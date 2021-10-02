/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 5.7.33 : Database - siakad_project
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`siakad_project` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `siakad_project`;

/*Table structure for table `angkatan` */

DROP TABLE IF EXISTS `angkatan`;

CREATE TABLE `angkatan` (
  `kode_angkatan` char(10) DEFAULT NULL,
  `tahun_angkatan` varchar(4) DEFAULT NULL,
  `nama_angkatan` varchar(100) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `angkatan` */

insert  into `angkatan`(`kode_angkatan`,`tahun_angkatan`,`nama_angkatan`,`aktif`) values 
('K019','2019','Komodo2019','N'),
('K020','2020','Komodo2020','N'),
('K021','2021','Komodo2021','Y');

/*Table structure for table `fasilitas` */

DROP TABLE IF EXISTS `fasilitas`;

CREATE TABLE `fasilitas` (
  `id_fasilitas` int(15) NOT NULL,
  `nama_fasilitas` varchar(100) NOT NULL,
  `icon_fasilitas` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `fasilitas` */

insert  into `fasilitas`(`id_fasilitas`,`nama_fasilitas`,`icon_fasilitas`) values 
(1,'Perlengkapan Alat Pendidikan Yang Lengkap','fa fa-book'),
(3,'Pengajar dan Pendidik Yang Berkompeten','fa fa-user'),
(4,'Laboratorium Komputer Yang Memadai','fa fa-desktop'),
(5,'Ruang Kelas Yang Bersih Dan Nyaman Untuk Belajar','fa fa-institution');

/*Table structure for table `gallery` */

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `id_gallery` int(15) NOT NULL,
  `judul_gallery` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `gallery` */

insert  into `gallery`(`id_gallery`,`judul_gallery`,`gambar`,`aktif`) values 
(1,'Latihan Dalmas Lanjutan','Latihan-Dalmas-Lanjutan.jpeg','Y'),
(2,'Kunjungan Kapolda Lampung','Kunjungan-Kapolda-Lampung.jpeg','Y'),
(3,'BINTARA Latihan','BINTARA-Latihan.jpeg','Y'),
(4,'Upacara Pembukaan TA 2019','Upacara-Pembukaan-TA-2019.jpg','Y');

/*Table structure for table `guru` */

DROP TABLE IF EXISTS `guru`;

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nidn` varchar(100) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `guru` */

insert  into `guru`(`id_guru`,`nidn`,`nama_guru`,`alamat`,`jenis_kelamin`,`email`,`telp`,`photo`) values 
(1,'0620066031','Badiyanto','Jl. Raya Janti No. 143 Karangjambe, Yogyakarta','laki-laki','badi@akakom.ac.id','-','0620066031.jpg'),
(2,'0512038101','Yosef Murya','Gondangan RT.002 RW.044 Sardonoharjo Ngaglik Sleman Yogyakarta','laki-laki','yosefmurya@gmail.com','08562555665','0512038101.jpg'),
(4,'0512345678','Daru Dita Wideatni','Gondangan No. 48 Sardonoharjo Ngaglik Sleman','perempuan','darudita@gmail.com','08567891011','0512345678.jpg'),
(6,'0612345678','Arif Riyadi','Jl. Bantul no 13 Yogyakarta','laki-laki','arifriyadi@ugm.ac.id','08123456789','0612345678.jpg'),
(0,'12334422','Andi','Bandar Lampung','laki-laki','andi@gmail.com','081456786332','');

/*Table structure for table `identitas` */

DROP TABLE IF EXISTS `identitas`;

CREATE TABLE `identitas` (
  `id_identitas` int(11) NOT NULL,
  `nama_pemilik` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `judul_website` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `meta_deskripsi` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `meta_keyword` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `alamat` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `telp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `facebook` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `twitter` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `twitter_widget` text COLLATE latin1_general_ci NOT NULL,
  `google_map` text COLLATE latin1_general_ci NOT NULL,
  `favicon` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `identitas` */

insert  into `identitas`(`id_identitas`,`nama_pemilik`,`judul_website`,`url`,`meta_deskripsi`,`meta_keyword`,`alamat`,`email`,`telp`,`facebook`,`twitter`,`twitter_widget`,`google_map`,`favicon`) values 
(2,'SPN POLDA LAMPUNG','SPN POLDA LAMPUNG','https://www.instagram.com/spn_polda_lampung','SEKOLAH POLISI NEGARA POLDA LAMPUNG','SEKOLAH POLISI NEGARA POLDA LAMPUNG','Jl. Agrowisata III, Beringin Raya, Kec. Kemiling, Kota Bandar Lampung, Lampung 35155','admin@spnpoldalampung.co.id','08562555665','facebook.com/spn.kemilinglampung','twitter.com/spn_kemilingLPG','-','-','SPN-POLDA-LAMPUNG.png');

/*Table structure for table `informasi` */

DROP TABLE IF EXISTS `informasi`;

CREATE TABLE `informasi` (
  `id_informasi` int(15) NOT NULL,
  `id_kategori` int(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `judul_informasi` varchar(100) NOT NULL,
  `judul_seo` varchar(100) NOT NULL,
  `isi_informasi` text NOT NULL,
  `tanggal` date NOT NULL,
  `hari` varchar(25) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `informasi` */

insert  into `informasi`(`id_informasi`,`id_kategori`,`username`,`judul_informasi`,`judul_seo`,`isi_informasi`,`tanggal`,`hari`,`gambar`,`aktif`) values 
(1,8,'admin','POLDA LAMPUNG BUKA PENERIMAAN ANGGOTA POLRI TAHUN 2021','polda-lampung-buka-penerimaan-anggota-polri-tahun-2021','Kepada pemuda-pemudi yang berada di provinsi, kabupaten, kota di Lampung, bahwa saat ini telah di buka penerimaan anggota Polri tahun anggaran (TA) 2021','2018-04-20','Jumat','POLDA-LAMPUNG-BUKA-PENERIMAAN-ANGGOTA-POLRI-TAHUN-2021.jpeg','Y'),
(2,9,'admin','DIMULAINYA TAHUN AJARAN BARU 2021/2022','dimulainya-tahun-ajaran-baru-20212022','Tahun ajaran baru 2021/2022 akan dimulai pada tanggal 28 Juli 2021, Oleh karena itu bagi seluruh siswa untuk mempersiapkan semua kebutuhan/peralatan akademik','2018-04-25','Rabu','DIMULAINYA-TAHUN-AJARAN-BARU-20212022.jpg','Y');

/*Table structure for table `jadwal` */

DROP TABLE IF EXISTS `jadwal`;

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `kode_angkatan` char(10) DEFAULT NULL,
  `kode_pelajaran` varchar(10) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `hari` varchar(10) NOT NULL,
  `jam_mulai` varchar(5) NOT NULL,
  `jam_selesai` varchar(5) NOT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `jadwal` */

insert  into `jadwal`(`id_jadwal`,`kode_angkatan`,`kode_pelajaran`,`id_guru`,`id_kelas`,`hari`,`jam_mulai`,`jam_selesai`) values 
(1,'K009','FKB3002',2,1,'Senin','09:35','09:35'),
(2,'K009','FKB3001',4,1,'Selasa','08:30','08:30'),
(4,'K009','FKK1001',1,2,'Kamis','07:30','08:30'),
(5,'K009','FPB1001',6,1,'Kamis','08:30','09:30'),
(6,'K009','FKB3002',6,1,'Sabtu','21:00','22:00'),
(7,'K009','FKK1001',1,1,'Selasa','12:00','13:00'),
(8,'K009','PKK1003',1,1,'Sabtu','09:25','04:30');

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` int(15) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `kategori_seo` varchar(100) NOT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`id_kategori`,`nama_kategori`,`kategori_seo`,`aktif`) values 
(8,'Informasi Kampus','informasi-kampus','Y'),
(9,'Pengumuman Kampus','pengumuman-kampus','Y');

/*Table structure for table `kegiatan` */

DROP TABLE IF EXISTS `kegiatan`;

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `galery` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_kegiatan`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `kegiatan` */

insert  into `kegiatan`(`id_kegiatan`,`nama_kegiatan`,`galery`,`deskripsi`) values 
(1,'Apel penandatanganan pakta integritas Pembangunan Zona Integritas','Apel-penandatanganan-pakta-integritas-Pembangunan-Zona-Integritas.jpg','Senin, 3 Mei 2021 Dilaksanakan apel penandatanganan pakta integritas Pembangunan Zona Integritas di SPN Polda Lampung Pelaksanaan penandatanganan dipimpin langsung oleh bapak Ka SPN Polda Lampung Kombes pol. Sri Winugroho, S.Ik., M.H.'),
(2,'Pesantren Kilat','Pesantren-Kilat.jpg','Dalam rangka mengisi waktu malam pergantian tahun, SPN Kemiling Polda Lampung mengadakan acara Pesantren Kilat, yang mana acara ini diikuti oleh seluruh Serdik Bintara Polri T.A. 2019, dan diarahkan ke tempat ibadah sesuai dengan keyakinannya masing-masing.');

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `kelas` */

insert  into `kelas`(`id_kelas`,`kode_kelas`,`nama_kelas`) values 
(1,'Kelas C','Kelas C'),
(2,'Kelas B','Kelas B'),
(3,'Kelas A','Kelas A');

/*Table structure for table `kontak` */

DROP TABLE IF EXISTS `kontak`;

CREATE TABLE `kontak` (
  `id_kontak` int(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `pesan` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `kontak` */

insert  into `kontak`(`id_kontak`,`nama`,`email`,`telp`,`pesan`) values 
(0,'Yosef Murya','yosefmurya@gmail.com','08562555665','Mohon informasi PMB untuk tahun 2019 dimulai kapan ya??');

/*Table structure for table `krs` */

DROP TABLE IF EXISTS `krs`;

CREATE TABLE `krs` (
  `id_krs` int(10) NOT NULL AUTO_INCREMENT,
  `kode_angkatan` char(10) NOT NULL,
  `nim` char(15) NOT NULL,
  `kode_pelajaran` varchar(10) NOT NULL,
  `nilai_keaktifan` int(11) NOT NULL,
  `nilai_penugasan` int(11) NOT NULL,
  `nilai_ujian` int(11) NOT NULL,
  PRIMARY KEY (`id_krs`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `krs` */

insert  into `krs`(`id_krs`,`kode_angkatan`,`nim`,`kode_pelajaran`,`nilai_keaktifan`,`nilai_penugasan`,`nilai_ujian`) values 
(5,'K009','2017010003','FKB3001',80,90,70),
(6,'K009','2017010003','FKB3003',89,98,75),
(7,'K009','2017010003','FKB4004',90,85,75),
(8,'K009','2017010003','FKB4012',85,90,95),
(9,'K009','2017010003','PKK1003',89,78,65),
(12,'K009','2017010003','UPK200X',89,78,97),
(13,'K009','2017010003','UKK1004',89,76,96),
(14,'K009','2017010003','UPK1002',87,78,98),
(15,'K009','2017010003','UPK1010',80,98,90),
(16,'K009','2017010012','UPK1006',8,6,7),
(17,'K009','2017010012','FKK1002',90,65,85),
(18,'K009','2017010005','FKB1001',90,50,85),
(19,'K007','2017010004','FKB1001',0,0,0),
(20,'K007','2017010004','FKB4004',0,0,0);

/*Table structure for table `materi_perkuliahan` */

DROP TABLE IF EXISTS `materi_perkuliahan`;

CREATE TABLE `materi_perkuliahan` (
  `id_materiperkuliahan` int(15) NOT NULL,
  `judul_materiperkuliahan` varchar(100) NOT NULL,
  `isi_materiperkuliahan` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `materi_perkuliahan` */

insert  into `materi_perkuliahan`(`id_materiperkuliahan`,`judul_materiperkuliahan`,`isi_materiperkuliahan`,`icon`) values 
(1,'Character Building','Pembentukan karakter mahasiswa agar memiliki watak, sifat kejiwaan, akhlak (budi pekerti), insan manusia (masyarakat) yang baik','fa fa-industry'),
(2,'Religiusitas','Pendalaman akan makna agama dan beragama, mendeteksi dinamika Wahyu Tuhan dan iman, dan memahami relasi dengan Tuhan dan sesama.','fa fa-moon-o'),
(3,'Pemrograman Web','Pengetahuan dan praktikum pembuatan website dinamis dengan bahasa pemrogaman HTML, CSS, PHP, Javascript dan database MySQL','fa fa-desktop'),
(4,'Pemrograman Berbasis Mobile','Pengetahuan dan praktikum pembuatan aplikasi mobile menggunakan Android Studio yang menggunakan bahasa pemrograman java dan XML','fa fa-mobile'),
(5,'Pemrograman Web Mobile','Pengetahuan dan praktikum pembuatan web mobile dinamis dengan IONIC Framework, SQLite dan MySQL','fa fa-tablet'),
(6,'Pemrograman Web Lanjut','Pengetahuan dan praktikum pembuatan website dinamis dengan Framework Langit Inspirasi dengan konsep MVC','fa fa-laptop');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `main_menu` varchar(11) NOT NULL,
  `level` enum('admin','user','kepsek') NOT NULL DEFAULT 'admin',
  KEY `id_menu` (`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id_menu`,`nama_menu`,`link`,`icon`,`main_menu`,`level`) values 
(1,'Menu Utama','#','','0','admin'),
(1,'Kelas','kelas','fa fa-university','12','admin'),
(3,'Pelajaran','pelajaran','fa fa-bookmark-o','12','user'),
(4,'Siswa','siswa','fa fa-users','12','user'),
(5,'Angkatan','angkatan','fa fa-ellipsis-v','12','admin'),
(6,'Rencana Pengajaran','krs','fa fa-edit','12','admin'),
(7,'Input Nilai','nilai/inputNilai','fa fa-sort-numeric-asc','12','admin'),
(8,'Nilai','nilai','fa fa-file-text-o','12','user'),
(10,'User','users','fa fa-user','13','admin'),
(11,'Menu','menu','fa fa-eye','13','admin'),
(12,'SIAKAD','#','fa fa-graduation-cap','0','admin'),
(13,'SETTING','#','fa fa-gear','0','admin'),
(14,'INFO SEKOLAH','#','fa fa-globe','0','admin'),
(15,'Identitas','identitas','fa fa-vcard-o','14','admin'),
(16,'Kategori','kategori','fa fa-server','14','admin'),
(17,'Informasi Sekolah','informasi','fa fa-newspaper-o','14','admin'),
(18,'Guru','guru','fa fa-group','12','admin'),
(19,'Tentang Sekolah','tentang_kampus','fa fa-info','14','admin'),
(20,'Fasilitas','fasilitas','fa fa-suitcase','14','admin'),
(22,'Gallery','gallery','fa fa-photo','14','admin'),
(23,'Kontak','kontak','fa fa-volume-control-phone','14','admin'),
(24,'Visi Misi','visi_misi','fa fa-info','14','admin'),
(25,'Kegiatan','kegiatan','fa fa-tasks','14','admin'),
(26,'Jadwal','jadwal','fa fa-calendar','12','user'),
(30,'Nilai Siswa','laporan/laporan_nilai','fa fa-file-text-o','0','kepsek'),
(32,'Laporan','laporan','fa fa-file','0','admin'),
(33,'Laporan','laporan','fa fa-file','0','kepsek');

/*Table structure for table `pelajaran` */

DROP TABLE IF EXISTS `pelajaran`;

CREATE TABLE `pelajaran` (
  `kode_pelajaran` varchar(10) NOT NULL,
  `nama_pelajaran` varchar(100) NOT NULL,
  `kkm` int(11) NOT NULL,
  `semester` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `pelajaran` */

insert  into `pelajaran`(`kode_pelajaran`,`nama_pelajaran`,`kkm`,`semester`,`id_kelas`) values 
('FKB1001','NAC Polri',75,1,2),
('FKB3001','Inter Personal Skill (Ips)',75,3,1),
('FKB3002','Nilai-Nilai Revolusi Mental',75,3,2),
('FKB3003','Sejarah Indonesia',75,3,1),
('FKB4004','Sejarah Polri',75,3,2),
('FKB4012','Wawasan Kebangsaan',75,3,2),
('FKK1001','Hubungan Antar Suku Bangsa',75,1,2),
('FKK1002','Demokratisasi Dan Globalisasi',75,1,2),
('FPB1001','Revolusi Industri 4.0 Menuju Masyarakat 5.0',75,1,2),
('PKK1003','Ideologi Pancasila',75,3,1),
('UKK1004','Peran Polri Dalam Bela Negara',75,1,1),
('UPK1002','Organisasi Polri',75,1,1),
('UPK1006','Administrasi Umum Polri',75,1,2),
('UPK1010','Hakikat Gangguan Kamtibmas (Pgiag/Gn)',75,1,2),
('UPK200X','Dasar-Dasar Komputer',75,2,1),
('FPB1020','Hubungan Polri  Dengan Masyar',75,1,1),
('FPB1021','Komunikasi Multimedia',75,1,1),
('FPB1022','Media Sosial',75,1,1),
('FPB1023','Radio Polri',75,1,1),
('FPB1024','Hak Asasi Manusia Dalam Tuga',75,1,1),
('FPB1025','Pemolisian Masyarakat (Polmas)',75,1,1),
('FPB1026','Undang-Undang Nomor 2 Tahun',75,1,1),
('FPB1027','Kuhp',75,1,1),
('FPB1028','Kuhap',75,1,1),
('FPB1029','Kapita Selekta Perundang-Undangan',75,1,1),
('FPB1030','Peraturan Disiplin Anggota P',75,1,1),
('FPB1031','Peraturan Kapolri Nomor 1 Ta',75,1,1),
('FPB1032','Pengantar F.T. Sabhara',75,1,1),
('FPB1033','Pengaturan',75,1,2),
('FPB1034','Penjagaan',75,1,2),
('FPB1035','Pengawalan',75,1,2),
('FPB1036','Patroli',75,1,2),
('FPB1037','Laporan Polisi (Lp)',75,1,2),
('FPB1038','Tindakan Pertama Tempat Kejad',75,1,2),
('FPB1039','Tindak Pidana Ringan (Tipirin',75,1,2),
('FPB1040','Pengendalian Massa (Dalmas)',75,1,2),
('FPB1041','Negosiasi',75,1,3),
('FPB1042','Bantuan Search And Rescue (Sar) Dan Pertolongan Pertama Gawat (Ppgd)',75,1,3),
('FPB1043','Pengamanan Pemilu',75,1,3),
('FPB1044','Fungsi Teknis Lalu Lintas',75,1,3),
('FPB1045','Fungsi Teknis Intelkam',75,1,3),
('FPB1046','Fungsi Teknis Reserse',75,1,3),
('FPB1047','Fungsi Teknis Binmas',75,1,3),
('FPB1048','Fungsi Teknis Polair',75,1,1),
('FPB1049','Persenjataan Dan Menembak',75,1,1),
('FPB1050','Beladiri Polri',75,1,2),
('FPB1051','\"Perdaspol (Pbb',0,0,0),
('FPB1052','Tutup Dasar Bhayangkara',75,1,1),
('FPB1053','Latihan Teknis',75,1,1),
('FPB1054','Latihan Kerja',75,1,2);

/*Table structure for table `siswa` */

DROP TABLE IF EXISTS `siswa`;

CREATE TABLE `siswa` (
  `nim` char(15) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `nama_panggilan` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `kode_angkatan` char(10) DEFAULT NULL,
  `id_kelas` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `siswa` */

insert  into `siswa`(`nim`,`nama_lengkap`,`nama_panggilan`,`alamat`,`email`,`telp`,`tempat_lahir`,`tgl_lahir`,`jenis_kelamin`,`agama`,`photo`,`kode_angkatan`,`id_kelas`) values 
('2017010001','Daru Dita','Dita','Badran JT I/884 Yogyakarta','dita@gmail.com','08562555665','Yogyakarta','1982-09-18','P','Katholik','20170100012.jpg','K021',2),
('2017010002','Yosef Murya Kusuma Ardhana','Yosef','Jl. Kaliurang KM 10 Yogyakarta','yosefmurya@gmail.com','08562943232','Surabaya','1981-03-12','L','Katholik','','K021',1),
('2017010003','Badiyanto','Badi','Bantul','badi@akakom.ac.id','081223232323','Pati','1965-05-30','L','Islam','2017010003.jpg','K021',2),
('2017010004','Eka Bayu Purnama','Eka','Semarang','eka@yahoo.com','0816343434','Semarang','1970-01-01','L','Protestan','2017010004.jpg','K021',1),
('2017010005','Ida Bagus Perdana','Ida','Denpasar','idab@gmail.com','081329443434','Denpasar','1970-01-15','L','Hindu','2017010005.jpg','K021',2),
('2017010012','Veronica Daru Dita Widieatni','Dita','Gondangan No. 48 Sardonoharjo Ngaglik Sleman','darudita@gmail.com','08562943232','Yogyakarta','1982-09-18','P','Islam','2017010012.jpg','K021',1),
('2117040026','avindo habib','avindo','Jl. Lintang Sari No 53','avindohabib1@gmail.com','85347596677','Bandar Lampung','1997-06-14','L','Islam','','K021',1),
('2117040114','rama kurniawan','rama','Jl. Lintang Sari No 54','ramakurniawan@04gmail.com','85347596677','Bandar Lampung','1997-06-15','L','Islam','','K021',1),
('2117040094','agung priambodo','agung','Jl. Lintang Sari No 55','agungpriambodo@04gmail.com','85347596677','Bandar Lampung','1997-06-16','L','Islam','','K021',1),
('2117040132','hidayaturrahman','hidayaturrahman','Jl. Lintang Sari No 56','hidayaturrahman@04gmail.com','85347596677','Bandar Lampung','1997-06-17','L','Islam','','K021',1),
('2117040125','dini ahmad firdaus','dini','Jl. Lintang Sari No 57','diniahmadfirdaus@04gmail.com','85347596677','Bandar Lampung','1997-06-18','L','Islam','','K021',1),
('2117040121','andreas yopa wijaya','andreas','Jl. Lintang Sari No 58','andreasyopawijaya@04gmail.com','85347596677','Bandar Lampung','1997-06-19','L','Islam','','K021',1),
('2117040070','adji mahendra','adji','Jl. Lintang Sari No 59','adjimahendra@04gmail.com','85347596677','Bandar Lampung','1997-06-20','L','Islam','','K021',1),
('2117040095','arkhiansyah','arkhiansyah','Jl. Lintang Sari No 60','arkhiansyah@04gmail.com','85347596677','Bandar Lampung','1997-06-21','L','Islam','','K021',1),
('2117040122','anjha novta tianfa','anjha','Jl. Lintang Sari No 61','anjhanovta@04gmail.com','85347596677','Bandar Lampung','1997-06-22','L','Islam','','K021',1),
('2117040108','tandilo','tandilo','Jl. Lintang Sari No 62','tandilo@04gmail.com','85347596677','Bandar Lampung','1997-06-23','L','Islam','','K021',1),
('2117040082','irfan maulana','irfan','Jl. Lintang Sari No 63','irfanmaulana@04gmail.com','85347596677','Bandar Lampung','1997-06-24','L','Islam','','K021',1),
('2117040149','dwiki viary','dwiki','Jl. Lintang Sari No 64','dwikiviary@04gmail.com','85347596677','Bandar Lampung','1997-06-25','L','Islam','','K021',1),
('2117040049','alan chandra tama','alan','Jl. Lintang Sari No 65','alanchandratama@04gmail.com','85347596677','Bandar Lampung','1997-06-26','L','Islam','','K021',1),
('2117040145','arya ramadhani','arya','Jl. Lintang Sari No 66','aryaramadhani@04gmail.com','85347596677','Bandar Lampung','1997-06-27','L','Islam','','K021',1),
('2117040144','sidabutar','sidabutar','Jl. Lintang Sari No 67','sidabutar@04gmail.com','85347596677','Bandar Lampung','1997-06-28','L','Islam','','K021',1),
('2117040032','riantama','riantama','Jl. Lintang Sari No 68','riantama@04gmail.com','85347596677','Bandar Lampung','1997-06-29','L','Islam','','K021',1),
('2117040078','ismutaji','ismutaji','Jl. Lintang Sari No 69','ismutaji@04gmail.com','85347596677','Bandar Lampung','1997-06-30','L','Islam','','K021',1),
('2117040088','ridho ilhammulloh','ridho','Jl. Lintang Sari No 70','ridhoilhammulloh@04gmail.com','85347596677','Bandar Lampung','1997-07-01','L','Islam','','K021',1),
('2117040090','rizky prapta hakim','rizky','Jl. Lintang Sari No 71','rizkypraptahakim@04gmail.com','85347596677','Bandar Lampung','1997-07-02','L','Islam','','K021',1),
('2117040099','haekal maulana','haekal','Jl. Lintang Sari No 72','hekalmaulana99@gmail.com','85347596677','Bandar Lampung','1997-07-03','L','Islam','','K021',1);

/*Table structure for table `tentang_kampus` */

DROP TABLE IF EXISTS `tentang_kampus`;

CREATE TABLE `tentang_kampus` (
  `id_tentangkampus` int(15) NOT NULL,
  `judul_tentangkampus` varchar(100) NOT NULL,
  `isi_tentangkampus` varchar(255) NOT NULL,
  `keterangan_tambahan` varchar(255) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tentang_kampus` */

insert  into `tentang_kampus`(`id_tentangkampus`,`judul_tentangkampus`,`isi_tentangkampus`,`keterangan_tambahan`,`gambar`,`aktif`) values 
(3,'Kampus Berbasis Teknologi Modern','Universitas Langit Inspirasi merupakan kampus berbasis teknologi modern yang telah mendapatkan berbagai awards baik Internasional maupun nasional.','Saat ini Universitas Langit Inspirasi telah menggunakan kurikulum pelajarannya dari Google, sehingga para lulusan dapat bekerja di dalam negeri maupun luar negeri.','Kampus-Berbasis-Teknologi-Modern.jpg','Y');

/*Table structure for table `thn_akad_semester` */

DROP TABLE IF EXISTS `thn_akad_semester`;

CREATE TABLE `thn_akad_semester` (
  `id_thn_akad` int(11) NOT NULL AUTO_INCREMENT,
  `thn_akad` varchar(9) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_thn_akad`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `thn_akad_semester` */

insert  into `thn_akad_semester`(`id_thn_akad`,`thn_akad`,`semester`,`aktif`) values 
(1,'2014/2015','1','N'),
(2,'2014/2015','2','N'),
(3,'2015/2016','1','N'),
(4,'2015/2016','2','N'),
(5,'2016/2017','1','N'),
(7,'2016/2017','2','N'),
(8,'2018/2019','1','N'),
(9,'2018/2019','2','N'),
(13,'2019/2020','1','N'),
(14,'2019/2020','2','Y');

/*Table structure for table `transkrip` */

DROP TABLE IF EXISTS `transkrip`;

CREATE TABLE `transkrip` (
  `id_transkrip` int(10) NOT NULL AUTO_INCREMENT,
  `nim` varchar(15) NOT NULL,
  `kode_pelajaran` varchar(10) NOT NULL,
  `nilai_keaktifan` int(11) NOT NULL,
  `nilai_penugasan` int(11) NOT NULL,
  `nilai_ujian` int(11) NOT NULL,
  PRIMARY KEY (`id_transkrip`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `transkrip` */

insert  into `transkrip`(`id_transkrip`,`nim`,`kode_pelajaran`,`nilai_keaktifan`,`nilai_penugasan`,`nilai_ujian`) values 
(1,'2017010012','FKB3001',0,0,90),
(2,'2017010012','FKB3003',0,0,70),
(3,'2017010012','FKB4012',0,0,70),
(4,'2017010012','UPK200X',0,0,65),
(5,'2017010003','FKB3001',0,0,75),
(6,'2017010003','FKB3003',0,0,86),
(7,'2017010003','FKB4004',0,0,80),
(8,'2017010003','FKB4012',0,0,90),
(9,'2017010003','PKK1003',0,0,70);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` enum('admin','user','kepsek') NOT NULL DEFAULT 'user',
  `blokir` enum('N','Y') NOT NULL DEFAULT 'N',
  `id_sessions` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`,`level`,`blokir`,`id_sessions`) values 
(1,'2017010001','d41d8cd98f00b204e9800998ecf8427e','bima@gmail.com','user','N','d41d8cd98f00b204e9800998ecf8427e'),
(2,'2017010012','202cb962ac59075b964b07152d234b70','abdullah@gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(3,'admin','21232f297a57a5a743894a0e4a801fc3','yosefmurya@gmail.com','admin','N','21232f297a57a5a743894a0e4a801fc3'),
(4,'kepsek','202cb962ac59075b964b07152d234b70','kepsek@gmail.com','kepsek','N','202cb962ac59075b964b07152d234b70'),
(5,'2017010004','202cb962ac59075b964b07152d234b70','bayu@gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(6,'2017010003','202cb962ac59075b964b07152d234b70','budi23@gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(7,'2117040026','202cb962ac59075b964b07152d234b70','avindohabib1@gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(8,'2117040114','202cb962ac59075b964b07152d234b70','ramakurniawan@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(9,'2117040094','202cb962ac59075b964b07152d234b70','agungpriambodo@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(10,'2117040132','202cb962ac59075b964b07152d234b70','hidayaturrahman@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(11,'2117040125','202cb962ac59075b964b07152d234b70','diniahmadfirdaus@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(12,'2117040121','202cb962ac59075b964b07152d234b70','andreasyopawijaya@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(13,'2117040070','202cb962ac59075b964b07152d234b70','adjimahendra@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(14,'2117040095','202cb962ac59075b964b07152d234b70','arkhiansyah@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(15,'2117040122','202cb962ac59075b964b07152d234b70','anjhanovta@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(16,'2117040108','202cb962ac59075b964b07152d234b70','tandilo@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(17,'2117040082','202cb962ac59075b964b07152d234b70','irfanmaulana@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(18,'2117040149','202cb962ac59075b964b07152d234b70','dwikiviary@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(19,'2117040049','202cb962ac59075b964b07152d234b70','alanchandratama@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(20,'2117040145','202cb962ac59075b964b07152d234b70','aryaramadhani@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(21,'2117040144','202cb962ac59075b964b07152d234b70','sidabutar@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(22,'2117040032','202cb962ac59075b964b07152d234b70','riantama@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(23,'2117040078','202cb962ac59075b964b07152d234b70','ismutaji@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(24,'2117040088','202cb962ac59075b964b07152d234b70','ridhoilhammulloh@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(25,'2117040090','202cb962ac59075b964b07152d234b70','rizkypraptahakim@04gmail.com','user','N','202cb962ac59075b964b07152d234b70'),
(26,'2117040099','202cb962ac59075b964b07152d234b70','hekalmaulana99@gmail.com','user','N','202cb962ac59075b964b07152d234b70');

/*Table structure for table `visi_misi` */

DROP TABLE IF EXISTS `visi_misi`;

CREATE TABLE `visi_misi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `visi_misi` */

insert  into `visi_misi`(`id`,`visi`,`misi`) values 
(1,'Visi Polri dibidang pendidikan adalah mewujudkan anggota Polri yang memahami jati dirinya sebagai insan pelindung, pengayom dan pelayan masayarakat yang memiliki integritas moral tinggi, menguasai ilmu pengetahuan dan teknologi kepolisian serta profesional dalam penerapannya, didukung kasmani yang samapta serta mewujudkan PNS Polri yang mampu mendukung pelaksanaan tugas-tugas Polri sesuai bidang tugasnya.','1. Membentuk masyarakat umum terpilih untuk menjadi personil Kepolisian Negara Republik Indonesia melaluui pendidikan Kepolisian. \r\n<br>\r\n2. Memberikan pembekalan ilmu pengetahuan dan teknologi yang berkaitan dengan tugas-tugas kepolisian kepada seluruh personil Polri maupun anggota masyarakat lainnya yang mengemban tugas Kamtibmas. \r\n<br>\r\n3. Meningkatkan kualitas peserta didik dan penyelenggaraan pendidikan, sehingga mampu mengoptimalkan pembentukan kepribadian Polri yang bermoral agama, menguasai pengetahuan dan teknologi kepolisian, mengerti serta memperhatikan kebutuhan masyarakat. \r\n<br>\r\n4. Mengupayakan perluasan dan pemerataan kesempatan memperoleh pendidikan profesional kepolisian yang bermutu bagi seluruh personil Polri.\r\n<br>\r\n5. Meningkatkan profesionalitas dan akuntabilitas lembaga pendidikan Polri sehingga mampu menjadi pusat pembudayaan / kulturalisasi kode etik Polri, Pusat Ilmu Pengetahuan Teknologi Kepolisian Indonesia, Pusat keterampilan sikap nilai dan pengalaman profesionalisme kepolisian serta pusat pemupukan kepribadian Polri yang bermoral agama.');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
