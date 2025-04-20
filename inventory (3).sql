-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 09:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `emp_user`
--

CREATE TABLE `emp_user` (
  `EMP_ID` int(11) NOT NULL,
  `EMP_NAME` varchar(100) NOT NULL,
  `EMP_ACTIVE` tinyint(1) DEFAULT 1,
  `EMP_SCALE` varchar(50) DEFAULT NULL,
  `EMP_DESIG` varchar(50) DEFAULT NULL,
  `EMP_DESIGNATION` varchar(100) DEFAULT NULL,
  `EMP_DEPT` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_user`
--

INSERT INTO `emp_user` (`EMP_ID`, `EMP_NAME`, `EMP_ACTIVE`, `EMP_SCALE`, `EMP_DESIG`, `EMP_DESIGNATION`, `EMP_DEPT`) VALUES
(1, 'sanjeet', 1, '4', 'executive', 'executive', 'it'),
(2, 'saurab', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `serial_no`, `location`) VALUES
(1, 'Laptop', 'SN12345', 'Room A'),
(2, 'Monitor', 'SN54321', 'Room B');

-- --------------------------------------------------------

--
-- Table structure for table `keyboard`
--

CREATE TABLE `keyboard` (
  `id` int(11) NOT NULL,
  `model` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monitor`
--

CREATE TABLE `monitor` (
  `id` int(11) NOT NULL,
  `model` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pc`
--

CREATE TABLE `pc` (
  `id` int(11) NOT NULL,
  `VENDOR_NAME` varchar(100) DEFAULT NULL,
  `INVOICE_NO` varchar(100) DEFAULT NULL,
  `BILL_DATE` date DEFAULT NULL,
  `SN` varchar(100) DEFAULT NULL,
  `OUTSTATION` varchar(100) DEFAULT NULL,
  `DESKTOP_PC_MODEL` varchar(100) DEFAULT NULL,
  `RAM_SIZE` varchar(50) DEFAULT NULL,
  `ROM_SIZE` varchar(50) DEFAULT NULL,
  `PC_SERIAL_NUMBER` varchar(100) DEFAULT NULL,
  `CORRECT_SERIAL_NUMBER` varchar(100) DEFAULT NULL,
  `INVENTORY` varchar(100) DEFAULT NULL,
  `WORKSTATION` varchar(100) DEFAULT NULL,
  `USERNAME` varchar(100) DEFAULT NULL,
  `FLOOR_NUMBER` varchar(50) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `VERIFIED` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc`
--

INSERT INTO `pc` (`id`, `VENDOR_NAME`, `INVOICE_NO`, `BILL_DATE`, `SN`, `OUTSTATION`, `DESKTOP_PC_MODEL`, `RAM_SIZE`, `ROM_SIZE`, `PC_SERIAL_NUMBER`, `CORRECT_SERIAL_NUMBER`, `INVENTORY`, `WORKSTATION`, `USERNAME`, `FLOOR_NUMBER`, `USER_ID`, `VERIFIED`) VALUES
(18, 'asda', 'sd', '0000-00-00', 'asdas', 'asd', 'asd', 'sad', 'asd', 'asd', '', '', '', '', '', 1, 0),
(20, 'adsf', 'dsaf', '0000-00-00', 'adsf', 'asd', 'adsf', 'adsf', 'adsf', 'adsf', '', 'sa', 'sa', 'sa', 'sa', 1, 0),
(25, 'sdfsw', 'wedcg', '2025-04-09', 'sdf', 'sdfw', 'dsfvw', 'sdf', 'sd', 'sd', 'dfsw', 'sdgv', 'sdgvsw', 'swgdb', 'swg', NULL, 0),
(26, 'adfasf', 'casfa', '2025-04-23', 'aezwa', 'DSF', 'adra', 'agfrbva', 'argf', 'afgrva', 'szfgbaz', 'szfb', '', 'dxfbs', '', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pc_edit_log`
--

CREATE TABLE `pc_edit_log` (
  `id` int(11) NOT NULL,
  `pc_id` int(11) NOT NULL,
  `edited_by` varchar(255) DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  `old_data` text DEFAULT NULL,
  `new_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pc_edit_log`
--

INSERT INTO `pc_edit_log` (`id`, `pc_id`, `edited_by`, `edit_time`, `old_data`, `new_data`) VALUES
(1, 1, 'admin', '2025-04-10 21:33:12', NULL, NULL),
(2, 1, 'admin', '2025-04-10 21:36:50', NULL, NULL),
(3, 1, 'admin', '2025-04-10 21:41:34', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"hero\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"hero\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}'),
(4, 1, 'admin', '2025-04-10 21:41:43', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"hero\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"pintu\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}'),
(5, 1, 'admin', '2025-04-10 21:53:18', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"pintu\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}'),
(6, 1, 'admin', '2025-04-10 21:53:29', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-566\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"5th\",\"USER_ID\":\"1000000\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-5689\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\"}'),
(7, 2, 'admin', '2025-04-14 16:37:25', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}'),
(8, 2, 'admin', '2025-04-14 23:41:33', '{\"id\":\"2\",\"VENDOR_NAME\":\"\",\"INVOICE_NO\":\"\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"\",\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"\",\"RAM_SIZE\":\"\",\"ROM_SIZE\":\"\",\"PC_SERIAL_NUMBER\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"deleted\":true}'),
(9, 3, 'admin', '2025-04-14 23:41:36', '{\"id\":\"3\",\"VENDOR_NAME\":\"\",\"INVOICE_NO\":\"\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"\",\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"\",\"RAM_SIZE\":\"\",\"ROM_SIZE\":\"\",\"PC_SERIAL_NUMBER\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"deleted\":true}'),
(10, 4, 'admin', '2025-04-15 07:39:24', '{\"id\":\"4\",\"VENDOR_NAME\":\"\",\"INVOICE_NO\":\"\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"\",\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"\",\"RAM_SIZE\":\"\",\"ROM_SIZE\":\"\",\"PC_SERIAL_NUMBER\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"deleted\":true}'),
(11, 5, 'admin', '2025-04-15 19:54:50', '{\"id\":\"5\",\"VENDOR_NAME\":\"f\",\"INVOICE_NO\":\"dr\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"fyhju\",\"OUTSTATION\":\"fuju\",\"DESKTOP_PC_MODEL\":\"ftgu\",\"RAM_SIZE\":\"fgtuj\",\"ROM_SIZE\":\"fgtuj\",\"PC_SERIAL_NUMBER\":\"tfrju\",\"CORRECT_SERIAL_NUMBER\":\"ftguj\",\"INVENTORY\":\"uj\",\"WORKSTATION\":\"ftguj\",\"USERNAME\":\"fguj\",\"FLOOR_NUMBER\":\"juyt\",\"USER_ID\":\"\"}', '{\"id\":\"5\",\"VENDOR_NAME\":\"f\",\"INVOICE_NO\":\"dr\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"fyhju\",\"OUTSTATION\":\"fuju\",\"DESKTOP_PC_MODEL\":\"ftgu\",\"RAM_SIZE\":\"fgtuj\",\"ROM_SIZE\":\"fgtuj\",\"PC_SERIAL_NUMBER\":\"tfrju\",\"CORRECT_SERIAL_NUMBER\":\"ftguj\",\"INVENTORY\":\"uj\",\"WORKSTATION\":\"ftguj\",\"USERNAME\":\"fguj\",\"FLOOR_NUMBER\":\"juyt\",\"USER_ID\":\"\",\"workstation\":null,\"username\":null,\"floor_number\":null}'),
(12, 8, 'admin', '2025-04-15 20:03:42', '{\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"dsfgsd\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}'),
(13, 8, 'admin', '2025-04-15 20:04:11', '{\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"dsfgsd\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awdaw\",\"WORKSTATION\":\"waqe\",\"USERNAME\":\"dsfgsd\",\"FLOOR_NUMBER\":\"eewqw\",\"USER_ID\":\"aqewd\"}'),
(14, 7, 'admin', '2025-04-16 06:42:29', '{\"id\":\"7\",\"VENDOR_NAME\":\"aewrfews\",\"INVOICE_NO\":\"s\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"gbsd\",\"OUTSTATION\":\"gbsdgv\",\"DESKTOP_PC_MODEL\":\"sdfgv\",\"RAM_SIZE\":\"sfv\",\"ROM_SIZE\":\"sefs\",\"PC_SERIAL_NUMBER\":\"sfre\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\"}', '{\"id\":\"7\",\"VENDOR_NAME\":\"aewrfews\",\"INVOICE_NO\":\"s\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"gbsd\",\"OUTSTATION\":\"gbsdgv\",\"DESKTOP_PC_MODEL\":\"sdfgv\",\"RAM_SIZE\":\"sfv\",\"ROM_SIZE\":\"sefs\",\"PC_SERIAL_NUMBER\":\"sfre\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\",\"workstation\":null,\"username\":null,\"floor_number\":null}'),
(15, 8, 'admin', '2025-04-16 06:42:38', '{\"id\":\"8\",\"VENDOR_NAME\":\"esfgsetwg\",\"INVOICE_NO\":\"wdegsw\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"sdes\",\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"RAM_SIZE\":\"swdesw\",\"ROM_SIZE\":\"des\",\"PC_SERIAL_NUMBER\":\"sdgfvs\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awdaw\",\"WORKSTATION\":\"waqe\",\"USERNAME\":\"dsfgsd\",\"FLOOR_NUMBER\":\"eewqw\",\"USER_ID\":\"aqewd\"}', '{\"id\":\"8\",\"VENDOR_NAME\":\"esfgsetwg\",\"INVOICE_NO\":\"wdegsw\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"sdes\",\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"RAM_SIZE\":\"swdesw\",\"ROM_SIZE\":\"des\",\"PC_SERIAL_NUMBER\":\"sdgfvs\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awdaw\",\"WORKSTATION\":\"waqe\",\"USERNAME\":\"dsfgsd\",\"FLOOR_NUMBER\":\"eewqw\",\"USER_ID\":\"aqewd\",\"workstation\":null,\"username\":null,\"floor_number\":null}'),
(16, 8, 'admin', '2025-04-16 06:45:43', '{\"id\":\"8\",\"VENDOR_NAME\":\"esfgsetwg\",\"INVOICE_NO\":\"wdegsw\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"sdes\",\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"RAM_SIZE\":\"swdesw\",\"ROM_SIZE\":\"des\",\"PC_SERIAL_NUMBER\":\"sdgfvs\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awdaw\",\"WORKSTATION\":null,\"USERNAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":\"aqewd\"}', '{\"id\":\"8\",\"VENDOR_NAME\":\"esfgsetwg\",\"INVOICE_NO\":\"wdegsw\",\"BILL_DATE\":\"0000-00-00\",\"SN\":\"sdes\",\"OUTSTATION\":\"wesde\",\"DESKTOP_PC_MODEL\":\"swde\",\"RAM_SIZE\":\"swdesw\",\"ROM_SIZE\":\"des\",\"PC_SERIAL_NUMBER\":\"sdgfvs\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awdaw\",\"WORKSTATION\":null,\"USERNAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":\"aqewd\",\"workstation\":\"DELETED\",\"username\":\"DELETED\",\"floor_number\":\"DELETED\",\"user_id\":\"DELETED\"}'),
(17, 1, 'admin', '2025-04-16 06:55:00', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-5689\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\"}'),
(18, 1, 'admin', '2025-04-16 07:09:01', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\",\"verified\":\"0\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\",\"verified\":1}'),
(19, 1, 'admin', '2025-04-16 07:11:22', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\",\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\",\"VERIFIED\":0}'),
(20, 1, 'admin', '2025-04-16 07:11:25', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"\",\"DESKTOP_PC_MODEL\":\"hp victus\",\"CORRECT_SERIAL_NUMBER\":\"14555\",\"INVENTORY\":\"\",\"WORKSTATION\":\"B-568\",\"USERNAME\":\"sanjeet\",\"FLOOR_NUMBER\":\"7th\",\"USER_ID\":\"1000000\",\"VERIFIED\":1}'),
(21, 5, 'admin', '2025-04-16 07:15:34', '{\"OUTSTATION\":\"fuju\",\"DESKTOP_PC_MODEL\":\"ftgu\",\"CORRECT_SERIAL_NUMBER\":\"ftguj\",\"INVENTORY\":\"uj\",\"WORKSTATION\":null,\"USERNAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":\"\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"fuju\",\"DESKTOP_PC_MODEL\":\"ftgu\",\"CORRECT_SERIAL_NUMBER\":\"ftguj\",\"INVENTORY\":\"uj\",\"WORKSTATION\":\"hero\",\"USERNAME\":\"hero\",\"FLOOR_NUMBER\":\"3\",\"USER_ID\":\"10025\",\"VERIFIED\":1}'),
(22, 18, 'admin', '2025-04-16 21:37:27', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"asd\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"asd\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":1}'),
(23, 18, 'admin', '2025-04-16 21:37:40', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"asd\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"asd\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":0}'),
(24, 20, 'user1', '2025-04-20 09:29:44', '{\"OUTSTATION\":\"asdf\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asdf\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}'),
(25, 26, 'user1', '2025-04-20 09:29:50', '{\"OUTSTATION\":\"DSF\",\"DESKTOP_PC_MODEL\":\"adra\",\"CORRECT_SERIAL_NUMBER\":\"szfgbaz\",\"INVENTORY\":\"szfb\",\"WORKSTATION\":null,\"USERNAME\":\"dxfbs\",\"FLOOR_NUMBER\":null,\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"DSF\",\"DESKTOP_PC_MODEL\":\"adra\",\"CORRECT_SERIAL_NUMBER\":\"szfgbaz\",\"INVENTORY\":\"szfb\",\"WORKSTATION\":\"\",\"USERNAME\":\"dxfbs\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}'),
(26, 20, 'admin', '2025-04-20 09:33:18', '{\"OUTSTATION\":\"asdf\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asdf\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"2\",\"VERIFIED\":1}'),
(27, 20, 'user1', '2025-04-20 09:34:03', '{\"OUTSTATION\":\"asdf\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"2\",\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"2\",\"VERIFIED\":\"1\"}'),
(28, 2, 'admin', '2025-04-20 11:36:49', '{\"OUTSTATION\":null,\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":null,\"INVENTORY\":null,\"WORKSTATION\":null,\"USER_NAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"awe\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(29, 2, 'admin', '2025-04-20 11:37:01', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"awe\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(30, 2, 'admin', '2025-04-20 11:37:15', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(31, 5, 'admin', '2025-04-20 11:38:09', '{\"OUTSTATION\":null,\"PRINTER_MODEL\":\"esr\",\"CORRECT_SERIAL_NUMBER\":null,\"INVENTORY\":null,\"WORKSTATION\":null,\"USER_NAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"aer\",\"PRINTER_MODEL\":\"esr\",\"CORRECT_SERIAL_NUMBER\":\"aret\",\"INVENTORY\":\"aert\",\"WORKSTATION\":\"sret\",\"USER_NAME\":\"sret\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":0}'),
(32, 4, 'admin', '2025-04-20 11:38:36', '{\"OUTSTATION\":\"awerd\",\"PRINTER_MODEL\":null,\"CORRECT_SERIAL_NUMBER\":null,\"INVENTORY\":null,\"WORKSTATION\":null,\"USER_NAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"awerd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awd\",\"WORKSTATION\":\"as\",\"USER_NAME\":\"daw\",\"FLOOR_NUMBER\":\"daw\",\"USER_ID\":\"1\",\"VERIFIED\":0}'),
(33, 3, 'admin', '2025-04-20 11:43:46', '{\"OUTSTATION\":null,\"PRINTER_MODEL\":\"aecfaW\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":null,\"WORKSTATION\":null,\"USER_NAME\":null,\"FLOOR_NUMBER\":null,\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":null,\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asd\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(34, 3, 'admin', '2025-04-20 11:44:04', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":null,\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asd\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":null,\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asd\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(35, 26, 'admin', '2025-04-20 11:44:25', '{\"OUTSTATION\":\"DSF\",\"DESKTOP_PC_MODEL\":\"adra\",\"CORRECT_SERIAL_NUMBER\":\"szfgbaz\",\"INVENTORY\":\"szfb\",\"WORKSTATION\":\"\",\"USERNAME\":\"dxfbs\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"DSF\",\"DESKTOP_PC_MODEL\":\"adra\",\"CORRECT_SERIAL_NUMBER\":\"szfgbaz\",\"INVENTORY\":\"szfb\",\"WORKSTATION\":\"\",\"USERNAME\":\"dxfbs\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":0}'),
(36, 3, 'admin', '2025-04-20 11:48:34', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":null,\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asd\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(37, 3, 'admin', '2025-04-20 11:51:09', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"\",\"VERIFIED\":0}'),
(38, 4, 'admin', '2025-04-20 11:51:16', '{\"OUTSTATION\":\"awerd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awd\",\"WORKSTATION\":\"as\",\"USER_NAME\":\"daw\",\"FLOOR_NUMBER\":\"daw\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"awerd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"awd\",\"WORKSTATION\":\"as\",\"USER_NAME\":\"daw\",\"FLOOR_NUMBER\":\"daw\",\"USER_ID\":\"\",\"VERIFIED\":0}'),
(39, 3, 'admin', '2025-04-20 11:52:22', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"\",\"VERIFIED\":1}'),
(40, 3, 'admin', '2025-04-20 11:52:47', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":null,\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":1}'),
(41, 26, 'admin', '2025-04-20 11:55:47', '{\"OUTSTATION\":\"DSF\",\"DESKTOP_PC_MODEL\":\"adra\",\"CORRECT_SERIAL_NUMBER\":\"szfgbaz\",\"INVENTORY\":\"szfb\",\"WORKSTATION\":\"\",\"USERNAME\":\"dxfbs\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"DSF\",\"DESKTOP_PC_MODEL\":\"adra\",\"CORRECT_SERIAL_NUMBER\":\"szfgbaz\",\"INVENTORY\":\"szfb\",\"WORKSTATION\":\"\",\"USERNAME\":\"dxfbs\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\",\"VERIFIED\":0}'),
(42, 20, 'admin', '2025-04-20 11:55:54', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"2\",\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":\"\",\"VERIFIED\":1}'),
(43, 20, 'admin', '2025-04-20 11:56:34', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"\",\"WORKSTATION\":\"\",\"USERNAME\":\"\",\"FLOOR_NUMBER\":\"\",\"USER_ID\":null,\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"\",\"VERIFIED\":1}'),
(44, 25, 'admin', '2025-04-20 11:57:13', '{\"OUTSTATION\":\"sdfw\",\"DESKTOP_PC_MODEL\":\"dsfvw\",\"CORRECT_SERIAL_NUMBER\":\"dfsw\",\"INVENTORY\":\"sdgv\",\"WORKSTATION\":\"sdgvsw\",\"USERNAME\":\"swgdb\",\"FLOOR_NUMBER\":\"swg\",\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"sdfw\",\"DESKTOP_PC_MODEL\":\"dsfvw\",\"CORRECT_SERIAL_NUMBER\":\"dfsw\",\"INVENTORY\":\"sdgv\",\"WORKSTATION\":\"sdgvsw\",\"USERNAME\":\"swgdb\",\"FLOOR_NUMBER\":\"swg\",\"USER_ID\":\"\",\"VERIFIED\":0}'),
(45, 20, 'admin', '2025-04-20 11:57:18', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":null,\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"2\",\"VERIFIED\":1}'),
(46, 20, 'admin', '2025-04-20 11:57:22', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"2\",\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"2\",\"VERIFIED\":0}'),
(47, 20, 'admin', '2025-04-20 11:57:43', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"1\",\"VERIFIED\":0}'),
(48, 20, 'admin', '2025-04-20 12:01:48', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"\",\"VERIFIED\":0}'),
(49, 20, 'admin', '2025-04-20 12:01:56', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"\",\"VERIFIED\":0}'),
(50, 20, 'admin', '2025-04-20 12:02:03', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":null,\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"1\",\"VERIFIED\":0}'),
(51, 20, 'admin', '2025-04-20 12:02:10', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"1\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"asd\",\"DESKTOP_PC_MODEL\":\"adsf\",\"CORRECT_SERIAL_NUMBER\":\"\",\"INVENTORY\":\"sa\",\"WORKSTATION\":\"sa\",\"USERNAME\":\"sa\",\"FLOOR_NUMBER\":\"sa\",\"USER_ID\":\"1\",\"VERIFIED\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `printer`
--

CREATE TABLE `printer` (
  `id` int(11) NOT NULL,
  `VENDOR_NAME` varchar(100) DEFAULT NULL,
  `INVOICE_NO` varchar(50) DEFAULT NULL,
  `BILL_DATE` date DEFAULT NULL,
  `SN` varchar(50) DEFAULT NULL,
  `OUTSTATION` varchar(50) DEFAULT NULL,
  `PRINTER_MODEL` varchar(100) DEFAULT NULL,
  `PRINTER_TYPE` varchar(50) DEFAULT NULL,
  `PRINTER_SERIAL_NUMBER` varchar(100) DEFAULT NULL,
  `CORRECT_SERIAL_NUMBER` varchar(100) DEFAULT NULL,
  `INVENTORY` varchar(50) DEFAULT NULL,
  `WORKSTATION` varchar(50) DEFAULT NULL,
  `USER_NAME` varchar(100) DEFAULT NULL,
  `FLOOR_NUMBER` varchar(20) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `VERIFIED` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `printer`
--

INSERT INTO `printer` (`id`, `VENDOR_NAME`, `INVOICE_NO`, `BILL_DATE`, `SN`, `OUTSTATION`, `PRINTER_MODEL`, `PRINTER_TYPE`, `PRINTER_SERIAL_NUMBER`, `CORRECT_SERIAL_NUMBER`, `INVENTORY`, `WORKSTATION`, `USER_NAME`, `FLOOR_NUMBER`, `USER_ID`, `VERIFIED`) VALUES
(1, 'radfs', 'afde', '2025-04-09', '1', NULL, 'awer', 'aew', 'awe', NULL, NULL, NULL, 'aedf', NULL, NULL, 0),
(2, 'adefcDE', 'AEF', '2025-04-08', '2', '', 'SD', NULL, NULL, 'dsfwe', 'werqw', 'awer', '', 'edtr', NULL, 0),
(3, 'AWEFWE', 'AWDE', '2025-04-09', '3', 'sda', 'a', NULL, 'awe', 'aweda', 'sada', 'sada', 'asdaa', 'sada', NULL, 1),
(4, 'wgersgfs', 'srdtgf', '2025-04-10', '3', 'awerd', '', NULL, NULL, '', 'awd', 'as', 'daw', 'daw', NULL, 0),
(5, 'aedga', 'rygjn', '2025-04-11', '4', 'aer', 'esr', NULL, NULL, 'aret', 'aert', 'sret', 'sret', '', 1, 0),
(6, 'strhy', 'tghtr', '2025-04-01', '5', NULL, 'ergf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 'dgyjd', 'sre', '2025-04-11', 'rhy', NULL, 'sreg', NULL, NULL, 'rhy', NULL, NULL, '1', NULL, 1, 0),
(8, 'gawr', 'sreh', '2025-04-12', NULL, NULL, 'tgbh', NULL, NULL, 'sth', 'strh', 'st', NULL, NULL, 2, 0),
(9, 'adf', 'aregf', '0000-00-00', 'sfg', 'sfg', 'sfg', 'BW', '', '', '', '', '', '', 2, 0),
(10, 'EFW', 'A', '0000-00-00', 'adg', 'fg', 'aew', 'awe', '', '', '', '', '', '', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `printer_edit_log`
--

CREATE TABLE `printer_edit_log` (
  `id` int(11) NOT NULL,
  `printer_id` int(11) NOT NULL,
  `edited_by` varchar(255) DEFAULT NULL,
  `edit_time` datetime DEFAULT NULL,
  `old_data` text DEFAULT NULL,
  `new_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `printer_edit_log`
--

INSERT INTO `printer_edit_log` (`id`, `printer_id`, `edited_by`, `edit_time`, `old_data`, `new_data`) VALUES
(0, 3, 'admin', '2025-04-20 12:09:47', '{\"OUTSTATION\":\"sd\",\"PRINTER_MODEL\":\"\",\"CORRECT_SERIAL_NUMBER\":\"awed\",\"INVENTORY\":\"sad\",\"WORKSTATION\":\"sad\",\"USER_NAME\":\"asda\",\"FLOOR_NUMBER\":\"sad\",\"USER_ID\":\"2\",\"VERIFIED\":\"1\"}', '{\"OUTSTATION\":\"sda\",\"PRINTER_MODEL\":\"a\",\"CORRECT_SERIAL_NUMBER\":\"aweda\",\"INVENTORY\":\"sada\",\"WORKSTATION\":\"sada\",\"USER_NAME\":\"asdaa\",\"FLOOR_NUMBER\":\"sada\",\"USER_ID\":\"\",\"VERIFIED\":1}'),
(0, 2, 'user1', '2025-04-20 12:13:58', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"2\",\"VERIFIED\":\"0\"}', '{\"OUTSTATION\":\"\",\"PRINTER_MODEL\":\"SD\",\"CORRECT_SERIAL_NUMBER\":\"dsfwe\",\"INVENTORY\":\"werqw\",\"WORKSTATION\":\"awer\",\"USER_NAME\":\"\",\"FLOOR_NUMBER\":\"edtr\",\"USER_ID\":\"\",\"VERIFIED\":\"0\"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin,user'),
(2, 'user1', 'user123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_user`
--
ALTER TABLE `emp_user`
  ADD PRIMARY KEY (`EMP_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keyboard`
--
ALTER TABLE `keyboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitor`
--
ALTER TABLE `monitor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pc`
--
ALTER TABLE `pc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pc_user_id` (`USER_ID`);

--
-- Indexes for table `pc_edit_log`
--
ALTER TABLE `pc_edit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printer`
--
ALTER TABLE `printer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_printer_user_id` (`USER_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `keyboard`
--
ALTER TABLE `keyboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monitor`
--
ALTER TABLE `monitor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pc`
--
ALTER TABLE `pc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pc_edit_log`
--
ALTER TABLE `pc_edit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `printer`
--
ALTER TABLE `printer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pc`
--
ALTER TABLE `pc`
  ADD CONSTRAINT `fk_pc_user_id` FOREIGN KEY (`USER_ID`) REFERENCES `emp_user` (`EMP_ID`);

--
-- Constraints for table `printer`
--
ALTER TABLE `printer`
  ADD CONSTRAINT `fk_printer_user_id` FOREIGN KEY (`USER_ID`) REFERENCES `emp_user` (`EMP_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
