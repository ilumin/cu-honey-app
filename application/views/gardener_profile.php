<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ข้อมูลสมาชิก</h2>
		<div class="title_right">
			<div class="col-md-2 col-sm-3 col-xs-12 form-group pull-right top_search">
			  <div class="input-group">
				<a  class="btn btn-primary" href="<?php echo base_url();?>member/editprofile">แก้ไข</a>
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
	  </div>
		
	  <div class="x_content">
		
	  <div class="form-horizontal form-label-left" >
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
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">สถานะสวน <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12 red">
							 <?php echo ($garden['STATUS']=='APPROVE')?"อนุมัติ":"รอการอนุมัติ" ?>
							</div>
						  </div>
						  <div class="clearfix"></div>
							<span class="section">ข้อมูลพืชมีดอกที่ปลูกในสวน</span>
							
							<table class="table">
								  <thead>
									<tr>
									 
									  <th>พืชที่ปลูก</th>
									  <th>จำนวนไร่</th>
									  <th>ปลูกพืชผสมหรือไม่</th>
									  <th>พิชที่ปลูกใกล้เคียง</th>
									  
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
											$check_area=$gardenflower[$k]['AREA'];
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
								if($check_plant!=""){
								?>
									<tr>
										<th scope="row">
											<?php echo $flower[$i]['FLOWER_NAME']?>
										</th>
										<td>
										  <?php echo $check_area;?>
										</td>
										<td>
										<?php if($check_mix !=""){?>
											ปลูกผสมกับ
										<?php } ?>
										</td>
									  <td>
									  
									  
									  <?php 
									  //echo $check_mix_plant;
									  
										for($j=0; $j<count($flower); $j++){
											
												if($flower[$j]['FLOWER_ID'] == $check_mix_plant){ echo $flower[$j]['FLOWER_NAME'];}
												
											
										}
									
									  
									  
									  ?>
									  </td>
									 
									</tr>
									
								<?php }
								} ?>
								  </tbody>
								</table>
							  <div class="clearfix"></div>
						 <div class="ln_solid"></div>
						 
					  </div>
					  
                    </div>
		
	  </div>
	</div>
  </div>
  </div>
