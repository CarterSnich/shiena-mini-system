-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2022 at 05:26 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shiena-mini-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`) VALUES
(1, 'Shiena Mae', 'Osares', 'shiena123', '$2y$10$QeiTeYgH7lMJ/gMEuYsVp.0XfB8XPvgxyin8s9RZVwWsxxiP7Qx8G'),
(2, 'Juan', 'Perez', 'juan101', '$2y$10$41kOiPfQTBYz4G/Vooyx/./8FyXOgEN4KLru4MaJK.ay1TIo6icxK'),
(5, 'John', 'Doe', 'doe_john', '$2y$10$d2rBKbq.aPwSHWc2wqelG.Aa5C.ABsWhgbFM4ImHoLmZni36Its22'),
(6, 'Marco', 'Polo', 'find_me123', '$2y$10$PsABISMFK2snu.LvjseidOuy.9Xi1UdcgL8pmTURT8IXrp7L4bJte'),
(7, 'Raul', 'Menendez', 'karma143', '$2y$10$J3EFhc76PCf7/nOwFbvq2uj8HFElCa74HkARc5rRI9aEYnVb5HEsK'),
(8, 'Bruce', 'Wayne', 'not_batman101', '$2y$10$QVe31NJOI5baWyyFRIAcm.W4dIDKncrg5IjDZVINCwNDaK/YQVn6y'),
(9, 'Gura', 'Gawr', 'baby_shark22222', '$2y$10$vC3/SwkfsLBW9JtsrJ9Ype3g24sfVMVQZ9HHLENZ8qV5Vc2GqeSxK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
