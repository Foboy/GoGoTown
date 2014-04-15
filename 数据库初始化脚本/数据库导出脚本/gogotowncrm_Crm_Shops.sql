CREATE DATABASE  IF NOT EXISTS `gogotowncrm` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gogotowncrm`;
-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: gogotowncrm
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `Crm_Shops`
--

DROP TABLE IF EXISTS `Crm_Shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Shops` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(50) NOT NULL COMMENT 'name',
  `description` varchar(1000) NOT NULL DEFAULT '' COMMENT 'description',
  `cover_pictureid` int(11) NOT NULL COMMENT 'cover_pictureid',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT 'brand_id',
  `tags` varchar(255) NOT NULL COMMENT 'tags',
  `mobile` char(11) NOT NULL COMMENT 'mobile',
  `telphone` varchar(30) NOT NULL COMMENT 'telphone',
  `city_id` int(11) NOT NULL COMMENT 'city_id',
  `area_id` int(11) NOT NULL COMMENT 'area_id',
  `district_id` int(11) NOT NULL DEFAULT '0' COMMENT 'district_id',
  `street_id` int(11) NOT NULL DEFAULT '0' COMMENT 'street_id',
  `address` varchar(200) NOT NULL COMMENT 'address',
  `longitude` varchar(20) NOT NULL COMMENT 'longitude',
  `latitude` varchar(20) NOT NULL COMMENT 'latitude',
  `booking_num` int(11) NOT NULL COMMENT 'booking_num',
  `view_num` int(11) NOT NULL DEFAULT '0' COMMENT 'view_num',
  `comm_num` int(11) NOT NULL DEFAULT '0' COMMENT 'comm_num',
  `check_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'check_status',
  `add_adminid` int(11) NOT NULL COMMENT 'add_adminid',
  `add_time` int(11) NOT NULL COMMENT 'add_time',
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'flag',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`),
  KEY `city_id` (`city_id`),
  KEY `area_id` (`area_id`),
  KEY `district_id` (`district_id`),
  KEY `street_id` (`street_id`),
  KEY `longitude` (`longitude`),
  KEY `latitude` (`latitude`),
  FULLTEXT KEY `name` (`name`) COMMENT 'FULLTEXT'
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='GoGo商家信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Shops`
--

LOCK TABLES `Crm_Shops` WRITE;
/*!40000 ALTER TABLE `Crm_Shops` DISABLE KEYS */;
INSERT INTO `Crm_Shops` VALUES (1,'gogo商城','1231',1,1,'我','123123','111',1,1,1,1,'12321','123','123',123,123,123,1,123,11114,1,'2014-04-07 05:18:37');
/*!40000 ALTER TABLE `Crm_Shops` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-15 16:06:48
