<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ข้อมูลขนย้ายรังผึ้ง</h2>
		<div class="title_right">
			<div class="col-md-2 col-sm-3 col-xs-12 form-group pull-right top_search">
			  <div class="input-group">
				<a  class="btn btn-primary" href="javascript: window.history.back();">BACK</a>
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
	  </div>
		
	  <div class="x_content">
		
	  <div class="form-horizontal form-label-left" >
			<div id="step1">
		   <form  action="<?php echo base_url(); ?>operation_plan/save/transfer" method="post" >
			  <span class="section"></span>

			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">จากสวน
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<strong> <?php echo $garden_info['NAME'];?> </strong> :  ดอกไม้<?php echo $garden_info['FLOWER_NAME'];?>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ที่อยู่ สวนต้นทาง
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				 <?php echo $garden_info['ADDRESS']?>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ไปยังสวน
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<strong> <?php echo $transport_info['GARDEN_NAME'];?></strong> :  ดอกไม้<?php echo $transport_info['FLOWER_NAME'];?>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ที่อยู่สวนปลายทาง
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				 <?php echo $transport_info['ADDRESS'];?> :  <?php echo $transport_info['FLOWER_NAME'];?>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">วันที่ขนย้าย
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<input class="form-control input-date" type="text" name="start_date" value="<?php echo $transport_info['TRANSPORT_DATE'];?> ">
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">วันที่ขนกลับ
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<input class="form-control input-date" type="text" name="end_date" value="<?php echo $transport_info['RETURN_DATE'];?> ">
				</div>
			  </div>
			  
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">สถานะ
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<?php echo $transport_info['STATUS'];?> 
				</div>
			  </div>
			  
			  
			  <div class="clearfix"></div>
				<span class="section">จำนวนรังผึ้งที่ต้องการขนย้าย</span>
				
				<div  class="col-md-4 col-sm-4 col-xs-4" >
				<table class="table">
					  <thead>
						<tr>
						 
						  <th>รายการรังผึ้ง</th>
					
						  
						</tr>
					  </thead>
					  <tbody>
				<?php for($i=0;$i<count($transport_hive);$i++){?>
						<tr>
						<td>
							<label><?php if( $transport_info['STATUS'] =='รอขนย้าย') {  ?><input checked="checked"  name="hive_select[]" type="checkbox"  data-parsley-mincheck="1" required  value="<?php echo $transport_hive[$i]['BEEHIVE_BEE_HIVE_ID'] ?>" class="flat"> <?php  } ?> <?php echo $transport_hive[$i]['BEEHIVE_BEE_HIVE_ID'] ?></label>
						</td>
						
						</tr>
				<?php } ?>
					  </tbody>
					</table>
					<?php if( $transport_info['STATUS'] =='รอขนย้าย') {  ?>
					<button id="send" type="submit" class="btn btn-success">ยืนยันการขนย้าย</button>
					<input type="hidden" name="transport_id" value="<?php echo $transport_info['TRANSPORT_ID'];?>" />
					<a class="btn btn-danger" href="">ยกเลิกการขนย้าย</a>
					<?php  } ?>
				  <div class="clearfix"></div>
			 <div class="ln_solid"></div>
			 </div>
			
			   </form> 
			 </div>
		  </div>
		  
		</div>
		
	  </div>
	</div>
  </div>
  </div>
