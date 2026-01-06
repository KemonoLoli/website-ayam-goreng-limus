<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $filters = ['search' => $this->input->get('search')];

        $data = [
            'page_title' => 'Supplier',
            'breadcrumbs' => ['Supplier' => ''],
            'suppliers' => $this->Supplier_model->get_all($filters),
            'filters' => $filters
        ];

        $this->render('supplier/index', $data);
    }

    public function create()
    {
        $data = [
            'page_title' => 'Tambah Supplier',
            'breadcrumbs' => ['Supplier' => admin_url('supplier'), 'Tambah' => '']
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');

            if ($this->form_validation->run()) {
                $insert = [
                    'nama_supplier' => $this->input->post('nama_supplier', true),
                    'kontak' => $this->input->post('kontak', true),
                    'email' => $this->input->post('email', true),
                    'alamat' => $this->input->post('alamat', true),
                    'keterangan' => $this->input->post('keterangan', true),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];

                if ($this->Supplier_model->create($insert)) {
                    $this->session->set_flashdata('success', 'Supplier berhasil ditambahkan.');
                    redirect('admin/supplier');
                }
            }
        }

        $this->render('supplier/form', $data);
    }

    public function edit($id)
    {
        $supplier = $this->Supplier_model->get_by_id($id);
        if (!$supplier)
            show_404();

        $data = [
            'page_title' => 'Edit Supplier',
            'breadcrumbs' => ['Supplier' => admin_url('supplier'), 'Edit' => ''],
            'supplier' => $supplier
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');

            if ($this->form_validation->run()) {
                $update = [
                    'nama_supplier' => $this->input->post('nama_supplier', true),
                    'kontak' => $this->input->post('kontak', true),
                    'email' => $this->input->post('email', true),
                    'alamat' => $this->input->post('alamat', true),
                    'keterangan' => $this->input->post('keterangan', true),
                    'is_active' => $this->input->post('is_active') ? 1 : 0
                ];

                if ($this->Supplier_model->update($id, $update)) {
                    $this->session->set_flashdata('success', 'Supplier berhasil diperbarui.');
                    redirect('admin/supplier');
                }
            }
        }

        $this->render('supplier/form', $data);
    }

    public function delete($id)
    {
        if ($this->Supplier_model->delete($id)) {
            $this->session->set_flashdata('success', 'Supplier berhasil dihapus.');
        }
        redirect('admin/supplier');
    }
}
