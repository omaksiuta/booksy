<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
    $form_url = 'vendor/save-holiday';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
    $form_url = 'admin/save-holiday';
}
$title_e = (set_value("title")) ? set_value("title") : (!empty($holiday) ? $holiday['title'] : '');
$holiday_date = (set_value("holiday_date")) ? date("m/d/Y", strtotime(set_value("holiday_date"))) : (!empty($holiday) ? date("m/d/Y", strtotime($holiday['holiday_date'])) : '');
$status = (set_value("status")) ? set_value("status") : (!empty($holiday) ? $holiday['status'] : '');
$id = !empty($holiday) ? $holiday['id'] : 0;
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('holiday'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/holiday'); ?>"><?php echo translate('holiday'); ?></a></li>
                        <?php if($id>0): ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('update'); ?> <?php echo translate('staff'); ?></a></li>
                        <?php else:?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('add'); ?> <?php echo translate('holiday'); ?></a></li>
                        <?php endif;?>
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
                        echo form_open($form_url, array('name' => 'ServiceHolidayForm', 'id' => 'ServiceHolidayForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title"><?php echo translate('title'); ?><small class="required">*</small></label>
                                    <input type="text" required="" autocomplete="off" id="title" maxlength="40" name="title" value="<?php echo $title_e; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="holiday_date"><?php echo translate('date'); ?><small class="required">*</small></label>
                                    <input type="text"  required=""  autocomplete="off" id="holiday_date" name="holiday_date" value="<?php echo $holiday_date; ?>" class="form-control" placeholder="<?php echo translate('date'); ?>">
                                    <?php echo form_error('holiday_date'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
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
                        </div>

                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><?php echo translate('save'); ?></button>
                                    <a href="<?php echo base_url($folder_name . '/holiday'); ?>" class="btn btn-info"><?php echo translate('cancel'); ?></a>
                                </div>
                            </div>
                        </div>


                        <?php echo form_close(); ?>
                    </div>
                    <!--/Form with header-->
                </div>
                <!--Card-->
            </div>

        </div>
    </div>
</div>
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/holiday.js" type='text/javascript'></script>
<script>
    if ($('#holiday_date').length > 0) {
        $('#holiday_date').datepicker({
            format: 'mm/dd/yyyy',
            minDate: new Date()
        });
    }
</script>