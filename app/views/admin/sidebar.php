<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span></span>
                </li>

                <li class="<?php echo active_link('dashboard');?>">
                    <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fe fe-home"></i> <span><?php echo translate('dashboard'); ?></span></a>
                </li>

                <li class="<?php echo active_link('customer');?>">
                    <a href="<?php echo base_url('admin/customer') ?>"><i class="fe fe-user"></i> <span><?php echo translate('customer'); ?></span></a>
                </li>

                <?php if (get_site_setting('is_display_vendor') == 'Y'): ?>
                    <li class="submenu">
                        <a href="#" class="<?php echo active_tab_link('vendor'); ?>"><i class="fe fe-users"></i> <span> <?php echo translate('vendor'); ?></span> <span class="menu-arrow"></span></a>
                        <ul style="display: <?php echo active_display('vendor'); ?>;">
                            <li>
                                <a href="<?php echo base_url('admin/vendor') ?>"><?php echo translate('vendor'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/unverified-vendor'); ?>">
                                    <?php echo translate('unverified') . " " . translate('vendor'); ?>
                                </a>
                            </li>
                            <li >
                                <a href="<?php echo base_url('admin/payout-request'); ?>">
                                    <?php echo translate('payout_request'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="<?php echo active_link('staff'); ?>">
                    <a href="<?php echo base_url('admin/staff') ?>"><i class="fe fe-user-plus"></i> <span><?php echo translate('my_staff'); ?></span></a>
                </li>


                <?php if (get_site_setting('enable_service') == 'Y'): ?>
                    <li class="submenu">
                        <a href="#" class="<?php echo active_tab_link('service')." ".active_tab_link('coupon'); ?>"><i class="fe fe-layout"></i> <span>  <?php echo translate('service'); ?> </span> <span class="menu-arrow"></span></a>
                        <ul style="display: <?php echo active_display('service')." ".active_display('coupon'); ?>;">
                            <li>
                                <a href="<?php echo base_url('admin/manage-service'); ?>">
                                    <?php echo translate('service'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/service-category'); ?>">
                                    <?php echo translate('service_category'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/manage-coupon'); ?>">
                                    <?php echo translate('event_coupon'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/manage-appointment'); ?>">
                                    <?php echo translate('appointment'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/payment-history'); ?>">
                                    <?php echo translate('appointment_payment_history'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/holiday'); ?>">
                                    <?php echo translate('holiday'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="submenu">
                    <a href="#" class="<?php echo active_tab_link('report'); ?>"><i class="fe fe-activity"></i> <span>  <?php echo translate('report'); ?></span> <span class="menu-arrow"></span></a>
                    <ul style="display: <?php echo active_display('report'); ?>;">
                        <?php if (get_site_setting('is_display_vendor') == 'Y'): ?>
                            <li>
                                <a href="<?php echo base_url('admin/report'); ?>">
                                    <?php echo translate('vendor_report'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo base_url('admin/customer-report'); ?>">
                                <?php echo translate('customer_report'); ?>
                            </a>
                        </li>
                        <?php if (get_site_setting('enable_service') == 'Y'): ?>
                            <li>
                                <a href="<?php echo base_url('admin/service-appointment-report'); ?>">
                                    <?php echo translate('service') . " " . translate('appointment'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="<?php echo active_link('page_content');?>">
                    <a href="<?php echo base_url('admin/manage-content'); ?>" class="border-color">
                        <i class="fe fe-document"></i>
                        <span><?php echo translate('content_management'); ?></span>
                    </a>
                </li>

                <li class="submenu">
                    <a href="#" class="<?php echo active_tab_link('contact'); ?>"><i class="fe fe-comment"></i> <span>  <?php echo translate('contact-us'); ?></span> <span class="menu-arrow"></span></a>
                    <ul style="display: <?php echo active_display('report'); ?>;">
                        <li class="<?php echo isset($contact_active) ? $contact_active : ""; ?>">
                            <a href="<?php echo base_url('admin/contact-us'); ?>">
                                <?php echo translate('contact-us-request'); ?>
                            </a>
                        </li>
                        <li class="<?php echo isset($event_inquiry_active) ? $event_inquiry_active : ""; ?>">
                            <a href="<?php echo base_url('admin/event-inquiry'); ?>">
                                <?php echo translate('event_inquiry'); ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="<?php echo active_link('sitesetting');?>">
                    <a href="<?php echo base_url('admin/sitesetting'); ?>"><i class="fe fe-gear"></i> <span><?php echo translate('site_setting'); ?></span></a>
                </li>

                <li class="<?php echo active_tab_link('language'); ?>">
                    <a href="<?php echo base_url('admin/manage-language'); ?>"><i class="fe fe-code"></i> <span><?php echo translate('language_setting'); ?></span></a>
                </li>


                <?php if (get_site_setting('enable_membership') == 'Y'): ?>
                    <li class="submenu">
                        <a href="#" class="<?php echo active_tab_link('package'); ?>"><i class="fe fe-gift"></i> <span>  <?php echo translate('package'); ?></span> <span class="menu-arrow"></span></a>
                        <ul style="display: <?php echo active_display('package'); ?>;">
                            <li class="">
                                <a href="<?php echo base_url('admin/manage-package'); ?>">
                                    <?php echo translate('manage') . " " . translate('package'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/package-payment'); ?>">
                                    <?php echo translate('package') . " " . translate('payment'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="submenu">
                    <a href="#" class="<?php echo active_tab_link('testimonial')." ".active_tab_link('faq')." ".active_tab_link('slider')." ".active_tab_link('city')." ".active_tab_link('currency')." ".active_tab_link('location'); ?>"><i class="fe fe-building"></i> <span>  <?php echo translate('master'); ?></span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li >
                            <a href="<?php echo base_url('admin/currency'); ?>">
                               <?php echo translate('currency'); ?>
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('admin/city'); ?>">
                                <?php echo translate('city'); ?>
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('admin/location'); ?>">
                                <?php echo translate('location'); ?>
                            </a>
                        </li>
                        <?php if (get_site_setting('enable_testimonial') == 'Y'): ?>
                            <li class="<?php echo isset($testimonial_active)?$testimonial_active:""; ?>">
                                <a href="<?php echo base_url('admin/testimonial'); ?>">
                                    <?php echo translate('testimonial'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li >
                            <a href="<?php echo base_url('admin/manage-slider'); ?>">
                                <?php echo translate('gallery_image'); ?>
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('admin/manage-faq'); ?>">
                                <?php echo translate('faqs'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->