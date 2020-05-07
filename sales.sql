-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2020 at 03:11 AM
-- Server version: 5.6.40-84.0-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kreateso_stand-dbc`
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
  `user_id` int(11) DEFAULT NULL,
  `is_checked` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `branch_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('in_store','out_store') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_store'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjustments`
--

INSERT INTO `adjustments` (`id`, `date`, `reference_no`, `store_id`, `document`, `total_qty`, `item`, `note`, `user_id`, `is_checked`, `branch_id`, `created_at`, `updated_at`, `type`) VALUES
(112, '2019-09-26', 'adr-20190926-080708', 39, NULL, 3, 1, NULL, 42, '0', '10', '2019-09-26 13:07:08', '2019-09-26 13:07:08', 'in_store'),
(113, '2019-09-30', 'adr-20190930-071047', 39, NULL, 5, 1, '555', 42, '0', '10', '2019-09-30 12:10:47', '2019-09-30 12:10:47', 'in_store'),
(114, '2019-09-30', 'adr-20190930-071154', 39, NULL, 2, 1, '222', 42, '0', '10', '2019-09-30 12:11:54', '2019-09-30 12:11:54', 'in_store'),
(115, '2019-10-20', 'adr-20191020-081630', 39, NULL, 1, 1, NULL, 2, '0', 'Admin', '2019-10-21 01:16:30', '2019-10-21 01:16:30', 'in_store'),
(116, '2019-10-20', 'adr-20191020-081705', 39, NULL, 1, 1, NULL, 2, '0', 'Admin', '2019-10-21 01:17:05', '2019-10-21 01:17:05', 'out_store'),
(117, '2019-11-16', 'adr-20191116-093956', 39, NULL, 1, 1, NULL, 2, '0', 'Admin', '2019-11-16 15:39:56', '2019-11-16 15:39:56', 'out_store'),
(118, '2019-11-16', 'adr-20191116-101218', 39, NULL, 3, 1, NULL, 2, '0', 'Admin', '2019-11-16 16:12:18', '2019-11-16 16:12:18', 'out_store'),
(119, '2019-11-16', 'adr-20191116-101354', 39, NULL, 4, 1, NULL, 2, '0', 'Admin', '2019-11-16 16:13:54', '2019-11-16 16:13:54', 'out_store'),
(120, '2019-11-16', 'adr-20191116-101457', 39, NULL, -9, 1, NULL, 2, '0', 'Admin', '2019-11-16 16:14:57', '2019-11-16 16:14:57', 'out_store'),
(121, '2019-11-16', 'adr-20191116-032209', 39, NULL, 1, 1, 'تصحيح ستوك', 2, '0', 'Admin', '2019-11-16 21:22:09', '2019-11-16 21:22:09', 'in_store'),
(122, '2019-12-08', 'adr-20191208-071706', 39, NULL, 10, 1, NULL, 47, '0', '10', '2019-12-09 01:17:06', '2019-12-09 01:17:06', 'in_store'),
(123, '2019-12-08', 'adr-20191208-071809', 39, NULL, 10, 1, NULL, 2, '0', 'Admin', '2019-12-09 01:18:09', '2019-12-09 01:18:09', 'in_store'),
(124, '2019-12-09', 'adr-20191209-031256', 39, NULL, 10, 1, NULL, 2, '0', 'Admin', '2019-12-09 21:12:56', '2019-12-09 21:12:56', 'in_store'),
(125, '2019-12-09', 'adr-20191209-032218', 39, NULL, 10, 1, NULL, 2, '0', 'Admin', '2019-12-09 21:22:18', '2019-12-09 21:22:18', 'in_store'),
(126, '2019-12-09', 'adr-20191209-033816', 39, NULL, 12, 2, NULL, 2, '0', 'Admin', '2019-12-09 21:38:16', '2019-12-09 21:38:16', 'in_store'),
(127, '2019-12-09', 'adr-20191209-034040', 39, NULL, 5, 1, NULL, 47, '0', '10', '2019-12-09 21:40:40', '2019-12-09 21:40:40', 'in_store'),
(128, '2019-12-09', 'adr-20191209-042121', 39, NULL, 7677, 2, NULL, 2, '0', 'Admin', '2019-12-09 22:21:21', '2019-12-09 22:21:21', 'in_store'),
(129, '2019-12-10', 'adr-20191210-062147', 39, NULL, 2, 1, NULL, 2, '0', 'Admin', '2019-12-10 12:21:47', '2019-12-10 12:21:47', 'in_store'),
(130, '2020-03-03', 'adr-20200303-015040', 40, NULL, 11, 2, 'بيان', 48, '0', '11', '2020-03-03 19:50:40', '2020-03-03 19:50:40', 'in_store'),
(131, '2020-03-03', 'adr-20200303-033819', 41, NULL, 27, 3, 'فاتورة ادخال مخزني', 48, '0', '11', '2020-03-03 21:38:19', '2020-03-03 21:38:19', 'in_store'),
(132, '2020-03-04', 'adr-20200304-035448', 42, NULL, 0, 0, NULL, 53, '0', '12', '2020-03-04 21:54:48', '2020-03-04 21:54:48', 'in_store');

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
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `address` text,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `phone`, `email`, `address`, `is_active`, `created_at`, `update_at`) VALUES
(10, 'test', '077000012566', 'test@gmail.com', 'تجريبي', 1, '2019-09-26 07:56:37', '2019-09-26 07:56:37'),
(11, 'فرع المنصور', '07701234567', 'example@branch2.com', 'العنوان', 1, '2020-03-03 13:44:08', '2020-03-03 13:44:08'),
(12, 'بغداد', '07701234567', 'bgd@demo.com', 'بغداد - المنصور', 1, '2020-03-04 09:20:10', '2020-03-04 09:20:10');

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

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `branch_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `branch_id`, `is_active`, `created_at`, `updated_at`) VALUES
(17, 'Dermo Expertise', NULL, '10', 1, NULL, NULL),
(18, 'Foam', 17, '10', 1, NULL, NULL),
(19, 'Cream', 17, '10', 1, NULL, NULL),
(20, 'Serum', 17, '10', 1, NULL, NULL),
(21, 'Tonic', 17, '10', 1, NULL, NULL),
(22, 'reem', NULL, 'Admin', 1, '2019-11-16 21:20:47', '2019-11-16 21:20:47'),
(23, 'العناية بالبشرة', NULL, '11', 1, '2020-03-03 19:47:12', '2020-03-03 19:47:12'),
(24, 'مقشر', 23, '11', 1, '2020-03-03 19:47:40', '2020-03-03 19:47:40'),
(25, 'العناية بالجسم', NULL, '11', 1, '2020-03-03 21:23:09', '2020-03-03 21:23:09'),
(26, 'مرطبات', 25, '11', 1, '2020-03-03 21:23:48', '2020-03-03 21:23:48'),
(27, 'main', NULL, '11', 1, NULL, NULL),
(28, '1', 27, '11', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cobuns`
--

CREATE TABLE `cobuns` (
  `id` int(11) NOT NULL,
  `cobun_number` int(11) DEFAULT NULL,
  `number_of_use` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `categories` text,
  `expire_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `coupon_category`
--

CREATE TABLE `coupon_category` (
  `id` int(11) NOT NULL,
  `copupon` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `value` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(6, 1, 'زبون نقدي', NULL, NULL, '07722284111', 'شارع الصناعة', 'بغداد', NULL, NULL, NULL, 1, '2019-04-29 12:53:50', '2019-04-29 12:53:50', NULL, NULL);

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
(1, 'general', '0', 1, '2018-09-24 23:35:20', '2018-09-24 23:35:52');

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
  `zero_balance` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `paginate_scrole` enum('paginate','scroll') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paginate',
  `offers_item_number` int(11) NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `created_at`, `updated_at`, `currency`, `color`, `zero_balance`, `paginate_scrole`, `offers_item_number`) VALUES
(1, 'ضفاف بغداد - DIFAF BAGHDAD', 'logo.png', '2018-07-06 06:13:11', '2019-04-22 17:02:32', 'USD', '#800000', '1', 'paginate', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `htl_product_category`
--

CREATE TABLE `htl_product_category` (
  `id` int(11) NOT NULL,
  `name` int(11) DEFAULT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_movement`
--

CREATE TABLE `item_movement` (
  `id` int(11) NOT NULL,
  `date` varchar(40) NOT NULL,
  `time` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `qty_in` int(11) NOT NULL,
  `qty_out` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `type_invoice` varchar(200) NOT NULL,
  `description` text,
  `reference` varchar(100) DEFAULT NULL,
  `branch_id` varchar(64) DEFAULT NULL,
  `attach` varchar(65) DEFAULT NULL,
  `col1` varchar(64) DEFAULT NULL,
  `col2` varchar(64) DEFAULT NULL,
  `col3` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_movement`
--

INSERT INTO `item_movement` (`id`, `date`, `time`, `user`, `product_id`, `category_id`, `store_id`, `qty_in`, `qty_out`, `balance`, `type_invoice`, `description`, `reference`, `branch_id`, `attach`, `col1`, `col2`, `col3`) VALUES
(530, '2019-09-26', '08:07:08', '42', 1746, 19, 39, 3, 0, 3, 'adjustment', NULL, 'adr-20190926-080708', '10', '', '', '', ''),
(531, '2019-09-30', '07:10:47', '42', 1759, 19, 39, 5, 0, 5, 'adjustment', '555', 'adr-20190930-071047', '10', '', '', '', ''),
(532, '2019-09-30', '07:11:54', '42', 1772, 20, 39, 2, 0, 2, 'adjustment', '222', 'adr-20190930-071154', '10', '', '', '', ''),
(533, '2019-09-30', '07:12:24', '44', 1759, 19, 39, 0, 1, 4, 'sell', '', 'sr-20190930-071224', '10', NULL, NULL, NULL, NULL),
(534, '2019-10-20', '08:16:30', '2', 1746, 19, 39, 1, 0, 4, 'adjustment', NULL, 'adr-20191020-081630', 'Admin', '', '', '', ''),
(535, '2019-10-20', '08:17:05', '2', 1745, 17, 39, 1, 0, 1, 'adjustment', NULL, 'adr-20191020-081705', 'Admin', '', '', '', ''),
(536, '2019-11-16', '09:39:56', '2', 1749, 19, 39, 1, 0, 1, 'adjustment', NULL, 'adr-20191116-093956', 'Admin', '', '', '', ''),
(537, '2019-11-16', '10:12:18', '2', 1745, 17, 39, 3, 0, 4, 'adjustment', NULL, 'adr-20191116-101218', 'Admin', '', '', '', ''),
(538, '2019-11-16', '10:13:54', '2', 1745, 17, 39, 4, 0, 8, 'adjustment', NULL, 'adr-20191116-101354', 'Admin', '', '', '', ''),
(539, '2019-11-16', '10:14:57', '2', 1745, 17, 39, -9, 0, -1, 'adjustment', NULL, 'adr-20191116-101457', 'Admin', '', '', '', ''),
(541, '2019-11-16', '03:22:09', '2', 1747, 19, 39, 1, 0, 1, 'adjustment', 'تصحيح ستوك', 'adr-20191116-032209', 'Admin', '', '', '', ''),
(542, '2019-12-09', '03:38:16', '2', 1745, 22, 39, 5, 0, 4, 'adjustment', NULL, 'adr-20191209-033816', 'Admin', '', '', '', ''),
(543, '2019-12-09', '03:38:16', '2', 1750, 19, 39, 7, 0, 7, 'adjustment', NULL, 'adr-20191209-033816', 'Admin', '', '', '', ''),
(544, '2019-12-09', '03:40:40', '47', 1749, 19, 39, 5, 0, 6, 'adjustment', NULL, 'adr-20191209-034040', '10', '', '', '', ''),
(545, '2019-12-09', '04:21:21', '2', 1745, 22, 39, 4344, 0, 4348, 'adjustment', NULL, 'adr-20191209-042121', 'Admin', NULL, '', '', ''),
(546, '2019-12-09', '04:21:21', '2', 1747, 19, 39, 3333, 0, 3334, 'adjustment', NULL, 'adr-20191209-042121', 'Admin', NULL, '', '', ''),
(547, '2019-12-10', '06:21:47', '2', 1748, 19, 39, 2, 0, 2, 'adjustment', NULL, 'adr-20191210-062147', 'Admin', '', '', '', ''),
(548, '2019-12-10', '06:29:37', '45', 1748, 19, 39, 0, 1, 1, 'sell', '', 'sr-20191210-062937', 'Admin', NULL, NULL, NULL, NULL),
(549, '2020-03-03', '01:50:40', '48', 1781, 24, 40, 5, 0, 5, 'adjustment', 'بيان', 'adr-20200303-015040', '11', '', '', '', ''),
(550, '2020-03-03', '01:50:40', '48', 1780, NULL, 40, 6, 0, 6, 'adjustment', 'بيان', 'adr-20200303-015040', '11', '', '', '', ''),
(551, '2020-03-03', '03:38:19', '48', 1780, NULL, 41, 10, 0, 10, 'adjustment', 'فاتورة ادخال مخزني', 'adr-20200303-033819', '11', '', '', '', ''),
(552, '2020-03-03', '03:38:19', '48', 1781, 24, 41, 5, 0, 5, 'adjustment', 'فاتورة ادخال مخزني', 'adr-20200303-033819', '11', '', '', '', ''),
(553, '2020-03-03', '03:38:19', '48', 1789, NULL, 41, 12, 0, 12, 'adjustment', 'فاتورة ادخال مخزني', 'adr-20200303-033819', '11', '', '', '', ''),
(554, '2020-03-03', '03:50:54', '49', 1789, NULL, 41, 0, 2, 10, 'sell', '', 'sr-20200303-035054', '11', NULL, NULL, NULL, NULL),
(555, '2020-03-03', '03:50:54', '49', 1781, 24, 41, 0, 1, 4, 'sell', '', 'sr-20200303-035054', '11', NULL, NULL, NULL, NULL),
(556, '2020-03-03', '04:21:17', '49', 1789, NULL, 41, 0, 1, 9, 'sell', '', 'sr-20200303-042117', '11', NULL, NULL, NULL, NULL);

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
(1, 'ar', '2018-07-07 22:59:17', '2019-06-13 11:28:09');

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

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('jumahmk2020@gmail.com', '$2y$10$jNxrD4KNI9gjnIXR5IQiK.gnik1ZI08QCcBCoJmtaPZj2pk9TgsEW', '2018-10-31 01:35:36');

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
(62, 'store-stock-report', 'web', '2018-10-18 02:14:58', '2018-10-18 02:14:58'),
(64, 'category-index', 'web', '2018-11-03 19:30:00', '2018-11-03 19:30:00'),
(65, 'category-add', 'web', '2018-11-03 21:34:04', '2018-11-03 21:34:04'),
(66, 'category-edit', 'web', '2018-11-04 21:37:08', '2018-11-04 21:37:08'),
(67, 'category-delete', 'web', '2018-11-05 00:40:08', '2018-11-05 00:40:08'),
(68, 'item_movement', 'web', '2018-11-03 21:36:05', '2018-11-03 21:36:05'),
(69, 'item_count_store', 'web', '2018-11-03 21:36:05', '2018-11-03 21:36:05'),
(70, 'role-index', 'web', '2018-11-11 23:41:11', '2018-11-11 23:41:11'),
(71, 'role-add', 'web', '2018-11-11 23:41:11', '2018-11-11 23:41:11'),
(72, 'role-edit', 'web', '2018-11-12 22:40:10', '2018-11-12 22:40:10'),
(73, 'role-delete', 'web', '2018-11-12 22:40:10', '2018-11-12 22:40:10'),
(74, 'adjustment-index', 'web', '2018-11-27 19:30:00', '2018-11-27 19:30:00'),
(75, 'adjustment-in', 'web', '2018-11-27 19:30:00', '2018-11-27 19:30:00'),
(76, 'adjustment-out', 'web', '2018-11-05 22:41:10', '2018-11-05 22:41:10'),
(77, 'adjusment-edit', 'web', '2018-11-05 22:41:10', '2018-11-05 22:41:10'),
(78, 'adjustment-delete', 'web', '2018-11-05 04:39:41', '2018-11-05 04:39:41'),
(79, 'product-price', 'web', '2018-11-04 12:41:36', '2018-11-04 12:41:36'),
(80, 'store_setting', 'web', '2018-11-06 00:46:08', '2018-11-06 00:46:08'),
(81, 'permission', 'web', '2018-11-04 23:40:10', '2018-11-04 23:40:10'),
(82, 'branch-index', 'web', '2019-08-10 19:30:00', '2019-08-10 19:30:00'),
(83, 'branch-create', 'web', '2019-08-10 19:30:00', '2019-08-10 19:30:00'),
(84, 'branch-edit', 'web', '2019-08-10 19:30:00', '2019-08-10 19:30:00'),
(85, 'branch-delete', 'web', '2019-08-10 19:30:00', '2019-08-10 19:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE `pincode` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status_done` enum('0','1') NOT NULL DEFAULT '1',
  `status_used` enum('0','1') NOT NULL DEFAULT '1',
  `number` varchar(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `notes` text,
  `user_inserted` varchar(64) DEFAULT NULL,
  `user_owner` varchar(64) DEFAULT NULL,
  `software_name` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 6, 5, 20, 0, 'pk_test_ITN7KOYiIsHSCQ0UMRcgaYUB', 'sk_test_TtQQaawhEYRwa3mU9CzttrEy', '2018-09-26 04:04:23', '2019-04-29 17:29:30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arabic_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_symbology` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `alert_quantity` double DEFAULT NULL,
  `promotion` tinyint(4) DEFAULT NULL,
  `promotion_price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_method` int(11) DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `external_link` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `product_details` text COLLATE utf8mb4_unicode_ci,
  `product_link` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `branch_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_variation` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `arabic_name`, `code`, `type`, `barcode_symbology`, `brand_id`, `category_id`, `unit`, `cost`, `price`, `qty`, `alert_quantity`, `promotion`, `promotion_price`, `starting_date`, `last_date`, `tax_id`, `tax_method`, `image`, `external_link`, `file`, `featured`, `product_details`, `product_link`, `is_active`, `branch_id`, `created_at`, `updated_at`, `is_variation`, `product_id`) VALUES
(1745, 'Loreal White Perfect Facial Foam 100 ml', 'لوريال', '8991380232148', 'standard', 'EAN13', NULL, 22, NULL, '0', 0, 4, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, 1, 'LorealWhitePerfectFacialFoam100ml.jpg', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-12-09 21:38:16', '0', NULL),
(1746, 'LoreaI new SKIN PERECTION 150 ml', NULL, '3600522384564', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 4, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'dr60081573917518.jpg', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-10-21 01:16:30', '0', NULL),
(1747, 'Loreal D-E. Revitalift Jour 50 ml', 'Loreal D-E. Revitalift Jour 50 ml', '3054080010159', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 1, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, 1, 'dr37711573917561.jpg', '0', NULL, NULL, '<p>يساعد على تنشيط الخلايا</p>', NULL, 1, '10', '2019-09-26 05:00:00', '2019-11-16 21:23:13', '0', NULL),
(1748, 'Loreal D-E. Revitalift Anti-Rides Nuit 50 ml', 'اوكسجين', '8032993661342', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 2, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, 1, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-12-10 12:21:47', '0', NULL),
(1749, 'Loreal D-E. Revitalift  Cream FPS 15 Jour 50 ml', NULL, '3600520949772', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 7, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-12-09 21:40:40', '0', NULL),
(1750, 'Loreal D-E. RevitaLift 10 Total Repair Jour 50 ml', NULL, '3600521985236', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 7, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-12-09 21:38:16', '0', NULL),
(1751, 'Loreal D-E. RevitaLift 10 Total Repair Night 50 ml', NULL, '3600522086970', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1752, 'Loreal D.E RevitaLift 10 Total Repair Jour 50 ml', NULL, '3600521985359', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1753, 'Loreal D-E. RevitaLift 10 Total Repair 50 ml', NULL, '3600522024675', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1754, 'Loreal Cream Revitalift Laser X3 Day 50 ml', NULL, '3600522248835', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1755, 'Loreal D-E. Revitalift Rides DE Cassure 50 ml', NULL, '3600521287309', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1756, 'Loreal D.E Revitalift Con t& Cou 50 ml', NULL, '3600521594179', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1757, 'Loreal Cream Revitalift Filler HA 50ml', NULL, '3600522892373', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1758, 'LOREAL REVITALIFT LASER X3 night  50 ml', NULL, '3600522480143', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1759, 'LOREAL REVITALIFT LASER X3 night New 50 ml', NULL, '3600522480129', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 5, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-30 12:10:47', '0', NULL),
(1760, 'Loreal Revitalift Day Cream 50 ml', NULL, '3600520564838', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1761, 'Loreal Revitalift 10 Total Repair BB Cream Light', NULL, '3600522206590', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1762, 'Loreal D-E. REVITALIFT POT50 NUIT', NULL, '3600520564845', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1763, 'Loreal D-E. Revitalift Double Lifting 30 ml', NULL, '3600520624877', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1764, 'Loreal D-E. Revitalift 10 Total Repair Serum 30 ml', NULL, '3600522089216', 'standard', 'EAN13', NULL, 20, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1765, 'Loreal D-E. Revitalift Soin ContourDes Yeux 15 ml', NULL, '3600521823682', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1766, 'Loreal D-E. Revitalift Dbl Yeux 15 ml', NULL, '3600521012697', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1767, 'Loreal D.EXP Revitalift Yeux 15 ml', NULL, '3054080019886', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1768, 'Loreal D-E. Revitalift Laser Renew Advanced', NULL, '3600520193526', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1769, 'SET Loreal D-E. Revitalift + Tonique milk', NULL, '5285001437429', 'standard', 'EAN13', NULL, 21, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1770, 'Revitalift Eye contour cream 15 ml', NULL, '3600520564913', 'standard', 'EAN13', NULL, 20, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1771, 'Loreal Revitalift 10 Total Repair BB Cream Medium', NULL, '3600522206606', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1772, 'Loreal Serum Revitalift Laser X3', NULL, '3600522249436', 'standard', 'EAN13', NULL, 20, NULL, '0', 0, 2, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-30 12:11:54', '0', NULL),
(1773, 'Loreal Cream Eye Revitalift Laser X3', NULL, '3600523436071', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1774, 'Loreal D-E. AGE Perfect Double Action 30 ml', NULL, '3600520259109', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1775, 'Loreal D.EXP Age Perfect Yeux 15 ml', NULL, '3600520070131', 'standard', 'EAN13', NULL, 19, NULL, '0', 0, 0, 0, NULL, NULL, '2019-09-26', '2019-09-26', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-09-26 05:00:00', '2019-09-26 05:00:00', '0', NULL),
(1776, 'Blue Cam', 'كاميرا زرقاء', '5000108478119', 'standard', 'EAN13', NULL, 17, NULL, '1', 1, 0, 2, NULL, '1', NULL, NULL, NULL, 1, 'BlueCam.jpg', '0', NULL, NULL, NULL, NULL, 1, 'Admin', '2019-12-09 00:59:54', '2019-12-09 00:59:54', '0', NULL),
(1777, 'Blue Camera', 'كاميرا زرقاء', '5000108478119', 'standard', 'EAN13', 3, NULL, NULL, '0', 0, 0, 0, NULL, NULL, '2019-12-08', '2019-12-08', NULL, NULL, 'dr90281575832579.jpg', '0', NULL, NULL, NULL, NULL, 1, '10', '2019-12-08 13:16:02', '2019-12-08 13:16:02', '0', NULL),
(1778, 'oxident loreal loreal', 'لوريال', '8032993661342', 'standard', 'EAN13', NULL, 17, NULL, '1', 1, 0, NULL, NULL, '1', NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 0, 'Admin', '2019-12-10 12:16:13', '2019-12-10 12:20:45', '0', NULL),
(1779, 'Scrap Item one', 'مقشر اول', '123456', 'standard', 'EAN13', 3, NULL, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 0, '11', '2020-03-03 07:48:30', '2020-03-03 19:49:44', '0', NULL),
(1780, 'Scrap Item two', 'مقشر ثاني', '123457', 'standard', 'EAN13', 3, NULL, NULL, '0', 0, 16, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 07:48:30', '2020-03-03 21:38:19', '0', NULL),
(1781, 'Skin Scrap one', 'مقشر بشرة اول', '39577201', 'standard', 'EAN13', NULL, 24, NULL, '1', 1, 10, 5, NULL, '1', NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', '0', NULL, NULL, '<p>تفاصيل</p>', NULL, 1, '11', '2020-03-03 19:49:32', '2020-03-03 21:38:19', '0', NULL),
(1782, 'jameel cream', 'مرطب جميل', '64730289', 'standard', 'EAN13', NULL, 25, NULL, '1', 1, 0, 0, NULL, '1', NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 21:25:14', '2020-03-03 21:25:14', '0', NULL),
(1783, 'item 1', 'منتج 1', '123456', 'standard', 'EAN13', NULL, 28, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 06:00:00', '2020-03-03 06:00:00', '0', NULL),
(1784, 'item2', 'منتج 2', '12334567', 'standard', 'EAN13', NULL, 28, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 06:00:00', '2020-03-03 06:00:00', '0', NULL),
(1785, 'item3', 'منتج 3', '1234564', 'standard', 'EAN13', NULL, 28, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 06:00:00', '2020-03-03 06:00:00', '0', NULL),
(1786, 'item4', 'منتج 4', '1231234', 'standard', 'EAN13', NULL, 28, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 06:00:00', '2020-03-03 06:00:00', '0', NULL),
(1787, 'item5', 'منتج 5', '453123', 'standard', 'EAN13', 3, NULL, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 09:33:08', '2020-03-03 09:33:08', '0', NULL),
(1788, 'item6', 'منتج 6', '41532', 'standard', 'EAN13', 3, NULL, NULL, '0', 0, 0, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 09:33:08', '2020-03-03 09:33:08', '0', NULL),
(1789, 'item7', 'منتج 7', '87541', 'standard', 'EAN13', 3, NULL, NULL, '0', 0, 12, 0, NULL, NULL, '2020-03-03', '2020-03-03', NULL, NULL, 'zummXD2dvAtI.png', '0', NULL, NULL, NULL, NULL, 1, '11', '2020-03-03 09:33:08', '2020-03-03 21:38:19', '0', NULL);

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
(416, 112, 1746, 3, '+', '2019-09-26 13:07:08', '2019-09-26 13:07:08'),
(417, 113, 1759, 5, '+', '2019-09-30 12:10:47', '2019-09-30 12:10:47'),
(418, 114, 1772, 2, '+', '2019-09-30 12:11:54', '2019-09-30 12:11:54'),
(419, 115, 1746, 1, '+', '2019-10-21 01:16:30', '2019-10-21 01:16:30'),
(420, 116, 1745, 1, '+', '2019-10-21 01:17:05', '2019-10-21 01:17:05'),
(421, 117, 1749, 1, '+', '2019-11-16 15:39:56', '2019-11-16 15:39:56'),
(422, 118, 1745, 3, '+', '2019-11-16 16:12:18', '2019-11-16 16:12:18'),
(423, 119, 1745, 4, '+', '2019-11-16 16:13:54', '2019-11-16 16:13:54'),
(424, 120, 1745, -9, '+', '2019-11-16 16:14:57', '2019-11-16 16:14:57'),
(425, 121, 1747, 1, '+', '2019-11-16 21:22:09', '2019-11-16 21:22:09'),
(426, 126, 1745, 5, '+', '2019-12-09 21:38:16', '2019-12-09 21:38:16'),
(427, 126, 1750, 7, '+', '2019-12-09 21:38:16', '2019-12-09 21:38:16'),
(428, 127, 1749, 5, '+', '2019-12-09 21:40:40', '2019-12-09 21:40:40'),
(429, 128, 1745, 4344, '+', '2019-12-09 10:21:21', '2019-12-09 10:21:21'),
(430, 128, 1747, 3333, '+', '2019-12-09 10:21:21', '2019-12-09 10:21:21'),
(431, 129, 1748, 2, '+', '2019-12-10 12:21:47', '2019-12-10 12:21:47'),
(432, 130, 1781, 5, '+', '2020-03-03 19:50:40', '2020-03-03 19:50:40'),
(433, 130, 1780, 6, '+', '2020-03-03 19:50:40', '2020-03-03 19:50:40'),
(434, 131, 1780, 10, '+', '2020-03-03 21:38:19', '2020-03-03 21:38:19'),
(435, 131, 1781, 5, '+', '2020-03-03 21:38:19', '2020-03-03 21:38:19'),
(436, 131, 1789, 12, '+', '2020-03-03 21:38:19', '2020-03-03 21:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery_images`
--

CREATE TABLE `product_gallery_images` (
  `id` int(11) NOT NULL,
  `imag_gallery` text,
  `product_id` int(11) DEFAULT NULL,
  `external_link` enum('0','1') NOT NULL DEFAULT '0',
  `is_active` enum('0','1') NOT NULL,
  `temp` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `product_request`
--

CREATE TABLE `product_request` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_name` varchar(64) DEFAULT NULL,
  `product_price` varchar(64) DEFAULT NULL,
  `ch_product_name` varchar(64) DEFAULT NULL,
  `ch_product_price` varchar(64) DEFAULT NULL,
  `changed_description` text,
  `currency` varchar(67) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_request`
--

INSERT INTO `product_request` (`id`, `product_id`, `request_id`, `product_qty`, `product_name`, `product_price`, `ch_product_name`, `ch_product_price`, `changed_description`, `currency`) VALUES
(312, 1759, 165, 1, 'LOREAL REVITALIFT LASER X3 night New 50 ml', '0', 'LOREAL REVITALIFT LASER X3 night New 50 ml', '0', '', 'en'),
(314, 1748, 167, 1, 'Loreal D-E. Revitalift Anti-Rides Nuit 50 ml', '0', 'Loreal D-E. Revitalift Anti-Rides Nuit 50 ml', '0', '', 'en'),
(315, 1789, 168, 2, 'item7', '0', 'item7', '0', '', 'en'),
(316, 1781, 168, 1, 'Skin Scrap one', '1', 'Skin Scrap one', '1', '', 'en'),
(317, 1789, 169, 1, 'item7', '0', 'item7', '0', '', 'en');

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
(112, 82, 1759, 1, '', 0, 0, 0, 0, 0, '2019-09-30 12:12:24', '2019-09-30 12:12:24', '0'),
(114, 84, 1748, 1, '', 0, 0, 0, 0, 0, '2019-12-10 12:29:37', '2019-12-10 12:29:37', '0'),
(115, 85, 1789, 2, '', 0, 0, 0, 0, 0, '2020-03-03 09:50:54', '2020-03-03 09:50:54', '0'),
(116, 85, 1781, 1, '', 1, 0, 0, 0, 1, '2020-03-03 09:50:54', '2020-03-03 09:50:54', '0'),
(117, 86, 1789, 1, '', 0, 0, 0, 0, 0, '2020-03-03 10:21:17', '2020-03-03 10:21:17', '0');

-- --------------------------------------------------------

--
-- Table structure for table `product_store`
--

CREATE TABLE `product_store` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `is_inserted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_store`
--

INSERT INTO `product_store` (`id`, `product_id`, `store_id`, `qty`, `is_inserted`, `created_at`, `updated_at`) VALUES
(10784, '1745', 39, 4348, '1', '2019-09-26 13:06:41', '2019-12-09 21:38:16'),
(10785, '1746', 39, 4, '1', '2019-09-26 13:06:41', '2019-10-21 01:16:30'),
(10786, '1747', 39, 3334, '1', '2019-09-26 13:06:41', '2019-11-16 21:22:09'),
(10787, '1748', 39, 1, '1', '2019-09-26 13:06:41', '2019-12-10 12:21:47'),
(10788, '1749', 39, 6, '1', '2019-09-26 13:06:41', '2019-12-09 21:40:40'),
(10789, '1750', 39, 7, '1', '2019-09-26 13:06:41', '2019-12-09 21:38:16'),
(10790, '1751', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10791, '1752', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10792, '1753', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10793, '1754', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10794, '1755', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10795, '1756', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10796, '1757', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10797, '1758', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10798, '1759', 39, 4, '1', '2019-09-26 13:06:41', '2019-09-30 12:10:47'),
(10799, '1760', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10800, '1761', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10801, '1762', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10802, '1763', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10803, '1764', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10804, '1765', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10805, '1766', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10806, '1767', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10807, '1768', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10808, '1769', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10809, '1770', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10810, '1771', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10811, '1772', 39, 2, '1', '2019-09-26 13:06:41', '2019-09-30 12:11:54'),
(10812, '1773', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10813, '1774', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10814, '1775', 39, 0, '0', '2019-09-26 13:06:41', '2019-09-26 13:06:41'),
(10815, '1777', 39, 0, '0', '2019-12-08 13:16:02', '2019-12-08 13:16:02'),
(10816, '1779', 39, 0, '0', '2020-03-03 07:48:30', '2020-03-03 07:48:30'),
(10817, '1779', 40, 0, '0', '2020-03-03 07:48:30', '2020-03-03 07:48:30'),
(10818, '1780', 39, 0, '0', '2020-03-03 07:48:30', '2020-03-03 07:48:30'),
(10819, '1780', 40, 6, '1', '2020-03-03 07:48:30', '2020-03-03 19:50:40'),
(10820, '1781', 40, 5, '1', '2020-03-03 07:49:32', '2020-03-03 19:50:40'),
(10821, '1780', 41, 10, '1', '2020-03-03 09:22:33', '2020-03-03 21:38:19'),
(10822, '1781', 41, 4, '1', '2020-03-03 09:22:33', '2020-03-03 21:38:19'),
(10823, '1782', 40, 0, '0', '2020-03-03 09:25:14', '2020-03-03 09:25:14'),
(10824, '1782', 41, 0, '0', '2020-03-03 09:25:14', '2020-03-03 09:25:14'),
(10825, '1783', 39, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10826, '1783', 40, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10827, '1783', 41, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10828, '1784', 39, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10829, '1784', 40, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10830, '1784', 41, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10831, '1785', 39, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10832, '1785', 40, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10833, '1785', 41, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10834, '1786', 39, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10835, '1786', 40, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10836, '1786', 41, 0, '0', '2020-03-03 09:30:40', '2020-03-03 09:30:40'),
(10837, '1787', 39, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10838, '1787', 40, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10839, '1787', 41, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10840, '1788', 39, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10841, '1788', 40, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10842, '1788', 41, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10843, '1789', 39, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10844, '1789', 40, 0, '0', '2020-03-03 09:33:08', '2020-03-03 09:33:08'),
(10845, '1789', 41, 9, '1', '2020-03-03 09:33:08', '2020-03-03 21:38:19');

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

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `var_photo` varchar(64) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `alert_qty` int(11) DEFAULT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(64) DEFAULT NULL,
  `customer_phone` varchar(64) NOT NULL,
  `customer_city` varchar(64) DEFAULT NULL,
  `customer_store` varchar(32) DEFAULT NULL,
  `order_note` text,
  `subtotal` varchar(64) NOT NULL,
  `shipping_cost` varchar(64) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `total` varchar(64) DEFAULT NULL,
  `is_active` enum('1','0') NOT NULL DEFAULT '1',
  `status` enum('waiting','process','pickup','delivered','paid','rejected','offer') NOT NULL DEFAULT 'waiting',
  `shipping_company` int(11) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `company_note` text,
  `from_store` int(11) DEFAULT NULL,
  `is_counted` enum('0','1') NOT NULL DEFAULT '0',
  `coupon_nu` int(11) DEFAULT NULL,
  `delivery_type` varchar(30) DEFAULT NULL,
  `reference_id` varchar(30) DEFAULT NULL,
  `is_checked` enum('1','0') DEFAULT '0',
  `is_marketer_order` enum('0','1') NOT NULL DEFAULT '0',
  `marketer_note` text,
  `branch_id` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `customer_name`, `customer_phone`, `customer_city`, `customer_store`, `order_note`, `subtotal`, `shipping_cost`, `discount`, `paid_amount`, `total`, `is_active`, `status`, `shipping_company`, `company_phone`, `company_note`, `from_store`, `is_counted`, `coupon_nu`, `delivery_type`, `reference_id`, `is_checked`, `is_marketer_order`, `marketer_note`, `branch_id`, `created_at`, `updated_at`) VALUES
(165, 'teston', '07700112565dd', NULL, '39', NULL, '0', '0', NULL, 0, '0', '1', 'rejected', NULL, NULL, NULL, NULL, '0', NULL, 'online', 'null', '0', '0', NULL, '10', '2019-09-30 07:12:24', '2019-09-30 07:12:24'),
(167, 'sanfor1', '077000012566', NULL, '39', NULL, '0', '0', NULL, 0, '0', '1', 'waiting', NULL, NULL, NULL, NULL, '0', NULL, 'online', 'null', '0', '0', NULL, 'Admin', '2019-12-10 06:29:37', '2019-12-10 06:29:37'),
(168, 'afnan', '07701234567', NULL, '41', NULL, '1', '0', NULL, 0, '1', '1', 'waiting', NULL, NULL, NULL, NULL, '0', NULL, 'online', 'null', '0', '0', NULL, '11', '2020-03-03 15:50:54', '2020-03-03 15:50:54'),
(169, 'afnan', '07701234567', NULL, '41', NULL, '0', '0', NULL, 0, '0', '1', 'waiting', NULL, NULL, NULL, NULL, '0', NULL, 'online', 'null', '0', '0', NULL, '11', '2020-03-03 16:21:17', '2020-03-03 16:21:17');

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
(2, 'Admin', 'Admin of this system...', 'web', 1, '2018-10-13 00:29:15', '2018-10-13 00:29:15'),
(6, 'موظف مبيعات', NULL, 'web', 1, '2019-06-12 11:12:04', '2019-06-12 11:12:04'),
(8, 'Marketer', NULL, 'web', 1, '2019-06-29 16:54:17', '2019-06-29 16:54:17'),
(9, 'مدير مخزن', NULL, 'web', 1, '2019-07-01 14:07:43', '2019-07-01 14:07:43'),
(11, 'branch', NULL, 'web', 1, '2019-08-10 19:30:00', '2019-08-10 19:30:00'),
(12, 'طباعة', NULL, 'web', 1, '2019-09-11 18:09:35', '2019-09-11 18:09:35'),
(13, 'مخازن', NULL, 'web', 1, '2019-09-12 09:29:20', '2019-09-12 09:29:20');

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
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(53, 2),
(59, 2),
(61, 2),
(62, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(74, 9),
(75, 9),
(76, 9),
(77, 9),
(78, 9),
(4, 11),
(5, 11),
(6, 11),
(7, 11),
(12, 11),
(13, 11),
(14, 11),
(15, 11),
(20, 11),
(21, 11),
(22, 11),
(23, 11),
(41, 11),
(42, 11),
(43, 11),
(44, 11),
(53, 11),
(59, 11),
(61, 11),
(64, 11),
(65, 11),
(66, 11),
(67, 11),
(68, 11),
(69, 11),
(70, 11),
(71, 11),
(72, 11),
(73, 11),
(74, 11),
(75, 11),
(76, 11),
(77, 11),
(78, 11),
(79, 11),
(80, 11),
(81, 11),
(12, 12),
(12, 13),
(69, 13);

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
  `order_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_printed` tinyint(4) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `branch_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `reference_no`, `user_id`, `customer_id`, `store_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `grand_total`, `order_tax_rate`, `order_tax`, `order_discount`, `shipping_cost`, `sale_status`, `payment_status`, `document`, `paid_amount`, `sale_note`, `staff_note`, `order_status`, `is_printed`, `request_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(82, '2019-09-30', 'sr-20190930-071224', 44, 6, 39, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, '', 0, NULL, '', '0', 1, 165, '10', '2019-09-30 12:12:24', '2019-09-30 12:12:24'),
(84, '2019-12-10', 'sr-20191210-062937', 45, 6, 39, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, '', 0, NULL, '', '0', 1, 167, 'Admin', '2019-12-10 12:29:37', '2019-12-10 12:29:37'),
(85, '2020-03-03', 'sr-20200303-035054', 49, 6, 41, 0, 3, 0, 0, 1, 1, 0, 0, 0, 0, 1, 2, '', 0, NULL, '', '0', 0, 168, '11', '2020-03-03 09:50:54', '2020-03-03 09:50:54'),
(86, '2020-03-03', 'sr-20200303-042117', 49, 6, 41, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, '', 0, NULL, '', '0', 0, 169, '11', '2020-03-03 10:21:17', '2020-03-03 10:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `site_setting`
--

CREATE TABLE `site_setting` (
  `id` int(11) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `phone_no1` varchar(60) NOT NULL,
  `phone_no2` varchar(60) NOT NULL,
  `email` varchar(64) NOT NULL,
  `facebook` varchar(200) NOT NULL,
  `allow_negative` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_setting`
--

INSERT INTO `site_setting` (`id`, `logo`, `title`, `phone_no1`, `phone_no2`, `email`, `facebook`, `allow_negative`) VALUES
(1, 'site_logo.png', 'ضفاف بغداد - DIFAF BAGHDAD', '07701234567', '07701234567', 'test@test.com', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `store_category_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `branch_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `phone`, `email`, `address`, `store_category_id`, `is_active`, `branch_id`, `created_at`, `updated_at`) VALUES
(39, 'whtest', '077000012566', 'test@gmail.com', 'تجريبي', NULL, 1, '10', '2019-09-26 12:59:38', '2019-09-26 12:59:38'),
(40, 'ياسر و عمر - منصور مول', '07701234567', 'ya@demo.com', 'بغداد - المنصور - منصور مول', NULL, 1, '11', '2020-03-03 19:46:43', '2020-03-03 19:46:43'),
(41, 'بابيلون مول - ضفاف بغداد', '07701234567', NULL, 'منصور بغداد', NULL, 1, '11', '2020-03-03 21:22:33', '2020-03-03 21:22:33'),
(42, 'الشهيره مول المنصور', '07712256331', NULL, NULL, NULL, 1, '12', '2020-03-04 21:49:08', '2020-03-04 21:49:08');

-- --------------------------------------------------------

--
-- Table structure for table `store_category`
--

CREATE TABLE `store_category` (
  `id` int(11) NOT NULL,
  `name` varchar(63) DEFAULT NULL,
  `description` text,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `branch_id` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `store_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selected_store` int(11) DEFAULT NULL,
  `branch_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `full_name`, `remember_token`, `created_at`, `updated_at`, `phone`, `company_name`, `role_id`, `store_id`, `selected_store`, `branch_id`, `is_active`, `is_deleted`) VALUES
(2, 'admin', 'user@gmail.com', '$2y$10$E7.0OPLsuSQN1lQdkIoGuO9VH9JPh6Fm0M8uWNwgIyz66qWl1TMN6', NULL, 'klp9alacLdpPctBwmEPEIB0NXJpf6wSjK0OdPHE7joPtbRL25x4h6UEdR9la', '2019-04-21 11:21:22', '2019-04-21 11:21:22', '07701234567', 'ابراهيم سوفت', 2, '3', NULL, 'Admin', 1, 0),
(42, 'testa', 'test@gmail.com', '$2y$10$GJ1J/XFvkuK6atRn9jsAtegyyRdn7dKvBfj51Xa2J/Fn8KkS9UOJq', NULL, 'm4Gs4lSp51bHXgqMIDTi3zpsAS4LF1k6oFFVaGhd6JseWbLoGfZcbyr2vw2r', '2019-09-26 12:57:26', '2019-09-26 12:57:26', '077000012566', NULL, 11, NULL, NULL, '10', 1, 0),
(43, 'testpp', 'testpp@gmail.com', '$2y$10$l96Gr39wXiCh/eMgLo0/jueAQmojTaKvc/DKimWWCDGPLuVB.ymAe', NULL, 'XnJjfyDhiV6m0i9TFWatgqArViyhAoKKon3tLAqhm9K3WOALQfO6MTvsLikQ', '2019-09-26 13:01:51', '2019-10-21 01:25:50', '077000012566', NULL, 13, NULL, NULL, '10', 1, 0),
(44, 'teston', 'testo@gmail.com', '$2y$10$x16ZSIfeX5D4AS/4DG7JEO2OJRNzhVJxjjXP/yP3kj8xCgpGRFPA.', NULL, '2tn9FaXyu7rQshBTsXPoRHNXowjTyeQqsC2OtjOO6YsgMG5tnyKwZfhrxnkD', '2019-09-30 12:09:34', '2019-09-30 12:09:34', '07700112565dd', NULL, 6, '39', 39, '10', 1, 0),
(45, 'sanfor1', 'test1@gmail.com', '$2y$10$IxCVwvQFoEcSAKTyJ6CBHukbNCaNo.yX5lBDeuqGFih37HLOKFyNO', 'sss', '8VOKBQ3NhnrYhs6R6gWgiEMZhOrHdkkF1CE3rLHm9W4hya91jfySvOCsRtkz', '2019-11-16 15:44:30', '2019-11-16 15:44:30', '077000012566', NULL, 6, '39', 39, 'Admin', 1, 0),
(46, 'iqmiky2', 'iqmiky@demo.com', '$2y$10$btsiaq3.lQnGssvBQhW4mOOnIA3EzHBP8xstqXtRgwTs6DauhN6wS', 'مبيعات شخص', '7SzHAKlOdEPn2AKBp3STlEE657RIr5Kw4I3IBoLk4blb73LV0L10BMwgPOdJ', '2019-12-09 01:07:10', '2019-12-09 01:07:10', '07708344321', NULL, 6, '39', 39, 'Admin', 1, 0),
(47, 'branchdemo', 'branch@demo.com', '$2y$10$3ym7e5gsp0xDbiHGdt5qiutmix8Fd.Bn3B7dU5QKTJlPIEBgWoGwq', 'branch admimn', 'mEis0EjKodjvKwFbVYQFTlSrHMhFor4aNZgeqQ8DFEOnip9QFp4Ry2kpJ7de', '2019-12-09 01:12:45', '2019-12-09 01:12:45', '07708344321', NULL, 11, NULL, NULL, '10', 1, 0),
(48, 'm-admin', 'm-admin@demo.com', '$2y$10$CFccmVXUQzafN6s9vVPC.O9JgrllG43h0JQVdx6TF7iKoJbAILnxu', 'مدير فرع المنصور', 'PD1rWJvp7kajf3KBimCOdq3gU6s8xrbOIMMr31qgpJBzBq2PuVpJREGZef4C', '2020-03-03 19:45:10', '2020-03-03 19:45:10', '07701234567', NULL, 11, NULL, NULL, '11', 1, 0),
(49, 'afnan', 'afnan@demo.com', '$2y$10$auPNWfTe0ME/b3JGwgn/O.Nc5W.x7SKu3GKdTACPVwxhgDZtKyUWG', 'افنان جمال', NULL, '2020-03-03 21:43:34', '2020-03-03 21:43:34', '07701234567', NULL, 6, '41', 41, '11', 1, 0),
(50, 'store', 'store@demo.com', '$2y$10$tDZWrExS679IPGdFb/oRGODMA29xfndRb69d/trvQiMndiN/jSrRS', 'مدير مخزن', 'v47cBuYZQ8E28sN4ZX02K6ITX8zAtrtt3CuwLTP6sIO19AgfAKKMLTOW5yZB', '2020-03-03 22:02:53', '2020-03-03 22:02:53', '07701234567', NULL, 9, NULL, NULL, '11', 1, 0),
(51, 'printer', 'printer@demo.com', '$2y$10$rd/mbTNKeYtqH82Oh0SRLuy.NigawTT3yE2PIv5QlS4INvPwvRUgi', 'محمد صلاح', 'mnJtq1HmWDTR7NyMuMUjT7k3QkwastnGBOC0gfu1UIxdZRCFyql2IyxPHwnN', '2020-03-03 22:06:07', '2020-03-03 22:06:07', '07701234567', NULL, 12, NULL, NULL, '11', 1, 0),
(52, 'store2', 'store2@demo.com', '$2y$10$P9iomvozJvTJu1fzclKjjO3WiyLlIEBlW6zp6fbNBinmnwnkPfI9K', 'مخزن فقط', NULL, '2020-03-03 22:06:51', '2020-03-03 22:06:51', '07701234567', NULL, 13, NULL, NULL, '11', 1, 0),
(53, 'badmin', 'badmin@demo.com', '$2y$10$zSBHlnBxypDRhGOAFdKhxuF1cpiERCHJysDIDkZVeb.qewM0ecriq', 'مدير فرع بغداد', 'bNzDyVTWqGznEDpIPbqJnigc4fode5DHotgwcKnUaXaJNa2JedONkqthXJWA', '2020-03-04 15:21:01', '2020-03-04 15:21:01', '07701234567', NULL, 11, NULL, NULL, '12', 1, 0);

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
-- Indexes for table `branches`
--
ALTER TABLE `branches`
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
-- Indexes for table `cobuns`
--
ALTER TABLE `cobuns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cobun_number` (`cobun_number`);

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
-- Indexes for table `coupon_category`
--
ALTER TABLE `coupon_category`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `htl_product_category`
--
ALTER TABLE `htl_product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_movement`
--
ALTER TABLE `item_movement`
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
-- Indexes for table `pincode`
--
ALTER TABLE `pincode`
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
-- Indexes for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_request`
--
ALTER TABLE `product_request`
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
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
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
-- Indexes for table `site_setting`
--
ALTER TABLE `site_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_category`
--
ALTER TABLE `store_category`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `cobuns`
--
ALTER TABLE `cobuns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coupon_category`
--
ALTER TABLE `coupon_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `htl_product_category`
--
ALTER TABLE `htl_product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_movement`
--
ALTER TABLE `item_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `pincode`
--
ALTER TABLE `pincode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1790;
--
-- AUTO_INCREMENT for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;
--
-- AUTO_INCREMENT for table `product_gallery_images`
--
ALTER TABLE `product_gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_request`
--
ALTER TABLE `product_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;
--
-- AUTO_INCREMENT for table `product_returns`
--
ALTER TABLE `product_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `product_store`
--
ALTER TABLE `product_store`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10846;
--
-- AUTO_INCREMENT for table `product_transfer`
--
ALTER TABLE `product_transfer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `site_setting`
--
ALTER TABLE `site_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `store_category`
--
ALTER TABLE `store_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tmp_table`
--
ALTER TABLE `tmp_table`
  MODIFY `tmp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
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
