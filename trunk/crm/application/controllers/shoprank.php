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
		

		if (! isset ( $_POST ['name'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
			return ;
		}
	

		$rankset_model = $this->loadModel ( 'RankSet' );
	
		$result->Data = $rankset_model->insert ( 0,$_POST ['name'],$_SESSION["user_shop"],'' );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	/*
	 * 删除客户等级名称
	* parms:   id
	*/
	public function delete() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['id'] ) or empty ( $_POST ['id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$rankset_model = $this->loadModel ( 'RankSet' );
	
		$result->Data = $rankset_model->delete ( $_POST ['id']);
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
	* parms: rank_id from_type 1自有 2gogo  customer_id begin_time end_time
	*/
	public function setCustomerRank() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['rank_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['from_type'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['customer_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}

	
		$rank_model = $this->loadModel ( 'Rank' );
		$result->Data = $rank_model->delete($_POST ['from_type'] ,$_POST ['customer_id'],$_SESSION["user_shop"] );
		$result->Data = $rank_model->insert ($_POST ['from_type'],$_SESSION["user_shop"],$_POST ['customer_id'],$_POST ['rank_id']);
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	/*
	 * 设置商家客户等级
	* parms: rank_id from_type 1自有 2gogo  customer_ids begin_time end_time
	*/
	public function setCustomerRankBat() {
		$result = new DataResult ();
	
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
	
		if (! isset ( $_POST ['rank_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		if (! isset ( $_POST ['from_type'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['customer_ids'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$ids = explode ( ',', trim ( $_POST ['customer_ids'] ) );
		if(count ( $ids )>0)
		{
			$rank_model = $this->loadModel ( 'Rank' );
			for($index = 0; $index < count ( $ids ); $index ++) {
				$result->Data = $rank_model->delete($_POST ['from_type'] ,$ids [$index],$_SESSION["user_shop"] );
				$result->Data = $rank_model->insert ($_POST ['from_type'],$_SESSION["user_shop"],$ids [$index],$_POST ['rank_id']);
			}
		}
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
}
?>