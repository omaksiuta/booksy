<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
if (isset($login_type) && $login_type == 'V') {
    $folder_name = 'vendor';
}
$currency_id = isset($currency_data['currency_id']) ? $currency_data['currency_id'] : 25;
$currency_position = isset($currency_data['currency_position']) ? $currency_data['currency_position'] : set_value('currency_position');
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('currency')." ".translate('setting'); ?></h3>
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
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/sitesetting'); ?>"><?php echo translate('site_setting'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/email-setting'); ?>"><?php echo translate('email'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/sms-setting'); ?>"><?php echo translate('sms'); ?></a></li>
                            <li class="nav-item active"><a  class="nav-link active" href="<?php echo base_url('admin/currency-setting'); ?>"><?php echo translate('currency'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/business-setting'); ?>"><?php echo translate('business'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/display-setting'); ?>"><?php echo translate('display'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/payment-setting'); ?>"><?php echo translate('payment'); ?></a></li>
                            <li class="nav-item"><a  class="nav-link" href="<?php echo base_url('admin/vendor-setting'); ?>"><?php echo translate('vendor'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                                <hr/>
                                <div class="">
                                    <?php echo form_open('admin/sitesetting/save_curenncy_setting', array('name' => 'site_business_form', 'id' => 'site_business_form')); ?>
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <?php echo form_label(translate('currency'), 'currency', array('class' => 'control-label')); ?>
                                                <select style="display:block !important;" class="form-control" id="currency_id" name="currency_id">
                                                    <?php foreach($app_currency as $val): ?>
                                                        <option <?php echo ($currency_id==$val['id'])?'selected="selected"':"";?> value="<?php echo $val['id']; ?>"><?php echo $val['title']." (".$val['currency_code'].")"; ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                            <div class="error" id="commission_percentage"></div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <?php echo form_label('Currency Display Position', 'currency', array('class' => 'control-label')); ?>
                                            <select style="display:block !important;"  class="form-control" id="currency_position" name="currency_position">
                                                <option <?php echo ($currency_position=='L')?'selected="selected"':"";?> value="L">Left</option>
                                                <option <?php echo ($currency_position=='R')?'selected="selected"':"";?> value="R">Right</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary waves-effect"><?php echo translate('update'); ?></button>
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
</div>
<script src="<?php echo $this->config->item('js_url'); ?>module/sitesetting.js" type="text/javascript"></script>
<?php include VIEWPATH . 'admin/footer.php'; ?>
