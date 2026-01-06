<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model
{

    protected $table = 'absensi';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_absensi' => $id])->row();
    }

    public function get_today($id_karyawan)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->get($this->table)->row();
    }

    public function get_by_karyawan($id_karyawan, $month = null, $year = null)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        if ($month)
            $this->db->where('MONTH(tanggal)', $month);
        if ($year)
            $this->db->where('YEAR(tanggal)', $year);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get_all($filters = [])
    {
        $this->db->select('absensi.*, karyawan.nama, karyawan.jabatan');
        $this->db->join('karyawan', 'karyawan.id_karyawan = absensi.id_karyawan');

        if (!empty($filters['tanggal'])) {
            $this->db->where('tanggal', $filters['tanggal']);
        }
        if (!empty($filters['id_karyawan'])) {
            $this->db->where('absensi.id_karyawan', $filters['id_karyawan']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['month'])) {
            $this->db->where('MONTH(tanggal)', $filters['month']);
        }
        if (!empty($filters['year'])) {
            $this->db->where('YEAR(tanggal)', $filters['year']);
        }

        $this->db->order_by('tanggal', 'DESC');
        $this->db->order_by('karyawan.nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function clock_in($id_karyawan)
    {
        $existing = $this->get_today($id_karyawan);
        if ($existing) {
            return false; // Already clocked in
        }

        return $this->db->insert($this->table, [
            'id_karyawan' => $id_karyawan,
            'tanggal' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'status' => 'hadir',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function clock_out($id_karyawan)
    {
        $existing = $this->get_today($id_karyawan);
        if (!$existing || $existing->jam_pulang) {
            return false;
        }

        $jam_masuk = strtotime($existing->jam_masuk);
        $jam_pulang = time();
        $total_jam = ($jam_pulang - $jam_masuk) / 3600;

        $this->db->where('id_absensi', $existing->id_absensi);
        return $this->db->update($this->table, [
            'jam_pulang' => date('H:i:s'),
            'total_jam_kerja' => round($total_jam, 2)
        ]);
    }

    public function break_out($id_karyawan)
    {
        $existing = $this->get_today($id_karyawan);
        if (!$existing)
            return false;

        $this->db->where('id_absensi', $existing->id_absensi);
        return $this->db->update($this->table, [
            'jam_mulai_istirahat' => date('H:i:s')
        ]);
    }

    public function break_in($id_karyawan)
    {
        $existing = $this->get_today($id_karyawan);
        if (!$existing)
            return false;

        $this->db->where('id_absensi', $existing->id_absensi);
        return $this->db->update($this->table, [
            'jam_selesai_istirahat' => date('H:i:s')
        ]);
    }

    public function get_summary($id_karyawan, $month, $year)
    {
        // Get status counts
        $this->db->select('status, COUNT(*) as count');
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->group_by('status');
        $result = $this->db->get($this->table)->result();

        $summary = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0, 'cuti' => 0, 'libur' => 0];
        foreach ($result as $row) {
            $summary[$row->status] = $row->count;
        }

        // Get terlambat count (if jam_masuk > 08:30)
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        $this->db->where('jam_masuk >', '08:30:00');
        $summary['terlambat'] = $this->db->count_all_results($this->table);

        // Get total jam kerja
        $this->db->select_sum('total_jam_kerja', 'total');
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        $jam_result = $this->db->get($this->table)->row();
        $summary['total_jam'] = $jam_result->total ?: 0;

        return $summary;
    }
}
