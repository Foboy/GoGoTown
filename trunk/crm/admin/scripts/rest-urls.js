/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};

          resturls.base = "/GoGoTown/trunk/crm/index.php";
         //resturls.base = "http://172.27.35.2/GoGoTown/trunk/crm/index.php";

         // resturls.base = "/crm/index.php";
          resturls.add = function (name, url) {
              resturls[name] = resturls.base + "?url=" + url;
          };
          resturls.addpage = function (name, url) {
              resturls[name] = resturls.base + url;
          };


          // 主模块
          resturls.add("GetCurrentUser", "user/getCurrentUser");//获取当前登陆用户信息
          resturls.add("Login", "user/crmlogin");//登陆
          resturls.add("LoginOut", "user/logout");//退出登陆


          // 客户管理

          resturls.add("LoadOwnCustomersList", "customers/searchPrivateBP"); //分页获取商家自有客户信息
          resturls.add("LoadGoGoCustomerList", "customers/searchGOGOBP"); //分页获取商家有消费记录gogo客户
          resturls.add("AddOwnCustomer", "customers/addPrivateCustomer");//添加商家自有客户信息
          resturls.add("UpdateOwnCustomer", "customers/update");//跟新商家自有客户信息
          resturls.add("SensMessage", "messages/send");//发送消息
          resturls.add("DeleteOwnCustomer", "customers/del");//删除自有客户
          resturls.add("SetCustomerRank", "shoprank/setCustomerRank");//客户会员等级 from_type 1自有 2 gogo

          //基本信息设置
          resturls.add("GetMerchantInfo", "shopinfo/get"); //获取商家基本信息
          resturls.add("EditMerchantInfo", "shopinfo/updateName"); //编辑商家信息(名字)
          resturls.add("SearchMerchantSetLevels", "shoprank/search");//获取商家设置的会员的等级
          resturls.add("AddMemberLevels", "shoprank/add");//新增会员等级信息
          resturls.add("DeleteMemberShipLevel", "shoprank/delete");//删除会员等级
          resturls.add("UpdateMemberLevels", "shoprank/update");//修改会员等级信息
          resturls.add("AddUserAccount", "user/register");//添加用户账号
          resturls.add("UpdateUserState", "user/updateUserState");//启用禁用用户 1 启用 0禁用
          resturls.add("LoadUserAccountList", "shopinfo/searchApps");//分页查询用户账号列表  user_type 1 ADMIN 2 APP 3 STAFF
          resturls.add("RestPassword", "shopinfo/updateAppPass");//修改用户账号密码
          resturls.add("UpdateRankName", "shoprank/updateRankName");//编辑会员等级名称

          //公海客户
          resturls.add("LoadSeaCustomerList", "customers/searchGOGOBP"); //分页获取公海客户数据 type=1
          resturls.add("TransforChance", 'customers/setPshopToChance');//公海客户转化为销售机会


          //销售机会
          resturls.add("LoadSaleChanceList", "customers/searchGOGOBP"); //分页获取销售机会数据 type=2

          //消费记录
          resturls.add("LoadSpendingRecordList", "bill/searchBills");//分页插叙消费记录

          //图片
          resturls.add("UpLoadImage", "upload/UpLoadImage");//上传图片
          resturls.add("ResizeImage", "upload/ResizeImage");//调整图片
          //销售分析
          resturls.add("DisplaySalesFunnel", "customers/getCustomerCount");//销售分析
          resturls.add("SaleTotalTrendGraphByTime", "home/SaleTotalTrendGraphByTime");//昨日今日销售分析统计 (每天24小时)
          resturls.add("AppuserTrendGraphByTime", "home/AppuserTrendGraphByTime");//收银员APP
          $provide.constant('$resturls', resturls);
      } ]);
})(window, window.angular);