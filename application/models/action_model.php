

<?php

class action_model extends CI_Model {
	public function __construct()	{
	  $this->load->database(); 
	}
	
	public function summary_hive(){
		$sql = "SELECT H.STATUS, COUNT(BEE_HIVE_ID) AS AMOUNT FROM beehive AS H GROUP BY STATUS";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	public function bee_hive_expired($month,$year){
		$sql = "SELECT count(bee_hive_id) as AMOUNT FROM beehive where month(expired_date)=".$month." AND year(expired_date)= ".$year;
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}
	public function bee_con_expired($month,$year){
		$sql = "SELECT count(BEEFRAME_ID) as AMOUNT,count(distinct(BEEHIVE_BEE_HIVE_ID)) as H_AMOUNT FROM beeframe where month(expired_date)=".$month." AND year(expired_date)= ".$year;
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}
	public function bee_queen_expired($month,$year){
		$sql = "SELECT count(QUEEN_ID)as AMOUNT FROM queenbee where month(expired_date)=".$month." AND year(expired_date)= ".$year;
		$query = $this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}
	public function bee_hive_using($status="เก็บน้ำผึ้ง",$month,$year){
		$sql="SELECT count(bee_hive_id) as AMOUNT FROM beehive WHERE STATUS='".$status."'AND MONTH(STARTDATE) = ".$month." AND ".$month." <= MONTH(ENDDATE) AND YEAR(STARTDATE) =".$year;
		$query =$this->db->query($sql);
		$data = $query->row_array();
		return $data;
	}
	
	
	//งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้
	public function bee_hive_expired_list($month,$year){
		$sql = "SELECT bee_hive_id FROM beehive where month(expired_date)=".$month." AND year(expired_date)= ".$year;
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	//งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้
	public function bee_hive_expired_save($hive_list,$date_save){
		if(count($hive_list)>0){
			for($i=0;$i<count($hive_list);$i++){
				$update['EXPIRED_DATE'] = $date_save;
				$this->db->where('BEE_HIVE_ID', intval($hive_list[$i]));
				
				
				$check[$i]= $this->db->update('beehive', $update);
			}
		}
		return true;
	}
	//งานเปลี่ยนคอนใหม่ภายในเดือนนี้
	public function bee_con_expired_list($month,$year){
		$sql = "SELECT BEEFRAME_ID AS id,BEEHIVE_BEE_HIVE_ID AS parent_id FROM beeframe where month(expired_date)=".$month." AND year(expired_date)= ".$year;
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	//งานเปลี่ยนคอนใหม่ภายในเดือนนี้
	public function bee_con_expired_save($con_list,$date_save){
		if(count($con_list)>0){
			for($i=0;$i<count($con_list);$i++){
				$update['EXPIRED_DATE'] = $date_save;
				$this->db->where('BEEFRAME_ID', intval($con_list[$i]));
				
				
				$check[$i]= $this->db->update('beeframe', $update);
			}
		}
		return true;
	}
	//งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้
	public function bee_queen_expired_list($month,$year){
		$sql = "SELECT BEEHIVE_BEE_HIVE_ID AS parent_id, QUEEN_ID AS id FROM queenbee where month(expired_date)=".$month." AND year(expired_date)= ".$year;
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	//งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้
	public function bee_queen_expired_save($hive_list,$date_save){
		if(count($hive_list)>0){
			for($i=0;$i<count($hive_list);$i++){
				//สถานะเพาะ รังผึ้ง วันหมดอายุของนางพญา + 1 ปี
				$update['EXPIRED_DATE'] = $date_save;
				$update['STATUS'] = 'เพาะ';
				$this->db->where('Beehive_BEE_HIVE_ID', intval($hive_list[$i]));
								
				$check[$i]= $this->db->update('queenbee', $update);
				
				
			}
		}
		return true;
	}
	//งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้
	public function bee_hive_raise_save($hive_list,$start_date,$end_date){
		if(count($hive_list)>0){
			for($i=0;$i<count($hive_list);$i++){
				//สถานะเพาะ รังผึ้ง วันหมดอายุของนางพญา + 1 ปี
				$update['STARTDATE'] = $start_date;
				$update['ENDDATE'] = $end_date;
				$update['STATUS'] = 'เพาะ';
				$this->db->where('BEE_HIVE_ID', intval($hive_list[$i]));
								
				$check[$i]= $this->db->update('beehive', $update);
				
				
			}
		}
		return true;
	}
	//งานเพาะรังผึ้งภายในเดือนนี้

	// จำนวนรังที่กำลังเพาะ ( 1 เดือน)
    public function bee_queen_raise($status, $month, $year)
    {
        $sql = "SELECT bee_hive_id AS id FROM beehive WHERE STATUS='".$status."'AND MONTH(STARTDATE) = ".$month." AND ".$month." <= MONTH(ENDDATE) AND YEAR(STARTDATE) =".$year;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

	// จำนวนรังที่กำลังเพาะ ( 2 เดือน)

	public function bee_hive_using_list($status="เก็บน้ำผึ้ง",$month,$year){
		$sql="SELECT count(bee_hive_id) as AMOUNT FROM beehive WHERE STATUS='".$status."'AND MONTH(STARTDATE) = ".$month." AND ".$month." <= MONTH(ENDDATE) AND YEAR(STARTDATE) =".$year;
		$query =$this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}

	// start_Date <= EndDateOfMonth And EndDate >=StartDateOfMonth
}

