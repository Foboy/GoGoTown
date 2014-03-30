<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:40:43
 * GOGO客户信息表
 */
class GogoCustomersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增gogo_customers
	public function insert($mobile,$email,$password,$username,$nickname,$sex,$salt,$reg_ip,$reg_time,$last_login_ip,$last_login_time,$error_login_num,$address_num,$email_approve,$mobile_approve,$headimg,$status) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_gogo_customers where mobile = :mobile and email = :email and password = :password and username = :username and nickname = :nickname and sex = :sex and salt = :salt and reg_ip = :reg_ip and reg_time = :reg_time and last_login_ip = :last_login_ip and last_login_time = :last_login_time and error_login_num = :error_login_num and address_num = :address_num and email_approve = :email_approve and mobile_approve = :mobile_approve and headimg = :headimg and status = :status" );
		$query->execute ( array (
':mobile' => $mobile,
                   ':email' => $email,
                   ':password' => $password,
                   ':username' => $username,
                   ':nickname' => $nickname,
                   ':sex' => $sex,
                   ':salt' => $salt,
                   ':reg_ip' => $reg_ip,
                   ':reg_time' => $reg_time,
                   ':last_login_ip' => $last_login_ip,
                   ':last_login_time' => $last_login_time,
                   ':error_login_num' => $error_login_num,
                   ':address_num' => $address_num,
                   ':email_approve' => $email_approve,
                   ':mobile_approve' => $mobile_approve,
                   ':headimg' => $headimg,
                   ':status' => $status
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_gogo_customers(mobile,email,password,username,nickname,sex,salt,reg_ip,reg_time,last_login_ip,last_login_time,error_login_num,address_num,email_approve,mobile_approve,headimg,status) values (:mobile,:email,:password,:username,:nickname,:sex,:salt,:reg_ip,:reg_time,:last_login_ip,:last_login_time,:error_login_num,:address_num,:email_approve,:mobile_approve,:headimg,:status)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':mobile' => $mobile,
                   ':email' => $email,
                   ':password' => $password,
                   ':username' => $username,
                   ':nickname' => $nickname,
                   ':sex' => $sex,
                   ':salt' => $salt,
                   ':reg_ip' => $reg_ip,
                   ':reg_time' => $reg_time,
                   ':last_login_ip' => $last_login_ip,
                   ':last_login_time' => $last_login_time,
                   ':error_login_num' => $error_login_num,
                   ':address_num' => $address_num,
                   ':email_approve' => $email_approve,
                   ':mobile_approve' => $mobile_approve,
                   ':headimg' => $headimg,
                   ':status' => $status
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_gogo_customers where mobile = :mobile and email = :email and password = :password and username = :username and nickname = :nickname and sex = :sex and salt = :salt and reg_ip = :reg_ip and reg_time = :reg_time and last_login_ip = :last_login_ip and last_login_time = :last_login_time and error_login_num = :error_login_num and address_num = :address_num and email_approve = :email_approve and mobile_approve = :mobile_approve and headimg = :headimg and status = :status" );
		$query->execute ( array (
':mobile' => $mobile,
                   ':email' => $email,
                   ':password' => $password,
                   ':username' => $username,
                   ':nickname' => $nickname,
                   ':sex' => $sex,
                   ':salt' => $salt,
                   ':reg_ip' => $reg_ip,
                   ':reg_time' => $reg_time,
                   ':last_login_ip' => $last_login_ip,
                   ':last_login_time' => $last_login_time,
                   ':error_login_num' => $error_login_num,
                   ':address_num' => $address_num,
                   ':email_approve' => $email_approve,
                   ':mobile_approve' => $mobile_approve,
                   ':headimg' => $headimg,
                   ':status' => $status
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改gogo_customers
	public function update($id,$mobile,$email,$password,$username,$nickname,$sex,$salt,$reg_ip,$reg_time,$last_login_ip,$last_login_time,$error_login_num,$address_num,$email_approve,$mobile_approve,$headimg,$status) {
		$sql = " update crm_gogo_customers set mobile = :mobile,email = :email,password = :password,username = :username,nickname = :nickname,sex = :sex,salt = :salt,reg_ip = :reg_ip,reg_time = :reg_time,last_login_ip = :last_login_ip,last_login_time = :last_login_time,error_login_num = :error_login_num,address_num = :address_num,email_approve = :email_approve,mobile_approve = :mobile_approve,headimg = :headimg,status = :status where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':mobile' => $mobile,
                   ':email' => $email,
                   ':password' => $password,
                   ':username' => $username,
                   ':nickname' => $nickname,
                   ':sex' => $sex,
                   ':salt' => $salt,
                   ':reg_ip' => $reg_ip,
                   ':reg_time' => $reg_time,
                   ':last_login_ip' => $last_login_ip,
                   ':last_login_time' => $last_login_time,
                   ':error_login_num' => $error_login_num,
                   ':address_num' => $address_num,
                   ':email_approve' => $email_approve,
                   ':mobile_approve' => $mobile_approve,
                   ':headimg' => $headimg,
                   ':status' => $status
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除gogo_customers
	public function delete($id) {
		$sql = " delete from crm_gogo_customers where id = :id ";
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
	// 分页查询gogo_customers
	public function searchByPages($mobile,$email,$password,$username,$nickname,$sex,$salt,$reg_ip,$reg_time,$last_login_ip,$last_login_time,$error_login_num,$address_num,$email_approve,$mobile_approve,$headimg,$status, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,mobile,email,password,username,nickname,sex,salt,reg_ip,reg_time,last_login_ip,last_login_time,error_login_num,address_num,email_approve,mobile_approve,headimg,status from crm_gogo_customers where  ( mobile = :mobile or :mobile='' )  and  ( email = :email or :email='' )  and  ( password = :password or :password='' )  and  ( username = :username or :username='' )  and  ( nickname = :nickname or :nickname='' )  and  ( sex = :sex or :sex='' )  and  ( salt = :salt or :salt='' )  and  ( reg_ip = :reg_ip or :reg_ip='' )  and  ( reg_time = :reg_time or :reg_time=0 )  and  ( last_login_ip = :last_login_ip or :last_login_ip='' )  and  ( last_login_time = :last_login_time or :last_login_time=0 )  and  ( error_login_num = :error_login_num or :error_login_num='' )  and  ( address_num = :address_num or :address_num='' )  and  ( email_approve = :email_approve or :email_approve='' )  and  ( mobile_approve = :mobile_approve or :mobile_approve='' )  and  ( headimg = :headimg or :headimg='' )  and  ( status = :status or :status='' )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':mobile' => $mobile,
                   ':email' => $email,
                   ':password' => $password,
                   ':username' => $username,
                   ':nickname' => $nickname,
                   ':sex' => $sex,
                   ':salt' => $salt,
                   ':reg_ip' => $reg_ip,
                   ':reg_time' => $reg_time,
                   ':last_login_ip' => $last_login_ip,
                   ':last_login_time' => $last_login_time,
                   ':error_login_num' => $error_login_num,
                   ':address_num' => $address_num,
                   ':email_approve' => $email_approve,
                   ':mobile_approve' => $mobile_approve,
                   ':headimg' => $headimg,
                   ':status' => $status
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_gogo_customers where  ( mobile = :mobile or :mobile='' )  and  ( email = :email or :email='' )  and  ( password = :password or :password='' )  and  ( username = :username or :username='' )  and  ( nickname = :nickname or :nickname='' )  and  ( sex = :sex or :sex='' )  and  ( salt = :salt or :salt='' )  and  ( reg_ip = :reg_ip or :reg_ip='' )  and  ( reg_time = :reg_time or :reg_time=0 )  and  ( last_login_ip = :last_login_ip or :last_login_ip='' )  and  ( last_login_time = :last_login_time or :last_login_time=0 )  and  ( error_login_num = :error_login_num or :error_login_num='' )  and  ( address_num = :address_num or :address_num='' )  and  ( email_approve = :email_approve or :email_approve='' )  and  ( mobile_approve = :mobile_approve or :mobile_approve='' )  and  ( headimg = :headimg or :headimg='' )  and  ( status = :status or :status='' ) " );
		$query->execute ( array (
':mobile' => $mobile,
                   ':email' => $email,
                   ':password' => $password,
                   ':username' => $username,
                   ':nickname' => $nickname,
                   ':sex' => $sex,
                   ':salt' => $salt,
                   ':reg_ip' => $reg_ip,
                   ':reg_time' => $reg_time,
                   ':last_login_ip' => $last_login_ip,
                   ':last_login_time' => $last_login_time,
                   ':error_login_num' => $error_login_num,
                   ':address_num' => $address_num,
                   ':email_approve' => $email_approve,
                   ':mobile_approve' => $mobile_approve,
                   ':headimg' => $headimg,
                   ':status' => $status
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部gogo_customers
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Gogo_Customers " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取gogo_customers
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Gogo_Customers WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>