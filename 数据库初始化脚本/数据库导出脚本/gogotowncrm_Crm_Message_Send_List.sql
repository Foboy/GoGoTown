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
-- Table structure for table `Crm_Message_Send_List`
--

DROP TABLE IF EXISTS `Crm_Message_Send_List`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Message_Send_List` (
  `ID` int(11) NOT NULL COMMENT 'ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Message_ID` int(11) DEFAULT NULL COMMENT '信息ID',
  `Title` varchar(64) DEFAULT NULL COMMENT '标题',
  `Content` varchar(512) DEFAULT NULL COMMENT '内容',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '创建时间',
  `Read_Time` bigint(20) DEFAULT NULL COMMENT '打开时间',
  `State` int(11) DEFAULT NULL COMMENT '状态',
  `Type` int(11) DEFAULT NULL COMMENT '类型',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='信息推送列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Message_Send_List`
--

LOCK TABLES `Crm_Message_Send_List` WRITE;
/*!40000 ALTER TABLE `Crm_Message_Send_List` DISABLE KEYS */;
/*!40000 ALTER TABLE `Crm_Message_Send_List` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-04-07 13:19:49
