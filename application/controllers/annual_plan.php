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
		return $this->member_model->get_data();
	
	}
	
	public function index()
	{
		
		//start_Date <= EndDateOfMonth And EndDate >=StartDateOfMonth
		$data = $this->get_data();
		$this->load->model('annual_model');
		$this->load->model('gardener_model');
		
		
		$data['annual_list']=$this->annual_model->annual_info_list();
		
		
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('annual_plan_list', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	public function create()
	{
		
		//start_Date <= EndDateOfMonth And EndDate >=StartDateOfMonth
		$data = $this->get_data();
		$this->load->model('annual_model');
		$this->load->model('gardener_model');
		$data['annual_info']=$this->annual_model->annual_info();
		$data['config']=$this->annual_model->config();
		$flower=$this->gardener_model->get_flower();
		for($i=0; $i<count($flower); $i++){
			$data['flower'][$flower[$i]['FLOWER_ID']]= $flower[$i]['FLOWER_NAME'];
		}
		//$this->load->library('annual_plan_library');
		//var_dump( $this->annual_plan_library->summary_hive_month($data['annual_info'],120));
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('annual_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	public function insert()
	{
		
		$this->load->model('annual_model');
		$annual_info=$this->annual_model->annual_info();
		$config=$this->annual_model->config();
		
		
		$data_insert['ANNUAL_YEAR'] = date('Y', strtotime('+1 year'));
		$data_insert['ANNUAL_CREATED_DATE'] = date('Y-m-d H:i:s');
		$data_insert['CAP_HARVEST_HONEY']= $config['CAP_HARVEST_HONEY'];
		$data_insert['ROUND_HARVEST']= $config['ROUND_HARVEST'];
		$data_insert['BEEHIVE_ON_PROCESS']= $config['CAP_HARVEST_HONEY']*$config['ROUND_HARVEST'];
		
		if(isset($_POST['hive_on_process'])){
			$data_insert['BEEHIVE_ON_PROCESS'] = $_POST['hive_on_process'];
			
		}
		
		$insert_id = $this->annual_model->insert($data_insert);
		
		if($insert_id >0){
			for($i=0;$i<count($annual_info);$i++){	
				$data_insert_item['GARDEN_GARDEN_ID'] = $annual_info[$i]['GARDEN_GARDEN_ID'];
				$data_insert_item['FLOWER_FLOWER_ID'] = $annual_info[$i]['FLOWER_FLOWER_ID'];
				$data_insert_item['AnnualPlan_annual_plan_id']= $insert_id;
				$data_insert_item['BLOOM_START_MONTH']= $annual_info[$i]['BLOOM_START_MONTH'];
				$data_insert_item['BLOOM_END_MONTH']= $annual_info[$i]['BLOOM_END_MONTH'];
				$data_insert_item['AMOUNT_HIVE']= $annual_info[$i]['AMOUNT_HIVE'];
				$data_insert_item['RISK_MIX_HONEY']= $annual_info[$i]['RISK_MIX_HONEY'];
				$data_insert_item['FLOWER_NEARBY_ID']= $annual_info[$i]['FLOWER_NEARBY_ID'];
				
				
				$check_status[$i]=$this->annual_model->insert_item($data_insert_item);
				
				//var_dump($check_status);
			}
		}
		if(in_array(false,$check_status)=== false && $insert_id >0 ){
			redirect('annual_plan/view/'.date('Y', strtotime('+1 year')), 'refresh');
		}
	
		
	}
	
	public function view($year)
	{
		$year =intval($year);
		
		//start_Date <= EndDateOfMonth And EndDate >=StartDateOfMonth
		$data = $this->get_data();
		$this->load->model('annual_model');
		$this->load->model('gardener_model');
		
		$data['annual_info']=$this->annual_model->annual_info_list_db($year);
		$data['config']=$this->annual_model->annual_info_db($year);
		
		$this->load->library('annual_plan_library');
		$data['summary_info']=$this->annual_plan_library->summary_hive_month($data['annual_info'],$data['config']['BEEHIVE_ON_PROCESS']);
		
		$flower=$this->gardener_model->get_flower();
		for($i=0; $i<count($flower); $i++){
			$data['flower'][$flower[$i]['FLOWER_ID']]= $flower[$i]['FLOWER_NAME'];
		}
		//$this->load->library('annual_plan_library');
		//var_dump( $this->annual_plan_library->summary_hive_month($data['annual_info'],120));
		
		$data['year'] = $year;
        $current_year = date('Y', strtotime(TODAY_DATE));
        if ($year < $current_year) {
            $current_month = 13;
        }
        else if ($current_year < $year) {
            $current_month = 0;
        }
        else {
            $current_month = date('n', strtotime(TODAY_DATE));
        }
        $data['current_month'] = $current_month;

		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('annual_plan_view', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/annual_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	
	
	
}
