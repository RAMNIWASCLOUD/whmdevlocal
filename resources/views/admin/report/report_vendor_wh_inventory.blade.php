@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fresh vendor WH Inventory
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Fresh vendor WH Inventory</a></li>
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
              <div class="row" style="display: none;">
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="search" name="search" value="{{isset($_GET['search'])? $_GET['search']: ''}}" placeholder="Start Date" >
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group" >
                      <input type="text" class="form-control" id="device_phase" name="device_phase" value="{{isset($_GET['device_phase'])? $_GET['device_phase']: ''}}" placeholder="End Date" >
                    </div>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="box-body">
                    <div class="form-group" >
                      <button class="btn btn-primary" type="button" >Search</button>
                    </div>
                  </div>
                </div>
               
               
              </div>
              <div class="row">
                <div class="col-md-12">
                    <h3>Meter inventory - vendor warehouse</h3>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>Vendor name</th>
                        <th>Vendor ID</th>
                        <th>Location</th>
                        <th>Opening stock</th>
                        <th>Receipts</th>
                        <th>Installed</th>
                        <th>Meters available with them</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($data_meter as $key=>$value)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value['warehouse_name']}}</td>
                            <td>{{$value['username']}}</td>
                            <td>{{$value['city']}}</td>
                            <td>{{(isset($value['opening_stock']))? $value['opening_stock']: ''}}</td>
                            <td>{{(isset($value['receipts']))? $value['receipts']: ''}}</td>
                            <td>{{(isset($value['installed']))? $value['installed']: ''}}</td>
                            <td>{{(isset($value['meter_available_with_them']))? $value['meter_available_with_them']: ''}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <h3>Modem inventory - vendor warehouse</h3>
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>Vendor name</th>
                        <th>Location</th>
                        <th>Opening stock</th>
                        <th>Receipts</th>
                        <th>Installed</th>
                        <th>Modem available with them</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($data_meter as $key=>$value)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value['username']}}</td>
                            <td>{{$value['city']}}</td>
                             <td>{{(isset($value['opening_stock']))? $value['opening_stock']: ''}}</td>
                            <td>{{(isset($value['receipts']))? $value['receipts']: ''}}</td>
                            <td>{{(isset($value['installed']))? 0: ''}}</td>
                            <td>{{(isset($value['meter_available_with_them']))? 0: ''}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
              
              <?php 
                $Genus_intransist_3G =  \DB::table('meter')->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','batch_supplier'=>'Genus 3G'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','batch_supplier'=>'Genus 3G'])->count(); 
                $Genus_intransist_4G =  \DB::table('meter')->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','batch_supplier'=>'Genus 4G'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','batch_supplier'=>'Genus 4G'])->count(); 
                $L_an_T_intransist =  \DB::table('meter')->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','batch_supplier'=>'L&T'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','batch_supplier'=>'L&T'])->count(); 



                $Genus_faulty_3G =  \DB::table('meter')->where(['edf_status'=>'Replaced','batch_supplier'=>'Genus 3G'])->count(); 
                $Genus_faulty_4G =  \DB::table('meter')->where(['edf_status'=>'Replaced','batch_supplier'=>'Genus 4G'])->count(); 
                $L_an_T_faulty =  \DB::table('meter')->where(['edf_status'=>'Replaced','batch_supplier'=>'L&T'])->count(); 

              ?>
              <h3>FAULTY INVENTORY WARRANTY - Meters</h3>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Manufacturer</th>
                  <th>Receipts from field</th>
                  <th>Dispatche to EDF</th>
                  <th>Balance Faulty meters @ WH</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>Genus 3G</td>
                      <td>0</td>
                      <td>{{$Genus_intransist_3G}}</td>
                      <td>{{$Genus_faulty_3G}}</td>
                    </tr>
                    <tr>
                      <td>Genus 4G</td>
                      <td>0</td>
                      <td>{{$Genus_intransist_4G}}</td>
                      <td>{{$Genus_faulty_4G}}</td>
                    </tr>
                    <tr>
                      <td>L&T</td>
                      <td>0</td>
                      <td>{{$L_an_T_intransist}}</td>
                      <td>{{$L_an_T_faulty}}</td>
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