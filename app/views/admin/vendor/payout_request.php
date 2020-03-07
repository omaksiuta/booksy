<?php
include VIEWPATH . 'admin/header.php';
$get_current_currency = get_current_currency();
?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('payout_request')." ".translate('vendor'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/vendor'); ?>"><?php echo translate('vendor'); ?></a></li>
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
                            <table class="table table-bordered mdl-data-table booking_datatable" id="example">
                                <thead>
                                <tr>
                                    <th class="text-center font-bold dark-grey-text">#</th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('vendor_name'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('payment_gateway'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('amount'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('cash_payment_fee'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('status'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('request_date'); ?></th>
                                    <th class="text-center font-bold dark-grey-text"><?php echo translate('action'); ?></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if (isset($payment_data) && count($payment_data) > 0) {
                                    foreach ($payment_data as $row) {
                                        $status = "";
                                        if ($row['status'] == 'P') {
                                            $status = "<span class='badge badge-warning'>" . translate('pending') . "</span>";
                                        } else if ($row['status'] == 'S') {
                                            $status = "<span class='badge badge-success'>" . translate('payout_successful') . "</span>";
                                        } else if ($row['status'] == 'H') {
                                            $status = "<span class='badge badge-info'>" . translate('on_hold') . "</span>";
                                        } else if ($row['status'] == 'F') {
                                            $status = "<span class='badge badge-danger'>" . translate('failed') . "</span>";
                                        }

                                        $other_charge = "";

                                        if (isset($row['other_charge']) && $row['other_charge'] != 0) {
                                            $other_charge = " + " . price_format($row['other_charge']);
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="<?php echo base_url('admin/vendor-details/' . $row['vendor_id']); ?>" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?php echo check_profile_image(UPLOAD_PATH . "profiles/" . $row['vendor_profile_image']); ?>" alt="<?php echo $row['vendor_name']; ?>"></a>
                                                    <a href="<?php echo base_url('admin/vendor-details/' . $row['vendor_id']); ?>"><?php echo $row['vendor_name']; ?>
                                                        <br/><span class="btn btn-sm bg-primary-light text-left"><?php echo $row['company_name']; ?></span>
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-center"><?php echo isset($row['choose_payment_gateway']) ? $row['choose_payment_gateway'] : "NA"; ?></td>
                                            <td class="text-center"><?php echo price_format($row['amount']); ?></td>
                                            <td class="text-center"><?php echo price_format($row['cash_payment']); ?></td>
                                            <td class="text-center"><?php echo $status; ?></td>
                                            <td class="text-center"><?php echo get_formated_date($row['created_date']); ?></td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('payout-request-details/' . (int) $row['id']); ?>"  data-direction="right" class="btn btn-sm bg-primary-light bookslide" title="<?php echo translate('view_details'); ?>"><i class="fe fe-info"></i></a>
                                                <?php if ($row['status'] != 'S'): ?>
                                                    <a id="" data-toggle="modal" onclick='UpdateStatus(this)' data-amount="<?php echo $row['amount']; ?>" data-cpayment="<?php echo isset($row['choose_payment_gateway']) ? $row['choose_payment_gateway'] : ""; ?>" data-target="#update_details" data-id="<?php echo (int) $row['id']; ?>" class="btn btn-sm bg-success-light" title="Post"><?php echo translate('process'); ?></a>
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

<!-- Modal -->
<div class="modal fade" id="update_details">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $attributes = array('id' => 'UpdateRecordForm', 'name' => 'UpdateRecordForm', 'method' => "post");
            echo form_open('', $attributes);
            ?>
            <input type="hidden" id="record_id"/>
            <input type="hidden" id="main_request_price"/>
            <div class="modal-header">
                <h4 id='some_name' class="modal-title" style="font-size: 18px;"><?php echo translate('payout_request'); ?></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="payment_gateway"><?php echo translate('payment_gateway'); ?></label>
                    <select id="payment_gateway" name="payment_gateway"required="" class="form-control" style="display: block !important;">
                        <option value="PayPal">PayPal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_gateway_fee"><?php echo translate('payment_gateway_fee_in_percentage'); ?>:</label>
                    <input type="number" id="payment_gateway_fee" name="payment_gateway_fee" value="0" class="form-control" placeholder="<?php echo translate('payment_gateway_fee_in_percentage'); ?>" required=""/>
                </div>
                <div class="form-group">
                    <label for="updated_amount"><?php echo translate('updated_payment_amount'); ?>:</label>
                    <input type="number" readonly="" id="updated_amount" name="updated_amount" value="" class="form-control" placeholder="<?php echo translate('updated_payment_amount'); ?>" required=""/>
                </div>
                <div class="form-group">
                    <label for="updated_amount"><?php echo translate('other_charge') . " (" . translate('in') . " " . $get_current_currency['currency_code'] . ")" ?>:</label>
                    <input type="number" min="0" id="other_charge" name="other_charge" value="0" class="form-control" placeholder="<?php echo translate('other_charge') . " (" . translate('in') . " " . $get_current_currency['currency_code'] . ")"; ?>"/>
                </div>
                <div class="form-group">
                    <label for="reference_no"><?php echo translate('reference_no'); ?>:</label>
                    <input id="reference_no" name="reference_no" value="" class="form-control" placeholder="<?php echo translate('reference_no'); ?>" required=""/>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary font_size_12" href="javascript:void(0)" id="UpdateStatusBtn" ><?php echo translate('save'); ?></a>
                <button data-dismiss="modal" class="btn btn-danger font_size_12" type="button"><?php echo translate('cancel'); ?></button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php
include VIEWPATH . 'admin/footer.php';
?>
<script src="<?php echo $this->config->item('js_url'); ?>module/vendor.js" type='text/javascript'></script>