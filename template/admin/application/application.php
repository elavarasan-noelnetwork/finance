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
        min-height: 750px;
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
        width: 500px;
        max-width: 100%;
        background-color: #c9fffd;
    }

    .label-question {
        font-weight: 600;
        padding-top: 0px;
        padding-bottom: 15px;
        font-size: 1rem;
    }

    .option-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .option {
        flex: 0 0 auto;
        max-width: 200px;
        min-width: 200px;
        text-align: center;
        padding: 10px 8px;
        border-radius: 8px;
        border: 1px solid #bfdfed;
        background: #bfdfed;
        cursor: pointer;
        font-weight: 500;
        transition: 0.2s;
        font-size: 14px;
    }

    .option.active,
    .option:hover {
        background: #08afa9;
        border-color: #08afa9;
        color: #ffffff;
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
  width: 97%;           /* or max-width: 100%; */
}

/* Elavarasan */

 .option-group {
    display: block;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
      margin-bottom: 30px;
    }


    .option-group input[type="radio"] {
      display: none!important;
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
    .option-group input[type="radio"]:checked + label {
      background-color: #08afa9;
      color: white;
    }
    .option-group input[type="radio"] + label:hover {
      background-color: #08afa9; /* light teal hover color */
      color: #fff;           /* darker text for contrast */
      cursor: pointer;          /* shows it's clickable */
    }

	 .option-group input[type="checkbox"]:checked + label {
      background-color: #08afa9;
      color: white;
    }

    .option-group input[type="checkbox"] + label:hover {
      background-color: #08afa9; /* light teal hover color */
      color: #fff;           /* darker text for contrast */
      cursor: pointer;          /* shows it's clickable */
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
  /* padding: 5px 25px 5px 5px; */ /* add extra right padding for arrow */
  color: #000!important;
  cursor: pointer;
  appearance: auto !important;      /* show arrow in all browsers */
  -webkit-appearance: menulist;     /* Safari/Chrome */
  -moz-appearance: menulist;        /* Firefox */
}


</style>
<style>
  .dependant-inputs {
    margin-top: 5px;
    display: flex;
    flex-wrap: wrap; /* allow multiple items per row */
    gap: 20px;       /* spacing between items */
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

  .bold{

    font-weight: bold;
  }

.wizard-card {
  max-height: 945px;
  overflow-y: auto;
  background: #e5fffe;
  scrollbar-width: thin;           /* for Firefox */
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

#relationship {
  padding-right: 30px; /* adjust spacing as needed */
  background: none !important;
  border: 1px solid #056a67;
  appearance: none; /* removes default arrow for consistent styling */
  -webkit-appearance: none;
  -moz-appearance: none;
  background-image: url("data:image/svg+xml;utf8,<svg fill='black' height='12' viewBox='0 0 24 24' width='12' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 10px center; /* arrow position */
  background-size: 12px;
}

#relationship-error, #dependant-error{padding:0px!important;background: none !important;border:none;}

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
              <div style="font-weight:600; font-size:1.5rem; color:#056a67; display:flex; align-items:center; gap:8px;">
                <img src="http://localhost:8081/assets/images/family.webp"
                    alt="Family Icon"
                    width="32" height="32">
                <span id="personal-details-heading">Personal Details</span>
              </div>

              <!-- Row 1 -->
              <div class="row mt-3">
                <div class="form-group col-md-6">
                   <label  class="bold" for="preferred_name">Preferred Name</label>
                  <input id="preferred_name" name="preferred_name" type="text"   maxlength="40" class="form-control required">
                </div>
                
              </div>
              <div class="row mt-3">
               
                <div class="col-md-6">
                  <div class="row">
                    <div class="form-group col-md-2">
                     <label  class="bold" for="country_code">Country Code</label>
                      <input id="country_code" name="country_code" type="text" value="+61"  readonly class="form-control required">
                    </div>
                    <div class="form-group col-md-10">
                     <label  class="bold" for="phone_number">Phone Number</label>
                      <input id="phone_number" name="phone_number" type="text" maxlength="11"  placeholder="Phone Number" class="form-control required">
                    </div>
                  </div>
                </div>
              </div>
              <?php $marginright="18px";?>
              <div class="row mt-3">
                <div class="form-group col-md-12">
                  <label class="bold">Title</label>
                  <div class="option-group">
                    <input class="option" type="radio" id="Mr." name="title1" value="Mr" checked required>
                    <label for="Mr." style="float:left;margin-right: <?php echo $marginright;?>;" >Mr.</label>
                    <input class="option" type="radio" id="Mrs" name="title1" value="Mrs">
                    <label for="Mrs" style="float:left;margin-right: <?php echo $marginright;?>;" >Mrs</label>
                    <input class="option" type="radio" id="Miss" name="title1" value="Miss">
                    <label style="float:left;margin-right: <?php echo $marginright;?>;" for="Miss">Miss</label>
                    
                     <select id="title2" name="title2" style=" background: #c9fffd;     border: #056a67 1px solid;" class="form-control title-select">

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
                    <label for="Male" style="float:left;margin-right: <?php echo $marginright;?>;" >Male</label>
                    <input class="option" type="radio" id="Female" name="gender" value="Female">
                    <label for="Female" style="float:left;margin-right: <?php echo $marginright;?>;" >Female</label>
                    <input class="option" type="radio" id="Other" name="gender" value="Other">
                    <label for="Other" style="float:left;margin-right: <?php echo $marginright;?>;" >Other</label>
                  
                  </div>
             
                </div>
              </div> 
              
               <div class="row mt-3">
                <div class="form-group col-md-12">
                  <label class="bold">Relationship status</label>
                  <div class="option-group" style=" display: flex !important; gap: 0px; flex-direction: column;">
                    <select id="relationship" name="relationship" style=" background: #c9fffd;    border: #056a67 1px solid;" class="form-control required title-select">
                      <option value="">Select an option</option>
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
                    <small>(A dependant is a child under the age of 18 or anyone else who is financially dependant on you, regardless of their age.)</small>
                  </label>
                  <div class="option-group" style=" display: flex !important; gap: 0px; flex-direction: column;margin-bottom: 5px;" >
                    <select id="dependant" name="dependant" style="background: #c9fffd;    border: #056a67 1px solid;" class="form-control required title-select">
                      <option value="">None</option>
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
                  <br/>
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
                  <input id="current_residential_address" name="current_residential_address" type="text"  maxlength="40" class="form-control required">
                </div>
                
              </div> 
              
              

              <div class="row mt-3">
                <div class="form-group col-md-12">
                  <label class="bold">Living arrangements 
                   
                  </label>
                  <div class="option-group" style=" display: flex !important; gap: 0px; flex-direction: column;margin-bottom: 5px;" >
                    <select id="living_arrangements" name="living_arrangements" style="background: #c9fffd; border: #056a67 1px solid; width: 27%;" class="form-control required title-select">
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
                   <label for="move_in_date">Move in date  <span class="text-danger">*</span></label>
                  <input id="move_in_date" name="move_in_date" type="month"  maxlength="40" class="form-control required">
                </div>
                
              </div>

              
              <div class="row mt-3">
                <div class="form-group col-md-12">
                  <label class="bold">Postal address is the same? </label>
                  <div class="option-group">
                    <input class="option" type="radio" id="Yes" name="postal_address_same" value="Yes" checked required>
                    <label for="Yes" style="float:left;margin-right: <?php echo $marginright;?>;" >Yes</label>
                    <input class="option" type="radio" id="No" name="postal_address_same" value="No">
                    <label for="No" style="float:left;margin-right: <?php echo $marginright;?>;" >No</label>
                   
                  
                  </div>
                 
             
                </div>
              </div> 

              <div class="row mt-3 hide" id="postalAddressRow">
                <div class="form-group col-md-6">
                    <label for="postal_address">Postal address <span class="text-danger">*</span></label>
                    <input id="postal_address" name="postal_address" type="text"  maxlength="40" class="form-control required">
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

                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="form-group col-md-4">
                        <label  class="bold" for="first_name">First Name </label>
                        <input id="first_name" name="first_name" type="text"   maxlength="40" class="form-control required">
                      </div> 
                      <div class="form-group col-md-4">
                        <label  class="bold" for="middle_name">Middle Name </label>
                        <input id="middle_name" name="middle_name" type="text"   maxlength="40" class="form-control required">
                      </div>
                    
                      <div class="form-group col-md-4">
                        <label  class="bold" for="last_name">Last Name </label>
                        <input id="last_name" name="last_name" type="text"   maxlength="40" class="form-control required">
                      </div>
                    </div>
                  </div>
                </div>


               

                <div class="row mt-3">
                  <div class="form-group col-md-12">
                    <label class="bold">State issued in 
                    
                    </label>
                    <div class="option-group" style=" display: flex !important; gap: 0px; flex-direction: column;margin-bottom: 5px;" >
                      <select id="living_arrangements" name="living_arrangements" style="background: #c9fffd; border: #056a67 1px solid; width: 27%;" class="form-control required title-select">
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
                      <div class="form-group col-md-4">
                        <label  class="bold" for="driving_licence">Driver licence number  </label>
                        <input id="driving_licence" name="driving_licence" type="text"   maxlength="40" class="form-control required">
                      </div> 
                      <div class="form-group col-md-4">
                        <label  class="bold" for="middle_name">Card number  </label>
                        <input id="middle_name" name="middle_name" type="text"   maxlength="40" class="form-control required">
                      </div>
                    
                     
                    </div>
                  </div>
                </div>

                <div class="row mt-3 " id="">
                  <div class="form-group col-md-6">
                      <label for="postal_address">Expiry date  <span class="text-danger">*</span></label>
                      <input id="expiry_date" name="expiry_date" type="date"  maxlength="40" class="form-control required">
                  </div>
                </div>
                
                <div class="row mt-3">
                  <div class="form-group col-md-12">
                    <label class="bold">Legal name has ever changed? </label>
                    <div class="option-group">
                      <input class="option" type="radio" id="legal_Yes" name="legal_name_changed" value="legal_Yes"   required>
                      <label for="legal_Yes" style="float:left;margin-right: <?php echo $marginright;?>;" >Yes</label>
                      <input class="option" type="radio" id="legal_No" name="legal_name_changed" value="legal_No" checked  >
                      <label for="legal_No" style="float:left;margin-right: <?php echo $marginright;?>;" >No</label>
                    </div>
        
                  </div>
                </div>  
                
                <div class="row mt-3">
                  <div class="form-group col-md-12">
                    <label class="bold">Residency status  </label>
                    <div class="option-group">
                      <input class="option" type="radio" id="australian_citizen" name="residency_status" value="australian_citizen"   required>
                      <label for="australian_citizen" style="float:left;margin-right: <?php echo $marginright;?>;" >Australian citizen</label>
                      <input class="option" type="radio" id="permanent_resident" name="residency_status" value="permanent_resident" checked  >
                      <label for="permanent_resident" style="float:left;margin-right: <?php echo $marginright;?>;" >Permanent Resident</label>
                      <input class="option" type="radio" id="temporary_resident" name="residency_status" value="temporary_resident" checked  >
                      <label for="temporary_resident" style="float:left;margin-right: <?php echo $marginright;?>;" >Temporary resident</label>
                    </div>
        
                  </div>
                </div> 

                <div class="row mt-3 hide" id="legal_previous_name">
                    <div class="col-md-12">
                      <label  class="bold" for="first_name">Enter a previous name </label>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label  class="bold" for="previous_first_name">First Name </label>
                          
                          <input id="previous_first_name" name="previous_first_name" type="text"   maxlength="40" class="form-control required">
                        </div> 
                        <div class="form-group col-md-4">
                          <label  class="bold" for="previous_middle_name">Middle Name </label>
                          <input id="previous_middle_name" name="previous_middle_name" type="text"   maxlength="40" class="form-control required">
                        </div>
                      
                        <div class="form-group col-md-4">
                          <label  class="bold" for="previous_last_name">Last Name </label>
                          <input id="previous_last_name" name="previous_last_name" type="text"   maxlength="40" class="form-control required">
                        </div>
                      </div>
                    </div>
                  </div>
              
                  
                <div class="row mt-3 " id="">
                  <div class="form-group col-md-6">
                      <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                      <input id="date_of_birth" name="date_of_birth" type="date"  maxlength="40" class="form-control required">
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
  const radios = document.querySelectorAll('input[name="title1"]');
  const select = document.querySelector('#title2');
  const relationship = document.querySelector('#relationship');

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
  
  relationship.addEventListener('change', () => {
      relationship.classList.add('active');
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
        <label>Dependant ${i}:</label>
        <input type="number" name="dependant_age_${i}" min="0" max="120" placeholder="Age" />
        <span>years old</span>
      `;
      dependantFields.appendChild(div);
    }
  });
</script>

<script>
/* $(document).ready(function () {
  $('#phone_number').on('input', function () {
    // Allow only numbers
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $('#phone_number').on('blur', function () {
    const phone = $(this).val().trim();
    if (phone === '') {
      alert('Please enter your phone number.');
    } else if (phone.length < 8 || phone.length > 15) {
      alert('Phone number must be between 8 and 15 digits.');
    }
  });
}); */


$(document).ready(function () {
  $('#phone_number').on('input', function () {
    let val = $(this).val().replace(/\D/g, ''); // Keep digits only

    // Limit to 9 digits total
    if (val.length > 9) val = val.slice(0, 9);

    // Auto insert spaces: 222 222 222
    val = val.replace(/(\d{3})(\d{0,3})(\d{0,3})/, function (_, g1, g2, g3) {
      return [g1, g2, g3].filter(Boolean).join(' ');
    });

    $(this).val(val);
  });

  $('#phone_number').on('blur', function () {
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

</body>

</html>