<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
<h3>รายการใบจ่ายเงิน</h3>
<ul>
<?php foreach($harvest_list as $key => $value){?>
	<li>เลขที่ใบจ่ายเงิน : 59<?php echo $value['HARVEST_ID']?> : <?php echo thai_date(strtotime($value['HARVEST_ENDDATE']))?> 
	<a class="btn btn-default" href="<?php echo base_url();?>main/print_po/<?php echo $value['HARVEST_ID'];?>">ดูรายละเอียด</a>
	</li>
<?php } ?>
</ul>



</div>
</div>