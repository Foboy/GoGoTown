//数据统计scope
function DataStatisticsCtrl($scope, $http, $location, $routeParams, $resturls) {
    //商家销售总额趋势图（最近7天 一个月 时间区间显示 横坐标时间以天为单位）
    $scope.SaleTotalTrendGraph = function (type) {
        var Datas = [];
        switch (type) {
            case 1://昨日今日
                $scope.ChoseSaleTotalTrendGraph = '默认(昨日今日)';
                $scope.spendshow = false;
                var twodaysData = {
                    today: [[0, 0], [2, 0], [3, 0], [4, 0], [7, 100], [9, 700], [10, 1500], [11, 3000], [12, 3200], [13, 4000], [14, 4300], [16, 4500], [17, 5000], [19, 6000], [24, 7000]],
                    yesterday: [[0, 110.0], [2, 200], [3, 400], [4, 800], [7, 900], [9, 1000], [10, 2500], [11, 3000], [12, 3200], [13, 4000], [14, 4300], [16, 5000], [17, 6000], [19, 8000], [24, 10000]]
                };
                Datas = [{ label: "今日销售总额", data: twodaysData.today, color: "#1ABC9C" }, { label: "昨日销售总额", data: twodaysData.yesterday, color: "#fa787e" }];
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
                            }
                            else if (type == 3) {
                                return rule;
                            }
                            else {
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
                    tooltip: true,
                    tooltipOpts: {
                        content: "%x的销售总额：%y",
                        shifts: {
                            x: -60,
                            y: 25
                        },
                        onHover: function (flotItem, $tooltipEl) {
                            // console.log(flotItem, $tooltipEl);
                        }
                    }
                }
                $.plot($("#flot-line-chart"), Datas, options);
                break;
            case 2://自定义时间区间
                $("#reservation").val('');
                $scope.ChoseSaleTotalTrendGraph = '自定义时间';
                $scope.spendshow = true;
                $('#reservation').daterangepicker({
                    showDropdowns: true,
                    format: 'YYYY/MM/DD',
                    ranges: {
                        '今天/昨天': [moment(), moment()],
                        '昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        '最近7天': [moment().subtract('days', 6), moment()],
                        '最近30天': [moment().subtract('days', 29), moment()],
                        '这个月': [moment().startOf('month'), moment().endOf('month')],
                        '上个月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    startDate: moment().subtract('days', 29),
                    endDate: moment()
                },
                   function (start, end) {
                       create_time1 = start / 1000;
                       create_time2 = end / 1000;
                       $scope.SaleTotalTrendGraphByTime(2, create_time1, create_time2);
                   });
                break;
        }

    }

    //时间区间发生变化商家销售总额趋势图
    $scope.SaleTotalTrendGraphByTime = function (type, starttime, endtime) {
        var weekDatas = [[1, 7000], [2, 9000], [3, 6000], [4, 6000], [5, 4000], [6, 9000], [7, 15000]];
        var Datas = [{ label: "时间区间内销售总额", data: weekDatas, color: "#1ABC9C" }];
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
                    }
                    else if (type == 3) {
                        return rule;
                    }
                    else {
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
            tooltip: true,
            tooltipOpts: {
                content: "%x的销售总额：%y",
                shifts: {
                    x: -60,
                    y: 25
                },
                onHover: function (flotItem, $tooltipEl) {
                    // console.log(flotItem, $tooltipEl);
                }
            }
        }
        $.plot($("#flot-line-chart"), Datas, options);
    }

    //消费同比饼图gogo客户
    $scope.ConsumerYear = function () {
        var data = [{
            label: "20岁以下",
            data: 12
        }, {
            label: "20-23岁",
            data: 25
        }, {
            label: "24-26岁",
            data: 33
        }, {
            label: "27-30岁",
            data: 43
        }, {
            label: '34岁以上',
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
                defaultTheme: false,
                onHover: function (flotItem, $tooltipEl) {
                    // console.log(flotItem, $tooltipEl);
                }
            }
        }
        $.plot($("#flot-pie-chart"), data, options);
    }

    //柱状图（收银员销售情况）
    $scope.CashierSaleBarChart = function (type) {
        var Datas = [];
        switch (type) {
            case 1://今日
                $scope.cashiersaleshow = false;
                $scope.CashierSaleConditionChose = "默认(今日)";
                Datas = [
                   { data: [[0, 7000]], color: '#16A085' },
                   { data: [[2, 9000]], color: '#27AE60' },
                   { data: [[4, 6000]], color: '#2980B9' },
                   { data: [[6, 6000]], color: '#2C3E50' },
                   { data: [[8, 4000]], color: '#F39C12' },
                   { data: [[10, 9000]], color: '#D35400' },
                   { data: [[12, 15000]], color: '#C0392B' },
                   { data: [[14, 15000]], color: '#BDC3C7' },
                   { data: [[16, 15000]], color: '#7F8C8D' }
                ];
                var names = ['老张', '杨超', '陈锐', '小强', '小宝', '小李子', '小飞刀', '小勺子', '小品'];
                var barOptions = {
                    series: {
                        bars: {
                            show: true,
                            barWidth: 1
                        }
                    },
                    xaxis: {
                        labelWidth: 10,
                        tickFormatter: function (number, obj) {
                            return names[number / this.tickSize];
                        },
                        tickSize: 2,
                        min: 0,
                        tickLabel: names
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
                    tooltip: true,
                    tooltipOpts: {
                        content: "%x的销售总额：%y",
                        shifts: {
                            x: -60,
                            y: 25
                        },
                        onHover: function (flotItem, $tooltipEl) {
                            console.log(flotItem, $tooltipEl);
                        }
                    }
                };
                $.plot($("#flot-bar-chart"), Datas, barOptions);
                break;
            case 2://昨日
                $("#CashierTimeControl").val('');
                $scope.CashierSaleConditionChose = '自定义时间';
                $scope.cashiersaleshow = true;
                $('#CashierTimeControl').daterangepicker({
                    showDropdowns: true,
                    format: 'YYYY/MM/DD',
                    ranges: {
                        '今天': [moment(), moment()],
                        '昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        '最近7天': [moment().subtract('days', 6), moment()],
                        '最近30天': [moment().subtract('days', 29), moment()],
                        '这个月': [moment().startOf('month'), moment().endOf('month')],
                        '上个月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    startDate: moment().subtract('days', 29),
                    endDate: moment()
                },
                   function (start, end) {
                       create_time1 = start / 1000;
                       create_time2 = end / 1000;
                       $scope.CashierSaleBarChartByTime(2, create_time1, create_time2);

                   });
                break;
        }

    }
    //时间区间发生变化 柱状图（收银员销售情况）
    $scope.CashierSaleBarChartByTime = function (type, starttime, endtime) {
        Datas = [
                   { data: [[0, 5000]], color: '#16A085' },
                   { data: [[2, 2000]], color: '#27AE60' },
                   { data: [[4, 3000]], color: '#8E44AD' },
                   { data: [[6, 7000]], color: '#2C3E50' },
                   { data: [[8, 4000]], color: '#F39C12' },
                   { data: [[10, 9000]], color: '#D35400' },
                   { data: [[12, 10000]], color: '#C0392B' },
                   { data: [[14, 15000]], color: '#BDC3C7' },
                   { data: [[16, 11000]], color: '#7F8C8D' }
        ];
        var names = ['老张', '杨超', '陈锐', '小强', '小宝', '小李子', '小飞刀', '小勺子', '小品'];
        var barOptions = {
            series: {
                bars: {
                    show: true,
                    barWidth: 1
                }
            },
            xaxis: {
                labelWidth: 10,
                tickFormatter: function (number, obj) {
                    return names[number / this.tickSize];
                },
                tickSize: 2,
                min: 0,
                tickLabel: names
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
            tooltip: true,
            tooltipOpts: {
                content: "%x的销售总额：%y",
                shifts: {
                    x: -60,
                    y: 25
                },
                onHover: function (flotItem, $tooltipEl) {
                    console.log(flotItem, $tooltipEl);
                }
            }
        };
        $.plot($("#flot-bar-chart"), Datas, barOptions);
    }



    $scope.ConsumerYear();
    $scope.SaleTotalTrendGraph(1);
    $scope.CashierSaleBarChart(1);

}