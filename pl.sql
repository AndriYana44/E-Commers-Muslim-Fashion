-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2020 at 06:55 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(1, 'pria'),
(2, 'wanita');

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi`
--

CREATE TABLE `konfirmasi` (
  `id_konfirm` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `resi` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konfirmasi`
--

INSERT INTO `konfirmasi` (`id_konfirm`, `id_user`, `resi`, `status`) VALUES
(6, 5, 'BRG292000-795TR', 'Telah Diproses'),
(9, 4, 'BRG120000-890TR', 'telah diproses');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `kode_produk` varchar(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `stok` int(20) NOT NULL,
  `harga` int(20) NOT NULL,
  `deskripsi` text NOT NULL,
  `img` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama`, `kategori`, `stok`, `harga`, `deskripsi`, `img`) VALUES
(5, 'A003', 'gamis2', 'wanita', 16, 195000, 'Bagus', 'syntaks.jpg'),
(6, 'A004', 'atasan', 'wanita', 12, 120000, 'Bagus', 'camera-lpt.jpg'),
(8, 'A006', 'koko anak', 'pria', -5, 159000, 'Bagus Tebal', 'koko anak.jpg'),
(16, '12', 'koko dewasa', 'pria', 12, 120000, 'bagus', 'kokopria.jpg'),
(17, 'BGR002', 'koko laki-laki', 'pria', 15, 155000, 'Bagus', 'koko.jpeg'),
(19, 'BRG003B', 'inspire dress', 'wanita', 12, 172000, 'bagus', 'b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sub_transaksi`
--

CREATE TABLE `sub_transaksi` (
  `id_trans` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_barang` varchar(20) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `jumlah` int(20) NOT NULL,
  `total` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `barang` varchar(20) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `jumlah` int(20) NOT NULL,
  `total` int(20) NOT NULL,
  `resi` varchar(20) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_customer`, `barang`, `kode_barang`, `warna`, `jumlah`, `total`, `resi`, `tgl`) VALUES
(3, 4, 'koko dewasa', '12', 'biru', 1, 120000, 'BRG279000-402TR', '2020-08-18'),
(4, 4, 'koko anak', 'A006', 'merah', 1, 159000, 'BRG279000-402TR', '2020-08-18'),
(5, 5, 'atasan', 'A004', 'hitam', 1, 120000, 'BRG292000-795TR', '2020-08-18'),
(6, 5, 'inspire dress', 'BRG003B', 'merah', 1, 172000, 'BRG292000-795TR', '2020-08-18'),
(11, 4, 'inspire dress', 'BRG003B', 'coklat', 1, 172000, 'BRG172000-344TR', '2020-08-19'),
(12, 5, 'koko dewasa', '12', 'biru', 1, 120000, 'BRG120000-789TR', '2020-08-19'),
(13, 4, 'koko laki-laki', 'BGR002', 'abu', 1, 155000, 'BRG155000-808TR', '2020-08-19'),
(14, 4, 'koko dewasa', '12', 'maroon', 1, 120000, 'BRG120000-890TR', '2020-08-23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tlp` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `nama`, `tlp`, `alamat`) VALUES
(3, 'dimas@gmail.com', '7d49e40f4b3d8f68c19406a58303f826', 'dimas', '082147483647', 'Bogor'),
(4, 'andri@gmail.com', '202cb962ac59075b964b07152d234b70', 'Andri Yana', '085316466555', 'Bogor'),
(5, 'riris@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'ririss', '085794562231', 'bogorr');

-- --------------------------------------------------------

--
-- Table structure for table `warna`
--

CREATE TABLE `warna` (
  `id_warna` int(11) NOT NULL,
  `kode_barang` varchar(11) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warna`
--

INSERT INTO `warna` (`id_warna`, `kode_barang`, `warna`, `stok`) VALUES
(1, 'A003', 'merah', 3),
(2, 'A003', 'hijau', 5),
(5, 'A006', 'merah', 7),
(6, 'A006', 'biru', 8),
(8, '12', 'maroon', 6),
(9, '12', 'biru', 9),
(11, 'A004', 'hitam', 1),
(18, 'BGR002', 'putih', 6),
(19, 'BGR002', 'abu', 9),
(20, 'BGR002', 'coklat', 5),
(21, 'BGR008', 'merah', 0),
(22, 'BGR008', 'maroon', 0),
(23, 'BGR008', 'hitam', 0),
(24, 'BRG003B', 'merah', 9),
(25, 'BRG003B', 'abu', 3),
(26, 'BRG003B', 'coklat', 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  ADD PRIMARY KEY (`id_konfirm`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `sub_transaksi`
--
ALTER TABLE `sub_transaksi`
  ADD PRIMARY KEY (`id_trans`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `warna`
--
ALTER TABLE `warna`
  ADD PRIMARY KEY (`id_warna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `konfirmasi`
--
ALTER TABLE `konfirmasi`
  MODIFY `id_konfirm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sub_transaksi`
--
ALTER TABLE `sub_transaksi`
  MODIFY `id_trans` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `warna`
--
ALTER TABLE `warna`
  MODIFY `id_warna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
