function UserMainCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.Register = function (data) {
        if ($scope.RegisterForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["Register"], { user_name: data.user_name, shop_id: data.shop_id, user_password_new: data.user_password_new, user_password_repeat: data.user_password_new }).success(function (data) {
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
    $scope.UserLogin = function (user) {
        $scope.errormessageshow = false;
        if ($scope.LoginForm.$valid) {
            $scope.showerror = false;
            $http.post($resturls["Login"], { user_name: user.user_name, user_password: user.user_password }).success(function (result) {
                if (result.Error == 0) {
                    console.log(result);
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
