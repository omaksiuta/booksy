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
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('city'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/city'); ?>"><?php echo translate('city'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name . '/add-city'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('city'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered booking_datatable mdl-data-table" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left"><?php echo translate('title'); ?></th>
                                        <th class="text-center"><?php echo translate('status'); ?></th>
                                        <?php if ($folder_name == 'admin'): ?>
                                            <th class="text-center"><?php echo translate('is_default'); ?></th>
                                        <?php endif; ?>
                                        <th class="text-center"><?php echo translate('created_date'); ?></th>
                                        <th class="text-center"><?php echo translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($city_data) && count($city_data) > 0) {
                                        foreach ($city_data as $key => $row) {
                                            if ($row['city_status'] == "A") {
                                                $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                            } else {
                                                $status_string = '<span class="badge badge-danger">' . translate('inactive') . '</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1; ?></td>
                                                <td class="text-left"><?php echo $row['city_title']; ?></td>
                                                <td class="text-center"><?php echo $status_string; ?></td>
                                                <?php if ($folder_name == 'admin'): ?>
                                                    <td class="text-center">
                                                        <input type="checkbox" <?php echo ($row['is_default'] == 1) ? "checked='checked'" : ""; ?> style="visibility: visible !important;left: 0px !important;position: relative;" name="is_default" data-id="<?php echo $row['city_id']; ?>"/>
                                                    </td>
                                                <?php endif; ?>

                                                <td class="text-center"><?php echo get_formated_date($row['city_created_on'], "N"); ?></td>
                                                <td class="td-actions text-center">
                                                    <?php
                                                    if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                        $created_by = $this->session->userdata('Vendor_ID');
                                                        if ($created_by == $row['city_created_by']) {
                                                            ?>
                                                            <a href="<?php echo base_url('vendor/update-city/' . $row['city_id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>"><i class="fe fe-pencil"></i></a>
                                                            <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['city_id']; ?>" class="btn btn-sm bg-danger-light" title="<?php echo translate('delete'); ?>"><i class="fe fe-trash"></i></a>
                                                            <?php
                                                        } else {
                                                            echo '-';
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href="<?php echo base_url('admin/update-city/' . $row['city_id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                        <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"><a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['city_id']; ?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash"></i></a></span>
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
<script src="<?php echo $this->config->item('js_url'); ?>module/city.js" type='text/javascript'></script>
<?php if ($folder_name == 'admin'): ?>
    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            $('input[type="checkbox"]').click(function () {
                                                                if ($(this).prop("checked") == true) {

                                                                    var id = $(this).data('id');
                                                                    $.ajax({
                                                                        url: site_url + "admin/default-city/" + id,
                                                                        type: "post",
                                                                        data: {token_id: csrf_token_name},
                                                                        beforeSend: function () {
                                                                            $("body").preloader({
                                                                                percent: 10,
                                                                                duration: 15000
                                                                            });
                                                                        },
                                                                        success: function (data) {
                                                                            if (data == true) {
                                                                                window.location.reload();
                                                                            } else {
                                                                                window.location.reload();
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        });
    </script>
<?php endif; ?>