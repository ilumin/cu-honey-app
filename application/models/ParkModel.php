<?php

class ParkModel extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function updateData($garden_id, $data = array())
    {
        try {
            $update['GARDENER_ID'] = isset($data['gardener_id']) ? $data['gardener_id'] : null;
            $update['NAME'] = isset($data['name']) ? $data['name'] : null;
            $update['ADDRESS'] = isset($data['address']) ? $data['address'] : null;
            $update['PROVINCE_ID'] = isset($data['province']) ? $data['province'] : null;
            $update['GARDEN_TYPE'] = 'PUBLIC';
            $update['STATUS'] = 'APPROVE';

            $this->db->where('GARDEN_ID', $garden_id)->update('garden', $update);

            $this->db->where('Garden_GARDEN_ID', $garden_id)->delete('gardenflower');
            $flowers = $data['flowers'];
            foreach ($data['selected'] as $flower_id) {
                $flower = $flowers[$flower_id];
                $hive = isset($flower['hive']) ? $flower['hive'] : 0;
                $risk = isset($flower['risk']) ? $flower['risk']=='mix' : false;
                $mix = isset($flower['mix']) ? $flower['mix'] : null;
                $area = isset($flower['area']) ? $flower['area'] : null;
                $this->db->insert('gardenflower', array(
                    'Garden_GARDEN_ID' => $garden_id,
                    'Flower_FLOWER_ID' => $flower_id,
                    'AMOUNT_HIVE' => $hive,
                    'RISK_MIX_HONEY' => $risk,
                    'FLOWER_NEARBY_ID' => $mix,
                    'AREA' => $area,
                ));
            }

            return $garden_id;
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
            $insert['STATUS'] = 'APPROVE';

            $this->db->insert('garden', $insert);
            $garden_id = $this->db->insert_id();

            $flowers = $data['flowers'];
            foreach ($data['selected'] as $flower_id) {
                $flower = $flowers[$flower_id];
                $hive = isset($flower['hive']) ? $flower['hive'] : 0;
                $risk = isset($flower['risk']) ? $flower['risk']=='mix' : false;
                $mix = isset($flower['mix']) ? $flower['mix'] : null;
                $area = isset($flower['area']) ? $flower['area'] : null;
                $this->db->insert('gardenflower', array(
                    'Garden_GARDEN_ID' => $garden_id,
                    'Flower_FLOWER_ID' => $flower_id,
                    'AMOUNT_HIVE' => $hive,
                    'RISK_MIX_HONEY' => $risk,
                    'FLOWER_NEARBY_ID' => $mix,
                    'AREA' => $area,
                ));
            }

            return $this->db->insert_id();
        } catch (Exception $e) {
            throw new Exception("Cannot insert park: " . $e->getMessage(), 1);
        }
    }

    public function getData($id)
    {
        return (array) $this->db->where('GARDEN_ID', $id)->get('garden')->row();
    }

    public function getParkFlowers($park_id)
    {
        $result = array();
        $sql = "SELECT g.AMOUNT_HIVE AS hive, g.AREA AS area, g.RISK_MIX_HONEY AS risk, g.Flower_FLOWER_ID AS flower_id, g.FLOWER_NEARBY_ID AS mix FROM gardenflower g WHERE g.Garden_GARDEN_ID = '" . $park_id . "'";
        $flowers = $this->db->query($sql)->result_array();
        foreach ($flowers as $flower) {
            $result[$flower['flower_id']] = $flower;
        }
        return $result;
    }

    public function getAll()
    {
		$sql = "SELECT G.*, GF.AMOUNT_HIVE, F.FLOWER_NAME, P.PROVINCE_NAME FROM garden AS G, gardenflower AS GF, province AS P, flower AS F WHERE G.GARDEN_TYPE= 'PUBLIC' AND GF.GARDEN_GARDEN_ID=G.GARDEN_ID AND P.PROVINCE_ID = G.PROVINCE_ID AND F.FLOWER_ID = GF.Flower_FLOWER_ID ORDER BY G.GARDEN_ID DESC;";
        $query = $this->db->query($sql);
        $data= $query->result_array();
        return $data;
    }

}
