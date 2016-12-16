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
        $this->load->model('beekeeper_model','',TRUE);
        $this->load->model('beekeeperModel','',TRUE);
        $this->load->model('parkModel','',TRUE);
        $this->load->model('member_model','',TRUE);
        $this->load->model('gardener_model','',TRUE);
        $this->load->model('harvest_model','',TRUE);
        $this->load->model('transport_model','',TRUE);

        $this->data = $this->member_model->get_data();
    }
	public function auto_create_hive(){
		$this->data['parks'] = $this->beekeeper_model->get_garden_beekeeper();

		$this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('setting_auto_hive',$this->data);
        $this->load->view('theme/footer_js', $this->data);
        $this->load->view('theme/footer', $this->data);
		
	}
	public function save_auto_create_hive(){
		$config = $this->configModel->getAll();
		$amount_hive = $this->input->post('amount_hive');
		$garden_id = $this->input->post('garden_id');
		$flower_id = $this->input->post('flower_id');
		//Create Hive
		
		//raise period
		
		if($garden_id !=null && $flower_id !=null){
			$harvest_info =   $this->harvest_model->get_harvest_info_BY_GID($garden_id);
			
			if(isset($harvest_info['Blooming_BLOOMING_ID'])){
				$transfer_info =   $this->transport_model->get_transportHiveBYBID($harvest_info['Blooming_BLOOMING_ID']);
			}
			

			for($k=0;$k< $amount_hive; $k++){
				$insert_h['start_date'] = TODAY_DATE;
				$insert_h['end_date'] = date('Y-m-d',strtotime(TODAY_DATE." +".$config['PERIOD_RAISE']."days"));
				
				$insert_h['expired_date'] = date('Y-m-d',strtotime(TODAY_DATE." +".$config['BEEHIVE_AGE']."years"));
				$insert_h['status'] = 'เพาะ';
				$insert_h['GARDEN_GARDEN_ID'] = $garden_id;
				$insert_h['FLOWER_FLOWER_ID'] = $flower_id;

				
				$hive_id = $this->beehiveModel->insertData($insert_h);
				//echo $hive_id;
				 
			
				for($i=0;$i<10;$i++){
					$insert_f['expired_date'] = date('Y-m-d',strtotime(TODAY_DATE." +".$config['BEEFRAME_AGE']."years"));
					$insert_f['beehive_id'] = $hive_id;
					$insert_f['status'] = 'ใช้งาน'; 
					 $frame_id = $this->beeframeModel->insertData($insert_f);
				}
				
				//
				//Create Queen
				$insert_q['expired_date'] = date('Y-m-d',strtotime(TODAY_DATE." +".$config['QUEENBEE_AGE']."years"));
				$insert_q['beehive_id'] = $hive_id;
				$insert_q['status'] = 'ใช้งาน'; 
				
				$queen_id = $this->queenModel->insertData($insert_q);
				
				if(count($harvest_info) >0){
					$insert_ha['HarvestHoney_HARVEST_ID'] = $harvest_info['HARVEST_ID']  ; // TO DO Will be revise to get last insert transport  --34
					$insert_ha['BeeHive_BEE_HIVE_ID']=$hive_id;
					$insert_ha['STATUS']='รอเก็บน้ำผึ้ง'; //ครบ 2 เดือน หากสถานะในสวนสาธารณะเป็นว่าง อันนี้ต้องเปลี่ยนเป็นเก็บน้ำผึ้งด้วยเช่นกัน
					$insert_ha['LASTED_HARVEST_DATE']='0000-00-00';
					$insert_ha['NO_HARVEST']='0';
					$insert_ha['PERCENT_HARVEST']='0';

					$chk_insert3 =  $this->harvest_model->insert_item($insert_ha);
				}
				
				if(count($transfer_info) >0){
					$insert_th['Transport_TRANSPORT_ID'] = $transfer_info['TRANSPORT_ID'] ; // TO DO Will be revise to get last insert transport  --34
					$insert_th['BeeHive_BEE_HIVE_ID']=$hive_id;
					$insert_th['STATUS']='ขนส่งเรียบร้อย';

					$chk_insert4  =  $this->transport_model->insert_hive($insert_th);
				}
				
				
			}
			
		}
		redirect('setting/hive');
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
           redirect('setting/config','refresh');
        }

        $this->data['field'] = $this->configModel->getField();
        $this->data['config'] = $this->configModel->getAll();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('setting_config',$this->data);
        $this->load->view('theme/footer_js', $this->data);
        $this->load->view('js/setting_config',$this->data);
        $this->load->view('theme/footer', $this->data);
    }

    public function beekeeper()
    {
        $hasPostRequest = !empty($this->input->post());
        if ($hasPostRequest) {
            $this->beekeeperModel->updateData($this->input->post());
           redirect('setting/config','refresh');
        }

        $this->data['field'] = $this->beekeeperModel->getField();
        $this->data['config'] = $this->beekeeperModel->getAll();
        $this->data['province'] = $this->gardener_model->getAllProvince();

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('setting_beekeeper',$this->data);
		$this->load->view('theme/footer_js', $this->data);
        $this->load->view('js/setting_beekeeper', $this->data);
		
        $this->load->view('theme/footer', $this->data);
    }
    public function beekeeper_movehive()
    {
        


		$this->data['garnden_bkp'] = $this->gardener_model->garden_info(1,"BEEKEEPER");
        
        $this->data['amount_all'] = $this->beehiveModel->getCount_AllGarden();
        $this->data['hives'] = $this->beehiveModel->get_DataBeekeeper();
        $this->data['parks'] = $this->parkModel->getAll();
		
		$flower = $this->gardener_model->flower_all();
		$garden = $this->gardener_model->garden_all();
		for($i=0;$i<count($garden);$i++){
			$this->data['garden'][$garden[$i]['GARDEN_ID']] = $garden[$i]['NAME']; 
		}
		for($i=0;$i<count($flower);$i++){
			$this->data['flower'][$flower[$i]['FLOWER_ID']] = $flower[$i]['FLOWER_NAME']; 
		}
		
		 foreach($this->data['parks'] as $key => $value){
			$remain_hive = $this->parkModel->get_hive($value['GARDEN_ID']);
			$this->data['remain_hive'][$value['GARDEN_ID']]  = $remain_hive['REMAIN_HIVE'];
			
		} 
		
		
		//var_dump($this->data['parks']);
		
        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('beekeeper_move',$this->data);
		$this->load->view('theme/footer_js', $this->data);
        $this->load->view('theme/footer', $this->data);
    }
	
	public function move_hive_save()
	{
		$park_id = $this->input->post('parks_move');
		$hive_select = $this->input->post('hive_select');
		$garden_id = $this->input->post('garden_id');
		$flower_id = $this->input->post('flower_id');
		
	//เหมือน MOVE BACK
		
	}
    public function flower()
    {
        $hasPostRequest = !empty($this->input->post());
        if ($hasPostRequest) {
            $this->beekeeperModel->updateData($this->input->post());
           redirect('setting/config','refresh');
        }

        $this->data['field'] = $this->beekeeperModel->getField();
        $this->data['config'] = $this->beekeeperModel->getAll();
        $this->data['province'] = $this->gardener_model->getAllProvince();
		$this->data['flowers'] = $this->gardener_model->get_flower();
		
        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
        $this->load->view('setting_flower',$this->data);
		$this->load->view('theme/footer_js', $this->data);
        $this->load->view('js/setting_beekeeper', $this->data);
        $this->load->view('theme/footer', $this->data);
    }

    public function publicpark($id = null)
    {
        $hasId = !empty($id);
        $hasPostRequest = !empty($this->input->post());

        if ($hasId && $hasPostRequest) {
            $this->parkModel->updateData($id, $this->input->post());
			
			
           redirect('setting/publicpark');
        }

        if ($hasPostRequest) {
            $id = $this->parkModel->insertData($this->input->post());
			
			
			//INSERT DISTANCE BETWEEN GARDEN 
			$garden = $this->gardener_model->garden_all();
			
			for($i=0;$i<count($garden);$i++){
				$data_insert[$id][$garden[$i]['GARDEN_ID']] = 0;
				$data_insert[$garden[$i]['GARDEN_ID']][$id] = 0;
				
				if(isset($data_insert[$id][$id])){
					unset($data_insert[$id][$id]);
				}
			}
			
			foreach($data_insert as $i => $val1){
				foreach($val1 as $j => $distance){
					$distance_insert['Garden_GARDEN1_ID'] = $i;
					$distance_insert['Garden_GARDEN2_ID'] = $j;
					$distance_insert['DISTANCE']=$distance;
					$this->gardener_model->insert_distance($distance_insert);
					
				}
				
			}
			
			//INSERT BLOOMING PUBLIC_PARK
			
			
			$data_b['Garden_GARDEN_ID']= $id;
			$data_b['Flower_FLOWER_ID']=  BJP_FLOWER;
			$data_b['BLOOMING_STARTDATE']= TODAY_DATE;
			$data_b['BLOOMING_ENDDATE']= '0000-00-00';
			$data_b['BLOOMING_PERCENT']= '100';
			$data_b['BLOOMING_STATUS']= 'ยืนยัน';
			$data_b['RISK_MIX_HONEY']= 1;
			$data_b['DEMAND_FLOWER_ID']= BJP_FLOWER;
			
			
			$insert_id = $this->gardener_model->insert_blooming($data_b);
			
			//INSERT HARVEST PUBLIC_PARK
			
			$data_h['Garden_GARDEN_ID'] = $id;
			$data_h['Flower_FLOWER_ID']=BJP_FLOWER;
			$data_h['Blooming_BLOOMING_ID']= $insert_id;
			$data_h['HARVEST_STATUS'] ='เก็บน้ำผึ้ง';
			$data_h['HONEY_AMOUNT'] ='0';
			$data_h['HARVEST_STARTDATE'] =TODAY_DATE;
			$data_h['HARVEST_ENDDATE']  ='0000-00-00';
			$insert_id2 =  $this->harvest_model->insert($data_h);
			
			//INSERT TRANSFER 
			
			//INSERT TRANSPORT 
			$data_t['TRANSPORT_DATE'] = TODAY_DATE;
			$data_t['STATUS'] = 'ขนส่งเรียบร้อย';
			$data_t['FLOWER_FLOWER_ID'] = BJP_FLOWER;
			$data_t['GARDEN_GARDEN_ID'] = $id;
			$data_t['Blooming_BLOOMING_ID'] = $insert_id;
			$data_t['HarvestHoney_HARVEST_ID'] = $insert_id2;
			$insert_id = $this->transport_model->insert($data_t);
			
           redirect('setting/publicpark');
        }

        $user = $this->session->userdata('logged_in');
        if (empty($user)) {
           redirect('member/login');
        }

        $this->data['gardener_id'] = isset($user['id']) ? $user['id'] : null;
        $this->data['park_id'] = $id;
		$province_open = $this->gardener_model->province_near_by();
		$this->data['province'] = $province_open;
        $this->data['flowers'] = $this->gardener_model->get_flower();

        if ($hasId) {
            $this->data['park_edit'] = $this->parkModel->getData($id);
            $this->data['gardenflowers'] = $this->parkModel->getParkFlowers($id);
        }
        else {
            $this->data['park_list'] = true;
            $this->data['parks'] = $this->parkModel->getAll();
			
			foreach($this->data['parks'] as $key => $value){
				$this->data['remain_hive'][$value['GARDEN_ID']] = $this->parkModel->get_hive($value['GARDEN_ID']);
				
			}
        }

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);

        $this->load->view('setting_park',$this->data);
        $this->load->view('theme/footer_js', $this->data);
        $this->load->view('js/setting_js',$this->data);

        $this->load->view('theme/footer', $this->data);
    }

    public function listHive()
    {
        $this->data['action'] = 'list-hive';
        $this->data['hives'] = $this->beehiveModel->listData();
        $this->data['frames'] = $this->beeframeModel->countFrame();
        $this->data['queens'] = $this->queenModel->mapHiveWithQueen();
		$flower = $this->gardener_model->flower_all();
		$garden = $this->gardener_model->garden_all();
		for($i=0;$i<count($garden);$i++){
			$this->data['garden'][$garden[$i]['GARDEN_ID']] = $garden[$i]['NAME']; 
		}
		for($i=0;$i<count($flower);$i++){
			$this->data['flower'][$flower[$i]['FLOWER_ID']] = $flower[$i]['FLOWER_NAME']; 
		}

        $this->load->view('theme/header', $this->data);
        $this->load->view('theme/left_bar', $this->data);
        $this->load->view('theme/nav', $this->data);
    		$this->load->view('setting_hive_list',$this->data);
    		$this->load->view('theme/footer_js', $this->data);
			$this->load->view('js/setting_frame_form', $this->data);
			$this->load->view('js/member_list_js', $this->data);
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
    		$this->load->view('js/setting_hive_form', $this->data);
    		$this->load->view('theme/footer_js', $this->data);
    		$this->load->view('theme/footer', $this->data);
    }

    private function newHive($insert = array())
    {
        try {
            $id = $this->beehiveModel->insertData($insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลกล่องรังผึ้งรหัส ' . $id . ' สำเร็จ');
           redirect('setting/hive');
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
           redirect('setting/hive/' . $id);
        }

    }

    private function updateHive($id, $insert = array())
    {
        try {
            $this->beehiveModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลกล่องรังผึ้งรหัส ' . $id . ' สำเร็จ');
           redirect('setting/hive');
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
           redirect('setting/hive/' . $id);
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
			$this->load->view('js/setting_beekeeper', $this->data);
			$this->load->view('js/member_list_js', $this->data);
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
    		$this->load->view('js/setting_frame_form', $this->data);
    		$this->load->view('theme/footer', $this->data);
    }

    public function updateFrame($id, $insert = array())
    {
        try {
            $this->beeframeModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลคอนรหัส ' . $id . ' สำเร็จ');
           redirect('setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
           redirect('setting/hive/' . $id);
        }
    }

    public function newFrame($insert = array())
    {
        try {
            $id = $this->beeframeModel->insertData($insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลคอนผึ้งรหัส ' . $id . ' สำเร็จ');
           redirect('setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
           redirect('setting/hive/' . $id);
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
			$this->load->view('js/formEditQueen', $this->data);
			$this->load->view('js/member_list_js', $this->data);
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
    		$this->load->view('js/formEditQueen', $this->data);
			
    		$this->load->view('theme/footer', $this->data);
    }

    public function newQueen($insert = array())
    {
        try {
            $id = $this->queenModel->insertData($insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลกล่องนางพญารหัส ' . $id . ' สำเร็จ');
           redirect('setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
           redirect('setting/queen/');
        }
    }

    public function updateQueen($id, $insert = array())
    {
        try {
            $this->queenModel->updateData($id, $insert);

            $this->session->set_flashdata('flash.type', 'success');
            $this->session->set_flashdata('flash.message', 'บันทึกข้อมูลนางพญารหัส ' . $id . ' สำเร็จ');
           redirect('setting/hive/' . $insert['beehive_id']);
        } catch (Exception $e) {
            $this->session->set_flashdata('flash.type', 'error');
            $this->session->set_flashdata('flash.message', $e->getMessage());
           redirect('setting/queen');
        }
    }

}
