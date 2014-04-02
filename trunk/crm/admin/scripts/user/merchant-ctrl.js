function MerchantMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.load = function () {
        console.log("Call MerchantController");
    }
    $scope.load();
    $scope.SaveEditMerchant = function (data) {
        console.log($scope.EditMerchantForm.$valid);
        if ($scope.EditMerchantForm.$valid) {
            $scope.showerror = false;
            //            $http.post($resturls["EditMerchantInfo"], { user_name: data.user_name, shop_id: data.shop_id, user_password_new: data.user_password_new, user_password_repeat: data.user_password_new }).success(function (data) {
            //                if (data.Error) {
            //                    $scope.LoginErrors = data.ErrorMessage;
            //                }
            //                else {
            //                    window.location.href = "index.html";
            //                }
            //            }).
            //            error(function (data, status, headers, config) {
            //                alert("error");
            //            });
        }
        else {
            $scope.showerror = true;
        }
    }
    $scope.GetMerchantInfo = function () {
        $scope.merchantinfo = {
            name: ' GOGO商城',
            desciption: "我们是看天下杂志下属互联网全资子公司",
            telephone: '123233444',
            address: '成都市水碾河55号'
        };
    }
    $scope.GetMerchantInfo();
    $scope.LoadMemberShipLeveList = function () {
        $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (data) {
            if (!data.Error) {
                $scope.mebershiplevels = data.Data;
            } else {
                $scope.mebershiplevels = {};
            }
        });
    }
    $scope.LoadMemberShipLeveList();
    $scope.SaveEditMerberShipLevel = function (data) {
        if (!this.showerror) {
            this.showerror = true;
            return;
        }
        if ($scope.EditLevelForm.$valid) {
            this.showerror = false;
        }
        else {
            this.showerror = true;
        }
    }
}