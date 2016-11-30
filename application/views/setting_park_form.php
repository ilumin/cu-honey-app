<?php

$name = isset($park_edit['NAME']) ? $park_edit['NAME'] : null;
$address = isset($park_edit['ADDRESS']) ? $park_edit['ADDRESS'] : null;
$province = isset($park_edit['PROVINCE_ID']) ? $park_edit['PROVINCE_ID'] : null;

?>

<form action="<?php echo base_url() . 'setting/publicpark/' . $park_id; ?>" class="form-horizontal form-label-left" method="post" novalidate>

    <span class="section">
        <?php if (isset($park_edit)): ?>
            แก้ไขข้อมูลสวนสาธารณะ
        <?php else: ?>
            เพิ่มข้อมูลสวนสาธารณะ
        <?php endif; ?>
    </span>

    <input type="hidden" name="garbdener_id" value="<?php echo $gardener_id; ?>">

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            ชื่อสวน<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" id="name" name="name" required="required" type="text" value="<?php echo $name; ?>">
        </div>
    </div>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            ที่อยู่สวน<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" id="address" name="address" required="required" type="text" value="<?php echo $address; ?>">
        </div>
    </div>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            จังหวัด<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" id="province" name="province" required="required" type="text" value="<?php echo $province; ?>">
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
