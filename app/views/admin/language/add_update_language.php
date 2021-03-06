<?php
include VIEWPATH . 'admin/header.php';
$folder_name = 'admin';
$title = (set_value("title")) ? set_value("title") : (!empty($language_data) ? $language_data['title'] : '');
$status = (set_value("status")) ? set_value("status") : (!empty($language_data) ? $language_data['status'] : '');
$id = (set_value("id")) ? set_value("id") : (!empty($language_data) ? $language_data['id'] : 0);
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
    <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('language'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/language'); ?>"><?php echo translate('language'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/language'); ?>"><?php echo isset($id) && $id > 0 ? translate('update') : translate('add'); ?> <?php echo translate('language'); ?></a></li>
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
                        echo form_open_multipart('admin/save-language', array('name' => 'LanguageForm', 'id' => 'LanguageForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name"><?php echo translate('title'); ?><small class="required">*</small></label>
                                    <input type="text" autocomplete="off" id="title" name="title" required="" value="<?php echo $title; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">
                                    <?php echo form_error('title'); ?>
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

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary"><?php echo translate('save'); ?></button>
                            <a href="<?php echo base_url('admin/manage-language'); ?>" class="btn btn-info waves-effect"><?php echo translate('cancel'); ?></a>
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
include VIEWPATH . 'admin/footer.php';
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/language.js" type="text/javascript"></script>
