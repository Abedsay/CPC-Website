-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 28, 2024 at 08:42 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `appointmentid` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `drid` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `reasonforvisit` varchar(255) DEFAULT NULL,
  `daily_schedule_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`appointmentid`),
  KEY `id` (`id`),
  KEY `drid` (`drid`),
  KEY `daily_schedule_id` (`daily_schedule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointmentid`, `id`, `drid`, `date`, `time`, `status`, `reasonforvisit`, `daily_schedule_id`) VALUES
(3, 6002, 1000, '2024-04-11', '11:00:00', 'Scheduled', 'follow-up', 42),
(2, 6001, 1100, '2024-04-10', '10:00:00', 'Scheduled', 'consultation', 2),
(0, 6009, 1100, '2024-04-26', '16:35:55', 'Scheduled', 'Checkup', 9),
(4, 6000, 1000, '2024-04-11', '15:00:00', 'Completed', 'routine', 63);

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

DROP TABLE IF EXISTS `clinic`;
CREATE TABLE IF NOT EXISTS `clinic` (
  `clinic_id` int(11) NOT NULL,
  `clinic_name` varchar(100) NOT NULL,
  PRIMARY KEY (`clinic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`clinic_id`, `clinic_name`) VALUES
(1, 'Public Health'),
(2, 'Ear, Nose Throat'),
(3, 'Dentistry'),
(4, 'Cardiology'),
(5, 'Physical Therapy');

-- --------------------------------------------------------

--
-- Table structure for table `daily_schedule`
--

DROP TABLE IF EXISTS `daily_schedule`;
CREATE TABLE IF NOT EXISTS `daily_schedule` (
  `daily_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('available','booked','unavailable') DEFAULT 'available',
  `appointment_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) NOT NULL,
  PRIMARY KEY (`daily_schedule_id`),
  KEY `schedule_id` (`schedule_id`),
  KEY `appointment_id` (`appointment_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daily_schedule`
--

INSERT INTO `daily_schedule` (`daily_schedule_id`, `schedule_id`, `date`, `start_time`, `end_time`, `status`, `appointment_id`, `doctor_id`) VALUES
(1, 1, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1100),
(2, 1, '2024-04-01', '10:00:00', '11:00:00', 'booked', 2, 1100),
(3, 1, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1100),
(4, 1, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1100),
(5, 1, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1100),
(6, 1, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1100),
(7, 1, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1100),
(8, 1, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1100),
(9, 2, '2024-04-01', '09:00:00', '10:00:00', 'booked', 0, 1100),
(10, 2, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1100),
(11, 2, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1100),
(12, 2, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1100),
(13, 2, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1100),
(14, 2, '2024-04-01', '14:00:00', '15:00:00', 'unavailable', NULL, 1100),
(15, 2, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1100),
(16, 2, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1100),
(17, 3, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1100),
(18, 3, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1100),
(19, 3, '2024-04-01', '11:00:00', '12:00:00', 'unavailable', NULL, 1100),
(20, 3, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1100),
(21, 3, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1100),
(22, 3, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1100),
(23, 3, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1100),
(24, 3, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1100),
(25, 4, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1100),
(26, 4, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1100),
(27, 4, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1100),
(28, 4, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1100),
(29, 4, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1100),
(30, 4, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1100),
(31, 4, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1100),
(32, 4, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1100),
(33, 5, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1100),
(34, 5, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1100),
(35, 5, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1100),
(36, 5, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1100),
(37, 5, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1100),
(38, 5, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1100),
(39, 5, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1100),
(40, 5, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1100),
(41, 6, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1000),
(42, 6, '2024-04-01', '10:00:00', '11:00:00', 'booked', 3, 1000),
(43, 6, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1000),
(44, 6, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1000),
(45, 6, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1000),
(46, 6, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1000),
(47, 6, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1000),
(48, 6, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1000),
(49, 7, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1000),
(50, 7, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1000),
(51, 7, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1000),
(52, 7, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1000),
(53, 7, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1000),
(54, 7, '2024-04-01', '14:00:00', '15:00:00', 'unavailable', NULL, 1000),
(55, 7, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1000),
(56, 7, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1000),
(57, 8, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1000),
(58, 8, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1000),
(59, 8, '2024-04-01', '11:00:00', '12:00:00', 'unavailable', NULL, 1000),
(60, 8, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1000),
(61, 8, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1000),
(62, 8, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1000),
(63, 8, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1000),
(64, 8, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1000),
(65, 9, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1000),
(66, 9, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1000),
(67, 9, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1000),
(68, 9, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1000),
(69, 9, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1000),
(70, 9, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1000),
(71, 9, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1000),
(72, 9, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1000),
(73, 10, '2024-04-01', '09:00:00', '10:00:00', 'available', NULL, 1000),
(74, 10, '2024-04-01', '10:00:00', '11:00:00', 'available', NULL, 1000),
(75, 10, '2024-04-01', '11:00:00', '12:00:00', 'available', NULL, 1000),
(76, 10, '2024-04-01', '12:00:00', '13:00:00', 'unavailable', NULL, 1000),
(77, 10, '2024-04-01', '13:00:00', '14:00:00', 'available', NULL, 1000),
(78, 10, '2024-04-01', '14:00:00', '15:00:00', 'available', NULL, 1000),
(79, 10, '2024-04-01', '15:00:00', '16:00:00', 'available', NULL, 1000),
(80, 10, '2024-04-01', '16:00:00', '17:00:00', 'available', NULL, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `doctor_id` int(100) NOT NULL,
  `clid` int(100) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  PRIMARY KEY (`doctor_id`),
  KEY `clid` (`clid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `clid`, `first_name`, `last_name`) VALUES
(1000, 3, 'Adam', 'Smith'),
(1100, 1, 'Bader', 'Houran'),
(3009, 5, 'mohammad', 'adel');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

DROP TABLE IF EXISTS `doctor_schedule`;
CREATE TABLE IF NOT EXISTS `doctor_schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`schedule_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`schedule_id`, `doctor_id`, `day_of_week`, `start_time`, `end_time`) VALUES
(1, 1100, 'Monday', '09:00:00', '17:00:00'),
(2, 1100, 'Tuesday', '09:00:00', '17:00:00'),
(3, 1100, 'Wednesday', '09:00:00', '17:00:00'),
(4, 1100, 'Thursday', '09:00:00', '17:00:00'),
(5, 1100, 'Friday', '09:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `department`, `mobile`) VALUES
(1, 'Bader ', 'cardiology ', '555-0110'),
(2, ' Lana', 'cardiology', '555-0111'),
(3, 'John Doe', 'Public Health', '555-0100'),
(4, 'Jane Smith', 'Public Health', '555-0101'),
(5, 'Emily Johnson', 'Pharmacy', '555-0102'),
(6, 'Michael Brown', 'Pharmacy', '555-0103'),
(7, 'Rachel Green', 'ENT', '555-0104'),
(8, 'Luis Blue', 'ENT', '555-0105'),
(9, 'Sofia Black', 'Dentistry', '555-0106'),
(10, 'Noah White', 'Dentistry', '555-0107'),
(11, 'Oliver Gray', 'Lab', '555-0108'),
(12, 'Amelia Gold', 'Lab', '555-0109'),
(13, 'Abdulaziz', 'Physical Therpy', '70738343'),
(14, 'Abdullah', 'Physical Therpy', '555-0113');

-- --------------------------------------------------------

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
CREATE TABLE IF NOT EXISTS `insurance` (
  `insuranceid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `insurancetype` varchar(255) DEFAULT NULL,
  `policynumber` varchar(255) DEFAULT NULL,
  `insuranceprovider` varchar(255) DEFAULT NULL,
  `effectivedate` date DEFAULT NULL,
  `expirationdate` date DEFAULT NULL,
  PRIMARY KEY (`insuranceid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `insurance`
--

INSERT INTO `insurance` (`insuranceid`, `id`, `insurancetype`, `policynumber`, `insuranceprovider`, `effectivedate`, `expirationdate`) VALUES
(1, 6000, 'Health', '123456789', 'ABC Insurance Company', '2024-01-01', '2024-12-31'),
(2, 6001, 'Dental', '987654321', 'XYZ Dental Insurance', '2023-03-15', '2024-03-14'),
(4, 6006, 'Health Insurance', '', '', '0000-00-00', '0000-00-00'),
(3, 6005, 'Health Insurance', '', '', '0000-00-00', '0000-00-00'),
(5, 6007, 'Health Insurance', '', '', '0000-00-00', '0000-00-00'),
(6, 6008, 'Health Insurance', '', '', '0000-00-00', '0000-00-00'),
(7, 6009, 'Health Insurance', '11', 'Company X', '2024-04-04', '2024-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `labtestresult`
--

DROP TABLE IF EXISTS `labtestresult`;
CREATE TABLE IF NOT EXISTS `labtestresult` (
  `resultid` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `testdate` date DEFAULT NULL,
  `testname` varchar(255) DEFAULT NULL,
  `result` decimal(10,2) DEFAULT NULL,
  `referencerange` varchar(100) DEFAULT NULL,
  `units` varchar(50) DEFAULT NULL,
  `flag` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notes` text,
  `seenbypatient` tinyint(1) NOT NULL,
  `seenbydr` tinyint(1) NOT NULL,
  PRIMARY KEY (`resultid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `labtestresult`
--

INSERT INTO `labtestresult` (`resultid`, `id`, `testdate`, `testname`, `result`, `referencerange`, `units`, `flag`, `notes`, `seenbypatient`, `seenbydr`) VALUES
(1, 6000, '2024-04-20', 'Hemoglobin A1c', '6.20', '4.0-5.6', '%', 'Slightly elevated', 'Patient diagnosed with prediabetes', 1, 1),
(2, 6001, '2024-04-21', 'Thyroid Stimulating Hormone (TSH)', '2.80', '0.4-4.0', 'mIU/L', 'Normal', 'No abnormalities detected in thyroid function', 1, 1),
(4, 6009, '2024-05-01', 'Blood Test', '0.00', 'none', 'none', 'positive', 'none', 0, 0),
(3, 6000, '2024-04-02', 'f', '0.00', 'ff', 'f', 'f', 'f', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `medicalrecord`
--

DROP TABLE IF EXISTS `medicalrecord`;
CREATE TABLE IF NOT EXISTS `medicalrecord` (
  `recordid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `allergies` text,
  `pastmed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `currentmed` text,
  `findings` text,
  `diagnosis` text,
  `treatment` text,
  `seenbypatient` tinyint(1) NOT NULL,
  PRIMARY KEY (`recordid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `medicalrecord`
--

INSERT INTO `medicalrecord` (`recordid`, `id`, `allergies`, `pastmed`, `currentmed`, `findings`, `diagnosis`, `treatment`, `seenbypatient`) VALUES
(1, 6000, 'None', 'Hypertension', 'Lisinopril 10mg daily', 'Elevated blood pressure', 'Hypertension', 'Prescribe Lisinopril and advise lifestyle modifications', 1),
(2, 6001, ' Penicillin', 'None', 'None', 'Redness and swelling in the throat', 'Strep throat', 'Prescribe Amoxicillin and recommend rest and fluids', 1),
(3, 6005, ' strawberry', 'None', 'None', 'you have an allergy from strawberry', 'allergy', 'you need to take medications', 1),
(4, 6009, ' none', 'none', 'none', 'Elevated blood pressure', 'Hypertension', 'Take Lisinopril and advise lifestyle modifications', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

DROP TABLE IF EXISTS `medication`;
CREATE TABLE IF NOT EXISTS `medication` (
  `medid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`medid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `medication`
--

INSERT INTO `medication` (`medid`, `name`, `quantity`) VALUES
(1, 'Aspirin', 10),
(2, 'Diphenhydramine', 10),
(3, 'Loratadine', 10),
(4, 'Ibuprofen', 10),
(5, 'Acetaminophen', 10),
(6, 'Bismuth Subsalicylate', 10),
(7, 'Loperamide', 10),
(8, 'Calcium Carbonate', 10),
(9, 'Saline Nasal Spray', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orderlabtest`
--

DROP TABLE IF EXISTS `orderlabtest`;
CREATE TABLE IF NOT EXISTS `orderlabtest` (
  `orderid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `testype` varchar(255) DEFAULT NULL,
  `reason` text,
  `seenbypatient` tinyint(1) NOT NULL,
  `seenbytech` tinyint(1) NOT NULL,
  PRIMARY KEY (`orderid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orderlabtest`
--

INSERT INTO `orderlabtest` (`orderid`, `id`, `testype`, `reason`, `seenbypatient`, `seenbytech`) VALUES
(1, 6000, 'Blood Test', 'Routine check-up', 1, 1),
(2, 6001, 'X-Ray', 'Suspected fracture in the arm', 1, 1),
(3, 6000, 'Blood Test', 'Blood group identification', 1, 0),
(4, 6000, 'Blood Test', '00', 1, 0),
(5, 6000, 'Blood Test', '00', 1, 0),
(6, 6009, 'Blood Test', 'identify blood group', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(20) NOT NULL,
  `insurance` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `gender`, `dob`, `email`, `phone`, `insurance`) VALUES
(6000, 'Ranim Ali', 'female', '1999-10-09', 'ranimmm@gmail.com', 3111111, 1),
(6001, 'Walid Itani', 'male', '2000-01-14', 'walidd@hotmail.com', 76777777, 1),
(6002, 'Jana Kamel', 'female', '2007-01-03', 'jannaa@gmail.com', 3456789, 1),
(6003, 'abd', 'male', '2004-03-10', 'abd@gmail.com', 3456678, 0),
(6004, 'nireez', 'female', '2004-01-18', 'nireez.alsweidan@lau.edu', 3456789, 1),
(24, 'jana', 'female', '0000-00-00', 'jana@gmail.com', 98765, 0),
(25, 'Mayan Al Ashy', 'female', '0000-00-00', 'mayanalashy@gmail.com', 81964405, 0),
(6005, 'Sara Azzam', 'female', '2009-02-24', 'sara@gmail.com', 3765322, 0),
(6006, 'Ramzi Haraty', 'male', '2024-04-19', 'rharatty@lau.edu.lb', 3111111, 0),
(6007, 'ramzi', 'male', '2015-02-03', 'rharatty@lau.edu.lb', 98765344, 0),
(6008, 'mayan', 'female', '2007-01-30', 'mayan@gmail.com', 98765433, 0),
(6009, 'Sana Itani', 'female', '1998-06-11', 'sana@gmail.com', 3123456, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
CREATE TABLE IF NOT EXISTS `prescription` (
  `preid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `medication` varchar(255) DEFAULT NULL,
  `dosage` varchar(255) DEFAULT NULL,
  `instructions` text,
  `seenbypatient` tinyint(1) NOT NULL,
  `seenbyphar` tinyint(1) NOT NULL,
  PRIMARY KEY (`preid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`preid`, `id`, `medication`, `dosage`, `instructions`, `seenbypatient`, `seenbyphar`) VALUES
(1, 6000, 'panadol', 'once a week', 'after eating', 1, 1),
(2, 6001, 'profin', 'twice a week', 'before sleeping', 1, 1),
(3, 6000, 'panadol', 'once a week', 'o', 1, 1),
(4, 6000, 'panadol', 'once a week', 'o', 1, 1),
(5, 6005, 'panadol', 'once a week', 'for better sleep', 1, 1),
(6, 6009, 'panadol', 'once a week', 'before sleep', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `type`) VALUES
(1000, 'Adam Smith', 'adamsmith@cpc.com', 'pass1', 'doctor'),
(1100, 'Bader Houran', 'baderhouran@cpc.com', 'pass2', 'doctor'),
(2000, 'Rami Hassan', 'ramihassan@cpc.com', 'pass3', 'receptionist'),
(3000, 'Lana Omar', 'lanaomar@cpc.com', 'pass4', 'pharmacist'),
(4000, 'Hadi kabbani', 'hadikabbani@cpc.com', 'pass5', 'labtechnician'),
(5000, 'Lina Adnan', 'linaadnan@cpc.com', 'pass6', 'manager'),
(6001, 'Walid Itani', 'waliditani@cpc.com', 'pass9', 'patient'),
(6000, 'Ranim Ali', 'ranimali@cpc.com', 'pass7', 'patient'),
(6002, 'Jana Kamel', 'janakamel@cpc.com', 'pass10', 'patient'),
(6005, 'Sara Azzam', 'saraazzam@cpc.com', 'pass777', 'patient'),
(3009, 'Mohammad Adel', 'mohammadadel@cpc.com', 'pass111', 'doctor'),
(6008, 'mayan', 'mayan@cpc.com', 'pass00', 'patient'),
(6009, 'Sana Itani', 'sanaitani@cpc.com', 'sana1', 'patient');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
