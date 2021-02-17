@extends('layouts.app')

@section('content')
<div class="d-flex" id="wrapper">
 <!-- Sidebar -->
 <div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Category</div> 
        <div class="list-group list-group-flush">
          <ul class="list-group">
             @if(!empty($categories))
                @foreach($categories as $k => $val)
                   <li class="list-group-item">
                       <a href="{{ url('home/?category_id='.encode($val->id)) }}" class="list-group-item list-group-item-action bg-light">{{$val->name}}</a>
                          @if ($val->children)
                             <ul class="list-group mt-2">
                                @foreach ($val->children as $child)
                                   <li class="list-group-item">
                                       <a href="{{ url('home/?category_id='.encode($child->id)) }}" class="list-group-item list-group-item-action bg-dark" style="color:white;">{{$child->name}}</a>
                                   </li>
                                @endforeach
                             </ul> 
                          @endif 
                     </li>
                 @endforeach
              @endif
           </ul>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->
 <div class="row"> 
 <!-- Filter Section -->
 <div class="col-xs-12">
            <div class="box box-primary box-solid" style="margin-left:84px;">
                <div class="box-header box-header-background with-border">
                  <h3 class="box-title">SEARCH BY FILTERS</h3>
                </div>
                <!-- /.box-header --> 
                <div class="box-body">
                <!-- <form role="form"  name="search-posts" id="search-posts" action="{{ url('search-posts') }}" method="post"> -->
                <form role="form"  name="search-posts" id="search-posts" method="get">
                <!-- {{ csrf_field() }} -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmail3">Category</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="">Select Category</option>
                                    @if(!empty($categories))
                                     @foreach($categories as $i => $cat)
                                    <option value="{{encode($cat->id)}}">{{$cat->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmail3">Sort By Date</label>
                                <select class="form-control" name="sort_by" id="sort_by">
                                    <option value="">Select</option>
                                    <option value="ASC">Asc</option>
                                    <option value="DESC">Desc</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmail3">Posted By</label>
                                <select class="form-control" name="posted_by" id="posted_by">
                                    <option value="">Select</option>
                                    @if(!empty($users))
                                     @foreach($users as $i => $user)
                                    <option value="{{encode($user->id)}}">{{$user->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row"> 
                         <div class="col-md-3">
                          <button type="submit" id="filter" class="btn btn-success btn-flat margin-top-25" ><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                          <!-- onclick="filterRequest();" -->
                        <a href="" class="btn btn-warning btn-flat margin-top-25"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Reset</a>
                     </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Filter Section -->  
    <div class="container">
      <div class="row ">
         @if(!empty($posts) && $posts->count())
           @foreach($posts as $key => $value)
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                  <?php
                  $arr = $value->feature_image;
                  $image = str_replace("storage/feature_image/","",$arr,$i);
                  ?>
                    <img class="card-img-top" src="{{ url('/storage/app/public/feature_image/'.$image)}}" alt="Card image cap" style="width:290px;height:190px;">
                      <div class="card-body">
                        <h5 class="card-title">{{$value->title}}</h5>
                              <?php $string = strip_tags($value->description);
                                  if (strlen($string) > 50) {
                                  // truncate string
                                  $stringCut = substr($string, 0, 50);
                                  $endPoint = strrpos($stringCut, ' ');
                                  //if the string doesn't contain any space then it will cut without word basis.
                                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                  $string .= '...';
                                  }
                               ?>
                        <div class="card-text">{{$string }}</div>
                          <a href="{{ url('post/'.encode($value->id))}}">Read More..</a>
                      </div>
                 </div>
              </div>
           @endforeach
            @else       
             <p colspan="10">There are no posts.</p>     
          @endif
       </div>
     <div>
  </div>
  <br>
  {!! $posts->links() !!}
  </div>
  @endsection

