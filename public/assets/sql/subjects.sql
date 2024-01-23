-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: sdb-53.hosting.stackcp.net
-- Generation Time: Dec 12, 2022 at 10:55 AM
-- Server version: 10.4.26-MariaDB-log
-- PHP Version: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frobel_new_sms-353030356922`
--

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'English', '2022-12-11 09:35:01', '2022-12-11 09:35:01'),
(4, 'Science', '2022-12-11 09:35:17', '2022-12-11 09:35:17'),
(5, 'Physics', '2022-12-11 09:35:27', '2022-12-11 09:35:27'),
(6, 'Chemistry', '2022-12-11 09:35:33', '2022-12-11 09:35:33'),
(7, 'Mathematics', '2022-12-11 09:35:45', '2022-12-11 09:35:45'),
(8, 'E.Language', '2022-12-11 09:37:36', '2022-12-11 09:37:36'),
(9, 'E.Literature', '2022-12-11 09:37:49', '2022-12-11 09:37:49'),
(10, 'Psychology', '2022-12-11 09:49:42', '2022-12-11 09:49:42'),
(11, 'Business', '2022-12-11 09:49:58', '2022-12-11 09:49:58'),
(12, 'Geography', '2022-12-11 09:50:14', '2022-12-11 09:50:14'),
(13, 'History', '2022-12-11 09:50:33', '2022-12-11 09:50:33'),
(14, 'Biology', '2022-12-11 09:51:11', '2022-12-11 09:51:11'),
(15, 'Politics', '2022-12-11 09:52:03', '2022-12-11 09:52:03'),
(16, 'Law', '2022-12-11 09:52:12', '2022-12-11 09:52:12'),
(17, 'Computer Science', '2022-12-11 09:53:16', '2022-12-11 09:53:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
