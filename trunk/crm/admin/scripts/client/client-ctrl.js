function ClientMainCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    $scope.text = $rootScope.searchText;
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "gogocustomer";
    }
    if (!$scope.parameters) {
        $scope.parameters = decodeURIComponent($routeParams.parameters || "");
    }
    //客户
    $scope.loadClientSortList = function (pageIndex, parameters) {
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'owncustomer':
                $http.post($resturls["LoadOwnCustomersList"], { rank_id: 0, name: parameters, phone: parameters, sex: 0, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.ownclients = result.Data;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#client/' + $scope.sorts + '/{0}' + '/{1}', encodeURIComponent(parameters));
                    } else {
                        $scope.ownclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
            case 'gogocustomer':
                $http.post($resturls["LoadGoGoCustomerList"], { rank_id: 0, name: parameters, phone: parameters, sex: 0, type: 3, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.gogoclients = result.Data;
                        $parent.gogocustomerActpageIndex = pageIndex;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#client/' + $scope.sorts + '/{0}' + '/{1}', encodeURIComponent(parameters));
                    } else {
                        $scope.gogoclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
        }
    }
    $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.parameters || '');
    $scope.SearchClientSortList = function (condtion) {
        $scope.loadClientSortList(1, condtion);
        $rootScope.searchText = $scope.text;
    }


    //增加客户弹窗
    $scope.ShowAddOwnCustomerModal = function (data, event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else {
                window.event.cancelBubble = true;
            }
        }
        if (data) {
            $scope.OwnCustomer = data;
        } else {
            $scope.OwnCustomer = { ID: 0, Sex: 1 };
        }
        $("#addcustomermodal").modal('show');
    }
    //客户数据详情弹窗
    $scope.ShowClientDetailModal = function (data) {
        $("#customerdetailmodal").modal('show');
    }
    $scope.ShowSendMessageModal = function (data) {
        $scope.message = data;
        $("#SendMessageMoadl").modal('show');
    }
}

//增加自有客户scope
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
                    $scope.showerror = true;
                    alert("e");
                }
            })
        }
        else {
            $scope.showerror = true;
        }
    };
    //跟新自有客户信息
    $scope.UpdateOwnCustomer = function (data) {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["UpdateOwnCustomer"], { name: data.Name, sex: data.Sex, phone: data.Phone, birthday: data.Birthady, remark: data.Remark, customer_id: data.ID }).success(function (result) {
                if (result.Error == 0) {
                    $("#addcustomermodal").modal('hide');
                    $scope.loadClientSortList($routeParams.pageIndex || 1, "");
                    alert("success");
                }
                else {
                    $scope.showerror = true;
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
        $http.post($resturls["LoadGoGoCustomerList"], { rank_id: 0, name: '', phone: '', type: 1, sex: 0, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
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

//发送信息scope
function SendMessageCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.SendMessage = function (data) {
        if ($scope.SendMessageForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["SensMessage"], { customer_ids: data.Customer_ID, title: data.Title, content: data.Content }).success(function (result) {
                if (result.Error == 0) {
                    alert("scuccess");
                    $("#SendMessageMoadl").modal('hide');
                } else {
                    $scope.showerror = true;
                    alert("error");
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
}

