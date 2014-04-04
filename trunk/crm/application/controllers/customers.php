<?php

class Customers extends Controller {
	/**
	 * 商家客户管理，包括公海客户，销售机会客户以及自有客户信息编辑
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
	 * parms: customer_id
	*/
	public function get() {
		$result = new DataResult ();
		if (! isset ( $_POST ['customer_id'] ) or empty ( $_POST ['customer_id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		$customers_model = $this->loadModel ( 'Customers' );
		
		$result= $customers_model->get ( $_POST ['customer_id']  );
		$result->Error = ErrorType::Success;
		
		print  json_encode ( $result );
	}
	
	/*
	 * 编辑商家自有客户信息
	* parms: customer_id name sex phone birthday remark
	*/
	public function update() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['customer_id'] ) or empty ( $_POST ['customer_id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['sex'] ) or empty ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['phone'] ) or empty ( $_POST ['phone'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}

		if (! isset ( $_POST ['birthady'] ) or empty ( $_POST ['birthady'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['remark'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$customers_model = $this->loadModel ( 'Customers' );

		$result->Data = $customers_model->update ( $_POST ['customer_id'],$_POST ['name'],$_POST ['sex'],$_POST ['phone'],$_POST ['birthady'],$_POST ['remark'] );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
	
	/*
	 * 根据ID删除商家自有客户信息
	 * parms: customer_id
	*/
	public function del() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['customer_id'] ) or empty ( $_POST ['customer_id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		$customers_model = $this->loadModel ( 'Customers' );
		
		$result->Data = $customers_model->delete ( $_POST ['customer_id'] );
		$result->Error = ErrorType::Success;
		
		print  json_encode ( $result );
	}
	/*
	 * 添加商家自有客户信息
	* parms:name,sex,phone,birthday,remark
	*/
	public function addPrivateCustomer() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		 
		if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['sex'] ) or empty ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['phone'] ) or empty ( $_POST ['phone'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['birthday'] ) or empty ( $_POST ['birthday'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['remark'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		$customers_model = $this->loadModel ( 'Customers' );
		$customer_id = $customers_model->insert ($_POST ['name'],$_POST ['sex'],$_POST ['phone'],$_POST ['birthday'],$_POST ['remark']);
		if($customer_id!=0)
		{
		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
		 $shopcustomers_model->insert($_SESSION["user_shop"],$customer_id,CustomerFromType::PrivateCustomer,CustomerType::PrivateCustomer,time());
		}
		$result->Data=$customer_id;
		print json_encode ( $result );
	}
	
	/*
	 * 分页查询添加商家自有客户信息
	* parms:name,sex,phone
	*/
	public function searchPrivateBP() {
		
		$result = new PageDataResult ();
		
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['name'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		if (! isset ( $_POST ['phone'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
		if (! isset ( $_POST ['pageindex'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}

		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
		
		$result = $shopcustomers_model->searchPrivateByPages ($_SESSION["user_shop"], $_POST ['name'], $_POST ['sex'], $_POST ['phone'],   $_POST ['pageindex'] , 1 );
		$result->Error = ErrorType::Success;
		
	
		print  json_encode ( $result );
	}
	/*
	 * 分页查询添加商家gogo客户信息
	* parms:name,sex,phone,type 1:公海客户 2：销售机会 3：有消费记录gogo客户
	*/
	public function searchGOGOBP() {
	
		$result = new PageDataResult ();
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['name'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['phone'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['sex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['type'] ) or empty ( $_POST ['type'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		if (! isset ( $_POST ['pageindex'] ) or empty ( $_POST ['pageindex'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
	
		$result = $shopcustomers_model->searchGOGOCustomerByPages ($_SESSION["user_shop"], $_POST ['name'], $_POST ['sex'], $_POST ['phone'], $_POST ['type'], $_POST ['pageindex'] , 20 );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
	/*
	 * 设置公海客户为销售机会
	* parms: customer_id 
	*/
	public function setPshopToChance() {
		$result = new DataResult ();
	
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
	
		if (! isset ( $_POST ['customer_id'] ) or empty ( $_POST ['customer_id'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
	
		$result->Data = $shopcustomers_model->update ($_SESSION["user_shop"], $_POST ['customer_id'],CustomerFromType::GOGOCustomer,CustomerType::ChanceCustomer,time() );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
	/*
	 * 分页查询添加商家gogo客户信息
	* parms: stime  etime
	* return: 公海客户数 mshop_num 消费机会 chance_num 已消费GOGO客户数 private_gogo_num
	*/
	public function getCustomerCount() {
	
		$result = new PageDataResult ();
	
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['stime'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['etime'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
	
		$result = $shopcustomers_model->getCustomerCount ($_SESSION["user_shop"], $_POST ['stime'], $_POST ['etime'] );
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
	
}
