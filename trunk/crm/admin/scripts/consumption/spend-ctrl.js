function SpendingRecordsCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    var $parent = $scope.$parent;
    $scope.searchpSRparameter = $rootScope.searchSR;
    $scope.LoadSpendingRecordList = function (pageIndex) {
        if (!$scope.searchpSRparameter) {
            $scope.searchpSRparameter = '';
        }
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadSpendingRecordList"], {}).success(function (result) {
            if (result.Error == 0) {
                $scope.SpendingRecords = result.Data;
                $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#spendingrecords' + '/{0}');
            } else {
                $scope.SpendingRecords = [];
                $parent.pages = utilities.paging(0, pageIndex, pageSize);
            }
        });
    }
    $scope.LoadSpendingRecordList($routeParams.pageIndex || 1);
    $scope.SerchSpendingRecordList = function () {
        $rootScope.searchSR = $scope.searchpSRparameter;
        $scope.LoadSpendingRecordList(1);
    }
}