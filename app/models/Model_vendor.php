<?php

class Model_vendor extends CI_Model {

    private $primary_key;
    private $main_table;
    public $errorCode;
    public $errorMessage;

    public function __construct() {
        parent::__construct();
        $this->main_table = "app_admin";
        $this->primary_key = "id";
    }

    function get_vendor_payment_list($login_id) {
        $this->db->select('app_service_appointment_payment.id,app_service_appointment_payment.payment_method,app_service_appointment_payment.transfer_status,app_service_appointment_payment.created_on,app_services.title,app_services.price,app_service_category.title as category_title,app_customer.first_name,app_customer.last_name,app_admin.first_name as cre_first_name,app_admin.last_name as cre_last_name');
        $this->db->join('app_customer', 'app_customer.id=app_service_appointment_payment.customer_id', 'left');
        $this->db->join('app_services', 'app_services.id=app_service_appointment_payment.event_id', 'left');
        $this->db->join('app_service_category', 'app_service_category.id=app_services.id', 'left');
        $this->db->join('app_admin', 'app_admin.id=app_services.created_by', 'left');
        $this->db->where("app_service_appointment_payment.vendor_id !='$login_id'");
        $res = $this->db->get('app_service_appointment_payment')->result_array();
        return $res;
    }

    public function authenticate($username, $password) {
        $ext = 'password = "' . md5($password) . '" AND  email = ' . $username . ' AND type="V"';
        $this->db->select('*');
        $this->db->from($this->main_table);
        $this->db->where($ext);
        $result = $this->db->get();
        $record = $result->result_array();
        if (is_array($record) && count($record) > 0) {
            if (isset($record) && $record[0]['status'] == 'A') {
                $this->session->set_userdata("Vendor_ID", $record[0]["id"]);
                $this->session->set_userdata("Type_Vendor", $record[0]["type"]);
                $this->session->set_userdata("DefaultPassword", $record[0]["default_password_changed"]);
                $this->errorCode = 1;
            } else if (isset($record) && $record[0]['status'] == 'P') {
                $this->errorCode = 0;

                $messages = translate('vendor_not_verify') . "<br/><a href=" . base_url('vendor-verify-resend/' . $record[0]["id"]) . ">" . translate('resend_verification_link') . "</a>";
                $this->errorMessage = $messages;
            } else {
                $this->errorCode = 0;
                $this->errorMessage = translate('login_failure');
            }
        } else {
            $this->errorCode = 0;
            $this->errorMessage = translate('login_failure');
        }
        $error['errorCode'] = $this->errorCode;
        $error['errorMessage'] = $this->errorMessage;
        return $error;
    }

    function check_username($username) {
        $this->db->where('email', $username);
        $this->db->where('type', 'V');
        $this->db->from($this->main_table);
        $list_data = $this->db->get()->row_array();
        if (is_array($list_data) && count($list_data) > 0) {
            $this->errorCode = 1;
            $this->errorMessage = translate('forgot_success');
        } else {
            $this->errorCode = 0;
            $this->errorMessage = translate('forgot_failure');
        }
        $error['id'] = $list_data['id'];
        $error['first_name'] = $list_data['first_name'];
        $error['last_name'] = $list_data['last_name'];
        $error['email'] = $list_data['email'];
        $error['errorCode'] = $this->errorCode;
        $error['errorMessage'] = $this->errorMessage;
        return $error;
    }

    function insert($tbl = '', $data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }

        $this->db->insert($tbl, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($tbl = '', $data = array(), $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where, false, false);
        $res = $this->db->update($tbl, $data);
        $rs = $this->db->affected_rows();
        return $rs;
    }

    function updateBatch($tbl = '', $data = array()) {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where();
        $res = $this->db->update_batch($tbl, $data);
        $rs = $this->db->affected_rows();
        return $rs;
    }

    function getData($tbl = '', $fields, $condition = '', $join_ary = array(), $orderby = '', $groupby = '', $having = '', $climit = '', $paging_array = array(), $reply_msgs = '', $like = array()) {

        if ($fields == '') {
            $fields = "*";
        }

        $this->db->select($fields, false);

        if (is_array($join_ary) && count($join_ary) > 0) {
            foreach ($join_ary as $ky => $vl) {
                $this->db->join($vl['table'], $vl['condition'], $vl['jointype']);
            }
        }

        if (trim($condition) != '') {
            $this->db->where($condition, false, false);
        }
        if (trim($groupby) != '') {
            $this->db->group_by($groupby);
        }
        if (trim($having) != '') {
            $this->db->having($having, false);
        }
        if ($orderby != '' && is_array($paging_array) && count($paging_array) == "0") {
            $this->db->order_by($orderby, false);
        }
        if (trim($climit) != '') {
            $this->db->limit($climit);
        }
        if ($tbl != '') {
            $this->db->from($tbl);
        } else {
            $this->db->from($this->main_table);
        }
        $list_data = $this->db->get()->result_array();
        return $list_data;
    }

    function delete($tbl = '', $where = '') {
        if ($tbl == '') {
            $tbl = $this->main_table;
        }
        $this->db->where($where);
        $this->db->delete($tbl);
        return 'deleted';
    }

}

?>