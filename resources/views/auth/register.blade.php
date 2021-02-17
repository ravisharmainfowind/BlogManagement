@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" required autocomplete="mobile_number" autofocus>

                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="from-group col-md-4">
                                <p>Please select Role Type:</p>
                                <input type="radio" id="editor" name="role_type" value="2">
                                <label for="editor">Editor</label><br>
                                <input type="radio" id="user_type" name="role_type" value="3">
                                <label for="user">User</label><br>
                                
                            </div>
                            @if ($errors->has('role_type'))
                                <p class="error">
                                    <i class="fa fa-times-circle-o"></i>  {{ $errors->first('role_type') }}
                                </p>
                            @endif
                        </div>
                                 
                            <div class="form-group row">   
                                <div class="form-group col-md-4">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture">
                                  
                                  @if ($errors->has('profile_picture'))
                                  <p class="error help-block">{{ $errors->first('profile_picture') }}</p>
                                  @endif
                                </div>
                            </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">Register Form</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                   
                    <form role="form" name="add-users" id="add-users" action="{{ url('register') }}" method="post" enctype="multipart/form-data">
                    
                    
                        {{ csrf_field() }}
                        <div class="box-body col-md-12">
                            <input type="hidden" name="status" id="status" value="0">
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ old('name') }}"></span>
                                    @if ($errors->has('name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('name') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="email">E-Mail<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter E-Mail" value="{{ old('email') }}"></span>
                                    @if ($errors->has('email'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('email') }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="mobile_number">Mobile Number<span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control" id="mobile_number"  placeholder="Enter Mobile Number" value="{{ old('mobile_number') }}">
                                    @if ($errors->has('mobile_number'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('mobile_number') }}
                                    </p>
                                    @endif
                                </div>

                                
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value=""  autocomplete="off"><span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    @if ($errors->has('password'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('password') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="exampleInputEmail1">Confirm Password<span class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Enter Confirm Password" value=""   autocomplete="off"><span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-cpassword"></span>
                                    @if ($errors->has('confirm_password'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('confirm_password') }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="from-group col-md-6">
                                <p>Please select Role Type:</p>
                                    <input type="radio" id="editor" name="role_type" value="2">
                                    <label for="editor">Editor</label><br>
                                    <input type="radio" id="user_type" name="role_type" value="3">
                                    <label for="user">User</label><br>
                                   
                                </div>
                                @if ($errors->has('role_type'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('role_type') }}
                                    </p>
                                    @endif
                                <div class="form-group col-md-6">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture">
                                  
                                  @if ($errors->has('profile_picture'))
                                  <p class="error help-block">{{ $errors->first('profile_picture') }}</p>
                                  @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">                       
                                    <a href="{{ url('admin/users') }}" class="btn btn-danger">Cancel</a>
                                    <button id="btn-users" type="submit" class="btn btn-primary">Submit</button>
                                   
                                </div>
                            </div>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</section>  
@endsection
@section('js')
        
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhX4GLdqtMBWhIAWcFKPVZMVjXrV_2hDQ&libraries=places"></script>
    <script src="{{ asset('public/Admin/my-js/bootstrap-datetimepicker.min.js') }}"></script>

    <script>

        $(document).ready(function () {   
            $(".toggle-password").click(function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $(".toggle-cpassword").click(function () {

                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $('#birth_date').datepicker({ 
                dateFormat: 'yy-mm-dd',
            });

            $("form[name='add-users']").validate({
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
      
      role_type: {
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
      
      role_type: {
        required: "Please select role type",
      },
      
    },

    submitHandler: function(form) {
      form.submit();
     }
    });
  });
</script>

@endsection