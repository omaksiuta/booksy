<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
    $form_url = 'vendor/save-location';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
    $form_url = 'admin/save-location';
}
$loc_title = (set_value("loc_title")) ? set_value("loc_title") : (!empty($loc_data) ? $loc_data['loc_title'] : '');
$loc_city_id = (set_value("loc_city_id")) ? set_value("loc_city_id") : (!empty($loc_data) ? $loc_data['loc_city_id'] : '');
$loc_status = (set_value("loc_status")) ? set_value("loc_status") : (!empty($loc_data) ? $loc_data['loc_status'] : '');
$id = (set_value("loc_id")) ? set_value("loc_id") : (!empty($loc_data) ? $loc_data['loc_id'] : 0);
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
    <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('location'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/location'); ?>"><?php echo translate('location'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo isset($id) && $id > 0 ? translate('update') : translate('add'); ?> <?php echo translate('location'); ?></a></li>
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
                        echo form_open($form_url, array('name' => 'LocationForm', 'id' => 'LocationForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo translate('select'); ?> <?php echo translate('city'); ?><small class="required">*</small></label>
                                    <?php
                                    $options[''] = translate('select') . ' ' . translate('city');
                                    if (isset($city_list) && !empty($city_list)) {
                                        foreach ($city_list as $row) {
                                            $options[$row['city_id']] = $row['city_title'];
                                        }
                                    }
                                    $attributes = array('class' => 'form-control', 'id' => 'loc_city_id', '');
                                    echo form_dropdown('loc_city_id', $options, $loc_city_id, $attributes);
                                    echo form_error('loc_city_id');
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loc_title"><?php echo translate('title'); ?><small class="required">*</small></label>
                                    <input type="text" autocomplete="off" id="loc_title" name="loc_title" value="<?php echo $loc_title; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">
                                    <?php echo form_error('loc_title'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label><?php echo translate('status'); ?><small class="required">*</small></label>
                                <div class="form-inline">
                                    <?php
                                    $active = $inactive = '';
                                    if ($loc_status == "I") {
                                        $inactive = "checked";
                                    } else {
                                        $active = "checked";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input name='loc_status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                        <label for="active"><?php echo translate('active'); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <input name='loc_status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
                                        <label for='inactive'><?php echo translate('inactive'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary waves-effect"><?php echo translate('save'); ?></button>
                            <a href="<?php echo base_url($folder_name.'/location'); ?>" class="btn btn-info waves-effect"><?php echo translate('cancel'); ?></a>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/location.js" type="text/javascript"></script>
