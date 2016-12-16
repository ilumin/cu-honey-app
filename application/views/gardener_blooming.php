	<!-- page content -->
        <div class="right_col" role="main">
          <div style="width: 890px; margin: 0 auto;">
            <div class="page-title">
              <div class="title_left">
                <h3>แจ้งดอกไม้บาน</h3>
              </div>

              
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <div class="x_content">
					

                    <form action="<?php echo base_url(); ?>member/blooming_save" class="form-horizontal form-label-left" method="post" novalidate>
						<div id="step1">
							<?php

							if(count($flower_chosen) >0){
								
							?>
						  <span class="section">กรุณากรอกข้อมูลให้ครบ</span>
							
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="flower">ชื่อสวน
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $garden['NAME'];?>
							 <input type="hidden" name="garden_id"  value="<?php echo $garden['GARDEN_ID']?>" />
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="flower">เลือกพืชที่บาน<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							

								<select class="form-control" name="flower_id" > 
							<?php
								for($i=0;$i<count($flower_chosen);$i++){ 
									?>
									<option value="<?php echo $flower_chosen[$i]['FLOWER_ID'];?>|<?php echo $flower_chosen[$i]['PERIOD_BLOOM_DATE'];?>" ><?php echo $flower_chosen[$i]['FLOWER_NAME'];?></option>
									<?php
								}
							?>
								</select>

							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">เปอร์เซ็นต์การบานรอบนี้ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <select class="form-control" name="percent_blooming" >
							 <?php
								for($i=0;$i<=10;$i++){ 
									?>
									<option value="<?php echo 100-$i*10;?>" ><?php echo 100-$i*10;?>%</option>
									<?php
								}
							?>
							 </select>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">วันที่คาดว่าดอกไม้บาน <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							   <input id="blooming_date" name="blooming_date" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" value="<?php echo TODAY_DATE;?>">
							</div>
						  </div>
						  
						 <div class="ln_solid"></div>
						  <div class="form-group">
							<div class="col-md-6 col-md-offset-3">
							  <button type="submit" class="btn btn-primary">Cancel</button>
							  <button id="send" type="submit" class="btn btn-success">บันทึกแจ้งดอกไม้บาน</button>
							</div>
						  </div>
					  </div>
							<?php	
							} else {
								echo "ไม่มีรายการดอกไม้บานให้เลือก"; 
								
							}
							?>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->



   
