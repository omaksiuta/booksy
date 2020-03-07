<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_report');
        set_time_zone();
    }

    //Show Vendor Report Page
    public function index() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        if ($month != '' || $year != '') {
            if ($month != '' && $year != '') {
                $condition = "MONTH(created_on) = '$month' AND YEAR(created_on) = '$year' AND type='V'";
            } elseif ($month != '') {
                $condition = "MONTH(created_on) = '$month' AND type='V'";
            } elseif ($year != '') {
                $condition = "MONTH(created_on) = MONTH(CURRENT_DATE()) AND YEAR(created_on) = '$year' AND type='V'";
            }
        } else {
            $condition = "MONTH(created_on) = (MONTH(CURRENT_DATE())) AND YEAR(created_on) AND type='V'";
            $month = date("m");
            $year = date("Y");
        }

        $data['month'] = $month;
        $data['year'] = $year;
        $monthly = $this->model_report->getData("app_admin", "DATE(created_on) as created_on,COUNT(created_on) AS total", $condition, "", "", "DATE(created_on)");
        $data['product_data'] = $monthly;
        $yeardata = $this->model_report->getData("app_admin", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['title'] = translate('vendor_report');
        $this->load->view('admin/report/vendor_report', $data);
    }

    //Show Customer Report Page
    public function customer_report() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        if ($month != '' || $year != '') {
            if ($month != '' && $year != '') {
                $condition = "MONTH(created_on) = '$month' AND YEAR(created_on) = '$year'";
            } elseif ($month != '') {
                $condition = "MONTH(created_on) = '$month'";
            } elseif ($year != '') {
                $condition = "MONTH(created_on) = MONTH(CURRENT_DATE()) AND YEAR(created_on) = '$year'";
            }
        } else {
            $condition = "MONTH(created_on) = (MONTH(CURRENT_DATE())) AND YEAR(created_on)";
            $month = date("m");
            $year = date("Y");
        }

        $data['month'] = $month;
        $data['year'] = $year;
        $monthly = $this->model_report->getData("app_customer", "DATE(created_on) as created_on,COUNT(created_on) AS total", $condition, "", "", "DATE(created_on)");
        $data['product_data'] = $monthly;
        $yeardata = $this->model_report->getData("app_customer", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['title'] = translate('customer_report');
        $this->load->view('admin/report/customer_report', $data);
    }

    //Show Appointment Report Page
    public function appointment_report() {
        if ($this->login_type == 'V') {
            $vendor_id = $this->login_id;
        } else {
            $vendor_id = $this->input->post('vendor_id');
        }
        $year = $this->input->post('year');

        $join = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_service_appointment.event_id=app_services.id',
                'jointype' => 'left'
            )
        );

        if ($vendor_id != '' || $year != '') {
            if ($vendor_id != '' && $year != '') {
                $condition = "app_services.created_by = '$vendor_id' AND YEAR(app_service_appointment.created_on) = '$year'";
            } elseif ($vendor_id != '') {
                $condition = "app_services.created_by   = '$vendor_id'";
            } elseif ($year != '') {
                $condition = "YEAR(app_service_appointment.created_on) = '$year'";
            }
        } else {
            $year = date("Y");
            $condition = "YEAR(app_service_appointment.created_on) = '$year'";
        }
        $data['login_type'] = $this->login_type;
        $data['vendor_id'] = $vendor_id;
        $data['year'] = $year;
        $monthly = $this->model_report->getData("app_service_appointment", "COUNT(app_service_appointment.id) AS total , MONTH(app_service_appointment.created_on) as month", $condition, $join, "", "MONTH(app_service_appointment.created_on),YEAR(app_service_appointment.created_on)");
        $data['product_data'] = $monthly;
        $data['vendor_list'] = $this->model_report->getData("app_admin", "*");
        $yeardata = $this->model_report->getData("app_service_appointment", "MIN(YEAR(created_on)) as min,MAX(YEAR(created_on)) as max");
        $data['year_data'] = $yeardata[0];
        $data['title'] = translate('appointment_report');
        $this->load->view('admin/report/appointment_report', $data);
    }

    public function event_booking() {
        $event = isset($_REQUEST['event']) ? $_REQUEST['event'] : "";
        $vendor = isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : "";
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : "";
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
        $customer = isset($_REQUEST['customer']) ? $_REQUEST['customer'] : 0;
        $month = isset($_REQUEST['month']) ? $_REQUEST['month'] : 0;
        $year = (isset($_REQUEST['year']) && $_REQUEST['year'] != "") ? $_REQUEST['year'] : date('Y');

        $cond = " app_service_appointment.event_id >0 AND app_service_appointment.type='E' ";

        $vendor_condition = "";
        if ($this->login_type == 'V') {
            $cond .= " AND app_services.created_by = $this->login_id";
            $vendor_condition .= "app_services.type='E' AND app_services.created_by=" . $this->login_id;
        } else {
            $cond .= '';
            $vendor_condition .= "app_services.type='E'";
        }

        if (isset($customer) && $customer > 0) {
            $cond .= " AND app_service_appointment.customer_id=" . $customer;
        }
        if (isset($year) && $year > 0) {
            $cond .= " AND YEAR(app_service_appointment.created_on)=" . $year;
        }
        if (isset($month) && $month > 0) {
            $cond .= " AND MONTH(app_service_appointment.created_on)=" . $month;
        }
        if (isset($event) && $event > 0) {
            $cond .= " AND app_service_appointment.event_id=" . $event;
        }

        if (isset($vendor) && $vendor > 0) {
            $cond .= " AND app_services.created_by=" . $vendor;
        }
        if (isset($city) && $city != "" && $city > 0) {
            $cond .= " AND app_services.city=" . $city;
        }

        if (isset($status) && $status != "") {
            $cond .= " AND app_service_appointment.status='" . $status . "'";
        }
        if (isset($type) && $type != "") {
            $cond .= " AND app_services.payment_type='" . $type . "'";
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

        $appointment = $this->model_report->getData('app_service_appointment', 'app_service_appointment.*,app_admin.company_name,app_customer.first_name,app_customer.last_name,app_services.title,app_services.created_by,app_services.payment_type', $cond, $join, 'app_service_appointment.id DESC');
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

        $appointment_event = $this->model_report->getData("app_service_appointment", "app_service_appointment.event_id,app_services.id as event_id,app_services.title as title", $vendor_condition, $join_one, "", "app_services.id");

        $appointment_vendor = $this->model_report->getData("app_service_appointment", "app_admin.company_name,app_admin.first_name,app_admin.last_name,app_admin.id", "", $join_two, "", "app_admin.id");

        $city_join = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_city.city_id=app_services.city',
                'jointype' => 'inner'
            )
        );
        $city_list = $this->model_report->getData('app_city', 'app_city.*', 'app_city.city_status="A"');
        $customer_list = $this->model_report->getData('app_customer', 'id,first_name,last_name', 'status="A"');
        $data['customer_list'] = $customer_list;

        $year_list = $this->db->query("SELECT DISTINCT(YEAR(`created_on`)) as year FROM `app_service_appointment` WHERE YEAR(`created_on`)>0 order by year")->result_array();
        $data['year_list'] = $year_list;


        $data['appointment_data'] = $appointment;
        $data['appointment_vendor'] = $appointment_vendor;
        $data['city_list'] = $city_list;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['appointment_event'] = $appointment_event;

        $data['title'] = translate('appointment_report');
        $this->load->view('admin/report/event_booking', $data);
    }

    public function service_appointment() {
        $event = isset($_REQUEST['event']) ? $_REQUEST['event'] : "";
        $vendor = isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : "";
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : "";
        $customer = isset($_REQUEST['customer']) ? $_REQUEST['customer'] : 0;
        $month = isset($_REQUEST['month']) ? $_REQUEST['month'] : 0;
        $year = (isset($_REQUEST['year']) && $_REQUEST['year'] != "") ? $_REQUEST['year'] : date('Y');

        $cond = " app_service_appointment.event_id >0 AND app_service_appointment.type='S' ";

        $vendor_condition = "";
        if ($this->login_type == 'V') {
            $cond .= " AND app_services.created_by = $this->login_id";
            $vendor_condition .= "app_services.type='S' AND app_services.created_by=" . $this->login_id;
        } else {
            $vendor_condition .= "app_services.type='S'";
            $cond .= '';
        }


        if (isset($event) && $event > 0) {
            $cond .= " AND app_service_appointment.event_id=" . $event;
        }

        if (isset($year) && $year > 0) {
            $cond .= " AND YEAR(app_service_appointment.created_on)=" . $year;
        }
        if (isset($month) && $month > 0) {
            $cond .= " AND MONTH(app_service_appointment.created_on)=" . $month;
        }

        if (isset($customer) && $customer > 0) {
            $cond .= " AND app_service_appointment.customer_id=" . $customer;
        }

        if (isset($city) && $city != "" && $city > 0) {
            $cond .= " AND app_services.city=" . $city;
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

        $appointment = $this->model_report->getData('app_service_appointment', 'app_service_appointment.*,app_admin.company_name,app_customer.first_name,app_customer.last_name,app_services.title,app_services.created_by,app_services.payment_type', $cond, $join, 'app_service_appointment.id DESC');
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

        $appointment_event = $this->model_report->getData("app_service_appointment", "app_service_appointment.event_id,app_services.id as event_id,app_services.title as title", $vendor_condition, $join_one, "", "app_services.id");

        $appointment_vendor = $this->model_report->getData("app_service_appointment", "app_admin.company_name,app_admin.first_name,app_admin.last_name,app_admin.id", "", $join_two, "", "app_admin.id");

        $city_join = array(
            array(
                'table' => 'app_services',
                'condition' => 'app_city.city_id=app_services.city',
                'jointype' => 'inner'
            )
        );
        $city_list = $this->model_report->getData('app_city', 'app_city.*', 'app_city.city_status="A"');
        $year_list = $this->db->query("SELECT DISTINCT(YEAR(`created_on`)) as year FROM `app_service_appointment` WHERE YEAR(`created_on`)>0 order by year ")->result_array();
        $data['year_list'] = $year_list;

        $data['appointment_data'] = $appointment;
        $data['appointment_vendor'] = $appointment_vendor;
        $data['city_list'] = $city_list;
        $data['month'] = $month;
        $data['year'] = $year;
        $data['appointment_event'] = $appointment_event;

        $customer_list = $this->model_report->getData('app_customer', 'id,first_name,last_name', 'status="A"');
        $data['customer_list'] = $customer_list;

        $data['title'] = translate('appointment_report');
        $this->load->view('admin/report/service_appointment', $data);
    }

    public function earnings_report() {
        $data['title'] = translate('earning') . " " . translate('report');
        $this->load->view('admin/report/earning_report', $data);
    }

}
