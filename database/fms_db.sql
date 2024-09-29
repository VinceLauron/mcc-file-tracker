-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 10:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `id` int(11) NOT NULL,
  `verification_code` varchar(15) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `id_number` varchar(12) NOT NULL,
  `year_graduated` varchar(10) NOT NULL,
  `school_graduated` varchar(100) NOT NULL,
  `program_graduated` varchar(100) NOT NULL,
  `admission` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`id`, `verification_code`, `fullname`, `email`, `password`, `contact`, `address`, `sex`, `dob`, `occupation`, `id_number`, `year_graduated`, `school_graduated`, `program_graduated`, `admission`, `is_verified`) VALUES
(88, '643654', 'Roxan Hilba', 'roxanhilba17@gmail.com', '', '09505501863', '', 'Female', '2000-06-28', '', '2020-1212', '2023', '', 'BSIT', '2020', 1),
(90, '662364', 'Bryan James Desuyo', 'bryanjamesdesuyo15@gmail.com', '', '09123767434', '', 'Male', '2003-05-15', '', '2021-1407', '2025', '', 'BSIT', '2021', 1);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_number` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` text NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_number`, `fullname`, `name`, `description`, `user_id`, `folder_id`, `file_type`, `file_path`, `file_name`, `is_public`, `date_updated`) VALUES
(38, '212863916736', 'rolly recabar', 'bantayan', 'cute', 1, 11, 'jpg', '1718952300_bantayan.jpg', '', 0, '2024-06-21 14:45:27'),
(44, '925899206894', 'vince lauron simuelle', 'maya', 'cute ako', 1, 0, 'png', '1718958420_maya.png', '', 0, '2024-06-21 21:20:24'),
(45, '352050093990', 'vince lauron simuelle', 'image', 'for capstone only', 1, 14, 'jpg', '1718976060_448419021_7658616977540041_1247959626365689670_n.jpg', '', 0, '2024-06-21 21:21:58'),
(46, '283569122930', 'vince lauron simuelle', 'VINCE', 'agfafgad', 1, 0, 'jpg', '1718978940_448419021_7658616977540041_1247959626365689670_n.jpg', '', 0, '2024-06-25 13:36:17'),
(47, '065057693318', 'rolly recabar', 'Screenshot (103)', 'cue', 1, 0, 'png', '1719041160_Screenshot (103).png', '', 0, '2024-06-22 15:26:16'),
(48, '118238754620', 'argie magallanes', 'maya ||1', 'hahhaah', 1, 0, 'png', '1719283860_maya.png', '', 0, '2024-06-25 10:51:51'),
(50, '751899944151', 'vince lauron simuelle', 'Innovative presentation - JJV', 'innovative', 3, 0, '', '1719389880_Innovative presentation - JJV..pptx', '', 0, '2024-06-26 16:18:16'),
(51, '239391047770', 'vincelauron', 'ryan123', 'afafaf', 1, 0, 'pptx', '1719472440_ryan123.pptx', '', 0, '2024-06-27 15:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `file_track`
--

CREATE TABLE `file_track` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tracking_number` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_track`
--

INSERT INTO `file_track` (`id`, `user_id`, `tracking_number`, `date_created`) VALUES
(1, 1, 2147483647, '2024-06-21 21:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `parent_id` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `user_id`, `name`, `description`, `parent_id`) VALUES
(11, 1, 'Enrolless', '', 0),
(14, 1, 'mcc nso', '', 0),
(15, 1, 'Certificates', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'unread',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `course` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `id_number` varchar(15) NOT NULL,
  `docu_type` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','onprocess','released','rejected','') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `is_verified` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=admin',
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `lock_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `verification_code`, `is_verified`, `type`, `reset_token`, `reset_token_expiry`, `failed_attempts`, `lock_time`) VALUES
(94, 'Roxan hilba', 'roxanhilba17@gmail.com', '923ba791253f0056a1924e29c5c966dd', '', 'Verified', 1, NULL, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_track`
--
ALTER TABLE `file_track`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
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
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `file_track`
--
ALTER TABLE `file_track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
