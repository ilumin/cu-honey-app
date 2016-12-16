<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<form  action="<?php echo base_url(); ?>setting/move_hive_save" method="post" >
	<div class="x_panel">
	
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">สวน
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			<select name="parks_move"  class="form-control "  >
			<option value="0">เลือกสวนที่ต้องการย้ายรังผึ้ง</option>
			<?php foreach($parks as $key => $value){ ?>
				<option value="<?php echo $value['GARDEN_ID']; ?>"><?php echo $value['NAME'];?> (<?php echo $remain_hive[$value['GARDEN_ID']]."/".$value['AMOUNT_HIVE']; ?>)</option>
			<?php } ?>
		</select>

			</div>
	  </div>
	<div class="clearfix"></div>
	</div>
<div class="x_panel">	
<div class="rows ">
<span class="section">รายการรังผึ้งในสวนของผู้เลี้ยงผึ้ง</span>
<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>เลือก (<?php echo count($hives);?>รัง)</th>
			  <th>รหัสรังผึ้ง</th>
			  <th>วันที่หมดอายุ</th>
			  <th>สถานะรังผึ้ง</th>
			  <th>จำนวนคอน</th>
			  <th>รหัสนางพญา</th>
			  <th>วันที่เริ่มต้นสถานะ</th>
			  <th>วันที่สิ้นสุดสถานะ</th>
			  <th>สวน</th>
			  <th>ดอกไม้</th>
			</tr>
		  </thead>


		  <tbody>

		  <?php foreach($hives as $key => $hive): ?>
			<tr>
        <td><input checked="checked" class="flat"  name="hive_select[]" type="checkbox"  data-parsley-mincheck="1"   value="<?php echo $hive['BEE_HIVE_ID'] ?>" ></td>
        <td><?php echo $hive['BEE_HIVE_ID']; ?></td>
        <td><?php echo $hive['EXPIRED_DATE']; ?></td>
        <td><?php echo $hive['STATUS']; ?></td>
        <td><?php echo isset($frames[$hive['BEE_HIVE_ID']]) ? $frames[$hive['BEE_HIVE_ID']] : 0; ?></td>
        <td><?php echo isset($queens[$hive['BEE_HIVE_ID']]) ? $queens[$hive['BEE_HIVE_ID']] : "-"; ?></td>
        <td><?php echo $hive['STARTDATE']; ?></td>
        <td><?php echo $hive['ENDDATE']; ?></td>
        <td><?php echo $garden[$hive['GARDEN_GARDEN_ID']]; ?></td>
        <td><?php echo $flower[$hive['FLOWER_FLOWER_ID']]; ?></td>
    
			</tr>
    <?php endforeach; ?>
		  </tbody>
		</table>
</div>	
	<div class="item form-group">
	<br />
	<button id="send" type="submit" class="btn btn-success">ยืนยันการเก็บน้ำผึ้ง</button>
	<input type="hidden" name="garden_id" value="<?php echo $garnden_bkp['GARDEN_ID'];?>" />
	<input type="hidden" name="flower_id" value="<?php echo BJP_FLOWER;?>" />
	</div>
	</form>
	</div>
</div>
</div>	