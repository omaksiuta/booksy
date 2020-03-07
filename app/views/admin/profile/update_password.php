<?php include VIEWPATH . 'admin/header.php'; ?>

<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('change')." ".translate('password'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('change')." ".translate('password'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <!--Section-->
                <section class="form-light px-2 sm-margin-b-20 ">
                    <?php $this->load->view('message'); ?>
                    <div class="alert alert-info alert-dismissable mt-3">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span class="d-block"><b> <?php echo translate('info'); ?> - </b></span>
                        <span class="d-block">- <?php echo translate('password_length'); ?></span>
                        <span class="d-block">- <?php echo translate('password_lowercase'); ?></span>
                        <span class="d-block">- <?php echo translate('password_uppercase'); ?></span>
                        <span class="d-block">- <?php echo translate('password_numeric'); ?></span>
                    </div>



                    <div class="card">
                        <div class="card-body resp_mx-0">
                            <?php
                            $hidden = array("id" => $id);
                            $attributes = array('id' => 'Update_password', 'name' => 'Update_password', 'method' => "post");
                            echo form_open('admin/update-password-action', $attributes);
                            ?>
                            <div class="form-group">
                                <label for="old_password"> <?php echo translate('current'); ?> <?php echo translate('password'); ?><small class="required">*</small></label>
                                <input type="password" id="old_password" autocomplete="off"  name="old_password" class="form-control" placeholder="<?php echo translate('current'); ?> <?php echo translate('password'); ?>">
                                <?php echo form_error('old_password'); ?>
                            </div>
                            <div class="form-group">
                                <label for="password"> <?php echo translate('password'); ?> <small class="required">*</small></label>
                                <input type="password" id="password" autocomplete="off"  name="password" class="form-control" placeholder="<?php echo translate('password'); ?>">
                                <?php echo form_error('password'); ?>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"> <?php echo translate('confirm'); ?> <?php echo translate('password'); ?> <small class="required">*</small></label>
                                <input type="password" id="confirm_password" autocomplete="off"  name="confirm_password" class="form-control" placeholder="<?php echo translate('confirm'); ?> <?php echo translate('password'); ?>">
                                <?php echo form_error('confirm_password'); ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><?php echo translate('update'); ?></button>
                                <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-info" style=""><?php echo translate('cancel'); ?></a>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <!--/Form with header-->
                </section>
                <!-- End Section-->
            </div>

        </div>

    </div>
</div>
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/content.js" type="text/javascript"></script>