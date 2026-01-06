<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * POS Controller
 * Point of Sale / Kasir module
 */
class Pos extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin', 'kasir', 'waiter'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Menu_model', 'Kategori_model', 'Transaksi_model', 'Konsumen_model', 'Karyawan_model']);
    }

    /**
     * POS main page
     */
    public function index()
    {
        $data = [
            'page_title' => 'Kasir (POS)',
            'categories' => $this->Kategori_model->get_active(),
            'menus' => $this->Menu_model->get_active(),
        ];

        // Get karyawan data for current user
        $karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);
        $data['id_kasir'] = $karyawan ? $karyawan->id_karyawan : null;

        $this->render('pos/index', $data);
    }

    /**
     * Get menus by category (AJAX)
     */
    public function get_menu($id_kategori = null)
    {
        if ($id_kategori) {
            $menus = $this->Menu_model->get_by_kategori($id_kategori);
        } else {
            $menus = $this->Menu_model->get_active();
        }

        $this->json_response(['success' => true, 'data' => $menus]);
    }

    /**
     * Process transaction (AJAX)
     */
    public function process()
    {
        if ($this->input->method() !== 'post') {
            $this->json_response(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }

        $this->load->library('form_validation');

        // Validate basic fields
        $this->form_validation->set_rules('tipe_pemesanan', 'Tipe Pesanan', 'required');
        $this->form_validation->set_rules('metode_pembayaran', 'Metode Pembayaran', 'required');
        $this->form_validation->set_rules('items', 'Items', 'required');

        if (!$this->form_validation->run()) {
            $this->json_response(['success' => false, 'message' => validation_errors()], 400);
            return;
        }

        $items = json_decode($this->input->post('items'), true);
        if (empty($items)) {
            $this->json_response(['success' => false, 'message' => 'Keranjang kosong'], 400);
            return;
        }

        // Calculate totals
        $subtotal = 0;
        $detail_items = [];

        foreach ($items as $item) {
            $menu = $this->Menu_model->get_by_id($item['id_menu']);
            if (!$menu)
                continue;

            $qty = (int) $item['qty'];
            $harga = $menu->harga_promo ?: $menu->harga;
            $total_item = $harga * $qty;
            $subtotal += $total_item;

            $detail_items[] = [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'qty' => $qty,
                'harga_satuan' => $harga,
                'diskon' => 0,
                'total_harga' => $total_item,
                'catatan' => isset($item['catatan']) ? $item['catatan'] : ''
            ];
        }

        // Get karyawan ID for kasir
        $karyawan = $this->Karyawan_model->get_by_user($this->current_user->id_user);

        // Calculate final amounts
        $diskon_persen = (float) $this->input->post('diskon_persen', true);
        $diskon_nominal = $subtotal * ($diskon_persen / 100);
        $ongkir = (float) $this->input->post('ongkir', true);
        $pajak = 0; // Can be configured
        $total = $subtotal - $diskon_nominal + $pajak + $ongkir;
        $bayar = (float) $this->input->post('bayar', true);
        $kembalian = max(0, $bayar - $total);

        // Determine customer name based on order type
        $tipe = $this->input->post('tipe_pemesanan', true);
        $nama_pelanggan = '';
        if ($tipe === 'dinein') {
            $nama_pelanggan = $this->input->post('nama_pelanggan_dinein', true);
        } elseif ($tipe === 'takeaway') {
            $nama_pelanggan = $this->input->post('nama_pelanggan_takeaway', true);
        } else {
            $nama_pelanggan = $this->input->post('nama_pelanggan', true);
        }

        // Validate customer name is required
        if (empty(trim($nama_pelanggan))) {
            $this->json_response(['success' => false, 'message' => 'Nama pelanggan harus diisi!'], 400);
            return;
        }

        // Prepare transaction data
        $transaksi = [
            'kode_transaksi' => $this->Transaksi_model->generate_kode(),
            'tgl_transaksi' => date('Y-m-d H:i:s'),
            'tipe_pemesanan' => $tipe,
            'metode_pembayaran' => $this->input->post('metode_pembayaran', true),
            'id_kasir' => $karyawan ? $karyawan->id_karyawan : null,
            'nama_pelanggan' => $nama_pelanggan,
            'no_hp_pelanggan' => $this->input->post('no_hp_pelanggan', true),
            'no_meja' => $this->input->post('no_meja', true),
            'alamat_pengiriman' => $this->input->post('alamat_pengiriman', true),
            'catatan' => $this->input->post('catatan', true),
            'subtotal' => $subtotal,
            'diskon_persen' => $diskon_persen,
            'diskon_nominal' => $diskon_nominal,
            'pajak' => $pajak,
            'ongkir' => $ongkir,
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
            'status' => 'diproses'
        ];

        $id = $this->Transaksi_model->create($transaksi, $detail_items);

        if ($id) {
            $this->json_response([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'data' => [
                    'id_transaksi' => $id,
                    'kode_transaksi' => $transaksi['kode_transaksi'],
                    'total' => $total,
                    'kembalian' => $kembalian
                ]
            ]);
        } else {
            $this->json_response(['success' => false, 'message' => 'Gagal menyimpan transaksi'], 500);
        }
    }

    /**
     * Get receipt data (AJAX)
     */
    public function receipt($id)
    {
        $transaksi = $this->Transaksi_model->get_with_details($id);
        if (!$transaksi) {
            $this->json_response(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
            return;
        }

        $this->json_response(['success' => true, 'data' => $transaksi]);
    }

    /**
     * Print receipt page
     */
    public function print_receipt($id)
    {
        $transaksi = $this->Transaksi_model->get_with_details($id);
        if (!$transaksi) {
            show_404();
            return;
        }

        $data = [
            'transaksi' => $transaksi,
            'settings' => $this->_get_settings()
        ];

        $this->load->view('admin/pos/receipt', $data);
    }

    /**
     * Get app settings
     */
    private function _get_settings()
    {
        $this->db->select('setting_key, setting_value');
        $result = $this->db->get('settings')->result();

        $settings = [];
        foreach ($result as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        return $settings;
    }
}
