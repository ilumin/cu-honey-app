<?php

$parent = false;

?>
<div class="right_col" role="main">

    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $form_title; ?></h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <form action="<?php echo $form_url; ?>" class="form-horizontal form-label-left" method="post" novalidate>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="x_panel">
                        <div class="x_content">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="text-align: right">เลือกวันที่ทำงาน</th>
                                    <th><input class="input-date" name="action_date" type="text" value="<?php echo date('Y-m-d')?>" /></th>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><input type="checkbox" class="select-all" /></th>
                                    <th>เลือก รหัสรังผึ้งทั้งหมด</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($items as $item): ?>
                                    <?php if($parent!=$item['parent_id']): $parent = $item['parent_id'] ?>
                                    <tr>
                                        <th colspan="2" style="background: #EEE;">รังหมายเลข <?php echo $item['parent_id']; ?></th>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td style="text-align: right"><input type="checkbox"  name="selected[]" value="<?php echo $item['id']; ?>"></td>
                                        <td><?php echo $item['id']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="ln_solid"></div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button id="send" type="submit" class="btn btn-success">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
    </form>

</div>