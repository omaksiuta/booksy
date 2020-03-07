<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
if (isset($login_type) && $login_type == 'V') {
    $folder_name = 'vendor';
}
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('staff'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/staff'); ?>"><?php echo translate('staff'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 pt-2">
                <?php $this->load->view('message'); ?>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center"><?php echo translate('mandatory_update'); ?></h3>
                    <hr>
                    <div class="col-md-12">
                        <h6 class="alert alert-danger"><?php echo translate('mandatory_message'); ?></h6>
                    </div>
                    <?php if (isset($total_event_category) && $total_event_category == 0) { ?>
                        <div class="col-md-12 mt-40">
                            <h6 class="box-border"><?php echo translate('mandatory_category'); ?> <a href="<?php echo base_url('admin/add-service-category'); ?>" class="btn btn-sm blue-gradient font-bold pull-right mt-0"><?php echo translate('add'); ?></a></h6>
                        </div>
                    <?php } ?>
                    <?php if (isset($total_city) && $total_city == 0) { ?>
                        <div class="col-md-12">
                            <h6 class="box-border"><?php echo translate('mandatory_city'); ?> <a href="<?php echo base_url('admin/add-city'); ?>" class="btn btn-sm blue-gradient font-bold pull-right mt-0"><?php echo translate('add'); ?></a></h6>
                        </div>
                    <?php } ?>
                    <?php if (isset($total_location) && $total_location == 0) { ?>
                        <div class="col-md-12">
                            <h6 class="box-border"><?php echo translate('mandatory_location'); ?> <a href="<?php echo base_url('admin/add-location'); ?>" class="btn btn-sm blue-gradient font-bold pull-right mt-0"><?php echo translate('add'); ?></a></h6>
                        </div>
                    <?php } ?>
                    <?php if (isset($total_payment) && $total_payment == 0) { ?>
                        <div class="col-md-12">
                            <h6 class="box-border"><?php echo translate('mandatory_payment'); ?> <a href="<?php echo base_url('admin/payment-setting'); ?>" class="btn btn-sm blue-gradient font-bold pull-right mt-0"><?php echo translate('add'); ?></a></h6>
                        </div>
                    <?php } ?>
                    <?php if (get_site_setting('commission_percentage') == "" || get_site_setting("minimum_vendor_payout") <= 0) { ?>
                        <div class="col-md-12">
                            <h6 class="box-border"><?php echo translate('mandatory_commission'); ?> <a href="<?php echo base_url('admin/business-setting'); ?>" class="btn btn-sm blue-gradient font-bold pull-right mt-0"><?php echo translate('add'); ?></a></h6>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include VIEWPATH . 'admin/footer.php'; ?>
