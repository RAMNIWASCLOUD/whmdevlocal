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
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/')}}/add_meter">Manage {{ $title }}</a></li>
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
              <h3 class="box-title"></h3>
              <div class="row">
                <div class="col-md-12">
                  <center>
                    <span style="font-size: 24px">
                      <b>Last Location:</b> {{$data[$id]['last_meter_location']}}({{ (!empty($data[$id]['last_meter_location_time']))? date('d M. Y & h:i:s A',$data[$id]['last_meter_location_time']) : 'NA'}})
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
                      <label for="oldpassword">Device ID</label>: <span>{{$data[$id]['device_id']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Manufacturer Serial Number</label>: <span>{{$data[$id]['manufacturer_serial_number']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Type</label>: <span>{{$data[$id]['device_type']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Subtype</label>: <span>{{$data[$id]['device_subtype']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Model Number</label>: <span>{{$data[$id]['device_model_number']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Manufacturer Abbreviation</label>: <span>{{$data[$id]['device_manufacturer_abbreviation']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Manufacturing Year</label>: <span>{{$data[$id]['device_manufacturing_year']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Calibration Year</label>: <span>{{$data[$id]['device_calibration_year']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Protocol</label>: <span>{{$data[$id]['device_protocol']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Protocol Version</label>: <span>{{$data[$id]['device_protocol_version']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device MAC Address</label>: <span>{{$data[$id]['device_mac_address']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Firmware Version</label>: <span>{{$data[$id]['device_firmware_version']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Configuration Version</label>: <span>{{$data[$id]['device_configuration_version']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Display Register Digit</label>: <span>{{$data[$id]['device_display_register_digit']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Communication Technology</label>: <span>{{$data[$id]['device_communication_technology']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Communication Module Model</label>: <span>{{$data[$id]['device_communication_module_model']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Communication Module Serial Number</label>: <span>{{$data[$id]['device_communication_module_serial_number']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Communication Module Manufacturing Year</label>: <span>{{$data[$id]['device_communication_module_manufacturing_year']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Communication Module Firmware Version</label>: <span>{{$data[$id]['device_communication_module_firmware_version']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Communication Module IMEI Number</label>: <span>{{$data[$id]['device_communication_module_imei_number']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS TCP PORT</label>: <span>{{$data[$id]['dlms_tcp_port']}}</span>
                    </div>
                  </div>
                </div>
              </div><div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Communication Profile</label>: <span>{{$data[$id]['dlms_communication_profile']}}</span>
                    </div>
                  </div>
                </div>
                {{-- <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Client ID</label>: <span>{{$data[$id]['dlms_client_id']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Master Key</label>: <span>{{$data[$id]['dlms_master_key']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Authentication Key</label>: <span>{{$data[$id]['dlms_authentication_key']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS GUC</label>: <span>{{$data[$id]['dlms_guc']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Security</label>: <span>{{$data[$id]['dlms_security_secret']}}</span>
                    </div>
                  </div>
                </div>
              </div><div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Security Policy</label>: <span>{{$data[$id]['dlms_security_policy']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Authentication Mechanism</label>: <span>{{$data[$id]['dlms_authentication_mechanism']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Security Suite</label>: <span>{{$data[$id]['dlms_security_suite']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Companion</label>: <span>{{$data[$id]['dlms_companion']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">DLMS Companion Version</label>: <span>{{$data[$id]['dlms_companion_version']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device Utility ID</label>: <span>{{$data[$id]['device_utilityid']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Utility</label>: <span>{{$data[$id]['utility']}}</span>
                    </div>
                  </div>
                </div> --}}
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Sim Number</label>: <span>{{$data[$id]['iccid']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Testing Status</label>: <span>{{$data[$id]['physical_testing_status']}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Testing Time</label>: <span>{{$data[$id]['physical_testing_time']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Damage Reason: </label><span>{{$data[$id]['physical_meter_reject_reason']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Physical Damage Proof</label>: <span><a href="{{url('/')}}/{{$data[$id]['physical_meter_reject_images']}}">View</a></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Technical Testing Status</label>: <span>{{$data[$id]['testing_status']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Technical Damage Reason: </label><span>{{$data[$id]['meter_reject_reason']}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Technical Damage Proof</label>: <span><a href="{{url('/')}}/{{$data[$id]['meter_reject_images']}}">View</a></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Current Meter Status</label>: <span>{{$data[$id]['current_meter_status']}}</span>
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
      <div class="row">
        <div class="col-md-12">
          <ul class="timeline">
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data[$id]['meter_upload_time']))? date('d M. Y',$data[$id]['meter_upload_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i>{{(!empty($data[$id]['meter_upload_time']))? date('h:i:s A',$data[$id]['meter_upload_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">Meter Uploaded</a></h3>
              </div>
            </li>
            @if(!empty($data[$id]['batch_approve_reject_time']))
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data[$id]['batch_approve_reject_time']))? date('d M. Y',$data[$id]['batch_approve_reject_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data[$id]['batch_approve_reject_time']))? date('h:i:s A',$data[$id]['batch_approve_reject_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">Meter Testing</a></h3>
                <div class="timeline-body">
                  
                  <b>Status:</b> {{$data[$id]['testing_status']}}
                </div>
              </div>
            </li>
            @endif
            @if(!empty($data[$id]['swh_delivery_time']))
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data[$id]['swh_delivery_time']))? date('d M. Y',$data[$id]['swh_delivery_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data[$id]['swh_delivery_time']))? date('h:i:s A',$data[$id]['swh_delivery_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);"> {{$data[$id]['swh_name']}}</a></h3>
                <div class="timeline-body">
                  MRN No.: {{$data[$id]['mrn_ref']}}<br>
                  Delivery Challan No.: {{$data[$id]['dl_ch_ref']}}
                </div>
              </div>
            </li>
            @endif
            @if(!empty($data[$id]['vmwh_delivery_time']))
            <li class="time-label">
                  <span class="bg-blue">
                    {{(!empty($data[$id]['vmwh_delivery_time']))? date('d M. Y',$data[$id]['vmwh_delivery_time']) : '--/--/----'}}
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{(!empty($data[$id]['vmwh_delivery_time']))? date('h:i:s A',$data[$id]['vmwh_delivery_time']) : '--:--'}}</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">{{$data[$id]['vmwh_name']}}</a></h3>
                <div class="timeline-body">
                  MRN No.: {{$data[$id]['vmwh_mrn_ref']}}<br>
                  Delivery Challan No.: {{$data[$id]['vmwh_dl_ch_ref']}}
                </div>
              </div>
            </li>
            @endif
            <li class="time-label">
                  <span class="bg-blue">
                    --/--/----
                  </span>
            </li>
            <li>
              <i class="fa fa-envelope bg-purple"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> --:--</span>
                <h3 class="timeline-header"><a href="javascript:void(0);">Installation</a></h3>
                <div class="timeline-body">
                  Consumer Id: NA<br>
                  Installed By: NA
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection