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
        $query = 'SELECT beehive.BEE_HIVE_ID, COUNT(beeframe.BeeHive_BEE_HIVE_ID) AS available from beehive LEFT JOIN beeframe ON beehive.BEE_HIVE_ID = beeframe.BeeHive_BEE_HIVE_ID GROUP BY beehive.BEE_HIVE_ID having COUNT(beehive.BEE_HIVE_ID) < 10';
        return $this->db
          ->query($query)
          ->result();
    }
}
