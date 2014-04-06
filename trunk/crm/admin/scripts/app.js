angular.module('gogotowncrm', ['ngRoute', 'ui.router', 'ngRestUrls']).
config(['$provide', '$httpProvider', '$routeProvider', '$stateProvider', '$urlRouterProvider', '$resturls', function ($provide, $httpProvider, $routeProvider, $stateProvider, $urlRouterProvider, $resturls) {
    $routeProvider
        .when('/user', { template: '', controller: function () { } })
        .when('/seacustomer/:pageIndex?', { template: '', controller: function () { } })
        .when('/merchantinfo', { template: '', controller: function () { } })
        .when('/mebershiplevel', { template: '', controller: function () { } })
        .when('/permissions/:sorts?/:pageIndex?', { template: '', controller: function () { } })
        .when('/client/:sorts?/:pageIndex?/:parameters?', { template: '', controller: function () { } })
        .otherwise({ redirectTo: '/home' });
    $stateProvider
         .state("main", {
             url: "",
             templateUrl: 'partials/main.html'
         })
         .state('main.home', {
             url: '/home',
             templateUrl: 'partials/home.html',
             controller: function () { }
         })
         .state('main.user', { url: '/user*path', templateUrl: 'partials/userinfo.html', controller: function () { } })
         .state('main.client', { url: '/client*path', templateUrl: 'partials/client.html', controller: ClientMainCtrl })
         .state('main.seacustomer', { url: '/seacustomer*path', templateUrl: 'partials/seacustomer.html', controller: SeaCustomerMainCtrl })
         .state('main.merchantinfo', { url: '/merchantinfo*path', templateUrl: 'partials/merchantinfo.html', controller: MerchantInfoMainCtrl })
         .state('main.mebershiplevel', { url: '/mebershiplevel*path', templateUrl: 'partials/mebershiplevel.html', controller: MemberShipLevelCtrl })
         .state('main.permissions', { url: '/permissions*path', templateUrl: 'partials/authoritymanagement.html', controller: AuthorityManagementCtrl });

    $httpProvider.interceptors.push(function () {
        return {
            'response': function (response) {
                if (response && typeof response.data === 'object') {
                    if (response.data.Error == 11) {
                        setTimeout(function () { window.location.href = 'login.html'; }, 3000);
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
    $scope.currentuser = null;
    //登录
    $http.post($resturls["GetCurrentUser"], {}).success(function (result) {
        if (result.Error == 0) {
            $scope.currentuser = result.Data;
        } else {
            $scope.currentuser = {};
        }
    });
}
