<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends MY_Controller {

    public function __construct() {
        parent::__construct();
        run_default_query();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->model('model_dashboard');
        set_time_zone();
    }

    public function contact_us() {
        $app_contact_us = $this->model_dashboard->getData("app_contact_us", '*', "event_id=0", "", "id DESC");
        $data['title'] = translate('contact-us-request');
        $data['app_contact_us'] = $app_contact_us;
        $this->load->view('admin/contact_us', $data);
    }

    public function event_inquiry() {

        $fields = "app_contact_us.*,CONCAT(app_admin.first_name,' ',app_admin.last_name) as vendor_name,app_services.title as event_name";
        $join = array(
            array(
                "table" => "app_admin",
                "condition" => "app_admin.id=app_contact_us.admin_id",
                "jointype" => "INNER"),
            array(
                "table" => "app_services",
                "condition" => "app_services.id=app_contact_us.event_id",
                "jointype" => "INNER")
        );
        $app_contact_us = $this->model_dashboard->getData("app_contact_us", $fields, "", $join, "id DESC");
        $data['title'] = translate('event_inquiry');
        $data['app_contact_us'] = $app_contact_us;
        $this->load->view('admin/event/event_inquiry', $data);
    }

    public function send_reply() {
        $reply_name = isset($_POST['reply_name']) ? $_POST['reply_name'] : "";
        $record_id = isset($_POST['record_id']) ? $_POST['record_id'] : "";
        $reply_email = isset($_POST['reply_email']) ? $_POST['reply_email'] : "";
        $reply_subject = isset($_POST['reply_subject']) ? $_POST['reply_subject'] : "";
        $reply_text = isset($_POST['reply_text']) ? $_POST['reply_text'] : "";
        if (isset($reply_email) && $reply_email != "" && $reply_email != NULL) {
            $define_param['to_name'] = $reply_name;
            $define_param['to_email'] = $reply_email;

            $parameters['name'] = $reply_name;
            $parameters['content_data'] = $reply_text;
            $html2 = $this->load->view("email_template/comman", $parameters, true);
            $send = $this->sendmail->send($define_param, $reply_subject, $html2);


            $this->session->set_flashdata('msg', translate('reply_send_success'));
            $this->session->set_flashdata('msg_class', 'success');
        }
        redirect(base_url('admin/contact-us'));
    }

    public function send_event_inquiry_reply() {
        $reply_name = isset($_POST['reply_name']) ? $_POST['reply_name'] : "";
        $record_id = isset($_POST['record_id']) ? $_POST['record_id'] : "";
        $reply_email = isset($_POST['reply_email']) ? $_POST['reply_email'] : "";
        $reply_subject = isset($_POST['reply_subject']) ? $_POST['reply_subject'] : "";
        $reply_text = isset($_POST['reply_text']) ? $_POST['reply_text'] : "";

        //Send email
        if (isset($reply_email) && $reply_email != "" && $reply_email != NULL) {
            $define_param['to_name'] = $reply_name;
            $define_param['to_email'] = $reply_email;

            $parameters['name'] = $reply_name;
            $parameters['content_data'] = $reply_text;
            $html2 = $this->load->view("email_template/comman", $parameters, true);
            $send = $this->sendmail->send($define_param, $reply_subject, $html2);

            $this->session->set_flashdata('msg', translate('reply_send_success'));
            $this->session->set_flashdata('msg_class', 'success');
        }
        redirect(base_url('admin/event-inquiry'));
    }
}