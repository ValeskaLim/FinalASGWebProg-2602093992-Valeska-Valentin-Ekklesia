-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 10:58 AM
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
-- Database: `connectfriend`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `price` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `name`, `image_url`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Pablo Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar1', 96918, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(2, 'Angus Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar2', 80438, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(3, 'Rosalia Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar3', 47095, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(4, 'Arch Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar4', 53837, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(5, 'Marquis Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar5', 15257, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(6, 'Gladyce Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar6', 8267, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(7, 'Chasity Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar7', 79837, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(8, 'Ewell Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar8', 67344, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(9, 'Amber Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar9', 58185, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(10, 'Ellie Avatar', 'https://dummyimage.com/100x100/000/fff&text=Avatar10', 18776, '2025-01-09 02:36:35', '2025-01-09 02:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `created_at`, `updated_at`) VALUES
(1, 3, 6, NULL, NULL),
(2, 6, 3, NULL, NULL),
(3, 7, 6, NULL, NULL),
(4, 6, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '2025-01-09 02:37:56', '2025-01-09 02:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 3, 6, 'hEY', 1, '2025-01-09 02:39:12', '2025-01-09 02:44:47'),
(2, 6, 3, 'Hey', 0, '2025-01-09 02:44:49', '2025-01-09 02:44:49'),
(3, 7, 6, 'Woy', 0, '2025-01-09 02:51:30', '2025-01-09 02:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_12_30_083726_create_users_table', 1),
(4, '2025_01_05_131149_create_friends_table', 1),
(5, '2025_01_06_105612_create_friend_requests_table', 1),
(6, '2025_01_06_111206_create_messages_table', 1),
(7, '2025_01_07_065032_create_avatars_table', 1),
(8, '2025_01_07_072339_create_user_avatar_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NYJ0iwiNGmPxTbPn49XLrUBJGyXheFS1ortjLrkD', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMzJEUFk0TkNiT2VucmtHd0pEM1VRcmNiSVNnTHg1dzJBTVV3UUQ5cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90b3B1cCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1736416359);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `hobbies` text NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `instagram_link` varchar(255) NOT NULL,
  `registration_price` bigint(20) NOT NULL,
  `wallet` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `gender`, `hobbies`, `phone_number`, `instagram_link`, `registration_price`, `wallet`, `created_at`, `updated_at`) VALUES
(1, 'stoltenberg.bonita', '$2y$12$m46B05a3Y8G35AMWRQHlGO0jc4s8if6wuSxy4xNjO8B2z8j8Bj1Qm', 'Female', 'assumenda, quas, expedita', '(385) 743-6589', 'http://www.hoeger.com/deserunt-rerum-eum-ad-alias', 101715, 6931, '2025-01-09 02:36:34', '2025-01-09 02:36:34'),
(2, 'matilda98', '$2y$12$RIh6sp9uobPmI8c9BPgkHu6RHvSBUvTdjD0YIfG4jUrq2t5VmhRRS', 'Female', 'deserunt, officia, voluptatem', '689.965.1127', 'http://trantow.net/', 112974, 3802, '2025-01-09 02:36:34', '2025-01-09 02:36:34'),
(3, 'marquise.cartwright', '$2y$12$UaDY/wJ2hdSAHnCg1iQ0UOmhJjCragwnp1.1IWO1DCqGyDL/na0WG', 'Female', 'earum, vel, quisquam', '+1-309-338-321', 'https://treutel.biz/quia-vitae-assumenda-cum-voluptas-maxime-fugit-odio.html', 124994, 5145, '2025-01-09 02:36:34', '2025-01-09 02:36:34'),
(4, 'sienna32', '$2y$12$4adQmW4r7PPLyL1Osj2ZGOK.8a1naQWfc/CG8JMbyMi4vabs1zdUu', 'Female', 'quam, qui, debitis', '1-706-716-4762', 'https://www.purdy.com/aut-doloremque-iste-voluptatem-omnis-ipsa-provident-dolores-sit', 116718, 4001, '2025-01-09 02:36:34', '2025-01-09 02:36:34'),
(5, 'daugherty.mack', '$2y$12$4tuo4qhqBG.KOyFts0ewcefEoNVdXxscxKL4tIfGLCiD1M7gKPGoa', 'Male', 'voluptatem, ipsum, accusamus', '325.298.1868', 'http://schiller.com/et-magni-sunt-sed-molestiae-eligendi-nisi-nemo.html', 119089, 1374, '2025-01-09 02:36:35', '2025-01-09 02:36:35'),
(6, 'Admin', '$2y$12$rcEVcuFJfWbfFARB6icpg.hpKETt5PKqDvZSES5bIrDsGIRI2Tht2', 'Male', 'Makan,Tidur,Berak', '1287381231', 'https://www.codepunker.com/tools/string-converter', 119725, 1933, '2025-01-09 02:37:23', '2025-01-09 02:52:39'),
(7, 'Admin12', '$2y$12$tSG8W8UjVzsxzqiVYev6QelTTy9ykbCZNfJ749JdIqAzoHNUMLnsa', 'Male', 'Makan,Tidur,Berak', '12312513', 'https://www.codedsapunker.com/tools/string-converter', 114713, 0, '2025-01-09 02:43:45', '2025-01-09 02:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_avatar`
--

CREATE TABLE `user_avatar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `avatar_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_avatar`
--

INSERT INTO `user_avatar` (`id`, `user_id`, `avatar_id`, `created_at`, `updated_at`) VALUES
(1, 6, 6, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `avatars_name_unique` (`name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friends_user_id_foreign` (`user_id`),
  ADD KEY `friends_friend_id_foreign` (`friend_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `friend_requests_sender_id_foreign` (`sender_id`),
  ADD KEY `friend_requests_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_instagram_link_unique` (`instagram_link`);

--
-- Indexes for table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_avatar_user_id_foreign` (`user_id`),
  ADD KEY `user_avatar_avatar_id_foreign` (`avatar_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_avatar`
--
ALTER TABLE `user_avatar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD CONSTRAINT `user_avatar_avatar_id_foreign` FOREIGN KEY (`avatar_id`) REFERENCES `avatars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_avatar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
