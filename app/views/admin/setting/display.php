<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
if (isset($login_type) && $login_type == 'V') {
    $folder_name = 'vendor';
}

$time_format = isset($company_data->time_format) ? $company_data->time_format : set_value('time_format');
$is_display_vendor = isset($company_data->is_display_vendor) ? $company_data->is_display_vendor : set_value('is_display_vendor');
$is_display_category = isset($company_data->is_display_category) ? $company_data->is_display_category : set_value('is_display_category');
$is_display_location = isset($company_data->is_display_location) ? $company_data->is_display_location : set_value('is_display_location');
$is_display_searchbar = isset($company_data->is_display_searchbar) ? $company_data->is_display_searchbar : set_value('is_display_searchbar');
$is_display_language = isset($company_data->is_display_language) ? $company_data->is_display_language : set_value('is_display_language');
$is_maintenance_mode = isset($company_data->is_maintenance_mode) ? $company_data->is_maintenance_mode : set_value('is_maintenance_mode');
$display_record_per_page = isset($company_data->display_record_per_page) ? $company_data->display_record_per_page : set_value('is_display_searchbar');
$header_color_code = isset($company_data->header_color_code) ? $company_data->header_color_code : (set_value('header_color_code') != '' ? set_value('header_color_code') : '#4b6499');
$footer_color_code = isset($company_data->footer_color_code) ? $company_data->footer_color_code : (set_value('footer_color_code') != '' ? set_value('footer_color_code') : '#4b6499');
$footer_text = isset($company_data->footer_text) ? $company_data->footer_text : set_value('footer_text');
$enable_event = isset($company_data->enable_event) ? $company_data->enable_event : set_value('enable_event');
$enable_service = isset($company_data->enable_service) ? $company_data->enable_service : set_value('enable_service');
$enable_testimonial = isset($company_data->enable_testimonial) ? $company_data->enable_testimonial : set_value('enable_testimonial');

?>
<link href="<?php echo $this->config->item('css_url'); ?>jquery.minicolors.css" rel="stylesheet">
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('display_setting'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/sitesetting'); ?>"><?php echo translate('setting'); ?></a></li>
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
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/sitesetting'); ?>"><?php echo translate('site_setting'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/email-setting'); ?>"><?php echo translate('email'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/sms-setting'); ?>"><?php echo translate('sms'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/currency-setting'); ?>"><?php echo translate('currency'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/business-setting'); ?>"><?php echo translate('business'); ?></a></li>
                            <li class="nav-item active"><a  class="nav-link active" href="<?php echo base_url('admin/display-setting'); ?>"><?php echo translate('display'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/payment-setting'); ?>"><?php echo translate('payment'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/vendor-setting'); ?>"><?php echo translate('vendor'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                                <hr/>
                                <?php echo form_open('admin/update-display-setting', array('name' => 'site_email_form', 'id' => 'site_email_form')); ?>
                                <div class="row">

                                    <div class="col-md-4 ">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('service') . ' : ', 'enable_service', array('class' => 'control-label')); ?>

                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='enable_service' id="enable_service_yes" value="Y" type='radio' <?php echo $enable_service == 'Y' ? "checked='checked'" : ""; ?> >
                                                <label for="enable_service_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='enable_service' id="enable_service_no" type='radio'  value='N' <?php echo $enable_service == 'N' ? "checked='checked'" : ""; ?> >
                                                <label for='enable_service_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4 ">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('event') . ' : ', 'is_display_vendor', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='enable_event' id="enable_event_yes" value="Y" type='radio' <?php echo $enable_event == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="enable_event_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='enable_event' id="enable_event_no" type='radio'  value='N' <?php echo $enable_event == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='enable_event_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('vendor') . ' ' . translate('module') . ' : ', 'is_display_vendor', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='is_display_vendor' id="is_display_vendor_yes" value="Y" type='radio' <?php echo $is_display_vendor == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="is_display_vendor_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='is_display_vendor' id="is_display_vendor_no" type='radio'  value='N' <?php echo $is_display_vendor == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='is_display_vendor_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('category') . ' ' . translate('module') . ' : ', 'is_display_category', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='is_display_category' id="is_display_category_yes" value="Y" type='radio' <?php echo $is_display_category == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="is_display_category_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='is_display_category' id="is_display_category_no" type='radio'  value='N' <?php echo $is_display_category == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='is_display_category_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('location') . ' ' . translate('module') . ' : ', 'is_display_location', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='is_display_location' id="is_display_location_yes" value="Y" type='radio' <?php echo $is_display_location == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="is_display_location_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='is_display_location' id="is_display_location_no" type='radio'  value='N' <?php echo $is_display_location == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='is_display_location_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('searching') . ' ' . translate('module') . ' : ', 'is_display_searchbar', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='is_display_searchbar' id="is_display_searchbar_yes" value="Y" type='radio' <?php echo $is_display_searchbar == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="is_display_searchbar_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='is_display_searchbar' id="is_display_searchbar_no" type='radio'  value='N' <?php echo $is_display_searchbar == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='is_display_searchbar_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('language') . ' ' . translate('module') . ' : ', 'is_display_language', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='is_display_language' id="is_display_language_yes" value="Y" type='radio' <?php echo $is_display_language == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="is_display_language_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='is_display_language' id="is_display_language_no" type='radio'  value='N' <?php echo $is_display_language == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='is_display_language_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('maintenance_mode') . ' : ', 'is_display_language', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='is_maintenance_mode' id="is_maintenance_mode_yes" value="Y" type='radio' <?php echo $is_maintenance_mode == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="is_maintenance_mode_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='is_maintenance_mode' id="is_maintenance_mode_no" type='radio'  value='N' <?php echo $is_maintenance_mode == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='is_maintenance_mode_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Switch -->
                                        <?php echo form_label(translate('enable') . ' ' . translate('testimonial') . ' : ', 'enable_testimonial', array('class' => 'control-label')); ?>
                                        <div class="form-group form-inline">
                                            <div class="form-group mr-2">
                                                <input name='enable_testimonial' id="enable_testimonial_yes" value="Y" type='radio' <?php echo $enable_testimonial == 'Y' ? "checked='checked'" : ""; ?>>
                                                <label for="enable_testimonial_yes"><?php echo translate('yes'); ?></label>
                                            </div>
                                            <div class="form-group">
                                                <input name='enable_testimonial' id="enable_testimonial_no" type='radio'  value='N' <?php echo $enable_testimonial == 'N' ? "checked='checked'" : ""; ?>>
                                                <label for='enable_testimonial_no'><?php echo translate('no'); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <?php echo form_label(translate('display_datetime_form') . ' : ', 'display_record_per_page', array('class' => 'control-label')); ?>
                                        <select style="display: block !important;" name="time_format" id="time_format" class="form-control" >

                                            <optgroup label="12hr format">
                                                <option <?php echo ($time_format == "d/m/y h:i") ? "selected='selected'" : ""; ?> value="d/m/Y h:i"><?php echo date('d/m/Y h:i'); ?></option>
                                                <option <?php echo ($time_format == "d-m-Y h:i") ? "selected='selected'" : ""; ?> value="d-m-Y h:i"><?php echo date('d-m-Y h:i'); ?></option>
                                                <option <?php echo ($time_format == "m-d-Y h:i") ? "selected='selected'" : ""; ?>  value="m-d-Y h:i"><?php echo date('m-d-Y h:i'); ?></option>
                                                <option <?php echo ($time_format == "m/d/Y h:i") ? "selected='selected'" : ""; ?>  value="m/d/Y h:i"><?php echo date('m/d/Y h:i'); ?></option>
                                                <option <?php echo ($time_format == "Y/m/d h:i") ? "selected='selected'" : ""; ?>  value="Y/m/d h:i"><?php echo date('Y/m/d h:i'); ?></option>
                                                <option <?php echo ($time_format == "Y-m-d h:i") ? "selected='selected'" : ""; ?>  value="Y-m-d h:i"><?php echo date('Y-m-d h:i'); ?></option>
                                            </optgroup>

                                            <optgroup label="24hr formar">
                                                <option <?php echo ($time_format == "d-m-Y H:i") ? "selected='selected'" : ""; ?> value="d-m-Y H:i"><?php echo date('d-m-Y H:i'); ?></option>
                                                <option <?php echo ($time_format == "d/m/Y H:i") ? "selected='selected'" : ""; ?> value="d/m/Y H:i"><?php echo date('d/m/Y H:i'); ?></option>
                                                <option <?php echo ($time_format == "m-d-Y H:i") ? "selected='selected'" : ""; ?> value="m-d-Y H:i"><?php echo date('m-d-Y H:i'); ?></option>
                                                <option <?php echo ($time_format == "m/d/Y H:i") ? "selected='selected'" : ""; ?> value="m/d/Y H:i"><?php echo date('m/d/Y H:i'); ?></option>
                                                <option <?php echo ($time_format == "Y/m/d H:i") ? "selected='selected'" : ""; ?>  value="Y/m/d H:i"><?php echo date('Y/m/d H:i'); ?></option>
                                                <option <?php echo ($time_format == "Y-m-d H:i") ? "selected='selected'" : ""; ?>  value="Y-m-d H:i"><?php echo date('Y-m-d H:i'); ?></option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php echo form_label(translate('display') . ' ' . translate('records') . ' ' . translate('per_page') . ' : ', 'display_record_per_page', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('type' => 'number', 'id' => 'display_record_per_page', 'class' => 'form-control', 'name' => 'display_record_per_page', 'value' => $display_record_per_page, 'placeholder' => translate('display') . ' ' . translate('records') . ' ' . translate('per_page'))); ?>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php echo form_label(translate('header') . ' ' . translate('color') . ' ' . translate('code') . ' : ', 'header_color_code', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('type' => 'text', 'id' => 'header_color_code', 'class' => 'form-control demo check-color ', 'name' => 'header_color_code', 'value' => $header_color_code, 'placeholder' => translate('header') . ' ' . translate('color') . ' ' . translate('code'))); ?>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php echo form_label(translate('footer') . ' ' . translate('color') . ' ' . translate('code') . ' : ', 'footer_color_code', array('class' => 'control-label')); ?>
                                        <?php echo form_input(array('type' => 'text', 'id' => 'footer_color_code', 'class' => 'demo check-color form-control', 'name' => 'footer_color_code', 'value' => $footer_color_code, 'placeholder' => translate('footer') . ' ' . translate('color') . ' ' . translate('code'))); ?>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php echo form_label(translate('footer') . ' ' . translate('text') . ' : ', 'footer_text', array('class' => 'control-label')); ?>
                                        <textarea id="footer_text" class="form-control" name="footer_text" placeholder="<?php echo translate("footer") . " " . translate("text"); ?>"><?php echo $footer_text; ?></textarea>
                                        <span id="spnCharLeft"></span>
                                    </div>


                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit"><?php echo translate('submit'); ?></button>
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
