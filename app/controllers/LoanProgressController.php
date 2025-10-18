<?php
/* ======================================
  Filename: LoanProgressController.php
  Author: Elavarasan 
  Description: LoanProgressController

  =======================================
*/

namespace app\controllers;

use core\View as View;
use app\models\LoanModel;
use app\models\Model;
use app\models\UserModel;
use app\models\LappPersonalModel;

class LoanProgressController extends Controller
{
  private $_OlappPersonalModel;

  public function home($route)
  {
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/application/application",
      [
        "page_data" => $page_data
      ]
    );
    exit;
  }

  public function ajaxaddfinancedetails($route){

    //echo "<pre>";print_r($_POST);

    $post_data = $_POST;
    $errorArray = [];

    //Array ( [preferred_name] => sdfsdfsd [country_code] => +61 [phone_number] => 342 342 342 [title1] => Miss [title2] => Dr. [gender] => Other [relationship] => married [dependant] => 3 [dependant_age_1] => 2 [dependant_age_2] => 2 [dependant_age_3] => 2 [job_id] => undefined [job_reference] => undefined )

    $this->_OlappPersonalModel = new LappPersonalModel();

    if(isset($post_data['loan_id']) && $post_data['loan_id']!=''){ 

      try {

        $loanUpdateArr = array();
        $loanUpdateArr['prefered_name']         = $post_data['preferred_name'];
        $loanUpdateArr['phone']                 = $post_data['country_code'].''.$post_data['phone_number'];
        if($post_data['title1']){
          $loanUpdateArr['title']               = $post_data['title1'];
        }
        if($post_data['title2']){
          $loanUpdateArr['title']               = $post_data['title2'];
        }
      
        $loanUpdateArr['gender']                = $post_data['gender'];
        $loanUpdateArr['relation_ship_status']  = $post_data['relationship'];
        $loanUpdateArr['dependants_count']      = $post_data['dependant'];

        for($i=1;$i<=10;$i++){ 
          if($post_data['dependant_age_'.$i]){
            $loanUpdateArr['dep'.$i.'_age']      = $post_data['dependant_age_'.$i];
          }
        }
        
        for($i=1;$i<=10;$i++){ 
          //if($post_data['dependant_age_'.$i])
          {
            $loanUpdateOldArr['dep'.$i.'_age']      = '';
          }
        }
        $whereUpdate["zlp_id"] = $post_data['loan_id'];

        $this->_OlappPersonalModel->update($loanUpdateOldArr, $whereUpdate);

        $res =  $this->_OlappPersonalModel->update($loanUpdateArr, $whereUpdate);

        $_Aresponse['status'] = true;
        $_Aresponse['loan_id']   =  $post_data['loan_id'];

        $_AjsonResponse = json_encode($_Aresponse);
        echo $_AjsonResponse;



      }catch (\Exception $e) {

          $_Aresponse = array();
          $_Aresponse['status'] = false;
          
          $_AjsonResponse = json_encode($_Aresponse);
          echo $_AjsonResponse;
          
      }


    }else{


      try {
        //init
        $StepOneErrorArray = array();
        //start transaction
        Model::$db->startTransaction();

        $loanInsertArr = array();
        $loanInsertArr['prefered_name']         = $post_data['preferred_name'];
        $loanInsertArr['phone']                 = $post_data['country_code'].''.$post_data['phone_number'];
        if($post_data['title1']){
          $loanInsertArr['title']               = $post_data['title1'];
        }
        if($post_data['title2']){
          $loanInsertArr['title']               = $post_data['title2'];
        }
      
        $loanInsertArr['gender']                = $post_data['gender'];
        $loanInsertArr['relation_ship_status']  = $post_data['relationship'];
        $loanInsertArr['dependants_count']      = $post_data['dependant'];

        for($i=1;$i<=10;$i++){ 
          if($post_data['dependant_age_'.$i]){
            $loanInsertArr['dep'.$i.'_age']      = $post_data['dependant_age_'.$i];
          }
        }

        $loan_insert_id    =  $this->_OlappPersonalModel->insert($loanInsertArr);

        $query = Model::$db->getLastQuery();

        Model::$db->commit();
        $_Aresponse = array();

        $_Aresponse['status'] = true;
        $_Aresponse['loan_id']   =  $loan_insert_id;

        $_AjsonResponse = json_encode($_Aresponse);
        echo $_AjsonResponse;

      } catch (\Throwable $e) {
        //for system errors
        error_log(" step 1 creation error " . date('Y-m-d H:i:s') . ' ' . $e->getMessage());
        $_Aresponse = array();
        $_Aresponse['status'] = false;

        $_AjsonResponse = json_encode($_Aresponse);
        echo $_AjsonResponse;
      }
    }


  }

 


}
