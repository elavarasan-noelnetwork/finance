<?php
/* ======================================
  Filename: Header
  Author: Elavarasan 
  Description: Header File
  Updated By: Ameen on 17-07-2025
  =======================================
*/
?>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Zeon Developments</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <?php //echo ASSETS_DIR;die;
  ?>

  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/vertical-layout-light/style.css?v=124">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/sidebar.css?v=123">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/navbar.css?v=123">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/settings.css?v=123">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/landing-screen.css?v=123">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/plugins-overrides.css?v=123">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR; ?>/css/responsive.css?v=123"> -->




  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo ASSETS_DIR; ?>/images/favicons/zion_favicon.png" />
</head>
<style>
  .add-user-btn {
    background-color: #056a67;    
    border: none;
    color: #fff;
    padding: 12px 18px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
  }

  .add-user-btn:hover {
    background-color: #056a67; 
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-1px);
  }

  .add-user-btn i {
    font-size: 14px;
  }

  /* filter */

  .filter-form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    max-width: 100%;
  }

  .filter-form h2 {
    margin-bottom: 15px;
    color: #333;
  }

  .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 15px;
  }

  .form-row input {
    /* flex: 1 1 200px; */
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    width: 20%;
  }

  .form-row select {
    /* flex: 1 1 200px; */

    width: 20%;
  }

  .filter-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    /* 👈 Align buttons to right */
  }

  .filter-buttons button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
  }

  .filter-buttons .btn-submit {
    background-color: #33d4cf;
    color: #fff;
  }

  .filter-buttons .btn-reset {
    background-color: #6c757d;
    color: #fff;
  }

  @media (max-width: 600px) {
    .form-row {
      flex-direction: column;
    }
  }

  .highlighted {
    border: 2px solid rgb(28, 206, 206);
    /* Green border */
    background-color: #bbf3f1;
    /* Light green background */
    color: #155724;
    /* Dark green text */

  }

  /*added for radio button starts*/
  input[type="radio"] {
    display: inline-block !important;
    opacity: 1 !important;
    accent-color: #33d4cf !important;
  }

  input[type="radio"].form-check-input:checked {
    background-color: #33d4cf !important;
    border-color: #33d4cf !important;
  }

  .form-check-input {
    background-color: transparent !important;
  }

  /* Apply styles to all radio buttons */
  input[type="radio"].form-check-input {
    appearance: none;
    /* Remove browser default */
    width: 15px;
    height: 15px;
    border: 2px solid #33d4cf;
    border-radius: 50%;
    cursor: pointer;
    background-color: white;
    outline: none;
    /* Remove default focus ring */
    box-shadow: none !important;
    /* Prevent any gray shadow */
  }



  /* Optional: Add hover/focus effect */
  input[type="radio"].form-check-input:hover {
    box-shadow: 0 0 0 3px rgba(51, 212, 207, 0.3);
  }

  .smallHead{
    font-size: 1.225rem;
    font-weight: normal;
    color: #e1d8d8;
  }

  .custTableHeader{
    background-color:#33d4cf !important;
    font-size:0.875rem !important;
    border-bottom-width:0 !important;
  }

   #pageAcessTable th, #pageAcessTable td {
    vertical-align: middle;
    text-align: left;
  }

  #pageAcessTable {
  width: 100%;
  table-layout: fixed;
}
#pageAcessTable th, #pageAcessTable td {
  word-wrap: break-word;
  white-space: normal;
}

.nav-tabs .nav-link.active {
  background-color: #33d4cf !important;
  color: #000000 !important;
  border-color: #33d4cf #33d4cf #fff !important;
}

.nav-tabs .nav-link {
  color: #333;
  border-color:  #33d4cf;
}

/* Optional: hover effect */
.nav-tabs .nav-link:hover {
  border-color: #33d4cf;
}

#pageAcessTable {
  margin-top: 0 !important;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
input[type="number"]:focus,
textarea:focus,
select:focus {
    border-color: #33d4cf !important; /* Your desired border color */
    box-shadow: 0 0 4px #33d4cf !important;
    outline: none !important;         /* Removes browser default outline */
}


.wizard > .steps .done a {
    background-color: #bfdfed !important;
    color: #434a54 !important;              
    cursor: pointer !important; 
}

.wizard > .steps .disabled a {
    background-color: #bfdfed !important;
    color: #434a54 !important;              
    cursor: pointer !important; 
}

.wizard > .steps .current a {
    background-color: #33d4cf !important;
    color: #434a54 !important;              
    cursor: pointer !important; 
}


.wizard > .steps .error a{
    background-color: #EB8C95 !important;
    color: #434a54 !important;              
    cursor: pointer !important;   
}

.wizard > .steps li.error a,
.wizard > .steps li.error a span {
  color: #434a54   !important;    
}

#add-category-btn{
  padding-left: 1% !important;
  padding-right: 1% !important;
}

  /*added for radio button ends*/

.progress-circle {
  --percent: 0; /* default */
  --radius: 54;
  --circumference: calc(2 * 3.1416 * var(--radius));
  --offset: calc(var(--circumference) - (var(--percent) / 100 * var(--circumference)));

  position: relative;
  width: 55px;
  height: 55px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.progress-ring {
  transform: rotate(-90deg);
  width: 100%;
  height: 100%;
}

.progress-ring__bg {
  fill: none;
  stroke: #b5a8a8ff;
  stroke-width: 4;
}

.progress-ring__progress {
  fill: none;
  stroke: #369936;
  stroke-width: 6;
  stroke-linecap: round;
  stroke-dasharray: var(--circumference);
  stroke-dashoffset: var(--offset);
}

.progress-text {
  position: absolute;
  font-size: 1rem;
  font-weight: bold;
  color: #369936;
  display: flex;
  align-items: center; /* keeps % aligned nicely */
}

.progress-text .small-percent {
  font-size: 0.8rem;   /* smaller size */
  margin-left: 2px;    /* little spacing */
  font-weight: bold; /* lighter look */
}

.progress-circle-lg {
  --percent: 0; /* default */
  --radius: 54; /* can adjust to make stroke fit */
  --circumference: calc(2 * 3.1416 * var(--radius));
  --offset: calc(var(--circumference) - (var(--percent) / 100 * var(--circumference)));

  position: relative;
  width: 100px;   /* bigger size */
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.progress-circle-lg .progress-ring {
  transform: rotate(-90deg);
  width: 100%;
  height: 100%;
}

.progress-circle-lg .progress-ring__bg {
  fill: none;
  stroke: #b5a8a8ff;
  stroke-width: 6; /* a bit thicker */
}

.progress-circle-lg .progress-ring__progress {
  fill: none;
  stroke: #369936;
  stroke-width: 8;
  stroke-linecap: round;
  stroke-dasharray: var(--circumference);
  stroke-dashoffset: var(--offset);
}

.progress-circle-lg .progress-text {
  position: absolute;
  font-size: 1.5rem;   /* bigger font */
  font-weight: bold;
  color: #369936;
  display: flex;
  align-items: center;
}

.progress-circle-lg .progress-text .small-percent {
  font-size: 1rem;     /* relative smaller % */
  margin-left: 4px;
  font-weight: bold;
}

.info-box {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 200px; /* force height so icons show */
    position: relative;
    transition: all 0.25s ease-in-out;
    cursor: pointer;
}

.scrollable-text {
    flex: 1;
    overflow-y: auto;
    max-height: 140px;
    padding-right: 5px;
    z-index: 2;
        scrollbar-color: #a3a3a3 #f1f1f1; /* thumb color | track color */
}

.scrollable-text::-webkit-scrollbar {
    width: 6px;
}
.scrollable-text::-webkit-scrollbar-thumb {
    background: #4e73df;
    border-radius: 4px;
}

.hover-card:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.08);
    border-color: transparent;
}


/* =========================
   Address Box
========================= */
.address-box {
    background: #f8fff8;              /* light green tint */
    border: 1px solid #c8e6c9;        /* greenish border */
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.address-box:hover {
    background: #eaffea;              /* slightly darker green on hover */
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.address-box i,
.address-title,
.address-text {
    color: #28a745;                   /* Bootstrap green */
    z-index: 2;
}


/* =========================
   Background Watermark Icon
========================= */
.bg-icon {
    position: absolute;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 4rem;
    opacity: 0.15;
    color: rgba(0,0,0,0.15);
    z-index: 0;
    pointer-events: none;
}

/* =========================
   Total Cost Box
========================= */
.total-cost-box {
    background-color: #f0f8ff;
    border: 1px solid #cce5ff;
    position: relative;
    overflow: hidden;
}


/* =========================
   Amount Paid Box
========================= */
.amount-paid-box {
    background-color: #f0fff4;
    border: 1px solid #c8e6c9;
    position: relative;
    overflow: hidden;
}
.amount-paid-box::after {
    font-family: "bootstrap-icons";
    font-size: 120px;
    color: rgba(40, 167, 69, 0.08);   /* faded green */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
}
/* =========================
   User Info Box
========================= */
.user-info-box {
    background-color: #fffaf0;
    border: 1px solid #f7e1c7;
}

.user-info-box::after {
    font-family: "bootstrap-icons";
    font-size: 120px;
    color: rgba(255, 193, 7, 0.08);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    z-index: 0;
}


.deadline-box1 {
    
    background: #fff8f8;
    border: 1px solid #f3caca;
    cursor: pointer;


    line-height: 2;      /* tighter text spacing */

    min-height: 80px;      /* fixes consistent compact height */
    display: flex;         /* flex to center items */
    flex-direction: column;
    justify-content: center;
}

.deadline-box1:hover {
    background: #ffeaea;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.deadline-box1 i,
.deadline-title1,
.deadline-text1 {
    color: #d9534f;
    z-index: 2;
}

.notes-location-box {
    min-height: 305px; /* adjust value */
}

.info-box-jservice {
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    transition: all 0.25s ease-in-out;
    cursor: pointer;
}

.navbar-brand-wrapper {
    height: 50px;            /* reduce overall height */
    display: flex;
    align-items: center;     /* vertical center */
    justify-content: center; /* horizontal center if needed */
    padding: 0;              /* remove extra spacing */    
}

.navbar-brand img {
    max-height: 35px;        /* shrink logo image */
    height: auto;
    width: auto;
}

.profile-pic {
    border-radius: 50% !important;
    object-fit: cover;
    width: 40px !important;
    height: 40px !important;
}

#income-chart {
  height: 580px !important;  
  width: 100% !important;   /* full width */
  display: block;           /* prevents inline sizing issues */  
}

/* Remove blue border/outline on dropdown trigger */
#profileDropdown:focus,
#profileDropdown:active {
  outline: none !important;
  box-shadow: none !important;
}

.text-custom {
  color: #33d4cf !important; /* your custom color */
}

/* Apply only to profile dropdown */
.profile-dropdown .dropdown-item {
  transition: background-color 0.2s ease, color 0.2s ease;
}

.profile-dropdown .dropdown-item:hover {
  background-color: #f3f4f6; /* light gray */
  color: #111827;           /* dark text */
}

.profile-dropdown .dropdown-item i {
  min-width: 20px;
  text-align: center;
}

.nav-profile .dropdown-menu {
  left: 0 !important;
  right: auto !important;
  margin-top: 0.5rem; /* little gap below */
}

#profileDropdown + .dropdown-menu.profile-dropdown {
  transform: translateX(-25px) !important;
}

.dataTable td{
  white-space: normal !important;   /* allow wrapping */
  word-wrap: break-word;            /* legacy support */
  word-break: break-word;           /* modern support */
  max-width: 200px;
}
</style>