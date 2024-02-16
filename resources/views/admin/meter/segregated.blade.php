@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name }}
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">{{ $page_name }}</a></li>
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
             <form action="{{ url('/')}}/change_utility" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
             
              {!! csrf_field() !!}
              <div class="row" style="display: none;">
                  <div class="col-md-4">  
                      <div class="form-group">
                        <label for="oldpassword">Upload Meter(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/sample_utility.csv" target="_blank">Download Sample File</a>
                        <input type="file" class="form-control" id="file" name="file" onchange="preview_image(event,1)" required="true">
                        <span id="error_file" class="parsley-required"></span>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group" >
                        <label for="oldpassword">Utility<span style="color:red;" >*</span></label>
                        <select id="utility" name="utility" class="form-control" required="">
                          <option value="">Select Utility</option>
                          <option value="NBPD">NBPDCL</option>
                          <option value="SBPD">SBPDCL</option>
                        </select>
                        <span id="error_utility" class="parsley-required"></span>
                      </div> 
                  </div>
                  <div class="col-md-1">  
                    <button type="submit" style="margin-top: 24px;" class="btn btn-primary pull-right">Submit</button>
                </div>

              </div>
            </form>
            <form method="GET" action="" data-parsley-validate="parsley">
              <div class="row"  >
                <div class="col-md-3" style="display: none;">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
                    </div>
                  </div>
                </div>
                <div class="col-md-5" style="display: none;">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-9">
                </div>
                <div class="col-md-3" >
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
                  <th>Utility</th>
                  {{-- <th>System Utility Id</th> --}}
                  <th>Time</th>
                  <th><center>MDM/HES</center></th>
                  <th>MDM/HES Updated Time</th>
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
                      {{-- <td>
                        {{$value['utility_time']}}
                      </td> --}}
                      <td>
                        {{$value['utility']}}
                      </td>
                      <td>
                        {{date('d-m-Y h:i:s',$value['utility_time'])}}
                      </td>
                      <td>
                        @if($value['mdm_hes']=='no')
                        <center>
                          <input type="checkbox" onclick='mdm_hes_function({{"'".$value['_id']."'"}})' value="{{$value['_id']}}">
                        </center>
                        @else
                          <center><button type="button" class="btn btn-success btn-flat btn-xs"><b>&#10003;</b></button></center>
                        @endif
                      </td>
                      <td>
                        @if($value['mdm_hes_time']=='-')
                        <center>-</center>
                        @else
                        {{date('d-m-Y h:i:s',$value['mdm_hes_time'])}}
                        @endif
                      </td>
                      <td>
                        <a class="btn btn-primary btn-xs" href="{{url('/')}}/segregated_hesm/{{ $value['utility_time'] }}">HESM</a>
                        <a class="btn btn-primary btn-xs" href="{{url('/')}}/segregated_hess/{{ $value['utility_time'] }}">HESS</a>
                        <a class="btn btn-primary btn-xs" href="{{url('/')}}/segregated_hesms/{{ $value['utility_time'] }}">HESMS</a>
                        <a class="btn btn-primary btn-xs" href="{{url('/')}}/segregated_mdmm/{{ $value['utility_time'] }}">MDMM</a>
                        <a class="btn btn-primary btn-xs" href="{{url('/')}}/segregated_mdms/{{ $value['utility_time'] }}">MDMS</a>
                        <a class="btn btn-primary btn-xs" href="{{url('/')}}/segregated_mdmsm/{{ $value['utility_time'] }}">MDMSM</a>
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
    function mdm_hes_function(id)
    {        
        $.ajax({
            url: '{{url('/')}}/mdm_hes_update',
            type: 'post',
            data: {"_token": "{{ csrf_token() }}",id: id},
            success: function (data) 
            {
              location.reload();
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
  </script>
 
@endsection