<?php

class member_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function check_login($email,$password) {
		$password = md5($password);
	  if($email != FALSE && $password != FALSE) {
		$query = $this->db->get_where('beekeeper', array('EMAIL' => $email,'PASSWORD'=>$password));
		$data= $query->row_array();
		
		if(is_null($data)== true){
	
			$query = $this->db->get_where('gardener', array('EMAIL' => $email,'PASSWORD'=>$password));
			$data= $query->row_array();
			
			
		}
		if(isset($data['BEE_KEEPER_ID'])){
			$data['id'] = $data['BEE_KEEPER_ID'];
			$data['type'] = 'beekeeper';
		}
		
		if(isset($data['GARDENER_ID'])){
			$data['id'] = $data['GARDENER_ID'];
			$data['type'] = 'gardener';
		}
		
		return $data;
	  }
	  else {
		return FALSE;
	  }
	}

	
	
	public function get_data()
	{

		$email ="yippadedoda@gmail.com";
		$password = "1234";
		//$this->load->model('beekeeper_model');
		$bee_keeper_id=1;
		$CI =& get_instance();
		$CI->load->model('beekeeper_model');
		$bee_keeper_info =  $CI->beekeeper_model->check_login($email,md5($password));

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
	

}

?>