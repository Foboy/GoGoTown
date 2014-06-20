<?php
class home extends Controller {
	public function __construct() {
		parent::__construct ();

		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		Auth::handleLogin ();
	}
	public function SaleTotalTrendGraphByTime() {
		$result = new DataResult ();

		if (! isset ( $_SESSION ["user_shop"] ) or empty ( $_SESSION ["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['create_time1'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['create_time2'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		$sdate = $_POST ['create_time1'];
		$edate = $_POST ['create_time2'];
		$stime = strtotime ( $sdate );
		$etime = strtotime ( $edate );

		$bills_model = $this->loadModel ( 'Bills' );

		$days = round ( ($etime - $stime) / (24 * 3600) );
		if ($days < 2) {
			$data = $bills_model->searchReport ( date ( "Y-m-d H:i:s", $etime ), date ( "Y-m-d H:i:s", $etime + 24 * 3600 - 1 ), $_SESSION ["user_shop"] );
			$today = report_handle::reportinit ( "", $data, $etime, $etime ,"");

			$data = $bills_model->searchReport ( date ( "Y-m-d H:i:s", $stime ), date ( "Y-m-d H:i:s", $stime + 24 * 3600 - 1 ), $_SESSION ["user_shop"] );
			$yesterday = report_handle::reportinit ( "", $data, $stime, $stime ,"");

			$result->Data = array (
					"type" => $today ["type"],
					"today" => $today ["data"],
					"yesterday" => $yesterday ["data"]
			);
		} else {
			$data = $bills_model->searchReport ( date ( "Y-m-d H:i:s", $stime ), date ( "Y-m-d H:i:s", $etime ), $_SESSION ["user_shop"] );
			$res = report_handle::reportinit ( "", $data, $stime, $etime );

			$result->Data = array (
					"type" => $res ["type"],
					"data" => $res ["data"]
			);
		}

		print json_encode ( $result );
	}
	public function AppuserTrendGraphByTime() {
		$result = new DataResult ();

		if (! isset ( $_SESSION ["user_shop"] ) or empty ( $_SESSION ["user_shop"] )) {
			$result->Error = ErrorType::Unlogin;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['create_time1'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		if (! isset ( $_POST ['create_time2'] )) {
			$result->Error = ErrorType::RequestParamsFailed;
			print json_encode ( $result );
			return;
		}
		$sdate = $_POST ['create_time1'];
		$edate = $_POST ['create_time2'];
		$stime = strtotime ( $sdate );
		$etime = strtotime ( $edate );

		$bills_model = $this->loadModel ( 'Bills' );

		$arr_users = $bills_model->searchReportofAppUser ( $_SESSION ["user_shop"] );
		$data = $bills_model->searchReport ( date ( "Y-m-d H:i:s", $stime ), date ( "Y-m-d H:i:s", $etime ), $_SESSION ["user_shop"] );

		$arr_us = array ();
		for($i = 0; $i < count ( $arr_users ); $i ++) {
			while ( list ( $key, $val ) = each ( $arr_users [$i] ) ) {
				array_push ( $arr_us, $val );
			}
		}
		$res = report_handle::reportinit ( "appuser", $data, $stime, $etime, $arr_us );
		// print json_encode($arr_us);
		$result->Data = $res;

		print json_encode ( $result );
	}
}

