function MainCtrl($scope, $routeParams, $http, $location, $filter) {
    //登录
    $scope.UserLogin = function () {
        $http.get($sitecore.urls["Login"]).success(function (data) {
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