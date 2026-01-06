-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 06, 2026 at 03:52 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ayamgoreng_limus`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) UNSIGNED NOT NULL,
  `id_karyawan` int(11) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `jam_mulai_istirahat` time DEFAULT NULL,
  `jam_selesai_istirahat` time DEFAULT NULL,
  `total_jam_kerja` decimal(5,2) DEFAULT NULL,
  `is_terlambat` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('hadir','izin','sakit','alpha','selesai') NOT NULL DEFAULT 'hadir',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_karyawan`, `tanggal`, `jam_masuk`, `jam_pulang`, `jam_mulai_istirahat`, `jam_selesai_istirahat`, `total_jam_kerja`, `is_terlambat`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-12-13', '13:56:50', '14:05:47', NULL, NULL, '0.15', 0, 'hadir', NULL, '2025-12-13 13:56:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE `bahan` (
  `id_bahan` int(11) UNSIGNED NOT NULL,
  `kode_bahan` varchar(20) NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `kategori_bahan` varchar(50) DEFAULT NULL,
  `satuan` varchar(20) NOT NULL,
  `stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stok_minimum` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga_per_satuan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id_bahan`, `kode_bahan`, `nama_bahan`, `kategori_bahan`, `satuan`, `stok`, `stok_minimum`, `harga_per_satuan`, `created_at`, `updated_at`) VALUES
(1, 'BH00001', 'Ayam Potong', 'Protein', 'ekor', '60.00', '20.00', '35000.00', '2025-12-13 15:13:45', '2025-12-13 18:11:49'),
(2, 'BH00002', 'Beras Premium', 'Karbohidrat', 'kg', '100.00', '25.00', '15000.00', '2025-12-13 15:13:45', NULL),
(3, 'BH00003', 'Minyak Goreng', 'Minyak', 'liter', '30.00', '10.00', '18000.00', '2025-12-13 15:13:45', NULL),
(4, 'BH00004', 'Tempe', 'Protein', 'papan', '25.00', '10.00', '8000.00', '2025-12-13 15:13:45', NULL),
(5, 'BH00005', 'Tahu', 'Protein', 'papan', '25.00', '10.00', '10000.00', '2025-12-13 15:13:45', NULL),
(6, 'BH00006', 'Telur Ayam', 'Protein', 'kg', '20.00', '5.00', '28000.00', '2025-12-13 15:13:45', NULL),
(7, 'BH00007', 'Gula Pasir', 'Bumbu', 'kg', '15.00', '5.00', '16000.00', '2025-12-13 15:13:45', NULL),
(8, 'BH00008', 'Teh Celup', 'Minuman', 'box', '10.00', '3.00', '25000.00', '2025-12-13 15:13:45', NULL),
(9, 'BH00009', 'Jeruk', 'Buah', 'kg', '10.00', '3.00', '20000.00', '2025-12-13 15:13:45', NULL),
(10, 'BH00010', 'Cabai Rawit', 'Bumbu', 'kg', '5.00', '2.00', '45000.00', '2025-12-13 15:13:45', NULL),
(11, 'BH00011', 'Bawang Merah', 'Bumbu', 'kg', '8.00', '3.00', '35000.00', '2025-12-13 15:13:45', NULL),
(12, 'BH00012', 'Bawang Putih', 'Bumbu', 'kg', '8.00', '3.00', '40000.00', '2025-12-13 15:13:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id_inventaris` int(11) UNSIGNED NOT NULL,
  `id_bahan` int(11) UNSIGNED NOT NULL,
  `jenis_pergerakan` enum('masuk','keluar') NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `stok_sebelum` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stok_sesudah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tgl_pergerakan` datetime NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_pembelian` int(11) UNSIGNED DEFAULT NULL,
  `id_transaksi` int(11) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) UNSIGNED NOT NULL,
  `nip` varchar(20) NOT NULL,
  `id_user` int(11) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tgl_bergabung` date NOT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `gaji_pokok` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('aktif','cuti','resign','phk') NOT NULL DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nip`, `id_user`, `nama`, `jabatan`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `alamat`, `no_hp`, `email`, `tgl_bergabung`, `tgl_keluar`, `gaji_pokok`, `status`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'EMP0001', 2, 'Pemilik Warung', 'Owner', 'L', NULL, '1980-01-15', NULL, NULL, NULL, '2020-01-01', NULL, '0.00', 'aktif', NULL, '2025-12-13 15:13:45', NULL),
(2, 'EMP0002', 3, 'Admin Operasional', 'Admin', 'P', NULL, '1990-05-20', NULL, NULL, NULL, '2021-06-01', NULL, '3500000.00', 'aktif', NULL, '2025-12-13 15:13:45', NULL),
(3, 'EMP0003', 4, 'Kasir Utama', 'Kasir', 'P', NULL, '1995-08-10', NULL, NULL, NULL, '2022-01-15', NULL, '2800000.00', 'aktif', NULL, '2025-12-13 15:13:45', NULL),
(4, 'EMP0004', NULL, 'Koki Ayam', 'Koki', 'L', NULL, '1988-03-25', NULL, NULL, NULL, '2021-02-01', NULL, '3200000.00', 'aktif', NULL, '2025-12-13 15:13:45', NULL),
(5, 'EMP0005', NULL, 'Pelayan 1', 'Waiter', 'P', NULL, '2000-11-05', NULL, NULL, NULL, '2023-03-01', NULL, '2500000.00', 'aktif', NULL, '2025-12-13 15:13:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id_kategori` int(11) UNSIGNED NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_menu`
--

INSERT INTO `kategori_menu` (`id_kategori`, `nama_kategori`, `deskripsi`, `urutan`, `is_active`, `created_at`) VALUES
(1, 'Ayam Goreng', 'Menu ayam goreng dan penyet', 1, 1, '2025-12-13 15:13:45'),
(2, 'Lauk Pauk', 'Tempe, tahu, telur, dan lainnya', 2, 1, '2025-12-13 15:13:45'),
(3, 'Minuman', 'Es, jus, dan minuman segar', 3, 1, '2025-12-13 15:13:45'),
(4, 'Paket Hemat', 'Paket nasi lengkap hemat', 4, 1, '2025-12-13 15:13:45'),
(5, 'Tambahan', 'Nasi, sambal, lalapan', 5, 1, '2025-12-13 15:13:45');

-- --------------------------------------------------------

--
-- Table structure for table `konsumen`
--

CREATE TABLE `konsumen` (
  `id_konsumen` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tipe` enum('walk-in','member','vip') NOT NULL DEFAULT 'walk-in',
  `poin` int(11) NOT NULL DEFAULT 0,
  `total_transaksi` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konsumen`
--

INSERT INTO `konsumen` (`id_konsumen`, `nama`, `no_hp`, `email`, `alamat`, `tipe`, `poin`, `total_transaksi`, `created_at`, `updated_at`) VALUES
(1, 'Pelanggan Umum', NULL, NULL, NULL, 'walk-in', 0, 0, '2025-12-13 15:13:45', NULL),
(2, 'Budi Santoso', '081111222333', NULL, NULL, 'member', 150, 0, '2025-12-13 15:13:45', NULL),
(3, 'Siti Rahayu', '082222333444', NULL, NULL, 'member', 85, 0, '2025-12-13 15:13:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) UNSIGNED NOT NULL,
  `kode_menu` varchar(20) NOT NULL,
  `id_kategori` int(11) UNSIGNED DEFAULT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `harga_promo` decimal(12,2) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `jenis` enum('makanan','minuman','lainnya') NOT NULL DEFAULT 'makanan',
  `is_bestseller` tinyint(1) NOT NULL DEFAULT 0,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `stok_terbatas` tinyint(1) NOT NULL DEFAULT 0,
  `stok` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `kode_menu`, `id_kategori`, `nama_menu`, `deskripsi`, `harga`, `harga_promo`, `gambar`, `jenis`, `is_bestseller`, `is_aktif`, `stok_terbatas`, `stok`, `created_at`, `updated_at`) VALUES
(1, 'MN00001', 1, 'Ayam Goreng Penyet', 'Ayam goreng gurih dengan sambal terasi pedas dan lalapan segar', '22000.00', NULL, 'ayam_goreng_penyet.png', 'makanan', 1, 1, 0, NULL, '2025-12-13 15:13:45', NULL),
(2, 'MN00002', 1, 'Ayam Goreng Kremes', 'Ayam goreng dengan taburan kremes gurih renyah', '24000.00', NULL, 'ayam_goreng_kremes.png', 'makanan', 1, 1, 0, NULL, '2025-12-13 15:13:45', NULL),
(3, 'MN00003', 1, 'Ayam Bakar', 'Ayam bakar bumbu kecap dengan sambal', '25000.00', NULL, 'ayam_bakar.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', NULL),
(4, 'MN00004', 1, 'Sayap Ayam Goreng (2pcs)', 'Dua potong sayap ayam goreng', '15000.00', NULL, 'ayam_goreng_kremes.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(5, 'MN00005', 2, 'Tempe Goreng (3pcs)', 'Tiga potong tempe goreng crispy', '5000.00', NULL, 'tempe_tahu_goreng.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', NULL),
(6, 'MN00006', 2, 'Tahu Goreng (3pcs)', 'Tiga potong tahu goreng', '5000.00', NULL, 'tempe_tahu_goreng.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:42:53'),
(7, 'MN00007', 2, 'Telur Ceplok', 'Telur ceplok matang sempurna', '6000.00', NULL, 'telur_goreng.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:39:31'),
(8, 'MN00008', 2, 'Telur Dadar', 'Telur dadar tebal', '7000.00', NULL, 'telur_goreng.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:39:31'),
(9, 'MN00009', 3, 'Es Teh Manis', 'Teh manis dingin menyegarkan', '5000.00', NULL, 'es_teh_manis.png', 'minuman', 1, 1, 0, NULL, '2025-12-13 15:13:45', NULL),
(10, 'MN00010', 3, 'Es Jeruk', 'Perasan jeruk asli segar', '8000.00', NULL, 'es_jeruk.png', 'minuman', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(11, 'MN00011', 3, 'Teh Hangat', 'Teh hangat manis', '4000.00', NULL, 'es_teh_manis.png', 'minuman', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(12, 'MN00012', 3, 'Air Mineral', 'Air mineral botol', '4000.00', NULL, 'air_mineral.png', 'minuman', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:46:42'),
(13, 'MN00013', 3, 'Es Kelapa Muda', 'Kelapa muda segar', '12000.00', NULL, 'es_kelapa_muda.png', 'minuman', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(14, 'MN00014', 4, 'Paket Nasi + Tempe Tahu', 'Nasi putih + tempe + tahu goreng', '12000.00', NULL, 'tempe_tahu_goreng.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(15, 'MN00015', 4, 'Paket Ayam + Nasi + Es Teh', 'Ayam goreng + nasi + es teh manis', '28000.00', '25000.00', 'es_teh_manis.png', 'makanan', 1, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(16, 'MN00016', 4, 'Paket Komplit', 'Ayam + nasi + tempe + tahu + es teh', '35000.00', '32000.00', 'paket_komplit.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:46:42'),
(17, 'MN00017', 5, 'Nasi Putih', 'Nasi putih hangat', '5000.00', NULL, 'nasi_putih.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', NULL),
(18, 'MN00018', 5, 'Lalapan', 'Timun, kemangi, kol', '3000.00', NULL, 'lalapan_segar.png', 'makanan', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00'),
(19, 'MN00019', 5, 'Sambal Extra', 'Sambal terasi ekstra', '2000.00', NULL, 'sambal_terasi.png', 'lainnya', 0, 1, 0, NULL, '2025-12-13 15:13:45', '2025-12-13 11:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) UNSIGNED NOT NULL,
  `kode_pembelian` varchar(50) NOT NULL,
  `id_supplier` int(11) UNSIGNED DEFAULT NULL,
  `id_petugas` int(11) UNSIGNED DEFAULT NULL,
  `tgl_pembelian` datetime NOT NULL,
  `tgl_diterima` datetime DEFAULT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `status` enum('dipesan','diterima','dibatalkan') NOT NULL DEFAULT 'dipesan',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id_detail` int(11) UNSIGNED NOT NULL,
  `id_pembelian` int(11) UNSIGNED NOT NULL,
  `id_bahan` int(11) UNSIGNED NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penggajian`
--

CREATE TABLE `penggajian` (
  `id_penggajian` int(11) UNSIGNED NOT NULL,
  `id_karyawan` int(11) UNSIGNED NOT NULL,
  `bulan` char(2) NOT NULL,
  `tahun` char(4) NOT NULL,
  `gaji_pokok` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_hari_kerja` int(11) NOT NULL DEFAULT 0,
  `tunjangan_hadir` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tunjangan_transport` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tunjangan_makan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tunjangan_lainnya` decimal(12,2) NOT NULL DEFAULT 0.00,
  `potongan_absen` decimal(12,2) NOT NULL DEFAULT 0.00,
  `potongan_terlambat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `potongan_lainnya` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_tunjangan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_potongan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gaji_bersih` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('draft','disetujui','dibayar') NOT NULL DEFAULT 'draft',
  `tgl_disetujui` datetime DEFAULT NULL,
  `tgl_dibayar` datetime DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penggajian`
--

INSERT INTO `penggajian` (`id_penggajian`, `id_karyawan`, `bulan`, `tahun`, `gaji_pokok`, `total_hari_kerja`, `tunjangan_hadir`, `tunjangan_transport`, `tunjangan_makan`, `tunjangan_lainnya`, `potongan_absen`, `potongan_terlambat`, `potongan_lainnya`, `total_tunjangan`, `total_potongan`, `gaji_bersih`, `status`, `tgl_disetujui`, `tgl_dibayar`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 4, '12', '2025', '3200000.00', 0, '0.00', '0.00', '0.00', '0.00', '1300000.00', '0.00', '0.00', '0.00', '1300000.00', '0.00', 'draft', NULL, NULL, NULL, '2025-12-13 10:44:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id_setting` int(11) UNSIGNED NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(50) NOT NULL DEFAULT 'general',
  `description` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id_setting`, `setting_key`, `setting_value`, `setting_group`, `description`, `updated_at`) VALUES
(1, 'nama_restoran', 'Warung Ayam Goreng Limus Regency', 'general', 'Nama restoran', NULL),
(2, 'alamat', 'Jl. Blitar No.21 Blok E1, RT.1/RW.6, Limusnunggal, Cileungsi, Bogor 16820', 'general', 'Alamat lengkap', NULL),
(3, 'telepon', '0812-3456-7890', 'general', 'Nomor telepon', NULL),
(4, 'email', 'warunglimus@email.com', 'general', 'Email', NULL),
(5, 'pajak_persen', '0', 'transaksi', 'Persentase pajak (%)', NULL),
(6, 'diskon_member', '5', 'transaksi', 'Diskon member (%)', NULL),
(7, 'ongkir_default', '10000', 'transaksi', 'Ongkir default', NULL),
(8, 'jam_buka', '10:00', 'operasional', 'Jam buka', NULL),
(9, 'jam_tutup', '22:00', 'operasional', 'Jam tutup', NULL),
(10, 'hari_kerja', '26', 'hr', 'Hari kerja per bulan', NULL),
(11, 'tunjangan_hadir_min', '22', 'hr', 'Min hari untuk dapat tunjangan hadir', NULL),
(12, 'potongan_per_hari', '50000', 'hr', 'Potongan per hari alpha', NULL),
(13, 'potongan_terlambat', '25000', 'hr', 'Potongan per keterlambatan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) UNSIGNED NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kontak`, `email`, `alamat`, `keterangan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'PT Ayam Segar Jaya', '081234567890', NULL, 'Pasar Cileungsi, Bogor', NULL, 1, '2025-12-13 15:13:45', NULL),
(2, 'Toko Bumbu Dapur Ibu', '082345678901', NULL, 'Jl. Raya Cileungsi No. 45', NULL, 1, '2025-12-13 15:13:45', NULL),
(3, 'UD Sayur Mayur Segar', '083456789012', NULL, 'Pasar Limus, Cileungsi', NULL, 1, '2025-12-13 15:13:45', NULL),
(4, 'Distributor Minyak Goreng', '084567890123', NULL, 'Gudang Cibubur', NULL, 1, '2025-12-13 15:13:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `tipe_pemesanan` enum('dinein','takeaway','delivery') NOT NULL DEFAULT 'dinein',
  `no_meja` varchar(10) DEFAULT NULL,
  `id_kasir` int(11) UNSIGNED DEFAULT NULL,
  `id_konsumen` int(11) UNSIGNED DEFAULT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `no_hp_pelanggan` varchar(20) DEFAULT NULL,
  `alamat_pengiriman` text DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `diskon_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
  `diskon_nominal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `pajak` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ongkir` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `bayar` decimal(12,2) NOT NULL DEFAULT 0.00,
  `kembalian` decimal(12,2) NOT NULL DEFAULT 0.00,
  `metode_pembayaran` enum('cash','qris','ewallet','transfer') NOT NULL DEFAULT 'cash',
  `status` enum('pending','diproses','dikirim','selesai','batal') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kode_transaksi`, `tgl_transaksi`, `tipe_pemesanan`, `no_meja`, `id_kasir`, `id_konsumen`, `nama_pelanggan`, `no_hp_pelanggan`, `alamat_pengiriman`, `subtotal`, `diskon_persen`, `diskon_nominal`, `pajak`, `ongkir`, `total`, `bayar`, `kembalian`, `metode_pembayaran`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'LMR-251210A001', '2025-12-10 11:30:00', 'dinein', '3', 3, NULL, 'Andi', NULL, NULL, '50000.00', '0.00', '0.00', '0.00', '0.00', '50000.00', '50000.00', '0.00', 'cash', 'selesai', NULL, '2025-12-13 15:13:45', NULL),
(2, 'LMR-251210A002', '2025-12-10 12:15:00', 'takeaway', NULL, 3, NULL, 'Budi', NULL, NULL, '32000.00', '0.00', '0.00', '0.00', '0.00', '32000.00', '50000.00', '18000.00', 'cash', 'selesai', NULL, '2025-12-13 15:13:45', NULL),
(3, 'TRX202512130001', '2025-12-13 13:09:48', 'dinein', '5', 3, NULL, '', '', '', '25000.00', '0.00', '0.00', '0.00', '0.00', '25000.00', '25000.00', '0.00', 'qris', 'selesai', '', '2025-12-13 13:09:48', NULL),
(4, 'TRX202512130002', '2025-12-13 13:12:51', 'dinein', '5', 3, NULL, '', '', '', '9000.00', '0.00', '0.00', '0.00', '0.00', '9000.00', '9000.00', '0.00', 'qris', 'selesai', '', '2025-12-13 13:12:51', NULL),
(5, 'TRX202512130003', '2025-12-13 14:31:37', 'dinein', '', NULL, NULL, '', '', '', '13000.00', '0.00', '0.00', '0.00', '0.00', '13000.00', '13000.00', '0.00', 'qris', 'selesai', '', '2025-12-13 14:31:37', NULL),
(6, 'LMR-2601063B91', '2026-01-06 15:36:07', 'dinein', '', NULL, NULL, 'fani', '086700000', '', '49000.00', '0.00', '0.00', '0.00', '0.00', '49000.00', '0.00', '0.00', 'cash', 'pending', 'tidak pedas', '2026-01-06 15:36:07', NULL),
(7, 'LMR-2601067D8C', '2026-01-06 15:37:51', 'dinein', '2', NULL, NULL, 'aryo', '0812345678', '', '24000.00', '0.00', '0.00', '0.00', '0.00', '24000.00', '0.00', '0.00', 'cash', 'pending', 'pedas', '2026-01-06 15:37:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_detail` int(11) UNSIGNED NOT NULL,
  `id_transaksi` int(11) UNSIGNED NOT NULL,
  `id_menu` int(11) UNSIGNED DEFAULT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `harga_satuan` decimal(12,2) NOT NULL,
  `diskon` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_harga` decimal(12,2) NOT NULL,
  `catatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id_detail`, `id_transaksi`, `id_menu`, `nama_menu`, `qty`, `harga_satuan`, `diskon`, `total_harga`, `catatan`) VALUES
(1, 1, 1, 'Ayam Goreng Penyet', 2, '22000.00', '0.00', '44000.00', NULL),
(2, 1, 9, 'Es Teh Manis', 2, '5000.00', '0.00', '10000.00', NULL),
(3, 2, 15, 'Paket Ayam + Nasi + Es Teh', 1, '25000.00', '0.00', '25000.00', NULL),
(4, 2, 6, 'Tahu Goreng (3pcs)', 1, '5000.00', '0.00', '5000.00', NULL),
(5, 3, 3, 'Ayam Bakar', 1, '25000.00', '0.00', '25000.00', ''),
(6, 4, 12, 'Air Mineral', 1, '4000.00', '0.00', '4000.00', ''),
(7, 4, 6, 'Tahu Goreng (3pcs)', 1, '5000.00', '0.00', '5000.00', ''),
(8, 5, 6, 'Tahu Goreng (3pcs)', 1, '5000.00', '0.00', '5000.00', ''),
(9, 5, 10, 'Es Jeruk', 1, '8000.00', '0.00', '8000.00', ''),
(10, 6, 2, 'Ayam Goreng Kremes', 1, '24000.00', '0.00', '24000.00', ''),
(11, 6, 3, 'Ayam Bakar', 1, '25000.00', '0.00', '25000.00', ''),
(12, 7, 2, 'Ayam Goreng Kremes', 1, '24000.00', '0.00', '24000.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `role` enum('master','owner','admin','kasir','koki','waiter','driver','member') NOT NULL DEFAULT 'kasir',
  `foto` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `role`, `foto`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'master', '$2y$10$Yvi5FG/8tlAaqXGeWl81qOoBdAc9E5R//6H7fvAMfD1sEzDfxbRPC', 'Master Administrator', 'master@gmail.com', NULL, 'master', NULL, 1, '2026-01-06 15:15:35', '2025-12-13 15:13:45', '2026-01-06 15:15:35'),
(2, 'owner', '$2y$10$Yvi5FG/8tlAaqXGeWl81qOoBdAc9E5R//6H7fvAMfD1sEzDfxbRPC', 'Pemilik Warung', 'owner@gmail.com', '', 'owner', NULL, 1, NULL, '2025-12-13 15:13:45', '2026-01-06 15:16:59'),
(3, 'admin', '$2y$10$Yvi5FG/8tlAaqXGeWl81qOoBdAc9E5R//6H7fvAMfD1sEzDfxbRPC', 'Admin Operasional', 'admin@gmail.com', NULL, 'admin', NULL, 1, '2026-01-06 14:26:11', '2025-12-13 15:13:45', '2026-01-06 14:26:11'),
(4, 'kasir1', '$2y$10$pkMl0e/p7IyUz4vEVaHmsOfx9QfFEOxXSuRZqjFiDoVZrGLGrTy8.', 'Kasir Utama', 'kasir1@gmail.com', NULL, 'kasir', NULL, 1, '2026-01-06 15:51:50', '2025-12-13 15:13:45', '2026-01-06 15:51:50'),
(5, 'koki1', '$2y$10$bBC9tSV.xXfud0UIW9gNPukLstgf0SpeoMJfk0/Jwzvq3MeSg/.8q', 'dzaky rofyan', 'koki1@gmail.com', '081222222222', 'koki', NULL, 1, NULL, '2026-01-06 15:16:44', '2026-01-06 15:16:44'),
(6, 'waiter1', '$2y$10$UMQII10p/t693W3grnpGKu0qHtNL6f1565gmXoU8Veokg8YfHtE4S', 'michiko', 'waiter1@gmail.com', '08155555555', 'waiter', NULL, 1, NULL, '2026-01-06 15:17:45', '2026-01-06 15:17:45'),
(7, 'driver1', '$2y$10$WO2KdC9ayhC6GCJGyYGmUuy.4hS3YSSyPaqNoQiTPpVPML0bpoZ2S', 'yasser arafat', 'driver1@gmail.com', '0878888888', 'driver', NULL, 1, NULL, '2026-01-06 15:23:18', '2026-01-06 15:23:18'),
(8, 'member1', '$2y$10$4jEPufd4WE8pRfxrwTrICe0Wx2sLmHPTHwebpQkPsKSl9FqGfIxC.', 'sya', 'member1@gmail.com', '08133333333', 'member', NULL, 1, '2026-01-06 15:33:05', '2026-01-06 15:24:01', '2026-01-06 15:33:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD UNIQUE KEY `uk_karyawan_tanggal` (`id_karyawan`,`tanggal`),
  ADD KEY `idx_tanggal` (`tanggal`);

--
-- Indexes for table `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id_bahan`),
  ADD UNIQUE KEY `uk_kode` (`kode_bahan`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id_inventaris`),
  ADD KEY `idx_bahan` (`id_bahan`),
  ADD KEY `idx_tanggal` (`tgl_pergerakan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `uk_nip` (`nip`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`id_konsumen`),
  ADD KEY `idx_hp` (`no_hp`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD UNIQUE KEY `uk_kode` (`kode_menu`),
  ADD KEY `idx_kategori` (`id_kategori`),
  ADD KEY `idx_aktif` (`is_aktif`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD UNIQUE KEY `uk_kode` (`kode_pembelian`),
  ADD KEY `idx_supplier` (`id_supplier`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `idx_pembelian` (`id_pembelian`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id_penggajian`),
  ADD UNIQUE KEY `uk_periode` (`id_karyawan`,`bulan`,`tahun`),
  ADD KEY `idx_periode` (`bulan`,`tahun`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id_setting`),
  ADD UNIQUE KEY `uk_key` (`setting_key`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `uk_kode` (`kode_transaksi`),
  ADD KEY `idx_tanggal` (`tgl_transaksi`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_kasir` (`id_kasir`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `idx_transaksi` (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uk_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id_bahan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id_inventaris` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id_kategori` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `konsumen`
--
ALTER TABLE `konsumen`
  MODIFY `id_konsumen` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id_detail` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id_penggajian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id_setting` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id_detail` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
