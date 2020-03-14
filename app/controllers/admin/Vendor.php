<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendor extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_vendor');
        check_mandatory();
        set_time_zone();
        if (get_site_setting('is_display_vendor') == 'N'):
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/dashboard', 'redirect');
        endif;
    }

    //show vendor list
    public function index() {
        $data['title'] = translate('manage') . " " . translate('vendor');
        $vendor = $this->model_vendor->getData("app_admin", '*', "type='V'");
        $data['vendor_data'] = $vendor;
        $this->load->view('admin/vendor/manage_vendor', $data);
    }

    //Show unverified vendor list
    public function unverified_vendor() {
        $data['title'] = translate('unverified') . " " . translate('vendor');
        $vendor = $this->model_vendor->getData("app_admin", '*', "type='V' AND profile_status='N'");
        $data['vendor_data'] = $vendor;
        $this->load->view('admin/vendor/unverified_vendor', $data);
    }

    //delete vendor
    public function delete_vendor($id) {
        $service_data = $this->model_vendor->getData('app_services', 'id', "created_by='$id'");
        if (isset($service_data) && count($service_data) > 0) {
            $this->session->set_flashdata('msg', translate('record_not_allowed_to_delete'));
            $this->session->set_flashdata('msg_class', 'failure');
            echo 'false';
            exit(0);
        } else {
            $this->model_vendor->delete('app_admin', 'id=' . $id);
            $this->session->set_flashdata('msg', translate('record_delete'));
            $this->session->set_flashdata('msg_class', 'success');
            echo 'true';
            exit;
        }
    }

    //change status of vendor
    public function change_vendor_tatus($id) {
        $status = $this->input->post('status', true);
        $update = array(
            'status' => $status
        );
        $this->model_vendor->update('app_admin', $update, 'id=' . $id);
        $this->session->set_flashdata('msg', translate('record_status'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    public function unverified_vendor_action() {
        $user_id = (int) $this->input->post('CustomerIDVal', true);
        if (isset($user_id) && $user_id > 0) {
            $status = trim($this->input->post('get_status', true));
            $update = array(
                'profile_status' => $status
            );

            $status_name = "";
            if ($status == 'V'):
                $status_name = translate('approved');
            endif;
            if ($status == 'R'):
                $status_name = translate('rejected');
            endif;

            $this->model_vendor->update('app_admin', $update, 'id=' . $user_id);
            //Send email to vendor
            $vendor = $this->model_vendor->getData("app_admin", '*', "id=" . $user_id)[0];
            $first_name = $vendor['first_name'];
            $last_name = $vendor['last_name'];
            $email = $vendor['email'];

            //Send email to vendor
            $subject = translate('profile') . " " . translate('verification') . " " . translate('update');
            $define_param['to_name'] = $first_name . " " . $last_name;
            $define_param['to_email'] = $email;

            $parameter['NAME'] = $first_name . " " . $last_name;
            $parameter['profile_verification_content'] = translate('profile_verification_content') . " <b>" . $status_name . "</b>";

            $html = $this->load->view("email_template/vendor_profile_verification", $parameter, true);
            $send = $this->sendmail->send($define_param, $subject, $html);

            $this->session->set_flashdata('msg', translate('vendor_status'));
            $this->session->set_flashdata('msg_class', 'success');

            redirect('admin/unverified-vendor');
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', translate('invalid_request'));
            redirect('admin/unverified-vendor');
        }
    }

    public function vendor_payment() {
        $data['vendor_payment'] = $this->model_vendor->get_vendor_payment_list($this->login_id);
        $data['title'] = translate('vendor_Payment');
        $this->load->view('admin/vendor/manage_vendor_payment', $data);
    }

    public function send_vendor_payment($id) {
        $this->model_vendor->update('app_service_appointment_payment', array('transfer_status' => 'S'), "id='$id'");
        $this->session->set_flashdata('msg', translate('vendor_payment_send'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    public function add_vendor() {
        $data['title'] = translate('add_vendor');
        $this->load->view('admin/vendor/add_update_vendor', $data);
    }

    public function update_vendor($id) {
        $cond = 'id=' . $id;

        $vendor = $this->model_vendor->getData("app_admin", "*", $cond);
        if (isset($vendor[0]) && !empty($vendor[0])) {
            $data['vendor_data'] = $vendor[0];
            $data['title'] = translate('update') . " " . translate('vendor');
            $this->load->view('admin/vendor/add_update_vendor', $data);
        } else {
            show_404();
        }
    }

    public function vendor_details($id) {
        $cond = 'id=' . $id;

        $vendor = $this->model_vendor->getData("app_admin", "*", $cond);
        if (isset($vendor[0]) && !empty($vendor[0])) {
            $data['vendor_data'] = $vendor[0];
            $data['title'] = translate('update') . " " . translate('vendor');
            $this->load->view('admin/vendor/vendor_details', $data);
        } else {
            show_404();
        }
    }

    public function save_vendor() {

        $hidden_profile_image = $this->input->post('hidden_profile_image');
        $user_id = (int) $this->input->post('vendor_id');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[app_admin.email.id.' . $user_id . ']');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|is_unique[app_admin.phone.id.' . $user_id . ']');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($user_id > 0) {
                $this->update_vendor($user_id);
            } else {
                $this->add_vendor();
            }
        } else {
            $this->load->helper('string');
            $password = random_string('alnum', 8);
            $data = array(
                'first_name' => trim($this->input->post('first_name')),
                'last_name' => trim($this->input->post('last_name')),
                'email' => trim($this->input->post('email')),
                'company_name' => trim($this->input->post('company')),
                'website' => trim($this->input->post('website')),
                'phone' => $this->input->post('phone'),
                'type' => 'V',
                'status' => trim($this->input->post('status')),
                'address' => trim($this->input->post('address')),
                'profile_status' => 'V'
            );

            $uploadPath = dirname(BASEPATH) . "/" . uploads_path . '/';
            if (isset($_FILES['profile_image']["name"]) && $_FILES['profile_image']["name"] != "") {
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $data['profile_image'] = $newfilename;
                if ($hidden_profile_image != "" && $hidden_profile_image != NULL) {
                    @unlink($uploadPath . "/" . $hidden_profile_image);
                }
            }


            if ($user_id > 0) {
                $this->model_vendor->update('app_admin', $data, 'id=' . $user_id);
                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['password'] = md5(trim($password));
                $data['created_on'] = date("Y-m-d H:i:s");
                $name = (trim($this->input->post('first_name'))) . " " . (trim($this->input->post('last_name')));
                $hidenuseremail = $this->input->post('email');
                $this->model_vendor->insert('app_admin', $data);

                //Send email to vendor
                $subject = translate('vendor') . " | " . translate('account_registration');
                $define_param['to_name'] = $name;
                $define_param['to_email'] = $hidenuseremail;

                $parameter['NAME'] = $name;
                $parameter['LOGIN_URL'] = base_url('vendor/login');
                $parameter['EMAIL'] = $hidenuseremail;
                $parameter['PASSWORD'] = $password;

                $html = $this->load->view("email_template/registration_admin", $parameter, true);
                $send = $this->sendmail->send($define_param, $subject, $html);

                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/vendor', 'redirect');
        }
    }

    public function payout_request() {
        $fields = "";
        $fields .= "app_payment_request.*,CONCAT(app_admin.first_name,' ',app_admin.last_name) as vendor_name,app_admin.company_name,app_admin.profile_image as vendor_profile_image";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_payment_request.vendor_id",
                "jointype" => "INNER")
        );

        $payment_data = $this->model_vendor->getData("app_payment_request", $fields, "", $join, "id DESC");

        $data['title'] = translate('payout_request');
        $data['payment_data'] = $payment_data;
        $this->load->view('admin/vendor/payout_request', $data);
    }

    public function send_vendor_forgot_password_link() {
        $customer_id = $this->input->post("cust_id", true);
        $email = $this->input->post("email", true);

        $vendor_data = $this->model_vendor->check_username($email);
        $this->load->helper('string');

        if ($vendor_data['errorCode'] == 1) {
            $code = random_string('numeric', 6);
            $updata = array(
                'reset_password_check' => $code,
                'reset_password_requested_on' => date("Y-m-d H:i:s")
            );
            $define_param['to_name'] = ($vendor_data['first_name']) . " " . ($vendor_data['last_name']);
            $define_param['to_email'] = $vendor_data['email'];
            $userid = $vendor_data['id'];
            $hidenuseremail = $vendor_data['email'];
            $hidenusername = ($vendor_data['first_name']) . " " . ($vendor_data['last_name']);

            //Encryprt data
            $encid = $this->general->encryptData($userid);
            $encemail = $this->general->encryptData($hidenuseremail);
            $url = base_url("vendor/reset-password/" . $encid . "/" . $encemail);
            $update['reset_password_check'] = 0;
            $update['reset_password_requested_on'] = date("Y-m-d H:i:S");
            $this->model_vendor->update("app_admin", $update, "id='" . $userid . "'");

            // Send email
            $subject = translate('reset_password');
            $define_param['to_name'] = $hidenusername;
            $define_param['to_email'] = $hidenuseremail;

            $parameter['URL'] = $url;
            $html = $this->load->view("email_template/forgot_password", $parameter, true);
            $this->sendmail->send($define_param, $subject, $html);

            $this->session->set_flashdata('msg', $vendor_data['errorMessage']);
            $this->session->set_flashdata('msg_class', 'success');
            redirect('admin/vendor-details/' . $customer_id);
        } else {
            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('admin/vendor-details/' . $customer_id);
        }
    }

    public function reset_vendor_password() {
        $customer_id = (int) $this->input->post('vendor_id');

        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_rules('cpassword', '', 'trim|required');
        $this->form_validation->set_message('required', translate('required_message'));
        if ($this->form_validation->run() == false) {
            redirect('admin/vendor-details/' . $customer_id);
        } else {
            $new_password = $this->input->post('password');

            $get_result = $this->model_vendor->getData("app_admin", "*", "id='" . $customer_id . "'");
            if (count($get_result) > 0) {
                $update['password'] = md5($new_password);
                $this->model_vendor->update("app_admin", $update, "id='" . $customer_id . "'");

                $this->session->set_flashdata('msg', translate('reset_success'));
                $this->session->set_flashdata('msg_class', 'success');

                redirect('admin/vendor-details/' . $customer_id);
            } else {
                $this->session->set_flashdata('msg', translate('invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('admin/vendor-details/' . $customer_id);
            }
        }
    }

}

?>