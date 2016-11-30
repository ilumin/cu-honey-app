	<!-- bootstrap-daterangepicker -->
	<script src="<?php echo base_url() ;?>gentelella-master/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url() ;?>gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
 <script>
/*       $(document).ready(function() {
        $('#blooming_date').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        }); */
		
	 $(document).ready(function() {	
		$('#blooming_date').daterangepicker(
			{
				singleDatePicker: true,
				calender_style: "picker_4",
				locale: {
				  format: 'YYYY-MM-DD'
				},
				minDate: '<?php echo $date_start?>',
				maxDate: '<?php echo $date_end?>'
			});
		
		
      });
	  
	  
	  
    </script>