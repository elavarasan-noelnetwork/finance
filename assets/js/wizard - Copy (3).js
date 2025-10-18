(function ($) {
  'use strict';

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
    }
  });

  form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    stepsOrientation: "vertical",

    onStepChanging: function (event, currentIndex, newIndex) {
      if (currentIndex > newIndex) return true;

      form.validate().settings.ignore = ":disabled,:hidden";
      if (!form.valid()) return false;

      for (let key in editorInstances) {
        const editor = editorInstances[key];
        const data = editor.getData();
        document.querySelector(`#${key}`).value = data;
      }

      const currentStep = form.find("section").eq(currentIndex);
      const formData = new FormData();

      currentStep.find("input, select, textarea").each(function () {
        const name = $(this).attr("name");
        const value = $(this).val();
        if (name) formData.append(name, value);
      });

      formData.append('job_id', $('#job_id').val());
      formData.append('job_reference', $('#job_reference').val());

      $.ajax({
        url: "/ajaxaddjob",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        async: false,
        success: function (response) {
          let data = JSON.parse(response);
          if (data.status == true) {
            $('.job-reference').html("Project Reference: " + data.job_reference);
            $('#job_reference').val(data.job_reference);
            $('#job_id').val(data.job_id);
            $('.alert-dismissible').addClass('show');
          }
        },
        error: function (xhr, status, error) {
          alert("Error saving step data: " + error);
        }
      });

      return true;
    },

    onFinishing: function () {
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },

    onFinished: function () {
      for (let key in editorInstances) {
        const editor = editorInstances[key];
        const data = editor.getData();
        document.querySelector(`#${key}`).value = data;
      }

      const allData = new FormData(form[0]);

      $('#categories-container .category-block').each(function (i, block) {
        $(block).find('input, select, textarea').each(function () {
          const name = $(this).attr("name");
          const value = $(this).val();
          if (name && this.type !== 'file') {
            allData.append(`categories[${i}][${name}]`, value);
          }
        });

       //const fileInput = $(block).find('input[type="file"]')[0];
  
        /* const fileInput = $(block).find('input[type="file"]')[0];
        if (fileInput && fileInput.files.length > 0) {
          Array.from(fileInput.files).forEach(file => {
            allData.append(`categories[${i}][files][]`, file);
          });
        } */

        const fileInput = $(block).find('input[type="file"]')[0];
        if (fileInput && fileInput.files.length > 0) {
          for (let j = 0; j < fileInput.files.length; j++) {
            allData.append(`categories[${i}][files][]`, fileInput.files[j]);
          }
        }

      });

       

      $.ajax({
        url: "/ajaxaddjob",
        method: "POST",
        data: allData,
        processData: false,
        contentType: false,
        success: function () {
          alert("Form submitted successfully!");
        },
        error: function (xhr, status, error) {
          alert("Final form submission failed: " + error);
        }
      });
    }
  });

  // Add category block
  let categoryCount = 1;

  const firstBlock = document.querySelector('#categories-block .category-block');
if (firstBlock) {
  const fileInput = firstBlock.querySelector('input[type="file"]');
  const dropZone = firstBlock.querySelector('.dropZone');
  const preview = firstBlock.querySelector('.filePreview');

  // Set proper input name
  fileInput.name = `categories[0][files][]`;

  // ✅ Hook up drag & drop
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

    const dt = new DataTransfer();
    Array.from(e.dataTransfer.files).forEach(file => dt.items.add(file));
    fileInput.files = dt.files; // ✅ push into input for FormData

    handleCategoryFiles(fileInput.files, preview);
  });

  // ✅ Hook up manual selection
  fileInput.addEventListener('change', () => {
    handleCategoryFiles(fileInput.files, preview);
  });
}




  document.getElementById('add-category-btn').addEventListener('click', () => {
    const template = document.getElementById('category-template').content.cloneNode(true);

    const block = template.querySelector('.category-block');
    const dropZone = block.querySelector('.dropZone');
    const fileInput = block.querySelector('input[type="file"]');
    const preview = block.querySelector('.filePreview');

    const currentIndex = categoryCount++;
    fileInput.name = `categories[${currentIndex}][files][]`;

    // Add close button
    const closeBtn = document.createElement('button');
    closeBtn.className = 'category-close-btn';
    closeBtn.innerHTML = '&times;';
    closeBtn.type = 'button';
    closeBtn.onclick = () => {
      if (confirm('Remove this block?')) block.remove();
    };
    block.prepend(closeBtn);

    // Drag and Drop
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

      const dt = new DataTransfer();
      Array.from(e.dataTransfer.files).forEach(file => dt.items.add(file));
      fileInput.files = dt.files;

      handleCategoryFiles(fileInput.files, preview);
    });

    fileInput.addEventListener('change', () => {
      handleCategoryFiles(fileInput.files, preview);
    });

    document.getElementById('categories-block').appendChild(block);
  });

  function handleCategoryFiles(files, previewContainer) {
    previewContainer.innerHTML = '';

    Array.from(files).forEach(file => {
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

      previewContainer.appendChild(container); 
    });
  }

  function setupCategoryBlock(block, index) {
    const dropZone = block.querySelector('.dropZone');
    const fileInput = block.querySelector('input[type="file"]');
    const preview = block.querySelector('.filePreview');

    // ✅ Set correct input name
    fileInput.name = `categories[${index}][files][]`;

    // ✅ Drag-and-drop behavior
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

      const dt = new DataTransfer();
      Array.from(e.dataTransfer.files).forEach(file => dt.items.add(file));
      fileInput.files = dt.files;

      handleCategoryFiles(fileInput.files, preview);
    });

    // ✅ File input change
    fileInput.addEventListener('change', () => {
      handleCategoryFiles(fileInput.files, preview);
    });

    // ✅ Optional: Add a close button for dynamic blocks
    if (!block.querySelector('.category-close-btn')) {
      const closeBtn = document.createElement('button');
      closeBtn.className = 'category-close-btn';
      closeBtn.innerHTML = '&times;';
      closeBtn.type = 'button';
      closeBtn.onclick = () => {
        if (confirm('Remove this block?')) block.remove();
      };
      block.prepend(closeBtn);
    }
  }

})(jQuery);