CREATE TABLE `Crm_Bills` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `Pay_Mothed` int(11) DEFAULT NULL COMMENT '支付方式',
  `Cash` decimal(10,0) DEFAULT NULL COMMENT '刷卡金额',
  `Go_Coin` int(11) DEFAULT NULL COMMENT 'Go币金额',
  `Type` int(11) DEFAULT NULL COMMENT '消费类型',
  `Amount` decimal(10,0) DEFAULT NULL COMMENT '消费总金额',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '消费时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='客户消费记录';
CREATE TABLE `Crm_Customers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Name` varchar(16) DEFAULT NULL COMMENT '姓名',
  `Sex` int(11) DEFAULT NULL COMMENT '性别',
  `Phone` varchar(16) DEFAULT NULL COMMENT '手机',
  `Birthady` bigint(20) DEFAULT NULL COMMENT '出生日期',
  `Remark` varchar(128) CHARACTER SET utf8 DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=22  COMMENT='商家客户表';
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
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='GoGo客户表';

CREATE TABLE `Crm_Logs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Type` int(11) DEFAULT NULL COMMENT '类型',
  `Content` varchar(128) DEFAULT NULL COMMENT '类容',
  `Target` varchar(32) DEFAULT NULL COMMENT '对象',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='系统日志表';
CREATE TABLE `Crm_Messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Type` int(11) DEFAULT NULL COMMENT '信息类型',
  `Title` varchar(64) DEFAULT NULL COMMENT '标题',
  `Content` varchar(512) DEFAULT NULL COMMENT '信息类容',
  `Send_Time` datetime DEFAULT NULL COMMENT '发送时间',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '创建时间',
  `State` int(11) DEFAULT NULL COMMENT '发送状态',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户推送信息';
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
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='信息推送列表';

CREATE TABLE `Crm_PMerchant_Customers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `Times` int(11) DEFAULT NULL COMMENT '商圈出现次数',
  `Last_Time` bigint(20) DEFAULT NULL COMMENT '最后出现时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='商圈公海客户';
CREATE TABLE `Crm_PShop_Customers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `Times` int(11) DEFAULT NULL COMMENT '商圈出现次数',
  `Last_Time` bigint(20) DEFAULT NULL COMMENT '最后出现时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='商家公海客户';
CREATE TABLE `Crm_Rank` (
  `ID` int(11) NOT NULL COMMENT 'ID',
  `From_Type` int(11) DEFAULT NULL COMMENT '客户来源',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '用户ID',
  `Rank` int(11) DEFAULT NULL COMMENT '用户等级',
  `Begin_Time` bigint(20) DEFAULT NULL COMMENT '生效时间',
  `End_Time` bigint(20) DEFAULT NULL COMMENT '终止时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客户等级';
CREATE TABLE `Crm_Rank_Set` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Rank` int(11) DEFAULT NULL COMMENT '等级',
  `Name` varchar(16) DEFAULT NULL COMMENT '名称',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Remark` varchar(128) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COMMENT='客户等级设定';
CREATE TABLE `Crm_Shop_Customers` (
  `ID` int(11) NOT NULL COMMENT 'ID',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  `From_Type` int(11) DEFAULT NULL COMMENT '客户来源',
  `Type` int(11) DEFAULT NULL COMMENT '客户类型',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商家客户关联表';
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
CREATE TABLE `Crm_Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Name` varchar(64) DEFAULT NULL COMMENT '商家名',
  `Shop_ID` int(11) DEFAULT NULL COMMENT '商家ID',
  `Type` int(11) DEFAULT NULL COMMENT '账户类型',
  `Account` varchar(32) DEFAULT NULL COMMENT '账户名',
  `Password` varchar(64) DEFAULT NULL COMMENT '登陆密码',
  `Last_Login` bigint(20) DEFAULT NULL COMMENT '最近登陆时间',
  `State` int(11) DEFAULT NULL COMMENT '账户状态',
  `Faileds` int(11) DEFAULT NULL COMMENT '登陆失败次数',
  `Last_Failed` bigint(20) DEFAULT NULL COMMENT '登陆失败时间',
  `Token` varchar(64) DEFAULT NULL COMMENT 'Token',
  `Create_Time` bigint(20) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统用户表';
CREATE TABLE `Crm_Validation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `Code` varchar(8) DEFAULT NULL COMMENT 'Code',
  `Expire_Time` bigint(20) DEFAULT NULL COMMENT '过期时间',
  `Type` int(11) DEFAULT NULL COMMENT '验证类型',
  `Usable` int(11) DEFAULT NULL COMMENT '是否可用',
  `Customer_ID` int(11) DEFAULT NULL COMMENT '客户ID',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='验证码';










