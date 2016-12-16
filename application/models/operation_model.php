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

	
	
	



	
	
	
	 
	
	

}

?>