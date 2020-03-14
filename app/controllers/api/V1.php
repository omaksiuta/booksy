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
        $select_string="app_services.id,app_services.category_id,app_services.staff,app_services.title,app_services.slug,app_services.description,app_services.total_seat,app_services.days,app_services.start_time,";
        $select_string.="app_services.end_time,app_services.padding_time,app_services.slot_time,app_services.monthly_allow,app_services.multiple_slotbooking_allow,app_services.multiple_slotbooking_limit,";
        $select_string.="app_services.city,app_services.location,app_services.is_display_address,app_services.address,app_services.address_map_link,app_services.image,app_services.thumb_image,app_services.payment_type,app_services.price,";
        $select_string.="app_services.discount,app_services.discounted_price,app_services.from_date,app_services.to_date,app_services.status,app_services.faq,app_service_category.title as category_name,";
        $select_string.="app_city.city_title as city_name,app_location.loc_title as location_name,app_admin.company_name,app_admin.first_name,app_admin.last_name,";
        $select_string.="app_admin.profile_image";


        $join = array(
            array(
                'table' => 'app_service_category',
                'condition' => 'app_service_category.id=app_services.category_id',
                'jointype' => 'INNER'
            ),
            array(
                'table' => 'app_admin',
                'condition' => 'app_admin.id=app_services.created_by',
                'jointype' => 'INNER'
            ),
            array(
                'table' => 'app_city',
                'condition' => 'app_city.city_id=app_services.city',
                'jointype' => 'INNER'
            ),
            array(
                'table' => 'app_location',
                'condition' => 'app_location.loc_id=app_services.location',
                'jointype' => 'INNER'
            ),
        );


        $app_service= $this->model_admin->getData("app_services",$select_string,'app_services.status="A"',$join,'title ASC');
        if(isset($app_service) && count($app_service)>0){

            $app_service_data=array();
            foreach ($app_service as $service){
                $service_arr=array();

                $service_arr['service_id']=$service['id'];
                $service_arr['title']=$service['title'];
                $service_arr['description']=$service['description'];
                $service_arr['slug']=$service['slug'];
                $service_arr['category_name']=$service['category_name'];
                $service_arr['category_name']=$service['category_name'];
                $service_arr['category_id']=$service['category_id'];
                $service_arr['city_name']=$service['city_name'];
                $service_arr['location_name']=$service['location_name'];
                $service_arr['is_display_address']=$service['is_display_address'];
                $service_arr['address']=$service['address'];
                $service_arr['service_image']=json_decode($service['image']);
                $service_arr['address_map_link']=$service['address_map_link'];
                $service_arr['status']=$service['status'];

                $service_arr['payment_type']=$service['payment_type'];
                $service_arr['price']=$service['price'];
                $service_arr['total_seat']=$service['total_seat'];
                $service_arr['days']=$service['days'];
                $service_arr['start_time']=$service['start_time'];
                $service_arr['end_time']=$service['end_time'];

                $service_arr['padding_time']=$service['padding_time'];
                $service_arr['slot_time']=$service['slot_time'];
                $service_arr['multiple_slotbooking_allow']=$service['multiple_slotbooking_allow'];
                $service_arr['multiple_slotbooking_limit']=$service['multiple_slotbooking_limit'];

                $service_arr['discount']=$service['discount'];
                $service_arr['discounted_price']=$service['discounted_price'];
                $service_arr['from_date']=$service['from_date'];
                $service_arr['to_date']=$service['to_date'];

                //Service Created By
                $service_arr['company_name']=$service['company_name'];
                $service_arr['created_by_first_name']=$service['first_name'];
                $service_arr['created_by_last_name']=$service['last_name'];
                $service_arr['company_logo']=$service['profile_image'];

                //Find staff details
                if(isset($service['staff']) && $service['staff']!="" && $service['staff']!=NULL){
                    $staff_array=$this->db->query("SELECT id as staff_id,profile_image,first_name,last_name,email,designation FROM app_admin WHERE id IN(".$service['staff'].")")->result_array();
                    $service_arr['staff']=$staff_array;
                }

                array_push($app_service_data,$service_arr);
            }

            $this->response([
                'data'=>$app_service_data,
                'image_path'=>base_url('assets/upload/'),
                'status' =>true,
                'message' => 'success'
            ], 200 );
        }else{
            $this->response([
                'status' => false,
                'message' =>translate('no_record_found')
            ], 200 );
        }


    }
}
