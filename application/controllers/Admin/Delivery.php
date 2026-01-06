<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Delivery Controller
 * Manage delivery orders
 */
class Delivery extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner', 'admin', 'driver'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
    }

    /**
     * List delivery orders
     */
    public function index()
    {
        // Get delivery orders
        $this->db->where('tipe_pemesanan', 'delivery');
        $this->db->where_in('status', ['siap', 'dikirim']);
        $this->db->order_by('created_at', 'DESC');
        $orders = $this->db->get('transaksi')->result();

        $data = [
            'page_title' => 'Delivery',
            'orders' => $orders,
            'ready_count' => $this->_count_delivery_status('siap'),
            'sending_count' => $this->_count_delivery_status('dikirim')
        ];

        $this->render('delivery/index', $data);
    }

    /**
     * Start delivery
     */
    public function start($id)
    {
        $this->Transaksi_model->update_status($id, 'dikirim');
        $this->session->set_flashdata('success', 'Pesanan sedang diantar.');
        redirect('admin/delivery');
    }

    /**
     * Complete delivery
     */
    public function complete($id)
    {
        $this->Transaksi_model->update_status($id, 'selesai');
        $this->session->set_flashdata('success', 'Pengantaran selesai.');
        redirect('admin/delivery');
    }

    private function _count_delivery_status($status)
    {
        $this->db->where('tipe_pemesanan', 'delivery');
        $this->db->where('status', $status);
        return $this->db->count_all_results('transaksi');
    }
}
