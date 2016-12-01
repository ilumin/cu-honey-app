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
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parks as $park): ?>
                          <tr>
                            <td><?php echo $park->GARDEN_ID; ?></td>
                            <td><?php echo $park->NAME; ?></td>
                            <td><?php echo $park->ADDRESS; ?></td>
                            <td><?php echo $park->PROVINCE_ID; ?></td>
                            <td><?php echo anchor('/setting/publicpark/' . $park->GARDEN_ID, 'Edit'); ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>
