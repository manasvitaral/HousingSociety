-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 04:26 AM
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
-- Database: `housing_society`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('resident','committee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `role`, `created_at`) VALUES
('ABC', 'A B C', '$2y$10$/e2SMZ4mDxj/zmKKE587q.o9F.PKyMWaO8hM9jFOrO3dPXV1n8sFe', 'resident', '2025-07-05 17:01:29'),
('mmt2005', 'manasvi', '$2y$10$3w/qWTEFLuQwjr49eJbqDOQ3oPhU9Gm.hQ/DYXy3HNA0bAs7HxY1i', 'resident', '2025-07-10 15:36:59'),
('myra', 'myra', '$2y$10$SjMoCnqs55hlxpSGgGZyO.qjnjcZ2IhMZ7ZtnnZ7BfnrfNWGOOQ3S', 'resident', '2025-07-11 02:20:35'),
('tt123', 'tejas taral', '$2y$10$OyAvWC3dAbe2aOUYEROmzO8HcRgJzqhIIR/shFwpS0aS49MPLoGjC', 'committee', '2025-07-06 07:44:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
