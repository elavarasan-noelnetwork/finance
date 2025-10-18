(function ($) {
  'use strict';
  /* $.validator.setDefaults({
     submitHandler: function() {
      alert(" login submitted!");
     
     //showSwal('success-message');
     
     }
   }); */
  $(function () {


    $("#ownership-form").validate({
      rules: {
        usr_fname: {
          required: true,
          lettersonly: true
        },
        usr_lname: {
          lettersonly: true
        },
        usr_email: {
          required: true,
          email: true
        },
        usr_department: { required: true },
        usr_role: { required: true },
        usr_status: { required: true },
        usr_password: {
          required: true,
          minlength: 5,
          maxlength: 25
        },
      },
      messages: {
        usr_fname: {
          required: "Please enter the firstname",
          lettersonly: "First name should contain only letters"
        },
        usr_lname: {
          lettersonly: "Last name should contain only letters"
        },
        usr_email: "Please enter the email",
        usr_department: "Please select the department",
        usr_role: "Please select the role",
        usr_status: "Please select the status",
        usr_password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },

      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#updateRegisterForm").validate({
      rules: {
        usr_fname: {
          required: true,
          lettersonly: true
        },
        usr_lname: {
          lettersonly: true
        },
        usr_email: {
          required: true,
          email: true
        },
        usr_department: { required: true },
        usr_role: { required: true },
        usr_status: { required: true },
        usr_password: {
          required: true,
          minlength: 5,
          maxlength: 25
        },
      },
      messages: {
        usr_fname: {
          required: "Please enter the firstname",
          lettersonly: "First name should contain only letters"
        },
        usr_lname: {
          lettersonly: "Last name should contain only letters"
        },
        usr_email: "Please enter the email",
        usr_department: "Please select the department",
        usr_role: "Please select the role",
        usr_status: "Please select the status",
        usr_password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },

      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#loginForm").validate({
      rules: {

        username: {
          required: true,
          email: true // validate email format
        },
        password: {
          required: true
        }
      },
      messages: {

        username: {
          required: "Please enter a Email",
          minlength: "Your Email or Mobile Number must consist of at least 6 characters"
        },
        password: {
          required: "Please provide a password"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));
      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#forgetPasswordForm").validate({
      rules: {

        email: {
          required: true,
          email: true,
          minlength: 6
        }
      },
      messages: {

        email: {
          required: "Please enter a Email ",
          minlength: "Your Email must consist of at least 6 characters"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));
      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#AddDepartmentForm").validate({
      rules: {
        dep_name: {
          required: true
        },
        dep_status: {
          required: true
        }
      },
      messages: {

        dep_name: {
          required: "Please enter the department name"
        },
        dep_status: {
          required: "Select the department status"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#updateDepartmentForm").validate({
      rules: {
        dep_name: {
          required: true
        },
        dep_status: {
          required: true
        }
      },
      messages: {

        dep_name: {
          required: "Please enter the department name"
        },
        dep_status: {
          required: "Select the department status"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#AddRoleForm").validate({
      rules: {
        role_dep_id: {
          required: true
        },
        role_name: {
          required: true
        },
        role_status: {
          required: true
        }
      },
      messages: {

        role_dep_id: {
          required: "Please select the department name"
        },
        role_name: {
          required: "Please enter the role name"
        },
        role_status: {
          required: "Please select the status"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#updateRoleForm").validate({
      rules: {
        role_dep_id: {
          required: true
        },
        role_name: {
          required: true
        },
        role_status: {
          required: true
        }
      },
      messages: {

        role_dep_id: {
          required: "Please select the department name"
        },
        role_name: {
          required: "Please enter the role name"
        },
        role_status: {
          required: "Please select the status"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });


    $("#AddMenuForm").validate({
      rules: {
        men_name: {
          required: true
        },
        men_sort_order: {
          required: true,
          digits: true,
          minlength: 1,     // adjust as needed 
          maxlength: 3     // adjust as needed
        },
      },
      messages: {
        men_name: {
          required: "Please enter the menu name"
        },
        men_sort_order: {
          required: "Please enter the sort order",
          digits: "Please enter valid numbers",
          minlength: "Short order must be at least 1 digit",
          maxlength: "Short order cannot exceed 3 digits",
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });


    $("#updateMenuForm").validate({
      rules: {
        men_name: {
          required: true
        },
        men_sort_order: {
          required: true,
          digits: true,
          minlength: 1,     // adjust as needed 
          maxlength: 3     // adjust as needed
        },
      },
      messages: {
        men_name: {
          required: "Please enter the menu name"
        },
        men_sort_order: {
          required: "Please enter the sort order",
          digits: "Please enter valid numbers",
          minlength: "Short order must be at least 1 digit",
          maxlength: "Short order cannot exceed 3 digits",
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });


    $("#changePasswordForm").validate({
      rules: {
        old_pass: {
          required: true
        },
        new_pass: {
          required: true,
          minlength: 6,  // Adjust as needed
          maxlength: 25
        },
        confirm_new_pass: {
          required: true,
          equalTo: "#new_pass"
        }
      },
      messages: {
        old_pass: {
          required: "Please enter your old password"
        },
        new_pass: {
          required: "Please enter a new password",
          minlength: "New password must be at least 6 characters",
          maxlength: "New password cannot exceed 25 characters"
        },
        confirm_new_pass: {
          required: "Please confirm your new password",
          equalTo: "Passwords do not match"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        label.appendTo(element.closest('.form-group'));
      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger');
        $(element).addClass('form-control-danger');
      }
    });


    $("#AddPageForm").validate({
      rules: {
        pag_name: {
          required: true
        },
        ser_status: {
          required: true
        }
      },
      messages: {
        pag_name: {
          required: "Please enter the page name"
        },
        ser_status: {
          required: "Please select the status"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#updatePageForm").validate({
      rules: {
        pag_name: {
          required: true
        },
        ser_status: {
          required: true
        }
      },
      messages: {
        pag_name: {
          required: "Please enter the page name"
        },
        ser_status: {
          required: "Please select the status"
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        label.appendTo(element.closest('.form-group'));

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });


    $("#addCompany").validate({
      ignore: [], // ✅ include hidden inputs (like com_logo)
      rules: {
        com_email: {
          required: true,
          email: true
        },
        com_name: { required: true },
        com_address1: { required: true },
        com_city: { required: true },
        com_state: { required: true },
        com_zip: { required: true },
        com_country: { required: true },
        com_phone: { required: true },
        com_status: { required: true },
        hidden_logo_tmp: {  // ✅ validate hidden helper, not file input
          required: true
        },
      },
      messages: {
        com_email: {
          required: "Please enter the email",
          email: "Please enter a valid email address"
        },
        com_name: "Please enter the name",
        com_address1: "Please enter the address1",
        com_city: "Please enter the city",
        com_state: "Please enter the state",
        com_zip: "Please enter the zip",
        com_country: "Please enter the country",
        com_phone: "Please enter the phone",
        com_status: "Please enter the status",
        hidden_logo_tmp: "Please upload the logo" // ✅ message here
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        // ✅ special case: show logo error under preview box
        if (element.attr("id") === "hidden_logo_tmp") {
          label.insertAfter("#drop-zone");
        } else {
          label.appendTo(element.closest('.form-group'));
        }

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    $("#updateCompany").validate({
      ignore: [], // ✅ include hidden inputs (like com_logo)
      rules: {
        com_email: {
          required: true,
          email: true
        },
        com_name: { required: true },
        com_address1: { required: true },
        com_city: { required: true },
        com_state: { required: true },
        com_zip: { required: true },
        com_country: { required: true },
        com_phone: { required: true },
        com_status: { required: true },
        hidden_logo_tmp: {  // ✅ validate hidden helper, not file input
          required: true
        },
      },
      messages: {
        com_email: {
          required: "Please enter the email",
          email: "Please enter a valid email address"
        },
        com_name: "Please enter the name",
        com_address1: "Please enter the address1",
        com_city: "Please enter the city",
        com_state: "Please enter the state",
        com_zip: "Please enter the zip",
        com_country: "Please enter the country",
        com_phone: "Please enter the phone",
        com_status: "Please enter the status",
        hidden_logo_tmp: "Please upload the logo" // ✅ message here
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        //label.insertAfter(element);
        // ✅ special case: show logo error under preview box
        if (element.attr("id") === "hidden_logo_tmp") {
          label.insertAfter("#drop-zone");
        } else {
          label.appendTo(element.closest('.form-group'));
        }

      },
      highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
      }
    });

    // Custom TinyMCE validation
    // Add custom method for TinyMCE
    $.validator.addMethod("tinyMCERequired", function (value, element) {
      console.log("tinyMCERequired called for:", element.id); // debug

      // Only validate if checkbox is checked
      if (!$("#pro_text_page_inc").is(":checked")) {
        return true; // skip validation
      }

      if (typeof tinymce !== "undefined") {
        var editor = tinymce.get(element.id);
        if (editor) {
          var content = editor.getContent({ format: "text" }).trim();
          console.log("Editor content length:", content.length); // debug
          return content.length > 0;
        }
      }

      return false; // fail validation if editor not initialized or empty
    }, "Please enter the text page content before proceeding");

    // Validate at least one file uploaded
    $.validator.addMethod("atLeastOneFile", function (value, element) {
      return filesArray.length > 0; // pass if at least one file exists
    }, "Please upload at least one image.");

    $("#addProposal").validate({
      ignore: [],
      rules: {
        pro_com_id: { required: true },
        pro_title: {
          required: true,
          maxlength: 200
        },
        pro_project_address: {
          required: true,
          maxlength: 200
        },
        pro_customer_name: {
          required: {
            depends: function (element) {
              return $("#pro_agrement_page_inc").is(":checked");
            }
          },
          maxlength: 200
        },
        pro_customer_address: {
          required: {
            depends: function (element) {
              return $("#pro_agrement_page_inc").is(":checked");
            }
          },
          maxlength: 200
        },
        pro_text_page: {
          tinyMCERequired: {
            depends: function () {
              return $("#pro_text_page_inc").is(":checked");
            }
          },
        },
        "files[]": {  
          atLeastOneFile: true
        }
      },
      messages: {
        pro_com_id: "Please select the company",
        pro_title: {
          required: "Please enter the proposal title",
          email: "Proposal title cannot exceed 200 characters"
        },
        pro_project_address: {
          required: "Please enter the project location",
          email: "Project location cannot exceed 200 characters"
        },
        pro_customer_name: {
          required: "Please enter the customer name",
          maxlength: "Customer name cannot exceed 200 characters"
        },
        pro_customer_address: {
          required: "Please enter the customer address",
          maxlength: "Customer address cannot exceed 200 characters"
        },
        pro_text_page: {
          tinyMCERequired: "Please enter the text page content"
        },
        "files[]": {
          atLeastOneFile: "Please upload at least one image."
        }
      },
      errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger-registration');
        // ✅ special case: show logo error under preview box
        if (element.attr("id") === "hidden_logo_tmp") {
          label.insertAfter("#drop-zone");

        } else if (element.attr("id") === "pro_text_page") {
          // Append error after TinyMCE editor container
          label.insertAfter($('#pro_text_page').next('.tox')); // or $('#pro_text_page_ifr').parent()
        }
        if (element.attr("id") === "fileInput") {
          label.insertAfter("#drop-zone"); // show error under drop zone
        }
        else {
          label.appendTo(element.closest('.form-group'));
        }

      },
      highlight: function (element, errorClass) {
        if (element.id === "pro_text_page") {
          $(element).next('.tox').addClass('border border-danger'); // red border
        } else {
          $(element).addClass('form-control-danger');
          $(element).parent().addClass('has-danger');
        }
      },
      unhighlight: function (element, errorClass) {
        if (element.id === "pro_text_page") {
          $(element).next('.tox').removeClass('border border-danger');
        } else {
          $(element).removeClass('form-control-danger');
          $(element).parent().removeClass('has-danger');
        }
      }
    });


    // propose username by combining first- and lastname
    $("#username").focus(function () {
      var firstname = $("#firstname").val();
      var lastname = $("#lastname").val();
      if (firstname && lastname && !this.value) {
        this.value = firstname + "." + lastname;
      }
    });
    $('input[name="phonenumber"]').on('input', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    $.validator.addMethod("lettersonly", function (value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "First name should contain only letters.");

    $("#usr_fname").on("input", function () {
      this.value = this.value.replace(/[^a-zA-Z ]/g, '');
    });
    $("#usr_lname").on("input", function () {
      this.value = this.value.replace(/[^a-zA-Z ]/g, '');
    });
    $("#usr_mobile").on("input", function () {
      this.value = this.value.replace(/[^0-9]/g, '');
    });



    //code to hide topic selection, disable for demo
    var newsletter = $("#newsletter");
    // newsletter topics are optional, hide at first
    var inital = newsletter.is(":checked");
    var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
    var topicInputs = topics.find("input").attr("disabled", !inital);
    // show when newsletter is checked
    newsletter.on("click", function () {
      topics[this.checked ? "removeClass" : "addClass"]("gray");
      topicInputs.attr("disabled", !this.checked);
    });


  });
})(jQuery);