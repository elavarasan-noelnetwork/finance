<?php

namespace app\controllers\admin;


class Controller {

    protected function request_get_params(){
        return isset($_REQUEST) ? $_REQUEST : [];
    }

    protected function request_get_files(){
        return isset($_FILES) ? $_FILES : [];
    }    

    protected function request_get_input(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
        return file_get_contents('php://input');
      }else{
            "";
        }
    }   

    protected function request_get_input_json($isobj=false){
        return json_decode($this->request_get_input(),!$isobj);
    }   
    
    protected function response_send_json($data=[]){
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    

}
