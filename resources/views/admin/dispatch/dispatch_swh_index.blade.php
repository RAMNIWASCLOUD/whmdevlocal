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
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">New {{$title}}</a>
            </div> --}}
            <!-- /.box-header -->
            <form method="GET" action="" data-parsley-validate="parsley">
              <div class="row">
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="DN/Challan No." >
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
            </form>
           
              <div class="box-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>DN/Challan No.</th>
                    <th>Dispatch Date & Time</th>
                    <th><center>Delivery Mode</center></th>
                    <th><center>LR Copy</center></th>
                    {{-- <th>Delivery Proof</th> --}}
                    <th><center>Delivery Confirmed Date & Time </center></th>
                    <th><center>Delivery Confirmed</center></th>
                    <th>GRN</th>
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
                        <td>
                          {{$value['dl_ch_ref']}}
                        </td>
                        <td>
                          {{$value['dispatch_processing_date']}} & {{$value['dispatch_processing_time']}}
                        </td>
                        <td>
                          {{$value['dispatch_mode']}}
                        </td>
                        <td>
                          @if(!empty($value['lr_copy']))
                          <center>
                            <a href="{{url('/')}}{{$value['lr_copy']}}" target="_blank"><i class="fa fa-image"></i></a>
                          </center>
                          @else
                          <center>-</center>
                          @endif
                        </td>
                        <!--<td>
                          @if(!empty($value['delivery_proof']))
                          <center>
                            <a href="{{url('/')}}{{$value['delivery_proof']}}" target="_blank"><i class="fa fa-image"></i></a>
                          </center>
                          @else
                          <center>-</center>
                          @endif
                        </td>-->
                        <td>
                          @if($value['delivery_status']=='Delivered')
                            <center>{{$value['delivery_date']}} & {{$value['delivery_time']}}</center>
                          @else
                            <center>-</center>
                          @endif
                        </td>
                        <td>
                          @if($value['status']=='Dispatch Process')
                            <center>
                              <button class="btn btn-primary btn-xs" onclick="accept_dispatch('{{$value['_id']}}')">Accept</button>
                              {{-- <a class="btn btn-primary btn-sm" href="{{url('/')}}/accept_dispatch_swh/{{$value['_id']}}" title="Accept">Accept</a> --}}
                            </center>
                          @elseif($value['status']=='Rejected')
                            <center>
                            <button type="button" class="btn btn-danger btn-flat btn-xs"><b>&#10006;</b></button>
                            </center>
                          @else


                            <center>
                            {{--$value['delivery_status']--}}
                            <button type="button" class="btn btn-success btn-flat btn-xs"><b>&#10003;</b></button>
                             
                            </center>
                          @endif
                        </td>
                        <td>
                          <a href="{{url('/')}}/view_grn_{{$url_slug}}/{{$value['_id']}}" title="GRN" target="_blank"><i class="fa fa-file-pdf-o" style="color: red;"></i></a>
                          
                        </td>
                        <td>
                          <a href="{{url('/')}}/view_{{$url_slug}}/{{$value['_id']}}" title="View" target="_blank"><i class="fa fa-file-pdf-o" style="color: red;"></i></a>
                          
                        </td>
                      </tr>
                    <?php $i++; ?>
                    @endforeach
                    @else
                      <tr>
                        <td colspan="8"><center>No Record Found.</center></td>
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
  <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Accept Dispach</h4>
              </div>
              <div class="modal-body">
                <form action="{{ url('/')}}/store_accept_dispatch_swh" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <input type="hidden" id="hidden_id" name="id" value="">
              <div class="row" >
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Status<span style="color:red;" >*</span></label>
                      <select id="status" name="status" class="form-control" required="">
                        <option value="">Select</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_file" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Delivery Proof<span style="color:red;" >*</span></label>
                      <input type="file" id="file" name="file" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_reason" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Reason<span style="color:red;" >*</span></label>
                      <select id="reason" name="reason" class="form-control">
                        <option value="">Select</option>
                        @foreach($reason as $value)
                          <option value="{{$value['reason']}}">{{$value['reason']}}</option>
                        @endforeach
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
      if(status=='Rejected')
      {
        $('#div_reason').show();
        $('#div_file').hide();
        $('#reason').prop('required',true);
        $('#file').prop('required',false);
      }
      else
      {
        $('#div_file').show();
        $('#div_reason').hide();
        $('#reason').prop('required',false);
        $('#file').prop('required',true);
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