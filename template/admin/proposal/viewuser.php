<?php

/* ======================================
  Filename: View user
  Author: Ameen 
  Description: View user and display all details
  =======================================
*/

//Requires only at sub views are rendered
use core\View as View;
use app\controllers\CommonController;
?>

<!DOCTYPE html>
<html lang="en">

<?php View::render("admin/_header"); ?>
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/simplemde/simplemde.min.css">

<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/dropify/dropify.min.css">
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/jquery-file-upload/uploadfile.css">

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">


<style>
  .striped-row:nth-of-type(odd) {
    background-color: #f5f6f7;
    /* Light gray for odd rows */
  }

  .striped-row {
    padding: 1rem;
    border-radius: 0.5rem;
  }
</style>



<body>
  <div class="container-scroller">
    <?php View::render("admin/_topnavbar"); ?>

    <div class="container-fluid page-body-wrapper">
      <?php View::render("admin/_sidebar"); ?>

      <?php
      $viewType = "User";
      if (isset($page_data['route']['uri'][0]) && $page_data['route']['uri'][0] == "viewprofile") {
        $viewType = "Profile";
        if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN) {
          $viewType = "User";
        }
      }
      ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <!--vertical wizard-->
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">

                <div class="breadcrumb-floating ms-3 mt-2 pb-1">
                  <a href="<?php echo BASE_URL; ?>">Dashboard</a>

                  <?
                  if ($viewType == "User") {
                  ?>
                    <span>››</span>
                    <a href="<?php echo BASE_URL; ?>users">Users</a>
                  <?
                  }
                  ?>
                  <span>››</span>
                  <span class="current"><?php echo @$viewType ?> Details</span>

                </div>

                <div class="card-body">

                  <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-primary border shadow-sm">

                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-people-fill fs-3 text-white"></i>
                      <h3 class="mb-0 text-white"><?php echo @$viewType ?> Details <span class="smallHead"> - <?php echo @$_user['usr_fname']; ?> <?php echo @$_user['usr_lname']; ?></span></h3>
                      <?php if (isset($_SESSION['user']['flash'])) {
                        echo '<div class="alert alert-' . ($_SESSION['user']['flash']['type'] ?? 'info') . ' alert-dismissible fade show d-flex align-items-center gap-2 align-self-center mb-0 py-1 px-2" role="alert"> <div class="flex-grow-1">';
                        echo htmlspecialchars($_SESSION['user']['flash']['message']);
                        echo '</div><button type="button" class="btn-close m-0 p-0" style="position: static;align-self: center;" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                        unset($_SESSION['user']['flash']);
                      } ?>
                    </div>

                    <?
                    if ($viewType == "User") {
                    ?>
                      <a href="<?php echo BASE_URL; ?>users"><button class="btn btn-primary add-user-btn">
                          <i class="fas fa-user-plus mr-2"></i> Back
                        </button>
                      </a>
                    <?
                    } else {
                    ?>
                      <a href="<?php echo BASE_URL; ?>editprofile/<?php echo isset($_SESSION['auth']['user_id']) ? trim($_SESSION['auth']['user_id']) : '' ?>"><button class="btn btn-primary add-user-btn">
                          <i class="fas fa-user-plus mr-2"></i> Edit
                        </button>
                      </a>
                    <?
                    }
                    ?>

                  </div>

                  <div class="w-100" style="background-color: #f8f9fa;">
                    <div class="card shadow-sm rounded-4 border-0 w-100">
                      <div class="card-body">

                        <?php
                        if (isset($errorArray) && !empty($errorArray)) {  ?>
                          <div class="containers">
                            <div style="color:red">
                              <?php
                              foreach ($errorArray as $errorMessage) {
                                echo  "<div style='padding-top:5px'>" . $errorMessage . "</div>";
                              }
                              ?>
                            </div>
                          </div>
                        <?php
                        } else {
                        ?>
                          <div class="containers my-4">
                            <div class="card shadow-sm rounded-4">
                              <div class="card-body">
                                <div class="row striped-row">
                                  <div class="col-md-6 mb-2">
                                    <strong>Name :</strong>
                                    <span class="text-muted"><?php echo @$_user['usr_fname']; ?> <?php echo @$_user['usr_lname']; ?></span>
                                  </div>
                                  <div class="col-md-6 mb-2">
                                    <strong>Email :</strong>
                                    <span class="text-muted"><?php echo @$_user['usr_email']; ?></span>
                                  </div>
                                </div>

                                <div class="row striped-row">
                                  <div class="col-md-6 mb-2">
                                    <strong>Department :</strong> <span class="text-muted"><?php echo CommonController::getDepartmentNameById(@$_user['usr_department']) ?></span>
                                  </div>
                                  <div class="col-md-6 mb-2">
                                    <strong>Role :</strong> <span class="text-muted"><?php echo CommonController::getRoleNameById(@$_user['usr_role']) ?></span>
                                  </div>
                                </div>

                                <div class="row striped-row">
                                  <div class="col-md-6 mb-2">
                                    <strong>Status :</strong>
                                    <span class="text-muted"><?php echo isset($_user['usr_status']) ? ($_user['usr_status'] == 1 ? 'Active' : ($_user['usr_status'] == 2 ? 'Inactive' : '')) : ''; ?></span>
                                  </div>
                                  <div class="col-md-6 mb-2">
                                    <strong>Last Loggedin :</strong>
                                    <span class="text-muted"> <span class="text-muted"><?php echo CommonController::formatDisplayDate(@$_user['usr_last_login']) ?></span>
                                  </div>
                                </div>

                                <?
                                if ($viewType == "User") {
                                ?>
                                  <div class="row striped-row">
                                    <div class="col-md-6 mb-2">
                                      <strong>Created By :</strong> <span class="text-muted"><?php echo CommonController::getUserNameById(@$_user['usr_created_by']) ?></span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                      <strong>Updated By :</strong> <span class="text-muted"><?php echo CommonController::getUserNameById(@$_user['usr_updated_by']) ?></span>
                                    </div>
                                  </div>

                                  <div class="row striped-row">
                                    <div class="col-md-6 mb-2">
                                      <strong>Created On :</strong>
                                      <span class="text-muted">
                                        <?php echo CommonController::formatDisplayDate(@$_user['usr_created_on']) ?>
                                      </span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                      <strong>Updated On :</strong>
                                      <span class="text-muted">
                                        <?php echo CommonController::formatDisplayDate(@$_user['usr_updated_on']) ?>
                                      </span>
                                    </div>
                                  </div>

                                <?
                                }
                                ?>

                              </div>
                            </div>

                          </div>
                        <?
                        }
                        ?>


                      </div> <!-- end outer card-body -->
                    </div> <!-- end outer card -->
                  </div> <!-- end w-100 bg -->
                </div> <!-- end card-body -->
              </div> <!-- end card -->
            </div> <!-- end col-12 -->
          </div> <!-- end row -->
        </div> <!-- end content-wrapper -->

        <?php View::render("admin/_footer"); ?>
      </div> <!-- end main-panel -->
    </div> <!-- end container-fluid -->
  </div> <!-- end container-scroller -->



  <?php
  View::render("admin/_scriptjs");

  ?>

  <script src="<?php echo ASSETS_DIR; ?>/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="<?php echo ASSETS_DIR; ?>/js/data-table.js"></script>
  <!-- End custom js for this page-->
  
</body>

</html>