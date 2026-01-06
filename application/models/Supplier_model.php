<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model
{

    protected $table = 'supplier';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_supplier' => $id])->row();
    }

    public function get_all($filters = [])
    {
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('nama_supplier', $filters['search']);
            $this->db->or_like('kontak', $filters['search']);
            $this->db->group_end();
        }

        $this->db->order_by('nama_supplier', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_active()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('nama_supplier', 'ASC');
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
        $this->db->where('id_supplier', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_supplier', $id);
        return $this->db->delete($this->table);
    }

    public function dropdown()
    {
        $items = $this->get_active();
        $dropdown = ['' => '-- Pilih Supplier --'];
        foreach ($items as $item) {
            $dropdown[$item->id_supplier] = $item->nama_supplier;
        }
        return $dropdown;
    }
}
