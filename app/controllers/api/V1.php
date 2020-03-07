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
        $this->auth();
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

    public function test_post()
    {
        $theCredential = $this->user_data;
        $this->response($theCredential, 200); // OK (200) being the HTTP response code
    }
}
