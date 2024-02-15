-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2024 at 04:26 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_transaksi`
--

CREATE TABLE `tb_detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tlp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`id`, `id_outlet`, `nama`, `alamat`, `jenis_kelamin`, `tlp`) VALUES
(2, 4, 'Ryan', 'Situbatu', 'L', '087812312'),
(8, 10, 'Jenal Abidins', 'Los Angeles', 'P', '08685764'),
(9, 5, 'Somara', 'Ngawi', 'L', '23131125'),
(10, 4, 'zaf', 'awww', 'L', '41415'),
(11, 4, 'affav', 'vasvave', 'P', '3515135'),
(14, 5, 'uuki', 'Situbatu', 'L', '089644588'),
(15, 5, 'huui', 'San Andreas', 'L', '08975444'),
(16, 5, 'toin', 'balikpapan', 'P', '089655'),
(17, 10, 'Kita Ikuyo', 'Japan', 'P', '08912314451'),
(18, 10, 'aku', 'Ngawi', 'P', '08912313'),
(19, 10, 'Rezza Ligmasssss', 'Los Angeles', 'L', '089123124'),
(20, 10, 'adamss', 'Banjar, Pintusinga', 'L', '081928921'),
(21, 8, 'Hyoooo', 'cina', 'L', '0891231134'),
(22, 7, 'Rynrrss', 'situbatu', 'L', '089176613'),
(23, 10, 'rezzas', 'pamarican', 'L', '089182312'),
(24, 7, 'Somara', 'pamarican', 'L', '099892481');

-- --------------------------------------------------------

--
-- Table structure for table `tb_outlet`
--

CREATE TABLE `tb_outlet` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tlp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_outlet`
--

INSERT INTO `tb_outlet` (`id`, `nama`, `alamat`, `tlp`) VALUES
(4, 'MFP Laundry', 'Banjar, Neglasari', '083109627088'),
(5, 'Laundry A', 'A', '0891231'),
(7, 'Xlaundry', 'Ngawi', '08791231'),
(8, 'GLaundry', 'Situbatu', '08192831'),
(10, 'DXD Laundry', 'Demon School', '08913123'),
(11, 'Jaya Outlet', 'Ngawi', '08916172');

-- --------------------------------------------------------

--
-- Table structure for table `tb_paket`
--

CREATE TABLE `tb_paket` (
  `id` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `jenis` enum('kiloan','selimut','bed_cover','kaos','lain') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `harga` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_paket`
--

INSERT INTO `tb_paket` (`id`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
(8, 4, 'kiloan', 'Kiloan', '9500'),
(9, 4, 'selimut', 'Selimut', '9000'),
(10, 4, 'bed_cover', 'Bed_Cover', '8500'),
(11, 4, 'kaos', 'Kaos', '7500'),
(12, 4, 'lain', 'Lain', '8000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `batas_waktu` datetime NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `status` enum('baru','selesai','proses','diambil') NOT NULL,
  `dibayar` enum('dibayar','belum_dibayar') NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id`, `id_outlet`, `id_member`, `tgl`, `batas_waktu`, `tgl_bayar`, `status`, `dibayar`, `id_user`) VALUES
(7, 10, 8, '2023-11-30 17:39:00', '2023-12-02 17:39:00', '1970-01-01 01:00:00', 'proses', 'belum_dibayar', 14),
(9, 10, 9, '2023-11-11 10:33:00', '2023-11-30 10:35:00', '2027-10-30 07:33:00', 'baru', 'belum_dibayar', 12),
(10, 8, 9, '2023-12-07 13:07:00', '2023-12-22 13:07:00', '1970-01-01 01:00:00', 'baru', 'belum_dibayar', 14),
(11, 10, 8, '2023-12-07 13:08:00', '2023-12-25 13:09:00', '1970-01-01 01:00:00', 'proses', 'dibayar', 12),
(12, 10, 3, '2023-12-07 13:09:00', '2023-12-12 13:09:00', '1970-01-01 01:00:00', 'proses', 'belum_dibayar', 7),
(13, 10, 8, '2023-12-08 13:10:00', '2023-12-21 13:10:00', '1970-01-01 01:00:00', 'selesai', 'dibayar', 14),
(14, 10, 8, '2023-12-10 13:10:00', '2023-12-15 13:10:00', '2023-12-20 01:00:00', 'diambil', 'dibayar', 7),
(15, 8, 8, '2023-12-08 13:15:00', '2023-12-24 13:15:00', '0000-00-00 00:00:00', 'baru', 'belum_dibayar', 14),
(16, 10, 8, '2023-12-11 12:43:00', '2023-12-14 12:43:00', '0000-00-00 00:00:00', 'baru', 'belum_dibayar', 18),
(17, 10, 8, '2023-12-15 16:26:00', '2023-12-19 16:26:00', '0000-00-00 00:00:00', 'selesai', 'dibayar', 19),
(18, 10, 19, '2023-12-14 16:38:00', '2023-12-16 16:38:00', '1970-01-01 01:00:00', 'selesai', 'dibayar', 19),
(19, 4, 17, '2023-12-11 18:19:00', '2023-12-16 18:19:00', '0000-00-00 00:00:00', 'selesai', 'dibayar', 18),
(20, 8, 15, '2023-12-11 19:24:00', '2023-12-16 19:24:00', '0000-00-00 00:00:00', 'baru', 'belum_dibayar', 7),
(21, 11, 11, '2023-12-12 06:46:00', '2023-12-14 06:47:00', '0000-00-00 00:00:00', 'baru', 'dibayar', 12),
(22, 10, 8, '2023-12-12 07:18:00', '2023-12-14 07:18:00', '0000-00-00 00:00:00', 'baru', 'belum_dibayar', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `id_outlet` int(11) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `nama`, `username`, `password`, `id_outlet`, `role`) VALUES
(7, 'Ridwan', 'Iweng', '$2a$12$mJSx9mBvLkW0Y9jK2C9Xm.U3IUxLdU4jPDKcmALQdrP7Ye7Yj5QJ6', 0, 'admin'),
(12, 'Admin', 'Admin', '$2a$12$NseLFozAjS/nKmfxx6xBrOTodRkvc8Cc3qss0dwWZv.7JglZkVvC6', 0, 'admin'),
(14, 'Owner', 'Owner', '$2a$12$NseLFozAjS/nKmfxx6xBrOTodRkvc8Cc3qss0dwWZv.7JglZkVvC6', 0, 'owner'),
(18, 'Jenal Abidin', 'Bidin', '$2y$10$NwE0rMVjegTQ8Hx/GtdK5edeOMW4Gi.ThyjpI/4NO2yfvhnNt4WDm', 5, 'kasir'),
(19, 'Kasir', 'Kasir', '$2a$12$NseLFozAjS/nKmfxx6xBrOTodRkvc8Cc3qss0dwWZv.7JglZkVvC6', 10, 'kasir'),
(21, 'Jenal Abidin', 'Jenall', '$2y$10$amUXuC61XzKphFfSbhJKte6bvNfyM5XhBRRXGxqKQcXxUB/J3AQ0m', 4, 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_outlet`
--
ALTER TABLE `tb_outlet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_outlet`
--
ALTER TABLE `tb_outlet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_paket`
--
ALTER TABLE `tb_paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
