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
        var pageSize = 5;
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


    //增加客户modal
    $scope.ShowAddOwnCustomerModal = function (data, event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else {
                window.event.cancelBubble = true;
            }
        }
        
        //获取用户等级设置信息
        $scope.GetCustomerMemberShip = function (data) {
            $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (result) {
                if (result.Error == 0) {
                    $scope.mebershiplevels = result.Data;
                    if (data) {
                        if (!data.rank_id) {
                            $scope.choselevel = { Name: "未设置等级", ID: 0 };
                        } else {
                            $scope.choselevel = { Name: data.shoprankname, ID: data.rank_id };
                        }
                    } else {
                        $scope.choselevel = { Name: "未设置等级", ID: 0 };
                    }
                } else {
                    $scope.mebershiplevels = [];
                }
            });
        }
        
        if (data) {
            $scope.OwnCustomer = angular.copy(data);
            $scope.GetCustomerMemberShip($scope.OwnCustomer);
            $scope.OwnCustomer.TimeStamp = $scope.OwnCustomer.Birthady;
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
                    $scope.OwnCustomer.TimeStamp = $scope.strtotimestamp($scope.OwnCustomer.Birthady);
                    console.log($scope.OwnCustomer.TimeStamp);
                });
            });
        } else {
            $scope.GetCustomerMemberShip(null);
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
                    $scope.OwnCustomer.TimeStamp = $scope.strtotimestamp($scope.OwnCustomer.Birthady);
                });
            });
        }
        $("#addcustomermodal").modal('show');
    }
   
    //客户数据详情modal
    $scope.ShowClientDetailModal = function (data, event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else {
                window.event.cancelBubble = true;
            }
        }
        $scope.onecustomer = data;
        $scope.onecustomerspends = [];
        if (data.from_type == 1) {
            $scope.customerage = $scope.CalculateAge(data.Birthady);
            $http.post($resturls["LoadSpendingRecordList"], { sname: '', pay_mothed: 0, customer_id: data.ID, type: 0, create_time1: '', create_time2: '', pageindex: 0, pagesize: 5 }).success(function (result) {
                if (result.Error == 0) {
                    $scope.onecustomerspends = result.Data;
                } else {
                    $scope.onecustomerspends = [];
                }
                $("#owncustomerdetailmodal").modal('show');//自有客户详细弹窗
            });
        } else {
            $http.post($resturls["LoadSpendingRecordList"], { sname: '', pay_mothed: 0, customer_id: data.Customer_ID, type: 0, create_time1: '', create_time2: '', pageindex: 0, pagesize: 5 }).success(function (result) {
                if (result.Error == 0) {
                    $scope.onecustomerspends = result.Data;
                } else {
                    $scope.onecustomerspends = [];
                }
                $("#gogocustomerdetailmodal").modal('show');//gogo客户详细弹窗
            });
        }
    }
    //给gogo发送信息modal
    $scope.ShowSendMessageModal = function (data, event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else {
                window.event.cancelBubble = true;
            }
        }
        $scope.message = data;
        $("#SendMessageMoadl").modal('show');
    }
    //弹出删除自有客户modal
    $scope.ShowDeleteOwnCustomerModal = function (data,event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else {
                window.event.cancelBubble = true;
            }
        }
        $scope.ownclient = data;
        $("#DeleteOwnCustomerModal").modal('show');
    }
    //弹出设置会员等级(暂时gogo客户在用)
    $scope.ShowSetMemberShipLevel = function (data, event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else { 
                window.event.cancelBubble = true;
            }
        }
        //获取用户等级设置信息
        $scope.GetCustomerMemberShip = function (data) {
            $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (result) {
                if (result.Error == 0) {
                    $scope.mebershiplevels = result.Data;
                    if (data) {
                        if (!data.rank_id) {
                            $scope.choselevel = { Name: "未设置等级", ID: 0 };
                        } else {
                            $scope.choselevel = { Name: data.shoprankname, ID: data.rank_id };
                        }
                    } else {
                        $scope.choselevel = { Name: "未设置等级", ID: 0 };
                    }
                } else {
                    $scope.mebershiplevels = [];
                }
            });
        }
        $scope.GetCustomerMemberShip(data);
        $scope.oneclient = data;
        $("#SetMemeberShipModal").modal('show');
    }
}

//增加自有客户scope
function AddOwnCustomerCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    $scope.ChoseCustomerRank = function (data) {
        $scope.choselevel = { Name: data.Name,ID:data.ID };
    };
    $scope.SaveAddOwnCustomer = function (data, choselevel) {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddOwnCustomer"], { name: data.Name, sex: data.Sex, phone: data.Phone, birthday: data.TimeStamp, remark: data.Remark }).success(function (result) {
                $("#addcustomermodal").modal('hide');
                if (result.Error == 0) {
                    $.scojs_message('新增成功', $.scojs_message.TYPE_OK);
                    $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.parameters || '');
                    if (choselevel.ID != 0) {
                        $http.post($resturls["SetCustomerRank"], { rank_id: choselevel.ID, from_type: result.from_type, customer_id: result.ID }).success(function (result) {
                            console.log(result);
                        });
                    }
                }
                else {
                    $scope.showerror = true;
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                }
            })
        }
        else {
            $scope.showerror = true;
        }
    };
    //跟新自有客户信息
    $scope.UpdateOwnCustomer = function (data, choselevel) {
        if ($scope.AddOwnCustomerForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["SetCustomerRank"], { rank_id: choselevel.ID, from_type: data.from_type,customer_id:data.ID }).success(function (result) {
                console.log(result);
            })
            $http.post($resturls["UpdateOwnCustomer"], { name: data.Name, sex: data.Sex, phone: data.Phone, birthday: data.TimeStamp, remark: data.Remark, customer_id: data.ID }).success(function (result) {
             
                $("#addcustomermodal").modal('hide');
                if (result.Error == 0) {
                    $.scojs_message('更新成功', $.scojs_message.TYPE_OK);
                    $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.parameters || '');
                }
                else {
                    $scope.showerror = true;
                    $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                }
            })
        }
        else {
            $scope.showerror = true;
        }
    }
}

//发送信息scope
function SendMessageCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.SendMessage = function (data) {
        if ($scope.SendMessageForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["SensMessage"], { customer_ids: data.Customer_ID, title: data.Content, content: data.Content }).success(function (result) {
                $("#SendMessageMoadl").modal('hide');
                if (result.Error == 0) {
                    $.scojs_message('发送成功', $.scojs_message.TYPE_OK);
                } else {
                    $scope.showerror = true;
                    $.scojs_message(result.ErrorMessage,$.scojs_message.TYPE_ERROR);
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
}

//删除自有客户scope
function DeleteOwnCustomerCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.DeleteOwnCustomer = function (data) {
        $http.post($resturls["DeleteOwnCustomer"], { customer_id: data.customer_id }).success(function (result) {
            $("#DeleteOwnCustomerModal").modal('hide');
            if (result.Error == 0) {
                $.scojs_message('删除成功', $.scojs_message.TYPE_OK);
                $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.paramters || '');
            } else {
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        });
    }
}

function SetMemeberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.ChoseMemberRank = function (data) {
        $scope.choselevel = { Name: data.Name, ID: data.ID };
    };
    $scope.SaveSetMemeberShipLevel = function (data, choselevel) {
        console.log(data);
        $http.post($resturls["SetCustomerRank"], { rank_id: choselevel.ID, from_type: data.from_type, customer_id: data.Customer_ID }).success(function (result) {
            $("#SetMemeberShipModal").modal('hide');
            if (result.Error == 0) {
                $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.parameters || '');
                $.scojs_message('设置成功', $.scojs_message.TYPE_OK);
            } else {
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        })
    }
}

