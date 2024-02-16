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
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/')}}/update_{{$url_slug}}/{{$id}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Email(Username)<span style="color:red;" >*</span></label>
                      <input type="email" class="form-control" id="username" name="username" value="{{$data[$id]['username']}}" placeholder="Email(Username)" data-parsley-pattern="^([\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$"  placeholder="Email" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Role<span style="color:red;" >*</span></label>
                      <select id="role" name="role" class="form-control" onchange="role_change()" required="">
                        <option value="">Select</option>
                        {{-- <option value="1" @if('1'==$data[$id]['role']) selected="" @endif>Main warehous</option> --}}
                        <option value="2" @if('2'==$data[$id]['role']) selected="" @endif>EDF Warehouse</option>
                        <option value="3" @if('3'==$data[$id]['role']) selected="" @endif>VM Warehouse</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" id="div_state" @if($data[$id]['role']!='3') style="display: none;" @endif>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">State<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="state" name="state" value="{{$data[$id]['state']}}" placeholder="State" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_city" @if($data[$id]['role']!='3') style="display: none;" @endif>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">City<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="city" name="city" value="{{$data[$id]['city']}}" placeholder="City"  required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6" id="div_sw_list" @if($data[$id]['role']!='3') style="display: none;" @endif>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">EDF Warehouse<span style="color:red;" >*</span></label>
                    
                      <select id="sw" name="sw" class="form-control">
                        @foreach($sw_list as $key=>$value)
                        <option value="{{$value['_id']}}" @if($value['_id']==$data[$id]['parent_sw']) @endif>{{$value['warehouse_name']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Warehouse Name<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" value="{{$data[$id]['warehouse_name']}}" placeholder="Warehouse Name" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Warehouse Address<span style="color:red;" >*</span></label>
                      <textarea class="form-control" id="warehouse_address" name="warehouse_address" placeholder="Warehouse Address" required="true">{{$data[$id]['warehouse_address']}}</textarea>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <script type="text/javascript">
    function role_change()
    {
      var role = $('#role').val();
      if(role=='1')
      {
        $('#div_state').hide();
        $('#div_city').hide();
        $('#div_sw_list').hide();
        $('#state').prop('required',false);
        $('#city').prop('required',false);
        $('#sw').prop('required',false);
      }
      else if(role=='2')
      {
        $('#div_state').show();
        $('#div_city').hide();
        $('#div_sw_list').hide();
        $('#state').prop('required',true);
        $('#city').prop('required',false);
        $('#sw').prop('required',false);
      }
      else
      {
        $('#div_state').show();
        $('#div_city').show();
        $('#div_sw_list').show();
        $('#sw').prop('required',true);
        $('#state').prop('required',true);
        $('#city').prop('required',true);
      }
    }
  </script>
  
@endsection