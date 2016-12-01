<?php

class ConfigModel extends CI_Model
{
    var $field = array(
        'CAP_HARVEST_HONEY' => 'ความสามารถเก็บน้ำผึ้งต่อวัน (รัง)',
        'PERCENT_EST_NO_HIVE' => 'เปอร์เซ็นต์ความคลาดเคลื่อนของจำนวนการนำรังผึ้งไปวางในแต่ละสวน',
        'ROUND_HARVEST' => 'รอบการเก็บน้ำผึ้ง',
        'BEEHIVE_AGE' => 'อายุกล่องรังผึ้ง (ปี)',
        'BEEFRAME_AGE' => 'อายุของคอน(ปี)',
        'QUEENBEE_AGE' => 'อายุุนางพญาที่สามารถใช้งานได้(ปี)',
        'PERIOD_RAISE' => 'ระยะเวลาเพาะผึ้ง (เดือน)',
        'PERIOD_TRANSPORT' => 'ระยะเวลาที่สามารถขนรังผึ้งได้หลังจากชาวสวนโทรมาแจ้งดอกไม้บาน',
        'RENTAL_RATE' => 'อัตราค่าเช่าวางรังผึ้ง (10 กล่อง /วัน)',
    );

    public function __construct()	{
        $this->load->database();
    }

    public function getField() {
        return $this->field;
    }

    public function updateData($insert = array()) {
        $this->db->update('configuration', $insert);
    }

    public function getAll() {
        return (array) $this->db->get('configuration')->row();
    }

}