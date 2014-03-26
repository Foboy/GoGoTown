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
            	Session::destroy();
            	header('location: ' . URL . 'login/unloginresponse');
        	}
        }
    }
}
