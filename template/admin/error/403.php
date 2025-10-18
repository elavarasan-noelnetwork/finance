<?php
/* ======================================
  Filename: List the departments
  Author: Ameen 
  Description: List all the departments
  =======================================
*/

//Requires only at sub views are rendered
use core\View as View;
?>

<!DOCTYPE html>
<html lang="en">

<?php View::render("admin/_header", ["title" => "Welcome Admin"]); ?>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

    <?php View::render("admin/_topnavbar", ["title" => "Welcome Admin"]); ?>

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->

      <?php View::render("admin/_sidebar", ["title" => "Welcome Admin"]); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">

            <div class="breadcrumb-floating ms-3 mt-2 pb-1">
              <a href="<?php echo BASE_URL; ?>">Dashboard</a>
              <span>››</span>
              <span class="current">Authorization</span>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="alert alert-danger text-center p-4 rounded shadow-sm">
                    <h2 class="text-danger mb-3">403 - Access Denied</h2>
                    <p class="mb-2">You do not have permission to access this page or perform this action.</p>
                    <a href="/" class="btn btn-primary mt-3">Return to Dashboard</a>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
        View::render("admin/_footer");
        ?>
        <!-- partial -->
      </div>

      <?php
      View::render("admin/_scriptjs");
      ?>
</body>

</html>