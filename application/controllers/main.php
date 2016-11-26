<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main extends CI_Controller {
	public $data;
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('member_model','',TRUE);
	   
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
		$email ="yippadedoda@gmail.com";
		$password = "1234";
		$this->load->model('beekeeper_model');
		$bee_keeper_id=1;
		$bee_keeper_info = $this->beekeeper_model->check_login($email,md5($password));
		
		if( is_null($bee_keeper_info) == false){
			$data['account_info'] = array('account_id'=>$bee_keeper_info['BEE_KEEPER_ID'], 'account_name' => $bee_keeper_info['FIRSTNAME'] , 'type'=>'admin','account_picture'=> base_url().'img/account/2.png');
			//var_dump($bee_keeper_info);
		}
	
		
		//$data['account_info'] = array('account_id'=>2, 'account_name' => 'Admin' , 'type'=>'admin','account_picture'=> base_url().'img/account/2.png');
		$data['honey_sum'] = array('total_hive'=>168, 'onprogress_hive'=>120, 'cure_hive'=>48,'expired_hive'=>10);

		$data['get_notification'][0] = array('account_id'=>1, 'account_name' => 'ลุงสร' , 'type'=>'orchardmen','account_picture'=> base_url().'img/account/1.png','status'=>'ได้แจ้งดอกไม้บานวันที่ 15/11/2016');
		$data['get_notification'][1] = array('account_id'=>2, 'account_name' => 'Admin' , 'type'=>'admin','account_picture'=> base_url().'img/account/2.png','status'=>'ตรวจสอบดอกไม้บาน ');
		$data['get_notification'][2] = array('account_id'=>3, 'account_name' => 'นายพงษ์' , 'type'=>'orchardmen','account_picture'=> base_url().'img/account/3.png','status'=>'ยังไม่มีการแจ้งดอกไม้บาน');
		$data['get_notification'][3] = array('account_id'=>4, 'account_name' => 'สมศรี' , 'type'=>'orchardmen','account_picture'=> base_url().'img/account/4.png','status'=>'ยังไม่มีการแจ้งดอกไม้บาน');

		$data['todo'] = array('ลำไยสวนใหญ่  ยังไม่ได้ทำการแจ้งดอกไม้บาน','สวนศิลสุนทร  ยังไม่ได้ทำการแจ้งดอกไม้บาน');
		
	
	return $data;
	}
	public function index()
	{
		//$data = array('data','123');
	
		
		//$this->load->view('');
		//$this->load->view('welcome_message');
		$data = $this->get_data();
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('main_theme', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	public function logout()
	 {
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   redirect('member/login', 'refresh');
	 }
	public function member_list(){
		$data = $this->get_data();
		$this->load->helper(array('form'));
		$this->load->model('gardener_model','',TRUE);
		$data['gardener_list'] = $this->gardener_model->gardener_list();
		//var_dump($data['gardener_list'] ); exit();
	
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('member_list', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/member_list_js', $data);
		$this->load->view('theme/footer', $data);
	 
	}
	public function member_detail($id){
		$data = $this->get_data();
		$this->load->helper(array('form'));
		//get member info from gardener
		$this->load->model('gardener_model','',TRUE);
		$data['gardener_info'] = $this->gardener_model->gardener_info($id);
		//get flower table 
		$flower = $this->gardener_model->get_flower();
		$data['flower'] = $flower;
		//get garden info
		$garden = $this->gardener_model->garden_info($id);
		$data['garden'] = $garden;
		
		//get flower in garden info
		$gardenflower = $this->gardener_model->gardenflower_info($garden['GARDEN_ID']);
		$data['gardenflower'] = $gardenflower;
		
		
		
		
		//var_dump($data['gardenflower']);
		
		//var_dump($data['gardener_list'] ); exit();
	
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('member_detail', $data);
		$this->load->view('theme/footer_js', $data);
		//$this->load->view('js/member_detail_js', $data);
		$this->load->view('theme/footer', $data);
	 
	}

	public function member_update_flower(){
		$this->load->helper('form');
		$this->load->model('gardener_model');
		//var_dump($_POST);
		
		$plant_id= $this->input->post('plant');
		$garden_id= $this->input->post('garden_id');
		$gardener_id= $this->input->post('gardener_id');
		//delete all flower
		$chk_del = $this->gardener_model->garderflower_delete($garden_id);
		
		$chk_insert =array();
		for($i=0;$i<count($plant_id);$i++){
			$data_insert['Garden_GARDEN_ID']= $garden_id;
			$data_insert['Flower_FLOWER_ID']= $plant_id[$i];
			
			$data_insert['AMOUNT_HIVE']= $this->input->post('amount_hive'.$plant_id[$i]);  
			$data_insert['AREA']= $this->input->post('area'.$plant_id[$i]);  
			
			if($this->input->post('mix'.$plant_id[$i]) !=null){
				
				$data_insert['RISK_MIX_HONEY'] = TRUE;
				$data_insert['FLOWER_NEARBY_ID'] = $this->input->post('mix_plant'.$plant_id[$i]);  
				
			}else{
				$data_insert['RISK_MIX_HONEY'] = FALSE;
				$data_insert['FLOWER_NEARBY_ID'] = '';  
			}
			
			
			
			$chk_insert[$i] = $this->gardener_model->gardenflower_insert($data_insert);
			//echo "<br/>insert".$chk_insert[$i];
		}
		
		if(in_array(false,$chk_insert)=== false && $chk_del ==true ){
			redirect('main/member_detail/'.$gardener_id, 'refresh');
		}
	}
	
	public function annual_plan(){
		$this->load->helper('form');
		$this->load->model('gardener_model');
		$data = $this->get_data();
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('annual_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/annual_plan', $data);
		$this->load->view('theme/footer', $data);
		
	}
}
