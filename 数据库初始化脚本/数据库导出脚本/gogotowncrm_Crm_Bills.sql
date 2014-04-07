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
-- Table structure for table `Crm_Bills`
--

DROP TABLE IF EXISTS `Crm_Bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Bills` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) NOT NULL COMMENT '商家ID',
  `Customer_ID` int(11) NOT NULL COMMENT '客户ID',
  `Pay_Mothed` int(11) NOT NULL COMMENT '支付方式',
  `Cash` decimal(10,2) DEFAULT NULL COMMENT '刷卡金额',
  `Go_Coin` int(11) DEFAULT NULL COMMENT 'Go币金额',
  `Type` varchar(50) NOT NULL COMMENT '消费类型',
  `Amount` decimal(10,2) DEFAULT NULL COMMENT '消费总金额',
  `Create_Time` bigint(20) NOT NULL COMMENT '消费时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='客户消费记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Bills`
--

LOCK TABLES `Crm_Bills` WRITE;
/*!40000 ALTER TABLE `Crm_Bills` DISABLE KEYS */;
INSERT INTO `Crm_Bills` VALUES (1,1,1,1,10.21,NULL,'衣服',23.00,2,'2014-04-07 05:13:49');
/*!40000 ALTER TABLE `Crm_Bills` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-07 13:19:48
