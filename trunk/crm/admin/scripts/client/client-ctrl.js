function ClientCtrl($scope, $http, $location, $routeParams) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "owncustomer";
        //$parent.enterpriseActPageIndex = 1;
    } //gogo���ѿͻ�
    else {
        // $parent.personalActPageIndex = 1;
    }
    $scope.loadCurrentSortList = function (pageIndex) {
        // if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'gogocustomer': //�̼��Լ������ͻ�
                $http.post($sitecore.urls["LoadownCustomersList"], { pageIndex: pageIndex - 1 }).success(function (data) {
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
            case 'personal': //��ȡgogo���ѿͻ�
                $http.post($sitecore.urls["LoadgogoCustomerList"], { pageIndex: pageIndex - 1 }).success(function (data) {
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
    $scope.ShowAddOwnCustomerModal = function () {
        $("#myModal").modal('show');
    }
    $scope.AddOwnCustomerSubmit = function (User) {
        console.log($scope.AddOwnCustomerForm.$valid);
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
        }
        else {
            $scope.showerror = true;
        }
    };
}