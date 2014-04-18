//公海客户scope
function SeaCustomerMainCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    var $parent = $scope.$parent;
    $scope.searchparamters = $rootScope.searchSeacustomer;
    $scope.LoadSeaCustomerList = function (pageIndex) {
        if (!$scope.searchparamters) {
            $scope.searchparamters = '';
        }
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadSeaCustomerList"], { rank_id: 0, name: $scope.searchparamters, phone: $scope.searchparamters, type: 1, sex: 0, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
            if (result.Error == 0) {
                $scope.seacustomers = result.Data;
                $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#seacustomer' + '/{0}');
            } else {
                $scope.seacustomers = [];
                $parent.pages = utilities.paging(0, pageIndex, pageSize);
            }
        });
    }
    $scope.LoadSeaCustomerList($routeParams.pageIndex || 1);

    $scope.SearchSeaCustomerList = function () {
        $rootScope.searchSeacustomer = $scope.searchparamters;
        $scope.LoadSeaCustomerList(1);
    }

    $scope.TransforSaleChanceModal = function (data) {
        $scope.seacustomer = data;
        $("#TransforSaleOpModal").modal('show');
    }
}
function ShowModalAboutSeaCustomrCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.TransforSaleChance = function (data) {
        $http.post($resturls['TransforChance'], { customer_id: data.customer_id }).success(function (result) {
            $("#TransforSaleOpModal").modal('hide');
            if (result.Error == 0) {
                $.scojs_message('转化成功', $.scojs_message.TYPE_OK);
                $scope.LoadSeaCustomerList(1);
            } else {
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        })
    }
}