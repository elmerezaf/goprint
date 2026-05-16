-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: goprint_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,1,'陳大明','91234567','香港中環花園道1號',1,'2026-05-09 05:28:20','2026-05-09 05:28:20'),(2,1,'李小明','98765432','九龍旺角彌敦道100號',0,'2026-05-09 05:28:20','2026-05-09 05:28:20');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_desc` text DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='印刷產品分類';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'商務印刷','名片、單張、畫冊、書刊','2026-05-09 19:17:20'),(2,'包裝設計','禮盒、包裝袋、標籤、彩盒','2026-05-09 19:17:20'),(3,'宣傳單張印刷','傳單、摺頁、單張等各類宣傳印刷品','2026-05-11 14:30:49'),(4,'書本印刷','書刊、雜誌、畫冊、說明書等書本類印刷','2026-05-11 14:30:49'),(5,'貼紙印刷','各類不乾膠貼紙、透明貼紙、標籤印刷','2026-05-11 14:30:49'),(6,'海報印刷','各類海報、展板、橫額等大幅面印刷','2026-05-11 14:30:49'),(7,'信封文儀','信封、信紙、公文袋等辦公室文儀印刷','2026-05-11 14:30:49'),(8,'橫額展架','戶外橫額、易拉架、展板等展示器材印刷','2026-05-11 14:30:49');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_05_02_130455_create_orders_table',1),(6,'2026_05_02_130500_add_order_columns',1),(7,'2026_05_06_081553_add_status_column_to_orders_table',1),(8,'2026_05_06_082650_add_role_to_users_table',1),(9,'2026_05_07_093239_create_addresses_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `printing_side` varchar(50) DEFAULT NULL,
  `binding` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT 0.00,
  `file` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'Chan Tai Ming','91234567','test@example.com','Business Cards','Standard','Premium',NULL,NULL,100,248.00,NULL,'completed','2026-05-08 02:30:00','2026-05-09 09:48:43'),(2,1,'Li Siu Ming','98765432','test@example.com','Promotional Poster','A3','Glossy',NULL,NULL,50,598.00,NULL,'processing','2026-05-08 06:20:00','2026-05-09 09:48:43'),(3,1,'Chan Tai Ming','91234567','test@example.com','Brochure Printing','A4','Premium',NULL,NULL,30,150.00,NULL,'pending','2026-05-09 09:48:43','2026-05-09 09:48:43'),(4,NULL,'test','60987777','test@qq.com','A4三摺頁','A5','300g銅版','單面','膠裝',100,350.40,'1778651870_212.png','cancelled','2026-05-12 21:57:51','2026-05-12 22:58:08');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `pro_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `pro_name` varchar(100) NOT NULL,
  `pro_price` decimal(10,2) NOT NULL,
  `pro_stock` int(11) DEFAULT 999,
  `pro_desc` text DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp(),
  `pro_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='印刷產品列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,1,'高檔名片印刷',98.00,999,'300g銅版紙 雙面彩色印刷','2026-05-09 19:17:20','business-card_1.png'),(2,1,'A4宣傳單打印',150.00,999,'1000張 高清快速印刷','2026-05-09 19:17:20','flyer_1.png'),(3,2,'產品包裝盒',299.00,999,'定制瓦楞紙包裝 免費設計','2026-05-09 19:17:20','brochure_1.png'),(4,1,'A4彩色傳單',200.00,1000,'157g銅版紙，全彩色印刷，香港即日交貨','2026-05-09 19:17:20','flyer_2.png'),(5,2,'企業名片',150.00,500,'300g銅版紙，雙面印刷，免費設計','2026-05-09 19:17:20','business-card_2.png'),(6,1,'商務名片套裝',188.00,999,'500張名片，300g銅版紙，專版UV印刷，免費設計','2026-05-11 14:30:49','business-card_2.png'),(7,1,'畫冊印刷',350.00,500,'騎馬釘裝訂，全彩色印刷，200g啞粉紙','2026-05-11 14:30:49','brochure_1.png'),(8,1,'書刊雜誌印刷',280.00,500,'A4尺寸，封面過膠，內頁80g書紙','2026-05-11 14:30:49','poster_1.png'),(9,2,'禮品包裝盒',399.00,300,'特殊紙質，燙金Logo，可選多種材質','2026-05-11 14:30:49','gop1 (3).png'),(10,2,'手提紙袋',250.00,800,'200g白卡紙，彩色印刷，可加繩','2026-05-11 14:30:49','gop1 (4).png'),(11,2,'彩盒印刷',320.00,400,'瓦楞彩盒，UV印刷，農曆新年前優惠','2026-05-11 14:30:49','gop1 (5).png'),(12,3,'A5宣傳單張',120.00,999,'1000張，157g銅版紙，雙面彩色印刷','2026-05-11 14:30:49','gop1 (8).png'),(13,3,'A4三摺頁',180.00,999,'200g啞粉紙，風琴摺，適合產品介紹','2026-05-11 14:30:49','gop1 (9).png'),(14,3,'雙面傳單',90.00,999,'A5尺寸，128g銅版紙，特價快速印刷','2026-05-11 14:30:49','gop1 (10).png'),(15,3,'A4單張',150.00,999,'1000張，157g銅版紙，專業色彩管理','2026-05-11 14:30:50','gop1 (14).png'),(16,4,'膠裝書刊',450.00,300,'A5尺寸，封面彩色內頁黑白，專業膠裝','2026-05-11 14:30:50','gop1 (15).png'),(17,4,'精裝書',600.00,200,'硬皮精裝，全彩色印刷，書脊燙金','2026-05-11 14:30:50','gop1 (20).png'),(18,4,'騎馬釘小冊子',220.00,500,'A4騎馬釘，8-16頁，封面過膠','2026-05-11 14:30:50','poster_2.png'),(19,4,'說明書印刷',180.00,800,'A5騎馬釘，黑白印刷，批量優惠','2026-05-11 14:30:50','poster_3.png'),(20,5,'圓形貼紙',80.00,999,'1000張，防水PVC，可選多種尺寸','2026-05-11 14:30:50','poster_4.png'),(21,5,'條形碼標籤',120.00,999,'不乾膠，白底黑字，可連號','2026-05-11 14:30:50','banner_1.png'),(22,5,'透明貼紙',150.00,999,'全透明PVC，彩色印刷，防水防曬','2026-05-11 14:30:50','service-affordable.jpg'),(23,5,'啞面貼紙',110.00,999,'啞面不乾膠，高級質感，適合Logo','2026-05-11 14:30:50','service-design.jpg'),(24,6,'A2海報',50.00,999,'200g啞粉紙，單面印刷，高清彩色','2026-05-11 14:30:50','hero-banner-business-cards.jpg'),(25,6,'A1戶外海報',80.00,999,'PP防水紙，彩色印刷，抗紫外線','2026-05-11 14:30:50','hero-banner-fast-delivery.jpg'),(26,6,'Foamboard展板',120.00,200,'KT板裱貼，邊緣包邊，可加支架','2026-05-11 14:30:50','hero-banner-flyers.jpg'),(27,6,'A3海報',35.00,999,'200g銅版紙，單面印刷，最快當日可取','2026-05-11 14:30:50','hero-banner-quality.jpg'),(28,7,'彩色信封',200.00,999,'DL尺寸，1000個，彩色印刷','2026-05-11 14:30:50','service-eco.jpg'),(29,7,'信紙本',160.00,600,'A4尺寸，100頁/本，80g書紙','2026-05-11 14:30:50','service-fast-delivery.jpg'),(30,7,'公文袋',250.00,800,'牛皮紙，A4尺寸，可印公司Logo','2026-05-11 14:30:50','service-quality.jpg'),(31,7,'長形信封',180.00,999,'9號長形信封，1000個','2026-05-11 14:30:50','service-support.jpg'),(32,8,'戶外橫額',300.00,200,'防水帆布，熱升華印刷，包繩及袋','2026-05-11 14:30:50','banner_1.png'),(33,8,'X架易拉架',180.00,150,'防水PP，彩色印刷，包便攜支架','2026-05-11 14:30:50','poster_1.png'),(34,8,'背景板噴畫',500.00,100,'戶外噴畫，包鋁架及安裝，適合活動','2026-05-11 14:30:50','poster_2.png'),(35,8,'掛畫海報',220.00,200,'防水布料，上下掛軸，可摺疊收藏','2026-05-11 14:30:50','poster_3.png');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','elmerezaf@gmail.com',NULL,'$2y$10$7TVPDWToSOr7Qgt9/M/pJObeoOnAoH3QK6q3sg/ObXubTvbPsOJ6C','admin',NULL,'2026-05-09 05:28:20','2026-05-09 05:28:20'),(2,'测试用户','test@example.com',NULL,'$2y$10$7TVPDWToSOr7Qgt9/M/pJObeoOnAoH3QK6q3sg/ObXubTvbPsOJ6C','user',NULL,'2026-05-09 05:28:20','2026-05-09 05:28:20');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-13 16:01:05
