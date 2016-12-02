

<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตารางรังผึ้งทั้งหมดที่สามารถขนย้ายได้  <?php if(isset($blooming_select)){ echo "เพื่อไปยังสวน ".$blooming_select['NAME'];}?></h2>
		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
	   <form action="<?php echo base_url(); ?>operation_plan/bloom_save" class="form-horizontal form-label-left" method="post" novalidate>
		<span class="section">สวนสาธารณะ</span>
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>สถานที่</th>
			  <th>จำนวนรังผึ้ง<br />ที่ขนได้</th>
<?php 
		if($garden_id >0){  
?>	
			  <th>ระยะทาง</th>  
			  <th>กรอกจำนวน</th>
			  <th>เลือกวันที่ต้องการขนส่ง</th>
		<?php } ?>
			</tr>
		  </thead>


		  <tbody>
		<?php 
		
		for($i=0;$i<count($public_park);$i++){ ?>
		  <tr>
			
			<td><?php echo $public_park[$i]['NAME'];?></td>
			<td><?php echo $public_park[$i]['AMOUNT_HIVE'];?></td>
<?php 
		if($garden_id >0){  
?>
			<td><?php echo isset($public_park[$i]['DISTANCE'])?$public_park[$i]['DISTANCE']:'' ; ?></td>
			<td>
			
			<div class="form-group">
			<select class="form-control" name="amount<?php echo $public_park[$i]['GARDEN_ID'];?>">
				<?php 
				
				for($j=0;$j<=$public_park[$i]['AMOUNT_HIVE'];$j++) { ?>
				<option value="<?php echo $j;?>"><?php echo $j;?></option>
				<?php } ?>
			</select>
			</div>

			</td>
			<td>
			<?php if(isset($blooming_select)){ ?>
				<select class="form-control" name="choose_date<?php echo $public_park[$i]['GARDEN_ID'];?>">
					<?php 
					
						$start_date = TODAY_DATE;
						
						if($blooming_select['BLOOMING_STARTDATE'] > TODAY_DATE){
							
							$start_date = $blooming_select['BLOOMING_STARTDATE'];
						}
						
						for($j=0;$j<5;$j++){
							$date_show = date('Y-m-d ',strtotime($start_date." +".$j."days"));
					?>
					<option value="<?php echo $date_show;?>"><?php echo $date_show;?></option>
						<?php 
						} 
					
					?>
				</select>
			<?php }?>
			</td>
		<?php	
			}
		?>
			</tr>
		<?php } ?>
		  </tbody>
		</table>
	  </div>
	  <div class="x_content">
		<span class="section">สวนสมาชิก</span>
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>สถานที่</th>
			  <th>จำนวนรังผึ้งที่ขนได้</th>
			<?php 
			if($garden_id >0){  
			?>
			  <th>ระยะทาง</th>
		<?php } ?>
			  <th>วันที่ขนส่ง</th>
			  <th>วันที่ขนกลับ</th>
			<?php 
			if($garden_id >0){  
			?>
			  <th>กรอกจำนวน</th>
			  <th>เลือกวันที่ต้องการขนส่ง</th>
			<?php
			} 
			?>
			</tr>
		  </thead>


		  <tbody>
			 <?php 
		if(count($member_park)>0){
			for($i=0;$i<count($member_park);$i++){ ?>
			  <tr>
				
				<td><?php echo $member_park[$i]['NAME'];?></td>
				<td><?php echo $member_park[$i]['AMOUNT_HIVE'];?></td>
			<?php 
			if($garden_id >0){  
			?>

				<td><?php echo isset($member_park[$i]['DISTANCE'])?$member_park[$i]['DISTANCE']:'' ; ?></td>
			<?php } ?>
				<td><?php echo isset($member_park[$i]['TRANSPORT_DATE'])?$member_park[$i]['TRANSPORT_DATE']:'' ; ?></td>
				<td><?php echo isset($member_park[$i]['RETURN_DATE'])?$member_park[$i]['RETURN_DATE']:'' ; ?></td>
			<?php 
			if($garden_id >0){  ?>	
				<td>

				<div class="form-group">
				<select class="form-control" name="amount<?php echo $member_park[$i]['GARDEN_ID'];?>">
					<?php 
					
					for($j=0;$j<=$member_park[$i]['AMOUNT_HIVE'];$j++) { ?>
					<option value="<?php echo $j;?>"><?php echo $j;?></option>
					<?php } ?>
				</select>
				</div>
				</td>
				<td>
				<?php if(isset($blooming_select)){ ?>
				<select class="form-control" name="choose_date<?php echo $public_park[$i]['GARDEN_ID'];?>">
					<?php 
					
						$start_date = TODAY_DATE;
						
						if($blooming_select['BLOOMING_STARTDATE'] > TODAY_DATE){
							
							$start_date = $blooming_select['BLOOMING_STARTDATE'];
						}
						
						for($j=0;$j<5;$j++){
							$date_show = date('Y-m-d ',strtotime($start_date." +".$j."days"));
					?>
					<option value="<?php echo $date_show;?>"><?php echo $date_show;?></option>
						<?php 
						} 
					
					?>
				</select>
			<?php }?>
				</td>
			<?php	
				}
			?>
				</tr>
			<?php } 
		
		}else{
		?>
		<td colspan="8" style="text-align: center;">ไม่มีสวน</td>
		<?php	
		
		}
		?>
		
		  </tbody>
		</table>
	  </div>
	  <?php if($garden_id >0){  ?>
	  <input  class="btn btn-primary submit" type="submit"  value="บันทึกจำนวนรังผึ้งที่ขนย้าย" />
	  <?php }?>
	  </form>
	</div>
	
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตารางแจ้งดอกไม้บาน</h2>
		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
		
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>น้ำผึ้งจากดอกไม้</th>
			  <th>ชื่อสวน</th>
			  <th>จำนวน</th>
			  <th>%ที่ดอกไม้เริ่มบาน</th>
			  <th>วันที่เริ่มต้น</th>
			  <th>วันที่สิ้นสุด</th>
			  <th></th>
			</tr>
		  </thead>


		  <tbody>
		  
		   <?php for($i=0; $i<count($blooming_info);$i++){?>
			<td><?php echo $blooming_info[$i]['FLOWER_NAME']?></td>
			<td><?php echo $blooming_info[$i]['NAME']?></td>
			<td><?php echo $blooming_info[$i]['AMOUNT_HIVE']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_PERCENT']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_STARTDATE']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_ENDDATE']?></td>
			<td><a  class="btn btn-primary" href="<?php echo base_url();?>operation_plan/bloom/<?php echo  $blooming_info[$i]['GARDEN_ID']?>">ค้นหาสวนที่ว่าง</a></td>
		   <?php } ?>
		  </tbody>
		</table>
	  </div>
	</div>
 </div>
</div>
