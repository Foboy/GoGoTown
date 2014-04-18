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
-- Table structure for table `Crm_Gogo_Customers`
--

DROP TABLE IF EXISTS `Crm_Gogo_Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Gogo_Customers` (
  `id` int(11) NOT NULL COMMENT 'id',
  `mobile` char(11) NOT NULL COMMENT 'mobile',
  `email` varchar(50) NOT NULL COMMENT 'email',
  `password` char(32) NOT NULL COMMENT 'password',
  `username` varchar(30) NOT NULL COMMENT 'username',
  `nickname` varchar(10) NOT NULL COMMENT 'nickname',
  `sex` tinyint(1) NOT NULL DEFAULT '3' COMMENT 'sex',
  `salt` char(6) NOT NULL COMMENT 'salt',
  `reg_ip` varchar(25) NOT NULL COMMENT 'reg_ip',
  `reg_time` int(11) NOT NULL COMMENT 'reg_time',
  `last_login_ip` varchar(25) NOT NULL COMMENT 'last_login_ip',
  `last_login_time` int(11) NOT NULL COMMENT 'last_login_time',
  `error_login_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'error_login_num',
  `address_num` tinyint(10) NOT NULL DEFAULT '0' COMMENT 'address_num',
  `email_approve` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email_approve',
  `mobile_approve` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile_approve',
  `headimg` varchar(30) NOT NULL COMMENT 'headimg',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'status',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='GoGo客户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Gogo_Customers`
--

LOCK TABLES `Crm_Gogo_Customers` WRITE;
/*!40000 ALTER TABLE `Crm_Gogo_Customers` DISABLE KEYS */;
INSERT INTO `Crm_Gogo_Customers` VALUES (1,'123','1','1','1','1',1,'1','1',1,'1',1,1,1,1,1,'1',1,'2014-04-07 05:16:53'),(24,'24','24','24','24','1',11,'1','1',1,'1',1,1,1,1,1,'1',1,'2014-04-14 05:26:12'),(30,'30','30','30','30','30',30,'30','30',30,'1',1,1,1,1,1,'1',1,'2014-04-14 05:26:12');
/*!40000 ALTER TABLE `Crm_Gogo_Customers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-17 15:19:31
