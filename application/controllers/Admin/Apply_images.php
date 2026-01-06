<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk apply gambar menu secara otomatis
 * Akses via: /admin/apply_images
 */
class Apply_images extends Admin_Controller
{
    protected $allowed_roles = ['master', 'admin'];

    public function index()
    {
        // Mapping nama menu ke gambar
        $image_mappings = [
            // Ayam
            'penyet' => 'ayam_goreng_penyet.png',
            'kremes' => 'ayam_goreng_kremes.png',
            'bakar' => 'ayam_bakar.png',
            'geprek' => 'ayam_geprek.png',

            // Minuman
            'teh' => 'es_teh_manis.png',
            'jeruk' => 'es_jeruk.png',
            'kelapa' => 'es_kelapa_muda.png',
            'alpukat' => 'jus_alpukat.png',
            'jus' => 'jus_alpukat.png',

            // Side dishes
            'tempe' => 'tempe_tahu_goreng.png',
            'tahu' => 'tempe_tahu_goreng.png',
            'nasi' => 'nasi_putih.png',
            'sambal' => 'sambal_terasi.png',
            'lalapan' => 'lalapan_segar.png',
            'telur' => 'telur_goreng.png',
            'mineral' => 'air_mineral.png',
            'air' => 'air_mineral.png',
            'paket' => 'paket_komplit.png',

            // Default
            'ayam' => 'ayam_goreng_kremes.png',
        ];

        // Get all menu items
        $menus = $this->db->get('menu')->result();

        $updated = 0;
        $results = [];

        foreach ($menus as $menu) {
            $nama = strtolower($menu->nama_menu);
            $matched_image = null;

            // Find matching image
            foreach ($image_mappings as $keyword => $image) {
                if (strpos($nama, $keyword) !== false) {
                    $matched_image = $image;
                    break;
                }
            }

            if ($matched_image && $menu->gambar != $matched_image) {
                $this->db->where('id_menu', $menu->id_menu);
                $this->db->update('menu', ['gambar' => $matched_image, 'updated_at' => date('Y-m-d H:i:s')]);
                $updated++;
                $results[] = ['status' => 'updated', 'menu' => $menu->nama_menu, 'image' => $matched_image];
            } else if (!$matched_image) {
                $results[] = ['status' => 'no_match', 'menu' => $menu->nama_menu, 'image' => null];
            } else {
                $results[] = ['status' => 'skipped', 'menu' => $menu->nama_menu, 'image' => $menu->gambar];
            }
        }

        $data = [
            'page_title' => 'Apply Menu Images',
            'results' => $results,
            'updated' => $updated,
            'total' => count($menus)
        ];

        $this->render('tools/apply_images', $data);
    }
}
