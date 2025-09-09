-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 08:49 AM
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
-- Database: `sentinel_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `email` varchar(160) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'new',
  `ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `email`, `message`, `status`, `ip`, `created_at`) VALUES
(10, 'test', 'test', 'tefascascsa@gmail.com', 'ascascascas', 'new', '192.168.3.246', '2025-09-05 07:02:50');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `email` varchar(160) DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('new','done','archived') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(160) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `position` varchar(160) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `first_name`, `last_name`, `email`, `resume_path`, `notes`, `status`, `created_at`, `name`, `mobile`, `position`, `message`) VALUES
(2, 'test', '', 'test@gmail.com', 'uploads/resumes/resume_2025-09-04_11-53-06_68b9618298dee.pdf', NULL, 'new', '2025-09-04 09:53:06', 'test', 'sadasdsa', 'CCTV Operators', 'sadasd'),
(3, 'lebron', 'james', 'lebronjames@gmail.com', 'uploads/resumes/resume_2025-09-05_05-27-34_68ba58a6ad639.pdf', NULL, 'new', '2025-09-05 03:27:34', 'lebron james', '098754569874', 'Security Guards', 'sssacascascasdfasf'),
(5, 'fjiasnviodsvndsjvnk', '', 'ndvsdojvnds@gmail.com', 'uploads/resumes/resume_2025-09-05_09-36-31_68ba92ffdc6b9.pdf', NULL, 'new', '2025-09-05 07:36:31', 'fjiasnviodsvndsjvnk', '123124891215', 'Receptionist', 'dfdsfsdfsd'),
(6, 'lebron', 'James', 'lebronjames@gmail.com', 'uploads/resumes/resume_2025-09-08_08-03-15_68be71a342dc8.pdf', NULL, 'archived', '2025-09-08 06:03:15', 'lebron James', '123456789001', 'Security Officers', 'asdascascas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
