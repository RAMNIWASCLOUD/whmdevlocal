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
        <li><a href="{{url('/')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/update_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
               <div class="box-body">
                <div class="form-group">
                  <label for="oldpassword">Email(Username)</label>: <span>{{$data[$id]['username']}}</span>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="oldpassword">Role</label>: <span> 
                        @if($data[$id]['role']=='1')
                          Admin
                        @elseif($data[$id]['role']=='2')
                          State Wharhouse Manager
                        @elseif($data[$id]['role']=='3')
                          VM Wharehouse Manager
                        @endif</span>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="oldpassword">Warehouse Name</label>: <span>{{$data[$id]['warehouse_name']}}</span>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="oldpassword">Warehouse Address</label>: <span>{{$data[$id]['warehouse_address']}}</span>
                </div>
              </div>
              <!-- /.box-body -->
              
              <div class="box-footer">
                <a href="{{url('/')}}/manage_{{$url_slug}}" type="submit" class="btn btn-primary pull-right">Back</a>
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