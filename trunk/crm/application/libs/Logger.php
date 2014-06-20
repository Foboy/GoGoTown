<?php
class Logger
{

	public function __construct()
	{
	}

	public function debug($msg)
	{
		$fileName = date('Y-m-d') . '.log';
		if($this->writeFile($fileName, $msg, "a"))
			return;
		$this->writeFile($fileName, $msg);
	}

	function writeFile($file,$str,$mode='w+')
	{
		$oldmask = @umask(0);
		$fp = @fopen($file,$mode);
		@flock($fp, 3);
		if(!$fp)
		{
			return false;
		}
		else
		{
			@fwrite($fp,$str);
			@fwrite($fp,"--\r\n--");
			@fclose($fp);
			@umask($oldmask);
			Return true;
		}
	}
}