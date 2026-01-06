<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Auth Controller
 * Login and logout for members
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->database();
        $this->load->model(['User_model', 'Konsumen_model']);
    }

    /**
     * Member Login Page
     */
    public function login()
    {
        // Already logged in?
        if ($this->session->userdata('member_id')) {
            redirect('member/dashboard');
        }

        $data = [
            'page_title' => 'Login Member'
        ];

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('username', 'Email/No HP', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $username = $this->input->post('username', true);
                $password = $this->input->post('password', true);

                // Authenticate
                $user = $this->User_model->authenticate($username, $password);

                if ($user && $user->role === 'member') {
                    // Get konsumen data
                    $konsumen = $this->Konsumen_model->get_by_user_id($user->id_user);

                    if ($konsumen) {
                        // Set session
                        $this->session->set_userdata([
                            'member_id' => $user->id_user,
                            'member_logged_in' => true,
                            'member_name' => $user->nama_lengkap,
                            'konsumen_id' => $konsumen->id_konsumen
                        ]);

                        // Update last login
                        $this->User_model->update($user->id_user, ['last_login' => date('Y-m-d H:i:s')]);

                        // Check if there's a redirect URL
                        $redirect = $this->session->userdata('member_redirect');
                        if ($redirect) {
                            $this->session->unset_userdata('member_redirect');
                            redirect($redirect);
                        }

                        $this->session->set_flashdata('success', 'Selamat datang, ' . $user->nama_lengkap . '!');
                        redirect('member/dashboard');
                    } else {
                        $data['error'] = 'Data member tidak ditemukan. Hubungi admin.';
                    }
                } else if ($user) {
                    $data['error'] = 'Akun ini bukan akun member.';
                } else {
                    $data['error'] = 'Email/No HP atau password salah.';
                }
            }
        }

        $this->load->view('member/login', $data);
    }

    /**
     * Member Logout
     */
    public function logout()
    {
        $this->session->unset_userdata(['member_id', 'member_logged_in', 'member_name', 'konsumen_id']);
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('member/login');
    }
}
