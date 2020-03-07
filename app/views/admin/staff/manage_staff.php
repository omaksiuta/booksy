<?php

if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<input type="hidden" id="folder_name" value="<?php echo $folder_name; ?>"/>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('staff'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/staff'); ?>"><?php echo translate('staff'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name . '/add-staff'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('staff'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered  mdl-data-table" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left"><?php echo translate('name'); ?></th>
                                        <th class="text-center"><?php echo translate('phone'); ?></th>
                                        <th class="text-center"><?php echo translate('status'); ?></th>
                                        <th class="text-center"><?php echo translate('activity'); ?></th>
                                        <th class="text-center"><?php echo translate('member_join'); ?></th>
                                        <th class="text-center"><?php echo translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (isset($staff_data) && count($staff_data) > 0) {
                                        foreach ($staff_data as $row) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-left">
                                                    <h2 class="table-avatar">
                                                        <a href="<?php echo base_url($folder_name . '/staff-details/' . $row['id']); ?>" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?php echo check_profile_image(UPLOAD_PATH . "profiles/" . $row['profile_image']); ?>" alt="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>"></a>
                                                        <a href="<?php echo base_url($folder_name . '/staff-details/' . $row['id']); ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?><br/><small><?php echo $row['email']; ?></small></a>
                                                    </h2>
                                                </td>
                                                <td class="text-center"><?php echo $row['phone']; ?></td>
                                                <td class="text-center"><?php echo print_vendor_status($row['status']); ?></td>
                                                <td><?php echo get_last_activity($row['last_login']); ?></td>
                                                <td class="text-center"><?php echo get_formated_date($row['created_on'], "N"); ?></td>
                                                <td class="td-actions text-center">
                                                    <a href="<?php echo base_url($folder_name . '/staff-details/' . $row['id']); ?>" class="btn btn-sm bg-success-light" title="<?php echo translate('details'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-info"></i></a>
                                                    <a href="<?php echo base_url($folder_name . '/update-staff/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a>
                                                    <span class="d-inline-block" title="<?php echo translate('staff'); ?>" data-toggle="tooltip" data-placement="top">
                                                        <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light"><i class="fe fe-trash"></i></a>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
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
<div class="modal fade" id="change-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $attributes = array('id' => 'StausForm', 'name' => 'StausForm', 'method' => "post");
            echo form_open('', $attributes);
            ?>
            <input type="hidden" id="CustomerIDVal"/>
            <input type="hidden" id="CustomerStatusVal"/>
            <div class="modal-header">
                <h4 id='CustomerTitle' class="modal-title" style="font-size: 18px;"></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p id='CustomerMsg' style="font-size: 15px;"></p>
            </div>
            <div class="modal-footer">

                <a class="btn btn-primary font_size_12" href="javascript:void(0)" id="CustomerChange" ><?php echo translate('confirm'); ?></a>
                <button data-dismiss="modal" class="btn btn-danger font_size_12" type="button"><?php echo translate('close'); ?></button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php include VIEWPATH . $folder_name . '/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/staff.js" type='text/javascript'></script>
