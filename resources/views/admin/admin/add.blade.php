@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Warehouse Name<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" placeholder="Warehouse Name" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <?php $state = \DB::table('state')->where(['is_delete'=>'0'])->get(); ?>
                      <label for="oldpassword">State<span style="color:red;" >*</span></label>
                      <select class="form-control" id="state" name="state" required="true">
                        <option value="">Select</option>
                        @foreach($state as $state_value)
                        <option value="{{$state_value['state']}}">{{$state_value['state']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                 
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Email(Username)<span style="color:red;" >*</span></label>
                      <input type="email" class="form-control" id="username" name="username" placeholder="Email(Username)" data-parsley-pattern="^([\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$"  placeholder="Email" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">New Password<span style="color:red;" >*</span></label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Confirmed Password<span style="color:red;" >*</span></label>
                      <input type="password" class="form-control" id="confimed_password" name="confimed_password" data-parsley-equalto="#password" data-parsley-error-message="New Password & Confirmed Password Should Be Same." placeholder="Password"  required="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4" id="div_state" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">State<span style="color:red;" >*</span></label>
                      {{-- <input type="text" class="form-control" id="state" name="state" value="Bihar" placeholder="State" readonly="" required="true"> --}}
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_city" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">City<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="City" >
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_sw_list" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">EDF Warehouse<span style="color:red;" >*</span></label>
                      <select id="sw" name="sw" class="form-control">
                        @foreach($sw_list as $key=>$value)
                        <option value="{{$value['_id']}}">{{$value['warehouse_name']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    function role_change()
    {
      var role = $('#role').val();
      if(role=='1')
      {
        $('#div_state').hide();
        $('#div_city').hide();
        $('#div_sw_list').hide();
        $('#state').prop('required',false);
        $('#city').prop('required',false);
        $('#sw').prop('required',false);
      }
      else if(role=='2')
      {
        $('#div_state').show();
        $('#div_city').hide();
        $('#div_sw_list').hide();
        $('#state').prop('required',true);
        $('#city').prop('required',false);
        $('#sw').prop('required',false);
      }
      else
      {
        $('#div_state').show();
        $('#div_city').show();
        $('#div_sw_list').show();
        $('#sw').prop('required',true);
        $('#state').prop('required',true);
        $('#city').prop('required',true);
      }
    }
  </script>
  
@endsection