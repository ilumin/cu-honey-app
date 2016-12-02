<?php

class operation_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	function schedule_info($start_date, $end_date){

		$sql ="SELECT T.*,G.NAME AS GARDEN_NAME,F.FLOWER_NAME FROM TRANSPORT AS T,GARDEN AS G,FLOWER AS F WHERE 
		T.Garden_GARDEN_ID = G.GARDEN_ID 
		AND F.FLOWER_ID = T.FLOWER_FLOWER_ID
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
			AND GF.GARDEN_GARDEN_ID = B.GARDEN_GARDEN_ID
			AND F.FLOWER_ID = D.Flower_FLOWER_ID
			AND G.GARDEN_ID = B.GARDEN_GARDEN_ID
			".$sql_add."
			ORDER BY DEMAND_ORDER ASC
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
	SELECT G.GARDEN_ID,G.NAME ,COUNT(TH.BEEHIVE_BEE_HIVE_ID ) AS AMOUNT_HIVE
	FROM GARDEN AS G ,TRANSPORT AS T ,TRANSPORTHIVE AS TH
	WHERE GARDEN_TYPE='PUBLIC'
	AND G.GARDEN_ID= T.GARDEN_GARDEN_ID
	AND T.TRANSPORT_ID = TH.Transport_TRANSPORT_ID
	AND G.STATUS='APPROVE'
	AND T.STATUS = 'ขนส่งเรียบร้อย'
	GROUP BY GARDEN_ID
	ORDER BY AMOUNT_HIVE DESC
	";
	
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	
	public function get_hive_public_park_byID($garden_id){
	$sql ="
	SELECT G.GARDEN_ID,G.NAME,DISTANCE ,COUNT(TH.BEEHIVE_BEE_HIVE_ID ) AS AMOUNT_HIVE, T.TRANSPORT_DATE
	FROM GARDEN AS G ,TRANSPORT AS T ,TRANSPORTHIVE AS TH, DISTANCEGARDEN AS DG
	WHERE GARDEN_TYPE='PUBLIC'
	AND G.GARDEN_ID= T.GARDEN_GARDEN_ID
	AND T.TRANSPORT_ID = TH.TRANSPORT_TRANSPORT_ID
	AND G.STATUS='APPROVE'
	AND T.STATUS = 'ขนส่งเรียบร้อย'
	AND Garden_GARDEN1_ID=".$garden_id."
	AND Garden_GARDEN2_ID=G.GARDEN_ID
	GROUP BY DISTANCE
	ORDER BY AMOUNT_HIVE DESC, DISTANCE ASC
	";
	
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	public function get_hive_member_park($data){
		
			
	$max_date ='0000-00-00';
	for($i=0; $i<count($data);$i++){
		if($max_date<$data[$i]['BLOOMING_ENDDATE']){
			$max_date = $data[$i]['BLOOMING_ENDDATE'];
			
		}
	}
	$sql ="
		SELECT G.GARDEN_ID,G.NAME ,COUNT(TH.BEEHIVE_BEE_HIVE_ID ) AS AMOUNT_HIVE, T.TRANSPORT_DATE,T.RETURN_DATE
		FROM GARDEN AS G ,TRANSPORT AS T ,TRANSPORTHIVE AS TH
		WHERE GARDEN_TYPE='MEMBER'
		AND G.GARDEN_ID= T.GARDEN_GARDEN_ID
		AND T.TRANSPORT_ID = TH.Transport_TRANSPORT_ID
		AND G.STATUS='APPROVE'
		AND T.STATUS = 'ขนส่งเรียบร้อย'
		AND T.TRANSPORT_DATE > '".$max_date."'
		GROUP BY GARDEN_ID
		ORDER BY AMOUNT_HIVE DESC
	";
	
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}

	
	public function get_hive_member_park_byID($garden_id){
	$sql ="
	SELECT G.GARDEN_ID,G.NAME,DISTANCE ,COUNT(TH.BEEHIVE_BEE_HIVE_ID ) AS AMOUNT_HIVE, T.TRANSPORT_DATE,T.RETURN_DATE
	FROM GARDEN AS G ,TRANSPORT AS T ,TRANSPORTHIVE AS TH, DISTANCEGARDEN AS DG
	WHERE GARDEN_TYPE='MEMBER'
	AND G.GARDEN_ID= T.GARDEN_GARDEN_ID
	AND T.TRANSPORT_ID = TH.TRANSPORT_TRANSPORT_ID
	AND G.STATUS='APPROVE'
	AND T.STATUS = 'ขนส่งเรียบร้อย'
	AND Garden_GARDEN1_ID=".$garden_id."
	AND Garden_GARDEN2_ID=G.GARDEN_ID
	AND G.GARDEN_ID!=".$garden_id."
	GROUP BY DISTANCE
	ORDER BY AMOUNT_HIVE DESC, DISTANCE ASC
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
	
	public function insert_hive_transportation_item($data){
		$this->db->insert('transporthive', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function insert_hive_transportation($data){
		$this->db->insert('transport', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function insert_harvest($data){
		$this->db->insert('harvesthoney', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function insert_harvest_item($data){
		$this->db->insert('harvesthoneyitem', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	public function insert_distance($data){
		$check = $this->db->insert('distancegarden',$data);
		return $check;
		
	}
}

?>