function ClientMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "owncustomer";

        //$parent.enterpriseActPageIndex = 1;
    } //gogo客户
    else {
        // $parent.personalActPageIndex = 1;
    }
    $scope.loadCurrentSortList = function (sorts,pageIndex) {
        // if (pageIndex == 0) pageIndex = 1;
        switch (sorts) {
            case '#gogocustomer': 
                $http.post($resturls["LoadGoGoCustomerList"], {name:'',phone:'',sex:0,type:0, pageindex: pageIndex  }).success(function (data) {
                    if (data.Error!=0) {
                        alert(data.ErrorMessage, 'e');
                    } else {
                        $scope.enterpriseclients = data.Data;
                        //console.log($scope.enterpriseclients);
                        $parent.enterpriseActPageIndex = pageIndex;
                        //$parent.pages = utilities.paging(data.Data.RecordsCount, pageIndex, 10, '#client/' + $scope.sorts + '/{0}');
                    }
                }).error(function (data, status, headers, config) {
                    $scope.enterpriseclients = [];
                })
                break;
            case '#owncustomer': 
                $http.post($resturls["LoadOwnCustomersList"], { name:'',phone:'',sex:0,pageindex: pageIndex }).success(function (data) {
                    if (data.Error!=0) { alert(data.ErrorMessage, 'e'); } else {
                    	console.log(data.Data)
                        $scope.personalclients = data.Data;
                      
                        $parent.personalActPageIndex = pageIndex;
                        //$parent.pages = utilities.paging(data.Data.RecordsCount, pageIndex, 10, '#client/' + $scope.sorts + '/{0}');
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
        $("#addcustomermodal").modal('show');
    }
    $scope.AddOwnCustomerSubmit = function (User) {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["LoadGoGoCustomerList"], {}).success(function (data) {
                if (data.Error) {
                    alert(data.ErrorMessage, 'e');
                }
                else {

                }
            })
        }
        else {
            $scope.showerror = true;
        }
    };
}

function SeaCustomerMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.load = function () {
        console.log("Call SeaCustomerController");
    }
    $scope.load();

}