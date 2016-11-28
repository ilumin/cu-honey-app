<div class="row right_col">
<div class="col-md-12 col-sm-12 col-xs-12">

<?php
$hive_id = isset($hive_id) ? $hive_id : null;
$beehive_id = isset($hive->BEE_HIVE_ID) ? $hive->BEE_HIVE_ID : null;
$expired_date = isset($hive->EXPIRED_DATE) ? $hive->EXPIRED_DATE : null;
$start_date = isset($hive->STARTDATE) ? $hive->STARTDATE : null;
$end_date = isset($hive->ENDDATE) ? $hive->ENDDATE : null;
$status = isset($hive->STATUS) ? $hive->STATUS : null;
?>

<?php if(!empty($flash_type)): ?>
  <div class="x_panel">
    <h4><?php echo $flash_type; ?></h4>
    <p><?php echo $flash_message; ?></p>
  </div>
<?php endif; ?>

<form action="<?php echo base_url() . 'setting/hive/' . $hive_id; ?>" class="form-horizontal form-label-left" method="post" novalidate>

  <span class="section">
    <?php echo empty($hive_id) ? 'เพิ่มกล่องรังผึ้ง' : 'แก้ไขข้อมูลกล่องรังผึ้ง'; ?>
  </span>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      รหัสรังผึ้ง<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12" id="hive_id" name="hive_id" required="required" type="text" value="<?php echo $beehive_id; ?>" <?php echo !empty($beehive_id) ? 'readonly disabled' : ''; ?>>
    </div>
  </div>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      รหัสนางพญา
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <?php echo !empty($queen) ? $queen->QUEEN_ID : "-"; ?>
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
      สถานะรังผึ้ง<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <select id="status" name="status" class="form-control" required="required">
        <option value="">เลือกสถานะ</option>
        <option <?php echo $status=='เพาะ' ? 'selected' : ''; ?> value="เพาะ">เพาะ</option>
        <option <?php echo $status=='ว่าง' ? 'selected' : ''; ?> value="ว่าง">ว่าง</option>
        <option <?php echo $status=='เก็บน้ำผึ้ง' ? 'selected' : ''; ?> value="เก็บน้ำผึ้ง">เก็บน้ำผึ้ง</option>
        <option <?php echo $status=='หมดอายุ' ? 'selected' : ''; ?> value="หมดอายุ">หมดอายุ</option>
      </select>
    </div>
  </div>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      วันที่เริ่มต้นสถานะ<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12 input-date" id="start_date" name="start_date" required="required" type="text" value="<?php echo $start_date; ?>">
    </div>
  </div>

  <div class="item form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
      วันที่สิ้นสุดสถานะ<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <input class="form-control col-md-7 col-xs-12 input-date" id="end_date" name="end_date" required="required" type="text" value="<?php echo $end_date; ?>">
    </div>
  </div>

  <div class="ln_solid"></div>

  <div class="form-group">
    <div class="col-md-6 col-md-offset-3">
      <button id="send" type="submit" class="btn btn-success">บันทึก</button>
    </div>
  </div>

</form>

<script src="<?php echo base_url() ;?>gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url() ;?>gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/nprogress/nprogress.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/validator/validator.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/build/js/custom.min.js"></script>

<script>
  // initialize the validator function
  validator.message.date = 'not a real date';

  // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
  $('form')
    .on('blur', 'input[required], input.optional, select.required', validator.checkField)
    .on('change', 'select.required', validator.checkField)
    .on('keypress', 'input[required][pattern]', validator.keypress);

  $('.multi.required').on('keyup blur', 'input', function() {
    validator.checkField.apply($(this).siblings().last()[0]);
  });

  $('form').submit(function(e) {
    e.preventDefault();
    var submit = true;

    // evaluate the form using generic validaing
    if (!validator.checkAll($(this))) {
      submit = false;
    }

    if (submit)
      this.submit();

    return false;
  });

  $('.input-date').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  });

</script>

<?php include 'setting_frame_list.php'; ?>

</div>
</div>
