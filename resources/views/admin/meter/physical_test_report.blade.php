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
              <table id="example111" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Batch ID</th>
                  <th>Batch Testing(%)</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>

                  @if($total!=0)
                  @foreach($data as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['batch_id']}}
                      </td>
                      <td>
                        {{$value['percentage']}}
                      </td>
                      <td>
                        <a href="{{url('/')}}/manage_physical_testing_meter/{{$value['batch_id']}}" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a onclick="accept_dispatch('{{$value['batch_id']}}')"><i class="fa fa-cog"></i></a>
                      </td>
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="4"><center>No Record Found.</center></td>
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
 <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Process Batch</h4>
              </div>
              <div class="modal-body">
                <form action="{{ url('/')}}/store_physical_testing_batch_status" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <input type="hidden" id="hidden_id" name="hidden_id" value="">
              <div class="row" >
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Status<span style="color:red;" >*</span></label>
                      <select id="status" name="status" class="form-control" onchange="status_change()" required="">
                        <option value="">Select</option>
                        <option value="Tested">Tested</option>
                        <option value="Damaged">Damaged</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_reason" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Reason<span style="color:red;" >*</span></label>
                      <select id="reason" name="reason" class="form-control">
                        <option value="">Select</option>
                        <option value="Door damage">Door damage</option>
                        <option value="Meter lock damage">Meter lock damage</option>
                        <option value="Meter cabinet damaged">Meter cabinet damaged</option>
                        
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form> 
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  <script type="text/javascript">
    function accept_dispatch($id)
    {
      $('#modal-default').modal('show');
      $('#hidden_id').val($id);
    }

    function status_change()
    {
      var status = $('#status').val();
      if(status=='Damaged')
      {
        $('#div_reason').show();
        $('#reason').prop('required',true);
      }
      else
      {
        $('#div_reason').hide();
        $('#reason').prop('required',false);
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
  </script>
 
@endsection