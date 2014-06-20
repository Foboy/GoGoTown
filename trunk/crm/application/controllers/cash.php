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
			$_SESSION["app_custormer_id"] = $serverresult->data->balance->id;
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

	private function newvalidatecode()
	{

		$phone = $_SESSION["app_custormer_phone"];
		$customer_id = $_SESSION["app_custormer_id"];
		$validate_model = $this->loadModel('Validation');
		$code = rand(100000,999999);

		$inserted = $validate_model->insert($code,ValidateType::GoPay,$customer_id);

		if($inserted)
		{
			$cash_model = $this->loadModel('Cash');
			$msg = "消费验证码：$code ，欢迎使用GO币支付。";
			$cash_model->sendValidCode($phone,$msg);
		}

		return  $inserted;
	}

	public function sendvalidatecode()
	{
		$result = new DataResult ();
		$inserted = $this->newvalidatecode();
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
		$logger = new Logger();

		$result = new DataResult ();
		if (!isset($_POST['code']) OR empty($_POST['code'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="验证码不能为空";
			print json_encode($result);
			return;
		}
		try
		{

			$customer_id = $_SESSION["app_custormer_id"];
			$shop_id = $_SESSION ['user_shop'];
			$user_id = $_SESSION ['user_id'];
			$order_id = $_SESSION ['order_id'];
			$type_id = $_SESSION ['type_id'];
			$pay_go_coin = $_SESSION ['pay_go_coin'];
			$go_order_no = $_SESSION ['go_order_no'];
			$lakala_order_no = $_SESSION ['lakala_order_no'];
			$amount = $_SESSION ['amount'];
			$pay_method = $_SESSION ['pay_method'];
			$code = $_POST['code'];

			$validate_model = $this->loadModel('Validation');
			if(!$validate_model->validation($code,ValidateType::GoPay,$customer_id))
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="验证码不正确";
				print json_encode($result);
				return;
			}
			$logger->debug("insert bill");
			//扣除GO币
			$go_pay_success = true;
			if($go_pay_success)
			{
				$pay_status = OrderStatus::GoPaySuccess;
				if($pay_method == PayMethodType::GoGoPay)
				{
					$pay_status = OrderStatus::Success;
				}
				$logger->debug("insert bill");
				$order_model = $this->loadModel('Orders');
				$logger->debug("updatestatus");
				$order_model = $order_model->updateStatus($shop_id,$go_order_no,$pay_status);
				$logger->debug("update end");
			}
			else
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="GO币扣除失败";
				print json_encode($result);
				return;
			}
			if($pay_method == PayMethodType::GoGoPay)
			{
				$bill_model = $this->loadModel('Bills');

				$bill_id = $bill_model->insert($shop_id,$customer_id,PayMethodType::GoGoPay,0,$pay_go_coin,$type_id,$amount,time(),$user_id,$lakala_order_no);
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
			else
			{
				$result->Error = ErrorType::Success;
				$result->ErrorMessage ="GO币支付成功";
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

	public function submitorder()
	{
		try {
		$result = new DataResult ();
		if (!isset($_POST['pay_method']) OR empty($_POST['pay_method'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="数据不完整:Error 0001";
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
		if (!isset($_POST['go_coin']) OR empty($_POST['go_coin'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="GO币支付数量不能为空";
			print json_encode($result);
			return;
		}
		if (!isset($_POST['lakala_cash']) OR empty($_POST['lakala_cash'])) {
			$result->Error = ErrorType::Failed;
			$result->ErrorMessage ="刷卡金额不能为空";
			print json_encode($result);
			return;
		}
		$proportion = floatval($_SESSION["app_custormer_proportion"]);
		$amount = floatval($_POST['amount']);
		$shop_id = $_SESSION ['user_shop'];
		$user_id = $_SESSION ['user_id'];
		$type_ids = json_decode($_POST['type_ids']);
		$pay_method = $_POST["pay_method"];
		$go_coin = intval($_POST["go_coin"]);
		$go_cash = $proportion * $go_coin;
		$lakala_cash = floatval($_POST["lakala_cash"]);
		if($pay_method == PayMethodType::GoGoPay)
		{
			if($go_cash < $amount)
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="Go币支付金额不足";
				print json_encode($result);
				return;
			}
			$go_cash = $amount;
		}
		else if($pay_method == PayMethodType::Cash)
		{
			$go_coin = 0;
			$go_cash = 0;
		}
		if($pay_method == PayMethodType::GoGoPay || $pay_method == PayMethodType::Multiply)
		{
			$inserted = $this->newvalidatecode();
			if(!$inserted)
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage ="发送验证码失败";
				print json_encode($result);
				return;
			}
		}



		$go_order_no ="G" . time() . substr("000000" . $shop_id, -6) . rand(1000, 9999);
		$lakala_order_no = "L" . time() . substr("000000" . $shop_id, -6) . rand(1000, 9999);
		$order_id = $this->neworder($pay_method, $go_cash, $go_coin, $lakala_cash, $amount,$go_order_no,$lakala_order_no);
		if($order_id >0)
		{
			$_SESSION ['order_id'] = $order_id;
			$_SESSION ['amount'] = $amount;
			$_SESSION ['pay_method'] = $pay_method;
			$_SESSION ['type_id'] = $type_ids[0];
			$_SESSION ['pay_go_coin'] = $go_coin;
			$_SESSION ['go_order_no'] = $go_order_no;
			$_SESSION ['lakala_order_no'] = $lakala_order_no;
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
				$result->ErrorMessage ="生成订单失败" . $e->getMessage();
				print json_encode($result);
				return;
		}
	}

	//订单流水号生成
	//订单流水规则
	//1396972800（时间戳10位）+商铺ID（6位）+随机码（4位）
	private function neworder($pay_method,$go_cash,$go_coin,$lakala_cash,$amount,$go_order_no,$lakala_order_no)
	{

			$customer_id = $_SESSION["app_custormer_id"];
			$shop_id = $_SESSION ['user_shop'];
			$app_user_id = $_SESSION ['user_id'];
			$status = OrderStatus::Init;
			$order_model = $this->loadModel('Orders');
			return $order_model->insert($shop_id,$customer_id,$pay_method,$go_cash,$go_coin,$lakala_cash,$status,$amount,$app_user_id,$lakala_order_no,$go_order_no);

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