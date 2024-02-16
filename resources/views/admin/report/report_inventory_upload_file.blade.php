@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inventory Upload File
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Inventory Upload File</a></li>
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
            <form id="reassign_form" method="GET" action="" data-parsley-validate="parsley">
              <div class="row">
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Start Date" >
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="device_phase" name="device_phase" value="{{isset($_GET['device_phase'])? $_GET['device_phase']: ''}}" placeholder="End Date" >
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" >Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" >Download</button>
                    </div>
                  </div>
                </div>
               
               
              </div>
              <div>
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Invoice No.</th>
                    <th>Invoice Date</th>
                    <th>EWAY BILL NO.</th>
                    <th>Eway Bill Date</th>
                    <th>Meter No.</th>
                    <th>Box No.</th>
                    <th>Received Date</th>
                    <th>Phase Type</th>
                    <th>Sim No.</th>
                    <th>IMEI No.</th>
                   
                  </tr>
                  </thead>
                   @if(!empty($data))
                      <tbody>
                        <?php $i = 0; ?>
                        @foreach($data as $value)
                            <tr>
                               <td>{{$i+1}}</td>
                              <td>{{$value['batch_invoice_no']}}</td>
                              <td>{{$value['batch_invoice_date']}}</td>
                              <td>{{$value['batch_waybill_no']}}</td>
                              <td>{{$value['batch_waybill_date']}}</td>
                              <td>{{$value['device_id']}}</td>
                              <td></td>
                              <td>{{$value['meter_created_at']}}</td>
                              <td>{{$value['dlms_companion']}}</td>
                              <td>{{$value['iccid']}}</td>
                              <td>{{$value['device_communication_module_imei_number']}}</td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </tbody>
                  @else
                  <tbody>
                      <tr>
                        <td colspan="11"><center>No Record Found</center> </td>
                       
                      </tr>
                  </tbody>
                  @endif
                </table>
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