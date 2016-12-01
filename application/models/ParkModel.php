<?php

class ParkModel extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function updateData($id, $data = array())
    {
        try {
            $update['GARDENER_ID'] = isset($data['gardener_id']) ? $data['gardener_id'] : null;
            $update['NAME'] = isset($data['name']) ? $data['name'] : null;
            $update['ADDRESS'] = isset($data['address']) ? $data['address'] : null;
            $update['PROVINCE_ID'] = isset($data['province']) ? $data['province'] : null;
            $update['GARDEN_TYPE'] = 'PUBLIC';
            $update['STATUS'] = isset($data['status']) ? $data['status'] : null;

            $this->db->where('GARDEN_ID', $id)->update('garden', $update);

            return $id;
        } catch (Exception $e) {
            throw new Exception("Cannot update park: " . $e->getMessage(), 1);
        }
    }

    public function insertData($data = array())
    {
        try {
            $insert['GARDENER_ID'] = isset($data['gardener_id']) ? $data['gardener_id'] : null;
            $insert['NAME'] = isset($data['name']) ? $data['name'] : null;
            $insert['ADDRESS'] = isset($data['address']) ? $data['address'] : null;
            $insert['PROVINCE_ID'] = isset($data['province']) ? $data['province'] : null;
            $insert['GARDEN_TYPE'] = 'PUBLIC';
            $insert['STATUS'] = 'ว่าง';

            $this->db->insert('garden', $insert);

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert park: " . $e->getMessage(), 1);
        }
    }

    public function getData($id)
    {
		
        return (array) $this->db->where('GARDEN_ID', $id)->get('garden')->row();
    }

    public function getAll()
    {
		$sql ="SELECT G.*, GF.AMOUNT_HIVE ,P.PROVINCE_NAME FROM GARDEN AS G,GARDENFLOWER AS GF,PROVINCE AS P WHERE G.GARDEN_TYPE= 'PUBLIC' AND GF.GARDEN_GARDEN_ID=G.GARDEN_ID AND  P.PROVINCE_ID = G.PROVINCE_ID";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
    }

}
