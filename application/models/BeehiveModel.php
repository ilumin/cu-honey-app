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
        $insert['EXPIRED_DATE'] = isset($data['expired_date']) ? $data['expired_date'] : null;
        $insert['STARTDATE'] = isset($data['start_date']) ? $data['start_date'] : null;
        $insert['ENDDATE'] = isset($data['end_date']) ? $data['end_date'] : null;
        $insert['STATUS'] = isset($data['status']) ? $data['status'] : null;

        return $this->db->where('BEE_HIVE_ID', $id)->update('beehive', $insert);
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
