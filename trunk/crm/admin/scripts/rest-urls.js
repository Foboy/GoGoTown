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
          resturls.addpage("login_page", "admin/login.php");
          resturls.add("login_info", "user/info");
          $provide.constant('$resturls', resturls);

      } ]);
})(window, window.angular);