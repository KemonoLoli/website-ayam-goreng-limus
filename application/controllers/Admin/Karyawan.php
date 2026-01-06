<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Karyawan_model', 'User_model']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $filters = [
            'status' => $this->input->get('status'),
            'jabatan' => $this->input->get('jabatan'),
            'search' => $this->input->get('search')
        ];

        $data = [
            'page_title' => 'Karyawan',
            'breadcrumbs' => ['Karyawan' => ''],
            'karyawan' => $this->Karyawan_model->get_all($filters),
            'filters' => $filters
        ];

        $this->render('karyawan/index', $data);
    }

    public function create()
    {
        $data = [
            'page_title' => 'Tambah Karyawan',
            'breadcrumbs' => ['Karyawan' => admin_url('karyawan'), 'Tambah' => '']
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

            if ($this->form_validation->run()) {
                $insert = [
                    'nip' => $this->Karyawan_model->generate_nip(),
                    'nama' => $this->input->post('nama', true),
                    'jabatan' => $this->input->post('jabatan', true),
                    'no_hp' => $this->input->post('no_hp', true),
                    'email' => $this->input->post('email', true),
                    'alamat' => $this->input->post('alamat', true),
                    'tgl_lahir' => $this->input->post('tgl_lahir', true) ?: null,
                    'tgl_bergabung' => $this->input->post('tgl_bergabung', true) ?: date('Y-m-d'),
                    'gaji_pokok' => $this->input->post('gaji_pokok', true) ?: 0,
                    'status' => $this->input->post('status', true) ?: 'aktif'
                ];

                // Create linked user account if requested
                if ($this->input->post('create_user') && $this->input->post('username')) {
                    $role_map = [
                        'Kasir' => 'kasir',
                        'Koki' => 'koki',
                        'Waiter' => 'waiter',
                        'Driver' => 'driver',
                        'Admin' => 'admin'
                    ];

                    $user_data = [
                        'username' => $this->input->post('username', true),
                        'password' => $this->input->post('password') ?: 'password123',
                        'nama_lengkap' => $insert['nama'],
                        'email' => $insert['email'],
                        'no_hp' => $insert['no_hp'],
                        'role' => $role_map[$insert['jabatan']] ?? 'kasir',
                        'is_active' => 1
                    ];

                    $user_id = $this->User_model->create($user_data);
                    if ($user_id) {
                        $insert['id_user'] = $user_id;
                    }
                }

                if ($this->Karyawan_model->create($insert)) {
                    $this->session->set_flashdata('success', 'Karyawan berhasil ditambahkan.');
                    redirect('admin/karyawan');
                }
            }
        }

        $this->render('karyawan/form', $data);
    }

    public function edit($id)
    {
        $karyawan = $this->Karyawan_model->get_by_id($id);
        if (!$karyawan)
            show_404();

        $data = [
            'page_title' => 'Edit Karyawan',
            'breadcrumbs' => ['Karyawan' => admin_url('karyawan'), 'Edit' => ''],
            'karyawan' => $karyawan
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

            if ($this->form_validation->run()) {
                $update = [
                    'nama' => $this->input->post('nama', true),
                    'jabatan' => $this->input->post('jabatan', true),
                    'no_hp' => $this->input->post('no_hp', true),
                    'email' => $this->input->post('email', true),
                    'alamat' => $this->input->post('alamat', true),
                    'tgl_lahir' => $this->input->post('tgl_lahir', true) ?: null,
                    'gaji_pokok' => $this->input->post('gaji_pokok', true) ?: 0,
                    'status' => $this->input->post('status', true)
                ];

                if ($this->Karyawan_model->update($id, $update)) {
                    $this->session->set_flashdata('success', 'Karyawan berhasil diperbarui.');
                    redirect('admin/karyawan');
                }
            }
        }

        $this->render('karyawan/form', $data);
    }

    public function delete($id)
    {
        $karyawan = $this->Karyawan_model->get_by_id($id);
        if (!$karyawan)
            show_404();

        if ($this->Karyawan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Karyawan berhasil dihapus.');
        }

        redirect('admin/karyawan');
    }
}
