<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Admin_Controller
{

    protected $allowed_roles = ['master', 'owner', 'admin'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Menu_model', 'Kategori_model']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $filters = [
            'id_kategori' => $this->input->get('kategori'),
            'jenis' => $this->input->get('jenis'),
            'search' => $this->input->get('search')
        ];

        $data = [
            'page_title' => 'Daftar Menu',
            'breadcrumbs' => ['Menu' => ''],
            'menus' => $this->Menu_model->get_all($filters),
            'categories' => $this->Kategori_model->get_all(),
            'filters' => $filters
        ];

        $this->render('menu/index', $data);
    }

    public function create()
    {
        $data = [
            'page_title' => 'Tambah Menu',
            'breadcrumbs' => ['Menu' => admin_url('menu'), 'Tambah' => ''],
            'categories' => $this->Kategori_model->dropdown()
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

            if ($this->form_validation->run()) {
                $jenis = $this->input->post('jenis', true) ?: 'makanan';
                $insert = [
                    'kode_menu' => $this->Menu_model->generate_kode($jenis),
                    'id_kategori' => $this->input->post('id_kategori', true) ?: null,
                    'nama_menu' => $this->input->post('nama_menu', true),
                    'deskripsi' => $this->input->post('deskripsi', true),
                    'harga' => $this->input->post('harga', true),
                    'harga_promo' => $this->input->post('harga_promo', true) ?: null,
                    'jenis' => $jenis,
                    'is_bestseller' => $this->input->post('is_bestseller') ? 1 : 0,
                    'is_aktif' => $this->input->post('is_aktif') ? 1 : 0
                ];

                // Handle image upload
                if ($_FILES['gambar']['name']) {
                    $upload = $this->_upload_image();
                    if ($upload['status']) {
                        $insert['gambar'] = $upload['file_name'];
                    }
                }

                if ($this->Menu_model->create($insert)) {
                    $this->session->set_flashdata('success', 'Menu berhasil ditambahkan.');
                    redirect('admin/menu');
                }
            }
        }

        $this->render('menu/form', $data);
    }

    public function edit($id)
    {
        $menu = $this->Menu_model->get_by_id($id);
        if (!$menu)
            show_404();

        $data = [
            'page_title' => 'Edit Menu',
            'breadcrumbs' => ['Menu' => admin_url('menu'), 'Edit' => ''],
            'menu' => $menu,
            'categories' => $this->Kategori_model->dropdown()
        ];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

            if ($this->form_validation->run()) {
                $update = [
                    'id_kategori' => $this->input->post('id_kategori', true) ?: null,
                    'nama_menu' => $this->input->post('nama_menu', true),
                    'deskripsi' => $this->input->post('deskripsi', true),
                    'harga' => $this->input->post('harga', true),
                    'harga_promo' => $this->input->post('harga_promo', true) ?: null,
                    'jenis' => $this->input->post('jenis', true),
                    'is_bestseller' => $this->input->post('is_bestseller') ? 1 : 0,
                    'is_aktif' => $this->input->post('is_aktif') ? 1 : 0
                ];

                if ($_FILES['gambar']['name']) {
                    $upload = $this->_upload_image();
                    if ($upload['status']) {
                        $update['gambar'] = $upload['file_name'];
                        // Delete old image
                        if ($menu->gambar && file_exists('./uploads/menu/' . $menu->gambar)) {
                            unlink('./uploads/menu/' . $menu->gambar);
                        }
                    }
                }

                if ($this->Menu_model->update($id, $update)) {
                    $this->session->set_flashdata('success', 'Menu berhasil diperbarui.');
                    redirect('admin/menu');
                }
            }
        }

        $this->render('menu/form', $data);
    }

    public function delete($id)
    {
        $menu = $this->Menu_model->get_by_id($id);
        if (!$menu)
            show_404();

        if ($this->Menu_model->delete($id)) {
            if ($menu->gambar && file_exists('./uploads/menu/' . $menu->gambar)) {
                unlink('./uploads/menu/' . $menu->gambar);
            }
            $this->session->set_flashdata('success', 'Menu berhasil dihapus.');
        }

        redirect('admin/menu');
    }

    public function toggle($id)
    {
        if ($this->Menu_model->toggle_status($id)) {
            $this->session->set_flashdata('success', 'Status menu diubah.');
        }
        redirect('admin/menu');
    }

    private function _upload_image()
    {
        $config = [
            'upload_path' => './uploads/menu/',
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size' => 2048,
            'encrypt_name' => true
        ];

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('gambar')) {
            return ['status' => true, 'file_name' => $this->upload->data('file_name')];
        }

        return ['status' => false, 'error' => $this->upload->display_errors()];
    }
}
