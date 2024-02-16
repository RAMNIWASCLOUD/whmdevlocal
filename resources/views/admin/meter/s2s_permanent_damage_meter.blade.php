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
            <div class="box-body">
            <!-- /.box-header -->
            <div class="row">
            <form action="{{ url('/')}}/s2s_upload_prepare_resend_to_supplier_from_pd" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="oldpassword">Prepare Re-Send To Supplier(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/damage/Sample_file_meter.csv" target="_blank">Download Sample File</a>
                        <input type="file" class="form-control" id="file" name="file" onchange="preview_image(event,1)" required="true">
                        <span style="color"></span>
                        <span id="error_file" class="parsley-required"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary pull-right" style="margin-top: 24px">Submit</button>
                    </div>
                  </div>
                </form>  
              <form method="GET" action="" data-parsley-validate="parsley">
              <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" style="margin-top: 24px" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" style="margin-top: 24px" type="submit">Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      @if(Session::get('download_enabled')=='1')<a style="margin-top: 24px" class="btn btn-primary" href="{{url('/').'/export_report/s2s_permanent_damage_meter'}}">Export(.csv)</a>@endif
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
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                 {{--  <th>State Wharhouse</th> --}}
                  <th>Device ID</th>
                  <th>Device Phase</th>
                  <th>Manufacturer</th>
                  <th>Batch ID</th>
                  <th>Status</th>
                  <th>Testing Type</th>
                  <th>Created At</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>

                  @if(count($data))
                  @foreach($data as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                     {{--  <td>
                        {{$value['swh_name']}}
                      </td> --}}
                       <td>
                        {{$value['device_id']}}
                      </td>
                      <td>
                        {{$value['batch_supplier']}}
                      </td>
                      <td>
                        {{$value['phase_type']}}
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
                      <td>
                        {{-- <a href="{{url('/')}}/edit_{{$url_slug}}/{{$value['_id']}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a> --}}
                        <a href="{{url('/')}}/view_{{$url_slug}}/{{$value['_id']}}" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        {{-- <a href="{{url('/')}}/delete_{{$url_slug}}/{{$value['_id']}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a> --}}
                      </td>
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="8"><center>No Record Found.</center></td>
                    </tr>
                  @endif
                </tbody>
              </table>
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
  </script>
 
@endsection