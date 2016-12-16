<?php

class Harvest_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

   

	public function insert($data){
	$this->db->set($data);
	$this->db->insert('harvesthoney', $data);
	$insert_id = $this->db->insert_id();
	return  $insert_id;
	}
	public function insert_item($data){
	$this->db->set($data);
	$this->db->insert('harvesthoneyitem', $data);
	$insert_id = $this->db->insert_id();
	return  $insert_id;
	}
	public function insert_detail($data){
	$this->db->set($data);
	$this->db->insert('harvestitemdetail', $data);
	$insert_id = $this->db->insert_id();
	return  $insert_id;
	}
	
	
	
	
	public function update($id, $data = array())
    {
		$this->db->where('HARVEST_ID', $id);
		return $this->db->update('harvesthoney', $data);
		
    }
	public function update_BYBID($id, $data = array())
    {	
		$this->db->where('Blooming_BLOOMING_ID', $id);
		return $this->db->update('harvesthoney', $data);

    }
	
    public function updateStatusRaise($id)
    {
		$sql = "SELECT BEE_HIVE_ID FROM beehive WHERE  '".TODAY_DATE."' >ENDDATE AND STATUS ='เพาะ'";
		$query = $this->db->query($sql);
		$data= $query->result_array();

		foreach ($data as $key => $value){
			$update['STATUS'] = 'เก็บน้ำผึ้ง';
			$this->db->update('harvesthoneyitem', $update, "BeeHive_BEE_HIVE_ID=".$value['BEE_HIVE_ID']);
		}
    }
	
	 public function updateItem( $id, $data = array())
    {
		
		$update= array();

		if(isset($data['STATUS'])){
			$update['STATUS'] = $data['STATUS'];
		}
		if(isset($data['LASTED_HARVEST_DATE'])){
			$update['LASTED_HARVEST_DATE'] = $data['LASTED_HARVEST_DATE'];
		}
		if(isset($data['NO_HARVEST'])){
			$update['NO_HARVEST'] = $data['NO_HARVEST'];
		}
		if(isset($data['PERCENT_HARVEST'])){
			$update['PERCENT_HARVEST'] = $data['PERCENT_HARVEST'];
		}
		
		
		if(count($update)>0){
			$this->db->where('HARVESTHONEYITEM_ID', $id);
			
			return $this->db->update('harvesthoneyitem', $update);
		}else{
			
			return false;
		}
    }
	 public function updateItem_BY_BHID( $hive_id,$harvest_id, $data = array())
    {
		
		$update= array();
			////`HARVESTHONEYITEM_ID`, `HarvestHoney_HARVEST_ID`, `BeeHive_BEE_HIVE_ID`, `STATUS`, `LASTED_HARVEST_DATE`, `NO_HARVEST`, `PERCENT_HARVEST`
		if(isset($data['STATUS'])){
			$update['STATUS'] = $data['STATUS'];
		}
		if(isset($data['LASTED_HARVEST_DATE'])){
			$update['LASTED_HARVEST_DATE'] = $data['LASTED_HARVEST_DATE'];
		}
		if(isset($data['NO_HARVEST'])){
			$update['NO_HARVEST'] = $data['NO_HARVEST'];
		}
		if(isset($data['PERCENT_HARVEST'])){
			$update['PERCENT_HARVEST'] = $data['PERCENT_HARVEST'];
		}
		
		
		if(count($update)>0){
			$this->db->where('BeeHive_BEE_HIVE_ID', $hive_id);
			$this->db->where('HarvestHoney_HARVEST_ID', $harvest_id);
			
			return $this->db->update('harvesthoneyitem', $update);
		}else{
			
			return false;
		}
    }
	 public function updateItem_BY_HID( $harvest_id, $data = array())
    {
		
		$update= array();
			////`HARVESTHONEYITEM_ID`, `HarvestHoney_HARVEST_ID`, `BeeHive_BEE_HIVE_ID`, `STATUS`, `LASTED_HARVEST_DATE`, `NO_HARVEST`, `PERCENT_HARVEST`
		if(isset($data['STATUS'])){
			$update['STATUS'] = $data['STATUS'];
		}
		if(isset($data['LASTED_HARVEST_DATE'])){
			$update['LASTED_HARVEST_DATE'] = $data['LASTED_HARVEST_DATE'];
		}
		if(isset($data['NO_HARVEST'])){
			$update['NO_HARVEST'] = $data['NO_HARVEST'];
		}
		if(isset($data['SERVICE_CASH'])){
			$update['SERVICE_CASH'] = $data['SERVICE_CASH'];
		}
		
		if(isset($data['PERCENT_HARVEST'])){
			$update['PERCENT_HARVEST'] = $data['PERCENT_HARVEST'];
		}
		
		
		if(count($update)>0){
			$this->db->where('HarvestHoney_HARVEST_ID', $harvest_id);
			if(isset($data['STATUS_CHECK'])){
				$this->db->where('STATUS',$data['STATUS_CHECK']);
			}
			
			return $this->db->update('harvesthoneyitem', $update);
		}else{
			
			return false;
		}
    }
	
	
	 public function updateDetail_ByHIID( $id, $data = array())
    {
		
		$update= array();

		if(isset($data['HARVEST_DATE'])){
			$update['HARVEST_DATE'] = $data['HARVEST_DATE'];
		}
		if(isset($data['HONEY_AMOUNT'])){
			$update['HONEY_AMOUNT'] = $data['HONEY_AMOUNT'];
		}
		
		
		
		if(count($update)>0){
			$this->db->where('HARVESTHONEYITEM_ID', $id);
			
			return $this->db->update('harvestitemdetail', $update);
		}else{
			
			return false;
		}
    }
	function get_harvest_detail($id){
		$sql = "SELECT * FROM harvestitemdetail WHERE harvesthoneyitem_id=".$id;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	function get_harvest_info_BY_BID($id){
		$sql = "SELECT * FROM harvesthoney WHERE Blooming_BLOOMING_ID=".$id;
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
		
	}
	function get_harvest_info_BY_GID($id){ // USING FOR PUBLIC PARK ONLY
		$sql = "SELECT * FROM harvesthoney WHERE GARDEN_GARDEN_ID=".$id." AND HARVEST_STATUS='เก็บน้ำผึ้ง'  ";
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
		
	}
	
	function get_harvest_info_BYID($id){
		$sql = "SELECT H.*,G.NAME AS GARDEN_NAME ,F.FLOWER_NAME, COUNT(HI.HARVESTHONEYITEM_ID) AS COUNT_HIVE
		FROM harvesthoney AS H,GARDEN AS G ,FLOWER AS F ,HARVESTHONEYITEM AS HI
		WHERE  
		H.GARDEN_GARDEN_ID = G.GARDEN_ID 
		AND F.FLOWER_ID = H.FLOWER_FLOWER_ID 
		AND H.HARVEST_ID = HI.HARVESTHONEY_HARVEST_ID
		AND H.HARVEST_ID=".$id."
		GROUP BY HARVESTHONEY_HARVEST_ID
		";
		
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
		
	}
	
	function get_hiveForMove($garden_id, $amount_hive=0){ //FOR PUBLIC PARK ONLY CASE BLOOM MOVE 
	$sql ="SELECT Beehive_BEE_HIVE_ID AS BEE_HIVE_ID FROM HARVESTHONEYITEM AS HI, HARVESTHONEY AS H WHERE H.GARDEN_GARDEN_ID=".$garden_id." AND HARVEST_ID= HARVESTHONEY_HARVEST_ID AND HI.STATUS = 'เก็บน้ำผึ้ง' ";
		
		if($amount_hive >0){
			$sql .= " LIMIT 0,".$amount_hive;
			
		}
	
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	
	function harvest_complete(){
		$sql = "SELECT H.* FROM HARVESTHONEY AS H,GARDEN AS G 
		WHERE G.GARDEN_ID = H.GARDEN_GARDEN_ID 
		AND G.GARDEN_TYPE='MEMBER'
		AND HARVEST_STATUS='เก็บน้ำผึ้งเรียบร้อย'      ";
		//echo $sql;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	
}
