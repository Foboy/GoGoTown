<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:44:18
 * 商家对客户发送信息列表
 */
class MessageSendListModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增message_send_list
	public function insert($customer_id,$shop_id,$message_id,$title,$content,$create_time,$read_time,$state,$type) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_message_send_list where customer_id = :customer_id and shop_id = :shop_id and message_id = :message_id and type = :type" );
		$query->execute ( array (
':customer_id' => $customer_id,
                   ':shop_id' => $shop_id,
                   ':message_id' => $message_id,
                   ':type' => $type
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_message_send_list(customer_id,shop_id,message_id,title,content,create_time,read_time,state,type) values (:customer_id,:shop_id,:message_id,:title,:content,:create_time,:read_time,:state,:type)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':customer_id' => $customer_id,
                   ':shop_id' => $shop_id,
                   ':message_id' => $message_id,
                   ':title' => $title,
                   ':content' => $content,
                   ':create_time' => $create_time,
                   ':read_time' => $read_time,
                   ':state' => $state,
                   ':type' => $type
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_message_send_list where customer_id = :customer_id and shop_id = :shop_id and message_id = :message_id and title = :title and content = :content and create_time = :create_time and read_time = :read_time and state = :state and type = :type" );
		$query->execute ( array (
':customer_id' => $customer_id,
                   ':shop_id' => $shop_id,
                   ':message_id' => $message_id,
                   ':title' => $title,
                   ':content' => $content,
                   ':create_time' => $create_time,
                   ':read_time' => $read_time,
                   ':state' => $state,
                   ':type' => $type
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	// 修改message_send_list
	public function update($id,$customer_id,$shop_id,$message_id,$title,$content,$create_time,$read_time,$state,$type) {
		$sql = " update crm_message_send_list set customer_id = :customer_id,shop_id = :shop_id,message_id = :message_id,title = :title,content = :content,create_time = :create_time,read_time = :read_time,state = :state,type = :type where id = :id";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':id' => $id,
                   ':customer_id' => $customer_id,
                   ':shop_id' => $shop_id,
                   ':message_id' => $message_id,
                   ':title' => $title,
                   ':content' => $content,
                   ':create_time' => $create_time,
                   ':read_time' => $read_time,
                   ':state' => $state,
                   ':type' => $type
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			// 修改错误
			return false;
		}
		return true;
	}
	// 根据ID删除message_send_list
	public function delete($id) {
		$sql = " delete from crm_message_send_list where id = :id ";
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
	// 分页查询message_send_list
	public function searchByPages($customer_id,$shop_id,$message_id,$title,$content,$create_time,$read_time,$state,$type, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,customer_id,shop_id,message_id,title,content,create_time,read_time,state,type from crm_message_send_list where  ( customer_id = :customer_id or :customer_id=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( message_id = :message_id or :message_id=0 )  and  ( title = :title or :title='' )  and  ( content = :content or :content='' )  and  ( create_time = :create_time or :create_time=0 )  and  ( read_time = :read_time or :read_time=0 )  and  ( state = :state or :state=0 )  and  ( type = :type or :type=0 )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':customer_id' => $customer_id,
                   ':shop_id' => $shop_id,
                   ':message_id' => $message_id,
                   ':title' => $title,
                   ':content' => $content,
                   ':create_time' => $create_time,
                   ':read_time' => $read_time,
                   ':state' => $state,
                   ':type' => $type
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_message_send_list where  ( customer_id = :customer_id or :customer_id=0 )  and  ( shop_id = :shop_id or :shop_id=0 )  and  ( message_id = :message_id or :message_id=0 )  and  ( title = :title or :title='' )  and  ( content = :content or :content='' )  and  ( create_time = :create_time or :create_time=0 )  and  ( read_time = :read_time or :read_time=0 )  and  ( state = :state or :state=0 )  and  ( type = :type or :type=0 ) " );
		$query->execute ( array (
':customer_id' => $customer_id,
                   ':shop_id' => $shop_id,
                   ':message_id' => $message_id,
                   ':title' => $title,
                   ':content' => $content,
                   ':create_time' => $create_time,
                   ':read_time' => $read_time,
                   ':state' => $state,
                   ':type' => $type
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部message_send_list
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Message_Send_List " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取message_send_list
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Message_Send_List WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>