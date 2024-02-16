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
              <div class="row">
                <form action="{{ url('/')}}/tagging_refurbish" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
                   {!! csrf_field() !!}

                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="oldpassword">Tag Refurbish(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/damage/Sample_file_meter.csv" target="_blank">Download Sample File</a>
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
                <form action="{{ url('/')}}/tagging_non_refurbish" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
                   {!! csrf_field() !!}

                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="oldpassword">Tag Non-Refurbish(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/damage/Sample_file_meter.csv" target="_blank">Download Sample File</a>
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
              </div>
            <form id="reassign_form" method="GET" action="" data-parsley-validate="parsley">
              <div class="row">
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="device_phase" name="device_phase" value="{{isset($_GET['device_phase'])? $_GET['device_phase']: ''}}" placeholder="Enter Device Phase" >
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" onclick="search_form_submit()">Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <?php $admin = \DB::table('login_users')->where(['role'=>'1'])->get(); ?>
                      <select class="form-control" id="assignee"  name="assignee" required="">
                        <option value="">Select </option>
                        @foreach($admin as $value)
                        <option value="{{$value['_id']}}">{{$value['username']}}({{$value['warehouse_name']}})</option>
                        @endforeach
                      </select>
                      <span id="error_span" style="color: red;"></span>
                      {{-- <input type="text" class="form-control" id="device_phase" name="device_phase" value="{{isset($_GET['device_phase'])? $_GET['device_phase']: ''}}" placeholder="Enter Device Phase" > --}}
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" onclick="assign_form_submit()">Submit</button>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-1">
                </div>
                <div class="col-md-1">
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
            
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><input type="checkbox" name="all" id="checkall" onClick="check_uncheck_checkbox(this.checked);" /></th>
                  <th>Sr. No.</th>
                  <th>Device ID</th>
                  <th>Device Phase</th>
                  <th>Manufacturer</th>
                  <th>Batch ID</th>
                  <th>Status</th>
                  <th>Testing Type</th>
                  <th>Created At</th>
                  <th>Last Location</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php $i=1; ?>
                  @if(count($data))
                  @foreach($data as $value)

                    <tr>
                      <td>
                       
                          <input type="checkbox" id="checkbox_id" name="checkbox_id[]" onclick="check_box_click()" value="{{$value['_id']}}">
                       
                      </td>

                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['device_id']}}
                      </td>
                      <td>
                       
                      </td>
                      <td>
                        
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
                        {{(!empty($value['last_meter_location']))? $value['last_meter_location']:'Main Warehouse'}}
                      </td>
                      <td>
                        <a href="{{url('/')}}/edit_{{$url_slug}}/{{$value['_id']}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
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

    function search_form_submit()
    {
       $("#assignee").attr("required", false);
        document.getElementById("reassign_form").action = "{{url('/')}}/manage_meter";
        document.getElementById("reassign_form").submit();
    }

    function assign_form_submit()
    {
        //$("#assignee").attr("required", true);
      
        var checkboxes = document.getElementsByName('checkbox_id[]');
        var selected = [];
        var flag = false;
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selected.push(checkboxes[i].value);
                flag = true;
            }
        } 

        if(!flag)
        {
          document.getElementById("error_span").innerHTML="Please select minimum one checkboxe.";
        }
        else
        {
          if($("#assignee").val()=='')
          {
            document.getElementById("error_span").innerHTML="This value is required.";
          }
          else
          {
            document.getElementById("error_span").innerHTML="";
            document.getElementById("reassign_form").action = "{{url('/')}}/get_meter_to_admin_pool";
            document.getElementById("reassign_form").submit();
          }
        }

    }
      function check_uncheck_checkbox(isChecked) {
          if(isChecked) {
            $('input[name="checkbox_id[]"]').each(function() { 
              this.checked = true; 
            });
          } else {
            $('input[name="checkbox_id[]"]').each(function() {
              this.checked = false;
            });
          }
        }
  </script>
 
@endsection