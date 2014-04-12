<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:41:29
 */
class BillsModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增bills
	public function insert($shop_id,$customer_id,$pay_mothed,$cash,$go_coin,$type,$amount,$create_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_bills where shop_id = :shop_id and customer_id = :customer_id and pay_mothed = :pay_mothed and cash = :cash and go_coin = :go_coin and type = :type and amount = :amount and create_time = :create_time" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':cash' => $cash,
                   ':go_coin' => $go_coin,
                   ':type' => $type,
                   ':amount' => $amount,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_bills(shop_id,customer_id,pay_mothed,cash,go_coin,type,amount,create_time) values (:shop_id,:customer_id,:pay_mothed,:cash,:go_coin,:type,:amount,:create_time)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':cash' => $cash,
                   ':go_coin' => $go_coin,
                   ':type' => $type,
                   ':amount' => $amount,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_bills where shop_id = :shop_id and customer_id = :customer_id and pay_mothed = :pay_mothed and cash = :cash and go_coin = :go_coin and type = :type and amount = :amount and create_time = :create_time" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':cash' => $cash,
                   ':go_coin' => $go_coin,
                   ':type' => $type,
                   ':amount' => $amount,
                   ':create_time' => $create_time
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	
	
	// 分页查询bills
	public function searchByPages($sname,$shop_id,$customer_id,$pay_mothed,$cash1,$cash2,$go_coin1,$go_coin2,$type,$create_time1, $create_time2,$pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		if(!empty($sname))
		{
			$sname=" where
    (bb.username like '%".trim($sname)."%'
        or bb.nickname like '%".trim($sname)."%'
        or bb.mobile like '%".trim($sname)."%'
        or aa.shop_name like '%".trim($sname)."%') ";
		}else 
		{
			$sname="";
		}
		
		$cash="";
		$go_coin="";
	     if($cash2>0)
		{
			$cash="  and cb.Cash between $cash1 and $cash2  ";
		}else if($go_coin1>0)
		{
			$go_coin=" and cb.Go_Coin between $go_coin1 and $go_coin2 ";
		}
		
		$create_time="";
		if(!empty($create_time1) and !empty($create_time2))
		{
			$create_time="  and cb.Create_Time between $create_time1 and $create_time2 ";
		}
		
		
		$sql = " select 
    *
from
    (select 
        a.shop_Id,
            a.customer_id,
            a.Pay_Mothed,
            a.Cash,
            a.Go_Coin,
            a.Type,
            a.Amount,
            a.Create_Time,
            b.name shop_name
    FROM
        (select 
        *
    from
        Crm_Bills cb
    where
             (cb.Pay_Mothed=:pay_mothed or :pay_mothed=0)
            and (cb.Customer_ID = :customer_id or :customer_id=0)
            and (cb.Shop_ID = :shop_id or :shop_id=0)
            and (cb.type = :type or :type ='') 
		    $create_time
            $cash
            $go_coin
		) a
    left join Crm_Shops b ON a.shop_id = b.id) aa
        left join
    Crm_Gogo_Customers bb ON aa.customer_id = bb.id
$sname order by aa.create_time desc limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':type' => $type
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select 
    *
from
    (select 
        a.shop_Id,
            a.customer_id,
            a.Pay_Mothed,
            a.Cash,
            a.Go_Coin,
            a.Type,
            a.Amount,
            a.Create_Time,
            b.name shop_name
    FROM
        (select 
        *
    from
        Crm_Bills cb
    where
             (cb.Pay_Mothed=:pay_mothed or :pay_mothed=0)
            and (cb.Customer_ID = :customer_id or :customer_id=0)
            and (cb.Shop_ID = :shop_id or :shop_id=0)
            and (cb.type = :type or :type ='') 
		    $create_time
            $cash
            $go_coin
		) a
    left join Crm_Shops b ON a.shop_id = b.id) aa
        left join
    Crm_Gogo_Customers bb ON aa.customer_id = bb.id
$sname " );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':pay_mothed' => $pay_mothed,
                   ':type' => $type
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部bills
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Bills " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
  
}

?>