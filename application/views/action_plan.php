<div class="right_col" > 
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2><i>Action Plan</i>  <small class="red">(NOW: <?php echo date('d-M-Y',strtotime(TODAY_DATE));?>)</small></h2>
		
		<div class="clearfix"></div>
	  </div>

		<div class="x_content">
			<div class="row tile_count">
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-stack-exchange"></i> จำนวนรังผึ้งรวมทั้งหมด</span>
              <div class="count"><?php echo $hive_summary['TOTAL'] ?></div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> รังที่สถานะว่าง</span>
              <div class="count blue"><?php echo ($hive_summary['ว่าง']) ?></div>
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
			<p>กรุณาคลิกตัวเลขด้านล่างเพื่อเข้าไปดู รายละเอียด</p>
			<table  class="table table-striped jambo_table bulk_action">
				<thead>
					<tr class="headings" >
					  <th>งาน</th>
						<?php 
						$show=1;
						
						for($i=0; $i<$show; $i++){ ?>
						 <th><?php echo $month_txt[$i]?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					
					<tr>
					  <td class="a-center ">งานเปลี่ยนรังผึ้งใหม่ภายในเดือนนี้ จำนวน <br />(หมดอายุภายในเดือนถัดไป)</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_hive_expired/<?php echo $bee_hive_expired_y[$i]."/".$bee_hive_expired_m[$i] ?>"><?php echo $bee_hive_expired[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">งานเปลี่ยนคอนใหม่ภายในเดือนนี้ จำนวน<br />(หมดอายุภายในเดือนถัดไป)</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_con_expired/<?php echo $bee_con_expired_y[$i]."/".$bee_con_expired_m[$i] ?>"><?php echo $bee_con_expired[$i]['H_AMOUNT']?> รัง  <br/><?php echo $bee_con_expired[$i]['AMOUNT']?>คอน</a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">งานเพาะรังผึ้งภายในเดือนนี้<br />(หมดอายุภายในเดือนถัดไป)</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_queen_expired/<?php echo $bee_queen_expired_y[$i]."/".$bee_queen_expired_m[$i] ?>"><?php echo $bee_queen_expired[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					
					<tr>
					  <td class="a-center ">งานเพาะรังใหม่เพิ่ม สำหรับเดือน <?php echo $month_txt[count($month_txt)-1]?> </td>
					  <td class="a-center red"><?php echo $need_hive[count($need_hive)-1]?></td>

					</tr>
				</tbody>
		</table>
		
			<table  class="table table-striped jambo_table bulk_action">
				<thead>
					<tr class="headings" >
					  <th>ผลที่คาดจะได้รับสิ้นเดือน</th>
						<?php 
						$show=1;
						
						for($i=0; $i<$show; $i++){ ?>
						 <th><?php echo $month_txt[$i]?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<tr>
					  <td class="a-center red">จำนวนรังผึ้งที่ต้องใช้งานในเดือนนี้</td>
					   <?php for($i=0; $i<$show; $i++){ ?>
						<td class="a-center red"><?php echo $bee_annual[$i] ;?></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่กำลังเพาะ ( 1 เดือน)</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_queen_raise/<?php echo $bee_queen_raise_1month_y[$i]."/".$bee_queen_raise_1month_m[$i] ?>"><?php echo $bee_queen_raise_1month[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่กำลังเพาะ ( 2 เดือน)</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_queen_raise/<?php echo $bee_queen_raise_2month_y[$i]."/".$bee_queen_raise_2month_m[$i] ?>"><?php echo $bee_queen_raise_2month[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่เพาะเรียบร้อย</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_queen_ready/<?php echo $bee_queen_raise_complete_y[$i]."/".$bee_queen_raise_complete_m[$i] ?>"><?php echo $bee_queen_raise_complete[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังผึ้งที่เก็บน้ำผึ้งอยู่</td>
					  <?php for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><a href="<?php echo base_url();?>action_plan/bee_hive_using/<?php echo $bee_hive_using_y[$i]."/".$bee_hive_using_m[$i] ?>""><?php echo $bee_hive_using[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr class="bor-top">
					  <td class="a-center ">จำนวนรังผึ้งที่ On Process</td>
					   <?php 
					   
					   for($i=0; $i<$show; $i++){ ?>
					  <td class="a-center "><?php echo $bee_queen_on_process[$i]?></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังผึ้งที่ต้องการเพิ่ม</td>
					<?php 
					   for($i=0; $i<$show; $i++){ 
					   
					   ?>
					  <td class="a-center "><a href="#"><?php echo $need_hive[$i]?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">งานเพาะรังใหม่เพิ่ม สำหรับเดือน <?php echo $month_txt[count($month_txt)-1]?></td>
					  <td class="a-center "><a class="red" href="#"><?php echo $need_hive[count($need_hive)-1]?></a></td>

					</tr>
				</tbody>
		</table>
		
	  </div>
	</div>
  </div>
  </div>
