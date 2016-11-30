<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">

  <?php if(!empty($flash_type)): ?>
    <div class="x_panel">
      <h4><?php echo $flash_type; ?></h4>
      <p><?php echo $flash_message; ?></p>
    </div>
  <?php endif; ?>

  <div class="x_panel">
    <div class="x_content">
      <?php include 'setting_queen_form.php'; ?>
	  </div>
  </div>

	<div class="x_panel">
	  <div class="x_title">
		<h2>รายการนางพญาผึ้ง</h2>

		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>รหัสนางพญา</th>
			  <th>รหัสรังผึ้ง</th>
			  <th>สถานะนางพญา</th>
        <th>วันที่หมดอายุ</th>
			  <th>&nbsp;</th>
			</tr>
		  </thead>


		  <tbody>
		  <?php foreach($queens as $queen): ?>
			<tr>
        <td><?php echo $queen->QUEEN_ID; ?></td>
        <td><?php echo anchor('/setting/hive/' . $queen->BeeHive_BEE_HIVE_ID, $queen->BeeHive_BEE_HIVE_ID); ?></td>
        <td><?php echo $queen->STATUS; ?></td>
        <td><?php echo $queen->EXPIRED_DATE; ?></td>
        <td>
          <?php echo anchor('setting/queen/' . $queen->QUEEN_ID, 'Edit');?>
        </td>
			</tr>
    <?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	</div>
</div>
</div>
