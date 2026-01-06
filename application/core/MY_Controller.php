<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin_Controller
 * Base controller for all admin modules with authentication and RBAC
 */
class Admin_Controller extends CI_Controller
{

    protected $current_user = null;
    protected $allowed_roles = [];

    // Role hierarchy - higher index = more privileges
    protected $role_levels = [
        'member' => 0,
        'driver' => 1,
        'waiter' => 2,
        'koki' => 3,
        'kasir' => 4,
        'admin' => 5,
        'owner' => 6,
        'master' => 7
    ];

    public function __construct()
    {
        parent::__construct();

        // Load required libraries and helpers
        $this->load->library('session');
        $this->load->helper(['url', 'form', 'admin_helper']);
        $this->load->database();
        $this->load->model('User_model');

        // Check authentication
        $this->_check_auth();

        // Check role access
        $this->_check_role();

        // Load current user data for views
        if ($this->current_user) {
            $this->load->vars(['current_user' => $this->current_user]);
        }
    }

    /**
     * Check if user is authenticated
     */
    protected function _check_auth()
    {
        $user_id = $this->session->userdata('user_id');

        if (!$user_id) {
            // Not logged in, redirect to login
            if ($this->router->fetch_class() !== 'auth') {
                $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
                redirect('admin/login');
            }
            return;
        }

        // Get user data
        $this->current_user = $this->User_model->get_by_id($user_id);

        if (!$this->current_user || !$this->current_user->is_active) {
            // User not found or inactive
            $this->session->sess_destroy();
            $this->session->set_flashdata('error', 'Akun tidak valid atau sudah dinonaktifkan.');
            redirect('admin/login');
        }

        // Update last activity
        $this->session->set_userdata('last_activity', time());
    }

    /**
     * Check if user has required role
     */
    protected function _check_role()
    {
        // Skip for auth controller
        if ($this->router->fetch_class() === 'auth') {
            return;
        }

        // If no specific roles set, allow all authenticated users
        if (empty($this->allowed_roles)) {
            return;
        }

        // Master role has access to everything
        if ($this->current_user && $this->current_user->role === 'master') {
            return;
        }

        // Check if user's role is in allowed roles
        if ($this->current_user && !in_array($this->current_user->role, $this->allowed_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('admin/dashboard');
        }
    }

    /**
     * Check if current user has minimum role level
     * @param string $min_role Minimum role required
     * @return bool
     */
    protected function has_role($min_role)
    {
        if (!$this->current_user) {
            return false;
        }

        // Master always has access
        if ($this->current_user->role === 'master') {
            return true;
        }

        $user_level = isset($this->role_levels[$this->current_user->role])
            ? $this->role_levels[$this->current_user->role]
            : 0;
        $required_level = isset($this->role_levels[$min_role])
            ? $this->role_levels[$min_role]
            : 0;

        return $user_level >= $required_level;
    }

    /**
     * Check if current user has specific role
     * @param string|array $roles Role or array of roles
     * @return bool
     */
    protected function is_role($roles)
    {
        if (!$this->current_user) {
            return false;
        }

        // Master always has access
        if ($this->current_user->role === 'master') {
            return true;
        }

        if (is_array($roles)) {
            return in_array($this->current_user->role, $roles);
        }

        return $this->current_user->role === $roles;
    }

    /**
     * Render admin view with layout
     * @param string $view View path
     * @param array $data View data
     * @param string $layout Layout name (default: main)
     */
    protected function render($view, $data = [], $layout = 'main')
    {
        // Default page data
        $data['page_title'] = isset($data['page_title']) ? $data['page_title'] : 'Dashboard';
        $data['breadcrumbs'] = isset($data['breadcrumbs']) ? $data['breadcrumbs'] : [];

        // Flash messages
        $data['flash_success'] = $this->session->flashdata('success');
        $data['flash_error'] = $this->session->flashdata('error');
        $data['flash_warning'] = $this->session->flashdata('warning');
        $data['flash_info'] = $this->session->flashdata('info');

        // Render content
        $data['content'] = $this->load->view('admin/' . $view, $data, true);

        // Load layout
        $this->load->view('admin/_layouts/' . $layout, $data);
    }

    /**
     * Return JSON response
     * @param mixed $data Response data
     * @param int $status HTTP status code
     */
    protected function json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * Generate unique transaction code
     * @param string $prefix Prefix for the code
     * @return string
     */
    protected function generate_code($prefix = 'TRX')
    {
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
        return $prefix . $date . $random;
    }
}

/**
 * Public_Controller
 * Base controller for public/guest pages
 */
class Public_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }
}

/**
 * Member_Controller
 * Base controller for member/customer area
 */
class Member_Controller extends CI_Controller
{
    protected $current_member = null;
    protected $current_konsumen = null;

    public function __construct()
    {
        parent::__construct();

        // Load required libraries and helpers
        $this->load->library('session');
        $this->load->helper(['url', 'form', 'admin_helper']);
        $this->load->database();
        $this->load->model(['User_model', 'Konsumen_model']);

        // Check member authentication
        $this->_check_member_auth();

        // Load current member data for views
        if ($this->current_member) {
            $this->load->vars([
                'current_member' => $this->current_member,
                'current_konsumen' => $this->current_konsumen
            ]);
        }
    }

    /**
     * Check if member is authenticated
     */
    protected function _check_member_auth()
    {
        $member_id = $this->session->userdata('member_id');

        if (!$member_id) {
            // Not logged in, redirect to login
            $class = $this->router->fetch_class();
            $method = $this->router->fetch_method();

            // Allow access to auth controller
            if ($class !== 'auth') {
                $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
                redirect('member/login');
            }
            return;
        }

        // Get user data
        $this->current_member = $this->User_model->get_by_id($member_id);

        if (!$this->current_member || !$this->current_member->is_active || $this->current_member->role !== 'member') {
            // User not found, inactive, or not a member
            $this->session->unset_userdata(['member_id', 'member_logged_in']);
            $this->session->set_flashdata('error', 'Akun tidak valid atau sudah dinonaktifkan.');
            redirect('member/login');
        }

        // Get konsumen data
        $this->current_konsumen = $this->Konsumen_model->get_by_user_id($member_id);

        // Update last activity
        $this->session->set_userdata('member_last_activity', time());
    }

    /**
     * Render member view with layout
     * @param string $view View path
     * @param array $data View data
     */
    protected function render($view, $data = [])
    {
        // Default page data
        $data['page_title'] = isset($data['page_title']) ? $data['page_title'] : 'Member Area';

        // Flash messages
        $data['flash_success'] = $this->session->flashdata('success');
        $data['flash_error'] = $this->session->flashdata('error');
        $data['flash_warning'] = $this->session->flashdata('warning');
        $data['flash_info'] = $this->session->flashdata('info');

        // Render content
        $data['content'] = $this->load->view('member/' . $view, $data, true);

        // Load layout
        $this->load->view('member/_layout', $data);
    }

    /**
     * Return JSON response
     */
    protected function json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}

