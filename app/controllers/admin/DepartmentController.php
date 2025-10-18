<?php
/* ======================================
  Filename: DepartmentController
  Author: Ameen 
  Description: List / Add / Edit / Update Departments
  =======================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\DepartmentModel;
use core\View as View;
use app\controllers\CommonController;
use Exception;



class DepartmentController extends Controller
{

  public function __construct()
  {
      //Initialize the model object
  }

  // Function to render the department list page
  // This function is called when the user navigates to the departments page
  public function home($route)
  {

    $setSearchError = false;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      //if reset clear inputs
      if (isset($_GET['reset'])) {
        unset($_SESSION['filters']);
        header("Location: departments"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['department']['filters']['name'] = @trim($_GET['name']) ?? '';
      $_SESSION['department']['filters']['status'] = @trim($_GET['status']) ?? '';
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
      "admin/department/list",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
      ]
    );
  }

  // Ajax call to get department list
  // This function is called by DataTables to fetch department data
  public function ajaxdepartments()
  {



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $request = $_POST;

      //get list input data
      $draw = intval($request['draw']);
      $start = intval($request['start']);
      $length = intval($request['length']);
      $orderColumnIndex = $request['order'][0]['column']; // e.g., 0
      $orderDirection = $request['order'][0]['dir']; // 'asc' or 'desc'      
      $search     = $request['name'];
      $status     = $request['status'];

      //set column mapping 
      $columns = ['d.dep_id', 'd.dep_created_on', 'd.dep_name', 'd.dep_status '];
      $orderColumnName = $columns[$orderColumnIndex]; 


      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("es_departments d", "count(*)");

      // Apply search
      if (!empty($search)) {
        Model::$db->where('d.dep_name', "%$search%", 'LIKE');
      }
      if (!empty($status)) {
        Model::$db->where('d.dep_status', $status);
      }


      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("es_departments d", "count(*)");

      // Pagination
      //Model::$db->orderBy("u.usr_id", "desc");
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $departments = Model::$db->paginate("es_departments d", ($start / $length) + 1);      
      //echo "<pre>";print_r($departments);exit;

      // If no records found, return empty data
      if (empty($departments)) {
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
      foreach ($departments as $row) {
        $statusLabel = '';
        if ($row['dep_status'] == 1) {
          $statusLabel = '<label class="badge badge-success">Active</label>';
        } elseif ($row['dep_status'] == 2) {
          $statusLabel = '<label class="badge badge-warning">Inactive</label>';
        } elseif ($row['dep_status'] == 3) {
          $statusLabel = '<label class="badge badge-danger">Deleted</label>';
        }

        $data[] = [
          'dep_id' => $row['dep_id'],
          'dep_created_on' => date('d-m-Y H:i', strtotime($row['dep_created_on'])),
          'dep_name' => $row['dep_name'],
          'dep_status' => $statusLabel,
          'actions' => '
                        <div class="d-flex gap-2">
                          <a href="' . BASE_URL . 'viewdepartment/' . $row['dep_id'] . '" title="view" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'editdepartment/' . $row['dep_id'] . '" title="Edit" style="text-decoration: none;">
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

  // Function to render the add department form
  // This function is called when the user clicks on "Add Department" button
  public function adddepartment($route)
  {
    //initialize variables
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/department/adddepartment",
      [
        "page_data" => $page_data
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
      "admin/department/adddepartment",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_department" => $_Adepartments,
      ]
    );
    exit;
  }

  // Function to store or update department data
  public function storedepartment($route)
  {

    $post_data = $_POST;

    //validate inputs
    $errorArray = $this->_validateUserInputs($post_data);

    if (!$errorArray) {
      //db process
      $this->_OdepartmentModel = new DepartmentModel();

      // If dep_id is set, it means we are updating an existing department
      if (isset($post_data['dep_id']) && !empty($post_data['dep_id'])) {
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
      } else {
        //insert process
        //set default values        
        $post_data['dep_created_by'] = $_SESSION['auth']['user_id'];
        $post_data['dep_updated_by'] = $_SESSION['auth']['user_id'];

      
        $res =  $this->_OdepartmentModel->insert($post_data);

        if ($res) {
          // If insert is successful, set a success message
          $_SESSION['department']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Department added successfully!'
          ];
          header("Location: departments");
          exit;
        } else {
          // If insert fails, set an error message   
          $errorArray[] = "Failed to add department. Please try again.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/department/adddepartment",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "_department" => $post_data,
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
      "admin/department/viewdepartment",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_department" => $_Adepartments,
      ]
    );
    exit;

  }

  //validata user inputs
  private function _validateUserInputs($formData)
  {

    $errorArray = array();

    //department name unique validation 
    if (!empty($formData['dep_name'])) {
      $_OdepModel = new DepartmentModel();

      if (!empty($formData['dep_id'])) {
        $_departments = $_OdepModel->getOne("dep_name = '{$formData['dep_name']}' AND dep_id != {$formData['dep_id']}");
      } else {
        $_departments = $_OdepModel->getOne("dep_name = '{$formData['dep_name']}'");
      }

      if (!empty($_departments) && count($_departments) > 0) {
        $errorArray[] = "Department name already exist";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
}
