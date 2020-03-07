<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $form_url = 'vendor/save-slider';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
    $form_url = 'admin/save-slider';
}

$status = (set_value("status")) ? set_value("status") : (!empty($slider_data) ? $slider_data['status'] : '');
$image_data = !empty($slider_data) ? $slider_data['image'] : '';
$id = (set_value("id")) ? set_value("id") : (!empty($slider_data) ? $slider_data['id'] : 0);
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('gallery_image'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/manage-slider'); ?>"><?php echo translate('gallery_image'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo isset($id) && $id > 0 ? translate('update') : translate('add'); ?> <?php echo translate('gallery_image'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <?php
                        echo form_open_multipart($form_url, array('name' => 'SliderForm', 'id' => 'SliderForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                        echo form_input(array('type' => 'hidden', 'name' => 'old_slider_image', 'id' => 'old_slider_image', 'value' => $image_data));
                        echo form_input(array('type' => 'hidden', 'name' => 'folder_name', 'id' => 'folder_name', 'value' => isset($folder_name) && $folder_name != '' ? $folder_name : ''));
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="image-data">
                                    <label for="image"><?php echo translate('image'); ?><small class="required">*</small></label>
                                    <input type="file" id="imageurl" name="image" class="form-control" value="<?php echo $image_data; ?>" onchange="readURL(this)" <?php echo isset($image_data) && $image_data != '' ? '' : 'required'; ?> >
                                    <?php echo form_error('image'); ?>
                                </div>
                                <div class="form-group">
                                    <?php if (isset($image_data) && $image_data != '') { ?>
                                        <img id="imageurl"  class="img"  style="border-radius:2%;" src="<?php echo check_admin_image(UPLOAD_PATH . "slider/" . $image_data); ?>" alt="No Image" width="100" height="100">
                                    <?php } else { ?>
                                        <img id="imageurl" class="img"  style="border-radius:2%;" src="<?php echo check_admin_image(img_path . "/no-image.png"); ?>" alt="No Image" width="100" height="100">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label><?php echo translate('status'); ?><small class="required">*</small></label>
                                <div class="form-inline">
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

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary"><?php echo translate('save'); ?></button>
                            <a href="<?php echo base_url($folder_name.'/manage-slider'); ?>" class="btn btn-info waves-effect"><?php echo translate('cancel'); ?></a>
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
<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/slider.js" type="text/javascript"></script>
