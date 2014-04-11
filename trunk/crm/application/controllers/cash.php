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
		$customer_id = $_POST['customer_id'];
		$validate_model = $this->loadModel('Validation');
		$code = rand(100000,999999);
		$inserted = $validate_model->insert($code,ValidateType::GoPay,$customer_id);

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
		$customer_id = $_POST['customer_id'];
		$amount = $_POST['amount'];
		$shop_id = $_SESSION ['user_shop'];
		$code = $_POST['code'];
		$type_ids = json_decode($_POST['type_ids']);
		
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
		$bill_id = $bill_model->insert($shop_id,$customer_id,PayMethodType::GoGoPay,0,ceil($amount),$type_ids[0],$amount,time());
		if($bill_id > 0)
		{
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
		$bills = $bill_model->searchByPages($shop_id,0,0,'',0,0,'',0,$page_index,20);
		$result->Id = $bills->totalcount;
		$result->Data = $bills->Data;
		print json_encode($result);
	}
}