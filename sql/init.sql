-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: wir_db
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchants` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('STORE','REWARD') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'STORE',
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `merchants_user_id_foreign` (`user_id`),
  CONSTRAINT `merchants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchants`
--

LOCK TABLES `merchants` WRITE;
/*!40000 ALTER TABLE `merchants` DISABLE KEYS */;
INSERT INTO `merchants` VALUES ('0a6e2200-5796-4a81-b362-0d6024665c31','Toko Merchant','STORE','Sleman, Jogjakarta','54ac5f88-4323-47d3-9d45-7630d1effb51','2020-03-19 05:24:12','2020-03-19 05:24:12'),('7090a10a-a5d5-4bae-8b2f-e75aec729534','Toko Reward','REWARD','Sleman, Jogjakarta','54ac5f88-4323-47d3-9d45-7630d1effb51','2020-03-19 05:27:45','2020-03-19 05:27:45');
/*!40000 ALTER TABLE `merchants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2016_06_01_000001_create_oauth_auth_codes_table',1),(3,'2016_06_01_000002_create_oauth_access_tokens_table',1),(4,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(5,'2016_06_01_000004_create_oauth_clients_table',1),(6,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(7,'2020_03_18_105128_create_merchants_table',1),(8,'2020_03_18_110646_create_products_table',1),(9,'2020_03_18_111206_create_stocks_table',1),(10,'2020_03_18_111449_create_transactions_table',1),(11,'2020_03_18_112253_create_reward_points_table',1),(12,'2020_03_18_112530_create_transaction_details_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('41e1cea574c5eb196c3198271fd0589be07127dd187b44e0d5e5301c6a40f78533974d8a0317b8be','54ac5f88-4323-47d3-9d45-7630d1effb51',1,'API Access','[]',0,'2020-03-19 05:23:42','2020-03-19 05:23:42','2021-03-19 12:23:42'),('62aa6dc75fd517241b9340352602416f0ee49bbd6e52f7d7187ffe48bfeb6db710ed53147806a43f','67e8c6ed-f9cd-4b7c-8c88-853c50ef1037',1,'API Access','[]',0,'2020-03-19 05:27:25','2020-03-19 05:27:25','2021-03-19 12:27:25'),('67137a5a74f682358161a61a02b48bf7e994dd69cd5a6eb0b1e4a986a0c218b451689b7a6c583ba0','54ac5f88-4323-47d3-9d45-7630d1effb51',1,'API Access','[]',0,'2020-03-19 05:30:00','2020-03-19 05:30:00','2021-03-19 12:30:00'),('70698790ee5a471b8bac9df258035fca199adfaa6bb80606077bde7c1027c6a10bbb99df609d6615','565645f5-91c7-4675-94c5-91ce399a59ea',1,'API Access','[]',0,'2020-03-19 05:23:06','2020-03-19 05:23:06','2021-03-19 12:23:06'),('b4527578c97d801c8a4d56041824533cbfe9f93fa51d7fde474c719d553c6676d7ac8263f6a00085','67e8c6ed-f9cd-4b7c-8c88-853c50ef1037',1,'API Access','[]',0,'2020-03-19 06:30:28','2020-03-19 06:30:28','2021-03-19 13:30:28'),('bba5aed801dd5912d279455080b5d5a6a0b29161015be20b3f82428948b11def1cefefe180dde9f7','54ac5f88-4323-47d3-9d45-7630d1effb51',1,'API Access','[]',0,'2020-03-19 05:23:33','2020-03-19 05:23:33','2021-03-19 12:23:33'),('da56d2578e2845bb76dae8b2c4e021160aef6e504620b76cea165ec9e072bf2de86e6cc85cfd620f','565645f5-91c7-4675-94c5-91ce399a59ea',1,'API Access','[]',0,'2020-03-19 05:22:52','2020-03-19 05:22:52','2021-03-19 12:22:52');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','bHqvJMaAGYdtAVRqenJPrMkKSuWnO0ATvINHH8Cy','http://localhost',1,0,0,'2020-03-19 05:22:15','2020-03-19 05:22:15'),(2,NULL,'Laravel Password Grant Client','3Mw8D4QmRkSFXANvUuIArJT7l1rIfUZE6JVSBWaj','http://localhost',0,1,0,'2020-03-19 05:22:15','2020-03-19 05:22:15');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2020-03-19 05:22:15','2020-03-19 05:22:15');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_product` enum('REWARD','NOT_REWARD') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NOT_REWARD',
  `price` double(8,2) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` enum('ARCHIVE','POST') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ARCHIVE',
  `merchant_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_merchant_id_foreign` (`merchant_id`),
  CONSTRAINT `products_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('4881c9c6-4953-4403-b929-33cd0a219889','Totebag Maju Mundu','Lucu','REWARD',20.00,'Kecil','POST','0a6e2200-5796-4a81-b362-0d6024665c31','2020-03-19 05:29:06','2020-03-19 05:29:06'),('bd50760d-3784-4efc-ab72-e99cb538e22a','Hoodie Maju Mundur','Jaket','REWARD',40.00,'M','POST','0a6e2200-5796-4a81-b362-0d6024665c31','2020-03-19 05:29:24','2020-03-19 06:31:43'),('fb505903-33a1-4a38-9cd6-742dd0f70e7f','Baju Koko','Clasic','NOT_REWARD',100000.00,'L','POST','0a6e2200-5796-4a81-b362-0d6024665c31','2020-03-19 05:26:05','2020-03-19 05:30:56');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reward_points`
--

DROP TABLE IF EXISTS `reward_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reward_points` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reward_points_user_id_foreign` (`user_id`),
  CONSTRAINT `reward_points_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reward_points`
--

LOCK TABLES `reward_points` WRITE;
/*!40000 ALTER TABLE `reward_points` DISABLE KEYS */;
INSERT INTO `reward_points` VALUES ('35937086-325e-4fcd-9e2c-cce4a117efb7',0,'67e8c6ed-f9cd-4b7c-8c88-853c50ef1037','2020-03-19 05:23:18','2020-03-19 05:23:18'),('cce9d73f-188b-4019-a75c-995ba253bf80',0,'565645f5-91c7-4675-94c5-91ce399a59ea','2020-03-19 05:22:01','2020-03-19 05:22:01'),('e64c3890-517a-463a-9c33-52b161504ffc',20,'54ac5f88-4323-47d3-9d45-7630d1effb51','2020-03-19 05:23:27','2020-03-19 05:41:38');
/*!40000 ALTER TABLE `reward_points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stocks_product_id_foreign` (`product_id`),
  CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES ('187c30c6-5c15-4dde-a8b3-650bf4385ab9',100,'bd50760d-3784-4efc-ab72-e99cb538e22a','2020-03-19 05:29:24','2020-03-19 05:29:24'),('4faeac08-e95f-4517-9eb0-17617aa7aa0f',96,'fb505903-33a1-4a38-9cd6-742dd0f70e7f','2020-03-19 05:26:05','2020-03-19 05:41:38'),('5db68c35-b0e1-41ac-b6fc-93b24d8eaaca',99,'4881c9c6-4953-4403-b929-33cd0a219889','2020-03-19 05:29:06','2020-03-19 05:39:52');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_details`
--

DROP TABLE IF EXISTS `transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_details` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `transaction_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_product` json NOT NULL,
  `merchant_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_merchant` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_details`
--

LOCK TABLES `transaction_details` WRITE;
/*!40000 ALTER TABLE `transaction_details` DISABLE KEYS */;
INSERT INTO `transaction_details` VALUES ('20914558-1154-4fad-82b4-f06150a8e8bf',1,'7b5a2f75-ab1d-49aa-99d3-b1b02d34e99d','4881c9c6-4953-4403-b929-33cd0a219889','{\"id\": \"4881c9c6-4953-4403-b929-33cd0a219889\", \"name\": \"Totebag Maju Mundu\", \"size\": \"Kecil\", \"type\": \"Lucu\", \"price\": 20, \"stock\": {\"id\": \"5db68c35-b0e1-41ac-b6fc-93b24d8eaaca\", \"stock\": 100, \"created_at\": \"2020-03-19 12:29:06\", \"product_id\": \"4881c9c6-4953-4403-b929-33cd0a219889\", \"updated_at\": \"2020-03-19 12:29:06\"}, \"merchant\": {\"id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"name\": \"Toko Merchant\", \"type\": \"STORE\", \"address\": \"Sleman, Jogjakarta\", \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:24:12\", \"updated_at\": \"2020-03-19 12:24:12\"}, \"created_at\": \"2020-03-19 12:29:06\", \"updated_at\": \"2020-03-19 12:29:06\", \"merchant_id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"post_status\": \"POST\", \"type_of_product\": \"REWARD\"}','0a6e2200-5796-4a81-b362-0d6024665c31','{\"id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"name\": \"Toko Merchant\", \"type\": \"STORE\", \"address\": \"Sleman, Jogjakarta\", \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:24:12\", \"updated_at\": \"2020-03-19 12:24:12\"}','2020-03-19 05:39:52','2020-03-19 05:39:52'),('a3ef32d2-e633-4ed2-ba73-4d65fa8201bc',1,'073cb876-3a48-47f2-a6fb-a66ddcc4fd82','fb505903-33a1-4a38-9cd6-742dd0f70e7f','{\"id\": \"fb505903-33a1-4a38-9cd6-742dd0f70e7f\", \"name\": \"Baju Koko\", \"size\": \"L\", \"type\": \"Clasic\", \"price\": 100000, \"stock\": {\"id\": \"4faeac08-e95f-4517-9eb0-17617aa7aa0f\", \"stock\": 100, \"created_at\": \"2020-03-19 12:26:05\", \"product_id\": \"fb505903-33a1-4a38-9cd6-742dd0f70e7f\", \"updated_at\": \"2020-03-19 12:26:05\"}, \"merchant\": {\"id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"name\": \"Toko Merchant\", \"type\": \"STORE\", \"address\": \"Sleman, Jogjakarta\", \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:24:12\", \"updated_at\": \"2020-03-19 12:24:12\"}, \"created_at\": \"2020-03-19 12:26:05\", \"updated_at\": \"2020-03-19 12:30:56\", \"merchant_id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"post_status\": \"POST\", \"type_of_product\": \"NOT_REWARD\"}','0a6e2200-5796-4a81-b362-0d6024665c31','{\"id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"name\": \"Toko Merchant\", \"type\": \"STORE\", \"address\": \"Sleman, Jogjakarta\", \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:24:12\", \"updated_at\": \"2020-03-19 12:24:12\"}','2020-03-19 05:37:31','2020-03-19 05:37:31'),('b6c8a993-29b0-4c7a-9c66-0483422498fa',3,'23ac98c4-2a99-4b94-888b-a51013b2971a','fb505903-33a1-4a38-9cd6-742dd0f70e7f','{\"id\": \"fb505903-33a1-4a38-9cd6-742dd0f70e7f\", \"name\": \"Baju Koko\", \"size\": \"L\", \"type\": \"Clasic\", \"price\": 100000, \"stock\": {\"id\": \"4faeac08-e95f-4517-9eb0-17617aa7aa0f\", \"stock\": 99, \"created_at\": \"2020-03-19 12:26:05\", \"product_id\": \"fb505903-33a1-4a38-9cd6-742dd0f70e7f\", \"updated_at\": \"2020-03-19 12:37:31\"}, \"merchant\": {\"id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"name\": \"Toko Merchant\", \"type\": \"STORE\", \"address\": \"Sleman, Jogjakarta\", \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:24:12\", \"updated_at\": \"2020-03-19 12:24:12\"}, \"created_at\": \"2020-03-19 12:26:05\", \"updated_at\": \"2020-03-19 12:30:56\", \"merchant_id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"post_status\": \"POST\", \"type_of_product\": \"NOT_REWARD\"}','0a6e2200-5796-4a81-b362-0d6024665c31','{\"id\": \"0a6e2200-5796-4a81-b362-0d6024665c31\", \"name\": \"Toko Merchant\", \"type\": \"STORE\", \"address\": \"Sleman, Jogjakarta\", \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:24:12\", \"updated_at\": \"2020-03-19 12:24:12\"}','2020-03-19 05:41:38','2020-03-19 05:41:38');
/*!40000 ALTER TABLE `transaction_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('GET_PAID','WAITING_FOR_PAYMENT') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WAITING_FOR_PAYMENT',
  `buyer_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_buyer` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES ('073cb876-3a48-47f2-a6fb-a66ddcc4fd82','A20200301','GET_PAID','54ac5f88-4323-47d3-9d45-7630d1effb51','{\"id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"name\": \"merchant\", \"email\": \"merchant@gmail.com\", \"created_at\": \"2020-03-19 12:23:27\", \"updated_at\": \"2020-03-19 12:23:27\", \"rewardpoint\": {\"id\": \"e64c3890-517a-463a-9c33-52b161504ffc\", \"points\": 0, \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:23:27\", \"updated_at\": \"2020-03-19 12:23:27\"}}','2020-03-19 05:37:31','2020-03-19 05:37:31'),('23ac98c4-2a99-4b94-888b-a51013b2971a','A20200303','GET_PAID','54ac5f88-4323-47d3-9d45-7630d1effb51','{\"id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"name\": \"merchant\", \"email\": \"merchant@gmail.com\", \"created_at\": \"2020-03-19 12:23:27\", \"updated_at\": \"2020-03-19 12:23:27\", \"rewardpoint\": {\"id\": \"e64c3890-517a-463a-9c33-52b161504ffc\", \"points\": 0, \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:23:27\", \"updated_at\": \"2020-03-19 12:39:52\"}}','2020-03-19 05:41:38','2020-03-19 05:41:38'),('7b5a2f75-ab1d-49aa-99d3-b1b02d34e99d','A20200302','GET_PAID','54ac5f88-4323-47d3-9d45-7630d1effb51','{\"id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"name\": \"merchant\", \"email\": \"merchant@gmail.com\", \"created_at\": \"2020-03-19 12:23:27\", \"updated_at\": \"2020-03-19 12:23:27\", \"rewardpoint\": {\"id\": \"e64c3890-517a-463a-9c33-52b161504ffc\", \"points\": 20, \"user_id\": \"54ac5f88-4323-47d3-9d45-7630d1effb51\", \"created_at\": \"2020-03-19 12:23:27\", \"updated_at\": \"2020-03-19 12:37:31\"}}','2020-03-19 05:39:52','2020-03-19 05:39:52');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('54ac5f88-4323-47d3-9d45-7630d1effb51','merchant','merchant@gmail.com','$2y$10$cxbl6Qc4KQBNuKIeCi4i.OuXle5dvl.t2fehkWh.7wh8a/Pfic87u',NULL,'2020-03-19 05:23:27','2020-03-19 05:23:27'),('565645f5-91c7-4675-94c5-91ce399a59ea','customer','customer@gmail.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','mpNu5QsVds','2020-03-19 05:22:01','2020-03-19 05:22:01'),('67e8c6ed-f9cd-4b7c-8c88-853c50ef1037','reward','reward@gmail.com','$2y$10$m.I2GsXrUVkqajG45ymET.Frb3665V2AV/uKw8Ks3f4SQGRW7NXF.',NULL,'2020-03-19 05:23:18','2020-03-19 05:23:18');
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

-- Dump completed on 2020-03-19 21:30:31
