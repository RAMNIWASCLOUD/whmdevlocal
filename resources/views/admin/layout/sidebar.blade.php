

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
            <i class="fa fa-dashboard"></i> <span>Dashboard </span>
          </a>
        </li>
      @if(\Session::get('role')=='999')
        <li @if(Request::segment(1)=='manage_admin' || Request::segment(1)=='edit_admin' || Request::segment(1)=='add_admin' || Request::segment(1)=='view_admin') class="active" @endif>
          <a href="{{url('/')}}/manage_admin">
            <i class="fa fa-list"></i> <span>Manage Admin</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='manage_state' || Request::segment(1)=='edit_state' || Request::segment(1)=='add_state' || Request::segment(1)=='view_state') class="active" @endif>
          <a href="{{url('/')}}/manage_state">
            <i class="fa fa-list"></i> <span>Manage State</span>
          </a>
        </li>
      @elseif(\Session::get('role')=='1')
        
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
        {{-- <li @if(Request::segment(1)=='manage_antennas') class="active" @endif>
          <a href="{{url('/')}}/manage_antennas">
            <i class="fa fa-upload"></i> <span>Upload .CSV(Antennas)</span>
          </a>
        </li> --}}
        <li @if(Request::segment(1)=='manage_sealstock') class="active" @endif>
          <a href="{{url('/')}}/manage_sealstock">
            <i class="fa fa-upload"></i> <span>Manage Antennas</span>
          </a>
        </li>
        <li class="treeview @if(Request::segment(1)=='s2s_permanent_damage_meter' || Request::segment(1)=='permanent_damage_meter' || Request::segment(1)=='uploaded_meter' || Request::segment(1)=='physical_test_report' || Request::segment(1)=='manage_physical_testing_meter' || Request::segment(1)=='phisical_tested' || Request::segment(1)=='phisical_damage' || Request::segment(1)=='segregated' || Request::segment(1)=='sm_to_admin_damaged_meter'|| Request::segment(1)=='sm_to_admin_pending_acceptance_damaged_meter' || Request::segment(1)=='repaired_meter' || Request::segment(1)=='send_to_supplier' || Request::segment(1)=='return_from_supplier' || Request::segment(1)=='s2s_sm_to_admin_pending_acceptance_damaged_meter' || Request::segment(1)=='s2s_sm_to_admin_damaged_meter' || Request::segment(1)=='s2s_send_to_supplier' || Request::segment(1)=='s2s_return_from_supplier' || Request::segment(1)=='s2s_repaired_meter') active @endif ">
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
            
            <li @if(Request::segment(1)=='sm_to_admin_pending_acceptance_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/sm_to_admin_pending_acceptance_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>Pending Damaged Meter(<span id="pending_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='sm_to_admin_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/sm_to_admin_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>Accepted Damaged Meter</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='send_to_supplier') class="active" @endif>
              <a href="{{url('/')}}/send_to_supplier">
                <i class="fa fa-circle-o"></i> <span>Sent To Supplier</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='return_from_supplier') class="active" @endif>
              <a href="{{url('/')}}/return_from_supplier">
                <i class="fa fa-circle-o"></i> <span>Return From Supplier</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='repaired_meter') class="active" @endif>
              <a href="{{url('/')}}/repaired_meter">
                <i class="fa fa-circle-o"></i> <span>Repaired Meter</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='permanent_damage_meter') class="active" @endif>
              <a href="{{url('/')}}/permanent_damage_meter">
                <i class="fa fa-circle-o"></i> <span>Permanent Damage Meter</span>
              </a>
            </li>


            <li @if(Request::segment(1)=='s2s_sm_to_admin_pending_acceptance_damaged_meter') class="active" @endif>
              <a style="white-space: initial;" href="{{url('/')}}/s2s_sm_to_admin_pending_acceptance_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>S2S Pending Damaged Meter(<span id="s2s_pending_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='s2s_sm_to_admin_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/s2s_sm_to_admin_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>S2S Accepted Damaged Meter</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='s2s_send_to_supplier') class="active" @endif>
              <a href="{{url('/')}}/s2s_send_to_supplier">
                <i class="fa fa-circle-o"></i> <span>S2S Sent To Supplier</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='s2s_return_from_supplier') class="active" @endif>
              <a href="{{url('/')}}/s2s_return_from_supplier">
                <i class="fa fa-circle-o"></i> <span>S2S Return From Supplier</span>
              </a>
            </li>


            <li @if(Request::segment(1)=='s2s_repaired_meter') class="active" @endif>
              <a href="{{url('/')}}/s2s_repaired_meter">
                <i class="fa fa-circle-o"></i> <span>S2S Repaired Meter</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='s2s_permanent_damage_meter') class="active" @endif>
              <a href="{{url('/')}}/s2s_permanent_damage_meter">
                <i class="fa fa-circle-o"></i> <span>S2S Permanent Damage Meter</span>
              </a>
            </li>

            
          </ul>
        </li>

        <li class="treeview @if(Request::segment(1)=='edf_meter_pool_all_permanent_damage' || Request::segment(1)=='edf_sim_pool' || Request::segment(1)=='edf_modem_pool' || Request::segment(1)=='manage_meter' || Request::segment(1)=='view_meter' || Request::segment(1)=='select_sample' || Request::segment(1)=='test_report' || Request::segment(1)=='edf_meter_pool'|| Request::segment(1)=='s2s_edf_meter_pool' || Request::segment(1)=='assigned_meter' || Request::segment(1)=='reject_meter'|| Request::segment(1)=='view_meter_testing' || Request::segment(1)=='manage_seleted_meter') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Manage Meters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='manage_meter' || Request::segment(1)=='view_meter') class="active" @endif>
              <a href="{{url('/')}}/manage_meter">
                <i class="fa fa-circle-o"></i> <span>All Meters(<span id="all_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='select_sample') class="active" @endif>
              <a href="{{url('/')}}/select_sample">
                <i class="fa fa-circle-o"></i> <span>Pending Test Bench(<span id="select_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='test_report' || Request::segment(1)=='manage_seleted_meter' || Request::segment(1)=='view_meter_testing') class="active" @endif>
              <a href="{{url('/')}}/test_report">
                <i class="fa fa-circle-o"></i> <span>Test Report{{-- (<span id="test_report_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>) --}}</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_meter_pool') class="active" @endif>
              <a href="{{url('/')}}/edf_meter_pool">
                <i class="fa fa-circle-o"></i> <span>All EDF Meter Pool(<span id="edf_meter_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='s2s_edf_meter_pool') class="active" @endif>
              <a href="{{url('/')}}/s2s_edf_meter_pool">
                <i class="fa fa-circle-o"></i> <span>S2S EDF Meter Pool(<span id="s2s_edf_meter_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_meter_pool_all_permanent_damage') class="active" @endif>
              <a href="{{url('/')}}/edf_meter_pool_all_permanent_damage" style="text-wrap: wrap;">
                <i class="fa fa-circle-o"></i> <span>All Permanent Damage Meter Pool(<span id="edf_meter_pool_all_permanent_damagee"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_sim_pool') class="active" @endif>
              <a href="{{url('/')}}/edf_sim_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Sim Pool(<span id="edf_sim_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='edf_modem_pool') class="active" @endif>
              <a href="{{url('/')}}/edf_modem_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Modem Pool(<span id="edf_modem_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='assigned_meter') class="active" @endif>
              <a href="{{url('/')}}/assigned_meter">
                <i class="fa fa-circle-o"></i> <span>Assigned Meters(<span id="assigned_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='reject_meter') class="active" @endif>
              <a href="{{url('/')}}/reject_meter">
                <i class="fa fa-circle-o"></i> <span>Rejected Meters(<span id="reject_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
          </ul>
        </li>
        <li @if(Request::segment(1)=='metermovement') class="active" @endif>
          <a href="{{url('/')}}/metermovement">
            <i class="fa fa-list"></i> <span>Meter Movement</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='recived_wh_mrn') class="active" @endif>
          <a href="{{url('/')}}/recived_wh_mrn">
            <i class="fa fa-list"></i> <span>All MRN</span>
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
        <li class="treeview @if(Request::segment(1)=='report_fresh_wh_inventory'||Request::segment(1)=='report_vendor_wh_inventory'||Request::segment(1)=='report_faulty_warranty_management'||Request::segment(1)=='daily_mis'||Request::segment(1)=='report_inventory_upload_file'||Request::segment(1)=='report_master_mis') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='report_fresh_wh_inventory') class="active" @endif>
              <a href="{{url('/')}}/report_fresh_wh_inventory">
                <i class="fa fa-circle-o"></i> <span>Fresh warehouse Inventory</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='report_vendor_wh_inventory') class="active" @endif>
              <a href="{{url('/')}}/report_vendor_wh_inventory">
                <i class="fa fa-circle-o"></i> <span>Fresh vendor WH Inventory</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='report_faulty_warranty_management') class="active" @endif>
              <a href="{{url('/')}}/report_faulty_warranty_management">
                <i class="fa fa-circle-o"></i> <span>Faulty warranty Management</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='daily_mis') class="active" @endif>
              <a href="{{url('/')}}/daily_mis">
                <i class="fa fa-circle-o"></i> <span>Daily MIS</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='report_inventory_upload_file') class="active" @endif>
              <a href="{{url('/')}}/report_inventory_upload_file">
                <i class="fa fa-circle-o"></i> <span>Inventory Upload File</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='report_master_mis') class="active" @endif>
              <a href="{{url('/')}}/report_master_mis">
                <i class="fa fa-circle-o"></i> <span>Master MIS</span>
              </a>
            </li>
          </ul>
        </li>
        <li @if(Request::segment(1)=='manage_intransit') class="active" @endif>
          <a href="{{url('/')}}/manage_intransit">
            <i class="fa fa-list"></i> <span>Inventory in transit</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='edf_installed_meter') class="active" @endif>
          <a href="{{url('/')}}/edf_installed_meter">
            <i class="fa fa-list"></i> <span>EDF Installed Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='edf_reject_meter') class="active" @endif>
          <a href="{{url('/')}}/edf_reject_meter">
            <i class="fa fa-list"></i> <span>EDF Damage Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='ghost_meter') class="active" @endif>
          <a href="{{url('/')}}/ghost_meter">
            <i class="fa fa-list"></i> <span>Ghost Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='warranty_expiring_in_one_month') class="active" @endif>
          <a href="{{url('/')}}/warranty_expiring_in_one_month">
            <i class="fa fa-list"></i> <span>Warranty Expiring In One Month</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='report_dumps') class="active" @endif>
          <a href="{{url('/')}}/report_dumps">
            <i class="fa fa-list"></i> <span>Report Dumps</span>
          </a>
        </li>

      @elseif(\Session::get('role')=='2')
        <li class="treeview @if(Request::segment(1)=='swh_edf_sim_pool' || Request::segment(1)=='swh_edf_modem_pool' ||Request::segment(1)=='swh_manage_meter' || Request::segment(1)=='swh_new_manage_meter' || Request::segment(1)=='swh_edf_meter_pool' || Request::segment(1)=='swh_assigned_meter' || Request::segment(1)=='swh_reject_meter' || Request::segment(1)=='sm_damaged_meter' || Request::segment(1)=='vm_to_sm_damaged_meter' || Request::segment(1)=='s2s_sm_damaged_meter' || Request::segment(1)=='s2s_vm_to_sm_damaged_meter') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Manage Meters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='swh_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_manage_meter">
                <i class="fa fa-circle-o"></i> <span>All Meters(<span id="sm_all_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            {{-- <li @if(Request::segment(1)=='swh_new_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_new_manage_meter">
                <i class="fa fa-circle-o"></i> <span>New Meters(<span id="sm_new_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li> --}}
            <li @if(Request::segment(1)=='swh_edf_meter_pool') class="active" @endif>
              <a href="{{url('/')}}/swh_edf_meter_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Meter Pool(<span id="sm_edf_meter_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='swh_edf_sim_pool') class="active" @endif>
              <a href="{{url('/')}}/swh_edf_sim_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Sim Pool(<span id="swh_edf_sim_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='swh_edf_modem_pool') class="active" @endif>
              <a href="{{url('/')}}/swh_edf_modem_pool">
                <i class="fa fa-circle-o"></i> <span>EDF Modem Pool(<span id="swh_edf_modem_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='swh_assigned_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_assigned_meter">
                <i class="fa fa-circle-o"></i> <span>Assigned Meters(<span id="sm_assigned_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='sm_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/sm_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>Damaged Meters(<span id="sm_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>

            </li>
            <li @if(Request::segment(1)=='vm_to_sm_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_to_sm_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>VM Damaged Meters(<span id="vm_to_sm_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>

            </li>
            <li @if(Request::segment(1)=='s2s_sm_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/s2s_sm_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>S2S Damaged Meters(<span id="s2s_sm_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>

            </li>
            <li @if(Request::segment(1)=='s2s_vm_to_sm_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/s2s_vm_to_sm_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>S2S VM Damaged Meters(<span id="s2s_vm_to_sm_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>

            </li>
           {{--  <li @if(Request::segment(1)=='swh_reject_meter') class="active" @endif>
              <a href="{{url('/')}}/swh_reject_meter">
                <i class="fa fa-circle-o"></i> <span>Reject Meters(<span id="sm_reject_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
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
        <li class="treeview @if(Request::segment(1)=='vmwh_edf_sim_pool' || Request::segment(1)=='vmwh_edf_modem_pool' || Request::segment(1)=='vm_manage_meter' || Request::segment(1)=='vm_new_manage_meter' || Request::segment(1)=='vm_installation_meter' || Request::segment(1)=='vm_reject_meter' || Request::segment(1)=='vm_damaged_meter' || Request::segment(1)=='s2s_vm_damaged_meter') active @endif ">
          <a href="#">
            <i class="fa fa-list"></i> <span>Meter</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(1)=='vm_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_manage_meter">
                <i class="fa fa-circle-o"></i> <span>All Meters(<span id="vm_all_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            {{-- <li @if(Request::segment(1)=='vm_new_manage_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_new_manage_meter">
                <i class="fa fa-circle-o"></i> <span>New Meters(<span id="vm_new_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li> --}}
            <li @if(Request::segment(1)=='vmwh_edf_sim_pool') class="active" @endif>
              <a href="{{url('/')}}/vmwh_edf_sim_pool">
                <i class="fa fa-circle-o"></i> <span>All Sim (<span id="vmwh_edf_sim_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='vmwh_edf_modem_pool') class="active" @endif>
              <a href="{{url('/')}}/vmwh_edf_modem_pool">
                <i class="fa fa-circle-o"></i> <span>All Modem (<span id="vmwh_edf_modem_poole"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='vm_installation_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_installation_meter">
                <i class="fa fa-circle-o"></i> <span>Installed Meters(<span id="vm_installation_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='vm_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>Damaged Meters(<span id="vm_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            <li @if(Request::segment(1)=='s2s_vm_damaged_meter') class="active" @endif>
              <a href="{{url('/')}}/s2s_vm_damaged_meter">
                <i class="fa fa-circle-o"></i> <span>S2S Damaged Meters(<span id="s2s_vm_damaged_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
              </a>
            </li>
            {{-- <li @if(Request::segment(1)=='vm_reject_meter') class="active" @endif>
              <a href="{{url('/')}}/vm_reject_meter">
                <i class="fa fa-circle-o"></i> <span>Reject Meters(<span id="vm_reject_meter"><img class="loader_class" style="width: 25px;" src="{{url('/')}}/css_and_js/Spinner-1s-200px.gif"></span>)</span>
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
      @elseif(\Session::get('role')=='4')
        <li @if(Request::segment(1)=='mrn_a_1_pending'||Request::segment(1)=='edit_vm_mrn') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_1_pending">
            <i class="fa fa-list"></i> <span>Pending MRN</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='mrn_a_1_approved') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_1_approved">
            <i class="fa fa-list"></i> <span>Approved MRN</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='mrn_a_1_rejected') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_1_rejected">
            <i class="fa fa-list"></i> <span>Rejected MRN</span>
          </a>
        </li>
      @elseif(\Session::get('role')=='5')
        {{-- <li @if(Request::segment(1)=='mrn_a_2_pending_from1') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_2_pending_from1">
            <i class="fa fa-list"></i> <span>Pending MRN Authority 1</span>
          </a>
        </li> --}}
        <li @if(Request::segment(1)=='mrn_a_2_pending'||Request::segment(1)=='edit_vm_mrn') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_2_pending">
            <i class="fa fa-list"></i> <span>Pending MRN</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='mrn_a_2_approved') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_2_approved">
            <i class="fa fa-list"></i> <span>Approved MRN</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='mrn_a_2_rejected') class="active" @endif>
          <a href="{{url('/')}}/mrn_a_2_rejected">
            <i class="fa fa-list"></i> <span>Rejected MRN</span>
          </a>
        </li>
      @elseif(\Session::get('role')=='6')
        <li @if(Request::segment(1)=='supplier_pending_meter') class="active" @endif>
          <a href="{{url('/')}}/supplier_pending_meter">
            <i class="fa fa-list"></i> <span>Pending Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='supplier_approved_meter') class="active" @endif>
          <a href="{{url('/')}}/supplier_approved_meter">
            <i class="fa fa-list"></i> <span>Approved Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='supplier_admin_approved_meter') class="active" @endif>
          <a href="{{url('/')}}/supplier_admin_approved_meter">
            <i class="fa fa-list"></i> <span>Admin Approved Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='s2s_supplier_pending_meter') class="active" @endif>
          <a href="{{url('/')}}/s2s_supplier_pending_meter">
            <i class="fa fa-list"></i> <span>S2S Pending Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='s2s_supplier_approved_meter') class="active" @endif>
          <a href="{{url('/')}}/s2s_supplier_approved_meter">
            <i class="fa fa-list"></i> <span>S2S Approved Meters</span>
          </a>
        </li>
        <li @if(Request::segment(1)=='s2s_supplier_admin_approved_meter') class="active" @endif>
          <a href="{{url('/')}}/s2s_supplier_admin_approved_meter">
            <i class="fa fa-list"></i> <span>S2S Admin Approved Meters</span>
          </a>
        </li>
      @endif
    

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <script type="text/javascript">
     $(document).ready(function(){
        //sidebar_call();
        @if(\Session::get('role')=='2')
        sidebar_call3();
        sidebar_call4();
        sidebar_call5();
        sidebar_call8();
        sidebar_call9();
        sidebar_call10();
        sidebar_call11();
        @elseif(\Session::get('role')=='999')
        @else
        sidebar_call1();
        sidebar_call2();
        sidebar_call3();
        sidebar_call4();
        sidebar_call5();
        sidebar_call6();
        sidebar_call7();
        sidebar_call8();
        sidebar_call9();
        sidebar_call10();
        sidebar_call11();
        sidebar_call12_1();
        sidebar_call12_2();
        @endif
    });

      /*function sidebar_call(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#all_meter').text(data.all_meter);
                $('#select_meter').text(data.select_meter);
                $('#edf_meter_poole').text(data.edf_meter_poole);
                $('#assigned_meter').text(data.assigned_meter);
                $('#reject_meter').text(data.reject_meter);
                $('#sm_all_meter').text(data.sm_all_meter);
                $('#sm_new_meter').text(data.sm_new_meter);
                $('#sm_edf_meter_poole').text(data.sm_edf_meter_poole);
                $('#sm_assigned_meter').text(data.sm_assigned_meter);
                $('#sm_reject_meter').text(data.sm_reject_meter);
                $('#vm_all_meter').text(data.vm_all_meter);
                $('#vm_new_meter').text(data.vm_new_meter);
                $('#vm_reject_meter').text(data.vm_reject_meter);
                $('#edf_sim_poole').text(data.edf_sim_poole);
                $('#swh_edf_sim_poole').text(data.swh_edf_sim_poole);
                $('#vmwh_edf_sim_poole').text(data.vmwh_edf_sim_poole);
                $('#edf_modem_poole').text(data.edf_modem_poole);
                $('#swh_edf_modem_poole').text(data.swh_edf_modem_poole);
                $('#vmwh_edf_modem_poole').text(data.vmwh_edf_modem_poole);
                $('#sm_damaged_meter').text(data.sm_damaged_meter);
                $('#vm_to_sm_damaged_meter').text(data.vm_to_sm_damaged_meter);
                $('#vm_installation_meter').text(data.vm_installation_meter);
                $('#vm_damaged_meter').text(data.vm_damaged_meter);
                $('#pending_damaged_meter').text(data.pending_damaged_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call();}});
      }*/

      function sidebar_call1(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts1',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#all_meter').text(data.all_meter);
              $('#select_meter').text(data.select_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call1();}});
      }

      function sidebar_call2(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts2',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
             $('#edf_meter_poole').text(data.edf_meter_poole);
             $('#s2s_edf_meter_poole').text(data.s2s_edf_meter_poole);
             $('#edf_meter_pool_all_permanent_damagee').text(data.edf_meter_pool_all_permanent_damagee);
             
              $('#assigned_meter').text(data.assigned_meter); 
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call2();}});
      }

      function sidebar_call3(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts3',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#reject_meter').text(data.reject_meter);
              $('#sm_all_meter').text(data.sm_all_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call3();}});
      }

      function sidebar_call4(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts4',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#sm_new_meter').text(data.sm_new_meter);
              $('#sm_edf_meter_poole').text(data.sm_edf_meter_poole);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call4();}});
      }

      function sidebar_call5(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts5',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#sm_assigned_meter').text(data.sm_assigned_meter);
              $('#sm_reject_meter').text(data.sm_reject_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call5();}});
      }

      function sidebar_call6(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts6',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#vm_all_meter').text(data.vm_all_meter);
              $('#vm_new_meter').text(data.vm_new_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call6();}});
      }

      function sidebar_call7(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts7',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#vm_reject_meter').text(data.vm_reject_meter);
              $('#edf_sim_poole').text(data.edf_sim_poole);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call7();}});
      }

      function sidebar_call8(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts8',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#swh_edf_sim_poole').text(data.swh_edf_sim_poole);
              $('#vmwh_edf_sim_poole').text(data.vmwh_edf_sim_poole);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call8();}});
      }

      function sidebar_call9(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts9',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#edf_modem_poole').text(data.edf_modem_poole);
              $('#swh_edf_modem_poole').text(data.swh_edf_modem_poole);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call9();}});
      }

      function sidebar_call10(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts10',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#vmwh_edf_modem_poole').text(data.vmwh_edf_modem_poole);
              $('#sm_damaged_meter').text(data.sm_damaged_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call10();}});
      }

      function sidebar_call11(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts11',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#vm_to_sm_damaged_meter').text(data.vm_to_sm_damaged_meter);
              $('#s2s_vm_to_sm_damaged_meter').text(data.s2s_vm_to_sm_damaged_meter);
              $('#s2s_sm_damaged_meter').text(data.s2s_sm_damaged_meter);
              $('#vm_installation_meter').text(data.vm_installation_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call11();}});
      }

      function sidebar_call12_1(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts12_1',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#vm_damaged_meter').text(data.vm_damaged_meter);
              $('#s2s_vm_damaged_meter').text(data.s2s_vm_damaged_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call12();}});
      }
      function sidebar_call12_2(){
        $.ajax({url: '{{url('/')}}/get_sidebar_counts12_2',type: 'post',data: {"_token": "{{ csrf_token() }}"},
          success: function (data) {$('.loader_class').hide();
              $('#pending_damaged_meter').text(data.pending_damaged_meter);
              $('#s2s_pending_damaged_meter').text(data.s2s_pending_damaged_meter);
          },beforeSend: function() { $('#loader_id').show(); },
          error: function (error) {sidebar_call12();}});
      }
    
  </script>