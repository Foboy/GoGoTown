/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          //resturls.base = "http://localhost/GoGoTown/trunk/crm/index.php";
         //resturls.base = "http://localhost/index.php";
          resturls.base = "http://192.168.8.110:8080/GoGoTown/trunk/crm/index.php";
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

          resturls.add("LoadOwnCustomersList", "Customers/searchPrivateBP"); //分页获取商家自有客户信息
          resturls.add("LoadGoGoCustomerList", "Customers/searchGOGOBP"); //分页获取商家有消费记录gogo客户
          resturls.add("AddOwnCustomer", "Customers/addPrivateCustomer");//添加商家自有客户信息
          resturls.add("UpdateOwnCustomer", "Customers/update");//跟新商家自有客户信息
          resturls.add("SensMessage", "Messages/send");//发送消息
          resturls.add("DeleteOwnCustomer", "Customers/del");//删除自有客户
          resturls.add("SetCustomerRank", "ShopRank/setCustomerRank");//客户会员等级 from_type 1自有 2 gogo

          //基本信息设置
          resturls.add("GetMerchantInfo", "ShopInfo/get"); //获取商家基本信息
          resturls.add("EditMerchantInfo", "ShopInfo/updateName"); //编辑商家信息(名字)
          resturls.add("SearchMerchantSetLevels", "ShopRank/search");//获取商家设置的会员的等级
          resturls.add("AddMemberLevels", "ShopRank/add");//新增会员等级信息
          resturls.add("DeleteMemberShipLevel", "ShopRank/delete");//删除会员等级
          resturls.add("UpdateMemberLevels", "ShopRank/update");//修改会员等级信息
          resturls.add("AddUserAccount", "user/register");//添加用户账号
          resturls.add("UpdateUserState", "user/updateUserState");//启用禁用用户 1 启用 0禁用
          resturls.add("LoadUserAccountList", "ShopInfo/searchApps");//分页查询用户账号列表  user_type 1 ADMIN 2 APP 3 STAFF
          resturls.add("RestPassword", "ShopInfo/updateAppPass");//修改用户账号密码

          //公海客户
          resturls.add("LoadSeaCustomerList", "Customers/searchGOGOBP"); //分页获取公海客户数据 type=1
          resturls.add("TransforChance", 'Customers/setPshopToChance');//公海客户转化为销售机会
          

          //销售机会
          resturls.add("LoadSaleChanceList", "Customers/searchGOGOBP"); //分页获取销售机会数据 type=2

          //消费记录
          resturls.add("LoadSpendingRecordList", "bill/searchBillsByCrm");//分页插叙消费记录

          //图片
          resturls.add("UpLoadImage", "upload/UpLoadImage");//上传图片
          resturls.add("ResizeImage", "upload/ResizeImage");//调整图片
          $provide.constant('$resturls', resturls);
      } ]);
})(window, window.angular);