-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.infinityfree.com
-- Generation Time: Jan 17, 2026 at 08:11 AM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39682897_votesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'crce', '$2y$10$kLqXG4BAJrPbsOjJ/.B4eeZn6oojNhAb8l5/cb9eZvFnYU.pz2qni', 'CRCE', 'Admin', 'WhatsApp Image 2021-05-27 at 17.55.34.jpeg', '2018-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `platform` text NOT NULL,
  `candidate_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `firstname`, `lastname`, `photo`, `platform`, `candidate_order`) VALUES
(18, 8, 'Vivek', 'Saxena', 'candidate_6896fbb7390a1.png', 'Education at a highly subsidized rate!', 0),
(19, 9, 'Ishika', 'Mehta', 'candidate_6897847e7d7db.png', 'Free Electricity for all!!!', 0),
(20, 8, 'Rajiv', 'Kumar', 'candidate_6897850d52169.png', '', 0),
(21, 12, 'Rohan', 'Gupta', 'candidate_68978600d221a.png', '', 0),
(22, 11, 'Riya', 'Mishra', 'candidate_6897863fd33e1.png', '', 0),
(23, 9, 'Aarav', 'Sharma', 'candidate_6898862227b96.png', '', 0),
(24, 12, 'Dhruv', 'Patel', 'candidate_6898867467646.png', '', 0),
(25, 11, 'Zara', 'Khan', 'candidate_689887184a698.png', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `election_title`
--

CREATE TABLE `election_title` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `election_title`
--

INSERT INTO `election_title` (`id`, `title`) VALUES
(1, 'Elections 2025');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `description`, `max_vote`, `priority`) VALUES
(8, 'President', 5, 1),
(9, 'Secretary', 5, 4),
(11, 'Vice President', 5, 2),
(12, 'Treasury', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `id` int(11) NOT NULL,
  `voters_id` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `photo`) VALUES
(3, '5', '$2y$10$1vTgEFajviGZ5R9VjlAODeViIS.Sl612hE2Kl3SRjUwvpuGCncWF6', 'Kajal', 'Kumari', 'voter_6898a7d9dc230.png'),
(4, '3', '$2y$10$W206DmKfx6l9jTVq.E766O8nElcyYcU3T3niqzHDlqllx/pyusHGW', 'Naman', 'Malik', 'voter_6897842e13ebc.png'),
(5, '4', '$2y$10$8fZwbR65cZ7/83mOYp0Smuu4jXW3QwmgWZrAeCyJpD6ollzfunhCS', 'Tarun', 'Awasthi', 'voter_6897866f9b706.png'),
(6, '1', '$2y$10$NJHICWxviIgjfw9MTI25hOk4ihqK113Gw1a8XiviBhXA6FhPPOnOi', 'Aarya', 'Sharma', 'voter_689884f614cad.png'),
(7, '2', '$2y$10$h/Un4dMsc6WhLMv5Tmh51.xCsOb3Nwe.vy.khBh9C0V2mHRMddi/6', 'Rishi', 'Gurjar', 'voter_68988571e9373.png'),
(8, '6', '$2y$10$pBHuMrZ2.vjhTcuZRotgNun/bnlq2zsRgPN09fCLk6fl4VADmF.kS', 'Vihaan', 'Gupta', 'voter_689887e4e6425.png'),
(9, '7', '$2y$10$nn710F8SiglA1f8nowVouOjCvAT/hcemNkoez8OY3a4qMOZN31wn2', 'Myra', 'Kapoor', 'voter_689888cbac4df.png'),
(10, '8', '$2y$10$lP01BNpzulJL3VQZz6bbB.sq./5HaOjeUz1bsQM6SE4fnNJRb12La', 'Sanya', 'Joshi', 'voter_68988a734f697.png');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `voters_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `voters_id`, `candidate_id`, `position_id`) VALUES
(82, 5, 18, 8),
(83, 4, 21, 12),
(84, 4, 19, 9),
(85, 4, 20, 8),
(87, 4, 18, 8),
(89, 4, 22, 11),
(90, 3, 21, 12),
(91, 3, 19, 9),
(92, 3, 18, 8),
(93, 3, 22, 11),
(94, 8, 23, 9),
(95, 8, 24, 12),
(96, 8, 18, 8),
(97, 8, 25, 11),
(98, 7, 19, 9),
(99, 7, 24, 12),
(100, 7, 20, 8),
(101, 7, 22, 11),
(102, 6, 18, 8),
(103, 6, 25, 11),
(104, 6, 24, 12),
(105, 6, 23, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `election_title`
--
ALTER TABLE `election_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `election_title`
--
ALTER TABLE `election_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
