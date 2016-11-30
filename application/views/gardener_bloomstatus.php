<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตรวจสอบสถานะการแจ้งดอกไม้บาน</h2>
		
		<div class="clearfix"></div>
	  </div>

		<div class="x_content">
			<h3>รายการสถานะแจ้งดอกไม้บาน</h3>
			<span class="section">สวน: <?php echo $garden['NAME']?></span>
			<?php for($i=0;$i<count($blooming_info);$i++){  ?>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<ul>
				<li><strong>ดอกไม้:</strong> <?php echo $blooming_info[$i]['FLOWER_NAME'] ?>
					<ul>
						<li>วันที่: <?php echo $blooming_info[$i]['BLOOMING_STARTDATE']."-".$blooming_info['0']['BLOOMING_ENDDATE'] ?></li>
						<li>สถานะ: <?php echo $blooming_info[$i]['BLOOMING_STATUS'] ?></li>
					</ul>
				</li>
				</ul>
			</div>
	<?php }	 ?>
	  </div>
	</div>
  </div>
  </div>
  
