-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2023 at 09:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Scribely`
--

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `full_name` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `username`, `password`, `email`, `created_at`, `full_name`, `bio`, `profile_image`, `website`, `location`, `twitter`, `facebook`, `instagram`, `linkedin`, `github`) VALUES
(1, 'mohamadkrayem', '$2y$10$L07reo8quGHHWv1oNvBkx.YaD548/iu.qg5/1wAEQwY4DqIh5Xy/C', 'mohamadkrayem@email.com', '2023-05-15 08:46:51', 'Mohamad Krayem', 'ladfajhdfkajhflkajhlkjehr', NULL, 'websi', 'sohmore', 'twitter', 'face', 'instar', 'linke', 'github'),
(26, 'majd', '$2y$10$RcoDPaOxNyoLF4LQusSDjedO3EeElBxaKkZ.WhNpHtfXsPwHA4qx6', 'majd@email.com', '2023-05-16 10:10:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'majdRabie', '$2y$10$acjY7qVA12wd2VkseWdEz.7krAp/M6qQpa3e0bI5dRkWn83woACgW', 'MardRabie@email.com', '2023-05-16 10:11:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'mhmd', '$2y$10$VzLhIwW8t70DqVj4hfPjc.X0eu4eLgZ/KpiqnqGo4r1F/4i/2z122', 'mhmd@email.com', '2023-05-16 10:12:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'raghad', '$2y$10$IAaT6Qhjpcg2uUsRoGkaOuDZz82IViV7E6BD0YJDRxhiAWWzDYJEG', 'raghad@email.com', '2023-05-16 10:19:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'rana', '$2y$10$.t/EUUXcg1p5k2Rc2B.2/.GsWw1aFxBpR11F245sMALv1WPpdwt7e', 'rana@email.com', '2023-05-16 10:20:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'raefkrayem', '$2y$10$XzMJemVAoYvkS3UczaPiVOrymRxF3G/S/mLJYqTh7WrfevLUwLvVu', 'raefkrayem@email.com', '2023-05-16 20:56:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'walid', '$2y$10$fEvNSxkY2/LZ0e8SHd9eb.fh3G0psRyU5NT2cZIUDUXyAO5Q7CInK', 'walid@email.com', '2023-05-18 05:49:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'abir', '$2y$10$yWxdsnoURWWxi5kNwnmRGO3GIzFefTTh2NN6y4RNEo95cMyDlc1TS', 'abir@email.com', '2023-05-19 17:06:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
