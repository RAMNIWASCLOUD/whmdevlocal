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
        <li><a href="{{url('/')}}/manage_seleted_meter/{{$data['batch_id']}}">Manage Selected Meter</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
   
  @if($data['physical_testing_status']=='Pending')
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
            <form action="{{ url('/')}}/store_physical_testing_meters_status" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              
              {!! csrf_field() !!}
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row" >
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Status<span style="color:red;" >*</span></label>
                      <select id="status" name="status" class="form-control" onchange="status_change()" required="">
                        <option value="">Select</option>
                        <option value="Tested">Tested</option>
                        <option value="Damaged">Damaged</option>
                      </select>
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
  @endif
    <section class="content">
      <div class="row">
        @include('admin.layout._status_msg')
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/update_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley">
              {!! csrf_field() !!}
              
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Invoice Date</label>: <span>{{$data['batch_invoice_no']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Invoice No.</label>: <span>{{$data['batch_invoice_date']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">EWAY Bill No.</label>: <span>{{$data['batch_waybill_no']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">EWAY Bill Date</label>: <span>{{$data['batch_waybill_date']}}</span>
                    </div>
                  </div>
                </div>
              
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Meter No.</label>: <span>{{$data['device_id']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Box No.</label>: <span>{{$data['box_no']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Received Date</label>: <span>{{$data['reveived_date']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Phase Type</label>: <span>{{$data['phase_type']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Sim No.</label>: <span>{{$data['sim_no']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">IMEI No.</label>: <span>{{$data['imei_no']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Sim No. 2</label>: <span>{{$data['sim_no2']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Supplier</label>: <span>{{$data['batch_supplier']}}</span>
                    </div>
                  </div>
                </div>
             
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Testing Status</label>: <span>{{$data['physical_testing_status']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Testing Time</label>: <span>{{$data['physical_testing_time']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Damage Reason: </label><span>{{$data['physical_meter_reject_reason']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Damage Proof</label>: 
                      @if(!empty($data['physical_meter_reject_images']))
                      <span><a href="{{url('/')}}/{{$data['physical_meter_reject_images']}}">View</a></span>
                      @else
                      
                      @endif
                    </div>
                  </div>
                </div>
              
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Technical Testing Status</label>: <span>{{$data['testing_status']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Technical Damage Reason: </label><span>{{$data['meter_reject_reason']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Technical Damage Proof</label>: 
                      @if(!empty($data['meter_reject_images']))
                        <span><a href="{{url('/')}}/{{$data['meter_reject_images']}}">View</a></span>
                      @else
                      
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Current Meter Status</label>: <span>{{$data['current_meter_status']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              
              <div class="box-footer">
                <a href="{{url('/')}}/manage_{{$url_slug}}" type="submit" class="btn btn-primary pull-right">Back</a>
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
        $('#reason').prop('required',true);
      }
      else
      {
        $('#div_reason').hide();
        $('#reason').prop('required',false);
      }
    }
  </script>
@endsection