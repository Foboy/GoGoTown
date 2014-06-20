<?php
// error_reporting ( E_ALL );
// // error_reporting(0);
// ini_set ( "display_errors", 1 );
// require_once '../excelHandle/excelConfig.php';
// require_once '../libs/dashbordtimetype.php';
class report_handle {
	/*
	 * params type: "appuser"查询app用户销售记录,"ages"按年龄查询消费记录,""默认按年月日查询销售记录 data: 账单数据
	 */
	public static function reportinit($type, $data, $stime, $etime,$arr_users) {
		$bdata = array (
				"Amount" => 0,
				"sys_time" => "" 
		);
		
		if (empty ( $type )) {
			
			for($i = 0; $i < count ( $data ); $i ++) {
				while ( list ( $key, $val ) = each ( $data [$i] ) ) {
					if ($key == "sys_time") {
						$bdata [$key] = $val;
					}
					if ($key == "Amount") {
						$bdata [$key] = $val;
					}
				}
				$data [$i] = $bdata;
			}
			
			$type = "";
			
			$days = round ( ($etime - $stime) / (24 * 3600) );
			// echo $days;
			if ($days < 2) {
				$type = dashbordtimetype::byhour;
			} elseif ($days <= 31) {
				$type = dashbordtimetype::byday;
			} else {
				$type = dashbordtimetype::bymonth;
			}
		}
		
		switch ($type) {
			case dashbordtimetype::byhour :
			 return	report_handle::report_hours ( $data, $stime, $etime ,$type);
				break;
			case dashbordtimetype::byday :
				return	report_handle::report_days ( $data, $stime, $etime ,$type);
				break;
			case dashbordtimetype::bymonth :
				return	report_handle::report_months ( $data, $stime, $etime,$type );
				break;
			case "appuser" :
				return	report_handle::report_appuser ($arr_users, $data, $stime, $etime ,$type);
				break;
		}
	}
	public static function report_hours($data, $stime, $etime,$type) {
		$resut = array ();
		for($i = 0; $i <= 24; $i ++) {
			$arr = array ();
			$amount = 0;
			for($j = 0; $j < count ( $data ); $j ++) {
				
				$time = strtotime ( $data [$j] ["sys_time"] );
				if (date ( "H", $time ) == $i) {
					$amount = $amount + $data [$j] ["Amount"];
				}
			}
			array_push ( $arr, $i, $amount );
			array_push ( $resut, $arr );
		}
		
		return array(
			"type"=>$type,
			"data"=>$resut
		);
	}
	public static function report_days($data, $stime, $etime,$type) {
		$days = round ( ($etime - $stime) / (24 * 3600) );
		
		$resut = array ();
		$nextday = $stime;
		for($i = 1; $i <= $days; $i ++) {
			$arr = array ();
			$amount = 0;
			for($j = 0; $j < count ( $data ); $j ++) {
				
				$time = strtotime ( $data [$j] ["sys_time"] );
				if (date ( "d", $time ) == date ( "d", $nextday )) {
					$amount = $amount + $data [$j] ["Amount"];
				}
			}
			array_push ( $arr, $nextday, $amount );
			array_push ( $resut, $arr );
			$nextday = $stime + 24 * 3600 * $i;
		}
		
		return  array(
			"type"=>$type,
			"data"=>$resut
		);
	}
	public static function report_months($data, $stime, $etime,$type) {
		// echo strtotime(date("Y-m",$stime));
		$resut = array ();
		
		$timespan = report_handle::format ( date ( "Y-m-d", $stime ), date ( "Y-m-d", $etime + 24 * 3600 - 1 ) );
		$y = $timespan ["yearly"];
		
		for($a= 0; $a <= $y; $a ++) {
			$mmax = 0;
			$mmin = 0;
			if (( int ) date ( "Y", $stime ) != ( int ) date ( "Y", $etime )) {
				
				//如果不在同一年
				if ($a > 0) {//如果不是第一年
					if ($a == $y) {//如果循环到最后一年
						$mmin = 1;
						$mmax = ( int ) date ( "m", $etime );
					} else {
						$mmin = 1;
						$mmax = 12;
					}
				} else {//如果是第一年
					$mmin = ( int ) date ( "m", $stime );
					$mmax = 12;
				}
			} else {//如果是同一年
				$mmin = ( int ) date ( "m", $stime );
				$mmax = ( int ) date ( "m", $etime );
			}
			//echo $mmin."||".$mmax;
			for($i = $mmin; $i <= $mmax; $i ++) {
				$arr = array ();
				$amount = 0;
				for($j = 0; $j < count ( $data ); $j ++) {
					
					$time = strtotime ( $data [$j] ["sys_time"] );
					if (date ( "m", $time ) == $i&&date ( "Y", $time )==( int ) date ( "Y", $stime )+$a) {
						$amount = $amount + $data [$j] ["Amount"];
					}
				}
			  $dtime =	mktime(0,0,0,$i,0,( int ) date ( "Y", $stime )+$a);
				array_push ( $arr, $dtime, $amount );
				array_push ( $resut, $arr );
			}
		}
		
		return array(
			"type"=>$type,
			"data"=>$resut
		);
	}
	public static function report_appuser($arr_users,$data, $stime, $etime) {
		 //echo strtotime(date("Y-m",$stime));
// 		$arr_users = array (); // appusername数组
		
		$arr_app_num = array (); // 单个销售额data数组
		$arr_app_nums = array (); // 销售额data数组
		$amount = 0;
		
		$arr_res_datas = array ();
		$colors = array (
				"#16A085",
				"#27AE60",
				"#2980B9",
				"#2C3E50",
				"#F39C12",
				"#D35400",
				"#C0392B",
				"#BDC3C7",
				"#7F8C8D" 
		);
		//echo json_encode($arr_users);
		

		// echo json_encode($arr_users);
		// echo json_encode($arr_app_nums);
		$num = 0; // 销售额偏移量
		for($i = 0; $i < count ( $arr_users ); $i ++) {
			
			if(Count($arr_app_nums)<count ( $arr_users ))
			{
				array_push ( $arr_app_num, $num * 2 );
				array_push ( $arr_app_num, 0 );
				array_push ( $arr_app_nums, $arr_app_num );
				$arr_app_num = array ();
				$num ++;
			}
			
			for($j = 0; $j < count ( $data ); $j ++) {
				$appusername = "";
				// echo json_encode($arr_app_nums [$i])."_____";
				if (! empty ( $data [$j]->appusername )) {
					$appusername = $data [$j]->appusername;
				} else {
					$appusername = "";
					continue;
				}
				//echo $appusername."||". $arr_users [$i]."......";
				if ($appusername == $arr_users [$i]) {
					
					$arr_app_nums [$i] [1] = $arr_app_nums [$i] [1] + $data [$j]->Amount;
					//echo json_encode($arr_app_nums [$i]);
				}
			}
			
			$arr_res_data = array (
					"data" => array (
							$arr_app_nums [$i]
					),
					"color" => $colors [array_rand ( $colors )] 
			);
			// echo json_encode($arr_res_data);
			// $arr_res_data->data=$arr_app_nums [$i];
			// $arr_res_data->color=array_rand($colors);
			array_push ( $arr_res_datas, $arr_res_data );
			// echo json_encode($arr_app_nums);
		}
		$resut = array (
				"name" => $arr_users,
				"datas" => $arr_res_datas 
		);
		return   $resut ;
	}
	static function format($a, $b) {
		// 检查两个日期大小，默认前小后大，如果前大后小则交换位置以保证前小后大
		if (strtotime ( $a ) > strtotime ( $b ))
			list ( $a, $b ) = array (
					$b,
					$a 
			);
		$start = strtotime ( $a );
		$stop = strtotime ( $b );
		$extend = ($stop - $start) / 86400;
		$result ['extends'] = $extend;
		if ($extend < 7) { // 如果小于7天直接返回天数
			$result ['daily'] = $extend;
		} elseif ($extend <= 31) { // 小于28天则返回周数，由于闰年2月满足了
			if ($stop == strtotime ( $a . '+1 month' )) {
				$result ['monthly'] = 1;
			} else {
				$w = floor ( $extend / 7 );
				$d = ($stop - strtotime ( $a . '+' . $w . ' week' )) / 86400;
				$result ['weekly'] = $w;
				$result ['daily'] = $d;
			}
		} else {
			$y = floor ( $extend / 365 );
			if ($y >= 1) { // 如果超过一年
				$start = strtotime ( $a . '+' . $y . 'year' );
				$a = date ( 'Y-m-d', $start );
				// 判断是否真的已经有了一年了，如果没有的话就开减
				if ($start > $stop) {
					$a = date ( 'Y-m-d', strtotime ( $a . '-1 month' ) );
					$m = 11;
					$y --;
				}
				$extend = ($stop - strtotime ( $a )) / 86400;
			}
			if (isset ( $m )) {
				$w = floor ( $extend / 7 );
				$d = $extend - $w * 7;
			} else {
				$m = isset ( $m ) ? $m : round ( $extend / 30 );
				$stop >= strtotime ( $a . '+' . $m . 'month' ) ? $m : $m --;
				if ($stop >= strtotime ( $a . '+' . $m . 'month' )) {
					$d = $w = ($stop - strtotime ( $a . '+' . $m . 'month' )) / 86400;
					$w = floor ( $w / 7 );
					$d = $d - $w * 7;
				}
			}
			$result ['yearly'] = $y;
			$result ['monthly'] = $m + $y * 12;
			$result ['weekly'] = $w;
			$result ['daily'] = isset ( $d ) ? $d : null;
		}
		return $result;
	}
}

// $bills_model = new BillsModel ( new Database () );

// $sdate = "2013-04-19";
// $edate = "2014-05-18";

// $stime = strtotime ( $sdate );
// $etime = strtotime ( $edate );
// $data = $bills_model->searchReport ( date ( "Y-m-d H:i:s", $stime ), date ( "Y-m-d H:i:s", $etime + 24 * 3600 - 1 ), 1 );
// // echo json_encode($data);
// $m = new report_handle ();
// $test = $m->format ( date ( "Y-m-d", $stime ), date ( "Y-m-d", $etime + 24 * 3600 - 1 ) );
// //echo json_encode ( $test );
// $m->reportinit ( "", $data, $stime, $etime );

