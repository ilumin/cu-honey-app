
<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>งานที่ต้องทำในวันพรุ่งนี้</h2>
		<div class="title_right">
			<div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
			  <div class="input-group">
				
			  </div>
			</div>
		</div>
		<div class="clearfix"></div>
	  </div>
		<?php //var_dump ($hive_fix); 
		$total_hive_h = 0;
		$total_hive_t = 0;
		$hive_f[1] = 0;
		$hive_f[2] = 0;
		$hive_f[3] = 0;
		$con_arr = $garden_t = $garden_h = array();
		//$total_hive = 0;
		foreach($harvest_info as $key => $value){
			$garden_h[$value['GARDEN_ID']]= $value['AMOUNT_HIVE'];
			$total_hive_h += $value['AMOUNT_HIVE'];
		}
		foreach($transfer_info as $key => $value){
			
			$garden_t[$value['GARDEN_ID']]= $value['AMOUNT_HIVE'];
			$total_hive_t += $value['AMOUNT_HIVE'];
		}
		foreach($hive_fix as $key => $value){
			
			if($value['TYPE_FIX'] ==2){
				$con_arr = explote(',',$value['REMARK']);
				$hive_f[$value['TYPE_FIX']] +=count($con_arr);
			}else{
				$hive_f[$value['TYPE_FIX']]++;
			}
		//	$total_hive_t += $value['AMOUNT_HIVE'];
		}
		?>
	  <div class="x_content">
		
					<ul>
					<?php if($garden_t >0){ ?>
						<li> <strong>งานขนส่งรังผึ้ง </strong>:  สวน <?php echo count($transfer_info);?> จำนวนรังผึ้ง <?php echo $total_hive_t;?> รัง   <a class="btn btn-default" href="<?php echo base_url();?>/operation_plan/task/transfer/tomorrow">ดูรายละเอียด</a></li>
					<?php }
						if($garden_h >0){
					?>
						<li> <strong>งานเก็บเกี่ยวน้ำผึ้ง</strong> :  <?php echo count($garden_h);?> สวน  จำนวนรังผึ้ง <?php echo $total_hive_h;?> รัง  <a class="btn btn-default" href="<?php echo base_url();?>/operation_plan/task/harvest/tomorrow">ดูรายละเอียด</a></li>
					<?php } 
						if(count($hive_fix) >0){
					?>
						<li> <strong>งานซ่อมแซมรังผึ้ง</strong><a class="btn btn-default" href="<?php echo base_url();?>/operation_plan/task/fix/tomorrow">ดูรายละเอียด</a>
							<ul>
								<?php if($hive_f[1] >0){ ?><li><strong>ซื้อกล่องรังใหม่</strong>: จำนวน <?php echo $hive_f[1] ?> รัง  </li><?php } ?>
								<?php if($hive_f[2] >0){ ?><li><strong>ซื้อคอนใหม่</strong>: จำนวน <?php echo $hive_f[2] ?> คอน  </li><?php } ?>
								<?php if($hive_f[3] >0){ ?><li><strong>เพาะนางพญาใหม่</strong>: จำนวน <?php echo $hive_f[3] ?> รัง </li><?php } ?>
							</ul>
						</li>
					<?php } ?>
					</ul>
	  </div>
	</div>
  </div>
  </div>

