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
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group1" >
                      <input type="text" class="form-control" id="modem_number_search" name="modem_number_search" value="{{isset($_GET['modem_number_search'])? $_GET['modem_number_search']: ''}}" placeholder="Modem Number" >
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </div>
                </div>
            </form>
            <form id="form_dispatch_meter_step_1" action="{{url('/')}}/form_dispatch_meter_step_1" method="POST">
              {!! csrf_field() !!}
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
                
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Modem Number</th>
                   <th>Make</th>
                  <th>Phase</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Date</th>
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
                        {{$value['modem_number']}}
                      </td>
                       <td>
                        {{$value['make']}}
                      </td>
                      <td>
                        {{$value['phase']}}
                      </td>
                      <td>
                        {{$value['category']}}
                      </td>
                      <td>
                        {{$value['status']}}
                      </td>
                      <td>
                        {{$value['date']}}
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
          flag= true;
      });

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