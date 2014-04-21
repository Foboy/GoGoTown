<?php

class CashModel
{
	private function getrpcclient()
	{
		require 'libs/phprpc/phprpc_client.php';
		$rpc_client = new PHPRPC_Client();
		$rpc_client->setProxy(NULL);
		$rpc_client->useService('http://192.168.0.47/Api32/GoCurrency');
		//$rpc_client->setKeyLength(1024);
		//$rpc_client->setEncryptMode(3);
		return $rpc_client;
	}
	public function getgocoin($phone)
	{
		/*
		$rpc_client = $this->getrpcclient();
		$name = array($phone);
		return $rpc_client->invoke('getBalance',$name);
		*/

		if($phone == "15882323654")
		{
			$result = json_decode('{"status":1,"info":"version:3.2","data":{"balance":{"balance":500,"name":"Mr. Zhang","limit":400,"proportion":0.8,"id":2,"hash":""}}}');
			
		}
		else 
		{
			$result = json_decode('{"status":0,"info":"缺少 mobile 或类型错误","data":""}');
		}
		return  $result;
	}
	
	public function getcatalogs($shop_id)
	{
		/*
			$rpc_client = $this->getrpcclient();
		$name = array($phone);
		return $rpc_client->invoke('hello',$name);
		*/
		$result = json_decode('{"status":1,"info":"version:3.2","data":[{"name":"衣服","id":1},{"name":"裤子","id":2},{"name":"鞋子","id":3},{"name":"帽子","id":4},{"name":"其他","id":5}]}');
		return  $result;
	}
}