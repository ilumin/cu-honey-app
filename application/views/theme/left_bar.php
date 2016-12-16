
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>เมนูหลัก</h3>
                <ul class="nav side-menu">
                  <li><a href="#"><i class="fa fa-clock-o"></i> <?php echo date('d-M-Y',strtotime(TODAY_DATE)) ?></a>
                
                  </li>
                  <li><a href="<?php echo base_url()?>main"><i class="fa fa-home"></i> หน้าแรก</a>
                
                  </li>
                  <li><a><i class="fa fa-bug"></i> ข้อมูลพื้นฐานระบบ <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url()?>setting/config">ตั้งค่าข้อมูลพื้นฐาน</a></li>
                      <li><a href="<?php echo base_url()?>setting/beekeeper">ข้อมูลผู้เลี้ยงผึ้ง</a></li>
                      <li><a href="<?php echo base_url()?>setting/flower">ข้อมูลพืชมีดอก</a></li>
					  <li><a href="<?php echo base_url()?>setting/auto_create_hive">เพิ่มรังผึ้งใหม่</a></li>
					  <li><a href="<?php echo base_url()?>setting/hive">ข้อมูลรังผึ้ง คอน </a></li>
					  <li><a href="<?php echo base_url()?>setting/queen">ข้อมูลนางพญา </a></li>
					  <li><a href="<?php echo base_url()?>setting/publicpark">ข้อมูลสวนสาธารณะ</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-user "></i>สมาชิกชาวสวน <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					 <li><a href="<?php echo base_url()?>main/member_list">ข้อมูลสมาชิก</a></li>
                    </ul>
                  </li>
				  
				  <li><a href="<?php echo base_url()?>annual_plan" ><i class="fa fa-calendar-o" ></i> Annual Plan </a></li>
				  <li><a href="<?php echo base_url()?>action_plan" ><i class="fa fa-trello"  ></i> Action Plan </a></li>
				  <li><a><i class="fa fa-table "></i>Operation Plan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					 <li><a href="<?php echo base_url()?>operation_plan/tomorrow">งานที่ต้องทำพรุ่งนี้</a></li>
					 <li><a href="<?php echo base_url()?>operation_plan/task">งานที่ต้องทำวันนี้</a></li>
					 <li><a href="<?php echo base_url()?>blooming">แจ้งดอกไม้บาน</a></li>
					 <li><a href="<?php echo base_url()?>po_list">รายการใบจ่ายเงิน</a></li>
                    </ul>
                  </li>
				  <li><a><i class="fa fa-list-alt "></i> รายงาน <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url()?>hive-report">รายงานผลผลิตน้ำผึ้ง</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>