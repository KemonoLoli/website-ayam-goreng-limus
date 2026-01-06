<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 * Main dashboard with KPIs and quick actions
 */
class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Transaksi_model', 'Menu_model', 'Bahan_model', 'Absensi_model', 'Karyawan_model']);
    }

    /**
     * Dashboard index
     */
    public function index()
    {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');

        // Get dashboard statistics
        $data = [
            'page_title' => 'Dashboard',

            // Today's stats
            'today_sales' => $this->_get_today_sales(),
            'today_orders' => $this->_get_today_orders(),
            'pending_orders' => $this->_get_pending_orders(),
            'employees_present' => $this->_get_employees_present(),

            // Monthly stats
            'monthly_sales' => $this->_get_monthly_sales(),
            'monthly_orders' => $this->_get_monthly_orders(),

            // Lists
            'low_stock_items' => $this->_get_low_stock_items(),
            'recent_orders' => $this->_get_recent_orders(5),
            'top_menu' => $this->_get_top_menu(5),

            // Chart data
            'weekly_sales' => $this->_get_weekly_sales(),
            'monthly_sales_chart' => $this->_get_monthly_sales_chart(),
        ];

        $this->render('dashboard/index', $data);
    }

    /**
     * Get today's total sales
     */
    private function _get_today_sales()
    {
        $this->db->select_sum('total');
        $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        $this->db->where('status', 'selesai');
        $result = $this->db->get('transaksi')->row();
        return $result ? ($result->total ?: 0) : 0;
    }

    /**
     * Get today's order count
     */
    private function _get_today_orders()
    {
        $this->db->where('DATE(tgl_transaksi)', date('Y-m-d'));
        $this->db->where('status !=', 'dibatalkan');
        return $this->db->count_all_results('transaksi');
    }

    /**
     * Get pending orders count
     */
    private function _get_pending_orders()
    {
        $this->db->where_in('status', ['pending', 'dikonfirmasi', 'diproses']);
        return $this->db->count_all_results('transaksi');
    }

    /**
     * Get employees present today
     */
    private function _get_employees_present()
    {
        $this->db->where('tanggal', date('Y-m-d'));
        $this->db->where('jam_masuk IS NOT NULL');
        return $this->db->count_all_results('absensi');
    }

    /**
     * Get this month's total sales
     */
    private function _get_monthly_sales()
    {
        $this->db->select_sum('total');
        $this->db->where('YEAR(tgl_transaksi)', date('Y'));
        $this->db->where('MONTH(tgl_transaksi)', date('m'));
        $this->db->where('status', 'selesai');
        $result = $this->db->get('transaksi')->row();
        return $result ? ($result->total ?: 0) : 0;
    }

    /**
     * Get this month's order count
     */
    private function _get_monthly_orders()
    {
        $this->db->where('YEAR(tgl_transaksi)', date('Y'));
        $this->db->where('MONTH(tgl_transaksi)', date('m'));
        $this->db->where('status', 'selesai');
        return $this->db->count_all_results('transaksi');
    }

    /**
     * Get low stock items
     */
    private function _get_low_stock_items()
    {
        $this->db->where('stok <= stok_minimum');
        $this->db->order_by('stok', 'ASC');
        $this->db->limit(5);
        return $this->db->get('bahan')->result();
    }

    /**
     * Get recent orders
     */
    private function _get_recent_orders($limit = 5)
    {
        $this->db->select('transaksi.*, karyawan.nama as kasir_nama');
        $this->db->join('karyawan', 'karyawan.id_karyawan = transaksi.id_kasir', 'left');
        $this->db->order_by('transaksi.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('transaksi')->result();
    }

    /**
     * Get top selling menu
     */
    private function _get_top_menu($limit = 5)
    {
        $this->db->select('menu.id_menu, menu.nama_menu, menu.harga, SUM(transaksi_detail.qty) as total_qty');
        $this->db->join('transaksi_detail', 'transaksi_detail.id_menu = menu.id_menu');
        $this->db->join('transaksi', 'transaksi.id_transaksi = transaksi_detail.id_transaksi');
        $this->db->where('transaksi.status', 'selesai');
        $this->db->where('MONTH(transaksi.tgl_transaksi)', date('m'));
        $this->db->group_by('menu.id_menu');
        $this->db->order_by('total_qty', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('menu')->result();
    }

    /**
     * Get weekly sales for chart
     */
    private function _get_weekly_sales()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $this->db->select_sum('total');
            $this->db->where('DATE(tgl_transaksi)', $date);
            $this->db->where('status !=', 'dibatalkan');
            $result = $this->db->get('transaksi')->row();

            $data[] = [
                'date' => date('d M', strtotime($date)),
                'day' => date('D', strtotime($date)),
                'total' => $result ? ($result->total ?: 0) : 0
            ];
        }
        return $data;
    }

    /**
     * Get monthly sales for chart (last 30 days)
     */
    private function _get_monthly_sales_chart()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $this->db->select_sum('total');
            $this->db->where('DATE(tgl_transaksi)', $date);
            $this->db->where('status !=', 'dibatalkan');
            $result = $this->db->get('transaksi')->row();

            $data[] = [
                'date' => date('d M', strtotime($date)),
                'day' => date('D', strtotime($date)),
                'total' => $result ? ($result->total ?: 0) : 0
            ];
        }
        return $data;
    }
}
