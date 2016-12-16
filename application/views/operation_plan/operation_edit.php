<style>
.list-task .fa {
  width: 26px;
  opacity: .99;
  display: inline-block;
  font-family: FontAwesome;
  font-style: normal;
  font-weight: normal;
  font-size: 18px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale; 
 }
#datatable tr th{
	background-color: #d6d1d1;
}
#datatable tr td{
	background-color: #f2eded;
}
#datatable tr.bg-now th{
	background-color: #aae2da;
}
#datatable tr.bg-now td{
	 background-color: #defcf8;

	 
 }
#datatable tr.bg-future th{
	background-color: #eee;
}
#datatable tr.bg-future td{
	 background-color: #fff;

	 
 }
</style>
<?php 
			$data_js=$content =$th="";
			for($i=0;$i<$period_show+1 ;$i++){ 
				if($i>0){ $content = " +".$i."days";}
				
			
				$date_schedule[date('Y-m-d',strtotime($start_date.$content))]='';
			}

			for($i=0; $i< count($schedule_info['TRANSPORT']); $i++){
				$edit_date = $class_transfer ='';
				$show_date = $schedule_info['TRANSPORT'][$i]['TRANSPORT_DATE'];
				$return_date = $schedule_info['TRANSPORT'][$i]['RETURN_DATE'];
				$garden_name = $schedule_info['TRANSPORT'][$i]['GARDEN_NAME'];
				$flower_name = $schedule_info['TRANSPORT'][$i]['FLOWER_NAME'];
				$status = $schedule_info['TRANSPORT'][$i]['STATUS'];
				
				$class_transfer = $status == 'รอขนย้าย' ?  ' red ': 'green';
				if(TODAY_DATE <= $show_date){
					$edit_date = '<div class="pull-left col-md-6 col-sm-6 col-xs-12">
						<label class="control-label col-md-3 col-sm-3 col-xs-12 pull-left">แก้ไขวันที่</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						<input class="form-control input-date pull-left " type="text" name="tranfer_date_'.$schedule_info['TRANSPORT'][$i]['TRANSPORT_ID'].'"  value="'.$show_date.'"/>
						</div>
					</div>';
				}
				$date_schedule[$show_date] .= '
				<div class="pull-left col-md-12 col-sm-12 col-xs-12">
					<div class="pull-left col-md-6 col-sm-6 col-xs-12 list-task ">
						
							<i class="fa fa-truck '.$class_transfer .'"> </i>
								ขนส่ง: '.$garden_name." (".$flower_name.') 
						
					</div>
				'.$edit_date.'
				</div>';
				
				
				if(isset($date_schedule[$return_date])){
					if(TODAY_DATE <= $return_date){
						$edit_date = '
					<div class="pull-left col-md-6 col-sm-6 col-xs-12">
						<label class="control-label col-md-3 col-sm-3 col-xs-12 pull-left">แก้ไขวันที่</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						<input class="form-control input-date pull-left " type="text" name="tranfer_date_'.$schedule_info['TRANSPORT'][$i]['TRANSPORT_ID'].'"  value="'.$return_date.'"/>
						</div>
					</div>';
					}
					$class_transfer = $status == 'ขนกลับเรียบร้อย' ?  ' green ': 'red';
					$date_schedule[$return_date] .= '
				<div class="pull-left col-md-12 col-sm-12 col-xs-12">
					<div class="pull-left col-md-6 col-sm-6 col-xs-12 list-task ">
						
							<i class="fa fa-truck '.$class_transfer .'"> </i>
								ขนส่ง: '.$garden_name." (".$flower_name.') 
						
					</div>
				'.$edit_date.'
				</div>';
				}
			}			
			
			for($i=0;$i< count($schedule_info['HARVESTHONEY']) ; $i++){
				$edit_date = $class_harvest='';
				$show_date = $schedule_info['HARVESTHONEY'][$i]['HARVEST_DATE'];
				$garden_name = $schedule_info['HARVESTHONEY'][$i]['GARDEN_NAME'];
				$flower_name = $schedule_info['HARVESTHONEY'][$i]['FLOWER_NAME'];
				$status = $schedule_info['HARVESTHONEY'][$i]['HARVEST_STATUS'];
				$class_harvest = $status == 'รอเก็บน้ำผึ้ง' ?  ' red ': 'green';
				$bloomming_id = $schedule_info['HARVESTHONEY'][$i]['Blooming_BLOOMING_ID'];
				
				$data_js[$i]['blooming_id'] = $bloomming_id;
				$data_js[$i]['harvest_id'] = "tranfer_date_".$schedule_info['HARVESTHONEY'][$i]['HARVEST_ID'];

				
				if(TODAY_DATE <= $show_date){
					$edit_date = '<div class="pull-left col-md-6 col-sm-6 col-xs-12">
						<label class="control-label col-md-3 col-sm-3 col-xs-12 pull-left">แก้ไขวันที่</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						<input  id="tranfer_date_'.$schedule_info['HARVESTHONEY'][$i]['HARVEST_ID'].'" class=" form-control input-date pull-left " type="text" name="tranfer_date_'.$schedule_info['HARVESTHONEY'][$i]['HARVEST_ID'].'"  value="'.$show_date.'"/>
						b: '.$bloomming_id.'  ,h: '.$schedule_info['HARVESTHONEY'][$i]['HARVEST_ID'].'
						</div>
					</div>';
				}
				$date_schedule[$show_date] .= '
				<div class="pull-left col-md-12 col-sm-12 col-xs-12">
					<div class="pull-left col-md-6 col-sm-6 col-xs-12 list-task ">
						
							<i class="fa fa-forumbee '.$class_harvest .'"> </i>
								เก็บน้ำผึ้ง: '.$garden_name." (".$flower_name.')
						
					</div>
				'.$edit_date.'
				</div>';
			}			
			
			?>

<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตารางงานประจำวัน</h2>
		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
		<div style="width: 900px; height: 500px; overflow: scroll">
		<table id="datatable" class="table table-striped table-bordered">

		  <tbody>
		  
			  
			  <?php

			foreach ($date_schedule as $key => $value) {
				$now='';
			?><tr <?php if($key == TODAY_DATE){echo 'class="bg-now"'; $now=" (now) ";} else if ($key > TODAY_DATE){  echo 'class="bg-future"';}?>>
			
			  <th   ><?php echo date('D d/m/y',strtotime($key)).$now?></th> 
			  <td><?php echo  $value;?></td>
			  </tr>
			<?php
			}
			  ?>
			  
				
		  </tbody>
		</table>
		</div>
	  </div>
	</div>
	<?php echo json_encode($data_js);?>
	
  </div>
  </div>
  <script>
  var obj_json = [<?php echo json_encode($data_js);?>];
  
  </script>
