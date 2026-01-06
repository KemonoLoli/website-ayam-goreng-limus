<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Dashboard Controller
 * Dashboard, orders, profile, rewards for members
 */
class Dashboard extends Member_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Transaksi_model', 'Reward_model']);
    }

    /**
     * Dashboard - Overview
     */
    public function index()
    {
        // Get recent orders
        $this->db->where('id_konsumen', $this->current_konsumen->id_konsumen);
        $this->db->order_by('tgl_transaksi', 'DESC');
        $this->db->limit(5);
        $recent_orders = $this->db->get('transaksi')->result();

        // Get stats
        $stats = [
            'total_orders' => $this->_count_orders(),
            'total_spent' => $this->current_konsumen->total_transaksi,
            'poin' => $this->current_konsumen->poin,
            'member_since' => $this->current_konsumen->created_at
        ];

        $data = [
            'page_title' => 'Dashboard Member',
            'recent_orders' => $recent_orders,
            'stats' => $stats
        ];

        $this->render('dashboard', $data);
    }

    /**
     * Order History
     */
    public function orders()
    {
        $page = $this->input->get('page') ?: 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $this->db->where('id_konsumen', $this->current_konsumen->id_konsumen);
        $this->db->order_by('tgl_transaksi', 'DESC');
        $this->db->limit($per_page, $offset);
        $orders = $this->db->get('transaksi')->result();

        $total = $this->_count_orders();

        $data = [
            'page_title' => 'Riwayat Pesanan',
            'orders' => $orders,
            'total' => $total,
            'page' => $page,
            'per_page' => $per_page,
            'total_pages' => ceil($total / $per_page)
        ];

        $this->render('orders', $data);
    }

    /**
     * Order Detail
     */
    public function order_detail($id)
    {
        $transaksi = $this->Transaksi_model->get_with_details($id);

        // Verify ownership
        if (!$transaksi || $transaksi->id_konsumen != $this->current_konsumen->id_konsumen) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('member/orders');
        }

        $data = [
            'page_title' => 'Detail Pesanan #' . $transaksi->kode_transaksi,
            'transaksi' => $transaksi
        ];

        $this->render('order_detail', $data);
    }

    /**
     * Profile Page
     */
    public function profile()
    {
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('no_hp', 'No HP', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');

            if ($this->form_validation->run()) {
                $konsumen_data = [
                    'nama' => $this->input->post('nama', true),
                    'no_hp' => $this->input->post('no_hp', true),
                    'email' => $this->input->post('email', true),
                    'alamat' => $this->input->post('alamat', true)
                ];

                $password = $this->input->post('password');

                $result = $this->Konsumen_model->update_member(
                    $this->current_konsumen->id_konsumen,
                    $konsumen_data,
                    $password ?: null
                );

                if ($result) {
                    // Update session name
                    $this->session->set_userdata('member_name', $konsumen_data['nama']);
                    $this->session->set_flashdata('success', 'Profil berhasil diupdate.');
                    redirect('member/profile');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate profil.');
                }
            }
        }

        // Refresh konsumen data
        $konsumen = $this->Konsumen_model->get_with_user($this->current_konsumen->id_konsumen);

        $data = [
            'page_title' => 'Profil Saya',
            'konsumen' => $konsumen
        ];

        $this->render('profile', $data);
    }

    /**
     * Rewards Page
     */
    public function rewards()
    {
        $poin = $this->current_konsumen->poin;

        // Get available rewards
        $rewards = $this->Reward_model->get_available($poin);

        // Get my claims
        $active_claims = $this->Reward_model->get_member_claims($this->current_konsumen->id_konsumen, 'active');
        $used_claims = $this->Reward_model->get_member_claims($this->current_konsumen->id_konsumen, 'used');

        // Get poin history
        $poin_history = $this->Konsumen_model->get_poin_history($this->current_konsumen->id_konsumen, 20);

        $data = [
            'page_title' => 'Poin & Rewards',
            'poin' => $poin,
            'rewards' => $rewards,
            'active_claims' => $active_claims,
            'used_claims' => $used_claims,
            'poin_history' => $poin_history
        ];

        $this->render('rewards', $data);
    }

    /**
     * Claim a reward
     */
    public function claim_reward($id_reward)
    {
        $result = $this->Reward_model->claim($this->current_konsumen->id_konsumen, $id_reward);

        if ($result['success']) {
            $this->session->set_flashdata('success', $result['message'] . ' Kode: ' . $result['kode_klaim']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('member/rewards');
    }

    /**
     * Reorder from history
     */
    public function reorder($id_transaksi)
    {
        $transaksi = $this->Transaksi_model->get_with_details($id_transaksi);

        // Verify ownership
        if (!$transaksi || $transaksi->id_konsumen != $this->current_konsumen->id_konsumen) {
            $this->session->set_flashdata('error', 'Pesanan tidak ditemukan.');
            redirect('member/orders');
        }

        // Store items in session for order page
        $items = [];
        foreach ($transaksi->details as $item) {
            $items[$item->id_menu] = [
                'id' => $item->id_menu,
                'name' => $item->nama_menu,
                'price' => $item->harga_satuan,
                'qty' => $item->qty,
                'note' => $item->catatan
            ];
        }

        $this->session->set_userdata('reorder_items', json_encode(array_values($items)));
        $this->session->set_flashdata('info', 'Item dari pesanan sebelumnya sudah ditambahkan ke keranjang.');
        redirect('order');
    }

    /**
     * Count member orders
     */
    private function _count_orders()
    {
        $this->db->where('id_konsumen', $this->current_konsumen->id_konsumen);
        return $this->db->count_all_results('transaksi');
    }
}
