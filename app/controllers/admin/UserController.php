<?php
/* ======================================
  Filename: UserController
  Author: Elavarasan 
  Description: Add / Edit / Update Users
  Updated By: Ameen on 17-07-2025
  =======================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\UserModel;
use app\models\DepartmentModel;
use app\models\RoleModel;
use core\View as View;
use app\controllers\CommonController;
use Exception;



class UserController extends Controller
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
        header("Location: users"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['user']['filters']['name'] = @trim($_GET['name']) ?? '';
      $_SESSION['user']['filters']['department'] = @trim($_GET['department']) ?? '';
      $_SESSION['user']['filters']['role'] = @trim($_GET['role']) ?? '';
      $_SESSION['user']['filters']['status'] = @trim($_GET['status']) ?? '';
    }

    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['name']) && empty($_GET['department']) && empty($_GET['role']) && empty($_GET['status'])) {
        $setSearchError = true;
      }
    }

    //get departments    
    $_Adepartments = CommonController::getDepartments(1);

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/user/list",
      [
        "page_data" => $page_data,
        "_Adepartments" => $_Adepartments,
        "search_error" => $setSearchError,
      ]
    );
  }

  // Ajax call to get users list
  // This function is called by DataTables to fetch user data
  public function ajaxusers()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $request = $_POST;

      //get list input data
      $draw = intval($request['draw']);
      $start = intval($request['start']);
      $length = intval($request['length']);
      $orderColumnIndex = $request['order'][0]['column']; // e.g., 0
      $orderDirection = $request['order'][0]['dir']; // 'asc' or 'desc'      
      $searchValue = $request['search']['value'];
      $search     = $request['name'];
      $department = $request['department'];
      $role       = $_SESSION['user']['filters']['role'];
      $status     = $request['status'];

      //set column mapping 
      $columns = ['u.usr_id', 'u.usr_created_on', 'u.usr_fname', 'u.usr_email', 'u.usr_mobile', 'd.dep_name', 'r.role_name'];
      $orderColumnName = $columns[$orderColumnIndex]; // e.g., usr_id

      // Join tables
      Model::$db->join("es_departments d", "d.dep_id = u.usr_department", "LEFT");
      Model::$db->join("es_roles r", "r.role_id = u.usr_role", "LEFT");

      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("es_users u", "count(*)");
      if (!empty($searchValue)) {
        Model::$db->where(
          "(u.usr_fname LIKE ? OR u.usr_lname LIKE ? OR u.usr_email LIKE ?)",
          ["%$searchValue%", "%$searchValue%", "%$searchValue%"]
        );
      }

      // Apply search
      if (!empty($search)) {
        Model::$db->where(
          "(u.usr_fname LIKE ? OR u.usr_lname LIKE ? OR u.usr_email LIKE ?)",
          ["%$search%", "%$search%", "%$search%"]
        );
      }
      if (!empty($department)) {
        Model::$db->where('u.usr_department', $department);
      }
      if (!empty($role)) {
        Model::$db->where('u.usr_role', $role);
      }
      if (!empty($status)) {
        Model::$db->where('u.usr_status', $status);
      }


      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("es_users u", "count(*)");

      // Pagination
      //Model::$db->orderBy("u.usr_id", "desc");
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $users = Model::$db->paginate("es_users u", ($start / $length) + 1);

      $data = [];
      foreach ($users as $row) {
        $statusLabel = '';
        if ($row['usr_status'] == 1) {
          $statusLabel = '<label class="badge badge-success">Active</label>';
        } elseif ($row['usr_status'] == 2) {
          $statusLabel = '<label class="badge badge-warning">Inactive</label>';
        } elseif ($row['usr_status'] == 3) {
          $statusLabel = '<label class="badge badge-danger">Deleted</label>';
        }

        $data[] = [
          'usr_id' => $row['usr_id'],
          'created_on' => date('d-m-Y H:i', strtotime($row['usr_created_on'])),
          'full_name' => $row['usr_fname'] . ' ' . $row['usr_lname'],
          'usr_email' => $row['usr_email'],
          'dep_name' => $row['dep_name'] ?? '',
          'role_name' => $row['role_name'] ?? '',
          'status_label' => $statusLabel,
          //'actions' => '<a href="' . BASE_URL . 'edituser/' . $row['usr_id'] . '" class="btn btn-outline-primary btn-sm">Edit</a>'
          'actions' => '
                        <div class="d-flex gap-2">
                          <a href="' . BASE_URL . 'viewuser/' . $row['usr_id'] . '" title="view" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'edituser/' . $row['usr_id'] . '" title="Edit" style="text-decoration: none;">
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

  // Function to render the add user form
  // This function is called when the user clicks on "Add User" button
  public function adduser($route)
  {

    //get departments    
    $_Adepartments = CommonController::getDepartments(1);

    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/user/adduser",
      [
        "page_data" => $page_data,
        "_Adepartments" => $_Adepartments,
      ]
    );
  }

  // Function to render the edit user form
  // This function is called when the user clicks on "Edit" button
  // It fetches the user data based on the user ID passed in the route  
  public function edituser($route)
  {

    //initialize variables
    $errorArray = [];
    $_Ausers =  [];

    //get departments    
    $_Adepartments = CommonController::getDepartments(1);

    //validate user id
    $_userid = $route['uri'][1];
    if (empty($_userid) || !is_numeric($_userid)) {
      $errorArray[] = "Invalid User ID provided.";
    } else {
      //get user data
      $this->_OuserModel = new UserModel();
      $_Ausers = $this->_OuserModel->getOne("usr_id = '{$_userid}'");
      if (empty($_Ausers)) {
        $errorArray[] = "User not found.";
      }
    }

    //redirect edit user page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/user/adduser",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_Adepartments" => $_Adepartments,
        "_user" => $_Ausers,
      ]
    );
    exit;
  }

  // Function to store or update user data
  // This function is called when the user submits the add/edit form
  public function storeuser($route)
  {

    $post_data = $_POST;

    $_Adepartments = CommonController::getDepartments(1);
    $_Acountries = CommonController::getAllCountries(1);

    //validate inputs
    $errorArray = $this->_validateUserInputs($post_data);

    if (!$errorArray) {
      //db process
      $this->_OuserModel = new UserModel();

      // If usr_id is set, it means we are updating an existing user
      if (isset($post_data['usr_id']) && !empty($post_data['usr_id'])) {

        $profileUpdate = false;
        if (isset($post_data['profile_update']) && $post_data['profile_update'] == 1) {
          $profileUpdate = true;
          unset($post_data['profile_update']);
        }

        //update process
        $whereUpdate["usr_id"] = $post_data['usr_id'];
        $hashedPassword = password_hash($post_data['usr_password'], PASSWORD_DEFAULT);
        $post_data['usr_enc_password'] =  $hashedPassword;
        $post_data['usr_updated_by'] = $_SESSION['auth']['user_id'];
        $post_data['usr_updated_on'] = date('Y-m-d H:i:s');

        $res =  $this->_OuserModel->update($post_data, $whereUpdate);
        if ($res) {
          // If update is successful, set a success message
          $_SESSION['user']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Updated successfully!'
          ];

          if (isset($profileUpdate)) {
            $redirectLocation = "viewprofile/" . $post_data['usr_id'];
            header("Location: " . $redirectLocation);
          } else {
            header("Location: users");
          }
          exit;
        } else {
          // If update fails, set an error message   
          $errorArray[] = "Failed to update user. Please try again.";
        }
      } else {
        //insert process
        //set default values
        $hashedPassword = password_hash($post_data['usr_password'], PASSWORD_DEFAULT);
        $post_data['usr_enc_password'] =  $hashedPassword;
        $post_data['usr_created_by'] = $_SESSION['auth']['user_id'];
        $post_data['usr_updated_by'] = $_SESSION['auth']['user_id'];
        $post_data['usr_last_login'] = date('Y-m-d H:i:s');
        $post_data['usr_updated_on'] = date('Y-m-d H:i:s');

        $res =  $this->_OuserModel->insert($post_data);
        if ($res) {
          // If insert is successful, set a success message
          $_SESSION['user']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'User registered successfully!'
          ];
          header("Location: users");
          exit;
        } else {
          // If insert fails, set an error message   
          $errorArray[] = "Failed to register user. Please try again.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/user/adduser",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "_Adepartments" => $_Adepartments,
          "_user" => $post_data,
        ]
      );
      exit;
    }
  }

  // Function to view user details
  // This function is called when the user clicks on "View" button
  public function viewuser($route)
  {

    //initialize variables
    $errorArray = [];
    $_Ausers =  [];

    //get departments    
    $_Adepartments = CommonController::getDepartments(1);
    //get countries    
    $_Acountries = CommonController::getAllCountries(1);

    //validate user id
    $_userid = $route['uri'][1];
    if (empty($_userid) || !is_numeric($_userid)) {
      $errorArray[] = "Invalid User ID provided.";
    } else {
      //get user data
      $this->_OuserModel = new UserModel();
      $_Ausers = $this->_OuserModel->getOne("usr_id = '{$_userid}'");
      if (empty($_Ausers)) {
        $errorArray[] = "User not found.";
      }
    }

    //redirect edit user page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/user/viewuser",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_Adepartments" => $_Adepartments,
        "_Acountries" => $_Acountries,
        "_user" => $_Ausers,
      ]
    );
    exit;
  }

  //validata user inputs
  private function _validateUserInputs($formData)
  {

    $errorArray = array();

    //unique email validation 
    if (!empty($formData['usr_email'])) {
      $_OuserModel = new UserModel();

      if (!empty($formData['usr_id'])) {
        $_Auser = $_OuserModel->getOne("usr_email = '{$formData['usr_email']}' AND usr_id != {$formData['usr_id']}");
      } else {
        $_Auser = $_OuserModel->getOne("usr_email = '{$formData['usr_email']}'");
      }

      if (!empty($_Auser) && count($_Auser) > 0) {
        $errorArray[] = "Email already exist";
      }
    }

    //unique mobile validation 
    if (!empty($formData['usr_countrycode']) && !empty($formData['usr_mobile'])) {
      $_OuserModel = new UserModel();

      if (!empty($formData['usr_id'])) {
        $_Auser = $_OuserModel->getOne("usr_countrycode = '{$formData['usr_countrycode']}' AND usr_mobile = '{$formData['usr_mobile']}' AND usr_id != {$formData['usr_id']}");
      } else {
        $_Auser = $_OuserModel->getOne("usr_countrycode = '{$formData['usr_countrycode']}' AND usr_mobile = '{$formData['usr_mobile']}'");
      }


      if (!empty($_Auser) && count($_Auser) > 0) {
        $errorArray[] = "Mobile number already exist";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }

  //function to view show password change from
  public function viewchangePassword($route)
  {

    //initialize variables
    $errorArray = [];
    $_Ausers =  [];

    //validate user id
    $_userid = $route['uri'][1];
    if (empty($_userid) || !is_numeric($_userid)) {
      $errorArray[] = "Invalid User ID provided.";
    } else {
      //get user data
      $this->_OuserModel = new UserModel();
      $_Ausers = $this->_OuserModel->getOne("zlu_id = '{$_userid}'");
      if (empty($_Ausers)) {
        $errorArray[] = "User not found.";
      }
    }

    //redirect edit user page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/user/changepassword",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_user" => $_Ausers,
      ]
    );
    exit;
  }

  public function updatePassword($route)
  {

    //initialize variable
    $post_data = $_POST;
    $errorArray = [];

    $errorArray = $this->_validateCpasswordInputs($post_data);

    if (!$errorArray) {
      //get user data
      if (!empty($post_data['usr_id'])) {
        $userId = $post_data['usr_id'];
        $this->_OuserModel = new UserModel();
        $userArray = $this->_OuserModel->getOne("usr_id = '{$userId}'");
        if (is_array($userArray) && count($userArray) > 0) {
          //check old passwords are same
          if ($userArray['usr_password'] != $post_data['old_pass']) {
            $errorArray[] = "Please provide a valid old password";
          } else {
            //update password
            //update process

            $ipData=[];

            $whereUpdate["usr_id"] = $post_data['usr_id'];
            $hashedPassword = password_hash($post_data['new_pass'], PASSWORD_DEFAULT);
            $ipData['usr_enc_password'] =  $hashedPassword;
            $ipData['usr_password'] =  $post_data['new_pass'];
            $ipData['usr_updated_by'] = $_SESSION['auth']['user_id'];
            $ipData['usr_updated_on'] = date('Y-m-d H:i:s');

            $res =  $this->_OuserModel->update($ipData, $whereUpdate);
            if ($res) {
              // If update is successful, set a success message
              $_SESSION['password']['flash'] = [
                'type' => 'success', // or 'error', 'warning'
                'message' => 'password updated successfully!'
              ];
              $redirectLocation = "viewpassword/" . $post_data['usr_id'];
              header("Location: " . $redirectLocation);
              exit;
            } else {
              // If update fails, set an error message   
              $errorArray[] = "Failed to update password. Please try again.";
            }
          }
        } else {
          $errorArray[] = "Invaild user id reference";
        }
      } else {
        $errorArray[] = "Empty user id reference";
      }
    }

    // echo "<pre>";
    // print_r($post_data);
    // exit;

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/user/changepassword",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "_user" => $post_data,
        ]
      );
      exit;
    }
  }

  private function _validateCpasswordInputs($formData)
  {
    $errorArray = [];

    if (empty($formData['old_pass'])) {
      $errorArray[] = "Empty old password reference";
    }

    if (empty($formData['new_pass'])) {
      $errorArray[] = "Empty new password reference";
    }

    if (empty($formData['confirm_new_pass'])) {
      $errorArray[] = "Empty confirm new password reference";
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
}
