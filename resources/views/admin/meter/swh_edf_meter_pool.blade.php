@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        {{-- <li><a href="#">Manage {{ $title }}</a></li> --}}
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @include('admin.layout._status_msg')
          <div class="box">
            {{-- <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div> --}}
            <div class="box-body">
            <!-- /.box-header -->
            <form method="GET" action="" data-parsley-validate="parsley">
              <div class="row">
                
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group1" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group1" >
                      <input type="text" class="form-control" id="search_device_phase" name="search_device_phase" value="{{isset($_GET['search_device_phase'])? $_GET['search_device_phase']: ''}}" placeholder="Device Phase">
                    </div>
                  </div>
                </div>
               {{--  <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group1" >
                      <input type="text" class="form-control" id="search_utility" name="search_utility" value="{{isset($_GET['search_utility'])? $_GET['search_utility']: ''}}" placeholder="Utility" >
                    </div>
                  </div>
                </div> --}}
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      @if(Session::get('download_enabled')=='1')<a class="btn btn-primary" href="{{url('/').'/export_report/swh_edf_meter_pool'}}">Export(.csv)</a>@endif
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" style="float: right;">
                      <b>Per Page</b>
                      <select id="limit" name="limit" onchange="change_page()">
                        <option value="10" @if(Session::get('limit')=='10') selected="" @endif>10</option>
                        <option value="50" @if(Session::get('limit')=='50') selected="" @endif>50</option>
                        <option value="100" @if(Session::get('limit')=='100') selected="" @endif>100</option>
                        <option value="200" @if(Session::get('limit')=='200') selected="" @endif>200</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <form id="form_dispatch_meter_step_1" action="{{url('/')}}/swh_form_dispatch_meter_step_1" enctype='multipart/form-data' method="POST">
              {!! csrf_field() !!}
                <div class="row">
                  <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <label>Meter(.csv)</label><br><a href="{{url('/')}}/sample_files/upload_for_assignment_against_mrn/edf_pool_meter_upload.csv" target="_blank">Download Sample File</a>
                      <input type="file" class="form-control" name="file" >
                      <span id="error_file" class="parsley-required"> </span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <label>BSNL Sim(.csv)</label><br><a href="{{url('/')}}/sample_files/upload_for_assignment_against_mrn/edf_pool_sim_upload.csv" target="_blank">Download Sample File</a>
                      <input type="file" class="form-control" name="simfile" >
                      <span id="error_file" class="parsley-required"> </span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <label>Modem(.csv)</label><br><a href="{{url('/')}}/sample_files/upload_for_assignment_against_mrn/edf_pool_modem_upload.csv" target="_blank">Download Sample File</a>
                      <input type="file" class="form-control" name="modemfile" >
                      <span id="error_file" class="parsley-required"> </span>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <label>MRN</label>
                      <select class="form-control" id="mrn" name="mrn">
                        <option value="">Select MRN</option>
                        @foreach($mrn as $value)
                          <option value="{{$value['_id']}}">{{$value['vmwh_mrn_ref']}}</option>
                        @endforeach
                      </select>
                      <span id="error_mrn" class="parsley-required"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" onclick="select_meter()" style="margin-top: 24px;">Submit</button><br>
                      <span id="error_select_sample_meter" class="parsley-required"></span>
                    </div>
                  </div>
                </div>
                
                
              </div>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="display: none;"><input type="checkbox" id="obi_id_all" name="obi_id_all"></th>
                  <th>Sr. No.</th>
                  <th>Device ID</th>
                  <th>Device Phase</th>
                  <th>Manufacturer</th>
                  <th>Batch ID</th>
                  <th>Status</th>
                  <th>Testing Type</th>
                  <th>Created At</th>
                  {{-- <th>View</th> --}}
                </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>

                  @if(count($data))
                  @foreach($data as $value)
                    <tr>
                      <td style="display: none;">
                          <input type="checkbox" name="obi_id[]" class="class_checkbox" value="{{$value['_id']}}">
                      </td>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['device_id']}}
                      </td>
                      <td>
                        {{$value['phase_type']}}
                      </td>
                      <td>
                        {{$value['batch_supplier']}}
                      </td>
                      <td>
                        {{$value['batch_id']}}
                      </td>
                      <td>
                        {{$value['batch_status']}}
                      </td>
                      <td>
                        @if($value['testing_type']=='')
                        <center>-</center>
                        @else
                        {{ucfirst($value['testing_type'])}}
                        @endif
                      </td>
                      <td>
                        {{$value['meter_created_at']}}
                      </td>
                      {{-- <td>
                        <a href="{{url('/')}}/view_{{$url_slug}}/{{$value['_id']}}" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                      </td> --}}
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="10"><center>No Record Found.</center></td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </form>
              <div style="float: right;">
                {{ $data->links() }}
              </div>
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
  <script type="text/javascript">
    function change_page() 
    {        
        var limit = $("#limit").val();            
        $.ajax({
            url: '{{url('/')}}/change_pagination_limit',
            type: 'get',
            data: {limit: limit},
            success: function (data) 
            {
              location.reload();
            }
        });
    };
    function select_meter()
    {
      var flag= false;
      var mrn = $('#mrn').val();
      if(mrn=='')
      {
        $('#error_mrn').text('Please Select MRN No.');
        flag= false;
        return false;
      }
      {
        $('#error_mrn').text('');
      }
      $(':checkbox:checked').each(function(i){
      });
          flag= true;

      if(flag)
      {
        $('#error_select_sample_meter').text('');
        $('#form_dispatch_meter_step_1').submit();
      }
      else
      {
         $('#error_select_sample_meter').text('Please select minimum one record.');
      }
    }
    $(document).ready(function(){
        $('#obi_id_all').click(function(){
            if($(this).prop("checked") == true){
               $(".class_checkbox").attr('checked', true);
            }
            else if($(this).prop("checked") == false){
               $(".class_checkbox").attr('checked', false);
            }
        });
    });
  </script>
 
@endsection