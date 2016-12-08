<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class operation_plan extends CI_Controller {
	public $data;
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('member_model','',TRUE);
	   $this->load->model('operation_model','',TRUE);
	   
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
	
	public function index()
	{
		$data = $this->get_data();
		$data['period_show'] =$period_show= 60;
		$start_date = '2016-10-01'; //TODAY_DATE
		$next_date= date('Y-m-d',strtotime($start_date.' +'.$period_show.'days'));
		$schedule_info = $this->operation_model->schedule_info($start_date,$next_date);
		$data['start_date'] = $start_date;
		
		$data['schedule_info'] =$schedule_info;
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('operation_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
		
	}
	public function edit()
	{
		$data = $this->get_data();
		$data['period_show'] =$period_show= 60;
		$start_date = TODAY_DATE; //
		$next_date= date('Y-m-d',strtotime($start_date.' +'.$period_show.'days'));
		$schedule_info = $this->operation_model->schedule_info($start_date,$next_date);
		$data['start_date'] = $start_date;
		
		$data['schedule_info'] =$schedule_info;
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('operation_edit', $data);
		$this->load->view('theme/footer_js', $data);
		
		$this->load->view('js/calc_date', $data);
		
		$this->load->view('theme/footer', $data);
		
	}
	
	function harvest($bloom_id=0){
		
		
		$this->load->model('annual_model');
		$this->load->model('blooming_model');
		
		$config = $this->annual_model->config();
		$cap = $config['CAP_HARVEST_HONEY'];
		$round_h = $config['ROUND_HARVEST'];
		$data_insert =$data_insert2= array();
		$transport_info = $this->operation_model->transport_info_byBID($bloom_id);
		$bloom_info = $this->blooming_model->blooming_infoByID($bloom_id);
		$transport_hive_info = $this->operation_model->transporthive_info_byBID($bloom_id);
		$total_hive = count($transport_hive_info);
		$k =0;
		
		
		$diff= date_diff(date_create($transport_info['TRANSPORT_DATE']), date_create($transport_info['RETURN_DATE']));
		$day = $diff->format("%a")+1;
		$firstdate =date("d-m-Y",strtotime($transport_info['TRANSPORT_DATE']));
		
		for($j=1;$j<=floor($day /$round_h); $j++){
			
			$date_insert = date("Y-m-d",strtotime($firstdate." +".($j*3)."days")) ;
			$data_insert['Garden_GARDEN_ID'] = $bloom_info['Garden_GARDEN_ID'];
			$data_insert['Flower_FLOWER_ID'] =$bloom_info['Flower_FLOWER_ID'];
			$data_insert['Blooming_BLOOMING_ID']=$bloom_info['BLOOMING_ID'];
			$data_insert['HARVEST_DATE']=$date_insert;
			$data_insert['HONEY_AMOUNT']=0;
			$data_insert['HARVEST_STATUS']='รอเก็บน้ำผึ้ง';
			
			//$insert_id = $this->operation_model->insert_harvest($data_insert);
			if($total_hive <= $cap && $insert_id >0){
				for($k=0; $k<count($transport_hive_info); $k++){
					$data_insert2['HarvestHoney_HARVEST_ID'] = $insert_id;
					$data_insert2['BeeHive_BEE_HIVE_ID'] = $transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID'];
					$data_insert2['HARVEST_DATE'] = '0000-00-00';
					$data_insert2['STATUS'] = 'รอเก็บน้ำผึ้ง';
				//	$check[$k] = $this->operation_model->insert_harvest_item($data_insert2);
					
				}
			}

		}
		
		
		//TO DO ขาด CASE มากกว่า CAP
		
	}
	
	function harvest_preview($bloom_id=0){
		
		$data = $this->get_data();
		$this->load->model('annual_model');
		$this->load->model('blooming_model');
		$this->load->library('operation_plan_library');
		$config = $this->annual_model->config();
		
		
		$round_h = $config['ROUND_HARVEST'];
		$data_insert =$data_insert2= array();
		$transport_info = $this->operation_model->transport_info_byBID($bloom_id);
		$bloom_info = $this->blooming_model->blooming_infoByID($bloom_id);
		$transport_hive_info = $this->operation_model->transporthive_info_byBID($bloom_id);
		$total_hive = count($transport_hive_info);
		$k =0;
		
		
		$diff= date_diff(date_create($transport_info['TRANSPORT_DATE']), date_create($transport_info['RETURN_DATE']));
		$day = $diff->format("%a")+1;
		$firstdate =date("Y-m-d",strtotime($transport_info['TRANSPORT_DATE']));
		
		$data_manage=array();
		
		$data_manage['CAP_HARVEST_HONEY'] = $config['CAP_HARVEST_HONEY'];
		$data_manage['ROUND_HARVEST'] = $config['ROUND_HARVEST'];
		$data_manage['BEE_HIVE_ID'] =array();//$transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID']; 
		$data_manage['PERIOD'] =$day;//$transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID']; 
		$data_manage['STARTDATE'] =$firstdate;//$transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID']; 
		
		for($k=0; $k<count($transport_hive_info); $k++){
			$data_manage['BEE_HIVE_ID'][$k] = $transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID'];
		}
		
		$data['hive_info'] = $this->operation_plan_library->manage_hive($data_manage);
		$data['manage'] = $data_manage;
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('harvest_preview', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/transfer_detail', $data);
		
		$this->load->view('theme/footer', $data);
		
		/* for($j=1;$j<=floor($day /$round_h); $j++){
			
			$date_insert = date("Y-m-d",strtotime($firstdate." +".($j*3)."days")) ;
			$data_insert['Garden_GARDEN_ID'] = $bloom_info['Garden_GARDEN_ID'];
			$data_insert['Flower_FLOWER_ID'] =$bloom_info['Flower_FLOWER_ID'];
			$data_insert['Blooming_BLOOMING_ID']=$bloom_info['BLOOMING_ID'];
			$data_insert['HARVEST_DATE']=$date_insert;
			$data_insert['HONEY_AMOUNT']=0;
			$data_insert['HARVEST_STATUS']='รอเก็บน้ำผึ้ง';
			
			//$insert_id = $this->operation_model->insert_harvest($data_insert);
			if($total_hive <= $cap && $insert_id >0){
				for($k=0; $k<count($transport_hive_info); $k++){
					$data_insert2['HarvestHoney_HARVEST_ID'] = $insert_id;
					$data_insert2['BeeHive_BEE_HIVE_ID'] = $transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID'];
					$data_insert2['HARVEST_DATE'] = '0000-00-00';
					$data_insert2['STATUS'] = 'รอเก็บน้ำผึ้ง';
				//	$check[$k] = $this->operation_model->insert_harvest_item($data_insert2);
					
				}
			}

		} */
		
		
		//TO DO ขาด CASE มากกว่า CAP
		
	}
	function harvest_test($bloom_id=0){
		
		$hive_array= array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38);
		$round = array(3,4);
		$cap = 7;
		$work_group = array(2);
		$total_hive = count($hive_array);
		$day = 19;
		$start_date = TODAY_DATE;
		
		
		// Case 1: 3 ล้วน  อันนี้ได้แย้ว
		// Case 2: 4 ล้วน อันนี้ได้แย้ว
		
		// Case 3:  3 ก่อน ค่อย 4
		$group_hive = ceil($total_hive /$cap);
		echo 'hive_array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38) <br />';
		echo 'round = array(3,4)  <br />';
		echo 'cap = 40  <br />';
		echo 'date = 19  <br />';
		
		$tmp = 0;
		$count_round = array(0,0);
		for($k=0;$k<count($round);$k++){
			for($i=1;$i<=$group_hive;$i++){
				for($j=1;$j<=floor($day /$round[$k]) ; $j++){
					$start = $i%$round[$k] >0 ?  $i%$round[$k] : $round[$k];
					$tmp =  $start+($j*$round[$k]);
					
					if($tmp <= $day ){
						
						$start_hive = (($i-1)*$cap)+1;
						$end_hive = $i*$cap;
						if($end_hive>$total_hive){
							$end_hive =$total_hive;
						}
						echo $tmp;
						$date_arr = date('Y-m-d',strtotime($start_date." +".$tmp."days "));
						for($l=$start_hive; $l<$end_hive  ;$l++ ){
							$date_show[$round[$k]][$date_arr][] = $hive_array[$l] ;
						}
						
						$count_round[$k]++;
					}
				}
				
			}
		}
		
		var_dump($date_show);
		var_dump($count_round);
		
		
		
		
		
		
		
		
		
		
		
		//TO DO ขาด CASE มากกว่า CAP
		
	}
	
	public function transfer_detail($transport_id){
		$data = $this->get_data();
		$this->load->model('blooming_model');
		if($transport_id>0){
			$transport_info = $this->operation_model->transport_info_byTID($transport_id);
			//var_dump($transport_info);
			if(count($transport_info)>0 ){
				$bloom_id = $transport_info['Blooming_BLOOMING_ID'];
				$garden_id_from = $transport_info['Garden_GARDEN_ID'];
				$flower_id_from = $transport_info['Flower_FLOWER_ID'];
				$transportHive = $this->operation_model->transporthive_info_byBID($bloom_id);
				$data['transport_info'] = $transport_info;
				$data['transport_hive'] =$transportHive;
				$data['garden_info']=$this->blooming_model->get_garden_info($garden_id_from,$flower_id_from);
			}
		}
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('transfer_detail', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/transfer_detail', $data);
		
		$this->load->view('theme/footer', $data);
		
	}
	public function harvest_detail($harvest_id){
		$data = $this->get_data();
		$this->load->model('blooming_model');
		if($harvest_id>0){
			$harvest_info = $this->operation_model->harvest_info_byHID($harvest_id);
			//var_dump($harvest_info);
			if(count($harvest_info)>0 ){
				$bloom_id = $harvest_info['Blooming_BLOOMING_ID'];
				$garden_id_from = $harvest_info['Garden_GARDEN_ID'];
				$flower_id_from = $harvest_info['Flower_FLOWER_ID'];
				$harvestHive = $this->operation_model->harvest_info_byBID($harvest_id);
				$data['harvest_info'] = $harvest_info;
				$data['harvest_hive'] =$harvestHive;
				$data['garden_info']=$this->blooming_model->get_garden_info($garden_id_from,$flower_id_from);
			}
		}
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('harvest_detail', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/transfer_detail', $data);
		$this->load->view('theme/footer', $data);
		
	}
	public function harvest_detail_view($harvest_id){
		$data = $this->get_data();
		$this->load->model('blooming_model');
		if($harvest_id>0){
			$harvest_info = $this->operation_model->harvest_info_byHID($harvest_id);
			//var_dump($harvest_info);
			if(count($harvest_info)>0 ){
				$bloom_id = $harvest_info['Blooming_BLOOMING_ID'];
				$garden_id_from = $harvest_info['Garden_GARDEN_ID'];
				$flower_id_from = $harvest_info['Flower_FLOWER_ID'];
				$harvestHive = $this->operation_model->harvest_info_byBID($harvest_id);
				$data['harvest_info'] = $harvest_info;
				$data['harvest_hive'] =$harvestHive;
				$data['garden_info']=$this->blooming_model->get_garden_info($garden_id_from,$flower_id_from);
			}
		}
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('harvest_detail_view', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/transfer_detail', $data);
		$this->load->view('theme/footer', $data);
		
	}
	
	public function save($method_name){
		if($method_name =='transfer'){
			
			$this->load->model('BeehiveModel');
			
			$id = $this->input->post('transport_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			
			
			$data_update['status'] = 'ขนย้ายเรียบร้อย';
			$data_update['transport_date'] = $start_date;
			$data_update['return_date'] =$end_date;
			
			$check = $this->operation_model->updateTransport($id,$data_update);
			
			
			$hive_arr = $this->input->post('hive_select');
			
			
			if($check == true){
				for($i=0; $i<count($hive_arr); $i++){
					$data_update2['status'] = 'เก็บน้ำผึ้ง';
					$data_update2['start_date'] = $end_date ;
					$data_update2['end_date'] =$start_date ;
					$check2[$i] = $this->BeehiveModel->updateData($hive_arr[$i],$data_update2);
					
				}
			}
			redirect("operation_plan","refresh");
			
			
		}else if($method_name=='harvest'){
			//var_dump($_POST);
			
			$id = $this->input->post('harvest_id');
			$harvest_date = $this->input->post('harvest_date');
			$honey_amount = $this->input->post('honey_amount');
			
			
			
			$data_update['status'] = 'เก็บน้ำผึ้งเรียบร้อย';
			$data_update['transport_date'] = $harvest_date;
			$data_update['honey_amount'] = $honey_amount;
		
			
			 $check = $this->operation_model->updateHarvest($id,$data_update);
			
			
			$hive_arr = $this->input->post('hive_select');
			
			
			if($check == true){
				for($i=0; $i<count($hive_arr); $i++){
					$data_update2['status'] = 'เก็บน้ำผึ้งเรียบร้อย';
					$data_update2['harvest_date'] = $harvest_date ;
					$data_update2['harvest_id'] = $id ;
					$data_update2['bee_hive_id'] = $hive_arr[$i] ;
					 $check2[$i] = $this->operation_model->updateHarvestItem($data_update2);
				
				}
			}
			
			
			redirect("operation_plan","refresh");
		}
		
	}
	
	public function test(){
		$this->load->model('gardener_model');
		$garden = $this->gardener_model->garden_all2();
		
		for($i=0;$i<count($garden);$i++){
			$garden_id = $garden[$i]['GARDEN_ID'];
			for($j=0;$j<count($garden); $j++){
				//$garden_arr[$i][$j]=rand(15,145);
				
				$check_insert[$garden[$i]['GARDEN_ID']][$garden[$j]['GARDEN_ID']] = rand(15,145);

				$data_insert['Garden_GARDEN1_ID'] = $garden[$i]['GARDEN_ID'];
				$data_insert['Garden_GARDEN2_ID'] = $garden[$j]['GARDEN_ID'];
				$data_insert['DISTANCE']=$check_insert[$garden[$i]['GARDEN_ID']][$garden[$j]['GARDEN_ID']];
				
				if(isset($check_insert[$garden[$j]['GARDEN_ID']][$garden[$i]['GARDEN_ID']])){
					
					$data_insert['DISTANCE']=$check_insert[$garden[$j]['GARDEN_ID']][$garden[$i]['GARDEN_ID']];	
					$check_insert[$garden[$i]['GARDEN_ID']][$garden[$j]['GARDEN_ID']]=$check_insert[$garden[$j]['GARDEN_ID']][$garden[$i]['GARDEN_ID']];	
				}
				
				//var_Dump($data_insert); 
				
				echo $this->operation_model->insert_distance($data_insert);
			}
		}
		var_Dump($check_insert); 
		exit();
		
	}
	/* 
	
	public function hive_update(){
		$this->load->model('BeehiveModel');
		$start = 0;
		$end = 190;
		$data= $this->operation_model->hive_avaliable($start,$end);
		$garden_id=11;
		$flower_id=12;
		
		
		
		for($i=0;$i<count($data);$i++){
			$id=$data[$i]['BEE_HIVE_ID'];
			echo $id."-";
			$data_insert['start_date']='0000-00-00';
			$data_insert['end_date']='0000-00-00';
			$chk_insert =  $this->BeehiveModel->updateData($id , $data_insert);
			echo $chk_insert."<br />";
		}
		
	}
	public function transport_hive_insert(){
		
		$start = 51;
		$end = 40;
		$data= $this->operation_model->hive_avaliable($start,$end);
		//$data= $this->operation_model->hive_reserve();
		var_dump($data);
		//exit();
		for($i=0;$i<count($data);$i++){
			$data_insert['Transport_TRANSPORT_ID'] = 4; // TO DO Will be revise to get last insert transport  --34
			$data_insert['BeeHive_BEE_HIVE_ID']=$data[$i]['BEE_HIVE_ID'];
			$chk_insert =  $this->operation_model->insert_hive_transportation_item($data_insert);
			echo $chk_insert."<br />";
		}
		
	}
	
	public function harvest_honey(){
		$bloom = $this->operation_model->blooming_info();
		for($i=0;$i<count($bloom);$i++){
				$diff= date_diff(date_create($bloom[$i]['BLOOMING_STARTDATE']), date_create($bloom[$i]['BLOOMING_ENDDATE']));
				$day = $diff->format("%a")+1;
				$firstdate =date("d-m-Y",strtotime($bloom[$i]['BLOOMING_STARTDATE']." +1days"));
				for($j=1;$j<=($day /3); $j++){
					echo $date_insert = date("d-m-Y",strtotime($firstdate." +".($j*3)."days")) ."<br />";
				}
				
		}		
	}
	
	public function insert_harvest_honey(){
		
		$data= $this->operation_model->hive_avaliable();
		$date_insert=array(	'2016-10-24',
							'2016-10-27',
							'2016-10-30',
							'2016-11-02',
							'2016-11-05',
							'2016-11-08',
							'2016-11-11',
							'2016-11-14',
							'2016-11-17',
							'2016-11-20');
		for($j=0;$j<count($date_insert);$j++){
			$data_insert1['Garden_GARDEN_ID']=3;
			$data_insert1['Flower_FLOWER_ID']=5;
			$data_insert1['Blooming_BLOOMING_ID']=2;
			$data_insert1['HARVEST_DATE']=$date_insert[$j];
			$data_insert1['HONEY_AMOUNT']=0;
			$insert_id=	$this->operation_model->insert_harvest($data_insert1);
			
			
			
			for($i=0;$i<count($data);$i++){
				$data_insert['HarvestHoney_HARVEST_ID'] = $insert_id;
				$data_insert['BeeHive_BEE_HIVE_ID']=$data[$i]['BEE_HIVE_ID'];
				$data_insert['HARVEST_DATE`']=$data_insert1['HARVEST_DATE'];
				$data_insert['STATUS`']='จอง';
				
				$chk_insert =  $this->operation_model->insert_harvest_item($data_insert);
				
			}
		}
	}
	
	public function test(){
		$this->load->model('gardener_model');
		$garden = $this->gardener_model->garden_all();
		
		for($i=0;$i<count($garden);$i++){
			$garden_id = $garden[$i]['GARDEN_ID'];
			for($j=0;$j<count($garden); $j++){
				//$garden_arr[$i][$j]=rand(15,145);
				
				$check_insert[$garden[$i]['GARDEN_ID']][$garden[$j]['GARDEN_ID']] = rand(15,145);

				$data_insert['Garden_GARDEN1_ID'] = $garden[$i]['GARDEN_ID'];
				$data_insert['Garden_GARDEN2_ID'] = $garden[$j]['GARDEN_ID'];
				$data_insert['DISTANCE']=$check_insert[$garden[$i]['GARDEN_ID']][$garden[$j]['GARDEN_ID']];
				
				if(isset($check_insert[$garden[$j]['GARDEN_ID']][$garden[$i]['GARDEN_ID']])){
					
					$data_insert['DISTANCE']=$check_insert[$garden[$j]['GARDEN_ID']][$garden[$i]['GARDEN_ID']];	
					$check_insert[$garden[$i]['GARDEN_ID']][$garden[$j]['GARDEN_ID']]=$check_insert[$garden[$j]['GARDEN_ID']][$garden[$i]['GARDEN_ID']];	
				}
				
				//var_Dump($data_insert); 
				
				echo $this->operation_model->insert_distance($data_insert);
			}
		}
		var_Dump($check_insert); 
		exit();
		
	}*/
//`HARVEST_ID`, `Garden_GARDEN_ID`, `Flower_FLOWER_ID`, `Bloom_BLOOMING_ID`, `HARVEST_DATE`, `HONEY_AMOUNT`
}
