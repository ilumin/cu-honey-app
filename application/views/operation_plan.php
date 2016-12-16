

<div class="right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<?php if(isset($transfer_info)){ 
		$total_hive=0;
		$garden=array();
	?>
		<span class="section">งานขนส่งรังผึ้ง</span>
		<table class="table table-striped table-bordered">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>วันที่ขนส่ง</th>
					<th>สถานที่จัดส่ง</th>
					<th>ดอกไม้</th>
					<th>จำนวนรังผึ้ง</th>
					<th>ดูรายละเอียด</th>
				</tr>
			</thead>
			<tbody>
			
			<?php foreach ($transfer_info as $key => $value) { ?>
				<tr>
					<td><?php echo $value['TRANSPORT_DATE'] ?></td>
					<td><?php echo $value['GARDEN_NAME'] ?></td>
					<td><?php echo $value['FLOWER_NAME'] ?></td>
					<td><?php echo $value['AMOUNT_HIVE'] ?></td>
					<td><a class="btn btn-default" href="<?php echo base_url();?>operation_plan/transfer/<?php echo $value['TRANSPORT_ID']?>">ดูรายละเอียด</a></td>
				</tr>
			<?php 
			isset ($garden[$value['GARDEN_ID']])? $garden[$value['GARDEN_ID']]++: $garden[$value['GARDEN_ID']] =1;
				$total_hive = $total_hive+$value['AMOUNT_HIVE'];
			}  
			if(count($transfer_info) ==0){ echo '<tr><td style="text-align: center;" colspan="5">ไม่มีรายการขนส่ง </td></tr>';}
			?>
			<tr>
			<th style="background-color: #eee;" class="red" > รวม</th>
			<th style="background-color: #eee;" class="red" colspan="2">  <?php echo count($garden); ?> สวน</th>
			<th style="background-color: #eee;" class="red" >  <?php echo $total_hive;?>รัง</th>
			<th style="background-color: #eee;" class="red" >  <?php echo ceil($total_hive/$cap);?> ชุดแรงงาน</th>
			</tr>
			</tbody>
		</table>
	<?php } ?>
	<?php if(isset($harvest_info)){ 
		$total_hive=0;
		$garden=array();
	?>
		<span class="section">งานเก็บน้ำผึ้ง</span>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
				<th>น้ำผึ้ง</th>
				<th>สวน</th>
				<th>ที่อยู่</th>
				<th>จำนวนรังผึ้งที่พร้อมเก็บ</th>
				<th>ระยะทางระหว่างสวนและบ้าน</th>
				<th>ดูรายละเอียด</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($harvest_info as $key =>$value) { ?>
				<tr>
				<td><?php echo $flowers[$value['DEMAND_FLOWER_ID']]?></td>
				<td><?php echo $value['GARDEN_NAME']?></td>
				<td><?php echo $value['ADDRESS']?></td>
				<td><?php echo $value['AMOUNT_HIVE']?> รัง</td>
				<td><?php echo $value['DISTANCE']?> กิโลเมตร</td>
				<td><a class="btn btn-default" href="<?php echo base_url();?>operation_plan/harvest/<?php echo $value['HARVEST_ID']?>">ดูรายละเอียด</a></td>
				</tr>
			<?php 
				
				isset ($garden[$value['GARDEN_ID']])? $garden[$value['GARDEN_ID']]++: $garden[$value['GARDEN_ID']] =1;
				$total_hive = $total_hive+$value['AMOUNT_HIVE'];
			} ?>
			<tr>
			<th style="background-color: #eee;" class="red" colspan="1"> รวม</th>
			<th style="background-color: #eee;" class="red" colspan="2">  <?php echo count($garden); ?> สวน</th>
			<th style="background-color: #eee;" class="red" colspan="1">  <?php echo $total_hive;?>รัง</th>
			<th style="background-color: #eee;" class="red" colspan="2">  <?php echo ceil($total_hive/$cap);?> ชุดแรงงาน</th>
			</tr>
			</tbody>
		</table>
		<p class="blue"> กรณีที่รังผึ้งมีจำนวนมากกว่า ความสามารถที่จะเก็บน้ำผึ้ง ให้ผู้เลี้ยงผึ้งเตรียมแรงงานเพื่อเก็บน้ำผึ้งเพิ่ม</p>
	<?php } ?>	
	
	<?php if(isset($hive_fix)){ 
	
		$total_hive=0;
		$garden=array();
	?>
		<span class="section">งานซ่อมรังผึ้ง</span>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>รหัสรังผึ้ง</th>
					<th>ประเภทการซ่อม</th>
					<th>รหัสคอน</th>
					<th>แก้ไข</th>
				</tr>
			</thead>
			<tbody>
												
			<?php 
			
			$type_fix[0] = '-';
			$type_fix[1] = 'เปลี่ยนรังใหม่';
			$type_fix[2] = 'เปลี่ยนคอนใหม่';
			$type_fix[3] = 'เปลี่ยนนางพญาใหม่';
			foreach ($hive_fix as $key => $value) { 
				if($value['TYPE_FIX'] == 1) $url =base_url()."setting/hive/".$value['BeeHive_BEE_HIVE_ID'];
				if($value['TYPE_FIX'] == 2) $url =base_url()."setting/con/".$value['BeeHive_BEE_HIVE_ID'];
				if($value['TYPE_FIX'] == 3) $url =base_url()."setting/queen/".$value['BeeHive_BEE_HIVE_ID'];
			?>
				<tr>
					<td><?php echo $value['BeeHive_BEE_HIVE_ID']?></td>
					<td><?php echo $type_fix[$value['TYPE_FIX']]?></td>
					<td><?php echo $value['REMARK']?></td>
					<td> <a class="btn btn-default" href="<?php echo $url ?>"> ทำการซ่อมแซม </a></td>
				</tr>
			<?php }  
			if(count($hive_fix) ==0){ echo '<tr><td style="text-align: center;" colspan="5">ไม่มีรายการซ่อมแซม </td></tr>';}
			?>
			</tbody>
		</table>
	<?php } ?>
	</div>
 </div>
</div>
