<?php

namespace App\Controllers;

/* 
//use your own models 
use app\models\ExampleModel as ExampleModel;
*/

class ApiController extends Controller{

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: token, Content-Type');
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            die();
        }
        header('Access-Control-Allow-Origin: *');
    }

    public function  list() {
        $post_data = $this->request_get_input_json();
        $result = ["status"=>true,'message'=>"Imported Successfully","data"=>$post_data];        
        $this->response_send_json($result);
    }
    

}