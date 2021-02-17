@extends('layouts.app')

@php
  $userInfo = json_decode(Cookie::get('admin'));
  if(isset($userInfo->remember_me) && $userInfo->remember_me == "on") {
    $remember_me  = $userInfo->remember_me;
    $email        = $userInfo->email;
    $password     = $userInfo->password;
    $mobileNumber = $userInfo->mobile_number;
  }
 @endphp


@section('content')
<section">
      <div class="container">
        
        <div class="row">
          <div class="col-md-12 mt-4">
            <h3 class="secHead text-center mb-md-5 mb-3">LOGIN</h3>
          </div>
          
          <div class="col-12 col-sm-10 col-md-6 col-xl-5 mx-auto">
            <form action="" method="post" id="login_form">
            @csrf
            @if(Session::has('success'))
                <p style="text-align: center;color: red;">{{Session::get('success')}}</p>
                @endif

                <p class="error help-block" style="text-align: center;color: red;" id="error">
                    @if ($errors->has('error'))
                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('error') }} @endif
                </p>
            <div class="form-group mb-4">
              <input class="form-control" placeholder="Username or email" name="email" id="login_email" type="email">
            </div>
            <div class="form-group mb-4">
              <input class="form-control" placeholder="Password" id="login_password" name="password" type="password">
            </div>
            <div class="form-group mb-4">
              <label class="ltcheckbox">
                <input placeholder="Password" type="checkbox" id="remember_me">
                <span></span>Remember me
              </label>
            </div>
            <div class="form-group mb-4 text-center">
              <button class="btn btn-outline-secondary w-50" type="submit" id="login_submit" value="login_submit" name="login_submit" onclick="login_submitRequest();">LOGIN</button>
            </div>
            
          </form>
          <div class="mb-4 text-center">
              <a href="{{ url('/register')}}" class="text-dark">Register</a>
            </div>
          </div>
       
        </div>
     
      </div>
    </section>
@endsection
<script type="text/javascript">  
var headers = { 
   'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
   //'Authorization' : "Bearer {{ @$sessionArray['jwt_token'] }}",
   //'Accept': 'application/json',
   //'Content-Type': 'application/x-www-form-urlencoded'      
   }; 
  function login_submitRequest() {
    $("#login_form").validate({
      rules: {
        email:{
             email:true,
             required:true
         },
         password:{  
             required:true
         },
      },
   messages: {

   },
   submitHandler: function(form) {
  
      var params = $("#login_form").serializeArray();
         $.ajax({
         url:  'userlogin',
         type: 'GET',
         data: params,
         headers  : headers,
      
          success: function(res) {
         console.log(res);    
         set_session(res.result,$("#login_password").val());
       },
       error: function(error){
         ajax_error(error,'submit','login');
       }
      });
   }

});

  function set_session(info,password){ 
     console.log(info);
     var RememberMe = "";
     if ($('#remember_me').is(':checked')) {
       RememberMe = "on";
     }
     if(info.role_id == 2){
       data = {
         'id': info.id,
         'full_name': info.full_name,
         'email': info.email,
         'password': password,
         'mobile_number': info.mobile_number,
         'user_type': info.role_id,
         'user_type_name': "editor",
         'profile_image': info.profile_image,
         'remember_me': RememberMe,
         'token' : $('meta[name="csrf-token"]').attr('content')
       };
     }
     if(info.role_id == 3){
       data = {
         'id': info.id,
         'full_name': info.full_name,
         'email': info.email,
         'password': password,
         'mobile_number': info.mobile_number,
         'user_type': info.role_id,
         'user_type_name': "user",
         'profile_image': info.profile_image,
         'remember_me': RememberMe,
         'token' : $('meta[name="csrf-token"]').attr('content')
       };
     }
     $.ajax({
       url: SITEURL + 'set-session-lg',
       type: 'GET',
       data: data,
       headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       success: function(res) {
          console.log(info.role_id);
          var login_type = info.role_id;
          if(login_type==3){
             window.location.href = SITEURL+'home';
          }

          if(login_type==2){
             window.location.href = SITEURL+'home';
          }
       },
       error:function(data){
         console.log(data);
       }
     });
   }  
}
</script>