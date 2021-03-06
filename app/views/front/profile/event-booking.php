<?php
include VIEWPATH . 'front/header.php';
$customer_data = get_CustomerDetails();
$first_name = $customer_data['first_name'];
$last_name = $customer_data['last_name'];
$email = $customer_data['email'];

if (file_exists(FCPATH . uploads_path . "/profiles/" . $customer_data['profile_image']) && $customer_data['profile_image'] != '') {
    $img_src = base_url() . uploads_path . "/profiles/" . $customer_data['profile_image'];
} else {
    $img_src = base_url() . img_path . "/user.png";
}
?>
<style>
   
    .pr-12 {
        padding-right: 12px !important;
    }

    .mb-20 {
        margin-bottom: 20px !important;
    }

    .b-1 {
        border: 1px solid #ebebeb !important;
    }

    .card {
        border: 0;
        border-radius: 0;
        margin-bottom: 30px;
        -webkit-transition: .5s;
        transition: .5s;
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }

    .media {
        padding: 16px 12px;
        -webkit-transition: background-color .2s linear;
        transition: background-color .2s linear;
    }

    .media {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
    }

    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .media .avatar {
        flex-shrink: 0;
    }

    .no-radius {
        border-radius: 0 !important;
    }

    .avatar-xl {
        width: 64px;
        height: 64px;
        line-height: 64px;
        font-size: 1.25rem;
    }

    .avatar {
        position: relative;
        display: inline-block;
        width: 36px;
        height: 36px;
        line-height: 36px;
        text-align: center;
        border-radius: 100%;
        background-color: #f5f6f7;
        color: #8b95a5;
        text-transform: uppercase;
    }

    img {
        max-width: 100%;
    }

    img {
        vertical-align: middle;
        border-style: none;
    }

    .mb-2 {
        margin-bottom: .5rem!important;
    }

    .fs-20 {
        font-size: 18px !important;
    }
    .ls-1 {
        letter-spacing: 1px !important;
    }

    .fw-300 {
        font-weight: 300 !important;
    }

    .fs-16 {
        font-size: 14px !important;
    }

    .media-body>* {
        margin-bottom: 0;
    }

    small, time, .small {
        font-family: Roboto,sans-serif;
        font-weight: 400;
        font-size: 11px;
        color: #8b95a5;
    }

    .fs-14 {
        font-size: 14px !important;
    }

    .mb-12 {
        margin-bottom: 12px !important;
    }

    .text-fade {
        color: rgba(77,82,89,0.7) !important;
    }

    .card-footer:last-child {
        border-radius: 0 0 calc(.25rem - 1px) calc(.25rem - 1px);
    }

    .card-footer {
        background-color: #fcfdfe;
        border-top: 1px solid rgba(77,82,89,0.07);
        color: #8b95a5;
        padding: 10px 20px;
    }

    .flexbox {
        display: -webkit-box;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
    }

    .align-items-center {
        -ms-flex-align: center!important;
        align-items: center!important;
    }

    .card-footer {
        padding: .75rem 1.25rem;
        background-color: rgba(0,0,0,.03);
        border-top: 1px solid rgba(0,0,0,.125);
    }


    .card-footer {
        background-color: #fcfdfe;
        border-top: 1px solid rgba(77, 82, 89, 0.07);
        color: #8b95a5;
        padding: 10px 20px
    }


    .hover-shadow {
        -webkit-box-shadow: 0 0 35px rgba(0, 0, 0, 0.11);
        box-shadow: 0 0 35px rgba(0, 0, 0, 0.11)
    }

</style>
<!-- Custom Script -->
<script src="<?php echo $this->config->item('js_url'); ?>module/additional-methods.js" type="text/javascript"></script>
<link href="<?php echo $this->config->item('css_url'); ?>module/user_panel.css" rel="stylesheet"/>
<div class="container  mt-20"  style="min-height:653px;">
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card mb-3">

                <div class="card-body text-center">
                    <img src="<?php echo $img_src; ?>" alt="<?php echo $first_name . " " . $last_name; ?>" class="rounded-circle mb-2" width="100" height="100"/>
                    <h4 class="card-title mb-0"><?php echo $first_name . " " . $last_name; ?></h4>
                </div>

                <hr class="my-0">
                <div class="card-body">
                    <nav class="side-menu">
                        <ul class="nav">

                            <li><a href="<?php echo base_url('profile'); ?>"><span class="fa fa-user"></span> <?php echo translate('profile'); ?></a></li>
                            <li ><a href="<?php echo base_url('change-password'); ?>"><span class="fa fa-cog"></span> <?php echo translate('Change_password'); ?></a></li>
                            
                            <?php if (get_site_setting('enable_service') == 'Y'): ?>
                                <li><a href="<?php echo base_url('appointment'); ?>"><span class="fa fa-clock-o"></span> <?php echo translate('my_appointment'); ?></a></li>
                            <?php endif; ?>

                            <?php if (get_site_setting('enable_event') == 'Y'): ?>
                                <li class="active"><a href="<?php echo base_url('event-booking'); ?>"><span class="fa fa-ticket"></span> <?php echo translate('event') . " " . translate('booking'); ?></a></li>
                            <?php endif; ?>

                            <li><a href="<?php echo base_url('payment-history'); ?>"><span class="fa fa-credit-card"></span> <?php echo translate('payment_history'); ?></a></li>
                            <li><a href="<?php echo base_url('logout'); ?>"><span class="fa fa-power-off"></span> <?php echo translate('logout'); ?></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xl-9">
            <?php $this->load->view('message'); ?>
            <div class="card">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo translate('upcoming')." ".translate('event') . " " . translate('booking'); ?> (<?php echo isset($appointment_data)?count($appointment_data):0; ?>)</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo translate('past')." ".translate('event'). " " . translate('booking'); ?> (<?php echo isset($past_appointment)?count($past_appointment):0; ?>)</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?php if (isset($appointment_data) && count($appointment_data) > 0) :
                    foreach ($appointment_data as $key => $row):
                        $event_img_file = '';
                        $event_img_Arr = json_decode($row['image']);
                        if (isset($event_img_Arr) && !empty($event_img_Arr)) {
                            $event_img = isset($event_img_Arr[0]) ? $event_img_Arr[0] : '';
                            if ($event_img != '') {
                                $original_filename = (pathinfo($event_img, PATHINFO_FILENAME));
                                $original_extension = (pathinfo($event_img, PATHINFO_EXTENSION));
                                $event_img_file = $original_filename . "_thumb" . "." . $original_extension;
                            }
                        }

                        if (isset($event_img_file) && $event_img_file != "") {
                            if (file_exists(FCPATH . "assets/uploads/event/" . $event_img_file)) {
                                $img_src = base_url() . UPLOAD_PATH . "event/" . $event_img_file;
                            } else {
                                $img_src = base_url() . UPLOAD_PATH . "event/events.png";
                            }
                        } else {
                            $img_src = base_url() . UPLOAD_PATH . "event/events.png";
                        }

                        $vendor_id = $row['aid'];
                        $appointment_id = $row['id'];
                        $event_id = $row['event_id'];

                        $status = "";
                        if ($row['status'] == 'A') {
                            $status = "<span class='badge badge-success'>" . translate('approved') . "</span>";
                        } else if ($row['status'] == 'R') {
                            $status = "<span class='badge badge-danger'>" . translate('Rejected') . "</span>";
                        } else if ($row['status'] == 'A') {
                            $status = "<span class='badge badge-danger'>" . translate('canceled') . "</span>";
                        } else if ($row['status'] == 'P') {
                            $status = "<span class='badge badge-info'>" . translate('pending') . "</span>";
                        } else if ($row['status'] == 'C') {
                            $status = "<span class='badge badge-primary'>" . translate('completed') . "</span>";
                        }
                        ?>
                        <div class="card b-1 hover-shadow" style="margin: 10px 20px;">
                            <div class="media card-body">
                                <div class="media-left pr-12">
                                    <img class="avatar avatar-xl no-radius" src="<?php echo $img_src; ?>" alt="<?php echo $row['title']; ?>">
                                </div>
                                <div class="media-body">
                                    <div class="mb-2">
                                        <span class="fs-20 pr-16"><?php echo $row['title']; ?></span>
                                    </div>
                                    <small class="fs-16 fw-300 ls-1"><?php echo $row['category_title']; ?></small>
                                </div>
                                <div class="media-right text-right d-none d-md-block">
                                    <p class="fs-14 text-fade mb-12"><i class="fa fa-map-marker pr-1"></i> <?php echo $row['city_title'] . " / " . $row['loc_title']; ?></p>
                                    <span class="text-fade"><i class="fa fa-money pr-1"></i> <?php echo ($row['final_price'] == 0) ? translate('free') : price_format($row['final_price']); ?></span><br/>
                                    <span class="text-fade"><b><?php echo translate('total') . " " . translate('ticket') ?></b>:<?php echo $row['event_booked_seat']; ?></span>
                                </div>
                            </div>
                            <footer class="card-footer flexbox align-items-center">
                                <div>
                                    <?php echo $status; ?> |
                                    <strong><?php echo translate('event') . " " . translate('date') ?>:</strong>
                                    <span><?php echo get_formated_date($row['start_date'] . " " . $row['start_time']); ?></span>
                                </div>
                                <div class="card-hover-show">
                                    <a href="<?php echo base_url('get-event-slidepanel-details/' . (int) $row['id']); ?>"  data-direction="right" class="btn btn-xs fs-10 btn-bold btn-info bookslide" title="<?php echo translate('details'); ?>"><?php echo translate('details'); ?></i></a>
                                    <?php if ($row['status'] == "P" || $row['status'] == "R"): ?>
                                        <a id="" data-toggle="modal" onclick='DeleteRecord(this)' data-target="#delete-record" data-id="<?php echo (int) $row['id']; ?>" class="btn-danger btn btn-sm red-gradient" title="<?php echo translate('delete'); ?>"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?> 
                                </div>
                            </footer>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center p-2"><?php echo translate('no_record_found'); ?></p>
                <?php endif; ?>
                </div>
                
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <?php if (isset($past_appointment) && count($past_appointment) > 0) :
                    foreach ($past_appointment as $key => $row):
                        $event_img_file = '';
                        $event_img_Arr = json_decode($row['image']);
                        if (isset($event_img_Arr) && !empty($event_img_Arr)) {
                            $event_img = isset($event_img_Arr[0]) ? $event_img_Arr[0] : '';
                            if ($event_img != '') {
                                $original_filename = (pathinfo($event_img, PATHINFO_FILENAME));
                                $original_extension = (pathinfo($event_img, PATHINFO_EXTENSION));
                                $event_img_file = $original_filename . "_thumb" . "." . $original_extension;
                            }
                        }

                        if (isset($event_img_file) && $event_img_file != "") {
                            if (file_exists(FCPATH . "assets/uploads/event/" . $event_img_file)) {
                                $img_src = base_url() . UPLOAD_PATH . "event/" . $event_img_file;
                            } else {
                                $img_src = base_url() . UPLOAD_PATH . "event/events.png";
                            }
                        } else {
                            $img_src = base_url() . UPLOAD_PATH . "event/events.png";
                        }

                        $vendor_id = $row['aid'];
                        $appointment_id = $row['id'];
                        $event_id = $row['event_id'];

                        $status = "";
                        if ($row['status'] == 'A') {
                            $status = "<span class='badge badge-success'>" . translate('approved') . "</span>";
                        } else if ($row['status'] == 'R') {
                            $status = "<span class='badge badge-danger'>" . translate('Rejected') . "</span>";
                        } else if ($row['status'] == 'A') {
                            $status = "<span class='badge badge-danger'>" . translate('canceled') . "</span>";
                        } else if ($row['status'] == 'P') {
                            $status = "<span class='badge badge-info'>" . translate('pending') . "</span>";
                        } else if ($row['status'] == 'C') {
                            $status = "<span class='badge badge-primary'>" . translate('completed') . "</span>";
                        }
                        ?>
                        <div class="card b-1 hover-shadow" style="margin: 10px 20px;">
                            <div class="media card-body">
                                <div class="media-left pr-12">
                                    <img class="avatar avatar-xl no-radius" src="<?php echo $img_src; ?>" alt="<?php echo $row['title']; ?>">
                                </div>
                                <div class="media-body">
                                    <div class="mb-2">
                                        <span class="fs-20 pr-16"><?php echo $row['title']; ?></span>
                                    </div>
                                    <small class="fs-16 fw-300 ls-1"><?php echo $row['category_title']; ?></small>
                                </div>
                                <div class="media-right text-right d-none d-md-block">
                                    <p class="fs-14 text-fade mb-12"><i class="fa fa-map-marker pr-1"></i> <?php echo $row['city_title'] . " / " . $row['loc_title']; ?></p>
                                    <span class="text-fade"><i class="fa fa-money pr-1"></i> <?php echo ($row['final_price'] == 0) ? translate('free') : price_format($row['final_price']); ?></span><br/>
                                    <span class="text-fade"><b><?php echo translate('total') . " " . translate('ticket') ?></b>:<?php echo $row['event_booked_seat']; ?></span>
                                </div>
                            </div>
                            <footer class="card-footer flexbox align-items-center">
                                <div>
                                    <?php echo $status; ?> |
                                    <strong><?php echo translate('event') . " " . translate('date') ?>:</strong>
                                    <span><?php echo get_formated_date($row['start_date'] . " " . $row['start_time']); ?></span>
                                </div>
                                <div class="card-hover-show">
                                    <a href="<?php echo base_url('get-event-slidepanel-details/' . (int) $row['id']); ?>"  data-direction="right" class="btn btn-xs fs-10 btn-bold btn-info bookslide" title="<?php echo translate('details'); ?>"><?php echo translate('details'); ?></i></a>
                                </div>
                            </footer>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center p-2"><?php echo translate('no_record_found'); ?></p>
                <?php endif; ?>
                </div>
            </div>

                

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete-record">
    <div class="modal-dialog modal-dialog-centered">
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
                    <button data-dismiss="modal" class="btn btn-danger font_size_12" type="button"><?php echo translate('close'); ?></button>
                    <a class="btn btn-primary font_size_12" href="javascript:void(0)" id="RecordDelete" ><?php echo translate('confirm'); ?></a>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Modal -->
<div class="modal fade" id="view-record">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: 18px;"><?php echo translate('appointment_details'); ?></h4>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="get_view_data">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Custom Script -->
<?php include VIEWPATH . 'front/footer.php'; ?>
<script src="<?php echo $this->config->item('js_url'); ?>module/appointment.js" type='text/javascript'></script>
<script src="<?php echo $this->config->item('js_url'); ?>jquery.rating-stars.js" type="text/javascript"></script>
<script>
    $('.bookslide').slidePanel();
    $(document).on('slidePanel::beforeShow', function (e) {
        $('#loadingmessage').show();
    });
    $(document).on('slidePanel::afterShow', function (e) {
        $('#loadingmessage').hide();
    });
</script>