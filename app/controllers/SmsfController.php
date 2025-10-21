<?php
/* ======================================
  Filename: LoanApplicationController.php
  Author: Ameen 
  =======================================
*/

namespace app\controllers;

use core\View as View;
use app\models\LoanModel;
use app\models\Model;
use app\models\UserModel;
use app\models\SmsfModel;

class SmsfController extends Controller
{


  public function home($route)
  {

    $errorArray = array();
    $loanDetailsArray = array();

    $loanId = $route['uri'][1];
    //get loan details
    if (empty($loanId) || !is_numeric($loanId)) {
      $errorArray[] = "Error while retrieving application details. Please try again later...";
    } else {
      $this->loanObject = new LoanModel();
      $loanDetailsArray = $this->loanObject->getOne("zl_id = '{$loanId}'");
      if (empty($loanDetailsArray)) {
        $errorArray[] = "Error while retrieving application details. Please try again later...";
      }
    }

    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/application/smsf",
      [
        "page_data" => $page_data,
        "loanDetailsArray" => $loanDetailsArray,
        "errorArray" => $errorArray,
      ]
    );
    exit;
  }

  public function storesmsf($route)
  {

    $errorArray = array();
    $post_data = array();
    $loanDetailsArray = array();
    $successFlag = false;

    if (!empty($_POST) && count($_POST) > 0) {
      if (!empty($_POST['loan_id']) && is_numeric($_POST['loan_id'])) {
        $loanId = $_POST['loan_id'];
        //get loan details
        $this->loanObject = new LoanModel();
        $loanDetailsArray = $this->loanObject->getOne("zl_id = '{$loanId}'");
        if (empty($loanDetailsArray)) {
          $errorArray[] = "Error while creating SMSF details. Please try again later...1";
        }
      } else {
        $errorArray[] = "Error while creating SMSF details. Please try again later...2";
      }

      if (empty($errorArray)) {

        //proceed with insert
        $post_data = $_POST;
        unset($post_data['loan_id']);

        //set defaults        
        $post_data['zls_id_loan_id'] = $loanId;
        $post_data['zls_user_id'] = $_SESSION['auth']['user_id'];
        $post_data['zls_created_by'] = $_SESSION['auth']['user_id'];


        //db insert process
        $this->SmsfModel = new SmsfModel();
        Model::$db->startTransaction();
        $smsfResult =  $this->SmsfModel->insert($post_data);

        if (is_int($smsfResult) && $smsfResult > 0) {
          //update completed status in loan table
          $this->loanModel = new LoanModel();
          $whereUpdate["zl_id"] = $loanId;
          $upd_ip_data['zl_trust_smsf_app_completed'] = 1;

          //if cash investment
          if (isset($loanDetailsArray['zl_cash_investment']) && $loanDetailsArray['zl_cash_investment'] == 1) {
                  $loanStatus=30;
                  $upd_ip_data['zl_status'] = $loanStatus;
                  $upd_ip_data['zl_loan_progress_percentage'] = LOAN_PROGRESS_PERCNTAGE_ARRAY[$loanStatus];
          }

          $updateResult =  $this->loanModel->update($upd_ip_data, $whereUpdate);
          if ($updateResult) {
            $successFlag = true;
          }
        } else {
          // If insert fails, set an error message   
          Model::$db->rollBack();
          $errorArray[] = "Error while creating SMSF details. Please try again later...3";
        }

        //if all success
        if ($successFlag) {
          Model::$db->commit();

          //set redirect page
          if (isset($loanDetailsArray['zl_loan_required']) && $loanDetailsArray['zl_loan_required'] == 1) {
            $redirectPage = "application";
          } else {
            $redirectPage = "proposals";
            $_SESSION['proposal']['flash'] = [
              'type' => 'success', // or 'error', 'warning'
              'message' => 'SMSF details saved successfully!'
            ];
          }

          header("Location: " . $redirectPage);
          exit;

        }
      }
    } else {
      $errorArray[] = "Error while creating SMSF details. Please try again later...4";
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/application/smsf",
        [
          "page_data" => $page_data,
          "loanDetailsArray" => $loanDetailsArray,
          "errorArray" => $errorArray,
        ]
      );
      exit;
    }
  }
}
