-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2022 at 08:59 AM
-- Server version: 8.0.29
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipd_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE  PROCEDURE `sp_ProductionView` ()  BEGIN
	
    DECLARE date1 date;
    DECLARE date2 date;
    DECLARE date3 date;
    
    
    set date1 = date(now());
    set date2 = date(DATE_ADD(now(), INTERVAL 1 DAY));
    set date3 = date(DATE_ADD(now(), INTERVAL 3 DAY));
    
    select DISTINCT productionline, linename, model, lot_number,
    fGetProdPlanQty(date1,productionline,'1',model, lot_number) as 'planqtyd1s1',fGetProdTotalQtyOutput(date1,productionline,'1',model, lot_number) as 'qtyoutd1s1',
    fGetProdPlanQty(date1,productionline,'2',model, lot_number) as 'planqtyd1s2',fGetProdTotalQtyOutput(date1,productionline,'2',model, lot_number) as 'qtyoutd1s2',
    fGetProdPlanQty(date2,productionline,'1',model, lot_number) as 'planqtyd2s1',fGetProdTotalQtyOutput(date2,productionline,'1',model, lot_number) as 'qtyoutd2s1',
    fGetProdPlanQty(date2,productionline,'2',model, lot_number) as 'planqtyd2s2',fGetProdTotalQtyOutput(date2,productionline,'2',model, lot_number) as 'qtyoutd2s2',
    fGetProdPlanQty(date3,productionline,'1',model, lot_number) as 'planqtyd3s1',fGetProdTotalQtyOutput(date3,productionline,'1',model, lot_number) as 'qtyoutd3s1',
    fGetProdPlanQty(date3,productionline,'2',model, lot_number) as 'planqtyd3s2',fGetProdTotalQtyOutput(date3,productionline,'2',model, lot_number) as 'qtyoutd3s2'
    FROM v_productionview WHERE plandate BETWEEN date(now()) and date(DATE_ADD(now(), INTERVAL 2 DAY)) order by productionline, model, lot_number;
    
END$$

CREATE  PROCEDURE `sp_ProductionViewDate` ()  BEGIN
	
    DECLARE date1 date;
    DECLARE date2 date;
    DECLARE date3 date;
    
    set date1 = date(now());
    set date2 = date(DATE_ADD(now(), INTERVAL 1 DAY));
    set date3 = date(DATE_ADD(now(), INTERVAL 3 DAY));
    
    select date1, date2, date3;
END$$

CREATE  PROCEDURE `sp_UpdateAgeingProcessStatus` (IN `pKepi` VARCHAR(50), IN `pBarcode` VARCHAR(50), IN `pPartLot` VARCHAR(50), IN `pAssycode` VARCHAR(70))  BEGIN
	UPDATE t_handwork_process set ageing_process = 'Y' WHERE kepi_lot = pKepi AND barcode_serial = pBarcode AND part_lot = pPartLot and assy_code = pAssycode;

UPDATE t_smt_line_process set ageing_process = 'Y' WHERE kepi_lot = pKepi AND barcode_serial = pBarcode AND part_lot = pPartLot and assy_code = pAssycode;
END$$

CREATE  PROCEDURE `sp_UpdateFTProcessStatus` (IN `pKepi` VARCHAR(50), IN `pBarcode` VARCHAR(50), IN `pPartLot` VARCHAR(50), IN `pAssycode` VARCHAR(70))  BEGIN
	UPDATE t_handwork_process set ft_process = 'Y' WHERE kepi_lot = pKepi AND barcode_serial = pBarcode AND part_lot = pPartLot and assy_code = pAssycode;

UPDATE t_smt_line_process set ft_process = 'Y' WHERE kepi_lot = pKepi AND barcode_serial = pBarcode AND part_lot = pPartLot and assy_code = pAssycode;
END$$

--
-- Functions
--
CREATE  FUNCTION `fGetProdPlanQty` (`pPlandate` DATE, `pLine` INT, `pShift` INT, `pModel` VARCHAR(70), `pLotnum` VARCHAR(50)) RETURNS BIGINT BEGIN
    DECLARE hasil bigint;
	
    SET hasil = (SELECT sum(plan_qty) from t_planning where plandate = pPlandate and productionline = pLine and shift = pShift and model = pModel and lot_number = pLotnum);    
    
    	-- return the customer level
    if hasil is null THEN
   		set hasil = 0;
    end if;
	RETURN (hasil);
END$$

CREATE  FUNCTION `fGetProdTotalQtyOutput` (`pPlandate` DATE, `pLine` INT, `pShift` INT, `pModel` VARCHAR(70), `pLotnum` VARCHAR(50)) RETURNS BIGINT BEGIN
    DECLARE hasil bigint;
	
    SET hasil = (SELECT sum(output_qty) from t_planning_output where plandate = pPlandate and productionline = pLine and shift = pShift and model = pModel and lot_number = pLotnum);    
    
    	-- return the customer level
    if hasil is null THEN
   		set hasil = 0;
    end if;
	RETURN (hasil);
END$$

CREATE  FUNCTION `fGetSMTAgeingProcess` (`pInd` VARCHAR(1), `pKepi` VARCHAR(50), `pQrcode` VARCHAR(50), `pLot` VARCHAR(50)) RETURNS VARCHAR(1) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci BEGIN
	DECLARE hasil varchar(1);
    DECLARE icount bigint;
    
 	if pInd = '1' THEN
    	SET icount = (SELECT count(*) FROM t_smt_line_process WHERE kepi_lot = pKepi and barcode_serial = pQrcode and part_lot = pLot);
    ELSEIF pInd = '2' THEN
    	SET icount = (SELECT COUNT(*) FROM t_handwork_process WHERE kepi_lot = pKepi and barcode_serial = pQrcode and part_lot = pLot);
    end if;
    
    if icount > 0 THEN
    	set hasil = 'Y';
    ELSE
    	set hasil = 'N';
    end if;
    
	RETURN (hasil);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsetting`
--

CREATE TABLE `tblsetting` (
  `id` int NOT NULL,
  `company` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` int NOT NULL,
  `actionname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_actionlist`
--

INSERT INTO `t_actionlist` (`id`, `actionname`, `createdon`, `createdby`) VALUES
(1, 'Retest', '2021-08-08', 'sys-admin'),
(2, 'Replaced', '2021-08-08', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_ageing`
--

CREATE TABLE `t_ageing` (
  `id` int NOT NULL,
  `kepi_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(15,3) NOT NULL,
  `manpower_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ageing_time` decimal(10,2) DEFAULT NULL,
  `ageing_result` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failure_remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `defect_quantity` decimal(15,3) DEFAULT NULL,
  `assy_code` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_serial` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_lot` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ageing`
--

INSERT INTO `t_ageing` (`id`, `kepi_lot`, `quantity`, `manpower_name`, `ageing_time`, `ageing_result`, `failure_remark`, `defect_quantity`, `assy_code`, `barcode_serial`, `part_lot`, `createdby`, `createdon`) VALUES
(1, 'KEPI1', '10.000', 'TEs', '2.00', 'GOOD', '', '0.000', '1122334-01', 'QR01', 'LOT01', 'sys-admin', '2022-07-12 14:07:48'),
(3, 'KEPI1', '20.000', 'Tes', '3.00', 'GOOD', '', '0.000', '1122334-01', 'QR02', 'LOT02', 'sys-admin', '2022-07-13 07:07:33');

--
-- Triggers `t_ageing`
--
DELIMITER $$
CREATE TRIGGER `tg_UpdateAgeingProcessStatus` AFTER INSERT ON `t_ageing` FOR EACH ROW CALL sp_UpdateAgeingProcessStatus(NEW.kepi_lot, NEW.barcode_serial, NEW.part_lot, NEW.assy_code)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_approval`
--

CREATE TABLE `t_approval` (
  `object` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Mapping Approval PR PO';

-- --------------------------------------------------------

--
-- Table structure for table `t_auth_object`
--

CREATE TABLE `t_auth_object` (
  `ob_auth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Authorization Object';

-- --------------------------------------------------------

--
-- Table structure for table `t_barcode_serial`
--

CREATE TABLE `t_barcode_serial` (
  `barcode_serial` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_number` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_lot` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_barcode_serial`
--

INSERT INTO `t_barcode_serial` (`barcode_serial`, `part_number`, `part_lot`, `createdby`, `createdon`) VALUES
('E1-226-0869', '209080001', '90000001', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0879', '209080002', '90000002', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0889', '209080003', '90000003', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0899', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0900', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0901', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0902', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0903', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0904', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0905', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0906', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0907', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0908', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0909', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58'),
('E1-226-0910', '209080004', '90000004', 'sys-admin', '2022-06-29 22:34:58');

-- --------------------------------------------------------

--
-- Table structure for table `t_causelist`
--

CREATE TABLE `t_causelist` (
  `id` int NOT NULL,
  `causename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
  `id` int NOT NULL,
  `defectname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
-- Table structure for table `t_defect_process`
--

CREATE TABLE `t_defect_process` (
  `id` int NOT NULL,
  `transactionid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `counter` int NOT NULL,
  `defect` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cause` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `repairaction` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repairremark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_defect_process`
--

INSERT INTO `t_defect_process` (`id`, `transactionid`, `counter`, `defect`, `location`, `cause`, `action`, `repairaction`, `repairremark`, `createdby`, `createdon`) VALUES
(1, '1638074011755', 1, 'Component Fail', 'C222', 'Part Dmage', 'Repair', 'Replace X', '', 'user6', '2021-11-28'),
(2, '1638074011755', 1, 'Voltage Error', 'C111', 'Test', 'Repair', 'Replace Y', '', 'user6', '2021-11-28'),
(3, '1638074011755', 1, 'Damage Part', 'D45', 'Part Dmage', 'Replace', 'Replace Z', '', 'user6', '2021-11-28'),
(4, '1638238567931', 1, 'Component Fail', 'C111', 'Test', 'Replace', NULL, NULL, 'user3', '2021-11-30'),
(5, '1638238567931', 1, 'Voltage Error', 'D45', 'Part Dmage', 'Repair', NULL, NULL, 'user3', '2021-11-30'),
(6, '1638315062491', 1, 'Voltage Error', 'C111', 'rejet', 'for repair', 'For touch up', '', 'user2', '2021-12-01'),
(7, '1638315062491', 1, 'Damage Part', 'C222', 'Machine Error', 'Trial', 'For test', '', 'user2', '2021-12-01'),
(8, '1638315062491', 2, 'Component Fail', 'C111', 'Electrical Defect', 'For Testing Purpose', 'Test', '', 'user5', '2021-12-01'),
(9, '1638748002034', 1, 'Voltage Error', 'C111', 'Electrical Defect', 'For Test', '2nd repair', '', 'user5', '2021-12-06'),
(10, '1638748002034', 1, 'Damage Part', 'C222', 'poor solder', 'For Testing Purpose', '2nd repair', '', 'user5', '2021-12-06'),
(11, '1638750013123', 1, 'Voltage Error', 'C111', 'poor solder', 'For resolder', 'Testing 123', '', 'user3', '2021-12-06'),
(12, '1638750013123', 1, 'Damage Part', 'D45', 'reject', 'For Test', 'Testing 456', '', 'user3', '2021-12-06'),
(13, '1638750288968', 1, 'Damage Part', 'D45', 'wala lang', 'Test01', 'For test', '', 'user3', '2021-12-06'),
(14, '1638776443227', 1, 'Component Fail', 'C111', 'Electrical Defect', 'For Test', 'For Test123', '', 'user4', '2021-12-06'),
(15, '1638776443227', 1, 'Component Fail', 'C222', 'poor solder', 'For Testing Purpose', 'For Test456', '', 'user4', '2021-12-06'),
(16, '1638776953005', 1, 'Voltage Error', 'C222', 'Electrical Defect', 'Test if will add two rows', 'Test if add two', '', 'user2', '2021-12-06'),
(17, '1638776953005', 1, 'Voltage Error', 'C222', 'poor solder', 'test if will add row again', 'test again', '', 'user2', '2021-12-06'),
(18, '1638777167565', 1, 'Component Fail', 'C222', 'Electrical Defect', 'Test', NULL, NULL, 'user3', '2021-12-06'),
(19, '1638859998716', 1, 'Component Fail', 'C111', 'cause defect 1', 'action defect 1', 'repair action 1', '', 'user6', '2021-12-07'),
(20, '1638859998716', 1, 'Damage Part', 'D45', 'cause defect 2', 'action defect 2', 'repair action 2', '', 'user6', '2021-12-07'),
(21, '1638865511726', 1, 'Voltage Error', 'C111', 'poor solder', 'For Test again', 'Hope OK. Process 1 again', '', 'user3', '2021-12-07'),
(22, '1638865511726', 1, 'Voltage Error', 'C111', 'Electrical Defect', 'Again and Again', 'Hope ok 2. ', '', 'user3', '2021-12-07'),
(23, '1638866312362', 1, 'Component Fail', 'C111', 'Electrical Defect', 'Trial', 'OK', '', 'user3', '2021-12-07'),
(24, '1638866312362', 1, 'Component Fail', 'C111', 'test', 'For Test', 'OK', '', 'user3', '2021-12-07'),
(25, '1638866312362', 2, 'Voltage Error', 'C222', 'poor solder', 'testing', 'Proceed to After Repair ICT', '', 'user5', '2021-12-07'),
(26, '1639011418368', 1, 'Component Fail', 'C111', 'test', 'For Testing Purpose', 'Done Repair', '', 'user2', '2021-12-09'),
(27, '1639011418368', 1, 'Component Fail', 'C111', 'poor solder', 'testing', 'Done Repair', '', 'user2', '2021-12-09'),
(28, '1639011418368', 2, 'Damage Part', 'C222', 'poor solder', 'For Testing Purpose', 'Test123', '', 'user8', '2021-12-09'),
(29, '1639011418368', 2, 'Voltage Error', 'D45', 'test', 'Trial', 'Test456', '', 'user8', '2021-12-09'),
(30, '1641435028312', 1, 'Component Fail', 'C111', 'Part Dmage', 'Replace', NULL, NULL, 'user3', '2022-01-06'),
(31, '1641435028312', 1, 'Voltage Error', 'C222', 'kabel putus', 'Ganti Kabel', NULL, NULL, 'user3', '2022-01-06'),
(32, '1641438161212', 1, 'Component Fail', 'C111', 'Part Dmage', 'Ganti Kabel', NULL, NULL, 'user1', '2022-01-06'),
(33, '1641438161212', 1, 'Damage Part', 'C222', 'kabel putus', 'AOI SMT-TOP (2nd) Action', NULL, NULL, 'user1', '2022-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `t_defect_repair`
--

CREATE TABLE `t_defect_repair` (
  `transactionid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `counter` int NOT NULL,
  `defect_process_id` int NOT NULL,
  `repair_counter` int NOT NULL,
  `process_counter` int NOT NULL,
  `defect` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cause` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_defect_repair`
--

INSERT INTO `t_defect_repair` (`transactionid`, `counter`, `defect_process_id`, `repair_counter`, `process_counter`, `defect`, `location`, `cause`, `action`, `remark`, `createdby`, `createdon`) VALUES
('1638776443227', 1, 14, 1, 1, 'Component Fail', 'C111', 'Electrical Defect', 'For Test123', '', 'sys-admin', '2021-12-06'),
('1638776443227', 2, 15, 1, 1, 'Component Fail', 'C222', 'poor solder', 'For Test456', '', 'sys-admin', '2021-12-06'),
('1638776953005', 1, 16, 1, 1, 'Voltage Error', 'C222', 'Electrical Defect', 'Test if add two', '', 'sys-admin', '2021-12-06'),
('1638776953005', 2, 17, 1, 1, 'Voltage Error', 'C222', 'poor solder', 'test again', '', 'sys-admin', '2021-12-06'),
('1638859998716', 1, 19, 1, 1, 'Component Fail', 'C111', 'cause defect 1', 'repair action 1', '', 'sys-admin', '2021-12-07'),
('1638859998716', 1, 19, 2, 1, 'Component Fail', 'C111', 'cause defect 1', 'repair action 1', 'please re-test again', 'user2', '2021-12-07'),
('1638859998716', 2, 20, 1, 1, 'Damage Part', 'D45', 'cause defect 2', 'repair action 2', '', 'sys-admin', '2021-12-07'),
('1638859998716', 2, 20, 2, 1, 'Damage Part', 'D45', 'cause defect 2', 'repair action 2', 'please re-test again', 'user2', '2021-12-07'),
('1638865511726', 1, 21, 1, 1, 'Voltage Error', 'C111', 'poor solder', 'Hope OK. Process 1 again', '', 'sys-admin', '2021-12-07'),
('1638865511726', 2, 22, 1, 1, 'Voltage Error', 'C111', 'Electrical Defect', 'Hope ok 2. ', '', 'sys-admin', '2021-12-07'),
('1638866312362', 1, 23, 1, 1, 'Component Fail', 'C111', 'Electrical Defect', 'OK', '', 'sys-admin', '2021-12-07'),
('1638866312362', 1, 25, 2, 2, 'Voltage Error', 'C222', 'poor solder', 'Final', '', 'sys-admin', '2021-12-07'),
('1638866312362', 1, 25, 3, 2, 'Voltage Error', 'C222', 'poor solder', 'Final', 'back to repair. for Rework', 'user5', '2021-12-07'),
('1638866312362', 1, 25, 4, 2, 'Voltage Error', 'C222', 'poor solder', 'Proceed to After Repair ICT', 'Fail', 'user3', '2021-12-07'),
('1638866312362', 2, 24, 1, 1, 'Component Fail', 'C111', 'test', 'OK', '', 'sys-admin', '2021-12-07'),
('1639011418368', 1, 26, 1, 1, 'Component Fail', 'C111', 'test', 'Done Repair', '', 'sys-admin', '2021-12-09'),
('1639011418368', 1, 28, 2, 2, 'Damage Part', 'C222', 'poor solder', 'Test123', '', 'sys-admin', '2021-12-09'),
('1639011418368', 2, 27, 1, 1, 'Component Fail', 'C111', 'poor solder', 'Done Repair', '', 'sys-admin', '2021-12-09'),
('1639011418368', 2, 29, 2, 2, 'Voltage Error', 'D45', 'test', 'Test456', '', 'sys-admin', '2021-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `t_ft_process`
--

CREATE TABLE `t_ft_process` (
  `id` int NOT NULL,
  `kepi_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `manpower_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ft_time` decimal(15,2) DEFAULT NULL,
  `ft_jig_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ft_result` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ft_quantity` decimal(15,3) DEFAULT NULL,
  `failure_remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `defect_qty` decimal(15,3) DEFAULT NULL,
  `assy_code` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_serial` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ft_process`
--

INSERT INTO `t_ft_process` (`id`, `kepi_lot`, `manpower_name`, `ft_time`, `ft_jig_no`, `ft_result`, `ft_quantity`, `failure_remark`, `defect_qty`, `assy_code`, `barcode_serial`, `part_lot`, `createdby`, `createdon`) VALUES
(1, 'KEPI1', 'Tes', '4.00', NULL, 'GOOD', '10.000', NULL, '0.000', '1122334-01', 'QR02', 'LOT02', 'sys-admin', '2022-07-13 06:07:46'),
(2, 'KEPI1', 'Tes', '4.00', NULL, 'GOOD', '10.000', NULL, '0.000', '1122334-01', 'QR01', 'LOT01', 'sys-admin', '2022-07-13 06:07:16');

--
-- Triggers `t_ft_process`
--
DELIMITER $$
CREATE TRIGGER `tg_UpdateFTProcessStatus` AFTER INSERT ON `t_ft_process` FOR EACH ROW CALL sp_UpdateFTProcessStatus(NEW.kepi_lot, NEW.barcode_serial, NEW.part_lot, NEW.assy_code)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_handwork_process`
--

CREATE TABLE `t_handwork_process` (
  `id` int NOT NULL,
  `assy_code` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepi_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_serial` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hw_line` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hw_shift` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ageing_process` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `ft_process` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_handwork_process`
--

INSERT INTO `t_handwork_process` (`id`, `assy_code`, `kepi_lot`, `barcode_serial`, `part_lot`, `hw_line`, `hw_shift`, `ageing_process`, `ft_process`, `createdby`, `createdon`) VALUES
(1, '1122334-01', 'KEPI1', 'QR02', 'LOT02', '1', '1', 'Y', 'Y', 'sys-admin', '2022-07-12 14:07:05'),
(2, '1122334-01', 'KEPI1', 'QR01', 'LOT01', '1', '1', 'N', 'Y', 'sys-admin', '2022-07-12 14:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `t_ipd_forms`
--

CREATE TABLE `t_ipd_forms` (
  `transactionid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_date` datetime NOT NULL,
  `partnumber` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `partmodel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lotcode` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ipd_forms`
--

INSERT INTO `t_ipd_forms` (`transactionid`, `prod_date`, `partnumber`, `partmodel`, `serial_no`, `lotcode`, `createdon`, `createdby`) VALUES
('1638074011755', '2021-11-28 00:00:00', '1122334-01', 'U776A', 'SER001', 'LOT001', '2021-11-28', 'user1'),
('1638238567931', '2021-11-30 00:00:00', '1122334-01', 'U776A', 'SER005', 'LOT005', '2021-11-30', 'user1'),
('1638315062491', '2021-12-01 00:00:00', '2233441-02', 'U778B', '1425', 'kepilt', '2021-12-01', 'user1'),
('1638748002034', '2021-12-06 00:00:00', '2233441-02	', 'U778B', '123654', '582', '2021-12-06', 'user1'),
('1638750013123', '2021-12-06 00:00:00', '2233441-02', 'U778B', '5858', '56', '2021-12-06', 'user1'),
('1638750288968', '2021-12-06 00:00:00', '2233441-02', 'U778B', '9898', '65', '2021-12-06', 'user1'),
('1638776443227', '2021-12-06 00:00:00', '2424241-01	', 'U778C', '789', '23', '2021-12-06', 'user1'),
('1638776953005', '2021-12-06 00:00:00', '2233441-02	', 'U778B', '564', '34', '2021-12-06', 'user1'),
('1638777167565', '2021-12-06 00:00:00', '2233441-02', 'U778B', '741', '34', '2021-12-06', 'user1'),
('1638859998716', '2021-12-07 00:00:00', '2424241-01', 'U778C', 'SER-TEST-1', 'LOT-TEST-1', '2021-12-07', 'user1'),
('1638865511726', '2021-12-07 00:00:00', '1122334-01	', 'U776A', '963', '654', '2021-12-07', 'user1'),
('1638866312362', '2021-12-07 00:00:00', '1122334-01	', 'U776A', '654', '852', '2021-12-07', 'user1'),
('1638931023488', '2021-12-08 00:00:00', '2233441-02	', 'U778B', 'SER02', 'LOT02', '2021-12-08', 'user1'),
('1639011418368', '2021-12-09 00:00:00', '1122334-01', 'U776A', '652', 'LOT1', '2021-12-09', 'user1'),
('1639014305454', '2021-12-09 08:12:09', '1122334-01', 'U776A', 'SER999', 'LOT999', '2021-12-09', 'user1'),
('1639026602707', '2021-12-09 12:12:04', '1122334-01	', 'U776A', '36', '6', '2021-12-09', 'user1'),
('1639027427637', '2021-12-09 12:12:51', '1122334-01	', 'U776A', '777', '65', '2021-12-09', 'user1'),
('1639027488067', '2021-12-09 12:12:49', '1122334-01	', 'U776A', '9', '6', '2021-12-09', 'user1'),
('1641353740863', '2022-01-05 10:01:09', '2233441-02', 'U778B', '34', '12', '2022-01-05', 'user1'),
('1641434570977', '2022-01-06 09:01:18', '1122334-01', 'U776A', 'SERIAL01', 'LOT01', '2022-01-06', 'user1'),
('1641435028312', '2022-01-06 09:01:34', '1122334-01', 'U776A', 'SERIAL02', 'LOT02', '2022-01-06', 'user1'),
('1641435230499', '2022-01-06 09:01:04', '1122334-01', 'U776A', 'SERIAL03', 'LOT03', '2022-01-06', 'user1'),
('1641437934183', '2022-01-06 09:01:15', '1122334-01', 'U776A', 'SERIAL04', 'LOT04', '2022-01-06', 'user1'),
('1641438043669', '2022-01-06 10:01:04', '1122334-01', 'U776A', 'SERIAL06', 'LOT06', '2022-01-06', 'user1'),
('1641438161212', '2022-01-06 10:01:45', '1122334-01', 'U776A', 'SERIAL07', 'LOT07', '2022-01-06', 'user1'),
('1641780897014', '2022-01-10 09:01:06', '1122334-01', 'U776A', 'SERX11', 'LOT999', '2022-01-10', 'user1');

-- --------------------------------------------------------

--
-- Table structure for table `t_ipd_process`
--

CREATE TABLE `t_ipd_process` (
  `transactionid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `counter` int NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process1` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process2` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process3` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process4` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process5` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process6` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process7` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process8` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process9` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_process` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defect_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cause` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastprocess` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ipd_process`
--

INSERT INTO `t_ipd_process` (`transactionid`, `counter`, `status`, `process1`, `process2`, `process3`, `process4`, `process5`, `process6`, `process7`, `process8`, `process9`, `error_process`, `defect_name`, `location`, `cause`, `action`, `lastprocess`) VALUES
('1638074011755', 1, 'Open', 'Good', 'Good', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, 'AOI HW-TOP', NULL, NULL, NULL, NULL, 6),
('1638238567931', 1, 'Open', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1638315062491', 1, 'Closed', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-TOP (2nd)', NULL, NULL, NULL, NULL, 2),
('1638315062491', 2, 'Open', 'Good', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, 'QPIT', NULL, NULL, NULL, NULL, 5),
('1638748002034', 1, 'Open', 'Good', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, 'QPIT', NULL, NULL, NULL, NULL, 5),
('1638750013123', 1, 'Closed', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1638750013123', 2, 'Open', 'Good', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
('1638750288968', 1, 'Closed', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1638750288968', 2, 'Open', 'Good', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
('1638776443227', 1, 'Closed', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, 'ICT', NULL, NULL, NULL, NULL, 4),
('1638776443227', 2, 'Closed', 'Good', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
('1638776443227', 3, 'Open', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('1638776953005', 1, 'Closed', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-TOP (2nd)', NULL, NULL, NULL, NULL, 2),
('1638776953005', 2, 'Open', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('1638777167565', 1, 'Open', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1638859998716', 1, 'Open', 'Good', 'Good', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, 'AOI HW-TOP', NULL, NULL, NULL, NULL, 6),
('1638865511726', 1, 'Closed', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1638865511726', 2, 'Closed', 'Good', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
('1638865511726', 3, 'Open', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1),
('1638866312362', 1, 'Closed', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1638866312362', 2, 'Open', 'Good', 'Good', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, 'QPIT', NULL, NULL, NULL, NULL, 5),
('1638931023488', 1, 'Open', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
('1639011418368', 1, 'Closed', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-TOP (2nd)', NULL, NULL, NULL, NULL, 2),
('1639011418368', 2, 'Open', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', 'NG', NULL, 'FVI', NULL, NULL, NULL, NULL, 8),
('1639014305454', 1, 'Open', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
('1639026602707', 1, 'Open', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
('1639027427637', 1, 'Open', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
('1639027488067', 1, 'Open', 'Good', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
('1641353740863', 1, 'Open', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-BOTTOM (1st)', NULL, NULL, NULL, NULL, 1),
('1641434570977', 1, 'Open', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-BOTTOM (1st)', NULL, NULL, NULL, NULL, 1),
('1641435028312', 1, 'Open', 'Good', 'Good', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, 'SMT SI', NULL, NULL, NULL, NULL, 3),
('1641435230499', 1, 'Open', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-BOTTOM (1st)', NULL, NULL, NULL, NULL, 1),
('1641437934183', 1, 'Open', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-BOTTOM (1st)', NULL, NULL, NULL, NULL, 1),
('1641438043669', 1, 'Open', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-BOTTOM (1st)', NULL, NULL, NULL, NULL, 1),
('1641438161212', 1, 'Open', 'NG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AOI SMT-BOTTOM (1st)', NULL, NULL, NULL, NULL, 1),
('1641780897014', 1, 'Open', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', '', NULL, NULL, NULL, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `t_ipd_repair`
--

CREATE TABLE `t_ipd_repair` (
  `transactionid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `counter` int NOT NULL,
  `process_counter` int NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process1` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process2` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process3` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process4` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process5` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process6` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `process7` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defect_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastrepair` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_ipd_repair`
--

INSERT INTO `t_ipd_repair` (`transactionid`, `counter`, `process_counter`, `status`, `process1`, `process2`, `process3`, `process4`, `process5`, `process6`, `process7`, `defect_name`, `location`, `action`, `remark`, `lastrepair`) VALUES
('1638074011755', 1, 1, 'Closed', 'PASS', 'NOT PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Please Retest Again', 2),
('1638074011755', 2, 1, 'Open', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1638238567931', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1638315062491', 1, 1, 'Closed', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638315062491', 2, 2, 'Open', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638748002034', 1, 1, 'Closed', 'PASS', 'PASS', 'NOT PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'For repair', 3),
('1638748002034', 2, 1, 'Open', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638750013123', 1, 1, 'Closed', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638750288968', 1, 1, 'Closed', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638776443227', 1, 1, 'Closed', 'PASS', 'PASS', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 3),
('1638776953005', 1, 1, 'Closed', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638777167565', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1638859998716', 1, 1, 'Closed', 'PASS', 'PASS', 'NOT PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'please re-test again', 3),
('1638859998716', 2, 1, 'Open', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1638865511726', 1, 1, 'Closed', 'PASS', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 2),
('1638866312362', 1, 1, 'Closed', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1638866312362', 2, 2, 'Closed', 'PASS', 'PASS', 'PASS', 'PASS', 'PASS', 'NOT PASS', NULL, NULL, NULL, NULL, 'back to repair. for Rework', 6),
('1638866312362', 3, 2, 'Closed', 'PASS', 'PASS', 'PASS', 'NOT PASS', NULL, NULL, NULL, NULL, NULL, NULL, 'Fail', 4),
('1638866312362', 4, 2, 'Open', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1639011418368', 1, 1, 'Closed', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1),
('1639011418368', 2, 2, 'Open', 'PASS', 'PASS', 'PASS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 3),
('1641353740863', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1641434570977', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('1641435028312', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1641435230499', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1641437934183', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('1641438161212', 1, 1, 'Closed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_line_masters`
--

CREATE TABLE `t_line_masters` (
  `lineid` int NOT NULL,
  `linename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_locationlist`
--

CREATE TABLE `t_locationlist` (
  `id` int NOT NULL,
  `locationname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
  `material` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matdesc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mattype` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matgroup` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partnumber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matunit` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minstock` decimal(15,2) DEFAULT NULL,
  `orderunit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stdprice` decimal(15,2) DEFAULT NULL,
  `stdpriceusd` decimal(15,4) DEFAULT '0.0000',
  `active` tinyint(1) DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Material Master';

--
-- Dumping data for table `t_material`
--

INSERT INTO `t_material` (`material`, `matdesc`, `mattype`, `matgroup`, `partname`, `partnumber`, `color`, `size`, `matunit`, `minstock`, `orderunit`, `stdprice`, `stdpriceusd`, `active`, `createdon`, `createdby`) VALUES
('1122334-01', 'U776A', NULL, NULL, NULL, NULL, NULL, NULL, 'PC', NULL, NULL, NULL, '0.0000', NULL, '2021-08-07 02:08:06', 'sys-admin'),
('2233441-02', 'U778B', NULL, NULL, NULL, NULL, NULL, NULL, 'PC', NULL, NULL, NULL, '0.0000', NULL, '2021-08-07 02:08:11', 'sys-admin'),
('2424241-01', 'U778C', NULL, NULL, NULL, NULL, NULL, NULL, 'PC', NULL, NULL, NULL, '0.0000', NULL, '2021-08-07 02:08:33', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_material2`
--

CREATE TABLE `t_material2` (
  `material` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `altuom` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `convalt` decimal(15,2) NOT NULL,
  `baseuom` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `convbase` decimal(15,2) NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
  `menugroup` int NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `_index` int DEFAULT NULL,
  `icon` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_menugroups`
--

INSERT INTO `t_menugroups` (`menugroup`, `description`, `_index`, `icon`, `createdon`, `createdby`) VALUES
(1, 'MASTER DATA', 1, 'storage', '2021-08-06 14:01:33', 'sys-admin'),
(2, 'TRANSACTION', 2, 'storage', '2021-08-06 14:01:33', ''),
(3, 'REPORTS', 5, 'library_books', '2021-08-06 14:02:16', 'sys-admin'),
(4, 'SETTINGS', 99, 'settings', '2021-08-06 14:02:16', 'sys-admin'),
(5, 'PRODUCTION', 3, 'storage', '2021-08-06 14:01:33', ''),
(6, 'CRITICAL PART CONTROL', 4, 'storage', '2021-08-06 14:01:33', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_menus`
--

CREATE TABLE `t_menus` (
  `id` int NOT NULL,
  `menu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menugroup` int NOT NULL,
  `grouping` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
(16, 'Action List', 'master/action', 'parent', '', 1, NULL, '2021-08-08 00:00:00', 'sys-admin'),
(17, 'Process Flow', 'processflow', 'parent', '', 4, NULL, '2021-08-09 00:00:00', 'sys-admin'),
(18, 'Create Purchase Request', 'pr', 'parent', '', 2, NULL, '2021-08-14 00:00:00', 'sys-admin'),
(19, 'Department List', 'department', 'parent', '', 1, NULL, '2021-08-14 00:00:00', 'sys-admin'),
(20, 'Budget Allocation', 'budgeting', 'parent', '', 1, NULL, '2021-08-14 00:00:00', 'sys-admin'),
(21, 'Approve Purchase Request', 'approvepr', 'parent', '', 2, NULL, '2021-08-14 00:00:00', 'sys-admin'),
(22, 'Mapping Approval', 'approval', 'parent', '', 4, NULL, '2021-08-14 00:00:00', 'sys-admin'),
(23, 'Report Purchase Request', 'reports/reportpr', 'parent', '', 3, NULL, '2021-08-14 00:00:00', 'sys-admin'),
(24, 'Input Planning', 'production', 'parent', '', 5, NULL, '2021-09-15 00:00:00', 'sys-admin'),
(25, 'Maintain Menu Groups', 'menugroup', 'parent', '', 4, NULL, '2021-09-16 00:00:00', 'sys-admin'),
(26, 'Production Lines', 'productionlines', 'parent', '', 1, NULL, '2021-09-18 00:00:00', 'sys-admin'),
(27, 'Actual Output', 'production/inputactualqty', 'parent', '', 5, NULL, '2021-09-18 00:00:00', 'sys-admin'),
(28, 'Planning Report', 'planningreport', 'parent', '', 5, NULL, '2021-09-20 00:00:00', 'sys-admin'),
(29, 'Production View', 'production/productionview', 'parent', '', 5, NULL, '2021-10-02 00:00:00', 'sys-admin'),
(30, 'Warehouse Issuance', 'warehouseissuance', 'parent', '', 2, NULL, '2022-06-01 00:00:00', 'sys-admin'),
(31, 'Part Code Location', 'partlocation', 'parent', '', 1, NULL, '2022-06-12 00:00:00', 'sys-admin'),
(32, 'Report Warehouse Issuance', 'rwarehouseissuance', 'parent', '', 3, NULL, '2022-06-16 00:00:00', 'sys-admin'),
(33, 'SMT LINE Process', 'smtprocess', 'parent', '', 6, NULL, '2022-06-18 00:00:00', 'sys-admin'),
(34, 'HANDWORK LINE Process', 'handworkprocess', 'parent', '', 6, NULL, '2022-06-18 00:00:00', 'sys-admin'),
(35, 'AGEING Process', 'ageingprocess', 'parent', '', 6, NULL, '2022-06-18 00:00:00', 'sys-admin'),
(36, 'FT Process', 'ftprocess', 'parent', '', 6, NULL, '2022-06-18 00:00:00', 'sys-admin'),
(37, 'QA Inspection', 'qainspection', 'parent', '', 6, NULL, '2022-06-18 00:00:00', 'sys-admin'),
(38, 'Barcode Serial', 'barcodeserial', 'parent', '', 1, NULL, '2022-06-29 00:00:00', 'sys-admin'),
(39, 'Critical Part Report', 'reports/criticalpart', 'parent', '', 3, NULL, '2022-07-15 00:00:00', 'sys-admin');

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
-- Table structure for table `t_part_location`
--

CREATE TABLE `t_part_location` (
  `part_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assy_location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniq_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_part_location`
--

INSERT INTO `t_part_location` (`part_number`, `assy_location`, `uniq_id`, `createdby`, `createdon`) VALUES
('209080001', 'DC1', '1656601237', 'sys-admin', '2022-06-30'),
('209080002', 'G90', '1656603881', 'sys-admin', '2022-06-30'),
('2177530-00', 'IC1', '1655007157', 'sys-admin', '2022-06-12'),
('2180281-00', 'T1', '1655007272', 'sys-admin', '2022-06-12'),
('2180439-00', 'DB1', '1655007285', 'sys-admin', '2022-06-12'),
('2180504-00', 'PC1', '1655007235', 'sys-admin', '2022-06-12'),
('2180505-00', 'DB2', '1655374247', 'sys-admin', '2022-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `t_planning`
--

CREATE TABLE `t_planning` (
  `plandate` date NOT NULL,
  `productionline` int NOT NULL,
  `shift` int NOT NULL,
  `model` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lot_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `plan_qty` int NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_planning`
--

INSERT INTO `t_planning` (`plandate`, `productionline`, `shift`, `model`, `partnumber`, `lot_number`, `plan_qty`, `createdon`, `createdby`) VALUES
('2021-10-04', 1, 1, 'U776A', '1122334-01', '10000001', 1000, '2021-10-04', 'sys-admin'),
('2021-10-04', 1, 1, 'U778B', '2233441-02', '10000002', 1500, '2021-10-04', 'sys-admin'),
('2021-10-04', 1, 2, 'U778B', '2233441-02', '10000003', 500, '2021-10-04', 'sys-admin'),
('2021-10-04', 1, 2, 'U778C', '2424241-01', '10000004', 1000, '2021-10-04', 'sys-admin'),
('2021-10-13', 1, 2, 'U778B', '2233441-02', '10000004', 500, '2021-10-14', 'sys-admin'),
('2021-10-14', 1, 1, 'U776A', '1122334-01', '10000000', 1000, '2021-10-14', 'sys-admin'),
('2021-10-14', 1, 1, 'U778B', '2233441-02', '10000001', 1500, '2021-10-14', 'sys-admin'),
('2021-10-14', 1, 2, 'U778C', '2424241-01', '10000002', 1000, '2021-10-14', 'sys-admin'),
('2021-10-15', 1, 1, 'U776A', '1122334-01', 'LOT12345', 1000, '2021-10-14', 'sys-admin'),
('2021-10-16', 4, 1, 'U778C', '2424241-01', '10000002', 600, '2021-10-14', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_planning_output`
--

CREATE TABLE `t_planning_output` (
  `id` int NOT NULL,
  `plandate` date NOT NULL,
  `productionline` int NOT NULL,
  `shift` int NOT NULL,
  `model` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `partnumber` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `output_qty` int NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_planning_output`
--

INSERT INTO `t_planning_output` (`id`, `plandate`, `productionline`, `shift`, `model`, `partnumber`, `lot_number`, `output_qty`, `createdon`, `createdby`) VALUES
(6, '2021-10-04', 1, 1, 'U776A', '', '10000001', 500, '2021-10-04', 'sys-admin'),
(7, '2021-10-04', 1, 1, 'U778B', '', '10000002', 600, '2021-10-04', 'sys-admin'),
(8, '2021-10-04', 1, 1, 'U776A', '', '10000001', 600, '2021-10-04', 'sys-admin'),
(9, '2021-10-04', 1, 1, 'U778B', '', '10000002', 1000, '2021-10-04', 'sys-admin'),
(10, '2021-10-04', 1, 2, 'U778B', '', '10000003', 600, '2021-10-04', 'sys-admin'),
(11, '2021-10-04', 1, 2, 'U778C', '', '10000004', 900, '2021-10-04', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_process_sequence`
--

CREATE TABLE `t_process_sequence` (
  `id` int NOT NULL,
  `transtype` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `processname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
(9, 'repair', 'AFTER REPAIR-ICT', 2, 'user1'),
(10, 'repair', 'AFTER REPAIR-QPIT', 3, 'user2'),
(11, 'repair', 'AFTER REPAIR-AOI TOP', 4, 'user3'),
(12, 'repair', 'AFTER REPAIR-BOT', 5, 'user4'),
(13, 'repair', 'AFTER REPAIR-FVI', 6, 'user5'),
(14, 'repair', 'OQA', 7, 'user6'),
(15, 'process', 'QQA', 9, 'user9'),
(16, 'repair', 'Action', 1, 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_production_lines`
--

CREATE TABLE `t_production_lines` (
  `id` int NOT NULL,
  `description` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_production_lines`
--

INSERT INTO `t_production_lines` (`id`, `description`, `createdon`, `createdby`) VALUES
(1, 'LINE 1', '2021-09-18', 'sys-admin'),
(2, 'LINE 2', '2021-09-18', 'sys-admin'),
(4, 'LINE 3', '2021-09-18', 'sys-admin'),
(5, 'LINE 4', '2021-09-20', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_qa_inspection`
--

CREATE TABLE `t_qa_inspection` (
  `id` int NOT NULL,
  `kepi_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_inspected` decimal(15,3) NOT NULL,
  `critcal_part_list` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qa_operator` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qa_date` date NOT NULL,
  `qa_result` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failure_remark` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `defect_qty` decimal(15,3) NOT NULL DEFAULT '0.000',
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_qa_inspection`
--

INSERT INTO `t_qa_inspection` (`id`, `kepi_lot`, `qty_inspected`, `critcal_part_list`, `qa_operator`, `qa_date`, `qa_result`, `failure_remark`, `defect_qty`, `createdby`, `createdon`) VALUES
(1, 'KEPI1', '100.000', NULL, 'Tes', '2022-07-13', 'GOOD', '', '0.000', 'sys-admin', '2022-07-13 07:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

CREATE TABLE `t_role` (
  `roleid` int NOT NULL,
  `rolename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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
  `roleid` int NOT NULL,
  `menuid` int NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role Menu';

--
-- Dumping data for table `t_rolemenu`
--

INSERT INTO `t_rolemenu` (`roleid`, `menuid`, `createdon`, `createdby`) VALUES
(1, 1, '2021-08-07 00:00:00', 'sys-admin'),
(1, 5, '2021-09-07 00:00:00', 'sys-admin'),
(1, 6, '2021-08-07 00:00:00', 'sys-admin'),
(1, 7, '2021-08-07 00:00:00', 'sys-admin'),
(1, 8, '2021-08-07 00:00:00', 'sys-admin'),
(1, 9, '2021-08-07 00:00:00', 'sys-admin'),
(1, 10, '2021-08-07 00:00:00', 'sys-admin'),
(1, 11, '2021-08-07 00:00:00', 'sys-admin'),
(1, 12, '2021-09-07 00:00:00', 'sys-admin'),
(1, 17, '2021-09-07 00:00:00', 'sys-admin'),
(1, 19, '2021-08-14 00:00:00', 'sys-admin'),
(1, 20, '2021-08-14 00:00:00', 'sys-admin'),
(1, 24, '2021-09-15 00:00:00', 'sys-admin'),
(1, 25, '2021-09-16 00:00:00', 'sys-admin'),
(1, 26, '2021-09-18 00:00:00', 'sys-admin'),
(1, 27, '2021-09-18 00:00:00', 'sys-admin'),
(1, 28, '2021-09-20 00:00:00', 'sys-admin'),
(1, 29, '2021-10-02 00:00:00', 'sys-admin'),
(1, 30, '2022-06-01 00:00:00', 'sys-admin'),
(1, 31, '2022-06-12 00:00:00', 'sys-admin'),
(1, 32, '2022-06-16 00:00:00', 'sys-admin'),
(1, 33, '2022-06-18 00:00:00', 'sys-admin'),
(1, 34, '2022-06-19 00:00:00', 'sys-admin'),
(1, 35, '2022-06-19 00:00:00', 'sys-admin'),
(1, 36, '2022-06-19 00:00:00', 'sys-admin'),
(1, 37, '2022-06-19 00:00:00', 'sys-admin'),
(1, 38, '2022-06-29 00:00:00', 'sys-admin'),
(1, 39, '2022-07-15 00:00:00', 'sys-admin'),
(2, 4, '2021-08-20 00:00:00', 'sys-admin'),
(2, 5, '2021-08-20 00:00:00', 'sys-admin'),
(3, 12, '2021-08-20 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_role_avtivity`
--

CREATE TABLE `t_role_avtivity` (
  `roleid` int NOT NULL,
  `menuid` int NOT NULL,
  `activity` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 5, 'Create', 0, '2021-09-07'),
(1, 5, 'Delete', 0, '2021-09-07'),
(1, 5, 'Read', 1, '2021-09-07'),
(1, 5, 'Update', 0, '2021-09-07'),
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
(1, 12, 'Create', 1, '2021-09-07'),
(1, 12, 'Delete', 1, '2021-09-07'),
(1, 12, 'Read', 1, '2021-09-07'),
(1, 12, 'Update', 1, '2021-09-07'),
(1, 17, 'Create', 1, '2021-09-07'),
(1, 17, 'Delete', 1, '2021-09-07'),
(1, 17, 'Read', 1, '2021-09-07'),
(1, 17, 'Update', 1, '2021-09-07'),
(1, 19, 'Create', 1, '2021-08-14'),
(1, 19, 'Delete', 1, '2021-08-14'),
(1, 19, 'Read', 1, '2021-08-14'),
(1, 19, 'Update', 1, '2021-08-14'),
(1, 20, 'Create', 1, '2021-08-14'),
(1, 20, 'Delete', 1, '2021-08-14'),
(1, 20, 'Read', 1, '2021-08-14'),
(1, 20, 'Update', 1, '2021-08-14'),
(1, 24, 'Create', 1, '2021-09-19'),
(1, 24, 'Delete', 1, '2021-09-19'),
(1, 24, 'Read', 1, '2021-09-19'),
(1, 24, 'Update', 1, '2021-09-19'),
(1, 25, 'Create', 1, '2021-09-16'),
(1, 25, 'Delete', 1, '2021-09-16'),
(1, 25, 'Read', 1, '2021-09-16'),
(1, 25, 'Update', 1, '2021-09-16'),
(1, 26, 'Create', 1, '2021-09-18'),
(1, 26, 'Delete', 1, '2021-09-18'),
(1, 26, 'Read', 1, '2021-09-18'),
(1, 26, 'Update', 1, '2021-09-18'),
(1, 27, 'Create', 1, '2021-09-18'),
(1, 27, 'Delete', 1, '2021-09-18'),
(1, 27, 'Read', 1, '2021-09-18'),
(1, 27, 'Update', 1, '2021-09-18'),
(1, 28, 'Create', 0, '2021-09-20'),
(1, 28, 'Delete', 0, '2021-09-20'),
(1, 28, 'Read', 1, '2021-09-20'),
(1, 28, 'Update', 0, '2021-09-20'),
(1, 30, 'Create', 1, '2022-06-04'),
(1, 30, 'Delete', 1, '2022-06-04'),
(1, 30, 'Read', 1, '2022-06-04'),
(1, 30, 'Update', 1, '2022-06-04'),
(1, 31, 'Create', 1, '2022-06-12'),
(1, 31, 'Delete', 1, '2022-06-12'),
(1, 31, 'Read', 1, '2022-06-12'),
(1, 31, 'Update', 1, '2022-06-12'),
(1, 32, 'Create', 0, '2022-06-16'),
(1, 32, 'Delete', 0, '2022-06-16'),
(1, 32, 'Read', 1, '2022-06-16'),
(1, 32, 'Update', 0, '2022-06-16'),
(1, 33, 'Create', 1, '2022-06-18'),
(1, 33, 'Delete', 1, '2022-06-18'),
(1, 33, 'Read', 1, '2022-06-18'),
(1, 33, 'Update', 1, '2022-06-18'),
(1, 34, 'Create', 1, '2022-06-19'),
(1, 34, 'Delete', 1, '2022-06-19'),
(1, 34, 'Read', 1, '2022-06-19'),
(1, 34, 'Update', 1, '2022-06-19'),
(1, 35, 'Create', 1, '2022-06-19'),
(1, 35, 'Delete', 1, '2022-06-19'),
(1, 35, 'Read', 1, '2022-06-19'),
(1, 35, 'Update', 1, '2022-06-19'),
(1, 36, 'Create', 1, '2022-06-19'),
(1, 36, 'Delete', 1, '2022-06-19'),
(1, 36, 'Read', 1, '2022-06-19'),
(1, 36, 'Update', 1, '2022-06-19'),
(1, 37, 'Create', 1, '2022-06-19'),
(1, 37, 'Delete', 1, '2022-06-19'),
(1, 37, 'Read', 1, '2022-06-19'),
(1, 37, 'Update', 1, '2022-06-19'),
(1, 38, 'Create', 1, '2022-06-29'),
(1, 38, 'Delete', 1, '2022-06-29'),
(1, 38, 'Read', 1, '2022-06-29'),
(1, 38, 'Update', 1, '2022-06-29'),
(1, 39, 'Create', 0, '2022-07-15'),
(1, 39, 'Delete', 0, '2022-07-15'),
(1, 39, 'Read', 1, '2022-07-15'),
(1, 39, 'Update', 0, '2022-07-15'),
(2, 4, 'Create', 1, '2021-08-20'),
(2, 4, 'Delete', 1, '2021-08-20'),
(2, 4, 'Read', 1, '2021-08-20'),
(2, 4, 'Update', 1, '2021-08-20'),
(2, 5, 'Create', 0, '2021-08-20'),
(2, 5, 'Delete', 0, '2021-08-20'),
(2, 5, 'Read', 1, '2021-08-20'),
(2, 5, 'Update', 0, '2021-08-20'),
(3, 12, 'Create', 1, '2021-08-20'),
(3, 12, 'Delete', 0, '2021-08-20'),
(3, 12, 'Read', 1, '2021-08-20'),
(3, 12, 'Update', 1, '2021-08-20');

-- --------------------------------------------------------

--
-- Table structure for table `t_smt_line_process`
--

CREATE TABLE `t_smt_line_process` (
  `id` int NOT NULL,
  `assy_code` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepi_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode_serial` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `smt_line` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smt_shift` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ageing_process` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `ft_process` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_smt_line_process`
--

INSERT INTO `t_smt_line_process` (`id`, `assy_code`, `kepi_lot`, `barcode_serial`, `part_lot`, `smt_line`, `smt_shift`, `ageing_process`, `ft_process`, `createdby`, `createdon`) VALUES
(1, '1122334-01', 'KEPI1', 'QR01', 'LOT01', '1', '2', 'Y', 'Y', 'sys-admin', '2022-07-12 14:07:48'),
(2, '1122334-01', 'KEPI1', 'QR02', 'LOT02', '1', '1', 'Y', 'Y', 'sys-admin', '2022-07-12 14:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userlevel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` int DEFAULT NULL,
  `jabatan` int DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `approval` varchar(50) DEFAULT NULL,
  `reffid` varchar(30) DEFAULT NULL,
  `cust_id` int DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`username`, `password`, `nama`, `userlevel`, `department`, `jabatan`, `section`, `approval`, `reffid`, `cust_id`, `createdby`, `createdon`) VALUES
('Repairer', '$2y$12$FIiBfGhdlXb82TcRIPRQHuyh48vv8A1YKsLtYzvxQ/yj3drPPy.ry', 'REPAIRER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-12-01'),
('sys-admin', '$2y$12$YCj4abvz4tMxEoYys4/9sul.FX.9lyhoQzRdl8rI8LWxg1rQb7l/W', 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-08-07'),
('user1', '$2y$12$SRZKODU0plLDEMZAaYI.fui6/KDGc6.E4Yqs94VJOlQM/4wFhhl0C', 'User Demo 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user2', '$2y$12$TxnC2JmAeAJF0g1q9PoY/uc3lPj8MUvHC.pd3pQ.lryIQtLCIxlTC', 'User Demo 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user3', '$2y$12$fIf3TTIpwRY3dUXBhUqZ6uJcmrH./LAYduoY8wk948txHdADT4s4.', 'User Demo 3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user4', '$2y$12$vzXwT1.rWf8RxCRN1xsjYORke32hDwzbmG3KWtiuw9DRSX3Gg0In2', 'User Demo 4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user5', '$2y$12$ELa9pJc.Y9WziGtEWUhNa.KmTr.1uYMV7kEjojLuUZ5fgKFhT5H4.', 'User Demo 5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user6', '$2y$12$.MG0aufoFg4Aynxv.IKdGex1BEtBKcTi5xJAtuMoRFAf2GcnIxtQW', 'User Demo 6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user7', '$2y$12$9fIVcRmeSqLiK2HUyyB2Xe7ix6XO/o0N.5.RliGAoCQZet9AAXM4W', 'User Demo 7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user8', '$2y$12$n7s3vxO9AcnB.cR8d00.hOUP0M9tX/0smmg.a9ww0h7b6IuEp84JW', 'User Demo 8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08'),
('user9', '$2y$12$n7s3vxO9AcnB.cR8d00.hOUP0M9tX/0smmg.a9ww0h7b6IuEp84JW', 'User QQA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sys-admin', '2021-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_object_auth`
--

CREATE TABLE `t_user_object_auth` (
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ob_auth` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ob_value` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Object Authorization';

-- --------------------------------------------------------

--
-- Table structure for table `t_user_role`
--

CREATE TABLE `t_user_role` (
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleid` int NOT NULL,
  `createdon` datetime NOT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User Role';

--
-- Dumping data for table `t_user_role`
--

INSERT INTO `t_user_role` (`username`, `roleid`, `createdon`, `createdby`) VALUES
('sys-admin', 1, '2021-08-07 00:00:00', 'sys-admin'),
('sys-admin', 2, '2022-06-06 00:00:00', 'sys-admin'),
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
('user8', 2, '2021-08-08 00:00:00', 'sys-admin'),
('user9', 2, '2022-01-10 00:00:00', 'sys-admin'),
('user9', 3, '2022-01-10 00:00:00', 'sys-admin');

-- --------------------------------------------------------

--
-- Table structure for table `t_warehouse_issuance`
--

CREATE TABLE `t_warehouse_issuance` (
  `issuance_number` int NOT NULL,
  `barcode_serial` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_number` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_lot` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` decimal(15,3) DEFAULT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ageing_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ft_status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issueance_date` date DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdon` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_warehouse_issuance`
--

INSERT INTO `t_warehouse_issuance` (`issuance_number`, `barcode_serial`, `part_number`, `part_lot`, `quantity`, `location`, `status`, `ageing_status`, `ft_status`, `issueance_date`, `createdby`, `createdon`) VALUES
(1, 'QR01', '209080001', 'LOT01', '0.000', NULL, NULL, 'PENDING', 'PENDING', '2022-07-12', 'sys-admin', '2022-07-12'),
(2, 'QR02', '209080001', 'LOT02', '0.000', NULL, NULL, 'PENDING', 'PENDING', '2022-07-12', 'sys-admin', '2022-07-12');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_critichal_part1`
-- (See below for the actual view)
--
CREATE TABLE `v_critichal_part1` (
`smt_date` date
,`smt_line` varchar(50)
,`smt_shift` varchar(50)
,`hw_line` varchar(50)
,`hw_shift` varchar(50)
,`kepi_lot` varchar(50)
,`assy_code` varchar(70)
,`model` varchar(100)
,`barcode_serial` varchar(50)
,`part_lot` varchar(50)
,`manpower_name` varchar(50)
,`ageing_qty` decimal(15,3)
,`ageing_time` decimal(10,2)
,`ageing_result` varchar(50)
,`failure_remark` text
,`defect_quantity` decimal(15,3)
,`ft_result` varchar(100)
,`ft_failure_remark` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_defect_process`
-- (See below for the actual view)
--
CREATE TABLE `v_defect_process` (
`id` int
,`transactionid` varchar(50)
,`counter` int
,`repair_counter` int
,`process_defect` varchar(100)
,`process_location` varchar(100)
,`process_cause` varchar(100)
,`process_action` varchar(100)
,`process_remark` varchar(100)
,`repair_defect` varchar(100)
,`repair_location` varchar(100)
,`repair_cause` varchar(100)
,`repair_action` varchar(100)
,`repair_remark` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_productionview`
-- (See below for the actual view)
--
CREATE TABLE `v_productionview` (
`plandate` date
,`productionline` int
,`model` varchar(70)
,`lot_number` varchar(50)
,`shift` int
,`plan_qty` int
,`linename` varchar(60)
,`outputqty` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_productionview_shift1`
-- (See below for the actual view)
--
CREATE TABLE `v_productionview_shift1` (
`plandate` date
,`productionline` int
,`model` varchar(70)
,`shift` int
,`plan_qty` int
,`linename` varchar(60)
,`outputqty` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_productionview_shift2`
-- (See below for the actual view)
--
CREATE TABLE `v_productionview_shift2` (
`plandate` date
,`productionline` int
,`model` varchar(70)
,`shift` int
,`plan_qty` int
,`linename` varchar(60)
,`outputqty` bigint
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_report_transaction`
-- (See below for the actual view)
--
CREATE TABLE `v_report_transaction` (
`transactionid` varchar(20)
,`process_counter` int
,`prod_date` datetime
,`partnumber` varchar(70)
,`partmodel` varchar(100)
,`lotcode` varchar(30)
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
,`process9` varchar(30)
,`lastprocess` int
,`error_process` varchar(50)
,`defect_name` varchar(50)
,`location` varchar(50)
,`cause` varchar(50)
,`action` varchar(50)
,`repair_counter` int
,`repair1` varchar(30)
,`repair2` varchar(30)
,`repair3` varchar(30)
,`repair4` varchar(30)
,`repair5` varchar(30)
,`repair6` varchar(30)
,`repair7` varchar(30)
,`remark` varchar(50)
,`repair_defect` varchar(50)
,`repair_location` varchar(50)
,`repair_action` varchar(50)
,`lastrepair` int
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_smt_handwork_data`
-- (See below for the actual view)
--
CREATE TABLE `v_smt_handwork_data` (
`assy_code` varchar(70)
,`kepi_lot` varchar(50)
,`barcode_serial` varchar(50)
,`part_lot` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_menu`
-- (See below for the actual view)
--
CREATE TABLE `v_user_menu` (
`username` varchar(100)
,`roleid` int
,`rolename` varchar(50)
,`menuid` int
,`id` int
,`menu` varchar(50)
,`route` varchar(50)
,`type` varchar(20)
,`menugroup` int
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
`menugroup` int
,`description` varchar(50)
,`icon` varchar(200)
,`createdon` timestamp
,`createdby` varchar(50)
,`username` varchar(100)
,`_index` int
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_user_role_avtivity`
-- (See below for the actual view)
--
CREATE TABLE `v_user_role_avtivity` (
`roleid` int
,`menuid` int
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
-- Structure for view `v_critichal_part1`
--
DROP TABLE IF EXISTS `v_critichal_part1`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_critichal_part1`  AS SELECT DISTINCT cast(`t4`.`createdon` as date) AS `smt_date`, `t4`.`smt_line` AS `smt_line`, `t4`.`smt_shift` AS `smt_shift`, `t5`.`hw_line` AS `hw_line`, `t5`.`hw_shift` AS `hw_shift`, `t1`.`kepi_lot` AS `kepi_lot`, `t1`.`assy_code` AS `assy_code`, `t6`.`matdesc` AS `model`, `t1`.`barcode_serial` AS `barcode_serial`, `t1`.`part_lot` AS `part_lot`, `t2`.`manpower_name` AS `manpower_name`, `t2`.`quantity` AS `ageing_qty`, `t2`.`ageing_time` AS `ageing_time`, `t2`.`ageing_result` AS `ageing_result`, `t2`.`failure_remark` AS `failure_remark`, `t2`.`defect_quantity` AS `defect_quantity`, `t3`.`ft_result` AS `ft_result`, `t3`.`failure_remark` AS `ft_failure_remark` FROM ((((((select `t_smt_line_process`.`kepi_lot` AS `kepi_lot`,`t_smt_line_process`.`assy_code` AS `assy_code`,`t_smt_line_process`.`barcode_serial` AS `barcode_serial`,`t_smt_line_process`.`part_lot` AS `part_lot` from `t_smt_line_process` union select `t_handwork_process`.`kepi_lot` AS `kepi_lot`,`t_handwork_process`.`assy_code` AS `assy_code`,`t_handwork_process`.`barcode_serial` AS `barcode_serial`,`t_handwork_process`.`part_lot` AS `part_lot` from `t_handwork_process`) `t1` join `t_ageing` `t2` on(((`t1`.`kepi_lot` = `t2`.`kepi_lot`) and (`t1`.`barcode_serial` = `t2`.`barcode_serial`)))) join `t_ft_process` `t3` on(((`t1`.`kepi_lot` = `t3`.`kepi_lot`) and (`t1`.`barcode_serial` = `t3`.`barcode_serial`)))) join `t_smt_line_process` `t4` on(((`t1`.`kepi_lot` = `t4`.`kepi_lot`) and (`t1`.`barcode_serial` = `t4`.`barcode_serial`)))) join `t_handwork_process` `t5` on(((`t1`.`kepi_lot` = `t5`.`kepi_lot`) and (`t1`.`barcode_serial` = `t5`.`barcode_serial`)))) join `t_material` `t6` on((`t1`.`assy_code` = `t6`.`material`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_defect_process`
--
DROP TABLE IF EXISTS `v_defect_process`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_defect_process`  AS SELECT `a`.`id` AS `id`, `a`.`transactionid` AS `transactionid`, `a`.`counter` AS `counter`, `b`.`repair_counter` AS `repair_counter`, `a`.`defect` AS `process_defect`, `a`.`location` AS `process_location`, `a`.`cause` AS `process_cause`, `a`.`action` AS `process_action`, `a`.`repairremark` AS `process_remark`, `b`.`defect` AS `repair_defect`, `b`.`location` AS `repair_location`, `b`.`cause` AS `repair_cause`, `b`.`action` AS `repair_action`, `b`.`remark` AS `repair_remark` FROM (`t_defect_process` `a` left join `t_defect_repair` `b` on(((`a`.`transactionid` = `b`.`transactionid`) and (`a`.`counter` = `b`.`process_counter`) and (`a`.`id` = `b`.`defect_process_id`)))) ORDER BY `a`.`transactionid` ASC, `b`.`repair_counter` ASC, `a`.`id` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `v_productionview`
--
DROP TABLE IF EXISTS `v_productionview`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_productionview`  AS SELECT `a`.`plandate` AS `plandate`, `a`.`productionline` AS `productionline`, `a`.`model` AS `model`, `a`.`lot_number` AS `lot_number`, `a`.`shift` AS `shift`, `a`.`plan_qty` AS `plan_qty`, `b`.`description` AS `linename`, `fGetProdTotalQtyOutput`(`a`.`plandate`,`a`.`productionline`,`a`.`shift`,`a`.`model`,`a`.`lot_number`) AS `outputqty` FROM (`t_planning` `a` join `t_production_lines` `b` on((`a`.`productionline` = `b`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_productionview_shift1`
--
DROP TABLE IF EXISTS `v_productionview_shift1`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_productionview_shift1`  AS SELECT `a`.`plandate` AS `plandate`, `a`.`productionline` AS `productionline`, `a`.`model` AS `model`, `a`.`shift` AS `shift`, `a`.`plan_qty` AS `plan_qty`, `b`.`description` AS `linename`, `fGetProdTotalQtyOutput`(`a`.`plandate`,`a`.`productionline`,`a`.`shift`,`a`.`model`,`a`.`lot_number`) AS `outputqty` FROM (`t_planning` `a` join `t_production_lines` `b` on((`a`.`productionline` = `b`.`id`))) WHERE (`a`.`shift` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `v_productionview_shift2`
--
DROP TABLE IF EXISTS `v_productionview_shift2`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_productionview_shift2`  AS SELECT `a`.`plandate` AS `plandate`, `a`.`productionline` AS `productionline`, `a`.`model` AS `model`, `a`.`shift` AS `shift`, `a`.`plan_qty` AS `plan_qty`, `b`.`description` AS `linename`, `fGetProdTotalQtyOutput`(`a`.`plandate`,`a`.`productionline`,`a`.`shift`,`a`.`model`,`a`.`lot_number`) AS `outputqty` FROM (`t_planning` `a` join `t_production_lines` `b` on((`a`.`productionline` = `b`.`id`))) WHERE (`a`.`shift` = 2) ;

-- --------------------------------------------------------

--
-- Structure for view `v_report_transaction`
--
DROP TABLE IF EXISTS `v_report_transaction`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_report_transaction`  AS SELECT `a`.`transactionid` AS `transactionid`, `b`.`counter` AS `process_counter`, `a`.`prod_date` AS `prod_date`, `a`.`partnumber` AS `partnumber`, `a`.`partmodel` AS `partmodel`, `a`.`lotcode` AS `lotcode`, `a`.`serial_no` AS `serial_no`, `a`.`createdon` AS `createdon`, `b`.`process1` AS `process1`, `b`.`process2` AS `process2`, `b`.`process3` AS `process3`, `b`.`process4` AS `process4`, `b`.`process5` AS `process5`, `b`.`process6` AS `process6`, `b`.`process7` AS `process7`, `b`.`process8` AS `process8`, `b`.`process9` AS `process9`, `b`.`lastprocess` AS `lastprocess`, `b`.`error_process` AS `error_process`, `b`.`defect_name` AS `defect_name`, `b`.`location` AS `location`, `b`.`cause` AS `cause`, `b`.`action` AS `action`, `c`.`counter` AS `repair_counter`, `c`.`process1` AS `repair1`, `c`.`process2` AS `repair2`, `c`.`process3` AS `repair3`, `c`.`process4` AS `repair4`, `c`.`process5` AS `repair5`, `c`.`process6` AS `repair6`, `c`.`process7` AS `repair7`, `c`.`remark` AS `remark`, `c`.`defect_name` AS `repair_defect`, `c`.`location` AS `repair_location`, `c`.`action` AS `repair_action`, `c`.`lastrepair` AS `lastrepair` FROM ((`t_ipd_forms` `a` left join `t_ipd_process` `b` on((`a`.`transactionid` = `b`.`transactionid`))) left join `t_ipd_repair` `c` on(((`a`.`transactionid` = `c`.`transactionid`) and (`b`.`counter` = `c`.`process_counter`)))) ORDER BY `a`.`transactionid` ASC, `a`.`serial_no` ASC, `a`.`partnumber` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `v_smt_handwork_data`
--
DROP TABLE IF EXISTS `v_smt_handwork_data`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_smt_handwork_data`  AS SELECT `t_handwork_process`.`assy_code` AS `assy_code`, `t_handwork_process`.`kepi_lot` AS `kepi_lot`, `t_handwork_process`.`barcode_serial` AS `barcode_serial`, `t_handwork_process`.`part_lot` AS `part_lot` FROM `t_handwork_process` ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_menu`
--
DROP TABLE IF EXISTS `v_user_menu`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_user_menu`  AS SELECT `a`.`username` AS `username`, `b`.`roleid` AS `roleid`, `f`.`rolename` AS `rolename`, `c`.`menuid` AS `menuid`, `d`.`id` AS `id`, `d`.`menu` AS `menu`, `d`.`route` AS `route`, `d`.`type` AS `type`, `d`.`menugroup` AS `menugroup`, `d`.`grouping` AS `grouping`, `d`.`icon` AS `icon`, `d`.`createdon` AS `createdon`, `d`.`createdby` AS `createdby` FROM ((((`t_user` `a` join `t_user_role` `b` on((`a`.`username` = `b`.`username`))) join `t_rolemenu` `c` on((`c`.`roleid` = `b`.`roleid`))) join `t_menus` `d` on((`d`.`id` = `c`.`menuid`))) join `t_role` `f` on((`f`.`roleid` = `b`.`roleid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_menugroup`
--
DROP TABLE IF EXISTS `v_user_menugroup`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_user_menugroup`  AS SELECT `a`.`menugroup` AS `menugroup`, `a`.`description` AS `description`, `a`.`icon` AS `icon`, `a`.`createdon` AS `createdon`, `a`.`createdby` AS `createdby`, `b`.`username` AS `username`, `a`.`_index` AS `_index` FROM (`t_menugroups` `a` join `v_user_menu` `b` on((`a`.`menugroup` = `b`.`menugroup`))) ORDER BY `a`.`_index` ASC, `a`.`menugroup` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `v_user_role_avtivity`
--
DROP TABLE IF EXISTS `v_user_role_avtivity`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `v_user_role_avtivity`  AS SELECT `a`.`roleid` AS `roleid`, `a`.`menuid` AS `menuid`, `a`.`activity` AS `activity`, `a`.`status` AS `status`, `a`.`createdon` AS `createdon`, `b`.`route` AS `route`, `b`.`menu` AS `menu`, `c`.`username` AS `username`, `d`.`rolename` AS `rolename` FROM (((`t_role_avtivity` `a` join `t_menus` `b` on((`a`.`menuid` = `b`.`id`))) join `t_user_role` `c` on((`a`.`roleid` = `c`.`roleid`))) join `t_role` `d` on((`a`.`roleid` = `d`.`roleid`))) ORDER BY `c`.`username` ASC, `d`.`rolename` ASC ;

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
-- Indexes for table `t_ageing`
--
ALTER TABLE `t_ageing`
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
-- Indexes for table `t_barcode_serial`
--
ALTER TABLE `t_barcode_serial`
  ADD PRIMARY KEY (`barcode_serial`);

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
-- Indexes for table `t_defect_process`
--
ALTER TABLE `t_defect_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_defect_repair`
--
ALTER TABLE `t_defect_repair`
  ADD PRIMARY KEY (`transactionid`,`counter`,`defect_process_id`,`repair_counter`,`process_counter`);

--
-- Indexes for table `t_ft_process`
--
ALTER TABLE `t_ft_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_handwork_process`
--
ALTER TABLE `t_handwork_process`
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
  ADD PRIMARY KEY (`transactionid`,`counter`);

--
-- Indexes for table `t_ipd_repair`
--
ALTER TABLE `t_ipd_repair`
  ADD PRIMARY KEY (`transactionid`,`counter`,`process_counter`);

--
-- Indexes for table `t_line_masters`
--
ALTER TABLE `t_line_masters`
  ADD PRIMARY KEY (`lineid`);

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
-- Indexes for table `t_part_location`
--
ALTER TABLE `t_part_location`
  ADD PRIMARY KEY (`part_number`,`assy_location`);

--
-- Indexes for table `t_planning`
--
ALTER TABLE `t_planning`
  ADD PRIMARY KEY (`plandate`,`productionline`,`shift`,`model`,`partnumber`,`lot_number`);

--
-- Indexes for table `t_planning_output`
--
ALTER TABLE `t_planning_output`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_process_sequence`
--
ALTER TABLE `t_process_sequence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_production_lines`
--
ALTER TABLE `t_production_lines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_qa_inspection`
--
ALTER TABLE `t_qa_inspection`
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
-- Indexes for table `t_smt_line_process`
--
ALTER TABLE `t_smt_line_process`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `t_warehouse_issuance`
--
ALTER TABLE `t_warehouse_issuance`
  ADD PRIMARY KEY (`issuance_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_actionlist`
--
ALTER TABLE `t_actionlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_ageing`
--
ALTER TABLE `t_ageing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_causelist`
--
ALTER TABLE `t_causelist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_defectlist`
--
ALTER TABLE `t_defectlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_defect_process`
--
ALTER TABLE `t_defect_process`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `t_ft_process`
--
ALTER TABLE `t_ft_process`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_handwork_process`
--
ALTER TABLE `t_handwork_process`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_locationlist`
--
ALTER TABLE `t_locationlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_menugroups`
--
ALTER TABLE `t_menugroups`
  MODIFY `menugroup` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_menus`
--
ALTER TABLE `t_menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `t_planning_output`
--
ALTER TABLE `t_planning_output`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `t_process_sequence`
--
ALTER TABLE `t_process_sequence`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `t_production_lines`
--
ALTER TABLE `t_production_lines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_qa_inspection`
--
ALTER TABLE `t_qa_inspection`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
  MODIFY `roleid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_smt_line_process`
--
ALTER TABLE `t_smt_line_process`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_warehouse_issuance`
--
ALTER TABLE `t_warehouse_issuance`
  MODIFY `issuance_number` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
