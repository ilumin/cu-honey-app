<div  class="right_col" role="main">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Annual Plan</h2>

		<div class="clearfix"></div>
	  </div>

		<div class="x_content">
		<form  action="<?php echo base_url(); ?>annual_plan/insert" method="post" >
			<span class="section">Annual Plan <?php echo date('Y', strtotime('+1 year'));?></span>
		  <div class="item">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">ความสามารถในการเก็บน่ำผึ้ง
			</label>
			<div class="col-md-2 col-sm-6 col-xs-12">
				<?php echo $config['CAP_HARVEST_HONEY'];?> รัง
			</div>
		  </div>	
		  <div class="item">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">รอบการเก็บน้ำผึ้ง
			</label>
			<div class="col-md-2 col-sm-6 col-xs-12">
				<?php echo $config['ROUND_HARVEST'];?> รัง
			</div>
		  </div>	
		  <div class="item">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="name">จำนวนรังผึ้ง On Process
			</label>
			<div class="col-md-2 col-sm-6 col-xs-12">
			<?php $hiveonprocess = $config['CAP_HARVEST_HONEY']*$config['ROUND_HARVEST']; ?>
				<input width="30" type="text" name="hive_on_process" value="<?php echo $hiveonprocess;?>" /> 
			</div>
		  </div>	
			
		<div class="clearfix"></div>
	<table id="datatable" class="table table-striped table-bordered">
		<thead>
			<tr>
			  <th rowspan="2">ชื่อสวน</th>
			  <th rowspan="2">จังหวัด</th>
			  <th rowspan="2">พืช</th>
			  <th rowspan="2">จำนวน รังผึ้งที่วาง</th>
			  <th rowspan="2" >ความเสี่ยง น้ำผึ้งผสม</th>
			  <th rowspan="2">พืชใกล้เคียง</th>
			  <th colspan="12">จำนวนรังผึ้งที่คาดว่าจะใช้ในแต่ละเดือน</th>
			</tr>
			<tr>
			  <th><?php echo date('M',strtotime('2017-01-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-02-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-03-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-04-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-05-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-06-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-07-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-08-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-09-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-10-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-11-01'))?></th>
			  <th><?php echo date('M',strtotime('2017-12-01'))?></th>
			</tr>
		  </thead>

		  <tbody>
		 <?php
		$border ="";
		$amount_hive_total  = array();
		$hive_month[1]=0;
		$hive_month[2]=0;
		$hive_month[3]=0;
		$hive_month[4]=0;
		$hive_month[5]=0;
		$hive_month[6]=0;
		$hive_month[7]=0;
		$hive_month[8]=0;
		$hive_month[9]=0;
		$hive_month[10]=0;
		$hive_month[11]=0;
		$hive_month[12]=0;

		$flower_mix="ไม่";
		for($i=0;$i<count($annual_info);$i++){	
			$flower_near= "";
			$html= "";
			$flower_mix="ไม่";
			if($i>0 && ($annual_info[$i]['GARDEN_GARDEN_ID'] == $annual_info[$i-1]['GARDEN_GARDEN_ID'])){
				$annual_info[$i]['NAME']='';
				$border ="";
			}else{
				if($i>0){
					$border = 'class="bor-top"';
				}
			}
			if($annual_info[$i]['FLOWER_NEARBY_ID']>0){
				$flower_near= $flower[$annual_info[$i]['FLOWER_NEARBY_ID']];
			}
			if($annual_info[$i]['RISK_MIX_HONEY']==true){
				$flower_mix = "ใช่";
			}
		?>
		<tr <?php echo $border?>>
			  <td><?php echo $annual_info[$i]['NAME'];?></td>
			  <td><?php echo $annual_info[$i]['PROVINCE_NAME'];?></td>
			  <td><?php echo $annual_info[$i]['FLOWER_NAME'];?></td>
			  <td><?php echo $annual_info[$i]['AMOUNT_HIVE'];?></td>
			  <td><?php echo $flower_mix;?></td>
			  <td><?php echo $flower_near;?></td>
		<?php


			if($annual_info[$i]['BLOOM_START_MONTH'] <= $annual_info[$i]['BLOOM_END_MONTH']){
				
				
				for($j=1; $j<=12; $j++){
					$hive_no= "";
					if($j>=$annual_info[$i]['BLOOM_START_MONTH'] && $j<= $annual_info[$i]['BLOOM_END_MONTH'] ){
						$hive_no = $annual_info[$i]['AMOUNT_HIVE'];
						$hive_month[$j]=$hive_month[$j]+$hive_no;
					}
					$html.= '<td>'.$hive_no.'</td>';
				}
			}
			else {
				
				for($j=1; $j<=12; $j++){
					$hive_no= "";
					if($j<= $annual_info[$i]['BLOOM_END_MONTH'] || $j>= $annual_info[$i]['BLOOM_START_MONTH'] ){
						$hive_no = $annual_info[$i]['AMOUNT_HIVE'];
						$hive_month[$j]=$hive_month[$j]+$hive_no;
					}
					$html.= '<td>'.$hive_no.'</td>';
				}
			}
			echo $html;
		
		?>
			
			</tr>
		<?php } ?>	
		<tr class="bor-top">
		
			<td colspan="6" align="right"><strong>จำนวนรังผึ้งที่คาดว่าจะใช้แต่ละเดือน</strong></td>
			<?php for($i=1; $i<=12;$i++){?>
			<td><strong <?php if($hive_month[$i] < $hiveonprocess){ echo ' class="red" ';} ?>><?php echo $hive_month[$i];?></strong></td>
			<?php } ?>
		</tr>
		  </tbody>
		</table>
		
			<input type="hidden" name= "hive_month" value="<?php echo implode(",",$hive_month);?>">
			<button id="send" type="submit" class="btn btn-success">ยืนยันการสร้าง Annual Plan <?php echo date('Y', strtotime('+1 year'));?></button>
		</form>
		
	  </div>
	</div>
  </div>
  </div>
