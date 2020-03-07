<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
if (isset($login_type) && $login_type == 'V') {
    $folder_name = 'vendor';
}
$allow_city_location = isset($vendor_data['allow_city_location']) ? $vendor_data['allow_city_location'] : set_value('allow_city_location');
$allow_service_category = isset($vendor_data['allow_service_category']) ? $vendor_data['allow_service_category'] : set_value('allow_service_category');
$allow_event_category = isset($vendor_data['allow_event_category']) ? $vendor_data['allow_event_category'] : set_value('allow_event_category');
?>
<link href="<?php echo $this->config->item('css_url'); ?>jquery.minicolors.css" rel="stylesheet">
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('site_setting'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/sitesetting'); ?>"><?php echo translate('setting'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                            <li class="nav-item "><a  class="nav-link" href="<?php echo base_url('admin/sitesetting'); ?>"><?php echo translate('site_setting'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/email-setting'); ?>"><?php echo translate('email'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link active" href="<?php echo base_url('admin/sms-setting'); ?>"><?php echo translate('sms'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/currency-setting'); ?>"><?php echo translate('currency'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/business-setting'); ?>"><?php echo translate('business'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/display-setting'); ?>"><?php echo translate('display'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/payment-setting'); ?>"><?php echo translate('payment'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/vendor-setting'); ?>"><?php echo translate('vendor'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                                <hr/>
                                <?php echo form_open('admin/save-vendor-setting', array('name' => 'vendor_setting_form', 'id' => 'vendor_setting_form')); ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('allow_city_location'), 'is_display_vendor', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='allow_city_location' id="allow_city_location_yes" value="Y" type='radio' <?php echo $allow_city_location == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="allow_city_location_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='allow_city_location' id="allow_city_location_no" type='radio'  value='N' <?php echo $allow_city_location == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='allow_city_location_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('allow_service_category'), 'is_display_category', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='allow_service_category' id="allow_service_category_yes" value="Y" type='radio' <?php echo $allow_service_category == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="allow_service_category_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='allow_service_category' id="allow_service_category_no" type='radio'  value='N' <?php echo $allow_service_category == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='allow_service_category_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('allow_event_category'), 'is_display_location', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='allow_event_category' value="Y" id="allow_event_category_yes" type='radio' <?php echo $allow_event_category == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="allow_event_category_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='allow_event_category' type='radio' id="allow_event_category_no" value='N' <?php echo $allow_event_category == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='allow_event_category_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect"><?php echo translate('update'); ?></button>
                                        </div>
                                    </div>

                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>jquery.minicolors.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>module/sitesetting.js" type="text/javascript"></script>