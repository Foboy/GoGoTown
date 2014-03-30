<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:50:30
 * 商家客户表包括（销售机会客户，自由客户，GOGO客户在该商家已有消费记录客户）
 */
class ShopCustomersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增shop_customers
	public function insert($shop_id,$customer_id,$from_type,$type,$create_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_shop_customers where shop_id = :shop_id and customer_id = :customer_id and from_type = :from_type and type = :type and create_time = :create_time" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':from_type' => $from_type,
                   ':type' => $type,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_shop_customers(shop_id,customer_id,from_type,type,create_time) values (:shop_id,:customer_id,:from_type,:type,:create_time)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':from_type' => $from_type,
                   ':type' => $type,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_shop_customers where shop_id = :shop_id and customer_id = :customer_id and from_type = :from_type and type = :type and create_time = :create_time" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':from_type' => $from_type,
                   ':type' => $type,
                   ':create_time' => $create_time
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改shop_customers
	public function update($id,$shop_id,$customer_id,$from_type,$type,$create_time) {
		$sql = " update crm_shop_customers set shop_id = :shop_id,customer_id = :customer_id,from_type = :from_type,type = :type,create_time = :create_time where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':from_type' => $from_type,
                   ':type' => $type,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除shop_customers
	public function delete($id) {
		$sql = " delete from crm_shop_customers where id = :id ";
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
	// 分页查询shop_customers
	public function searchByPages($shop_id,$customer_id,$from_type,$type,$create_time, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,shop_id,customer_id,from_type,type,create_time from crm_shop_customers where  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( from_type = :from_type or :from_type=0 )  and  ( type = :type or :type=0 )  and  ( create_time = :create_time or :create_time=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':from_type' => $from_type,
                   ':type' => $type,
                   ':create_time' => $create_time
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_shop_customers where  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( from_type = :from_type or :from_type=0 )  and  ( type = :type or :type=0 )  and  ( create_time = :create_time or :create_time=0 ) " );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':from_type' => $from_type,
                   ':type' => $type,
                   ':create_time' => $create_time
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部shop_customers
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shop_Customers " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取shop_customers
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shop_Customers WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>