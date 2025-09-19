-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Des 2024 pada 10.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendataan_warga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `nama_pekerjaan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_pekerjaan`, `nama_pekerjaan`) VALUES
(1, 'Developer'),
(2, 'Dokter'),
(3, 'Guru'),
(4, 'Insinyur'),
(5, 'Programmer'),
(6, 'Desainer Grafis'),
(7, 'Pekerja Sosial'),
(8, 'Arsitek'),
(9, 'Pengacara'),
(10, 'Akuntan'),
(11, 'Manager'),
(12, 'Kasir'),
(13, 'Jurnalis'),
(14, 'Pramugari'),
(15, 'Petani'),
(16, 'Supir'),
(17, 'Koki'),
(18, 'Penulis'),
(19, 'Penyanyi'),
(20, 'Fotografer'),
(21, 'Teknisi'),
(22, 'Pemrogram Web'),
(23, 'Analisis Data'),
(24, 'Penyiar Radio'),
(25, 'Pembantu Rumah Tangga'),
(26, 'Karyawan Toko'),
(27, 'Marketing'),
(28, 'Manajer Sumber Daya Manusia (HRD)'),
(29, 'Pengusaha'),
(30, 'Pemandu Wisata'),
(31, 'Security');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'hangga', 'hangga', '123456');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `bahasa_indonesia` decimal(5,2) DEFAULT NULL,
  `matematika` decimal(5,2) DEFAULT NULL,
  `ipa` decimal(5,2) DEFAULT NULL,
  `hasil` decimal(5,2) DEFAULT NULL,
  `nem` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_nilai`
--

INSERT INTO `tb_nilai` (`id_nilai`, `student_id`, `nama`, `bahasa_indonesia`, `matematika`, `ipa`, `hasil`, `nem`) VALUES
(13, 5, NULL, 9.00, 8.00, 8.00, 8.33, 25.00),
(14, 12, NULL, 6.00, 6.00, 5.00, 5.00, 17.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `student_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nomor_induk` varchar(20) NOT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`student_id`, `nama`, `nomor_induk`, `jenis_kelamin`, `agama`, `alamat`) VALUES
(5, 'Putritama', '15', 'Perempuan', 'Kristen', 'Prambanan\r\n'),
(12, 'Gara', '12', 'Laki-laki', 'islam', 'Klaten');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warga`
--

CREATE TABLE `warga` (
  `id_warga` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `id_pekerjaan` int(11) DEFAULT NULL,
  `dokumen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `warga`
--

INSERT INTO `warga` (`id_warga`, `nama_lengkap`, `tanggal_lahir`, `alamat`, `nomor_telepon`, `id_pekerjaan`, `dokumen`) VALUES
(1, 'Hanggara Putra ', '2024-11-18', 'Klaten', '0813489502', 1, NULL),
(13, 'Hanggara', '2024-11-19', 'Klaten', '0813489501', 20, NULL),
(15, 'Gaga', '2024-11-20', 'Jogja', '0813489504', 13, NULL),
(16, 'Gugu', '2024-11-13', 'Jogja', '0813489505', 17, NULL),
(17, 'Putri', '2024-11-20', 'Jogja', '0813489506', 19, NULL),
(19, 'Putra putriiii', '2024-11-28', 'Klaten', '0813489509', 18, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `student_id` (`student_id`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `nomor_induk` (`nomor_induk`);

--
-- Indeks untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id_warga`),
  ADD KEY `id_pekerjaan` (`id_pekerjaan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `warga`
--
ALTER TABLE `warga`
  MODIFY `id_warga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD CONSTRAINT `tb_nilai_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tb_siswa` (`student_id`);

--
-- Ketidakleluasaan untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
