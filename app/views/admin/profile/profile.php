<?php include VIEWPATH . 'admin/header.php'; ?>
<?php
$first_name = (set_value("first_name")) ? set_value("first_name") : $admin_data['first_name'];
$last_name = (set_value("last_name")) ? set_value("last_name") : $admin_data['last_name'];
$company_name = (set_value("company_name")) ? set_value("company_name") : $admin_data['company_name'];
$email = (set_value("email")) ? set_value("email") : $admin_data['email'];
$phone = (set_value("phone")) ? set_value("phone") : $admin_data['phone'];
$address = (set_value("address")) ? set_value("address") : $admin_data['address'];
$fb_link = (set_value("fb_link")) ? set_value("fb_link") : $admin_data['fb_link'];
$twitter_link = (set_value("twitter_link")) ? set_value("twitter_link") : $admin_data['twitter_link'];
$google_link = (set_value("google_link")) ? set_value("google_link") : $admin_data['google_link'];
$instagram_link = (set_value("instagram_link")) ? set_value("instagram_link") : $admin_data['instagram_link'];
$profile_text = (set_value("profile_text")) ? set_value("profile_text") : $admin_data['profile_text'];
$profile_image = $admin_data['profile_image'];
$profile_cover_image = $admin_data['profile_cover_image'];
?>
<!-- Additional method Script -->


<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('profile'); ?> <?php echo translate('update'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('profile'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body resp_mx-0">
                        <?php
                        $attributes = array('id' => 'Profile', 'name' => 'Profile', 'method' => "post");
                        echo form_open_multipart('admin/profile-save', $attributes);
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name"><?php echo translate('company_name'); ?> <small class="required">*</small></label>
                                    <input type="text" autocomplete="off" required="" id="company_name" name="company_name" value="<?php echo $company_name; ?>" class="form-control" placeholder="<?php echo translate('company_name'); ?>">
                                    <?php echo form_error('company_name'); ?>

                                </div>
                                <div class="error" id="first_name_validate"></div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name"><?php echo translate('first_name'); ?> <small class="required">*</small></label>
                                    <input type="text" autocomplete="off" id="first_name" name="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="<?php echo translate('first'); ?><?php echo translate('name'); ?>">
                                    <?php echo form_error('first_name'); ?>

                                </div>
                                <div class="error" id="first_name_validate"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name"><?php echo translate('last_name'); ?> <small class="required">*</small></label>
                                    <input type="text" autocomplete="off" id="last_name" name="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="<?php echo translate('last'); ?><?php echo translate('name'); ?>">
                                    <?php echo form_error('last_name'); ?>
                                </div>
                                <div class="error" id="last_name_validate"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo translate('email'); ?> <small class="required">*</small></label>
                                    <input type="email" autocomplete="off" placeholder="<?php echo translate('email'); ?>" id="email" name="email" value="<?php echo $email; ?>" class="form-control">
                                    <?php echo form_error('email'); ?>

                                </div>
                                <div class="error" id="email_validate"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone"><?php echo translate('phone'); ?> <small class="required">*</small></label>
                                    <input type="text" autocomplete="off" id="phone" name="phone" value="<?php echo $phone; ?>" class="form-control" placeholder="<?php echo translate('phone'); ?>" maxlength="10" minlength="10">
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address"><?php echo translate('address'); ?> <small class="required">*</small></label>
                                    <textarea type="text" id="address" name="address" class="form-control" placeholder="<?php echo translate('address'); ?>"><?php echo $address; ?></textarea>
                                    <?php echo form_error('address'); ?>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile_text"><?php echo translate('profile_text'); ?></label>
                                    <textarea type="text" id="profile_text" name="profile_text" class="form-control" placeholder="<?php echo translate('profile_text'); ?>"><?php echo $profile_text; ?></textarea>
                                    <?php echo form_error('profile_text'); ?>
                                </div>
                                <div class="error" id="phone_validate"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fb_link"> <?php echo translate('facebook_link'); ?></label>
                                    <input type="url" autocomplete="off" placeholder="<?php echo translate('facebook_link'); ?>" id="fb_link" name="fb_link" value="<?php echo $fb_link; ?>" class="form-control">
                                    <?php echo form_error('fb_link'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter_link"> <?php echo translate('twitter_link'); ?></label>
                                    <input type="url" autocomplete="off"  placeholder="<?php echo translate('twitter_link'); ?>" id="twitter_link" name="twitter_link" value="<?php echo $twitter_link; ?>" class="form-control">
                                    <?php echo form_error('twitter_link'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="google_link"> <?php echo translate('google_link'); ?></label>
                                    <input type="url" autocomplete="off"  placeholder="<?php echo translate('google_link'); ?>" id="google_link" name="google_link" value="<?php echo $google_link; ?>" class="form-control">
                                    <?php echo form_error('google_link'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram_link"> <?php echo translate('instagram_link'); ?></label>
                                    <input type="url" autocomplete="off"  placeholder="<?php echo translate('instagram_link'); ?>" id="instagram_link" name="instagram_link" value="<?php echo $instagram_link; ?>" class="form-control">
                                    <?php echo form_error('instagram_link'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <label><?php echo translate('choose_file'); ?></label>
                                <input onchange="readURL(this)" id="imageurl"  type="file" name="profile_image" class="form-control"/>
                                <?php echo form_error('profile_image'); ?>
                            </div>
                            <div class="col-md-6">
                                <label><?php echo translate('choose_file'); ?></label>
                                <input onchange="readURL(this)" id="profileimageurl" class="form-control" type="file" name="profile_cover_image"/>
                                <small>Select Profile Cover Image (Size must be minimum of 1110*266)</small>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <img id="imageurl" class="img" style="border-radius:50%;" src="<?php echo check_profile_image($admin_data['profile_image']); ?>" alt="<?php echo translate('profile'); ?> <?php echo translate('image'); ?>" width="100" height="100">
                            </div>
                            <div class="col-md-6">
                                <?php
                                if (isset($cover_img_src) && $cover_img_src != ''):
                                    $style = 'block';
                                else :
                                    $style = 'none';
                                endif;
                                ?>
                                <img id="profileimageurl"  class="img"  style="width: 250px;height: 100px;" src="<?php echo check_profile_image($admin_data['profile_cover_image']); ?>" alt="">
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn btn-primary" style=""><?php echo translate('update'); ?></button>
                            <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-info" style=""><?php echo translate('cancel'); ?></a>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!--/Form with header-->
                </div>
                <!--Card-->
            </div>
            <!-- End Col -->
        </div>
    </div>
</div>


<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('js_url'); ?>module/content.js" type="text/javascript"></script>