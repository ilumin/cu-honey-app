<?php if($action == 'form-frame'): ?>
<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php endif; ?>

<?php
$hives = isset($hives) ? $hives : array();
$frame_id = isset($frame_id) ? $frame_id : null;
$beehive_id = isset($frame->BeeHive_BEE_HIVE_ID) ? $frame->BeeHive_BEE_HIVE_ID : null;
$expired_date = isset($frame->EXPIRED_DATE) ? $frame->EXPIRED_DATE : null;
$status = isset($frame->STATUS) ? $frame->STATUS : null;
?>

<?php if(!empty($flash_type)): ?>
  <div class="x_panel">
    <h4><?php echo $flash_type; ?></h4>
    <p><?php echo $flash_message; ?></p>
  </div>
<?php endif; ?>

<form action="<?php echo base_url() . 'setting/frame/' . $frame_id; ?>" class="form-horizontal form-label-left" method="post" novalidate>

  <span class="section">
    <?php echo empty($frame_id) ? 'เพิ่มคอน' : 'แก้ไขข้อมูลคอน'; ?>
  </span>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      รังผึ้ง<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <?php if (isset($hive_id)): ?>
        <input class="form-control col-md-7 col-xs-12" type="text" name="beehive_id" id="beehive_id" value="<?php echo $hive_id; ?>" readonly>
      <?php else: ?>
      <select id="beehive_id" name="beehive_id" class="form-control" required="required">
        <option value="">เลือกรังผึ้ง</option>
        <?php foreach($hives as $hive): $available[] = $hive->BEE_HIVE_ID; ?>
          <option value="<?php echo $hive->BEE_HIVE_ID; ?>" <?php echo $beehive_id==$hive->BEE_HIVE_ID ? 'selected' : ''; ?>><?php echo $hive->BEE_HIVE_ID; ?></option>
        <?php endforeach; ?>
        <?php if (!in_array($beehive_id, $available) && !empty($beehive_id)): ?>
          <option value="<?php echo $beehive_id; ?>" selected><?php echo $beehive_id; ?></option>
        <?php endif; ?>
      </select>
      <?php endif; ?>
    </div>
  </div>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      วันที่หมดอายุ<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12 input-date" id="expired_date" name="expired_date" required="required" type="text" value="<?php echo $expired_date; ?>">
    </div>
  </div>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      สถานะคอน<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <select id="status" name="status" class="form-control" required="required">
        <option value="">เลือกสถานะ</option>
        <option <?php echo $status=='ใช้งาน' ? 'selected' : ''; ?> value="ใช้งาน">ใช้งาน</option>
        <option <?php echo $status=='ว่าง' ? 'selected' : ''; ?> value="ว่าง">ว่าง</option>
        <option <?php echo $status=='ซ่อมแซม' ? 'selected' : ''; ?> value="ซ่อมแซม">ซ่อมแซม</option>
      </select>
    </div>
  </div>

  <div class="ln_solid"></div>

  <div class="form-group">
    <div class="col-md-6 col-md-offset-3">
      <button id="send" type="submit" class="btn btn-success">บันทึก</button>
    </div>
  </div>

</form>


<?php if($action == 'form-frame'): ?>
</div>
</div>
<?php endif; ?>
