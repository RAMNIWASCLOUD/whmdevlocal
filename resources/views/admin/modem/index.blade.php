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
            <!-- /.box-header -->
            <form action="{{ url('/')}}/store_modem" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
            
              {!! csrf_field() !!}
              
              
                  <div class="row">
                    <div class="col-md-4">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="oldpassword">Upload Batch(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/test_modems.csv" target="_blank">Download Sample File</a>
                         {{--  <a href="{{url('/')}}/sample_files/file_input/Worksheet in C  Users dell Desktop suraj WHM_01062021" target="_blank">Download Sample File</a> --}}
                          
                          <input type="file" class="form-control" id="file" name="file" onchange="preview_image(event,1)" required="true">
                          <span id="error_file" class="parsley-required"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1">
                       <div class="box-body">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary " style="margin-top: 25px">Submit</button>
                        </div>
                      </div>
                    </div>
            </form>
            <form method="GET" action="" data-parsley-validate="parsley">
              
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" style="margin-top: 25px" placeholder="Enter Modem IMEI Number" >
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" style="margin-top: 25px" type="submit">Search</button>
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
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Modem IMEI Number</th>
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
                      <td colspan="7"><center>No Record Found.</center></td>
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
   <script type="text/javascript">
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
                $("#error_file").text('Please upload file having extensions .csv only.');
                
                $('#file').attr("src",'');
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
                $("#error_file").text('');
                reader.readAsDataURL(event.target.files[0]);
            }
        }
  </script>
 
@endsection