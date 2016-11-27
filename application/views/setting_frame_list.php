<div class="row right_col">
<div class="col-md-12 col-sm-12 col-xs-12">

  <?php if(!empty($flash_type)): ?>
    <div class="x_panel">
      <h4><?php echo $flash_type; ?></h4>
      <p><?php echo $flash_message; ?></p>
    </div>
  <?php endif; ?>

  <div class="x_panel">
    <div class="x_content">
      <?php include 'setting_frame_form.php'; ?>
	  </div>
  </div>

	<div class="x_panel">
	  <div class="x_title">
		<h2>รายการคอน</h2>

		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>รหัสคอน</th>
			  <th>รหัสรังผึ้ง</th>
			  <th>สถานะคอน</th>
        <th>วันที่หมดอายุ</th>
			  <th>&nbsp;</th>
			</tr>
		  </thead>


		  <tbody>
		  <?php foreach($frames as $frame): ?>
			<tr>
        <td><?php echo $frame->BEEFRAME_ID; ?></td>
        <td><?php echo anchor('/setting/hive/' . $frame->BeeHive_BEE_HIVE_ID, $frame->BeeHive_BEE_HIVE_ID); ?></td>
        <td><?php echo $frame->STATUS; ?></td>
        <td><?php echo $frame->EXPIRED_DATE; ?></td>
        <td>
          <?php echo anchor('setting/frame/' . $frame->BEEFRAME_ID, 'Edit');?>
        </td>
			</tr>
    <?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	</div>
</div>
</div>
