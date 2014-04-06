function UserMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.UserLogin = function (user) {
        $scope.errormessageshow = false;
        if ($scope.LoginForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["Login"], { user_name: user.user_name, user_password: user.user_password }).success(function (result) {
                if (result.Error == 0) {
                    window.location.href = "index.html";
                } else {
                    $scope.showerror = true;
                    $scope.errormessageshow = true;
                }
            }).error(function (data, status, headers, config) {
                alert('error');
            })
        } else {
            $scope.showerror = true;
        }
    }
}



