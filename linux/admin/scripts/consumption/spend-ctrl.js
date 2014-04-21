//消费记录scope
function SpendingRecordsCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    var $parent = $scope.$parent;
    $scope.searchpSRparameter = $rootScope.searchSR;
    $scope.LoadSpendingRecordList = function (pageIndex) {
        if (!$scope.searchpSRparameter) {
            $scope.searchpSRparameter = '';
        }
        var pageSize = 10;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadSpendingRecordList"], { sname: $scope.searchpSRparameter, pay_mothed: 0, customer_id: 0, type: 0, create_time1: '', create_time2: '', pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
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