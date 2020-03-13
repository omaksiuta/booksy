<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_event');
        $this->load->model('model_appointment');
        set_time_zone();

        if (get_site_setting('enable_service') == 'N'):
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/dashboard', 'redirect');
        endif;
    }

    public function wizard(){
        $this->load->view('admin/service/wizard');
    }

    //show service page
    public function index() {
        $join = array(
            array(
                'table' => 'app_service_category',
                'condition' => 'app_service_category.id=app_services.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_admin',
                'condition' => 'app_admin.id=app_services.created_by',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_services.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_services.location',
                'jointype' => 'left'
            ),
        );


        $vendor = (int) $this->input->get('vendor');

        if ($this->login_type == 'A') {
            if (isset($vendor) && $vendor != "" && $vendor > 0) {
                $service_condition = "app_services.type ='S' AND app_services.created_by=" . $vendor;
            } else {
                $service_condition = "app_services.type ='S'=" . $this->login_id;
            }
        } else {
            $service_condition = "app_services.type ='S' AND app_services.created_by=" . $this->login_id;
        }


        $event = $this->model_event->getData('', 'app_services.*,app_service_category.title as category_title,app_admin.company_name, app_admin.first_name, app_admin.last_name,app_city.city_title,app_location.loc_title', $service_condition, $join);

        $vendor_list = $this->model_event->getData('app_admin', 'id,first_name,last_name,company_name', "status='A' AND type='V' AND profile_status='V'", "", "company_name ASC");
        $data['event_data'] = $event;
        $data['vendor_list'] = $vendor_list;
        $data['title'] = translate('manage') . " " . translate('service');
        $this->load->view('admin/service/manage_service', $data);
    }

    //show add service form
    public function add_service() {
        if (isset($this->login_type) && $this->login_type == 'A') {
            check_mandatory();
        }
        $staff_data = get_staff_by_vendor_id($this->login_id);
        $data['staff_data'] = $staff_data;
        $where = "status='A' AND type ='S'";
        $data['category_data'] = $this->model_event->getData('app_service_category', '*', $where);
        $data['city_data'] = $this->model_event->getData('app_city', '*', "city_status='A'");
        $data['title'] = translate('add') . " " . translate('service');
        $this->load->view('admin/service/add_update_service', $data);
    }

    //show edit service form
    public function update_service($id) {

        $service = $this->model_event->getData("app_services", "*", "id='$id'");
        if (isset($service[0]) && !empty($service[0])) {
            $data['event_data'] = $service[0];
            $where = " status='A' AND type ='S'";
            $data['category_data'] = $this->model_event->getData('app_service_category', '*', $where);
            $data['city_data'] = $this->model_event->getData('app_city', '*', "city_status='A'");
            $loc_city_id = $service[0]['city'];
            $data['location_data'] = $this->model_event->getData('app_location', '*', "loc_city_id='$loc_city_id' AND loc_status='A'");
            $data['app_service_addons'] = $this->model_event->getData("app_service_addons", "*", 'event_id=' . $id);

            if ($this->login_type == 'A' && $service[0]['created_by'] != $this->login_id) {
                $staff_data = get_staff_by_vendor_id($service[0]['created_by']);
            } else {
                $staff_data = get_staff_by_vendor_id($this->login_id);
            }
            $data['staff_data'] = $staff_data;

            $data['title'] = translate('update') . " " . translate('service');
            $this->load->view('admin/service/add_update_service', $data);
        } else {
            show_404();
        }
    }

    //update service booking 
    public function service_booking_update() {
        $book_id = (int) $this->input->post('book_id', true);
        $customer_id = (int) $this->input->post('customer_id', true);
        $event_id = (int) $this->input->post('event_id', true);
        $staff_member_id = (int) $this->input->post('staff_member_id', true);
        $user_datetime = $this->input->post('user_datetime', true);

        $user_datetime = explode(" ", $user_datetime);
        $data['start_date'] = $user_datetime[0];
        $data['start_time'] = $user_datetime[1];
        $data['staff_id'] = $staff_member_id;

        //check booking
        $app_service_appointment = $this->model_event->getData("app_service_appointment", '*', "event_id=" . $event_id . " AND customer_id=" . $customer_id . " AND id=" . $book_id);
        if (count($app_service_appointment) == 0) {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            if (isset($this->login_type) && $this->login_type == 'V') {
                redirect(base_url('vendor/manage-appointment'));
            } else {
                redirect(base_url('admin/manage-appointment'));
            }
        }
        $id = $this->model_event->update('app_service_appointment', $data, "event_id=" . $event_id . " AND customer_id=" . $customer_id . " AND id=" . $book_id);
        $get_service_event_by_id = get_service_event_by_id($event_id);
        if ($id) {
            $this->session->set_flashdata('msg_class', 'success');
            $this->session->set_flashdata('msg', translate('update_booking_time'));

            //send success email to user
            $customer_data = $this->db->query("SELECT * FROM app_customer WHERE id=" . $customer_id)->row_array();

            if (isset($customer_data['email']) && $customer_data['email'] != ""):
                //set email template data
                $parameter['service_data'] = $get_service_event_by_id;
                $parameter['SERVICE_TIME'] = get_formated_date($user_datetime[0] . " " . $user_datetime[1]);
                $parameter['name'] = $customer_data['first_name'] . " " . $customer_data['last_name'];

                if ($staff_member_id > 0):
                    $parameter['staff_data'] = get_staff_row_by_id($staff_member_id);
                endif;

                $html = $this->load->view('email_template/booking_time_change', $parameter, true);

                $subject = get_CompanyName() . " | " . translate('appointment') . " " . translate('notification');
                $define_param['to_name'] = $customer_data['first_name'] . " " . $customer_data['last_name'];
                $define_param['to_email'] = $customer_data['email'];
                $send = $this->sendmail->send($define_param, $subject, $html);
            endif;

            $this->session->set_flashdata('msg', translate('update_booking_time'));
            $this->session->set_flashdata('msg_class', 'success');

            if (isset($this->login_type) && $this->login_type == 'V') {
                redirect(base_url('vendor/manage-appointment'));
            } else {
                redirect(base_url('admin/manage-appointment'));
            }
        } else {
            if (isset($this->login_type) && $this->login_type == 'V') {
                redirect(base_url('vendor/manage-appointment'));
            } else {
                redirect(base_url('admin/manage-appointment'));
            }
        }
    }

    //add/edit an service
    public function save_service() {
        $service_id = (int) $this->input->post('id', true);

        $this->form_validation->set_rules('name', '', 'trim|required');
        $this->form_validation->set_rules('description', '', 'trim|required');
        $this->form_validation->set_rules('days[]', '', 'required');
        $this->form_validation->set_rules('start_time', '', 'required');
        $this->form_validation->set_rules('end_time', '', 'required');
        $this->form_validation->set_rules('city', '', 'required');
        $this->form_validation->set_rules('location', '', 'required');
        $this->form_validation->set_rules('status', '', 'required');
        $this->form_validation->set_rules('payment_type', '', 'required');
        $this->form_validation->set_rules('category_id', '', 'required');
        $this->form_validation->set_rules('padding_time', 'Padding time', 'integer');
        $this->form_validation->set_rules('multiple_slotbooking_limit', 'Multiple slot booking limit', 'integer');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($service_id > 0) {
                $this->update_service($service_id);
            } else {
                $this->add_service();
            }
        } else {

            $staff_value = $this->input->post('staff[]', true);

            if (isset($staff_value) && count($staff_value) > 0):
                $staff_data = implode(',', $staff_value);
            else:
                $staff_data = '';
            endif;

            $service_images_hidden=$this->input->post('service_images_hidden');
            $data['title'] = trim($this->input->post('name', true));
            $data['slug'] = convert_lang_string(trim($this->input->post('name', true)));
            $data['description'] = trim($this->input->post('description', true));
            $data['days'] = implode(",", $this->input->post('days[]', true));
            $data['start_time'] = $this->input->post('start_time', true);
            $data['end_time'] = $this->input->post('end_time', true);
            $data['slot_time'] = $this->input->post('slot_time', true);

            $data['city'] = $this->input->post('city', true);
            $data['staff'] = $staff_data;
            $data['location'] = $this->input->post('location', true);
            $data['payment_type'] = $this->input->post('payment_type', true);
            $data['price'] = $this->input->post('price', true);
            $data['category_id'] = $this->input->post('category_id', true);
            $data['status'] = $this->input->post('status', true);
            $data['discount'] = $this->input->post('discount', true);
            $data['from_date'] = $this->input->post('from_date', true) != '' ? date("Y-m-d", strtotime($this->input->post('from_date', true))) : '';
            $data['to_date'] = $this->input->post('to_date', true) != '' ? date("Y-m-d", strtotime($this->input->post('to_date', true))) : '';
            $data['discounted_price'] = $this->input->post('discounted_price', true);
            $data['seo_description'] = $this->input->post('seo_description', true);
            $data['seo_keyword'] = $this->input->post('seo_keyword', true);
            $data['address'] = $this->input->post('address', true);
            $data['address_map_link'] = $this->input->post('address_map_link', true);
            $data['latitude'] = $this->input->post('event_latitude', true);
            $data['longitude'] = $this->input->post('event_longitude', true);
            $data['padding_time'] = $this->input->post('padding_time', true);
            $data['multiple_slotbooking_allow'] = $this->input->post('multiple_slotbooking_allow', true);
            $data['multiple_slotbooking_limit'] = $this->input->post('multiple_slotbooking_limit', true);
            $data['type'] = "S";

            $faq_title = $this->input->post('faq_title', true);
            $faq_description = $this->input->post('faq_description', true);

            $faq_data_array = array();
            for ($i = 0; $i < count($faq_title); $i++) {
                if ($faq_title[$i] != '' || $faq_description[$i] != '') {
                    $array_val['faq_title'] = $faq_title[$i];
                    $array_val['faq_description'] = $faq_description[$i];
                    array_push($faq_data_array, $array_val);
                }
            }

            $data['faq'] = json_encode($faq_data_array);

            $is_Files = $this->check_upload_images($_FILES['image']['name']);

            if (isset($_FILES['image']) && $is_Files) {
                $filesCount = count($_FILES['image']['name']);

                $thumb_config['image_library'] = 'gd2';
                $thumb_config['maintain_ratio'] = TRUE;
                $thumb_config['width'] = 350;
                $thumb_config['height'] = 230;
                $thumb_config['create_thumb'] = TRUE;
                $thumb_config['thumb_marker'] = '_thumb';

                for ($i = 0; $i < $filesCount; $i++) {

                    $_FILES['userFile']['name'] = $fname = $_FILES['image']['name'][$i];
                    if ($fname != '') {
                        $_FILES['userFile']['type'] = $_FILES['image']['type'][$i];
                        $_FILES['userFile']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
                        $_FILES['userFile']['error'] = $_FILES['image']['error'][$i];
                        $_FILES['userFile']['size'] = $_FILES['image']['size'][$i];

                        $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/event';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $temp = explode(".", $_FILES["userFile"]["name"]);
                        $name = uniqid();
                        $new_name = $name . '.' . end($temp);

                        $config['file_name'] = $new_name;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('userFile')) {
                            $fileData = $this->upload->data();
                            $image[] = $fileData['file_name'];

                            $source_path = $uploadPath . '/' . $new_name;
                            $dest = $uploadPath . '/' . $new_name;

                            $thumb_config['source_image'] = $source_path;
                            $thumb_config['new_image'] = $dest;
                            $this->load->library('image_lib');
                            $this->image_lib->initialize($thumb_config);
                            if (!$this->image_lib->resize()) {
                                echo $this->image_lib->display_errors();
                            }
                            // clear //
                            $this->image_lib->clear();
                        }
                    }
                }


                if(isset($service_images_hidden) && count($service_images_hidden)>0){
                    $new_image_array=array_merge($service_images_hidden, $image);
                }else{
                    $new_image_array=$image;
                }

                $data['image'] = json_encode($new_image_array);
            } else {
                if (isset($service_images_hidden) && count($service_images_hidden>0)) {
                    $data['image'] = json_encode($service_images_hidden);
                }
            }
            if (isset($_FILES['seo_og_image']) && $_FILES['seo_og_image']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/event';
                $banner_tmp_name = $_FILES["seo_og_image"]["tmp_name"];
                $banner_temp = explode(".", $_FILES["seo_og_image"]["name"]);
                $nanner_name = uniqid();
                $new_banner_name = $nanner_name . '.' . end($banner_temp);
                $data['seo_og_image'] = $new_banner_name;
                move_uploaded_file($banner_tmp_name, "$uploadPath/$new_banner_name");
            }
            if ($service_id > 0) {
                $id = $this->model_event->update('app_services', $data, "id=$service_id");

                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_by'] = $this->login_id;
                $data['created_on'] = date('Y-m-d H:i:s');
                $id = $this->model_event->insert('app_services', $data);

                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/manage-service', 'redirect');
        }
    }

    //delete an service
    public function delete_service($id) {
        $appointment = $this->model_event->getData('app_service_appointment', 'id', "event_id='$id'");
        if (isset($appointment) && count($appointment) > 0) {
            $this->session->set_flashdata('msg', translate('event_book_appointment'));
            $this->session->set_flashdata('msg_class', 'failure');
            echo 'false';
            exit;
        }
        $this->model_event->delete('app_services', 'id=' . $id);
        $this->session->set_flashdata('msg', translate('record_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    //get location
    public function get_location($city_id) {
        $location_data = $this->model_event->getData('app_location', '*', "loc_city_id='$city_id' AND loc_status='A'");
        $html = '<option value="">' . translate('select_location') . '</option>';
        if (isset($location_data) && count($location_data) > 0) {
            foreach ($location_data as $value) {
                $html .= '<option value="' . $value['loc_id'] . '">' . $value['loc_title'] . '</option>';
            }
        }
        echo $html;
    }

    //delete event image
    public function delete_event_image() {
        $image = $this->input->post('i', TRUE);
        $event_id = $this->input->post('id', TRUE);
        $hidden_image = json_decode($this->input->post('h', TRUE));

        if (file_exists(dirname(FCPATH) . "/" . $image)) {
            if (unlink(dirname(FCPATH) . "/" . $image)) {
                $key = array_search(basename($image), $hidden_image);
                unset($hidden_image[$key]);
                $new_array = array_values($hidden_image);
                $data['image'] = json_encode($new_array);
                $id = $this->model_event->update('app_services', $data, "id=$event_id");
                if ($id) {
                    echo json_encode($new_array);
                } else {
                    echo 'false';
                }
            } else {
                echo 'false';
            }
        } else {
            $key = array_search(basename($image), $hidden_image);
            unset($hidden_image[$key]);
            $new_array = array_values($hidden_image);
            $data['image'] = json_encode($new_array);
            $id = $this->model_event->update('app_services', $data, "id=$event_id");
            if ($id) {
                echo json_encode($new_array);
            } else {
                echo 'false';
            }
        }
        exit;
    }

    //show service category page
    public function service_category() {
        if (isset($this->login_type) && $this->login_type == 'V') {
            $app_vendor_setting_data = app_vendor_setting();
            if (isset($app_vendor_setting_data['allow_service_category']) && $app_vendor_setting_data['allow_service_category'] == 'N'):
                redirect('vendor/dashboard');
            endif;
        }
        $where = "type ='S'";
        $event = $this->model_event->getData('app_service_category', '*', $where);
        $data['category_data'] = $event;
        $data['title'] = translate('manage_service_category');
        $this->load->view('admin/service/manage_service_category', $data);
    }

    //show add service category form
    public function add_category() {
        if (isset($this->login_type) && $this->login_type == 'V') {
            $app_vendor_setting_data = app_vendor_setting();
            if (isset($app_vendor_setting_data['allow_service_category']) && $app_vendor_setting_data['allow_service_category'] == 'N'):
                redirect('vendor/dashboard');
            endif;
        }
        $data['title'] = translate('add_service_category');
        $this->load->view('admin/service/add_update_service_category', $data);
    }

    //show edit service category form
    public function update_category($id) {
        if (isset($this->login_type) && $this->login_type == 'V') {
            $app_vendor_setting_data = app_vendor_setting();
            if (isset($app_vendor_setting_data['allow_service_category']) && $app_vendor_setting_data['allow_service_category'] == 'N'):
                redirect('vendor/dashboard');
            endif;
        }
        $cond = 'id=' . $id;
        if ($this->session->userdata('Type_Admin') != "A") {
            $cond .= ' AND created_by=' . $this->login_id;
        }
        $category = $this->model_event->getData("app_service_category", "*", $cond);
        if (isset($category) && count($category) > 0) {
            $data['category_data'] = $category[0];
            $data['title'] = translate('update') . " " . translate('service');
            $this->load->view('admin/service/add_update_service_category', $data);
        } else {
            show_404();
        }
    }

    public function validate_image() {
        $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/png");
        if (isset($_FILES["category_image"]["type"]) && $_FILES["category_image"]["type"] != "") {
            if (in_array($_FILES["category_image"]["type"], $allowedExts)) {
                return true;
            } else {
                $this->form_validation->set_message('validate_image', 'Please select valid image.');
                return false;
            }
        } else {
            $this->form_validation->set_message('validate_image', 'The Category Image field is required.');
            return false;
        }
    }

    public function validate_image_edit() {
        $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/png");
        if (empty($_FILES["category_image"]["type"])) {
            return true;
        } else {
            if (in_array($_FILES["category_image"]["type"], $allowedExts)) {
                return true;
            } else {
                $this->form_validation->set_message('validate_image_edit', 'Please select valid image.');
                return false;
            }
        }
    }

    //add/edit an service category
    public function save_category() {
        if (isset($this->login_type) && $this->login_type == 'V') {
            $app_vendor_setting_data = app_vendor_setting();
            if (isset($app_vendor_setting_data['allow_service_category']) && $app_vendor_setting_data['allow_service_category'] == 'N'):
                redirect('vendor/dashboard');
            endif;
        }
        $hidden_main_image = $this->input->post('hidden_category_image', true);
        $id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', 'title', 'required|callback_check_service_category_title');
        if ($id > 0) {
            $this->form_validation->set_rules('category_image', translate('category_image'), 'trim|callback_validate_image_edit');
        } else {
            $this->form_validation->set_rules('category_image', translate('category_image'), 'trim|callback_validate_image');
        }
        $this->form_validation->set_rules('status', 'Status', 'required');


        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($id > 0) {
                $this->update_category($id);
            } else {
                $this->add_category();
            }
        } else {
            $data['title'] = $this->input->post('title', true);
            $data['category_slug'] = convert_lang_string(trim($this->input->post('title', true)));
            $data['status'] = $this->input->post('status', true);
            $data['type'] = "S";
            $data['created_by'] = $this->login_id;

            $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/category';

            if (isset($_FILES['category_image']["name"]) && $_FILES['category_image']["name"] != "") {
                $tmp_name = $_FILES["category_image"]["tmp_name"];
                $temp = explode(".", $_FILES["category_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $data['category_image'] = $newfilename;

                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploadPath . "/" . $newfilename;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 40;
                $config['height'] = 40;

                $this->load->library('image_lib', $config);

                $this->image_lib->resize();

                if (isset($hidden_main_image) && $hidden_main_image != "" && file_exists(FCPATH . uploads_path . '/category/' . $hidden_main_image)) {
                    @unlink($uploadPath . "/" . $hidden_main_image);
                }
            }

            if ($id > 0) {
                $data['updated_on'] = date("Y-m-d H:i:s");
                $this->model_event->update('app_service_category', $data, "id=$id");
                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_on'] = date("Y-m-d H:i:s");
                $id = $this->model_event->insert('app_service_category', $data);
                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/service-category', 'redirect');
        }
    }

    //delete an service category
    public function delete_service_category($id) {
        $event_data = $this->model_event->getData('app_services', 'id', "category_id='$id'");
        if (isset($event_data) && count($event_data) > 0) {
            $this->session->set_flashdata('msg', translate('record_not_allowed_to_delete'));
            $this->session->set_flashdata('msg_class', 'failure');
            echo 'false';
            exit(0);
        } else {
            $this->model_event->delete('app_service_category', "id='$id' AND created_by='$this->login_id'");
            $this->session->set_flashdata('msg', translate('record_delete'));
            $this->session->set_flashdata('msg_class', 'success');
            echo 'true';
            exit;
        }
    }

//     check service category title
    public function check_service_category_title() {
        $id = (int) $this->input->post('id', true);
        $title = trim($this->input->post('title', TRUE));

        if (isset($id) && $id > 0) {
            $where = "title='$title' AND id!='$id' AND type='S'";
        } else {
            $where = "title='$title' AND type='S'";
        }

        $check_title = $this->model_event->getData("app_service_category", "title", $where);
        if (isset($check_title) && count($check_title) > 0) {
            $this->form_validation->set_message('check_service_category_title', translate('title_already_exist'));
            return false;
        } else {
            return true;
        }
    }

    //delete service seo image
    public function delete_event_seo_image() {
        $image = $this->input->post('i', TRUE);
        $event_id = $this->input->post('id', TRUE);
        if (file_exists((FCPATH) . "/" . $image)) {
            if (unlink((FCPATH) . "/" . $image)) {
                $data['seo_og_image'] = "";
                $id = $this->model_event->update('app_services', $data, "id=$event_id");
                echo 'success';
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function check_upload_images($files_arr) {
        if (isset($files_arr) && !empty($files_arr)) {
            $total_files = count($files_arr);
            $empty_files_cnt = 0;
            foreach ($files_arr as $key => $val):
                if ($val == "") {
                    $empty_files_cnt++;
                }
            endforeach;
            if ($empty_files_cnt == $total_files) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /* Service Addons */

    public function addons($service_id) {
        $service_id = (int) $service_id;
        if ($service_id > 0) {
            if ($this->login_type == 'V') {
                $service_data = $this->model_event->getData('app_services', '*', "id=" . $service_id . " AND payment_type='P' AND created_by=" . $this->login_id);
            } else {
                $service_data = $this->model_event->getData('app_services', '*', "id=" . $service_id . " AND payment_type='P'");
            }
            if (count($service_data) > 0) {

                if ($this->login_type == 'V') {
                    $app_service_addons = $this->model_event->getData('app_service_addons', '*', "user_id=" . $this->login_id . " AND event_id=" . $service_id);
                } else {
                    $app_service_addons = $this->model_event->getData('app_service_addons', '*', "event_id=" . $service_id);
                }

                $data['app_service_addons'] = $app_service_addons;
                $data['service_id'] = $service_id;
                $data['service_data'] = $service_data[0];
                $data['title'] = translate('manage') . " " . translate('service') . " " . translate('add_ons');
                $this->load->view('admin/service/manage_service_addons', $data);
            } else {
                if ($this->login_type == 'V') {
                    redirect('vendor/manage-service');
                } else {
                    redirect('admin/manage-service');
                }
            }
        } else {
            if ($this->login_type == 'V') {
                redirect('vendor/manage-service');
            } else {
                redirect('admin/manage-service');
            }
        }
    }

    public function add_service_addons($service_id) {
        if ($this->login_type == 'V'):
            $service = $this->model_event->getData("app_services", "*", "id=" . $service_id . " AND payment_type='P'  AND created_by=" . $this->login_id);
        else:
            $service = $this->model_event->getData("app_services", "*", "id=" . $service_id . " AND payment_type='P' ");
        endif;

        if (count($service) > 0) {
            $data['title'] = translate('add') . " " . translate('service') . " " . translate('add_ons');
            $data['service_id'] = $service_id;
            $this->load->view('admin/service/add_update_service_addons', $data);
        } else {
            if ($this->login_type == 'V') {
                redirect('vendor/manage-service');
            } else {
                redirect('admin/manage-service');
            }
        }
    }

    public function update_addons_service($service_id, $add_on_id) {

        if ($this->login_type == 'V'):
            $service = $this->model_event->getData("app_services", "*", "id=" . $service_id . " AND payment_type='P' AND created_by=" . $this->login_id);
        else:
            $service = $this->model_event->getData("app_services", "*", "id=" . $service_id . " AND payment_type='P' ");
        endif;

        if (count($service) > 0) {
            $app_service_addons = $this->model_event->getData("app_service_addons", "*", "add_on_id='$add_on_id'");
            if (count($app_service_addons) > 0) {
                $data['app_service_addons'] = $app_service_addons[0];
                $data['service_id'] = $service_id;
                $data['title'] = translate('update') . " " . translate('service') . " " . translate('add_ons');
                $this->load->view('admin/service/add_update_service_addons', $data);
            } else {
                if ($this->login_type == 'V') {
                    redirect('vendor/manage-service');
                } else {
                    redirect('admin/manage-service');
                }
            }
        } else {
            if ($this->login_type == 'V') {
                redirect('vendor/manage-service');
            } else {
                redirect('admin/manage-service');
            }
        }
    }

    public function save_service_addons() {

        $hidden_main_image = $this->input->post('hidden_add_on_image', true);
        $service_id = $this->input->post('service_id', true);
        if ($this->login_type == 'V'):
            $service = $this->model_event->getData("app_services", "*", "id=" . $service_id . " AND payment_type='P' AND created_by=" . $this->login_id);
        else:
            $service = $this->model_event->getData("app_services", "*", "id=" . $service_id . " AND payment_type='P' ");
        endif;

        if (count($service) > 0) {

            $id = (int) $this->input->post('id', true);
            $this->form_validation->set_rules('title', 'title', 'required|trim');
            $this->form_validation->set_rules('details', 'details', 'required|trim');

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            if ($this->form_validation->run() == false) {
                if ($id > 0) {
                    $this->update_addons_service($id);
                } else {
                    $this->add_service_addons();
                }
            } else {
                $data['title'] = $this->input->post('title', true);
                $data['price'] = $this->input->post('price', true);
                $data['details'] = $this->input->post('details', true);
                $data['event_id'] = $this->input->post('service_id', true);
                $data['user_id'] = $this->login_id;

                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/event';

                if (isset($_FILES['event_add_on_image']["name"]) && $_FILES['event_add_on_image']["name"] != "") {
                    $tmp_name = $_FILES["event_add_on_image"]["tmp_name"];
                    $temp = explode(".", $_FILES["event_add_on_image"]["name"]);
                    $newfilename = (uniqid()) . '.' . end($temp);
                    move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                    $data['image'] = $newfilename;

                    if ($hidden_main_image != "" && $hidden_main_image != NULL) {
                        unlink($uploadPath . "/" . $hidden_main_image);
                    }
                }

                if ($id > 0) {
                    $data['updated_date'] = date("Y-m-d H:i:s");
                    $this->model_event->update('app_service_addons', $data, "add_on_id=$id");
                    $this->session->set_flashdata('msg', translate('service_add_ons_update'));
                    $this->session->set_flashdata('msg_class', 'success');
                } else {
                    $data['created_date'] = date("Y-m-d H:i:s");
                    $id = $this->model_event->insert('app_service_addons', $data);
                    $this->session->set_flashdata('msg', translate('service_add_ons_insert'));
                    $this->session->set_flashdata('msg_class', 'success');
                }
                $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
                redirect($folder_url . '/manage-service-addons/' . $service_id, 'redirect');
            }
        } else {
            if ($this->login_type == 'V') {
                redirect('vendor/manage-service');
            } else {
                redirect('admin/manage-service');
            }
        }
    }

    public function delete_service_addons($id) {
        $app_service_addons = $this->model_event->getData('app_service_addons', '*', "add_on_id=" . $id);
        if (count($app_service_addons) > 0) {
            $this->model_event->delete('app_service_addons', "add_on_id='$id' AND user_id='$this->login_id'");

            $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/event';

            if (isset($app_service_addons[0]['image']) && $app_service_addons[0]['image'] != "") {
                unlink($uploadPath . "/" . $app_service_addons[0]['image']);
            }

            $this->session->set_flashdata('msg', translate('service_add_ons_delete'));
            $this->session->set_flashdata('msg_class', 'success');
            echo 'true';
            exit;
        } else {
            $this->model_event->delete('app_service_category', "id='$id' AND user_id='$this->login_id'");
            $this->session->set_flashdata('msg', translate('service_add_ons_delete'));
            $this->session->set_flashdata('msg_class', 'success');
            echo 'true';
            exit;
        }
    }

    function view_booking_details($id) {
        $data['title'] = translate('view') . " " . ('booking');
        $join = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_services.id=app_service_appointment.event_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_services.city',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_services.location',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_service_category',
                'condition' => 'app_service_category.id=app_services.category_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_customer',
                'condition' => 'app_customer.id=app_service_appointment.customer_id',
                'jointype' => 'left'
            ),
            array(
                'table' => 'app_admin',
                'condition' => 'app_admin.id=app_services.created_by',
                'jointype' => 'left'
            )
        );

        $e_condition = "app_service_appointment.id=" . $id;
        $event_data = $this->model_event->getData("app_service_appointment", "app_service_appointment.* ,app_service_appointment.price as final_price,app_services.title as Event_title,app_location.loc_title,app_city.city_title,app_service_category.title as category_title,CONCAT(app_customer.first_name,' ',app_customer.last_name) as Customer_name,app_customer.phone as Customer_phone,app_customer.email as Customer_email,app_service_appointment.addons_id,app_services.price,app_admin.company_name,app_services.description as Event_description, app_services.payment_type", $e_condition, $join);

        $data['event_data'] = $event_data;
        $this->load->view('admin/service/view_booking_details', $data);
    }

    public function appointment_payment() {

        $Vendor_ID = $this->session->userdata('Vendor_ID');
        $fields = "";
        $fields .= "app_service_appointment_payment.*,CONCAT(app_admin.first_name,' ',app_admin.last_name) as vendor_name,app_services.title as event_name,CONCAT(app_customer.first_name,' ',app_customer.last_name) as customer_name";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_service_appointment_payment.vendor_id",
                "jointype" => "INNER"),
            array(
                "table" => "app_services",
                "condition" => "(app_services.id=app_service_appointment_payment.event_id  AND app_services.type='S')",
                "jointype" => "INNER"),
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_service_appointment_payment.customer_id",
                "jointype" => "INNER")
        );

        $payment_data = $this->model_event->getData("app_service_appointment_payment", $fields, "app_service_appointment_payment.vendor_id=" . $Vendor_ID, $join, "id DESC");

        $data['title'] = translate('payment_history');
        $data['payment_data'] = $payment_data;
        $this->load->view('admin/service/vendor_appointment_payment', $data);
    }

    /* Holiday Module 07-11-2019 */

    public function holiday() {
        $holiday = $this->model_event->getData('app_holidays', '*', "created_by=" . $this->login_id);
        $data['title'] = translate('manage') . " " . translate('holiday');
        $data['holiday'] = $holiday;
        $this->load->view('admin/service/manage_holidays', $data);
    }

    public function add_holiday() {

        $data['title'] = translate('add') . " " . translate('holiday');
        $data['holiday'] = array();
        $this->load->view('admin/service/add_update_holiday', $data);
    }

    public function update_holiday($id) {
        $id = (int) $id;

        if ($id > 0) {

            $app_holidays = $this->model_event->getData("app_holidays", "*", "id='$id'");
            if (isset($app_holidays[0]) && !empty($app_holidays[0])) {
                $data['title'] = translate('update') . " " . translate('holiday');
                $data['holiday'] = $app_holidays[0];
                $this->load->view('admin/service/add_update_holiday', $data);
            } else {
                $this->session->set_flashdata('msg_class', 'failure');
                $this->session->set_flashdata('msg', translate('invalid_request'));

                $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
                redirect($folder_url . '/holiday', 'redirect');
            }
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/holiday', 'redirect');
        }
    }

    public function save_holiday() {
        $id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', translate('title'), 'required|trim');
        $this->form_validation->set_rules('holiday_date', translate('date'), 'required|trim|callback_holiday_check');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($id > 0) {
                $this->update_holiday($id);
            } else {
                $this->add_holiday();
            }
        } else {

            $data['title'] = $this->input->post('title', true);
            $data['holiday_date'] = date("Y-m-d", strtotime($this->input->post('holiday_date', true)));
            $data['status'] = $this->input->post('status', true);
            $data['created_by'] = $this->login_id;

            if ($id > 0) {
                $this->model_event->update('app_holidays', $data, "id=" . $id);
                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_date'] = date("Y-m-d H:i:s");
                $id = $this->model_event->insert('app_holidays', $data);
                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/holiday/', 'redirect');
        }
    }

    public function delete_holiday($id) {
        $this->model_event->delete('app_holidays', 'id=' . $id . " AND created_by=" . $this->login_id);
        $this->session->set_flashdata('msg', translate('record_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    public function holiday_check($str) {

        $holiday_date = date("Y-m-d", strtotime($this->input->post('holiday_date', true)));
        $id = $this->input->post('id');
        $created_by = $this->login_id;

        if ($id > 0) {
            $app_holidays = $this->model_event->getData("app_holidays", "*", "created_by=" . $created_by . " AND holiday_date='" . $holiday_date . "' AND id!=" . $id);
        } else {
            $app_holidays = $this->model_event->getData("app_holidays", "*", "created_by=" . $created_by . " AND holiday_date='" . $holiday_date . "'");
        }

        if (count($app_holidays) > 0) {
            $this->form_validation->set_message('holiday_check', translate('holiday_exist'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //show appointment page
    public function manage_appointment($id = '0') {

        $event = isset($_REQUEST['event']) ? $_REQUEST['event'] : "";
        $vendor = isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : "";
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
        $appointment_type = isset($_REQUEST['appointment_type']) ? $_REQUEST['appointment_type'] : "U";

        $cond = " app_service_appointment.event_id >0 AND app_service_appointment.type='S' AND app_service_appointment.payment_status!='IN'";

        $vendor_condition = " ";

        if ($this->login_type == 'V') {
            $cond .= " AND app_services.created_by = $this->login_id";
            $vendor_condition .= "app_services.type='S' AND app_services.created_by=" . $this->login_id;
        } else {
            $vendor_condition .= "app_services.type='S'";
            $cond .= '';
        }
        if ((int) $id > 0) {
            $cond .= " AND app_service_appointment.event_id = '$id'";
        }

        if (isset($event) && $event > 0) {
            $cond .= " AND app_service_appointment.event_id=" . $event;
        }

        if (isset($vendor) && $vendor > 0) {
            $cond .= " AND app_services.created_by=" . $vendor;
        }

        if (isset($status) && $status != "") {
            $cond .= " AND app_service_appointment.status='" . $status . "'";
        }
        if (isset($type) && $type != "") {
            $cond .= " AND app_services.payment_type='" . $type . "'";
        }
        $cur_date = date("Y-m-d");

        if (isset($appointment_type) && $appointment_type == 'U') {
            $cond .= " AND app_service_appointment.start_date>='" . $cur_date . "' ";
        } else {
            $cond .= " AND app_service_appointment.start_date<'" . $cur_date . "'  ";
        }


        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_service_appointment.customer_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_services",
                "condition" => "app_services.id=app_service_appointment.event_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_admin",
                "condition" => "app_services.created_by=app_admin.id",
                "jointype" => "INNER")
        );

        $appointment = $this->model_appointment->getData('app_service_appointment', 'app_service_appointment.*,app_admin.company_name,app_customer.first_name,app_customer.last_name,app_services.title,app_services.created_by,app_services.payment_type', $cond, $join, "app_service_appointment.start_date ASC,app_service_appointment.start_time ASC");
        $data['appointment_data'] = $appointment;

        $join_one = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_services.id=app_service_appointment.event_id',
                'jointype' => 'INNER'
            )
        );


        $join_two = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_services.id=app_service_appointment.event_id',
                'jointype' => 'inner'
            ), array(
                'table' => 'app_admin',
                'condition' => 'app_services.created_by=app_admin.id',
                'jointype' => 'inner'
            )
        );

        $appointment_event = $this->model_appointment->getData("app_service_appointment", "app_service_appointment.event_id,app_services.id as event_id,app_services.title as title", $vendor_condition, $join_one, "", "app_services.id");
        $appointment_vendor = $this->model_appointment->getData("app_service_appointment", "app_admin.company_name,app_admin.first_name,app_admin.last_name,app_admin.id", "", $join_two, "", "app_admin.id");

        $city_join = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_city.city_id=app_services.city',
                'jointype' => 'inner'
            )
        );
        $top_cities = $this->model_appointment->getData('app_city', 'app_city.*', 'app_services.status="A"', $city_join, 'city_id', 'city_id', '', 12, array(), '', array(), 'DESC');

        $data['appointment_data'] = $appointment;
        $data['appointment_vendor'] = $appointment_vendor;
        $data['topCity_List'] = $top_cities;
        $data['appointment_event'] = $appointment_event;

        $data['title'] = translate('manage') . " " . translate('appointment');
        $this->load->view('admin/service/manage_appointment', $data);
    }

    public function change_appointment_status($id, $status) {
        if ((int) $id > 0) {
            //Get Booking Details
            $result_data = get_full_event_service_data_by_booking_id($id);

            $start_date = $result_data['start_date'];
            $start_time = $result_data['start_time'];
            $event_id = $result_data['event_id'];
            $customer_id = $result_data['customer_id'];
            $staff_id = (int) $result_data['staff_id'];
            $customer_data = get_customer_data($customer_id);
            $service_data = get_full_event_service_data($event_id);

            $multiple_slotbooking_allow = $service_data['multiple_slotbooking_allow'];
            $multiple_slotbooking_limit = $service_data['multiple_slotbooking_limit'];

            if ($status == 'A'):

                if ($staff_id > 0):
                    $get_data = $this->db->query("SELECT * FROM app_service_appointment WHERE id!=" . $id . " AND staff_id=" . $staff_id . " AND event_id=" . $event_id . " AND start_date='" . $start_date . "' AND start_time='" . $start_time . "' AND type='S' AND status IN ('A')")->result_array();
                else:
                    $get_data = $this->db->query("SELECT * FROM app_service_appointment WHERE id!=" . $id . " AND event_id=" . $event_id . " AND start_date='" . $start_date . "' AND start_time='" . $start_time . "' AND type='S' AND status IN ('A')")->result_array();
                endif;

                //Check if multiple booking allowed
                if ($multiple_slotbooking_allow == 'Y'):
                    if (count($get_data) <= $multiple_slotbooking_limit) {
                        //Approvr this
                        $this->model_appointment->update('', array('status' => strtoupper($status)), "id='$id'");

                        $name = ($customer_data['first_name']) . " " . ($customer_data['last_name']);
                        $subject = translate('appointment_booking') . " | " . translate('notification');
                        $define_param['to_name'] = $name;
                        $define_param['to_email'] = $customer_data['email'];

                        $parameter['name'] = $name;
                        $parameter['content'] = str_replace('{status}', print_appointment_status(strtoupper($status)), translate('booking_approve_reject'));
                        $parameter['appointment_date'] = get_formated_date(($start_date . " " . $start_time));
                        $parameter['service_data'] = $service_data;

                        if ($staff_id > 0):
                            $parameter['staff_data'] = get_staff_row_by_id($staff_id);
                        endif;

                        $html = $this->load->view("email_template/service_booking_approve", $parameter, true);

                        $this->session->set_flashdata('msg_class', 'success');
                        $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper($status)), translate('appointment_status')));

                        $this->sendmail->send($define_param, $subject, $html);
                    } else {

                        //Reject this booking as not available
                        $this->model_appointment->update('', array('status' => 'R'), "id='$id'");

                        $name = ($customer_data['first_name']) . " " . ($customer_data['last_name']);
                        $subject = translate('appointment_booking') . " | " . translate('notification');
                        $define_param['to_name'] = $name;
                        $define_param['to_email'] = $customer_data['email'];

                        $parameter['name'] = $name;
                        $parameter['content'] = str_replace('{status}', print_appointment_status(strtoupper('R')), translate('booking_approve_reject'));
                        $parameter['appointment_date'] = get_formated_date(($start_date . " " . $start_time));
                        $parameter['service_data'] = $service_data;

                        if ($staff_id > 0):
                            $parameter['staff_data'] = get_staff_row_by_id($staff_id);
                        endif;

                        $html = $this->load->view("email_template/service_booking_approve", $parameter, true);

                        $this->session->set_flashdata('msg_class', 'success');
                        $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper('R')), translate('appointment_status')));

                        $this->sendmail->send($define_param, $subject, $html);
                    }
                else:
                    if (count($get_data) > 0) {
                        //Reject this booking as not available
                        $this->model_appointment->update('', array('status' => 'R'), "id='$id'");

                        $name = ($customer_data['first_name']) . " " . ($customer_data['last_name']);
                        $subject = translate('appointment_booking') . " | " . translate('notification');
                        $define_param['to_name'] = $name;
                        $define_param['to_email'] = $customer_data['email'];

                        $parameter['name'] = $name;
                        $parameter['content'] = str_replace('{status}', print_appointment_status(strtoupper('R')), translate('booking_approve_reject'));
                        $parameter['appointment_date'] = get_formated_date(($start_date . " " . $start_time));
                        $parameter['service_data'] = $service_data;

                        if ($staff_id > 0):
                            $parameter['staff_data'] = get_staff_row_by_id($staff_id);
                        endif;

                        $html = $this->load->view("email_template/service_booking_approve", $parameter, true);

                        $this->session->set_flashdata('msg_class', 'success');
                        $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper('R')), translate('appointment_status')));

                        $this->sendmail->send($define_param, $subject, $html);
                    } else {
                        //Approvr this
                        $this->model_appointment->update('', array('status' => strtoupper($status)), "id='$id'");

                        $name = ($customer_data['first_name']) . " " . ($customer_data['last_name']);
                        $subject = translate('appointment_booking') . " | " . translate('notification');
                        $define_param['to_name'] = $name;
                        $define_param['to_email'] = $customer_data['email'];

                        $parameter['name'] = $name;
                        $parameter['content'] = str_replace('{status}', print_appointment_status(strtoupper($status)), translate('booking_approve_reject'));
                        $parameter['appointment_date'] = get_formated_date(($start_date . " " . $start_time));
                        $parameter['service_data'] = $service_data;

                        if ($staff_id > 0):
                            $parameter['staff_data'] = get_staff_row_by_id($staff_id);
                        endif;

                        $html = $this->load->view("email_template/service_booking_approve", $parameter, true);

                        $this->session->set_flashdata('msg_class', 'success');
                        $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper($status)), translate('appointment_status')));

                        $this->sendmail->send($define_param, $subject, $html);
                    }
                endif;
            else:
                $this->model_appointment->update('', array('status' => strtoupper($status)), "id='$id'");

                $name = ($customer_data['first_name']) . " " . ($customer_data['last_name']);
                $subject = translate('appointment_booking') . " | " . translate('notification');
                $define_param['to_name'] = $name;
                $define_param['to_email'] = $customer_data['email'];

                $parameter['name'] = $name;
                $parameter['content'] = str_replace('{status}', print_appointment_status(strtoupper($status)), translate('booking_approve_reject'));
                $parameter['appointment_date'] = get_formated_date(($start_date . " " . $start_time));
                $parameter['service_data'] = $service_data;

                if ($staff_id > 0):
                    $parameter['staff_data'] = get_staff_row_by_id($staff_id);
                endif;

                $html = $this->load->view("email_template/service_booking_approve", $parameter, true);
                $this->session->set_flashdata('msg_class', 'success');
                $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper($status)), translate('appointment_status')));
                $this->sendmail->send($define_param, $subject, $html);
            endif;
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
        }
    }

    public function send_remainder() {
        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_service_appointment.customer_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_services",
                "condition" => "app_services.id=app_service_appointment.event_id",
                "jointype" => "LEFT")
        );
        $id = $this->input->post('event_book_id', true);
        if ((int) $id > 0) {
            $cond = "app_service_appointment.id = '$id'";
            $res = $this->model_appointment->getData('', 'app_service_appointment.*,app_customer.first_name,app_customer.last_name,app_customer.email, app_services.title,app_services.description, app_services.created_by', $cond, $join)[0];

            $service_data = get_full_event_service_data($res['event_id']);

            $staff_id = $res['staff_id'];
            $event_title = $res['title'];
            $name = ($res['first_name']) . " " . ($res['last_name']);
            $email = $res['email'];
            $description = $res['description'];
            $startdate = date("m/d/Y", strtotime($res['start_date']));
            $starttime = date("H:i a", strtotime($res['start_time']));

            $subject2 = translate('appointment_booking_reminder');
            $define_param2['to_name'] = $name;
            $define_param2['to_email'] = $email;

            $parameterv['name'] = $name;
            $parameterv['appointment_date'] = get_formated_date($startdate . " " . $starttime);
            $parameterv['service_data'] = $service_data;

            if ($staff_id > 0):
                $parameterv['staff_data'] = get_staff_row_by_id($staff_id);
            endif;

            $html2 = $this->load->view("email_template/service_reminder", $parameterv, true);

            $send = $this->sendmail->send($define_param2, $subject2, $html2);
            if ($send) {
                $this->session->set_flashdata('msg', translate('remainder_mail_success'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $this->session->set_flashdata('msg', translate('remainder_mail_failure'));
                $this->session->set_flashdata('msg_class', 'failure');
            }
        }
    }

    public function payment_history() {
        $fields = "";
        $fields .= "app_service_appointment_payment.*,CONCAT(app_admin.first_name,' ',app_admin.last_name) as vendor_name,app_admin.company_name,app_services.title as event_name,CONCAT(app_customer.first_name,' ',app_customer.last_name) as customer_name";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_service_appointment_payment.vendor_id",
                "jointype" => "INNER"),
            array(
                "table" => "app_services",
                "condition" => "(app_services.id=app_service_appointment_payment.event_id AND app_services.type='S')",
                "jointype" => "INNER"),
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_service_appointment_payment.customer_id",
                "jointype" => "INNER")
        );

        $payment_data = $this->model_appointment->getData("app_service_appointment_payment", $fields, "", $join, "id DESC");

        $data['title'] = translate('payout_request');
        $data['payment_data'] = $payment_data;
        $this->load->view('admin/service/payment_history', $data);
    }

    public function change_booking_slot($book_id, $event_id, $staff_id = null) {
        $folder_name = "admin";
        if ($this->login_type == 'V'):
            $folder_name = "vendor";
        endif;
        //show days page
        if ($book_id && $event_id) {
            $id = (int) $event_id;
            $join_data = array(
                array(
                    'table' => 'app_city',
                    'condition' => 'app_city.city_id=app_services.city',
                    'jointype' => 'left'
                ),
                array(
                    'table' => 'app_location',
                    'condition' => 'app_location.loc_id=app_services.location',
                    'jointype' => 'left'
                ),
                array(
                    'table' => 'app_service_category',
                    'condition' => 'app_service_category.id=app_services.category_id',
                    'jointype' => 'left'
                ),
                array(
                    'table' => 'app_admin',
                    'condition' => 'app_admin.id=app_services.created_by',
                    'jointype' => 'left'
                ),
            );
            $select_value = "app_services.*,app_location.loc_title,app_city.city_title,app_service_category.title as category_title,app_admin.company_name";
            $event = $this->model_appointment->getData("app_services", $select_value, "app_services.id=" . $id . " AND app_services.type='S'", $join_data);
            if (!isset($event) || isset($event) && count($event) == 0) {
                $this->session->set_flashdata('msg_class', 'failure');
                $this->session->set_flashdata('msg', translate('invalid_request'));
                redirect(base_url($folder_name . '/manage-appointment'));
            }

            //check booking
            $app_service_appointment = $this->model_appointment->getData("app_service_appointment", '*', "id=" . $book_id);
            if (count($app_service_appointment) == 0) {
                $this->session->set_flashdata('msg_class', 'failure');
                $this->session->set_flashdata('msg', translate('invalid_request'));
                redirect(base_url($folder_name . '/manage-appointment'));
            }

            $booking_staff_id = $app_service_appointment[0]['staff_id'];
            //Get Staff
            $staff_member_value = 0;

            if (isset($event[0]['staff']) && $event[0]['staff'] != ""):
                $staff = get_staff_by_id($event[0]['staff']);
                if ($staff_id > 0):
                    $staff_member_value = $staff_id;
                else:
                    if (isset($booking_staff_id) && $booking_staff_id > 0) {
                        $staff_member_value = $booking_staff_id;
                    } else {
                        $staff_member_value = $staff[0]['id'];
                    }
                endif;
                $data['staff_data'] = $staff;
            endif;


            if ($staff_member_value > 0) {
                $current_selected_staff = get_staff_by_id($id);
            } else {
                $current_selected_staff = get_VendorDetails($event[0]['created_by']);
            }

            $data['staff_member_value'] = $staff_member_value;
            $data['current_selected_staff'] = $current_selected_staff;

            $min = $event[0]['slot_time'];
            $allow_day = explode(",", $event[0]['days']);
            $date = date('d-m-Y');

            $month_ch = date("M", strtotime($date));
            $year = date("Y", strtotime($date));
            $day = date("d", strtotime($date));

            //Get Holiday List
            $get_holiday_list = get_holiday_list_by_vendor($event[0]['created_by']);

            //Display Current date data
            if (isset($date) && $date != "") {
                if (!in_array($date, $get_holiday_list)) {
                    $dayOfWeek = date('D', strtotime($date));
                    $todays_date = date('d', strtotime($date));

                    if (in_array($dayOfWeek, $allow_day)) {
                        $check = $this->_day_slots_check($todays_date . "-" . $month . "-" . $year, $min, $id, $staff_member_value);
                        $day_data[] = array(
                            "week" => get_day_of_week($dayOfWeek),
                            "month" => $month_ch,
                            "date" => $todays_date,
                            "check" => $check,
                            "full_date" => "$year-$month-$todays_date"
                        );
                    }
                }
            }


            // Calculate Next Days
            $number = get_site_setting('slot_display_days');

            for ($k = 1; $k <= $number; $k++) {

                $datetime = new DateTime($date);
                $datetime->modify('+' . $k . ' day');
                $new_next_date = $datetime->format('d-m-Y');

                $dayOfWeeks = date('D', strtotime($new_next_date));
                $next_year = date('Y', strtotime($new_next_date));
                $next_month = date('m', strtotime($new_next_date));
                $updated_new_date = date('d', strtotime($new_next_date));

                if (!in_array($new_next_date, $get_holiday_list)) {
                    if (in_array($dayOfWeeks, $allow_day)) {
                        $checks = $this->_day_slots_check($updated_new_date . "-" . $next_month . "-" . $next_year, $min, $id, $staff_member_value);
                        $day_data[] = array(
                            "week" => get_day_of_week($dayOfWeeks),
                            "month" => date('M', strtotime($new_next_date)),
                            "date" => $updated_new_date,
                            "check" => $checks,
                            "full_date" => "$next_year-$next_month-$updated_new_date"
                        );
                    }
                }
            }


            $data['event_payment_price'] = number_format($event[0]['price'], 0);
            $data['event_payment_type'] = $event[0]['payment_type'];
            $data['booking_data'] = $app_service_appointment[0];
            $data['slot_time'] = $event[0]['slot_time'];
            $data['event_title'] = $event[0]['title'];
            $data['event_id'] = $event[0]['id'];
            $data['current_date'] = $date;
            $data['day_data'] = $day_data;
            $data['event_data'] = isset($event[0]) ? $event[0] : array();
            $data['book_id'] = $book_id;
            $data['title'] = translate('change') . " " . translate('booking') . " " . translate('time');
            $this->load->view('admin/service/days', $data);
        }
    }

    //check days available or not
    private function _day_slots_check($k, $min, $cur_event_id, $staff_member_id) {
        $event = $this->model_appointment->getData("app_services", "*", "status='A' AND slot_time='" . $min . "' AND id=" . $cur_event_id);

        $slot_time = $event[0]['slot_time'];
        $multiple_slotbooking_allow = $event[0]['multiple_slotbooking_allow'];
        $multiple_slotbooking_limit = $event[0]['multiple_slotbooking_limit'];

        $j = get_formated_time(strtotime("-" . $slot_time . "minute", strtotime($event[0]['end_time'])));
        $datetime1 = new DateTime($event[0]['start_time']);
        $datetime2 = new DateTime($event[0]['end_time']);
        $interval = $datetime1->diff($datetime2);
        $minute = $interval->format('%h') * 60;
        $time_array = array();
        for ($i = 1; $i <= $minute / $slot_time; $i++) {
            if ($i == 1) {
                $time_array[] = get_formated_time(strtotime($event[0]['start_time']));
            } else {
                $time_array[] = get_formated_time(strtotime("+" . $slot_time * ($i - 1) . " minute", strtotime($event[0]['start_time'])));
            }
        }
        if (($key = array_search(get_formated_time(strtotime($event[0]['end_time'])), $time_array)) !== false) {
            unset($time_array[$key]);
        }
        $start_date = date("Y-m-d", strtotime($k));
        if ($start_date == date("Y-m-d")) {
            foreach ($time_array as $key => $value) {
                if (get_formated_time(strtotime('H:i')) > get_formated_time(strtotime($value))) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        }
        $customer_id = (int) $this->session->userdata('CUST_ID');
        $book_month = date('m', strtotime($start_date));

        if ($staff_member_id > 0):
            $result = $this->model_appointment->getData("app_service_appointment", "start_time,slot_time", "start_date = '" . $start_date . "' AND staff_id=" . $staff_member_id);
        else:
            $result = $this->model_appointment->getData("app_service_appointment", "start_time,slot_time", "start_date = '" . $start_date . "' AND event_id=" . $cur_event_id);
        endif;


        if (isset($result) && count($result) > 0) {
            foreach ($result as $key => $value) {
                if ($min == $value['slot_time']) {

                    if ($staff_member_id > 0):
                        $multiple_boook_result = $this->model_appointment->getData("app_service_appointment", "start_time,slot_time", "start_time='" . $value['start_time'] . "' AND start_date = '" . $start_date . "' AND event_id=" . $cur_event_id . " AND staff_id=" . $staff_member_id . " AND status IN ('A')");
                    else:
                        $multiple_boook_result = $this->model_appointment->getData("app_service_appointment", "start_time,slot_time", "start_time='" . $value['start_time'] . "' AND start_date = '" . $start_date . "' AND event_id=" . $cur_event_id . " AND status IN ('A')");
                    endif;

                    if (isset($multiple_slotbooking_allow) && $multiple_slotbooking_allow == 'Y') {
                        if (count($multiple_boook_result) <= $multiple_slotbooking_limit) {
                            $time_array = $this->_check_slot($time_array, $value['start_time'], $value['slot_time'], $min);
                        } else {
                            $time_slot = date("H:i", strtotime($value['start_time']));
                            if (($key = array_search($time_slot, $time_array)) !== false) {
                                unset($time_array[$key]);
                            }
                        }
                    } else {
                        $time_slot = date("H:i", strtotime($value['start_time']));
                        if (($key = array_search($time_slot, $time_array)) !== false) {
                            unset($time_array[$key]);
                        }
                    }
                } else {
                    $time_array = $this->_check_slot($time_array, $value['start_time'], $value['slot_time'], $min);
                }
            }
            if (isset($time_array) && count($time_array) > 0) {
                return '1';
            }
            return '0';
        }
        return '1';
    }

    private function _check_slot($time_array, $start_time, $slot_time, $current_slot_time, $gap_time = 0) {
        if ($slot_time > $current_slot_time) {
            $min_time = get_formated_time(strtotime($start_time));

            $max_time = get_formated_time(strtotime("+" . $slot_time + $gap_time . " minute", strtotime($start_time)));
            foreach ($time_array as $key => $value) {
                if ($min_time <= $value && $max_time > $value) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        } else if ($slot_time < $current_slot_time) {
            $min_time = get_formated_time(strtotime($start_time));
            $max_time = get_formated_time(strtotime("+" . $slot_time + $gap_time . " minute", strtotime($start_time)));
            foreach ($time_array as $key => $value) {
                $current_end_time = get_formated_time(strtotime("+" . $current_slot_time . " minute", strtotime($value)));
                if ($value <= $min_time && $current_end_time > $min_time) {
                    if (($key = array_search($value, $time_array)) !== false) {
                        unset($time_array[$key]);
                    }
                }
            }
        }
        return $time_array;
    }

}

?>