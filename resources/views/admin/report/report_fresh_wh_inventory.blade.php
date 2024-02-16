@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fresh warehouse Inventory
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Fresh warehouse Inventory</a></li>
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
            <form id="reassign_form" method="GET" action="" data-parsley-validate="parsley">
              <div class="row">
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="datepicker" name="search" value="{{isset($_GET['search'])? $_GET['search']: date('Y-m-d')}}" placeholder="Today's Date" >
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="submit" >Search</button>
                    </div>
                  </div>
                </div>
               
               
              </div>
            
              <h3>FRESH INVENTORY- EDF Warehouse </h3>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Item</th>
                  <th>Manufacturer</th>
                  <th>Opening stock</th>
                  <th>Dispatched</th>
                  <th>Available WH Stock</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>1</td>
                      <td>Meter</td>
                      <td>Genus 3G</td>
                      <td>{{$goe_opening_stock_3g}}</td>
                      <td>{{$goe_dispatch_3g}}</td>
                      <td>{{$goe_opening_stock_3g+$goe_dispatch_3g}}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Meter</td>
                      <td>Genus 4G</td>
                      <td>{{$goe_opening_stock_4g}}</td>
                      <td>{{$goe_dispatch_4g}}</td>
                      <td>{{$goe_opening_stock_4g+$goe_dispatch_4g}}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Meter</td>
                      <td>L&T</td>
                      <td>{{$L_an_T_opening_stock}}</td>
                      <td>{{$L_an_T_dispatch}}</td>
                      <td>{{$L_an_T_opening_stock+$L_an_T_dispatch}}</td>
                    </tr>

                </tbody>
              </table>
             
              <h3>Available meters at Warehouse</h3>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Phase</th>
                  <th>SBPDCL</th>
                  <th>NBPDCL</th>
                  <th>To Be Mapped</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>1-Phase</td>
                      <td>{{$_1phase_SBPDCL}}</td>
                      <td>{{$_1phase_NBPDCL}}</td>
                      <td>{{$_1phase_To_Be_Mapped}}</td>
                      <td><b>{{$_1phase_SBPDCL+$_1phase_NBPDCL}}</b></td>
                    </tr>
                    <tr>
                      <td>3-Phase</td>
                      <td>{{$_3phase_SBPDCL}}</td>
                      <td>{{$_3phase_NBPDCL}}</td>
                      <td>{{$_3phase_To_Be_Mapped}}</td>
                      <td><b>{{$_3phase_SBPDCL+$_3phase_NBPDCL}}</b></td>
                    </tr>
                    <tr>
                      <td><b>Total</b></td>
                      <td><b>{{$_1phase_SBPDCL+$_3phase_SBPDCL}}</b></td>
                      <td><b>{{$_1phase_NBPDCL+$_3phase_NBPDCL}}</b></td>
                      <td><b>{{$_1phase_To_Be_Mapped+$_3phase_To_Be_Mapped}}</b></td>
                      <td><b>{{$_1phase_SBPDCL+$_3phase_SBPDCL+$_1phase_NBPDCL+$_3phase_NBPDCL}}</b></td>
                    </tr>
                </tbody>
              </table>
            </form>
              
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

    function search_form_submit()
    {
       $("#assignee").attr("required", false);
        document.getElementById("reassign_form").action = "{{url('/')}}/manage_meter";
        document.getElementById("reassign_form").submit();
    }

    function assign_form_submit()
    {
        //$("#assignee").attr("required", true);
      
        var checkboxes = document.getElementsByName('checkbox_id[]');
        var selected = [];
        var flag = false;
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selected.push(checkboxes[i].value);
                flag = true;
            }
        } 

        if(!flag)
        {
          document.getElementById("error_span").innerHTML="Please select minimum one checkboxe.";
        }
        else
        {
          if($("#assignee").val()=='')
          {
            document.getElementById("error_span").innerHTML="This value is required.";
          }
          else
          {
            document.getElementById("error_span").innerHTML="";
            document.getElementById("reassign_form").action = "{{url('/')}}/get_meter_to_admin_pool";
            document.getElementById("reassign_form").submit();
          }
        }

    }
      function check_uncheck_checkbox(isChecked) {
          if(isChecked) {
            $('input[name="checkbox_id[]"]').each(function() { 
              this.checked = true; 
            });
          } else {
            $('input[name="checkbox_id[]"]').each(function() {
              this.checked = false;
            });
          }
        }
  </script>
 
@endsection