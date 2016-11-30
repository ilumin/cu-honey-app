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
	public function garden_info($member_id,$type="MEMBER"){


		$query = $this->db->query('SELECT * from GARDEN WHERE GARDEN_TYPE="'.$type.'" AND GARDENER_ID='.$member_id);
		$data= $query->row_array();
		return $data;

	}

	public function gardenflower_info($garden_id){


		$query = $this->db->query('SELECT * from GARDENFLOWER WHERE GARDEN_GARDEN_ID='.$garden_id);
		$data= $query->result_array();
		return $data;

	}
	
	public function garden_bloomingmonth($month,$garden_id){
	$query = $this->db->query('SELECT *FROM FLOWER F ,GARDENFLOWER GF WHERE
	(
		(BLOOM_START_MONTH <= BLOOM_END_MONTH AND BLOOM_START_MONTH <='.$month.' AND BLOOM_END_MONTH >='.$month.')
		OR 
		(BLOOM_START_MONTH >BLOOM_END_MONTH AND ('.$month.'<= BLOOM_END_MONTH   OR '.$month.'>= BLOOM_START_MONTH) )
	)
		AND GF.FLOWER_FLOWER_ID = F.FLOWER_ID
		AND GF.GARDEN_GARDEN_ID='.$garden_id);
		
	
		$data= $query->result_array();
		return $data;
	}

	public function gardenflower_insert($data){


		$check = $this->db->insert('gardenflower', $data);

		return $check;

	}
	public function insert_blooming($data){


		$check = $this->db->insert('blooming', $data);

		return $check;

	}
	public function blooming_info($garden_id){

		$query = $this->db->query('SELECT * from BLOOMING AS B,FLOWER AS F WHERE  F.FLOWER_ID = B.FLOWER_FLOWER_ID AND B.Garden_GARDEN_ID='.$garden_id);
		$data= $query->result_array();
		return $data;

	}
	public function garderflower_delete($id){

		$this->db->where('Garden_GARDEN_ID', $id);
		$check_delete = $this->db->delete('gardenflower');
		return $check_delete;
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

  public function insert_garden($data, $gardener_id)
  {
    $this->db->trans_begin();

    try {
      $has_gardener = !empty($gardener_id);
      if (!$has_gardener) {
        throw new Exception("Permission denied", 1);
      }

      $has_gardenflower = isset($data['selected']) ? !empty($data['selected']) : false;
      if (!$has_gardenflower) {
        throw new Exception("Required garden flower", 1);
      }

      $garden['GARDENER_ID'] = $gardener_id;
      $garden['NAME'] = isset($data['garden_name']) ? $data['garden_name'] : "";
      $garden['ADDRESS'] = isset($data['address']) ? $data['address'] : "";
      $garden['PROVINCE_ID'] = isset($data['province']) ? $data['province'] : "";
      $garden['GARDEN_TYPE'] = isset($data['garden_type']) ? $data['garden_type'] : "";
      $this->db->insert('garden', $garden);
      $garden_id = $this->db->insert_id();

      $selected_flowers = isset($data['selected']) ? $data['selected'] : array();
      $flowers = isset($data['flowers']) ? $data['flowers'] : array();
      foreach ($flowers as $flower_id => $flower) {
        if (!in_array($flower_id, $selected_flowers)) {
          continue;
        }

        $this->db->insert('gardenflower', array(
          'Garden_GARDEN_ID' => $garden_id,
          'Flower_FLOWER_ID' => $flower_id,
          'AMOUNT_HIVE' => isset($flower['hive']) ? $flower['hive'] : NULL,
          'RISK_MIX_HONEY' => isset($flower['risk']) ? $flower['risk']=='mix' : 0,
          'FLOWER_NEARBY_ID' => isset($flower['mix']) ? $flower['mix'] : NULL,
          'AREA' => isset($flower['area']) ? $flower['area'] : NULL,
        ));
      }

      $this->db->trans_commit();
    } catch (Exception $e) {
      $this->db->trans_rollback();
      throw new Exception("Database transaction error: " . $e->getMessage(), 1);

    }

  }
}
