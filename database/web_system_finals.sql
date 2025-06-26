-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 08:27 PM
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
  `relationship` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opd_records`
--

INSERT INTO `opd_records` (`id`, `patient_id`, `date_time`, `attending_physician`, `chief_complaint`, `bp`, `pr`, `rr`, `temp`, `weight`, `height`, `fullname_signature`, `relationship`) VALUES
(1, 29, '2025-06-21 18:58:00', 'test', 'test', '101', '101', '101', '101', '45', '1.56', 'test', 'test'),
(2, 29, '2025-06-21 19:08:00', 'test2', 'test2', '101', '101', '101', '101', '45', '1.56', 'test2', 'test2'),
(3, 32, '2025-06-21 19:35:00', 'test', 'test', '101', '101', '101', '101', '45', '1.56', NULL, NULL);

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
(47, 'Test', 'Test', 'Test', 'Female', '2025-05-13', 'Test', '0', NULL, '', 'Testingggg', '2025-06-17 10:14:31', 'Single', 'Test', 'Test', ''),
(48, 'Sample', '', 'Sample', 'Male', '2022-06-08', '', '2', NULL, 'sample@gmail.com', '', '2025-06-17 10:14:34', 'Single', '', '', '');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `firstname`, `lastname`, `middlename`, `created_at`) VALUES
(20, 'cheskaasha', '1234', 'admin', 'Cheska Asha', 'Garcia', 'Salcedo', '2025-05-12 16:56:53'),
(38, 'motnosaj10', '123!@mot<324', 'staff', 'Tom ', 'Umali', 'Dumlao', '2025-05-13 10:49:52'),
(45, 'test', 'test', 'staff', 'Sample Name', 'Test', 'Test', '2025-05-13 15:08:11'),
(46, 'ashasg', '0000', 'admin', 'Asha', 'Salcedo', '', '2025-05-13 15:08:13'),
(47, 'emssme', 'ememe', 'staff', 'Ems', 'Ems', 'EMs', '2025-05-14 00:42:08'),
(48, 'alaiasalcedo', '1113', 'staff', 'Alaia', 'Salcedo', '', '2025-05-14 00:52:44'),
(49, 'sample', 'sample', 'staff', 'Sample', 'Sample', '', '2025-05-14 01:43:43'),
(50, 'adahdua@gm', '1234', 'admin', 'roselara', 'jj', 'jjj', '2025-05-14 01:44:30'),
(52, 'eman', '202003', 'admin', 'Emanuel', 'Gonzales', 'Mercado', '2025-06-18 10:49:38');

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
  MODIFY `archived_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `archived_users`
--
ALTER TABLE `archived_users`
  MODIFY `archived_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opd_records`
--
ALTER TABLE `opd_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

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
