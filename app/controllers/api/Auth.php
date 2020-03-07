<?php
require FCPATH.'vendor/autoload.php';
use \Firebase\JWT\JWT;
use chriskacerguis\RestServer\RestController;
class Auth extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('model_front');
    }

    public function service_category_get()
    {
        $id = $this->get( 'id' );
        $app_service_category = $this->model_front->getData('app_service_category', 'id as category_id,title,category_slug,status,type','type="S" AND status="A"');

        if (isset($app_service_category) && count($app_service_category)>0){
            $this->response( $app_service_category, 200 );
        }else{
            $this->response( [
                'status' => false,
                'message' => 'No record found'
            ], 404 );
        }
    }

    public function login_get(){
        $kunci =$this->config->item('thekey');
        $token['id'] = 1;  //From here
        $token['username'] ="nitin";
        $date = new DateTime();
        $token['iat'] = $date->getTimestamp();
        $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
        $output['token'] = JWT::encode($token,$kunci ); //This is the output token
        $this->set_response($output, RestController::HTTP_OK); //This is the respon if success
    }
    public function test_post(){
        echo "s";
    }
}
