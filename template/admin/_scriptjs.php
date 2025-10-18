<?php 
/* ======================================
  Filename: Common Script
  Author: Elavarasan 
  Description: Common Script
  Updated By: Ameen on 15-07-2025
  =======================================
*/
?>
  <!-- base:js -->
  <script src="<?php echo ASSETS_DIR;?>/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="<?php echo ASSETS_DIR;?>/vendors/chart.js/chart.umd.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/jquery.cookie.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo ASSETS_DIR;?>/js/off-canvas.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/hoverable-collapse.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/template.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/settings.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/todolist.js"></script>
  <!-- endinject -->
  <script src="<?php echo ASSETS_DIR;?>/vendors/sweetalert/sweetalert.min.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/vendors/jquery.avgrund/jquery.avgrund.min.js"></script>

  <script src="<?php echo ASSETS_DIR;?>/js/alerts.js"></script>
  <script src="<?php echo ASSETS_DIR;?>/js/avgrund.js"></script>

  <script>
    function load_department_based_roles($departmentId,$selectedRoleId){
      $.ajax({
        url: '/load_dep_roles',
        type: 'POST',
        data: { department_id: $departmentId,selected_role_id: $selectedRoleId, },
        success: function(response){
          $('#usr_role').html('<option value="">Select Role</option>' + response);
          updateSelectStyle();
        },
        error: function(xhr){
          console.log("Error: ", xhr.responseText);
        }
      });
    }
  </script>