/* created by : Devendra dode*/
//web
  function successToast(message) {
    $.toast({
      heading: 'Success',
      text: message,
      position: 'top-right',
      loaderBg:'#ea65a2',
      icon: 'success',
      hideAfter: 3000, 
      stack: 6
    });
  }

  function errorToast(message) {
    $.toast({
      heading: 'Error',
      text: message,
      position: 'top-right',
      loaderBg:'#ea65a2',
      icon: 'error',
      hideAfter: 3000, 
      stack: 6
    });
  } 


function readURL(input, id) {
    id = id || '#blah';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

  $("form[name='addEditProperty']").validate({
    
    rules: {
      name: {
        required: true,  
        maxlength: 100,
      },
      image: {
        required: function (element) {
        return $("#old_path").val() == '';
        },
         accept: "image/jpeg, image/jpeg , png",
     },
     
    },
    // Specify validation error messages
    messages: {
       name: {
        required: "Please enter name",
        maxlength: "The name maxlength should be 100 characters long.",
       
      },
      image: {
        required: "Please select image",
      },     
    },

    highlight: function(element) {
        $(element).removeClass("error");
    },

    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
        form.submit();
    }
  });

$(function() {

   //login form
   $("form[name='loginform']").validate({

	    rules: {

	      email: {
	        required: true,
	        email: true
	      },
	      password: {
	        required: true,
	        minlength: 6
	      }
	    },

	    messages: {
	   
	      password: {
	        required: "Please enter password",
	        minlength: "Your password must be at least 6 characters long"
	      },
	      email: {
	        required: "Please enter email",
	        email: "Please enter a valid email address"
	      },
	    },
   });
   
   //register user
  if ($("#register").length > 0) {
     $("#register").validate({
    
     rules: {
      first_name: {
        required: true,
        maxlength: 30
      },     

      last_name: {
        required: true,
        maxlength: 30
      },

       mobile_number: {
            required: true,
            digits:true,
            minlength: 6,
            maxlength:12,
            remote: {
                type: 'POST',
                url: SITEURL + '/check-mobile',
                data: {
                    'mobile': function () {
                        return $('#mobile_number').val()
                    },
                    'tbl': 'users',
                    'id': $('#userId').val(),
                },
                dataType: 'json'
            }
        },
        email: {
        	    required: true,
                maxlength: 50,
                email: true,
               // customemail: true,
                remote: {
                    type: 'POST',
                    url: SITEURL + '/check-email',
                    data: {
                        'email': function () {
                            return $('#email').val()
                        },
                        'tbl': 'users',
                        'id': $('#userId').val(),
                    },
                    dataType: 'json'
                }
            }, 
      password: {
        required: true,
        minlength: 6,
      },  
     confirm_password: {
        required: true,
        maxlength: 20,
        minlength: 6,
        equalTo: "#password"
      },   
      image: {
        required: function (element) {
        return $("#old_path").val() == '';
        },
         accept: "image/jpeg, image/jpeg , png",
     },

     },

     messages: {
      
      first_name: {
        required: "Please enter first name",
        maxlength: "Your first name maxlength should be 30 characters long."
      },      
      last_name: {
        required: "Please enter last name",
        maxlength: "Your last name maxlength should be 30 characters long."
      },
      mobile_number: {
        required: "Please enter mobile number",
        minlength: "The mobile number should be 10 digits",
        digits: "Please enter only numbers",
        maxlength: "The mobile number should be 12 digits",
        remote: "Oops! Looks like the mobile number already exists"
      },
      email: {
          email: "Please enter valid email",
          maxlength: "The email name should less than or equal to 50 characters",
          remote: "Oops! Looks like the email already exists"
        },
       password: {
        required: "Please enter password",
        minlength: "The password should be minimum 6 character long "
      },
     confirm_password: {
          required: "Please enter confirm password",
          equalTo:   "Password and confirm password do not match",
          minlength: "Confirm Password minimum length should be 6 character",
          maxlength: "Confirm Password maximun length should be 20 character",
         
      },
      image: {
        required: "Please select profile picture"
      },
     },
    
    });
  }
   //login form
   $("form[name='fgpassword']").validate({

	    rules: {

	      email: {
	        required: true,
	        email: true
	      }
	    },

	    messages: {
	      email: {
	        required: "Please enter email",
	        email: "Please enter a valid email address"
	      },
	    },
   });
   
   //rest forget password password
  $("#resetPassForm").validate({
      rules: {
          otp:{
              required : true,
               minlength: 4,
               maxlength: 8,
           },
          password: {
              required: true,
              maxlength: 20,
              minlength: 6
          },
          confirm_password: {
              required: true,
              minlength: 6,
              maxlength: 20,
              equalTo: "#password"
          }
      },
      messages: {

        otp: {
              required: "We have sent you an OTP on the registered email id.Please enter it here to verify your account!.",
              minlength: "OTP minimum length should be 4 character",
              maxlength: "OTP maximun length should be 8 character.",
          },

          password: {
              required: "Please enter new password field.",
              maxlength: "Password maximun length should be 20 character.",
              minlength: "Password minimum length should be 6 character",
          },

          confirm_password: {
              required: "Confirm password should be equal to new password.",
              equalTo:   "Password and confirm password do not match.",
              minlength: "Confirm Password minimum length should be 6 character",
              maxlength: "Confirm Password maximun length should be 20 character.",
             
          },

      },
   //          
  });


//change password
$("#update-password").validate({
      rules: {
        current_password:{
            required : true,
            maxlength : 20,
            minlength : 6
         },
        new_password: {
            required: true,
            maxlength: 20,
            minlength: 6
        },
        confirm_password: {
            required: true,
            maxlength: 20,
            minlength: 6,
            equalTo: "#new_password"
        },
      },
      messages: {

        current_password: {
              required: "Please enter current password",
              maxlength: "Current password maximum length should be 20 character",
              minlength: "Confirm password minimum length should be 6 character"
          },

          new_password: {
            required: "Please enter new password",
            maxlength: "New password maximum length should be 20 character",
            minlength: "New password minimum length should be 6 character"
          },

          confirm_password: {
            required: "Please enter confirm password",
            equalTo:   "New password and confirm password do not match",
            minlength: "Confirm password minimum length should be 6 character",
            maxlength: "Confirm password maximun length should be 20 character",         
         },
     },   
 }); 

   //register user
  if ($("#update-profile").length > 0) {
     $("#update-profile").validate({
    
     rules: {
      first_name: {
        required: true,
        maxlength: 30
      },     

      last_name: {
        required: true,
        maxlength: 30
      },

       mobile_number: {
            required: true,
            digits:true,
            minlength: 6,
            maxlength:12,
            remote: {
                type: 'POST',
                url: SITEURL + '/check-mobile',
                data: {
                    'mobile': function () {
                        return $('#mobile_number').val()
                    },
                    'tbl': 'users',
                    'id': $('#userId').val(),
                },
                dataType: 'json'
            }
        }, 
        image: {
          required: function (element) {
          return $("#old_path").val() == '';
          },
           accept: "image/jpeg, image/jpeg , png",
       },
     },

     messages: {
      
      first_name: {
        required: "Please enter first name",
        maxlength: "Your first name maxlength should be 30 characters long."
      },      
      last_name: {
        required: "Please enter last name",
        maxlength: "Your last name maxlength should be 30 characters long."
      },
      mobile_number: {
        required: "Please enter mobile number",
        minlength: "The mobile number should be 10 digits",
        digits: "Please enter only numbers",
        maxlength: "The mobile number should be 12 digits",
        remote: "Oops! Looks like the mobile number already exists"
      },
      image: { required: "Please select profile picture"},
     },
    
    });
  }

   // globel ajax
   $("form").submit(function(e){

	    e.preventDefault();
        var fname = this.getAttribute('name');
        var fid = this.getAttribute('id');

        $('button[name="submit"]').attr("disabled", true);
        $('button[name="submit"]').text('Loading...');
        $('span[name="btn-loader"]').removeClass('d-none');

    		$.ajax({
    		    url: this.getAttribute('action'),
    		    method: this.getAttribute('method'),             
    	      data: new FormData(this),
    		    dataType: 'JSON',
    		    contentType: false,
    		    cache: false,             
    	      processData: false,  
    		    success: function(resp) {
    		    	
                   if(resp.success == true) {
                   	 if(resp.data.redirect != '') {
                        if(resp.data.redirect == '/'){
                          window.location.assign(SITEURL+resp.data.redirect)   
                        }else {
                          window.location.assign(SITEURL+"/"+resp.data.redirect) 
                        }
                   	 }
                     if(fname == 'fgpassword') {
                     	 window.location.assign(SITEURL+"/reset-password")      
                     }
                     successToast(resp.message);
                   } else if(resp.success == false) {
                      errorToast(resp.message);
                   } else {
                      errorToast(resp.message);
                   }
                $('button[name="submit"]').attr("disabled", false);
                $('button[name="submit"]').text('Submit');
                $('span[name="btn-loader"]').addClass('d-none');
    		    },
    		   error: function(resp) {

                if(resp.status == 422){   

                  Object.keys(resp.responseJSON.message).forEach(field_name => {

                      $(`#`+fid+`[name=${field_name}]`).addClass('is-invalid').siblings(`.invalid-feedback`).html(

                          `<i class="fa fa-times-circle-o"></i> ${resp.responseJSON.message[field_name]}`

                          );

                  });
                }
                $('button[name="submit"]').attr("disabled", false);
                $('button[name="submit"]').text('Submit');
                $('span[name="btn-loader"]').addClass('d-none');
              }
    		});

   });

});	

/*file upload js*/
/*function ekUpload(){
  function Init() {

    console.log("Upload Initialised");

    var fileSelect    = document.getElementById('file-upload'),
        fileDrag      = document.getElementById('file-drag'),
        submitButton  = document.getElementById('submit-button');

    fileSelect.addEventListener('change', fileSelectHandler, false);

    // Is XHR2 available?
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {
      // File Drop
      fileDrag.addEventListener('dragover', fileDragHover, false);
      fileDrag.addEventListener('dragleave', fileDragHover, false);
      fileDrag.addEventListener('drop', fileSelectHandler, false);
    }
  }

  function fileDragHover(e) {
    var fileDrag = document.getElementById('file-drag');

    e.stopPropagation();
    e.preventDefault();

    fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
  }

  function fileSelectHandler(e) {
    // Fetch FileList object
    var files = e.target.files || e.dataTransfer.files;

    // Cancel event and hover styling
    fileDragHover(e);

    // Process all File objects
    for (var i = 0, f; f = files[i]; i++) {
      parseFile(f);
      uploadFile(f);
    }
  }

  // Output
  function output(msg) {
    // Response
    var m = document.getElementById('messages');
    m.innerHTML = msg;
  }

  function parseFile(file) {

    console.log(file.name);
    output(
      '<strong>' + encodeURI(file.name) + '</strong>'
    );
    
    // var fileType = file.type;
    // console.log(fileType);
    var imageName = file.name;

    var isGood = (/\.(?=gif|jpg|png|jpeg)/gi).test(imageName);
    if (isGood) {
      document.getElementById('start').classList.add("hidden");
      document.getElementById('response').classList.remove("hidden");
      document.getElementById('notimage').classList.add("hidden");
      // Thumbnail Preview
      document.getElementById('file-image').classList.remove("hidden");
      document.getElementById('file-image').src = URL.createObjectURL(file);
    }
    else {
      document.getElementById('file-image').classList.add("hidden");
      document.getElementById('notimage').classList.remove("hidden");
      document.getElementById('start').classList.remove("hidden");
      document.getElementById('response').classList.add("hidden");
      document.getElementById("file-upload-form").reset();
    }
  }

  function setProgressMaxValue(e) {
    var pBar = document.getElementById('file-progress');

    if (e.lengthComputable) {
      pBar.max = e.total;
    }
  }

  function updateFileProgress(e) {
    var pBar = document.getElementById('file-progress');

    if (e.lengthComputable) {
      pBar.value = e.loaded;
    }
  }

  function uploadFile(file) {

    var xhr = new XMLHttpRequest(),
      fileInput = document.getElementById('class-roster-file'),
      pBar = document.getElementById('file-progress'),
      fileSizeLimit = 1024; // In MB
    if (xhr.upload) {
      // Check if file is less than x MB
      if (file.size <= fileSizeLimit * 1024 * 1024) {
        // Progress bar
        pBar.style.display = 'inline';
        xhr.upload.addEventListener('loadstart', setProgressMaxValue, false);
        xhr.upload.addEventListener('progress', updateFileProgress, false);

        // File received / failed
        xhr.onreadystatechange = function(e) {
          if (xhr.readyState == 4) {
            // Everything is good!

            // progress.className = (xhr.status == 200 ? "success" : "failure");
            // document.location.reload(true);
          }
        };

        // Start upload
        xhr.open('POST', document.getElementById('file-upload-form').action, true);
        xhr.setRequestHeader('X-File-Name', file.name);
        xhr.setRequestHeader('X-File-Size', file.size);
        xhr.setRequestHeader('Content-Type', 'multipart/form-data');
        xhr.send(file);
      } else {
        output('Please upload a smaller file (< ' + fileSizeLimit + ' MB).');
      }
    }
  }

  // Check for the various File API support.
  if (window.File && window.FileList && window.FileReader) {
    Init();
  } else {
    document.getElementById('file-drag').style.display = 'none';
  }
}
ekUpload();*/
/*end file upload*/