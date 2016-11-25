<?php

class member_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function check_login($email,$password) {
		$password = md5($password);
	  if($email != FALSE && $password != FALSE) {
		$query = $this->db->get_where('beekeeper', array('EMAIL' => $email,'PASSWORD'=>$password));
		$data= $query->row_array();
		//var_dump($data);
		if(is_null($data)== true){
			$query = $this->db->get_where('gardener', array('EMAIL' => $email,'PASSWORD'=>$password));
			$data= $query->row_array();
		}
		if(isset($data['BEE_KEEPER_ID'])){
			$data['id'] = $data['BEE_KEEPER_ID'];
			$data['type'] = 'beekeeper';
		}
		
		if(isset($data['GARDENER_ID'])){
			$data['id'] = $data['GARDENER_ID'];
			$data['type'] = 'gardener';
		}
		
		return $data;
	  }
	  else {
		return FALSE;
	  }
	}
	

}

?>