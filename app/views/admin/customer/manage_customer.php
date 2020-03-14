<?php include VIEWPATH . 'admin/header.php'; ?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('customer'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/customer'); ?>"><?php echo translate('customer'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url('admin/add-customer'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('customer'); ?></a>
                </div>
            </div>
        </div>

        <!-- /Page Header -->
        <div class="row">
            <div class="col-sm-12">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered booking_datatable mdl-data-table datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo translate('customer_name'); ?></th>
                                            <th><?php echo translate('phone'); ?></th>
                                            <th><?php echo translate('status'); ?></th>
                                            <th><?php echo translate('activity'); ?></th>
                                            <th><?php echo translate('member_join'); ?></th>
                                            <th class="text-center"><?php echo translate('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (isset($customer_data) && count($customer_data) > 0) {
                                            foreach ($customer_data as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="<?php echo base_url('admin/customer-details/' . $row['id']); ?>" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?php echo check_profile_image($row['profile_image']); ?>" alt="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>"></a>
                                                            <a href="<?php echo base_url('admin/customer-details/' . $row['id']); ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?><br/><small><?php echo $row['email']; ?></small></a>
                                                        </h2>
                                                    </td>

                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td><?php echo print_vendor_status($row['status']); ?></td>
                                                    <td><?php echo get_last_activity($row['last_login']); ?></td>
                                                    <td><?php echo get_formated_date($row['created_on'], "N"); ?></td>
                                                    <td class="td-actions text-center">
                                                        <a href="<?php echo base_url('admin/customer-details/' . $row['id']); ?>" class="btn btn-sm bg-success-light" title="<?php echo translate('details'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-info"></i></a>
                                                        <a href="<?php echo base_url('admin/update-customer/' . $row['id']); ?>" class="btn btn-sm bg-info-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                        <span class="d-inline-block" title="<?php echo translate('customer'); ?>" data-toggle="tooltip" data-placement="top">
                                                            <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-danger-light font_size_12"><i class="fe fe-trash"></i></a>
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
            </div>
        </div>

    </div>
</div>
<!-- Modal -->
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/customer.js" type='text/javascript'></script>
