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

  public function insert($data)
  {
    $has_email = isset($data['email']);
    $has_password = isset($data['password']);
    $has_password2 = isset($data['password2']);
    if (!$has_email || !$has_password || !$has_password2) {
      throw new Exception("Required email, password, and confirm password", 1);
    }

    $password_match = $data['password'] == $data['password2'];
    if (!$password_match) {
      throw new Exception("Password not match", 1);
    }

    $this->FIRSTNAME = isset($data['firstname']) ? $data['firstname'] : "";
    $this->LASTNAME = isset($data['lastname']) ? $data['lastname'] : "";
    $this->ADDRESS = isset($data['address']) ? $data['address'] : "";
    $this->PROVINCE_ID = isset($data['province']) ? $data['province'] : "";
    $this->MOBILE_NO = isset($data['phone']) ? $data['phone'] : "";
    $this->EMAIL = isset($data['email']) ? $data['email'] : "";
    $this->PASSWORD = isset($data['password']) ? md5($data['password']) : "";
    $this->STATUS = "approve";
    $this->REGISTER_DATE = date("Y-m-d H:i:s");

    $this->db->insert('gardener', $this);
    return $this;
  }
}
