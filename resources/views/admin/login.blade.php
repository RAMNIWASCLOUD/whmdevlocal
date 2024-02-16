<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('/')}}/css_and_js/admin/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/')}}/css_and_js/admin/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/')}}/css_and_js/admin/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/')}}/css_and_js/admin/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/')}}/css_and_js/admin/plugins/iCheck/square/blue.css">

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
  .parsley-errors-list{
    list-style: none;
      padding-left: 5px;
  }
  </style>
</head>
<body class="hold-transition login-page" style="background: #ffffff;">
<div class="login-box" >
  <!-- /.login-logo -->
  <div class="login-logo">
      <img src="{{url('/')}}/css_and_js/logo.png" style="width: 60%"><br><br>
      <b>WHM</b>Login
  </div>
  <div class="login-box-body" style="background: #032d61!important;">
  <div >
    <p class="login-box-msg" style="color: #ffffff">Sign in</p>
    @if(Session::has('error'))
      <div class="alert alert-danger">
        {{ Session::get('error') }}
      </div>
    @endif
    @if(Session::has('success'))
      <div class="alert alert-success">
        {{ Session::get('success') }}
      </div>
    @endif

    <form action="{{ url('/')}}/login_process" method="post" data-parsley-validate="parsley">
      {!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="text" name="email" class="form-control" placeholder="Username" {{-- data-parsley-type="email" --}} required="true">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" {{-- data-parsley-minlength="6" --}} required="true">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
           <!-- <label>
              <input type="checkbox" name="remember" <?php if(isset($_COOKIE["adminremember"])) { ?> checked <?php } ?>> Remember Me
            </label>-->
          </div> 
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="    background-color: #e75710;">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    </div>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    {{-- <a href="{{url('/')}}/forget_password">I forgot my password</a><br> --}}
    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('/')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/')}}/css_and_js/admin/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ url('/')}}/css_and_js/admin/plugins/iCheck/icheck.min.js"></script>
<!-- parsaly -->
<script src="{{ url('/')}}/css_and_js/admin/parsley.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
 <script type="text/javascript">
    

const channel = new BroadcastChannel('tab');
let isOriginal = true;

channel.postMessage('another-tab');
// note that listener is added after posting the message

channel.addEventListener('message', (msg) => {
    if (msg.data === 'another-tab' && isOriginal) {
        // message received from 2nd tab
        // reply to all new tabs that the website is already open
        channel.postMessage('already-open');
    }
    if (msg.data === 'already-open') {
        isOriginal = false;
        // message received from original tab
        // replace this with whatever logic you need
        alert('Cannot open multiple instances');
        close();
    }
});
  </script>
</body>
</html>
