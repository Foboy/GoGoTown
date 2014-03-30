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
		
		return  json_encode ( $result );
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
		
		return  json_encode ( $result );
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
		
		return json_encode ( $result );
	}
	
	/*
	 * 分页查询添加商家自有客户信息
	* parms:name,sex,phone,birthday,remark
	*/
	public function searchBP() {
		$result = new PageDataResult ();
		if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['phone'] ) or empty ( $_POST ['phone'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['sex'] ) or empty ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['birthady'] ) or empty ( $_POST ['birthady'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		if (! isset ( $_POST ['pageindex'] ) or empty ( $_POST ['pageindex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			return json_encode ( $result );
		}
		
		$customers_model = $this->loadModel ( 'Customers' );
		
		$result = $customers_model->searchByPages ( $_POST ['name'], $_POST ['sex'], $_POST ['phone'], $_POST ['birthady'],  $_POST ['pageindex'] , 10 );
		$result->Error = ErrorType::Success;
		
		return  json_encode ( $result );
	}
}
