<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:43:31
 */
class LogsModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增logs
	public function insert($type,$content,$target,$create_time) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from Crm_Logs where type = :type and content = :content and target = :target and create_time = :create_time" );
		$query->execute ( array (
':type' => $type,
                   ':content' => $content,
                   ':target' => $target,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into Crm_Logs(type,content,target,create_time) values (:type,:content,:target,:create_time)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':type' => $type,
                   ':content' => $content,
                   ':target' => $target,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from Crm_Logs where type = :type and content = :content and target = :target and create_time = :create_time" );
		$query->execute ( array (
':type' => $type,
                   ':content' => $content,
                   ':target' => $target,
                   ':create_time' => $create_time
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改logs
	public function update($id,$type,$content,$target,$create_time) {
		$sql = " update Crm_Logs set type = :type,content = :content,target = :target,create_time = :create_time where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':type' => $type,
                   ':content' => $content,
                   ':target' => $target,
                   ':create_time' => $create_time
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除logs
	public function delete($id) {
		$sql = " delete from Crm_Logs where id = :id ";
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
	// 分页查询logs
	public function searchByPages($type,$content,$target,$create_time, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,type,content,target,create_time from Crm_Logs where  ( type = :type or :type=0 )  and  ( content = :content or :content='' )  and  ( target = :target or :target='' )  and  ( create_time = :create_time or :create_time=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':type' => $type,
                   ':content' => $content,
                   ':target' => $target,
                   ':create_time' => $create_time
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from Crm_Logs where  ( type = :type or :type=0 )  and  ( content = :content or :content='' )  and  ( target = :target or :target='' )  and  ( create_time = :create_time or :create_time=0 ) " );
		$query->execute ( array (
':type' => $type,
                   ':content' => $content,
                   ':target' => $target,
                   ':create_time' => $create_time
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部logs
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Logs " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取logs
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Logs WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>