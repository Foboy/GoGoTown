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
                    $.scojs_message('修改成功', $.scojs_message.TYPE_OK);
                    setTimeout("location.reload()", 2000);
                }
                else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
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
                    $.scojs_message('保存成功', $.scojs_message.TYPE_OK);
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
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
    //弹出删除会员等级确认框
    $scope.DeleteMemberShipLevelModal = function (data) {
        $scope.mebershiplevel = data;
        $("#DeleteLevelModal").modal('show');

    }
    //弹出修改会员等级名称框
    $scope.EditMembershipNameModal = function (data) {
        $scope.Eidtmebershiplevel = data;
        $("#editmeberlevelmodal").modal('show');
    }
    $scope.LoadMemberShipLeveList();
}

function AddMemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    //保存增加会员等级设置
    $scope.SaveAddMemberShipLevel = function (data) {
        if ($scope.AddMemberShipLevelForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddMemberLevels"], { name: data.name }).success(function (result) {
                $("#addmeberlevelmodal").modal('hide');
                if (result.Error == 0) {
                    $.scojs_message('新增成功', $.scojs_message.TYPE_OK);
                    $scope.LoadMemberShipLeveList();
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                }
            })
        } else {
            $scope.showerror = true;
        }
    }
}

function EditMemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    //保存编辑会员等级名称
    $scope.SaveEditMemberShipLevel = function (data) {
        if ($scope.EditMemberShipLevelForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["UpdateRankName"], { rank_id: data.ID, rank_name: data.Name }).success(function (result) {
                $("#editmeberlevelmodal").modal('hide');
                if (result.Error == 0) {
                    $.scojs_message('编辑成功', $.scojs_message.TYPE_OK);
                    $scope.LoadMemberShipLeveList();
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                }
            })
        } else {
            $scope.showerror = true;
        }
    }
}

function AuthorityManagementCtrl($scope, $rootScope, $http, $location, $routeParams, $resturls) {
    var $parent = $scope.$parent;
    $scope.sorts = $routeParams.sorts;
    if (!$scope.sorts) {
        $scope.sorts = "clerk";
    }
    //账户列表
    $scope.loadUserAccountSortList = function (pageIndex) {
        var pageSize = 15;
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
        if (data) {
            $scope.UserAccount = data;
        } else {
            $scope.UserAccount = { user_id: 0, Type: usertype };
        }
        $("#AddUsermodal").modal("show");
        $rootScope.$broadcast("ShowAddUserAccountModalEvent");
    }
    //弹出修改用户账号密码窗口
    $scope.ShowRestUserAccountPwdModal = function (data) {
        $scope.UserInfo = data;
        $("#RestPwdModal").modal("show");
    }
    //弹出用户禁用启用确认框
    $scope.ShowUpdateUserStateModel = function (data) {
         $scope.Userinfos = data;
        $("#ChangeStateModal").modal("show");
    }
    //编辑用户姓名
    $scope.ShowEditUserNameModal = function (data) {
        $scope.OneUser= data;
        $("#EditUsermodal").modal("show");
    }
    
}

function AddUserAccountCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.$on("ShowAddUserAccountModalEvent", function () {
        $scope.showerror = false;
    });
    //添加账户
    $scope.AddUserAccount = function (data) {
        if ($scope.AddUserAccountForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddUserAccount"], { user_type: data.Type, user_name: data.Name, user_account: data.Account, user_password_new: data.Password, user_password_repeat: data.Password }).success(function (result) {
                $("#AddUsermodal").modal("hide");
                if (result.Error == 0) {
                    $.scojs_message('添加成功', $.scojs_message.TYPE_OK);
                    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
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
                $("#AddUsermodal").modal("hide");
                if (result.Error == 0) {
                    $.scojs_message('编辑成功', $.scojs_message.TYPE_OK);
                    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                    $scope.showerror = true;
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
    //编辑用户账号姓名
    $scope.EditUserName = function (data) {
        if ($scope.EditUserNameForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["UpdateUserName"], { user_id: data.ID, name: data.Name }).success(function (result) {
                $("#EditUsermodal").modal("hide");
                if (result.Error == 0) {
                    $.scojs_message('编辑成功', $.scojs_message.TYPE_OK);
                    $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
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
        if ($scope.RestPasswordForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["RestPassword"], { user_id: data.ID, user_password_new: data.NewPassword, user_password_repeat: data.NewPassword }).success(function (result) {
                $("#RestPwdModal").modal("hide");
                if (result.Error == 0) {
                    $.scojs_message('修改成功', $.scojs_message.TYPE_OK);
                } else {
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                    $scope.showerror = true;
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
};


function UpdateUserStateCtrl($scope, $http, $location, $routeParams, $resturls) {
    //启用禁用用户 2 启用 1禁用
    $scope.UpdateUserState = function (data) {
        data.State = data.State == 1 ? 2 : 1;
        $http.post($resturls["UpdateUserState"], { user_id: data.ID, state: data.State }).success(function (result) {
            $("#ChangeStateModal").modal("hide");
            if (result.Error == 0) {
                $.scojs_message('操作成功', $.scojs_message.TYPE_OK);
                $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
            }
            else {
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                $scope.loadUserAccountSortList($routeParams.pageIndex || 1);
            }
        });
    }
};

function DeleteMemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    //删除等级
    $scope.DeleteMemberShipLevel = function (data) {
        $http.post($resturls["DeleteMemberShipLevel"], { id: data.ID }).success(function (result) {
            $("#DeleteLevelModal").modal('hide');
            if (result.Error == 0) {
                $.scojs_message('删除成功', $.scojs_message.TYPE_OK);
                $scope.LoadMemberShipLeveList();
            } else {
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        });
    }
}