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
class PageDataResult
{
	public $pageindex;

	public $pagesize;

	public $totalcount;

	public $Data;

	public function __construct(){
		$this->Data=new DataResult();
		$this->Error = ErrorType::Success;
	}
}