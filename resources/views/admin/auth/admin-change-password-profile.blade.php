@extends('admin.layouts.master')
@section('content')
    <style type="text/css">
        .field-icon {
        float: right;
        margin-top: -25px;
        position: relative;
        z-index: 2;
        margin-right: 8px;
    }
    </style>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->

            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">Update Profile</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form role="form" name="admin-profile" id="admin-profile" action="{{ url('admin/update-profile') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body col-md-12">
                            
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="hidden" name="userId" id="userId" value="{{ auth()->user()->id }}">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{ auth()->user()->name }}">
                                    @if ($errors->has('name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('name') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ auth()->user()->email }}">
                                    @if ($errors->has('email'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('email') }}
                                    </p>
                                    @endif
                                </div>

                                <!-- <div class="form-group col-md-6 ">
                                    <label for="name">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter Last Name" value="{{ auth()->user()->last_name }}"></span>
                                    @if ($errors->has('last_name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('last_name') }}
                                    </p>
                                    @endif
                                </div> -->
                            </div>    

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="mobile_number">Mobile Number<span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_number" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" value="{{ auth()->user()->mobile_number }}">
                                    @if ($errors->has('mobile_number'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('mobile_number') }}
                                    </p>
                                    @endif
                                </div>
                            </div>                            
                           <div class="row">
                             <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                             </div>
                           </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>  
</section>     
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->

            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">Update Password</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form role="form" name="admin-update-password" id="admin-update-password" action="{{ url('admin/update-password') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body col-md-12">
                            
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Old Password<span class="text-danger">*</span></label>
                                    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Enter Old Password" value=""></span>
                                    @if ($errors->has('old_password'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('old_password') }}
                                    </p>
                                    @endif
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">New Password<span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Enter New Password" value=""></span>
                                    @if ($errors->has('new_password'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('new_password') }}
                                    </p>
                                    @endif
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Confirm Password<span class="text-danger">*</span></label>
                                    <input type="password" name="c_password" class="form-control" id="c_password" placeholder="Enter Confirm Password" value=""></span>
                                    @if ($errors->has('c_password'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('c_password') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                           <div class="row">
                             <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
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

@endsection