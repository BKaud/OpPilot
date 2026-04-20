CREATE DATABASE  IF NOT EXISTS `oppilot` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `oppilot`;
-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: oppilot
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account` (
  `account_id` int NOT NULL,
  `acc_name` varchar(100) DEFAULT NULL,
  `acc_tier` varchar(50) DEFAULT 'Tier 1',
  `acc_is_active` tinyint(1) DEFAULT '1',
  `acc_create_date` datetime DEFAULT NULL,
  `acc_primary_color` varchar(7) DEFAULT '#1a8f7a',
  `acc_permissions` int DEFAULT NULL,
  `acc_trained_rides` int DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  KEY `acc_accpermissions_idx` (`acc_permissions`),
  KEY `acc_acctrained_rides_idx` (`acc_trained_rides`),
  KEY `idx_acc_active` (`acc_is_active`),
  CONSTRAINT `acc_accpermissions` FOREIGN KEY (`acc_permissions`) REFERENCES `accpermissions` (`accperms_id`),
  CONSTRAINT `acc_acctrained_rides` FOREIGN KEY (`acc_trained_rides`) REFERENCES `acctrained_rides` (`acctrained_rides_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (101,'M. Torres','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL),(102,'D. Reyes','Tier 2',1,'2026-03-05 06:37:03',NULL,NULL),(103,'A. Kim','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL),(104,'P. Vega','Lead',1,'2026-03-05 06:37:03',NULL,NULL),(105,'S. Okoro','Tier 2',1,'2026-03-05 06:37:03',NULL,NULL),(106,'J. Marsh','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL),(107,'C. Liu','Tier 3',1,'2026-03-05 06:37:03',NULL,NULL),(108,'H. Brown','Tier 2',1,'2026-03-05 06:37:03',NULL,NULL),(109,'T. Nair','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL),(110,'B. Okafor','Lead',1,'2026-03-05 06:37:03',NULL,NULL),(111,'L. Santos','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL),(112,'R. Patel','Tier 2',1,'2026-03-05 06:37:03',NULL,NULL),(113,'K. Nguyen','Lead',1,'2026-03-05 06:37:03',NULL,NULL),(114,'F. Jensen','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL),(115,'W. Diaz','Tier 3',1,'2026-03-05 06:37:03',NULL,NULL),(116,'N. Abebe','Tier 2',1,'2026-03-05 06:37:03',NULL,NULL),(117,'O. Ferreira','Tier 1',1,'2026-03-05 06:37:03',NULL,NULL);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accpermissions`
--

DROP TABLE IF EXISTS `accpermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accpermissions` (
  `accperms_id` int NOT NULL,
  `accperms_createdel_acc` tinyint DEFAULT NULL,
  `accperms_createdel_zone` tinyint DEFAULT NULL,
  `accperms_createdel_ride` tinyint DEFAULT NULL,
  `accperms_createdel_event` tinyint DEFAULT NULL,
  `accperms_call_downtime_gen` tinyint DEFAULT NULL,
  PRIMARY KEY (`accperms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accpermissions`
--

LOCK TABLES `accpermissions` WRITE;
/*!40000 ALTER TABLE `accpermissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `accpermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acctrained_rides`
--

DROP TABLE IF EXISTS `acctrained_rides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acctrained_rides` (
  `acctrained_rides_id` int NOT NULL,
  PRIMARY KEY (`acctrained_rides_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acctrained_rides`
--

LOCK TABLES `acctrained_rides` WRITE;
/*!40000 ALTER TABLE `acctrained_rides` DISABLE KEYS */;
/*!40000 ALTER TABLE `acctrained_rides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `org_acc`
--

DROP TABLE IF EXISTS `org_acc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `org_acc` (
  `org_acc_id` int NOT NULL,
  `org_acc_org_id` int DEFAULT NULL,
  `org_acc_acc_id` int DEFAULT NULL,
  PRIMARY KEY (`org_acc_id`),
  KEY `org_id_idx` (`org_acc_org_id`),
  KEY `acc_id_idx` (`org_acc_acc_id`),
  CONSTRAINT `org_acc_acc_id` FOREIGN KEY (`org_acc_acc_id`) REFERENCES `account` (`account_id`),
  CONSTRAINT `org_acc_org_id` FOREIGN KEY (`org_acc_org_id`) REFERENCES `organization` (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org_acc`
--

LOCK TABLES `org_acc` WRITE;
/*!40000 ALTER TABLE `org_acc` DISABLE KEYS */;
/*!40000 ALTER TABLE `org_acc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `org_permtier`
--

DROP TABLE IF EXISTS `org_permtier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `org_permtier` (
  `org_permtier_id` int NOT NULL,
  `org_permtier_org_id` int DEFAULT NULL,
  `org_permtier_permtier_id` int DEFAULT NULL,
  PRIMARY KEY (`org_permtier_id`),
  KEY `org_id_idx` (`org_permtier_org_id`),
  KEY `permtier_id_idx` (`org_permtier_permtier_id`),
  CONSTRAINT `org_pertier_org_id` FOREIGN KEY (`org_permtier_org_id`) REFERENCES `organization` (`org_id`),
  CONSTRAINT `org_pertier_permtier_id` FOREIGN KEY (`org_permtier_permtier_id`) REFERENCES `permtier` (`permtier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org_permtier`
--

LOCK TABLES `org_permtier` WRITE;
/*!40000 ALTER TABLE `org_permtier` DISABLE KEYS */;
/*!40000 ALTER TABLE `org_permtier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `org_zone`
--

DROP TABLE IF EXISTS `org_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `org_zone` (
  `org_zone_id` int NOT NULL,
  `org_zone_org_id` int DEFAULT NULL,
  `org_zone_zone_id` int DEFAULT NULL,
  PRIMARY KEY (`org_zone_id`),
  KEY `org_zone_org_id_idx` (`org_zone_org_id`),
  KEY `org_zone_zone_id_idx` (`org_zone_zone_id`),
  CONSTRAINT `org_zone_org_id` FOREIGN KEY (`org_zone_org_id`) REFERENCES `organization` (`org_id`),
  CONSTRAINT `org_zone_zone_id` FOREIGN KEY (`org_zone_zone_id`) REFERENCES `zone` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org_zone`
--

LOCK TABLES `org_zone` WRITE;
/*!40000 ALTER TABLE `org_zone` DISABLE KEYS */;
/*!40000 ALTER TABLE `org_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organization` (
  `org_id` int NOT NULL,
  `org_name` varchar(200) DEFAULT NULL,
  `org_owner` int DEFAULT NULL,
  PRIMARY KEY (`org_id`),
  KEY `org_owner_idx` (`org_owner`),
  CONSTRAINT `org_owner` FOREIGN KEY (`org_owner`) REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization`
--

LOCK TABLES `organization` WRITE;
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permtier`
--

DROP TABLE IF EXISTS `permtier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permtier` (
  `permtier_id` int NOT NULL,
  `permrier_createdel_zone` tinyint DEFAULT NULL,
  `permrier_createdel_ride` tinyint DEFAULT NULL,
  `permrier_createdel_event` tinyint DEFAULT NULL,
  `permrier_call_downtime_gen` tinyint DEFAULT NULL,
  `permrier_createdel_acc` tinyint DEFAULT NULL,
  `permrier_created_by` int DEFAULT NULL,
  PRIMARY KEY (`permtier_id`),
  KEY `permrier_created_by_idx` (`permrier_created_by`),
  CONSTRAINT `permrier_created_by` FOREIGN KEY (`permrier_created_by`) REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permtier`
--

LOCK TABLES `permtier` WRITE;
/*!40000 ALTER TABLE `permtier` DISABLE KEYS */;
/*!40000 ALTER TABLE `permtier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `position` (
  `pos_id` int NOT NULL,
  `pos_name` varchar(50) DEFAULT NULL,
  `pos_desc` varchar(400) DEFAULT NULL,
  `pos_order` int DEFAULT '1',
  `pos_created_by` int DEFAULT NULL,
  `pos_create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pos_id`),
  KEY `pos_created_by_idx` (`pos_created_by`),
  KEY `idx_pos_order` (`pos_order`),
  CONSTRAINT `pos_created_by` FOREIGN KEY (`pos_created_by`) REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1,'Station 1','Main station position',1,NULL,'2026-03-05 06:37:03'),(2,'Station 2','Secondary station',2,NULL,'2026-03-05 06:37:03'),(3,'Load Platform','Loading area',3,NULL,'2026-03-05 06:37:03'),(4,'Station 1','Main station',1,NULL,'2026-03-05 06:37:03'),(5,'Dispatch','Dispatch position',2,NULL,'2026-03-05 06:37:03'),(6,'Load','Load position',1,NULL,'2026-03-05 06:37:03'),(7,'Floor','Floor monitoring',1,NULL,'2026-03-05 06:37:03'),(8,'Control','Control booth',2,NULL,'2026-03-05 06:37:03'),(9,'Main','Main operator position',1,NULL,'2026-03-05 06:37:03'),(10,'Platform','Platform position',1,NULL,'2026-03-05 06:37:03'),(11,'Control','Control position',2,NULL,'2026-03-05 06:37:03');
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride`
--

DROP TABLE IF EXISTS `ride`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride` (
  `ride_id` int NOT NULL,
  `ride_name` varchar(200) DEFAULT NULL,
  `ride_status` enum('up','maint','down') DEFAULT NULL,
  `ride_is_placed_on_canvas` tinyint(1) DEFAULT '0',
  `ride_canvas_order` int DEFAULT '0',
  `ride_created_by` int DEFAULT NULL,
  `ride_create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`ride_id`),
  KEY `ride_created_by_idx` (`ride_created_by`),
  KEY `idx_ride_placed` (`ride_is_placed_on_canvas`),
  CONSTRAINT `ride_created_by` FOREIGN KEY (`ride_created_by`) REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride`
--

LOCK TABLES `ride` WRITE;
/*!40000 ALTER TABLE `ride` DISABLE KEYS */;
INSERT INTO `ride` VALUES (1,'Tidal Twist','up',1,1,NULL,'2026-03-05 06:37:03'),(2,'Thunder Mountain','up',1,2,NULL,'2026-03-05 06:37:03'),(3,'Space Coaster','up',1,3,NULL,'2026-03-05 06:37:03'),(4,'Bumper Cars','up',1,4,NULL,'2026-03-05 06:37:03'),(5,'Carousel','up',1,0,NULL,'2026-03-05 06:37:03'),(6,'Drop Tower','up',0,0,NULL,'2026-03-05 06:37:03');
/*!40000 ALTER TABLE `ride` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride_pos`
--

DROP TABLE IF EXISTS `ride_pos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride_pos` (
  `ride_pos_id` int NOT NULL,
  `ride_pos_ride_id` int DEFAULT NULL,
  `ride_pos_pos_id` int DEFAULT NULL,
  `ride_pos_posholder` int DEFAULT NULL,
  PRIMARY KEY (`ride_pos_id`),
  KEY `ride_pos_pos_id_idx` (`ride_pos_pos_id`),
  KEY `ride_pos_ride_id_idx` (`ride_pos_ride_id`),
  KEY `ride_pos_posholder_idx` (`ride_pos_posholder`),
  CONSTRAINT `ride_pos_pos_id` FOREIGN KEY (`ride_pos_pos_id`) REFERENCES `position` (`pos_id`),
  CONSTRAINT `ride_pos_posholder` FOREIGN KEY (`ride_pos_posholder`) REFERENCES `account` (`account_id`),
  CONSTRAINT `ride_pos_ride_id` FOREIGN KEY (`ride_pos_ride_id`) REFERENCES `ride` (`ride_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride_pos`
--

LOCK TABLES `ride_pos` WRITE;
/*!40000 ALTER TABLE `ride_pos` DISABLE KEYS */;
INSERT INTO `ride_pos` VALUES (1,1,1,101),(2,1,2,102),(3,1,3,103),(4,2,4,NULL),(5,2,5,NULL),(6,3,6,NULL),(7,4,7,NULL),(8,4,8,NULL),(9,5,9,103),(10,6,10,NULL),(11,6,11,NULL);
/*!40000 ALTER TABLE `ride_pos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zone` (
  `zone_id` int NOT NULL,
  `zone_name` varchar(100) DEFAULT 'Unnamed Zone',
  `zone_created_by` int DEFAULT NULL,
  `zone_create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`zone_id`),
  KEY `zone_created_by_idx` (`zone_created_by`),
  CONSTRAINT `zone_created_by` FOREIGN KEY (`zone_created_by`) REFERENCES `account` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zone`
--

LOCK TABLES `zone` WRITE;
/*!40000 ALTER TABLE `zone` DISABLE KEYS */;
INSERT INTO `zone` VALUES (1,'Rides Zone 1',NULL,'2026-03-05 06:37:03');
/*!40000 ALTER TABLE `zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zone_ride`
--

DROP TABLE IF EXISTS `zone_ride`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zone_ride` (
  `zone_ride_id` int NOT NULL,
  `zone_ride_zone_id` int DEFAULT NULL,
  `zone_ride_ride_id` int DEFAULT NULL,
  PRIMARY KEY (`zone_ride_id`),
  KEY `zone_ride_zone_id_idx` (`zone_ride_zone_id`),
  KEY `zone_ride_ride_id_idx` (`zone_ride_ride_id`),
  CONSTRAINT `zone_ride_ride_id` FOREIGN KEY (`zone_ride_ride_id`) REFERENCES `ride` (`ride_id`),
  CONSTRAINT `zone_ride_zone_id` FOREIGN KEY (`zone_ride_zone_id`) REFERENCES `zone` (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zone_ride`
--

LOCK TABLES `zone_ride` WRITE;
/*!40000 ALTER TABLE `zone_ride` DISABLE KEYS */;
INSERT INTO `zone_ride` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6);
/*!40000 ALTER TABLE `zone_ride` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-05  3:17:38
