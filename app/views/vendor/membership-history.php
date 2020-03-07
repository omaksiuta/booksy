<?php
include VIEWPATH . 'vendor/header.php';
$folder_name = "vendor";
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('membership') . " " . translate('payment') ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url('vendor/membership-purchase'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('purchase') . " " . translate('now'); ?></a>
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
                                        <th class="text-left"><?php echo translate('name'); ?></th>
                                        <th class="text-center"><?php echo translate('price'); ?></th>
                                        <th class="text-center"><?php echo translate('validity'); ?></th>
                                        <th class="text-center"><?php echo translate('expire_date'); ?></th>
                                        <th class="text-center"><?php echo translate('created_date'); ?></th>
                                        <th class="text-center"><?php echo translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($membership_history) && count($membership_history) > 0) {
                                        foreach ($membership_history as $mem_key => $mem_row) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $mem_key + 1; ?></td>
                                                <td class="text-left"><?php echo $mem_row['title']; ?></td>
                                                <td class="text-center"><?php echo price_format($mem_row['price']); ?></td>
                                                <td class="text-center"><?php echo $mem_row['package_month']; ?> <?php echo translate('month'); ?></td>
                                                <td class="text-center"><?php echo get_formated_date($mem_row['membership_till'], "N"); ?></td>
                                                <td class="text-center"><?php echo get_formated_date($mem_row['created_on'], "N"); ?></td>
                                                <td class="text-center"><a href="<?php echo base_url('vendor/get-membership-details/' . (int) $mem_row['app_membership_id']); ?>"  data-direction="right" class="btn btn-xs fs-10 btn-bold btn-info bookslide" title="<?php echo translate('details'); ?>"><?php echo translate('details'); ?></i></a></td>
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
include VIEWPATH . 'vendor/footer.php';
?>

<script>
    $('.bookslide').slidePanel();
    $(document).on('slidePanel::beforeShow', function (e) {
        $('#loadingmessage').show();
    });
    $(document).on('slidePanel::afterShow', function (e) {
        $('#loadingmessage').hide();
    });
</script>