<?php

/* ======================================
  Filename: View proposal
  Author: Ameen 
  =======================================
*/
//Requires only at sub views are rendered
namespace app\controllers;

use  app\controllers\CommonController;
use core\View as View;
?>

<!DOCTYPE html>
<html lang="en">

<?php View::render("admin/_header", ["title" => "Welcome Admin"]); ?>
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/simplemde/simplemde.min.css">

<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/dropify/dropify.min.css">
<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/jquery-file-upload/uploadfile.css">
<!-- 
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	 -->
<link href="<?php echo ASSETS_DIR; ?>/fonts/roboto/5.0.8/400.css" rel="stylesheet">
<link href="<?php echo ASSETS_DIR; ?>/fonts/roboto/5.0.8/700.css" rel="stylesheet">
<script src="<?php echo ASSETS_DIR; ?>/js/ckeditor5/39.0.1/classic/ckeditor.js"></script>


<link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/CSS/custom/viewjobservice.css">

<style>
  /*   body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to right, #e6f0f3, #ffffff);
      margin: 0;
      padding: 20px;
    }
    .form-container {
      max-width: 800px;
      margin: auto;
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #0d3b66;
    }
    label.bold {
      font-weight: bold;
      color: #0d3b66;
      margin-top: 20px;
    }
    select, input[type="file"], input[type="text"], input[type="number"], button, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    button {

      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .option-group {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
      margin-bottom: 30px;
    }
    .option-group input[type="radio"] {
      display: none;
    }
	 .option-group input[type="checkbox"] {
      display: none;
    }
    .option-group label {
      padding: 10px 20px;
      border: 2px solid #0d3b66;
      border-radius: 20px;
      cursor: pointer;
      background: #ffffff;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .option-group input[type="radio"]:checked + label {
      background-color: #0d3b66;
      color: white;
    }
	 .option-group input[type="checkbox"]:checked + label {
      background-color: #0d3b66;
      color: white;
    } */


  .alert-dismissible {
    padding-right: 3rem;
    width: 65%;
    float: right;
    margin-right: 62px;
  }

  .alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    padding: 0.50rem 1rem;
  }

  .category-block {
    border: 1px solid #33d4cf;
    ;
    padding: 16px;
    margin-bottom: 20px;
    border-radius: 12px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }

  #categories-container {
    border: 1px solid #33d4cf;
    padding: 16px;
    margin-bottom: 20px;
    border-radius: 12px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }


  .category-block input[type="text"] {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-bottom: 12px;
  }

  #add-category-btn {
    background: #33d4cf;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    margin-bottom: 20px;
    width: 20%;
    float: right;
  }

  #add-category-btn:hover {
    background: #008c9e;
  }

  .category-main-title {
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 14px;
    color: #fff;
    background-color: #7043a4;
    padding: 6px;
  }

  .category-close-btn {
    float: right;
    background: transparent;
    border: none;
    font-size: 22px;
    color: #ef4444;
    cursor: pointer;
    margin-top: 0px;
    margin-right: 0px;
    width: 4%;
    padding: 0px;
    background: #33d4cf;
    font-weight: bold;
  }

  .category-close-btn:hover {
    color: #dc2626;
  }

  .category-title {
    width: 95%;
    background: #7043a4 1px;
    padding: 5px;
    font-weight: bold;
    color: #fff;
  }


  table.dataTable {
    width: 100% !important;
  }

  /* Allow text wrapping for long descriptions */
  table.dataTable td {
    white-space: normal;
    word-break: break-word;
  }

  .timeline-header-1 {
    padding: 16px 20px;
    background: linear-gradient(180deg, #f8fafc, #f1f5f9);
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-left: -29px;
    margin-top: -23px;
    margin-right: -29px;
    border-radius: 14px 15px 5px 5px;
    margin-bottom: 20px;
  }

  .timeline-title {
    font: 600 18px/1.2 system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
    font-size: 1.125rem;
    color: #111827;
  }

  .button-status {

    border: 1px solid #e5e7eb;
    height: 52px;
    border-radius: 5px;
    margin-top: 8px;
    margin-bottom: 2px;
    margin-left: 0px;
    margin-right: 0px;
    box-shadow: 0px 0px 1px 1px #e5e7eb;
  }

  .close_project .avgrund-popin {
    height: 200px !important;
    max-height: 200px;
    overflow-y: auto;
  }

  .application-details-box {
    background: #a3f3f0;
    border: 1px solid #e6e9f0;
  }

  .field-row {
    border-bottom: 1px solid #a9a9a9;
    transition: background 0.2s ease;
  }

  .field-row.even {
    background-color: #a3f3f0;
  }

  .field-row.odd {
    background-color: #a3f3f0;
  }

  .field-label {
    color: #6b7280 !important;
  }

  .field-value {
    font-size: 0.9rem;
  }

  .bi-info-circle {
    cursor: pointer;
  }

  .custom-border-bottom {
    border-bottom: 1px solid black !important;
  }

  .custom-action-btn {
    background-color: #056a67 !important;
    color: #fff !important;
    border: none;
  }

  .custom-action-btn:hover {
    background-color: #218838 !important;
  }

  /* Popup background (strong overrides) */
  body.setup_complete .avgrund-popin,
  .avgrund-popin,
  .avgrund-popup {
    background: #b9d7d6 !important;
    /* <-- change popup bg color here */
    border-radius: 12px !important;
    box-shadow: 0 10px 40px #056a67 !important;
    color: #1f2937 !important;
    padding: 20px !important;
    border: 1px solid #056a67;
  }

  /* Submit/primary button inside popup (cover common cases) */
  .avgrund-popin .btn-submit,
  .avgrund-popin button[type="submit"],
  .avgrund-popin .btn-primary,
  .avgrund-popin .btn,
  .avgrund-popup .btn-submit,
  .avgrund-popup button[type="submit"],
  .avgrund-popup .btn-primary,
  .avgrund-popup .btn {
    background-color: #056a67 !important;
    /* <-- change button color here */
    color: #fff !important;
    border: none !important;
    padding: 10px 20px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
  }

  /* Hover state */
  .avgrund-popin .btn-submit:hover,
  .avgrund-popin button[type="submit"]:hover,
  .avgrund-popin .btn-primary:hover,
  .avgrund-popin .btn:hover,
  .avgrund-popup .btn-submit:hover,
  .avgrund-popup button[type="submit"]:hover,
  .avgrund-popup .btn-primary:hover,
  .avgrund-popup .btn:hover {
    background-color: #218838 !important;
    /* <-- hover color */
  }

  /* (Optional) darken the page overlay behind popup */
  .avgrund-overlay {
    background: rgba(0, 0, 0, .6) !important;
  }
</style>
<?php
function timeConversion($dt)
{
  return CommonController::timeConversion($dt);
}
function dateConversion($dt)
{
  return CommonController::dateConversion($dt);
}
?>

<body>
  <div class="container-scroller">
    <?php View::render("admin/_topnavbar", ["title" => "Welcome Admin"]); ?>
    <div class="container-fluid page-body-wrapper">
      <?php View::render("admin/_sidebar", ["title" => "Welcome Admin"]); ?>
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="col-12 grid-margin">
            <div class="card">

              <div class="breadcrumb-floating ms-3 mt-2 pb-1">
                <a href="<?php echo BASE_URL; ?>proposals">All Applications</a>
                <span>››</span>
                <span class="current">View Application</span>
              </div>

              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-0 p-2 rounded bg-primary border shadow-sm">
                  <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-buildings fs-3 text-white"></i>
                    <h3 class="mb-0 text-white"> Application Details
                      <span class="smallHead">
                        <?php
                        if (!empty($loan_array['zl_code'])) {
                          echo "#" . $loan_array['zl_code'];
                        }
                        ?>
                      </span>
                  </div>

                  <a href="<?php echo BASE_URL; ?>proposals"><button class="btn btn-primary add-user-btn">
                      <i class="fas fa-user-plus mr-2"></i> Back
                    </button>
                  </a>
                </div>

                <?
                $enableActionButton = false;

                /*
                  if ($_SESSION['auth']['user_role_key'] == SUPPORT_PRO_COORDINATOR) {
                    if (isset($_Ajob['job_status']) && $_Ajob['job_status'] == JOB_STATUS_ARRAY['Job Created']) {
                      if ($_SESSION['auth']['user_id'] == $_Ajob['job_coordinator_id']) {
                        $enableActionButton = true;
                        $buttonDisplayName = "Confirm Project";
                        $bottonToolTip = "Confirm the project scope and details";
                        $buttoIdName = "assigntoManager";
                      }
                    }
                  }
                  */


                if ($_SESSION['auth']['user_department'] == 'Accounts') {
                  if (!empty($loan_array['zl_status'])) {
                    if ($loan_array['zl_status'] == 20 || $loan_array['zl_status'] == 30) {
                      $enableActionButton = true;
                      $buttonDisplayName = "Mark as Setup Complete";
                      $bottonToolTip = "Mark as completed once account setup is completed";
                      $buttoIdName = "setUpComplete";
                    }
                  }
                }


                if ($enableActionButton) {
                ?>
                  <div class="button-status">
                    <button id="<?php echo $buttoIdName ?>" class="btn custom-action-btn add-new-btns clickButtonStatus tooltip-btn badge-btn-primary " style="margin:7px;">
                      <i class="fas fa-job-plus mr-2"></i> <?php echo $buttonDisplayName ?>
                      <span class="tooltip-text"><?php echo $bottonToolTip ?></span>
                    </button>
                  </div>

                <?php
                }
                //display job details
                if (isset($loan_array) && is_array($loan_array) && count($loan_array) > 0) {
                ?>
                  <div class="w-100">
                    <div class="">
                      <div class="card-body" style="padding:0px;margin:0px;">
                        <div class="containers my-4 mt-0 pt-2 pb-2">

                          <div class="card shadow-sm rounded-4 left-panel me-2" style="width:60%;min-height:560px;box-shadow:0 2px 8px rgba(0,0,0,.2);border:1px solid #f1f1e4;">
                            <div class="card-body pb-0">

                              <div class="timeline-header-1">
                                <div class="timeline-title">
                                  <h3>
                                    <div>
                                      <div style="max-width: 400px;word-break: break-word;border:0px solid red;">
                                        <?php echo @'#' . $loan_array['zl_code'];
                                        ?>
                                      </div>
                                    </div>
                                  </h3>
                                </div>
                                <span style="border-radius:50px;" class="badge badge-success"> <?php echo @LOAN_STATUS_ARRAY[$loan_array['zl_status']]; ?></span>
                              </div>


                              <div class="row align-items-center" style="min-height:60px;">
                                <!-- Column 1 (Left - Project Manager) -->
                                <div class="col-md-4 d-flex align-items-center">
                                  <img src="<?php echo ASSETS_DIR; ?>/images/trust.png"
                                    alt="Profile Picture"
                                    class="rounded-circle me-2"
                                    style="width:60px; height:60px; object-fit:cover;">
                                  <div>
                                    <div class="fw-semibold fs-6 text-break">
                                      <?php
                                      $userName = "Not Available";
                                      $userTitle = "Not Available";
                                      if (!empty($loan_array['zl_buying_as_id'])) {
                                        if ($loan_array['zl_buying_as_id'] == 1) {
                                          $userName = isset($loan_array['zl_fname']) ? $loan_array['zl_fname'] : '';
                                          $userName .= isset($loan_array['zl_lname']) ? " " . $loan_array['zl_lname'] : '';
                                          $userTitle = "Individual";
                                        } elseif ($loan_array['zl_buying_as_id'] == 2) {
                                          $userName = isset($loan_array['zl_trust_name']) ? $loan_array['zl_trust_name'] : '';
                                          $userTitle = "Trust";
                                        } elseif ($loan_array['zl_buying_as_id'] == 3) {
                                          $userName = isset($loan_array['zl_smsf_name']) ? $loan_array['zl_smsf_name'] : '';
                                          $userTitle = "SMSF";
                                        }
                                      }

                                      echo $userName;
                                      ?>
                                    </div>
                                    <div class="text-muted small"><?php echo $userTitle ?></div>

                                    <!-- ✅ Trust Setup Status -->
                                    <?php if (isset($loan_array['zl_trust_setup_required']) && $loan_array['zl_buying_as_id'] == 2): ?>
                                      <?php if ($loan_array['zl_trust_setup_required'] == 1): ?>
                                        <div class="info-row small">
                                          <i class="typcn typcn-tick text-success"></i>
                                          <span class="label">Trust Setup :</span>
                                          <span class="value text-success">Required</span>
                                        </div>
                                      <?php elseif ($loan_array['zl_trust_setup_required'] == 2): ?>
                                        <div class="info-row small">
                                          <i class="typcn typcn-times text-danger"></i>
                                          <span class="label">Trust Setup :</span>
                                          <span class="value text-danger">Not Required</span>
                                        </div>
                                      <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- 🏦 SMSF Setup Status -->
                                    <?php if (isset($loan_array['zl_smsf_setup_required']) && $loan_array['zl_buying_as_id'] == 3): ?>
                                      <?php if ($loan_array['zl_smsf_setup_required'] == 1): ?>
                                        <div class="info-row small">
                                          <i class="typcn typcn-tick text-success"></i>
                                          <span class="label">SMSF Setup :</span>
                                          <span class="value text-success">Required</span>
                                        </div>
                                      <?php elseif ($loan_array['zl_smsf_setup_required'] == 2): ?>
                                        <div class="info-row small">
                                          <i class="typcn typcn-times text-danger"></i>
                                          <span class="label">SMSF Setup :</span>
                                          <span class="value text-danger">Not Required</span>
                                        </div>
                                      <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- 👥 Co-Applicant Name -->
                                    <?php
                                    if (!empty($loan_array['zl_fname2']) || !empty($loan_array['zl_lname2'])):
                                      $coApplicantName = trim(($loan_array['zl_fname2'] ?? '') . ' ' . ($loan_array['zl_lname2'] ?? ''));
                                    ?>
                                      <div class="info-row small">
                                        <i class="typcn typcn-user-outline text-primary"></i>
                                        <span class="label">Co-Applicant :</span>
                                        <span class="value"><?php echo $coApplicantName; ?></span>
                                      </div>
                                    <?php endif; ?>

                                  </div>
                                </div>

                                <!-- Column 2 (Center - Client) -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                  <img src="<?php echo ASSETS_DIR; ?>/images/house.jpg"
                                    alt="Profile Picture"
                                    class="rounded-circle me-2"
                                    style="width:60px; height:60px; object-fit:cover;">
                                  <div>
                                    <div class="fw-semibold fs-6 text-break">
                                      <?php
                                      echo @PROPERTY_NAME_ARRAY[$loan_array['zl_property_id']] . " street" ?: 'Not Assigned';
                                      ?>
                                    </div>
                                    <div class="text-muted small">Property</div>
                                  </div>
                                </div>

                                <!-- Column 3: Deadline -->
                                <div class="col-md-2 d-flex align-items-center justify-content-center">
                                  <div class="info-box deadline-box1 rounded-3 text-center w-100">
                                    <div class="fw-bold small deadline-title1 mt-2">
                                      <img src="<?php echo ASSETS_DIR; ?>/images/smsf.png"
                                        alt="Profile Picture"
                                        class="rounded-circle me-2"
                                        style="width:60px; height:60px; object-fit:cover;">
                                    </div>
                                    <div class="small fw-semibold deadline-text1">
                                      <?php
                                      $sourceName = "Not Available";
                                      if (!empty($loan_array['zl_loan_required']) && $loan_array['zl_loan_required'] == 1) {
                                        $sourceName = "Loan";
                                      } elseif (!empty($loan_array['zl_cash_investment']) && $loan_array['zl_cash_investment'] == 1) {
                                        $sourceName = "Cash";
                                      }
                                      echo "Source : " . $sourceName;
                                      ?>

                                    </div>
                                  </div>
                                </div>

                                <!-- Column 4 (Right - Progress) -->
                                <?php
                                $progressValue = 0;
                                if (isset($loan_array['zl_loan_progress_percentage']) && $loan_array['zl_loan_progress_percentage']) {
                                  $progressValue = round($loan_array['zl_loan_progress_percentage']);
                                }
                                ?>
                                <div class="col-md-2 d-flex align-items-center justify-content-end">
                                  <div class="d-flex flex-column align-items-center">
                                    <div class="progress-circle-lg mb-1" style="--percent:<?php echo $progressValue; ?>">
                                      <svg class="progress-ring" viewBox="0 0 120 120">
                                        <circle class="progress-ring__bg" cx="60" cy="60" r="54" />
                                        <circle class="progress-ring__progress" cx="60" cy="60" r="54" />
                                      </svg>
                                      <div class="progress-text">
                                        <?php echo $progressValue; ?>
                                        <span class="small-percent">%</span>
                                      </div>
                                    </div>
                                    <div class="text-muted small">Completed</div>
                                  </div>
                                </div>
                              </div>
                              <?php
                              //show only for admin


                              //trust section display logic  
                              $showTrustSection = false;
                              if (count($trust_array) > 0) {
                                if (!empty($_SESSION['auth']['user_department'])) {
                                  if ($_SESSION['auth']['user_department'] == 'Client' || $_SESSION['auth']['user_department'] == 'Admin' || $_SESSION['auth']['user_department'] == 'Legal') {
                                    $showTrustSection = true;
                                  } elseif ($_SESSION['auth']['user_department'] == 'Accounts') {
                                    if (!empty($loan_array['zl_status'])) {
                                      if ($loan_array['zl_status'] == 20) {
                                        $showTrustSection = true;
                                      }
                                    }
                                  }
                                }
                              }


                              if ($showTrustSection) {
                              ?>
                                <!-- ✅ Trust section start -->
                                <div class="col-12 mt-5 mb-5">
                                  <div class="application-details-box p-3 rounded-4 shadow-sm">
                                    <!-- ✅ Title with info icon -->
                                    <div class="d-flex align-items-center mb-1 pb-3 custom-border-bottom">
                                      <h5 class="fw-bold text-dark mb-0 me-2">Trust Details</h5>
                                      <i class="bi bi-info-circle text-muted fs-5"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="This section shows all key information related to the application including applicant, cost, status, and other details.">
                                      </i>
                                    </div>

                                    <!-- Field Grid -->
                                    <div class="row g-0">
                                      <?php
                                      // Example fields array (you can generate dynamically)
                                      $fields = [
                                        'Company Name' => @$trust_array['company_name'] ?? 'N/A',
                                        'Trust Name' => @$trust_array['trust_name'] ?? 'N/A',
                                        'Director 1 Name' => @$trust_array['director1_name'] ?? 'N/A',
                                        'Director 1 Directir ID' => @$trust_array['director1_id'] ?? 'N/A',
                                        'Director 1 Address' => @$trust_array['director1_address'] ?? 'N/A',
                                        'Director 1 DOB' => (isset($trust_array['director1_dob']) && $trust_array['director1_dob']) ? CommonController::formatDisplayDate($trust_array['director1_dob']) : 'N/A',
                                        'Director 1 Place of Birth' => @$trust_array['director1_pob'] ?? 'N/A',
                                        'Director 1 Tax File Number' => @$trust_array['director1_tfn'] ?? 'N/A',
                                        'Director 2 Name' => @$trust_array['director2_name'] ?? 'N/A',
                                        'Director 2 Directir ID' => @$trust_array['director2_id'] ?? 'N/A',
                                        'Director 2 Address' => @$trust_array['director2_address'] ?? 'N/A',
                                        'Director 2 DOB' => (isset($trust_array['director2_dob']) && $trust_array['director2_dob']) ? CommonController::formatDisplayDate($trust_array['director2_dob']) : 'N/A',
                                        'Director 2 Place of Birth' => @$trust_array['director2_pob'] ?? 'N/A',
                                        'Director 2 Tax File Number' => @$trust_array['director2_tfn'] ?? 'N/A',
                                        'Share Holder 1 Name' => @$trust_array['shareholder1_name'] ?? 'N/A',
                                        'Share Holder 1 Address' => @$trust_array['shareholder1_address'] ?? 'N/A',
                                        'Share Holder 2 Name' => @$trust_array['shareholder2_name'] ?? 'N/A',
                                        'Share Holder 2 Address' => @$trust_array['shareholder2_address'] ?? 'N/A',
                                        'Beneficiaries' => @$trust_array['beneficiaries'] ?? 'N/A',
                                        'Appointors' => @$trust_array['appointors'] ?? 'N/A',
                                      ];

                                      $i = 0;
                                      foreach ($fields as $label => $value):
                                        $rowClass = ($i % 2 == 0) ? 'field-row even' : 'field-row odd';
                                      ?>
                                        <div class="col-md-6 col-sm-12 <?php echo $rowClass; ?>">
                                          <div class="d-flex flex-column p-2 h-100">
                                            <div class="field-label fw-semibold text-secondary small text-uppercase mb-1">
                                              <?php echo htmlspecialchars($label); ?>
                                            </div>
                                            <div class="field-value fw-semibold text-dark">
                                              <?php echo !empty($value) ? htmlspecialchars($value) : '—'; ?>
                                            </div>
                                          </div>
                                        </div>
                                      <?php
                                        $i++;
                                      endforeach;
                                      ?>
                                    </div>
                                  </div>
                                </div>
                                <!-- ✅ Trust section end -->
                              <?
                              }


                              //smsf section display logic  
                              $showSmsfSection = false;
                              if (count($smsf_array) > 0) {
                                if (!empty($_SESSION['auth']['user_department'])) {
                                  if ($_SESSION['auth']['user_department'] == 'Client' || $_SESSION['auth']['user_department'] == 'Admin' || $_SESSION['auth']['user_department'] == 'Legal') {
                                    $showSmsfSection = true;
                                  } elseif ($_SESSION['auth']['user_department'] == 'Accounts') {
                                    if (!empty($loan_array['zl_status'])) {
                                      if ($loan_array['zl_status'] == 30) {
                                        $showSmsfSection = true;
                                      }
                                    }
                                  }
                                }
                              }


                              if ($showSmsfSection) {
                              ?>
                                <!-- ✅ Trust section start -->
                                <div class="col-12 mt-5 mb-5">
                                  <div class="application-details-box p-3 rounded-4 shadow-sm">
                                    <!-- ✅ Title with info icon -->
                                    <div class="d-flex align-items-center mb-1 pb-3 custom-border-bottom">
                                      <h5 class="fw-bold text-dark mb-0 me-2">SMSF Details</h5>
                                      <i class="bi bi-info-circle text-muted fs-5"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="This section shows all key information related to the application including applicant, cost, status, and other details.">
                                      </i>
                                    </div>

                                    <!-- Field Grid -->
                                    <div class="row g-0">
                                      <?php
                                      // Example fields array (you can generate dynamically)
                                      $fields = [
                                        'SMSF Name' => @$smsfArray['smsf_name'] ?? 'N/A',
                                        'Company Name' => @$smsfArray['company_name'] ?? 'N/A',
                                        'Director 1 Name' => @$smsfArray['member1_name'] ?? 'N/A',
                                        'Director 1 Directir ID' => @$smsfArray['member1_id'] ?? 'N/A',
                                        'Director 1 Address' => @$smsfArray['member1_address'] ?? 'N/A',
                                        'Director 1 DOB' => (isset($smsfArray['member1_dob']) && $smsfArray['member1_dob']) ? CommonController::formatDisplayDate($smsfArray['member1_dob']) : 'N/A',
                                        'Director 1 Place of Birth' => @$smsfArray['member1_pob'] ?? 'N/A',
                                        'Director 1 Tax File Number' => @$smsfArray['member1_tfn'] ?? 'N/A',
                                        'Director 2 Name' => @$smsfArray['member2_name'] ?? 'N/A',
                                        'Director 2 Directir ID' => @$smsfArray['member2_id'] ?? 'N/A',
                                        'Director 2 Address' => @$smsfArray['member2_address'] ?? 'N/A',
                                        'Director 2 DOB' => (isset($smsfArray['member2_dob']) && $smsfArray['member2_dob']) ? CommonController::formatDisplayDate($smsfArray['member2_dob']) : 'N/A',
                                        'Director 2 Place of Birth' => @$smsfArray['member2_pob'] ?? 'N/A',
                                        'Director 2 Tax File Number' => @$smsfArray['member2_tfn'] ?? 'N/A',
                                        'Director 3 Name' => @$smsfArray['member3_name'] ?? 'N/A',
                                        'Director 3 Directir ID' => @$smsfArray['member3_id'] ?? 'N/A',
                                        'Director 3 Address' => @$smsfArray['member3_address'] ?? 'N/A',
                                        'Director 3 DOB' => (isset($smsfArray['member3_dob']) && $smsfArray['member3_dob']) ? CommonController::formatDisplayDate($smsfArray['member3_dob']) : 'N/A',
                                        'Director 3 Place of Birth' => @$smsfArray['member3_pob'] ?? 'N/A',
                                        'Director 3 Tax File Number' => @$smsfArray['member3_tfn'] ?? 'N/A',
                                        'Director 4 Name' => @$smsfArray['member4_name'] ?? 'N/A',
                                        'Director 4 Directir ID' => @$smsfArray['member4_id'] ?? 'N/A',
                                        'Director 4 Address' => @$smsfArray['member4_address'] ?? 'N/A',
                                        'Director 4 DOB' => (isset($smsfArray['member4_dob']) && $smsfArray['member4_dob']) ? CommonController::formatDisplayDate($smsfArray['member4_dob']) : 'N/A',
                                        'Director 4 Place of Birth' => @$smsfArray['member4_pob'] ?? 'N/A',
                                        'Director 4 Tax File Number' => @$smsfArray['member4_tfn'] ?? 'N/A',

                                      ];

                                      $i = 0;
                                      foreach ($fields as $label => $value):
                                        $rowClass = ($i % 2 == 0) ? 'field-row even' : 'field-row odd';
                                      ?>
                                        <div class="col-md-6 col-sm-12 <?php echo $rowClass; ?>">
                                          <div class="d-flex flex-column p-2 h-100">
                                            <div class="field-label fw-semibold text-secondary small text-uppercase mb-1">
                                              <?php echo htmlspecialchars($label); ?>
                                            </div>
                                            <div class="field-value fw-semibold text-dark">
                                              <?php echo !empty($value) ? htmlspecialchars($value) : '—'; ?>
                                            </div>
                                          </div>
                                        </div>
                                      <?php
                                        $i++;
                                      endforeach;
                                      ?>
                                    </div>
                                  </div>
                                </div>
                                <!-- ✅ Trust section end -->
                              <?
                              }
                              ?>
                            </div>
                          </div>


                          <div class="">

                            <?php
                            $projectStatus = [
                              'created_on' => $_Ajob['job_created_on'],
                              'confirmed_on' => $_Ajob['job_confirmed_on'],
                              'assigned_on' => $_Ajob['job_assigned_on'],
                              'progress_on' => $_Ajob['job_started_on'],
                              'delivered_on' => $_Ajob['job_deliverd_on'],
                              'closed_on' => $_Ajob['job_closed_on'],
                            ];

                            ?>

                            <div class="timeline-card">
                              <div class="timeline-header">
                                <div class="timeline-title">Application Timeline</div>
                              </div>

                              <?php

                              $_AprogressArr[0] = 5;
                              $_AprogressArr[1] = 20;
                              $_AprogressArr[2] = 40;
                              $_AprogressArr[3] = 55;
                              $_AprogressArr[4] = 75;
                              $_AprogressArr[5] = 100;

                              $progressrate =  $_AprogressArr[0];
                              if (!empty($projectStatus['confirmed_on'])) {
                                $progressrate = $_AprogressArr[1];
                              }
                              if (!empty($projectStatus['assigned_on'])) {
                                $progressrate = $_AprogressArr[2];
                              }
                              if (!empty($projectStatus['progress_on'])) {
                                $progressrate = $_AprogressArr[3];
                              }
                              if (!empty($projectStatus['delivered_on'])) {
                                $progressrate = $_AprogressArr[4];
                              }
                              if (!empty($projectStatus['closed_on'])) {
                                $progressrate = $_AprogressArr[5];
                              }


                              ?>

                              <div class="timeline-body">
                                <div class="timeline" style="--progress: <?php echo $progressrate; ?>;">

                                  <!-- Created -->
                                  <div class="t-item done">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Application Initiated</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        Application initiated by the <b>user</b>.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                  <div class="t-item <?php echo !empty($projectStatus['confirmed_on']) ? 'done' : ''; ?>">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Application Completed</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        Application completed by the <b>user</b>.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                  <div class="t-item <?php echo !empty($projectStatus['confirmed_on']) ? 'done' : ''; ?>">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Finance Approved</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        <b>Finance Team</b> approved loan.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                  <div class="t-item <?php echo !empty($projectStatus['confirmed_on']) ? 'done' : ''; ?>">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Finance Rejected</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        <b>Finance Team</b> reject loan.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                  <div class="t-item <?php echo !empty($projectStatus['confirmed_on']) ? 'done' : ''; ?>">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Trust Setup</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        Trust Setup Completed by <b>accounts team</b>.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                  <div class="t-item <?php echo !empty($projectStatus['confirmed_on']) ? 'done' : ''; ?>">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Legal Approved</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        <b>Legal Team</b> processed the application.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                  <div class="t-item <?php echo !empty($projectStatus['confirmed_on']) ? 'done' : ''; ?>">
                                    <span class="t-dot"></span>
                                    <div class="t-label">Closed</div>
                                    <div class="t-date fw-bold">
                                      <?php echo !empty($projectStatus['created_on']) ? timeConversion($projectStatus['created_on']) : '<span class="empty">Pending</span>'; ?>
                                    </div>
                                    <div class="t-note">
                                      <?php
                                      if ($_SESSION['auth']['user_role_key'] == SUPER_ADMIN || $_SESSION['auth']['user_role_key'] == ADMIN_MEMBER) {
                                        if (!empty($_Ajob['job_created_by'])) {
                                          $createdbyUser = CommonController::getUserNameById($_Ajob['job_created_by']);
                                          echo " Project created by <b>" . ($createdbyUser ?: 'the client') . "</b>.";
                                        } else {
                                          echo "Project created by the <b>client</b>.";
                                        }
                                      } else {
                                      ?>
                                        Application officially closed.
                                      <?
                                      }
                                      ?>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div style="clear:both"></div>

                      </div> <!-- end outer card-body -->
                    </div> <!-- end outer card -->
                  </div> <!-- end w-100 bg -->
                <?
                }
                //no job found
                else {
                ?>
                  <div class="w-100" style="background-color: #f8f9fa;">
                    <div class="card shadow-sm rounded-4 border-0 w-100">
                      <div class="card-body">
                        <div class="containers">
                          <div style="color:red">
                            <div style='padding-top:5px'>Error while loading page...</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?
                }
                ?>

              </div> <!-- end card-body -->
            </div> <!-- end card -->
          </div> <!-- end col-12 -->

        </div> <!-- content-wrapper ends -->
        <?php
        View::render("admin/_footer");
        ?>
        <!-- partial -->
      </div>
    </div> <!-- page-body-wrapper ends -->
  </div> <!-- container-scroller -->




  <!-- ========= setup complete Popup ============ -->
  <!-- ✅ FIXED TEMPLATE -->
  <div id="setUpCompleteTemplates" style="display: none;">
    <div class="popup-header text-center">
      <h5>Are you sure want to mark as setup complete?</h5>
    </div>

    <form id="setUpCompleteForm" method="post" action="#" class="popup-form">
      <input type="hidden" name="loan_id" id="loan_id" value="<?php echo $loan_array['zl_id']; ?>" />

      <div class="form-actions text-center">
        <button type="submit" class="btn-submit">
          <i class="bi bi-send-fill me-1"></i> Submit
        </button>
      </div>
    </form>
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
  <script>
    $(document).ready(function() {
      var table = $('#jobTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        searching: false, // This removes the default search box            
        order: [
          [0, 'desc']
        ],
        columnDefs: [{
            orderable: false,
            targets: [8]
          } // Disables sorting (0-based index)
        ],
        ajax: {
          url: '/admin/ajaxjobservicelist', // change to your route
          type: 'POST',
          data: function(d) { //job_name  job_department job_role
            d.job_id = <?php echo @$_Ajob['job_id']; ?>;
            //d.job_id ='';
          }
        },
        columns: [{
            data: 'id'
          },
          {
            data: 'service_ref'
          },
          {
            data: 'created_on'
          },
          {
            data: 'cat_name'
          },
          {
            data: 'ser_name'
          },
          {
            data: 'deadline'
          },
          {
            data: 'progress'
          },
          {
            data: 'status_label'
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
          $('#jobTable_length').hide(); // hides "Show X entries"
          $('#jobTable_paginate').hide(); // optionally hide pagination controls
          $('#jobTable_info').hide(); // optionally hide "Showing 1 to..." info
        } else {
          $('#jobTable_length').show();
          $('#jobTable_paginate').show();
          $('#jobTable_info').show();
        }
      });

    });
  </script>


  <script>
    $(document).ready(function() {


      $(document).on('submit', '#setUpCompleteForm', function(e) {

        e.preventDefault(); // Prevent default form submission

        // Hide the button immediately
        $('#setUpComplete').prop('disabled', true); // disables the button 

        // Optional: Collect and log form data
        const formDataEng = new FormData(this);

        for (const [key, value] of formDataEng.entries()) {
          console.log(`${key}:`, value);
        }

        $('.loading').removeClass('hide');
        $('.loading-content').html('Please wait, updating status');
        $.ajax({
          url: "/setup", // Your form submission URL
          method: "POST",
          data: formDataEng,
          processData: false,
          contentType: false,
          success: function(response) {
            let data = JSON.parse(response);
            if (data.status == true) {

              $('.loading').addClass('hide');

              swal(data.message, {
                icon: "success",
                timer: 3000,
                buttons: false
              });

              $('.avgrund-close').trigger('click');

              setTimeout(() => {
                window.location.href = "<?php echo BASE_URL; ?>proposals";
              }, 3000);

            }
          },
          error: function(xhr, status, error) {
            //$('.loading').addClass('hide');
            //alert("Final form submission failed: " + error);

            swal('Error while updating status. Please try again later', {
              icon: "error",
              timer: 3000,
              buttons: false
            });

            setTimeout(() => {
              window.location.reload();
            }, 3000);

          }
        });


      });

      // Initialize popup ONCE
      $('#setUpComplete').avgrund({
        height: 500,
        holderClass: 'setup_complete',
        showClose: true,
        showCloseText: 'x',
        onBlurContainer: '.container-scroller',
        closeByEscape: true,
        closeByDocument: false,
        template: '',
        onLoad: function() {
          const interval = setInterval(() => {
            const popup = document.querySelector('.avgrund-popin');
            const setupComplete = $('#setUpCompleteTemplates').html();
            if (!popup) return;
            clearInterval(interval);
            popup.innerHTML = setupComplete;

            const closeBtn = document.createElement('a');
            closeBtn.href = '#';
            closeBtn.className = 'avgrund-close';
            closeBtn.textContent = 'x';
            popup.appendChild(closeBtn);

            popup.style.setProperty('height', '200px', 'important');
            popup.style.setProperty('max-height', '200px', 'important');
            popup.style.setProperty('overflow-y', 'auto', 'important');
          }, 100);
        }
      });

      // Just prevent default if needed
      $(document).on('click', '#setUpComplete', function(e) {
        e.preventDefault();
      });
    });
  </script>


</body>

</html>