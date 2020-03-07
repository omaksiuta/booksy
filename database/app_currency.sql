-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2019 at 12:24 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmyslote`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_currency`
--

CREATE TABLE `app_currency` (
  `id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `code` varchar(100) NOT NULL,
  `currency_code` varchar(100) NOT NULL,
  `stripe_supported` enum('Y','N') NOT NULL DEFAULT 'N',
  `paypal_supported` enum('Y','N') NOT NULL DEFAULT 'N',
  `display_status` enum('A','I') NOT NULL DEFAULT 'I',
  `status` enum('A','I') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_currency`
--

INSERT INTO `app_currency` (`id`, `title`, `code`, `currency_code`, `stripe_supported`, `paypal_supported`, `display_status`, `status`) VALUES
(1, 'Australian dollar', 'AUD', '&#36;', 'Y', 'Y', 'I', 'I'),
(2, 'Brazilian real', 'BRL', '&#82;&#36;', 'Y', 'Y', 'I', 'I'),
(3, 'Canadian dollar', 'CAD', '&#36;', 'Y', 'Y', 'I', 'I'),
(4, 'Czech koruna', 'CZK', '&#75;&#269;', 'Y', 'Y', 'I', 'I'),
(5, 'Danish krone', 'DKK', '&#107;&#114;', 'Y', 'Y', 'I', 'I'),
(6, 'Euro', 'EUR', '&#8364;', 'Y', 'Y', 'I', 'I'),
(7, 'Hong Kong dollar', 'HKD', '&#36;', 'Y', 'Y', 'I', 'I'),
(8, 'Hungarian forint', 'HUF', '&#70;&#116;', 'Y', 'Y', 'I', 'I'),
(9, 'Indian rupee', 'INR', '&#8377;', 'Y', 'Y', 'I', 'I'),
(10, 'Israeli new shekel', 'ILS', '&#8362;', 'Y', 'Y', 'I', 'I'),
(11, 'Japanese yen', 'JPY', '&#165;', 'Y', 'Y', 'I', 'I'),
(12, 'Malaysian ringgit', 'MYR', '&#82;&#77;', 'Y', 'Y', 'I', 'I'),
(13, 'Mexican peso', 'MXN', '&#36;', 'Y', 'Y', 'I', 'I'),
(14, 'New Taiwan dollar', 'TWD', '&#78;&#84;&#36;', 'Y', 'Y', 'I', 'I'),
(15, 'New Zealand dollar', 'NZD', '&#36;', 'Y', 'Y', 'I', 'I'),
(16, 'Norwegian krone', 'NOK', '&#107;&#114;', 'Y', 'Y', 'I', 'I'),
(17, 'Philippine peso', 'PHP', '&#8369;', 'Y', 'Y', 'I', 'I'),
(18, 'Polish złoty', 'PLN', '&#122;&#322;', 'Y', 'Y', 'I', 'I'),
(19, 'Pound sterling', 'GBP', '&#163;', 'Y', 'Y', 'I', 'I'),
(20, 'Russian ruble', 'RUB', '&#1088;&#1091;&#1073;', 'Y', 'Y', 'I', 'I'),
(21, 'Singapore dollar', 'SGD', '&#36;', 'Y', 'Y', 'I', 'I'),
(22, 'Swedish krona', 'SEK', '&#107;&#114;', 'Y', 'Y', 'I', 'I'),
(23, 'Swiss franc', 'CHF', '&#67;&#72;&#70;', 'Y', 'Y', 'I', 'I'),
(24, 'Thai baht', 'THB', '&#3647;', 'Y', 'Y', 'I', 'I'),
(25, 'United States dollar', 'USD', '&#36;', 'Y', 'Y', 'A', 'A'),
(26, 'Shrilanka', 'SRK', 'Rp', 'N', 'N', 'A', 'I');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_currency`
--
ALTER TABLE `app_currency`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_currency`
--
ALTER TABLE `app_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
