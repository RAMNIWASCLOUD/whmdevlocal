<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use \MongoDB\BSON\ObjectID as MongoId;
class ReportController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        $this->title             = "Report";
        $this->url_slug          = "report";
        $this->folder_path       = "admin/report/";
    }

    public function report_fresh_wh_inventory()
    {
        $data     = [];

        if(!empty($_GET))
        {
            $date = $_GET['search'];
        }
        else
        {
            $date = date('Y-m-d');
        }
        $daily_meter_inventory        = \DB::table('daily_meter_inventory')->where(['meter'=>'Genus 3G'])->where('date','=',$date)->first();
        $data['goe_opening_stock_3g'] = (!empty($daily_meter_inventory))? $daily_meter_inventory['Opening_stock']:0;
        $daily_meter_inventory        = \DB::table('daily_meter_inventory')->where(['meter'=>'Genus 4G'])->where('date','=',$date)->first();
        $data['goe_opening_stock_4g'] = (!empty($daily_meter_inventory))? $daily_meter_inventory['Opening_stock']:0;
        $daily_meter_inventory        = \DB::table('daily_meter_inventory')->where(['meter'=>'L&T'])->where('date','=',$date)->first();
        $data['L_an_T_opening_stock'] = (!empty($daily_meter_inventory))? $daily_meter_inventory['Opening_stock']:0;
        $data['goe_dispatch_3g']      = 0;
        $data['goe_dispatch_4g']      = 0;
        $data['L_an_T_dispatch']      = 0;






        $data['_1phase_SBPDCL'] = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase'])->count();
        $data['_3phase_SBPDCL'] = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase'])->count();
        $data['_1phase_NBPDCL'] = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase'])->count();
        $data['_3phase_NBPDCL'] = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase'])->count();
        $data['_1phase_To_Be_Mapped'] = 0;
        $data['_3phase_To_Be_Mapped'] = 0;






        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'report_fresh_wh_inventory',$data);
    }

    public function report_vendor_wh_inventory()
    {
        $cursor     = \DB::table('login_users')->where(['role'=>'3'])->get();
        $data['data_meter']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'report_vendor_wh_inventory',$data);
    }

    public function report_faulty_warranty_management()
    {
        
        $cursor     = [];//\DB::table('meter')->get();
        
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'report_faulty_warranty_management',$data);
    }

    public function daily_mis()
    {
        if(!empty($_GET))
        {
            $date = $_GET['search'];
        }
        else
        {
            $date = date('Y-m-d');
        }
        $cursor     = \DB::table('meter')->where('date','=',$date)->limit(1)->get();
        
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'daily_mis',$data);
    }

    public function report_inventory_upload_file()
    {
        
         if(!empty($_GET))
        {
            $date = $_GET['search'];
        }
        else
        {
            $date = date('Y-m-d');
        }
        $cursor     = \DB::table('meter')/*->where('date','=',$date)*/->where(['device_id'=>'GOEGP15861668'])->get();
        
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'report_inventory_upload_file',$data);
    }

    /*public function daily_mis()
    {
        $cursor     = \DB::table('meter')->where('date','=',$date)->where(['device_id'=>'GOEGP15861668'])->get();
        foreach ($variable as $key => $value) {
            
        }

    }
    public function report_master_mis()
    {

    }
    public function report_inventory_upload_file()
    {

    }*/

    public function test_report_repaired()
    {
        /*$arr = \DB::table('meter')->where(['damaged_status'=>'Repaired'])->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=procedure_repaired_meter_report.csv");
        header("Pragma: no-cache");
        header("Expires: 0");*/
        // $arr = \DB::table('meter')->where(['sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','Yes')->get();
        // header("Content-type: text/csv");
        // header("Content-Disposition: attachment; filename=available_at EDF.csv");
        // header("Pragma: no-cache");
        // header("Expires: 0");
        /*$arr = \DB::table('meter')->where(['supplier_status'=>'pending'])->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=send_to_supplier.csv");
        header("Pragma: no-cache");
        header("Expires: 0");*/
        /*$arr = \DB::table('meter')->where(['supplier_status'=>'approved'])->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=return_from_supplier.csv");
        header("Pragma: no-cache");
        header("Expires: 0");*/
        /*$arr = \DB::table('meter')->where(['swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>'NBPD'])->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=NBPD_meter_pool.csv");
        header("Pragma: no-cache");
        header("Expires: 0");*/
        /*$arr = \DB::table('meter')->where(['sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','Yes')->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Accepted Damaged Meters.csv");
        header("Pragma: no-cache");
        header("Expires: 0");*/
          
          $arr = \DB::table('meter')->select('device_id')->where(['swh_inventory_status'=>'Outstock'])->where(['whm_system_utility'=>'NBPD'])->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=NBPD_dispatch.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

          echo "Sr. No.";
          echo ',';
          echo "Device id";
          echo ',';
          echo "\n"; 

        foreach ($arr as $key => $value) 
        {
            $c             = ($key+1);
            echo $c;
            echo ',';
            echo $value['device_id'];
            echo ',';echo "\n"; 
        }
    }

    public function export_report($id)
    {

        $query = \DB::table('meter');           
        switch ($id) {
            //supplier
            case 'supplier_pending_meter':
                $query = $query->where(['supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')]);
                $report_name = $id;
                break;
            case 'supplier_approved_meter':
                $query = $query->where(['supplier_status'=>'approved','batch_supplier'=>\Session::get('warehouse_name')]);
                $report_name = $id;
                break;
            case 'supplier_admin_approved_meter':
                $query = $query->where(['supplier_status'=>'admin_approved','batch_supplier'=>\Session::get('warehouse_name')]);
                $report_name = $id;
                break;
            case 's2s_supplier_pending_meter':
                $query = $query->where(['s2s_supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')]);
                $report_name = $id;
                break;
            case 's2s_supplier_approved_meter':
                $query = $query->where(['s2s_supplier_status'=>'approved','batch_supplier'=>\Session::get('warehouse_name')]);
                $report_name = $id;
                break;
            case 's2s_supplier_admin_approved_meter':
                $query = $query->where(['s2s_supplier_status'=>'admin_approved','batch_supplier'=>\Session::get('warehouse_name')]);
                $report_name = $id;
                break;

            //vendor manager
            case 'vm_manage_meter':
                $query = $query->where(['swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);
                $report_name = $id;
                break;
            case 'vm_damaged_meter':
                $query = $query->where(['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
                $report_name = $id;
                break;
            case 's2s_vm_damaged_meter':
                $query = $query->where(['s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','s2s_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
                $report_name = $id;
                break;
            //State warehouse
            case 'swh_edf_meter_pool':
                $query = $query->where(['swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
                $report_name = $id;
                break;
            case 'sm_damaged_meter':
                $query = $query->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_swh'=>'Yes','is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')/*'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/]);
                $report_name = $id;
                break;
            case 'vm_to_sm_damaged_meter':
                $query = $query->where(['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/]);
                $report_name = $id;
                break;
            case 's2s_sm_damaged_meter':
                $query = $query->where(['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_swh'=>'Yes','s2s_is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')/*'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/]);
                $report_name = $id;
                break;
            case 's2s_vm_to_sm_damaged_meter':
                $query = $query->where(['s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/]);
                $report_name = $id;
                break;
            //admin warehouse
            case 'sm_to_admin_pending_acceptance_damaged_meter':
                $query = $query->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>'']);
                $report_name = $id;
                break;
            case 'sm_to_admin_damaged_meter':
                $query = $query->where(['sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','Yes');
                $report_name = $id;
                break;
            case 'send_to_supplier':
                $query = $query->where(['supplier_status'=>'pending']);
                $report_name = $id;
                break;
            case 'return_from_supplier':
                $query = $query->where(['supplier_status'=>'approved']);
                $report_name = $id;
                break;
            case 'repaired_meter':
                $query = $query->where(['damaged_status'=>'Repaired','vmwh_mrn_ref'=>'']);
                $report_name = $id;
                break;
            case 's2s_sm_to_admin_pending_acceptance_damaged_meter':
                $query = $query->where(['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_admin'=>'']);
                $report_name = $id;
                break;
            case 's2s_sm_to_admin_damaged_meter':
                $query = $query->where(['s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','Yes');
                $report_name = $id;
                break;
            case 's2s_send_to_supplier':
                $query = $query->where(['s2s_supplier_status'=>'pending']);
                $report_name = $id;
                break;
            case 's2s_return_from_supplier':
                $query = $query->where(['s2s_supplier_status'=>'approved']);
                $report_name = $id;
                break;
            case 's2s_repaired_meter':
                $query = $query->where(['s2s_damaged_status'=>'Repaired']);
                $report_name = $id;
                break;
            case 'edf_meter_pool':
                $query = $query->where(['batch_status'=>'Approved','dl_ch_ref'=>'']);
                $report_name = $id;
                break;
            case 's2s_edf_meter_pool':
                $query = $query->where(['batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
                $report_name = $id;
                break;
            case 'reject_meter':
                $query = $query->where('supplier_status','=','admin_approved')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->where('supplier_status','=','admin_approved');
                $report_name = $id;
                break;
            case 'phisical_damage':
                $query = $query->where(['physical_testing_status'=>'Damaged','date_of_dispatch_to_OEM_repair'=>'']);
                $report_name = $id;
                break;
            case 'permanent_damage_meter':
                $query = $query->where('damaged_status','=','Permanent Damage');
                $report_name = $id;
                break;
            case 's2s_permanent_damage_meter':
                $query = $query->where('s2s_damaged_status','=','Permanent Damage');
                $report_name = $id;
                break;
                
            default:
                $query = $query->where(['any'=>'0']); 
                $report_name = 'report_error';
                break;
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=".$report_name.".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo 'batch_invoice_no';
        echo ',';
        echo 'batch_invoice_date';
        echo ',';
        echo 'batch_waybill_no';
        echo ',';
        echo 'batch_waybill_date';
        echo ',';
        echo 'device_id';
        echo ',';
        echo 'meter_created_at';
        echo ',';
        echo 'phase_type';
        echo ',';
        echo 'sim_no';
        echo ',';
        echo 'imei_no';
        echo ',';
        echo 'whm_system_utility';
        echo ',';
        echo 'last_meter_location';
        echo ',';
        echo 'swh_delivery_time';
        echo ',';
        echo 'current_meter_status';
        echo ',';
        echo 'status';
        echo ',';
        echo 'edf_vendor_manager_name';
        echo ',';
        echo 'batch_supplier';
        echo ',';
        echo 'whm_vendor_manager_name';
        echo ',';
        echo 'date_of_dispatch_to_OEM_repair';
        echo ',';
        echo 'date_of_receipt_of_meter_WH';
        echo ',';
        echo 'date_of_receipt_of_refurbished';
        echo ',';
        echo 'refurbished_meter_received_date';
        echo ',';
        echo 'faulty_declared_date';
        echo ',';
        echo 's2s_faulty_declared_date';
        echo ',';
        echo 's2s_date_of_receipt_of_meter_WH';
        echo ',';
        echo 's2s_date_of_dispatch_to_OEM_repair';
        echo ',';
        echo 's2s_date_of_receipt_of_refurbished';
        echo ',';
        echo 's2s_refurbished_meter_received_date';
        echo ',';
        echo 'reveived_date';
        echo ',';
        echo 'vendor_dispatched_date';
        echo ',';
        echo 'swh_inventory_status';
        echo ',';
        echo "\n"; 
        $arr = $query->orderBy('_id')->chunk(20000, function ($chunk_records) {
            foreach ($chunk_records as $record) {
                echo $record['batch_invoice_no'];
                echo ',';
                echo $record['batch_invoice_date'];
                echo ',';
                echo $record['batch_waybill_no'];
                echo ',';
                echo $record['batch_waybill_date'];
                echo ',';
                echo $record['device_id'];
                echo ',';
                echo $record['meter_created_at'];
                echo ',';
                echo $record['phase_type'];
                echo ',';
                echo $record['sim_no'];
                echo ',';
                echo $record['imei_no'];
                echo ',';
                echo $record['whm_system_utility'];
                echo ',';
                echo $record['last_meter_location'];
                echo ',';
                echo $record['swh_delivery_time'];
                echo ',';
                echo $record['current_meter_status'];
                echo ',';
                echo $record['status'];
                echo ',';
                echo $record['edf_vendor_manager_name'];
                echo ',';
                echo $record['batch_supplier'];
                echo ',';
                echo $record['whm_vendor_manager_name'];
                echo ',';
                echo $record['date_of_dispatch_to_OEM_repair'];
                echo ',';
                echo $record['date_of_receipt_of_meter_WH'];
                echo ',';
                echo $record['date_of_receipt_of_refurbished'];
                echo ',';
                echo $record['refurbished_meter_received_date'];
                echo ',';
                echo $record['faulty_declared_date'];
                echo ',';
                echo $record['s2s_faulty_declared_date'];
                echo ',';
                echo $record['s2s_date_of_receipt_of_meter_WH'];
                echo ',';
                echo $record['s2s_date_of_dispatch_to_OEM_repair'];
                echo ',';
                echo $record['s2s_date_of_receipt_of_refurbished'];
                echo ',';
                echo $record['s2s_refurbished_meter_received_date'];
                echo ',';
                echo $record['reveived_date'];
                echo ',';
                echo $record['vendor_dispatch_date'];
                echo ',';
                echo $record['swh_inventory_status'];
                echo ',';echo "\n"; 
            }
        });
        
        // $arr = $query->get();
        // $this->master_export_function($arr,$report_name);
    }

    public function master_export_function($arr,$report_name)
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=".$report_name.".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
          
        echo 'Sr. No.';
        echo ',';
        echo 'batch_invoice_no';
        echo ',';
        echo 'batch_invoice_date';
        echo ',';
        echo 'batch_waybill_no';
        echo ',';
        echo 'batch_waybill_date';
        echo ',';
        echo 'device_id';
        echo ',';
        echo 'meter_created_at';
        echo ',';
        echo 'phase_type';
        echo ',';
        echo 'sim_no';
        echo ',';
        echo 'imei_no';
        echo ',';
        echo 'whm_system_utility';
        echo ',';
        echo 'last_meter_location';
        echo ',';
        echo 'swh_delivery_time';
        echo ',';
        echo 'current_meter_status';
        echo ',';
        echo 'status';
        echo ',';
        echo 'edf_vendor_manager_name';
        echo ',';
        echo 'batch_supplier';
        echo ',';
        echo 'whm_vendor_manager_name';
        echo ',';
        echo 'date_of_dispatch_to_OEM_repair';
        echo ',';
        echo 'date_of_receipt_of_meter_WH';
        echo ',';
        echo 'date_of_receipt_of_refurbished';
        echo ',';
        echo 'refurbished_meter_received_date';
        echo ',';
        echo 'faulty_declared_date';
        echo ',';
        echo 's2s_faulty_declared_date';
        echo ',';
        echo 's2s_date_of_receipt_of_meter_WH';
        echo ',';
        echo 's2s_date_of_dispatch_to_OEM_repair';
        echo ',';
        echo 's2s_date_of_receipt_of_refurbished';
        echo ',';
        echo 's2s_refurbished_meter_received_date';
        echo ',';
        echo 'reveived_date';
        echo ',';
        echo 'vendor_dispatched_date';
        echo ',';
        echo 'swh_inventory_status';
        echo ',';
        echo "\n"; 

        foreach ($arr as $key => $line) 
        {
            $c             = ($key+1);
            echo $c;
            echo ',';
            echo $line['batch_invoice_no'];
            echo ',';
            echo $line['batch_invoice_date'];
            echo ',';
            echo $line['batch_waybill_no'];
            echo ',';
            echo $line['batch_waybill_date'];
            echo ',';
            echo $line['device_id'];
            echo ',';
            echo $line['meter_created_at'];
            echo ',';
            echo $line['phase_type'];
            echo ',';
            echo $line['sim_no'];
            echo ',';
            echo $line['imei_no'];
            echo ',';
            echo $line['whm_system_utility'];
            echo ',';
            echo $line['last_meter_location'];
            echo ',';
            echo $line['swh_delivery_time'];
            echo ',';
            echo $line['current_meter_status'];
            echo ',';
            echo $line['status'];
            echo ',';
            echo $line['edf_vendor_manager_name'];
            echo ',';
            echo $line['batch_supplier'];
            echo ',';
            echo $line['whm_vendor_manager_name'];
            echo ',';
            echo $line['date_of_dispatch_to_OEM_repair'];
            echo ',';
            echo $line['date_of_receipt_of_meter_WH'];
            echo ',';
            echo $line['date_of_receipt_of_refurbished'];
            echo ',';
            echo $line['refurbished_meter_received_date'];
            echo ',';
            echo $line['faulty_declared_date'];
            echo ',';
            echo $line['s2s_faulty_declared_date'];
            echo ',';
            echo $line['s2s_date_of_receipt_of_meter_WH'];
            echo ',';
            echo $line['s2s_date_of_dispatch_to_OEM_repair'];
            echo ',';
            echo $line['s2s_date_of_receipt_of_refurbished'];
            echo ',';
            echo $line['s2s_refurbished_meter_received_date'];
            echo ',';
            echo $line['reveived_date'];
            echo ',';
            echo $line['vendor_dispatch_date'];
            echo ',';
            echo $line['swh_inventory_status'];
            echo ',';echo "\n"; 
        }
    }


    public function report_master_mis()
    {
        if(!empty($_GET))
        {
            $date = $_GET['search'];
        }
        else
        {
            $date = date('Y-m-d');
        }
        $cursor     = \DB::table('meter')/*->where('date','=',$date)*/->where(['device_id'=>'GOEGP15861668'])->get();
        
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'report_master_mis',$data);
    }

   
}
