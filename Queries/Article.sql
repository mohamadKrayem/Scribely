-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2023 at 08:43 AM
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
-- Table structure for table `Article`
--

CREATE TABLE `Article` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `image` int(11) NOT NULL,
  `views` int(11) DEFAULT 0,
  `likes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Article`
--

INSERT INTO `Article` (`article_id`, `title`, `content`, `author_id`, `image`, `views`, `likes`, `created_at`) VALUES
(1, 'welcome', 'welcome to here again !!!!!!', 33, 1, 6, 3, '2023-05-19 21:07:30'),
(2, 'welcome', 'welcome to here again !!!!!!', 33, 6, 2, 17, '2023-05-19 21:08:52'),
(3, 'Final Project - backup files every 24 hours', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus consectetur quam recusandae repudiandae ipsa asperiores maiores sit quos maxime earum quia officiis, inventore et. Atque harum officia rerum aut ratione?', 33, 7, 1, 6, '2023-05-20 12:28:18'),
(4, 'This is a title for an article', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus consectetur quam recusandae repudiandae ipsa asperiores maiores sit quos maxime earum quia officiis, inventore et. Atque harum officia rerum aut ratione?', 30, 8, 7, 3, '2023-05-20 12:47:03'),
(5, 'FOSS Weekly #23.20: risiOS Distro, Plasma 6, Distrohopping, FOSSverse and More', 'FOSSverse? What\'s that?\n\nIt\'s basically the idea of unifying all things It\'s FOSS with a single member account. When logged in to It\'s FOSS, you can automatically log in to the comment section with the same profile. That was the first part.\n\nThe same member account is now valid on the It\'s FOSS Community. You don\'t have to manage a separate account for the Community anymore. Pro members also get \'Pro\' badge on their profile in the Community.\n\nStill not part of the It\'s FOSS Community? That\'s the place where you can ask your questions and clear your doubts. Do join.\n\nIn the last step towards FOSSverse, the same member account will also be valid on It\'s FOSS News. Pro member accounts are already synced between the portals.\n\nEventually, you will have the same identity across the FOSSverse (all It\'s FOSS web portals). I am super excited about it ðŸ¤© and I welcome your feedback on this idea.\n\nðŸ’¬ Let\'s see what you have in this edition of FOSS Weekly:\n\nFirst look at Fedora-based risiOS Linux distro\nConcluding the Rust series\nLinux Mint update guide\nAnd other Linux news, videos, puzzles and, of course, memes!', 34, 9, 1, 28, '2023-05-20 20:10:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Article`
--
ALTER TABLE `Article`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `image` (`image`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Article`
--
ALTER TABLE `Article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Article`
--
ALTER TABLE `Article`
  ADD CONSTRAINT `Article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `User` (`user_id`),
  ADD CONSTRAINT `Article_ibfk_2` FOREIGN KEY (`image`) REFERENCES `Image` (`image_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
