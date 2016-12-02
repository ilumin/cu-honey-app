<?php 
			$content =$th="";
			for($i=0;$i<$period_show+1 ;$i++){ 
				if($i>0){ $content = " +".$i."days";}
				$th .="<th>". date('D d/m/y',strtotime(TODAY_DATE.$content))."</th> \n";
			
				$date_schedule[date('Y-m-d',strtotime(TODAY_DATE.$content))]='';
			}

			for($i=0; $i< count($schedule_info['TRANSPORT']); $i++){
				$show_date = $schedule_info['TRANSPORT'][$i]['TRANSPORT_DATE'];
				$garden_name = $schedule_info['TRANSPORT'][$i]['GARDEN_NAME'];
				$flower_name = $schedule_info['TRANSPORT'][$i]['FLOWER_NAME'];
				$date_schedule[$show_date] .= '<div><a href="'.base_url().'operation_plan/transfer_detail">ขนส่ง: '.$garden_name." (".$flower_name.') </a> </div>';
			}			
			
			for($i=0;$i< count($schedule_info['HARVESTHONEY']) ; $i++){
				$show_date = $schedule_info['HARVESTHONEY'][$i]['HARVEST_DATE'];
				$garden_name = $schedule_info['HARVESTHONEY'][$i]['GARDEN_NAME'];
				$flower_name = $schedule_info['HARVESTHONEY'][$i]['FLOWER_NAME'];
				$date_schedule[$show_date] .= '<div><a href="">เก็บน้ำผึ้ง: '.$garden_name." (".$flower_name.') </a> </div>';
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
		
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			<?php echo $th;
			
			?>
			</tr>
		  </thead>
		  <tbody>
			  <tr>
			  <?php
			foreach ($date_schedule as $key => $value) {
			?>
			  <td><?php echo  $value;?></td>
			<?php
			}
			  ?>
			  
				</tr>
		  </tbody>
		</table>
	  </div>
	</div>
	
	
  </div>
  </div>
