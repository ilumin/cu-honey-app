

<div class="row right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>รายชื่อชาวสวน</h2>
		<div class="title_right">
			<div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
			  <div class="input-group">
				<a  class="btn btn-primary" href="<?php echo base_url();?>main/member_list">กลับไปยังหน้ารายการสมาชิกชาวสวน</a>
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
	  </div>
		
	  <div class="x_content">
		
	  <form method="post" action="<?php echo base_url();?>main/member_update_flower" class="form-horizontal form-label-left" novalidate>
						<div id="step1">
					   
						  <span class="section">ข้อมูลส่วนตัว</span>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">รหัสสมาชิก
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $gardener_info['GARDENER_ID'];?>
							</div>
						  </div>
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
							
							for($i=0; $i<count($flower); $i++){
								$check_plant = "";
								$check_area = "0";
								$check_mix = "";
								$check_mix_plant = "";
								$check_hive_no = 0;
								//get garden flower to show
								for($k=0; $k <count($gardenflower);$k++){
									
									if($flower[$i]['FLOWER_ID'] ==$gardenflower[$k]['Flower_FLOWER_ID'] ){
										$check_plant=' checked="checked" ';
										
										if($gardenflower[$k]['AREA'] !=0 ){
											$check_area=$check_area;
										}
										if($gardenflower[$k]['RISK_MIX_HONEY'] ==1 ){
											$check_mix=' checked="checked" ';
										}
										if($gardenflower[$k]['FLOWER_NEARBY_ID'] !=0){
											$check_mix_plant=$gardenflower[$k]['FLOWER_NEARBY_ID'];
										}
										if($gardenflower[$k]['AMOUNT_HIVE'] !=0 ){
											$check_hive_no=$gardenflower[$k]['AMOUNT_HIVE'];
										}
									}
									
									
								}
								
								?>
									<tr>
										<th scope="row">
											<label><input  name="plant[]" type="checkbox" <?php if($i==1){echo ' data-parsley-mincheck="1" required ';}?> value="<?php echo $flower[$i]['FLOWER_ID'];?>" class="flat" <?php echo $check_plant;?>>  <?php echo $flower[$i]['FLOWER_NAME']?></label>
										</th>
										<td>
										  <input style="width: 80px;" type="number"  name="area<?php echo $flower[$i]['FLOWER_ID'];?>"  data-validate-minmax="5,2000" class="form-control" value="<?php echo $check_area;?>" >
										</td>
										<td>
											<label><input name="mix<?php echo $flower[$i]['FLOWER_ID'];?>" type="checkbox" value="<?php echo $flower[$i]['FLOWER_ID'];?>" class="flat checkbox_check" <?php echo $check_mix;?> > ปลูกผสมกับ</label>
										</td>
									  <td>
									  
									  
									  <?php 
									  //echo $check_mix_plant;
									  $select_plant= '<select name="mix_plant'.$flower[$i]['FLOWER_ID'].'" >	<option value="-">เลือกพืชที่ปลูกผสม</option>';
										for($j=0; $j<count($flower); $j++){
											$selected ="";
											if($flower[$i]['FLOWER_ID'] != $flower[$j]['FLOWER_ID']  ){
												if($flower[$j]['FLOWER_ID'] == $check_mix_plant){ $selected = 'selected ="selected"'; }
												$select_plant.= '<option '.$selected.' value= "'.$flower[$j]['FLOWER_ID'].'">'.$flower[$j]['FLOWER_NAME'].'</option>';
											}
										}
										$select_plant.= '</select  >';
									  echo $select_plant;
									  
									  ?>
									  </td>
									  <td><input style="width: 80px;" type="number" name="amount_hive<?php echo $flower[$i]['FLOWER_ID'];?>"  data-validate-minmax="5,2000" class="form-control" value="<?php echo $check_hive_no;?>"/></td>
									</tr>
									
							<?php } ?>
								  </tbody>
								</table>
							  <div class="clearfix"></div>
						 <div class="ln_solid"></div>
						  <div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								<input type="hidden" name="gardener_id" value="<?php echo $gardener_info['GARDENER_ID'];?>" />
								<input type="hidden" name="garden_id" value="<?php echo $garden['GARDEN_ID'];?>" />
							  <button type="submit" class="btn btn-primary">Cancel</button>
							  <button id="send" type="submit" class="btn btn-success">บันทีกข้อมูลสวน</button>
							</div>
						  </div>
					  </div>
					  
                    </form>
		
	  </div>
	</div>
  </div>
  </div>
