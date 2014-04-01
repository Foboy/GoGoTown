function ClientCtrl($scope, $http, $location, $routeParams) {
    
//	$scope.LoadClientList = function(pageIndex) {
//		 $http.post($sitecore.urls["LoadCustmersList"], { pageIndex: pageIndex - 1, pageSize: 10 }).success(function (data) {
//             if (data.Error) { alert(data.ErrorMessage, 'e'); } else
//             {
//                 $scope.personalclients = data.Data.Items;
//                 $parent.personalActPageIndex = pageIndex;
//                 $parent.pages = utilities.paging(data.Data.RecordsCount, pageIndex, 10, '#client/' + $scope.sorts + '/{0}');
//             }
//         }).error(function (data, status, headers, config) {
//             $scope.personalclients = [];
//         })
    //	}
    $scope.load = function () {
        console.log("Call clientcontroller");
    }
    $scope.load();
}