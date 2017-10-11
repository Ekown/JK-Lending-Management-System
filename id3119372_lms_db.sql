-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2017 at 05:00 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id3119372_lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `name`, `company_id`) VALUES
(1, 'KATHERINE', 8),
(3, 'joseph', 9),
(4, 'noli', 9),
(5, 'jeanne', 10),
(6, 'llapitan', 11),
(7, 'campo', 9),
(8, 'bitek', 11),
(9, 'abby nievera', 8),
(11, 'emmanuel', 10),
(12, 'esmeralda', 10),
(13, 'ric john', 10),
(14, 'celia zapanta', 8),
(15, 'fernando-eddie', 11),
(16, 'mary joy naza', 12),
(17, 'jayson fermante', 11),
(18, 'may escalante', 8),
(19, 'joey platon', 11),
(20, 'jiralden', 13),
(21, 'glenda perez', 14),
(22, 'emor', 15),
(23, 'michael reyes', 14),
(24, 'jennifer', 14),
(25, 'joselito binaday', 11),
(26, 'mae - no atm', 8),
(27, 'arden', 11),
(29, 'michelle - glenda', 14),
(31, 'pesigan', 15),
(32, 'alex', 15),
(33, 'christopher', 14),
(34, 'rubinos', 9),
(35, 'agnes', 12),
(36, 'chona', 11),
(37, 'tin tin clemente', 12),
(38, 'ricky dela cruz', 9),
(39, 'apple franco', 12),
(40, 'alura', 7),
(41, 'janet paredes', 14),
(42, 'kazeem', 12),
(43, 'allan', 8),
(44, 'justine', 12),
(45, 'rishelle ann', 14),
(46, 'diana-glenda-mae', 14),
(48, 'mara', 8),
(50, 'zeny', 17),
(51, 'zenly', 8),
(52, 'anilyn', 12),
(53, 'daisy naza', 14),
(54, 'ariel', 8),
(55, 'venus', 12),
(56, 'michael', 12),
(57, 'lovely', 14),
(58, 'lovely', 14),
(59, 'joel', 17),
(60, 'rishelle argame', 12),
(61, 'mae - sheila', 8),
(62, 'mae - donna', 8),
(63, 'diana', 12),
(64, 'paul', 14),
(65, 'katherine', 14),
(66, 'loria', 19),
(67, 'ate emy hilot', 18),
(68, 'nelson-gilson', 18),
(69, 'michael sibayan', 18),
(70, 'nestor-jao', 18),
(71, 'valerie', 14),
(72, 'jonathan-buko', 18),
(73, 'sahra', 12),
(74, 'sheila', 19),
(75, 'bianca', 14),
(76, 'moncada', 18),
(77, 'glenda', 8);

-- --------------------------------------------------------

--
-- Table structure for table `cash_advances`
--

CREATE TABLE `cash_advances` (
  `id` int(10) UNSIGNED NOT NULL,
  `master_ledger_id` int(10) UNSIGNED DEFAULT NULL,
  `cash_advance_remittance_id` int(10) UNSIGNED NOT NULL,
  `cash_advance_amount_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cash_advance_amount`
--

CREATE TABLE `cash_advance_amount` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `amount` double(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_advance_remittances`
--

CREATE TABLE `cash_advance_remittances` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cash_advance_remittances`
--

INSERT INTO `cash_advance_remittances` (`id`, `amount`, `date`) VALUES
(1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cash_advance_status`
--

CREATE TABLE `cash_advance_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cash_advance_status`
--

INSERT INTO `cash_advance_status` (`id`, `name`) VALUES
(1, 'No Cash Advance'),
(2, 'Not Paid'),
(3, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(7, 'No Company 10-25'),
(8, 'MAE GADONG 6-21'),
(9, 'SG 5-20'),
(10, 'ceron 5-20'),
(11, 'no company 5-20'),
(12, 'mae gadong 10-25'),
(13, 'jehada 5-20'),
(14, 'mae gadong 15-30'),
(15, 'mariel 5-20'),
(17, 'mae gadong 5-20'),
(18, 'friday'),
(19, 'mae gadong 7-22');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(10) UNSIGNED NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `amount` double(9,2) UNSIGNED NOT NULL,
  `interested_amount` double(9,2) UNSIGNED NOT NULL,
  `term` int(11) NOT NULL,
  `percentage` int(10) UNSIGNED NOT NULL,
  `created_at` date DEFAULT NULL,
  `cash_advance_status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `term_type_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `loan_status_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `deduction` double(9,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `borrower_id`, `amount`, `interested_amount`, `term`, `percentage`, `created_at`, `cash_advance_status_id`, `term_type_id`, `loan_status_id`, `deduction`) VALUES
(1, 1, 19000.00, 25080.00, 4, 32, '2017-06-10', 1, 1, 1, 3135.00),
(2, 3, 30000.00, 46800.00, 7, 56, '2017-09-23', 1, 1, 1, 3342.86),
(3, 4, 10000.00, 11600.00, 2, 16, '2017-08-08', 1, 1, 1, 2900.00),
(4, 5, 15000.00, 18000.00, 2, 20, '2017-09-26', 1, 1, 1, 4500.00),
(5, 6, 5000.00, 5700.00, 2, 14, '2017-09-21', 1, 1, 1, 1425.00),
(6, 7, 5000.00, 5400.00, 1, 8, '2017-09-21', 1, 1, 1, 2700.00),
(7, 8, 20000.00, 28000.00, 5, 40, '2017-09-08', 1, 1, 1, 2800.00),
(8, 9, 22000.00, 29040.00, 4, 32, '2017-06-07', 1, 1, 1, 3630.00),
(9, 11, 20000.00, 24000.00, 2, 20, '2017-09-20', 1, 1, 1, 6000.00),
(10, 12, 60000.00, 84000.00, 4, 40, '2017-09-05', 1, 1, 1, 10500.00),
(11, 13, 15000.00, 18000.00, 2, 20, '2017-09-01', 1, 1, 1, 4500.00),
(12, 14, 30000.00, 44400.00, 6, 48, '2017-06-21', 1, 1, 1, 3700.00),
(13, 15, 15000.00, 22200.00, 6, 48, '2017-08-25', 1, 1, 1, 1850.00),
(14, 16, 30000.00, 39600.00, 4, 32, '2017-07-05', 1, 1, 1, 4950.00),
(15, 17, 30000.00, 44400.00, 6, 48, '2017-08-10', 1, 1, 1, 3700.00),
(16, 18, 20000.00, 26400.00, 4, 32, '2017-07-07', 1, 1, 1, 3300.00),
(17, 19, 6000.00, 6720.00, 2, 12, '2017-08-19', 1, 1, 1, 2240.00),
(18, 20, 15000.00, 18600.00, 3, 24, '2017-08-09', 1, 1, 1, 3100.00),
(19, 21, 15000.00, 18600.00, 3, 24, '2017-07-22', 1, 1, 1, 3100.00),
(20, 22, 10000.00, 11600.00, 2, 16, '2017-09-05', 1, 1, 1, 2900.00),
(21, 23, 12000.00, 13920.00, 2, 16, '2017-08-15', 1, 1, 1, 3480.00),
(22, 24, 20000.00, 24800.00, 3, 24, '2017-09-01', 1, 1, 1, 4133.33),
(23, 25, 5000.00, 5200.00, 1, 4, '2017-09-20', 1, 1, 1, 5200.00),
(24, 26, 6000.00, 6960.00, 2, 16, '2017-09-01', 1, 1, 1, 1740.00),
(25, 27, 20000.00, 24800.00, 3, 24, '2017-08-05', 1, 1, 1, 4133.33),
(27, 29, 5000.00, 6200.00, 3, 24, '2017-06-22', 1, 1, 1, 1033.33),
(29, 31, 15000.00, 21000.00, 4, 40, '2017-07-27', 1, 1, 1, 2625.00),
(30, 32, 15000.00, 22500.00, 5, 50, '2017-07-27', 1, 1, 1, 2250.00),
(31, 33, 23000.00, 26680.00, 2, 16, '2017-09-01', 1, 1, 1, 6670.00),
(32, 34, 5000.00, 5400.00, 1, 8, '2017-09-22', 1, 1, 1, 2700.00),
(33, 35, 13000.00, 16120.00, 3, 24, '2017-07-11', 1, 1, 1, 2686.67),
(34, 36, 15000.00, 18600.00, 4, 24, '2017-07-22', 1, 1, 1, 2325.00),
(35, 37, 13000.00, 15080.00, 2, 16, '2017-06-30', 1, 1, 1, 3770.00),
(36, 38, 50000.00, 74000.00, 6, 48, '2017-05-22', 1, 1, 1, 6166.67),
(37, 39, 19000.00, 23560.00, 3, 24, '2017-07-03', 1, 1, 1, 3926.67),
(38, 40, 25000.00, 33000.00, 4, 32, '2017-04-05', 1, 1, 1, 4125.00),
(39, 41, 20000.00, 28000.00, 5, 40, '2017-08-15', 1, 1, 1, 2800.00),
(40, 42, 12000.00, 13920.00, 2, 16, '2017-09-06', 1, 1, 1, 3480.00),
(41, 43, 12000.00, 13920.00, 2, 16, '2017-08-20', 1, 1, 1, 3480.00),
(42, 44, 20000.00, 24800.00, 3, 24, '2017-08-26', 1, 1, 1, 4133.33),
(43, 45, 15000.00, 18600.00, 3, 24, '2017-09-25', 1, 1, 1, 3100.00),
(44, 46, 5000.00, 5800.00, 2, 16, '2017-08-02', 1, 1, 1, 1450.00),
(45, 47, 25800.00, 38184.00, 6, 48, '2017-10-04', 1, 1, 1, 3182.00),
(46, 48, 20000.00, 28000.00, 5, 40, '2017-08-07', 1, 1, 1, 2800.00),
(47, 49, 5000.00, 6000.00, 3, 20, '2017-10-01', 1, 1, 1, 1200.00),
(48, 50, 20000.00, 24800.00, 3, 24, '2017-09-05', 1, 1, 1, 4133.33),
(49, 51, 10000.00, 11600.00, 2, 16, '2017-08-16', 1, 1, 1, 2900.00),
(50, 52, 18000.00, 22320.00, 3, 24, '2017-09-09', 1, 1, 1, 3720.00),
(51, 53, 13000.00, 16120.00, 3, 24, '2017-08-16', 1, 1, 1, 2686.67),
(52, 54, 15000.00, 17400.00, 2, 16, '2017-08-15', 1, 1, 1, 4350.00),
(53, 55, 20000.00, 24800.00, 3, 24, '2017-08-15', 1, 1, 1, 4133.33),
(54, 56, 10000.00, 11600.00, 2, 16, '2017-09-06', 1, 1, 1, 2900.00),
(55, 57, 5000.00, 5800.00, 2, 16, '2017-10-02', 1, 1, 1, 1450.00),
(56, 57, 5000.00, 5800.00, 2, 16, '2017-10-02', 1, 1, 1, 1450.00),
(57, 59, 18000.00, 20880.00, 2, 16, '2017-09-21', 1, 1, 1, 5220.00),
(58, 60, 50000.00, 90000.00, 5, 80, '2017-08-20', 1, 1, 1, 9000.00),
(59, 61, 22000.00, 23760.00, 1, 8, '2017-09-15', 1, 1, 1, 11880.00),
(60, 62, 12000.00, 13920.00, 2, 16, '2017-08-25', 1, 1, 1, 3480.00),
(61, 63, 15000.00, 18600.00, 3, 24, '2017-08-31', 1, 1, 1, 3100.00),
(62, 64, 6000.00, 6960.00, 2, 16, '2017-09-04', 1, 1, 1, 1740.00),
(63, 1, 12000.00, 13920.00, 2, 16, '2017-10-04', 1, 1, 1, 3480.00),
(64, 66, 16000.00, 18560.00, 2, 16, '2017-09-22', 1, 1, 1, 4640.00),
(65, 67, 25800.00, 38184.00, 6, 48, '2017-10-04', 1, 1, 1, 3182.00),
(66, 68, 15000.00, 19800.00, 4, 32, '2017-09-30', 1, 1, 1, 2475.00),
(67, 69, 30000.00, 44400.00, 6, 48, '2017-04-22', 1, 1, 1, 3700.00),
(68, 70, 12000.00, 14400.00, 3, 20, '2017-09-11', 1, 1, 1, 2880.00),
(69, 71, 13000.00, 16120.00, 3, 24, '2017-09-09', 1, 1, 1, 2686.67),
(70, 72, 15000.00, 18000.00, 2, 20, '2017-08-25', 1, 1, 1, 4500.00),
(71, 73, 15000.00, 18600.00, 3, 24, '2017-09-09', 1, 1, 1, 3100.00),
(72, 74, 22000.00, 23760.00, 1, 8, '2017-09-15', 1, 1, 1, 11880.00),
(73, 75, 6000.00, 6960.00, 2, 16, '2017-09-16', 1, 1, 1, 1740.00),
(74, 76, 15000.00, 18600.00, 3, 24, '2017-07-25', 1, 1, 1, 3100.00),
(75, 77, 16000.00, 18560.00, 2, 16, '2017-09-21', 1, 1, 1, 4640.00);

-- --------------------------------------------------------

--
-- Table structure for table `loan_remittances`
--

CREATE TABLE `loan_remittances` (
  `id` int(10) UNSIGNED NOT NULL,
  `loan_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` double(9,2) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `loan_remittances`
--

INSERT INTO `loan_remittances` (`id`, `loan_id`, `date`, `amount`) VALUES
(1, 1, '2017-06-21', 3135.00),
(2, 1, '2017-07-06', 3135.00),
(3, 1, '2017-07-21', 3135.00),
(4, 1, '2017-08-06', 3135.00),
(5, 3, '2017-08-22', 2900.00),
(6, 3, '2017-09-06', 2900.00),
(7, 3, '2017-09-20', 2900.00),
(8, 1, '2017-10-04', 3135.00),
(9, 1, '2017-08-19', 3135.00),
(10, 1, '2017-09-21', 3135.00),
(11, 8, '2017-06-21', 3630.00),
(12, 8, '2017-07-06', 3630.00),
(13, 8, '2017-07-21', 3630.00),
(14, 8, '2017-08-06', 3630.00),
(15, 8, '2017-08-19', 3630.00),
(16, 8, '2017-09-06', 3630.00),
(17, 8, '2017-09-21', 3630.00),
(18, 10, '2017-09-20', 6100.00),
(19, 11, '2017-09-05', 4500.00),
(20, 11, '2017-09-21', 4500.00),
(21, 12, '2017-07-06', 3700.00),
(22, 12, '2017-07-21', 3700.00),
(23, 12, '2017-08-06', 3700.00),
(24, 12, '2017-08-19', 3700.00),
(25, 12, '2017-09-06', 3700.00),
(26, 12, '2017-09-21', 3700.00),
(27, 13, '2017-09-05', 1850.00),
(28, 13, '2017-09-20', 0.00),
(29, 14, '2017-07-10', 4950.00),
(30, 14, '2017-07-22', 4950.00),
(31, 14, '2017-08-05', 4950.00),
(32, 14, '2017-08-20', 4950.00),
(33, 14, '2017-09-05', 4950.00),
(34, 14, '2017-09-20', 4950.00),
(35, 15, '2017-08-20', 3700.00),
(36, 15, '2017-09-05', 3700.00),
(37, 15, '2017-09-20', 3700.00),
(38, 17, '2017-09-05', 1600.00),
(39, 18, '2017-09-01', 3100.00),
(40, 18, '2017-09-05', 3100.00),
(41, 19, '2017-08-15', 3100.00),
(42, 18, '2017-09-20', 0.00),
(43, 19, '2017-08-31', 3100.00),
(44, 19, '2017-09-15', 3100.00),
(45, 21, '2017-08-30', 3480.00),
(46, 21, '2017-09-15', 3480.00),
(47, 20, '2017-09-20', 3000.00),
(48, 21, '2017-09-30', 3400.00),
(49, 22, '2017-09-15', 4133.00),
(50, 22, '2017-09-30', 4133.00),
(51, 25, '2017-08-19', 4133.33),
(52, 25, '2017-09-05', 4133.33),
(53, 25, '2017-09-20', 4133.33),
(54, 29, '2017-08-05', 2625.00),
(55, 29, '2017-08-19', 2625.00),
(56, 29, '2017-09-05', 2625.00),
(57, 29, '2017-09-20', 2625.00),
(58, 28, '2017-06-22', 1000.00),
(59, 28, '2017-08-21', 1000.00),
(60, 30, '2017-08-05', 2250.00),
(61, 28, '2017-09-20', 1000.00),
(62, 30, '2017-08-19', 2250.00),
(63, 30, '2017-09-05', 2250.00),
(64, 30, '2017-09-20', 2250.00),
(65, 31, '2017-09-15', 6670.00),
(66, 31, '2017-09-30', 6200.00),
(67, 33, '2017-07-11', 2687.00),
(68, 33, '2017-07-26', 2686.00),
(69, 33, '2017-08-10', 2800.00),
(70, 34, '2017-08-05', 0.00),
(71, 33, '2017-08-25', 2800.00),
(72, 33, '2017-09-10', 0.00),
(73, 34, '2017-08-20', 0.00),
(74, 33, '2017-09-25', 0.00),
(75, 34, '2017-09-06', 2325.00),
(76, 34, '2017-09-20', 2325.00),
(77, 35, '2017-07-10', 3770.00),
(78, 35, '2017-09-11', 1500.00),
(79, 35, '2017-07-25', 0.00),
(80, 35, '2017-08-10', 0.00),
(81, 35, '2017-08-25', 0.00),
(82, 36, '2017-06-06', 6000.00),
(83, 35, '2017-09-26', 1500.00),
(84, 36, '2017-06-21', 6000.00),
(85, 36, '2017-10-04', 6000.00),
(86, 36, '2017-07-21', 6000.00),
(87, 36, '2017-08-05', 6000.00),
(88, 36, '2017-08-22', 6000.00),
(89, 36, '2017-09-05', 6000.00),
(90, 36, '2017-09-20', 6000.00),
(91, 37, '2017-07-22', 3000.00),
(92, 37, '2017-08-05', 3000.00),
(93, 37, '2017-08-15', 4400.00),
(94, 37, '2017-09-01', 2440.00),
(95, 38, '2017-04-20', 4125.00),
(96, 38, '2017-05-05', 4125.00),
(97, 39, '2017-08-31', 3300.00),
(98, 38, '2017-05-20', 0.00),
(99, 39, '2017-09-15', 3300.00),
(100, 39, '2017-09-30', 3000.00),
(101, 38, '2017-06-05', 4125.00),
(102, 40, '2017-09-21', 3480.00),
(103, 38, '2017-06-20', 4125.00),
(104, 38, '2017-07-05', 2300.00),
(105, 38, '2017-07-20', 1400.00),
(106, 38, '2017-08-05', 0.00),
(107, 41, '2017-09-06', 3480.00),
(108, 41, '2017-09-21', 3480.00),
(109, 38, '2017-08-22', 2500.00),
(110, 38, '2017-09-10', 0.00),
(111, 38, '2017-09-25', 0.00),
(112, 42, '2017-09-10', 4133.00),
(113, 42, '2017-09-25', 4133.00),
(114, 43, '2017-10-02', 2100.00),
(115, 44, '2017-08-17', 1450.00),
(116, 44, '2017-09-01', 1450.00),
(117, 44, '2017-09-16', 1450.00),
(118, 46, '2017-10-04', 2800.00),
(119, 46, '2017-09-06', 2800.00),
(120, 46, '2017-09-21', 2800.00),
(121, 48, '2017-09-20', 3000.00),
(122, 49, '2017-08-19', 2900.00),
(123, 49, '2017-09-06', 2900.00),
(124, 49, '2017-09-21', 2900.00),
(125, 50, '2017-09-25', 3720.00),
(126, 51, '2017-08-30', 2686.00),
(127, 51, '2017-09-15', 2687.00),
(128, 51, '2017-09-30', 2687.00),
(129, 52, '2017-08-21', 4100.00),
(130, 52, '2017-09-06', 4100.00),
(131, 52, '2017-09-21', 4350.00),
(132, 53, '2017-08-26', 4133.00),
(133, 53, '2017-09-10', 4133.00),
(134, 53, '2017-09-25', 4133.00),
(135, 58, '2017-08-20', 4000.00),
(136, 58, '2017-09-09', 4000.00),
(137, 58, '2017-09-25', 4000.00),
(138, 60, '2017-09-06', 3480.00),
(139, 60, '2017-09-21', 3480.00),
(140, 61, '2017-09-09', 3100.00),
(141, 63, '2017-09-16', 3480.00),
(142, 64, '2017-09-09', 3480.00),
(143, 64, '2017-09-25', 1000.00),
(144, 68, '2017-09-16', 1380.00),
(145, 68, '2017-09-22', 1380.00),
(146, 68, '2017-09-29', 1380.00),
(147, 69, '2017-09-16', 2687.00),
(148, 69, '2017-09-30', 2600.00),
(149, 70, '2017-08-27', 2250.00),
(150, 70, '2017-09-01', 4500.00),
(151, 71, '2017-09-21', 3100.00),
(152, 70, '2017-09-22', 2250.00),
(153, 70, '2017-09-28', 2250.00),
(154, 73, '2017-09-30', 1740.00),
(155, 74, '2017-08-04', 1550.00);

-- --------------------------------------------------------

--
-- Table structure for table `loan_status`
--

CREATE TABLE `loan_status` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `loan_status`
--

INSERT INTO `loan_status` (`id`, `name`) VALUES
(1, 'Not Paid'),
(2, 'Paid'),
(3, 'Late');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(239, '2014_10_12_000000_create_users_table', 1),
(240, '2014_10_12_100000_create_password_resets_table', 1);

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
-- Table structure for table `term_type`
--

CREATE TABLE `term_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `term_type`
--

INSERT INTO `term_type` (`id`, `name`) VALUES
(1, 'By Month'),
(2, 'By Give');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` bigint(20) NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact_number`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', 9477984422, '$2y$10$DW2TT5LGEOf/MczIxdB0m.W0GfbXsiYYzDcPOteD5DYfYRv8a2DRe', 'RNnXlmM2GXTX7rBWBYGG9yrXsm3ApqfKtpLjebFng7BPBuonjLqon1fNWdX7', '2017-09-25 11:34:24', '2017-09-25 11:34:24'),
(2, 'Karen Mae Caile', 'karenmaecaile@yahoo.com', 9778414206, '$2y$10$yA5LCkE4F7PVu8UTE.AE..ynanbzsUDa8XfQMvHdghYUZC0dhGkB6', 'riXO4nwplqoABohTzlmHys06SjvN8TU0aiAJht7T6xBUr57vscljpzwxl7D2', '2017-10-02 20:02:08', '2017-10-02 20:02:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_advances`
--
ALTER TABLE `cash_advances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_advance_amount`
--
ALTER TABLE `cash_advance_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_advance_remittances`
--
ALTER TABLE `cash_advance_remittances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_advance_status`
--
ALTER TABLE `cash_advance_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_remittances`
--
ALTER TABLE `loan_remittances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_status`
--
ALTER TABLE `loan_status`
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
-- Indexes for table `term_type`
--
ALTER TABLE `term_type`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `cash_advances`
--
ALTER TABLE `cash_advances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_advance_amount`
--
ALTER TABLE `cash_advance_amount`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_advance_remittances`
--
ALTER TABLE `cash_advance_remittances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cash_advance_status`
--
ALTER TABLE `cash_advance_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `loan_remittances`
--
ALTER TABLE `loan_remittances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT for table `loan_status`
--
ALTER TABLE `loan_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;
--
-- AUTO_INCREMENT for table `term_type`
--
ALTER TABLE `term_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
