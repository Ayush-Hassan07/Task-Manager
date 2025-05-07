-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 08:51 PM
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
-- Database: `task_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `due_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `due_date`, `status`, `due_time`) VALUES
(12, 1, 'Web', 'Webpage', '2025-04-09', 'pending', '14:00:00'),
(20, 2, 'Meet with stakeholders to gather requirements', 'Meeting for requirements', '2025-04-08', 'completed', '03:30:00'),
(22, 1, 'System Design', 'Design database schema and relationships', '2025-04-11', 'pending', '07:30:00'),
(23, 3, 'Web Open Ended Lab', 'Open Ended Report Writing', '2025-04-09', 'in_progress', '02:06:00'),
(24, 1, 'Network', 'Checking the connection of every ports', '2025-04-11', 'completed', '21:00:00'),
(25, 1, 'Development Follow up', 'Meeting for checking the project follow up ', '2025-04-10', 'pending', '00:00:00'),
(26, 4, 'Follow up ', 'Updated requirements to be followed', '2025-04-10', 'in_progress', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Lamia', 'lamia13@gmail.com', '$2y$10$jtVtX8/otuuDkUJrWHXVOuMamI6rNhMrNk75KNGygFgjQ9.bnAPle'),
(2, 'Ayush', 'ayush@gmail.com', '$2y$10$O7FDa0/8P2eZlUP.3pcDleOT1Cpgc0K9t67.qoi4l4eWFYOzELVeC'),
(3, 'Jarin Tasnim', 'jarin@gmail.com', '$2y$10$U3wZGzKXNck.2/xJIlJckuqonCwg8mVpPuxVTcBePaycubOx8joLe'),
(4, 'Raiyan', 'ran13@gmail.com', '$2y$10$kPW9IsFSj5e43AjGIZnFaetiqw1G5O6rw1P7ynWzgAF3hUxANXTYa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
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
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
