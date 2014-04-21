<?php

class DataResult
{
	public $Error;
	
	public $Id;
	
	public $ExMessage;
	
	public $ErrorMessage;
	
	public $Data;
	
	public function __construct(){
		$this->Error = ErrorType::Success;
	}
}
