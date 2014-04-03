function ClientMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "owncustomer";
    } //gogo客户
    else {
       
    }
    $scope.loadClientSortList = function () {
        // if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'owncustomer':
                $http.post($resturls["LoadOwnCustomersList"], { name: '', phone: '', sex: 0, pageindex: 0 }).success(function (result) {
                    console.log(result);
                    if (result.Error == 0) {
                        $scope.ownclients = result.Data;
                    } else {
                        $scope.ownclients = [];
                    }
                });
                break;
            case 'gogocustomer':
                $http.post($resturls["LoadGoGoCustomerList"], { name: '', phone: '', sex: 0, type: 0, pageindex: 0 }).success(function (result) {
                    console.log(result);
                    if (result.Error == 0) {
                        $scope.gogoclients = result.Data;
                    } else {
                        $scope.gogoclients = [];
                    }
                });
                break;
            
        }
    }
    $scope.loadClientSortList();
    $scope.load = function () {
        console.log("Call clientcontroller");
    }
    $scope.load();
    $scope.ShowAddOwnCustomerModal = function () {
        $("#addcustomermodal").modal('show');
    }
    
}

function AddOwnCustomerCtrl($scope, $http, $location, $routeParams, $resturls)
{
    $scope.SaveAddOwnCustomer = function (data) {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddOwnCustomer"], { name: data.name, sex: data.sex, phone: data.phone, birthday: data.birthday, remark: data.remark }).success(function (data) {
                if (data.Error == 0) {
                    $("#addcustomermodal").modal('hide');
                    alert("success");
                }
                else {
                    alert("e");
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