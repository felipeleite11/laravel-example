-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host:     Database: sie
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Eleições','/list/election','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(2,'Agenda','/list/schedule','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(3,'Atendimentos','/list/appointment','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(4,'Proposições','/list/proposition','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(5,'Visitas','/list/visit','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(6,'Contatos','/list/contact','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(7,'Aniversários de municípios','/list/city_birthdate','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(8,'IDH','/list/idh','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(9,'Câmara Municipal','/list/assembly','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(10,'Dados populacionais','/list/population','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(11,'Dados educacionais','/list/education','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(12,'Prefeituras','/list/prefecture','Consulta','2023-12-28 00:00:00','2023-12-28 00:00:00'),(13,'Agendamentos','/report/schedule','Relatórios','2023-12-28 00:00:00','2023-12-28 00:00:00'),(14,'Proposições','/report/proposition','Relatórios','2023-12-28 00:00:00','2023-12-28 00:00:00');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Admin','2021-12-11 23:25:46','2021-12-11 23:25:46');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles_permissions`
--

DROP TABLE IF EXISTS `profiles_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_permissions_profile_id_foreign` (`profile_id`),
  KEY `profiles_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `profiles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `profiles_permissions_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles_permissions`
--

LOCK TABLES `profiles_permissions` WRITE;
/*!40000 ALTER TABLE `profiles_permissions` DISABLE KEYS */;
INSERT INTO `profiles_permissions` VALUES (1,1,1,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(2,1,2,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(3,1,3,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(4,1,4,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(5,1,5,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(6,1,6,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(7,1,7,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(8,1,8,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(9,1,9,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(10,1,10,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(11,1,11,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(12,1,12,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(13,1,13,'2023-12-28 00:00:00','2023-12-28 00:00:00'),(14,1,14,'2023-12-28 00:00:00','2023-12-28 00:00:00');
/*!40000 ALTER TABLE `profiles_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-28 19:21:09
