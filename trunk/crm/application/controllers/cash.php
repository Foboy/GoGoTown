<?php

class Cash extends Controller
{
	function __construct()
	{
		parent::__construct();
		Auth::handleLoginWithUserType(UserType::ShopApp);
	}
}