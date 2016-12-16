	  <?php
	  //var_dump($harvest_info);
	  
		$date1=date_create($harvest_info['HARVEST_STARTDATE']);
		$date2=date_create($harvest_info['HARVEST_ENDDATE']);
		$diff=date_diff($date1,$date2);
		
		$diff_date = $diff->format("%a");
		
		
	 ?>


<div style="margin:0 auto; border-style: solid; border-width: 5px; width: 700px;padding: 20px;  font-size: 14px; font-family: Tahoma, Geneva, sans-serif;background: white;">
<table style="width: 693px;" >
   <tbody>
      <tr>
         <td style="text-align: center; width: 681px;" colspan="8">
			<div style="text-align: right;"><img width="200" src="<?php echo base_url();?>img/logo.png" alt="logo"/></div>
            <h2 >ใบจ่ายเงิน</h2>
         </td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;">&nbsp;</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align:right;"><strong>ผู้เลี้ยงผึ้ง</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $beekeeper['FIRSTNAME']." ".$beekeeper['LASTNAME']?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px; text-align: right;"><strong>เลขที่</strong></td>
         <td style="width: 93.2px;border-bottom: 1px solid;text-align: center;">59<?php echo sprintf('%03d',$harvest_id);?></td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align:right;"><strong>ที่อยู่</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $beekeeper['ADDRESS'];?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px; text-align: right;"><strong>วันที่</strong></td>
         <td style="width: 93.2px;border-bottom: 1px solid;text-align: center;"><?php echo thai_date(strtotime($harvest_info['HARVEST_ENDDATE']));?></td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align:right;"><strong>เบอร์โทร</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $beekeeper['MOBILE']?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr> 
	  <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align:right;"><strong>อีเมล์</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $beekeeper['EMAIL']?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
	  <tr><td colspan="8" height="5"></td></tr>
	  <tr><td colspan="8"><hr /></td></tr>
	  <tr><td colspan="8" height="5"></td></tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px; text-align: right;"><strong>สวน</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $harvest_info['GARDEN_NAME'].$harvest_info['FLOWER_NAME'];?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px; text-align: right;"><strong>จำนวนรัง</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $harvest_info['COUNT_HIVE'];?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px; text-align: right;"><strong>วันที่วาง</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo thai_date(strtotime($harvest_info['HARVEST_STARTDATE']));?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px; text-align: right;"><strong>วันที่เก็บ</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo thai_date(strtotime($harvest_info['HARVEST_ENDDATE']));?></td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px; text-align: right;"><strong>รวม</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $diff_date; ?> วัน</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px; text-align: right;"><strong>เป็นเงินค่าเช่าสถานที่</strong></td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;border-bottom: 1px solid;"><?php echo $harvest_info['SERVICE_CASH'];?> บาท</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;">&nbsp;</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
	  <tr><td colspan="8" height="5"></td></tr>
	  <tr><td colspan="8"><hr /></td></tr>
	  <tr><td colspan="8" height="5"></td></tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align: center;">ผู้จ่ายเงิน</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 145.2px;text-align: center;" colspan="2">ผู้รับเงิน</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
	  
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align: center;">&nbsp;</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 145.2px;text-align: center;" colspan="2">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
	  
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;border-bottom: 1px solid;">&nbsp;</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 145.2px;border-bottom: 1px solid;" colspan="2">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;text-align: center;">วันที่ (_____/_____/_____)</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 145.2px;text-align: center;" colspan="2">วันที่ (_____/_____/_____)</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 27px;">&nbsp;</td>
         <td style="width: 150px;">&nbsp;</td>
         <td style="width: 24px;">&nbsp;</td>
         <td style="width: 243px;">&nbsp;</td>
         <td style="width: 34px;">&nbsp;</td>
         <td style="width: 52px;">&nbsp;</td>
         <td style="width: 93.2px;">&nbsp;</td>
         <td style="width: 73.8px;">&nbsp;</td>
      </tr>
   </tbody>
</table>
</div>