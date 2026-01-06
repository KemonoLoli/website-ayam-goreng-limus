<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model
{

    protected $table = 'kategori_menu';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_kategori' => $id])->row();
    }

    public function get_all()
    {
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('nama_kategori', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_active()
    {
        $this->db->where('is_active', 1);
        $this->db->order_by('urutan', 'ASC');
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
        $this->db->where('id_kategori', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_kategori', $id);
        return $this->db->delete($this->table);
    }

    public function dropdown()
    {
        $items = $this->get_active();
        $dropdown = ['' => '-- Pilih Kategori --'];
        foreach ($items as $item) {
            $dropdown[$item->id_kategori] = $item->nama_kategori;
        }
        return $dropdown;
    }
}
