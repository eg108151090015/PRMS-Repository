-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 07:03 AM
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
-- Database: `web_system_finals`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission_records`
--

CREATE TABLE `admission_records` (
  `record_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `admitting_personnel` varchar(100) DEFAULT NULL,
  `admission_datetime` datetime DEFAULT NULL,
  `admission_type` varchar(50) DEFAULT NULL,
  `referred_by` varchar(100) DEFAULT NULL,
  `attending_physician` varchar(100) DEFAULT NULL,
  `discharge_datetime` datetime DEFAULT NULL,
  `total_days` int(11) DEFAULT NULL,
  `ward_services` varchar(100) DEFAULT NULL,
  `insurance` varchar(255) DEFAULT NULL,
  `allergic_to` varchar(255) DEFAULT NULL,
  `admission_diagnosis` text DEFAULT NULL,
  `final_diagnosis` text DEFAULT NULL,
  `icd_code` varchar(50) DEFAULT NULL,
  `procedre` text DEFAULT NULL,
  `other_procedures` text DEFAULT NULL,
  `injury_code` varchar(100) DEFAULT NULL,
  `place_occurrence` varchar(100) DEFAULT NULL,
  `disposition` varchar(100) DEFAULT NULL,
  `outcome` varchar(100) DEFAULT NULL,
  `autopsy` varchar(50) DEFAULT NULL,
  `informant_name` varchar(100) DEFAULT NULL,
  `relation` varchar(100) DEFAULT NULL,
  `informant_contact` varchar(150) DEFAULT NULL,
  `physician_signature` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission_records`
--

INSERT INTO `admission_records` (`record_id`, `patient_id`, `admitting_personnel`, `admission_datetime`, `admission_type`, `referred_by`, `attending_physician`, `discharge_datetime`, `total_days`, `ward_services`, `insurance`, `allergic_to`, `admission_diagnosis`, `final_diagnosis`, `icd_code`, `procedre`, `other_procedures`, `injury_code`, `place_occurrence`, `disposition`, `outcome`, `autopsy`, `informant_name`, `relation`, `informant_contact`, `physician_signature`) VALUES
(2, 21, 'Cheska', '2025-05-12 19:12:00', 'New', 'Not specified', 'Alaia Salcedo', '0000-00-00 00:00:00', 0, 'Female', 'None', '', 'Cough', 'Primary Complex', NULL, NULL, '', '', 'House', 'Transferred', '', 'No', 'Tom Jason Umali', 'Father', '09694065633', 'Alaia Salcedo'),
(3, 24, '', '2024-08-08 00:48:00', 'New', 'Not specified', '', '0000-00-00 00:00:00', 4, '', 'None', '', '', '', NULL, NULL, '', '', '', 'Discharge', '', 'No', '', '', '', ''),
(4, 1, 'Alaia Salcedo', '2025-05-13 15:20:00', 'New', 'Not specified', 'Cheska Garcia', '0000-00-00 00:00:00', 0, '', 'None', '', '', '', NULL, NULL, '', '', 'House', 'Transferred', '', 'No', '', '', '', ''),
(5, 29, 'Asha Salcedo', '2025-05-13 16:36:00', 'New', 'Test', 'Test', '0000-00-00 00:00:00', 0, 'Test', 'None', 'Test', 'Test', 'Test', NULL, NULL, 'Test', 'Test', 'Test', 'Discharge', 'Test', 'No', 'Test', 'Test', 'Test', 'Test'),
(6, 33, 'Test', '2025-05-13 18:48:00', 'New', 'Not specified', '', '0000-00-00 00:00:00', 0, '', 'None', '', '', '', NULL, NULL, '', '', '', 'Discharge', '', 'No', '', '', '', ''),
(7, 34, 'Test', '2025-05-13 22:38:00', 'New', 'Not specified', '', '0000-00-00 00:00:00', 0, 'Test', 'None', 'Test', 'Test', 'Test', NULL, NULL, '', '', 'Test', 'Transferred', '', 'No', '', '', '', ''),
(8, 37, 'Admit', '2024-11-06 23:04:00', 'Old', 'Not specified', 'Alaia Salcedo', '0000-00-00 00:00:00', 6, 'Male', 'None', 'None', 'Test', 'Test', NULL, NULL, 'Test', 'Test', 'Test', 'Discharge', '', 'No', 'Test', '', '', ''),
(9, 40, '', '0000-00-00 00:00:00', 'New', 'Not specified', '', '0000-00-00 00:00:00', 0, '', 'None', '', '', '', NULL, NULL, '', '', '', 'Discharge', '', 'No', '', '', '', ''),
(10, 32, 'Sample Name', '2025-05-14 09:38:00', 'New', 'Not specified', '', '0000-00-00 00:00:00', 0, '', 'None', '', '', '', NULL, NULL, '', '', '', 'Discharge', '', 'No', 'sample', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `archived_patients`
--

CREATE TABLE `archived_patients` (
  `archived_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `birth_place` varchar(45) DEFAULT NULL,
  `age` varchar(45) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(45) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `civil_status` enum('Single','Married','Widowed','Divorced') DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_patients`
--

INSERT INTO `archived_patients` (`archived_id`, `patient_id`, `record_id`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `birth_place`, `age`, `contact_number`, `email_address`, `address`, `created_at`, `civil_status`, `nationality`, `religion`, `occupation`, `archived_at`) VALUES
(24, 58, NULL, 'test3', 'test3', 'test3', 'Male', '2025-06-29', 'test3', '0', '09623752862', 'emanuel.gonzales.mercado@gmail.com', 'test3', '2025-06-29 11:37:26', 'Single', 'asdasdasd', 'asdsadsad', 'asdasdasd', '2025-06-29 11:37:26'),
(25, 61, NULL, 'sdasda', '', 'hahaa', 'Male', '2025-06-02', '', '0', '', '', '', '2025-06-30 06:19:45', 'Single', '', '', '', '2025-06-30 06:19:45'),
(28, 67, NULL, 'dsfd', '', 'dsfds', 'Male', '2025-07-01', '', '0', '', '', '', '2025-07-01 15:59:03', 'Single', '', '', '', '2025-07-01 15:59:03'),
(29, 68, NULL, 'dsf', '', 'dsfds', 'Male', '2025-07-02', '', '0', '', '', '', '2025-07-01 16:03:31', 'Single', '', '', '', '2025-07-01 16:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `archived_users`
--

CREATE TABLE `archived_users` (
  `archived_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_users`
--

INSERT INTO `archived_users` (`archived_id`, `user_id`, `username`, `password`, `role`, `firstname`, `lastname`, `middlename`, `archived_at`) VALUES
(32, 61, 'test2', '$2y$10$R6imNCSCJjvmTXoXKW9NE.EJulhvU38BLGIAZMns5tFrFVx1a1VV6', 'staff', 'test2', 'test2', '', '2025-07-02 04:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opd_records`
--

CREATE TABLE `opd_records` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `attending_physician` varchar(100) DEFAULT NULL,
  `chief_complaint` varchar(255) DEFAULT NULL,
  `bp` varchar(20) DEFAULT NULL,
  `pr` varchar(20) DEFAULT NULL,
  `rr` varchar(20) DEFAULT NULL,
  `temp` varchar(20) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `fullname_signature` varchar(255) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `history_of_present_illness` varchar(200) DEFAULT NULL,
  `impressions_diagnosis` varchar(200) DEFAULT NULL,
  `treatment_medications` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opd_records`
--

INSERT INTO `opd_records` (`id`, `patient_id`, `date_time`, `attending_physician`, `chief_complaint`, `bp`, `pr`, `rr`, `temp`, `weight`, `height`, `fullname_signature`, `relationship`, `history_of_present_illness`, `impressions_diagnosis`, `treatment_medications`) VALUES
(1, 29, '2025-06-21 18:58:00', 'test', 'test', '101', '101', '101', '101', '45', '1.56', 'test', 'test', NULL, NULL, NULL),
(2, 29, '2025-06-21 19:08:00', 'test2', 'test2', '101', '101', '101', '101', '45', '1.56', 'test2', 'test2', NULL, NULL, NULL),
(3, 32, '2025-06-21 19:35:00', 'test', 'test', '101', '101', '101', '101', '45', '1.56', NULL, NULL, NULL, NULL, NULL),
(4, 29, '2025-06-27 18:20:00', 'test', 'test2', '101', '101', '101', '101', '45', '1.56', NULL, NULL, 'test', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `birth_place` varchar(45) NOT NULL,
  `age` varchar(45) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(45) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `civil_status` enum('Single','Married','Widowed','Separated','Divorced') NOT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `last_name`, `middle_name`, `first_name`, `gender`, `date_of_birth`, `birth_place`, `age`, `contact_number`, `email_address`, `address`, `created_at`, `civil_status`, `nationality`, `religion`, `occupation`) VALUES
(29, 'Garcia', 'Salcedo', 'Cheska Asha', 'Female', '2003-12-23', 'Las Pinas City', '21', '0964065633', 'cheskaasha@gmail.com', '33 BLISS, Biga 2, Silang, Cavite', '2025-05-13 06:46:08', 'Single', 'Filipino', 'Roman Catholic', 'Test'),
(32, 'Umali', 'Garcia', 'Calista Taylor', 'Female', '2024-11-13', 'Silang', '0', NULL, 'cheskaasha@gmail.com', 'Silang, Cavite', '2025-05-13 08:12:55', 'Single', 'Filipino', 'Catholic', 'N/A'),
(37, 'Carlos', '', 'Juan', 'Male', '2000-02-10', 'Sample', '25', '0969694646', 'sample@gmail.com', 'Sample Address', '2025-05-13 15:04:23', 'Married', 'Sample', 'Sample', 'Sample'),
(45, 'Sample', '', 'Sample', 'Female', '2005-11-09', 'Sample', '19', NULL, 'sample@gmail.com', 'Sample', '2025-05-14 01:38:30', 'Single', 'Sample', 'Sample', 'Sample'),
(52, 'sasdsad', 'asdasdasd', 'tetete', 'Male', '2025-06-03', 'asdasdasd', '0', NULL, '', 'asdasdasda', '2025-06-29 08:37:28', 'Single', 'asdasdasd', 'asdsadsad', 'asdasdasd'),
(53, 'Sample', '', 'Sample', 'Male', '2022-06-08', '', '2', NULL, 'sample@gmail.com', '', '2025-06-29 08:40:04', 'Single', '', '', ''),
(57, 'dsfdsfdsf', 'dfsd', 'sdfs', 'Male', '2025-06-29', 'sdfds', '0', '09237652762', '', 'sdf', '2025-06-29 10:29:08', 'Single', 'fdf', 'sada', 'sdsdfsdf'),
(59, 'Test', 'Test', 'Test', 'Female', '2025-05-13', 'Test', '0', NULL, '', 'Testingggg', '2025-06-29 10:44:22', 'Single', 'Test', 'Test', 'asdasdasd'),
(60, 'test2', 'test2', 'test2', 'Male', '2025-06-29', '', '0', '', '', 'test2', '2025-06-29 10:45:07', 'Single', '', '', ''),
(62, 'fhgfhg', 'fhgfh', 'asd', 'Male', '2025-07-01', 'asdasdasd', '0', '09623752862', '', 'gfhgf', '2025-07-01 13:01:18', 'Single', 'sadas', 'sad', 'sdasd'),
(65, 'dfgd', '', 'dsfds', 'Male', '2025-07-02', '', '0', '', '', 'dfgfd', '2025-07-01 14:56:53', 'Single', '', '', ''),
(69, 'sdfdsf', '', 'dsfsdf', 'Male', '2025-07-01', '', '0', NULL, '', '', '2025-07-01 16:06:25', 'Single', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `firstname`, `lastname`, `middlename`, `created_at`, `status`) VALUES
(20, 'cheskaasha', '$2y$10$5TD1BgK4EWAmwt31oFO2k.0WX4riwiGFKBztZPurAXoH2ettS6Pku', 'admin', 'Cheska Asha', 'Garcia', 'Salcedo', '2025-05-12 16:56:53', 'active'),
(52, 'eman', '$2y$10$ZviwfHMUVKMdXhfDzYPwWekXZtPP7G4UjbhmcEVPVnbA/SEoMrCDe', 'admin', 'Emanuel', 'Gonzales', 'Mercado', '2025-06-18 10:49:38', 'active'),
(54, 'test', '$2y$10$ntZVDDYAzKKMYmIdW6yEc.jt8X0fPcWIvYdsNOqHqPfRrya8jy/Pa', 'staff', 'test', 'test', 'test', '2025-06-29 09:24:14', 'active'),
(59, 'motnosaj10', '$2y$10$MvOmClnztmDFb5VSjnMgkOmQpLACpsZ1tXAt78dhaF9UabWk7wb32', 'staff', 'Tom', 'Umali', 'Dumlao', '2025-07-01 15:52:03', 'active'),
(61, 'test2', '$2y$10$R6imNCSCJjvmTXoXKW9NE.EJulhvU38BLGIAZMns5tFrFVx1a1VV6', 'staff', 'test2', 'test2', '', '2025-07-02 04:47:02', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`log_id`, `user_id`, `action`, `timestamp`) VALUES
(1, 52, 'Updated user account (ID: 52, Name: Gonzales Emanuel Mercado, Role: Staff)', '2025-06-29 09:20:15'),
(2, 52, 'Deactivated user account (ID: 53, Name: Sample Sample )', '2025-06-29 09:21:08'),
(3, 52, 'Deactivated user account (ID: 50, Name: jj roselara jjj)', '2025-06-29 09:21:30'),
(4, 52, 'Deactivated user account (ID: 48, Name: Salcedo Alaia )', '2025-06-29 09:21:35'),
(5, 52, 'Deactivated user account (ID: 47, Name: Ems Ems EMs)', '2025-06-29 09:21:39'),
(6, 52, 'Deactivated user account (ID: 46, Name: Salcedo Asha )', '2025-06-29 09:21:43'),
(7, 52, 'Deactivated user account (ID: 45, Name: Test Sample Name Test)', '2025-06-29 09:21:47'),
(8, 52, 'Updated user account (ID: 52, Name: Gonzales Emanuel Mercado, Role: Admin)', '2025-06-29 09:23:01'),
(9, 52, 'Updated user account (ID: 20, Name: Garcia Cheska Asha Salcedo, Role: Staff)', '2025-06-29 09:23:41'),
(10, 52, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Staff)', '2025-06-29 09:23:50'),
(11, 52, 'Added new user account (ID: 54, Name: test test test, Role: Staff)', '2025-06-29 09:24:14'),
(12, 52, 'Updated user account (ID: 20, Name: Garcia Cheska Asha Salcedo, Role: Admin)', '2025-06-29 09:30:27'),
(13, 54, 'Updated user account (ID: 20, Name: Garcia Cheska Asha Salcedo, Role: Admin)', '2025-06-29 09:52:52'),
(14, 54, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Staff)', '2025-06-29 09:53:07'),
(15, 54, 'Updated user account (ID: 52, Name: Gonzales Emanuel Mercado, Role: Admin)', '2025-06-29 09:53:23'),
(16, 52, 'Archived patient record (ID: 54, Name: Test Test Test)', '2025-06-29 09:54:24'),
(17, 52, 'Restored patient information (ID: 54, Name: Test Test Test)', '2025-06-29 09:54:38'),
(18, 52, 'Added new patient (ID: 56, Name: test3 test3 test3)', '2025-06-29 09:56:18'),
(19, 52, 'Archived patient record (ID: 56, Name: test3 test3 test3)', '2025-06-29 09:56:55'),
(20, 52, 'Edited patient information (ID: 55, Name: Test Test Test)', '2025-06-29 09:57:39'),
(21, 52, 'Updated user account (ID: 54, Name: test test test, Role: Staff)', '2025-06-29 10:09:29'),
(22, 52, 'Updated user account (ID: 54, Name: test test test, Role: Staff)', '2025-06-29 10:26:03'),
(23, 52, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Staff)', '2025-06-29 10:26:58'),
(24, 54, 'Restored patient information (ID: 56, Name: test3 test3 test3)', '2025-06-29 10:40:14'),
(25, 54, 'Archived patient record (ID: 55, Name: Test Test Test)', '2025-06-29 10:40:42'),
(26, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 10:41:14'),
(27, 54, 'Restored patient information (ID: 55, Name: Test Test Test)', '2025-06-29 10:44:22'),
(28, 54, 'Added new patient (ID: 60, Name: test2 test2 test2)', '2025-06-29 10:45:08'),
(29, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 10:45:41'),
(30, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 10:56:35'),
(31, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 11:24:53'),
(32, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 11:26:25'),
(33, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 11:33:46'),
(34, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-06-29 11:36:21'),
(35, 52, 'Archived patient record (ID: 58, Name: test3 test3 test3)', '2025-06-29 11:37:27'),
(36, 52, 'Added new patient (ID: 61, Name: sdasda hahaa )', '2025-06-30 06:14:47'),
(37, 52, 'Archived patient record (ID: 61, Name: sdasda hahaa )', '2025-06-30 06:19:45'),
(38, 52, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 12:54:19'),
(39, 52, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 13:00:34'),
(40, 52, 'Added new patient (ID: 62, Name: fhgfhg asd fhgfh)', '2025-07-01 13:01:18'),
(41, 52, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 13:02:18'),
(42, 54, 'Added new patient (ID: 63, Name: dfgd dsfds )', '2025-07-01 13:03:02'),
(43, 54, 'Edited patient information (ID: 63, Name: dfgd dsfds )', '2025-07-01 13:03:20'),
(44, 52, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 14:41:06'),
(45, 52, 'Added new patient (ID: 64, Name: sdfdsf dsfsdf )', '2025-07-01 14:41:22'),
(46, 52, 'Archived patient record (ID: 64, Name: sdfdsf dsfsdf )', '2025-07-01 14:41:37'),
(47, 52, 'Archived patient record (ID: 63, Name: dfgd dsfds )', '2025-07-01 14:56:28'),
(48, 52, 'Restored patient information (ID: 63, Name: dfgd dsfds )', '2025-07-01 14:56:53'),
(49, 52, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Staff)', '2025-07-01 15:05:51'),
(50, 52, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Staff)', '2025-07-01 15:06:11'),
(51, 52, 'Updated user account (ID: 54, Name: test test test, Role: Staff)', '2025-07-01 15:14:22'),
(52, 52, 'Updated user account (ID: 20, Name: Garcia Cheska Asha Salcedo, Role: Admin)', '2025-07-01 15:23:06'),
(53, 52, 'Updated user account (ID: 20, Name: Garcia Cheska Asha Salcedo, Role: Admin)', '2025-07-01 15:23:11'),
(54, 52, 'Updated user account (ID: 20, Name: Garcia Cheska Asha Salcedo, Role: Admin)', '2025-07-01 15:27:52'),
(55, 52, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Admin)', '2025-07-01 15:28:55'),
(56, 52, 'Updated user account (ID: 54, Name: test test test1, Role: Staff)', '2025-07-01 15:34:45'),
(57, 52, 'Updated user account (ID: 38, Name: Umali Tom Dumlao, Role: Staff)', '2025-07-01 15:34:55'),
(58, 52, 'Added new user account (ID: 55, Name: fdsfs sdfsdf fdgfd, Role: Staff)', '2025-07-01 15:35:31'),
(59, 52, 'Updated user account (ID: 55, Name: fdsfs sdfsdf , Role: Staff)', '2025-07-01 15:35:46'),
(60, 52, 'Deactivated user account (ID: 55, Name: fdsfs sdfsdf )', '2025-07-01 15:36:00'),
(61, 52, 'Activated user account (ID: 55, Name: fdsfs sdfsdf )', '2025-07-01 15:36:40'),
(62, 52, 'Restored patient information (ID: 64, Name: sdfdsf dsfsdf )', '2025-07-01 15:37:00'),
(63, 52, 'Deactivated user account (ID: 56, Name: fdsfs sdfsdf )', '2025-07-01 15:37:46'),
(64, 52, 'Activated user account (ID: 56, Name: fdsfs sdfsdf )', '2025-07-01 15:38:55'),
(65, 52, 'Deactivated user account (ID: 57, Name: fdsfs sdfsdf )', '2025-07-01 15:39:03'),
(66, 52, 'Activated user account (ID: 57, Name: fdsfs sdfsdf )', '2025-07-01 15:39:57'),
(67, 52, 'Deactivated user account (ID: 58, Name: fdsfs sdfsdf )', '2025-07-01 15:40:04'),
(68, 52, 'Updated user account (ID: 54, Name: test test test, Role: Staff)', '2025-07-01 15:40:18'),
(69, 52, 'Deactivated user account (ID: 38, Name: Umali Tom Dumlao)', '2025-07-01 15:51:52'),
(70, 52, 'Activated user account (ID: 38, Name: Umali Tom Dumlao)', '2025-07-01 15:52:03'),
(71, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 15:58:35'),
(72, 54, 'Added new patient (ID: 67, Name: dsfd dsfds )', '2025-07-01 15:58:55'),
(73, 54, 'Archived patient record (ID: 67, Name: dsfd dsfds )', '2025-07-01 15:59:03'),
(74, 54, 'Added new patient (ID: 68, Name: dsf dsfds )', '2025-07-01 16:03:10'),
(75, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 16:03:24'),
(76, 54, 'Archived patient record (ID: 68, Name: dsf dsfds )', '2025-07-01 16:03:32'),
(77, 54, 'Archived patient record (ID: 66, Name: sdfdsf dsfsdf )', '2025-07-01 16:06:11'),
(78, 54, 'Restored patient information (ID: 66, Name: sdfdsf dsfsdf )', '2025-07-01 16:06:25'),
(79, 54, 'Edited patient information (ID: 29, Name: Garcia Cheska Asha Salcedo)', '2025-07-01 16:06:56'),
(80, 52, 'Activated user account (ID: 58, Name: fdsfs sdfsdf )', '2025-07-02 04:18:50'),
(81, 52, 'Deactivated user account (ID: 60, Name: fdsfs sdfsdf )', '2025-07-02 04:19:00'),
(82, 52, 'Activated user account (ID: 54, Name: test test test)', '2025-07-02 04:45:27'),
(83, 52, 'Added new user account (ID: 61, Name: test2 test2 , Role: Staff)', '2025-07-02 04:47:04'),
(84, 52, 'Deactivated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:47:12'),
(85, 52, 'Activated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:47:24'),
(86, 52, 'Deactivated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:50:38'),
(87, 52, 'Activated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:50:48'),
(88, 52, 'Deactivated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:51:44'),
(89, 52, 'Activated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:57:59'),
(90, 52, 'Deactivated user account (ID: 61, Name: test2 test2 )', '2025-07-02 04:58:06'),
(91, 52, 'Deactivated user account (ID: 54, Name: test test test)', '2025-07-02 04:59:21'),
(92, 52, 'Activated user account (ID: 54, Name: test test test)', '2025-07-02 05:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `visit_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `symptoms` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `treatment` text DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission_records`
--
ALTER TABLE `admission_records`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `archived_patients`
--
ALTER TABLE `archived_patients`
  ADD PRIMARY KEY (`archived_id`),
  ADD KEY `record_id` (`record_id`);

--
-- Indexes for table `archived_users`
--
ALTER TABLE `archived_users`
  ADD PRIMARY KEY (`archived_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `opd_records`
--
ALTER TABLE `opd_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`visit_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission_records`
--
ALTER TABLE `admission_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `archived_patients`
--
ALTER TABLE `archived_patients`
  MODIFY `archived_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `archived_users`
--
ALTER TABLE `archived_users`
  MODIFY `archived_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_records`
--
ALTER TABLE `opd_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archived_patients`
--
ALTER TABLE `archived_patients`
  ADD CONSTRAINT `archived_patients_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `admission_records` (`record_id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `opd_records`
--
ALTER TABLE `opd_records`
  ADD CONSTRAINT `opd_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
