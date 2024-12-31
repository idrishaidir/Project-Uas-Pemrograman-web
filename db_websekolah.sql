-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2024 pada 11.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_websekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID` bigint(10) NOT NULL,
  `Nama` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID`, `Nama`, `username`, `password`, `email`) VALUES
(11, 'IDRIS HAIDIR ALI', 'idris', '$2y$10$cDREAKlK6yOQ9i.aaVuPk.izhDKy9pcvJpNzjvy8XU8G98H1.UA9q', 'aliidir006@gmail.com'),
(13, 'ADITIYA SAPUTRA', 'adit', '$2y$10$ju3LqTJSe9bLch9n6NnDxOs7xnza9tj4O/5kWxU.XAj3P6.1J1o0G', 'adit@mail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `ID` int(10) NOT NULL,
  `Judul` varchar(255) NOT NULL,
  `Kategori` varchar(50) NOT NULL,
  `Isi` text NOT NULL,
  `Gambar` varchar(255) NOT NULL,
  `Teks` text NOT NULL,
  `Tanggal` datetime NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Viewnum` int(20) NOT NULL,
  `Post_type` varchar(20) NOT NULL,
  `Terbit` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`ID`, `Judul`, `Kategori`, `Isi`, `Gambar`, `Teks`, `Tanggal`, `Author`, `Viewnum`, `Post_type`, `Terbit`) VALUES
(21, 'afs,ndkasnkdasn', 'ekstrakurikuler', '<p>dasdasda<br></p>', 'assets/info/berita/idris.jpg', 'asdas', '2024-12-28 20:53:29', 'idris', 0, 'berita', '0'),
(10, 'SISWA SMA HOGWARTS MENJUARAI TURNAMEN BASKET', 'prestasi', '<p>Hogwarts, 23 Desember 2024 — Siswa SMA Hogwarts kembali mencetak prestasi gemilang dengan memenangkan Turnamen Basket Antar SMA se-Britania Raya. Kompetisi yang berlangsung di London Sports Arena ini mempertemukan tim-tim terbaik dari berbagai sekolah, namun tim Hogwarts berhasil mengungguli lawan-lawannya dengan permainan yang memukau.</p><p>Di final yang berlangsung Minggu malam, tim Hogwarts menghadapi SMA Beauxbatons yang dikenal sebagai tim unggulan. Pertandingan berlangsung sengit dengan skor akhir 89-85 untuk kemenangan Hogwarts. Keberhasilan ini tidak lepas dari kerja sama tim yang solid dan kepemimpinan kapten tim, Harry Gryffindor, yang mencetak triple-double dengan 25 poin, 12 assist, dan 10 rebound.</p><p><br></p><p>Pelatih tim, Minerva McGonagall, memuji perjuangan anak asuhnya. \"Mereka tidak hanya menunjukkan kemampuan fisik yang luar biasa, tetapi juga semangat pantang menyerah. Saya sangat bangga dengan mereka,\" ujarnya usai pertandingan.</p><p><br></p><p>Kemenangan ini sekaligus menjadi bukti bahwa SMA Hogwarts tidak hanya unggul di bidang akademik dan magis, tetapi juga dalam olahraga. Kepala sekolah, Albus Dumbledore, mengucapkan selamat kepada tim basket dalam acara penyambutan di Hogwarts Hall. \"Semangat dan kerja keras kalian adalah inspirasi bagi seluruh siswa Hogwarts,\" katanya.</p><p>Salah satu pemain, Luna Lovegood, yang mencetak tembakan tiga angka penentu kemenangan, mengungkapkan kebahagiaannya. \"Kami telah bekerja keras selama berbulan-bulan, dan hasilnya sungguh luar biasa. Saya berterima kasih kepada tim atas kepercayaan dan dukungan mereka,\" ujar Luna.</p><p>Dengan kemenangan ini, tim basket SMA Hogwarts berhak membawa pulang piala juara serta beasiswa olahraga untuk melanjutkan karier di bidang basket. Perayaan kemenangan direncanakan akan digelar di lapangan utama Hogwarts pada malam Tahun Baru.</p><p>Selamat untuk SMA Hogwarts atas pencapaiannya!</p><p></p>', 'assets/info/berita/SISWA_SMA_HOGWARTS_MENJUARAI_TURNAMEN_BASKET.jpg', 'PRESTASI SMA HOGWARTS', '2024-12-23 11:29:42', 'idris', 0, 'berita', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `ID` int(5) NOT NULL,
  `Kategori` varchar(100) NOT NULL,
  `alias` varchar(5) NOT NULL,
  `Terbit` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`ID`, `Kategori`, `alias`, `Terbit`) VALUES
(6, 'prestasi', 'prs', '1'),
(7, 'organisasi', 'ogs', '1'),
(8, 'ekstrakurikuler', 'eks', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `ID` int(5) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Tax` varchar(100) NOT NULL,
  `Isi` text NOT NULL,
  `Link` varchar(100) NOT NULL,
  `Tipe` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konfigurasi`
--

INSERT INTO `konfigurasi` (`ID`, `Nama`, `Tax`, `Isi`, `Link`, `Tipe`) VALUES
(11, 'Judul Situs', 'site_title', 'Portal Berita', 'http://localhost/matkul-web/Project%20UAS/admin/admin.php', 'konfigurasi'),
(17, 'Judul Situs', 'detail-info', 'Prestasi SMA Hogwarts', 'http://localhost/matkul-web/Project%20UAS/public/detail.php?id=10', 'konfigurasi'),
(18, 'Judul Situs', 'site_title', 'Info SMA Hogwarts', 'http://localhost/matkul-web/Project%20UAS/public/info.php', 'konfigurasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimoni`
--

CREATE TABLE `testimoni` (
  `Nama` varchar(255) NOT NULL,
  `Tanggal` date NOT NULL,
  `Isi` text NOT NULL,
  `Sebagai` varchar(255) NOT NULL,
  `Gambar` varchar(255) NOT NULL,
  `ID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `testimoni`
--

INSERT INTO `testimoni` (`Nama`, `Tanggal`, `Isi`, `Sebagai`, `Gambar`, `ID`) VALUES
('agus supriyadi', '2024-12-25', 'Belajar di SMA HOGWARTS Jakarta adalah pengalaman yang luar biasa. Guru-guru yang profesional dan fasilitas yang lengkap membuat saya siap menghadapi dunia kerja. Selain itu, kegiatan ekstrakurikuler di sekolah ini sangat membantu saya mengembangkan keterampilan non-akademik. Saya sangat bangga menjadi bagian dari sekolah ini.', 'siswa', 'assets/testimoni/agus_supriyadi.jpg', 11),
('Mikasa', '2024-12-27', '<p>Saya sangat berterima kasih kepada SMK Hogwarts atas pengalaman belajar yang luar biasa. Lingkungan yang mendukung, guru yang berdedikasi, serta fasilitas yang memadai telah memberikan saya bekal yang kuat untuk meraih kesuksesan. Di sini, saya tidak hanya mendapatkan ilmu akademik tetapi juga pelajaran berharga tentang kedisiplinan, tanggung jawab, dan kerja keras yang terus saya aplikasikan hingga hari ini.</p>', 'Siswa', 'assets/testimoni/Mikasa.jpg', 15);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD KEY `ID` (`ID`);

--
-- Indeks untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
