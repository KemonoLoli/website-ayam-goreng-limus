<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pembelian Controller
 * Purchase order management
 */
class Pembelian extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Bahan_model']);
    }

    /**
     * List purchases
     */
    public function index()
    {
        // Check if tables exist
        if (!$this->db->table_exists('pembelian')) {
            $data = [
                'page_title' => 'Pembelian Stok',
                'purchases' => [],
                'table_missing' => true
            ];
            $this->render('pembelian/index', $data);
            return;
        }

        $this->db->select('pembelian.*');
        if ($this->db->table_exists('supplier') && $this->db->field_exists('nama', 'supplier')) {
            $this->db->select('supplier.nama as supplier_nama');
            $this->db->join('supplier', 'supplier.id_supplier = pembelian.id_supplier', 'left');
        }
        $this->db->order_by('pembelian.created_at', 'DESC');
        $purchases = $this->db->get('pembelian')->result();

        $data = [
            'page_title' => 'Pembelian Stok',
            'purchases' => $purchases
        ];

        $this->render('pembelian/index', $data);
    }

    /**
     * Create purchase
     */
    public function create()
    {
        if ($this->input->post()) {
            $this->db->trans_start();

            $purchase_data = [
                'kode_pembelian' => $this->_generate_code(),
                'id_supplier' => $this->input->post('id_supplier') ?: null,
                'tgl_pembelian' => $this->input->post('tgl_pembelian'),
                'total' => 0,
                'status' => 'draft',
                'catatan' => $this->input->post('catatan'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('pembelian', $purchase_data);
            $id = $this->db->insert_id();

            $items = $this->input->post('items');
            $total = 0;

            if ($items) {
                foreach ($items as $item) {
                    if (!empty($item['id_bahan']) && !empty($item['qty'])) {
                        $subtotal = $item['qty'] * $item['harga'];
                        $total += $subtotal;

                        $this->db->insert('pembelian_detail', [
                            'id_pembelian' => $id,
                            'id_bahan' => $item['id_bahan'],
                            'qty' => $item['qty'],
                            'harga' => $item['harga'],
                            'subtotal' => $subtotal
                        ]);
                    }
                }
            }

            $this->db->where('id_pembelian', $id);
            $this->db->update('pembelian', ['total' => $total]);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Pembelian berhasil dibuat.');
                redirect('admin/pembelian');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat pembelian.');
            }
        }

        // Get suppliers for dropdown
        $this->db->where('is_active', 1);
        $suppliers = $this->db->get('supplier')->result();

        // Get bahan for dropdown
        $bahan = $this->Bahan_model->get_all();

        $data = [
            'page_title' => 'Buat Pembelian',
            'suppliers' => $suppliers,
            'bahan' => $bahan
        ];

        $this->render('pembelian/form', $data);
    }

    /**
     * Receive purchase (update stock)
     */
    public function receive($id)
    {
        $purchase = $this->db->get_where('pembelian', ['id_pembelian' => $id])->row();

        if (!$purchase || $purchase->status != 'dipesan') {
            $this->session->set_flashdata('error', 'Pembelian tidak valid.');
            redirect('admin/pembelian');
        }

        $this->db->trans_start();

        // Update stock
        $items = $this->db->get_where('pembelian_detail', ['id_pembelian' => $id])->result();
        foreach ($items as $item) {
            $this->db->set('stok', 'stok + ' . $item->qty, false);
            $this->db->where('id_bahan', $item->id_bahan);
            $this->db->update('bahan');
        }

        // Update status
        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian', [
            'status' => 'diterima',
            'tgl_diterima' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Pembelian diterima dan stok diupdate.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menerima pembelian.');
        }

        redirect('admin/pembelian');
    }

    /**
     * Confirm order
     */
    public function confirm($id)
    {
        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian', [
            'status' => 'dipesan',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Pembelian dikonfirmasi.');
        redirect('admin/pembelian');
    }

    private function _generate_code()
    {
        $prefix = 'PO';
        $date = date('Ymd');

        $this->db->select('kode_pembelian');
        $this->db->like('kode_pembelian', $prefix . $date);
        $this->db->order_by('kode_pembelian', 'DESC');
        $last = $this->db->get('pembelian')->row();

        if ($last) {
            $num = (int) substr($last->kode_pembelian, -4) + 1;
        } else {
            $num = 1;
        }

        return $prefix . $date . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
