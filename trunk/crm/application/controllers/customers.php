<?php

class customers extends Controller
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
	//	Auth::handleLogin();
	}
	
	public function info(){
		$result = new DataResult();
		json_encode($result);
	}
	public  function  search()
	{
		$result = new DataResult();
		
		$customers_model = $this->loadModel('customers');
		
		$result = $customers_model ->search('','','');
		$result->Error=ErrorType::Success;
		
		return  json_encode($result);
	}
	
	public function  add()
	{
		$result = new DataResult();
		
// 		if (!isset($_POST['name']) OR empty($_POST['name'])) {
// 			$result->Error=ErrorType::Failed;
// 			return json_encode($result);
// 		}
// 		if (!isset($_POST['phone']) OR empty($_POST['phone'])) {
// 			$result->Error=ErrorType::Failed;
// 			return json_encode($result);
// 		}
// 		if (!isset($_POST['rank']) OR empty($_POST['rank'])) {
// 			$result->Error=ErrorType::Failed;
// 			return json_encode($result);
// 		}
		
// 		$name=$_POST['name'];
// 		$phone=$_POST['phone'];	
// 		$rank=$_POST['rank'];
		
		$name="test";
		$phone="13888888";
		$rank="11";
		
		$customers_model = $this->loadModel('customers');
		
		$result->Data=$customers_model->insert($name,$phone,$rank);
		
		return json_encode($result);
	
	}



}