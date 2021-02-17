$(document).ready(function(){

  $.validator.addMethod("customemail",function (value, element) {
    return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
  });

  $.validator.addMethod('decimal', function (value, element) {
    return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
  }, "");

  $.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
  }, "Please enter letters");   
});


//login form validation
$(document).ready(function(){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var link = $('body').data('baseurl');

  /* For login-form */

  $("form[name='login-form']").validate({

    rules: {

      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 6,
        maxlength: 20
      }
    },

    messages: {

      email: {
        required: "Please enter an email",
        email: "Please enter valid email",
      },
      password: {
        required: "Please enter password",
        minlength: "Minimum password length 6",
        maxlength: "Maximim password length 20",
      },
    },

    submitHandler: function(form) {
      form.submit();
    }
  });  

  /* For forgot-password */

 /* $("form[name='forgot-password']").validate({

    rules: {

      email: {
        required: true,
        email: true,
      }
    },

    messages: {

      email: {
        required: lang.ENTER_AN_EMAIL,
        email: lang.ENTER_VALID_EMAIL,
      },
    },

    submitHandler: function(form) {
      form.submit();
    }
  });  */


  /* For reset-forgot-password */

  /*$("form[name='reset-forgot-password']").validate({

    rules: {

      password: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      confirm_password: {
        required: true,
        minlength: 6,
        maxlength: 20,
        equalTo: "#password"
      }
    },

    messages: {

      password: {
        required: lang.PLEASE_ENTER_PASSWORD,
        minlength: lang.PASSWORD_MIN_LENGTH,
        maxlength: lang.PASSWORD_MAX_LENGTH,
      },
      confirm_password: {
        required: lang.PLEASE_ENTER_CONFIRM_PASSWORD,
        minlength: lang.CONFIRM_PASSWORD_MIN_LENGTH,
        maxlength: lang.CONFIRM_PASSWORD_MAX_LENGTH,
        equalTo: lang.CONFIRM_PASSWORD_SAME_AS_PASSWORD,
      },
    },

    submitHandler: function(form) {
      form.submit();
    }
  });  */

/************  For Admin Form Validation  ************/
  /* For add-admin */
  $("form[name='add-users']").validate({
    rules: {
      name: {
        required: true,
      },
      area_id: {
        required: true,
      },
      email: {
        required: true,
        email: true,
        maxlength: 50,
        remote: {
          type: 'post',
          url: SITEURL + '/admin/check-email',
          data: {
            'email': function () {
              return $('#email').val()
            },
          'tbl': 'users',
          'id': $('#id').val(),
          },
          dataType: 'json'
        }
      },
      mobile_number: {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 13,
        remote: {
          type: 'post',
          url: SITEURL + '/admin/check-mobile',
          data: {
            'mobile_number': function () {
              return $('#mobile_number').val()
            },
            'tbl': 'users',
            'id': $('#id').val(),
          },
          dataType: 'json'
        }
      },
      birth_date: {
        required: true,
      },
      password: {
        required: true,
        maxlength: 25,
        minlength: 6
      },
      confirm_password: {
        required: true,
        minlength: 6,
        maxlength: 25,
        equalTo: "#password"
      },
      country_id: {
        required: true,
      },
      role_type: {
        required: true,
      },
      status: {
        required: true,
      },
    },

    messages: {
      name: {
        required: "Please enter name",
      },
      area_id: {
        required: "Please select area",
      },
      email: {
        required: "Please enter an email",
        email: "Please enter valid email",
        maxlength: "Email should be greater than or equal to 50 character",
        remote: "Oops! Looks like the email already exists",
      },
      mobile_number: {
        required: "Please enter mobile number",
        number: "Mobile number accepts only numeric value",
        minlength: "Mobile number should be atleast 8 character",
        maxlength: "Mobile number should be greater than or equal to 13 character",
        remote: "Oops! Looks like the mobile number already exists.",
      },
      birth_date: {
        required: "Please select date of birth",
      },
      password: {
        required: "Please enter password",
        minlength: "Password should be atleast 6 character",
        maxlength: "Password should be greater than or equal to 25 character",
      },
      confirm_password: {
        required: "Please enter confirm password",
        minlength: "Confirm password should be atleast 6 character",
        maxlength: "Confirm password should be greater than or equal to 25 character",
        equalTo: "Confirm password and confirm password do not match.",
      },
      country_id: {
        required: "Please select country",
      },
      role_type: {
        required: "Please select role type",
      },
      status: {
        required: "Please select status",
      },
    },

    submitHandler: function(form) {
      form.submit();
    }
  });

  /* For edit-users */
  $("form[name='edit-users']").validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
        maxlength: 50,
        remote: {
          type: 'post',
          url: SITEURL + '/admin/check-email',
          data: {
            'email': function () {
              return $('#email').val()
            },
          'tbl': 'users',
          'id': $('#id').val(),
          },
          dataType: 'json'
        }
      },
      mobile_number: {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 13,
        remote: {
          type: 'post',
          url: SITEURL + '/admin/check-mobile',
          data: {
            'mobile_number': function () {
              return $('#mobile_number').val()
            },
            'tbl': 'users',
            'id': $('#id').val(),
          },
          dataType: 'json'
        }
      },
      birth_date: {
        required: true,
      },
      area_id: {
        required: true,
      },
      role_type: {
        required: true,
      },
      status: {
        required: true,
      },
    },

    messages: {
      name: {
        required: "Please enter name",
      },
      email: {
        required: "Please enter an email",
        email: "Please enter valid email",
        maxlength: "Email should be greater than or equal to 50 character",
        remote: "Oops! Looks like the email already exists",
      },
      mobile_number: {
        required: "Please enter mobile number",
        number: "Mobile number accepts only numeric value",
        minlength: "Mobile number should be atleast 8 character",
        maxlength: "Mobile number should be greater than or equal to 13 character",
        remote: "Oops! Looks like the mobile number already exists.",
      },
      birth_date: {
        required: "Please select date of birth",
      },
      area: {
        required: "Please select area",
      },
      role_type: {
        required: "Please select role type",
      },
      status: {
        required: "Please select status",
      },
    },

    submitHandler: function(form) {
      form.submit();
    }
  });   

});