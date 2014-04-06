<?php

class ShopInfo extends Controller {
	/**
	 * 商家信息相关操作
	 */
	public function __construct() {
		parent::__construct ();

		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		// Auth::handleLogin();
	}
	/*
	 * 获取商家信息
	* 
	*/
	public function get() {
		$result = new DataResult ();
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_SESSION["user_id"] ) or empty ( $_SESSION["user_id"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		$user_model = $this->loadModel('Users');
		
		$user = $user_model->get ( $_SESSION["user_id"] );
			$shops_model = $this->loadModel ( 'Shops' );
	
		$shop = $shops_model->get ($_SESSION["user_shop"]);
if( $user->Data)
{
		$shop->Data->name=$user->Data->Name;
}
		
		$result=$shop;
	
		print  json_encode ( $result );
	}
	/*
	 * 修改商家名称
	* parms: name
	*/
	public function updateName() {
		$result = new DataResult ();
		if (! isset ( $_SESSION["user_id"] ) or empty ( $_SESSION["user_id"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['name'] ) or empty ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
       $user_model = $this->loadModel('Users');
	
		$result->Data = $user_model->updateShopName ($_POST ['name'],$_SESSION["user_id"]);
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	/*
	 * 修改商家账号密码
	* parms: user_password_new  user_password_repeat
	*/
	public function updatePass() {
		$result = new DataResult ();
		if (! isset ( $_SESSION["user_id"] ) or empty ( $_SESSION["user_id"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
	
		if (!isset($_POST['user_password_new']) OR empty($_POST['user_password_new'])) {
			$result->Error = ErrorType::RequestParamsFailed;;
			print json_encode ( $result );
			return ;
		}
		if (!isset($_POST['user_password_repeat']) OR empty($_POST['user_password_repeat'])) {
			$result->Error = ErrorType::RequestParamsFailed;;
			print json_encode ( $result );
			return ;
		}
		// password does not match password repeat
		if ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
			$result->Error  = FEEDBACK_PASSWORD_REPEAT_WRONG;
			print json_encode ( $result );
			return ;
		}
		// password too short
		if (strlen($_POST['user_password_new']) < 6) {
			$result->Error = FEEDBACK_PASSWORD_TOO_SHORT;
			print json_encode ( $result );
			return ;
		}
		// check if we have a constant HASH_COST_FACTOR defined
		// if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
		$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
		
		// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
		// the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
		// compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
		// want the parameter: as an array with, currently only used with 'cost' => XX.
		$user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
		
		 $user_model = $this->loadModel('Users');
	
		$result->Data = $user_model->setNewPassword ($_SESSION["user_id"] ,$user_password_hash);
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
	/*
	 * 修改收银员APP密码
	* parms: user_id user_password_new  user_password_repeat
	*/
	public function updateAppPass() {
		$result = new DataResult ();
		if (! isset ( $_POST["user_id"] ) or empty ( $_POST["user_id"] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
	
		if (!isset($_POST['user_password_new']) OR empty($_POST['user_password_new'])) {
			$result->Error = ErrorType::RequestParamsFailed;;
			print json_encode ( $result );
			return ;
		}
		if (!isset($_POST['user_password_repeat']) OR empty($_POST['user_password_repeat'])) {
			$result->Error = ErrorType::RequestParamsFailed;;
			print json_encode ( $result );
			return ;
		}
		// password does not match password repeat
		if ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
			$result->Error  = FEEDBACK_PASSWORD_REPEAT_WRONG;
			print json_encode ( $result );
			return ;
		}
		// password too short
		if (strlen($_POST['user_password_new']) < 6) {
			$result->Error = FEEDBACK_PASSWORD_TOO_SHORT;
			print json_encode ( $result );
			return ;
		}
		// check if we have a constant HASH_COST_FACTOR defined
		// if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
		$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
	
		// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
		// the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
		// compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
		// want the parameter: as an array with, currently only used with 'cost' => XX.
		$user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
	
		$user_model = $this->loadModel('Users');
	
		$result->Data = $user_model->setNewPassword ($_POST["user_id"] ,$user_password_hash);
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
	
	/*
	 * 获取商家APP账号列表
	* parms: name user_type 1 ADMIN 2 APP 3 STAFF
	*/
	public function searchApps() {
		$result = new DataResult ();
		if (! isset ( $_SESSION["user_shop"] ) or empty ( $_SESSION["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['name'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		if (! isset ( $_POST ['user_type'] ) OR empty($_POST['user_type'])) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		$user_model = $this->loadModel('Users');
	
		$result = $user_model->search ($_POST ['name'],$_SESSION["user_shop"],$_POST ['user_type']);
		$result->Error = ErrorType::Success;
	
		print  json_encode ( $result );
	}
}