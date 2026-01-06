<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'page_title' => 'Kategori Menu',
            'breadcrumbs' => ['Kategori' => ''],
            'categories' => $this->Kategori_model->get_all()
        ];

        $this->render('kategori/index', $data);
    }

    public function create()
    {
        $data = [
            'page_title' => 'Tambah Kategori',
            'breadcrumbs' => ['Kategori' => admin_url('kategori'), 'Tambah' => '']
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');

            if ($this->form_validation->run()) {
                $insert = [
                    'nama_kategori' => $this->input->post('nama_kategori', true),
                    'deskripsi' => $this->input->post('deskripsi', true),
                    'urutan' => $this->input->post('urutan', true) ?: 0,
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];

                if ($this->Kategori_model->create($insert)) {
                    $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan.');
                    redirect('admin/kategori');
                }
            }
        }

        $this->render('kategori/form', $data);
    }

    public function edit($id)
    {
        $kategori = $this->Kategori_model->get_by_id($id);
        if (!$kategori)
            show_404();

        $data = [
            'page_title' => 'Edit Kategori',
            'breadcrumbs' => ['Kategori' => admin_url('kategori'), 'Edit' => ''],
            'kategori' => $kategori
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');

            if ($this->form_validation->run()) {
                $update = [
                    'nama_kategori' => $this->input->post('nama_kategori', true),
                    'deskripsi' => $this->input->post('deskripsi', true),
                    'urutan' => $this->input->post('urutan', true) ?: 0,
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];

                if ($this->Kategori_model->update($id, $update)) {
                    $this->session->set_flashdata('success', 'Kategori berhasil diperbarui.');
                    redirect('admin/kategori');
                }
            }
        }

        $this->render('kategori/form', $data);
    }

    public function delete($id)
    {
        if ($this->Kategori_model->delete($id)) {
            $this->session->set_flashdata('success', 'Kategori berhasil dihapus.');
        }
        redirect('admin/kategori');
    }
}
