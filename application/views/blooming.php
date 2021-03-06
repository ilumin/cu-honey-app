

<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
<?php  if(isset($blooming_select)){ ?>
	  <div class="x_title">
		<h2>ตารางรังผึ้งทั้งหมดที่สามารถขนย้ายได้  <?php  echo "เพื่อไปยังสวน ".$blooming_select['NAME'];?> </h2>
		<div class="clearfix"></div>
		<div>จำนวน <?php echo $blooming_select['AMOUNT_HIVE']; ?> รัง  |  เปอร์เซ็นต์การบาน <?php echo $blooming_select['BLOOMING_PERCENT'];?> %</div>
		<div>ตั้งแต่วันที่  <?php echo date('d/m/Y',strtotime($blooming_select['BLOOMING_STARTDATE'])); ?>  ถึง <?php echo date('d/m/Y',strtotime($blooming_select['BLOOMING_ENDDATE']));?></div>

		<div class="clearfix"></div>
	  </div>
<?php } ?>
	  <div class="x_content">
	   <form action="<?php echo base_url(); ?>blooming/bloom_save" class="form-horizontal form-label-left" method="post" novalidate>
<?php 
$has_hive_move = false;
if(count($public_park) > 0 or count($member_park) > 0) { 
		$has_hive_move = true;

?>
		<span class="section">สวนสาธารณะ</span>
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>สถานที่</th>
			  <th>จำนวนรังผึ้ง<br />ที่ขนได้</th>
<?php 
		$garden_id_all='';
		$flower_id_all='';
		if($garden_id >0){  
?>	
			  <th>ระยะทางระหว่าง<br />สวนที่เลือก</th>  
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
			<select class="form-control amount" name="amount<?php echo $public_park[$i]['GARDEN_ID'];?>">
				<?php 
				
				for($j=0;$j<=$public_park[$i]['AMOUNT_HIVE'];$j++) { ?>
				<option value="<?php echo $j;?>"><?php echo $j;?></option>
				<?php } ?>
			</select>
			</div>

			</td>
			<td>
			<?php if(isset($blooming_select)){ ?>
				<select class="form-control tdate" name="choose_date<?php echo $public_park[$i]['GARDEN_ID'];?>">
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
		<?php 
		$garden_id_all .="|".$public_park[$i]['GARDEN_ID'];
		$flower_id_all .="|".$public_park[$i]['FLOWER_ID'];

		} ?>
		  </tbody>
		</table>
		<strong >จำนวนรังผึ้งรวม <span id="sum_honey" >0</span> รัง</strong>
	  </div>
	
	  <?php if($garden_id >0){  ?>
	  <input type="hidden" name="garden_id_all" value="<?php echo isset($garden_id_all)?substr($garden_id_all,1):'';?>" />
	  <input type="hidden" name="flower_id_all" value="<?php echo isset($flower_id_all)?substr($flower_id_all,1):'';?>" />
	  <input type="hidden" name="bloom_id" value="<?php echo isset($blooming_select['BLOOMING_ID'])?$blooming_select['BLOOMING_ID']:'';?>" />
	  
	  <input  class="btn btn-primary submit" type="submit"  value="บันทึกจำนวนรังผึ้งที่ขนย้าย" />
	  <?php }
}else{
?>
<?php	
	
}
	  ?>
	  </form>
	</div>
<?php if( $blooming_id == 0) { ?>	
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
		  
		   <?php 
		   if(count($blooming_info)>0){
		   for($i=0; $i<count($blooming_info);$i++){?>
		   <tr>
			<td><?php echo $flowers[$blooming_info[$i]['DEMAND_FLOWER_ID']]?></td>
			<td><?php echo $blooming_info[$i]['NAME']?></td>
			<td><?php echo $blooming_info[$i]['AMOUNT_HIVE']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_PERCENT']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_STARTDATE']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_ENDDATE']?></td>
			<td><a  class="btn btn-primary" href="<?php echo base_url();?>blooming/index/<?php echo  $blooming_info[$i]['GARDEN_ID']?>">ค้นหาสวนเพื่อนขนย้ายรัง</a>
			
			</td>
			</tr>
		   <?php } 
		   }else{
			?>
			<td colspan="7" style="text-align: center;">ไม่มีการแจ้งดอกไม้บาน</td>
			<?php   
			   
		   }
		   ?>
		  </tbody>
		</table>

	  </div>
	</div>
	
	<?php } ?>
 </div>
 </div>
</div>
