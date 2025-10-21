/* ======================================
  Filename: wizard.js
  Author: Elavarasan 
  Description: For dynamic add category and tab based submission
               This file used to newly added categories
  =======================================
*/
(function ($) {
  'use strict';

  var form = $("#example-vertical-wizard");
  const categoryFilesMap = {};

  $.validator.addMethod("nineDigitNumber", function (value, element) {
    // remove spaces if any
    var cleaned = value.replace(/\s+/g, '');
    return this.optional(element) || (/^\d{9}$/).test(cleaned);
  }, "Please enter exactly 9 digits.");

  form.validate({
    errorPlacement: function errorPlacement(error, element) {
      element.after(error);
    },
    ignore: [],
    rules: {
      phone_number: {
        required: true,
        nineDigitNumber: true
      },
      current_residential_address: { 
        required: true,
      },
      move_in_date: {
        required: true,
      },
      postal_address: {
        required: true,
      },
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
      state_issued_in: {
        required: true,
      },
      driving_licence: {
        required: true,
        minlength: 6,
        maxlength: 10
      },
      card_number: {
        required: true,
        minlength: 6,
        maxlength: 10
      },
      expiry_date: {
        required: true,
      },
      previous_first_name: {
        required: true,
      },
      previous_last_name: {
        required: true,
      },
      date_of_birth: {
        required: true,
      }


    },
    messages: {
      phone_number: {
        required: "Phone number is required",
        nineDigitNumber: "Please enter exactly 9 digits"
      },
      current_residential_address: {
        required: "Residential address is required"
      },
      move_in_date: {
        required: "Move in date is required"
      },
      postal_address: {
        required: "Postal address is required"
      },
      first_name: {
        required: "First name is required"
      },
      last_name: {
        required: "Last name is required"
      },
      state_issued_in: {
        required: "select a state of issue"
      },
      driving_licence: {
        required: "Driver licence number is required",
        minlength: "Licence number must be at least 6 characters",
        maxlength: "Licence number cannot exceed 10 characters"
      },
      card_number: {
        required: "Card number is required",
        minlength: "Card number must be at least 6 characters",
        maxlength: "Card number cannot exceed 10 characters"
      },
      expiry_date: {
        required: "Expiry Date is required"
      },
      previous_first_name: {
        required: "First name is required"
      },
      previous_last_name: {
        required: "Last name is required"
      },
      date_of_birth: {
        required: "Date of birth is required"
      }
    }

  });

  let blockBackNavigation = false;
  form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    stepsOrientation: "vertical",

    onStepChanging: function (event, currentIndex, newIndex) {

      if (blockBackNavigation && newIndex < currentIndex) {
        return false;
      }

      if (currentIndex > newIndex) return true;

      form.validate().settings.ignore = ":disabled,:hidden";
      if (!form.valid()) {
        $('.alert-success').hide();
        //$('.error-message').text("Please fill in all required fields before proceeding.");
        //$('.alert-danger').removeClass('fade hide').addClass('show').show();

        // Highlight current step tab
        $(".wizard > .steps li").eq(currentIndex).addClass("error");

        // Scroll to top
        $('html, body').animate({ scrollTop: 0 }, 500);

        return false;
      }

      /*  for (let key in editorInstances) {
         const editor = editorInstances[key];
         const data = editor.getData();
         document.querySelector(`#${key}`).value = data;
       } */

      const currentStep = form.find("section").eq(currentIndex);
      const formData = new FormData();

      currentStep.find("input, select, textarea").each(function () {
        const name = $(this).attr("name");
        const type = $(this).attr('type');
        const value = $(this).val();


        if (name && ((type === 'radio' && $(this).is(':checked')) || (type === 'checkbox' && $(this).is(':checked'))
          || (type !== 'radio' && type !== 'checkbox' && value !== '' && value !== null))) {

          formData.append(name, value);
        }
      });

      // 🔍 (For testing) Log all the fields that will be sent
      console.log('Filtered Form Data:');
      for (const [key, val] of formData.entries()) {
        console.log(key, val);
      }

      // formData.append('job_id', $('#job_id').val());
      //formData.append('job_reference', $('#job_reference').val());
      $('.loading').removeClass('hide');

      let allowNextStep = false;

      $.ajax({
        url: "/ajaxaddfinancedetails",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        async: false,
        success: function (response) {

          // /console.log(ajaxaddfinancedetails);

          //return false;


          $('.loading').addClass('hide');
          let data = JSON.parse(response);
          if (data.status == true) {
            $('.alert-danger').hide();
            // Populate success alert

            $('#loan_id').val(data.loan_id);
            // Show success alert
            $('.alert-success').removeClass('fade hide').addClass('show').show();

            swal("Your personal details added successfully! continue the other forms", {
              icon: "success",
              timer: 3000,
              buttons: false
            });
            blockBackNavigation = false
            allowNextStep = true;
          }
          else {
            $('.alert-success').hide();
            // Populate error alert message
            $('.error-message').text(data.message || "Your personal details not inserted. Please try again later.");
            // Show error alert
            $('.alert-danger').removeClass('fade hide').addClass('show').show();
            $('html, body').animate({
              scrollTop: $('.alert-success').offset().top
            }, 500);
            blockBackNavigation = false
            allowNextStep = false;
          }

          /**/

        }

      });

      //allowNextStep = true;

      return allowNextStep;
    },

    onStepChanged: function (event, currentIndex) {
      $('html, body').animate({ scrollTop: 0 }, 500);
      if (currentIndex === 0) {
        $(".actions a[href='#previous']").hide();
      } else {
        $(".actions a[href='#previous']").show();
      }
    },

    onInit: function (event, currentIndex) {
      if (currentIndex === 0) {
        $(".actions a[href='#previous']").hide();
      }
    },

    onFinishing: function () {
      form.validate().settings.ignore = ":disabled"; // validate all visible fields

      var allRequiredFilled = true;

      // Check each visible required field
      $('.required:visible').each(function () {
        var value = $(this).val();
        if (!value || value.trim() === '') {
          allRequiredFilled = false;
          return false; // break loop if any is empty
        }
      });

      // If not all required fields are filled OR validation fails
      if (!allRequiredFilled || !form.valid()) {

        // Remove old error highlights
        $('.form-group, .mb-3').removeClass('has-error').css('border', '');
        $('.required').css('border', '');

        // Highlight required fields + outer category-block
        $('.required:visible').each(function () {
          if (!$(this).val() || $(this).val().trim() === '') {
            $(this).css('background-color', '#fffafa');
            $(this).css('border', '0.5px solid #EB8C95');
            $(this).closest('.category-block')
              .css('border', '0.5px solid #EB8C95');
          } else {
            $(this).css('border', '');
            $(this).closest('.category-block')
              .css('border', '1px solid #dfdada');
          }
        });

        $('.alert-success').hide();
        $('.error-message').text("Please fill in all required fields before finishing.");
        $('.alert-danger').removeClass('fade hide').addClass('show').show();

        $(".wizard > .steps li").last().addClass("error");

        $(".wizard .actions a[href='#previous']").hide();

        $(".wizard > .steps a").css({
          "pointer-events": "none",
          "cursor": "not-allowed"
        });

        $('html, body').animate({ scrollTop: 0 }, 500);

        form.find(".required:visible").filter(function () {
          return !$(this).val().trim();
        }).first().focus();

        return false;
      }

      return true;
    },

    onFinished: function (currentIndex) {
      /*  for (let key in editorInstances) {
         const editor = editorInstances[key];
         const data = editor.getData();
         document.querySelector(`#${key}`).value = data;
       } */

      const allData = new FormData(form[0]);

      $('#categories-container .category-block').each(function (i, block) {
        $(block).find('input, select, textarea').each(function () {
          const name = $(this).attr("name");
          const value = $(this).val();
          if (name && this.type !== 'file') {
            allData.append(`categories[${i}][${name}]`, value);
          }
        });

        const hiddenFileInput = $(block).find('.hidden-file-input')[0];
        if (hiddenFileInput && hiddenFileInput.files.length > 0) {
          for (let j = 0; j < hiddenFileInput.files.length; j++) {
            allData.append(`categories[${i}][files][]`, hiddenFileInput.files[j]);
          }
        }
      });
      $('.loading').removeClass('hide');

      $.ajax({
        url: "/ajaxaddjob",
        method: "POST",
        data: allData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('.loading').addClass('hide');
          let data = JSON.parse(response);
          if (data.status == true) {
            window.location.href = "/jobs/";
          } else {
            $('.alert-success').hide();
            // Populate error alert message
            $('.error-message').text(data.message || "Service could not be created. Please try again later.");

            // Disable previous button
            $(".actions a[href='#previous']").addClass("disabled").css("pointer-events", "none");

            $(".wizard > .steps li").eq(currentIndex + 1).addClass("error");

            // Show error alert
            $('.alert-danger').removeClass('fade hide').addClass('show').show();
            $('html, body').animate({
              scrollTop: $('.alert-success').offset().top
            }, 500);
            blockBackNavigation = true; // also block in finishing
          }
        },
        error: function (xhr, status, error) {
          $('.loading').addClass('hide');
          $('.alert-success').hide();
          // Populate error alert message
          $('.error-message').text("Service could not be created. Please try again later.");

          // Disable previous button
          $(".actions a[href='#previous']").addClass("disabled").css("pointer-events", "none");

          // Show error alert
          $('.alert-danger').removeClass('fade hide').addClass('show').show();
          $('html, body').animate({
            scrollTop: $('.alert-success').offset().top
          }, 500);
          blockBackNavigation = true;
        }


      });
    }
  });

  /*
  document.getElementById('add-category-btn').addEventListener('click', () => {
  
    const addCategoryBtnStle = document.getElementById('add-category-btn');
    const maxServiceCount = MAX_SERVICE_CREATION_COUNT;
  
    if (categoryCount >= maxServiceCount) {
        swal({
            title: "Limit reached",
            text: "You can only add up to 5 services.",
            icon: "warning",
            button: {
                text: "OK",
                className: "btn btn-danger", // red button
            }
        });
        return; // prevent adding more
    }
  
    const template = document.getElementById('category-template').content.cloneNode(true);
    const block = template.querySelector('.category-block');
    const currentIndex = categoryCount++;
    categoryFilesMap[currentIndex] = [];
    block.querySelector('.category-title').textContent = `Service ${currentIndex + 1}`;
  
  
    // Hide the add button if limit reached
    if (categoryCount >= maxServiceCount) {
        addCategoryBtnStle.style.display = 'none';
    }    
  
    const dropZone = block.querySelector('.dropZone');
    const fileInput = block.querySelector('input[type="file"]');
    const preview = block.querySelector('.filePreview');
    fileInput.classList.add('hidden-file-input');
    fileInput.name = `categories[${currentIndex}][files][]`;
  
    const descriptionTextarea = block.querySelector('.service_description');
    const uniqueEditorId = `service_description_${currentIndex}`;
    descriptionTextarea.id = uniqueEditorId;
  
    ClassicEditor.create(descriptionTextarea)
      .then(editor => {
        editorInstances[uniqueEditorId] = editor;
        editor.editing.view.change(writer => {
          writer.setStyle('height', '150px', editor.editing.view.document.getRoot());
        });
      })
      .catch(error => {
        console.error("CKEditor init error:", error);
      });
  
    const closeBtn = document.createElement('button');
    closeBtn.className = 'category-close-btn';
    closeBtn.innerHTML = '&times;';
    closeBtn.type = 'button';
    closeBtn.onclick = () => {
      const thisBlock = block;
      const thisEditorId = uniqueEditorId;
  
      showSwal('remove-block');
  
      // Wait for SweetAlert's promise to resolve
      swal({
        title: "Are you sure?",
        text: "Remove this block?",
        icon: "warning",
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          },
          confirm: {
            text: "Yes, remove it",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true
          }
        }
      }).then((value) => {
        if (value) {
          thisBlock.remove();
          delete editorInstances[thisEditorId];
           categoryCount--; // decrease count when a block is removed
  
          // Show the add button again if under limit
          if (categoryCount < maxServiceCount) {
              addCategoryBtnStle.style.display = 'inline-block';
          }
  
        }
      });
    };
    block.prepend(closeBtn);
  
    dropZone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropZone.classList.add('dragover');
    });
  
    dropZone.addEventListener('dragleave', () => {
      dropZone.classList.remove('dragover');
    });
  
    dropZone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropZone.classList.remove('dragover');
      mergeFiles(currentIndex, e.dataTransfer.files);
      updateFileInput(fileInput, categoryFilesMap[currentIndex]);
      handleCategoryFiles(fileInput, categoryFilesMap[currentIndex], categoryFilesMap, preview, currentIndex);
    });
  
    fileInput.addEventListener('change', (e) => {
      mergeFiles(currentIndex, e.target.files);
      updateFileInput(fileInput, categoryFilesMap[currentIndex]);
      handleCategoryFiles(fileInput, categoryFilesMap[currentIndex], categoryFilesMap, preview, currentIndex);
    });
  
    dropZone.addEventListener('click', () => {
      fileInput.click();
    });
  
    document.getElementById('categories-block').appendChild(block);
  });
  */
  function mergeFiles(index, newFiles) {
    const existingFiles = categoryFilesMap[index];

    Array.from(newFiles).forEach(file => {
      const exists = existingFiles.some(existing =>
        existing.name === file.name && existing.size === file.size
      );
      if (!exists) existingFiles.push(file);
    });
  }
  function updateFileInput(fileInput, newFiles) {
    const dt = new DataTransfer();

    // Add old files
    Array.from(fileInput.files).forEach(file => dt.items.add(file));

    // Add new files without duplication
    Array.from(newFiles).forEach(file => {
      const exists = Array.from(dt.files).some(existing =>
        existing.name === file.name && existing.size === file.size
      );
      if (!exists) dt.items.add(file);
    });

    fileInput.files = dt.files;
  }

  /* function handleCategoryFiles(files, previewContainer) {
     previewContainer.innerHTML = '';
 
     Array.from(files).forEach(file => {
       const container = document.createElement('div');
       container.classList.add('preview-item');
 
       if (file.type.startsWith('image/')) {
         const img = document.createElement('img');
         img.src = URL.createObjectURL(file);
         container.appendChild(img);
       }else{
          const extension = file.name.split('.').pop().toLowerCase();
         const icon = document.createElement('img');
         icon.className = 'file-icon';
 
         switch (extension) {
           case 'pdf':
             icon.src = assetsdir+'/images/customicons/pdf-icon.png';
             break;
           case 'doc':
           case 'docx':
             icon.src = assetsdir+'/images/customicons/word-icon.png';
             break;
           case 'xls':
           case 'xlsx':
             icon.src = assetsdir+'/images/customicons/excel-icon.png';
             break;
           case 'zip':
           case 'rar':
             icon.src = assetsdir+'/images/customicons/zip-icon.png';
             break;
           case 'ppt':
           case 'pptx':
             icon.src = assetsdir+'/images/customicons/ppt-icon.png';
             break;
             case 'html':
             icon.src = assetsdir+'/images/customicons/html-icon.png';
             break;
           default:
             icon.src = assetsdir+'/images/customicons/default-file-icon.png';
         }
         container.appendChild(icon);
       }
 
       const info = document.createElement('p');
       const fileSizeKB = (file.size / 1024).toFixed(1);
       info.textContent = `📄 ${file.name} (${fileSizeKB} KB)`;
       container.appendChild(info);
 
       const closeBtn = document.createElement('span');
       closeBtn.innerHTML = '&times;';
       closeBtn.classList.add('close-btn');
       closeBtn.onclick = () => {
         container.remove();
         // Optional: manually remove from DataTransfer if needed
       };
       container.appendChild(closeBtn);
 
       previewContainer.appendChild(container);
     });
   } */

})(jQuery);
