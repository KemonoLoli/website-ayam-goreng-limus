<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Absensi_model', 'Karyawan_model']);
    }

    /**
     * Main attendance page
     */
    public function index()
    {
        // Get karyawan for current user
        $my_karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);
        $my_attendance = null;

        if ($my_karyawan) {
            $my_attendance = $this->Absensi_model->get_today($my_karyawan->id_karyawan);
        }

        // Get all attendance for today (admin view)
        $filters = [
            'tanggal' => $this->input->get('tanggal') ?: date('Y-m-d'),
            'id_karyawan' => $this->input->get('karyawan')
        ];

        $data = [
            'page_title' => 'Absensi',
            'breadcrumbs' => ['Absensi' => ''],
            'my_karyawan' => $my_karyawan,
            'my_attendance' => $my_attendance,
            'attendances' => $this->Absensi_model->get_all($filters),
            'karyawan_list' => $this->Karyawan_model->get_active(),
            'filters' => $filters,
            'is_admin' => $this->is_role(['master', 'owner', 'admin'])
        ];

        $this->render('absensi/index', $data);
    }

    /**
     * Clock in
     */
    public function clock_in()
    {
        $karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);

        if (!$karyawan) {
            $this->session->set_flashdata('error', 'Data karyawan tidak ditemukan.');
            redirect('admin/absensi');
        }

        if ($this->Absensi_model->clock_in($karyawan->id_karyawan)) {
            $this->session->set_flashdata('success', 'Berhasil clock in pada ' . date('H:i'));
        } else {
            $this->session->set_flashdata('error', 'Anda sudah clock in hari ini.');
        }

        redirect('admin/absensi');
    }

    /**
     * Clock out
     */
    public function clock_out()
    {
        $karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);

        if (!$karyawan) {
            $this->session->set_flashdata('error', 'Data karyawan tidak ditemukan.');
            redirect('admin/absensi');
        }

        if ($this->Absensi_model->clock_out($karyawan->id_karyawan)) {
            $this->session->set_flashdata('success', 'Berhasil clock out pada ' . date('H:i'));
        } else {
            $this->session->set_flashdata('error', 'Gagal clock out.');
        }

        redirect('admin/absensi');
    }

    /**
     * Break out
     */
    public function break_out()
    {
        $karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);

        if ($karyawan && $this->Absensi_model->break_out($karyawan->id_karyawan)) {
            $this->session->set_flashdata('success', 'Mulai istirahat pada ' . date('H:i'));
        }

        redirect('admin/absensi');
    }

    /**
     * Break in
     */
    public function break_in()
    {
        $karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);

        if ($karyawan && $this->Absensi_model->break_in($karyawan->id_karyawan)) {
            $this->session->set_flashdata('success', 'Selesai istirahat pada ' . date('H:i'));
        }

        redirect('admin/absensi');
    }

    /**
     * Monthly summary
     */
    public function rekap()
    {
        if (!$this->is_role(['master', 'owner', 'admin'])) {
            redirect('admin/absensi');
        }

        $month = $this->input->get('bulan') ?: date('m');
        $year = $this->input->get('tahun') ?: date('Y');
        $karyawan_id = $this->input->get('karyawan');

        $karyawan_list = $this->Karyawan_model->get_active();
        $rekap = [];

        foreach ($karyawan_list as $k) {
            if ($karyawan_id && $k->id_karyawan != $karyawan_id)
                continue;

            $summary = $this->Absensi_model->get_summary($k->id_karyawan, $month, $year);
            $summary['karyawan'] = $k;
            $rekap[] = $summary;
        }

        $data = [
            'page_title' => 'Rekap Absensi',
            'breadcrumbs' => ['Absensi' => admin_url('absensi'), 'Rekap' => ''],
            'rekap' => $rekap,
            'karyawan_list' => $karyawan_list,
            'bulan' => $month,
            'tahun' => $year,
            'karyawan_selected' => $karyawan_id
        ];

        $this->render('absensi/rekap', $data);
    }
}
