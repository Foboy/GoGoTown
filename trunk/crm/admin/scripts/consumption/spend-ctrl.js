//消费记录scope
function SpendingRecordsCtrl($scope, $http, $location, $routeParams, $resturls, $rootScope) {
	 var $parent = $scope.$parent;
		$scope.shopinfo=$rootScope.shopinfo;
		if(!$scope.shopinfo)
			$scope.shopinfo=[];
		   //获取交易记录 
		// parms sname （模糊查询商户名称客户名称手机号昵称）,shop_id,customer_id,pay_mothed（1:刷卡2:GO币）,
		//       cash1,cash2,go_coin1,go_coin2,type,create_time1, create_time2,pageindex, pagesize


		
		var shop_id=0;
		var customer_id=0;
		$scope.shopinfo.cash1=0;
		$scope.shopinfo.cash2=0;
		$scope.shopinfo.GO1=0;
		$scope.shopinfo.GO2=0;
		$scope.shopinfo.daterange="";
		$scope.shopinfo.skey="";
		
		var create_time1="";
		var create_time2="";
	   $scope.SearchlakalaBills = function (pageIndex) {
	       if (!pageIndex) 
	    	   pageIndex = 0;
	       $http.post($resturls["LoadSpendingRecordList"], { sname: $scope.shopinfo.skey, shop_id: 0, customer_id: 0, pay_mothed: $scope.cpt_id,  cash1: $scope.shopinfo.cash1, cash2: $scope.shopinfo.cash2,go_coin1: $scope.shopinfo.GO1, go_coin2: $scope.shopinfo.GO2,type:$scope.cct_id,create_time1:create_time1,create_time2:create_time2,area_id:$scope.csr_id,pageindex:pageIndex,pagesize: 15 }).success(function (result) {
	           if (result.Error == 0) {
	               $scope.shopBills = result.Data;
	               //$parent.shopBillsActpageIndex = pageIndex;
	               $parent.pages = utilities.paging(result.totalcount, pageIndex+1, 10, '#spendingrecords/' + '{0}');
	           } else {
	               $scope.shopBills = [];
	               $parent.pages = utilities.paging(0, pageIndex+1, 10);
	           }
	       });
	   }
	   $('#reservation').daterangepicker({
				   showDropdowns:true,
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
	      function(start, end) {
		   create_time1=start/1000;
		   create_time2=end/1000;
	   });
	   $("#Masterserach").click(function() {
	       $("#MasterZone").toggle();
	   });
	   
	   $scope.cct_name="消费类型";
	   $scope.cct_id=0;
	   $scope.csr_name="商圈范围";
	   $scope.csr_id=0;
	   $scope.cpt_name="支付类型";
	   $scope.cpt_id=0;
	   
	
	  
	   $scope.ChooseShopRange=function(data)
	   {
	   //	$scope.csr_name=data.name;
		
	   	$scope.csr_id=data.id;
		$scope.tag_sr_text=data.name;
		$("#tag_sr").removeClass("hidden");
	   	
	   };
	   $scope.Hiddensrtag=function()
	   {
		   $("#tag_sr").addClass("hidden");
		   $scope.csr_id=0;
	   }
	   
	   //获取消费类型
	   $scope.Consumptiontype=[
	                   {"id":1,"name":"服饰"},
	                   {"id":2,"name":"箱包"},
	                   {"id":3,"name":"数码"}
	                   ];
	   $scope.ChooseConsumptiontype=function(data)
	   {
			$scope.cct_id=data.id;
			$scope.tag_ct_text=data.name;
			$("#tag_ct").removeClass("hidden");
	   };
	   $scope.Hiddencttag=function()
	   {
		   $("#tag_ct").addClass("hidden");
		   $scope.cct_id=0;
	   }

	   //获取支付类型
	   $scope.PayType=[
	                     {"id":1,"name":"GO币支付"},
	                     {"id":2,"name":"刷卡消费"}
	                     ];
	   $scope.ChoosePayType=function(data)
	   {
			$scope.cpt_id=data.id;
			$scope.tag_pt_text=data.name;
			$("#tag_pt").removeClass("hidden");
	   };
	   $scope.Hiddenpttag=function()
	   {
		   $("#tag_pt").addClass("hidden");
		   $scope.cpt_id=0;
	   }
		if($routeParams.pageIndex)
			$scope.SearchlakalaBills($routeParams.pageIndex-1);
		else
			$scope.SearchlakalaBills();
}