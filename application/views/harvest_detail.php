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
				 <?php echo $harvest_info['ADDRESS'];?> 
				</div>
			  </div>
			  
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">สถานะ
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<?php echo $harvest_info['HARVEST_STATUS'];?>
			  </div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">น้ำผึ้งที่เก็บรอบล่าสุด
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<strong class="red"> รวม<?php echo $honey_avg['TOTALHONEY'];?> ลิตร </strong> 	
				<strong class="red"> เฉลี่ย <?php echo number_format($honey_avg['AVGHONEY'],2);?> ลิตร </strong> 	
				<strong class="red"> จากรังผึ้งจำนวน <?php echo $honey_avg['HIVE'];?> รัง </strong> 	
			  </div>
			  </div>
			  
			  
			  
			  
			  <div class="clearfix"></div>
				<span class="section">จำนวนรังผึ้งที่เก็บน้ำผึ้ง</span>
				<a  class="btn btn-primary" href="<?php echo base_url();?>operation_plan/add_hive">เพิ่มรังผึ้ง</a>
				<div  class="col-md-12 col-sm-12 col-xs-4" >
				<table class="table">
					  <thead>
						<tr>
						 
						  <th>เลือกรังผึ้ง (<?php echo count($harvest_hive);?>)</th>
						  <th>วันที่เก็บน้ำผึ้ง<br/> ล่าสุด (รอบที่) </th>
						  <th>%เปรียบเทียบ<br/>กับน้ำผึ้งมากที่สุด </th>
						  <th>ปริมาณน้ำผึ้ง<br/> (ลิตร)</th> 
						  <th>ซ่อมแซม </th>
						  <th>ประเภทซ่อมแซม</th>
						  <th>รหัสคอน (ตามด้วย ,)</th>
						</tr>
					  </thead>
					  <tbody>
				<?php for($i=0;$i<count($harvest_hive);$i++){
						$status = (($harvest_hive[$i]['DATE_DIFF'] >= 3) or ($harvest_hive[$i]['LASTED_HARVEST_DATE'] == '0000-00-00'));
					?>
						<tr>
						<td>
							<label>
				<?php if($status){ ?>
							<input checked="checked" class="flat"  name="hive_select[]" type="checkbox"  data-parsley-mincheck="1"   value="<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']."|".$harvest_hive[$i]['BEEHIVE_BEE_HIVE_ID'] ?>" >
				<?php } ?>  
				<?php echo $harvest_hive[$i]['BEEHIVE_BEE_HIVE_ID'] ?>
							</label>
						</td>
						<td><?php echo $harvest_hive[$i]['LASTED_HARVEST_DATE'] =='0000-00-00'? '-':$harvest_hive[$i]['LASTED_HARVEST_DATE']?> (<?php echo $harvest_hive[$i]['NO_HARVEST']?>)</td>
						<td><?php echo $harvest_hive[$i]['PERCENT_HARVEST']?> % </td>
						
					<?php if($status) { ?>		
						<td >
			
							
							  <input  class="form-control col-md-5 " style="width: 100px;" data-validate-length-range="6" name="honey_amount<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>"  type="text"> 
						
			
						</td>
						<td>
						
	
						
							<label style="float:left;" ><input   data-parsley-mincheck="1" type="checkbox" class=" hive_action" name="fix_<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>" value="yes">ซ่อม</label>

	
						</td>
						<td>
						<div id="fix_form_<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>" class="form-group">
								<select style="width: 150px;" class="form-control col-md-2 col-xs-12 fix_type" name="fix_type<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>" id="fix_type<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>" >
									<option value="0">เลือกประเภท</option>
									<option value="1">เปลี่ยนรังใหม่</option>
									<option value="2">เปลี่ยนคอนใหม่</option>
									<option value="3">เปลี่ยนนางพญาใหม่</option>
								</select>

							</div>
						</td>
						<td>
						
							
								<input class="form-control" type="text" id="remark_<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>"   name="remark_<?php echo $harvest_hive[$i]['HARVESTHONEYITEM_ID']?>" value="" disabled="disabled" />
								
							
						
						</td>
						<?php } ?>
						</tr>
				<?php } ?>
					  </tbody>
					</table>
					
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ต้องการขนรังผึ้งกลับเลยหรือไม่
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				<label for="move_back" >ใช่</label><input type="radio" id="move_back" name="move_back" value="yes"/>
				<label for="move_back" >ไม่</label><input type="radio" id="stay" name="move_back" value="no" checked="checked"/>
				<div id="move_back_park" style="display:none;" >
				<h5>
				 ค่าเช่าพื้นที่ : 
				 <?php
					$date1=date_create($harvest_info['HARVEST_STARTDATE']);
					$date2=date_create(TODAY_DATE);
					$diff=date_diff($date1,$date2);
					
					$diff_date = $diff->format("%a");
					
					$price = (ceil(count($harvest_hive)/10)*$rental_rate)*$diff_date;
					echo $price." บาท";
				 ?>
				 </h5>
				<select  class="form-control "  name="move_back_park"  >
				<option value="-">กรุณาเลือกสวนสาธารณะ</option>
				<?php foreach($garden_move_back as $key =>$value) {?>
					<option value="<?php echo $value['GARDEN_ID'] ?>"><?php echo $value['NAME'] /* ."(".$value['REMAIN_HIVE']."/ ".$value['AMOUNT_HIVE'].") ระยะทางจากสวนถึงสวน ".$value['DISTANCE']." กิโลเมตร " */?></option>
				<?php } ?>
				</select>
				
				</div>
				
			  </div>
			  </div>
					<button id="send" type="submit" class="btn btn-success">ยืนยันการเก็บน้ำผึ้ง</button>
					<input type="hidden" name="harvest_id" value="<?php echo $harvest_info['HARVEST_ID']; ?>" />
					<input type="hidden" name="service_cash" value="<?php echo $price; ?>" />
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
