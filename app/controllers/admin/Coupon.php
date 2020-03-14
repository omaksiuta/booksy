<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coupon extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_service');
        set_time_zone();
    }

    //show service page
    public function index() {
        $coupon_data = $this->model_service->getData('app_service_coupon', '*', "created_by=" . $this->login_id);
        $data['coupon_data'] = $coupon_data;
        $data['title'] = translate('manage') . " " . translate('coupon');
        $this->load->view('admin/coupon/manage_coupon', $data);
    }

    //show add service form
    public function add_coupon() {
        $data['service_data'] = $this->model_service->getData('app_services', '*', "status='A' AND created_by=" . $this->login_id);
        $data['title'] = translate('add') . " " . translate('coupon');
        $this->load->view('admin/coupon/add_update_coupon', $data);
    }

    //show edit service form
    public function update_coupon($id) {
        $coupon = $this->model_service->getData("app_service_coupon", "*", "id='$id'");
        if (isset($coupon[0]) && !empty($coupon[0])) {
            $data['coupon_data'] = $coupon[0];
            $data['service_data'] = $this->model_service->getData('app_services', '*', "status='A' AND created_by=" . $this->login_id);
            $data['title'] = translate('update') . " " . translate('coupon');
            $this->load->view('admin/coupon/add_update_coupon', $data);
        } else {
            show_404();
        }
    }

    //add/edit an service
    public function save_coupon() {
        $id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', '', 'required');
        $this->form_validation->set_rules('valid_till', '', 'required');
        $this->form_validation->set_rules('service_id[]', '', 'required');
        $this->form_validation->set_rules('code', '', 'required|is_unique[app_service_coupon.code.id.' . $id . ']');
        $this->form_validation->set_rules('discount_type', '', 'required');
        $this->form_validation->set_rules('discount_value', '', 'required');
        $this->form_validation->set_rules('status', '', 'required');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == false) {
            if ($id > 0) {
                $this->update_coupon($id);
            } else {
                $this->add_coupon();
            }
        } else {

            $data['title'] = $this->input->post('title', true);
            $data['valid_till'] = $this->input->post('valid_till', true);
            $data['service_id'] = json_encode($this->input->post('service_id[]', true));
            $data['code'] = $this->input->post('code', true);
            $data['discount_type'] = $this->input->post('discount_type', true);
            $data['discount_value'] = $this->input->post('discount_value', true);
            $data['status'] = $this->input->post('status', true);

            if ($id > 0) {
                $id = $this->model_service->update('app_service_coupon', $data, "id=$id");
                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_by'] = $this->login_id;
                $data['created_date'] = date('Y-m-d H:i:s');
                $id = $this->model_service->insert('app_service_coupon', $data);
                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            $folder_url = isset($this->login_type) && $this->login_type == 'V' ? 'vendor' : 'admin';
            redirect($folder_url . '/manage-coupon', 'redirect');
        }
    }

    //delete an service
    public function delete_coupon($id) {
        $this->model_service->delete('app_service_coupon', 'id=' . $id . " AND created_by=" . $this->login_id);
        $this->session->set_flashdata('msg', translate('record_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        echo 'true';
        exit;
    }

}

?>