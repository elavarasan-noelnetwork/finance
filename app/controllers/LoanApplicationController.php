<?php
/* ======================================
  Filename: LoanApplicationController.php
  Author: Ameen 
  Description: Dashboard report based on user
  Updated By: Ameen on 16-07-2025
  =======================================
*/

namespace app\controllers;

use core\View as View;
use app\models\LoanModel;
use app\models\Model;
use app\models\UserModel;
use app\controllers\PdfController;

class LoanApplicationController extends Controller
{

  public function home($route)
  {
    echo "hai";    
    exit;
  }

  public function optin($route)
  {
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/application/optin",
      [
        "page_data" => $page_data
      ]
    );
    exit;
  }  

  public function storeoptin($route){
    
    $errorArray = array();    
    $post_data = array();
    $successFlag = false;
    $redirectPage="proposals";

    if(!empty($_POST) && count($_POST)>0){

      //set defaults
      $post_data['zl_user_id'] = $_SESSION['auth']['user_id'];
      $post_data['zl_created_by'] = $_SESSION['auth']['user_id'];

      //other values
      $post_data['zl_property_id'] = $_POST['property_choice'];
      $post_data['zl_buying_as_id'] =  BUYING_TYPE_ARRAY[$_POST['buyer_type']] ? BUYING_TYPE_ARRAY[$_POST['buyer_type']] : '-';

      //set loan and cash
      if(!empty($_POST['loan_help']) && strtoupper($_POST['loan_help']) == "YES"){
        $post_data['zl_loan_required'] = 1;
      }
      elseif(!empty($_POST['loan_help']) && strtoupper($_POST['loan_help']) == "NO"){
        $post_data['zl_loan_required'] = 2;
      } 
      
      if(!empty($_POST['cash_available']) && strtoupper($_POST['cash_available']) == "YES"){
        $post_data['zl_cash_investment'] = 1;
      }
      if(!empty($_POST['cash_available']) && strtoupper($_POST['cash_available']) == "NO"){
        $post_data['zl_cash_investment'] = 2;
      }       

      //for individual
      if(!empty($_POST['buyer_type'])){
        if(strtoupper($_POST['buyer_type']) == "INDIVIDUAL"){
          $post_data['zl_applicant_count'] = $_POST['applicant_count'];
          $post_data['zl_fname'] = $_POST['first_name'];
          $post_data['zl_lname'] = $_POST['last_name'];
          $post_data['zl_fname2'] = $_POST['first_name2'];
          $post_data['zl_lname2'] = $_POST['last_name2'];        
        }
        elseif(strtoupper($_POST['buyer_type']) == "TRUST"){
          $post_data['zl_trust_name'] = $_POST['trust_name'];
          $post_data['zl_trust_setup_required'] = OPTION_YES_NO_ARRAY[$_POST['trust_help']] ? OPTION_YES_NO_ARRAY[$_POST['trust_help']] : '-';;
        }
        elseif(strtoupper($_POST['buyer_type']) == "SMSF"){
          $post_data['zl_smsf_name'] = $_POST['smsf_name'];
          $post_data['zl_smsf_setup_required'] = OPTION_YES_NO_ARRAY[$_POST['smsf_help']] ? OPTION_YES_NO_ARRAY[$_POST['smsf_help']] : '-';;
        }            
      }


      
      //set status
      $loanStatus=10; //application in progress      
      if(!empty($post_data['zl_buying_as_id'])){        
        
        if($post_data['zl_buying_as_id'] == 1){ //individual

          if($post_data['zl_loan_required'] == 1){
            $loanStatus=10; //application in progress
            $redirectPage = "application";
          }
          elseif($post_data['zl_cash_investment'] == 1){
            $loanStatus=60; //Legal Review
            $redirectPage = "proposals";
          }          


        }
        elseif($post_data['zl_buying_as_id'] == 2){ //trust
          if(!empty($post_data['zl_trust_setup_required']) && $post_data['zl_trust_setup_required'] == 1){
            $loanStatus=10; //application in progress
            $redirectPage = "trust";
          }
          else{
            if($post_data['zl_loan_required'] == 1){
              $loanStatus=10; //application in progress
              $redirectPage = "application";
            }
            elseif($post_data['zl_cash_investment'] == 1){
              $loanStatus=60; //Legal Review
              $redirectPage = "proposals";
            }              
          }
        }
        elseif($post_data['zl_buying_as_id'] == 3){ //smsf
          if(!empty($post_data['zl_smsf_setup_required']) && $post_data['zl_smsf_setup_required'] == 1){
            $loanStatus=10; //application in progress
            $redirectPage = "smsf";
          }
          else{
            if($post_data['zl_loan_required'] == 1){
              $loanStatus=10; //application in progress
              $redirectPage = "application";
            }
            elseif($post_data['zl_cash_investment'] == 1){
              $loanStatus=60; //Legal Review
              $redirectPage = "proposals";
            }              
          }          
        }
      }

      //set status input
      $post_data['zl_status'] = $loanStatus;
      $post_data['zl_loan_progress_percentage'] = LOAN_PROGRESS_PERCNTAGE_ARRAY[$loanStatus];

      //db insert process
      $this->loanModel = new LoanModel();
      Model::$db->startTransaction();
      $loanResult =  $this->loanModel->insert($post_data);
      if(is_int($loanResult) && $loanResult > 0) {
          //update code
          $applicationCode = "ZAC" . $loanResult;
          $whereUpdate["zl_id"] = $loanResult;
          $upd_ip_data['zl_code'] = $applicationCode;
          $updateResult =  $this->loanModel->update($upd_ip_data, $whereUpdate);
          if ($updateResult) {
            //update user application status
            $this->UserModel = new UserModel();
            $whereUserUpdate["zlu_id"] = $_SESSION['auth']['user_id'];
            $upd_user_ip_data['zlu_application_completed'] = 1;
            $updateUserResult =  $this->UserModel->update($upd_user_ip_data, $whereUserUpdate);
            if ($updateUserResult) {               
              $successFlag = true;
            }         
          }
      } else {
        // If insert fails, set an error message   
        Model::$db->rollBack();
        $errorArray[] = "Error while creating ownership. Please try again later...";
      }      

      //if all success
      if($successFlag){

        $_SESSION['auth']['user_redirect']='proposals';
        $_SESSION['auth']['user_application'] = 1;
        Model::$db->commit();

        //generate final documents
        if(!empty($loanResult) && !empty($loanStatus) && $loanStatus == 60){ //legal review
          PdfController::generateFinalDocuments($loanResult);
        }

        $redirectPageWithId = $redirectPage;
        if($redirectPage == "trust" || $redirectPage == "smsf"){
          $redirectPageWithId = $redirectPage."/".$loanResult;
        }

        //set success message
        if(in_array($redirectPage, ['proposals'])){
            $_SESSION['proposal']['flash'] = [
              'type' => 'success', // or 'error', 'warning'
              'message' => 'Application saved successfully!'
            ];
        }        

        header("Location: ".$redirectPageWithId);
        exit;    
         
        /*
        if(!empty($_POST['loan_help']) && strtoupper($_POST['loan_help']) == "YES"){
          header("Location: application");
          exit;
        }
        elseif(!empty($_POST['loan_help']) && strtoupper($_POST['loan_help']) == "NO"){
          header("Location: proposals");
          exit;
        }
        */

      }

    }
    else{
      $errorArray[] = "Error while creating ownership. Please try again later...";
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/application/optin",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray
        ]
      );
      exit;
    }    
  }


}
