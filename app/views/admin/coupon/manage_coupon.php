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
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('coupon'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/coupon'); ?>"><?php echo translate('coupon'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-coupon'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('coupon'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered  mdl-data-table booking_datatable">
                                <thead>
                                <tr>
                                    <th class="text-center font-bold dark-grey-text">#</th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('title'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('code'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('discount_type'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('discount_value'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('created_date'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($coupon_data) && count($coupon_data) > 0) {
                                    foreach ($coupon_data as $key => $row) {

                                        if (isset($row['id']) && $row['id'] != NULL) {
                                            if ($row['status'] == "A") {
                                                $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                            } else {
                                                $status_string = '<span class="label label-danger">' . translate('inactive') . '</span>';
                                            }
                                            if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                $update_url = 'vendor/update-coupon/' . $row['id'];
                                                $manage_url = 'vendor/manage-coupon/' . $row['id'];
                                            } else {
                                                $update_url = 'admin/update-coupon/' . $row['id'];
                                                $manage_url = 'admin/manage-coupon/' . $row['id'];
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1; ?></td>
                                                <td class="text-center"><?php echo $row['title']; ?></td>
                                                <td class="text-center"><?php echo $row['code']; ?></td>
                                                <td class="text-center"><a class="badge badge-info" style="padding: 0.2rem 1.6rem;" href="javascript:void(0)"><?php echo ($row['discount_type'] == 'A') ? "Amount" : "Percentage"; ?></a></td>
                                                <td class="text-center"><?php echo $row['discount_value']; ?></td>
                                                <td class="text-center"><?php echo $status_string; ?></td>
                                                <td class="text-center"><?php echo get_formated_date($row['created_date'], "N"); ?></td>
                                                <td class="td-actions text-center">
                                                    <a href="<?php echo base_url($update_url); ?>" class="btn btn-sm bg-info-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/coupon.js" type='text/javascript'></script>
