function SalesOpportunityCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    var $parent = $scope.$parent;
    $scope.searchpSOPparameter = $rootScope.searchpSaleOp;
    $scope.LoadSalesOpportunityList = function (pageIndex) {
        if (!$scope.searchpSOPparameter) {
            $scope.searchpSOPparameter = '';
        }
        var pageSize = 15;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadSaleChanceList"], { rank_id: 0, name: $scope.searchpSOPparameter, phone: $scope.searchpSOPparameter, sex: 0, type: 2, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
            if (result.Error == 0) {
                $scope.salesOpportunitys = result.Data;
                $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#salesopportunity' + '/{0}');
            } else {
                $scope.salesOpportunitys = [];
                $parent.pages = utilities.paging(0, pageIndex, pageSize);
            }
        });
    }
    $scope.LoadSalesOpportunityList($routeParams.pageIndex || 1);

    $scope.SerchSalesOppOpportunityList = function () {
        $rootScope.searchpSaleOp = $scope.searchpSOPparameter;
        $scope.LoadSalesOpportunityList(1);
    }
}