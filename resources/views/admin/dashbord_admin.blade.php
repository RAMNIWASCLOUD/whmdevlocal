@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <style type="text/css">
    .close_custome{
      float: right;
    }
  </style>
  <style type="text/css">
.preloader_id { position:absolute; top: 0; left: 0; right: 0; bottom: 0; background-color:rgba(255,255,255,0.5); z-index: 99; height:100%}
#preloader__status {position: absolute; left: 50%; top: 50%; /* width: 200px;  height: 200px;   background-image:url(../images/Spinner-1s-200px.gif);*/   background-repeat: o-repeat;  background-position: center; transform:translate(-50%,-50%);  }
  </style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     @include('admin.layout._status_msg')
     <div class="row">
        
    @if(\Session::get('role')=='1')
      <div class="col-lg-12 col-xs-12">
        <div class="box">
        <div class="box-body">
          <style>
          .table1{ border:1px solid #b5b5b5; border-bottom:none}
          .table1 > tbody > tr > th, .table1 >tbody> tr >td{ border:1px solid #b5b5b5}
          .table1> tbody >tr > th, .table1 >tbody> tr >td{ border-top:none; border-right:none;}
          </style>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="5" class="table1" >
                  <tr>
                    <td colspan="3" align="center" bgcolor="#FFFF33">Sims</td>
                  </tr>
                  <tr>
                    <td align="center">Total</td>
                    <td align="center">Utilized</td>
                    <td align="center">UN Utilized</td>
                  </tr>
                  <tr>
                    <td align="center"><span id="bfc_sim_total"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td align="center"><span id="bfc_sim_utilized"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td align="center"><span id="bfc_sim_unutilized"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="5" class="table1">
                  <tr>
                    <td colspan="3" align="center" bgcolor="#FFFF33">Modems</td>
                  </tr>
                  <tr>
                    <td align="center">Total</td>
                    <td align="center">ok</td>
                    <td align="center">Defective</td>
                  </tr>
                  <tr>
                    <td align="center"><span id="bfc_modem_total"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td align="center"><span id="bfc_modem_ok"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td align="center"><span id="bfc_modem_defective"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="5" class="table1">
                  <tr>
                    <td colspan="3" align="center" bgcolor="#FFFF33">Antennas</td>
                  </tr>
                  <tr>
                    <td align="center">Total</td>
                    <td align="center">ok</td>
                    <td align="center">Defective</td>
                  </tr>
                  <tr>
                    <td align="center"><span id="bfc_antenna_total"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td align="center"><span id="bfc_antenna_ok"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td align="center"><span id="bfc_antenna_defective"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                  </tr>
                </table></td>
               
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
              <tr>
                <td colspan="7" align="center" bgcolor="#FFFF33">Meters Details of EDF Pool</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2" align="center">L &amp; T</td>
                <td colspan="2" align="center">Genus 3G</td>
                <td colspan="2" align="center">Genus 4G</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2" align="center"><span id="lnt"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td colspan="2" align="center"><span id="genus_3g"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td colspan="2" align="center"><span id="genus_4g"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
                <td align="center">1 Phase</td>
                <td align="center">3 Phase</td>
                <td align="center">1 Phase</td>
                <td align="center">3 Phase</td>
                <td align="center">1 Phase</td>
                <td align="center">3 Phase</td>
                </tr>
              <tr>
                <td align="center">SBPDCL</td>
                <td align="center"><span id="sbpd_lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="sbpd_lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="sbpd_genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="sbpd_genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="sbpd_genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="sbpd_genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
              <tr>
                <td align="center">NBPDCL</td>
                <td align="center"><span id="nbpd_lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="nbpd_lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="nbpd_genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="nbpd_genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="nbpd_genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="nbpd_genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
              <tr>
                <td colspan="7" align="center" bgcolor="#FF9900">&nbsp;</td>
                </tr>
              <tr>
                <td align="center">All Meters</td>
                <td align="center"><span id="lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
              <tr>
                <td align="center">EDF Pool Meters</td>
                <td align="center"><span id="edf_pool_lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="edf_pool_lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="edf_pool_genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="edf_pool_genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="edf_pool_genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="edf_pool_genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
              <tr>
                <td align="center">Assigned Meters</td>
                <td align="center"><span id="assigned_lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="assigned_lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="assigned_genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="assigned_genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="assigned_genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="assigned_genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
              <tr>
                <td align="center">Unassigned Meters</td>
                <td align="center"><span id="unsigned_lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="unsigned_lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="unsigned_genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="unsigned_genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="unsigned_genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="unsigned_genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
              <tr>
                <td align="center">Damage Meters</td>
                <td align="center"><span id="damage_lnt_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="damage_lnt_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="damage_genus_3g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="damage_genus_3g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="damage_genus_4g_1ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                <td align="center"><span id="damage_genus_4g_3ph"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
          <tr>
            <td colspan="7" align="center" bgcolor="#FFFF33">All Meters</td>
          </tr>
          <tr>
            <td align="center">Received Meter</td>
            <td align="center"><span id="Received_Meter"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Test Report</td>
            <td align="center"><span id="Test_Report"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Physical Tested</td>
            <td align="center"><span id="Physical_Tested"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Physical Damage</td>
            <td align="center"><span id="Physical_Damage"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Accepted Damaged Meter</td>
            <td align="center"><span id="Accepted_Damaged_Meter"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Pending Damaged Meter</td>
            <td align="center"><span id="Pending_Damaged_Meter"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Sent To Supplier</td>
            <td align="center"><span id="Sent_To_Supplier"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Return From Supplier</td>
            <td align="center"><span id="Return_From_Supplier"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Repaired Meter</td>
            <td align="center"><span id="Repaired_Meter"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">All MRN</td>
            <td align="center"><span id="All_MRN"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Dispatch </td>
            <td align="center"><span id="Dispatch"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Pending Utility Map </td>
            <td align="center"><span id="pending_utility_map"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Permanent Damage</td>
            <td align="center"><span id="Permanent_Damage"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center"></td>
            <td align="center"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
          <tr>
            <td colspan="7" align="center" bgcolor="#FFFF33">S2S Meters</td>
          </tr>
          {{--<tr>
            <td align="center">S2S Pending Damaged Meter </td>
            <td align="center"><span id="s2s_pending_damaged_meter1"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">S2S Accepted Damaged Meter</td>
            <td align="center"><span id="s2s_accepted_damaged_meter"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">S2S Sent To Supplier </td>
            <td align="center"><span id="s2s_sent_to_supplier"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">S2S Return From Supplier </td>
            <td align="center"><span id="s2s_return_from_supplier"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">S2S Repaired Meter</td>
            <td align="center"><span id="s2s_repaired_meter"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center"></td>
            <td align="center"></td>
          </tr>--}}
          <tr>
            <td align="center">Total S2S received at WH</td>
            <td align="center"><span id="Total_S2S_received_at_WH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Total S2S Pending With EDF WH</td>
            <td align="center"><span id="Total_S2S_Pending_With_EDF_WH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Total S2S Pending With Supplier</td>
            <td align="center"><span id="Total_S2S_Pending_With_Supplier"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Total S2S Repaired in WH</td>
            <td align="center"><span id="Total_S2S_Repaired_in_WH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">Total S2S repaired installed in Field</td>
            <td align="center"><span id="Total_S2S_repaired_installed_in_Field"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center">Total S2S Repaired Available in Field</td>
            <td align="center"><span id="Total_S2S_Repaired_Available_in_Field"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
          </tr>
          <tr>
            <td align="center">S2S Permanent Damage</td>
            <td align="center"><span id="s2s_Permanent_Damage"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
            <td align="center"></td>
            <td align="center"></td>
          </tr>
        </table>
        </div>
      </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(){
          // dashboard_get_admin_c();
          dashboard_get_admin_c1();
          dashboard_get_admin_c2();
          dashboard_get_admin_c3();
          dashboard_get_admin_meter_bfc_c2();
          dashboard_get_admin_meter_bfc_c3_1();
          dashboard_get_admin_meter_bfc_c3_2();
          dashboard_get_admin_meter_bfc_c3_3();
          dashboard_get_admin_meter_bfc_c4_1();
          dashboard_get_admin_meter_bfc_c4_2();
          dashboard_get_admin_meter_bfc_c4_3();
          dashboard_get_admin_meter_bfc_c5_1();
          dashboard_get_admin_meter_bfc_c5_2();
          dashboard_get_admin_meter_bfc_c5_3();
          dashboard_get_admin_meter_bfc_c6_1();
          dashboard_get_admin_meter_bfc_c6_2();
          dashboard_get_admin_meter_bfc_c6_3();
          dashboard_get_admin_meter_bfc_c7_1();
          dashboard_get_admin_meter_bfc_c7_2();
          dashboard_get_admin_meter_bfc_c7_3();
          dashboard_get_admin_meter_bfc_c8_1();
          dashboard_get_admin_meter_bfc_c8_2();
          dashboard_get_admin_meter_bfc_c8_3();
          dashboard_get_admin_meter_bfc_c9_1();
          dashboard_get_admin_meter_bfc_c9_2();
          dashboard_get_admin_meter_bfc_c9_3();
          dashboard_get_admin_all_meter();
          
          /*
          dashboard_get_admin_meter_bfc_c3();
          dashboard_get_admin_meter_bfc_c4();
          dashboard_get_admin_meter_bfc_c5();
          dashboard_get_admin_meter_bfc_c6();
          dashboard_get_admin_meter_bfc_c7();
          dashboard_get_admin_meter_bfc_c8();
          dashboard_get_admin_meter_bfc_c9();*/
        });

        /*function dashboard_get_admin_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#bfc_sim_total").text(data.bfc_sim_total);
          $("#bfc_sim_utilized").text(data.bfc_sim_utilized);
          $("#bfc_sim_unutilized").text(data.bfc_sim_unutilized);
          $("#bfc_modem_total").text(data.bfc_modem_total);
          $("#bfc_modem_ok").text(data.bfc_modem_ok);
          $("#bfc_modem_defective").text(data.bfc_modem_defective);
          $("#bfc_antenna_total").text(data.bfc_antenna_total);
          $("#bfc_antenna_ok").text(data.bfc_antenna_ok);
          $("#bfc_antenna_defective").text(data.bfc_antenna_defective);
          // dashboard_get_admin_meter_bfc_c2(); 
        },error: function (error) { dashboard_get_admin_c(); }});};*/

        function dashboard_get_admin_c1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_c1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#bfc_sim_total").text(data.bfc_sim_total);
          $("#bfc_sim_utilized").text(data.bfc_sim_utilized);
          $("#bfc_sim_unutilized").text(data.bfc_sim_unutilized);
          lnt
        },error: function (error) { dashboard_get_admin_c1(); }});};

        function dashboard_get_admin_c2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_c2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#bfc_modem_total").text(data.bfc_modem_total);
          $("#bfc_modem_ok").text(data.bfc_modem_ok);
          $("#bfc_modem_defective").text(data.bfc_modem_defective);
        },error: function (error) { dashboard_get_admin_c2(); }});};

        function dashboard_get_admin_c3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_c3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#bfc_antenna_total").text(data.bfc_antenna_total);
          $("#bfc_antenna_ok").text(data.bfc_antenna_ok);
          $("#bfc_antenna_defective").text(data.bfc_antenna_defective);
        },error: function (error) { dashboard_get_admin_c3(); }});};

        function dashboard_get_admin_meter_bfc_c2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
           $("#lnt").text(data.lnt); 
          $("#genus_3g").text(data.genus_3g); 
          $("#genus_4g").text(data.genus_4g);  
        },error: function (error) { dashboard_get_admin_meter_bfc_c2(); }});};

        /*function dashboard_get_admin_meter_bfc_c3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#sbpd_lnt_1ph").text(data.sbpd_lnt_1ph); 
          $("#sbpd_lnt_3ph").text(data.sbpd_lnt_3ph); 
          $("#sbpd_genus_3g_1ph").text(data.sbpd_genus_3g_1ph); 
          $("#sbpd_genus_3g_3ph").text(data.sbpd_genus_3g_3ph); 
          $("#sbpd_genus_4g_1ph").text(data.sbpd_genus_4g_1ph); 
          $("#sbpd_genus_4g_3ph").text(data.sbpd_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c4(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c3(); }});};

        function dashboard_get_admin_meter_bfc_c4() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c4',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#nbpd_lnt_1ph").text(data.nbpd_lnt_1ph); 
          $("#nbpd_lnt_3ph").text(data.nbpd_lnt_3ph); 
          $("#nbpd_genus_3g_1ph").text(data.nbpd_genus_3g_1ph); 
          $("#nbpd_genus_3g_3ph").text(data.nbpd_genus_3g_3ph); 
          $("#nbpd_genus_4g_1ph").text(data.nbpd_genus_4g_1ph); 
          $("#nbpd_genus_4g_3ph").text(data.nbpd_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c5(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c4(); }});};

        function dashboard_get_admin_meter_bfc_c5() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c5',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#lnt_1ph").text(data.lnt_1ph); 
          $("#lnt_3ph").text(data.lnt_3ph); 
          $("#genus_3g_1ph").text(data.genus_3g_1ph); 
          $("#genus_3g_3ph").text(data.genus_3g_3ph); 
          $("#genus_4g_1ph").text(data.genus_4g_1ph); 
          $("#genus_4g_3ph").text(data.genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c6(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c5(); }});};

        function dashboard_get_admin_meter_bfc_c6() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c6',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#edf_pool_lnt_1ph").text(data.edf_pool_lnt_1ph); 
          $("#edf_pool_lnt_3ph").text(data.edf_pool_lnt_3ph); 
          $("#edf_pool_genus_3g_1ph").text(data.edf_pool_genus_3g_1ph); 
          $("#edf_pool_genus_3g_3ph").text(data.edf_pool_genus_3g_3ph); 
          $("#edf_pool_genus_4g_1ph").text(data.edf_pool_genus_4g_1ph); 
          $("#edf_pool_genus_4g_3ph").text(data.edf_pool_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c7(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c6(); }});};

        function dashboard_get_admin_meter_bfc_c7() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c7',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#assigned_lnt_1ph").text(data.assigned_lnt_1ph); 
          $("#assigned_lnt_3ph").text(data.assigned_lnt_3ph); 
          $("#assigned_genus_3g_1ph").text(data.assigned_genus_3g_1ph); 
          $("#assigned_genus_3g_3ph").text(data.assigned_genus_3g_3ph); 
          $("#assigned_genus_4g_1ph").text(data.assigned_genus_4g_1ph); 
          $("#assigned_genus_4g_3ph").text(data.assigned_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c8(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c7(); }});};

        function dashboard_get_admin_meter_bfc_c8() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c8',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#unsigned_lnt_1ph").text(data.unsigned_lnt_1ph); 
          $("#unsigned_lnt_3ph").text(data.unsigned_lnt_3ph); 
          $("#unsigned_genus_3g_1ph").text(data.unsigned_genus_3g_1ph); 
          $("#unsigned_genus_3g_3ph").text(data.unsigned_genus_3g_3ph); 
          $("#unsigned_genus_4g_1ph").text(data.unsigned_genus_4g_1ph); 
          $("#unsigned_genus_4g_3ph").text(data.unsigned_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c9(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c8(); }});};

        function dashboard_get_admin_meter_bfc_c9() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c9',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#damage_lnt_1ph").text(data.damage_lnt_1ph); 
          $("#damage_lnt_3ph").text(data.damage_lnt_3ph); 
          $("#damage_genus_3g_1ph").text(data.damage_genus_3g_1ph); 
          $("#damage_genus_3g_3ph").text(data.damage_genus_3g_3ph); 
          $("#damage_genus_4g_1ph").text(data.damage_genus_4g_1ph); 
          $("#damage_genus_4g_3ph").text(data.damage_genus_4g_3ph); 
          //dashboard_get_admin_meter_bfc_c8(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c9(); }});};*/

        function dashboard_get_admin_meter_bfc_c3_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c3_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#sbpd_lnt_1ph").text(data.sbpd_lnt_1ph); 
          $("#sbpd_lnt_3ph").text(data.sbpd_lnt_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c3_1(); }});};

        function dashboard_get_admin_meter_bfc_c3_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c3_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#sbpd_genus_3g_1ph").text(data.sbpd_genus_3g_1ph); 
          $("#sbpd_genus_3g_3ph").text(data.sbpd_genus_3g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c3_2(); }});};

        function dashboard_get_admin_meter_bfc_c3_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c3_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#sbpd_genus_4g_1ph").text(data.sbpd_genus_4g_1ph); 
          $("#sbpd_genus_4g_3ph").text(data.sbpd_genus_4g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c3_3(); }});};

        function dashboard_get_admin_meter_bfc_c4_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c4_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#nbpd_lnt_1ph").text(data.nbpd_lnt_1ph); 
          $("#nbpd_lnt_3ph").text(data.nbpd_lnt_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c4_1(); }});};

        function dashboard_get_admin_meter_bfc_c4_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c4_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#nbpd_genus_3g_1ph").text(data.nbpd_genus_3g_1ph); 
          $("#nbpd_genus_3g_3ph").text(data.nbpd_genus_3g_3ph);  
        },error: function (error) { dashboard_get_admin_meter_bfc_c4_2(); }});};

        function dashboard_get_admin_meter_bfc_c4_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c4_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#nbpd_genus_4g_1ph").text(data.nbpd_genus_4g_1ph); 
          $("#nbpd_genus_4g_3ph").text(data.nbpd_genus_4g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c4_3(); }});};

        function dashboard_get_admin_meter_bfc_c5_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c5_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#lnt_1ph").text(data.lnt_1ph); 
          $("#lnt_3ph").text(data.lnt_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c5_1(); }});};

        function dashboard_get_admin_meter_bfc_c5_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c5_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#genus_3g_1ph").text(data.genus_3g_1ph); 
          $("#genus_3g_3ph").text(data.genus_3g_3ph);  
        },error: function (error) { dashboard_get_admin_meter_bfc_c5_2(); }});};

        function dashboard_get_admin_meter_bfc_c5_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c5_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#genus_4g_1ph").text(data.genus_4g_1ph); 
          $("#genus_4g_3ph").text(data.genus_4g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c5_3(); }});};

        function dashboard_get_admin_meter_bfc_c6_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c6_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#edf_pool_lnt_1ph").text(data.edf_pool_lnt_1ph); 
          $("#edf_pool_lnt_3ph").text(data.edf_pool_lnt_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c6_1(); }});};

        function dashboard_get_admin_meter_bfc_c6_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c6_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#edf_pool_genus_3g_1ph").text(data.edf_pool_genus_3g_1ph); 
          $("#edf_pool_genus_3g_3ph").text(data.edf_pool_genus_3g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c6_2(); }});};

        function dashboard_get_admin_meter_bfc_c6_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c6_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#edf_pool_genus_4g_1ph").text(data.edf_pool_genus_4g_1ph); 
          $("#edf_pool_genus_4g_3ph").text(data.edf_pool_genus_4g_3ph);  
        },error: function (error) { dashboard_get_admin_meter_bfc_c6_3(); }});};

        function dashboard_get_admin_meter_bfc_c7_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c7_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#assigned_lnt_1ph").text(data.assigned_lnt_1ph); 
          $("#assigned_lnt_3ph").text(data.assigned_lnt_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c7_1(); }});};

        function dashboard_get_admin_meter_bfc_c7_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c7_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#assigned_genus_3g_1ph").text(data.assigned_genus_3g_1ph); 
          $("#assigned_genus_3g_3ph").text(data.assigned_genus_3g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c7_2(); }});};

        function dashboard_get_admin_meter_bfc_c7_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c7_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#assigned_genus_4g_1ph").text(data.assigned_genus_4g_1ph); 
          $("#assigned_genus_4g_3ph").text(data.assigned_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c8(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c7_3(); }});};

        function dashboard_get_admin_meter_bfc_c8_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c8_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#unsigned_lnt_1ph").text(data.unsigned_lnt_1ph); 
          $("#unsigned_lnt_3ph").text(data.unsigned_lnt_3ph);
        },error: function (error) { dashboard_get_admin_meter_bfc_c8_1(); }});};

        function dashboard_get_admin_meter_bfc_c8_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c8_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#unsigned_genus_3g_1ph").text(data.unsigned_genus_3g_1ph); 
          $("#unsigned_genus_3g_3ph").text(data.unsigned_genus_3g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c8_2(); }});};

        function dashboard_get_admin_meter_bfc_c8_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c8_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#unsigned_genus_4g_1ph").text(data.unsigned_genus_4g_1ph); 
          $("#unsigned_genus_4g_3ph").text(data.unsigned_genus_4g_3ph); 
          // dashboard_get_admin_meter_bfc_c9(); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c8_3(); }});};

        function dashboard_get_admin_meter_bfc_c9_1() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c9_1',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#damage_lnt_1ph").text(data.damage_lnt_1ph); 
          $("#damage_lnt_3ph").text(data.damage_lnt_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c9_1(); }});};

        function dashboard_get_admin_meter_bfc_c9_2() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c9_2',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { 
          $("#damage_genus_3g_1ph").text(data.damage_genus_3g_1ph); 
          $("#damage_genus_3g_3ph").text(data.damage_genus_3g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c9_2(); }});};

        function dashboard_get_admin_meter_bfc_c9_3() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_bfc_c9_3',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) {
          $("#damage_genus_4g_1ph").text(data.damage_genus_4g_1ph); 
          $("#damage_genus_4g_3ph").text(data.damage_genus_4g_3ph); 
        },error: function (error) { dashboard_get_admin_meter_bfc_c9_3(); }});};

        function dashboard_get_admin_all_meter() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_all_meter',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) {
          $("#Received_Meter").text(data.Received_Meter); 
          $("#Test_Report").text(data.Test_Report); 
          $("#Physical_Tested").text(data.Physical_Tested); 
          $("#Physical_Damage").text(data.Physical_Damage); 
          $("#Segregation_Log").text(data.Segregation_Log); 
          $("#Pending_Damaged_Meter").text(data.Pending_Damaged_Meter); 
          $("#Accepted_Damaged_Meter").text(data.Accepted_Damaged_Meter); 
          $("#Sent_To_Supplier").text(data.Sent_To_Supplier); 
          $("#Return_From_Supplier").text(data.Return_From_Supplier); 
          $("#Repaired_Meter").text(data.Repaired_Meter); 
          $("#All_MRN").text(data.All_MRN); 
          $("#Dispatch").text(data.Dispatch); 
          $("#pending_utility_map").text(data.pending_utility_map); 
          //$("#s2s_pending_damaged_meter1").text(data.s2s_pending_damaged_meter); 
          //$("#s2s_accepted_damaged_meter").text(data.s2s_accepted_damaged_meter); 
          //$("#s2s_sent_to_supplier").text(data.s2s_sent_to_supplier); 
          //$("#s2s_return_from_supplier").text(data.s2s_return_from_supplier); 
          //$("#s2s_repaired_meter").text(data.s2s_repaired_meter); 
          $("#Total_S2S_received_at_WH").text(data.Total_S2S_received_at_WH); 
          $("#Total_S2S_Pending_With_EDF_WH").text(data.Total_S2S_Pending_With_EDF_WH); 
          $("#Total_S2S_Pending_With_Supplier").text(data.Total_S2S_Pending_With_Supplier); 
          $("#Total_S2S_Repaired_in_WH").text(data.Total_S2S_Repaired_in_WH); 
          $("#Total_S2S_repaired_installed_in_Field").text(data.Total_S2S_repaired_installed_in_Field); 
          $("#Total_S2S_Repaired_Available_in_Field").text(data.Total_S2S_Repaired_Available_in_Field); 

          $("#Permanent_Damage").text(data.Permanent_Damage); 
          $("#s2s_Permanent_Damage").text(data.s2s_Permanent_Damage); 
          






        },error: function (error) { dashboard_get_admin_all_meter(); }});};


      </script>

    @elseif(\Session::get('role')=='3')
        <div class="col-lg-12 col-xs-6">

          <div class="row">
         
           
            <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Meters</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Meters<span class="pull-right badge bg-blue" id="vm_t_meter_c">0</span></a></li>
                    <li><a href="#">OK Meters <span class="pull-right badge bg-green" id="vm_o_meter_c">0</span></a></li>
                    <li><a href="#">Defective Meters<span class="pull-right badge bg-red" id="vm_d_meter_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="vm_loader_meter">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Modems</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Modems<span class="pull-right badge bg-blue" id="vm_t_modem_c">0</span></a></li>
                    <li><a href="#">OK Modems <span class="pull-right badge bg-green" id="vm_o_modem_c">0</span></a></li>
                    <li><a href="#">Defective Modems<span class="pull-right badge bg-red" id="vm_d_modem_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="vm_loader_modem">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            
             <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Installed Meter</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Installed Meter<span class="pull-right badge bg-blue" id="vm_t_meter_installed_c">0</span></a></li>
                    <li><a href="#">Phase 1 Installed Mater <span class="pull-right badge bg-green" id="vm_o_meter_installed_c">0</span></a></li>
                    <li><a href="#">Phase 3 Installed Mater <span class="pull-right badge bg-aqua" id="vm_d_meter_installed_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="vm_loader_meter_installed">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Bifurcation Meter</h5>
                </div>
                <div class="box-footer no-padding">
                  <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" style="text-align: center;font-weight: bold;">L&amp;T</td>
                    <td colspan="2" style="text-align: center;font-weight: bold;">Genus 3G</td>
                    <td colspan="2" style="text-align: center;font-weight: bold;">Genus 4G</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: center;height:38px;"><span id="supplier_LT">0</span></td>
                    <td colspan="2" style="text-align: center;height:38px;"><span id="supplier_Genus">0</span></td>
                    <td colspan="2" style="text-align: center;height:38px;"><span id="supplier_Genus1">0</span></td>
                  </tr>
                  <tr>
                    <td style="text-align: center;font-weight: bold;">1 Phase</td>
                    <td style="text-align: center;font-weight: bold;">3 Phase</td>
                    <td style="text-align: center;font-weight: bold;">1 Phase</td>
                    <td style="text-align: center;font-weight: bold;">3 Phase</td>
                    <td style="text-align: center;font-weight: bold;">1 Phase</td>
                    <td style="text-align: center;font-weight: bold;">3 Phase</td>
                  </tr>
                  <tr>
                    <td style="text-align: center;height:38px"><span id="supplier_LT_1PH">0</span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_LT_3PH">0</span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus_1PH">0</span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus_3PH">0</span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus1_1PH">0</span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus1_3PH">0</span></td>
                  </tr>
                </table>
                </div>
              </div>
                  <div class="preloader_id" id="superadmin_loader_meter_bifurcation">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
          
          <!-- /.col -->
          </div>

        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="vm_meter_c">{{$all_meter}}</h3>

              <p>All Meters</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="vm_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="vm_sim_c">{{$edf_meter_pool}}</h3>

              <p>All Sim</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="vm_sim_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="vm_modem_c">{{$assigned_meter}}</h3>

              <p>All Modem</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="vm_modem_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="vm_meter_c">{{$rejected_meter}}</h3>

              <p>Installed Meters</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="vm_meter_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function(){
          dashboard_get_vm_meter_c();
        });

        function dashboard_get_vm_meter_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_vm_meter_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#vm_t_meter_c").text(data.vm_t_meter_c);$("#vm_o_meter_c").text(parseInt(data.vm_t_meter_c)-parseInt(data.vm_d_meter_c));$("#vm_d_meter_c").text(data.vm_d_meter_c); $("#vm_loader_meter").hide();$("#vm_meter_c").text(data.vm_t_meter_c);$("#vm_loader_c").hide();dashboard_get_vm_modem_c(); },error: function (error) { dashboard_get_vm_meter_c(); }});};
        function dashboard_get_vm_modem_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_vm_modem_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#vm_t_modem_c").text(data);$("#vm_o_modem_c").text(0);$("#vm_d_modem_c").text(0); $("#vm_loader_modem").hide();$("#vm_modem_loader_c").hide();dashboard_get_vm_sim_c(); },error: function (error) { dashboard_get_vm_modem_c(); }});};
        function dashboard_get_vm_sim_c() {
          $.ajax({url: '{{url('/')}}/api_dashboard_get_vm_sim_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#vm_sim_c").text(data); $("#vm_sim_loader_c").hide();$("#vm_t_meter_installed_c").text(0/*1971+777+1302+103+855+683+3100+793+6328+17056+812+9236+10823+1069+2852+57144+5738+2035+41921+2057+6125+15956+1676+3191+42811+4288+6693+57395+3197+7059+67133+3593+6760+74748+3502+7516);$("#vm_meter_c").text(1971+777+1302+103+855+683+3100+793+6328+17056+812+9236+10823+1069+2852+57144+5738+2035+41921+2057+6125+15956+1676+3191+42811+4288+6693+57395+3197+7059+67133+3593+6760+74748+3502+7516*/);$("#vm_o_meter_installed_c").text(0);$("#vm_d_meter_installed_c").text(0); $("#vm_loader_meter_installed").hide();$("#vm_meter_loader_c").hide();dashboard_admin_meter_bifucation_loader_c(); },error: function (error) { dashboard_get_vm_sim_c(); }});}
          function dashboard_admin_meter_bifucation_loader_c() {  $.ajax({url: '{{url('/')}}/api_admin_meter_bifucation_loader_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#supplier_LT").text(data.supplier_LT);$("#supplier_Genus").text(data.supplier_Genus);$("#supplier_LT_1PH").text(data.supplier_LT_1PH);$("#supplier_LT_3PH").text(data.supplier_LT_3PH);$("#supplier_Genus_1PH").text(data.supplier_Genus_1PH);$("#supplier_Genus_3PH").text(data.supplier_Genus_3PH);$("#supplier_Genus1_1PH").text(data.supplier_Genus1_1PH);$("#supplier_Genus1_3PH").text(data.supplier_Genus1_3PH);$("#superadmin_loader_meter_bifurcation").hide(); },error: function (error) {
    dashboard_admin_meter_bifucation_loader_c();}});};

  </script>      
    @elseif(\Session::get('role')=='4')
        <div class="col-lg-12 col-xs-6">

          <div class="row">
         
           
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Meters</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Meters<span class="pull-right badge bg-blue" id="mrn1_t_meter_c">0</span></a></li>
                    <li><a href="#">OK Meters <span class="pull-right badge bg-green" id="mrn1_o_meter_c">0</span></a></li>
                    <li><a href="#">Defective Meters<span class="pull-right badge bg-red" id="mrn1_d_meter_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="vm_meter_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Modems</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Modems<span class="pull-right badge bg-blue" id="mrn1_t_modem_c">0</span></a></li>
                    <li><a href="#">OK Modems <span class="pull-right badge bg-green" id="mrn1_o_modem_c">0</span></a></li>
                    <li><a href="#">Defective Modems<span class="pull-right badge bg-red" id="mrn1_d_modem_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="mrn1_loader_modem">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
               <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Antennas</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Antennas<span class="pull-right badge bg-blue" id="mrn1_t_antenna_c">0</span></a></li>
                    <li><a href="#">Utilized Antennas<span class="pull-right badge bg-green" id="mrn1_o_antenna_c">0</span></a></li>
                    <li><a href="#">Un-Utilized Antennas<span class="pull-right badge bg-aqua" id="mrn1_d_antenna_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="mrn1_loader_antenna">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            
          
          <!-- /.col -->
          </div>

        </div>   
        <script type="text/javascript">
           $(document).ready(function(){
          dashboard_get_mrn1_meter_c();
        });
        function dashboard_get_mrn1_meter_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_mrn1_meter_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#mrn1_t_meter_c").text(data);$("#mrn1_o_meter_c").text(0);$("#mrn1_d_meter_c").text(0);$("#vm_meter_loader_c").hide(); dashboard_get_mrn1_modem_c(); }});};
        function dashboard_get_mrn1_modem_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_mrn1_modem_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#mrn1_t_modem_c").text(data); $("#mrn1_o_modem_c").text();$("#mrn1_o_modem_c").text(0);$("#mrn1_d_modem_c").text(0); $("#mrn1_loader_modem").hide();dashboard_get_mrn1_antenna_c(); }});};
        function dashboard_get_mrn1_antenna_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_mrn1_antenna_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#mrn1_t_antenna_c").text(data); $("#mrn1_o_antenna_c").text(0);$("#mrn1_d_antenna_c").text(0);$("#mrn1_loader_antenna").hide(); }});};
        </script>
    @elseif(\Session::get('role')=='5')
       <div class="col-lg-12 col-xs-6">

          <div class="row">
         
           
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Meters</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Meters<span class="pull-right badge bg-blue" id="mrn2_t_meter_c">0</span></a></li>
                    <li><a href="#">OK Meters <span class="pull-right badge bg-green" id="mrn2_o_meter_c">0</span></a></li>
                    <li><a href="#">Defective Meters<span class="pull-right badge bg-red" id="mrn2_d_meter_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="vm_meter_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Modems</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Modems<span class="pull-right badge bg-blue" id="mrn2_t_modem_c">0</span></a></li>
                    <li><a href="#">OK Modems <span class="pull-right badge bg-green" id="mrn2_o_modem_c">0</span></a></li>
                    <li><a href="#">Defective Modems<span class="pull-right badge bg-red" id="mrn2_d_modem_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="mrn2_loader_modem">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
               <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Antennas</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Antennas<span class="pull-right badge bg-blue" id="mrn2_t_antenna_c">0</span></a></li>
                    <li><a href="#">Utilized Antennas<span class="pull-right badge bg-green" id="mrn2_o_antenna_c">0</span></a></li>
                    <li><a href="#">Un-Utilized Antennas<span class="pull-right badge bg-aqua" id="mrn2_d_antenna_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="mrn2_loader_antenna">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            
          
          <!-- /.col -->
          </div>

        </div>   
        <script type="text/javascript">
           $(document).ready(function(){
          dashboard_get_mrn2_meter_c();
        });
        function dashboard_get_mrn2_meter_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_mrn2_meter_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#mrn2_t_meter_c").text(data);$("#mrn2_o_meter_c").text(0);$("#mrn2_d_meter_c").text(0);$("#vm_meter_loader_c").hide(); dashboard_get_mrn2_modem_c(); },error: function (error) { dashboard_get_mrn2_meter_c(); }});};
        function dashboard_get_mrn2_modem_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_mrn2_modem_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#mrn2_t_modem_c").text(data); $("#mrn2_o_modem_c").text();$("#mrn2_o_modem_c").text(0);$("#mrn2_d_modem_c").text(0); $("#mrn2_loader_modem").hide();dashboard_get_mrn2_antenna_c(); },error: function (error) { dashboard_get_mrn2_modem_c(); }});};
        function dashboard_get_mrn2_antenna_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_mrn2_antenna_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#mrn2_t_antenna_c").text(data); $("#mrn2_o_antenna_c").text(0);$("#mrn2_d_antenna_c").text(0);$("#mrn2_loader_antenna").hide(); },error: function (error) { dashboard_get_mrn2_antenna_c(); }});};
        </script>  

    @elseif(\Session::get('role')=='6')
    {{-- Do nothing --}}
    @else
       <div class="col-lg-12 col-xs-6">

          <div class="row">
         
           
            <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Meters</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Meters<span class="pull-right badge bg-blue" id="superadmin_t_meter_c">0</span></a></li>
                    <li><a href="#">OK Meters <span class="pull-right badge bg-green" id="superadmin_o_meter_c">0</span></a></li>
                    <li><a href="#">Defective Meters<span class="pull-right badge bg-red" id="superadmin_d_meter_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="superadmin_loader_meter">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Modems</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Modems<span class="pull-right badge bg-blue" id="superadmin_t_modem_c">0</span></a></li>
                    <li><a href="#">OK Modems <span class="pull-right badge bg-green" id="superadmin_o_modem_c">0</span></a></li>
                    <li><a href="#">Defective Modems<span class="pull-right badge bg-red" id="superadmin_d_modem_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="superadmin_loader_modem">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
            
             <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Installed Meter</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Total Installed Meter<span class="pull-right badge bg-blue" id="superadmin_t_meter_installed_c">0</span></a></li>
                    <li><a href="#">Phase 1 Installed Mater <span class="pull-right badge bg-green" id="superadmin_o_meter_installed_c">0</span></a></li>
                    <li><a href="#">Phase 3 Installed Mater <span class="pull-right badge bg-aqua" id="superadmin_d_meter_installed_c">0</span></a></li>
                  </ul>
                </div>
              </div>
                  <div class="preloader_id" id="superadmin_loader_meter_installed">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
             <div class="col-md-3">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active" >
                  
                  <h5 class="widget-user-desc">Bifurcation Meter</h5>
                </div>
                <div class="box-footer no-padding">
                  <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" style="text-align: center;font-weight: bold;">L&amp;T</td>
                    <td colspan="2" style="text-align: center;font-weight: bold;">Genus 3G</td>
                    <td colspan="2" style="text-align: center;font-weight: bold;">Genus 4G</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: center;height:38px;"><span id="supplier_LT"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td colspan="2" style="text-align: center;height:38px;"><span id="supplier_Genus"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td colspan="2" style="text-align: center;height:38px;"><span id="supplier_Genus1"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                  </tr>
                  <tr>
                    <td style="text-align: center;font-weight: bold;">1 Phase</td>
                    <td style="text-align: center;font-weight: bold;">3 Phase</td>
                    <td style="text-align: center;font-weight: bold;">1 Phase</td>
                    <td style="text-align: center;font-weight: bold;">3 Phase</td>
                    <td style="text-align: center;font-weight: bold;">1 Phase</td>
                    <td style="text-align: center;font-weight: bold;">3 Phase</td>
                  </tr>
                  <tr>
                    <td style="text-align: center;height:38px"><span id="supplier_LT_1PH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_LT_3PH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus_1PH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus_3PH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus1_1PH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                    <td style="text-align: center;height:38px"><span id="supplier_Genus1_3PH"><img class="loader_image" src="{{url('/')}}/css_and_js/loader.gif"></span></td>
                  </tr>
                </table>
                </div>
              </div>
                  <div class="preloader_id" id="superadmin_loader_meter_bifurcation">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
              <!-- /.widget-user -->
            </div>
          
          <!-- /.col -->
          </div>

        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="superadmin_meter_c">{{$all_meter}}</h3>

              <p>All Meters</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="superadmin_loader_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="superadmin_meter_pool_c">{{$edf_meter_pool}}</h3>

              <p>EDF Meter Pool</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="superadmin_loader_pool_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="superadmin_meter_assign_c">{{$assigned_meter}}</h3>

              <p>Assigned Meters</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="superadmin_loader_assign_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="superadmin_meter_reject_c">{{$rejected_meter}}</h3>

              <p>Damaged Meters</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <div class="preloader_id" id="superadmin_loader_reject_c">
            <div id="preloader__status">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
          </div>
          </div>
        </div>

          <script type="text/javascript">
    $(document).ready(function(){
      dashboard_get_admin_meter_c();
      dashboard_admin_meter_pool_c();
      dashboard_admin_modem_c();
      dashboard_admin_meter_reject_loader_c();
      dashboard_admin_meter_bifucation_loader_c();
    });


    function dashboard_get_admin_meter_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_get_admin_meter_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#superadmin_meter_c").text(data.t_meter_c);$("#superadmin_t_meter_c").text(data.t_meter_c); $("#superadmin_loader_c").hide();$("#superadmin_loader_meter").hide();$("#superadmin_o_meter_c").text(parseInt(data.t_meter_c)-parseInt(data.d_meter_c));$("#superadmin_d_meter_c").text(data.d_meter_c);dashboard_admin_meter_pool_c(); },error: function (error) {
    dashboard_get_admin_meter_c();}});};

    function dashboard_admin_meter_pool_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_admin_meter_pool_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#superadmin_meter_pool_c").text(data); $("#superadmin_loader_pool_c").hide();dashboard_admin_meter_assign_c(); },error: function (error) {
    dashboard_admin_meter_pool_c();}});};
    function dashboard_admin_meter_assign_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_admin_meter_assign_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#superadmin_meter_assign_c").text(data); $("#superadmin_loader_assign_c").hide();dashboard_admin_modem_c(); },error: function (error) {
    dashboard_admin_meter_assign_c();}});};
    
    function dashboard_admin_modem_c() {  $.ajax({url: '{{url('/')}}/api_dashboard_admin_modem_loader_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#superadmin_modem_c").text(data);$("#superadmin_t_modem_c").text(data); $("#superadmin_modem_loader_c").hide();$("#superadmin_loader_modem").hide();$("#superadmin_o_modem_c").text(0);$("#superadmin_d_modem_c").text(0);dashboard_admin_meter_reject_loader_c(); },error: function (error) {
    dashboard_admin_modem_c();}});};
    
    function dashboard_admin_meter_reject_loader_c() {  $.ajax({url: '{{url('/')}}/api_admin_meter_reject_loader_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#superadmin_meter_reject_c").text(data);$("#admin_o_antenna_c").text(0);$("#admin_d_antenna_c").text(0); $("#superadmin_loader_reject_c").hide();$("#superadmin_loader_reject_c").hide();$("#superadmin_loader_meter_installed").hide();$("#superadmin_t_meter_installed_c").text(0/*1971+777+1302+103+855+683+3100+793+6328+17056+812+9236+10823+1069+2852+57144+5738+2035+41921+2057+6125+15956+1676+3191+42811+4288+6693+57395+3197+7059+67133+3593+6760+74748+3502+7516*/);dashboard_admin_meter_bifucation_loader_c(); },error: function (error) {
    dashboard_admin_meter_reject_loader_c();}});};

    function dashboard_admin_meter_bifucation_loader_c() {  $.ajax({url: '{{url('/')}}/api_admin_meter_bifucation_loader_c',type: 'post',data:{"_token": "{{ csrf_token() }}"},success: function (data) { $("#supplier_LT").text(data.supplier_LT);$("#supplier_Genus").text(data.supplier_Genus);$("#supplier_LT_1PH").text(data.supplier_LT_1PH);$("#supplier_LT_3PH").text(data.supplier_LT_3PH);$("#supplier_Genus_1PH").text(data.supplier_Genus_1PH);$("#supplier_Genus_3PH").text(data.supplier_Genus_3PH);$("#supplier_Genus1").text(data.supplier_Genus1);$("#supplier_Genus1_1PH").text(data.supplier_Genus1_1PH);$("#supplier_Genus1_3PH").text(data.supplier_Genus1_3PH);$("#superadmin_loader_meter_bifurcation").hide(); },error: function (error) {
    dashboard_admin_meter_bifucation_loader_c();}});};
  </script>       
    @endif


        <!-- ./col -->
      <div class="col-lg-12 col-xs-6" @if(\Session::get('role')=='6') style="display: none;" @endif>
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              {{-- <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
              <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
               --}}<li class="pull-left header"><i class="fa fa-inbox"></i> Meter Installation</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="bar-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
        </div>
      </div>
     
        
    </section>
    <!-- /.content -->
  </div>
 
  <!-- /.content-wrapper -->

  
  
  
@endsection