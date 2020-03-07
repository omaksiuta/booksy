<?php
include VIEWPATH . 'admin/header.php';
?>
    <div class="page-wrapper" style="min-height: 473px;">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-7 col-auto">
                        <h3 class="page-title"><?php echo translate('vendor_Payment')." ".translate('vendor'); ?></h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/vendor'); ?>"><?php echo translate('vendor'); ?></a></li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="<?php echo base_url('admin/add-vendor'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('vendor'); ?></a>
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
                                        <th class="text-center font-bold dark-grey-text">#</th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('name'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('title'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('category'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('price'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_type'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('transfer_status'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('event_creater'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('created_date'); ?></th>
                                        <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (isset($vendor_payment) && count($vendor_payment) > 0) {
                                        foreach ($vendor_payment as $payment_key => $payment_row) {
                                            if ($payment_row['transfer_status'] == "S") {
                                                $status_string = '<span class="badge badge-success">' . translate('success') . '</span>';
                                            } else {
                                                $status_string = '<span class="badge badge-danger">' . translate('pending') . '</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $payment_key + 1; ?></td>
                                                <td class="text-center"><?php echo ($payment_row['first_name']) . " " . ($payment_row['last_name']); ?></td>
                                                <td class="text-center"><?php echo $payment_row['title']; ?></td>
                                                <td class="text-center"><?php echo $payment_row['category_title']; ?></td>
                                                <td class="text-center"><?php echo price_format(number_format($payment_row['price'], 0)); ?></td>
                                                <td class="text-center"><?php echo $payment_row['payment_method']; ?></td>
                                                <td class="text-center"><?php echo $status_string; ?></td>
                                                <td class="text-center"><?php echo ($payment_row['cre_first_name']) . " " . ($payment_row['cre_last_name']); ?></td>
                                                <td class="text-center"><?php echo get_formated_date($payment_row['created_on'], "N"); ?></td>
                                                <td class="text-center">
                                                    <?php if ($payment_row['transfer_status'] == 'P') { ?>
                                                        <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $payment_row['id']; ?>" class="btn btn-sm blue-gradient font-bold waves-effect waves-light"><?php echo translate('send'); ?></a>
                                                        <?php
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
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

<script>
    function DeleteRecord(element) {
        var id = $(element).attr('data-id');
        var title = 'Send Vendor Payment';
        $("#some_name").html(title);
        $("#confirm_msg").html("Are you sure you want to send payment?");
        $("#record_id").val(id);
    }
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/send-vendor-payment/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (data) {
                window.location.reload();
            }
        });
    });
</script>
<?php
include VIEWPATH . 'admin/footer.php';
?>