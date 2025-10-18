<?php
/* ======================================
  Filename: MenuController
  Author: Ameen 
  Description: List / Add / Edit / Update menu
  ==============================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\ServiceModel as ServiceModel;
use core\View as View;
use app\controllers\CommonController;
use app\models\MenuModel;
use Exception;



class MenuController extends Controller
{

  public function __construct()
  {
    //Initialize the model object
  }

  // Function to render the menu list page
  // This function is called when the user navigates to the menu page
  public function home($route)
  {

    //echo "<pre>";print_r($_GET);exit;


    $setSearchError = false;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      //if reset clear inputs
      if (isset($_GET['reset'])) {
        unset($_SESSION['filters']);
        header("Location: menus"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['menu']['filters']['parentMenu'] = @trim($_GET['parentMenu']) ?? '';
      $_SESSION['menu']['filters']['name'] = @trim($_GET['name']) ?? '';
      $_SESSION['menu']['filters']['status'] = @trim($_GET['status']) ?? '';
      $_SESSION['menu']['filters']['menuType'] = @trim($_GET['menuType']) ?? '';
    }



    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['parentMenu']) && empty($_GET['name']) && empty($_GET['status']) && empty($_GET['menuType'])) {
        $setSearchError = true;
      }
    }

    $parentMenuArray = CommonController::getParentMenus(1, 1); // 1 is for backend menu and 1 is for visible menu

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/menu/listmenu",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
        "parentMenus" => $parentMenuArray,
      ]
    );
  }

  // Ajax call to get menu list
  // This function is called by DataTables to fetch menu data
  public function ajaxmenus()
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
      $parentMenu     = $request['parentMenu'];
      $menuType     = $request['menuType'];

      //set column mapping 
      $columns = ['m.men_id', 'm.men_created_on', 'm.men_parent_id ', 'm.men_name', 'm.men_page', 'm.men_sort_order', 'm.men_type', 'm.men_is_after_login', 'm.men_is_visible', 'm.men_status'];
      $orderColumnName = $columns[$orderColumnIndex];

      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("es_menus m", "count(*)");

      // Apply search
      if (!empty($search)) {
        Model::$db->where('m.men_name', "%$search%", 'LIKE');
      }
      if (!empty($parentMenu)) {
        Model::$db->where('m.men_parent_id', $parentMenu);
        Model::$db->orWhere('m.men_id', $parentMenu);
      }
      if (!empty($status)) {
        Model::$db->where('m.men_status', $status);
      }
      if (!empty($menuType)) {
        Model::$db->where('m.men_type', $menuType);
      }

      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("es_menus m", "count(*)");

      // Pagination
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $menus = Model::$db->paginate("es_menus m", ($start / $length) + 1);

      // Prepare data for DataTables
      $data = [];
      if (!empty($menus) && count($menus) > 0) {
        foreach ($menus as $row) {

          $statusLabel = '';
          if ($row['men_status'] == 1) {
            $statusLabel = '<label class="badge badge-success">Active</label>';
          } elseif ($row['men_status'] == 2) {
            $statusLabel = '<label class="badge badge-warning">Inactive</label>';
          }

          $menuType = '';
          if ($row['men_type'] == 1) {
            $menuType = 'Frontend';
          } elseif ($row['men_type'] == 2) {
            $menuType = 'Backend';
          }

          $afterLogin = '';
          if ($row['men_is_after_login'] == 1) {
            $afterLogin = 'Yes';
          } elseif ($row['men_is_after_login'] == 2) {
            $afterLogin = 'No';
          }

          $menuVisible = '';
          if ($row['men_is_visible'] == 1) {
            $menuVisible = 'Yes';
          } elseif ($row['men_is_visible'] == 2) {
            $menuVisible = 'No';
          }

          $data[] = [
            'menu_id' => $row['men_id'] ? $row['men_id'] : '-',
            'menu_created_on' => $row['men_created_on'] ? CommonController::formatDisplayDate($row['men_created_on']) : '-',
            'menu_parent_name' => $row['men_parent_id'] ? CommonController::getMenuNameById($row['men_parent_id']) : '-',
            'menu_name' => $row['men_name'] ? $row['men_name'] : '-',
            'menu_page' => $row['men_page'] ? $row['men_page'] : '-',
            'menu_sort_order' => $row['men_sort_order'] ? $row['men_sort_order'] : '-',
            'menu_type' => $menuType,
            'menu_login' => $afterLogin,
            'menu_visible' => $menuVisible,
            'menu_status' => $statusLabel,
            'actions' => '
                        <div class="d-flex gap-2">
                          <a href="' . BASE_URL . 'viewmenu/' . $row['men_id'] . '" title="view" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'editmenu/' . $row['men_id'] . '" title="Edit" style="text-decoration: none;">
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

  // Function to render the add menu form
  // This function is called when the user clicks on "Add menu" button
  public function addmenu($route)
  {
    $parentMenuArray = CommonController::getParentMenus(1, 1); // 1 is for backend menu and 1 is for visible menu

    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/menu/addmenu",
      [
        "page_data" => $page_data,
        "parentMenus" => $parentMenuArray,
        "menudata" => [],
      ]
    );
  }

  // Function to render the edit menu form
  // This function is called when the user clicks on "Edit" button
  // It fetches the menu data based on the menu ID passed in the route  
  public function editmenu($route)
  {

    //initialize variables
    $errorArray = [];
    $menuArray =  [];
    $parentMenuArray = CommonController::getParentMenus(1, 1); // 1 is for backend menu and 1 is for visible menu

    //validate service id
    $menuId = $route['uri'][1];

    if (empty($menuId) || !is_numeric($menuId)) {
      $errorArray[] = "Invalid menu ID provided.";
    } else {
      //get menu data
      $menuModelObj = new MenuModel();
      $menuArray = $menuModelObj->getOne("men_id = '{$menuId}'");
      if (empty($menuArray)) {
        $errorArray[] = "menu not found.";
      }
    }

    //redirect edit menu page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/menu/addmenu",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "parentMenus" => $parentMenuArray,
        "menu" => $menuArray,
      ]
    );
    exit;
  }

  // Function to store or update menu data
  public function storemenu($route)
  {

    $post_data = $_POST;
    $parentMenuArray = CommonController::getParentMenus(1, 1); // 1 is for backend menu and 1 is for visible menu
    if (empty($post_data['men_parent_id'])) {
      $post_data['men_parent_id'] = 0; //set default parent id
    }

    $errorArray = $this->_validateUserInputs($post_data);

    if (!$errorArray) {

      //db process
      $menuModelObj = new MenuModel();

      // If men_id is set, it means we are updating an existing department
      if (isset($post_data['men_id']) && !empty($post_data['men_id'])) {

        //update process
        $whereUpdate["men_id"] = $post_data['men_id'];
        $post_data['men_updated_by'] = $_SESSION['auth']['user_id'];
        $post_data['men_updated_on'] = date('Y-m-d H:i:s');

        $res =  $menuModelObj->update($post_data, $whereUpdate);

        if (is_bool($res)) {
          // If update is successful, set a success message
          $_SESSION['menu']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Menu updated successfully!'
          ];
          header("Location: menus"); // redirect to roles list
          exit;
        } else {
          // If update fails, set an error message   
          $errorArray[] = "Failed to update menu. Please try again.";
        }
      } else {


        //insert process
        //set default values        
        $post_data['men_created_by'] = $_SESSION['auth']['user_id'];
        $post_data['men_updated_by'] = $_SESSION['auth']['user_id'];

        $res =  $menuModelObj->insert($post_data);

        if (is_numeric($res)) {
          // If insert is successful, set a success message
          $_SESSION['menu']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Menu added successfully!'
          ];
          header("Location: menus");
          exit;
        } else {
          // If insert fails, set an error message   
          $errorArray[] = "Failed to add menu. Please try again.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/menu/addmenu",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "parentMenus" => $parentMenuArray,
          "menu" => $post_data,
        ]
      );
      exit;
    }
  }

  // Function to view menu details
  // This function is called when the user clicks on "View" button
  public function viewmenu($route)
  {

    //initialize variables
    $errorArray = [];
    $menuArray =  [];
    $parentMenuArray = CommonController::getParentMenus(1, 1); // 1 is for backend menu and 1 is for visible menu

    //validate service id
    $menuId = $route['uri'][1];

    if (empty($menuId) || !is_numeric($menuId)) {
      $errorArray[] = "Invalid menu ID provided.";
    } else {
      //get menu data
      $menuModelObj = new MenuModel();
      $menuArray = $menuModelObj->getOne("men_id = '{$menuId}'");
      if (empty($menuArray)) {
        $errorArray[] = "menu not found.";
      }
    }

    //redirect edit menu page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/menu/viewmenu",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "parentMenus" => $parentMenuArray,
        "menu" => $menuArray,
      ]
    );
    exit;    
    
  }

  //validata user inputs
  private function _validateUserInputs($formData)
  {
    //initialize error array
    $errorArray = array();

    //empty validation
    if (empty($formData['men_name'])) {
      $errorArray[] = "Please enter the menu name";
    }
    if (empty($formData['men_sort_order'])) {
      $errorArray[] = "Please enter the sort order";
    }

    //unique validation
    if (!empty($formData['men_name'])) {

      $parentIdValue = 0;
      if (!empty($formData['men_parent_id'])) {
        $parentIdValue = $formData['men_parent_id'];
      }

      $menuModelObj = new MenuModel();
      if (!empty($formData['men_id'])) {
        $menuArray = $menuModelObj->getOne("men_parent_id = {$parentIdValue} AND men_name = '{$formData['men_name']}' AND men_id != {$formData['men_id']}");
      } else {
        $menuArray = $menuModelObj->getOne("men_parent_id = {$parentIdValue} AND men_name = '{$formData['men_name']}'");
      }

      if (!empty($menuArray) && count($menuArray) > 0) {
        $errorArray[] = "Menu already exist";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
}
