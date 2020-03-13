<?php
require FCPATH.'vendor/autoload.php';
use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;

require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

class V1 extends RestController {

    private $user_credential;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('model_admin');
        //$this->auth();
    }


    public function auth()
    {
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        //JWT Auth middleware
        $headers = $this->input->get_request_header('Authorization');
        $kunci = $this->config->item('thekey'); //secret key for encode and decode
        $token= "token";
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
                $token = $matches[1];
            }
        }

        try {
            $decoded = JWT::decode($token, $kunci, array('HS256'));
            $this->user_data = $decoded;
        } catch (Exception $e) {
            $invalid = ['status' =>"Invalid token"]; //Respon if credential invalid
            $this->response($invalid, 401);//401
        }
    }

    public function service_category_get()
    {
        $select_string="id as category_id,title,category_slug,category_image";
        $app_service_category = $this->model_admin->getData("app_service_category",$select_string,'status="A"','','title ASC');

        if(isset($app_service_category) && count($app_service_category)>0){
            $this->response([
                'data'=>$app_service_category,
                'image_path'=>base_url('assets/upload/'),
                'status' =>true,
                'message' => 'success'
            ], 200 );
        }else{
            $this->response([
                'status' => false,
                'message' => 'No record found'
            ], 200 );
        }


    }

    public function service_get()
    {
        $select_string="`id`, `category_id`, `staff`,`title`, `slug`, `description`, `total_seat`,  `days`, `start_time`,";
        $select_string.="`end_time`, `padding_time`, `slot_time`, `monthly_allow`, `multiple_slotbooking_allow`, `multiple_slotbooking_limit`,";
        $select_string.="`city`, `location`, `is_display_address`, `address`, `address_map_link`, `latitude`, `longitude`, `image`, `thumb_image`, `payment_type`, `price`,";
        $select_string.="`discount`, `discounted_price`, `from_date`, `to_date`, `status`,`faq`";

        $app_service= $this->model_admin->getData("app_services",$select_string,'status="A"','','title ASC');

        if(isset($app_service) && count($app_service)>0){
            $this->response([
                'data'=>$app_service,
                'image_path'=>base_url('assets/upload/'),
                'status' =>true,
                'message' => 'success'
            ], 200 );
        }else{
            $this->response([
                'status' => false,
                'message' => 'No record found'
            ], 200 );
        }


    }
}
