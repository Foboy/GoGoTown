<?php

class user extends Controller
{
	/**
	 * 用户信息查询，登陆注册转移到这个文件
	 */
	public function __construct()
	{
		parent::__construct();
	
		//Auth::handleLogin();
	}
	/*
	 * crm客户端登陆
	 * parms user_name user_password user_type=1/3
	 */
    public  function  crmlogin()
    {
    	$result = new DataResult ();
    	
    	$login_model = $this->loadModel('Users');
    	$login_successful = $login_model->login();
    	
    	$result->Data=$login_successful;
    	if ($login_successful) {
    		
    		if($_SESSION ['user_type']==2)
    		{
    			$result->Error = ErrorType::Accessdenied;
    			print json_encode ( $result ) ;
    			return ;
    		}else 
    		{
    		$result->Data=$_SESSION ['user_type'];
    		
    		$result->Error = ErrorType::Success;
    		}
    	} else {
    		$result ->ExMessage =$_SESSION ["feedback_negative"];
    		$result->Error = ErrorType::LoginFailed;
    		
    	}
    	
    	print json_encode ( $result ) ;
    }
    /*
     * app客户端登陆
    * parms user_name user_password user_type=2
    */
    public  function  applogin()
    {
    	//sleep(6);
    	$result = new DataResult ();
        $result->Data =array();
    	$login_model = $this->loadModel('Users');
    	$login_successful = $login_model->login();
    	if ($login_successful) {
    		if($_SESSION ['user_type']!=UserType::ShopApp)
    		{
    			$result->Error = ErrorType::Accessdenied;
    			print json_encode ( $result ) ;
    			return ;
    		}else 
    		{
    			$cash_model = $this->loadModel('Cash');
    			$result->Id=$_SESSION ['user_shop'];
    			$serverresult = $cash_model->getcatalogs($result->Id);
    			if($serverresult->status == 1)
    			{
    				$result->Error = ErrorType::Success;
    				$result->Data = $serverresult->data;
    			}
    			else
    			{
    				$result->Error = ErrorType::Failed;
    				$result->ErrorMessage = $serverresult->info;
    			}
    		}
    	
    	} else {
    		$error= Session::get("feedback_negative");
    		$result->ErrorMessage = $error[0];
    		//$result->ExMessage = json_encode($_SERVER);
    		$result->Error = ErrorType::LoginFailed;

    	}
    	
    	print  json_encode ( $result ) ;
    }

    function logout()
    {
    	$result = new DataResult ();
    	$login_model = $this->loadModel('Users');
    	$result->Data = $login_model->logout();
    	print  json_encode ( $result ) ;
    }
    /**
     * Login with cookie
     */
    function loginWithCookie()
    {
    	$result = new DataResult ();
    	// run the loginWithCookie() method in the login-model, put the result in $login_successful (true or false)
    	$login_model = $this->loadModel('Users');
    	$result->Data =$login_successful = $login_model->loginWithCookie();
    
    	if ($login_successful) {
    			$result->Error = ErrorType::Success;
    	} else {
    		// delete the invalid cookie to prevent infinite login loops
    		$login_model->deleteCookie();
    		// if NO, then move user to login/index (login form) (this is a browser-redirection, not a rendered view)
    		$result->Error = ErrorType::LoginFailed;
    	}
    	print  json_encode ( $result ) ;
    }
    /**
     * 注册新用户
     * parms acount user_type user_name user_password_new user_password_repeat
     */
    public  function  register()
    {
    	$result = new DataResult ();
    	$login_model = $this->loadModel('Users');
    	$result->Data = $registration_successful = $login_model->registerNewUser();
    	
    	if ($registration_successful == true) {
 $result->Error = ErrorType::Success;
    		//  header('location: ' . URL . 'login/index');
    	} else {
    		$result->Error = ErrorType::Failed;
    		//  header('location: ' . URL . 'login/register');
    	}
    	print  json_encode ( $result ) ;
    }
    /*
     * 获取当前登陆用户信息
     */
    public  function  getCurrentUser()
    {
    	$result = new DataResult ();
    	if (! isset ( $_SESSION["user_id"] ) or empty ( $_SESSION["user_id"] )) {
    		$result->Error = ErrorType::Unlogin;
    		print json_encode ( $result );
    		return ;
    	}
    	$user_model = $this->loadModel('Users');
    	$result = $user_model->get($_SESSION["user_id"]);
        $result->Error = ErrorType::Success;
    	print  json_encode ( $result ) ;
    }
    /*
     * 启用禁用用户
     * parms user_id state 1 启用 0禁用
    */
    public  function  updateUserState()
    {
    	$result = new DataResult ();
    	if (! isset ( $_POST["user_id"] ) or empty ( $_POST["user_id"] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result );
    		return ;
    	}
    	if (! isset ( $_POST["state"] ) or empty ( $_POST["state"] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result );
    		return ;
    	}
    	$user_model = $this->loadModel('Users');
    	$result->Data = $user_model->updateUserState($_POST["state"],$_POST["user_id"]);
    	$result->Error = ErrorType::Success;
    	print  json_encode ( $result ) ;
    }
    /*
     * 修改用户名称
    * parms: name
    */
    public function updateUserName() {
    	$result = new DataResult ();
    	if (! isset ( $_POST["user_id"] ) or empty ( $_POST["user_id"] )) {
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
    
    	$result->Data = $user_model->updateShopName ($_POST ['name'],$_POST["user_id"]);
    	$result->Error = ErrorType::Success;
    
    	print  json_encode ( $result );
    }
    
}