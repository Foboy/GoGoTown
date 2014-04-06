﻿/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          //resturls.base = "http://localhost/GoGoTown/trunk/crm/index.php";
          resturls.base = "http://localhost:8080/GoGoTown/trunk/crm/index.php";
          resturls.add = function (name, url) {
              resturls[name] = resturls.base + "?url=" + url;
          };
          resturls.addpage = function (name, url) {
              resturls[name] = resturls.base + url;
          };


          // 主模块
          resturls.add("GetCurrentUser", "user/getCurrentUser");
          resturls.add("Login", "user/crmlogin");


          // 客户管理

          resturls.add("LoadOwnCustomersList", "Customers/searchPrivateBP"); //分页获取商家自有客户信息
          resturls.add("LoadGoGoCustomerList", "Customers/searchGOGOBP"); //分页获取商家有消费记录gogo客户
          resturls.add("AddOwnCustomer", "Customers/addPrivateCustomer");//添加商家自有客户信息

          //基本信息设置
          resturls.add("GetMerchantInfo", "ShopInfo/get"); //获取商家基本信息
          resturls.add("EditMerchantInfo", "ShopInfo/updateName"); //编辑商家信息(名字)
          resturls.add("SearchMerchantSetLevels", "ShopRank/search");//获取商家设置的会员的等级
          resturls.add("AddMemberLevels", "ShopRank/add");//新增会员等级信息
          resturls.add("UpdateMemberLevels", "ShopRank/update");//修改会员等级信息
          resturls.add("AddUserAccount", "user/register");//添加用户账号
          $provide.constant('$resturls', resturls);

      } ]);
})(window, window.angular);