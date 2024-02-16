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
        <li><a href="{{url('/')}}/swh_edf_meter_pool">EDF Meter Pool</a></li>
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
            <form action="{{ url('/')}}/swh_form_dispatch_meter_step_2" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">MRN No.</label>: <span>{{ $mrn_details['vmwh_mrn_ref'] }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body" >
                    <div class="form-group">
                      <label for="oldpassword">MRN Process Date & Time</label>: <span>{{ $mrn_details['mrn_processing_date'] }} & {{ $mrn_details['mrn_processing_time'] }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Total Uploaded Meter</label>: <span>{{$match_found_meter}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body" >
                    <div class="form-group">
                      <label for="oldpassword">Match Found Meter</label>: <span>{{$total_upload_meter}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Single Phase Meter</label>: <span>{{$count_1phase}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body" >
                    <div class="form-group">
                      <label for="oldpassword">Three Phase Meter</label>: <span>{{$count_3phase}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Total Uploaded Sim</label>: <span>{{$upload_sim_total}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body" >
                    <div class="form-group">
                      <label for="oldpassword">Match Found Sim</label>: <span>{{$match_found_sim}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Total Uploaded Modem</label>: <span>{{$upload_modem_total}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body" >
                    <div class="form-group">
                      <label for="oldpassword">Match Found Modem</label>: <span>{{$match_found_modem}}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>Description Of Material</th>
                        <th>UOM</th>
                        <th>Request Qty</th>
                        <th>Issued From Warehouse<span style="color:red;" >*</span></th>
                        <th>Balance to be Issued</th>
                        <th>Comment</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>1</th>
                        <th>Single Phase Meter</th>
                        <th>Nos</th>
                        <th><center><span >{{ $mrn_details['single_phase_meter_qty'] }}</span></center></th>
                        <th><center>{{$count_1phase}}</center>{{-- <input type="number" class="form-control" id="single_phase_meter_qty" name="single_phase_meter_qty" onchange="change_single_balaned_qty()" required=""> --}}</th>
                        <th><center><span id="single_phase_meter_qty_balanced">{{$count_1phase_balance}}</span></center></th>
                        <th><input type="text" class="form-control" id="single_comment" name="single_comment"></th>
                      </tr>
                      <tr>
                        <th>2</th>
                        <th>Three Phase Meter</th>
                        <th>Nos</th>
                        <th><center><span>{{ $mrn_details['three_phase_meter_qty'] }}</span></center></th>
                        <th><center>{{$count_3phase}}</center>{{-- <input type="number" class="form-control" id="three_phase_meter_qty" name="three_phase_meter_qty" onchange="change_third_balaned_qty()" required=""> --}}</th>
                        <th><center><span id="three_phase_meter_qty_balanced">{{$count_3phase_balance}}</span></center></th>
                        <th><input type="text" class="form-control" id="three_comment" name="three_comment"></th>
                      </tr>
                      <tr>
                        <th>3</th>
                        <th>Sim</th>
                        <th>Nos</th>
                        <th><center><span>{{ $mrn_details['sim_qty'] }}</span></center></th>
                        <th><center>{{$match_found_sim}}</center>{{-- <input type="number" class="form-control" id="sim_qty" name="sim_qty" onchange="change_sim_balaned_qty()" required=""> --}}</th>
                        <th><center><span id="sim_qty_balanced">{{$count_bsnl_sim_balance}}</span></center></th>
                        <th><input type="text" class="form-control" id="sim_comment" name="sim_comment"></th>
                      </tr>
                      <tr>

                        <th>4</th>
                        <th>Modem</th>
                        <th>Nos</th>
                        <th><center><span>{{ $mrn_details['modem_qty'] }}</span></center></th>
                        <th><center>{{$match_found_modem}}</center>{{-- <input type="number" class="form-control" id="modem_qty" name="modem_qty" onchange="change_modem_balaned_qty()" required=""> --}}</th>
                        <th><center><span id="modem_qty_balanced">{{$count_modem_balance}}</span></center></th>
                        <th><input type="text" class="form-control" id="modem_comment" name="modem_comment"></th>
                      </tr>
                      <tr>
                        <th>5</th>
                        <th>Antenna</th>
                        <th>Nos</th>
                        <th><center><span>{{ $mrn_details['seal_qty'] }}</span></center></th>
                        <th><input type="number" class="form-control" id="seal_qty" name="seal_qty" value="0" onchange="change_seal_balaned_qty()" required=""></th>
                        <th><center><span id="seal_qty_balanced">-</span></center></th>
                        <th><input type="text" class="form-control" id="seal_comment"  name="seal_comment"></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <input type="hidden" id="hidden_single_phase_meter_qty" name="hidden_single_phase_meter_qty" value="{{ $mrn_details['single_phase_meter_qty'] }}">
              <input type="hidden" id="hidden_three_phase_meter_qty" name="hidden_three_phase_meter_qty" value="{{ $mrn_details['three_phase_meter_qty'] }}">
              <input type="hidden" id="hidden_sim_qty" name="hidden_sim_qty" value="{{ $mrn_details['sim_qty'] }}">
              <input type="hidden" id="hidden_modem_qty" name="hidden_modem_qty" value="{{ $mrn_details['modem_qty'] }}">
              <input type="hidden" id="hidden_seal_qty" name="hidden_seal_qty" value="{{ $mrn_details['seal_qty'] }}">
              <input type="hidden" id="mrn_id" name="mrn_id" value="{{ $mrn_id }}">
              <input type="hidden" id="meter_ids_list" name="meter_ids_list" value="{{ $meter_ids_list }}">
              <input type="hidden" id="sim_ids_list" name="sim_ids_list" value="{{ $sim_ids_list }}">
              <input type="hidden" id="modem_ids_list" name="modem_ids_list" value="{{ $modem_ids_list }}">
              <input type="hidden" id="match_found_modem" name="match_found_modem" value="{{ $match_found_modem }}">
              <input type="hidden" id="match_found_sim" name="match_found_sim" value="{{ $match_found_sim }}">
              <input type="hidden" id="count_bsnl_sim_balance" name="count_bsnl_sim_balance" value="{{ $count_bsnl_sim_balance }}">
              <input type="hidden" id="count_modem_balance" name="count_modem_balance" value="{{ $count_modem_balance }}">
              <div class="row" style="display: none;">
                <div class="col-md-6">
                  <div class="box-body">
                    <strong>Available Sim</strong>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{-- <input type="checkbox" id="obi_id_all" name="obi_id_all"> --}}</th>
                        <th>Sr. No.</th>
                        <th>Sim No</th>
                        <th>Mobile No</th>
                        <th>IMSI</th>
                      {{--   <th>Static IP</th>
                        <th>APN</th>
                        <th>Status</th>
                        <th>Sim Status</th>
                        <th>Batch Id</th> --}}
                      </tr>
                      </thead>
                      <tbody>
                        <?php $i=1;$sim_data=[]; ?>
                        @foreach($sim_data as $key=>$value)
                          <tr>
                            <td>
                                <input type="checkbox" name="sim_obi_id[]" class="class_checkbox" value="{{$value['_id']}}">
                            </td>
                            <td>
                              {{$i}}
                            </td>
                            <td>
                              {{$value['sim_no']}}
                            </td>
                            <td>
                              {{$value['mobile_no']}}
                            </td>
                            <td>
                              {{$value['imsi']}}
                            </td>
                            {{-- <td>
                              {{$value['static_ip']}}
                            </td>
                            <td>
                              {{$value['apn']}}
                            </td>
                            <td>
                              {{$value['status']}}
                            </td>
                            <td>
                              {{ (isset($value['sim_status']))? $value['sim_status'] :"UTILIZED"}}
                            </td>
                            <td>
                              {{$value['batch_id']}}
                            </td> --}}
                          </tr>
                        <?php $i++; ?>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <strong>Available Modem</strong>
                    <table id="example5" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>{{-- <input type="checkbox" id="obi_id_all" name="obi_id_all"> --}}</th>
                        <th>Sr. No.</th>
                        <th>Modem Number</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; $modem_total=0;?>

                        @if($modem_total!=0)
                        @foreach($modem_data as $value)
                          <tr>
                            <td>
                                <input type="checkbox" name="modem_obi_id[]" class="class_checkbox" value="{{$value['_id']}}">
                            </td>
                            <td>
                              {{$i}}
                            </td>
                            <td>
                              {{$value['modem_number']}}
                            </td>
                            <td>
                              {{$value['status']}}
                            </td>
                          </tr>
                        <?php $i++; ?>
                        @endforeach
                        @else
                          <tr>
                            <td colspan="4"><center>No Record Found.</center></td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">To Dispatch<span style="color:red;" >*</span></label>
                      <select id="to_dispatch" name="to_dispatch" class="form-control" required="" readonly="" style="pointer-events: none;">
                        <option value="">Select</option>
                        @foreach($swh as $value)
                          <option value="{{$value['_id']}}" @if($value['_id']==$mrn_details['to_dispatch']) selected="" @endif>{{$value['username']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Dispatch Mode<span style="color:red;" >*</span></label>
                      <select id="dispatch_mode" name="dispatch_mode" class="form-control" onchange="onchange_dispatch_mode()" required="">
                        <option value="">Select</option>
                        <option value="Self Pickup">Self Pickup</option>
                        <option value="Road Transport">Road Transport</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="div_pickup" style="display: none;">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Name of Person<span style="color:red;" >*</span></label>
                      <input type="text" id="name_of_pickup_person" name="name_of_pickup_person" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Mobile No.<span style="color:red;" >*</span></label>
                      <input type="number" id="mobile_no_pickup_person" name="mobile_no_pickup_person" class="form-control" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="Mobile No. should be 10 digit." data-parsley-maxlength-message="Mobile No. should be 10 digit.">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="div_transport" style="display: none;">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">LR Copy<span style="color:red;" >*</span></label>
                      <input type="file" id="lr_copy" name="lr_copy" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">LR No.<span style="color:red;" >*</span></label>
                      <input type="text" id="lr_no" name="lr_no" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Transport Name<span style="color:red;" >*</span></label>
                      <input type="text" id="transport_name" name="transport_name" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="div_transport1" style="display: none;">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Driver Name<span style="color:red;" >*</span></label>
                      <input type="text" id="driver_name" name="driver_name" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Driver Mobile No.<span style="color:red;" >*</span></label>
                      <input type="number" id="driver_mobile_no" name="driver_mobile_no" class="form-control" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="Driver Mobile No. should be 10 digit." data-parsley-maxlength-message="Driver Mobile No. should be 10 digit." >
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
    function onchange_dispatch_mode()
    {
      var dispatch_mode = $('#dispatch_mode').val();
      if(dispatch_mode=='Self Pickup')
      { 
        $('#div_pickup').show();
        $('#name_of_pickup_person').attr('required','true');
        $('#mobile_no_pickup_person').attr('required','true');

        $('#lr_copy').removeAttr('required');
        $('#lr_no').removeAttr('required');
        $('#transport_name').removeAttr('required');
        $('#driver_name').removeAttr('required');
        $('#driver_mobile_no').removeAttr('required');
        $('#div_transport').hide();
        $('#div_transport1').hide();
      }
      else
      {
        $('#lr_copy').attr('required','true');
        $('#lr_no').attr('required','true');
        $('#transport_name').attr('required','true');
        $('#driver_name').attr('required','true');
        $('#driver_mobile_no').attr('required','true');

        $('#name_of_pickup_person').removeAttr('required');
        $('#mobile_no_pickup_person').removeAttr('required');
        $('#div_pickup').hide();
        $('#div_transport').show();
        $('#div_transport1').show();
      }
    }

    function change_single_balaned_qty()
    {
      var single_phase_meter_qty = $('#single_phase_meter_qty').val();
      var hidden_single_phase_meter_qty = $('#hidden_single_phase_meter_qty').val();
      $('#single_phase_meter_qty_balanced').text(hidden_single_phase_meter_qty-single_phase_meter_qty);
    }

    function change_third_balaned_qty()
    {
      var three_phase_meter_qty = $('#three_phase_meter_qty').val();
      var hidden_three_phase_meter_qty = $('#hidden_three_phase_meter_qty').val();
      $('#three_phase_meter_qty_balanced').text(hidden_three_phase_meter_qty-three_phase_meter_qty);
    }
    
    function change_sim_balaned_qty()
    {
      var sim_qty = $('#sim_qty').val();
      var hidden_sim_qty = $('#hidden_sim_qty').val();
      $('#sim_qty_balanced').text(hidden_sim_qty-sim_qty);
    }

    function change_modem_balaned_qty()
    {
      var modem_qty = $('#modem_qty').val();
      var hidden_modem_qty = $('#hidden_modem_qty').val();
      $('#modem_qty_balanced').text(hidden_modem_qty-modem_qty);
    }

    function change_seal_balaned_qty()
    {
      var seal_qty = $('#seal_qty').val();
      var hidden_seal_qty = $('#hidden_seal_qty').val();
      $('#seal_qty_balanced').text(hidden_seal_qty-seal_qty);
    }
  </script>
  
@endsection