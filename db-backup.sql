-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2022 at 04:59 PM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redgreen_wedding`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(75) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone`) VALUES
(1, 'Suzie Q', 'Anderson', 'suzie@email.com', '425-555-1111'),
(2, 'Lois', 'Lane', 'lois@email.com', '425-555-1112'),
(4, 'Michelle', 'Scalley', 'michelle@email.com', '425-555-1113'),
(5, 'Amy', 'Adams', 'amy@email.com', '425 555-1114'),
(6, 'Sarah', 'Olmstead', 'sarah@email.com', '425-555-1115'),
(7, 'Elaine', 'King', 'elaine@email.com', '425-555-2222'),
(8, 'Jane', 'Jansen', 'jane@email.com', '425-555-2223'),
(9, 'Jillian', 'Sykes', 'jillian@email.com', '425-555-2224'),
(10, 'Taylor', 'Kinsey', 'taylor@email.com', '425-555-2225'),
(11, 'Paige', 'Pierce', 'paige@email.com', '425-555-3333'),
(12, 'Kristen', 'Tattar', 'kristen@email.com', '425-555-4444'),
(13, 'Sarah', 'Hokom', 'sarahh@email.com', '425-555-4445'),
(14, 'Jennifer', 'Allen', 'jennifera@email.com', '425-555-4446'),
(15, 'Stacy', 'Rawnsley', 'stacyr@email.com', '425-555-5555'),
(16, 'Kat', 'Mertsh', 'katm@email.com', '425-555-6667'),
(17, 'Amy', 'Spicuzza', 'amys@email.com', '425-555-7777'),
(18, 'Ashley', 'Kelver', 'ashleyk@email.com', '425-555-7779'),
(19, 'Tina', 'Oakley', 'tinao@email.com', '425-555-8888'),
(20, 'Madison', 'Walker', 'madisonw@email.com', '425-555-9990');

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `extras_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(50) DEFAULT NULL,
  `form_value` varchar(15) DEFAULT NULL,
  `form_id` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`extras_id`, `name`, `price`, `image_url`, `form_value`, `form_id`) VALUES
(1, 'Clear Antique Ball Jars', '30.00', 'walnut-ridge-images/da-7.jpg', 'clearJars', 'clearBall'),
(2, 'Blue Antique Ball Jars', '30.00', 'walnut-ridge-images/da-6.jpg', 'blueJars', 'blueBall'),
(3, 'Vintage Couch', '99.00', 'walnut-ridge-images/da-1.jpg', 'couch', 'vintageCouch'),
(4, 'Antique Gallon Jugs', '4.00', 'walnut-ridge-images/da-8.jpg', 'antique', 'antiqueJugs'),
(5, 'XL Wine Jugs', '20.00', 'walnut-ridge-images/da-4.jpg', 'wine', 'wineJugs'),
(6, 'Hexagon Arbor', '350.00', 'walnut-ridge-images/IMG_5617.jpg', 'arbor', 'arbor');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `note_text` varchar(5000) DEFAULT NULL,
  `note_date` date DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ordered_extras`
--

CREATE TABLE `ordered_extras` (
  `ordered_extras_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `extras_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordered_extras`
--

INSERT INTO `ordered_extras` (`ordered_extras_id`, `reservation_id`, `extras_id`) VALUES
(1, 2, 6),
(17, 5, 2),
(16, 5, 1),
(15, 4, 5),
(14, 4, 4),
(13, 3, 5),
(12, 3, 4),
(11, 3, 2),
(10, 3, 1),
(18, 5, 6),
(19, 14, 1),
(20, 14, 2),
(21, 14, 4),
(22, 14, 5),
(23, 14, 6),
(24, 15, 3),
(25, 16, 4),
(26, 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `reservation_set` varchar(50) DEFAULT NULL,
  `reservation_package` varchar(50) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `status` varchar(30) DEFAULT 'unconfirmed'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `reservation_set`, `reservation_package`, `reservation_date`, `status`) VALUES
(1, 'Layered Arch Package', 'Layered Arch Full Set Rental', '2022-12-09', 'unconfirmed'),
(2, 'Dark Walnut Package', 'Dark Walnut Full Set Rental', '2022-12-22', 'unconfirmed'),
(3, 'Vintage Mirror Package', 'Vintage Mirror Platinum Package', '2023-01-13', 'unconfirmed'),
(4, 'Layered Arch Package ', 'Layered Arch Full Set Rental', '2023-03-10', 'unconfirmed'),
(5, 'Modern Round Package', 'Modern Round Full Set Rental', '2023-03-10', 'unconfirmed'),
(6, 'Layered Arch Package', 'Layered Arch Full Set Rental', '2023-04-14', 'unconfirmed'),
(7, 'Modern Round Package', 'Modern Round Full Set Rental', '2023-04-28', 'unconfirmed'),
(8, 'Vintage Mirror Package', 'Vintage Mirror Platinum Package', '2023-05-19', 'unconfirmed'),
(9, 'Layered Arch Package', 'Layered Arch Full Set Rental', '2023-05-19', 'unconfirmed'),
(10, 'Layered Arch Package', 'Layered Arch Full Set Rental', '2023-06-09', 'unconfirmed'),
(11, 'Layered Arch Package', 'Layered Arch Full Set Rental', '2023-06-30', 'unconfirmed'),
(12, 'Rustic Wood Package', 'Rustic Wood Full Set', '2023-06-30', 'unconfirmed'),
(13, 'Vintage Mirror Package', 'Vintage Mirror Platinum Package', '2023-07-01', 'unconfirmed'),
(14, 'Vintage Mirror Package', 'Vintage Mirror Platinum Package', '2023-08-04', 'unconfirmed'),
(15, 'Modern Round Package', 'Modern Round Full Set Rental', '2023-08-11', 'unconfirmed'),
(16, 'Vintage Mirror Package', 'Vintage Mirror Platinum Package', '2023-09-01', 'unconfirmed'),
(17, 'Modern Round Package', 'Modern Round Pick 6 Rental', '2023-09-01', 'unconfirmed'),
(18, 'Dark Walnut Package', 'Dark Walnut Full Set Rental', '2023-09-02', 'unconfirmed'),
(19, 'Layered Arch Package', 'Layered Arch Full Set Rental', '2023-09-07', 'unconfirmed');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_customers`
--

CREATE TABLE `reservation_customers` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `reservation` int(11) NOT NULL,
  `relationship` varchar(75) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_customers`
--

INSERT INTO `reservation_customers` (`id`, `customer`, `reservation`, `relationship`) VALUES
(1, 1, 1, ''),
(2, 2, 2, ''),
(5, 4, 3, ''),
(6, 5, 4, ''),
(7, 6, 5, ''),
(8, 7, 6, ''),
(9, 8, 7, ''),
(10, 9, 8, ''),
(11, 10, 9, ''),
(12, 11, 10, ''),
(13, 12, 11, ''),
(14, 13, 12, ''),
(15, 14, 13, ''),
(16, 15, 14, ''),
(17, 16, 15, ''),
(18, 17, 16, ''),
(19, 18, 17, ''),
(20, 19, 18, ''),
(21, 20, 19, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`extras_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notes_reservation` (`reservation_id`);

--
-- Indexes for table `ordered_extras`
--
ALTER TABLE `ordered_extras`
  ADD PRIMARY KEY (`ordered_extras_id`),
  ADD KEY `fk_ordered_extras_reservation` (`reservation_id`),
  ADD KEY `fk_extras` (`extras_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `reservation_customers`
--
ALTER TABLE `reservation_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rc_customer` (`customer`),
  ADD KEY `fk_rc_reservation` (`reservation`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `extras_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordered_extras`
--
ALTER TABLE `ordered_extras`
  MODIFY `ordered_extras_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reservation_customers`
--
ALTER TABLE `reservation_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
