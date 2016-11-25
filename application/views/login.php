


  <script>
	$(function() {
		// highlight
		var elements = $("input[type!='submit'], textarea, select");
		elements.focus(function() {
			$(this).parents('div').addClass('highlight');
		});
		elements.blur(function() {
			$(this).parents('div').removeClass('highlight');
		});

			$("#forgotpassword").click(function() {
			$("#password").removeClass("required");
			$("#login").submit();
			$("#password").addClass("required");
			
		});

		$("#login").validate()
	});
	</script>
	<style>
	.fline{
		position: relative;
		width: 100%;
		display: block;
	}
	
	
	#login label.error{
		color: red;
		position: absolute;
		bottom: -25px;
		width: 100%;
		display: block;
	}
	.register_now{
		font-size: 20px;
		font-weight: bold;
		
	}
	.error p{
		color: red;
		
	}
	
	</style>
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class=" form login_form">
          <section class="login_content">
            <form id="login" method="post" action="<?php echo base_url();?>member/check_login" >
              <h1>เข้าสู่ระบบ</h1>
			  <?php  
				if(form_error('username')!="" || form_error('password')!="")
				{
					echo "<div class=\"error\">";
					echo form_error('username');
					echo form_error('password');
					echo "</div>";
				}; 
				  
			?>
              <div class="fline">
                <input name="username" id="username" type="text" class="form-control text required email" placeholder="กรุณากรอกอีเมล์" required=""  />
              </div>
              <div  class="fline">
                <input name="password" id="password" type="password" class="form-control text required" placeholder="กรุณากรอกรหัสผ่าน" required="" />
              </div>
              <div>
				<input  class="btn btn-default submit" type="submit"  value="เข้าสู่ระบบ" />
                <a class="reset_pass"  id="forgotpassword" href="#">คุณลืมรหัสผ่านใช่หรือไม่</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">ต้องการให้เช่าสวน เพื่อนำผึ้งไปวาง 
                  <a href="<?php echo base_url();?>member/register" class="red register_now"  > สมัครเป็นสมาชิก</a> 
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa  fa-forumbee"></i> <?php echo COMP_NAME; ?></h1>
                  <p>©2016 All Rights Reserved. <?php echo COMP_NAME; ?> . Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  
