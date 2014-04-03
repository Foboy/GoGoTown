<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:52:16
 * 商家账号以及收银员账号表
 */
class UsersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增users
	public function insert($name,$shop_id,$type,$account,$password,$last_login,$state,$faileds,$last_failed,$token,$create_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_users where name = :name and shop_id = :shop_id and type = :type and account = :account and password = :password and last_login = :last_login and state = :state and faileds = :faileds and last_failed = :last_failed and token = :token and create_time = :create_time" );
		$query->execute ( array (
':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':account' => $account,
                   ':password' => $password,
                   ':last_login' => $last_login,
                   ':state' => $state,
                   ':faileds' => $faileds,
                   ':last_failed' => $last_failed,
                   ':token' => $token,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_users(name,shop_id,type,account,password,last_login,state,faileds,last_failed,token,create_time) values (:name,:shop_id,:type,:account,:password,:last_login,:state,:faileds,:last_failed,:token,:create_time)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':account' => $account,
                   ':password' => $password,
                   ':last_login' => $last_login,
                   ':state' => $state,
                   ':faileds' => $faileds,
                   ':last_failed' => $last_failed,
                   ':token' => $token,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_users where name = :name and shop_id = :shop_id and type = :type and account = :account and password = :password and last_login = :last_login and state = :state and faileds = :faileds and last_failed = :last_failed and token = :token and create_time = :create_time" );
		$query->execute ( array (
':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':account' => $account,
                   ':password' => $password,
                   ':last_login' => $last_login,
                   ':state' => $state,
                   ':faileds' => $faileds,
                   ':last_failed' => $last_failed,
                   ':token' => $token,
                   ':create_time' => $create_time
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改users
	public function update($id,$name,$shop_id,$type,$account,$password,$last_login,$state,$faileds,$last_failed,$token,$create_time) {
		$sql = " update crm_users set name = :name,shop_id = :shop_id,type = :type,account = :account,password = :password,last_login = :last_login,state = :state,faileds = :faileds,last_failed = :last_failed,token = :token,create_time = :create_time where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':account' => $account,
                   ':password' => $password,
                   ':last_login' => $last_login,
                   ':state' => $state,
                   ':faileds' => $faileds,
                   ':last_failed' => $last_failed,
                   ':token' => $token,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除users
	public function delete($id) {
		$sql = " delete from crm_users where id = :id ";
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
	// 分页查询users
	public function searchByPages($name,$shop_id,$type,$state, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,name,shop_id,type,account,password,last_login,state,faileds,last_failed,token,create_time from crm_users where  ( name = :name or :name=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and  ( account = :account or :account='' )  and  ( password = :password or :password='' )  and  ( last_login = :last_login or :last_login=0 )  and  ( state = :state or :state=0 )  and  ( faileds = :faileds or :faileds=0 )  and  ( last_failed = :last_failed or :last_failed=0 )  and  ( token = :token or :token='' )  and  ( create_time = :create_time or :create_time=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':state' => $state
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_users where  ( name = :name or :name=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and   ( state = :state or :state=0 )   " );
		$query->execute ( array (
':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':state' => $state
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //不分页查询全部users
	public function search($name,$shop_id,$type,$state) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Users where  ( name = :name or :name=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and   ( state = :state or :state=0 )  " );
		$query->execute ( array (
':name' => $name,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':state' => $state));
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取users
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Users WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
	// 修改usersName
	public function updateShopName($name,$id) {
		$sql = " update crm_users set name = :name where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
			':id' => $id,
				':name' => $name
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	
	public function setNewPassword($user_id,$user_password_hash)
	{
		// write users new password hash into database, reset user_password_reset_hash
		$query = $this->db->prepare("UPDATE crm_users
                                        SET password = :user_password_hash
                                      WHERE id = :id");
	
		$query->execute(array(':user_password_hash' => $user_password_hash,
				':id' => $user_id));
	
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
}

?>