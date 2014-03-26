create database if not exists gogotowncrm;
use gogotowncrm;
drop table if exists Crm_Bills;

drop table if exists Crm_Customers;

drop table if exists Crm_Logs;

drop table if exists Crm_Message_Send_List;

drop table if exists Crm_Messages;

drop table if exists Crm_PMerchant_Customers;

drop table if exists Crm_PShop_Customers;

drop table if exists Crm_Rank;

drop table if exists Crm_Rank_Set;

drop table if exists Crm_Shops;

drop table if exists Crm_Users;

drop table if exists Crm_Validation;

/*==============================================================*/
/* Table: Crm_Bills                                             */
/*==============================================================*/
create table Crm_Bills
(
   ID                   int not null auto_increment,
   Shop_ID              int,
   Customer_ID          int,
   Pay_Mothed           int comment '1：现金支付，2：GO币支付，3：混合支付',
   Cash                 decimal,
   Go_Coin              int,
   Type                 int,
   Amount               decimal,
   Create_Time          datetime,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Customers                                         */
/*==============================================================*/
create table Crm_Customers
(
   ID                   int not null auto_increment,
   Name                 varchar(16),
   Phone                varchar(16),
   Rank                 int,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Logs                                              */
/*==============================================================*/
create table Crm_Logs
(
   ID                   int not null auto_increment,
   Type                 int,
   Content              varchar(128),
   Target               varchar(32),
   Create_Time          datetime,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Message_Send_List                                 */
/*==============================================================*/
create table Crm_Message_Send_List
(
   ID                   int not null auto_increment,
   Customer_ID          int,
   Shop_ID              int,
   Message_ID           int,
   Title                varchar(64),
   Content              varchar(512),
   Create_Time          datetime,
   Read_Time            datetime,
   State                int,
   Type                 int,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Messages                                          */
/*==============================================================*/
create table Crm_Messages
(
   ID                   int not null auto_increment,
   Shop_ID              int,
   Type                 int,
   Title                varchar(64),
   Content              varchar(512),
   Create_Time          datetime,
   State                int,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_PMerchant_Customers                               */
/*==============================================================*/
create table Crm_PMerchant_Customers
(
   ID                   int,
   Shop_ID              int,
   Customer_ID          int,
   Times                int,
   Last_Time            datetime
);

/*==============================================================*/
/* Table: Crm_PShop_Customers                                   */
/*==============================================================*/
create table Crm_PShop_Customers
(
   ID                   int,
   Shop_ID              int,
   Customer_ID          int,
   Times                int,
   Last_Time            datetime
);

/*==============================================================*/
/* Table: Crm_Rank                                              */
/*==============================================================*/
create table Crm_Rank
(
   ID                   int not null auto_increment,
   Shop_ID              int,
   Customer_ID          int,
   Rank                 int,
   Begin_Time           datetime,
   End_Time             datetime,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Rank_Set                                          */
/*==============================================================*/
create table Crm_Rank_Set
(
   ID                   int not null auto_increment,
   Rank                 int,
   Name                 varchar(16),
   Shop_ID              int,
   Remark               varchar(128),
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Shops                                             */
/*==============================================================*/
create table Crm_Shops
(
   ID                   int not null auto_increment,
   Name                 varchar(32),
   Longitude            double,
   Latitude             int,
   Address              varchar(64),
   Tel                  varchar(16),
   Phone                varchar(16),
   Owner                varchar(16),
   Email                varchar(32),
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Users                                             */
/*==============================================================*/
create table Crm_Users
(
   ID                   int not null auto_increment,
   Shop_ID              int,
   Type                 int,
   Account              varchar(32),
   Password             varchar(64),
   Last_Login           datetime,
   State                int,
   primary key (ID)
);

/*==============================================================*/
/* Table: Crm_Validation                                        */
/*==============================================================*/
create table Crm_Validation
(
   ID                   int not null auto_increment,
   Code                 varchar(8),
   Expire_Time          datetime,
   Type                 int,
   Usable               int,
   primary key (ID)
);
