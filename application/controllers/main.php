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
	
	public function index()
	{
		//$data = array('data','123');
		$user = $this->session->userdata('logged_in');
		if($user['type'] != "beekeeper"){
			redirect('member/profile', 'refresh');	
		}
		//$this->load->view('');
		//$this->load->view('welcome_message');
		$data = $this->member_model->get_data();
		$this->load->model('action_model');
		$data_show['HIVE_STATUS'] = $this->action_model->summary_hive();
		$data_show['HIVE_EXPIRED'] =$this->action_model->bee_hive_expired(11,2016);
		
		$this->load->library('action_plan_library');
		$data['hive_summary']=$this->action_plan_library->summary_hive($data_show);
		
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('main_theme', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}

	
	public function member_list(){
		$data = $this->member_model->get_data();
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
		$data = $this->member_model->get_data();
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
	public function distancegarden($id){
		$data = $this->member_model->get_data();
		$this->load->helper(array('form'));
		//get member info from gardener
		$this->load->model('gardener_model','',TRUE);
		$data['gardener_info'] = $this->gardener_model->gardener_info($id);
		//get flower table
		$flower = $this->gardener_model->get_flower();
		$data['flower'] = $flower;
		//get garden info
		$garden_info = $this->gardener_model->garden_info($id);
		$data['garden_info'] = $garden_info;
		//var_dump($garden_info);

		$data['garden'] = $this->gardener_model->garden_all();
		//var_dump($data['gardenflower']);
		$data['distance'] = $this->gardener_model->distance($data['garden_info']['GARDEN_ID']);
		//var_dump($data['gardener_list'] ); exit();

		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('distancegarden', $data);
		$this->load->view('theme/footer_js', $data);
		//$this->load->view('js/member_detail_js', $data);
		$this->load->view('theme/footer', $data);

	}

	
	public function distance_save(){
		$garden_id = $this->input->post('garden_id');
		$gardener_id = $this->input->post('gardener_id');
		$garden_m = $this->input->post('garden_match');
		
		if($garden_id !=''){
			
			$this->load->model('operation_model');
			
			$garden = explode('|',$garden_m);
		
			for($i=0;$i<count($garden);$i++){
				//echo $distance = $this->input->post('distance_'.$garden_match[$i])."<br />";
				//$garden_arr[$i][$j]=rand(15,145);
				
				$check_insert[$garden[$i]][$garden_id] = $this->input->post('distance_'.$garden[$i]);
	
				$data_insert['Garden_GARDEN1_ID'] = $garden[$i];
				$data_insert['Garden_GARDEN2_ID'] = $garden_id;
				$data_insert['DISTANCE']=$check_insert[$garden[$i]][$garden_id];
				//var_dump($data_insert);
				$check['FIRST'][$i] = $this->operation_model->update_distance($data_insert);
				if($check['FIRST'][$i] == true){
					$data_insert['Garden_GARDEN1_ID'] = $garden_id;
					$data_insert['Garden_GARDEN2_ID'] = $garden[$i]; 
					$data_insert['DISTANCE']=$check_insert[$garden[$i]][$garden_id];
					//var_dump($data_insert);
					$check['SECOND'][$i] =$this->operation_model->update_distance($data_insert);
				}
			}
			if(count($check['SECOND']) == count($garden)){
				if(in_array(false,$check['SECOND'])=== false  && in_array(false,$check['FIRST'])=== false){
					redirect('main/distancegarden/'.$gardener_id);
				}
			}
		}
		
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
			$data_update['status'] = 'APPROVE' ;
			$check = $this->gardener_model->update_garden_member($garden_id, $data_update);
			if($check != false) {
				redirect('main/member_detail/'.$gardener_id, 'refresh');
			}
		}
	}

}
