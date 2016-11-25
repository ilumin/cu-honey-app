	<!-- page content -->
        <div class="right_col" role="main">
          <div style="width: 890px; margin: 0 auto;">
            <div class="page-title">
              <div class="title_left">
                <h3>สมัครสมาชิกชาวสวน</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <a  class="btn btn-primary" href="<?php echo base_url();?>/member/login">กลับไปยังหน้าเข้าสู่ระบบ</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
			
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				   <img width="500"  src="<?php echo base_url().'img/navigator/step2.jpg';?>" />
					<div class="item form-group">
				
					 <h2>กรุณากรอกข้อมูลสวน และ พืชมีดอกที่ปลูกในสวน  <small></small></h2>
					
						
						<form class="form-horizontal form-label-left" novalidate>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<span class="section">ข้อมูลสวน</span>

								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="garden_name">ชื่อสวน<span class="required">*</span>
								</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="garden_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="garden_name"required="required" type="text">
									</div>
								</div>
								<div class="item form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ที่อยู่ <span class="required">*</span>
								</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea id="address" required="required" name="address" class="form-control col-md-7 col-xs-12"></textarea>
									</div>
								</div>
								<span class="section">ข้อมูลพืชมีดอกที่ปลูกในสวน</span>
								<h4 class="red">เลือกพืชที่ปลูกในสวน  (อย่างน้อย 1 รายการ)</h4>
								
							<table class="table">
								  <thead>
									<tr>
									 
									  <th>เลือก</th>
									  <th>จำนวนไร่</th>
									  <th>ปลูกพืชผสมหรือไม่</th>
									  <th>พิชที่ปลูก</th>
									</tr>
								  </thead>
								  <tbody>
							<?php
							$select_plant= '<select name="mix_plant[]" >	<option value="-">เลือกพืชที่ปลูกผสม</option>';
							
							for($i=0; $i<count($flower); $i++){
								
								$select_plant.= '<option value= "'.$i.'">'.$flower[$i]['FLOWER_NAME'].'</option>';
							}
							$select_plant.= '</select  >';
							for($i=0; $i<count($flower); $i++){?>
									<tr>
									  <th scope="row"><label><input name="plant[]" type="checkbox" <?php if($i==1){echo ' data-parsley-mincheck="1" required ';}?> value="<?php echo $flower[$i]['FLOWER_ID'];?>" class="flat">  <?php echo $flower[$i]['FLOWER_NAME']?></label></th>
									  <td><input style="width: 80px;" type="number" id="number" name="number"  data-validate-minmax="5,2000" class="form-control" ></td>
									  <td> <input name="mix[]" type="checkbox" value="mix" class="flat checkbox_check"> ปลูกผสมกับ</td>
									  <td><?php echo $select_plant;?></td>
									</tr>
									
							<?php } ?>
								  </tbody>
								</table>
							  <div class="clearfix"></div>
							<span>**กรณีไม่รายการพืชที่ปลูก กรุณาโทรแจ้งทางผู้เลี้ยงผึ้งได้ที่ <?php echo COMP_TEL;?></span>
							</div>
							
							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-3">
									<button type="submit" class="btn btn-primary">Cancel</button>
									<button id="send" type="submit" class="btn btn-success">สมัครสมาชิก</button>
								</div>
							</div>
						</form>
                      </div>
				    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
                      