@extends('admin.layout.master')
 
@section('content')
<style type="text/css">
  .form-group {
     margin-bottom: 0px; 
}
</style>
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      {{-- <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol> --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              <div class="row">
                <div class="col-md-12">
                  <center>
                    <span style="font-size: 24px">
                      <b>Last Location:</b> {{$data['last_meter_location']}}({{ (!empty($data['last_meter_location_time']))? date('d M. Y & h:i:s A',$data['last_meter_location_time']) : 'NA'}})
                    </span>
                  </center>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/update_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">                     
                      <label for="oldpassword">Invoice Date</label>: <span><!-- {{$data['batch_invoice_no']}}  --></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Invoice No.</label>: <span><!--{{$data['batch_invoice_date']}}--></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">EWAY Bill No.</label>: <span><!--{{$data['batch_waybill_no']}}--></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">EWAY Bill Date</label>: <span><!--{{$data['batch_waybill_date']}}--></span>
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
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Uploaded Batch ID</label>: <span>{{$data['batch_id']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">GRN Date:</label>: <span>{{$data['batch_grn_date']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Warranty Expiry Date:</label>: <span>{{ date('Y-m-d', strtotime('+5 year', strtotime($data['batch_grn_date'])))}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              
              {{-- <div class="box-footer">
                <a href="{{url('/')}}/manage_{{$url_slug}}" type="submit" class="btn btn-primary pull-right">Back</a>
              </div> --}}
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <ul class="timeline">
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data['meter_upload_time']))? date('d M. Y',$data['meter_upload_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data['meter_upload_time']))? date('h:i:s A',$data['meter_upload_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">Meter Uploaded</a></h3>
              </div>
            </li>
            @if(!empty($data['batch_approve_reject_time']))
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data['batch_approve_reject_time']))? date('d M. Y',$data['batch_approve_reject_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data['batch_approve_reject_time']))? date('h:i:s A',$data['batch_approve_reject_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">Meter Testing</a></h3>
                <div class="timeline-body">
                  
                  <b>Status:</b> {{$data['testing_status']}}
                </div>
              </div>
            </li>
            @endif
            @if(!empty($data['swh_delivery_time']))
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data['swh_delivery_time']))? date('d M. Y',$data['swh_delivery_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data['swh_delivery_time']))? date('h:i:s A',$data['swh_delivery_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);"> {{$data['swh_name']}}</a></h3>
                <div class="timeline-body">
                  MRN No.: {{$data['mrn_ref']}}<br>
                  Delivery Challan No.: {{$data['dl_ch_ref']}}
                </div>
              </div>
            </li>
            @endif
            @if(!empty($data['vmwh_delivery_time']))
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data['vmwh_delivery_time']))? date('d M. Y',$data['vmwh_delivery_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data['vmwh_delivery_time']))? date('h:i:s A',$data['vmwh_delivery_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">{{$data['vmwh_name']}}</a></h3>
                <div class="timeline-body">
                  MRN No.: {{$data['vmwh_mrn_ref']}}<br>
                  Delivery Challan No.: {{$data['vmwh_dl_ch_ref']}}
                </div>
              </div>
            </li>
            @endif
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data['installation_date_time']))? date('d M. Y',strtotime($data['installation_date_time'])) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i>  {{(!empty($data['installation_date_time']))? date('h:i:s A',strtotime($data['installation_date_time'])) : '--/--/----'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">Installation</a></h3>
                <div class="timeline-body">
                  Consumer Id: {{$data['consumer_id']}}<br>
                  EDF Vendor Manager Name: {{$data['edf_vendor_manager_name']}}<br>
                  EDF Vendor Plan Name: {{$data['edf_vendor_plan_name']}}<br>
                  Installed By: {{$data['field_worker']}}
                </div>
              </div>
            </li>
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            {{-- <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div> --}}
            <h3>Meter Movement</h3>
            <div class="box-body">
            <!-- /.box-header -->
           
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Done By</th>
                  <th>Activity</th>
                  <th>Description</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php $i=1; 
                    $meter_movement = \DB::table('meter_movement')->where(['meter_id'=>$data['device_id']])->get();
                  ?>
                  @if(count($meter_movement)!=0)
                  @foreach($meter_movement as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['created_name']}}
                      </td>
                      <td>
                        {{$value['activity']}}
                      </td>
                      <td>
                        {{$value['description']}}
                      </td>
                      <td>
                        {{$value['date']}}
                      </td>
                      
                     
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="5"><center>No Record Found.</center></td>
                    </tr>
                  @endif
                </tbody>
              </table>
          
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-xs-12">
         
          <div class="box">
            {{-- <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div> --}}
            <h3>Sim History</h3>
            <div class="box-body">
            <!-- /.box-header -->
           
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Done By</th>
                  <th>Old Sim</th>
                  <th>New Sim</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php $i=1; 
                    $sim_history = \DB::table('sim_history')->where(['meter_id'=>$data['_id']])->get();
                  ?>
                  @if(count($sim_history)!=0)
                  @foreach($sim_history as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['created_name']}}
                      </td>
                      <td>
                        {{$value['old_iccid']}}
                      </td>
                      <td>
                        {{$value['iccid']}}
                      </td>
                      <td>
                        {{$value['date']}}
                      </td>
                     
                     
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="5"><center>No Record Found.</center></td>
                    </tr>
                  @endif
                </tbody>
              </table>
          
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection