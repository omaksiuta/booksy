<?php
$first_name = isset($customer_data['first_name']) ? $customer_data['first_name'] : set_value('first_name');
$last_name = isset($customer_data['last_name']) ? $customer_data['last_name'] : set_value('last_name');
$email = isset($customer_data['email']) ? $customer_data['email'] : set_value('email');
$phone = isset($customer_data['phone']) ? $customer_data['phone'] : set_value('phone');

$city = isset($customer_data['city']) ? $customer_data['city'] : set_value('city');
$state = isset($customer_data['state']) ? $customer_data['state'] : set_value('state');
$country = isset($customer_data['country']) ? $customer_data['country'] : set_value('country');
$birth_date = isset($customer_data['birth_date']) ? $customer_data['birth_date'] : set_value('birth_date');
$phone_country_code = isset($customer_data['phone_country_code']) ? $customer_data['phone_country_code'] : set_value('phone_country_code');
$address = isset($customer_data['address']) ? $customer_data['address'] : set_value('address');
$profile_image = isset($customer_data['profile_image']) ? $customer_data['profile_image'] : set_value('profile_image');

$status = (set_value("status")) ? set_value("status") : (!empty($customer_data) ? $customer_data['status'] : 'A');

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
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('customer'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/customer'); ?>"><?php echo translate('customer'); ?></a></li>

                        <?php if (isset($customer_data['id']) && $customer_data['id'] > 0): ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('update'); ?> <?php echo translate('customer'); ?></a></li>
                        <?php else: ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('add'); ?> <?php echo translate('customer'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url('admin/add-customer'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('customer'); ?></a>
                </div>
            </div>
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">

                    <div class="card-body resp_mx-0">
                        <?php
                        $attributes = array('id' => 'frmCustomer', 'name' => 'frmCustomer', 'method' => "post");
                        echo form_open_multipart($folder_name . '/save-customer', $attributes);
                        ?>
                        <input type="hidden" name="customer_id" id="customer_id" value="<?php echo isset($customer_data['id']) ? $customer_data['id'] : 0; ?>"/>
                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('first_name') . '<small class ="required">*</small>', 'first_name', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'id' => 'first_name', 'class' => 'form-control', 'name' => 'first_name', 'value' => $first_name, 'placeholder' => translate('first_name'))); ?>
                                    <?php echo form_error('first_name'); ?>
                                </div>
                                <div class="error" id="first_name_validate"></div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('last_name') . '<small class ="required">*</small>', 'last_name', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'id' => 'last_name', 'class' => 'form-control', 'name' => 'last_name', 'value' => $last_name, 'placeholder' => translate('last_name'))); ?>
                                    <?php echo form_error('last_name'); ?>
                                </div>
                                <div class="error" id="last_name_validate"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(translate('email') . '<small class ="required">*</small>', 'email', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'type' => 'email', 'id' => 'email', 'class' => 'form-control', 'name' => 'email', 'value' => $email, 'placeholder' => translate('email'))); ?>
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="error" id="email_validate"></div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('phone'), 'phone', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'minlength' => "10", 'maxlength' => "10", 'id' => 'phone', 'class' => 'form-control', 'name' => 'phone', 'value' => $phone, 'placeholder' => translate('phone'))); ?>
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('birth_date'), 'birth_date', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'type' => 'date', 'id' => 'birth_date', 'class' => 'form-control', 'name' => 'birth_date', 'value' => $birth_date, 'placeholder' => translate('birth_date'))); ?>
                                    <?php echo form_error('birth_date'); ?>
                                </div>
                                <div class="error" id="email_validate"></div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('address'), 'phone', array('class' => 'control-label')); ?>
                                    <textarea id="address" name="address" placeholder="<?php echo translate('address'); ?>" class="form-control" ><?php echo $address; ?></textarea>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('city'), 'city', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'type' => 'text', 'id' => 'city', 'class' => 'form-control', 'name' => 'city', 'value' => $city, 'placeholder' => translate('city'))); ?>
                                    <?php echo form_error('city'); ?>
                                </div>

                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('state'), 'state', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'id' => 'state', 'class' => 'form-control', 'name' => 'state', 'value' => $state, 'placeholder' => translate('state'))); ?>
                                    <?php echo form_error('state'); ?>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <?php echo form_label(translate('country'), 'country', array('class' => 'control-label')); ?>
                                    <?php echo form_input(array('autocomplete' => "off", 'type' => 'text', 'id' => 'country', 'class' => 'form-control', 'name' => 'country', 'value' => $country, 'placeholder' => translate('country'))); ?>
                                    <?php echo form_error('country'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?php echo translate('status'); ?><small class="required">*</small></label>
                                    <div class="form-inline">
                                        <?php
                                        $active = $inactive = '';
                                        if ($status == "I") {
                                            $inactive = "checked";
                                        } else {
                                            $active = "checked";
                                        }
                                        ?>
                                        <div class="form-group">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profile_image"><?php echo translate('image'); ?></label>
                                    <div class="">
                                        <?php
                                        echo form_input(array('type' => 'hidden', 'name' => 'hidden_image', 'id' => 'hidden_image', 'value' => $profile_image));
                                        echo form_input(array('type' => 'file', 'onchange' => 'readURL(this)', 'class' => 'form-control', 'id' => 'profile_image', 'name' => 'profile_image', 'accept' => 'image/x-png,image/gif,image/jpeg,image/png'));
                                        ?>
                                        <?php echo form_error('category_image'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <br/>
                                    <div class="d-inline-block">
                                        <img id="preview" src="<?php echo check_profile_image($profile_image); ?>"  style="height: 50px;width: 50px"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><?php echo translate('submit'); ?></button>
                                    <a href="<?php echo base_url('admin/customer'); ?>" class="btn btn-info"><?php echo translate('cancel'); ?></a>
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
        <!-- End Col -->
    </div>
</div>
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/customer.js" type="text/javascript"></script>