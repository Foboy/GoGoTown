﻿/*
**  Create by foboy.cray
**  2014/03/25
*/
(function (window, angular, undefined) {
    'use strict';
    angular.module('ngRestUrls', ['ng']).
      config(['$provide', function ($provide) {
          var resturls = {};
          resturls.base = "http://localhost/";

          resturls.add = function (name, url) {
              resturls[name] = resturls.base + "?url=" + url;
          };

          resturls.addpage = function (name, url) {
              resturls[name] = resturls.base + url;
          };

          resturls.addpage("login_page", "admin/login.html");
          resturls.add("login_info", "user/info");

          $provide.constant('$resturls', resturls);

      }]);
})(window, window.angular);