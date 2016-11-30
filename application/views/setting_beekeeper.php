
<div class="right_col">
    <div class="col-md-12 col-sm-12 col-xs-12">

        <?php if(!empty($flash_type)): ?>
            <div class="x_panel">
                <h4><?php echo $flash_type; ?></h4>
                <p><?php echo $flash_message; ?></p>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url() . 'setting/beekeeper'; ?>" class="form-horizontal form-label-left" method="post" novalidate>
            <span class="section">
                ข้อมูลผู้เลี้ยงผึ้ง
            </span>

            <?php foreach($field as $key => $label): ?>
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        <?php echo $label; ?>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-7 col-xs-12 input-date" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo isset($config[$key]) ? $config[$key] : ''; ?>">
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button id="send" type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </div>
        </form>

    </div>
</div>

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

</script>