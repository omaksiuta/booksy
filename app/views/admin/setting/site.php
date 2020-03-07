<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
$company_name = isset($company_data->company_name) ? $company_data->company_name : set_value('company_name');
$company_email1 = isset($company_data->company_email1) ? $company_data->company_email1 : set_value('company_email1');
$company_email2 = isset($company_data->company_email2) ? $company_data->company_email2 : set_value('company_email2');
$company_phone1 = isset($company_data->company_phone1) ? $company_data->company_phone1 : set_value('company_phone1');
$company_phone2 = isset($company_data->company_phone2) ? $company_data->company_phone2 : set_value('company_phone2');
$company_address1 = isset($company_data->company_address1) ? $company_data->company_address1 : set_value('company_address1');
$company_address2 = isset($company_data->company_address2) ? $company_data->company_address2 : set_value('company_address2');
$language = isset($company_data->language) ? $company_data->language : set_value('language');
$time_zone = isset($company_data->time_zone) ? $company_data->time_zone : set_value('time_zone');
$company_logo = isset($company_data->company_logo) ? $company_data->company_logo : set_value('company_logo');
$fb_link = isset($company_data->fb_link) ? $company_data->fb_link : set_value('fb_link');
$google_link = isset($company_data->google_link) ? $company_data->google_link : set_value('google_link');
$twitter_link = isset($company_data->twitter_link) ? $company_data->twitter_link : set_value('twitter_link');
$insta_link = isset($company_data->insta_link) ? $company_data->insta_link : set_value('insta_link');
$linkdin_link = isset($company_data->linkdin_link) ? $company_data->linkdin_link : set_value('linkdin_link');
$root_dir = dirname(BASEPATH) . "/" . uploads_path . '/sitesetting/';
$logo_check = false;
$icon_check = false;
$banner_check = false;
if (isset($company_data->company_logo) && $company_data->company_logo != "") {
    if (file_exists($root_dir . $company_data->company_logo)) {
        $logo_check = true;
        $logo_image = base_url() . uploads_path . '/sitesetting/' . $company_data->company_logo;
    } else {
        $logo_image = base_url() . img_path . "/no-image.png";
    }
} else {
    $logo_image = base_url() . img_path . "/no-image.png";
}
if (isset($company_data->fevicon_icon) && $company_data->fevicon_icon != "") {
    if (file_exists($root_dir . $company_data->fevicon_icon)) {
        $icon_check = true;
        $icon_image = base_url() . uploads_path . '/sitesetting/' . $company_data->fevicon_icon;
    } else {
        $icon_image = base_url() . img_path . "/no-image.png";
    }
} else {
    $icon_image = base_url() . img_path . "/no-image.png";
}
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('site_setting'); ?></h3>
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
                            <li class="nav-item active"><a  class="nav-link active" href="<?php echo base_url('admin/sitesetting'); ?>"><?php echo translate('site_setting'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/email-setting'); ?>"><?php echo translate('email'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/sms-setting'); ?>"><?php echo translate('sms'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/currency-setting'); ?>"><?php echo translate('currency'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/business-setting'); ?>"><?php echo translate('business'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/display-setting'); ?>"><?php echo translate('display'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/payment-setting'); ?>"><?php echo translate('payment'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/vendor-setting'); ?>"><?php echo translate('vendor'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                                <hr/>
                                <div class="steps-form-2">
                                    <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                        <div class="steps-step-2">
                                            <a href="#step-4" type="button" class="btn kb-color bg-primary-light ml-0" data-toggle="tooltip" data-placement="top" title="<?php echo translate('basic'); ?> <?php echo translate('information'); ?>">
                                                <?php echo translate('basic'); ?> <?php echo translate('information'); ?>
                                            </a>
                                        </div>
                                        <div class="steps-step-2">
                                            <a href="#step-5" type="button" class="btn bg-primary-light waves-effect" data-toggle="tooltip" data-placement="top" title=" <?php echo translate('social'); ?> <?php echo translate('media'); ?>">
                                                <?php echo translate('social'); ?> <?php echo translate('media'); ?>
                                            </a>
                                        </div>
                                        <div class="steps-step-2">
                                            <a href="#step-6" type="button" class="btn bg-primary-light waves-effect" data-toggle="tooltip" data-placement="top" title=" <?php echo translate('media'); ?>">
                                                <?php echo translate('media'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_open_multipart('admin/save-sitesetting', array('name' => 'site_form', 'id' => 'site_form')); ?>
                                <div class="row setup-content-2" id="step-4">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('company'); ?> <?php echo translate('information'); ?></strong></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('site_name') . '<small class ="required">*</small>', 'company_name', array('class' => 'control-label', 'data-error' => 'wrong', 'data-success' => 'right')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'company_name', 'class' => 'form-control validate', 'name' => 'company_name', 'value' => $company_name, 'required' => 'required', 'placeholder' => translate('site_name'))); ?>
                                                    <?php echo form_error('company_name'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('site_email') . '<small class ="required">*</small>', 'company_email1', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'company_email1', 'class' => 'form-control validate', 'name' => 'company_email1', 'value' => $company_email1, 'required' => 'required', 'type' => 'email', 'placeholder' => translate('site_email'))); ?>
                                                    <?php echo form_error('company_email1'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('site_phone'), 'company_phone1', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'company_phone1', 'class' => 'form-control validate', 'name' => 'company_phone1', 'value' => $company_phone1, 'placeholder' => translate('site_phone'))); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('address'), 'company_address1', array('class' => 'control-label')); ?>
                                                    <?php echo form_textarea(array('id' => 'company_address1', 'class' => 'form-control validate', 'name' => 'company_address1', 'type' => 'text', 'rows' => 3, 'value' => $company_address1, 'placeholder' => translate('address'))); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label class="black-text"><?php echo translate('select'); ?> <?php echo translate('language'); ?><small class="required">*</small></label>
                                                    <?php
                                                    $options = array();
                                                    $options[''] = translate('select') . " " . translate('language');
                                                    if (isset($language_data) && !empty($language_data)) {

                                                        foreach ($language_data as $row) {
                                                            $options[$row['db_field']] = $row['title'];
                                                        }
                                                    }

                                                    $attributes = array('class' => 'form-control', 'id' => 'language', 'required' => 'required');
                                                    echo form_dropdown('language', $options, $language, $attributes);
                                                    echo form_error('language');
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label class="black-text"><?php echo translate('select'); ?> <?php echo translate('time_zone'); ?></label>
                                                    <select class="form-control" id="time_zone" name="time_zone">
                                                        <option value=""><?php echo translate('select') . " " . translate('time_zone'); ?></option>
                                                        <?php foreach (tz_list() as $t) { ?>
                                                            <option value="<?php echo $t['zone']; ?>" <?php echo $time_zone == $t['zone'] ? 'selected' : ''; ?>><?php echo $t['diff_from_GMT'] . ' - ' . $t['zone']; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <?php
                                                    echo form_error('time_zone');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-rounded nextBtn-2 float-right" type="button"><?php echo translate('next'); ?></button>
                                    </div>
                                </div>
                                <div class="row setup-content-2" id="step-5">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('social'); ?> <?php echo translate('media'); ?></strong></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('facebook') . ' ' . translate('link') . ' : ', 'fb_link', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'fb_link', 'class' => 'form-control', 'name' => 'fb_link', 'value' => $fb_link, 'type' => 'url', 'placeholder' => translate('facebook') . ' ' . translate('link'))); ?>
                                                    <?php echo form_error('fb_link'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('google+') . ' ' . translate('link') . ' : ', 'google_link', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'google_link', 'class' => 'form-control', 'name' => 'google_link', 'value' => $google_link, 'type' => 'url', 'placeholder' => translate('google+') . ' ' . translate('link'))); ?>
                                                    <?php echo form_error('google_link'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('twitter') . ' ' . translate('link') . ' : ', 'twitter_link', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'twitter_link', 'class' => 'form-control', 'name' => 'twitter_link', 'value' => $twitter_link, 'type' => 'url', 'placeholder' => translate('twitter') . ' ' . translate('link'))); ?>
                                                    <?php echo form_error('twitter_link'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('instagram') . ' ' . translate('link') . ' : ', 'insta_link', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'insta_link', 'class' => 'form-control', 'name' => 'insta_link', 'value' => $insta_link, 'type' => 'url', 'placeholder' => translate('instagram') . ' ' . translate('link'))); ?>
                                                    <?php echo form_error('insta_link'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <?php echo form_label(translate('linkdin') . ' ' . translate('link') . ' : ', 'linkdin_link', array('class' => 'control-label')); ?>
                                                    <?php echo form_input(array('autocomplete'=>'off','id' => 'linkdin_link', 'class' => 'form-control', 'name' => 'linkdin_link', 'value' => $linkdin_link, 'type' => 'url', 'placeholder' => translate('linkdin') . ' ' . translate('link'))); ?>
                                                    <?php echo form_error('linkdin_link'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-rounded prevBtn-2 float-left" type="button"><?php echo translate('previous'); ?></button>
                                        <button class="btn btn-primary btn-rounded nextBtn-2 float-right" type="button"><?php echo translate('next'); ?></button>
                                    </div>
                                </div>
                                <div class="row setup-content-2" id="step-6">
                                    <div class="col-md-12">
                                        <h3 class="font-bold pl-0 my-4"><strong><?php echo translate('media'); ?></strong></h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo translate('company'); ?> <?php echo translate('logo'); ?><small class="required">*</small></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <img id="imageurl" width="241" class="img-fluid"  src="<?php echo $logo_image; ?>" alt="Image" height="61">
                                                        </div>
                                                    </div>
                                                    <div class="file-field">
                                                        <div>
                                                            <input class="form-control" onchange="readURL(this)" id="imageurl" <?php if ($logo_check == false) echo "required"; ?>  type="file" name="company_logo" accept="image/x-png,image/gif,image/jpeg,image/png"  extension="jpg|png|gif|jpeg" />
                                                        </div>
                                                    </div>
                                                    <?php echo form_error('company_logo'); ?>
                                                </div>
                                                <small>(<?php echo translate('valid_logo_size'); ?>)</small>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo translate('fevicon_icon'); ?><small class="required">*</small> </label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <img id="imageurl2"   src="<?php echo $icon_image; ?>" alt="Image" height="50" width="50">
                                                        </div>
                                                    </div>
                                                    <div class="file-field">
                                                        <input class="form-control" onchange="readURLIcon(this)" id="imageurl2" <?php if ($icon_check == false) echo "required"; ?>  type="file" name="fevicon_icon" accept="image/x-png,image/gif,image/jpeg,image/png"/>
                                                    </div>
                                                    <?php echo form_error('fevicon_icon'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-rounded prevBtn-2 float-left" type="button"><?php echo translate('previous'); ?></button>
                                        <button class="btn btn-success btn-rounded float-right" type="submit"><?php echo translate('submit'); ?></button>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/sitesetting.js" type="text/javascript"></script>
