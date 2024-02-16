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
                <div class="row">
                  {{-- <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_grn_no" name="batch_grn_no" placeholder="GRN No." required="true">
                      </div>
                    </div>
                  </div> --}}
                  {{--  <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_invoice_no" name="batch_invoice_no" placeholder="Invoice No" required="true">
                      </div>
                    </div>
                  </div> --}}
                   {{-- <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="datepicker" name="batch_grn_date" placeholder="GRN Date" required="true">
                      </div>
                    </div>
                  </div> --}}
                   {{-- <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_supplier" name="batch_supplier" placeholder="Batch Supplier" required="true">
                      </div>
                    </div>
                  </div> --}}
                  
                   {{-- <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="datepicker1" name="batch_invoice_date" placeholder="Invoice Date" required="true">
                      </div>
                    </div>
                  </div> --}}
                   <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_order_no" name="batch_order_no" placeholder="Order No" required="true">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                   <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_delivery_location" name="batch_delivery_location" placeholder="Delivery Location" required="true">
                      </div>
                    </div>
                  </div>
                   <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_transporter" name="batch_transporter" placeholder="Transporter" required="true">
                      </div>
                    </div>
                  </div>
                   <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_lr_docket_no" name="batch_lr_docket_no" placeholder="LR/Docket No" required="true">
                      </div>
                    </div>
                  </div>
                   {{-- <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_waybill_no" name="batch_waybill_no" placeholder="Waybill No" required="true">
                      </div>
                    </div>
                  </div>
                   <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="datepicker2" name="batch_waybill_date" placeholder="Waybill Date" required="true">
                      </div>
                    </div>
                  </div> --}}
                   <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <input type="input" class="form-control" id="batch_vehicle_no" name="batch_vehicle_no" placeholder="Vehicle No" required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="">
                      <div class="form-group">
                        <label for="oldpassword">Upload Batch(.csv)<span style="color:red;" >*</span></label><a href="{{url('/')}}/sample_files/file_input/test_meter.csv" target="_blank">Download Sample File</a>
                        <input type="file" class="form-control" id="file" name="file" onchange="preview_image(event,1)" required="true">
                        <span id="error_file" class="parsley-required"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
    <section class="content" style="margin-top: -30px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            {{-- <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div> --}}
            <div class="box-body">
            <!-- /.box-header -->
            
            
              <table class="table table-bordered table-striped" id="example111111">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Batch ID</th>
                  <th>GRN</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php $i=1; ?>
                  @if(!empty($data1))
                  @foreach($data1 as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['batch_id']}}
                      </td>
                      <td>
                        <a href="{{url('/')}}/view_grn_batch/{{$value['batch_id']}}" target="_blank" title="View">
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
              <ul class="pagination" style="float: right;">
                  <li><a href="?page=1">First</a></li>
                  <li class="@if($page <= 1) {{'disabled'}} @endif">
                      <a href="@if($page <= 1){{'#'}} @else <?php echo "?page=".($page - 1); ?>@endif">Prev</a>
                  </li>
                  <li class="paginate_button active">
                      <a href="javascript:void(0);" >{{$page}}</a>
                  </li>
                  <li class="@if($page >= $total) {{'disabled'}} @endif">
                      <a href="@if($page >= $total) {{'#'}} @else <?php echo "?page=".($page + 1) ?>@endif">Next</a>
                  </li>
                  <li><a href="?page={{ (round($total)<=0)? '1':round($total) }}">Last</a></li>
              </ul>
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