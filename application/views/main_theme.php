

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
			<div class="row tile_count">
				<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
				  <span class="count_top"><i class="fa fa-stack-exchange"></i> จำนวนรังผึ้งรวมทั้งหมด</span>
				  <div class="count"><?php echo $hive_summary['TOTAL'] ?></div>
				</div>
				<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
				  <span class="count_top"><i class="fa fa-clock-o"></i> จำนวนรังผึ้งที่กำลังทำงาน</span>
				  <div class="count blue"><?php echo ($hive_summary['TOTAL']-$hive_summary['เพาะ']) ?></div>
				  
				</div>
			   
				<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
				  <span class="count_top"><i class="fa fa-stack-exchange"></i> รังผึ้งที่กำลังเพาะ</span>
				  <div class="count green"><?php echo $hive_summary['เพาะ'] ?></div>
				</div>
			   
				<div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
				  <span class="count_top"><i class="fa fa-stack-exchange"></i> รังที่หมดอายุเดือนหน้า</span>
				  <div class="count red"><?php echo $hive_summary['EXPIRED'] ?></div>
				</div>
			</div>
 
          <div class="row">
            
            <div class="col-md-8 col-sm-8 col-xs-12">



              <div class="row">


                <!-- Start to do list -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>รายการแจ้งเตือนวันนี้ <small>รายการสวนที่ยังไม่ดอกไม้บาน</small></h2>
                      
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        <ul class="to_do">
						<?php for($i=0; $i<count($todo); $i++ ) {?>
                          <li>
                            <p>
								<?php echo $todo[$i];?></p>
                          </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End to do list -->
                
               
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
