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

                <li class="<?php echo in_array($url_segment,array('dashboard'))?"active":""; ?>">
                    <a href="<?php echo base_url('vendor/dashboard'); ?>"><i class="fe fe-home"></i> <span><?php echo translate('dashboard'); ?></span></a>
                </li>

                <li class="<?php echo active_link('staff'); ?>">
                    <a href="<?php echo base_url('vendor/staff') ?>"><i class="fe fe-user-plus"></i> <span><?php echo translate('my_staff'); ?></span></a>
                </li>


                <?php if (get_site_setting('enable_service') == 'Y'): ?>
                    <li class="submenu">
                        <a href="#" class="<?php echo active_tab_link('service')." ".active_tab_link('coupon'); ?>"><i class="fe fe-layout"></i> <span>  <?php echo translate('service'); ?> </span> <span class="menu-arrow"></span></a>
                        <ul style="display: <?php echo active_display('service')." ".active_display('coupon'); ?>;">
                            <li>
                                <a href="<?php echo base_url('vendor/manage-service'); ?>">
                                    <?php echo translate('service'); ?>
                                </a>
                            </li>
                            <?php if (isset($app_vendor_setting_data['allow_service_category']) && $app_vendor_setting_data['allow_service_category'] == "Y"): ?>
                                <li>
                                    <a href="<?php echo base_url('vendor/service-category'); ?>">
                                        <?php echo translate('service_category'); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo base_url('vendor/manage-coupon'); ?>">
                                    <?php echo translate('event_coupon'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('vendor/manage-appointment'); ?>">
                                    <?php echo translate('appointment'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('vendor/appointment-payments'); ?>">
                                    <?php echo translate('appointment_payment_history'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('vendor/holiday'); ?>">
                                    <?php echo translate('holiday'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (get_site_setting('enable_membership') == 'Y'): ?>
                    <li class="<?php echo active_link('membership'); ?>">
                        <a href="<?php echo base_url('vendor/membership'); ?>" class="border-color">
                            <i class="fe fe-cage"></i>
                            <span><?php echo translate('membership') . " " . translate('payment'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="<?php echo in_array($url_segment,array('wallet'))?"active":""; ?>">
                    <a href="<?php echo base_url('vendor/wallet'); ?>" class="border-color">
                        <i class="fe fe-credit-card"></i>
                        <span><?php echo translate('wallet'); ?></span>
                    </a>
                </li>

                <li class="<?php echo active_link('slider'); ?>">
                    <a href="<?php echo base_url('vendor/manage-slider'); ?>" class="border-color">
                        <i class="fe fe-file-image"></i>
                        <span><?php echo translate('gallery_image'); ?></span>
                    </a>
                </li>

                <li class="<?php echo active_link('contact'); ?>">
                    <a href="<?php echo base_url('vendor/contact-us'); ?>" class="border-color">
                        <i class="fe fe-comment-o"></i>
                        <span><?php echo translate('event_inquiry'); ?></span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0)" class="<?php echo active_tab_link('report'); ?>">
                        <i class="fe fe-activity"></i>
                        <span><?php echo translate('report'); ?></span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="display: <?php echo active_display('report'); ?>;">
                        <?php if (get_site_setting('enable_service') == 'Y'): ?>
                            <li class="">
                                <a href="<?php echo base_url('vendor/appointment-report'); ?>">
                                    <i class="fa fa-bookmark pr-2"></i>
                                    <?php echo translate('appointment_report'); ?>
                                </a>
                            </li>
                            <li class="">
                                <a href="<?php echo base_url('vendor/service-appointment-report'); ?>">
                                    <i class="fa fa-bookmark pr-2"></i>
                                    <?php echo translate('service') . " " . translate('appointment'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>


                <?php if (isset($app_vendor_setting_data['allow_city_location']) && $app_vendor_setting_data['allow_city_location'] == "Y"): ?>
                <li class="submenu">
                    <a href="#" class="<?php echo active_tab_link('testimonial')." ".active_tab_link('faq')." ".active_tab_link('slider')." ".active_tab_link('city')." ".active_tab_link('currency')." ".active_tab_link('location'); ?>"><i class="fe fe-building"></i> <span>  <?php echo translate('master'); ?></span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li >
                            <a href="<?php echo base_url('vendor/city'); ?>">
                                <?php echo translate('city'); ?>
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('vendor/location'); ?>">
                                <?php echo translate('location'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->