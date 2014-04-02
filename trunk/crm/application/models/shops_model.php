<?php
/**
 * @author yangchao
 * @email:66954011@qq.com
 * @date: 2014/3/30 18:51:38
 * 商家信息表
 */
class ShopsModel {
	public function __construct(Database $db) {
		$this->db = $db;
		$this->db->query("SET NAMES utf8");//设置数据库编码
	}
	
	// 新增shops
	public function insert($id,$name,$description,$cover_pictureid,$brand_id,$tags,$mobile,$telphone,$city_id,$area_id,$district_id,$street_id,$address,$longitude,$latitude,$booking_num,$view_num,$comm_num,$check_status,$add_adminid,$add_time,$flag) {
		// 判断是否已存在
		$query = $this->db->prepare ( " select *  from crm_shops where name = :name " );
		$query->execute ( array (
':id' => $id
		) );
		$count = $query->rowCount ();
		if ($count > 0) {
			return 0;
		}
		
		// 添加操作
		$sql = "insert into crm_shops(name,description,cover_pictureid,brand_id,tags,mobile,telphone,city_id,area_id,district_id,street_id,address,longitude,latitude,booking_num,view_num,comm_num,check_status,add_adminid,add_time,flag) values (:name,:description,:cover_pictureid,:brand_id,:tags,:mobile,:telphone,:city_id,:area_id,:district_id,:street_id,:address,:longitude,:latitude,:booking_num,:view_num,:comm_num,:check_status,:add_adminid,:add_time,:flag)";
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag
		) );
		$count = $query->rowCount ();
		if ($count != 1) {
			
			return 0;
		}
		
		// 获取ID
		// get user_id of the user that has been created, to keep things clean we DON'T use lastInsertId() here
		$query = $this->db->prepare ( " select id from crm_shops where name = :name and description = :description and cover_pictureid = :cover_pictureid and brand_id = :brand_id and tags = :tags and mobile = :mobile and telphone = :telphone and city_id = :city_id and area_id = :area_id and district_id = :district_id and street_id = :street_id and address = :address and longitude = :longitude and latitude = :latitude and booking_num = :booking_num and view_num = :view_num and comm_num = :comm_num and check_status = :check_status and add_adminid = :add_adminid and add_time = :add_time and flag = :flag" );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag
		) );
		if ($query->rowCount () != 1) {
			
			return 0;
		}
		$result_user_row = $query->fetch ();
		$customer_id = $result_user_row->id;
		
		return $customer_id;
	}
	
	// 分页查询shops
	public function searchByPages($name,$description,$cover_pictureid,$brand_id,$tags,$mobile,$telphone,$city_id,$area_id,$district_id,$street_id,$address,$longitude,$latitude,$booking_num,$view_num,$comm_num,$check_status,$add_adminid,$add_time,$flag, $pageindex, $pagesize) {
		$result = new PageDataResult ();
		$lastpagenum = $pageindex*$pagesize;
		
		$sql = " select id,name,description,cover_pictureid,brand_id,tags,mobile,telphone,city_id,area_id,district_id,street_id,address,longitude,latitude,booking_num,view_num,comm_num,check_status,add_adminid,add_time,flag from crm_shops where  ( name = :name or :name='' )  and  ( description = :description or :description='' )  and  ( cover_pictureid = :cover_pictureid or :cover_pictureid=0 )  and  ( brand_id = :brand_id or :brand_id=0 )  and  ( tags = :tags or :tags='' )  and  ( mobile = :mobile or :mobile='' )  and  ( telphone = :telphone or :telphone='' )  and  ( city_id = :city_id or :city_id=0 )  and  ( area_id = :area_id or :area_id=0 )  and  ( district_id = :district_id or :district_id=0 )  and  ( street_id = :street_id or :street_id=0 )  and  ( address = :address or :address='' )  and  ( longitude = :longitude or :longitude='' )  and  ( latitude = :latitude or :latitude='' )  and  ( booking_num = :booking_num or :booking_num=0 )  and  ( view_num = :view_num or :view_num=0 )  and  ( comm_num = :comm_num or :comm_num=0 )  and  ( check_status = :check_status or :check_status='' )  and  ( add_adminid = :add_adminid or :add_adminid=0 )  and  ( add_time = :add_time or :add_time=0 )  and  ( flag = :flag or :flag='' )  limit $lastpagenum,$pagesize" ;
		$query = $this->db->prepare ( $sql );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag
		) );
		$objects = $query->fetchAll ();
		
		$query = $this->db->prepare ( " select count(*)  from crm_shops where  ( name = :name or :name='' )  and  ( description = :description or :description='' )  and  ( cover_pictureid = :cover_pictureid or :cover_pictureid=0 )  and  ( brand_id = :brand_id or :brand_id=0 )  and  ( tags = :tags or :tags='' )  and  ( mobile = :mobile or :mobile='' )  and  ( telphone = :telphone or :telphone='' )  and  ( city_id = :city_id or :city_id=0 )  and  ( area_id = :area_id or :area_id=0 )  and  ( district_id = :district_id or :district_id=0 )  and  ( street_id = :street_id or :street_id=0 )  and  ( address = :address or :address='' )  and  ( longitude = :longitude or :longitude='' )  and  ( latitude = :latitude or :latitude='' )  and  ( booking_num = :booking_num or :booking_num=0 )  and  ( view_num = :view_num or :view_num=0 )  and  ( comm_num = :comm_num or :comm_num=0 )  and  ( check_status = :check_status or :check_status='' )  and  ( add_adminid = :add_adminid or :add_adminid=0 )  and  ( add_time = :add_time or :add_time=0 )  and  ( flag = :flag or :flag='' ) " );
		$query->execute ( array (
':name' => $name,
                   ':description' => $description,
                   ':cover_pictureid' => $cover_pictureid,
                   ':brand_id' => $brand_id,
                   ':tags' => $tags,
                   ':mobile' => $mobile,
                   ':telphone' => $telphone,
                   ':city_id' => $city_id,
                   ':area_id' => $area_id,
                   ':district_id' => $district_id,
                   ':street_id' => $street_id,
                   ':address' => $address,
                   ':longitude' => $longitude,
                   ':latitude' => $latitude,
                   ':booking_num' => $booking_num,
                   ':view_num' => $view_num,
                   ':comm_num' => $comm_num,
                   ':check_status' => $check_status,
                   ':add_adminid' => $add_adminid,
                   ':add_time' => $add_time,
                   ':flag' => $flag
		) );
		$totalcount = $query->fetchColumn ( 0 );
		
		$result->pageindex = $pageindex;
		$result->pagesize = $pagesize;
		$result->Data = $objects;
		$result->totalcount = $totalcount;
		
		return $result;
	}
    //查询全部shops
	public function search() {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shops " );
		$query->execute ();
		$objects = $query->fetchAll ();
		
		$result->Data = $objects;
		return $result;
	}
    //根据ID获取shops
	public function get($id) {
		$result = new DataResult ();
		
		$query = $this->db->prepare ( "SELECT * FROM Crm_Shops WHERE id = :id " );
		$query->execute ( array (
				':id' => $id 
		) );
		
		$objects = $query->fetch ();
		$result->Data = $objects;
		return $result;
	}
}

?>