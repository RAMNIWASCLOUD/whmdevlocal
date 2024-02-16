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
              <div class="row">
            <form method="GET" action="" data-parsley-validate="parsley">
                
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Enter Device ID" >
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
            <form id="form_segregated" action="{{url('/')}}/store_segregated" method="POST" enctype="multipart/form-data">
              <div class="col-md-2">  
                  <div class="form-group">
                    <input type="file" class="form-control" id="file" name="file" onchange="preview_image(event,1)" style="margin-top:10px;" >
                  {{--   <label for="oldpassword">Upload Meter(.csv)<span style="color:red;" >*</span></label> --}}<a href="{{url('/')}}/sample_files/file_input/sample_utility.csv" target="_blank">Download Sample File</a>
                    <span id="error_file" class="parsley-required"></span>
                  </div>
              </div>
              <div class="col-md-2" >
                  <div class="box-body">
                    <div class="form-group" >
                      <select class="form-control" id="batch" name="batch">
                        <option value="">Select Batch</option>
                        @foreach($batch as $value)
                          <option value="{{$value['batch_id']}}" @if(isset($_GET['search_batch']) && $_GET['search_batch']==$value['batch_id']) selected="" @endif>{{$value['batch_id']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
               <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <select id="utility" name="utility" class="form-control" required="">
                        <option value="">Select Utility</option>
                        <option value="NBPD">NBPDCL</option>
                        <option value="SBPD">SBPDCL</option>
                      </select>
                      <span id="error_utility" class="parsley-required"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" onclick="select_segregate()">Segregate</button><br>
                      <span id="error_segregate" class="parsley-required"></span>
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
               {!! csrf_field() !!}
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  {{-- <th><input type="checkbox" id="obi_id_all" name="obi_id_all"></th> --}}
                  <th>Sr. No.</th>
                  <th>Device ID</th>
                  <th>Device Phase</th>
                  <th>Manufacturer</th>
                  <th>Created At</th>
                  <th>View</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>

                  @if(count($data))
                  @foreach($data as $value)
                    <tr>
                      {{-- <td>
                        <input type="checkbox" id="obi_id{{$i}}" name="obi_id[]" class="class_checkbox111" value="{{$value['_id']}}">
                      </td> --}}
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['device_id']}}
                      </td>
                      <td>
                        {{$value['batch_supplier']}}
                      </td>
                      <td>
                        {{$value['phase_type']}}
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
                      <td colspan="9"><center>No Record Found.</center></td>
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
    function select_segregate()
    {
      var flag= false;
      $(':checkbox:checked').each(function(i){
          flag= true;
      });



          $('#form_segregated').submit();
      if(flag)
      {
        $('#error_segregate').text('');
        if($('#utility').val()!='')
        {
          $('#form_segregated').submit();
        }
        else
        {
         $('#error_utility').text('Please select utility.');
        }
      }
      else
      {
         //$('#error_segregate').text('Please select minimum one record.');
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
    };
     
     $(document).ready(function(){
    $('#obi_id_all').on('click',function(){
        if(this.checked){
            $('.class_checkbox111').each(function(){
                this.checked = true;
            });
        }else{
             $('.class_checkbox111').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.class_checkbox111').on('click',function(){
        if($('.class_checkbox111:checked').length == $('.class_checkbox111').length){
            $('#obi_id_all').prop('checked',true);
        }else{
            $('#obi_id_all').prop('checked',false);
        }
    });
});
  
  </script>
 
@endsection