<?php
include VIEWPATH . 'admin/header.php';
$cust_id = $customer_data['id'];
$profile_image = $customer_data['profile_image'];
$first_name = $customer_data['first_name'];
$last_name = $customer_data['last_name'];
$email = $customer_data['email'];
$phone_country_code = $customer_data['phone_country_code'];
$phone = $customer_data['phone'];
$birth_date = $customer_data['birth_date'];
$address = $customer_data['address'];
$city = $customer_data['city'];
$state = $customer_data['state'];
$country = $customer_data['country'];
$created_on = $customer_data['created_on'];
?>
<div class="page-wrapper">
    <div class="content container-fluid">
        <?php $this->load->view('message'); ?>
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('customer') . " " . translate('profile'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/customer'); ?>"><?php echo translate('customer'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo translate('profile'); ?></a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a target="_blank" href="<?php echo check_profile_image($profile_image); ?>">
                                <img class="rounded-circle" alt="User Image" src="<?php echo check_profile_image($profile_image); ?>">
                            </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                            <h4 class="user-name mb-0"><?php echo $first_name . " " . $last_name; ?></h4>
                            <h6 class="text-muted"><?php echo $email; ?></h6>
                            <div class="user-Location"><?php echo isset($city) ? '<i class="fa fa-map-marker"></i> ' . $city : ""; ?><?php echo isset($state) ? ',' . $state : ""; ?><?php echo isset($country) ? ',' . $country : ""; ?></div>
                            <?php if (isset($address) && $address != NULL): ?>
                                <div class="about-text"><?php echo $address; ?></div>
                            <?php endif; ?>

                        </div>
                        <div class="col-auto profile-btn">
                            <a href="<?php echo base_url('admin/update-customer/' . $cust_id); ?>" class="btn btn-primary"><?php echo translate('edit'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#per_details_tab"><?php echo translate('details'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#password_tab"><?php echo translate('password'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#service_tab"><?php echo translate('service'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#event_tab"><?php echo translate('event'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">

                        <!-- Personal Details -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('name'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $first_name . " " . $last_name; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('birth_date'); ?>:</b></p>
                                            <?php if (isset($birth_date) && $birth_date != NULL): ?>
                                                <p class="col-sm-9"><?php echo get_formated_date($birth_date, 'N'); ?></p>
                                            <?php else: ?>
                                                <p class="col-sm-9"> - </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('email'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $email; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('phone'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $phone_country_code . "" . $phone; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0"><b><?php echo translate('address'); ?>:</b></p>
                                            <p class="col-sm-9 mb-0"><?php echo isset($address) ? $address : "-"; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('name'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $first_name . " " . $last_name; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('birth_date'); ?>:</b></p>
                                            <?php if (isset($birth_date) && $birth_date != NULL): ?>
                                                <p class="col-sm-9"><?php echo get_formated_date($birth_date, 'N'); ?></p>
                                            <?php else: ?>
                                                <p class="col-sm-9"> - </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('email'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $email; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0 mb-sm-3"><b><?php echo translate('phone'); ?>:</b></p>
                                            <p class="col-sm-9"><?php echo $phone_country_code . "" . $phone; ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-left mb-0"><b><?php echo translate('address'); ?>:</b></p>
                                            <p class="col-sm-9 mb-0"><?php echo isset($address) ? $address : "-"; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Personal Details -->
                    </div>
                    <!-- /Personal Details Tab -->

                    <!-- Change Password Tab -->
                    <div id="password_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo translate('change_password'); ?></h5>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <?php
                                        $attributes = array('id' => 'Reset_password', 'name' => 'Reset_password', 'method' => "post");
                                        echo form_open('admin/reset-customer-password', $attributes);
                                        ?>
                                        <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $cust_id; ?>"/>

                                        <div class="form-group">
                                            <label><?php echo translate('password'); ?></label>
                                            <input required="" autocomplete="off" id="password" name="password" placeholder="<?php echo translate('password'); ?>" type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo translate('confirm_password'); ?></label>
                                            <input required="" autocomplete="off" type="password" name="cpassword" id="cpassword" placeholder="<?php echo translate('confirm_password'); ?>" class="form-control">
                                        </div>
                                        <button class="btn btn-primary" type="submit"><?php echo translate('save'); ?></button>
                                        </form>
                                    </div>

                                    <div class="col-md-6 col-lg-6 border-left text-center p-20">
                                        <?php
                                        $attributes = array('id' => 'send_forgot_password', 'name' => 'send_forgot_password', 'method' => "post");
                                        echo form_open('admin/send-forgot-password-link', $attributes);
                                        ?>
                                        <input type="hidden" id="cust_id" name="cust_id" value="<?php echo $cust_id; ?>"/>
                                        <input type="hidden" id="email" name="email" value="<?php echo $email; ?>"/>
                                        <button class="btn btn-success" type="submit"><?php echo translate('send_forgot_password_link'); ?></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Change Password Tab -->


                    <!--  Service -->
                    <div id="service_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table mdl-data-table booking_datatable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center"><?php echo translate('title'); ?></th>
                                                    <th class="text-center"><?php echo translate('appointment_date'); ?></th>
                                                    <th class="text-center"><?php echo translate('vendor'); ?></th>
                                                    <th class="text-center"><?php echo translate('type'); ?></th>
                                                    <th class="text-center"><?php echo translate('payment') . ' ' . translate('status'); ?></th>
                                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                if (isset($service_appointment_data) && count($service_appointment_data) > 0) {
                                                    foreach ($service_appointment_data as $row) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i; ?></td>
                                                            <td class="text-center"><?php echo $row['title']; ?></td>
                                                            <td class="text-center"><?php echo get_formated_date($row['start_date'], ''); ?><br/><?php echo get_formated_time(strtotime($row['start_time'])); ?></td>
                                                            <td class="text-center"><?php echo ($row['first_name']) . ' ' . $row['last_name']; ?></td>
                                                            <td class="text-center"><?php echo $row['payment_type'] == 'F' ? translate('free') : price_format($row['price']); ?></td>
                                                            <td class="text-center"><?php echo check_appointment_pstatus($row['payment_status']); ?></td>
                                                            <td class="text-center">
                                                                <a href="<?php echo base_url('admin/view-booking-details/' . $row['id']); ?>" class="btn btn-sm bg-info-light"><span class="fa fa-info"></span></a>
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

                    <!-- Event -->

                    <div id="event_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table mdl-data-table booking_datatable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center"><?php echo translate('title'); ?></th>
                                                    <th class="text-center"><?php echo translate('date'); ?></th>
                                                    <th class="text-center"><?php echo translate('time'); ?></th>
                                                    <th class="text-center"><?php echo translate('created_by'); ?></th>
                                                    <th class="text-center"><?php echo translate('type'); ?></th>
                                                    <th class="text-center"><?php echo translate('payment') . ' ' . translate('status'); ?></th>
                                                    <th class="text-center"><?php echo translate('action'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                if (isset($event_appointment_data) && count($event_appointment_data) > 0) {
                                                    foreach ($event_appointment_data as $row) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i; ?></td>
                                                            <td class="text-center"><?php echo $row['title']; ?></td>
                                                            <td class="text-center"><?php echo get_formated_date($row['start_date'], ''); ?></td>
                                                            <td class="text-center"><?php echo get_formated_time(strtotime($row['start_time'])); ?></td>
                                                            <td class="text-center"><?php echo ($row['first_name']) . ' ' . $row['last_name']; ?></td>
                                                            <td class="text-center"><?php echo $row['payment_type'] == 'F' ? translate('free') : price_format($row['price']); ?></td>
                                                            <td class="text-center"><?php echo check_appointment_pstatus($row['payment_status']); ?></td>
                                                            <td class="text-center">
                                                                <a href="<?php echo base_url('admin/view-booking-details/' . $row['id']); ?>" class="btn btn-info"><span class="fa fa-info"></span></a>
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

    </div>
</div>
<!-- /Page Wrapper -->
<?php include VIEWPATH . 'admin/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/customer.js" type='text/javascript'></script>
