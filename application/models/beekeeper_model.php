<?php

class beekeeper_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function get_beekeeper_info($id) {
	  if($id != FALSE) {
		$query = $this->db->get_where('beekeeper', array('BEE_KEEPER_ID' => $id));
		return $query->row_array();
	  }
	  else {
		return FALSE;
	  }
	}
	public function check_login($email,$password) {
	  if($email != FALSE && $password != FALSE) {
		$query = $this->db->get_where('beekeeper', array('EMAIL' => $email,'PASSWORD'=>$password));
		return $query->row_array();
	  }
	  else {
		return FALSE;
	  }
	}
	
}

?>