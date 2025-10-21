<?php
/* ======================================
  Filename: dashboard.php
  Author: Ameen 
  Description: Main Dash Board
  =======================================
*/
//Requires only at sub views are rendered
use core\View as View;
?>

<!DOCTYPE html>
<html lang="en">

<?php View::render("admin/_header", ["title" => "Welcome Admin"]); ?>

<style>
.page-application .page-body-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.page-application .main-panel {
  display: flex;
  flex-direction: column;
  flex: 1;
  min-height: auto !important;
}

.page-application .content-wrapper {
  flex: 0 0 auto !important;
  padding: 0 !important;
  margin: 0 !important;
  min-height: auto !important;
  height: auto !important;
}

.page-application .row {
  margin-bottom: 0 !important;
  padding-bottom: 0 !important;
  --bs-gutter-x: 0 !important;
  --bs-gutter-y: 0 !important;
}

.page-application .grid-margin,
.page-application .stretch-card,
.page-application .col-xl-12 {
  margin-bottom: 0 !important;
  padding-bottom: 0 !important;
}

.page-application .footer {
  flex-shrink: 0;
  margin: 0 !important;
  padding: 10px 0 !important;
  background: #f5f5f5;
  border-top: 1px solid #ddd;
  text-align: center;
}

.navbar + .page-body-wrapper {
  padding-top: 0 !important;
}



/* ================================
   Vertical Wizard Layout (jQuery Steps)
   ================================ */

/* Layout: steps (tabs) on the left, content (sections) on the right */
#example-vertical-wizard {
  display: flex;
  flex-direction: row;
  align-items: flex-start;
}

/* Sidebar: steps */
#example-vertical-wizard .steps {
  width: 300px;               /* 👈 set desired width for tabs */
  flex-shrink: 0;             /* prevents shrinking on resize */  
  border-right: 1px solid #056a67;
  min-height: 750px;          /* optional for consistent height */
  
}

/* Main Content Area */
#example-vertical-wizard .content {
  width: calc(100% - 300px);  /* 👈 must match the steps width */
  padding: 20px;
  padding-left: 100px;
  background: #e5fffe;
  box-sizing: border-box;
}

/* Step titles inside sidebar */
#example-vertical-wizard .steps ul li a {
  font-size: 14px;  
  display: block;
  white-space: normal;       /* allow wrapping */
  text-align: left;
}

/* Active step highlight */
#example-vertical-wizard .steps ul li.current a {
  background: #33d4cf;
  color: #fff;
  font-weight: 600;
  border-radius: 4px;
}

/* Optional: better spacing inside section content */
#example-vertical-wizard .content section {
  border-radius: 6px;
  padding: 20px;
  background: #e5fffe;
  margin-bottom: 15px;
}

/* Responsive — stack on small screens */
@media (max-width: 768px) {
  #example-vertical-wizard {
    flex-direction: column;
  }

  #example-vertical-wizard .steps,
  #example-vertical-wizard .content {
    width: 100%;
    min-height: auto;
  }

  #example-vertical-wizard .steps {
    border-right: none;
    border-bottom: 1px solid #ddd;
  }
}

#example-vertical-wizard .actions a[href="#next"] {
  background-color: #056a67;
  color: #fff;
}

#example-vertical-wizard .actions {
  text-align: left;
  padding-left: 350px;
}

#example-vertical-wizard input.form-control {
  border: #056a67 1px solid;
  width: 500px;           /* or max-width: 100%; */
}

</style>

<body  class="page-application">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

    <?php View::render("admin/_topnavbar", ["title" => "Welcome Admin"]); ?>

    <div class="container-fluid page-body-wrapper">


      <div class="main-panel" style="width:100%;">
        <div class="content-wrapper" >
          
          <!--
          <div class="row" >
            <div class="col-xl-12 grid-margin stretch-card flex-column">
              <div class="row h-100">
                <div class="col-xl-12 stretch-card">
                  <div class="card" style="height:945px; background:#fff;">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start flex-wrap">

                      </div>                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          -->

          <!--vertical wizard-->
<div class="row" style="padding-top:50px;">
  <div class="col-12 grid-margin">
    <div class="card wizard-card" style="height:945px; background:#e5fffe;">
      <div class="card-body" style="background:#e5fffe;">
        <h4 class="card-title"></h4>
        <form id="example-vertical-wizard" action="#">
          <div>

            <h3>Your Property</h3>
            <section style="background:#e5fffe;padding-bottom:0px;padding-top:0px;padding-right:0px;padding-left:0px">
              <div style="font-weight:600;font-size:1.5rem;color:#056a67"><img src="<?php echo ASSETS_DIR; ?>/images/map-with-pin.jpg" alt="map" width="4%" height="4%"/>Property Location</div>

              <div style="font-weight:600;padding-top:20px;padding-bottom:20px;font-size:1rem">What property are you refinancing?</div>

              <div class="form-group">
                <label for="userName">Appartment, Floor, Etc <span class="text-danger">*</span></label>
                <input id="userName" name="userName" type="text" class="required form-control">
              </div>
              <div class="form-group">
                <label for="password">Street Address <span class="text-danger">*</span></label>
                <input id="password" name="password" type="password" class="required form-control">
              </div>
              <div class="form-group">
                <label for="confirm">Suburb <span class="text-danger">*</span></label>
                <input id="confirm" name="confirm" type="password" class="required form-control">
              </div>
            </section>

            <h3>Your Details</h3>
            <section>
              <h3>Profile</h3>
              <div class="form-group">
                <label for="name">First name *</label>
                <input id="name" name="name" type="text" class="required form-control">
              </div>
              <div class="form-group">
                <label for="surname">Last name *</label>
                <input id="surname" name="surname" type="text" class="required form-control">
              </div>
              <div class="form-group">
                <label for="email">Email *</label>
                <input id="email" name="email" type="text" class="required email form-control">
              </div>
              <div class="form-group">
                <label for="address">Address</label>
                <input id="address" name="address" type="text" class="form-control">
                <small>(*) Mandatory</small>
              </div>
            </section>

            <h3>Yor Finances</h3>
            <section>
              <h3>Finish</h3>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox">
                  I agree with the Terms and Conditions.
                </label>
              </div>
            </section>

            <h3>Yor Loan</h3>
            <section>
              <h3>Finish</h3>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="checkbox" type="checkbox">
                  I agree with the Terms and Conditions.
                </label>
              </div>
            </section>            

          </div>
        </form>
      </div>
    </div>
  </div>
</div>



        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->

        <!-- partial -->
      </div>

      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <?php
  View::render("admin/_scriptjs");
  ?>

      <!-- jQuery Validation -->
      <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
      <!-- jQuery Steps -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>


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
      <script src="<?php echo ASSETS_DIR; ?>/vendors/jquery-steps/jquery.steps.min.js"></script>
      <script src="<?php echo ASSETS_DIR; ?>/vendors/jquery-validation/jquery.validate.min.js"></script>
      <script src="<?php echo ASSETS_DIR; ?>/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
      <!-- End plugin js for this page -->

      <!-- Custom js for this page-->
      <script src="<?php echo ASSETS_DIR; ?>/js/form-validation.js"></script>
      <script src="<?php echo ASSETS_DIR; ?>/js/bt-maxLength.js"></script>

      <script src="<?php echo ASSETS_DIR; ?>/js/wizard.js"></script>
  

  <!-- Custom js for this page-->


  <?php if (!empty($_SESSION['show_profile_dropdown'])): ?>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var triggerEl = document.getElementById("profileDropdown");
        if (triggerEl) {
          var dropdown = new bootstrap.Dropdown(triggerEl);
          dropdown.show();


          // Remove focus immediately to prevent border/outline
          triggerEl.blur();
        }
      });
    </script>
    <?php unset($_SESSION['show_profile_dropdown']); // clear it so it runs only once 
    ?>
  <?php endif; ?>

  <!-- End custom js for this page-->
</body>

</html>