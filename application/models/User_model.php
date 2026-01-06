<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model
 * Model for user authentication and management
 */
class User_model extends CI_Model
{

    protected $table = 'users';
    protected $primary_key = 'id_user';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get user by ID
     * @param int $id User ID
     * @return object|null
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primary_key => $id])->row();
    }

    /**
     * Get user by username
     * @param string $username Username
     * @return object|null
     */
    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }

    /**
     * Get user by email
     * @param string $email Email
     * @return object|null
     */
    public function get_by_email($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Authenticate user
     * @param string $username Username or email
     * @param string $password Plain password
     * @return object|bool User object on success, false on failure
     */
    public function authenticate($username, $password)
    {
        // Try to find user by username or email
        $this->db->where('username', $username);
        $this->db->or_where('email', $username);
        $user = $this->db->get($this->table)->row();

        if (!$user) {
            return false;
        }

        // Check if user is active
        if (!$user->is_active) {
            return false;
        }

        // Verify password
        if (!password_verify($password, $user->password)) {
            return false;
        }

        // Update last login
        $this->update($user->id_user, ['last_login' => date('Y-m-d H:i:s')]);

        return $user;
    }

    /**
     * Get all users with optional filtering
     * @param array $filters Filter options
     * @return array
     */
    public function get_all($filters = [])
    {
        if (isset($filters['role']) && $filters['role']) {
            $this->db->where('role', $filters['role']);
        }

        if (isset($filters['is_active'])) {
            $this->db->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $this->db->group_start();
            $this->db->like('username', $filters['search']);
            $this->db->or_like('nama_lengkap', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->group_end();
        }

        // Exclude master from list for non-master users
        if (isset($filters['exclude_master']) && $filters['exclude_master']) {
            $this->db->where('role !=', 'master');
        }

        $this->db->order_by('created_at', 'DESC');

        return $this->db->get($this->table)->result();
    }

    /**
     * Get users with pagination
     * @param int $limit Limit per page
     * @param int $offset Offset
     * @param array $filters Filter options
     * @return array
     */
    public function get_paginated($limit, $offset, $filters = [])
    {
        if (isset($filters['role']) && $filters['role']) {
            $this->db->where('role', $filters['role']);
        }

        if (isset($filters['is_active'])) {
            $this->db->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $this->db->group_start();
            $this->db->like('username', $filters['search']);
            $this->db->or_like('nama_lengkap', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->group_end();
        }

        if (isset($filters['exclude_master']) && $filters['exclude_master']) {
            $this->db->where('role !=', 'master');
        }

        $this->db->order_by('created_at', 'DESC');

        return $this->db->get($this->table, $limit, $offset)->result();
    }

    /**
     * Count users with filters
     * @param array $filters Filter options
     * @return int
     */
    public function count_all($filters = [])
    {
        if (isset($filters['role']) && $filters['role']) {
            $this->db->where('role', $filters['role']);
        }

        if (isset($filters['is_active'])) {
            $this->db->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $this->db->group_start();
            $this->db->like('username', $filters['search']);
            $this->db->or_like('nama_lengkap', $filters['search']);
            $this->db->or_like('email', $filters['search']);
            $this->db->group_end();
        }

        if (isset($filters['exclude_master']) && $filters['exclude_master']) {
            $this->db->where('role !=', 'master');
        }

        return $this->db->count_all_results($this->table);
    }

    /**
     * Create new user
     * @param array $data User data
     * @return int|bool Insert ID on success, false on failure
     */
    public function create($data)
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Update user
     * @param int $id User ID
     * @param array $data User data
     * @return bool
     */
    public function update($id, $data)
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete user
     * @param int $id User ID
     * @return bool
     */
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if username exists
     * @param string $username Username
     * @param int $exclude_id User ID to exclude
     * @return bool
     */
    public function username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where($this->primary_key . ' !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Check if email exists
     * @param string $email Email
     * @param int $exclude_id User ID to exclude
     * @return bool
     */
    public function email_exists($email, $exclude_id = null)
    {
        if (empty($email))
            return false;

        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where($this->primary_key . ' !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Get users by role
     * @param string $role Role name
     * @return array
     */
    public function get_by_role($role)
    {
        $this->db->where('role', $role);
        $this->db->where('is_active', 1);
        $this->db->order_by('nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Change user password
     * @param int $id User ID
     * @param string $new_password New password
     * @return bool
     */
    public function change_password($id, $new_password)
    {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, [
            'password' => $hash,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get staff users (non-member roles)
     * @return array
     */
    public function get_staff()
    {
        $this->db->where('role !=', 'member');
        $this->db->where('is_active', 1);
        $this->db->order_by('role', 'ASC');
        $this->db->order_by('nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result();
    }

    // =========================================
    // Password Reset Token Methods
    // =========================================

    /**
     * Create password reset token
     * @param string $email User email
     * @return string|bool Token on success, false on failure
     */
    public function create_reset_token($email)
    {
        // Delete any existing tokens for this email
        $this->db->where('email', $email);
        $this->db->delete('password_resets');

        // Generate secure token
        $token = bin2hex(random_bytes(32));

        $data = [
            'email' => $email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('password_resets', $data)) {
            return $token;
        }

        return false;
    }

    /**
     * Verify password reset token
     * Token is valid for 1 hour
     * @param string $token Reset token
     * @return object|bool Reset data on success, false if invalid/expired
     */
    public function verify_reset_token($token)
    {
        $this->db->where('token', $token);
        $reset = $this->db->get('password_resets')->row();

        if (!$reset) {
            return false;
        }

        // Check if token is expired (1 hour = 3600 seconds)
        $created_time = strtotime($reset->created_at);
        $current_time = time();
        $expiry_time = 3600; // 1 hour

        if (($current_time - $created_time) > $expiry_time) {
            // Token expired, delete it
            $this->delete_reset_token($token);
            return false;
        }

        return $reset;
    }

    /**
     * Delete password reset token
     * @param string $token Reset token
     * @return bool
     */
    public function delete_reset_token($token)
    {
        $this->db->where('token', $token);
        return $this->db->delete('password_resets');
    }
}
