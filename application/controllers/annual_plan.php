<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class annual_plan extends CI_Controller {
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
		$this->load->model('gardener_model');
	
		
		$data = $this->get_data();
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('annual_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	
	
}
