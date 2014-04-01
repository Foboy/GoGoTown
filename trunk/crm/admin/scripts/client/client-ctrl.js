function ClientCtrl($scope, $http, $location, $routeParams) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "owncustomer";
        //$parent.enterpriseActPageIndex = 1;
    } //gogo消费客户
    else {
        // $parent.personalActPageIndex = 1;
    }
    $scope.loadCurrentSortList = function (pageIndex) {
        // if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'gogocustomer': //商家自己新增客户
                $http.post($sitecore.urls["SearchCustomerEntByOwnerId"], { pageIndex: pageIndex - 1, pageSize: 10 }).success(function (data) {
                    if (data.Error) {
                        alert(data.ErrorMessage, 'e');
                    } else {
                        $scope.enterpriseclients = data.Data.Items;
                        $parent.enterpriseActPageIndex = pageIndex;
                        $parent.pages = utilities.paging(data.Data.RecordsCount, pageIndex, 10, '#client/' + $scope.sorts + '/{0}');
                    }
                }).error(function (data, status, headers, config) {
                    $scope.enterpriseclients = [];
                })
                break;
            case 'personal': //获取gogo消费客户
                $http.post($sitecore.urls["SearchCustomerPrivByOwnerId"], { pageIndex: pageIndex - 1, pageSize: 10 }).success(function (data) {
                    if (data.Error) { alert(data.ErrorMessage, 'e'); } else {
                        $scope.personalclients = data.Data.Items;
                        $parent.personalActPageIndex = pageIndex;
                        $parent.pages = utilities.paging(data.Data.RecordsCount, pageIndex, 10, '#client/' + $scope.sorts + '/{0}');
                    }
                }).error(function (data, status, headers, config) {
                    $scope.personalclients = [];
                })
                break;
        }
    }
    $scope.load = function () {
        console.log("Call clientcontroller");
    }
    $scope.load();
}