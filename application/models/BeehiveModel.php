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
            $insert['EXPIRED_DATE'] = isset($data['expired_date']) ? $data['expired_date'] : null;
            $insert['STARTDATE'] = isset($data['start_date']) ? $data['start_date'] : null;
            $insert['ENDDATE'] = isset($data['end_date']) ? $data['end_date'] : null;
            $insert['STATUS'] = isset($data['status']) ? $data['status'] : null;

            $this->db->insert('beehive', $insert);

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert hive: " . $e->getMessage(), 1);
        }
    }
}
