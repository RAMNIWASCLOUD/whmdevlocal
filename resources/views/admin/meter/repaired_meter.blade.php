@extends('admin.layout.master')
 
@section('content')
<?php use \MongoDB\BSON\ObjectID as MongoId; 
?>
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
            <div class="row">
                  <form action="{{ url('/')}}/upload_prepare_resend_to_supplier" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="col-md-2">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="oldpassword">Prepare Re-Send To Supplier(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/damage/admin_prepare_resend_to_supplier_damaged_meter.csv" target="_blank">Download Sample File</a>
                        <input type="file" class="form-control" id="file1" name="file" onchange="preview_image(event,1)" required="true">
                        <span style="color"></span>
                        <span id="error_file1" class="parsley-required"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary pull-right" style="margin-top: 64px">Submit</button>
                    </div>
                  </div>
                  </form>
                  <form action="{{ url('/')}}/upload_permanent_damage" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                  <div class="col-md-2">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="oldpassword">Mark Permanent damage(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/s2s_damage/Sample_file_meter.csv" target="_blank">Download Sample File</a>
                        <input type="file" class="form-control" id="file2" name="file" onchange="preview_image(event,2)" required="true">
                        <span style="color"></span>
                        <span id="error_file2" class="parsley-required"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary pull-right" style="margin-top: 64px">Submit</button>
                    </div>
                  </div>
                  </form>
                  <form method="GET" action="" data-parsley-validate="parsley">
                <div class="col-md-2" style="margin-top: 64px">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-1" style="margin-top: 64px">
                  <div class="box-body">
                      <button class="btn btn-primary pull-right" type="submit">Search</button>                    
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      @if(Session::get('download_enabled')=='1')<a style="margin-top: 64px" class="btn btn-primary" href="{{url('/').'/export_report/repaired_meter'}}">Export(.csv)</a>@endif
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
            </form>
                </div>
                <!-- /.box-body -->
            {{-- <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div> --}}
            <div class="box-body">
            <!-- /.box-header -->
              <div class="row">
               
            
              </div>
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Device ID</th>
                  <th>Manufacturer Serial No.</th>
                  <th>Device Phase</th>
                  <th>Manufacturer</th>
                  <th>Damaged Reported By</th>
                  <th>Damaged Date</th>
                  <th>Repaired Time</th>
                  <th>Status</th>
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
                        {{$value['phase_type']}}
                      </td>
                      <td>
                        {{$value['batch_supplier']}}
                      </td>
                      
                      <td>
                        <?php
                        $user = '';
                        if(!empty($value['sm_damaged_mark_by_id']))
                        {
                          $user = \DB::table('login_users')->where(['_id'=>new MongoId($value['sm_damaged_mark_by_id'])])->first(); 
                        } 
                        ?>
                        {{ (!empty($user))? $user['warehouse_name']:'NA'}}
                      </td>
                      <td>
                        {{$value['sm_damaged_mark_by_time']}}
                      </td>
                      <td>
                        {{$value['repaired_time']}}
                      </td>
                       <td>
                        {{$value['damaged_status']}}
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
    }

     function preview_image(event,id) 
        {   
            var input_id = event.target.id
            var fileInput = document.getElementById(input_id);
            //var filePath = event.path[0].files[0].name;
            var filePath = fileInput.value;
            var allowedExtensions = /(\.csv)$/i;
            if(!allowedExtensions.exec(filePath))
            {
                fileInput.value = '';
                $("#error_file"+id).text('Please upload file having extensions .csv only.');
                
                $('#file'+id).attr("src",'');
                return false;
            }
            else
            {
                //Image preview
                var reader = new FileReader();
                reader.onload = function()
                {
                    var output = document.getElementById('file'+id);
                    output.src = reader.result;
                }
                $("#error_file"+id).text('');
                reader.readAsDataURL(event.target.files[0]);
            }
        }
  </script>
 
@endsection