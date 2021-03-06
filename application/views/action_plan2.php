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
						<?php for($i=0; $i<count($month_txt); $i++){ ?>
						 <th><?php echo $month_txt[$i]?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<tr>
					  <td class="a-center red">จำนวนรังผึ้งที่ต้องใช้งานในแต่ละเดือน</td>
					   <?php for($i=0; $i<count($bee_annual); $i++){ ?>
						<td class="a-center red"><?php echo $bee_annual[$i] ;?></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่ต้องเปลี่ยนภายในเดือนนี้ <br />(หมดอายุภายในเดือนถัดไป)</td>
					  <?php for($i=0; $i<count($bee_hive_expired); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_hive_expired[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนคอนที่ต้องเปลี่ยนภายในเดือนนี้<br />(หมดอายุภายในเดือนถัดไป)</td>
					  <?php for($i=0; $i<count($bee_con_expired); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_con_expired[$i]['H_AMOUNT']?> รัง  <br/><?php echo $bee_con_expired[$i]['AMOUNT']?>คอน</a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่ต้องนำมาเพาะภายในเดือนนี้<br />(หมดอายุภายในเดือนถัดไป)</td>
					  <?php for($i=0; $i<count($bee_queen_expired); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_queen_expired[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่กำลังเพาะ ( 1 เดือน)</td>
					  <?php for($i=0; $i<count($bee_queen_raise_1month); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_queen_raise_1month[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่กำลังเพาะ ( 2 เดือน)</td>
					  <?php for($i=0; $i<count($bee_queen_raise_2month); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_queen_raise_2month[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังที่เพาะเรียบร้อย</td>
					  <?php for($i=0; $i<count($bee_queen_raise_complete); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_queen_raise_complete[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังผึ้งที่เก็บน้ำผึ้งอยู่</td>
					  <?php for($i=0; $i<count($bee_hive_using); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_hive_using[$i]['AMOUNT']?></a></td>
					  <?php } ?>
					</tr>
					<tr class="bor-top">
					  <td class="a-center ">จำนวนรังผึ้งที่ On Process</td>
					   <?php 
					   
					   for($i=0; $i<count($bee_queen_on_process); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $bee_queen_on_process[$i]?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังผึ้งที่ต้องการเพิ่ม</td>
					<?php 
					   for($i=0; $i<count($need_hive); $i++){ ?>
					  <td class="a-center "><a href="#"><?php echo $need_hive[$i]?></a></td>
					  <?php } ?>
					</tr>
					<tr>
					  <td class="a-center ">จำนวนรังผึ้งที่ต้องเพาะนางพญา</td>
					  <td class="a-center "><a class="red" href="#"><?php echo $need_hive[$i-1]?></a></td>
					  <td class="a-center ">&nbsp;</td>
					  <td class="a-center ">&nbsp;</td>
					  <td class="a-center ">&nbsp;</td>

					</tr>
				</tbody>
		</table>
	  </div>
	</div>
  </div>
  </div>
