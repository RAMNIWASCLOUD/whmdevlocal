<?php
$common_connection = new \MongoClient(config('app.aliases.DB_URL'));
$common_db         = $common_connection->whm;
$common_collection = $common_db->meter;

$condition         = ['physical_testing_status'=>'sagregated'];
$cursor            = $common_collection->find($condition);
$all_meter         = $cursor->count();
$condition         = ['physical_testing_status'=>'sagregated','batch_status'=>'Pending','testing_status'=>'Pending'];
$cursor            = $common_collection->find($condition);
$select_meter      = $cursor->count();
//$condition         = ['swh'=>new \MongoId(\Session::get('_id'))];
//$cursor            = $common_collection->find($condition);
//$test_report_meter = $cursor->count();

$condition         = ['batch_status'=>'Approved','dl_ch_ref'=>''];
$cursor            = $common_collection->find($condition);
$edf_meter_poole   = $cursor->count();

$condition         = ['dl_ch_ref'=>['$ne'=>'']/*,'swh'=>['$ne'=>'']*/];
$cursor            = $common_collection->find($condition);
$assigned_meter    = $cursor->count();
$condition         = ['$or' => [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
$cursor            = $common_collection->find($condition);
$reject_meter      = $cursor->count();

$condition         = ['swh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);
$sm_all_meter      = $cursor->count();
$condition         = ['status'=>'New Meter','swh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);
$sm_new_meter      = $cursor->count();
$condition         = ['swh_inventory_status'=>'Instock','batch_status'=>'Approved','swh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);
$sm_edf_meter_poole= $cursor->count();
$condition         = ['swh_inventory_status'=>'Outstock','swh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);
$sm_assigned_meter = $cursor->count();
$condition         = ['swh'=>new \MongoId(\Session::get('_id')),'$or' => [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
$cursor            = $common_collection->find($condition);
$sm_reject_meter   = $cursor->count();
$condition         = ['swh_inventory_status'=>'Outstock','vmwh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);


$vm_all_meter      = $cursor->count();
$condition         = ['swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);
$vm_new_meter          = $cursor->count();
$vm_installation_meter = 0;
$condition         = ['status'=>'Rejected','vmwh'=>new \MongoId(\Session::get('_id'))];
$cursor            = $common_collection->find($condition);
$vm_reject_meter       = $cursor->count();


$common_db         = $common_connection->whm;
$common_collection = $common_db->bsnl_sim;
$condition         = ['swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED'];
$cursor            = $common_collection->find($condition);
$edf_sim_poole   = $cursor->count();
$condition         = ['vmwh'=>'','swh'=>new \MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
$cursor            = $common_collection->find($condition);
$swh_edf_sim_poole   = $cursor->count();
$condition         = ['vmwh'=>new \MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
$cursor            = $common_collection->find($condition);
$vmwh_edf_sim_poole   = $cursor->count();

$common_db         = $common_connection->whm;
$common_collection = $common_db->modem;
$condition         = ['swh'=>'','vmwh'=>'','mrn_ref'=>'','status'=>'UNUTILISED'];
$cursor            = $common_collection->find($condition);
$edf_modem_poole   = $cursor->count();
$condition         = ['vmwh'=>'','swh'=>new \MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
$cursor            = $common_collection->find($condition);
$swh_edf_modem_poole   = $cursor->count();
$condition         = ['vmwh'=>new \MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
$cursor            = $common_collection->find($condition);
$vmwh_edf_modem_poole   = $cursor->count();



?>
 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('/')}}/css_and_js/admin/dist/img/user2-160x160.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="margin-top: 5%;">
          {{\Session::get('warehouse_name')}}
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu" data-widget="tree">
        {{-- <li class="header">ACTION CONTROLS</li> --}}

        <li @if(Request::segment(1)=='dashbord') class="active" @endif>
          <a href="{{url('/')}}/dashbord">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
      @if(\Session::get('role')=='1')
        
        <li @if(Request::segment(1)=='new_view_meter' || Request::segment(1)=='add_meter') class="active" @endif>
          <a href="{{url('/')}}/add_meter">
            <i class="fa fa-upload"></i> <span>Upload .CSV(Genus)</span>
          </a>
        </li>
         <li @if(Request::segment(1)=='add_bsnlsim') class="active" @endif>
          <a href="{{url('/')}}/add_bsnlsim">
            <i class="fa fa-upload"></i> <span>Upload .CSV(BSNL SIM)</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='manage_modem') class="active" @endif>
          <a href="{{url('/')}}/manage_modem">
            <i class="fa fa-upload"></i> <span>Upload .CSV(MODEM)</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='manage_sealstock') class="active" @endif>
          <a href="{{url('/')}}/manage_sealstock">
            <i class="fa fa-upload"></i> <span>Manage Seal stock</span>
          </a>
        </li>
        <li class="treeview @if(Request::segment(1)=='uploaded_meter' || Request::segment(1)=='physical_test_report' || Request::segment(1)=='manage_physical_testing_meter' || Request::segment(1)=='phisical_tested' || Request::segment(1)=='phisical_damage' || Request::segment(1)=='segregated') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>All Meters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='uploaded_meter') class="active" @endif>
              <a href="{{url('/')}}/uploaded_meter">
                <i class="fa fa-circle-o"></i> <span>Received Meter</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='physical_test_report' || Request::segment(1)=='manage_physical_testing_meter') class="active" @endif>
              <a href="{{url('/')}}/physical_test_report">
                <i class="fa fa-circle-o"></i> <span>Test Report</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='phisical_tested') class="active" @endif>
              <a href="{{url('/')}}/phisical_tested">
                <i class="fa fa-circle-o"></i> <span>Physical Tested</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='phisical_damage') class="active" @endif>
              <a href="{{url('/')}}/phisical_damage">
                <i class="fa fa-circle-o"></i> <span>Physical Damage</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='segregated') class="active" @endif>
              <a href="{{url('/')}}/segregated">
                <i class="fa fa-circle-o"></i> <span>Segregation Log</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="treeview @if(Request::segment(1)=='edf_sim_pool' || Request::segment(1)=='edf_modem_pool' || Request::segment(1)=='manage_meter' || Request::segment(1)=='view_meter' || Request::segment(1)=='select_sample' || Request::segment(1)=='test_report' || Request::segment(1)=='edf_meter_pool' || Request::segment(1)=='assigned_meter' || Request::segment(1)=='reject_meter'|| Request::segment(1)=='view_meter_testing' || Request::segment(1)=='manage_seleted_meter') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Manage Meters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='manage_meter' || Request::segment(1)=='view_meter') class="active" @endif>
              <a href="{{url('/')}}/manage_meter">
                <i class="fa fa-circle-o"></i> <span>All Meters({{ $all_meter }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='select_sample') class="active" @endif>
              <a href="{{url('/')}}/select_sample">
                <i class="fa fa-circle-o"></i> <span>Pending Test Bench({{ $select_meter }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='test_report' || Request::segment(1)=='manage_seleted_meter' || Request::segment(1)=='view_meter_testing') class="active" @endif>
              <a href="{{url('/')}}/test_report">
                <i class="fa fa-circle-o"></i> <span>Test Report{{-- ({{ $test_report_meter }}) --}}</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_meter_pool') class="active" @endif>
              <a href="{{url('/')}}/edf_meter_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Meter Pool({{ $edf_meter_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_sim_pool') class="active" @endif>
              <a href="{{url('/')}}/edf_sim_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Sim Pool({{ $edf_sim_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_modem_pool') class="active" @endif>
              <a href="{{url('/')}}/edf_modem_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Modem Pool({{ $edf_modem_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='assigned_meter') class="active" @endif>
              <a href="{{url('/')}}/assigned_meter">
                <i class="fa fa-circle-o"></i> <span>Assigned Meters({{ $assigned_meter }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='reject_meter') class="active" @endif>
              <a href="{{url('/')}}/reject_meter">
                <i class="fa fa-circle-o"></i> <span>Rejected Meters({{ $reject_meter }})</span>
              </a>
            </li>
          </ul>
        </li>
        <li @if(Request::segment(1)=='recived_wh_mrn') class="active" @endif>
          <a href="{{url('/')}}/recived_wh_mrn">
            <i class="fa fa-list"></i> <span>Pending MRN</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='manage_dispatch') class="active" @endif>
          <a href="{{url('/')}}/manage_dispatch">
            <i class="fa fa-list"></i> <span>Dispatch</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='manage_member' || Request::segment(1)=='edit_member' || Request::segment(1)=='add_member' || Request::segment(1)=='view_member') class="active" @endif>
          <a href="{{url('/')}}/manage_member">
            <i class="fa fa-list"></i> <span>Manage Users</span>
          </a>
        </li>
      @elseif(\Session::get('role')=='2')
        <li class="treeview @if(Request::segment(1)=='swh_edf_sim_pool' || Request::segment(1)=='swh_edf_modem_pool' ||Request::segment(1)=='swh_manage_meter' || Request::segment(1)=='swh_new_manage_meter' || Request::segment(1)=='swh_edf_meter_pool' || Request::segment(1)=='swh_assigned_meter' || Request::segment(1)=='swh_reject_meter') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Manage Meters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='swh_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_manage_meter">
                <i class="fa fa-circle-o"></i> <span>All Meters({{ $sm_all_meter }})</span>
              </a>
            </li>
            {{-- <li @if(Request::segment(1)=='swh_new_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_new_manage_meter">
                <i class="fa fa-circle-o"></i> <span>New Meters({{ $sm_new_meter }})</span>
              </a>
            </li> --}}
            <li @if(Request::segment(1)=='swh_edf_meter_pool') class="active" @endif>
              <a href="{{url('/')}}/swh_edf_meter_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Meter Pool({{ $sm_edf_meter_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='swh_edf_sim_pool') class="active" @endif>
              <a href="{{url('/')}}/swh_edf_sim_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Sim Pool({{ $swh_edf_sim_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='swh_edf_modem_pool') class="active" @endif>
              <a href="{{url('/')}}/swh_edf_modem_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Modem Pool({{ $swh_edf_modem_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='swh_assigned_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_assigned_meter">
                <i class="fa fa-circle-o"></i> <span>Assigned Meters({{ $sm_assigned_meter }})</span>
              </a>
            </li>
           {{--  <li @if(Request::segment(1)=='swh_reject_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_reject_meter">
                <i class="fa fa-circle-o"></i> <span>Reject Meters({{ $sm_reject_meter }})</span>
              </a>
            </li> --}}
          </ul>
        </li>
        <li class="treeview @if(Request::segment(1)=='recived_swh_mrn' || Request::segment(1)=='new_swh_mrn') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>MRN</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='new_swh_mrn') class="active" @endif>
              <a href="{{url('/')}}/new_swh_mrn">
                <i class="fa fa-circle-o"></i> <span>New MRN</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='recived_swh_mrn') class="active" @endif>
              <a href="{{url('/')}}/recived_swh_mrn">
                <i class="fa fa-circle-o"></i> <span>MRN Received By VM</span>
              </a>
            </li>
          </ul>
        </li>
        <li @if(Request::segment(1)=='dispatch_swh_index') class="active" @endif>
          <a href="{{url('/')}}/dispatch_swh_index">
            <i class="fa fa-list"></i> <span>Incoming Dispatch</span>
          </a>
        </li>
      @elseif(\Session::get('role')=='3')
        <li class="treeview @if(Request::segment(1)=='vmwh_edf_sim_pool' || Request::segment(1)=='vmwh_edf_modem_pool' || Request::segment(1)=='vm_manage_meter' || Request::segment(1)=='vm_new_manage_meter' || Request::segment(1)=='vm_installation_meter' || Request::segment(1)=='vm_reject_meter') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Meter</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='vm_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_manage_meter">
                <i class="fa fa-circle-o"></i> <span>All Meters({{ $vm_all_meter }})</span>
              </a>
            </li>
            {{-- <li @if(Request::segment(1)=='vm_new_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_new_manage_meter">
                <i class="fa fa-circle-o"></i> <span>New Meters({{ $vm_new_meter }})</span>
              </a>
            </li> --}}
            <li @if(Request::segment(1)=='vmwh_edf_sim_pool') class="active" @endif>
              <a href="{{url('/')}}/vmwh_edf_sim_pool">
                <i class="fa fa-circle-o"></i> <span>All Sim ({{ $vmwh_edf_sim_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='vmwh_edf_modem_pool') class="active" @endif>
              <a href="{{url('/')}}/vmwh_edf_modem_pool">
                <i class="fa fa-circle-o"></i> <span>All Modem ({{ $vmwh_edf_modem_poole }})</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='vm_installation_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_installation_meter">
                <i class="fa fa-circle-o"></i> <span>Installed Meters({{ $vm_installation_meter }})</span>
              </a>
            </li>
            {{-- <li @if(Request::segment(1)=='vm_reject_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_reject_meter">
                <i class="fa fa-circle-o"></i> <span>Reject Meters({{ $vm_reject_meter }})</span>
              </a>
            </li> --}}
          </ul>
        </li>
        <li class="treeview @if(Request::segment(1)=='recived_vm_mrn' || Request::segment(1)=='new_vm_mrn') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>MRN</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='new_vm_mrn') class="active" @endif>
              <a href="{{url('/')}}/new_vm_mrn">
                <i class="fa fa-circle-o"></i> <span>New MRN</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='recived_vm_mrn') class="active" @endif>
              <a href="{{url('/')}}/recived_vm_mrn">
                <i class="fa fa-circle-o"></i> <span>MRN Received By SHM</span>
              </a>
            </li>
          </ul>
        </li>
        <li @if(Request::segment(1)=='dispatch_vmwh_index') class="active" @endif>
          <a href="{{url('/')}}/dispatch_vmwh_index">
            <i class="fa fa-list"></i> <span>Incoming Dispatch</span>
          </a>
        </li>
      @endif
    

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>