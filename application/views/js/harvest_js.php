<script>
  $('#move_back').click(function() {
     
	 if($(this).is(':checked')){
		 
		$('#move_back_park').show( "slow");
		
	 }
});  
  $('#stay').click(function() {
     
	 if($(this).is(':checked')){
		 
		$('#move_back_park').hide( "slow");
		
	 }
});  


$('.fix_type').change(function(){
	hive_id = $(this).attr('name').substring(8);
	console.log(hive_id);
	if($(this).val() == 2){
		$('#remark_'+hive_id).removeAttr('disabled');
		
	}else{
		$('#remark_'+hive_id).val('');
		$('#remark_'+hive_id).attr('disabled','disabled');
	}
	
});
</script>