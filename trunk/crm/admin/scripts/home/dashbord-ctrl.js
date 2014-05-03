//数据统计scope
function DataStatisticsCtrl($scope, $http, $location, $routeParams, $resturls) {
    //商家销售总额趋势图(默认昨天今天)
    $scope.SaleTotalTrendGraph = function () {
        $("#reservation").val('');
        $('#reservation').daterangepicker({
            showDropdowns: true,
            format: 'YYYY/MM/DD',
            ranges: {
                '今天/昨天': [moment().subtract('days', 1), moment()],
                '最近7天': [moment().subtract('days', 6), moment()],
                '最近30天': [moment().subtract('days', 29), moment()]
            },
            startDate: moment().subtract('days', 1),
            endDate: moment()
        },
           function (start, end) {
               create_time1 = start / 1000;
               create_time2 = end / 1000;
               $scope.SaleTotalTrendGraphByTime( $scope.timestamptostr(create_time1), $scope.timestamptostr(create_time2));
              
           });
        
        var Datas = [];
        var d=Math.round(new Date().getTime()/1000);
        //console.log( $scope.timestamptostr(d-24*3600));
        
        $http.post($resturls["SaleTotalTrendGraphByTime"], { create_time1: $scope.timestamptostr(d-24*3600), create_time2: $scope.timestamptostr(d) }).success(function (result) {
            if (result.Error == 0) {
           	 var twodaysData = {
        	            today:result.Data.today,
        	            yesterday:result.Data.yesterday
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
        	                    return rule + '时';
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
                
            } else {
                $scope.showerror = true;
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        }).error(function (data, status, headers, config) {
            $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
        });
        
    
       
    }
    //时间区间发生变化商家销售总额趋势图
    $scope.SaleTotalTrendGraphByTime = function (starttime, endtime) {
        var Datas = [];
        var type = 2;
        $http.post($resturls["SaleTotalTrendGraphByTime"], { create_time1: starttime, create_time2: endtime }).success(function (result) {
            if (result.Error == 0) {
      type=result.Data.type;
           	 switch (type) {
             case 1://按小时
               	 var twodaysData = {
     	            today:result.Data.today,
     	            yesterday:result.Data.yesterday
     	        };
                 Datas = [{ label: "今日销售总额", data: twodaysData.today, color: "#1ABC9C" }, { label: "昨日销售总额", data: twodaysData.yesterday, color: "#fa787e" }];
                 break;
             case 2://按日
                 var weekDatas = result.Data.data;
                 Datas = [{ label: "时间区间内销售总额", data: weekDatas, color: "#1ABC9C" }];
                 break;
             case 3://按月
                 var weekDatas = result.Data.data;
                 Datas = [{ label: "时间区间内销售总额", data: weekDatas, color: "#1ABC9C" }];
                 break;
         }
         var ts=86400;
    
        	 switch(type)
        	 {
        	 case 1:
        		 ts = 3600;
        		 break;
        	 case 2:
        		 ts = 86400;
        		 break;
        	 case 3:
        		 ts = 86400*31;
        		 break;
        	 };
    
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
                 tickSize: ts,
                 tickFormatter: function (rule) {
                     return $scope.TimestampToStr(rule, type);
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
                
            } else {
                $scope.showerror = true;
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        }).error(function (data, status, headers, config) {
            $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
        });
        
       
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
    $scope.CashierSaleBarChart = function (starttime, endtime) {
        $("#CashierTimeControl").val('');
        $('#CashierTimeControl').daterangepicker({
            showDropdowns: true,
            format: 'YYYY/MM/DD',
            ranges: {
                '今天': [moment(), moment()],
                '最近7天': [moment().subtract('days', 6), moment()],
                '最近30天': [moment().subtract('days', 29), moment()]

            },
            startDate: moment(),
            endDate: moment()
        },
           function (start, end) {
               create_time1 = start / 1000;
               create_time2 = end / 1000;
               $scope.CashierSaleBarChartByTime($scope.timestamptostr(create_time1), $scope.timestamptostr(create_time2));

           });
        var d=Math.round(new Date().getTime()/1000);
        console.log( $scope.timestamptostr(d-24*3600));
        $http.post($resturls["AppuserTrendGraphByTime"], { create_time1: $scope.timestamptostr(d-24*3600), create_time2: $scope.timestamptostr(d) }).success(function (result) {
            if (result.Error == 0) {

                var Datas = [];
                Datas=result.Data.datas;
//                Datas = [
//                   { data: [[0, 7000]], color: '#16A085' },
//                   { data: [[2, 9000]], color: '#27AE60' },
//                   { data: [[4, 6000]], color: '#2980B9' },
//                   { data: [[6, 6000]], color: '#2C3E50' },
//                   { data: [[8, 4000]], color: '#F39C12' },
//                   { data: [[10, 9000]], color: '#D35400' },
//                   { data: [[12, 15000]], color: '#C0392B' },
//                   { data: [[14, 15000]], color: '#BDC3C7' },
//                   { data: [[16, 15000]], color: '#7F8C8D' }
//                ];
//                var names = ['老张', '杨超', '陈锐', '小强', '小宝', '小李子', '小飞刀', '小勺子', '小品'];
                var names=result.Data.name;
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
                            //console.log(flotItem, $tooltipEl);
                        }
                    }
                };
                $.plot($("#flot-bar-chart"), Datas, barOptions);
            } else {
                $scope.showerror = true;
                $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
            }
        }).error(function (data, status, headers, config) {
            $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
        });


    }
    //时间区间发生变化 柱状图（收银员销售情况）
    $scope.CashierSaleBarChartByTime = function (starttime, endtime) {
    	 $http.post($resturls["AppuserTrendGraphByTime"], { create_time1: starttime, create_time2: endtime }).success(function (result) {
             if (result.Error == 0) {

                 var Datas = [];
                 Datas=result.Data.datas;
//                 Datas = [
//                    { data: [[0, 7000]], color: '#16A085' },
//                    { data: [[2, 9000]], color: '#27AE60' },
//                    { data: [[4, 6000]], color: '#2980B9' },
//                    { data: [[6, 6000]], color: '#2C3E50' },
//                    { data: [[8, 4000]], color: '#F39C12' },
//                    { data: [[10, 9000]], color: '#D35400' },
//                    { data: [[12, 15000]], color: '#C0392B' },
//                    { data: [[14, 15000]], color: '#BDC3C7' },
//                    { data: [[16, 15000]], color: '#7F8C8D' }
//                 ];
//                 var names = ['老张', '杨超', '陈锐', '小强', '小宝', '小李子', '小飞刀', '小勺子', '小品'];
                 var names=result.Data.name;
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
                        	 console.log(number);
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
                             //console.log(flotItem, $tooltipEl);
                         }
                     }
                 };
                 $.plot($("#flot-bar-chart"), Datas, barOptions);
             } else {
                 $scope.showerror = true;
                 $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
             }
         }).error(function (data, status, headers, config) {
             $.scojs_message('服务器忙，请稍后重试', $.scojs_message.TYPE_ERROR);
         });

    }

    $scope.TimestampToStr = function (timestamp, type) {
        //debugger;
        var unixTimestamp = new Date(timestamp * 1000);
        if (type == 1) {
            var str = (unixTimestamp.getHours()) + '时';
            return str;
        }
        else if (type == 2) {
            var str = (unixTimestamp.getMonth() + 1) + '月' + unixTimestamp.getDate() + '日';
            return str;
        } else {
            var str = (unixTimestamp.getMonth() + 1) + '月';
            return str;
        }
    }
    
    //初始化调用
    $scope.SaleTotalTrendGraph();
    $scope.ConsumerYear();
    $scope.CashierSaleBarChart(Date.parse(new Date()) / 1000, Date.parse(new Date()) / 1000);
}