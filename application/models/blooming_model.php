

<?php

class blooming_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	public function blooming_infoByID($blooming_id){
		$sql ="SELECT * FROM BLOOMING WHERE BLOOMING_ID =".$blooming_id;
		$query = $this->db->query($sql);
		$data= $query->row_array();
		return $data;
	}
	
	public function get_garden_info($garden_id, $flower_id){
		$sql = "SELECT * 
		FROM GARDEN AS G, GARDENFLOWER AS GF ,FLOWER  AS F
		WHERE 
		G.GARDEN_ID= GF.GARDEN_GARDEN_ID
		AND F.FLOWER_ID = GF.Flower_FLOWER_ID
		AND G.GARDEN_ID=".$garden_id." 
		AND GF.Flower_FLOWER_ID=".$flower_id;
		$query = $this->db->query($sql);
		$data= $query->row_array();
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
			B.DEMAND_FLOWER_ID,
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
			AND B.DEMAND_FLOWER_ID = D.Flower_FLOWER_ID
			AND G.GARDEN_TYPE ='MEMBER'
			AND G.STATUS = 'APPROVE'
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
	
	function get_public_hive_avaliable ($id){
		$sql = "
			SELECT G.GARDEN_ID,G.NAME ,COUNT(HI.BEEHIVE_BEE_HIVE_ID) AS AMOUNT_HIVE,DISTANCE, B.FLOWER_FLOWER_ID AS FLOWER_ID
			FROM GARDEN AS G ,BLOOMING AS B ,HARVESTHONEY AS H , HARVESTHONEYITEM AS HI, DISTANCEGARDEN AS D
			WHERE G.GARDEN_TYPE='PUBLIC'
			AND B.GARDEN_GARDEN_ID = G.GARDEN_ID
			AND G.STATUS ='APPROVE'
			AND B.BLOOMING_STATUS  ='ยืนยัน'
			AND B.BLOOMING_ID = H.Blooming_BLOOMING_ID
			AND H.HARVEST_ID= HI.HarvestHoney_HARVEST_ID
			AND D.GARDEN_GARDEN1_ID=".$id."
			AND Garden_GARDEN2_ID=G.GARDEN_ID
			AND H.HARVEST_STATUS ='เก็บน้ำผึ้ง'
			AND HI.STATUS = 'เก็บน้ำผึ้ง'
			AND DATEDIFF('".TODAY_DATE."',H.HARVEST_STARTDATE)>= 5 
			AND ( (LASTED_HARVEST_DATE='0000:00:00' AND DATEDIFF('".TODAY_DATE."',HARVEST_STARTDATE)>=3))
			GROUP BY GARDEN_ID
			ORDER BY LASTED_HARVEST_DATE ASC , AMOUNT_HIVE DESC, DISTANCE ASC
			 ";
		//echo $sql;
		
		$query = $this->db->query($sql);
		$data= $query->result_array();	
		return $data;
	}
	 public function update($id, $data = array())
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
}

?>