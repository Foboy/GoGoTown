<?php
class OrdersModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}

	// 新增bills
	public function insert($shop_id,$customer_id,$pay_method,$go_cash,$go_coin,$lakala_cash,$status,$amount,$app_user_id,$lakala_order_no,$go_order_no) {
			// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_orders where lakala_order_no = :lakala_order_no or go_order_no = :go_order_no" );
		$query->execute ( array (
				':lakala_order_no' => $lakala_order_no,
				':go_order_no'=>$go_order_no
		) );
		$count = $query->rowCount();
		if ($count > 0) {
			return 0;
		}

		// 添加操作
		$sql = "insert into crm_orders(lakala_order_no,shop_id,customer_id,pay_method,go_cash,go_coin,lakala_cash,status,amount,create_time,app_user_id,go_order_no) values (:lakala_order_no,:shop_id,:customer_id,:pay_mothed,:go_cash,:go_coin,:lakala_cash,:status,:amount,:create_time,:app_user_id,:go_order_no)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_method' => $pay_method,
                   ':go_cash' => $go_cash,
                   ':go_coin' => $go_coin,
				   ':lakala_cash' => $lakala_cash,
                   ':status' => $status,
                   ':amount' => $amount,
                   ':create_time' => time(),
				':app_user_id'=>$app_user_id,
				':lakala_order_no'=>$lakala_order_no,
				':go_order_no'=>$go_order_no
		) );
		$count = $query->rowCount();
		if ($count != 1) {

			return 0;
		}

		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_orders where go_order_no = :go_order_no" );
		$query->execute ( array (
':go_order_no' => $go_order_no
		) );
		if ($query->rowCount() != 1) {

			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;

		return $customer_id;
	}

	public function updateStatus($shop_id,$go_order_no,$status)
	{
		$sql = "update crm_orders set status=:status where shop_id = :shop_id and go_order_no = :go_order_no";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':status' => $status,
				':go_order_no'=>$go_order_no
		) );
		$count = $query->rowCount();
		return $count;
	}

	// 分页查询bills
	public function searchByMobiles($shop_id,$customer_id,$pay_mothed,$status,$pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;

		$sql = "select orders.*,Crm_Gogo_Customers.username,Crm_Gogo_Customers.mobile from (select * from (select * from crm_orders where  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( pay_mothed = :pay_mothed or :pay_mothed=0 )  and  ( status = :status or :status=0 )  order by create_time desc ) a  limit $lastpagenum,$pagesize ) orders left join Crm_Gogo_Customers on Crm_Gogo_Customers.id = orders.customer_id" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':status' => $status
		) );
		$objects = $query->fetchAll ();

		$query = $this->db->prepare ( "select count(1) from crm_orders where  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( pay_mothed = :pay_mothed or :pay_mothed=0 )  and  ( status = :status or :status=0 )" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':status' => $status
		) );
		$totalcount = $query->fetchColumn ( 0 );

		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;

		return $result;
	}

}

?>