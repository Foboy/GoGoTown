function MerchantInfoMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.load = function () {
        console.log("Call MerchantInfoMainController");
    }
    $scope.load();
    //获取商家信息
    $scope.GetMerchantInfo = function () {
        $http.post($resturls["GetMerchantInfo"], {}).success(function (result) {
            if (result.Error == 0) {
                $scope.merchantinfo = result.Data;
            } else {
                $scope.merchantinfo = {};
            }
        });
    }
    $scope.GetMerchantInfo();
    //修改商家信息（名字）
    $scope.SaveEditMerchant = function (data) {
        if (!data.name) {
            $scope.Ntype = true;
        }
        if ($scope.EditMerchantForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["EditMerchantInfo"], { name: data.name }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                }
                else {
                    alert("error");
                }
            })
        }
        else {
            $scope.showerror = true;
        }
    }
}

function MemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    //获取商家会员等级设置信息
    $scope.LoadMemberShipLeveList = function () {
        $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (result) {
            if (result.Error == 0) {
                $scope.mebershiplevels = result.Data;
            } else {
                $scope.mebershiplevels = {};
            }
        });
    }
    //保存商家编辑会员等级设置
    $scope.SaveEditMerberShipLevel = function (data) {
        if (!this.showerror) {
            this.showerror = true;
            return;
        }
        if ($scope.EditLevelForm.$valid) {
            this.showerror = false;
            $http.post($resturls["UpdateMemberLevels"], { rank: data.Rank, name: data.Name, remark: "", id: data.ID }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                } else {
                    alert("error");
                }
            })
        }
        else {
            this.showerror = true;
        }
    }
    //弹出增加会员等级设置框
    $scope.ShowAddMemberShipLevel = function () {
        $("#addmeberlevelmodal").modal('show');
    }

    $scope.LoadMemberShipLeveList();
}

function AddMemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    //保存增加会员等级设置
    $scope.SaveAddMemberShipLevel = function (data) {

        if ($scope.AddMemberShipLevelForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddMemberLevels"], { rank: 6, name: data.name, remark: '' }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                    $("#addmeberlevelmodal").modal('hide');
                } else {
                    alert("error");
                }
            })
        } else {
            $scope.showerror = true;
        }
    }
}

function AuthorityManagementCtrl($scope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "clerk";
        $parent.clerkActpageIndex = 1;
    }
    else {
        $parent.cashierActpageIndex = 1;
    }
    $scope.loadUserAccountSortList = function (pageIndex) {
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'clerk': //店员
                $http.post($resturls["LoadOwnCustomersList"], { name: '', phone: '', sex: 0, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.ownclients = result.Data;
                        $parent.owncustomerActpageIndex = pageIndex;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#permissions/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.ownclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
            case 'cashier': //收银员
                $http.post($resturls["LoadGoGoCustomerList"], { name: '', phone: '', sex: 0, type: 1, pageindex: pageIndex - 1, pagesize: pageSize }).success(function (result) {
                    console.log(result);
                    if (result.Error == 0) {
                        $scope.gogoclients = result.Data;
                        $parent.gogocustomerActpageIndex = pageIndex;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#permissions/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.gogoclients = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
        }
        $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
        $scope.load = function () {
            console.log("Call AuthorityManagementCtrl");
        }
        $scope.load();
        //$scope.ShowAddOwnCustomerModal = function () {
        //    $("#addcustomermodal").modal('show');
        //}
        //$scope.AddOwnCustomerSubmit = function (User) {
        //    if ($scope.AddOwnCustomerForm.$valid) {
        //        $scope.showerror = false;
        //        $http.post($resturls["LoadGoGoCustomerList"], {}).success(function (data) {
        //            if (data.Error) {
        //                alert(data.ErrorMessage, 'e');
        //            }
        //            else {

        //            }
        //        })
        //    }
        //    else {
        //        $scope.showerror = true;
        //    }
        //};
    }
}