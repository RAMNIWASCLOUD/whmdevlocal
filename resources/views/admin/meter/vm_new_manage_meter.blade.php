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
        <li><a href="#">Manage {{ $title }}</a></li>
        {{-- <li class="active">{{ $page_name." ".$title }}</li> --}}
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
                <div class="col-md-3" style="display: none;">
                  <div class="box-body">
                    <div class="form-group" >
                      <select class="form-control" id="search_batch" name="search_batch">
                        <option value="">Select</option>
                        @foreach($batch as $value)
                          <option value="{{$value}}" @if(isset($_GET['search_batch']) && $_GET['search_batch']==$value) selected="" @endif>{{$value}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-1">
                </div>
                <div class="col-md-6">
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
                  <th>Device ID</th>
                  <th>Manufacturer Serial No.</th>
                  <th>Device Phase</th>
                  <th>Manufacturer</th>
                  <th>Manufacturing Year</th>
                  <th>Batch ID</th>
                  <th>Status</th>
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
                      <td>
                        {{$value['device_id']}}
                      </td>
                      <td>
                        {{$value['manufacturer_serial_number']}}
                      </td>
                      <td>
                        {{$value['dlms_companion']}}
                      </td>
                      <td>
                        {{$value['device_manufacturer_abbreviation']}}
                      </td>
                      <td>
                        {{$value['device_manufacturing_year']}}
                      </td>
                      <td>
                        {{$value['batch_id']}}
                      </td>
                      <td>
                        {{$value['batch_status']}}
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
                      <td colspan="9"><center>No Record Found.</center></td>
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