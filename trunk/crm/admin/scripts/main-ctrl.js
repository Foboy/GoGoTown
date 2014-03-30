function MainCtrl($scope, $routeParams, $http, $location, $filter) {
    //登录
    $scope.UserLogin = function (user) {
        $http.get($sitecore.urls["Login"], { user_name: user.user_name, user_password: user.user_password }).success(function (data) {
            if (data.Error) {
                console.log(data);
            } else {
                console.log(data);
            }
        }).error(function (data, status, headers, config) {
            alert('error');
        })
    }
}