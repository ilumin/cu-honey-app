

<?php

class annual_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function annual_info(){
		$sql ="
			SELECT 
			G.GARDEN_ID as GARDEN_GARDEN_ID, 
			G.NAME,
			G.ADDRESS,
			P.PROVINCE_NAME,
			F.FLOWER_ID as FLOWER_FLOWER_ID,
			F.FLOWER_NAME,
			F.BLOOM_START_MONTH,
			F.BLOOM_END_MONTH,
			GF.AMOUNT_HIVE,
			GF.RISK_MIX_HONEY,
			GF.FLOWER_NEARBY_ID
			FROM GARDENFLOWER as GF,FLOWER as F, GARDEN as G ,PROVINCE as P
			WHERE 
			G.STATUS ='APPROVE' AND
			F.FLOWER_ID = GF.Flower_FLOWER_ID AND
			G.GARDEN_ID=GF.Garden_GARDEN_ID AND
			G.PROVINCE_ID= P.PROVINCE_ID AND
			G.GARDEN_TYPE = 'MEMBER'
			ORDER BY G.GARDEN_ID ASC, FLOWER_ID ASC
		";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	public function config(){
		$sql ="
			SELECT * FROM configuration
		";
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
	}
	
	public function insert($data){
		$this->db->insert('annualplan', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}
	public function insert_item($data){
		$check = $this->db->insert('annualplanitem', $data);
	return $check;

	}
	public function annual_info_list_db($year){
		$sql ="
			SELECT 
			G.GARDEN_ID as GARDEN_GARDEN_ID, 
						G.NAME,
						G.ADDRESS,
						P.PROVINCE_NAME,
						F.FLOWER_ID as FLOWER_FLOWER_ID,
						F.FLOWER_NAME,
						F.BLOOM_START_MONTH,
						F.BLOOM_END_MONTH,
						AI.AMOUNT_HIVE,
						AI.RISK_MIX_HONEY,
						AI.FLOWER_NEARBY_ID
			 FROM annualplan AS A, annualplanitem AS AI  
			,flower as F, garden as G ,province as P
			WHERE
			AI.ANNUALPLAN_ANNUAL_PLAN_ID=A.ANNUAL_PLAN_ID AND
			F.FLOWER_ID= AI.flower_flower_id AND
			G.GARDEN_ID = AI.Garden_GARDEN_ID AND
			P.PROVINCE_ID = G.PROVINCE_ID AND
			A.ANNUAL_YEAR = '".$year."'
			
		";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}

	public function annual_info_db($year){
		$sql ="
			SELECT 
			* FROM annualplan
			WHERE ANNUAL_YEAR=".$year;

		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
	}
	public function annual_info_list(){
		$sql ="
			SELECT 
			* FROM annualplan";

		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	
}

?>