<?php include VIEWPATH . 'admin/header.php'; ?>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('vendor'); ?></h3>
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
                                    <th class="text-center">#</th>
                                    <th class="text-left"><?php echo translate('name'); ?></th>
                                    <th class="text-left"><?php echo translate('email'); ?></th>
                                    <th class="text-center"><?php echo translate('status'); ?></th>
                                    <th class="text-center"><?php echo translate('verification'); ?></th>
                                    <th class="text-center"><?php echo translate('activity'); ?></th>
                                    <th class="text-center"><?php echo translate('member_join'); ?></th>
                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if (isset($vendor_data) && count($vendor_data) > 0) {
                                    foreach ($vendor_data as $row) {

                                        $profile_status = "";

                                        if ($row['profile_status'] == 'V') {
                                            $profile_status = "<span class='badge badge-primary'>".translate('approved')."</span>";
                                        } elseif ($row['profile_status'] == 'N') {
                                            $profile_status = "<span class='badge badge-warning'>".translate('unverified')."</span>";
                                        } elseif ($row['profile_status'] == 'R') {
                                            $profile_status = "<span class='badge badge-danger'>".translate('rejected')."</span>";
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="<?php echo base_url('admin/vendor-details/' . $row['id']); ?>" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?php echo check_profile_image($row['profile_image']); ?>" alt="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>"></a>
                                                    <a href="<?php echo base_url('admin/vendor-details/' . $row['id']); ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                                        <br/><span class="btn btn-sm bg-primary-light text-left"><?php echo $row['company_name']; ?></span>
                                                    </a>
                                                </h2>
                                            </td>
                                            <td class="text-left"><?php echo $row['email']; ?></td>
                                            <td class="text-center"><?php echo print_vendor_status($row['status']); ?></td>
                                            <td class="text-center"><?php echo $profile_status; ?></td>
                                            <td><?php echo get_last_activity($row['last_login']); ?></td>
                                            <td class="text-center"><?php echo get_formated_date($row['created_on'], "N"); ?></td>
                                            <td class="td-actions text-center">
                                                <a href="<?php echo base_url('admin/vendor-details/' . $row['id']); ?>" class="btn btn-sm bg-success-light" title="<?php echo translate('details'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-info"></i></a>
                                                <a href="<?php echo base_url('admin/update-vendor/' . $row['id']); ?>" class="btn btn-sm bg-primary-light" title="<?php echo translate('edit'); ?>" data-toggle="tooltip" data-placement="top"><i class="fe fe-pencil"></i></a>
                                                <span class="d-inline-block" title="<?php echo translate('customer'); ?>" data-toggle="tooltip" data-placement="top">
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
<!-- Status Modal -->
<div class="modal fade" id="change-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $attributes = array('id' => 'StausForm', 'name' => 'StausForm', 'method' => "post");
            echo form_open('', $attributes);
            ?>
            <input type="hidden" id="CustomerIDVal"/>
            <div class="modal-header">
                <h4 id='CustomerTitle' class="modal-title" style="font-size: 18px;"></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select name="get_status" id="get_status" class="form-control" required style="display: block !important;">
                        <option value=""><?php echo translate('change_status'); ?></option>
                        <option value="A"><?php echo translate('active'); ?></option>
                        <option value="I"><?php echo translate('inactive'); ?></option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">

                <a class="btn btn-primary font_size_12" href="javascript:void(0)" id="CustomerChange" ><?php echo translate('confirm'); ?></a>
                <button data-dismiss="modal" class="btn btn-danger font_size_12" type="button"><?php echo translate('close'); ?></button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/vendor.js" type='text/javascript'></script>
