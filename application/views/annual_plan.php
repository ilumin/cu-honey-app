

<div class="row right_col">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>รายชื่อชาวสวน</h2>

		<div class="clearfix"></div>
	  </div>

	  <div class="x_content">
		
		<table id="datatable" class="table table-striped table-bordered">
		  <thead>
			<tr>
			  <th>รหัส</th>
			  <th>ชื่อ-นามสกุล</th>
			  <th>สถานะ</th>
			  <th>ที่อยู่</th>
			  <th>เบอร์โทร</th>
			  <th>อีเมล์</th>
			  <th>วันที่สมัคร</th>
			</tr>
		  </thead>


		  <tbody>
		  <?php for ($i=0; $i <count($gardener_list);$i++){?>
			<tr>
			  <td><?php echo $gardener_list[$i]['GARDENER_ID']?></td>
			  <td><a href="<?php echo base_url();?>main/member_detail/<?php echo $gardener_list[$i]['GARDENER_ID']?>"><?php echo $gardener_list[$i]['FIRSTNAME']." ".$gardener_list[$i]['LASTNAME']?></a></td>
			  <td><?php echo $gardener_list[$i]['STATUS']?></td>
			  <td><?php echo $gardener_list[$i]['province_name']?></td>
			  <td><?php echo $gardener_list[$i]['MOBILE_NO']?></td>
			  <td><?php echo $gardener_list[$i]['EMAIL']?></td>
			  <td><?php echo date("D d M y H:i:s",strtotime($gardener_list[$i]['REGISTER_DATE']))?></td>
			  <td><a href="<?php echo base_url();?>main/member_detail/<?php echo $gardener_list[$i]['GARDENER_ID']?>">ดูรายละเอียด</a></td>
			</tr>
		  <?php } ?>
		  </tbody>
		</table>
	  </div>
	</div>
  </div>
  </div>
