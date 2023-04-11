-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 03, 2023 at 06:29 AM
-- Server version: 8.0.27
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health_korner`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `email` (`email`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `phone`, `email`, `role`, `password`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Anjan Talukdar', '8638292131', 'anjan@codepilot.in', '1', '$2y$10$WaAfGrfWwu3b1IcfAphJ9eAEIEBNUHKqzOlwqEHhVTeZgpBYWynqC', '2023-01-09 07:05:25', NULL, '2023-01-09 07:05:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`,`email`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `module_name`, `slug`) VALUES
(1, 'Doctor', 'doctor');

-- --------------------------------------------------------

--
-- Table structure for table `module_access`
--

DROP TABLE IF EXISTS `module_access`;
CREATE TABLE IF NOT EXISTS `module_access` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_access`
--

INSERT INTO `module_access` (`id`, `module_id`, `role`) VALUES
(1, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `sub_module`
--

DROP TABLE IF EXISTS `sub_module`;
CREATE TABLE IF NOT EXISTS `sub_module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `sub_module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_module`
--

INSERT INTO `sub_module` (`id`, `module_id`, `sub_module`, `slug`) VALUES
(3, 1, 'Schedule', 'schedule'),
(4, 1, 'Invoice', 'invoice');

-- --------------------------------------------------------

--
-- Table structure for table `sub_module_access`
--

DROP TABLE IF EXISTS `sub_module_access`;
CREATE TABLE IF NOT EXISTS `sub_module_access` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_module_id` int NOT NULL,
  `role_id` int NOT NULL,
  `create` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `update` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `sub_module_id` (`sub_module_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_module_access`
--

INSERT INTO `sub_module_access` (`id`, `sub_module_id`, `role_id`, `create`, `read`, `update`, `delete`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 3, 1, 1, 1, 1, 1, '2023-01-09 06:42:54', NULL, '2023-01-09 06:42:54', NULL),
(4, 3, 2, 1, 1, 1, 1, '2023-01-09 06:42:54', NULL, '2023-01-09 06:42:54', NULL),
(5, 3, 3, 1, 1, 1, 0, '2023-01-09 06:42:54', NULL, '2023-01-09 06:42:54', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `client_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `module_access`
--
ALTER TABLE `module_access`
  ADD CONSTRAINT `module_access_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `sub_module`
--
ALTER TABLE `sub_module`
  ADD CONSTRAINT `sub_module_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_module_access`
--
ALTER TABLE `sub_module_access`
  ADD CONSTRAINT `sub_module_access_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_module_access_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_module_access_ibfk_4` FOREIGN KEY (`sub_module_id`) REFERENCES `sub_module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_module_access_ibfk_5` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
