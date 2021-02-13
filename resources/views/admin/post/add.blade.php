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
                    <form role="form" name="add-posts" id="add-posts" action="{{ url('admin/posts/store') }}" method="post" enctype="multipart/form-data"> 
                        {{ csrf_field() }}
                        <div class="box-body col-md-12">
                            <input type="hidden" name="status" id="status" value="0">
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="title">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" value="{{ old('title') }}"></span>
                                    @if ($errors->has('title'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('title') }}
                                    </p>
                                    @endif
                                </div>
                               
                               
                                <div class="form-group col-md-6">
                                    <label>Category</label>
                                    <select class="form-control select2" name="category[]" id="category_id" multiple>
                                        <option value="">Select Category</option>                                  
                                            @foreach($category_info as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach                                    
                                    </select>
                                    @if ($errors->has('category'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('category') }}
                                    </p>
                                    @endif
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="publish_date">Publish Date<span class="text-danger">*</span></label>
                                    <input type="text" name="publish_date" class="form-control" id="publish_date" placeholder="Enter Publish Date" value="{{ old('publish_date') }}">
                                    @if ($errors->has('publish_date'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('publish_date') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image">Image</label>
                                    <input type="file" name="feature_image" id="feature_image">

                                    @if ($errors->has('feature_image'))
                                        <p class="error help-block">{{ $errors->first('feature_image') }}</p>
                                    @endif
                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="form-group purple-border">
                                      <label for="exampleFormControlTextarea4">Description</label>
                                      <textarea name="description" id="description"></textarea>
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">                       
                                    <a href="{{ url('admin/posts') }}" class="btn btn-danger">Cancel</a>
                                    <button id="btn-posts" type="submit" class="btn btn-primary">Submit</button>
                                   
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
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function () {   
            $('#publish_date').datepicker({ 
            dateFormat: 'yy-mm-dd',
        });

            CKEDITOR.replace('description');

            $('.select2').select2();

            $("form[name='add-posts']").validate({
            rules: {
                title: {
                required: true
                },
                category:{
                 require:true   
                },
                publish_date: {
                    required: true
                },
                feature_image:{
                    required:true,
                    extension: "jpg|jpeg|png"
                },
            },

            messages: {
                title: {
                    required: "Please enter title"
                },
                publish_date: {
                    required: "Please select date"
                },
                category: {
                    required: "This Select Category."
                },
                feature_image: {
                    required: "Please select image",
                    extension: "Please upload file in these format only (jpg, jpeg, png)."
                },
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        });
    </script>

@endsection