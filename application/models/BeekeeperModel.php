<?php

class BeekeeperModel extends CI_Model
{
    var $field = array(
        // 'BEE_KEEPER_ID' => 'รหัสคนเลี้ยงผึ้ง',
        'FIRSTNAME' => 'ชื่อ',
        'LASTNAME' => 'นามสกุล',
        'ADDRESS' => 'ที่อยู่',
        'MOBILE' => 'เบอร์โทรมือถือ',
        'EMAIL' => 'อีเมล์',
        'PASSWORD' => 'รหัสผ่าน',
        'PROVINCE_ID' => 'จังหวัด',
    );

    public function __construct()	{
        $this->load->database();
    }

    public function getField() {
        return $this->field;
    }

    public function updateData($insert = array()) {
        $this->db->update('beekeeper', $insert);
    }

    public function getAll() {
        return (array) $this->db->get('beekeeper')->row();
    }

}