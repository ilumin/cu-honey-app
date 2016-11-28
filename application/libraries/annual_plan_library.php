<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class annual_plan_library {

        public function summary_hive_month($annual_info,$hive_max)
        {
			$hive_no= 0;

			$hive_month =array();
			$hive_onprocess =array();
			$hive_month[1]=0;
			$hive_month[2]=0;
			$hive_month[3]=0;
			$hive_month[4]=0;
			$hive_month[5]=0;
			$hive_month[6]=0;
			$hive_month[7]=0;
			$hive_month[8]=0;
			$hive_month[9]=0;
			$hive_month[10]=0;
			$hive_month[11]=0;
			$hive_month[12]=0;
			
			for($i=0;$i<count($annual_info);$i++){
				
				if($annual_info[$i]['BLOOM_START_MONTH'] <= $annual_info[$i]['BLOOM_END_MONTH']){
					
					
					for($j=1; $j<=12; $j++){
						$hive_no= 0;
						if($j>=$annual_info[$i]['BLOOM_START_MONTH'] && $j<= $annual_info[$i]['BLOOM_END_MONTH'] ){
							$hive_no = $annual_info[$i]['AMOUNT_HIVE'];
							if(isset($hive_month[$j]) ==false){$hive_month[$j] =0;}
							if(isset($hive_onprocess[$j]) ==false){$hive_onprocess[$j] =0;}
							$hive_month[$j]=$hive_month[$j]+$hive_no;
						}
						
					}
				}
				else {
					
					for($j=1; $j<=12; $j++){
						$hive_no= 0;
						if($j<= $annual_info[$i]['BLOOM_END_MONTH'] || $j>= $annual_info[$i]['BLOOM_START_MONTH'] ){
							$hive_no = $annual_info[$i]['AMOUNT_HIVE'];
							if(isset($hive_month[$j]) ==false){$hive_month[$j] =0;}
							if(isset($hive_onprocess[$j]) ==false){$hive_onprocess[$j] =0;}
							$hive_month[$j]=$hive_month[$j]+$hive_no;
						}
						
					}
				}
			}
			$hive_onprocess = $hive_month ;
			
			for($i=1; $i<=12; $i++){
				
				if($hive_month[$i] >=$hive_max){
					$hive_onprocess[$i]=$hive_max;
				}
			}
			
			$return_data['hive_month']= $hive_month;
			$return_data['hive_process_month']= $hive_onprocess;
			return $return_data;
        }
}