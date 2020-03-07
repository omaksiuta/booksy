<?php
include VIEWPATH . 'admin/header.php';
$folder_name="admin";
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('membership')." ".translate('payment'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/manage-package'); ?>"><?php echo translate('package'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mdl-data-table booking_datatable" id="example">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left"><?php echo translate('Name'); ?></th>
                                    <th class="text-left"><?php echo translate('Title'); ?></th>
                                    <th class="text-center"><?php echo translate('Price'); ?></th>
                                    <th class="text-center"><?php echo translate('validity'); ?></th>
                                    <th class="text-center"><?php echo translate('Status'); ?></th>
                                    <th class="text-center"><?php echo translate('Created_Date'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($payment_history) && count($payment_history) > 0) {
                                    foreach ($payment_history as $payment_key => $payment_row) {
                                        if ($payment_row['membership_status'] == "A") {
                                            $status_string = '<span class="badge badge-success">' . translate('Active') . '</span>';
                                        } else {
                                            $status_string = '<span class="badge badge-danger">' . translate('Expired') . '</span>';
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $payment_key + 1; ?></td>
                                            <td class="text-left"><?php echo ($payment_row['first_name']) . " " . ($payment_row['last_name']); ?></td>
                                            <td class="text-left"><?php echo $payment_row['title']; ?></td>
                                            <td class="text-center"><?php echo price_format(number_format($payment_row['price'], 0)); ?></td>
                                            <td class="text-center"><?php echo $payment_row['package_month']; ?> <?php echo translate('month'); ?></td>
                                            <td class="text-center"><?php echo $status_string; ?></td>
                                            <td class="text-center"><?php echo date("d-m-Y", strtotime($payment_row['created_on'])); ?></td>
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
include VIEWPATH . 'admin/footer.php';
?>