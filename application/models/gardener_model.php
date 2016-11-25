<?php

class gardener_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	
	public function get_flower(){
		
		$query = $this->db->query('SELECT * from flower');
		$data= $query->result_array();
		return $data;
	}
	public function province_near_by(){
		
		$query = $this->db->query('SELECT p.* from province as p,nearbyprovince as n WHERE p.province_id=n.Province_PROVINCE_ID');
		$data= $query->result_array();
		return $data;
	}
	public function gardener_list(){
		
		$query = $this->db->query('SELECT g.*,p.province_name from gardener as g, province as p WHERE g.province_id=p.province_id');
		$data= $query->result_array();
		return $data;
	}
	
	public function gardener_info($member_id){
		
		
		$query = $this->db->query('SELECT * from GARDENER as G, PROVINCE as P WHERE GARDENER_ID='.$member_id);
		$data= $query->row_array();
		return $data;
		
	}
	public function garden_info($member_id){
		
		
		$query = $this->db->query('SELECT * from GARDEN WHERE GARDENER_ID='.$member_id);
		$data= $query->row_array();
		return $data;
		
	}
	public function gardenflower_insert($data){
		
		
		$query = $this->db->query('SELECT * from GARDEN WHERE GARDENER_ID='.$member_id);
		$data= $query->row_array();
		return $data;
		
	}
}

?>

