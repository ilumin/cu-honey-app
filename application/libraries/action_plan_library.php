<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class action_plan_library {

        public function summary_hive($data)
        {
			$return_data['TOTAL']=0;
			
			//var_dump($data); exit();
			for($i=0; $i<count($data['HIVE_STATUS']); $i++){
				$return_data[$data['HIVE_STATUS'][$i]['STATUS']] = $data['HIVE_STATUS'][$i]['AMOUNT'];
				$return_data['TOTAL'] += $data['HIVE_STATUS'][$i]['AMOUNT'];
			}
			
			$return_data['EXPIRED'] = $data['HIVE_EXPIRED']['AMOUNT'];
			return $return_data;
        }
		
		public function get_nextmonth($month,$year,$addMonth=0){
			
			$return_date ['month'] = date('m',strtotime(TODAY_DATE));
			$return_date ['year'] = date('Y',strtotime(TODAY_DATE));
			
			if($return_date ['month']+$addMonth > 12){
				$return_date ['month']=($return_date ['month']+ $addMonth)-12;
				$return_date ['year'] = $year+1;
			}else if($return_date ['month']+$addMonth < 1){
				$return_date ['month']=12-$addMonth;
				$return_date ['year'] = $year-1;
			}
			else{
				$return_date ['month']=$return_date ['month']+$addMonth;
				$return_date ['year'] = $year;
				
			}
			
			return $return_date;
		}
}