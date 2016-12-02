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

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="x_panel">
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>รหัสรังผึ้ง</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($items as $item): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    <div>

</div>