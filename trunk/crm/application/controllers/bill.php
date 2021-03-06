<?php
class Bill extends Controller {
	/**
	 * 交易记录
	 */
	public function __construct() {
		parent::__construct ();
		
		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		 Auth::handleLogin();
	}
	public function twoday()
	{
		$result = new DataResult ();
		print json_encode($result);
	}
	
	/*
	/* 商家分页查询消费记录 crm系统
	 * parms sname （模糊查询客户名称手机号昵称）,pay_mothed（0:查所有 2:刷卡现金 1:GO币 ）,customer_id,type,create_time1, create_time2,pageindex, pagesize
	 */
	public function  searchBillsByCrm()
	{
		$result = new DataResult ();

		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['sname'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['customer_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['pay_mothed'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['type'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['create_time1'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['create_time2'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['pageindex'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['pagesize'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$bills_model = $this->loadModel ( 'Bills' );
	
		$result= $bills_model->searchByPages ( $_POST ['sname'], $_SESSION["user_shop"],$_POST ['customer_id'],$_POST ['pay_mothed'],0,0,0,0,$_POST ['type'],$_POST ['create_time1'],$_POST ['create_time2'],$_POST ['pageindex'],$_POST ['pagesize'] );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}


	/*
	/* 分页查询交易记录
	 * parms sname （模糊查询商户名称客户名称手机号昵称）,shop_id,customer_id,pay_mothed（2:刷卡现金1:GO币）,cash1,cash2,go_coin1,go_coin2,type,create_time1, create_time2,pageindex, pagesize
	 */
	public function  searchBills()
	{
		$result = new DataResult ();
		if (! isset ( $_POST ['sname'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['shop_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['customer_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['pay_mothed'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['cash1'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['cash2'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['go_coin1'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['go_coin2'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['type'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['create_time1'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['create_time2'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['pageindex'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['pagesize'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		$bills_model = $this->loadModel ( 'Bills' );
		
		$result= $bills_model->searchByPages ( $_POST ['sname'],$_POST ['shop_id'],$_POST ['customer_id'],$_POST ['pay_mothed'],$_POST ['cash1'],$_POST ['cash2'],$_POST ['go_coin1'],$_POST ['go_coin2'],$_POST ['type'],$_POST ['create_time1'],$_POST ['create_time2'],$_POST ['pageindex'],$_POST ['pagesize'] );
		$result->Error = ErrorType::Success;
		
		print  json_encode ( $result );
	}


}