<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
$cust_id = $staff_data['id'];
$profile_image = $staff_data['profile_image'];
$first_name = $staff_data['first_name'];
$last_name = $staff_data['last_name'];
$email = $staff_data['email'];
$phone_country_code = $staff_data['phone_country_code'];
$phone = $staff_data['phone'];
$address = $staff_data['address'];
$designation = $staff_data['designation'];
$city = $staff_data['city'];
$state = $staff_data['state'];
$country = $staff_data['country'];
$created_on = $staff_data['created_on'];
$company_name = $staff_data['company_name'];
$website = $staff_data['website'];
$fb_link = $staff_data['fb_link'];
$twitter_link = $staff_data['twitter_link'];
$instagram_link = $staff_data['instagram_link'];
$google_link = $staff_data['google_link'];
$my_wallet = $staff_data['my_wallet'];
$folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <?php $this->load->view('message'); ?>
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('staff') . " " . translate('profile'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_url . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_url . '/staff'); ?>"><?php echo translate('staff'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('profile'); ?></a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a target="_blank" href="<?php echo check_profile_image(UPLOAD_PATH . "profiles/" . $profile_image); ?>">
                                <img class="rounded-circle" alt="User Image" src="<?php echo check_profile_image(UPLOAD_PATH . "profiles/" . $profile_image); ?>">
                            </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                            <h4 class="user-name mb-0"><?php echo $first_name . " " . $last_name; ?></h4>
                            <h6 class="text-muted"><?php echo $email; ?></h6>
                            <div class="user-Location"><?php echo isset($city) ? '<i class="fa fa-map-marker"></i> ' . $city : ""; ?><?php echo isset($state) ? ',' . $state : ""; ?><?php echo isset($country) ? ',' . $country : ""; ?></div>
                            <?php if (isset($address) && $address != NULL): ?>
                                <div class="about-text"><?php echo $address; ?></div>
                            <?php endif; ?>

                        </div>
                        <div class="col-auto profile-btn">
                            <a href="<?php echo base_url($folder_url . '/update-staff/' . $cust_id); ?>" class="btn btn-primary"><?php echo translate('edit'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#per_details_tab"><?php echo translate('details'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#password_tab"><?php echo translate('password'); ?></a>
                        </li>

                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">

                        <!-- Personal Details -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('name'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $first_name . " " . $last_name; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('email'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $email; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('phone'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $phone_country_code . "" . $phone; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('designation'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $designation; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /Personal Details -->
                    </div>
                    <!-- /Personal Details Tab -->

                    <!-- Change Password Tab -->
                    <div id="password_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo translate('change_password'); ?></h5>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <?php
                                        $attributes = array('id' => 'Reset_password', 'name' => 'Reset_password', 'method' => "post");
                                        echo form_open($folder_url . '/reset-staff-password', $attributes);
                                        ?>
                                        <input type="hidden" id="staff_id" name="staff_id" value="<?php echo $cust_id; ?>"/>

                                        <div class="form-group">
                                            <label><?php echo translate('password'); ?></label>
                                            <input required="" autocomplete="off" id="password" name="password" placeholder="<?php echo translate('password'); ?>" type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo translate('confirm_password'); ?></label>
                                            <input required="" autocomplete="off" type="password" name="cpassword" id="cpassword" placeholder="<?php echo translate('confirm_password'); ?>" class="form-control">
                                        </div>
                                        <button class="btn btn-primary" type="submit"><?php echo translate('save'); ?></button>
                                        </form>
                                    </div>

                                    <div class="col-md-6 col-lg-6 border-left text-center p-20">
                                        <?php
                                        $attributes = array('id' => 'send_forgot_password', 'name' => 'send_forgot_password', 'method' => "post");
                                        echo form_open($folder_url . '/send-staff-forgot-password-link', $attributes);
                                        ?>
                                        <input type="hidden" id="cust_id" name="staff_id" value="<?php echo $cust_id; ?>"/>
                                        <input type="hidden" id="email" name="email" value="<?php echo $email; ?>"/>
                                        <button class="btn btn-success" type="submit"><?php echo translate('send_forgot_password_link'); ?></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Change Password Tab -->
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /Page Wrapper -->
<?php include VIEWPATH . $folder_name . '/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/staff.js" type='text/javascript'></script>
