-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql55
-- Generation Time: Oct 17, 2025 at 06:04 AM
-- Server version: 5.5.62
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bradman_nhrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `zeon_loan`
--

CREATE TABLE `zeon_loan` (
  `zl_id` int(11) NOT NULL,
  `zl_user_id` int(11) NOT NULL,
  `zl_code` varchar(255) DEFAULT NULL,
  `zl_property_id` tinyint(1) NOT NULL COMMENT '1=> 33 Carl street, 2=>39 Raffles, 3=>61 Regent, 4=>55 Regent',
  `zl_buying_as_id` tinyint(1) NOT NULL COMMENT '1=>Individual, 2=> Trust, 3=> SMSF',
  `zl_applicant_count` tinyint(1) DEFAULT NULL COMMENT '1=>one, 2=>Two',
  `zl_fname` varchar(100) DEFAULT NULL,
  `zl_lname` varchar(100) DEFAULT NULL,
  `zl_fname2` varchar(100) DEFAULT NULL,
  `zl_lname2` varchar(100) DEFAULT NULL,
  `zl_trust_name` varchar(255) DEFAULT NULL,
  `zl_trust_setup_required` tinyint(1) DEFAULT NULL COMMENT '1=>yes, 2=>No',
  `zl_smsf_name` varchar(255) DEFAULT NULL,
  `zl_smsf_setup_required` tinyint(1) DEFAULT NULL COMMENT '1=>yes, 2=>No',
  `zl_loan_required` tinyint(1) NOT NULL COMMENT '1=>yes, 2=>No',
  `zl_cash_investment` tinyint(1) NOT NULL COMMENT '1=>yes, 2=>No',
  `zl_status` int(1) NOT NULL DEFAULT '1' COMMENT '1=>In progress, 2=>Completed, 3=> Closed',
  `zl_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zl_created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zeon_loan`
--

INSERT INTO `zeon_loan` (`zl_id`, `zl_user_id`, `zl_code`, `zl_property_id`, `zl_buying_as_id`, `zl_applicant_count`, `zl_fname`, `zl_lname`, `zl_fname2`, `zl_lname2`, `zl_trust_name`, `zl_trust_setup_required`, `zl_smsf_name`, `zl_smsf_setup_required`, `zl_loan_required`, `zl_cash_investment`, `zl_status`, `zl_created_on`, `zl_created_by`) VALUES
(1, 1, 'ZAC1', 2, 2, NULL, NULL, NULL, NULL, NULL, 'Ameen Trust', 1, NULL, NULL, 1, 2, 1, '2025-10-16 13:19:10', 1),
(2, 1, 'ZAC2', 4, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ameen SMSF', 2, 2, 1, 1, '2025-10-16 13:19:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zeon_loan_users`
--

CREATE TABLE `zeon_loan_users` (
  `zlu_id` int(11) NOT NULL,
  `zlu_email` varchar(250) NOT NULL,
  `zlu_password` varchar(100) NOT NULL,
  `zlu_fname` varchar(250) NOT NULL,
  `zlu_lname` varchar(250) NOT NULL,
  `zlu_phone_code` varchar(10) NOT NULL DEFAULT '+61',
  `zlu_phone` varchar(10) DEFAULT NULL,
  `zlu_address` text NOT NULL,
  `zlu_user_type` tinyint(4) NOT NULL COMMENT '1=>Client,2=>Admin',
  `zlu_email_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '	0=>Not verified, 1=> Verified	',
  `zlu_application_completed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>Not Completed, 1=>Completed',
  `zlu_created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zeon_loan_users`
--

INSERT INTO `zeon_loan_users` (`zlu_id`, `zlu_email`, `zlu_password`, `zlu_fname`, `zlu_lname`, `zlu_phone_code`, `zlu_phone`, `zlu_address`, `zlu_user_type`, `zlu_email_verified`, `zlu_application_completed`, `zlu_created_on`) VALUES
(1, 'ameen.minhaz@gmail.com', 'ameen', 'Ameen', 'Minhaz', '+61', '123456789', '123, West Street, QLD 4235', 1, 1, 1, '2025-10-15 06:02:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zeon_loan`
--
ALTER TABLE `zeon_loan`
  ADD PRIMARY KEY (`zl_id`);

--
-- Indexes for table `zeon_loan_users`
--
ALTER TABLE `zeon_loan_users`
  ADD PRIMARY KEY (`zlu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zeon_loan`
--
ALTER TABLE `zeon_loan`
  MODIFY `zl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zeon_loan_users`
--
ALTER TABLE `zeon_loan_users`
  MODIFY `zlu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
