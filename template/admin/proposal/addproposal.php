<?php
/* ======================================
  Filename: addproposal
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
  .iti {
    position: relative;
    display: inline-block;
    width: 100%;
  }

  .col-form-label {
    padding-bottom: 0px !important;
  }

  .form-control.custom-input {
    height: 40px;
    /* reduce height */
    padding: 4px 10px;
    /* tighter padding */
    border-radius: 10px;
    /* more curved corners */
    font-size: 0.9rem;
    /* optional: slightly smaller text */
  }

  /* Specific for textarea */
  textarea.form-control.custom-input {
    resize: vertical;
    /* allow vertical resize only */
    overflow-y: auto;
    /* scroll if content overflows */
    min-height: 70px;
    /* default visible area (≈3 rows) */
    max-height: 70px;
    /* don’t let it grow too tall */
    line-height: 1.4;
    /* good text readability */
    padding: 10px;
  }

  .form-check .form-check-input {
    margin-left: 0px;
    float: left;
  }

  /* Base checkbox */
  .form-check-input {
    width: 18px;
    height: 18px;
    cursor: pointer;
    border: 1px solid #434a54;
    border-radius: 4px;
    background-color: white;
    appearance: none;
    /* hide default browser tick */
    -webkit-appearance: none;
    -moz-appearance: none;
    outline: none;
    position: relative;
    transition: all 0.2s ease-in-out;
  }

  /* Checked state background */
  .form-check-input:checked {
    background-color: #33d4cf !important;
    border-color: #33d4cf !important;
    box-shadow: 0 !important;
  }

  .form-check-input:focus {
    border-color: #33d4cf !important;
    box-shadow: 0 0 5px #33d4cf !important;
    /* subtle glow around the box */
  }

  .form-check-label {
    padding-top: 3px;
  }

  .proposal-form {
    background-color: #f9f9f9;
    /* light background */
    border: 1px solid #ddd;
    /* light gray border */
    padding: 20px;
    /* inner spacing */
    border-radius: 10px;
    /* rounded corners */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    /* subtle shadow */
  }

  .btn-modern {
    background-color: #056a67;
    /* brand color */
    color: white;
    /* text color */
    border: none;
    /* remove default border */
    padding: 12px 30px;
    /* larger clickable area */
    font-size: 1rem;
    /* slightly bigger text */
    font-weight: 600;
    /* bold text */
    border-radius: 50px;
    /* fully curved pill shape */
    box-shadow: 0 4px 12px rgba(51, 212, 207, 0.4);
    /* subtle shadow */
    transition: all 0.3s ease;
    /* smooth hover transition */
  }

  .btn-modern:hover {
    background-color: #28bfb4;
    /* slightly darker shade on hover */
    transform: translateY(-2px);
    /* subtle lift effect */
    box-shadow: 0 6px 15px rgba(51, 212, 207, 0.5);
  }

  .btn-modern:active {
    transform: translateY(0);
    /* reset lift on click */
    box-shadow: 0 4px 12px rgba(51, 212, 207, 0.4);
  }

  .agreement-section {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 12px;
    background-color: #dce7ed;
    transition: all 0.5s ease, box-shadow 0.3s ease;
    overflow: hidden;
    max-height: 1000px;
    opacity: 1;
    position: relative;
  }

  .text-page-section {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 12px;
    background-color: #dce7ed;
    transition: all 0.5s ease, box-shadow 0.3s ease;
    overflow: hidden;
    max-height: 1000px;
    opacity: 1;
    position: relative;
  }

  .agreement-section.hide {
    max-height: 0;
    opacity: 0;
    padding: 0 20px;
  }

  .agreement-header {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .agreement-icon {
    animation: bounceIn 0.6s ease, glow 2s infinite alternate;
    color: #33d4cf;
  }

  .text-danger-registration {
    width: 100% !important;
    font-size: 0.875rem !important;
  }

  /* Bounce animation */
  @keyframes bounceIn {
    0% {
      transform: scale(0);
    }

    50% {
      transform: scale(1.2);
    }

    100% {
      transform: scale(1);
    }
  }

  /* Glow/pulse effect */
  @keyframes glow {
    0% {
      text-shadow: 0 0 5px #33d4cf;
    }

    50% {
      text-shadow: 0 0 15px #33d4cf;
    }

    100% {
      text-shadow: 0 0 5px #33d4cf;
    }
  }

  /* Drag & Drop Zone */
  .drop-zone {
    border: 2px dashed #33d4cf;
    border-radius: 12px;
    background: #f9fbfd;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
  }

  .drop-zone:hover {
    background: #e8fafa;
    border-color: #22bfb8;
  }

  /* Overall Preview Section */
  /* Preview container */
  /* Preview container */
  .preview-container {
    display: flex !important;
    flex-wrap: wrap !important;
    margin-top: 15px !important;
    width: 100% !important;
    box-sizing: border-box !important;
    justify-content: center !important;
    align-items: center !important;
  }

  /* Show border only when files exist */
  .preview-container.with-border {
    border: 1px solid #ccc !important;
    border-radius: 12px !important;
    background: #fafafa !important;
    padding: 15px !important;
    box-shadow: 0 0 4px #ccc;
  }



  /* Image wrapper */
  .preview-wrapper {
    position: relative;
    width: 250px;
    /* larger width */
    height: 180px;
    /* larger height */
    padding: 8px;
    border: 2px solid #ccc;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: transform 0.2s;
    box-sizing: border-box;
  }

  .preview-wrapper:hover {
    transform: scale(1.05);
  }

  .preview-wrapper img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    /* fully visible, no cropping */
    display: block;
  }

  /* Remove button */
  .remove-btn {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 16px;
    cursor: pointer;
    line-height: 1;
  }

  /* File name below preview */
  .file-name {
    display: block;
    text-align: center;
    font-size: 0.85rem;
    word-break: break-word;
    max-width: 250px;
    /* match wrapper width */
    margin-top: 8px;
  }

  /* ==== Spinner Overlay: Top Center ==== */
  /* ==== Full-Screen Overlay ==== */
  #spinnerOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(4px);
    display: none;
    /* Toggle to 'flex' with JS */
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  /* ==== Centered Loader Box ==== */
  .status-container {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(12px);
    padding: 20px 32px;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    font-family: "Segoe UI", "Roboto", sans-serif;
    border: 1px solid rgba(200, 200, 200, 0.5);
    animation: fadeInScale 0.4s ease-in-out;
  }

  /* ==== Icon Styling (Hourglass) ==== */
  .status-icon {
    font-size: 42px;
    color: #007bff;
    animation: pulse 1.6s infinite;
    margin-bottom: 10px;
  }

  /* ==== Text Styling ==== */
  .status-text {
    font-size: 18px;
    font-weight: 600;
    background: linear-gradient(90deg, #056a67, #29afab);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
  }

  /* ==== Animated Dots ==== */
  .animated-dots::after {
    content: "";
    display: inline-block;
    animation: dots 1.5s steps(3, end) infinite;
  }

  /* ==== Keyframes ==== */
  @keyframes dots {
    0% {
      content: "";
    }

    33% {
      content: ".";
    }

    66% {
      content: "..";
    }

    100% {
      content: "...";
    }
  }

  @keyframes pulse {

    0%,
    100% {
      transform: scale(1);
      opacity: 1;
    }

    50% {
      transform: scale(1.1);
      opacity: 0.7;
    }
  }

  @keyframes fadeInScale {
    from {
      opacity: 0;
      transform: scale(0.95);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
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

      <?php
      $_Amaxlength = array();
      $_Amaxlength['pro_title']    = 200;
      $_Amaxlength['pro_project_address']   = 200;
      $_Amaxlength['pro_customer_name']   = 200;
      $_Amaxlength['pro_customer_address']   = 200;
      ?>

      <div id="spinnerOverlay">
        <div class="status-container">
          <div class="status-icon">⏳</div>
          <p class="status-text">
            Generating proposal PDF<span class="animated-dots"></span>
          </p>
        </div>
      </div>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-12 grid-margin">
              <div class="card">

                <div class="breadcrumb-floating ms-3 mt-2 pb-1">
                  <a href="<?php echo BASE_URL; ?>">Dashboard</a>
                  <span>››</span>
                  <a href="<?php echo BASE_URL; ?>proposals">Proposals</a>
                  <span>››</span>                     
                  <span class="current"><?php if (isset($proposal['pro_id']) && !empty($proposal['pro_id'])) { ?> Edit <?php } else { ?> Add <?php } ?> Proposal</span>
                </div>

                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-primary border shadow-sm">

                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-file-earmark-pdf-fill fs-3 text-white"></i>
                      <h3 class="mb-0 text-white"><?php if (isset($proposal['pro_id']) && !empty($proposal['pro_id'])) { ?> Update Propasal <span class="smallHead">-</span> <?php } else { ?> Create Proposal <?php } ?> <span class="smallHead"> <?php echo @$proposal['pro_title']; ?></span></h3>
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

                  <form autocomplete="off" enctype="multipart/form-data" class="cmxform pt-3 proposal-form" <?php if (isset($proposal['pro_id'])) { ?> name="updateProposal" id="updateProposal" <?php } else { ?> name="addProposal" id="addProposal" <?php } ?> method="post" action="<?php echo BASE_URL; ?>storeproposal">

                    <?php if (isset($proposal['pro_id'])) { ?>
                      <input type="hidden" name="pro_id" id="pro_id" value="<?php echo $proposal['pro_id']; ?>" />
                    <?php } ?>



                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-form-label">Proposed By Company <span class="text-danger">*</span></label>
                          <select class="form-select" id="pro_com_id" name="pro_com_id">
                            <option value="">Select Company</option>
                            <?php
                            if ($companyDetails && is_array($companyDetails) && count($companyDetails) > 0) {
                              foreach ($companyDetails as $key => $company) { ?>
                                <option value="<?php echo $company['com_id']; ?>"
                                  <?php if (@$proposal['pro_com_id'] == $company['com_id']) echo "selected"; ?>>
                                  <?php echo $company['com_name']; ?>
                                </option>
                            <?php }
                            } ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-form-label">Proposal Title <span class="text-danger">*</span></label>
                          <input type="text" id="pro_title" name="pro_title"
                            value="<?php echo @$proposal['pro_title']; ?>"
                            class="form-control custom-input"
                            autocomplete="off"
                            maxlength="<?php echo $_Amaxlength['pro_title']; ?>" />
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-form-label">Project Location <span class="text-danger">*</span></label>
                          <textarea id="pro_project_address" name="pro_project_address"
                            class="form-control custom-input"
                            rows="10"
                            maxlength="<?php echo $_Amaxlength['pro_project_address']; ?>"
                            autocomplete="off"><?php echo @$proposal['pro_project_address']; ?></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="pro_water_mark_inc" name="pro_water_mark_inc" value="1"
                              <?php if (!empty($proposal['pro_water_mark_inc'])) echo "checked"; ?>>
                            <label class="form-check-label" for="pro_water_mark_inc">
                              Include watermark on all pages.
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="pro_agrement_page_inc" name="pro_agrement_page_inc" value="1"
                              <?php if (!empty($proposal['pro_agrement_page_inc'])) echo "checked"; ?>>
                            <label class="form-check-label" for="pro_agrement_page_inc">
                              Include agreement page at the end of PDF.
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="pro_text_page_inc" name="pro_text_page_inc" value="1"
                              <?php if (!empty($proposal['pro_text_page_inc'])) echo "checked"; ?>>
                            <label class="form-check-label" for="pro_text_page_inc">
                              Include text page at the begining of PDF.
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="agreement-section mt-3 text-center hide" id="agreement_section">

                      <div class="d-flex align-items-center mb-3"
                        style="border-left:4px solid #33d4cf; padding-left:10px;">
                        <i class="bi bi-people-fill" style="font-size:1.2rem; color:#33d4cf; margin-right:8px;"></i>
                        <h5 class="mb-0" style="color:#333; font-weight:500;">Customer Details</h5>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-form-label" style="float: left;">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" id="pro_customer_name" name="pro_customer_name"
                              value="<?php echo @$proposal['pro_customer_name']; ?>"
                              class="form-control custom-input"
                              autocomplete="off"
                              maxlength="<?php echo $_Amaxlength['pro_customer_name']; ?>" />
                          </div>
                        </div>
                      </div>

                      <div class="row justify-content-center">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-form-label" style="float: left;">Customer Address<span class="text-danger">*</span></label>
                            <textarea id="pro_customer_address" name="pro_customer_address"
                              class="form-control custom-input"
                              rows="10"
                              maxlength="<?php echo $_Amaxlength['pro_customer_address']; ?>"
                              autocomplete="off"><?php echo @$proposal['pro_customer_address']; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="text-page-section mt-3 hide" id="text_page_section">
                      <div class="d-flex align-items-center mb-3"
                        style="border-left:4px solid #33d4cf; padding-left:10px;">
                        <i class="bi bi-file-text" style="font-size:1.2rem; color:#33d4cf; margin-right:8px;"></i>
                        <h5 class="mb-0" style="color:#333; font-weight:500;">Text Page Content</h5>
                      </div>
                      <textarea id="pro_text_page" name="pro_text_page" class="form-control">
                        <?php echo @$proposal['pro_text_page']; ?>
                      </textarea>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-form-label mb-2"> Upload Images for PDF<span class="text-danger">*</span>
                          <span class="" style="font-size: 0.85rem; color: #6c757d;padding-left :25px">
                            Formats: JPG, JPEG, PNG | Max file size: 5MB | Max file count: 25 | Recommended resolution: 1000×1000 px or higher 
                          </span>                            
                          </label>
                          <div id="drop-zone" class="drop-zone">
                            <p class="mb-0"><i class="bi bi-upload me-2"></i> Drag & Drop files here or click to upload</p>
                            <input type="file" id="fileInput" name="files[]" class="d-none" multiple accept=".jpg,.jpeg,.png">
                          </div>
                          <div id="preview-container" class="preview-container mt-3 row g-3" style="margin-left:1px"></div>
                        </div>
                      
                      </div>
                    </div>

                    <!-- Hidden input (fallback for file persistence on form error) -->
                    <input type="hidden" id="uploadedFiles" name="uploadedFiles">


                    <div style="padding-top:15px; text-align:center;">
                      <button type="submit" class="btn btn-primary btn-modern">Generate Proposal</button>
                    </div>
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
       <script src="<?php echo ASSETS_DIR; ?>/js/tinymce/tinymce.min.js"></script>
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

      

      <script>
        let filesArray = []; // To store selected files
        document.addEventListener("DOMContentLoaded", function() {
          const agreementCheckbox = document.getElementById("pro_agrement_page_inc");
          const textPageCheckbox = document.getElementById("pro_text_page_inc");

          const agreementSection = document.getElementById("agreement_section");
          const textPageSection = document.getElementById("text_page_section");

          let tinyMCEInitialized = false;

          function toggleAgreementSection() {
            if (agreementCheckbox.checked) {
              agreementSection.classList.remove("hide");
            } else {
              agreementSection.classList.add("hide");
            }
          }

          function toggleTextPageSection() {
            if (textPageCheckbox.checked) {
              textPageSection.classList.remove("hide");

              if (!tinyMCEInitialized) {
                tinymce.init({
                  selector: '#pro_text_page',
                  height: 300,
                  menubar: false,
                  plugins: 'lists link code',
                  toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist',
                  branding: false,
                  statusbar: false,
                  setup: function(editor) {
                    editor.on('input', function() {


                      const content = editor.getContent({
                        format: "text"
                      }).trim();

                      // Remove error if content exists
                      if (content.length > 0) {
                        const errorLabel = $('#pro_text_page').nextAll('label.error');
                        if (errorLabel.length) {
                          errorLabel.remove();
                          editor.getContainer().classList.remove('border', 'border-danger');
                        }
                      } else {
                        // Re-validate to show error if empty
                        $("#pro_text_page").valid();
                      }
                    });
                  }
                });
                tinyMCEInitialized = true;
              }
            } else {
              textPageSection.classList.add("hide");
            }
          }

          // Initial load
          toggleAgreementSection();
          toggleTextPageSection();

          // Event listeners
          agreementCheckbox.addEventListener("change", toggleAgreementSection);
          textPageCheckbox.addEventListener("change", toggleTextPageSection);


          const dropZone = document.getElementById("drop-zone");
          const fileInput = document.getElementById("fileInput");
          const previewContainer = document.getElementById("preview-container");
          const proposalForm = document.getElementById("addProposal");
          const hiddenUploadedFiles = document.getElementById("uploadedFiles");



          // Click to open file dialog
          dropZone.addEventListener("click", () => fileInput.click());

          // Drag events
          dropZone.addEventListener("dragover", e => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add("border-success");
          });

          dropZone.addEventListener("dragleave", () => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove("border-success");
          });

          dropZone.addEventListener("drop", e => {
            e.preventDefault();
            e.stopPropagation(); // Stop other handlers

            dropZone.classList.remove("border-success");

            // ✅ Disable file input temporarily
            fileInput.disabled = true;

            handleFiles(e.dataTransfer.files);

            // ✅ Re-enable after handling
            setTimeout(() => {
              fileInput.disabled = false;
            }, 100);
          });

          // Handle file selection via input
          fileInput.addEventListener("change", () => {
            if (fileInput.disabled) {
              return; // skip if disabled (during drop)
            }
            handleFiles(fileInput.files);
          });

          // Main file handler
          function handleFiles(selectedFiles) {
            const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            const maxFiles = 25;

            [...selectedFiles].forEach(file => {
              if (!allowedTypes.includes(file.type)) {
                showSwal("upload_img_type_alert");
                return;
              }
              if (file.size === 0) {
                showSwal("upload_img_zero_size_alert");
                return;
              }
              if (file.size > maxFileSize) {
                showSwal("upload_img_max_size_alert");
                return;
              }
              if (filesArray.length >= maxFiles) {
                showSwal("max_upload_count");
                return;
              }

              // ✅ Check for duplicates
              const isDuplicate = filesArray.some(f => f.name === file.name && f.size === file.size);
              if (isDuplicate) {
                return swal("Duplicate File", `${file.name} is already added.`, "info");
              }

              filesArray.push(file);
            });

            renderPreview();
            fileInput.value = ''; // Reset input
          }

          // Preview renderer
          function renderPreview() {
            previewContainer.innerHTML = "";

            if (filesArray.length > 0) {
              previewContainer.classList.add("with-border");
            } else {
              previewContainer.classList.remove("with-border");
            }

            filesArray.forEach((file, index) => {
              const reader = new FileReader();
              reader.onload = e => {
                const div = document.createElement("div");
                div.classList.add("preview-card", "col-auto", "m-2");
                div.innerHTML = `
        <div class="preview-wrapper">
          <img src="${e.target.result}" alt="Preview">
          <button type="button" class="remove-btn">&times;</button>
        </div>
        <span class="file-name" title="${file.name}">${file.name}</span>
      `;

                // ✅ Attach event listener for remove button
                div.querySelector(".remove-btn").addEventListener("click", () => {
                  removeFile(index);
                });

                previewContainer.appendChild(div);
              };
              reader.readAsDataURL(file);
            });
            // ✅ Trigger validator manually
            //$("#addProposal").valid();

            if (filesArray.length > 0) {
              // Remove error label if exists
              const errorLabel = document.getElementById('fileInput-error');
              if (errorLabel) {
                errorLabel.remove();
              }
            } else {
              // Trigger validation if no files
              $("#fileInput").valid();
            }

          }

          function removeFile(index) {
            filesArray.splice(index, 1);
            renderPreview();
          }

          // Intercept form submit
          proposalForm.addEventListener("submit", function(e) {

            e.preventDefault();

            tinyMCE.triggerSave();

            // Use jQuery Validate to check form
            if (!$("#addProposal").valid()) {
              return; // Stop submission if validation fails
            }

          
            document.getElementById("spinnerOverlay").style.display = "flex";

            // ✅ Build FormData with files
            const formData = new FormData(this);
            filesArray.forEach(file => {
              if (file.size > 0) {
                formData.append("files[]", file);
              }
            });

            // Send via AJAX
            fetch(this.action, {
                method: "POST",
                body: formData
              })
              .then(res => res.json())
              .then(data => {
                document.getElementById("spinnerOverlay").style.display = "none"; // Hide spinner
                if (data.success) {
                  const downloadUrl = '/downloadPdf/' + data.fileName;
                  console.log(downloadUrl);
                  const link = document.createElement('a');
                  link.href = downloadUrl;
                  link.download = data.fileName;
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);                  
                  swal({
                      title: "Success",
                      content: {
                        element: "div",
                        attributes: {
                          innerHTML: "<p style='color:#155724; font-weight:normal;font-size:16px;'>Proposal PDF generated successfully!</p>"
                        }
                      },
                      icon: "success",
                      closeOnClickOutside: false, // disable click outside
                      closeOnEsc: false                         
                    })
                    .then(() => {
                      window.location.reload();
                    });
                } else {  
                  swal({
                    title: "Error",
                    content: {
                      element: "div",
                      attributes: {
                        innerHTML: "<p style='color:#DC3545FF; font-weight:normal;font-size:16px;'>" + data.message + ".</p>"
                      }
                    },
                    icon: "error"
                  });
                }
              })
              .catch(err => {
                console.error("Fetch error:", err);
                swal({
                  title: "Error",
                  content: {
                    element: "div",
                    attributes: {
                      innerHTML: "<p style='color:#DC3545FF; font-weight:normal;font-size:16px;'>Failed to generate proposal. Please try later.</p>"
                    }
                  },
                  icon: "error"
                });
              });
          });


        });
      </script>

</body>

</html>