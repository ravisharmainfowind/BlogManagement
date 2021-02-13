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
                    <form role="form" name="edit-users" id="edit-users" action="{{ url('admin/users/update') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ (!empty($user_info->id))?($user_info->id):('') }}">
                        <div class="box-body col-md-12">
                            <div class="row">
                                <!-- <div class="form-group col-md-6 ">
                                    <label for="country_id">{{ __('message.country') }}<span class="text-danger">*</span></label>
                                    <select name="country_id" type="text" id="country_id" class="form-control box-size select2">
                                        <option value="">{{ __('message.select_country') }}</option>
                                        @if(!empty($country_info))
                                            @foreach($country_info as $c)
                                                <option value="{{ $c->id }}" {{ (!empty($user_info->country_id))?(($user_info->country_id == $c->id)?('selected'):('')):('') }} >{{$c->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('country_id'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('country_id') }}
                                    </p>
                                    @endif
                                </div> -->          
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name', (!empty($user_info->name)) ? ($user_info->name) : (''))}}"></span>
                                    @if ($errors->has('name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('name') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="email">E-Mail<span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter E-Mail" value="{{old('email', (!empty($user_info->email)) ? ($user_info->email) : (''))}}"></span>
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
                                    <input type="text" name="mobile_number" class="form-control" id="mobile_number" maxlength="10" placeholder="Enter Mobile Number" value="{{old('mobile_number', (!empty($user_info->mobile_number)) ? ($user_info->mobile_number) : (''))}}"></span>
                                    @if ($errors->has('mobile_number'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('mobile_number') }}
                                    </p>
                                    @endif
                                </div>
                                <!-- <div class="form-group col-md-6 ">
                                    <label for="birth_date">Date of birth</label>
                                    <input type="text" name="birth_date" class="form-control" id="birth_date" placeholder="Enter date of birth" value="{{old('birth_date', (!empty($user_info->birth_date)) ? (date('Y-m-d', strtotime($user_info->birth_date))) : (''))}}"></span>
                                    @if ($errors->has('birth_date'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('birth_date') }}
                                    </p>
                                    @endif
                                </div> -->
                            </div>
                            @if(empty($user_info))
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
                            @endif

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                    <div>
                                        <label for="editor&quot;" class="control control">
                                            <input type="radio" name="role_type" id="male" value="2" checked="" {{ ($user_info->role_id == 2) ? ("checked") : ("") }}> &nbsp;&nbsp; Editor
                                        </label>
                                         <label for="user_type&quot;" class="control control">
                                            <input type="radio" name="role_type" id="user_type" value="3" {{ ($user_info->role_id == 3) ? ("checked") : ("") }}> &nbsp;&nbsp; User
                                        </label>
                                    </div>
                                    @if ($errors->has('role_type'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('role_type') }}
                                    </p>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture">
                                  
                                  @if ($errors->has('profile_picture'))
                                  <p class="error help-block">{{ $errors->first('profile_picture') }}</p>
                                  @endif
                                </div>
                                <div class="form-group col-md-6">
                                    @if (!empty($user_info->profile_picture))
                                        <img id="file-image" src="{{ asset('public/'.$user_info->profile_picture) }}" width="80" height="80"/>
                                      @else
                                        <img id="file-image" src="{{ asset('public/no-img.png') }}" alt="Preview" class="hidden" width="80" height="80">
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


    <script>

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

    </script>

@endsection