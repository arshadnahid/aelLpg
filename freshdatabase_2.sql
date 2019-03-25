-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2019 at 12:56 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freshdatabase_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `distributor_id` smallint(6) NOT NULL,
  `type` enum('Master','Super','User') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=distributor,2=headoffice',
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lastUpdate` date NOT NULL,
  `status` enum('1','2') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=active,2=inactive',
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `accessType` enum('1','2','','') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=means head office,2=distributor',
  `updated_by` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activationCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `distributor_id`, `type`, `name`, `phone`, `email`, `password`, `lastUpdate`, `status`, `address`, `image`, `accessType`, `updated_by`, `created_at`, `updated_at`, `activationCode`) VALUES
(1, 1, 'Master', 'Saidur Rahman', '01718248354', 'master@ael-bd.net', 'e10adc3949ba59abbe56e057f20f883e', '2019-03-11', '1', 'Hassan Plaza (2nd Floor) \r\n53 Karwan Bazar C/A \r\nTejgaon, Dhaka – 1215 ', '', '1', 0, '2019-03-11 03:55:24', '0000-00-00 00:00:00', ''),
(2, 2, 'Super', 'Md.Saidul Islam', '0188898987', 'erp@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00', '1', '', '', '2', 0, '2019-03-11 03:58:11', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `adminloghistory`
--

CREATE TABLE `adminloghistory` (
  `logId` int(11) NOT NULL,
  `adminId` smallint(6) NOT NULL,
  `logIn` datetime NOT NULL,
  `logOut` datetime DEFAULT NULL,
  `date` date NOT NULL,
  `distId` smallint(6) NOT NULL,
  `ipAddress` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adminloghistory`
--

INSERT INTO `adminloghistory` (`logId`, `adminId`, `logIn`, `logOut`, `date`, `distId`, `ipAddress`) VALUES
(1, 2, '2019-03-25 16:45:18', NULL, '2019-03-25', 2, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `admin_role_id` int(11) NOT NULL,
  `admin_id` smallint(6) NOT NULL,
  `navigation_id` tinyint(4) NOT NULL,
  `parent_id` tinyint(4) NOT NULL,
  `test` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`admin_role_id`, `admin_id`, `navigation_id`, `parent_id`, `test`) VALUES
(329, 2, 101, 0, ''),
(330, 2, 102, 0, ''),
(331, 2, 103, 0, ''),
(332, 2, 104, 0, ''),
(333, 2, 105, 0, ''),
(334, 2, 106, 0, ''),
(335, 2, 107, 0, ''),
(336, 2, 108, 0, ''),
(337, 2, 109, 0, ''),
(338, 2, 119, 0, ''),
(339, 2, 3, 2, ''),
(340, 2, 17, 2, ''),
(341, 2, 49, 2, ''),
(342, 2, 76, 2, ''),
(343, 2, 87, 2, ''),
(344, 2, 89, 2, ''),
(345, 2, 90, 2, ''),
(346, 2, 58, 80, ''),
(347, 2, 59, 80, ''),
(348, 2, 60, 80, ''),
(349, 2, 75, 80, ''),
(350, 2, 88, 80, ''),
(351, 2, 22, 81, ''),
(352, 2, 40, 81, ''),
(353, 2, 55, 81, ''),
(354, 2, 56, 81, ''),
(355, 2, 74, 81, ''),
(356, 2, 110, 0, ''),
(357, 2, 111, 0, ''),
(358, 2, 112, 0, ''),
(359, 2, 16, 9, ''),
(360, 2, 51, 9, ''),
(361, 2, 38, 10, ''),
(362, 2, 39, 10, ''),
(363, 2, 42, 10, ''),
(364, 2, 79, 10, ''),
(365, 2, 45, 12, ''),
(366, 2, 48, 12, ''),
(367, 2, 69, 12, ''),
(368, 2, 85, 12, ''),
(369, 2, 113, 0, ''),
(370, 2, 114, 0, ''),
(371, 2, 115, 0, ''),
(372, 2, 19, 13, ''),
(373, 2, 20, 13, ''),
(374, 2, 23, 14, ''),
(375, 2, 24, 14, ''),
(376, 2, 25, 14, ''),
(377, 2, 62, 14, ''),
(378, 2, 27, 15, ''),
(379, 2, 30, 15, ''),
(380, 2, 31, 15, ''),
(381, 2, 32, 15, ''),
(382, 2, 33, 15, ''),
(383, 2, 34, 15, ''),
(384, 2, 35, 15, ''),
(385, 2, 36, 15, ''),
(386, 2, 57, 15, ''),
(387, 2, 116, 0, ''),
(388, 2, 117, 0, ''),
(389, 2, 118, 0, ''),
(390, 2, 4, 7, ''),
(391, 2, 5, 7, ''),
(392, 2, 6, 7, ''),
(393, 2, 43, 7, ''),
(394, 2, 44, 7, ''),
(395, 2, 52, 7, ''),
(396, 2, 92, 7, ''),
(397, 2, 93, 7, ''),
(398, 2, 21, 8, ''),
(399, 2, 37, 8, ''),
(400, 2, 65, 8, ''),
(401, 2, 28, 11, ''),
(402, 2, 47, 11, ''),
(403, 2, 70, 11, ''),
(404, 2, 71, 11, ''),
(405, 2, 77, 11, ''),
(406, 2, 83, 11, ''),
(407, 2, 91, 11, ''),
(408, 2, 46, 72, ''),
(409, 2, 67, 72, ''),
(410, 2, 68, 72, ''),
(411, 2, 73, 72, ''),
(412, 2, 82, 72, ''),
(413, 2, 84, 72, '');

-- --------------------------------------------------------

--
-- Table structure for table `blood_group`
--

CREATE TABLE `blood_group` (
  `id` int(11) NOT NULL,
  `bloodName` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blood_group`
--

INSERT INTO `blood_group` (`id`, `bloodName`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'O+'),
(4, '0-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'B+'),
(8, 'B-');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brandId` int(11) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `brandName` varchar(55) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brandId`, `dist_id`, `brandName`, `updated_at`, `created_at`, `updated_by`) VALUES
(1, 1, 'Laugfs Gas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 1, 'Bashundhara LPG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 1, 'Jamuna Gas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 1, 'Totalgaz', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 1, 'BM Energy', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 1, 'BEXIMCO LPG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 1, 'Omera', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 1, 'Navana', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 1, 'Sketch', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 1, 'Orion', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 1, 'G-Gas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 1, 'Petromax LPG', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(13, 1, 'Eurogas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(14, 1, 'Promita', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(15, 1, 'BPC Gas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(16, 1, 'Delta Gas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(17, 1, 'Universal LP Gas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(18, 1, 'Others', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(19, 1, 'HM', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(20, 1, 'JMI', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(21, 1, 'TK', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(22, 1, 'Nozir', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(23, 1, 'Newaz', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(24, 1, 'Padma', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chartofaccount`
--

CREATE TABLE `chartofaccount` (
  `chart_id` int(11) NOT NULL,
  `rootId` tinyint(4) NOT NULL,
  `accountCode` varchar(56) NOT NULL,
  `title` varchar(120) NOT NULL,
  `parentId` smallint(6) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `dist_id` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `notShow` tinyint(4) NOT NULL,
  `common` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chartofaccount`
--

INSERT INTO `chartofaccount` (`chart_id`, `rootId`, `accountCode`, `title`, `parentId`, `status`, `dist_id`, `updated_at`, `created_at`, `updated_by`, `notShow`, `common`) VALUES
(1, 0, '', 'Assets', 0, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(2, 0, '', ' Capital & Liability', 0, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(3, 0, '', 'Income', 0, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(4, 0, '', 'Expense', 0, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(41, 1, '1 - 01', ' Non-current assets', 1, '1', 1, '2018-04-11 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(42, 1, '1 - 02', 'Current Assets', 1, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(43, 2, '2 - 01', 'Capital', 2, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(44, 2, '2 - 02', 'Non-Current Liability', 2, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(45, 2, '2 - 03', 'Current Liability', 2, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(46, 3, '3 - 01', 'Sales Revenue', 3, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(47, 3, '3 - 02', 'Bank Interest', 3, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(49, 3, '3 - 01 - 001', 'Sales', 46, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 1, 1),
(50, 2, '2 - 03 - 001', 'Supplier Payables', 45, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 1, 1),
(51, 1, '1 - 02 - 001', 'Inventories', 42, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(52, 1, '1 - 02 - 001 - 0001', 'Inventory stock', 51, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 1, 1),
(53, 1, '1 - 02 - 001 - 0002', 'Goods Receive Clear Accounts', 51, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 1, 1),
(54, 1, '1 - 02 - 002', 'Cash in Hand', 42, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(55, 1, '1 - 02 - 003', 'Cash at Bank', 42, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(58, 1, '1 - 02 - 004', 'Customer Receivable', 42, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 1, 1),
(59, 3, '3 - 01 - 002', 'Prompt Payment Discounts', 46, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(60, 2, '2 - 03 - 002', 'Sales Tax', 45, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(61, 4, '4 - 02', 'Cost of Goods', 4, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(62, 4, '4 - 02 - 001', 'Cost of Goods Product', 61, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(72, 2, '2 - 01 - 001', 'Paid up Capital', 43, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(173, 1, '1 - 02 - 001 - 0003', 'New Cylinder Stock', 51, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(325, 1, '1 - 01 - 001', 'Property ,plant & equipment', 41, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(327, 1, '1 - 01 - 001 - 0001', 'Land and Land Development', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(328, 1, '1 - 01 - 001 - 0002', 'Building', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(329, 1, '1 - 01 - 001 - 0003', 'Furniture & Fixture', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(330, 1, '1 - 01 - 001 - 0004', 'Computer', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(331, 1, '1 - 02 - 005', 'Advance against rent', 42, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(332, 1, '1 - 02 - 006', 'Advance against salary', 42, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(333, 3, '3 - 01', 'Incentive', 3, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(334, 4, '4 - 01', 'Administrative Expense', 4, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(335, 4, '4 - 02 - 002', 'Packing Materials', 61, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(336, 4, '4 - 02 - 003', 'Loading & Wages', 61, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(337, 4, '4 - 02 - 004', 'Labour Expense', 61, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(338, 4, '4 - 02 - 005', 'Selling Expense', 61, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(339, 4, '4 - 02 - 006', 'Transportation', 61, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(340, 4, '4 - 01 - 001', 'Staff Salary', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(341, 4, '4 - 01 - 002', 'Festival Bonus', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(342, 4, '4 - 01 - 003', 'Printing', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(343, 4, '4 - 01 - 004', 'Stationery', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(344, 4, '4 - 01 - 005', 'Photocopy', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(345, 4, '4 - 01 - 006', 'Conveyance', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(346, 4, '4 - 01 - 007', 'Travel', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(347, 4, '4 - 01 - 008', 'Staff Food', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(348, 4, '4 - 01 - 009', 'Office Entertainment', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(349, 4, '4 - 01 - 010', 'Guest Entertainment', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(350, 4, '4 - 01 - 011', 'Incentive', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(351, 4, '4 - 01 - 012', 'Internet', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(352, 4, '4 - 01 - 013', 'Mobile Bill', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(353, 4, '4 - 01 - 014', 'Postage & courier', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(354, 4, '4 - 01 - 015', 'Office Rent', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(355, 4, '4 - 01 - 016', 'Godown ', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(356, 4, '4 - 01 - 017', 'Water', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(357, 4, '4 - 01 - 018', 'Gas', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(358, 4, '4 - 01 - 019', 'Electricity', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(359, 4, '4 - 01 - 020', 'T & T', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(360, 4, '4 - 01 - 021', 'Vehicle Maintenance', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(361, 4, '4 - 01 - 022', 'Repair & Maintenance', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(362, 4, '4 - 01 - 023', 'Cleaning', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(363, 4, '4 - 01 - 024', 'Papers & Periodicals', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(364, 4, '4 - 01 - 025', 'Gift', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(365, 4, '4 - 01 - 026', 'Bank Charge', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(366, 4, '4 - 01 - 027', 'Consultant Fees', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(367, 4, '4 - 01 - 028', 'Legal Fees', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(368, 4, '4 - 01 - 029', 'Lawyer Fees', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(369, 4, '4 - 01 - 030', 'Audit Fees', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(370, 4, '4 - 01 - 031', 'Vehicle Registration Renewals', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(371, 4, '4 - 01 - 032', 'Trade License', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(372, 4, '4 - 01 - 033', 'Fuel and oil', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(373, 4, '4 - 01 - 034', 'C & G', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(374, 4, '4 - 01 - 035', 'Promotional Expenses', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(375, 4, '4 - 01 - 036', 'Signboards', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(376, 4, '4 - 01 - 037', 'Donation and Gift', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(377, 4, '4 - 01 - 038', 'Seminar /Advertisement', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(378, 4, '4 - 01 - 039', 'Medicine', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(379, 4, '4 - 01 - 040', 'Withdrawal', 334, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(380, 4, '4 - 02', 'Financial / Other Expenses', 4, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(381, 2, '2 - 02 - 001', 'Bank Loan', 44, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(382, 2, '2 - 02 - 002', 'Directors Loan', 44, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(383, 1, '1 - 01 - 001 - 0005', 'Air Conditioner', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(384, 1, '1 - 01 - 001 - 0006', 'Equipment', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(385, 1, '1 - 01 - 001 - 0007', 'Decoration', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(386, 1, '1 - 01 - 001 - 0008', 'Warehouse Equipment', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(387, 1, '1 - 01 - 001 - 0009', 'Vehicle', 325, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(388, 1, '1 - 01 - 002', 'Investment', 41, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(389, 1, '1 - 01 - 002 - 0001', 'FDR', 388, '1', 1, '0000-00-00 00:00:00', '2019-03-04 09:47:29', 0, 0, 1),
(390, 3, '3 - 01', 'Others Income', 3, '1', 2, '0000-00-00 00:00:00', '2019-03-20 05:52:50', 0, 0, 1),
(391, 3, '3 - 01 - 001', 'Loader', 390, '1', 2, '0000-00-00 00:00:00', '2019-03-20 05:53:05', 0, 0, 1),
(392, 3, '3 - 01 - 002', 'Transportation', 390, '1', 2, '0000-00-00 00:00:00', '2019-03-20 05:53:08', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_vendor_ledger`
--

CREATE TABLE `client_vendor_ledger` (
  `ledger_id` int(11) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `ledger_type` tinyint(4) NOT NULL COMMENT '1=client,2=vendor',
  `trans_type` varchar(100) NOT NULL,
  `history_id` int(11) NOT NULL COMMENT 'general id',
  `client_vendor_id` int(11) NOT NULL COMMENT 'ledger_type=1#customer table || ledger_type=2#vendor table',
  `amount` decimal(10,0) NOT NULL,
  `previous_due` decimal(10,0) NOT NULL,
  `dr` decimal(10,0) NOT NULL,
  `cr` decimal(10,0) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `updated_by` smallint(6) NOT NULL,
  `paymentType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_vendor_ledger`
--

INSERT INTO `client_vendor_ledger` (`ledger_id`, `dist_id`, `ledger_type`, `trans_type`, `history_id`, `client_vendor_id`, `amount`, `previous_due`, `dr`, `cr`, `balance`, `date`, `created_at`, `updated_at`, `updated_by`, `paymentType`) VALUES
(1, 2, 2, 'PV19030001', 1, 1, '1020', '0', '1020', '0', '0', '2019-03-25', '2019-03-25 04:42:38', '0000-00-00 00:00:00', 2, 'Purcahses Voucher'),
(3, 2, 1, 'SID19030001', 2, 1, '90', '0', '90', '0', '0', '2019-03-25', '2019-03-25 05:00:39', '0000-00-00 00:00:00', 2, ''),
(4, 2, 2, 'PV19030002', 3, 1, '900', '0', '900', '0', '0', '2019-03-25', '2019-03-25 07:16:24', '0000-00-00 00:00:00', 2, 'Purcahses Voucher');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `colorID` int(11) NOT NULL,
  `title` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customerID` varchar(20) NOT NULL,
  `customerType` tinyint(4) NOT NULL,
  `customerName` varchar(55) NOT NULL,
  `customerPhone` varchar(15) NOT NULL,
  `customerEmail` varchar(56) NOT NULL,
  `customerAddress` text NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customerID`, `customerType`, `customerName`, `customerPhone`, `customerEmail`, `customerAddress`, `dist_id`, `status`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'CID19030001', 1, 'c2', '', '', '', 2, '1', '2019-03-20 04:59:56', 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `customertype`
--

CREATE TABLE `customertype` (
  `type_id` int(11) NOT NULL,
  `typeTitle` varchar(100) NOT NULL,
  `dist_id` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customertype`
--

INSERT INTO `customertype` (`type_id`, `typeTitle`, `dist_id`) VALUES
(1, 'Corporate', '1'),
(2, 'Retailer', '1'),
(3, 'Wholesaler', '1'),
(4, 'Local', '1');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `district_id` int(11) NOT NULL,
  `district_title` varchar(55) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district_title`, `created_by`, `updated_at`, `created_at`) VALUES
(1, 'Comilla', 0, '0000-00-00 00:00:00', '2018-07-23 11:06:47'),
(2, 'Dhaka', 0, '0000-00-00 00:00:00', '2018-07-23 11:11:38'),
(3, 'Comilla', 0, '0000-00-00 00:00:00', '2018-07-24 05:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(2) UNSIGNED NOT NULL,
  `division_id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `website` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name`, `bn_name`, `lat`, `lon`, `website`) VALUES
(1, 3, 'Dhaka', 'ঢাকা', 23.7115253, 90.4111451, 'www.dhaka.gov.bd'),
(2, 3, 'Faridpur', 'ফরিদপুর', 23.6070822, 89.8429406, 'www.faridpur.gov.bd'),
(3, 3, 'Gazipur', 'গাজীপুর', 24.0022858, 90.4264283, 'www.gazipur.gov.bd'),
(4, 3, 'Gopalganj', 'গোপালগঞ্জ', 23.0050857, 89.8266059, 'www.gopalganj.gov.bd'),
(5, 8, 'Jamalpur', 'জামালপুর', 24.937533, 89.937775, 'www.jamalpur.gov.bd'),
(6, 3, 'Kishoreganj', 'কিশোরগঞ্জ', 24.444937, 90.776575, 'www.kishoreganj.gov.bd'),
(7, 3, 'Madaripur', 'মাদারীপুর', 23.164102, 90.1896805, 'www.madaripur.gov.bd'),
(8, 3, 'Manikganj', 'মানিকগঞ্জ', 0, 0, 'www.manikganj.gov.bd'),
(9, 3, 'Munshiganj', 'মুন্সিগঞ্জ', 0, 0, 'www.munshiganj.gov.bd'),
(10, 8, 'Mymensingh', 'ময়মনসিংহ', 0, 0, 'www.mymensingh.gov.bd'),
(11, 3, 'Narayanganj', 'নারায়াণগঞ্জ', 23.63366, 90.496482, 'www.narayanganj.gov.bd'),
(12, 3, 'Narsingdi', 'নরসিংদী', 23.932233, 90.71541, 'www.narsingdi.gov.bd'),
(13, 8, 'Netrokona', 'নেত্রকোণা', 24.870955, 90.727887, 'www.netrokona.gov.bd'),
(14, 3, 'Rajbari', 'রাজবাড়ি', 23.7574305, 89.6444665, 'www.rajbari.gov.bd'),
(15, 3, 'Shariatpur', 'শরীয়তপুর', 0, 0, 'www.shariatpur.gov.bd'),
(16, 8, 'Sherpur', 'শেরপুর', 25.0204933, 90.0152966, 'www.sherpur.gov.bd'),
(17, 3, 'Tangail', 'টাঙ্গাইল', 0, 0, 'www.tangail.gov.bd'),
(18, 5, 'Bogura', 'বগুড়া', 24.8465228, 89.377755, 'www.bogra.gov.bd'),
(19, 5, 'Joypurhat', 'জয়পুরহাট', 0, 0, 'www.joypurhat.gov.bd'),
(20, 5, 'Naogaon', 'নওগাঁ', 0, 0, 'www.naogaon.gov.bd'),
(21, 5, 'Natore', 'নাটোর', 24.420556, 89.000282, 'www.natore.gov.bd'),
(22, 5, 'Nawabganj', 'নবাবগঞ্জ', 24.5965034, 88.2775122, 'www.chapainawabganj.gov.bd'),
(23, 5, 'Pabna', 'পাবনা', 23.998524, 89.233645, 'www.pabna.gov.bd'),
(24, 5, 'Rajshahi', 'রাজশাহী', 0, 0, 'www.rajshahi.gov.bd'),
(25, 5, 'Sirajgonj', 'সিরাজগঞ্জ', 24.4533978, 89.7006815, 'www.sirajganj.gov.bd'),
(26, 6, 'Dinajpur', 'দিনাজপুর', 25.6217061, 88.6354504, 'www.dinajpur.gov.bd'),
(27, 6, 'Gaibandha', 'গাইবান্ধা', 25.328751, 89.528088, 'www.gaibandha.gov.bd'),
(28, 6, 'Kurigram', 'কুড়িগ্রাম', 25.805445, 89.636174, 'www.kurigram.gov.bd'),
(29, 6, 'Lalmonirhat', 'লালমনিরহাট', 0, 0, 'www.lalmonirhat.gov.bd'),
(30, 6, 'Nilphamari', 'নীলফামারী', 25.931794, 88.856006, 'www.nilphamari.gov.bd'),
(31, 6, 'Panchagarh', 'পঞ্চগড়', 26.3411, 88.5541606, 'www.panchagarh.gov.bd'),
(32, 6, 'Rangpur', 'রংপুর', 25.7558096, 89.244462, 'www.rangpur.gov.bd'),
(33, 6, 'Thakurgaon', 'ঠাকুরগাঁও', 26.0336945, 88.4616834, 'www.thakurgaon.gov.bd'),
(34, 1, 'Barguna', 'বরগুনা', 0, 0, 'www.barguna.gov.bd'),
(35, 1, 'Barishal', 'বরিশাল', 0, 0, 'www.barisal.gov.bd'),
(36, 1, 'Bhola', 'ভোলা', 22.685923, 90.648179, 'www.bhola.gov.bd'),
(37, 1, 'Jhalokati', 'ঝালকাঠি', 0, 0, 'www.jhalakathi.gov.bd'),
(38, 1, 'Patuakhali', 'পটুয়াখালী', 22.3596316, 90.3298712, 'www.patuakhali.gov.bd'),
(39, 1, 'Pirojpur', 'পিরোজপুর', 0, 0, 'www.pirojpur.gov.bd'),
(40, 2, 'Bandarban', 'বান্দরবান', 22.1953275, 92.2183773, 'www.bandarban.gov.bd'),
(41, 2, 'Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', 23.9570904, 91.1119286, 'www.brahmanbaria.gov.bd'),
(42, 2, 'Chandpur', 'চাঁদপুর', 23.2332585, 90.6712912, 'www.chandpur.gov.bd'),
(43, 2, 'Chattogram', 'চট্টগ্রাম', 22.335109, 91.834073, 'www.chittagong.gov.bd'),
(44, 2, 'Cumilla', 'কুমিল্লা', 23.4682747, 91.1788135, 'www.comilla.gov.bd'),
(45, 2, 'Cox\'s Bazar', 'কক্স বাজার', 0, 0, 'www.coxsbazar.gov.bd'),
(46, 2, 'Feni', 'ফেনী', 23.023231, 91.3840844, 'www.feni.gov.bd'),
(47, 2, 'Khagrachari', 'খাগড়াছড়ি', 23.119285, 91.984663, 'www.khagrachhari.gov.bd'),
(48, 2, 'Lakshmipur', 'লক্ষ্মীপুর', 22.942477, 90.841184, 'www.lakshmipur.gov.bd'),
(49, 2, 'Noakhali', 'নোয়াখালী', 22.869563, 91.099398, 'www.noakhali.gov.bd'),
(50, 2, 'Rangamati', 'রাঙ্গামাটি', 0, 0, 'www.rangamati.gov.bd'),
(51, 7, 'Habiganj', 'হবিগঞ্জ', 24.374945, 91.41553, 'www.habiganj.gov.bd'),
(52, 7, 'Maulvibazar', 'মৌলভীবাজার', 24.482934, 91.777417, 'www.moulvibazar.gov.bd'),
(53, 7, 'Sunamganj', 'সুনামগঞ্জ', 25.0658042, 91.3950115, 'www.sunamganj.gov.bd'),
(54, 7, 'Sylhet', 'সিলেট', 24.8897956, 91.8697894, 'www.sylhet.gov.bd'),
(55, 4, 'Bagerhat', 'বাগেরহাট', 22.651568, 89.785938, 'www.bagerhat.gov.bd'),
(56, 4, 'Chuadanga', 'চুয়াডাঙ্গা', 23.6401961, 88.841841, 'www.chuadanga.gov.bd'),
(57, 4, 'Jashore', 'যশোর', 23.16643, 89.2081126, 'www.jessore.gov.bd'),
(58, 4, 'Jhenaidah', 'ঝিনাইদহ', 23.5448176, 89.1539213, 'www.jhenaidah.gov.bd'),
(59, 4, 'Khulna', 'খুলনা', 22.815774, 89.568679, 'www.khulna.gov.bd'),
(60, 4, 'Kushtia', 'কুষ্টিয়া', 23.901258, 89.120482, 'www.kushtia.gov.bd'),
(61, 4, 'Magura', 'মাগুরা', 23.487337, 89.419956, 'www.magura.gov.bd'),
(62, 4, 'Meherpur', 'মেহেরপুর', 23.762213, 88.631821, 'www.meherpur.gov.bd'),
(63, 4, 'Narail', 'নড়াইল', 23.172534, 89.512672, 'www.narail.gov.bd'),
(64, 4, 'Satkhira', 'সাতক্ষীরা', 0, 0, 'www.satkhira.gov.bd');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `bn_name`) VALUES
(1, 'Barishal', 'বরিশাল'),
(2, 'Chattogram', 'চট্টগ্রাম'),
(3, 'Dhaka', 'ঢাকা'),
(4, 'Khulna', 'খুলনা'),
(5, 'Rajshahi', 'রাজশাহী'),
(6, 'Rangpur', 'রংপুর'),
(7, 'Sylhet', 'সিলেট'),
(8, 'Mymensingh', 'ময়মনসিংহ');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `profile` varchar(200) DEFAULT NULL,
  `employeeId` varchar(55) DEFAULT NULL,
  `fathersName` varchar(55) DEFAULT NULL,
  `mothersName` varchar(55) DEFAULT NULL,
  `presentAddress` text NOT NULL,
  `permanentAddress` text,
  `dateOfBirth` varchar(15) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `religion` int(11) DEFAULT NULL,
  `homeDistrict` int(11) DEFAULT NULL,
  `nationalId` varchar(25) NOT NULL,
  `maritalStatus` enum('Married','Unmarried') DEFAULT NULL,
  `personalMobile` varchar(15) NOT NULL,
  `officeMobile` varchar(15) DEFAULT NULL,
  `bloodGroup` tinyint(4) DEFAULT NULL,
  `emailAddress` varchar(55) DEFAULT NULL,
  `workLocation` int(11) DEFAULT NULL,
  `status` enum('Regular','Iregular') DEFAULT NULL,
  `joiningDate` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `empStatus` enum('Active','Inactive') DEFAULT NULL,
  `employeeType` varchar(15) DEFAULT NULL,
  `dist_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  `updatedBy` int(11) NOT NULL,
  `isActive` enum('Y','N') NOT NULL,
  `isDelete` enum('Y','N') NOT NULL,
  `deletedAt` datetime NOT NULL,
  `deletedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `profile`, `employeeId`, `fathersName`, `mothersName`, `presentAddress`, `permanentAddress`, `dateOfBirth`, `gender`, `religion`, `homeDistrict`, `nationalId`, `maritalStatus`, `personalMobile`, `officeMobile`, `bloodGroup`, `emailAddress`, `workLocation`, `status`, `joiningDate`, `salary`, `empStatus`, `employeeType`, `dist_id`, `createdAt`, `updatedAt`, `createdBy`, `updatedBy`, `isActive`, `isDelete`, `deletedAt`, `deletedBy`) VALUES
(1, 'erp', 'al amin_1552969638.jpg', 'dfsdfsd', 'sfs', 'sdfsdf', 'sdfsdf', 'sdfsdf', '19-03-2019', 'Female', 2, 40, 'sdfsdf', 'Unmarried', 'fsdfsd', 'fsdfsdf', 2, 'sfsd', 0, 'Regular', '0000-00-00', '0.00', 'Active', '0', 0, '2019-03-19 04:27:18', '0000-00-00 00:00:00', 14, 0, 'Y', 'N', '0000-00-00 00:00:00', 0),
(2, 'singers', 'al amin_1552972308.jpg', 'fsdfsd', 'sdfsdf', 'sdf', 'sdfsdfsdfsds', 'dfsdfsdf', '2019-03-19', 'Female', 2, 40, 'sdfsd', 'Unmarried', 'sdf', 'sdfsdfsd', 1, 'fsdf', 0, 'Regular', '2019-06-04', '1000.00', 'Active', 'Loader', 23, '2019-03-19 04:28:52', '0000-00-00 00:00:00', 14, 0, 'Y', 'Y', '2019-03-19 10:45:00', 14),
(3, 'erp', 'al amin_1552970236.jpg', 'sfsd', 'fsdfs', 'dfsd', 'fsdfsdf', 'sdfsd', '19-03-2019', 'Male', 1, 40, 'sdfsd', 'Unmarried', 'fdsf', 'sdfdsf', 1, 'fsdfsd', 0, 'Regular', '0000-00-00', '0.00', 'Active', '0', 23, '2019-03-19 04:37:16', '0000-00-00 00:00:00', 14, 0, 'Y', 'Y', '2019-03-19 10:45:01', 14),
(4, 'Rumman Baby', 'al amin_1552972730.jpg', '00007', 'mr.kamal', 'mrs.fatema', 'dhaka', 'dhaka', '2010-01-05', 'Male', 1, 16, '0007', 'Married', '01916666589', '01856665256', 1, 'salauddin@gmail.com', 0, 'Regular', '2019-03-19', '2000.00', 'Active', 'Staff', 23, '2019-03-19 05:18:42', '0000-00-00 00:00:00', 14, 0, 'Y', 'N', '0000-00-00 00:00:00', 0),
(5, 'erp', '', '', '', '', 'ertert', '', '2019-03-06', NULL, NULL, 0, 'werwere', NULL, '01816665298', '', NULL, '', NULL, NULL, '2019-03-19', '0.00', NULL, NULL, 23, '2019-03-19 05:28:18', '0000-00-00 00:00:00', 14, 0, 'Y', 'Y', '2019-03-19 10:58:41', 14),
(6, 'Saiful Isam', '', '0007', 'Ahasan ULLAH', 'SELENA BEGUM', 'DHAKA', '', '2019-03-20', NULL, NULL, 0, '01916665298', NULL, '01816665298', '', NULL, '', NULL, NULL, '2019-03-20', '0.00', NULL, NULL, 2, '2019-03-20 04:56:48', '0000-00-00 00:00:00', 2, 0, 'Y', 'N', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `name`) VALUES
(1, 'Journal Voucher'),
(2, 'Payment Voucher'),
(3, 'Receive Voucher'),
(4, 'Funds Transfer'),
(5, 'Sales Invoice'),
(6, 'Customer Credit Note'),
(7, 'Customer Payment'),
(8, 'Delivery Note'),
(9, 'Location Transfer'),
(10, 'Inventory Adjustment'),
(11, 'Purchase Voucher'),
(12, 'Supplier Invoice'),
(13, 'Supplier Credit Note'),
(14, 'Supplier Payment'),
(15, 'Purchase Delivery'),
(16, 'Purchase Order'),
(17, 'Work Order Issue'),
(18, 'Work Order Production'),
(19, 'Sales Order'),
(20, 'Sales Quotation'),
(21, 'Cost Update'),
(22, 'Dimension'),
(23, 'Cylinder Out'),
(24, 'Cylinder In'),
(25, 'Supplier Opening'),
(26, 'Customer Opening'),
(27, 'Cylinder In/Out Journal'),
(28, 'Cylinder Opening'),
(29, 'Bill Invoice'),
(30, 'Bill Payment');

-- --------------------------------------------------------

--
-- Table structure for table `generaldata`
--

CREATE TABLE `generaldata` (
  `generalId` int(11) NOT NULL,
  `code` varchar(55) NOT NULL,
  `rootId` tinyint(4) NOT NULL,
  `title` varchar(120) NOT NULL,
  `parentId` smallint(6) NOT NULL,
  `chartId` int(11) NOT NULL,
  `dist_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `generaldata`
--

INSERT INTO `generaldata` (`generalId`, `code`, `rootId`, `title`, `parentId`, `chartId`, `dist_id`) VALUES
(215, '1 - 01 - 001 - 0001', 1, 'Land and Land Development', 325, 327, 2),
(216, '1 - 01 - 001 - 0002', 1, 'Building', 325, 328, 2),
(217, '1 - 01 - 001 - 0003', 1, 'Furniture & Fixture', 325, 329, 2),
(218, '1 - 01 - 001 - 0004', 1, 'Computer', 325, 330, 2),
(219, '1 - 01 - 001 - 0005', 1, 'Air Conditioner', 325, 383, 2),
(220, '1 - 01 - 001 - 0006', 1, 'Equipment', 325, 384, 2),
(221, '1 - 01 - 001 - 0007', 1, 'Decoration', 325, 385, 2),
(222, '1 - 01 - 001 - 0008', 1, 'Warehouse Equipment', 325, 386, 2),
(223, '1 - 01 - 001 - 0009', 1, 'Vehicle', 325, 387, 2),
(224, '1 - 01 - 002 - 0001', 1, 'FDR', 388, 389, 2),
(225, '1 - 02 - 001 - 0001', 1, 'Inventory stock', 51, 52, 2),
(226, '1 - 02 - 001 - 0002', 1, 'Goods Receive Clear Accounts', 51, 53, 2),
(227, '1 - 02 - 001 - 0003', 1, 'New Cylinder Stock', 51, 173, 2),
(228, '1 - 02 - 002', 1, 'Cash in Hand', 42, 54, 2),
(229, '1 - 02 - 003', 1, 'Cash at Bank', 42, 55, 2),
(230, '1 - 02 - 004', 1, 'Customer Receivable', 42, 58, 2),
(231, '1 - 02 - 005', 1, 'Advance against rent', 42, 331, 2),
(232, '1 - 02 - 006', 1, 'Advance against salary', 42, 332, 2),
(233, '2 - 01 - 001', 2, 'Paid up Capital', 43, 72, 2),
(234, '2 - 02 - 001', 2, 'Bank Loan', 44, 381, 2),
(235, '2 - 02 - 002', 2, 'Directors Loan', 44, 382, 2),
(236, '2 - 03 - 001', 2, 'Supplier Payables', 45, 50, 2),
(237, '2 - 03 - 002', 2, 'Sales Tax', 45, 60, 2),
(238, '3 - 01 - 001', 3, 'Sales', 46, 49, 2),
(239, '3 - 01 - 002', 3, 'Prompt Payment Discounts', 46, 59, 2),
(240, '4 - 02 - 001', 4, 'Cost of Goods Product', 61, 62, 2),
(241, '4 - 02 - 002', 4, 'Packing Materials', 61, 335, 2),
(242, '4 - 02 - 003', 4, 'Loading & Wages', 61, 336, 2),
(243, '4 - 02 - 004', 4, 'Labour Expense', 61, 337, 2),
(244, '4 - 02 - 005', 4, 'Selling Expense', 61, 338, 2),
(245, '4 - 02 - 006', 4, 'Transportation', 61, 339, 2),
(246, '4 - 01 - 001', 4, 'Staff Salary', 334, 340, 2),
(247, '4 - 01 - 002', 4, 'Festival Bonus', 334, 341, 2),
(248, '4 - 01 - 003', 4, 'Printing', 334, 342, 2),
(249, '4 - 01 - 004', 4, 'Stationery', 334, 343, 2),
(250, '4 - 01 - 005', 4, 'Photocopy', 334, 344, 2),
(251, '4 - 01 - 006', 4, 'Conveyance', 334, 345, 2),
(252, '4 - 01 - 007', 4, 'Travel', 334, 346, 2),
(253, '4 - 01 - 008', 4, 'Staff Food', 334, 347, 2),
(254, '4 - 01 - 009', 4, 'Office Entertainment', 334, 348, 2),
(255, '4 - 01 - 010', 4, 'Guest Entertainment', 334, 349, 2),
(256, '4 - 01 - 011', 4, 'Incentive', 334, 350, 2),
(257, '4 - 01 - 012', 4, 'Internet', 334, 351, 2),
(258, '4 - 01 - 013', 4, 'Mobile Bill', 334, 352, 2),
(259, '4 - 01 - 014', 4, 'Postage & courier', 334, 353, 2),
(260, '4 - 01 - 015', 4, 'Office Rent', 334, 354, 2),
(261, '4 - 01 - 016', 4, 'Godown ', 334, 355, 2),
(262, '4 - 01 - 017', 4, 'Water', 334, 356, 2),
(263, '4 - 01 - 018', 4, 'Gas', 334, 357, 2),
(264, '4 - 01 - 019', 4, 'Electricity', 334, 358, 2),
(265, '4 - 01 - 020', 4, 'T & T', 334, 359, 2),
(266, '4 - 01 - 021', 4, 'Vehicle Maintenance', 334, 360, 2),
(267, '4 - 01 - 022', 4, 'Repair & Maintenance', 334, 361, 2),
(268, '4 - 01 - 023', 4, 'Cleaning', 334, 362, 2),
(269, '4 - 01 - 024', 4, 'Papers & Periodicals', 334, 363, 2),
(270, '4 - 01 - 025', 4, 'Gift', 334, 364, 2),
(271, '4 - 01 - 026', 4, 'Bank Charge', 334, 365, 2),
(272, '4 - 01 - 027', 4, 'Consultant Fees', 334, 366, 2),
(273, '4 - 01 - 028', 4, 'Legal Fees', 334, 367, 2),
(274, '4 - 01 - 029', 4, 'Lawyer Fees', 334, 368, 2),
(275, '4 - 01 - 030', 4, 'Audit Fees', 334, 369, 2),
(276, '4 - 01 - 031', 4, 'Vehicle Registration Renewals', 334, 370, 2),
(277, '4 - 01 - 032', 4, 'Trade License', 334, 371, 2),
(278, '4 - 01 - 033', 4, 'Fuel and oil', 334, 372, 2),
(279, '4 - 01 - 034', 4, 'C & G', 334, 373, 2),
(280, '4 - 01 - 035', 4, 'Promotional Expenses', 334, 374, 2),
(281, '4 - 01 - 036', 4, 'Signboards', 334, 375, 2),
(282, '4 - 01 - 037', 4, 'Donation and Gift', 334, 376, 2),
(283, '4 - 01 - 038', 4, 'Seminar /Advertisement', 334, 377, 2),
(284, '4 - 01 - 039', 4, 'Medicine', 334, 378, 2),
(285, '4 - 01 - 040', 4, 'Withdrawal', 334, 379, 2),
(286, '3 - 01 - 001', 3, 'Loader', 390, 391, 2),
(287, '3 - 01 - 002', 3, 'Transportation', 390, 392, 2);

-- --------------------------------------------------------

--
-- Table structure for table `generalledger`
--

CREATE TABLE `generalledger` (
  `generalledger_id` int(50) NOT NULL,
  `generals_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `form_id` tinyint(4) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `account` int(11) NOT NULL COMMENT 'chart_master -> code',
  `debit` decimal(15,2) NOT NULL,
  `credit` decimal(15,2) NOT NULL,
  `memo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `generalledger`
--

INSERT INTO `generalledger` (`generalledger_id`, `generals_id`, `date`, `form_id`, `dist_id`, `account`, `debit`, `credit`, `memo`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-03-25', 11, 2, 50, '0.00', '1020.00', 'purchases', 2, '2019-03-25 04:12:38', '0000-00-00 00:00:00'),
(2, 1, '2019-03-25', 11, 2, 173, '1000.00', '0.00', 'purchases', 2, '2019-03-25 04:12:38', '0000-00-00 00:00:00'),
(3, 1, '2019-03-25', 11, 2, 336, '10.00', '0.00', 'Loading and wages', 2, '2019-03-25 04:12:38', '0000-00-00 00:00:00'),
(4, 1, '2019-03-25', 11, 2, 339, '10.00', '0.00', 'Transportation', 2, '2019-03-25 04:12:38', '0000-00-00 00:00:00'),
(12, 2, '2019-03-25', 5, 2, 58, '90.00', '0.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(13, 2, '2019-03-25', 5, 2, 59, '20.00', '0.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(14, 2, '2019-03-25', 5, 2, 49, '0.00', '100.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(15, 2, '2019-03-25', 5, 2, 62, '100.00', '0.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(16, 2, '2019-03-25', 5, 2, 173, '0.00', '100.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(17, 2, '2019-03-25', 5, 2, 391, '0.00', '5.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(18, 2, '2019-03-25', 5, 2, 392, '0.00', '5.00', '', 2, '2019-03-25 05:00:39', '0000-00-00 00:00:00'),
(19, 3, '2019-03-25', 11, 2, 50, '0.00', '900.00', 'purchases', 2, '2019-03-25 06:46:24', '0000-00-00 00:00:00'),
(20, 3, '2019-03-25', 11, 2, 173, '1000.00', '0.00', 'purchases', 2, '2019-03-25 06:46:24', '0000-00-00 00:00:00'),
(21, 3, '2019-03-25', 11, 2, 336, '0.00', '0.00', 'Loading and wages', 2, '2019-03-25 06:46:24', '0000-00-00 00:00:00'),
(22, 3, '2019-03-25', 11, 2, 339, '0.00', '0.00', 'Transportation', 2, '2019-03-25 06:46:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `generals`
--

CREATE TABLE `generals` (
  `generals_id` int(11) NOT NULL,
  `form_id` tinyint(4) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `payType` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=Cash,2=Credit,3=Bank,4=cash',
  `voucher_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `miscellaneous` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `contract_no` text COLLATE utf8_unicode_ci NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `vat` decimal(10,2) NOT NULL,
  `debit` decimal(15,2) NOT NULL,
  `credit` decimal(15,2) NOT NULL,
  `vatAmount` decimal(10,2) NOT NULL,
  `narration` longtext COLLATE utf8_unicode_ci NOT NULL,
  `orderStatus` tinyint(4) DEFAULT '1' COMMENT '1=pending,2=confirm,3=cancel',
  `shipAddress` text COLLATE utf8_unicode_ci NOT NULL,
  `deliveryDate` date NOT NULL,
  `orderId` int(11) NOT NULL,
  `dueDate` date NOT NULL,
  `qtyIn` int(11) NOT NULL,
  `qtyOut` int(11) NOT NULL,
  `loader` int(11) DEFAULT NULL COMMENT 'employee id',
  `transportation` int(11) DEFAULT NULL COMMENT 'vehicle id',
  `loaderAmount` decimal(10,2) DEFAULT NULL,
  `transportationAmount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` smallint(6) NOT NULL,
  `mainInvoiceId` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `generals`
--

INSERT INTO `generals` (`generals_id`, `form_id`, `dist_id`, `payType`, `voucher_no`, `reference`, `date`, `miscellaneous`, `customer_id`, `supplier_id`, `contract_no`, `discount`, `vat`, `debit`, `credit`, `vatAmount`, `narration`, `orderStatus`, `shipAddress`, `deliveryDate`, `orderId`, `dueDate`, `qtyIn`, `qtyOut`, `loader`, `transportation`, `loaderAmount`, `transportationAmount`, `created_at`, `updated_at`, `updated_by`, `mainInvoiceId`) VALUES
(1, 11, 2, '2', 'PV19030001', '', '2019-03-25', '', 0, 1, '', '0.00', '0.00', '1000.00', '0.00', '0.00', '', 1, '', '0000-00-00', 0, '2019-03-25', 0, 0, 6, 1, '10.00', '10.00', '2019-03-25 04:12:38', '0000-00-00 00:00:00', 2, ''),
(2, 5, 2, '2', 'SID19030001', '1', '2019-03-25', '', 1, NULL, '', '20.00', '0.00', '90.00', '0.00', '0.00', '', 1, '', '0000-00-00', 0, '0000-00-00', 0, 0, 6, 1, '5.00', '5.00', '2019-03-25 05:00:09', '2019-03-25 04:30:39', 2, ''),
(3, 11, 2, '2', 'PV19030002', '', '2019-03-25', '', 0, 1, '', '100.00', '0.00', '1000.00', '0.00', '0.00', '', 1, '', '0000-00-00', 0, '2019-03-25', 0, 0, 6, 1, '0.00', '0.00', '2019-03-25 06:46:24', '0000-00-00 00:00:00', 2, '1111');

-- --------------------------------------------------------

--
-- Table structure for table `incentive`
--

CREATE TABLE `incentive` (
  `incentive_id` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL COMMENT 'distributor id',
  `company` int(11) NOT NULL COMMENT 'branch supp omera,laugfs',
  `incentive` varchar(120) NOT NULL COMMENT 'price,air ticket,gift',
  `start` date NOT NULL COMMENT 'time/daily,monthly,yearly',
  `end` date NOT NULL,
  `targetQty` float NOT NULL,
  `updatedAt` datetime NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgId` int(11) NOT NULL,
  `msgSubject` varchar(120) NOT NULL,
  `msgDescrip` text NOT NULL,
  `date` date NOT NULL,
  `type` enum('1','2') NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msgTo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messageuser`
--

CREATE TABLE `messageuser` (
  `msgUserid` int(11) NOT NULL,
  `msgid` int(11) NOT NULL,
  `userid` text NOT NULL,
  `date` date NOT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1=pending,2=approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `moneyreceit`
--

CREATE TABLE `moneyreceit` (
  `moneyReceitid` int(11) NOT NULL,
  `mainInvoiceId` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `receiveType` enum('1','2') NOT NULL COMMENT '1=Customer2=Supplier',
  `customerid` int(11) NOT NULL,
  `paymentType` tinyint(4) NOT NULL COMMENT '1=Cash,2=check,3=Partial,4=cheque bounce',
  `receitID` varchar(15) NOT NULL,
  `invoiceID` text NOT NULL,
  `date` date NOT NULL,
  `totalPayment` decimal(10,2) NOT NULL,
  `bankName` varchar(120) NOT NULL,
  `checkNo` varchar(120) NOT NULL,
  `checkDate` date NOT NULL,
  `branchName` varchar(120) NOT NULL,
  `narration` text NOT NULL,
  `received_date` date NOT NULL,
  `checkStatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=pending,2=receive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `navigation_id` int(11) NOT NULL,
  `label` varchar(120) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'parent_id => navigation_id',
  `url` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `object_class` varchar(100) NOT NULL,
  `object_id` varchar(100) NOT NULL,
  `extra_attribute` varchar(100) NOT NULL,
  `target` varchar(30) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'administration',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `orderBy` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`navigation_id`, `label`, `parent_id`, `url`, `icon`, `object_class`, `object_id`, `extra_attribute`, `target`, `user_type`, `active`, `orderBy`) VALUES
(2, 'Setup', 1001, '', 'fa fa-cog bigger-130', '', '', '', '', 'administration', 1, 1),
(3, 'System Config', 2, 'SystemConfig', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(4, 'Supplier List', 7, 'supplierList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(5, 'Product Category', 7, 'productCatList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(6, 'Product List', 7, 'productList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(7, 'Inventory Setup', 1002, '', 'fa fa-sitemap', '', '', '', '', 'administration', 1, 2),
(8, 'Inventory Transactions', 1002, '', 'fa fa-sitemap', '', '', '', '', 'administration', 1, 3),
(9, 'Sales Setup', 1003, '', 'fa fa-truck', '', '', '', '', 'administration', 1, 5),
(10, 'Sales Transaction', 1003, '', 'fa fa-truck', '', '', '', '', 'administration', 1, 6),
(11, 'Inventory Report', 1002, '', 'fa fa-sitemap', '', '', '', '', 'administration', 1, 4),
(12, 'Sales Report', 1003, '', 'fa fa-truck', '', '', '', '', 'administration', 1, 7),
(13, 'Accounts Setup', 1004, '', 'fa fa-bar-chart-o', '', '', '', '', 'administration', 1, 8),
(14, 'Accounts Transaction', 1004, '', 'fa fa-bar-chart-o', '', '', '', '', 'administration', 1, 9),
(15, 'Accounts Report', 1004, '', 'fa fa-bar-chart-o', '', '', '', '', 'administration', 1, 10),
(16, 'Customer List', 9, 'customerList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(17, 'User Access', 2, 'userAccess', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(19, 'List Chart of Account', 13, 'listChartOfAccount', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(20, 'View Chart of Account', 13, 'viewChartOfAccount', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(21, 'Purchases Voucher', 8, 'purchases_list', 'fa fa-share', '', '', '', '', 'administration', 1, 1),
(22, 'Opening Balance', 81, 'openingBalance', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(23, 'Payment Voucher', 14, 'paymentVoucher', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(24, 'Receive Voucher', 14, 'receiveVoucher', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(25, 'Journal Voucher', 14, 'journalVoucher', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(26, 'Sales Order', 10, 'salesOrder', 'fa fa-share', '', '', '', '', 'administration', 0, 0),
(27, 'General Ledger', 15, 'generalLedger', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(28, 'Stock Report', 11, 'stockReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(29, 'Stock Category Report', 111, 'stockCatReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(30, 'Trial Balance', 15, 'trialBalance', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(31, 'Balance Sheet', 15, 'balanceSheet', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(32, 'Income Statement', 15, 'incomeStetement', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(33, 'Cash Flow', 15, 'cashFlow', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(34, 'Cash Book', 15, 'cashBook', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(35, 'Bank Book', 15, 'bankBook', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(36, 'Customer Ledger', 15, 'customerLedger', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(37, 'Supplier Payment', 8, 'supplierPayment', 'fa fa-share', '', '', '', '', 'administration', 1, 2),
(38, 'Sales Invoice', 10, 'salesInvoice', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(39, 'Customer Payment', 10, 'customerPayment', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(40, 'Opening Inventory', 81, 'inventoryAdjustment', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(42, 'Pending Cheque', 10, 'pendingCheck', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(43, 'Brand', 7, 'brand', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(44, 'Unit', 7, 'unit', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(45, 'Sales Report', 12, 'salesReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(46, '<span style=\"font-size:12px!important;\"> New Cylinder Stock Report</span>', 72, 'newCylinderStockReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(47, 'Supplier Wise Purchas', 11, 'supplierPurchasesReport', '', '', '', '', '', 'administration', 1, 0),
(48, 'Customer Sales Report', 12, 'customerSalesReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(49, 'User List', 2, 'userList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(50, 'Cancel Order', 10, 'cancelOrder', 'fa fa-share', '', '', '', '', 'administration', 0, 0),
(51, 'Reference', 9, 'reference', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(52, 'Product Barcode', 7, 'productBarcode', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(55, 'Supplier Opening', 81, 'supplierOpening', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(56, 'Customer Opening', 81, 'customerOpneing', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(57, 'Supplier Ledger', 15, 'supplierLedger', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(58, 'Setup Import', 80, 'setupImport', 'fa fa-sitemap', '', '', '', '', 'administration', 1, 2),
(59, 'Product Import', 80, 'productImport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(60, 'Purchases Import', 80, 'demolist', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(62, 'Bill Voucher', 14, 'billInvoice', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(63, 'HR', 0, 'http://sflcl.com/baseithr/', 'fa fa-users', '', '', '', '', 'administration', 1, 11),
(64, 'Module', 1005, '', 'fa fa-archive', '', '', '', '', 'administration', 1, 0),
(65, 'Pending Cheque', 8, 'supPendingCheque', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(67, 'Customer Wise Cylinder', 72, 'cylinderStockReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(68, 'Product Wise Cylinder', 72, 'productWiseCylinderStock', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(69, 'Product Wise Sales ', 12, 'productWiseSalesReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(70, 'Product Wise Purchases ', 11, 'productWisePurchasesReport', '', '', '', '', '', 'administration', 1, 0),
(71, 'Purchases Report', 11, 'purchasesReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(72, 'Cylinder Report', 1002, '', 'fa fa-fire', '', '', '', '', 'administration', 1, 5),
(73, 'Cylinder Exchange', 72, 'cylinderInOutJournal', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(74, 'Cylinder Opening', 81, 'cylinderOpening', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(75, 'Sales Import', 80, 'salesImport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(76, 'Login History', 2, 'adminLoginHistory', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(77, 'Low Inventory Report', 11, 'lowInventoryReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(79, 'Sales Pos', 10, 'salesPos', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(80, 'Import', 1001, '', 'fa fa-upload bigger-130', '', '', '', '', 'administration', 1, 1),
(81, 'Opening', 1001, '', 'fa fa-upload bigger-130', '', '', '', '', 'administration', 1, 1),
(82, 'Cylinder Ledger', 72, 'cylinderLedger', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(83, 'Product Ledger', 11, 'productLedger', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(84, 'Cylinder combine Report', 72, 'cylinderSummaryReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(85, 'Reference Sales Report', 12, 'referenceSalesReport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(87, 'Incentive', 2, 'incentiveList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(88, 'Finance Import', 80, 'financeImport', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(89, 'Employee', 2, 'employeeList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(90, 'Vehicle', 2, 'vehicleList', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(91, 'Brand Wise Profit', 11, 'brandWiseProfit', 'fa fa-share', '', '', '', '', 'administration', 1, 0),
(92, 'Product Type', 7, 'productType', '', '', '', '', '', 'administration', 1, 0),
(93, 'Product Package', 7, 'productPackageList', '', '', '', '', '', 'administration', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `newdecision`
--

CREATE TABLE `newdecision` (
  `newDecisionId` int(11) NOT NULL,
  `company_bank` varchar(255) NOT NULL,
  `title_Product` varchar(255) NOT NULL,
  `investAmount` decimal(10,0) NOT NULL,
  `percentage` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offerId` int(11) NOT NULL,
  `offerTitle` varchar(120) NOT NULL,
  `offerDescription` text NOT NULL,
  `date` date NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `dateRange` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opening_balance`
--

CREATE TABLE `opening_balance` (
  `opening_balance_id` int(11) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `date` date NOT NULL,
  `account` int(6) NOT NULL COMMENT 'chart_master -> code',
  `debit` decimal(15,2) NOT NULL,
  `credit` decimal(15,2) NOT NULL,
  `updated_by` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `description` text,
  `dist_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_delete` enum('Y','N') NOT NULL DEFAULT 'N',
  `insert_by` int(11) DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_name`, `description`, `dist_id`, `company_id`, `branch_id`, `is_active`, `is_delete`, `insert_by`, `insert_date`, `update_by`, `update_date`) VALUES
(6, 'asd', '', 2, 0, 0, 'Y', 'N', 2, '2019-03-25 11:19:06', 2, '2019-03-25 17:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `package_products`
--

CREATE TABLE `package_products` (
  `package_products_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `dist_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_delete` enum('Y','N') NOT NULL DEFAULT 'N',
  `insert_by` int(11) DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_products`
--

INSERT INTO `package_products` (`package_products_id`, `package_id`, `product_id`, `dist_id`, `company_id`, `branch_id`, `is_active`, `is_delete`, `insert_by`, `insert_date`, `update_by`, `update_date`) VALUES
(14, 6, 1, 2, 0, 0, 'N', 'Y', 2, '2019-03-25 11:19:06', NULL, NULL),
(15, 6, 4, 2, 0, 0, 'N', 'Y', 2, '2019-03-25 11:23:14', 2, '2019-03-25 17:23:14'),
(16, 6, 1, 2, 0, 0, 'N', 'Y', 2, '2019-03-25 11:23:14', 2, '2019-03-25 17:23:14'),
(17, 6, 39, 2, 0, 0, 'Y', 'N', 2, '2019-03-25 11:23:35', 2, '2019-03-25 17:23:35'),
(18, 6, 4, 2, 0, 0, 'Y', 'N', 2, '2019-03-25 11:23:35', 2, '2019-03-25 17:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `brand_id` smallint(6) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `unit_id` smallint(6) NOT NULL,
  `product_type_id` int(11) NOT NULL DEFAULT '0',
  `productName` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `purchases_price` decimal(10,2) NOT NULL,
  `salesPrice` float NOT NULL,
  `retailPrice` float NOT NULL,
  `alarm_qty` decimal(11,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active,2=inactive',
  `updated_by` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `brand_id`, `dist_id`, `category_id`, `supplierid`, `unit_id`, `product_type_id`, `productName`, `product_code`, `purchases_price`, `salesPrice`, `retailPrice`, `alarm_qty`, `status`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1, 0, 0, 0, '12 Kg', 'HPID0001', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 7, 1, 1, 0, 0, 0, '33 Kg', 'HPID0002', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 7, 1, 1, 0, 0, 0, '45 Kg', 'HPID0003', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 5, 1, 1, 0, 0, 0, '12 Kg', 'HPID0004', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5, 1, 1, 0, 0, 0, '33 Kg', 'HPID0005', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 5, 1, 1, 0, 0, 0, '45 Kg', 'HPID0006', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 5, 1, 1, 0, 0, 0, '20 Kg', 'HPID0007', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 11, 1, 1, 0, 0, 0, '12 Kg', 'HPID0008', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 11, 1, 1, 0, 0, 0, '35 Kg', 'HPID0009', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 11, 1, 1, 0, 0, 0, '45 Kg', 'HPID0010', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 7, 1, 2, 0, 0, 0, 'Refil 12 Kg', 'HPID0011', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 7, 1, 2, 0, 0, 0, 'Refill 45 Kg', 'HPID0012', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 7, 1, 2, 0, 0, 0, 'Refill 33 Kg', 'HPID0013', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 5, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0014', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 5, 1, 2, 0, 0, 0, 'Refill 20 Kg', 'HPID0015', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 5, 1, 2, 0, 0, 0, 'Refill 33 Kg', 'HPID0016', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 5, 1, 2, 0, 0, 0, 'Refill 45 Kg', 'HPID0017', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 11, 1, 2, 0, 0, 0, 'Refil 12 Kg', 'HPID0018', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 11, 1, 2, 0, 0, 0, 'Refill 35 Kg', 'HPID0019', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 11, 1, 2, 0, 0, 0, 'Refill 45 Kg', 'HPID0020', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 7, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0021', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 7, 1, 2, 0, 0, 0, 'Empty 33 Kg', 'HPID0022', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 7, 1, 2, 0, 0, 0, 'Empty 45 Kg', 'HPID0023', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 5, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0024', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 5, 1, 2, 0, 0, 0, 'Empty 20 Kg', 'HPID0025', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 5, 1, 2, 0, 0, 0, 'Empty 33 Kg', 'HPID0026', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 5, 1, 2, 0, 0, 0, 'Empty 45 Kg', 'HPID0027', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 11, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0028', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 11, 1, 2, 0, 0, 0, 'Empty 35 Kg', 'HPID0029', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 11, 1, 2, 0, 0, 0, 'Empty 45 Kg', 'HPID0030', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 18, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0031', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 3, 1, 1, 0, 0, 0, '12 kg', 'HPID0032', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 3, 1, 2, 0, 0, 0, 'Refill 12 Kg ', 'HPID0033', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 3, 1, 2, 0, 0, 0, 'Empty 12 Kg ', 'HPID0034', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 3, 1, 1, 0, 0, 0, '30 kg', 'HPID0035', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 3, 1, 2, 0, 0, 0, 'Refill 30 Kg ', 'HPID0036', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 3, 1, 2, 0, 0, 0, 'Empty 30 Kg ', 'HPID0037', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 3, 1, 1, 0, 0, 0, '45 Kg', 'HPID0038', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 3, 1, 2, 0, 0, 0, 'Refill 45 Kg', 'HPID0039', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 3, 1, 2, 0, 0, 0, 'Empty 45 Kg', 'HPID0040', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 7, 1, 1, 0, 0, 0, '12 kg', 'HPID0047', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 7, 1, 2, 0, 0, 0, 'Refill 12 Kg ', 'HPID0048', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 7, 1, 2, 0, 0, 0, 'Empty 12 Kg ', 'HPID0049', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 7, 1, 1, 0, 0, 0, '35 kg', 'HPID0050', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 7, 1, 2, 0, 0, 0, 'Refill 35 Kg ', 'HPID0051', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 7, 1, 2, 0, 0, 0, 'Empty 35 Kg', 'HPID0052', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 7, 1, 1, 0, 0, 0, '45 Kg', 'HPID0053', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 7, 1, 2, 0, 0, 0, 'Refill 45 Kg', 'HPID0054', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 7, 1, 2, 0, 0, 0, 'Empty 45 Kg', 'HPID0055', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 7, 1, 1, 0, 0, 0, '5.5 Kg', 'HPID0056', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 7, 1, 2, 0, 0, 0, 'Refill 5.5 Kg', 'HPID0057', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 7, 1, 2, 0, 0, 0, 'Empty 5.5 Kg', 'HPID0058', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 4, 1, 1, 0, 0, 0, '12 kg', 'HPID0059', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 4, 1, 2, 0, 0, 0, 'Refill 12 Kg ', 'HPID0060', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 4, 1, 2, 0, 0, 0, 'Empty 12 Kg ', 'HPID0061', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 4, 1, 1, 0, 0, 0, '35 kg', 'HPID0062', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 4, 1, 2, 0, 0, 0, 'Refill 35 Kg ', 'HPID0063', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 4, 1, 2, 0, 0, 0, 'Empty 35 Kg', 'HPID0064', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 4, 1, 1, 0, 0, 0, '45 Kg', 'HPID0065', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 4, 1, 2, 0, 0, 0, 'Refill 45 Kg', 'HPID0066', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 4, 1, 2, 0, 0, 0, 'Empty 45 Kg', 'HPID0067', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 3, 1, 1, 0, 0, 0, '5.5 Kg', 'HPID0068', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 24, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0069', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 23, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0070', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 17, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0071', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 20, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0072', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 19, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0073', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 21, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0074', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 22, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0075', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 10, 1, 1, 0, 0, 0, '12 Kg', 'HPID0076', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 10, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0077', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 10, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0078', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 8, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0079', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 3, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0080', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 12, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0081', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 6, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0082', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 13, 1, 2, 0, 0, 0, 'Empty 12 Kg', 'HPID0083', '0.00', 0, 0, '0.00', 1, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 3, 1, 1, 0, 0, 0, '12 Kg', 'HPID0084', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 3, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0085', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 21, 1, 1, 0, 0, 0, '12 Kg', 'HPID0086', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 21, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0087', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 12, 1, 1, 0, 0, 0, '12 Kg', 'HPID0088', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 12, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0089', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 23, 1, 1, 0, 0, 0, '12 Kg', 'HPID0090', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 23, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0091', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 24, 1, 1, 0, 0, 0, '12 Kg', 'HPID0092', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 24, 1, 2, 0, 0, 0, 'Refill 12 Kg', 'HPID0093', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 4, 1, 2, 0, 0, 0, 'Refill 15 kg', 'HPID0094', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 4, 1, 2, 0, 0, 0, 'Empty 15 kg', 'HPID0095', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 4, 1, 1, 0, 0, 0, '15 kg', 'HPID0096', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 3, 1, 2, 0, 0, 0, 'Empty 35 Kg', 'HPID0097', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 8, 1, 2, 0, 0, 0, 'Empty 33 Kg', 'HPID0098', '0.00', 0, 0, '0.00', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 2, 2, 1, 0, 1, 5, '555 Kg', 'PID19030093', '0.00', 0, 0, '0.00', 1, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `category_id` int(11) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `title` varchar(120) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`category_id`, `dist_id`, `title`, `updated_at`, `created_at`, `updated_by`) VALUES
(1, 1, 'Only Cylinder', '2019-03-04 11:06:18', '2019-03-04 09:28:16', 0),
(2, 1, 'Refill / Empty Cylinder', '2019-03-04 00:00:00', '2019-03-04 09:28:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productimport`
--

CREATE TABLE `productimport` (
  `importId` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `unitId` int(11) NOT NULL,
  `catName` varchar(55) NOT NULL,
  `brandName` varchar(55) NOT NULL,
  `unitName` varchar(55) NOT NULL,
  `productName` varchar(55) NOT NULL,
  `purchasesPrice` float NOT NULL,
  `salesPrice` float NOT NULL,
  `retailprice` float NOT NULL,
  `date` date NOT NULL,
  `dist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productimport`
--

INSERT INTO `productimport` (`importId`, `catId`, `brandId`, `unitId`, `catName`, `brandName`, `unitName`, `productName`, `purchasesPrice`, `salesPrice`, `retailprice`, `date`, `dist_id`) VALUES
(1, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '12 KG', 0, 0, 0, '0000-00-00', 2),
(2, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '13 KG', 0, 0, 0, '0000-00-00', 2),
(3, 1, 5, 1, 'Only Cylinder', 'BM Energy', 'Pcs', '14 KG', 0, 0, 0, '0000-00-00', 2),
(4, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '15 KG', 0, 0, 0, '0000-00-00', 2),
(5, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '16 KG', 0, 0, 0, '0000-00-00', 2),
(6, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '17 KG', 0, 0, 0, '0000-00-00', 2),
(7, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '18 KG', 0, 0, 0, '0000-00-00', 2),
(8, 0, 0, 1, ' Only Cylinder', ' Omera', 'PCS', '19 KG', 0, 0, 0, '0000-00-00', 2),
(9, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '20 KG', 0, 0, 0, '0000-00-00', 2),
(10, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '21 KG', 0, 0, 0, '0000-00-00', 2),
(11, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '22 KG', 0, 0, 0, '0000-00-00', 2),
(12, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '23 KG', 0, 0, 0, '0000-00-00', 2),
(13, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '24 KG', 0, 0, 0, '0000-00-00', 2),
(14, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '25 KG', 0, 0, 0, '0000-00-00', 2),
(15, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '26 KG', 0, 0, 0, '0000-00-00', 2),
(16, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '27 KG', 0, 0, 0, '0000-00-00', 2),
(17, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '28 KG', 0, 0, 0, '0000-00-00', 2),
(18, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '29 KG', 0, 0, 0, '0000-00-00', 2),
(19, 0, 0, 1, ' Only Cylinder', 'BM', 'PCS', '30 KG', 0, 0, 0, '0000-00-00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_type_id` int(11) NOT NULL,
  `product_type_name` varchar(255) NOT NULL,
  `description` text,
  `dist_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_delete` enum('Y','N') NOT NULL DEFAULT 'N',
  `insert_by` int(11) DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_type_id`, `product_type_name`, `description`, `dist_id`, `company_id`, `branch_id`, `is_active`, `is_delete`, `insert_by`, `insert_date`, `update_by`, `update_date`) VALUES
(4, 'A', '', 2, 0, 0, 'Y', 'N', 2, '2019-03-25 11:04:46', 2, '2019-03-25 17:21:57'),
(5, 'B', '', 2, 0, 0, 'N', 'Y', 2, '2019-03-25 11:11:05', 2, '2019-03-25 17:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_demo`
--

CREATE TABLE `purchase_demo` (
  `purchase_demo_id` int(11) NOT NULL,
  `supplierID` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `voucherid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `purchasesDate` date NOT NULL,
  `paymentType` enum('1','2') COLLATE utf8_unicode_ci NOT NULL COMMENT 'cash =1, Credit=2',
  `accountCr` int(11) NOT NULL,
  `drAmount` text COLLATE utf8_unicode_ci NOT NULL,
  `crAmount` text COLLATE utf8_unicode_ci NOT NULL,
  `category_product` text COLLATE utf8_unicode_ci NOT NULL,
  `productID` text COLLATE utf8_unicode_ci NOT NULL,
  `productUnit` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` text COLLATE utf8_unicode_ci NOT NULL,
  `rate` text COLLATE utf8_unicode_ci NOT NULL,
  `price` text COLLATE utf8_unicode_ci NOT NULL,
  `subTotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `grandTotal` decimal(10,2) NOT NULL,
  `vat` decimal(10,2) NOT NULL,
  `netTotal` decimal(10,2) NOT NULL,
  `type` enum('1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=purchase,2=sales3=payment,4=receive,5=journal voucher',
  `narration` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dist_id` smallint(6) NOT NULL,
  `ConfirmStatus` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=demo,1=posted',
  `updated_by` smallint(6) NOT NULL,
  `payee` tinyint(4) NOT NULL COMMENT '1=miselenius,2=customer,3=supplier',
  `accountDr` text COLLATE utf8_unicode_ci NOT NULL,
  `memo` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_info`
--

CREATE TABLE `purchase_invoice_info` (
  `purchase_invoice_id` int(11) NOT NULL,
  `invoice_no` varchar(15) NOT NULL,
  `supplier_invoice_no` varchar(15) DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `refference_person_id` int(11) DEFAULT NULL,
  `invoice_amount` decimal(10,0) DEFAULT NULL,
  `vat_amount` decimal(10,0) DEFAULT NULL,
  `discount_amount` decimal(10,0) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `insert_by` int(11) DEFAULT NULL,
  `insert_date` date DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `delete_by` int(11) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_delete` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `reference_id` int(11) NOT NULL,
  `refCode` varchar(20) NOT NULL,
  `referenceName` varchar(55) NOT NULL,
  `referencePhone` varchar(15) NOT NULL,
  `referenceEmail` varchar(56) NOT NULL,
  `referenceAddress` text NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`reference_id`, `refCode`, `referenceName`, `referencePhone`, `referenceEmail`, `referenceAddress`, `dist_id`, `created_at`, `updated_by`, `updated_at`, `status`) VALUES
(1, 'RID19030001', 'Mr. Monowar', '01865956535', 'monowar@gmail.com', 'DFD', 2, '2019-03-21 06:25:51', 2, '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `id` int(11) NOT NULL,
  `religionName` varchar(55) NOT NULL,
  `isActive` enum('Y','N') NOT NULL,
  `isDelete` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`id`, `religionName`, `isActive`, `isDelete`) VALUES
(1, 'Islam ', 'Y', 'N'),
(2, 'Christianity ', 'Y', 'N'),
(3, 'Hinduism ', 'Y', 'N'),
(4, 'Buddhism ', 'Y', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `retainearning`
--

CREATE TABLE `retainearning` (
  `retainid` int(11) NOT NULL,
  `dr` float NOT NULL,
  `cr` float NOT NULL,
  `date` date NOT NULL,
  `dist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `generals_id` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `supplierId` int(11) NOT NULL,
  `dist_id` int(4) NOT NULL,
  `date` date NOT NULL,
  `form_id` int(3) NOT NULL,
  `category_id` int(3) NOT NULL,
  `product_id` int(4) NOT NULL,
  `unit` int(3) NOT NULL,
  `type` enum('In','Out','Order','Cin','Cout') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=inventory in,2=inventory out,3=order qty,4=cylinder stock in,5=cylinder stock out',
  `quantity` float NOT NULL,
  `cIn` float DEFAULT '0',
  `cOut` float DEFAULT '0',
  `rate` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `openingStatus` tinyint(4) NOT NULL COMMENT '1=opening,0=normal',
  `updated_by` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `generals_id`, `customerId`, `supplierId`, `dist_id`, `date`, `form_id`, `category_id`, `product_id`, `unit`, `type`, `quantity`, `cIn`, `cOut`, `rate`, `price`, `openingStatus`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 2, '2019-03-25', 11, 1, 1, 1, 'In', 10, 0, 0, '100.00', '1000.00', 0, 2, '2019-03-25 04:12:38', '0000-00-00 00:00:00'),
(3, 2, 0, 0, 2, '2019-03-25', 5, 1, 1, 1, 'Out', 1, 0, 0, '100.00', '100.00', 0, 2, '2019-03-25 04:30:39', '0000-00-00 00:00:00'),
(4, 3, 0, 0, 2, '2019-03-25', 11, 1, 1, 1, 'In', 10, 0, 0, '100.00', '1000.00', 0, 2, '2019-03-25 06:46:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` int(11) NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `supID` varchar(15) NOT NULL,
  `supName` varchar(55) NOT NULL,
  `supEmail` varchar(55) NOT NULL,
  `supPhone` varchar(25) NOT NULL,
  `supAddress` text NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=active,2=inactive',
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sup_id`, `dist_id`, `supID`, `supName`, `supEmail`, `supPhone`, `supAddress`, `status`, `updated_at`, `created_at`, `updated_by`) VALUES
(1, 2, 'SID19030001', 'Kosan', '', '', '', '1', '0000-00-00 00:00:00', '2019-03-21 04:28:49', 2);

-- --------------------------------------------------------

--
-- Table structure for table `system_config`
--

CREATE TABLE `system_config` (
  `configId` int(11) NOT NULL,
  `dist_id` mediumint(9) NOT NULL,
  `companyName` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `vat` float NOT NULL,
  `logo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `system_config`
--

INSERT INTO `system_config` (`configId`, `dist_id`, `companyName`, `phone`, `email`, `address`, `website`, `vat`, `logo`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'Advanced Equipment Limited', '0188898987', 'erp@gmail.com', 'Hassan Plaza (2nd Floor) \r\n53 Karwan Bazar C/A \r\nTejgaon, Dhaka – 1215 ', 'Cement.com', 0, '', 0, '2019-03-11 03:58:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tablecustomer`
--

CREATE TABLE `tablecustomer` (
  `customer_id` int(11) NOT NULL,
  `cusName` varchar(55) NOT NULL,
  `cusEmail` varchar(55) NOT NULL,
  `cusPhone` varchar(25) NOT NULL,
  `cusAddress` text NOT NULL,
  `dist_id` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `customerID` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_decision`
--

CREATE TABLE `tbl_decision` (
  `decision_id` int(11) NOT NULL,
  `dec_title` varchar(100) NOT NULL,
  `asset_amount` decimal(10,2) NOT NULL,
  `invest_type` tinyint(2) NOT NULL COMMENT '1=Bank Saving; 2=Invest; 3=both',
  `bank_saving_type` varchar(50) DEFAULT NULL,
  `amount_of_saving` decimal(10,2) DEFAULT NULL,
  `period_time` varchar(20) DEFAULT NULL,
  `interest_per_month` varchar(20) DEFAULT NULL,
  `per_month_interest_amount` varchar(25) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `invest_amount` decimal(10,2) DEFAULT NULL,
  `per_month_profit_amount` decimal(10,2) DEFAULT NULL,
  `return_of_invest_time` varchar(25) DEFAULT NULL,
  `note` text,
  `dist_id` int(11) NOT NULL,
  `decision_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_distributor`
--

CREATE TABLE `tbl_distributor` (
  `dist_id` int(9) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `dist_name` varchar(100) NOT NULL,
  `contactNo` varchar(15) NOT NULL,
  `contactPerson` varchar(55) NOT NULL,
  `contactPersonCont` varchar(25) NOT NULL,
  `dist_password` varchar(100) NOT NULL,
  `dist_email` varchar(100) NOT NULL,
  `dist_phone` varchar(50) NOT NULL,
  `dis_website` varchar(56) NOT NULL,
  `zone` varchar(70) NOT NULL,
  `division` smallint(6) NOT NULL,
  `district` smallint(6) NOT NULL,
  `postOffice` varchar(222) NOT NULL,
  `thanna` smallint(6) NOT NULL,
  `dist_address` text NOT NULL,
  `ownerName` varchar(55) NOT NULL,
  `dist_picture` varchar(120) NOT NULL,
  `dist_label` tinyint(1) NOT NULL,
  `VAT` int(11) NOT NULL,
  `demail` varchar(132) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` smallint(6) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_distributor`
--

INSERT INTO `tbl_distributor` (`dist_id`, `companyName`, `dist_name`, `contactNo`, `contactPerson`, `contactPersonCont`, `dist_password`, `dist_email`, `dist_phone`, `dis_website`, `zone`, `division`, `district`, `postOffice`, `thanna`, `dist_address`, `ownerName`, `dist_picture`, `dist_label`, `VAT`, `demail`, `updated_at`, `created_at`, `updated_by`, `status`) VALUES
(1, 'Advanced Equipment Limited', 'Saidul Islam', '01525556565', 'Salauddin Ahamed', '01865956535', 'e10adc3949ba59abbe56e057f20f883e', 'master@ael-bd.com', '01856665232', 'ael-bd.net', '1', 11, 1, '1', 1, 'Hassan Plaza (2nd Floor) \r\n53 Karwan Bazar C/A \r\nTejgaon, Dhaka – 1215 ', '', '', 0, 0, '', '0000-00-00 00:00:00', '2019-03-11 03:53:45', 0, 0),
(2, 'Advanced Equipment Limited', 'Md.Saidul Islam', '01910009876', 'Md.Salauddin Ahamed', '01799850231', 'e10adc3949ba59abbe56e057f20f883e', 'erp@gmail.com', '0188898987', 'Cement.com', '1', 3, 3, '', 77, 'Hassan Plaza (2nd Floor) \r\n53 Karwan Bazar C/A \r\nTejgaon, Dhaka – 1215 ', '', '', 0, 0, '', '0000-00-00 00:00:00', '2019-03-11 03:58:11', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `unions`
--

CREATE TABLE `unions` (
  `id` int(2) UNSIGNED NOT NULL,
  `upazila_id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unions`
--

INSERT INTO `unions` (`id`, `upazila_id`, `name`, `bn_name`, `lat`, `lon`) VALUES
(1, 226, '', 'আমলাব', 0, 0),
(2, 226, '', 'বাজনাব', 0, 0),
(3, 226, '', 'বেলাব', 0, 0),
(4, 226, '', 'বিন্নাবাইদ', 0, 0),
(5, 226, '', 'চরউজিলাব', 0, 0),
(6, 226, '', 'নারায়নপুর', 0, 0),
(7, 226, '', 'সল্লাবাদ', 0, 0),
(8, 226, '', 'পাটুলী', 0, 0),
(9, 226, '', 'দেয়ারা', 0, 0),
(10, 227, '', 'বড়চাপা', 0, 0),
(11, 227, '', 'চালাকচর', 0, 0),
(12, 227, '', 'চরমান্দালিয়া', 0, 0),
(13, 227, '', 'একদুয়ারিয়া', 0, 0),
(14, 227, '', 'গোতাশিয়া', 0, 0),
(15, 227, '', 'কাচিকাটা', 0, 0),
(16, 227, '', 'খিদিরপুর', 0, 0),
(17, 227, '', 'শুকুন্দি', 0, 0),
(18, 227, '', 'দৌলতপুর', 0, 0),
(19, 227, '', 'কৃষ্ণপুর ইউনিয়ন', 0, 0),
(20, 227, '', 'লেবুতলা', 0, 0),
(21, 227, '', 'চন্দনবাড়ী', 0, 0),
(22, 228, '', 'আলোকবালী', 0, 0),
(23, 228, '', 'চরদিঘলদী', 0, 0),
(24, 228, '', 'করিমপুর', 0, 0),
(25, 228, '', 'কাঠালিয়া', 0, 0),
(26, 228, '', 'নূরালাপুর', 0, 0),
(27, 228, '', 'মহিষাশুড়া', 0, 0),
(28, 228, '', 'মেহেড়পাড়া', 0, 0),
(29, 228, '', 'নজরপুর', 0, 0),
(30, 228, '', 'পাইকারচর', 0, 0),
(31, 228, '', 'পাঁচদোনা', 0, 0),
(32, 228, '', 'শিলমান্দী', 0, 0),
(33, 228, '', 'আমদিয়া ২', 0, 0),
(34, 229, '', 'ডাংঙ্গা', 0, 0),
(35, 229, '', 'চরসিন্দুর', 0, 0),
(36, 229, '', 'জিনারদী', 0, 0),
(37, 229, '', 'গজারিয়া', 0, 0),
(38, 230, '', 'চানপুর', 0, 0),
(39, 230, '', 'অলিপুরা', 0, 0),
(40, 230, '', 'আমিরগঞ্জ', 0, 0),
(41, 230, '', 'আদিয়াবাদ', 0, 0),
(42, 230, '', 'বাঁশগাড়ী', 0, 0),
(43, 230, '', 'চান্দেরকান্দি', 0, 0),
(44, 230, '', 'চরআড়ালিয়া', 0, 0),
(45, 230, '', 'চরমধুয়া', 0, 0),
(46, 230, '', 'চরসুবুদ্দি', 0, 0),
(47, 230, '', 'হাইরমারা', 0, 0),
(48, 230, '', 'মহেষপুর', 0, 0),
(49, 230, '', 'মির্জানগর', 0, 0),
(50, 230, '', 'মির্জারচর', 0, 0),
(51, 230, '', 'নিলক্ষ্যা', 0, 0),
(52, 230, '', 'পলাশতলী', 0, 0),
(53, 230, '', 'পাড়াতলী', 0, 0),
(54, 230, '', 'শ্রীনগর', 0, 0),
(55, 230, '', 'রায়পুরা', 0, 0),
(56, 230, '', 'মুছাপুর', 0, 0),
(57, 230, '', 'উত্তর বাখরনগর', 0, 0),
(58, 230, '', 'মরজাল', 0, 0),
(59, 231, '', 'দুলালপুর', 0, 0),
(60, 231, '', 'জয়নগর', 0, 0),
(61, 231, '', 'সাধারচর', 0, 0),
(62, 231, '', 'মাছিমপুর', 0, 0),
(63, 231, '', 'চক্রধা', 0, 0),
(64, 231, '', 'যোশর', 0, 0),
(65, 231, '', 'বাঘাব', 0, 0),
(66, 231, '', 'আয়ুবপুর', 0, 0),
(67, 231, '', 'পুটিয়া', 0, 0),
(68, 163, '', 'বাহাদুরশাদী', 0, 0),
(69, 163, '', 'বক্তারপুর', 0, 0),
(70, 163, '', 'জামালপুর', 0, 0),
(71, 163, '', 'জাঙ্গালিয়া', 0, 0),
(72, 163, '', 'মোক্তারপুর', 0, 0),
(73, 163, '', 'নাগরী', 0, 0),
(74, 163, '', 'তুমুলিয়া', 0, 0),
(75, 160, '', 'আটাবহ', 0, 0),
(76, 160, '', 'বোয়ালী', 0, 0),
(77, 160, '', 'চাপাইর', 0, 0),
(78, 160, '', 'ঢালজোড়া', 0, 0),
(79, 160, '', 'ফুলবাড়ীয়া', 0, 0),
(80, 160, '', 'মধ্যপাড়া', 0, 0),
(81, 160, '', 'মৌচাক', 0, 0),
(82, 160, '', 'সূত্রাপুর', 0, 0),
(83, 160, '', 'শ্রীফলতলী', 0, 0),
(84, 161, '', 'বারিষাব', 0, 0),
(85, 161, '', 'ঘাগটিয়া', 0, 0),
(86, 161, '', 'কাপাসিয়া', 0, 0),
(87, 161, '', 'চাঁদপুর', 0, 0),
(88, 161, '', 'তরগাঁও', 0, 0),
(89, 161, '', 'কড়িহাতা', 0, 0),
(90, 161, '', 'টোক', 0, 0),
(91, 161, '', 'সিংহশ্রী', 0, 0),
(92, 161, '', 'দূর্গাপুর', 0, 0),
(93, 161, '', 'সনমানিয়া', 0, 0),
(94, 161, '', 'রায়েদ', 0, 0),
(95, 159, '', 'বাড়ীয়া', 0, 0),
(96, 159, '', 'বাসন', 0, 0),
(97, 159, '', 'গাছা', 0, 0),
(98, 159, '', 'কাশিমপুর', 0, 0),
(99, 159, '', 'কাউলতিয়া', 0, 0),
(100, 159, '', 'কোনাবাড়ী', 0, 0),
(101, 159, '', 'মির্জাপুর', 0, 0),
(102, 159, '', 'পূবাইল', 0, 0),
(103, 162, '', 'বরমী', 0, 0),
(104, 162, '', 'গাজীপুর', 0, 0),
(105, 162, '', 'গোসিংগা', 0, 0),
(106, 162, '', 'মাওনা', 0, 0),
(107, 162, '', 'কাওরাইদ', 0, 0),
(108, 162, '', 'প্রহলাদপুর', 0, 0),
(109, 162, '', 'রাজাবাড়ী', 0, 0),
(110, 162, '', 'তেলিহাটী', 0, 0),
(111, 247, '', 'বিনোদপুর', 0, 0),
(112, 247, '', 'তুলাসার', 0, 0),
(113, 247, '', 'পালং', 0, 0),
(114, 247, '', 'ডোমসার', 0, 0),
(115, 247, '', 'রুদ্রকর', 0, 0),
(116, 247, '', 'আংগারিয়া', 0, 0),
(117, 247, '', 'চিতলয়া', 0, 0),
(118, 247, '', 'মাহমুদপুর', 0, 0),
(119, 247, '', 'চিকন্দি', 0, 0),
(120, 247, '', 'চন্দ্রপুর', 0, 0),
(121, 247, '', 'শৌলপাড়া', 0, 0),
(122, 249, '', 'কেদারপুর', 0, 0),
(123, 249, '', 'ডিংগামানিক', 0, 0),
(124, 249, '', 'ঘড়িষার', 0, 0),
(125, 249, '', 'নওপাড়া', 0, 0),
(126, 249, '', 'মোত্তারেরচর', 0, 0),
(127, 249, '', 'চরআত্রা', 0, 0),
(128, 249, '', 'রাজনগর', 0, 0),
(129, 249, '', 'জপসা', 0, 0),
(130, 249, '', 'ভোজেশ্বর', 0, 0),
(131, 249, '', 'ফতেজংপুর', 0, 0),
(132, 249, '', 'বিঝারি', 0, 0),
(133, 249, '', 'ভূমখাড়া', 0, 0),
(134, 249, '', 'নশাসন', 0, 0),
(135, 250, '', 'জাজিরা সদর', 0, 0),
(136, 250, '', 'মূলনা', 0, 0),
(137, 250, '', 'বড়কান্দি', 0, 0),
(138, 250, '', 'বিলাসপুর', 0, 0),
(139, 250, '', 'কুন্ডেরচর', 0, 0),
(140, 250, '', 'পালেরচর', 0, 0),
(141, 250, '', 'পুর্ব নাওডোবা', 0, 0),
(142, 250, '', 'নাওডোবা', 0, 0),
(143, 250, '', 'সেনেরচর', 0, 0),
(144, 250, '', 'বি. কে. নগর', 0, 0),
(145, 250, '', 'বড়গোপালপুর', 0, 0),
(146, 250, '', 'জয়নগর', 0, 0),
(147, 252, '', 'নাগের পাড়া', 0, 0),
(148, 252, '', 'আলাওলপুর', 0, 0),
(149, 252, '', 'কোদালপুর', 0, 0),
(150, 252, '', 'গোসাইরহাট', 0, 0),
(151, 252, '', 'ইদিলপুর', 0, 0),
(152, 252, '', 'নলমুড়ি', 0, 0),
(153, 252, '', 'সামন্তসার', 0, 0),
(154, 252, '', 'কুচাইপট্টি', 0, 0),
(155, 251, '', 'রামভদ্রপুর', 0, 0),
(156, 251, '', 'মহিষার', 0, 0),
(157, 251, '', 'ছয়গাঁও', 0, 0),
(158, 251, '', 'নারায়নপুর', 0, 0),
(159, 251, '', 'ডি.এম খালি', 0, 0),
(160, 251, '', 'চরকুমারিয়া', 0, 0),
(161, 251, '', 'সখিপুর', 0, 0),
(162, 251, '', 'কাচিকাঁটা', 0, 0),
(163, 251, '', 'উত্তর তারাবুনিয়া', 0, 0),
(164, 251, '', 'চরভাগা', 0, 0),
(165, 251, '', 'আরশিনগর', 0, 0),
(166, 251, '', 'দক্ষিন তারাবুনিয়া', 0, 0),
(167, 251, '', 'চরসেনসাস', 0, 0),
(168, 248, '', 'শিধলকুড়া', 0, 0),
(169, 248, '', 'কনেস্বর', 0, 0),
(170, 248, '', 'পুর্ব ডামুড্যা', 0, 0),
(171, 248, '', 'ইসলামপুর', 0, 0),
(172, 248, '', 'ধানকাটি', 0, 0),
(173, 248, '', 'সিড্যা', 0, 0),
(174, 248, '', 'দারুল আমান', 0, 0),
(175, 220, '', 'সাতগ্রাম', 0, 0),
(176, 220, '', 'দুপ্তারা', 0, 0),
(177, 220, '', 'ব্রা‏হ্মন্দী', 0, 0),
(178, 220, '', 'ফতেপুর', 0, 0),
(179, 220, '', 'বিশনন্দী', 0, 0),
(180, 220, '', 'মাহমুদপুর', 0, 0),
(181, 220, '', 'হাইজাদী', 0, 0),
(182, 220, '', 'উচিৎপুরা', 0, 0),
(183, 220, '', 'কালাপাহাড়িয়া', 0, 0),
(184, 220, '', 'খাগকান্দা', 0, 0),
(185, 223, '', 'আলিরটেক', 0, 0),
(186, 223, '', 'কুতুবপুর', 0, 0),
(187, 223, '', 'বক্তাবলী', 0, 0),
(188, 223, '', 'এনায়েত নগর', 0, 0),
(189, 224, '', 'মুড়াপাড়া', 0, 0),
(190, 224, '', 'ভূলতা', 0, 0),
(191, 224, '', 'গোলাকান্দাইল', 0, 0),
(192, 224, '', 'দাউদপুর', 0, 0),
(193, 224, '', 'রূপগঞ্জ', 0, 0),
(194, 224, '', 'কায়েতপাড়া', 0, 0),
(195, 224, '', 'ভোলাব', 0, 0),
(196, 221, '', 'পিরোজপুর ইউনিয়ন', 0, 0),
(197, 221, '', 'শম্ভুপুরা ইউনিয়ন', 0, 0),
(198, 221, '', 'মোগরাপাড়া ইউনিয়ন', 0, 0),
(199, 221, '', 'বৈদ্যেরবাজার ইউনিয়ন', 0, 0),
(200, 221, '', 'বারদী ইউনিয়ন', 0, 0),
(201, 221, '', 'নোয়াগাঁও ইউনিয়ন', 0, 0),
(202, 221, '', 'জামপুর ইউনিয়ন', 0, 0),
(203, 221, '', 'সাদীপুর ইউনিয়ন', 0, 0),
(204, 221, '', 'সনমান্দি ইউনিয়ন', 0, 0),
(205, 221, '', 'কাচপুর ইউনিয়ন', 0, 0),
(206, 260, '', 'বাসাইল ইউনিয়ন', 0, 0),
(207, 260, '', 'কাঞ্চনপুর ইউনিয়ন', 0, 0),
(208, 260, '', 'হাবলা ইউনিয়ন', 0, 0),
(209, 260, '', 'কাশিল ইউনিয়ন', 0, 0),
(210, 260, '', 'ফুলকি ইউনিয়ন', 0, 0),
(211, 260, '', 'কাউলজানী ইউনিয়ন', 0, 0),
(212, 268, '', 'অর্জুনা ইউনিয়ন', 0, 0),
(213, 268, '', 'গাবসারা ইউনিয়ন', 0, 0),
(214, 268, '', 'ফলদা ইউনিয়ন', 0, 0),
(215, 268, '', 'গোবিন্দাসী ইউনিয়ন', 0, 0),
(216, 268, '', 'আলোয়া ইউনিয়ন', 0, 0),
(217, 268, '', 'নিকরাইল ইউনিয়ন', 0, 0),
(218, 267, '', 'দেউলী ইউনিয়ন', 0, 0),
(219, 267, '', 'লাউহাটি ইউনিয়ন', 0, 0),
(220, 267, '', 'পাথরাইল ইউনিয়ন', 0, 0),
(221, 267, '', 'দেলদুয়ার ইউনিয়ন', 0, 0),
(222, 267, '', 'ফাজিলহাটি ইউনিয়ন', 0, 0),
(223, 267, '', 'এলাসিন ইউনিয়ন', 0, 0),
(224, 267, '', 'আটিয়া ইউনিয়ন', 0, 0),
(225, 267, '', 'ডুবাইল ইউনিয়ন', 0, 0),
(226, 262, '', 'দেউলাবাড়ী ইউনিয়ন', 0, 0),
(227, 262, '', 'ঘাটাইল ইউনিয়ন', 0, 0),
(228, 262, '', 'জামুরিয়া ইউনিয়ন', 0, 0),
(229, 262, '', 'লোকেরপাড়া ইউনিয়ন', 0, 0),
(230, 262, '', 'আনেহলা ইউনিয়ন', 0, 0),
(231, 262, '', 'দিঘলকান্দি ইউনিয়ন', 0, 0),
(232, 262, '', 'দিগড় ইউনিয়ন', 0, 0),
(233, 262, '', 'দেওপাড়া ইউনিয়ন', 0, 0),
(234, 262, '', 'সন্ধানপুর ইউনিয়ন', 0, 0),
(235, 262, '', 'রসুলপুর ইউনিয়ন', 0, 0),
(236, 262, '', 'ধলাপাড়া ইউনিয়ন', 0, 0),
(237, 266, '', 'হাদিরা ইউনিয়ন', 0, 0),
(238, 266, '', 'ঝাওয়াইল ইউনিয়ন', 0, 0),
(239, 266, '', 'নগদাশিমলা ইউনিয়ন', 0, 0),
(240, 266, '', 'ধোপাকান্দি ইউনিয়ন', 0, 0),
(241, 266, '', 'আলমনগর ইউনিয়ন', 0, 0),
(242, 266, '', 'হেমনগর ইউনিয়ন', 0, 0),
(243, 266, '', 'মির্জাপুর ইউনিয়ন', 0, 0),
(244, 261, '', 'আলোকদিয়া ইউনিয়ন', 0, 0),
(245, 261, '', 'আউশনারা ইউনিয়ন', 0, 0),
(246, 261, '', 'অরণখোলা ইউনিয়ন', 0, 0),
(247, 261, '', 'শোলাকুড়ি ইউনিয়ন', 0, 0),
(248, 261, '', 'গোলাবাড়ী ইউনিয়ন', 0, 0),
(249, 261, '', 'মির্জাবাড়ী ইউনিয়ন', 0, 0),
(250, 265, '', 'মহেড়া ইউনিয়ন', 0, 0),
(251, 265, '', 'জামুর্কী ইউনিয়ন', 0, 0),
(252, 265, '', 'ফতেপুর ইউনিয়ন', 0, 0),
(253, 265, '', 'বানাইল ইউনিয়ন', 0, 0),
(254, 265, '', 'আনাইতারা ইউনিয়ন', 0, 0),
(255, 265, '', 'ওয়ার্শী ইউনিয়ন', 0, 0),
(256, 265, '', 'ভাতগ্রাম ইউনিয়ন', 0, 0),
(257, 265, '', 'বহুরিয়া ইউনিয়ন', 0, 0),
(258, 265, '', 'গোড়াই ইউনিয়ন', 0, 0),
(259, 265, '', 'আজগানা ইউনিয়ন', 0, 0),
(260, 265, '', 'তরফপুর ইউনিয়ন', 0, 0),
(261, 265, '', 'বাঁশতৈল ইউনিয়ন', 0, 0),
(262, 265, '', 'ভাওড়া ইউনিয়ন', 0, 0),
(263, 265, '', 'লতিফপুর ইউনিয়ন', 0, 0),
(264, 264, '', 'ভারড়া ইউনিয়ন', 0, 0),
(265, 264, '', 'সহবতপুর ইউনিয়ন', 0, 0),
(266, 264, '', 'গয়হাটা ইউনিয়ন', 0, 0),
(267, 264, '', 'সলিমাবাদ ইউনিয়ন', 0, 0),
(268, 264, '', 'নাগরপুর ইউনিয়ন', 0, 0),
(269, 264, '', 'মামুদনগর ইউনিয়ন', 0, 0),
(270, 264, '', 'মোকনা ইউনিয়ন', 0, 0),
(271, 264, '', 'পাকুটিয়া ইউনিয়ন', 0, 0),
(272, 264, '', 'বেকরা আটগ্রাম ইউনিয়ন', 0, 0),
(273, 264, '', 'ধুবড়িয়া ইউনিয়ন', 0, 0),
(274, 264, '', 'ভাদ্রা ইউনিয়ন', 0, 0),
(275, 264, '', 'দপ্তিয়র ইউনিয়ন', 0, 0),
(276, 259, '', 'কাকড়াজান ইউনিয়ন', 0, 0),
(277, 259, '', 'গজারিয়া ইউনিয়ন', 0, 0),
(278, 259, '', 'যাদবপুর ইউনিয়ন', 0, 0),
(279, 259, '', 'হাতীবান্ধা ইউনিয়ন', 0, 0),
(280, 259, '', 'কালিয়া ইউনিয়ন', 0, 0),
(281, 259, '', 'দরিয়াপুর ইউনিয়ন', 0, 0),
(282, 259, '', 'কালমেঘা ইউনিয়ন', 0, 0),
(283, 259, '', 'বহেড়াতৈল ইউনিয়ন', 0, 0),
(284, 258, '', 'মগড়া ইউনিয়ন', 0, 0),
(285, 258, '', 'গালা ইউনিয়ন', 0, 0),
(286, 258, '', 'ঘারিন্দা ইউনিয়ন', 0, 0),
(287, 258, '', 'করটিয়া ইউনিয়ন', 0, 0),
(288, 258, '', 'ছিলিমপুর ইউনিয়ন', 0, 0),
(289, 258, '', 'পোড়াবাড়ী ইউনিয়ন', 0, 0),
(290, 258, '', 'দাইন্যা ইউনিয়ন', 0, 0),
(291, 258, '', 'বাঘিল ইউনিয়ন', 0, 0),
(292, 258, '', 'কাকুয়া ইউনিয়ন', 0, 0),
(293, 258, '', 'হুগড়া ইউনিয়ন', 0, 0),
(294, 258, '', 'কাতুলী ইউনিয়ন', 0, 0),
(295, 258, '', 'মাহমুদনগর ইউনিয়ন', 0, 0),
(296, 263, '', 'দুর্গাপুর ইউনিয়ন', 0, 0),
(297, 263, '', 'বীরবাসিন্দা ইউনিয়ন', 0, 0),
(298, 263, '', 'নারান্দিয়া ইউনিয়ন', 0, 0),
(299, 263, '', 'সহদেবপুর ইউনিয়ন', 0, 0),
(300, 263, '', 'কোকডহরা ইউনিয়ন', 0, 0),
(301, 263, '', 'বল্লা ইউনিয়ন', 0, 0),
(302, 263, '', 'সল্লা ইউনিয়ন', 0, 0),
(303, 263, '', 'নাগবাড়ী ইউনিয়ন', 0, 0),
(304, 263, '', 'বাংড়া ইউনিয়ন', 0, 0),
(305, 263, '', 'পাইকড়া ইউনিয়ন', 0, 0),
(306, 263, '', 'দশকিয়া ইউনিয়ন', 0, 0),
(307, 263, '', 'পারখী ইউনিয়ন', 0, 0),
(308, 263, '', 'গোহালিয়াবাড়ী ইউনিয়ন', 0, 0),
(309, 269, '', 'ধোপাখালী ইউনিয়ন', 0, 0),
(310, 269, '', 'পাইস্কা ইউনিয়ন', 0, 0),
(311, 269, '', 'মুশুদ্দি ইউনিয়ন', 0, 0),
(312, 269, '', 'বলিভদ্র ইউনিয়ন', 0, 0),
(313, 269, '', 'বীরতারা ইউনিয়ন', 0, 0),
(314, 269, '', 'বানিয়াজান ইউনিয়ন', 0, 0),
(315, 269, '', 'যদুনাথপুর ইউনিয়ন', 0, 0),
(316, 182, '', 'চৌগাংগা', 0, 0),
(317, 182, '', 'জয়সিদ্ধি', 0, 0),
(318, 182, '', 'এলংজুরী', 0, 0),
(319, 182, '', 'বাদলা', 0, 0),
(320, 182, '', 'বড়িবাড়ি', 0, 0),
(321, 182, '', 'ইটনা ইউনিয়ন', 0, 0),
(322, 182, '', 'মৃগা', 0, 0),
(323, 182, '', 'ধনপুর', 0, 0),
(324, 182, '', 'রায়টুটি', 0, 0),
(325, 184, '', 'বনগ্রাম', 0, 0),
(326, 184, '', 'সহশ্রাম ধুলদিয়া', 0, 0),
(327, 184, '', 'কারগাঁও', 0, 0),
(328, 184, '', 'চান্দপুর', 0, 0),
(329, 184, '', 'মুমুরদিয়া', 0, 0),
(330, 184, '', 'আচমিতা', 0, 0),
(331, 184, '', 'মসূয়া', 0, 0),
(332, 184, '', 'লোহাজুরী', 0, 0),
(333, 184, '', 'জালালপুর', 0, 0),
(334, 180, '', 'সাদেকপুর', 0, 0),
(335, 180, '', 'আগানগর', 0, 0),
(336, 180, '', 'শিমুলকান্দি', 0, 0),
(337, 180, '', 'গজারিয়া', 0, 0),
(338, 180, '', 'কালিকা প্রসাদ', 0, 0),
(339, 180, '', 'শ্রীনগর', 0, 0),
(340, 180, '', 'শিবপুর', 0, 0),
(341, 190, '', 'তালজাঙ্গা', 0, 0),
(342, 190, '', 'রাউতি', 0, 0),
(343, 190, '', 'ধলা', 0, 0),
(344, 190, '', 'জাওয়ার', 0, 0),
(345, 190, '', 'দামিহা', 0, 0),
(346, 190, '', 'দিগদাইর', 0, 0),
(347, 190, '', 'তাড়াইল-সাচাইল', 0, 0),
(348, 181, '', 'জিনারী', 0, 0),
(349, 181, '', 'গোবিন্দপুর', 0, 0),
(350, 181, '', 'সিদলা', 0, 0),
(351, 181, '', 'আড়াইবাড়িয়া', 0, 0),
(352, 181, '', 'সাহেদল', 0, 0),
(353, 181, '', 'পুমদি', 0, 0),
(354, 189, '', 'জাঙ্গালিয়া', 0, 0),
(355, 189, '', 'হোসেনদি', 0, 0),
(356, 189, '', 'নারান্দি', 0, 0),
(357, 189, '', 'সুখিয়া', 0, 0),
(358, 189, '', 'পটুয়াভাঙ্গা', 0, 0),
(359, 189, '', 'চান্দিপাশা', 0, 0),
(360, 189, '', 'চারফারাদি', 0, 0),
(361, 189, '', 'বুড়ুদিয়া', 0, 0),
(362, 189, '', 'ইজারাসিন্দুর', 0, 0),
(363, 189, '', 'পাকন্দিয়া', 0, 0),
(364, 186, '', 'রামদী', 0, 0),
(365, 186, '', 'উছমানপুর', 0, 0),
(366, 186, '', 'ছয়সূতী', 0, 0),
(367, 186, '', 'সালুয়া', 0, 0),
(368, 186, '', 'গোবরিয়া আব্দুল্লাহপুর', 0, 0),
(369, 186, '', 'ফরিদপুর', 0, 0),
(370, 185, '', 'রশিদাবাদ', 0, 0),
(371, 185, '', 'লতিবাবাদ', 0, 0),
(372, 185, '', 'মাইজখাপন', 0, 0),
(373, 185, '', 'মহিনন্দ', 0, 0),
(374, 185, '', 'যশোদল', 0, 0),
(375, 185, '', 'বৌলাই', 0, 0),
(376, 185, '', 'বিন্নাটি', 0, 0),
(377, 185, '', 'মারিয়া', 0, 0),
(378, 185, '', 'চৌদ্দশত', 0, 0),
(379, 185, '', 'কর্শাকড়িয়াইল', 0, 0),
(380, 185, '', 'দানাপাটুলী', 0, 0),
(381, 183, '', 'কাদিরজঙ্গল', 0, 0),
(382, 183, '', 'গুজাদিয়া', 0, 0),
(383, 183, '', 'কিরাটন ইউনিয়ন', 0, 0),
(384, 183, '', 'বারঘড়িয়া', 0, 0),
(385, 183, '', 'নিয়ামতপুর', 0, 0),
(386, 183, '', 'দেহুন্দা', 0, 0),
(387, 183, '', 'সুতারপাড়া', 0, 0),
(388, 183, '', 'গুনধর', 0, 0),
(389, 183, '', 'জয়কা', 0, 0),
(390, 183, '', 'জাফরাবাদ', 0, 0),
(391, 183, '', 'নোয়াবাদ', 0, 0),
(392, 179, '', 'কৈলাগ', 0, 0),
(393, 179, '', 'পিরিজপুর', 0, 0),
(394, 179, '', 'গাজীরচর', 0, 0),
(395, 179, '', 'হিলচিয়া', 0, 0),
(396, 179, '', 'মাইজচর', 0, 0),
(397, 179, '', 'হুমাইপর', 0, 0),
(398, 179, '', 'হালিমপুর', 0, 0),
(399, 179, '', 'সরারচর', 0, 0),
(400, 179, '', 'দিলালপুর', 0, 0),
(401, 179, '', 'দিঘীরপাড়', 0, 0),
(402, 179, '', 'বলিয়ার্দী', 0, 0),
(403, 178, '', 'দেওঘর', 0, 0),
(404, 178, '', 'কাস্তুল', 0, 0),
(405, 178, '', 'অষ্টগ্রাম সদর', 0, 0),
(406, 178, '', 'বাঙ্গালপাড়া', 0, 0),
(407, 178, '', 'কলমা', 0, 0),
(408, 178, '', 'আদমপুর', 0, 0),
(409, 178, '', 'খয়েরপুর-আব্দুল্লাপুর', 0, 0),
(410, 178, '', 'পূর্ব অষ্টগ্রাম', 0, 0),
(411, 187, '', 'গোপদিঘী', 0, 0),
(412, 187, '', 'মিঠামইন', 0, 0),
(413, 187, '', 'ঢাকী', 0, 0),
(414, 187, '', 'ঘাগড়া', 0, 0),
(415, 187, '', 'কেওয়ারজোর', 0, 0),
(416, 187, '', 'কাটখাল', 0, 0),
(417, 187, '', 'বৈরাটি', 0, 0),
(418, 188, '', 'ছাতিরচর', 0, 0),
(419, 188, '', 'গুরই', 0, 0),
(420, 188, '', 'জারইতলা', 0, 0),
(421, 188, '', 'নিকলী সদর', 0, 0),
(422, 188, '', 'কারপাশা', 0, 0),
(423, 188, '', 'দামপাড়া', 0, 0),
(424, 188, '', 'সিংপুর', 0, 0),
(425, 199, '', 'বাল্লা ইউনিয়ন', 0, 0),
(426, 199, '', 'গালা ইউনিয়ন', 0, 0),
(427, 199, '', 'চালা ইউনিয়ন', 0, 0),
(428, 199, '', 'বলড়া', 0, 0),
(429, 199, '', 'হারুকান্দি', 0, 0),
(430, 199, '', 'বয়রা', 0, 0),
(431, 199, '', 'রামকৃঞ্চপুর', 0, 0),
(432, 199, '', 'গোপীনাথপুর', 0, 0),
(433, 199, '', 'কাঞ্চনপুর', 0, 0),
(434, 199, '', 'লেছড়াগঞ্জ', 0, 0),
(435, 199, '', 'সুতালড়ী', 0, 0),
(436, 199, '', 'ধূলশুড়া', 0, 0),
(437, 199, '', 'আজিমনগর', 0, 0),
(438, 198, '', 'বরাইদ', 0, 0),
(439, 198, '', 'দিঘুলিয়া', 0, 0),
(440, 198, '', 'বালিয়াটি', 0, 0),
(441, 198, '', 'দড়গ্রাম', 0, 0),
(442, 198, '', 'তিল্লী', 0, 0),
(443, 198, '', 'হরগজ', 0, 0),
(444, 198, '', 'সাটুরিয়া', 0, 0),
(445, 198, '', 'ধানকোড়া', 0, 0),
(446, 198, '', 'ফুকুরহাটি', 0, 0),
(447, 195, '', 'বেতিলা-মিতরা ইউনিয়ন', 0, 0),
(448, 195, '', 'জাগীর ইউনিয়ন', 0, 0),
(449, 195, '', 'আটিগ্রাম ইউনিয়ন', 0, 0),
(450, 195, '', 'দিঘী ইউনিয়ন', 0, 0),
(451, 195, '', 'পুটাইল ইউনিয়ন', 0, 0),
(452, 195, '', 'হাটিপাড়া ইউনিয়ন', 0, 0),
(453, 195, '', 'ভাড়ারিয়া ইউনিয়ন', 0, 0),
(454, 195, '', 'নবগ্রাম ইউনিয়ন', 0, 0),
(455, 195, '', 'গড়পাড়া ইউনিয়ন', 0, 0),
(456, 195, '', 'কৃঞ্চপুর ইউনিয়ন', 0, 0),
(457, 200, '', 'পয়লা ইউনিয়ন', 0, 0),
(458, 200, '', 'সিংজুড়ী ইউনিয়ন', 0, 0),
(459, 200, '', 'বালিয়াখোড়া ইউনিয়ন', 0, 0),
(460, 200, '', 'ঘিওর ইউনিয়ন', 0, 0),
(461, 200, '', 'বড়টিয়া ইউনিয়ন', 0, 0),
(462, 200, '', 'বানিয়াজুড়ী', 0, 0),
(463, 200, '', 'নালী', 0, 0),
(464, 197, '', 'তেওতা ইউনিয়ন', 0, 0),
(465, 197, '', 'উথলী ইউনিয়ন', 0, 0),
(466, 197, '', 'শিবালয় ইউনিয়ন', 0, 0),
(467, 197, '', 'উলাইল ইউনিয়ন', 0, 0),
(468, 197, '', 'আরুয়া ইউনিয়ন', 0, 0),
(469, 197, '', 'মহাদেবপুর', 0, 0),
(470, 197, '', 'শিমুলিয়া', 0, 0),
(471, 201, '', 'চরকাটারী', 0, 0),
(472, 201, '', 'বাচামারা', 0, 0),
(473, 201, '', 'বাঘুটিয়া', 0, 0),
(474, 201, '', 'জিয়নপুর', 0, 0),
(475, 201, '', 'খলশী', 0, 0),
(476, 201, '', 'চকমিরপুর', 0, 0),
(477, 201, '', 'কলিয়া', 0, 0),
(478, 201, '', 'ধামশ্বর', 0, 0),
(479, 196, '', 'বায়রা', 0, 0),
(480, 196, '', 'তালেবপুর', 0, 0),
(481, 196, '', 'সিংগাইর', 0, 0),
(482, 196, '', 'বলধারা', 0, 0),
(483, 196, '', 'জামশা', 0, 0),
(484, 196, '', 'চারিগ্রাম', 0, 0),
(485, 196, '', 'শায়েস্তা', 0, 0),
(486, 196, '', 'জয়মন্টপ', 0, 0),
(487, 196, '', 'ধল্লা', 0, 0),
(488, 196, '', 'জার্মিতা', 0, 0),
(489, 196, '', 'চান্দহর', 0, 0),
(490, 149, '', 'সাভার', 0, 0),
(491, 149, '', 'বিরুলিয়া', 0, 0),
(492, 149, '', 'ধামসোনা', 0, 0),
(493, 149, '', 'শিমুলিয়া', 0, 0),
(494, 149, '', 'আশুলিয়া', 0, 0),
(495, 149, '', 'ইয়ারপুর', 0, 0),
(496, 149, '', 'ভাকুর্তা', 0, 0),
(497, 149, '', 'পাথালিয়া', 0, 0),
(498, 149, '', 'বনগাঁও', 0, 0),
(499, 149, '', 'কাউন্দিয়া', 0, 0),
(500, 149, '', 'তেঁতুলঝোড়া', 0, 0),
(501, 149, '', 'আমিনবাজার', 0, 0),
(502, 145, '', 'চৌহাট ইউনিয়ন', 0, 0),
(503, 145, '', 'আমতা ইউনিয়ন', 0, 0),
(504, 145, '', 'বালিয়া ইউনিয়ন', 0, 0),
(505, 145, '', 'যাদবপুর ইউনিয়ন', 0, 0),
(506, 145, '', 'বাইশাকান্দা ইউনিয়ন', 0, 0),
(507, 145, '', 'কুশুরা', 0, 0),
(508, 145, '', 'গাংগুটিয়া', 0, 0),
(509, 145, '', 'সানোড়া', 0, 0),
(510, 145, '', 'সূতিপাড়া', 0, 0),
(511, 145, '', 'সোমভাগ', 0, 0),
(512, 145, '', 'ভাড়ারিয়া', 0, 0),
(513, 145, '', 'ধামরাই', 0, 0),
(514, 145, '', 'কুল্লা', 0, 0),
(515, 145, '', 'রোয়াইল', 0, 0),
(516, 145, '', 'সুয়াপুর', 0, 0),
(517, 145, '', 'নান্নার', 0, 0),
(518, 147, '', 'হযরতপুর', 0, 0),
(519, 147, '', 'কলাতিয়া ইউনিয়ন', 0, 0),
(520, 147, '', 'তারানগর', 0, 0),
(521, 147, '', 'শাক্তা', 0, 0),
(522, 147, '', 'রোহিতপুর', 0, 0),
(523, 147, '', 'বাস্তা', 0, 0),
(524, 147, '', 'কালিন্দি', 0, 0),
(525, 147, '', 'জিনজিরা', 0, 0),
(526, 147, '', 'শুভাঢ্যা ইউনিয়ন', 0, 0),
(527, 147, '', 'তেঘরিয়া ইউনিয়ন', 0, 0),
(528, 147, '', 'কোন্ডা ইউনিয়ন', 0, 0),
(529, 147, '', 'আগানগর ইউনিয়ন', 0, 0),
(530, 148, '', 'শিকারীপাড়া ইউনিয়ন', 0, 0),
(531, 148, '', 'জয়কৃষ্ণপুর ইউনিয়ন', 0, 0),
(532, 148, '', 'বারুয়াখালী ইউনিয়ন', 0, 0),
(533, 148, '', 'নয়নশ্রী', 0, 0),
(534, 148, '', 'শোল্লা ইউনিয়ন', 0, 0),
(535, 148, '', 'যন্ত্রাইল ইউনিয়ন', 0, 0),
(536, 148, '', 'বান্দুরা ইউনিয়ন', 0, 0),
(537, 148, '', 'কলাকোপা ইউনিয়ন', 0, 0),
(538, 148, '', 'বক্সনগর ইউনিয়ন', 0, 0),
(539, 148, '', 'বাহ্রা', 0, 0),
(540, 148, '', 'কৈলাইল', 0, 0),
(541, 148, '', 'আগলা ইউনিয়ন', 0, 0),
(542, 148, '', 'গালিমপুর', 0, 0),
(543, 148, '', 'চুড়াইন', 0, 0),
(544, 146, '', 'নয়াবাড়ী ইউনিয়ন', 0, 0),
(545, 146, '', 'কুসুমহাটি ইউনিয়ন', 0, 0),
(546, 146, '', 'রাইপাড়া ইউনিয়ন', 0, 0),
(547, 146, '', 'সুতারপাড়া ইউনিয়ন', 0, 0),
(548, 146, '', 'নারিশা ইউনিয়ন', 0, 0),
(549, 146, '', 'মুকসুদপুর ইউনিয়ন', 0, 0),
(550, 146, '', 'মাহমুদপুর ইউনিয়ন', 0, 0),
(551, 146, '', 'বিলাসপুর ইউনিয়ন', 0, 0),
(552, 204, '', 'রামপাল', 0, 0),
(553, 204, '', 'পঞ্চসার', 0, 0),
(554, 204, '', 'বজ্রযোগিনী', 0, 0),
(555, 204, '', 'মহাকালী', 0, 0),
(556, 204, '', 'চরকেওয়ার', 0, 0),
(557, 204, '', 'মোল্লাকান্দি', 0, 0),
(558, 204, '', 'আধারা', 0, 0),
(559, 204, '', 'শিলই', 0, 0),
(560, 204, '', 'বাংলাবাজার', 0, 0),
(561, 203, '', 'বাড়েখাল', 0, 0),
(562, 203, '', 'হাসাড়া', 0, 0),
(563, 203, '', 'বাড়তারা', 0, 0),
(564, 203, '', 'ষোলঘর', 0, 0),
(565, 203, '', 'শ্রীনগর', 0, 0),
(566, 203, '', 'পাঢাভোগ', 0, 0),
(567, 203, '', 'শ্যামসিদ্দি', 0, 0),
(568, 203, '', 'কুলাপাড়া', 0, 0),
(569, 203, '', 'ভাগ্যকুল', 0, 0),
(570, 203, '', 'বাঘড়া', 0, 0),
(571, 203, '', 'রাঢ়ীখাল', 0, 0),
(572, 203, '', 'কুকুটিয়া', 0, 0),
(573, 203, '', 'আটপাড়া', 0, 0),
(574, 203, '', 'তন্তর', 0, 0),
(575, 205, '', 'চিত্রকোট ইউনিয়ন', 0, 0),
(576, 205, '', 'শেখরনগার', 0, 0),
(577, 205, '', 'রাজানগর', 0, 0),
(578, 205, '', 'কেয়াইন', 0, 0),
(579, 205, '', 'বাসাইল', 0, 0),
(580, 205, '', 'বালুচর', 0, 0),
(581, 205, '', 'লতাব্দী', 0, 0),
(582, 205, '', 'রশুনিয়া', 0, 0),
(583, 205, '', 'ইছাপুরা', 0, 0),
(584, 205, '', 'বয়রাগাদি', 0, 0),
(585, 205, '', 'মালখানগর', 0, 0),
(586, 205, '', 'মধ্যপাড়া', 0, 0),
(587, 205, '', 'কোলা', 0, 0),
(588, 205, '', 'জৈনসার', 0, 0),
(589, 202, '', 'মেদিনীমন্ডল', 0, 0),
(590, 202, '', 'কুমারভোগ', 0, 0),
(591, 202, '', 'হলদিয়া', 0, 0),
(592, 202, '', 'কনকসার', 0, 0),
(593, 202, '', 'লৌহজং-তেওটিয়া', 0, 0),
(594, 202, '', 'বেজগাঁও', 0, 0),
(595, 202, '', 'বৌলতলী', 0, 0),
(596, 202, '', 'খিদিরপাড়া', 0, 0),
(597, 202, '', 'গাওদিয়া', 0, 0),
(598, 202, '', 'কলমা', 0, 0),
(599, 207, '', 'গজারিয়া', 0, 0),
(600, 207, '', 'বাউশিয়া', 0, 0),
(601, 207, '', 'ভবেরচর', 0, 0),
(602, 207, '', 'বালুয়াকান্দী', 0, 0),
(603, 207, '', 'টেংগারচর', 0, 0),
(604, 207, '', 'হোসেন্দী', 0, 0),
(605, 207, '', 'গুয়াগাছিয়া', 0, 0),
(606, 207, '', 'ইমামপুর', 0, 0),
(607, 206, '', 'বেতকা', 0, 0),
(608, 206, '', 'আব্দুল্লাপুর', 0, 0),
(609, 206, '', 'সোনারং টংগীবাড়ী', 0, 0),
(610, 206, '', 'আউটশাহী', 0, 0),
(611, 206, '', 'আড়িয়ল বালিগাঁও', 0, 0),
(612, 206, '', 'ধীপুর', 0, 0),
(613, 206, '', 'কাঠাদিয়া শিমুলিয়া', 0, 0),
(614, 206, '', 'যশলং', 0, 0),
(615, 206, '', 'পাঁচগাও', 0, 0),
(616, 206, '', 'কামারখাড়া ইউনিয়ন', 0, 0),
(617, 206, '', 'হাসাইল বানারী', 0, 0),
(618, 206, '', 'দিঘীরপাড়', 0, 0),
(619, 246, '', 'মিজানপুর', 0, 0),
(620, 246, '', 'বরাট', 0, 0),
(621, 246, '', 'চন্দনী', 0, 0),
(622, 246, '', 'খানগঞ্জ', 0, 0),
(623, 246, '', 'বানীবহ', 0, 0),
(624, 246, '', 'দাদশী', 0, 0),
(625, 246, '', 'মুলঘর', 0, 0),
(626, 246, '', 'বসন্তপুর', 0, 0),
(627, 246, '', 'খানখানাপুর', 0, 0),
(628, 246, '', 'আলীপুর', 0, 0),
(629, 246, '', 'রামকান্তপুর', 0, 0),
(630, 246, '', 'শহীদওহাবপুর', 0, 0),
(631, 246, '', 'পাঁচুরিয়া', 0, 0),
(632, 246, '', 'সুলতানপুর', 0, 0),
(633, 243, '', 'দৌলতদিয়া', 0, 0),
(634, 243, '', 'দেবগ্রাম', 0, 0),
(635, 243, '', 'উজানচর', 0, 0),
(636, 243, '', 'ছোটভাকলা', 0, 0),
(637, 244, '', 'বাহাদুরপুর', 0, 0),
(638, 244, '', 'হাবাসপুর', 0, 0),
(639, 244, '', 'যশাই', 0, 0),
(640, 244, '', 'বাবুপাড়া', 0, 0),
(641, 244, '', 'মৌরাট', 0, 0),
(642, 244, '', 'পাট্টা', 0, 0),
(643, 244, '', 'সরিষা', 0, 0),
(644, 244, '', 'কলিমহর', 0, 0),
(645, 244, '', 'কসবামাজাইল', 0, 0),
(646, 244, '', 'মাছপাড়া', 0, 0),
(647, 242, '', 'ইসলামপুর', 0, 0),
(648, 242, '', 'বহরপুর', 0, 0),
(649, 242, '', 'নবাবপুর', 0, 0),
(650, 242, '', 'নারুয়া', 0, 0),
(651, 242, '', 'বালিয়াকান্দি', 0, 0),
(652, 242, '', 'জঙ্গল', 0, 0),
(653, 242, '', 'জামালপুর', 0, 0),
(654, 245, '', 'কালুখালী', 0, 0),
(655, 245, '', 'রতনদিয়া', 0, 0),
(656, 245, '', 'কালিকাপুর', 0, 0),
(657, 245, '', 'বোয়ালিয়া', 0, 0),
(658, 245, '', 'মাজবাড়ী', 0, 0),
(659, 245, '', 'মদাপুর', 0, 0),
(660, 245, '', 'সাওরাইল', 0, 0),
(661, 245, '', 'মৃগী', 0, 0),
(662, 191, '', 'শিড়খাড়া', 0, 0),
(663, 191, '', 'বাহাদুরপুর', 0, 0),
(664, 191, '', 'কুনিয়া', 0, 0),
(665, 191, '', 'পেয়ারপুর', 0, 0),
(666, 191, '', 'কেন্দুয়া', 0, 0),
(667, 191, '', 'মস্তফাপুর', 0, 0),
(668, 191, '', 'দুধখালী', 0, 0),
(669, 191, '', 'কালিকাপুর', 0, 0),
(670, 191, '', 'ছিলারচর', 0, 0),
(671, 191, '', 'পাঁচখোলা', 0, 0),
(672, 191, '', 'ঘটমাঝি', 0, 0),
(673, 191, '', 'ঝাউদী', 0, 0),
(674, 191, '', 'খোয়াজপুর', 0, 0),
(675, 191, '', 'রাস্তি', 0, 0),
(676, 191, '', 'ধুরাইল', 0, 0),
(677, 194, '', 'শিবচর', 0, 0),
(678, 194, '', 'দ্বিতীয়খন্ড', 0, 0),
(679, 194, '', 'নিলখি', 0, 0),
(680, 194, '', 'বন্দরখোলা', 0, 0),
(681, 194, '', 'চরজানাজাত', 0, 0),
(682, 194, '', 'মাদবরেরচর', 0, 0),
(683, 194, '', 'পাঁচচর', 0, 0),
(684, 194, '', 'সন্যাসিরচর', 0, 0),
(685, 194, '', 'কাঁঠালবাড়ী', 0, 0),
(686, 194, '', 'কুতুবপুর', 0, 0),
(687, 194, '', 'কাদিরপুর', 0, 0),
(688, 194, '', 'ভান্ডারীকান্দি', 0, 0),
(689, 194, '', 'বহেরাতলা দক্ষিণ', 0, 0),
(690, 194, '', 'বহেরাতলা উত্তর', 0, 0),
(691, 194, '', 'বাঁশকান্দি', 0, 0),
(692, 194, '', 'উমেদপুর', 0, 0),
(693, 194, '', 'ভদ্রাসন', 0, 0),
(694, 194, '', 'শিরুয়াইল', 0, 0),
(695, 194, '', 'দত্তপাড়া', 0, 0),
(696, 192, '', 'আলীনগর', 0, 0),
(697, 192, '', 'বালীগ্রাম', 0, 0),
(698, 192, '', 'বাঁশগাড়ী', 0, 0),
(699, 192, '', 'চরদৌলতখান', 0, 0),
(700, 192, '', 'ডাসার', 0, 0),
(701, 192, '', 'এনায়েতনগর', 0, 0),
(702, 192, '', 'গোপালপুর', 0, 0),
(703, 192, '', 'কয়ারিয়া', 0, 0),
(704, 192, '', 'কাজীবাকাই', 0, 0),
(705, 192, '', 'লক্ষীপুর', 0, 0),
(706, 192, '', 'নবগ্রাম', 0, 0),
(707, 192, '', 'রমজানপুর', 0, 0),
(708, 192, '', 'সাহেবরামপুর', 0, 0),
(709, 192, '', 'শিকারমঙ্গল', 0, 0),
(710, 193, '', 'হরিদাসদী-মহেন্দ্রদী', 0, 0),
(711, 193, '', 'কদমবাড়ী', 0, 0),
(712, 193, '', 'বাজিতপুর', 0, 0),
(713, 193, '', 'আমগ্রাম', 0, 0),
(714, 193, '', 'রাজৈর', 0, 0),
(715, 193, '', 'খালিয়া', 0, 0),
(716, 193, '', 'ইশিবপুর', 0, 0),
(717, 193, '', 'বদরপাশা', 0, 0),
(718, 193, '', 'কবিরাজপুর', 0, 0),
(719, 193, '', 'হোসেনপুর', 0, 0),
(720, 193, '', 'পাইকপাড়া', 0, 0),
(721, 165, '', 'জালালাবাদ', 0, 0),
(722, 165, '', 'শুকতাইল', 0, 0),
(723, 165, '', 'চন্দ্রদিঘলিয়া', 0, 0),
(724, 165, '', 'গোপীনাথপুর', 0, 0),
(725, 165, '', 'পাইককান্দি', 0, 0),
(726, 165, '', 'উরফি', 0, 0),
(727, 165, '', 'লতিফপুর', 0, 0),
(728, 165, '', 'সাতপাড় ইউনিয়ন', 0, 0),
(729, 165, '', 'সাহাপুর', 0, 0),
(730, 165, '', 'হরিদাসপুর', 0, 0),
(731, 165, '', 'উলপুর ইউনিয়ন', 0, 0),
(732, 165, '', 'নিজড়া', 0, 0),
(733, 165, '', 'করপাড়া ইউনিয়ন', 0, 0),
(734, 165, '', 'দুর্গাপুর ইউনিয়ন', 0, 0),
(735, 165, '', 'কাজুলিয়া', 0, 0),
(736, 165, '', 'মাঝিগাতী', 0, 0),
(737, 165, '', 'রঘুনাথপুর ইউনিয়ন', 0, 0),
(738, 165, '', 'গোবরা ইউনিয়ন', 0, 0),
(739, 165, '', 'বোড়াশী ইউনিয়ন', 0, 0),
(740, 165, '', 'কাঠি', 0, 0),
(741, 165, '', 'বৌলতলী', 0, 0),
(742, 166, '', 'কাশিয়ানী', 0, 0),
(743, 166, '', 'হাতিয়াড়া', 0, 0),
(744, 166, '', 'ফুকরা', 0, 0),
(745, 166, '', 'রাজপাট', 0, 0),
(746, 166, '', 'বেথুড়ী', 0, 0),
(747, 166, '', 'নিজামকান্দি', 0, 0),
(748, 166, '', 'সাজাইল', 0, 0),
(749, 166, '', 'মাহমুদপুর', 0, 0),
(750, 166, '', 'মহেশপুর', 0, 0),
(751, 166, '', 'ওড়াকান্দি', 0, 0),
(752, 166, '', 'পারুলিয়া', 0, 0),
(753, 166, '', 'রাতইল', 0, 0),
(754, 166, '', 'পুইশুর', 0, 0),
(755, 166, '', 'সিংগা', 0, 0),
(756, 169, '', 'কুশলী', 0, 0),
(757, 169, '', 'গোপালপুর', 0, 0),
(758, 169, '', 'পাটগাতী', 0, 0),
(759, 169, '', 'বর্ণি', 0, 0),
(760, 169, '', 'ডুমরিয়া', 0, 0),
(761, 167, '', 'সাদুল্লাপুর', 0, 0),
(762, 167, '', 'রামশীল', 0, 0),
(763, 167, '', 'বান্ধাবাড়ী', 0, 0),
(764, 167, '', 'কলাবাড়ী', 0, 0),
(765, 167, '', 'কুশলা', 0, 0),
(766, 167, '', 'আমতলী', 0, 0),
(767, 167, '', 'পিঞ্জুরী', 0, 0),
(768, 167, '', 'ঘাঘর', 0, 0),
(769, 167, '', 'রাধাগঞ্জ', 0, 0),
(770, 167, '', 'হিরণ', 0, 0),
(771, 167, '', 'কান্দি', 0, 0),
(772, 168, '', 'উজানী', 0, 0),
(773, 168, '', 'দিগনগর', 0, 0),
(774, 168, '', 'পশারগাতি', 0, 0),
(775, 168, '', 'গোবিন্দপুর', 0, 0),
(776, 168, '', 'খান্দারপাড়া', 0, 0),
(777, 168, '', 'বহুগ্রাম', 0, 0),
(778, 168, '', 'বাশঁবাড়িয়া', 0, 0),
(779, 168, '', 'ভাবড়াশুর', 0, 0),
(780, 168, '', 'মহারাজপুর', 0, 0),
(781, 168, '', 'বাটিকামারী', 0, 0),
(782, 168, '', 'জলিরপাড়', 0, 0),
(783, 168, '', 'রাঘদী', 0, 0),
(784, 168, '', 'গোহালা', 0, 0),
(785, 168, '', 'মোচনা', 0, 0),
(786, 168, '', 'কাশালিয়া', 0, 0),
(787, 150, '', 'ঈশানগোপালপুর', 0, 0),
(788, 150, '', 'চরমাধবদিয়া', 0, 0),
(789, 150, '', 'আলিয়াবাদ', 0, 0),
(790, 150, '', 'নর্থচ্যানেল', 0, 0),
(791, 150, '', 'ডিক্রিরচর', 0, 0),
(792, 150, '', 'মাচ্চর', 0, 0),
(793, 150, '', 'কৃষ্ণনগর', 0, 0),
(794, 150, '', 'অম্বিকাপুর', 0, 0),
(795, 150, '', 'কানাইপুর', 0, 0),
(796, 150, '', 'কৈজুরী', 0, 0),
(797, 150, '', 'গেরদা', 0, 0),
(798, 152, '', 'বুড়াইচ', 0, 0),
(799, 152, '', 'আলফাডাঙ্গা', 0, 0),
(800, 152, '', 'টগরবন্দ', 0, 0),
(801, 152, '', 'বানা', 0, 0),
(802, 152, '', 'পাঁচুড়িয়া', 0, 0),
(803, 152, '', 'গোপালপুর', 0, 0),
(804, 151, '', 'বোয়ালমারী', 0, 0),
(805, 151, '', 'দাদপুর', 0, 0),
(806, 151, '', 'চতুল', 0, 0),
(807, 151, '', 'ঘোষপুর', 0, 0),
(808, 151, '', 'গুনবহা', 0, 0),
(809, 151, '', 'চাঁদপুর', 0, 0),
(810, 151, '', 'পরমেশ্বরদী', 0, 0),
(811, 151, '', 'সাতৈর', 0, 0),
(812, 151, '', 'রূপাপাত', 0, 0),
(813, 151, '', 'শেখর', 0, 0),
(814, 151, '', 'ময়না', 0, 0),
(815, 157, '', 'চর বিষ্ণুপুর', 0, 0),
(816, 157, '', 'আকোটের চর', 0, 0),
(817, 157, '', 'চর নাসিরপুর', 0, 0),
(818, 157, '', 'নারিকেল বাড়িয়া', 0, 0),
(819, 157, '', 'ভাষানচর', 0, 0),
(820, 157, '', 'কৃষ্ণপুর', 0, 0),
(821, 157, '', 'সদরপুর', 0, 0),
(822, 157, '', 'চর মানাইর', 0, 0),
(823, 157, '', 'ঢেউখালী', 0, 0),
(824, 155, '', 'চরযশোরদী', 0, 0),
(825, 155, '', 'পুরাপাড়া', 0, 0),
(826, 155, '', 'লস্করদিয়া', 0, 0),
(827, 155, '', 'রামনগর', 0, 0),
(828, 155, '', 'কাইচাইল', 0, 0),
(829, 155, '', 'তালমা', 0, 0),
(830, 155, '', 'ফুলসুতি', 0, 0),
(831, 155, '', 'ডাঙ্গী', 0, 0),
(832, 155, '', 'কোদালিয়া', 0, 0),
(833, 154, '', 'ঘারুয়া', 0, 0),
(834, 154, '', 'নুরুল্যাগঞ্জ', 0, 0),
(835, 154, '', 'মানিকদহ', 0, 0),
(836, 154, '', 'কাউলিবেড়া', 0, 0),
(837, 154, '', 'নাছিরাবাদ', 0, 0),
(838, 154, '', 'তুজারপুর', 0, 0),
(839, 154, '', 'আলগী', 0, 0),
(840, 154, '', 'চুমুরদী', 0, 0),
(841, 154, '', 'কালামৃধা', 0, 0),
(842, 154, '', 'আজিমনগর', 0, 0),
(843, 154, '', 'চান্দ্রা', 0, 0),
(844, 154, '', 'হামিরদী', 0, 0),
(845, 156, '', 'গাজীরটেক', 0, 0),
(846, 156, '', 'চর ভদ্রাসন', 0, 0),
(847, 156, '', 'চর হরিরামপুর', 0, 0),
(848, 156, '', 'চর ঝাউকান্দা', 0, 0),
(849, 153, '', 'মধুখালী', 0, 0),
(850, 153, '', 'জাহাপুর', 0, 0),
(851, 153, '', 'গাজনা', 0, 0),
(852, 153, '', 'মেগচামী', 0, 0),
(853, 153, '', 'রায়পুর', 0, 0),
(854, 153, '', 'বাগাট', 0, 0),
(855, 153, '', 'ডুমাইন', 0, 0),
(856, 153, '', 'নওপাড়া', 0, 0),
(857, 153, '', 'কামারখালী', 0, 0),
(858, 158, '', 'ভাওয়াল', 0, 0),
(859, 158, '', 'আটঘর', 0, 0),
(860, 158, '', 'মাঝারদিয়া', 0, 0),
(861, 158, '', 'বল্লভদী', 0, 0),
(862, 158, '', 'গট্টি', 0, 0),
(863, 158, '', 'যদুনন্দী', 0, 0),
(864, 158, '', 'রামকান্তপুর', 0, 0),
(865, 158, '', 'সোনাপুর', 0, 0),
(866, 88, '', 'সুবিল', 0, 0),
(867, 88, '', 'গুনাইঘর (উত্তর)', 0, 0),
(868, 88, '', 'গুনাইঘর (দক্ষিণ)', 0, 0),
(869, 88, '', 'বড়শালঘর ইউনিয়ন', 0, 0),
(870, 88, '', 'রাজামেহার ইউনিয়ন', 0, 0),
(871, 88, '', 'ইউসুফপুর ইউনিয়ন', 0, 0),
(872, 88, '', 'রসুলপুর ইউনিয়ন', 0, 0),
(873, 88, '', 'ফতেহাবাদ ইউনিয়ন', 0, 0),
(874, 88, '', 'এলাহাবাদ ইউনিয়ন', 0, 0),
(875, 88, '', 'জাফরগঞ্জ ইউনিয়ন', 0, 0),
(876, 88, '', 'ধামতী ইউনিয়ন', 0, 0),
(877, 88, '', 'মোহনপুর', 0, 0),
(878, 88, '', 'ভানী', 0, 0),
(879, 88, '', 'বরকামতা', 0, 0),
(880, 88, '', 'সুলতানপুর ইউনিয়ন', 0, 0),
(881, 82, '', 'আগানগর', 0, 0),
(882, 82, '', 'ভবানীপুর', 0, 0),
(883, 82, '', 'খোশবাস (উ:)', 0, 0),
(884, 82, '', 'খোশবাস (দ:)', 0, 0),
(885, 82, '', 'ঝলম', 0, 0),
(886, 82, '', 'চিতড্ডা', 0, 0),
(887, 82, '', 'শিলমুড়ি (উ:)', 0, 0),
(888, 82, '', 'শিলমুড়ি (দ:)', 0, 0),
(889, 82, '', 'গালিমপুর', 0, 0),
(890, 82, '', 'শাকপুর', 0, 0),
(891, 82, '', 'ভাউকসার', 0, 0),
(892, 82, '', 'আড্ডা', 0, 0),
(893, 82, '', 'আদ্রা', 0, 0),
(894, 82, '', 'পয়ালগাছা', 0, 0),
(895, 82, '', 'লক্ষীপুর', 0, 0),
(896, 83, '', 'শিদলাই ইউনিয়ন', 0, 0),
(897, 83, '', 'চান্দলা ইউনিয়ন', 0, 0),
(898, 83, '', 'শশীদল ইউনিয়ন', 0, 0),
(899, 83, '', 'দুলালপুর (২) ইউনিয়ন', 0, 0),
(900, 83, '', 'ব্রাহ্মনপাড়া সদর ইউনিয়ন', 0, 0),
(901, 83, '', 'সাহেবাবাদ ইউনিয়ন', 0, 0),
(902, 83, '', 'মালাপাড়া ইউনিয়ন', 0, 0),
(903, 83, '', 'মাধবপুর', 0, 0),
(904, 85, '', 'সুহিলপুর', 0, 0),
(905, 85, '', 'বাতাঘাসি', 0, 0),
(906, 85, '', 'জোয়াগ', 0, 0),
(907, 85, '', 'বরকরই', 0, 0),
(908, 85, '', 'মাধাইয়া', 0, 0),
(909, 85, '', 'দোল্লাই নবাবপুর', 0, 0),
(910, 85, '', 'মহিচাইল', 0, 0),
(911, 85, '', 'গল্লাই', 0, 0),
(912, 85, '', 'কেরণখাল', 0, 0),
(913, 85, '', 'মাইজখার', 0, 0),
(914, 85, '', 'এতবারপুর', 0, 0),
(915, 85, '', 'বাড়েরা', 0, 0),
(916, 85, '', 'বরকইট', 0, 0),
(917, 86, '', 'শ্রীপুর', 0, 0),
(918, 86, '', 'কাশিনগর', 0, 0),
(919, 86, '', '২নং কালিকাপুর', 0, 0),
(920, 86, '', '৪নং শুভপুর', 0, 0),
(921, 86, '', '৫নং ঘোলপাশা', 0, 0),
(922, 86, '', '৬নং মুন্সীরহাট', 0, 0),
(923, 86, '', '৭নং বাতিসা', 0, 0),
(924, 86, '', '৮নং কনকাপৈত', 0, 0),
(925, 86, '', '৯নং চিওড়া', 0, 0),
(926, 86, '', '১০ নং জগন্নাথদিঘী', 0, 0),
(927, 86, '', '১১ নং গুনবতী', 0, 0),
(928, 86, '', '১২নং আলকরা', 0, 0),
(929, 87, '', 'দৌলতপুর', 0, 0),
(930, 87, '', 'দাউদকান্দি (উত্তর)', 0, 0),
(931, 87, '', 'ইলিয়টগঞ্জ (উত্তর)', 0, 0),
(932, 87, '', 'ইলিয়টগঞ্জ (দক্ষিন)', 0, 0),
(933, 87, '', 'জিংলাতলী', 0, 0),
(934, 87, '', 'সুন্দলপুর', 0, 0),
(935, 87, '', 'গৌরীপুর ইউনিয়ন', 0, 0),
(936, 87, '', 'মোহাম্মদপুর (পুর্ব) ইউনিয়ন', 0, 0),
(937, 87, '', 'মোহাম্মদপুর (পশ্চিম) ইউনিয়ন', 0, 0),
(938, 87, '', 'গোয়ালমারী ইউনিয়ন', 0, 0),
(939, 87, '', 'মারুকা ইউনিয়ন', 0, 0),
(940, 87, '', 'বিটেশ্বর ইউনিয়ন', 0, 0),
(941, 87, '', 'পদুয়া ইউনিয়ন', 0, 0),
(942, 87, '', 'পাচঁগাছিয়া (পশ্চিম) ইউনিয়ন', 0, 0),
(943, 87, '', 'বারপাড়া', 0, 0),
(944, 89, '', 'মাথাভাঙ্গা', 0, 0),
(945, 89, '', 'ঘাগুটিয়া', 0, 0),
(946, 89, '', 'আছাদপুর', 0, 0),
(947, 89, '', 'চান্দেরচর', 0, 0),
(948, 89, '', 'ভাষানিয়া', 0, 0),
(949, 89, '', 'নিলখী ইউনিয়ন', 0, 0),
(950, 89, '', 'ঘারমোড়া ইউনিয়ন', 0, 0),
(951, 89, '', 'জয়পুর ইউনিয়ন', 0, 0),
(952, 89, '', 'দুলালপুর', 0, 0),
(953, 91, '', 'বাকই', 0, 0),
(954, 91, '', 'মুদাফফর গঞ্জ ইউনিয়ন', 0, 0),
(955, 91, '', 'কান্দিরপাড় ইউনিয়ন', 0, 0),
(956, 91, '', 'গোবিন্দপুর ইউনিয়ন (2)', 0, 0),
(957, 91, '', 'উত্তরদা ইউনিয়ন', 0, 0),
(958, 91, '', 'লাকসাম পুর্ব ইউনিয়ন', 0, 0),
(959, 91, '', 'আজগরা ইউনিয়ন', 0, 0),
(960, 94, '', '১নং শ্রীকাইল', 0, 0),
(961, 94, '', '২নং আকুবপুর', 0, 0),
(962, 94, '', '৩নং আন্দিকোট', 0, 0),
(963, 94, '', '৪নং পুর্বধৈইর (পুর্ব)', 0, 0),
(964, 94, '', '৫নং পুর্বধৈইর (পশ্চিম)', 0, 0),
(965, 94, '', '৬নং বাঙ্গরা (পূর্ব)', 0, 0),
(966, 94, '', '৭নং বাঙ্গরা (পশ্চিম)', 0, 0),
(967, 94, '', '৮নং চাপিতলা', 0, 0),
(968, 94, '', '৯নং কামাল্লা', 0, 0),
(969, 94, '', '১০নং যাত্রাপুর', 0, 0),
(970, 94, '', 'রামচন্দ্রপুর উত্তর', 0, 0),
(971, 94, '', 'রামচন্দ্রপুর দক্ষিন', 0, 0),
(972, 94, '', '১১ নং মুরাদনগর সদর', 0, 0),
(973, 94, '', '১২নং নবীপুর (পুর্ব)', 0, 0),
(974, 94, '', '১৩নং নবীপুর (পশ্চিম)', 0, 0),
(975, 94, '', '১৪নং ধামঘর', 0, 0),
(976, 94, '', '১৫নং জাহাপুর', 0, 0),
(977, 94, '', '১৬নং ছালিয়াকান্দি', 0, 0),
(978, 94, '', '১৭নং দারোরা', 0, 0),
(979, 94, '', '১৮নং পাহাড়পুর', 0, 0),
(980, 94, '', '২১নং বাবুটিপাড়া', 0, 0),
(981, 94, '', '২২নং টনকী', 0, 0),
(982, 95, '', 'বাঙ্গড্ডা', 0, 0),
(983, 95, '', 'পেরিয়া', 0, 0),
(984, 95, '', 'রায়কোট', 0, 0),
(985, 95, '', 'মোকরা', 0, 0),
(986, 95, '', 'মক্রবপুর', 0, 0),
(987, 95, '', 'হেসাখাল', 0, 0),
(988, 95, '', 'আদ্রা', 0, 0),
(989, 95, '', 'জোড্ডা', 0, 0),
(990, 95, '', 'ঢালুয়া', 0, 0),
(991, 95, '', 'দৌলখাঁড়', 0, 0),
(992, 95, '', 'বক্সগঞ্জ', 0, 0),
(993, 95, '', 'সাতবাড়ীয়া ইউনিয়ন', 0, 0),
(994, 90, '', 'কালীর বাজার ইউনিয়ন', 0, 0),
(995, 90, '', 'দুর্গাপুর (উত্তর) ইউনিয়ন', 0, 0),
(996, 90, '', 'দুর্গাপুর (দক্ষিন) ইউনিয়ন', 0, 0),
(997, 90, '', 'আমড়াতলী ইউনিয়ন', 0, 0),
(998, 90, '', 'পাঁচথুবী ইউনিয়ন', 0, 0),
(999, 90, '', 'জগন্নাথপুর ইউনিয়ন', 0, 0),
(1000, 93, '', 'চন্দনপুর', 0, 0),
(1001, 93, '', '২নং চালিভাঙ্গা', 0, 0),
(1002, 93, '', '৩নং রাধানগর', 0, 0),
(1003, 93, '', '৪নং মানিকারচর', 0, 0),
(1004, 93, '', '৫নং বড়কান্দা', 0, 0),
(1005, 93, '', '৬নং গোবিন্দপুর', 0, 0),
(1006, 93, '', '৭নং লুটেরচর', 0, 0),
(1007, 93, '', '৮নং ভাওরখোলা', 0, 0),
(1008, 92, '', 'বাইশগাঁও', 0, 0),
(1009, 92, '', 'সরসপুর', 0, 0),
(1010, 92, '', 'হাসনাবাদ', 0, 0),
(1011, 92, '', '৪নং ঝলম উত্তর ইউনিয়ন', 0, 0),
(1012, 92, '', '৫নং ঝলম দক্ষিন', 0, 0),
(1013, 92, '', 'মৈশাতুয়া', 0, 0),
(1014, 92, '', 'লক্ষনপুর', 0, 0),
(1015, 92, '', 'খিলা ইউনিয়ন', 0, 0),
(1016, 92, '', 'উত্তর হাওলা', 0, 0),
(1017, 92, '', 'নাথেরপেটুয়া', 0, 0),
(1018, 92, '', 'বিপুলাসার', 0, 0),
(1019, 96, '', 'চৌয়ারা', 0, 0),
(1020, 96, '', 'বারপাড়া ইউনিয়ন', 0, 0),
(1021, 96, '', 'জোড়কানন (পুর্ব)', 0, 0),
(1022, 96, '', 'গলিয়ারা', 0, 0),
(1023, 96, '', 'জোড়কানন (পশ্চিম)', 0, 0),
(1024, 96, '', 'বাগমারা (উত্তর)', 0, 0),
(1025, 96, '', 'বাগমারা (দক্ষিন) ইউনিয়ন', 0, 0),
(1026, 96, '', 'ভূলইন (উত্তর) ইউনিয়ন', 0, 0),
(1027, 96, '', 'ভূলইন (দক্ষিন)', 0, 0),
(1028, 96, '', 'বেলঘর (উত্তর)', 0, 0),
(1029, 96, '', 'বেলঘর (দক্ষিন)', 0, 0),
(1030, 96, '', 'পেরুল (উত্তর)', 0, 0),
(1031, 96, '', 'পেরুল (দক্ষিন)', 0, 0),
(1032, 96, '', 'বিজয়পুর', 0, 0),
(1033, 97, '', '১নং সাতানী', 0, 0),
(1034, 97, '', '২নং জগতপুর', 0, 0),
(1035, 97, '', '৩নং বলরামপুর', 0, 0),
(1036, 97, '', '৪নং কড়িকান্দি', 0, 0),
(1037, 97, '', '৫নং কলাকান্দি', 0, 0),
(1038, 97, '', '৬নং ভিটিকান্দি', 0, 0),
(1039, 97, '', '৭নং নারান্দিয়া', 0, 0),
(1040, 97, '', '৮নং জিয়ারকান্দি', 0, 0),
(1041, 97, '', '৯নং মজিদপুর', 0, 0),
(1042, 84, '', 'ময়নামতি', 0, 0),
(1043, 84, '', 'ভারেল্লা', 0, 0),
(1044, 84, '', 'মোকাম', 0, 0),
(1045, 84, '', 'বুড়িচং সদর', 0, 0),
(1046, 84, '', 'বাকশীমূল', 0, 0),
(1047, 84, '', 'পীরযাত্রাপুর', 0, 0),
(1048, 84, '', 'ষোলনল', 0, 0),
(1049, 84, '', 'রাজাপুর', 0, 0),
(1050, 108, '', 'মহামায়া', 0, 0),
(1051, 108, '', 'পাঠাননগর', 0, 0),
(1052, 108, '', 'শুভপুর', 0, 0),
(1053, 108, '', 'রাধানগর', 0, 0),
(1054, 108, '', 'ঘোপাল', 0, 0),
(1055, 107, '', 'শর্শদি', 0, 0),
(1056, 107, '', 'পাঁচগাছিয়া', 0, 0),
(1057, 107, '', 'ধর্মপুর', 0, 0),
(1058, 107, '', 'কাজিরবাগ', 0, 0),
(1059, 107, '', 'কালিদহ', 0, 0),
(1060, 107, '', 'বালিগাঁও', 0, 0),
(1061, 107, '', 'ধলিয়া', 0, 0),
(1062, 107, '', 'লেমুয়া', 0, 0),
(1063, 107, '', 'ছনুয়া', 0, 0),
(1064, 107, '', 'মোটবী', 0, 0),
(1065, 107, '', 'ফাজিলপুর', 0, 0),
(1066, 107, '', 'ফরহাদনগর', 0, 0),
(1067, 112, '', 'চরমজলিশপুর', 0, 0),
(1068, 112, '', 'বগাদানা', 0, 0),
(1069, 112, '', 'মতিগঞ্জ', 0, 0),
(1070, 112, '', 'মঙ্গলকান্দি', 0, 0),
(1071, 112, '', 'চরদরবেশ', 0, 0),
(1072, 112, '', 'চরচান্দিয়া', 0, 0),
(1073, 112, '', 'সোনাগাজী', 0, 0),
(1074, 112, '', 'আমিরাবাদ', 0, 0),
(1075, 112, '', 'নবাবপুর', 0, 0),
(1076, 111, '', 'ফুলগাজী', 0, 0),
(1077, 111, '', 'মুন্সিরহাট', 0, 0),
(1078, 111, '', 'দরবারপুর', 0, 0),
(1079, 111, '', 'আনন্দপুর', 0, 0),
(1080, 111, '', 'আমজাদহাট', 0, 0),
(1081, 111, '', 'জি', 0, 0),
(1082, 111, '', 'এম', 0, 0),
(1083, 111, '', 'হাট', 0, 0),
(1084, 110, '', 'মির্জানগর', 0, 0),
(1085, 110, '', 'চিথলিয়া', 0, 0),
(1086, 110, '', 'বক্সমাহমুদ', 0, 0),
(1087, 109, '', 'সিন্দুরপুর', 0, 0),
(1088, 109, '', 'রাজাপুর', 0, 0),
(1089, 109, '', 'পূর্বচন্দ্রপুর', 0, 0),
(1090, 109, '', 'রামনগর', 0, 0),
(1091, 109, '', 'ইয়াকুবপুর', 0, 0),
(1092, 109, '', 'দাগনভূঞা', 0, 0),
(1093, 109, '', 'মাতুভূঞা', 0, 0),
(1094, 109, '', 'জায়লস্কর', 0, 0),
(1095, 50, '', 'বাসুদেব', 0, 0),
(1096, 50, '', 'মাছিহাতা', 0, 0),
(1097, 50, '', 'সুলতানপুর', 0, 0),
(1098, 50, '', 'রামরাইল ইউনিয়ন', 0, 0),
(1099, 50, '', 'সাদেকপুর ইউনিয়ন', 0, 0),
(1100, 50, '', 'তালশহর', 0, 0),
(1101, 50, '', 'নাটাই (দঃ) ইউনিয়ন', 0, 0),
(1102, 50, '', 'নাটাই', 0, 0),
(1103, 50, '', 'সুহিলপুর', 0, 0),
(1104, 50, '', 'বুধল', 0, 0),
(1105, 50, '', 'মজলিশপুর', 0, 0),
(1106, 56, '', 'মূলগ্রাম', 0, 0),
(1107, 56, '', 'মেহারী', 0, 0),
(1108, 56, '', 'বাদৈর', 0, 0),
(1109, 56, '', 'খাড়েরা', 0, 0),
(1110, 56, '', 'বিনাউটি', 0, 0),
(1111, 56, '', 'গোপীনাথপুর', 0, 0),
(1112, 56, '', 'কসবা(পঃ)', 0, 0),
(1113, 56, '', 'কুটি', 0, 0),
(1114, 56, '', 'কাইমপুর', 0, 0),
(1115, 56, '', 'বায়েক', 0, 0),
(1116, 52, '', 'চাতলপাড়', 0, 0),
(1117, 52, '', 'ভলাকুট', 0, 0),
(1118, 52, '', 'কুন্ডা', 0, 0),
(1119, 52, '', 'গোয়ালনগর ইউনিয়ন', 0, 0),
(1120, 52, '', 'নাসিরনগর', 0, 0),
(1121, 52, '', 'বুড়িশ্বর', 0, 0),
(1122, 52, '', 'ফান্দাউক', 0, 0),
(1123, 52, '', 'গুনিয়াউক', 0, 0),
(1124, 52, '', 'চাপৈরতলা', 0, 0),
(1125, 52, '', 'ধরমন্ডল', 0, 0),
(1126, 52, '', 'হরিপুর', 0, 0),
(1127, 52, '', 'পূর্বভাগ', 0, 0),
(1128, 52, '', 'গোকর্ণ', 0, 0),
(1129, 54, '', 'অরুয়াইল', 0, 0),
(1130, 54, '', 'পাকশিমুল', 0, 0),
(1131, 54, '', 'চুন্টা', 0, 0),
(1132, 54, '', 'কালীকচ্ছ', 0, 0),
(1133, 54, '', 'পানিশ্বর ইউনিয়ন', 0, 0),
(1134, 54, '', 'সরাইল সদর', 0, 0),
(1135, 54, '', 'নোয়াগাঁও', 0, 0),
(1136, 54, '', 'শাহজাদাপুর', 0, 0),
(1137, 54, '', 'শাহবাজপুর', 0, 0),
(1138, 51, '', 'আশুগঞ্জ সদর', 0, 0),
(1139, 51, '', 'চরচারতলা', 0, 0),
(1140, 51, '', 'দুর্গাপুর', 0, 0),
(1141, 51, '', 'আড়াইসিধা', 0, 0),
(1142, 51, '', 'তালশহর(পঃ)', 0, 0),
(1143, 51, '', 'শরীফপুর', 0, 0),
(1144, 51, '', 'লালপুর', 0, 0),
(1145, 51, '', 'তারুয়া', 0, 0),
(1146, 57, '', 'মনিয়ন্দ', 0, 0),
(1147, 57, '', 'ধরখার', 0, 0),
(1148, 57, '', 'মোগড়া', 0, 0),
(1149, 57, '', 'আখাউড়া (উঃ)', 0, 0),
(1150, 57, '', 'আখাউড়া (দঃ)', 0, 0),
(1151, 53, '', 'বড়াইল', 0, 0),
(1152, 53, '', 'বীরগাঁও', 0, 0),
(1153, 53, '', 'কৃষ্ণনগর', 0, 0),
(1154, 53, '', 'নাটঘর', 0, 0),
(1155, 53, '', 'বিদ্যাকুট', 0, 0),
(1156, 53, '', 'নবীনগর', 0, 0),
(1157, 53, '', 'নবীনগর(পশ্চিম)', 0, 0),
(1158, 53, '', 'বিটঘর', 0, 0),
(1159, 53, '', 'শিবপুর', 0, 0),
(1160, 53, '', 'শ্রীরামপুর', 0, 0),
(1161, 53, '', 'জিনোদপুর', 0, 0),
(1162, 53, '', 'লাউরফতেপুর', 0, 0),
(1163, 53, '', 'ইব্রাহিমপুর', 0, 0),
(1164, 53, '', 'সাতমোড়া', 0, 0),
(1165, 53, '', 'শ্যামগ্রাম', 0, 0),
(1166, 53, '', 'রসুল্লাবাদ', 0, 0),
(1167, 53, '', 'বড়িকান্দি', 0, 0),
(1168, 53, '', 'ছলিমগঞ্জ', 0, 0),
(1169, 53, '', 'রতনপুর', 0, 0),
(1170, 53, '', 'কাইতলা (উঃ)', 0, 0),
(1171, 53, '', 'কাইতলা', 0, 0),
(1172, 58, '', 'তেজখালী', 0, 0),
(1173, 58, '', 'পাহাড়িয়া কান্দি', 0, 0),
(1174, 58, '', 'দরিয়াদৌলত', 0, 0),
(1175, 58, '', 'সোনারামপুর', 0, 0),
(1176, 58, '', 'দড়িকান্দি', 0, 0),
(1177, 58, '', 'ছয়ফুল্লাকান্দি', 0, 0),
(1178, 58, '', 'বাঞ্ছারামপুর', 0, 0),
(1179, 58, '', 'আইয়ুবপুর', 0, 0),
(1180, 58, '', 'ফরদাবাদ', 0, 0),
(1181, 58, '', 'রুপসদী পশ্চিম', 0, 0),
(1182, 58, '', 'ছলিমাবাদ', 0, 0),
(1183, 58, '', 'উজানচর পূর্ব', 0, 0),
(1184, 58, '', 'মানিকপুর', 0, 0),
(1185, 59, '', 'বুধন্তি', 0, 0),
(1186, 59, '', 'চান্দুরা', 0, 0),
(1187, 59, '', 'ইছাপুরা', 0, 0),
(1188, 59, '', 'চম্পকনগর', 0, 0),
(1189, 59, '', 'হরষপুর', 0, 0),
(1190, 59, '', 'পত্তন', 0, 0),
(1191, 59, '', 'সিংগারবিল', 0, 0),
(1192, 59, '', 'বিষ্ণুপুর', 0, 0),
(1193, 59, '', 'চর-ইসলামপুর', 0, 0),
(1194, 59, '', 'পাহাড়পুর', 0, 0),
(1195, 135, '', '১ নং জীবতলি', 0, 0),
(1196, 135, '', '৩ নং সাপছড়ি', 0, 0),
(1197, 135, '', '৪ নং কুতুকছড়ি', 0, 0),
(1198, 135, '', '৫ নং বন্দুকভাঙ্গা', 0, 0),
(1199, 135, '', '৬ নং বালুখালী', 0, 0),
(1200, 135, '', '২ নং মগবান', 0, 0),
(1201, 141, '', '২ নং রাইখালী', 0, 0),
(1202, 141, '', '৪ নং কাপ্তাই', 0, 0),
(1203, 141, '', '৫ নং ওয়াজ্ঞা', 0, 0),
(1204, 141, '', '১ নং চন্দ্রঘোনা', 0, 0),
(1205, 141, '', '৩ নং চিৎমরম', 0, 0),
(1206, 144, '', '৩ নং ঘাগড়া', 0, 0),
(1207, 144, '', '২ নং ফটিকছড়ি', 0, 0),
(1208, 144, '', '১ নং বেতবুনিয়া', 0, 0),
(1209, 144, '', '৪ নং কলমপতি', 0, 0),
(1210, 137, '', '৩৬ নং সাজেক', 0, 0),
(1211, 137, '', '৩৭ নং আমতলী', 0, 0),
(1212, 137, '', '৩৫ নং বঙ্গলতলী', 0, 0),
(1213, 137, '', '৩৪ নং রুপকারী', 0, 0),
(1214, 137, '', '৩৩ নং মারিশ্যা', 0, 0),
(1215, 137, '', '৩১ নং খেদারমারা', 0, 0),
(1216, 137, '', '৩০ নং সারোয়াতলী', 0, 0),
(1217, 137, '', '৩২ নং বাঘাইছড়ি', 0, 0),
(1218, 138, '', '১ নং সুবলং', 0, 0),
(1219, 138, '', '২ নং বরকল', 0, 0),
(1220, 138, '', '৪ নং ভূষনছড়া', 0, 0),
(1221, 138, '', '৩ নং আইমাছড়া', 0, 0),
(1222, 138, '', '৫ নং বড় হরিণা', 0, 0),
(1223, 142, '', 'লংগদু', 0, 0),
(1224, 142, '', 'মাইনীমুখ', 0, 0),
(1225, 142, '', 'ভাসান্যাদম', 0, 0),
(1226, 142, '', 'বগাচতর', 0, 0),
(1227, 142, '', 'গুলশাখালী', 0, 0),
(1228, 142, '', 'কালাপাকুজ্যা', 0, 0),
(1229, 142, '', 'আটারকছড়া', 0, 0),
(1230, 140, '', '১ নং ঘিলাছড়ি', 0, 0),
(1231, 140, '', '২ নং গাইন্দ্যা', 0, 0),
(1232, 140, '', '৩ নং বাঙ্গালহালিয়া', 0, 0),
(1233, 136, '', '২ নং কেংড়াছড়ি', 0, 0),
(1234, 136, '', '১ নং বিলাইছড়ি', 0, 0),
(1235, 136, '', '৩ নং ফারুয়া', 0, 0),
(1236, 139, '', 'জুরাছড়ি', 0, 0),
(1237, 139, '', 'বনযোগীছড়া', 0, 0),
(1238, 139, '', 'মৈদং', 0, 0),
(1239, 139, '', 'দুমদুম্যা', 0, 0),
(1240, 143, '', 'সাবেক্ষ্যং', 0, 0),
(1241, 143, '', 'নানিয়ারচর', 0, 0),
(1242, 143, '', 'বুড়িঘাট', 0, 0),
(1243, 143, '', 'ঘিলাছড়ি', 0, 0),
(1244, 126, '', 'চরমটুয়া', 0, 0),
(1245, 126, '', 'দাদপুর', 0, 0),
(1246, 126, '', 'নোয়ান্নই', 0, 0),
(1247, 126, '', 'কাদির হানিফ', 0, 0),
(1248, 126, '', 'বিনোদপুর', 0, 0),
(1249, 126, '', 'ধর্মপুর', 0, 0),
(1250, 126, '', 'এওজবালিয়া', 0, 0),
(1251, 126, '', 'কালাদরপ', 0, 0),
(1252, 126, '', 'অশ্বদিয়া', 0, 0),
(1253, 126, '', 'নিয়াজপুর', 0, 0),
(1254, 126, '', 'পূর্ব চরমটুয়া', 0, 0),
(1255, 126, '', 'আন্ডারচর', 0, 0),
(1256, 126, '', 'নোয়াখালী', 0, 0),
(1257, 129, '', 'সিরাজপুর', 0, 0),
(1258, 129, '', 'চরপার্বতী', 0, 0),
(1259, 129, '', 'চরহাজারী', 0, 0),
(1260, 129, '', 'চরকাঁকড়া', 0, 0),
(1261, 129, '', 'চরফকিরা', 0, 0),
(1262, 129, '', 'মুসাপুর', 0, 0),
(1263, 129, '', 'চরএলাহী', 0, 0),
(1264, 129, '', 'রামপুর', 0, 0),
(1265, 127, '', 'আমানউল্ল্যাপুর', 0, 0),
(1266, 127, '', 'গোপালপুর', 0, 0),
(1267, 127, '', 'জিরতলী', 0, 0),
(1268, 127, '', 'কুতবপুর', 0, 0),
(1269, 127, '', 'আলাইয়ারপুর', 0, 0),
(1270, 127, '', 'ছয়ানী', 0, 0),
(1271, 127, '', 'রাজগঞ্জ', 0, 0),
(1272, 127, '', 'একলাশপুর', 0, 0),
(1273, 127, '', 'বেগমগঞ্জ', 0, 0),
(1274, 127, '', 'মিরওয়ারিশপুর', 0, 0),
(1275, 127, '', 'নরোত্তমপুর', 0, 0),
(1276, 127, '', 'দূর্গাপুর', 0, 0),
(1277, 127, '', 'রসুলপুর', 0, 0),
(1278, 127, '', 'হাজীপুর', 0, 0),
(1279, 127, '', 'শরীফপুর', 0, 0),
(1280, 127, '', 'কাদিরপুর', 0, 0),
(1281, 131, '', 'সুখচর', 0, 0),
(1282, 131, '', 'নলচিরা', 0, 0),
(1283, 131, '', 'চরঈশ্বর', 0, 0),
(1284, 131, '', 'চরকিং', 0, 0),
(1285, 131, '', 'তমরদ্দি', 0, 0),
(1286, 131, '', 'সোনাদিয়া', 0, 0),
(1287, 131, '', 'বুড়িরচর', 0, 0),
(1288, 131, '', 'জাহাজমারা', 0, 0),
(1289, 131, '', 'নিঝুমদ্বীপ', 0, 0),
(1290, 134, '', 'চরজাব্বার', 0, 0),
(1291, 134, '', 'চরবাটা', 0, 0),
(1292, 134, '', 'চরক্লার্ক', 0, 0),
(1293, 134, '', 'চরওয়াপদা', 0, 0),
(1294, 134, '', 'চরজুবলী', 0, 0),
(1295, 134, '', 'চরআমান', 0, 0),
(1296, 134, '', 'পূর্ব চরবাটা', 0, 0),
(1297, 134, '', 'মোহাম্মদপুর', 0, 0),
(1298, 132, '', 'নরোত্তমপুর', 0, 0),
(1299, 132, '', 'ধানসিঁড়ি', 0, 0),
(1300, 132, '', 'সুন্দলপুর', 0, 0),
(1301, 132, '', 'ঘোষবাগ', 0, 0),
(1302, 132, '', 'চাপরাশিরহাট', 0, 0),
(1303, 132, '', 'ধানশালিক', 0, 0),
(1304, 132, '', 'বাটইয়া', 0, 0),
(1305, 130, '', 'ছাতারপাইয়া', 0, 0),
(1306, 130, '', 'কেশরপাড়া', 0, 0),
(1307, 130, '', 'ডুমুরুয়া', 0, 0),
(1308, 130, '', 'কাদরা', 0, 0),
(1309, 130, '', 'অর্জুনতলা', 0, 0),
(1310, 130, '', 'কাবিলপুর', 0, 0),
(1311, 130, '', 'মোহাম্মদপুর', 0, 0),
(1312, 130, '', 'নবীপুর', 0, 0),
(1313, 130, '', 'বিজবাগ', 0, 0),
(1314, 128, '', 'সাহাপুর', 0, 0),
(1315, 128, '', 'রামনারায়নপুর', 0, 0),
(1316, 128, '', 'পরকোট', 0, 0),
(1317, 128, '', 'বাদলকোট', 0, 0),
(1318, 128, '', 'পাঁচগাঁও', 0, 0),
(1319, 128, '', 'হাট-পুকুরিয়া', 0, 0),
(1320, 128, '', 'নোয়াখলা', 0, 0),
(1321, 128, '', 'খিলপাড়া', 0, 0),
(1322, 128, '', 'মোহাম্মদপুর', 0, 0),
(1323, 133, '', 'জয়াগ', 0, 0),
(1324, 133, '', 'নদনা', 0, 0),
(1325, 133, '', 'চাষীরহাট', 0, 0),
(1326, 133, '', 'বারগাঁও', 0, 0),
(1327, 133, '', 'অম্বরনগর', 0, 0),
(1328, 133, '', 'নাটেশ্বর', 0, 0),
(1329, 133, '', 'বজরা', 0, 0),
(1330, 133, '', 'সোনাপুর', 0, 0),
(1331, 133, '', 'দেওটি', 0, 0),
(1332, 133, '', 'আমিশাপাড়া', 0, 0),
(1333, 62, '', 'গাজীপুর', 0, 0),
(1334, 62, '', 'আলগী দুর্গাপুর', 0, 0),
(1335, 62, '', 'আলগী দুর্গাপুরদক্ষিণ', 0, 0),
(1336, 62, '', 'নীলকমল', 0, 0),
(1337, 62, '', 'হাইমচর', 0, 0),
(1338, 64, '', 'পাথৈর', 0, 0),
(1339, 64, '', 'বিতারা', 0, 0),
(1340, 64, '', 'সহদেবপুর', 0, 0),
(1341, 64, '', 'সহদেবপুর', 0, 0),
(1342, 64, '', 'কচুয়া', 0, 0),
(1343, 64, '', 'কচুয়া', 0, 0),
(1344, 64, '', 'গোহাট', 0, 0),
(1345, 64, '', 'গোহাট', 0, 0),
(1346, 64, '', 'সাচার', 0, 0),
(1347, 67, '', 'টামটা দক্ষিণ', 0, 0),
(1348, 67, '', 'টামটা উত্তর', 0, 0),
(1349, 67, '', 'মেহের', 0, 0),
(1350, 67, '', 'মেহের', 0, 0),
(1351, 67, '', 'সুচিপাড়া', 0, 0),
(1352, 67, '', 'সুচিপাড়া', 0, 0),
(1353, 67, '', 'চিতষী', 0, 0),
(1354, 67, '', 'রায়শ্রী', 0, 0),
(1355, 67, '', 'রায়শ্রী', 0, 0),
(1356, 67, '', 'চিতষী', 0, 0),
(1357, 60, '', 'বিষ্ণপুর', 0, 0),
(1358, 60, '', 'আশিকাটি', 0, 0),
(1359, 60, '', 'শাহ্‌', 0, 0),
(1360, 60, '', 'কল্যাণপুর', 0, 0),
(1361, 60, '', 'রামপুর', 0, 0),
(1362, 60, '', 'মৈশাদী', 0, 0),
(1363, 60, '', 'তরপুচন্ডী', 0, 0),
(1364, 60, '', 'বাগাদী', 0, 0),
(1365, 60, '', 'লক্ষীপুর মডেল', 0, 0),
(1366, 60, '', 'হানারচর', 0, 0),
(1367, 60, '', 'চান্দ্রা', 0, 0),
(1368, 60, '', 'রাজরাজেশ্বর', 0, 0),
(1369, 60, '', 'ইব্রাহীমপুর', 0, 0),
(1370, 60, '', 'বালিয়া', 0, 0),
(1371, 66, '', 'নায়েরগাঁও উত্তর', 0, 0),
(1372, 66, '', 'নায়েরগাঁও দক্ষিন', 0, 0),
(1373, 66, '', 'খাদেরগাঁও', 0, 0),
(1374, 66, '', 'নারায়নপুর', 0, 0),
(1375, 66, '', 'উপাদী', 0, 0),
(1376, 66, '', 'উপাদী', 0, 0),
(1377, 63, '', 'রাজারগাঁও', 0, 0),
(1378, 63, '', 'বাকিলা', 0, 0),
(1379, 63, '', 'কালচোঁ উত্তর', 0, 0),
(1380, 63, '', 'হাজীগঞ্জ সদর', 0, 0),
(1381, 63, '', 'কালচোঁ', 0, 0),
(1382, 63, '', 'বড়কুল', 0, 0),
(1383, 63, '', 'বড়কুল', 0, 0),
(1384, 63, '', 'হাটিলা', 0, 0),
(1385, 63, '', 'হাটিলা', 0, 0),
(1386, 63, '', 'গন্ধর্ব্যপুর', 0, 0),
(1387, 63, '', 'গন্ধর্ব্যপুর', 0, 0),
(1388, 65, '', 'ফতেহপুর', 0, 0),
(1389, 65, '', 'ফতেহপুর', 0, 0),
(1390, 61, '', 'বালিথুবা পশ্চিম ইউনিয়ন', 0, 0),
(1391, 61, '', 'বালিথুবা পূর্ব ইউনিয়ন', 0, 0),
(1392, 61, '', 'সুবিদপুর', 0, 0),
(1393, 61, '', 'সুবিদপুর', 0, 0),
(1394, 61, '', 'গুপ্তি', 0, 0),
(1395, 61, '', 'গুপ্তি', 0, 0),
(1396, 61, '', 'পাইকপাড়া', 0, 0),
(1397, 61, '', 'পাইকপাড়া', 0, 0),
(1398, 61, '', 'গবিন্দপুর', 0, 0),
(1399, 61, '', 'গবিন্দপুর', 0, 0),
(1400, 61, '', 'চরদুখিয়া', 0, 0),
(1401, 61, '', 'চরদুঃখিয়া', 0, 0),
(1402, 61, '', 'ফরিদ্গঞ্জ দক্ষিণ', 0, 0),
(1403, 61, '', 'রুপসা', 0, 0),
(1404, 61, '', 'রুপসা', 0, 0),
(1405, 121, '', 'উত্তর হামছাদী', 0, 0),
(1406, 121, '', 'দক্ষিন হামছাদী', 0, 0),
(1407, 121, '', 'দালাল বাজার', 0, 0),
(1408, 121, '', 'চররুহিতা', 0, 0),
(1409, 121, '', 'পার্বতীনগর', 0, 0),
(1410, 121, '', 'বাঙ্গাখাঁ', 0, 0),
(1411, 121, '', 'দত্তপাড়া', 0, 0),
(1412, 121, '', 'বশিকপুর', 0, 0),
(1413, 121, '', 'চন্দ্রগঞ্জ', 0, 0),
(1414, 121, '', 'উত্তর জয়পুর', 0, 0),
(1415, 121, '', 'হাজিরপাড়া', 0, 0),
(1416, 121, '', 'চরশাহী', 0, 0),
(1417, 121, '', 'দিঘলী', 0, 0),
(1418, 121, '', 'লাহারকান্দি', 0, 0),
(1419, 121, '', 'ভবানীগঞ্জ', 0, 0),
(1420, 121, '', 'কুশাখালী', 0, 0),
(1421, 121, '', 'শাকচর', 0, 0),
(1422, 121, '', 'তেয়ারীগঞ্জ', 0, 0),
(1423, 121, '', 'টুমচর', 0, 0),
(1424, 121, '', 'চররমনী মোহন', 0, 0),
(1425, 125, '', 'চর কালকিনি', 0, 0),
(1426, 125, '', 'সাহেবেরহাট', 0, 0),
(1427, 125, '', 'চর মার্টিন', 0, 0),
(1428, 125, '', 'চর ফলকন', 0, 0),
(1429, 125, '', 'পাটারীরহাট', 0, 0),
(1430, 125, '', 'হাজিরহাট', 0, 0),
(1431, 125, '', 'চর কাদিরা', 0, 0),
(1432, 125, '', 'তোরাবগঞ্জ', 0, 0),
(1433, 125, '', 'চর লরেঞ্চ', 0, 0),
(1434, 122, '', 'উত্তর চর আবাবিল', 0, 0),
(1435, 122, '', 'উত্তর চর বংশী', 0, 0),
(1436, 122, '', 'চর মোহনা', 0, 0),
(1437, 122, '', 'সোনাপুর', 0, 0),
(1438, 122, '', 'চর পাতা', 0, 0),
(1439, 122, '', 'বামনী', 0, 0),
(1440, 122, '', 'দক্ষিন চর বংশী', 0, 0),
(1441, 122, '', 'দক্ষিন চর আবাবিল', 0, 0),
(1442, 122, '', 'রায়পুর', 0, 0),
(1443, 122, '', 'কেরোয়া', 0, 0),
(1444, 124, '', 'চর পোড়াগাছা', 0, 0),
(1445, 124, '', 'চর বাদাম', 0, 0),
(1446, 124, '', 'চর আবদুল্যাহ', 0, 0),
(1447, 124, '', 'আলেকজান্ডার', 0, 0),
(1448, 124, '', 'চর আলগী', 0, 0),
(1449, 124, '', 'চর রমিজ', 0, 0),
(1450, 124, '', 'বড়খেড়ী', 0, 0),
(1451, 124, '', 'চরগাজী', 0, 0),
(1452, 123, '', 'কাঞ্চনপুর', 0, 0),
(1453, 123, '', 'নোয়াগাঁও ইউনিয়ন', 0, 0),
(1454, 123, '', 'ভাদুর', 0, 0),
(1455, 123, '', 'ইছাপুর', 0, 0),
(1456, 123, '', 'চন্ডিপুর', 0, 0),
(1457, 123, '', 'লামচর', 0, 0),
(1458, 123, '', 'দরবেশপুর', 0, 0),
(1459, 123, '', 'করপাড়া', 0, 0),
(1460, 123, '', 'ভোলাকোট', 0, 0),
(1461, 123, '', 'ভাটরা', 0, 0),
(1462, 77, '', 'রাজানগর', 0, 0),
(1463, 77, '', 'হোছনাবাদ', 0, 0),
(1464, 77, '', 'স্বনির্ভর রাঙ্গুনিয়া', 0, 0),
(1465, 77, '', 'মরিয়মনগর', 0, 0),
(1466, 77, '', 'পারুয়া', 0, 0),
(1467, 77, '', 'পোমরা', 0, 0),
(1468, 77, '', 'বেতাগী', 0, 0),
(1469, 77, '', 'সরফভাটা', 0, 0),
(1470, 77, '', 'শিলক', 0, 0),
(1471, 77, '', 'চন্দ্রঘোনা', 0, 0),
(1472, 77, '', 'কোদালা', 0, 0),
(1473, 77, '', 'ইসলামপুর', 0, 0),
(1474, 77, '', 'দক্ষিণ রাজানগর ইউনিয়ন', 0, 0),
(1475, 77, '', 'লালানগর', 0, 0),
(1476, 81, '', 'কুমিরা', 0, 0),
(1477, 81, '', 'বাঁশবারীয়া', 0, 0),
(1478, 81, '', 'বারবকুন্ড', 0, 0),
(1479, 81, '', 'বাড়িয়াডিয়ালা', 0, 0),
(1480, 81, '', 'মুরাদপুর', 0, 0),
(1481, 81, '', 'সাঈদপুর', 0, 0);
INSERT INTO `unions` (`id`, `upazila_id`, `name`, `bn_name`, `lat`, `lon`) VALUES
(1482, 81, '', 'সালিমপুর', 0, 0),
(1483, 81, '', 'সোনাইছড়ি', 0, 0),
(1484, 81, '', 'ভাটিয়ারী', 0, 0),
(1485, 75, '', 'করেরহাট', 0, 0),
(1486, 75, '', 'হিংগুলি', 0, 0),
(1487, 75, '', 'জোরারগঞ্জ', 0, 0),
(1488, 75, '', 'ধুম', 0, 0),
(1489, 75, '', 'ওসমানপুর', 0, 0),
(1490, 75, '', 'ইছাখালী', 0, 0),
(1491, 75, '', 'কাটাছরা', 0, 0),
(1492, 75, '', 'দূর্গাপুর', 0, 0),
(1493, 75, '', 'মীরসরাই', 0, 0),
(1494, 75, '', 'মিঠানালা', 0, 0),
(1495, 75, '', 'মঘাদিয়া', 0, 0),
(1496, 75, '', 'খৈয়াছরা', 0, 0),
(1497, 75, '', 'মায়ানী', 0, 0),
(1498, 75, '', 'হাইতকান্দি', 0, 0),
(1499, 75, '', 'ওয়াহেদপুর', 0, 0),
(1500, 75, '', 'সাহেরখালী', 0, 0),
(1501, 76, '', 'আশিয়া', 0, 0),
(1502, 76, '', 'কাচুয়াই', 0, 0),
(1503, 76, '', 'কাশিয়াইশ', 0, 0),
(1504, 76, '', 'কুসুমপুরা', 0, 0),
(1505, 76, '', 'কেলিশহর', 0, 0),
(1506, 76, '', 'কোলাগাঁও', 0, 0),
(1507, 76, '', 'খরনা', 0, 0),
(1508, 76, '', 'চরপাথরঘাটা', 0, 0),
(1509, 76, '', 'চরলক্ষ্যা', 0, 0),
(1510, 76, '', 'ছনহরা', 0, 0),
(1511, 76, '', 'জঙ্গলখাইন', 0, 0),
(1512, 76, '', 'জিরি', 0, 0),
(1513, 76, '', 'জুলধা', 0, 0),
(1514, 76, '', 'দক্ষিণ ভূর্ষি', 0, 0),
(1515, 76, '', 'ধলঘাট', 0, 0),
(1516, 76, '', 'বড় উঠান', 0, 0),
(1517, 76, '', 'বরলিয়া', 0, 0),
(1518, 76, '', 'ভাটিখাইন', 0, 0),
(1519, 76, '', 'শিকলবাহা', 0, 0),
(1520, 76, '', 'শোভনদন্ডী', 0, 0),
(1521, 76, '', 'হাবিলাসদ্বীপ', 0, 0),
(1522, 76, '', 'হাইদগাঁও', 0, 0),
(1523, 79, '', 'রহমতপুর ইউনিয়ন', 0, 0),
(1524, 79, '', 'হরিশপুর', 0, 0),
(1525, 79, '', 'কালাপানিয়া', 0, 0),
(1526, 79, '', 'আমানউল্যা', 0, 0),
(1527, 79, '', 'সন্তোষপুর', 0, 0),
(1528, 79, '', 'গাছুয়া', 0, 0),
(1529, 79, '', 'বাউরিয়া', 0, 0),
(1530, 79, '', 'হারামিয়া', 0, 0),
(1531, 79, '', 'মগধরা', 0, 0),
(1532, 79, '', 'মাইটভাঙ্গা', 0, 0),
(1533, 79, '', 'সারিকাইত', 0, 0),
(1534, 79, '', 'মুছাপুর', 0, 0),
(1535, 79, '', 'আজিমপুর', 0, 0),
(1536, 79, '', 'উড়িরচর', 0, 0),
(1537, 69, '', 'পুকুরিয়া', 0, 0),
(1538, 69, '', 'সাধনপুর', 0, 0),
(1539, 69, '', 'খানখানাবাদ', 0, 0),
(1540, 69, '', 'বাহারছড়া', 0, 0),
(1541, 69, '', 'কালীপুর', 0, 0),
(1542, 69, '', 'বৈলছড়ি', 0, 0),
(1543, 69, '', 'কাথরিয়া', 0, 0),
(1544, 69, '', 'সরল', 0, 0),
(1545, 69, '', 'শীলকুপ', 0, 0),
(1546, 69, '', 'চাম্বল', 0, 0),
(1547, 69, '', 'গন্ডামারা', 0, 0),
(1548, 69, '', 'শেখেরখীল', 0, 0),
(1549, 69, '', 'পুঁইছড়ি', 0, 0),
(1550, 69, '', 'ছনুয়া', 0, 0),
(1551, 70, '', 'কধুরখীল', 0, 0),
(1552, 70, '', 'পশ্চিম গোমদন্ডী', 0, 0),
(1553, 70, '', 'পুর্ব গোমদন্ডী', 0, 0),
(1554, 70, '', 'শাকপুরা ইউনিয়ন', 0, 0),
(1555, 70, '', 'সারোয়াতলী', 0, 0),
(1556, 70, '', 'পোপাদিয়া ইউনিয়ন', 0, 0),
(1557, 70, '', 'চরনদ্বীপ', 0, 0),
(1558, 70, '', 'শ্রীপুর-খরন্দীপ', 0, 0),
(1559, 70, '', 'আমুচিয়া ইউনিয়ন', 0, 0),
(1560, 70, '', 'আহল্লা করলডেঙ্গা', 0, 0),
(1561, 68, '', 'বৈরাগ', 0, 0),
(1562, 68, '', 'বারশত', 0, 0),
(1563, 68, '', 'রায়পুর', 0, 0),
(1564, 68, '', 'বটতলী', 0, 0),
(1565, 68, '', 'বরম্নমচড়া', 0, 0),
(1566, 68, '', 'বারখাইন', 0, 0),
(1567, 68, '', 'আনোয়ারা', 0, 0),
(1568, 68, '', 'চাতরী', 0, 0),
(1569, 68, '', 'পরৈকোড়া', 0, 0),
(1570, 68, '', 'হাইলধর', 0, 0),
(1571, 68, '', 'জুঁইদন্ডী', 0, 0),
(1572, 71, '', 'কাঞ্চনাবাদ', 0, 0),
(1573, 71, '', 'জোয়ারা', 0, 0),
(1574, 71, '', 'বরকল', 0, 0),
(1575, 71, '', 'বরমা', 0, 0),
(1576, 71, '', 'বৈলতলী', 0, 0),
(1577, 71, '', 'সাতবাড়িয়া', 0, 0),
(1578, 71, '', 'হাশিমপুর', 0, 0),
(1579, 71, '', 'দোহাজারী', 0, 0),
(1580, 71, '', 'ধোপাছড়ী', 0, 0),
(1581, 80, '', 'চরতী', 0, 0),
(1582, 80, '', 'খাগরিয়া', 0, 0),
(1583, 80, '', 'নলুয়া', 0, 0),
(1584, 80, '', 'কাঞ্চনা', 0, 0),
(1585, 80, '', 'আমিলাইশ', 0, 0),
(1586, 80, '', 'এওচিয়া', 0, 0),
(1587, 80, '', 'মাদার্শা', 0, 0),
(1588, 80, '', 'ঢেমশা', 0, 0),
(1589, 80, '', 'পশ্চিম ঢেমশা', 0, 0),
(1590, 80, '', 'কেঁওচিয়া', 0, 0),
(1591, 80, '', 'কালিয়াইশ', 0, 0),
(1592, 80, '', 'বাজালিয়া', 0, 0),
(1593, 80, '', 'পুরানগড়', 0, 0),
(1594, 80, '', 'ছদাহা', 0, 0),
(1595, 80, '', 'সাতকানিয়া', 0, 0),
(1596, 80, '', 'সোনাকানিয়া', 0, 0),
(1597, 74, '', 'পদুয়া', 0, 0),
(1598, 74, '', 'বড়হাতিয়া', 0, 0),
(1599, 74, '', 'আমিরাবাদ', 0, 0),
(1600, 74, '', 'চরম্বা', 0, 0),
(1601, 74, '', 'কলাউজান', 0, 0),
(1602, 74, '', 'লোহাগাড়া', 0, 0),
(1603, 74, '', 'পুটিবিলা', 0, 0),
(1604, 74, '', 'চুনতি', 0, 0),
(1605, 74, '', 'আধুনগর', 0, 0),
(1606, 73, '', 'ফরহাদাবাদ', 0, 0),
(1607, 73, '', 'ধলই', 0, 0),
(1608, 73, '', 'মির্জাপুর', 0, 0),
(1609, 73, '', 'নাঙ্গলমোরা', 0, 0),
(1610, 73, '', 'গুমানমর্দ্দন', 0, 0),
(1611, 73, '', 'ছিপাতলী', 0, 0),
(1612, 73, '', 'মেখল', 0, 0),
(1613, 73, '', 'গড়দুয়ারা', 0, 0),
(1614, 73, '', 'ফতেপুর', 0, 0),
(1615, 73, '', 'চিকনদন্ডী', 0, 0),
(1616, 73, '', 'উত্তর মাদার্শা', 0, 0),
(1617, 73, '', 'দক্ষিন মাদার্শা', 0, 0),
(1618, 73, '', 'শিকারপুর', 0, 0),
(1619, 73, '', 'বুডিরশ্চর', 0, 0),
(1620, 73, '', 'হাটহাজারী', 0, 0),
(1621, 72, '', 'ধর্মপুর', 0, 0),
(1622, 72, '', 'বাগান বাজার', 0, 0),
(1623, 72, '', 'দাঁতমারা', 0, 0),
(1624, 72, '', 'নারায়নহাট ইউনিয়ন', 0, 0),
(1625, 72, '', 'ভূজপুর ইউনিয়ন', 0, 0),
(1626, 72, '', 'হারুয়ালছড়ি ইউনিয়ন', 0, 0),
(1627, 72, '', 'পাইনদং ইউনিয়ন', 0, 0),
(1628, 72, '', 'কাঞ্চনগর ইউনিয়ন', 0, 0),
(1629, 72, '', 'সুনদরপুর ইউনিয়ন', 0, 0),
(1630, 72, '', 'সুয়াবিল ইউনিয়ন', 0, 0),
(1631, 72, '', 'আবদুল্লাপুর ইউনিয়ন', 0, 0),
(1632, 72, '', 'সমিতির হাট ইউনিয়ন', 0, 0),
(1633, 72, '', 'জাফতনগর ইউনিয়ন', 0, 0),
(1634, 72, '', 'বক্তপুর ইউনিয়ন', 0, 0),
(1635, 72, '', 'রোসাংগিরী ইউনিয়ন', 0, 0),
(1636, 72, '', 'নানুপুর ইউনিয়ন', 0, 0),
(1637, 72, '', 'লেলাং ইউনিয়ন', 0, 0),
(1638, 72, '', 'দৌলতপুর ইউনিয়ন', 0, 0),
(1639, 78, '', 'রাউজান', 0, 0),
(1640, 78, '', 'বাগোয়ান', 0, 0),
(1641, 78, '', 'বিনাজুরী', 0, 0),
(1642, 78, '', 'চিকদাইর', 0, 0),
(1643, 78, '', 'ডাবুয়া', 0, 0),
(1644, 78, '', 'পূর্ব গুজরা', 0, 0),
(1645, 78, '', 'পশ্চিম গুজরা', 0, 0),
(1646, 78, '', 'গহিরা', 0, 0),
(1647, 78, '', 'হলদিয়া', 0, 0),
(1648, 78, '', 'কদলপূর', 0, 0),
(1649, 78, '', 'নোয়াপাড়া', 0, 0),
(1650, 78, '', 'পাহাড়তলী', 0, 0),
(1651, 78, '', 'উড়কিরচর', 0, 0),
(1652, 78, '', 'নওয়াজিশপুর', 0, 0),
(1653, 100, '', 'ইসলামাবাদ', 0, 0),
(1654, 100, '', 'ইসলামপুর', 0, 0),
(1655, 100, '', 'পোকখালী', 0, 0),
(1656, 100, '', 'ঈদগাঁও', 0, 0),
(1657, 100, '', 'জালালাবাদ', 0, 0),
(1658, 100, '', 'চৌফলদন্ডী', 0, 0),
(1659, 100, '', 'ভারুয়াখালী', 0, 0),
(1660, 100, '', 'পিএমখালী', 0, 0),
(1661, 100, '', 'খুরুশকুল', 0, 0),
(1662, 100, '', 'ঝিলংঝা', 0, 0),
(1663, 98, '', 'কাকারা', 0, 0),
(1664, 98, '', 'কাইয়ার বিল', 0, 0),
(1665, 98, '', 'কোনাখালী', 0, 0),
(1666, 98, '', 'খুটাখালী', 0, 0),
(1667, 98, '', 'চিরিঙ্গা', 0, 0),
(1668, 98, '', 'ঢেমুশিয়া', 0, 0),
(1669, 98, '', 'ডুলাহাজারা', 0, 0),
(1670, 98, '', 'পশ্চিম বড় ভেওলা', 0, 0),
(1671, 98, '', 'বদরখালী', 0, 0),
(1672, 98, '', 'বামু বিলছড়ি', 0, 0),
(1673, 98, '', 'বড়ইতলী', 0, 0),
(1674, 98, '', 'ভেওলা মানিকচর', 0, 0),
(1675, 98, '', 'শাহারবিল', 0, 0),
(1676, 98, '', 'সুরজপুর মানিকপুর', 0, 0),
(1677, 98, '', 'হারবাঙ্গ', 0, 0),
(1678, 98, '', 'ফাঁসিয়াখালী', 0, 0),
(1679, 101, '', 'আলি আকবর ডেইল', 0, 0),
(1680, 101, '', 'উত্তর ধুরুং', 0, 0),
(1681, 101, '', 'কৈয়ারবিল', 0, 0),
(1682, 101, '', 'দক্ষিণ ধুরুং', 0, 0),
(1683, 101, '', 'বড়ঘোপ', 0, 0),
(1684, 101, '', 'লেমসিখালী', 0, 0),
(1685, 105, '', 'রাজাপালং', 0, 0),
(1686, 105, '', 'জালিয়াপালং', 0, 0),
(1687, 105, '', 'হলদিয়াপালং', 0, 0),
(1688, 105, '', 'রত্নাপালং', 0, 0),
(1689, 105, '', 'পালংখালী', 0, 0),
(1690, 102, '', 'বড় মহেশখালী', 0, 0),
(1691, 102, '', 'ছোট মহেশখালী', 0, 0),
(1692, 102, '', 'শাপলাপুর', 0, 0),
(1693, 102, '', 'কুতুবজোম', 0, 0),
(1694, 102, '', 'হোয়ানক', 0, 0),
(1695, 102, '', 'কালারমারছড়া', 0, 0),
(1696, 102, '', 'মাতারবাড়ী', 0, 0),
(1697, 102, '', 'ধলঘাটা', 0, 0),
(1698, 106, '', 'উজানটিয়া', 0, 0),
(1699, 106, '', 'টাইটং', 0, 0),
(1700, 106, '', 'পেকুয়া', 0, 0),
(1701, 106, '', 'বড় বাকিয়া', 0, 0),
(1702, 106, '', 'মগনামা', 0, 0),
(1703, 106, '', 'রাজাখালী', 0, 0),
(1704, 106, '', 'শীলখালী', 0, 0),
(1705, 103, '', 'ফতেখাঁরকুল', 0, 0),
(1706, 103, '', 'রাজারকুল', 0, 0),
(1707, 103, '', 'রশীদনগর', 0, 0),
(1708, 103, '', 'খুনিয়াপালং', 0, 0),
(1709, 103, '', 'ঈদগড়', 0, 0),
(1710, 103, '', 'চাকমারকুল', 0, 0),
(1711, 103, '', 'কচ্ছপিয়া', 0, 0),
(1712, 103, '', 'কাউয়ারখোপ', 0, 0),
(1713, 103, '', 'দক্ষিণ মিঠাছড়ি', 0, 0),
(1714, 103, '', 'জোয়ারিয়া নালা', 0, 0),
(1715, 103, '', 'গর্জনিয়া', 0, 0),
(1716, 104, '', 'সাবরাং', 0, 0),
(1717, 104, '', 'বাহারছড়া', 0, 0),
(1718, 104, '', 'হ্নীলা', 0, 0),
(1719, 104, '', 'হোয়াইক্যং', 0, 0),
(1720, 104, '', 'সেন্ট মার্টিন', 0, 0),
(1721, 104, '', 'টেকনাফ সদর', 0, 0),
(1722, 114, '', 'খাগরাছড়ি সদর', 0, 0),
(1723, 114, '', 'গোলাবাড়ী', 0, 0),
(1724, 114, '', 'পেরাছড়া', 0, 0),
(1725, 114, '', 'কমলছড়ি', 0, 0),
(1726, 113, '', 'মেরুং', 0, 0),
(1727, 113, '', 'বোয়ালখালী', 0, 0),
(1728, 113, '', 'কবাখালী', 0, 0),
(1729, 113, '', 'দিঘীনালা', 0, 0),
(1730, 113, '', 'বাবুছড়া', 0, 0),
(1731, 119, '', 'লোগাং', 0, 0),
(1732, 119, '', 'চেংগী', 0, 0),
(1733, 119, '', 'পানছড়ি', 0, 0),
(1734, 119, '', 'লতিবান', 0, 0),
(1735, 115, '', 'দুল্যাতলী', 0, 0),
(1736, 115, '', 'বর্মাছড়ি', 0, 0),
(1737, 115, '', 'লক্ষীছড়ি', 0, 0),
(1738, 116, '', 'ভাইবোনছড়া', 0, 0),
(1739, 116, '', 'মহালছড়ি', 0, 0),
(1740, 116, '', 'মুবাছড়ি', 0, 0),
(1741, 116, '', 'ক্যায়াংঘাট', 0, 0),
(1742, 116, '', 'মাইসছড়ি', 0, 0),
(1743, 117, '', 'মানিকছড়ি', 0, 0),
(1744, 117, '', 'বাটনাতলী', 0, 0),
(1745, 117, '', 'যোগ্যছোলা', 0, 0),
(1746, 117, '', 'তিনটহরী', 0, 0),
(1747, 120, '', 'রামগড়', 0, 0),
(1748, 120, '', 'পাতাছড়া', 0, 0),
(1749, 120, '', 'হাফছড়ি', 0, 0),
(1750, 118, '', 'তাইন্দং', 0, 0),
(1751, 118, '', 'তবলছড়ি', 0, 0),
(1752, 118, '', 'বর্ণাল', 0, 0),
(1753, 118, '', 'গোমতি', 0, 0),
(1754, 118, '', 'বেলছড়ি', 0, 0),
(1755, 118, '', 'মাটিরাঙ্গা', 0, 0),
(1756, 118, '', 'গুইমারা', 0, 0),
(1757, 118, '', 'আমতলি', 0, 0),
(1758, 43, '', 'রাজবিলা', 0, 0),
(1759, 43, '', 'টংকাবতী ইউনিয়ন', 0, 0),
(1760, 43, '', 'সুয়ালক ইউনিয়ন', 0, 0),
(1761, 43, '', 'বান্দরবান সদর', 0, 0),
(1762, 43, '', 'কুহালং', 0, 0),
(1763, 47, '', 'আলীকদম সদর ইউনিয়ন', 0, 0),
(1764, 47, '', 'চৈক্ষ্যং ইউনিয়ন', 0, 0),
(1765, 46, '', 'নাইক্ষ্যংছড়ি সদর ইউনিয়ন', 0, 0),
(1766, 46, '', 'ঘুমধুম ইউনিয়ন', 0, 0),
(1767, 46, '', 'বাইশারী', 0, 0),
(1768, 46, '', 'সোনাইছড়ি', 0, 0),
(1769, 46, '', 'দোছড়ি', 0, 0),
(1770, 48, '', 'রোয়াংছড়ি সদর', 0, 0),
(1771, 48, '', 'তারাছা', 0, 0),
(1772, 48, '', 'আলেক্ষ্যং', 0, 0),
(1773, 48, '', 'নোয়াপতং', 0, 0),
(1774, 45, '', 'গজালিয়া', 0, 0),
(1775, 45, '', 'লামা সদর', 0, 0),
(1776, 45, '', 'ফাসিয়াখালী', 0, 0),
(1777, 45, '', 'ফাইতং', 0, 0),
(1778, 45, '', 'রূপসীপাড়া', 0, 0),
(1779, 45, '', 'সরই ইউনিয়ন', 0, 0),
(1780, 45, '', 'আজিজনগর ইউনিয়ন', 0, 0),
(1781, 49, '', 'পাইন্দু ইউনিয়ন', 0, 0),
(1782, 49, '', 'রুমা সদর ইউনিয়ন', 0, 0),
(1783, 49, '', 'রেমাক্রীপ্রাংসা ইউনিয়ন', 0, 0),
(1784, 49, '', 'গ্যালেংগ্যা ইউনিয়ন', 0, 0),
(1785, 44, '', 'রেমাক্রী ইউনিয়ন', 0, 0),
(1786, 44, '', 'তিন্দু ইউনিয়ন', 0, 0),
(1787, 44, '', 'থানচি সদর ইউনিয়ন', 0, 0),
(1788, 44, '', 'বলিপাড়া ইউনিয়ন', 0, 0),
(1789, 387, '', 'রাজাপুর', 0, 0),
(1790, 387, '', 'বড়ধুল', 0, 0),
(1791, 387, '', 'বেলকুচি সদর', 0, 0),
(1792, 387, '', 'ধুকুরিয়া বেড়া', 0, 0),
(1793, 387, '', 'দৌলতপুর', 0, 0),
(1794, 387, '', 'ভাঙ্গাবাড়ী', 0, 0),
(1795, 388, '', 'বাঘুটিয়া', 0, 0),
(1796, 388, '', 'ঘোরজান', 0, 0),
(1797, 388, '', 'খাসকাউলিয়া', 0, 0),
(1798, 388, '', 'খাসপুকুরিয়া', 0, 0),
(1799, 388, '', 'উমারপুর', 0, 0),
(1800, 388, '', 'সদিয়া চাঁদপুর', 0, 0),
(1801, 388, '', 'স্থল', 0, 0),
(1802, 389, '', 'ভদ্রঘাট', 0, 0),
(1803, 389, '', 'জামতৈল', 0, 0),
(1804, 389, '', 'ঝাঐল', 0, 0),
(1805, 389, '', 'রায়দৌলতপুর', 0, 0),
(1806, 390, '', 'চালিতাডাঙ্গা', 0, 0),
(1807, 390, '', 'চরগিরিশ', 0, 0),
(1808, 390, '', 'গান্ধাইল', 0, 0),
(1809, 390, '', 'কাজিপুর সদর', 0, 0),
(1810, 390, '', 'খাসরাজবাড়ী', 0, 0),
(1811, 390, '', 'মাইজবাড়ী', 0, 0),
(1812, 390, '', 'মনসুর নগর', 0, 0),
(1813, 390, '', 'নাটুয়ারপাড়া', 0, 0),
(1814, 390, '', 'নিশ্চিন্তপুর', 0, 0),
(1815, 390, '', 'সোনামুখী', 0, 0),
(1816, 390, '', 'শুভগাছা', 0, 0),
(1817, 390, '', 'তেকানী', 0, 0),
(1818, 391, '', 'ব্রহ্মগাছা', 0, 0),
(1819, 391, '', 'চান্দাইকোনা', 0, 0),
(1820, 391, '', 'ধামাইনগর', 0, 0),
(1821, 391, '', 'ধানগড়া', 0, 0),
(1822, 391, '', 'ধুবিল', 0, 0),
(1823, 391, '', 'ঘুড়কা', 0, 0),
(1824, 391, '', 'নলকা', 0, 0),
(1825, 391, '', 'পাঙ্গাসী', 0, 0),
(1826, 391, '', 'সোনাখাড়া', 0, 0),
(1827, 392, '', 'বেলতৈল', 0, 0),
(1828, 392, '', 'জালালপুর', 0, 0),
(1829, 392, '', 'কায়েমপুর', 0, 0),
(1830, 392, '', 'গাড়াদহ', 0, 0),
(1831, 392, '', 'পোতাজিয়া', 0, 0),
(1832, 392, '', 'রূপবাটি', 0, 0),
(1833, 392, '', 'গালা', 0, 0),
(1834, 392, '', 'পোরজনা', 0, 0),
(1835, 392, '', 'হাবিবুল্লাহ নগর', 0, 0),
(1836, 392, '', 'খুকনী', 0, 0),
(1837, 392, '', 'কৈজুরী', 0, 0),
(1838, 392, '', 'সোনাতনী', 0, 0),
(1839, 392, '', 'নরিনা', 0, 0),
(1840, 386, '', 'বাগবাটি', 0, 0),
(1841, 386, '', 'রতনকান্দি', 0, 0),
(1842, 386, '', 'বহুলী', 0, 0),
(1843, 386, '', 'শিয়ালকোল', 0, 0),
(1844, 386, '', 'খোকশাবাড়ী', 0, 0),
(1845, 386, '', 'ছোনগাছা', 0, 0),
(1846, 386, '', 'মেছড়া', 0, 0),
(1847, 386, '', 'কাওয়াখোলা', 0, 0),
(1848, 386, '', 'কালিয়াহরিপুর', 0, 0),
(1849, 386, '', 'সয়দাবাদ', 0, 0),
(1850, 393, '', 'বারুহাস', 0, 0),
(1851, 393, '', 'তালম', 0, 0),
(1852, 393, '', 'সগুনা', 0, 0),
(1853, 393, '', 'মাগুড়া বিনোদ', 0, 0),
(1854, 393, '', 'নওগাঁ', 0, 0),
(1855, 393, '', 'তাড়াশ সদর', 0, 0),
(1856, 393, '', 'মাধাইনগর', 0, 0),
(1857, 393, '', 'দেশীগ্রাম', 0, 0),
(1858, 394, '', 'উল্লাপাড়া সদর', 0, 0),
(1859, 394, '', 'রামকৃষ্ণপুর', 0, 0),
(1860, 394, '', 'বাঙ্গালা', 0, 0),
(1861, 394, '', 'উধুনিয়া', 0, 0),
(1862, 394, '', 'বড়পাঙ্গাসী', 0, 0),
(1863, 394, '', 'দুর্গা নগর', 0, 0),
(1864, 394, '', 'পূর্ণিমাগাতী', 0, 0),
(1865, 394, '', 'সলঙ্গা', 0, 0),
(1866, 394, '', 'হটিকুমরুল', 0, 0),
(1867, 394, '', 'বড়হর', 0, 0),
(1868, 394, '', 'পঞ্চক্রোশী', 0, 0),
(1869, 394, '', 'সলপ', 0, 0),
(1870, 394, '', 'মোহনপুর', 0, 0),
(1871, 376, '', 'ভায়না', 0, 0),
(1872, 376, '', 'তাঁতিবন্দ', 0, 0),
(1873, 376, '', 'মানিকহাট', 0, 0),
(1874, 376, '', 'দুলাই', 0, 0),
(1875, 376, '', 'আহম্মদপুর', 0, 0),
(1876, 376, '', 'রাণীনগর', 0, 0),
(1877, 376, '', 'সাতবাড়ীয়া', 0, 0),
(1878, 376, '', 'হাটখালী', 0, 0),
(1879, 376, '', 'নাজিরগঞ্জ', 0, 0),
(1880, 376, '', 'সাগরকান্দি', 0, 0),
(1881, 373, '', 'সাঁড়া', 0, 0),
(1882, 373, '', 'পাকশী', 0, 0),
(1883, 373, '', 'মুলাডুলি', 0, 0),
(1884, 373, '', 'দাশুরিয়া', 0, 0),
(1885, 373, '', 'ছলিমপুর', 0, 0),
(1886, 373, '', 'সাহাপুর', 0, 0),
(1887, 373, '', 'লক্ষীকুন্ডা', 0, 0),
(1888, 370, '', 'ভাঙ্গুড়া', 0, 0),
(1889, 370, '', 'খানমরিচ', 0, 0),
(1890, 370, '', 'অষ্টমণিষা', 0, 0),
(1891, 370, '', 'দিলপাশার', 0, 0),
(1892, 370, '', 'পারভাঙ্গুড়া', 0, 0),
(1893, 374, '', 'মালিগাছা', 0, 0),
(1894, 374, '', 'মালঞ্চি', 0, 0),
(1895, 374, '', 'গয়েশপুর', 0, 0),
(1896, 374, '', 'আতাইকুলা', 0, 0),
(1897, 374, '', 'চরতারাপুর', 0, 0),
(1898, 374, '', 'সাদুল্লাপুর', 0, 0),
(1899, 374, '', 'ভাঁড়ারা', 0, 0),
(1900, 374, '', 'দোগাছী', 0, 0),
(1901, 374, '', 'হেমায়েতপুর', 0, 0),
(1902, 374, '', 'দাপুনিয়া', 0, 0),
(1903, 369, '', 'হাটুরিয়া নাকালিয়া', 0, 0),
(1904, 369, '', 'নতুন ভারেঙ্গা', 0, 0),
(1905, 369, '', 'কৈটোলা', 0, 0),
(1906, 369, '', 'চাকলা', 0, 0),
(1907, 369, '', 'জাতসাখিনি', 0, 0),
(1908, 369, '', 'পুরান ভারেঙ্গা', 0, 0),
(1909, 369, '', 'রূপপুর', 0, 0),
(1910, 369, '', 'মাসুমদিয়া', 0, 0),
(1911, 369, '', 'ঢালার চর', 0, 0),
(1912, 368, '', 'মাজপাড়া', 0, 0),
(1913, 368, '', 'চাঁদভা', 0, 0),
(1914, 368, '', 'দেবোত্তর', 0, 0),
(1915, 368, '', 'একদন্ত', 0, 0),
(1916, 368, '', 'লক্ষীপুর', 0, 0),
(1917, 371, '', 'হান্ডিয়াল', 0, 0),
(1918, 371, '', 'ছাইকোলা', 0, 0),
(1919, 371, '', 'নিমাইচড়া', 0, 0),
(1920, 371, '', 'গুনাইগাছা', 0, 0),
(1921, 371, '', 'পার্শ্বডাঙ্গা', 0, 0),
(1922, 371, '', 'ফৈলজানা', 0, 0),
(1923, 371, '', 'মুলগ্রাম', 0, 0),
(1924, 371, '', 'হরিপুর', 0, 0),
(1925, 371, '', 'মথুরাপুর', 0, 0),
(1926, 371, '', 'বিলচলন', 0, 0),
(1927, 371, '', 'দাতিয়া বামনগ্রাম', 0, 0),
(1928, 375, '', 'নাগডেমড়া', 0, 0),
(1929, 375, '', 'ধুলাউড়ি', 0, 0),
(1930, 375, '', 'ভুলবাড়ীয়া', 0, 0),
(1931, 375, '', 'ধোপাদহ', 0, 0),
(1932, 375, '', 'করমজা', 0, 0),
(1933, 375, '', 'কাশিনাথপুর', 0, 0),
(1934, 375, '', 'গৌরীগ্রাম', 0, 0),
(1935, 375, '', 'নন্দনপুর', 0, 0),
(1936, 375, '', 'ক্ষেতুপাড়া', 0, 0),
(1937, 375, '', 'আর-আতাইকুলা', 0, 0),
(1938, 372, '', 'বৃলাহিড়ীবাড়ী', 0, 0),
(1939, 372, '', 'পুঙ্গুলি', 0, 0),
(1940, 372, '', 'ফরিদপুর', 0, 0),
(1941, 372, '', 'হাদল', 0, 0),
(1942, 372, '', 'বনওয়ারীনগর', 0, 0),
(1943, 372, '', 'ডেমড়া', 0, 0),
(1944, 335, '', 'বীরকেদার', 0, 0),
(1945, 335, '', 'কালাই', 0, 0),
(1946, 335, '', 'পাইকড়', 0, 0),
(1947, 335, '', 'নারহট্ট', 0, 0),
(1948, 335, '', 'মুরইল', 0, 0),
(1949, 335, '', 'কাহালু', 0, 0),
(1950, 335, '', 'দূর্গাপুর', 0, 0),
(1951, 335, '', 'জামগ্রাম', 0, 0),
(1952, 335, '', 'মালঞ্চা', 0, 0),
(1953, 330, '', 'ফাঁপোর', 0, 0),
(1954, 330, '', 'সাবগ্রাম', 0, 0),
(1955, 330, '', 'নিশিন্দারা', 0, 0),
(1956, 330, '', 'এরুলিয়া', 0, 0),
(1957, 330, '', 'রাজাপুর', 0, 0),
(1958, 330, '', 'শাখারিয়া', 0, 0),
(1959, 330, '', 'শেখেরকোলা', 0, 0),
(1960, 330, '', 'গোকুল', 0, 0),
(1961, 330, '', 'নুনগোলা', 0, 0),
(1962, 330, '', 'লাহিড়ীপাড়া', 0, 0),
(1963, 330, '', 'নামুজা', 0, 0),
(1964, 338, '', 'সারিয়াকান্দি সদর', 0, 0),
(1965, 338, '', 'নারচী', 0, 0),
(1966, 338, '', 'বোহাইল', 0, 0),
(1967, 338, '', 'চালুয়াবাড়ী', 0, 0),
(1968, 338, '', 'চন্দনবাইশা', 0, 0),
(1969, 338, '', 'হাটফুলবাড়ী', 0, 0),
(1970, 338, '', 'হাটশেরপুর', 0, 0),
(1971, 338, '', 'কর্ণিবাড়ী', 0, 0),
(1972, 338, '', 'কাজলা', 0, 0),
(1973, 338, '', 'কুতুবপুর', 0, 0),
(1974, 338, '', 'কামালপুর', 0, 0),
(1975, 338, '', 'ভেলাবাড়ী', 0, 0),
(1976, 337, '', 'আশেকপুর', 0, 0),
(1977, 337, '', 'মাদলা', 0, 0),
(1978, 337, '', 'মাঝিড়া', 0, 0),
(1979, 337, '', 'আড়িয়া', 0, 0),
(1980, 337, '', 'খরনা', 0, 0),
(1981, 337, '', 'খোট্টাপাড়া', 0, 0),
(1982, 337, '', 'চোপিনগর', 0, 0),
(1983, 337, '', 'আমরুল', 0, 0),
(1984, 337, '', 'গোহাইল', 0, 0),
(1985, 333, '', 'জিয়ানগর', 0, 0),
(1986, 333, '', 'চামরুল', 0, 0),
(1987, 333, '', 'দুপচাঁচিয়া', 0, 0),
(1988, 333, '', 'গুনাহার', 0, 0),
(1989, 333, '', 'গোবিন্দপুর', 0, 0),
(1990, 333, '', 'তালোড়া', 0, 0),
(1991, 329, '', 'ছাতিয়ানগ্রাম', 0, 0),
(1992, 329, '', 'নশরতপুর', 0, 0),
(1993, 329, '', 'আদমদিঘি', 0, 0),
(1994, 329, '', 'কুন্দগ্রাম', 0, 0),
(1995, 329, '', 'চাঁপাপুর', 0, 0),
(1996, 329, '', 'সান্তাহার', 0, 0),
(1997, 336, '', '১নং বুড়ইল', 0, 0),
(1998, 336, '', '২নং নন্দিগ্রাম', 0, 0),
(1999, 336, '', '৩নং ভাটরা', 0, 0),
(2000, 336, '', '৪নং থালতা মাঝগ্রাম', 0, 0),
(2001, 336, '', '৫নং ভাটগ্রাম', 0, 0),
(2002, 340, '', 'সোনাতলা', 0, 0),
(2003, 340, '', 'বালুয়া', 0, 0),
(2004, 340, '', 'জোড়গাছা', 0, 0),
(2005, 340, '', 'দিগদাইড়', 0, 0),
(2006, 340, '', 'মধুপুর', 0, 0),
(2007, 340, '', 'পাকুল্ল্যা', 0, 0),
(2008, 340, '', 'তেকানী চুকাইনগর', 0, 0),
(2009, 332, '', '১নং নিমগাছি', 0, 0),
(2010, 332, '', '২নং কালেরপাড়া', 0, 0),
(2011, 332, '', '৩নং চিকাশী', 0, 0),
(2012, 332, '', '৪নং গোসাইবাড়ী', 0, 0),
(2013, 332, '', '৫নং ভান্ডারবাড়ী', 0, 0),
(2014, 332, '', '১০নং গোপালনগর', 0, 0),
(2015, 332, '', '৯নং মথুরাপুর', 0, 0),
(2016, 332, '', '৮নং চৌকিবাড়ী', 0, 0),
(2017, 332, '', '৭নং এলাঙ্গী', 0, 0),
(2018, 332, '', '৬নং ধুনট সদর', 0, 0),
(2019, 334, '', 'বালিয়া দিঘী', 0, 0),
(2020, 334, '', 'দক্ষিণপাড়া', 0, 0),
(2021, 334, '', 'দুর্গাহাটা', 0, 0),
(2022, 334, '', 'কাগইল', 0, 0),
(2023, 334, '', 'সোনারায়', 0, 0),
(2024, 334, '', 'রামেশ্বরপুর', 0, 0),
(2025, 334, '', 'নাড়ুয়ামালা', 0, 0),
(2026, 334, '', 'নেপালতলী', 0, 0),
(2027, 334, '', 'গাবতলি', 0, 0),
(2028, 334, '', 'মহিষাবান', 0, 0),
(2029, 334, '', 'নশিপুর', 0, 0),
(2030, 331, '', '৫নং মির্জাপুর', 0, 0),
(2031, 331, '', '৩নং খামারকান্দি', 0, 0),
(2032, 331, '', '২নং গাড়িদহ', 0, 0),
(2033, 331, '', '১নং কুসুম্বী', 0, 0),
(2034, 331, '', '৬নং বিশালপুর', 0, 0),
(2035, 331, '', '৯নং সীমাবাড়ি', 0, 0),
(2036, 331, '', '১০নং শাহবন্দেগী', 0, 0),
(2037, 331, '', '৮নং সুঘাট', 0, 0),
(2038, 331, '', '৪নং খানপুর', 0, 0),
(2039, 331, '', '৭নং ভবানীপুর', 0, 0),
(2040, 339, '', '১নং ময়দানহাট্টা', 0, 0),
(2041, 339, '', '২নং কিচক ইউনিয়ন', 0, 0),
(2042, 339, '', '৩নং আটমূল', 0, 0),
(2043, 339, '', '৪নং পিরব', 0, 0),
(2044, 339, '', '৫নং মাঝিহট্ট', 0, 0),
(2045, 339, '', '৬নং বুড়িগঞ্জ', 0, 0),
(2046, 339, '', '৭নং বিহার', 0, 0),
(2047, 339, '', '৮নং শিবগঞ্জ', 0, 0),
(2048, 339, '', '৯নং দেউলি', 0, 0),
(2049, 339, '', '১০নং সৈয়দপুর', 0, 0),
(2050, 339, '', '১১নং মোকামতলা ইউনিয়ন', 0, 0),
(2051, 339, '', '১২নং রায়নগর', 0, 0),
(2052, 383, '', '০১ নং দর্শনপাড়া ইউনিয়ন', 0, 0),
(2053, 383, '', '০২ নং হুজুরী পাড়া ইউনিয়ন', 0, 0),
(2054, 383, '', '০৩ নং দামকুড়া ইউনিয়ন', 0, 0),
(2055, 383, '', '০৪ নং হরিপুর ইউনিয়ন', 0, 0),
(2056, 383, '', '০৫ নং হড়গ্রাম ইউনিয়ন', 0, 0),
(2057, 383, '', '০৬ নং হরিয়ান ইউনিয়ন', 0, 0),
(2058, 383, '', '০৭ নং বড়্গাছি ইউনিয়ন', 0, 0),
(2059, 383, '', '০৮ নং পারিলা ইউনিয়ন', 0, 0),
(2060, 380, '', '০১ নং নওপাড়া ইউনিয়ন', 0, 0),
(2061, 380, '', '০২ নং কিসমতগণকৈড় ইউনিয়ন', 0, 0),
(2062, 380, '', '০৩ নং পানানগর ইউনিয়ন', 0, 0),
(2063, 380, '', '০৪ নং দেলুয়াবাড়ী ইউনিয়ন', 0, 0),
(2064, 380, '', '০৫ নং ঝালুকা ইউনিয়ন', 0, 0),
(2065, 380, '', '০৬ নং মাড়িয়া ইউনিয়ন', 0, 0),
(2066, 380, '', '০৭ নং জয়নগর ইউনিয়ন', 0, 0),
(2067, 382, '', '০১ নং ধুরইল ইউনিয়ন', 0, 0),
(2068, 382, '', '০২ নং ঘষিগ্রাম ইউনিয়ন', 0, 0),
(2069, 382, '', '০৩ নং রায়ঘাটি ইউনিয়ন', 0, 0),
(2070, 382, '', '০৪ নং মৌগাছি ইউনিয়ন', 0, 0),
(2071, 382, '', '০৫ নং বাকশিমইল ইউনিয়ন', 0, 0),
(2072, 382, '', '০৬ নং জাহানাবাদ ইউনিয়ন', 0, 0),
(2073, 379, '', '০১ নং ইউসুফপুর ইউনিয়ন', 0, 0),
(2074, 379, '', '০২ নং শলুয়া ইউনিয়ন', 0, 0),
(2075, 379, '', '০৩ নং সরদহ ইউনিয়ন', 0, 0),
(2076, 379, '', '০৪ নং নিমপাড়া ইউনিয়ন', 0, 0),
(2077, 379, '', '০৫ নং চারঘাট ইউনিয়ন', 0, 0),
(2078, 379, '', '০৬ নং ভায়ালক্ষ্মীপুর ইউনিয়ন', 0, 0),
(2079, 384, '', '০১ নং পুঠিয়া ইউনিয়ন', 0, 0),
(2080, 384, '', '০২ নং বেলপুকুরিয়া ইউনিয়ন', 0, 0),
(2081, 384, '', '০৩ নং বানেশ্বর ইউনিয়ন', 0, 0),
(2082, 384, '', '০৪ নং ভালুক গাছি ইউনিয়ন', 0, 0),
(2083, 384, '', '০৫ নং শিলমাড়িয়া ইউনিয়ন', 0, 0),
(2084, 384, '', '০৬ নং জিউপাড়া ইউনিয়ন', 0, 0),
(2085, 377, '', '০১ নং বাজুবাঘা ইউনিয়ন', 0, 0),
(2086, 377, '', '০২ নং গড়গড়ি ইউনিয়ন', 0, 0),
(2087, 377, '', '০৩ নং পাকুড়িয়া ইউনিয়ন', 0, 0),
(2088, 377, '', '০৪ নং মনিগ্রাম ইউনিয়ন', 0, 0),
(2089, 377, '', '০৫ নং বাউসা ইউনিয়ন', 0, 0),
(2090, 377, '', '০৬ নং আড়ানী', 0, 0),
(2091, 381, '', '০১ নং গোদাগাড়ী ইউনিয়ন', 0, 0),
(2092, 381, '', '০২ নং মোহনপুর ইউনিয়ন', 0, 0),
(2093, 381, '', '০৩ নং পাকড়ী ইউনিয়ন', 0, 0),
(2094, 381, '', '০৪ নং রিশিকুল ইউনিয়ন', 0, 0),
(2095, 381, '', '০৫ নং গোগ্রাম ইউনিয়ন', 0, 0),
(2096, 381, '', '০৬ নং মাটিকাটা ইউনিয়ন', 0, 0),
(2097, 381, '', '০৭ নং দেওপাড়া ইউনিয়ন', 0, 0),
(2098, 381, '', '০৮ নং বাসুদেবপুর ইউনিয়ন', 0, 0),
(2099, 381, '', '০৯ নং আষাড়িয়াদহ ইউনিয়ন', 0, 0),
(2100, 385, '', '০১ নং কলমা ইউনিয়ন', 0, 0),
(2101, 385, '', '০২ নং বাধাইড় ইউনিয়ন', 0, 0),
(2102, 385, '', '০৩ নং পাঁচন্দর ইউনিয়ন', 0, 0),
(2103, 385, '', '০৪ নং সরঞ্জাই ইউনিয়ন', 0, 0),
(2104, 385, '', '০৫ নং তালন্দ ইউনিয়ন', 0, 0),
(2105, 385, '', '০৬ নং কামারগাঁ ইউনিয়ন', 0, 0),
(2106, 385, '', '০৭ নং চান্দুড়িয়া ইউনিয়ন', 0, 0),
(2107, 378, '', '০১ নং গোবিন্দপাড়া ইউনিয়ন', 0, 0),
(2108, 378, '', '০২ নং নরদাস ইউনিয়ন', 0, 0),
(2109, 378, '', '০৩ নং দ্বীপপুর ইউনিয়ন', 0, 0),
(2110, 378, '', '০৪ নং বড়বিহানলী ইউনিয়ন', 0, 0),
(2111, 378, '', '০৫ নং আউচপাড়া ইউনিয়ন', 0, 0),
(2112, 378, '', '০৬ নং শ্রীপুর ইউনিয়ন', 0, 0),
(2113, 378, '', '০৭ নং বাসুপাড়া ইউনিয়ন', 0, 0),
(2114, 378, '', '০৮ নং কাচাড়ী কোয়লিপাড়া ইউনিয়ন', 0, 0),
(2115, 378, '', '০৯ নং শুভডাঙ্গা ইউনিয়ন', 0, 0),
(2116, 378, '', '১০ নং মাড়িয়া ইউনিয়ন', 0, 0),
(2117, 378, '', '১১ নং গণিপুর ইউনিয়ন', 0, 0),
(2118, 378, '', '১২ নং ঝিকড়া ইউনিয়ন', 0, 0),
(2119, 378, '', '১৩ নং গোয়ালকান্দি ইউনিয়ন', 0, 0),
(2120, 378, '', '১৪ নং হামিরকুৎসা ইউনিয়ন', 0, 0),
(2121, 378, '', '১৫ নং যোগিপাড়া ইউনিয়ন', 0, 0),
(2122, 378, '', '১৬ নং সোনাডাঙ্গা ইউনিয়ন', 0, 0),
(2123, 357, '', '১ নং ব্রহ্মপুর ইউনিয়ন', 0, 0),
(2124, 357, '', '০২ নং মাধনগর ইউনিয়ন', 0, 0),
(2125, 357, '', '০৩ নং খাজুরা ইউনিয়ন', 0, 0),
(2126, 357, '', '০৪ নং পিপরুল ইউনিয়ন', 0, 0),
(2127, 357, '', '০৫ নং বিপ্রবেলঘড়িয়া ইউনিয়ন', 0, 0),
(2128, 357, '', '০৬ নং ছাতনী ইউনিয়ন', 0, 0),
(2129, 357, '', '০৭ নং তেবাড়িয়া ইউনিয়ন', 0, 0),
(2130, 357, '', '০৮ নং দিঘাপতিয়া ইউনিয়ন', 0, 0),
(2131, 357, '', '০৯ নং লক্ষীপুর খোলাবাড়িয়া ইউনিয়ন', 0, 0),
(2132, 357, '', '১০ নং বড়হরিশপুর ইউনিয়ন', 0, 0),
(2133, 357, '', '১১ নং কাফুরিয়া ইউনিয়ন', 0, 0),
(2134, 357, '', '১২ নং হালসা ইউনিয়ন', 0, 0),
(2135, 361, '', '০১ নং শুকাশ ইউনিয়ন', 0, 0),
(2136, 361, '', '০২ নং ডাহিয়া ইউনিয়ন', 0, 0),
(2137, 361, '', '০৩ নং ইটালী ইউনিয়ন', 0, 0),
(2138, 361, '', '০৪ নং কলম ইউনিয়ন', 0, 0),
(2139, 361, '', '০৫ নং চামারী ইউনিয়ন', 0, 0),
(2140, 361, '', '০৬ নং হাতিয়ানদহ ইউনিয়ন', 0, 0),
(2141, 361, '', '০৭ নং লালোর ইউনিয়ন', 0, 0),
(2142, 361, '', '০৮ নং শেরকোল ইউনিয়ন', 0, 0),
(2143, 361, '', '০৯ নং তাজপুর ইউনিয়ন', 0, 0),
(2144, 361, '', '১০ নং চৌগ্রাম ইউনিয়ন', 0, 0),
(2145, 361, '', '১১ নং ছাতারদিঘী ইউনিয়ন', 0, 0),
(2146, 361, '', '১২ নং রামান্দখাজুরা ইউনিয়ন', 0, 0),
(2147, 362, '', '০১ নং জোয়াড়ী ইউনিয়ন', 0, 0),
(2148, 362, '', '০২ নং বড়াইগ্রাম ইউনিয়ন', 0, 0),
(2149, 362, '', '০৩ নং জোনাইল ইউনিয়ন', 0, 0),
(2150, 362, '', '০৪ নং নগর ইউনিয়ন', 0, 0),
(2151, 362, '', '০৫ নং মাঝগাও ইউনিয়ন', 0, 0),
(2152, 362, '', '০৬ নং গোপালপুর ইউনিয়ন', 0, 0),
(2153, 362, '', '০৭ নং চান্দাই ইউনিয়ন', 0, 0),
(2154, 359, '', '০১ নং পাঁকা ইউনিয়ন', 0, 0),
(2155, 359, '', '০২ নং জামনগর ইউনিয়ন', 0, 0),
(2156, 359, '', '০৩ নং বাগাতিপাড়া ইউনিয়ন', 0, 0),
(2157, 359, '', '০৪ নং দয়ারামপুর ইউনিয়ন', 0, 0),
(2158, 359, '', '০৫ নং ফাগুয়ারদিয়াড় ইউনিয়ন', 0, 0),
(2159, 360, '', '০১ নং লালপুর ইউনিয়ন', 0, 0),
(2160, 360, '', '০২ নং ঈশ্বরদী ইউনিয়ন', 0, 0),
(2161, 360, '', '০৩ নং চংধুপইল ইউনিয়ন', 0, 0),
(2162, 360, '', '০৪ নং আড়বাব ইউনিয়ন', 0, 0),
(2163, 360, '', '০৫ নং বিলমাড়িয়া ইউনিয়ন', 0, 0),
(2164, 360, '', '০৬ নং দুয়ারিয়া ইউনিয়ন', 0, 0),
(2165, 360, '', '০৭ নং ওয়ালিয়া ইউনিয়ন', 0, 0),
(2166, 360, '', '০৮ নং দুড়দুরিয়া ইউনিয়ন', 0, 0),
(2167, 360, '', '০৯ নং অর্জুনপুর বরমহাটী ইউনিয়ন', 0, 0),
(2168, 360, '', '১০ নং কদিমচিলান ইউনিয়ন', 0, 0),
(2169, 362, '', '০১ নং নাজিরপুর ইউনিয়ন', 0, 0),
(2170, 362, '', '০২ নং বিয়াঘাট ইউনিয়ন', 0, 0),
(2171, 362, '', '০৩ নং খুবজীপুর ইউনিয়ন', 0, 0),
(2172, 362, '', '০৫ নং ধারাবারিষা ইউনিয়ন', 0, 0),
(2173, 362, '', '০৪ নং মসিন্দা ইউনিয়ন', 0, 0),
(2174, 362, '', '০৬ নং চাপিলা ইউনিয়ন', 0, 0),
(2175, 342, '', 'রুকিন্দীপুর ইউনিয়ন', 0, 0),
(2176, 342, '', 'সোনামূখী ইউনিয়ন', 0, 0),
(2177, 342, '', 'তিলকপুর ইউনিয়ন', 0, 0),
(2178, 342, '', 'রায়কালী ইউনিয়ন', 0, 0),
(2179, 342, '', 'গোপীনাথপুর ইউনিয়ন', 0, 0),
(2180, 343, '', 'মাত্রাই ইউনিয়ন', 0, 0),
(2181, 343, '', 'আহম্মেদাবাদ ইউনিয়ন', 0, 0),
(2182, 343, '', 'পুনট ইউনিয়ন', 0, 0),
(2183, 343, '', 'জিন্দারপুর', 0, 0),
(2184, 343, '', 'উদয়পুর', 0, 0),
(2185, 344, '', 'আলমপুর ইউনিয়ন', 0, 0),
(2186, 344, '', 'বড়াইল ইউনিয়ন', 0, 0),
(2187, 344, '', 'তুলশীগংগা ইউনিয়ন', 0, 0),
(2188, 344, '', 'মামুদপুর ইউনিয়ন', 0, 0),
(2189, 344, '', 'বড়তারা ইউনিয়ন', 0, 0),
(2190, 345, '', 'বাগজানা ইউনিয়ন', 0, 0),
(2191, 345, '', 'ধরঞ্জি', 0, 0),
(2192, 345, '', 'আয়মারসুলপুর ইউনিয়ন', 0, 0),
(2193, 345, '', 'বালিঘাটা ইউনিয়ন', 0, 0),
(2194, 345, '', 'আটাপুর ইউনিয়ন', 0, 0),
(2195, 345, '', 'মোহাম্মদপুর ইউনিয়ন', 0, 0),
(2196, 345, '', 'আওলাই', 0, 0),
(2197, 345, '', 'কুসুম্বা', 0, 0),
(2198, 341, '', 'আমদই ইউনিয়ন', 0, 0),
(2199, 341, '', 'বম্বু ইউনিয়ন', 0, 0),
(2200, 341, '', 'দোগাছি ইউনিয়ন', 0, 0),
(2201, 341, '', 'পুরানাপৈল ইউনিয়ন', 0, 0),
(2202, 341, '', 'জামালপুর ইউনিয়ন', 0, 0),
(2203, 341, '', 'চকবরকত ইউনিয়ন', 0, 0),
(2204, 341, '', 'মোহাম্মদাবাদ ইউনিয়ন', 0, 0),
(2205, 341, '', 'ধলাহার ইউনিয়ন', 0, 0),
(2206, 341, '', 'ভাদসা', 0, 0),
(2207, 366, '', 'আলাতুলী', 0, 0),
(2208, 366, '', 'বারঘরিয়া', 0, 0),
(2209, 366, '', 'মহারাজপুর', 0, 0),
(2210, 366, '', 'রানীহাটি', 0, 0),
(2211, 366, '', 'বালিয়াডাঙ্গা', 0, 0),
(2212, 366, '', 'গোবরাতলা', 0, 0),
(2213, 366, '', 'ঝিলিম', 0, 0),
(2214, 366, '', 'চরঅনুপনগর', 0, 0),
(2215, 366, '', 'দেবীনগর', 0, 0),
(2216, 366, '', 'শাহজাহানপুর', 0, 0),
(2217, 366, '', 'ইসলামপুর', 0, 0),
(2218, 366, '', 'চরবাগডাঙ্গা', 0, 0),
(2219, 366, '', 'নারায়নপুর', 0, 0),
(2220, 366, '', 'সুন্দরপুর', 0, 0),
(2221, 364, '', 'রাধানগর', 0, 0),
(2222, 364, '', 'রহনপুর', 0, 0),
(2223, 364, '', 'বোয়ালিয়া', 0, 0),
(2224, 364, '', 'বাঙ্গাবাড়ী', 0, 0),
(2225, 364, '', 'পার্বতীপুর', 0, 0),
(2226, 364, '', 'চৌডালা', 0, 0),
(2227, 364, '', 'গোমস্তাপুর', 0, 0),
(2228, 364, '', 'আলীনগর', 0, 0),
(2229, 365, '', 'ফতেপুর', 0, 0),
(2230, 365, '', 'কসবা', 0, 0),
(2231, 365, '', 'নেজামপুর', 0, 0),
(2232, 365, '', 'নাচোল', 0, 0),
(2233, 363, '', 'ভোলাহাট', 0, 0),
(2234, 363, '', 'জামবাড়িয়া', 0, 0),
(2235, 363, '', 'গোহালবাড়ী', 0, 0),
(2236, 363, '', 'দলদলী', 0, 0),
(2237, 367, '', 'বিনোদপুর', 0, 0),
(2238, 367, '', 'চককির্তী', 0, 0),
(2239, 367, '', 'দাইপুকুরিয়া', 0, 0),
(2240, 367, '', 'ধাইনগর', 0, 0),
(2241, 367, '', 'দুর্লভপুর', 0, 0),
(2242, 367, '', 'ঘোড়াপাখিয়া', 0, 0),
(2243, 367, '', 'মোবারকপুর', 0, 0),
(2244, 367, '', 'মনাকষা', 0, 0),
(2245, 367, '', 'নয়ালাভাঙ্গা', 0, 0),
(2246, 367, '', 'পাঁকা', 0, 0),
(2247, 367, '', 'ছত্রাজিতপুর', 0, 0),
(2248, 367, '', 'শাহাবাজপুর', 0, 0),
(2249, 367, '', 'শ্যামপুর', 0, 0),
(2250, 367, '', 'কানসাট', 0, 0),
(2251, 367, '', 'উজিরপুর', 0, 0),
(2252, 347, '', 'মহাদেবপুর ইউনিয়ন', 0, 0),
(2253, 347, '', 'হাতুড়', 0, 0),
(2254, 347, '', 'খাজুর ইউনিয়ন', 0, 0),
(2255, 347, '', 'চাঁন্দাশ', 0, 0),
(2256, 347, '', 'এনায়েতপুর', 0, 0),
(2257, 347, '', 'সফাপুর', 0, 0),
(2258, 347, '', 'উত্তরগ্রাম', 0, 0),
(2259, 347, '', 'চেরাগপুর', 0, 0),
(2260, 347, '', 'ভীমপুর', 0, 0),
(2261, 347, '', 'রাইগাঁ', 0, 0),
(2262, 356, '', 'বদলগাছী ইউনিয়ন', 0, 0),
(2263, 356, '', 'মথুরাপুর ইউনিয়ন', 0, 0),
(2264, 356, '', 'পাহারপুর ইউনিয়ন', 0, 0),
(2265, 356, '', 'মিঠাপুর ইউনিয়ন', 0, 0),
(2266, 356, '', 'কোলা ইউনিয়ন', 0, 0),
(2267, 356, '', 'বিলাশবাড়ী ইউনিয়ন', 0, 0),
(2268, 356, '', 'আধাইপুর ইউনিয়ন', 0, 0),
(2269, 356, '', 'বালুভরা ইউনিয়ন', 0, 0),
(2270, 352, '', 'পত্নীতলা ইউনিয়ন', 0, 0),
(2271, 352, '', 'নিমইল ইউনিয়ন', 0, 0),
(2272, 352, '', 'দিবর ইউনিয়ন', 0, 0),
(2273, 352, '', 'আকবরপুর ইউনিয়ন', 0, 0),
(2274, 352, '', 'মাটিন্দর ইউনিয়ন', 0, 0),
(2275, 352, '', 'কৃষ্ণপুর ইউনিয়ন', 0, 0),
(2276, 352, '', 'পাটিচড়া ইউনিয়ন', 0, 0),
(2277, 352, '', 'নজিপুর ইউনিয়ন', 0, 0),
(2278, 352, '', 'ঘষনগর ইউনিয়ন', 0, 0),
(2279, 352, '', 'আমাইড় ইউনিয়ন', 0, 0),
(2280, 352, '', 'শিহারা ইউনিয়ন', 0, 0),
(2281, 353, '', 'ধামইরহাট', 0, 0),
(2282, 353, '', 'আলমপুর', 0, 0),
(2283, 353, '', 'উমার ইউনিয়ন', 0, 0),
(2284, 353, '', 'আড়ানগর', 0, 0),
(2285, 353, '', 'জাহানপুর', 0, 0),
(2286, 353, '', 'ইসবপুর', 0, 0),
(2287, 353, '', 'খেলনা', 0, 0),
(2288, 353, '', 'আগ্রাদ্বিগুন', 0, 0),
(2289, 349, '', 'হাজীনগর ইউনিয়ন', 0, 0),
(2290, 349, '', 'চন্দননগর ইউনিয়ন', 0, 0),
(2291, 349, '', 'ভাবিচা ইউনিয়ন', 0, 0),
(2292, 349, '', 'নিয়ামতপুর ইউনিয়ন', 0, 0),
(2293, 349, '', 'রসুলপুর ইউনিয়ন', 0, 0),
(2294, 349, '', 'পাড়ইল ইউনিয়ন', 0, 0),
(2295, 349, '', 'শ্রীমন্তপুর', 0, 0),
(2296, 349, '', 'বাহাদুরপুর', 0, 0),
(2297, 348, '', 'ভারশো', 0, 0),
(2298, 348, '', 'ভালাইন', 0, 0),
(2299, 348, '', 'পরানপুর', 0, 0),
(2300, 348, '', 'মান্দা', 0, 0),
(2301, 348, '', 'গনেশপুর', 0, 0),
(2302, 348, '', 'মৈনম', 0, 0),
(2303, 348, '', 'প্রসাদপুর ইউনিয়ন', 0, 0),
(2304, 348, '', 'কুসুম্বা', 0, 0),
(2305, 348, '', 'তেঁতুলিয়া', 0, 0),
(2306, 348, '', 'নূরুল্যাবাদ', 0, 0),
(2307, 348, '', 'কালিকাপুর', 0, 0),
(2308, 348, '', 'কাঁশোকাপুর', 0, 0),
(2309, 348, '', 'কশব ইউনিয়ন', 0, 0),
(2310, 348, '', 'বিষ্ণপুর', 0, 0),
(2311, 350, '', 'শাহাগোলা', 0, 0),
(2312, 350, '', 'ভোঁপড়া', 0, 0),
(2313, 350, '', 'আহসানগঞ্জ', 0, 0),
(2314, 350, '', 'পাঁচুপুর', 0, 0),
(2315, 350, '', 'বিশা', 0, 0),
(2316, 350, '', 'মনিয়ারী', 0, 0),
(2317, 350, '', 'কালিকাপুর', 0, 0),
(2318, 350, '', 'হাটকালুপাড়া', 0, 0),
(2319, 351, '', 'খট্টেশ্বর রাণীনগর', 0, 0),
(2320, 351, '', 'কাশিমপুর', 0, 0),
(2321, 351, '', 'গোনা', 0, 0),
(2322, 351, '', 'পারইল', 0, 0),
(2323, 351, '', 'বরগাছা', 0, 0),
(2324, 351, '', 'কালিগ্রাম', 0, 0),
(2325, 351, '', 'একডালা', 0, 0),
(2326, 351, '', 'মিরাট', 0, 0),
(2327, 346, '', 'বর্ষাইল', 0, 0),
(2328, 346, '', 'কির্ত্তিপুর', 0, 0),
(2329, 346, '', 'বক্তারপুর ইউনিয়ন', 0, 0),
(2330, 346, '', 'তিলোকপুর', 0, 0),
(2331, 346, '', 'হাপানিয়া', 0, 0),
(2332, 346, '', 'দুবলহাটী ইউনিয়ন', 0, 0),
(2333, 346, '', 'বোয়ালিয়া ইউনিয়ন', 0, 0),
(2334, 346, '', 'হাঁসাইগাড়ী', 0, 0),
(2335, 346, '', 'চন্ডিপুর', 0, 0),
(2336, 346, '', 'বলিহার', 0, 0),
(2337, 346, '', 'শিকারপুর', 0, 0),
(2338, 346, '', 'শৈলগাছী', 0, 0),
(2339, 355, '', 'নিতপুর ইউনিয়ন', 0, 0),
(2340, 355, '', 'তেঁতুলিয়া', 0, 0),
(2341, 355, '', 'ছাওড়', 0, 0),
(2342, 355, '', 'গাঙ্গুরিয়া', 0, 0),
(2343, 355, '', 'ঘাটনগর ইউনিয়ন', 0, 0),
(2344, 355, '', 'মশিদপুর', 0, 0),
(2345, 354, '', 'সাপাহার', 0, 0),
(2346, 354, '', 'তিলনা', 0, 0),
(2347, 354, '', 'আইহাই', 0, 0),
(2348, 354, '', 'শিরন্টী', 0, 0),
(2349, 354, '', 'গোয়ালা', 0, 0),
(2350, 354, '', 'পাতাড়ী', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `unitTtile` varchar(55) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `dist_id`, `unitTtile`, `code`, `created_at`, `updated_by`) VALUES
(1, 1, 'Pcs', '1001', '2018-11-25 17:40:40', 1),
(2, 1, 'KG', '1002', '2018-11-18 12:22:59', 0),
(4, 15, 'KG1', '1005', '2019-01-09 11:11:45', 1),
(5, 3, 'Ltr.', '', '2019-01-28 15:11:19', 3);

-- --------------------------------------------------------

--
-- Table structure for table `upazilas`
--

CREATE TABLE `upazilas` (
  `id` int(2) UNSIGNED NOT NULL,
  `district_id` int(2) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `bn_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `upazilas`
--

INSERT INTO `upazilas` (`id`, `district_id`, `name`, `bn_name`) VALUES
(1, 34, 'Amtali Upazila', 'আমতলী'),
(2, 34, 'Bamna Upazila', 'বামনা'),
(3, 34, 'Barguna Sadar Upazila', 'বরগুনা সদর'),
(4, 34, 'Betagi Upazila', 'বেতাগি'),
(5, 34, 'Patharghata Upazila', 'পাথরঘাটা'),
(6, 34, 'Taltali Upazila', 'তালতলী'),
(7, 35, 'Muladi Upazila', 'মুলাদি'),
(8, 35, 'Babuganj Upazila', 'বাবুগঞ্জ'),
(9, 35, 'Agailjhara Upazila', 'আগাইলঝরা'),
(10, 35, 'Barisal Sadar Upazila', 'বরিশাল সদর'),
(11, 35, 'Bakerganj Upazila', 'বাকেরগঞ্জ'),
(12, 35, 'Banaripara Upazila', 'বানাড়িপারা'),
(13, 35, 'Gaurnadi Upazila', 'গৌরনদী'),
(14, 35, 'Hizla Upazila', 'হিজলা'),
(15, 35, 'Mehendiganj Upazila', 'মেহেদিগঞ্জ '),
(16, 35, 'Wazirpur Upazila', 'ওয়াজিরপুর'),
(17, 36, 'Bhola Sadar Upazila', 'ভোলা সদর'),
(18, 36, 'Burhanuddin Upazila', 'বুরহানউদ্দিন'),
(19, 36, 'Char Fasson Upazila', 'চর ফ্যাশন'),
(20, 36, 'Daulatkhan Upazila', 'দৌলতখান'),
(21, 36, 'Lalmohan Upazila', 'লালমোহন'),
(22, 36, 'Manpura Upazila', 'মনপুরা'),
(23, 36, 'Tazumuddin Upazila', 'তাজুমুদ্দিন'),
(24, 37, 'Jhalokati Sadar Upazila', 'ঝালকাঠি সদর'),
(25, 37, 'Kathalia Upazila', 'কাঁঠালিয়া'),
(26, 37, 'Nalchity Upazila', 'নালচিতি'),
(27, 37, 'Rajapur Upazila', 'রাজাপুর'),
(28, 38, 'Bauphal Upazila', 'বাউফল'),
(29, 38, 'Dashmina Upazila', 'দশমিনা'),
(30, 38, 'Galachipa Upazila', 'গলাচিপা'),
(31, 38, 'Kalapara Upazila', 'কালাপারা'),
(32, 38, 'Mirzaganj Upazila', 'মির্জাগঞ্জ '),
(33, 38, 'Patuakhali Sadar Upazila', 'পটুয়াখালী সদর'),
(34, 38, 'Dumki Upazila', 'ডুমকি'),
(35, 38, 'Rangabali Upazila', 'রাঙ্গাবালি'),
(36, 39, 'Bhandaria', 'ভ্যান্ডারিয়া'),
(37, 39, 'Kaukhali', 'কাউখালি'),
(38, 39, 'Mathbaria', 'মাঠবাড়িয়া'),
(39, 39, 'Nazirpur', 'নাজিরপুর'),
(40, 39, 'Nesarabad', 'নেসারাবাদ'),
(41, 39, 'Pirojpur Sadar', 'পিরোজপুর সদর'),
(42, 39, 'Zianagar', 'জিয়ানগর'),
(43, 40, 'Bandarban Sadar', 'বান্দরবন সদর'),
(44, 40, 'Thanchi', 'থানচি'),
(45, 40, 'Lama', 'লামা'),
(46, 40, 'Naikhongchhari', 'নাইখংছড়ি '),
(47, 40, 'Ali kadam', 'আলী কদম'),
(48, 40, 'Rowangchhari', 'রউয়াংছড়ি '),
(49, 40, 'Ruma', 'রুমা'),
(50, 41, 'Brahmanbaria Sadar Upazila', 'ব্রাহ্মণবাড়িয়া সদর'),
(51, 41, 'Ashuganj Upazila', 'আশুগঞ্জ'),
(52, 41, 'Nasirnagar Upazila', 'নাসির নগর'),
(53, 41, 'Nabinagar Upazila', 'নবীনগর'),
(54, 41, 'Sarail Upazila', 'সরাইল'),
(55, 41, 'Shahbazpur Town', 'শাহবাজপুর টাউন'),
(56, 41, 'Kasba Upazila', 'কসবা'),
(57, 41, 'Akhaura Upazila', 'আখাউরা'),
(58, 41, 'Bancharampur Upazila', 'বাঞ্ছারামপুর'),
(59, 41, 'Bijoynagar Upazila', 'বিজয় নগর'),
(60, 42, 'Chandpur Sadar', 'চাঁদপুর সদর'),
(61, 42, 'Faridganj', 'ফরিদগঞ্জ'),
(62, 42, 'Haimchar', 'হাইমচর'),
(63, 42, 'Haziganj', 'হাজীগঞ্জ'),
(64, 42, 'Kachua', 'কচুয়া'),
(65, 42, 'Matlab Uttar', 'মতলব উত্তর'),
(66, 42, 'Matlab Dakkhin', 'মতলব দক্ষিণ'),
(67, 42, 'Shahrasti', 'শাহরাস্তি'),
(68, 43, 'Anwara Upazila', 'আনোয়ারা'),
(69, 43, 'Banshkhali Upazila', 'বাশখালি'),
(70, 43, 'Boalkhali Upazila', 'বোয়ালখালি'),
(71, 43, 'Chandanaish Upazila', 'চন্দনাইশ'),
(72, 43, 'Fatikchhari Upazila', 'ফটিকছড়ি'),
(73, 43, 'Hathazari Upazila', 'হাঠহাজারী'),
(74, 43, 'Lohagara Upazila', 'লোহাগারা'),
(75, 43, 'Mirsharai Upazila', 'মিরসরাই'),
(76, 43, 'Patiya Upazila', 'পটিয়া'),
(77, 43, 'Rangunia Upazila', 'রাঙ্গুনিয়া'),
(78, 43, 'Raozan Upazila', 'রাউজান'),
(79, 43, 'Sandwip Upazila', 'সন্দ্বীপ'),
(80, 43, 'Satkania Upazila', 'সাতকানিয়া'),
(81, 43, 'Sitakunda Upazila', 'সীতাকুণ্ড'),
(82, 44, 'Barura Upazila', 'বড়ুরা'),
(83, 44, 'Brahmanpara Upazila', 'ব্রাহ্মণপাড়া'),
(84, 44, 'Burichong Upazila', 'বুড়িচং'),
(85, 44, 'Chandina Upazila', 'চান্দিনা'),
(86, 44, 'Chauddagram Upazila', 'চৌদ্দগ্রাম'),
(87, 44, 'Daudkandi Upazila', 'দাউদকান্দি'),
(88, 44, 'Debidwar Upazila', 'দেবীদ্বার'),
(89, 44, 'Homna Upazila', 'হোমনা'),
(90, 44, 'Comilla Sadar Upazila', 'কুমিল্লা সদর'),
(91, 44, 'Laksam Upazila', 'লাকসাম'),
(92, 44, 'Monohorgonj Upazila', 'মনোহরগঞ্জ'),
(93, 44, 'Meghna Upazila', 'মেঘনা'),
(94, 44, 'Muradnagar Upazila', 'মুরাদনগর'),
(95, 44, 'Nangalkot Upazila', 'নাঙ্গালকোট'),
(96, 44, 'Comilla Sadar South Upazila', 'কুমিল্লা সদর দক্ষিণ'),
(97, 44, 'Titas Upazila', 'তিতাস'),
(98, 45, 'Chakaria Upazila', 'চকরিয়া'),
(100, 45, 'Cox\'s Bazar Sadar Upazila', 'কক্স বাজার সদর'),
(101, 45, 'Kutubdia Upazila', 'কুতুবদিয়া'),
(102, 45, 'Maheshkhali Upazila', 'মহেশখালী'),
(103, 45, 'Ramu Upazila', 'রামু'),
(104, 45, 'Teknaf Upazila', 'টেকনাফ'),
(105, 45, 'Ukhia Upazila', 'উখিয়া'),
(106, 45, 'Pekua Upazila', 'পেকুয়া'),
(107, 46, 'Feni Sadar', 'ফেনী সদর'),
(108, 46, 'Chagalnaiya', 'ছাগল নাইয়া'),
(109, 46, 'Daganbhyan', 'দাগানভিয়া'),
(110, 46, 'Parshuram', 'পরশুরাম'),
(111, 46, 'Fhulgazi', 'ফুলগাজি'),
(112, 46, 'Sonagazi', 'সোনাগাজি'),
(113, 47, 'Dighinala Upazila', 'দিঘিনালা '),
(114, 47, 'Khagrachhari Upazila', 'খাগড়াছড়ি'),
(115, 47, 'Lakshmichhari Upazila', 'লক্ষ্মীছড়ি'),
(116, 47, 'Mahalchhari Upazila', 'মহলছড়ি'),
(117, 47, 'Manikchhari Upazila', 'মানিকছড়ি'),
(118, 47, 'Matiranga Upazila', 'মাটিরাঙ্গা'),
(119, 47, 'Panchhari Upazila', 'পানছড়ি'),
(120, 47, 'Ramgarh Upazila', 'রামগড়'),
(121, 48, 'Lakshmipur Sadar Upazila', 'লক্ষ্মীপুর সদর'),
(122, 48, 'Raipur Upazila', 'রায়পুর'),
(123, 48, 'Ramganj Upazila', 'রামগঞ্জ'),
(124, 48, 'Ramgati Upazila', 'রামগতি'),
(125, 48, 'Komol Nagar Upazila', 'কমল নগর'),
(126, 49, 'Noakhali Sadar Upazila', 'নোয়াখালী সদর'),
(127, 49, 'Begumganj Upazila', 'বেগমগঞ্জ'),
(128, 49, 'Chatkhil Upazila', 'চাটখিল'),
(129, 49, 'Companyganj Upazila', 'কোম্পানীগঞ্জ'),
(130, 49, 'Shenbag Upazila', 'শেনবাগ'),
(131, 49, 'Hatia Upazila', 'হাতিয়া'),
(132, 49, 'Kobirhat Upazila', 'কবিরহাট '),
(133, 49, 'Sonaimuri Upazila', 'সোনাইমুরি'),
(134, 49, 'Suborno Char Upazila', 'সুবর্ণ চর '),
(135, 50, 'Rangamati Sadar Upazila', 'রাঙ্গামাটি সদর'),
(136, 50, 'Belaichhari Upazila', 'বেলাইছড়ি'),
(137, 50, 'Bagaichhari Upazila', 'বাঘাইছড়ি'),
(138, 50, 'Barkal Upazila', 'বরকল'),
(139, 50, 'Juraichhari Upazila', 'জুরাইছড়ি'),
(140, 50, 'Rajasthali Upazila', 'রাজাস্থলি'),
(141, 50, 'Kaptai Upazila', 'কাপ্তাই'),
(142, 50, 'Langadu Upazila', 'লাঙ্গাডু'),
(143, 50, 'Nannerchar Upazila', 'নান্নেরচর '),
(144, 50, 'Kaukhali Upazila', 'কাউখালি'),
(145, 1, 'Dhamrai Upazila', 'ধামরাই'),
(146, 1, 'Dohar Upazila', 'দোহার'),
(147, 1, 'Keraniganj Upazila', 'কেরানীগঞ্জ'),
(148, 1, 'Nawabganj Upazila', 'নবাবগঞ্জ'),
(149, 1, 'Savar Upazila', 'সাভার'),
(150, 2, 'Faridpur Sadar Upazila', 'ফরিদপুর সদর'),
(151, 2, 'Boalmari Upazila', 'বোয়ালমারী'),
(152, 2, 'Alfadanga Upazila', 'আলফাডাঙ্গা'),
(153, 2, 'Madhukhali Upazila', 'মধুখালি'),
(154, 2, 'Bhanga Upazila', 'ভাঙ্গা'),
(155, 2, 'Nagarkanda Upazila', 'নগরকান্ড'),
(156, 2, 'Charbhadrasan Upazila', 'চরভদ্রাসন '),
(157, 2, 'Sadarpur Upazila', 'সদরপুর'),
(158, 2, 'Shaltha Upazila', 'শালথা'),
(159, 3, 'Gazipur Sadar-Joydebpur', 'গাজীপুর সদর'),
(160, 3, 'Kaliakior', 'কালিয়াকৈর'),
(161, 3, 'Kapasia', 'কাপাসিয়া'),
(162, 3, 'Sripur', 'শ্রীপুর'),
(163, 3, 'Kaliganj', 'কালীগঞ্জ'),
(164, 3, 'Tongi', 'টঙ্গি'),
(165, 4, 'Gopalganj Sadar Upazila', 'গোপালগঞ্জ সদর'),
(166, 4, 'Kashiani Upazila', 'কাশিয়ানি'),
(167, 4, 'Kotalipara Upazila', 'কোটালিপাড়া'),
(168, 4, 'Muksudpur Upazila', 'মুকসুদপুর'),
(169, 4, 'Tungipara Upazila', 'টুঙ্গিপাড়া'),
(170, 5, 'Dewanganj Upazila', 'দেওয়ানগঞ্জ'),
(171, 5, 'Baksiganj Upazila', 'বকসিগঞ্জ'),
(172, 5, 'Islampur Upazila', 'ইসলামপুর'),
(173, 5, 'Jamalpur Sadar Upazila', 'জামালপুর সদর'),
(174, 5, 'Madarganj Upazila', 'মাদারগঞ্জ'),
(175, 5, 'Melandaha Upazila', 'মেলানদাহা'),
(176, 5, 'Sarishabari Upazila', 'সরিষাবাড়ি '),
(177, 5, 'Narundi Police I.C', 'নারুন্দি'),
(178, 6, 'Astagram Upazila', 'অষ্টগ্রাম'),
(179, 6, 'Bajitpur Upazila', 'বাজিতপুর'),
(180, 6, 'Bhairab Upazila', 'ভৈরব'),
(181, 6, 'Hossainpur Upazila', 'হোসেনপুর '),
(182, 6, 'Itna Upazila', 'ইটনা'),
(183, 6, 'Karimganj Upazila', 'করিমগঞ্জ'),
(184, 6, 'Katiadi Upazila', 'কতিয়াদি'),
(185, 6, 'Kishoreganj Sadar Upazila', 'কিশোরগঞ্জ সদর'),
(186, 6, 'Kuliarchar Upazila', 'কুলিয়ারচর'),
(187, 6, 'Mithamain Upazila', 'মিঠামাইন'),
(188, 6, 'Nikli Upazila', 'নিকলি'),
(189, 6, 'Pakundia Upazila', 'পাকুন্ডা'),
(190, 6, 'Tarail Upazila', 'তাড়াইল'),
(191, 7, 'Madaripur Sadar', 'মাদারীপুর সদর'),
(192, 7, 'Kalkini', 'কালকিনি'),
(193, 7, 'Rajoir', 'রাজইর'),
(194, 7, 'Shibchar', 'শিবচর'),
(195, 8, 'Manikganj Sadar Upazila', 'মানিকগঞ্জ সদর'),
(196, 8, 'Singair Upazila', 'সিঙ্গাইর'),
(197, 8, 'Shibalaya Upazila', 'শিবালয়'),
(198, 8, 'Saturia Upazila', 'সাঠুরিয়া'),
(199, 8, 'Harirampur Upazila', 'হরিরামপুর'),
(200, 8, 'Ghior Upazila', 'ঘিওর'),
(201, 8, 'Daulatpur Upazila', 'দৌলতপুর'),
(202, 9, 'Lohajang Upazila', 'লোহাজং'),
(203, 9, 'Sreenagar Upazila', 'শ্রীনগর'),
(204, 9, 'Munshiganj Sadar Upazila', 'মুন্সিগঞ্জ সদর'),
(205, 9, 'Sirajdikhan Upazila', 'সিরাজদিখান'),
(206, 9, 'Tongibari Upazila', 'টঙ্গিবাড়ি'),
(207, 9, 'Gazaria Upazila', 'গজারিয়া'),
(208, 10, 'Bhaluka', 'ভালুকা'),
(209, 10, 'Trishal', 'ত্রিশাল'),
(210, 10, 'Haluaghat', 'হালুয়াঘাট'),
(211, 10, 'Muktagachha', 'মুক্তাগাছা'),
(212, 10, 'Dhobaura', 'ধবারুয়া'),
(213, 10, 'Fulbaria', 'ফুলবাড়িয়া'),
(214, 10, 'Gaffargaon', 'গফরগাঁও'),
(215, 10, 'Gauripur', 'গৌরিপুর'),
(216, 10, 'Ishwarganj', 'ঈশ্বরগঞ্জ'),
(217, 10, 'Mymensingh Sadar', 'ময়মনসিং সদর'),
(218, 10, 'Nandail', 'নন্দাইল'),
(219, 10, 'Phulpur', 'ফুলপুর'),
(220, 11, 'Araihazar Upazila', 'আড়াইহাজার'),
(221, 11, 'Sonargaon Upazila', 'সোনারগাঁও'),
(222, 11, 'Bandar', 'বান্দার'),
(223, 11, 'Naryanganj Sadar Upazila', 'নারায়ানগঞ্জ সদর'),
(224, 11, 'Rupganj Upazila', 'রূপগঞ্জ'),
(225, 11, 'Siddirgonj Upazila', 'সিদ্ধিরগঞ্জ'),
(226, 12, 'Belabo Upazila', 'বেলাবো'),
(227, 12, 'Monohardi Upazila', 'মনোহরদি'),
(228, 12, 'Narsingdi Sadar Upazila', 'নরসিংদী সদর'),
(229, 12, 'Palash Upazila', 'পলাশ'),
(230, 12, 'Raipura Upazila, Narsingdi', 'রায়পুর'),
(231, 12, 'Shibpur Upazila', 'শিবপুর'),
(232, 13, 'Kendua Upazilla', 'কেন্দুয়া'),
(233, 13, 'Atpara Upazilla', 'আটপাড়া'),
(234, 13, 'Barhatta Upazilla', 'বরহাট্টা'),
(235, 13, 'Durgapur Upazilla', 'দুর্গাপুর'),
(236, 13, 'Kalmakanda Upazilla', 'কলমাকান্দা'),
(237, 13, 'Madan Upazilla', 'মদন'),
(238, 13, 'Mohanganj Upazilla', 'মোহনগঞ্জ'),
(239, 13, 'Netrakona-S Upazilla', 'নেত্রকোনা সদর'),
(240, 13, 'Purbadhala Upazilla', 'পূর্বধলা'),
(241, 13, 'Khaliajuri Upazilla', 'খালিয়াজুরি'),
(242, 14, 'Baliakandi Upazila', 'বালিয়াকান্দি'),
(243, 14, 'Goalandaghat Upazila', 'গোয়ালন্দ ঘাট'),
(244, 14, 'Pangsha Upazila', 'পাংশা'),
(245, 14, 'Kalukhali Upazila', 'কালুখালি'),
(246, 14, 'Rajbari Sadar Upazila', 'রাজবাড়ি সদর'),
(247, 15, 'Shariatpur Sadar -Palong', 'শরীয়তপুর সদর '),
(248, 15, 'Damudya Upazila', 'দামুদিয়া'),
(249, 15, 'Naria Upazila', 'নড়িয়া'),
(250, 15, 'Jajira Upazila', 'জাজিরা'),
(251, 15, 'Bhedarganj Upazila', 'ভেদারগঞ্জ'),
(252, 15, 'Gosairhat Upazila', 'গোসাইর হাট '),
(253, 16, 'Jhenaigati Upazila', 'ঝিনাইগাতি'),
(254, 16, 'Nakla Upazila', 'নাকলা'),
(255, 16, 'Nalitabari Upazila', 'নালিতাবাড়ি'),
(256, 16, 'Sherpur Sadar Upazila', 'শেরপুর সদর'),
(257, 16, 'Sreebardi Upazila', 'শ্রীবরদি'),
(258, 17, 'Tangail Sadar Upazila', 'টাঙ্গাইল সদর'),
(259, 17, 'Sakhipur Upazila', 'সখিপুর'),
(260, 17, 'Basail Upazila', 'বসাইল'),
(261, 17, 'Madhupur Upazila', 'মধুপুর'),
(262, 17, 'Ghatail Upazila', 'ঘাটাইল'),
(263, 17, 'Kalihati Upazila', 'কালিহাতি'),
(264, 17, 'Nagarpur Upazila', 'নগরপুর'),
(265, 17, 'Mirzapur Upazila', 'মির্জাপুর'),
(266, 17, 'Gopalpur Upazila', 'গোপালপুর'),
(267, 17, 'Delduar Upazila', 'দেলদুয়ার'),
(268, 17, 'Bhuapur Upazila', 'ভুয়াপুর'),
(269, 17, 'Dhanbari Upazila', 'ধানবাড়ি'),
(270, 55, 'Bagerhat Sadar Upazila', 'বাগেরহাট সদর'),
(271, 55, 'Chitalmari Upazila', 'চিতলমাড়ি'),
(272, 55, 'Fakirhat Upazila', 'ফকিরহাট'),
(273, 55, 'Kachua Upazila', 'কচুয়া'),
(274, 55, 'Mollahat Upazila', 'মোল্লাহাট '),
(275, 55, 'Mongla Upazila', 'মংলা'),
(276, 55, 'Morrelganj Upazila', 'মরেলগঞ্জ'),
(277, 55, 'Rampal Upazila', 'রামপাল'),
(278, 55, 'Sarankhola Upazila', 'স্মরণখোলা'),
(279, 56, 'Damurhuda Upazila', 'দামুরহুদা'),
(280, 56, 'Chuadanga-S Upazila', 'চুয়াডাঙ্গা সদর'),
(281, 56, 'Jibannagar Upazila', 'জীবন নগর '),
(282, 56, 'Alamdanga Upazila', 'আলমডাঙ্গা'),
(283, 57, 'Abhaynagar Upazila', 'অভয়নগর'),
(284, 57, 'Keshabpur Upazila', 'কেশবপুর'),
(285, 57, 'Bagherpara Upazila', 'বাঘের পাড়া '),
(286, 57, 'Jessore Sadar Upazila', 'যশোর সদর'),
(287, 57, 'Chaugachha Upazila', 'চৌগাছা'),
(288, 57, 'Manirampur Upazila', 'মনিরামপুর '),
(289, 57, 'Jhikargachha Upazila', 'ঝিকরগাছা'),
(290, 57, 'Sharsha Upazila', 'সারশা'),
(291, 58, 'Jhenaidah Sadar Upazila', 'ঝিনাইদহ সদর'),
(292, 58, 'Maheshpur Upazila', 'মহেশপুর'),
(293, 58, 'Kaliganj Upazila', 'কালীগঞ্জ'),
(294, 58, 'Kotchandpur Upazila', 'কোট চাঁদপুর '),
(295, 58, 'Shailkupa Upazila', 'শৈলকুপা'),
(296, 58, 'Harinakunda Upazila', 'হাড়িনাকুন্দা'),
(297, 59, 'Terokhada Upazila', 'তেরোখাদা'),
(298, 59, 'Batiaghata Upazila', 'বাটিয়াঘাটা '),
(299, 59, 'Dacope Upazila', 'ডাকপে'),
(300, 59, 'Dumuria Upazila', 'ডুমুরিয়া'),
(301, 59, 'Dighalia Upazila', 'দিঘলিয়া'),
(302, 59, 'Koyra Upazila', 'কয়ড়া'),
(303, 59, 'Paikgachha Upazila', 'পাইকগাছা'),
(304, 59, 'Phultala Upazila', 'ফুলতলা'),
(305, 59, 'Rupsa Upazila', 'রূপসা'),
(306, 60, 'Kushtia Sadar', 'কুষ্টিয়া সদর'),
(307, 60, 'Kumarkhali', 'কুমারখালি'),
(308, 60, 'Daulatpur', 'দৌলতপুর'),
(309, 60, 'Mirpur', 'মিরপুর'),
(310, 60, 'Bheramara', 'ভেরামারা'),
(311, 60, 'Khoksa', 'খোকসা'),
(312, 61, 'Magura Sadar Upazila', 'মাগুরা সদর'),
(313, 61, 'Mohammadpur Upazila', 'মোহাম্মাদপুর'),
(314, 61, 'Shalikha Upazila', 'শালিখা'),
(315, 61, 'Sreepur Upazila', 'শ্রীপুর'),
(316, 62, 'angni Upazila', 'আংনি'),
(317, 62, 'Mujib Nagar Upazila', 'মুজিব নগর'),
(318, 62, 'Meherpur-S Upazila', 'মেহেরপুর সদর'),
(319, 63, 'Narail-S Upazilla', 'নড়াইল সদর'),
(320, 63, 'Lohagara Upazilla', 'লোহাগাড়া'),
(321, 63, 'Kalia Upazilla', 'কালিয়া'),
(322, 64, 'Satkhira Sadar Upazila', 'সাতক্ষীরা সদর'),
(323, 64, 'Assasuni Upazila', 'আসসাশুনি '),
(324, 64, 'Debhata Upazila', 'দেভাটা'),
(325, 64, 'Tala Upazila', 'তালা'),
(326, 64, 'Kalaroa Upazila', 'কলরোয়া'),
(327, 64, 'Kaliganj Upazila', 'কালীগঞ্জ'),
(328, 64, 'Shyamnagar Upazila', 'শ্যামনগর'),
(329, 18, 'Adamdighi', 'আদমদিঘী'),
(330, 18, 'Bogra Sadar', 'বগুড়া সদর'),
(331, 18, 'Sherpur', 'শেরপুর'),
(332, 18, 'Dhunat', 'ধুনট'),
(333, 18, 'Dhupchanchia', 'দুপচাচিয়া'),
(334, 18, 'Gabtali', 'গাবতলি'),
(335, 18, 'Kahaloo', 'কাহালু'),
(336, 18, 'Nandigram', 'নন্দিগ্রাম'),
(337, 18, 'Sahajanpur', 'শাহজাহানপুর'),
(338, 18, 'Sariakandi', 'সারিয়াকান্দি'),
(339, 18, 'Shibganj', 'শিবগঞ্জ'),
(340, 18, 'Sonatala', 'সোনাতলা'),
(341, 19, 'Joypurhat S', 'জয়পুরহাট সদর'),
(342, 19, 'Akkelpur', 'আক্কেলপুর'),
(343, 19, 'Kalai', 'কালাই'),
(344, 19, 'Khetlal', 'খেতলাল'),
(345, 19, 'Panchbibi', 'পাঁচবিবি'),
(346, 20, 'Naogaon Sadar Upazila', 'নওগাঁ সদর'),
(347, 20, 'Mohadevpur Upazila', 'মহাদেবপুর'),
(348, 20, 'Manda Upazila', 'মান্দা'),
(349, 20, 'Niamatpur Upazila', 'নিয়ামতপুর'),
(350, 20, 'Atrai Upazila', 'আত্রাই'),
(351, 20, 'Raninagar Upazila', 'রাণীনগর'),
(352, 20, 'Patnitala Upazila', 'পত্নীতলা'),
(353, 20, 'Dhamoirhat Upazila', 'ধামইরহাট '),
(354, 20, 'Sapahar Upazila', 'সাপাহার'),
(355, 20, 'Porsha Upazila', 'পোরশা'),
(356, 20, 'Badalgachhi Upazila', 'বদলগাছি'),
(357, 21, 'Natore Sadar Upazila', 'নাটোর সদর'),
(358, 21, 'Baraigram Upazila', 'বড়াইগ্রাম'),
(359, 21, 'Bagatipara Upazila', 'বাগাতিপাড়া'),
(360, 21, 'Lalpur Upazila', 'লালপুর'),
(361, 21, 'Natore Sadar Upazila', 'নাটোর সদর'),
(362, 21, 'Baraigram Upazila', 'বড়াই গ্রাম'),
(363, 22, 'Bholahat Upazila', 'ভোলাহাট'),
(364, 22, 'Gomastapur Upazila', 'গোমস্তাপুর'),
(365, 22, 'Nachole Upazila', 'নাচোল'),
(366, 22, 'Nawabganj Sadar Upazila', 'নবাবগঞ্জ সদর'),
(367, 22, 'Shibganj Upazila', 'শিবগঞ্জ'),
(368, 23, 'Atgharia Upazila', 'আটঘরিয়া'),
(369, 23, 'Bera Upazila', 'বেড়া'),
(370, 23, 'Bhangura Upazila', 'ভাঙ্গুরা'),
(371, 23, 'Chatmohar Upazila', 'চাটমোহর'),
(372, 23, 'Faridpur Upazila', 'ফরিদপুর'),
(373, 23, 'Ishwardi Upazila', 'ঈশ্বরদী'),
(374, 23, 'Pabna Sadar Upazila', 'পাবনা সদর'),
(375, 23, 'Santhia Upazila', 'সাথিয়া'),
(376, 23, 'Sujanagar Upazila', 'সুজানগর'),
(377, 24, 'Bagha', 'বাঘা'),
(378, 24, 'Bagmara', 'বাগমারা'),
(379, 24, 'Charghat', 'চারঘাট'),
(380, 24, 'Durgapur', 'দুর্গাপুর'),
(381, 24, 'Godagari', 'গোদাগারি'),
(382, 24, 'Mohanpur', 'মোহনপুর'),
(383, 24, 'Paba', 'পবা'),
(384, 24, 'Puthia', 'পুঠিয়া'),
(385, 24, 'Tanore', 'তানোর'),
(386, 25, 'Sirajganj Sadar Upazila', 'সিরাজগঞ্জ সদর'),
(387, 25, 'Belkuchi Upazila', 'বেলকুচি'),
(388, 25, 'Chauhali Upazila', 'চৌহালি'),
(389, 25, 'Kamarkhanda Upazila', 'কামারখান্দা'),
(390, 25, 'Kazipur Upazila', 'কাজীপুর'),
(391, 25, 'Raiganj Upazila', 'রায়গঞ্জ'),
(392, 25, 'Shahjadpur Upazila', 'শাহজাদপুর'),
(393, 25, 'Tarash Upazila', 'তারাশ'),
(394, 25, 'Ullahpara Upazila', 'উল্লাপাড়া'),
(395, 26, 'Birampur Upazila', 'বিরামপুর'),
(396, 26, 'Birganj', 'বীরগঞ্জ'),
(397, 26, 'Biral Upazila', 'বিড়াল'),
(398, 26, 'Bochaganj Upazila', 'বোচাগঞ্জ'),
(399, 26, 'Chirirbandar Upazila', 'চিরিরবন্দর'),
(400, 26, 'Phulbari Upazila', 'ফুলবাড়ি'),
(401, 26, 'Ghoraghat Upazila', 'ঘোড়াঘাট'),
(402, 26, 'Hakimpur Upazila', 'হাকিমপুর'),
(403, 26, 'Kaharole Upazila', 'কাহারোল'),
(404, 26, 'Khansama Upazila', 'খানসামা'),
(405, 26, 'Dinajpur Sadar Upazila', 'দিনাজপুর সদর'),
(406, 26, 'Nawabganj', 'নবাবগঞ্জ'),
(407, 26, 'Parbatipur Upazila', 'পার্বতীপুর'),
(408, 27, 'Fulchhari', 'ফুলছড়ি'),
(409, 27, 'Gaibandha sadar', 'গাইবান্ধা সদর'),
(410, 27, 'Gobindaganj', 'গোবিন্দগঞ্জ'),
(411, 27, 'Palashbari', 'পলাশবাড়ী'),
(412, 27, 'Sadullapur', 'সাদুল্যাপুর'),
(413, 27, 'Saghata', 'সাঘাটা'),
(414, 27, 'Sundarganj', 'সুন্দরগঞ্জ'),
(415, 28, 'Kurigram Sadar', 'কুড়িগ্রাম সদর'),
(416, 28, 'Nageshwari', 'নাগেশ্বরী'),
(417, 28, 'Bhurungamari', 'ভুরুঙ্গামারি'),
(418, 28, 'Phulbari', 'ফুলবাড়ি'),
(419, 28, 'Rajarhat', 'রাজারহাট'),
(420, 28, 'Ulipur', 'উলিপুর'),
(421, 28, 'Chilmari', 'চিলমারি'),
(422, 28, 'Rowmari', 'রউমারি'),
(423, 28, 'Char Rajibpur', 'চর রাজিবপুর'),
(424, 29, 'Lalmanirhat Sadar', 'লালমনিরহাট সদর'),
(425, 29, 'Aditmari', 'আদিতমারি'),
(426, 29, 'Kaliganj', 'কালীগঞ্জ'),
(427, 29, 'Hatibandha', 'হাতিবান্ধা'),
(428, 29, 'Patgram', 'পাটগ্রাম'),
(429, 30, 'Nilphamari Sadar', 'নীলফামারী সদর'),
(430, 30, 'Saidpur', 'সৈয়দপুর'),
(431, 30, 'Jaldhaka', 'জলঢাকা'),
(432, 30, 'Kishoreganj', 'কিশোরগঞ্জ'),
(433, 30, 'Domar', 'ডোমার'),
(434, 30, 'Dimla', 'ডিমলা'),
(435, 31, 'Panchagarh Sadar', 'পঞ্চগড় সদর'),
(436, 31, 'Debiganj', 'দেবীগঞ্জ'),
(437, 31, 'Boda', 'বোদা'),
(438, 31, 'Atwari', 'আটোয়ারি'),
(439, 31, 'Tetulia', 'তেতুলিয়া'),
(440, 32, 'Badarganj', 'বদরগঞ্জ'),
(441, 32, 'Mithapukur', 'মিঠাপুকুর'),
(442, 32, 'Gangachara', 'গঙ্গাচরা'),
(443, 32, 'Kaunia', 'কাউনিয়া'),
(444, 32, 'Rangpur Sadar', 'রংপুর সদর'),
(445, 32, 'Pirgachha', 'পীরগাছা'),
(446, 32, 'Pirganj', 'পীরগঞ্জ'),
(447, 32, 'Taraganj', 'তারাগঞ্জ'),
(448, 33, 'Thakurgaon Sadar Upazila', 'ঠাকুরগাঁও সদর'),
(449, 33, 'Pirganj Upazila', 'পীরগঞ্জ'),
(450, 33, 'Baliadangi Upazila', 'বালিয়াডাঙ্গি'),
(451, 33, 'Haripur Upazila', 'হরিপুর'),
(452, 33, 'Ranisankail Upazila', 'রাণীসংকইল'),
(453, 51, 'Ajmiriganj', 'আজমিরিগঞ্জ'),
(454, 51, 'Baniachang', 'বানিয়াচং'),
(455, 51, 'Bahubal', 'বাহুবল'),
(456, 51, 'Chunarughat', 'চুনারুঘাট'),
(457, 51, 'Habiganj Sadar', 'হবিগঞ্জ সদর'),
(458, 51, 'Lakhai', 'লাক্ষাই'),
(459, 51, 'Madhabpur', 'মাধবপুর'),
(460, 51, 'Nabiganj', 'নবীগঞ্জ'),
(461, 51, 'Shaistagonj Upazila', 'শায়েস্তাগঞ্জ'),
(462, 52, 'Moulvibazar Sadar', 'মৌলভীবাজার'),
(463, 52, 'Barlekha', 'বড়লেখা'),
(464, 52, 'Juri', 'জুড়ি'),
(465, 52, 'Kamalganj', 'কামালগঞ্জ'),
(466, 52, 'Kulaura', 'কুলাউরা'),
(467, 52, 'Rajnagar', 'রাজনগর'),
(468, 52, 'Sreemangal', 'শ্রীমঙ্গল'),
(469, 53, 'Bishwamvarpur', 'বিসশম্ভারপুর'),
(470, 53, 'Chhatak', 'ছাতক'),
(471, 53, 'Derai', 'দেড়াই'),
(472, 53, 'Dharampasha', 'ধরমপাশা'),
(473, 53, 'Dowarabazar', 'দোয়ারাবাজার'),
(474, 53, 'Jagannathpur', 'জগন্নাথপুর'),
(475, 53, 'Jamalganj', 'জামালগঞ্জ'),
(476, 53, 'Sulla', 'সুল্লা'),
(477, 53, 'Sunamganj Sadar', 'সুনামগঞ্জ সদর'),
(478, 53, 'Shanthiganj', 'শান্তিগঞ্জ'),
(479, 53, 'Tahirpur', 'তাহিরপুর'),
(480, 54, 'Sylhet Sadar', 'সিলেট সদর'),
(481, 54, 'Beanibazar', 'বেয়ানিবাজার'),
(482, 54, 'Bishwanath', 'বিশ্বনাথ'),
(483, 54, 'Dakshin Surma Upazila', 'দক্ষিণ সুরমা'),
(484, 54, 'Balaganj', 'বালাগঞ্জ'),
(485, 54, 'Companiganj', 'কোম্পানিগঞ্জ'),
(486, 54, 'Fenchuganj', 'ফেঞ্চুগঞ্জ'),
(487, 54, 'Golapganj', 'গোলাপগঞ্জ'),
(488, 54, 'Gowainghat', 'গোয়াইনঘাট'),
(489, 54, 'Jaintiapur', 'জয়ন্তপুর'),
(490, 54, 'Kanaighat', 'কানাইঘাট'),
(491, 54, 'Zakiganj', 'জাকিগঞ্জ'),
(492, 54, 'Nobigonj', 'নবীগঞ্জ');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `vehicleName` varchar(100) NOT NULL,
  `vehicleModel` varchar(100) NOT NULL,
  `chassisNumber` varchar(50) NOT NULL,
  `numberPlate` varchar(50) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  `updatedBy` int(11) NOT NULL,
  `isActive` enum('Y','N') NOT NULL,
  `isDelete` enum('Y','N') NOT NULL,
  `deletedBy` tinyint(4) NOT NULL,
  `deletedAt` timestamp(4) NOT NULL DEFAULT '0000-00-00 00:00:00.0000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicleName`, `vehicleModel`, `chassisNumber`, `numberPlate`, `dist_id`, `createdAt`, `updatedAt`, `createdBy`, `updatedBy`, `isActive`, `isDelete`, `deletedBy`, `deletedAt`) VALUES
(1, 'Car', '0007', '000523', 'ABC-0063', 2, '2019-03-20 04:57:26', '0000-00-00 00:00:00', 2, 0, 'Y', 'N', 0, '0000-00-00 00:00:00.0000');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zone_id` int(11) NOT NULL,
  `zone_title` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `divisionId` int(11) NOT NULL,
  `districtId` int(11) NOT NULL,
  `thanaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zone_id`, `zone_title`, `created_by`, `divisionId`, `districtId`, `thanaId`) VALUES
(1, 'Dhaka Division', 0, 3, 2, 150),
(2, 'Gazipur Zone', 0, 3, 3, 160),
(3, 'Syleth Zone', 0, 7, 52, 463),
(4, '8200', 0, 1, 39, 37),
(5, 'Savar', 0, 3, 1, 149),
(6, 'Cumilla', 0, 2, 44, 96);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `adminloghistory`
--
ALTER TABLE `adminloghistory`
  ADD PRIMARY KEY (`logId`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`admin_role_id`);

--
-- Indexes for table `blood_group`
--
ALTER TABLE `blood_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brandId`);

--
-- Indexes for table `chartofaccount`
--
ALTER TABLE `chartofaccount`
  ADD PRIMARY KEY (`chart_id`);

--
-- Indexes for table `client_vendor_ledger`
--
ALTER TABLE `client_vendor_ledger`
  ADD PRIMARY KEY (`ledger_id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`colorID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customertype`
--
ALTER TABLE `customertype`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `generaldata`
--
ALTER TABLE `generaldata`
  ADD PRIMARY KEY (`generalId`);

--
-- Indexes for table `generalledger`
--
ALTER TABLE `generalledger`
  ADD PRIMARY KEY (`generalledger_id`);

--
-- Indexes for table `generals`
--
ALTER TABLE `generals`
  ADD PRIMARY KEY (`generals_id`);

--
-- Indexes for table `incentive`
--
ALTER TABLE `incentive`
  ADD PRIMARY KEY (`incentive_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgId`);

--
-- Indexes for table `messageuser`
--
ALTER TABLE `messageuser`
  ADD PRIMARY KEY (`msgUserid`);

--
-- Indexes for table `moneyreceit`
--
ALTER TABLE `moneyreceit`
  ADD PRIMARY KEY (`moneyReceitid`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`navigation_id`);

--
-- Indexes for table `newdecision`
--
ALTER TABLE `newdecision`
  ADD PRIMARY KEY (`newDecisionId`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offerId`);

--
-- Indexes for table `opening_balance`
--
ALTER TABLE `opening_balance`
  ADD PRIMARY KEY (`opening_balance_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `package_products`
--
ALTER TABLE `package_products`
  ADD PRIMARY KEY (`package_products_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `productimport`
--
ALTER TABLE `productimport`
  ADD PRIMARY KEY (`importId`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `purchase_demo`
--
ALTER TABLE `purchase_demo`
  ADD PRIMARY KEY (`purchase_demo_id`);

--
-- Indexes for table `purchase_invoice_info`
--
ALTER TABLE `purchase_invoice_info`
  ADD PRIMARY KEY (`purchase_invoice_id`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`reference_id`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retainearning`
--
ALTER TABLE `retainearning`
  ADD PRIMARY KEY (`retainid`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `system_config`
--
ALTER TABLE `system_config`
  ADD PRIMARY KEY (`configId`);

--
-- Indexes for table `tablecustomer`
--
ALTER TABLE `tablecustomer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_decision`
--
ALTER TABLE `tbl_decision`
  ADD PRIMARY KEY (`decision_id`);

--
-- Indexes for table `tbl_distributor`
--
ALTER TABLE `tbl_distributor`
  ADD PRIMARY KEY (`dist_id`);

--
-- Indexes for table `unions`
--
ALTER TABLE `unions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upazila_id` (`upazila_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `upazilas`
--
ALTER TABLE `upazilas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zone_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `adminloghistory`
--
ALTER TABLE `adminloghistory`
  MODIFY `logId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `admin_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=414;

--
-- AUTO_INCREMENT for table `blood_group`
--
ALTER TABLE `blood_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brandId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `chartofaccount`
--
ALTER TABLE `chartofaccount`
  MODIFY `chart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- AUTO_INCREMENT for table `client_vendor_ledger`
--
ALTER TABLE `client_vendor_ledger`
  MODIFY `ledger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `colorID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customertype`
--
ALTER TABLE `customertype`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `generaldata`
--
ALTER TABLE `generaldata`
  MODIFY `generalId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `generalledger`
--
ALTER TABLE `generalledger`
  MODIFY `generalledger_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `generals`
--
ALTER TABLE `generals`
  MODIFY `generals_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `incentive`
--
ALTER TABLE `incentive`
  MODIFY `incentive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messageuser`
--
ALTER TABLE `messageuser`
  MODIFY `msgUserid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moneyreceit`
--
ALTER TABLE `moneyreceit`
  MODIFY `moneyReceitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `navigation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `newdecision`
--
ALTER TABLE `newdecision`
  MODIFY `newDecisionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offerId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opening_balance`
--
ALTER TABLE `opening_balance`
  MODIFY `opening_balance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `package_products`
--
ALTER TABLE `package_products`
  MODIFY `package_products_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productimport`
--
ALTER TABLE `productimport`
  MODIFY `importId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_demo`
--
ALTER TABLE `purchase_demo`
  MODIFY `purchase_demo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_invoice_info`
--
ALTER TABLE `purchase_invoice_info`
  MODIFY `purchase_invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `reference_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `retainearning`
--
ALTER TABLE `retainearning`
  MODIFY `retainid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_config`
--
ALTER TABLE `system_config`
  MODIFY `configId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tablecustomer`
--
ALTER TABLE `tablecustomer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_decision`
--
ALTER TABLE `tbl_decision`
  MODIFY `decision_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_distributor`
--
ALTER TABLE `tbl_distributor`
  MODIFY `dist_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unions`
--
ALTER TABLE `unions`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2351;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `upazilas`
--
ALTER TABLE `upazilas`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=493;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unions`
--
ALTER TABLE `unions`
  ADD CONSTRAINT `unions_ibfk_1` FOREIGN KEY (`upazila_id`) REFERENCES `upazilas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `upazilas`
--
ALTER TABLE `upazilas`
  ADD CONSTRAINT `upazilas_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;