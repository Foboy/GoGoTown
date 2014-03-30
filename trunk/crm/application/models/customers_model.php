
<?php
/*
 * @author yangchao
* @email:66954011@qq.com
* @date: 2014/3/30 18:26:21
* 商家自有客户信息表
*/
class CustomersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增customers
	public function insert($name,$sex,$phone,$birthady,$remark) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_customers where name = :name and sex = :sex and phone = :phone and birthady = :birthady and remark = :remark" );
		$query->execute ( array (
':name' => $name,
                   ':sex' => $sex,
                   ':phone' => $phone,
                   ':birthady' => $birthady,
                   ':remark' => $remark
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_customers(name,sex,phone,birthady,remark) values (:name,:sex,:phone,:birthady,:remark)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':sex' => $sex,
                   ':phone' => $phone,
                   ':birthady' => $birthady,
                   ':remark' => $remark
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_customers where name = :name and sex = :sex and phone = :phone and birthady = :birthady and remark = :remark" );
		$query->execute ( array (
':name' => $name,
                   ':sex' => $sex,
                   ':phone' => $phone,
                   ':birthady' => $birthady,
                   ':remark' => $remark
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改customers
	public function update($id,$name,$sex,$phone,$birthady,$remark) {
		$sql = " update crm_customers set name = :name,sex = :sex,phone = :phone,birthady = :birthady,remark = :remark where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':name' => $name,
                   ':sex' => $sex,
                   ':phone' => $phone,
                   ':birthady' => $birthady,
                   ':remark' => $remark
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除customers
	public function delete($id) {
		$sql = " delete from crm_customers where id = :id ";
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
	// 分页查询customers
	public function searchByPages($name,$sex,$phone,$birthady, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,name,sex,phone,birthady,remark from crm_customers where  ( name = :name or :name='' )  and  ( sex = :sex or :sex=0 )  and  ( phone = :phone or :phone='' )  and  ( birthady = :birthady or :birthady=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':sex' => $sex,
                   ':phone' => $phone,
                   ':birthady' => $birthady
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_customers where  ( name = :name or :name='' )  and  ( sex = :sex or :sex=0 )  and  ( phone = :phone or :phone='' )  and  ( birthady = :birthady or :birthady=0 )   " );
		$query->execute ( array (
':name' => $name,
                   ':sex' => $sex,
                   ':phone' => $phone,
                   ':birthady' => $birthady
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部customers
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Customers " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取customers
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Customers WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>