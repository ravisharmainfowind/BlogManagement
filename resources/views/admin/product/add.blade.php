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
                    @if(auth('web')->user()->role_id==1)
                    <form role="form" name="add-products" id="add-products" action="{{ url('admin/products/store') }}" method="post" enctype="multipart/form-data">
                    @endif 
                    
                        {{ csrf_field() }}
                        <div class="box-body col-md-12">
                            <input type="hidden" name="status" id="status" value="0">
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Product Name<span class="text-danger">*</span></label>
                                    <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter Product Name" value="{{ old('product_name') }}"></span>
                                    @if ($errors->has('product_name'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('product_name') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="email">Quantity<span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity" value="{{ old('quantity') }}"></span>
                                    @if ($errors->has('quantity'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('quantity') }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="mobile_number">price<span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control" id="price"  placeholder="Enter price" value="{{ old('price') }}">
                                    @if ($errors->has('price'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('price') }}
                                    </p>
                                    @endif
                                </div>

                                <div class="form-group col-md-6 ">
                                    <label for="mobile_number">Discount<span class="text-danger">*</span></label>
                                    <input type="number" name="discount" class="form-control" id="discount"  placeholder="Enter Discount" value="{{ old('discount') }}">
                                    @if ($errors->has('discount'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('discount') }}
                                    </p>
                                    @endif
                                </div>

                                
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="name">Description<span class="text-danger">*</span></label>
                                    <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value=""  autocomplete="off"><span toggle="#description"></span>
                                    @if ($errors->has('description'))
                                    <p class="error">
                                        <i class="fa fa-times-circle-o"></i>  {{ $errors->first('description') }}
                                    </p>
                                    @endif
                                </div>
                                
                            </div>

                           

                            <div class="row">
                                <div class="form-group col-md-6">
                                    @if(auth('web')->user()->role_id==1)
                                    <a href="{{ url('admin/products') }}" class="btn btn-danger">Cancel</a>
                                    <button id="btn-products" type="submit" class="btn btn-primary">Submit</button>
                                    @endif
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

@endsection