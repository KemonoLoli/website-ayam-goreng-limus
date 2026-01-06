<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    protected $table = 'menu';

    public function get_by_id($id)
    {
        $this->db->select('menu.*, kategori_menu.nama_kategori');
        $this->db->join('kategori_menu', 'kategori_menu.id_kategori = menu.id_kategori', 'left');
        $this->db->where('id_menu', $id);
        return $this->db->get($this->table)->row();
    }

    public function get_all($filters = [])
    {
        $this->db->select('menu.*, kategori_menu.nama_kategori');
        $this->db->join('kategori_menu', 'kategori_menu.id_kategori = menu.id_kategori', 'left');

        if (isset($filters['is_aktif'])) {
            $this->db->where('menu.is_aktif', $filters['is_aktif']);
        }
        if (!empty($filters['id_kategori'])) {
            $this->db->where('menu.id_kategori', $filters['id_kategori']);
        }
        if (!empty($filters['jenis'])) {
            $this->db->where('menu.jenis', $filters['jenis']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('menu.nama_menu', $filters['search']);
            $this->db->or_like('menu.kode_menu', $filters['search']);
            $this->db->group_end();
        }

        $this->db->order_by('kategori_menu.urutan', 'ASC');
        $this->db->order_by('menu.nama_menu', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_active()
    {
        return $this->get_all(['is_aktif' => 1]);
    }

    public function get_by_kategori($id_kategori)
    {
        $this->db->where('id_kategori', $id_kategori);
        $this->db->where('is_aktif', 1);
        $this->db->order_by('nama_menu', 'ASC');
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
        $this->db->where('id_menu', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_menu', $id);
        return $this->db->delete($this->table);
    }

    public function toggle_status($id)
    {
        $menu = $this->get_by_id($id);
        if ($menu) {
            return $this->update($id, ['is_aktif' => $menu->is_aktif ? 0 : 1]);
        }
        return false;
    }

    public function generate_kode($jenis = 'makanan')
    {
        $prefixes = ['makanan' => 'MK', 'minuman' => 'MN', 'paket' => 'PK', 'lainnya' => 'LN'];
        $prefix = $prefixes[$jenis] ?? 'MK';

        $this->db->select('kode_menu');
        $this->db->like('kode_menu', $prefix);
        $this->db->order_by('kode_menu', 'DESC');
        $last = $this->db->get($this->table)->row();

        $num = $last ? ((int) substr($last->kode_menu, -3) + 1) : 1;
        return $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
