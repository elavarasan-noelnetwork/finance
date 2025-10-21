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
        min-height: 780px;
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
        padding : 0.6rem 0.6rem !important;
    }

    .label-question {
        font-weight: 600;
        padding-top: 0px;
        padding-bottom: 10px;
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

                                    <form id="ownership-form" action="/storeoptin" method="post">
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
                                                <div class="menu-item"> Ownership details</div>
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
                                                    <div style="font-weight:600; font-size:1.5rem; margin-bottom:30px;color:#056a67;display:flex; align-items:center; gap:8px;">
                                                        <img src="<?php echo ASSETS_DIR; ?>/images/house.jpg" alt="map" width="35" height="35" />
                                                        Ownership details
                                                    </div>

                                                    <div class="label-question">Choose your property ?</div>
                                                    <div class="option-group" data-group="property-choice">
                                                        <div class="option" data-value="1">33 Carl Street</div>
                                                        <div class="option" data-value="2">39 Raffles</div>
                                                        <div class="option" data-value="3">61 Regent</div>
                                                        <div class="option" data-value="4">55 Regent</div>
                                                        <input type="hidden" name="property_choice" id="property_choice" value="">
                                                    </div>

                                                    <!-- Buyer Type -->
                                                    <div id="buyer-type-section" style="display:none;" class="buyer-type">
                                                        <div class="label-question">Buying as a ?</div>
                                                        <div class="option-group" data-group="buyer-type">
                                                            <div class="option" data-value="Individual">Individual</div>
                                                            <div class="option" data-value="Trust">Trust</div>
                                                            <div class="option" data-value="SMSF">SMSF</div>
                                                            <input type="hidden" name="buyer_type" id="buyer_type" value="">
                                                        </div>
                                                    </div>

                                                    <!-- Individual Form -->
                                                    <div id="form-individual" class="buyer-form">
                                                        <div id="applicant-count-section" style="display:none;">
                                                            <div class="label-question">How many applicants
                                                                <span class='label-subtext'>(just you or you and someone else)</span> ?
                                                            </div>
                                                            <div class="option-group applicant-count-group" data-group="applicant-count">
                                                                <div class="option active" data-value="1">1</div>
                                                                <div class="option" data-value="2">2</div>
                                                                <input type="hidden" name="applicant_count" id="applicant_count" value="1">
                                                            </div>

                                                            <div id="applicant-1" class="applicant-fields" style="margin-top:15px;">
                                                                <input id="first_name" name="first_name" type="text" class="form-control" placeholder="First name" value="<?= htmlspecialchars($_SESSION['auth']['usr_fname'] ?? '') ?>">
                                                                <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Last name" value="<?= htmlspecialchars($_SESSION['auth']['usr_lname'] ?? '') ?>" style="margin-top:10px;">
                                                            </div>

                                                            <div id="applicant-2" class="applicant-fields" style="display:none; margin-top:15px;">
                                                                <input id="first_name2" name="first_name2" type="text" class="form-control" placeholder="Co-applicant First name">
                                                                <input id="last_name2" name="last_name2" type="text" class="form-control" placeholder="Co-applicant Last name" style="margin-top:10px;">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Trust -->
                                                    <div id="trust-name-question" class="buyer-form" style="display:none;">
                                                        <div class="label-question">Provide trust name</div>
                                                        <input id="trust_name" name="trust_name" type="text" class="form-control" placeholder="Trust name">
                                                    </div>

                                                    <div id="trust-help-question" class="buyer-form" style="display:none;">
                                                        <div class="label-question">Do you need help with setting up a trust ?</div>
                                                        <div class="option-group" data-group="trust-help">
                                                            <div class="option" data-value="Yes">Yes</div>
                                                            <div class="option active" data-value="No">No</div>
                                                            <input type="hidden" name="trust_help" id="trust_help" value="">
                                                        </div>
                                                    </div>

                                                    <!-- SMSF -->
                                                    <div id="smsf-name-question" class="buyer-form" style="display:none;">
                                                        <div class="label-question">Provide SMSF name</div>
                                                        <input id="smsf_name" name="smsf_name" type="text" class="form-control" placeholder="SMSF name">
                                                    </div>

                                                    <div id="smsf-help-question" class="buyer-form" style="display:none;">
                                                        <div class="label-question">Do you need help with setting up a SMSF ?</div>
                                                        <div class="option-group" data-group="smsf-help">
                                                            <div class="option" data-value="Yes">Yes</div>
                                                            <div class="option active" data-value="No">No</div>
                                                            <input type="hidden" name="smsf_help" id="smsf_help" value="">
                                                        </div>
                                                    </div>

                                                    <!-- Loan -->
                                                    <div id="loan-question" class="buyer-form" style="display:none;">
                                                        <div class="label-question">Do you need help with a loan ?</div>
                                                        <div class="option-group" data-group="loan-help">
                                                            <div class="option" data-value="Yes">Yes</div>
                                                            <div class="option" data-value="No">No</div>
                                                            <input type="hidden" name="loan_help" id="loan_help" value="">
                                                        </div>
                                                    </div>

                                                    <div id="cash-question" class="buyer-form" style="display:none;">
                                                        <div class="label-question">Do you have cash for the investment ?</div>
                                                        <div class="option-group" data-group="cash-available">
                                                            <div class="option" data-value="Yes">Yes</div>
                                                            <div class="option" data-value="No">No</div>
                                                            <input type="hidden" name="cash_available" id="cash_available" value="">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="form-footer">
                                                    <button type="submit" class="form-submit-btn">Submit</button>
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

            // 2) XOR rule: valid only when loan_help !== cash_available
            $.validator.addMethod("loanCashXor", function(value, element) {
                const buyerType = $("#buyer_type").val();
                const loanVal = $("#loan_help").val();
                const cashVal = $("#cash_available").val();

                // Skip until buyer type selected
                if (buyerType === "") return true;

                // Let 'required' handle empty cases
                if (loanVal === "" || cashVal === "") return true;

                if (buyerType === "No") return true;

                // Valid only if they differ (Yes/No or No/Yes)
                return loanVal !== cashVal;
            }, "Loan Help and Cash Available cannot both be Yes or both be No");


            // ✅ Initialize form validation
            $("#ownership-form").validate({
                ignore: [],
                rules: {
                    property_choice: {
                        required: true
                    },
                    buyer_type: {
                        required: function() {
                            return $("#property_choice").val() !== "";
                        }
                    },
                    first_name: {
                        required: function() {
                            return $("#buyer_type").val() === "Individual";
                        },
                        lettersonly: true
                    },
                    last_name: {
                        required: function() {
                            return $("#buyer_type").val() === "Individual";
                        },
                        lettersonly: true
                    },
                    first_name2: {
                        required: function() {
                            return $("#buyer_type").val() === "Individual" && $("#applicant_count").val() === "2";
                        },
                        lettersonly: true
                    },
                    last_name2: {
                        required: function() {
                            return $("#buyer_type").val() === "Individual" && $("#applicant_count").val() === "2";
                        },
                        lettersonly: true
                    },
                    trust_name: {
                        required: function() {
                            return $("#buyer_type").val() === "Trust";
                        }
                    },
                    smsf_name: {
                        required: function() {
                            return $("#buyer_type").val() === "SMSF";
                        }
                    },
                    loan_help: {
                        required: function() {
                            const t = $("#buyer_type").val();
                            return t === "Individual" || t === "Trust" || t === "SMSF";
                        }
                    },
                    cash_available: {
                        required: function() {
                            const buyerType = $("#buyer_type").val();
                            const loanHelp = $("#loan_help").val();
                            return buyerType !== "" && loanHelp === "No";
                        },
                        loanCashXor: true
                    }
                },
                messages: {
                    property_choice: "Please choose your property",
                    buyer_type: "Please select a buying type",
                    first_name: {
                        required: "Please enter applicant 1 first name",
                        lettersonly: "First name should contain only letters"
                    },
                    last_name: {
                        required: "Please enter applicant 1 last name",
                        lettersonly: "Last name should contain only letters"
                    },
                    first_name2: {
                        required: "Please enter applicant 2 first name",
                        lettersonly: "First name should contain only letters"
                    },
                    last_name2: {
                        required: "Please enter applicant 2 last name",
                        lettersonly: "Last name should contain only letters"
                    },
                    trust_name: "Please enter trust name",
                    smsf_name: "Please enter SMSF name",
                    loan_help: {
                        required: "Please select if you need help with a loan",
                        loanCashXor: "Loan Help and Cash Available cannot both be Yes or both be No"
                    },
                    cash_available: {
                        required: "Please specify if you have cash available",
                        loanCashXor: "Please select either Loan Help or Cash Available"
                    }
                },
                errorPlacement: function(label, element) {
                    label.addClass('mt-2 text-danger-registration');
                    if (element.closest('.option-group').length) {
                        label.insertAfter(element.closest('.option-group'));
                    } else {
                        label.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('form-control-danger');
                },
                unhighlight: function(element) {
                    $(element).removeClass('form-control-danger');
                },
                submitHandler: function(form) {
                    console.log("✅ Validation passed, submitting...");
                    form.submit();
                }
            });

            // ✅ Custom Option Group Logic (works like radio buttons)
            function initOptionGroup(groupName, hiddenInputId, callback = null) {
                const options = document.querySelectorAll(`.option-group[data-group="${groupName}"] .option`);
                const hiddenInput = document.getElementById(hiddenInputId);
                if (!options.length || !hiddenInput) return;

                options.forEach(option => {
                    option.addEventListener('click', () => {
                        options.forEach(o => o.classList.remove('active'));
                        option.classList.add('active');
                        hiddenInput.value = option.dataset.value;

                        // ✅ Trigger re-validation
                        $("#ownership-form").validate().element(hiddenInput);

                        if (callback) callback(hiddenInput.value, option);
                    });
                });

                // Default selection (if any active)
                const defaultOption = document.querySelector(`.option-group[data-group="${groupName}"] .option.active`);
                if (defaultOption) {
                    hiddenInput.value = defaultOption.dataset.value;
                    if (callback) callback(hiddenInput.value, defaultOption);
                }
            }

            // ✅ Section visibility control
            const buyerTypeSection = document.getElementById('buyer-type-section');
            const applicantSection = document.getElementById('applicant-count-section');
            const loanQuestion = document.getElementById('loan-question');
            const cashQuestion = document.getElementById('cash-question');
            const applicant2 = document.getElementById('applicant-2');
            const trustHelpQuestion = document.getElementById('trust-help-question');
            const trustNameQuestion = document.getElementById('trust-name-question');
            const smsfHelpQuestion = document.getElementById('smsf-help-question');
            const smsfNameQuestion = document.getElementById('smsf-name-question');
            const individualForm = document.getElementById('form-individual');

            // ✅ Init option groups
            initOptionGroup('property-choice', 'property_choice', () => buyerTypeSection.style.display = 'block');

            initOptionGroup('buyer-type', 'buyer_type', (value) => {
                individualForm.style.display = 'none';
                trustHelpQuestion.style.display = 'none';
                trustNameQuestion.style.display = 'none';
                smsfHelpQuestion.style.display = 'none';
                smsfNameQuestion.style.display = 'none';
                applicantSection.style.display = 'none';

                if (value === 'Individual') {
                    individualForm.style.display = 'block';
                    applicantSection.style.display = 'block';
                } else if (value === 'Trust') {
                    trustHelpQuestion.style.display = 'block';
                    trustNameQuestion.style.display = 'block';
                } else if (value === 'SMSF') {
                    smsfHelpQuestion.style.display = 'block';
                    smsfNameQuestion.style.display = 'block';
                }

                loanQuestion.style.display = 'block';
            });

            initOptionGroup('applicant-count', 'applicant_count', (value) => {
                applicant2.style.display = (value === '2') ? 'block' : 'none';
            });

            initOptionGroup('trust-help', 'trust_help');
            initOptionGroup('smsf-help', 'smsf_help');
            initOptionGroup('loan-help', 'loan_help', (value) => {
                cashQuestion.style.display = (value === 'No') ? 'block' : 'none';
            });
            initOptionGroup('cash-available', 'cash_available');

            
        });
    </script>
    
</body>

</html>