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

                    // If no konsumen record exists, create one automatically
                    if (!$konsumen) {
                        // Check if there's a konsumen with same email/phone that can be linked
                        $existing = null;
                        if ($user->email) {
                            $existing = $this->Konsumen_model->get_by_email($user->email);
                        }
                        if (!$existing && $user->no_hp) {
                            $existing = $this->Konsumen_model->get_by_hp($user->no_hp);
                        }

                        if ($existing && !$existing->id_user) {
                            // Link existing konsumen to this user
                            $this->Konsumen_model->update($existing->id_konsumen, [
                                'id_user' => $user->id_user,
                                'tipe' => 'member'
                            ]);
                            $konsumen = $this->Konsumen_model->get_by_id($existing->id_konsumen);
                        } else {
                            // Create new konsumen record
                            $konsumen_data = [
                                'id_user' => $user->id_user,
                                'nama' => $user->nama_lengkap,
                                'no_hp' => $user->no_hp,
                                'email' => $user->email,
                                'tipe' => 'member',
                                'poin' => 0,
                                'total_transaksi' => 0
                            ];
                            $id_konsumen = $this->Konsumen_model->create($konsumen_data);
                            $konsumen = $this->Konsumen_model->get_by_id($id_konsumen);
                        }
                    }

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
