<?php

namespace app\controllers;

/* 
//use your own models 
use app\models\ExampleModel as ExampleModel;
*/
use core\View as View;

/*
To use the composer libraries
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
*/

class ApplicationController extends Controller{

    /*
    //To use the Model Objects
    protected $model_object;
    */
 
   public function __construct(){
    /*
    //Initialize the example model
    $this->model_object = new ExampleModel();
    */
   }

   public function home($route){
      /*
      $page_data = ["app_name"=>"php-fm","route"=>$route];
      View::render("default/index",
        [
        "page_data"=>$page_data
      ]);
      */

       View::render("default/index",[]);
   }


   /* 
      
    Model object manipulations example 

    public function example($route){
      //To get the Request and GET data
      $get_data = $this->request_get_params();
      
      //To get the POST Data
      $post_data = $this->request_get_input();

      //To get the Files
      $files = $this->request_get_files();

      // To get the JSON POST
      $post_json_data = $this->request_get_input_json();

      // Update the model data
      $this->model_object->update($post_data,"id = '201'");

      // Delete the row
      $this->model_object->delete("id = '201'");

      //Insert the new row
      $this->model_object->insert($post_data);

      //Get the row or rows
      $row = $this->model_object->getOne("id = '200' ");
      $rows = $this->model_object->get("id >= '200' ");

      //To use other local models
      $other_model = new ExampleModel();
      $rows = $other_model->get("id >= '200' ");
      
      $result = ["status"=>true,'message'=>"Completed Successfully"];    
      // Return the json output    
      $this->response_send_json($result);

    }
   */


}
