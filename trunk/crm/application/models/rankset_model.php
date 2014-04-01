<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:49:33
 * 商家客户等级设置表
 */
class RankSetModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增rank_set
	public function insert($rank,$name,$shop_id,$remark) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_rank_set where rank = :rank and name = :name and shop_id = :shop_id and remark = :remark" );
		$query->execute ( array (
':rank' => $rank,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':remark' => $remark
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_rank_set(rank,name,shop_id,remark) values (:rank,:name,:shop_id,:remark)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':rank' => $rank,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':remark' => $remark
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_rank_set where rank = :rank and name = :name and shop_id = :shop_id and remark = :remark" );
		$query->execute ( array (
':rank' => $rank,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':remark' => $remark
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改rank_set
	public function update($id,$rank,$name,$shop_id,$remark) {
		$sql = " update crm_rank_set set rank = :rank,name = :name,shop_id = :shop_id,remark = :remark where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':rank' => $rank,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':remark' => $remark
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除rank_set
	public function delete($id) {
		$sql = " delete from crm_rank_set where id = :id ";
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
	// 分页查询rank_set
	public function searchByPages($rank,$name,$shop_id,$remark, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,rank,name,shop_id,remark from crm_rank_set where  ( rank = :rank or :rank=0 )  and  ( name = :name or :name='' )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( remark = :remark or :remark='' )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':rank' => $rank,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':remark' => $remark
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_rank_set where  ( rank = :rank or :rank=0 )  and  ( name = :name or :name='' )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( remark = :remark or :remark='' ) " );
		$query->execute ( array (
':rank' => $rank,
                   ':name' => $name,
                   ':shop_id' => $shop_id,
                   ':remark' => $remark
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询商家已设置的等级
	public function search($shop_id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Rank_Set where  ( shop_id = :shop_id or :shop_id=0 ) " );
		$query->execute ( array (
                   ':shop_id' => $shop_id
		) );
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取rank_set
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Rank_Set WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>