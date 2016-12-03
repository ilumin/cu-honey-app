
<div class="right_col">
    <div class="col-md-12 col-sm-12 col-xs-12">

        <?php if(!empty($flash_type)): ?>
            <div class="x_panel">
                <h4><?php echo $flash_type; ?></h4>
                <p><?php echo $flash_message; ?></p>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url() . 'setting/config'; ?>" class="form-horizontal form-label-left" method="post" novalidate>
            <span class="section">
                ตั้งค่าข้อมูลพื้นฐาน
            </span>

            <?php foreach($field as $key => $label): ?>
            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                    <?php echo $label; ?>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12 input-date" id="<?php echo $key; ?>" name="<?php echo $key; ?>" type="text" value="<?php echo isset($config[$key]) ? $config[$key] : ''; ?>">
                </div>
            </div>
            <?php endforeach; ?>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button id="send" type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </div>
        </form>

    </div>
</div>
