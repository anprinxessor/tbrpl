-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2014 at 12:54 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prestasi_apps`
--

-- --------------------------------------------------------

--
-- Table structure for table `civitas_akademik`
--

CREATE TABLE IF NOT EXISTS `civitas_akademik` (
  `civitas_akademik_id` int(11) NOT NULL COMMENT 'mhs: bp; dosen:nip',
  `nim` varchar(12) NOT NULL,
  `civitas_akademik_nama` varchar(50) NOT NULL,
  `tmpt_lhr` varchar(30) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(12) NOT NULL,
  `hp` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civitas_akademik_jenis` tinyint(1) NOT NULL COMMENT '0: mhs; 1:dosen',
  `jurusan_id` tinyint(4) NOT NULL,
  `ukm_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`civitas_akademik_id`),
  UNIQUE KEY `nim` (`nim`),
  UNIQUE KEY `hp` (`hp`),
  UNIQUE KEY `email` (`email`),
  KEY `jurusan_id` (`jurusan_id`),
  KEY `ukm_id` (`ukm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `civitas_akademik`
--

INSERT INTO `civitas_akademik` (`civitas_akademik_id`, `nim`, `civitas_akademik_nama`, `tmpt_lhr`, `tgl_lhr`, `alamat`, `telp`, `hp`, `email`, `civitas_akademik_jenis`, `jurusan_id`, `ukm_id`) VALUES
(1010961015, '1010961015', 'Annisa Permatasari', 'Padang', '1992-03-18', 'Asrama TNI-AD Parak Pisang Blok CC No.10 Padang', '075138067', '087895440199', 'annisa.11int1@gmail.com', 0, 2, 1),
(1110961008, '1110961008', 'Heriyandi Elvis', 'Tangerang', '1993-11-10', 'PadangPanjang', '', '08994652036', 'yhandi93@gmail.com', 0, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE IF NOT EXISTS `fakultas` (
  `fakultas_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `fakultas_nama` varchar(50) NOT NULL,
  `fakultas_kode` varchar(2) NOT NULL,
  PRIMARY KEY (`fakultas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`fakultas_id`, `fakultas_nama`, `fakultas_kode`) VALUES
(1, 'Tidak Ada', '0'),
(2, 'Hukum', '01'),
(3, 'Pertanian', '02'),
(11, 'Teknik', '09'),
(12, 'Farmasi', '03'),
(13, 'Ilmu Budaya', '04'),
(14, 'Teknologi Informasi', '15');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE IF NOT EXISTS `jurusan` (
  `jurusan_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `jurusan_nama` varchar(50) NOT NULL,
  `fakultas_id` tinyint(2) NOT NULL,
  PRIMARY KEY (`jurusan_id`),
  KEY `fakultas_id` (`fakultas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`jurusan_id`, `jurusan_nama`, `fakultas_id`) VALUES
(2, 'Sistem Informasi', 14),
(3, 'Sistem Komputer', 14),
(4, 'Teknik Elektro', 11),
(5, 'Farmasi', 12);

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE IF NOT EXISTS `prestasi` (
  `prestasi_id` int(11) NOT NULL AUTO_INCREMENT,
  `peringkat` varchar(255) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `tgl_dari` date NOT NULL,
  `tgl_sampai` date NOT NULL,
  `tingkat_id` tinyint(4) NOT NULL,
  `tingkat_ket` varchar(255) NOT NULL,
  `prestasi_jenis` varchar(20) NOT NULL COMMENT '0: akademik; 1: non',
  `deskripsi` text NOT NULL,
  `status_ukm` varchar(5) NOT NULL,
  `status_baca` tinyint(1) NOT NULL COMMENT '0: belum; 1:sudah',
  PRIMARY KEY (`prestasi_id`),
  KEY `tingkat_id` (`tingkat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=204 ;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`prestasi_id`, `peringkat`, `nama_kegiatan`, `tempat`, `tahun`, `tgl_dari`, `tgl_sampai`, `tingkat_id`, `tingkat_ket`, `prestasi_jenis`, `deskripsi`, `status_ukm`, `status_baca`) VALUES
(1, '1', ' lomba matematika', 'padang', 2014, '2014-06-13', '2014-06-13', 3, '', 'Akademik', 'lomba', 'Tidak', 1),
(24, 'Juara III', ' Web Design Sisfotime', 'Telkom University, Bandung', 2013, '2013-11-02', '2013-11-02', 5, '', 'Akademik', 'Web Design Tema Usaha Kecil Menengah', 'Ya', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prestasi_detail`
--

CREATE TABLE IF NOT EXISTS `prestasi_detail` (
  `prestasi_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `prestasi_id` int(11) NOT NULL,
  `civitas_akademik_id` int(11) NOT NULL,
  `foto_sertifikat` varchar(255) NOT NULL,
  `link_foto` varchar(255) NOT NULL,
  PRIMARY KEY (`prestasi_detail_id`),
  UNIQUE KEY `prestasi_id_2` (`prestasi_id`,`civitas_akademik_id`),
  KEY `prestasi_id` (`prestasi_id`),
  KEY `civitas_akademik_id` (`civitas_akademik_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `prestasi_detail`
--

INSERT INTO `prestasi_detail` (`prestasi_detail_id`, `prestasi_id`, `civitas_akademik_id`, `foto_sertifikat`, `link_foto`) VALUES
(70, 24, 1010961015, 'rose.png', '<img src="sertifikat/rose.png" width="150px"/>'),
(71, 1, 1010961015, 'wolf.png', '<img src="sertifikat/wolf.png" width="150px"/>');

-- --------------------------------------------------------

--
-- Table structure for table `tingkat`
--

CREATE TABLE IF NOT EXISTS `tingkat` (
  `tingkat_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `tingkat_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`tingkat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tingkat`
--

INSERT INTO `tingkat` (`tingkat_id`, `tingkat_nama`) VALUES
(1, 'Jurusan'),
(2, 'Fakultas'),
(3, 'Universitas'),
(4, 'Regional'),
(5, 'Nasional'),
(6, 'Internasional');

-- --------------------------------------------------------

--
-- Table structure for table `ukm`
--

CREATE TABLE IF NOT EXISTS `ukm` (
  `ukm_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ukm_nama` varchar(255) NOT NULL,
  PRIMARY KEY (`ukm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ukm`
--

INSERT INTO `ukm` (`ukm_id`, `ukm_nama`) VALUES
(1, 'Neo Telemetri'),
(3, 'PHP'),
(4, 'Kosbema'),
(5, 'Kopma'),
(7, 'Tidak Ada');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `user_jenis` varchar(50) NOT NULL,
  `fakultas_id` tinyint(2) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  KEY `fakultas_id` (`fakultas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `pass`, `ket`, `user_jenis`, `fakultas_id`) VALUES
(1, 'wr3', '9c0e5a29c34bb2388ee10112e4a4fc46fef17916', 'Wakil Rektor III', 'Wakil Rektor 3', 1),
(2, 'adminuniv', '86b8ab94df644425c408d1ee730b004d2d939a69', 'Admin Universitas', 'Admin Universitas', 1),
(3, 'adminfti', 'b37b101a945267a5464ee2f88234d1395474e505', 'Admin FTI', 'Admin Fakultas', 14),
(4, 'adminteknik', '300b996022306ca162bf70e095f5c6bed1969fa4', 'Admin Teknik', 'Admin Fakultas', 11);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `civitas_akademik`
--
ALTER TABLE `civitas_akademik`
  ADD CONSTRAINT `civitas_akademik_ibfk_1` FOREIGN KEY (`ukm_id`) REFERENCES `ukm` (`ukm_id`),
  ADD CONSTRAINT `civitas_akademik_ibfk_2` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`jurusan_id`);

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_ibfk_1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`fakultas_id`);

--
-- Constraints for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `prestasi_ibfk_1` FOREIGN KEY (`tingkat_id`) REFERENCES `tingkat` (`tingkat_id`);

--
-- Constraints for table `prestasi_detail`
--
ALTER TABLE `prestasi_detail`
  ADD CONSTRAINT `prestasi_detail_ibfk_2` FOREIGN KEY (`prestasi_id`) REFERENCES `prestasi` (`prestasi_id`),
  ADD CONSTRAINT `prestasi_detail_ibfk_3` FOREIGN KEY (`civitas_akademik_id`) REFERENCES `civitas_akademik` (`civitas_akademik_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`fakultas_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
