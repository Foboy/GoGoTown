//数据统计scope
function DataStatisticsCtrl($scope, $http, $location, $routeParams, $resturls) {
    //商家销售总额趋势图（最近7天 一个月 时间区间显示 横坐标时间以天为单位）
    $scope.SaleTotalTrendGraph = function (type, starttime, endtime) {
        var Datas = [];
        switch (type) {
            case 1://昨日今日
                var twodaysData = {
                    today: [[0, 0], [2, 0], [3, 0], [4, 0], [7, 100], [9, 700], [10, 1500], [11, 3000], [12, 3200], [13, 4000], [14, 4300], [16, 4500], [17, 5000], [19, 6000], [24, 7000]],
                    yesterday: [[0, 110.0], [2, 200], [3, 400], [4, 800], [7, 900], [9, 1000], [10, 2500], [11, 3000], [12, 3200], [13, 4000], [14, 4300], [16, 5000], [17, 6000], [19, 8000], [24, 10000]]
                };
                Datas = [{ label: "今日销售总额", data: twodaysData.today, color: "#1ABC9C" }, { label: "昨日销售总额", data: twodaysData.yesterday, color: "#fa787e" }];
                break;
            case 2://最近七日
                var weekDatas = [[1, 7000], [2, 9000], [3, 6000], [4, 6000], [5, 4000], [6, 9000], [7, 15000]];
                Datas = [{ label: "最近七天销售总额", data: weekDatas, color: "#1ABC9C" }];
                break;
            case 3://最近一月
                var monthDatas = [[1, 7000], [2, 9000], [3, 6000], [4, 6000], [5, 4000], [6, 9000], [7, 15000], [8, 6000], [9, 4000], [10, 7000], [11, 9000], [12, 10000], [13, 18000], [14, 15000], [15, 6000], [16, 4000], [17, 4000], [18, 7000], [19, 9000], [20, 9000], [21, 9000], [22, 15000], [23, 6000], [24, 4000], [25, 7000], [26, 9000], [27, 9000], [28, 15000], [29, 6000], [30, 4000], [31, 7000]];
                Datas = [{ label: "最近一月销售总额", data: monthDatas, color: "#1ABC9C" }];
                break;
            default:
                var monthDatas = [[1, 7000], [2, 9000], [3, 6000], [4, 6000], [5, 4000], [6, 9000], [7, 15000], [8, 6000], [9, 4000], [10, 7000], [11, 9000], [12, 10000], [13, 18000], [14, 15000], [15, 6000], [16, 4000], [17, 4000], [18, 7000], [19, 9000], [20, 9000], [21, 9000], [22, 15000], [23, 6000], [24, 4000], [25, 7000], [26, 9000], [27, 9000], [28, 15000], [29, 6000], [30, 4000], [31, 7000]];
                Datas = [{ label: "最近一月销售总额", data: monthDatas, color: "#1ABC9C" }];
                break;
        }

        var options = {
            series: {
                lines: {
                    show: true
                },
                points: {
                    show: true
                }
            },
            xaxis: {
                tickSize: 1,
                tickFormatter: function (rule) {
                    if (type == 1) {
                        return rule + '时';
                    } else {
                        return rule + '日';
                    }
                }
            },  //指定固定的显示内容
            yaxis: {
                ticks: 5,
                tickFormatter: function (rule) {
                    if (rule > 10000) {
                        return rule / 10000 + '万';
                    } else {
                        return rule + '元';
                    }
                },
                min: 0
            },  //在y轴方向显示5个刻度，此时显示内容由 flot 根据所给的数据自动判断
            grid: {
                hoverable: true
            },
            shadowSize: 10,
            tooltip: true,
            tooltipOpts: {
                content: "%x的销售总额：%y",
                shifts: {
                    x: -60,
                    y: 25
                }
            }
        }
        $.plot($("#flot-line-chart"), Datas, options);
    }

    //消费同比饼图gogo客户
    $scope.ConsumerYear = function () {
        var data = [{
            label: "20以下",
            data: 12
        }, {
            label: "20-23",
            data: 25
        }, {
            label: "24-26",
            data: 33
        }, {
            label: "27-30",
            data: 43
        }, {
            label: '34以上',
            data: 25
        },{
            label: '其他',
            data: 25
        }];
        var options = {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        }
        $.plot($("#flot-pie-chart"), data, options);
    }

    //柱状图（收银员销售情况）
    $scope.CashierSaleBarChart = function () {
        var barOptions = {
            series: {
                bars: {
                    show: true,
                    barWidth: 12000000
                }
            },
            xaxis: {
                tickSize: 1,
                tickFormatter: function (rule) {
                    if (type == 1) {
                        return rule + '时';
                    } else {
                        return rule + '日';
                    }
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "x: %x, y: %y"
            }
        };
        var barData = {
            label: "收银员销售情况",
            data: [
                [1, 1000],
                [2, 2000],
                [3, 3000],
                [4, 4000],
                [5, 5000],
                [6, 6000]
            ]
        };
        $.plot($("#flot-bar-chart"), [barData], barOptions);
    }
    $scope.CashierSaleBarChart();
    $scope.ConsumerYear();
    $scope.SaleTotalTrendGraph(1);
}