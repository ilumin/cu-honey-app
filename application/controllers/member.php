<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	 function __construct()
	 {
	   parent::__construct();
	   $this->load->model('member_model','',TRUE);
	 }

	public function login(){
		$this->load->helper(array('form'));
		$this->load->view('theme/nonlogin/header');
		$this->load->view('login');
		$this->load->view('theme/nonlogin/footer');

	 }
	public function logout()
	 {
	   $this->session->unset_userdata('logged_in');
	   session_destroy();
	   redirect('member/login', 'refresh');
	 }
	public function check_login(){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|valid_email|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
		$check = $this->form_validation->run();
		//var_dump($check);
		if($this->form_validation->run() == FALSE)
		{

			 //Field validation failed.  User redirected to login page
			$this->load->view('theme/nonlogin/header');
			$this->load->view('login');
			$this->load->view('theme/nonlogin/footer');

		}else{
			
			redirect('main', 'refresh');
		}

	}



	function check_database($password)
	 {
	   //Field validation succeeded.  Validate against database
	   $username = $this->input->post('username');

	   //query the database
	   $result = $this->member_model->check_login($username, $password);

	   if(is_null($result) == false)
	   {
		$data_session = array('id'=>$result['id'],'name'=>$result['FIRSTNAME'],'email'=>$result['EMAIL'],'type'=>$result['type']);
		$this->session->set_userdata('logged_in', $data_session);

		 return TRUE;
	   }
	   else
	   {

		 $this->form_validation->set_message('check_database', 'Invalid username or password');
		 return false;
	   }
	 }


	public function register(){
		$data = array();
		$this->load->model('gardener_model','',TRUE);

		$province_open = $this->gardener_model->province_near_by();
		$data['province'] = $province_open;

		$this->load->view('theme/nonlogin/header');
		$this->load->view('register_gardener',$data);
		$this->load->view('theme/nonlogin/footer');
	}

	public function register_submit(){
    try {
      $this->load->model('gardener_model','',TRUE);
      $this->gardener_model->insert($_POST);

      // TODO: set user session here

      header("Location: /member/register2");
    } catch (Exception $e) {
      echo "ERROR: " . $e->getMessage() . "<br /><a href='window.history.back();'>back</a>";
    }
	}

	public function register_submit2(){
    try {
      // TODO: check user session here
      $gardener_id = 1;

      $this->load->model('gardener_model','',TRUE);
      $this->gardener_model->insert_garden($_POST, $gardener_id);
      header("Location: /member/register2");
    } catch (Exception $e) {
      echo "ERROR: " . $e->getMessage() . "<br /><a href='window.history.back();'>back</a>";
    }
	}

	public function register2(){
		$data = array();
		$this->load->model('gardener_model','',TRUE);
		$data['flowers'] = $this->gardener_model->get_flower();
		$data['province'] = $this->gardener_model->province_near_by();

		$this->load->view('theme/nonlogin/header');
		$this->load->view('register_gardener2',$data);
		$this->load->view('theme/nonlogin/footer');
	}
	private function get_data()
	{
		return $this->member_model->get_data();
	}
	
	
//MEMBER GARDENER	
	public function profile(){
		$data = $this->get_data();
		
		$user = $this->session->userdata('logged_in');
		$id = $user['id'];
	
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

		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/gardener/left_bar', $data);
		$this->load->view('theme/gardener/nav',$data);
		$this->load->view('gardener_profile', $data);
		$this->load->view('theme/gardener/footer_js', $data);
		$this->load->view('theme/gardener/footer', $data);
	}

	public function blooming(){
		$data = array();
		$data = $this->get_data();
		
		$user = $this->session->userdata('logged_in');
		$id = $user['id'];
		
		$this->load->model('gardener_model','',TRUE);
		$garden = $this->gardener_model->garden_info($id);
		$data['garden'] = $garden;
		
		$this->load->model('gardener_model','',TRUE);
		$data['flowers'] = $this->gardener_model->get_flower();
		//$data['province'] = $this->gardener_model->province_near_by();

		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/gardener/left_bar', $data);
		$this->load->view('theme/gardener/nav',$data);
		$this->load->view('gardener_blooming', $data);
		$this->load->view('theme/gardener/footer_js', $data);
		$this->load->view('theme/gardener/footer', $data);
	}
	public function bloomstatus(){
		$data = array();
		$this->load->model('gardener_model','',TRUE);
		$data['flowers'] = $this->gardener_model->get_flower();
		$data['province'] = $this->gardener_model->province_near_by();

		$data = $this->get_data();
		$this->load->view('theme/header', $data);
		$this->load->view('theme/gardener/left_bar', $data);
		$this->load->view('theme/gardener/nav',$data);
		$this->load->view('gardener_bloomstatus', $data);
		$this->load->view('theme/gardener/footer_js', $data);
		$this->load->view('theme/gardener/footer', $data);
	}

}
