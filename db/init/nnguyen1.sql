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

DROP TABLE IF EXISTS `AuthUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthUsers` (
                             `UserID` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `Email` varchar(255) NOT NULL,
                             `Password` varchar(255) NOT NULL,
                             `Role` enum('User','Admin') NOT NULL DEFAULT 'User',
                             `LastModified` datetime DEFAULT NULL,
                             PRIMARY KEY (`UserID`),
                             UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthUsers`
--

LOCK TABLES `AuthUsers` WRITE;
/*!40000 ALTER TABLE `AuthUsers` DISABLE KEYS */;
INSERT INTO `AuthUsers` VALUES (1,'kayla@demomail.com','$2y$10$n3JTUhiW2tuw0C4TcFdxie4nOdqM6Q6QW7RIG99oQCPbygAsm.HlO','User',NULL),(4,'admin@funflix.com','$2y$10$HLt9.WL2Hjr8z9c9n5u.huiuyj.1b1lxi7/z9p3tRK/squUsYDrsK','Admin',NULL),(5,'user@funflix.com','$2y$10$uwcpnFSDZKn1aUo4i.GQCuLuxcBjM.mn9iDrWTQenh8mQK5QKPtU6','User',NULL),(6,'mod@funflix.com','$2y$10$.kUfrfiQHPYCFFkcLOfqKuPKKnxXakj0OYYvLCohqKfY.ZuvGSyui','Admin',NULL),(7,'kayla@funflix.com','$2y$10$x6EIr.7bOyttxAEewcORXepx/70ZmhpVfQK7Z9zH83A7uPQc396tO','User',NULL),(12,'kayla@user.com','$2y$10$C7c1XzRapn/joA3DgIQalu/oiP1vuTqmhjye49lbwC56zH5uqB9Ua','User',NULL),(16,'kayla@funflix.gmail.com','$2y$10$jv2LRyojxu7IvHTSAsf7HOsRVBnQ3c4Lo/XlVquyFoMi75bAO3mcW','User',NULL),(17,'account@funflix.com','$2y$10$TuyI.FiPM3R5bAgMbvZZzuoRwPPXcZL0Bk37phfC9hBElq1VseKPm','User',NULL),(18,'kaylademo@funflix.com','$2y$10$OcupN80WhxgCcePU0kmMGu0zbSjg2T./Vms7.N5Hv/Xi.e56HlwBq','User',NULL),(19,'tkowalch@wctc.edu','$2y$10$OsBeLgIVcFLLWfDAA/kI8udcxHy2tT/FLuy.rq53YE08uam2LbJTS','User',NULL);
/*!40000 ALTER TABLE `AuthUsers` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Table structure for table `Genres`
--

DROP TABLE IF EXISTS `Genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Genres` (
                          `GenreID` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `Name` varchar(100) NOT NULL,
                          PRIMARY KEY (`GenreID`),
                          UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Genres`
--

LOCK TABLES `Genres` WRITE;
/*!40000 ALTER TABLE `Genres` DISABLE KEYS */;
INSERT INTO `Genres` VALUES (5,'Action'),(11,'Adventure'),(10,'Animation'),(1,'Comedy'),(9,'Crime'),(7,'Drama'),(12,'Fantasy'),(3,'Horror'),(8,'Mistery'),(4,'Romance'),(2,'Sci-Fi'),(6,'Thriller');
/*!40000 ALTER TABLE `Genres` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Table structure for table `MovieCredits`
--

DROP TABLE IF EXISTS `MovieCredits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MovieCredits` (
                                `MovieID` int(10) unsigned NOT NULL,
                                `PersonID` int(10) unsigned NOT NULL,
                                `RoleID` int(10) unsigned NOT NULL,
                                `CharacterName` varchar(255) DEFAULT NULL,
                                PRIMARY KEY (`MovieID`,`PersonID`),
                                KEY `RoleID` (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MovieCredits`
--

LOCK TABLES `MovieCredits` WRITE;
/*!40000 ALTER TABLE `MovieCredits` DISABLE KEYS */;
INSERT INTO `MovieCredits` VALUES (1,1,2,NULL),(1,2,1,'Detective Pikachu'),(1,3,1,'Tim Goodman'),(1,4,1,'Lucy Stevens'),(5,5,2,NULL),(5,6,1,'Woody'),(5,7,1,'Buzz Lightyear'),(5,8,1,'Bo Beep'),(6,9,2,NULL),(6,10,3,NULL),(6,11,1,'Captain Marvel'),(6,12,1,'Nick Fury'),(7,12,1,'Nick Fury'),(7,13,2,NULL),(7,14,1,'Peter Parker'),(7,15,1,'Mysterio');
/*!40000 ALTER TABLE `MovieCredits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MovieGenre`
--

DROP TABLE IF EXISTS `MovieGenre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MovieGenre` (
                              `MovieID` int(10) unsigned NOT NULL,
                              `GenreID` int(10) unsigned NOT NULL,
                              PRIMARY KEY (`MovieID`,`GenreID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MovieGenre`
--

LOCK TABLES `MovieGenre` WRITE;
/*!40000 ALTER TABLE `MovieGenre` DISABLE KEYS */;
INSERT INTO `MovieGenre` VALUES (1,1),(1,5),(1,11),(5,1),(5,10),(5,11),(6,2),(6,5),(6,11),(7,2),(7,5),(7,11),(8,5),(8,8),(8,10),(9,1),(9,10),(10,1),(10,5),(10,9),(11,5),(11,9),(15,1),(15,2),(15,7),(15,10),(15,11),(15,12),(42,10),(42,11);
/*!40000 ALTER TABLE `MovieGenre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Movies`
--

DROP TABLE IF EXISTS `Movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Movies` (
                          `MovieID` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `MovieName` varchar(255) NOT NULL,
                          `ReleaseDate` date DEFAULT NULL,
                          `Overview` text DEFAULT NULL,
                          `Runtime` smallint(5) unsigned DEFAULT NULL,
                          `PosterPath` varchar(255) DEFAULT NULL,
                          `CompanyID` int(10) unsigned DEFAULT NULL,
                          PRIMARY KEY (`MovieID`),
                          UNIQUE KEY `MovieName` (`MovieName`),
                          KEY `CompanyID` (`CompanyID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Movies`
--

LOCK TABLES `Movies` WRITE;
/*!40000 ALTER TABLE `Movies` DISABLE KEYS */;
INSERT INTO `Movies` VALUES (1,'Pokémon Detective Pikachu','2019-05-10','In a world where people collect Pokémon to do battle, a boy comes across an intelligent talking Pikachu who seeks to be a detective.',104,'https://www.joblo.com/assets/images/joblo/posters/2019/02/detective-pikachu-trailer-poster-main.jpg',2),(5,'Toy Story 4','2019-06-21','When a new toy called \"Forky\" joins Woody and the gang, a road trip alongside old and new friends reveals how big the world can be for a toy.',100,'https://www.joblo.com/assets/images/joblo/posters/2019/02/Dyow9RgX4AElAGN.jpg',1),(6,'Captain Marvel','2019-03-08','Carol Danvers becomes one of the universe\'s most powerful heroes when Earth is caught in the middle of a galactic war between two alien races.',123,'https://www.joblo.com/assets/images/joblo/posters/2019/02/captin-marvel-poster-international.jpg',NULL),(7,'Spider-Man: Far from Home','2019-07-02','Following the events of Avengers: Endgame (2019), Spider-Man must step up to take on new threats in a world that has changed forever.',129,'https://www.joblo.com/assets/images/joblo/posters/2019/01/Spider-Man-Far-From-Home-poster-1.jpg',NULL),(8,'Mortal Kombat','2021-04-23','MMA fighter Cole Young seeks out Earth\'s greatest champions in order to stand against the enemies of Outworld in a high stakes battle for the universe.',110,'https://www.joblo.com/assets/images/joblo/posters/2021/03/mortal-kombat-poster.jpg',1),(9,'Promising Young Woman','2020-12-25','A young woman, traumatized by a tragic event in her past, seeks out vengeance against those who crossed her path.',113,'https://www.joblo.com/assets/images/joblo/posters/2020/01/promising-woman-poster.jpg',1),(10,'Nobody','2021-03-26','A bystander who intervenes to help a woman being harassed by a group of men becomes the target of a vengeful drug lord.',92,'https://www.joblo.com/assets/images/joblo/posters/2021/01/nobody-NBD_Teaser1Sheet5_rgb.jpg',1),(11,'Ava','2020-09-25','Ava is a deadly assassin who works for a black ops organization, traveling the globe specializing in high profile hits. When a job goes dangerously wrong she is forced to fight for her own survival.',96,'https://www.joblo.com/assets/images/joblo/posters/2020/06/Ava-poster-1.jpg',1),(13,'Gretel & Hansel','2020-01-31','A long time ago in a distant fairy tale countryside, a young girl leads her little brother into a dark wood in desperate search of food and work, only to stumble upon a nexus of terrifying evil.',87,'https://www.joblo.com/assets/images/joblo/posters/2019/09/gretel_and_hansel_poster.jpg',NULL),(14,'Good Boys','2019-08-16','Three 6th grade boys ditch school and embark on an epic journey while carrying accidentally stolen drugs, being hunted by teenage girls, and trying to make their way home in time for a long-awaited party.',90,'https://www.joblo.com/assets/images/joblo/posters/2019/03/good-boys-poster-xl.jpg',NULL),(15,'The Grinch','2018-11-09','A grumpy Grinch (Benedict Cumberbatch) plots to ruin Christmas for the village of Whoville.',85,'https://www.joblo.com/assets/images/oldsite/posters/images/full/GRC_Adv1Sheet_GrinchFace_RGB_2SM.jpg',1),(16,'A Quiet Place &lt;script&gt;alert(\'hi\');&lt;/script&gt;','2018-04-06','In a post-apocalyptic world, a family is forced to live in silence while hiding from monsters with ultra-sensitive hearing.alert(\'hi\');',90,'https://www.joblo.com/assets/images/oldsite/posters/images/full/A-Quiet-Place-poster-1.jpg&lt;script&gt;alert(\'hi\');&lt;/script&gt;',1),(17,'Knives Out','2019-11-27','A detective investigates the death of a patriarch of an eccentric, combative family.',130,'https://www.joblo.com/assets/images/joblo/posters/2019/09/knives-out-final-poster.jpg',NULL),(18,'Midsommar','2019-07-03','A couple travels to Scandinavia to visit a rural hometown\'s fabled Swedish mid-summer festival. What begins as an idyllic retreat quickly devolves into an increasingly violent and bizarre competition at the hands of a pagan cult.',148,'https://www.joblo.com/assets/images/joblo/posters/2019/05/D6DL219W4AEJK1C.jpg',1),(19,'Miss Bala','2019-02-01','Gloria finds a power she never knew she had when she is drawn into a dangerous world of cross-border crime. Surviving will require all of her cunning, inventiveness, and strength. Based on the Spanish-language film.',104,'https://www.joblo.com/assets/images/joblo/posters/2018/12/miss_bala_poster.jpg',NULL);
/*!40000 ALTER TABLE `Movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `People`
--

DROP TABLE IF EXISTS `People`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `People` (
  `PersonID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `MiddleInitial` char(1) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `Deathdate` date DEFAULT NULL,
  PRIMARY KEY (`PersonID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `People`
--

LOCK TABLES `People` WRITE;
/*!40000 ALTER TABLE `People` DISABLE KEYS */;
INSERT INTO `People` VALUES (1,'Rob','Letterman',NULL,NULL,NULL),(2,'Ryan','Reynolds',NULL,NULL,NULL),(3,'Justice','Smith',NULL,NULL,NULL),(4,'Kathryn','Newton',NULL,NULL,NULL),(5,'Josh','Cooley',NULL,NULL,NULL),(6,'Tom','Hanks',NULL,NULL,NULL),(7,'Tim','Allen',NULL,NULL,NULL),(8,'Annie','Potts',NULL,NULL,NULL),(9,'Anna','Boden',NULL,NULL,NULL),(10,'Ryan','Fleck',NULL,NULL,NULL),(11,'Brie','Larson',NULL,NULL,NULL),(12,'Samuel','Jackson','L',NULL,NULL),(13,'Jon','Watts',NULL,NULL,NULL),(14,'Tom','Holland',NULL,NULL,NULL),(15,'Jake','Gyllenhaal',NULL,NULL,NULL);
/*!40000 ALTER TABLE `People` ENABLE KEYS */;
UNLOCK TABLES;

-- --------------------------------------------------------

--
-- Table structure for table `ProductionCompanies`
--

DROP TABLE IF EXISTS `ProductionCompanies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductionCompanies` (
  `CompanyID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`CompanyID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductionCompanies`
--

LOCK TABLES `ProductionCompanies` WRITE;
/*!40000 ALTER TABLE `ProductionCompanies` DISABLE KEYS */;
INSERT INTO `ProductionCompanies` VALUES (1,'A24'),(2,'Warner Bros.');
/*!40000 ALTER TABLE `ProductionCompanies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Roles`
--

DROP TABLE IF EXISTS `Roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Roles` (
  `RoleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(255) NOT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Roles`
--

LOCK TABLES `Roles` WRITE;
/*!40000 ALTER TABLE `Roles` DISABLE KEYS */;
INSERT INTO `Roles` VALUES (1,'Actor'),(2,'Director'),(3,'Writer');
/*!40000 ALTER TABLE `Roles` ENABLE KEYS */;
UNLOCK TABLES;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
