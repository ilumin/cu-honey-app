<?php

class Fix_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }
	public function insert($data){
	$this->db->set($data);
	$this->db->insert('beehive_fix', $data);
	$insert_id = $this->db->insert_id();
	return  $insert_id;
	}
	
}
