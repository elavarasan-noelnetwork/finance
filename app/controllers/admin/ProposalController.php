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
use app\models\ProposalModel;
use core\View as View;
use app\controllers\CommonController;
use app\controllers\PdfController;
use app\controllers\CustomPdfExceptionController;
use app\models\CompanyModel;
use app\models\ProposalImageModel;
use Exception;

class ProposalController extends Controller
{

  private $proposalModelObj;

  public function __construct()
  {
    //Initialize the model object
    $proposalModelObj = new ProposalModel();
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
      $_SESSION['proposal']['filters']['company'] = @trim($_GET['company']) ?? '';
      $_SESSION['proposal']['filters']['project'] = @trim($_GET['project']) ?? '';
      $_SESSION['proposal']['filters']['customer'] = @trim($_GET['customer']) ?? '';
      $_SESSION['proposal']['filters']['status'] = @trim($_GET['status']) ?? '';
    }

    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['company']) && empty($_GET['project']) && empty($_GET['customer']) && empty($_GET['status'])) {
        $setSearchError = true;
      }
    }

    //get company details   
    $companyArray = CommonController::getCompanies(1);

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/proposal/listproposal",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
        "companyDetails" => $companyArray,
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
      $company     = $request['company'];
      $project     = $request['project'];
      $customer     = $request['customer'];
      $status     = $request['status'];

      //set column mapping 
      $columns = ['p.pro_code', 'p.pro_created_on', 'p.pro_title', 'p.pro_project_address', 'p.pro_water_mark_inc', 'p.pro_agrement_page_inc', 'p.pro_customer_name', 'p.pro_customer_address', 'p.pro_status'];
      $orderColumnName = $columns[$orderColumnIndex];

      Model::$db->join("ne_companies c", "c.com_id = p.pro_com_id", "LEFT");

      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("ne_proposals p", "count(*)");

      // Apply search
      if (!empty($project)) {
        Model::$db->where(
          "(p.pro_code LIKE ? OR p.pro_title LIKE ? OR p.pro_project_address  LIKE ?)",
          ["%$project%", "%$project%", "%$project%"]
        );
      }

      if (!empty($customer)) {
        Model::$db->where(
          "(p.pro_customer_name LIKE ? OR p.pro_customer_address LIKE ?)",
          ["%$customer%", "%$customer%"]
        );
      }

      if (!empty($status)) {
        Model::$db->where('p.pro_status', $status);
      }

      if (!empty($company)) {
        Model::$db->where('p.pro_com_id', $company);
      }


      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("ne_proposals p", "count(*)");

      // Pagination
      //Model::$db->orderBy("u.usr_id", "desc");
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $proposals = Model::$db->paginate("ne_proposals p", ($start / $length) + 1);
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
        $statusLabel = '';
        if ($row['pro_status'] == 1) {
          $statusLabel = '<label class="badge badge-success">Active</label>';
        } elseif ($row['pro_status'] == 2) {
          $statusLabel = '<label class="badge badge-warning">Inactive</label>';
        }

        $waterMark = 'No';
        if ($row['pro_water_mark_inc'] == 1) {
          $waterMark = 'Yes';
        }

        $agreement = 'No';
        if ($row['pro_agrement_page_inc'] == 1) {
          $agreement = 'Yes';
        }

        //preview logo
        $logoPreview = 'NA';
        if (!empty($row['com_logo'])) {
          $tmpPath = COM_LOGO_PATH . $row['com_logo'];
          $tmpUrl = COM_LOGO_URL . $row['com_logo'];
          if (file_exists($tmpPath)) {
            $logoPreview = '<img src="' . $tmpUrl . '" alt="Preview" 
              style="width:100px; height:50px; object-fit:contain;  border-radius:6px; padding:4px;">';
          }
        }        

        $pdfPreviewUrl = PDF_UPLOAD_URL.$row['pro_generated_pdf'];
        
        $data[] = [
          'code' => $row['pro_code'] ? $row['pro_code'] : 'NA',
          'created_on' => date('d-m-Y H:i', strtotime($row['pro_created_on'])),
          'title' => $logoPreview,
          'logo' => $row['pro_title'] ? $row['pro_title'] : 'NA',
          'location' => $row['pro_project_address'] ? $row['pro_project_address'] : 'NA',
          'agreement' => $agreement,
          'customer' => $row['pro_customer_name'] ? $row['pro_customer_name'] : 'NA',
          'address' => $row['pro_customer_address'] ? $row['pro_customer_address'] : 'NA',
          'status' => $statusLabel,
          'actions' => '
                        <div class="d-flex gap-2">
                          <a href="#" title="Preview PDF" style="text-decoration: none;" onclick="openPdfViewer(\''.$pdfPreviewUrl.'\')">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>

                          <a href="' . BASE_URL . 'downloadPdf/' . $row['pro_generated_pdf'] . '" title="dowload PDF" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-download" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                                                            
                          <a href="#" title="Delete" style="text-decoration: none;" onclick="showSwal(\'delete\')">                          
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-trash" style="font-size: 18px;"></i>
                            </button>                      
                          </a>      
                        </div>        
                        '
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
        /*
        //update process
        $whereUpdate["dep_id"] = $post_data['dep_id'];
        $post_data['dep_updated_by'] = $_SESSION['auth']['user_id'];
        $post_data['dep_updated_on'] = date('Y-m-d H:i:s');

        $res =  $this->_OdepartmentModel->update($post_data, $whereUpdate);
        if ($res) {
          // If update is successful, set a success message
          $_SESSION['department']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Department updated successfully!'
          ];
          header("Location: departments");
          exit;
        } else {
          // If update fails, set an error message   
          $errorArray[] = "Failed to update user. Please try again.";
        }
        */
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

                        //set sucess
                        /*
                        $_SESSION['department']['flash'] = [
                          'type' => 'success', // or 'error', 'warning'
                          'fileName' => $pdfFileName
                        ];

                        // ✅ Query executed successfully
                        // Could have changed rows OR matched nothing / same data
                        
                        // If insert is successful, set a success message
                        $_SESSION['department']['flash'] = [
                          'type' => 'success', // or 'error', 'warning'
                          'message' => 'Proposal generated sucessfully!'
                        ];
                        header("Location: departments");
                        exit;
                        */
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
  }

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
}
