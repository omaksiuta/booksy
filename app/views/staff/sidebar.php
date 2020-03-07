<!-- Sidebar -->
<?php
/* Vendor Setting */
$app_vendor_setting_data = app_vendor_setting();
$url_segment = trim($this->uri->segment(2));
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span></span>
                </li>

                <li class="<?php echo in_array($url_segment, array('dashboard')) ? "active" : ""; ?>">
                    <a href="<?php echo base_url('staff/dashboard'); ?>"><i class="fe fe-home"></i> <span><?php echo translate('dashboard'); ?></span></a>
                </li>

                <li class="<?php echo in_array($url_segment, array('appointment','view-booking-details')) ? "active" : ""; ?>">
                    <a href="<?php echo base_url('staff/appointment'); ?>"><i class="fe fe-calendar"></i> <span><?php echo translate('appointment'); ?></span></a>
                </li>


            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->