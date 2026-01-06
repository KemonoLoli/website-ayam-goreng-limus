<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggajian_model extends CI_Model
{

    protected $table = 'penggajian';

    public function get_by_id($id)
    {
        $this->db->select('p.*, k.nama, k.nip, k.jabatan, k.gaji_pokok');
        $this->db->from($this->table . ' p');
        $this->db->join('karyawan k', 'k.id_karyawan = p.id_karyawan');
        $this->db->where('p.id_penggajian', $id);
        return $this->db->get()->row();
    }

    public function get_all($filters = [])
    {
        $this->db->select('p.*, k.nama, k.nip, k.jabatan');
        $this->db->from($this->table . ' p');
        $this->db->join('karyawan k', 'k.id_karyawan = p.id_karyawan');

        if (!empty($filters['bulan'])) {
            $this->db->where('p.bulan', $filters['bulan']);
        }

        if (!empty($filters['tahun'])) {
            $this->db->where('p.tahun', $filters['tahun']);
        }

        if (!empty($filters['status'])) {
            $this->db->where('p.status', $filters['status']);
        }

        if (!empty($filters['id_karyawan'])) {
            $this->db->where('p.id_karyawan', $filters['id_karyawan']);
        }

        $this->db->order_by('p.tahun', 'DESC');
        $this->db->order_by('p.bulan', 'DESC');
        $this->db->order_by('k.nama', 'ASC');

        return $this->db->get()->result();
    }

    public function get_by_period($id_karyawan, $bulan, $tahun)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get($this->table)->row();
    }

    public function generate($id_karyawan, $bulan, $tahun)
    {
        $this->load->model(['Karyawan_model', 'Absensi_model']);

        // Check if already exists
        $existing = $this->get_by_period($id_karyawan, $bulan, $tahun);
        if ($existing) {
            return ['success' => false, 'message' => 'Penggajian sudah ada untuk periode ini'];
        }

        $karyawan = $this->Karyawan_model->get_by_id($id_karyawan);
        if (!$karyawan) {
            return ['success' => false, 'message' => 'Karyawan tidak ditemukan'];
        }

        // Get attendance summary
        $absensi = $this->Absensi_model->get_summary($id_karyawan, $bulan, $tahun);

        // Calculate components
        $gaji_pokok = $karyawan->gaji_pokok;
        $hari_kerja = $absensi['hadir'];
        $hari_kerja_seharusnya = 26; // Assuming 26 work days

        // Pro-rate salary based on attendance
        $gaji_prorata = ($hari_kerja / $hari_kerja_seharusnya) * $gaji_pokok;

        // Sample allowances and deductions
        $tunjangan_hadir = ($hari_kerja >= 22) ? 200000 : 0;
        $tunjangan_transport = $hari_kerja * 15000;
        $tunjangan_makan = $hari_kerja * 20000;

        $potongan_absen = max(0, $hari_kerja_seharusnya - $hari_kerja - $absensi['izin']) * 50000;
        $potongan_terlambat = $absensi['terlambat'] * 25000;

        $total_tunjangan = $tunjangan_hadir + $tunjangan_transport + $tunjangan_makan;
        $total_potongan = $potongan_absen + $potongan_terlambat;

        $gaji_bersih = $gaji_prorata + $total_tunjangan - $total_potongan;

        $data = [
            'id_karyawan' => $id_karyawan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $gaji_pokok,
            'total_hari_kerja' => $hari_kerja,
            'tunjangan_hadir' => $tunjangan_hadir,
            'tunjangan_transport' => $tunjangan_transport,
            'tunjangan_makan' => $tunjangan_makan,
            'tunjangan_lainnya' => 0,
            'potongan_absen' => $potongan_absen,
            'potongan_terlambat' => $potongan_terlambat,
            'potongan_lainnya' => 0,
            'total_tunjangan' => $total_tunjangan,
            'total_potongan' => $total_potongan,
            'gaji_bersih' => max(0, $gaji_bersih),
            'status' => 'draft',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert($this->table, $data)) {
            return ['success' => true, 'id' => $this->db->insert_id()];
        }

        return ['success' => false, 'message' => 'Gagal menyimpan data'];
    }

    public function generate_bulk($bulan, $tahun)
    {
        $this->load->model('Karyawan_model');
        $karyawan_list = $this->Karyawan_model->get_active();

        $results = ['success' => 0, 'failed' => 0];

        foreach ($karyawan_list as $k) {
            $result = $this->generate($k->id_karyawan, $bulan, $tahun);
            if ($result['success']) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_penggajian', $id);
        return $this->db->update($this->table, $data);
    }

    public function approve($id)
    {
        return $this->update($id, [
            'status' => 'disetujui',
            'tgl_disetujui' => date('Y-m-d H:i:s')
        ]);
    }

    public function pay($id)
    {
        return $this->update($id, [
            'status' => 'dibayar',
            'tgl_dibayar' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete($id)
    {
        $penggajian = $this->get_by_id($id);
        if ($penggajian && $penggajian->status === 'draft') {
            $this->db->where('id_penggajian', $id);
            return $this->db->delete($this->table);
        }
        return false;
    }

    public function get_summary($bulan, $tahun)
    {
        $this->db->select('
            COUNT(*) as total_karyawan,
            SUM(gaji_pokok) as total_gaji_pokok,
            SUM(total_tunjangan) as total_tunjangan,
            SUM(total_potongan) as total_potongan,
            SUM(gaji_bersih) as total_gaji_bersih,
            SUM(CASE WHEN status = "draft" THEN 1 ELSE 0 END) as draft,
            SUM(CASE WHEN status = "disetujui" THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN status = "dibayar" THEN 1 ELSE 0 END) as dibayar
        ');
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get($this->table)->row();
    }
}
