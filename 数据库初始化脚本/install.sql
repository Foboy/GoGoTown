create database if not exists gogotowncrm;

use gogotowncrm;

drop table if exists Crm_Bills;

drop table if exists Crm_Customers;

drop table if exists Crm_Gogo_Customers;

drop table if exists Crm_Logs;

drop table if exists Crm_Message_Send_List;

drop table if exists Crm_Messages;

drop table if exists Crm_PMerchant_Customers;

drop table if exists Crm_PShop_Customers;

drop table if exists Crm_Rank;

drop table if exists Crm_Rank_Set;

drop table if exists Crm_Shop_Customers;

drop table if exists Crm_Shops;

drop table if exists Crm_Users;

drop table if exists Crm_Validation;

/*==============================================================*/
/* Table: Crm_Bills                                             */
/*==============================================================*/
create table Crm_Bills
(
   ID                   int not null auto_increment comment 'ID',
   Shop_ID              int comment '商家ID',
   Customer_ID          int comment '客户ID',
   Pay_Mothed           int comment '支付方式',
   Cash                 decimal comment '刷卡金额',
   Go_Coin              int comment 'Go币金额',
   Type                 int comment '消费类型',
   Amount               decimal comment '消费总金额',
   Create_Time          bigint(20) comment '消费时间',
   primary key (ID)
);

alter table Crm_Bills comment '客户消费记录';

/*==============================================================*/
/* Table: Crm_Customers                                         */
/*==============================================================*/
create table Crm_Customers
(
   ID                   int not null auto_increment comment 'ID',
   Name                 varchar(16) comment '姓名',
   Sex                  int comment '性别',
   Phone                varchar(16) comment '手机',
   Birthady             bigint(20) comment '出生日期',
   Remark               varchar(128) comment '备注',
   primary key (ID)
);

alter table Crm_Customers comment '商家客户表';

/*==============================================================*/
/* Table: Crm_Gogo_Customers                                    */
/*==============================================================*/
create table Crm_Gogo_Customers
(
   id                   int(11) not null comment 'id',
   mobile               char(11) not null comment 'mobile',
   email                varchar(50) not null comment 'email',
   password             char(32) not null comment 'password',
   username             varchar(30) not null comment 'username',
   nickname             varchar(10) not null comment 'nickname',
   sex                  tinyint(1) not null default 3 comment 'sex',
   salt                 char(6) not null comment 'salt',
   reg_ip               varchar(25) not null comment 'reg_ip',
   reg_time             int(11) not null comment 'reg_time',
   last_login_ip        varchar(25) not null comment 'last_login_ip',
   last_login_time      int(11) not null comment 'last_login_time',
   error_login_num      tinyint(4) not null default 0 comment 'error_login_num',
   address_num          tinyint(10) not null default 0 comment 'address_num',
   email_approve        tinyint(1) not null default 0 comment 'email_approve',
   mobile_approve       tinyint(1) not null default 0 comment 'mobile_approve',
   headimg              varchar(30) not null comment 'headimg',
   status               tinyint(1) not null default 1 comment 'status',
   primary key (id),
   key mobile (mobile),
   key username (username),
   key email (email)
)
ENGINE=InnoDB AUTO_INCREMENT=25433 DEFAULT CHARSET=utf8;

alter table Crm_Gogo_Customers comment 'GoGo客户表';

/*==============================================================*/
/* Table: Crm_Logs                                              */
/*==============================================================*/
create table Crm_Logs
(
   ID                   int not null auto_increment comment 'ID',
   Type                 int comment '类型',
   Content              varchar(128) comment '类容',
   Target               varchar(32) comment '对象',
   Create_Time          bigint(20) comment '时间',
   primary key (ID)
);

alter table Crm_Logs comment '系统日志表';

/*==============================================================*/
/* Table: Crm_Message_Send_List                                 */
/*==============================================================*/
create table Crm_Message_Send_List
(
   ID                   int not null comment 'ID',
   Customer_ID          int comment '客户ID',
   Shop_ID              int comment '商家ID',
   Message_ID           int comment '信息ID',
   Title                varchar(64) comment '标题',
   Content              varchar(512) comment '内容',
   Create_Time          bigint(20) comment '创建时间',
   Read_Time            bigint(20) comment '打开时间',
   State                int comment '状态',
   Type                 int comment '类型',
   primary key (ID)
);

alter table Crm_Message_Send_List comment '信息推送列表';

/*==============================================================*/
/* Table: Crm_Messages                                          */
/*==============================================================*/
create table Crm_Messages
(
   ID                   int not null auto_increment comment 'ID',
   Shop_ID              int comment '商家ID',
   Type                 int comment '信息类型',
   Title                varchar(64) comment '标题',
   Content              varchar(512) comment '信息类容',
   Send_Time            datetime comment '发送时间',
   Create_Time          bigint(20) comment '创建时间',
   State                int comment '发送状态',
   primary key (ID)
);

alter table Crm_Messages comment '商户推送信息';

/*==============================================================*/
/* Table: Crm_PMerchant_Customers                               */
/*==============================================================*/
create table Crm_PMerchant_Customers
(
   ID                   int comment 'ID',
   Shop_ID              int comment '商家ID',
   Customer_ID          int comment '客户ID',
   Times                int comment '商圈出现次数',
   Last_Time            bigint(20) comment '最后出现时间'
);

alter table Crm_PMerchant_Customers comment '商圈公海客户';

/*==============================================================*/
/* Table: Crm_PShop_Customers                                   */
/*==============================================================*/
create table Crm_PShop_Customers
(
   ID                   int comment 'ID',
   Shop_ID              int comment '商家ID',
   Customer_ID          int comment '客户ID',
   Times                int comment '商圈出现次数',
   Last_Time            bigint(20) comment '最后出现时间'
);

alter table Crm_PShop_Customers comment '商家公海客户';

/*==============================================================*/
/* Table: Crm_Rank                                              */
/*==============================================================*/
create table Crm_Rank
(
   ID                   int not null comment 'ID',
   From_Type            int comment '客户来源',
   Shop_ID              int comment '商家ID',
   Customer_ID          int comment '用户ID',
   Rank                 int comment '用户等级',
   Begin_Time           bigint(20) comment '生效时间',
   End_Time             bigint(20) comment '终止时间',
   primary key (ID)
);

alter table Crm_Rank comment '客户等级';

/*==============================================================*/
/* Table: Crm_Rank_Set                                          */
/*==============================================================*/
create table Crm_Rank_Set
(
   ID                   int not null auto_increment comment 'ID',
   Rank                 int comment '等级',
   Name                 varchar(16) comment '名称',
   Shop_ID              int comment '商家ID',
   Remark               varchar(128) comment '备注',
   primary key (ID)
);

alter table Crm_Rank_Set comment '客户等级设定';

/*==============================================================*/
/* Table: Crm_Shop_Customers                                    */
/*==============================================================*/
create table Crm_Shop_Customers
(
   ID                   int not null comment 'ID',
   Shop_ID              int comment '商家ID',
   Customer_ID          int comment '客户ID',
   From_Type            int comment '客户来源',
   Type                 int comment '客户类型',
   Create_Time          bigint(20) comment '添加时间',
   primary key (ID)
);

alter table Crm_Shop_Customers comment '商家客户关联表';

/*==============================================================*/
/* Table: Crm_Shops                                             */
/*==============================================================*/
create table Crm_Shops
(
   id                   int(11) not null comment 'id',
   name                 varchar(50) not null comment 'name',
   description          varchar(1000) not null default '' comment 'description',
   cover_pictureid      int(11) not null comment 'cover_pictureid',
   brand_id             int(11) not null default 0 comment 'brand_id',
   tags                 varchar(255) not null comment 'tags',
   mobile               char(11) not null comment 'mobile',
   telphone             varchar(30) not null comment 'telphone',
   city_id              int(11) not null comment 'city_id',
   area_id              int(11) not null comment 'area_id',
   district_id          int(11) not null default 0 comment 'district_id',
   street_id            int(11) not null default 0 comment 'street_id',
   address              varchar(200) not null comment 'address',
   longitude            varchar(20) not null comment 'longitude',
   latitude             varchar(20) not null comment 'latitude',
   booking_num          int(11) not null comment 'booking_num',
   view_num             int(11) not null default 0 comment 'view_num',
   comm_num             int(11) not null default 0 comment 'comm_num',
   check_status         tinyint(1) not null default 0 comment 'check_status',
   add_adminid          int(11) not null comment 'add_adminid',
   add_time             int(11) not null comment 'add_time',
   flag                 tinyint(1) not null default 1 comment 'flag',
   FULLTEXT             KEY `name` (`name`) comment 'FULLTEXT',
   primary key (id),
   key brand_id (brand_id),
   key city_id (city_id),
   key area_id (area_id),
   key district_id (district_id),
   key street_id (street_id),
   key longitude (longitude),
   key latitude (latitude)
)
ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='商家信息表';

alter table Crm_Shops comment 'GoGo商家信息表';

/*==============================================================*/
/* Table: Crm_Users                                             */
/*==============================================================*/
create table Crm_Users
(
   ID                   int not null auto_increment comment 'ID',
   Name                 int comment '商家名',
   Shop_ID              int comment '商家ID',
   Type                 int comment '账户类型',
   Account              varchar(32) comment '账户名',
   Password             varchar(64) comment '登陆密码',
   Last_Login           bigint(20) comment '最近登陆时间',
   State                int comment '账户状态',
   Faileds              int comment '登陆失败次数',
   Last_Failed          bigint(20) comment '登陆失败时间',
   Token                varchar(64) comment 'Token',
   Create_Time          bigint(20) comment '添加时间',
   primary key (ID)
);

alter table Crm_Users comment '系统用户表';

/*==============================================================*/
/* Table: Crm_Validation                                        */
/*==============================================================*/
create table Crm_Validation
(
   ID                   int not null auto_increment comment 'ID',
   Code                 varchar(8) comment 'Code',
   Expire_Time          bigint(20) comment '过期时间',
   Type                 int comment '验证类型',
   Usable               int comment '是否可用',
   Customer_ID          int comment '客户ID',
   primary key (ID)
);

alter table Crm_Validation comment '验证码';


