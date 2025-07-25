-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 07:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mykes`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status_absen` int(5) NOT NULL,
  `foto_absen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_pegawai`, `tanggal`, `jam_masuk`, `jam_pulang`, `keterangan`, `status_absen`, `foto_absen`, `created_at`) VALUES
(26, 28, '2025-07-25', '07:00:06', '18:56:18', '1', 1, NULL, '2025-07-25 16:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `absen_detail`
--

CREATE TABLE `absen_detail` (
  `id` int(11) NOT NULL,
  `absen_id` int(11) DEFAULT NULL,
  `pegawai_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `terlambat` tinyint(1) DEFAULT NULL,
  `menit_terlambat` int(11) DEFAULT NULL,
  `pulang_cepat` tinyint(1) DEFAULT NULL,
  `menit_pulang_cepat` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absen_detail`
--

INSERT INTO `absen_detail` (`id`, `absen_id`, `pegawai_id`, `tanggal`, `terlambat`, `menit_terlambat`, `pulang_cepat`, `menit_pulang_cepat`, `catatan`, `created_at`) VALUES
(15, 26, 28, '2025-07-25', 1, 656, 0, 0, '1', NULL),
(16, 26, 28, '2025-07-25', 1, 656, 0, 0, '1', NULL),
(17, 26, 28, '2025-07-25', 0, 0, 0, 0, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` int(12) NOT NULL,
  `id_pegawai` int(25) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `status` int(4) NOT NULL,
  `lama_cuti` int(20) NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id`, `id_pegawai`, `tgl_mulai`, `tgl_selesai`, `status`, `lama_cuti`, `update_at`, `create_at`) VALUES
(13, 28, '2025-07-23', '2025-07-26', 2, 4, '2025-07-23 03:55:09', '2025-07-23 03:46:26'),
(15, 22, '2025-07-23', '2025-07-25', 0, 3, '2025-07-23 13:36:51', '2025-07-23 13:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(12) NOT NULL,
  `nama_level` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `create_at`, `update_at`) VALUES
(1, 'admistrator', '2024-11-30 09:59:26', '2024-11-30 10:14:35'),
(2, 'pegawai', '2025-05-26 03:17:19', '2025-07-25 16:22:34');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(12) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_telepon` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `periode_cuti` int(20) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama_lengkap`, `no_telepon`, `alamat`, `periode_cuti`, `create_at`, `update_at`) VALUES
(0, 'Arya Wiraguna', '566556', 'bandung', 0, '2024-11-30 13:00:02', '2024-11-30 13:00:02'),
(0, 'ibnu ibrahim', '566556', 'jakarta', 0, '2024-11-30 13:10:43', '2024-11-30 13:10:43');

-- --------------------------------------------------------

--
-- Table structure for table `shifting`
--

CREATE TABLE `shifting` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `nama_shift` text NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `keterangan` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shifting`
--

INSERT INTO `shifting` (`id`, `id_pegawai`, `nama_shift`, `jam_masuk`, `jam_keluar`, `tgl_mulai`, `tgl_selesai`, `keterangan`, `create_at`, `update_at`) VALUES
(2, 22, 'Pagi', '07:00:00', '17:00:00', '2025-07-26', '2025-07-28', '', '2025-07-23 18:10:22', '2025-07-25 16:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`id`, `id_user`, `deskripsi`, `catatan`, `foto`, `create_at`, `update_at`) VALUES
(1, 1, 'ipsum dolor', 'lorem', '5.jpg', '2024-12-17 14:15:06', '2024-12-18 08:37:51'),
(43, 1, ' Donec vel eros id metus bibendum eleifend in ut quam. Nam vehicula id orci et convallis.Agregos avi', 'lorem', '1.jpg', '2024-12-17 16:15:06', '2024-12-18 08:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `id_level` int(12) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nip` varchar(16) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `no_telepon` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `periode_cuti` int(20) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama_lengkap`, `email`, `nip`, `jabatan`, `no_telepon`, `alamat`, `password`, `foto`, `periode_cuti`, `create_at`, `update_at`) VALUES
(1, 1, 'admin', 'admin@gmail.com', 'PSBD-20250526060', 'admin', '566556', 'jakarta', '123', '', 12, '2024-11-30 10:18:59', '2025-07-21 07:43:46'),
(22, 2, 'hari budiarto', 'ari@gmail.com', 'PSBD-20250526065', 'staff', '93493434-34', 'Tuban', '123', '', 12, '2025-05-26 04:53:34', '2025-07-21 07:43:50'),
(28, 2, 'danang S ', 'danangS@gmail.com', 'PSBD-20250721094', 'it', '934893490343490', 'Tuban', '123', '', 12, '2025-07-21 07:43:24', '2025-07-21 15:30:11'),
(29, 2, 'Suharno', 'harno@gmail.com', 'PSBD-20250723062', 'Staff', '934893490343490', 'Jakarta', '123', '', 12, '2025-07-23 16:26:48', '2025-07-23 16:26:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `absen_detail`
--
ALTER TABLE `absen_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absen_id` (`absen_id`),
  ADD KEY `pegawai_id` (`pegawai_id`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuti_ibfk_1` (`id_pegawai`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifting`
--
ALTER TABLE `shifting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifting_ibfk_1` (`id_pegawai`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ibfk_1` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `absen_detail`
--
ALTER TABLE `absen_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `shifting`
--
ALTER TABLE `shifting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `absen_detail`
--
ALTER TABLE `absen_detail`
  ADD CONSTRAINT `absen_detail_ibfk_1` FOREIGN KEY (`absen_id`) REFERENCES `absensi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absen_detail_ibfk_2` FOREIGN KEY (`pegawai_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shifting`
--
ALTER TABLE `shifting`
  ADD CONSTRAINT `shifting_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD CONSTRAINT `suggestion_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
