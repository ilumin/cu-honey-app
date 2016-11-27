<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function hive($id = null)
    {
        $listAction = empty($id);
        $submitAction = !empty($this->input->post('submit_type'));

        $this->load->model('beehive','',TRUE);

        if ($listAction) {
            return $this->listHive();
        }

        if ($submitAction) {
            return $this->submitHive($id, $this->input->post());
        }

        throw new Exception("Invalid Request: missing hive ID", 1);
    }

    public function listHive()
    {
        $data['hives'] = $this->beehive->list();

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_hive_list',$data);
    		$this->load->view('theme/nonlogin/footer');
    }

    public function submitHive($id, $data = array())
    {
        // TODO: submit hive data
    }

}
