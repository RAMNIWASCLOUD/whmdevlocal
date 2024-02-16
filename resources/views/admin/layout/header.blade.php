<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('/')}}/css_and_js/admin/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- tiem picker -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('/')}}/css_and_js/admin/bootstrap-timepicker/css/bootstrap-timepicker.css">
  <link href='{{url('/')}}/css_and_js/admin/select2/dist/css/select2.min.css' rel='stylesheet' type='text/css'>
  <!-- jQuery 3 -->
  <script src="{{url('/')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style type="text/css">
  .parsley-required{
    color: red;
  }
  .parsley-type{
    color: red;
  }
  .parsley-minlength{
    color: red; 
  }
  .parsley-custom-error-message{
    color: red; 
  }
  .parsley-maxlength{
    color: red; 
  }

  .parsley-errors-list{
    list-style: none;
      padding-left: 5px;
  }
  .parsley-equalto{
    color: red; 
  }
  .inr_font_size_12{
    font-size: 12px;
  }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/')}}/dashbord" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="color: black;"></span>
      <!-- logo for regular state and mobile devices -->

      <span class="logo-lg" style="color: black;"><img style="max-width: 200px;max-height: 42px;" src="{{url('/')}}/css_and_js/logo.png"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" >
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
     
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
              
         
          <li>
            <a href="{{ url('/')}}/logout" class="" >
              {{-- <img src="{{url('/')}}/css_and_js/admin/dist/img/user2-160x160.png" class="user-image" alt="User Image"> --}}
              <span class="hidden-xs">Logout <i class="fa fa-sign-out"></i></span>
            </a>
          </li>
          <!-- Control Sidebar Toggle Button -->
          {{-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> --}}
        </ul>
      </div>
    </nav>
    <style type="text/css">
    .preload { width:100px;
    height: 100px;
    position: fixed;
    top: 50%;
    left: 50%;}
    .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('http://i.imgur.com/KUJoe.gif') 50% 50% no-repeat rgb(249,249,249);
    </style>
  </header>
  {{-- <div class="preload loader"></div> --}}

