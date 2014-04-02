function MainCtrl($scope, $routeParams, $http, $location, $filter) {
    //登录
    $scope.UserLogin = function (user) {
        if ($scope.LoginForm.$valid) {
            $scope.showerror = false;
            $http.post($sitecore.urls["Login"], { user_name: user.user_name, user_password: user.user_password }).success(function (data) {
                if (data.Error) {
                    window.location.href = "index.html";
                } else {
                    window.location.href = "index.html";
                }
            }).error(function (data, status, headers, config) {
                alert('error');
            })
        } else {
            $scope.showerror = true;
        }
    }
}