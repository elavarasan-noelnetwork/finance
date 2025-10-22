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

input {
  letter-spacing: 0.6px;
}

  ::-webkit-scrollbar {
    width: 0px;
    background: transparent;
  }

  html {
    scrollbar-width: none;
  }

  html,
  body {
    scrollbar-gutter: stable;
    scroll-behavior: smooth;
    margin: 0;
    padding: 0;
    height: 100%;
  }

  .page-application .page-body-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  .page-application .main-panel {
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .page-application .content-wrapper {
    padding: 0 !important;
    margin: 0 !important;
  }

  .form-layout {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
  }

  .form-sidebar-menu {
    width: 300px;
    flex-shrink: 0;
    min-height: 950px;
    background: #e5fffe;
    border-right: 1px solid #056a67;
    padding-right: 10px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    margin-top: 30px;
  }

  .form-sidebar-menu .menu-item {
    background: #33d4cf;
    color: #434a54;
    font-weight: 600;
    padding: 18px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s ease;
  }

  .form-content {
    width: calc(100% - 300px);
    padding: 40px 60px;
    padding-left: 80px;
    padding-top: 60px;
    background: #e5fffe;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 90vh;
  }

  .form-sidebar h2 {
    font-weight: 600;
    font-size: 1.5rem;
    color: #056a67;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  @media (max-width: 768px) {
    .form-layout {
      flex-direction: column;
    }

    .form-sidebar,
    .form-content {
      width: 100%;
      min-height: auto;
    }

    .form-sidebar {
      border-right: none;
      border-bottom: 1px solid #ddd;
    }
  }

  input.form-control {
    border: #6ec3c0 1px solid;
    width: 450px;
    max-width: 100%;
    background-color: #c9fffd;
    padding: 0.6rem 0.6rem !important;
  }

  .label-question {
    font-weight: 600;
    padding-top: 0px;
    padding-bottom: 15px;
    font-size: 1rem;
  }

  .option {
    flex: 0 0 auto !important;
    max-width: 200px !important;
    min-width: 200px !important;
    text-align: center !important;
    padding: 10px 8px !important;
    border-radius: 8px !important;
    border: 1px solid #bfdfed !important;
    background: #bfdfed !important;
    cursor: pointer !important;
    font-weight: 500 !important;
    transition: 0.2s !important;
    font-size: 14px !important;
  }



  .option.active,
  .option:hover {
    background: #08afa9 !important;
    border-color: #08afa9 !important;
    color: #ffffff !important;
  }

  .buyer-form,
  .buyer-type {
    margin-top: 40px;
  }

  .label-subtext {
    font-size: 0.85rem;
    font-weight: 600;
    color: #555;
  }

  input::placeholder {
    color: #555 !important;
    font-size: 0.9rem;
    font-weight: 200 !important;
    opacity: 50 !important;
  }

  .form-submit-btn {
    margin-top: 40px;
    background: #056a67;
    border: none;
    padding: 12px 35px;
    color: #fff;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
  }

  .form-submit-btn:hover {
    background: #04827e;
  }

  .navbar+.page-body-wrapper {
    padding-top: calc(0.5rem + 1.875rem) !important;
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border-radius: 12px;
    border: none;
  }

  .form-footer {
    padding-top: 20px;
    margin-top: auto;
    display: flex;
    justify-content: flex-start;
  }

  .text-danger-registration {
    display: block;
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 4px;
    text-align: left;
    font-weight: 500;
    margin-top: 0.5rem !important
  }

  .form-control-danger {
    border: 1px solid #ff98a8 !important;
    background-color: #ffe5e9 !important;
    color: #212529;
    box-shadow: 0 0 5px rgba(220, 53, 69, 0.2);
    transition: all 0.2s ease-in-out;
    text-align: left;
  }
</style>

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

  .navbar+.page-body-wrapper {
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
    width: 300px;
    /* 👈 set desired width for tabs */
    flex-shrink: 0;
    /* prevents shrinking on resize */
    border-right: 1px solid #056a67;
    min-height: 750px;
    /* optional for consistent height */

  }

  /* Main Content Area */
  #example-vertical-wizard .content {
    width: calc(100% - 300px);
    /* 👈 must match the steps width */
    padding: 20px;
    padding-left: 60px;
    background: #e5fffe;
    box-sizing: border-box;
    padding-bottom: 0px !important;
  }

  .wizard.vertical>.actions {
    margin-top: 0px !important;
  }

  /* Step titles inside sidebar */
  #example-vertical-wizard .steps ul li a {
    font-size: 14px;
    display: block;
    white-space: normal;
    /* allow wrapping */
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
    padding-left: 300px;
  }

  #example-vertical-wizard input.form-control {

    border: #6ec3c0 1px solid;
    width: 450px;
    max-width: 100%;
    background-color: #c9fffd;
    padding: 0.6rem 0.6rem !important;
  }

  /* Elavarasan */

  .option-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }


  .option-group input[type="radio"] {
    display: none !important;
  }

  .option-group input[type="checkbox"] {
    display: none !important;
  }

  .option-group label {
    flex: 0 0 auto;
    max-width: 220px;
    min-width: 220px;
    text-align: center;
    padding: 15px 8px;
    border-radius: 8px;
    border: 1px solid #bfdfed;
    background: #bfdfed;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s;
    font-size: 14px;

  }

  .option-group input[type="radio"]:checked+label {
    background-color: #08afa9 !important;
    color: white;
  }

  .option-group input[type="radio"]+label:hover {
    background-color: #08afa9;
    /* light teal hover color */
    color: #fff;
    /* darker text for contrast */
    cursor: pointer;
    /* shows it's clickable */
  }

  .option-group input[type="checkbox"]:checked+label {
    background-color: #08afa9;
    color: white;
  }

  .option-group input[type="checkbox"]+label:hover {
    background-color: #08afa9;
    /* light teal hover color */
    color: #fff;
    /* darker text for contrast */
    cursor: pointer;
    /* shows it's clickable */
  }

  .title-select.active {
    background-color: #08afa9 !important;
    color: #fff !important;
  }

  /* .title-select {
  width: 13%;
  float: left;
 
  color: #000!important;
  border: 1px solid #ced4da;
  border-radius: 4px;
  padding: 6px;
  appearance: auto !important;      
  -webkit-appearance: menulist;     
  -moz-appearance: menulist;        
} */
  .title-select {
    width: 13%;
    float: left;
    border: 1px solid #ccc;
    border-radius: 4px;
    /* padding: 5px 25px 5px 5px; */
    /* add extra right padding for arrow */
    color: #000 !important;
    cursor: pointer;
    appearance: auto !important;
    /* show arrow in all browsers */
    -webkit-appearance: menulist;
    /* Safari/Chrome */
    -moz-appearance: menulist;
    /* Firefox */
  }
</style>
<style>
  .dependant-inputs {
    margin-top: 5px;
    display: flex;
    flex-wrap: wrap;
    /* allow multiple items per row */
    gap: 20px;
    /* spacing between items */
  }

  .dependant-inputs .dep-item {
    background: #bfdfed;
    padding: 8px 12px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 12px;
    width: calc(20% - -65px);
    box-sizing: border-box;
  }

  .dependant-inputs .dep-item label {
    min-width: 90px;
    margin: 0;
    font-weight: 500;
  }

  .dependant-inputs .dep-item input {
    width: 80px;
    text-align: center;
    padding: 4px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .dependant-inputs .dep-item span {
    font-size: 0.95rem;
    color: #333;
  }

  .bold {

    font-weight: bold;
  }

  .wizard-card {
    max-height: 945px;
    overflow-y: auto;
    background: #e5fffe;
    scrollbar-width: thin;
    /* for Firefox */
    scrollbar-color: #08afa9 #e5fffe;
  }

  /* Optional – pretty scrollbar for Chrome/Edge */
  .wizard-card::-webkit-scrollbar {
    width: 8px;
  }

  .wizard-card::-webkit-scrollbar-thumb {
    background-color: #08afa9;
    border-radius: 4px;
  }

  /* #relationship {
  background: none !important;
}


.option-group {
  position: relative;
  display: flex;
  flex-direction: column;
} */

  /* .option-group .error {
  color: #d93025; 
  font-size: 13px;
  margin-top: 4px;
  background: none !important;
  position: relative;
  border:none;
 
} */



  #relationship-error,
  #dependant-error {
    padding: 0px !important;
    background: none !important;
    border: none;
  }

  .wizard>.content>.body label {
    font-weight: 600;
    padding-top: 0px;
    font-size: 1rem;
  }

  .wizard>.content>.body label-1 {
    font-weight: 600;
    padding-top: 10px;
    font-size: 1rem;
  }

  .mt-3,
  .template-demo>.btn-toolbar,
  .template-demo>.btn,
  .wizard>.actions .template-demo>a,
  .swal2-modal .swal2-buttonswrapper .template-demo>.swal2-styled,
  .ajax-upload-dragdrop .template-demo>.ajax-file-upload,
  .fc .template-demo>button {
    margin-top: 8px !important;
  }

  select.form-control {
    border: #6ec3c0 1px solid;
    width: 450px;
    max-width: 100%;
    background-color: #c9fffd;
    padding: 0.6rem 0.6rem;
    font-size: 0.9rem;
    font-weight: 400;
    color: #000;
    border-radius: 4px;
    appearance: auto;
    /* show default browser dropdown arrow */
    -webkit-appearance: menulist;
    -moz-appearance: menulist;
  }

  /* Focus same as input */
  select.form-control:focus {
    border-color: #056a67;
    box-shadow: 0 0 0 2px rgba(5, 106, 103, 0.25);
    background-color: #e5fffe;
  }

  /* Base option style */
  select.form-control option {
    background-color: #c9fffd;
    color: #000;
    padding: 10px;
  }

  /* When hovered inside the dropdown */
  select.form-control option:hover {
    background-color: #08afa9 !important;
    color: #fff !important;
  }

  /* When navigated (active/selected) */
  select.form-control option:checked,
  select.form-control option:focus,
  select.form-control option:active {
    background-color: #08afa9 !important;
    color: #fff !important;
  }

  .dependendent-lable {
    padding-top: 7px !important;
    font-size: 14px !important;
  }

  /* Error message text style */
  label.error {
    display: block;
    color: #d93025;
    font-size: 14px;

    background: none !important;
    border: none;
    padding: 0;
    text-align: left;
  }

  /* Highlight the error field */
  input.error,
  select.error,
  textarea.error {
    border-color: #d93025 !important;
    background-color: #ffe5e9 !important;
    box-shadow: 0 0 5px rgba(217, 48, 37, 0.2);
  }

  .wizard>.content>.body label.error {
    float: left;
    font-size: 14px;
    margin-top: 4px;
    font-weight: semibold;
  }

.phone-input-wrapper {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 450px;   /* match input width */
}

.input-prefix {
  display: inline-block;
  padding: 0.5rem 0.6rem;
  background: #c9fffd;
  border: 1px solid #6ec3c0;
  border-right: none;
  border-radius: 4px 0 0 4px;
  font-weight: 600;
  white-space: nowrap;
}

#phone_number {
  flex: 1;
  border: 1px solid #6ec3c0;
  border-radius: 0 4px 4px 0;
  background-color: #c9fffd;
  padding: 0.6rem 0.6rem !important;
}

.phone-input-wrapper + label.error {
  display: block !important;
  margin-top: 4px;
  margin-left: 0;
  width: 100%;
}
</style>

<style>
  /* Accordion container style */
  .accordion-header {
    width: 50%;
    background: #33d4cf; /* folded background color */
    border-radius: 10px;
    padding: 10px 15px;
    margin-top: 30px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .accordion-header:hover {
    background: #d3f0ee;
  }

  .accordion-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 1.3rem;
    color: #056a67;
  }

  .accordion-icon {
    margin-left: auto;
    font-size: 1.5rem;
    color: #056a67;
    font-weight: bold;
  }

  .accordion-body {
    display: none;
    width: 50%;
    padding: 15px;
    margin-top: 5px;
    border-left: 4px solid #056a67;
    border-radius: 8px;
    background: #c1ebe954; /* expanded area background */
  }

  /* When header is active */
  .accordion-header.active {
    background: #33d4cf;;
  }

</style>
<style>
/* ===== Input field wrapper (for $ symbol etc.) ===== */
.input-wrapper {
  display: flex;
  align-items: center;
  gap: 8px; /* space between $ and input */
}

.currency-symbol {
  font-weight: 600;
  color: #056a67;
}

/* ===== Address Form Section ===== */
.address-form {
  background: #f8f9fa;
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 10px;
  margin-top: 15px;
  width: 50%;
  position: relative;
}

.address-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.close-address {
  background: none;
  border: none;
  font-size: 22px;
  font-weight: bold;
  color: #999;
  cursor: pointer;
}

.close-address:hover {
  color: #333;
}

/* ===== Add Address Button ===== */
.add-address-button {
  display: inline-block;
  margin-top: 10px;
  color: #056a67;
  font-weight: 600;
  cursor: pointer;
  padding: 6px 12px;
  border: 1px solid #056a67;
  border-radius: 6px;
  transition: all 0.2s ease-in-out;
}

.add-address-button:hover {
  background-color: #056a67;
  color: #fff;
}


/* ===== Address Form Section ===== */
.property-form {
  background: #f8f9fa;
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 10px;
  margin-top: 15px;
  width: 90%;
  position: relative;
}

.property-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.close-property {
  background: none;
  border: none;
  font-size: 22px;
  font-weight: bold;
  color: #999;
  cursor: pointer;
}

.close-property:hover {
  color: #333;
}

/* ===== Add Address Button ===== */
.add-property-button {
  display: inline-block;
  margin-top: 10px;
  color: #056a67;
  font-weight: 600;
  cursor: pointer;
  padding: 6px 12px;
  border: 1px solid #056a67;
  border-radius: 6px;
  transition: all 0.2s ease-in-out;
}

.add-property-button:hover {
  background-color: #056a67;
  color: #fff;
}


.toggle-switch .toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f3e7e7;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 34px;
    border: 1px solid #d1c8c8;
}

.toggle-contents{
  font-weight: 500; 
  font-size: 1rem; 
  color: #056a67; 
  display: flex; 
  align-items: center; 
  padding: 20px 0;
  gap: 188px;    
  border-bottom: 1px solid #d6eaf3; 
  margin-bottom: 20px;
}
.special-text{
color: #056a67;
}

.wizard > .steps .done a {
    background-color: #33d4cf !important;
    color: #434a54 !important;
    cursor: pointer !important;
}
</style>
<style>
.add-address-button {
  display: inline-block;
  color: #29afab;
  border: 2px solid #29afab;
  padding: 8px 16px;
  border-radius: 25px;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  transition: 0.3s ease;
}

.add-address-button:hover {
  background-color: #29afab;
  color: white;
}
</style>

<body class="page-application">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->

    <?php View::render("admin/_topnavbar", ["title" => "Welcome Admin"]); ?>

    <div class="container-fluid page-body-wrapper">


      <div class="main-panel" style="width:100%;">
        <div class="content-wrapper">

          <!--vertical wizard-->
          <div class="row" style="padding-top:50px;">
            <div class="col-12 grid-margin">
              <div class="card wizard-card" style="height:945px; background:#e5fffe;overflow-y:auto;">
                <div class="card-body" style="background:#e5fffe;">
                  <h4 class="card-title"></h4>
                  <form id="example-vertical-wizard" action="#">
                    <div>
                      <!-- Step 1: Persona l Details -->
                      <h3>Personal Details</h3>
                      <section id="personal-details"
                        class="body current"
                        style="background:#e5fffe; padding:0;"
                        role="tabpanel"
                        aria-labelledby="personal-details-heading"
                        aria-hidden="false">

                        <input type="hidden" name="loan_id" id="loan_id" value="" />

                        <!-- Section Title -->
                        <div style="font-weight:600; font-size:1.5rem; color:#056a67;margin-bottom:30px; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR; ?>/images/family.webp"
                            alt="Family Icon"
                            width="50" height="50">
                          <span id="personal-details-heading">Personal Details</span>
                        </div>

                        <!-- Row 1 -->
                        <div class="row mt-3">
                          <div class="form-group col-md-6">
                            <label class="bold" for="preferred_name">Preferred Name (optional) </label>
                            <input id="preferred_name" name="preferred_name" type="text" maxlength="40" placeholder="Preferred Name" class="form-control">
                          </div>

                        </div>
                        <div class="row mt-3">

                          <div class="col-md-6">
                            <div class="row">
                              <div class="form-group col-md-10">
                                <label class="bold" for="phone_number">Phone Number</label>
                                <div class="phone-input-wrapper">
                                  <span class="input-prefix">+61</span>
                                  <input id="phone_number" name="phone_number" type="text" maxlength="11" placeholder="Phone Number" class="form-control required">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php $marginright = "18px"; ?>
                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Title</label>
                            <div class="option-group">
                              <input class="option" type="radio" id="Mr" name="title1" value="Mr" checked required>
                              <label class="option" for="Mr">Mr</label>
                              <input class="option" type="radio" id="Mrs" name="title1" value="Mrs">
                              <label class="option" for="Mrs">Mrs</label>
                              <input class="option" type="radio" id="Miss" name="title1" value="Miss">
                              <label class="option" for="Miss">Miss</label>

                              <select id="title2" name="title2" class="option form-control title-select">
                                <option value="">Select Title</option>
                                <option value="Ms">Ms.</option>
                                <option value="Dr">Dr.</option>
                                <option value="Rev">Rev.</option>
                                <option value="Prof">Prof.</option>
                                <option value="Other">Other</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Gender</label>
                            <div class="option-group">
                              <input class="option" type="radio" id="Male" name="gender" value="Male" checked required>
                              <label for="Male" class="option">Male</label>
                              <input class="option" type="radio" id="Female" name="gender" value="Female">
                              <label for="Female" class="option">Female</label>
                              <input class="option" type="radio" id="Other" name="gender" value="Other">
                              <label for="Other" class="option">Other</label>

                            </div>

                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Relationship status</label>
                            <div class="option-group">
                              <select id="relationship" name="relationship" class="form-control required title-select">
                                <option value="single">single</option>
                                <option value="married">Married</option>
                                <option value="de_facto">De Facto</option>
                                <option value="other">Other</option>
                              </select>
                            </div>

                          </div>
                        </div>


                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Dependants
                              <span class="label-subtext">(A dependant is a child under the age of 18 or anyone else who is financially dependant on you, regardless of their age.)</span>
                            </label>
                            <div class="option-group">
                              <select id="dependant" name="dependant" class="form-control required title-select">
                                <option value="0">None</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                              </select>
                            </div>
                            <br />
                            <!-- Dynamic dependant inputs -->
                            <div id="dependantFields" class="dependant-inputs"></div>
                          </div>
                        </div>
                      </section>

                      <!-- Step 2: Your Details -->
                      <h3>Residential address</h3>
                      <section id="residential-details">
                        <div style="font-weight:600; font-size:1.5rem; color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="http://localhost:8081/assets/images/house-on-hand.png"
                            alt="Family Icon"
                            width="32" height="32">
                          <span id="personal-details-heading">Residential address</span>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-6">
                            <label for="current_residential_address">Current residential address <span class="text-danger">*</span></label>
                            <input id="current_residential_address" name="current_residential_address" type="text" maxlength="40" class="form-control required">
                          </div>

                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Living arrangements

                            </label>
                            <div class="option-group" >
                              <select id="living_arrangements" name="living_arrangements"  class="form-control required title-select">
                                <option value="I own my home with a mortgage">I own my home with a mortgage</option>
                                <option value="I own my home outright">I own my home outright</option>
                                <option value="I am renting">I am renting</option>
                                <option value="I live with family or relatives">I live with family or relatives</option>
                                <option value="Other">Other</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="form-group col-md-6">
                            <label for="move_in_date">Move in date <span class="text-danger">*</span></label>
                            <input id="move_in_date" name="move_in_date" type="month" maxlength="40" class="form-control required">
                          </div>

                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Postal address is the same?</label>
                            <div class="option-group">
                              <input class="option" type="radio" id="Yes" name="postal_address_same" value="Yes" checked required>
                              <label class="option" for="Yes" style="float:left;margin-right: <?php echo $marginright; ?>;">Yes</label>
                              <input class="option" type="radio" id="No" name="postal_address_same" value="No">
                              <label class="option" for="No" style="float:left;margin-right: <?php echo $marginright; ?>;">No</label>
                            </div>

                          </div>
                        </div>
                        
                        <div class="row mt-3 hide" id="postalAddressRow"> 
                          <div class="form-group col-md-6">
                            <label for="postal_address">Postal address <span class="text-danger">*</span></label>
                            <input id="postal_address" name="postal_address" type="text" maxlength="40" class="form-control required">
                          </div>
                        </div>
                        



                        <!-- Where new addresses will appear -->
                        <div id="address-container"></div>
                        <div>
                          <span class="add-address-button" style="cursor:pointer;">+ Add address</span>
                        </div>
                        <!-- Template (stay hidden and NEVER removed) -->
                        <div class="address-form template" style="display:none;">
                          <div class="form-fields">
                            <div class="address-header">
                              <h4>Previous residential address</h4>
                              <button type="button" class="close-address">×</button>
                            </div>

                            <div class="row mt-3">
                              <div class="form-group col-md-9">
                                <label>Previous address <span class="text-danger">*</span></label>
                                <input type="text" name="previous_address[]" maxlength="40" class="form-control required">
                              </div>
                            </div>

                            <div class="row mt-3">
                              <div class="form-group col-md-9">
                                <label>Period lived there</label>
                                <div class="d-flex align-items-center gap-2">
                                  <div class="col-md-5 p-0">
                                    <label style="font-weight: normal;"> <span class="label-subtext">From date (Month/Year)</span></label>
                                    <input type="month" name="period_lived_from_date[]" class="form-control required">
                                  </div>
                                  <div class="" style="margin-top:30px;"><b>-</b></div>
                                  <div class="col-md-5 p-0">
                                    <label style="font-weight: normal;"> <span class="label-subtext">To date (Month/Year)</span></label>
                                    <input type="month" name="period_lived_to_date[]" class="form-control required">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>

                      <!-- Step 3: Your Finances -->
                      <h3>ID details</h3>
                      <section id="id_details">

                        <div style="font-weight:600; font-size:1.5rem; color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="http://localhost:8081/assets/images/id-card.png"
                            alt="Family Icon"
                            width="32" height="32">
                          <span id="personal-details-heading">ID details</span>
                        </div>

                        <div class="toggle-contents">
                           <label style="margin: 0;">Australian Driver Licence</label>
                          <div style="display: flex; align-items: center; gap: 10px; font-size:15px;">
                           <span id="personal-details-heading">I don’t have this</span>
                            <label class="toggle-switch">
                              <input class="dont_have_licence" type="checkbox" name="dont_have_licence" id="dont_have_licence" />
                              <span class="toggle-slider round"></span>
                            </label>
                          </div>
                        </div>

                        
                        <div class="row mt-3">
                          <div class="col-md-12">
                            <label class="bold special-text" for="">Name exactly as displayed on ID </label>
                            <div class="row">
                              <div class="form-group col-md-12">
                                <!-- <label class="bold" for="first_name">First Name <span class="text-danger">*</span></label> -->
                                <input id="first_name" name="first_name" type="text" maxlength="40" class="form-control required" placeholder="First Name">
                              </div>
                              <div class="form-group col-md-12">
                                <!-- <label class="bold" for="middle_name">Middle Name </label> -->
                                <input id="middle_name" name="middle_name" type="text" maxlength="40" class="form-control" placeholder="Middle Name">
                              </div>

                              <div class="form-group col-md-12">
                                <!-- <label class="bold" for="last_name">Last Name <span class="text-danger">*</span></label> -->
                                <input id="last_name" name="last_name" type="text" maxlength="40" class="form-control required" placeholder="Last Name">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="having_driving_licence">
                          <div class="row mt-3">
                            <div class="form-group col-md-12">
                              <label class="bold">State issued in <span class="text-danger">*</span></label>
                              <div class="option-group" style=" display: flex !important; gap: 0px; flex-direction: column;margin-bottom: 5px;">
                                <select id="state_issued_in" name="state_issued_in"  
                                class="form-control required title-select">
                                  <option value="Australian Capital Territory">Australian Capital Territory</option>
                                  <option value="New South Wales">New South Wales</option>
                                  <option value="I am renting">Northern Territory</option>
                                  <option value="Queensland">Queensland</option>
                                  <option value="South Australia">South Australia</option>
                                  <option value="Tasmania">Tasmania</option>
                                  <option value="Victoria">Victoria</option>
                                  <option value="Western Australia">Western Australia</option>
                                </select>
                              </div>


                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="form-group col-md-12">
                                  <label class="bold" for="driving_licence">Driver licence number <span class="text-danger">*</span></label>
                                  <input id="driving_licence" name="driving_licence" type="text" maxlength="10" class="form-control required">
                                </div>
                                <div class="form-group col-md-12">
                                  <label class="bold" for="card_number">Card number <span class="text-danger">*</span></label>
                                  <input id="card_number" name="card_number" type="text" maxlength="10" class="form-control required">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3 " id="">
                            <div class="form-group col-md-6">
                              <label for="expiry_date">Expiry date <span class="text-danger">*</span></label>
                              <input id="expiry_date" name="expiry_date" type="date" maxlength="10" class="form-control required">
                            </div>
                          </div>
                        </div>
                       <!--  <div class="Not_having_driving_licence">
                          <div class="row mt-3">
                            <div class="col-md-12">
                               <label class="bold special-text" for="">Legal Name</label>
                              <div class="row">
                                <div class="form-group col-md-12">
                                  <input id="first_name" name="first_name" type="text" maxlength="40" class="form-control required" placeholder="First Name" >
                                </div>
                                <div class="form-group col-md-12">
                                  <input id="middle_name" name="middle_name" type="text" maxlength="40" class="form-control" placeholder="Middle Name" >
                                </div>

                                <div class="form-group col-md-12">
                                  <input id="last_name" name="last_name" type="text" maxlength="40" class="form-control required" placeholder="Last Name">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Legal name has ever changed? </label>
                            <div class="option-group">
                              <input class="option" type="radio" id="legal_Yes" name="legal_name_changed" value="legal_Yes" >
                              <label class="option" for="legal_Yes" style="float:left;margin-right: <?php echo $marginright; ?>;">Yes</label>
                              <input class="option" type="radio" id="legal_No" name="legal_name_changed" value="legal_No" checked>
                              <label class="option" for="legal_No" style="float:left;margin-right: <?php echo $marginright; ?>;">No</label>
                            </div>

                          </div>
                        </div>
                        <div class="row mt-3 hide" id="legal_previous_name">
                          <div class="col-md-12">
                            <label class="bold special-text" for="first_name">Enter a previous name </label>
                            <div class="row">
                              <div class="form-group col-md-12">
                               <!--  <label class="bold" for="previous_first_name"> <span class="text-danger">*</span></label> -->
                                <input id="previous_first_name" name="previous_first_name" type="text" maxlength="40" class="form-control required" placeholder="First Name" />
                              </div>
                              <div class="form-group col-md-12">
                                <!-- <label class="bold" for="previous_middle_name">Middle Name </label> -->
                                <input id="previous_middle_name" name="previous_middle_name" type="text" maxlength="40" class="form-control" placeholder="Middle Name">
                              </div>

                              <div class="form-group col-md-12">
                                <!-- <label class="bold" for="previous_last_name">Last Name<span class="text-danger">*</span> </label> -->
                                <input id="previous_last_name" name="previous_last_name" type="text" maxlength="40" class="form-control required" placeholder="Last Name">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Residency status </label>
                            <div class="option-group">
                              <input class="option" type="radio" id="australian_citizen" name="residency_status" value="australian_citizen" checked>
                              <label class="option" for="australian_citizen" style="float:left;margin-right: <?php echo $marginright; ?>;">Australian citizen</label>
                              <input class="option" type="radio" id="permanent_resident" name="residency_status" value="permanent_resident">
                              <label class="option" for="permanent_resident" style="float:left;margin-right: <?php echo $marginright; ?>;">Permanent Resident</label>
                              <input class="option" type="radio" id="temporary_resident" name="residency_status" value="temporary_resident">
                              <label class="option" for="temporary_resident" style="float:left;margin-right: <?php echo $marginright; ?>;">Temporary resident</label>
                            </div>

                          </div>
                        </div>
                        <div class="row mt-3 " id="">
                          <div class="form-group col-md-6">
                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                            <input id="date_of_birth" name="date_of_birth" type="date" maxlength="40" class="form-control required">
                          </div>
                        </div>
                       </section>

                      <h3>Assets</h3>
                      <section id="assets_details">

                        <div style="font-weight:600; font-size:1.5rem; color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="http://localhost:8081/assets/images/car.webp"
                            alt=""
                            width="32" height="32">
                          <span id="personal-details-heading">Assets</span>
                        </div>



                        <!-- Accordion Header 1 -->
                        <div class="accordion-header" data-target=".assets_accordian">
                          <div class="accordion-title">
                            <img src="http://localhost:8081/assets/images/moneybag.png" alt="Car Icon" width="32" height="32">
                            <span>Savings, shares & superannuation</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="assets_accordian accordion-body">
                          <!-- <h2></h2> -->

                          <div class="row mt-3">

                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                
                                <input  type="text" id="total_savings" name="total_savings" oninput="allowonlynumbers(this)" maxlength="15" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                  <!-- <span class="input-group-text">.00</span> -->
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <!-- <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"> -->
                                <input id="total_shares" name="total_shares" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" />
                                <div class="input-group-append">
                                  <!-- <span class="input-group-text">.00</span> -->
                                </div>
                              </div>
                            </div>

                            <!-- <div class="form-group col-md-6 dollar-field">
                              <label for="total_shares">Total shares</label>
                              <div class="input-wrapper">
                              <span class="currency-symbol">$</span><input id="total_shares" name="total_shares" type="number" maxlength="12" class="form-control">
                            </div>
                            </div> -->
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <!-- <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"> -->
                                <input id="superannuation" name="superannuation" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control required" />
                                <div class="input-group-append">
                                  <!-- <span class="input-group-text">.00</span> -->
                                </div>
                              </div>
                            </div>

                           <!--  <div class="form-group col-md-6 dollar-field">
                              <label for="superannuation">Total superannuation <span class="text-danger">*</span></label>
                              <div class="input-wrapper">
                              <span class="currency-symbol">$</span><input id="superannuation" name="superannuation" type="number" maxlength="12" class="form-control required">
                            </div>
                            </div> -->
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label for="primary_superannuation">Primary superannuation institution</label>
                              <input id="primary_superannuation" name="primary_superannuation" type="text" maxlength="40" class="form-control required">
                            </div>
                          </div>
                        </div>

                        <!-- Accordion Header 2 -->
                        <div class="accordion-header" data-target=".properties_accordian">
                          <div class="accordion-title">
                            <img src="http://localhost:8081/assets/images/house.png" alt="House Icon" width="32" height="32">
                            <span>Properties</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 2 -->
                        <div class="properties_accordian accordion-body">
                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label>Address of a property you own</label>
                              <input type="text" value="123 A'Beckett Street Narromine NSW 2821" readonly class="form-control">
                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label>Estimated property value</label>
                              <input type="text" value="$430,000" readonly class="form-control" />
                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label>Intended property usage <span class="text-danger">*</span></label>
                              <input type="text" value="Owner occupied" readonly maxlength="40" class="form-control required" />
                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label> What is your share of ownership?  <span class="text-danger">*</span></label>
                              <div class="input-group">
                                  <input id="share_ownership" name="share_ownership" oninput="updateShareOwnership(this)"  value="100" type="text" maxlength="5" class="form-control required" >
                                  <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: #29afab;color:#fff; ">%</span>
                                  </div>
                                 
                              </div>
                               <span class="whitespace-nowrap non-applicant-owns" style="font-size:13px;"></span>
                            </div>
                          </div>

                          <div id="property-container"></div>
                          <div>
                            <span class="add-property-button" style="cursor:pointer;">+ Add property</span>
                          </div>
                          <!-- Template (stay hidden and NEVER removed) -->
                          <div class="property-form template" style="display:none;">
                            <div class="form-fields">
                              <div class="property-header">
                                <h4>New Property</h4>
                                <button type="button" class="close-property">×</button>
                              </div>

                              <div class="row mt-3">
                                <div class="form-group col-md-9">
                                  <label>Address of a property you own  <span class="text-danger">*</span></label>
                                  <input type="text" name="property_address[]" maxlength="40" class="form-control required">
                                </div>
                              </div>
                              <div class="row mt-3">
                                <div class="form-group col-md-7">
                                  <label>Estimated property value   <span class="text-danger">*</span></label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text bg-primary text-white">$</span>
                                    </div>
                                    <input id="estimated_property_value" name="estimated_property_value" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control required" />
                                    <div class="input-group-append">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row mt-3">
                                <div class="form-group col-md-12">
                                  <label class="bold">Current property usage  </label>
                                  <div class="option-group">
                                    <input class="option" type="radio" id="owner_occupied"  name="owner_occupied[]" value="owner_occupied" checked>
                                    <label class="option" for="owner_occupied" style="float:left;margin-right: <?php echo $marginright; ?>;">Owner occupied</label>
                                    <input class="option" type="radio" id="investment"  name="owner_occupied[]" value="investment" >
                                    <label class="option" for="investment" style="float:left;margin-right: <?php echo $marginright; ?>;">Investment</label>
                                  </div>
                                </div>
                              </div>

                              <div class="row mt-3">
                                <div class="form-group col-md-12">
                                  <label class="bold">Rental status <br/>
                                  <span class="label-subtext">Long term rentals are more than 6 months</span> </label>
                                  <div class="option-group">
                                    <input class="option" type="radio" id="long_term" name="long_term[]" value="long_term" checked>
                                    <label class="option" for="long_term" style="float:left;margin-right: <?php echo $marginright; ?>;">Long term</label>

                                    <input class="option" type="radio" id="short_term"  name="long_term[]" value="short_term" >
                                    <label class="option" for="short_term" style="float:left;margin-right: <?php echo $marginright; ?>;">Short term</label> 
                                    
                                    <input class="option" type="radio" id="untenanted"  name="long_term[]" value="untenanted" >
                                    <label class="option" for="untenanted" style="float:left;margin-right: <?php echo $marginright; ?>;">Untenanted</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row mt-3">
                                <div class="form-group col-md-6">
                                  <label> What is your share of ownership?  <span class="text-danger">*</span></label>
                                  <div class="input-group">
                                      <input id="share_of_ownership" name="share_of_ownership[]" oninput="allowonlynumbers(this)"  value="100" type="text" maxlength="5" class="form-control required" >
                                      <div class="input-group-append">
                                        <span class="input-group-text" style="background-color: #29afab;color:#fff; ">%</span>
                                      </div>
                                    
                                  </div>
                                  <!-- <span class="whitespace-nowrap non-applicant-owns" style="font-size:13px;"></span> -->
                                </div>
                              </div>

                            </div>

                              
                          </div>
                        </div>


                        
                      </section>
                      
                      <!-- Step 4: Your Loan -->
                      <h3>Your Finances</h3>
                      <section id="your-loan">
                        <div style="font-weight:600; font-size:1.5rem; color:#056a67;">Your Finances</div>
                        <div class="form-check mt-3">
                          <input class="form-check-input" type="checkbox" id="terms2">
                          <label class="form-check-label" for="terms2">
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

  <!-- Elavarsan ---------------------------- -->

  <script>

    function allowonlynumbers(input) {
      // Allow only numbers and one dot
      input.value = input.value
        .replace(/[^0-9.]/g, '')   // Remove everything except digits and dot
        .replace(/(\..*)\./g, '$1'); // Prevent multiple dots
    }
    function updateShareOwnership(input) {
      // Allow only numbers and one dot
      input.value = input.value
        .replace(/[^0-9.]/g, '')   // Only digits and dot
        .replace(/(\..*)\./g, '$1'); // Only one dot

      let value = parseFloat(input.value);
      let $span = document.querySelector('.non-applicant-owns');

      if (!isNaN(value) && value <= 100) {
        let remaining = (100 - value).toFixed(2).replace(/\.00$/, ''); // Remove .00 if not needed
        if(remaining!=0){
          $span.textContent = `Non-applicant owns ${remaining}%`;
        }else{
          $span.textContent = '';
        }
        
      } else if (value > 100) {
        input.value = 100;
        $span.textContent = '';
        //$span.textContent = `Non-applicant owns 0%`;
      } else {
        $span.textContent = '';
      }
    }


    const radios = document.querySelectorAll('input[name="title1"]');
    const select = document.querySelector('#title2');
    //const relationship = document.querySelector('#relationship');

    radios.forEach(radio => {
      radio.addEventListener('change', () => {
        // Unhighlight select when any radio is chosen
        select.classList.remove('active');
      });
    });

    select.addEventListener('change', () => {
      if (select.value !== "") {
        // Uncheck all radios when dropdown is used
        radios.forEach(r => (r.checked = false));
        select.classList.add('active');
      } else {
        select.classList.remove('active');
      }
    });

    /*
    relationship.addEventListener('change', () => {
      relationship.classList.add('active');
    });
    */
  </script>

  <script>
    const dependantSelect = document.getElementById("dependant");
    const dependantFields = document.getElementById("dependantFields");

    dependantSelect.addEventListener("change", () => {
      const count = parseInt(dependantSelect.value) || 0;
      dependantFields.innerHTML = ""; // clear previous

      for (let i = 1; i <= count; i++) {
        const div = document.createElement("div");
        div.className = "dep-item";
        div.innerHTML = `
        <label class="dependendent-lable">Dependant ${i} </label>
        <input type="number" name="dependant_age_${i}" min="0" max="120" placeholder="Age" />
        <span>years old</span>
      `;
        dependantFields.appendChild(div);
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#phone_number').on('input', function() {
        let val = $(this).val().replace(/\D/g, ''); // Keep digits only

        // Limit to 9 digits total
        if (val.length > 9) val = val.slice(0, 9);

        // Auto insert spaces: 222 222 222
        val = val.replace(/(\d{3})(\d{0,3})(\d{0,3})/, function(_, g1, g2, g3) {
          return [g1, g2, g3].filter(Boolean).join(' ');
        });

        $(this).val(val);
      });

      $('#phone_number').on('blur', function() {
        const phone = $(this).val().trim();
        const phoneError = $('#phone_error');

        // Validate format: exactly 3 digits + space + 3 digits + space + 3 digits
        const phonePattern = /^\d{3}\s\d{3}\s\d{3}$/;

        if (phone === '') {
          phoneError.text('Phone number is required.');
        } else if (!phonePattern.test(phone)) {
          phoneError.text('Enter a valid phone number in format: 222 222 222.');
        } else {
          phoneError.text('');
        }
      });

      $('input[name="postal_address_same"]').on('change', function() {

        console.log('yahhh');
        if ($(this).val() === 'No') {
          $('#postalAddressRow').removeClass('hide');
        } else {
          $('#postalAddressRow').addClass('hide');
          $('#postal_address').val(''); // clear value if hidden
        }
      });

      $('input[name="legal_name_changed"]').on('change', function() {

        console.log('yahhh___');
        console.log($(this).val());
        if ($(this).val() === 'legal_Yes') {
          $('#legal_previous_name').removeClass('hide');
        } else {
          $('#legal_previous_name').addClass('hide');
          $('#legal_first_name').val(''); // clear value if hidden
          $('#legal_middle_name').val(''); // clear value if hidden
          $('#legal_last_name').val(''); // clear value if hidden
        }
      });


    });
  </script>
<script>
  $(document).ready(function () {
    $(".accordion-header").click(function () {
      const target = $(this).data("target");
      const body = $(target);

      // Close other accordions
      $(".accordion-body").not(body).slideUp();
      $(".accordion-header").not(this).removeClass("active").find(".accordion-icon").text("+");

      // Toggle current accordion
      $(this).toggleClass("active");
      body.slideToggle();
      const icon = $(this).find(".accordion-icon");
      icon.text(icon.text() === "+" ? "−" : "+");
    });
  });

/* $(document).ready(function () {
  $(".add-address-button").click(function () {
    $(".address-form").slideDown(); // show with animation
  });

  $(".close-address").click(function () {
    $(".address-form").slideUp(); // hide with animation
  });
}); */




</script>

<script>
$(document).ready(function() {

  // Add new address
  $('.add-address-button').on('click', function() {
    // Always clone from the original template (not from appended copies)
    let $template = $('.address-form.template').first().clone();

    // Clean up and show
    $template.removeClass('template').show();
    $template.find('input').val(''); // clear previous values if any

    // Append to container
    $('#address-container').append($template);
  });

  // Close (remove) only the clicked address
  $(document).on('click', '.close-address', function() {
    $(this).closest('.address-form').remove();
  }); 
  
  /* $('.add-property-button').on('click', function() {
    // Always clone from the original template (not from appended copies)
    let $template = $('.property-form.template').first().clone();

    // Clean up and show
    $template.removeClass('template').show();
    $template.find('input').val(''); // clear previous values if any

    // Append to container
    $('#property-container').append($template);
  });

  // Close (remove) only the clicked address
  $(document).on('click', '.close-property', function() {
    $(this).closest('.property-form').remove();
  }); */


  /*  let propertyIndex = 0;

  $(".add-property-button").on("click", function () {
    propertyIndex++;

    const newForm = $(".property-form.template").clone().removeClass("template").show();

    // Update radio button group names to be unique
    newForm.find('input[type="radio"]').each(function () {
      const oldName = $(this).attr("name");
      const newName = oldName.replace("[]", "") + "_" + propertyIndex;
      $(this).attr("name", newName);
    });

    // Append to container
    $("#property-container").append(newForm);

    // Handle close button
    newForm.find(".close-property").on("click", function () {
      newForm.remove();
    });
  }); */

  let propertyIndex = 0;

  $(".add-property-button").on("click", function () {
    propertyIndex++;

    // Clone template
    const $newForm = $(".property-form.template")
      .clone()
      .removeClass("template")
      .show();

    // Update header title
    $newForm.find(".property-header h4").text("Property #" + propertyIndex);

    // Generate a unique suffix for IDs and radio names
    const uniqueSuffix = "_prop" + propertyIndex;

    // Fix all IDs and "for" labels
    $newForm.find("[id]").each(function () {
      const oldId = $(this).attr("id");
      const newId = oldId + uniqueSuffix;
      $(this).attr("id", newId);
    });

    $newForm.find("label[for]").each(function () {
      const oldFor = $(this).attr("for");
      const newFor = oldFor + uniqueSuffix;
      $(this).attr("for", newFor);
    });

    // Fix radio names (make them independent)
    $newForm.find('input[type="radio"]').each(function () {
      let oldName = $(this).attr("name");
      let newName = oldName.replace("[]", "") + uniqueSuffix;
      $(this).attr("name", newName);
    });

    // Reset all text/number inputs
    $newForm.find("input[type='text'], input[type='month']").val("");

    // Append to container
    $("#property-container").append($newForm);

    // Close button handler
    $newForm.find(".close-property").on("click", function () {
      $newForm.fadeOut(200, function () {
        $(this).remove();
      });
    });
  });

});


</script>

<script>
$(document).ready(function() {

  // Hide Not_having_driving_licence by default
  $('.Not_having_driving_licence').hide();

  // When checkbox is clicked
  $('#dont_have_licence').on('change', function() {
    if ($(this).is(':checked')) {
      // Checkbox checked → hide licence fields, show non-licence fields
      $('.having_driving_licence').hide();
      $('.Not_having_driving_licence').show();
    } else {
      // Checkbox unchecked → show licence fields, hide non-licence fields
      $('.having_driving_licence').show();
      $('.Not_having_driving_licence').hide();
    }
  });

});
</script>

</body>

</html>