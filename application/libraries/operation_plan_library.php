<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class operation_plan_library {

	public function manage_hive($data = array()){
		
		$hive_array =array();
		$round =0;
		$cap =0;
		$total_hive =0;
		$day =0;
		$start_date ='0000-00-00';
		
			$hive_array= $data['BEE_HIVE_ID']; 
			$round = array($data['ROUND_HARVEST'],$data['ROUND_HARVEST']+1);
			$cap =$data['CAP_HARVEST_HONEY'];
			$total_hive = count($hive_array);
			$day = $data['PERIOD'];
			$start_date = $data['STARTDATE'];
		
		$group_hive = ceil($total_hive /$cap);
		$tmp = 0;
		$count_round = array(0,0);
		$date_show =array();
		for($k=0;$k<count($round);$k++){
			for($i=1;$i<=$group_hive;$i++){
				for($j=1;$j<=floor($day /$round[$k]) ; $j++){
					$start = $i%$round[$k] >0 ?  $i%$round[$k] : $round[$k];
					$tmp =  $start+($j*$round[$k]);
					
					if($tmp <= $day ){
						
						$start_hive = (($i-1)*$cap)+1;
						$end_hive = $i*$cap;
						if($end_hive>$total_hive){
							$end_hive =$total_hive;
						}
						//echo $tmp;
						$date_arr = date('Y-m-d',strtotime($start_date." +".$tmp."days "));
						for($l=$start_hive; $l<$end_hive  ;$l++ ){
							$date_show[$round[$k]][$date_arr][] = $hive_array[$l] ;
							
						}
						
						$count_round[$k]++;
					}
				}
				
			}
		}
		$data_return['round'] = $date_show;
		$data_return['count_round'] = $count_round;
		return $data_return;
	}
}