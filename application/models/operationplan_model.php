<?php

class operationplan_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function harvest($id=0,$date=TODAY_DATE){
		$sql_add='';
		if($id>0){
			$sql_add = " AND H.HARVEST_ID=".$id;
			
		}
		$sql = "
			SELECT 
				G.GARDEN_ID,
				B.FLOWER_FLOWER_ID,
				HARVEST_ID,
				COUNT(BEEHIVE_BEE_HIVE_ID) AS AMOUNT_HIVE,
				DISTANCE,
				DEMAND_FLOWER_ID,
				G.NAME AS GARDEN_NAME,
				F.FLOWER_NAME,
				G.ADDRESS,
				H.HARVEST_STATUS,
				H.HARVEST_STARTDATE,
				HI.LASTED_HARVEST_DATE
				FROM 
				GARDEN AS G,
				BLOOMING AS B,
				FLOWER AS F,
				HARVESTHONEY AS H,
				HARVESTHONEYITEM AS HI,
				DISTANCEGARDEN AS D
				WHERE 
				G.STATUS = 'APPROVE'
				AND G.GARDEN_ID = B.GARDEN_GARDEN_ID
				AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
				AND F.FLOWER_ID = H.FLOWER_FLOWER_ID
				AND H.BLOOMING_BLOOMING_ID = B.BLOOMING_ID
				AND HI.HARVESTHONEY_HARVEST_ID = H.HARVEST_ID
				AND Garden_GARDEN1_ID=1
				AND Garden_GARDEN2_ID=B.GARDEN_GARDEN_ID
				AND H.HARVEST_STATUS ='เก็บน้ำผึ้ง'
				AND (HI.STATUS = 'เก็บน้ำผึ้ง'  OR HI.STATUS = 'รอขนย้าย')
				AND '".TODAY_DATE."' >= H.HARVEST_STARTDATE 
				
				AND (   (DATEDIFF('".TODAY_DATE."',LASTED_HARVEST_DATE)>=3)
						OR  
						(LASTED_HARVEST_DATE='0000:00:00' AND DATEDIFF('".TODAY_DATE."',HARVEST_STARTDATE)>=3 )
					)
				".$sql_add."
				GROUP BY HARVESTHONEY_HARVEST_ID
				HAVING AMOUNT_HIVE> 0
				ORDER BY GARDEN_TYPE ASC,AMOUNT_HIVE DESC, DISTANCE ASC
			";
		//echo $sql;
		$query = $this->db->query($sql);
		
		if($id ==0){
			$data= $query->result_array();
		}else{
			$data= $query->row_array();
		}
		
		return $data;
	}
	
	public function transfer($chk_date=TODAY_DATE){
		if($chk_date > TODAY_DATE){
			$condition = " >= ";
		}
		if($chk_date == TODAY_DATE){
			$condition =" = ";
		}
		//$sql = "SELECT * FROM TRANSPORT WHERE STATUS = 'รอขนส่ง' AND DATEDIFF('".TODAY_DATE."',TRANSPORT_DATE )";
		$start_date = TODAY_DATE;
		$end_date = date('Y-m-d',strtotime(TODAY_DATE." +3days"));
		$sql ="
				SELECT T.*,G.NAME AS GARDEN_NAME,F.FLOWER_NAME,COUNT(TH.BeeHive_BEE_HIVE_ID) AS AMOUNT_HIVE ,G.GARDEN_ID
				FROM TRANSPORT AS T,TRANSPORTHIVE AS TH ,BLOOMING AS B , GARDEN AS G , FLOWER AS F 
				WHERE 
				T.STATUS= 'รอขนส่ง'
				AND T.TRANSPORT_ID = TH.TRANSPORT_TRANSPORT_ID
				AND TH.STATUS = 'รอขนส่ง'
				AND T.BLOOMING_BLOOMING_ID = B.BLOOMING_ID 
				AND B.GARDEN_GARDEN_ID= G.GARDEN_ID 
				AND B.FLOWER_FLOWER_ID = F.FLOWER_ID
				AND '".$chk_date."' ".$condition." T.TRANSPORT_DATE 
				GROUP BY TRANSPORT_ID
			";
	
		
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	public function hive_fix(){
		$sql = "SELECT F.*,HI.BeeHive_BEE_HIVE_ID FROM BEEHIVE_FIX AS F,HARVESTHONEYITEM AS HI WHERE F.STATUS = 'ซ่อมแซม'  AND HI.HARVESTHONEYITEM_ID= F. HARVEST_ITEM_ID ";
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		//TODO : Query Later
	}
	
	public function harvesthive($id){
		$sql =
			'SELECT HI.BEEHIVE_BEE_HIVE_ID, HI.LASTED_HARVEST_DATE,HI.STATUS,NO_HARVEST,PERCENT_HARVEST,HARVESTHONEYITEM_ID 
			, DATEDIFF("'.TODAY_DATE.'",LASTED_HARVEST_DATE) AS DATE_DIFF
			FROM HARVESTHONEY AS H ,HARVESTHONEYITEM AS HI 
			WHERE 
			H.HARVEST_ID = HI.HARVESTHONEY_HARVEST_ID
			AND H.HARVEST_ID='.$id." 
			AND (HI.STATUS = 'เก็บน้ำผึ้ง' OR HI.STATUS = 'รอขนย้าย')
			AND H.HARVEST_STATUS = 'เก็บน้ำผึ้ง'
			ORDER BY DATE_DIFF DESC, BEEHIVE_BEE_HIVE_ID ASC";
		//echo $sql;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
	}
	
	public function garden_move_back($garden_id){
		$sql ="SELECT G.*, COUNT(BEE_HIVE_ID) AS REMAIN_HIVE  FROM GARDEN AS G
				LEFT JOIN BEEHIVE AS BH ON G.GARDEN_ID=BH.GARDEN_GARDEN_ID 
				WHERE  GARDEN_TYPE='PUBLIC' 
				GROUP BY GARDEN_ID 
				";
		//echo $sql;
		$query = $this->db->query($sql);
		$data= $query->result_array();
		return $data;
		
	}
	
	public function get_avg_honey($harvest_id){
		$sql = 
		"
		SELECT SUM(HONEY_AMOUNT) AS TOTALHONEY, AVG(HONEY_AMOUNT) AS AVGHONEY ,COUNT(HARVESTHONEY_HARVEST_ID) AS HIVE FROM HARVESTITEMDETAIL AS HD, HARVESTHONEYITEM AS HI 
		WHERE 
		HI.HARVESTHONEYITEM_ID  =HD. HARVESTHONEYITEM_ID
		AND HI.LASTED_HARVEST_DATE = HD.HARVEST_DATE
		AND HI.HARVESTHONEY_HARVEST_ID=".$harvest_id."
		GROUP BY HI.HARVESTHONEY_HARVEST_ID;";
		
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
		
	}
	/* 
	public function transfer_detail($id){
		$sql = "
			SELECT T.*,G.ADDRESS,G.NAME AS GARDEN_NAME,F.FLOWER_NAME  FROM TRANSPORT AS T,GARDEN AS G,FLOWER AS F ,BLOOMING AS B
			WHERE 
		B.Garden_GARDEN_ID = G.GARDEN_ID
		AND B.BLOOMING_ID = T.BLOOMING_BLOOMING_ID
		AND F.FLOWER_ID = B.FLOWER_FLOWER_ID
		AND T.TRANSPORT_ID =".$id;
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
	} */
}

?>