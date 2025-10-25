<?php
/* ======================================
  Filename: ProposalController
  Author: Ameen 
  Description: List / Add / Edit / Update Proposal
  =======================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\LoanModel;
use app\models\TrustModel;
use app\models\SmsfModel;
use core\View as View;
use app\controllers\CommonController;
use Exception;

class ProposalController extends Controller
{

  private $loanModelObj;

  public function __construct()
  {
    //Initialize the model object
    $loanModelObj = new LoanModel();
  }

  // Function to render the proposal list page
  // This function is called when the user navigates to the propsal page
  public function home($route)
  {

    $setSearchError = false;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      //if reset clear inputs
      if (isset($_GET['reset'])) {
        unset($_SESSION['filters']);
        header("Location: proposals"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['proposal']['filters']['application'] = @trim($_GET['application']) ?? '';
      $_SESSION['proposal']['filters']['property'] = @trim($_GET['property']) ?? '';
      $_SESSION['proposal']['filters']['type'] = @trim($_GET['type']) ?? '';
      $_SESSION['proposal']['filters']['source'] = @trim($_GET['source']) ?? '';
      $_SESSION['proposal']['filters']['status'] = @trim($_GET['status']) ?? '';
    }

    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['application']) && empty($_GET['property']) && empty($_GET['type']) && empty($_GET['source']) && empty($_GET['status'])) {
        $setSearchError = true;
      }
    }

    //define input arrays
    $propertyArray = PROPERTY_NAME_ARRAY;
    $buyingTypeArray = BUYING_TYPE_NAME_ARRAY;
    $statusArray = LOAN_STATUS_ARRAY;

    $soueceArray['loan'] = 'Loan';
    $soueceArray['cash'] = 'Cash';

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/proposal/listproposal",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
        "property_array" => $propertyArray,
        "buying_type_array" => $buyingTypeArray,
        "source_array" => $soueceArray,
        "status_array" => $statusArray,
      ]
    );
  }

  // Ajax call to get proposal list
  // This function is called by DataTables to fetch proposal data
  public function ajaxproposals()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $request = $_POST;

      //get list input data
      $draw = intval($request['draw']);
      $start = intval($request['start']);
      $length = intval($request['length']);
      $orderColumnIndex = $request['order'][0]['column']; // e.g., 0
      $orderDirection = $request['order'][0]['dir']; // 'asc' or 'desc'      
      $application     = $request['application'];
      $property     = $request['property'];
      $type     = $request['type'];
      $source     = $request['source'];

      //set column mapping 
      $columns = ['p.zl_id', 'p.zl_user_id', 'p.zl_code', 'p.zl_property_id', 'p.zl_buying_as_id', 'p.zl_applicant_count', 'p.zl_fname', 'p.zl_lname', 'p.zl_fname2', 'p.zl_lname2', 'p.zl_trust_name', 'p.zl_trust_setup_required', 'p.zl_smsf_name', 'p.zl_smsf_setup_required', 'p.zl_loan_required', 'p.zl_cash_investment', 'p.zl_status', 'p.zl_loan_progress_percentage', 'p.zl_created_on', 'p.zl_created_by', 'c.zlu_fname', 'c.zlu_lname'];
      $orderColumnName = $columns[$orderColumnIndex];

      Model::$db->join("zeon_loan_users c", "c.zlu_id = p.zl_user_id", "LEFT");

      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("zeon_loan p", "count(*)");

      // Apply search
      if (!empty($application)) {
        Model::$db->where(
          "(p.zl_code LIKE ? OR p.zl_trust_name LIKE ? OR p.zl_smsf_name  LIKE ? OR p.zl_fname  LIKE ? OR p.zl_lname  LIKE ? OR p.zl_fname2  LIKE ? OR p.zl_lname2  LIKE ?)",
          ["%$application%", "%$application%", "%$application%", "%$application%", "%$application%", "%$application%", "%$application%"]
        );
      }

      if (!empty($property)) {
        Model::$db->where('p.zl_property_id', $property);
      }

      if (!empty($type)) {
        Model::$db->where('p.zl_buying_as_id', $type);
      }

      if (!empty($source)) {
        if (strtolower($source) == 'loan')
          Model::$db->where('p.zl_loan_required', 1);
        else if (strtolower($source) == 'cash')
          Model::$db->where('p.zl_cash_investment', 1);
      }

      //department based lists
      if(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] == "Client"){      
        Model::$db->where('p.zl_user_id', $_SESSION['auth']['user_id']);
      }
      elseif(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] == "Accounts"){      
        Model::$db->where('p.zl_status', [20, 30], 'IN');
      }
      elseif(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] == "Finance"){      
        Model::$db->where('p.zl_status', 40);
      }
      elseif(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] == "Legal"){      
        Model::$db->where('p.zl_status', 60);
      }      

      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("zeon_loan p", "count(*)");

      // Pagination
      //Model::$db->orderBy("u.usr_id", "desc");
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $proposals = Model::$db->paginate("zeon_loan p", ($start / $length) + 1);
      //echo "<pre>";print_r($proposals);exit;

      // If no records found, return empty data
      if (empty($proposals)) {
        echo json_encode([
          'draw' => $draw,
          'recordsTotal' => $totalRecords,
          'recordsFiltered' => $totalFiltered,
          'data' => []
        ]);
        exit;
      }

      // Prepare data for DataTables
      $data = [];
      foreach ($proposals as $row) {
        $downloadLink = '';
        $deleteLink = '';
        $continueLink = '';
        $viewLink = '';

        $statusLabel = '';
        if (!empty(LOAN_STATUS_ARRAY[$row['zl_status']])) {
          $statusLabel = '<label style="border-radius:50px;" class="badge badge-success">' . LOAN_STATUS_ARRAY[$row['zl_status']] . '</label>';
        } else {
          $statusLabel = '<label style="border-radius:50px;" class="badge badge-warning">NA</label>';
        }

        $sourceValue = 'NA';
        if ($row['zl_loan_required'] == 1) {
          $sourceValue = 'Loan';
        } elseif ($row['zl_cash_investment'] == 1) {
          $sourceValue = 'Cash';
        }


        //set actions links
        if (!empty(LOAN_STATUS_ARRAY[$row['zl_status']])) {
          if ($row['zl_status'] == 10) {
         
            if (isset($row['zl_trust_setup_required']) && $row['zl_trust_setup_required'] == 1) {
              if (isset($row['zl_trust_smsf_app_completed']) && $row['zl_trust_smsf_app_completed'] == 0) {
                $sourceRedirectValue = 'trust/'.$row['zl_id'];
              }  
              elseif ($row['zl_loan_required'] == 1) {
                $sourceRedirectValue = 'application';  
              }              
            }   
            elseif (isset($row['zl_smsf_setup_required']) && $row['zl_smsf_setup_required'] == 1) {              
              if (isset($row['zl_trust_smsf_app_completed']) && $row['zl_trust_smsf_app_completed'] == 0) {
                $sourceRedirectValue = 'smsf/'.$row['zl_id'];
              }  
              elseif ($row['zl_loan_required'] == 1) {
                $sourceRedirectValue = 'application';  
              }              
            }    
            elseif ($row['zl_loan_required'] == 1) {
              $sourceRedirectValue = 'application';
            }    
            

            if(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] == "Client"){
              $continueLink = '                          
              <div class="d-flex gap-2">
                <a href="'.$sourceRedirectValue.'" title="Continue Progress" style="text-decoration: none;">
                  <button type="button" class="btn btn-outline-danger blink-icon rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                    <i class="typcn typcn-arrow-right-thick" style="font-size: 18px; color: red;"></i>
                  </button>                      
                </a>
              </div>

              <style>
              @keyframes blink {
                0%, 50%, 100% {
                  opacity: 1;
                }
                25%, 75% {
                  opacity: 0;
                }
              }

              /* Makes the entire button (circle + icon) blink */
              .blink-icon {
                animation: blink 1.5s infinite;
              }

              /* Ensures the border is red */
              .btn-outline-danger {
                border-color: red;
                color: red;
              }
              </style>
              ';
            }
          }

        }

        if(!empty($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department'] == "Admin"
        || $_SESSION['auth']['user_department'] == "Legal"
        ){
          if ($row['zl_final_doc_generated'] == 1) {
            $downloadLink = '
                          <a href="#" onclick="downloadZip('.$row['zl_id'].')" title="Dowload Document" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-download" style="font-size: 18px;"></i>
                            </button>                      
                          </a>';
            }
        }

        $deleteLink = '
                          <a href="#" title="Dowload Document" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-download" style="font-size: 18px;"></i>
                            </button>                      
                          </a>';



        $viewLink = '                          
                        <div class="d-flex gap-2">
                          <a href="/viewproposal/'.$row['zl_id'].'" title="view Application" style="text-decoration: none;" >
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a> ';

        /*
        $progressValue = isset($row['job_completed_percentage']) && $row['job_completed_percentage']
          ? round($row['job_completed_percentage'])
          : 0;
        */

        $progressValue = $row['zl_loan_progress_percentage'];

        /* This is for sample data purpose */
        $progressBar = '
            <div class="progress-circle" style="--percent:' . $progressValue . '">
              <svg class="progress-ring" viewBox="0 0 120 120">
                <!-- Background Circle -->
                <circle class="progress-ring__bg" cx="60" cy="60" r="54" />
                <!-- Progress Circle -->
                <circle class="progress-ring__progress" cx="60" cy="60" r="54" />
              </svg>
              <div class="progress-text">' . $progressValue . '<span class="small-percent">%</span></div>
            </div>';

        //set details
        $details = '<span class="text-muted">NA</span>';

        if ($row['zl_buying_as_id'] == 1) { // Individual
          $details  = '<div class="info-row">';
          $details .= '<i class="typcn typcn-user"></i> ';
          $details .= '<span class="label">Applicant Count :</span> ';
          $details .= '<span class="value">' . htmlspecialchars($row['zl_applicant_count']) . '</span>';
          $details .= '</div>';

          $details .= '<div class="info-row">';
          $details .= '<i class="typcn typcn-user-outline"></i> ';
          $details .= '<span class="label">First Applicant :</span> ';
          $details .= '<span class="value">' . htmlspecialchars($row['zl_fname']) . ' ' . htmlspecialchars($row['zl_lname']) . '</span>';
          $details .= '</div>';

          if (!empty($row['zl_fname2']) || !empty($row['zl_lname2'])) {
            $details .= '<div class="info-row">';
            $details .= '<i class="typcn typcn-user-add"></i> ';
            $details .= '<span class="label">Second Applicant :</span> ';
            $details .= '<span class="value">' . htmlspecialchars($row['zl_fname2']) . ' ' . htmlspecialchars($row['zl_lname2']) . '</span>';
            $details .= '</div>';
          }
        } elseif ($row['zl_buying_as_id'] == 2) { // Trust
          $details  = '<div class="info-row">';
          $details .= '<i class="typcn typcn-briefcase"></i> ';
          $details .= '<span class="label">Trust Name :</span> ';
          $details .= '<span class="value">' . htmlspecialchars($row['zl_trust_name']) . '</span>';
          $details .= '</div>';

          if ($row['zl_trust_setup_required'] == 1) {
            $details .= '<div class="info-row">';
            $details .= '<i class="typcn typcn-tick text-success"></i> ';
            $details .= '<span class="label">Trust Setup :</span> ';
            $details .= '<span class="value text-success">Required</span>';
            $details .= '</div>';
          } elseif ($row['zl_trust_setup_required'] == 2) {
            $details .= '<div class="info-row">';
            $details .= '<i class="typcn typcn-times text-danger"></i> ';
            $details .= '<span class="label">Trust Setup :</span> ';
            $details .= '<span class="value text-danger">Not Required</span>';
            $details .= '</div>';
          }
        } elseif ($row['zl_buying_as_id'] == 3) { // SMSF
          $details  = '<div class="info-row">';
          $details .= '<i class="typcn typcn-briefcase"></i> ';
          $details .= '<span class="label">SMSF Name :</span> ';
          $details .= '<span class="value">' . htmlspecialchars($row['zl_smsf_name']) . '</span>';
          $details .= '</div>';

          if ($row['zl_smsf_setup_required'] == 1) {
            $details .= '<div class="info-row">';
            $details .= '<i class="typcn typcn-tick text-success"></i> ';
            $details .= '<span class="label">SMSF Setup :</span> ';
            $details .= '<span class="value text-success">Required</span>';
            $details .= '</div>';
          } elseif ($row['zl_smsf_setup_required'] == 2) {
            $details .= '<div class="info-row">';
            $details .= '<i class="typcn typcn-times text-danger"></i> ';
            $details .= '<span class="label">SMSF Setup :</span> ';
            $details .= '<span class="value text-danger">Not Required</span>';
            $details .= '</div>';
          }
        }


        $data[] = [
          'code' => $row['zl_code'] ? '<b>' . $row['zl_code'] . '</b>' : 'NA',
          'created_on' => date('d-m-Y H:i', strtotime($row['zl_created_on'])),
          'property' => PROPERTY_NAME_ARRAY[$row['zl_property_id']] ? PROPERTY_NAME_ARRAY[$row['zl_property_id']] : 'NA',
          'Type' => BUYING_TYPE_NAME_ARRAY[$row['zl_buying_as_id']] ? BUYING_TYPE_NAME_ARRAY[$row['zl_buying_as_id']] : 'NA',
          'Details' => $details,
          'Source' => $sourceValue,
          'Status' => $statusLabel,
          'Progress' => $progressBar,
          'actions' => '
                        <div class="d-flex gap-2">
                        ' . $viewLink . '   
                        ' . $continueLink . '                        
                        ' . $downloadLink . '                                             
                        </div>'
        ];
      }
      //echo "<pre>";print_r($data);exit;

      echo json_encode([
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalFiltered,
        'data' => $data
      ]);
      exit;
    }
  }


  public function viewproposal($route)
  {    
    //initialize variables
    $errorArray = [];
    $loanArray =  [];
    $trustArray = [];
    $smsfArray = [];

    //validate user id
    $applicationId = $route['uri'][1];
    if (empty($applicationId) || !is_numeric($applicationId)) {
      $errorArray[] = "Invalid application ID provided.";
    } else {
      //retrieve loan
      $loanObject = new LoanModel();
      $loanArray = $loanObject->getOne("zl_id = '{$applicationId}'");          
      if (empty($loanArray)) {
        $errorArray[] = "Apllication not found.";
      }

      //retrieve trust details
      $trustObject = new TrustModel();
      $trustArray = $trustObject->getOne("zlt_id_loan_id = '{$applicationId}'");  
      
      //retrieve smsf details      
      $smsfObject = new SmsfModel();
      $smsfArray = $smsfObject->getOne("zls_id_loan_id = '{$applicationId}'");        

    }

    //redirect view application page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/proposal/viewproposal",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "loan_array" => $loanArray,
        "trust_array" => $trustArray,
        "smsf_array" => $smsfArray,
      ]
    );
    exit;
  }  

  

  public function updateSetupComplete($route){

    $errorArray = array();
    $message = '';


    if (isset($_POST['loan_id']) && $_POST['loan_id'] != '' && is_numeric($_POST['loan_id']) && $_POST['loan_id'] > 0) {
      $loan_id = $_POST['loan_id'];

      //update process
      $whereUpdate["zl_id"] = $loan_id;
      $loanStatus=60;
      $ipData['zl_status'] = $loanStatus;
      $ipData['zl_loan_progress_percentage'] = LOAN_PROGRESS_PERCNTAGE_ARRAY[$loanStatus];  

      $loanModelObj = new LoanModel();
      $updateResult =  $loanModelObj->update($ipData, $whereUpdate); 
      if ($updateResult) {
        $message = "Status updated successfully.";
      } else {
        $message = 'Error while updating. Please try again later.';
      }      
    }
    else{
      $message = 'Error while updating. Please try again later.';
    }    

    $_Aresponse = array();
    $_Aresponse['status'] = true;
    $_Aresponse['message'] =  $message;

    $_AjsonResponse = json_encode($_Aresponse);
    echo $_AjsonResponse;
  }

  /*
  // Function to render the add proposal form
  // This function is called when the user clicks on "Add Proposal" button
  public function addproposal($route)
  {
    //get company details   
    $companyArray = CommonController::getCompanies(1);

    //initialize variables
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/proposal/addproposal",
      [
        "page_data" => $page_data,
        "companyDetails" => $companyArray,
      ]
    );
  }

  // Function to render the edit user form
  // This function is called when the user clicks on "Edit" button
  // It fetches the user data based on the user ID passed in the route  
  public function editdepartment($route)
  {

    //initialize variables
    $errorArray = [];
    $_Adepartments =  [];

    //validate user id
    $_departmentid = $route['uri'][1];
    if (empty($_departmentid) || !is_numeric($_departmentid)) {
      $errorArray[] = "Invalid department ID provided.";
    } else {
      //get department data
      $this->_OdepartmentModel = new DepartmentModel();
      $_Adepartments = $this->_OdepartmentModel->getOne("dep_id = '{$_departmentid}'");
      if (empty($_Adepartments)) {
        $errorArray[] = "Department not found.";
      }
    }

    //redirect edit department page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/proposal/adddepartment",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_department" => $_Adepartments,
      ]
    );
    exit;
  }

  // Function to store or update proposal data
  public function storeproposal($route)
  {

    $post_data = $_POST;
    $errorArray = [];
    //$errorArray[] = "Project title name already exist";


    //validate inputs
    $errorArray = $this->_validateProjectTitle($post_data);

    if (!$errorArray) {

      // If prop is set, it means we are updating an existing department
      if (isset($post_data['pro_id']) && !empty($post_data['pro_id'])) {

      } else {

        //get company details
        $companyDetailsArray = [];
        if (!empty($post_data['pro_com_id'])) {
          $companyObj = new CompanyModel();
          $companyDetailsArray = $companyObj->getOne("com_id = '{$post_data['pro_com_id']}'");
        }

        //validate company details
        if (count($companyDetailsArray) > 0) {
          //move temp files
          $movedFilesArray = $this->moveFilestofolder($_FILES);
          //validate moved files
          if ($movedFilesArray) {

            //gerate  pdf
            try {
              $pdfFileName = PdfController::generatePdf($post_data, $companyDetailsArray, $movedFilesArray);
              $pdfFilPath = PDF_UPLOAD_PATH . $pdfFileName;
              // File exists
              if (file_exists($pdfFilPath)) {
                Model::$db->startTransaction();
                //do insert process
                //set default values        
                $post_data['pro_status'] = 1;
                $post_data['pro_generated_pdf'] = $pdfFileName;
                $post_data['pro_created_by'] = $_SESSION['auth']['user_id'];
                unset($post_data['uploadedFiles']);

                $proposalObj = new ProposalModel();
                $insertResult = $proposalObj->insert($post_data);
                if (is_int($insertResult) && $insertResult > 0) {
                  //update proposal code
                  $proposalCode = "PROP_" . $insertResult;
                  $whereUpdate["pro_id"] = $insertResult;
                  $post_data['pro_code'] = $proposalCode;
                  $post_data['pro_updated_by'] = $_SESSION['auth']['user_id'];
                  $post_data['pro_updated_on'] = date('Y-m-d H:i:s');
                  $updateResult =  $proposalObj->update($post_data, $whereUpdate);
                  //success
                  if ($updateResult) {
                    //inset iamges in child table
                    $proposalImgObj = new ProposalImageModel();
                    if (isset($movedFilesArray) && is_array($movedFilesArray) && count($movedFilesArray) > 0) {
                      $childErrorFlag = false;
                      foreach ($movedFilesArray as $movedFiles) {
                        $child_post_data = [];
                        $child_post_data['pimg_pro_id'] = $insertResult;
                        $child_post_data['pmg_img_name'] = $movedFiles['processedName'];
                        $child_post_data['pmg_img_original_name'] = $movedFiles['originalName'];
                        $child_post_data['pimg_type'] = $movedFiles['type'];
                        $child_post_data['pimg_size'] = $movedFiles['size'];
                        $child_post_data['pro_created_by'] = $_SESSION['auth']['user_id'];
                        $childInsertResult = $proposalImgObj->insert($child_post_data);
                        if (!is_int($childInsertResult)) {
                          //error process
                          $childErrorFlag = true;
                        }
                      }

                      //child error
                      if ($childErrorFlag) {
                        Model::$db->rollBack();
                        if (file_exists($pdfFilPath)) {
                          unlink($pdfFilPath); // Deletes the file
                        }
                        $errorArray[] = "Failed to generate proposal. Please try later.";
                      } else {
                        Model::$db->commit();


                        $response = [
                          'success' => true,
                          'fileName' => $pdfFileName
                        ];

                        echo json_encode($response);
                        exit;
                      }
                    } else {
                      if (file_exists($pdfFilPath)) {
                        unlink($pdfFilPath); // Deletes the file
                      }
                      $errorArray[] = "Failed to generate proposal. Please try later.";
                    }
                  }
                  if (!$updateResult) {
                    if (file_exists($pdfFilPath)) {
                      unlink($pdfFilPath); // Deletes the file
                    }
                    $errorArray[] = "Failed to generate proposal. Please try later.";
                  }
                } else {
                  if (file_exists($pdfFilPath)) {
                    unlink($pdfFilPath); // Deletes the file
                  }
                  // If insert fails, set an error message                     
                  $errorArray[] = "Failed to generate proposal. Please try later.";
                }
              } else {
                // File does not exist
                $errorArray[] = "Error while creating PDF...";
              }
            } catch (CustomPdfExceptionController $e) {
              echo "Custom Exception: " . $e->getMessage() . "\n";
              //echo "Details: " . json_encode($e->getDetails());
              $errorArray[] = "Error while creating PDF. Please try later.";
            } catch (\Throwable $e) {
              echo "System error: " . $e->getMessage();
              $errorArray[] = "Error while creating PDF. Please try later.";
            }

            echo "end";
            exit;
          } else {
            $errorArray[] = "Error while processing attached images.Please try later.";
          }
        } else {
          $errorArray[] = "Error while processing company details. Please try later.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $response = [
        'success' => false,
        'message' => implode(",", $errorArray)
      ];

      echo json_encode($response);
      exit;
    }
    */

  /*
    $response = [
        'success' => true,
        'message' => 'Proposal saved successfully!'
    ];
    // Or, if there’s an error:
    $response = [
        'success' => false,
        'message' => 'Something went wrong.'
    ];
    */
  //}

  /*
  //move temp files to director
  public function moveFilestofolder($ipFiles)
  {
    $movedFilesArray = [];

    if (isset($ipFiles) && !empty($ipFiles) && is_array($ipFiles)) {
      //calculate total uploaded files
      if (isset($ipFiles['files']['name']) && !empty($ipFiles['files']['name']) && is_array($ipFiles['files']['name']) && count($ipFiles['files']['name']) > 0) {
        $ipFilesCount = count($ipFiles['files']['name']) - 1;
        //create moved files array
        for ($i = 0; $i <= $ipFilesCount; $i++) {
          if (isset($ipFiles['files']['error'][$i]) && $ipFiles['files']['error'][$i] == 0) {
            //validate all file inputs 
            $tempArray = [];
            if (isset($ipFiles['files']['tmp_name'][$i]) && !empty($ipFiles['files']['tmp_name'][$i])) {
              if (isset($ipFiles['files']['name'][$i]) && !empty($ipFiles['files']['name'][$i])) {
                if (isset($ipFiles['files']['type'][$i]) && !empty($ipFiles['files']['type'][$i])) {
                  if (isset($ipFiles['files']['size'][$i]) && !empty($ipFiles['files']['size'][$i])) {
                    //move file
                    //PDF_IMG_PATH
                    $extension = pathinfo($ipFiles['files']['name'][$i], PATHINFO_EXTENSION);
                    $newFileName = uniqid('iamge_', true) . '.' . $extension;
                    $desitination = PDF_IMG_PATH . $newFileName;
                    if (move_uploaded_file($ipFiles['files']['tmp_name'][$i], $desitination)) {
                      $tempArray['originalName'] = $ipFiles['files']['name'][$i];
                      $tempArray['processedName'] = $newFileName;
                      $tempArray['type'] = $ipFiles['files']['type'][$i];
                      $tempArray['size'] = $ipFiles['files']['size'][$i];
                      $movedFilesArray[] = $tempArray;
                    }
                  }
                }
              }
            }
          }
        }
      }
    }

    //return moved files array
    if (count($movedFilesArray) > 0) {
      if (count($movedFilesArray) == $ipFilesCount) {
        return $movedFilesArray;
      }
    }

    return false;
  }

  /*
  public function downloadPdf($route)
  {
    //$pdfFileName = "ameen_68c15942b830e.pdf";
    $pdfFileName = $route['uri'][1];
    $pdfFilPath = PDF_UPLOAD_PATH . $pdfFileName;

    if (!empty($pdfFileName) && file_exists($pdfFilPath)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment; filename="' . $pdfFileName . '"');
      header('Content-Transfer-Encoding: binary');
      header('Content-Length: ' . filesize($pdfFilPath));
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      ob_clean();
      flush();
      readfile($pdfFilPath);
      exit;
    } else {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        'admin/error/404_pdf',
        [
          "page_data" => $page_data
        ]
      );
      exit;
    }
  }


  // Function to view department details
  // This function is called when the user clicks on "View" button
  public function viewdepartment($route)
  {

    //initialize variables
    $errorArray = [];
    $_Adepartments =  [];

    //validate user id
    $_departmentid = $route['uri'][1];
    if (empty($_departmentid) || !is_numeric($_departmentid)) {
      $errorArray[] = "Invalid department ID provided.";
    } else {
      //get department data
      $this->_OdepartmentModel = new DepartmentModel();
      $_Adepartments = $this->_OdepartmentModel->getOne("dep_id = '{$_departmentid}'");
      if (empty($_Adepartments)) {
        $errorArray[] = "Department not found.";
      }
    }

    //redirect edit department page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/proposal/viewdepartment",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_department" => $_Adepartments,
      ]
    );
    exit;
  }

  //validata project title
  private function _validateProjectTitle($formData)
  {
    $errorArray = array();

    //title unique validation 
    if (!empty($formData['pro_title'])) {
      $proposalModelObj = new ProposalModel();

      if (!empty($formData['pro_id'])) {
        $proposals = $proposalModelObj->getOne("pro_title = '{$formData['pro_title']}' AND pro_id != {$formData['pro_id']}");
      } else {
        $proposals = $proposalModelObj->getOne("pro_title = '{$formData['pro_title']}'");
      }

      if (!empty($proposals) && count($proposals) > 0) {
        $errorArray[] = "Project title name already exist";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
  */


  
}
