-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2021 at 05:30 PM
-- Server version: 5.5.16
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipd_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblsetting`
--

CREATE TABLE `tblsetting` (
  `id` int(11) NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsetting`
--

INSERT INTO `tblsetting` (`id`, `company`, `address`, `createdby`) VALUES
(1, 'IPD - System', 'Company Address', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_actionlist`
--

CREATE TABLE `t_actionlist` (
  `id` int(11) NOT NULL,
  `actionname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_actionlist`
--

INSERT INTO `t_actionlist` (`id`, `actionname`, `createdon`, `createdby`) VALUES
(1, 'Retest', '2021-08-08', 'sys-admin'),
(2, 'Replaced', '2021-08-08', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_approval`
--

CREATE TABLE `t_approval` (
  `object` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Mapping Approval PR PO';

-- --------------------------------------------------------

--
-- Table structure for table `t_auth_object`
--

CREATE TABLE `t_auth_object` (
  `ob_auth` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Authorization Object';

-- --------------------------------------------------------

--
-- Table structure for table `t_causelist`
--

CREATE TABLE `t_causelist` (
  `id` int(11) NOT NULL,
  `causename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_causelist`
--

INSERT INTO `t_causelist` (`id`, `causename`, `createdon`, `createdby`) VALUES
(1, 'Electrical Defect', '2021-08-08', 'sys-admin'),
(2, 'Machine Error', '2021-08-08', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_defectlist`
--

CREATE TABLE `t_defectlist` (
  `id` int(11) NOT NULL,
  `defectname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_defectlist`
--

INSERT INTO `t_defectlist` (`id`, `defectname`, `createdon`, `createdby`) VALUES
(1, 'Component Fail', '2021-08-08', 'sys-admin'),
(2, 'Voltage Error', '2021-08-08', 'sys-admin'),
(3, 'Damage Part', '2021-08-08', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_ipd_forms`
--

CREATE TABLE `t_ipd_forms` (
  `transactionid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_date` date NOT NULL,
  `partnumber` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partmodel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ipd_forms`
--

INSERT INTO `t_ipd_forms` (`transactionid`, `prod_date`, `partnumber`, `partmodel`, `serial_no`, `createdon`, `createdby`) VALUES
('1628343418', '2021-08-07', '1122334-01', 'U776A', '12345678', '2021-08-07', 'sys-admin'),
('1628343459', '2021-08-07', '2233441-02', 'U778B', '3456789876', '2021-08-07', 'sys-admin'),
('1628343831', '2021-08-07', '2233441-02', 'U778B', '54829320392', '2021-08-07', 'sys-admin'),
('1628343905', '2021-08-07', '2233441-02', 'U778B', '43567382232', '2021-08-07', 'sys-admin'),
('1628415264', '2021-08-08', '2424241-01', 'U778C', '2346232732', '2021-08-08', 'sys-admin'),
('1628435192', '2021-08-08', '2424241-01', 'U778C', '1000001', '2021-08-08', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_ipd_process`
--

CREATE TABLE `t_ipd_process` (
  `transactionid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process1` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process3` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process4` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process5` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process6` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process7` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process8` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_process` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defect_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cause` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastprocess` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ipd_process`
--

INSERT INTO `t_ipd_process` (`transactionid`, `process1`, `process2`, `process3`, `process4`, `process5`, `process6`, `process7`, `process8`, `error_process`, `defect_name`, `location`, `cause`, `action`, `lastprocess`) VALUES
('1628343418', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, 'ICT', 'Component Fail', 'C111', 'Electrical Defect', 'Retest', 4),
('1628343459', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
('1628435192', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, 'SMT SI', 'Component Fail', 'C222', 'Machine Error', 'Replaced', 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_ipd_repair`
--

CREATE TABLE `t_ipd_repair` (
  `transactionid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process1` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process3` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process4` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process5` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process6` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defect_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_locationlist`
--

CREATE TABLE `t_locationlist` (
  `id` int(11) NOT NULL,
  `locationname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_locationlist`
--

INSERT INTO `t_locationlist` (`id`, `locationname`, `createdon`, `createdby`) VALUES
(1, 'C111', '2021-08-08', 'sys-admin'),
(2, 'C222', '2021-08-08', 'sys-admin'),
(3, 'D45', '2021-08-08', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_material`
--

CREATE TABLE `t_material` (
  `material` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matdesc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mattype` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matgroup` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partnumber` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matunit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minstock` decimal(15,2) DEFAULT NULL,
  `orderunit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdprice` decimal(15,2) DEFAULT NULL,
  `stdpriceusd` decimal(15,4) DEFAULT '0.0000',
  `active` tinyint(1) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Material Master';

--
-- Dumping data for table `t_material`
--

INSERT INTO `t_material` (`material`, `matdesc`, `mattype`, `matgroup`, `partname`, `partnumber`, `color`, `size`, `matunit`, `minstock`, `orderunit`, `stdprice`, `stdpriceusd`, `active`, `createdon`, `createdby`) VALUES
('1122334-01', 'U776A', NULL, NULL, NULL, NULL, NULL, NULL, 'PC', NULL, NULL, NULL, '0.0000', NULL, '2021-08-07 02:08:06', 'sys-admin'),
('2233441-02', 'U778B', NULL, NULL, NULL, NULL, NULL, NULL, 'PC', NULL, NULL, NULL, '0.0000', NULL, '2021-08-07 02:08:11', 'sys-admin'),
('2424241-01', 'U778C', NULL, NULL, NULL, NULL, NULL, NULL, 'PC', NULL, NULL, NULL, '0.0000', NULL, '2021-08-07 02:08:33', 'sys-admin');

--
-- Triggers `t_material`
--
DELIMITER $$
CREATE TRIGGER `DELETE_MATERIAL` AFTER DELETE ON `t_material` FOR EACH ROW DELETE FROM t_material2 where material = OLD.material
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `INSERT_TO_ALT_UOM` AFTER INSERT ON `t_material` FOR EACH ROW INSERT INTO t_material2 VALUES(NEW.material,NEW.matunit,1,NEW.matunit,1,NEW.createdon,NEW.createdby)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_material2`
--

CREATE TABLE `t_material2` (
  `material` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `altuom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `convalt` decimal(15,2) NOT NULL,
  `baseuom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `convbase` decimal(15,2) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Material Alternative UOM';

--
-- Dumping data for table `t_material2`
--

INSERT INTO `t_material2` (`material`, `altuom`, `convalt`, `baseuom`, `convbase`, `createdon`, `createdby`) VALUES
('1122334-01', 'PC', '1.00', 'PC', '1.00', '2021-08-07 02:08:06', 'sys-admin'),
('2233441-02', 'PC', '1.00', 'PC', '1.00', '2021-08-07 02:08:11', 'sys-admin'),
('2424241-01', 'PC', '1.00', 'PC', '1.00', '2021-08-07 02:08:33', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_menugroups`
--

CREATE TABLE `t_menugroups` (
  `menugroup` int(11) NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_menugroups`
--

INSERT INTO `t_menugroups` (`menugroup`, `description`, `icon`, `createdon`, `createdby`) VALUES
(1, 'MASTER DATA', 'storage', '2021-08-06 14:01:33', 'sys-admin'),
(2, 'TRANSACTION', 'archive', '2021-08-06 14:01:33', ''),
(3, 'REPORTS', 'library_books', '2021-08-06 14:02:16', 'sys-admin'),
(4, 'SETTINGS', 'settings', '2021-08-06 14:02:16', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_menus`
--

CREATE TABLE `t_menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menugroup` int(11) NOT NULL,
  `grouping` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Application Menus';

--
-- Dumping data for table `t_menus`
--

INSERT INTO `t_menus` (`id`, `menu`, `route`, `type`, `icon`, `menugroup`, `grouping`, `createdon`, `createdby`) VALUES
(1, 'Material Master', 'material', 'parent', '', 1, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(2, 'Material Type', 'material', 'parent', '', 1, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(3, 'Generate Process Form', 'transaction/form', 'parent', '', 2, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(4, 'Transaction Process', 'transaction/process', 'parent', '', 2, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(5, 'Transaction Report', 'reports/transaction', 'parent', '', 3, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(6, 'Maintain User', 'user', 'parent', '', 4, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(7, 'Maintain System Menu', 'menu', 'parent', '', 4, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(8, 'Maintain Role', 'role', 'parent', '', 4, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(9, 'Maintain Menu Role', 'menurole', 'parent', '', 4, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(10, 'Maintain User Role', 'userrole', 'parent', '', 4, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(11, 'General Setting', 'generalsetting', 'parent', '', 4, 'setting', '2021-08-07 00:00:00', 'sys-admin'),
(12, 'Transaction Repair', 'transaction/repair', 'parent', '', 2, NULL, '2021-08-07 00:00:00', 'sys-admin'),
(13, 'Defect List', 'master/defect', 'parent', '', 1, NULL, '2021-08-08 00:00:00', 'sys-admin'),
(14, 'Location', 'master/location', 'parent', '', 1, NULL, '2021-08-08 00:00:00', 'sys-admin'),
(15, 'Cause List', 'master/cause', 'parent', '', 1, NULL, '2021-08-08 00:00:00', 'sys-admin'),
(16, 'Action List', 'master/action', 'parent', '', 1, NULL, '2021-08-08 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_nriv`
--

CREATE TABLE `t_nriv` (
  `object` varchar(15) NOT NULL,
  `fromnum` varchar(15) NOT NULL,
  `tonumber` varchar(15) NOT NULL,
  `currentnum` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_process_sequence`
--

CREATE TABLE `t_process_sequence` (
  `id` int(11) NOT NULL,
  `transtype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_process_sequence`
--

INSERT INTO `t_process_sequence` (`id`, `transtype`, `processname`, `sequence`, `username`) VALUES
(1, 'process', 'AOI SMT-BOTTOM (1st)', 1, 'user1'),
(2, 'process', 'AOI SMT-TOP (2nd)', 2, 'user2'),
(3, 'process', 'SMT SI', 3, 'user3'),
(4, 'process', 'ICT', 4, 'user4'),
(5, 'process', 'QPIT', 5, 'user5'),
(6, 'process', 'AOI HW-TOP', 6, 'user6'),
(7, 'process', 'AOI HW-BOTTOM', 7, 'user7'),
(8, 'process', 'FVI', 8, 'user8'),
(9, 'repair', 'AFTER REPAIR-ICT', 1, 'user1'),
(10, 'repair', 'AFTER REPAIR-QPIT', 2, 'user2'),
(11, 'repair', 'AFTER REPAIR-AOI TOP', 3, 'user3'),
(12, 'repair', 'AFTER REPAIR-BOT', 4, 'user4'),
(13, 'repair', 'AFTER REPAIR-FVI', 5, 'user5'),
(14, 'repair', 'OQA', 6, 'user6');

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

CREATE TABLE `t_role` (
  `roleid` int(11) NOT NULL,
  `rolename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role Master';

--
-- Dumping data for table `t_role`
--

INSERT INTO `t_role` (`roleid`, `rolename`, `createdon`, `createdby`) VALUES
(1, 'SYS-ADMIN', '2021-08-06 00:00:00', 'sys-admin'),
(2, 'ROLE01', '2021-08-08 00:00:00', 'sys-admin'),
(3, 'ROLE02', '2021-08-08 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_rolemenu`
--

CREATE TABLE `t_rolemenu` (
  `roleid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role Menu';

--
-- Dumping data for table `t_rolemenu`
--

INSERT INTO `t_rolemenu` (`roleid`, `menuid`, `createdon`, `createdby`) VALUES
(1, 1, '2021-08-07 00:00:00', 'sys-admin'),
(1, 3, '2021-08-07 00:00:00', 'sys-admin'),
(1, 4, '2021-08-07 00:00:00', 'sys-admin'),
(1, 5, '2021-08-07 00:00:00', 'sys-admin'),
(1, 6, '2021-08-07 00:00:00', 'sys-admin'),
(1, 7, '2021-08-07 00:00:00', 'sys-admin'),
(1, 8, '2021-08-07 00:00:00', 'sys-admin'),
(1, 9, '2021-08-07 00:00:00', 'sys-admin'),
(1, 10, '2021-08-07 00:00:00', 'sys-admin'),
(1, 11, '2021-08-07 00:00:00', 'sys-admin'),
(1, 12, '2021-08-07 00:00:00', 'sys-admin'),
(1, 13, '2021-08-08 00:00:00', 'sys-admin'),
(1, 14, '2021-08-08 00:00:00', 'sys-admin'),
(1, 15, '2021-08-08 00:00:00', 'sys-admin'),
(1, 16, '2021-08-08 00:00:00', 'sys-admin'),
(2, 4, '2021-08-08 00:00:00', 'sys-admin'),
(2, 5, '2021-08-08 00:00:00', 'sys-admin'),
(3, 12, '2021-08-08 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_role_avtivity`
--

CREATE TABLE `t_role_avtivity` (
  `roleid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `activity` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Activity Auth';

--
-- Dumping data for table `t_role_avtivity`
--

INSERT INTO `t_role_avtivity` (`roleid`, `menuid`, `activity`, `status`, `createdon`) VALUES
(1, 1, 'Create', 1, '2021-08-07'),
(1, 1, 'Delete', 1, '2021-08-07'),
(1, 1, 'Read', 1, '2021-08-07'),
(1, 1, 'Update', 1, '2021-08-07'),
(1, 3, 'Create', 1, '2021-08-07'),
(1, 3, 'Delete', 1, '2021-08-07'),
(1, 3, 'Read', 1, '2021-08-07'),
(1, 3, 'Update', 1, '2021-08-07'),
(1, 4, 'Create', 1, '2021-08-07'),
(1, 4, 'Delete', 1, '2021-08-07'),
(1, 4, 'Read', 1, '2021-08-07'),
(1, 4, 'Update', 1, '2021-08-07'),
(1, 5, 'Create', 0, '2021-08-07'),
(1, 5, 'Delete', 0, '2021-08-07'),
(1, 5, 'Read', 1, '2021-08-07'),
(1, 5, 'Update', 0, '2021-08-07'),
(1, 6, 'Create', 1, '2021-08-07'),
(1, 6, 'Delete', 1, '2021-08-07'),
(1, 6, 'Edit', 1, '2021-08-07'),
(1, 6, 'Read', 1, '2021-08-07'),
(1, 6, 'Update', 1, '2021-08-07'),
(1, 7, 'Create', 1, '2021-08-07'),
(1, 7, 'Delete', 1, '2021-08-07'),
(1, 7, 'Read', 1, '2021-08-07'),
(1, 7, 'Update', 1, '2021-08-07'),
(1, 8, 'Create', 1, '2021-08-07'),
(1, 8, 'Delete', 1, '2021-08-07'),
(1, 8, 'Read', 1, '2021-08-07'),
(1, 8, 'Update', 1, '2021-08-07'),
(1, 9, 'Create', 1, '2021-08-07'),
(1, 9, 'Delete', 1, '2021-08-07'),
(1, 9, 'Read', 1, '2021-08-07'),
(1, 9, 'Update', 1, '2021-08-07'),
(1, 10, 'Create', 1, '2021-08-07'),
(1, 10, 'Delete', 1, '2021-08-07'),
(1, 10, 'Read', 1, '2021-08-07'),
(1, 10, 'Update', 1, '2021-08-07'),
(1, 11, 'Create', 1, '2021-08-07'),
(1, 11, 'Delete', 1, '2021-08-07'),
(1, 11, 'Read', 1, '2021-08-07'),
(1, 11, 'Update', 1, '2021-08-07'),
(1, 12, 'Create', 1, '2021-08-07'),
(1, 12, 'Delete', 1, '2021-08-07'),
(1, 12, 'Read', 1, '2021-08-07'),
(1, 12, 'Update', 1, '2021-08-07'),
(1, 13, 'Create', 1, '2021-08-08'),
(1, 13, 'Delete', 1, '2021-08-08'),
(1, 13, 'Read', 1, '2021-08-08'),
(1, 13, 'Update', 1, '2021-08-08'),
(1, 14, 'Create', 1, '2021-08-08'),
(1, 14, 'Delete', 1, '2021-08-08'),
(1, 14, 'Read', 1, '2021-08-08'),
(1, 14, 'Update', 1, '2021-08-08'),
(1, 15, 'Create', 1, '2021-08-08'),
(1, 15, 'Delete', 1, '2021-08-08'),
(1, 15, 'Read', 1, '2021-08-08'),
(1, 15, 'Update', 1, '2021-08-08'),
(1, 16, 'Create', 1, '2021-08-08'),
(1, 16, 'Delete', 1, '2021-08-08'),
(1, 16, 'Read', 1, '2021-08-08'),
(1, 16, 'Update', 1, '2021-08-08'),
(2, 4, 'Create', 1, '2021-08-08'),
(2, 4, 'Delete', 1, '2021-08-08'),
(2, 4, 'Read', 1, '2021-08-08'),
(2, 4, 'Update', 1, '2021-08-08'),
(2, 5, 'Create', 0, '2021-08-08'),
(2, 5, 'Delete', 0, '2021-08-08'),
(2, 5, 'Read', 1, '2021-08-08'),
(2, 5, 'Update', 0, '2021-08-08'),
(3, 12, 'Create', 1, '2021-08-08'),
(3, 12, 'Delete', 1, '2021-08-08'),
(3, 12, 'Read', 1, '2021-08-08'),
(3, 12, 'Update', 1, '2021-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userlevel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `jabatan` int(11) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `approval` varchar(50) DEFAULT NULL,
  `reffid` varchar(30) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`username`, `password`, `nama`, `userlevel`, `department`, `jabatan`, `section`, `approval`, `reffid`, `cust_id`, `createdby`, `createdon`) VALUES
('sys-admin', '$2y$12$YCj4abvz4tMxEoYys4/9sul.FX.9lyhoQzRdl8rI8LWxg1rQb7l/W', 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-07'),
('user1', '$2y$12$SRZKODU0plLDEMZAaYI.fui6/KDGc6.E4Yqs94VJOlQM/4wFhhl0C', 'User Demo 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user2', '$2y$12$TxnC2JmAeAJF0g1q9PoY/uc3lPj8MUvHC.pd3pQ.lryIQtLCIxlTC', 'User Demo 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user3', '$2y$12$fIf3TTIpwRY3dUXBhUqZ6uJcmrH./LAYduoY8wk948txHdADT4s4.', 'User Demo 3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user4', '$2y$12$vzXwT1.rWf8RxCRN1xsjYORke32hDwzbmG3KWtiuw9DRSX3Gg0In2', 'User Demo 4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user5', '$2y$12$ELa9pJc.Y9WziGtEWUhNa.KmTr.1uYMV7kEjojLuUZ5fgKFhT5H4.', 'User Demo 5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user6', '$2y$12$.MG0aufoFg4Aynxv.IKdGex1BEtBKcTi5xJAtuMoRFAf2GcnIxtQW', 'User Demo 6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user7', '$2y$12$9fIVcRmeSqLiK2HUyyB2Xe7ix6XO/o0N.5.RliGAoCQZet9AAXM4W', 'User Demo 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user8', '$2y$12$n7s3vxO9AcnB.cR8d00.hOUP0M9tX/0smmg.a9ww0h7b6IuEp84JW', 'User Demo 8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_object_auth`
--

CREATE TABLE `t_user_object_auth` (
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ob_auth` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ob_value` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Object Authorization';

-- --------------------------------------------------------

--
-- Table structure for table `t_user_role`
--

CREATE TABLE `t_user_role` (
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleid` int(11) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Role';

--
-- Dumping data for table `t_user_role`
--

INSERT INTO `t_user_role` (`username`, `roleid`, `createdon`, `createdby`) VALUES
('sys-admin', 1, '2021-08-07 00:00:00', 'sys-admin'),
('user1', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user1', 3, '2021-08-08 00:00:00', 'sys-admin'),
('user2', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user2', 3, '2021-08-08 00:00:00', 'sys-admin'),
('user3', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user3', 3, '2021-08-08 00:00:00', 'sys-admin'),
('user4', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user4', 3, '2021-08-08 00:00:00', 'sys-admin'),
('user5', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user5', 3, '2021-08-08 00:00:00', 'sys-admin'),
('user6', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user6', 3, '2021-08-08 00:00:00', 'sys-admin'),
('user7', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user8', 2, '2021-08-08 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_report_transaction`
-- (See below for the actual view)
--
CREATE TABLE `v_report_transaction` (
`transactionid` varchar(20)
,`prod_date` date
,`partnumber` varchar(70)
,`partmodel` varchar(100)
,`serial_no` varchar(30)
,`createdon` date
,`process1` varchar(30)
,`process2` varchar(30)
,`process3` varchar(30)
,`process4` varchar(30)
,`process5` varchar(30)
,`process6` varchar(30)
,`process7` varchar(30)
,`process8` varchar(30)
,`error_process` varchar(50)
,`defect_name` varchar(50)
,`location` varchar(50)
,`cause` varchar(50)
,`action` varchar(50)
,`repair1` varchar(30)
,`repair2` varchar(30)
,`repair3` varchar(30)
,`repair4` varchar(30)
,`repair5` varchar(30)
,`repair6` varchar(30)
,`remark` varchar(50)
,`repair_defect` varchar(50)
,`repair_location` varchar(50)
,`repair_action` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_menu`
-- (See below for the actual view)
--
CREATE TABLE `v_user_menu` (
`username` varchar(100)
,`roleid` int(11)
,`rolename` varchar(50)
,`menuid` int(11)
,`id` int(11)
,`menu` varchar(50)
,`route` varchar(50)
,`type` varchar(20)
,`menugroup` int(11)
,`grouping` varchar(30)
,`icon` varchar(50)
,`createdon` datetime
,`createdby` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_menugroup`
-- (See below for the actual view)
--
CREATE TABLE `v_user_menugroup` (
`menugroup` int(11)
,`description` varchar(50)
,`icon` varchar(200)
,`createdon` timestamp
,`createdby` varchar(50)
,`username` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_role_avtivity`
-- (See below for the actual view)
--
CREATE TABLE `v_user_role_avtivity` (
`roleid` int(11)
,`menuid` int(11)
,`activity` varchar(10)
,`status` tinyint(1)
,`createdon` date
,`route` varchar(50)
,`menu` varchar(50)
,`username` varchar(100)
,`rolename` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `v_report_transaction`
--
DROP TABLE IF EXISTS `v_report_transaction`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_report_transaction`  AS  select `a`.`transactionid` AS `transactionid`,`a`.`prod_date` AS `prod_date`,`a`.`partnumber` AS `partnumber`,`a`.`partmodel` AS `partmodel`,`a`.`serial_no` AS `serial_no`,`a`.`createdon` AS `createdon`,`b`.`process1` AS `process1`,`b`.`process2` AS `process2`,`b`.`process3` AS `process3`,`b`.`process4` AS `process4`,`b`.`process5` AS `process5`,`b`.`process6` AS `process6`,`b`.`process7` AS `process7`,`b`.`process8` AS `process8`,`b`.`error_process` AS `error_process`,`b`.`defect_name` AS `defect_name`,`b`.`location` AS `location`,`b`.`cause` AS `cause`,`b`.`action` AS `action`,`c`.`process1` AS `repair1`,`c`.`process2` AS `repair2`,`c`.`process3` AS `repair3`,`c`.`process4` AS `repair4`,`c`.`process5` AS `repair5`,`c`.`process6` AS `repair6`,`c`.`remark` AS `remark`,`c`.`defect_name` AS `repair_defect`,`c`.`location` AS `repair_location`,`c`.`action` AS `repair_action` from ((`t_ipd_forms` `a` left join `t_ipd_process` `b` on((`a`.`transactionid` = `b`.`transactionid`))) left join `t_ipd_repair` `c` on((`a`.`transactionid` = `c`.`transactionid`))) order by `a`.`transactionid`,`a`.`serial_no`,`a`.`partnumber` ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_menu`
--
DROP TABLE IF EXISTS `v_user_menu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_menu`  AS  select `a`.`username` AS `username`,`b`.`roleid` AS `roleid`,`f`.`rolename` AS `rolename`,`c`.`menuid` AS `menuid`,`d`.`id` AS `id`,`d`.`menu` AS `menu`,`d`.`route` AS `route`,`d`.`type` AS `type`,`d`.`menugroup` AS `menugroup`,`d`.`grouping` AS `grouping`,`d`.`icon` AS `icon`,`d`.`createdon` AS `createdon`,`d`.`createdby` AS `createdby` from ((((`t_user` `a` join `t_user_role` `b` on((`a`.`username` = `b`.`username`))) join `t_rolemenu` `c` on((`c`.`roleid` = `b`.`roleid`))) join `t_menus` `d` on((`d`.`id` = `c`.`menuid`))) join `t_role` `f` on((`f`.`roleid` = `b`.`roleid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_menugroup`
--
DROP TABLE IF EXISTS `v_user_menugroup`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_menugroup`  AS  select `a`.`menugroup` AS `menugroup`,`a`.`description` AS `description`,`a`.`icon` AS `icon`,`a`.`createdon` AS `createdon`,`a`.`createdby` AS `createdby`,`b`.`username` AS `username` from (`t_menugroups` `a` join `v_user_menu` `b` on((`a`.`menugroup` = `b`.`menugroup`))) order by `a`.`menugroup` ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_role_avtivity`
--
DROP TABLE IF EXISTS `v_user_role_avtivity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_role_avtivity`  AS  select `a`.`roleid` AS `roleid`,`a`.`menuid` AS `menuid`,`a`.`activity` AS `activity`,`a`.`status` AS `status`,`a`.`createdon` AS `createdon`,`b`.`route` AS `route`,`b`.`menu` AS `menu`,`c`.`username` AS `username`,`d`.`rolename` AS `rolename` from (((`t_role_avtivity` `a` join `t_menus` `b` on((`a`.`menuid` = `b`.`id`))) join `t_user_role` `c` on((`a`.`roleid` = `c`.`roleid`))) join `t_role` `d` on((`a`.`roleid` = `d`.`roleid`))) order by `c`.`username`,`d`.`rolename` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblsetting`
--
ALTER TABLE `tblsetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_actionlist`
--
ALTER TABLE `t_actionlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_approval`
--
ALTER TABLE `t_approval`
  ADD PRIMARY KEY (`object`,`creator`,`approval`);

--
-- Indexes for table `t_auth_object`
--
ALTER TABLE `t_auth_object`
  ADD PRIMARY KEY (`ob_auth`);

--
-- Indexes for table `t_causelist`
--
ALTER TABLE `t_causelist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_defectlist`
--
ALTER TABLE `t_defectlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_ipd_forms`
--
ALTER TABLE `t_ipd_forms`
  ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `t_ipd_process`
--
ALTER TABLE `t_ipd_process`
  ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `t_ipd_repair`
--
ALTER TABLE `t_ipd_repair`
  ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `t_locationlist`
--
ALTER TABLE `t_locationlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_material`
--
ALTER TABLE `t_material`
  ADD PRIMARY KEY (`material`);

--
-- Indexes for table `t_material2`
--
ALTER TABLE `t_material2`
  ADD PRIMARY KEY (`material`,`altuom`);

--
-- Indexes for table `t_menugroups`
--
ALTER TABLE `t_menugroups`
  ADD PRIMARY KEY (`menugroup`);

--
-- Indexes for table `t_menus`
--
ALTER TABLE `t_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_nriv`
--
ALTER TABLE `t_nriv`
  ADD PRIMARY KEY (`object`);

--
-- Indexes for table `t_process_sequence`
--
ALTER TABLE `t_process_sequence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_role`
--
ALTER TABLE `t_role`
  ADD PRIMARY KEY (`roleid`),
  ADD KEY `idxrolename` (`rolename`),
  ADD KEY `roleid` (`roleid`);

--
-- Indexes for table `t_rolemenu`
--
ALTER TABLE `t_rolemenu`
  ADD PRIMARY KEY (`roleid`,`menuid`),
  ADD KEY `roleid` (`roleid`),
  ADD KEY `menuid` (`menuid`);

--
-- Indexes for table `t_role_avtivity`
--
ALTER TABLE `t_role_avtivity`
  ADD PRIMARY KEY (`roleid`,`menuid`,`activity`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `t_user_object_auth`
--
ALTER TABLE `t_user_object_auth`
  ADD PRIMARY KEY (`username`,`ob_auth`,`ob_value`);

--
-- Indexes for table `t_user_role`
--
ALTER TABLE `t_user_role`
  ADD PRIMARY KEY (`username`,`roleid`),
  ADD KEY `roleid` (`roleid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_actionlist`
--
ALTER TABLE `t_actionlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_causelist`
--
ALTER TABLE `t_causelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_defectlist`
--
ALTER TABLE `t_defectlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_locationlist`
--
ALTER TABLE `t_locationlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_menugroups`
--
ALTER TABLE `t_menugroups`
  MODIFY `menugroup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_menus`
--
ALTER TABLE `t_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `t_process_sequence`
--
ALTER TABLE `t_process_sequence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_rolemenu`
--
ALTER TABLE `t_rolemenu`
  ADD CONSTRAINT `t_rolemenu_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `t_role` (`roleid`),
  ADD CONSTRAINT `t_rolemenu_ibfk_2` FOREIGN KEY (`menuid`) REFERENCES `t_menus` (`id`);

--
-- Constraints for table `t_user_role`
--
ALTER TABLE `t_user_role`
  ADD CONSTRAINT `t_user_role_ibfk_1` FOREIGN KEY (`username`) REFERENCES `t_user` (`username`),
  ADD CONSTRAINT `t_user_role_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `t_role` (`roleid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
