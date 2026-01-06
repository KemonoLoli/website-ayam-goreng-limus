<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

    protected $table = 'transaksi';
    protected $detail_table = 'transaksi_detail';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_transaksi' => $id])->row();
    }

    public function get_by_kode($kode)
    {
        return $this->db->get_where($this->table, ['kode_transaksi' => $kode])->row();
    }

    public function get_with_details($id)
    {
        $transaksi = $this->get_by_id($id);
        if ($transaksi) {
            $transaksi->items = $this->get_details($id);
        }
        return $transaksi;
    }

    public function get_details($id_transaksi)
    {
        $this->db->select('transaksi_detail.*, menu.nama_menu, menu.gambar');
        $this->db->join('menu', 'menu.id_menu = transaksi_detail.id_menu', 'left');
        $this->db->where('id_transaksi', $id_transaksi);
        return $this->db->get($this->detail_table)->result();
    }

    public function get_all($filters = [])
    {
        $this->db->select('transaksi.*, karyawan.nama as kasir_nama');
        $this->db->join('karyawan', 'karyawan.id_karyawan = transaksi.id_kasir', 'left');

        $this->_apply_filters($filters);

        $this->db->order_by('transaksi.created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get_paginated($limit, $offset, $filters = [])
    {
        $this->db->select('transaksi.*, karyawan.nama as kasir_nama, konsumen.nama as konsumen_nama');
        $this->db->join('karyawan', 'karyawan.id_karyawan = transaksi.id_kasir', 'left');
        $this->db->join('konsumen', 'konsumen.id_konsumen = transaksi.id_konsumen', 'left');

        $this->_apply_filters($filters);

        $this->db->order_by('transaksi.created_at', 'DESC');
        return $this->db->get($this->table, $limit, $offset)->result();
    }

    public function count_all($filters = [])
    {
        $this->_apply_filters($filters);
        return $this->db->count_all_results($this->table);
    }

    private function _apply_filters($filters)
    {
        if (!empty($filters['status'])) {
            $this->db->where('transaksi.status', $filters['status']);
        }
        if (!empty($filters['tipe'])) {
            $this->db->where('transaksi.tipe_pemesanan', $filters['tipe']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(transaksi.tgl_transaksi) >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(transaksi.tgl_transaksi) <=', $filters['date_to']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('transaksi.kode_transaksi', $filters['search']);
            $this->db->or_like('transaksi.nama_pelanggan', $filters['search']);
            $this->db->group_end();
        }
    }

    public function create($data, $items)
    {
        $this->db->trans_start();

        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();

        foreach ($items as $item) {
            $item['id_transaksi'] = $id;
            $this->db->insert($this->detail_table, $item);
        }

        $this->db->trans_complete();
        return $this->db->trans_status() ? $id : false;
    }

    public function update($id, $data)
    {
        $this->db->where('id_transaksi', $id);
        return $this->db->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        $data = ['status' => $status];
        return $this->update($id, $data);
    }

    public function generate_kode()
    {
        $prefix = 'TRX';
        $date = date('Ymd');

        $this->db->select('kode_transaksi');
        $this->db->like('kode_transaksi', $prefix . $date);
        $this->db->order_by('kode_transaksi', 'DESC');
        $last = $this->db->get($this->table)->row();

        if ($last) {
            $num = (int) substr($last->kode_transaksi, -4) + 1;
        } else {
            $num = 1;
        }

        return $prefix . $date . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function get_daily_sales($date)
    {
        $this->db->select_sum('total');
        $this->db->where('DATE(tgl_transaksi)', $date);
        $this->db->where('status', 'selesai');
        $result = $this->db->get($this->table)->row();
        return $result->total ?: 0;
    }
}
