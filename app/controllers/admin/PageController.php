<?php
/* ======================================
  Filename: pageController.php
  Author: Ameen 
  Description: List / Add / Edit / Update pages
  =======================================
*/

namespace app\controllers\admin;

//session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//use your own models 
use app\models\Model;
use app\models\PageModel as PageModel;
use core\View as View;
use app\controllers\CommonController;
use Exception;



class pageController extends Controller
{

  public function __construct()
  {
    //Initialize the model object
  }

  // Function to render the page list page
  // This function is called when the user navigates to the page
  public function home($route)
  {

    $setSearchError = false;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      //if reset clear inputs
      if (isset($_GET['reset'])) {
        unset($_SESSION['filters']);
        header("Location: pages"); // redirect to clear query string
        exit;
      }

      // Store or update session filters
      $_SESSION['page']['filters']['name'] = @trim($_GET['name']) ?? '';
      $_SESSION['page']['filters']['parentService'] = @trim($_GET['parentService']) ?? '';
      $_SESSION['page']['filters']['status'] = @trim($_GET['status']) ?? '';
    }
    
    

    //validate search input
    if (isset($_GET['submit'])) {
      if (empty($_GET['name']) && empty($_GET['parentService']) && empty($_GET['status'])) {
        $setSearchError = true;
      }
    }

    $parentPagesArray = CommonController::getParentPages();

    //render list template
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/page/listpage",
      [
        "page_data" => $page_data,
        "search_error" => $setSearchError,
        "parentpages" => $parentPagesArray,
      ]
    );
  }

  // Ajax call to get pages list
  // This function is called by DataTables to fetch page data
  public function ajaxpages()
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
      $parentService     = $request['parentService'];

      //set column mapping 
      $columns = ['p.pag_id', 'p.pag_created_on','p.pag_parent_id','p.pag_name','p.pag_sort_order','p.pag_status'];
      $orderColumnName = $columns[$orderColumnIndex];


      // Total count without filtering
      $totalRecords = Model::$db->copy()->getValue("es_pages p", "count(*)");

      // Apply search
      if (!empty($search)) {
        Model::$db->where('p.pag_name', "%$search%", 'LIKE');
      }
      if (!empty($parentService)) {
        Model::$db->where('p.pag_parent_id', $parentService);
      }
      if (!empty($status)) {
        Model::$db->where('p.pag_status', $status);
      }

      $filteredDb = Model::$db->copy();
      $totalFiltered = $filteredDb->getValue("es_pages p", "count(*)");

      // Pagination
      Model::$db->orderBy($orderColumnName, $orderDirection);
      Model::$db->pageLimit = $length;
      $pages = Model::$db->paginate("es_pages p", ($start / $length) + 1);

      // Prepare data for DataTables
      $data = [];
      if (!empty($pages) && count($pages) > 0) {
        foreach ($pages as $row) {
          $statusLabel = '';
          if ($row['pag_status'] == 1) {
            $statusLabel = '<label class="badge badge-success">Active</label>';
          } elseif ($row['pag_status'] == 2) {
            $statusLabel = '<label class="badge badge-warning">Inactive</label>';
          }          

          $data[] = [
            'page_id' => $row['pag_id'] ? $row['pag_id'] : '-',
            'page_created_on' => $row['pag_created_on'] ? CommonController::formatDisplayDate($row['pag_created_on']) : '-',
            'page_parent_name' => $row['pag_parent_id'] ? CommonController::getPageNameById($row['pag_parent_id']) : '-',
            'page_name' => $row['pag_name'] ? $row['pag_name'] : '-',
            'page_sort_order' => $row['pag_sort_order'] ? $row['pag_sort_order'] : '-',
            'page_status' => $statusLabel,
            'actions' => '
                        <div class="d-flex gap-2">
                          <a href="' . BASE_URL . 'viewpage/' . $row['pag_id'] . '" title="view" style="text-decoration: none;">
                            <button type="button" class="btn btn-outline-info rounded-circle d-flex align-items-center justify-content-center p-0" style="width: 36px; height: 36px;">
                              <i class="typcn typcn-zoom" style="font-size: 18px;"></i>
                            </button>                      
                          </a>
                          
                          <a href="' . BASE_URL . 'editpage/' . $row['pag_id'] . '" title="Edit" style="text-decoration: none;">
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

  // Function to render the add page form
  // This function is called when the user clicks on "Add Page" button
  public function addpage($route)
  {
    $parentPagesArray = CommonController::getParentPages(1);

    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/page/addpage",
      [
        "page_data" => $page_data,
        "parentpages" => $parentPagesArray,
      ]
    );
  }

  // Function to render the edit page form
  // This function is called when the user clicks on "Edit" button
  // It fetches the role data based on the page ID passed in the route  
  public function editpage($route)
  {

    //initialize variables
    $errorArray = [];
    $pageArray =  [];
    $parentPagesArray = CommonController::getParentPages();

    //validate page id
    $pageId = $route['uri'][1];

    if (empty($pageId) || !is_numeric($pageId)) {
      $errorArray[] = "Invalid page ID provided.";
    } else {
      //get page data
      $pageModelObj = new PageModel();
      $pageArray = $pageModelObj->getOne("pag_id = '{$pageId}'");
      if (empty($pageArray)) {
        $errorArray[] = "Page not found.";
      }
    }

    //redirect edit page page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/page/addpage",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "parentpages" => $parentPagesArray,
        "page" => $pageArray,
      ]
    );
    exit;
  }

  // Function to store or update page data
  public function storepage($route)
  {

    //echo "aaa";
    //exit;

    $post_data = $_POST;
    $parentPagesArray = CommonController::getParentPages();
    if(empty($post_data['pag_parent_id'])){
      $post_data['pag_parent_id']=0; //set default parent id
    }

    //validate inputs
    $errorArray = $this->_validateUserInputs($post_data);
  
    if (!$errorArray) {
      
      //db process
      $pageModelObj = new PageModel();

      // If ser_id is set, it means we are updating an existing page
      if (isset($post_data['pag_id']) && !empty($post_data['pag_id'])) {
        //update process
        $whereUpdate["pag_id"] = $post_data['pag_id'];
        $post_data['pag_updated_by'] = $_SESSION['auth']['user_id'];
        $post_data['pag_updated_on'] = date('Y-m-d H:i:s');

        $res =  $pageModelObj->update($post_data, $whereUpdate);
        if (is_bool($res)) {
          // If update is successful, set a success message
          $_SESSION['page']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Page updated successfully!'
          ];
          header("Location: pages"); // redirect to roles list
          exit;
        } else {
          // If update fails, set an error message   
          $errorArray[] = "Failed to update page. Please try again.";
        }
      } else {

        //insert process
        //set default values        
        $post_data['pag_created_by'] = $_SESSION['auth']['user_id'];
        $post_data['pag_updated_by'] = $_SESSION['auth']['user_id'];

        $res =  $pageModelObj->insert($post_data);

        if (is_numeric($res)) {
          // If insert is successful, set a success message
          $_SESSION['page']['flash'] = [
            'type' => 'success', // or 'error', 'warning'
            'message' => 'Page added successfully!'
          ];
          header("Location: pages");
          exit;
        } else {
          // If insert fails, set an error message   
          $errorArray[] = "Failed to add page. Please try again.";
        }
      }
    }

    //if error redirect to form 
    if (!empty($errorArray) && count($errorArray) > 0) {
      $page_data = ["app_name" => APP_NAME, "route" => $route];
      View::render(
        "admin/page/addpage",
        [
          "page_data" => $page_data,
          "errorArray" => $errorArray,
          "parentPages" => $parentPagesArray,
          "page" => $post_data,
        ]
      );
      exit;
    }
  }

  // Function to view page details
  // This function is called when the user clicks on "View" button
  public function viewpage($route)
  {

    //initialize variables
    $errorArray = [];
    $pageArray =  [];
    $parentPagesArray = CommonController::getParentPages();

    //validate page id
    $pageId = $route['uri'][1];

    if (empty($pageId) || !is_numeric($pageId)) {
      $errorArray[] = "Invalid page ID provided.";
    } else {
      //get page data
      $pageModelObj = new PageModel();
      $pageArray = $pageModelObj->getOne("pag_id = '{$pageId}'");

      if (empty($pageArray)) {
        $errorArray[] = "Page not found.";
      }
    }

    //redirect edit page page 
    $page_data = ["app_name" => APP_NAME, "route" => $route];
    View::render(
      "admin/page/viewpage",
      [
        "page_data" => $page_data,
        "errorArray" => $errorArray,
        "parentpages" => $parentPagesArray,
        "page" => $pageArray,
      ]
    );
    exit;
  }

  //validata user inputs
  private function _validateUserInputs($formData)
  {

    $errorArray = array();

    //empty validation
    if (empty($formData['pag_name'])) {
      $errorArray[] = "Please enter the page name";
    }    
  
    //unique validation
    if (!empty($formData['pag_name'])) {

      $parentIdValue=0;  
      if(!empty($formData['pag_parent_id'])){
        $parentIdValue=$formData['pag_parent_id'];  
      }

      $pageModelObj = new PageModel();
      if (!empty($formData['pag_id'])) {
        $pageArray = $pageModelObj->getOne("pag_parent_id = {$parentIdValue} AND pag_name = '{$formData['pag_name']}' AND pag_id != {$formData['pag_id']}");
      } else {
        $pageArray = $pageModelObj->getOne("pag_parent_id = {$parentIdValue} AND pag_name = '{$formData['pag_name']}'");
      }
  
      if (!empty($pageArray) && count($pageArray) > 0) {
        $errorArray[] = "Page already exist";
      }
    }

    //set return
    if (!empty($errorArray) && count($errorArray) > 0) {
      return $errorArray;
    }
    return false;
  }
}
