<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    protected $table = 'karyawan';

    public function get_by_id($id)
    {
        $this->db->select('karyawan.*, users.username, users.email as user_email, users.role');
        $this->db->join('users', 'users.id_user = karyawan.id_user', 'left');
        $this->db->where('id_karyawan', $id);
        return $this->db->get($this->table)->row();
    }

    public function get_by_user($id_user)
    {
        return $this->db->get_where($this->table, ['id_user' => $id_user])->row();
    }

    public function get_all($filters = [])
    {
        $this->db->select('karyawan.*, users.username, users.role');
        $this->db->join('users', 'users.id_user = karyawan.id_user', 'left');

        if (!empty($filters['status'])) {
            $this->db->where('karyawan.status', $filters['status']);
        }
        if (!empty($filters['jabatan'])) {
            $this->db->where('karyawan.jabatan', $filters['jabatan']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('karyawan.nama', $filters['search']);
            $this->db->or_like('karyawan.nip', $filters['search']);
            $this->db->group_end();
        }

        $this->db->order_by('karyawan.nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_active()
    {
        return $this->get_all(['status' => 'aktif']);
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
        $this->db->where('id_karyawan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id_karyawan', $id);
        return $this->db->delete($this->table);
    }

    public function get_by_jabatan($jabatan)
    {
        $this->db->where('jabatan', $jabatan);
        $this->db->where('status', 'aktif');
        return $this->db->get($this->table)->result();
    }

    public function get_kasir()
    {
        return $this->get_by_jabatan('Kasir');
    }

    public function get_driver()
    {
        return $this->get_by_jabatan('Driver');
    }

    public function generate_nip()
    {
        $prefix = 'EMP';
        $this->db->select('nip');
        $this->db->like('nip', $prefix);
        $this->db->order_by('nip', 'DESC');
        $last = $this->db->get($this->table)->row();

        $num = $last ? ((int) substr($last->nip, -3) + 1) : 1;
        return $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
