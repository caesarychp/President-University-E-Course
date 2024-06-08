-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 07:49 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebusiness2`
--

-- --------------------------------------------------------

--
-- Table structure for table `databanks`
--

CREATE TABLE `databanks` (
  `ImageLink` varchar(50) NOT NULL,
  `CardNumber` varchar(50) NOT NULL,
  `ExpiredDate` varchar(50) NOT NULL,
  `CVV` int(11) NOT NULL,
  `CardOwner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `databanks`
--

INSERT INTO `databanks` (`ImageLink`, `CardNumber`, `ExpiredDate`, `CVV`, `CardOwner`) VALUES
('bca.png', '12311', '1212', 123, '1321312'),
('bca.png', '1231', '121', 121, '1213'),
('bca.png', '12313', '1212', 121, '1231312'),
('bca.png', '23123', '1212', 123, '12313'),
('bni.png', '99999', '9999', 999, '999999999'),
('bca.png', '82438432', '3242', 232, '124242'),
('bca.png', '24432121', '1212', 123, '1241424'),
('bca.png', '1231321', '1231', 123, '1231412');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
