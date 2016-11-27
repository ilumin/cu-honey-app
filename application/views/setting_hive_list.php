<div class="row right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>รายการกล่องรังผึ้ง</h2>

		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>รหัสรังผึ้ง</th>
			  <th>วันที่หมดอายุ</th>
			  <th>สถานะรังผึ้ง</th>
			  <th>วันที่เริ่มต้นสถานะ</th>
			  <th>วันที่สิ้นสุดสถานะ</th>
			</tr>
		  </thead>


		  <tbody>
		  <?php foreach($hives as $hive): ?>
			<tr>
        <td><?php echo $hive->BEEHIVE_ID; ?></td>
        <td><?php echo $hive->EXPIRED_DATE; ?></td>
        <td><?php echo $hive->STATUS; ?></td>
        <td><?php echo $hive->STARTDATE; ?></td>
        <td><?php echo $hive->ENDDATE; ?></td>
			</tr>
    <?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	</div>
</div>
</div>