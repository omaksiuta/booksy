<?php
$login_user_details = get_login_admin();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" type="image/x-icon" href="<?php echo get_fevicon(); ?>"/>
        <title><?php
            echo (get_CompanyName());
            if (!empty($title))
                echo " | " . $title;
            ?></title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/global/css/bootstrap.min.css'); ?>">
        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/global/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/global/css/feathericon.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/morris/morris.css'); ?>">
        <!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css'); ?>">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/global/css/toastr.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/custom.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/datatables/datatables.min.css'); ?>">

        <!-- Seelct2 -->
        <link rel="stylesheet" href="<?php echo base_url('assets/global/css/select2.min.css'); ?>">
        <!-- Loader -->
        <link href ="<?php echo $this->config->item('assets_url'); ?>loader/css/preloader.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="<?php echo base_url('assets/js/html5shiv.min.js'); ?>"></script>

        <script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
        <![endif]-->
        <?php include VIEWPATH . 'front/translation_js.php'; ?>

    </head>
    <body>
        <div id="loadingmessage" class="loadingmessage"></div>
        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Header -->
            <div class="header">
                <!-- Logo -->
                <div class="header-left">
                    <a href="<?php echo base_url('admin/dashboard'); ?>" class="logo">
                        <img src="<?php echo get_CompanyLogo(); ?>" alt="<?php echo get_CompanyName(); ?>">
                    </a>
                    <a href="<?php echo base_url('admin/dashboard'); ?>" class="logo logo-small mt-2"><h3><?php echo mb_substr(get_CompanyName(), 0, 1, 'utf-8'); ?></h3></a>
                </div>
                <!-- /Logo -->

                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fe fe-text-align-left"></i>
                </a>
                <!-- Mobile Menu Toggle -->
                <a class="mobile_btn" id="mobile_btn">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- /Mobile Menu Toggle -->

                <!-- Header Right Menu -->
                <ul class="nav user-menu">
                    <li class="nav-item noti-dropdown">
                        <a href="<?php echo base_url(); ?>" target="_blank" class="nav-link">
                            <i class="fe fe-laptop"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown has-arrow">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img class="rounded-circle" src="<?php echo check_profile_image(UPLOAD_PATH . "profiles/" . $login_user_details['profile_image']); ?>" width="31" alt="<?php echo $login_user_details['first_name'] . " " . $login_user_details['last_name']; ?>"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <img src="<?php echo check_profile_image(UPLOAD_PATH . "profiles/" . $login_user_details['profile_image']); ?>" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                                <div class="user-text">
                                    <h6><?php echo $login_user_details['first_name'] . " " . $login_user_details['last_name']; ?></h6>
                                    <p class="text-muted mb-0">Administrator</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="<?php echo base_url('admin/profile'); ?>"><?php echo translate('profile'); ?></a>
                            <a class="dropdown-item" href="<?php echo base_url('admin/change-password'); ?>"><?php echo translate('change_password'); ?></a>
                            <a class="dropdown-item" href="<?php echo base_url('admin/logout'); ?>"><?php echo translate('logout'); ?></a>
                        </div>
                    </li>
                    <!-- /User Menu -->

                </ul>
                <!-- /Header Right Menu -->

            </div>
            <!-- /Header -->

            <?php include VIEWPATH . 'admin/sidebar.php'; ?>
