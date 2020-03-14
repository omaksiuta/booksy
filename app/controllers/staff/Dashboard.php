<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_staff');
        $this->load->model('model_dashboard');
        set_time_zone();
    }

    //show staff dashboard
    public function index() {
        $staff_id = (int) $this->session->userdata('staff_id');
        $data['title'] = translate('dashboard');

        $data['completed_appointment'] = $this->db->query("SELECT COUNT(id) as completed_appointment FROM app_service_appointment WHERE staff_id=" . $staff_id . " AND status='C'")->row('completed_appointment');
        $data['pending_appointment'] = $this->db->query("SELECT COUNT(id) as completed_appointment FROM app_service_appointment WHERE staff_id=" . $staff_id . " AND status='A'")->row('completed_appointment');
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
        $cond = " app_services.type='S' AND app_service_appointment.status IN ('A') AND app_service_appointment.start_date >= '$current_date' AND app_service_appointment.start_date <= '$up_date' AND app_service_appointment.staff_id=" . $staff_id;
        $appointment = $this->model_dashboard->getData('app_service_appointment', 'app_service_appointment.*,app_customer.first_name,app_customer.last_name,app_services.title,app_services.payment_type,app_services.created_by', $cond, $join);


        $cond_pending = "app_service_appointment.status='P' AND app_services.type='S'  AND app_service_appointment.staff_id=" . $staff_id;
        $pending_appointment = $this->model_dashboard->getData('app_service_appointment', 'app_service_appointment.*,app_customer.first_name,app_customer.last_name,app_services.title,app_services.payment_type,app_services.created_by', $cond_pending, $join);
        $data['pending_appointment'] = $pending_appointment;

        $data['appointment_data'] = $appointment;
        $this->load->view('staff/dashboard', $data);
    }

    public function appointment() {
        $data['title'] = translate('appointment');

        $staff_id = (int) $this->session->userdata('staff_id');

        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
        $appointment_type = isset($_REQUEST['appointment_type']) ? $_REQUEST['appointment_type'] : "U";

        $cond = " app_service_appointment.service_id >0 AND app_service_appointment.type='S' AND app_service_appointment.payment_status!='IN'";

        $cond .= " AND app_service_appointment.staff_id=" . $staff_id;

        if (isset($status) && $status != "") {
            $cond .= " AND app_service_appointment.status='" . $status . "'";
        }
        if (isset($type) && $type != "") {
            $cond .= " AND app_services.payment_type='" . $type . "'";
        }
        $cur_date=date("Y-m-d");
        
        if(isset($appointment_type) && $appointment_type=='U'){
            $cond .= " AND app_service_appointment.start_date>='".$cur_date."' ";
        }else{
            $cond .= " AND app_service_appointment.start_date<'".$cur_date."'  ";
        }


        $join = array(
            array(
                "table" => "app_customer",
                "condition" => "app_customer.id=app_service_appointment.customer_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_services",
                "condition" => "app_services.id=app_service_appointment.service_id",
                "jointype" => "LEFT"),
            array(
                "table" => "app_admin",
                "condition" => "app_services.created_by=app_admin.id",
                "jointype" => "INNER")
        );

        $appointment = $this->model_dashboard->getData('app_service_appointment', 'app_service_appointment.*,app_admin.company_name,app_customer.first_name,app_customer.last_name,app_services.title,app_services.created_by,app_services.payment_type', $cond, $join,"app_service_appointment.start_date ASC,app_service_appointment.start_time ASC");
        $data['appointment_data'] = $appointment;

        $this->load->view('staff/appointment', $data);
    }

    public function send_remainder() {

        $id = $this->input->post('service_book_id', true);
        $staff_id = (int) $this->session->userdata('staff_id');
        if ((int) $id > 0) {
            $cond = "app_service_appointment.id = '$id'";
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

            $res = $this->model_dashboard->getData('app_service_appointment', 'app_service_appointment.*,app_customer.first_name,app_customer.last_name,app_customer.email, app_services.title,app_services.description, app_services.created_by', $cond, $join)[0];

            $service_data = get_full_service_service_data($res['service_id']);

            $service_title = $res['title'];
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
            
            $parameterv['price'] = translate('free');
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

    public function change_appointment($id, $status) {
        if ((int) $id > 0) {
            $this->model_dashboard->update('app_service_appointment', array('status' => strtoupper($status)), "id='$id'");
            $this->session->set_flashdata('msg', str_replace('{status}', print_appointment_status(strtoupper($status)), translate('appointment_status')));
            $this->session->set_flashdata('msg_class', 'success');
        }
        echo 'true';
        exit;
    }

    function view_booking_details($id) {
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
        $service_data = $this->model_dashboard->getData("app_service_appointment", "app_service_appointment.* ,app_service_appointment.price as final_price,app_services.title as service_title,app_location.loc_title,app_city.city_title,app_service_category.title as category_title,CONCAT(app_customer.first_name,' ',app_customer.last_name) as Customer_name,app_customer.phone as Customer_phone,app_customer.email as Customer_email,app_service_appointment.addons_id,app_services.price,app_admin.company_name,app_services.description as service_description, app_services.payment_type", $e_condition, $join);
        
        $data['service_data'] = $service_data;
        $this->load->view('staff/view_booking_details', $data);
    }

}

?>