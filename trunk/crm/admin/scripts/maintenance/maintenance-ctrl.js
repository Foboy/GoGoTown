﻿//客户维护scope
function MaintenanceCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
    var $parent = $scope.$parent;
    $scope.choselevel = $rootScope.selectedLevel;
    $scope.show = $rootScope.dropShow;
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
    //查询gogo客户列表
    $scope.LoadGogoCustomerList = function (pageIndex, rankId) {
        if (!rankId) rankId = 0;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadGoGoCustomerList"], { rank_id: rankId, name: "", phone: "", sex: 0, pageindex: pageIndex - 1, pagesize: 15, type: 3, create_time1: '', create_time2: '' }).success(function (result) {
            if (result.Error == 0) {
                $scope.gogoclients = result.Data;
                $parent.gogocustomerActpageIndex = pageIndex;
                $parent.pages = utilities.paging(result.totalcount, pageIndex, 2, '#maintenance/' + '{0}');
            } else {
                $scope.gogoclients = [];
                $parent.pages = utilities.paging(0, pageIndex, 2);
            }
        });
    }
    $scope.ChoseCustomerRank = function (data) {
        $scope.choselevel = data;
        $rootScope.selectedLevel = data;
        $scope.LoadGogoCustomerList(1, data.ID);
    };
    $scope.ShowLevel = function (data) {
        $rootScope.dropShow = true;
        $scope.show = true;
        $scope.LoadGogoCustomerList(1, data.ID);
    }
    $scope.ChoseLoadGogoCustomerList = function () {
        $scope.LoadGogoCustomerList(1, 0);
        $scope.show = false;
        $rootScope.dropShow = false;
    }
    $scope.LoadMemberShipLeveList();
    $scope.LoadGogoCustomerList($routeParams.pageIndex || 1, 0);

    //发送消息
    $scope.SendMessage = function (data, message) {
        var random_picid = "";
        for (var i = 0; i < 10; i++) {
            random_picid += Math.floor(Math.random() * 10);
        }
        if (data) {
            if (data.length > 0) {
                var customerids = "";
                for (var i = 0; i < data.length; i++) {
                    customerids = data[i].Customer_ID + ',' + customerids;
                }
                customerids = $scope.trimEnd(customerids, ',');
                if ($scope.SendGogoMessageForm.$valid) {
                    $scope.showerror = false;
                    $http.post($resturls["SendMessage"], { customer_ids: customerids, title: message.content, content: message.content, pic_id: random_picid, pic_url: $("#imagezone").attr("src") }).success(function (result) {
                        if (result.Error == 0) {
                            $.scojs_message('发送成功', $.scojs_message.TYPE_OK);
                            $("#SendMessageMoadl").modal('hide');
                        } else if (result.Error == 3) {
                            $scope.showerror = true;
                            $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
                        }
                        else {
                            $scope.showerror = true;
                            $.scojs_message(result.ErrorMessage, $.scojs_message.TYPE_ERROR);
                        }
                    });
                } else {
                    $scope.showerror = true;
                }
            } else {
                return;
            }
        } else {
            return;
        }
    }

    $scope.UpLoadImage = function () {
        $('#file_upload').uploadify({
            'swf': 'js/plugins/uploadify/uploadify.swf',
            'uploader': $resturls['UpLoadImage'],
            'buttonText': '',
            'width': 91,
            'height':91,
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
}