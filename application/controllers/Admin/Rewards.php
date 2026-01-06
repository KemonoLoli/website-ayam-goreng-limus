<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Rewards Controller
 * Manage rewards for member redemption
 */
class Rewards extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner', 'admin', 'kasir'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Reward_model', 'Konsumen_model']);
    }

    /**
     * List all rewards
     */
    public function index()
    {
        $rewards = $this->Reward_model->get_all();

        // Get claim statistics
        foreach ($rewards as $reward) {
            $reward->total_claims = $this->_count_claims($reward->id_reward);
        }

        $data = [
            'page_title' => 'Kelola Rewards',
            'rewards' => $rewards
        ];

        $this->render('rewards/index', $data);
    }

    /**
     * Create new reward
     */
    public function create()
    {
        if ($this->input->post()) {
            $data = [
                'nama_reward' => $this->input->post('nama_reward'),
                'deskripsi' => $this->input->post('deskripsi'),
                'poin_dibutuhkan' => (int) $this->input->post('poin_dibutuhkan'),
                'tipe_reward' => $this->input->post('tipe_reward'),
                'nilai_reward' => (float) $this->input->post('nilai_reward'),
                'stok' => $this->input->post('stok') !== '' ? (int) $this->input->post('stok') : null,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'expired_days' => (int) $this->input->post('expired_days') ?: 30
            ];

            if ($this->Reward_model->create($data)) {
                $this->session->set_flashdata('success', 'Reward berhasil ditambahkan.');
                redirect('admin/rewards');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan reward.');
            }
        }

        $data = [
            'page_title' => 'Tambah Reward'
        ];

        $this->render('rewards/form', $data);
    }

    /**
     * Edit reward
     */
    public function edit($id)
    {
        $reward = $this->Reward_model->get_by_id($id);

        if (!$reward) {
            $this->session->set_flashdata('error', 'Reward tidak ditemukan.');
            redirect('admin/rewards');
        }

        if ($this->input->post()) {
            $data = [
                'nama_reward' => $this->input->post('nama_reward'),
                'deskripsi' => $this->input->post('deskripsi'),
                'poin_dibutuhkan' => (int) $this->input->post('poin_dibutuhkan'),
                'tipe_reward' => $this->input->post('tipe_reward'),
                'nilai_reward' => (float) $this->input->post('nilai_reward'),
                'stok' => $this->input->post('stok') !== '' ? (int) $this->input->post('stok') : null,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'expired_days' => (int) $this->input->post('expired_days') ?: 30
            ];

            if ($this->Reward_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Reward berhasil diupdate.');
                redirect('admin/rewards');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate reward.');
            }
        }

        $data = [
            'page_title' => 'Edit Reward',
            'reward' => $reward
        ];

        $this->render('rewards/form', $data);
    }

    /**
     * Delete reward
     */
    public function delete($id)
    {
        if ($this->Reward_model->delete($id)) {
            $this->session->set_flashdata('success', 'Reward berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus reward.');
        }
        redirect('admin/rewards');
    }

    /**
     * Toggle reward active status
     */
    public function toggle($id)
    {
        $reward = $this->Reward_model->get_by_id($id);
        if ($reward) {
            $this->Reward_model->update($id, ['is_active' => !$reward->is_active]);
            $this->session->set_flashdata('success', 'Status reward berhasil diubah.');
        }
        redirect('admin/rewards');
    }

    /**
     * View reward claims
     */
    public function claims($id = null)
    {
        $this->db->select('rc.*, r.nama_reward, k.nama as nama_member, k.no_hp');
        $this->db->from('reward_claims rc');
        $this->db->join('rewards r', 'r.id_reward = rc.id_reward');
        $this->db->join('konsumen k', 'k.id_konsumen = rc.id_konsumen');

        if ($id) {
            $this->db->where('rc.id_reward', $id);
        }

        $this->db->order_by('rc.created_at', 'DESC');
        $claims = $this->db->get()->result();

        $data = [
            'page_title' => 'Riwayat Klaim Reward',
            'claims' => $claims,
            'reward_id' => $id
        ];

        $this->render('rewards/claims', $data);
    }

    /**
     * Use a claimed reward (mark as used)
     */
    public function use_claim($id_claim)
    {
        $result = $this->Reward_model->use_claim($id_claim, $this->current_user->id_user);

        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('admin/rewards/claims');
    }

    /**
     * Count claims for a reward
     */
    private function _count_claims($id_reward)
    {
        $this->db->where('id_reward', $id_reward);
        return $this->db->count_all_results('reward_claims');
    }
}
