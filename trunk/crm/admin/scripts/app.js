angular.module('gogotowncrm', ['ngRoute', 'ui.router', 'ngRestUrls']).
config(['$provide', '$httpProvider', '$routeProvider', '$stateProvider', '$urlRouterProvider', '$resturls', function ($provide, $httpProvider, $routeProvider, $stateProvider, $urlRouterProvider, $resturls) {
    $routeProvider
        .when('/client/:sorts?/:pageIndex?/:parameters?', { template: '', controller: function () { } })
         .when('/spendingrecords/:pageIndex?', { template: '', controller: function () { } })
        .when('/seacustomer/:pageIndex?', { template: '', controller: function () { } })
        .when('/salesopportunity/:pageIndex?', { template: '', controller: function () { } })
        .when('/salesanalysis', { template: '', controller: function () { } })
        .when('/maintenance/:pageIndex?', { template: '', controller: function () { } })
        .when('/merchantinfo', { template: '', controller: function () { } })
        .when('/mebershiplevel', { template: '', controller: function () { } })
        .when('/permissions/:sorts?/:pageIndex?', { template: '', controller: function () { } })
        .otherwise({ redirectTo: '/home' });
    $stateProvider
         .state("main", { url: "", templateUrl: 'partials/main.html' })
         .state('main.home', { url: '/home',templateUrl: 'partials/home.html',controller: DataStatisticsCtrl })
         .state('main.client', { url: '/client*path', templateUrl: 'partials/client.html', controller: ClientMainCtrl })
         .state('main.spendingrecords', { url: '/spendingrecords*path', templateUrl: 'partials/spendingrecords.html', controller: SpendingRecordsCtrl })
         .state('main.seacustomer', { url: '/seacustomer*path', templateUrl: 'partials/seacustomer.html', controller: SeaCustomerMainCtrl })
         .state('main.salesopportunity', { url: '/salesopportunity*path', templateUrl: 'partials/salesopportunity.html', controller: SalesOpportunityCtrl })
         .state('main.salesanalysis', { url: '/salesanalysis*path', templateUrl: 'partials/salesanalysis.html', controller: SaleAnalyzeCtrl })
         .state('main.maintenance', { url: '/maintenance*path', templateUrl: 'partials/maintenance.html', controller: MaintenanceCtrl })
         .state('main.merchantinfo', { url: '/merchantinfo*path', templateUrl: 'partials/merchantinfo.html', controller: MerchantInfoMainCtrl })
         .state('main.mebershiplevel', { url: '/mebershiplevel*path', templateUrl: 'partials/mebershiplevel.html', controller: MemberShipLevelCtrl })
         .state('main.permissions', { url: '/permissions*path', templateUrl: 'partials/authoritymanagement.html', controller: AuthorityManagementCtrl });




    $httpProvider.interceptors.push(function () {
        return {
            'response': function (response) {
                if (response && typeof response.data === 'object') {
                    if (response.data.Error == 11) {
                        $.scojs_message('非法访问', $.scojs_message.TYPE_ERROR);
                        setTimeout(function () {
                            window.location.href = 'login.html';
                        }, 1000);
                    }
                }
                return response || $q.when(response);
            }
        };
    });
}])
    .value('$anchorScroll', angular.noop)
    .run(
      ['$rootScope', '$state', '$stateParams',
      function ($rootScope, $state, $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      }]);;

function MainCtrl($scope, $routeParams, $http, $location, $filter, $resturls) {
    $scope.LoginOut = function () {
        $http.post($resturls["LoginOut"], {}).success(function (result) {
            if (result.Error == 0) {
                window.location.href = "login.html";
            } else {
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        })
    };
    $scope.currentuser = null;
    //登录
    $http.post($resturls["GetCurrentUser"], {}).success(function (result) {
        if (result.Error == 0) {
            $scope.currentuser = result.Data;
        } else {
            $scope.currentuser = {};
        }
    });
    //根据出生日期unix时间戳计算年龄
    $scope.CalculateAge = function (time) {
        var age = 0;
        time = $scope.timestamptostr(time);
        if (time) {
            var now = new Date();
            var birthday = new Date(time);
            if ((now.getFullYear() - birthday.getFullYear()) > 0) {
                if ((now.getMonth() - birthday.getMonth()) > 0) {
                    age = (now.getFullYear() - birthday.getFullYear()) + 1;
                }
                else if ((now.getMonth() - birthday.getMonth()) == 0) {
                    age = now.getFullYear() - birthday.getFullYear();
                } else {
                    age = (now.getFullYear() - birthday.getFullYear()) - 1;
                }
            } else {
                age = 0;
            }
        }
        return age;
    }
    // unix时间戳转化为 eg:'2014-04-08'
    $scope.timestamptostr = function (timestamp) {
        if (timestamp.indexOf('-') == -1) {
            var month = 0;
            var day = 0;
            if (timestamp) {
                var unixTimestamp = new Date(timestamp * 1000);
                if (unixTimestamp.getMonth() < 9) {
                    month = '0' + (unixTimestamp.getMonth() + 1);
                }
                if (unixTimestamp.getDay() < 9) {
                    day = '0' + unixTimestamp.getDay();
                }
                var str = unixTimestamp.getFullYear() + '-' + month + '-' + day;
                return str;
            } else {
                return "";
            }
        } else {
            return timestamp;
        }
    }

    // 时间格式字符串 ey:'2014-04-08'转化为unix时间戳
    $scope.strtotimestamp = function (datestr) {
        var arr = datestr.split("-");
        var timestap = new Date(Date.UTC(arr[0], arr[1] - 1, arr[2])).getTime() / 1000;
        return timestap;
    }
    //删除字符串末尾空格和指定字符
    $scope.trimEnd = function (temp, str) {
        if (!str) { return temp; }
        while (true) {
            if (temp.substr(temp.length - str.length, str.length) != str) {
                break;
            }
            temp = temp.substr(0, temp.length - str.length);
        }
        return temp;
    }
}
