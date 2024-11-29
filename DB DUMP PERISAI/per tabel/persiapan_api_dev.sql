/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100420
 Source Host           : localhost:3306
 Source Schema         : persiapan_api_dev

 Target Server Type    : MariaDB
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 24/04/2024 10:50:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for berita
-- ----------------------------
DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita`  (
  `id_berita` int(255) NOT NULL AUTO_INCREMENT,
  `nama_berita` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `facebook` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `website` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `instagram` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `twitter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tiktok` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sippn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `youtube` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `media_lokal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `media_nasional` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tgl_input` date NULL DEFAULT NULL,
  `tgl_update` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_berita`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cabang
-- ----------------------------
DROP TABLE IF EXISTS `cabang`;
CREATE TABLE `cabang`  (
  `kode_cabang` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `radius_cabang` int(255) NOT NULL,
  PRIMARY KEY (`kode_cabang`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for departemen
-- ----------------------------
DROP TABLE IF EXISTS `departemen`;
CREATE TABLE `departemen`  (
  `kode_dept` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_dept` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`kode_dept`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jam_kerja
-- ----------------------------
DROP TABLE IF EXISTS `jam_kerja`;
CREATE TABLE `jam_kerja`  (
  `kode_jam_kerja` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_jam_kerja` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `awal_jam_masuk` time(0) NULL DEFAULT NULL,
  `jam_masuk` time(0) NULL DEFAULT NULL,
  `akhir_jam_masuk` time(0) NULL DEFAULT NULL,
  `jam_pulang` time(0) NULL DEFAULT NULL,
  PRIMARY KEY (`kode_jam_kerja`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for karyawan
-- ----------------------------
DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE `karyawan`  (
  `nik` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_dept` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`nik`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for konfigurasi_berita
-- ----------------------------
DROP TABLE IF EXISTS `konfigurasi_berita`;
CREATE TABLE `konfigurasi_berita`  (
  `id_konfig` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_config` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `salam_pembuka` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `yth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah_tembusan_yth` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dari_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pengantar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah_hashtag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jargon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah_moto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `penutup` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `salam_penutup` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jenis_konfig` enum('Konfigurasi Berita','Konfigurasi Rekap') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tgl_input` date NULL DEFAULT NULL,
  `tgl_update` date NULL DEFAULT NULL,
  `ttd_kakanwil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_kakanwil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_konfig`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for konfigurasi_jamkerja
-- ----------------------------
DROP TABLE IF EXISTS `konfigurasi_jamkerja`;
CREATE TABLE `konfigurasi_jamkerja`  (
  `nik` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `hari` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_jam_kerja` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for konfigurasi_lokasi
-- ----------------------------
DROP TABLE IF EXISTS `konfigurasi_lokasi`;
CREATE TABLE `konfigurasi_lokasi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lokasi_kantor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `radius` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengajuan_izin
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_izin`;
CREATE TABLE `pengajuan_izin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tgl_izin` date NULL DEFAULT NULL,
  `status` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'i:izin s:sakit',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_approved` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '0:Pending 1:Disetujui 2:Ditolak',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for presensi
-- ----------------------------
DROP TABLE IF EXISTS `presensi`;
CREATE TABLE `presensi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tgl_presensi` date NULL DEFAULT NULL,
  `jam_in` time(0) NULL DEFAULT NULL,
  `jam_out` time(0) NULL DEFAULT NULL,
  `foto_in` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto_out` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lokasi_in` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lokasi_out` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for satker
-- ----------------------------
DROP TABLE IF EXISTS `satker`;
CREATE TABLE `satker`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kode_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `roles` enum('humas_kanwil','humas_satker','superadmin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `konfigurasi_berita` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `konfigurasi_rekap` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  INDEX `kode_satker`(`kode_satker`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satker
-- ----------------------------
INSERT INTO `satker` VALUES (1, 'ADAM NBC', 'adams', 'SAT-NTB-01', 'adamsedit@gmail.com', '2024-01-23 08:05:54', '$2y$10$a7Mzk8hX/8UWk2iPKeC6aeMNowX/8C6V.xFijkIwln3PQgKLd7Zy.', NULL, '2024-02-23 15:56:48', '2024-03-15 00:00:00', '12345678', 'humas_kanwil', NULL, NULL, 'SAT-NTB-01.jpeg');
INSERT INTO `satker` VALUES (3, 'KAKA SLANK', 'kaka', 'SAT-NTB-02', 'kaka@gmail.com', '2024-01-23 08:05:54', '$2y$10$873EhKlfRK7gR4KdNIwQjugXKZSzf2oybIucBbJWylZsXwPAoP36y', NULL, '2024-02-23 15:56:48', '2024-04-19 00:00:00', '12345678', 'humas_kanwil', NULL, NULL, 'SAT-NTB-02.jpeg');
INSERT INTO `satker` VALUES (4, 'ADMIN SLANK', 'admin', 'SAT-NTB-03', 'admin@gmail.com', '2024-01-23 08:05:54', '$2y$10$j7hZA7nThUY0xGkL9wJbdOhLH0md8M.ompnqx4MStg.RaTMP9Mz3G', NULL, '2024-02-23 15:56:48', '2024-03-15 00:00:00', '12345678', 'superadmin', NULL, NULL, 'SAT-NTB-03.png');
INSERT INTO `satker` VALUES (21, 'LAPAS KLAS IIA MATARAM', 'Lapas Mataram', 'SAT-NTB-04', 'lapasmataram@gmail.com', '2024-01-23 08:05:54', '$2y$10$Cdz1tzOsg.YwXtTtGSFRI.OEb1kftMvLRBUV6QgidflUGmP1FTPZG', NULL, '2024-02-23 15:56:48', '2024-04-19 00:00:00', '12345', 'humas_satker', NULL, NULL, 'SAT-NTB-04.jpg');
INSERT INTO `satker` VALUES (22, 'LAPAS KLAS IIA SUMBAWA BESAR', NULL, 'SAT-NTB-05', 'lapassumbawa@gmail.com', '2024-01-23 08:05:54', '$2y$10$TbTcLqBQ6rJYCpvGRY6kz.FQ/ZsoNSZ3MZlmajOsqqpILAROmW8r6', NULL, '2024-02-23 15:56:48', '2024-04-19 00:00:00', '12345', 'humas_satker', NULL, NULL, 'SAT-NTB-05.jpeg');
INSERT INTO `satker` VALUES (23, 'LAPAS KLAS IIB DOMPU', NULL, 'SAT-NTB-06', 'lapasdompu@gmail.com', '2024-01-23 08:05:54', '$2y$10$FiJvkkPlqa5/jX3UNSEfDOxKfHpSF/dIJIII.RqrAYs4SnQvYsg1m', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (24, 'LAPAS KLAS IIB SELONG', NULL, 'SAT-NTB-07', 'lapasselong@gmail.com', '2024-01-23 08:05:54', '$2y$10$ux6VhbUt1aJGQAIzCHBM8uMd4We/XZEEE0T3DG4FTKKUMeLzjbG3e', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (25, 'LAPAS TERBUKA KLAS IIB LOMBOK TENGAH', NULL, 'SAT-NTB-08', 'lapasterbuka@gmail.com', '2024-01-23 08:05:54', '$2y$10$C.WpwBwA76SmlS4RIbG2LeH4ZQ2piqxTMJylbF00yq3Tn7Xg7tCRK', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (26, 'LPKA KLAS II LOMBOK TENGAH', NULL, 'SAT-NTB-09', 'lpka@gmail.com', '2024-01-23 08:05:54', '$2y$10$4x.RR3tPfUQ3cS9ijD982uFjvEMkEa6g5Ca2y4L8TkK9MfavIml1i', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (27, 'LPP KLAS III MATARAM', NULL, 'SAT-NTB-010', 'lppmataram@gmail.com', '2024-01-23 08:05:54', '$2y$10$78hZfy/HOe79ynktQNMGfeB0iniv/oYQps.SO3134Po/6/OoHQhlK', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (28, 'RUTAN KLAS IIB PRAYA', NULL, 'SAT-NTB-011', 'rutanpraya@gmail.com', '2024-01-23 08:05:54', '$2y$10$zckhhl5k/T6k1O.AF2UOlu15GgMpin2SBSudEmgW1dqLmv6nDpwMS', NULL, '2024-02-23 15:56:48', '2024-03-15 00:00:00', '12345', 'humas_satker', NULL, NULL, 'SAT-NTB-011.jpeg');
INSERT INTO `satker` VALUES (29, 'RUTAN KLAS IIB RABA BIMA', NULL, 'SAT-NTB-012', 'rutanbima@gmail.com', '2024-01-23 08:05:54', '$2y$10$7JRmzM1elXTcurXZeA6kk.Qy/6QY9Kt6desdRBPABUra2BQ70XCHC', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (30, 'BAPAS KLAS II MATARAM', NULL, 'SAT-NTB-013', 'bapasmataram@gmail.com', '2024-01-23 08:05:54', '$2y$10$t91Yupbe4wIHdAncI1tujOlQCjTreWC789u2StrxBd.SQfLtHblQa', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (31, 'BAPAS KLAS II SUMBAWA BESAR', NULL, 'SAT-NTB-014', 'bapassumbawa@gmail.com', '2024-01-23 08:05:54', '$2y$10$TT799TF0F4KC/JTf/dy7R.35XnOdigkf0gYRFnmCMYlcvr3cqoPlO', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (32, 'RUPBASAN KLAS I MATARAM', NULL, 'SAT-NTB-015', 'rupbasanmataram@gmail.com', '2024-01-23 08:05:54', '$2y$10$jq1AXU8CRFKgTWUgro/DPeTuQXn0oln8S3hMWGineoZBRwwoPQxBK', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (33, 'RUPBASAN KLAS II SUMBAWA BESAR', NULL, 'SAT-NTB-016', 'rupbasansumbawa@gmail.com', '2024-01-23 08:05:54', '$2y$10$0pEx696ZrSOfWbHvkNs.NuynbyYPpEgjUd8l7NGnWZo1IkmqXTy.y', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (34, 'KANIM KLAS I TPI MATARAM', NULL, 'SAT-NTB-017', 'kanimmataram@gmail.com', '2024-01-23 08:05:54', '$2y$10$KaGAY4wN1hakgi.IHuMAyuFECPXMKTG7x12176GeAUm.oWAXwHGT.', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (35, 'KANIM KLAS II TPI SUMBAWA BESAR', NULL, 'SAT-NTB-018', 'kanimsumbawa@gmail.com', '2024-01-23 08:05:54', '$2y$10$9/s9A0Sudqvx3mL565gj1uJAVa2AVpZHnTMzoIVAlPUAiKxZsVrkS', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);
INSERT INTO `satker` VALUES (37, 'KANIM KLAS III NON TPI BIMA', NULL, 'SAT-NTB-019', 'kanimbima@gmail.com', '2024-01-23 08:05:54', '$2y$10$jn9IaUiLyJPC4pdu9DNsdeZZ7GKT0W6JKUBRyY5S5oV/Fy.b.aD0m', NULL, '2024-02-23 15:56:48', '2024-02-23 15:56:48', '12345', 'humas_satker', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
