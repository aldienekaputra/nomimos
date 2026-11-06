-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2026 at 05:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_nomimos`
--

-- --------------------------------------------------------

--
-- Table structure for table `catatan_acara`
--

CREATE TABLE `catatan_acara` (
  `id_note` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `list_VIP` text DEFAULT NULL,
  `req_lagu` text DEFAULT NULL,
  `list_foto_VVIP` text DEFAULT NULL,
  `catatan_kebutuhan` text DEFAULT NULL,
  `petugas_keluarga` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catatan_acara`
--

INSERT INTO `catatan_acara` (`id_note`, `id_pemesanan`, `list_VIP`, `req_lagu`, `list_foto_VVIP`, `catatan_kebutuhan`, `petugas_keluarga`) VALUES
(1, 1, '5 Meja VVIP Reserved Stage', 'A Thousand Years - Christina Perri', 'Sesi 1: Keluarga Inti, Sesi 2: Rombongan VVIP', 'Ring bearer dibawa adik jam 08.00 WIB', 'Saksi: Bapak Ahmad, Sambutan: Bpk. Ir. Budi'),
(2, 2, '3 Meja VVIP Depan Stage', 'Perfect - Ed Sheeran', 'Sesi Foto Teman Alumni & Pejabat', 'Gamelan set siap pukul 10.00 WIB', 'Saksi: Bapak Subagyo\r\nJuru Paes: Bu Hj. Anik'),
(3, 3, '10 Meja VVIP Artis & Pejabat Reserved Front Stage', 'Lover - Taylor Swift, Penjaga Hati - Nadhif Basalamah', 'Sesi 1: Keluarga Besar Ahmad Dhani & Maia Estianty, Sesi 2: Rekan Artis', 'Booth Es Kopi & Catering standby jam 11.00 WIB', 'Saksi: Bpk. Ahmad Dhani & Bpk. Syifa\r\nJuru Bicara: Bpk. El Rumi');

-- --------------------------------------------------------

--
-- Table structure for table `crew`
--

CREATE TABLE `crew` (
  `id_crew` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_crew` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crew`
--

INSERT INTO `crew` (`id_crew`, `id_user`, `nama_crew`, `no_hp`) VALUES
(1, 4, 'Galih', '081234500001'),
(2, 5, 'Irfan', '081234500002'),
(3, 6, 'Salsa', '081234500003'),
(4, 7, 'Aldien', '081234500004'),
(5, 8, 'Izza', '081234500005'),
(6, 9, 'Kayla', '081234500006'),
(7, 10, 'Karin', '081234500007'),
(8, 11, 'Mahenz', '081234500008'),
(9, 12, 'Zahra', '081234500009'),
(10, 13, 'Jua', '081234500010'),
(11, 14, 'Anton', '081234500011');

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_acara`
--

CREATE TABLE `keuangan_acara` (
  `id_keuangan` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `tgl_sewa_WO` date NOT NULL,
  `dp_WO` decimal(12,2) NOT NULL,
  `tgl_hitung_pelunasan` date NOT NULL,
  `sisa_pelunasan_WO` decimal(12,2) NOT NULL,
  `tgl_Jatuh_tempo` date NOT NULL,
  `status_pembayaran` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keuangan_acara`
--

INSERT INTO `keuangan_acara` (`id_keuangan`, `id_pemesanan`, `tgl_sewa_WO`, `dp_WO`, `tgl_hitung_pelunasan`, `sisa_pelunasan_WO`, `tgl_Jatuh_tempo`, `status_pembayaran`) VALUES
(1, 1, '2026-03-01', 2000000.00, '2026-04-10', 4000000.00, '2026-04-05', 'Lunas'),
(2, 2, '2026-03-15', 3000000.00, '2026-05-01', 4000000.00, '2026-04-25', 'Pending'),
(3, 3, '2026-06-01', 5000000.00, '2026-12-01', 10000000.00, '2026-12-10', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `id_klien` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_pria` varchar(100) NOT NULL,
  `nama_wanita` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klien`
--

INSERT INTO `klien` (`id_klien`, `id_user`, `nama_pria`, `nama_wanita`, `no_hp`, `alamat`) VALUES
(1, 2, 'Budi', 'Ani', '081234567890', 'Jl. Soekarno Hatta No. 12, Malang'),
(2, 3, 'Rizky', 'Maya', '089876543210', 'Jl. Ijen No. 45, Malang'),
(3, 15, 'el rumi', 'syifa hadju', '08438436843683', 'Malang'),
(4, 16, 'pikri', 'putri', '123456789', 'tajinan');

-- --------------------------------------------------------

--
-- Table structure for table `moodboard`
--

CREATE TABLE `moodboard` (
  `id_moodboard` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `url_gambar` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moodboard`
--

INSERT INTO `moodboard` (`id_moodboard`, `id_pemesanan`, `url_gambar`, `keterangan`) VALUES
(5, 1, 'moodboard/36ixwg0UF34DgWHcTn7w6NkUUnI0SiDzFqUvUGmN.png', 'Referensi Fotografer');

-- --------------------------------------------------------

--
-- Table structure for table `paket_acara`
--

CREATE TABLE `paket_acara` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `keterangan_paket` text NOT NULL,
  `harga_paket` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_acara`
--

INSERT INTO `paket_acara` (`id_paket`, `nama_paket`, `keterangan_paket`, `harga_paket`) VALUES
(1, 'Samaya Wedding Package', 'Engagement / Akad / Pemberkatan - 5 crew, standby 6 jam', 5000000.00),
(2, 'Arkana Wedding Package', 'Intimate Wedding - 100 pax, 6 crew, preparation 3 bulan', 6000000.00),
(3, 'Asmara Wedding Package', '600 pax, 7 crew, preparation 6 bulan, stand by 8 jam', 7000000.00),
(4, 'Amerta Wedding Package', '1000 pax, 8 crew, preparation 6 bulan, stand by 8 jam', 8000000.00),
(5, 'Nirwana Wedding Package', '1500 pax, 10 crew, preparation 6 bulan, include VIP service', 9500000.00),
(6, 'Mahesa Wedding Package', '3000 pax, 12 crew, include MC & Wedding Planner/Consultant', 15000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_vendor`
--

CREATE TABLE `pembayaran_vendor` (
  `id_pay_vendor` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_vendor` int(11) NOT NULL,
  `nominal_dp` decimal(12,2) NOT NULL,
  `nominal_pelunasan` decimal(12,2) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `status_bayar_vendor` enum('Confirmed','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran_vendor`
--

INSERT INTO `pembayaran_vendor` (`id_pay_vendor`, `id_pemesanan`, `id_vendor`, `nominal_dp`, `nominal_pelunasan`, `tgl_bayar`, `status_bayar_vendor`) VALUES
(1, 1, 1, 15000000.00, 20000000.00, '2026-04-01', 'Confirmed'),
(2, 1, 2, 5000000.00, 10000000.00, '2026-04-02', 'Pending'),
(3, 2, 3, 20000000.00, 25000000.00, '2026-04-15', 'Confirmed'),
(4, 2, 4, 10000000.00, 20000000.00, '2026-04-18', 'Confirmed'),
(6, 1, 6, 2000000.00, 3000000.00, '2026-04-05', 'Confirmed'),
(7, 1, 5, 5000000.00, 5000000.00, '2026-04-06', 'Confirmed'),
(8, 2, 7, 1500000.00, 2500000.00, '2026-04-20', 'Confirmed'),
(9, 2, 8, 4000000.00, 6000000.00, '2026-04-22', 'Confirmed'),
(10, 3, 2, 10000000.00, 15000000.00, '2026-11-01', 'Confirmed'),
(11, 3, 1, 20000000.00, 30000000.00, '2026-11-05', 'Confirmed'),
(12, 3, 6, 3000000.00, 4000000.00, '2026-11-10', 'Confirmed'),
(13, 3, 5, 7000000.00, 8000000.00, '2026-11-12', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_acara`
--

CREATE TABLE `pemesanan_acara` (
  `id_pemesanan` int(11) NOT NULL,
  `id_klien` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `tgl_acara` date NOT NULL,
  `lokasi_acara` varchar(255) NOT NULL,
  `status_acc` enum('Pending','ACC','Batal') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan_acara`
--

INSERT INTO `pemesanan_acara` (`id_pemesanan`, `id_klien`, `id_paket`, `tgl_acara`, `lokasi_acara`, `status_acc`) VALUES
(1, 1, 2, '2026-04-20', 'Grand Ballroom Hotel Malang', 'ACC'),
(2, 2, 3, '2026-05-15', 'Ijen Suites Resort Malang', 'ACC'),
(3, 3, 6, '2026-12-19', 'Grand Mercure', 'ACC');

-- --------------------------------------------------------

--
-- Table structure for table `penugasan_crew`
--

CREATE TABLE `penugasan_crew` (
  `id_laporan` int(11) NOT NULL,
  `id_crew` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `jobdesk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penugasan_crew`
--

INSERT INTO `penugasan_crew` (`id_laporan`, `id_crew`, `id_pemesanan`, `jobdesk`) VALUES
(1, 7, 1, 'Team Leader'),
(3, 10, 1, 'Bride Assistant'),
(4, 1, 1, 'Stage Manager'),
(5, 4, 1, 'WCC (Wedding Content Creator)'),
(6, 7, 2, 'Team Leader'),
(7, 2, 2, 'Helper'),
(8, 3, 2, 'Helper'),
(9, 5, 2, 'Usher'),
(10, 6, 2, 'Usher'),
(11, 9, 1, 'Usher'),
(12, 4, 2, 'WCC (Wedding Content Creator)'),
(13, 4, 3, 'WCC (Wedding Content Creator)'),
(14, 1, 3, 'Team Leader'),
(15, 10, 3, 'Bride Assistant'),
(16, 9, 3, 'Stage Manager'),
(17, 11, 1, 'Helper');

-- --------------------------------------------------------

--
-- Table structure for table `rundown_acara`
--

CREATE TABLE `rundown_acara` (
  `id_rundown` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `nama_kegiatan` varchar(150) NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rundown_acara`
--

INSERT INTO `rundown_acara` (`id_rundown`, `id_pemesanan`, `waktu_mulai`, `waktu_selesai`, `nama_kegiatan`, `penanggung_jawab`, `keterangan`) VALUES
(1, 1, '08:00:00', '09:30:00', 'Akad Nikah', 'WO & Penghulu', 'Persiapan berkas & meja akad selesai pukul 07.30'),
(2, 1, '09:30:00', '10:00:00', 'Sesi Foto Keluarga', 'Team Dokumentasi', 'Keluarga inti standby di area pelaminan'),
(4, 2, '07:00:00', '08:30:00', 'Sungkeman & Panggih', 'Perias & WO', 'Prosesi adat Jawa didampingi sesepuh'),
(5, 2, '09:00:00', '10:30:00', 'Akad Nikah Islami', 'Penghulu & WO', 'Penyerahan mahar dan sesi foto resmi'),
(6, 2, '12:00:00', '15:00:00', 'Resepsi Utama', 'Catering & WO', 'Ramah tamah musik gamelan modern'),
(7, 1, '10:00:00', '11:00:00', 'Pembukaan Resepsi & Grooming', 'WO & MUA', 'Persiapan gaun resepsi & Touchup'),
(8, 1, '11:00:00', '14:00:00', 'Resepsi Utama & Stand Es Kopi', 'Catering & WO', 'Ramah tamah & Foto bersama VIP'),
(9, 2, '10:30:00', '11:30:00', 'Foto Bersama Keluarga VVIP', 'Team Dokumentasi', 'Foto grup di depan dekorasi utama'),
(10, 2, '11:30:00', '14:00:00', 'Ramah Tamah & Hiburan', 'WO & Music Player', 'Penyajian es kopi booth & prasmanan'),
(11, 3, '07:00:00', '08:30:00', 'Preparation & Makeup Pengantin', 'MUA & Bride Assistant', 'Persiapan busana akad di ruang VIP'),
(12, 3, '08:30:00', '10:00:00', 'Prosesi Akad Nikah', 'Penghulu & Team Leader', 'Ijab kabul di Grand Mercure Ballroom'),
(13, 3, '10:00:00', '11:00:00', 'Sesi Foto Akad & Keluarga Inti', 'Dokumentasi & WO', 'Foto bersama saksi dan keluarga'),
(14, 3, '11:00:00', '12:00:00', 'Ganti Busana & Touch Up Resepsi', 'MUA & Bride Assistant', 'Persiapan resepsi grand ballroom'),
(15, 3, '12:00:00', '15:00:00', 'Grand Reception & Live Music', 'Catering, Vendor & WO', 'Ramah tamah artis & penikmat es kopi booth');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5IDPpwuAFuD3w5wxdUvJSEWaXqyYJbFGuA70oXgT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjNiOThyREZmelhtYk43S1hEQk1qbTFlREVRV0tIeVNPdWtmbjhMTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29raW5nIjtzOjU6InJvdXRlIjtzOjE1OiJsYW5kaW5nLmJvb2tpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1793935992);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Klien','Crew') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin_nomimos', '$2y$12$w4sTWF42yLUk5JXAfBPYyOgzG23TXTMNAfYKwpqzr7kY/t41hvLhO', 'Admin'),
(2, 'budi_ani', '$2y$12$n.Nm4QJ0U07f0oWoy6vQMe05O/5url8deVquKhzNYsiM.ZYZeSPFS', 'Klien'),
(3, 'rizky_maya', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Klien'),
(4, 'galih_wcc', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(5, 'irfan_helper', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(6, 'salsa_helper', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(7, 'aldien_it', '$2y$12$jAp0hpTWkx3A6veqweWfqe4.Du0u/vhKmwRJ8dkpGS0aQSBscH0YK', 'Crew'),
(8, 'izza_usher', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(9, 'kayla_usher', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(10, 'karin_tl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(11, 'mahenz_sm', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(12, 'zahra_bt', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(13, 'jua_ba', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(14, 'anton_sovenir', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Crew'),
(15, 'syifarumi', '$2y$12$Ntn5TRMGt0kKFdY2MuCG1eDC2t43pZp7mXZh0FeatDBh1cnFaEF4O', 'Klien'),
(16, 'pikriputri', '$2y$12$s0H13cdCqxH7FiyTvvfxGOFs88v75VbWzS3gkSkcKU09zJ7zBzvBe', 'Klien');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id_vendor` int(11) NOT NULL,
  `nama_vendor` varchar(100) NOT NULL,
  `kategori_vendor` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id_vendor`, `nama_vendor`, `kategori_vendor`, `no_hp`) VALUES
(1, 'Mahkota Catering', 'Catering', '081233221100'),
(2, 'Royal Art Decoration', 'Dekorasi', '082244332211'),
(3, 'Srikandi Catering Jawa', 'Catering', '083355443322'),
(4, 'Jawa Sanggar MUA & Adat', 'MUA & Attire', '084466554433'),
(5, 'Shine Visual', 'Foto & Video', '823193921'),
(6, 'Janji Jiwa & Kopi Kenangan Event', 'Es Kopi & Beverage', '081299887766'),
(7, 'Kopi Janji Manis Booth', 'Es Kopi & Beverage', '082133445566'),
(8, 'Storyography Pictures', 'Foto & Video', '085711223344');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_acara`
--

CREATE TABLE `vendor_acara` (
  `id_va` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_vendor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_acara`
--

INSERT INTO `vendor_acara` (`id_va`, `id_pemesanan`, `id_vendor`) VALUES
(5, 1, 2),
(6, 1, 1),
(7, 1, 6),
(8, 1, 5),
(9, 2, 2),
(10, 2, 3),
(11, 2, 7),
(12, 2, 8),
(13, 3, 2),
(14, 3, 1),
(15, 3, 6),
(16, 3, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catatan_acara`
--
ALTER TABLE `catatan_acara`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`id_crew`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `keuangan_acara`
--
ALTER TABLE `keuangan_acara`
  ADD PRIMARY KEY (`id_keuangan`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`id_klien`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `moodboard`
--
ALTER TABLE `moodboard`
  ADD PRIMARY KEY (`id_moodboard`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `paket_acara`
--
ALTER TABLE `paket_acara`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pembayaran_vendor`
--
ALTER TABLE `pembayaran_vendor`
  ADD PRIMARY KEY (`id_pay_vendor`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_vendor` (`id_vendor`);

--
-- Indexes for table `pemesanan_acara`
--
ALTER TABLE `pemesanan_acara`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_klien` (`id_klien`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `penugasan_crew`
--
ALTER TABLE `penugasan_crew`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_crew` (`id_crew`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `rundown_acara`
--
ALTER TABLE `rundown_acara`
  ADD PRIMARY KEY (`id_rundown`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id_vendor`);

--
-- Indexes for table `vendor_acara`
--
ALTER TABLE `vendor_acara`
  ADD PRIMARY KEY (`id_va`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_vendor` (`id_vendor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catatan_acara`
--
ALTER TABLE `catatan_acara`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `crew`
--
ALTER TABLE `crew`
  MODIFY `id_crew` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `keuangan_acara`
--
ALTER TABLE `keuangan_acara`
  MODIFY `id_keuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `klien`
--
ALTER TABLE `klien`
  MODIFY `id_klien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `moodboard`
--
ALTER TABLE `moodboard`
  MODIFY `id_moodboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paket_acara`
--
ALTER TABLE `paket_acara`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran_vendor`
--
ALTER TABLE `pembayaran_vendor`
  MODIFY `id_pay_vendor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pemesanan_acara`
--
ALTER TABLE `pemesanan_acara`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penugasan_crew`
--
ALTER TABLE `penugasan_crew`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rundown_acara`
--
ALTER TABLE `rundown_acara`
  MODIFY `id_rundown` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id_vendor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vendor_acara`
--
ALTER TABLE `vendor_acara`
  MODIFY `id_va` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catatan_acara`
--
ALTER TABLE `catatan_acara`
  ADD CONSTRAINT `catatan_acara_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `crew`
--
ALTER TABLE `crew`
  ADD CONSTRAINT `crew_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `keuangan_acara`
--
ALTER TABLE `keuangan_acara`
  ADD CONSTRAINT `keuangan_acara_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `klien`
--
ALTER TABLE `klien`
  ADD CONSTRAINT `klien_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `moodboard`
--
ALTER TABLE `moodboard`
  ADD CONSTRAINT `moodboard_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran_vendor`
--
ALTER TABLE `pembayaran_vendor`
  ADD CONSTRAINT `pembayaran_vendor_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_vendor_ibfk_2` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id_vendor`) ON DELETE CASCADE;

--
-- Constraints for table `pemesanan_acara`
--
ALTER TABLE `pemesanan_acara`
  ADD CONSTRAINT `pemesanan_acara_ibfk_1` FOREIGN KEY (`id_klien`) REFERENCES `klien` (`id_klien`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemesanan_acara_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `paket_acara` (`id_paket`) ON DELETE CASCADE;

--
-- Constraints for table `penugasan_crew`
--
ALTER TABLE `penugasan_crew`
  ADD CONSTRAINT `penugasan_crew_ibfk_1` FOREIGN KEY (`id_crew`) REFERENCES `crew` (`id_crew`) ON DELETE CASCADE,
  ADD CONSTRAINT `penugasan_crew_ibfk_2` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `rundown_acara`
--
ALTER TABLE `rundown_acara`
  ADD CONSTRAINT `rundown_acara_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_acara`
--
ALTER TABLE `vendor_acara`
  ADD CONSTRAINT `vendor_acara_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan_acara` (`id_pemesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_acara_ibfk_2` FOREIGN KEY (`id_vendor`) REFERENCES `vendor` (`id_vendor`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
