-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 01:22 PM
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
-- Database: `krl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `salary` decimal(10,0) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `emergency_contact_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `aadhaar_number` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `employee_photo` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `role`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`, `last_name`, `designation`, `salary`, `department`, `date_of_joining`, `phone_number`, `emergency_contact_number`, `address`, `state`, `pin_code`, `aadhaar_number`, `username`, `pan_number`, `bank_account_number`, `ifsc_code`, `employee_photo`, `status`) VALUES
(8, 'New Admin', 'admin@gmail.com', '7', NULL, NULL, '$2y$12$23ukNQSVbnyflSY1WmPnXOli8xpV.0O0X4UMzaJTEdqc4encSZAkK', NULL, '2025-03-06 11:33:32', '2025-05-08 01:37:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(11, 'ishwar rathore', 'test@gmail.com', '5', NULL, NULL, '$2y$12$h/0juomO0B462OuagQ/vcu7C9RHHA7ffBhxtapJ5BEdLERb7/4mP6', NULL, '2025-05-05 01:13:48', '2025-05-06 01:55:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active'),
(12, 'mohit', 'mohit@gmail.com', '12', NULL, NULL, '$2y$12$.4quKLz7d3zo76ZbVU.Pae4FELL2BtdG/LyQrnqjaFAEWdwpsKtwC', NULL, '2025-05-05 02:54:00', '2025-05-24 05:45:54', 'sharma', 'Manager', 8000, 'Manager', '2025-05-30', '9009149401', '9977926348', '302 Krsihna tower', 'Uttar Pradesh', '452018', '34324555', NULL, 'ASDR3445', 'ASEDR43', 'EDRF4566', 'employee_1748085354.png', 'active'),
(20, 'mina sharma', 'jiya@gmail.com', '12', NULL, NULL, '$2y$12$lopv59kneqnDcLJoD9gP/.p6U68/8ST2qn5RA91gfMuDFaiJcTtXi', NULL, '2025-05-24 02:36:59', '2025-05-24 04:18:35', 'sharma', 'Manager', 500, 'Manager', '2025-05-25', '9009149401', '9009149401', '302 Krsihna tower', 'Delhi', '452018', '747', NULL, 'ASDR3445', '852147963574', 'RATIONE VOLUPTAS ANI', 'employee_1748080115.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','halfday') NOT NULL DEFAULT 'present',
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `admin_id`, `date`, `status`, `remark`, `created_at`, `updated_at`) VALUES
(242, 8, '2025-05-24', 'absent', 'm', '2025-05-24 05:30:37', '2025-05-24 05:38:25'),
(241, 11, '2025-05-24', 'present', 'present done', '2025-05-24 05:30:37', '2025-05-24 05:30:37'),
(240, 12, '2025-05-24', 'halfday', 'mm', '2025-05-24 05:30:37', '2025-05-24 05:38:38'),
(239, 20, '2025-05-24', 'present', 'present done', '2025-05-24 05:30:37', '2025-05-24 05:30:37'),
(243, 20, '2025-05-26', 'present', NULL, '2025-05-26 04:21:57', '2025-05-26 04:21:57'),
(244, 12, '2025-05-26', 'present', NULL, '2025-05-26 04:21:57', '2025-05-26 04:21:57'),
(245, 11, '2025-05-26', 'present', NULL, '2025-05-26 04:21:57', '2025-05-26 04:21:57'),
(246, 8, '2025-05-26', 'present', NULL, '2025-05-26 04:21:57', '2025-05-26 04:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, NULL, 'subcategories/R5u2qogluxMRbicFvKtAk4CaW2UKAOrF6D4XsdYR.jpg', 1, '2025-03-07 04:57:03', '2025-03-07 05:08:51'),
(3, NULL, 'subcategories/mtPjOEjl2ytWJZPLcLhjvxedI1ULF40o92VKGdmL.png', 1, '2025-03-07 05:08:15', '2025-03-07 05:09:00'),
(6, NULL, 'banners/aWJ5tCjd8gStvHQp2NXtkAq8rZLOGWMobp78Lg96.png', 1, '2025-03-07 05:25:03', '2025-03-07 05:25:03'),
(7, NULL, 'banners/x4brVzBLuDBGLev47cPsJT5xuAyNTpYSWKoXSdER.png', 1, '2025-03-15 09:57:12', '2025-03-15 09:57:12'),
(8, NULL, 'banners/yoDl1tRL9e2HJUgydKllqsSD2mQhgnOsq6A1sW01.png', 1, '2025-03-15 09:57:33', '2025-03-15 09:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(28, 'Fruits', 1, NULL, NULL),
(29, 'Vegetables', 1, NULL, NULL),
(30, 'Grains', 1, NULL, NULL),
(31, 'Dairy Products', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `pan` varchar(20) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `aadhar_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `against_user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext DEFAULT NULL,
  `from_destination_id` bigint(20) DEFAULT NULL,
  `to_destination_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `type_id`, `description`, `from_destination_id`, `to_destination_id`, `user_id`, `rate`, `documents`, `created_at`, `updated_at`) VALUES
(86, 4, 'Description', 1, 2, 129, 200.00, NULL, '2025-05-28 01:49:17', '2025-05-28 01:49:17'),
(87, 4, 'Description', 2, 1, 129, 200.00, NULL, '2025-05-28 01:49:44', '2025-05-28 01:49:44'),
(88, 4, 'testts', 3, 4, 130, 900.00, NULL, '2025-05-28 01:50:10', '2025-05-28 01:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `demand_listings`
--

CREATE TABLE `demand_listings` (
  `id` int(11) NOT NULL,
  `subcategory_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selling_rate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivary_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demand_listings`
--

INSERT INTO `demand_listings` (`id`, `subcategory_id`, `quantity`, `unit`, `selling_rate`, `per_unit`, `delivary_date`, `created_at`, `updated_at`, `user_id`, `image`) VALUES
(1, '7', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-11 07:04:17', '2025-03-11 07:04:17', 18, 'demand_images/E1PDCU51OPrFuC0BI88ZY43nBZF7EiqDs5GBbtf6.png'),
(2, '7', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-11 07:08:17', '2025-03-11 07:08:17', 18, NULL),
(3, '7', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-15 10:37:20', '2025-03-15 10:37:20', 38, NULL),
(4, '7', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-17 01:30:08', '2025-03-17 01:30:08', 38, NULL),
(5, '8', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-17 02:48:52', '2025-03-17 02:48:52', 38, NULL),
(6, '9', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-17 02:49:19', '2025-03-17 02:49:19', 38, NULL),
(7, '9', '20', 'kg', '150', 'Kilogram', '2025-03-20', '2025-03-17 06:57:00', '2025-03-17 06:57:00', 38, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `destination`, `created_at`, `updated_at`) VALUES
(1, 'Mumbai', '2025-04-17 04:30:29', '2025-04-17 04:32:14'),
(2, 'Pune', '2025-04-17 04:33:09', '2025-04-17 04:33:09'),
(3, 'Nagpur', '2025-04-17 04:33:23', '2025-04-17 04:33:23'),
(4, 'kollkata', '2025-04-17 04:33:58', '2025-04-17 04:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `emergency_contact_number` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `aadhaar_number` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `driver_photo` varchar(255) DEFAULT NULL,
  `aadhaar_doc` varchar(255) DEFAULT NULL,
  `license_doc` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `first_name`, `last_name`, `phone_number`, `emergency_contact_number`, `address`, `state`, `pin_code`, `aadhaar_number`, `vehicle_number`, `driver_photo`, `aadhaar_doc`, `license_doc`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Silas', 'Stuart', '280', '863', 'Sunt voluptatem mag', 'Tamil Nadu', '1234567', NULL, 'mp 04 GA 0786', 'drivers/drivers_photos/BOAtuTgPCYFrGK3lA730yS1HHnAlvGBizQA2vk6l.png', 'drivers/aadhaar/Y75qEQjIk8mS4DpG3QMPawEb3JxS8qAcb43PuvOm.png', 'drivers/license/GhAON8abyycWl8x19VH2CdyXdZGQfXwy0sfh3z1m.png', 'active', '2025-04-15 00:05:03', '2025-05-06 06:20:22'),
(4, 'Graiden', 'Ortega', '9669198800', '9643456789', 'Aut cupidatat volupt', 'Karnataka', '4545454', '95345455554545', 'Ut ut eos quas temp', 'drivers/drivers_photos/j4efwXdbrosV4gaTg01KNhv5rQWKbcVXLRdbR6aN.png', 'drivers/aadhaar/sOUn6AZeYFfRHvuCB9v0rgm8U0KkMjZC9KlDZseQ.png', 'drivers/license/10UpfXCiIBW5o0Ff6EYdPKGJohgK52S02vC9Hvnl.png', 'active', '2025-04-08 07:22:30', '2025-04-08 07:22:30'),
(5, 'rajnikant', 'gaykvad', '34567890', '9643456789', 'gao', 'Tamil Nadu', '111111', NULL, 'Ut ut eos quas temp', 'drivers/drivers_photos/SQYYhTcRyaSupADMUdJiGxHPA52XTaqnTCL70vfC.png', 'drivers/aadhaar/KAV5foZj9c5i8GnyoQr8m52AcrOKKqekcVtbqbJc.png', 'drivers/license/hpcyNbLU8onUooXyqhLxE2cos18xJA7SUO5ZFdor.png', 'active', '2025-04-08 08:20:19', '2025-04-08 08:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `date_of_joining` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `emergency_contact_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `aadhaar_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `employee_photo` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `role`, `password`, `first_name`, `last_name`, `designation`, `salary`, `department`, `date_of_joining`, `email`, `phone_number`, `emergency_contact_number`, `address`, `state`, `pin_code`, `aadhaar_number`, `pan_number`, `bank_account_number`, `ifsc_code`, `status`, `employee_photo`, `created_at`, `updated_at`) VALUES
(30, '12', '$2y$12$wj1dkUCKRiAYZHyc0/u6ZuXrT60C8ac64LuiwLDjKBuoLdS3CktgK', 'gita', 'bangde', 'Manager', 4342.00, 'Manager', '2025-05-23', 'gita@gmail.com', '8521478574', '9009149401', 'swarsadhana1@swarsadhanamusicloversclub.com', 'Delhi', '452018', '7478521479634', 'ASDR3445', '852144rtygfh', 'IFSCCODE456', 'active', 'employees/employee_photos/fhM8snyJ662IFPMWM4dbnbLGp8P1BVBsut7fiNvl.png', '2025-05-22 05:34:42', '2025-05-23 07:25:02'),
(29, '5', '$2y$12$8KdzPX9y.9fYADNadmOIJeGSQeZMPrExBhINqg2OKemZyDNtWpF0i', 'SITA', 'sharma', 'Manager', 5000.00, 'HR', '2025-05-22', 'sharma@gmail.com', '9009149401', '9977926348', 'swarsadhana1@swarsadhanamusicloversclub.com', 'Delhi', '452018', '7478521479634', 'ASDR3445', '852144rtygfh', 'IFSCCODE456', 'active', 'employees/employee_photos/rArDj6Ngs9jLSSopHJsWXfAJLoxDa6eecWkIE3eM.png', '2025-05-21 06:34:03', '2025-05-21 07:01:58'),
(31, '12', '$2y$12$akof1hdT6omml3pif.fEIuoDMNAJAcB7ojQpQOYda55t6ZBJmXmci', 'modi', 'shrma', 'Vel quia ipsum eius', 1500.00, 'Manager', '2025-05-24', 'modi@gmail.com', '8521479635', '7412589635', 'swarsadhana1@swarsadhanamusicloversclub.com', 'Delhi', '452018', '7478521479634', '849ASDRF', '374', 'IFSCCODE456', 'active', 'employees/employee_photos/a5RUetesOJGu3kpYpBWAe6QA4Li6BIVcsRuEI84Y.png', '2025-05-23 07:51:25', '2025-05-23 07:51:25'),
(32, '7', '$2y$12$N6E6Thv7YqJgnepTBUZEIeOXQ8espQg8FEBe3H9Zbey8FU7aASJtK', 'Asher', 'Higgins', 'Obcaecati aut ut rep', 76.00, 'Accounts', '2011-09-26', 'buvutyh@mailinator.com', '+1 (243) 163-6995', '624', 'Adipisicing deserunt', 'Delhi', '99', '569', '479', '175', 'RATIONE DESERUNT ID', 'inactive', 'employees/employee_photos/dhmNAsNCfOXg1iVfgGccJxwyZHnSXYOaBXQyXhtN.png', '2025-05-24 02:31:30', '2025-05-24 02:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freight_bill`
--

CREATE TABLE `freight_bill` (
  `id` int(11) NOT NULL,
  `order_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`order_id`)),
  `lr_number` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lr_number`)),
  `freight_bill_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `notes` varchar(225) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freight_bill`
--

INSERT INTO `freight_bill` (`id`, `order_id`, `lr_number`, `freight_bill_number`, `notes`, `updated_at`, `created_at`) VALUES
(186, '\"[\\\"ORD-000001\\\"]\"', '\"[\\\"LR-1749188434096\\\"]\"', 'FB20250606-001', NULL, '2025-06-06 05:43:33', '2025-06-06 05:43:33'),
(187, '\"[\\\"ORD-1750164016\\\"]\"', '\"[\\\"LR-1750164016-1\\\",\\\"LR-1750164016-2\\\"]\"', 'FB20250627-002', NULL, '2025-06-27 04:42:00', '2025-06-27 04:42:00'),
(188, '\"[\\\"ORD-1750164016\\\"]\"', '\"[\\\"LR-1750164016-1\\\",\\\"LR-1750164016-2\\\"]\"', 'FB20250627-003', NULL, '2025-06-27 05:00:44', '2025-06-27 05:00:44'),
(189, '\"[\\\"ORD-1749188997\\\",\\\"ORD-000001\\\"]\"', '\"[\\\"LR-1749189154815\\\",\\\"LR-1749188434096\\\"]\"', 'FB20250701-004', NULL, '2025-07-01 07:12:48', '2025-07-01 07:12:48'),
(190, '\"[\\\"ORD-1750148798\\\"]\"', '\"[\\\"LR-1750148798-2\\\"]\"', 'FB20250701-005', NULL, '2025-07-01 07:20:48', '2025-07-01 07:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `sub_group` varchar(255) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `sub_group`, `parent_id`, `created_at`, `updated_at`) VALUES
(19, 'Bank', NULL, NULL, '2025-05-09 01:40:12', '2025-05-09 01:40:12'),
(20, 'Cash', NULL, NULL, '2025-05-09 01:40:30', '2025-05-09 01:40:30'),
(21, 'Loan', NULL, NULL, '2025-05-09 01:40:40', '2025-05-09 01:40:40'),
(23, 'Sales', NULL, NULL, '2025-05-12 04:19:25', '2025-05-12 04:20:12'),
(26, 'Vendors', NULL, NULL, '2025-05-22 05:27:30', '2025-05-22 05:28:28'),
(28, 'Expense', NULL, NULL, '2025-05-26 01:26:26', '2025-05-26 02:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `freight_bill_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `invoice_date`, `freight_bill_id`, `created_at`, `updated_at`) VALUES
(10, 'INV-20250606-0186', '2025-06-06', 186, '2025-06-06 05:44:05', '2025-06-06 05:44:05'),
(11, 'INV-20250627-0188', '2025-06-27', 188, '2025-06-27 05:41:37', '2025-06-27 05:41:37'),
(12, 'INV-20250701-0190', '2025-07-01', 190, '2025-07-01 07:21:10', '2025-07-01 07:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledger_master`
--

CREATE TABLE `ledger_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ledger_name` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `tan` varchar(255) DEFAULT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledger_master`
--

INSERT INTO `ledger_master` (`id`, `ledger_name`, `group_id`, `pan`, `tan`, `gst`, `created_at`, `updated_at`) VALUES
(8, 'HDFC BANK', '19', 'UHYGT456ED', 'SS4555F', 'GHYTFRW45555', '2025-05-09 01:41:44', '2025-05-09 01:41:44'),
(9, 'CASH', '20', 'EDRSWQ234', '6766FGHH', 'GHYTFRW45778', '2025-05-09 01:42:18', '2025-05-09 01:42:18'),
(10, 'loan', '21', 'UHYGT456ED', 'AWDRF3456', 'GHYTFRW455RT', '2025-05-12 01:18:08', '2025-05-12 01:18:08'),
(12, 'Eagan Kemp', '22', 'UHYGT456ED', 'ss', 'Omnis ex voluptate e', '2025-05-12 04:09:45', '2025-05-12 04:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoparts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `odometer_reading` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenances`
--

INSERT INTO `maintenances` (`id`, `vehicle`, `category`, `vendor`, `autoparts`, `created_at`, `updated_at`, `odometer_reading`) VALUES
(6, 'HERO HONDA', 'routine_check', 'mechanic', '[{\"name\":\"nn\",\"id\":\"fdf\",\"quantity\":\"68\"},{\"name\":\"uihk\",\"id\":\"uhio\",\"quantity\":\"77\"}]', '2025-04-05 01:49:18', '2025-05-22 01:22:10', 434344),
(7, 'eco', 'routine_check', 'service_center', '[{\"id\": \"fdf\", \"name\": \"gair\", \"quantity\": \"44\"}]', '2025-04-05 01:51:13', '2025-04-09 23:49:23', 1234),
(12, 'Unde eu quaerat irur', 'major_repair', 'service_center', '[{\"id\": \"1\", \"name\": \"gair\", \"quantity\": \"1\"}, {\"id\": \"1\", \"name\": \"bark\", \"quantity\": \"1\"}]', '2025-04-09 23:49:58', '2025-04-09 23:49:58', 4234234),
(13, 'Unde eu quaerat irur', 'major_repair', 'service_center', '[{\"id\": \"Sunt sequi quam occa\", \"name\": \"Rafael Gilliam\", \"quantity\": \"547\"}]', '2025-04-15 01:16:02', '2025-04-15 01:16:02', 64),
(14, 'HERO HONDA', 'routine_check', 'service_center', '[{\"name\":\"HJ\",\"id\":\"6YT6Y\",\"quantity\":\"6\"},{\"name\":\"TY\",\"id\":\"76DR\",\"quantity\":\"10\"}]', '2025-05-08 02:24:00', '2025-05-08 02:24:00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_02_120019_create_tyres_table', 2),
(5, '2025_04_04_112541_create_sessions_table', 3),
(6, '2025_04_05_060940_create_maintenances_table', 4),
(7, '2025_04_05_071245_add_odometer_reading_to_maintenances_table', 5),
(8, '2025_04_07_130815_add_designation_to_employees_table', 6),
(9, '2025_04_08_110236_create_drivers_table', 7),
(10, '2025_04_09_064204_create_attendances_table', 8),
(11, '2025_04_09_120120_add_salary_to_employees_table', 9),
(12, '2025_04_11_113334_create_task_managements_table', 10),
(13, '2025_04_17_073308_create_package_types_table', 11),
(14, '2025_04_17_094024_create_destinations_table', 12),
(15, '2025_05_02_072342_create_roles_table', 13),
(16, '2025_05_03_054547_create_permission_tables', 14),
(17, '2025_05_03_101340_create_permission_tables', 15),
(18, '2025_05_03_133220_create_permission_tables', 16),
(19, '2025_05_03_133516_create_modules_table', 17),
(20, '2025_05_08_094437_create_vouchers_table', 18),
(21, '2025_05_08_111928_create_groups_table', 19),
(22, '2025_05_08_131700_create_ledger_master_table', 20),
(23, '2025_05_08_131943_create_ledger_master_table', 21),
(24, '2025_05_08_132456_create_ledger_master_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\Admin', 11),
(5, 'App\\Models\\Admin', 12),
(7, 'App\\Models\\Admin', 8);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`actions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `actions`, `created_at`, `updated_at`) VALUES
(6, 'dashboard', '[\"manage\"]', '2025-05-04 02:31:54', '2025-05-04 02:31:54'),
(7, 'order_booking', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:33:01', '2025-05-04 02:33:01'),
(8, 'lr_consignment', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:33:40', '2025-05-04 02:33:40'),
(9, 'freight_bill', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:34:10', '2025-05-04 02:34:10'),
(10, 'vehicles', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:34:34', '2025-05-04 02:34:34'),
(11, 'maintenance', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:35:31', '2025-05-04 02:35:31'),
(12, 'tyres', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:36:09', '2025-05-04 02:36:09'),
(13, 'task_managment', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:36:47', '2025-05-04 02:36:47'),
(14, 'employees', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:37:11', '2025-05-04 02:37:11'),
(15, 'drivers', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:37:33', '2025-05-04 02:37:33'),
(16, 'attendance', '[\"create\", \"manage\"]', '2025-05-04 02:39:20', '2025-05-04 02:39:20'),
(17, 'payroll', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:39:57', '2025-05-04 02:39:57'),
(18, 'customer', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:41:11', '2025-05-04 02:41:11'),
(19, 'package_type', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:41:41', '2025-05-04 02:41:41'),
(20, 'destination', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:42:08', '2025-05-04 02:42:08'),
(21, 'contract', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:42:29', '2025-05-04 02:42:29'),
(22, 'vehicle_type', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:42:58', '2025-05-04 02:42:58'),
(23, 'warehouse', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:43:46', '2025-05-04 02:43:46'),
(24, 'stock_transfer', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:44:12', '2025-05-04 02:44:12'),
(25, 'permissions', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:44:39', '2025-05-04 02:44:39'),
(26, 'role', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:45:04', '2025-05-04 02:45:04'),
(27, 'settings', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 02:45:29', '2025-05-04 02:45:29'),
(28, 'settings', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 08:00:37', '2025-05-04 08:00:37'),
(29, 'payout', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-04 08:02:01', '2025-05-04 08:02:01'),
(30, 'users', '[\"create\",\"edit\",\"delete\",\"view\",\"manage\"]', '2025-05-05 08:03:08', '2025-05-05 08:03:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo_description_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_gst` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_method` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'order method type',
  `byorder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bycontract` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_addresss` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleiver_addresss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `consignor_gst` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignor_loading` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `consignee_gst` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignee_unloading` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `from_destination_id` bigint(20) DEFAULT NULL,
  `to_destination_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `lr`, `status`, `description`, `order_date`, `order_type`, `cargo_description_type`, `customer_id`, `customer_gst`, `customer_address`, `order_method`, `byorder`, `bycontract`, `pickup_addresss`, `deleiver_addresss`, `consignor_id`, `consignor_gst`, `consignor_loading`, `consignee_id`, `consignee_gst`, `consignee_unloading`, `created_at`, `updated_at`, `user_id`, `from_destination_id`, `to_destination_id`) VALUES
(218, 'ORD-000001', '\"{\\\"1\\\":{\\\"lr_number\\\":\\\"LR-1749188434096\\\",\\\"lr_date\\\":\\\"2025-06-18\\\",\\\"vehicle_no\\\":null,\\\"vehicle_type\\\":\\\"4\\\",\\\"vehicle_ownership\\\":\\\"Own\\\",\\\"delivery_mode\\\":\\\"godwon_deliver\\\",\\\"from_location\\\":\\\"1\\\",\\\"to_location\\\":\\\"3\\\",\\\"consignor_id\\\":\\\"153\\\",\\\"consignor_gst\\\":\\\"Et quibusdam explica\\\",\\\"consignor_loading\\\":\\\"Enim consequatur sit\\\",\\\"consignee_id\\\":\\\"153\\\",\\\"consignee_gst\\\":\\\"Et quibusdam explica\\\",\\\"consignee_unloading\\\":\\\"Enim consequatur sit\\\",\\\"freightType\\\":\\\"paid\\\",\\\"freight_amount\\\":\\\"110.00\\\",\\\"lr_charges\\\":\\\"1\\\",\\\"hamali\\\":\\\"1\\\",\\\"other_charges\\\":\\\"1\\\",\\\"gst_amount\\\":\\\"5.65\\\",\\\"total_freight\\\":\\\"118.65\\\",\\\"less_advance\\\":\\\"1\\\",\\\"balance_freight\\\":\\\"117.65\\\",\\\"total_declared_value\\\":\\\"11.00\\\",\\\"insurance_description\\\":null,\\\"insurance_status\\\":\\\"no\\\",\\\"order_rate\\\":\\\"10.00\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"11\\\",\\\"package_type\\\":\\\"2\\\",\\\"package_description\\\":\\\"In consequatur Magn\\\",\\\"actual_weight\\\":\\\"11\\\",\\\"charged_weight\\\":\\\"11\\\",\\\"document_no\\\":\\\"Quas fugiat culpa fu\\\",\\\"document_name\\\":\\\"Florence Christensen\\\",\\\"document_date\\\":\\\"2025-07-10\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"11\\\",\\\"eway_bill\\\":\\\"Eaque omnis ut corpo\\\",\\\"valid_upto\\\":\\\"2025-06-24\\\",\\\"unit\\\":\\\"kg\\\"}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"MH0022\\\",\\\"remarks\\\":\\\"Aut incidunt laboru\\\",\\\"is_selected\\\":false}],\\\"eway_bills\\\":[\\\"711008845840\\\",\\\"781008845841\\\",\\\"751008845842\\\",\\\"721008845843\\\"]}}\"', '\"Request-invioce\"', 'Ad aliquip consequat', '2019-11-15', 'export', NULL, 153, 'Et quibusdam explica', 'Enim consequatur sit', 'order', '10', NULL, '59 Hague Drive', 'ujjain', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-06 05:35:11', '2025-06-17 06:30:58', NULL, 1, 3),
(222, 'ORD-1749188997', '\"{\\\"1\\\":{\\\"lr_number\\\":\\\"LR-1749189154815\\\",\\\"lr_date\\\":\\\"2025-06-18\\\",\\\"vehicle_no\\\":null,\\\"vehicle_type\\\":\\\"4\\\",\\\"vehicle_ownership\\\":\\\"Own\\\",\\\"delivery_mode\\\":\\\"godwon_deliver\\\",\\\"from_location\\\":\\\"2\\\",\\\"to_location\\\":\\\"3\\\",\\\"consignor_id\\\":\\\"153\\\",\\\"consignor_gst\\\":\\\"Et quibusdam explica\\\",\\\"consignor_loading\\\":\\\"Enim consequatur sit\\\",\\\"consignee_id\\\":\\\"153\\\",\\\"consignee_gst\\\":\\\"Et quibusdam explica\\\",\\\"consignee_unloading\\\":\\\"Enim consequatur sit\\\",\\\"freightType\\\":\\\"paid\\\",\\\"freight_amount\\\":\\\"121.00\\\",\\\"lr_charges\\\":\\\"33\\\",\\\"hamali\\\":null,\\\"other_charges\\\":null,\\\"gst_amount\\\":\\\"7.70\\\",\\\"total_freight\\\":\\\"161.70\\\",\\\"less_advance\\\":null,\\\"balance_freight\\\":\\\"161.70\\\",\\\"total_declared_value\\\":\\\"21.00\\\",\\\"insurance_description\\\":null,\\\"insurance_status\\\":\\\"no\\\",\\\"order_rate\\\":\\\"11.00\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"11\\\",\\\"package_type\\\":\\\"5\\\",\\\"package_description\\\":\\\"fdf\\\",\\\"actual_weight\\\":\\\"11\\\",\\\"charged_weight\\\":\\\"11\\\",\\\"document_no\\\":\\\"Perferendis vel in n\\\",\\\"document_name\\\":\\\"Sage Rivera\\\",\\\"document_date\\\":\\\"2025-06-11\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"21\\\",\\\"eway_bill\\\":\\\"Proident qui qui in\\\",\\\"valid_upto\\\":\\\"2025-06-04\\\",\\\"unit\\\":\\\"kg\\\"}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"MH04GA 0786\\\",\\\"remarks\\\":\\\"Repudiandae mollit m\\\",\\\"is_selected\\\":false}],\\\"eway_bills\\\":[\\\"781008845838\\\",\\\"751008845839\\\"]}}\"', '\"Request-lr\"', 'my orders', '2025-06-06', 'import-restoff', NULL, 153, 'Et quibusdam explica', 'Enim consequatur sit', 'order', '11', NULL, '59 Hague Drive', 'Delectus rem ipsum', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-06 05:49:57', '2025-06-17 06:27:06', NULL, NULL, NULL),
(246, 'ORD-1750148798', '\"{\\\"1\\\":{\\\"lr_number\\\":\\\"LR-1750148798-1\\\",\\\"lr_date\\\":\\\"1990-09-06\\\",\\\"vehicle_type\\\":\\\"7\\\",\\\"vehicle_ownership\\\":\\\"Other\\\",\\\"delivery_mode\\\":\\\"door_delivery\\\",\\\"from_location\\\":\\\"1\\\",\\\"to_location\\\":\\\"2\\\",\\\"consignor_id\\\":\\\"153\\\",\\\"consignor_gst\\\":\\\"Et quibusdam explica\\\",\\\"consignor_loading\\\":\\\"Enim consequatur sit, Qui mollit quo velit, Consequatur Laborum\\\",\\\"consignee_id\\\":\\\"156\\\",\\\"consignee_gst\\\":\\\"Exercitationem volup\\\",\\\"consignee_unloading\\\":\\\"Magna elit eum anim, Deleniti aut delenit, Error optio velit\\\",\\\"freightType\\\":\\\"paid\\\",\\\"freight_amount\\\":\\\"10450\\\",\\\"lr_charges\\\":\\\"31\\\",\\\"hamali\\\":\\\"61\\\",\\\"other_charges\\\":\\\"45\\\",\\\"gst_amount\\\":\\\"1270.44\\\",\\\"total_freight\\\":\\\"11857.44\\\",\\\"less_advance\\\":\\\"57\\\",\\\"balance_freight\\\":\\\"11800.44\\\",\\\"total_declared_value\\\":\\\"144\\\",\\\"order_rate\\\":\\\"95\\\",\\\"insurance_description\\\":null,\\\"insurance_status\\\":\\\"no\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"91\\\",\\\"package_type\\\":\\\"2\\\",\\\"package_description\\\":\\\"Aliquam aliquip rem\\\",\\\"actual_weight\\\":\\\"28\\\",\\\"charged_weight\\\":\\\"35\\\",\\\"document_no\\\":\\\"Do excepteur numquam\\\",\\\"document_name\\\":\\\"Magee Hopper\\\",\\\"document_date\\\":\\\"2006-06-20\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"80\\\",\\\"eway_bill\\\":\\\"Ab rerum voluptatem\\\",\\\"valid_upto\\\":\\\"1972-07-01\\\",\\\"unit\\\":\\\"kg\\\"},{\\\"packages_no\\\":\\\"89\\\",\\\"package_type\\\":\\\"5\\\",\\\"package_description\\\":\\\"Perspiciatis sed es\\\",\\\"actual_weight\\\":\\\"39\\\",\\\"charged_weight\\\":\\\"75\\\",\\\"document_no\\\":\\\"Veniam nulla suscip\\\",\\\"document_name\\\":\\\"Francis Pitts\\\",\\\"document_date\\\":\\\"2003-02-20\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"64\\\",\\\"eway_bill\\\":\\\"Quo laudantium reru\\\",\\\"valid_upto\\\":\\\"2014-10-02\\\",\\\"unit\\\":\\\"ton\\\"}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"JK667QWE\\\",\\\"remarks\\\":\\\"Dolorem reiciendis a\\\"}],\\\"eway_bills\\\":[\\\"751008845839\\\",\\\"781008845841\\\",\\\"751008845842\\\"]},\\\"2\\\":{\\\"lr_number\\\":\\\"LR-1750148798-2\\\",\\\"lr_date\\\":\\\"2004-02-04\\\",\\\"vehicle_type\\\":\\\"7\\\",\\\"vehicle_ownership\\\":\\\"Other\\\",\\\"delivery_mode\\\":\\\"godwon_deliver\\\",\\\"from_location\\\":\\\"4\\\",\\\"to_location\\\":\\\"1\\\",\\\"consignor_id\\\":\\\"155\\\",\\\"consignor_gst\\\":\\\"Cumque tempore eius\\\",\\\"consignor_loading\\\":\\\"Voluptatem ullam dol, Consequatur ut ipsam, Earum vel ratione co\\\",\\\"consignee_id\\\":\\\"156\\\",\\\"consignee_gst\\\":\\\"316 White Milton Lane\\\",\\\"consignee_unloading\\\":\\\"53 Hague Lane, 761 West Oak Extension, 662 East Green First Avenue\\\",\\\"freightType\\\":\\\"to_pay\\\",\\\"freight_amount\\\":\\\"3800\\\",\\\"lr_charges\\\":\\\"63\\\",\\\"hamali\\\":\\\"10\\\",\\\"other_charges\\\":\\\"95\\\",\\\"gst_amount\\\":\\\"476.16\\\",\\\"total_freight\\\":\\\"4444.16\\\",\\\"less_advance\\\":\\\"73\\\",\\\"balance_freight\\\":\\\"4371.16\\\",\\\"total_declared_value\\\":\\\"82\\\",\\\"order_rate\\\":\\\"95\\\",\\\"insurance_description\\\":\\\"Ullamco esse aperiam\\\",\\\"insurance_status\\\":\\\"yes\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"21\\\",\\\"package_type\\\":\\\"5\\\",\\\"package_description\\\":\\\"Voluptatem aut a re\\\",\\\"actual_weight\\\":\\\"85\\\",\\\"charged_weight\\\":\\\"28\\\",\\\"document_no\\\":\\\"Voluptatem tempora o\\\",\\\"document_name\\\":\\\"Ryder Frazier\\\",\\\"document_date\\\":\\\"1995-10-03\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"18\\\",\\\"eway_bill\\\":\\\"Ullamco saepe rerum\\\",\\\"valid_upto\\\":\\\"2008-12-03\\\",\\\"unit\\\":\\\"ton\\\"},{\\\"packages_no\\\":\\\"74\\\",\\\"package_type\\\":\\\"5\\\",\\\"package_description\\\":\\\"Cumque voluptas est\\\",\\\"actual_weight\\\":\\\"19\\\",\\\"charged_weight\\\":\\\"12\\\",\\\"document_no\\\":\\\"Enim sed corporis au\\\",\\\"document_name\\\":\\\"Patience Christian\\\",\\\"document_date\\\":\\\"2006-09-25\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"64\\\",\\\"eway_bill\\\":\\\"Nostrud et quia dolo\\\",\\\"valid_upto\\\":\\\"2005-07-05\\\",\\\"unit\\\":\\\"kg\\\"}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"JK667QWE\\\",\\\"remarks\\\":\\\"Duis impedit dolor\\\"}],\\\"eway_bills\\\":[\\\"781008845838\\\",\\\"751008845839\\\",\\\"711008845840\\\"]}}\"', '\"Processing\"', 'Et aperiam est quaer', '1989-09-08', 'domestic', 'multiple', 156, 'Exercitationem volup', 'Magna elit eum anim', 'order', '95', NULL, 'Ut nesciunt omnis v', 'Sed aut iste ut ut', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 02:56:38', '2025-06-17 06:32:13', NULL, NULL, NULL),
(247, 'ORD-1750163526', '\"{\\\"1\\\":{\\\"lr_number\\\":\\\"LR-1750163526-1\\\",\\\"lr_date\\\":\\\"2010-02-21\\\",\\\"vehicle_type\\\":\\\"8\\\",\\\"vehicle_ownership\\\":\\\"Own\\\",\\\"delivery_mode\\\":\\\"godwon_deliver\\\",\\\"from_location\\\":\\\"3\\\",\\\"to_location\\\":\\\"2\\\",\\\"insurance_status\\\":\\\"yes\\\",\\\"insurance_description\\\":\\\"Aut quia laboriosam\\\",\\\"consignor_id\\\":\\\"158\\\",\\\"consignor_gst\\\":\\\"237 Milton Parkway\\\",\\\"consignor_loading\\\":\\\"10 Rocky Fabien Boulevard, 564 Clarendon Boulevard, 69 Oak Drive\\\",\\\"consignee_id\\\":\\\"155\\\",\\\"consignee_gst\\\":\\\"63 New Boulevard\\\",\\\"consignee_unloading\\\":\\\"89 South Cowley Street, 857 East White Milton Freeway, 912 Green First Lane\\\",\\\"freightType\\\":\\\"to_pay\\\",\\\"freight_amount\\\":\\\"237.00\\\",\\\"lr_charges\\\":\\\"86\\\",\\\"hamali\\\":\\\"66\\\",\\\"other_charges\\\":\\\"82\\\",\\\"gst_amount\\\":\\\"56.52\\\",\\\"total_freight\\\":\\\"527.52\\\",\\\"less_advance\\\":\\\"7\\\",\\\"balance_freight\\\":\\\"520.52\\\",\\\"total_declared_value\\\":\\\"2\\\",\\\"order_rate\\\":\\\"3\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"31\\\",\\\"package_type\\\":\\\"4\\\",\\\"package_description\\\":\\\"Ut vero perferendis\\\",\\\"declared_value\\\":\\\"2\\\",\\\"actual_weight\\\":\\\"72\\\",\\\"charged_weight\\\":\\\"79\\\",\\\"unit\\\":\\\"kg\\\",\\\"document_no\\\":\\\"Non sed at magni in\\\",\\\"document_name\\\":\\\"Libby Fisher\\\",\\\"document_date\\\":\\\"2007-04-10\\\",\\\"valid_upto\\\":\\\"1988-09-24\\\",\\\"document_file\\\":null}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"MH04GA 0786\\\",\\\"remarks\\\":\\\"Ipsa ipsa accusant\\\",\\\"is_selected\\\":false},{\\\"vehicle_no\\\":\\\"MH04GA 0786\\\",\\\"remarks\\\":\\\"hjhk\\\",\\\"is_selected\\\":false}],\\\"eway_bills\\\":[\\\"781008845838\\\"]}}\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'order', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 07:02:06', '2025-06-17 07:04:26', NULL, NULL, NULL),
(248, 'ORD-1750164016', '\"{\\\"1\\\":{\\\"lr_number\\\":\\\"LR-1750164016-1\\\",\\\"lr_date\\\":\\\"2007-09-16\\\",\\\"vehicle_no\\\":null,\\\"vehicle_type\\\":\\\"6\\\",\\\"vehicle_ownership\\\":\\\"Own\\\",\\\"delivery_mode\\\":\\\"door_delivery\\\",\\\"from_location\\\":\\\"3\\\",\\\"to_location\\\":\\\"2\\\",\\\"consignor_id\\\":\\\"157\\\",\\\"consignor_gst\\\":\\\"804 North First Street\\\",\\\"consignor_loading\\\":\\\"28 South White Milton Avenue\\\",\\\"consignee_id\\\":\\\"156\\\",\\\"consignee_gst\\\":\\\"316 White Milton Lane\\\",\\\"consignee_unloading\\\":\\\"53 Hague Lane\\\",\\\"freightType\\\":\\\"to_be_billed\\\",\\\"freight_amount\\\":null,\\\"lr_charges\\\":null,\\\"hamali\\\":null,\\\"other_charges\\\":null,\\\"gst_amount\\\":null,\\\"total_freight\\\":null,\\\"less_advance\\\":null,\\\"balance_freight\\\":null,\\\"total_declared_value\\\":\\\"80.00\\\",\\\"insurance_description\\\":null,\\\"insurance_status\\\":\\\"no\\\",\\\"order_rate\\\":\\\"0.00\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"80\\\",\\\"package_type\\\":\\\"2\\\",\\\"package_description\\\":\\\"Anim nulla ratione c\\\",\\\"actual_weight\\\":\\\"7\\\",\\\"charged_weight\\\":\\\"44\\\",\\\"document_no\\\":\\\"Minus saepe maiores\\\",\\\"document_name\\\":\\\"Sybil Martinez\\\",\\\"document_date\\\":\\\"2020-11-13\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"80\\\",\\\"valid_upto\\\":\\\"2008-02-17\\\",\\\"unit\\\":\\\"ton\\\"}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"MJUHY6677\\\",\\\"remarks\\\":\\\"Ut quis itaque sint\\\",\\\"is_selected\\\":false}],\\\"eway_bills\\\":[\\\"781008845838\\\",\\\"751008845839\\\",\\\"711008845840\\\",\\\"781008845841\\\",\\\"751008845842\\\",\\\"721008845843\\\"]},\\\"2\\\":{\\\"lr_number\\\":\\\"LR-1750164016-2\\\",\\\"lr_date\\\":\\\"2012-01-13\\\",\\\"vehicle_no\\\":null,\\\"vehicle_type\\\":\\\"5\\\",\\\"vehicle_ownership\\\":\\\"Other\\\",\\\"delivery_mode\\\":\\\"door_delivery\\\",\\\"from_location\\\":\\\"1\\\",\\\"to_location\\\":\\\"4\\\",\\\"consignor_id\\\":\\\"157\\\",\\\"consignor_gst\\\":\\\"804 North First Street\\\",\\\"consignor_loading\\\":\\\"28 South White Milton Avenue\\\",\\\"consignee_id\\\":\\\"157\\\",\\\"consignee_gst\\\":\\\"804 North First Street\\\",\\\"consignee_unloading\\\":\\\"28 South White Milton Avenue\\\",\\\"freightType\\\":\\\"paid\\\",\\\"freight_amount\\\":\\\"0.00\\\",\\\"lr_charges\\\":\\\"38\\\",\\\"hamali\\\":\\\"1\\\",\\\"other_charges\\\":\\\"12\\\",\\\"gst_amount\\\":\\\"6.12\\\",\\\"total_freight\\\":\\\"57.12\\\",\\\"less_advance\\\":\\\"92\\\",\\\"balance_freight\\\":\\\"-34.88\\\",\\\"total_declared_value\\\":\\\"97.00\\\",\\\"insurance_description\\\":null,\\\"insurance_status\\\":\\\"no\\\",\\\"order_rate\\\":\\\"0.00\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"18\\\",\\\"package_type\\\":\\\"2\\\",\\\"package_description\\\":\\\"Officia eligendi sus\\\",\\\"actual_weight\\\":\\\"16\\\",\\\"charged_weight\\\":\\\"100\\\",\\\"document_no\\\":\\\"Non ut obcaecati rep\\\",\\\"document_name\\\":\\\"Brett Barlow\\\",\\\"document_date\\\":\\\"2021-08-06\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"77\\\",\\\"valid_upto\\\":\\\"1978-07-06\\\",\\\"unit\\\":\\\"kg\\\"},{\\\"packages_no\\\":\\\"87\\\",\\\"package_type\\\":\\\"2\\\",\\\"package_description\\\":\\\"Laborum est porro ni\\\",\\\"actual_weight\\\":\\\"78\\\",\\\"charged_weight\\\":\\\"3\\\",\\\"document_no\\\":\\\"Ducimus animi eos\\\",\\\"document_name\\\":\\\"Zena Delaney\\\",\\\"document_date\\\":\\\"1990-10-25\\\",\\\"document_file\\\":null,\\\"declared_value\\\":\\\"20\\\",\\\"valid_upto\\\":\\\"1988-12-10\\\",\\\"unit\\\":\\\"ton\\\"}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"MJUHY6677\\\",\\\"remarks\\\":\\\"Repellendus Obcaeca\\\",\\\"is_selected\\\":false}],\\\"eway_bills\\\":[\\\"751008845839\\\",\\\"711008845840\\\",\\\"781008845841\\\"]}}\"', '\"Processing\"', 'Laboriosam illum i', '1974-07-30', 'export-restoff', NULL, 156, '316 White Milton Lane', '53 Hague Lane', 'contract', '31', NULL, 'Velit illum sit im', 'Et voluptas autem fu', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-17 07:10:16', '2025-06-26 01:37:35', NULL, NULL, NULL),
(249, 'ORD-1751367654', '\"[]\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'order', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-01 05:30:54', '2025-07-01 05:31:36', NULL, NULL, NULL),
(250, 'ORD-1751367689', '\"{\\\"1\\\":{\\\"lr_number\\\":\\\"LR-1751367689-1\\\",\\\"lr_date\\\":\\\"2013-09-14\\\",\\\"vehicle_type\\\":\\\"4\\\",\\\"vehicle_ownership\\\":\\\"Other\\\",\\\"delivery_mode\\\":\\\"godwon_deliver\\\",\\\"from_location\\\":\\\"1\\\",\\\"to_location\\\":\\\"3\\\",\\\"insurance_status\\\":\\\"no\\\",\\\"insurance_description\\\":null,\\\"customer_id\\\":\\\"156\\\",\\\"gst_number\\\":\\\"316 White Milton Lane\\\",\\\"customer_address\\\":\\\"53 Hague Lane, 761 West Oak Extension, 662 East Green First Avenue\\\",\\\"consignor_id\\\":\\\"158\\\",\\\"consignor_gst\\\":\\\"Alias deleniti duis\\\",\\\"consignor_loading\\\":\\\"Officiis recusandae, Anim eum quia quaera, Dolore dolorem nostr\\\",\\\"consignee_id\\\":\\\"160\\\",\\\"consignee_gst\\\":\\\"Doloremque debitis q\\\",\\\"consignee_unloading\\\":\\\"Molestiae quia offic, Sint asperiores nat, Voluptas voluptatibu\\\",\\\"freightType\\\":\\\"to_be_billed\\\",\\\"freight_amount\\\":null,\\\"lr_charges\\\":null,\\\"hamali\\\":null,\\\"other_charges\\\":null,\\\"gst_amount\\\":null,\\\"total_freight\\\":null,\\\"less_advance\\\":null,\\\"balance_freight\\\":null,\\\"total_declared_value\\\":\\\"73\\\",\\\"order_rate\\\":\\\"49\\\",\\\"cargo\\\":[{\\\"packages_no\\\":\\\"88\\\",\\\"package_type\\\":\\\"2\\\",\\\"package_description\\\":\\\"Sequi elit laborum\\\",\\\"declared_value\\\":\\\"73\\\",\\\"actual_weight\\\":\\\"64\\\",\\\"charged_weight\\\":\\\"90\\\",\\\"unit\\\":\\\"kg\\\",\\\"document_no\\\":\\\"Ut repellendus Quid\\\",\\\"document_name\\\":\\\"Willow Castillo\\\",\\\"document_date\\\":\\\"1995-12-20\\\",\\\"valid_upto\\\":\\\"1997-12-25\\\",\\\"document_file\\\":null}],\\\"vehicle\\\":[{\\\"vehicle_no\\\":\\\"JK667QWE\\\",\\\"remarks\\\":\\\"Vel enim pariatur A\\\",\\\"is_selected\\\":true}]}}\"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'order', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-01 05:31:29', '2025-07-01 06:13:30', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `package_type`, `created_at`, `updated_at`) VALUES
(2, 'Luna Alvarez Trading', '2025-04-17 03:57:55', '2025-04-17 03:57:55'),
(4, 'Jacobson Watson Trading', '2025-04-17 03:58:12', '2025-04-17 03:58:12'),
(5, 'Ware Calderon Plc', '2025-04-17 03:58:19', '2025-04-17 03:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage dashboard', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(2, 'create order_booking', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(3, 'edit order_booking', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(4, 'delete order_booking', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(5, 'view order_booking', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(6, 'manage order_booking', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(7, 'create lr_consignment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(8, 'edit lr_consignment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(9, 'delete lr_consignment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(10, 'view lr_consignment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(11, 'manage lr_consignment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(12, 'create freight_bill', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(13, 'edit freight_bill', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(14, 'delete freight_bill', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(15, 'view freight_bill', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(16, 'manage freight_bill', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(17, 'create vehicles', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(18, 'edit vehicles', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(19, 'delete vehicles', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(20, 'view vehicles', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(21, 'manage vehicles', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(22, 'create maintenance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(23, 'edit maintenance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(24, 'delete maintenance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(25, 'view maintenance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(26, 'manage maintenance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(27, 'create tyres', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(28, 'edit tyres', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(29, 'delete tyres', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(30, 'view tyres', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(31, 'manage tyres', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(32, 'create task_managment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(33, 'edit task_managment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(34, 'delete task_managment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(35, 'view task_managment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(36, 'manage task_managment', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(37, 'create employees', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(38, 'edit employees', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(39, 'delete employees', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(40, 'view employees', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(41, 'manage employees', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(42, 'create drivers', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(43, 'edit drivers', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(44, 'delete drivers', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(45, 'view drivers', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(46, 'manage drivers', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(47, 'create attendance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(48, 'manage attendance', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(49, 'create payroll', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(50, 'edit payroll', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(51, 'delete payroll', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(52, 'view payroll', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(53, 'manage payroll', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(54, 'create customer', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(55, 'edit customer', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(56, 'delete customer', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(57, 'view customer', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(58, 'manage customer', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(59, 'create package_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(60, 'edit package_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(61, 'delete package_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(62, 'view package_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(63, 'manage package_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(64, 'create destination', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(65, 'edit destination', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(66, 'delete destination', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(67, 'view destination', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(68, 'manage destination', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(69, 'create contract', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(70, 'edit contract', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(71, 'delete contract', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(72, 'view contract', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(73, 'manage contract', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(74, 'create vehicle_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(75, 'edit vehicle_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(76, 'delete vehicle_type', 'web', '2025-05-04 03:02:17', '2025-05-04 03:02:17'),
(77, 'view vehicle_type', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(78, 'manage vehicle_type', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(79, 'create warehouse', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(80, 'edit warehouse', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(81, 'delete warehouse', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(82, 'view warehouse', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(83, 'manage warehouse', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(84, 'edit stock_transfer', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(85, 'delete stock_transfer', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(86, 'view stock_transfer', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(87, 'manage stock_transfer', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(88, 'create permissions', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(89, 'edit permissions', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(90, 'delete permissions', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(91, 'view permissions', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(92, 'manage permissions', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(93, 'create role', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(94, 'edit role', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(95, 'delete role', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(96, 'view role', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(97, 'manage role', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(98, 'create settings', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(99, 'edit settings', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(100, 'delete settings', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(101, 'view settings', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(102, 'manage settings', 'web', '2025-05-04 03:02:18', '2025-05-04 03:02:18'),
(103, 'create stock_transfer', 'web', '2025-05-04 06:46:22', '2025-05-04 06:46:22'),
(104, 'create payout', 'web', '2025-05-04 08:02:01', '2025-05-04 08:02:01'),
(105, 'edit payout', 'web', '2025-05-04 08:02:01', '2025-05-04 08:02:01'),
(106, 'delete payout', 'web', '2025-05-04 08:02:01', '2025-05-04 08:02:01'),
(107, 'view payout', 'web', '2025-05-04 08:02:01', '2025-05-04 08:02:01'),
(108, 'manage payout', 'web', '2025-05-04 08:02:01', '2025-05-04 08:02:01'),
(109, 'create users', 'web', '2025-05-05 08:03:09', '2025-05-05 08:03:09'),
(110, 'edit users', 'web', '2025-05-05 08:03:09', '2025-05-05 08:03:09'),
(111, 'delete users', 'web', '2025-05-05 08:03:09', '2025-05-05 08:03:09'),
(112, 'view users', 'web', '2025-05-05 08:03:10', '2025-05-05 08:03:10'),
(113, 'manage users', 'web', '2025-05-05 08:03:10', '2025-05-05 08:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(26, 'App\\Models\\User', 55, 'auth_token', 'ff8ad9f4d103a6a06baeb2484df685505c7dc90a6077a95d7caff639633fe411', '[\"*\"]', '2025-03-24 05:37:44', NULL, '2025-03-22 01:55:06', '2025-03-24 05:37:44'),
(27, 'App\\Models\\User', 56, 'auth_token', '5c4275012cb91a3d5ac0ae975744954e6f1f42f25565d869f77bbfd4042bc494', '[\"*\"]', '2025-03-24 08:42:04', NULL, '2025-03-24 05:03:45', '2025-03-24 08:42:04'),
(28, 'App\\Models\\Admin', 8, 'admin-token', '9278964a1dd72a6a3d57c50eac3fbb839a6aebce8a1ae0e9aac912babfc056f4', '[\"*\"]', NULL, NULL, '2025-05-08 00:53:08', '2025-05-08 00:53:08'),
(29, 'App\\Models\\Admin', 8, 'admin-token', '4ec4a213a3198da494c2e26ef2aca1cc6ebb7b0085c0743eb67bca342344d2fa', '[\"*\"]', '2025-05-08 02:35:24', NULL, '2025-05-08 01:19:40', '2025-05-08 02:35:24'),
(30, 'App\\Models\\Admin', 8, 'admin-token', '10dae4c35d3acaa699b696538bb3512de36db402461ebe5ca59860dfaf74aa7c', '[\"*\"]', NULL, NULL, '2025-05-09 05:14:01', '2025-05-09 05:14:01'),
(31, 'App\\Models\\Admin', 8, 'admin-token', '264aad9b72121ad57f038a1411ea6811e8eeccc1202ce98bde6d6487bcecf9bb', '[\"*\"]', NULL, NULL, '2025-05-09 06:59:44', '2025-05-09 06:59:44'),
(32, 'App\\Models\\Admin', 8, 'admin-token', '0cdf82e62bb0225c7723786dd16096bdac02e97778d60c3db6af125d1e878f43', '[\"*\"]', NULL, NULL, '2025-05-09 07:00:28', '2025-05-09 07:00:28'),
(33, 'App\\Models\\Admin', 8, 'admin-token', '54167c5f3c24fb0f4d55f2ec9dd4e590ce1b5276f5f57d8bdab7893b5b62b6d0', '[\"*\"]', '2025-05-14 04:38:03', NULL, '2025-05-14 04:37:07', '2025-05-14 04:38:03'),
(34, 'App\\Models\\Admin', 8, 'admin-token', '999fc8ef05da93acf968938491289c213e887cdf9ccefd637c658645e658009e', '[\"*\"]', NULL, '2027-05-14 06:49:40', '2025-05-14 06:49:40', '2025-05-14 06:49:40'),
(35, 'App\\Models\\User', 147, 'api_token', 'b06045fbb9180e8b368f451d5f6e1e1f27234a4063fcd4a4f84a3fd338cb8309', '[\"*\"]', '2025-06-03 13:56:19', NULL, '2025-06-03 13:55:33', '2025-06-03 13:56:19'),
(36, 'App\\Models\\User', 148, 'api_token', 'd0ba587f6d4c72e3e08636d1ae0c189bc1f59cb00f12f07b522bf041d7ddbecf', '[\"*\"]', '2025-06-04 05:29:59', NULL, '2025-06-04 05:28:39', '2025-06-04 05:29:59'),
(37, 'App\\Models\\User', 148, 'api_token', 'f7d0e593b3eb3650e7fcf5fc4abb49b8e9d711ef6d9d51df5d8bd07600b32ddf', '[\"*\"]', NULL, NULL, '2025-06-04 05:37:21', '2025-06-04 05:37:21'),
(38, 'App\\Models\\User', 148, 'api_token', 'bc35aef3eb11f64d43f60ea31d1a401f35d513b362dde5eb597b226fb501a6e4', '[\"*\"]', NULL, NULL, '2025-06-04 05:40:34', '2025-06-04 05:40:34'),
(39, 'App\\Models\\User', 148, 'api_token', 'e2b759cdd9e89f7b1d9683403c8136c862eac4d07205c9e5245532bc253eaf5e', '[\"*\"]', '2025-06-04 05:49:46', NULL, '2025-06-04 05:40:36', '2025-06-04 05:49:46'),
(40, 'App\\Models\\User', 151, 'api_token', '1c8c2fb58fc418063f1e5fab3167ed12d9ec420c13a6dc5cd2f45ea95ad5838f', '[\"*\"]', '2025-06-04 06:18:27', NULL, '2025-06-04 06:10:27', '2025-06-04 06:18:27'),
(41, 'App\\Models\\User', 151, 'api_token', 'ce78956af993e27e6c3bcd18ec831de35a95eab74f57506c7d5e434cba99a65f', '[\"*\"]', '2025-06-04 06:32:28', NULL, '2025-06-04 06:20:02', '2025-06-04 06:32:28'),
(42, 'App\\Models\\User', 151, 'api_token', '3829b2e466535eac5c12212f52588451d5a60afa3b2e5501691acbcd41a845a9', '[\"*\"]', '2025-06-04 09:55:55', NULL, '2025-06-04 06:26:31', '2025-06-04 09:55:55'),
(43, 'App\\Models\\User', 151, 'api_token', 'a7977b2e9c5b3b435dacae4a4eb76b7d895e6939774e4abb2668cb1a99fe17eb', '[\"*\"]', '2025-06-04 10:54:24', NULL, '2025-06-04 06:38:44', '2025-06-04 10:54:24'),
(44, 'App\\Models\\User', 151, 'api_token', '99016a8cef4a905468d5325838823b56d7cd89981ebb032d01c44794e5b86daf', '[\"*\"]', '2025-06-04 06:47:43', NULL, '2025-06-04 06:47:25', '2025-06-04 06:47:43'),
(45, 'App\\Models\\User', 151, 'api_token', '6ca12a41bfdd534b06b35d618dd6dd94499ce29d7ff7a6ab48e51c5d3d274208', '[\"*\"]', '2025-06-05 05:55:28', NULL, '2025-06-04 09:56:40', '2025-06-05 05:55:28'),
(46, 'App\\Models\\User', 151, 'api_token', 'b4a804a6e126fcbb41a6febae72388a9d314da2d00a25ab474e00a12e522510d', '[\"*\"]', '2025-06-05 12:23:31', NULL, '2025-06-05 05:29:53', '2025-06-05 12:23:31'),
(47, 'App\\Models\\User', 151, 'api_token', '66eb8b02695f51f191257ccc5d149f43e7325afa1344a2e75c2f681994596ac2', '[\"*\"]', '2025-06-05 06:00:53', NULL, '2025-06-05 05:58:20', '2025-06-05 06:00:53'),
(48, 'App\\Models\\User', 151, 'api_token', '9ccd457aeed605ed04b1858a6346d0ea833fd43fad7ea7c0aab0dc7734e70dac', '[\"*\"]', '2025-06-05 06:05:38', NULL, '2025-06-05 06:05:30', '2025-06-05 06:05:38'),
(49, 'App\\Models\\User', 151, 'api_token', 'aebea9bcc8e3c11516050976af0487b02613cbc25a105713a381e8dfd0ad3aa1', '[\"*\"]', '2025-06-05 06:21:04', NULL, '2025-06-05 06:20:50', '2025-06-05 06:21:04'),
(50, 'App\\Models\\User', 151, 'api_token', '040e4fdfebca0f09697221d5e069d2688ce41625a6bb7ac9fd83a99ca08c79f4', '[\"*\"]', '2025-06-05 06:24:10', NULL, '2025-06-05 06:23:55', '2025-06-05 06:24:10'),
(51, 'App\\Models\\User', 151, 'api_token', 'd7079097b928144b302643f295a4f936dcdc6076429fbb67b13707a95db1fd33', '[\"*\"]', '2025-06-05 06:27:18', NULL, '2025-06-05 06:27:11', '2025-06-05 06:27:18'),
(52, 'App\\Models\\User', 151, 'api_token', '7ca50a8659b54a9447863366d3d2f17aa8a24f6312fb44b494ea2e084cacf854', '[\"*\"]', '2025-06-05 06:38:39', NULL, '2025-06-05 06:38:32', '2025-06-05 06:38:39'),
(53, 'App\\Models\\User', 151, 'api_token', 'bd7052f48a5c243da27691a27f2772b0c9877afdfb56f4af7a4b4dff32c80267', '[\"*\"]', '2025-06-05 07:46:06', NULL, '2025-06-05 06:42:19', '2025-06-05 07:46:06'),
(54, 'App\\Models\\User', 151, 'api_token', '55434c2ad9179c416e0aa7e1ab64f29ed0d9ab08b8f66246d96c37b438d0b595', '[\"*\"]', '2025-06-05 13:55:03', NULL, '2025-06-05 06:54:50', '2025-06-05 13:55:03'),
(55, 'App\\Models\\User', 151, 'api_token', 'e3e96c6913184cf1ca4b12610f1f24ca33e5bc8581d5b6dc37b93d01fcd37187', '[\"*\"]', NULL, NULL, '2025-06-05 07:47:50', '2025-06-05 07:47:50'),
(56, 'App\\Models\\User', 151, 'api_token', 'e0778ba27ce4f49eac26f25c2164ce612051f95ce315009c960a2d1280318082', '[\"*\"]', NULL, NULL, '2025-06-05 07:52:06', '2025-06-05 07:52:06'),
(57, 'App\\Models\\User', 151, 'api_token', '524bba80137bfbeca682e803ed5cc04d638d330cb53be6f25b20a05b915bc9a9', '[\"*\"]', '2025-06-05 08:33:03', NULL, '2025-06-05 07:56:15', '2025-06-05 08:33:03'),
(58, 'App\\Models\\User', 151, 'api_token', 'fdb08c2231068403ce7dbf91008c0bbb71c9d58fa6303f79137b4d2829a7abfe', '[\"*\"]', '2025-06-05 09:29:45', NULL, '2025-06-05 08:00:16', '2025-06-05 09:29:45'),
(59, 'App\\Models\\User', 151, 'api_token', '3754894d6aaca415070b40d5a1fec8be3343d520b8fd355780566f46893d5458', '[\"*\"]', '2025-06-05 10:20:28', NULL, '2025-06-05 09:29:18', '2025-06-05 10:20:28'),
(60, 'App\\Models\\User', 151, 'api_token', '848b44eeb5de9f1fc31ce0cd5a152ed776ab0f243af1c6d59fb7ab10c177e4e7', '[\"*\"]', '2025-06-05 11:36:23', NULL, '2025-06-05 10:13:40', '2025-06-05 11:36:23'),
(61, 'App\\Models\\User', 151, 'api_token', '2621d8ce97753a10686a46985cc5ae258778c57815e0cd54cadae700cee5acb4', '[\"*\"]', '2025-06-05 12:37:16', NULL, '2025-06-05 10:22:35', '2025-06-05 12:37:16'),
(62, 'App\\Models\\User', 151, 'api_token', '8b16e63ff6d59f4ae6b8e4b85a7745c36b689cb5b3d0c79139b66de199c3fb19', '[\"*\"]', '2025-06-05 12:56:21', NULL, '2025-06-05 11:37:44', '2025-06-05 12:56:21'),
(63, 'App\\Models\\User', 151, 'api_token', 'cc92eebf18663c5f1f9958a2d6c91a0d0192e27b2de23cfb023f015e88771722', '[\"*\"]', '2025-06-05 12:57:42', NULL, '2025-06-05 12:55:43', '2025-06-05 12:57:42'),
(64, 'App\\Models\\User', 151, 'api_token', '630def5a89a7a18d8ea20bc4fb6dfb5614102838f1908ce32a9b5706b89ee745', '[\"*\"]', '2025-06-05 13:03:28', NULL, '2025-06-05 12:58:00', '2025-06-05 13:03:28'),
(65, 'App\\Models\\User', 151, 'api_token', '60f348bcbf8c3ceaae1a5aacf5c19db1aa017543fe3be9245be2060d6b776051', '[\"*\"]', '2025-06-05 13:07:13', NULL, '2025-06-05 13:05:05', '2025-06-05 13:07:13'),
(66, 'App\\Models\\User', 154, 'api_token', 'ff9197d2ab25dc3ead7e531c4531eef165bf29d0f8565e345af9daff516a81b4', '[\"*\"]', '2025-06-06 13:58:00', NULL, '2025-06-06 13:36:49', '2025-06-06 13:58:00'),
(67, 'App\\Models\\User', 153, 'api_token', '750b2f3377706e6787e89e5cacafb650b977b383ad741708a0f36794b7bb997d', '[\"*\"]', '2025-06-07 13:22:32', NULL, '2025-06-06 13:56:40', '2025-06-07 13:22:32'),
(68, 'App\\Models\\User', 154, 'api_token', '918886b685016bfeafe2b5867a7005ef4e1cbe48b1620e9ca1ef854af801b0ad', '[\"*\"]', '2025-06-07 12:49:16', NULL, '2025-06-06 13:58:26', '2025-06-07 12:49:16'),
(69, 'App\\Models\\User', 153, 'api_token', '57b72dae157a7dbe08abeeecf209fea678f19b5dbeef3d559295ff66ec67105a', '[\"*\"]', '2025-06-07 05:42:14', NULL, '2025-06-07 05:41:37', '2025-06-07 05:42:14'),
(70, 'App\\Models\\User', 153, 'api_token', 'baf8537eb3cd8dca5cbc5fb6951af7443a13c32265eefba5c72803772193bb41', '[\"*\"]', '2025-06-07 13:45:05', NULL, '2025-06-07 05:51:13', '2025-06-07 13:45:05'),
(71, 'App\\Models\\User', 154, 'api_token', '810f1fbf4280a9b292318a7a4333f71bc2965ff747a28325f5fc794803a76ef4', '[\"*\"]', '2025-06-07 12:57:38', NULL, '2025-06-07 12:49:51', '2025-06-07 12:57:38'),
(72, 'App\\Models\\User', 154, 'api_token', '57c747cfccca0ec981ec44ad7c8114f27e6d4c50b6b838d9dfeae0f9a77207ca', '[\"*\"]', '2025-06-07 13:49:29', NULL, '2025-06-07 12:57:55', '2025-06-07 13:49:29'),
(73, 'App\\Models\\User', 154, 'api_token', 'cdb04905750af08a035a16066d4e86bf7ed64f908d025d20e30348533c039b2a', '[\"*\"]', '2025-06-07 13:50:09', NULL, '2025-06-07 13:03:12', '2025-06-07 13:50:09'),
(74, 'App\\Models\\User', 154, 'api_token', 'b0f2a5efc1a318fb013039994ddb4f58c37adcd6b49ff2fd030e863c9087e3a1', '[\"*\"]', '2025-06-07 14:07:45', NULL, '2025-06-07 13:50:28', '2025-06-07 14:07:45'),
(75, 'App\\Models\\User', 154, 'api_token', '867379d28c19c1b33b3ea1842f1328d18e452b641620319f6786241b85ba120f', '[\"*\"]', '2025-06-07 13:55:04', NULL, '2025-06-07 13:53:40', '2025-06-07 13:55:04'),
(76, 'App\\Models\\User', 154, 'api_token', '47dd1eac4ba9efc2ca432838c9555cc9ba45ef472195703c5b2fce48860e80e8', '[\"*\"]', '2025-06-07 13:59:56', NULL, '2025-06-07 13:57:33', '2025-06-07 13:59:56'),
(77, 'App\\Models\\User', 154, 'api_token', 'c5ea2627be250b4044fdc4a8fcda4784532648c066b401238f452f45c081c154', '[\"*\"]', '2025-06-09 05:09:31', NULL, '2025-06-07 14:01:34', '2025-06-09 05:09:31'),
(78, 'App\\Models\\User', 154, 'api_token', 'ad4a5a3d867c12024d4936ebce826eb797b205ceb734e27e19396f3ec3fd6b60', '[\"*\"]', '2025-06-09 05:23:13', NULL, '2025-06-09 05:05:42', '2025-06-09 05:23:13'),
(79, 'App\\Models\\User', 154, 'api_token', '7958513def0b3c71b876f5b42e855a4a8c5bbb5a07bf4a9474e8004ffab56e51', '[\"*\"]', '2025-06-09 05:26:54', NULL, '2025-06-09 05:14:09', '2025-06-09 05:26:54'),
(80, 'App\\Models\\User', 154, 'api_token', 'bfcd260b097666cc5910709755595ce278ad14e182bbf471f85238cca648c1da', '[\"*\"]', '2025-06-09 05:46:56', NULL, '2025-06-09 05:33:39', '2025-06-09 05:46:56'),
(81, 'App\\Models\\User', 154, 'api_token', '09eea54bea9cbfbfc5576440fce4cbbc4d5fa28f303f1d21e305e85e93cd9eda', '[\"*\"]', '2025-06-09 05:55:31', NULL, '2025-06-09 05:47:28', '2025-06-09 05:55:31'),
(82, 'App\\Models\\User', 154, 'api_token', '374dec2d3deede1c56e9eb1c3cc4a039ce799f4fa8e5ef0817a7909399d1d27f', '[\"*\"]', '2025-06-18 06:14:07', NULL, '2025-06-09 05:56:06', '2025-06-18 06:14:07'),
(83, 'App\\Models\\User', 154, 'api_token', '8e07aad3b4dca84a0af8970109e21260430458aa01e29e1d478c9883efba6710', '[\"*\"]', '2025-06-18 06:23:00', NULL, '2025-06-18 06:14:42', '2025-06-18 06:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcategory_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `category_id`, `price`, `description`, `created_at`, `updated_at`, `user_id`, `quantity`, `subcategory_id`) VALUES
(1, 'products/e2ZTTmrXJCkh725F9vmzvz9i66b0bGYwal3J3qwh.png', 'Organic Apples', NULL, '120', 'Fresh organic apples directly from farms.', '2025-03-07 06:15:57', '2025-03-10 13:13:34', NULL, '8', '7'),
(2, 'products/pYpYtQLE2iXF6rednH12cfoXX9IX1vAvBowfgsNv.png', 'Farm Fresh Tomatoes', '29', '50', 'Hand-picked fresh tomatoes, pesticide-free.', '2025-03-07 06:30:16', '2025-03-10 12:16:48', '18', '10', '9');

-- --------------------------------------------------------

--
-- Table structure for table `product_listings`
--

CREATE TABLE `product_listings` (
  `id` int(11) NOT NULL,
  `subcategory_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selling_rate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_listings`
--

INSERT INTO `product_listings` (`id`, `subcategory_id`, `quantity`, `selling_rate`, `per_unit`, `image`, `unit`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '7', '5', '20', '10', 'products/FpSUZgDBfajUxBGp4gQohvphIvRTwWEEZtP89jps.png', NULL, '2025-03-11 06:07:43', '2025-03-11 06:07:43', NULL),
(2, '7', '5', '20', '10', 'products/KCskaHya1g9YFHBQadh0mYjJJ0PhHtNDeIVoPdyr.png', NULL, '2025-03-11 06:09:06', '2025-03-11 06:09:06', NULL),
(3, '7', '5', '20', '10', NULL, NULL, '2025-03-11 07:05:06', '2025-03-11 07:05:06', NULL),
(4, '7', '5', '20', '10', 'products/kjQdsfUSVH684RQpIv8r7wKoIOXLFK3MixlA3nwC.png', NULL, '2025-03-11 07:05:22', '2025-03-11 07:05:22', NULL),
(5, '7', '5', '20', '10', NULL, NULL, '2025-03-15 10:36:12', '2025-03-15 10:36:12', NULL),
(6, '7', '5', '20', '10', NULL, NULL, '2025-03-17 01:05:16', '2025-03-17 01:05:16', NULL),
(7, '7', '5', '200', '10', NULL, NULL, '2025-03-17 02:10:45', '2025-03-17 02:10:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_sells`
--

CREATE TABLE `product_sells` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_featured` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sells`
--

INSERT INTO `product_sells` (`id`, `product_name`, `quantity`, `price`, `user_id`, `description`, `image`, `created_at`, `updated_at`, `is_featured`) VALUES
(1, 'sd', '1', '100', NULL, 'Fresh organic apples directly from farms.', 'products/oQ3sXYFhEPvWaoQ0ZjZpF6MntHE8LyXegdXv85YE.png', NULL, '2025-03-13 00:41:48', '1'),
(2, 'dfsd', '2', '100', NULL, 'tsdf,sdnf', 'products/ExaRsTsqJLfqfqMCWHZrMH8jCVHfW92X9ksR4Ewb.png', '2025-03-11 02:04:26', '2025-03-11 02:04:26', '1'),
(3, 'sds', '1', '120', NULL, 'Fresh organic apples directly from farms.', 'products/yPO0saF9BGIRCuqMhHK0Fvbj1wjy2ELaUTnvZvFu.png', '2025-03-11 02:10:16', '2025-03-13 00:42:58', '1'),
(4, 'Organic Apples', '1', '120', NULL, 'Fresh organic apples directly from farms.', 'products/C6M3Rm2gvko0VCzPbU2nCJe6kMn34xeqEgvSOWNC.png', '2025-03-11 02:10:52', '2025-03-11 02:10:52', '1'),
(6, 'sd', '1', '1000', NULL, 'Fresh organic apples.', 'products/1iGX0q6FWPw6gtyMBiFh2kNoVFLChpFDPpn4tPjy.png', '2025-03-13 00:36:00', '2025-03-13 00:42:27', '1'),
(7, 'Organic Corn lemon', '2', '200', '38', 'Fresh organic apples directly from farms lemon.', 'products/QZHz3tnDD6ffjw1M0rOe0gHDD5VGQ5uCMngG91Ud.png', '2025-03-13 00:43:23', '2025-03-17 07:07:04', '1'),
(8, 'ghjg', '1', '1000', NULL, 'Fresh organic apples.', 'products/8qviNIN12OIe9vLIh8Cw6Xftu3FnQ6s3vSiW7DyG.png', '2025-03-15 10:34:27', '2025-03-15 11:14:40', '1'),
(14, 'Farm Fresh Tomatoes', '1', '1000', NULL, 'Fresh organic applesjh', 'products/Nglir80fnAsarYegpeSnwFxlVjV9yMEZbSMITDpE.png', '2025-03-17 06:43:32', '2025-03-17 06:43:32', '1'),
(15, 'Farm Fresh Tomatoes', '1', '1000', NULL, 'Fresh organic applesjh', 'products/RKTcs1bq6z7vkYkP2uaf7bFbPvWnGFAPM5uUx8NZ.png', '2025-03-17 06:44:47', '2025-03-17 06:44:47', '1'),
(16, 'jh', '1', '1000', '40', 'Fresh organic applesjh', 'products/k3dTJerA7jUzdjDIRfD35L0xTKudEgCZeUHMpIkE.png', '2025-03-17 06:44:51', '2025-03-17 06:47:38', '1'),
(18, 'Farm Fresh Tomatoes', '1', '1000', '39', 'Fresh organic applesjh', 'products/VITxslaRpbzpDqVQnFHdonY4ivTqbsYiadL6XYqO.png', '2025-03-17 06:48:51', '2025-03-17 06:48:51', '1'),
(19, 'Farm Fresh lemon', '2', '100', '38', 'Fresh organic applesjh', 'products/oFskbh09AOiGAVNsPcGckYndNliCEfywE058WLdj.png', '2025-03-17 07:03:33', '2025-03-17 07:03:33', '1'),
(20, 'Farm Fresh lemon', '2', '100', '38', 'Fresh organic applesjh', 'products/dKYZe7NLA1NKlqwAAe4JxSfyaOp3TLubVjMAF444.png', '2025-03-17 07:05:27', '2025-03-17 07:05:27', '1');

-- --------------------------------------------------------

--
-- Table structure for table `redeems`
--

CREATE TABLE `redeems` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `redeem_product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `coins_used` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `redeem_products`
--

CREATE TABLE `redeem_products` (
  `id` int(11) NOT NULL,
  `redeem_product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redeem_product_coins` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redeem_product_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redeem_product_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redeem_products`
--

INSERT INTO `redeem_products` (`id`, `redeem_product_name`, `redeem_product_coins`, `redeem_product_image`, `redeem_product_description`, `created_at`, `updated_at`, `user_id`) VALUES
(6, 'Natural Honey', '200', 'products/qf5r9klhnMOmQG8FJbHq0CGVzZ1X6z7yAD63bFy2.png', 'redeem descripion palak', '2025-03-12 06:04:25', '2025-03-12 06:04:25', NULL),
(7, 'Rice', '100', 'products/yXheJvEUiTUelMu4RAqgKox4NbtAgxFvCMiYrGpD.png', 'redeem descripion rice', '2025-03-12 06:05:38', '2025-03-12 06:05:38', NULL),
(8, 'green Gobi', '100', 'products/cS815cBT1q0CkRndcxxsfHTuvLtIWSwoT9PjO3D3.png', 'redeem descripion rice', '2025-03-15 10:37:55', '2025-03-17 01:01:46', NULL),
(9, 'Rice', '100', 'products/D42t9ibUOHZULxt5pyZvppfLCJc4CwHhK7vJDSIT.png', 'redeem descripion rice', '2025-03-15 10:40:13', '2025-03-17 00:59:25', NULL),
(12, 'Natural gobi', '100', 'products/LevKw4StyGRernouuWAWKzx6kn7LztYjB3l5VVUv.png', 'gobi', '2025-03-17 01:01:21', '2025-03-17 01:01:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refer_earn`
--

CREATE TABLE `refer_earn` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `referred_user_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `reward_points` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refer_earn`
--

INSERT INTO `refer_earn` (`id`, `user_id`, `referred_user_id`, `subcategory_id`, `reward_points`, `created_at`, `updated_at`) VALUES
(1, 18, 20, 9, 100, '2025-03-12 02:05:50', '2025-03-12 02:05:50'),
(2, 20, 20, 8, 100, '2025-03-12 02:31:41', '2025-03-12 02:31:41'),
(3, 20, 20, 8, 100, '2025-03-12 02:33:15', '2025-03-12 02:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'hr', 'web', '2025-05-04 06:29:53', '2025-05-05 01:01:16'),
(7, 'admin', 'web', '2025-05-04 06:53:25', '2025-05-04 06:53:25'),
(11, 'kartik', 'web', '2025-05-07 08:35:02', '2025-05-07 08:35:02'),
(12, 'employee', 'web', '2025-05-22 08:09:37', '2025-05-22 08:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 5),
(1, 7),
(1, 11),
(1, 12),
(2, 5),
(2, 7),
(2, 12),
(3, 5),
(3, 7),
(3, 12),
(4, 5),
(4, 7),
(4, 12),
(5, 5),
(5, 7),
(5, 12),
(6, 5),
(6, 7),
(6, 12),
(7, 5),
(7, 7),
(7, 11),
(7, 12),
(8, 5),
(8, 7),
(8, 11),
(8, 12),
(9, 5),
(9, 7),
(9, 11),
(9, 12),
(10, 5),
(10, 7),
(10, 11),
(10, 12),
(11, 5),
(11, 7),
(11, 11),
(11, 12),
(12, 5),
(12, 7),
(12, 12),
(13, 5),
(13, 7),
(13, 12),
(14, 5),
(14, 7),
(14, 12),
(15, 5),
(15, 7),
(15, 12),
(16, 5),
(16, 7),
(16, 12),
(17, 5),
(17, 7),
(17, 11),
(17, 12),
(18, 5),
(18, 7),
(18, 11),
(18, 12),
(19, 5),
(19, 7),
(19, 12),
(20, 5),
(20, 7),
(20, 12),
(21, 5),
(21, 7),
(21, 11),
(21, 12),
(22, 5),
(22, 7),
(22, 12),
(23, 5),
(23, 7),
(23, 12),
(24, 5),
(24, 7),
(24, 12),
(25, 5),
(25, 7),
(25, 12),
(26, 5),
(26, 7),
(26, 12),
(27, 5),
(27, 7),
(27, 11),
(27, 12),
(28, 5),
(28, 7),
(28, 11),
(28, 12),
(29, 5),
(29, 7),
(29, 11),
(29, 12),
(30, 5),
(30, 7),
(30, 11),
(30, 12),
(31, 5),
(31, 7),
(31, 11),
(31, 12),
(32, 5),
(32, 7),
(32, 12),
(33, 5),
(33, 7),
(33, 12),
(34, 5),
(34, 7),
(34, 12),
(35, 5),
(35, 7),
(35, 12),
(36, 5),
(36, 7),
(36, 12),
(37, 5),
(37, 7),
(37, 11),
(37, 12),
(38, 5),
(38, 7),
(38, 12),
(39, 5),
(39, 7),
(39, 12),
(40, 5),
(40, 7),
(40, 12),
(41, 5),
(41, 7),
(41, 11),
(41, 12),
(42, 5),
(42, 7),
(42, 12),
(43, 5),
(43, 7),
(43, 12),
(44, 5),
(44, 7),
(44, 12),
(45, 5),
(45, 7),
(45, 12),
(46, 5),
(46, 7),
(46, 12),
(47, 5),
(47, 7),
(47, 12),
(48, 5),
(48, 7),
(48, 12),
(49, 5),
(49, 7),
(49, 12),
(50, 5),
(50, 7),
(50, 12),
(51, 5),
(51, 7),
(51, 12),
(52, 5),
(52, 7),
(52, 12),
(53, 5),
(53, 7),
(53, 12),
(54, 5),
(54, 7),
(54, 12),
(55, 5),
(55, 7),
(55, 12),
(56, 5),
(56, 7),
(56, 12),
(57, 5),
(57, 7),
(57, 12),
(58, 5),
(58, 7),
(58, 12),
(59, 5),
(59, 7),
(59, 12),
(60, 5),
(60, 7),
(60, 12),
(61, 5),
(61, 7),
(61, 12),
(62, 5),
(62, 7),
(62, 12),
(63, 5),
(63, 7),
(63, 12),
(64, 5),
(64, 7),
(64, 12),
(65, 5),
(65, 7),
(65, 12),
(66, 5),
(66, 7),
(66, 12),
(67, 5),
(67, 7),
(67, 12),
(68, 5),
(68, 7),
(68, 12),
(69, 5),
(69, 7),
(69, 12),
(70, 5),
(70, 7),
(70, 12),
(71, 5),
(71, 7),
(71, 12),
(72, 5),
(72, 7),
(72, 12),
(73, 5),
(73, 7),
(73, 12),
(74, 5),
(74, 7),
(74, 12),
(75, 5),
(75, 7),
(75, 12),
(76, 5),
(76, 7),
(76, 12),
(77, 5),
(77, 7),
(77, 12),
(78, 5),
(78, 7),
(78, 12),
(79, 5),
(79, 7),
(79, 12),
(80, 5),
(80, 7),
(80, 12),
(81, 5),
(81, 7),
(81, 12),
(82, 5),
(82, 7),
(82, 12),
(83, 5),
(83, 7),
(83, 12),
(84, 5),
(84, 7),
(84, 12),
(85, 5),
(85, 7),
(85, 12),
(86, 5),
(86, 7),
(86, 12),
(87, 5),
(87, 7),
(87, 12),
(88, 5),
(88, 7),
(88, 12),
(89, 5),
(89, 7),
(89, 12),
(90, 5),
(90, 7),
(90, 12),
(91, 5),
(91, 7),
(91, 12),
(92, 5),
(92, 7),
(92, 12),
(93, 5),
(93, 7),
(93, 12),
(94, 5),
(94, 7),
(94, 12),
(95, 5),
(95, 7),
(95, 12),
(96, 5),
(96, 7),
(96, 12),
(97, 5),
(97, 7),
(97, 12),
(98, 5),
(98, 7),
(98, 12),
(99, 5),
(99, 7),
(99, 12),
(100, 5),
(100, 7),
(100, 12),
(101, 5),
(101, 7),
(101, 12),
(102, 5),
(102, 7),
(102, 12),
(103, 5),
(103, 7),
(103, 12),
(104, 5),
(104, 7),
(104, 12),
(105, 5),
(105, 7),
(105, 12),
(106, 5),
(106, 7),
(106, 12),
(107, 5),
(107, 7),
(107, 12),
(108, 5),
(108, 7),
(108, 12),
(109, 5),
(109, 7),
(109, 12),
(110, 5),
(110, 7),
(110, 12),
(111, 5),
(111, 7),
(111, 12),
(112, 5),
(112, 7),
(112, 12),
(113, 5),
(113, 7),
(113, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('n481xlqFtSDbAvbLWnAckV3joytTfH09s98LMOSO', NULL, '3.81.52.119', 'Lynx/2.8.7dev.4 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.8d', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkV6U3d0M0YxQTBITk5iN1NkOGxRanhJOEE1OWd2RE9yeERXMGNITiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749220006),
('PYPR9Bo88MWP2zokYz7xsKr7g7n5Q84J3wYKfH6O', NULL, '34.219.131.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzFKUjh1MkJlTDA0RHRjcnd2RkJtZk5CSkFNcjNnSmFqWG5zd2dzaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749221206),
('cCGoSbzklfrTjfxl9RYzZ5s0jDpLWfW75Yur9Re8', NULL, '2001:bc8:1201:2c:569f:35ff:fe15:f7b8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnVnNDRWanBBajZtY242RXZnQW55ZmVUbkpLZTFBZ0ZwOUMwOEJNYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749212937),
('80GuXH9UkeYaygSqSNBgzkw0a0CCoVi3mvQE4C3z', NULL, '139.59.27.96', 'Mozilla/5.0 (X11; Linux x86_64; rv:136.0) Gecko/20100101 Firefox/136.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQk94QlJnMndJSzJ6TnJ3WWtta0tVa09TeXNCYjRjM1diYnNmb0prciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749211848),
('BJwt1sxVwCOJsRAMJXcnzpaD3ouM5WXGgUahArPJ', NULL, '2405:201:300a:c08c:7038:e5f:3268:aa66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY011aHNoZVRwcDlZbkxEOFVmUklSN0x2NWpUYlREMUo2bDkxdVNvYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9mYi1kZXRhaWxzL09SRC0wMDAyMTAvMTgyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749206298),
('1Vq42lDEik6w8215oIdxtWIiYaZBZ3z1DoVy9r53', NULL, '2405:201:300a:c08c:f520:c668:604c:a40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUXZzQlFnRW9hR1o3WmZFSlZhSzh1b2s0c09qcFBjaGVvZm9uZ2RiTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWRtaW4vb3JkZXJzIjt9czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1749189630),
('PbySs4EqnzHEllfVHP2dksRMu2DZ6IFxKVq4B4lm', NULL, '27.5.41.53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUhLb3lOZVJCZjVldmx4SmxWc21mZkh0VzVYbzkzblkxdEdqcFE1bCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vZGVsaXZyb24uaW4vY29udGFjdCI7fX0=', 1749193082),
('YwzzdRI8XHj6OpIiMIe4kgdehacGku7wKiXCQoR9', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT01XZ0h3eGxWa0c1SnVVVkNQa1NkeURMQXd1c1lWT0x0NkZtZWYxcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749180398),
('Y4kqtsj4Oioq7mF4kVIy17sC0TPKi0roJPqvTloa', NULL, '49.35.195.73', 'PostmanRuntime/7.44.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHgyQ0xDaVBINUtIc0UzSkN2ZElHbXA5Mjc4VmhPUlA3UEZNekRSbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749218184),
('97RfBY1H1lIaEmoiHZWblwt61EL7kCKHykZCg6Ph', NULL, '2001:bc8:1da0:16:ba2a:72ff:fed3:a1fe', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRzBoTWE3anR6RUVqa2NXZFdLT2NNNEtjSFJvdHRKT2VGaHMwWWxoSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749127930),
('KxX9MClfetZPBoEOMMr3lOE4Wc4ald4ShikEb9W6', NULL, '49.43.7.53', 'Mozilla/5.0 (Linux; Android 13; 21091116AI Build/TP1A.220624.014; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/136.0.7103.125 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia2g3cmY1WERCanFBdEJQODZZbHI1MkxvUVhaeHJjaW9JMUVYYVF6byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sci1kZXRhaWxzL0xSLTE3NDkwMzI3OTEzNjAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749127079),
('IVzzwyspWcKjOhns69F8oiY8TB9TKfG1f0LXBoHH', NULL, '120.138.107.4', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR0ZaQ210Mm90RnRrMHJMZENSdmJ0NFczVnFOcnBabDFvYjBWbzN0ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749110605),
('kff9HDEvSJSOHweDB3iQ4A1htOe8kbXsQnJujCVt', NULL, '2405:201:300a:c08c:a5d9:5a53:7168:df94', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTW1YUVh2NXl6YU1iVlZhVmxDd3JINUpZbmdGV05mbEkzQVZvTkQ3eSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9mYi1kZXRhaWxzL09SRC0wMDAyMTAvMTgyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749123695),
('ytzGDzffbzPhtu4e94JH2CZmJpLrDqmtZNW9Tdut', 152, '49.43.7.53', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/137.0.7151.51 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidENXNjAwVzZQbFlWUTJIM0JoQ3ZrZFN5S0FZVTcxNzQ3RHN1bE1lUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9vcmRlci1kZXRhaWxzL09SRC0wMDAyMTciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTI7fQ==', 1749122819),
('UXq64HCkbRHkPTTFx9wN4WgvayCqumbBrtdR1IQA', NULL, '2409:4043:981:7b51:3cc3:1a63:c21d:a001', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOUJ2VDdoY3d1QktlbUt6UUplQkc3VEIxSDJiam9mbm9nY1RCVFJIbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL2RlbGl2cm9uLmluL2FkbWluL29yZGVycyI7fX0=', 1749131714),
('2zAlZiqR9KbiW9AqAKmjO21M5KEvKAeAuTOpOe0S', 152, '2405:201:300a:c08c:e808:5873:e33:2d03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicmIxRXN5clpQdFVkSzhFekloRElOcTE2eVlCUEpHNUNudWhTZXZzWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWRtaW4vZnJlaWdodC1iaWxsL2ludm9pY2Utdmlldy8xODUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTUyO30=', 1749110543),
('MyhDs1jNxjDqwZwawJ0PRHfgpfkSP1OSNLTMjRGM', NULL, '2409:4081:9e31:ec08:a8ca:1b6a:445a:3626', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakhSZ25CVHlJM1pEdHp1eURiRWZlSWdpclpnNVhHbDNZZ05hMXdvYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sci1kZXRhaWxzL0xSLTE3NDkxMDgzNTAwMTAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749109450),
('EkiUdzS6xnxE1mY86Fh2sGn4hzvTRiL9nHFGjuIM', 152, '2405:201:300a:c08c:8840:c274:7130:5720', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiejhCeUVoTzBibU0zbFgzcnlmTjI3NW5vTG14a0ZPOW4wYW12NXJjVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9pbnZvaWNlLWRldGFpbHMvMTg1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTUyO3M6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9', 1749122076),
('UioRGlJycp83mIwfLTvSGU9jqidBnuCa9zYBwUEX', 153, '2405:201:300a:c805:883e:e418:dd5b:ca54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHgxdWFhcFJmSWVrWDhvaU1PWUZOYWpwbzhqNWFtU2h6eDdueGt5ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTM7fQ==', 1750224315),
('ei8YGWfcpFUdYURnIbxoJwDV6aDporqdAuGAac5a', NULL, '51.77.89.183', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnhtTjFjMnV6b0hXSTJhQ3BVdjRQclZXT2wzNjFJYXI0S01zSHZLZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749281699),
('dC0xsOKIRhouc6uJuXa9mULZU6rYd2t8eGk3Ht4Y', NULL, '2409:40e3:501f:2bd2:65ad:f07b:573f:1c56', 'Mozilla/5.0 (Windows NT 6.1; rv:16.0) Gecko/20100101 Firefox/16.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWw0RkRMaE83MEp2R20xbWZ3dFBsdVpOTVJJUU5BajdDUnNZYkdpaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749098824),
('KJqtE3zk183ySvwM3ZuRNNdjjKqHpsTaFW9eCgSh', NULL, '34.34.21.42', 'Scrapy/2.12.0 (+https://scrapy.org)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0pudmdTbFJJS21POExkNEhnVktEWDI3eHlHcTFySm5vU2VPSWtlcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749069942),
('ehO6c0S0gX5s6MfO3WscqTCZp7wQ1Q0uy236WLbk', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlNmMUpPY0w3Q0hOV3NnZWU3cEpXSVlvazdmSEZDSHN1N1hyeUVUZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749093488),
('s0BpDZ47d1AxLxSQU5GULrF8vOs9rN5FBZxK3cUO', NULL, '34.219.239.106', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaklEQmNHSnhNYkI2UjRNUmxDaFc4Q0ZyUWpReTZVSGlaU1BJU2kwdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749069049),
('t29omUYlkR1qly0B61GXIpgMLgEmVp7O9Awu4g53', NULL, '34.219.239.106', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRUVkSUxneGNFVHEzbWtvUEFKNHNXNGxlMXFvc2pFNjF4NGpIS1ZyQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749069027),
('9qoA9tnGfEHVnz1uVFZvLOOs4jCkkOQX3PhwNpVJ', NULL, '35.90.174.210', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib2NROENtWHZKVDlFTjlGZGhCakNVZmQ1dEJrbFR6M1o0RFVxbjRxaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749061327),
('LL49k6WFaCsGLjKJck1ENQ6pN2e9vbXUSYEfQQNg', NULL, '35.90.174.210', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicU9UeU9jaVdFbXl2Yzdva2dQdzNzUDNFS3NjSDA3SVhNenlKVEVweiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749061325),
('HNdOoHWXe1rC6238di2fjEdZVxv43VZIWLnehSjO', NULL, '104.152.52.125', 'curl/7.61.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibU1pSEpVbWNBSUUzT0lHV1hGQWR4Q2pYZlZIMUx4NHhkaUpTU28zWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749052769),
('Dth7ZtqQ1cn57ko9xr9E4YTvI6v4ZXnWq1kcXBwX', NULL, '35.153.57.91', 'Googlebot/2.1 ( http://www.googlebot.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1M2Q3NnUnlUTXdvc1JNdWFxaW0zV01Kd3pUdXlIQTQ5Z1lBUHpnbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749047131),
('kX3KIvlS6hEf3gP0GfzFIJraDSz4H8rQSk5WWrFP', NULL, '2409:4043:981:7b51:6c6c:1a57:bce5:ae53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNHhnbDNWUDNHY0k1VDhqRm01aVRLanRWQ3VQTFNWSW1jcW9RemZ6dyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWRtaW4vZnJlaWdodC1iaWxsL3ZpZXcvMTg0Ijt9czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1749039206),
('AibjdHZ1HtL4dtErrZjcWQsXGnbTfbngK8pA8ZmN', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2hzVnhvWW9idXB6Sk1QZ0FHYWwwaFZHbzZMck5aR2dQR1p5NlFvayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749033816),
('S06JxoE3dkZKskZgys1FiOK7zcM48cLHqhWOK0Ar', NULL, '2405:201:300a:c08c:70ab:bd98:89d7:5296', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieExrZ2VYWTZKd3V0WUhyMDlvdmFsakJEeERYQWlyWmxlRkxQaEpkeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWRtaW4vb3JkZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1749032872),
('aZp95YUL9gzozrnSXlNarDesI2KFmtWovClUQYaW', NULL, '2001:bc8:1201:61f:569f:35ff:fe14:3784', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEVHWmZteFpSMUk3ZGhwVHVMYXVNTDNzSU5sUmh4ZENsNDdWV005aCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749047018),
('tOLc4LMwkFPtCpmGa8278kLZ60zfmfKOOW4BI7AB', NULL, '204.8.96.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWVlZ1g4M0hnWEZpbVJtNjRBeWJXeUxPODdvM0F3TjNwSldicXBqQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749032091),
('lYIhicSNT7OKvX48eVLHUZff3QE9n9p1DbkuyF2j', 151, '2409:4043:981:7b51:6c6c:1a57:bce5:ae53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib2diSHRUcGNKRlpnSWlFNm1pUjdmNEJ1ZW51aFJ4S1Q1VXliMEdFQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTUxO30=', 1749046044),
('xsy0wC4erRO0VHxdul7nNKZUoY7iBUpj4trJp0Kr', NULL, '2405:201:300a:c08c:2076:be48:f90f:70cd', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiODdsSUN3REJwM2J4aVh4U29nVUR2aUtWNWRuRXg0bllJak5ncWdsMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njc6Imh0dHBzOi8vZGVsaXZyb24uaW4vcHVibGljL2FkbWluL2NvbnNpZ25tZW50cy92aWV3L0xSLTE3NDkwMTc1NTY1NDEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1749035154),
('YbExz4gEEpAzh4Lp2uf67MPOb8loxAWSNXXKpeeV', NULL, '66.249.64.109', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.7103.113 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib015Tlo4c1pTTzduYnR1T3Q0NVpJbVRqZFo0NDc2ZFRvSWI1ek1WSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749027632),
('mbj9WR4yU8kMFBV2G4zJaKd7abCRYD18PeNTXJWE', 151, '2405:201:300a:c08c:70ab:bd98:89d7:5296', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWXNGQmxnNGFaUGRuSThEVFN1T2VLakdEemVmYWluMmw4R3dJNzA2UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sci1kZXRhaWxzL0xSLTE3NDkwMzI3OTEzNjAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTE7fQ==', 1749032972),
('Gmkzp8kCkTouiCrJTYNUUrcRSIf3U9flRYHHFSWv', NULL, '2405:201:300a:c08c:7408:ce33:11d2:97c1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHh3YmlOTW1tcEMwelBqdzhkdmg0NUpJZ3FoVGlCOW5CNGhXak96QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749030599),
('GqNznGiF2Dsf9Rx9v2MKT6Lb6r034U2IuMfov9uT', NULL, '66.249.64.108', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXMyZlFIbUhnZFFSazVNRlNtbjRpek1LaUZOWTlGSXA4cDB2eWVoSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749030617),
('WLYcTOEC33tesi6nxxyd7UvymqwapOX3zx3EkHxp', NULL, '66.249.64.110', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHZMbXJXdW1CWTViQndkSnNXSWpOa2IzaUhnb1V2RXgzdkczMmVqSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749030618),
('dzrGcMuQVvoT106hVfP7GP931EVFoKdr2Nnt9EJo', NULL, '34.219.131.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjRRT1BDbTBKTnhZcTZoVHRiMVZDT1k3V0lja3VxVThPbVJSMkpPYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749221208),
('855SHCE1IrMPRDVi62DxFbw6EaJa35grS9Q8Wel9', NULL, '52.40.197.94', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXhvVHVQNGFEZzBuY1luWGxrQ0hoaUV1dFpHN3FFZHltYkdUTDdoTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749290444),
('M85QMl36BZKhn5rcFKeQF4MpdOPLnLQlICe8UFld', 154, '2405:201:300a:c08c:614c:ae79:7db7:7504', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHVPNzc4UEh1MmRYbFhYaTJxTUhhM1VJTmp6UnhtejFWaGQ3aWdBMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTQ7fQ==', 1749293617),
('BkBePHjzaHMNrrJojWrtaA0nzoaaVz5LM79TvEEG', NULL, '2001:bc8:1201:1d:ba2a:72ff:fee0:e46a', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTcwdGZJbXJJSTVPQkhaN3hDNEM4MFlxQWF6WGZTOXExZkRGdkRFbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749294852),
('ByNV3A6MHnncW0C2h5Jtkc2diYWqygQ0ZyjE7KI9', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0wxeFhOUHZHN3Y4QW1tMjJyMk01bE41aUxMOGhqTW5ZWVNkdjhFWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749296569),
('x9YGI0GIBfbfSJx5rZzNVZC1dP9U13o9la3LFhPv', NULL, '3.253.235.210', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnNZdkE1WHd2dmVEdHBxRFczWHBRQlFFckx1em9JSmlLOEluQzJiNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749311870),
('523Jjbw5PNuPTQ3rQKOO5MQcT8bfqQhTxnmxyODk', NULL, '2001:448a:4043:7d75:bc2e:5568:b79e:1384', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGJGenJrRDd6QTlGUEhnOG1zM084bUw3a282Q05vVExzMlVQN0NpdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749317298),
('kdE45XTFU231n64iKJjvbyjCbieqJVeHJWMdwF2j', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXFHYU44TEdHQ3VlR2xpczBVUVV0WmI2eU9ramZJdThSWUcxbE5QciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749322028),
('s0KcMR6wMMu1eEgV6hMVVxFksAskyHLL8rDrNCXI', NULL, '5.133.192.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3F5TlF1bUtsbVNUcG9Ha3p2MllvUXVneTU3bFdHRW1MblRqbFl1biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749340066),
('764GjAxYg38EajUrQ4jspexXBpZpL5ABriwzpXfE', NULL, '2409:4081:8293:2604::1451:b0a1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1FybEpMcVprYTBrWlFWVFl3TWcyNEZwVjVleU1oZDg3SEJkY0xFNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749361532),
('UQj1BJsvDBm9WkQE3wnUWkLKOfhpBTRoqTUqiIk8', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWtsRnF0blRRMWVoc1g2NmFOOEMxSEV0U3ZSOWtoeThPeUs5THpIRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749365366),
('1klAqfmP62wtYrklx7wIk7kEjZ24iSbUy2XHCgf3', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS1ZSaVczNTBVdkxhdTRuZE1uOEVlajFDaDV2SVFHelRxUWlOUzJTTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749365804),
('qlOYWSBIM5o73iPzulKLbOg8KFyqocaShaDlc3Ef', NULL, '2001:bc8:1201:1d:b283:feff:fee7:9b9', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTNUSlpUaFRqT1lYYm1DSXhQdk11UzNSZzdxVHFaREtSSHJqV2wwUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749382902),
('dMqCsEsGrGWjaLlAkY7qL3kaQSUNyBbfFhwX59Cg', NULL, '54.211.44.22', 'WDG_Validator/1.6.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFdEYlZ3R0kyUWZNTzVXN0RVRExDMEx0ZDN3cG9haFNlTzdtcHBuUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749394217),
('5EVjPPGUVozqSvJddnHS2hSHyt4aJ0zjQDNNyGQ9', NULL, '52.13.111.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWlya3l3Z1NPMWF4UjJkTXVPdFkxYndWdlBGdnJlbEhqTlB6dDVPRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749401039),
('Pwq4k0twxV5VXsX5xzmZnZhGZQBVioDgqVrj39GJ', NULL, '52.13.111.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaDQxcEx4Wjd4VUwwbjRzQzBxZ25KOVc4TWt6RUx6SDBUcW44aFZJbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749401041),
('vKlvduhMHYOSx1iSr8VYpiMfB1Spq8SBEbM4gdpS', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEkwR1RLbXVRMVFmbml2Rll6emRPVlpDNnBaaGlNakt6dERNamFWQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749431966),
('FNGDkSwq1loG3vNY9roJjsda49XmdHsR0PK46Z2v', NULL, '2001:4860:7:805::ff', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSlBGS0VxNnNqTVhoNDRtcmJZb09oTksxY1huNmtTeTFFUm96UFdZWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749465906),
('opYCOf5dbyCCbUbXFjSIZczbhMu2xeihAOCDhgVa', NULL, '2405:201:f:15e:dd34:bf98:ecbe:6ffc', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlFBMXdrRlhoMXpFMG5hZDEwT2ViRDNKOG45cVJPbVJBRzZzc1I2eiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vZGVsaXZyb24uaW4vY29udGFjdCI7fX0=', 1749466107),
('dREUHe7NdcoamFHiml3ZhJ3V7XQ6kFD4e3XlfUyd', NULL, '2001:4860:7:805::3b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYUltNDZaRmh0Y1RUYldWclp2cTV6TW9CV3JLSE5mWW1qUXV2eGJhdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749465955),
('jHCJgfYM2fGInuW17KscXqjIHX4gDcDIHmjtqg2q', NULL, '2001:4860:7:b05::9c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieEJld3RZSDZpc25ybUh6bjIyb29LOUFMMzR3NXJsaU1kQkhnY1dWTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749467873),
('gtZXO7XTE5w9s1M7WncOqXjM2OTCkOh9ZH89TeX3', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTVjZ0pIdHoxeXAyVjgyTTF6NzRLR1EwZjFleTU5OHkycldWYUdxMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749474324),
('JRzq2xl63xkvyRkgHJPNkll874F4dCFrDXsdsF0A', NULL, '155.248.254.73', 'Mozilla/5.0 (X11; Linux x86_64; rv:68.0) Gecko/20100101 Firefox/68.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1ZwdlRIOHFUalR5M0dtMFJPZ25DTG5JSk5nTDM2UDNZeHgyMWZybCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749479619),
('15FrfWMO9TOFiH5WKVvZZ4wPl7wbKFVqfIzWGBwg', NULL, '87.250.224.28', 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVd1b3dvbHNtVkt3dk1OeVhNeTVndHJYQW5TNURrcFpMbFNmeWlFUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749482508),
('P7bTkKy1uzvdGHDXbqwWdTebLnglmhtctcL4i4vo', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid0RTT3hOVFJGZnhCWHZlWUY1Q0FPV3VVYnk3a2pQRGh3TkpGWGVteiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749526329),
('bpDgZK0R5AEw8tpbIZGQZKH39V1qNz47o9R0WI8h', NULL, '18.246.61.133', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0RjTlJ6Y1Q2Y3FCS1o4R1F6TXRZaGFkejFDMkM0V0p4SlZ0bkN4SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749548747),
('0OA5AUEaFRj3xqj5bBgylDg7pt6MYLvX5FfJ2i8Q', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVFESnpzcWFrRGR0ckVUUHlzcWxXZFNJN25yQ2IyQnBVVkpTZUVDbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749553415),
('U2NkAd21OQuSufmOe4gvo0vG35UXtVvVhKWj1dxY', NULL, '66.249.66.3', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.7103.113 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVhxV1V2OGFMZDJ2Qk9Xa0JMNXdoUDRFRGFIOUpqamtwblVkTGwyMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749648423),
('hIjRdbEJzzLnsiGjQjUasySzBY5V4HIyf3zxUbZu', NULL, '104.152.52.103', 'curl/7.61.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieTk1RTlXMjRqM0pxRkd4R0QwNk9zNXc2ZHFnODNtNGlWRHhQYU5NUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1749656773),
('jZxuIJ50cWvyQYcINUEXVqGUC02rYh20cFyrlc6j', NULL, '104.152.52.116', 'curl/7.61.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTE9KdXUxOTZtN1AwM1BFMU9nYnVCZm9UbFA5UnV4ZzhYVnpSMmF6cSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749656902),
('AdArTLkhuuLPNzhTpWqvwEuEpBPe96WfO6BYtqJY', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFBxeXNpcEtqM2lWV2J1WlVUbXc1WVY2NmxoeDFINTVnR3gybW9CbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749704087),
('CcN3vXYnXEO7K9nH3DsZFkqEdFLE8zRGwUFZLoWz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRXFpVkZnOFE1N0RYYmp1OUVaWFFoQlVUbnpYb0xENDRLWm9HSEltVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb25zaWdubWVudHMvYXNzaWduL0xSLTE3NTEzNjc2ODktMT9kYXRlPTIwMjQtMDUtMjAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1751465823),
('MHUxXlOZJeQgvtyYIMJI0dhbTcnpCArTFTqZeybA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGlhNzdOWWVEWW11Z0ZuUW93QmJBYnRLdGVDaUtoS084SEw0YmZDUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ld2F5YmlsbC82ODEwMTE5NTU4MTUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1751627395),
('E0VbVXsrv3B7DW8foHI3ro2SPUeuK9T6e5yiv4nU', NULL, '2405:201:300a:c805:6457:6f48:7715:a8ae', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWZEeHhMdUFrVWExZ01JaHZSaU5KVVcyTjN2V05ybFBvczRGSTUwOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzc6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWRtaW4vY29uc2lnbm1lbnRzL2Fzc2lnbi9MUi0xNzUwMTY0MDE2LTE/ZGF0ZT0yMDI0LTA1LTIwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1750311859),
('7Omr5gK660iLv7WbDBGABBN85N783EVi9vT8mB7J', NULL, '35.229.17.213', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1BGYVFWaXBNbFplcGxrbFFhRlRPQklQS2pRTXZMdlJveFVibk8xaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750184022),
('s5SsHYnzbN19Fpmv8MKZu0ZVXB8sLgMCqYnorIWr', NULL, '111.231.10.88', 'Mozilla/5.0 (Linux; Android 10; LIO-AN00 Build/HUAWEILIO-AN00; wv) MicroMessenger Weixin QQ AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.62 XWEB/2692 MMWEBSDK/200901 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZTg3QlM3SzBkREF3cTA2YXhySHZkQlRWbThzYUdla3JvSWE0N09aMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750208472),
('ug5cIEMvxORwOpoPCb0YWcc0REjm7G4cxpqoFniN', NULL, '2a01:4f8:13a:1f0a::2', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieTM4QlVHb3E0M3VxRXJBYWRjU3VuVTI5RDZGeGVKc3d1RG80aGJnaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750218190),
('JQvHEpbn51tJgk45bek8H9eEfLE0IBBVyhvSKajF', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWdhcklvYWlSVGxjckVrVDJLOFNRaHdiTGFSa1REeXVhTUhBN0dESCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750246623),
('mdwicFT7RJgQr7KPlS5IP0e9DE09r45pwOddzipi', NULL, '2001:bc8:1201:61f:569f:35ff:fe14:3784', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHZPVnlYNDRXQjBQZExjNmxJVkcxT1pDMVcxd3ZsSlJXeUdJc1VGbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750250137),
('ywv5QweSYUqgP0TeT31i6zntT5h0PHOuDjTGZC7b', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWphWFRkZXJIZkVOcldabkp1TkZLQkJLSzQ1alNubWVzWnVzajlLUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750251193),
('rQKUamXsR3T1gvji6TSLpHD0xxekJGF2GOuNz4uX', NULL, '2001:41d0:303:83d2::1', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG42ck9LeXJ0emcyZE9UR2w1eDVMUGNsS09hUlg0dDRkOFg3TXFQZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGVsaXZyb24uaW4vYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750253251),
('1uPleViazlBk1dq21iiuJtHdEVweRYtsrahipVDb', NULL, '2001:41d0:303:83d2::1', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzFXanlqYnRKTnRyNzJ0blpnSVFlcHBVcU5nMnZiUmd0MnNMcThmUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vZGVsaXZyb24uaW4vY29udGFjdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750253261),
('xDRos3r9rnjEk5ZEKTAJYKcvdwf73Bz9MgjVw8mD', NULL, '2001:41d0:303:83d2::1', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTURUS3llUlFQTzJPOFprMEpzTVNXczVDTHFiTHZwR2lIbUw2QXM0UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vZGVsaXZyb24uaW4vcHJpdmFjeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750253298),
('dr3f8dXzJFqgPtycE9opciMFz00d8M2kf5PAGtj7', NULL, '2001:41d0:303:83d2::1', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWtuVTRYUlA1NkNUZnpUNnA5QnB2SzlWVDJYZDZublRYZXlsa2o5UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGVsaXZyb24uaW4vdGVybXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750253301),
('fKFE7y6TPChEWma7tJsMBqrcV6RauJQ0DEOe8OWI', NULL, '2001:41d0:303:83d2::1', 'Mozilla/5.0 (compatible; MJ12bot/v1.4.8; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNk1mMTJHQUxvcmlIdXJpZVpzYXJvWTF2Y0xkUEFzZG95TVFKUHlhSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750253308),
('FMVlNScdbShoIF5q4OJOTpn6nvgm6dR0HB2TKqlh', NULL, '104.152.52.234', 'curl/7.61.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWkNlZUl5a2RzRjZZWlJwQ0dKNUREaXcwY09yU3RKeEVZelVMdldxZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750262719),
('Rh9Oprczvwrfo7qoAzZK4Qv1GjGx83Ty5ImVm8pO', NULL, '34.141.231.213', 'Scrapy/2.12.0 (+https://scrapy.org)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkxyQXF1V1RuWXpKcEIyRXVYS0ZqQ3FHWW5yQUlEaG9jejQ3MER2RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750263399),
('5tz3AVSyFKxq8qttNO6KUBV0nZ5E8MmvYWz5Bkua', NULL, '104.152.52.130', 'curl/7.61.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFN5NmhBWkU2OUZlcU43WU5nSHdYNEYwa1dZNnE3dE9QNXBmSm9YUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750263756),
('Ph66qKeHNAkugIjK79UARPGVAm8LNBoKyBnVkHwH', NULL, '130.89.144.162', 'OI-Crawler/Nutch (https://openintel.nl/webcrawl/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidjVqWmo5MDUzUnV0MjM3SlFRdWg0Nm5vUVNHM2JMS3JHeG4zbEZQeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750282709),
('YdGca1qvxAZuGtfhtWARh609h2XbYtjIbOXwVwce', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRENHS3dIQjdDblZkWFhLdWlyUlgxQUxpb0J2UjlGMXU2Vk9pVXpERCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750322010),
('ep1YmaoTDEuSvU3SZP2u2VclRujrYW38H52sTd2j', NULL, '47.88.22.231', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXFPQnpXVWVKOEY3Q29tSThqeEczTjIyUkFvNlp5QUNSaVB6d3duZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750332182),
('QycZOCKfZaxFDkQZcP3THdvOnGuONmG1BxWEFPG2', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzRYV2JRVXBOdk5KWTRnUnRKN2dic2FsUmp2a1RGWjZKYzdRTWZXOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750332827),
('CgAK6dEQiUIa54xPAySYVz2CuT7KRmNCAieM9WIQ', NULL, '2001:bc8:1201:1d:ba2a:72ff:fee0:e46a', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWXRCN3RSREpaU0haV0RhYVJBcDY1U2NlZ0VxWFJVS2tGU1NWWjMzUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750334880),
('3HJGIox9EY5U5Yc3c4R2rrUJL82gC2D3XYTyqhrv', NULL, '2401:4900:4bc7:84d7:1:0:a14e:7fa9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFp1MjVZTW9KOUtWUnJMNFJPTkpBTkJVb2I4T0pjdGJZbHZaanBqMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vZGVsaXZyb24uaW4vdXNlci9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1750345758),
('nzk9A48iHjV2aHvFrYNpNQdjyV00zUZceSSZPzyC', NULL, '51.68.111.244', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.2; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiam5qN1hhMldvUVBGT3RMdWFpb3dxN1VzSFdsWEM5cHRHTkZVWmF0aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750357275),
('ntc3SwddZAsuWQuMdaSDJthHzBTZYmIJvtru8Cal', NULL, '2a02:247a:26d:1000::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36 Edg/91.0.864.54', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDh4Y1hZTlJSbnliaW83N0FiaFNOY3hlazAzNnB4WVNSZktiWjQyWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750374211),
('lPUYmDuRWzcTSLGaapM82J4vGKWmyfwfgb2uTbos', NULL, '8.41.221.58', 'Mozilla/5.0 Firefox/33.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1l0QU9veU0xdTZnUUNBcFFLbnV1OWtHVEFocHJwV0JtNFFmejZBaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750405878),
('f7nKBufE8AfsU9j2lQQi6EmxYLAVq3VdAUQQH710', NULL, '8.41.221.58', 'Mozilla/5.0 Firefox/33.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUE1HeHlWdVBqcklqbGNMN2xHa1N2VUdpaWpXT1h2VVRwNXlKMmhmeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750405880),
('bAkhDfoewSpESRaXynGW8KfBOV9w5qr3YlefEvpm', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidTg5OTlVclhaS3dyZVhiRzlIWkQxczFMcFZPMmphZjc2WXdXRXZaWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750414359),
('t5bAETvoQKOMaobHEPbSFiIYGXA7pJXKsjWaMj6x', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1dhZUtRVFUzNmVZelMxUW1kd3FZOHZjYVl2eFE4eEt5WjJsSFdSRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750426029),
('eo48Bl9hEX1TNENYBMRoNgZJ91DQAP2naaRqz6SB', NULL, '159.203.47.150', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHl6dWtvUDFHclBjd2ZmanM1NVpsQkJpOHBzU1F6OEt0TkxyU2RZaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750427436),
('XR4VYSBHA9fr0QYiuQOi3cMrSExKLYFbXobD3PO2', NULL, '104.196.245.90', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUVzYm81VEVNbVZ5bE0xTG1taXc0cVdHSWt5SDBNaTkzNmVnQThPUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750442670),
('fNOTpTk2wlSFUHUsoM78IljpeAPLYZuMzAfIL0Rd', NULL, '35.197.11.186', 'Mozilla/5.0 (compatible; CMS-Checker/1.0; +https://example.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUW5YbGtHQ0xISFVVNHAzWWlvZm9OMWlEbjE4VTVySEQyYlJSbGpFRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHBzOi8vd3d3LmRlbGl2cm9uLmluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1750455581),
('gRftw6xULV8ZPVcckqO7vBMcPViwJN7yX9wvi43g', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFprWXYxM2dzWElpQjd4MGRvaXBmRFdVdUw0WkR4Mk4xRDNpdlBmSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750464947),
('ZoXCmAZNd7hD2h0rL1mGUPRI1ELMyqIe0866BHgs', NULL, '2001:bc8:701:1d:ba2a:72ff:fee0:8c42', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUd6bkJ6dnNJT1Zua2E2OExWWWF1WE85VkJ2aDRYNkVKOFdjak1jYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750506744),
('FHdvRka2jtaUZ5bcnJWxmiHO3TYYOthGBP73vzK1', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTVSdDZrQUxWQVBYekVpWEptY0tQRHpBekNlU1RkUEJhUEw4MTNMaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750508364),
('rLVF1aWhBijBU3W4sBOMHyv1NZlZUxbtSDMraWoS', NULL, '66.249.79.131', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.7151.103 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlRWTHFaZU41Mm51eDhsZ1VFU3JFd2l1bmk3cGVqUXV0VjMyZ0RQMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750514463),
('qHXGHdmlhKk5I3D7LWOVvhBhazAW3zR1NudTPiJx', NULL, '2a02:4780:11:c0de::21', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT0tleWtnNzBCMkZseXFLTWR5Y0NvZ04zT255alY3T2RHNDdYWDl2USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750554967),
('5ATrcGqxOHG9KZOZeTI2vOnUaxCbALrq08l4csKv', NULL, '2a02:4780:11:c0de::e', 'Go-http-client/2.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDd0OTdjbnJEdmxycER3dVRoZXJCSlJuSGkxVVRKY0FyZFlCNjVJRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750583209),
('cpooyEh2BRdQP7YO0cxFJeLFyaskUijH8V3U9OC2', NULL, '54.185.57.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGVHMkFkQzU3YkJlaHdXemx5eXV6QWczS0h6ZTQ1TUFkWVFCQm83ZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750605012),
('02LFCDEhPGBHhOUcvHLeNi1QZ95sN5rK61NYmbRW', NULL, '54.185.57.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZGZLVlhHbmNEdmpqTXk5SGd6QUtjejlCNHJtMDRDeWpFdDBwbzBsMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750605014),
('emevJoW6ddimLfUNPw1LXvj4w6kyGnZQDsTTwDqF', NULL, '51.68.236.87', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.2; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmNJdFNRU1c3MkN2eXFLZFJKMXZDdEhwc3Y1UVVTbWw4WkNuTkNENCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750620431),
('7Ajwcld0YP06mUbAreorh9JPU8ksgA8XUKCPAFGx', NULL, '51.68.236.87', 'Mozilla/5.0 (compatible; MJ12bot/v2.0.2; http://mj12bot.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlJWcVVEN3VtNVZQejc4dHVnaTBIcEg3M1RneVk0bEZTanAwMkFPbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVsaXZyb24uaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750620432);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_office` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offices` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transporter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('rcm','fcm') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rcm_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `head_office`, `offices`, `mobile`, `email`, `website`, `transporter`, `type`, `rcm_description`, `fcm_code`, `created_at`, `updated_at`) VALUES
(3, 'logo_1745244145.jpg', 'Khandelwal RoadLines, Opp. Abhinav Talkies, Ujjain Road, Dewas - 455001', 'Mumbai: 9326145500, Indore: 9303188889', '9098733332', 'krl@khandelwalroadlines.com', 'https://www.fetum.biz', '23AAAFK1234L1Z5', 'fcm', NULL, NULL, '2025-04-21 12:49:32', '2025-05-30 10:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(7, 29, 'Onion', 'subcategories/vnkQMcS1s4ZfScrsZ0AJHLrdETv5GxjRuYdDh9Wo.png', '2025-03-07 02:24:02', '2025-03-10 06:00:35'),
(8, 29, 'Potato', 'subcategories/GfiUnMIHnfKM3cJ97MOfssLv3iDe2BKTzzII0oix.png', '2025-03-07 04:13:35', '2025-03-10 06:00:58'),
(9, 29, 'Garlic', 'subcategories/bK1DmN9eBctTsPn8Tg8mRBbkBYoAYCetJjQwngw4.png', '2025-03-10 06:01:20', '2025-03-10 06:07:05'),
(10, 30, 'LadyFinger', 'subcategories/EtWszz6s6c2E3sMQiadunQqEDF2shbdG8pLsFRUU.png', '2025-03-10 06:07:31', '2025-03-10 06:07:47'),
(11, 29, 'gjh', 'subcategories/nsBjtxjlxjOgw0wJWmGEIDRlfU0HfsmNpl1lpRt4.png', '2025-03-17 02:17:06', '2025-03-17 02:17:06'),
(12, 31, 'Gobi', 'subcategories/LA7v0oghNWp48FP1QfUQXZCasOyMVMB6aGySLzo8.png', '2025-03-17 04:45:47', '2025-03-17 04:45:47'),
(13, 30, 'hkkkskhksahsa', 'subcategories/7LCpJ7RTpx8u8qls3xwvUEOnRVFMTu2iIXpkRDTy.png', '2025-03-17 05:52:31', '2025-03-17 05:52:31');

-- --------------------------------------------------------

--
-- Table structure for table `task_managements`
--

CREATE TABLE `task_managements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `high_priority` tinyint(1) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_managements`
--

INSERT INTO `task_managements` (`id`, `assigned_to`, `description`, `high_priority`, `date`, `status`, `created_at`, `updated_at`) VALUES
(29, '20', 'helo kapil yes', 1, '2025-05-19', 'close', '2025-05-08 02:35:24', '2025-05-24 04:44:13'),
(30, '12', 'JHHKJ', 1, '2025-05-24', 'open', '2025-05-24 04:43:22', '2025-05-24 04:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `tyres`
--

CREATE TABLE `tyres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(191) NOT NULL,
  `make_model` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `format` varchar(191) NOT NULL,
  `tyre_number` varchar(191) NOT NULL,
  `tyre_health` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tyres`
--

INSERT INTO `tyres` (`id`, `company`, `make_model`, `description`, `format`, `tyre_number`, `tyre_health`, `created_at`, `updated_at`) VALUES
(7, 'Oliver Baldwin Co', 'Architecto sed autem', 'Dignissimos enim deb', 'gygh8ui', '35', 'new', '2025-04-07 05:34:45', '2025-04-15 01:16:45'),
(4, 'BKT', 'CKK3', 'dfdfsd', 'll', 'KKDPF090', 'worn_out', NULL, '2025-04-09 23:50:51'),
(8, 'roadking', 'TTCI', 'good quliaty', 'FKDK', '43', 'good', '2025-04-09 23:51:16', '2025-04-09 23:51:16'),
(9, 'Jefferson and Barnes Trading', 'Exercitation consect', 'Eiusmod do voluptate', 'Sit quibusdam molest', '920', 'needs_replacement', '2025-04-15 01:16:28', '2025-04-15 01:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deductor` varchar(255) DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `group_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tan_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `otp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refer_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reward_points` int(11) DEFAULT NULL,
  `api_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_otp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firm_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adhar_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `you_are` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `industry` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `against_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `deductor`, `address`, `group_id`, `tan_number`, `pan_number`, `email`, `mobile_number`, `password`, `created_at`, `updated_at`, `email_verified_at`, `remember_token`, `city`, `status`, `otp`, `refer_code`, `reward_points`, `api_token`, `session_otp`, `firm_number`, `adhar_number`, `you_are`, `state`, `pincode`, `industry`, `against_user_id`) VALUES
(153, 'GOOGLE PVT LTD BEST ', NULL, '[{\"city\":\"Qui mollit quo velit\",\"gstin\":\"Et quibusdam explica\",\"billing_address\":\"Enim consequatur sit\",\"consignment_address\":\"Consequatur Laborum\",\"mobile_number\":\"+1 (317) 649-7529\",\"poc\":\"Consequatur sit la\",\"email\":\"gyxota@mailinator.com\"}]', '23', '610', '710', 'ishwar@gmail.com', '9669198800', '$2y$12$nL/q4Vxir/ezd7c3brADbedYXYtLZxXTjhzQyvrIUX/qgRP29yHhq', '2025-06-06 05:35:00', '2025-06-23 00:31:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'VALVO MANAGE PVT LTD INDIA', 'Consequatur optio p', '[{\"city\":\"JAipur\",\"gstin\":\"Consequuntur non aut\",\"billing_address\":\"Muhana\",\"consignment_address\":\"Perspiciatis dignis\",\"mobile_number\":\"+1 (202) 156-9815\",\"poc\":\"Ipsa laudantium qu\",\"email\":\"figujoxo@mailinator.com\"}]', '20', '250', '896', 'a@gmail.com', '9669198800', '$2y$12$AGrVGAb1LsBbY0fag3rY4usPyPUId1UBRlgsgI1PfD8SK.qtCzvjG', '2025-06-06 05:55:14', '2025-06-23 00:32:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'KRL TECH OUT OFF INDIA', 'Nam enim elit error', '[{\"city\":\"Consequatur ut ipsam\",\"gstin\":\"Cumque tempore eius\",\"billing_address\":\"Voluptatem ullam dol\",\"consignment_address\":\"Earum vel ratione co\",\"mobile_number\":\"224\",\"poc\":\"Praesentium voluptas\",\"email\":\"jyzu@mailinator.com\"},{\"city\":\"857 East White Milton Freeway\",\"gstin\":\"63 New Boulevard\",\"billing_address\":\"89 South Cowley Street\",\"consignment_address\":\"912 Green First Lane\",\"mobile_number\":\"590\",\"poc\":\"20 Hague Street\",\"email\":\"quzyjafir@mailinator.com\"}]', '21', '473', '383', 'puxa@mailinator.com', NULL, '$2y$12$Zh9QTgcgF8PfLQRRPF4hr.JzaW8HtvstNZYbxmOk4eGYGDL2BfKBa', '2025-06-13 07:15:35', '2025-06-23 00:32:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'DELIVORN PVT LTD OUT', 'Iusto in deserunt qu', '[{\"city\":\"Deleniti aut delenit\",\"gstin\":\"Exercitationem volup\",\"billing_address\":\"Magna elit eum anim\",\"consignment_address\":\"Error optio velit\",\"mobile_number\":\"640\",\"poc\":\"Repudiandae eum in r\",\"email\":\"hiryhyjo@mailinator.com\"},{\"city\":\"761 West Oak Extension\",\"gstin\":\"316 White Milton Lane\",\"billing_address\":\"53 Hague Lane\",\"consignment_address\":\"662 East Green First Avenue\",\"mobile_number\":\"337\",\"poc\":\"273 South Oak Avenue\",\"email\":\"rozy@mailinator.com\"}]', '26', '798', '283', 'qyjolud@mailinator.com', NULL, '$2y$12$yrJnvpd0cjmzLtfKiS8/COmr0FcgFCLnDYvgQ0UwS4pCPLkO0nIhq', '2025-06-13 07:15:48', '2025-06-23 00:34:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'AMAZOON MANAGE PVT LTD INDIA', 'Rerum in itaque labo', '[{\"city\":\"Exercitation irure e\",\"gstin\":\"Vero deserunt pariat\",\"billing_address\":\"Aut blanditiis conse\",\"consignment_address\":\"Aut animi cillum qu\",\"mobile_number\":\"735\",\"poc\":\"Atque pariatur Dolo\",\"email\":\"taxa@mailinator.com\"},{\"city\":\"25 South Old Drive\",\"gstin\":\"804 North First Street\",\"billing_address\":\"28 South White Milton Avenue\",\"consignment_address\":\"85 Milton Freeway\",\"mobile_number\":\"998\",\"poc\":\"10 Cowley Street\",\"email\":\"figaxi@mailinator.com\"}]', '23', '512', '840', 'wabubig@mailinator.com', NULL, '$2y$12$PAphN8DXIjlcm5LreAzt6udpzGRLntW93x7ujWSgge3THTwUxSHbm', '2025-06-13 07:16:15', '2025-06-23 00:33:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 'FLIPKART PVT LTD IN', 'Ipsum doloribus dign', '[{\"city\":\"Anim eum quia quaera\",\"gstin\":\"Alias deleniti duis\",\"billing_address\":\"Officiis recusandae\",\"consignment_address\":\"Dolore dolorem nostr\",\"mobile_number\":\"96\",\"poc\":\"Quo aspernatur modi\",\"email\":\"larapo@mailinator.com\"},{\"city\":\"564 Clarendon Boulevard\",\"gstin\":\"237 Milton Parkway\",\"billing_address\":\"10 Rocky Fabien Boulevard\",\"consignment_address\":\"69 Oak Drive\",\"mobile_number\":\"936\",\"poc\":\"456 East Oak Avenue\",\"email\":\"wyfyzurohe@mailinator.com\"}]', '19', '487', '143', 'jexin@mailinator.com', NULL, '$2y$12$jceeySnkYuXpmLwktPuvsezmD5kSoiuH7Y0vSc2OvN9nyUDtLEcK6', '2025-06-13 07:16:34', '2025-06-23 00:34:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 'PALTA FERTILIZERS ', 'Sed est aperiam id o', '[{\"city\":\"Vel consectetur obca\",\"gstin\":\"Amet fugiat sunt\",\"billing_address\":\"In sed placeat aut\",\"consignment_address\":\"Porro harum et ex ar\",\"mobile_number\":\"485\",\"poc\":\"Enim commodi asperio\",\"email\":\"lavozuny@mailinator.com\"}]', '28', '273', '336', 'peqa@mailinator.com', NULL, '$2y$12$9nPVu7ZWa8UFrOGoqWj2reGRi/qhhPge4CLoBfZGaPHJ93akkNunS', '2025-06-23 00:35:47', '2025-06-23 00:35:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'AAKASHI COLORANTS ', 'Irure voluptate volu', '[{\"city\":\"Sint asperiores nat\",\"gstin\":\"Doloremque debitis q\",\"billing_address\":\"Molestiae quia offic\",\"consignment_address\":\"Voluptas voluptatibu\",\"mobile_number\":\"743\",\"poc\":\"Quo dolorem molestia\",\"email\":\"sakydiv@mailinator.com\"}]', '21', '785', '711', 'qykomasa@mailinator.com', NULL, '$2y$12$a1.I3x2tU7VGczy4L/Bd7uHoghnCDyGVNtQ8YZnofw0Auk7u9ThcK', '2025-06-23 00:36:54', '2025-06-23 00:36:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 'Aluminium Paste ABC', 'Neque porro sunt aut', '[{\"city\":\"Aliquid ut explicabo\",\"gstin\":\"Obcaecati exercitati\",\"billing_address\":\"Lorem velit illum d\",\"consignment_address\":\"Aspernatur ullam ass\",\"mobile_number\":\"586\",\"poc\":\"Incidunt a eius lib\",\"email\":\"jezipu@mailinator.com\"}]', '20', '528', '25', 'tikabax@mailinator.com', NULL, '$2y$12$nuR/XYxavYMsGQvuJrFEUeebjd9rvS8YnETY02KYzkaFS5MfegdSK', '2025-06-23 00:40:23', '2025-06-23 00:40:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `registered_mobile_number` varchar(20) NOT NULL,
  `gvw` varchar(50) DEFAULT NULL,
  `payload` varchar(50) DEFAULT NULL,
  `chassis_number` varchar(50) DEFAULT NULL,
  `engine_number` varchar(50) DEFAULT NULL,
  `number_of_tyres` int(11) DEFAULT NULL,
  `rc_document_file` varchar(255) DEFAULT NULL,
  `rc_valid_from` date DEFAULT NULL,
  `rc_valid_till` date DEFAULT NULL,
  `fitness_certificate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `insurance_document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `authorization_permit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `national_permit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fitness_valid_till` date DEFAULT NULL,
  `insurance_valid_from` date DEFAULT NULL,
  `insurance_valid_till` date DEFAULT NULL,
  `auth_permit_valid_from` date DEFAULT NULL,
  `auth_permit_valid_till` date DEFAULT NULL,
  `national_permit_valid_from` date DEFAULT NULL,
  `national_permit_valid_till` date DEFAULT NULL,
  `tax_document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tax_valid_from` date DEFAULT NULL,
  `tax_valid_till` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_type`, `vehicle_no`, `registered_mobile_number`, `gvw`, `payload`, `chassis_number`, `engine_number`, `number_of_tyres`, `rc_document_file`, `rc_valid_from`, `rc_valid_till`, `fitness_certificate`, `insurance_document`, `authorization_permit`, `national_permit`, `fitness_valid_till`, `insurance_valid_from`, `insurance_valid_till`, `auth_permit_valid_from`, `auth_permit_valid_till`, `national_permit_valid_from`, `national_permit_valid_till`, `tax_document`, `tax_valid_from`, `tax_valid_till`, `created_at`, `updated_at`) VALUES
(20, 'HERO HONDA', 'MH0022', '9876543215', 'Enim voluptatem aliq', '15 TON', '999', '369', 6, 'vehicals/rc/zeB7Kdjs1GHvCLiP8T8DST0JoKxiKEnJXXQZN24u.png', '2025-04-07', '2025-04-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-07 05:02:10', '2025-05-08 02:16:39'),
(21, 'TRUCK', 'MH04GA 0786', '8521479635', '1200', '500', 'mpeifwe32', 'ecoenmrti984d', 42, 'vehicals/rc/jFI12YuKwsERRgs9ESEOPxNAHWUD4IDeHRD03g1L.png', '2025-04-10', '2025-04-10', 'vehicals/fitness/FUDPHKDpvh1B3HDBbffQANgEexdMlr3BaG3tPEfx.png', 'vehicals/insurance/OXAQ4xyPLwJVIG0tJHB509Zy7G1prln7Ypf9qW4i.png', 'vehicals/auth_permit/PFtBELgELQmjAuGNZxEvftX2RRNZeeWx2wxR96Nb.png', 'vehicals/national_permit/QXyuHuDdRdGXQDsOwGoW7ofa2PaPnH6gRdUGKW6r.png', '2025-05-03', '2025-04-19', '2025-04-23', '2025-05-08', '2025-04-10', '2025-05-06', '2025-05-29', NULL, NULL, NULL, '2025-04-09 23:47:03', '2025-05-08 02:17:19'),
(22, 'HERO CAR', 'JK667QWE', '368', 'Aperiam quibusdam cu', 'In inventore occaeca', '272', '91', 362, 'vehicals/rc/n2cfhStPPysyaVykC6OjtjiuwB7YsSzvsuxXZvo9.png', '1993-04-04', '1979-02-13', 'vehicals/fitness/7fKSOTXUNhaqtTl9BJOx7nZl6KYsbRflL9U5LqwF.png', 'vehicals/insurance/OPDOK5QdDc5RYOkMMoCEnMmUymJ2hjFTvxNUbRdI.png', 'vehicals/auth_permit/dm6X89izHy87ctW3SwUFH4Yz3WUgXYiuY8luJLHK.png', NULL, '2025-04-16', '2025-04-17', '2025-04-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-15 01:08:22', '2025-05-08 02:17:49'),
(23, 'HONDA CAR', 'SDER4567', '86', 'Ea iste quia tempora', 'Ipsam eaque quo beat', '584', '119', 424, NULL, '2004-08-03', '1982-05-18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-18 07:36:57', '2025-05-08 02:18:16'),
(24, 'Container', 'MJUHY6677', '9123456789', '20 Ton', '15 Ton', '58965', 'GHYTRD456', 36, 'vehicals/rc/UuGBXFqwTFRMnNQNSCywgSmBCZmUzSe8bdDBSFVS.png', '2025-05-10', '2025-05-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-08 02:23:07', '2025-05-08 02:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicletype` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `vehicletype`, `created_at`, `updated_at`) VALUES
(4, '10 mt', '2025-05-20 07:23:42', '2025-05-20 07:23:42'),
(5, '9 mt', '2025-05-20 07:23:56', '2025-05-20 07:23:56'),
(6, '3 mt', '2025-05-20 07:24:07', '2025-05-20 07:24:07'),
(7, '4 mt', '2025-05-20 07:24:19', '2025-05-20 07:24:19'),
(8, '8mt', '2025-05-22 02:06:33', '2025-05-22 02:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_type` varchar(255) NOT NULL,
  `voucher_date` date NOT NULL,
  `vouchers` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('from','to','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_type`, `voucher_date`, `vouchers`, `created_at`, `updated_at`, `type`) VALUES
(57, 'Purchase', '2025-06-24', '\"[{\\\"voucher_no\\\":\\\"VOR854\\\",\\\"from_account\\\":\\\"156\\\",\\\"to_account\\\":\\\"153\\\",\\\"amount\\\":\\\"5000\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"Narration TEXT\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":\\\"20\\\"}]\"', '2025-06-23 00:43:55', '2025-06-23 00:43:55', 'from'),
(58, 'Expense', '2025-06-19', '\"[{\\\"voucher_no\\\":\\\"VOR885\\\",\\\"from_account\\\":\\\"159\\\",\\\"to_account\\\":\\\"154\\\",\\\"amount\\\":\\\"5000\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"Narration\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":\\\"12\\\"}]\"', '2025-06-23 00:46:41', '2025-06-23 00:46:41', 'from'),
(59, 'Purchase', '1997-11-24', '\"[{\\\"voucher_no\\\":\\\"Sequi consectetur ut\\\",\\\"from_account\\\":\\\"156\\\",\\\"to_account\\\":\\\"153\\\",\\\"amount\\\":\\\"700000\\\",\\\"assigned_to\\\":null,\\\"narration\\\":\\\"Delectus nesciunt\\\",\\\"tally_narration\\\":\\\"Quo autem et aut sit\\\",\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":\\\"12\\\"}]\"', '2025-06-23 00:48:54', '2025-06-24 00:51:01', 'from'),
(60, 'Expense', '1996-05-12', '\"[{\\\"voucher_no\\\":\\\"Ipsa odit voluptate\\\",\\\"from_account\\\":\\\"159\\\",\\\"to_account\\\":\\\"155\\\",\\\"amount\\\":\\\"900000\\\",\\\"assigned_to\\\":null,\\\"narration\\\":\\\"Dolor quod numquam n\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"12\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":\\\"2\\\"}]\"', '2025-06-23 00:50:47', '2025-06-24 01:28:08', 'from'),
(61, 'Sales', '2025-06-20', '\"[{\\\"voucher_no\\\":\\\"VOR7545\\\",\\\"from_account\\\":\\\"153\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"250000\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 00:51:53', '2025-06-23 00:51:53', 'from'),
(62, 'Sales', '1980-02-28', '\"[{\\\"voucher_no\\\":\\\"Voluptatem Excepteu\\\",\\\"from_account\\\":\\\"157\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"98000\\\",\\\"assigned_to\\\":null,\\\"narration\\\":\\\"Odit reprehenderit s\\\",\\\"tally_narration\\\":\\\"Pariatur Expedita l\\\",\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 00:52:15', '2025-06-23 00:52:15', 'from'),
(63, 'Contra', '2007-01-22', '\"[{\\\"voucher_no\\\":\\\"Eligendi ut ex delec\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"55\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"Id amet dignissimo\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS34556\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 00:53:11', '2025-06-23 00:53:11', 'from'),
(64, 'Contra', '2025-06-26', '\"[{\\\"voucher_no\\\":\\\"VOR854\\\",\\\"from_account\\\":\\\"158\\\",\\\"to_account\\\":\\\"154\\\",\\\"amount\\\":\\\"5600\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS345745\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 00:53:43', '2025-06-23 00:53:43', 'from'),
(65, 'Journal', '2019-12-08', '\"[{\\\"voucher_no\\\":\\\"Quo in in porro dolo\\\",\\\"from_account\\\":\\\"158\\\",\\\"to_account\\\":\\\"159\\\",\\\"amount\\\":\\\"99\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"In sint magnam quas\\\",\\\"tally_narration\\\":\\\"Assumenda dicta veni\\\",\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 00:54:14', '2025-06-23 00:54:14', 'from'),
(66, 'Journal', '1994-01-16', '\"[{\\\"voucher_no\\\":\\\"Mollit dolores atque\\\",\\\"from_account\\\":\\\"157\\\",\\\"to_account\\\":\\\"156\\\",\\\"amount\\\":\\\"90000\\\",\\\"assigned_to\\\":\\\"Entity X\\\",\\\"narration\\\":\\\"Culpa enim ut error\\\",\\\"tally_narration\\\":\\\"Quas doloremque in d\\\",\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 00:54:41', '2025-06-23 00:54:41', 'from'),
(82, 'Payment', '1973-10-16', '\"[{\\\"voucher_no\\\":\\\"Delectus animi ips\\\",\\\"from_account\\\":\\\"161\\\",\\\"to_account\\\":\\\"153\\\",\\\"amount\\\":\\\"240\\\",\\\"assigned_to\\\":null,\\\"narration\\\":\\\"Similique ratione la\\\",\\\"tally_narration\\\":\\\"Voluptates odio exer\\\",\\\"against_voucher\\\":[{\\\"label\\\":\\\"Expense - PALTA FERTILIZERS  \\\\u2192 VALVO MANAGE PVT LTD INDIA (2025-06-19) \\\\u2192 \\\\u20b95000\\\",\\\"amount\\\":5000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS3454\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 04:52:48', '2025-06-24 01:26:14', 'from'),
(85, 'Receipt', '2025-06-25', '\"[{\\\"voucher_no\\\":\\\"VOR1234\\\",\\\"from_account\\\":\\\"153\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"kkj\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":[{\\\"label\\\":\\\"Sales - AMAZOON MANAGE PVT LTD INDIA \\\\u2192 FLIPKART PVT LTD IN (1980-02-28) \\\\u2192 \\\\u20b998000\\\",\\\"amount\\\":98000}],\\\"transaction_id\\\":\\\"TRDS385432\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 07:10:28', '2025-06-23 07:10:28', 'from'),
(86, 'Receipt', '2025-06-23', '\"[{\\\"voucher_no\\\":\\\"VOR1\\\",\\\"from_account\\\":\\\"159\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":[{\\\"label\\\":\\\"Sales - GOOGLE PVT LTD BEST  \\\\u2192 FLIPKART PVT LTD IN (2025-06-20) \\\\u2192 \\\\u20b9250000\\\",\\\"amount\\\":250000}],\\\"transaction_id\\\":\\\"TRDS385432\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 07:12:20', '2025-06-23 07:12:20', 'from'),
(87, 'Receipt', '2025-06-23', '\"[{\\\"voucher_no\\\":\\\"VOR1234\\\",\\\"from_account\\\":\\\"159\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"5000\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"text\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":[{\\\"label\\\":\\\"Sales - GOOGLE PVT LTD BEST  \\\\u2192 FLIPKART PVT LTD IN (2025-06-20) \\\\u2192 \\\\u20b9250000\\\",\\\"amount\\\":250000}],\\\"transaction_id\\\":\\\"TRDS345\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 07:13:48', '2025-06-23 07:13:48', 'from'),
(88, 'Receipt', '2025-06-24', '\"[{\\\"voucher_no\\\":\\\"VOR1234\\\",\\\"from_account\\\":\\\"159\\\",\\\"to_account\\\":\\\"158\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":[{\\\"label\\\":\\\"Sales - GOOGLE PVT LTD BEST  \\\\u2192 FLIPKART PVT LTD IN (2025-06-20) \\\\u2192 \\\\u20b9250000\\\",\\\"amount\\\":250000}],\\\"transaction_id\\\":\\\"TRDS3854\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-23 07:36:17', '2025-06-23 07:36:17', 'from'),
(89, 'Payment', '2025-06-25', '\"[{\\\"voucher_no\\\":\\\"VOR1234\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"156\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Purchase - DELIVORN PVT LTD OUT \\\\u2192 GOOGLE PVT LTD BEST  (2025-06-24) \\\\u2192 \\\\u20b95000\\\",\\\"amount\\\":5000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS345\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 00:41:18', '2025-06-24 00:49:19', 'from'),
(90, 'Payment', '2025-06-25', '\"[{\\\"voucher_no\\\":\\\"VOR1854\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"153\\\",\\\"amount\\\":\\\"2000\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"EEWR\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Purchase - DELIVORN PVT LTD OUT \\\\u2192 GOOGLE PVT LTD BEST  (1997-11-24) \\\\u2192 \\\\u20b9700000\\\",\\\"amount\\\":700000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS385432\\\",\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 00:50:29', '2025-06-24 00:51:37', 'from'),
(91, 'Payment', '2025-06-04', '\"[{\\\"voucher_no\\\":\\\"VOR6757\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"156\\\",\\\"amount\\\":\\\"200\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"TEST\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Expense - PALTA FERTILIZERS  \\\\u2192 VALVO MANAGE PVT LTD INDIA (2025-06-19) \\\\u2192 \\\\u20b95000\\\",\\\"amount\\\":5000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS345\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 00:56:37', '2025-06-24 00:57:28', 'from'),
(92, 'Payment', '2025-06-25', '\"[{\\\"voucher_no\\\":\\\"VOR67\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"156\\\",\\\"amount\\\":\\\"600\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"TEST\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Purchase - DELIVORN PVT LTD OUT \\\\u2192 GOOGLE PVT LTD BEST  (1997-11-24) \\\\u2192 \\\\u20b9700000\\\",\\\"amount\\\":700000},{\\\"label\\\":\\\"Expense - PALTA FERTILIZERS  \\\\u2192 VALVO MANAGE PVT LTD INDIA (2025-06-19) \\\\u2192 \\\\u20b95000\\\",\\\"amount\\\":5000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS345\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 01:01:38', '2025-06-24 01:01:38', 'from'),
(93, 'Payment', '2025-06-10', '\"[{\\\"voucher_no\\\":\\\"VOR854\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"159\\\",\\\"amount\\\":\\\"200\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"TEST\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Expense - PALTA FERTILIZERS  \\\\u2192 VALVO MANAGE PVT LTD INDIA (2025-06-19) \\\\u2192 \\\\u20b95000\\\",\\\"amount\\\":5000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS3454\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 01:08:47', '2025-06-24 01:08:47', 'from'),
(94, 'Payment', '2025-06-18', '\"[{\\\"voucher_no\\\":\\\"VOR745\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"155\\\",\\\"amount\\\":\\\"100000\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"TEST\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Expense - PALTA FERTILIZERS  \\\\u2192 KRL TECH OUT OFF INDIA (1996-05-12) \\\\u2192 \\\\u20b939\\\",\\\"amount\\\":39}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS345\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 01:09:52', '2025-06-24 01:27:18', 'from'),
(95, 'Payment', '2025-06-11', '\"[{\\\"voucher_no\\\":\\\"VOR1234\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"153\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Purchase - DELIVORN PVT LTD OUT \\\\u2192 GOOGLE PVT LTD BEST  (1997-11-24) \\\\u2192 \\\\u20b9700000\\\",\\\"amount\\\":700000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS37\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 01:23:31', '2025-06-24 01:23:31', 'from'),
(96, 'Payment', '2025-06-20', '\"[{\\\"voucher_no\\\":\\\"VOR85\\\",\\\"from_account\\\":\\\"158\\\",\\\"to_account\\\":\\\"159\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"testrt\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Expense - PALTA FERTILIZERS  \\\\u2192 KRL TECH OUT OFF INDIA (1996-05-12) \\\\u2192 \\\\u20b9900000\\\",\\\"amount\\\":900000}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS38\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 01:30:10', '2025-06-24 01:30:10', 'from'),
(97, 'Purchase', '1996-11-09', '\"[{\\\"voucher_no\\\":\\\"Explicabo Debitis u\\\",\\\"from_account\\\":\\\"156\\\",\\\"to_account\\\":\\\"155\\\",\\\"amount\\\":\\\"4400\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"Aperiam cupidatat et\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":null,\\\"transaction_id\\\":null,\\\"credit_day\\\":\\\"15\\\",\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":\\\"34\\\"}]\"', '2025-06-24 02:30:51', '2025-06-24 02:30:51', 'from'),
(98, 'Payment', '2025-06-25', '\"[{\\\"voucher_no\\\":\\\"VOR127\\\",\\\"from_account\\\":\\\"154\\\",\\\"to_account\\\":\\\"153\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Purchase - DELIVORN PVT LTD OUT \\\\u2192 KRL TECH OUT OFF INDIA (1996-11-09) \\\\u2192 \\\\u20b94400\\\",\\\"amount\\\":4400}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS34574\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 02:32:05', '2025-06-24 02:32:05', 'from'),
(99, 'Payment', '2025-06-11', '\"[{\\\"voucher_no\\\":\\\"VOR126\\\",\\\"from_account\\\":\\\"158\\\",\\\"to_account\\\":\\\"155\\\",\\\"amount\\\":\\\"500\\\",\\\"assigned_to\\\":\\\"Person B\\\",\\\"narration\\\":\\\"test\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":[{\\\"label\\\":\\\"Purchase - DELIVORN PVT LTD OUT \\\\u2192 KRL TECH OUT OFF INDIA (1996-11-09) \\\\u2192 \\\\u20b94400\\\",\\\"amount\\\":4400}],\\\"sales_voucher\\\":null,\\\"transaction_id\\\":\\\"TRDS34574\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 02:33:16', '2025-06-24 02:33:16', 'from'),
(100, 'Receipt', '2011-02-24', '\"[{\\\"voucher_no\\\":\\\"Voluptatem sit dolor\\\",\\\"from_account\\\":\\\"153\\\",\\\"to_account\\\":\\\"154\\\",\\\"amount\\\":\\\"190\\\",\\\"assigned_to\\\":\\\"Person A\\\",\\\"narration\\\":\\\"Aut sunt fuga Non c\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":[{\\\"label\\\":\\\"Sales - GOOGLE PVT LTD BEST  \\\\u2192 FLIPKART PVT LTD IN (2025-06-20) \\\\u2192 \\\\u20b9250000\\\",\\\"amount\\\":250000}],\\\"transaction_id\\\":\\\"TRDS345\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 04:03:27', '2025-06-24 04:03:27', 'from'),
(101, 'Receipt', '1980-08-21', '\"[{\\\"voucher_no\\\":\\\"Aut sit voluptates\\\",\\\"from_account\\\":\\\"153\\\",\\\"to_account\\\":\\\"154\\\",\\\"amount\\\":\\\"220\\\",\\\"assigned_to\\\":null,\\\"narration\\\":\\\"Ipsam maiores et pro\\\",\\\"tally_narration\\\":null,\\\"against_voucher\\\":null,\\\"sales_voucher\\\":[{\\\"label\\\":\\\"Sales - AMAZOON MANAGE PVT LTD INDIA \\\\u2192 FLIPKART PVT LTD IN (1980-02-28) \\\\u2192 \\\\u20b998000\\\",\\\"amount\\\":98000}],\\\"transaction_id\\\":\\\"Omnis est qui conseq\\\",\\\"credit_day\\\":null,\\\"cash_credit\\\":\\\"Credit\\\",\\\"tds_payable\\\":null}]\"', '2025-06-24 07:03:50', '2025-06-24 07:03:50', 'from');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `incharge` varchar(244) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `warehouse_name`, `address`, `incharge`, `created_at`, `updated_at`) VALUES
(5, 'indore bajar', 'indore', 'kanha', '2025-04-03 04:34:31', '2025-04-03 05:13:52'),
(6, 'dfdf', 'fdf', 'fdff', '2025-04-03 04:47:37', '2025-04-03 04:47:37'),
(7, 'f', 'dff', 'fdfd', '2025-04-04 02:05:46', '2025-04-04 02:05:46'),
(8, 'rrrer', 'df', 'dfdf', '2025-04-04 08:12:03', '2025-04-04 08:12:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_employee_id_foreign` (`admin_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demand_listings`
--
ALTER TABLE `demand_listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `freight_bill`
--
ALTER TABLE `freight_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ledger_master`
--
ALTER TABLE `ledger_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`);

--
-- Indexes for table `package_types`
--
ALTER TABLE `package_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_listings`
--
ALTER TABLE `product_listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sells`
--
ALTER TABLE `product_sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redeem_products`
--
ALTER TABLE `redeem_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refer_earn`
--
ALTER TABLE `refer_earn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `task_managements`
--
ALTER TABLE `task_managements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tyres`
--
ALTER TABLE `tyres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_no` (`vehicle_no`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `demand_listings`
--
ALTER TABLE `demand_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freight_bill`
--
ALTER TABLE `freight_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger_master`
--
ALTER TABLE `ledger_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `package_types`
--
ALTER TABLE `package_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_listings`
--
ALTER TABLE `product_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_sells`
--
ALTER TABLE `product_sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `redeem_products`
--
ALTER TABLE `redeem_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `refer_earn`
--
ALTER TABLE `refer_earn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `task_managements`
--
ALTER TABLE `task_managements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tyres`
--
ALTER TABLE `tyres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
