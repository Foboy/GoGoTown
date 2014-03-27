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
   Shop_ID              int comment '�̼�ID',
   Customer_ID          int comment '�ͻ�ID',
   Pay_Mothed           int comment '֧����ʽ',
   Cash                 decimal comment 'ˢ�����',
   Go_Coin              int comment 'Go�ҽ��',
   Type                 int comment '��������',
   Amount               decimal comment '�����ܽ��',
   Create_Time          bigint(20) comment '����ʱ��',
   primary key (ID)
);

alter table Crm_Bills comment '�ͻ����Ѽ�¼';

/*==============================================================*/
/* Table: Crm_Customers                                         */
/*==============================================================*/
create table Crm_Customers
(
   ID                   int not null auto_increment comment 'ID',
   Name                 varchar(16) comment '����',
   Sex                  int comment '�Ա�',
   Phone                varchar(16) comment '�ֻ�',
   Birthady             bigint(20) comment '��������',
   Remark               varchar(128) comment '��ע',
   primary key (ID)
);

alter table Crm_Customers comment '�̼ҿͻ���';

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

alter table Crm_Gogo_Customers comment 'GoGo�ͻ���';

/*==============================================================*/
/* Table: Crm_Logs                                              */
/*==============================================================*/
create table Crm_Logs
(
   ID                   int not null auto_increment comment 'ID',
   Type                 int comment '����',
   Content              varchar(128) comment '����',
   Target               varchar(32) comment '����',
   Create_Time          bigint(20) comment 'ʱ��',
   primary key (ID)
);

alter table Crm_Logs comment 'ϵͳ��־��';

/*==============================================================*/
/* Table: Crm_Message_Send_List                                 */
/*==============================================================*/
create table Crm_Message_Send_List
(
   ID                   int not null comment 'ID',
   Customer_ID          int comment '�ͻ�ID',
   Shop_ID              int comment '�̼�ID',
   Message_ID           int comment '��ϢID',
   Title                varchar(64) comment '����',
   Content              varchar(512) comment '����',
   Create_Time          bigint(20) comment '����ʱ��',
   Read_Time            bigint(20) comment '��ʱ��',
   State                int comment '״̬',
   Type                 int comment '����',
   primary key (ID)
);

alter table Crm_Message_Send_List comment '��Ϣ�����б�';

/*==============================================================*/
/* Table: Crm_Messages                                          */
/*==============================================================*/
create table Crm_Messages
(
   ID                   int not null auto_increment comment 'ID',
   Shop_ID              int comment '�̼�ID',
   Type                 int comment '��Ϣ����',
   Title                varchar(64) comment '����',
   Content              varchar(512) comment '��Ϣ����',
   Send_Time            datetime comment '����ʱ��',
   Create_Time          bigint(20) comment '����ʱ��',
   State                int comment '����״̬',
   primary key (ID)
);

alter table Crm_Messages comment '�̻�������Ϣ';

/*==============================================================*/
/* Table: Crm_PMerchant_Customers                               */
/*==============================================================*/
create table Crm_PMerchant_Customers
(
   ID                   int comment 'ID',
   Shop_ID              int comment '�̼�ID',
   Customer_ID          int comment '�ͻ�ID',
   Times                int comment '��Ȧ���ִ���',
   Last_Time            bigint(20) comment '������ʱ��'
);

alter table Crm_PMerchant_Customers comment '��Ȧ�����ͻ�';

/*==============================================================*/
/* Table: Crm_PShop_Customers                                   */
/*==============================================================*/
create table Crm_PShop_Customers
(
   ID                   int comment 'ID',
   Shop_ID              int comment '�̼�ID',
   Customer_ID          int comment '�ͻ�ID',
   Times                int comment '��Ȧ���ִ���',
   Last_Time            bigint(20) comment '������ʱ��'
);

alter table Crm_PShop_Customers comment '�̼ҹ����ͻ�';

/*==============================================================*/
/* Table: Crm_Rank                                              */
/*==============================================================*/
create table Crm_Rank
(
   ID                   int not null comment 'ID',
   From_Type            int comment '�ͻ���Դ',
   Shop_ID              int comment '�̼�ID',
   Customer_ID          int comment '�û�ID',
   Rank                 int comment '�û��ȼ�',
   Begin_Time           bigint(20) comment '��Чʱ��',
   End_Time             bigint(20) comment '��ֹʱ��',
   primary key (ID)
);

alter table Crm_Rank comment '�ͻ��ȼ�';

/*==============================================================*/
/* Table: Crm_Rank_Set                                          */
/*==============================================================*/
create table Crm_Rank_Set
(
   ID                   int not null auto_increment comment 'ID',
   Rank                 int comment '�ȼ�',
   Name                 varchar(16) comment '����',
   Shop_ID              int comment '�̼�ID',
   Remark               varchar(128) comment '��ע',
   primary key (ID)
);

alter table Crm_Rank_Set comment '�ͻ��ȼ��趨';

/*==============================================================*/
/* Table: Crm_Shop_Customers                                    */
/*==============================================================*/
create table Crm_Shop_Customers
(
   ID                   int not null comment 'ID',
   Shop_ID              int comment '�̼�ID',
   Customer_ID          int comment '�ͻ�ID',
   From_Type            int comment '�ͻ���Դ',
   Type                 int comment '�ͻ�����',
   Create_Time          bigint(20) comment '���ʱ��',
   primary key (ID)
);

alter table Crm_Shop_Customers comment '�̼ҿͻ�������';

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
ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='�̼���Ϣ��';

alter table Crm_Shops comment 'GoGo�̼���Ϣ��';

/*==============================================================*/
/* Table: Crm_Users                                             */
/*==============================================================*/
create table Crm_Users
(
   ID                   int not null auto_increment comment 'ID',
   Name                 int comment '�̼���',
   Shop_ID              int comment '�̼�ID',
   Type                 int comment '�˻�����',
   Account              varchar(32) comment '�˻���',
   Password             varchar(64) comment '��½����',
   Last_Login           bigint(20) comment '�����½ʱ��',
   State                int comment '�˻�״̬',
   Faileds              int comment '��½ʧ�ܴ���',
   Last_Failed          bigint(20) comment '��½ʧ��ʱ��',
   Token                varchar(64) comment 'Token',
   Create_Time          bigint(20) comment '���ʱ��',
   primary key (ID)
);

alter table Crm_Users comment 'ϵͳ�û���';

/*==============================================================*/
/* Table: Crm_Validation                                        */
/*==============================================================*/
create table Crm_Validation
(
   ID                   int not null auto_increment comment 'ID',
   Code                 varchar(8) comment 'Code',
   Expire_Time          bigint(20) comment '����ʱ��',
   Type                 int comment '��֤����',
   Usable               int comment '�Ƿ����',
   Customer_ID          int comment '�ͻ�ID',
   primary key (ID)
);

alter table Crm_Validation comment '��֤��';


