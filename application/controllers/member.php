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
		//var_dump($result);
	   if(is_null($result) == false)
	   {
		$data_session = array('id'=>$result['id'],'name'=>$result['FIRSTNAME'],'email'=>$result['EMAIL'],'type'=>$result['type']);
		$this->session->set_userdata('logged_in', $result);

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

}
