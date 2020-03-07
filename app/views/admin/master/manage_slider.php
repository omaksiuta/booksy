<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<input id="folder_name" name="folder_name" type="hidden" value="<?php echo isset($folder_name) && $folder_name != '' ? $folder_name : ''; ?>"/>
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
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-slider'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('gallery_image'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mdl-data-table booking_datatable" id="example">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"><?php echo translate('image'); ?></th>
                                    <th class="text-center"><?php echo translate('status'); ?></th>
                                    <th class="text-center"><?php echo translate('created_date'); ?></th>
                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($slider_data) && count($slider_data) > 0) {
                                    foreach ($slider_data as $key => $row) {

                                        if (isset($row['id']) && $row['id'] != NULL) {
                                            if ($row['status'] == "A") {
                                                $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                            } else {
                                                $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                            }

                                            $update_url = $folder_name.'/update-slider/' . $row['id'];
                                            $image_data = !empty($row) ? $row['image'] : '';
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1; ?></td>
                                                <td class="text-center">
                                                    <?php if (isset($image_data) && $image_data != '') { ?>
                                                        <img class="img"  style="border-radius:2%;object-fit: cover;object-position: center;" src="<?php echo check_admin_image(UPLOAD_PATH . "slider/" . $image_data); ?>" alt="No Image" width="100" height="100">
                                                    <?php } else { ?>
                                                        <img class="img"  style="border-radius:2%;object-fit: cover;object-position: center;" src="<?php echo check_admin_image(img_path . "/no-image.png"); ?>" alt="No Image" width="100" height="100">
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center"><?php echo $status_string; ?></td>
                                                <td class="text-center"><?php echo get_formated_date($row['created_on'], "N"); ?></td>
                                                <td class="td-actions text-center">
                                                    <a href="<?php echo base_url($update_url); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                    <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"><a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash"></i></a></span>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!--col-md-12-->
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
<script src="<?php echo $this->config->item('js_url'); ?>module/slider.js" type='text/javascript'></script>
