<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Landing Controller
 * 
 * Frontend landing page that connects to backend models
 * to display dynamic menu, track orders, and link to admin
 */
class Landing extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->model(['Menu_model', 'Kategori_model', 'Transaksi_model', 'Konsumen_model']);
    $this->load->helper('admin');
  }

  public function index()
  {
    // Get featured menu items (bestsellers or first 4 active)
    $this->db->where('is_aktif', 1);
    $this->db->order_by('is_bestseller', 'DESC');
    $this->db->order_by('id_menu', 'DESC');
    $this->db->limit(4);
    $featured_menu = $this->db->get('menu')->result();

    // Get categories for menu page
    $categories = $this->Kategori_model->get_active();

    $data = [
      'page_title' => 'Warung Ayam Goreng Limus Regency',
      'featured_menu' => $featured_menu,
      'categories' => $categories,
      'menu_url' => site_url('menu'),
      'order_url' => site_url('order'),
      'track_url' => site_url('track'),
      'login_url' => site_url('admin/login'),
    ];

    $this->load->view('frontend/landing', $data);
  }

  /**
   * Full Menu Page
   */
  public function menu()
  {
    $category_id = $this->input->get('kategori');

    $filters = [];
    if ($category_id) {
      $filters['category'] = $category_id;
    }

    $data = [
      'page_title' => 'Menu Lengkap',
      'categories' => $this->Kategori_model->get_active(),
      'menu_items' => $this->Menu_model->get_all($filters),
      'selected_category' => $category_id,
    ];

    $this->load->view('frontend/menu', $data);
  }

  /**
   * Order Tracking
   */
  public function track()
  {
    $code = $this->input->get('code');
    $order = null;
    $error = null;

    if ($code) {
      // Search transaction by code
      $this->db->where('kode_transaksi', $code);
      $order = $this->db->get('transaksi')->row();

      if ($order) {
        // Get order items
        $this->db->where('id_transaksi', $order->id_transaksi);
        $order->items = $this->db->get('transaksi_detail')->result();
      } else {
        $error = 'Pesanan dengan kode "' . $code . '" tidak ditemukan.';
      }
    }

    $data = [
      'page_title' => 'Lacak Pesanan',
      'code' => $code,
      'order' => $order,
      'error' => $error,
    ];

    $this->load->view('frontend/track', $data);
  }

  /**
   * Order Page (with member support)
   */
  public function order()
  {
    // Get all active menu items grouped by category
    $categories = $this->Kategori_model->get_active();

    foreach ($categories as $cat) {
      $this->db->where('id_kategori', $cat->id_kategori);
      $this->db->where('is_aktif', 1);
      $this->db->order_by('nama_menu', 'ASC');
      $cat->items = $this->db->get('menu')->result();
    }

    // Check if member is logged in
    $member = null;
    $konsumen = null;
    $member_discount = 0;

    if ($this->session->userdata('member_id')) {
      $this->load->model('User_model');
      $member = $this->User_model->get_by_id($this->session->userdata('member_id'));
      $konsumen = $this->Konsumen_model->get_by_user_id($this->session->userdata('member_id'));

      // Get member discount from settings
      $this->db->where('setting_key', 'diskon_member');
      $setting = $this->db->get('settings')->row();
      $member_discount = $setting ? (int) $setting->setting_value : 5;
    }

    // Check for reorder items
    $reorder_items = $this->session->userdata('reorder_items');
    if ($reorder_items) {
      $this->session->unset_userdata('reorder_items');
    }

    $data = [
      'page_title' => 'Pesan Online',
      'categories' => $categories,
      'member' => $member,
      'konsumen' => $konsumen,
      'member_discount' => $member_discount,
      'reorder_items' => $reorder_items,
    ];

    $this->load->view('frontend/order', $data);
  }

  /**
   * Process order submission (guest and member)
   */
  public function submit_order()
  {
    if ($this->input->method() !== 'post') {
      redirect('order');
    }

    $items = json_decode($this->input->post('items'), true);

    if (empty($items)) {
      $this->session->set_flashdata('error', 'Keranjang masih kosong!');
      redirect('order');
    }

    // Calculate totals
    $subtotal = 0;
    $order_items = [];

    foreach ($items as $item) {
      $menu = $this->Menu_model->get_by_id($item['id']);
      if ($menu) {
        $harga = $menu->harga_promo ?: $menu->harga;
        $item_total = $harga * $item['qty'];
        $subtotal += $item_total;

        $order_items[] = [
          'id_menu' => $menu->id_menu,
          'nama_menu' => $menu->nama_menu,
          'qty' => $item['qty'],
          'harga_satuan' => $harga,
          'total_harga' => $item_total,
          'catatan' => $item['note'] ?? '',
        ];
      }
    }

    // Check if member is logged in
    $id_konsumen = null;
    $diskon_persen = 0;
    $diskon_nominal = 0;

    if ($this->session->userdata('member_id')) {
      $konsumen = $this->Konsumen_model->get_by_user_id($this->session->userdata('member_id'));
      if ($konsumen) {
        $id_konsumen = $konsumen->id_konsumen;

        // Get member discount from settings
        $this->db->where('setting_key', 'diskon_member');
        $setting = $this->db->get('settings')->row();
        $diskon_persen = $setting ? (float) $setting->setting_value : 5;
        $diskon_nominal = $subtotal * ($diskon_persen / 100);
      }
    }

    // Calculate final total
    $total = $subtotal - $diskon_nominal;

    // Generate transaction code
    $kode = 'LMR-' . date('ymd') . strtoupper(substr(uniqid(), -4));

    // Create transaction
    $transaksi = [
      'kode_transaksi' => $kode,
      'tgl_transaksi' => date('Y-m-d H:i:s'),
      'tipe_pemesanan' => $this->input->post('tipe'),
      'id_konsumen' => $id_konsumen,
      'nama_pelanggan' => $this->input->post('nama'),
      'no_hp_pelanggan' => $this->input->post('hp'),
      'alamat_pengiriman' => $this->input->post('alamat'),
      'no_meja' => $this->input->post('meja'),
      'catatan' => $this->input->post('catatan'),
      'subtotal' => $subtotal,
      'diskon_persen' => $diskon_persen,
      'diskon_nominal' => $diskon_nominal,
      'total' => $total,
      'status' => 'pending',
      'metode_pembayaran' => $this->input->post('metode_pembayaran') ?: 'cash',
      'created_at' => date('Y-m-d H:i:s'),
    ];

    $this->db->insert('transaksi', $transaksi);
    $id_transaksi = $this->db->insert_id();

    // Insert order items
    foreach ($order_items as $item) {
      $item['id_transaksi'] = $id_transaksi;
      $this->db->insert('transaksi_detail', $item);
    }

    // If member, add poin and update total_transaksi
    if ($id_konsumen) {
      // Calculate poin earned
      $poin_earned = $this->Konsumen_model->calculate_poin($total);

      if ($poin_earned > 0) {
        $this->Konsumen_model->add_poin(
          $id_konsumen,
          $poin_earned,
          'earn',
          $id_transaksi,
          'transaksi',
          'Poin dari transaksi ' . $kode
        );
      }

      // Update total_transaksi
      $this->Konsumen_model->add_transaksi($id_konsumen, $total);
    }

    // Redirect to thank you page
    $this->session->set_flashdata('order_code', $kode);
    $this->session->set_flashdata('order_total', $total);
    $this->session->set_flashdata('order_discount', $diskon_nominal);
    $this->session->set_flashdata('poin_earned', isset($poin_earned) ? $poin_earned : 0);
    redirect('order/thanks');
  }

  /**
   * Order confirmation page
   */
  public function thanks()
  {
    $code = $this->session->flashdata('order_code');
    $total = $this->session->flashdata('order_total');
    $discount = $this->session->flashdata('order_discount');
    $poin_earned = $this->session->flashdata('poin_earned');

    if (!$code) {
      redirect('/');
    }

    $data = [
      'page_title' => 'Pesanan Berhasil',
      'order_code' => $code,
      'order_total' => $total,
      'order_discount' => $discount,
      'poin_earned' => $poin_earned,
    ];

    $this->load->view('frontend/thanks', $data);
  }
}
