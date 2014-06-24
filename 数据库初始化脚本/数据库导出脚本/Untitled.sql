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
  `app_user_id` int(11) NOT NULL COMMENT '收银员ID',
  `lakala_order_no` varchar(45) NOT NULL COMMENT '拉卡拉订单编号',
  `go_coin_back` int(11) DEFAULT NULL,
  `go_coin_back_extra` float DEFAULT NULL,
  `go_coin_spend_extra` float DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='客户消费记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Bills`
--

LOCK TABLES `Crm_Bills` WRITE;
/*!40000 ALTER TABLE `Crm_Bills` DISABLE KEYS */;
INSERT INTO `Crm_Bills` VALUES (1,1,24,1,10.21,NULL,'衣服',23.00,1396972800,'2014-04-16 03:25:28',0,'gg11111111111',NULL,NULL,NULL),(2,2,1,2,NULL,44,'裤子',44.30,1397291200,'2014-04-16 03:25:28',0,'gg12345678902',NULL,NULL,NULL),(3,1,30,1,561.00,NULL,'3C',23.00,1397490200,'2014-04-16 03:25:28',0,'gg98765432109',NULL,NULL,NULL),(4,1,2,1,0.00,235,'1',234.87,1397804218,'2014-04-18 06:56:58',11,'1397804218',NULL,NULL,NULL),(5,1,2,1,0.00,235,'2',234.87,1397804353,'2014-04-18 06:59:13',11,'1397804353',NULL,NULL,NULL),(6,1,2,1,0.00,235,'1',100.00,1397804218,'2014-04-18 06:56:58',10,'1397804218',NULL,NULL,NULL);
/*!40000 ALTER TABLE `Crm_Bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Customers`
--

DROP TABLE IF EXISTS `Crm_Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Customers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Name` varchar(16) DEFAULT NULL COMMENT '姓名',
  `Sex` int(11) DEFAULT NULL COMMENT '性别',
  `Phone` varchar(16) DEFAULT NULL COMMENT '手机',
  `Birthady` bigint(20) DEFAULT NULL COMMENT '出生日期',
  `Remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='商家客户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Customers`
--

LOCK TABLES `Crm_Customers` WRITE;
/*!40000 ALTER TABLE `Crm_Customers` DISABLE KEYS */;
INSERT INTO `Crm_Customers` VALUES (1,'自由客户',1,'1',1,'是的范德萨发','2014-04-07 05:16:19'),(30,'yc2',1,'18608046444',1396915200,'稍等','2014-04-09 15:15:24'),(22,'ee',1,'13558871855',NULL,'123','2014-04-07 05:16:19'),(23,'第三方',1,'13558871877',12,'地方','2014-04-07 05:16:19'),(24,'地方',1,'13558871877',11,'反倒是','2014-04-07 05:16:19'),(25,'D大调',1,'13882014677',32,'第三方','2014-04-07 05:16:19'),(26,'test',1,'13448871866',1397088000,'test','2014-04-08 15:13:10'),(27,'yc',2,'18608046466',1396483200,'水电费发生大幅度发','2014-04-08 15:14:41'),(31,'yyyy',1,'13811111111',1277510400,'111','2014-06-24 07:31:57');
/*!40000 ALTER TABLE `Crm_Customers` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `Crm_Gogo_Customers` VALUES (1,'123','1','1','1','1',1,'1','1',1,'1',1,1,1,1,1,'1',1,'2014-04-07 05:16:53'),(24,'24','24','24','24','1',11,'1','1',1,'1',1,1,1,1,1,'1',1,'2014-04-14 05:26:12'),(30,'30','30','30','30','30',30,'30','30',30,'1',1,1,1,1,1,'1',1,'2014-04-14 05:26:12'),(4,'13885035477','1','1','张三','1',1,'1','1',1,'1',1,1,1,1,1,'1',1,'2014-04-18 06:31:15'),(5,'18689874458','1','1','李四','1',1,'1','1',1,'1',1,1,1,1,1,'1',1,'2014-04-18 06:31:34'),(2,'13550066447','','66b4da17a62cc867a5b6fbea8b616b41','Mr.Right','Mr.Right',1,'4b11b2','192.168.0.55',1395135968,'192.168.0.55',1395801520,0,0,0,1,'',1,'2014-04-11 13:44:38');
/*!40000 ALTER TABLE `Crm_Gogo_Customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Logs`
--

DROP TABLE IF EXISTS `Crm_Logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Logs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Type` int(11) DEFAULT NULL COMMENT '类型',
  `Content` varchar(128) DEFAULT NULL COMMENT '类容',
  `Target` varchar(32) DEFAULT NULL COMMENT '对象',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Logs`
--

LOCK TABLES `Crm_Logs` WRITE;
/*!40000 ALTER TABLE `Crm_Logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Crm_Logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Message_Send_List`
--

DROP TABLE IF EXISTS `Crm_Message_Send_List`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Message_Send_List` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
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
  `pic_id` bigint(20) DEFAULT NULL,
  `pic_url` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='信息推送列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Message_Send_List`
--

LOCK TABLES `Crm_Message_Send_List` WRITE;
/*!40000 ALTER TABLE `Crm_Message_Send_List` DISABLE KEYS */;
INSERT INTO `Crm_Message_Send_List` VALUES (17,4,1,50,'test','test',1397802898,NULL,1,1,'2014-04-18 06:34:58',NULL,NULL),(16,5,1,49,'test2222','22222',1396942186,NULL,1,1,'2014-04-08 07:29:46',NULL,NULL),(15,4,1,48,'的积分等级','的解放军',1396942022,NULL,1,1,'2014-04-08 07:27:02',NULL,NULL),(14,2,1,47,'testyc','testyc',1396941825,NULL,1,1,'2014-04-08 07:23:45',NULL,NULL),(13,25,1,47,'testyc','testyc',1396941825,NULL,1,1,'2014-04-08 07:23:45',NULL,NULL);
/*!40000 ALTER TABLE `Crm_Message_Send_List` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Messages`
--

DROP TABLE IF EXISTS `Crm_Messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Type` int(11) DEFAULT NULL COMMENT '信息类型',
  `Title` varchar(64) DEFAULT NULL COMMENT '标题',
  `Content` varchar(512) DEFAULT NULL COMMENT '信息类容',
  `Send_Time` bigint(20) DEFAULT NULL COMMENT '发送时间',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '创建时间',
  `State` int(11) DEFAULT NULL COMMENT '发送状态',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  `pic_id` bigint(20) DEFAULT NULL,
  `pic_url` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='商户推送信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Messages`
--

LOCK TABLES `Crm_Messages` WRITE;
/*!40000 ALTER TABLE `Crm_Messages` DISABLE KEYS */;
INSERT INTO `Crm_Messages` VALUES (50,1,1,'test','test',1397802898,1397802898,1,'2014-04-18 06:34:58',NULL,NULL),(49,1,1,'test2222','22222',1396942186,1396942186,1,'2014-04-08 07:29:46',NULL,NULL),(48,1,1,'的积分等级','的解放军',1396942022,1396942022,1,'2014-04-08 07:27:02',NULL,NULL),(47,1,1,'testyc','testyc',1396941825,1396941825,1,'2014-04-08 07:23:45',NULL,NULL),(51,1,1,'对方答复','对方答复',1403603334,1403603334,1,'2014-06-24 09:48:54',8596280565,'');
/*!40000 ALTER TABLE `Crm_Messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_PMerchant_Customers`
--

DROP TABLE IF EXISTS `Crm_PMerchant_Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_PMerchant_Customers` (
  `ID` int(11) NOT NULL COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `Times` int(11) DEFAULT NULL COMMENT '商圈出现次数',
  `Last_Time` bigint(20) DEFAULT NULL COMMENT '最后出现时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈公海客户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_PMerchant_Customers`
--

LOCK TABLES `Crm_PMerchant_Customers` WRITE;
/*!40000 ALTER TABLE `Crm_PMerchant_Customers` DISABLE KEYS */;
/*!40000 ALTER TABLE `Crm_PMerchant_Customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_PShop_Customers`
--

DROP TABLE IF EXISTS `Crm_PShop_Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_PShop_Customers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `Times` int(11) DEFAULT NULL COMMENT '商圈出现次数',
  `Last_Time` bigint(20) DEFAULT NULL COMMENT '最后出现时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  `Is_Chance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商家公海客户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_PShop_Customers`
--

LOCK TABLES `Crm_PShop_Customers` WRITE;
/*!40000 ALTER TABLE `Crm_PShop_Customers` DISABLE KEYS */;
INSERT INTO `Crm_PShop_Customers` VALUES (1,1,1,2,123213,'2014-06-24 05:40:40',1),(2,1,30,3,123213,'2014-06-24 05:31:12',1);
/*!40000 ALTER TABLE `Crm_PShop_Customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Rank`
--

DROP TABLE IF EXISTS `Crm_Rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Rank` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `From_Type` int(11) DEFAULT NULL COMMENT '客户来源',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '用户ID',
  `Rank_ID` int(11) DEFAULT NULL COMMENT '用户等级',
  `Begin_Time` bigint(20) DEFAULT NULL COMMENT '生效时间',
  `End_Time` bigint(20) DEFAULT NULL COMMENT '终止时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='客户等级';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Rank`
--

LOCK TABLES `Crm_Rank` WRITE;
/*!40000 ALTER TABLE `Crm_Rank` DISABLE KEYS */;
INSERT INTO `Crm_Rank` VALUES (3,2,1,4,1,NULL,NULL,'2014-04-18 06:30:40'),(6,1,1,31,2,NULL,NULL,'2014-06-24 07:31:57'),(1,2,2,4,1,11,NULL,'2014-04-23 11:38:29');
/*!40000 ALTER TABLE `Crm_Rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Rank_Set`
--

DROP TABLE IF EXISTS `Crm_Rank_Set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Rank_Set` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Rank` int(11) DEFAULT NULL COMMENT '等级',
  `Name` varchar(16) DEFAULT NULL COMMENT '名称',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Remark` varchar(128) DEFAULT NULL COMMENT '备注',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='客户等级设定';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Rank_Set`
--

LOCK TABLES `Crm_Rank_Set` WRITE;
/*!40000 ALTER TABLE `Crm_Rank_Set` DISABLE KEYS */;
INSERT INTO `Crm_Rank_Set` VALUES (1,1,'白金',1,'','2014-06-24 07:29:30'),(2,1,'黄金',1,NULL,'2014-04-08 15:10:24'),(3,1,'钻石',2,NULL,'2014-04-23 11:38:07'),(5,0,'test',1,'','2014-06-24 07:08:30');
/*!40000 ALTER TABLE `Crm_Rank_Set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Shop_Customers`
--

DROP TABLE IF EXISTS `Crm_Shop_Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Shop_Customers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `From_Type` int(11) DEFAULT NULL COMMENT '客户来源',
  `Type` int(11) DEFAULT NULL COMMENT '客户类型',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '添加时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='商家客户关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Shop_Customers`
--

LOCK TABLES `Crm_Shop_Customers` WRITE;
/*!40000 ALTER TABLE `Crm_Shop_Customers` DISABLE KEYS */;
INSERT INTO `Crm_Shop_Customers` VALUES (17,1,30,2,2,1397806808,'2014-04-18 07:40:08'),(15,1,31,1,4,1397469383,'2014-04-14 09:56:23'),(3,1,1,2,2,1396322520,'2014-06-24 05:40:24'),(4,1,4,2,3,1396452520,'2014-04-07 05:18:29'),(5,1,5,2,3,1397352520,'2014-04-07 05:18:29'),(6,1,1,1,4,1396452520,'2014-04-07 05:18:29'),(8,2,4,2,3,1397453764,'2014-04-23 11:37:16'),(9,1,25,1,4,1396603691,'2014-04-07 05:18:29'),(10,1,26,1,4,1396969990,'2014-04-08 15:13:10'),(11,1,27,1,4,1396970081,'2014-04-08 15:14:41');
/*!40000 ALTER TABLE `Crm_Shop_Customers` ENABLE KEYS */;
UNLOCK TABLES;

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
  `pos_rate` decimal(10,2) DEFAULT '0.00',
  `lakala_rate` decimal(10,2) DEFAULT '0.00',
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
INSERT INTO `Crm_Shops` VALUES (1,'gogo商城','1231',1,1,'我','123123','111',1,1,1,1,'12321','123','123',123,123,123,1,123,139749,1,'2014-06-18 10:28:31',33.00,34.00);
/*!40000 ALTER TABLE `Crm_Shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Users`
--

DROP TABLE IF EXISTS `Crm_Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Name` varchar(64) DEFAULT NULL COMMENT '商家名',
  `Shop_ID` int(11) NOT NULL COMMENT '商家ID',
  `Type` int(11) NOT NULL COMMENT '账户类型',
  `Account` varchar(32) NOT NULL COMMENT '账户名',
  `Password` varchar(64) NOT NULL COMMENT '登陆密码',
  `Last_Login` bigint(20) DEFAULT NULL COMMENT '最近登陆时间',
  `State` int(11) NOT NULL COMMENT '账户状态',
  `Faileds` int(11) DEFAULT NULL COMMENT '登陆失败次数',
  `Last_Failed` bigint(20) DEFAULT NULL COMMENT '登陆失败时间',
  `Token` varchar(64) DEFAULT NULL COMMENT 'Token',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '添加时间',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='系统用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Users`
--

LOCK TABLES `Crm_Users` WRITE;
/*!40000 ALTER TABLE `Crm_Users` DISABLE KEYS */;
INSERT INTO `Crm_Users` VALUES (3,'dfddd',1,1,'test','$2y$10$wKS2f6kCMoeaQrxBgQR8NOuuussFZE2/zbSfZV1hJR9aT/6.yPTHe',1403587832,2,NULL,1403253264,NULL,1396352513,'2014-06-24 05:30:32'),(4,'管理员',1,4,'test1','$2y$10$eetDqkfTe0Deg.0ZMVrW1esZTBxmxUjKDJPfjxvaOUlb38yXCNp46',1403531596,2,NULL,1403255614,NULL,1396784856,'2014-06-23 13:53:16'),(5,NULL,1,3,'test2','$2y$10$HZvIvgqDD0Eg1/hvXjnxXOnU7y1YVVE6rNJyVD92R8MkRFa45XDv2',NULL,1,NULL,NULL,NULL,1396784884,'2014-04-07 05:18:44'),(6,'sdf的积分等级',1,3,'test3','$2y$10$I3jkcWzoNThKapc2nXAJqeJsQt5q4ozf2IclQ/gmmVfscLPSJAqOO',NULL,1,NULL,1396945838,NULL,1396789264,'2014-04-08 08:30:38'),(7,'的解放军',1,3,'test5','$2y$10$w0q8LOnl5iFw13Qw.5FcX.2D0VTzuAKzxP3X9eMSPeunrVI9JI0Qe',NULL,1,NULL,NULL,NULL,1396865369,'2014-04-07 10:09:29'),(8,'dfjdjf',1,2,'test6','$2y$10$wQ6JI76XiySZncPtjW8N7e4ql8WFwDEJEBab7OQzdxnYOklFIxb36',NULL,1,NULL,NULL,NULL,1396865401,'2014-04-07 10:10:01'),(9,'111',1,3,'test7','$2y$10$BC0n9PyCr.Vlb2lLc4OTO.J.o/p2tCY2lkl73HPjVuFzqdS2pVSWK',NULL,2,NULL,NULL,NULL,1396865542,'2014-04-07 10:12:54'),(10,'cz1',1,2,'cz1','$2y$10$4gVpt8cBqxtqTE0cU.Bhteom17Rl.SE0DEHrsqpz.F6ZyOQuWCHSS',1396949431,2,NULL,1396949217,NULL,1396947537,'2014-04-29 04:44:03'),(11,'陈锐',1,2,'cr2013','$2y$10$vG3hVz.UyS2oTqoF/5KdwOMSRmcYfwrUv71IzBmSSFsB.coUVbcyq',1397805343,2,NULL,NULL,NULL,1397803923,'2014-04-18 07:15:43'),(12,'testadmin',1,5,'testadmin','$2y$10$cXEiwu8hVrbJex/tcoFVo.HUbvFgeSCQtFjEqUqfBulSyOUJ/u9Xe',1403253481,2,NULL,1403253476,NULL,1403087275,'2014-06-20 08:38:01'),(13,'testadmin1',1,5,'testadmin1','$2y$10$0wqqBNs8PXgEUTTdQLolMONJ/lVnuoH2aGLJ9zEPUEYhog0lCos2u',NULL,1,NULL,NULL,NULL,1403246213,'2014-06-20 08:19:48'),(14,'testadmin2',1,5,'testadmin2','$2y$10$UHx9zZ0QWoOp.WvZBQ/ND.oECdblasZmcRI.5Iid1sMqPDl3nBZxG',1403252880,1,NULL,1403253055,NULL,1403246236,'2014-06-20 08:30:55'),(15,'testadmin3',1,5,'testadmin3','$2y$10$MfGDUqaZ1SkpS0QeTD782O6c35yAHxr6tCy6gwerpfNHI.cDYP.uK',NULL,1,NULL,NULL,NULL,1403246251,'2014-06-20 08:19:55');
/*!40000 ALTER TABLE `Crm_Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_Validation`
--

DROP TABLE IF EXISTS `Crm_Validation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_Validation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Code` varchar(8) DEFAULT NULL COMMENT 'Code',
  `Expire_Time` bigint(20) DEFAULT NULL COMMENT '过期时间',
  `Type` int(11) DEFAULT NULL COMMENT '验证类型',
  `Usable` int(11) DEFAULT NULL COMMENT '是否可用',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `sys_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改以及新增时候改变',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='验证码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_Validation`
--

LOCK TABLES `Crm_Validation` WRITE;
/*!40000 ALTER TABLE `Crm_Validation` DISABLE KEYS */;
INSERT INTO `Crm_Validation` VALUES (1,'370728',1397804318,1,0,2,'2014-04-18 06:56:58'),(2,'566453',1397804438,1,0,2,'2014-04-18 06:59:13'),(3,'115085',1397805215,1,1,2,'2014-04-18 07:11:35');
/*!40000 ALTER TABLE `Crm_Validation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Crm_area_district`
--

DROP TABLE IF EXISTS `Crm_area_district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Crm_area_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `desc` varchar(1000) NOT NULL,
  `city_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0',
  `picture_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Crm_area_district`
--

LOCK TABLES `Crm_area_district` WRITE;
/*!40000 ALTER TABLE `Crm_area_district` DISABLE KEYS */;
INSERT INTO `Crm_area_district` VALUES (1,'万达广场','佛挡杀佛',1,1,1,1,1),(2,'春熙路','第三方打算',1,1,1,1,1);
/*!40000 ALTER TABLE `Crm_area_district` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-24 17:53:29
