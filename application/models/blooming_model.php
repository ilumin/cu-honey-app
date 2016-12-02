

<?php

class blooming_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function blooming_infoByID($blooming_id){
		$sql ="SELECT * FROM BLOOMING WHERE BLOOMING_ID =".$blooming_id;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	
	
}

?>