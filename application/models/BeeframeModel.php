<?php

class BeeframeModel extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function listData()
    {
        return $this->db->get('beeframe')->result();
    }

    public function getData($id)
    {
        return $this->db->where('BEEFRAME_ID', $id)->get('beeframe')->row();
    }

    public function getFrameFromHive($id)
    {
        return $this->db->where('BeeHive_BEE_HIVE_ID', $id)->get('beeframe')->result();
    }
    public function updateStatusExpired()
    {
		$update['STATUS'] = 'หมดอายุ';
		return $this->db->update('beeframe', $update, "'".TODAY_DATE."' > EXPIRED_DATE");
    }
    public function countFrame()
    {
        $frames = array();
        $query = 'SELECT beehive.BEE_HIVE_ID, COUNT(beeframe.BeeHive_BEE_HIVE_ID) AS available from beehive LEFT JOIN beeframe ON beehive.BEE_HIVE_ID = beeframe.BeeHive_BEE_HIVE_ID GROUP BY beehive.BEE_HIVE_ID';
        $result = $this->db
          ->query($query)
          ->result();
        foreach ($result as $item) {
            $frames[$item->BEE_HIVE_ID] = $item->available;
        }

        return $frames;
    }

    public function updateData($id, $data = array())
    {
		
		if(isset($data['beehive_id'])){ $insert['BeeHive_BEE_HIVE_ID'] = $data['beehive_id']; }
		if(isset($data['expired_date'])){ $insert['EXPIRED_DATE'] = $data['expired_date']; }
		if(isset($data['status'])){ $insert['STATUS'] = $data['status']; }
		
        return $this->db->where('BEEFRAME_ID', $id)->update('beeframe', $insert);
    }

    public function insertData($data = array())
    {
        try {
            

			if(isset($data['beehive_id'])){ $insert['BeeHive_BEE_HIVE_ID'] = $data['beehive_id']; }
			if(isset($data['expired_date'])){ $insert['EXPIRED_DATE'] = $data['expired_date']; }
			if(isset($data['status'])){ $insert['STATUS'] = $data['status']; }
		
			
            $this->db->insert('beeframe', $insert);

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert frame: " . $e->getMessage(), 1);
        }
    }

    public function getAvailableHive()
    {
        $query = 'SELECT beehive.BEE_HIVE_ID, COUNT(beeframe.BeeHive_BEE_HIVE_ID) AS available from beehive LEFT JOIN beeframe ON beehive.BEE_HIVE_ID = beeframe.BeeHive_BEE_HIVE_ID GROUP BY beehive.BEE_HIVE_ID having COUNT(beehive.BEE_HIVE_ID) < 10';
        return $this->db
          ->query($query)
          ->result();
    }
}
