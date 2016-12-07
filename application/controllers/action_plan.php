<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class action_plan extends CI_Controller {
	public $data;
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('action_model','',TRUE);
	   $this->load->model('member_model','',TRUE);
	   $this->current_month =date('m',strtotime(TODAY_DATE));
	   $this->current_year = date('Y',strtotime(TODAY_DATE));
	   
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
	
	public function index($id='0')
	{
		
		//start_Date <= EndDateOfMonth And EndDate >=StartDateOfMonth
		$data = $this->get_data();
		$this->load->model('annual_model');
		$this->load->model('action_model');
		$this->load->library('action_plan_library');
		
		$data_show['HIVE_STATUS'] = $this->action_model->summary_hive();
		$date_calc = $this->action_plan_library->get_nextmonth($this->current_month,$this->current_year,1);
		
		
		$data_show['HIVE_EXPIRED'] =$this->action_model->bee_hive_expired($date_calc['month'],$date_calc['year']);
		
		
		$data['hive_summary']=$this->action_plan_library->summary_hive($data_show);
		
		//echo $data['hive_summary']['TOTAL']; exit();
		
		
		$month_forward= 3;
		$date_calc = $this->action_plan_library->get_nextmonth($this->current_month,$this->current_year,$month_forward);
		
		
		$this->load->library('annual_plan_library');	
		for($i=$this->current_year ; $i<=$date_calc['year'] ;$i++){
			$data['annual_info']=$this->annual_model->annual_info_list_db($i);
			$data['config']=$this->annual_model->annual_info_db($i);
			$summary_hive[$i]=$this->annual_plan_library->summary_hive_month($data['annual_info'],$data['config']['BEEHIVE_ON_PROCESS']);
		}
		
		
		$data['bee_queen_on_process'][0] = $data['hive_summary']['TOTAL']-$data['hive_summary']['เพาะ'];
		for($i=0; $i<4; $i++){
			
			// Past 2 Month	
			$date_calc = $this->action_plan_library->get_nextmonth($this->current_month,$this->current_year,$i-2);
			$data['bee_queen_raise_complete'][$i]=$this->action_model->bee_hive_using('เพาะ',$date_calc['month'],$date_calc['year']);
			$data['bee_queen_raise_complete_m'][$i]=$date_calc['month'];
			$data['bee_queen_raise_complete_y'][$i]=$date_calc['year'];
			
			
			// Past Month	
			$date_calc = $this->action_plan_library->get_nextmonth($this->current_month,$this->current_year,$i-1);
			$data['bee_queen_raise_2month'][$i]=$this->action_model->bee_hive_using('เพาะ',$date_calc['month'],$date_calc['year']);
			$data['bee_queen_raise_2month_m'][$i]=$date_calc['month'];
			$data['bee_queen_raise_2month_y'][$i]=$date_calc['year'];
			
			
			// Current Month	
			$date_calc = $this->action_plan_library->get_nextmonth($this->current_month,$this->current_year,$i);
			$data['bee_hive_using'][$i]=$this->action_model->bee_hive_using('เก็บน้ำผึ้ง',$date_calc['month'],$date_calc['year']);
			$data['bee_hive_using_m'][$i]=$date_calc['month'];
			$data['bee_hive_using_y'][$i]=$date_calc['year'];
			
			$data['bee_annual'][$i]=$summary_hive[$date_calc['year']]['hive_process_month'][$date_calc['month']];
			$data['month_txt'][$i] = date('M-Y',strtotime($date_calc['year']."-".$date_calc['month']."-1"));
			
			$data['bee_queen_raise_1month'][$i]=$this->action_model->bee_hive_using('เพาะ',$date_calc['month'],$date_calc['year']);
			$data['bee_queen_raise_1month_m'][$i]=$date_calc['month'];
			$data['bee_queen_raise_1month_y'][$i]=$date_calc['year'];
			
			
			// Next Month
			$date_calc = $this->action_plan_library->get_nextmonth($this->current_month,$this->current_year,$i+1);
			$data['bee_hive_expired'][$i]=$this->action_model->bee_hive_expired($date_calc['month'],$date_calc['year']);
			$data['bee_con_expired'][$i]=$this->action_model->bee_con_expired($date_calc['month'],$date_calc['year']);
			$data['bee_queen_expired'][$i]=$this->action_model->bee_queen_expired($date_calc['month'],$date_calc['year']);	
			
			$data['bee_hive_expired_m'][$i] = $data['bee_con_expired_m'][$i] = $data['bee_queen_expired_m'][$i] =$date_calc['month'];
			$data['bee_hive_expired_y'][$i] = $data['bee_con_expired_y'][$i] = $data['bee_queen_expired_y'][$i] =$date_calc['year'];
			
			
			if($i>0){
				$data['bee_queen_on_process'][$i]=$data['hive_summary']['TOTAL']-$data['bee_hive_expired'][$i]['AMOUNT'];
			}
			
			$data['need_hive'][$i]=0;
			$need_hive = $data['bee_annual'][$i] - $data['bee_queen_on_process'][$i];
			if($need_hive>0){
				$data['need_hive'][$i] = $need_hive;
			}
			//var_dump($date_calc);
		}
		
		//var_dump($data['bee_queen_expired']);
		
		for($i=0; $i<4;$i++){
			if($i>0){
				if($data['bee_queen_raise_1month'][$i]['AMOUNT'] == false){
					$data['bee_queen_raise_1month'][$i] = $data['bee_queen_expired'][$i-1];
				}

				if($data['bee_queen_raise_2month'][$i]['AMOUNT'] == false){
					$data['bee_queen_raise_2month'][$i] = $data['bee_queen_raise_1month'][$i-1];
					
				}
				if($data['bee_queen_raise_complete'][$i]['AMOUNT'] == false){
					$data['bee_queen_raise_complete'][$i] = $data['bee_queen_raise_2month'][$i-1];
				}
			}
			
		}
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		if($id==0){
			$this->load->view('action_plan', $data);
		}else{
			$this->load->view('action_plan2', $data);
		}
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	public function bee_hive_expired($year, $month)
    {
        $form_title = 'งานเปลี่ยนกล่องรังผึ้งใหม่ภายในเดือนนี้ <br/> (หมดอายุเดือนถัดไป)';
        $form_url = base_url() . 'action_plan/save/bee_hive_expired/';
        $items = $this->action_model->bee_hive_expired_list($month, $year);
        $view = 'action_form';

        $this->displayActionForm($form_title, $form_url, $items, $view);
    }

	public function bee_con_expired($year, $month)
    {
        $form_title = 'งานเปลี่ยนคอนใหม่ภายในเดือนนี้ <br/> (หมดอายุเดือนถัดไป)';
        $form_url = base_url() . 'action_plan/save/bee_con_expired/';
        $items = $this->action_model->bee_con_expired_list($month, $year);

        $view = 'action_form2';

        $this->displayActionForm($form_title, $form_url, $items, $view);
    }

	public function bee_queen_expired($year, $month)
    {
        $form_title = 'งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้ <br/> (หมดอายุเดือนถัดไป)';
        $form_url = base_url() . 'action_plan/save/bee_queen_expired/';
        $items = $this->action_model->bee_queen_expired_list($month, $year);
        $view = 'action_form2';

        $this->displayActionForm($form_title, $form_url, $items, $view);
    }

	public function bee_queen_raise($year, $month)
    {
        $current_month = date('n', strtotime(TODAY_DATE));

        if ($current_month < $month) {
            throw new Exception("Invalid param");
        }

        $form_title = 'รังที่กำลังเพาะ (' . ($current_month - $month + 1) . ' เดือน)';
        $form_url = base_url() . 'action_plan/save/bee_queen_raise/';
        $items = $this->action_model->bee_queen_raise("เพาะ", $month, $year);
        $view = 'action_list1';

        $this->displayActionForm($form_title, $form_url, $items, $view);
    }

	public function bee_queen_ready($year, $month)
    {
        $form_title = 'รังที่เพาะเรียบร้อย';
        $form_url = base_url() . 'action_plan/save/bee_queen_ready/';
        $items = $this->action_model->bee_queen_raise("ว่าง", $month, $year);
        $view = 'action_list1';

        $this->displayActionForm($form_title, $form_url, $items, $view);
    }

	public function bee_hive_using($year, $month)
    {
        $form_title = 'รังผึ้งที่เก็บน้ำผึ้งอยู่';
        $form_url = base_url() . 'action_plan/bee_queen_ready/';
        $items = $this->action_model->bee_queen_raise("เก็บน้ำผึ้ง", $month, $year);
        $view = 'action_list1';

        $this->displayActionForm($form_title, $form_url, $items, $view);
    }

    private function displayActionForm($title, $url, $checkboxItem, $view)
    {
        $data = $this->get_data();
        $data['form_url'] = $url;
        $data['form_title'] = $title;
        $data['items'] = $checkboxItem;

        $this->load->view('theme/header', $data);
        $this->load->view('theme/left_bar', $data);
        $this->load->view('theme/nav',$data);

        $this->load->view($view, $data);

        $this->load->view('theme/footer_js', $data);
        $this->load->view('js/form_action', $data);
        $this->load->view('theme/footer', $data);
    }
	
	public function save($module_name){
		//var_dump($_POST);
		$this->load->model('annual_model');
		$config =$this->annual_model->config();
		if($module_name == 'bee_hive_expired'){
			//var_dump($config); 
			$expired_date = date('Y-m-d',strtotime($_POST['action_date']." +".$config['BEEHIVE_AGE']."years"));
			$hive_id = $_POST['selected'];
			
			
			$items = $this->action_model->bee_hive_expired_save($hive_id ,$expired_date);
			
			if($items != false){
				redirect('action_plan','refresh');
				
			}
		}
		if($module_name == 'bee_con_expired'){
			$con_id = $_POST['selected'];
			$expired_date = date('Y-m-d',strtotime($_POST['action_date']." +".$config['BEEFRAME_AGE']."years"));
			$items = $this->action_model->bee_con_expired_save($con_id ,$expired_date);
			
			if($items != false){
				redirect('action_plan','refresh');
				
			}
		}
		if($module_name == 'bee_queen_expired'){
			$beehive_list = $_POST['selected'];
			//queen
			$expired_date = '0000-00-00';
			$items1 = $this->action_model->bee_queen_expired_save($beehive_list ,$expired_date);
			//Beehive
			
			$start_date =$_POST['action_date'];
			$end_date =date('Y-m-d',strtotime($_POST['action_date']." +".$config['PERIOD_RAISE']));
			$items2 = $this->action_model->bee_hive_raise_save($beehive_list ,$start_date,$end_date);
			
			
			
			
			if($items1 != false && $items2 != false){
				redirect('action_plan','refresh');
				
			}
		}
	}
	
}
