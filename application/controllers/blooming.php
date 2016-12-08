<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class blooming extends CI_Controller {
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
	
	
	
	public function index($id=0){
		$data = $this->get_data();
		$data['public_park'] = array();
		$data['member_park'] = array();
		
		$data['blooming_info'] = $this->operation_model->blooming_info();
		$data['garden_id'] = $id= intval($id);
		if($id>0){
			$data['public_park'] = $this->operation_model->get_hive_public_park_byID($id);
			$data['member_park'] = $this->operation_model->get_hive_member_park_byID($id);
			$data['blooming_select'] = $this->operation_model->blooming_info($id);
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
	
	
}
