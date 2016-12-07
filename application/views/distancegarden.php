

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="x_content">
		  
			<form method="post" action="<?php echo base_url();?>main/distance_save" class="form-horizontal form-label-left" novalidate>
				<div id="step1">
			   
				  <span class="section">ระยะห่างระหว่างสวน</span>
				<?php  //var_dump($garden_info);
				$garden_id_all ="";
				for($i=0;$i<count($garden);$i++) { 
					if($garden[$i]['GARDEN_ID'] != $garden_info['GARDEN_ID']){
						$garden_id_all .= "|".$garden[$i]['GARDEN_ID'];
				?>
				  <div class="item form-group">
					<label class="control-label col-md-6 col-sm-6 col-xs-12" for="name">ระยะห่างระหว่างสวน <?php echo $garden_info['NAME'] ."และ". $garden[$i]['NAME'];?>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" name="distance_<?php echo $garden[$i]['GARDEN_ID']?>" value="<?php echo $distance[$i]['DISTANCE']?>"/> กิโลเมตร
					</div>
				  </div>
			<?php } 
				} 
				?>
				</div>
				<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								<label class="control-label col-md-6 col-sm-6 col-xs-12" for="name"></label>
								<input type="hidden" name="garden_id" value="<?php echo $garden_info['GARDEN_ID'] ?>" />
								<input type="hidden" name="gardener_id" value="<?php echo $garden_info['GARDENER_ID'] ?>" />
								<input type="hidden" name="garden_match" value="<?php echo substr($garden_id_all,1);?>" />
							  <button id="send" type="submit" class="btn btn-success">บันทึกระยะห่างระหว่างสวน</button>
							  
							</div>
						  </div>
			</form>
		  </div>
        </div>
        <!-- /page content -->
