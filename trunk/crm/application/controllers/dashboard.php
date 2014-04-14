<?php

/**
 * Class Dashboard
 * This is a demo controller that simply shows an area that is only visible for the logged in user
 * because of Auth::handleLogin(); in line 19.
 */
class Dashboard extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();

        // this controller should only be visible/usable by logged in users, so we put login-check here
        Auth::handleLogin();
    }
    /**
     * This method controls what happens when you move to /dashboard/index in your app.
     */
    function index()
    {
    	$this->view->render('dashboard/index');
    }
    /**
     * 昨日今日销售分析统计 (每天24小时)
     * 返回数据格式: var twodaysData = {
     today: [[0, 0], [2, 0], [3, 0], [4, 0], [7, 100], [9, 700], [10, 1500], [11, 3000], [12, 3200], [13, 4000], [14, 4300], [16, 4500], [17, 5000], [19, 6000], [24, 7000]],
     yesterday: [[0, 110.0], [2, 200], [3, 400], [4, 800], [7, 900], [9, 1000], [10, 2500], [11, 3000], [12, 3200], [13, 4000], [14, 4300], [16, 5000], [17, 6000], [19, 8000], [24, 10000]]
     };
     */
    public function twodaysalesstatistics()
    {
    	
    }
    
    /**
     * 销售分析统计 按照天数 ey:最近七天 最近一个月30天 一个时间段:2012-03-04 到 2014-04-12
    *数据返回类型  var weekDatas = [[1, 7000], [2, 9000], [3, 6000], [4, 6000], [5, 4000], [6, 9000], [7, 15000]];
    */
    public function salesstatisticsbydays()
    {}
    
    /**
     * 消费同比统计
     *返回数据格式: var data = [{
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
     */
    public function ConsumerYear()
    {}
    
    /**
     * 收银员销售情况统计 按照时间 ey:今天 昨天 一个时间段:2012-03-04 到 2014-04-12
    *返回参数格式(注意datas中每个数组的横坐标步长为2):var obj={
    name: ['王晓', '杨超', '陈锐', '小强', '小宝', '小李子', '小飞刀', '小勺子', '小品'];
    datas:[[0, 7000], [2, 9000], [4, 6000], [6, 6000], [8, 4000], [10, 9000], [12, 15000], [14, 15000], [16, 15000]];
    }
    */
    public function CashierSaleBarChart()
    {}


}
