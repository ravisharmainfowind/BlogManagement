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
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach

                                            <!-- <option value="">Select Question</option>
                                        @if(!empty($poll_question_info))
                                            @foreach($poll_question_info as $poll_ques)
                                                <option value="{{ $poll_ques->id }}" {{ (!empty($daily_news_info->poll_question_id))?(($daily_news_info->poll_question_id == $poll_ques->id)?('selected'):('')):('') }}>{{ $poll_ques->title }}</option>
                                            @endforeach
                                        @endif -->


                                    </select>
                                    @if ($errors->has('category'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('category') }}
                                    </p>
                                    @endif
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