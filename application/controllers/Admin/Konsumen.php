<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Konsumen Controller
 * Customer and Member management
 */
class Konsumen extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner', 'admin', 'kasir'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Konsumen_model', 'User_model']);
    }

    /**
     * List customers
     */
    public function index()
    {
        $filters = [];

        if ($this->input->get('tipe')) {
            $filters['tipe'] = $this->input->get('tipe');
        }
        if ($this->input->get('search')) {
            $filters['search'] = $this->input->get('search');
        }

        $data = [
            'page_title' => 'Pelanggan',
            'customers' => $this->Konsumen_model->get_all($filters),
            'filters' => $filters
        ];

        $this->render('konsumen/index', $data);
    }

    /**
     * Create customer form
     */
    public function create()
    {
        if ($this->input->post()) {
            $tipe = $this->input->post('tipe') ?: 'walk-in';
            $password = $this->input->post('password');

            $konsumen_data = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'tipe' => $tipe
            ];

            // If member and password provided, create member with user account
            if (($tipe === 'member' || $tipe === 'vip') && !empty($password)) {
                // Validate email or phone for login
                if (empty($konsumen_data['email']) && empty($konsumen_data['no_hp'])) {
                    $this->session->set_flashdata('error', 'Member harus memiliki Email atau No HP untuk login.');
                    $data = ['page_title' => 'Tambah Pelanggan'];
                    $this->render('konsumen/form', $data);
                    return;
                }

                $result = $this->Konsumen_model->create_member($konsumen_data, $password);
                if ($result) {
                    $this->session->set_flashdata('success', 'Member berhasil ditambahkan dengan akun login.');
                    redirect('admin/konsumen');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan member. Email/No HP mungkin sudah terdaftar.');
                }
            } else {
                // Create regular customer without login
                if ($this->Konsumen_model->create($konsumen_data)) {
                    $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan.');
                    redirect('admin/konsumen');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan.');
                }
            }
        }

        $data = [
            'page_title' => 'Tambah Pelanggan'
        ];

        $this->render('konsumen/form', $data);
    }

    /**
     * Edit customer
     */
    public function edit($id)
    {
        $customer = $this->Konsumen_model->get_with_user($id);

        if (!$customer) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan.');
            redirect('admin/konsumen');
        }

        if ($this->input->post()) {
            $tipe = $this->input->post('tipe');
            $password = $this->input->post('password');

            $konsumen_data = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'tipe' => $tipe
            ];

            // If upgrading to member and password provided
            if (($tipe === 'member' || $tipe === 'vip') && !$customer->id_user && !empty($password)) {
                // Validate email or phone for login
                if (empty($konsumen_data['email']) && empty($konsumen_data['no_hp'])) {
                    $this->session->set_flashdata('error', 'Member harus memiliki Email atau No HP untuk login.');
                    $data = ['page_title' => 'Edit Pelanggan', 'customer' => $customer];
                    $this->render('konsumen/form', $data);
                    return;
                }

                // Create user account and link
                $username = $konsumen_data['email'] ?: $konsumen_data['no_hp'];
                $user_data = [
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'nama_lengkap' => $konsumen_data['nama'],
                    'email' => $konsumen_data['email'],
                    'no_hp' => $konsumen_data['no_hp'],
                    'role' => 'member',
                    'is_active' => 1
                ];

                $id_user = $this->User_model->create($user_data);
                if ($id_user) {
                    $konsumen_data['id_user'] = $id_user;
                }
            }

            // Update member (with password change if provided)
            if ($customer->id_user) {
                $result = $this->Konsumen_model->update_member($id, $konsumen_data, $password ?: null);
            } else {
                $result = $this->Konsumen_model->update($id, $konsumen_data);
            }

            if ($result) {
                $this->session->set_flashdata('success', 'Pelanggan berhasil diupdate.');
                redirect('admin/konsumen');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate pelanggan.');
            }
        }

        $data = [
            'page_title' => 'Edit Pelanggan',
            'customer' => $customer
        ];

        $this->render('konsumen/form', $data);
    }

    /**
     * Delete customer
     */
    public function delete($id)
    {
        if ($this->Konsumen_model->delete($id)) {
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pelanggan.');
        }
        redirect('admin/konsumen');
    }

    /**
     * Manage poin for a member
     */
    public function poin($id)
    {
        $customer = $this->Konsumen_model->get_with_user($id);

        if (!$customer) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan.');
            redirect('admin/konsumen');
        }

        if ($this->input->post()) {
            $poin = (int) $this->input->post('poin');
            $keterangan = $this->input->post('keterangan');
            $tipe = $poin >= 0 ? 'bonus' : 'adjust';

            if ($poin != 0) {
                $result = $this->Konsumen_model->add_poin(
                    $id,
                    $poin,
                    $tipe,
                    null,
                    'manual',
                    $keterangan ?: ($poin > 0 ? 'Penambahan poin manual' : 'Pengurangan poin manual'),
                    $this->current_user->id_user
                );

                if ($result) {
                    $this->session->set_flashdata('success', 'Poin berhasil diupdate.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate poin.');
                }
            }
            redirect('admin/konsumen/poin/' . $id);
        }

        // Get poin history
        $poin_history = $this->Konsumen_model->get_poin_history($id);

        $data = [
            'page_title' => 'Kelola Poin - ' . $customer->nama,
            'customer' => $customer,
            'poin_history' => $poin_history
        ];

        $this->render('konsumen/poin', $data);
    }

    /**
     * Reset member password
     */
    public function reset_password($id)
    {
        $customer = $this->Konsumen_model->get_with_user($id);

        if (!$customer || !$customer->id_user) {
            $this->session->set_flashdata('error', 'Member tidak ditemukan atau tidak memiliki akun.');
            redirect('admin/konsumen');
        }

        // Generate new password
        $new_password = 'member' . rand(1000, 9999);
        $this->User_model->change_password($customer->id_user, $new_password);

        $this->session->set_flashdata('success', 'Password berhasil direset. Password baru: <strong>' . $new_password . '</strong>');
        redirect('admin/konsumen/edit/' . $id);
    }
}
