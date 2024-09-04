-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2024 at 04:36 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_salem`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_names`
--

CREATE TABLE `account_names` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_names`
--

INSERT INTO `account_names` (`id`, `name`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Benevolent', 1, NULL, NULL, '2024-08-31 15:50:55', '2024-08-31 15:50:55'),
(2, 'Building', 1, NULL, NULL, '2024-08-31 15:51:08', '2024-08-31 15:51:08'),
(3, 'General Assessment', 1, NULL, NULL, '2024-08-31 15:51:21', '2024-08-31 15:51:21'),
(4, 'Electricity', 1, NULL, NULL, '2024-08-31 15:51:47', '2024-08-31 15:51:47'),
(5, 'Tithes / Offerings', 1, NULL, NULL, '2024-08-31 15:52:05', '2024-08-31 15:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"d\";s:8:\"position\";s:1:\"e\";s:9:\"parent_id\";}s:11:\"permissions\";a:18:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"Dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:1;s:1:\"e\";i:0;}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"Post Offering\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:2;s:1:\"e\";i:0;}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"Payment\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:5;s:1:\"e\";i:0;}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"Members\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:8;s:1:\"e\";i:0;}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:7:\"Account\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:11;s:1:\"e\";i:0;}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:17;s:1:\"e\";i:0;}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"Transfer Funds\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:14;s:1:\"e\";i:0;}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:8:\"Settings\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:18;s:1:\"e\";i:0;}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"Edit Offering\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:3;s:1:\"e\";i:2;}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"Delete Offering\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:4;s:1:\"e\";i:2;}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:12:\"Edit Payment\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:6;s:1:\"e\";i:3;}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:14:\"Delete Payment\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:7;s:1:\"e\";i:3;}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:11:\"Edit Member\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:9;s:1:\"e\";i:4;}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:13:\"Delete Member\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:10;s:1:\"e\";i:4;}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:12:\"Edit Account\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:12;s:1:\"e\";i:5;}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"Delete Account\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:13;s:1:\"e\";i:5;}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:19:\"Edit Transfer Funds\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:15;s:1:\"e\";i:7;}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:22:\"Delete  Transfer Funds\";s:1:\"c\";s:3:\"web\";s:1:\"d\";i:16;s:1:\"e\";i:7;}}s:5:\"roles\";a:0:{}}', 1725294225);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `check_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` bigint UNSIGNED NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `member_id`, `date`, `amount`, `check_number`, `type_id`, `account_id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 14615, '2024-09-01', 100, NULL, 1, 1, 1, NULL, NULL, '2024-08-31 16:03:59', '2024-08-31 16:03:59'),
(2, 2, '2024-09-01', 223, NULL, 1, 1, 1, NULL, NULL, '2024-09-01 03:03:25', '2024-09-01 03:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(11, '0001_01_01_000000_create_users_table', 2),
(12, '2024_08_17_192020_user_modify_migration', 2),
(13, '2024_08_19_184613_create_payment_types_table', 3),
(15, '2024_08_20_110634_create_earnings_table', 4),
(16, '2024_08_20_134656_create_starting_balances_table', 5),
(18, '2024_08_27_164552_create_permission_tables', 7),
(21, '2024_08_20_110332_create_account_names_table', 9),
(23, '2024_08_31_085759_create_post_payments_table', 10),
(27, '2024_08_26_212639_create_payments_table', 12),
(30, '2024_08_31_202235_create_transactions_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 2),
(10, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 13303),
(9, 'App\\Models\\User', 13303),
(1, 'App\\Models\\User', 14615);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 13303),
(2, 'App\\Models\\User', 14615);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `payable_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `type_id` bigint UNSIGNED NOT NULL,
  `from_account` bigint UNSIGNED NOT NULL,
  `check_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payable_to`, `date`, `amount`, `type_id`, `from_account`, `check_number`, `notes`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Payment to name', '2024-09-01', 100, 1, 1, NULL, 'payment done', 1, NULL, NULL, '2024-08-31 16:07:41', '2024-08-31 16:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `payment_type_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Cash', NULL, '2024-08-19 12:55:02', '2024-08-19 12:55:02'),
(2, 'Check', NULL, '2024-08-19 12:55:02', '2024-08-19 12:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `parent_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `position`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'web', 1, 0, '2024-08-27 14:06:12', '2024-08-31 11:56:23'),
(2, 'Post Offering', 'web', 2, 0, '2024-08-28 07:43:35', '2024-08-31 11:56:23'),
(3, 'Payment', 'web', 5, 0, '2024-08-28 07:43:44', '2024-08-31 11:56:23'),
(4, 'Members', 'web', 8, 0, '2024-08-28 07:43:52', '2024-08-31 11:56:23'),
(5, 'Account', 'web', 11, 0, '2024-08-28 07:43:59', '2024-08-31 11:56:23'),
(6, 'Report', 'web', 17, 0, '2024-08-28 07:44:05', '2024-08-31 11:56:08'),
(7, 'Transfer Funds', 'web', 14, 0, '2024-08-28 07:44:13', '2024-08-31 13:33:21'),
(8, 'Settings', 'web', 18, 0, '2024-08-28 07:44:19', '2024-08-31 11:56:08'),
(9, 'Edit Offering', 'web', 3, 2, '2024-08-31 11:44:26', '2024-08-31 11:56:23'),
(10, 'Delete Offering', 'web', 4, 2, '2024-08-31 11:52:18', '2024-08-31 11:56:23'),
(11, 'Edit Payment', 'web', 6, 3, '2024-08-31 11:52:48', '2024-08-31 11:56:23'),
(12, 'Delete Payment', 'web', 7, 3, '2024-08-31 11:53:03', '2024-08-31 11:56:23'),
(13, 'Edit Member', 'web', 9, 4, '2024-08-31 11:53:26', '2024-08-31 11:56:23'),
(14, 'Delete Member', 'web', 10, 4, '2024-08-31 11:53:40', '2024-08-31 11:56:23'),
(15, 'Edit Account', 'web', 12, 5, '2024-08-31 11:55:13', '2024-08-31 11:56:23'),
(16, 'Delete Account', 'web', 13, 5, '2024-08-31 11:55:24', '2024-08-31 11:56:23'),
(17, 'Edit Transfer Funds', 'web', 15, 7, '2024-08-31 11:55:46', '2024-08-31 13:33:29'),
(18, 'Delete  Transfer Funds', 'web', 16, 7, '2024-08-31 11:55:56', '2024-08-31 13:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `post_payments`
--

CREATE TABLE `post_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `from_account` bigint UNSIGNED NOT NULL,
  `to_account` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `notes` varchar(999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_payments`
--

INSERT INTO `post_payments` (`id`, `from_account`, `to_account`, `date`, `amount`, `notes`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2024-09-01', 200, 'transfer', 1, NULL, NULL, '2024-08-31 16:29:17', '2024-08-31 16:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-08-27 17:08:50', '2024-08-28 17:08:50'),
(2, 'User', 'web', '2024-08-27 13:35:55', '2024-08-27 13:48:22');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('QQKXYn82n96ooApMPrYYKsEuxX8pJZTWIJbp29OV', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNXoxRGY1dDdzcDl1enFhbDdFSXFVdEhoajc2ZU1yRkpDTWh4V1pnMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3QvbmV3X3NhbGVtL21lbWJlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1725208355);

-- --------------------------------------------------------

--
-- Table structure for table `starting_balances`
--

CREATE TABLE `starting_balances` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `starting_balances`
--

INSERT INTO `starting_balances` (`id`, `date`, `amount`, `account_id`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '2024-08-31', 200, 1, 1, NULL, NULL, '2024-08-31 15:50:55', '2024-08-31 15:50:55'),
(2, '2024-08-31', 300, 2, 1, NULL, NULL, '2024-08-31 15:51:08', '2024-08-31 15:51:08'),
(3, '2024-08-31', 150, 3, 1, NULL, NULL, '2024-08-31 15:51:21', '2024-08-31 15:51:21'),
(4, '2024-08-31', 100, 4, 1, NULL, NULL, '2024-08-31 15:51:47', '2024-08-31 15:51:47'),
(5, '2024-08-31', 50, 5, 1, NULL, NULL, '2024-08-31 15:52:05', '2024-08-31 15:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `post_offering_id` bigint UNSIGNED DEFAULT NULL,
  `payment_id` bigint UNSIGNED DEFAULT NULL,
  `tranfer_id` bigint UNSIGNED DEFAULT NULL,
  `starting_balance_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `check_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` bigint UNSIGNED DEFAULT NULL,
  `account_id` bigint UNSIGNED NOT NULL,
  `payable_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(999) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_status` int NOT NULL COMMENT '1=post offering; 2=payment; 3=transter_in; 4=tranfer_out; 5=starting_balance',
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `member_id`, `post_offering_id`, `payment_id`, `tranfer_id`, `starting_balance_id`, `date`, `amount`, `check_number`, `type_id`, `account_id`, `payable_to`, `notes`, `transaction_status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 1, '2024-08-31', 200, NULL, NULL, 1, NULL, 'Staring Balance', 5, 1, NULL, NULL, '2024-08-31 15:50:55', '2024-08-31 15:50:55'),
(2, NULL, NULL, NULL, NULL, 2, '2024-08-31', 300, NULL, NULL, 2, NULL, 'Staring Balance', 5, 1, NULL, NULL, '2024-08-31 15:51:08', '2024-08-31 15:51:08'),
(3, NULL, NULL, NULL, NULL, 3, '2024-08-31', 150, NULL, NULL, 3, NULL, 'Staring Balance', 5, 1, NULL, NULL, '2024-08-31 15:51:21', '2024-08-31 15:51:21'),
(4, NULL, NULL, NULL, NULL, 4, '2024-08-31', 100, NULL, NULL, 4, NULL, 'Staring Balance', 5, 1, NULL, NULL, '2024-08-31 15:51:47', '2024-08-31 15:51:47'),
(5, NULL, NULL, NULL, NULL, 5, '2024-08-31', 50, NULL, NULL, 5, NULL, 'Staring Balance', 5, 1, NULL, NULL, '2024-08-31 15:52:05', '2024-08-31 15:52:05'),
(6, 14615, 1, NULL, NULL, NULL, '2024-09-01', 100, NULL, 1, 1, NULL, NULL, 1, 1, NULL, NULL, '2024-08-31 16:03:59', '2024-08-31 16:03:59'),
(7, NULL, NULL, 1, NULL, NULL, '2024-09-01', 100, NULL, 1, 1, 'Payment to name', 'payment done', 2, 1, NULL, NULL, '2024-08-31 16:07:41', '2024-08-31 16:07:41'),
(8, NULL, NULL, NULL, 1, NULL, '2024-09-01', 200, NULL, NULL, 1, NULL, 'transfer', 4, 1, NULL, NULL, '2024-08-31 16:29:17', '2024-08-31 16:29:17'),
(9, NULL, NULL, NULL, 1, NULL, '2024-09-01', 200, NULL, NULL, 2, NULL, 'transfer', 3, 1, NULL, NULL, '2024-08-31 16:29:17', '2024-08-31 16:29:17'),
(10, 2, 2, NULL, NULL, NULL, '2024-09-01', 223, NULL, 1, 1, NULL, NULL, 1, 1, NULL, NULL, '2024-09-01 03:03:25', '2024-09-01 03:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `birthday`, `address`, `city`, `state`, `zip`, `phone`, `role`, `deleted_at`) VALUES
(1, 'Prof. Adrian Rogahn update', 'lilian.mcglynn@example.com', NULL, '$2y$12$xssTAbaerVnxSbIEVy8J0eX0C1cyM/Bb431FG6sGVeeHeXxzTORXS', NULL, '2024-08-18 06:01:33', '2024-08-18 07:41:41', '2019-01-01', '81604 Rempel Canyon Suite 199Naderchester, HI 63928 update', 'East Dayna update', 'NY update', '29826 update', '+17262303274', 'admin', NULL),
(2, 'Aliyah Rutherford', 'bbrekke@example.net', NULL, '$2y$12$xssTAbaerVnxSbIEVy8J0eX0C1cyM/Bb431FG6sGVeeHeXxzTORXS', NULL, '2024-08-18 06:01:33', '2024-08-18 06:01:33', '1971-09-20', '99672 Dickinson Oval Apt. 029\nJanieville, MN 57007', 'East Alexzander', 'NH', '27902-7362', '(806) 452-6611', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_names`
--
ALTER TABLE `account_names`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_names_created_by_foreign` (`created_by`),
  ADD KEY `account_names_updated_by_foreign` (`updated_by`);

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
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `earnings_member_id_foreign` (`member_id`),
  ADD KEY `earnings_type_id_foreign` (`type_id`),
  ADD KEY `earnings_account_id_foreign` (`account_id`),
  ADD KEY `earnings_created_by_foreign` (`created_by`),
  ADD KEY `earnings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_type_id_foreign` (`type_id`),
  ADD KEY `payments_from_account_foreign` (`from_account`),
  ADD KEY `payments_created_by_foreign` (`created_by`),
  ADD KEY `payments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `post_payments`
--
ALTER TABLE `post_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_payments_from_account_foreign` (`from_account`),
  ADD KEY `post_payments_to_account_foreign` (`to_account`),
  ADD KEY `post_payments_created_by_foreign` (`created_by`),
  ADD KEY `post_payments_updated_by_foreign` (`updated_by`);

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
-- Indexes for table `starting_balances`
--
ALTER TABLE `starting_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `starting_balances_account_id_foreign` (`account_id`),
  ADD KEY `starting_balances_created_by_foreign` (`created_by`),
  ADD KEY `starting_balances_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_account_id_foreign` (`account_id`),
  ADD KEY `transactions_created_by_foreign` (`created_by`),
  ADD KEY `transactions_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_names`
--
ALTER TABLE `account_names`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `post_payments`
--
ALTER TABLE `post_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `starting_balances`
--
ALTER TABLE `starting_balances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_names`
--
ALTER TABLE `account_names`
  ADD CONSTRAINT `account_names_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_names_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `earnings`
--
ALTER TABLE `earnings`
  ADD CONSTRAINT `earnings_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `account_names` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earnings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earnings_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earnings_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `payment_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `earnings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_from_account_foreign` FOREIGN KEY (`from_account`) REFERENCES `account_names` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `payment_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `post_payments`
--
ALTER TABLE `post_payments`
  ADD CONSTRAINT `post_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_payments_from_account_foreign` FOREIGN KEY (`from_account`) REFERENCES `account_names` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_payments_to_account_foreign` FOREIGN KEY (`to_account`) REFERENCES `account_names` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `starting_balances`
--
ALTER TABLE `starting_balances`
  ADD CONSTRAINT `starting_balances_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `account_names` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `starting_balances_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `starting_balances_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `account_names` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
