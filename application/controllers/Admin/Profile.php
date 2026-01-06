<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile Controller
 * User profile management
 */
class Profile extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    /**
     * View/Edit profile
     */
    public function index()
    {
        if ($this->input->post()) {
            $data = [
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp')
            ];

            // Handle photo upload
            if (!empty($_FILES['foto']['name'])) {
                $upload = $this->_upload_photo();
                if ($upload['success']) {
                    $data['foto'] = $upload['file_name'];
                }
            }

            if ($this->User_model->update($this->current_user->id_user, $data)) {
                $this->session->set_flashdata('success', 'Profil berhasil diupdate.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate profil.');
            }

            redirect('admin/profile');
        }

        $data = [
            'page_title' => 'Profil Saya',
            'user' => $this->User_model->get_by_id($this->current_user->id_user)
        ];

        $this->render('profile/index', $data);
    }

    /**
     * Change password
     */
    public function password()
    {
        if ($this->input->post()) {
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            // Validate old password
            if (!password_verify($old_password, $this->current_user->password)) {
                $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
                redirect('admin/profile/password');
            }

            // Validate new password match
            if ($new_password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Konfirmasi password tidak sesuai.');
                redirect('admin/profile/password');
            }

            // Validate minimum length
            if (strlen($new_password) < 6) {
                $this->session->set_flashdata('error', 'Password minimal 6 karakter.');
                redirect('admin/profile/password');
            }

            if ($this->User_model->change_password($this->current_user->id_user, $new_password)) {
                $this->session->set_flashdata('success', 'Password berhasil diubah.');
                redirect('admin/profile');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah password.');
            }

            redirect('admin/profile/password');
        }

        $data = [
            'page_title' => 'Ganti Password'
        ];

        $this->render('profile/password', $data);
    }

    /**
     * Upload photo
     */
    private function _upload_photo()
    {
        $config['upload_path'] = './uploads/users/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = 'user_' . $this->current_user->id_user . '_' . time();

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            return ['success' => true, 'file_name' => $this->upload->data('file_name')];
        }

        return ['success' => false, 'error' => $this->upload->display_errors()];
    }
}
