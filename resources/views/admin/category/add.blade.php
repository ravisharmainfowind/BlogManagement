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
                    <form role="form" name="add-categories" id="add-categories" action="{{ url('admin/categories/store') }}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="box-body col-md-12">
                            <input type="hidden" name="status" id="status" value="0">
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Category Name" value="{{ old('name') }}"></span>
                                    @if ($errors->has('name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('name') }}
                                    </p>
                                    @endif
                                </div>
                               
                                @if(count($category_info) > 0)
                                <div class="form-group col-md-6">
                                    <label>Parent Category</label>
                                    <select class="form-control select2" name="parent_id" id="parent_id">
                                        <option value="">Select Category</option>                                  
                                            @foreach($category_info as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach                                    
                                    </select>
                                </div>
                                @endif
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

            $("form[name='add-categories']").validate({
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