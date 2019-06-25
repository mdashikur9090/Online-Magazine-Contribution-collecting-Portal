-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2019 at 09:04 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ewsd`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `user_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`user_id`, `name`) VALUES
(1, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `id` int(11) NOT NULL,
  `magazine_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `doc_or_image` varchar(191) NOT NULL,
  `comment` longtext,
  `published_status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contributions`
--

INSERT INTO `contributions` (`id`, `magazine_id`, `student_id`, `doc_or_image`, `comment`, `published_status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'di5c7590674e7f4.jpg', NULL, 1, '2019-03-20 20:44:07', '2019-02-22 10:10:15'),
(2, 1, 4, 'di5c759078c3d99.png', 'This Contribution is the best Contribution in our faculty.', 0, '2019-03-06 19:12:50', '2019-03-02 14:48:07'),
(3, 1, 5, 'di5c7546d10f4a9.docx', NULL, 1, '2019-03-06 19:07:08', '2019-02-26 08:01:44'),
(4, 1, 5, 'di5c7590c903692.jpeg', NULL, 1, '2019-03-06 19:12:50', '2019-02-26 08:01:44'),
(5, 1, 6, 'di5c759092d2d9f.docx', 'This Contribution is the best Contribution in our faculty.', 0, '2019-03-05 04:01:51', '2019-02-26 13:13:34'),
(6, 1, 6, 'di5c758fde6f09d.jpg', NULL, 0, '2019-02-26 13:13:34', '2019-02-26 13:13:34'),
(7, 1, 7, 'di5c75900e58332.jpg', 'This Contribution is the best Contribution in our faculty.', 0, '2019-03-05 04:01:55', '2019-02-26 13:14:22'),
(8, 1, 10, 'di5c7590ba55b1c.jpeg', NULL, 0, '2019-03-06 06:19:06', '2019-02-26 13:14:22'),
(24, 1, 4, 'di5c7abb473d74e.docx', NULL, 0, '2019-03-06 19:12:28', '2019-03-02 11:20:07'),
(25, 2, 10, 'di5c759078c3d99.png', 'This Contribution is the best Contribution in our faculty.', 0, '2019-03-06 06:18:23', '2019-03-02 14:48:07'),
(26, 2, 5, 'di5c7590c903692.jpeg', NULL, 0, '2019-02-26 19:17:29', '2019-02-26 08:01:44'),
(27, 2, 6, 'di5c758fde6f09d.jpg', NULL, 0, '2019-02-26 13:13:34', '2019-02-26 13:13:34'),
(28, 2, 7, 'di5c75900e58332.jpg', 'This Contribution is the best Contribution in our faculty.', 0, '2019-03-05 04:01:55', '2019-02-26 13:14:22'),
(29, 2, 4, 'di5c7abb473d74e.docx', NULL, 0, '2019-03-02 11:20:07', '2019-03-02 11:20:07'),
(30, 2, 11, 'di5c7abb473d74e.docx', NULL, 0, '2019-03-02 11:20:07', '2019-03-02 11:20:07');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `marketing_coordinator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `marketing_coordinator_id`) VALUES
(1, 'Bussiness', 3),
(2, 'Science', 8),
(3, 'Economics', 9);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_guests`
--

CREATE TABLE `faculty_guests` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty_guests`
--

INSERT INTO `faculty_guests` (`user_id`, `faculty_id`, `name`) VALUES
(12, 1, 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `magazines`
--

CREATE TABLE `magazines` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `final_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `magazines`
--

INSERT INTO `magazines` (`id`, `name`, `start_date`, `end_date`, `final_end_date`) VALUES
(1, 'First Magazine', '2019-02-22', '2019-03-05', '2019-03-04'),
(2, 'Old Magazine', '2018-03-06', '2018-03-10', '2018-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `marketing_coordinators`
--

CREATE TABLE `marketing_coordinators` (
  `user_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marketing_coordinators`
--

INSERT INTO `marketing_coordinators` (`user_id`, `name`) VALUES
(3, 'Marketing Coordinator'),
(8, 'Marketing Cordinator 2'),
(9, 'Marketing Cordinator 3');

-- --------------------------------------------------------

--
-- Table structure for table `marketing_managers`
--

CREATE TABLE `marketing_managers` (
  `user_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marketing_managers`
--

INSERT INTO `marketing_managers` (`user_id`, `name`) VALUES
(2, 'Marketing Manager');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `marketing_coordinatord_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `syn` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `marketing_coordinatord_id`, `student_id`, `message`, `syn`, `created_at`, `updated_at`) VALUES
(1, 3, 4, 'Your contribution need to changes for publication. please change and contact with me.', 1, '2019-03-20 19:00:07', '2019-03-20 13:00:07'),
(2, 3, 4, 'Your 3rd contribution  need to changes for publication. please change and contact with me.', 0, '2019-03-20 18:02:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `marketing_coordinator_id` int(11) NOT NULL,
  `contribution_id` int(11) NOT NULL,
  `syn` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `marketing_coordinator_id`, `contribution_id`, `syn`) VALUES
(2, 3, 24, 0),
(3, 3, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('mdashikur9090@gmail.com', '$2y$10$iPQZjODKVHTTAT4rV.a5d.Z9c/EPaTBi1CHkNoD3YO0bjRJ/XRP1a', '2019-03-20 14:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` int(10) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `faculty_id`, `first_name`, `last_name`, `address`, `gender`, `image`) VALUES
(4, 1, 'Ashikur', 'Rahman', 'Narayangank', 'Male', NULL),
(5, 1, 'Taslima', 'Shormi', 'Mirpur', 'Female', NULL),
(6, 2, 'Muhtasim', 'Ahmed', 'Mirpur', 'Male', NULL),
(7, 2, 'Adnan', 'Hossain', 'Mirpur', 'Male', NULL),
(10, 3, 'MD', 'Ashik', 'Narayanganj', 'Male', NULL),
(11, 1, 'Amin', 'Hossain', 'Dhaka', 'Male', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(4) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'administrator@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 1, 'QJaIGLT7WgUo9kKp7P1aD6igEsBGmptdDCJiVPKehkTUpnEqYTpvdmH8wPvq', NULL, NULL),
(2, 'marketingmanager@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 2, '09DGLkly4Hfnw5BaQajbWhF35qP6bqKmvOpiRLwwVB82fw0g5L20mGdEwyDn', NULL, NULL),
(3, 'marketingcordinator1@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 3, 'RuKyEgPDQtKhYDPIp4WTRJdlgi7iYA9uOYXKdKwz35GWGPkTgLMNtly9Wqtj', '2019-02-16 13:25:06', '2019-02-16 13:25:06'),
(4, 'mdashikur9090@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 4, 'JIUbFI4KLOXXClvYaRX04v1e9XUjbZFBsrFHlmXpUkbLQIX9UbJ6cqq8aJWQ', NULL, NULL),
(5, 'shormiinf@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 4, 'Ra6gAXHxQL5MuTOyDbKMWha9GdvAca0WBGcUMkcYVYeY1EN6slQPcyhKavd5', NULL, NULL),
(6, 'ahmed05.muhtasim@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 4, 'thPY1AfaG3NvkDZFcEOQBYvyXwSk95KfqNbuGwp1ECCMm1gmi8WO2raHiXZU', NULL, NULL),
(7, 'adnankhn6@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 4, 'UQkVHWmJod2QRH12hCQxlqi8S0jND1fxlOF3VSTEVKk1EY7P5Z9hfo551r1z', NULL, NULL),
(8, 'marketingcordinator2@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 3, '', '2019-02-16 13:25:06', '2019-02-16 13:25:06'),
(9, 'marketingcordinator3@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 3, '', '2019-02-16 13:25:06', '2019-02-16 13:25:06'),
(10, 'ashik@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 4, 'H9X1LTsGBAfHtMyccArFuM2G8cLt12FbsuZICmFFi0JvFS9BJzHu2ZhnQJ4Y', NULL, NULL),
(11, 'amin@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 4, 'H9X1LTsGBAfHtMyccArFuM2G8cLt12FbsuZICmFFi0JvFS9BJzHu2ZhnQJ4Y', NULL, NULL),
(12, 'facultyguest@gmail.com', '$2y$10$..kY5hZ2GXAwX4CSH8iBXuFaDAtb3rmUB285mpjkb5Df.z74X6j.q', 5, 'l2UCtL9NMwAH62FD2VKwIZPP2zjDIOpFKqsHt0ePN7BOOIhikfRjvTUtptkk', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magazine_id` (`magazine_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magazines`
--
ALTER TABLE `magazines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketing_coordinators`
--
ALTER TABLE `marketing_coordinators`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `marketing_managers`
--
ALTER TABLE `marketing_managers`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `magazines`
--
ALTER TABLE `magazines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `administrators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contributions`
--
ALTER TABLE `contributions`
  ADD CONSTRAINT `contributions_ibfk_1` FOREIGN KEY (`magazine_id`) REFERENCES `magazines` (`id`);

--
-- Constraints for table `marketing_coordinators`
--
ALTER TABLE `marketing_coordinators`
  ADD CONSTRAINT `marketing_coordinators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `marketing_managers`
--
ALTER TABLE `marketing_managers`
  ADD CONSTRAINT `marketing_managers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
