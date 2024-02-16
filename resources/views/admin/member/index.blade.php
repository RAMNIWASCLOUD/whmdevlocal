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
            <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div>
            <!-- /.box-header -->
            <form method="GET" id="reassign_form" action="" data-parsley-validate="parsley">
              <div class="row">
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Ex. Username" required="true">
                      <span id="error_assignee_search" class="parsley-required" style="position: absolute;width: 219px;"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group">
                      <button class="btn btn-primary" type="button" onclick="form_submit1()">Search</button>

                    </div>
                  </div>
                </div>
                 <!--<div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <?php  $assignee = \DB::table('login_users')->where(['role'=>'4'])->get(); ?>
                      <?php  $assignee1 = \DB::table('login_users')->where(['role'=>'5'])->get(); ?>
                      <select id="assignee" name="assignee" class="form-control">
                        <option value="">Select MRN Authorized 1</option>
                        @foreach($assignee as $value)
                        <option value="{{$value['_id']}}">{{$value['username']}}</option>
                        @endforeach
                      </select>
                      <span id="error_assignee" class="parsley-required"></span>
                    </div>
                  </div>
                </div>-->
                {{-- <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <select id="assignee1" name="assignee1" class="form-control">
                        <option value="">Select MRN Authorized 2</option>
                        @foreach($assignee1 as $value)
                        <option value="{{$value['_id']}}">{{$value['username']}}</option>
                        @endforeach
                      </select>
                      <span id="error_assignee1" class="parsley-required"></span>
                    </div>
                  </div>

                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group">
                      <button class="btn btn-primary" type="button" onclick="form_submit()">Assign</button>
                      <br><span id="error_assignee3" class="parsley-required" style="position: absolute;width: 219px;"></span>
                    </div>
                  </div>
                </div> --}}
                <div class="col-md-9">
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
              
            
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  {{-- <th><input type="checkbox" name="all" id="checkall" onClick="check_uncheck_checkbox(this.checked);" /></th> --}}
                  <th>Sr. No.</th>
                  <th>Warehouse Name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>

                 @if(count($data))
                  @foreach($data as $value)
                    <tr>
                      <!--<td>
                        @if($value['role']=='3')
                          <input type="checkbox" id="checkbox_id" name="checkbox_id[]" onclick="check_box_click()" value="{{$value['_id']}}">
                        @endif
                      </td>-->
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['warehouse_name']}}
                      </td>
                      <td>
                        {{$value['username']}}
                      </td>
                      <td>
                        @if($value['role']=='1')
                          Admin
                        @elseif($value['role']=='2')
                          State Warehouse Manager
                        @elseif($value['role']=='3')
                          VM Warehouse Manager
                        @elseif($value['role']=='6')
                          Supplier
                        @endif
                      </td>
                      <td>
                        <a href="{{url('/')}}/edit_{{$url_slug}}/{{$value['_id']}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{url('/')}}/view_{{$url_slug}}/{{$value['_id']}}" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{url('/')}}/delete_{{$url_slug}}/{{$value['_id']}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a>
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
              <div style="float: right;">
                {{ $data->links() }}
              </div>
            </div>
            </form>
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
     function check_box_click()
    {
      var count = 0; 
      $.each($("input[name='checkbox_id[]']:checked"), function(){  
          count ++;  
      });
      $('#multiselection_count').text(count);
    }
     function check_uncheck_checkbox(isChecked) {
      var count = 0; 
  if(isChecked) {
    $('input[name="checkbox_id[]"]').each(function() { 
      this.checked = true; 
      count++;
    });
    $('#multiselection_count').text(count);
  } else {
    $('input[name="checkbox_id[]"]').each(function() {
      this.checked = false;
    });
    $('#multiselection_count').text(0);
  }
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
    }

    function form_submit()
    {
      var assignee= document.getElementById("assignee").value;
      var assignee1= document.getElementById("assignee1").value;
     
      if(assignee=='')
      {
        document.getElementById("error_assignee").innerHTML="This field is required.";
      }
      else if(assignee1=='')
      {
        document.getElementById("error_assignee1").innerHTML="This field is required.";
      }
      else
      {
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
          document.getElementById("error_assignee3").innerHTML="Please select minimum one checkboxe.";
        }
        else
        {
          document.getElementById("error_assignee3").innerHTML="";
          document.getElementById("reassign_form").action = "{{url('/')}}/assign_mrn_authority";
          document.getElementById("reassign_form").submit();
        }
      }

    }
    function form_submit1()
    {
      var assignee= document.getElementById("search").value;
      
      if(assignee=='')
      {
        document.getElementById("error_assignee_search").innerHTML="This field is required.";
      }
      else
      {
        document.getElementById("reassign_form").action = "";
        document.getElementById("reassign_form").submit();

      }
    }
  </script>
 
@endsection