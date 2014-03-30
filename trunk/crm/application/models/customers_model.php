<?php


class customersModel {
	
	public function __construct(Database $db)
	{
		$this->db = $db;
	}
	
	//新增crm_customers
	public  function insert($name,$phone,$rank)
	{
		//判断是否已存在
		$query = $this->db->prepare("SELECT * FROM crm_customers WHERE Name = :name and Phone = :phone and Rank = :rank");
		$query->execute(array(':name' => $name,
				':phone' => $phone,
				':rank' => $rank));
		$count =  $query->rowCount();
		if ($count == 1) {
		
			return 0;
		}
		
		//添加操作
		$sql = "INSERT INTO crm_customers( Name,Phone,Rank)
				VALUES(:name,:phone,:rank) ";
		$query = $this->db->prepare($sql);
		$query->execute(array(':name' => $name,
				':phone' => $phone,
				':rank' => $rank));
		$count =  $query->rowCount();
		if ($count != 1) {
		
			return 0;
		}
		
		//获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare("SELECT ID FROM crm_customers WHERE Name = :name and Phone = :phone and Rank = :rank");
		$query->execute(array(':name' => $name,
				':phone' => $phone,
				':rank' => $rank));
		if ($query->rowCount() != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch();
		$customer_id = $result_user_row->ID;
		
	
		return $customer_id;
		
	}
	//修改crm_customers
	public  function update($id,$name,$phone,$rank)
	{
		$sql = "update crm_customers set name=:name, phone = :phone, rank=:rank where id = :id ";
		$query = $this->db->prepare($sql);
		$query->execute(array(':id' => $id,':name' => $name,
				':phone' => $phone,
				':rank' => $rank));
		$count =  $query->rowCount();
		if ($count != 1) {
			//修改错误
			return false;
		}
		return true;
		
	}
	//根据ID删除crm_customers
	public  function delete($id)
	{
		$sql = "delete from crm_customers where id = :id ";
		$query = $this->db->prepare($sql);
		$query->execute(array(':id' => $id));
		$count =  $query->rowCount();
		if ($count != 1) {
			//修改错误
			return false;
		}
		return true;
	}
	//分页查询
	public  function searchByPages($name,$phone,$rank,$pageindex,$pagesize)
	{
		$result = new PageDataResult();
		
		$query = $this->db->prepare("SELECT * FROM crm_customers WHERE Name = :name and Phone = :phone and Rank = :rank limit :lastpagenum,:pagesize");
		$query->execute(array(':name' => $name,
				':phone' => $phone,
				':rank' => $rank,
				':lastpagenum' => $pageindex*$pagesize,
				':pagesize' => $pagesize));
		
		$objects = $query->fetchAll();
		
		$query = $this->db->prepare("SELECT count(*) FROM crm_customers WHERE Name = :name and Phone = :phone and Rank = :rank ");
		$query->execute(array(':name' => $name,
				':phone' => $phone,
				':rank' => $rank));
		$totalcount=$query->fetch();
		
		$result->pageindex=$pageindex;
		$result->pagesize=$pagesize;
		$result->Data=$objects;
		$result->totalcount=$totalcount;
		
		return $result;
	}
	
	
	public  function search($name,$phone,$rank)
	{
		$result = new DataResult();
		
		$query = $this->db->prepare("SELECT * FROM crm_customers WHERE Name = :name and Phone = :phone and Rank = :rank ");
		$query->execute(array(':name' => $name,
				':phone' => $phone,
				':rank' => $rank));
		
		$objects = $query->fetchAll();
		$result->Data=$objects;
		return  $result;
	}
	
	public  function  get($id)
	{
		$result = new DataResult();
		
		$query = $this->db->prepare("SELECT * FROM crm_customers WHERE id = :id ");
		$query->execute(array(':id' => $id));
		
		$objects = $query->fetch();
		$result->Data=$objects;
		return  $result;
	}
	
}

?>