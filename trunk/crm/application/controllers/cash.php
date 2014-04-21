<?php

class Cash extends Controller
{
	function __construct()
	{
		parent::__construct();
		Auth::handleLoginWithUserType(UserType::ShopApp);
	}
	

	public  function  getgoinfo()
	{
		
		$result = new DataResult ();
		
		if (!isset($_POST['phone']) OR empty($_POST['phone'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="电话号码不能为空";
			print json_encode($result);
			return;
		}
		$phone = $_POST['phone'];
	
		$cash_model = $this->loadModel('Cash');
		
		$serverresult = $cash_model->getgocoin($phone);
		if($serverresult->status == 1)
		{
			$result->Error = ErrorType::Success;
			$result->Data = $serverresult->data->balance;
			$_SESSION["app_custormer_gocoin"] = $serverresult->data->balance->balance;
			$_SESSION["app_custormer_phone"] = $phone;
			$_SESSION["app_custormer_proportion"] = $serverresult->data->balance->proportion;
		}
		else 
		{
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage = $serverresult->info;
		}
		print  json_encode ( $result ) ;
	}
	
	public function sendvalidatecode()
	{
		$result = new DataResult ();
		if (!isset($_POST['customer_id']) OR empty($_POST['customer_id'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="客户ID不能为空";
			print json_encode($result);
			return;
		}
		if (!isset($_POST['phone']) OR empty($_POST['phone'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="电话号码不能为空";
			print json_encode($result);
			return;
		}
		$phone = $_POST['phone'];
		$customer_id = $_POST['customer_id'];
		$validate_model = $this->loadModel('Validation');
		$code = rand(100000,999999);
		$inserted = $validate_model->insert($code,ValidateType::GoPay,$customer_id);
		$cash_model = $this->loadModel('Cash');
		$msg = "消费验证码：$code ，欢迎使用GO币支付。";
		$cash_model->sendValidCode($phone,$msg);

		if($inserted)
		{
			//send code to customer
			$result->Error = ErrorType::Success;
		}
		else 
		{
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage = "生成验证码失败";
		}
		print json_encode($result);
	}
	
	public function gopayvalid()
	{
		$result = new DataResult ();
		if (!isset($_POST['customer_id']) OR empty($_POST['customer_id'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="数据不完整:ErrorCode 0001";
			print json_encode($result);
			return;
		}
		if (!isset($_POST['amount']) OR empty($_POST['amount'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="数据不完整:ErrorCode 0002";
			print json_encode($result);
			return;
		}
		if (!isset($_POST['type_ids']) OR empty($_POST['type_ids'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="数据不完整:ErrorCode 0003";
			print json_encode($result);
			return;
		}
		if (!isset($_POST['code']) OR empty($_POST['code'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="验证码不能为空";
			print json_encode($result);
			return;
		}
		


		try
		{
			
			$customer_id = $_POST['customer_id'];
			$amount = floatval($_POST['amount']);
			$shop_id = $_SESSION ['user_shop'];
			$user_id = $_SESSION ['user_id'];
			$code = $_POST['code'];
			$type_ids = json_decode($_POST['type_ids']);
			
			$proportion = floatval($_SESSION["app_custormer_proportion"]);
			$go_coin = intval($_SESSION["app_custormer_gocoin"]);
			
			$need_go_coin = $amount/$proportion;
			
			$pay_go_coin = ceil($need_go_coin);
			
			if($pay_go_coin > $go_coin)
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="GO币不足!";
				print json_encode($result);
				return;
			}
			
			
			
			
			$validate_model = $this->loadModel('Validation');
			if(!$validate_model->validation($code,ValidateType::GoPay,$customer_id))
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="验证码不正确";
				print json_encode($result);
				return;
			}
			//扣除GO币
			$bill_model = $this->loadModel('Bills');
			$bill_id = $bill_model->insert($shop_id,$customer_id,PayMethodType::GoGoPay,0,$pay_go_coin,$type_ids[0],$amount,time(),$user_id,time());
			if($bill_id > 0)
			{
				$shopcustomers_model = $this->loadModel ( 'ShopCustomers' );
				
				$shopcustomers_model->insert ($shop_id, $customer_id,CustomerFromType::GOGOCustomer,CustomerType::PurchaseCustomer,time() );
				$shopcustomers_model->update ($shop_id, $customer_id,CustomerFromType::GOGOCustomer,CustomerType::PurchaseCustomer,time() );
				$result->Error = ErrorType::Success;
				print json_encode($result);
				return;
			}
			else
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="生成订单失败";
				print json_encode($result);
				return;
			}
		}
		catch(Exception $e)
		{ 
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage =$e->getMessage();
			print json_encode($result);
			return;
		}
		

		
	}
	
	public function getbills()
	{
		$result = new DataResult ();
		if (!isset($_POST['page_index']) OR empty($_POST['page_index'])) {
			$page_index = 0;
		}
		else 
		{
			$page_index = $_POST['page_index'];
		}
		$shop_id = $_SESSION ['user_shop'];
		$bill_model = $this->loadModel('Bills');
		$bills = $bill_model->searchByMobiles($shop_id,0,0,'',0,0,'',0,$page_index,20);
		$result->Id = $bills->totalcount;
		$result->Data = $bills->Data;
		print json_encode($result);
	}
}