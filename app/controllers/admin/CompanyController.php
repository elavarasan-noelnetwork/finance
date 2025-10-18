<?php
/* ======================================
  Filename: CompanyController
  Author: Ameen 
  =======================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\UserModel;
use app\models\CompanyModel;
use core\View as View;
use app\controllers\CommonController;
use Exception;



class CompanyController extends Controller
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
      $this->model_object = new UserModel();
      */
  }

  public function home($route)
  {

    $setSearchError = false;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      //if reset clear inputs
      if (isset($_GET['reset'])) {
        unset($_SESSION['filters']);
        header("Location: companies"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['company']['filters']['name'] = @trim($_GET['name']) ?? '';
      $_SESSION['company']['filters']['status'] = @trim($_GET['status']) ?? '';
    }

    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['name']) && empty($_GET['status'])) {
        $setSearchError = true;
      }
    }

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/company/listcompany",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
      ]
    );
  }

  // Ajax call to get company list
  // This function is called by DataTables to fetch company data
  public function ajaxcompany()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $request = $_POST;

      //get list input data
      $draw = intval($request['draw']);
      $start = intval($request['start']);
      $length = intval($request['length']);
      $orderColumnIndex = $request['order'][0]['column']; // e.g., 0
      $orderDirection = $request['order'][0]['dir']; // 'asc' or 'desc'      
      $name     = $request['name'];
      $status     = $request['status'];

      //set column mapping 
      $columns = ['c.com_id', 'c.com_created_on', 'c.com_name', 'c.com_email', 'c.com_phone', 'c.com_status'];
      $orderColumnName = $columns[$orderColumnIndex]; // e.g., usr_id

      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("ne_companies c", "count(*)");

      // Apply search
      if (!empty($name)) {
        Model::$db->where(
          "(c.com_name LIKE ? OR c.com_address1 LIKE ? OR c.com_address2 LIKE ? OR c.com_city LIKE ? OR c.com_state LIKE ? OR c.com_zip LIKE ? OR c.com_country LIKE ? )",
          ["%$name%", "%$name%", "%$name%", "%$name%", "%$name%", "%$name%", "%$name%"]
        );
      }
      if (!empty($status)) {
        Model::$db->where('c.com_status', $status);
      }


      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("ne_companies c", "count(*)");

      // Pagination
      //Model::$db->orderBy("u.usr_id", "desc");
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $companies = Model::$db->paginate("ne_companies c", ($start / $length) + 1);


      $data = [];
      foreach ($companies as $row) {
        $statusLabel = '';
        if ($row['com_status'] == 1) {
          $statusLabel = '<label class="badge badge-success">Active</label>';
        } elseif ($row['com_status'] == 2) {
          $statusLabel = '<label class="badge badge-warning">Inactive</label>';
        }

        //preview logo
        $logoPreview = '';
        if (!empty($row['com_logo'])) {
          $tmpPath = COM_LOGO_PATH . $row['com_logo'];
          $tmpUrl = COM_LOGO_URL . $row['com_logo'];
          if (file_exists($tmpPath)) {
            $logoPreview = '<img src="' . $tmpUrl . '" alt="Preview" 
              style="width:120px; height:70px; object-fit:contain;  border-radius:6px; padding:4px;">';
          }
        }

        //adress lable
        $addressLabel = '';
        $line1 = [];
        if (!empty($row['com_address1'])) $line1[] = $row['com_address1'];
        if (!empty($row['com_address2'])) $line1[] = $row['com_address2'];

        $line2 = [];
        if (!empty($row['com_city']))  $line2[] = $row['com_city'];
        if (!empty($row['com_state'])) $line2[] = $row['com_state'];

        $zip = !empty($row['com_zip']) ? $row['com_zip'] : '';
        $country = !empty($row['com_country']) ? $row['com_country'] : '';

        // first line
        if (!empty($line1)) {
          $addressLabel .= implode(', ', $line1) . "<br>";
        }

        // second line
        if (!empty($line2)) {
          $addressLabel .= implode(', ', $line2);
          if ($zip) {
            $addressLabel .= ' - ' . $zip;
          }
          $addressLabel .= "<br>";
        } elseif ($zip) {
          // if only zip exists
          $addressLabel .= $zip . "<br>";
        }

        // country line
        if ($country) {
          $addressLabel .= $country;
        }


        $data[] = [
          'com_id' => $row['com_id'] ?? '',
          'com_created_on' => date('d-m-Y H:i', strtotime($row['com_created_on'])),
          'com_name' => $row['com_name'] ?? '',
          'com_logo' => $logoPreview,
          'address' => $addressLabel,
          'com_email' => $row['com_email'] ?? '',
          'com_phone' => $row['com_phone'] ?? '',
          'com_status' => $statusLabel,
          'actions' => '
                        <div class="d-flex gap-2">
                          <a href="' . BASE_URL . 'viewcompany/' . $row['com_id'] . '" title="view" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'editcompany/' . $row['com_id'] . '" title="Edit" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-edit" style="font-size: 18px;"></i>
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

      echo json_encode([
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalFiltered,
        'data' => $data
      ]);
      exit;
    }
  }

  public function addcompany($route)
  {
    $errorArray = [];
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/company/addcompany",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
      ]
    );
  }


  public function editcompany($route)
  {

    //initialize variables
    $errorArray = [];
    $company =  [];

    //validate company id
    $companyId = $route['uri'][1];
    if (empty($companyId) || !is_numeric($companyId)) {
     // $errorArray[] = "Invalid Company ID provided.";
        header("Location: /authorization");
        exit;
    } else {
      //get company data
      $companyObj = new CompanyModel();
      $company = $companyObj->getOne("com_id = '{$companyId}'");
      if (empty($company)) {
        //$errorArray[] = "Company not found.";
        header("Location: /authorization");
        exit;        
      }
    }

    //redirect edit user page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/company/addcompany",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "company" => $company,
      ]
    );
    exit;
  }


  public function storecompany($route)
  {

    $post_data = $_POST;
    $errorArray = [];

    //Handle logo upload (new / tmp / existing)
    $newLogoUploaded = isset($_FILES['com_logo']) && $_FILES['com_logo']['error'] !== UPLOAD_ERR_NO_FILE;

    if (!empty($_FILES['com_logo']['name'])) {
      // new upload
      $tempFile = $this->processLogoFileTmp($_FILES['com_logo'], $post_data);
      if ($tempFile) {
        $post_data['com_logo_tmp'] = $tempFile;
      } else {
        $errorArray[] = "Error while processing logo image";
      }
    } elseif (!empty($_POST['hidden_logo_tmp']) && (strpos($post_data['hidden_logo_tmp'], 'logo_') !== 0)) {
      // reuse old logo (from hidden field)
      $post_data['com_logo_tmp'] = $_POST['hidden_logo_tmp'];
    } elseif (!empty($post_data['com_id'])) {
      // edit mode fallback
      $companyObj = new CompanyModel();
      $company = $companyObj->getOne("com_id = '{$post_data['com_id']}'");
      $post_data['com_logo'] = $company['com_logo'] ?? '';
    } 

    /*
    echo "<pre>";
    print_r($_POST);
    print_r($post_data);
    exit;
    */

    // Validate inputs
    $validationErrors = $this->_validateCompanyInputs($post_data);
    if ($validationErrors) {
      $errorArray = array_merge($errorArray, $validationErrors);
    }

    if (!$errorArray) {
      //db process
      // If com_id is set, it means we are updating an existing company
      if (isset($post_data['com_id']) && !empty($post_data['com_id'])) {

  
        //get final logo
        $finalLogoName = "";
        if (!empty($post_data['com_logo_tmp'])) {
          $finalLogoName = $this->moveTmpToPermanent($post_data['com_logo_tmp']);
        }
        elseif(!empty($post_data['com_logo'])){
            $finalLogoName = $post_data['com_logo'];
        }

        if (!empty($finalLogoName)) {          
          //set company logo data
          $post_data['com_logo'] = $finalLogoName;
          unset($post_data['com_logo_tmp']);
          unset($post_data['hidden_logo_tmp']);

          //update process
          $whereUpdate["com_id"] = $post_data['com_id'];
          $post_data['com_updated_by'] = $_SESSION['auth']['user_id'];
          $post_data['com_updated_on'] = date('Y-m-d H:i:s');
          $companyObj = new CompanyModel();
          $res =  $companyObj->update($post_data, $whereUpdate);
          if ($res) {
            // If update is successful, set a success message
            $_SESSION['company']['flash'] = [
              'type' => 'success', // or 'error', 'warning'
              'message' => 'Company details updated successfully!'
            ];
            header("Location: companies");
            exit;
          } else {
            // If update fails, set an error message   
            $errorArray[] = "Failed to update company details. Please try again.";
          }
        } else {
          $errorArray[] = "Error while processing logo image0.";
        }
      } else {

        //Finalize logo (if tmp exists, move to permanent)
        if (!empty($post_data['com_logo_tmp'])) {
          $finalLogoName = $this->moveTmpToPermanent($post_data['com_logo_tmp']);
          if ($finalLogoName) {
            $companyObj = new CompanyModel();

            //set company logo data
            $post_data['com_logo'] = $finalLogoName;
            unset($post_data['com_logo_tmp']);
            unset($post_data['hidden_logo_tmp']);

            //set default values        
            $post_data['com_created_by'] = $_SESSION['auth']['user_id'];
            $post_data['com_updated_by'] = $_SESSION['auth']['user_id'];
            $post_data['com_updated_on'] = date('Y-m-d H:i:s');

            //insert process
            $res =  $companyObj->insert($post_data);

            if (is_int($res) && $res > 0) {
              // If insert is successful, set a success message
              $_SESSION['company']['flash'] = [
                'type' => 'success', // or 'error', 'warning'
                'message' => 'Company registered successfully!'
              ];
              header("Location: companies");
              exit;
            } else {
              // If insert fails, set an error message   
              $errorArray[] = "Failed to create company. Please try again.";
            }
          } else {
            $errorArray[] = "Error while processing logo image.";
          }
        } else {
          $errorArray[] = "Error while processing logo image.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {

      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/company/addcompany",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "company" => $post_data,
        ]
      );
      exit;
    }
  }


  /**
   * Save upload into tmp directory
   */
  private function processLogoFileTmp($file, $postData)
  {
    $dir = COM_LOGO_TEMP_PATH;
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = bin2hex(random_bytes(12)) . '.' . $ext;
    $target = $dir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
      $userId = $_SESSION['auth']['user_id'];
      $_SESSION['temp_logo'][$userId][] = $filename;

      return $filename;
    }

    return false;
  }

  /**
   * Move file from tmp → permanent directory
   */
  private function moveTmpToPermanent($tmpFilename)
  {
    $tmpPath = COM_LOGO_TEMP_PATH . $tmpFilename;
    $permDir = COM_LOGO_PATH;
    if (!is_dir($permDir)) mkdir($permDir, 0755, true);

    $ext = strtolower(pathinfo($tmpFilename, PATHINFO_EXTENSION));
    $final = uniqid("logo_") . '.' . $ext;
    $finalPath = $permDir . '/' . $final;

    if (file_exists($tmpPath)) {
      rename($tmpPath, $finalPath);
      $this->cleanOldTempFiles();
      return $final;
    }

    return false;
  }

  //clean other temp files not used
  private function cleanOldTempFiles()
  {
    $userId = $_SESSION['auth']['user_id'];
    if (is_array($_SESSION['temp_logo'][$userId]) && count($_SESSION['temp_logo'][$userId]) > 0) {
      $dir = COM_LOGO_TEMP_PATH;
      foreach ($_SESSION['temp_logo'][$userId] as $tempFileName) {
        if (!empty($tempFileName)) {
          $oldTmp = $dir . '/' . $tempFileName;
          if (is_file($oldTmp)) {
            unlink($oldTmp);
          }
        }
      }
      unset($_SESSION['temp_logo'][$userId]);
    }
  }

  public function viewcompany($route)
  {

    //initialize variables
    $errorArray = [];
    $company =  [];

    //validate company id
    $companyId = $route['uri'][1];
    if (empty($companyId) || !is_numeric($companyId)) {
        $errorArray[] = "Invalid Company ID provided.";
    } else {
      //get company data
      $companyObj = new CompanyModel();
      $company = $companyObj->getOne("com_id = '{$companyId}'");
      if (empty($company)) {
        $errorArray[] = "Company not found.";   
      }
    }

    //redirect edit user page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/company/viewcompany",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "company" => $company
      ]
    );
    exit;
  }

  //validata company inputs
  private function _validateCompanyInputs($formData)
  {

    $errorArray = array();

    //unique company name validation 
    if (!empty($formData['com_name'])) {
      $companyObj = new CompanyModel();

      if (!empty($formData['com_id'])) {
        $companyArray = $companyObj->getOne("com_name = '{$formData['com_name']}' AND com_id != {$formData['com_id']}");
      } else {
        $companyArray = $companyObj->getOne("com_name = '{$formData['com_name']}'");
      }

      if (!empty($companyArray) && count($companyArray) > 0) {
        $errorArray[] = "Company name already exist";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
}
