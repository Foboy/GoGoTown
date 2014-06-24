<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:45:16
 * 商家发送信息列表
 */
class MessagesModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增messages
	public function insert($shop_id,$type,$title,$content,$send_time,$create_time,$state,$pic_Id,$pic_url) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from Crm_Messages where shop_id = :shop_id and type = :type and title = :title and content = :content and send_time = :send_time and create_time = :create_time and state = :state" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':type' => $type,
                   ':title' => $title,
                   ':content' => $content,
                   ':send_time' => $send_time,
                   ':create_time' => $create_time,
                   ':state' => $state
		) );
		$count = $query->rowCount();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into Crm_Messages(shop_id,type,title,content,send_time,create_time,state,pic_id,pic_url) values (:shop_id,:type,:title,:content,:send_time,:create_time,:state,:pic_id,:pic_url)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':type' => $type,
                   ':title' => $title,
                   ':content' => $content,
                   ':send_time' => $send_time,
                   ':create_time' => $create_time,
				':pic_id' => $pic_Id,
				':pic_url' => $pic_url,
                   ':state' => $state
		) );
		$count = $query->rowCount();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from Crm_Messages where shop_id = :shop_id and type = :type and title = :title and content = :content and send_time = :send_time and create_time = :create_time and state = :state" );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':type' => $type,
                   ':title' => $title,
                   ':content' => $content,
                   ':send_time' => $send_time,
                   ':create_time' => $create_time,
                   ':state' => $state
		) );
		if ($query->rowCount() != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改messages
	public function update($id,$shop_id,$type,$title,$content,$send_time,$create_time,$state) {
		$sql = " update Crm_Messages set shop_id = :shop_id,type = :type,title = :title,content = :content,send_time = :send_time,create_time = :create_time,state = :state where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':shop_id' => $shop_id,
                   ':type' => $type,
                   ':title' => $title,
                   ':content' => $content,
                   ':send_time' => $send_time,
                   ':create_time' => $create_time,
                   ':state' => $state
		) );
		$count = $query->rowCount();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除messages
	public function delete($id) {
		$sql = " delete from Crm_Messages where id = :id ";
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
	// 分页查询messages
	public function searchByPages($shop_id,$type,$state, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,shop_id,type,title,content,send_time,create_time,state,pic_id,pic_url from Crm_Messages where  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and   ( state = :state or :state=0 ) order by  create_time desc limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':type' => $type,
                   ':state' => $state
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from Crm_Messages where  ( shop_id = :shop_id or :shop_id=0 )  and  ( type = :type or :type=0 )  and  ( state = :state or :state=0 ) " );
		$query->execute ( array (
':shop_id' => $shop_id,
                   ':type' => $type,
                   ':state' => $state
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部messages
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Messages " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据店铺ID获取最近一条messages
	public function get($shop_id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT 
    *
FROM
    gogotowncrm.Crm_Messages
where
    Shop_ID = :shop_id
order by Create_Time desc limit 1 " );
		$query->execute ( array (
				':shop_id' => $shop_id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>