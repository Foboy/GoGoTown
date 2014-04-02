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
	
	// 新增validation
	public function insert($code,$expire_time,$type,$usable,$customer_id) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_validation where code = :code and expire_time = :expire_time and type = :type and usable = :usable and customer_id = :customer_id" );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_validation(code,expire_time,type,usable,customer_id) values (:code,:expire_time,:type,:usable,:customer_id)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_validation where code = :code and expire_time = :expire_time and type = :type and usable = :usable and customer_id = :customer_id" );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改validation
	public function update($id,$code,$expire_time,$type,$usable,$customer_id) {
		$sql = " update crm_validation set code = :code,expire_time = :expire_time,type = :type,usable = :usable,customer_id = :customer_id where id = :id";
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
		$sql = " delete from crm_validation where id = :id ";
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
		
		$sql = " select id,code,expire_time,type,usable,customer_id from crm_validation where  ( code = :code or :code='' )  and  ( expire_time = :expire_time or :expire_time=0 )  and  ( type = :type or :type=0 )  and  ( usable = :usable or :usable=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':code' => $code,
                   ':expire_time' => $expire_time,
                   ':type' => $type,
                   ':usable' => $usable,
                   ':customer_id' => $customer_id
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_validation where  ( code = :code or :code='' )  and  ( expire_time = :expire_time or :expire_time=0 )  and  ( type = :type or :type=0 )  and  ( usable = :usable or :usable=0 )  and  ( customer_id = :customer_id or :customer_id=0 ) " );
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