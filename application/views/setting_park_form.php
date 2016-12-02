<?php

$name = isset($park_edit['NAME']) ? $park_edit['NAME'] : null;
$address = isset($park_edit['ADDRESS']) ? $park_edit['ADDRESS'] : null;
$province_id = isset($park_edit['PROVINCE_ID']) ? $park_edit['PROVINCE_ID'] : null;


$area = isset($gardenflowers[BJP_FLOWER]) ? $gardenflowers[BJP_FLOWER]['area'] : null;
$hive = isset($gardenflowers[BJP_FLOWER]) ? $gardenflowers[BJP_FLOWER]['hive'] : null;
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            จำนวนไร่<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input style="width: 80px;" type="number" id="number" name="flowers[<?php echo BJP_FLOWER; ?>][area]"  data-validate-minmax="5,2000" class="form-control" value="<?php echo $area; ?>">
        </div>
    </div>

    <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            จำนวนรัง<span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input style="width: 80px;" type="number" id="number" name="flowers[<?php echo BJP_FLOWER; ?>][hive]"  data-validate-minmax="5,2000" class="form-control" value="<?php echo $hive; ?>">
            <input name="flowers[<?php echo BJP_FLOWER; ?>][risk]" type="hidden" value="mix">
            <input type="hidden" name="selected[]" value="<?php echo BJP_FLOWER; ?>">
        </div>
    </div>

    <div class="ln_solid"></div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button id="send" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>

</form>

