<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:53:00
 * 验证码表
 */
class ValidationModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	public function validation($code,$type,$customer_id)
	{
		$sql = " update Crm_Validation set usable = :disable where expire_time > :expire_time and customer_id = :customer_id and usable = :usable and code = :code and type = :type";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':disable' => EnableType::Disable,
				':usable' => EnableType::Enable,
				':expire_time' => time(),
                ':code' => $code,
                ':type' => $type,
                ':customer_id' => $customer_id
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	
	// 新增validation
	public function insert($code,$type,$customer_id) {
		// 判断是否已存在
		
		$expire_time = time() + VALIDATION_CODE_EXPIRE_TIME;
		// 添加操作
		$sql = "insert into Crm_Validation(code,expire_time,type,usable,customer_id) values (:code,:expire_time,:type,:usable,:customer_id)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => EnableType::Enable,
                   ':customer_id' => $customer_id
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return false;
		}
		return true;
	}
	// 修改validation
	public function update($id,$code,$expire_time,$type,$usable,$customer_id) {
		$sql = " update Crm_Validation set code = :code,expire_time = :expire_time,type = :type,usable = :usable,customer_id = :customer_id where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除validation
	public function delete($id) {
		$sql = " delete from Crm_Validation where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':id' => $id 
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 分页查询validation
	public function searchByPages($code,$expire_time,$type,$usable,$customer_id, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,code,expire_time,type,usable,customer_id from Crm_Validation where  ( code = :code or :code='' )  and  ( expire_time = :expire_time or :expire_time=0 )  and  ( type = :type or :type=0 )  and  ( usable = :usable or :usable=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from Crm_Validation where  ( code = :code or :code='' )  and  ( expire_time = :expire_time or :expire_time=0 )  and  ( type = :type or :type=0 )  and  ( usable = :usable or :usable=0 )  and  ( customer_id = :customer_id or :customer_id=0 ) " );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部validation
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Validation " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取validation
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Validation WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>