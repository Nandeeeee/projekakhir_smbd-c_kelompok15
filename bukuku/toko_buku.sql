-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2025 pada 18.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_buku`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalPendapatanPerPeriode` (IN `tanggal_awal` DATE, IN `tanggal_akhir` DATE)   BEGIN
SELECT 
SUM(TotalHarga) as Total
FROM Penjualan
WHERE TanggalPenjualan BETWEEN tanggal_awal AND tanggal_akhir;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CariBuku` (IN `keyword` VARCHAR(100))   BEGIN
SELECT * FROM Buku
WHERE 
Judul LIKE CONCAT('%', keyword, '%') OR
Pengarang LIKE CONCAT('%', keyword, '%') OR
Penerbit LIKE CONCAT('%', keyword, '%') OR
TahunTerbit LIKE CONCAT('%', keyword, '%') OR
Harga LIKE CONCAT('%', keyword, '%') OR
Stok LIKE CONCAT('%', keyword, '%') OR
Keterangan LIKE CONCAT('%', keyword, '%');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LihatTransaksiPelanggan` (IN `p_id` INT)   BEGIN
SELECT * FROM View_DetailTransaksi WHERE IDPelanggan = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TambahPelanggan` (IN `p_nama` VARCHAR(100), IN `p_alamat` TEXT, IN `p_nohp` VARCHAR(15), IN `p_email` VARCHAR(200), IN `p_password` VARCHAR(200))   BEGIN
INSERT INTO Pelanggan (NamaPelanggan, Alamat, NoHP, email, password)
VALUES (p_nama, p_alamat, p_nohp, p_email, p_password);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdateBuku` (IN `p_judul` VARCHAR(100), IN `p_pengaran` VARCHAR(100), IN `p_penerbit` VARCHAR(100), IN `p_tahun` YEAR, IN `p_harga` INT, IN `p_stok` INT, IN `p_keterangan` VARCHAR(100), IN `p_gambar` VARCHAR(100), IN `p_kode` VARCHAR(100))   BEGIN
    UPDATE buku SET 
    Judul = p_judul,
    Pengarang = p_pengaran,
    Penerbit = p_penerbit,
    TahunTerbit = p_tahun,
    Harga = p_harga,
    Stok = p_stok,
    Keterangan = p_keterangan,
    gambar = p_gambar
    WHERE KodeBuku = p_kode;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `KodeBuku` varchar(10) NOT NULL,
  `Judul` varchar(100) NOT NULL,
  `Pengarang` varchar(100) DEFAULT NULL,
  `Penerbit` varchar(100) DEFAULT NULL,
  `TahunTerbit` int(11) DEFAULT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `Stok` int(11) NOT NULL,
  `Keterangan` varchar(200) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`KodeBuku`, `Judul`, `Pengarang`, `Penerbit`, `TahunTerbit`, `Harga`, `Stok`, `Keterangan`, `gambar`) VALUES
('BK002', 'apa', 'asdasd', 'asd', 2024, 123.00, 123, 'asd', 'img/2117781834_2.jpg'),
('BK003', 'apa', 'asdasd', 'asd', 2024, 123.00, 123, 'asd', 'img/2117781834_2.jpg'),
('BK004', 'apaasd', 'Bapak budi', 'asdasd', 2024, 123.00, 123, 'asd', 'img/2117781834_2.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `IDDetailPenjualan` int(11) NOT NULL,
  `IDPenjualan` int(11) DEFAULT NULL,
  `KodeBuku` varchar(10) DEFAULT NULL,
  `Jumlah` int(11) NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL,
  `StatusTransaksi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`IDDetailPenjualan`, `IDPenjualan`, `KodeBuku`, `Jumlah`, `SubTotal`, `StatusTransaksi`) VALUES
(2, 1, 'BK002', 1, 85000.00, NULL),
(3, 2, 'BK003', 1, 120000.00, NULL),
(5, 3, 'BK003', 1, 120000.00, 'Non-Aktif'),
(6, 4, 'BK002', 1, 90000.00, 'Pasif'),
(8, 5, 'BK003', 1, 70000.00, NULL),
(9, 6, 'BK002', 2, 180000.00, 'Aktif'),
(11, 7, 'BK003', 1, 120000.00, NULL),
(303, 206, 'BK003', 1, 120000.00, ''),
(304, 207, 'BK003', 1, 120000.00, ''),
(305, 208, 'BK003', 1, 120000.00, ''),
(306, 209, 'BK003', 1, 120000.00, '');

--
-- Trigger `detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `trg_kembalikan_stok_buku` AFTER DELETE ON `detail_penjualan` FOR EACH ROW BEGIN
UPDATE Buku
SET Stok = Stok + OLD.Jumlah
WHERE KodeBuku = OLD.KodeBuku;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_kurangi_stok_buku` AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
UPDATE Buku
SET Stok = Stok - NEW.Jumlah
WHERE KodeBuku = NEW.KodeBuku;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_stok_buku` AFTER UPDATE ON `detail_penjualan` FOR EACH ROW BEGIN
DECLARE selisih INT;
SET selisih = NEW.Jumlah - OLD.Jumlah;

UPDATE Buku
SET Stok = Stok - selisih
WHERE KodeBuku = NEW.KodeBuku;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `IDPegawai` int(11) NOT NULL,
  `NamaPegawai` varchar(100) NOT NULL,
  `Jabatan` varchar(50) DEFAULT NULL,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`IDPegawai`, `NamaPegawai`, `Jabatan`, `Pass`) VALUES
(2, 'Tono', 'admin', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `IDPelanggan` int(11) NOT NULL,
  `NamaPelanggan` varchar(100) NOT NULL,
  `Alamat` text DEFAULT NULL,
  `NoHP` varchar(15) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`IDPelanggan`, `NamaPelanggan`, `Alamat`, `NoHP`, `email`, `password`) VALUES
(1, 'Rina', 'Jl. Melati No.5', '081234567890', 'asdd@gmail.com', '123'),
(2, 'Dedi', 'Jl. Mawar No.10', '081298765432', 'asd@gmail.com', '123'),
(3, 'Sinta', 'Jl. Kenanga No.12', '082112233445', 'asd@gmail.com', '123'),
(4, 'Dedi Update', 'Alamat Baru', '081200000000', 'asd@gmail.com', '123'),
(5, 'Sari Dewi', 'Jl. Teratai No.23', '088812345678', 'asd@gmail.com', '123'),
(19, 'Nur muhammad', 'JL.Pahlawan GG V NO 14 C 003/004 Karangduak Kota Sumenep', '081234567890', 'nur@gmail.com', '123'),
(26, 'Kontol', 'Memek', '081234567890', 'kntl@gmail.com', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `IDPenjualan` int(11) NOT NULL,
  `TanggalPenjualan` datetime DEFAULT current_timestamp(),
  `IDPelanggan` int(11) DEFAULT NULL,
  `IDPegawai` int(11) DEFAULT NULL,
  `TotalHarga` decimal(10,2) NOT NULL,
  `StatusPembayaran` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`IDPenjualan`, `TanggalPenjualan`, `IDPelanggan`, `IDPegawai`, `TotalHarga`, `StatusPembayaran`) VALUES
(1, '2025-04-01 00:00:00', 1, NULL, 255000.00, 'Sukses'),
(2, '2025-04-05 00:00:00', 2, 2, 180000.00, 'Sukses'),
(3, '2025-04-10 00:00:00', 3, NULL, 300000.00, 'Sukses'),
(4, '2025-04-12 00:00:00', 1, 2, 90000.00, 'Sukses'),
(5, '2025-04-14 00:00:00', 2, NULL, 740000.00, 'Sukses'),
(6, '2025-04-15 00:00:00', 3, 2, 1280000.00, 'Sukses'),
(7, '2025-04-16 00:00:00', 1, NULL, 555000.00, 'Sukses'),
(206, '2025-05-12 00:00:00', NULL, NULL, 120000.00, 'Lunas'),
(207, '2025-05-16 00:00:00', NULL, NULL, 120000.00, 'Lunas'),
(208, '2025-05-16 00:00:00', 19, NULL, 123.00, 'Lunas'),
(209, '2025-05-16 00:00:00', NULL, NULL, 120000.00, 'Lunas');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_bukuhabisstok`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_bukuhabisstok` (
`KodeBuku` varchar(10)
,`Judul` varchar(100)
,`Pengarang` varchar(100)
,`Penerbit` varchar(100)
,`TahunTerbit` int(11)
,`Harga` decimal(10,2)
,`Stok` int(11)
,`Keterangan` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_detailtransaksi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_detailtransaksi` (
`KodeBuku` varchar(10)
,`Judul` varchar(100)
,`Pengarang` varchar(100)
,`Penerbit` varchar(100)
,`TahunTerbit` int(11)
,`Harga` decimal(10,2)
,`Stok` int(11)
,`Keterangan` varchar(200)
,`IDDetailPenjualan` int(11)
,`Jumlah` int(11)
,`SubTotal` decimal(10,2)
,`StatusTransaksi` varchar(20)
,`IDPenjualan` int(11)
,`TanggalPenjualan` datetime
,`TotalHarga` decimal(10,2)
,`StatusPembayaran` varchar(20)
,`IDPelanggan` int(11)
,`NamaPelanggan` varchar(100)
,`Alamat` text
,`NoHP` varchar(15)
,`email` varchar(255)
,`password` varchar(255)
,`IDPegawai` int(11)
,`NamaPegawai` varchar(100)
,`Jabatan` varchar(50)
,`Pass` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_jumlahbukuterjual`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_jumlahbukuterjual` (
`KodeBuku` varchar(10)
,`Judul` varchar(100)
,`TotalTerjual` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_pelangganterbaik`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_pelangganterbaik` (
`IDPelanggan` int(11)
,`NamaPelanggan` varchar(100)
,`TotalBelanja` decimal(32,2)
,`JumlahTransaksi` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_totalpenjualanperhari`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_totalpenjualanperhari` (
`TanggalPenjualan` datetime
,`JumlahTransaksi` bigint(21)
,`TotalPendapatan` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_bukuhabisstok`
--
DROP TABLE IF EXISTS `view_bukuhabisstok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_bukuhabisstok`  AS SELECT `buku`.`KodeBuku` AS `KodeBuku`, `buku`.`Judul` AS `Judul`, `buku`.`Pengarang` AS `Pengarang`, `buku`.`Penerbit` AS `Penerbit`, `buku`.`TahunTerbit` AS `TahunTerbit`, `buku`.`Harga` AS `Harga`, `buku`.`Stok` AS `Stok`, `buku`.`Keterangan` AS `Keterangan` FROM `buku` WHERE `buku`.`Stok` <= 3 ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_detailtransaksi`
--
DROP TABLE IF EXISTS `view_detailtransaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_detailtransaksi`  AS SELECT `b`.`KodeBuku` AS `KodeBuku`, `b`.`Judul` AS `Judul`, `b`.`Pengarang` AS `Pengarang`, `b`.`Penerbit` AS `Penerbit`, `b`.`TahunTerbit` AS `TahunTerbit`, `b`.`Harga` AS `Harga`, `b`.`Stok` AS `Stok`, `b`.`Keterangan` AS `Keterangan`, `dp`.`IDDetailPenjualan` AS `IDDetailPenjualan`, `dp`.`Jumlah` AS `Jumlah`, `dp`.`SubTotal` AS `SubTotal`, `dp`.`StatusTransaksi` AS `StatusTransaksi`, `j`.`IDPenjualan` AS `IDPenjualan`, `j`.`TanggalPenjualan` AS `TanggalPenjualan`, `j`.`TotalHarga` AS `TotalHarga`, `j`.`StatusPembayaran` AS `StatusPembayaran`, `pl`.`IDPelanggan` AS `IDPelanggan`, `pl`.`NamaPelanggan` AS `NamaPelanggan`, `pl`.`Alamat` AS `Alamat`, `pl`.`NoHP` AS `NoHP`, `pl`.`email` AS `email`, `pl`.`password` AS `password`, `pg`.`IDPegawai` AS `IDPegawai`, `pg`.`NamaPegawai` AS `NamaPegawai`, `pg`.`Jabatan` AS `Jabatan`, `pg`.`Pass` AS `Pass` FROM ((((`detail_penjualan` `dp` join `buku` `b` on(`b`.`KodeBuku` = `dp`.`KodeBuku`)) join `penjualan` `j` on(`j`.`IDPenjualan` = `dp`.`IDPenjualan`)) join `pelanggan` `pl` on(`j`.`IDPelanggan` = `pl`.`IDPelanggan`)) left join `pegawai` `pg` on(`j`.`IDPegawai` = `pg`.`IDPegawai`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_jumlahbukuterjual`
--
DROP TABLE IF EXISTS `view_jumlahbukuterjual`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jumlahbukuterjual`  AS SELECT `b`.`KodeBuku` AS `KodeBuku`, `b`.`Judul` AS `Judul`, sum(`dp`.`Jumlah`) AS `TotalTerjual` FROM (`detail_penjualan` `dp` join `buku` `b` on(`dp`.`KodeBuku` = `b`.`KodeBuku`)) GROUP BY `b`.`Judul` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_pelangganterbaik`
--
DROP TABLE IF EXISTS `view_pelangganterbaik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_pelangganterbaik`  AS SELECT `pl`.`IDPelanggan` AS `IDPelanggan`, `pl`.`NamaPelanggan` AS `NamaPelanggan`, sum(`p`.`TotalHarga`) AS `TotalBelanja`, count(`p`.`IDPenjualan`) AS `JumlahTransaksi` FROM (`pelanggan` `pl` join `penjualan` `p` on(`pl`.`IDPelanggan` = `p`.`IDPelanggan`)) GROUP BY `pl`.`IDPelanggan` ORDER BY sum(`p`.`TotalHarga`) DESC ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_totalpenjualanperhari`
--
DROP TABLE IF EXISTS `view_totalpenjualanperhari`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_totalpenjualanperhari`  AS SELECT `penjualan`.`TanggalPenjualan` AS `TanggalPenjualan`, count(0) AS `JumlahTransaksi`, sum(`penjualan`.`TotalHarga`) AS `TotalPendapatan` FROM `penjualan` GROUP BY `penjualan`.`TanggalPenjualan` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`KodeBuku`);

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`IDDetailPenjualan`),
  ADD KEY `IDPenjualan` (`IDPenjualan`),
  ADD KEY `KodeBuku` (`KodeBuku`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`IDPegawai`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`IDPelanggan`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`IDPenjualan`),
  ADD KEY `IDPelanggan` (`IDPelanggan`),
  ADD KEY `IDPegawai` (`IDPegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `IDDetailPenjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `IDPegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `IDPelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `IDPenjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`IDPenjualan`) REFERENCES `penjualan` (`IDPenjualan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`KodeBuku`) REFERENCES `buku` (`KodeBuku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`IDPelanggan`) REFERENCES `pelanggan` (`IDPelanggan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`IDPegawai`) REFERENCES `pegawai` (`IDPegawai`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
