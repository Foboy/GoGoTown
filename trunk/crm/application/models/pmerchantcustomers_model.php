<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:47:09
 * 商家商圈GOGO客户对应表
 */
class PmerchantCustomersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增pmerchant_customers
	public function insert($shop_id,$customer_id,$times,$last_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from Crm_Pmerchant_Customers where shop_id = :shop_id and customer_id = :customer_id and times = :times and last_time = :last_time" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':times' => $times,
                   ':last_time' => $last_time
		) );
		$count = $query->rowCount();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into Crm_Pmerchant_Customers(shop_id,customer_id,times,last_time) values (:shop_id,:customer_id,:times,:last_time)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':times' => $times,
                   ':last_time' => $last_time
		) );
		$count = $query->rowCount();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from Crm_Pmerchant_Customers where shop_id = :shop_id and customer_id = :customer_id and times = :times and last_time = :last_time" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':times' => $times,
                   ':last_time' => $last_time
		) );
		if ($query->rowCount() != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改pmerchant_customers
	public function update($id,$shop_id,$customer_id,$times,$last_time) {
		$sql = " update Crm_Pmerchant_Customers set shop_id = :shop_id,customer_id = :customer_id,times = :times,last_time = :last_time where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':times' => $times,
                   ':last_time' => $last_time
		) );
		$count = $query->rowCount();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除pmerchant_customers
	public function delete($id) {
		$sql = " delete from Crm_Pmerchant_Customers where id = :id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':id' => $id 
		) );
		$count = $query->rowCount();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 分页查询pmerchant_customers
	public function searchByPages($shop_id,$customer_id,$times,$last_time, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,shop_id,customer_id,times,last_time from Crm_Pmerchant_Customers where  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( times = :times or :times=0 )  and  ( last_time = :last_time or :last_time=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':times' => $times,
                   ':last_time' => $last_time
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from Crm_Pmerchant_Customers where  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( times = :times or :times=0 )  and  ( last_time = :last_time or :last_time=0 ) " );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':times' => $times,
                   ':last_time' => $last_time
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部pmerchant_customers
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Pmerchant_Customers " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取pmerchant_customers
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Pmerchant_Customers WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>