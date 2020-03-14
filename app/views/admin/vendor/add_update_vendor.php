<?php
$first_name = isset($vendor_data['first_name']) ? $vendor_data['first_name'] : set_value('first_name');
$id = isset($vendor_data['id']) ? $vendor_data['id'] : set_value('id');
$last_name = isset($vendor_data['last_name']) ? $vendor_data['last_name'] : set_value('last_name');
$email = isset($vendor_data['email']) ? $vendor_data['email'] : set_value('email');
$company = isset($vendor_data['company_name']) ? $vendor_data['company_name'] : set_value('company');
$website = isset($vendor_data['website']) ? $vendor_data['website'] : set_value('website');
$phone = isset($vendor_data['phone']) ? $vendor_data['phone'] : set_value('phone');
$address = isset($vendor_data['address']) ? $vendor_data['address'] : set_value('address');
$status = (set_value("status")) ? set_value("status") : (!empty($vendor_data) ? $vendor_data['status'] : 'A');

$profile_image = (set_value("profile_image")) ? set_value("profile_image") : (!empty($vendor_data) ? $vendor_data['profile_image'] : '');
$image = check_profile_image($profile_image);


if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('vendor'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/vendor'); ?>"><?php echo translate('vendor'); ?></a></li>
                        <?php if (isset($vendor_data['id']) && $vendor_data['id'] > 0): ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('update'); ?> <?php echo translate('vendor'); ?></a></li>
                        <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/add-vendor'); ?>"><?php echo translate('add'); ?> <?php echo translate('vendor'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url('admin/add-vendor'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('vendor'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>

                <div class="card">
                    <div class="card-body resp_mx-0">
                        <?php $this->load->view('message'); ?>
                        <?php
                        $attributes = array('id' => 'Register_user', 'name' => 'Register_user', 'method' => "post");
                        echo form_open_multipart($folder_name . '/save-vendor', $attributes);
                        ?>
                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo (int) $id; ?>"/>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('first_name') . '<small class ="required">*</small>', 'first_name', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => 'off', 'id' => 'first_name', 'class' => 'form-control', 'name' => 'first_name', 'value' => $first_name, 'placeholder' => translate('first_name'))); ?>
                                    <?php echo form_error('first_name'); ?>
                                </div>
                                <div class="error" id="first_name_validate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('last_name') . '<small class ="required">*</small>', 'last_name', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => 'off', 'id' => 'last_name', 'class' => 'form-control', 'name' => 'last_name', 'value' => $last_name, 'placeholder' => translate('last_name'))); ?>
                                    <?php echo form_error('last_name'); ?>
                                </div>
                                <div class="error" id="last_name_validate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('email') . '<small class ="required">*</small>', 'email', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => 'off', 'type' => 'email', 'id' => 'email', 'class' => 'form-control', 'name' => 'email', 'value' => $email, 'placeholder' => translate('email'))); ?>
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="error" id="email_validate"></div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address"><?php echo translate('address'); ?> <small class="required">*</small></label>
                                    <textarea class="form-control" name="address" id="address" placeholder="<?php echo translate('address'); ?>"><?php echo $address; ?></textarea>
                                    <?php echo form_error('address'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('phone') . '<small class ="required">*</small>', 'phone', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => 'off', 'minlength' => "10", 'maxlength' => "10", 'id' => 'phone', 'class' => 'form-control', 'name' => 'phone', 'value' => $phone, 'placeholder' => translate('phone'))); ?>
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('company') . '<small class ="required">*</small>', 'company', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => 'off', 'id' => 'company', 'class' => 'form-control', 'name' => 'company', 'value' => $company, 'placeholder' => translate('company'))); ?>
                                    <?php echo form_error('company'); ?>
                                </div>
                                <div class="error" id="company_username_validate"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('website'), 'website', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => 'off', 'id' => 'website', 'class' => 'form-control', 'type' => 'text', 'name' => 'website', 'value' => $website, 'placeholder' => translate('website'))); ?>
                                    <?php echo form_error('website'); ?>
                                </div>
                                <div class="error" id="website_validate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title"><?php echo translate('profile_image'); ?></label>
                                    <div class="d-inline-block">
                                        <?php
                                        echo form_input(array('type' => 'hidden', 'name' => 'hidden_profile_image', 'id' => 'hidden_profile_image', 'value' => $profile_image));
                                        if ($id == 0) {
                                            echo form_input(array('type' => 'file', 'id' => 'profile_image', 'required' => "true", 'onchange' => 'readURL(this)', 'class' => 'form-control', 'name' => 'profile_image', 'accept' => 'image/x-png,image/gif,image/jpeg,image/png'));
                                        } else {
                                            echo form_input(array('type' => 'file', 'id' => 'profile_image', 'onchange' => 'readURL(this)', 'class' => 'form-control', 'name' => 'profile_image', 'accept' => 'image/x-png,image/gif,image/jpeg,image/png'));
                                        }
                                        ?><br/>
                                        <?php echo form_error('profile_image'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="preview"><?php echo translate('preview'); ?></label><br/>
                                    <div class="d-inline-block">
                                        <img id="preview"  src="<?php echo $image; ?>"  style="height: 50px;width: 50px"/>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label><?php echo translate('status'); ?><small class="required">*</small></label>
                                <div class="form-group form-inline">
                                    <?php
                                    $active = $inactive = '';
                                    if ($status == "I") {
                                        $inactive = "checked";
                                    } else {
                                        $active = "checked";
                                    }
                                    ?>
                                    <div class="form-group mr-2">
                                        <input name='status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                        <label for="active"><?php echo translate('active'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
                                        <label for='inactive'><?php echo translate('inactive'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><?php echo translate('submit'); ?></button>
                                    <a href="<?php echo base_url('admin/vendor'); ?>" class="btn btn-info waves-effect"><?php echo translate('cancel'); ?></a>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!--/Form with header-->
            </div>
            <!--Card-->
        </div>
    </div>
</div>
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/vendor_register.js" type="text/javascript"></script>