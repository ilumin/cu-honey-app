<?php

class BeehiveModel extends CI_Model
{
    public function __construct()	{
        $this->load->database();
    }

    public function list()
    {
        return array();
    }
}
