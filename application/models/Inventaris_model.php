<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaris_model extends CI_Model
{

    protected $table = 'inventaris';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_inventaris' => $id])->row();
    }

    public function get_all($filters = [])
    {
        $this->db->select('i.*, b.nama_bahan, b.satuan, b.stok_minimum');
        $this->db->from($this->table . ' i');
        $this->db->join('bahan b', 'b.id_bahan = i.id_bahan', 'left');

        if (!empty($filters['search'])) {
            $this->db->like('b.nama_bahan', $filters['search']);
        }

        if (!empty($filters['jenis'])) {
            $this->db->where('i.jenis_pergerakan', $filters['jenis']);
        }

        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(i.tgl_pergerakan) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(i.tgl_pergerakan) <=', $filters['date_to']);
        }

        $this->db->order_by('i.tgl_pergerakan', 'DESC');
        return $this->db->get()->result();
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function stock_in($id_bahan, $qty, $keterangan = '', $id_pembelian = null)
    {
        $this->load->model('Bahan_model');

        $data = [
            'id_bahan' => $id_bahan,
            'jenis_pergerakan' => 'masuk',
            'qty' => $qty,
            'stok_sebelum' => $this->Bahan_model->get_by_id($id_bahan)->stok,
            'tgl_pergerakan' => date('Y-m-d H:i:s'),
            'keterangan' => $keterangan,
            'id_pembelian' => $id_pembelian
        ];

        $data['stok_sesudah'] = $data['stok_sebelum'] + $qty;

        if ($this->create($data)) {
            return $this->Bahan_model->add_stock($id_bahan, $qty);
        }
        return false;
    }

    public function stock_out($id_bahan, $qty, $keterangan = '', $id_transaksi = null)
    {
        $this->load->model('Bahan_model');

        $data = [
            'id_bahan' => $id_bahan,
            'jenis_pergerakan' => 'keluar',
            'qty' => $qty,
            'stok_sebelum' => $this->Bahan_model->get_by_id($id_bahan)->stok,
            'tgl_pergerakan' => date('Y-m-d H:i:s'),
            'keterangan' => $keterangan,
            'id_transaksi' => $id_transaksi
        ];

        $data['stok_sesudah'] = max(0, $data['stok_sebelum'] - $qty);

        if ($this->create($data)) {
            return $this->Bahan_model->reduce_stock($id_bahan, $qty);
        }
        return false;
    }

    public function get_movement_summary($id_bahan, $month = null, $year = null)
    {
        $month = $month ?: date('m');
        $year = $year ?: date('Y');

        $this->db->select('jenis_pergerakan, SUM(qty) as total_qty');
        $this->db->from($this->table);
        $this->db->where('id_bahan', $id_bahan);
        $this->db->where('MONTH(tgl_pergerakan)', $month);
        $this->db->where('YEAR(tgl_pergerakan)', $year);
        $this->db->group_by('jenis_pergerakan');

        return $this->db->get()->result();
    }
}
