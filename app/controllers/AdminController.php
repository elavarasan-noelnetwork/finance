<?php
/* ======================================
  Filename: AdminController
  Author: Ameen 
  Description: Admin login and logout process
  Updated By: Ameen on 16-07-2025
  =======================================
*/

namespace app\controllers;
//session_start();
/* 
//use your own models 
use app\models\ExampleModel as ExampleModel;
*/

use core\View as View;
use app\models\UserModel;
use app\models\LoanModel;
use app\models\Model;
use TCPDF;

/*
To use the composer libraries
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
*/

class AdminController extends Controller
{

  /*
    //To use the Model Objects
    protected $model_object;
    */

  public function __construct()
  {
    /*
    //Initialize the example model
    $this->model_object = new ExampleModel();
    */
  }

  public function home($route)
  {

    // simple redirection
    if (!isset($_SESSION['auth']['loginstatus']) || $_SESSION['auth']['loginstatus'] !== true) {
      header("Location: /login");
      exit;
    } else {
      header("Location: /optin");
      exit;
    }
    exit;
  }

  public function authorizationerror($route)
  {
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      'admin/error/403',
      [
        "page_data" => $page_data
      ]
    );
    exit;
  }

  public function pageNotFounderror($route)
  {
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      'admin/error/404',
      [
        "page_data" => $page_data
      ]
    );
    exit;
  }

  public function loginvalidate()
  {

    //initialize the post data
    $post_data = $_POST;
    $route = '';
    $invalid = false;

    if (!empty($post_data)) {

      //check if the post data has username and password
      $ipUsername = isset($post_data['username']) ? trim($post_data['username']) : '';
      $ipPassword = isset($post_data['password']) ? trim($post_data['password']) : '';

      if (!empty($ipUsername) && !empty($ipPassword)) {
      
        // Define the menu items based on the role
        UserModel::$db->join("zeon_loan B", "A.zlu_id = B.zl_user_id", "LEFT");
        UserModel::$db->where("A.zlu_email", $ipUsername);
        UserModel::$db->where("A.zlu_password", $ipPassword);
        UserModel::$db->where("A.zlu_email_verified", 1);
        $_Auser = UserModel::$db->get("zeon_loan_users A", null);        

        //echo "<pre>";print_r($_Auser);exit;

        //set the session variables if user is valid
        //else set the invalid variable to true

        if (is_array($_Auser[0]) && !empty($_Auser[0])) {

          $_Auser=$_Auser[0];

          $_SESSION['auth']['loginstatus'] = true;
          $_SESSION['auth']['user_id'] = $_Auser['zlu_id'];
          $_SESSION['auth']['user_email'] = $_Auser['zlu_email'];
          $_SESSION['auth']['usr_fname'] = $_Auser['zlu_fname'];
          $_SESSION['auth']['usr_lname'] = $_Auser['zlu_lname'];          
          $_SESSION['auth']['usr_phone_code'] = $_Auser['zlu_phone_code'];
          $_SESSION['auth']['usr_phone'] = $_Auser['zlu_phone'];
          $_SESSION['auth']['usr_address'] = $_Auser['zlu_address'];
          $_SESSION['auth']['user_type '] = $_Auser['zlu_user_type'];
          $_SESSION['auth']['user_email_verified'] = $_Auser['zlu_email_verified'];
          $_SESSION['auth']['user_application '] = $_Auser['zlu_application_completed'];
          $_SESSION['auth']['user_created_on'] = $_Auser['zlu_created_on'];
          $_SESSION['show_profile_dropdown'] = true;

        } else {
          $invalid = true;
        }
      } else {
        $invalid = true;
      }
    } else {
      $invalid = true;
    }

    //redirect to admin page if login is successful
    //else show the login page with error message      
    if (!isset($_SESSION['auth']['loginstatus'])) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "auth/login",
        [
          "page_data" => $page_data,
          "invalid" => $invalid
        ]
      );
      exit;
    }

    header("Location: /optin");
  }

  public function login()
  {
    $route = '';
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "auth/login",
      [
        "page_data" => $page_data
      ]
    );
    exit;
  }

  /* Logout the user */
  public function logout()
  {
    session_destroy();
    header("Location: " . BASE_URL);
  }

}
