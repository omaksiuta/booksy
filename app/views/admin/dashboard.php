<?php include VIEWPATH . 'admin/header.php'; ?>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12">
                <a href="<?php echo base_url('admin/customer'); ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary">
                                    <i class="fe fe-user"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?php echo $total_customer; ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted"><?php echo translate('customer'); ?></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <a href="<?php echo base_url('admin/vendor'); ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success">
                                    <i class="fe fe-users"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?php echo $total_vendor; ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted"><?php echo translate('vendor'); ?></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <a href="<?php echo base_url('admin/manage-appointment'); ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-danger border-danger">
                                    <i class="fe fe-money"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?php echo $total_appointment; ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted"><?php echo translate('appointment'); ?></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <a href="<?php echo base_url('admin/payout-request'); ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-warning border-warning">
                                    <i class="fe fe-folder"></i>
                                </span>
                                <div class="dash-count">
                                    <h3><?php echo isset($total_payout_request) ? $total_payout_request : 0; ?></h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">

                                <h6 class="text-muted"><?php echo translate('payout_request'); ?></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning w-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <!-- Recent Orders -->
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo translate('unverified') . " " . translate('vendor'); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center font-bold dark-grey-text">#</th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('name'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('company_name'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('verification'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (isset($unverified_vendor) && count($unverified_vendor) > 0) {
                                        foreach ($unverified_vendor as $row) {

                                            $profile_status = "";

                                            if ($row['profile_status'] == 'V') {
                                                $profile_status = translate('approved');
                                            } elseif ($row['profile_status'] == 'N') {
                                                $profile_status = translate('unverified');
                                            } elseif ($row['profile_status'] == 'R') {
                                                $profile_status = translate('rejected');
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-center"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                <td class="text-center"><?php echo $row['company_name']; ?></td>
                                                <td class="text-center"><?php echo $profile_status; ?></td>
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
                <!-- /Recent Orders -->

            </div>
            <div class="col-md-6 d-flex">

                <!-- Feed Activity -->
                <div class="card  card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title">Patients List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Phone</th>
                                        <th>Last Visit</th>
                                        <th>Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Feed Activity -->

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card card-table">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo translate('upcoming_appointment'); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo translate('service'); ?></th>
                                        <th><?php echo translate('customer_name'); ?></th>
                                        <th><?php echo translate('slot_time'); ?></th>
                                        <th><?php echo translate('appointment_date'); ?></th>
                                        <th><?php echo translate('type'); ?></th>
                                        <th><?php echo translate('payment'); ?></th>
                                        <th><?php echo translate('status'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($appointment_data) && count($appointment_data) > 0):
                                        foreach ($appointment_data as $key => $row):
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1; ?></td>
                                                <td class="text-center"><?php echo ($row['title']); ?></td>
                                                <td class="text-center"><?php echo ($row['first_name']) . " " . ($row['last_name']); ?></td>
                                                <td class="text-center"><?php echo convertToHoursMins($row['slot_time']); ?></td>
                                                <td class="text-center"><?php echo get_formated_date($row['start_date'] . " " . $row['start_time']); ?></td>
                                                <?php if ($row['payment_type'] == 'F'): ?>
                                                    <td class="text-center">
                                                        <span class="badge badge-success"><?php echo translate('free'); ?></span>
                                                    </td>
                                                <?php else: ?>
                                                    <td class="text-center">
                                                        <span class="badge badge-primary"><?php echo translate('paid'); ?></span>
                                                    </td>
                                                <?php endif; ?>
                                                <td class="text-center"><?php echo check_appointment_pstatus($row['payment_status']); ?></td>
                                                <td class="text-center"><?php echo check_appointment_status($row['status']); ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-center"><?php echo translate('no_record_found') ?></td>
                                        </tr>
                                    <?php
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->
            </div>
        </div>
        <?php if (isset($pending_appointment) && count($pending_appointment) > 0): ?>
            <div class="row">
                <div class="col-md-12">

                    <!-- Recent Orders -->
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo translate('pending') . " " . translate('appointment'); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-bold dark-grey-text">#</th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('service'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('customer_name'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('slot_time'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('appointment_date'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cnt = 1;
                                        if (isset($pending_appointment) && count($pending_appointment) > 0) {
                                            foreach ($pending_appointment as $row) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $cnt; ?></td>
                                                    <td class="text-center"><?php echo ($row['title']); ?></td>
                                                    <td class="text-center"><?php echo ($row['first_name']) . " " . ($row['last_name']); ?></td>
                                                    <td class="text-center"><?php echo convertToHoursMins($row['slot_time']); ?></td>
                                                    <td class="text-center"><?php echo get_formated_date($row['start_date'] . " " . $row['start_time']); ?></td>
                                                </tr>
                                                <?php
                                                $cnt++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Recent Orders -->
                </div>
            </div>
        <?php endif; ?>

        <?php if (get_site_setting('enable_membership') == 'Y' && count($membership_vendor) > 0): ?>
            <div class="row">
                <div class="col-md-12">

                    <!-- Recent Orders -->
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo translate('vendor') . " " . translate('membership') . " " . translate('validity'); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-bold dark-grey-text">#</th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('name'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('company_name'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('expire_date'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                            <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($membership_vendor as $key => $row):
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1; ?></td>
                                                <td class="text-center"><?php echo ($row['first_name']) . " " . ($row['last_name']); ?></td>
                                                <td class="text-center"><?php echo $row['company_name']; ?></td>
                                                <td class="text-center"><?php echo get_formated_date($row['membership_till'], 'N'); ?></td>
                                                <td class="text-center"><?php echo print_vendor_status($row['status']); ?></td>
                                                <td class="text-center"><a data-toggle="modal" onclick='ReminderAction(this)' data-target="#remainder-membership" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-warning font_size_12" title="<?php echo translate('send_mail'); ?>"><?php echo translate('reminder'); ?></a></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Recent Orders -->
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
<!-- /Page Wrapper -->
<?php include VIEWPATH . 'admin/footer.php'; ?>