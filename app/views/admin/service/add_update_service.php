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
$imageArr=array();
if (isset($image_data) && $image_data != '') {
    $imageArr = json_decode($image_data);
}
$id = (set_value("id")) ? set_value("id") : (!empty($event_data) ? $event_data['id'] : 0);
?>

<input type="hidden" name="address_selection" id="address_selection" value="0">
<link href="<?php echo $this->config->item('css_url'); ?>timepicker.css" rel="stylesheet">
<div class="page-wrapper" style="min-height: 473px;">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-7 col-auto">
                    <h3 class="page-title"><?php echo translate('manage')." ".translate('service'); ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/dashboard'); ?>"><?php echo translate('dashboard'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url($folder_name.'/service'); ?>"><?php echo translate('service'); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo isset($id) && $id > 0 ? translate('update') : translate('add'); ?> <?php echo translate("service"); ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-5 col">
                    <a href="<?php echo base_url($folder_name.'/add-service'); ?>" class="btn btn-primary float-right mt-2"><?php echo translate('add'); ?> <?php echo translate('service'); ?></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 m-auto">
                <?php $this->load->view('message'); ?>
                <div class="card">
                    <div class="card-body resp_mx-0">
                        <?php
                        echo form_open_multipart($form_url, array('name' => 'ServiceForm', 'id' => 'ServiceForm'));
                        echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $id));
                        echo form_input(array('type' => 'hidden', 'name' => 'folder_name', 'id' => 'folder_name', 'value' => isset($folder_name) && $folder_name != '' ? $folder_name : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_latitude', 'id' => 'business_latitude', 'value' => isset($latitude) && $latitude != '' ? $latitude : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_longitude', 'id' => 'business_longitude', 'value' => isset($longitude) && $longitude != '' ? $longitude : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_starttime', 'id' => 'event_starttime', 'value' => isset($start_time) && $start_time != '' ? $start_time : ''));
                        echo form_input(array('type' => 'hidden', 'name' => 'event_stoptime', 'id' => 'event_stoptime', 'value' => isset($end_time) && $end_time != '' ? $end_time : ''));
                        ?>
                        <div class="list-group">
                            <!-- Basic Information -->
                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('basic'); ?> <?php echo translate('information'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="col-md-12">
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
                                                    <select tabindex="2" required class="form-control select2" name="category_id">
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
                                                    <select multiple="" style="width: 100%;" tabindex="2" class="form-control select2" id="staff" name="staff[]">
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
                                                    <select tabindex="4" class="form-control select2" id="city" name="city" onchange="get_location(this.value);">
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
                                                    <select tabindex="5" class="form-control select2" id="location" name="location">
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

                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('description'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description"> <?php echo translate('description'); ?><small class="required">*</small></label>
                                                <textarea type="text" tabindex="3" id="summornote_div_id" name="description" class="form-control" placeholder="<?php echo translate('description'); ?>"><?php echo $description; ?></textarea>
                                                <?php echo form_error('description'); ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('booking') . " " . translate('setting'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="black-text"><?php echo translate('select'); ?> <?php echo translate('days'); ?><small class="required">*</small></label>
                                                <select  style="width: 100%" tabindex="12" class="form-control select2" id="days" name="days[]" multiple>
                                                    <option value="" disabled=""><?php echo translate('select') . " " . translate('days'); ?></option>
                                                    <option value="Mon" <?php echo isset($days) && in_array("Mon", $days) ? 'selected' : ''; ?>><?php echo translate('monday'); ?></option>
                                                    <option value="Tue" <?php echo isset($days) && in_array("Tue", $days) ? 'selected' : ''; ?>><?php echo translate('tuesday'); ?></option>
                                                    <option value="Wed" <?php echo isset($days) && in_array("Wed", $days) ? 'selected' : ''; ?>><?php echo translate('wednesday'); ?></option>
                                                    <option value="Thu" <?php echo isset($days) && in_array("Thu", $days) ? 'selected' : ''; ?>><?php echo translate('thursday'); ?></option>
                                                    <option value="Fri" <?php echo isset($days) && in_array("Fri", $days) ? 'selected' : ''; ?>><?php echo translate('friday'); ?></option>
                                                    <option value="Sat" <?php echo isset($days) && in_array("Sat", $days) ? 'selected' : ''; ?>><?php echo translate('saturday'); ?></option>
                                                    <option value="Sun" <?php echo isset($days) && in_array("Sun", $days) ? 'selected' : ''; ?>><?php echo translate('sunday'); ?></option>
                                                </select>
                                                <?php echo form_error('days[]'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                <label for="slot_time"> <?php echo translate('slot_time'); ?> <small class="required">*</small> ( <?php echo translate('in_min'); ?> )</label>
                                                <input tabindex="16" autocomplete="off"  type="number" placeholder="<?php echo translate('slot_time'); ?>" id="slot_time" name="slot_time" value="<?php echo $slot_time; ?>" class="form-control" min="15">
                                                <?php echo form_error('slot_time'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                <label for="start_time"> <?php echo translate('start_time'); ?> (In 24hr format)<small class="required">*</small></label>
                                                <input readonly="" autocomplete="off"  tabindex="14" type="text" placeholder="<?php echo translate('start_time'); ?>" id="start_time" name="start_time" value="<?php echo $start_time; ?>" class="form-control">
                                                <?php echo form_error('start_time'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                <label for="end_time"> <?php echo translate('end_time'); ?> (In 24hr format)<small class="required">*</small></label>
                                                <input readonly=""  autocomplete="off" tabindex="15" type="text" placeholder="<?php echo translate('end_time'); ?>" id="end_time" name="end_time" value="<?php echo $end_time; ?>" class="form-control">
                                                <?php echo form_error('end_time'); ?>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label for="padding_time" class="d-block"> <?php echo translate('padding_time'); ?> ( <?php echo translate('in_min'); ?> )</label>
                                                <input tabindex="17" autocomplete="off"  type="text"  class="form-control integers" name="padding_time" value="<?php echo isset($padding_time) ? $padding_time : "0"; ?>">
                                                <?php echo form_error('padding_time'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="color: #757575;" > <?php echo translate('is_allow_multiple_slotbooking'); ?> <small class="required">*</small></label>
                                            <div class="form-group form-inline">
                                                <?php
                                                $active = $inactive = '';
                                                if ($multiple_slotbooking_allow == "Y") {
                                                    $active = "checked";
                                                } else {
                                                    $inactive = "checked";
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <input tabindex="18" name='multiple_slotbooking_allow' value="Y" type='radio' id='multiobook_active'   <?php echo $active; ?>>
                                                    <label for="multiobook_active"><?php echo translate('yes'); ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <input tabindex="19" name='multiple_slotbooking_allow' type='radio'  value='N' id='multiobook_inactive'  <?php echo $inactive; ?>>
                                                    <label for='multiobook_inactive'><?php echo translate('no'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="book_limit" class="col-md-6  <?php echo isset($multiple_slotbooking_allow) && $multiple_slotbooking_allow == 'N' ? 'd-none' : ''; ?>">
                                            <div class="form-group" >
                                                <label for="multiple_slotbooking_limit" class="d-block"> <?php echo translate('multiple_slotbooking_limit'); ?> <small class="required">*</small></label>
                                                <input tabindex="20" autocomplete="off"  type="text"  class="form-control integers" id="multiple_slotbooking_limit" name="multiple_slotbooking_limit" value="<?php echo isset($multiple_slotbooking_limit) ? $multiple_slotbooking_limit : ""; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('price'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label style="color: #757575;" > <?php echo translate('type'); ?> <small class="required">*</small></label>
                                            <div class="form-group form-inline">
                                                <?php
                                                $free = $paid = '';
                                                if ($payment_type == "P") {
                                                    $paid = "checked";
                                                } else {
                                                    $free = "checked";
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <input tabindex="21" name='payment_type' value="F" type='radio' id='free'   <?php echo $free; ?>>
                                                    <label for="free"><?php echo translate('free'); ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <input tabindex="22" name='payment_type' type='radio'  value='P' id='paid'  <?php echo $paid; ?>>
                                                    <label for='paid'><?php echo translate('paid'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;" id="price-box">
                                                <label for="price"> <?php echo translate('price'); ?> <small class="required">*</small></label>
                                                <input tabindex="23"  autocomplete="off" onblur="calc_final_price(this);" type="number" placeholder="<?php echo translate('price'); ?>" id="price" name="price" value="<?php echo $price; ?>" class="form-control" <?php echo isset($payment_type) && $payment_type == 'F' ? 'min="0"' : 'min="1"'; ?>>
                                                <?php echo form_error('price'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="price-box form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                <label  for="discount"> <?php echo translate('discount') . " " . translate('in') . " " . translate('percentage'); ?></label>
                                                <input tabindex="24"  autocomplete="off" onblur="calc_final_price(this);" type="number" placeholder="<?php echo translate('discount') . " " . translate('in') . " " . translate('percentage'); ?>" id="discount" name="discount" value="<?php echo $discount; ?>" class="form-control integers" <?php echo isset($payment_type) && $payment_type == 'F' ? 'min="0"' : 'min="1" max="100";'; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;" id="price-box">
                                                <label for="discounted_price"> <?php echo translate('price_after_discount'); ?></label>
                                                <input tabindex="25"  autocomplete="off" readonly="" type="number" placeholder="<?php echo translate('discount') . " " . translate('price'); ?>" id="discounted_price" name="discounted_price" value="<?php echo $discounted_price; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="price-box form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                <label for="from_date"> <?php echo translate('from_date') ?></label>
                                                <input tabindex="26"  autocomplete="off" type="text" placeholder="<?php echo translate('from_date') ?>" id="from_date" name="from_date" value="<?php echo $from_date; ?>" class="form-control bdatepicker">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="price-box form-group <?php echo isset($payment_type) && $payment_type == 'F' ? 'd-none' : ''; ?>" style="padding-top: <?php isset($id) && $id > 0 ? "10px" : ""; ?>;">
                                                <label for="to_date"> <?php echo translate('to_date') ?></label>
                                                <input tabindex="27"  autocomplete="off" type="text" placeholder="<?php echo translate('to_date'); ?>" id="to_date" name="to_date" value="<?php echo $to_date; ?>" class="form-control bdatepicker">
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>


                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('media'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-sm bg-primary-light float-right mb-2" onclick="get_more_image(this);"><i class="fa fa-plus-square-o mr-10"></i>  <?php echo translate('add')." ".translate('more'); ?></button>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="image"><?php echo translate('service') . " " . translate('image'); ?><small class="required">*</small></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  id="sortable">
                                        <?php if (isset($imageArr) && count($imageArr) > 0) { ?>
                                            <?php
                                            foreach ($imageArr as $value) {
                                                ?>
                                                <div class="col-sm-3 service_gallery_images">
                                                    <div class="card">
                                                        <img class="card-img-top" src="<?php echo check_admin_image(UPLOAD_PATH . "event/" . $value); ?>" height="150">
                                                        <div class="card-body">
                                                            <input type="hidden" name="service_images_hidden[]" value="<?php echo $value; ?>"/>
                                                            <input class="d-none" type="file" id="imag_none" >
                                                            <a  href="javascript:void(0)"  class="btn btn-danger btn-sm mt-2" onclick="delete_event_image(this);" data-url="<?php echo UPLOAD_PATH . "event/" . $value; ?>" data-id="<?php echo $id; ?>"><i class="fe fe-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        <?php } ?>
                                        <?php
                                        if(isset($imageArr) && count($imageArr)==0) { ?>
                                            <div class="col-sm-3 service_gallery_images">
                                                <div class="card">
                                                    <img class="card-img-top" src="<?php echo base_url('assets/images/no-image.png'); ?>" height="150">
                                                    <div class="card-body">
                                                        <input tabindex="28" onchange="readServiceImage(this)" accept="image/*" type="file" id="image" name="image[]" class="form-control" <?php echo (isset($imageArr) && count($imageArr)>0)? '' : 'required'; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('service') . " " . translate('faqs'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="pull-right btn btn-sm bg-info-light float-right" onclick="add_more_faq(this);"><i class="fa fa-plus-square-o mr-10"></i> <?php echo translate('add')." ".translate('more'); ?></button>
                                        </div>
                                    </div>

                                    <div id="faq_section_id">
                                        <?php if (count($faq) && !empty($faq)): ?>
                                            <?php foreach ($faq as $val): ?>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="faq_title"> <?php echo translate('title') ?></label>
                                                            <input type="text" autocomplete="off"  placeholder="<?php echo translate('title'); ?>" id="seo_keyword" name="faq_title[]" value="<?php echo trim($val->faq_title); ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="faq_description"> <?php echo translate('description'); ?></label>
                                                            <textarea type="text" name="faq_description[]" class="form-control" placeholder="<?php echo translate('description'); ?>"><?php echo trim($val->faq_description); ?></textarea>
                                                            <?php echo form_error('faq_description'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group"><br/>
                                                            <label for="remove">&nbsp;</label>
                                                            <button type="button" class="btn btn-sm bg-danger-light" onclick="remove_add_more(this);"><i class="fe fe-trash mr-10"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="faq_title"> <?php echo translate('title') ?></label>
                                                        <input type="text" autocomplete="off"  placeholder="<?php echo translate('title'); ?>" id="seo_keyword" name="faq_title[]" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="faq_description"> <?php echo translate('description'); ?></label>
                                                        <textarea type="text" name="faq_description[]" rows="1" class="form-control" placeholder="<?php echo translate('description'); ?>"></textarea>
                                                        <?php echo form_error('faq_description'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group"><br/>
                                                        <label for="remove">&nbsp;</label>
                                                        <button type="button" class="btn btn-sm bg-danger-light" onclick="remove_add_more(this);"><i class="fe fe-trash mr-10"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>


                            <div class="list-group-item py-3" data-acc-step>
                                <h5 class="mb-0" data-acc-title><?php echo translate('seo'); ?></h5>
                                <div data-acc-content>
                                    <hr/>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="seo_keyword"> <?php echo translate('seo_keyword') ?></label>
                                                <input tabindex="29" autocomplete="off"  type="text" placeholder="<?php echo translate('seo_keyword'); ?>" id="seo_keyword" name="seo_keyword" value="<?php echo $seo_keyword; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="seo_description"> <?php echo translate('seo_description'); ?></label>
                                                <textarea tabindex="30" type="text" name="seo_description" class="form-control" placeholder="<?php echo translate('seo_description'); ?>"><?php echo $seo_description; ?></textarea>
                                                <?php echo form_error('seo_description'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" id="image-data">
                                                <label for="image"> <?php echo translate('seo_og_image'); ?></label>
                                                <input tabindex="31" type="file" id="image" name="seo_og_image" class="form-control">
                                            </div>

                                            <?php if ($seo_og_image != '') { ?>
                                                <ul class="list-inline inline-ul" id="images_ul">
                                                    <li class="hover-btn">
                                                        <img src = "<?php echo check_admin_image(UPLOAD_PATH . "event/" . $seo_og_image); ?>" class = "img-thumbnail mr-10 mb-10 height-100" width = "100px"/>
                                                        <a class="btn-danger btn-floating btn-sm red-gradient waves-effect waves-light remove-btn" onclick="delete_event_seo_image(this);" data-url="<?php echo UPLOAD_PATH . "event/" . $seo_og_image; ?>" data-id="<?php echo $id; ?>"><i class="fe fe-trash"></i></a>
                                                    </li>
                                                </ul>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                    <!--/Form with header-->
                </div>
                <!--Card-->
            </div>
            <!-- End Col -->
        </div>

    </div>
</div>

<div class="modal fade" id="map_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id='some_name' class="modal-title" style="font-size: 18px;">Share a map or location</h4>
            </div>
            <div class="modal-body">
                <ol>
                    <li>On your computer, open <a href="https://www.google.com/maps" target="_blank" rel="noopener">Google Maps</a>.</li>
                    <li>On the top left, click Menu <img src="//lh5.ggpht.com/gnm-ty6mnE6vkedDflD8UzuuSYpoeaGMx1Am3m0zH0OkEAkqv3jGJV3cnjkqH75mrrqn=w18-h18" width="18" height="18" alt="Menu" title="Menu">.</li>
                    <li>Select <strong>Share or embed map</strong></li>
                    <li>Copy and paste the "<strong>Link to share</strong>"</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo translate('close'); ?></button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    function add_more_faq(e) {

        var html = '';
        html += '<div class="row">';
        html += '<div class="col-md-5">';
        html += '<div class="form-group">';
        html += '<label for="faq_title"> <?php echo translate('title') ?></label>';
        html += '<input type="text" placeholder="<?php echo translate('title'); ?>" id="seo_keyword" name="faq_title[]" value="" class="form-control">';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-5">';
        html += '<div class="form-group">';
        html += '<label for="faq_description"> <?php echo translate('description'); ?></label>';
        html += '<textarea type="text" name="faq_description[]" class="form-control" placeholder="<?php echo translate('description'); ?>"></textarea>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '<div class="form-group"><br/>';
        html += '<button type="button" class="btn btn-sm bg-danger-light" onclick="remove_add_more(this);"><i class="fe fe-trash mr-10"></i></button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        $("#faq_section_id").append(html);
    }

    function remove_add_more($this) {
        $($this).closest('.row').remove();
    }
</script>

<?php
if ($this->session->userdata('Type_' . ucfirst($this->uri->segment(1))) == 'V') {
    include VIEWPATH . 'vendor/footer.php';
} else {
    include VIEWPATH . 'admin/footer.php';
}
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="<?php echo $this->config->item('js_url'); ?>bootstrap-timepicker.js"></script>
<script src="<?php echo $this->config->item('js_url'); ?>jquery.accordion-wizard.min.js"></script>

<script src="<?php echo $this->config->item('js_url'); ?>module/service.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('js_url'); ?>additional-method.js" type="text/javascript"></script>
<script>
    $( function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    } );
</script>

<script>
    var options = {
        mode: 'wizard',
        autoButtonsNextClass: 'btn btn-primary pull-right',
        autoButtonsPrevClass: 'btn btn-info pull-left',
        stepNumberClass: 'badge badge-pill badge-primary mr-1',
        beforeNextStep: function(t) {
            var form = $("#ServiceForm").valid();
            if (form) {
                return true;
            }
        },
        onSubmit: function() {
            var form = $("#ServiceForm").valid();
            if (form) {
                $("#loadingmessage").show();
                return true;
            }
        }
    }

    $( function() {

        $("#ServiceForm").accWizard(options);

    });
</script>