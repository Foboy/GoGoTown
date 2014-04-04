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
	public function update($shop_id,$customer_id,$from_type,$type,$create_time) {
		$sql = " update crm_shop_customers set type = :type,create_time = :create_time where shop_id = :shop_id,customer_id = :customer_id,from_type = :from_type";
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
	// 分页查询商家自有客户shop_customers
	public function searchPrivateByPages($shop_id,$name,$sex,$phone, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		if(empty($name))
		{
			$name= "  1=1  ";
		}else 
		{
		$name=" aa.name like '%".$name."%' ";
		}
		if(empty($phone))
		{
			$phone= "  1=1  ";
		}else
		{
			$phone=" aa.phone like '%".$phone."%'  ";
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
        crm_shop_customers
    where
        shop_id = :shop_id and from_type = 1) a
    left join Crm_Customers b ON a.customer_id = b.ID) aa
        left join
    (select 
        cr.Customer_ID, cr.Rank, crs.Name shoprankname
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.id = crs.ID
    where
        cr.Shop_ID = 0) bb ON aa.customer_id = bb.customer_id 
        where $name and (aa.sex = :sex or 0=:sex) and $phone
		order by aa.create_time desc limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
				':sex' => $sex
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
        crm_shop_customers
    where
        shop_id = :shop_id and from_type = 1) a
    left join Crm_Customers b ON a.customer_id = b.ID) aa
        left join
    (select 
        cr.Customer_ID, cr.Rank, crs.Name
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.id = crs.ID
    where
        cr.Shop_ID = 0) bb ON aa.customer_id = bb.customer_id where $name and (aa.sex = :sex or 0=:sex) and $phone " );
		$query->execute ( array (
':shop_id' => $shop_id,
				':sex' => $sex
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
	// 分页查询有消费记录GOGO客户shop_customers $type 1:公海客户 2：销售机会 3：有消费记录gogo客户
	public function searchGOGOCustomerByPages($shop_id,$name,$sex,$phone,$type, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		if(empty($name))
		{
			$name= "  1=1  ";
		}else
		{
			$name=" cc.username like '%".$name."%' ";
		}
		if(empty($phone))
		{
			$phone= "  1=1  ";
		}else
		{
			$phone=" cc.mobile like '%".$phone."%'  ";
		}
		
		$sql = " select 
    *
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
        crm_shop_customers
    where
        shop_id = :shop_id and from_type = 2
            and type = :type) a
    left join (select 
        *
    from
        Crm_PShop_Customers
    where
        shop_id = :shop_id) b ON a.Customer_ID = b.customer_id) aa
    left join Crm_Gogo_Customers bb ON aa.cid = bb.id) cc
        left join
    (select 
        cr.Customer_ID, cr.Rank, crs.Name
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.id = crs.ID
    where
        cr.Shop_ID = :shop_id) dd ON cc.cid = dd.Customer_ID 
        where $name and (cc.sex = :sex or 0=:sex) and $phone
		order by cc.create_time limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':type' => $type,
				':sex' => $sex
		) );
		$objects = $query->fetchAll ();
	
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
        crm_shop_customers
    where
        shop_id = :shop_id and from_type = 2
            and type = :type) a
    left join (select 
        *
    from
        Crm_PShop_Customers
    where
        shop_id = :shop_id) b ON a.Customer_ID = b.customer_id) aa
    left join Crm_Gogo_Customers bb ON aa.cid = bb.id) cc
        left join
    (select 
        cr.Customer_ID, cr.Rank, crs.Name
    from
        Crm_Rank cr
    left join Crm_Rank_Set crs ON cr.id = crs.ID
    where
        cr.Shop_ID = :shop_id) dd ON cc.cid = dd.Customer_ID  where $name and (cc.sex = :sex or 0=:sex) and $phone" );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':type' => $type,
				':sex' => $sex
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
	
	//根据实际查询商户客户数量
	public function getCustomerCount($shop_id,$stime,$etime) {
		$result = new DataResult ();
	
		$query = $this->db->prepare ( "select 
    (SELECT 
            count(*) 
        FROM
            gogotowncrm.Crm_Shop_Customers a
        where
            a.From_Type = 2 and a.type = 1 and a.Shop_ID=:shop_id
                and a.create_time between :stime and :etime) mshop_num,
    (SELECT 
            count(*) 
        FROM
            gogotowncrm.Crm_Shop_Customers a
        where
            a.From_Type = 2 and a.type = 2 and a.Shop_ID=:shop_id
                and a.create_time between :stime and :etime) chance_num,
    (SELECT 
            count(*) 
        FROM
            gogotowncrm.Crm_Shop_Customers a
        where
            a.From_Type = 2 and a.type = 3 and a.Shop_ID=:shop_id
                and a.create_time between :stime and :etime) private_gogo_num
from dual " );
		$query->execute ( array (
				':shop_id' => $shop_id,
				':stime' => $stime,
				':etime' => $etime
		) );
		$objects = $query->fetchAll ();
	
		$result->Data = $objects;
		return $result;
	}
}

?>