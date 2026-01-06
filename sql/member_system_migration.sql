-- =========================================================
-- MIGRATION: Member System
-- =========================================================
-- File: member_system_migration.sql
-- Date: 2026-01-06
-- Description: Adds member login, rewards, and poin history tables
-- =========================================================

-- =========================================================
-- 1. Add id_user column to konsumen table for user linking
-- =========================================================
ALTER TABLE `konsumen` 
ADD COLUMN `id_user` INT(11) UNSIGNED DEFAULT NULL AFTER `id_konsumen`,
ADD KEY `idx_user` (`id_user`);

-- =========================================================
-- 2. Table: rewards (Daftar Rewards yang bisa ditukar)
-- =========================================================
CREATE TABLE IF NOT EXISTS `rewards` (
  `id_reward` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_reward` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT DEFAULT NULL,
  `poin_dibutuhkan` INT(11) NOT NULL DEFAULT 0,
  `tipe_reward` ENUM('diskon_nominal','diskon_persen','free_item','other') NOT NULL DEFAULT 'diskon_nominal',
  `nilai_reward` DECIMAL(12,2) NOT NULL DEFAULT 0 COMMENT 'Nominal diskon atau persen',
  `id_menu` INT(11) UNSIGNED DEFAULT NULL COMMENT 'Untuk tipe free_item',
  `stok` INT(11) DEFAULT NULL COMMENT 'NULL = unlimited',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `tanggal_mulai` DATE DEFAULT NULL,
  `tanggal_selesai` DATE DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id_reward`),
  KEY `idx_active` (`is_active`),
  KEY `idx_poin` (`poin_dibutuhkan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- 3. Table: poin_history (Log pergerakan poin)
-- =========================================================
CREATE TABLE IF NOT EXISTS `poin_history` (
  `id_history` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_konsumen` INT(11) UNSIGNED NOT NULL,
  `poin` INT(11) NOT NULL COMMENT 'Positif = tambah, Negatif = kurang',
  `saldo_sebelum` INT(11) NOT NULL DEFAULT 0,
  `saldo_sesudah` INT(11) NOT NULL DEFAULT 0,
  `tipe` ENUM('earn','redeem','adjust','bonus','expired') NOT NULL DEFAULT 'earn',
  `referensi_id` INT(11) UNSIGNED DEFAULT NULL COMMENT 'ID transaksi atau reward',
  `referensi_tipe` VARCHAR(50) DEFAULT NULL COMMENT 'transaksi, reward, manual',
  `keterangan` VARCHAR(255) DEFAULT NULL,
  `created_by` INT(11) UNSIGNED DEFAULT NULL COMMENT 'ID user yang melakukan (untuk adjust)',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_history`),
  KEY `idx_konsumen` (`id_konsumen`),
  KEY `idx_tipe` (`tipe`),
  KEY `idx_tanggal` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- 4. Table: reward_claims (Log klaim reward)
-- =========================================================
CREATE TABLE IF NOT EXISTS `reward_claims` (
  `id_claim` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_konsumen` INT(11) UNSIGNED NOT NULL,
  `id_reward` INT(11) UNSIGNED NOT NULL,
  `poin_digunakan` INT(11) NOT NULL,
  `kode_klaim` VARCHAR(20) NOT NULL,
  `status` ENUM('active','used','expired') NOT NULL DEFAULT 'active',
  `id_transaksi` INT(11) UNSIGNED DEFAULT NULL COMMENT 'Transaksi dimana klaim digunakan',
  `expired_at` DATETIME DEFAULT NULL,
  `used_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_claim`),
  UNIQUE KEY `uk_kode` (`kode_klaim`),
  KEY `idx_konsumen` (`id_konsumen`),
  KEY `idx_reward` (`id_reward`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- 5. Settings: Poin configuration
-- =========================================================
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`, `description`) VALUES
('poin_per_transaksi', '10000', 'poin', 'Nominal transaksi untuk mendapat 1 poin (Rp)'),
('poin_multiplier', '1', 'poin', 'Multiplier poin (1 = setiap 10k dapat 1 poin)')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- =========================================================
-- 6. Sample Rewards Data
-- =========================================================
INSERT INTO `rewards` (`nama_reward`, `deskripsi`, `poin_dibutuhkan`, `tipe_reward`, `nilai_reward`, `is_active`) VALUES
('Diskon Rp 5.000', 'Potongan harga Rp 5.000 untuk pembelian apapun', 50, 'diskon_nominal', 5000, 1),
('Diskon Rp 10.000', 'Potongan harga Rp 10.000 untuk pembelian apapun', 100, 'diskon_nominal', 10000, 1),
('Diskon Rp 25.000', 'Potongan harga Rp 25.000 untuk pembelian apapun', 200, 'diskon_nominal', 25000, 1),
('Diskon 10%', 'Diskon 10% untuk total pembelian', 150, 'diskon_persen', 10, 1),
('Gratis Es Teh Manis', 'Dapatkan 1 Es Teh Manis gratis', 30, 'free_item', 5000, 1);

-- =========================================================
-- END OF MIGRATION
-- =========================================================
-- 
-- CARA MENJALANKAN:
-- 1. Buka phpMyAdmin
-- 2. Pilih database: ayamgoreng_limus
-- 3. Klik tab SQL
-- 4. Copy-paste isi file ini
-- 5. Klik Go/Execute
-- =========================================================
