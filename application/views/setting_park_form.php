<?php

$name = isset($park_edit['NAME']) ? $park_edit['NAME'] : null;
$address = isset($park_edit['ADDRESS']) ? $park_edit['ADDRESS'] : null;
$province_id = isset($park_edit['PROVINCE_ID']) ? $park_edit['PROVINCE_ID'] : null;

?>

<form action="<?php echo base_url() . 'setting/publicpark/' . $park_id; ?>" class="form-horizontal form-label-left" method="post" novalidate>

    <span class="section">
        <?php if (isset($park_edit)): ?>
            แก้ไขข้อมูลสวนสาธารณะ
        <?php else: ?>
            เพิ่มข้อมูลสวนสาธารณะ
        <?php endif; ?>
    </span>

    <input type="hidden" name="gardener_id" value="<?php echo $gardener_id; ?>">

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            ชื่อสวน<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" id="name" name="name" required="required" type="text" value="<?php echo $name; ?>">
        </div>
    </div>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            ที่อยู่สวน<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input class="form-control col-md-7 col-xs-12" id="address" name="address" required="required" type="text" value="<?php echo $address; ?>">
        </div>
    </div>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            จังหวัด<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <!-- <input class="form-control col-md-7 col-xs-12" id="province" name="province" required="required" type="text" value=""> -->
            <select id="province" name="province" class="form-control" required="required" >
              <option value="" selected>--------- เลือกจังหวัด ---------</option>
              <?php for($i=0; $i<count($province); $i++): ?>
              <option value="<?php echo $province[$i]['PROVINCE_ID']; ?>" <?php echo $province[$i]['PROVINCE_ID'] == $province_id ? 'selected' : ''; ?>><?php echo $province[$i]['PROVINCE_NAME']; ?></option>
              <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="item form-group">
        <span class="section">ข้อมูลพืชมีดอกที่ปลูกในสวน</span>
        <h4 class="red">เลือกพืชที่ปลูกในสวน  (อย่างน้อย 1 รายการ)</h4>
        <table class="table">
            <thead>
            <tr>

                <th>เลือก</th>
                <th>จำนวนไร่</th>
                <th>จำนวนรัง</th>
                <th>ปลูกพืชผสมหรือไม่</th>
                <th>พิชที่ปลูก</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($flowers as $index => $flower):
                $flower_id = $flower['FLOWER_ID'];
                $flower_name = $flower['FLOWER_NAME'];
                $selected = isset($gardenflowers[$flower_id]);

                $area = false;
                $hive = false;
                $risk = false;
                $mix = false;
                if ($selected) {
                    $area = $gardenflowers[$flower_id]['area'];
                    $hive = $gardenflowers[$flower_id]['hive'];
                    $risk = $gardenflowers[$flower_id]['risk'];
                    $mix = $gardenflowers[$flower_id]['mix'];
                }
                ?>
                <tr>
                    <th scope="row">
                        <label><input name="selected[]" type="checkbox" <?php echo $index==0 ? 'data-parsley-mincheck="1" required ' : ''; ?> value="<?php echo $flower_id;?>" class="flat" <?php echo $selected ? ' checked' : ''; ?>>
                            <?php echo $flower_name; ?>
                        </label>
                    </th>
                    <td>
                        <input style="width: 80px;" type="number" id="number" name="flowers[<?php echo $flower_id; ?>][area]"  data-validate-minmax="5,2000" class="form-control" value="<?php echo $area; ?>">
                    </td>
                    <td>
                        <input style="width: 80px;" type="number" id="number" name="flowers[<?php echo $flower_id; ?>][hive]"  data-validate-minmax="5,2000" class="form-control" value="<?php echo $hive; ?>">
                    </td>
                    <td>
                        <input name="flowers[<?php echo $flower_id; ?>][risk]" type="checkbox" value="mix" class="flat checkbox_check" <?php echo $risk ? ' checked' : ''; ?>>
                        ปลูกผสมกับ
                    </td>
                    <td>
                        <select name="flowers[<?php echo $flower_id; ?>][mix]">
                            <option value="-">เลือกพืชที่ปลูกผสม</option>
                            <?php foreach($flowers as $item) { echo '<option value="' . $item['FLOWER_ID'] . '" ' . ($mix==$item['FLOWER_ID'] ? ' selected' : '') . '>' . $item['FLOWER_NAME'] . '</option>'; }; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="ln_solid"></div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button id="send" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>

</form>

