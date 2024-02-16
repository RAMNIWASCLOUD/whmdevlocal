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
                   <div class="col-md-12">
                      <div class="form-group" id="div_id">
                        <center><img src="{{url('/')}}/css_and_js/filetransfer.gif"><br>Process will take a minute.</center>
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
    $( document ).ready(function() {
        $.ajax({
            url: '{{url('/')}}/dumps_proccess_ajax/{{$id}}',
            type: 'get',
            success: function (data) 
            {
              $('#div_id').html('<center><a href="'+data+'">Click Here</a><br>Downloadable link is available.</center>');
            }
        });
    });
  </script>
@endsection