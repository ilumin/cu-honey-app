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
						  <div class="item form-group">
							<h4 class="red">พืชมีดอกของคุณ คือ <?php echo $flower_name;?> </h4>
							<label class="control-label col-md-6 col-sm-6 col-xs-12" for="risk"> <?php echo $flower_nearby; ?> จะบานในช่วงเวลา <?php echo date('d/m/Y',strtotime($blooming_startdate));?> ถึง <?php  echo date('d/m/Y',strtotime($blooming_enddate));?> ใช่หรือไม่
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="radio" name="risk" value="yes" checked="checked" /> ใช่
							  <input type="radio" name="risk" value="no" /> ไม่
							</div>
						  </div>
						  
						 <div class="ln_solid"></div>
						  <div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								<input type="hidden" name="blooming_id" value="<?php echo $blooming_id?>"/>
							  <button type="submit" class="btn btn-primary">Cancel</button>
							  <button id="send" type="submit" class="btn btn-success">บันทึกแจ้งดอกไม้บาน</button>
							</div>
						  </div>
					  </div>
							
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
   
