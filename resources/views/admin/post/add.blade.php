@extends('admin.layouts.master')
@section('content')
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <!-- @if(auth('web')->user()->role_id==1) -->
                    <form role="form" name="add-users" id="add-users" action="{{ url('admin/users/store') }}" method="post" enctype="multipart/form-data">
                    <!-- @endif  -->
                    
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
        });
    </script>

@endsection