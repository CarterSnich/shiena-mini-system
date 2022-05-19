-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2022 at 04:10 AM
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
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` varchar(255) NOT NULL,
  `month` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `gender`, `address`, `month`, `day`, `year`) VALUES
(1, 'Shiena Mae', 'Osares', 'shiena123', '$2y$10$QeiTeYgH7lMJ/gMEuYsVp.0XfB8XPvgxyin8s9RZVwWsxxiP7Qx8G', 'female', 'MacArthur', 3, 22, 2000),
(5, 'John', 'Doe', 'doe_john', '$2y$10$d2rBKbq.aPwSHWc2wqelG.Aa5C.ABsWhgbFM4ImHoLmZni36Its22', 'male', 'Calbayog', 2, 23, 2000),
(6, 'Marco', 'Polo', 'find_me123', '$2y$10$PsABISMFK2snu.LvjseidOuy.9Xi1UdcgL8pmTURT8IXrp7L4bJte', 'male', 'Cebu', 6, 2, 2000),
(7, 'Raul', 'Menendez', 'karma143', '$2y$10$J3EFhc76PCf7/nOwFbvq2uj8HFElCa74HkARc5rRI9aEYnVb5HEsK', 'male', 'Dulag', 10, 11, 2000),
(8, 'Bruce', 'Wayne', 'not_batman101', '$2y$10$QVe31NJOI5baWyyFRIAcm.W4dIDKncrg5IjDZVINCwNDaK/YQVn6y', 'male', 'Palo', 5, 19, 2000),
(9, 'Gura', 'Gawr', 'baby_shark22222', '$2y$10$vC3/SwkfsLBW9JtsrJ9Ype3g24sfVMVQZ9HHLENZ8qV5Vc2GqeSxK', 'female', 'Abuyog', 3, 4, 2001),
(10, 'Richard', 'Gomez', 'gomez_rich123', '$2y$10$EJsjQNwaA84sxwBVUqzn5O6KeHgnHLz.P3v28e/xVFmfNLLPAd8mi', 'male', 'Tolosa', 8, 15, 2000),
(11, 'Johansen', 'Porto', 'portoporto', '$2y$10$ey2gygAMLBTrI0na37/Eqe1tPHA2zHpyWmpaXbV1Y2h7TtJSPa926', 'male', 'Mayorga', 2, 29, 2000),
(13, 'Nikko', 'Noya', 'nikko123', '$2y$10$OvQoD..n9aum.W0Et6U72OHmOf1jth.E07f7Ebb6lhGzzViO4/CFW', 'male', 'MacArthur', 1, 4, 2000),
(14, 'Eula', 'Carter', 'carter_eula', '$2y$10$1vkN2XXAn3T.oJBvMBvElusGT2k.GoLOmBeD.FGXZBTbbXa5W/AMK', 'female', 'Tacloban', 1, 8, 2000),
(15, 'Sheildon', 'Abarca', 'abarca17', '$2y$10$gvL4OiPVW2FddLTmQ.vwPuZFBI9YbS7KFIT1dI64RdpkwJdTUIk3S', 'male', 'MacArthur', 6, 1, 2000),
(17, 'Kenneth', 'adonis', 'kenneth12', '$2y$10$ciuFuS3zO1b98OPYr8QOmOcFQ0.vbsitXXDZoDlrlhgoALaWHJnpu', 'male', 'MacArthur', 5, 1, 2000),
(18, 'Shin', 'Pelle', 'Shin1', '$2y$10$C0xPPo5z3QmB55kS3oZUx.K/q3zHA11RuvQNYnXVq0uaZTodOwF2a', 'male', 'Tuyo', 4, 12, 2001);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
