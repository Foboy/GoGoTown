function SaleAnalyzeCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {

    $scope.salesFunnelList = [];

    $scope.displaySalesFunnel = function (sales) {
        var totalHeight = 326;
        var total = 0;
        var colors = ['#F09B2D', '#7AC0A8', '#E74C3C'];
        var titles = ['公海客户', '销售机会', '消费客户'];
        var labelTop = [60, 110, 160, 210, 250];

        for (var i = 0; i < sales.length; i++) {
            total += sales[i];
            var node = {
                style: { background: colors[i], height: 0 },
                labelStyle: { background: colors[i] },
                top: 0,
                labelTop: labelTop[i],
                title: titles[i],
                data: sales[i]
            };
            if ($scope.salesFunnelList[i]) {
                $scope.salesFunnelList[i] = node;
            }
            else {
                $scope.salesFunnelList.push(node);
            }
        }

        total = total <= 0 ? 1 : total;

        var brotherHeight = 16;
        for (var i = 0; i < sales.length; i++) {
            var height = Math.floor((sales[i] / total) * totalHeight);
            $scope.salesFunnelList[i].style.height = height + 'px';
            $scope.salesFunnelList[i].top = Math.floor(brotherHeight + height / 2);
            brotherHeight += height;
        }
    }

    $scope.loadSalesFunnel = function () {
        $http.post($resturls["DisplaySalesFunnel"], { stime: '', etime: '' }).success(function (result) {
            var mshopnum = 1;
            var chancenum = 0;
            var gogonum = 0;
            if (result.Error == 0) {
                mshopnum = result.Data[0].mshop_num;
                chancenum = result.Data[0].chance_num;
                gogonum = result.Data[0].private_gogo_num;
                if (mshopnum == 0 && chancenum == 0 && gogonum == 0) {
                    $scope.displaySalesFunnel([1, 0, 0]);
                } else {
                    $scope.displaySalesFunnel([mshopnum*1, chancenum*1, gogonum*1]);
                }
            } else {
                $scope.displaySalesFunnel([1, 0, 0]);
            }
        })
    }

    $scope.salesFunnel = function () {
        var sales = [1, 0, 0];
        $scope.displaySalesFunnel(sales);
        $scope.loadSalesFunnel();

    }
    $scope.salesFunnel();
}