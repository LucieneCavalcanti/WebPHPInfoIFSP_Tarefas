-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: bdprojeto
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `tbusuarios`
--

DROP TABLE IF EXISTS `tbusuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbusuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `datacadastro` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `tipo` varchar(20) NOT NULL DEFAULT 'Comum',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuarios`
--

LOCK TABLES `tbusuarios` WRITE;
/*!40000 ALTER TABLE `tbusuarios` DISABLE KEYS */;
INSERT INTO `tbusuarios` VALUES (7,'Luciene','professor@aldeiaedutec.com.br','123','2025-04-30 19:21:40',2,'Comum'),(8,'Juan Domenick','luciene@asdf','45','2025-04-30 19:21:58',1,'Comum'),(10,'teste2','asdff@asdfsaf','asfasf','2025-04-30 19:29:06',1,'Comum'),(13,'Ronaldo Fenomeno','rrr@asdf','86768','2025-04-30 19:36:07',1,'Comum'),(15,'adadadasdo Fenomenoas f','asf@asf','err','2025-04-30 19:49:35',1,'Comum'),(17,'Marcelo ATUAL','ATUAL@MAIL','321','2025-04-30 19:59:03',2,'Administrador'),(18,'aaaaan Domenick sdfsaf','asf@asf','234234','2025-04-30 20:01:42',1,'Comum'),(19,'Juan werwerwe sdfsaf','asf@asf','234234','2025-04-30 20:02:27',1,'Comum');
/*!40000 ALTER TABLE `tbusuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-12 19:57:38
