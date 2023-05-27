-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2023 at 04:37 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Hand Made', 'Hand made items', 0, 1, 1, 1, 1),
(2, 'Copmuters', 'Computes items', 0, 2, 0, 0, 0),
(3, 'Cell Phones', 'Cell phones items', 0, 3, 0, 0, 0),
(4, 'Clothing', 'Clothing and Fashion items', 0, 4, 0, 0, 0),
(5, 'Tools', 'Home tools', 0, 5, 0, 0, 0),
(7, 'Samsung', 'Samsung phones', 3, 4, 0, 0, 0),
(8, 'Boxes', 'Boxes hand mad', 1, 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Com_ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` tinyint(4) NOT NULL DEFAULT 0,
  `Com_Date` date NOT NULL DEFAULT current_timestamp(),
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Com_ID`, `Comment`, `Status`, `Com_Date`, `item_id`, `user_id`) VALUES
(1, 'thank you', 1, '2023-04-17', 1, 1),
(2, 'very good', 1, '2023-04-17', 3, 1),
(3, 'good item', 1, '2023-04-17', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `User_ID`, `tags`) VALUES
(1, 'Speaker', 'very good speaker', '$10', '2023-04-13', 'China', '', '1', 0, 1, 2, 1, ''),
(2, 'Yeti blue mic', 'very good mic', '$108', '2023-04-13', 'USA', '', '1', 0, 1, 2, 1, ''),
(3, 'iphone 63', 'phone', '$300', '2023-04-13', 'USA', '', '2', 0, 1, 3, 1, ''),
(4, 'Magic Mouse', 'Apple magic mouse', '$150', '2023-04-13', 'USA', '', '1', 0, 1, 2, 1, ''),
(5, 'Network Cable', 'Cat9 network cable', '$10', '2023-04-13', 'USA', '', '1', 0, 1, 2, 1, ''),
(6, 'Game', 'test game', '$120', '2023-04-15', 'USA', '', '2', 0, 1, 1, 4, ''),
(7, 'Mac MIC', 'Mac Mic is good for record your voise', '$30', '2023-04-18', 'USA', '', '1', 0, 1, 2, 1, ''),
(13, 'AirPods', 'Apple Wirless Bluetooth', '$30', '2023-04-18', 'USA', '', '1', 0, 1, 3, 1, 'mohanad, phones, discount, new, airpods'),
(14, 'Wooden Game', 'good wooden game', '$100', '2023-04-19', 'Europe', '', '1', 0, 1, 2, 1, 'mohanad, hand, discount, gurantee'),
(15, 'Sun Glasses ', 'very cool sun glasses ', '$30', '2023-04-19', 'USA', '', '1', 0, 1, 4, 1, 'mohanad, clothing, discount, new, sun, glasses');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `password`, `UserEmail`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `Avatar`) VALUES
(1, 'Mohanad', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679', 'mohanad@moon.code', 'Mohanad Tawfik', 1, 1, 1, '0000-00-00', ''),
(3, 'Mohammed', 'dd01903921ea24941c26a48f2cec24e0bb0e8cc7', 'mohammed@gmail.com', '', 0, 0, 0, '2023-04-15', ''),
(4, 'Omar', '011c945f30ce2cbafc452f39840f025693339c42', 'omar@omar.com', '', 0, 0, 0, '2023-04-15', ''),
(5, 'Moayad', 'dd01903921ea24941c26a48f2cec24e0bb0e8cc7', 'moayad@gamil.com', '', 0, 0, 0, '2023-04-15', ''),
(6, 'Ahmed', 'dd01903921ea24941c26a48f2cec24e0bb0e8cc7', 'ahmed@gmail.com', 'Ahmed Yassen', 0, 0, 1, '2023-04-20', '88371178979_user.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Name_2` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Com_ID`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `comments_ibfk_2` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Com_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
