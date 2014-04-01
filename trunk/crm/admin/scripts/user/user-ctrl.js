function UserRegisterMainCtrl($scope, $http) {
    $scope.Register = function (data) {
        $http.post($sitecore.urls["Register"], { user_name: data.user_name, shop_id: data.shop_id, user_password_new: data.user_password_new, user_password_repeat: data.user_password_repeat }).success(function (data) {
            console.log(data);
            if (data.Error) {
                $scope.LoginErrors = data.ErrorMessage;
            }
            else {
                console.log(data);
                //window.location.href = "index.html";
            }
        }).
            error(function (data, status, headers, config) {
                alert("error");
            })
    }
}