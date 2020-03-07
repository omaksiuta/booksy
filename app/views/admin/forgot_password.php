<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/x-icon" href="<?php echo get_fevicon(); ?>"/>
    <!-- SITE META -->
    <title ><?php
        echo get_CompanyName();
        if (!empty($title))
            echo " | " . $title;
        ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/global/css/bootstrap.min.css');?>">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/global/css/font-awesome.min.css');?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css');?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/custom.css');?>">
    <!-- Loader -->
    <link href ="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('assets/js/html5shiv.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/respond.min.js');?>"></script>
    <![endif]-->
    <?php include VIEWPATH . 'front/translation_js.php'; ?>
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper login-body">
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                    <a href="<?php echo base_url('admin/login'); ?>"><img class="img-fluid" src="<?php echo get_CompanyLogo(); ?>" alt="<?php echo get_CompanyName(); ?>"></a>
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1><?php echo translate('forgot_password'); ?></h1><br/>

                        <!-- Form -->
                        <?php $this->load->view('message'); ?>
                        <?php
                        $attributes = array('id' => 'Forgot_password', 'name' => 'Forgot_password', 'method' => "post");
                        echo form_open('admin/forgot-password-action', $attributes);
                        ?>
                        <div class="form-group">
                            <input type="email" autocomplete="off"  placeholder="<?php echo translate('email'); ?>" id="email" name="email" value='<?php if (!empty($enter_email)) echo $enter_email; ?>' class="form-control">
                            <?php echo form_error('email'); ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo translate('submit'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                        <!-- /Form -->

                        <div class="text-center forgotpass">
                            <a href="<?php echo base_url("admin/login"); ?>"><?php echo translate('login'); ?>?</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main Wrapper -->
<!-- jQuery -->
<script src="<?php echo base_url('assets/global/js/jquery-3.2.1.min.js');?>"></script>
<!-- Bootstrap Core JS -->
<script src="<?php echo base_url('assets/global/js/popper.min.js');?>"></script>
<script src="<?php echo base_url('assets/global/js/bootstrap.min.js');?>"></script>
<!-- Custom JS -->
<script src="<?php echo $this->config->item('assets_url'); ?>loader/js/jquery.preloader.min.js"></script>
<script src="<?php echo base_url('assets/global/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/admin/js/script.js');?>"></script>
<script src="<?php echo $this->config->item('js_url'); ?>module/content.js" type="text/javascript"></script>
</body>
</html>