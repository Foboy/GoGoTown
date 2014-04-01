<?php

class ShopCustomers extends Controller {
	/**
	 * Construct this object by extending the basic Controller class
	 */
	public function __construct() {
		parent::__construct ();
		
		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		// Auth::handleLogin();
	}

	/*
	 * 根据ID获取商家自有客户信息
	 * parms:id
	*/
	public function get() {
		$result = new DataResult ();
		if (! isset ( $_POST ['id'] ) or empty ( $_POST ['id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		
		$customers_model = $this->loadModel ( 'Customers' );
		
		$result->Data = $customers_model->get ( $_POST ['id']  );
		$result->Error = ErrorType::Success;
		
		print  json_encode ( $result );
	}
	/*
	 * 根据ID删除商家自有客户信息
	 * parms:id
	*/
	public function del() {
		$result = new DataResult ();
		
		if (! isset ( $_POST ['id'] ) or empty ( $_POST ['id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		
		$customers_model = $this->loadModel ( 'Customers' );
		
		$result->Data = $customers_model->delete ( $_POST ['id'] );
		$result->Error = ErrorType::Success;
		
		print  json_encode ( $result );
	}
	/*
	 * 添加商家自有客户信息
	* parms:name,sex,phone,birthday,remark
	*/
	public function add() {
		$result = new DataResult ();
		
	if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['sex'] ) or empty ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['phone'] ) or empty ( $_POST ['phone'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}

		if (! isset ( $_POST ['birthady'] ) or empty ( $_POST ['birthady'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['remark'] ) or empty ( $_POST ['remark'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		$customers_model = $this->loadModel ( 'Customers' );
		
		$result->Data = $customers_model->insert ($_POST ['name'],$_POST ['sex'],$_POST ['phone'],$_POST ['birthady'],$_POST ['remark']);
		
		print json_encode ( $result );
	}
	
	/*
	 * 分页查询添加商家自有客户信息
	* parms:name,sex,phone,birthday,remark
	*/
	public function searchPrivateBP() {
		
		$result = new PageDataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['name'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['phone'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		
		if (! isset ( $_POST ['pageindex'] ) or empty ( $_POST ['pageindex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		
		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
		
		$result = $shopcustomers_model->searchPrivateByPages ($_SESSION["user_shop"], $_POST ['name'], $_POST ['sex'], $_POST ['phone'],   $_POST ['pageindex'] , 10 );
		$result->Error = ErrorType::Success;
		
		print  json_encode ( $result );
	}
	/*
	 * 分页查询添加商家自有客户信息
	* parms:name,sex,phone,type 1:公海客户 2：销售机会 3：有消费记录gogo客户
	*/
	public function searchGOGOBP() {
	
		$result = new PageDataResult ();
	
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['name'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['phone'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
		if (! isset ( $_POST ['type'] ) or empty ( $_POST ['type'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
	
		if (! isset ( $_POST ['pageindex'] ) or empty ( $_POST ['pageindex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
		}
	
		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
	
		$result = $shopcustomers_model->searchGOGOCustomerByPages ($_SESSION["user_shop"], $_POST ['name'], $_POST ['sex'], $_POST ['phone'], $_POST ['type'], $_POST ['pageindex'] , 10 );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
}
