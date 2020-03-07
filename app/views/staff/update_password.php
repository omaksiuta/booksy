<?php include VIEWPATH . 'staff/header.php';
$folder_name="staff";
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('change'); ?> <?php echo translate('password'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/change-password'); ?>"><?php echo translate('change'); ?> <?php echo translate('password'); ?></a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body resp_mx-0">
                        <?php
                        $hidden = array("id" => $id);
                        $attributes = array('id' => 'Update_password', 'name' => 'Update_password', 'method' => "post");
                        echo form_open('staff/update-password-action', $attributes);
                        ?>
                        <div class="form-group">
                            <label for="old_password"> <?php echo translate('current'); ?> <?php echo translate('password'); ?><small class="required">*</small></label>
                            <input type="password" id="old_password" name="old_password" class="form-control" placeholder="<?php echo translate('current'); ?> <?php echo translate('password'); ?>">
                            <?php echo form_error('old_password'); ?>
                        </div>
                        <div class="form-group">
                            <label for="password"> <?php echo translate('password'); ?> <small class="required">*</small></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="<?php echo translate('password'); ?>">
                            <?php echo form_error('password'); ?>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password"> <?php echo translate('confirm'); ?> <?php echo translate('password'); ?> <small class="required">*</small></label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="<?php echo translate('confirm'); ?> <?php echo translate('password'); ?>">
                            <?php echo form_error('confirm_password'); ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect"><?php echo translate('update'); ?></button>
                            <a  class="btn btn-info waves-effect" href="<?php echo base_url('staff/dashboard'); ?>"><?php echo translate('cancel'); ?></a>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!--/Form with header-->
            </div>
        </div>
    </div>
</div>

<!-- Custom Script --><script src="<?php echo $this->config->item('js_url'); ?>module/staff_content.js" type="text/javascript"></script>
<?php include VIEWPATH . 'staff/footer.php'; ?>   
