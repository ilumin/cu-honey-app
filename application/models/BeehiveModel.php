<?php

class BeehiveModel extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function listData()
    {
        return $this->db->get('beehive')->result();
    }

    public function getData($id)
    {
        return $this->db->where('BEE_HIVE_ID', $id)->get('beehive')->row();
    }
    public function get_DataBeekeeper() //FOR BEEKEEPER
    {
        $sql ="
		SELECT BH.* FROM BEEHIVE AS BH,GARDEN AS G WHERE GARDEN_GARDEN_ID=G.GARDEN_ID AND GARDEN_TYPE='BEEKEEPER'
		";
				
		$query = $this->db->query($sql);
		
		//var_dump($data['HARVESTHONEY']);
		
		return $query->result_array();
    }
    
    public function getCount_AllGarden() //FOR BEEKEEPER
    {
        $sql ="SELECT COUNT(BEE_HIVE_ID) AS AMOUNT_HIVE, GARDEN_GARDEN_ID  FROM BEEHIVE 
GROUP BY  GARDEN_GARDEN_ID";
				
		$query = $this->db->query($sql);
		
		//var_dump($data['HARVESTHONEY']);
		
		return $query->row_array();
    }

    public function updateStatusExpired()
    {
		$update['STATUS'] = 'หมดอายุ';
		return $this->db->update('beehive', $update, "'".TODAY_DATE."' >EXPIRED_DATE");
    }

    public function updateStatusRaise()
    {
		$update['STATUS'] = 'ว่าง';
		$update['STARTDATE'] = '0000-00-00';
		$update['ENDDATE'] = '0000-00-00';
		return $this->db->update('beehive', $update, "'".TODAY_DATE."' >ENDDATE AND STATUS ='เพาะ'");
    }

    public function updateData($id, $data = array())
    {
		$update= array();

		if(isset($data['expired_date'])){
			$update['EXPIRED_DATE'] = $data['expired_date'];
		}
		if(isset($data['start_date'])){
			$update['STARTDATE'] = $data['start_date'];
		}
		if(isset($data['end_date'])){
			$update['ENDDATE'] = $data['end_date'];
		}
		if(isset($data['status'])){
			$update['STATUS'] = $data['status'];
		}
		if(isset($data['GARDEN_GARDEN_ID'])){
			$update['GARDEN_GARDEN_ID'] = $data['GARDEN_GARDEN_ID'];
		}
		if(isset($data['FLOWER_FLOWER_ID'])){
			$update['FLOWER_FLOWER_ID'] = $data['FLOWER_FLOWER_ID'];
		}
		/* var_dump($update);
		echo $id; */
		if(count($update)>0){
         $this->db->where('BEE_HIVE_ID', $id);
			return $this->db->update('beehive', $update);
		}else{
			
			return false;
		}
    }

    public function insertData($data = array())
    {
        try {
			if(isset($data['expired_date'])){
				$insert['EXPIRED_DATE'] = $data['expired_date'];
			}
			if(isset($data['start_date'])){
				$insert['STARTDATE'] = $data['start_date'];
			}
			if(isset($data['end_date'])){
				$insert['ENDDATE'] = $data['end_date'];
			}
			if(isset($data['status'])){
				$insert['STATUS'] = $data['status'];
			}
			if(isset($data['GARDEN_GARDEN_ID'])){
				$insert['GARDEN_GARDEN_ID'] = $data['GARDEN_GARDEN_ID'];
			}
			if(isset($data['FLOWER_FLOWER_ID'])){
				$insert['FLOWER_FLOWER_ID'] = $data['FLOWER_FLOWER_ID'];
			}

            $this->db->insert('beehive', $insert);

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert hive: " . $e->getMessage(), 1);
        }
    }
}
