<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
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



		//var_dump($data['gardener_list'] ); exit();

		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('member_detail', $data);
		$this->load->view('theme/footer_js', $data);
		//$this->load->view('js/member_detail_js', $data);
		$this->load->view('theme/footer', $data);

	}
/*
`Garden_GARDEN_ID`
`Flower_FLOWER_ID`
`AMOUNT_HIVE`
`RISK_MIX_HONEY`
`FLOWER_NEARBY_ID`
`GARDEN_TYPE`


array (size=37)
  'plant' =>
    array (size=4)
      0 => string '1' (length=1)
      1 => string '4' (length=1)
      2 => string '5' (length=1)
      3 => string '6' (length=1)
  'area1' => string '200' (length=3)
  'mix1' => string '1' (length=1)
  'mix_plant1' => string '3' (length=1)
  'amount_hive1' => string '40' (length=2)
  'area2' => string '' (length=0)
  'mix_plant2' => string '-' (length=1)
  'amount_hive2' => string '' (length=0)
  'area3' => string '' (length=0)
  'mix_plant3' => string '-' (length=1)
  'amount_hive3' => string '' (length=0)
  'area4' => string '' (length=0)
  'mix4' => string '4' (length=1)
  'mix_plant4' => string '11' (length=2)
  'amount_hive4' => string '28' (length=2)
  'area5' => string '20' (length=2)
  'mix_plant5' => string '-' (length=1)
  'amount_hive5' => string '10' (length=2)
  'area6' => string '30' (length=2)
  'mix_plant6' => string '-' (length=1)
  'amount_hive6' => string '10' (length=2)
  'area7' => string '' (length=0)
  'mix_plant7' => string '-' (length=1)
  'amount_hive7' => string '' (length=0)
  'area8' => string '' (length=0)
  'mix_plant8' => string '-' (length=1)
  'amount_hive8' => string '' (length=0)
  'area9' => string '' (length=0)
  'mix_plant9' => string '-' (length=1)
  'amount_hive9' => string '' (length=0)
  'area10' => string '' (length=0)
  'mix_plant10' => string '-' (length=1)
  'amount_hive10' => string '' (length=0)
  'area11' => string '' (length=0)
  'mix_plant11' => string '-' (length=1)
  'amount_hive11' => string '' (length=0)
  'garden_id' => string '2' (length=1)

*/
	public function member_update_flower(){
		$this->load->helper('form');
		//var_dump($_POST);

		$plant_id= $this->input->post('plant');
		$garden_id= $this->input->post('garden_id');
		for($i=0;$i<count($plant_id);$i++){
			$data_insert['Garden_GARDEN_ID']= $garden_id;
			$data_insert['Flower_FLOWER_ID']= $plant_id[$i];

			$data_insert['AMOUNT_HIVE']= $this->input->post('amount_hive'.$plant_id[$i]);
			if($this->input->post('mix'.$plant_id[$i]) !=null){

				$data_insert['RISK_MIX_HONEY'] = TRUE;
				$data_insert['FLOWER_NEARBY_ID'] = $this->input->post('mix_plant'.$plant_id[$i]);
			}else{
				$data_insert['RISK_MIX_HONEY'] = FALSE;
				$data_insert['FLOWER_NEARBY_ID'] = '';
			}


		}





	}

}
