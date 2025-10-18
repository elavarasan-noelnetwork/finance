function getFileIconSrc(file,filename) {


  const extension = filename.split('.').pop().toLowerCase();
  const basePath = assetsdir+'/images/customicons/';

  switch (extension) {
    case 'pdf':
      return basePath + 'pdf-icon.png';
    case 'doc':
    case 'docx':
      return basePath + 'word-icon.png';
    case 'xls':
    case 'xlsx':
      return basePath + 'excel-icon.png';
    case 'zip':
    case 'rar':
      return basePath + 'zip-icon.png';
    case 'ppt':
    case 'pptx':
      return basePath + 'ppt-icon.png';
    case 'html':
      return basePath + 'html-icon.png';

    case 'dwg':
      return basePath + 'dwg-icon.png';

    case 'rfa':
      return basePath + 'rfa-icon.png';
    
    case 'skp':
      return basePath + 'skp-icon.png';
    
    case 'stl':
      return basePath + 'stl-icon.png';

    default:
      return basePath + 'default-file-icon.png';
  }
}
function mergeFiles(index, newFiles,savedFiles = []) {

  const existingFiles = categoryFilesMap[index];

  console.log("existingFiless:", existingFiles);
  console.log("savedFiless:", savedFiles);


  Array.from(newFiles).forEach(file => {              //Array.from(newFiles) - Converts the FileList into a real JavaScript Array
    const fileSizeMB = file.size / (1024 * 1024);


    // Reject empty files
    if (file.size === 0) {
      swal({
        title: "Invalid File",
        content: {
          element: "span",
          attributes: {
            innerHTML: `<b>${file.name}</b> is empty and cannot be uploaded.`
          }
        },
        icon: "warning",
        button: {
          text: "OK",
          className: "btn btn-danger",
        }
      });
      return;
    }

    // Reject files larger than allowed size
    if (fileSizeMB > MAX_FILE_SIZE_MB) {
      swal({
        title: "File Size Exceeded",
        content: {
          element: "span",
          attributes: {
            innerHTML: `<b>${file.name}</b> exceeds the <b>${MAX_FILE_SIZE_MB} MB</b> limit.`
          }
        },
        icon: "warning",
        button: {
          text: "OK",
          className: "btn btn-danger",
        }
      });      
      return;
    }

    const alreadyExists = existingFiles.some(existing =>
      existing.name.toLowerCase() === file.name.toLowerCase() && existing.size === file.size
    ) || savedFiles.some(saved =>
      saved.joa_attachment_original.toLowerCase() === file.name.toLowerCase() && parseInt(saved.joa_filesize || 0) === file.size
    );

    if (alreadyExists) {
      swal({
        title: "Duplicate File",
        content: {
          element: "span",
          attributes: {
            innerHTML: `<b>${file.name}</b> is already added.`
          }
        },
        icon: "warning",
        button: {
          text: "OK",
          className: "btn btn-danger",
        }
      });
      return;
    }

    // ✅ Passed all checks → add file
    existingFiles.push(file);

  });
}


function enforceLimits(index) {
  const files = categoryFilesMap[index];

  if (files.length > MAX_FILE_COUNT) {
    // Separate valid and extra files
    const validFiles = files.slice(0, MAX_FILE_COUNT);
    const skippedFiles = files.slice(MAX_FILE_COUNT);

    // Replace with only valid files
    categoryFilesMap[index] = validFiles;

    // Show warning with skipped filenames
    const skippedList = skippedFiles.map(f => f.name).join("<br>");

    swal({
      title: "File Limit Exceeded",
      content: {
        element: "span",
        attributes: {
          innerHTML: `
            You can upload a maximum of <b>${MAX_FILE_COUNT}</b> files in one service.<br><br>
            These files were skipped:<br>
            <span style="color:red;">${skippedList}</span>
          `,
        }
      },
      icon: "warning",
      button: {
        text: "OK",
        className: "btn btn-danger",
      }
    });
  }
}