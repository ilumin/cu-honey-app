

<?php

class blooming_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function blooming_infoByID($blooming_id){
		$sql ="SELECT * FROM BLOOMING WHERE BLOOMING_ID =".$blooming_id;
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
	}
	
	public function get_garden_info($garden_id, $flower_id){
		$sql = "SELECT * 
		FROM GARDEN AS G, GARDENFLOWER AS GF ,FLOWER  AS F
		WHERE 
		G.GARDEN_ID= GF.GARDEN_GARDEN_ID
		AND F.FLOWER_ID = GF.Flower_FLOWER_ID
		AND G.GARDEN_ID=".$garden_id." 
		AND GF.Flower_FLOWER_ID=".$flower_id;
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
	}
}

?>