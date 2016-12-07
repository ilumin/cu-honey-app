<?php

class operation_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	function schedule_info($start_date, $end_date){

		$sql ="SELECT T.*,G.NAME AS GARDEN_NAME,F.FLOWER_NAME FROM TRANSPORT AS T,GARDEN AS G,FLOWER AS F ,BLOOMING AS B
		WHERE 
		B.Garden_GARDEN_ID = G.GARDEN_ID 
		AND B.BLOOMING_ID = T.BLOOMING_BLOOMING_ID
		AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
		AND TRANSPORT_DATE>='".$start_date."' 
		AND TRANSPORT_DATE<= '".$end_date."'";
		
		$query = $this->db->query($sql);
		$data['TRANSPORT']= $query->result_array();
		//var_dump($data['TRANSPORT']);
		$sql ="SELECT H.*,G.NAME AS GARDEN_NAME,F.FLOWER_NAME FROM HARVESTHONEY AS H ,GARDEN AS G,FLOWER AS F WHERE
		G.GARDEN_ID  =  H.Garden_GARDEN_ID 
		AND F.FLOWER_ID = H.FLOWER_FLOWER_ID
		AND HARVEST_DATE>='".$start_date."' 
		AND HARVEST_DATE<= '".$end_date."'";
		
		$query = $this->db->query($sql);
		$data['HARVESTHONEY']= $query->result_array();
		//var_dump($data['HARVESTHONEY']);
		
		return $data;
	}
	
	public function transport_info_byTID($transport_id){
			$sql ="SELECT T.*,G.ADDRESS,G.NAME AS GARDEN_NAME,F.FLOWER_NAME  FROM TRANSPORT AS T,GARDEN AS G,FLOWER AS F ,BLOOMING AS B
			WHERE 
		B.Garden_GARDEN_ID = G.GARDEN_ID
		AND B.BLOOMING_ID = T.BLOOMING_BLOOMING_ID
		AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
		AND T.TRANSPORT_ID = ".$transport_id."
		";
				
		$query = $this->db->query($sql);
		
		//var_dump($data['HARVESTHONEY']);
		
		return $query->row_array();
	}
	
	public function harvest_info_byHID($harvest_id){
			$sql ="SELECT H.*,G.ADDRESS,G.NAME AS GARDEN_NAME,F.FLOWER_NAME  
FROM HARVESTHONEY AS H,GARDEN AS G,FLOWER AS F ,BLOOMING AS B
			WHERE 
		B.Garden_GARDEN_ID = G.GARDEN_ID
		AND B.BLOOMING_ID = H.BLOOMING_BLOOMING_ID
		AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
		AND H.HARVEST_ID =".$harvest_id."
		";
				
		$query = $this->db->query($sql);
		
		//var_dump($data['HARVESTHONEY']);
		
		return $query->row_array();
	}
	
	public function transport_info_byBID($bloom_id){
			$sql ="SELECT T.*,G.NAME AS GARDEN_NAME,F.FLOWER_NAME FROM TRANSPORT AS T,GARDEN AS G,FLOWER AS F ,BLOOMING AS B 
		WHERE 
		B.Garden_GARDEN_ID = G.GARDEN_ID
		AND B.BLOOMING_ID = T.BLOOMING_BLOOMING_ID
		AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
		AND T.BLOOMING_BLOOMING_ID = ".$bloom_id."
		";
				
		$query = $this->db->query($sql);
		
		//var_dump($data['HARVESTHONEY']);
		
		return $query->row_array();
	}
	public function transporthive_info_byBID($bloom_id){
		$sql ="SELECT BEEHIVE_BEE_HIVE_ID FROM TRANSPORTHIVE AS TH, TRANSPORT AS T 
					WHERE 
					T.BLOOMING_BLOOMING_ID = ".$bloom_id."
					AND TH.TRANSPORT_TRANSPORT_ID = T.TRANSPORT_ID
					ORDER BY BEEHIVE_BEE_HIVE_ID ASC
					";
		$query = $this->db->query($sql);
		//echo $sql;
		//var_dump($data['HARVESTHONEY']);
		
		return $query->result_array();
	}
	public function harvest_info_byBID($bloom_id){
		$sql ="SELECT BEEHIVE_BEE_HIVE_ID,HI.STATUS,HI.HARVEST_DATE FROM HARVESTHONEYITEM AS HI, HARVESTHONEY AS H
					WHERE 
					H.HARVEST_ID = ".$bloom_id."
					AND HI.HarvestHoney_HARVEST_ID = H.HARVEST_ID
					ORDER BY BEEHIVE_BEE_HIVE_ID ASC
					";
		$query = $this->db->query($sql);
		//echo $sql;
		//var_dump($data['HARVESTHONEY']);
		
		return $query->result_array();
	}
	
	public function blooming_info($id=0){
		
	$sql_add="";
		$sql ="
			SELECT  
			B.BLOOMING_ID,
			B.BLOOMING_PERCENT,
			B.BLOOMING_STATUS,
			B.BLOOMING_STARTDATE,
			B.BLOOMING_ENDDATE,
			B.FLOWER_FLOWER_ID,
			F.FLOWER_NAME,
			GF.AMOUNT_HIVE,
			GF.RISK_MIX_HONEY,
			GF.AMOUNT_HIVE,
			D.DEMAND_ORDER,
			G.GARDEN_ID,
			G.NAME
			FROM 
			BLOOMING AS B,FLOWER AS F,GARDENFLOWER AS GF,HONEYDEMAND AS D,GARDEN AS G
			WHERE B.BLOOMING_STATUS= 'รอยืนยัน'  
			AND B.FLOWER_FLOWER_ID=F.FLOWER_ID
			AND B.GARDEN_GARDEN_ID = G.GARDEN_ID
			AND GF.GARDEN_GARDEN_ID = B.GARDEN_GARDEN_ID
			AND GF.FLOWER_FLOWER_ID = F.FLOWER_ID
			AND F.FLOWER_ID = D.Flower_FLOWER_ID
			AND G.GARDEN_TYPE ='MEMBER'
			".$sql_add."
			ORDER BY DEMAND_ORDER ASC, AMOUNT_HIVE DESC
		";
		
		if($id>0){
			$sql_add= " AND G.GARDEN_ID=".$id;
			$query = $this->db->query($sql);
			$data= $query->row_array();
		}else{
			
			$query = $this->db->query($sql);
			$data= $query->result_array();
		}
		
		return $data;
	}
	
	public function hive_reserve(){
		
		$sql ="
			
			SELECT BEE_HIVE_ID FROM BEEHIVE WHERE STATUS='เก็บน้ำผึ้ง'   ORDER BY BEE_HIVE_ID ASC 
		";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	
	public function get_hive_public_park(){

		
	$sql ="
		SELECT COUNT(H.BEE_HIVE_ID) AS AMOUNT_HIVE, G.GARDEN_ID ,H.FLOWER_FLOWER_ID AS FLOWER_ID ,NAME
		FROM BEEHIVE AS H , GARDEN AS G 
		WHERE 
		H.STATUS='ว่าง'
		AND G.STATUS='APPROVE'
		AND G.GARDEN_ID= H.GARDEN_GARDEN_ID
		AND G.GARDEN_TYPE = 'PUBLIC'
		AND H.BEE_HIVE_ID  not in (
		SELECT TH.BeeHive_BEE_HIVE_ID  FROM TRANSPORTHIVE AS TH, TRANSPORT AS T 
		WHERE T.STATUS='รอขนย้าย'
		AND T.Garden_GARDEN_ID=H.GARDEN_GARDEN_ID 
		AND T.FLOWER_FLOWER_ID=H.FLOWER_FLOWER_ID 
		AND TH.Transport_TRANSPORT_ID = T.Transport_ID
		)
		GROUP BY H.GARDEN_GARDEN_ID,H.FLOWER_FLOWER_ID
		ORDER BY AMOUNT_HIVE DESC
	";
	
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	
	
	//G.GARDEN_ID,G.NAME,DISTANCE ,COUNT(TH.BEEHIVE_BEE_HIVE_ID ) AS AMOUNT_HIVE, T.TRANSPORT_DATE,T.FLOWER_FLOWER_ID AS FLOWER_ID
	public function get_hive_public_park_byID($garden_id){
	$sql ="
			SELECT COUNT(H.BEE_HIVE_ID) AS AMOUNT_HIVE, G.GARDEN_ID ,H.FLOWER_FLOWER_ID AS FLOWER_ID ,NAME ,DISTANCE
			FROM BEEHIVE AS H , GARDEN AS G ,DISTANCEGARDEN AS DG 
			WHERE 
			H.STATUS='ว่าง'
			AND G.STATUS='APPROVE'
			AND G.GARDEN_ID= H.GARDEN_GARDEN_ID
			AND G.GARDEN_TYPE = 'PUBLIC'
			AND Garden_GARDEN1_ID= ".$garden_id."
			AND Garden_GARDEN2_ID=G.GARDEN_ID
			AND H.BEE_HIVE_ID  not in (
			SELECT TH.BeeHive_BEE_HIVE_ID  FROM TRANSPORTHIVE AS TH, TRANSPORT AS T 
			WHERE T.STATUS='รอขนย้าย'
			AND T.Garden_GARDEN_ID=H.GARDEN_GARDEN_ID 
			AND T.FLOWER_FLOWER_ID=H.FLOWER_FLOWER_ID 
			AND TH.Transport_TRANSPORT_ID = T.Transport_ID
			)
			GROUP BY H.GARDEN_GARDEN_ID,H.FLOWER_FLOWER_ID
			ORDER BY AMOUNT_HIVE DESC ,DISTANCE ASC
	";
	//echo $sql;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
public function get_hive_member_park($data){
		
		//รอแก้ไข	
	$max_date ='0000-00-00';
	for($i=0; $i<count($data);$i++){
		if($max_date<$data[$i]['BLOOMING_ENDDATE']){
			$max_date = $data[$i]['BLOOMING_ENDDATE'];
			
		}
	}
	
	
	$sql ="
		SELECT COUNT(BEE_HIVE_ID) AS AMOUNT_HIVE,GARDEN_GARDEN_ID AS GARDEN_ID,FLOWER_FLOWER_ID AS FLOWER_ID ,NAME,STARTDATE,ENDDATE
		FROM BEEHIVE AS H , GARDEN AS G 
		WHERE 
		H.STATUS='เก็บน้ำผึ้ง'
		AND G.STATUS='APPROVE'
		AND G.GARDEN_ID= H.GARDEN_GARDEN_ID
		AND G.GARDEN_TYPE = 'MEMBER'
		AND H.ENDDATE >  '".$max_date."'
		GROUP BY GARDEN_GARDEN_ID,FLOWER_FLOWER_ID
		ORDER BY AMOUNT_HIVE DESC
				
	";
	
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}

	
	public function get_hive_member_park_byID($garden_id){
	$sql ="
	SELECT COUNT(H.BEE_HIVE_ID) AS AMOUNT_HIVE, G.GARDEN_ID ,H.FLOWER_FLOWER_ID AS FLOWER_ID ,NAME ,DISTANCE
			FROM BEEHIVE AS H , GARDEN AS G ,DISTANCEGARDEN AS DG 
			WHERE 
			H.STATUS='ว่าง'
			AND G.STATUS='APPROVE'
			AND G.GARDEN_ID= H.GARDEN_GARDEN_ID
			AND G.GARDEN_TYPE = 'MEMBER'
			AND Garden_GARDEN1_ID= ".$garden_id."
			AND Garden_GARDEN2_ID=G.GARDEN_ID
			AND H.BEE_HIVE_ID  not in (
			SELECT TH.BeeHive_BEE_HIVE_ID  FROM TRANSPORTHIVE AS TH, TRANSPORT AS T 
			WHERE T.STATUS='รอขนย้าย'
			AND T.Garden_GARDEN_ID=H.GARDEN_GARDEN_ID 
			AND T.FLOWER_FLOWER_ID=H.FLOWER_FLOWER_ID 
			AND TH.Transport_TRANSPORT_ID = T.Transport_ID
			)
			GROUP BY H.GARDEN_GARDEN_ID,H.FLOWER_FLOWER_ID
			ORDER BY AMOUNT_HIVE DESC ,DISTANCE ASC
	";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	public function hive_avaliable($start,$row){
		
		$sql ="
			
			SELECT BEE_HIVE_ID FROM BEEHIVE WHERE STATUS='ว่าง'   ORDER BY BEE_HIVE_ID ASC LIMIT ".$start.",".$row;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}

	public function hive_id_ByGardenID($garden_id,$flower_id, $amount_hive){
				
		$sql ="SELECT * FROM BEEHIVE AS H  WHERE GARDEN_GARDEN_ID=".$garden_id." AND FLOWER_FLOWER_ID = ".$flower_id." ORDER BY EXPIRED_DATE DESC LIMIT 0,".$amount_hive;

		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	
	public function insert_hive_transportation_item($data){
		$this->db->set($data);
		return $this->db->insert('transporthive', $data);
		
	}
	public function insert_hive_transportation($data){
		$this->db->set($data);
		$this->db->insert('transport', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function insert_harvest($data){
		$this->db->set($data);
		$this->db->insert('harvesthoney', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function insert_harvest_item($data){
		$this->db->set($data);
		$this->db->insert('harvesthoneyitem', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function insert_distance($data){
		$this->db->set($data);
		$check = $this->db->insert('distancegarden',$data);
		return $check;
		
	}
	
	public function update_distance($data){
		$update['DISTANCE'] = $data['DISTANCE'];
         $this->db->where('Garden_GARDEN1_ID', $data['Garden_GARDEN1_ID']);
         $this->db->where('Garden_GARDEN2_ID', $data['Garden_GARDEN2_ID']);
		return $this->db->update('distancegarden', $update);
		
	}
	
	
	
	  public function updateBloom($id, $data = array())
    {
		$update= array();

		if(isset($data['blooming_status'])){
			$update['BLOOMING_STATUS'] = $data['blooming_status'];
		}
		if(isset($data['blooming_startdate'])){
			$update['BLOOMING_STARTDATE'] = $data['blooming_startdate'];
		}
		if(isset($data['blooming_enddate'])){
			$update['BLOOMING_ENDDATE'] = $data['blooming_enddate'];
		}
		if(isset($data['blooming_percent'])){
			$update['BLOOMING_PERCENT'] = $data['blooming_percent'];
		}
		if(isset($data['garden_garden_id'])){
			$update['garden_garden_id'] = $data['garden_garden_id'];
		}
		if(isset($data['flower_flower_id'])){
			$update['flower_flower_id'] = $data['flower_flower_id'];
		}
		
		if(count($update)>0){
         $this->db->where('BLOOMING_ID', $id);
			return $this->db->update('blooming', $update);
		}else{
			
			return false;
		}
    }
	
	
	  public function updateTransport($id, $data = array())
    {
		$update= array();
/*
TRANSPORT_DATE
RETURN_DATE
STATUS
GARDEN_GARDEN_ID
FLOWER_FLOWER_ID
BLOOMING_BLOOMING_ID
*/
		if(isset($data['transport_date'])){
			$update['TRANSPORT_DATE'] = $data['transport_date'];
		}
		if(isset($data['return_date'])){
			$update['RETURN_DATE'] = $data['return_date'];
		}
		if(isset($data['status'])){
			$update['STATUS'] = $data['status'];
		}
		if(isset($data['blooming_percent'])){
			$update['BLOOMING_PERCENT'] = $data['blooming_percent'];
		}
		if(isset($data['garden_garden_id'])){
			$update['GARDEN_GARDEN_ID'] = $data['garden_garden_id'];
		}
		if(isset($data['flower_flower_id'])){
			$update['flower_flower_id'] = $data['flower_flower_id'];
		}
		
		if(count($update)>0){
			$this->db->where('transport_id', $id);
			return $this->db->update('transport', $update);
		}else{
			
			return false;
		}
    }
	  public function updateHarvest($id, $data = array())
    {
		/*
		`HARVEST_ID`, `Garden_GARDEN_ID`, `Flower_FLOWER_ID`, `Blooming_BLOOMING_ID`, `HARVEST_DATE`, `HONEY_AMOUNT`, `HARVEST_STATUS`
		*/
		$update= array();

		if(isset($data['harvest_date'])){
			$update['HARVEST_DATE'] = $data['harvest_date'];
		}
		
		if(isset($data['status'])){
			$update['HARVEST_STATUS'] = $data['status'];
		}
		if(isset($data['blooming_id'])){
			$update['Blooming_BLOOMING_ID'] = $data['blooming_id'];
		}
		if(isset($data['garden_id'])){
			$update['GARDEN_GARDEN_ID'] = $data['garden_id'];
		}
		if(isset($data['flower_id'])){
			$update['flower_flower_id'] = $data['flower_id'];
		}
		
		if(isset($data['honey_amount'])){
			$update['HONEY_AMOUNT'] = $data['honey_amount'];
		}
		
		if(count($update)>0){
			$this->db->where('HARVEST_ID', $id);
			return $this->db->update('harvesthoney', $update);
		}else{
			
			return false;
		}
    }
	 public function updateHarvestItem( $data = array())
    {
		/*HarvestHoney_HARVEST_ID, BeeHive_BEE_HIVE_ID, HARVEST_DATE, STATUS*/
		$update= array();

		if(isset($data['harvest_date'])){
			$update['HARVEST_DATE'] = $data['harvest_date'];
		}
		if(isset($data['status'])){
			$update['STATUS'] = $data['status'];
		}
		
		
		if(count($update)>0){
			$this->db->where('HarvestHoney_HARVEST_ID', $data['harvest_id']);
			$this->db->where('BeeHive_BEE_HIVE_ID', $data['bee_hive_id']);
			return $this->db->update('harvesthoneyitem', $update);
		}else{
			
			return false;
		}
    }
}

?>