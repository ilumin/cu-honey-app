<?php

class QueenModel extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function list()
    {
        return $this->db->get('queenbee')->result();
    }

    public function getData($id)
    {
        return $this->db->where('QUEEN_ID', $id)->get('queenbee')->row();
    }

    public function getQueenFromHive($id)
    {
        return $this->db->where('BeeHive_BEE_HIVE_ID', $id)->get('queenbee')->row();
    }

    public function mapHiveWithQueen()
    {
        $frames = array();
        $query = 'SELECT beehive.BEE_HIVE_ID, queenbee.QUEEN_ID from beehive LEFT JOIN queenbee ON beehive.BEE_HIVE_ID = queenbee.BeeHive_BEE_HIVE_ID';
        $result = $this->db
          ->query($query)
          ->result();
        foreach ($result as $item) {
            $frames[$item->BEE_HIVE_ID] = $item->QUEEN_ID;
        }

        return $frames;
    }

    public function updateData($id, $data = array())
    {
        $insert['BeeHive_BEE_HIVE_ID'] = isset($data['beehive_id']) ? $data['beehive_id'] : null;
        $insert['EXPIRED_DATE'] = isset($data['expired_date']) ? $data['expired_date'] : null;
        $insert['STATUS'] = isset($data['status']) ? $data['status'] : null;

        $duplicate = $this->db->where('BeeHive_BEE_HIVE_ID', $insert['BeeHive_BEE_HIVE_ID'])->where('QUEEN_ID !=', $id)->from('queenbee')->count_all_results();
        if ($duplicate) {
            throw new Exception("Hive already has queen", 1);
        }

        return $this->db->where('QUEEN_ID', $id)->update('queenbee', $insert);
    }

    public function insertData($data = array())
    {
        try {
            $insert['BeeHive_BEE_HIVE_ID'] = isset($data['beehive_id']) ? $data['beehive_id'] : null;
            $insert['EXPIRED_DATE'] = isset($data['expired_date']) ? $data['expired_date'] : null;
            $insert['STATUS'] = isset($data['status']) ? $data['status'] : null;

            $duplicate = $this->db->where('BeeHive_BEE_HIVE_ID', $insert['BeeHive_BEE_HIVE_ID'])->from('queenbee')->count_all_results();
            if ($duplicate) {
                throw new Exception("Hive already has queen", 1);
            }

            $this->db->insert('queenbee', $insert);

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert queen: " . $e->getMessage(), 1);
        }
    }

    public function getAvailableHive()
    {
        $query = 'SELECT beehive.BEE_HIVE_ID from beehive WHERE BEE_HIVE_ID NOT IN (SELECT BeeHive_BEE_HIVE_ID FROM queenbee)';
        return $this->db
          ->query($query)
          ->result();
    }

}
