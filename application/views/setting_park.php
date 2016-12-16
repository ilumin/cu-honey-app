<div class="right_col">
    <div class="col-md-12 col-sm-12 col-xs-12">

        <?php if(!empty($flash_type)): ?>
            <div class="x_panel">
                <h4><?php echo $flash_type; ?></h4>
                <p><?php echo $flash_message; ?></p>
            </div>
        <?php endif; ?>

        <div class="x_panel">
            <div class="x_content">
                <?php include 'setting_park_form.php'; ?>
            </div>
        </div>

        <?php if(isset($park_list)): ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>ข้อมูลสวนสาธารณะ</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>รหัสสวน</th>
                            
                            <th>ชื่อสวน</th>
                            <th>ที่อยู่สวน</th>
                            <th>จังหวัด</th>
                            <th>ดอกไม้</th>
                            <th>จำนวนรังผึ้ง <br />ทีวางได้</th>
                            <th>จำนวนรังผึ้ง<br />ที่วางอยู่</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0;$i<count($parks);$i++){ ?>
                          <tr>
                            <td><?php echo $parks[$i]['GARDEN_ID']; ?></td>

                            <td><?php echo $parks[$i]['NAME']; ?></td>
                            <td><?php echo $parks[$i]['ADDRESS']; ?></td>
                            <td><?php echo $parks[$i]['PROVINCE_NAME']; ?></td>
                              <td><?php echo $parks[$i]['FLOWER_NAME']; ?></td>
                              <td><?php echo $parks[$i]['AMOUNT_HIVE']; ?></td>
                              <td><?php echo ($remain_hive[$parks[$i]['GARDEN_ID']]['REMAIN_HIVE']);?></td>
                            <td>
							<a class="btn btn-default" href="<?php echo base_url();?>/setting/publicpark/<?php echo $parks[$i]['GARDEN_ID'];?>">แก้ไข</a>
							</td>
                            <td><a class="btn btn-default" href="<?php echo base_url();?>main/distancegarden/<?php echo $parks[$i]['GARDEN_ID'];?>/public">กำหนดระยะห่างระหว่างสวน</a></td>
                          </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
