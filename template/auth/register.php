<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.bootstrapdash.com/polluxui/themes/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Jun 2025 11:44:07 GMT -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Engineering Registration</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo ASSETS_DIR;?>/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR;?>/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo ASSETS_DIR;?>/css/vertical-layout-light/style.css">
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
  <?php //echo "<pre>";print_r($post_data); die;?>

 <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-start p-3">
              <div class="brand-logo">
               <img src="./assets/images/logo5.png" alt="logo"/>
              </div>
              <h4>New here?</h4>
              <h6 class="fw-light">Join us today! It takes only few steps</h6>
              
             <form class="cmxform pt-3" id="signupForm" method="post" action="registervalidate">
                <div class="form-group">
                  <label>Firstname</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-user-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" id="firstname" name="firstname" class="form-control form-control-lg border-left-0"  style="width:87%!important" placeholder="Firstname" maxlength="20" value="<?php echo @$post_data['firstname'];?>" >
                  </div>
                </div>  
                
                <div class="form-group">
                  <label>Lastname</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-user-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" id="lastname" name="lastname" class="form-control form-control-lg border-left-0"  style="width:87%!important" placeholder="Lastname" maxlength="20" value="<?php echo @$post_data['lastname'];?>" >
                  </div>
                </div>    

                  <div class="form-group">
                  <label>Country</label> 
                  <select class="form-select form-select-lg form-select" id="country" name="country" >
                    <option value="">Select Country</option>
                   <option value="Australia">Australia</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="India">India</option>
                    <option value="India">Germany</option>
                    <option value="Argentina">Argentina</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>City</label>
                  <select class="form-select form-select-lg form-select" id="city" name="city" >
                  <option value="">Select City</option>
                  <option value="Sydney">Sydney</option>
                  <option value="Melbourne">Melbourne</option>
                  <option value="Brisbane">Brisbane</option>
                  <option value="Perth">Perth</option>
                  <option value="Adelaide">Adelaide</option>
                  <option value="Canberra">Canberra</option>
                  <option value="Hobart">Hobart</option>
                  <option value="Darwin">Darwin</option>
                  <option value="Gold Coast">Gold Coast</option>
                  <option value="Newcastle">Newcastle</option>
                  </select>
                </div>
                 <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-mail text-primary"></i>
                      </span>
                    </div>
                    <input type="email" id="email" name="email" class="form-control form-control-lg border-left-0" placeholder="Email" style="width:87%!important" maxlength="30" value="<?php echo @$post_data['email'];?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label>Phonenumber</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="typcn typcn-mail text-primary"></i>
                      </span>
                    </div>
                    <input type="text" id="phonenumber" name="phonenumber" class="form-control form-control-lg border-left-0" placeholder="Phonenumber" style="width:87%!important" maxlength="12" value="<?php echo @$post_data['phonenumber'];?>" >
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
                    <input type="password" id="password" name="password" class="form-control form-control-lg border-left-0 "  placeholder="Password" style="width:87%!important" maxlength="15"  >

                    <button type="button" class="toggle-password" onclick="togglePassword()">
                      <i class="fa-solid fa-eye" id="eyeIcon"></i>
                    </button>             
                  </div>
                </div>

                  <!-- <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" class="form-control" name="username" type="text">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" name="password" type="password">
                  </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div> -->
                <div class="my-3 d-grid gap-2">
                  <!-- <a class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" href="../../index.html">LOGIN</a> -->

                  <div class=" form-group mb20 no-padding no-margin">
                    <div class="g-recaptcha  no-padding no-margin" data-sitekey="6Le0fkkrAAAAAOV0ExFbVBDBF-9nYRA30atwHQ1Q" style="display:inline-block;"></div>
                    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en">
                    </script>
                  </div>

                  <input class="btn btn-primary" type="submit" value="Submit">
                </div>
                <div class="mb-2 d-flex">
                  <button type="button" class="btn btn-facebook auth-form-btn flex-grow me-1">
                    <i class="typcn typcn-social-facebook me-2"></i>Facebook
                  </button>
                  <button type="button" class="btn btn-google auth-form-btn flex-grow ms-1">
                    <i class="typcn typcn-social-google-plus-circular me-2"></i>Google
                  </button>
                </div>
                <div class="text-center mt-4 fw-light">
                  Already have an account? <a href="login" class="text-primary" style="text-align: right; color: #3b579d !important; font-weight: bold;" >Login</a>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6 register-half-bg d-flex flex-row">
            <p class="text-white fw-medium text-center flex-grow align-self-end">Copyright &copy; 2021  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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

    <!-- Custom js ========== ALERT ======== for this page-->
  <script src="<?php echo ASSETS_DIR;?>/js/alerts.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/avgrund.js"></script>
  <!-- End custom js for this page-->

 <script src="<?php echo ASSETS_DIR;?>/vendors/sweetalert/sweetalert.min.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/vendors/jquery.avgrund/jquery.avgrund.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  

   
</body>


<!-- Mirrored from demo.bootstrapdash.com/polluxui/themes/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Jun 2025 11:44:07 GMT -->
</html>
 <script>
/*    $.validator.setDefaults({
    submitHandler: function() {
      alert("submitted!====");
	  
	  showSwal('success-message');

    
	  
    }
  }); */

  $.validator.setDefaults({
  submitHandler: function(form) {


     event.preventDefault();

    // Get the response from reCAPTCHA
    var recaptchaResponse = grecaptcha.getResponse();

    if (recaptchaResponse.length === 0) {
      alert("Please complete the reCAPTCHA.");
      
    } else {
       swal({
          title: 'Congratulations!',
          text: 'Thanks for registering with engineering services, check your email and verify your account',
          icon: 'success',
          button: {
            text: "Continue",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }).then(() => {
        form.submit(); // 👈 Form actually submits after alert closes
      });

    }
  }
});

  
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