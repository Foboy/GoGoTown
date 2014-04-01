function UserRegisterMainCtrl($scope, $http) {
    $scope.Register = function (data) {
        if ($scope.RegisterForm.$valid) {
            $http.post($sitecore.urls["Register"], { user_name: data.user_name, shop_id: data.shop_id, user_password_new: data.user_password_new, user_password_repeat: data.user_password_new }).success(function (data) {
                if (data.Error) {
                    $scope.LoginErrors = data.ErrorMessage;
                }
                else {
                    window.location.href = "index.html";
                }
            }).
            error(function (data, status, headers, config) {
                alert("error");
            });
        }
        else {
            $scope.showerror = true;
        }
    }
}