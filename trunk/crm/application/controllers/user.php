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
    	if (! isset ( $_POST [user_type] ) or empty ( $_POST ['user_type'] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result ) ;
    		return ;
    	}else if($_POST ['user_type']==2)
    	{
    		$result->Error = ErrorType::Accessdenied;
    		print json_encode ( $result ) ;
    		return ;
    	}
    	
    	$login_model = $this->loadModel('Users');
    	$login_successful = $login_model->login();
    	
    	$result->Data=$login_successful;
    	if ($login_successful) {
    		$result->Error = ErrorType::Success;
    	} else {
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
    	$result = new DataResult ();
    	if (! isset ( $_POST [user_type] ) or empty ( $_POST ['user_type'] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result ) ;
    		return ;
    	}else if($_POST ['user_type']!=2)
    	{
    		$result->Error = ErrorType::Accessdenied;
    		print json_encode ( $result ) ;
    		return ;
    	}
    	$login_model = $this->loadModel('Users');
    	$login_successful = $login_model->login();
    	$result->Data=$login_successful;
    	if ($login_successful) {
    		$result->Error = ErrorType::Success;
    	
    	} else {
    		$result->Error = ErrorType::LoginFailed;

    	}
    	
    	echo json_encode ( $result ) ;
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
     * parms  user_type user_name user_password_new user_password_repeat
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
}