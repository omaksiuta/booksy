<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/header.php';
    $form_url = 'vendor/save-service';
    $folder_name = 'vendor';
} else {
    include VIEWPATH . 'admin/header.php';
    $form_url = 'admin/save-service';
    $folder_name = 'admin';
}

$location_api_key = get_site_setting('google_location_search_key');
$name = (set_value("name")) ? set_value("name") : (!empty($event_data) ? $event_data['title'] : '');
$staff = (set_value("staff")) ? set_value("staff") : (!empty($event_data) ? explode(',', $event_data['staff']) : array());
$description = (set_value("description")) ? set_value("description") : (!empty($event_data) ? $event_data['description'] : '');
$days = (set_value("days")) ? set_value("days") : (!empty($event_data) ? explode(",", $event_data['days']) : array());
$start_time = (set_value("start_time")) ? set_value("start_time") : (!empty($event_data) ? $event_data['start_time'] : '');
$end_time = (set_value("end_time")) ? set_value("end_time") : (!empty($event_data) ? $event_data['end_time'] : '');
$slot_time = (set_value("slot_time")) ? set_value("slot_time") : (!empty($event_data) ? $event_data['slot_time'] : '');

$city = (set_value("city")) ? set_value("city") : (!empty($event_data) ? $event_data['city'] : '');
$location = (set_value("location")) ? set_value("location") : (!empty($event_data) ? $event_data['location'] : '');
$price = (set_value("price")) ? set_value("price") : (!empty($event_data) ? $event_data['price'] : '1');
$discount = (set_value("discount")) ? set_value("discount") : (!empty($event_data) && $event_data['discount'] > 0 ? $event_data['discount'] : '');
$discounted_price = (set_value("discounted_price")) ? set_value("discounted_price") : (!empty($event_data) ? $event_data['discounted_price'] : '');
$from_date = (set_value("from_date")) ? set_value("from_date") : (!empty($event_data) && $event_data['from_date'] != '' && $event_data['from_date'] != '0000-00-00' ? date("m/d/Y", strtotime($event_data['from_date'])) : '');
$to_date = (set_value("to_date")) ? set_value("to_date") : (!empty($event_data) && $event_data['to_date'] != '' && $event_data['to_date'] != '0000-00-00' ? date("m/d/Y", strtotime($event_data['to_date'])) : '');
$payment_type = (set_value("payment_type")) ? set_value("payment_type") : (!empty($event_data) ? $event_data['payment_type'] : 'F');
$category_id = (set_value("category_id")) ? set_value("category_id") : (!empty($event_data) ? $event_data['category_id'] : '');
$status = (set_value("status")) ? set_value("status") : (!empty($event_data) ? $event_data['status'] : '');
$address = (set_value("address")) ? set_value("address") : (!empty($event_data) ? $event_data['address'] : '');
$address_map_link = (set_value("address_map_link")) ? set_value("address_map_link") : (!empty($event_data) ? $event_data['address_map_link'] : '');
$longitude = (set_value("longitude")) ? set_value("longitude") : (!empty($event_data) ? $event_data['longitude'] : '');
$latitude = (set_value("latitude")) ? set_value("latitude") : (!empty($event_data) ? $event_data['latitude'] : '');
$image_data = (!empty($event_data) ? $event_data['image'] : '');
$seo_description = (set_value("seo_description")) ? set_value("seo_description") : (!empty($event_data) ? $event_data['seo_description'] : '');
$seo_keyword = (set_value("seo_keyword")) ? set_value("seo_keyword") : (!empty($event_data) ? $event_data['seo_keyword'] : '');
$seo_og_image = (set_value("seo_og_image")) ? set_value("seo_og_image") : (!empty($event_data) ? $event_data['seo_og_image'] : '');

$padding_time = (set_value("padding_time")) ? set_value("padding_time") : (!empty($event_data) ? $event_data['padding_time'] : '0');
$multiple_slotbooking_allow = (set_value("multiple_slotbooking_allow")) ? set_value("multiple_slotbooking_allow") : (!empty($event_data) ? $event_data['multiple_slotbooking_allow'] : 'N');
$multiple_slotbooking_limit = (set_value("multiple_slotbooking_limit")) ? set_value("multiple_slotbooking_limit") : (!empty($event_data) ? $event_data['multiple_slotbooking_limit'] : '');

$faq = (isset($event_data['faq']) && !empty($event_data['faq'])) ? json_decode($event_data['faq']) : array();
if (isset($image_data) && $image_data != '') {
    $imageArr = json_decode($image_data);
}
$id = (set_value("id")) ? set_value("id") : (!empty($event_data) ? $event_data['id'] : 0);
?>
<style>
    body { background-color: #fafafa; }
    .container { margin: 150px auto; }
    div[data-acc-content] { display: none;  }
    div[data-acc-step]:not(.open) { background: #f2f2f2;  }
    div[data-acc-step]:not(.open) h5 { color: #777;  }
    div[data-acc-step]:not(.open) .badge-primary { background: #ccc;  }
</style>
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('holiday'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/holiday'); ?>"><?php echo translate('holiday'); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-holiday'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('holiday'); ?></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body resp_mx-0">
                        <?php
                        echo form_open_multipart($form_url, array('name' => 'ServiceForm', 'id' => 'ServiceForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                        echo form_input(array('type' => 'hidden', 'name' => 'hidden_image', 'id' => 'hidden_image', 'value' => isset($image_data) && $image_data != '' ? $image_data : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'folder_name', 'id' => 'folder_name', 'value' => isset($folder_name) && $folder_name != '' ? $folder_name : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_latitude', 'id' => 'business_latitude', 'value' => isset($latitude) && $latitude != '' ? $latitude : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_longitude', 'id' => 'business_longitude', 'value' => isset($longitude) && $longitude != '' ? $longitude : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_starttime', 'id' => 'event_starttime', 'value' => isset($start_time) && $start_time != '' ? $start_time : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_stoptime', 'id' => 'event_stoptime', 'value' => isset($end_time) && $end_time != '' ? $end_time : ''));
                        ?>
                        <input type="hidden" name="event_latitude" id="business_latitude">
                        <input type="hidden" name="event_longitude" id="business_longitude">

                        <div class="list-group">

                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('service'); ?> <?php echo translate('information'); ?></h5>
                                <div data-acc-content>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name"> <?php echo translate('title'); ?><small class="required">*</small></label>
                                                <input type="text" required autocomplete="off" tabindex="1" id="name" name="name" value="<?php echo $name; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">
                                                <?php echo form_error('name'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select') . " " . translate("service") . " " . translate('category'); ?><small class="required">*</small></label>
                                                <select tabindex="2" required class="form-control" id="days" name="category_id">
                                                    <option value=""><?php echo translate('select') . " " . translate("service") . " " . translate('category'); ?></option>
                                                    <?php
                                                    if (isset($category_data) && count($category_data)) {
                                                        foreach ($category_data as $category_key => $category_value) {
                                                            ?>
                                                            <option value="<?php echo $category_value['id']; ?>" <?php echo isset($category_id) && $category_id == $category_value['id'] ? 'selected' : ''; ?>><?php echo $category_value['title']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php echo form_error('category_id'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select') . " " . translate("staff"); ?></label>
                                                <select multiple="" required tabindex="2" class="form-control" id="staff" name="staff[]">
                                                    <option value=""><?php echo translate('select') . " " . translate("staff"); ?></option>
                                                    <?php
                                                    if (isset($staff_data) && count($staff_data)) {
                                                        foreach ($staff_data as $vals) {
                                                            ?>
                                                            <option value="<?php echo $vals['id']; ?>" <?php echo isset($staff) && in_array($vals['id'], $staff) ? 'selected' : ''; ?>><?php echo $vals['first_name'] . " " . $vals['last_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php echo form_error('category_id'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select_city'); ?><small class="required">*</small></label>
                                                <select tabindex="4" required class="form-control" id="city" name="city" onchange="get_location(this.value);">
                                                    <option value=""><?php echo translate('select_city'); ?></option>
                                                    <?php
                                                    if (isset($city_data) && count($city_data) > 0) {
                                                        foreach ($city_data as $value) {
                                                            ?>
                                                            <option value="<?php echo $value['city_id']; ?>" <?php echo isset($city) && $city == $value['city_id'] ? 'selected' : ''; ?>><?php echo $value['city_title']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php echo form_error('city'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select_location'); ?><small class="required">*</small></label>
                                                <select tabindex="5" required class="form-control" id="location" name="location">
                                                    <?php if (isset($location_data) && count($location_data) > 0) { ?>
                                                        <option value=""><?php echo translate('select_location'); ?></option>
                                                        <?php foreach ($location_data as $value) {
                                                            ?>
                                                            <option value="<?php echo $value['loc_id']; ?>" <?php echo isset($location) && $location == $value['loc_id'] ? 'selected' : ''; ?>><?php echo $value['loc_title']; ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value=""><?php echo translate('select_city_first'); ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <?php echo form_error('location'); ?>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address"><?php echo translate('address'); ?><small class="required">*</small></label>
                                                <input tabindex="8" required autocomplete="off"  type="text" required="" name="address" class="form-control" placeholder="<?php echo translate('address'); ?>" value="<?php echo $address; ?>"/>
                                                <?php echo form_error('address'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address"><?php echo translate('get_direction') . " " . translate('map') . " " . translate('link'); ?></label>
                                                <input tabindex="8" required autocomplete="off" type="text" id="address_map_link" name="address_map_link" class="form-control" placeholder="<?php echo translate('map') . " " . translate('link'); ?>" value="<?php echo $address_map_link; ?>"/>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#map_modal" >Click Here For Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="color: #757575;" ><?php echo translate('status'); ?> <small class="required">*</small></label>
                                            <div class="form-group form-inline">
                                                <?php
                                                $active = $inactive = '';
                                                if ($status == "I") {
                                                    $inactive = "checked";
                                                } else {
                                                    $active = "checked";
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <input tabindex="9"  autocomplete="off" name='status' value="A" type='radio' id='e_active'   <?php echo $active; ?>>
                                                    <label for="e_active"><?php echo translate('active'); ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <input tabindex="10"  autocomplete="off" name='status' type='radio'  value='I' id='e_inactive'  <?php echo $inactive; ?>>
                                                    <label for='e_inactive'><?php echo translate('inactive'); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('service'); ?> <?php echo translate('information'); ?></h5>
                                <div data-acc-content>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name"> <?php echo translate('title'); ?><small class="required">*</small></label>
                                                <input type="text" autocomplete="off" tabindex="1" id="name" name="name" value="<?php echo $name; ?>" class="form-control" placeholder="<?php echo translate('title'); ?>">
                                                <?php echo form_error('name'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select') . " " . translate("service") . " " . translate('category'); ?><small class="required">*</small></label>
                                                <select tabindex="2" class="form-control" id="days" name="category_id">
                                                    <option value=""><?php echo translate('select') . " " . translate("service") . " " . translate('category'); ?></option>
                                                    <?php
                                                    if (isset($category_data) && count($category_data)) {
                                                        foreach ($category_data as $category_key => $category_value) {
                                                            ?>
                                                            <option value="<?php echo $category_value['id']; ?>" <?php echo isset($category_id) && $category_id == $category_value['id'] ? 'selected' : ''; ?>><?php echo $category_value['title']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php echo form_error('category_id'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select') . " " . translate("staff"); ?></label>
                                                <select multiple="" tabindex="2" class="form-control" id="staff" name="staff[]">
                                                    <option value="" disabled=""><?php echo translate('select') . " " . translate("staff"); ?></option>
                                                    <?php
                                                    if (isset($staff_data) && count($staff_data)) {
                                                        foreach ($staff_data as $vals) {
                                                            ?>
                                                            <option value="<?php echo $vals['id']; ?>" <?php echo isset($staff) && in_array($vals['id'], $staff) ? 'selected' : ''; ?>><?php echo $vals['first_name'] . " " . $vals['last_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php echo form_error('category_id'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select_city'); ?><small class="required">*</small></label>
                                                <select tabindex="4" class="form-control" id="city" name="city" onchange="get_location(this.value);">
                                                    <option value=""><?php echo translate('select_city'); ?></option>
                                                    <?php
                                                    if (isset($city_data) && count($city_data) > 0) {
                                                        foreach ($city_data as $value) {
                                                            ?>
                                                            <option value="<?php echo $value['city_id']; ?>" <?php echo isset($city) && $city == $value['city_id'] ? 'selected' : ''; ?>><?php echo $value['city_title']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php echo form_error('city'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select_location'); ?><small class="required">*</small></label>
                                                <select tabindex="5" class="form-control" id="location" name="location">
                                                    <?php if (isset($location_data) && count($location_data) > 0) { ?>
                                                        <option value=""><?php echo translate('select_location'); ?></option>
                                                        <?php foreach ($location_data as $value) {
                                                            ?>
                                                            <option value="<?php echo $value['loc_id']; ?>" <?php echo isset($location) && $location == $value['loc_id'] ? 'selected' : ''; ?>><?php echo $value['loc_title']; ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value=""><?php echo translate('select_city_first'); ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <?php echo form_error('location'); ?>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address"> <?php echo translate('address'); ?><small class="required">*</small></label>
                                                <input tabindex="8" autocomplete="off"  type="text" required="" name="address" class="form-control" placeholder="<?php echo translate('address'); ?>" value="<?php echo $address; ?>"/>
                                                <?php echo form_error('address'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address"> <?php echo translate('get_direction') . " " . translate('map') . " " . translate('link'); ?></label>
                                                <input tabindex="8"  autocomplete="off" type="text" id="address_map_link" name="address_map_link" class="form-control" placeholder="<?php echo translate('map') . " " . translate('link'); ?>" value="<?php echo $address_map_link; ?>"/>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#map_modal" >Click Here For Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="color: #757575;" > <?php echo translate('status'); ?> <small class="required">*</small></label>
                                            <div class="form-group form-inline">
                                                <?php
                                                $active = $inactive = '';
                                                if ($status == "I") {
                                                    $inactive = "checked";
                                                } else {
                                                    $active = "checked";
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <input tabindex="9"  autocomplete="off" name='status' value="A" type='radio' id='e_active'   <?php echo $active; ?>>
                                                    <label for="e_active"><?php echo translate('active'); ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <input tabindex="10"  autocomplete="off" name='status' type='radio'  value='I' id='e_inactive'  <?php echo $inactive; ?>>
                                                    <label for='e_inactive'><?php echo translate('inactive'); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php echo form_close(); ?>
                    </div>
                    <!--/Form with header-->
                </div>
            </div>
        </div>

    </div>
</div>


<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
<script>
    var options = {
        mode: 'wizard',
        autoButtonsNextClass: 'btn btn-primary float-right',
        autoButtonsPrevClass: 'btn btn-light',
        stepNumberClass: 'badge badge-pill badge-primary mr-1',
        beforeNextStep:function(){
            if($("#ServiceForm").valid()){
                return true;
            }
        },
        onSubmit: function() {
            if($("#ServiceForm").valid()){
                alert("s")
            }
        }
    }

    $( function() {
        $( "#ServiceForm" ).accWizard(options);
    });
</script>
</body>
</html>
