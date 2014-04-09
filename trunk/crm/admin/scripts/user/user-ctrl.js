function UserMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.UserLogin = function () {
        $scope.errormessageshow = false;
        if ($scope.LoginForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["Login"], { user_name: $scope.User.user_name, user_password: $scope.User.user_password }).success(function (result) {
                if (result.Error == 0) {
                    $.pagePreLoading('index.html', function () {
                        window.location.href = "index.html";
                    });
                } else {
                    $scope.showerror = true;
                    $scope.errormessageshow = true;
                }
            }).error(function (data, status, headers, config) {
                alert('error');
            }).lock({ selector: '#loginBox' })
        } else {
            $scope.showerror = true;
        }
    }
    $(document).keyup(function (e) {
        if (e.keyCode == 13) {
            $scope.$apply(function () {
                $scope.UserLogin();
            });
        }
    });
}



