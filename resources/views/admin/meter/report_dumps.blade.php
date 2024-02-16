@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       {{--  <li><a href="{{url('/')}}/manage_category">Manage {{ $title }}</a></li> --}}
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="row" style="height: 600px;">
                 
                   <div class="col-md-6">
                    <div class="">
                      <div class="form-group">
                        
                        <ul style="list-style-type: lower-alpha;font-size: 18px;">
                          <li><strong>Meter dump files</strong>
                            <ul>
                              <li>NBPD Meter Link: <a href="{{url('/')}}/dumps_proccess/1">Click Here</a></li>
                              <li>SBPD Meter Link: <a href="{{url('/')}}/dumps_proccess/2">Click Here</a></li>
                              <li>Non-NBPD/SBPD Link: <a href="{{url('/')}}/dumps_proccess/3">Click Here</a></li>
                            </ul>
                          </li>
                          <li><strong>Sim dump file</strong> 
                            <ul>
                              <li>Batch 1:<a href="{{url('/')}}/dumps_proccess/4">Click Here</a></li>
                              <li>Batch 2:<a href="{{url('/')}}/dumps_proccess/5">Click Here</a></li>
                            </ul>
                          </li>
                          <li><strong>Modem dump file</strong> <a href="{{url('/')}}/dumps_proccess/6">Click Here</a></li>
                          <li><strong>S2S dump file</strong> <a href="{{url('/')}}/dumps_proccess/111">Click Here</a></li>
                        </ul>
                          
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->

      
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