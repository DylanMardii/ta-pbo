-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 07:15 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_inventori`
--

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id` varchar(255) NOT NULL,
  `idProduk` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `index` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inv_keluar`
--

CREATE TABLE `inv_keluar` (
  `id` varchar(255) NOT NULL,
  `issued` tinyint(1) NOT NULL,
  `referenceNumber` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `klien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_keluar`
--

INSERT INTO `inv_keluar` (`id`, `issued`, `referenceNumber`, `deskripsi`, `timestamp`, `klien`) VALUES
('IM-1682602365-wm3vIc7T7S', 0, '(90)DTL8713002537A1(91)250130', 'Picked Up By SATRIA', 1682602320000, 'SILA');

-- --------------------------------------------------------

--
-- Table structure for table `inv_masuk`
--

CREATE TABLE `inv_masuk` (
  `id` varchar(255) NOT NULL,
  `issued` tinyint(1) NOT NULL,
  `referenceNumber` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `supplier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_masuk`
--

INSERT INTO `inv_masuk` (`id`, `issued`, `referenceNumber`, `deskripsi`, `timestamp`, `supplier`) VALUES
('IM-1682602365-wm3vIc7T7S', 0, '(90)DTL8713002537A1(91)250130', 'Picked Up By SATRIA', 1682602320000, 'SILA');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `label`, `deskripsi`) VALUES
('kategori-001', 'Sirup', 'Botol sirup'),
('kategori-1682422571-DOjROIvQd2', 'Obat', ''),
('kategori-1682423524-jfgvGGU8XF', 'Inhaler', ''),
('kategori-1682423528-jKgpWFRkar', 'Air Mineral', ''),
('kategori-1682603161-VtDSU3RnSf', 'Meubel', ''),
('kategori-1682906552-rQcrMky9ap', 'Hand Sanitizer', '');

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` varchar(64) NOT NULL,
  `idInvoice` varchar(255) NOT NULL,
  `idProduk` varchar(255) NOT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `idInvoice`, `idProduk`, `sku`, `barcode`, `nama`, `kuantitas`, `harga`) VALUES
('JS-1683002596-HWUGGDpSE3', 'IM-1682602365-wm3vIc7T7S', 'produk-1682403030-yH3CNjIcIF', 'a', '8998888170910', 'Marjan Orange', 5, 35000),
('JS-1683002708-lsmPwHo34S', 'IM-1682602365-wm3vIc7T7S', 'produk-1682423651-AwyCzOaw3N', '(90)QL031700281(91)230112', '4987176008718', 'Vicks', 1, 22000);

-- --------------------------------------------------------

--
-- Table structure for table `penyetokan`
--

CREATE TABLE `penyetokan` (
  `id` varchar(255) NOT NULL,
  `idInvoice` varchar(255) NOT NULL,
  `idProduk` varchar(255) NOT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kuantitas` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyetokan`
--

INSERT INTO `penyetokan` (`id`, `idInvoice`, `idProduk`, `sku`, `barcode`, `nama`, `kuantitas`, `harga`) VALUES
('MS-1683002345-grV6LmVRvZ', 'IM-1682602365-wm3vIc7T7S', 'produk-1682403030-yH3CNjIcIF', 'a', '8998888170910', 'Marjan Orange', '5', '35000');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` varchar(255) NOT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `kategori` varchar(64) DEFAULT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `lokasi` varchar(64) DEFAULT NULL,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `stok` int(11) NOT NULL DEFAULT 0,
  `satuan` char(30) NOT NULL,
  `dimensi` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `sku`, `barcode`, `nama`, `image`, `kategori`, `deskripsi`, `lokasi`, `harga_beli`, `harga_jual`, `stok`, `satuan`, `dimensi`) VALUES
('produk-1682403030-yH3CNjIcIF', 'a', '8998888170910', 'Marjan Orange', NULL, 'kategori-001', 'Rasa Jeruk', 'Rumah Ben', 35000, 40000, 65, 'satuan-001', '0'),
('produk-1682403262-gYMGL6jthV', '', '899888817090', 'Marjan Apel', NULL, 'kategori-001', '', 'Rumah Ben 2', 100000, 20000, 10, 'satuan-001', '30 cm'),
('produk-1682423328-r1GU4eW0Bm', '(90)DTL8713002537A1(91)250130', '8998667300675', 'Siladex Biru', NULL, 'kategori-1682422571-DOjROIvQd2', 'Batuk Pilek', '', 20000, 25000, 1, 'satuan-001', '20 cm'),
('produk-1682423651-AwyCzOaw3N', '(90)QL031700281(91)230112', '4987176008718', 'Vicks', NULL, 'kategori-1682423524-jfgvGGU8XF', '25g', '', 22000, 25000, 1, 'satuan-001', ''),
('produk-1682487494-66CIjdZ8VW', '(90)MD265228049054(91)201210', '8992752011408', 'Vit Air Mineral', NULL, 'kategori-1682423528-jKgpWFRkar', '600 ml', 'UBM', 3500, 4000, 0, 'satuan-001', '600 ml');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `label` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `slug`, `label`) VALUES
('role-08c2e', 'admin', 'Admin'),
('role-bc076', 'manager', 'Manager'),
('role-fdae0', 'operator', 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` varchar(64) NOT NULL,
  `label` char(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `label`, `deskripsi`) VALUES
('satuan-001', 'btl', 'botol'),
('satuan-002', 'dus', 'dus ukuran besar (biasanya lebih dari 1)'),
('satuan-003', 'buah', 'buah'),
('satuan-1682259107-7Ae1IHachL', 'org', 'orang'),
('satuan-1682294919-PbjGsV1hSG', 'box', 'box ukuran kecil (1 barang)'),
('satuan-1682294966-qWjfyixdTN', 'lbr', 'lembar'),
('satuan-1682295124-WdDUyfryKi', 'plastik', 'plastik'),
('satuan-1682334419-SZTMcVYQZM', 'bks', 'bungkus'),
('satuan-1682334432-kfIQlPEqhK', 'scht', 'sachet'),
('satuan-1682334444-jphsmX9w0l', 'klg', 'kaleng'),
('satuan-1682492190-Bsog0QtkOA', 'pak', ''),
('satuan-1682492207-5e1AFsPxuF', 'keping', ''),
('satuan-1682492252-GzSOiQtJNp', 'bar', ''),
('satuan-1682492257-LHJS9DehvT', 'unit', ''),
('satuan-1682492281-dQ9tfHS8zy', 'kntg', 'kantong'),
('satuan-1682603645-UwIBbLzpEB', 'tank', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `role`, `avatar`) VALUES
('user-70ae515b45b20920005e6abcf66fdd2a', 'Dylan Mardi', 'dylanoperator', '$2y$10$FgIq0XwaNMzqvgP6XNm3GeSBOxp8F7E79MCPKGtzt3TWqL.M31UH.', 'role-fdae0', NULL),
('user-96c53ae1c6f38b8a6325d400ce21cd9b', 'Dylan Mardi', 'dylanadmin', '$2y$10$gGDL7pPbBIkjL1UPAbJ3Pek9VKiKV1o7SUemGQhwHkN1RRxna.jaS', 'role-08c2e', NULL),
('user-d31ec6d5503d8d8348292d7031eff4e4', 'Administrator', 'admin', '$2y$10$n7C1O7WkMSsTubaee1A05OH.itgacmu1.9lmSvzvWl0bmwAyDNeVq', 'role-08c2e', NULL),
('user-e76a9633c50a34c2de11866bb34aba27', 'Manager', 'manager', '$2y$10$qRiiXC32N6uuARICk3ZI5eaV1ja4aSrYM8pYLiR7ghlY7EzhxrsIK', 'role-bc076', NULL),
('user-f7e8992831909d670f640e08593227df', 'Operator', 'operator', '$2y$10$YjEB.1WFsVwROSF300r5a.XmeEzd8wDc2auj9LK4/B9TAE6X3iJsO', 'role-fdae0', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProduk` (`idProduk`);

--
-- Indexes for table `inv_keluar`
--
ALTER TABLE `inv_keluar`
  ADD PRIMARY KEY (`referenceNumber`),
  ADD KEY `klien` (`klien`);

--
-- Indexes for table `inv_masuk`
--
ALTER TABLE `inv_masuk`
  ADD PRIMARY KEY (`referenceNumber`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyetokan`
--
ALTER TABLE `penyetokan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idInvoice` (`idInvoice`),
  ADD KEY `idProduk` (`idProduk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori`),
  ADD KEY `satuan` (`satuan`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gambar`
--
ALTER TABLE `gambar`
  ADD CONSTRAINT `gambar_ibfk_1` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`satuan`) REFERENCES `satuan` (`id`);
COMMIT;
