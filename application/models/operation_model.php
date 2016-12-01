<?php

class operation_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function blooming_info(){
		
	
		$sql ="
			SELECT  
			B.BLOOMING_ID,
			B.BLOOMING_PERCENT,
			B.BLOOMING_STATUS,
			B.BLOOMING_STARTDATE,
			B.BLOOMING_ENDDATE,
			B.FLOWER_FLOWER_ID,
			F.FLOWER_NAME,
			GF.AMOUNT_HIVE,
			GF.RISK_MIX_HONEY,
			GF.AMOUNT_HIVE,
			D.DEMAND_ORDER,
			G.GARDEN_ID,
			G.NAME
			FROM 
			BLOOMING AS B,FLOWER AS F,GARDENFLOWER AS GF,HONEYDEMAND AS D,GARDEN AS G
			WHERE B.BLOOMING_STATUS= 'รอยืนยัน'  
			AND B.FLOWER_FLOWER_ID=F.FLOWER_ID
			AND GF.GARDEN_GARDEN_ID = B.GARDEN_GARDEN_ID
			AND F.FLOWER_ID = D.Flower_FLOWER_ID
			AND G.GARDEN_ID = B.GARDEN_GARDEN_ID
			ORDER BY DEMAND_ORDER ASC
		";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	
	public function hive_avaliable(){
		
		$sql ="
			
			SELECT BEE_HIVE_ID FROM BEEHIVE WHERE STATUS='ว่าง'
		";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	
	public function insert_hive_transportation_item($data){
		$this->db->insert('transporthive', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
}

?>