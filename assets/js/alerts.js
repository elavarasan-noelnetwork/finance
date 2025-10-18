(function ($) {
  window.showSwal = function (type) {   // 👈 attach to window so it's global
    'use strict';

    if (type === 'delete') {
      swal({
        icon: "error", // #DC3545FF cross icon
        title: "Delete Action Restricted",
        content: {
          element: "span",
          attributes: {
            innerHTML: "This record cannot be deleted due to restrictions.",
            style: "color: #DC3545FF; font-weight: normal;font-size:14px;"
          }
        },
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }
      });

    }
    else if (type === 'upload_img_type_alert') {
      swal({
        icon: "error", // built-in #DC3545FF cross icon
        title: "Invalid File Type",
        content: {
          element: "span",
          attributes: {
            innerHTML: "Only JPG, JPEG, and PNG are allowed.",
            style: "color: #DC3545FF; font-weight: normal;font-size:14px;"
          }
        },
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }
      });

    }
    else if (type === 'upload_img_max_size_alert') {
      swal({
        icon: "error", // built-in #DC3545FF cross icon
        title: "File Too Large",
        content: {
          element: "span",
          attributes: {
            innerHTML: "File too large. Max 5MB allowed.",
            style: "color: #DC3545FF; font-weight: normal;font-size:14px;"
          }
        },
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }
      });
    }
    else if (type === 'upload_img_zero_size_alert') {
      swal({
        icon: "error", // built-in #DC3545FF cross icon
        title: "Invalid File",
        content: {
          element: "span",
          attributes: {
            innerHTML: "The file is empty. Please upload a valid image.",
            style: "color: #DC3545FF; font-weight: normal;font-size:14px;"
          }
        },
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }
      });
    }
    else if (type === 'udrag_drop_error') {
      swal({
        icon: "error", // #DC3545FF cross icon
        title: "No File Detected",
        content: {
          element: "span",
          attributes: {
            innerHTML: "Please drag files from your computer (e.g. desktop or folder), not from the browse dialog.",
            style: "color: #DC3545FF; font-weight: normal;font-size:14px;"
          }
        },
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }
      });
    }
    else if (type === 'max_upload_count') {
      swal({
        icon: "error", // #DC3545FF cross icon
        title: "Limit Exceeded",
        content: {
          element: "span",
          attributes: {
            innerHTML: "Maximum 25 files allowed.",
            style: "color: #DC3545FF; font-weight: normal;font-size:14px;"
          }
        },
        buttons: {
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        }
      });
    }    
    else if (type === 'remove-block') {
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
        if (value && data?.block && data?.uniqueEditorId) {
          data.block.remove();
          delete editorInstances[data.uniqueEditorId];
        }
      });

    }
    else if (type === 'title-and-text') {
      swal({
        title: 'Read the alert!',
        text: 'Click OK to close this alert',
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "btn btn-primary"
        }
      })

    } else if (type === 'success-message') {
      swal({
        title: 'Congratulations!',
        text: 'You entered the correct answer',
        icon: 'success',
        button: {
          text: "Continue",
          value: true,
          visible: true,
          className: "btn btn-primary"
        }
      })

    } else if (type === 'auto-close') {
      swal({
        title: 'Auto close alert!',
        text: 'I will close in 2 seconds.',
        timer: 2000,
        button: false
      }).then(
        function () { },
        // handling the promise rejection
        function (dismiss) {
          if (dismiss === 'timer') {
            console.log('I was closed by the timer')
          }
        }
      )
    } else if (type === 'warning-message-and-cancel') {
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3f51b5',
        cancelButtonColor: '#ff4081',
        confirmButtonText: 'Great ',
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          },
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true
          }
        }
      })

    } else if (type === 'custom-html') {
      swal({
        content: {
          element: "input",
          attributes: {
            placeholder: "Type your password",
            type: "password",
            class: 'form-control'
          },
        },
        button: {
          text: "OK",
          value: true,
          visible: true,
          className: "btn btn-primary"
        }
      })
    }


  }

})(jQuery);