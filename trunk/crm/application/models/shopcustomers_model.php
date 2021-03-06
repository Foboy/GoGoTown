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
		$this->db->query ( "SET NAMES utf8" ); // 设置数据库编码
	}
	
	// 新增shop_customers
	public function insert($shop_id, $customer_id, $from_type, $type, $create_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from Crm_Shop_Customers where shop_id = :shop_id and customer_id = :customer_id and from_type = :from_type" );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':customer_id' => $customer_id,
				':from_type' => $from_type 
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into Crm_Shop_Customers(shop_id,customer_id,from_type,type,create_time) values (:shop_id,:customer_id,:from_type,:type,:create_time)";
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
		$query = $this->db->prepare ( " select id from Crm_Shop_Customers where shop_id = :shop_id and customer_id = :customer_id and from_type = :from_type and type = :type and create_time = :create_time" );
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
	public function update($shop_id, $customer_id, $from_type, $type, $create_time) {
		$sql = " update Crm_Shop_Customers set type = :type,create_time = :create_time where shop_id = :shop_id and customer_id = :customer_id and from_type = :from_type";
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
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除shop_customers
	public function delete($shop_id, $customer_id) {
		$sql = " delete from Crm_Shop_Customers where shop_id = :shop_id and customer_id = :customer_id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':customer_id' => $customer_id 
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 分页查询商家自有客户shop_customers
	public function searchPrivateByPages($shop_id, $name, $sex, $phone, $rank_id, $create_time1,$create_time2,$pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex * $pagesize;
		if (empty ( $name )) {
			$name = "  1=1  ";
		} else {
			$name = " aa.name like '%" . $name . "%' ";
		}
		if (empty ( $phone )) {
			$phone = "  1=1  ";
		} else {
			$phone = " aa.phone like '%" . $phone . "%'  ";
		}
		$create_time="";
		if(!empty($create_time1) and !empty($create_time2))
		{
			$create_time="  and create_time between $create_time1 and $create_time2 ";
		}
		
		$sql = " select 
    *
from
    (select 
        a.customer_id, from_type, a.type, a.create_time, b . *
    from
        (select 
        *
    from
        Crm_Shop_Customers
    where
        shop_id = :shop_id and from_type = 1 $create_time ) a
    left join Crm_Customers b ON a.customer_id = b.ID) aa
        left join
    (select 
        cr.Customer_ID cid, cr.rank_id, crs.Name shoprankname
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.rank_id = crs.ID
    where
        cr.Shop_ID = :shop_id ) bb ON aa.customer_id = bb.cid 
        where ($name or $phone) and (aa.sex = :sex or 0=:sex) and (bb.rank_id=:rank_id or :rank_id=0)
		order by aa.create_time desc limit $lastpagenum,$pagesize";
		// print $sql;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':sex' => $sex,
				':rank_id' => $rank_id 
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select 
    count(*)
from
    (select 
        a.customer_id, from_type, a.type, a.create_time, b . *
    from
        (select 
        *
    from
        Crm_Shop_Customers
    where
        shop_id = :shop_id and from_type = 1 $create_time) a
    left join Crm_Customers b ON a.customer_id = b.ID) aa
        left join
    (select 
        cr.Customer_ID, cr.rank_id, crs.Name
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.rank_id = crs.ID
    where
        cr.Shop_ID = :shop_id) bb ON aa.customer_id = bb.customer_id where ($name or $phone) and (aa.sex = :sex or 0=:sex) and (bb.rank_id=:rank_id or :rank_id=0) " );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':sex' => $sex,
				':rank_id' => $rank_id 
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
	// 查询公海客户
	public function searchPCustomerByPages($shop_id, $name, $sex, $phone, $type, $rank_id, $create_time1,$create_time2, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex * $pagesize;
		if (empty ( $name )) {
			$name = "  1=1  ";
		} else {
			$name = " cc.username like '%" . $name . "%' ";
		}
		if (empty ( $phone )) {
			$phone = "  1=1  ";
		} else {
			$phone = " cc.mobile like '%" . $phone . "%'  ";
		}
		$create_time="";
		if(!empty($create_time1) and !empty($create_time2))
		{
			$create_time="  and sys_time between $create_time1 and $create_time2 ";
		}
		
		$sql = " select 
    *
from
    (select 
        aa . *, bb . *
    from
        (select 
        shop_id,customer_id,times,last_time,is_chance,sys_time update_time
    from
        Crm_PShop_Customers
    where
        shop_id = :shop_id $create_time ) aa
    left join Crm_Gogo_Customers bb ON aa.Customer_ID = bb.id) cc
        left join
    (select 
        cr.Customer_ID ccid, cr.rank_id, crs.Name shoprankname
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.rank_id = crs.ID
    where
        cr.Shop_ID = :shop_id) dd ON cc.Customer_ID = dd.ccid 
        where ($name or $phone) and (cc.sex = :sex or 0=:sex) and (dd.rank_id=:rank_id or :rank_id=0)
		order by cc.update_time desc limit $lastpagenum,$pagesize";
		// print $sql;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':sex' => $sex,
				':rank_id' => $rank_id 
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select 
    count(*)
from
    (select 
        aa . *, bb . *
    from
        (select 
        shop_id,customer_id,times,last_time,sys_time update_time
    from
        Crm_PShop_Customers
    where
        shop_id = :shop_id $create_time ) aa
    left join Crm_Gogo_Customers bb ON aa.Customer_ID = bb.id) cc
        left join
    (select 
        cr.Customer_ID ccid, cr.rank_id, crs.Name shoprankname
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.rank_id = crs.ID
    where
        cr.Shop_ID = :shop_id) dd ON cc.Customer_ID = dd.ccid 
        where ($name or $phone) and (cc.sex = :sex or 0=:sex) and (dd.rank_id=:rank_id or :rank_id=0)" );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':sex' => $sex,
				':rank_id' => $rank_id 
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
	
	// 分页查询有消费记录GOGO客户shop_customers $type 1:公海客户 2：销售机会 3：有消费记录gogo客户
	public function searchGOGOCustomerByPages($shop_id, $name, $sex, $phone, $type, $rank_id,$create_time1,$create_time2, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex * $pagesize;
		if (empty ( $name )) {
			$name = "  1=1  ";
		} else {
			$name = " ee.username like '%" . $name . "%' ";
		}
		if (empty ( $phone )) {
			$phone = "  1=1  ";
		} else {
			$phone = " ee.mobile like '%" . $phone . "%'  ";
		}
		
		$create_time="";
		if(!empty($create_time1) and !empty($create_time2))
		{
			$create_time="  and create_time between $create_time1 and $create_time2 ";
		}
		
		$sql = "  select ee.*,crs.Name shoprankname from (select
		cc.*,cr.Rank_ID
		from
		(select
		aa . *, bb . *
		from
		(select
		a.Customer_ID, from_type, type, create_time
		from
		(select
		*
		from
		Crm_Shop_Customers
		where
		shop_id = :shop_id and from_type = 2 $create_time
		and type = :type) as a
		) as aa
		left join Crm_Gogo_Customers as bb ON aa.Customer_ID = bb.id) as cc
		left join Crm_Rank cr on cc.Customer_ID=cr.Customer_ID) ee left join
Crm_Rank_Set crs on ee.rank_id =crs.ID 
		where  ($name or $phone) and (ee.sex = :sex or :sex=0) and (ee.rank_id=:rank_id or :rank_id=0)
		order by ee.create_time desc limit  $lastpagenum,$pagesize";
// 		$sql = " select
// 		*
// 		from
// 		(select
// 		aa . *, bb . *
// 		from
// 		(select
// 		a.Customer_ID, from_type, type, create_time
// 		from
// 		(select
// 		*
// 		from
// 		Crm_Shop_Customers
// 		where
// 		shop_id = :shop_id and from_type = 2
// 		and type = :type) as a
// 		) as aa
// 		left join Crm_Gogo_Customers as bb ON aa.Customer_ID = bb.id) as cc
// 		left join
// 		(select
// 		cr.Customer_ID as ccid, cr.rank_id, crs.Name as shoprankname
// 		from
// 		Crm_Rank as cr
// 		left join Crm_Rank_Set as crs on cr.rank_id = crs.ID
// 		where
// 		cr.Shop_ID = :shop_id) as dd on cc.Customer_ID = dd.ccid
// 		where ($name or $phone) and (cc.sex = :sex or 0=:sex) and (dd.rank_id=:rank_id or :rank_id=0)
// 		order by cc.create_time limit $lastpagenum,$pagesize";
// $sql="select 
//     *,crs.Name Shoprankname
// from
//     (select 
//         *
//     from
//         Crm_Shop_Customers
//     where
//         shop_id = :shop_id and from_type = 2
//             and type = :type) a
//         left join
//     (Crm_Gogo_Customers bb, (select 
//         *
//     from
//         Crm_Rank
//     where
//         Crm_Rank.Shop_ID = :shop_id) cr, Crm_Rank_Set crs) ON (a.Customer_ID = bb.id
//         and cr.rank_id = crs.ID
//         and a.Customer_ID = cr.Customer_ID)
// where
//     ($name or $phone)
//         and (bb.sex = :sex or :sex = 0)
//         and (cr.rank_id = :rank_id or :rank_id = 0)
// order by a.create_time desc
// limit $lastpagenum,$pagesize";
		// print $sql;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':type' => $type,
				':sex' => $sex,
				':rank_id' => $rank_id 
		) );
		$objects = $query->fetchAll ();
		//print json_encode($objects);
		$query = $this->db->prepare ( " select
    count(*)
				from
				(select
						aa . *, bb . *
						from
						(select
						a.Customer_ID cid, from_type, type, create_time
						from
						(select
								*
								from
								Crm_Shop_Customers
								where
								shop_id = :shop_id and from_type = 2 $create_time
								and type = :type) a
								) aa
								left join Crm_Gogo_Customers bb ON aa.cid = bb.id) cc
								left join
								(select
								cr.Customer_ID, cr.rank_id, crs.Name
								from
								Crm_Rank cr
								left join Crm_Rank_Set crs ON cr.rank_id = crs.ID
								where
								cr.Shop_ID = :shop_id) dd ON cc.cid = dd.Customer_ID  where ($name or $phone) and (cc.sex = :sex or 0=:sex) and (dd.rank_id=:rank_id or :rank_id=0) " );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':type' => $type,
				':sex' => $sex,
				':rank_id' => $rank_id 
		) );
		
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
	
	// 查询全部shop_customers
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shop_Customers " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
	// 根据ID获取shop_customers
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
	
	// 根据实际查询商户客户数量
	public function getCustomerCount($shop_id, $stime, $etime) {
		$result = new DataResult ();
		
		$time1 = "";
		$time2 = "";
		$time3 = "";
		
		if (! empty ( $stime )) {
			$time1 = " and a.last_time between $stime and $etime ";
			$time2 = " and a.create_time between $stime and $etime ";
			$time3 = " and a.create_time between $stime and $etime ";
		}
		$sql = "select 
    (SELECT 
            count(*) 
        FROM
                 Crm_PShop_Customers a
        where
           a.Shop_ID=:shop_id
               $time1  ) mshop_num,
    (SELECT 
            count(*) 
        FROM
            Crm_Shop_Customers a
        where
            a.From_Type = 2 and a.type = 2 and a.Shop_ID=:shop_id
                $time2) chance_num,
    (SELECT 
            count(*) 
        FROM
            Crm_Shop_Customers a
        where
            a.From_Type = 2 and a.type = 3 and a.Shop_ID=:shop_id
                $time3 ) private_gogo_num
from dual ";
		$query = $this->db->prepare ( $sql );
		// print $sql;
		$query->execute ( array (
				':shop_id' => $shop_id 
		) );
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
}

?>