-- SIAKAD Pertemuan 12 MySQL Schema & Seed Script
-- Dapat diimpor langsung melalui phpMyAdmin atau MySQL CLI,
-- atau gunakan `php artisan migrate --seed`.

CREATE DATABASE IF NOT EXISTS `siakad_pbo_per12` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `siakad_pbo_per12`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` int NOT NULL DEFAULT 2,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tb_dosen` (
  `id_dosen` varchar(20) NOT NULL,
  `nip` varchar(200) NOT NULL,
  `nama_dosen` varchar(200) NOT NULL,
  `mata_kuliah` varchar(200) NOT NULL,
  `foto_dosen` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dosen`),
  UNIQUE KEY `tb_dosen_nip_unique` (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tb_mahasiswa` (
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `ttl` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `agama` varchar(100) NOT NULL,
  `tingkat` int NOT NULL,
  `semester` int NOT NULL,
  `nomor_handphone` varchar(20) NOT NULL,
  `foto_mahasiswa` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tb_invoice` (
  `no_invoice` varchar(30) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `semester_akademik` varchar(50) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `nominal_ukt` bigint unsigned NOT NULL,
  `biaya_praktikum` bigint unsigned NOT NULL DEFAULT 0,
  `status_pembayaran` varchar(30) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_invoice`),
  KEY `tb_invoice_nim_foreign` (`nim`),
  CONSTRAINT `tb_invoice_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `tb_mahasiswa` (`nim`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password default semua akun demo: password
INSERT INTO `users` (`name`, `email`, `password`, `level`, `created_at`, `updated_at`) VALUES
('Administrator SIAKAD', 'admin@siakad.test', '$2y$12$sYJnMR8tOcufCYzGISHPcOsrclx0ANX.pYpBw9JNNqm12QWOkxute', 1, '2024-09-01 08:00:00', '2024-09-01 08:00:00'),
('Staf Akademik', 'user@siakad.test', '$2y$12$sYJnMR8tOcufCYzGISHPcOsrclx0ANX.pYpBw9JNNqm12QWOkxute', 2, '2025-02-10 09:00:00', '2025-02-10 09:00:00'),
('Daffa Riyadhul', 'mahasiswa@siakad.test', '$2y$12$sYJnMR8tOcufCYzGISHPcOsrclx0ANX.pYpBw9JNNqm12QWOkxute', 3, '2025-09-05 10:00:00', '2025-09-05 10:00:00'),
('Erick Febriyanto', 'dosen@siakad.test', '$2y$12$sYJnMR8tOcufCYzGISHPcOsrclx0ANX.pYpBw9JNNqm12QWOkxute', 4, '2026-01-15 08:30:00', '2026-01-15 08:30:00')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `level` = VALUES(`level`);

INSERT INTO `tb_dosen` (`id_dosen`, `nip`, `nama_dosen`, `mata_kuliah`, `foto_dosen`, `created_at`, `updated_at`) VALUES
('PEG0001', '199001262019031025', 'Mohammad Iqbal, S.Kom., M.T.', 'Pemrograman Berorientasi Objek', 'PEG0001.svg', NOW(), NOW()),
('PEG0002', '198801052019031001', 'Tri Herdiawan Apandi, S.ST., M.T.', 'Data Mining', 'PEG0002.svg', NOW(), NOW()),
('PEG0003', '199104122020121008', 'Erick Febriyanto, S.Kom., M.TI.', 'Pemrograman Web', 'PEG0003.svg', NOW(), NOW())
ON DUPLICATE KEY UPDATE `nama_dosen` = VALUES(`nama_dosen`), `mata_kuliah` = VALUES(`mata_kuliah`);

INSERT INTO `tb_mahasiswa` (`nim`, `nama`, `jurusan`, `prodi`, `ttl`, `alamat`, `agama`, `tingkat`, `semester`, `nomor_handphone`, `foto_mahasiswa`, `created_at`, `updated_at`) VALUES
('10603001', 'Daffa Riyadhul', 'Teknologi Informasi dan Komputer', 'D4 Teknologi Rekayasa Perangkat Lunak', 'Subang, 14 Mei 2005', 'Jl. Brigjen Katamso No. 37, Dangdeur, Subang', 'Islam', 2, 3, '081234567890', '10603001.svg', NOW(), NOW()),
('10603002', 'Nabil Andhika Rabbani', 'Teknologi Informasi dan Komputer', 'D3 Sistem Informasi', 'Bandung, 22 Agustus 2005', 'Jl. Otista No. 18, Karanganyar, Subang', 'Islam', 2, 3, '081345678901', '10603002.svg', NOW(), NOW()),
('10603003', 'Siti Rahmawati', 'Teknologi Informasi dan Komputer', 'D4 Teknologi Rekayasa Perangkat Lunak', 'Purwakarta, 03 November 2004', 'Jl. Veteran No. 12, Sukamelang, Subang', 'Islam', 3, 5, '081567890123', '10603003.svg', NOW(), NOW())
ON DUPLICATE KEY UPDATE `nama` = VALUES(`nama`), `prodi` = VALUES(`prodi`);

INSERT INTO `tb_invoice` (`no_invoice`, `nim`, `semester_akademik`, `tanggal_terbit`, `jatuh_tempo`, `nominal_ukt`, `biaya_praktikum`, `status_pembayaran`, `metode_pembayaran`, `catatan`, `created_at`, `updated_at`) VALUES
('INV-2026-001', '10603001', 'Ganjil 2026/2027', '2026-08-15', '2026-09-05', 3500000, 450000, 'Lunas', 'Virtual Account Bank Mandiri', 'Simulasi tagihan UKT awal untuk keperluan demonstrasi cetak modul Pertemuan 12.', NOW(), NOW()),
('INV-2026-002', '10603002', 'Ganjil 2026/2027', '2026-08-16', '2026-09-05', 3000000, 350000, 'Menunggu Pembayaran', 'Virtual Account BRI', 'Simulasi tagihan UKT awal untuk keperluan demonstrasi cetak modul Pertemuan 12.', NOW(), NOW())
ON DUPLICATE KEY UPDATE `status_pembayaran` = VALUES(`status_pembayaran`);
