<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 * Handles login, logout, and authentication
 */
class Auth extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login page
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect('admin/dashboard');
        }

        $data = [
            'page_title' => 'Login - Warung Limus Pojok'
        ];

        // Handle form submission
        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $username = $this->input->post('username', true);
                $password = $this->input->post('password');

                $user = $this->User_model->authenticate($username, $password);

                if ($user) {
                    // Check if user is staff (not member)
                    if ($user->role === 'member') {
                        $data['error'] = 'Akun member tidak dapat login ke panel admin.';
                    } else {
                        // Set session data
                        $this->session->set_userdata([
                            'user_id' => $user->id_user,
                            'username' => $user->username,
                            'role' => $user->role,
                            'nama_lengkap' => $user->nama_lengkap,
                            'logged_in' => true,
                            'login_time' => time()
                        ]);

                        $this->session->set_flashdata('success', 'Selamat datang, ' . $user->nama_lengkap . '!');

                        // Redirect based on role
                        $redirect = $this->_get_role_redirect($user->role);
                        redirect($redirect);
                    }
                } else {
                    $data['error'] = 'Username atau password salah.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        // Load login view (standalone, no layout)
        $this->load->view('admin/auth/login', $data);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    /**
     * Get redirect URL based on role
     * @param string $role User role
     * @return string
     */
    private function _get_role_redirect($role)
    {
        switch ($role) {
            case 'kasir':
                return 'admin/pos';
            case 'koki':
                return 'admin/dapur';
            case 'waiter':
                return 'admin/pesanan';
            case 'driver':
                return 'admin/delivery';
            default:
                return 'admin/dashboard';
        }
    }

    /**
     * Forgot password page
     */
    public function forgot_password()
    {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect('admin/dashboard');
        }

        $data = [
            'page_title' => 'Lupa Password - Warung Limus Pojok'
        ];

        // Handle form submission
        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email', true);

                // Check if email exists
                $user = $this->User_model->get_by_email($email);

                if ($user) {
                    // Check if user is staff (not member)
                    if ($user->role === 'member') {
                        $data['error'] = 'Akun member tidak dapat reset password melalui panel admin.';
                    } else {
                        // Generate reset token
                        $token = $this->User_model->create_reset_token($email);

                        if ($token) {
                            // In development mode, show the reset link directly
                            $reset_link = site_url('admin/auth/reset_password/' . $token);
                            $data['reset_link'] = $reset_link;

                            // In production, you would send email here
                            // $this->_send_reset_email($email, $reset_link);
                        } else {
                            $data['error'] = 'Gagal membuat token reset. Silakan coba lagi.';
                        }
                    }
                } else {
                    // Don't reveal if email exists for security
                    $data['error'] = 'Email tidak ditemukan dalam sistem.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->load->view('admin/auth/forgot_password', $data);
    }

    /**
     * Reset password page
     * @param string $token Reset token
     */
    public function reset_password($token = null)
    {
        if (!$token) {
            $this->session->set_flashdata('error', 'Token reset tidak valid.');
            redirect('admin/login');
        }

        // Verify token
        $reset_data = $this->User_model->verify_reset_token($token);

        if (!$reset_data) {
            $this->session->set_flashdata('error', 'Token reset tidak valid atau sudah kadaluarsa.');
            redirect('admin/login');
        }

        $data = [
            'page_title' => 'Reset Password - Warung Limus Pojok',
            'token' => $token
        ];

        $this->load->view('admin/auth/reset_password', $data);
    }

    /**
     * Process reset password form
     */
    public function do_reset_password()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('token', 'Token', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/auth/reset_password/' . $this->input->post('token'));
            return;
        }

        $token = $this->input->post('token', true);
        $password = $this->input->post('password');

        // Verify token again
        $reset_data = $this->User_model->verify_reset_token($token);

        if (!$reset_data) {
            $this->session->set_flashdata('error', 'Token reset tidak valid atau sudah kadaluarsa.');
            redirect('admin/login');
            return;
        }

        // Get user by email
        $user = $this->User_model->get_by_email($reset_data->email);

        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('admin/login');
            return;
        }

        // Update password
        $result = $this->User_model->change_password($user->id_user, $password);

        if ($result) {
            // Delete used token
            $this->User_model->delete_reset_token($token);

            $this->session->set_flashdata('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
            redirect('admin/login');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah password. Silakan coba lagi.');
            redirect('admin/auth/reset_password/' . $token);
        }
    }
}
