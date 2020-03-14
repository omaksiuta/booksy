<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        run_default_query();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_dashboard');
        set_time_zone();
    }

    //show admin dashboard
    public function index() {

        check_mandatory();
        $admin_id = (int) $this->session->userdata('ADMIN_ID');
        $data['total_vendor'] = $this->model_dashboard->Totalcount('app_admin', "type='V'");
        $data['total_payout_request'] = $this->model_dashboard->Totalcount('app_payment_request', "status!='S'");
        $data['total_customer'] = $this->model_dashboard->Totalcount('app_customer');
        $data['total_service'] = $this->model_dashboard->Totalcount('app_services');
        $data['total_appointment'] = $this->model_dashboard->Totalcount('app_service_appointment', 'type="S" AND status="A"');
        $data['total_my_wallet'] = $this->model_dashboard->total_my_wallet($this->login_id);

        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_service_appointment.customer_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_services",
                "condition" => "app_services.id=app_service_appointment.service_id",
                "jointype" => "LEFT")
        );
        $current_date = date('Y-m-d');
        $up_date = date('Y-m-d', strtotime(date('Y-m-d') . ' + 10 days'));
        $current_time = date('H:i:s');
        $cond = "app_service_appointment.status='A' AND app_service_appointment.start_date >= '$current_date' AND app_service_appointment.start_date <= '$up_date' AND app_services.created_by='$this->login_id'";

        $appointment = $this->model_dashboard->getData('app_service_appointment', 'app_service_appointment.*,app_customer.first_name,app_customer.last_name,app_services.title,app_services.payment_type,app_services.created_by', $cond, $join);
        $cond_pending = "app_service_appointment.status='P' AND app_service_appointment.start_date >= '$current_date' AND app_services.created_by=" . $this->login_id;

        $pending_appointment = $this->model_dashboard->getData('app_service_appointment', 'app_service_appointment.*,app_customer.first_name,app_customer.last_name,app_services.title,app_services.payment_type,app_services.created_by', $cond_pending, $join);
        $data['appointment_data'] = $appointment;
        $data['pending_appointment'] = $pending_appointment;

        //Get list of unverified vendor
        $unverified_vendor = $this->model_dashboard->getData('app_admin', '*', 'profile_status="N" AND type="V"');

        //Check expire package
        if (get_site_setting('enable_membership') == 'Y'):
            $condition_membership = " status='A' AND type='V' AND membership_till >= '$current_date' AND membership_till <= '$up_date'";
            $membership_vendor = $this->model_dashboard->getData('app_admin', 'id,status,company_name,first_name,last_name,email,package_id,membership_till', $condition_membership);
            $data['membership_vendor'] = $membership_vendor;
        endif;

        $data['unverified_vendor'] = $unverified_vendor;
        $data['title'] = translate('dashboard');
        $this->load->view('admin/dashboard', $data);
    }

    public function send_membership_reminder() {
        $vendor_id_hd = (int) $this->input->post('vendor_id_hd');
        $vendor_data = get_VendorDetails($vendor_id_hd);

        $first_name = $vendor_data['first_name'];
        $last_name = $vendor_data['last_name'];
        $email = $vendor_data['email'];
        $package_id = $vendor_data['package_id'];
        $membership_till = get_formated_date($vendor_data['membership_till'], 'N');

        //Send email
        $subject = translate('membership') . " " . translate('reminder');
        $define_param['to_name'] = $first_name . " " . $last_name;
        $define_param['to_email'] = $email;

        $parameter['membership_till'] = $membership_till;
        $parameter['name'] = $first_name . " " . $last_name;
        $html = $this->load->view("email_template/membership_reminder", $parameter, true);
        $this->sendmail->send($define_param, $subject, $html);
        $this->session->set_flashdata('msg', translate('remainder_mail_success'));
        $this->session->set_flashdata('msg_class', 'success');
        redirect('admin/dashboard');
    }

    //show mandatory update
    public function mandatory_update() {
        $data['total_service_category'] = $this->model_dashboard->Totalcount('app_service_category');
        $data['total_location'] = $this->model_dashboard->Totalcount('app_location');
        $data['total_city'] = $this->model_dashboard->Totalcount('app_city');
        $data['total_payment'] = $this->model_dashboard->check_payment();
        $data['title'] = translate('mandatory_update');
        $this->load->view('admin/setting/mandatory-update', $data);
    }



    public function payment_status_update($id) {
        if ($id) {
            $payment_data = $this->model_dashboard->getData("app_service_appointment_payment", '*', "id=" . $id . " AND payment_status!='S'");
            if (count($payment_data) > 0) {


                $data['payment_status'] = "S";
                $this->model_dashboard->update('app_service_appointment_payment', $data, "id=$id");

                //update service status
                $data_service['payment_status'] = "S";
                $this->model_dashboard->update('app_service_appointment', $data_service, "id=" . $payment_data[0]['booking_id']);

                $vendor_amount = $payment_data[0]['vendor_price'];
                $admin_amount = $payment_data[0]['admin_price'];

                $up_qry_vendor = $this->db->query("UPDATE app_admin SET my_earning=my_earning+" . $vendor_amount . ",my_wallet=my_wallet+" . $vendor_amount . " WHERE id=" . $payment_data[0]['vendor_id']);
                $up_qry_admin = $this->db->query("UPDATE app_admin SET my_wallet=my_wallet+" . $admin_amount . " WHERE id=1");

                $this->session->set_flashdata('msg', translate('status_update'));
                $this->session->set_flashdata('msg_class', 'success');
                echo true;
                exit(0);
            } else {
                $this->session->set_flashdata('msg', translate('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                echo FALSE;
                exit(0);
            }
        } else {
            $this->session->set_flashdata('msg', translate('Invalid_request'));
            $this->session->set_flashdata('msg_class', 'failure');
            echo FALSE;
            exit(0);
        }
    }

    public function payment_update($id) {
        if ($id) {
            $payment_data = $this->model_dashboard->getData("app_payment_request", '*', "id=" . $id . " AND status!='S'");
            if (count($payment_data) > 0) {

                $payment_data = $payment_data[0];
                if (isset($payment_data['id']) && $payment_data['id'] > 0) {
                    $payment_data = $this->model_dashboard->getData("app_admin", 'first_name,last_name,email', "id=" . $payment_data['vendor_id']);

                    $first_name = isset($payment_data[0]['first_name']) ? $payment_data[0]['first_name'] : "";
                    $last_name = isset($payment_data[0]['last_name']) ? $payment_data[0]['last_name'] : "";
                    $email = isset($payment_data[0]['email']) ? $payment_data[0]['email'] : "";

                    $data['other_charge'] = $this->input->post('other_charge', true);
                    $data['updated_amount'] = $this->input->post('updated_amount', true);
                    $data['payment_gateway_fee'] = $this->input->post('payment_gateway_fee', true);
                    $data['status'] = 'S';
                    $data['reference_no'] = $this->input->post('reference_no', true);
                    $data['processed_date'] = date('Y-m-d H:i:s');
                    $this->model_dashboard->update('app_payment_request', $data, "id=$id");

                    $this->session->set_flashdata('msg', translate('payout_process'));
                    $this->session->set_flashdata('msg_class', 'success');

                    // Header
                    $subject = get_CompanyName() . " | " . translate('payout_request');
                    if (isset($email) && $email != "" && $email != NULL) {
                        $define_param2['to_name'] = $first_name . " " . $last_name;
                        $define_param2['to_email'] = translate('payout_success_from_admin');

                        $parameters['name'] = $first_name . " " . $last_name;
                        $parameters['content_data'] = $email;
                        $html2 = $this->load->view("email_template/comman", $parameters, true);
                        $send = $this->sendmail->send($define_param2, $subject, $html2);
                    }
                    echo true;
                } else {
                    $this->session->set_flashdata('msg', translate('Invalid_request'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    echo FALSE;
                }
            } else {
                $this->session->set_flashdata('msg', translate('Invalid_request'));
                $this->session->set_flashdata('msg_class', 'failure');
                echo FALSE;
            }
        }
    }


}
