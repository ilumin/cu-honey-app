<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ย้ายรังผึ้งกลับ </h2>
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
		   <form  action="<?php echo base_url(); ?>operation_plan/save/confirm_move"" method="post" >
			  <span class="section"></span>

			  
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">สวน
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<strong> <?php echo $harvest_info['GARDEN_NAME'];?></strong> :  ดอกไม้<?php echo $harvest_info['FLOWER_NAME'];?>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ที่อยู่สวน
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				 <?php echo $harvest_info['ADDRESS'];?> 
				</div>
			  </div>

			  <div class="clearfix"></div>
				<span class="section">จำนวนรังผึ้งที่ขนกลับทั้งหมด:<?php echo $harvest_info['AMOUNT_HIVE'];?>  </span>
				<div class="x_content">
	   <form action="<?php echo base_url(); ?>operation_plan/save/confirm_back" class="form-horizontal form-label-left" method="post" novalidate>

		<span class="section">สวนสาธารณะปลายทาง</span>
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>สถานที่</th>
			  <th>จำนวนรังผึ้งที่วางขณะนี้</th>
			  <th>จำนวนรังผึ้งที่รองรับ</th>
			  <th>ระยะทางระหว่าง<br />สวนที่เลือก</th>  
			  <th>กรอกจำนวนที่ต้องการขนย้าย</th>
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
				<input type="text" name="amount_hive_move" />
			</td>
			<td>

			</td>
		<?php	
		
			}
		?>
			</tr>
		
		  </tbody>
		</table>
		<strong >จำนวนรังผึ้งรวม <span id="sum_honey" >0</span> รัง</strong>
	  </div>
					<button id="send" type="submit" class="btn btn-success">ยืนยันการขนย้ายรังผึ้งกลับ</button>
					<input type="hidden" name="harvest_id" value="<?php echo $harvest_info['HARVEST_ID']; ?>" />
				  <div class="clearfix"></div>
			 <div class="ln_solid"></div>
			 </div>
			 
			   
			 </div>
		  </div>
		  
		</div>
		
	  </div>
	</div>
  </div>
  </div>
