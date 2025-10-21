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
        min-height: 955px;
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

                                    <form id="trust-form" action="/storetrust" method="post">
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

                                                <div class="menu-item">Trust details</div>
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
                                                        <img src="<?php echo ASSETS_DIR; ?>/images/trust.png" alt="trust" width="35" height="35" />
                                                        Corporate Trust Details
                                                    </div>

                                                    <!-- ================== Company & Trust Name ================== -->
                                                    <div class="form-row">
                                                        <div class="form-box">
                                                            <div class="label-question">Company Name</div>
                                                            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter company name">
                                                        </div>

                                                        <div class="form-box">
                                                            <div class="label-question">Trust Name</div>
                                                            <input type="text" name="trust_name" id="trust_name" class="form-control" placeholder="Enter trust name" value="<?php echo !empty($loanDetailsArray['zl_trust_name']) ? $loanDetailsArray['zl_trust_name'] : ''; ?>">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="loan_id" value="<?php echo !empty($loanDetailsArray['zl_id']) ? $loanDetailsArray['zl_id'] : ''; ?>">

                                                    <!-- ================== Directors ================== -->
                                                    <div class="form-row">
                                                        <div class="form-box">
                                                            <div class="label-question">Director 1 Details</div>
                                                            <div class="form-border">
                                                                <input type="text" name="director1_name" class="form-control" placeholder="Name" value="<?php echo !empty($_SESSION['auth']['usr_fname']) ? $_SESSION['auth']['usr_fname'] : ''; ?> <?php echo !empty($_SESSION['auth']['usr_lname']) ? $_SESSION['auth']['usr_lname'] : ''; ?>">
                                                                <input type="text" name="director1_id" class="form-control" placeholder="Director ID" style="margin-top:10px;">
                                                                <input type="text" name="director1_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;" value="<?php echo !empty($_SESSION['auth']['usr_address']) ? $_SESSION['auth']['usr_address'] : ''; ?>">
                                                                <input type="date" name="director1_dob" class="form-control" placeholder="Date of Birth" style="margin-top:10px;">
                                                                <input type="text" name="director1_pob" class="form-control" placeholder="Place of Birth (City, State and Country)" style="margin-top:10px;">
                                                                <input type="text" name="director1_tfn" class="form-control" placeholder="Tax File Number" style="margin-top:10px;">
                                                            </div>
                                                        </div>

                                                        <div class="form-box">
                                                            <div class="label-question">Director 2 Details</div>
                                                            <div class="form-border">
                                                                <input type="text" name="director2_name" class="form-control" placeholder="Name">
                                                                <input type="text" name="director2_id" class="form-control" placeholder="Director ID" style="margin-top:10px;">
                                                                <input type="text" name="director2_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;">
                                                                <input type="date" name="director2_dob" class="form-control" placeholder="Date of Birth" style="margin-top:10px;">
                                                                <input type="text" name="director2_pob" class="form-control" placeholder="Place of Birth (City, State and Country)" style="margin-top:10px;">
                                                                <input type="text" name="director2_tfn" class="form-control" placeholder="Tax File Number" style="margin-top:10px;">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- ================== Shareholders ================== -->
                                                    <div class="form-row">
                                                        <div class="form-box">
                                                            <div class="label-question">Shareholder 1 Details</div>
                                                            <div class="form-border">
                                                                <input type="text" name="shareholder1_name" class="form-control" placeholder="Name">
                                                                <input type="text" name="shareholder1_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;">
                                                            </div>
                                                        </div>

                                                        <div class="form-box">
                                                            <div class="label-question">Shareholder 2 Details</div>
                                                            <div class="form-border">
                                                                <input type="text" name="shareholder2_name" class="form-control" placeholder="Name">
                                                                <input type="text" name="shareholder2_address" class="form-control" placeholder="Residential Address" style="margin-top:10px;">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- ================== Beneficiaries & Appointors ================== -->
                                                    <div class="form-row">
                                                        <div class="form-box">
                                                            <div class="label-question-1">Would you like to add specific beneficiaries or leave as the above trustees?</div>
                                                            <textarea name="beneficiaries" id="beneficiaries" class="form-control" placeholder="Enter beneficiaries"></textarea>
                                                        </div>

                                                        <div class="form-box">
                                                            <div class="label-question-1">Would you like to add specific appointors or have the trustees have the power to appoint and remove?</div>
                                                            <textarea name="appointors" id="appointors" class="form-control" placeholder="Enter appointors"></textarea>
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

    <!-- container-scroller -->
    <?php
    View::render("admin/_scriptjs");
    ?>
    <!-- ✅ Validation Script -->

    <script src="<?php echo ASSETS_DIR; ?>/vendors/jquery-validation/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log("Validator loaded:", typeof $.validator !== 'undefined');

            // ✅ Custom Rule: Letters only
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
            }, "Please use letters only");

            // ✅ Initialize validation for Trust Form
            $("#trust-form").validate({
                ignore: [],
                rules: {
                    company_name: {
                        required: true,
                        lettersonly: false
                    },
                    trust_name: {
                        required: true
                    },
                    director1_name: {
                        required: true,
                        lettersonly: true
                    },
                    director1_id: {
                        required: true
                    },
                    director1_address: {
                        required: true
                    },
                    director1_dob: {
                        required: true,
                        date: true
                    },
                    director1_pob: {
                        required: true
                    },
                    director1_tfn: {
                        required: true
                    },
                    director2_name: {
                        required: true,
                        lettersonly: true
                    },
                    director2_id: {
                        required: true
                    },
                    director2_address: {
                        required: true
                    },
                    director2_dob: {
                        required: true,
                        date: true
                    },
                    director2_pob: {
                        required: true
                    },
                    director2_tfn: {
                        required: true
                    },
                    shareholder1_name: {
                        required: true,
                        lettersonly: true
                    },
                    shareholder1_address: {
                        required: true
                    },
                    shareholder2_name: {
                        required: true,
                        lettersonly: true
                    },
                    shareholder2_address: {
                        required: true
                    },
                    beneficiaries: {
                        required: true
                    },
                    appointors: {
                        required: true
                    }
                },
                messages: {
                    company_name: {
                        required: "Please enter company name"
                    },
                    trust_name: {
                        required: "Please enter trust name"
                    },
                    director1_name: {
                        required: "Enter Director 1 name",
                        lettersonly: "Name should contain only letters"
                    },
                    director1_id: {
                        required: "Enter Director 1 ID"
                    },
                    director1_address: {
                        required: "Enter Director 1 address"
                    },
                    director1_dob: {
                        required: "Select Director 1 date of birth",
                        date: "Enter a valid date"
                    },
                    director1_pob: {
                        required: "Enter Director 1 place of birth"
                    },
                    director1_tfn: {
                        required: "Enter Director 1 TFN"
                    },
                    director2_name: {
                        required: "Enter Director 2 name",
                        lettersonly: "Name should contain only letters"
                    },
                    director2_id: {
                        required: "Enter Director 2 ID"
                    },
                    director2_address: {
                        required: "Enter Director 2 address"
                    },
                    director2_dob: {
                        required: "Select Director 2 date of birth",
                        date: "Enter a valid date"
                    },
                    director2_pob: {
                        required: "Enter Director 2 place of birth"
                    },
                    director2_tfn: {
                        required: "Enter Director 2 TFN"
                    },
                    shareholder1_name: {
                        required: "Enter Shareholder 1 name",
                        lettersonly: "Name should contain only letters"
                    },
                    shareholder1_address: {
                        required: "Enter Shareholder 1 address"
                    },
                    shareholder2_name: {
                        required: "Enter Shareholder 2 name",
                        lettersonly: "Name should contain only letters"
                    },
                    shareholder2_address: {
                        required: "Enter Shareholder 2 address"
                    },
                    beneficiaries: {
                        required: "Please enter beneficiaries"
                    },
                    appointors: {
                        required: "Please enter appointors"
                    }
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger-registration');
                    label.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('form-control-danger');
                },
                unhighlight: function(element) {
                    $(element).removeClass('form-control-danger');
                },
                submitHandler: function(form) {
                    console.log("✅ Trust form validation passed — submitting");
                    form.submit();
                }
            });
        });
    </script>


</body>

</html>