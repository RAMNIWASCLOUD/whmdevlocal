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
        <li><a href="#">{{ $page_name." ".$title }}</a></li>
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
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Ex. MRN Ref." >
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="location" name="location" value="{{isset($_GET['location'])? $_GET['location']: ''}}" placeholder="Location" >
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="box-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="kind_attn" name="kind_attn" value="{{isset($_GET['kind_attn'])? $_GET['kind_attn']: ''}}" placeholder="Kind Attn" >
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
                
                <div class="col-md-3">
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
                  <th>1 Phase Meter Qty.</th>
                  <th>3 Phase Meter Qty.</th>
                  <th>Sim Qty.</th>
                  <th>Modem Qty.</th>
                  <th>Antenna Qty.</th>
                  <th>Delivery Proof</th>
                  <th>LR Copy</th>
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
                        @if(!empty($value['mrn_ref']))
                          {{$value['mrn_ref']}}
                        @else
                          {{$value['vmwh_mrn_ref']}}
                        @endif
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
                        {{ (!empty($value['single_phase_meter_qty']))? $value['single_phase_meter_qty']:'-'}}
                      </td>
                      <td>
                        {{ (!empty($value['three_phase_meter_qty']))? $value['three_phase_meter_qty']:'-'}}
                      </td>
                      <td>
                        {{ (!empty($value['sim_qty']))? $value['sim_qty']:'-'}}
                      </td>
                      <td>
                        {{ (!empty($value['modem_qty']))? $value['modem_qty']:'-'}}
                      </td>
                      <td>
                        {{ (!empty($value['seal_qty']))? $value['seal_qty']:'-'}}
                      </td>
                      <td>
                          @if(!empty($value['mrn_ref']))
                            @if(!empty($value['delivery_proof']))
                            <center>
                              <a href="{{url('/')}}{{$value['delivery_proof']}}" target="_blank"><i class="fa fa-image"></i></a>
                            </center>
                            @else
                            <center>-</center>
                            @endif
                          @else
                            @if(!empty($value['vmwh_delivery_proof']))
                            <center>
                              <a href="{{url('/')}}{{$value['vmwh_delivery_proof']}}" target="_blank"><i class="fa fa-image"></i></a>
                            </center>
                            @else
                            <center>-</center>
                            @endif
                          @endif
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
                      <td>
                        {{-- <a href="{{url('/')}}/edit_{{$url_slug}}/{{$value['_id']}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a> --}}
                        @if(!empty($value['mrn_ref']))
                          <a href="{{url('/')}}/view_swh_{{$url_slug}}/{{$value['_id']}}" title="View" target="_blank">
                            <i class="fa fa-file-pdf-o" style="color: red;"></i>
                          </a>
                        @else
                          <a href="{{url('/')}}/view_vmwh_{{$url_slug}}/{{$value['_id']}}" title="View" target="_blank">
                            <i class="fa fa-file-pdf-o" style="color: red;"></i>
                          </a>
                        @endif
                        {{-- <a href="{{url('/')}}/delete_{{$url_slug}}/{{$value['_id']}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a> --}}
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
 
@endsection