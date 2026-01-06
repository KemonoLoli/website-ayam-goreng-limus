<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Inventaris Controller
 * Stock movement tracking based on database_final.sql schema
 */
class Inventaris extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List stock movements
     */
    public function index()
    {
        // Get stock movements with bahan details
        $this->db->select('inventaris.*, bahan.nama_bahan, bahan.satuan');
        $this->db->from('inventaris');
        $this->db->join('bahan', 'bahan.id_bahan = inventaris.id_bahan', 'left');
        $this->db->order_by('inventaris.tgl_pergerakan', 'DESC');
        $this->db->limit(100);
        $movements = $this->db->get()->result();

        // Get current stock levels
        $this->db->select('bahan.*, 
            (SELECT SUM(CASE WHEN jenis_pergerakan="masuk" THEN qty ELSE -qty END) FROM inventaris WHERE id_bahan=bahan.id_bahan) as total_movement');
        $this->db->from('bahan');
        $this->db->order_by('nama_bahan', 'ASC');
        $stocks = $this->db->get()->result();

        $data = [
            'page_title' => 'Stock & Inventaris',
            'movements' => $movements,
            'stocks' => $stocks
        ];

        $this->render('inventaris/index', $data);
    }

    /**
     * Add stock movement
     */
    public function create()
    {
        if ($this->input->post()) {
            $id_bahan = $this->input->post('id_bahan');

            // Get current stock
            $bahan = $this->db->get_where('bahan', ['id_bahan' => $id_bahan])->row();
            $stok_sebelum = $bahan ? $bahan->stok : 0;

            $jenis = $this->input->post('jenis_pergerakan');
            $qty = floatval($this->input->post('qty'));

            if ($jenis == 'masuk') {
                $stok_sesudah = $stok_sebelum + $qty;
            } else {
                $stok_sesudah = $stok_sebelum - $qty;
            }

            // Insert movement record
            $data = [
                'id_bahan' => $id_bahan,
                'jenis_pergerakan' => $jenis,
                'qty' => $qty,
                'stok_sebelum' => $stok_sebelum,
                'stok_sesudah' => $stok_sesudah,
                'tgl_pergerakan' => date('Y-m-d H:i:s'),
                'keterangan' => $this->input->post('keterangan'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('inventaris', $data);

            // Update bahan stock
            $this->db->where('id_bahan', $id_bahan);
            $this->db->update('bahan', ['stok' => $stok_sesudah, 'updated_at' => date('Y-m-d H:i:s')]);

            $this->session->set_flashdata('success', 'Pergerakan stok berhasil dicatat.');
            redirect('admin/inventaris');
        }

        // Get bahan list
        $this->db->order_by('nama_bahan', 'ASC');
        $bahan = $this->db->get('bahan')->result();

        $data = [
            'page_title' => 'Catat Pergerakan Stok',
            'bahan' => $bahan
        ];

        $this->render('inventaris/form', $data);
    }
}
