<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page_content extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('model_city');
        set_time_zone();
    }

    //show home page
    public function index() {
        $app_faq = $this->model_city->getData('app_content', '*');
        $data['app_faq'] = $app_faq;
        $data['title'] = translate('manage') . " " . translate('content_management');
        $this->load->view('admin/master/manage_content', $data);
    }

    //show add content form
    public function add_content() {
        $data['title'] = translate('add') . " " . translate('content_management');
        $this->load->view('admin/master/add_update_content', $data);
    }

    //show edit content form
    public function update_content($id) {
        $cond = 'id=' . $id;
        $app_content = $this->model_city->getData("app_content", "*", $cond);
        if (isset($app_content[0]) && !empty($app_content[0])) {
            $data['content'] = $app_content[0];
            $data['title'] = translate('update') . " " . translate('content_management');
            $this->load->view('admin/master/add_update_content', $data);
        } else {
            show_404();
        }
    }

    //add/edit an content
    public function save_content() {
        $id = (int) $this->input->post('id', true);
        $this->form_validation->set_rules('title', 'title', 'trim|required|is_unique[app_content.title.id.' . $id . ']');
        $this->form_validation->set_rules('status', '', 'trim|required');
        $this->form_validation->set_message('required', translate('required_message'));
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == false) {
            if ($id > 0) {
                $this->update_content($id);
            } else {
                $this->add_content();
            }
        } else {

            $data['title'] = $this->input->post('title', true);
            $data['slug'] = convert_lang_string($this->input->post('title', true));
            $data['description'] = $this->input->post('description', true);
            $data['status'] = $this->input->post('status', true);

            if ($id > 0) {
                $this->model_city->update('app_content', $data, "id=$id");
                $this->session->set_flashdata('msg', translate('record_update'));
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_on'] = date("Y-m-d H:i:s");
                $this->model_city->insert('app_content', $data);
                $this->session->set_flashdata('msg', translate('record_insert'));
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect('admin/manage-content', 'redirect');
        }
    }

    //delete an service
    public function delete_content($id) {
        $this->model_city->delete('app_content', "id=" . $id);
        $this->session->set_flashdata('msg', translate('record_delete'));
        $this->session->set_flashdata('msg_class', 'success');
        echo "true";
        exit;
    }

    public function check_page_title() {
        $id = (int) $this->input->post('id', true);
        $title = $this->input->post('title');
        if (isset($id) && $id > 0) {
            $where = "title='$title' AND id!='$id'";
        } else {
            $where = "title='$title'";
        }
        $check_title = $this->model_city->getData("app_content", "title", $where);
        if (isset($check_title) && count($check_title) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

}

?>