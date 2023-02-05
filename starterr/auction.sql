-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2022 at 08:17 PM
-- Server version: 10.6.5-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

DROP TABLE IF EXISTS `bids`;
CREATE TABLE IF NOT EXISTS `bids` (
  `bid_id` int(20) UNSIGNED NOT NULL,
  `item_id` int(20) UNSIGNED NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `bid_price` double NOT NULL,
  `user_id` int(20) UNSIGNED NOT NULL,
  `winner` int(1) DEFAULT 0,
  PRIMARY KEY (`bid_id`),
  KEY `item_id` (`item_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`bid_id`, `item_id`, `timestamp`, `bid_price`, `user_id`, `winner`) VALUES
(1, 2, '2022-12-13 14:33:00.000000', 2, 45, 0),
(2, 2, '2022-12-13 14:55:00.000000', 3, 48, 0),
(3, 2, '2022-12-13 14:55:00.000000', 4, 48, 0),
(4, 2, '2022-12-13 14:56:00.000000', 6, 47, 0),
(5, 8, '2022-12-13 14:56:00.000000', 6, 47, 0),
(6, 9, '2022-12-13 14:57:00.000000', 800, 47, 0),
(7, 6, '2022-12-13 14:57:00.000000', 70, 47, 0),
(8, 6, '2022-12-13 15:09:00.000000', 80, 46, 0),
(9, 5, '2022-12-13 15:09:00.000000', 100, 46, 0),
(10, 2, '2022-12-13 15:10:00.000000', 8, 46, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(20) UNSIGNED NOT NULL,
  `category_name` varchar(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Clothing'),
(2, 'Electronics'),
(3, 'Homeware'),
(4, 'Furniture'),
(5, 'Jewelry'),
(6, 'Garden Equipment'),
(7, 'Books & Games'),
(8, 'DVDs, Films and TV'),
(9, 'Collectibles');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(20) UNSIGNED NOT NULL,
  `itemName` varchar(20) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `startPrice` int(64) UNSIGNED NOT NULL,
  `reservePrice` int(64) UNSIGNED DEFAULT NULL,
  `startDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `endDate` datetime NOT NULL,
  `image` varchar(250) NOT NULL,
  `category_id` int(20) UNSIGNED NOT NULL,
  `user_id` int(20) UNSIGNED NOT NULL,
  `email` tinyint(1) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `itemName`, `description`, `startPrice`, `reservePrice`, `startDate`, `endDate`, `image`, `category_id`, `user_id`, `email`) VALUES
(1, 'Treasure Island book', 'a good children\'s book', 4, NULL, '2022-12-13 14:05:00', '2022-12-19 12:00:00', 'IMG-639886c7b91480.19802141.jpg', 7, 45, 0),
(2, 'chair', 'depressing', 1, 1, '2022-12-13 14:07:00', '2022-12-14 14:00:00', 'IMG-6398872bcbd4b3.20272504.jpeg', 4, 45, 0),
(3, 'Lawn Mower', '', 40, 50, '2022-12-13 14:13:00', '2023-03-12 10:00:00', 'IMG-639888a09481a7.73738735.jpg', 6, 45, 0),
(4, 'DVD', '', 2, 3, '2022-12-13 14:28:00', '2023-12-12 01:01:00', 'IMG-63988bff1ed4f4.66451951.jpg', 8, 45, 0),
(5, 'Barbour Jacket', '', 80, 90, '2022-12-13 14:28:00', '2023-03-03 12:00:00', 'IMG-63988c2456cc52.29302562.jpg', 1, 45, 0),
(6, 'Hufflepuff Jumper', 'From harry potter land!!!!', 60, 60, '2022-12-13 14:29:00', '2023-08-08 01:10:00', 'IMG-63988c5f42c390.07202871.jpg', 1, 45, 0),
(7, 'ASUS webcam', '', 80, 90, '2022-12-13 14:32:00', '2023-05-12 10:00:00', 'IMG-63988d0d4a00d2.22695997.jpg', 2, 45, 0),
(8, 'Logitech mouse', '', 4, 12, '2022-12-13 14:38:00', '2022-12-18 17:00:00', 'IMG-63988e56ee64b3.65506193.jpg', 2, 45, 0),
(9, 'Gaming PC', '', 500, 700, '2022-12-13 14:38:00', '2023-05-12 12:00:00', 'IMG-63988e82a4e561.20011256.jpg', 2, 45, 0),
(10, 'spade', '', 12, 15, '2022-12-13 14:42:00', '2022-12-29 12:00:00', 'IMG-63988f5ec9a4d9.44254386.jpg', 6, 45, 0),
(11, 'Dragon\'s chair', '', 13000, 18000, '2022-12-13 14:43:00', '2023-09-24 13:00:00', 'IMG-63988fae8dbae1.02824104.jpg', 4, 45, 0),
(12, 'Black Mountain Bike', 'Hardly ridden, very high quality bike.', 50, 60, '2022-12-13 15:25:00', '2022-12-13 15:28:00', 'IMG-63989954344f33.31231065.jpg', 3, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(50) NOT NULL,
  `account_type` varchar(10) NOT NULL,
  `rec1` int(11) NOT NULL,
  `rec2` int(11) NOT NULL,
  `rec3` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `password`, `email`, `account_type`, `rec1`, `rec2`, `rec3`) VALUES
(45, 'Fergus', 'Cassidy', '$2y$10$5ijgidwzG6l5bcfdxvMT0.etzC01OwCRcOHT8iUjAMGHywjJHA1b6', 'fergusjcassidy@gmail.com', 'both', 1, 2, 6),
(46, 'Fatima', 'Rasheed', '$2y$10$D4mQJDmMXAbut5SqPKrYieFD.leTDz.M/MBMEUQrlbW8.WoD61ifK', 'fatimarasheed20@gmail.com', 'buyer', 1, 3, 5),
(47, 'Fedor', 'Sulitskiy', '$2y$10$kRYvIkd6kDWRBF0.Q5E2Nu99HeS3/lH4qkVjMxMRTwfYCk2wMQBQa', 'f.sulitskiy@gmail.com', 'buyer', 1, 2, 4),
(48, 'Tania', 'Turdean', '$2y$10$Y1bOCJmEyrfaXKTU6MbE9eWx2EALD6m3n9QfHYwFgiD47q6e5Gh3G', 'taniaaalexandra28@gmail.com', 'buyer', 1, 2, 4),
(49, 'James', 'Bradshaw', '$2y$10$L6sz27dpQ0A4TpI8MlMG6O/AXFlMpqJpFkNgWX11vok1eI27x6ChC', 'james@both.com', 'buyer', 1, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE IF NOT EXISTS `watchlist` (
  `watch_id` int(20) NOT NULL AUTO_INCREMENT,
  `userid` int(20) UNSIGNED NOT NULL,
  `itemid` int(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`watch_id`),
  KEY `FK_userid` (`userid`),
  KEY `FK_itemid` (`itemid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bids_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `FK_itemid` FOREIGN KEY (`itemid`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `eventexample`$$
CREATE DEFINER=`root`@`localhost` EVENT `eventexample` ON SCHEDULE AT '2022-12-06 20:53:46' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 18 and bid_price = (select max(bid_price) from bids where item_id =18))$$

DROP EVENT IF EXISTS `endofauction34`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction34` ON SCHEDULE AT '2023-01-03 21:46:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 34 and bid_price = (select max(bid_price) from bids where item_id =34))$$

DROP EVENT IF EXISTS `endofauction35`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction35` ON SCHEDULE AT '2022-12-27 21:50:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 35 and bid_price = (select max(bid_price) from bids where item_id =35))$$

DROP EVENT IF EXISTS `endofauction36`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction36` ON SCHEDULE AT '2022-12-22 21:53:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 36 and bid_price = (select max(bid_price) from bids where item_id =36))$$

DROP EVENT IF EXISTS `endofauction37`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction37` ON SCHEDULE AT '2022-12-30 21:54:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 37 and bid_price = (select max(bid_price) from bids where item_id =37))$$

DROP EVENT IF EXISTS `endofauction38`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction38` ON SCHEDULE AT '2022-12-06 23:55:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 38 and bid_price = (select max(bid_price) from bids where item_id =38))$$

DROP EVENT IF EXISTS `endofauction39`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction39` ON SCHEDULE AT '2022-12-07 10:40:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 39 and bid_price = (select max(bid_price) from bids where item_id =39))$$

DROP EVENT IF EXISTS `endofauction40`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction40` ON SCHEDULE AT '2022-12-07 22:15:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 40 and bid_price = (select max(bid_price) from bids where item_id =40))$$

DROP EVENT IF EXISTS `endofauction41`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction41` ON SCHEDULE AT '2022-12-07 22:33:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 41 and bid_price = (select max(bid_price) from bids where item_id =41))$$

DROP EVENT IF EXISTS `endofauction42`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction42` ON SCHEDULE AT '2022-12-07 22:42:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 42 and bid_price = (select max(bid_price) from bids where item_id =42))$$

DROP EVENT IF EXISTS `endofauction43`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction43` ON SCHEDULE AT '2022-12-09 12:27:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 43 and bid_price = (select max(bid_price) from bids where item_id =43))$$

DROP EVENT IF EXISTS `endofauction44`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction44` ON SCHEDULE AT '2022-12-08 12:30:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 44 and bid_price = (select max(bid_price) from bids where item_id =44))$$

DROP EVENT IF EXISTS `endofauction45`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction45` ON SCHEDULE AT '2022-12-08 12:42:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 45 and bid_price = (select max(bid_price) from bids where item_id =45))$$

DROP EVENT IF EXISTS `endofauction46`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction46` ON SCHEDULE AT '2022-12-08 12:45:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 46 and bid_price = (select max(bid_price) from bids where item_id =46))$$

DROP EVENT IF EXISTS `endofauction47`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction47` ON SCHEDULE AT '2022-12-08 12:50:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 47 and bid_price = (select max(bid_price) from bids where item_id =47))$$

DROP EVENT IF EXISTS `endofauction48`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction48` ON SCHEDULE AT '2022-12-11 15:41:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 48 and bid_price = (select max(bid_price) from bids where item_id =48))$$

DROP EVENT IF EXISTS `endofauction49`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction49` ON SCHEDULE AT '2022-12-11 16:04:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 49 and bid_price = (select max(bid_price) from bids where item_id =49))$$

DROP EVENT IF EXISTS `endofauction50`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction50` ON SCHEDULE AT '2022-12-11 17:15:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 50 and bid_price = (select max(bid_price) from bids where item_id =50))$$

DROP EVENT IF EXISTS `endofauction51`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction51` ON SCHEDULE AT '2022-12-11 17:18:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 51 and bid_price = (select max(bid_price) from bids where item_id =51))$$

DROP EVENT IF EXISTS `endofauction52`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction52` ON SCHEDULE AT '2022-12-11 17:22:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 52 and bid_price = (select max(bid_price) from bids where item_id =52))$$

DROP EVENT IF EXISTS `endofauction53`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction53` ON SCHEDULE AT '2022-12-11 17:26:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 53 and bid_price = (select max(bid_price) from bids where item_id =53))$$

DROP EVENT IF EXISTS `endofauction54`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction54` ON SCHEDULE AT '2022-12-11 17:29:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 54 and bid_price = (select max(bid_price) from bids where item_id =54))$$

DROP EVENT IF EXISTS `endofauction55`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction55` ON SCHEDULE AT '2022-12-11 17:31:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 55 and bid_price = (select max(bid_price) from bids where item_id =55))$$

DROP EVENT IF EXISTS `endofauction56`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction56` ON SCHEDULE AT '2022-12-11 17:38:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 56 and bid_price = (select max(bid_price) from bids where item_id =56))$$

DROP EVENT IF EXISTS `endofauction57`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction57` ON SCHEDULE AT '2022-12-11 18:06:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 57 and bid_price = (select max(bid_price) from bids where item_id =57))$$

DROP EVENT IF EXISTS `endofauction58`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction58` ON SCHEDULE AT '2022-12-11 18:10:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 58 and bid_price = (select max(bid_price) from bids where item_id =58))$$

DROP EVENT IF EXISTS `endofauction59`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction59` ON SCHEDULE AT '2022-12-11 18:12:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 59 and bid_price = (select max(bid_price) from bids where item_id =59))$$

DROP EVENT IF EXISTS `endofauction60`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction60` ON SCHEDULE AT '2022-12-11 18:34:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 60 and bid_price = (select max(bid_price) from bids where item_id =60))$$

DROP EVENT IF EXISTS `endofauction61`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction61` ON SCHEDULE AT '2022-12-23 18:35:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 61 and bid_price = (select max(bid_price) from bids where item_id =61))$$

DROP EVENT IF EXISTS `endofauction62`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction62` ON SCHEDULE AT '2022-12-12 01:09:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 62 and bid_price = (select max(bid_price) from bids where item_id =62))$$

DROP EVENT IF EXISTS `endofauction63`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction63` ON SCHEDULE AT '2022-12-12 01:25:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 63 and bid_price = (select max(bid_price) from bids where item_id =63))$$

DROP EVENT IF EXISTS `endofauction64`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction64` ON SCHEDULE AT '2022-12-12 02:03:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 64 and bid_price = (select max(bid_price) from bids where item_id =64))$$

DROP EVENT IF EXISTS `endofauction65`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction65` ON SCHEDULE AT '2022-12-12 02:09:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 65 and bid_price = (select max(bid_price) from bids where item_id =65))$$

DROP EVENT IF EXISTS `endofauction66`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction66` ON SCHEDULE AT '2022-12-12 02:14:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 66 and bid_price = (select max(bid_price) from bids where item_id =66))$$

DROP EVENT IF EXISTS `endofauction67`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction67` ON SCHEDULE AT '2022-12-12 02:21:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 67 and bid_price = (select max(bid_price) from bids where item_id =67))$$

DROP EVENT IF EXISTS `endofauction68`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction68` ON SCHEDULE AT '2022-12-12 02:25:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 68 and bid_price = (select max(bid_price) from bids where item_id =68))$$

DROP EVENT IF EXISTS `endofauction69`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction69` ON SCHEDULE AT '2022-12-12 11:25:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 69 and bid_price = (select max(bid_price) from bids where item_id =69))$$

DROP EVENT IF EXISTS `endofauction70`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction70` ON SCHEDULE AT '2022-12-12 11:42:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 70 and bid_price = (select max(bid_price) from bids where item_id =70))$$

DROP EVENT IF EXISTS `endofauction71`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction71` ON SCHEDULE AT '2022-12-12 11:43:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 71 and bid_price = (select max(bid_price) from bids where item_id =71))$$

DROP EVENT IF EXISTS `endofauction72`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction72` ON SCHEDULE AT '2022-12-12 11:50:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 72 and bid_price = (select max(bid_price) from bids where item_id =72))$$

DROP EVENT IF EXISTS `endofauction73`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction73` ON SCHEDULE AT '2022-12-13 11:48:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 73 and bid_price = (select max(bid_price) from bids where item_id =73))$$

DROP EVENT IF EXISTS `endofauction74`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction74` ON SCHEDULE AT '2022-12-28 11:49:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 74 and bid_price = (select max(bid_price) from bids where item_id =74))$$

DROP EVENT IF EXISTS `endofauction75`$$
CREATE DEFINER=`test`@`localhost` EVENT `endofauction75` ON SCHEDULE AT '2022-12-14 11:49:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 75 and bid_price = (select max(bid_price) from bids where item_id =75))$$

DROP EVENT IF EXISTS `endofauction76`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction76` ON SCHEDULE AT '2022-12-12 22:06:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 76 and bid_price = (select max(bid_price) from bids where item_id =76))$$

DROP EVENT IF EXISTS `endofauction77`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction77` ON SCHEDULE AT '2022-12-13 03:39:00' ON COMPLETION PRESERVE DISABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 77 and bid_price = (select max(bid_price) from bids where item_id =77))$$

DROP EVENT IF EXISTS `endofauction1`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction1` ON SCHEDULE AT '2022-12-19 12:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 1 and bid_price = (select max(bid_price) from bids where item_id =1))$$

DROP EVENT IF EXISTS `endofauction2`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction2` ON SCHEDULE AT '2022-12-14 14:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 2 and bid_price = (select max(bid_price) from bids where item_id =2))$$

DROP EVENT IF EXISTS `endofauction3`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction3` ON SCHEDULE AT '2023-03-12 10:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 3 and bid_price = (select max(bid_price) from bids where item_id =3))$$

DROP EVENT IF EXISTS `endofauction4`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction4` ON SCHEDULE AT '2023-12-12 01:01:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 4 and bid_price = (select max(bid_price) from bids where item_id =4))$$

DROP EVENT IF EXISTS `endofauction5`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction5` ON SCHEDULE AT '2023-03-03 12:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 5 and bid_price = (select max(bid_price) from bids where item_id =5))$$

DROP EVENT IF EXISTS `endofauction6`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction6` ON SCHEDULE AT '2023-08-08 01:10:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 6 and bid_price = (select max(bid_price) from bids where item_id =6))$$

DROP EVENT IF EXISTS `endofauction7`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction7` ON SCHEDULE AT '2023-05-12 10:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 7 and bid_price = (select max(bid_price) from bids where item_id =7))$$

DROP EVENT IF EXISTS `endofauction8`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction8` ON SCHEDULE AT '2022-12-18 17:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 8 and bid_price = (select max(bid_price) from bids where item_id =8))$$

DROP EVENT IF EXISTS `endofauction9`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction9` ON SCHEDULE AT '2023-05-12 12:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 9 and bid_price = (select max(bid_price) from bids where item_id =9))$$

DROP EVENT IF EXISTS `endofauction10`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction10` ON SCHEDULE AT '2022-12-29 12:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 10 and bid_price = (select max(bid_price) from bids where item_id =10))$$

DROP EVENT IF EXISTS `endofauction11`$$
CREATE DEFINER=`root`@`localhost` EVENT `endofauction11` ON SCHEDULE AT '2023-09-24 13:00:00' ON COMPLETION PRESERVE ENABLE DO UPDATE `bids` SET `winner`=1 WHERE (item_id = 11 and bid_price = (select max(bid_price) from bids where item_id =11))$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
