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
        <li><a href="{{url('/')}}/manage_seleted_meter/{{$id}}">Manage Selected Meter</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/store_accept_dispatch_swh" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row" >
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Status<span style="color:red;" >*</span></label>
                      <select id="status" name="status" class="form-control" onchange="status_change()" required="">
                        <option value="">Select</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_file" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Delivery Proof<span style="color:red;" >*</span></label>
                      <input type="file" id="file" name="file" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_reason" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Reason<span style="color:red;" >*</span></label>
                      <select id="reason" name="reason" class="form-control">
                        <option value="">Select</option>
                        @foreach($reason as $value)
                          <option value="{{$value['reason']}}">{{$value['reason']}}</option>
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
    function status_change()
    {
      var status = $('#status').val();
      if(status=='Rejected')
      {
        $('#div_reason').show();
        $('#div_file').hide();
        $('#reason').prop('required',true);
        $('#file').prop('required',false);
      }
      else
      {
        $('#div_file').show();
        $('#div_reason').hide();
        $('#reason').prop('required',false);
        $('#file').prop('required',true);
      }
    }
  </script>
@endsection