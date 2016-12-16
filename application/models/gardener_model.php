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

  public function getAllProvince()
  {
    return $this->db->query('SELECT * from province')->result_array();
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
		$query = $this->db->query('SELECT * from gardener as G, province as P WHERE GARDENER_ID='.$member_id);
		$data= $query->row_array();
		return $data;

	}
	public function garden_all(){
		$query = $this->db->query('SELECT * from garden WHERE STATUS="APPROVE" ');
		$data= $query->result_array();
		return $data;
		
	}
	public function garden_all2(){
		$query = $this->db->query('SELECT * from garden  ');
		$data= $query->result_array();
		return $data;
		
	}
	public function flower_all(){
		$query = $this->db->query('SELECT * from flower  ');
		$data= $query->result_array();
		return $data;
		
	}
	public function garden_info($member_id,$type="MEMBER"){


		$query = $this->db->query('SELECT * from garden WHERE GARDEN_TYPE="'.$type.'" AND GARDENER_ID='.$member_id);
		$data= $query->row_array();
		return $data;

	}
	public function garden_infoByID($garden_id){


		$query = $this->db->query('SELECT * from garden WHERE GARDEN_ID='.$garden_id);
		$data= $query->row_array();
		return $data;

	}

	public function gardenflower_info($garden_id){
		$query = $this->db->query('SELECT * from gardenflower WHERE GARDEN_GARDEN_ID='.$garden_id);
		$data= $query->result_array();
		return $data;

	}

	public function garden_bloomingmonth($month,$garden_id){
	$sql = 'SELECT * FROM flower F ,gardenflower GF WHERE
	(
		(BLOOM_START_MONTH <= BLOOM_END_MONTH AND BLOOM_START_MONTH <='.$month.' AND BLOOM_END_MONTH >='.$month.')
		OR
		(BLOOM_START_MONTH >BLOOM_END_MONTH AND ('.$month.'<= BLOOM_END_MONTH   OR '.$month.'>= BLOOM_START_MONTH) )
	)
		AND GF.FLOWER_FLOWER_ID = F.FLOWER_ID
		AND GF.GARDEN_GARDEN_ID='.$garden_id;
	$query = $this->db->query($sql);
		
//	echo $sql;
		$data= $query->result_array();
		return $data;
	}

	public function gardenflower_insert($data){
		$check = $this->db->insert('gardenflower', $data);
		return $check;

	}
	public function insert_blooming($data){
		$this->db->insert('blooming', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function update_blooming($id,$data){
		
		 $this->db->where('BLOOMING_ID', $id);
        
		return $this->db->update('blooming', $data);
	}
	public function blooming_info($garden_id){
		$query = $this->db->query('SELECT * from blooming AS B,flower AS F WHERE  F.FLOWER_ID = B.FLOWER_FLOWER_ID AND B.Garden_GARDEN_ID='.$garden_id);
		$data= $query->result_array();
		return $data;
	}
	public function garderflower_delete($id){

		$this->db->where('Garden_GARDEN_ID', $id);
		$check_delete = $this->db->delete('gardenflower');
		return $check_delete;
	}

	public function update_garden_member($garden_id,$data){
		 try {
			 
           if (isset($data['gardener_id'])){ 
				$update['GARDENER_ID']= $data['gardener_id'];
		   }
           if (isset($data['name'])){ 
				$update['NAME']= $data['name'];
		   }
           if (isset($data['address'])){ 
				$update['ADDRESS']= $data['address'];
		   }
           if (isset($data['province_id'])){ 
				$update['PROVINCE_ID']= $data['province_id'];
		   }
           if (isset($data['garden_type'])){ 
				$update['GARDEN_TYPE']= $data['garden_type'];
		   }
           if (isset($data['status'])){ 
				$update['STATUS']= $data['status'];
		   }
           

            return $this->db->where('GARDEN_ID', $garden_id)->update('garden', $update);
		} catch (Exception $e) {
            throw new Exception("Cannot update park: " . $e->getMessage(), 1);
        }
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
      $garden['GARDEN_TYPE'] = "MEMBER";
      $garden['STATUS'] = "WAITING";
      $this->db->insert('garden', $garden);
      $garden_id = $this->db->insert_id();

      $selected_flowers = isset($data['selected']) ? $data['selected'] : array();
      $flowers = isset($data['flowers']) ? $data['flowers'] : array();
      foreach ($flowers as $flower_id => $flower) {
        if (!in_array($flower_id, $selected_flowers)) {
          continue;
        }
		
		if(isset($flower['risk'])){
			if($flower['risk']=='mix'){
				if($flower_id == $flower['mix'] ){
					unset($flower['risk']);
					unset($flower['mix']);
				}
			}else{
				unset($flower['mix']);
			}
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
	  return $garden_id;
    } catch (Exception $e) {
      $this->db->trans_rollback();
      throw new Exception("Database transaction error: " . $e->getMessage(), 1);

    }

  }
  
	public function distance($id){
	$query = $this->db->query('SELECT * from distancegarden WHERE Garden_GARDEN1_ID='.$id);
	$data= $query->result_array();
	return $data;
	  
	}


	public function insert_distance($data){
		$this->db->set($data);
		$check = $this->db->insert('distancegarden',$data);
		return $check;
		
	}

	public function update_distance($data){
		$update['DISTANCE'] = $data['DISTANCE'];
		 $this->db->where('Garden_GARDEN1_ID', $data['Garden_GARDEN1_ID']);
		 $this->db->where('Garden_GARDEN2_ID', $data['Garden_GARDEN2_ID']);
		return $this->db->update('distancegarden', $update);
		
	}
}
