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
        <li><a href="{{url('/')}}/new_vm_mrn">New {{ $title }}</a></li>
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
            <form action="{{ url('/')}}/update_mrn_a_1_mrn/{{$data['_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Kind Attn<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="kind_attn" name="kind_attn" value="{{$data['kind_attn']}}" placeholder="Kind Attn" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Mobile No.<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{$data['mobile_no']}}" placeholder="Mobile No."  data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="Mobile No. should be 10 digit." data-parsley-maxlength-message="Mobile No. should be 10 digit." required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Location<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{$data['location']}}" required="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Telephone 1<span style="color:red;" >*</span></label>
                      <input type="number" class="form-control" id="telephone_1" name="telephone_1" value="{{$data['telephone_1']}}" placeholder="Telephone 1" data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-minlength-message="Telephone No. should be 6 to 16 digit." data-parsley-maxlength-message="Telephone No. should be 6 to 16 digit." required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Telephone 2</label>
                      <input type="number" class="form-control" id="telephone_2" name="telephone_2" value="{{$data['telephone_2']}}" placeholder="Telephone 2" data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-minlength-message="Telephone No. should be 6 to 16 digit." data-parsley-maxlength-message="Telephone No. should be 6 to 16 digit." >
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Site Address<span style="color:red;" >*</span></label>
                      <textarea class="form-control" id="site_address" name="site_address"  required="true">{{$data['site_address']}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-striped" style="width: 60%">
                    <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>Description Of Material</th>
                        <th>UOM</th>
                        <th>Request Qty</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>1</th>
                        <th>Single Phase Meter</th>
                        <th>Nos</th>
                        <th><input type="number" class="form-control" id="single_phase_meter_qty" name="single_phase_meter_qty" value="{{$data['single_phase_meter_qty']}}"></th>
                      </tr>
                      <tr>
                        <th>2</th>
                        <th>Three Phase Meter</th>
                        <th>Nos</th>
                        <th><input type="number" class="form-control" id="three_phase_meter_qty" name="three_phase_meter_qty" value="{{$data['three_phase_meter_qty']}}"></th>
                      </tr>
                       <tr>
                        <th>3</th>
                        <th>Sim</th>
                        <th>Nos</th>
                        <th><input type="number" class="form-control" id="sim_qty" name="sim_qty" value="{{$data['sim_qty']}}"></th>
                      </tr>
                      <tr>
                        <th>4</th>
                        <th>Modem</th>
                        <th>Nos</th>
                        <th><input type="number" class="form-control" id="modem_qty" name="modem_qty" value="{{$data['modem_qty']}}"></th>
                      </tr>
                      <tr>
                        <th>5</th>
                        <th>Antenna </th>
                        <th>Nos</th>
                        <th><input type="number" class="form-control" id="seal_qty" name="seal_qty" value="{{$data['seal_qty']}}"></th>
                      </tr>
                    </tbody>
                  </table>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
@endsection