<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Reward_model
 * Model for rewards management
 */
class Reward_model extends CI_Model
{
    protected $table = 'rewards';

    /**
     * Get reward by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_reward' => $id])->row();
    }

    /**
     * Get all rewards with optional filters
     */
    public function get_all($filters = [])
    {
        if (isset($filters['is_active'])) {
            $this->db->where('is_active', $filters['is_active']);
        }
        if (!empty($filters['search'])) {
            $this->db->like('nama_reward', $filters['search']);
        }

        $this->db->order_by('poin_dibutuhkan', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get active rewards
     */
    public function get_active()
    {
        $this->db->where('is_active', 1);

        // Check date validity
        $today = date('Y-m-d');
        $this->db->group_start();
        $this->db->where('tanggal_mulai IS NULL', null, false);
        $this->db->or_where('tanggal_mulai <=', $today);
        $this->db->group_end();

        $this->db->group_start();
        $this->db->where('tanggal_selesai IS NULL', null, false);
        $this->db->or_where('tanggal_selesai >=', $today);
        $this->db->group_end();

        // Check stock
        $this->db->group_start();
        $this->db->where('stok IS NULL', null, false);
        $this->db->or_where('stok >', 0);
        $this->db->group_end();

        $this->db->order_by('poin_dibutuhkan', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get rewards available for member based on their poin
     */
    public function get_available($poin)
    {
        $rewards = $this->get_active();

        foreach ($rewards as $reward) {
            $reward->can_claim = ($poin >= $reward->poin_dibutuhkan);
        }

        return $rewards;
    }

    /**
     * Create new reward
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Update reward
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_reward', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete reward
     */
    public function delete($id)
    {
        $this->db->where('id_reward', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Decrease stock
     */
    public function decrease_stock($id)
    {
        $reward = $this->get_by_id($id);
        if (!$reward || ($reward->stok !== null && $reward->stok <= 0)) {
            return false;
        }

        if ($reward->stok !== null) {
            $this->db->set('stok', 'stok - 1', false);
            $this->db->where('id_reward', $id);
            return $this->db->update($this->table);
        }

        return true; // Unlimited stock
    }

    /**
     * Claim a reward for a member
     */
    public function claim($id_konsumen, $id_reward)
    {
        $reward = $this->get_by_id($id_reward);
        if (!$reward || !$reward->is_active) {
            return ['success' => false, 'message' => 'Reward tidak tersedia'];
        }

        // Check stock
        if ($reward->stok !== null && $reward->stok <= 0) {
            return ['success' => false, 'message' => 'Stok reward habis'];
        }

        // Check member poin
        $this->load->model('Konsumen_model');
        $konsumen = $this->Konsumen_model->get_by_id($id_konsumen);
        if (!$konsumen || $konsumen->poin < $reward->poin_dibutuhkan) {
            return ['success' => false, 'message' => 'Poin tidak mencukupi'];
        }

        $this->db->trans_start();

        // Use poin
        $this->Konsumen_model->use_poin(
            $id_konsumen,
            $reward->poin_dibutuhkan,
            $id_reward,
            'reward',
            'Klaim reward: ' . $reward->nama_reward
        );

        // Decrease stock
        $this->decrease_stock($id_reward);

        // Create claim record
        $kode_klaim = 'RWD-' . date('ymd') . strtoupper(substr(uniqid(), -4));
        $expired_at = date('Y-m-d H:i:s', strtotime('+30 days'));

        $claim = [
            'id_konsumen' => $id_konsumen,
            'id_reward' => $id_reward,
            'poin_digunakan' => $reward->poin_dibutuhkan,
            'kode_klaim' => $kode_klaim,
            'status' => 'active',
            'expired_at' => $expired_at,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('reward_claims', $claim);
        $id_claim = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            return [
                'success' => true,
                'message' => 'Reward berhasil diklaim!',
                'kode_klaim' => $kode_klaim,
                'id_claim' => $id_claim
            ];
        }

        return ['success' => false, 'message' => 'Gagal mengklaim reward'];
    }

    /**
     * Get member's active claims
     */
    public function get_member_claims($id_konsumen, $status = null)
    {
        $this->db->select('rc.*, r.nama_reward, r.tipe_reward, r.nilai_reward');
        $this->db->from('reward_claims rc');
        $this->db->join('rewards r', 'r.id_reward = rc.id_reward');
        $this->db->where('rc.id_konsumen', $id_konsumen);

        if ($status) {
            $this->db->where('rc.status', $status);
        }

        $this->db->order_by('rc.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Use a claim in transaction
     */
    public function use_claim($kode_klaim, $id_transaksi)
    {
        $this->db->where('kode_klaim', $kode_klaim);
        $this->db->where('status', 'active');
        $this->db->where('expired_at >', date('Y-m-d H:i:s'));
        $claim = $this->db->get('reward_claims')->row();

        if (!$claim) {
            return ['success' => false, 'message' => 'Kode klaim tidak valid atau sudah expired'];
        }

        $this->db->where('id_claim', $claim->id_claim);
        $this->db->update('reward_claims', [
            'status' => 'used',
            'id_transaksi' => $id_transaksi,
            'used_at' => date('Y-m-d H:i:s')
        ]);

        return [
            'success' => true,
            'claim' => $claim
        ];
    }

    /**
     * Get claim by code
     */
    public function get_claim_by_code($kode_klaim)
    {
        $this->db->select('rc.*, r.nama_reward, r.tipe_reward, r.nilai_reward, r.id_menu');
        $this->db->from('reward_claims rc');
        $this->db->join('rewards r', 'r.id_reward = rc.id_reward');
        $this->db->where('rc.kode_klaim', $kode_klaim);
        return $this->db->get()->row();
    }
}
