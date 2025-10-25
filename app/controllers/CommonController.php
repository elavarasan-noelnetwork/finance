<?php
/* ======================================
  Filename: CommonController
  Author: Ameen 
  Description: common controller for all reusable functions
  Common fuction GetIcon added by Elavarasn
  =======================================
*/

namespace app\controllers;

use app\models\RoleMenuModel as RoleMenuModel;
use app\models\RoleModel as RoleModel;
use app\models\DepartmentModel;
use app\models\CountryModel;
use app\models\UserModel as UserModel;
use app\models\MenuModel as MenuModel;
use app\models\PageModel as PageModel;
use app\models\AcessLevelModel as AcessLevelModel;
use app\models\CompanyModel as CompanyModel;
use core\View as View;
use app\models\Model;

//use core\View as View;
//use app\models\UserModel;

class CommonController extends Controller
{


  public function __construct()
  {
    /*
  //Initialize the example model
  $this->model_object = new ExampleModel();
  */
  }

  public function home($route) {}

  public function getRoleBasedBackendMenu($role)
  {
    $backendMenuArray = [];

    // Define the menu items based on the role
    RoleMenuModel::$db->join("es_menus B", "A.rom_menu_id = B.men_id", "LEFT");
    RoleMenuModel::$db->where("A.rom_rol_id", $role);
    RoleMenuModel::$db->where("B.men_type", 2); // 2 is for backend menu
    RoleMenuModel::$db->where("B.men_status", 1); // 1 is for active menu
    RoleMenuModel::$db->where("B.men_is_visible", 1);   // 1 is for visible menu
    RoleMenuModel::$db->orderBy("B.men_sort_order ", "asc");
    $roleMenus = RoleMenuModel::$db->get("es_role_menus A", null);

    //echo "<pre>";
    //print_r($roleMenus);
    //die;  

    if (is_array($roleMenus) && !empty($roleMenus)) {
      foreach ($roleMenus as $menu) {
        if (empty($menu['men_parent_id'])) {
          // If the menu has no parent, add it to the backend menu array
          $backendMenuArray[$menu['men_id']] = $menu;
        }
      }

      // Now, we have a flat array of backend menus with no parents
      // We need to structure it into a hierarchical array
      if (is_array($backendMenuArray) && !empty($backendMenuArray)) {
        // Now, we need to add child menus to their respective parents
        foreach ($roleMenus as $menu) {
          if (!empty($menu['men_parent_id'])) {
            // If the menu has a parent, add it as a child of the parent menu
            if (isset($backendMenuArray[$menu['men_parent_id']])) {
              // If the parent menu already exists, add the child to it
              $backendMenuArray[$menu['men_parent_id']]['sub_menu'][] = $menu;
            }
          }
        }
      }
    }
    return $backendMenuArray;
  }

  public static function getGetAllMenu($menuType = "", $menuStatus = "", $menuVisible = "", $menuSortOrder = "asc")
  {

    $menuArray = [];
    if (!empty($menuType)) {
      RoleMenuModel::$db->where("m.men_type", 2); // 2 is for backend menu
    }
    if (!empty($menuStatus)) {
      RoleMenuModel::$db->where("m.men_status", 1); // 1 is for active menu
    }
    if (!empty($menuVisible)) {
      RoleMenuModel::$db->where("m.men_is_visible", 1);   // 1 is for visible menu
    }
    if (!empty($menuSortOrder)) {
      RoleMenuModel::$db->orderBy("m.men_sort_order ", $menuSortOrder);
    }

    $menusResultArray = RoleMenuModel::$db->get("es_menus m", null);

    if (is_array($menusResultArray) && !empty($menusResultArray)) {
      foreach ($menusResultArray as $menu) {
        if (empty($menu['men_parent_id'])) {
          // If the menu has no parent, add it to the backend menu array
          $menuArray[$menu['men_id']] = $menu;
        }
      }

      // Now, we have a flat array of backend menus with no parents
      // We need to structure it into a hierarchical array
      if (is_array($menuArray) && !empty($menuArray)) {
        // Now, we need to add child menus to their respective parents
        foreach ($menusResultArray as $menu) {
          if (!empty($menu['men_parent_id'])) {
            // If the menu has a parent, add it as a child of the parent menu
            if (isset($menuArray[$menu['men_parent_id']])) {
              // If the parent menu already exists, add the child to it
              $menuArray[$menu['men_parent_id']]['sub_menu'][] = $menu;
            }
          }
        }
      }
    }
    return $menuArray;
  }


  public static function getAllPages(?int $pageStatus = null, string $pageSortOrder = "asc")
  {

    $pageArray = [];
    if (!empty($pageStatus)) {
      PageModel::$db->where("p.pag_status", 1); // 1 is for active menu
    }
    if (!empty($pageSortOrder)) {
      PageModel::$db->orderBy("p.pag_sort_order ", $pageSortOrder);
    }

    $pageResultArray = PageModel::$db->get("es_pages p", null);

    if (is_array($pageResultArray) && !empty($pageResultArray)) {
      foreach ($pageResultArray as $page) {
        if (empty($page['pag_parent_id'])) {
          // If the page has no parent, add it to the backend page array
          $pageArray[$page['pag_id']] = $page;
        }
      }

      // Now, we have a flat array of pages with no parents
      // We need to structure it into a hierarchical array
      if (is_array($pageArray) && !empty($pageArray)) {
        // Now, we need to add child pages to their respective parents
        foreach ($pageResultArray as $page) {
          if (!empty($page['pag_parent_id'])) {
            // If the page has a parent, add it as a child of the parent page
            if (isset($pageArray[$page['pag_parent_id']])) {
              // If the parent menu already exists, add the child to it
              $pageArray[$page['pag_parent_id']]['sub_menu'][] = $page;
            }
          }
        }
      }
    }
    return $pageArray;
  }

  //get acess levels
  public static function getAllAccessLevels()
  {
    $acessLevelArray = [];

    $acessResultArray = AcessLevelModel::$db->get("es_access a", null);
    if (is_array($acessResultArray) && !empty($acessResultArray)) {
      foreach ($acessResultArray as $acessLevel) {
        $acessLevelArray[$acessLevel['acs_id']] = $acessLevel;
      }
    }

    return $acessLevelArray;
  }

  //function to get roles based on departments
  public static function getDepartmentRoles()
  {
    global $_SESSION;
    $depId = $_POST['department_id'] ?? 0;
    $SelectedRoleId = $_POST['selected_role_id'] ?? 0;


    if (!empty($depId)) {
      $roles = RoleModel::$db->where("role_dep_id", $depId)
        ->where("role_status", 1)
        ->orderBy("role_name ", "asc")
        ->get("es_roles");

      if (!empty($roles)) {
        foreach ($roles as $role) {

          $selected = "";
          $selectedClass = "";
          if (!empty($SelectedRoleId)) {
            if ($SelectedRoleId == $role['role_id']) {
              $selected = "selected";
              $selectedClass = "class='active'";
            }
          }

          echo '<option value="' . $role['role_id'] . '" ' . $selected . ' ' . $selectedClass . '>' . $role['role_name'] . '</option>';
        }
      } else {
        echo '<option value="">No Roles Found</option>';
      }
    } else {
      echo '<option value="">No Roles Found</option>';
    }
  }

  //Define auth-protected route wrapper
  public static function authRoute($method, $route, $callback)
  {
    if (!isset($_SESSION['auth']['loginstatus']) || $_SESSION['auth']['loginstatus'] !== true) {
      \core\Route::get($route, function () {
        header("Location: /login");
        exit;
      });
    } else {
      $autharizationError = true;
      $authResult = SELF::validateAuthorizaztion();
      if ($authResult) {
        //validate page specific authorization
        $pageSpecificAuthResult = SELF::validatePageSpecificAuthorization();
        if ($pageSpecificAuthResult) {
          $autharizationError = false;
          call_user_func(["core\Route", $method], $route, $callback);
        }
      }

      if ($autharizationError) {
        header("Location: /authorization");
        exit;
      }
    }
  }

  //validate authorization
  public static function validateAuthorizaztion()
  {
    //get current page
    $currentPage = SELF::getCurrentPageName();

    if ($currentPage) {
      if (in_array($currentPage, NON_AUTH_PAGES_ARRAY)) {
        return true;
      } else {
        if (isset($_SESSION['auth']['page_acess'][$currentPage])) {
          if ($_SESSION['auth']['page_acess'][$currentPage] == 1 || $_SESSION['auth']['page_acess'][$currentPage] == 2) {
            return true;
          }
        }
      }
    }
    return false;

    //return true;
  }

  //validate page sepecific authorization
  public static function validatePageSpecificAuthorization()
  {
    //get current page  
    $currentPage = SELF::getCurrentPageName();
    if ($currentPage) {
      if (in_array($currentPage, PAGE_SPECIFIC_AUTH_PAGES_ARRAY)) {

        //code to implement

      } else {
        return true;
      }
    }
    return false;
  }

  //get companies
  public static function getCompanies($compStatus = '')
  {
    $resultArray = [];
    $where = [];

    $companyModelObj = new CompanyModel();
    if (!empty($compStatus)) {
      $where["com_status"] = $compStatus;
    }

    $CompaniesArray  = $companyModelObj->get($where, null, '*', 'com_name');
    if ($CompaniesArray && is_array($CompaniesArray) && count($CompaniesArray) > 0) {
      $resultArray = $CompaniesArray;
    }

    return $resultArray;
  }



  //get department details
  public static function getDepartments($depStatus = '')
  {
    $_Aresult = [];
    $where = [];

    $_OdepartmentModel = new DepartmentModel();
    if (!empty($depStatus)) {
      $where["dep_status"] = $depStatus;
    }

    $_Adepartments  = $_OdepartmentModel->get($where, null, '*', 'dep_name');
    if ($_Adepartments && is_array($_Adepartments) && count($_Adepartments) > 0) {
      $_Aresult = $_Adepartments;
    }

    return $_Aresult;
  }

  //get country details
  public static function getAllCountries($countryStatus = '')
  {
    $_Aresult = [];
    $where = [];

    $_OcountryModel = new CountryModel();
    if (!empty($countryStatus)) {
      $where["cnt_status"] = $countryStatus;
    }

    $_Acountries  = $_OcountryModel->get($where, null, '*', 'cnt_name');
    if ($_Acountries && is_array($_Acountries) && count($_Acountries) > 0) {
      $_Aresult = $_Acountries;
    }

    return $_Aresult;
  }

  //get user name by id
  public static function getUserNameById($userId = '')
  {
    $_Aresult = '';
    if (!empty($userId)) {
      $userModel = new UserModel();
      $where['usr_id'] = $userId;
      $userDetails = $userModel->getOne($where, 'usr_fname, usr_lname');

      if ($userDetails && is_array($userDetails) && count($userDetails) > 0) {
        $_Aresult = trim($userDetails['usr_fname'] . ' ' . $userDetails['usr_lname']);
      }
    }
    return $_Aresult;
  }

  //format display date
  // This function is a placeholder for future implementation
  public static function formatDisplayDate($dateTime = '')
  {
    $formattedDate = '';
    if (!empty($dateTime)) {
      $formattedDate = date("d-m-Y", strtotime($dateTime));
    }
    return $formattedDate;
  }

  //get department name by id
  public static function getDepartmentNameById($department = '')
  {
    $_Aresult = '';
    if (!empty($department)) {
      $departmentModel = new DepartmentModel();
      $where['dep_id'] = $department;
      $departmentDetails = $departmentModel->getOne($where, 'dep_name');

      if ($departmentDetails && is_array($departmentDetails) && count($departmentDetails) > 0) {
        $_Aresult = trim($departmentDetails['dep_name']);
      }
    }
    return $_Aresult;
  }

  //get role name by id
  public static function getRoleNameById($roleId = '')
  {
    $_Aresult = '';
    if (!empty($roleId)) {
      $roleModel = new RoleModel();
      $where['role_id'] = $roleId;
      $roleDetails = $roleModel->getOne($where, 'role_name');

      if ($roleDetails && is_array($roleDetails) && count($roleDetails) > 0) {
        $_Aresult = trim($roleDetails['role_name']);
      }
    }
    return $_Aresult;
  }




  //get parent page details
  public static function getParentPages($pageStatus = '')
  {
    $parenPagesArray = [];
    $where = [];

    $pageModelObj = new PageModel();
    $where["pag_parent_id"] = 0;
    if (!empty($pageStatus)) {
      $where["pag_status"] = $pageStatus;
    }

    $resultArray  = $pageModelObj->get($where, null, '*');

    if ($resultArray && is_array($resultArray) && count($resultArray) > 0) {
      $parenPagesArray = $resultArray;
    }

    return $parenPagesArray;
  }

  

  //get page name by id
  public static function getPageNameById($pageId = '')
  {
    $pageName = '';
    if (!empty($pageId)) {
      $pageModelObj = new PageModel();
      $where['pag_id'] = $pageId;
      $pageDetails = $pageModelObj->getOne($where, 'pag_name');

      if ($pageDetails && is_array($pageDetails) && count($pageDetails) > 0) {
        $pageName = trim($pageDetails['pag_name']);
      }
    }


    return $pageName;
  }

  //get parent menu details
  public static function getParentMenus($menuStatus = '', $menuVisible = '')
  {
    $parenMenuArray = [];
    $where = [];

    $menuModelObj = new MenuModel();
    $where["men_parent_id"] = 0;
    if (!empty($menuStatus)) {
      $where["men_status"] = $menuStatus;
    }
    if (!empty($menuVisible)) {
      $where["men_is_visible"] = $menuVisible;
    }

    $resultArray  = $menuModelObj->get($where, null, '*');

    if ($resultArray && is_array($resultArray) && count($resultArray) > 0) {
      $parenMenuArray = $resultArray;
    }

    return $parenMenuArray;
  }



  //get current page name
  public static function getCurrentPageName($getId = '')
  {
    $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $currentPathParts = explode('/', $currentPath);

    if (!empty($getId)) {
      $currentPageParam = $currentPathParts[1] ?? false;
      return $currentPageParam;
    } else {
      $currentPage = $currentPathParts[0] ?? false; // Assuming the page name is always the second part of the path
      return $currentPage;
    }
  }

  /* getusers Sub function */
  public static function getallusers(string $email = '', int $roll = 0, int $department = 0, int $empType = 0, int $status = 0, int $emailVerified = 0, int $mobileVerified = 0)
  {

    if (!empty($email)) {
      UserModel::$db->where("u.usr_email", $email);
    }
    if (!empty($roll)) {
      UserModel::$db->where("u.usr_role", $roll);
    }
    if (!empty($department)) {
      UserModel::$db->where("u.usr_department", $department);
    }
    if (!empty($empType)) {
      UserModel::$db->where("u.usr_emp_type", $empType);
    }
    if (!empty($status)) {
      UserModel::$db->where("u.usr_status", $status);
    }
    if (!empty($emailVerified)) {
      UserModel::$db->where("u.usr_is_email_verified", $emailVerified);
    }
    if (!empty($mobileVerified)) {
      UserModel::$db->where("u.usr_is_mobile_verified", $mobileVerified);
    }

    $userArray = UserModel::$db->get("es_users u", null);
    return (is_array($userArray) && count($userArray) > 0) ? $userArray : [];
  }



  


  public static function dateConversion($dt)
  {
    if (empty($dt) || $dt === '0000-00-00 00:00:00') return '-';
    try {

      $dt = date('d-m-Y h:iA', strtotime($dt));
      return $dt;
    } catch (\Exception $e) {
      return htmlspecialchars($dt);
    }
  }
  public static function timeConversion($dt)
  {
    if (empty($dt) || $dt === '0000-00-00 00:00:00') return ' ';
    try {

      $dt = date('d-M-Y h:iA', strtotime($dt));
      return $dt;
    } catch (\Exception $e) {
      return htmlspecialchars($dt);
    }
  }

  //format display date
  // This function is a placeholder for future implementation
  //31 auguest 25
  public static function formatDateWithMonthName($dateTime = '')
  {
    $formattedDate = '';
    if (!empty($dateTime)) {
      $formattedDate = date("d M Y", strtotime($dateTime));
    }
    return $formattedDate;
  }

  public static function getRedirectPageName(){
    $redirectPage = 'proposals';
    if(isset($_SESSION['auth']['user_department']) && $_SESSION['auth']['user_department']=='Client'){
      if($_SESSION['auth']['user_application']==1){
        $redirectPage = 'proposals';
      }
      else{
        $redirectPage = 'optin';
      }      
    }
    return $redirectPage;
  }

  


}


