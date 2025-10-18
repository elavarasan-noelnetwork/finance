<?php
/* ======================================
  Filename: changepassword.php
  Author: Ameen 
  Description: change password
  =======================================
*/
//Requires only at sub views are rendered
use core\View as View;
?>

<!DOCTYPE html>
<html lang="en">

<?php View::render("admin/_header"); ?>
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<style>
    .iti {
        position: relative;
        display: inline-block;
        width: 100%;
    }
</style>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->

        <?php View::render("admin/_topnavbar"); ?>

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->

            
            <!-- partial -->

            <?php

            $_Amaxlength = array();
            $_Amaxlength['oldPassword']    = 25;
            $_Amaxlength['newPassword']    = 25;
            $_Amaxlength['confirmNewPasword']    = 25;

            ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-12 grid-margin">
                            <div class="card">

                                <div class="breadcrumb-floating ms-3 mt-2 pb-1">
                                    <a href="<?php echo BASE_URL; ?>">Dashboard</a>
                                    <span>››</span>
                                    <span class="current">Change Password</span>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-primary border shadow-sm">

                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-people-fill fs-3 text-white"></i>
                                            <h3 class="mb-0 text-white">Change Password</h3>
                                            <?php if (isset($_SESSION['password']['flash'])) {
                                                echo '<div class="alert alert-' . ($_SESSION['password']['flash']['type'] ?? 'info') . ' alert-dismissible fade show d-flex align-items-center gap-2 align-self-center mb-0 py-1 px-2" role="alert"> <div class="flex-grow-1">';
                                                echo htmlspecialchars($_SESSION['password']['flash']['message']);
                                                echo '</div><button type="button" class="btn-close m-0 p-0" style="position: static;align-self: center;" data-bs-dismiss="alert" aria-label="Close"></button>';
                                                echo '</div>';
                                                unset($_SESSION['password']['flash']);
                                            } ?>                                            
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($errorArray) && !empty($errorArray)) {  ?>
                                        <h6 id="errorMsg" class="fw-light" style="color:red">
                                            <?php
                                            foreach ($errorArray as $errorMessage) {
                                                echo  "<div style='padding-top:5px'>" . $errorMessage . "</div>";
                                            }
                                            ?>
                                        </h6>
                                        <script>
                                            var errorMsg = document.getElementById('errorMsg');
                                            setTimeout(function() {
                                                errorMsg.style.display = 'none';
                                            }, 5000);
                                        </script>
                                    <?php  } ?>

                                    <form autocomplete="off" class="cmxform pt-3" name="changePasswordForm" id="changePasswordForm" method="post" action="<?php echo BASE_URL; ?>updatepassword" >

                                        <?php if (isset($_user['usr_id'])) { ?>
                                            <input type="hidden" name="usr_id" id="usr_id" value="<?php echo $_user['usr_id']; ?>" />
                                        <?php } ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3-registration-label col-form-label">Old Password <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" id="old_pass" name="old_pass" value="" class="form-control" maxlength="<?php echo $_Amaxlength['oldPassword']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3-registration-label col-form-label">New Password <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" id="new_pass" name="new_pass" value="" class="form-control" maxlength="<?php echo $_Amaxlength['newPassword']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3-registration-label col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" id="confirm_new_pass" name="confirm_new_pass" value="" class="form-control" maxlength="<?php echo $_Amaxlength['confirmNewPasword']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        

                                        <button type="submit" class="btn btn-primary me-2">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- partial:../../partials/_footer.html -->
                <?php
                View::render("admin/_footer");
                ?>
                <!-- partial -->
            </div>


            <?php
            View::render("admin/_scriptjs");
            ?>

            <script src="<?php echo ASSETS_DIR; ?>/vendors/datatables.net/jquery.dataTables.js"></script>
            <script src="<?php echo ASSETS_DIR; ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <!-- End plugin js for this page -->
            <!-- Custom js for this page-->
            <script src="<?php echo ASSETS_DIR; ?>/js/data-table.js"></script>
            <!-- End custom js for this page-->

            <!-- Custom js for this page-->
            <script src="<?php echo ASSETS_DIR; ?>/js/file-upload.js"></script>
            <script src="<?php echo ASSETS_DIR; ?>/js/typeahead.js"></script>
            <script src="<?php echo ASSETS_DIR; ?>/js/select2.js"></script>
            <!-- End custom js for this page-->

            <!-- plugin js for this page -->
            <script src="<?php echo ASSETS_DIR; ?>/vendors/jquery-validation/jquery.validate.min.js"></script>
            <script src="<?php echo ASSETS_DIR; ?>/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
            <!-- End plugin js for this page -->
            <!-- Custom js for this page-->
            <script src="<?php echo ASSETS_DIR; ?>/js/form-validation.js"></script>
            <script src="<?php echo ASSETS_DIR; ?>/js/bt-maxLength.js"></script>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css" />

            <!-- Your HTML form here -->

</body>

</html>