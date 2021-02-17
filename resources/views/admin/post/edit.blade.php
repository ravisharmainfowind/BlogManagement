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
                    <form role="form" name="edit-posts" id="edit-posts" action="{{ url('admin/posts/update') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ (!empty($post_info->id))?($post_info->id):('') }}">
                        <input type="hidden" name="status" id="status" value="{{ (!empty($post_info->status))?($post_info->status):('') }}">
                        <div class="box-body col-md-12">
                            <div class="row">
                                         
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="title">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" value="{{old('title', (!empty($post_info->title)) ? ($post_info->title) : (''))}}"></span>
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
                                         @if(!empty($post_info->postCategories))
                                            @foreach($post_info->postCategories as $post_cat_id)
                                                <option value="{{ $category->id }}" {{ (!empty($category->id))?(($post_cat_id->category_id == $category->id)?('selected'):('')):('') }}>{{ $category->name }}</option>
                                            @endforeach
                                        @endif
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
                                    <input type="text" name="publish_date" class="form-control" id="publish_date" placeholder="Enter Publish Date" value="{{old('publish_date', (!empty($post_info->publish_date)) ? (date('d-m-Y', strtotime($post_info->publish_date))) : (''))}}">
                                    @if ($errors->has('publish_date'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('publish_date') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="image">Image</label>
                                    <input type="file" name="feature_image" id="feature_image">
                                    
                                </div>
                                 
                                 <!-- {{ url('/storage/app/public/feature_image/'.$post_info->feature_image)}} -->
                                <div class="col-md-6">
                                    <img src="{{ asset('public/'.$post_info->feature_image) }}" height="75" width="75">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="form-group purple-border">
                                      <label for="exampleFormControlTextarea4">Description</label>
                                      <textarea name="description" id="description">{{old('description', (!empty($post_info->description)) ? ($post_info->description) : (''))}}</textarea>
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

            $("form[name='edit-posts']").validate({
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
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        });
    </script>

@endsection