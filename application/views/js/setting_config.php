


<script src="<?php echo base_url() ;?>gentelella-master/vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url() ;?>gentelella-master/vendors/nprogress/nprogress.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/validator/validator.js"></script>
<script src="<?php echo base_url() ;?>gentelella-master/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>


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