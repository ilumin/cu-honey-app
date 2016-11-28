<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('beehiveModel','',TRUE);
        $this->load->model('beeframeModel','',TRUE);
        $this->load->model('queenModel','',TRUE);
    }

    public function hive($id = null)
    {
        $listAction = empty($id);
        $hasPostRequest = !empty($this->input->post());
        $newHiveAction = $hasPostRequest==true && empty($id);
        $updateHiveAction = $hasPostRequest==true && !empty($id);
        $displayFormAction = $listAction==false && $hasPostRequest==false;

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

    public function frame($id = null)
    {
        $listAction = empty($id);
        $hasPostRequest = !empty($this->input->post());
        $newFrameAction = $hasPostRequest==true && empty($id);
        $updateFrameAction = $hasPostRequest==true && !empty($id);
        $displayFormAction = $listAction==false && $hasPostRequest==false;

        $this->data['flash_type'] = $this->session->flashdata('flash.type');
        $this->data['flash_message'] = $this->session->flashdata('flash.message');

        if ($newFrameAction) {
            return $this->newFrame($this->input->post());
        }

        if ($updateFrameAction) {
            return $this->updateFrame($id, $this->input->post());
        }

        if ($listAction) {
            return $this->listFrame();
        }

        if ($displayFormAction) {
            return $this->formEditFrame($id);
        }

        throw new Exception("Invalid Request: missing frame ID", 1);
    }

    public function queen($id = null)
    {
        $listAction = empty($id);
        $hasPostRequest = !empty($this->input->post());
        $newQueenAction = $hasPostRequest==true && empty($id);
        $updateQueenAction = $hasPostRequest==true && !empty($id);
        $displayFormAction = $listAction==false && $hasPostRequest==false;

        $this->data['flash_type'] = $this->session->flashdata('flash.type');
        $this->data['flash_message'] = $this->session->flashdata('flash.message');

        if ($newQueenAction) {
            return $this->newQueen($this->input->post());
        }

        if ($updateQueenAction) {
            return $this->updateQueen($id, $this->input->post());
        }

        if ($listAction) {
            return $this->listQueen();
        }

        if ($displayFormAction) {
            return $this->formEditQueen($id);
        }

        throw new Exception("Invalid Request: missing frame ID", 1);
    }

    public function listHive()
    {
        $this->data['hives'] = $this->beehiveModel->list();
        $this->data['frames'] = $this->beeframeModel->countFrame();
        $this->data['queens'] = $this->queenModel->mapHiveWithQueen();

			$this->load->view('theme/header', $data);
			$this->load->view('theme/left_bar', $data);
			$this->load->view('theme/nav',$data);
    		$this->load->view('setting_hive_list',$this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    public function formEditHive($id)
    {
        $this->data['hive_id'] = $id;
        $this->data['hive'] = $this->beehiveModel->getData($id);
        $this->data['frames'] = $this->beeframeModel->getFrameFromHive($id);
        $this->data['queen'] = $this->queenModel->getQueenFromHive($id);

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_hive_form', $this->data);
    		$this->load->view('setting_frame_list', $this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    private function newHive($insert = array())
    {
        try {
            $id = $this->beehiveModel->insertData($insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลกล่องรังผึ้งรหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive');
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/hive/' . $id);
        }

    }

    private function updateHive($id, $insert = array())
    {
        try {
            $this->beehiveModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลกล่องรังผึ้งรหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive');
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/hive/' . $id);
        }
    }

    private function listFrame()
    {
        $this->data['frames'] = $this->beeframeModel->blist();
        $this->data['hives'] = $this->beeframeModel->getAvailableHive();

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_frame_list', $this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    public function formEditFrame($id)
    {
        $this->data['frame_id'] = $id;
        $this->data['frame'] = $this->beeframeModel->getData($id);
        $this->data['hives'] = $this->beeframeModel->getAvailableHive();

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_frame_form', $this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    public function updateFrame($id, $insert = array())
    {
        try {
            $this->beeframeModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลคอนรหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/hive/' . $id);
        }
    }

    public function newFrame($insert = array())
    {
        try {
            $id = $this->beeframeModel->insertData($insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลคอนผึ้งรหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/hive/' . $id);
        }
    }

    public function listQueen()
    {
        $this->data['queens'] = $this->queenModel->blist();
        // $this->data['hives'] = $this->queenModel->getAvailableHive();

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_queen_list', $this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    public function formEditQueen($id)
    {
        $this->data['queen_id'] = $id;
        $this->data['queen'] = $this->queenModel->getData($id);
        $this->data['hives'] = $this->queenModel->getAvailableHive();

    		$this->load->view('theme/nonlogin/header');
    		$this->load->view('setting_queen_form', $this->data);
    		$this->load->view('theme/nonlogin/footer');
    }

    public function newQueen($insert = array())
    {
        try {
            $id = $this->queenModel->insertData($insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลกล่องนางพญารหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/queen/');
        }
    }

    public function updateQueen($id, $insert = array())
    {
        try {
            $this->queenModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลนางพญารหัส ' . $id . ' สำเร็จ');
            header('Location: /setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
            header('Location: /setting/queen');
        }
    }

}
