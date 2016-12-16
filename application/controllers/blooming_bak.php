<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class blooming extends CI_Controller {
	public $data;
	function __construct()
	 {
	   parent::__construct();
		$this->load->model('member_model','',TRUE);
		$this->load->model('operation_model','',TRUE);
		$this->load->model('blooming_model','',TRUE);
		$this->load->model('gardener_model','',TRUE);
		$this->load->model('BeehiveModel','',TRUE);
		$this->load->model('transport_model','',TRUE);
		$this->load->model('harvest_model','',TRUE);
	   
	 }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	private function get_data()
	{
		return $this->member_model->get_data();
	}
	
	
	
	public function index($id=0){
		
		$data = $this->get_data();

		$data['public_park'] = array();
		$data['member_park'] = array();
		$data['blooming_id'] = 0;
		$data['blooming_info'] = $this->blooming_model->blooming_info();
		$data['garden_id'] = $id= intval($id);
		
		$flower = $this->gardener_model->get_flower();
		
		for($i=0;$i<count($flower);$i++){
			$data['flowers'][ $flower[$i]['FLOWER_ID']] = $flower[$i]['FLOWER_NAME'];	
		}
		
		if($id>0){
			$data['blooming_id'] = $id;
			$data['public_park'] = $this->blooming_model->get_public_hive_avaliable($id);
			
			//$data['member_park'] = $this->operation_model->get_hive_member_park_byID($id);
			$data['blooming_select'] = $this->blooming_model->blooming_info($id);
		}
		//var_dump($data['public_park']);
		
		
		
		
		//var_dump($data['blooming_info']);
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('blooming', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/bloom_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	
	function bloom_save(){
		//var_dump($_POST);
		
		
		//from garden to blooming id
		$garden_id = $this->input->post('garden_id_all');
		$flower_id = $this->input->post('flower_id_all');
		$blooming_id = $this->input->post('bloom_id');

		if($garden_id!="" && $blooming_id !=""){
		
			$garden_id_arr= explode("|",$garden_id);
			$flower_id_arr= explode("|",$flower_id);
			
			
			$blooming_info = $this->blooming_model->blooming_info($blooming_id);
			
			for($i=0; $i<count($garden_id_arr); $i++){
				
				$amount_hive = $this->input->post('amount'.$garden_id_arr[$i]);
				$choose_date = $this->input->post('choose_date'.$garden_id_arr[$i]);
			
				if($amount_hive>0){
					
					
					$data_h['Garden_GARDEN_ID'] = $blooming_info['GARDEN_ID'] ; 
					$data_h['Flower_FLOWER_ID']=$blooming_info['FLOWER_FLOWER_ID'];
					$data_h['Blooming_BLOOMING_ID']= $blooming_id;
					$data_h['HARVEST_STATUS'] ='รอเก็บน้ำผึ้ง';
					$data_h['HONEY_AMOUNT'] ='0';
					$data_h['HARVEST_STARTDATE'] =$choose_date;
					$data_h['HARVEST_ENDDATE'] = $blooming_info['BLOOMING_ENDDATE'];
					$insert_id2 =  $this->harvest_model->insert($data_h);
					
					if($insert_id2 >0){
						for($j=0;$j<count($hive_info );$j++){
							$data_insert3['HarvestHoney_HARVEST_ID'] = $insert_id2  ; // TO DO Will be revise to get last insert transport  --34
							$data_insert3['BeeHive_BEE_HIVE_ID']=$hive_info[$j]['BEE_HIVE_ID'];
							$data_insert3['STATUS']='รอเก็บน้ำผึ้ง';
							$data_insert3['LASTED_HARVEST_DATE']='0000-00-00';
							$data_insert3['NO_HARVEST']='0';
							$data_insert3['PERCENT_HARVEST']='0';
							
							$chk_insert3[$j] =  $this->harvest_model->insert_item($data_insert3);
							//echo $chk_insert3[$j];
						}
					}
					
					
					
					//INSERT TRANSPORT 
					$data_insert['TRANSPORT_DATE'] = $choose_date;
					
					$data_insert['STATUS'] = 'รอขนส่ง';
					$data_insert['FLOWER_FLOWER_ID'] = $flower_id_arr[$i];
					$data_insert['GARDEN_GARDEN_ID'] = $garden_id_arr[$i];
					$data_insert['Blooming_BLOOMING_ID'] = $blooming_id;
					$data_insert['HarvestHoney_HARVEST_ID'] = $insert_id2;
					$insert_id = $this->transport_model->insert($data_insert);
		
					//วันที่ Expire Date DESC
					//INSERT  TRANSPORT DETAIL
					$hive_info = $this->operation_model->hive_id_ByGardenID($garden_id_arr[$i],$flower_id_arr[$i],$amount_hive);
					
					if($insert_id >0){
						for($j=0;$j<count($hive_info );$j++){
							$data_insert2['Transport_TRANSPORT_ID'] = $insert_id ; // TO DO Will be revise to get last insert transport  --34
							$data_insert2['BeeHive_BEE_HIVE_ID']=$hive_info[$j]['BEE_HIVE_ID'];
							$data_insert2['STATUS']='รอขนส่ง';
							
							$chk_insert2[$j] =  $this->transport_model->insert_hive($data_insert2);
							
							//echo $chk_insert2[$j];
						}
					}
					
					//var_dump($blooming_info);

					
				}
			}	
			if((in_array(false , $chk_insert2) == false)&& (in_array(false , $chk_insert3) == false)){
				$data_bloom['blooming_status'] = 'ยืนยัน';
				//echo 'confirm';
				$check_bloom = $this->blooming_model->update($blooming_id,$data_bloom );
				if($check_bloom  !=false){
					redirect('operation_plan', 'refresh');	
				}

			}else{
				echo "ERROR:cannot update data complete";
				
			}
		}
		
	}
	
	/* public function addtransport(){
		
		$hive_array = array(40,41,42,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,62,63,64,65,66,67,68,69,70,71,77,79,80,134,136,137,138,139);

		
		
		$this->load->model('operation_model');
		for($i=0;$i<count($hive_array);$i++){
			$data['Transport_TRANSPORT_ID'] = 10;
			$data['BeeHive_BEE_HIVE_ID'] = $hive_array[$i];
			$data['STATUS'] = 'ขนส่งเรียบร้อย';
			$this->operation_model->insert_hive_transportation_item( $data);
		}
	}
	
	public function updatebeehive(){
		$this->load->model('beehiveModel');
		
		$hive_array = array(38,39,40,41,42,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,62,63,64,65,66,67,68,69,70,71,77,79,80,134,136,137,138,139);
		$data['start_date'] ='2016-10-01';
		$data['end_date'] ='2016-10-20';
		$data['GARDEN_GARDEN_ID'] ='11';
		for($i=0;$i<count($hive_array);$i++){
			//echo $i;
			echo $this->beehiveModel->updateData($hive_array[$i],$data);
		}
		
		
		
	} 
	
	public function addharvestItem(){
		//`HarvestHoney_HARVEST_ID`, `BeeHive_BEE_HIVE_ID`, `STATUS`, `LASTED_HARVEST_DATE`, `NO_HARVEST`, `PERCENT_HARVEST`
		$this->load->model('beehiveModel');
		
		$hive_array = array(40,41,42,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,62,63,64,65,66,67,68,69,70,71,77,79,80,134,136,137,138,139);
		
		for($i=0;$i<count($hive_array);$i++){
			$data['HarvestHoney_HARVEST_ID'] ='194';
			$data['BeeHive_BEE_HIVE_ID'] =$hive_array[$i];
			$data['STATUS'] ='รอเก็บน้ำผึ้ง';
			$data['LASTED_HARVEST_DATE'] ='0000-00-00';
			$data['NO_HARVEST'] ='0';
			$data['PERCENT_HARVEST'] ='0';
			echo $this->operation_model->insert_harvest_item($data);
		}
		
		
		
	} 
	
		private function randvalue($date){
		
		$data['2016-10-04'] = rand(5,12); 
		$data['2016-10-07'] = rand(12,24); 
		$data['2016-10-10'] = rand(24,30); 
		$data['2016-10-13'] = rand(30,45); 
		$data['2016-10-16'] = rand(12,24); 
		$data['2016-10-19'] = rand(5,12); 
		return ($data[$date]/10);
		
	}
	
	public function addHarvestAction(){
		$this->load->model('operation_model');
		$hive_array = array();
		$range = 20;
		$date_arr = array('2016-10-04','2016-10-07','2016-10-10','2016-10-13','2016-10-16','2016-10-19');
		
		for($i=0;$i<count($date_arr);$i++){
			$data['HARVEST_DATE'] = $date_arr[$i];
			for($j=1;$j<=39;$j++){
				$data['HONEY_AMOUNT'] = $this->randvalue($date_arr[$i]);
				$data['Harvesthoneyitem_ID'] = $j;
				echo $this->operation_model->insert_hive_harvestitemdetail($data);
			}
		}
		
		
		
	}
	public function getdatacal(){
		
		$this->load->model('operation_model');
		for($i=1; $i<=39;$i++){
			$id=$i;
			$honey_amount= array();
			$data = $this->operation_model->get_harvest_detail($id);
			for($j=0;$j<count($data);$j++){
				$honey_amount[$j] = $data[$j]['HONEY_AMOUNT'];
			}
			$amount_harvest = count($data);
			$last_id = count($data)-1;
			$max_val = max($honey_amount);
			$last_val = $honey_amount[$last_id];
			$percent_diff = number_format((abs($last_val-$max_val)/$max_val*100),2);
			//echo "id:".$i." --last_val & max =".$last_val."&".$max_val."=".$percent_diff."<br />";
			
			$data['NO_HARVEST'] =$amount_harvest ;
			$data['PERCENT_HARVEST'] = $percent_diff;
	
			
			$this->operation_model->updateHarvestItem( $i,$data);
		}
	}
	public function getdatacal(){
		
		$this->load->model('operation_model');
		for($i=1; $i<=39;$i++){
			$id=$i;
			$honey_amount= array();
			$data = $this->operation_model->get_harvest_detail($id);
			for($j=0;$j<count($data);$j++){
				$honey_amount[$j] = $data[$j]['HONEY_AMOUNT'];
				$date_harvest[$j] = $data[$j]['HARVEST_DATE'];
			}
			$amount_harvest = count($data);
			$last_id = count($data)-1;
			$max_val = max($honey_amount);
			$max_date = max($date_harvest);
			$last_val = $honey_amount[$last_id];
			$percent_diff = number_format((abs($last_val-$max_val)/$max_val*100),2);
			//echo "id:".$i." --last_val & max =".$last_val."&".$max_val."=".$percent_diff."<br />";
			
			$data_update['NO_HARVEST'] =$amount_harvest ;
			$data_update['LASTED_HARVEST_DATE'] = $max_date;
	//var_dump($data);
			
			$this->operation_model->updateHarvestItem( $i,$data_update);
		}
	}
	
	
	public function updateDateItem(){
		//`HarvestHoney_HARVEST_ID`, `BeeHive_BEE_HIVE_ID`, `STATUS`, `LASTED_HARVEST_DATE`, `NO_HARVEST`, `PERCENT_HARVEST`
		$this->load->model('beehiveModel');
		$this->load->model('harvest_model');
		
		$harvesthoneyitem_id = array(
40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120
);
		
		for($i=0;$i<count($harvesthoneyitem_id);$i++){
			$data['LASTED_HARVEST_DATE'] = '2016-10-12';
			
			echo $this->harvest_model->updateItem($harvesthoneyitem_id[$i] ,$data);
		}
		
		
		
	} 
	public function updateDateDetail(){
		//`HarvestHoney_HARVEST_ID`, `BeeHive_BEE_HIVE_ID`, `STATUS`, `LASTED_HARVEST_DATE`, `NO_HARVEST`, `PERCENT_HARVEST`
		$this->load->model('beehiveModel');
		$this->load->model('harvest_model');
		
		$harvesthoneyitem_id = array(
40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120
);
		
		for($i=0;$i<count($harvesthoneyitem_id);$i++){
			$data['HARVEST_DATE'] = '2016-10-12';
			
			echo $this->harvest_model->updateDetail_ByHIID($harvesthoneyitem_id[$i] ,$data);
		}
		
		
		
	} 
	*/
	
	
}
