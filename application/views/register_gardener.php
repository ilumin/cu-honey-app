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
                    <h2>กรุณากรอกข้อมูลให้ครบทุกช่องเพื่อลงทะเบียนเป็นสมาชิก <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<img width="500"  src="<?php echo base_url().'img/navigator/step1.jpg';?>" />

                    <form action="<?php echo base_url(); ?>member/register_submit" class="form-horizontal form-label-left" method="post" novalidate>
						<div id="step1">

						  <span class="section">ข้อมูลส่วนตัว</span>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ชื่อ<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="firstname" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="firstname"required="required" type="text">
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">นามสกุล<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="lastname" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="lastname"required="required" type="text">
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">อีเมล์ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">เบอร์มือถือโทรติดต่อ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="tel" id="telephone" name="phone" required="required" data-validate-length-range="10,11" class="form-control col-md-7 col-xs-12">
							</div>
						  </div>
						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="province">จังหวัด<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">

								<select id="province" name="province" class="form-control" required="required" >
								  <option value="" selected>--------- เลือกจังหวัด ---------</option>
									<?php for($i=0; $i<count($province); $i++)
									{

							echo  '<option value= "'.$province[$i]['PROVINCE_ID'].'">'.$province[$i]['PROVINCE_NAME'].'</option>';
									}?>
							</select>

							</div>
						  </div>
						  <div class="item form-group">
							<label for="password" class="control-label col-md-3">รหัสผ่าน</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="password" type="password" name="password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required="required">
							</div>
						  </div>
						  <div class="item form-group">
							<label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">ยืนยันรหัสผ่าน</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input id="password2" type="password" name="password2" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
							</div>
						  </div>

						  <div class="item form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">ที่อยู่ <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <textarea id="address" required="required" name="address" class="form-control col-md-7 col-xs-12"></textarea>
							</div>
						  </div>
						 <div class="ln_solid"></div>
						  <div class="form-group">
							<div class="col-md-6 col-md-offset-3">
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


	  $('#wizard').smartWizard();
    </script>
    <!-- /validator -->
