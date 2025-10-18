<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.bootstrapdash.com/polluxui/themes/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Jun 2025 11:44:07 GMT -->

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Zeon Developments</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../assets/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo ASSETS_DIR; ?>/images/favicons/zion_favicon.png" />
</head>

<style>
  .toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #555;
    font-size: 18px;
  }

  .brand-logo {
    text-align: center !important;
  }

</style>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center" style="background-color: #e5fffe;font-weight:initial;color:black !important">
            <div class="auth-form-transparent text-start p-3">
              <div class="brand-logo">
                <img src="<?php echo ASSETS_DIR; ?>/images/zeon.png" alt="logo" />
              </div>
              <h6>Welcome back. Happy to see you again!</h6>                      
              <?php 
              if (isset($invalid) && $invalid == true) {  ?>
                <div class="text-center" style="padding-top:20px;">
                  <h6 id="errorMsg" class="fw-light" style="color:red">Invalid Credentials, try again</h6>
                  <script>
                    var errorMsg = document.getElementById('errorMsg');
                    setTimeout(function() {
                      errorMsg.style.display = 'none';
                    }, 5000);
                  </script>                  
                </div>
              <?php  }  ?>


              <form class="cmxform" id="loginForm" method="post" action="<?php echo BASE_URL; ?>loginvalidate" style="padding-top:1rem !important">
                <div class="form-group" >
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-user-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" id="username" name="username" class="form-control form-control-lg border-left-0" placeholder="Email" maxlength="100" style="border:1px solid #056a67 !important;width:85%!important">
                  </div>
                </div>
                <div class="form-group ">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group ">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-lock-closed-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" id="password" name="password" class="form-control form-control-lg border-left-0 " placeholder="Password" maxlength="15" style="border:1px solid #056a67 !important;width:85%!important">

                    <button type="button" class="toggle-password" onclick="togglePassword()">
                      <i class="fa-solid fa-eye" id="eyeIcon"></i>
                    </button>
                  </div>
                </div>

                <!--
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input custom">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>                
                -->

                <div class="my-5 d-grid gap-2">
                  <!-- <a class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" href="../../index.html">LOGIN</a> -->

                  <?php
                  //if (!isset($_SESSION['CustomerID'])) {
                  ?>
                  <!--
                        <div class=" form-group mb20 no-padding no-margin">
                          <div class="g-recaptcha  no-padding no-margin" data-sitekey="6Le0fkkrAAAAAOV0ExFbVBDBF-9nYRA30atwHQ1Q" style="display:inline-block;"></div>
                          <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en">
                          </script>
                        </div>
                        -->
                  <?php
                  //} 
                  ?>

                  <!--<a href="forgetpassword" class="text-primary" style="text-align: right;font-size: 12px;  color: #3b579d !important; font-weight: bold;">Forgot Password?</a>-->


                  <input class="btn btn-primary" type="submit" value="Submit" style="background-color: #056a67; border-color:#056a67;font-weight:500">

                </div>

              </form>

            </div>

          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white fw-medium text-center flex-grow align-self-end">Copyright Zeon Developments © <?php echo date('Y'); ?> All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="<?php echo ASSETS_DIR; ?>/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo ASSETS_DIR; ?>/js/off-canvas.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/js/hoverable-collapse.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/js/template.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/js/settings.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/js/todolist.js"></script>
  <!-- endinject -->

  <!-- plugin js for this page -->
  <script src="<?php echo ASSETS_DIR; ?>/vendors/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="<?php echo ASSETS_DIR; ?>/js/form-validation.js"></script>
  <script src="<?php echo ASSETS_DIR; ?>/js/bt-maxLength.js"></script>
  <!-- End custom js for this page-->


</body>


<!-- Mirrored from demo.bootstrapdash.com/polluxui/themes/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Jun 2025 11:44:07 GMT -->

</html>
<script>
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
  }

</script>