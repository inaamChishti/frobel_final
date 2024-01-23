-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: sdb-51.hosting.stackcp.net
-- Generation Time: Dec 09, 2022 at 05:29 AM
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
-- Database: `frobel_new_sms-353030333074`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `custom_password`, `remember_token`, `created_at`, `updated_at`) VALUES
(10, 'Super Admin', 'superadmin', 'superadmin@frobel.uk', '2022-12-08 07:04:31', '$2y$10$UAe7eYA1LxakqbFgYcjA9.jQpR2qvH.QjggwHZitK8rBeksA8hzz.', '12345678', 'jwv0QYXh5CRYRHn9sGaIldZgWo4ybz23FGrHXIsobjwaZSBeBYev0042nRww', '2022-12-08 07:04:31', '2022-12-08 07:04:31'),
(11, 'Dev User', 'biztechsols', 'dev@biztechsols.com', '2022-12-08 07:04:31', '$2y$10$yWHQtwpRKW1zPongW4Zvae.37v.5ZYTl4s/8lmRSQLtG7gDGmQAwu', '12345678', 'L191In7VmAJj1j34FrKYqW61jnsGCqgbn4IUfQWWU71KoLEaQWjI32BNYZ5D', '2022-12-08 07:04:31', '2022-12-08 07:04:31'),
(12, 'Mohammad', 'Mohammad', 'Mohammad@frobel.co.uk', NULL, '$2y$10$Ls2BX5SL7lvAhHa2bbzTK.Z6b7EgVEvqyr8akFzO7yhW5Kh78aTUW', 'frobel@456', NULL, '2022-12-09 05:02:31', '2022-12-09 05:02:31'),
(13, 'yiqbal', 'yiqbal', 'yiqbal@frobel.co.uk', NULL, '$2y$10$fMp5NL0FXZfw0l36Br/nL.5nFI94xYb5IaUJHu2MRm48c486rJeke', 'rameses', NULL, '2022-12-09 05:03:08', '2022-12-09 05:03:08'),
(14, 'yen', 'yen', 'yen@frobel.co.uk', NULL, '$2y$10$kIa1zd/LljcXW7eH/qvoLeiqiXij86th/OOEGpLguHn3WDf.rkKZG', 'yenfrobel', NULL, '2022-12-09 05:03:36', '2022-12-09 05:03:36'),
(15, 'hassan', 'hassan', 'hassan@frobel.co.uk', NULL, '$2y$10$WsPYsYWRbM/zRuxeLIrKO.8Bl10ChJ9sP.9qf47/1hZZAVlAgD3Tu', 'HassanFrobel', NULL, '2022-12-09 05:03:59', '2022-12-09 05:03:59'),
(16, 'areeb', 'areeb', 'areeb@frobel.co.uk', NULL, '$2y$10$cy8nzEEXN/3caZSg2xNv.epp8T45v5PKoTO.M8pWhHvgp8C47ZAcO', 'areeb123', NULL, '2022-12-09 05:04:22', '2022-12-09 05:04:22'),
(17, 'office', 'office', 'office@frobel.co.uk', NULL, '$2y$10$aC7nWgSLTJxmINHuwM2D8uc9GH2imkP.qC4Al.xn9vKapQB3RKtvO', 'office123', NULL, '2022-12-09 05:04:56', '2022-12-09 05:04:56'),
(18, 'amber', 'amber', 'amber@frobel.co.uk', NULL, '$2y$10$occqAFKU1LFayEYevXJgDeRNbY7Fp6QBzc/7L3CzWq4MRKyCb2C5y', 'amber@123', NULL, '2022-12-09 05:05:37', '2022-12-09 05:05:37'),
(19, 'fozia.k', 'fozia.k', 'fozia.k@frobel.co.uk', NULL, '$2y$10$6G4eYp51FMYwH7mIJeS2B.ctxFukoAuJO.OF6hsOj5nmKS0MNTyli', 'khadijaamina', NULL, '2022-12-09 05:06:01', '2022-12-09 05:06:01'),
(20, 'sameera', 'sameera', 'sameera@frobel.co.uk', NULL, '$2y$10$K2My2V1cNHUcUGAhdw5aDOzyXW9kjpy18NhXubwmPCfOhzgYCPeEK', 'Sameer001', NULL, '2022-12-09 05:06:25', '2022-12-09 05:06:25'),
(21, 'finance', 'finance', 'finance@frobel.co.uk', NULL, '$2y$10$7kB2lrHKxmKYmaPqEqy/ouXaq0x6vZ8RHReXLkS723o7KvIsRyQNS', 'irfanfinance', NULL, '2022-12-09 05:06:49', '2022-12-09 05:06:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
