<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>ANNUAL PLAN</h2>
		<div class="title_right">
			<div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
			  <div class="input-group">
				<a  class="btn btn-primary" href="<?php echo base_url();?>annual_plan/create/">สร้าง Annual Plan ปี <?php echo date('Y', strtotime('+1 year'))?></a>
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
	  </div>

		<div class="x_content">
			<h3>Annual Plan List</h3>
			<span class="section"></span>
			<ul>
			<?php for($i=0;$i<count($annual_list);$i++){  ?>
				<li>Annual Plan ปี <?php echo $annual_list[$i]['ANNUAL_YEAR'] ?>  <a class="btn btn-primary" href="<?php echo base_url()?>annual_plan/view/<?php echo $annual_list[$i]['ANNUAL_YEAR'] ?>"> ดูรายละเอียด</a> </li>
			<?php }	 ?>
		</ul>
	  </div>
	</div>
  </div>
  </div>
  
