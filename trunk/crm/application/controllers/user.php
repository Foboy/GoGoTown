<?php

class user extends Controller
{
	/**
	 * Construct this object by extending the basic Controller class
	 */
	public function __construct()
	{
		parent::__construct();
	
		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		Auth::handleLogin();
	}
	
	public function info(){
		$result = new DataResult();
		json_encode($result);
	}
}