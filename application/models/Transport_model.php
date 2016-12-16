<?php

class Transport_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert('transport', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function insert_hive($data){
		$this->db->set($data);
		return $this->db->insert('transporthive', $data);
	}
		
	
	  public function updateTransport($id, $data = array())
    {
		$update= array();

		if(isset($data['transport_date'])){
			$update['TRANSPORT_DATE'] = $data['transport_date'];
		}
		
		if(isset($data['status'])){
			$update['STATUS'] = $data['status'];
		}
		if(isset($data['blooming_percent'])){
			$update['BLOOMING_PERCENT'] = $data['blooming_percent'];
		}
		if(isset($data['garden_garden_id'])){
			$update['GARDEN_GARDEN_ID'] = $data['garden_garden_id'];
		}
		if(isset($data['flower_flower_id'])){
			$update['flower_flower_id'] = $data['flower_flower_id'];
		}
		
		if(count($update)>0){
			$this->db->where('transport_id', $id);
			return $this->db->update('transport', $update);
		}else{
			
			return false;
		}
    }
	  public function updateTransportItem($id,$beeHiveId, $data = array())
    {
		$update= array();

		if(isset($data['STATUS'])){
			$update['STATUS'] = $data['STATUS'];
		}
		
		
		if(count($update)>0){
			$this->db->where('Transport_TRANSPORT_ID', $id);
			$this->db->where('BeeHive_BEE_HIVE_ID', $beeHiveId);
			return $this->db->update('transporthive', $update);
		}else{
			
			return false;
		}
    }
	public function get_transportBYID($transport_id){
			$sql ="SELECT T.*,G.ADDRESS,G.NAME AS GARDEN_NAME,F.FLOWER_NAME ,B.GARDEN_GARDEN_ID,B.FLOWER_FLOWER_ID,B.BLOOMING_ID  FROM TRANSPORT AS T,GARDEN AS G,FLOWER AS F ,BLOOMING AS B
			WHERE 
		B.Garden_GARDEN_ID = G.GARDEN_ID
		AND B.BLOOMING_ID = T.BLOOMING_BLOOMING_ID
		AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
		AND T.TRANSPORT_ID = ".$transport_id."
		";
			
		$query = $this->db->query($sql);
		
		//var_dump($data['HARVESTHONEY']);
		
		return $query->row_array();
	}
	public function get_transportHiveBYID($transport_id){
		$sql ="SELECT BEEHIVE_BEE_HIVE_ID FROM TRANSPORTHIVE AS TH, TRANSPORT AS T 
					WHERE 
					T.TRANSPORT_ID = ".$transport_id."
					AND TH.TRANSPORT_TRANSPORT_ID = T.TRANSPORT_ID
					ORDER BY BEEHIVE_BEE_HIVE_ID ASC
					";
		$query = $this->db->query($sql);
		//echo $sql;
		//var_dump($data['HARVESTHONEY']);
		
		return $query->result_array();
	}
	public function get_transportHiveBYBID($blooming_id){  // FOR PUBLIC PARK ONLY CREATE NEW HIVE
		$sql ="SELECT * FROM TRANSPORT AS T 
		WHERE T.BLOOMING_BLOOMING_ID=".$blooming_id;
		$query = $this->db->query($sql);		
		return $query->row_array();
	}
}

?>