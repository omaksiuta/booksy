<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
$title_e = (set_value("title")) ? set_value("title") : (!empty($category_data) ? $category_data['title'] : '');
$status = (set_value("status")) ? set_value("status") : (!empty($category_data) ? $category_data['status'] : '');
$type = (set_value("type")) ? set_value("type") : (!empty($category_data) ? $category_data['type'] : '');
$category_image = (set_value("category_image")) ? set_value("category_image") : (!empty($category_data) ? $category_data['category_image'] : '');
$id = !empty($category_data) ? $category_data['id'] : 0;
$image = check_service_image($category_image);
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>

<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('service') . " " . translate('category'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/service-category'); ?>"><?php echo translate('service') . " " . translate('category'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo isset($id) && $id > 0 ? translate('update') : translate('add'); ?> <?php echo translate("service") . " " . translate('category'); ?></a></li>
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
                        if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                            $form_url = 'vendor/save-service-category';
                        } else {
                            $form_url = 'admin/save-service-category';
                        }
                        ?>
                        <?php
                        echo form_open_multipart($form_url, array('name' => 'ServiceCategoryForm', 'id' => 'ServiceCategoryForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));

                        echo form_input(array('type' => 'hidden', 'name' => 'image_validate', 'id' => 'image_validate', 'value' => 0));
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title"><?php echo translate('title'); ?><small class="required">*</small></label>
                                    <input type="text"  autocomplete="off" id="title" maxlength="40" name="title" value="<?php echo $title_e; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title"><?php echo translate('category_image'); ?><small class="required">*</small></label>
                                    <div class="">
                                        <?php
                                        echo form_input(array('type' => 'hidden', 'name' => 'hidden_category_image', 'id' => 'hidden_category_image', 'value' => $category_image));
                                        if ($id == 0) {
                                            echo form_input(array('type' => 'file', 'required' => "true", 'id' => 'category_image', 'class' => 'form-control', 'name' => 'category_image', 'accept' => 'image/x-png,image/gif,image/jpeg,image/png'));
                                        } else {
                                            echo form_input(array('type' => 'file', 'id' => 'category_image', 'class' => 'form-control', 'name' => 'category_image', 'accept' => 'image/x-png,image/gif,image/jpeg,image/png'));
                                        }
                                        ?><br/>
                                        <?php echo form_error('category_image'); ?>
                                        <small>(Image size must be 40X40.)</small>
                                    </div>
                                    <div class="d-inline-block">
                                        <img id="preview"  src="<?php echo $image; ?>"  style="height: 50px;width: 50px"/>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <?php
                                $active = $inactive = '';
                                if ($status == "I") {
                                    $inactive = "checked";
                                } else {
                                    $active = "checked";
                                }
                                ?>
                                <label><?php echo translate('status'); ?><small class="required">*</small></label>
                                <div class="form-group">
                                    <input name='status' value="A" type='radio' id='active'   <?php echo $active; ?>>
                                    <label for="active"><?php echo translate('active'); ?></label>

                                    <input name='status' type='radio'  value='I' id='inactive'  <?php echo $inactive; ?>>
                                    <label for='inactive'><?php echo translate('inactive'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><?php echo translate('save'); ?></button>
                            <a href="<?php echo base_url($folder_name . '/service-category'); ?>" class="btn btn-info"><?php echo translate('cancel'); ?></a>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/service-category.js" type="text/javascript"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#image_validate').attr('value', 1);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#category_image").change(function () {
        readURL(this);
    });
</script>