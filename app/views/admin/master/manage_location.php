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
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('location'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/location'); ?>"><?php echo translate('location'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-location'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('location'); ?></a>
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
                                    <th class="text-left"><?php echo translate('title'); ?></th>
                                    <th class="text-left"><?php echo translate('city'); ?></th>
                                    <th class="text-center"><?php echo translate('status'); ?></th>
                                    <th class="text-center"><?php echo translate('created_date'); ?></th>
                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($loc_data) && count($loc_data) > 0) {
                                    foreach ($loc_data as $key => $row) {


                                        if ($row['loc_status'] == "A") {
                                            $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                        } else {
                                            $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key + 1; ?></td>
                                            <td class="text-left"><?php echo $row['loc_title']; ?></td>
                                            <td class="text-left"><?php echo $row['city_title']; ?></td>
                                            <td class="text-center"><?php echo $status_string; ?></td>
                                            <td class="text-center"><?php echo get_formated_date($row['loc_created_on'], "N"); ?></td>
                                            <td class="td-actions text-center">
                                                <?php
                                                if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                    $created_by = $this->session->userdata('Vendor_ID');
                                                    if ($created_by == $row['loc_created_by']) {
                                                        ?>
                                                        <a href="<?php echo base_url('vendor/update-location/' . $row['loc_id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>"><i class="fe fe-pencil"></i></a>
                                                        <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['loc_id']; ?>" class="btn btn-sm bg-danger-light" title="<?php echo translate('delete'); ?>"><i class="fe fe-trash"></i></a>
                                                        <?php
                                                    } else {
                                                        echo '-';
                                                    }
                                                } else {
                                                    ?>
                                                    <a href="<?php echo base_url('admin/update-location/' . $row['loc_id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                    <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"><a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['loc_id']; ?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash"></i></a></span>
                                                <?php } ?>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/location.js" type='text/javascript'></script>
