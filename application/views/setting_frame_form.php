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
      <select id="beehive_id" name="beehive_id" class="form-control" required="required">
        <option value="">เลือกรังผึ้ง</option>
        <?php foreach($hives as $hive): $available[] = $hive->BEE_HIVE_ID; ?>
          <option value="<?php echo $hive->BEE_HIVE_ID; ?>" <?php echo $beehive_id==$hive->BEE_HIVE_ID ? 'selected' : ''; ?>><?php echo $hive->BEE_HIVE_ID; ?></option>
        <?php endforeach; ?>
        <?php if (!in_array($beehive_id, $available) && !empty($beehive_id)): ?>
          <option value="<?php echo $beehive_id; ?>" selected><?php echo $beehive_id; ?></option>
        <?php endif; ?>
      </select>
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
