<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตารางรังผึ้งทั้งหมดที่ขนได้</h2>

		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
		
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>สถานที่</th>
			  <th>ระยะทาง</th>
			  <th>จำนวนรังผึ้งที่ขนได้</th>
			  <th>ประเภทสวน</th>
			  <th>วันที่เริ่มต้น</th>
			  <th>วันที่สิ้นสุด</th>
			</tr>
		  </thead>


		  <tbody>
			  <tr>
			 
				  <td>ddddddd</td>
				  <td>40</td>
				  <td>60</td>
				  <td>สวนสมาชิก</td>
				  <td>20 NOV 2016</td>
				  <td>24 NOV 2016</td>
			
				</tr>
		  </tbody>
		</table>
	  </div>
	</div>
	
	<div class="x_panel">
	  <div class="x_title">
		<h2>ตารางแจ้งดอกไม้บาน</h2>
		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
		<span class="section"> จำนวนรังผึ้งคงเหลือ  45 รัง</span>
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>น้ำผึ้งจากดอกไม้</th>
			  <th>ชื่อสวน</th>
			  <th>จำนวน</th>
			  <th>%ที่ดอกไม้เริ่มบาน</th>
			  <th>วันที่เริ่มต้น</th>
			  <th>วันที่สิ้นสุด</th>
			  <th></th>
			</tr>
		  </thead>


		  <tbody>
		  
		   <?php for($i=0; $i<count($blooming_info);$i++){?>
			<td><?php echo $blooming_info[$i]['FLOWER_NAME']?></td>
			<td><?php echo $blooming_info[$i]['NAME']?></td>
			<td><?php echo $blooming_info[$i]['AMOUNT_HIVE']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_PERCENT']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_STARTDATE']?></td>
			<td><?php echo $blooming_info[$i]['BLOOMING_ENDDATE']?></td>
			<td><a  class="btn btn-primary" href="<?php echo base_url();?>main/member_list">ค้นหาสวนที่ว่าง</a></td>
		   <?php } ?>
		  </tbody>
		</table>
	  </div>
	</div>
 </div>
</div>
