@extends('admin.layouts.master')
@section('content')
<link href="{{ asset('public/Admin/select2-bootstrap.min.css') }}" rel="stylesheet" />
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
                    <form role="form" name="edit-categories" id="edit-categories" action="{{ url('admin/categories/update') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ (!empty($category_info->id))?($category_info->id):('') }}">
                        <input type="hidden" name="status" id="status" value="{{ (!empty($category_info->status))?($category_info->status):('') }}">
                        <div class="box-body col-md-12">
                            <div class="row">
                                         
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{old('name', (!empty($category_info->name)) ? ($category_info->name) : (''))}}"></span>
                                    @if ($errors->has('name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('name') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="parent_id">Parent Category<span class="text-danger">*</span></label>
                                    <select name="parent_id" type="text" id="parent_id" class="form-control box-size select2">
                                      <option value="">Select Category</option> 
                                        @if(!empty($category_parent_info))
                                            @foreach($category_parent_info as $c)
                                                <!-- <option value="{{ $c->id }}" {{ (!empty($category_info->parent_id))?(($category_info->parent_id == $c->parent_id)?('selected'):('')):('') }} >{{$c->name}}</option> -->
                                                <option value="{{ $c->id }}" >{{$c->name}}</option>
                                                @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('parent_id'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('parent_id') }}
                                    </p>
                                    @endif
                                </div>    
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <a href="{{ url('admin/categories') }}" class="btn btn-danger">Cancel</a>
                                    <button id="btn-categories" type="submit" class="btn btn-primary">Submit</button>
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
    <script type="text/javascript" src="{{ asset('public/Admin/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {   
            $('#birth_date').datepicker({ 
                dateFormat: 'yy-mm-dd',
            });

            $('.select2').select2();

            $("form[name='edit-categories']").validate({
            rules: {
                name: {
                required: true
                },
            },

            messages: {
                name: {
                    require: "Please enter name"
                },
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        });
    </script>

@endsection