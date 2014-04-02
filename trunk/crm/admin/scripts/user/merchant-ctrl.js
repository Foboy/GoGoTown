function MerchantInfoMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.load = function () {
        console.log("Call MerchantInfoMainController");
    }
    $scope.load();
    $scope.SaveEditMerchant = function (data) {
        console.log($scope.EditMerchantForm.$valid);
        if ($scope.EditMerchantForm.$valid) {
            $scope.showerror = false;
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
}

function MemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls)
{
    $scope.LoadMemberShipLeveList = function () {
        $http.post($resturls["SearchMerchantSetLevels"], {}).success(function (data) {
            if (!data.Error) {
                $scope.mebershiplevels = data.Data;
            } else {
                $scope.mebershiplevels = {};
            }
        });
    }
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
    $scope.ShowAddMemberShipLevel = function () {
        $("#addmeberlevelmodal").modal('show');
    }
    $scope.SaveAddMemberShipLevel = function (memberlevel) {
        if ($scope.AddMemberShipLevelForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["AddMemberLevels"], { rank: 6, name: memberlevel.name, remark: '' }).success(function (data) {
                if (!data.Error) {
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
    $scope.LoadMemberShipLeveList();
}