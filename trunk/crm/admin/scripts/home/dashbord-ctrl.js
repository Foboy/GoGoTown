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
        }, {
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
    $scope.CashierSaleBarChart = function (type, starttime, endtime) {
        var Datas = [];
        switch (type) {
            case 1://今日
                $scope.CashierSaleConditionChose="今日"
                var todayDatas = [[0, 7000], [2, 9000], [4, 6000], [6, 6000], [8, 4000], [10, 9000], [12, 15000], [14, 15000], [16, 15000]];
                Datas = [{ label: "收银员今日销售情况", data: todayDatas, color: '#1ABC9C' }];
                break;
            case 2://昨日
                $scope.CashierSaleConditionChose = "昨日";
                var yesterdayDatas = [[0, 4000], [2, 12000], [4, 6000], [6, 6000], [8, 8000], [10, 9000], [12, 15000], [14, 15000], [16, 8000]];
                Datas = [{ label: "收银员昨日销售情况", data: yesterdayDatas, color: "#1ABC9C" }];
                break;
            case 3://最近七天
                $scope.CashierSaleConditionChose = "最近一周";
                var weekDatas = [[0, 6000], [2, 1200], [4, 3000], [6, 6000], [8, 7000], [10, 9000], [12, 1500], [14, 15000], [16, 3000]];
                Datas = [{ label: "收银员近一周销售总额", data: weekDatas, color: "#1ABC9C" }];
                break;
            case 4://最近一个月
                $scope.CashierSaleConditionChose = "最近一个月";
                var monthDatas = [[0, 3000], [2, 5000], [4, 4000], [6, 6000], [8, 7000], [10, 12000], [12, 3000], [14, 6000], [16, 3000]];
                Datas = [{ label: "收银员近一月销售总额", data: monthDatas, color: "#1ABC9C" }];
                break;
            default:
                $scope.CashierSaleConditionChose = "今日"
                var todayDatas = [[0, 7000], [2, 9000], [4, 6000], [6, 6000], [8, 4000], [10, 9000], [12, 15000], [14, 15000], [16, 15000]];
                Datas = [{ label: "收银员今日销售情况", data: todayDatas, color: '#1ABC9C' }];
                break;
        }
        var names = ['王晓', '杨超', '陈锐', '小强', '小宝', '小李子', '小飞刀', '小勺子', '小品'];
        var barOptions = {
            series: {
                bars: {
                    show: true,
                    barWidth: 1
                }
            },
            xaxis: {
                labelWidth: 10,
                tickFormatter:function(number,obj){
                    return names[number / this.tickSize];
                },
                tickSize: 2,
                min: 0
            },
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
            },
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
        };
        $.plot($("#flot-bar-chart"), Datas, barOptions);
    }

    $scope.ConsumerYear();
    $scope.SaleTotalTrendGraph(1);
    $scope.CashierSaleBarChart(1);
}