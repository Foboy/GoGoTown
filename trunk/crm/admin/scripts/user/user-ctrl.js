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


function AddUserAccountCtrl($scope, $http, $location, $routeParams, $resturls) {
    $scope.AddUserAccount = function (data) {
        if ($scope.AddUserAccountForm.$valid) {
            $http.post($resturls["AddUserAccount"], { user_type: data.user_type, user_name: data.user_name, user_password_new: data.user_password_new, user_password_repeat: data.user_password_new }).success(function (result) {
                if (result.Error) {
                    alert("success");
                    $("#AddUsermodal").modal("hide");
                } else {
                    alert(result.ErrorMessage);
                    $scope.showerror = true;
                  
                }
            });
        } else {
            $scope.showerror = true;
        }
    }
};
