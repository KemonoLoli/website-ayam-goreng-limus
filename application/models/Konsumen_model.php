<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsumen_model extends CI_Model
{

    protected $table = 'konsumen';

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_konsumen' => $id])->row();
    }

    public function get_by_hp($no_hp)
    {
        return $this->db->get_where($this->table, ['no_hp' => $no_hp])->row();
    }

    /**
     * Get konsumen by user ID (for member login)
     */
    public function get_by_user_id($id_user)
    {
        return $this->db->get_where($this->table, ['id_user' => $id_user])->row();
    }

    /**
     * Get konsumen by email
     */
    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Get konsumen with linked user data
     */
    public function get_with_user($id)
    {
        $this->db->select('k.*, u.username, u.email as user_email, u.is_active as user_active');
        $this->db->from($this->table . ' k');
        $this->db->join('users u', 'u.id_user = k.id_user', 'left');
        $this->db->where('k.id_konsumen', $id);
        return $this->db->get()->row();
    }

    public function get_all($filters = [])
    {
        if (!empty($filters['tipe'])) {
            $this->db->where('tipe', $filters['tipe']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('nama', $filters['search']);
            $this->db->or_like('no_hp', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->group_end();
        }

        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get all members (tipe = member or vip)
     */
    public function get_members()
    {
        $this->db->select('k.*, u.username, u.is_active as user_active');
        $this->db->from($this->table . ' k');
        $this->db->join('users u', 'u.id_user = k.id_user', 'left');
        $this->db->where_in('k.tipe', ['member', 'vip']);
        $this->db->order_by('k.nama', 'ASC');
        return $this->db->get()->result();
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Create member with user account
     */
    public function create_member($konsumen_data, $password)
    {
        $this->db->trans_start();

        // Create user account first
        $this->load->model('User_model');

        // Generate username from email or phone
        $username = $konsumen_data['email'] ?: $konsumen_data['no_hp'];

        $user_data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nama_lengkap' => $konsumen_data['nama'],
            'email' => $konsumen_data['email'],
            'no_hp' => $konsumen_data['no_hp'],
            'role' => 'member',
            'is_active' => 1
        ];

        $id_user = $this->User_model->create($user_data);

        if ($id_user) {
            // Add user ID to konsumen data
            $konsumen_data['id_user'] = $id_user;
            $konsumen_data['tipe'] = $konsumen_data['tipe'] ?: 'member';
            $konsumen_data['created_at'] = date('Y-m-d H:i:s');

            $this->db->insert($this->table, $konsumen_data);
            $id_konsumen = $this->db->insert_id();
        } else {
            $id_konsumen = false;
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $id_konsumen : false;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_konsumen', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Update member including user data
     */
    public function update_member($id, $konsumen_data, $password = null)
    {
        $konsumen = $this->get_by_id($id);
        if (!$konsumen)
            return false;

        $this->db->trans_start();

        // Update konsumen
        $konsumen_data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id_konsumen', $id);
        $this->db->update($this->table, $konsumen_data);

        // Update user if exists
        if ($konsumen->id_user) {
            $this->load->model('User_model');

            $user_data = [
                'nama_lengkap' => $konsumen_data['nama'],
                'email' => $konsumen_data['email'],
                'no_hp' => $konsumen_data['no_hp'],
            ];

            // Update username if email changed
            if ($konsumen_data['email']) {
                $user_data['username'] = $konsumen_data['email'];
            }

            // Update password if provided
            if ($password) {
                $user_data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->User_model->update($konsumen->id_user, $user_data);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function delete($id)
    {
        $konsumen = $this->get_by_id($id);

        $this->db->trans_start();

        // Delete user account if exists
        if ($konsumen && $konsumen->id_user) {
            $this->load->model('User_model');
            $this->User_model->delete($konsumen->id_user);
        }

        $this->db->where('id_konsumen', $id);
        $this->db->delete($this->table);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Add poin to member with history logging
     */
    public function add_poin($id, $poin, $tipe = 'earn', $referensi_id = null, $referensi_tipe = null, $keterangan = null, $created_by = null)
    {
        $konsumen = $this->get_by_id($id);
        if (!$konsumen)
            return false;

        $saldo_sebelum = $konsumen->poin;
        $saldo_sesudah = $saldo_sebelum + $poin;

        $this->db->trans_start();

        // Update poin
        $this->db->set('poin', 'poin + ' . (int) $poin, false);
        $this->db->where('id_konsumen', $id);
        $this->db->update($this->table);

        // Log history
        $history = [
            'id_konsumen' => $id,
            'poin' => $poin,
            'saldo_sebelum' => $saldo_sebelum,
            'saldo_sesudah' => $saldo_sesudah,
            'tipe' => $tipe,
            'referensi_id' => $referensi_id,
            'referensi_tipe' => $referensi_tipe,
            'keterangan' => $keterangan,
            'created_by' => $created_by,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('poin_history', $history);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Use/redeem poin
     */
    public function use_poin($id, $poin, $referensi_id = null, $referensi_tipe = null, $keterangan = null)
    {
        $konsumen = $this->get_by_id($id);
        if (!$konsumen || $konsumen->poin < $poin)
            return false;

        return $this->add_poin($id, -$poin, 'redeem', $referensi_id, $referensi_tipe, $keterangan);
    }

    /**
     * Get poin history for a member
     */
    public function get_poin_history($id_konsumen, $limit = 50)
    {
        $this->db->select('ph.*, u.nama_lengkap as created_by_name');
        $this->db->from('poin_history ph');
        $this->db->join('users u', 'u.id_user = ph.created_by', 'left');
        $this->db->where('ph.id_konsumen', $id_konsumen);
        $this->db->order_by('ph.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function add_transaksi($id, $total)
    {
        $this->db->set('total_transaksi', 'total_transaksi + ' . (float) $total, false);
        $this->db->where('id_konsumen', $id);
        return $this->db->update($this->table);
    }

    /**
     * Calculate poin from transaction total
     */
    public function calculate_poin($total)
    {
        // Get settings
        $this->db->where('setting_key', 'poin_per_transaksi');
        $setting = $this->db->get('settings')->row();
        $poin_per = $setting ? (int) $setting->setting_value : 10000;

        $this->db->where('setting_key', 'poin_multiplier');
        $setting = $this->db->get('settings')->row();
        $multiplier = $setting ? (int) $setting->setting_value : 1;

        // Calculate: every poin_per gets multiplier poin
        $poin = floor($total / $poin_per) * $multiplier;

        return (int) $poin;
    }
}
