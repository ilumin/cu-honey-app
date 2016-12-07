<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ข้อมูลการเก็บน้ำผึ้ง</h2>
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
		   <form  action="<?php echo base_url(); ?>operation_plan/save/harvest"" method="post" >
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
				 <?php echo $harvest_info['ADDRESS'];?> :  <?php echo $harvest_info['FLOWER_NAME'];?>
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">วันที่ทำการเก็บน้ำผึ้ง
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<input class="form-control input-date" type="text" name="harvest_date"  value="<?php echo $harvest_info['HARVEST_DATE'];?>" />
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ปริมาณน้ำผึ้งที่เก็บได้วันนี้
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<div  class="col-md-3 col-sm-3 col-xs-12">
				<input class="form-control " type="text" name="honey_amount"  value="<?php echo $harvest_info['HONEY_AMOUNT'];?>" /></div>ลิตร
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">สถานะ
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<?php echo $harvest_info['HARVEST_STATUS'];?>
			  </div>
			  
			  
			  <div class="clearfix"></div>
				<span class="section">จำนวนรังผึ้งที่เก็บน้ำผึ้ง</span>
				
				<div  class="col-md-4 col-sm-4 col-xs-4" >
				<table class="table">
					  <thead>
						<tr>
						 
						  <th>เลือก (<?php echo count($harvest_hive);?>)</th>
					
						  
						</tr>
					  </thead>
					  <tbody>
				<?php for($i=0;$i<count($harvest_hive);$i++){?>
						<tr>
						<td>
						<?php if($harvest_info['HARVEST_STATUS'] == 'รอเก็บน้ำผึ้ง') {?>
							<label><input checked="checked"  name="hive_select[]" type="checkbox"  data-parsley-mincheck="1"   value="<?php echo $harvest_hive[$i]['BEEHIVE_BEE_HIVE_ID'] ?>" class="flat">  <?php echo $harvest_hive[$i]['BEEHIVE_BEE_HIVE_ID'] ?></label>
						<?php }else{
							$alert_request ='';
							if($harvest_hive[$i]['STATUS'] == 'รอเก็บน้ำผึ้ง') { $alert_request = " <span class=\"red\"> (ยังไม่ได้ทำการเก็บน้ำผึ้ง) </span>";}
						?>
						<label><?php echo $harvest_hive[$i]['BEEHIVE_BEE_HIVE_ID']. $alert_request ?></label>
						<?php		
						}?>
						</td>
						
						</tr>
				<?php } ?>
					  </tbody>
					</table>
					<button id="send" type="submit" class="btn btn-success">ยืนยันการเก็บน้ำผึ้ง</button>
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
