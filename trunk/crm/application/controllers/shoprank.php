<?php

class ShopRank extends Controller {
	/**
	 * 商家客户等级相关操作
	 */
	public function __construct() {
		parent::__construct ();

		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		// Auth::handleLogin();
	}
	/*
	 * 新增客户等级
	* parms: rank  name  remark
	*/
	public function add() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['rank'] ) or empty ( $_POST ['rank'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['remark'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
			return ;
		}

		$rankset_model = $this->loadModel ( 'RankSet' );
	
		$result->Data = $rankset_model->insert ( $_POST ['rank'],$_POST ['name'],$_SESSION["user_shop"],$_POST ['remark'] );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	/*
	 * 修改客户等级名称
	* parms:  rank  name  remark  id
	*/
	public function update() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['rank'] ) or empty ( $_POST ['rank'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['remark'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['id'] ) or empty ( $_POST ['id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$rankset_model = $this->loadModel ( 'RankSet' );
	
		$result->Data = $rankset_model->update ( $_POST ['id'],$_POST ['rank'],$_POST ['name'],$_SESSION["user_shop"],$_POST ['remark']);
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	/*
	 * 获取商家客户等级名称
	* parms:
	*/
	public function search() {
		$result = new DataResult ();
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
	
		$rankset_model = $this->loadModel ( 'RankSet' );
	
		$result = $rankset_model->search (  $_SESSION["user_shop"]   );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	/*
	 * 设置商家客户等级
	* parms: rank from_type customer_id begin_time end_time
	*/
	public function setCustomerRank() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['rank'] ) or empty ( $_POST ['rank'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['from_type'] ) or empty ( $_POST ['from_type'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['customer_id'] ) or empty ( $_POST ['customer_id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['begin_time'] ) or empty ( $_POST ['begin_time'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['end_time'] ) or empty ( $_POST ['end_time'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$rankset_model = $this->loadModel ( 'Rank' );
		$result->Data = $rankset_model->delete($_POST ['from_type'] ,$_POST ['customer_id'],$_SESSION["user_shop"] );
		$result->Data = $rankset_model->insert ($_POST ['from_type'],$_SESSION["user_shop"],$_POST ['customer_id'],$_POST ['rank'], $_POST ['begin_time'],$_POST ['end_time'] );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
}
?>