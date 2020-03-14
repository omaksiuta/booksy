<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_customer');
        set_time_zone();
    }

    //show customer list
    public function index() {
        $data['title'] = translate('manage') . " " . translate('customer');
        $order = "created_on DESC";
        $customer = $this->model_customer->getData("app_customer", "*", "", "", $order);
        $data['customer_data'] = $customer;
        $this->load->view('admin/customer/manage_customer', $data);
    }

    //delete customer
    public function delete_customer($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $customer_check = $this->model_customer->getData("app_service_appointment", "*", "customer_id=" . $id);
        if (isset($customer_check) && count($customer_check) > 0) {
            $this->session->set_flashdata('msg', translate('customer_booked_no_delete'));
            $this->session->set_flashdata('msg_class', 'failure');
            echo 'false';
            exit;
        } else {
            $this->model_customer->delete('app_customer', 'id=' . $id);
            $this->session->set_flashdata('msg', translate('record_delete'));
            $this->session->set_flashdata('msg_class', 'success');
            echo 'true';
            exit;
        }
    }

    //change status of customer
    public function change_customer_tatus($id = null) {
        if ($id == null) {
            $id = $this->uri->segment(2);
        }
        $status = $this->input->post('status', true);
        $update = array(
            'status' => $status
        );
        $this->model_customer->update('app_customer', $update, 'id=' . $id);
        $msg = isset($status) && $status == "A" ? "Active" : "Inactive";
        $this->session->set_flashdata('msg', translate('customer_status'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

    public function add_customer() {
        $data['title'] = translate('add_customer');
        $this->load->view('admin/customer/add_update_customer', $data);
    }

    public function update_customer($id) {
        $cond = 'id=' . $id;

        $customer = $this->model_customer->getData("app_customer", "*", $cond);
        if (isset($customer[0]) && !empty($customer[0])) {
            $data['customer_data'] = $customer[0];
            $data['title'] = translate('update') . " " . translate('customer');
            $this->load->view('admin/customer/add_update_customer', $data);
        } else {
            redirect('admin/customer');
        }
    }

    public function send_forgot_password_link() {
        $customer_id = $this->input->post("cust_id", true);
        $email = $this->input->post("email", true);

        $rply = $this->model_customer->check_username($email);
        $this->load->helper('string');

        if ($rply['errorCode'] == 1) {
            $customer_full_name = ($rply['Firstname']) . " " . ($rply['Lastname']);

            $define_param['to_name'] = $customer_full_name;
            $define_param['to_email'] = $rply['Email'];
            $userid = $rply['ID'];
            $hidenuseremail = $rply['Email'];
            $hidenusername = $customer_full_name;
            //Encryprt data
            $encid = $this->general->encryptData($userid);
            $encemail = $this->general->encryptData($hidenuseremail);
            $url = base_url("reset-password/" . $encid . "/" . $encemail);

            $update['reset_password_check'] = 0;
            $update['reset_password_requested_on'] = date("Y-m-d H:i:S");
            $result = $this->model_customer->update("app_customer", $update, "id='" . $userid . "'");

            //Send email
            $subject = translate('reset_password');
            $define_param['to_name'] = $hidenusername;
            $define_param['to_email'] = $hidenuseremail;

            $parameter['URL'] = $url;
            $html = $this->load->view("email_template/forgot_password", $parameter, true);
            $this->sendmail->send($define_param, $subject, $html);

            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'success');
            redirect('admin/customer-details/' . $customer_id);
        } else {
            $this->session->set_flashdata('msg', $rply['errorMessage']);
            $this->session->set_flashdata('msg_class', 'failure');
            redirect('admin/customer-details/' . $customer_id);
        }
    }

    public function reset_customer_password() {
        $customer_id = (int) $this->input->post('customer_id');

        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_rules('cpassword', '', 'trim|required');
        $this->form_validation->set_message('required', translate('required_message'));
        if ($this->form_validation->run() == false) {
            redirect('admin/customer-details/' . $customer_id);
        } else {
            $new_password = $this->input->post('password');

            $get_result = $this->model_customer->getData("app_customer", "*", "id='" . $customer_id . "'");
            if (count($get_result) > 0) {
                $update['password'] = md5($new_password);
                $this->model_customer->update("app_customer", $update, "id='" . $customer_id . "'");

                $this->session->set_flashdata('msg', translate('reset_success'));
                $this->session->set_flashdata('msg_class', 'success');

                redirect('admin/customer-details/' . $customer_id);
            } else {
                $this->session->set_flashdata('msg', translate('invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('admin/customer-details/' . $customer_id);
            }
        }
    }

    public function customer_details($id) {
        $cond = 'id=' . $id;

        $customer = $this->model_customer->getData("app_customer", "*", $cond);
        if (isset($customer[0]) && !empty($customer[0])) {
            $data['customer_data'] = $customer[0];

            $data['title'] = translate('update') . " " . translate('customer');




            $join = array(
                array(
                    'table' => 'app_services',
                    'condition' => 'app_services.id=app_service_appointment.service_id',
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

            $s_condition = "app_service_appointment.customer_id=" . $id;
            $appointment = $this->model_customer->getData("app_service_appointment", "app_service_appointment.*,app_admin.id as aid ,app_service_appointment.price as final_price,app_admin.company_name,app_services.title,app_location.loc_title,app_city.city_title,app_service_category.title as category_title,app_customer.first_name,app_customer.last_name,app_customer.phone,app_services.price,app_admin.first_name,app_admin.last_name,app_admin.company_name,app_services.image,app_services.description as service_description, app_services.payment_type", $s_condition, $join);
            $data['service_appointment_data'] = $appointment;
            $this->load->view('admin/customer/customer_details', $data);
        } else {
            redirect('admin/customer');
        }
    }

    public function save_customer() {
        $hidden_image = $this->input->post('hidden_image');
        $user_id = (int) $this->input->post('customer_id');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[app_customer.email.id.' . $user_id . ']');
        $this->form_validation->set_rules('phone', 'Phone', 'is_unique[app_admin.phone.id.' . $user_id . ']');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($user_id > 0) {
                $this->update_customer($user_id);
            } else {
                $this->add_customer();
            }
        } else {
            $this->load->helper('string');
            $password = random_string('alnum', 8);
            $birth_date = "";
            $birth_date_val = $this->input->post('birth_date');
            if (isset($birth_date_val) && $birth_date_val != "" && $birth_date_val != NULL) {
                $birth_date = $birth_date_val;
            }

            $data = array(
                'first_name' => trim($this->input->post('first_name')),
                'last_name' => trim($this->input->post('last_name')),
                'email' => trim($this->input->post('email')),
                'birth_date' => $birth_date,
                'address' => trim($this->input->post('address')),
                'city' => trim($this->input->post('city')),
                'state' => trim($this->input->post('state')),
                'country' => trim($this->input->post('country')),
                'phone' => $this->input->post('phone'),
                'status' => trim($this->input->post('status')),
            );

            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {
                $uploadPath = uploads_path . '/';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");
                $data['profile_image'] = $newfilename;

                if (isset($hidden_image) && $hidden_image != "") {
                    @unlink(FCPATH . uploads_path . '/' . $hidden_image);
                }
            }

            if ($user_id > 0) {
                $this->model_customer->update('app_customer', $data, 'id=' . $user_id);
                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_on'] = date("Y-m-d H:i:s");
                $data['password'] = md5(trim($password));
                $name = (trim($this->input->post('first_name'))) . " " . (trim($this->input->post('last_name')));
                $hidenuseremail = $this->input->post('email');
                $this->model_customer->insert('app_customer', $data);

                //Send email to customer
                $subject = translate('customer') . " | " . translate('account_registration');
                $define_param['to_name'] = $name;
                $define_param['to_email'] = $hidenuseremail;

                $parameter['NAME'] = $name;
                $parameter['LOGIN_URL'] = base_url('login');
                $parameter['EMAIL'] = $hidenuseremail;
                $parameter['PASSWORD'] = $password;

                $html = $this->load->view("email_template/registration_admin", $parameter, true);
                $send = $this->sendmail->send($define_param, $subject, $html);

                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/customer', 'redirect');
        }
    }

    function view_service_booking_details($id) {
        $data['title'] = translate('view') . " " . ('booking');
        $join = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_services.id=app_service_appointment.service_id',
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
        $service_data = $this->model_customer->getData("app_service_appointment", "app_service_appointment.* ,app_service_appointment.price as final_price,app_services.title as service_title,app_location.loc_title,app_city.city_title,app_service_category.title as category_title,CONCAT(app_customer.first_name,' ',app_customer.last_name) as Customer_name,app_customer.phone as Customer_phone,app_customer.email as Customer_email,app_services.price,app_admin.company_name,app_services.description as service_description, app_services.payment_type", $e_condition, $join);
        $data['service_data'] = $service_data;
        $this->load->view('admin/customer/view_booking_details', $data);
    }

}

?>