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
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('service') . " " . translate('add_ons'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/manage-service-addons/'.$service_id); ?>"><?php echo translate('service') . " " . translate('add_ons'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-service-addons/'.$service_id); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add')." ".translate('service') . " " . translate('add_ons'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-header">
                        <?php echo translate('service') . " " . translate('details'); ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><b><?php echo translate('title'); ?> : </b> <?php echo isset($service_data['title']) ? $service_data['title'] : ""; ?></h5>
                        <p class="card-text"><b><?php echo translate('price'); ?> : </b> <?php echo price_format($service_data['price']); ?></p>
                    </div>
                </div>
                <br/>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ox-unset">
                            <table class="table table-bordered booking_datatable mdl-data-table" id="example">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left"><?php echo translate('title'); ?></th>
                                    <th class="text-left"><?php echo translate('description'); ?></th>
                                    <th class="text-center"><?php echo translate('price'); ?></th>
                                    <th class="text-center"><?php echo translate('image'); ?></th>
                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($app_service_addons) && count($app_service_addons) > 0) {
                                    foreach ($app_service_addons as $key => $row) {
                                        $update_url = $folder_name.'/update-service-addons/' . $service_id . '/' . $row['add_on_id'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key + 1; ?></td>
                                            <td class="text-left"><?php echo $row['title']; ?></td>
                                            <td class="text-left"><?php echo $row['details']; ?></td>
                                            <td class="text-center"><?php echo price_format($row['price']); ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo check_admin_image(UPLOAD_PATH . "event/" . $row['image']); ?>" target="_blank">
                                                    <img src="<?php echo check_admin_image(UPLOAD_PATH . "event/" . $row['image']); ?>" class = "img-thumbnail" width="50"/>
                                                </a>
                                            </td>
                                            <td class="td-actions text-center">
                                                <a href="<?php echo base_url($update_url); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top">
                                                    <a id="" data-toggle="modal" data-action="delete-" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['add_on_id']; ?>" class="btn btn-sm bg-danger-light" title="<?php echo translate('delete'); ?>"><i class="fa fa-trash"></i></a>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
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
<script src="<?php echo $this->config->item('js_url'); ?>module/service.js" type='text/javascript'></script>
