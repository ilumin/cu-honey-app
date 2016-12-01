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
        $this->load->model('configModel','',TRUE);
        $this->load->model('beekeeperModel','',TRUE);
        $this->load->model('parkModel','',TRUE);
        $this->load->model('member_model','',TRUE);

        $this->data = $this->member_model->get_data();
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

    public function config()
    {
        $hasPostRequest = !empty($this->input->post());
        if ($hasPostRequest) {
            $this->configModel->updateData($this->input->post());
            header('Location: /setting/config');
        }

        $this->data['field'] = $this->configModel->getField();
        $this->data['config'] = $this->configModel->getAll();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('setting_config',$this->data);
        $this->load->view('theme/footer_js', $this->data);
        $this->load->view('theme/footer', $this->data);
    }

    public function beekeeper()
    {
        $hasPostRequest = !empty($this->input->post());
        if ($hasPostRequest) {
            $this->beekeeperModel->updateData($this->input->post());
            header('Location: /setting/config');
        }

        $this->data['field'] = $this->beekeeperModel->getField();
        $this->data['config'] = $this->beekeeperModel->getAll();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('setting_beekeeper',$this->data);
        $this->load->view('theme/footer_js', $this->data);
        $this->load->view('theme/footer', $this->data);
    }

    public function publicpark($id = null)
    {
        $hasId = !empty($id);
        $hasPostRequest = !empty($this->input->post());

        if ($hasId && $hasPostRequest) {
            $this->parkModel->updateData($id, $this->input->post());
            header('Location: /setting/publicpark');
        }

        if ($hasPostRequest) {
            $this->parkModel->insertData($this->input->post());
            header('Location: /setting/publicpark');
        }

        $user = $this->member_model->getUser();
        $this->data['gardener_id'] = isset($user['id']) ? $user['id'] : null;
        $this->data['park_id'] = $id;

        if ($hasId) {
            $this->data['park_edit'] = $this->parkModel->getData($id);
        }
        else {
            $this->data['parks'] = $this->parkModel->getAll();
        }

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);

        $this->load->view('setting_park',$this->data);

        $this->load->view('theme/footer_js', $this->data);
        $this->load->view('theme/footer', $this->data);
    }

    public function listHive()
    {
        $this->data['action'] = 'list-hive';
        $this->data['hives'] = $this->beehiveModel->listData();
        $this->data['frames'] = $this->beeframeModel->countFrame();
        $this->data['queens'] = $this->queenModel->mapHiveWithQueen();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_hive_list',$this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
    }

    public function formEditHive($id)
    {
        $this->data['action'] = 'form-hive';
        $this->data['hive_id'] = $id;
        $this->data['hive'] = $this->beehiveModel->getData($id);
        $this->data['frames'] = $this->beeframeModel->getFrameFromHive($id);
        $this->data['queen'] = $this->queenModel->getQueenFromHive($id);

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_hive_form', $this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
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
        $this->data['action'] = 'list-frame';
        $this->data['frames'] = $this->beeframeModel->listData();
        $this->data['hives'] = $this->beeframeModel->getAvailableHive();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_frame_list', $this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
    }

    public function formEditFrame($id)
    {
        $this->data['action'] = 'form-frame';
        $this->data['frame_id'] = $id;
        $this->data['frame'] = $this->beeframeModel->getData($id);
        $this->data['hives'] = $this->beeframeModel->getAvailableHive();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_frame_form', $this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
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
        $this->data['action'] = 'list-queen';
        $this->data['queens'] = $this->queenModel->listData();
        // $this->data['hives'] = $this->queenModel->getAvailableHive();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_queen_list', $this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
    }

    public function formEditQueen($id)
    {
        $this->data['action'] = 'form-queen';
        $this->data['queen_id'] = $id;
        $this->data['queen'] = $this->queenModel->getData($id);
        $this->data['hives'] = $this->queenModel->getAvailableHive();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_queen_form', $this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
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
