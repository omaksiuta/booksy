<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $folder_name = 'admin';
}
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage') . " " . translate('currency'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name . '/currency'); ?>"><?php echo translate('currency'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name . '/add-currency'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('currency'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered booking_datatable mdl-data-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left"><?php echo translate('title'); ?></th>
                                        <th class="text-center"><?php echo translate('code'); ?></th>
                                        <th class="text-center">Currency Code</th>
                                        <th class="text-center">Stripe Supported</th>
                                        <th class="text-center">PayPal Supported</th>
                                        <th class="text-center"><?php echo translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (isset($currency_data) && count($currency_data) > 0) {
                                        foreach ($currency_data as $row) {

                                            if ($row['stripe_supported'] == "Y") {
                                                $stripe_supported = '<span class="badge badge-success">' . translate('yes') . '</span>';
                                            } else {
                                                $stripe_supported = '<span class="badge badge-danger">' . translate('no') . '</span>';
                                            }

                                            if ($row['paypal_supported'] == "Y") {
                                                $paypal_supported = '<span class="badge badge-success">' . translate('yes') . '</span>';
                                            } else {
                                                $paypal_supported = '<span class="badge badge-danger">' . translate('no') . '</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-left"><?php echo $row['title']; ?></td>
                                                <td class="text-center"><?php echo $row['code']; ?></td>
                                                <td class="text-center"><?php echo $row['currency_code']; ?></td>
                                                <td class="text-center"><?php echo $stripe_supported; ?></td>
                                                <td class="text-center"><?php echo $paypal_supported; ?></td>
                                                <td class="td-actions text-center">
                                                    <?php if ($row['id'] > 25): ?>
                                                        <a href="<?php echo base_url('admin/update-currency/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>

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

<!-- Status Modal -->
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
