-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 11:10 PM
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
-- Database: `medispritus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(2, 'ree', '456');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `doctor_id`, `appointment_date`, `status`, `created_at`) VALUES
(11, 10, 12, '2025-04-28', 'Pending', '2025-04-21 18:03:20'),
(12, 11, 3, '2025-04-23', 'Pending', '2025-04-21 18:13:24'),
(13, 11, 14, '2025-04-27', 'Pending', '2025-04-21 18:13:51'),
(15, 11, 18, '2025-04-23', 'Pending', '2025-04-21 20:56:17'),
(16, 11, 16, '2025-04-24', 'Pending', '2025-04-21 20:58:59');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `availability` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `availability`, `created_at`, `status`) VALUES
(3, 'Dr. Sarker', 'Psychartic', 'Tue-Thu', '2024-12-18 23:43:48', 'Inactive'),
(4, 'Dr. Nion Mondol', 'Children', 'Tue-Thu', '2024-12-19 01:22:09', 'Active'),
(11, 'Dr.Stranger', 'Neurologist', 'SUN-TUE', '2025-04-21 13:11:27', 'Inactive'),
(12, 'Dr.Mike', 'Orthodontist', 'Thus-Sat', '2025-04-21 13:28:31', 'Active'),
(13, 'Dr.River', 'Cardiologist', 'MON - WED', '2025-04-21 13:31:13', 'Inactive'),
(14, 'Dr.Rachel', 'Dermatologist', 'MON - WED', '2025-04-21 13:31:51', 'Active'),
(16, 'Dr.Jhon Sn', 'Neurologist', 'SUN-TUE', '2025-04-21 18:55:06', 'Active'),
(17, 'Dr.Airen', 'Cardiologist', 'mon-wed', '2025-04-21 18:58:01', 'Active'),
(18, 'Dr. Phobee', 'Children', 'Thus-Sat', '2025-04-21 19:01:32', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback_text` text NOT NULL,
  `reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `resolved` tinyint(1) DEFAULT 0,
  `status` enum('Unresolved','Resolved') DEFAULT 'Unresolved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `feedback_text`, `reply`, `created_at`, `updated_at`, `resolved`, `status`) VALUES
(15, 11, 'Good', NULL, '2025-04-21 19:02:49', '2025-04-21 19:02:49', 0, 'Unresolved'),
(16, 11, 'Bad management', NULL, '2025-04-21 19:06:32', '2025-04-21 19:06:32', 0, 'Unresolved'),
(17, 12, 'nice', NULL, '2025-04-21 19:07:51', '2025-04-21 19:07:51', 0, 'Unresolved'),
(18, 11, 'good', 'ok', '2025-04-21 20:59:53', '2025-04-21 21:01:10', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nurse_name` varchar(100) NOT NULL,
  `service_date` date NOT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`id`, `user_id`, `nurse_name`, `service_date`, `status`, `created_at`) VALUES
(9, 11, 'Wednesday', '2025-04-30', 'Pending', '2025-04-21 15:09:56'),
(10, 11, 'Reha', '2025-04-29', 'Pending', '2025-04-21 19:06:01'),
(11, 11, 'Reha', '2025-04-25', 'Pending', '2025-04-21 20:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `test_date` date NOT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `user_id`, `test_name`, `test_date`, `status`, `created_at`) VALUES
(9, 11, 'Blood Test', '2025-04-25', 'Pending', '2025-04-21 15:11:58'),
(10, 10, 'Blood Test', '2025-04-24', 'Pending', '2025-04-21 18:04:28'),
(11, 12, 'X-ray for teeth', '2025-04-24', 'Pending', '2025-04-21 19:07:39'),
(13, 11, 'Blood Test', '2025-04-25', 'Pending', '2025-04-21 20:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(10, 'Toyny', 'tony123@gmal.com', '$2y$10$7jPkPDn5T6sAi/E8GXZJYe1tgRXVBZlB8rCU2Rb5LrVUIGtsApLOO', '2025-04-21 14:13:32'),
(11, 'ponyo', 'ponyo@gmail.com', '$2y$10$J1WqbU7kw3r1g0.w/IMpFeYkQMmXsIlENEAgpUqUNRJR9VPAo.gw.', '2025-04-21 14:59:22'),
(12, 'akjkv', 'ajkjv@gmail.com', '$2y$10$qWWLz/HNmVwguxISco9lV.AkkNW1iG697RXozZH2Mb/UxBs3ZXubO', '2025-04-21 15:36:26'),
(14, 'GHY', 'ghy@gnail.com', '$2y$10$l3jO2hNqvp7NI458/V7G7uUEb8Wkn9R5R86Z7TPZ/stj7xuX0NOe2', '2025-04-21 20:54:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
