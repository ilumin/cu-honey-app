<script>

$('.amount').change(function(){
	var sum=0;
	$.each( $('.amount option:selected'), function(  ) {
		sum += parseInt(this.innerHTML);
		
	});
	$('#sum_honey').text(sum);
});

</script>