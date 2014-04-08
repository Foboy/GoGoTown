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
                $scope.mebershiplevels = [];
            }
        });
    }
    //删除等级
    $scope.DeleteMemberShipLevel = function (data)
    {
        $http.post($resturls["DeleteMemberShipLevel"], { id: data.ID }).success(function (result) {
            if (result.Error == 0) {
                alert("success");
                $scope.LoadMemberShipLeveList();
            } else {
                alert("error");
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
    $scope.AddMemberShipLevelmodal = function (data) {
        $scope.MeberShipLevel = { rank: data + 1 };
        $("#addmeberlevelmodal").modal('show');
    }
    $scope.LoadMemberShipLeveList();
}

function AddMemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    //保存增加会员等级设置
    $scope.SaveAddMemberShipLevel = function (data) {
        if ($scope.AddMemberShipLevelForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddMemberLevels"], { name: data.name }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                    $("#addmeberlevelmodal").modal('hide');
                    $scope.LoadMemberShipLeveList();
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
    }
    //账户列表
    $scope.loadUserAccountSortList = function (pageIndex) {
        var pageSize = 1;
        if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            //店员
            case 'clerk':
                $http.post($resturls["LoadUserAccountList"], { name: '', pageindex: pageIndex - 1, pagesize: pageSize, user_type: 3 }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.clerks = result.Data;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#permissions/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.clerks = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
            case 'cashier': //收银员(手机app)
                $http.post($resturls["LoadUserAccountList"], { name: '', pageindex: pageIndex - 1, pagesize: pageSize, user_type: 2 }).success(function (result) {
                    if (result.Error == 0) {
                        $scope.cashiers = result.Data;
                        $parent.pages = utilities.paging(result.totalcount, pageIndex, pageSize, '#permissions/' + $scope.sorts + '/{0}');
                    } else {
                        $scope.cashiers = [];
                        $parent.pages = utilities.paging(0, pageIndex, pageSize);
                    }
                });
                break;
        }
    }
    //账户列表数据出初始化
    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
    //弹出添加或编辑用户账号窗口
    $scope.ShowAddUserAccountModal = function (data, usertype) {
        console.log(data);
        if (data) {
            $scope.UserAccount = data;
        } else {
            $scope.UserAccount = { user_id: 0, Type: usertype };
        }
        $("#AddUsermodal").modal("show");

    }
    //弹出修改用户账号密码窗口
    $scope.ShowRestUserAccountPwdModal = function (data) {
        $scope.UserInfo = data;
        $("#RestPwdModal").modal("show");
    }
    //启用禁用用户 1 启用 0禁用
    $scope.UpdateUserState = function (data) {
        data.State = data.State == 1 ? 2 : 1;
        $http.post($resturls["UpdateUserState"], { user_id: data.ID, state: data.State }).success(function (result) {
            if (result.Error == 0) {
                alert("success");
                $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
            }
            else {
                alert("error");
                $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
            }
        });
    }
}

function AddUserAccountCtrl($scope, $http, $location, $routeParams, $resturls) {
    //添加账户
    $scope.AddUserAccount = function (data) {
        if ($scope.AddUserAccountForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddUserAccount"], { user_type: data.Type, user_name: data.Name, user_account: data.Account, user_password_new: data.Password, user_password_repeat: data.Password }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
                    $("#AddUsermodal").modal("hide");
                } else {
                    alert(result.ErrorMessage);
                    $scope.showerror = true;
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
    //编辑用户账号
    $scope.EditUserAccount = function (data) {
        if ($scope.AddUserAccountForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["UpdateUserAccount"], { user_type: data.Type, user_name: data.Name, user_account: data.Account, user_password_new: data.Password, user_password_repeat: data.Password }).success(function (result) {
                if (result.Error == 0) {
                    alert("success");
                    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
                    $("#AddUsermodal").modal("hide");
                } else {
                    alert(result.ErrorMessage);
                    $scope.showerror = true;
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
};
//修改密码
function RestPasswordCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.RestPassword = function (data) {
        console.log(data);
        if ($scope.RestPasswordForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["RestPassword"], { user_id: data.ID, user_password_new: data.NewPassword, user_password_repeat: data.NewPassword }).success(function (result) {
                if (result.Error == 0) {
                    alert("success"); 
                    $("#RestPwdModal").modal("hide");
                } else {
                    alert("e");
                    $scope.showerror = true;
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
};