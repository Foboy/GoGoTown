<?php

/**
 * Class Auth
 * Simply checks if user is logged in. In the app, several controllers use Auth::handleLogin() to
 * check if user if user is logged in, useful to show controllers/methods only to logged-in users.
 */
class Auth
{
    public static function handleLogin()
    {
        // initialize the session
        Session::init();

        // if user is still not logged in, then destroy session, handle user as "not logged in" and
        // redirect user to login page
        if (!isset($_SESSION['user_logged_in'])) {
        	// user has remember-me-cookie ? then try to login with cookie ("remember me" feature)
        	$login_successful = false;
        	if (isset($_COOKIE['rememberme'])) {
        		$controller = new Controller();
        		$login_model = $controller->loadModel('Login');
        		$login_successful = $login_model->loginWithCookie();
        	}
        	if(!$login_successful)
        	{
        		$_SESSION["feedback_negative"][] = "δ��½";
            	header('location: ' . URL . 'login/unloginresponse');
        	}
        }
    }
    
    public static function handleLoginWithUserType($userType)
    {
    	Auth::handleLogin();
    	if(isset($_SESSION['user_logged_in']))
    	{
    		if($_SESSION['user_type'] !=$userType)
    		{
	            $_SESSION["feedback_negative"][] = "登陆账号权限不符!";
	    		header('location: ' . URL . 'login/unloginresponse');
    		}
    	}
    }
}
