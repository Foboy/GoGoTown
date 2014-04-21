<?php

include('libs/phprpc/phprpc_server.php');
class TestHello
{
	function hello($name) {
		$name = 'Hello ' . $name;
		return 'Hello ' . $name;
	}
}
$server = new PHPRPC_Server();
$server->add('hello',new TestHello());
$server->start();