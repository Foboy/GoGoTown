<?php
class Messages extends Controller {
	/**
	 * 商家发送信息管理接口
	 */
	public function __construct() {
		parent::__construct ();
		
		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		// Auth::handleLogin();
	}
	/*
	 * 商家发送信息接口通过会员等级 parms: rank_id title content
	*/
	public  function sendByrank()
	{
		$result = new DataResult ();
		
		if (! isset ( $_SESSION ["user_shop"] ) or empty ( $_SESSION ["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return;
		}
		
		if (! isset ( $_POST ['rank_id'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['title'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['content'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		
		$messages_model = $this->loadModel ( 'Messages' );
		$mslist_model = $this->loadModel ( 'MessageSendList' );
		
		$rank_model = $this->loadModel ( 'Rank' );
		$ids=$rank_model->searchCustomerIDByRank($_POST ['rank_id'] );
		
		
		//$ids = explode ( ',', trim ( $_POST ['customer_ids'] ) );
		$stime = time ();
		
		//判断群发只能一周发一次
		if(count ( $ids )>0)
		{
			$lastmsg=$messages_model->get($_SESSION ["user_shop"]);
				
			$lasttime=$lastmsg->Data->Create_Time;
			$days =(int)(($stime-$lasttime)/(24*3600));
			if($days<7)
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage=FEEDBACK_MSG_TIME_FAILED;
				print json_encode ( $result );
				return;
			}else
			{
				//插入商铺发送信息表
				$mid = $messages_model->insert ( $_SESSION ["user_shop"], MessageType::GOGO, $_POST ['title'], $_POST ['content'], $stime, $stime, MessageState::IsSent );
				if ($mid < 1) {
					$result->Error = ErrorType::Failed;
					print json_encode ( $result );
					return;
				}
				//插入商铺客户对应信息表
				for($index = 0; $index < count ( $ids ); $index ++) {
					$mslist_model->insert( $ids [$index], $_SESSION ["user_shop"], $mid, $_POST ['title'], $_POST ['content'],  MessageState::IsSent, MessageType::GOGO );
				}
		
				$result->Error = ErrorType::Success;
				print json_encode ( $result );
			}
		
		}else
		{
			//插入商铺发送信息表
			$mid = $messages_model->insert ( $_SESSION ["user_shop"], MessageType::GOGO, $_POST ['title'], $_POST ['content'], $stime, $stime, MessageState::IsSent );
			if ($mid < 1) {
				$result->Error = ErrorType::Failed;
				print json_encode ( $result );
				return;
			}
			//插入商铺客户对应信息表
			$mslist_model->insert( $ids [0], $_SESSION ["user_shop"], $mid, $_POST ['title'], $_POST ['content'],  MessageState::IsSent, MessageType::GOGO );
		
			$result->Error = ErrorType::Success;
			print json_encode ( $result );
		}
	}

	/*
	 * 商家发送信息接口 parms: customer_ids title content
	 */
	public function send() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION ["user_shop"] ) or empty ( $_SESSION ["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return;
		}
		
		if (! isset ( $_POST ['customer_ids'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['title'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['content'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		
		$messages_model = $this->loadModel ( 'Messages' );
		$mslist_model = $this->loadModel ( 'MessageSendList' );
		$ids = explode ( ',', trim ( $_POST ['customer_ids'] ) );
		$stime = time ();
		
		//判断群发只能一周发一次
		if(count ( $ids )>0)
		{
			$lastmsg=$messages_model->get($_SESSION ["user_shop"]);
			
			$lasttime=$lastmsg->Data->Create_Time;
		 $days =(int)(($stime-$lasttime)/(24*3600));
			if($days<7)
			{
				$result->Error = ErrorType::Failed;
				$result->ErrorMessage=FEEDBACK_MSG_TIME_FAILED;
				print json_encode ( $result );
				return;
			}else 
			{
				//插入商铺发送信息表
				$mid = $messages_model->insert ( $_SESSION ["user_shop"], MessageType::GOGO, $_POST ['title'], $_POST ['content'], $stime, $stime, MessageState::IsSent );
				if ($mid < 1) {
					$result->Error = ErrorType::Failed;
					print json_encode ( $result );
					return;
				}
				//插入商铺客户对应信息表
				for($index = 0; $index < count ( $ids ); $index ++) {
					$mslist_model->insert( $ids [$index], $_SESSION ["user_shop"], $mid, $_POST ['title'], $_POST ['content'],  MessageState::IsSent, MessageType::GOGO );
				}
				
				$result->Error = ErrorType::Success;
				print json_encode ( $result );
			}
				
		}else 
			{
		//插入商铺发送信息表
		$mid = $messages_model->insert ( $_SESSION ["user_shop"], MessageType::GOGO, $_POST ['title'], $_POST ['content'], $stime, $stime, MessageState::IsSent );
		if ($mid < 1) {
			$result->Error = ErrorType::Failed;
			print json_encode ( $result );
			return;
		}
		//插入商铺客户对应信息表
		$mslist_model->insert( $ids [0], $_SESSION ["user_shop"], $mid, $_POST ['title'], $_POST ['content'],  MessageState::IsSent, MessageType::GOGO );
	
		$result->Error = ErrorType::Success;
		print json_encode ( $result );
			}
	}
	/*
	 * 商家获取已发送信息接口 
	 * parms: pageindex
	 */
	public function searchBP() {
		$result = new DataResult ();
		
		if (! isset ( $_SESSION ["user_shop"] ) or empty ( $_SESSION ["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['pageindex'] ) ) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return ;
		}
		
	$messages_model = $this->loadModel ( 'Messages' );
		
		$result = $messages_model->searchByPages ( $_SESSION ["user_shop"],MessageType::GOGO ,MessageState::IsSent,$_POST ['pageindex'] ,20);
		$result->Error = ErrorType::Success;
		
		print json_encode ( $result );
	}
}