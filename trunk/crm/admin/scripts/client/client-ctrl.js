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
    $scope.GetCustomerMemberShip = function () {
        $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (result) {
            if (result.Error == 0) {
                $scope.mebershiplevels = result.Data;
            } else {
                $scope.mebershiplevels = [];
            }
            if ($scope.mebershiplevels.length == 0) {
                $scope.choselevel = { Name: "未设置等级", ID: 0 };
            } else {
                $scope.choselevel = $scope.mebershiplevels[0];
            }
        });
    }
    $scope.GetCustomerMemberShip();
    $scope.ChoseMemberRank = function (data) {
        $scope.choselevel = { Name: data.Name, ID: data.ID };
    };
    //客户
    $scope.loadClientSortList = function (pageIndex, parameters, choselevel) {
        var rank_id = 0;
        if (choselevel != null)
        {
            rank_id = choselevel.ID;
        }
        var pageSize = 15;
        if (pageIndex == 0) pageIndex = 1;
        switch ($scope.sorts) {
            case 'owncustomer':
                $http.post($resturls["LoadOwnCustomersList"], { rank_id: rank_id, name: parameters, phone: parameters, sex: 0, pageindex: pageIndex - 1, pagesize: pageSize,create_time1:'',create_time2:'' }).success(function (result) {
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
                $http.post($resturls["LoadGoGoCustomerList"], { rank_id: rank_id, name: parameters, phone: parameters, sex: 0, type: 3, pageindex: pageIndex - 1, pagesize: pageSize, create_time1: '', create_time2: '' }).success(function (result) {
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
    $scope.SearchClientSortList = function (condtion, choselevel) {
        $scope.loadClientSortList(1, condtion, choselevel);
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
                        if (!data.rank_id || data.rank_id == 0) {
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
    $scope.ShowDeleteOwnCustomerModal = function (data, event) {
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
                        if (!data.rank_id || data.rank_id == 0) {
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
    //checkbox选中对象
    $scope.toggle = function (data, event) {
        if (event != undefined) {
            if (event && event.stopPropagation) {
                event.stopPropagation();
            }
            else {
                window.event.cancelBubble = true;
            }
        }
        data.checked = !data.checked;
    }
    //弹出批量设置会员等级
    $scope.ShowBatchSetMemberShipLevel = function () {
        //获取等级设置信息
        $scope.GetCustomerMemberShip = function () {
            $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (result) {
                if (result.Error == 0) {
                    $scope.mebershiplevels = result.Data;
                } else {
                    $scope.mebershiplevels = [];
                }
                if ($scope.mebershiplevels.length == 0) {
                    $scope.choselevel = { Name: "未设置等级", ID: 0 };
                } else {
                    $scope.choselevel = $scope.mebershiplevels[0];
                }
            });
        }
        $scope.GetCustomerMemberShip();
        $("#BacthSetMemeberShipModal").modal('show');
    }
}

//增加自有客户scope
function AddOwnCustomerCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    $scope.ChoseCustomerRank = function (data) {
        $scope.choselevel = { Name: data.Name, ID: data.ID };
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
            $http.post($resturls["SetCustomerRank"], { rank_id: choselevel.ID, from_type: data.from_type, customer_id: data.ID }).success(function (result) {
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
    $scope.UpLoadImage = function () {
        $('#file_upload').uploadify({
            'swf': 'js/plugins/uploadify/uploadify.swf',
            'uploader': $resturls['UpLoadImage'],
            'buttonText': '',
            'width': 91,
            'height': 91,
            'buttonClass': 'img-thumbnail upload_btn_css',
            'fileSizeLimit': '2048kB',
            'fileTypeExts': '*.jpg;*.gif;*.png',
            'fileTypeDesc': 'Web Image Files (.JPG, .GIF, .PNG)',
            onUploadSuccess: function (fileObj, data, response) {
                var result = $.parseJSON(data);
                if (result.status == 1) {
                    $.scojs_message('上传完成!', $.scojs_message.TYPE_OK);
                    $("#imagezone").attr('src', $.trim(result.data.uploadResult.url));
                    $scope.$apply(function () {
                        $scope.showing = true;
                    });
                } else {
                    $.scojs_message('服务器忙，请稍后重试!', $.scojs_message.TYPE_ERROR);
                }
            },
            onSelectError: function (file, errorCode, errorMsg) {
                switch (errorCode) {
                    case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                        $.scojs_message('上传文件不能超过2MB', $.scojs_message.TYPE_ERROR);
                        break;
                    case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                        $.scojs_message('不能上传空文件', $.scojs_message.TYPE_ERROR);
                        break;
                }
            }
        });
    }
    $scope.DeleteUpLoadImage = function () {
        $scope.showing = false;
    }
    $scope.UpLoadImage();
    $scope.SendMessage = function (data) {
        var random_picid="";
        for(var i=0;i<10;i++){
            random_picid+=Math.floor(Math.random()*10);
        }
        if ($scope.SendMessageForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["SendMessage"], { customer_ids: data.Customer_ID, title: data.Content, content: data.Content, pic_id: random_picid, pic_url: $("#imagezone").attr("src") }).success(function (result) {
                $("#SendMessageMoadl").modal('hide');
                if (result.Error == 0) {
                    $.scojs_message('发送成功', $.scojs_message.TYPE_OK);
                } else {
                    $scope.showerror = true;
                    $.scojs_message("服务器忙，请稍后重试!", $.scojs_message.TYPE_ERROR);
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

//设置会员等级scope
function SetMemeberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.ChoseMemberRank = function (data) {
        $scope.choselevel = { Name: data.Name, ID: data.ID };
    };
    $scope.SaveSetMemeberShipLevel = function (data, choselevel) {
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
    //批量设置会员等级
    $scope.SaveBatchSetMemeberShipLevel = function (data, choselevel) {
        var type = 1;
        type = $scope.sorts == 'gogocustomer' ? 2 : type;
        //$http.post($resturls["SetCustomerRank"], { rank_id: choselevel.ID, from_type: type, customer_id: data.Customer_ID }).success(function (result) {
        //    $("#BacthSetMemeberShipModal").modal('hide');
        //    if (result.Error == 0) {
        //        $scope.loadClientSortList($routeParams.pageIndex || 1, $routeParams.parameters || '');
        //        $.scojs_message('设置成功', $.scojs_message.TYPE_OK);
        //    } else {
        //        $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
        //    }
        //})
    }
}

