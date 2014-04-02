function MerchantMainCtrl($scope, $http, $location, $routeParams) {
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
        $scope.mebershiplevels = [
        {
            level: '1',
            desciption: "砖石会员"
        },
        {
            level: '2',
            desciption: "白金会员"

        },
        {
            level: '3',
            desciption: "黄金会员"
        }
        ,
        {
            level: '4',
            desciption: "白银会员"

        },
        {
            level: '5',
            desciption: "普通会员"
        }
        ]
    }
    $scope.LoadMemberShipLeveList();
    $scope.SaveEditMerberShipLevel = function (data) {
        console.log(data);
        if (!data) {
            $scope.showerror = false;
        }
        else {
            $scope.showerror = true;
        }
    }
}