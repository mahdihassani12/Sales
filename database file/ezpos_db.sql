-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2018 at 12:13 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newpoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_qty` double NOT NULL,
  `item` int(11) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjustments`
--

INSERT INTO `adjustments` (`id`, `date`, `reference_no`, `store_id`, `document`, `total_qty`, `item`, `note`, `created_at`, `updated_at`) VALUES
(1, '2018-09-26', 'adr-20180925-111216', 2, NULL, 2, 1, 'bottle has broken...', '2018-09-25 05:12:16', '2018-10-15 21:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `billers`
--

CREATE TABLE `billers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'frootooos', 'frootooo.jpg', 1, '2018-09-21 23:56:00', '2018-09-21 23:57:07'),
(2, 'tttt', 'tttt.jpg', 0, '2018-09-26 02:42:12', '2018-09-26 02:42:30'),
(3, 'Samsung', 'Samsung.png', 1, '2018-10-17 23:47:51', '2018-10-17 23:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'fruit', 2, 1, '2018-09-17 21:48:51', '2018-09-17 21:49:30'),
(2, 'food', NULL, 1, '2018-09-17 21:49:14', '2018-09-17 21:49:14'),
(3, 'IT', NULL, 1, '2018-09-22 00:24:20', '2018-09-22 00:24:20'),
(4, 'Accessories', NULL, 1, '2018-10-07 05:21:21', '2018-10-07 05:21:21'),
(5, 'electronics', NULL, 1, '2018-10-17 23:43:20', '2018-10-17 23:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `address` text,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `extra1` varchar(100) DEFAULT NULL,
  `extra2` varchar(100) DEFAULT NULL,
  `extra3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `name`, `address`, `username`, `password`, `email`, `phone`, `extra1`, `extra2`, `extra3`) VALUES
(1, 'company 1', 'Afghanistan  - Kabul', 'ali', '12345', 'ahmadi@yahoo.com', '0788444233', '1234', '123', '12'),
(5, 'techlight com', 'Afghanistan - Kabul', 'ADMIN', 'admin', 'admin@yahoo.com', '998898933', 'note1', 'note2', 'note3');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country` varchar(64) NOT NULL,
  `cost_shiping` varchar(64) NOT NULL,
  `sale_shipping` varchar(64) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country`, `cost_shiping`, `sale_shipping`, `company_id`) VALUES
(1, 'Afghanistan', '500', '400', 5),
(2, 'Iraq', '700', '780', 5);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `expense` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_group_id`, `name`, `company_name`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`, `deposit`, `expense`) VALUES
(1, 1, 'walk-in-customer', NULL, NULL, '11112222', 'khulshi', 'chittagong', NULL, NULL, 'bangladesh', 1, '2018-09-24 23:39:54', '2018-10-12 07:44:29', 500, 0),
(2, 1, 'aaa', NULL, NULL, 'ww3', 'eqw', 'wrq', NULL, NULL, NULL, 0, '2018-09-25 00:46:44', '2018-09-25 00:48:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `name`, `percentage`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'general', '0', 1, '2018-09-24 23:35:20', '2018-09-24 23:35:52'),
(2, 'distribut0r', '-10', 0, '2018-09-24 23:37:03', '2018-09-24 23:37:47'),
(3, 'distributor', '-10', 1, '2018-09-24 23:37:56', '2018-09-24 23:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale_id` int(11) NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivered_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recieved_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `date`, `reference_no`, `sale_id`, `address`, `delivered_by`, `recieved_by`, `file`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, '2018-10-08', 'dr-20181008-050304', 8, 'khulshi chittagong bangladesh', NULL, NULL, NULL, NULL, 'packing', '2018-10-07 23:03:09', '2018-10-07 23:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `amount`, `customer_id`, `user_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 500, 1, 1, NULL, '2018-10-07 23:15:30', '2018-10-07 23:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `date`, `reference_no`, `expense_category_id`, `store_id`, `amount`, `note`, `created_at`, `updated_at`) VALUES
(1, '2018-10-08', 'er-20181008-053620', 1, 1, 100, NULL, '2018-10-07 23:36:20', '2018-10-07 23:36:20');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `code`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '16829406', 'washing', 1, '2018-09-25 05:54:41', '2018-09-25 05:58:01'),
(2, '78103659', 'saD', 0, '2018-09-25 05:58:09', '2018-09-25 05:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zero_balance` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `created_at`, `updated_at`, `currency`, `color`, `zero_balance`) VALUES
(1, 'EZPOS', 'logo.png', '2018-07-06 06:13:11', '2018-10-25 01:55:18', 'USD', '#800000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `card_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `expense` double NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_cards`
--

INSERT INTO `gift_cards` (`id`, `card_no`, `amount`, `expense`, `customer_id`, `user_id`, `expired_date`, `created_by`, `is_active`, `created_at`, `updated_at`) VALUES
(3, '4123620643178097', 550, 2000, 1, NULL, '2018-12-31', 1, 1, '2018-09-29 22:47:04', '2018-10-25 07:45:54'),
(4, '7130653894998072', 200, 0, NULL, 1, '2018-10-05', 1, 0, '2018-09-30 00:48:50', '2018-09-30 00:51:37'),
(5, '3179960248701260', 22, 0, 1, NULL, '2018-10-26', 1, 0, '2018-10-01 22:25:45', '2018-10-01 22:28:58'),
(6, '9721308394631214', 100, 0, NULL, 1, '2018-10-02', 1, 0, '2018-10-01 22:30:12', '2018-10-01 22:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `gift_card_recharges`
--

CREATE TABLE `gift_card_recharges` (
  `id` int(10) UNSIGNED NOT NULL,
  `gift_card_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_card_recharges`
--

INSERT INTO `gift_card_recharges` (`id`, `gift_card_id`, `amount`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 3, 200, 1, '2018-09-29 22:55:39', '2018-09-29 22:55:39'),
(3, 3, 100, 1, '2018-09-29 23:58:34', '2018-09-29 23:58:34'),
(4, 3, 100, 1, '2018-10-16 01:53:45', '2018-10-16 01:53:45'),
(5, 3, 50, 1, '2018-10-16 01:55:49', '2018-10-16 01:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'en', '2018-07-07 22:59:17', '2018-10-25 06:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(35, '2014_10_12_000000_create_users_table', 1),
(36, '2014_10_12_100000_create_password_resets_table', 1),
(37, '2018_02_17_060412_create_categories_table', 1),
(38, '2018_02_20_035727_create_brands_table', 1),
(39, '2018_02_25_100635_create_suppliers_table', 1),
(40, '2018_02_27_101619_create_store_table', 1),
(41, '2018_03_04_041317_create_taxes_table', 1),
(42, '2018_03_10_061915_create_customer_groups_table', 1),
(43, '2018_03_10_090534_create_customers_table', 1),
(44, '2018_03_11_095547_create_billers_table', 1),
(45, '2018_04_05_054401_create_products_table', 1),
(46, '2018_04_06_133606_create_purchases_table', 1),
(47, '2018_04_06_154600_create_product_purchases_table', 1),
(48, '2018_04_06_154915_create_product_store_table', 1),
(49, '2018_04_10_085927_create_sales_table', 1),
(50, '2018_04_10_090133_create_product_sales_table', 1),
(51, '2018_04_10_090254_create_payments_table', 1),
(52, '2018_04_10_090341_create_payment_with_cheque_table', 1),
(53, '2018_04_10_090509_create_payment_with_credit_card_table', 1),
(54, '2018_04_14_121802_create_transfers_table', 1),
(55, '2018_04_14_121913_create_product_transfer_table', 1),
(56, '2018_05_13_082847_add_payment_id_and_change_sale_id_to_payments_table', 1),
(57, '2018_05_13_090906_change_customer_id_to_payment_with_credit_card_table', 1),
(58, '2018_05_20_054532_create_adjustments_table', 1),
(59, '2018_05_20_054859_create_product_adjustments_table', 1),
(60, '2018_05_21_163419_create_returns_table', 1),
(61, '2018_05_21_163443_create_product_returns_table', 1),
(62, '2018_06_02_050905_create_roles_table', 1),
(63, '2018_06_02_073430_add_columns_to_users_table', 1),
(64, '2018_06_03_053738_create_permission_tables', 1),
(65, '2018_06_21_063736_create_pos_setting_table', 1),
(66, '2018_06_21_094155_add_user_id_to_sales_table', 1),
(67, '2018_06_21_101529_add_user_id_to_purchases_table', 1),
(68, '2018_06_21_103512_add_user_id_to_transfers_table', 1),
(69, '2018_06_23_082427_add_is_deleted_to_users_table', 1),
(70, '2018_06_25_043308_change_email_to_users_table', 1),
(71, '2018_07_06_115449_create_general_settings_table', 1),
(72, '2018_07_08_043944_create_languages_table', 1),
(73, '2018_07_11_102144_add_user_id_to_returns_table', 1),
(74, '2018_07_11_102334_add_user_id_to_payments_table', 1),
(75, '2018_07_22_130541_add_digital_to_products_table', 1),
(76, '2018_07_24_154250_create_deliveries_table', 1),
(77, '2018_08_16_053336_create_expense_categories_table', 1),
(78, '2018_08_17_115415_create_expenses_table', 1),
(79, '2018_08_18_050418_create_gift_cards_table', 1),
(80, '2018_08_19_063119_create_payment_with_gift_card_table', 1),
(81, '2018_08_25_042333_create_gift_card_recharges_table', 1),
(82, '2018_08_25_101354_add_deposit_expense_to_customers_table', 1),
(83, '2018_09_02_044042_add_keybord_active_to_pos_setting_table', 1),
(84, '2018_09_09_092713_create_payment_with_paypal_table', 1),
(85, '2018_09_10_051254_add_currency_to_general_settings_table', 1),
(86, '2018_09_25_063316_create_deposits_table', 2),
(87, '2018_09_25_103159_add_date_to_adjustments_table', 3),
(88, '2018_09_26_062200_add_date_to_expenses_table', 4),
(90, '2018_09_29_035550_add_date_to_payments_table', 5),
(91, '2018_09_29_114204_add_date_to_deliveries_table', 6),
(92, '2018_10_13_072215_add_store_id_to_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `payment_reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `paying_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `date`, `purchase_id`, `sale_id`, `payment_reference`, `user_id`, `amount`, `paying_method`, `payment_note`, `created_at`, `updated_at`) VALUES
(1, '2018-09-30', 5, NULL, 'ppr-20180924-094547', 1, 15, 'Cheque', NULL, '2018-09-24 03:45:47', '2018-10-16 02:41:33'),
(2, '2018-08-30', NULL, 4, 'spr-20180929-092658', 1, 108.3, 'Cash', NULL, '2018-09-29 03:26:58', '2018-10-01 00:30:38'),
(6, '2018-10-06', NULL, 8, 'spr-20181006-042628', 1, 50, 'Cash', NULL, '2018-10-05 22:26:28', '2018-10-05 22:26:28'),
(9, '2018-10-15', NULL, 21, 'spr-20181015-123552', 1, 83, 'Cash', NULL, '2018-10-15 06:35:52', '2018-10-15 06:35:52'),
(11, '2018-10-15', NULL, 13, 'spr-20181015-052726', 1, 54, 'Cash', NULL, '2018-10-15 11:27:26', '2018-10-15 11:27:26'),
(12, '2018-10-16', NULL, 14, 'spr-20181016-042059', 5, 45, 'Cash', NULL, '2018-10-15 22:20:59', '2018-10-15 22:20:59'),
(16, '2018-10-16', NULL, 19, 'spr-20181016-082844', 1, 12, 'Cash', NULL, '2018-10-16 02:28:44', '2018-10-16 02:28:44'),
(17, '2018-10-16', 9, NULL, 'ppr-20181016-084054', 1, 30, 'Credit Card', NULL, '2018-10-16 02:40:54', '2018-10-16 02:40:54'),
(19, '2018-07-11', 8, NULL, 'ppr-20181018-051642', 1, 275, 'Cash', NULL, '2018-10-17 23:16:42', '2018-10-17 23:16:42'),
(20, '2018-10-18', NULL, 22, 'spr-20181018-065222', 1, 7925, 'Cash', NULL, '2018-10-18 00:52:22', '2018-10-18 00:52:22'),
(21, '2018-10-18', NULL, 23, 'spr-20181018-070046', 1, 8271, 'Cash', NULL, '2018-10-18 01:00:46', '2018-10-18 01:00:46'),
(22, '2018-10-22', NULL, 24, 'spr-20181022-031015', 1, 1665, 'Cash', NULL, '2018-10-21 22:40:15', '2018-10-21 22:40:15'),
(23, '2018-10-22', NULL, 26, 'spr-20181022-031328', 1, 76, 'Cash', NULL, '2018-10-21 22:43:28', '2018-10-21 22:43:28'),
(24, '2018-10-22', NULL, 27, 'spr-20181022-033316', 1, 225, 'Cash', NULL, '2018-10-21 23:03:16', '2018-10-21 23:03:16'),
(25, '2018-10-22', NULL, 28, 'spr-20181022-033612', 1, 96, 'Cash', NULL, '2018-10-21 23:06:12', '2018-10-21 23:06:12'),
(26, '2018-10-22', NULL, 29, 'spr-20181022-080106', 1, 725, 'Cash', NULL, '2018-10-22 03:31:06', '2018-10-22 03:31:06'),
(27, '2018-10-22', NULL, 30, 'spr-20181022-095446', 1, 965, 'Cash', NULL, '2018-10-22 05:24:46', '2018-10-22 05:24:46'),
(28, '2018-10-22', NULL, 31, 'spr-20181022-095856', 1, 4125, 'Cash', 'note jumah', '2018-10-22 05:28:56', '2018-10-22 05:28:56'),
(29, '2018-10-22', NULL, 32, 'spr-20181022-103315', 1, 500, 'Cash', NULL, '2018-10-22 06:03:15', '2018-10-22 06:03:15'),
(30, '2018-10-22', NULL, 33, 'spr-20181022-110625', 1, 12, 'Cash', NULL, '2018-10-22 06:36:25', '2018-10-22 06:36:25'),
(31, '2018-10-23', NULL, 34, 'spr-20181023-034421', 1, 25, 'Cash', NULL, '2018-10-22 23:14:21', '2018-10-22 23:14:21'),
(32, '2018-10-23', NULL, 35, 'spr-20181023-035346', 1, 12, 'Cash', NULL, '2018-10-22 23:23:46', '2018-10-22 23:23:46'),
(33, '2018-10-23', NULL, 36, 'spr-20181023-035429', 1, 25, 'Cash', NULL, '2018-10-22 23:24:29', '2018-10-22 23:24:29'),
(34, '2018-10-23', NULL, 37, 'spr-20181023-054052', 1, 33, 'Paypal', NULL, '2018-10-23 01:10:52', '2018-10-23 01:10:52'),
(35, '2018-10-23', NULL, 39, 'spr-20181023-091658', 1, 198, 'Cash', NULL, '2018-10-23 04:46:58', '2018-10-23 04:46:58'),
(36, '2018-10-23', NULL, 40, 'spr-20181023-092705', 1, 481, 'Cash', NULL, '2018-10-23 04:57:05', '2018-10-23 04:57:05'),
(37, '2018-10-23', NULL, 41, 'spr-20181023-095128', 1, 75, 'Cash', NULL, '2018-10-23 05:21:28', '2018-10-23 05:21:28'),
(38, '2018-10-23', NULL, 42, 'spr-20181023-100059', 1, 33, 'Cash', NULL, '2018-10-23 05:30:59', '2018-10-23 05:30:59'),
(39, '2018-10-23', NULL, 43, 'spr-20181023-100423', 1, 231, 'Cash', NULL, '2018-10-23 05:34:23', '2018-10-23 05:34:23'),
(40, '2018-10-23', NULL, 44, 'spr-20181023-100711', 1, 225, 'Paypal', NULL, '2018-10-23 05:37:11', '2018-10-23 05:37:11'),
(41, '2018-10-23', NULL, 45, 'spr-20181023-101259', 1, 375, 'Cash', NULL, '2018-10-23 05:42:59', '2018-10-23 05:42:59'),
(42, '2018-10-23', NULL, 46, 'spr-20181023-104740', 1, 132, 'Cash', NULL, '2018-10-23 06:17:40', '2018-10-23 06:17:40'),
(43, '2018-10-23', NULL, 47, 'spr-20181023-110016', 1, 149, 'Cash', NULL, '2018-10-23 06:30:16', '2018-10-23 06:30:16'),
(44, '2018-10-23', NULL, 48, 'spr-20181023-110217', 1, 24, 'Cash', NULL, '2018-10-23 06:32:17', '2018-10-23 06:32:17'),
(45, '2018-10-23', NULL, 49, 'spr-20181023-115720', 1, 33, 'Cash', NULL, '2018-10-23 07:27:20', '2018-10-23 07:27:20'),
(46, '2018-10-23', NULL, 50, 'spr-20181023-115812', 1, 180, 'Cash', NULL, '2018-10-23 07:28:12', '2018-10-23 07:28:12'),
(47, '2018-10-24', NULL, 51, 'spr-20181024-073406', 1, 1500, 'Cash', NULL, '2018-10-24 03:04:06', '2018-10-24 03:04:06'),
(48, '2018-10-24', NULL, 52, 'spr-20181024-121523', 1, 75, 'Cash', NULL, '2018-10-24 07:45:23', '2018-10-24 07:45:23'),
(50, '2018-10-25', NULL, 54, 'spr-20181025-110826', 1, 125, 'Cash', NULL, '2018-10-25 06:38:26', '2018-10-25 06:38:26'),
(51, '2018-10-25', NULL, 55, 'spr-20181025-110856', 1, 200, 'Cash', NULL, '2018-10-25 06:38:56', '2018-10-25 06:38:56'),
(52, '2018-10-25', NULL, 56, 'spr-20181025-110939', 1, 300, 'Cash', NULL, '2018-10-25 06:39:39', '2018-10-25 06:39:39'),
(53, '2018-10-25', NULL, 57, 'spr-20181025-111500', 1, 120, 'Cash', NULL, '2018-10-25 06:45:00', '2018-10-25 06:45:00'),
(54, '2018-10-25', NULL, 61, 'spr-20181025-121506', 1, 150, 'Gift Card', NULL, '2018-10-25 07:45:06', '2018-10-25 07:45:06'),
(55, '2018-10-25', NULL, 62, 'spr-20181025-121554', 1, 2000, 'Gift Card', NULL, '2018-10-25 07:45:54', '2018-10-25 07:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_cheque`
--

CREATE TABLE `payment_with_cheque` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `cheque_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_with_cheque`
--

INSERT INTO `payment_with_cheque` (`id`, `payment_id`, `cheque_no`, `created_at`, `updated_at`) VALUES
(1, 1, '1111', '2018-10-16 02:41:33', '2018-10-16 02:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_credit_card`
--

CREATE TABLE `payment_with_credit_card` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_with_credit_card`
--

INSERT INTO `payment_with_credit_card` (`id`, `payment_id`, `customer_id`, `customer_stripe_id`, `charge_id`, `created_at`, `updated_at`) VALUES
(1, 17, NULL, NULL, 'ch_1DLo6nKwOmA8HLXecOkyNgLL', '2018-10-16 02:40:57', '2018-10-16 02:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_gift_card`
--

CREATE TABLE `payment_with_gift_card` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `gift_card_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_with_gift_card`
--

INSERT INTO `payment_with_gift_card` (`id`, `payment_id`, `gift_card_id`, `created_at`, `updated_at`) VALUES
(1, 55, 3, '2018-10-25 07:45:54', '2018-10-25 07:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_paypal`
--

CREATE TABLE `payment_with_paypal` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'products-edit', 'web', '2018-06-03 01:00:09', '2018-06-03 01:00:09'),
(5, 'products-delete', 'web', '2018-06-03 22:54:22', '2018-06-03 22:54:22'),
(6, 'products-add', 'web', '2018-06-04 00:34:14', '2018-06-04 00:34:14'),
(7, 'products-index', 'web', '2018-06-04 03:34:27', '2018-06-04 03:34:27'),
(8, 'purchases-index', 'web', '2018-06-04 08:03:19', '2018-06-04 08:03:19'),
(9, 'purchases-add', 'web', '2018-06-04 08:12:25', '2018-06-04 08:12:25'),
(10, 'purchases-edit', 'web', '2018-06-04 09:47:36', '2018-06-04 09:47:36'),
(11, 'purchases-delete', 'web', '2018-06-04 09:47:36', '2018-06-04 09:47:36'),
(12, 'sales-index', 'web', '2018-06-04 10:49:08', '2018-06-04 10:49:08'),
(13, 'sales-add', 'web', '2018-06-04 10:49:52', '2018-06-04 10:49:52'),
(14, 'sales-edit', 'web', '2018-06-04 10:49:52', '2018-06-04 10:49:52'),
(15, 'sales-delete', 'web', '2018-06-04 10:49:53', '2018-06-04 10:49:53'),
(16, 'quotes-index', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(17, 'quotes-add', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(18, 'quotes-edit', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(19, 'quotes-delete', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(20, 'transfers-index', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(21, 'transfers-add', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(22, 'transfers-edit', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(23, 'transfers-delete', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(24, 'returns-index', 'web', '2018-06-04 22:50:24', '2018-06-04 22:50:24'),
(25, 'returns-add', 'web', '2018-06-04 22:50:24', '2018-06-04 22:50:24'),
(26, 'returns-edit', 'web', '2018-06-04 22:50:25', '2018-06-04 22:50:25'),
(27, 'returns-delete', 'web', '2018-06-04 22:50:25', '2018-06-04 22:50:25'),
(28, 'customers-index', 'web', '2018-06-04 23:15:54', '2018-06-04 23:15:54'),
(29, 'customers-add', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(30, 'customers-edit', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(31, 'customers-delete', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(32, 'suppliers-index', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(33, 'suppliers-add', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(34, 'suppliers-edit', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(35, 'suppliers-delete', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(36, 'product-report', 'web', '2018-06-24 23:05:33', '2018-06-24 23:05:33'),
(37, 'purchase-report', 'web', '2018-06-24 23:24:56', '2018-06-24 23:24:56'),
(38, 'sale-report', 'web', '2018-06-24 23:33:13', '2018-06-24 23:33:13'),
(39, 'customer-report', 'web', '2018-06-24 23:36:51', '2018-06-24 23:36:51'),
(40, 'due-report', 'web', '2018-06-24 23:39:52', '2018-06-24 23:39:52'),
(41, 'users-index', 'web', '2018-06-25 00:00:10', '2018-06-25 00:00:10'),
(42, 'users-add', 'web', '2018-06-25 00:00:10', '2018-06-25 00:00:10'),
(43, 'users-edit', 'web', '2018-06-25 00:01:30', '2018-06-25 00:01:30'),
(44, 'users-delete', 'web', '2018-06-25 00:01:30', '2018-06-25 00:01:30'),
(45, 'profit-loss', 'web', '2018-07-14 21:50:05', '2018-07-14 21:50:05'),
(46, 'best-seller', 'web', '2018-07-14 22:01:38', '2018-07-14 22:01:38'),
(47, 'daily-sale', 'web', '2018-07-14 22:24:21', '2018-07-14 22:24:21'),
(48, 'monthly-sale', 'web', '2018-07-14 22:30:41', '2018-07-14 22:30:41'),
(49, 'daily-purchase', 'web', '2018-07-14 22:36:46', '2018-07-14 22:36:46'),
(50, 'monthly-purchase', 'web', '2018-07-14 22:48:17', '2018-07-14 22:48:17'),
(51, 'payment-report', 'web', '2018-07-14 23:10:41', '2018-07-14 23:10:41'),
(52, 'warehouse-stock-report', 'web', '2018-07-14 23:16:55', '2018-07-14 23:16:55'),
(53, 'product-qty-alert', 'web', '2018-07-14 23:33:21', '2018-07-14 23:33:21'),
(54, 'supplier-report', 'web', '2018-07-30 03:00:01', '2018-07-30 03:00:01'),
(55, 'expenses-index', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(56, 'expenses-add', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(57, 'expenses-edit', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(58, 'expenses-delete', 'web', '2018-09-05 01:07:11', '2018-09-05 01:07:11'),
(59, 'general_setting', 'web', '2018-10-08 05:19:28', '2018-10-08 05:19:28'),
(60, 'mail_setting', 'web', '2018-10-08 05:19:29', '2018-10-08 05:19:29'),
(61, 'pos_setting', 'web', '2018-10-08 05:19:29', '2018-10-08 05:19:29'),
(62, 'store-stock-report', 'web', '2018-10-18 02:14:58', '2018-10-18 02:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `pos_setting`
--

CREATE TABLE `pos_setting` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_number` int(11) NOT NULL,
  `keybord_active` tinyint(1) NOT NULL,
  `stripe_public_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_secret_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pos_setting`
--

INSERT INTO `pos_setting` (`id`, `customer_id`, `store_id`, `product_number`, `keybord_active`, `stripe_public_key`, `stripe_secret_key`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 0, 'pk_test_ITN7KOYiIsHSCQ0UMRcgaYUB', 'sk_test_TtQQaawhEYRwa3mU9CzttrEy', '2018-09-26 04:04:23', '2018-10-27 01:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_symbology` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double DEFAULT NULL,
  `alert_quantity` double DEFAULT NULL,
  `promotion` tinyint(4) DEFAULT NULL,
  `promotion_price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_method` int(11) DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `product_details` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `type`, `barcode_symbology`, `brand_id`, `category_id`, `unit`, `cost`, `price`, `qty`, `alert_quantity`, `promotion`, `promotion_price`, `starting_date`, `last_date`, `tax_id`, `tax_method`, `image`, `file`, `featured`, `product_details`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'jackfruit', '33520242', 'standard', 'C128', 1, 1, 'pc', '20', '30', 7, 20, NULL, NULL, NULL, NULL, 1, 1, 'jackfruit.png', NULL, 1, 'national fruit of Bangladesh..\r\nVery tasty and healthy...', 1, '2018-09-17 21:56:41', '2018-10-23 07:27:19'),
(2, 'Beat it', '57623098', 'digital', 'C128', NULL, 3, NULL, '0', '35', 0, NULL, 1, '25', '2018-09-25', '2018-10-31', NULL, 1, 'Beatit.jpeg', '1537597557.png', 1, '<p>Just Beat it!!!</p>', 1, '2018-09-22 00:25:57', '2018-10-19 12:52:10'),
(3, 'coke', '69230049', 'standard', 'UPCA', NULL, 2, 'pc', '8', '12', 21, 20, NULL, NULL, NULL, NULL, NULL, 1, 'coke.jpg', NULL, 1, '', 1, '2018-09-24 01:27:57', '2018-10-23 06:32:17'),
(11, 'jhkhk', '68493375', 'standard', 'C128', NULL, 1, NULL, '345', '556', 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'hgj ughi ihi\r\ndasdasd\"\r\nasd \'fef\r\n&nbsp;&nbsp; sds', 0, '2018-10-02 22:29:08', '2018-10-05 22:35:58'),
(12, 'aaa', 'aaa', 'standard', 'C128', NULL, 1, NULL, '1', '2', 0, 10, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, '2018-10-08 10:54:55', '2018-10-08 10:55:05'),
(13, 'Apple', '51900834', 'standard', 'C128', NULL, 1, 'kg', '80', '120', 56, 20, NULL, NULL, NULL, NULL, NULL, 1, 'Apple.jpg', NULL, 1, NULL, 1, '2018-10-11 00:10:23', '2018-10-25 12:17:17'),
(14, 'pepsi', '94027367', 'standard', 'C128', NULL, 2, 'pc', '10', '15', 91, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'pepsi.jpg', NULL, 1, NULL, 1, '2018-10-11 00:14:14', '2018-10-23 07:28:12'),
(15, 'Head & Shoulder', '70934260', 'standard', 'C128', NULL, 4, 'pc', '100', '150', 17, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'HeadShoulder.jpg', NULL, 1, NULL, 1, '2018-10-17 23:37:17', '2018-10-25 12:14:08'),
(16, 'Fast Track', '14275219', 'standard', 'C128', NULL, 4, NULL, '80', '200', 18, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'FastTrack.jpg', NULL, 1, NULL, 1, '2018-10-17 23:39:08', '2018-10-25 07:54:47'),
(17, 'Banana', '89622400', 'standard', 'C128', NULL, 1, 'dozen', '50', '100', 39, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Banana.jpg', NULL, 1, NULL, 1, '2018-10-17 23:41:12', '2018-10-25 15:35:16'),
(18, 'IPone X', '07739340', 'standard', 'C128', NULL, 5, 'pc', '500', '800', 34, 20, NULL, NULL, NULL, NULL, NULL, 1, 'IPoneX.jpg', NULL, 1, NULL, 1, '2018-10-17 23:45:15', '2018-10-22 05:24:45'),
(19, 'Samsung Galaxy S9', '82543361', 'standard', 'C128', 3, 5, 'pc', '300', '500', 25, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'SamsungGalaxyS9.jpg', NULL, 1, NULL, 1, '2018-10-17 23:48:34', '2018-10-25 07:45:54'),
(20, 'HP Spectre x360', '52932406', 'standard', 'C128', NULL, 3, 'pc', '800', '1000', 34, 20, NULL, NULL, NULL, NULL, NULL, 1, 'HPSpectrex360.jpg', NULL, 1, NULL, 1, '2018-10-17 23:52:08', '2018-10-25 15:32:50'),
(21, 'Mac AirBook', '34807601', 'standard', 'C128', NULL, 3, 'pc', '900', '1200', 35, 10, NULL, NULL, NULL, NULL, NULL, 1, 'MacAirBook.jpg', NULL, 1, NULL, 1, '2018-10-17 23:55:30', '2018-10-18 01:02:20'),
(22, 'sample product', '36913472', 'standard', 'C39', 1, 4, 'USD', '900', '1000', 0, 40, NULL, NULL, '2018-10-21', NULL, 1, 1, 'sampleproduct.jpg', NULL, 1, '<p>description</p>', 0, '2018-10-21 07:31:24', '2018-10-21 07:36:17'),
(23, 'photo', '68028194', 'standard', 'UPCA', 1, 4, 'usd', '50', '500', 0, 78, 1, '450', '2018-10-31', '2018-11-30', 1, 2, 'photo.jpg', NULL, 1, '<p>some details about it</p>', 1, '2018-10-25 00:49:12', '2018-10-25 00:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `product_adjustments`
--

CREATE TABLE `product_adjustments` (
  `id` int(10) UNSIGNED NOT NULL,
  `adjustment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_adjustments`
--

INSERT INTO `product_adjustments` (`id`, `adjustment_id`, `product_id`, `qty`, `action`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 2, '-', '2018-09-25 05:36:33', '2018-10-15 21:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchases`
--

CREATE TABLE `product_purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `recieved` double NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_unit_cost` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchases`
--

INSERT INTO `product_purchases` (`id`, `purchase_id`, `product_id`, `qty`, `recieved`, `unit`, `net_unit_cost`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 2, 2, 'pc', 20, 0, 10, 4, 44, '2018-09-23 04:13:56', '2018-09-23 04:13:56'),
(34, 5, 1, 12, 12, 'pc', 20, 0, 10, 24, 264, '2018-09-30 23:53:43', '2018-09-30 23:53:43'),
(35, 5, 3, 30, 30, 'pc', 8, 0, 0, 0, 240, '2018-09-30 23:53:44', '2018-09-30 23:53:44'),
(36, 4, 1, 10, 10, 'pc', 20, 0, 10, 20, 220, '2018-10-01 22:54:00', '2018-10-01 22:54:00'),
(38, 7, 13, 25, 25, 'kg', 80, 0, 0, 0, 2000, '2018-10-11 00:38:47', '2018-10-11 00:38:47'),
(39, 7, 14, 50, 50, 'pc', 10, 0, 0, 0, 500, '2018-10-11 00:38:48', '2018-10-11 00:38:48'),
(40, 8, 13, 25, 25, 'kg', 80, 0, 0, 0, 2000, '2018-10-11 00:39:56', '2018-10-11 00:39:56'),
(41, 8, 14, 50, 50, 'pc', 10, 0, 0, 0, 500, '2018-10-11 00:39:56', '2018-10-11 00:39:56'),
(42, 9, 1, 10, 10, 'pc', 20, 0, 10, 20, 220, '2018-10-15 21:41:42', '2018-10-15 21:41:42'),
(43, 9, 3, 15, 15, 'pc', 8, 0, 0, 0, 120, '2018-10-15 21:41:42', '2018-10-15 21:41:42'),
(44, 10, 15, 20, 20, 'pc', 100, 0, 0, 0, 2000, '2018-10-18 00:47:58', '2018-10-18 00:47:58'),
(45, 10, 16, 20, 20, 'null', 80, 0, 0, 0, 1600, '2018-10-18 00:47:59', '2018-10-18 00:47:59'),
(46, 10, 17, 20, 20, 'dozen', 50, 0, 0, 0, 1000, '2018-10-18 00:47:59', '2018-10-18 00:47:59'),
(47, 10, 21, 20, 20, 'pc', 900, 0, 0, 0, 18000, '2018-10-18 00:47:59', '2018-10-18 00:47:59'),
(48, 10, 18, 20, 20, 'pc', 500, 0, 0, 0, 10000, '2018-10-18 00:47:59', '2018-10-18 00:47:59'),
(49, 10, 19, 20, 20, 'pc', 300, 0, 0, 0, 6000, '2018-10-18 00:47:59', '2018-10-18 00:47:59'),
(50, 10, 20, 20, 20, 'pc', 800, 0, 0, 0, 16000, '2018-10-18 00:47:59', '2018-10-18 00:47:59'),
(51, 11, 15, 20, 20, 'pc', 100, 0, 0, 0, 2000, '2018-10-18 00:49:56', '2018-10-18 00:49:56'),
(52, 11, 20, 20, 20, 'pc', 800, 0, 0, 0, 16000, '2018-10-18 00:49:56', '2018-10-18 00:49:56'),
(53, 11, 16, 20, 20, 'null', 80, 0, 0, 0, 1600, '2018-10-18 00:49:57', '2018-10-18 00:49:57'),
(54, 11, 17, 20, 20, 'dozen', 50, 0, 0, 0, 1000, '2018-10-18 00:49:57', '2018-10-18 00:49:57'),
(55, 11, 21, 20, 20, 'pc', 900, 0, 0, 0, 18000, '2018-10-18 00:49:57', '2018-10-18 00:49:57'),
(56, 11, 18, 20, 20, 'pc', 500, 0, 0, 0, 10000, '2018-10-18 00:49:57', '2018-10-18 00:49:57'),
(57, 11, 19, 20, 20, 'pc', 300, 0, 0, 0, 6000, '2018-10-18 00:49:57', '2018-10-18 00:49:57'),
(58, 12, 13, 19, 19, 'kg', 80, 0, 0, 0, 1520, '2018-10-25 02:30:14', '2018-10-25 02:30:14'),
(59, 12, 17, 13, 13, 'dozen', 50, 0, 0, 0, 650, '2018-10-25 02:30:14', '2018-10-25 02:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `product_returns`
--

CREATE TABLE `product_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_returns`
--

INSERT INTO `product_returns` (`id`, `return_id`, `product_id`, `qty`, `unit`, `net_unit_price`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(5, 2, 2, 1, 'null', 25, 0, 0, 0, 25, NULL, NULL),
(6, 1, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-01 22:38:12', '2018-10-15 21:52:24'),
(7, 1, 3, 1, 'pc', 12, 0, 0, 0, 12, NULL, '2018-10-15 21:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_finished` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`id`, `sale_id`, `product_id`, `qty`, `unit`, `net_unit_price`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`, `is_finished`) VALUES
(4, 4, 1, 1, 'pc', 30, 0, 10, 3, 33, '2018-09-29 03:26:58', '2018-09-29 03:26:58', '0'),
(5, 4, 2, 2, 'null', 20, 10, 0, 0, 40, '2018-09-29 03:26:58', '2018-09-29 03:26:58', '0'),
(12, 7, 1, 2, 'pc', 30, 0, 10, 6, 66, '2018-10-02 00:42:30', '2018-10-15 21:40:28', '0'),
(13, 7, 3, 3, 'pc', 12, 0, 0, 0, 36, '2018-10-02 00:42:31', '2018-10-15 21:40:28', '0'),
(14, 7, 2, 50, 'null', 25, 0, 0, 0, 1250, '2018-10-02 00:42:31', '2018-10-15 21:40:28', '0'),
(15, 8, 2, 3, 'null', 25, 0, 0, 0, 75, '2018-10-05 22:26:28', '2018-10-15 03:29:45', '0'),
(51, 8, 13, 1, 'kg', 110, 10, 10, 11, 121, '2018-10-14 00:37:32', '2018-10-15 03:29:45', '0'),
(58, 13, 3, 2, 'pc', 12, 0, 0, 0, 24, '2018-10-15 11:27:26', '2018-10-15 11:27:26', '0'),
(59, 13, 14, 2, 'pc', 15, 0, 0, 0, 30, '2018-10-15 11:27:26', '2018-10-15 11:27:26', '0'),
(60, 14, 14, 3, 'pc', 15, 0, 0, 0, 45, '2018-10-15 22:20:59', '2018-10-15 22:20:59', '0'),
(65, 19, 3, 1, 'pc', 12, 0, 0, 0, 12, '2018-10-16 02:28:44', '2018-10-16 02:28:44', '0'),
(67, 21, 3, 1, 'pc', 12, 0, 0, 0, 12, '2018-10-16 04:34:25', '2018-10-16 04:34:25', '0'),
(68, 22, 15, 2, 'pc', 150, 0, 0, 0, 300, '2018-10-18 00:52:21', '2018-10-18 00:52:21', '0'),
(69, 22, 16, 2, 'null', 200, 0, 0, 0, 400, '2018-10-18 00:52:21', '2018-10-18 00:52:21', '0'),
(70, 22, 17, 2, 'dozen', 100, 0, 0, 0, 200, '2018-10-18 00:52:22', '2018-10-18 00:52:22', '0'),
(71, 22, 18, 2, 'pc', 800, 0, 0, 0, 1600, '2018-10-18 00:52:22', '2018-10-18 00:52:22', '0'),
(72, 22, 19, 2, 'pc', 500, 0, 0, 0, 1000, '2018-10-18 00:52:22', '2018-10-18 00:52:22', '0'),
(73, 22, 20, 2, 'pc', 1000, 0, 0, 0, 2000, '2018-10-18 00:52:22', '2018-10-18 00:52:22', '0'),
(74, 22, 21, 2, 'pc', 1200, 0, 0, 0, 2400, '2018-10-18 00:52:22', '2018-10-18 00:52:22', '0'),
(75, 22, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-18 00:52:22', '2018-10-18 00:52:22', '0'),
(76, 23, 2, 50, 'null', 25, 0, 0, 0, 1250, '2018-10-18 01:00:45', '2018-10-18 01:02:19', '0'),
(77, 23, 15, 2, 'pc', 150, 0, 0, 0, 300, '2018-10-18 01:00:45', '2018-10-18 01:02:19', '0'),
(78, 23, 16, 2, 'null', 200, 0, 0, 0, 400, '2018-10-18 01:00:45', '2018-10-18 01:02:20', '0'),
(79, 23, 17, 2, 'dozen', 100, 0, 0, 0, 200, '2018-10-18 01:00:45', '2018-10-18 01:02:20', '0'),
(80, 23, 18, 3, 'pc', 800, 0, 0, 0, 2400, '2018-10-18 01:00:45', '2018-10-18 01:02:20', '0'),
(81, 23, 19, 3, 'pc', 500, 0, 0, 0, 1500, '2018-10-18 01:00:45', '2018-10-18 01:02:20', '0'),
(82, 23, 21, 3, 'pc', 1200, 0, 0, 0, 3600, '2018-10-18 01:00:46', '2018-10-18 01:02:20', '0'),
(83, 23, 20, 3, 'pc', 1000, 0, 0, 0, 3000, '2018-10-18 01:00:46', '2018-10-18 01:02:20', '0'),
(84, 23, 14, 1, 'pc', 15, 0, 0, 0, 15, '2018-10-18 01:00:46', '2018-10-18 01:02:20', '0'),
(85, 23, 13, 2, 'kg', 120, 0, 0, 0, 240, '2018-10-18 01:00:46', '2018-10-18 01:02:21', '0'),
(86, 23, 1, 2, 'pc', 30, 0, 10, 6, 66, '2018-10-18 01:00:46', '2018-10-18 01:02:21', '0'),
(87, 24, 1, 5, 'pc', 30, 0, 10, 15, 165, '2018-10-21 22:40:14', '2018-10-21 22:40:14', '0'),
(88, 24, 19, 3, 'pc', 500, 0, 0, 0, 1500, '2018-10-21 22:40:15', '2018-10-21 22:40:15', '0'),
(89, 25, 18, 3, 'pc', 800, 0, 0, 0, 2400, '2018-10-21 22:41:19', '2018-10-21 22:41:19', '0'),
(90, 25, 20, 3, 'pc', 1000, 0, 0, 0, 3000, '2018-10-21 22:41:19', '2018-10-21 22:41:19', '0'),
(91, 26, 2, 2, 'null', 25, 0, 0, 0, 50, '2018-10-21 22:43:28', '2018-10-21 22:43:28', '0'),
(92, 26, 3, 3, 'pc', 12, 0, 0, 0, 36, '2018-10-21 22:43:28', '2018-10-21 22:43:28', '0'),
(93, 27, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-21 23:03:16', '2018-10-21 23:03:16', '0'),
(94, 27, 16, 1, 'null', 200, 0, 0, 0, 200, '2018-10-21 23:03:16', '2018-10-21 23:03:16', '0'),
(95, 28, 3, 8, 'pc', 12, 0, 0, 0, 96, '2018-10-21 23:06:12', '2018-10-21 23:06:12', '0'),
(96, 29, 2, 5, 'null', 25, 0, 0, 0, 125, '2018-10-22 03:31:05', '2018-10-22 03:31:05', '0'),
(97, 29, 13, 5, 'kg', 120, 0, 0, 0, 600, '2018-10-22 03:31:06', '2018-10-22 03:31:06', '0'),
(98, 30, 18, 1, 'pc', 800, 0, 0, 0, 800, '2018-10-22 05:24:45', '2018-10-22 05:24:45', '0'),
(99, 30, 14, 1, 'pc', 15, 0, 0, 0, 15, '2018-10-22 05:24:45', '2018-10-22 05:24:45', '0'),
(100, 30, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-22 05:24:46', '2018-10-22 05:24:46', '0'),
(101, 31, 2, 11, 'null', 25, 0, 0, 0, 275, '2018-10-22 05:28:55', '2018-10-22 05:28:55', '0'),
(102, 31, 15, 11, 'pc', 150, 0, 0, 0, 1650, '2018-10-22 05:28:56', '2018-10-22 05:28:56', '0'),
(103, 31, 16, 11, 'null', 200, 0, 0, 0, 2200, '2018-10-22 05:28:56', '2018-10-22 05:28:56', '0'),
(104, 32, 16, 2, 'null', 200, 0, 0, 0, 400, '2018-10-22 06:03:14', '2018-10-22 06:03:14', '0'),
(105, 32, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-22 06:03:15', '2018-10-22 06:03:15', '0'),
(106, 33, 3, 1, 'pc', 12, 0, 0, 0, 12, '2018-10-22 06:36:25', '2018-10-22 06:36:25', '0'),
(107, 34, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-22 23:14:21', '2018-10-22 23:14:21', '0'),
(108, 35, 3, 1, 'pc', 12, 0, 0, 0, 12, '2018-10-22 23:23:46', '2018-10-22 23:23:46', '0'),
(109, 36, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-22 23:24:29', '2018-10-22 23:24:29', '0'),
(110, 37, 1, 1, 'pc', 30, 0, 10, 3, 33, '2018-10-23 01:10:52', '2018-10-23 01:10:52', '0'),
(111, 38, 3, 4, 'pc', 12, 0, 0, 0, 48, '2018-10-23 01:12:29', '2018-10-23 01:12:29', '0'),
(112, 39, 1, 6, 'pc', 30, 0, 10, 18, 198, '2018-10-23 04:46:58', '2018-10-23 04:46:58', '0'),
(115, 41, 2, 555, 'null', 25, 0, 0, 0, 13875, '2018-10-23 05:21:28', '2018-10-23 05:23:12', '0'),
(116, 42, 1, 1, 'pc', 30, 0, 10, 3, 33, '2018-10-23 05:30:59', '2018-10-23 05:30:59', '0'),
(117, 43, 1, 7, 'pc', 30, 0, 10, 21, 231, '2018-10-23 05:34:23', '2018-10-23 05:34:23', '0'),
(118, 44, 2, 9, 'null', 25, 0, 0, 0, 225, '2018-10-23 05:37:11', '2018-10-23 05:37:11', '0'),
(119, 45, 2, 15, 'null', 25, 0, 0, 0, 375, '2018-10-23 05:42:59', '2018-10-23 05:42:59', '0'),
(120, 46, 1, 4, 'pc', 30, 0, 10, 12, 132, '2018-10-23 06:17:40', '2018-10-23 06:17:40', '0'),
(121, 47, 2, 5, 'null', 25, 0, 0, 0, 125, '2018-10-23 06:30:16', '2018-10-23 06:30:16', '0'),
(122, 47, 3, 2, 'pc', 12, 0, 0, 0, 24, '2018-10-23 06:30:16', '2018-10-23 06:30:16', '0'),
(123, 48, 3, 2, 'pc', 12, 0, 0, 0, 24, '2018-10-23 06:32:17', '2018-10-23 06:32:17', '0'),
(124, 49, 1, 1, 'pc', 30, 0, 10, 3, 33, '2018-10-23 07:27:20', '2018-10-23 07:27:20', '0'),
(125, 50, 14, 2, 'pc', 15, 0, 0, 0, 30, '2018-10-23 07:28:12', '2018-10-23 07:28:12', '0'),
(126, 50, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-23 07:28:12', '2018-10-23 07:28:12', '0'),
(127, 51, 19, 3, 'pc', 500, 0, 0, 0, 1500, '2018-10-24 03:04:06', '2018-10-24 03:04:06', '0'),
(128, 52, 2, 3, 'null', 25, 0, 0, 0, 75, '2018-10-24 07:45:23', '2018-10-24 07:45:23', '0'),
(130, 54, 2, 5, 'null', 25, 0, 0, 0, 125, '2018-10-25 06:38:26', '2018-10-25 06:38:26', '0'),
(131, 55, 16, 1, 'null', 200, 0, 0, 0, 200, '2018-10-25 06:38:56', '2018-10-25 06:38:56', '0'),
(132, 56, 16, 1, 'null', 200, 0, 0, 0, 200, '2018-10-25 06:39:39', '2018-10-25 06:39:39', '0'),
(133, 56, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 06:39:39', '2018-10-25 06:39:39', '0'),
(134, 57, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 06:45:00', '2018-10-25 06:45:00', '0'),
(135, 58, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-25 07:39:09', '2018-10-25 07:39:09', '0'),
(136, 59, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-25 07:43:11', '2018-10-25 07:43:11', '0'),
(137, 60, 16, 1, 'null', 200, 0, 0, 0, 200, '2018-10-25 07:44:29', '2018-10-25 07:44:29', '0'),
(138, 61, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-25 07:45:06', '2018-10-25 07:45:06', '0'),
(139, 62, 19, 4, 'pc', 500, 0, 0, 0, 2000, '2018-10-25 07:45:54', '2018-10-25 07:45:54', '0'),
(140, 63, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-25 07:46:29', '2018-10-25 07:46:29', '0'),
(141, 64, 17, 3, 'dozen', 100, 0, 0, 0, 300, '2018-10-25 07:49:09', '2018-10-25 07:49:09', '0'),
(142, 65, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 07:52:26', '2018-10-25 07:52:26', '0'),
(143, 66, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 07:52:50', '2018-10-25 07:52:50', '0'),
(144, 67, 17, 3, 'dozen', 100, 0, 0, 0, 300, '2018-10-25 07:53:37', '2018-10-25 07:53:37', '0'),
(145, 68, 16, 1, 'null', 200, 0, 0, 0, 200, '2018-10-25 07:54:47', '2018-10-25 07:54:47', '0'),
(146, 69, 20, 1, 'pc', 1000, 0, 0, 0, 1000, '2018-10-25 07:55:23', '2018-10-25 07:55:23', '0'),
(147, 70, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-25 07:58:10', '2018-10-25 07:58:10', '0'),
(148, 71, 21, 2, 'pc', 1200, 0, 0, 0, 2400, '2018-10-25 08:02:03', '2018-10-25 08:02:03', '0'),
(149, 72, 21, 3, 'pc', 1200, 0, 0, 0, 3600, '2018-10-25 08:03:07', '2018-10-25 08:03:07', '0'),
(150, 73, 18, 2, 'pc', 800, 0, 0, 0, 1600, '2018-10-25 08:04:21', '2018-10-25 08:04:21', '0'),
(151, 74, 19, 2, 'pc', 500, 0, 0, 0, 1000, '2018-10-25 08:04:40', '2018-10-25 08:04:40', '0'),
(152, 75, 18, 2, 'pc', 800, 0, 0, 0, 1600, '2018-10-25 08:05:46', '2018-10-25 08:05:46', '0'),
(153, 76, 15, 2, 'pc', 150, 0, 0, 0, 300, '2018-10-25 08:09:08', '2018-10-25 08:09:08', '0'),
(154, 77, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-25 08:10:02', '2018-10-25 08:10:02', '0'),
(155, 78, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 08:11:25', '2018-10-25 08:11:25', '0'),
(156, 79, 19, 1, 'pc', 500, 0, 0, 0, 500, '2018-10-25 08:12:56', '2018-10-25 08:12:56', '0'),
(157, 80, 19, 1, 'pc', 500, 0, 0, 0, 500, '2018-10-25 08:15:31', '2018-10-25 08:15:31', '0'),
(158, 81, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 08:24:30', '2018-10-25 08:24:30', '0'),
(159, 82, 17, 2, 'dozen', 100, 0, 0, 0, 200, '2018-10-25 08:34:39', '2018-10-25 08:34:39', '0'),
(160, 83, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 08:40:05', '2018-10-25 08:40:05', '0'),
(161, 84, 2, 1, 'null', 25, 0, 0, 0, 25, '2018-10-25 08:40:51', '2018-10-25 08:40:51', '0'),
(162, 85, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 08:41:46', '2018-10-25 08:41:46', '0'),
(163, 86, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 12:07:03', '2018-10-25 12:07:03', '0'),
(164, 87, 15, 1, 'pc', 150, 0, 0, 0, 150, '2018-10-25 12:14:08', '2018-10-25 12:14:08', '0'),
(165, 88, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 12:16:06', '2018-10-25 12:16:06', '0'),
(166, 89, 13, 1, 'kg', 120, 0, 0, 0, 120, '2018-10-25 12:17:17', '2018-10-25 12:17:17', '0'),
(167, 90, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 12:18:35', '2018-10-25 12:18:35', '0'),
(168, 91, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 12:29:01', '2018-10-25 12:29:01', '0'),
(169, 92, 20, 1, 'pc', 1000, 0, 0, 0, 1000, '2018-10-25 15:32:50', '2018-10-25 15:32:50', '0'),
(170, 93, 17, 1, 'dozen', 100, 0, 0, 0, 100, '2018-10-25 15:35:16', '2018-10-25 15:35:16', '0');

-- --------------------------------------------------------

--
-- Table structure for table `product_store`
--

CREATE TABLE `product_store` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_store`
--

INSERT INTO `product_store` (`id`, `product_id`, `store_id`, `qty`, `created_at`, `updated_at`) VALUES
(1, '1', 1, -5, '2018-09-23 04:13:56', '2018-10-23 07:27:20'),
(2, '3', 1, 0, '2018-09-24 03:00:01', '2018-10-23 06:32:17'),
(3, '3', 2, 21, '2018-09-24 21:54:28', '2018-10-21 22:43:28'),
(4, '1', 2, 12, '2018-09-24 22:33:58', '2018-10-18 01:02:21'),
(5, '13', 1, 15, '2018-10-11 00:38:47', '2018-10-25 12:17:17'),
(6, '14', 1, 44, '2018-10-11 00:38:48', '2018-10-22 05:24:45'),
(7, '13', 2, 41, '2018-10-11 00:39:56', '2018-10-25 02:30:14'),
(8, '14', 2, 47, '2018-10-11 00:39:56', '2018-10-23 07:28:12'),
(9, '15', 1, 0, '2018-10-18 00:47:58', '2018-10-25 12:14:08'),
(10, '16', 1, 0, '2018-10-18 00:47:59', '2018-10-25 07:54:47'),
(11, '17', 1, 8, '2018-10-18 00:47:59', '2018-10-25 15:35:16'),
(12, '21', 1, 18, '2018-10-18 00:47:59', '2018-10-18 00:52:22'),
(13, '18', 1, 17, '2018-10-18 00:47:59', '2018-10-22 05:24:45'),
(14, '19', 1, 8, '2018-10-18 00:47:59', '2018-10-25 07:45:54'),
(15, '20', 1, 17, '2018-10-18 00:47:59', '2018-10-25 15:32:50'),
(16, '15', 2, 17, '2018-10-18 00:49:56', '2018-10-23 07:28:12'),
(17, '20', 2, 17, '2018-10-18 00:49:56', '2018-10-18 01:02:20'),
(18, '16', 2, 18, '2018-10-18 00:49:56', '2018-10-18 01:02:20'),
(19, '17', 2, 31, '2018-10-18 00:49:57', '2018-10-25 02:30:14'),
(20, '21', 2, 17, '2018-10-18 00:49:57', '2018-10-18 01:02:20'),
(21, '18', 2, 17, '2018-10-18 00:49:57', '2018-10-18 01:02:20'),
(22, '19', 2, 17, '2018-10-18 00:49:57', '2018-10-18 01:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `product_transfer`
--

CREATE TABLE `product_transfer` (
  `id` int(10) UNSIGNED NOT NULL,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_unit_cost` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_transfer`
--

INSERT INTO `product_transfer` (`id`, `transfer_id`, `product_id`, `qty`, `unit`, `net_unit_cost`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(4, 2, 1, 10, 'pc', 20, 10, 20, 220, '2018-10-01 22:56:51', '2018-10-01 23:49:29'),
(5, 2, 3, 5, 'pc', 8, 0, 0, 40, '2018-10-01 23:49:29', '2018-10-01 23:49:29'),
(6, 3, 3, 8, 'pc', 8, 0, 0, 64, '2018-10-01 23:50:12', '2018-10-16 00:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `paid_amount` double NOT NULL,
  `status` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `reference_no`, `user_id`, `store_id`, `supplier_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_cost`, `order_tax_rate`, `order_tax`, `order_discount`, `shipping_cost`, `grand_total`, `paid_amount`, `status`, `payment_status`, `document`, `note`, `created_at`, `updated_at`) VALUES
(4, '2018-09-26', 'pr-20180923-103010', 1, 1, 1, 1, 10, 0, 20, 220, 0, 0, 10, 50, 260, 0, 1, 1, NULL, NULL, '2018-09-23 04:30:10', '2018-10-01 22:54:01'),
(5, '2018-08-21', 'pr-20180923-105137', 1, 1, 1, 2, 42, 0, 24, 504, 10, 50.4, 0, 0, 554.4, 15, 1, 1, NULL, NULL, '2018-09-23 04:51:37', '2018-10-07 22:07:26'),
(7, '2018-10-11', 'pr-20181011-063847', 1, 1, 1, 2, 75, 0, 0, 2500, 0, 0, NULL, NULL, 2500, 0, 1, 1, NULL, NULL, '2018-10-11 00:38:47', '2018-10-11 00:38:47'),
(8, '2018-10-11', 'pr-20181011-063955', 1, 2, 1, 2, 75, 0, 0, 2500, 10, 250, NULL, NULL, 2750, 275, 1, 1, NULL, NULL, '2018-10-11 00:39:55', '2018-10-17 23:16:42'),
(9, '2018-10-16', 'pr-20181016-034142', 1, 2, NULL, 2, 25, 0, 20, 340, 10, 34, NULL, 10, 384, 30, 1, 1, NULL, 'aaa\r\naaa', '2018-10-15 21:41:42', '2018-10-17 23:16:25'),
(10, '2018-10-18', 'pr-20181018-064758', 1, 1, 1, 7, 140, 0, 0, 54600, 0, 0, NULL, NULL, 54600, 0, 1, 1, NULL, NULL, '2018-10-18 00:47:58', '2018-10-18 00:47:58'),
(11, '2018-10-18', 'pr-20181018-064956', 1, 2, NULL, 7, 140, 0, 0, 54600, 0, 0, NULL, NULL, 54600, 0, 1, 1, NULL, NULL, '2018-10-18 00:49:56', '2018-10-18 00:49:56'),
(12, '2018-10-25', 'pr-20181025-070014', 1, 2, 1, 2, 32, 0, 0, 2170, 10, 216, 10, 30, 2406, 0, 1, 1, '5ba5ead3db94f_1537600211.jpeg', 'discription', '2018-10-25 02:30:14', '2018-10-25 02:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_note` text COLLATE utf8mb4_unicode_ci,
  `staff_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `date`, `reference_no`, `user_id`, `customer_id`, `store_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `order_tax_rate`, `order_tax`, `grand_total`, `document`, `return_note`, `staff_note`, `created_at`, `updated_at`) VALUES
(1, '2018-10-06', 'rr-20181006-042724', 1, 1, 1, 1, 1, 0, 0, 12, 0, 0, 12, NULL, 'aaa\r\naaaa', 'aaa\r\naaa', '2018-10-05 22:27:24', '2018-10-15 21:52:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `guard_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Owner', 'Owner of the company...', 'web', 1, NULL, '2018-10-13 00:27:21'),
(2, 'Admin', 'Admin of this system...', 'web', 1, '2018-10-13 00:29:15', '2018-10-13 00:29:15'),
(3, 'Staff', 'Staff of the company...', 'web', 1, '2018-10-13 00:30:05', '2018-10-13 00:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 2),
(13, 3),
(14, 1),
(14, 2),
(14, 3),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(16, 3),
(17, 1),
(17, 2),
(17, 3),
(18, 1),
(18, 2),
(18, 3),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(20, 3),
(21, 1),
(21, 2),
(21, 3),
(22, 1),
(22, 2),
(22, 3),
(23, 1),
(23, 2),
(24, 1),
(24, 2),
(24, 3),
(25, 1),
(25, 2),
(25, 3),
(26, 1),
(26, 2),
(26, 3),
(27, 1),
(27, 2),
(28, 1),
(28, 2),
(28, 3),
(29, 1),
(29, 2),
(29, 3),
(30, 1),
(30, 2),
(30, 3),
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 1),
(46, 2),
(47, 1),
(47, 2),
(48, 1),
(48, 2),
(49, 1),
(49, 2),
(50, 1),
(50, 2),
(51, 1),
(51, 2),
(53, 1),
(53, 2),
(54, 1),
(54, 2),
(55, 1),
(55, 2),
(55, 3),
(56, 1),
(56, 2),
(56, 3),
(57, 1),
(57, 2),
(57, 3),
(58, 1),
(58, 2),
(59, 1),
(59, 2),
(60, 1),
(60, 2),
(61, 1),
(61, 2),
(62, 1),
(62, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `grand_total` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `sale_status` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `sale_note` text COLLATE utf8mb4_unicode_ci,
  `staff_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `reference_no`, `user_id`, `customer_id`, `store_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `grand_total`, `order_tax_rate`, `order_tax`, `order_discount`, `shipping_cost`, `sale_status`, `payment_status`, `document`, `paid_amount`, `sale_note`, `staff_note`, `created_at`, `updated_at`) VALUES
(4, '2018-09-29', 'sr-20180929-092658', 1, 1, 1, 2, 3, 10, 3, 73, 108.3, 10, 5.3, 20, 50, 1, 4, NULL, 108.3, NULL, NULL, '2018-09-29 03:26:58', '2018-09-29 03:26:58'),
(7, '2018-10-02', 'sr-20181002-064230', 1, 1, 1, 3, 55, 0, 6, 1352, 1499.2, 10, 132.2, 30, 45, 1, 2, NULL, 0, 'aa\r\naa', 'asas\r\nsasa', '2018-10-02 00:42:30', '2018-10-15 21:40:28'),
(8, '2018-10-06', 'sr-20181006-042628', 1, 1, 2, 2, 4, 10, 11, 196, 196, 0, 0, 0, 0, 1, 2, NULL, 50, NULL, NULL, '2018-10-05 22:26:28', '2018-10-15 03:29:45'),
(13, '2018-10-15', 'sr-20181015-052726', 1, 1, 1, 2, 4, 0, 0, 54, 54, 0, 0, 0, 0, 1, 4, NULL, 54, NULL, NULL, '2018-10-15 11:27:26', '2018-10-15 11:27:26'),
(14, '2018-10-16', 'sr-20181016-042059', 5, 1, 1, 1, 3, 0, 0, 45, 45, 0, 0, NULL, NULL, 1, 4, NULL, 45, NULL, NULL, '2018-10-15 22:20:59', '2018-10-15 22:20:59'),
(19, '2018-10-16', 'sr-20181016-082843', 1, 1, 1, 1, 1, 0, 0, 12, 12, 0, 0, NULL, NULL, 1, 4, NULL, 12, NULL, NULL, '2018-10-16 02:28:43', '2018-10-16 02:28:43'),
(21, '2018-10-16', 'dr-20181016-103425', 1, 1, 1, 1, 1, 0, 0, 12, 12, 0, 0, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-16 04:34:25', '2018-10-16 04:34:25'),
(22, '2018-10-18', 'sr-20181018-065221', 1, 1, 1, 8, 15, 0, 0, 7925, 7925, 0, 0, NULL, NULL, 1, 4, NULL, 7925, NULL, NULL, '2018-10-18 00:52:21', '2018-10-18 00:52:21'),
(23, '2018-10-18', 'sr-20181018-070044', 1, 1, 2, 11, 73, 0, 6, 12971, 12971, 0, 0, 0, 0, 1, 2, NULL, 8271, NULL, NULL, '2018-10-18 01:00:44', '2018-10-18 01:02:21'),
(24, '2018-10-22', 'sr-20181022-031014', 1, 1, 1, 2, 8, 0, 15, 1665, 1665, 0, 0, 120, NULL, 1, 4, NULL, 1665, NULL, NULL, '2018-10-21 22:40:14', '2018-10-21 22:40:14'),
(25, '2018-10-22', 'dr-20181022-031119', 1, 1, 1, 2, 6, 0, 0, 5400, 5400, 0, 0, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-21 22:41:19', '2018-10-21 22:41:19'),
(26, '2018-10-22', 'sr-20181022-031328', 1, 1, 2, 2, 5, 0, 0, 86, 76, 0, 0, 10, NULL, 1, 4, NULL, 76, NULL, NULL, '2018-10-21 22:43:28', '2018-10-21 22:43:28'),
(27, '2018-10-22', 'sr-20181022-033316', 1, 1, 1, 2, 2, 0, 0, 225, 225, 0, 0, NULL, NULL, 1, 4, NULL, 225, NULL, NULL, '2018-10-21 23:03:16', '2018-10-21 23:03:16'),
(28, '2018-10-22', 'sr-20181022-033611', 1, 1, 1, 1, 8, 0, 0, 96, 96, 0, 0, NULL, NULL, 1, 4, NULL, 96, NULL, NULL, '2018-10-21 23:06:11', '2018-10-21 23:06:11'),
(29, '2018-10-22', 'sr-20181022-080105', 1, 1, 1, 2, 10, 0, 0, 725, 725, 0, 0, NULL, NULL, 1, 4, NULL, 725, NULL, NULL, '2018-10-22 03:31:05', '2018-10-22 03:31:05'),
(30, '2018-10-22', 'sr-20181022-095445', 1, 1, 1, 3, 3, 0, 0, 965, 965, 0, 0, NULL, NULL, 1, 4, NULL, 965, NULL, NULL, '2018-10-22 05:24:45', '2018-10-22 05:24:45'),
(31, '2018-10-22', 'sr-20181022-095855', 1, 1, 1, 3, 33, 0, 0, 4125, 4125, 0, 0, NULL, NULL, 1, 4, NULL, 4125, 'note jumah', 'jumah', '2018-10-22 05:28:55', '2018-10-22 05:28:55'),
(32, '2018-10-22', 'sr-20181022-103314', 1, 1, 1, 2, 3, 0, 0, 500, 500, 0, 0, NULL, NULL, 1, 4, NULL, 500, NULL, NULL, '2018-10-22 06:03:14', '2018-10-22 06:03:14'),
(33, '2018-10-22', 'sr-20181022-110625', 1, 1, 1, 1, 1, 0, 0, 12, 12, 0, 0, NULL, NULL, 1, 4, NULL, 12, NULL, NULL, '2018-10-22 06:36:25', '2018-10-22 06:36:25'),
(34, '2018-10-23', 'sr-20181023-034421', 1, 1, 1, 1, 1, 0, 0, 25, 25, 0, 0, NULL, NULL, 1, 4, NULL, 25, NULL, NULL, '2018-10-22 23:14:21', '2018-10-22 23:14:21'),
(35, '2018-10-23', 'sr-20181023-035346', 1, 1, 1, 1, 1, 0, 0, 12, 12, 0, 0, NULL, NULL, 1, 4, NULL, 12, NULL, NULL, '2018-10-22 23:23:46', '2018-10-22 23:23:46'),
(36, '2018-10-23', 'sr-20181023-035429', 1, 1, 1, 1, 1, 0, 0, 25, 25, 0, 0, NULL, NULL, 1, 4, NULL, 25, NULL, NULL, '2018-10-22 23:24:29', '2018-10-22 23:24:29'),
(37, '2018-10-23', 'dr-20181023-054052', 1, 1, 1, 1, 1, 0, 3, 33, 33, 0, 0, NULL, NULL, 2, 4, NULL, 33, NULL, NULL, '2018-10-23 01:10:52', '2018-10-23 01:10:52'),
(38, '2018-10-23', 'dr-20181023-054229', 1, 1, 1, 1, 4, 0, 0, 48, 48, 0, 0, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-23 01:12:29', '2018-10-23 01:12:29'),
(39, '2018-10-23', 'sr-20181023-091657', 1, 1, 1, 1, 6, 0, 18, 198, 198, 0, 0, NULL, NULL, 1, 4, NULL, 198, NULL, NULL, '2018-10-23 04:46:57', '2018-10-23 04:46:57'),
(40, '2018-10-23', 'sr-20181023-092705', 1, 1, 1, 2, 10, 0, 21, 481, 481, 0, 0, NULL, NULL, 1, 4, NULL, 481, NULL, NULL, '2018-10-23 04:57:05', '2018-10-23 04:57:05'),
(41, '2018-10-23', 'sr-20181023-095128', 1, 1, 1, 1, 555, 0, 0, 13875, 13875, 0, 0, 0, 0, 1, 2, NULL, 75, NULL, NULL, '2018-10-23 05:21:28', '2018-10-23 05:23:12'),
(42, '2018-10-23', 'sr-20181023-100059', 1, 1, 1, 1, 1, 0, 3, 33, 33, 0, 0, NULL, NULL, 1, 4, NULL, 33, NULL, NULL, '2018-10-23 05:30:59', '2018-10-23 05:30:59'),
(43, '2018-10-23', 'sr-20181023-100423', 1, 1, 1, 1, 7, 0, 21, 231, 231, 0, 0, NULL, NULL, 1, 4, NULL, 231, NULL, NULL, '2018-10-23 05:34:23', '2018-10-23 05:34:23'),
(44, '2018-10-23', 'sr-20181023-100710', 1, 1, 1, 1, 9, 0, 0, 225, 225, 0, 0, NULL, NULL, 1, 4, NULL, 225, NULL, NULL, '2018-10-23 05:37:10', '2018-10-23 05:37:10'),
(45, '2018-10-23', 'sr-20181023-101259', 1, 1, 1, 1, 15, 0, 0, 375, 375, 0, 0, NULL, NULL, 1, 4, NULL, 375, NULL, NULL, '2018-10-23 05:42:59', '2018-10-23 05:42:59'),
(46, '2018-10-23', 'sr-20181023-104739', 1, 1, 1, 1, 4, 0, 12, 132, 132, 0, 0, NULL, NULL, 1, 4, NULL, 132, NULL, NULL, '2018-10-23 06:17:39', '2018-10-23 06:17:39'),
(47, '2018-10-23', 'sr-20181023-110016', 1, 1, 1, 2, 7, 0, 0, 149, 149, 0, 0, NULL, NULL, 1, 4, NULL, 149, NULL, NULL, '2018-10-23 06:30:16', '2018-10-23 06:30:16'),
(48, '2018-10-23', 'sr-20181023-110217', 1, 1, 1, 1, 2, 0, 0, 24, 24, 0, 0, NULL, NULL, 1, 4, NULL, 24, NULL, NULL, '2018-10-23 06:32:17', '2018-10-23 06:32:17'),
(49, '2018-10-23', 'sr-20181023-115719', 1, 1, 1, 1, 1, 0, 3, 33, 33, 0, 0, NULL, NULL, 1, 4, NULL, 33, NULL, NULL, '2018-10-23 07:27:19', '2018-10-23 07:27:19'),
(50, '2018-10-23', 'sr-20181023-115812', 1, 1, 2, 2, 3, 0, 0, 180, 180, 0, 0, NULL, NULL, 1, 4, NULL, 180, NULL, NULL, '2018-10-23 07:28:12', '2018-10-23 07:28:12'),
(51, '2018-10-24', 'sr-20181024-073405', 1, 1, 1, 1, 3, 0, 0, 1500, 1500, 0, 0, NULL, NULL, 1, 4, NULL, 1500, NULL, NULL, '2018-10-24 03:04:05', '2018-10-24 03:04:05'),
(52, '2018-10-24', 'sr-20181024-121523', 1, 1, 1, 1, 3, 0, 0, 75, 75, 0, 0, NULL, NULL, 1, 4, NULL, 75, NULL, NULL, '2018-10-24 07:45:23', '2018-10-24 07:45:23'),
(54, '2018-10-25', 'sr-20181025-110826', 1, 1, 1, 1, 5, 0, 0, 125, 125, 0, 0, NULL, NULL, 1, 4, NULL, 125, NULL, NULL, '2018-10-25 06:38:26', '2018-10-25 06:38:26'),
(55, '2018-10-25', 'sr-20181025-110856', 1, 1, 1, 1, 1, 0, 0, 200, 200, 0, 0, NULL, NULL, 1, 4, NULL, 200, NULL, NULL, '2018-10-25 06:38:56', '2018-10-25 06:38:56'),
(56, '2018-10-25', 'sr-20181025-110939', 1, 1, 1, 2, 2, 0, 0, 300, 300, 0, 0, NULL, NULL, 1, 4, NULL, 300, NULL, NULL, '2018-10-25 06:39:39', '2018-10-25 06:39:39'),
(57, '2018-10-25', 'sr-20181025-111500', 1, 1, 1, 1, 1, 0, 0, 120, 120, 0, 0, NULL, NULL, 1, 4, NULL, 120, NULL, NULL, '2018-10-25 06:45:00', '2018-10-25 06:45:00'),
(58, '2018-10-25', 'sr-20181025-120909', 1, 1, 1, 1, 1, 0, 0, 25, 25, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:39:09', '2018-10-25 07:39:09'),
(59, '2018-10-25', 'dr-20181025-121311', 1, 1, 1, 1, 1, 0, 0, 150, 150, 0, 0, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:43:11', '2018-10-25 07:43:11'),
(60, '2018-10-25', 'sr-20181025-121429', 1, 1, 1, 1, 1, 0, 0, 200, 200, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:44:29', '2018-10-25 07:44:29'),
(61, '2018-10-25', 'sr-20181025-121505', 1, 1, 1, 1, 1, 0, 0, 150, 150, 0, 0, NULL, NULL, 1, 4, NULL, 150, NULL, NULL, '2018-10-25 07:45:05', '2018-10-25 07:45:05'),
(62, '2018-10-25', 'sr-20181025-121554', 1, 1, 1, 1, 4, 0, 0, 2000, 2000, 0, 0, NULL, NULL, 1, 4, NULL, 2000, NULL, NULL, '2018-10-25 07:45:54', '2018-10-25 07:45:54'),
(63, '2018-10-25', 'dr-20181025-121629', 1, 1, 1, 1, 1, 0, 0, 25, 25, 0, 0, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:46:29', '2018-10-25 07:46:29'),
(64, '2018-10-25', 'sr-20181025-121909', 1, 1, 1, 1, 3, 0, 0, 300, 300, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:49:09', '2018-10-25 07:49:09'),
(65, '2018-10-25', 'dr-20181025-122226', 1, 1, 1, 1, 1, 0, 0, 120, 120, 0, 0, NULL, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:52:26', '2018-10-25 07:52:26'),
(66, '2018-10-25', 'dr-20181025-122250', 1, 1, 1, 1, 1, 0, 0, 120, 120, 0, 0, NULL, NULL, 4, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:52:50', '2018-10-25 07:52:50'),
(67, '2018-10-25', 'dr-20181025-122337', 1, 1, 1, 1, 3, 0, 0, 300, 300, 0, 0, NULL, NULL, 4, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:53:37', '2018-10-25 07:53:37'),
(68, '2018-10-25', 'sr-20181025-122447', 1, 1, 1, 1, 1, 0, 0, 200, 188, 0, 0, 12, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:54:47', '2018-10-25 07:54:47'),
(69, '2018-10-25', 'dr-20181025-122522', 1, 1, 1, 1, 1, 0, 0, 1000, 501, 0, 0, 499, NULL, 2, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:55:22', '2018-10-25 07:55:22'),
(70, '2018-10-25', 'sr-20181025-122810', 1, 1, 1, 1, 1, 0, 0, 150, 150, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 07:58:10', '2018-10-25 07:58:10'),
(71, '2018-10-25', 'dr-20181025-123203', 1, 1, 1, 1, 2, 0, 0, 2400, 2400, 0, 0, NULL, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:02:03', '2018-10-25 08:02:03'),
(72, '2018-10-25', 'dr-20181025-123307', 1, 1, 1, 1, 3, 0, 0, 3600, 3600, 0, 0, NULL, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:03:07', '2018-10-25 08:03:07'),
(73, '2018-10-25', 'dr-20181025-123421', 1, 1, 1, 1, 2, 0, 0, 1600, 1600, 0, 0, NULL, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:04:21', '2018-10-25 08:04:21'),
(74, '2018-10-25', 'dr-20181025-123440', 1, 1, 1, 1, 2, 0, 0, 1000, 1000, 0, 0, NULL, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:04:40', '2018-10-25 08:04:40'),
(75, '2018-10-25', 'dr-20181025-123546', 1, 1, 2, 1, 2, 0, 0, 1600, 1467, 0, 0, 133, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:05:46', '2018-10-25 08:05:46'),
(76, '2018-10-25', 'dr-20181025-123908', 1, 1, 1, 1, 2, 0, 0, 300, 235, 0, 0, 65, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:09:08', '2018-10-25 08:09:08'),
(77, '2018-10-25', 'sr-20181025-124001', 1, 1, 1, 1, 1, 0, 0, 150, 61, 0, 0, 89, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:10:01', '2018-10-25 08:10:01'),
(78, '2018-10-25', 'dr-20181025-124125', 1, 1, 1, 1, 1, 0, 0, 100, 22, 0, 0, 78, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:11:25', '2018-10-25 08:11:25'),
(79, '2018-10-25', 'dr-20181025-124256', 1, 1, 1, 1, 1, 0, 0, 500, 500, 0, 0, NULL, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:12:56', '2018-10-25 08:12:56'),
(80, '2018-10-25', 'dr-20181025-124531', 1, 1, 1, 1, 1, 0, 0, 500, 589, 0, 0, NULL, 89, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:15:31', '2018-10-25 08:15:31'),
(81, '2018-10-25', 'sr-20181025-125430', 1, 1, 1, 1, 1, 0, 0, 100, 46, 0, 0, 54, NULL, 3, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:24:30', '2018-10-25 08:24:30'),
(82, '2018-10-25', 'dr-20181025-010439', 1, 1, 1, 1, 2, 0, 0, 200, 200, 0, 0, NULL, NULL, 32, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:34:39', '2018-10-25 08:34:39'),
(83, '2018-10-25', 'sr-20181025-011004', 1, 1, 1, 1, 1, 0, 0, 100, 10, 0, 0, 90, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:40:04', '2018-10-25 08:40:04'),
(84, '2018-10-25', 'sr-20181025-011051', 1, 1, 1, 1, 1, 0, 0, 25, 25, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:40:51', '2018-10-25 08:40:51'),
(85, '2018-10-25', 'sr-20181025-011146', 1, 1, 1, 1, 1, 0, 0, 120, 32, 0, 0, 88, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 08:41:46', '2018-10-25 08:41:46'),
(86, '2018-10-25', 'sr-20181025-043703', 1, 1, 1, 1, 1, 0, 0, 120, 120, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 12:07:03', '2018-10-25 12:07:03'),
(87, '2018-10-25', 'sr-20181025-044407', 1, 1, 1, 1, 1, 0, 0, 150, 73, 0, 0, 77, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 12:14:07', '2018-10-25 12:14:07'),
(88, '2018-10-25', 'sr-20181025-044606', 1, 1, 1, 1, 1, 0, 0, 120, 21, 0, 0, 99, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 12:16:06', '2018-10-25 12:16:06'),
(89, '2018-10-25', 'sr-20181025-044717', 1, 1, 1, 1, 1, 0, 0, 120, 120, 0, 0, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 12:17:17', '2018-10-25 12:17:17'),
(90, '2018-10-25', 'sr-20181025-044835', 1, 1, 1, 1, 1, 0, 0, 100, 23, 0, 0, 77, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 12:18:35', '2018-10-25 12:18:35'),
(91, '2018-10-25', 'sr-20181025-045900', 1, 1, 1, 1, 1, 0, 0, 100, 94, 0, 0, 6, NULL, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 12:29:00', '2018-10-25 12:29:00'),
(92, '2018-10-25', 'sr-20181025-080250', 1, 1, 1, 1, 1, 0, 0, 1000, 1005, 0, 0, NULL, 5, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 15:32:50', '2018-10-25 15:32:50'),
(93, '2018-10-25', 'sr-20181025-080516', 1, 1, 1, 1, 1, 0, 0, 100, 108, 0, 0, NULL, 8, 1, 2, NULL, NULL, NULL, NULL, '2018-10-25 15:35:16', '2018-10-25 15:35:16');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `phone`, `email`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Store 1', '1212', 'abc@gmail.com', 'jamalkhan, chittagong', 1, '2018-09-22 01:54:56', '2018-10-09 01:04:03'),
(2, 'Store 2', '11111', 'abd@gmail.com', 'khatunganj, chittagong', 1, '2018-09-24 21:38:03', '2018-10-09 01:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'jackson', 'microsoft.jpg', 'microsoft', '112211', 'jack@microsoft.com', '212121', 'newyork  usa', 'manhattan', NULL, NULL, 'usa', 1, '2018-09-23 02:42:22', '2018-09-23 02:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'vat-10', 10, 1, '2018-09-22 00:10:18', '2018-09-22 00:10:18'),
(2, 'gst-10', 10, 0, '2018-09-26 02:43:44', '2018-09-26 02:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_table`
--

CREATE TABLE `tmp_table` (
  `tmp_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `product_code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tmp_table`
--

INSERT INTO `tmp_table` (`tmp_id`, `product_id`, `qty`, `price`, `product_code`) VALUES
(20, 1, 51, 30, '33520242'),
(21, 2, 34, 35, '57623098'),
(22, 3, 21, 12, '69230049'),
(23, 20, 0, 1000, '52932406');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reference_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `from_store_id` int(11) NOT NULL,
  `to_store_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `date`, `reference_no`, `user_id`, `status`, `from_store_id`, `to_store_id`, `item`, `total_qty`, `total_tax`, `total_cost`, `shipping_cost`, `grand_total`, `document`, `note`, `created_at`, `updated_at`) VALUES
(2, '2018-10-02', 'tr-20181002-045651', 1, 1, 1, 2, 2, 15, 20, 260, 10, 270, NULL, NULL, '2018-10-01 22:56:51', '2018-10-01 23:49:29'),
(3, '2018-10-02', 'tr-20181002-055012', 1, 1, 1, 2, 1, 8, 0, 64, 0, 64, NULL, 'aaa\r\naaaa', '2018-10-01 23:50:12', '2018-10-16 00:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `company_name`, `role_id`, `store_id`, `is_active`, `is_deleted`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$WuMYvvH/v3ivlBmcpKOfb.xcfOuFIRIKZ95PykSmEW5MHFbQU6CuO', 'fs5kyjgN85FYMMaeeNFM2vxVaaHqd0JD0NpTvRXZWJmbkei2CQYlCN0d7TTC', '2018-09-17 03:34:46', '2018-09-17 03:34:46', '1234', NULL, 1, NULL, 1, 0),
(2, 'test', 'test@test.com', '$2y$10$vNEMxH3xdZQCMwRCthhdOuyWtYpmQUBPdGHyerqOXpkG5MDIdLhem', 'G0iLQvTgXkAk9dFZa3ZVo1luk9eT2gWdHnOCtCaySjMPkgeJsxooyN2h3npo', '2018-09-26 02:22:12', '2018-09-26 02:37:46', '1111', NULL, 1, NULL, 1, 0),
(3, 'staff', 'staff@lion-coders.com', '$2y$10$pzpUDSoKd5midR8zTLLe9OLdeTq1uLjGbwtlbtrLfLzCpXll1CFc2', 'flIoulDWKIkkcP5gR5fsyarEJIV2GIuRFaHZAA5hCO3VXIdMNsAuSFzgCshr', '2018-10-13 01:27:32', '2018-10-13 03:05:58', '12121', 'lioncoders', 3, 2, 1, 0),
(5, 'john', 'john@ezpos.com', '$2y$10$LaoMjJQ1CUDewnaNzUxGcO.SF77tXV16PLZ4SLtmFhyZzwxXMaMO.', '0RFMYJtj1w52wuB97ZHrGrp3gNEH0ZR3mAuKi2RaaZtSzGMZI1qLfBhDMMPO', '2018-10-15 22:19:50', '2018-10-15 22:20:18', '111', 'EZPOS', 3, 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billers`
--
ALTER TABLE `billers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_cheque`
--
ALTER TABLE `payment_with_cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_gift_card`
--
ALTER TABLE `payment_with_gift_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_paypal`
--
ALTER TABLE `payment_with_paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_setting`
--
ALTER TABLE `pos_setting`
  ADD UNIQUE KEY `pos_setting_id_unique` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_returns`
--
ALTER TABLE `product_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_store`
--
ALTER TABLE `product_store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_transfer`
--
ALTER TABLE `product_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_table`
--
ALTER TABLE `tmp_table`
  ADD PRIMARY KEY (`tmp_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjustments`
--
ALTER TABLE `adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `payment_with_cheque`
--
ALTER TABLE `payment_with_cheque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_with_gift_card`
--
ALTER TABLE `payment_with_gift_card`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_with_paypal`
--
ALTER TABLE `payment_with_paypal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `product_returns`
--
ALTER TABLE `product_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `product_store`
--
ALTER TABLE `product_store`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_transfer`
--
ALTER TABLE `product_transfer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tmp_table`
--
ALTER TABLE `tmp_table`
  MODIFY `tmp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
