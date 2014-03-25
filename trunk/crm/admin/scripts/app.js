angular.module('gogotowncrm', ['ngRoute', 'ui.router', 'ngRestUrls']).
 config(['$provide', '$httpProvider', '$routeProvider', '$stateProvider', '$urlRouterProvider', '$resturls', function ($provide, $httpProvider, $routeProvider, $stateProvider, $urlRouterProvider, $resturls) {

     $routeProvider
        .when('/home', { template: '', controller: function () { } })
        .when('/boss', { template: '', controller: function () { } })
        .when('/user', { template: '', controller: function () { } })
        .when('/mytimeshaft', { template: '', controller: function () { } })
        .when('/staffmangement', { template: '', controller: function () { } })
        .when('/changepassword', { template: '', controller: function () { } })
        .when('/changeemail', { template: '', controller: function () { } })
        .when('/enterpriseinfo', { template: '', controller: function () { } })
        .when('/product/:catalogId?/:pageIndex?', { template: '', controller: function () { } })
        .when('/sales/:steps?/:pageIndex?', { template: '', controller: function () { } })
        .when('/finance/:steps?/:pageIndex?', { template: '', controller: function () { } })
        .when('/client/:sorts?/:pageIndex?', { template: '', controller: function () { } })
        .otherwise({ redirectTo: '/home' });
     /*
     $stateProvider
         .state("main", {
             url: "",
             templateUrl: 'partials/main.html'
         })
         .state("boss", {
             url: "^/boss",
             templateUrl: 'partials/boss.html',
             controller: UserBossMainCtrl
         })
         .state('main.home', {
             url: '/home',
             templateUrl: 'partials/home.html',
             controller: HomeMainCtrl
         })
         .state("main.product", {
             url: "/product*path",
             templateUrl: 'partials/product.html',
             controller: ProductMainCtrl
         })
         .state('main.user', { url: '/user*path', templateUrl: 'partials/userinfo.html', controller: UserMainCtrl })
         .state('main.mytimeshaft', { url: '/mytimeshaft*path', templateUrl: 'partials/mytimeshaft.html', controller: UserTimeShaftCtrl })
         .state('main.staffmangement', { url: '/staffmangement*path', templateUrl: 'partials/staffmangement.html', controller: StaffMangementCtrl })
         .state('main.changepassword', { url: '/changepassword*path', templateUrl: 'partials/changepassword.html', controller: UserMainCtrl })
         .state('main.changeemail', { url: '/changeemail*path', templateUrl: 'partials/changeemail.html', controller: UserMainCtrl })
         .state('main.enterpriseinfo', { url: '/enterpriseinfo*path', templateUrl: 'partials/enterpriseinfo.html', controller: EnterPriseInfoCtrl })
         .state('main.sales', { url: '/sales*path', templateUrl: 'partials/sales.html', controller: SalesMainCtrl })
         .state('main.finance', { url: '/finance*path', templateUrl: 'partials/finance.html', controller: FinanceMainCtrl })
         .state('main.client', { url: '/client*path', templateUrl: 'partials/client.html', controller: ClientMainCtrl });
     */
     $httpProvider.interceptors.push(function () {
         return {
             'response': function (response) {
                 if (response && typeof response.data === 'object') {
                     if (response.data.Error == 11) {
                         setTimeout(function () { window.location.href = $resturls['login_page']; }, 0);
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