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
					

                    <form action="<?php echo base_url(); ?>member/register_submit" class="form-horizontal form-label-left" method="post" novalidate>
						<div id="step1">

						  <span class="section">กรุณากรอกข้อมูลให้ครบ</span>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" >ชื่อสวน
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							 <?php echo $garden['NAME'];?>
							 <input type="hidden" name="GARDEN_ID"  value="<?php echo $garden['GARDEN_ID']?>" />
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="flower">เลือกพืชที่บาน<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							<?php
							for($i=0; $i<count($flower); $i++){
								
								
							}
							?>
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">เปอร์เซ็นต์การบานรอบนี้ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">วันที่คาดว่าดอกไม้บาน <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
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

                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->



    <!-- jQuery -->
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/validator/validator.js"></script>
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url() ;?>gentelella-master/build/js/custom.min.js"></script>


    <!-- validator -->
    <script>
      // initialize the validator function
      validator.message.date = 'not a real date';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit)
          this.submit();

        return false;
      });


	  
    </script>
    <!-- /validator -->
