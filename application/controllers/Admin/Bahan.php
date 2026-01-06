<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bahan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $filters = [
            'search' => $this->input->get('search'),
            'kategori' => $this->input->get('kategori')
        ];

        $data = [
            'page_title' => 'Bahan / Stok',
            'breadcrumbs' => ['Bahan' => ''],
            'bahan' => $this->Bahan_model->get_all($filters),
            'categories' => $this->Bahan_model->get_categories(),
            'filters' => $filters,
            'low_stock_count' => count($this->Bahan_model->get_low_stock())
        ];

        $this->render('bahan/index', $data);
    }

    public function create()
    {
        $data = [
            'page_title' => 'Tambah Bahan',
            'breadcrumbs' => ['Bahan' => admin_url('bahan'), 'Tambah' => '']
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');

            if ($this->form_validation->run()) {
                $insert = [
                    'kode_bahan' => 'BH' . date('YmdHis'),
                    'nama_bahan' => $this->input->post('nama_bahan', true),
                    'kategori_bahan' => $this->input->post('kategori_bahan', true),
                    'satuan' => $this->input->post('satuan', true),
                    'stok' => $this->input->post('stok', true) ?: 0,
                    'stok_minimum' => $this->input->post('stok_minimum', true) ?: 0,
                    'harga_per_satuan' => $this->input->post('harga_per_satuan', true) ?: 0
                ];

                if ($this->Bahan_model->create($insert)) {
                    $this->session->set_flashdata('success', 'Bahan berhasil ditambahkan.');
                    redirect('admin/bahan');
                }
            }
        }

        $this->render('bahan/form', $data);
    }

    public function edit($id)
    {
        $bahan = $this->Bahan_model->get_by_id($id);
        if (!$bahan)
            show_404();

        $data = [
            'page_title' => 'Edit Bahan',
            'breadcrumbs' => ['Bahan' => admin_url('bahan'), 'Edit' => ''],
            'bahan' => $bahan
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required');

            if ($this->form_validation->run()) {
                $update = [
                    'nama_bahan' => $this->input->post('nama_bahan', true),
                    'kategori_bahan' => $this->input->post('kategori_bahan', true),
                    'satuan' => $this->input->post('satuan', true),
                    'stok_minimum' => $this->input->post('stok_minimum', true) ?: 0,
                    'harga_per_satuan' => $this->input->post('harga_per_satuan', true) ?: 0
                ];

                if ($this->Bahan_model->update($id, $update)) {
                    $this->session->set_flashdata('success', 'Bahan berhasil diperbarui.');
                    redirect('admin/bahan');
                }
            }
        }

        $this->render('bahan/form', $data);
    }

    public function delete($id)
    {
        if ($this->Bahan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Bahan berhasil dihapus.');
        }
        redirect('admin/bahan');
    }

    // Quick stock adjustment
    public function adjust($id)
    {
        $bahan = $this->Bahan_model->get_by_id($id);
        if (!$bahan)
            show_404();

        if ($this->input->method() === 'post') {
            $type = $this->input->post('type');
            $qty = (float) $this->input->post('qty');

            if ($type === 'add') {
                $this->Bahan_model->add_stock($id, $qty);
                $this->session->set_flashdata('success', 'Stok berhasil ditambah.');
            } else {
                $this->Bahan_model->reduce_stock($id, $qty);
                $this->session->set_flashdata('success', 'Stok berhasil dikurangi.');
            }
        }

        redirect('admin/bahan');
    }
}
