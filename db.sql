-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2023 at 12:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_keluar`
--

CREATE TABLE `inv_keluar` (
  `id` varchar(255) NOT NULL,
  `pajak` double NOT NULL,
  `referenceNumber` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `klien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inv_keluar`
--

INSERT INTO `inv_keluar` (`id`, `pajak`, `referenceNumber`, `deskripsi`, `timestamp`, `klien`) VALUES
('IM-1683091007-vcLkO1LWgc', 10, 'SCK/030523/1216', 'Open', 1683090999000, 'klien-1683084606-VSHIG01ERB'),
('IM-1683126271-g8Z8BMVAIC', 10, 'SCK/030523/2204', 'PAID', 1683126255000, 'klien-1683084754-kiwxKrAW7z'),
('IM-1683294711-uQzn884xos', 10, 'SCK/020523/2125', 'Open', 1683294706000, 'klien-1683084606-VSHIG01ERB');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `label`, `deskripsi`) VALUES
('kategori-001', 'Sirup', 'Botol sirup'),
('kategori-1682422571-DOjROIvQd2', 'Obat', ''),
('kategori-1682423524-jfgvGGU8XF', 'Inhaler', ''),
('kategori-1682423528-jKgpWFRkar', 'Air Minum', ''),
('kategori-1682603161-VtDSU3RnSf', 'Meubel', ''),
('kategori-1682906552-rQcrMky9ap', 'Hand Sanitizer', ''),
('kategori-1683957128-DGvHikQ8qR', 'Cologne', 'Cologne');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klien`
--

INSERT INTO `klien` (`id`, `nama`, `alamat`, `telepon`, `email`) VALUES
('klien-1683084606-VSHIG01ERB', 'Elgato', 'Jl. Lodan Raya No. 170, Ancol, Jakarta Utara', '0821-1122-4756', 'contact@elgato.com'),
('klien-1683084620-MgLSLZQyYf', 'Justin Darya Yuswira', 'Jl. doang jadian kaga', '0899-8877-665', 'justinsifurry@furry.com'),
('klien-1683084649-KEfR81X6Oq', 'Sumber Daya Cipta', 'Di mana mana hatiku senang', '08139453232', 'sdc@sdc.com'),
('klien-1683084754-kiwxKrAW7z', 'Payes', 'Jl. Pademangan IV, Kec. Pademangan, Jakarta Utara, DKI Jakarta', '0878-7465-5555', 'chatwith@payes.com');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `Nim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`Nim`, `nama`, `tanggal`) VALUES
('101', 'ben', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` varchar(64) NOT NULL,
  `idInvoice` varchar(255) NOT NULL,
  `idProduk` varchar(255) DEFAULT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `idInvoice`, `idProduk`, `sku`, `barcode`, `nama`, `kuantitas`, `harga`) VALUES
('JS-1683863573-uEacrCbPV8', 'IM-1683294711-uQzn884xos', 'produk-1683091836-0Sd6HTouhI', '(90)MD265211001078(91)231029', '8886008101053', 'Aqua ', 20, 4000),
('JS-1683863653-p2CFG8gVmB', 'IM-1683294711-uQzn884xos', 'produk-1682403030-yH3CNjIcIF', 'a', '8998888170910', 'Marjan Orange', 2, 35000),
('JS-1683863665-IEwBxVjZv3', 'IM-1683294711-uQzn884xos', 'produk-1682423651-AwyCzOaw3N', '(90)QL031700281(91)230112', '4987176008718', 'Vicks', 3, 16000);

-- --------------------------------------------------------

--
-- Table structure for table `penyetokan`
--

CREATE TABLE `penyetokan` (
  `id` varchar(255) NOT NULL,
  `idInvoice` varchar(255) NOT NULL,
  `idProduk` varchar(255) DEFAULT NULL,
  `sku` varchar(64) DEFAULT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kuantitas` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `sku`, `barcode`, `nama`, `image`, `kategori`, `deskripsi`, `lokasi`, `harga_beli`, `harga_jual`, `stok`, `satuan`, `dimensi`) VALUES
('produk-1682403030-yH3CNjIcIF', 'a', '8998888170910', 'Marjan Orange', NULL, 'kategori-001', 'Rasa Jeruk', 'Rumah Ben', 35000, 40000, 60, 'satuan-001', '0'),
('produk-1682403262-gYMGL6jthV', '', '899888817090', 'Marjan Apel', NULL, 'kategori-001', '', 'Rumah Ben 2', 100000, 20000, 5, 'satuan-001', '30 cm'),
('produk-1682423328-r1GU4eW0Bm', '(90)DTL8713002537A1(91)250130', '8998667300675', 'Siladex Biru', NULL, 'kategori-1682422571-DOjROIvQd2', 'Batuk Pilek', '', 20000, 25000, 11, 'satuan-001', '20 cm'),
('produk-1682423651-AwyCzOaw3N', '(90)QL031700281(91)230112', '4987176008718', 'Vicks', NULL, 'kategori-1682423524-jfgvGGU8XF', '25g', '', 16000, 21000, 1, 'satuan-1682294966-qWjfyixdTN', ''),
('produk-1682487494-66CIjdZ8VW', '(90)MD265228049054(91)201210', '8992752011408', 'Vit Air Mineral', NULL, 'kategori-1682423528-jKgpWFRkar', '600 ml', 'UBM', 3500, 4000, 5, 'satuan-001', '600 ml'),
('produk-1683091675-EdKs1EL7sD', '(90)MD265210015032(91)250518', '8992761139018', 'Ades', NULL, 'kategori-1682423528-jKgpWFRkar', 'Air Mineral 600 ml', '', 4000, 5000, 120, 'satuan-001', '600 ml'),
('produk-1683091836-0Sd6HTouhI', '(90)MD265211001078(91)231029', '8886008101053', 'Aqua ', NULL, 'kategori-1682423528-jKgpWFRkar', '600 ml', '', 4000, 5000, 41, 'satuan-001', '600 ml');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `label` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('satuan-1682492252-GzSOiQtJNp', 'bar', 'mawar'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `telepon`, `email`) VALUES
('supplier-1683084606-VSHIG01ERB', 'ElSupply', 'Elgato Supply Chain', '08123456789', 'contact@elgato.com'),
('supplier-1683119186-kgTb9ryWeb', 'Mixue Supply Chain', 'Jl. Internasional, Blok M, Jakarta Selatan', '+861239123812', 'chatme@mixue.com'),
('supplier-1683958094-0ERnrjcakz', 'PT Tirta Mas Perkasa', 'Depok 16457', '0800-15-99999', 'minum@vit.co.id');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `role`, `avatar`) VALUES
('user-2e7d42e4599fbd82880b2219440b5a4e', 'ben', 'ben', '$2y$10$.quQe4gkib9J/7IhB9B.DuhWZbz47DNWEwDYOgQuwaNfxGkTAqFuG', 'role-fdae0', NULL),
('user-603de254eb03bc864f6bb36e118e8b5b', 'Dylan Mardi', 'dylanmanager', '$2y$10$Lw9lIG4ljr9RNzEYtfE0BeR6kco9dRXJa.RJXS4wTCIpM5bqop3cS', 'role-bc076', NULL),
('user-70ae515b45b20920005e6abcf66fdd2a', 'Dylan Mardi', 'dylanoperator', '$2y$10$FgIq0XwaNMzqvgP6XNm3GeSBOxp8F7E79MCPKGtzt3TWqL.M31UH.', 'role-fdae0', NULL),
('user-96c53ae1c6f38b8a6325d400ce21cd9b', 'Dylan Mardi', 'dylanadmin', '$2y$10$gGDL7pPbBIkjL1UPAbJ3Pek9VKiKV1o7SUemGQhwHkN1RRxna.jaS', 'role-08c2e', NULL),
('user-ca4d876d6a3a000e15942b44e92eab9f', 'Raphael Benedict', 'baneneb', '$2y$10$Nni08.3P/D05gW7QjWiPDuI4yLE2lKnMS2u8AuFl7SHgwewXM0CUW', 'role-08c2e', NULL),
('user-d31ec6d5503d8d8348292d7031eff4e4', 'Administrator', 'admin', '$2y$10$ygJvkL7WBZtu4jEU9V./G.o9ej1iy/ofMP6c4mjVZdCkwjsK5HCsG', 'role-08c2e', NULL),
('user-db5ccad1d5befc581859877c2d60ebac', 'Dylan Mardi', 'dyl_admin', '$2y$10$H0xuZxh8/S0E3HYVug/0zuuVuDQ4b2hoLMBwYbtOK7Yf/4q8cgkfO', 'role-08c2e', '1683956890_c2e0aec40df33a5e1761.png'),
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `klien` (`klien`);

--
-- Indexes for table `inv_masuk`
--
ALTER TABLE `inv_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier` (`supplier`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`Nim`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProduk_produk` (`idProduk`),
  ADD KEY `idInvoice_invKeluar` (`idInvoice`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gambar`
--
ALTER TABLE `gambar`
  ADD CONSTRAINT `gambar_ibfk_1` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`id`);

--
-- Constraints for table `inv_keluar`
--
ALTER TABLE `inv_keluar`
  ADD CONSTRAINT `klien_klien` FOREIGN KEY (`klien`) REFERENCES `klien` (`id`);

--
-- Constraints for table `inv_masuk`
--
ALTER TABLE `inv_masuk`
  ADD CONSTRAINT `supplier_idSupplier` FOREIGN KEY (`supplier`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `idInvoice_invKeluar` FOREIGN KEY (`idInvoice`) REFERENCES `inv_keluar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idProduk_produk` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `penyetokan`
--
ALTER TABLE `penyetokan`
  ADD CONSTRAINT `idInvoice` FOREIGN KEY (`idInvoice`) REFERENCES `inv_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idProduk` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`satuan`) REFERENCES `satuan` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `role` FOREIGN KEY (`role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
