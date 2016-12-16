

<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>เพิ่มรังผึ้ง</h2>

		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
		  <form action="<?php echo base_url(); ?>setting/save_auto_create_hive" class="form-horizontal form-label-left" method="post" novalidate>
		  <span class="section">สร้างรังผึ้งใหม่</span>

		  <div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount_hive">จำนวนรังผึ้ง<span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input id="amount_hive" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="amount_hive"required="required" type="text">
			</div>
		  </div>
		  <div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="garden_id">สถานที่วางรังผึ้ง<span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">

			  <select class="form-control" name="garden_id" id="garden_id" >
			
				<option value="<?php echo $parks['GARDEN_ID'];?>"><?php echo $parks['NAME'];?></option>
			
			  </select>
			
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				
				<input type="hidden" name="flower_id" value="<?php echo BJP_FLOWER?>" />
			  <button id="send" type="submit" class="btn btn-success">สร้างรังผึ้งใหม่</button>
			  
			</div>
		  </div>
			</form>
	  </div>
	</div>
  </div>
  </div>
