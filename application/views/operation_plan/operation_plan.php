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
			$content =$th="";
			for($i=0;$i<$period_show+1 ;$i++){ 
				if($i>0){ $content = " +".$i."days";}
				
			
				$date_schedule[date('Y-m-d',strtotime($start_date.$content))]='';
			}

			for($i=0; $i< count($schedule_info['TRANSPORT']); $i++){
				$class_transfer ='';
				$show_date = $schedule_info['TRANSPORT'][$i]['TRANSPORT_DATE'];
				$return_date = $schedule_info['TRANSPORT'][$i]['RETURN_DATE'];
				$garden_name = $schedule_info['TRANSPORT'][$i]['GARDEN_NAME'];
				$flower_name = $schedule_info['TRANSPORT'][$i]['FLOWER_NAME'];
				$status = $schedule_info['TRANSPORT'][$i]['STATUS'];
				
				$class_transfer = $status == 'รอขนย้าย' ?  ' red ': 'green';
				
				$date_schedule[$show_date] .= '<li><a href="'.base_url().'operation_plan/transfer_detail/'.$schedule_info['TRANSPORT'][$i]['TRANSPORT_ID'].'"><i class="fa fa-truck '.$class_transfer .'"> </i>ขนส่ง: '.$garden_name." (".$flower_name.') </a> </li>';
				if(isset($date_schedule[$return_date])){
					$class_transfer = $status == 'ขนกลับเรียบร้อย' ?  ' green ': 'red';
					$date_schedule[$return_date] .= '<li><a href="'.base_url().'operation_plan/transfer_back/'.$schedule_info['TRANSPORT'][$i]['TRANSPORT_ID'].'"><i class="fa fa-truck '.$class_transfer .'"> </i>ขนส่งกลับ: '.$garden_name." (".$flower_name.') </a> </li>';
				}
			}			
			
			for($i=0;$i< count($schedule_info['HARVESTHONEY']) ; $i++){
				$class_harvest='';
				$show_date = $schedule_info['HARVESTHONEY'][$i]['HARVEST_DATE'];
				$garden_name = $schedule_info['HARVESTHONEY'][$i]['GARDEN_NAME'];
				$flower_name = $schedule_info['HARVESTHONEY'][$i]['FLOWER_NAME'];
				$status = $schedule_info['HARVESTHONEY'][$i]['HARVEST_STATUS'];
				$class_harvest = $status == 'รอเก็บน้ำผึ้ง' ?  ' red ': 'green';
				$date_schedule[$show_date] .= '<li><a href="'.base_url().'operation_plan/harvest_detail/'.$schedule_info['HARVESTHONEY'][$i]['HARVEST_ID'].'"><i class="fa fa-forumbee '.$class_harvest .' "> </i>เก็บน้ำผึ้ง: '.$garden_name." (".$flower_name.') </a> </li>';
			}			
			
			?>

<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตารางงานประจำวัน</h2>
			<div class="title_right">
				<div class="col-md-1 col-sm-1 col-xs-12 form-group pull-right top_search">
				  <div class="input-group">
					<a class="btn btn-primary" href="<?php echo base_url()?>operation_plan/edit">แก้ไข</a>
				  </div>
				</div>
			</div>
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
			  <td><ul class="list-task"><?php echo  $value;?></ul></td>
			  </tr>
			<?php
			}
			  ?>
			  
				
		  </tbody>
		</table>
		</div>
	  </div>
	</div>
	
	
  </div>
  </div>
