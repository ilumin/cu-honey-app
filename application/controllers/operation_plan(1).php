<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class operation_plan extends CI_Controller {
	public $data;
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('member_model','',TRUE);
	   $this->load->model('operationplan_model','',TRUE);
	   $this->load->model('operation_model','',TRUE);
	   $this->load->model('gardener_model','',TRUE);
	   $this->load->model('harvest_model','',TRUE);
	   $this->load->model('fix_model','',TRUE);
	   $this->load->model('transport_model','',TRUE);
	   $this->load->model('BeehiveModel','',TRUE);
	   $this->load->model('QueenModel','',TRUE);
	   $this->load->model('BeeframeModel','',TRUE);
	   $this->load->model('ConfigModel','',TRUE);
	   
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
	
	public function index(){
		
		$data = $this->get_data();
		$data['harvest_info'] = $this->operationplan_model->harvest();
		//var_dump($data['harvest_info']);
		
		$data['transfer_info'] = $this->operationplan_model->transfer();
		//var_dump($data['transfer_info']);
		
		$data['hive_fix'] = $this->operationplan_model->hive_fix();
		//var_dump($data['hive_fix']);
		
		$f_info = $this->gardener_model->get_flower();
		$f_arr = array();
		foreach($f_info as $key => $value){
			$f_arr[$value['FLOWER_ID']] = $value['FLOWER_NAME'];
		}
		$data['flowers'] = $f_arr;
		//var_dump($data['flowers']);
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('operation_plan', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('theme/footer', $data);
	}
	
	public function harvest($id){
		$data = $this->get_data();
		$garden_info = $this->gardener_model->garden_all($id);
		$data['garden_move_back'] = array();
		$data['garden_info'] = $garden_info;
		$data['harvest_info'] = $this->operationplan_model->harvest($id);
		$data['honey_avg'] = $this->operationplan_model->get_avg_honey($id);
		
		$config = $this->ConfigModel->getAll();
		
		$data['rental_rate'] = $config['RENTAL_RATE'];
		//var_dump($data['harvest_info']);
		$data['harvest_hive'] = $this->operationplan_model->harvesthive($id);
		
		if(count($data['harvest_info'])>0){
			$data['garden_move_back'] = $this->operationplan_model->garden_move_back($data['harvest_info']['GARDEN_ID']);
		}
		//var_dump($data['garden_move_back']);
		
		$f_info = $this->gardener_model->get_flower();
		$f_arr = array();
		foreach($f_info as $key => $value){
			$f_arr[$value['FLOWER_ID']] = $value['FLOWER_NAME'];
		}
		$data['flowers'] = $f_arr;
		
		//var_dump($data['flowers']);
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('harvest_detail', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/harvest_js', $data);
		$this->load->view('theme/footer', $data);
		
	}
	
	public function save($method_name){
		if($method_name =='transfer'){
			$id = $this->input->post('transport_id');
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$garden_id = $this->input->post('garden_id');
			$flower_id = $this->input->post('flower_id');
			$blooming_id = $this->input->post('blooming_id');
			$harvest_id = $this->input->post('harvest_id');
			

			
			$data_update['status'] = 'ขนส่งเรียบร้อย';
			$data_update['transport_date'] = $start_date;
			
			
			$check = $this->transport_model->updateTransport($id,$data_update);
			//echo "check-update transport".$check."<br>";
			
			$data_update3['HARVEST_STATUS'] = 'เก็บน้ำผึ้ง';
			$data_update3['HARVEST_STARTDATE'] = $start_date ;
			$data_update3['HARVEST_ENDDATE'] =$end_date ;
			$check_harvest = $this->harvest_model->update($harvest_id,$data_update3);
			
			//echo "check-update Harvest".$check_harvest."<br>";
		
			
			$hive_arr = $this->input->post('hive_select');
			
			
			if($check == true){
				for($i=0; $i<count($hive_arr); $i++){
					$data_update5['STATUS'] = 'ขนส่งเรียบร้อย';
					$check6[$i] = $this->transport_model->updateTransportItem($id,$hive_arr[$i], $data_update5);
					//echo "check-update TransportHive".$hive_arr[$i]."--status: ".$check6[$i]."<br>";
					
					$data_update2['status'] = 'เก็บน้ำผึ้ง';
					$data_update2['start_date'] = $start_date ;
					$data_update2['end_date'] =$end_date ;
					$data_update2['GARDEN_GARDEN_ID'] =$garden_id ;
					$data_update2['FLOWER_FLOWER_ID'] =$flower_id ;
					
					$check2[$i] = $this->BeehiveModel->updateData($hive_arr[$i],$data_update2);
					//echo "check-update Beehive".$hive_arr[$i]."--status: ".$check2[$i]."<br>";

					if($harvest_id >0){
						$data_update4['STATUS'] = 'เก็บน้ำผึ้ง';
						$data_update4['LASTED_HARVEST_DATE'] = '0000-00-00' ;
						$data_update4['NO_HARVEST'] = 0 ;
						$data_update4['PERCENT_HARVEST'] = 0 ;
						
						
						$data_update5['STATUS'] = 'เก็บน้ำผึ้ง';
						
						$check4[$i] = $this->harvest_model->updateItem_BY_BHID($hive_arr[$i],$harvest_id,$data_update4);
						//$check5[$i] = $this->harvest_model->updateItem_BY_BHID($hive_arr[$i],$data_info['HARVEST_ID'],$data_update5);
						//echo "check-update Harvest ITEM".$hive_arr[$i]."--status: ".$check4[$i]."<hr>";
					}
				}
			}
			//redirect("operation_plan","refresh");
			
			
		}else if($method_name=='harvest'){
			//var_dump($_POST);
			
			$id = $this->input->post('harvest_id');
			$harvest_date = TODAY_DATE;
			$honey_amount = $this->input->post('honey_amount');
			$item_arr = $this->input->post('hive_select');
			
				for($i=0; $i<count($item_arr); $i++){
						$data_update2= array();
						
						$id_arr = explode("|",$item_arr[$i]);
						$harvesthoneyitem_id = $id_arr[0];
						$hive_id = $id_arr[1];
						
						$data_update2['HARVEST_DATE'] = $harvest_date ;
						$data_update2['HARVESTHONEYITEM_ID'] = $harvesthoneyitem_id ;
						$data_update2['HONEY_AMOUNT'] = $this->input->post('honey_amount'.$harvesthoneyitem_id) ;
						
						$check1[$i] = $this->harvest_model->insert_detail($data_update2);
						
						
						
						$honey_amount= array();
						$data = $this->harvest_model->get_harvest_detail($harvesthoneyitem_id);
						
						for($j=0;$j<count($data);$j++){
							$honey_amount[$j] = $data[$j]['HONEY_AMOUNT'];
							$date_harvest[$j] = $data[$j]['HARVEST_DATE'];
						}
						$amount_harvest = count($data);
						$last_id = count($data)-1;
						$max_val = max($honey_amount);
						$max_date = max($date_harvest);
						$last_val = $honey_amount[$last_id];
						$percent_diff = number_format((($last_val/$max_val)*100),2);  //TODO: NEED TO BE REVISE
						
						
						$data_update = array();
						$data_update['STATUS'] ='เก็บน้ำผึ้ง' ;
						$data_update['NO_HARVEST'] =$amount_harvest ;
						$data_update['LASTED_HARVEST_DATE'] = $max_date;
						$data_update['PERCENT_HARVEST'] = $percent_diff;
					

						 $check2[$i] = $this->harvest_model->updateItem( $harvesthoneyitem_id ,$data_update);
						//DATA UPDATE ITEM
						
					if($this->input->post('fix_'.$harvesthoneyitem_id) == 'yes' ){
						
						//FIX DETAIL  TO DO ADD DETAIL TO DB HIVE_FIX
							$data_insert= array();
							$data_insert['TYPE_FIX'] = $this->input->post('fix_type'.$harvesthoneyitem_id);
							$data_insert['HARVEST_ITEM_ID'] = $item_arr[$i];
							$data_insert['REMARK'] = $this->input->post('remark_'.$harvesthoneyitem_id);
							$check2[$i]= $this->fix_model->insert($data_insert);
							
							
							$data_update = array();
							$data_update['STATUS'] ='ซ่อมแซม' ;
							$check2[$i] = $this->harvest_model->updateItem( $harvesthoneyitem_id ,$data_update);
							//RESET ให้ไปซ่อมที่บ้าน
							//echo $item_arr[$i]."-".$data_insert['TYPE_FIX']."<br />";
							
							if($data_insert['TYPE_FIX'] == 1){  //เปลี่ยนรัง
								$data_update2= array();
								$data_update2['status'] = 'ซ่อมแซม';
								$data_update2['start_date'] = "0000-00-00" ;
								$data_update2['end_date'] ="0000-00-00" ;
								$data_update2['GARDEN_GARDEN_ID'] ="1" ; //กลับบ้านจ้า
								$data_update2['FLOWER_FLOWER_ID'] =BJP_FLOWER ; //ดอกไมเบญจพรรณไปก่อนจ้า 
								$check_fix['hive'][$i] = $this->BeehiveModel->updateData($hive_id,$data_update2);
								
							} else if($data_insert['TYPE_FIX'] == 2){  //เปลี่ยนคอน
								$data_update2= array();
								$data_update2['status'] = 'ซ่อมแซม';
								$con_id =explode(",",$data_insert['REMARK']);
								for($g=0;$g<count($con_id);$g++){
									$check_fix['con'][$i] = $this->BeeframeModel->updateData($con_id[$g],$data_update2);
								}
								
							}else if($data_insert['TYPE_FIX'] == 3){ //เปลี่ยนนางพญา
								$data_update2= array();
								$data_update2['status'] = 'ซ่อมแซม';
								$data_update2['beehive_id'] = $hive_id;
								
								 $check_fix['queen'][$i] = $this->QueenModel->updateData($hive_id,$data_update2);
								
							}
						
						
						
						
					}
				
				
				}
			$move_back = $this->input->post('move_back');
			if($move_back == true){
				$data_post['HARVEST_ID'] = $id;
				$data_post['GARDEN_ID'] = $this->input->post('move_back_park');
				$this->move_back($data_post);
				
			}
			
			
			redirect("operation_plan","refresh");
		}
	
	}
	
	public function transfer($transport_id){
		$data = $this->get_data();
		$this->load->model('blooming_model');
		if($transport_id>0){
			$transport_info = $this->transport_model->get_transportBYID($transport_id);
			//var_dump($transport_info);
			if(count($transport_info)>0 ){
				$bloom_id = $transport_info['Blooming_BLOOMING_ID'];
				$garden_id_from = $transport_info['Garden_GARDEN_ID'];
				$flower_id_from = $transport_info['Flower_FLOWER_ID'];
				$transportHive = $this->transport_model->get_transportHiveBYID($transport_id);
				$data['transport_info'] = $transport_info;
				$data['transport_hive'] =$transportHive;
				$data['garden_info']=$this->blooming_model->get_garden_info($garden_id_from,$flower_id_from);
			}
		}
		
		$this->load->view('theme/header', $data);
		$this->load->view('theme/left_bar', $data);
		$this->load->view('theme/nav',$data);
		$this->load->view('transfer_detail', $data);
		$this->load->view('theme/footer_js', $data);
		$this->load->view('js/transfer_detail', $data);
		
		$this->load->view('theme/footer', $data);
		
	}
	
	private function move_back($data_post){
		
		$harvest_info = $this->harvest_model->get_harvest_info_BYID($data_post['HARVEST_ID']);
		
		
		$blooming_id = $harvest_info['Blooming_BLOOMING_ID'];
		
		$data_h['Blooming_BLOOMING_ID']= $blooming_id;
		$data_h['HARVEST_STATUS'] ='เก็บน้ำผึ้งเรียบร้อย';
		$data_h['HARVEST_ENDDATE'] = TODAY_DATE;
		$check = $this->harvest_model->update($data_post['HARVEST_ID'] , $data_h);
		
		$data_hi['STATUS']='เก็บน้ำผึ้งเรียบร้อย';
		$data_hi['STATUS_CHECK']='เก็บน้ำผึ้ง';
		$check = $this->harvest_model->updateItem_BY_HID($data_post['HARVEST_ID'] , $data_hi);
		
		
		
		$harvest_info2 = $this->harvest_model->get_harvest_info_BY_GID($data_post['GARDEN_ID']);
		
		//INSERT TRANSPORT 
		$data_insert['TRANSPORT_DATE'] = TODAY_DATE;
		
		$data_insert['STATUS'] = 'ขนส่งเรียบร้อย';
		$data_insert['FLOWER_FLOWER_ID'] = BJP_FLOWER ;
		$data_insert['GARDEN_GARDEN_ID'] = $data_post['GARDEN_ID'];
		$data_insert['Blooming_BLOOMING_ID'] = $blooming_id;
		$data_insert['HarvestHoney_HARVEST_ID'] = $harvest_info2['HARVEST_ID'];
		$insert_id = $this->transport_model->insert($data_insert);

		//วันที่ Expire Date DESC
		//INSERT  TRANSPORT DETAIL
		$hive_info = $this->operation_model->hive_id_ByGardenID($data_post['GARDEN_ID'],BJP_FLOWER);
		
		if($insert_id >0){
			for($j=0;$j<count($hive_info );$j++){
				$data_insert2['Transport_TRANSPORT_ID'] = $insert_id ; 
				$data_insert2['BeeHive_BEE_HIVE_ID']=$hive_info[$j]['BEE_HIVE_ID'];
				$data_insert2['STATUS']='ขนส่งเรียบร้อย';
				
				$chk_insert2[$j] =  $this->transport_model->insert_hive($data_insert2);
				
				$data_b['FLOWER_FLOWER_ID'] = BJP_FLOWER ;
				$data_b['GARDEN_GARDEN_ID'] = $data_post['GARDEN_ID'];
				$data_b['status'] = 'ว่าง';
				
				
				 $this->BeehiveModel->updateData($data_insert2['BeeHive_BEE_HIVE_ID'],$data_b );
				 
				 
				$data_insert3['HarvestHoney_HARVEST_ID'] = $harvest_info2['HARVEST_ID'] ; // TO DO Will be revise to get last insert transport  --34
				$data_insert3['BeeHive_BEE_HIVE_ID']=$data_insert2['BeeHive_BEE_HIVE_ID'];
				$data_insert3['STATUS']='เก็บน้ำผึ้ง';
				$data_insert3['LASTED_HARVEST_DATE']=TODAY_DATE;
				$data_insert3['NO_HARVEST']='0';
				$data_insert3['PERCENT_HARVEST']='0';

				$chk_insert3[$j] =  $this->harvest_model->insert_item($data_insert3);
				
				
			}
		}
		
	}
	
}
