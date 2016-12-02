

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
	// start_Date <= EndDateOfMonth And EndDate >=StartDateOfMonth
}

