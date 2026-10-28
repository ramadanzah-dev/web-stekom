/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: stekom
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggota` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `angkatan` year(4) NOT NULL,
  `divisi_id` tinyint(3) unsigned DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `anggota_nim_unique` (`nim`),
  KEY `anggota_divisi_id_index` (`divisi_id`),
  CONSTRAINT `anggota_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `berita` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `ringkasan` varchar(320) NOT NULL,
  `isi` text NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `diterbitkan_pada` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_slug_unique` (`slug`),
  KEY `berita_diterbitkan_pada_index` (`diterbitkan_pada`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berita`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `berita` WRITE;
/*!40000 ALTER TABLE `berita` DISABLE KEYS */;
INSERT INTO `berita` VALUES
(1,'Tim STEKOM Juara 2 Kompetisi IoT Nasional','tim-stekom-juara-2-kompetisi-iot-nasional','img/berita/tim-stekom-juara-2-kompetisi-iot-nasional.svg','Prestasi','Perangkat pemantau kualitas air karya tiga mahasiswa Sistem Komputer menempati posisi runner-up di kompetisi IoT nasional.','Tim STEKOM kembali membawa pulang prestasi. Perangkat pemantau kualitas air berbasis sensor dan dashboard real-time karya tiga mahasiswa Sistem Komputer berhasil meraih juara kedua pada Kompetisi IoT Nasional yang digelar akhir pekan lalu.\n\nPerangkat bernama Tirta Watch ini membaca tingkat keasaman, kekeruhan, dan suhu air, lalu mengirimkan data ke dashboard yang bisa dipantau dari jarak jauh. Prototipe dikembangkan selama enam minggu dengan pendampingan dosen dan alumni.\n\n\"Kami ingin teknologi tidak berhenti di demo. Tantangannya adalah membuat alat ini murah, tahan lama, dan mudah dipakai di lapangan,\" ujar ketua tim, Raka Pratama.\n\nKe depan, tim berencana menguji perangkat di beberapa titik sungai bersama komunitas lingkungan kampus.','Humas STEKOM','2026-10-24 09:00:00','2026-10-26 05:48:40','2026-10-26 06:13:55'),
(2,'Open Recruitment Anggota STEKOM 2026/2027 Resmi Dibuka','open-recruitment-anggota-stekom-2026-2027','img/berita/open-recruitment-anggota-stekom-2026-2027.svg','Pengumuman','Pendaftaran anggota baru STEKOM dibuka untuk seluruh mahasiswa aktif Sistem Komputer. Simak alur dan jadwal lengkapnya.','STEKOM membuka pendaftaran anggota baru untuk periode 2026/2027. Rekrutmen terbuka bagi seluruh mahasiswa aktif program studi Sistem Komputer yang ingin belajar, berkarya, dan bertumbuh bersama.\n\nPendaftaran dilakukan secara daring sampai 30 November 2026. Setelah itu, peserta akan mengikuti sesi perkenalan divisi, wawancara singkat, dan proyek kolaborasi sebagai bagian dari proses seleksi.\n\nTidak ada syarat pengalaman sebelumnya. Yang kami cari adalah rasa ingin tahu, komitmen, dan kemauan untuk bekerja dalam tim. Setiap anggota baru akan didampingi mentor dari divisi pilihannya.\n\nInformasi lengkap dan tautan pendaftaran bisa didapat melalui akun Instagram resmi STEKOM atau dengan menghubungi pengurus.','Pengurus STEKOM','2026-10-18 08:00:00','2026-10-26 05:48:40','2026-10-26 06:13:55'),
(3,'Sistem Komputer Expo 2026, Ruang Temu Karya dan Industri','sistem-komputer-expo-2026','img/berita/sistem-komputer-expo-2026.svg','Kegiatan','Pameran karya mahasiswa, talkshow industri, dan jejaring alumni akan memeriahkan Sistem Komputer Expo 2026 di Auditorium Kampus.','Sistem Komputer Expo kembali hadir pada 12 November 2026. Acara tahunan ini menjadi ruang temu antara karya mahasiswa, praktisi industri, dan alumni Sistem Komputer.\n\nTahun ini, lebih dari 30 proyek mahasiswa akan dipamerkan, mulai dari aplikasi web, perangkat IoT, sampai eksperimen kecerdasan artifisial. Setiap proyek akan didampingi tim yang siap menjelaskan proses dan tantangan di baliknya.\n\nSelain pameran, akan ada talkshow bertema \"Menyiapkan Talenta Teknologi yang Relevan\" bersama perwakilan industri dan sesi jejaring alumni.\n\nAcara terbuka untuk mahasiswa dan masyarakat umum. Pendaftaran pengunjung dibuka melalui tautan yang tersedia di Instagram STEKOM.','Divisi Media & Komunikasi','2026-10-10 10:00:00','2026-10-26 05:48:40','2026-10-26 06:13:55'),
(4,'Workshop Embedded: Dari Sensor ke Dashboard dalam Satu Akhir Pekan','workshop-embedded-sensor-ke-dashboard','img/berita/workshop-embedded-sensor-ke-dashboard.svg','Kegiatan','Dua hari praktik langsung merakit perangkat IoT, membaca sensor, dan menampilkan data ke dashboard.','Divisi Embedded & IoT menggelar workshop intensif selama dua hari di Lab Hardware. Peserta belajar merakit perangkat, menghubungkan sensor, dan mengirim data ke dashboard sederhana.\n\nMateri dimulai dari dasar mikrokontroler, pembacaan sensor suhu dan kelembapan, lalu berlanjut ke komunikasi data melalui jaringan. Di akhir sesi, setiap tim mempresentasikan prototipe kecil yang mereka bangun.\n\n\"Kami sengaja membuat formatnya praktik, bukan teori panjang. Peserta langsung menghadapi masalah nyata dan belajar mencari solusinya,\" kata koordinator divisi, Intan Permata.\n\nWorkshop ini merupakan bagian dari rangkaian kelas rutin STEKOM yang terbuka untuk seluruh anggota.','Divisi Embedded & IoT','2026-09-29 13:00:00','2026-10-26 05:48:40','2026-10-26 06:13:55'),
(5,'STEKOM dan Komunitas Data Kampus Jalin Kolaborasi','stekom-komunitas-data-kampus-kolaborasi','img/berita/stekom-komunitas-data-kampus-kolaborasi.svg','Kolaborasi','Kedua komunitas akan berbagi kelas, menggarap proyek data terbuka, dan menyiapkan program mentoring bersama.','STEKOM menandatangani kerja sama dengan Komunitas Data Kampus untuk memperkuat ekosistem belajar berbasis data di lingkungan mahasiswa. Kolaborasi ini mencakup kelas bersama, proyek data terbuka, dan program mentoring lintas komunitas.\n\nProgram pertama akan berfokus pada pengolahan data kampus menjadi visualisasi yang mudah dipahami. Hasilnya direncanakan dipublikasikan sebagai bahan diskusi terbuka.\n\n\"Kolaborasi ini membuka kesempatan bagi anggota untuk belajar dari perspektif lain. Data bukan hanya soal angka, tetapi juga cara memahami persoalan,\" ujar Nadia Putri, Wakil Ketua STEKOM.\n\nDetail jadwal kegiatan akan diumumkan melalui kanal resmi kedua komunitas.','Divisi Data & AI','2026-09-15 09:30:00','2026-10-26 05:48:40','2026-10-26 06:13:55'),
(6,'Menyusun Peta Belajar Sistem Komputer Bersama Alumni','menyusun-peta-belajar-sistem-komputer','img/berita/menyusun-peta-belajar-sistem-komputer.svg','Teknologi','Sesi diskusi bersama alumni menghasilkan peta belajar yang lebih terarah untuk mahasiswa baru Sistem Komputer.','Apa saja yang sebaiknya dipelajari lebih dulu di Sistem Komputer? Pertanyaan itu menjadi titik awal diskusi STEKOM bersama sejumlah alumni pada akhir pekan lalu.\n\nDiskusi menghasilkan peta belajar yang dibagi ke dalam beberapa fase: dasar pemrograman, pemahaman sistem, penguatan proyek, dan persiapan karier. Setiap fase dilengkapi rekomendasi topik dan proyek kecil untuk latihan.\n\nAlumni menekankan pentingnya keseimbangan antara fondasi teori dan kebiasaan membangun. Menurut mereka, portofolio yang tumbuh dari proyek nyata lebih meyakinkan daripada daftar sertifikat yang panjang.\n\nRingkasan peta belajar akan dibagikan kepada anggota dan diperbarui secara berkala bersama divisi terkait.','Divisi Web & Product','2026-08-30 10:00:00','2026-10-26 05:48:40','2026-10-26 06:13:55');
/*!40000 ALTER TABLE `berita` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `divisi`
--

DROP TABLE IF EXISTS `divisi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `divisi` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisi_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisi`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `divisi` WRITE;
/*!40000 ALTER TABLE `divisi` DISABLE KEYS */;
INSERT INTO `divisi` VALUES
(1,'Web & Product','web-product','Membangun produk digital dari riset, desain, sampai deploy.','2026-10-26 05:48:40'),
(2,'Mobile & UI/UX','mobile-ui-ux','Merancang pengalaman digital di layar kecil maupun besar.','2026-10-26 05:48:40'),
(3,'Data & AI','data-ai','Mengolah data menjadi insight, model, dan keputusan.','2026-10-26 05:48:40'),
(4,'Keamanan Siber','keamanan-siber','Pertahanan sistem, etika hacking, dan budaya aman digital.','2026-10-26 05:48:40'),
(5,'Embedded & IoT','embedded-iot','Menghubungkan perangkat fisik dengan kode dan sensor.','2026-10-26 05:48:40'),
(6,'Media & Komunikasi','media-komunikasi','Menceritakan karya himpunan lewat desain, foto, dan konten.','2026-10-26 05:48:40');
/*!40000 ALTER TABLE `divisi` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kegiatan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `divisi_id` tinyint(3) unsigned DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `mulai_pada` datetime DEFAULT NULL,
  `selesai_pada` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `kegiatan_slug_unique` (`slug`),
  KEY `kegiatan_divisi_id_index` (`divisi_id`),
  CONSTRAINT `kegiatan_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pengaturan`
--

DROP TABLE IF EXISTS `pengaturan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaturan` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `kunci` varchar(100) NOT NULL,
  `nilai` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengaturan_kunci_unique` (`kunci`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pengaturan` WRITE;
/*!40000 ALTER TABLE `pengaturan` DISABLE KEYS */;
INSERT INTO `pengaturan` VALUES
(100,'site_name','STEKOM','2026-10-26 13:53:24'),
(101,'site_full_name','Himpunan Mahasiswa Sistem Komputer','2026-10-26 13:53:24'),
(102,'site_tagline','Ruang tumbuh mahasiswa Sistem Komputer.','2026-10-26 13:53:24'),
(103,'site_description','STEKOM adalah himpunan mahasiswa Sistem Komputer: wadah kolaborasi, karya, dan pengembangan diri di bidang teknologi.','2026-10-26 13:53:24'),
(104,'site_periode','2026/2027','2026-10-26 13:53:24'),
(105,'site_email','halo@stekom.id','2026-10-26 15:04:19'),
(106,'site_instagram','https://www.instagram.com/stekom','2026-10-26 15:04:19'),
(107,'site_location','Kampus Sistem Komputer','2026-10-26 15:04:19'),
(108,'site_logo','uploads/pengaturan/2439b9fb8b43e4972d5ed8b5.png','2026-10-26 15:28:23'),
(109,'site_footer_text','Belajar, berkarya, dan bertumbuh bersama.','2026-10-26 13:53:24'),
(110,'site_footer_note','Ramadanzah','2026-10-26 15:28:50');
/*!40000 ALTER TABLE `pengaturan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pengurus`
--

DROP TABLE IF EXISTS `pengurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengurus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jabatan` varchar(80) NOT NULL,
  `divisi_id` tinyint(3) unsigned DEFAULT NULL,
  `periode` varchar(20) NOT NULL,
  `urutan` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengurus_periode_nama_unique` (`periode`,`nama`),
  KEY `pengurus_divisi_id_index` (`divisi_id`),
  CONSTRAINT `pengurus_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengurus`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pengurus` WRITE;
/*!40000 ALTER TABLE `pengurus` DISABLE KEYS */;
INSERT INTO `pengurus` VALUES
(1,'Ramadanzah','uploads/pengurus/2db89c571fac878706038f3f.png','Ketua Umum',NULL,'2026/2027',1,1,'2026-10-26 05:48:40'),
(2,'Nadia Putri','img/pengurus/nadia-putri.svg','Wakil Ketua Umum',NULL,'2026/2027',2,1,'2026-10-26 05:48:40'),
(3,'Bima Saputra','img/pengurus/bima-saputra.svg','Sekretaris Umum',NULL,'2026/2027',3,1,'2026-10-26 05:48:40'),
(4,'Salsabila Rahma','img/pengurus/salsabila-rahma.svg','Bendahara Umum',NULL,'2026/2027',4,1,'2026-10-26 05:48:40'),
(5,'Fajar Nugroho','img/pengurus/fajar-nugroho.svg','Koordinator Divisi',1,'2026/2027',5,1,'2026-10-26 05:48:40'),
(6,'Alya Kirana','img/pengurus/alya-kirana.svg','Koordinator Divisi',2,'2026/2027',6,1,'2026-10-26 05:48:40'),
(7,'Dimas Aryo','img/pengurus/dimas-aryo.svg','Koordinator Divisi',3,'2026/2027',7,1,'2026-10-26 05:48:40'),
(8,'Rizky Maulana','img/pengurus/rizky-maulana.svg','Koordinator Divisi',4,'2026/2027',8,1,'2026-10-26 05:48:40'),
(9,'Intan Permata','img/pengurus/intan-permata.svg','Koordinator Divisi',5,'2026/2027',9,1,'2026-10-26 05:48:40'),
(10,'Yusuf Hidayat','img/pengurus/yusuf-hidayat.svg','Koordinator Divisi',6,'2026/2027',10,1,'2026-10-26 05:48:40');
/*!40000 ALTER TABLE `pengurus` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','pengurus') NOT NULL DEFAULT 'pengurus',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin STEKOM','admin@stekom.id','$2y$12$AVE4/jjO9ZrIRJcpu96cOeskBYMw51aWDkazUpQXtuXB8qt/Hqx8W','admin','2026-10-26 12:02:16',1,'2026-10-26 23:44:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-10-28  0:19:36
