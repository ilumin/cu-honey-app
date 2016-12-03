<?php if($action == 'form-queen'): ?>
<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php endif; ?>

<?php
$available =array();
$hives = isset($hives) ? $hives : array();
$queen_id = isset($queen_id) ? $queen_id : null;
$beehive_id = isset($queen->BeeHive_BEE_HIVE_ID) ? $queen->BeeHive_BEE_HIVE_ID : null;
$expired_date = isset($queen->EXPIRED_DATE) ? $queen->EXPIRED_DATE : null;
$status = isset($queen->STATUS) ? $queen->STATUS : null;
?>

<?php if(!empty($flash_type)): ?>
  <div class="x_panel">
    <h4><?php echo $flash_type; ?></h4>
    <p><?php echo $flash_message; ?></p>
  </div>
<?php endif; ?>

<form action="<?php echo base_url() . 'setting/queen/' . $queen_id; ?>" class="form-horizontal form-label-left" method="post" novalidate>

  <span class="section">
    <?php echo empty($queen_id) ? 'เพิ่มนางพญา' : 'แก้ไขข้อมูลนางพญา'; ?>
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
      สถานะนางพญา<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <select id="status" name="status" class="form-control" required="required">
        <option value="">เลือกสถานะ</option>
        <option <?php echo $status=='ใช้งาน' ? 'selected' : ''; ?> value="ใช้งาน">ใช้งาน</option>
        <option <?php echo $status=='เพาะ' ? 'selected' : ''; ?> value="เพาะ">เพาะ</option>
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


<?php if($action == 'form-queen'): ?>
</div>
</div>
<?php endif; ?>
