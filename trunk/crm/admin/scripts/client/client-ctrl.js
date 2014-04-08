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
        $scope.choselevel = $rootScope.selectedOwnCustomerLevel;
        //获取商家会员等级设置信息
        $scope.LoadMemberShipLeveList = function () {
            $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (result) {
                if (result.Error == 0) {
                    $scope.mebershiplevels = result.Data;
                    if (!$scope.choselevel) {
                        if ($scope.mebershiplevels.length > 0) {
                            $scope.choselevel = $scope.mebershiplevels[0];
                        } else {
                            $scope.choselevel = { ID: 0, Name: '未设置等级' };
                        }
                    }

                } else {
                    $scope.mebershiplevels = [];
                }
            });
        }
        $scope.LoadMemberShipLeveList();
        if (data) {
            $scope.OwnCustomer = angular.copy(data);
            $scope.OwnCustomer.Birthady = $scope.timestamptostr($scope.OwnCustomer.Birthady);
            $('.form_date').datetimepicker({
                minView: 2,
                language: 'zh-CN',
                format: "yyyy-mm-dd",
                autoclose: true,
                todayBtn: true,
                pickerPosition: "bottom-left"
            }).on('changeDate', function (ev) {
                $scope.$apply(function () {
                    $scope.OwnCustomer.Birthady = $scope.strtotimestamp($scope.OwnCustomer.Birthady);
                });
            });
        } else {
            $scope.OwnCustomer = { ID: 0, Sex: 1 };
            $('.form_date').datetimepicker({
                minView: 2,
                language: 'zh-CN',
                format: "yyyy-mm-dd",
                autoclose: true,
                todayBtn: true,
                pickerPosition: "bottom-left"
            }).on('changeDate', function (ev) {
                $scope.$apply(function () {
                    $scope.OwnCustomer.Birthady = $scope.strtotimestamp($scope.OwnCustomer.Birthady);
                });
            });
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
function AddOwnCustomerCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    $scope.ChoseCustomerRank = function (data) {
        $scope.choselevel = data;
        $rootScope.selectedOwnCustomerLevel = data;
    };
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
            $http.post($resturls["UpdateOwnCustomer"], { name: data.Name, sex: data.Sex, phone: data.Phone, birthday: 24, remark: data.Remark, customer_id: data.ID }).success(function (result) {
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

