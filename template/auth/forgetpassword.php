<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.bootstrapdash.com/polluxui/themes/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Jun 2025 11:44:07 GMT -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Engineering Forgetpassword</title>
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
  <link rel="shortcut icon" href="<?php echo ASSETS_DIR;?>/images/favicons/favicon.ico" />
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
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-start p-3">
              <div class="brand-logo ">
                <img src="./assets/images/logo5.png" alt="logo"/>

                
              </div>
             
              
         <div class="card p-4">
          <h4 class="text-center mb-3">Forgot Your Password?</h4>
          <p class="text-center text-muted">Enter your email to reset your password</p>

         

           <form class="cmxform pt-3" id="forgetPasswordForm" method="post" action="loginvalidate">

                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-user-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" id="email" name="email"  class="form-control form-control-lg border-left-0"  placeholder="you@engineering.com" style="width:91%!important" maxlength="25">
                  </div>
                </div>
               <div class="my-3 d-grid gap-2">
                  <!-- <a class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" href="../../index.html">LOGIN</a> -->
                  <!-- <input class="btn btn-primary" type="submit" value="Submit"> -->

                  <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>

                   
                </div>
                 <div class="text-center mt-3">
                  <a href="login" class="text-decoration-none" style="text-align: right; color: #3b579d !important; font-weight: bold;">Back to Login</a>
                 </div>
          </form>
        </div>




              <!-- <form class="cmxform" id="signupForm" method="get" action="#">
                    <fieldset>
                      <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input id="firstname" class="form-control" name="firstname" type="text">
                      </div>
                      <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input id="lastname" class="form-control" name="lastname" type="text">
                      </div>
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" class="form-control" name="username" type="text">
                      </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" name="password" type="password">
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">Confirm password</label>
                        <input id="confirm_password" class="form-control" name="confirm_password" type="password">
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" name="email" type="email">
                      </div>
                      <input class="btn btn-primary" type="submit" value="Submit">
                    </fieldset>
                  </form> -->
                  


           
                </div>
          
              </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white fw-medium text-center flex-grow align-self-end">Copyright © <?php echo date('Y');?>  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="<?php echo ASSETS_DIR;?>/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo ASSETS_DIR;?>/js/off-canvas.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/hoverable-collapse.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/template.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/settings.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/todolist.js"></script>
  <!-- endinject -->

    <!-- plugin js for this page -->
  <script src="<?php echo ASSETS_DIR;?>/vendors/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="<?php echo ASSETS_DIR;?>/js/form-validation.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/bt-maxLength.js"></script>
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