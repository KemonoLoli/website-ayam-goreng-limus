<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggajian extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Penggajian_model', 'Karyawan_model']);
    }

    public function index()
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $filters = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $this->input->get('status'),
            'id_karyawan' => $this->input->get('karyawan')
        ];

        $data = [
            'page_title' => 'Penggajian',
            'breadcrumbs' => ['Penggajian' => ''],
            'gaji_list' => $this->Penggajian_model->get_all($filters),
            'summary' => $this->Penggajian_model->get_summary($bulan, $tahun),
            'karyawan_list' => $this->Karyawan_model->get_active(),
            'filters' => $filters,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        $this->render('penggajian/index', $data);
    }

    public function generate()
    {
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        $id_karyawan = $this->input->post('id_karyawan');

        if ($id_karyawan) {
            // Generate for single employee
            $result = $this->Penggajian_model->generate($id_karyawan, $bulan, $tahun);
            if ($result['success']) {
                $this->session->set_flashdata('success', 'Penggajian berhasil di-generate.');
            } else {
                $this->session->set_flashdata('error', $result['message']);
            }
        } else {
            // Bulk generate for all active employees
            $result = $this->Penggajian_model->generate_bulk($bulan, $tahun);
            $this->session->set_flashdata(
                'success',
                "Generate selesai: {$result['success']} berhasil, {$result['failed']} gagal/sudah ada."
            );
        }

        redirect('admin/penggajian?bulan=' . $bulan . '&tahun=' . $tahun);
    }

    public function detail($id)
    {
        $gaji = $this->Penggajian_model->get_by_id($id);
        if (!$gaji)
            show_404();

        $data = [
            'page_title' => 'Slip Gaji',
            'breadcrumbs' => ['Penggajian' => admin_url('penggajian'), 'Detail' => ''],
            'gaji' => $gaji
        ];

        $this->render('penggajian/detail', $data);
    }

    public function edit($id)
    {
        $gaji = $this->Penggajian_model->get_by_id($id);
        if (!$gaji || $gaji->status !== 'draft') {
            $this->session->set_flashdata('error', 'Hanya slip draft yang bisa diubah.');
            redirect('admin/penggajian');
        }

        $data = [
            'page_title' => 'Edit Penggajian',
            'breadcrumbs' => ['Penggajian' => admin_url('penggajian'), 'Edit' => ''],
            'gaji' => $gaji
        ];

        if ($this->input->method() === 'post') {
            $update = [
                'tunjangan_hadir' => $this->input->post('tunjangan_hadir'),
                'tunjangan_transport' => $this->input->post('tunjangan_transport'),
                'tunjangan_makan' => $this->input->post('tunjangan_makan'),
                'tunjangan_lainnya' => $this->input->post('tunjangan_lainnya'),
                'potongan_absen' => $this->input->post('potongan_absen'),
                'potongan_terlambat' => $this->input->post('potongan_terlambat'),
                'potongan_lainnya' => $this->input->post('potongan_lainnya'),
            ];

            // Recalculate totals
            $update['total_tunjangan'] = $update['tunjangan_hadir'] + $update['tunjangan_transport'] +
                $update['tunjangan_makan'] + $update['tunjangan_lainnya'];
            $update['total_potongan'] = $update['potongan_absen'] + $update['potongan_terlambat'] +
                $update['potongan_lainnya'];
            $update['gaji_bersih'] = $gaji->gaji_pokok + $update['total_tunjangan'] - $update['total_potongan'];

            if ($this->Penggajian_model->update($id, $update)) {
                $this->session->set_flashdata('success', 'Penggajian diperbarui.');
                redirect('admin/penggajian/detail/' . $id);
            }
        }

        $this->render('penggajian/edit', $data);
    }

    public function approve($id)
    {
        if ($this->Penggajian_model->approve($id)) {
            $this->session->set_flashdata('success', 'Penggajian disetujui.');
        }
        redirect('admin/penggajian/detail/' . $id);
    }

    public function pay($id)
    {
        if ($this->Penggajian_model->pay($id)) {
            $this->session->set_flashdata('success', 'Penggajian ditandai sudah dibayar.');
        }
        redirect('admin/penggajian/detail/' . $id);
    }

    public function delete($id)
    {
        if ($this->Penggajian_model->delete($id)) {
            $this->session->set_flashdata('success', 'Penggajian dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Hanya slip draft yang bisa dihapus.');
        }
        redirect('admin/penggajian');
    }

    public function print_slip($id)
    {
        $gaji = $this->Penggajian_model->get_by_id($id);
        if (!$gaji)
            show_404();

        $data = ['gaji' => $gaji];
        $this->load->view('admin/penggajian/slip', $data);
    }
}
