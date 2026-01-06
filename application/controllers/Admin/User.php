<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Controller
 * User and RBAC management
 */
class User extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    /**
     * List users
     */
    public function index()
    {
        $filters = [
            'role' => $this->input->get('role'),
            'search' => $this->input->get('search'),
            'exclude_master' => $this->current_user->role !== 'master'
        ];

        $data = [
            'page_title' => 'Manajemen User',
            'breadcrumbs' => ['Manajemen User' => ''],
            'users' => $this->User_model->get_all($filters),
            'filters' => $filters
        ];

        $this->render('user/index', $data);
    }

    /**
     * Create user form
     */
    public function create()
    {
        $data = [
            'page_title' => 'Tambah User',
            'breadcrumbs' => [
                'Manajemen User' => admin_url('user'),
                'Tambah' => ''
            ]
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

            if ($this->form_validation->run()) {
                $insert = [
                    'username' => $this->input->post('username', true),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role', true),
                    'nama_lengkap' => $this->input->post('nama_lengkap', true),
                    'email' => $this->input->post('email', true),
                    'no_hp' => $this->input->post('no_hp', true),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];

                // Prevent non-master from creating master
                if ($insert['role'] === 'master' && $this->current_user->role !== 'master') {
                    $this->session->set_flashdata('error', 'Tidak dapat membuat akun master.');
                    redirect('admin/user/create');
                }

                if ($this->User_model->create($insert)) {
                    $this->session->set_flashdata('success', 'User berhasil ditambahkan.');
                    redirect('admin/user');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan user.');
                }
            }
        }

        $this->render('user/form', $data);
    }

    /**
     * Edit user form
     */
    public function edit($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        // Prevent editing master by non-master
        if ($user->role === 'master' && $this->current_user->role !== 'master') {
            $this->session->set_flashdata('error', 'Tidak dapat mengedit akun master.');
            redirect('admin/user');
        }

        $data = [
            'page_title' => 'Edit User',
            'breadcrumbs' => [
                'Manajemen User' => admin_url('user'),
                'Edit' => ''
            ],
            'user' => $user
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
            $this->form_validation->set_rules('role', 'Role', 'required');
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

            // Check username uniqueness excluding current user
            if ($this->input->post('username') !== $user->username) {
                if ($this->User_model->username_exists($this->input->post('username'), $id)) {
                    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
                }
            }

            if ($this->form_validation->run()) {
                $update = [
                    'username' => $this->input->post('username', true),
                    'role' => $this->input->post('role', true),
                    'nama_lengkap' => $this->input->post('nama_lengkap', true),
                    'email' => $this->input->post('email', true),
                    'no_hp' => $this->input->post('no_hp', true),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];

                // Only update password if provided
                if ($this->input->post('password')) {
                    $update['password'] = $this->input->post('password');
                }

                if ($this->User_model->update($id, $update)) {
                    $this->session->set_flashdata('success', 'User berhasil diperbarui.');
                    redirect('admin/user');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui user.');
                }
            }
        }

        $this->render('user/form', $data);
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        // Prevent deleting self
        if ($user->id_user == $this->current_user->id_user) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri.');
            redirect('admin/user');
        }

        // Prevent deleting master
        if ($user->role === 'master') {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun master.');
            redirect('admin/user');
        }

        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user.');
        }

        redirect('admin/user');
    }

    /**
     * Toggle user status
     */
    public function toggle($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        if ($user->id_user == $this->current_user->id_user) {
            $this->session->set_flashdata('error', 'Tidak dapat menonaktifkan akun sendiri.');
            redirect('admin/user');
        }

        $this->User_model->update($id, ['is_active' => $user->is_active ? 0 : 1]);
        $this->session->set_flashdata('success', 'Status user berhasil diubah.');
        redirect('admin/user');
    }
}
