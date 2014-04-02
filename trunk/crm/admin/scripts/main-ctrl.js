function MainCtrl($scope, $routeParams, $http, $location, $filter, $resturls) {
    //登录
    $scope.UserLogin = function (user) {
        $scope.errormessage = false;
        if ($scope.LoginForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["Login"], { user_name: user.user_name, user_password: user.user_password }).success(function (data) {
                if (data.Data) {
                    window.location.href = "index.html";
                } else {
                    $scope.showerror = true;
                    $scope.errormessage = true;
                }
            }).error(function (data, status, headers, config) {
                alert('error');
            })
        } else {
            $scope.showerror = true;
        }
    }
}