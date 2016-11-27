<?php

class BeeframeModel extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function list()
    {
        return $this->db->get('beeframe')->result();
    }

    public function getData($id)
    {
        return $this->db->where('BEEFRAME_ID', $id)->get('beeframe')->row();
    }

    public function updateData($id, $data = array())
    {
        $insert['BeeHive_BEE_HIVE_ID'] = isset($data['beehive_id']) ? $data['beehive_id'] : null;
        $insert['EXPIRED_DATE'] = isset($data['expired_date']) ? $data['expired_date'] : null;
        $insert['STATUS'] = isset($data['status']) ? $data['status'] : null;

        return $this->db->where('BEEFRAME_ID', $id)->update('beeframe', $insert);
    }

    public function insertData($data = array())
    {
        try {
            $insert['BeeHive_BEE_HIVE_ID'] = isset($data['beehive_id']) ? $data['beehive_id'] : null;
            $insert['EXPIRED_DATE'] = isset($data['expired_date']) ? $data['expired_date'] : null;
            $insert['STATUS'] = isset($data['status']) ? $data['status'] : null;

            $this->db->insert('beeframe', $insert);

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert frame: " . $e->getMessage(), 1);
        }
    }

    public function getAvailableHive()
    {
        return $this->db
          ->query('SELECT BeeHive_BEE_HIVE_ID AS BEE_HIVE_ID, COUNT(BeeHive_BEE_HIVE_ID) AS available FROM beeframe GROUP BY BeeHive_BEE_HIVE_ID having COUNT(BeeHive_BEE_HIVE_ID) < 10;')
          ->result();
    }
}
