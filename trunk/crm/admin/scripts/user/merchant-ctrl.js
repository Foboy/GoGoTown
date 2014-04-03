function MerchantInfoMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.load = function () {
        console.log("Call MerchantInfoMainController");
    }
    $scope.load();
    $scope.GetMerchantInfo = function () {
        $http.post($resturls["GetMerchantInfo"], {}).success(function (data) {
            if (!data.Error) {
                $scope.merchantinfo = data.Data;
            } else {
                $scope.merchantinfo = {};
            }
        });
    }
    $scope.GetMerchantInfo();
    $scope.SaveEditMerchant = function (data) {
        if (!data.name) {
            $scope.Ntype = true;
        }
        if (!data.mobile) {
            $scope.Ctype = true;
        }
        if (!data.address) {
            $scope.Atype = true;
        }
        if ($scope.EditMerchantForm.$valid) {
            $scope.showerror = false;
        }
        else {
            $scope.showerror = true;
        }
    }
}

function MemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
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

    $scope.LoadMemberShipLeveList();
}

function AddMemberShipLevelCtrl($scope, $http, $location, $routeParams, $resturls) {
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
}