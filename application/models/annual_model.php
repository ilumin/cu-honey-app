

<?php

class annual_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function annual_info(){
		$sql ="
			SELECT 
			G.GARDEN_ID, 
			G.NAME,
			G.ADDRESS,
			P.PROVINCE_NAME,
			F.FLOWER_ID,
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
			G.PROVINCE_ID= P.PROVINCE_ID
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
	
}

?>