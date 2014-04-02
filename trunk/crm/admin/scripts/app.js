angular.module('gogotowncrm', ['ngRoute', 'ui.router', 'ngRestUrls']).
config(['$provide', '$httpProvider', '$routeProvider', '$stateProvider', '$urlRouterProvider', '$resturls', function ($provide, $httpProvider, $routeProvider, $stateProvider, $urlRouterProvider, $resturls) {
    $routeProvider
        .when('/user', { template: '', controller: function () { } })
        .when('/mytimeshaft', { template: '', controller: function () { } })
        .when('/staffmangement', { template: '', controller: function () { } })
        .when('/changepassword', { template: '', controller: function () { } })
        .when('/changeemail', { template: '', controller: function () { } })
        .when('/product/:catalogId?/:pageIndex?', { template: '', controller: function () { } })
        .when('/sales/:steps?/:pageIndex?', { template: '', controller: function () { } })
        .when('/finance/:steps?/:pageIndex?', { template: '', controller: function () { } })
        .when('/client/:sorts?/:pageIndex?', { template: '', controller: function () { } })
        .when('/seacustomer/:pageIndex?', { template: '', controller: function () { } })
        .when('/merchantinfo', { template: '', controller: function () { } })
        .when('/mebershiplevel', { template: '', controller: function () { } })
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
         .state("main.product", {
             url: "/product*path",
             templateUrl: 'partials/product.html',
             controller: function () { }
         })
         .state('main.user', { url: '/user*path', templateUrl: 'partials/userinfo.html', controller: function () { } })
         .state('main.mytimeshaft', { url: '/mytimeshaft*path', templateUrl: 'partials/mytimeshaft.html', controller: function () { } })
         .state('main.staffmangement', { url: '/staffmangement*path', templateUrl: 'partials/staffmangement.html', controller: function () { } })
         .state('main.changepassword', { url: '/changepassword*path', templateUrl: 'partials/changepassword.html', controller: function () { } })
         .state('main.changeemail', { url: '/changeemail*path', templateUrl: 'partials/changeemail.html', controller: function () { } })
         .state('main.enterpriseinfo', { url: '/enterpriseinfo*path', templateUrl: 'partials/enterpriseinfo.html', controller: function () { } })
         .state('main.sales', { url: '/sales*path', templateUrl: 'partials/sales.html', controller: function () { } })
         .state('main.finance', { url: '/finance*path', templateUrl: 'partials/finance.html', controller: function () { } })
         .state('main.client', { url: '/client*path', templateUrl: 'partials/client.html', controller: ClientMainCtrl })
         .state('main.seacustomer', { url: '/seacustomer*path', templateUrl: 'partials/seacustomer.html', controller: SeaCustomerMainCtrl })
         .state('main.merchantinfo', { url: '/merchantinfo*path', templateUrl: 'partials/merchantinfo.html', controller: MerchantMainCtrl })
         .state('main.mebershiplevel', { url: '/mebershiplevel*path', templateUrl: 'partials/mebershiplevel.html', controller: MerchantMainCtrl });

  

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
} ])
    .value('$anchorScroll', angular.noop)
    .run(
      ['$rootScope', '$state', '$stateParams',
      function ($rootScope, $state, $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      } ]);        ;