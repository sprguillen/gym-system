-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2018 at 04:58 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contact`
--

CREATE TABLE `emergency_contact` (
  `id` int(11) NOT NULL,
  `full_name` varchar(30) DEFAULT NULL,
  `contact` varchar(10) DEFAULT NULL,
  `relationship` varchar(20) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `mname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `height` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(30) NOT NULL,
  `img` blob,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `fname`, `mname`, `lname`, `address`, `date_of_birth`, `gender`, `weight`, `height`, `email`, `contact`, `img`, `date_created`) VALUES
(1, 'Simon Phillip', 'Ramos', 'Guillen', '401 Parkview Cor. Tiara St. Lanang Executive Homes, Davao City', '1991-02-18', 'Male', 152, 170, 'sprguillen@gmail.com', '+639178641192', NULL, '2018-04-25 17:59:22'),
(2, 'Stevie', 'Hardaway', 'Wonder', 'Black Bull Music,\n4616 W Magnolia Blvd ', '1950-05-13', 'Male', 110, 185, 'stevie.wonder@gmail.com', '0987241567', NULL, '2018-05-06 07:25:06');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `date_started` date DEFAULT NULL,
  `date_expired` date DEFAULT NULL,
  `status` enum('Active','Frozen','Expired','Inactive','Guest') NOT NULL DEFAULT 'Active',
  `member_id` int(11) DEFAULT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `date_started`, `date_expired`, `status`, `member_id`, `program_id`) VALUES
(1, '2018-04-14', '2018-05-14', 'Active', 1, 1),
(2, '2018-04-14', '2018-05-14', 'Active', 1, 2),
(3, '2018-05-04', '2018-11-03', 'Active', 2, 2),
(4, '2018-03-01', '2018-11-03', 'Active', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_attendance`
--

CREATE TABLE `membership_attendance` (
  `id` int(11) NOT NULL,
  `attendance` datetime NOT NULL,
  `membership_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `membership_frozen`
--

CREATE TABLE `membership_frozen` (
  `id` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `date_frozen` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('Ongoing','Done') NOT NULL DEFAULT 'Ongoing',
  `membership_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership_frozen`
--

INSERT INTO `membership_frozen` (`id`, `purpose`, `date_frozen`, `date_created`, `status`, `membership_id`) VALUES
(7, 'Travel to Bangkok', '2018-06-06', '2018-05-10 20:10:43', 'Done', 3),
(8, 'Great', '2018-05-11', '2018-05-10 20:10:43', 'Done', 4),
(9, 'Dodong\'s birthday', '2018-05-18', '2018-05-10 20:10:43', 'Done', 3),
(10, 'Dodong\'s birthday', '2018-05-18', '2018-05-10 20:10:43', 'Done', 4),
(11, 'Dodong\'s birthday', '2018-06-06', '2018-05-10 20:10:43', 'Done', 3),
(12, 'Dodong\'s birthday', '2018-06-06', '2018-05-10 20:10:43', 'Done', 4),
(13, 'Dodong\'s annual laag', '2018-07-11', '2018-05-10 20:10:43', 'Done', 3),
(14, 'Dodong\'s annual laag', '2018-07-11', '2018-05-10 20:10:43', 'Done', 4),
(15, 'sad', '2018-07-11', '2018-05-10 20:10:43', 'Done', 3),
(16, 'sad', '2018-07-11', '2018-05-10 20:10:43', 'Done', 4),
(17, 'dodong\'s birthday bash', '2018-06-11', '2018-05-10 20:10:43', 'Done', 3),
(18, 'dodong\'s birthday bash', '2018-06-11', '2018-05-10 20:10:43', 'Done', 4),
(19, 'Dodong\'s debut', '2018-06-11', '2018-05-10 20:10:43', 'Done', 3),
(20, 'Dodong\'s debut', '2018-06-11', '2018-05-10 20:10:43', 'Done', 4),
(21, 'Sakit akong baba', '2018-06-11', '2018-05-10 20:10:43', 'Done', 3),
(22, 'Sakit akong baba', '2018-06-11', '2018-05-10 20:10:43', 'Done', 4),
(23, 'Animal', '2018-06-11', '2018-05-10 20:10:43', 'Done', 3),
(24, 'Animal', '2018-06-11', '2018-05-10 20:10:43', 'Done', 4),
(25, 'Dodong\'s dental check up', '2018-08-11', '2018-05-10 20:13:57', 'Done', 3),
(26, 'Dodong\'s dental check up', '2018-08-11', '2018-05-10 20:13:57', 'Done', 4),
(27, 'Dodong\'s headache', '2018-07-11', '2018-05-10 20:14:56', 'Done', 3),
(28, 'Dodong\'s headache', '2018-07-11', '2018-05-10 20:14:56', 'Done', 4),
(29, 'dodong\'s birthday bash', '2018-07-11', '2018-05-10 20:15:19', 'Ongoing', 3),
(30, 'dodong\'s birthday bash', '2018-07-11', '2018-05-10 20:15:19', 'Ongoing', 4),
(31, 'Dodong', '2018-08-11', '2018-05-10 20:15:51', 'Ongoing', 3),
(32, 'Dodong', '2018-08-11', '2018-05-10 20:15:51', 'Ongoing', 4),
(33, 'Dodong\'s toothache', '2018-07-11', '2018-05-10 20:18:58', 'Ongoing', 3),
(34, 'Dodong\'s toothache', '2018-07-11', '2018-05-10 20:18:58', 'Ongoing', 4),
(35, 'Dodong', '2018-06-11', '2018-05-10 20:20:13', 'Ongoing', 3),
(36, 'Dodong', '2018-06-11', '2018-05-10 20:20:13', 'Ongoing', 4),
(41, 'test', '2018-05-11', '2018-05-10 20:54:22', 'Ongoing', 3),
(42, 'test', '2018-05-11', '2018-05-10 20:54:22', 'Ongoing', 4),
(43, 'heyyyyy', '2018-05-11', '2018-05-10 20:54:49', 'Ongoing', 3),
(44, 'heyyyyy', '2018-05-11', '2018-05-10 20:54:49', 'Ongoing', 4);

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `type`) VALUES
(1, 'Weight Training'),
(2, 'Boxing'),
(3, 'Yoga'),
(4, 'Zumba');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `username` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_account_type_id` int(11) DEFAULT NULL,
  `user_profile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `email`, `password`, `user_account_type_id`, `user_profile_id`) VALUES
(1, 'sprguillen', 'sprguillen@gmail.com', '51abb9636078defbf888d8457a7c76f85c8f114c', 1, 1),
(2, 'nikki', 'nikki@hifitechnologies.com', '8cb2237d0679ca88db6464eac60da96345513964', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_account_type`
--

CREATE TABLE `user_account_type` (
  `id` int(11) NOT NULL,
  `account_type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account_type`
--

INSERT INTO `user_account_type` (`id`, `account_type`) VALUES
(1, 'Admin'),
(2, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `img` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `fname`, `lname`, `email`, `img`) VALUES
(1, 'Simon', 'Guillen', 'sprguillen@gmail.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `membership_attendance`
--
ALTER TABLE `membership_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- Indexes for table `membership_frozen`
--
ALTER TABLE `membership_frozen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_account_type_id` (`user_account_type_id`),
  ADD KEY `user_profile_id` (`user_profile_id`);

--
-- Indexes for table `user_account_type`
--
ALTER TABLE `user_account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `membership_attendance`
--
ALTER TABLE `membership_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `membership_frozen`
--
ALTER TABLE `membership_frozen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD CONSTRAINT `emergency_contact_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `membership_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`);

--
-- Constraints for table `membership_attendance`
--
ALTER TABLE `membership_attendance`
  ADD CONSTRAINT `membership_attendance_ibfk_1` FOREIGN KEY (`membership_id`) REFERENCES `membership` (`id`);

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`user_account_type_id`) REFERENCES `user_account_type` (`id`),
  ADD CONSTRAINT `user_account_ibfk_2` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profile` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
