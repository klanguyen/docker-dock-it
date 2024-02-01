-- phpMyAdmin SQL Dump
-- version 5.1.4-dev+20220331.b9ddf0b305
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2024 at 09:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nnguyen1`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuthUsers`
--

CREATE TABLE `AuthUsers` (
  `UserID` int(10) UNSIGNED NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('User','Admin') NOT NULL DEFAULT 'User',
  `LastModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `AuthUsers`
--

INSERT INTO `AuthUsers` (`UserID`, `Email`, `Password`, `Role`, `LastModified`) VALUES
(1, 'kayla@demomail.com', '$2y$10$n3JTUhiW2tuw0C4TcFdxie4nOdqM6Q6QW7RIG99oQCPbygAsm.HlO', 'User', NULL),
(4, 'admin@funflix.com', '$2y$10$HLt9.WL2Hjr8z9c9n5u.huiuyj.1b1lxi7/z9p3tRK/squUsYDrsK', 'Admin', NULL),
(5, 'user@funflix.com', '$2y$10$uwcpnFSDZKn1aUo4i.GQCuLuxcBjM.mn9iDrWTQenh8mQK5QKPtU6', 'User', NULL),
(6, 'mod@funflix.com', '$2y$10$.kUfrfiQHPYCFFkcLOfqKuPKKnxXakj0OYYvLCohqKfY.ZuvGSyui', 'Admin', NULL),
(7, 'kayla@funflix.com', '$2y$10$x6EIr.7bOyttxAEewcORXepx/70ZmhpVfQK7Z9zH83A7uPQc396tO', 'User', NULL),
(12, 'kayla@user.com', '$2y$10$C7c1XzRapn/joA3DgIQalu/oiP1vuTqmhjye49lbwC56zH5uqB9Ua', 'User', NULL),
(16, 'kayla@funflix.gmail.com', '$2y$10$jv2LRyojxu7IvHTSAsf7HOsRVBnQ3c4Lo/XlVquyFoMi75bAO3mcW', 'User', NULL),
(17, 'account@funflix.com', '$2y$10$TuyI.FiPM3R5bAgMbvZZzuoRwPPXcZL0Bk37phfC9hBElq1VseKPm', 'User', NULL),
(18, 'kaylademo@funflix.com', '$2y$10$OcupN80WhxgCcePU0kmMGu0zbSjg2T./Vms7.N5Hv/Xi.e56HlwBq', 'User', NULL),
(19, 'tkowalch@wctc.edu', '$2y$10$OsBeLgIVcFLLWfDAA/kI8udcxHy2tT/FLuy.rq53YE08uam2LbJTS', 'User', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Genres`
--

CREATE TABLE `Genres` (
  `GenreID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Genres`
--

INSERT INTO `Genres` (`GenreID`, `Name`) VALUES
(5, 'Action'),
(11, 'Adventure'),
(10, 'Animation'),
(1, 'Comedy'),
(9, 'Crime'),
(7, 'Drama'),
(12, 'Fantasy'),
(3, 'Horror'),
(8, 'Mistery'),
(4, 'Romance'),
(2, 'Sci-Fi'),
(6, 'Thriller');

-- --------------------------------------------------------

--
-- Table structure for table `MovieCredits`
--

CREATE TABLE `MovieCredits` (
  `MovieID` int(10) UNSIGNED NOT NULL,
  `PersonID` int(10) UNSIGNED NOT NULL,
  `RoleID` int(10) UNSIGNED NOT NULL,
  `CharacterName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `MovieCredits`
--

INSERT INTO `MovieCredits` (`MovieID`, `PersonID`, `RoleID`, `CharacterName`) VALUES
(1, 1, 2, NULL),
(1, 2, 1, 'Detective Pikachu'),
(1, 3, 1, 'Tim Goodman'),
(1, 4, 1, 'Lucy Stevens'),
(5, 5, 2, NULL),
(5, 6, 1, 'Woody'),
(5, 7, 1, 'Buzz Lightyear'),
(5, 8, 1, 'Bo Beep'),
(6, 9, 2, NULL),
(6, 10, 3, NULL),
(6, 11, 1, 'Captain Marvel'),
(6, 12, 1, 'Nick Fury'),
(7, 12, 1, 'Nick Fury'),
(7, 13, 2, NULL),
(7, 14, 1, 'Peter Parker'),
(7, 15, 1, 'Mysterio');

-- --------------------------------------------------------

--
-- Table structure for table `MovieGenre`
--

CREATE TABLE `MovieGenre` (
  `MovieID` int(10) UNSIGNED NOT NULL,
  `GenreID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `MovieGenre`
--

INSERT INTO `MovieGenre` (`MovieID`, `GenreID`) VALUES
(1, 1),
(1, 5),
(1, 11),
(5, 1),
(5, 10),
(5, 11),
(6, 2),
(6, 5),
(6, 11),
(7, 2),
(7, 5),
(7, 11),
(8, 5),
(8, 8),
(8, 10),
(9, 1),
(9, 10),
(10, 1),
(10, 5),
(10, 9),
(11, 5),
(11, 9),
(15, 1),
(15, 2),
(15, 7),
(15, 10),
(15, 11),
(15, 12),
(42, 10),
(42, 11);

-- --------------------------------------------------------

--
-- Table structure for table `Movies`
--

CREATE TABLE `Movies` (
  `MovieID` int(10) UNSIGNED NOT NULL,
  `MovieName` varchar(255) NOT NULL,
  `ReleaseDate` date DEFAULT NULL,
  `Overview` text DEFAULT NULL,
  `Runtime` smallint(5) UNSIGNED DEFAULT NULL,
  `PosterPath` varchar(255) DEFAULT NULL,
  `CompanyID` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Movies`
--

INSERT INTO `Movies` (`MovieID`, `MovieName`, `ReleaseDate`, `Overview`, `Runtime`, `PosterPath`, `CompanyID`) VALUES
(1, 'Pokémon Detective Pikachu', '2019-05-10', 'In a world where people collect Pokémon to do battle, a boy comes across an intelligent talking Pikachu who seeks to be a detective.', 104, 'https://www.hcpress.com/img/pikachu.jpg', 2),
(5, 'Toy Story 4', '2019-06-21', 'When a new toy called \"Forky\" joins Woody and the gang, a road trip alongside old and new friends reveals how big the world can be for a toy.', 100, 'https://www.joblo.com/assets/images/joblo/posters/2019/02/Dyow9RgX4AElAGN.jpg', 1),
(6, 'Captain Marvel', '2019-03-08', 'Carol Danvers becomes one of the universe\'s most powerful heroes when Earth is caught in the middle of a galactic war between two alien races.', 123, 'https://m.media-amazon.com/images/M/MV5BMTE0YWFmOTMtYTU2ZS00ZTIxLWE3OTEtYTNiYzBkZjViZThiXkEyXkFqcGdeQXVyODMzMzQ4OTI@._V1_FMjpg_UX1000_.jpg', 1),
(7, 'Spider-Man: Far from Home', '2019-07-02', 'Following the events of Avengers: Endgame (2019), Spider-Man must step up to take on new threats in a world that has changed forever.', 129, 'https://www.joblo.com/assets/images/joblo/posters/2019/01/Spider-Man-Far-From-Home-poster-1.jpg', NULL),
(8, 'Mortal Kombat', '2021-04-23', 'MMA fighter Cole Young seeks out Earth\'s greatest champions in order to stand against the enemies of Outworld in a high stakes battle for the universe.', 110, 'https://www.joblo.com/assets/images/joblo/posters/2021/03/mortal-kombat-poster.jpg', 1),
(9, 'Promising Young Woman', '2020-12-25', 'A young woman, traumatized by a tragic event in her past, seeks out vengeance against those who crossed her path.', 113, 'https://www.joblo.com/assets/images/joblo/posters/2020/01/promising-woman-poster.jpg', 1),
(10, 'Nobody', '2021-03-26', 'A bystander who intervenes to help a woman being harassed by a group of men becomes the target of a vengeful drug lord.', 92, 'https://www.joblo.com/assets/images/joblo/posters/2021/01/nobody-NBD_Teaser1Sheet5_rgb.jpg', 1),
(11, 'Ava', '2020-09-25', 'Ava is a deadly assassin who works for a black ops organization, traveling the globe specializing in high profile hits. When a job goes dangerously wrong she is forced to fight for her own survival.', 96, 'https://m.media-amazon.com/images/M/MV5BMTMzMTg1MjgtOWNhYy00NmZmLWExOTctMjA2OTZhZDFkNDhhXkEyXkFqcGdeQXVyNzAwMjU2MTY@._V1_FMjpg_UX1000_.jpg', 1),
(13, 'Gretel &amp; Hansel', '2020-01-31', 'A long time ago in a distant fairy tale countryside, a young girl leads her little brother into a dark wood in desperate search of food and work, only to stumble upon a nexus of terrifying evil.', 87, 'https://m.media-amazon.com/images/M/MV5BM2IxMzRiMzMtYWRjNy00ODU3LWI2ODctNmFmMjA5OTU2NThmXkEyXkFqcGdeQXVyMTA4NjE0NjEy._V1_.jpg', 1),
(14, 'Good Boys', '2019-08-16', 'Three 6th grade boys ditch school and embark on an epic journey while carrying accidentally stolen drugs, being hunted by teenage girls, and trying to make their way home in time for a long-awaited party.', 90, 'https://m.media-amazon.com/images/M/MV5BMTc1NjIzODAxMF5BMl5BanBnXkFtZTgwMTgzNzk1NzM@._V1_.jpg', 1),
(15, 'The Grinch', '2018-11-09', 'A grumpy Grinch (Benedict Cumberbatch) plots to ruin Christmas for the village of Whoville.', 85, 'https://www.joblo.com/assets/images/oldsite/posters/images/full/GRC_Adv1Sheet_GrinchFace_RGB_2SM.jpg', 1),
(16, 'A Quiet Place', '2018-04-06', 'In a post-apocalyptic world, a family is forced to live in silence while hiding from monsters with ultra-sensitive hearing.alert(\'hi\');', 90, 'https://pbs.twimg.com/media/Efeo7_tUwAAcQaY.jpg', 1),
(17, 'Knives Out', '2019-11-27', 'A detective investigates the death of a patriarch of an eccentric, combative family.', 130, 'https://www.joblo.com/assets/images/joblo/posters/2019/09/knives-out-final-poster.jpg', NULL),
(18, 'Midsommar', '2019-07-03', 'A couple travels to Scandinavia to visit a rural hometown\'s fabled Swedish mid-summer festival. What begins as an idyllic retreat quickly devolves into an increasingly violent and bizarre competition at the hands of a pagan cult.', 148, 'https://www.joblo.com/assets/images/joblo/posters/2019/05/D6DL219W4AEJK1C.jpg', 1),
(19, 'Miss Bala', '2019-02-01', 'Gloria finds a power she never knew she had when she is drawn into a dangerous world of cross-border crime. Surviving will require all of her cunning, inventiveness, and strength. Based on the Spanish-language film.', 104, 'https://www.joblo.com/assets/images/joblo/posters/2018/12/miss_bala_poster.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `People`
--

CREATE TABLE `People` (
  `PersonID` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `MiddleInitial` char(1) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `Deathdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `People`
--

INSERT INTO `People` (`PersonID`, `FirstName`, `LastName`, `MiddleInitial`, `Birthdate`, `Deathdate`) VALUES
(1, 'Rob', 'Letterman', NULL, NULL, NULL),
(2, 'Ryan', 'Reynolds', NULL, NULL, NULL),
(3, 'Justice', 'Smith', NULL, NULL, NULL),
(4, 'Kathryn', 'Newton', NULL, NULL, NULL),
(5, 'Josh', 'Cooley', NULL, NULL, NULL),
(6, 'Tom', 'Hanks', NULL, NULL, NULL),
(7, 'Tim', 'Allen', NULL, NULL, NULL),
(8, 'Annie', 'Potts', NULL, NULL, NULL),
(9, 'Anna', 'Boden', NULL, NULL, NULL),
(10, 'Ryan', 'Fleck', NULL, NULL, NULL),
(11, 'Brie', 'Larson', NULL, NULL, NULL),
(12, 'Samuel', 'Jackson', 'L', NULL, NULL),
(13, 'Jon', 'Watts', NULL, NULL, NULL),
(14, 'Tom', 'Holland', NULL, NULL, NULL),
(15, 'Jake', 'Gyllenhaal', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ProductionCompanies`
--

CREATE TABLE `ProductionCompanies` (
  `CompanyID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ProductionCompanies`
--

INSERT INTO `ProductionCompanies` (`CompanyID`, `Name`) VALUES
(1, 'A24'),
(2, 'Warner Bros.');

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `RoleID` int(10) UNSIGNED NOT NULL,
  `RoleName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`RoleID`, `RoleName`) VALUES
(1, 'Actor'),
(2, 'Director'),
(3, 'Writer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AuthUsers`
--
ALTER TABLE `AuthUsers`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `Genres`
--
ALTER TABLE `Genres`
  ADD PRIMARY KEY (`GenreID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `MovieCredits`
--
ALTER TABLE `MovieCredits`
  ADD PRIMARY KEY (`MovieID`,`PersonID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- Indexes for table `MovieGenre`
--
ALTER TABLE `MovieGenre`
  ADD PRIMARY KEY (`MovieID`,`GenreID`);

--
-- Indexes for table `Movies`
--
ALTER TABLE `Movies`
  ADD PRIMARY KEY (`MovieID`),
  ADD UNIQUE KEY `MovieName` (`MovieName`),
  ADD KEY `CompanyID` (`CompanyID`);

--
-- Indexes for table `People`
--
ALTER TABLE `People`
  ADD PRIMARY KEY (`PersonID`);

--
-- Indexes for table `ProductionCompanies`
--
ALTER TABLE `ProductionCompanies`
  ADD PRIMARY KEY (`CompanyID`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AuthUsers`
--
ALTER TABLE `AuthUsers`
  MODIFY `UserID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Genres`
--
ALTER TABLE `Genres`
  MODIFY `GenreID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Movies`
--
ALTER TABLE `Movies`
  MODIFY `MovieID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `People`
--
ALTER TABLE `People`
  MODIFY `PersonID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ProductionCompanies`
--
ALTER TABLE `ProductionCompanies`
  MODIFY `CompanyID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Roles`
--
ALTER TABLE `Roles`
  MODIFY `RoleID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
