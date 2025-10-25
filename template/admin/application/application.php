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
    color: #000 !important;
    cursor: pointer;
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
    width: 52%;
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
    width: 52%;
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
  width: 100%;
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

.input-group {
  flex-wrap: nowrap;
}

.property-form .input-group {
  flex-wrap: nowrap;
}

.property-form .input-group .error {
  width: 100%;
  margin-top: 1px;
  font-size: 13px;
  color: #dc3545;
}

.input-group-prepend{
  height:43px;
}

select {
  padding-right: 25px; 
}

select {
  appearance: none !important; /* Remove default arrow */
  -webkit-appearance: none;
  -moz-appearance: none;

  background-color: #fff; /* Optional */
  background-image: url('data:image/svg+xml;utf8,<svg fill="black" height="10" width="10" xmlns="http://www.w3.org/2000/svg"><polygon points="0,0 10,0 5,7"/></svg>') !important;
  background-repeat: no-repeat;
  background-position: right 10px center; /* Control arrow spacing */
  padding-right: 35px; /* Adds actual space inside */
  border: 1px solid #ccc;
  border-radius: 4px;
  height: 36px;
}

select.form-control, select.typeahead, select.tt-query, select.tt-hint, .select2-container--default .select2-selection--single select.select2-search__field, .select2-container--default select.select2-selection--single, .jsgrid .jsgrid-table .jsgrid-filter-row select, .dataTables_wrapper select, select.asColorPicker-input {
    background-size: 10px !important;
}

.assets_accordian,
.everyday_expenses {
  display: block;
}

hr {
    margin: 0 0 1rem 0;
}

.form-check .form-check-label input {
    opacity: 1;
}

.form-check-input:checked {
    background-color: #33d4cf !important;
    border-color: #129592 !important;
}
.form-check-input {
    border-color: #129592 !important;
    font-size:12px;
    font-size: 20px;
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
                      
                      <!-- Step 1: Persona Details -->
                      <h3>Personal Details</h3>
                      <section id="personal-details"
                        class="body current"
                        style="background:#e5fffe; padding:0;"
                        role="tabpanel"
                        aria-labelledby="personal-details-heading"
                        aria-hidden="false">

                        <input type="hidden" name="loan_id" id="loan_id" value="" />

                        <!-- Section Title -->
                        <div style="font-weight:600; font-size:1.5rem; color:#056a67;margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR; ?>/images/family.webp"
                            alt="Family Icon"
                            width="50" height="50">
                          <span id="personal-details-heading">Personal Details</span>
                        </div>

                        <hr class="hr-break" />



                        <!-- Row 1 -->
                        <div class="row mt-3">
                          <div class="form-group col-md-6">
                            <label class="bold" for="preferred_name">Preferred Name (optional) </label>
                            <input id="preferred_name" name="preferred_name" type="text" maxlength="40" placeholder="Preferred Name" class="form-control">
                          </div>

                        </div>

                          <div class="row mt-3">
                            <label>Phone Number</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">+61</span>
                                </div>
                                <div>
                                  <input id="phone_number" name="phone_number" type="text" maxlength="11" placeholder="Phone Number" style="width:404px;" class="form-control required">
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

                      <!-- Step 2: Residential Details -->
                      <h3>Residential address</h3>
                      <section id="residential-details">
                        <div style="font-weight:600; font-size:1.5rem; color:#056a67; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR;?>/images/house-on-hand.png"
                            alt="Family Icon"
                            width="32" height="32">
                          <span id="personal-details-heading">Residential address</span>
                        </div>
                        <hr class="hr-break" />

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

                      <!-- Step 3: ID Details -->
                      <h3>ID details</h3>
                      <section id="id_details">

                        <div style="font-weight:600; font-size:1.5rem;margin-bottom:20px;  color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR;?>/images/id-card.png"
                            alt="Family Icon"
                            width="32" height="32">
                          <span id="personal-details-heading">ID details</span>
                        </div>

                        
                        <hr class="hr-break" />

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
                            <label class="bold special-text" for="">Name exactly as displayed on ID <span class="text-danger">*</span></label>
                            <div class="row">
                              <div class="form-group col-md-12">
                                <input id="first_name" name="first_name" type="text" maxlength="40" class="form-control required" placeholder="First Name">
                              </div>
                              <div class="form-group col-md-12">
                                <input id="middle_name" name="middle_name" type="text" maxlength="40" class="form-control" placeholder="Middle Name">
                              </div>

                              <div class="form-group col-md-12">
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
                                  <input id="driving_licence" name="driving_licence" type="text" maxlength="20" class="form-control required">
                                </div>
                                <div class="form-group col-md-12">
                                  <label class="bold" for="card_number">Card number <span class="text-danger">*</span></label>
                                  <input id="card_number" name="card_number" type="text" maxlength="15" class="form-control required">
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
                            <label class="bold special-text" for="first_name">Enter a previous name <span class="text-danger">*</span> </label>
                            <div class="row">
                              <div class="form-group col-md-12">
                                <input id="previous_first_name" name="previous_first_name" type="text" maxlength="40" class="form-control required" placeholder="First Name" />
                              </div>
                              <div class="form-group col-md-12">
                                <input id="previous_middle_name" name="previous_middle_name" type="text" maxlength="40" class="form-control" placeholder="Middle Name">
                              </div>

                              <div class="form-group col-md-12">
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
                      
                      <!-- Step 4: Assets Details -->
                      <h3>Assets</h3>
                      <section id="assets_details">
                          
                        <div style="font-weight:600; font-size:1.5rem;margin-bottom:20px; color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR;?>/images/car.webp"
                            alt=""
                            width="32" height="32">
                          <span id="personal-details-heading">Assets</span>
                        </div>

                        <hr class="hr-break" />

                        <!-- Accordion Header 1 -->
                        <div class="accordion-header active" data-target=".assets_accordian">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/moneybag.png" alt="Car Icon" width="32" height="32">
                            <span>Savings, Shares & Superannuation</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="assets_accordian accordion-body">

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label for="total_savings">Total savings  </label>
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
                              <label for="total_shares">Total shares   </label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <input id="total_shares" name="total_shares" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" />
                                <div class="input-group-append">
                                  <!-- <span class="input-group-text">.00</span> -->
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label for="superannuation">Total superannuation <span class="text-danger">*</span></label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <input id="superannuation" name="superannuation" type="text" oninput="allowonlynumbers(this)" maxlength="15" value="1"  class="form-control required" />
                                <div class="input-group-append">
                                  <!-- <span class="input-group-text">.00</span> -->
                                </div>
                              </div>
                            </div>
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
                            <img src="<?php echo ASSETS_DIR;?>/images/house.png" alt="House Icon" width="32" height="32">
                            <span>Properties</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 2 -->
                        <div class="properties_accordian accordion-body">
                          <div class="row mt-3">
                            <div class="form-group col-md-6">
                              <label>Address of a Property You Own</label>
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

                          <!-- <div id="property-container"></div>
                          <div>
                            <span class="add-property-button" style="cursor:pointer;">+ Add property</span>
                          </div>
                          <div class="property-form template" style="display:none;">
                            <div class="form-fields">
                              <div class="property-header">
                                <h4>New Property</h4>
                                <button type="button" class="close-property">×</button>
                              </div>

                              <div class="row mt-3">
                                <div class="form-group col-md-7">
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
                                    <div>
                                      <input id="estimated_property_value" name="estimated_property_value" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control required" style="width: 364px;" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row mt-3 owner_occupied_option">
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

                              <div class="row mt-3 owner_occupied_div">
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
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" style="background-color: #29afab;color:#fff; ">%</span>
                                    </div>
                                    <div>
                                      <input id="share_of_ownership" name="share_of_ownership[]" oninput="allowonlynumbers(this)"  value="100" type="text" maxlength="5" class="form-control required" style="width: 364px;" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div> -->
                        </div>

                        <!-- Accordion Header 3 -->

                        <div class="accordion-header" data-target=".home_contents">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/gem.webp" alt="House Icon" width="32" height="32">
                            <span>Home Contents & Other Assets</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 3 -->
                        <div class="home_contents accordion-body">

                          <div class="row mt-3">
                            <label>Home contents   <span class="label-subtext">(Include things like furniture, jewellery, art, and other personal belongings)</span></label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="home_contents_value" name="home_contents_value" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control required" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row mt-3">
                             <label>Other assets  <span class="label-subtext">( Include things like machinery, equipment or any other investments )</span></label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="other_assets_value" name="other_assets_value" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control required" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </section>

                      <!-- Step 5: Income Details -->
                      <h3>Income</h3>
                      <section id="income_details">
                        <div style="font-weight:600; font-size:1.5rem; margin-bottom:20px; color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR;?>/images/coin.webp"
                            alt="Family Icon"
                            width="32" height="32">
                          <span id="personal-details-heading">Income Details</span>
                          
                        </div>

                        <hr class="hr-break" />
                        <!--   <div style="font-weight:400; font-size:0.8rem; color:#056a67; display:flex; align-items:left; gap:8px;">
                          <span id="personal-details-heading">Income</span>
                          <span> $<span id="total_income">0</span>/year</span>
                        </div> -->

                        <div class="row mt-3">
                          <label for="current_residential_address">Overall income type <span class="text-danger">*</span><span class="label-subtext">( Salary, Residential, Divident, etc.. )</span></label>
                          <div class="form-group col-md-6">

                            <input id="income_type" name="income_type" type="text" maxlength="15"  class="form-control required" style="width: 417px;" />
                            
                            <!-- <select id="living_arrangements" name="living_arrangements"  class="form-control required title-select">
                                <option value="SALARY_WAGES-value">Salary or wage (PAYG)</option>
                                <option value="SELF_EMPLOYED-value">Self Employed</option>
                                <option value="RESIDENTIAL_PROPERTY_RENTAL-value">Residential Property Rental Income</option>
                                <option value="DIVIDEND-value">Dividend Income</option>
                                <option value="OTHER_INVESTMENT-value">Other Investment Income</option>
                                <option value="AGED_CARE_PENSION-value">Aged Care Pension</option>
                                <option value="VETERANS_AFFAIRS_PENSION-value">Vetereans Affairs Pension</option>
                                <option value="EX_SERVICEPERSON_PENSION-value">Ex Serviceperson Pension</option>
                                <option value="TOTALLY_PERMANENTLY_INCAPACITATED_PENSION-value">Totally & Permanently Incapacitated Pension</option>
                                <option value="DISABILITY_PENSION-value">Disability Pension</option>
                                <option value="CARERS-value">Carers Payment</option>
                                <option value="FAMILY_TAX_BENEFIT_A-value">Family Tax Benefit A</option>
                                <option value="FAMILY_TAX_BENEFIT_B-value">Family Tax Benefit B</option>
                                <option value="PARTNERED_PARENTING-value">Partnered Parenting Payment</option>
                                <option value="GOVERNMENT_MAINTENANCE-value">Government Maintenance Income</option>
                                <option value="NEWSTART_ALLOWANCE-value">Newstart Allowance</option>
                                <option value="COMMUNITY_DEVELOPMENT-value">Community Development Employment Program</option>
                                <option value="AUSTUDY-value">Austudy</option>
                                <option value="BABY_BONUS-value">Baby Bonus</option>
                                <option value="RENT_ALLOWANCE-value">Rent Allowance</option>
                                <option value="SINGLE_PARENTS-value">Single Parent Payments</option>
                                <option value="FOSTER_CARES-value">Foster Care Payments</option>
                                <option value="GOVERNMENT_STIMULUS-value">Government Stimulus Payments</option>
                                <option value="OTHER_GOVERNMENT_BENEFITS-value">Other Government Benefits</option>
                                <option value="WORKCOVERS-value">Workcover Payments</option>
                                <option value="INCOME_PROTECTIONS-value">Income Protection Payments</option>
                                <option value="CHILD_AND_SPOUSAL_MAINTENANCE-value">Child and Spousal Maintenance</option>
                                <option value="SUPERANNUATION-value">Superannuation Income</option>
                                <option value="OTHER-value">Other income</option>
                              </select> -->
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-7">
                            <label> Overall Income Amount (Per year) <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">$</span>
                              </div>
                              <div>
                                <input id="income_amount" name="income_amount" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control required" style="width: 417px;" />
                              </div>
                            </div>
                          </div>
                        </div>
                      
                      </section>

                       <!-- Step 6: Employment Details -->
                      <h3>Employment</h3>
                      <section id="employment_details">
                        <div style="font-weight:600; font-size:1.5rem; margin-bottom:20px;  color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR;?>/images/case.png"
                            alt="Family Icon"
                            width="32" height="32">
                          <span id="personal-details-heading">Employment History</span>
                          
                        </div>

                        <hr class="hr-break" />

                        <div class="row mt-3">
                          <label for="employment_type">Employment type  <span class="text-danger">*</span></label>
                          <div class="form-group col-md-6">
                            <select id="employment_type" name="employment_type"  class="form-control required title-select">
                              <option value="employee">Employee</option>
                              <option value="self_employed">Self Employed</option>
                              <option value="household_duties">Household duties</option>
                              <option value="retired">Retired</option>
                              <option value="unemployed">Unemployed</option>
                              <option value="student">Student</option>
                            </select>
                          </div>
                        </div>

                       <div class="row mt-3">
                          <div class="form-group col-md-9">
                            <label>Period lived there</label>
                            <div class="d-flex align-items-center gap-2">
                              <div class="col-md-5 p-0">
                                <label style="font-weight: normal;"> <span class="label-subtext">Date started  </span></label>
                                <input type="date" id="employment_date_started" name="employment_date_started" class="form-control required">
                              </div>
                              <div class="" style="margin-top:30px;"><b>-</b></div>
                              <div class="col-md-5 p-0">
                                <label style="font-weight: normal;"> <span class="label-subtext">Date ended </span></label>
                                <input type="date" id="employment_date_ended" name="employment_date_ended" class="form-control required">
                              </div>
                            </div>
                          </div>
                        </div>

                      </section>

                      <!-- Step 7: Expenses Details -->
                      <h3>Expenses</h3>
                      <section id="expenses_details">
                          
                        <div style="font-weight:600; font-size:1.5rem;margin-bottom:20px;  color:#056a67; display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR;?>/images/expenses.webp"
                            alt=""
                            width="32" height="32">
                          <span id="personal-details-heading">Expenses</span>
                        </div>

                        <hr class="hr-break" />

                        <!-- Accordion Header 1 -->
                        <div class="accordion-header active" data-target=".everyday_expenses">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/everyday_expenses.png" alt="Car Icon" width="32" height="32">
                            <span>Everyday Expenses</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="everyday_expenses accordion-body">

                          <div class="row mt-3">
                            <label>Groceries</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="groceries" name="groceries" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div> 
                          
                          <div class="row mt-3">
                            <label>Clothing and personal care</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="clothing" name="clothing" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <label>Telephone, internet, pay TV & media streaming subscriptions</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="telephone" name="telephone" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row mt-3">
                            <label>Transport</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="transport" name="transport" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <label>Recreation and entertainment</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="recreation_entertainment" name="recreation_entertainment" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <label>Pet care</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="pet_care" name="pet_care" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Accordion Header 1 -->
                        <div class="accordion-header" data-target=".primary_residence">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/primary_residences.png" alt="Car Icon" width="32" height="32">
                            <span>Primary Residence</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="primary_residence accordion-body">

                          <div class="row mt-3">
                            <label>Running costs</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="running_costs" name="running_costs" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div> 
                          
                          <div class="row mt-3">
                            <label>Land Tax</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="land_tax" name="land_tax" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <label>Rent and board</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="rent_board" name="rent_board" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> 
                        
                        
                        <!-- Accordion Header 1 -->
                        <div class="accordion-header" data-target=".insurance_medical">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/insurance_medical.png" alt="Car Icon" width="32" height="32">
                            <span>Insurance and Medical</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="insurance_medical accordion-body">

                          <div class="row mt-3">
                            <label>Healthcare (services and items)</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="healthcare" name="healthcare" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div> 
                          
                          <div class="row mt-3">
                            <label>General basic insurances</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="general_insurances" name="general_insurances" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <label>Health insurance</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="health_insurance" name="health_insurance" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                           <div class="row mt-3">
                            <label>Life, sickness and personal accident insurance</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="life_accident_insurance" name="life_accident_insurance" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                          
                        </div> 
                        
                        
                        <!-- Accordion Header 1 -->
                        <div class="accordion-header" data-target=".dependants_education">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/education.png" alt="Car Icon" width="32" height="32">
                            <span>Dependants and Education</span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="dependants_education accordion-body">

                          <div class="row mt-3">
                            <label>Childcare expenses</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="childcare_expenses" name="childcare_expenses" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div> 
                          
                          <div class="row mt-3">
                            <label>Public or government primary and secondary education</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="primary_secondary_education" name="primary_secondary_education" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row mt-3">
                            <label>Higher education and professional memberships (e.g. University/TAFE)</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="higher_education" name="higher_education" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                           <div class="row mt-3">
                            <label>Private schooling and tuition</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="private_schooling" name="private_schooling" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row mt-3">
                            <label>Child and spousal support payments</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="child_spousal_payments" name="child_spousal_payments" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                        
                        <!-- Accordion Header 1 -->
                        <div class="accordion-header" data-target=".investment_holiday">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/investment_and_holiday.png" alt="Car Icon" width="32" height="32">
                            <span>Investment and Holiday Home </span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="investment_holiday accordion-body">

                          <div class="row mt-3">
                            <label>Total investment property running costs</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="total_investment_property" name="total_investment_property" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div> 
                          
                          <div class="row mt-3">
                            <label>Total holiday home running costs</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="total_holiday_costs" name="total_holiday_costs" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                        
                        <!-- Accordion Header 1 -->
                        <div class="accordion-header" data-target=".other_expenses">
                          <div class="accordion-title">
                            <img src="<?php echo ASSETS_DIR;?>/images/other_expenses.png" alt="Car Icon" width="32" height="32">
                            <span>Other Expenses </span>
                            <span class="accordion-icon">+</span>
                          </div>
                        </div>

                        <!-- Accordion Body 1 -->
                        <div class="other_expenses accordion-body">

                          <div class="row mt-3">
                            <label>Other expenses</label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-primary text-white">$</span>
                                </div>
                                <div>
                                  <input id="other_expenses" name="other_expenses" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
      
                      </section>

                      
                     <!-- Step 1: Persona Details -->
                      <h3>Loan preferences</h3>
                      <section id="loan_preferences"
                        class="body current"
                        style="background:#e5fffe; padding:0;"
                        role="tabpanel"
                        aria-labelledby="personal-details-heading"
                        aria-hidden="false">

                        <input type="hidden" name="loan_id" id="loan_id" value="" />

                        <!-- Section Title -->
                        <div style="font-weight:600; font-size:1.5rem; color:#056a67;margin-bottom:20px;  display:flex; align-items:center; gap:8px;">
                          <img src="<?php echo ASSETS_DIR; ?>/images/loan_preparances.webp"
                            alt="Family Icon"
                            width="50" height="50">
                          <span id="personal-details-heading">Loan preferences</span>
                        </div>
                       
                        <hr class="hr-break" />

                        <?php $marginright = "18px"; ?>

                        


                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold"><label>Why are you refinancing? <span class="label-subtext"> You can select multiple</span> </label></label>
                            
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="get_better_rate_check" name="get_better_rate_check" value="get_better_rate_check" >
                                Get a better rate
                              </label>
                            </div>

                            <div class="form-check">
                              <label class="form-check-label">
                                 <input class="form-check-input" type="checkbox" id="access_equity_check" name="access_equity_check" value="access_equity_check">
                                Access equity / get cash out
                              </label>
                            </div>

                            <div class="form-check">
                              <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" id="consolidate_debt_check" name="consolidate_debt_check" value="consolidate_debt_check">
                                Consolidate debt
                              </label>
                            </div>
                            
                            <div class="form-check">
                              <label class="form-check-label">
                                   <input class="form-check-input" type="checkbox" id="more_flexibility_check" name="more_flexibility_check" value="more_flexibility_check">
                                More flexibility / convenience
                              </label>
                            </div>

                          </div>
                        </div>

                        <div class="row mt-3">
                          <label>Desired loan amount</label>
                          <div class="form-group col-md-6">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">$</span>
                              </div>
                              <div>
                                <input id="desired_loan_amount" name="desired_loan_amount" type="text" oninput="allowonlynumbers(this)" maxlength="15"  class="form-control" style="width: 364px;" />
                              </div>
                            </div>
                          </div>
                        </div> 

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                             <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="unsure" name="unsure" value="unsure">
                                Unsure
                              </label>
                            </div>

                           <!--  <div class="option-group">
                              <input class="option" type="checkbox" id="unsure" name="unsure" value="unsure" required>
                              <label class="option" for="unsure">Unsure</label>
                            </div> -->
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">What rate type are you interested in? 
                            <span class="label-subtext"> By selecting both you can apportion a part of your loan to each rate type</span> </label>
                            <div class="option-group">
                              <input class="option" type="radio" id="variable_radio" name="rate_type" value="variable_radio"  required>
                              <label class="option" for="variable_radio">Variable</label>

                              <input class="option" type="radio" id="fixed_radio" name="rate_type" value="fixed_radio">
                              <label class="option" for="fixed_radio">Fixed</label>

                              <input class="option" type="radio" id="both_radio" name="rate_type" value="both_radio">
                              <label class="option" for="both_radio">Both</label>
                              
                              <input class="option" type="radio" id="unsure_radio" name="rate_type" value="unsure_radio">
                              <label class="option" for="unsure_radio">Unsure</label>

                            </div>
                          </div>
                        </div>

                         <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Repayment type 
                           
                            <div class="option-group">
                              <input class="option" type="radio" id="Principal_interest_radio" name="repayment_type" value="Principal_interest_radio"  required>
                              <label class="option" for="Principal_interest_radio">Principal & interest</label>

                              <input class="option" type="radio" id="interest_only_radio" name="repayment_type" value="interest_only_radio">
                              <label class="option" for="interest_only_radio">Interest only</label>

                              <input class="option" type="radio" id="repayment_both_radio" name="repayment_type" value="repayment_both_radio">
                              <label class="option" for="repayment_both_radio">Both</label>
                              
                              <input class="option" type="radio" id="unsure_repayment_radio" name="repayment_type" value="unsure_repayment_radio">
                              <label class="option" for="unsure_repayment_radio">Unsure</label>

                            </div>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Loan term</label>
                            <div class="option-group">
                              <select id="loan_term_select" name="loan_term_select" class="form-control required title-select">
                                <option value="unsure">Unsure</option>

                                <?php for($i=20; $i<=30;$i++){   ?>
                                     <option value="<?php echo $i;?>_years"><?php echo $i;?> Years</option>
                                <?php } ?>
                               
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold">Repayment frequency</label>
                            <div class="option-group">
                              <select id="repayment_frequency_select" name="repayment_frequency_select" class="form-control required title-select">
                                <option value="unsure">Unsure</option>
                                <option value="monthly">Monthly</option>
                                <option value="fortnightly">Fortnightly</option>
                                <option value="weekly">Weekly</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <label class="bold"><label>Loan features <span class="label-subtext"> (You can select multiple or leave blank if you have no preference)</span> </label></label>
                            
                            <div class="form-check">
                              <label class="form-check-label">

                               <input class="form-check-input" type="checkbox" id="additional_repayments_check" name="additional_repayments_check" value="additional_repayments_check" >
                               Additional repayments
                              </label>
                            </div>

                            <div class="form-check">
                              <label class="form-check-label">
                               <input class="form-check-input" type="checkbox" id="offset_account_check" name="offset_account_check" value="offset_account_check">   
                                Offset account
                              </label>
                            </div>

                            <div class="form-check">
                              <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" id="redraw_facility_check" name="redraw_facility_check" value="redraw_facility_check">
                               Redraw facility
                              </label>
                            </div>
                            
                            <div class="form-check">
                              <label class="form-check-label">
                                   <input class="form-check-input" type="checkbox" id="transaction_account_check" name="transaction_account_check" value="transaction_account_check">
                               Transaction account
                              </label>
                            </div>

                          </div>
                        </div>

                         <div class="row mt-3">
                            <label>Other loan requirements   <span class="label-subtext">(Tell your broker about any other loan requirements not covered by the above, or leave blank)</span></label>
                            <div class="form-group col-md-6">
                              <div class="input-group">
                               <textarea id="other_loan_requirements"
                                  name="other_loan_requirements"
                                  rows="4"
                                  maxlength="1500"
                                  placeholder="Describe any other loan requirements (e.g., loan purpose, special conditions)..."
                                  class="form-control"
                                  aria-label="Other loan requirements"></textarea>
                                
                              </div>
                            </div>
                          </div>


                        

                      </section>
                      
                      <!-- Step 9: Documents -->
                      <h3>Documents</h3>
                      <section id="documents_details">
                        <div style="font-weight:600; font-size:1.5rem; margin-bottom:20px;  color:#056a67;">Documents</div>
                         <div class="row mt-3">
                          <div class="form-group col-md-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="confirm" name="confirm" value="confirm">
                                All the details provided are correct only.
                              </label>
                            </div>
                          </div>
                        </div>

                      
                        <hr class="hr-break" />
                      </section>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
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

        //console.log('yahhh');
        if ($(this).val() === 'No') {
          $('#postalAddressRow').removeClass('hide');
        } else {
          $('#postalAddressRow').addClass('hide');
          $('#postal_address').val(''); // clear value if hidden
        }
      });

      $('input[name="legal_name_changed"]').on('change', function() {

        //console.log('yahhh___');
        //console.log($(this).val());
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

</script>

<script>
$(document).ready(function() {

  /* ===================== Address Add Button ============================ */
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

  /* ===================== Poperty Add Button ============================ */

  /* let propertyIndex = 0;

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
  }); */

  let propertyIndex = 0;

  function reindexProperties() {
    $("#property-container .property-form").each(function (index) {
      $(this).find(".property-header h4").text("Property #" + (index + 1));
    });
  }

  function bindPropertyEvents($form) {
    // Hide owner_occupied_div by default
    $form.find(".owner_occupied_div").hide();

    // Toggle rental section based on selection
    $form.find('input[name^="owner_occupied"]').on("change", function () {
      const selected = $(this).val();
      if (selected === "investment") {
        $form.find(".owner_occupied_div").slideDown();
      } else {
        $form.find(".owner_occupied_div").slideUp();
      }
    });

    // Close button
    $form.find(".close-property").on("click", function () {
      $form.fadeOut(200, function () {
        $(this).remove();
        reindexProperties(); // Reorder titles after removal
      });
    });
  }

  $(".add-property-button").on("click", function () {
    propertyIndex++;

    // Clone template
    const $newForm = $(".property-form.template")
      .clone()
      .removeClass("template")
      .show();

    // Update header title
    $newForm.find(".property-header h4").text("Property #" + propertyIndex);

    // Generate unique suffix
    const uniqueSuffix = "_prop" + propertyIndex;

    // Update IDs and labels
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

    // Fix radio names (make independent)
    $newForm.find('input[type="radio"]').each(function () {
      let oldName = $(this).attr("name");
      let newName = oldName.replace("[]", "") + uniqueSuffix;
      $(this).attr("name", newName);
    });

    // Reset text fields
    $newForm.find("input[type='text'], input[type='month']").val("");

    // Append to container
    $("#property-container").append($newForm);

    // Bind dynamic events
    bindPropertyEvents($newForm);

    reindexProperties();
  });

  /* ======= Not_having_driving_licence show hide option ============= */

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