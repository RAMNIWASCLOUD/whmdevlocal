@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $title }}
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">{{ $title }}</a></li>
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
            <form method="GET" action="" data-parsley-validate="parsley">
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Ex. MRN Ref." required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group">
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
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
                  <th>MRN Ref.</th>
                  <th>Kind Attn</th>
                  <th>Mobile No.</th>
                  <th>Location</th>
                  <th>MRN Process Date & Time</th>
                  <th>Status</th>
                  <th>Action</th>
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
                        {{$value['vmwh_mrn_ref']}}
                      </td>
                      <td>
                        {{$value['kind_attn']}}
                      </td>
                      <td>
                        {{$value['mobile_no']}}
                      </td>
                      <td>
                        {{$value['location']}}
                      </td>
                      <td>
                        {{$value['mrn_processing_date']}} & {{$value['mrn_processing_time']}}
                      </td>
                      <td>
                        @if($value['mrn_authorized_1_status']=='Pending')
                          <a href="#" onclick="function_model('{{$value['_id']}}')"><span class="badge bg-yellow">{{$value['mrn_authorized_1_status']}}</span></a>
                        @else
                          <a href="#" ><span class="badge bg-green">{{$value['mrn_authorized_1_status']}}</span></a>
                        @endif
                        
                      </td>
                      <td>
                        <a href="{{url('/')}}/edit_vm_mrn/{{$value['_id']}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>

                        {{-- <a href="{{url('/')}}/view_swh_{{$url_slug}}/{{$value['_id']}}" title="View" target="_blank">
                          <i class="fa fa-file-pdf-o" style="color: red;"></i>
                        </a> --}}
                        {{-- <a href="{{url('/')}}/delete_{{$url_slug}}/{{$value['_id']}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a> --}}
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
  <div class="modal login" id="function_model_id">
  <div class="modal-dialog">

    <form action="{{ url('/')}}/status_update_mrn_a_1" method="post" data-parsley-validate="parsley">
      {!! csrf_field() !!}
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><center>Approve MRN</center>  </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="form-group">
        <label for="email">Status:</label>
        <select class="form-control" id="status" name="status" onchange="function_status()" required="">
          <option value="">Select</option>
          <option value="Approve">Approve</option>
          <option value="Reject">Reject</option>
        </select>
      </div>
      <div class="form-group" id="r_id" style="display: none;">
        <label for="email">Reject Reason:</label>

        <input type="hidden" class="form-control" id="mrn_id" name="mrn_id">
        <input type="text" class="form-control" placeholder="Please Reject Reason" id="reason" name="reason">
      </div>
      <center>
        <button class="btn btn-primary submit" type="submit">Submit</button>
      </center>
      </div>
    </div>
    </form>
  </div>
</div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    function function_status()
    {
      var status = $('#status').val();
      if(status=='Approve')
      {
        $('#r_id').hide();
        $('#reason').prop('required',false);
      }
      else
      {
        $('#r_id').show();
        $('#reason').prop('required',true);
      }
      
    }

    function function_model(id) 
    {

       $('#mrn_id').val(id);
       $('#function_model_id').modal('show');
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