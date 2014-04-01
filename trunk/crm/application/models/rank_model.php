<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:49:04
 * 客户等级对应表
 */
class RankModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增rank
	public function insert($from_type,$shop_id,$customer_id,$rank,$begin_time,$end_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_rank where from_type = :from_type and shop_id = :shop_id and customer_id = :customer_id and rank = :rank " );
		$query->execute ( array (
':from_type' => $from_type,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':rank' => $rank
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_rank(from_type,shop_id,customer_id,rank,begin_time,end_time) values (:from_type,:shop_id,:customer_id,:rank,:begin_time,:end_time)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':from_type' => $from_type,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':rank' => $rank,
                   ':begin_time' => $begin_time,
                   ':end_time' => $end_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_rank where from_type = :from_type and shop_id = :shop_id and customer_id = :customer_id and rank = :rank and begin_time = :begin_time and end_time = :end_time" );
		$query->execute ( array (
':from_type' => $from_type,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':rank' => $rank,
                   ':begin_time' => $begin_time,
                   ':end_time' => $end_time
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改rank
	public function update($id,$from_type,$shop_id,$customer_id,$rank,$begin_time,$end_time) {
		$sql = " update crm_rank set from_type = :from_type,shop_id = :shop_id,customer_id = :customer_id,rank = :rank,begin_time = :begin_time,end_time = :end_time where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':from_type' => $from_type,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':rank' => $rank,
                   ':begin_time' => $begin_time,
                   ':end_time' => $end_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据客户ID删除rank
	public function delete($from_type,$customer_id,$shop_id) {
		$sql = " delete from crm_rank where from_type = :from_type,customer_id = :customer_id,shop_id = :shop_id ";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array ( 
				':from_type' => $from_type,
				':customer_id' => customer_id ,
				':shop_id' => $shop_id
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 分页查询rank
	public function searchByPages($from_type,$shop_id,$customer_id,$rank,$begin_time,$end_time, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,from_type,shop_id,customer_id,rank,begin_time,end_time from crm_rank where  ( from_type = :from_type or :from_type=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( rank = :rank or :rank=0 )  and  ( begin_time = :begin_time or :begin_time=0 )  and  ( end_time = :end_time or :end_time=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':from_type' => $from_type,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':rank' => $rank,
                   ':begin_time' => $begin_time,
                   ':end_time' => $end_time
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_rank where  ( from_type = :from_type or :from_type=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( customer_id = :customer_id or :customer_id=0 )  and  ( rank = :rank or :rank=0 )  and  ( begin_time = :begin_time or :begin_time=0 )  and  ( end_time = :end_time or :end_time=0 ) " );
		$query->execute ( array (
':from_type' => $from_type,
                   ':shop_id' => $shop_id,
                   ':customer_id' => $customer_id,
                   ':rank' => $rank,
                   ':begin_time' => $begin_time,
                   ':end_time' => $end_time
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部rank
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Rank " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取rank
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Rank WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>