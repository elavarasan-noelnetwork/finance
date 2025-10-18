<?php
/* ======================================
  Filename: RoleController
  Author: Ameen 
  Description: List / Add / Edit / Update roles
  =======================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\DepartmentModel;
use app\models\RoleModel;
use core\View as View;
use app\controllers\CommonController;
use app\models\RoleMenuModel;
use app\models\RolePageModel;
use Exception;



class RoleController extends Controller
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
        header("Location: roles"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['role']['filters']['name'] = @trim($_GET['name']) ?? '';
      $_SESSION['role']['filters']['department'] = @trim($_GET['department']) ?? '';
      $_SESSION['role']['filters']['status'] = @trim($_GET['status']) ?? '';
    }

    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['name']) && empty($_GET['department']) && empty($_GET['status'])) {
        $setSearchError = true;
      }
    }

    $_Adepartments = CommonController::getDepartments(1);

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/role/listrole",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
        "_Adepartments" => $_Adepartments,
      ]
    );
  }

  // Ajax call to get role list
  // This function is called by DataTables to fetch role data
  public function ajaxroles()
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
      $department     = $request['department'];

      //set column mapping 
      $columns = ['r.role_id', 'r.role_created_on', 'd.dep_name', 'r.role_name', 'r.role_status'];
      $orderColumnName = $columns[$orderColumnIndex];

      // Join tables
      Model::$db->join("es_departments d", "d.dep_id = r.role_dep_id", "LEFT");

      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("es_roles r", "count(*)");

      // Apply search
      if (!empty($search)) {
        Model::$db->where('r.role_name', "%$search%", 'LIKE');
      }
      if (!empty($department)) {
        Model::$db->where('r.role_dep_id', $department);
      }
      if (!empty($status)) {
        Model::$db->where('r.role_status', $status);
      }


      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("es_roles r", "count(*)");

      // Pagination
      //Model::$db->orderBy("u.usr_id", "desc");
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $roles = Model::$db->paginate("es_roles r", ($start / $length) + 1);

      // Prepare data for DataTables
      $data = [];
      if (!empty($roles) && count($roles) > 0) {
        foreach ($roles as $row) {
          $statusLabel = '';
          if ($row['role_status'] == 1) {
            $statusLabel = '<label class="badge badge-success">Active</label>';
          } elseif ($row['role_status'] == 2) {
            $statusLabel = '<label class="badge badge-warning">Inactive</label>';
          }

          $data[] = [
            'role_id' => $row['role_id'],
            'role_created_on' => CommonController::formatDisplayDate(@$row['role_created_on']),
            'role_department' => $row['dep_name'],
            'role_name' => $row['role_name'],
            'role_status' => $statusLabel,
            'actions' => '
                        <div class="d-flex gap-2">
                          <a href="' . BASE_URL . 'viewrole/' . $row['role_id'] . '" title="view" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'editrole/' . $row['role_id'] . '" title="Edit" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-edit" style="font-size: 18px;"></i>
                            </button>                      
                          </a>         
                          
                          <a href="#" title="Delete" style="text-decoration: none;" onclick="showSwal(\'delete\')">                          
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-trash" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'viewrolemenu/' . $row['role_id'] . '" title="Assign menu" style="text-decoration: none;">                          
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-tick" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'viewpageacess/' . $row['role_id'] . '" title="Assign page" style="text-decoration: none;">                          
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-cog" style="font-size: 18px;"></i>
                            </button>                      
                          </a>                          

                        </div>                             
                        '
          ];
        }
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

  // Function to render the add role form
  // This function is called when the user clicks on "Add Role" button
  public function addrole($route)
  {
    $departmentArray = CommonController::getDepartments(1);

    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/role/addrole",
      [
        "page_data" => $page_data,
        "_Adepartments" => $departmentArray,
      ]
    );
  }

  // Function to render the edit role form
  // This function is called when the user clicks on "Edit" button
  // It fetches the role data based on the role ID passed in the route  
  public function editrole($route)
  {

    //initialize variables
    $errorArray = [];
    $roleArray =  [];
    $departmentArray = CommonController::getDepartments(1);

    //validate user id
    $roleId = $route['uri'][1];
    if (empty($roleId) || !is_numeric($roleId)) {
      $errorArray[] = "Invalid role ID provided.";
    } else {
      //get department data
      $roleModelObj = new RoleModel();
      $roleArray = $roleModelObj->getOne("role_id = '{$roleId}'");
      if (empty($roleArray)) {
        $errorArray[] = "Role not found.";
      }
    }

    //redirect edit department page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/role/addrole",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_Adepartments" => $departmentArray,
        "_role" => $roleArray,
      ]
    );
    exit;
  }

  // Function to store or update role data
  public function storerole($route)
  {

    $post_data = $_POST;
    $departmentArray = CommonController::getDepartments(1);

    //validate inputs
    $errorArray = $this->_validateUserInputs($post_data);


    if (!$errorArray) {

      //db process
      $roleModelObj = new RoleModel();

      // If role_id is set, it means we are updating an existing department
      if (isset($post_data['role_id']) && !empty($post_data['role_id'])) {
        //update process
        $whereUpdate["role_id"] = $post_data['role_id'];
        $post_data['role_updated_by'] = $_SESSION['auth']['user_id'];
        $post_data['role_updated_on'] = date('Y-m-d H:i:s');

        $res =  $roleModelObj->update($post_data, $whereUpdate);
        if (is_bool($res)) {
          // If update is successful, set a success message
          $_SESSION['department']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Role updated successfully!'
          ];
          header("Location: roles"); // redirect to roles list
          exit;
        } else {
          // If update fails, set an error message   
          $errorArray[] = "Failed to update role. Please try again.";
        }
      } else {
        //insert process
        //set default values
        //get department name 
        $ipKeyDep=CommonController::getDepartmentNameById($post_data['role_dep_id']);
        $ipKeyRole=$post_data['role_name'];
        $ipRoleKey = preg_replace('/\s+/', '_', trim(strtolower($ipKeyDep)))."_".preg_replace('/\s+/', '_', strtolower(trim($ipKeyRole)));
        
        $post_data['role_key'] = $ipRoleKey;
        $post_data['role_created_by'] = $_SESSION['auth']['user_id'];
        $post_data['role_updated_by'] = $_SESSION['auth']['user_id'];

        $res =  $roleModelObj->insert($post_data);

        if (is_numeric($res)) {
          // If insert is successful, set a success message
          $_SESSION['role']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Role added successfully!'
          ];
          header("Location: roles");
          exit;
        } else {
          // If insert fails, set an error message   
          $errorArray[] = "Failed to add role. Please try again.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/role/addrole",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "_Adepartments" => $departmentArray,
          "_role" => $post_data,
        ]
      );
      exit;
    }
  }

  // Function to view role details
  // This function is called when the user clicks on "View" button
  public function viewrole($route)
  {

    //initialize variables
    $errorArray = [];
    $roleArray =  [];
    $departmentArray = CommonController::getDepartments(1);

    //validate role id
    $roleId = $route['uri'][1];
    if (empty($roleId) || !is_numeric($roleId)) {
      $errorArray[] = "Invalid role ID provided.";
    } else {
      //get role data
      $roleModelObj = new RoleModel();
      $roleArray = $roleModelObj->getOne("role_id = '{$roleId}'");
      if (empty($roleArray)) {
        $errorArray[] = "Role not found.";
      }
    }

    //redirect edit department page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/role/viewrole",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "_Adepartments" => $departmentArray,
        "_role" => $roleArray,
      ]
    );
    exit;
  }

  // Function to view role menu details
  // This function is called when the user clicks on "View" button
  public function viewrolemenu($route)
  {

    //initialize variables
    $errorArray = [];
    $roleMenuArray =  [];
    $menuArray = [];
    $submitErrorArray = [];
    $roleArray = [];

    //validate role id
    $roleId = $route['uri'][1];
    if (empty($roleId) || !is_numeric($roleId)) {
      $errorArray[] = "Invalid role ID provided.";
    } else {
      //get role data
      $roleModelObj = new RoleModel();
      $roleArray = $roleModelObj->getOne("role_id = '{$roleId}'");
      if (empty($roleArray)) {
        $errorArray[] = "Role not found.";
      }
    }

    //if no error and role id exists then retrieve data
    if (isset($roleId) && count($errorArray) == 0) {
      //reteive menu details
      $menuArray = CommonController::getGetAllMenu();

      //retireve already assigned menus for the role
      $whereRoleMenu['rom_rol_id'] = $roleId;
      $roleMenuModelObj = new RoleMenuModel();
      $roleMenuResultArray = $roleMenuModelObj->get($whereRoleMenu, null, 'rom_menu_id');
      if (isset($roleMenuResultArray) && count($roleMenuResultArray) > 0) {
        foreach ($roleMenuResultArray as $roleMenuResultVal) {
          if (!empty($roleMenuResultVal['rom_menu_id'])) {
            $roleMenuArray[] = $roleMenuResultVal['rom_menu_id'];
          }
        }
      }
    }


    //redirect edit department page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/role/viewrolemenu",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "submitErrorArray" => $submitErrorArray,
        "menuArray" => $menuArray,
        "roleMenuArray" => $roleMenuArray,
        "roleId"  => $roleId,
        "_role" => $roleArray,        
      ]
    );
    exit;
  }

  // Function to view role page acess details
  // This function is called when the user clicks on "settings" icon
  public function viewpageacess($route)
  {

    //initialize variables
    $errorArray = [];
    $submitErrorArray = [];
    $pageArray = [];
    $accessLevelArray =  [];    
    $rolePageArray = [];
    $roleArray = [];


    //validate role id
    $roleId = $route['uri'][1];
    if (empty($roleId) || !is_numeric($roleId)) {
      $errorArray[] = "Invalid role ID provided.";
    } else {
      //get role data
      $roleModelObj = new RoleModel();
      $roleArray = $roleModelObj->getOne("role_id = '{$roleId}'");
      if (empty($roleArray)) {
        $errorArray[] = "Role not found.";
      }
      else{
        //get page data & acess level data
        $pageArray = CommonController::getAllPages(1);
        $accessLevelArray = CommonController::getAllAccessLevels();

        if (count($pageArray) == 0) {      
          $errorArray[] = "Page data not found.";
        }    

        if (count($accessLevelArray) == 0) {      
          $errorArray[] = "Acess Level data not found.";
        }            

      }
    }


    //if no error and role id exists then retrieve data
    if (isset($roleId) && count($errorArray) == 0) {
      //reteive page details
      //retireve already assigned pages for the role
      $whereRolePage['rop_role_id'] = $roleId;
      $rolePageModelObj = new RolePageModel();
      $rolePageResultArray = $rolePageModelObj->get($whereRolePage, null);

      if (isset($rolePageResultArray) && count($rolePageResultArray) > 0) {
        foreach ($rolePageResultArray as $rolePageResultVal) {
          if (!empty($rolePageResultVal['rop_page_id']) && !empty($rolePageResultVal['rop_access_level_id'])) {
            $rolePageArray[$rolePageResultVal['rop_page_id']] = $rolePageResultVal['rop_access_level_id'];
          }
        }
      }
    }

    //redirect edit  page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/role/viewpageacess",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "submitErrorArray" => $submitErrorArray,
        "pageArray" => $pageArray,
        "accessLevelArray" => $accessLevelArray,
        "rolePageArray" => $rolePageArray,
        "roleId"  => $roleId,
        "_role" => $roleArray,        
      ]
    );
    exit;
  }


    //Function to store or update role menu data
  public function storepageacess($route)
  {
    
    $post_data = $_POST;

    //initialize variables
    $errorArray = [];
    $submitErrorArray = [];
    $pageArray = [];
    $accessLevelArray =  [];    
    $rolePageArray = [];
    $roleArray = [];
    $roleId="";

    //set role id
    if (!empty($post_data['role_id'])) {
      $roleId = $post_data['role_id'];
    }

    //validate role id
    if (empty($roleId) || !is_numeric($roleId)) {
      $errorArray[] = "Invalid role ID provided.";
    } else {
      
      //get role data
      $roleModelObj = new RoleModel();
      $roleArray = $roleModelObj->getOne("role_id = '{$roleId}'");
      if (empty($roleArray)) {
        $errorArray[] = "Role not found.";
      } 
      else {
        //start process

        //get page data & acess level data
        $pageArray = CommonController::getAllPages(1);
        $accessLevelArray = CommonController::getAllAccessLevels();

        //delete all pages already assigned for roles
        $wherePageMenuDel['rop_role_id'] = $roleId;
        $rolePageModelObj = new RolePageModel();
        $rolePageDeleteArray = $rolePageModelObj->delete($wherePageMenuDel);
        if ($rolePageDeleteArray){

          // if role have atleast one menu
          if (count($post_data['page_access']) > 0) {
            //insert new menu to the role
            foreach($post_data['page_access'] as $ipPageId => $ipAccessId){
              $dataArray=array();
              $dataArray['rop_role_id']= $roleId;
              $dataArray['rop_page_id']= $ipPageId;
              $dataArray['rop_access_level_id']= $ipAccessId;
              $rolePageModelObj = new RolePageModel();
              $insertResult = $rolePageModelObj->insert($dataArray);
              unset($rolePageModelObj);
            }
            $processSucess = true;
          } else {
            //if all menu revoked
            $processSucess = true;
          }

          // If insert is successful, set a success message
          if ($processSucess) {            
            $_SESSION['role']['flash'] = [
              'type' => 'success', // or 'error', 'warning'
              'message' => 'Pages assigned successfully!'
            ];
            header("Location: roles");
            exit;
          } 
        } 
        else {
              $submitErrorArray[] = "Error while assigned page.";
        }
      }
    }

    //if error redirect to form 
    if (count($errorArray) > 0 || count($submitErrorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/role/viewpageacess",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "submitErrorArray" => $submitErrorArray,
          "pageArray" => $pageArray,
          "accessLevelArray" => $accessLevelArray,
          "rolePageArray" => $rolePageArray,
          "roleId"  => $roleId,
          "_role" => $roleArray,        
        ]
      );
      exit;
    }
  }


  //Function to store or update role menu data
  public function storerolemenu($route)
  {

    $post_data = $_POST;
    $errorArray = [];
    $submitErrorArray = [];
    $menuArray = [];
    $roleId = "";
    $processSucess = false;
    $roleArray = [];

    //set role id
    if (!empty($post_data['role_id'])) {
      $roleId = $post_data['role_id'];
    }

    //validate role id
    if (empty($roleId) || !is_numeric($roleId)) {
      $errorArray[] = "Invalid role ID provided.";
    } else {
      //get role data
      $roleModelObj = new RoleModel();
      $roleArray = $roleModelObj->getOne("role_id = '{$roleId}'");
      if (empty($roleArray)) {
        $errorArray[] = "Role not found.";
      } 
      else {
        //start process
        //delete all menus already assigned for roles
        $whereRoleMenuDel['rom_rol_id'] = $roleId;
        $roleMenuModelObj = new RoleMenuModel();
        $roleMenuDeleteArray = $roleMenuModelObj->delete($whereRoleMenuDel);
        if ($roleMenuDeleteArray) {

          // if role have atleast one menu
          if (count($post_data['menuID']) > 0) {
            $_uniquePostData=array_unique($_POST['menuID']);
            //insert new menu to the role
            foreach($_uniquePostData as $ipMenuId){
              $dataArray=array();
              $dataArray['rom_rol_id']= $roleId;
              $dataArray['rom_menu_id']= $ipMenuId;
              $roleMenuModelObj = new RoleMenuModel();
              $insertResult = $roleMenuModelObj->insert($dataArray);
              unset($roleMenuModelObj);
            }
            $processSucess = true;
          } else {
            //if all menu revoked
            $processSucess = true;
          }

          // If insert is successful, set a success message
          if ($processSucess) {            
            $_SESSION['role']['flash'] = [
              'type' => 'success', // or 'error', 'warning'
              'message' => 'Menus assigned successfully!'
            ];
            header("Location: roles");
            exit;
          } 
        } 
        else {
              $submitErrorArray[] = "Error while assigned menu.";
        }



      }
    }

    //if error redirect to form 
    if (count($errorArray) > 0 || count($submitErrorArray) > 0) {

      //reteive menu details
      $menuArray = CommonController::getGetAllMenu();

      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/role/viewrolemenu",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "submitErrorArray" => $submitErrorArray,
          "menuArray" => $menuArray,
          "roleMenuArray" => $post_data['menuID'],
          "roleId"  => $roleId,
          "_role" => $roleArray, 
        ]
      );
      exit;
    }
  }

  //validata user inputs
  private function _validateUserInputs($formData)
  {

    $errorArray = array();

    //empty validation
    if (empty($formData['role_dep_id'])) {
      $errorArray[] = "Please select the department name";
    }
    if (empty($formData['role_name'])) {
      $errorArray[] = "Please enter the role name";
    }


    //unique validation
    if (!empty($formData['role_dep_id']) && !empty($formData['role_name'])) {

      $roleModelObj = new RoleModel();
      if (!empty($formData['role_id'])) {
        $roleArray = $roleModelObj->getOne("role_dep_id = '{$formData['role_dep_id']}' AND role_name = '{$formData['role_name']}' AND role_id != {$formData['role_id']}");
      } else {
        $roleArray = $roleModelObj->getOne("role_dep_id = '{$formData['role_dep_id']}' AND role_name = '{$formData['role_name']}'");
      }


      if (!empty($roleArray) && count($roleArray) > 0) {
        $errorArray[] = "Role already exist for this department.";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
}
