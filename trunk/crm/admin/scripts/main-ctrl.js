function MainCtrl($scope, $http, $resturls)
{
    $http.post($resturls["login_info"], {}).success(function (data) {
        console.log(data);
        if (data.Error) {
            //alert(data.ErrorMessage);
        }
    }).
    error(function (data, status, headers, config) {
        $scope.CurrentUser = {};
    });
}