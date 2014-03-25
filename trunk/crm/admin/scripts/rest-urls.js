/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          resturls.base = "";

          resturls.add = function (name, url) {
              resturls[name] = resturls.base + url + "?timestamp=" + new Date().getTime();
          };

          resturls.addpage = function (name, url) {
              resturls[name] = resturls.base + url + "?timestamp=" + new Date().getTime();
          };

          resturls.addpage("login_page", "login.php");

          $provide.constant('$resturls', resturls);

      }]);
})(window, window.angular);