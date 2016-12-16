

        <!-- page content -->
        <div class="right_col" role="main">
			<table class="table">
			<tr>
					<th>ชื่อดอกไม้</th>
					<th>ระยะเวลาการบาน</th>
					<th>เดือนคาดว่าเริ่มต้นบาน</th>
					<th>เดือนคาดว่าสิ้นสุดการบาน</th>
			</tr>
			<?php foreach($flowers as $key => $value) {?>
				<tr>
					<td><?php echo $value['FLOWER_NAME']?></td>
					<td><?php echo $value['PERIOD_BLOOM_DATE']?></td>
					<td><?php echo $value['BLOOM_START_MONTH']?></td>
					<td><?php echo $value['BLOOM_END_MONTH']?></td>
				</tr>
			<?php } ?>
			</table>
        </div>
        <!-- /page content -->
