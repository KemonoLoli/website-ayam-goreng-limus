<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian_model extends CI_Model
{

    protected $table = 'pembelian';
    protected $table_detail = 'pembelian_detail';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_pembelian' => $id])->row();
    }

    public function get_with_details($id)
    {
        $pembelian = $this->get_by_id($id);
        if (!$pembelian)
            return null;

        $this->db->select('pd.*, b.nama_bahan, b.satuan');
        $this->db->from($this->table_detail . ' pd');
        $this->db->join('bahan b', 'b.id_bahan = pd.id_bahan', 'left');
        $this->db->where('pd.id_pembelian', $id);

        $pembelian->items = $this->db->get()->result();
        return $pembelian;
    }

    public function get_all($filters = [])
    {
        $this->db->select('p.*, s.nama_supplier, k.nama as nama_petugas');
        $this->db->from($this->table . ' p');
        $this->db->join('supplier s', 's.id_supplier = p.id_supplier', 'left');
        $this->db->join('karyawan k', 'k.id_karyawan = p.id_petugas', 'left');

        if (!empty($filters['status'])) {
            $this->db->where('p.status', $filters['status']);
        }

        if (!empty($filters['supplier'])) {
            $this->db->where('p.id_supplier', $filters['supplier']);
        }

        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(p.tgl_pembelian) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(p.tgl_pembelian) <=', $filters['date_to']);
        }

        $this->db->order_by('p.tgl_pembelian', 'DESC');
        return $this->db->get()->result();
    }

    public function generate_kode()
    {
        $prefix = 'PO' . date('Ymd');
        $this->db->like('kode_pembelian', $prefix, 'after');
        $this->db->order_by('id_pembelian', 'DESC');
        $last = $this->db->get($this->table)->row();

        if ($last) {
            $num = (int) substr($last->kode_pembelian, -4) + 1;
        } else {
            $num = 1;
        }

        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function create($data, $items = [])
    {
        $this->db->trans_start();

        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();

        if (!empty($items)) {
            foreach ($items as $item) {
                $item['id_pembelian'] = $id;
                $this->db->insert($this->table_detail, $item);
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status() ? $id : false;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_pembelian', $id);
        return $this->db->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function receive($id)
    {
        $this->load->model('Inventaris_model');
        $pembelian = $this->get_with_details($id);

        if (!$pembelian || $pembelian->status !== 'dipesan') {
            return false;
        }

        $this->db->trans_start();

        // Update stock for each item
        foreach ($pembelian->items as $item) {
            $this->Inventaris_model->stock_in(
                $item->id_bahan,
                $item->qty,
                'Penerimaan dari PO: ' . $pembelian->kode_pembelian,
                $id
            );
        }

        // Update status
        $this->update($id, [
            'status' => 'diterima',
            'tgl_diterima' => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id)
    {
        $this->db->trans_start();
        $this->db->where('id_pembelian', $id)->delete($this->table_detail);
        $this->db->where('id_pembelian', $id)->delete($this->table);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
