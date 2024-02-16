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
      {{-- <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol> --}}
    </section>



    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/update_meter_sim/{{$data['_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}

              
              
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Device ID:<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="username" name="username" value="{{$data['device_id']}}" disabled="" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Manufacturer Serial Number:<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="username" name="username" value="{{$data['device_id']}}" disabled="" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Old Sim Number<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="username" name="username" value="{{$data['device_id']}}" disabled="" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">New Sim Number<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="new_iccid" name="new_iccid" required="true">
                    </div>
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->
              
              <div class="box-footer">
                <a href="{{url('/')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary pull-right">Update</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            {{-- <div class="box-header">
              <a href="{{url('/')}}/add_{{$url_slug}}" class="btn btn-primary btn-xs" style="float: right;">Add {{$title}}</a>
            </div> --}}
            <h3>Sim History</h3>
            <div class="box-body">
            <!-- /.box-header -->
           
            
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Done By</th>
                  <th>Old Sim</th>
                  <th>New Sim</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                  
                  <?php $i=1; 
                    $sim_history = \DB::table('sim_history')->where(['meter_id'=>$data['_id']])->get();
                  ?>
                  @if(count($sim_history)!=0)
                  @foreach($sim_history as $value)
                    <tr>
                      <td>
                        {{$i}}
                      </td>
                      <td>
                        {{$value['created_name']}}
                      </td>
                      <td>
                        {{$value['old_iccid']}}
                      </td>
                      <td>
                        {{$value['iccid']}}
                      </td>
                      <td>
                        {{$value['date']}}
                      </td>
                      <td>
                     
                    </tr>
                  <?php $i++; ?>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="5"><center>No Record Found.</center></td>
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
  
@endsection