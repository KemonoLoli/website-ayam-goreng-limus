<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Transaksi_model', 'Bahan_model', 'Absensi_model', 'Karyawan_model', 'Menu_model']);
    }

    public function index()
    {
        $data = [
            'page_title' => 'Laporan',
            'breadcrumbs' => ['Laporan' => '']
        ];
        $this->render('laporan/index', $data);
    }

    /**
     * Sales Report
     */
    public function penjualan()
    {
        $date_from = $this->input->get('from') ?: date('Y-m-01');
        $date_to = $this->input->get('to') ?: date('Y-m-d');

        // Get transactions
        $this->db->select('
            DATE(tgl_transaksi) as tanggal,
            COUNT(*) as total_transaksi,
            SUM(subtotal) as total_subtotal,
            SUM(diskon_nominal) as total_diskon,
            SUM(total) as total_penjualan
        ');
        $this->db->from('transaksi');
        $this->db->where('status', 'selesai');
        $this->db->where('DATE(tgl_transaksi) >=', $date_from);
        $this->db->where('DATE(tgl_transaksi) <=', $date_to);
        $this->db->group_by('DATE(tgl_transaksi)');
        $this->db->order_by('tanggal', 'ASC');

        $daily = $this->db->get()->result();

        // Summary
        $this->db->select('
            COUNT(*) as total_transaksi,
            SUM(total) as total_penjualan,
            AVG(total) as rata_rata_transaksi
        ');
        $this->db->from('transaksi');
        $this->db->where('status', 'selesai');
        $this->db->where('DATE(tgl_transaksi) >=', $date_from);
        $this->db->where('DATE(tgl_transaksi) <=', $date_to);

        $summary = $this->db->get()->row();

        // Top products
        $this->db->select('td.nama_menu, SUM(td.qty) as total_qty, SUM(td.total_harga) as total_sales');
        $this->db->from('transaksi_detail td');
        $this->db->join('transaksi t', 't.id_transaksi = td.id_transaksi');
        $this->db->where('t.status', 'selesai');
        $this->db->where('DATE(t.tgl_transaksi) >=', $date_from);
        $this->db->where('DATE(t.tgl_transaksi) <=', $date_to);
        $this->db->group_by('td.nama_menu');
        $this->db->order_by('total_qty', 'DESC');
        $this->db->limit(10);

        $top_products = $this->db->get()->result();

        $data = [
            'page_title' => 'Laporan Penjualan',
            'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Penjualan' => ''],
            'date_from' => $date_from,
            'date_to' => $date_to,
            'daily' => $daily,
            'summary' => $summary,
            'top_products' => $top_products
        ];

        $this->render('laporan/penjualan', $data);
    }

    /**
     * Stock Report
     */
    public function stok()
    {
        $data = [
            'page_title' => 'Laporan Stok',
            'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Stok' => ''],
            'bahan' => $this->Bahan_model->get_all(),
            'low_stock' => $this->Bahan_model->get_low_stock()
        ];

        $this->render('laporan/stok', $data);
    }

    /**
     * Attendance Report
     */
    public function absensi()
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $karyawan_list = $this->Karyawan_model->get_active();
        $rekap = [];

        foreach ($karyawan_list as $k) {
            $summary = $this->Absensi_model->get_summary($k->id_karyawan, $bulan, $tahun);
            $summary['karyawan'] = $k;
            $rekap[] = $summary;
        }

        $data = [
            'page_title' => 'Laporan Absensi',
            'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Absensi' => ''],
            'rekap' => $rekap,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        $this->render('laporan/absensi', $data);
    }

    /**
     * Payroll Report
     */
    public function penggajian()
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        $this->load->model('Penggajian_model');

        $data = [
            'page_title' => 'Laporan Penggajian',
            'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Penggajian' => ''],
            'gaji_list' => $this->Penggajian_model->get_all(['bulan' => $bulan, 'tahun' => $tahun]),
            'summary' => $this->Penggajian_model->get_summary($bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        $this->render('laporan/penggajian', $data);
    }

    /**
     * Purchase Report
     */
    public function pembelian()
    {
        // Check if table exists
        if (!$this->db->table_exists('pembelian')) {
            $data = [
                'page_title' => 'Laporan Pembelian',
                'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Pembelian' => ''],
                'date_from' => date('Y-m-01'),
                'date_to' => date('Y-m-d'),
                'purchases' => [],
                'summary' => (object) ['total_pembelian' => 0, 'total_nilai' => 0],
                'table_missing' => true
            ];
            $this->render('laporan/pembelian', $data);
            return;
        }

        $date_from = $this->input->get('from') ?: date('Y-m-01');
        $date_to = $this->input->get('to') ?: date('Y-m-d');

        // Get purchases
        $this->db->select('pembelian.*');
        $this->db->from('pembelian');
        if ($this->db->field_exists('tgl_pembelian', 'pembelian')) {
            $this->db->where('DATE(pembelian.tgl_pembelian) >=', $date_from);
            $this->db->where('DATE(pembelian.tgl_pembelian) <=', $date_to);
            $this->db->order_by('pembelian.tgl_pembelian', 'DESC');
        }

        $purchases = $this->db->get()->result();

        // Summary
        $this->db->select('COUNT(*) as total_pembelian, COALESCE(SUM(total), 0) as total_nilai');
        $this->db->from('pembelian');

        $summary = $this->db->get()->row();

        $data = [
            'page_title' => 'Laporan Pembelian',
            'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Pembelian' => ''],
            'date_from' => $date_from,
            'date_to' => $date_to,
            'purchases' => $purchases,
            'summary' => $summary
        ];

        $this->render('laporan/pembelian', $data);
    }

    /**
     * Profit and Loss Report
     */
    public function laba_rugi()
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');

        // Get income from sales
        $income = 0;
        if ($this->db->table_exists('transaksi')) {
            $this->db->select_sum('total', 'total_penjualan');
            $this->db->from('transaksi');
            $this->db->where('transaksi.status', 'selesai');
            $this->db->where('MONTH(tgl_transaksi)', $bulan);
            $this->db->where('YEAR(tgl_transaksi)', $tahun);
            $result = $this->db->get()->row();
            $income = $result->total_penjualan ?: 0;
        }

        // Get expenses from purchases
        $purchases = 0;
        if ($this->db->table_exists('pembelian')) {
            $this->db->select_sum('total', 'total_pembelian');
            $this->db->from('pembelian');
            $result = $this->db->get()->row();
            $purchases = $result->total_pembelian ?: 0;
        }

        // Get payroll expenses
        $payroll = 0;
        if ($this->db->table_exists('penggajian')) {
            $this->db->select_sum('gaji_bersih', 'total_gaji');
            $this->db->from('penggajian');
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $result = $this->db->get()->row();
            $payroll = $result->total_gaji ?: 0;
        }

        $total_expense = $purchases + $payroll;
        $profit = $income - $total_expense;

        $data = [
            'page_title' => 'Laporan Laba/Rugi',
            'breadcrumbs' => ['Laporan' => admin_url('laporan'), 'Laba/Rugi' => ''],
            'bulan' => $bulan,
            'tahun' => $tahun,
            'income' => $income,
            'purchases' => $purchases,
            'payroll' => $payroll,
            'total_expense' => $total_expense,
            'profit' => $profit
        ];

        $this->render('laporan/laba_rugi', $data);
    }

    /**
     * Export to Excel (simple CSV)
     */
    public function export($type)
    {
        $date_from = $this->input->get('from') ?: date('Y-m-01');
        $date_to = $this->input->get('to') ?: date('Y-m-d');

        switch ($type) {
            case 'penjualan':
                $data = $this->Transaksi_model->get_all([
                    'status' => 'selesai',
                    'date_from' => $date_from,
                    'date_to' => $date_to
                ]);
                $filename = 'laporan_penjualan_' . date('Ymd') . '.csv';
                $headers = ['Kode', 'Tanggal', 'Tipe', 'Status', 'Subtotal', 'Diskon', 'Total'];

                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '"');

                $output = fopen('php://output', 'w');
                fputcsv($output, $headers);

                foreach ($data as $row) {
                    fputcsv($output, [
                        $row->kode_transaksi,
                        $row->tgl_transaksi,
                        $row->tipe_pemesanan,
                        $row->status,
                        $row->subtotal,
                        $row->diskon_nominal,
                        $row->total
                    ]);
                }

                fclose($output);
                break;

            default:
                redirect('admin/laporan');
        }
    }
}
