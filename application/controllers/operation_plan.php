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
		$data['period_show'] =$period_show= 6;
		$next_date= date('Y-m-d',strtotime(TODAY_DATE.' +'.$period_show.'days'));
		$schedule_info = $this->operation_model->schedule_info(TODAY_DATE,$next_date);
		
		
		$data['schedule_info'] =$schedule_info;
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('operation_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
		
	}
	
	public function bloom($id=0){
		$data = $this->get_data();
		
		$data['blooming_info'] = $this->operation_model->blooming_info();
		$data['garden_id'] = $id= intval($id);
		if($id>0){
			$data['public_park'] = $this->operation_model->get_hive_public_park_byID($id);
			$data['member_park'] = $this->operation_model->get_hive_member_park_byID($id);
			$data['blooming_select'] = $this->operation_model->blooming_info($id);
		}else{
			$data['public_park'] = $this->operation_model->get_hive_public_park();
			
			$data['member_park'] = $this->operation_model->get_hive_member_park($data['blooming_info']);
			
		}
		//var_dump($data['public_park']);
		
		
		
		
		//var_dump($data['blooming_info']);
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('blooming', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	
	function bloom_save(){
		//var_dump($_POST);
		
		$this->load->model('BeehiveModel');
		//from garden to blooming id
		$garden_id = $this->input->post('garden_id_all');
		$flower_id = $this->input->post('flower_id_all');
		$blooming_id = $this->input->post('bloom_id');

		if($garden_id!="" && $blooming_id !=""){
		
			$garden_id_arr= explode("|",$garden_id);
			$flower_id_arr= explode("|",$flower_id);
			
			
			$blooming_info = $this->operation_model->blooming_info($blooming_id);
			
			for($i=0; $i<count($garden_id_arr); $i++){
				
				$amount_hive = $this->input->post('amount'.$garden_id_arr[$i]);
				$choose_date = $this->input->post('choose_date'.$garden_id_arr[$i]);
			
				if($amount_hive>0){
					
					
					$data_insert['TRANSPORT_DATE'] = $choose_date;
					$data_insert['RETURN_DATE'] = $blooming_info['BLOOMING_ENDDATE'];
					$data_insert['STATUS'] = 'รอขนย้าย';
					$data_insert['FLOWER_FLOWER_ID'] = $flower_id_arr[$i];
					$data_insert['GARDEN_GARDEN_ID'] = $garden_id_arr[$i];
					$data_insert['Blooming_BLOOMING_ID'] = $blooming_id;
					$insert_id = $this->operation_model->insert_hive_transportation($data_insert);
		
					//วันที่ Expire Date DESC
					$hive_info = $this->operation_model->hive_id_ByGardenID($garden_id_arr[$i],$flower_id_arr[$i],$amount_hive);
					
					if($insert_id >0){
						for($j=0;$j<count($hive_info );$j++){
							$data_insert2['Transport_TRANSPORT_ID'] = $insert_id ; // TO DO Will be revise to get last insert transport  --34
							$data_insert2['BeeHive_BEE_HIVE_ID']=$hive_info[$j]['BEE_HIVE_ID'];
							
							$chk_insert2[$j] =  $this->operation_model->insert_hive_transportation_item($data_insert2);
							//echo $chk_insert2[$j];
						}
					}	
				}
			}
			
			if(in_array(false , $chk_insert2) == false){
				$data_bloom['blooming_status'] = 'ยืนยัน';
				//echo 'confirm';
				$check_bloom = $this->operation_model->updateBloom($blooming_id,$data_bloom );
				if($check_bloom  !=false){
					redirect('operation_plan/harvest/'.$blooming_id, 'refresh');	
				}

			}else{
				echo "ERROR:cannot update data complete";
				
			}
		}
		
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
		
		//
		/* 
		
		
		if(ceil($total_hive / $cap) > $round_h){
			$round_h = $round_h+1;
		} */
		
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
			
			$insert_id = $this->operation_model->insert_harvest($data_insert);
			if($total_hive <= $cap && $insert_id >0){
				for($k=0; $k<count($transport_hive_info); $k++){
					$data_insert2['HarvestHoney_HARVEST_ID'] = $insert_id;
					$data_insert2['BeeHive_BEE_HIVE_ID'] = $transport_hive_info[$k]['BEEHIVE_BEE_HIVE_ID'];
					$data_insert2['HARVEST_DATE'] = '0000-00-00';
					$data_insert2['STATUS'] = 'รอเก็บน้ำผึ้ง';
					$check[$k] = $this->operation_model->insert_harvest_item($data_insert2);
					
				}
			}

		}
		
		if($k==count($transport_hive_info)){
			redirect('operation_plan/','refresh');	
			
		}
		//TO DO ขาด CASE มากกว่า CAP
		
	}
	public function transfer_detail($transport_id){
		$data = $this->get_data();
		if($transport_id>0){
			$transport_info = $this->operation_model->transport_info_byTID($transport_id);
		//	var_dump($transport_info);
			if(count($transport_info)>0 ){
				$bloom_id = $transport_info['Blooming_BLOOMING_ID'];
				$transportHive = $this->operation_model->transporthive_info_byBID($bloom_id);
				$data['transport_info'] = $transport_info;
				$data['transport_hive'] =$transportHive;
			}
		}
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('transfer_detail', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
		
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
