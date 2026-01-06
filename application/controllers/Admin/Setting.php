<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Setting Controller
 * Application settings management
 */
class Setting extends Admin_Controller
{
    protected $allowed_roles = ['master', 'owner'];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Settings page
     */
    public function index()
    {
        if ($this->input->post()) {
            $settings = $this->input->post('settings');

            foreach ($settings as $key => $value) {
                $this->_update_setting($key, $value);
            }

            $this->session->set_flashdata('success', 'Pengaturan berhasil disimpan.');
            redirect('admin/setting');
        }

        $data = [
            'page_title' => 'Pengaturan',
            'settings' => $this->_get_all_settings()
        ];

        $this->render('setting/index', $data);
    }

    /**
     * Get all settings
     */
    private function _get_all_settings()
    {
        $query = $this->db->get('settings');
        $settings = [];

        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }

        return $settings;
    }

    /**
     * Update single setting
     */
    private function _update_setting($key, $value)
    {
        $this->db->where('setting_key', $key);
        $exists = $this->db->count_all_results('settings') > 0;

        if ($exists) {
            $this->db->where('setting_key', $key);
            $this->db->update('settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->db->insert('settings', [
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_group' => 'general',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
