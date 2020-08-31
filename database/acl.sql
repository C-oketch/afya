-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2016 at 03:07 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acl`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'List of Words', 'Stolen from kenya police', '2016-09-29 10:09:35', '2016-09-29 10:09:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_07_03_113552_entrust_setup_tables', 1),
('2016_07_03_142937_create_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'Display Role Listing', 'See only Listing Of Role', '2016-09-29 06:45:00', NULL),
(2, 'item-list', 'Display Item Listing', 'See only Item Of Role', '2016-09-29 06:45:00', NULL),
(3, 'role-create', 'Create Role', 'Create New Role', '2016-09-29 06:45:00', NULL),
(4, 'role-edit', 'Edit Role', 'Edit Role', '2016-09-29 06:45:00', NULL),
(5, 'role-delete', 'Delete Role', 'Delete Role', '2016-09-29 06:45:00', NULL),
(6, 'item-create', 'Create Item', 'Create New Item', '2016-09-29 06:45:00', NULL),
(7, 'item-edit', 'Edit Item', 'Edit Item', '2016-09-29 06:45:00', NULL),
(8, 'item-delete', 'Delete Item', 'Delete Item', '2016-09-29 06:45:00', NULL),
(10, 'admin-list', 'Display admin panel', 'Display admin panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(11, 'admin-create', 'Create Admin''s Components', 'Create Admin''s Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(12, 'admin-edit', 'Edit admin panel', 'Edit admin panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(13, 'admin-delete', 'Delete Admin''s Components', 'Delete Admin''s Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(14, 'doctor-list', 'Display Doctor panel', 'Display Doctor panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(15, 'doctor-create', 'Create doctor''s Components', 'Create Doctor''s Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(16, 'doctor-edit', 'Edit Doctor panel', 'Edit Doctor panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(17, 'doctor-delete', 'Delete Doctors''s Components', 'Delete Doctor''s Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(18, 'nurse-list', 'Display Nurse panel', 'Display Nurse panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(19, 'nurse-create', 'Create Nurse Components', 'Create Nurse Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(20, 'nurse-edit', 'Edit Nurse panel', 'Edit Nurse panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(21, 'nurse-delete', 'Delete Nurse Components', 'Delete Nurse Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(22, 'manufacturer-list', 'Display Manufacturer panel', 'Display Manufacturer panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(23, 'manufacturer-create', 'Create Manufacturer Components', 'Create Manufacturer Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(24, 'manufacturer-edit', 'Edit Manufacturer panel', 'Edit Manufacturer panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(25, 'manufacturer-delete', 'Delete Manufacturer Components', 'Delete Manufacturer Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(26, 'pharmacy-list', 'Display Pharmacy panel', 'Display Pharmacy panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(27, 'pharmacy-create', 'Create Pharmacy Components', 'Create Pharmacy Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(28, 'pharmacy-edit', 'Edit Pharmacy panel', 'Edit Pharmacy panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(29, 'pharmacy-delete', 'Delete Pharmacy Components', 'Delete Pharmacy Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(30, 'test-list', 'Display Test panel', 'Display Test panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(31, 'test-create', 'Create Test Components', 'Create Test Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(32, 'test-edit', 'Edit Test panel', 'Edit Test panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(33, 'test-delete', 'Delete Test Components', 'Delete Test Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(34, 'patient-list', 'Display Patient panel', 'Display Patient panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(35, 'patient-create', 'Create Patient Components', 'Create Patient Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00'),
(36, 'patient-edit', 'Edit Patient panel', 'Edit Patient panel', '2016-09-28 21:00:00', '2016-09-28 21:00:00'),
(37, 'patient-delete', 'Delete Patient Components', 'Delete Patient Components', '2016-09-29 21:00:00', '2016-09-29 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(35, 8),
(36, 1),
(36, 8),
(37, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'Super user', NULL, NULL),
(2, 'Doctor', 'Doctor', 'Only Doc Stuff', NULL, NULL),
(4, 'Nurse', 'Nurse', 'Nurse Platform', '2016-09-13 21:00:00', NULL),
(5, 'Manufacturer', 'Manufacturer', 'Manufacturer Platform', NULL, NULL),
(6, 'Pharmacy', 'Pharmacy', 'Only Pharmacy Stuff', NULL, NULL),
(7, 'Test', 'Test', 'Test Platform', '2016-09-13 21:00:00', NULL),
(8, 'Patient', 'Patient', 'Patient Platform', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(3, 2),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@afyapepe.com', '$2y$10$vkHzDCGyA55q65C3pLP/6eIXqcwXdvgQsYrduzP1JrQg.FI5sHB5C', 'sd8G0U1obZQCsn4lv03Zrc7gPAonnrLvypoCbFUNbeZpR6oVxyLCmlN3BpVl', '2016-09-29 09:06:47', '2016-10-01 05:09:54'),
(3, 'Doctor', 'doctor1@afyapepe.com', '$2y$10$XQ2qrMehbLE6vYc/CstefeOMmJ1nAAaHhhB8a43cdqAWG35GHl5AK', 'CpzOMhUJat6lOU9cXYH0s7qaTj3OspXowfS7UcJebPJvu7SxOxnLrxXQcfxi', '2016-09-30 04:30:00', '2016-09-30 04:47:45'),
(4, 'Nurse1', 'nurse1@afyapepe.com', '$2y$10$RM5IHrtUljODc1vrmODxx.9uKs0vobYo9zgxAxlkCy13DEzfOp7SG', 'pBcv77EtpzJav8LC1le9qikt7X1Rwwe3KMJhgGq79uSNlR2fBI2tmYf9g8Gd', '2016-09-30 05:16:28', '2016-10-01 04:43:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
