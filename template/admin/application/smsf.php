<?php

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
        min-height: 985px;
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
        margin-bottom: 10px;
        /* 🆕 Adds space between menu items */
    }

    .form-sidebar-menu .menu-item-dashboard {
        background: #bfdfed;
        color: #434a54;
        font-weight: 600;
        padding: 18px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
        margin-bottom: 10px;
        /* 🆕 Adds space between menu items */
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
        font-weight: 550;
        padding-top: 0px;
        padding-bottom: 5px;
        font-size: 0.9rem;
    }

    .label-question-1 {
        font-weight: 550;
        padding-top: 20px;
        padding-bottom: 5px;
        font-size: 0.9rem;
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
        font-size: 0.8rem;
        font-weight: 200 !important;
        opacity: 20 !important;
    }

    .form-submit-btn {
        margin-top: 10px;
        background: #056a67;
        border: none;
        padding: 8px 15px;
        color: #fff;
        font-size: 16px;
        font-weight: 400;
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
        padding-top: 0px;
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

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .form-box {
        flex: 1;
        min-width: 300px;
    }

    .form-border {
        border: 1px solid #056a67;
        background: #e5fffe;
        padding: 15px;
        border-radius: 8px;
        margin-top: 0px;
    }



    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
    }

    textarea {
        width: 106%;
        padding: 13px 14px;
        border-radius: 8px;
        border: #6ec3c0 1px solid !important;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
        background-color: #c9fffd !important;
        font-family: 'Inter', sans-serif;
        resize: vertical;
        min-height: 90px !important;
        box-sizing: border-box;
        border: 1px solid #33d4cf;
        font-weight: 550 !important;
    }


    textarea:focus {
        border-color: #22a39f;
        background-color: #fff;
    }

    textarea::placeholder {
        color: #555 !important;
        font-size: 0.9rem;
        font-weight: 200 !important;
        opacity: 50 !important;
    }

    .form-row input{
        font-weight: 550 !important;
    }
</style>

<body class="page-application">
<div class="container-scroller">
    <?php View::render("admin/_topnavbar", ["title" => "Welcome Admin"]); ?>

    <div class="container-fluid page-body-wrapper">
        <div class="main-panel" style="width:100%;">
            <div class="content-wrapper">
                <div class="row justify-content-center">
                    <div class="col-12 grid-margin">
                        <div class="card" style="background:#e5fffe;">
                            <div class="card-body" style="background:#e5fffe;">

                                <form id="smsf-form" action="/storesmsf" method="post">
                                    <div class="form-layout">

                                        <!-- Sidebar -->
                                        <div class="form-sidebar-menu">
                                                <?php
                                                if (isset($_SESSION['auth']['user_application']) && $_SESSION['auth']['user_application'] == 1) {
                                                ?>
                                                    <a href="<?php echo BASE_URL; ?>proposals" style="text-decoration:none;color:#434a54">
                                                        <div class="menu-item-dashboard">Dashboard</div>
                                                    </a>
                                                <?php
                                                }
                                                ?>                                            
                                            <div class="menu-item">SMSF Details</div>
                                        </div>

                                        <!-- Content -->
                                        <div class="form-content">

                                            <?php
                                            if (isset($errorArray) && !empty($errorArray)) {  ?>
                                                <h6 id="errorMsg" class="fw-semibold" style="color:red;padding-bottom:10px">
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

                                            <div class="form-body">
                                                <!-- Title -->
                                                <div style="font-weight:600; font-size:1.5rem; margin-bottom:30px; color:#056a67; display:flex; align-items:center; gap:8px;">
                                                    <img src="<?php echo ASSETS_DIR; ?>/images/smsf.png" alt="trust" width="45" height="45" />
                                                    Corporate Trust Details
                                                </div>

                                                <!-- Fund Name & Company Name -->
                                                <div class="form-row">
                                                    <div class="form-box">
                                                        <div class="label-question">Self-Managed Super Fund Name</div>
                                                        <input type="text" name="smsf_name" class="form-control" placeholder="Enter SMSF name" value="<?php echo !empty($loanDetailsArray['zl_smsf_name']) ? $loanDetailsArray['zl_smsf_name'] : ''; ?>">
                                                    </div>
                                                    <div class="form-box">
                                                        <div class="label-question">Company Name</div>
                                                        <input type="text" name="company_name" class="form-control" placeholder="Enter company name">
                                                    </div>
                                                    <input type="hidden" name="loan_id" value="<?php echo !empty($loanDetailsArray['zl_id']) ? $loanDetailsArray['zl_id'] : ''; ?>">
                                                </div>

                                                <!-- Directors and Members 1 & 2 -->
                                                <div class="form-row">
                                                    <div class="form-box">
                                                        <div class="label-question">Director and Member 1 Details</div>
                                                        <div class="form-border">
                                                            <input type="text" name="member1_name" class="form-control" placeholder="Name" value="<?php echo !empty($_SESSION['auth']['usr_fname']) ? $_SESSION['auth']['usr_fname'] : ''; ?> <?php echo !empty($_SESSION['auth']['usr_lname']) ? $_SESSION['auth']['usr_lname'] : ''; ?>">
                                                            <input type="text" name="member1_id" class="form-control" placeholder="Director ID" style="margin-top:10px;">
                                                            <input type="text" name="member1_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;" value="<?php echo !empty($_SESSION['auth']['usr_address']) ? $_SESSION['auth']['usr_address'] : ''; ?>">
                                                            <input type="date" name="member1_dob" class="form-control" placeholder="Date of Birth" style="margin-top:10px;">
                                                            <input type="text" name="member1_pob" class="form-control" placeholder="Place of Birth (City, State and Country)" style="margin-top:10px;">
                                                            <input type="text" name="member1_tfn" class="form-control" placeholder="Tax File Number" style="margin-top:10px;">
                                                        </div>
                                                    </div>

                                                    <div class="form-box">
                                                        <div class="label-question">Director and Member 2 Details</div>
                                                        <div class="form-border">
                                                            <input type="text" name="member2_name" class="form-control" placeholder="Name">
                                                            <input type="text" name="member2_id" class="form-control" placeholder="Director ID" style="margin-top:10px;">
                                                            <input type="text" name="member2_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;">
                                                            <input type="date" name="member2_dob" class="form-control" placeholder="Date of Birth" style="margin-top:10px;">
                                                            <input type="text" name="member2_pob" class="form-control" placeholder="Place of Birth (City, State and Country)" style="margin-top:10px;">
                                                            <input type="text" name="member2_tfn" class="form-control" placeholder="Tax File Number" style="margin-top:10px;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Directors and Members 3 & 4 -->
                                                <div class="form-row">
                                                    <div class="form-box">
                                                        <div class="label-question">Director and Member 3 Details</div>
                                                        <div class="form-border">
                                                            <input type="text" name="member3_name" class="form-control" placeholder="Name">
                                                            <input type="text" name="member3_id" class="form-control" placeholder="Director ID" style="margin-top:10px;">
                                                            <input type="text" name="member3_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;">
                                                            <input type="date" name="member3_dob" class="form-control" placeholder="Date of Birth" style="margin-top:10px;">
                                                            <input type="text" name="member3_pob" class="form-control" placeholder="Place of Birth (City, State and Country)" style="margin-top:10px;">
                                                            <input type="text" name="member3_tfn" class="form-control" placeholder="Tax File Number" style="margin-top:10px;">
                                                        </div>
                                                    </div>

                                                    <div class="form-box">
                                                        <div class="label-question">Director and Member 4 Details</div>
                                                        <div class="form-border">
                                                            <input type="text" name="member4_name" class="form-control" placeholder="Name">
                                                            <input type="text" name="member4_id" class="form-control" placeholder="Director ID" style="margin-top:10px;">
                                                            <input type="text" name="member4_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;">
                                                            <input type="date" name="member4_dob" class="form-control" placeholder="Date of Birth" style="margin-top:10px;">
                                                            <input type="text" name="member4_pob" class="form-control" placeholder="Place of Birth (City, State and Country)" style="margin-top:10px;">
                                                            <input type="text" name="member4_tfn" class="form-control" placeholder="Tax File Number" style="margin-top:10px;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Submit -->
                                                <div class="form-footer">
                                                    <button type="submit" class="form-submit-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<?php View::render("admin/_scriptjs"); ?>
<script src="<?php echo ASSETS_DIR; ?>/vendors/jquery-validation/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    console.log("Validator loaded:", typeof $.validator !== 'undefined');

    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please use letters only");

    $("#smsf-form").validate({
        ignore: [],
        rules: {
            smsf_name: { required: true },
            company_name: { required: true },
            member1_name: { required: true, lettersonly: true },
            member1_id: { required: true },
            member1_address: { required: true },
            member1_dob: { required: true, date: true },
            member1_pob: { required: true },
            member1_tfn: { required: true },

            member2_name: { required: true, lettersonly: true },
            member2_id: { required: true },
            member2_address: { required: true },
            member2_dob: { required: true, date: true },
            member2_pob: { required: true },
            member2_tfn: { required: true },

            member3_name: { required: true, lettersonly: true },
            member3_id: { required: true },
            member3_address: { required: true },
            member3_dob: { required: true, date: true },
            member3_pob: { required: true },
            member3_tfn: { required: true },

            member4_name: { required: true, lettersonly: true },
            member4_id: { required: true },
            member4_address: { required: true },
            member4_dob: { required: true, date: true },
            member4_pob: { required: true },
            member4_tfn: { required: true }
        },
        messages: {
            smsf_name: "Please enter SMSF name",
            company_name: "Please enter company name",

            member1_name: "Enter Member 1 name",
            member1_id: "Enter Member 1 ID",
            member1_address: "Enter Member 1 address",
            member1_dob: "Enter Member 1 DOB",
            member1_pob: "Enter Member 1 POB",
            member1_tfn: "Enter Member 1 TFN",

            member2_name: "Enter Member 2 name",
            member2_id: "Enter Member 2 ID",
            member2_address: "Enter Member 2 address",
            member2_dob: "Enter Member 2 DOB",
            member2_pob: "Enter Member 2 POB",
            member2_tfn: "Enter Member 2 TFN",

            member3_name: "Enter Member 3 name",
            member3_id: "Enter Member 3 ID",
            member3_address: "Enter Member 3 address",
            member3_dob: "Enter Member 3 DOB",
            member3_pob: "Enter Member 3 POB",
            member3_tfn: "Enter Member 3 TFN",

            member4_name: "Enter Member 4 name",
            member4_id: "Enter Member 4 ID",
            member4_address: "Enter Member 4 address",
            member4_dob: "Enter Member 4 DOB",
            member4_pob: "Enter Member 4 POB",
            member4_tfn: "Enter Member 4 TFN"
        },
        errorPlacement: function (label, element) {
            label.addClass('mt-2 text-danger-registration');
            label.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('form-control-danger');
        },
        unhighlight: function (element) {
            $(element).removeClass('form-control-danger');
        },
        submitHandler: function (form) {
            console.log("✅ SMSF form validation passed — submitting");
            form.submit();
        }
    });
});
</script>

</body>
</html>
