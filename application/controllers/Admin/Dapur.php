<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dapur Controller
 * Kitchen display system for order management
 */
class Dapur extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner', 'admin', 'koki'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Transaksi_model', 'Menu_model']);
    }

    /**
     * Kitchen display - show pending/in-progress orders
     */
    public function index()
    {
        // Get orders that need to be prepared
        $filters = [
            'status' => 'diproses'
        ];

        $data = [
            'page_title' => 'Dapur',
            'orders' => $this->Transaksi_model->get_all($filters),
            'pending_count' => $this->_count_by_status('pending'),
            'process_count' => $this->_count_by_status('diproses'),
            'ready_count' => $this->_count_by_status('siap')
        ];

        $this->render('dapur/index', $data);
    }

    /**
     * Mark order as being prepared
     */
    public function process($id)
    {
        $this->Transaksi_model->update_status($id, 'diproses');
        $this->session->set_flashdata('success', 'Pesanan sedang diproses.');
        redirect('admin/dapur');
    }

    /**
     * Mark order as ready
     */
    public function ready($id)
    {
        $this->Transaksi_model->update_status($id, 'siap');
        $this->session->set_flashdata('success', 'Pesanan siap disajikan.');
        redirect('admin/dapur');
    }

    /**
     * Get order details via AJAX
     */
    public function detail($id)
    {
        $order = $this->Transaksi_model->get_with_details($id);
        $this->json_response(['success' => true, 'order' => $order]);
    }

    private function _count_by_status($status)
    {
        return $this->db->where('status', $status)->count_all_results('transaksi');
    }
}
