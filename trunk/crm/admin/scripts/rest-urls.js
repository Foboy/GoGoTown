/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          resturls.base = "http://localhost:8080/GoGoTown/trunk/crm/index.php";
          resturls.add = function (name, url) {
              resturls[name] = resturls.base + "?url=" + url;
          };
          resturls.addpage = function (name, url) {
              resturls[name] = resturls.base + url;
          };
          // 主模块
          resturls.add("Register", "Login/register_action");
          resturls.add("Login", "Login/login");


          // 客户管理

          resturls.add("LoadOwnCustomersList", "ShopCustomers/searchPrivateBP"); //分页获取商家自有客户信息
          resturls.add("LoadGoGoCustomerList", "ShopCustomers/searchGOGOBP"); //分页获取商家有消费记录gogo客户
          resturls.add("AddOwnCustomer", "")

          //基本信息设置
          resturls.add("GetMerchantInfo", "ShopRank/get"); //获取商家基本信息
          resturls.add("EditMerchantInfo", "ShopRank/Edit"); //编辑商家信息

          $provide.constant('$resturls', resturls);

      } ]);
})(window, window.angular);