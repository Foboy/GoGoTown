<?php
class customermeta
{
	public $name;
	public  $phone;
	public  $sex;
	public  $birthday;
	public  $remark;
}
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
	public  function  get()
	{
		$result = new DataResult();
	
		$customers_model = $this->loadModel('Customers');
	
		$result->Data = $customers_model ->get(20);
		$result->Error=ErrorType::Success;
	
		print  json_encode($result);
	}
	public  function  search()
	{
		$result = new DataResult();
		
		$customers_model = $this->loadModel('Customers');
		
		$result = $customers_model ->search();
		$result->Error=ErrorType::Success;
		
		print  json_encode($result);
	}
public  function  del()
{
	$result = new DataResult();
	
	$customers_model = $this->loadModel('Customers');
	
	$result->Data = $customers_model ->delete(20);
	$result->Error=ErrorType::Success;
	
	print  json_encode($result);
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
		
		$_customermeta=new customermeta();
		
		$_customermeta->name="test";
		$_customermeta->phone="13888888";
		$_customermeta->sex="11";
		$_customermeta->birthday= time();
		$_customermeta->remark="放多久11";
		
// 		$result->Data=$_customermeta;
		
// 		$customers_model = $this->loadModel('customers');
		$customers_model = $this->loadModel('Customers');
		
		$result->Data=$customers_model->insert($_customermeta->name,$_customermeta->phone,$_customermeta->sex,$_customermeta->birthday,$_customermeta->remark);
		
		print json_encode($result);
	
	}
public function searchBP()
{
	$result = new PageDataResult();
	$customers_model = $this->loadModel('Customers');

	$result = $customers_model ->searchByPages("","","","","",0,5);
	$result->Error=ErrorType::Success;
	
	print  json_encode($result);
}


}
