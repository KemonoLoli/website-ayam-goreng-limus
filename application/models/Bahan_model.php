<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_model extends CI_Model
{

    protected $table = 'bahan';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_bahan' => $id])->row();
    }

    public function get_all($filters = [])
    {
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('nama_bahan', $filters['search']);
            $this->db->or_like('kode_bahan', $filters['search']);
            $this->db->group_end();
        }
        if (!empty($filters['kategori'])) {
            $this->db->where('kategori_bahan', $filters['kategori']);
        }

        $this->db->order_by('nama_bahan', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_low_stock()
    {
        $this->db->where('stok <= stok_minimum');
        $this->db->order_by('stok', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_bahan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_bahan', $id);
        return $this->db->delete($this->table);
    }

    public function add_stock($id, $qty)
    {
        $this->db->set('stok', 'stok + ' . (float) $qty, false);
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->where('id_bahan', $id);
        return $this->db->update($this->table);
    }

    public function reduce_stock($id, $qty)
    {
        $this->db->set('stok', 'stok - ' . (float) $qty, false);
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->where('id_bahan', $id);
        return $this->db->update($this->table);
    }

    public function get_categories()
    {
        $this->db->distinct();
        $this->db->select('kategori_bahan');
        $this->db->where('kategori_bahan IS NOT NULL');
        $this->db->order_by('kategori_bahan', 'ASC');
        return $this->db->get($this->table)->result();
    }
}
