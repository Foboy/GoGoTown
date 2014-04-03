function MerchantInfoMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.load = function () {
        console.log("Call MerchantInfoMainController");
    }
    $scope.load();
    //获取商家信息
    $scope.GetMerchantInfo = function () {
        $http.post($resturls["GetMerchantInfo"], {}).success(function (result) {
            if (result.Error==0) {
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
        //if (!data.mobile) {
        //    $scope.Ctype = true;
        //}
        //if (!data.address) {
        //    $scope.Atype = true;
        //}
        if ($scope.EditMerchantForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["EditMerchantInfo"], { name: data.name }).success(function (result) {
                if (result.Error==0) {
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
            if (result.Error==0) {
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
        //$parent.enterpriseActPageIndex = 1;
    } 
    else {
        // $parent.personalActPageIndex = 1;
    }
    $scope.loadCurrentSortList = function (pageIndex) {
        // if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'clerk': //店员
                $http.post($resturls["LoadGoGoCustomerList"], { name: '', phone: '', sex: 0, pageindex: pageIndex }).success(function (data) {
                    if (data.Error != 0) {
                        alert(data.ErrorMessage, 'e');
                    } else {
                        $scope.enterpriseclients = data.Data;
                        console.log($scope.enterpriseclients);
                        $parent.enterpriseActPageIndex = pageIndex;
                        //$parent.pages = utilities.paging(data.Data.RecordsCount, pageIndex, 10, '#client/' + $scope.sorts + '/{0}');
                    }
                }).error(function (data, status, headers, config) {
                    $scope.enterpriseclients = [];
                })
                break;
            case 'app': //��ȡgogo��ѿͻ�
                $http.post($resturls["LoadOwnCustomersList"], { name: '', phone: '', sex: 0, pageindex: pageIndex }).success(function (data) {
                    if (data.Error) { alert(data.ErrorMessage, 'e'); } else {
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
        console.log("Call AuthorityManagementCtrl");
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