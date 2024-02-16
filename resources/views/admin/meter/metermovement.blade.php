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
            <form id="reassign_form" method="GET" action="" data-parsley-validate="parsley" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-2">
                  <div >
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div >
                    <div class="form-group" >
                      <input type="text" class="form-control" id="device_phase" name="device_phase" value="{{isset($_GET['device_phase'])? $_GET['device_phase']: ''}}" placeholder="Enter Device Phase" >
                    </div>
                  </div>
                </div>
                 <?php 
                 $sm = \DB::table('login_users')->where(['role'=>'2'])->orderBy('username','ASC')->get();
                 $vm = \DB::table('login_users')->where(['role'=>'3'])->orderBy('username','ASC')->get();
                  ?>
                <div class="col-md-2">
                  <div >
                    <div class="form-group" >
                      <select class="form-control" name="sm">
                        <option value="">Select SW</option>
                        @foreach($sm as $value)
                        <option @if(isset($_GET['sm']) && $value['_id']==$_GET['sm']) selected="" @endif value="{{$value['_id']}}">{{$value['username']}}({{$value['warehouse_name']}})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                 
                </div>
                
                <div class="col-md-2">
                  <div >
                    <div class="form-group" >
                      <select class="form-control" name="vm">
                        <option value="">Select VM Warehouse</option>
                        @foreach($vm as $value)
                        <option @if(isset($_GET['vm']) && $value['_id']==$_GET['vm']) selected="" @endif value="{{$value['_id']}}">{{$value['username']}}({{$value['warehouse_name']}})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                 
                </div>
                <div class="col-md-1">
                  <div >
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" onclick="search_form_submit()">Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div >
                    <div class="form-group" >
                      <a href="{{url('/')}}/metermovement" class="btn btn-primary">Reset Filter</a>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-1">
                </div>
                <div class="col-md-1">
                  <div >
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
              <div class="row">
               
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-3">
                      <div >
                        <div class="form-group">
                          <input type="file" class="form-control" id="file" name="file" onchange="preview_image(event,1)" required="true">
                          <label for="oldpassword" style="white-space: nowrap;">Upload Meter(.csv)<span style="color:red;" >*</span></label>
                          <a style="white-space: nowrap;" href="{{url('/')}}/sample_files/file_input/accept_meter.csv" target="_blank">Download Sample File</a>
                          <span style="color"></span>
                          <span id="error_file" class="parsley-required"></span>
                        </div>
                      </div>
                    </div>
                   <div class="col-md-3">
                    <div >
                      <div class="form-group" >
                        <select class="form-control" id="select_sw" name="select_sw" onchange="function_select_sw()">
                          <option value="">Select SW</option>
                          @foreach($sm as $value)
                          <option value="{{$value['_id']}}">{{$value['username']}}({{$value['warehouse_name']}})</option>
                          @endforeach
                        </select>
                        <span id="error_span2" style="color: red;"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div >
                      <div class="form-group" >
                        <select class="form-control" id="select_sw_mrn" name="select_sw_mrn">
                          <option value="">Select MRN</option>
                        </select>
                        <span id="error_span3" style="color: red;"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div >
                      <div class="form-group" >
                        <button class="btn btn-primary" type="button" onclick="assign_form_submit()">Submit</button>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
              <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-3">
                      <div >
                        <div class="form-group">
                          <input type="file" class="form-control" id="file1" name="file1" onchange="preview_image(event,1)" required="true">
                          <label for="oldpassword" style="white-space: nowrap;">Upload Meter(.csv)<span style="color:red;" >*</span></label>
                          <a style="white-space: nowrap;" href="{{url('/')}}/sample_files/file_input/accept_meter.csv" target="_blank">Download Sample File</a>
                          <span style="color"></span>
                          <span id="error_file4" class="parsley-required"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div >
                        <div class="form-group" >
                          <select class="form-control" id="select_vm" name="select_vm" onchange="function_select_vm()">
                            <option value="">Select VM Warehouse</option>
                            @foreach($vm as $value)
                            <option value="{{$value['_id']}}">{{$value['username']}}({{$value['warehouse_name']}})</option>
                            @endforeach
                          </select>
                          <span id="error_span5" style="color: red;"></span>
                        </div>
                      </div>
                    </div>       
                     <div class="col-md-3">
                      <div >
                        <div class="form-group" >
                          <select class="form-control" id="select_vm_mrn" name="select_vm_mrn">
                            <option value="">Select MRN</option>
                          </select>
                          <span id="error_span6" style="color: red;"></span>
                        </div>
                      </div>
                    </div>                
                    <div class="col-md-1">
                      <div >
                        <div class="form-group" >
                          <button class="btn btn-primary" type="button" onclick="assign_form_submit1()">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                 {{--  <th><input type="checkbox" name="all" id="checkall" onClick="check_uncheck_checkbox(this.checked);" /></th> --}}
                  <th>Sr. No.</th>
                  <th>Device ID</th>
                  <th>Manufacturer Serial No.</th>
                  <th>Device Phase</th>
                  <th>State Warehouse</th>
                  <th>Vendor Warehouse</th>
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
                      <!--<td>
                       
                          <input type="checkbox" id="checkbox_id" name="checkbox_id[]" onclick="check_box_click()" value="{{$value['_id']}}">
                       
                      </td>-->
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
                       
                        @if(!empty($value['swh_name']))
                        {{$value['swh_name']}}
                        @else
                        -
                        @endif
                      </td>
                      <td>
                        @if(!empty($value['vmwh_name']))
                        {{$value['vmwh_name']}}
                        @else
                        -
                        @endif
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
                      <td colspan="10"><center>No Record Found.</center></td>
                    </tr>
                  @endif
                </tbody>
              </table>
              <div style="float: right;">
                {{ $data->links() }}
              </div>
            </form>
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

    

    function function_select_sw() 
    {        
        var id = $("#select_sw").val();            
        $.ajax({
            url: '{{url('/')}}/get_sm_mrn',
            type: 'get',
            data: {id: id},
            success: function (data) 
            {
              $("#select_sw_mrn").html(data);
            }
        });
    }

    function function_select_vm() 
    {        
        var id = $("#select_vm").val();            
        $.ajax({
            url: '{{url('/')}}/get_vm_mrn',
            type: 'get',
            data: {id: id},
            success: function (data) 
            {
              $("#select_vm_mrn").html(data);
            }
        });
    }

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
      $("#reassign_form").attr("method", 'GET');
        document.getElementById("reassign_form").action = "{{url('/')}}/metermovement";
        document.getElementById("reassign_form").submit();
    }

    function assign_form_submit()
    {
        //$("#assignee").attr("required", true);
      
      
        if(document.getElementById("file").files.length == 0 )
        {
          document.getElementById("error_file").innerHTML="Please select meter file.";
        }
        else
        {
            document.getElementById("error_file").innerHTML="";

          if($("#select_sw").val()=='')
          {
            document.getElementById("error_span2").innerHTML="This value is required.";
          }
          else if($("#select_sw_mrn").val()=='')
          {
            document.getElementById("error_span3").innerHTML="This value is required.";
            document.getElementById("error_span2").innerHTML="";
          }
          else
          {
            document.getElementById("error_span2").innerHTML="";
            $("#reassign_form").attr("method", 'POST');
            document.getElementById("reassign_form").action = "{{url('/')}}/send_meter_to_sm_pool";
            document.getElementById("reassign_form").submit();
          }
        }

    }

    function assign_form_submit1()
    {
        //$("#assignee").attr("required", true);
      
      
        if(document.getElementById("file1").files.length == 0 )
        {
          document.getElementById("error_file4").innerHTML="Please select meter file.";
        }
        else
        {
            document.getElementById("error_file4").innerHTML="";

          if($("#select_vm").val()=='')
          {
            document.getElementById("error_span5").innerHTML="This value is required.";
          }
          else if($("#select_vm_mrn").val()=='')
          {
            document.getElementById("error_span5").innerHTML="";
            document.getElementById("error_span6").innerHTML="This value is required.";
          }
          else
          {
            document.getElementById("error_span5").innerHTML="";
            $("#reassign_form").attr("method", 'POST');
            document.getElementById("reassign_form").action = "{{url('/')}}/send_meter_to_vm_pool";
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