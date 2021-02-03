-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2021 at 03:44 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmks`
--

-- --------------------------------------------------------

--
-- Table structure for table `desa`
--

CREATE TABLE `desa` (
  `id_desa` int(10) NOT NULL,
  `nm_desa` varchar(25) NOT NULL,
  `id_kec` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `desa`
--

INSERT INTO `desa` (`id_desa`, `nm_desa`, `id_kec`, `is_delete`, `row_edit`, `creator`, `time_input`) VALUES
(1, 'Kedokanbunder Wetan', 1, 0, 0, 1, '2020-12-15 19:32:07'),
(2, 'Kaplongan Lor', 2, 0, 0, 1, '2020-12-15 19:32:07'),
(13, 'KarangVolong', 2, 0, 0, 1, '2020-12-27 13:26:02'),
(14, 'Balongan', 24, 1, 0, 1, '2021-01-04 12:06:18'),
(15, 'Sudimampir', 24, 1, 0, 1, '2021-01-04 12:07:02'),
(16, 'Majakerta', 24, 1, 0, 1, '2021-01-04 12:08:14'),
(17, 'Jatibarang Baru', 25, 1, 0, 1, '2021-01-04 12:08:22'),
(18, 'Kalimati', 25, 1, 0, 1, '2021-01-04 12:08:47'),
(19, 'Pilangsari', 25, 1, 0, 1, '2021-01-04 12:09:04'),
(20, 'Benda', 2, 1, 0, 1, '2021-01-04 12:09:18'),
(21, 'Mundu', 2, 1, 0, 1, '2021-01-04 12:09:44'),
(22, 'Tanjungpura', 2, 1, 0, 1, '2021-01-04 12:09:55'),
(23, 'Kedokanbunder Wetan', 1, 1, 0, 1, '2021-01-04 12:10:07'),
(24, 'Kedokanbunder', 1, 1, 0, 1, '2021-01-04 12:10:25'),
(25, 'Kedokan Agung', 1, 1, 0, 1, '2021-01-04 12:10:39'),
(26, 'Lemahayu', 26, 1, 0, 1, '2021-01-04 12:11:00'),
(27, 'Tulungagung', 26, 1, 0, 1, '2021-01-04 12:11:22'),
(28, 'Tenajar', 26, 1, 0, 1, '2021-01-04 12:11:36'),
(29, 'Tidak Ada', 27, 1, 0, 1, '2021-01-15 17:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `kat_pmks`
--

CREATE TABLE `kat_pmks` (
  `id_kat_pmks` int(10) NOT NULL,
  `nm_kat` varchar(25) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kat_pmks`
--

INSERT INTO `kat_pmks` (`id_kat_pmks`, `nm_kat`, `is_delete`, `row_edit`, `creator`, `time_input`) VALUES
(1, 'Disabilitas Terlantar', 1, 0, 1, '2020-12-15 18:28:42'),
(2, 'AMPFS', 1, 0, 1, '2020-12-15 18:28:42'),
(3, 'Lansia Terlantar', 1, 0, 1, '2020-12-15 18:28:42'),
(4, 'Tuna Daksa', 0, 0, 1, '2020-12-15 18:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kec` int(11) NOT NULL,
  `nm_kec` varchar(20) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id_kec`, `nm_kec`, `is_delete`, `row_edit`, `creator`, `time_input`) VALUES
(1, 'Kedokanbunder', 1, 0, 1, '2020-12-12 20:07:54'),
(2, 'Karangampel', 1, 0, 1, '2020-12-12 20:07:54'),
(24, 'Balongan', 1, 0, 1, '2021-01-04 12:05:02'),
(25, 'Jatibarang', 1, 0, 1, '2021-01-04 12:05:27'),
(26, 'Kertasemaya', 1, 0, 1, '2021-01-04 12:05:38'),
(27, 'Tidak Ada', 1, 0, 1, '2021-01-15 17:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `kk`
--

CREATE TABLE `kk` (
  `id_kk` int(11) NOT NULL,
  `id_kec` int(11) NOT NULL,
  `id_desa` int(11) NOT NULL,
  `no_kk` varchar(50) NOT NULL,
  `nik_kpl` varchar(50) NOT NULL,
  `nm_kpl` varchar(50) NOT NULL,
  `tgl_lhr_kpl` date NOT NULL,
  `alamat_kpl` varchar(100) NOT NULL,
  `pekerjaan_kpl` varchar(50) NOT NULL,
  `pendidikan_kpl` varchar(50) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kk`
--

INSERT INTO `kk` (`id_kk`, `id_kec`, `id_desa`, `no_kk`, `nik_kpl`, `nm_kpl`, `tgl_lhr_kpl`, `alamat_kpl`, `pekerjaan_kpl`, `pendidikan_kpl`, `is_delete`, `row_edit`, `creator`, `time_input`) VALUES
(21, 27, 29, 'Tidak Ada', 'Tidak Ada', 'Tidak Ada', '2021-01-01', 'Tidak Ada', 'Tidak Ada', 'Tidak Ada', 1, 0, 1, '2021-01-15 17:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nm_pegawai` varchar(50) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `no_telepon` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nm_pegawai`, `nip`, `no_telepon`, `alamat`, `username`, `password`, `role`, `is_delete`, `row_edit`, `time_input`) VALUES
(4, 'Ahmad', '16061115123', '0876767535353', 'Karangapel', 'pegawai', '$2y$10$f/uAjXE6GltsqXIjUnGXn.k6r9d0fKUEea5ckjv8AvgTo01GHuhUS', 'Pegawai', 1, 0, '2021-01-17 00:12:57'),
(5, 'Muhammad', '1606111545678', '0876767535353', 'Karangapel', 'pimpinan', '$2y$10$VCzzExGEM/eCmnZw8yFV2eFnlEfNZTG1sngUYIOTIM32LXYNgzDwC', 'Pimpinan', 1, 0, '2021-01-17 00:12:57'),
(10, 'Fauzan Ahmad', '160511010', '08567657889', 'Desa Karangampel', 'admin', '$2y$10$vxl6yPYBjJpX5XWdwWjLYemd3Z6lS9pjeJ1tnPuzUeVHC5PASjtPi', 'Admin', 1, 0, '2021-01-17 00:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `pmks`
--

CREATE TABLE `pmks` (
  `id_pmks` int(11) NOT NULL,
  `id_kk` int(11) NOT NULL,
  `id_kec` int(11) NOT NULL,
  `id_desa` int(11) NOT NULL,
  `id_kat_pmks` int(11) NOT NULL,
  `id_program` int(11) NOT NULL,
  `hsl_survei` varchar(50) NOT NULL,
  `nik_pmks` varchar(50) NOT NULL,
  `nm_pmks` varchar(50) NOT NULL,
  `tgl_lhr_pmks` date NOT NULL,
  `hubungan` varchar(25) NOT NULL,
  `jns_klm_pmks` varchar(25) NOT NULL,
  `nm_ibu_pmks` varchar(50) NOT NULL,
  `pendidikan_pmks` varchar(50) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `program_bantuan`
--

CREATE TABLE `program_bantuan` (
  `id_program` int(10) NOT NULL,
  `nm_program` varchar(25) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `row_edit` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `time_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `program_bantuan`
--

INSERT INTO `program_bantuan` (`id_program`, `nm_program`, `is_delete`, `row_edit`, `creator`, `time_input`) VALUES
(1, 'PKH', 1, 0, 1, '2020-12-14 13:07:41'),
(2, 'BPJS', 1, 0, 1, '2020-12-14 13:07:41'),
(3, 'Bansos Covid', 1, 0, 1, '2020-12-15 17:58:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id_desa`);

--
-- Indexes for table `kat_pmks`
--
ALTER TABLE `kat_pmks`
  ADD PRIMARY KEY (`id_kat_pmks`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kec`);

--
-- Indexes for table `kk`
--
ALTER TABLE `kk`
  ADD PRIMARY KEY (`id_kk`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `pmks`
--
ALTER TABLE `pmks`
  ADD PRIMARY KEY (`id_pmks`);

--
-- Indexes for table `program_bantuan`
--
ALTER TABLE `program_bantuan`
  ADD PRIMARY KEY (`id_program`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `desa`
--
ALTER TABLE `desa`
  MODIFY `id_desa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `kat_pmks`
--
ALTER TABLE `kat_pmks`
  MODIFY `id_kat_pmks` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `kk`
--
ALTER TABLE `kk`
  MODIFY `id_kk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pmks`
--
ALTER TABLE `pmks`
  MODIFY `id_pmks` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `program_bantuan`
--
ALTER TABLE `program_bantuan`
  MODIFY `id_program` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
