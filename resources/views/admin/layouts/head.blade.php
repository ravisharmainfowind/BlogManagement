<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ __('message.APP_NAME') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="icon" type="image/png" sizes="16x16" href="{{ url('public/favicon.png') }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/morris.js/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('public/Admin/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

  <link href="{{ asset('public/Admin/sweetalert/sweetalert.css') }}" rel="stylesheet">
  
  <link href="{{ asset('public/Admin/custom-admin.css') }}" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  @yield('css')


  <!-- jQuery 3 -->
<script src="{{ asset('public/Admin/AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/Admin/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/Admin/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<script src="{{ asset('public/Admin/custom-scripts/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/Admin/my-js/sweetalert.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);

  var SITEURL = '{{URL::to('')}}';
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>
<style type="text/css">
  .error{
    color:red;
  }
</style>

</head>