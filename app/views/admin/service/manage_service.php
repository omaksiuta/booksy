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
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('service'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/service'); ?>"><?php echo translate('service'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-service'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('service'); ?></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>

                <div class="card">
                    <div class="card-body">
                        <form class="form" role="form" method="GET" id="appointment_filter" action="<?php echo base_url($folder_name . '/manage-service') ?>">
                            <div class="row">
                                <?php if (($this->session->userdata('Type_' . ucfirst($this->uri->segment(1)))) && $this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) != 'V') { ?>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select  name="vendor" id="vendor" class="form-control" onchange="this.form.submit()" style="display: block !important">
                                                <option value=""><?php echo translate('vendor') ?></option>

                                                <?php foreach ($vendor_list as $val): ?>
                                                    <option <?php echo (isset($_REQUEST['vendor']) && $_REQUEST['vendor'] == $val['id']) ? "selected='selected'" : ""; ?> value="<?php echo $val['id'] ?>"><?php echo ($val['company_name']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-info btn-sm" href="<?php echo base_url($folder_name . '/manage-service') ?>"><i class="fa fa-refresh"></i></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered mdl-data-table booking_datatable" id="example">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center"><?php echo translate('title'); ?></th>
                                    <th class="text-center"><?php echo translate('price'); ?></th>
                                    <th class="text-center"><?php echo translate('total_booking'); ?></th>
                                    <th class="text-center"><?php echo translate('add_ons'); ?></th>
                                    <th class="text-center"><?php echo translate('status'); ?></th>
                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($service_data) && count($service_data) > 0) {
                                    foreach ($service_data as $key => $row) {
                                        if (isset($row['id']) && $row['id'] != NULL) {
                                            if ($row['status'] == "A") {
                                                $status_string = '<span class="badge badge-success">' . translate('active') . '</span>';
                                            } else if ($row['status'] == "SS") {
                                                $status_string = '<span class="badge badge-info">' . translate('service_suspended') . '</span>';
                                            } else {
                                                $status_string = '<span class="badge label-danger">' . translate('inactive') . '</span>';
                                            }
                                            if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
                                                $update_url = 'vendor/update-service/' . $row['id'];
                                                $manage_url = 'vendor/manage-appointment/' . $row['id'];
                                            } else {
                                                $update_url = 'admin/update-service/' . $row['id'];
                                                $manage_url = 'admin/manage-appointment/' . $row['id'];
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1; ?></td>
                                                <td class="text-left hover-me">
                                                    <?php echo $row['title']; ?><br/>
                                                    <span class="badge badge-success"><?php echo $row['company_name']; ?></span>
                                                    <div class="hover-short-desc">
                                                        <div class="row">
                                                            <div class="col-md-6 resp_my-0">
                                                                <ul class="ticket_info list-inline">
                                                                    <li class="stat">
                                                                        <span class="stat-label"><?php echo translate('category'); ?> : </span>
                                                                        <span class="stat-value"><?php echo $row['category_title']; ?></span>
                                                                    </li>
                                                                    <li class="stat">
                                                                        <span class="stat-label"><?php echo translate('location') . "/" . translate('city'); ?> : </span>
                                                                        <span class="stat-value"><?php echo $row['loc_title'] . "/" . $row['city_title']; ?></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <?php echo isset($row['payment_type']) && $row['payment_type'] == 'F' ? translate("free") : price_format($row['price']); ?>
                                                </td>
                                                <td class="text-center"><a class="btn btn-sm bg-primary-light" style="padding: 0.2rem 1.6rem;" href="<?php echo base_url($manage_url); ?>"><?php echo get_slote_count($row['id']); ?></a></td>
                                                <td class="text-center">
                                                    <?php if ($row['payment_type'] == 'P'): ?>
                                                        <?php if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') : ?>
                                                            <a href="<?php echo base_url('vendor/manage-service-addons/' . $row['id']); ?>" class="btn-warning btn-sm" title="<?php echo translate('manage') . " " . translate('add_ons'); ?>" data-toggle="tooltip" data-placement="top"><?php echo translate('manage') . " " . translate('add_ons'); ?></a>
                                                        <?php else: ?>
                                                            <a href="<?php echo base_url('admin/manage-service-addons/' . $row['id']); ?>" class="btn-warning btn-sm" title="<?php echo translate('manage') . " " . translate('add_ons'); ?>" data-toggle="tooltip" data-placement="top"><?php echo translate('manage') . " " . translate('add_ons'); ?></a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        --
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?php echo $status_string; ?></td>
                                                <td class="td-actions text-center">
                                                    <a href="<?php echo base_url($update_url); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                    <span class="d-inline-block" title="<?php echo translate('delete'); ?>" data-toggle="tooltip" data-placement="top"><a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light" title="<?php echo translate('delete'); ?>"><i class="fe fe-trash"></i></a></span>
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

<!-- Modal -->
<div class="modal fade" id="delete-record">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $attributes = array('id' => 'DeleteRecordForm', 'name' => 'DeleteRecordForm', 'method' => "post");
            echo form_open('', $attributes);
            ?>
                <input type="hidden" id="record_id"/>
                <div class="modal-header">
                    <h4 id='some_name' class="modal-title" style="font-size: 18px;"></h4>
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p id='confirm_msg' style="font-size: 15px;"></p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary font_size_12" href="javascript:void(0)" id="RecordDelete" ><?php echo translate('confirm'); ?></a>
                    <button data-dismiss="modal" class="btn btn-danger font_size_12" type="button"><?php echo translate('close'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/service.js" type='text/javascript'></script>