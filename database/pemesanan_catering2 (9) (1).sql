-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 07:08 AM
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
-- Database: `pemesanan_catering2`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm`
--

CREATE TABLE `adm` (
  `ID_ADMIN` int(11) NOT NULL,
  `NAMA_ADMIN` varchar(100) DEFAULT NULL,
  `NO_TELP` varchar(15) DEFAULT NULL,
  `ALAMAT` varchar(255) DEFAULT NULL,
  `FOTO_ADMIN` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adm`
--

INSERT INTO `adm` (`ID_ADMIN`, `NAMA_ADMIN`, `NO_TELP`, `ALAMAT`, `FOTO_ADMIN`, `PASSWORD`) VALUES
(7, 'JAY', '08974834', 'SOLO', 'profil_admin.jpg', '$2y$10$ZpDZ0auiUmkVbUzP81JLluzGYjU5bfJTMf/vam/TpaOquxvF5EQk2');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID_CUSTOMER` int(11) NOT NULL,
  `NAMA_CUSTOMER` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `ALAMAT` varchar(255) DEFAULT NULL,
  `PASS` varchar(60) DEFAULT NULL,
  `saran` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID_CUSTOMER`, `NAMA_CUSTOMER`, `EMAIL`, `ALAMAT`, `PASS`, `saran`) VALUES
(3, 'SAVINA DYAH ARWIANA', 'savinadyah@gmail.com', 'Polanharjo, Klaten', '$2y$10$XuCOmDk8CA5hVrC0E4qwmOVg9k.oN/HrHRBFCo/5U/4t13hJj2SCa', NULL),
(4, 'trafrika nining erina', 'trafrika@gmail.com', 'Klaten', '$2y$10$5SdjkbE8uR37Snaq9bcDhuPlJzFZWvlo7ar..uPH3OfoHR9eob0V6', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_suggestions`
--

CREATE TABLE `customer_suggestions` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `saran` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_suggestions`
--

INSERT INTO `customer_suggestions` (`id`, `customer_name`, `saran`, `created_at`) VALUES
(1, 'FIKA', 'MANTAPPP', '2024-12-16 10:14:38'),
(2, 'KAKA', 'BAGUSS', '2024-12-31 05:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `koki`
--

CREATE TABLE `koki` (
  `ID_KOKI` int(11) NOT NULL,
  `NAMA_KOKI` varchar(100) DEFAULT NULL,
  `SPESIALIS_MENU` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `koki`
--

INSERT INTO `koki` (`ID_KOKI`, `NAMA_KOKI`, `SPESIALIS_MENU`) VALUES
(1, 'Faisal', 'Masakan Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `ID_PESANAN` int(11) NOT NULL,
  `ID_ADMIN` int(11) DEFAULT NULL,
  `ID_MENU` int(11) DEFAULT NULL,
  `ID_CUSTOMER` int(11) DEFAULT NULL,
  `JUMLAH_PESANAN` int(11) DEFAULT NULL,
  `TANGGAL_ACARA` date DEFAULT NULL,
  `ALAMAT_ACARA` varchar(100) NOT NULL,
  `TOTAL_HARGA` decimal(10,2) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL,
  `TANGGAL_PESAN` datetime DEFAULT current_timestamp(),
  `REQUEST` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`ID_PESANAN`, `ID_ADMIN`, `ID_MENU`, `ID_CUSTOMER`, `JUMLAH_PESANAN`, `TANGGAL_ACARA`, `ALAMAT_ACARA`, `TOTAL_HARGA`, `STATUS`, `TANGGAL_PESAN`, `REQUEST`) VALUES
(2, 7, 1, 3, 10, '2025-01-30', 'Polanharjo', 250000.00, 'Disetujui', '2025-01-10 14:16:24', '-'),
(3, 7, 6, 3, 200, '2025-01-23', 'Klaten', 99999999.99, 'Disetujui', '2025-01-10 14:25:12', ''),
(4, 7, 5, 4, 50, '2025-01-15', 'Klaten', 1000000.00, 'Disetujui', '2025-01-10 14:27:55', ''),
(5, 7, 1, 4, 12, '2025-01-13', 'Klaten', 300000.00, 'Disetujui', '2025-01-10 15:46:14', ''),
(6, 7, 6, 4, 200, '2025-01-16', 'KLATEN', 99999999.99, 'Disetujui', '2025-01-10 15:57:41', '');

-- --------------------------------------------------------

--
-- Table structure for table `produk_menu`
--

CREATE TABLE `produk_menu` (
  `ID_MENU` int(11) NOT NULL,
  `NAMA_MENU` varchar(100) DEFAULT NULL,
  `DESKRIPSI` text DEFAULT NULL,
  `HARGA` decimal(10,2) DEFAULT NULL,
  `GAMBAR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_menu`
--

INSERT INTO `produk_menu` (`ID_MENU`, `NAMA_MENU`, `DESKRIPSI`, `HARGA`, `GAMBAR`) VALUES
(1, 'Paket Masakan Indonesia  1', 'Menu masakan Indonesia bisa catering dengan box atau prasmanan.', 25000.00, 'pkt1_nasibox.jpg'),
(2, 'Paket Makanan Jepang', 'Nikmati kelezatan masakan Jepang dengan paket katering kami setiap menu diracik dengan bahan berkualitas tinggi, menawarkan cita rasa Jepang yang lezat dan autentik. Menu tersedia:\r\nSushi, Sashimi, Tempura, Ramen, Teriyaki Chicken\r\n', 50000.00, 'pkt2_jepang.png\r\n'),
(3, 'Paket Masakan Korean', 'Nikmati kelezatan autentik Korea langsung di meja Anda dengan paket katering Korean Food kami. Menawarkan berbagai hidangan khas Korea yang kaya rasa dan menggugah selera. Bulgogi, Kimchi, Bibimbap dengan saus gochujang, Japchae, Tteokbokki, Sundubu, Jjigae, Pajeon. ', 100000.00, 'pkt3_korean.jpg'),
(5, 'Paket SnackBox Arisan', 'Nikmati momen kebersamaan dengan teman dan keluarga dengan Paket Arisan Snack Box dari kami. Paket ini mencakup beragam pilihan camilan lezat dan praktis, mulai dari kue tradisional hingga kue modern, gorengan, dan hidangan manis lainnya.\r\n*Untuk harga /box', 20000.00, 'pkt5_snackbox1.jpg'),
(6, 'Paket Wedding', 'Paket ini tersedia untuk perporsi catering piringan.\r\n- Snack ringan\r\n- Soup\r\n- Nasi + Lauk\r\n- Dessert ( Es Cream)', 28000.00, 'pkt6_nikahan.avif'),
(9, 'Paket Bento', 'Paket Bento terdiri dari beberapa varian. Contohnya: Bento Anak, Remaja, Dewasa', 200000.00, 'pkt8_bento.jpg'),
(10, 'Paket Dessert Box', 'Rasa Dessert Box tersedia diantaranya: Chocolate Lovers Box, Cheese & Cracker Box, Nutty Treats Box', 25000.00, 'pkt7_dessert.jpg'),
(11, 'Mini Pizza Box', 'Varian: Mozarella Sosis, Beef Cheese, Mushrooms', 15000.00, 'pkt9_pizzabox.jpg'),
(12, 'Salad Box', 'Varian: Buah dan Sayur', 10000.00, 'pkt10_saladbox.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_TRANSAKSI` int(11) NOT NULL,
  `ID_PESANAN` int(11) NOT NULL,
  `ID_ADMIN` int(20) NOT NULL,
  `TGL_BAYAR` date DEFAULT NULL,
  `STATUS_PEMBAYARAN` enum('belum dibayar','dibayar','gagal') NOT NULL,
  `METODE_PEMBAYARAN` varchar(100) NOT NULL,
  `jumlah_pembayaran` int(11) NOT NULL,
  `virtual_account` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`ID_TRANSAKSI`, `ID_PESANAN`, `ID_ADMIN`, `TGL_BAYAR`, `STATUS_PEMBAYARAN`, `METODE_PEMBAYARAN`, `jumlah_pembayaran`, `virtual_account`) VALUES
(1, 3, 7, '2025-01-10', 'dibayar', 'Transfer Bank - BCA', 100000000, 1234567890),
(2, 4, 7, '2025-01-10', 'dibayar', 'E-Wallet - OVO', 1000000, 2147483647),
(3, 5, 7, '2025-01-10', 'dibayar', 'Transfer Bank - Mandiri', 300000, 2147483647),
(4, 6, 7, '2025-01-10', 'dibayar', 'Transfer Bank - BCA', 100000000, 1234567890);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID_CUSTOMER`);

--
-- Indexes for table `customer_suggestions`
--
ALTER TABLE `customer_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `koki`
--
ALTER TABLE `koki`
  ADD PRIMARY KEY (`ID_KOKI`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`ID_PESANAN`),
  ADD KEY `ID_MENU` (`ID_MENU`),
  ADD KEY `fk_cust` (`ID_CUSTOMER`),
  ADD KEY `fk_adm` (`ID_ADMIN`);

--
-- Indexes for table `produk_menu`
--
ALTER TABLE `produk_menu`
  ADD PRIMARY KEY (`ID_MENU`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`ID_TRANSAKSI`),
  ADD KEY `ID_PESANAN` (`ID_PESANAN`),
  ADD KEY `fk_admintr` (`ID_ADMIN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adm`
--
ALTER TABLE `adm`
  MODIFY `ID_ADMIN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID_CUSTOMER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_suggestions`
--
ALTER TABLE `customer_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `koki`
--
ALTER TABLE `koki`
  MODIFY `ID_KOKI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `ID_PESANAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk_menu`
--
ALTER TABLE `produk_menu`
  MODIFY `ID_MENU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `ID_TRANSAKSI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_adm` FOREIGN KEY (`ID_ADMIN`) REFERENCES `adm` (`ID_ADMIN`),
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`ID_ADMIN`) REFERENCES `adm` (`ID_ADMIN`),
  ADD CONSTRAINT `fk_cust` FOREIGN KEY (`ID_CUSTOMER`) REFERENCES `customer` (`ID_CUSTOMER`),
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`ID_MENU`) REFERENCES `produk_menu` (`ID_MENU`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_admintr` FOREIGN KEY (`ID_ADMIN`) REFERENCES `adm` (`ID_ADMIN`),
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`ID_PESANAN`) REFERENCES `pesanan` (`ID_PESANAN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
