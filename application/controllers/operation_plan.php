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
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('operation_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
		
	}
	
	public function bloom(){
		$data = $this->get_data();
		
		
		$data['blooming_info'] = $this->operation_model->blooming_info();
		
		//var_dump($data['blooming_info']);
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('blooming', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	public function transport_hive_insert(){
		
		$data= $this->operation_model->hive_avaliable();
		var_dump($data);
	
		for($i=0;$i<count($data);$i++){
			$data_insert['Transport_TRANSPORT_ID'] = 1; // TO DO Will be revise to get last insert transport
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
	
}
