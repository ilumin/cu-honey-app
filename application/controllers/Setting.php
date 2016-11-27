<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
    private $data = array();

    public function hive($id = null)
    {
        $listAction = empty($id);
        $hasPostRequest = !empty($this->input->post());
        $newHiveAction = $hasPostRequest==true && empty($id);
        $updateHiveAction = $hasPostRequest==true && !empty($id);
        $displayFormAction = $listAction==false && $hasPostRequest==false;

        $this->load->library('session');
        $this->load->model('beehiveModel','',TRUE);

        $this->data['flash_type'] = $this->session->flashdata('flash.type');
        $this->data['flash_message'] = $this->session->flashdata('flash.message');

        if ($newHiveAction) {
            return $this->newHive($this->input->post());
        }

        if ($updateHiveAction) {
            return $this->updateHive($id, $this->input->post());
        }

        if ($listAction) {
            return $this->listHive();
        }

        if ($displayFormAction) {
            return $this->formEditHive($id);
        }

        throw new Exception("Invalid Request: missing hive ID", 1);
    }

    private function listHive()
    {
        $this->data['hives'] = $this->beehiveModel->list();

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_hive_list',$this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    private function formEditHive($id)
    {
        $this->data['hive_id'] = $id;
        $this->data['hive'] = $this->beehiveModel->getData($id);

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_hive_form', $this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    private function newHive($data = array())
    {
        // TODO: submit hive data
        var_dump($data);
        die();
    }

    private function updateHive($id, $insert = array())
    {
        try {
            $this->beehiveModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'อัพเดทข้อมูลกล่องรังผึ้งรหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive');
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/hive/' . $id);
        }
    }

}
