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
              
                 <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">State<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="state" name="state" placeholder="State" required="true">
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