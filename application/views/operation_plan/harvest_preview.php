

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="x_content">
		  
			<form method="post" action="<?php echo base_url();?>main/distance_save" class="form-horizontal form-label-left" novalidate>
				<div id="step1">
			   
				  <span class="section">วางแผนเก็บน้ำผึ้ง</span>
				  <div>ความสามารถเก็บน้ำผึ้ง:<?php echo $manage['CAP_HARVEST_HONEY']?></div>
				  <div>รอบการเก็บน้ำผึ้ง ทุกๆ:<?php echo $manage['ROUND_HARVEST']?>วัน</div>
				  <div>จำนวนรังผึ้ง <?php echo count($manage['BEE_HIVE_ID'])?>รัง</div>
				  <div>วันที่ขนส่ง <?php echo $manage['STARTDATE']?>วัน</div>
				  <div>ระยะเวลาการวางรังผึ้ง <?php echo $manage['PERIOD']?>วัน</div>
				  <?php //var_dump($hive_info);
				  
				  foreach ($hive_info['round'] as $round => $value){
					  echo '<input type="checkbox"/><h3>เก็บน้ำผึ้งทุกๆ : '.$round.' วัน</h3>';
					  echo "<ul>";
					  ksort($value);
					  foreach($value as $date =>$hive_array){
						 echo "<li>วันที่ $date: รหัสรังผึ้ง ";
						 $show = implode(',',$hive_array);
						 echo ": $show</li>";
						  
					  }
					  echo "</ul>";
				  }
				  ?>
					
				<div class="form-group">
				<div class="col-md-6 col-md-offset-3">
					<label class="control-label col-md-6 col-sm-6 col-xs-12" for="name"></label>

				  <button id="send" type="submit" class="btn btn-success">บันทึก</button>
				  
				</div>
				</div>
			</form>
		  </div>
        </div>
        <!-- /page content -->
