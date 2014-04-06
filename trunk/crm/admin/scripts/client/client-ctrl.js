function ClientMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "gogocustomer";
    } //gogo客户
    $scope.loadClientSortList = function (pageIndex, paramters) {
        $(".form_date").datetimepicker({
            language: 'zh-CN',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'owncustomer':
                $http.post($resturls["LoadOwnCustomersList"], { name: '', phone: '', sex: 0, pageindex: pageIndex - 1, pagesize: pageSize, paramters: paramters }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.ownclients = result.Data;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#client/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.ownclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
            case 'gogocustomer':
                $http.post($resturls["LoadGoGoCustomerList"], { name: '', phone: '', sex: 0, type: 3, pageindex: pageIndex - 1, pagesize: pageSize, paramters: paramters }).success(function (result) {
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
    $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.parameters || "");
   
    //增加客户弹窗
    $scope.ShowAddOwnCustomerModal = function (data, event) {
        if (event && event.stopPropagation) {
            event.stopPropagation();
        }
        else {
            window.event.cancelBubble = true;
        }
        if (data) {
            $scope.OwnCustomer = data;
        } else {
            $scope.OwnCustomer = { Customer_ID: 0, Sex: 1 };
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
            $http.post($resturls["AddOwnCustomer"], { name: data.Name, sex: data.Sex, phone: data.Phone, birthday: data.Birthady, remark: data.Remark }).success(function (result) {
                if (result.Error == 0) {
                    $("#addcustomermodal").modal('hide');
                    $scope.loadClientSortList($routeParams.pageIndex || 1, "");
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
    $scope.UpdateOwnCustomer = function (data)
    {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["UpdateOwnCustomer"], { name: data.Name, sex: data.Sex, phone: data.Phone, birthday: data.Birthady, remark: data.Remark, customer_id: data.Customer_ID }).success(function (result) {
                if (result.Error == 0) {
                    $("#addcustomermodal").modal('hide');
                    $scope.loadClientSortList($routeParams.pageIndex || 1, "");
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
    }
}

//公海客户scope
function SeaCustomerMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    var pageSize = 1;
    $scope.LoadSeaCustomerList = function (pageIndex, paramters) {
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadGoGoCustomerList"], { name: '', phone: '',type: 1, sex: 0, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
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
}