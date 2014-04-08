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

    $scope.LoadGogoCustomerList = function (pageIndex, rankId) {
        if (!rankId) rankId = 0;
        if (pageIndex == 0) pageIndex = 1;
        $http.post($resturls["LoadOwnCustomersList"], { rank_id: rankId, name: "", phone: "", sex: 0, pageindex: pageIndex - 1, pagesize: 2 }).success(function (result) {
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

    $scope.SendMessage = function (data,message) {
        if (data) {
            if (data.length > 0) {
                var customerids = "";
                for (var i = 0; i < data.length; i++) {
                    customerids = data[i].customer_id + ',' + customerids;
                }
                customerids = $scope.trimEnd(customerids, ',');
                if ($scope.SendGogoMessageForm.$valid) {
                    $scope.showerror = false;
                    $http.post($resturls["SensMessage"], { customer_ids: customerids, title: message.content, content: message.content }).success(function (result) {
                        if (result.Error == 0) {
                            alert("scuccess");
                            $("#SendMessageMoadl").modal('hide');
                        } else {
                            $scope.showerror = true;
                            alert(result.ErrorMessage);
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
    $scope.trimEnd = function (temp,str) {
        if (!str) { return temp; }
        while (true) {
            if (temp.substr(temp.length - str.length, str.length) != str) {
                break;
            }
            temp = temp.substr(0, temp.length - str.length);
        }
        return temp;
    }
}