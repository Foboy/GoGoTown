function ClientMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "gogocustomer";
        $parent.owncustomerActpageIndex = 1;
    } //gogo客户
    else {
        $parent.gogocustomerActpageIndex = 1;
    }
    $scope.loadClientSortList = function (pageIndex) {
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'owncustomer':
                $http.post($resturls["LoadOwnCustomersList"], { name: '', phone: '', sex: 0, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.ownclients = result.Data;
                        $parent.owncustomerActpageIndex = pageIndex;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#client/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.ownclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
            case 'gogocustomer':
                $http.post($resturls["LoadGoGoCustomerList"], { name: '', phone: '', sex: 0, type: 1, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
                    console.log(result);
                    if (result.Error == 0) {
                        $scope.gogoclients = result.Data;
                        $parent.gogocustomerActpageIndex = pageIndex;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#client/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.gogoclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;

        }
    }
    $scope.loadClientSortList($routeParams.pageIndex || 1);
    $scope.load = function () {
        console.log("Call clientcontroller");
    }
    $scope.load();
    //增加客户弹窗
    $scope.ShowAddOwnCustomerModal = function (data) {
        if (data) {
            $scope.OwnCustomer = data;
        } else {
            $scope.OwnCustomer = { customer_id: 0, sex: 1 };
        }
        $("#addcustomermodal").modal('show');
    }
    //客户数据详情弹窗
    $scope.ShowClientDetailModal = function (data) {
        $("#customerdetailmodal").modal('show');
    }
}

function AddOwnCustomerCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.SaveAddOwnCustomer = function (data) {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            console.log(data);
            $http.post($resturls["AddOwnCustomer"], { name: data.name, sex: data.sex, phone: data.phone, birthday: data.birthday, remark: data.remark }).success(function (result) {
                if (result.Error == 0) {
                    $("#addcustomermodal").modal('hide');
                    $scope.loadClientSortList($routeParams.pageIndex || 1);
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