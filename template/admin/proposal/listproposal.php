<?php
/* ======================================
  Filename: list proposal
  Author: Ameen 

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
  #pdfOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6);
    /* semi-transparent dark overlay */
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #pdfViewerWrapper {
    background: #eaeaf1;
    padding: 15px;
    width: 50%;
    height: 90%;
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
    position: relative;
  }

  #closePdfViewer {
    position: absolute;
    top: 8px;
    right: 12px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    font-size: 20px;
    cursor: pointer;
    z-index: 10000;
  }

  #pdfViewer canvas {
    display: block;
    margin: 0 auto 16px auto;
    max-width: 100%;
  }

#pdfProgress {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-size: 18px;
  font-weight: 500;
  color: #444;
  background: rgba(255, 255, 255, 0.95);
  padding: 20px 30px;
  border-radius: 12px;
  box-shadow: 0 4px 25px rgba(0, 0, 0, 0.25);
  z-index: 1000;
  opacity: 1;
  transition: opacity 0.3s ease;
}

#pdfProgress.fade-out {
  opacity: 0;
}

.loading-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.hourglass {
  font-size: 32px;
  margin-bottom: 8px;
  animation: hourglass-tilt 1.2s infinite;
}

@keyframes hourglass-tilt {
  0%   { transform: rotate(0deg); }
  25%  { transform: rotate(20deg); }
  50%  { transform: rotate(0deg); }
  75%  { transform: rotate(-20deg); }
  100% { transform: rotate(0deg); }
}

.loading-text {
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 500;
  font-size: 18px;
  background: linear-gradient(90deg, #056a67, #29afab);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text; /* for Firefox */
  color: transparent;      /* fallback */
}

.dots::after {
  content: "";
  animation: dots 1.5s steps(4, end) infinite;
  background: linear-gradient(90deg, #056a67, #29afab);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  color: transparent;
}

@keyframes dots {
  0%   { content: ""; }
  25%  { content: "."; }
  50%  { content: ".."; }
  75%  { content: "..."; }
  100% { content: ""; }
}
</style>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

    <?php View::render("admin/_topnavbar"); ?>

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->

      <?php View::render("admin/_sidebar"); ?>
      <!-- partial -->

      <!-- Overlay container -->
      <div id="pdfOverlay" style="display: none;">
        <div id="pdfViewerWrapper">
          <button id="closePdfViewer" title="Close">×</button>
          <div id="pdfViewer">
            <!-- Canvas elements will be injected here -->
          </div>
        </div>
      </div>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">

            <div class="breadcrumb-floating ms-3 mt-2 pb-1">
              <a href="<?php echo BASE_URL; ?>">Dashboard</a>
              <span>››</span>

              <span class="current">Proposals</span>
            </div>

            <div class="card-body">


              <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-primary border shadow-sm">

                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-file-earmark-pdf-fill fs-3 text-white"></i>
                  <h3 class="mb-0 text-white">Proposals</h3>
                  <?php if (isset($_SESSION['proposal']['flash'])) {
                    echo '<div class="alert alert-' . ($_SESSION['proposal']['flash']['type'] ?? 'info') . ' alert-dismissible fade show d-flex align-items-center gap-2 align-self-center mb-0 py-1 px-2" role="alert"> <div class="flex-grow-1">';
                    echo htmlspecialchars($_SESSION['proposal']['flash']['message']);
                    echo '</div><button type="button" class="btn-close m-0 p-0" style="position: static;align-self: center;" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                    unset($_SESSION['proposal']['flash']);
                  } ?>
                </div>

                <a href="<?php echo BASE_URL; ?>addproposal"><button class="btn btn-primary add-user-btn">
                    <i class="fas fa-user-plus mr-2"></i> Create Proposal
                  </button>
                </a>

              </div>

              <form autocomplete="off" class="filter-form mb-2" name="proposalFilterForm" id="proposalFilterForm" method="get" action="proposals">
                <h2>Filter</h2>
                <?php
                if (isset($search_error) && $search_error == true) {  ?>
                  <h6 id="errorMsg" class="fw-light" style="color:red;padding:5px">Please enter atleast one search field</h6>
                  <script>
                    var errorMsg = document.getElementById('errorMsg');
                    setTimeout(function() {
                      errorMsg.style.display = 'none';
                    }, 5000);
                  </script>
                <?php
                }
                ?>
                <div class="form-row">

                  <select class="form-select form-select" id="company" name="company">
                    <option value="">Select Company</option>

                    <?php
                    if ($companyDetails && is_array($companyDetails) && count($companyDetails) > 0) {
                      foreach ($companyDetails as $key => $company) { ?>
                        <option value="<?php echo $company['com_id']; ?>"
                          <?php if ($_SESSION['proposal']['filters']['company'] == $company['com_id']) {
                            echo "selected ";
                            echo "class='active'";
                          } ?>>
                          <?php echo $company['com_name']; ?>
                        </option>
                    <?php }
                    } ?>
                  </select>

                  <input type="text" id="project" name="project" placeholder="Project Code / Title / Location" maxlength="100" value="<?php echo htmlspecialchars(trim($_SESSION['proposal']['filters']['project']) ?? ''); ?>">
                  <input type="text" id="customer" name="customer" placeholder="Customer Name / Address" maxlength="100" value="<?php echo htmlspecialchars(trim($_SESSION['proposal']['filters']['customer']) ?? ''); ?>">


                  <?php $_AstatusArr[1] = 'Active';
                  $_AstatusArr[2] = 'Inactive'; ?>
                  <select class="form-select form-select" id="status" name="status">
                    <option value="">Select Status</option>
                    <?php
                    if (!empty($_AstatusArr)) {
                      foreach ($_AstatusArr as $key => $value) {  ?>
                        <option value="<?php echo $key; ?>" <?php if ($_SESSION['proposal']['filters']['status'] == $key) {
                                                              echo "selected";
                                                            } ?>><?php echo $value; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                  <div class="filter-buttons">
                    <button type="submit" name="submit" class="btn-submit">Apply Filter</button>
                    <button type="submit" name="reset" class="btn-reset" value="1">Reset</button>
                  </div>
                </div>
              </form>

              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="proposalTable" class="table table-hover table-striped">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Created On</th>
                          <th>Company</th>
                          <th>Title</th>
                          <th>Location</th>
                          <th>Agreement</th>
                          <th>Customer</th>
                          <th>Address</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                    </table>
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



      <script src="<?php echo ASSETS_DIR; ?>/vendors/datatables.net/jquery.dataTables.js"></script>
      <script src="<?php echo ASSETS_DIR; ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
      <!-- End plugin js for this page -->
      <!-- Custom js for this page-->
      <script src="<?php echo ASSETS_DIR; ?>/js/data-table.js"></script>
      <script src="<?php echo ASSETS_DIR; ?>/js/pdf.min.js"></script>
      <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>-->
      <!-- End custom js for this page-->
      <script>
        $(document).ready(function() {
          var table = $('#proposalTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            searching: false, // This removes the default search box
            order: [
              [0, 'desc']
            ], //Set default sort: column 0 (usr_id), descending
            columnDefs: [{
                orderable: false,
                targets: [2,9]
              } // Disables sorting (0-based index)
            ],
            ajax: {
              url: '/ajaxproposals', // change to your route
              type: 'POST',
              data: function(d) { //usr_name  usr_department usr_role
                d.company = $('#company').val();
                d.project = $('#project').val();
                d.customer = $('#customer').val();
                d.status = $('#status').val();
              }
            },
            columns: [{
                data: 'code'
              },
              {
                data: 'created_on'
              },
              {
                data: 'title'
              },
              {
                data: 'logo'
              },              
              {
                data: 'location'
              },
              {
                data: 'agreement'
              },
              {
                data: 'customer'
              },
              {
                data: 'address'
              },
              {
                data: 'status'
              },
              {
                data: 'actions'
              }
            ]
          });

          // Hide length dropdown if total records < 10
          table.on('draw', function() {

            var info = table.page.info();;
            // Debug check
            console.log("Page Info:", info);

            if (info.recordsDisplay < 10 || info.pages <= 1) {
              $('#proposalTable_length').hide(); // hides "Show X entries"
              $('#proposalTable_paginate').hide(); // optionally hide pagination controls
              $('#proposalTable_info').hide(); // opti  onally hide "Showing 1 to..." info
            } else {
              $('#proposalTable_length').show();
              $('#proposalTable_paginate').show();
              $('#proposalTable_info').show();
            }
          });

        });
      </script>

      <script>
        /* ===== start Selected department highlight ============*/
        const selectcompany = document.getElementById('company');
        const selectstatus = document.getElementById('status');

        function updateSelectStyle() {
          if (selectcompany.value !== '') {
            selectcompany.classList.add('highlighted');
          } else {
            selectcompany.classList.remove('highlighted');
          }

          if (selectstatus.value !== '') {
            selectstatus.classList.add('highlighted');
          } else {
            selectstatus.classList.remove('highlighted');
          }
        }
        // Apply on page load (if pre-selected)
        updateSelectStyle();
        // Apply on change
        selectcompany.addEventListener('change', updateSelectStyle);
        selectstatus.addEventListener('change', updateSelectStyle);
        /* ===== start Selected department highlight ============*/
      </script>


<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = "/assets/js/pdf.worker.min.js";

function openPdfViewer(pdfUrl) {
  const overlay = document.getElementById('pdfOverlay');
  const viewer = document.getElementById('pdfViewer');

  // Show overlay
  overlay.style.display = 'flex';
  viewer.innerHTML = '';

  // Create centered loading overlay with hourglass and dots
  const progressContainer = document.createElement("div");
  progressContainer.id = "pdfProgress";
  progressContainer.innerHTML = `
    <div class="loading-wrapper">
      <div class="hourglass">⏳</div>
      <div class="loading-text">Loading PDF Preview<span class="dots"></span></div>
    </div>
  `;
  viewer.appendChild(progressContainer);

  // Load PDF
  pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
    let loadedPages = 0;

    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
      pdf.getPage(pageNum).then(page => {
        const scale = 1.3;
        const viewport = page.getViewport({ scale });

        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        page.render({ canvasContext: context, viewport: viewport }).promise.then(() => {
          loadedPages++;
          if (loadedPages >= pdf.numPages) {
            const loader = document.getElementById("pdfProgress");
            if (loader) {
              loader.classList.add("fade-out");
              setTimeout(() => loader.remove(), 300); // remove after fade
            }
          }
        });

        viewer.appendChild(canvas);
      });
    }
  }).catch(error => {
    viewer.innerHTML = "<p style='color:red;'>Failed to load PDF.</p>";
    console.error("PDF Load Error:", error);
  });
}

// Close viewer on button click
document.getElementById("closePdfViewer").addEventListener("click", function() {
  document.getElementById("pdfOverlay").style.display = "none";
  document.getElementById("pdfViewer").innerHTML = ""; // clear canvases
});
</script>


</body>

</html>