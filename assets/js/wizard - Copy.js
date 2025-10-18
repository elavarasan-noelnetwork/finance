(function($) {
  'use strict';
 
  
  /* Elavarasan */
  
   var form = $("#example-vertical-wizard");

	

var form = $("#example-vertical-wizard");
   form.validate({
      errorPlacement: function errorPlacement(error, element) {
      element.before(error);
      },
      ignore: [],
      rules: {
        job_title: {
          required: true,
          minlength: 5
        }
      },
      messages: {
        job_title: {
          required: "Please enter a job title",
          minlength: "At least 5 characters required"
        }
      },
      submitHandler: function (form) {
        //alert('Form submitted!');
        // form.submit(); or use AJAX
      }
    });

  /* Elavarasan **/

form.children("div").steps({
  headerTag: "h3",
  bodyTag: "section",
  transitionEffect: "slideLeft",
  stepsOrientation: "vertical",

   onStepChanging: function (event, currentIndex, newIndex) {
      if (currentIndex > newIndex) {
        return true; // Allow going back
      }

    // tinymce.triggerSave(); // Sync TinyMCE

      form.validate().settings.ignore = ":disabled,:hidden";
      if (!form.valid()) return false;

      for (let key in editorInstances) {
        const editor = editorInstances[key];
        const data = editor.getData();

        //console.log("KEY:", key);
        //console.log("EDITOR INSTANCE:", editorInstances[key]);
        //console.log("EDITOR DATA:", editorInstances[key].getData());

        document.querySelector(`#${key}`).value = data; // Push data to <textarea>
      }

      // 🔁 Get data only from current step
      const currentStep = form.find("section").eq(currentIndex);
      const formData = new FormData();

      currentStep.find("input, select, textarea").each(function () {
        const name = $(this).attr("name");
        const value = $(this).val();
        if (name) formData.append(name, value);
      });

      var job_id = $('#job_id').val();
      formData.append('job_id', job_id);
      
      var job_reference = $('#job_reference').val();
      formData.append('job_reference', job_reference);


      // Add CSRF if needed (Laravel etc.)
      // formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

      console.log('Form Data');
      console.log(formData);

      $.ajax({
        url: "/ajaxaddjob", // 🔁 Replace with your endpoint
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        
        async: false, // ❗ must be sync to prevent premature step change
        success: function (response) {
          //job-reference
          let data = JSON.parse(response);

          //console.log('data');
          //console.log(data);
          if(data.status==true){

            var jobReference = "Project Reference: "+data.job_reference+" ";
            $('.job-reference').html(jobReference);
            $('#job_reference').val(data.job_reference);
            $('#job_id').val(data.job_id);
            $('.alert-dismissible').addClass('show');
          }
          
          console.log("Your job data saved successfully.");
        },
        error: function (xhr, status, error) {
          alert("Error saving step data: " + error);
        }
      });

      return true; // Allow step to change
    },

  onFinishing: function (event, currentIndex) {
    // 🔁 Sync TinyMCE content with textarea
    //tinymce.triggerSave();

    form.validate().settings.ignore = ":disabled";
    return form.valid();
  },

  onFinished: function (event, currentIndex) {
  for (let key in editorInstances) {
    const editor = editorInstances[key];
    const data = editor.getData();
    document.querySelector(`#${key}`).value = data;
  }

  const allData = new FormData(form[0]);

  // Loop through all category blocks and append their files
  $('#categories-container .category-block').each(function (i, block) {
    $(block).find('input, select, textarea').each(function () {
      const name = $(this).attr("name");
      const value = $(this).val();
      if (name && this.type !== 'file') {
        allData.append(`categories[${i}][${name}]`, value);
      }
    });

    const fileInput = $(block).find('input[type="file"]')[0];
    if (fileInput && fileInput.files.length > 0) {
      Array.from(fileInput.files).forEach(file => {
        allData.append(`categories[${i}][files][]`, file);
      });
    }

    fileInput.name = `categories[${currentIndex}][files][]`;

});

for (let pair of allData.entries()) {
  console.log(pair[0]+ ': ' + pair[1]);
}

  $.ajax({
    url: "/ajaxaddjob",
    method: "POST",
    data: allData,
    processData: false,
    contentType: false,
    success: function (response) {
      alert("Form submitted successfully!");
      //window.location.href = "/jobs";
    },
    error: function (xhr, status, error) {
      alert("Final form submission failed: " + error);
    }
  });
}

});
  

let categoryCount = 0;

document.getElementById('add-category-btn').addEventListener('click', () => {
  const template = document.getElementById('category-template').content.cloneNode(true);
  
  const block = template.querySelector('.category-block');
  const dropZone = block.querySelector('.dropZone');
  const fileInput = block.querySelector('input[type="file"]');
  const preview = block.querySelector('.filePreview');

  const currentIndex = categoryCount++;
  //fileInput.name = `category_files_${currentIndex}[]`;
  fileInput.name = `categories[${currentIndex}][files][]`;
 
  //Add Close button for each category
  const closeBtn = document.createElement('button');
  closeBtn.className = 'category-close-btn';
  closeBtn.innerHTML = '&times;';
  closeBtn.type = 'button';
  closeBtn.onclick = () => {
    if (confirm('Are you sure you want to remove this block?')) {
      block.remove();
    }
  };
  block.prepend(closeBtn); // Add it at top of the block
  


  let filesArray = [];

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
    handleCategoryFiles(e.dataTransfer.files, filesArray, preview);
  });

  fileInput.addEventListener('change', () => {
    handleCategoryFiles(fileInput.files, filesArray, preview);
  });

  document.getElementById('categories-block').appendChild(block);
});

function handleCategoryFiles(files, fileList, previewContainer) {
  Array.from(files).forEach(file => {
    const isDuplicate = fileList.some(f => f.name === file.name && f.size === file.size);
    if (isDuplicate) return;

    fileList.push(file);

    const container = document.createElement('div');
    container.classList.add('preview-item');

    if (file.type.startsWith('image/')) {
      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      container.appendChild(img);
    }

    const info = document.createElement('p');
    info.textContent = file.name;
    container.appendChild(info);

    const closeBtn = document.createElement('span');
    closeBtn.innerHTML = '&times;';
    closeBtn.classList.add('close-btn');
    closeBtn.onclick = () => {
      container.remove();
      const index = fileList.findIndex(f => f.name === file.name && f.size === file.size);
      if (index !== -1) fileList.splice(index, 1);
    };
    container.appendChild(closeBtn);

    previewContainer.appendChild(container);
  });
}

  
})(jQuery);