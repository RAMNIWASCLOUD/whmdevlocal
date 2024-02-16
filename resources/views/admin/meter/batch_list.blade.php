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
            
            
              <table class="table table-bordered table-striped" id="example1">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Batch ID</th>
                  <th>GRN</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php $i=1; ?>
                  @if(!empty($data))
                  @foreach($data as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['batch_id']}}
                      </td>
                      <td>
                        <a href="{{url('/')}}/view_grn_batch/{{$value['batch_id']}}" title="View">
                          <i class="fa fa-file-pdf-o" style="color: red;"></i>
                        </a>
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