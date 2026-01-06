<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin', 'kasir'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
    }

    public function index()
    {
        $filters = [
            'status' => $this->input->get('status'),
            'tipe' => $this->input->get('tipe'),
            'date_from' => $this->input->get('from'),
            'date_to' => $this->input->get('to'),
            'search' => $this->input->get('search')
        ];

        $data = [
            'page_title' => 'Riwayat Transaksi',
            'breadcrumbs' => ['Transaksi' => ''],
            'transaksi' => $this->Transaksi_model->get_all($filters),
            'filters' => $filters
        ];

        $this->render('transaksi/index', $data);
    }

    public function detail($id)
    {
        $transaksi = $this->Transaksi_model->get_with_details($id);
        if (!$transaksi)
            show_404();

        $data = [
            'page_title' => 'Detail Transaksi',
            'breadcrumbs' => ['Transaksi' => admin_url('transaksi'), $transaksi->kode_transaksi => ''],
            'transaksi' => $transaksi
        ];

        $this->render('transaksi/detail', $data);
    }

    public function update_status($id)
    {
        $status = $this->input->post('status', true);
        $valid_statuses = ['pending', 'dikonfirmasi', 'diproses', 'siap', 'dikirim', 'selesai', 'dibatalkan'];

        if (!in_array($status, $valid_statuses)) {
            $this->session->set_flashdata('error', 'Status tidak valid.');
            redirect('admin/transaksi/detail/' . $id);
        }

        if ($this->Transaksi_model->update_status($id, $status)) {
            $this->session->set_flashdata('success', 'Status transaksi berhasil diperbarui.');
        }

        redirect('admin/transaksi/detail/' . $id);
    }
}
