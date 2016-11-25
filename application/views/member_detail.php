

<div class="row right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>รายชื่อชาวสวน</h2>

		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		
	  <form method="post" action="<?php echo base_url();?>main/member_update_flower" class="form-horizontal form-label-left" novalidate>
						<div id="step1">
					   
						  <span class="section">ข้อมูลส่วนตัว</span>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ชื่อ
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $gardener_info['FIRSTNAME'];?>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">นามสกุล
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							   <?php echo $gardener_info['LASTNAME'];?>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">อีเมล์ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							   <?php echo $gardener_info['EMAIL'];?>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">เบอร์มือถือโทรติดต่อ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							   <?php echo $gardener_info['MOBILE_NO'];?>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="province">จังหวัด<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $gardener_info['PROVINCE_NAME']?>

							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ที่อยู่ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $gardener_info['ADDRESS']?>
							</div>
						  </div>
						  <div class="clearfix"></div>
						   <span class="section">ข้อมูลสวน</span>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ชื่อสวน <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $garden['NAME']?>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ที่อยู่ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $garden['ADDRESS']?>
							</div>
						  </div>
						  <div class="clearfix"></div>
							<span class="section">ข้อมูลพืชมีดอกที่ปลูกในสวน</span>
							<h4 class="red">เลือกพืชที่ปลูกในสวน  (อย่างน้อย 1 รายการ)</h4>
							<table class="table">
								  <thead>
									<tr>
									 
									  <th>เลือก</th>
									  <th>จำนวนไร่</th>
									  <th>ปลูกพืชผสมหรือไม่</th>
									  <th>พิชที่ปลูก</th>
									  <th>จำนวนรังผึ้งที่ต้องการวาง</th>
									</tr>
								  </thead>
								  <tbody>
							<?php
							
							for($i=0; $i<count($flower); $i++){?>
									<tr>
									  <th scope="row"><label><input name="plant[]" type="checkbox" <?php if($i==1){echo ' data-parsley-mincheck="1" required ';}?> value="<?php echo $flower[$i]['FLOWER_ID'];?>" class="flat">  <?php echo $flower[$i]['FLOWER_NAME']?></label></th>
									  <td><input style="width: 80px;" type="number"  name="area<?php echo $flower[$i]['FLOWER_ID'];?>"  data-validate-minmax="5,2000" class="form-control" ></td>
									  <td><label><input name="mix<?php echo $flower[$i]['FLOWER_ID'];?>" type="checkbox" value="<?php echo $flower[$i]['FLOWER_ID'];?>" class="flat checkbox_check"> ปลูกผสมกับ</label></td>
									  <td>
									  
									  
									  <?php 
									  
									  $select_plant= '<select name="mix_plant'.$flower[$i]['FLOWER_ID'].'" >	<option value="-">เลือกพืชที่ปลูกผสม</option>';
										for($j=0; $j<count($flower); $j++){
											if($flower[$i]['FLOWER_ID'] != $flower[$j]['FLOWER_ID']  ){
												$select_plant.= '<option value= "'.$flower[$j]['FLOWER_ID'].'">'.$flower[$j]['FLOWER_NAME'].'</option>';
											}
										}
										$select_plant.= '</select  >';
									  echo $select_plant;
									  
									  ?>
									  </td>
									  <td><input style="width: 80px;" type="number" name="amount_hive<?php echo $flower[$i]['FLOWER_ID'];?>"  data-validate-minmax="5,2000" class="form-control"/></td>
									</tr>
									
							<?php } ?>
								  </tbody>
								</table>
							  <div class="clearfix"></div>
						 <div class="ln_solid"></div>
						  <div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								<input type="hidden" name="garden_id" value="<?php echo $garden['GARDEN_ID']?>" />
							  <button type="submit" class="btn btn-primary">Cancel</button>
							  <button id="send" type="submit" class="btn btn-success">ไปยังขั้นตอนถัดไป</button>
							</div>
						  </div>
					  </div>
					  
                    </form>
		
	  </div>
	</div>
  </div>
  </div>
