<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use \MongoDB\BSON\ObjectID as MongoId;
class MeternewController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        $this->title             = "Meters";
        $this->url_slug          = "meter";
        $this->folder_path       = "admin/meter/";
        ini_set('memory_limit', '8192M');
        ini_set('max_execution_time', '0');
        
    }

    public function index()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['device_phase'])/* && !empty($_GET['search_batch'])*/)
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated'])->where('device_id','like',''.$_GET['search'].'')->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated'])->where('device_id','like',''.$_GET['search'].'');
            }
            elseif(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated'])->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated'])->where('batch_id','like',''.$_GET['search_batch'].'');
            }
            else
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated']);
            }
        }
        else
        {
            $cursor = $cursor->where(['physical_testing_status'=>'sagregated']);
        }
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "All";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }

    public function edf_installed_meter()
    {
        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_%')->count();
        dd($sim);*/
        /*echo '<pre>';
        system("cat /proc/cpuinfo | grep \"model name\\|processor\"");
        $fh = fopen('/proc/meminfo','r');
        $mem = 0;
        while ($line = fgets($fh)) {
        $pieces = array();
        if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
        $mem = $pieces[1];
        break;
        }
        }
        fclose($fh);

        echo "$mem kB RAM found";die;*/
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['device_phase'])/* && !empty($_GET['search_batch'])*/)
            {
                $cursor = $cursor->where(['edf_status'=>'Installed'])->where('device_id','like',''.$_GET['search'].'')->where('dlms_companion','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['edf_status'=>'Installed'])->where('device_id','like',''.$_GET['search'].'');
            }
            elseif(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->where(['edf_status'=>'Installed'])->where('dlms_companion','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['edf_status'=>'Installed'])->where('batch_id','like',''.$_GET['search_batch'].'');
            }
            else
            {
                $cursor = $cursor->where(['edf_status'=>'Installed']);
            }
        }
        else
        {
            $cursor = $cursor->where(['edf_status'=>'Installed']);
        }
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'EDF Installed Meter';
        return view($this->folder_path.'edf_installed_meter',$data);
    }

    public function report_dumps()
    {
        $data['page_name'] = "";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Dumps';
        return view($this->folder_path.'report_dumps',$data);
    }

    public function metermovement()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) || isset($_GET['device_phase']) || isset($_GET['sm']) || isset($_GET['vm']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where('device_id','like',''.$_GET['search'].'');
            }
            if(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            if(!empty($_GET['sm']))
            {
                $cursor = $cursor->where(['swh'=>new MongoId($_GET['sm'])]);
            }
            if(!empty($_GET['vm']))
            {
                $cursor = $cursor->where(['vmwh'=>new MongoId($_GET['vm'])]);
            }
        }
        else
        {
            $cursor = $cursor;
        }
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Meter Movement';
        return view($this->folder_path.'metermovement',$data);
    }

    public function edf_reject_meter()
    {   
        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_%')->count();
        dd($sim);*/
        /*$m = \DB::table('meter')->select(['device_id','sim_no2'])->get();
        foreach ($m as $key => $value) {
        
            \DB::table('meter')->where(['device_id'=>$value['device_id']])->update(['sim_no'=>'sim_'.$value['sim_no2']]);
        }
        echo 'success';
        die;*/

        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_%')->orderBy('_id','ASC')->chunk(5000, function($data) {
            foreach ($data as $key => $value) {
               $sim_no = str_replace('sim_', '', str_replace('sim_', '', str_replace('sim_', '', $value['sim_no'])));
               \DB::table('meter')->where(['sim_no'=>$value['sim_no']])->update((['sim_no'=>$sim_no]));
               //print_r($value['sim_no']);die;
               //die;
               
            }
        });
        echo 'success';
        die;*/
        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_sim_sim_sim_sim_sim_sim_sim_sim_sim_sim_%')->limit(1)->get();
        dd($sim);*/

        // $temp = \DB::table('login_users')->where(['role'=>'3'])/*->where(['username'=>'AI_PATNA_SB@email.com'])*/->get();
        /*$temp = \DB::table('login_users')->where(['role'=>'3'])->get();
        foreach ($temp as $key => $value) 
        {
            $meter = \DB::table('meter')->where(['vmwh'=>$value['_id']])->update(['whm_vendor_manager_name'=>$value['warehouse_name']]);
            
        }*/
        //echo 'success';
        //die;
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['device_phase'])/* && !empty($_GET['search_batch'])*/)
            {
                $cursor = $cursor->where(['edf_status'=>'Replaced'])->where('device_id','like',''.$_GET['search'].'')->where('dlms_companion','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['edf_status'=>'Replaced'])->where('device_id','like',''.$_GET['search'].'');
            }
            elseif(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->where(['edf_status'=>'Replaced'])->where('dlms_companion','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['edf_status'=>'Replaced'])->where('batch_id','like',''.$_GET['search_batch'].'');
            }
            else
            {
                $cursor = $cursor->where(['edf_status'=>'Replaced']);
            }
        }
        else
        {
            $cursor = $cursor->where(['edf_status'=>'Replaced']);
        }
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'EDF Damage Meter';
        return view($this->folder_path.'edf_reject_meter',$data);
    }

    public function manage_intransit()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['device_phase'])/* && !empty($_GET['search_batch'])*/)
            {
                $cursor = $cursor->orwhere(['physical_testing_status'=>'sagregated'])->where('device_id','like',''.$_GET['search'].'')->where('dlms_companion','like',''.$_GET['device_phase'].'')->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse']);
                $cursor = $cursor->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse'])->where(['physical_testing_status'=>'sagregated'])->where('device_id','like',''.$_GET['search'].'')->where('dlms_companion','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->orwhere(['physical_testing_status'=>'sagregated'])->where('device_id','like',''.$_GET['search'].'')->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse']);
                $cursor = $cursor->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse'])->where(['physical_testing_status'=>'sagregated'])->where('device_id','like',''.$_GET['search'].'');
            }
            elseif(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->orwhere(['physical_testing_status'=>'sagregated'])->where('dlms_companion','like',''.$_GET['device_phase'].'')->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse']);
                $cursor = $cursor->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse'])->where(['physical_testing_status'=>'sagregated'])->where('dlms_companion','like',''.$_GET['device_phase'].'');
            }
            else
            {
                $cursor = $cursor->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse']);
            }
        }
        else
        {
            $cursor = $cursor->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse']);
        }
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "Inventory in transit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'manage_intransit',$data);
    }

    public function ghost_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['device_phase'])/* && !empty($_GET['search_batch'])*/)
            {
                $cursor = $cursor->where(['status'=>'Unknown'])->where('device_id','like',''.$_GET['search'].'')->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['status'=>'Unknown'])->where('device_id','like',''.$_GET['search'].'');
            }
            elseif(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->where(['status'=>'Unknown'])->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['status'=>'Unknown'])->where('batch_id','like',''.$_GET['search_batch'].'');
            }
            else
            {
                $cursor = $cursor->where(['status'=>'Unknown']);
            }
        }
        else
        {
            $cursor = $cursor->where(['status'=>'Unknown']);
        }
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "Ghost Meters";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'ghost_meter',$data);
    }

    public function warranty_expiring_in_one_month()
    {
        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_%')->count();
        dd($sim);*/
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');

        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['device_phase'])/* && !empty($_GET['search_batch'])*/)
            {
                $cursor = $cursor->where(['status'=>'Expiring'])->where('device_id','like',''.$_GET['search'].'')->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['status'=>'Expiring'])->where('device_id','like',''.$_GET['search'].'');
            }
            elseif(!empty($_GET['device_phase']))
            {
                $cursor = $cursor->where(['status'=>'Expiring'])->where('phase_type','like',''.$_GET['device_phase'].'');
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['status'=>'Expiring'])->where('batch_id','like',''.$_GET['search_batch'].'');
            }
            else
            {
                $cursor = $cursor->where(['status'=>'Expiring']);
            }
        }
        else
        {
            $cursor = $cursor->where(['status'=>'Expiring']);
        }
        
        
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "Warranty Expiring In One Month";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'warranty_expiring_in_one_month',$data);
    }

    public function swh_manage_meter()
    {
        //$data = \DB::table('meter')->where(['batch_id'=>'Batch-03_11_2022_09:17:56','swh_inventory_status'=>'Outstock','vmwh_name'=>'Intellismart_Patna_NB'])->update(['swh_inventory_status'=>'Instock','vmwh_name'=>'','last_meter_location'=>'NBPDCL','last_meter_location_time'=>1669267994,'current_meter_status'=>'Open in EDF pool','vmwh'=>'']);
        //dd($data);
        //die;
        //dd(\DB::table('meter')->where(['batch_id'=>'Batch-03_11_2022_09:17:56','swh_inventory_status'=>'Outstock'])->groupBy('vmwh_name')->get());
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) || isset($_GET['search_batch']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_id'=>$_GET['search_batch'],/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            else
            {
                $cursor = $cursor->where([/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
        }
        else
        {
            $cursor = $cursor->where([/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "All";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'swh_manage_meter',$data);
    }
    
    public function segregated_hesm($id)
    {
        $cursor     = \DB::table('meter')->where(['whm_system_utility_id'=>(int)$id])->orderBy('createdAt','ASC')->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=HESM_".$id.".csv");
        header("Pragma: no-cache");
        header("Expires: 0"); 
        die;
        foreach ($cursor as $key =>$value) 
        {
            echo $value['device_id'].";".$value['manufacturer_serial_number'].";".$value['device_type'].";".$value['device_subtype'].";".$value['device_model_number'].";;2019;2019;".$value['device_protocol'].";;;".$value['device_firmware_version'].";;;".$value['device_communication_technology'].";;;;;".$value['device_communication_module_imei_number'].";".$value['dlms_tcp_port'].";".$value['dlms_communication_profile'].";32;;;;1A2B3C4D;0;1;0;".$value['dlms_companion'].";1.0;".$value['device_utilityid'].";".$value['whm_system_utility'].";\n";

            echo $value['device_id'].";".$value['manufacturer_serial_number'].";".$value['device_type'].";".$value['device_subtype'].";".$value['device_model_number'].";;2019;2019;".$value['device_protocol'].";;;".$value['device_firmware_version'].";;;".$value['device_communication_technology'].";;;;;".$value['device_communication_module_imei_number'].";".$value['dlms_tcp_port'].";".$value['dlms_communication_profile'].";48;47656e75734d61737465724b65793036;6565736c656b616b67736c3036616263;6565736c656b616b67736c3036616263;eeslhlsugsl06abc;3;2;0;".$value['dlms_companion'].";1.0;".$value['device_utilityid'].";".$value['whm_system_utility'].";\n";

            echo $value['device_id'].";".$value['manufacturer_serial_number'].";".$value['device_type'].";".$value['device_subtype'].";".$value['device_model_number'].";;2019;2019;".$value['device_protocol'].";;;".$value['device_firmware_version'].";;;".$value['device_communication_technology'].";;;;;".$value['device_communication_module_imei_number'].";".$value['dlms_tcp_port'].";".$value['dlms_communication_profile'].";80;47656e75734d61737465724b65793036;6565736c656b616b67736c3036616263;6565736c656b616b67736c3036616263;eeslhlsfgsl06abc;3;2;0;".$value['dlms_companion'].";1.0;".$value['device_utilityid'].";".$value['whm_system_utility'].";\n";
                
        }
    }

    public function segregated_hess($id)
    {
        $cursor     = \DB::table('meter')->where(['whm_system_utility_id'=>(int)$id])->orderBy('createdAt','ASC')->get();

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=HESS_".$id.".csv");
        header("Pragma: no-cache");
        header("Expires: 0"); 
        foreach ($cursor as $key =>$value) 
        {
            $cursor1    = \DB::table('bsnl_sim')->where(['sim_no'=>$value['sim_no']])->orderBy('createdAt','ASC')->get();
            foreach ($cursor1 as $key1 =>$value1) 
            {
                echo $value1['imsi'].";".$value1['sim_no'].";".$value1['static_ip'].";;".$value1['apn'].";".$value1['status'].";\n";
            }
        }  
    }
    
    public function segregated_hesms($id)
    {
        $cursor     = \DB::table('meter')->where(['whm_system_utility_id'=>(int)$id])->orderBy('createdAt','ASC')->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=HESMS_".$id.".csv");
        header("Pragma: no-cache");
        header("Expires: 0"); 
        foreach ($cursor as $key =>$value) 
        {
            $cursor1    = \DB::table('bsnl_sim')->where(['sim_no'=>$value['sim_no']])->orderBy('createdAt','ASC')->get();
            foreach ($cursor1 as $key1 =>$value1) 
            {
                echo $value['device_id'].";".$value['device_type'].";".$value1['imsi'].";;".$value1['sim_no'].";\n";
                break;
            }
        }       
    }
    public function segregated_mdmm($id)
    {
        $cursor     = \DB::table('meter')->where(['whm_system_utility_id'=>(int)$id])->orderBy('createdAt','ASC')->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=MDMM_".$id.".csv");
        header("Pragma: no-cache");
        header("Expires: 0"); 
        //dd($cursor);
        foreach ($cursor as $key =>$value) 
        {
            echo $value['device_id'].";".$value['manufacturer_serial_number'].";".$value['phase_type'].";".$value['sim_no'].";".$value['whm_system_utility'].";\n";
        }      
    }
    public function segregated_mdms($id)
    { 
        $cursor     = \DB::table('meter')->where(['whm_system_utility_id'=>(int)$id])->orderBy('createdAt','ASC')->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=MDMS_".$id.".csv");
        header("Pragma: no-cache");
        header("Expires: 0"); 
        foreach ($cursor as $key =>$value) 
        {
            $cursor1    = \DB::table('bsnl_sim')->where(['sim_no'=>$value['sim_no']])->orderBy('createdAt','ASC')->get();
            
            foreach ($cursor1 as $key1 =>$value1) 
            {
                echo $value1['imsi'].";".$value1['sim_no'].";".$value1['static_ip'].";;".$value1['apn'].";".$value1['status'].";".$value['whm_system_utility'].";\n";
                break;
            }
        }     
    }
    public function segregated_mdmsm($id)
    {
        $cursor     = \DB::table('meter')->where(['whm_system_utility_id'=>(int)$id])->orderBy('createdAt','ASC')->get();
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=MDMSM_".$id.".csv");
        header("Pragma: no-cache");
        header("Expires: 0"); 
        foreach ($cursor as $key =>$value) 
        {
            $cursor1    = \DB::table('bsnl_sim')->where(['sim_no'=>$value['sim_no']])->orderBy('createdAt','ASC')->get();
            
            foreach ($cursor1 as $key1 =>$value1) 
            {
                echo $value['device_id'].";".$value['device_type'].";".$value1['imsi'].";;".$value1['sim_no'].";".$value['whm_system_utility'].";\n";
                break;
            }
        }          
    }

    public function change_utility(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $fh = fopen($_FILES['file']['tmp_name'], 'r+');   
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        if(isset($details[0]) && !empty($details[0]))
                        {
                            $new_data                       = [];
                            $new_data['whm_system_utility'] = $request->input('utility');
                            
                            $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->first();
                            if(!empty($responce))
                            {
                                $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->update($new_data);  
                            }
                        }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }
    public function segregated()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('segregation_log');
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();
        

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $common_collection->distinct('batch_id');
        $data['page_name'] = "Segregation Log";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'segregated',$data);
    }

    public function store_segregated(Request $request)
    {
        /*$validator          = Validator::make($request->all(), [
                'batch'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Please select minimum one record.");
            return \Redirect::back();
        }*/

        
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {      
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0],'physical_testing_status'=>'Tested'])->first();
                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                    }
                }
            }    
            if($flag)
            {
                Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
                return \Redirect::back();
            }       
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');   
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        if(isset($details[0]) && !empty($details[0]))
                        {
                            $new_data                            = [];
                            $new_data['current_meter_status']    = 'Pending technical test';
                            $new_data['physical_testing_status'] = 'sagregated';
                            $new_data['whm_system_utility']      = $request->input('utility');
                            $new_data['whm_system_utility_id']   = time();
                           
                            $responce                            = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->where('physical_testing_status','!=','Damaged')->first();
                            if(!empty($responce))
                            {
                                $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]/*,'batch_id'=>$request->input('batch')*/])->where('physical_testing_status','!=','Damaged')->update($new_data);  
                            }
                            
                        }
                }
            }
        }
        else
        {
            $responce  = \DB::table('meter')->where(['batch_id'=>$request->input('batch')])->where('physical_testing_status','!=','sagregated')->where('physical_testing_status','!=','Damaged')->update(['current_meter_status'=>'Pending technical test','physical_testing_status'=>'sagregated','whm_system_utility'=>$request->input('utility'),'whm_system_utility_id'=>time()]);
        }


        $new_data                  = [];
        $new_data['utility']       = $request->input('utility');
        $new_data['utility_time']  = time();
        $new_data['mdm_hes']       = 'no';
        $new_data['mdm_hes_time']  = '-';
        $responce                  = \DB::table('segregation_log')->insert($new_data);
        Session::flash('success', 'Success! Meter sagregated successfully.');
        return \Redirect::back();
  
    }

    public function mdm_hes_update(Request $request)
    {
        $common_collection         = \DB::table('segregation_log')->where(['_id'=>new MongoId($request->input('id'))])->update(['mdm_hes'=>'yes','mdm_hes_time'=>time()]);
        
        Session::flash('success', 'Success! Meter sagregated successfully.');
        echo 'success';
    }

    public function uploaded_meter()
    {
        ini_set('memory_limit','1684M');
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search']]);
            }
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)*//*->orderBy('createdAt','ASC')*/->paginate($limit);
        
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Received Meter";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'uploaded_meter',$data);
    }

    public function phisical_tested()
    {
        //\DB::table('meter')->where(['physical_testing_status'=>'Pending'])->update(["physical_testing_status" => "Tested"]);die;
        //dd(\DB::table('meter')->groupBy('physical_testing_status')->get());
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'physical_testing_status'=>'Tested']);
            }
            else
            {
                $cursor = $cursor->where(['physical_testing_status'=>'Tested']);
            }
        }
        else
        {
            $cursor = $cursor->where(['physical_testing_status'=>'Tested']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = \DB::table('meter')->where(['physical_testing_status'=>'Tested'])->groupBy('batch_id')->get();
        $data['page_name'] = "Physically Tested";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'phisical_tested',$data);
    }

    public function phisical_damage()
    {
        /*$m = \DB::table('meter')->where('swh_inventory_status','like','AssignedToVM')->get();
        dd($m);*/
        
        /*$m = \DB::table('meter')->whereIn('device_id',["GP4448236","GP4448248","GP4448261","GP4448280","GP4448283","GP4448290","GP4448301","GP4448322","GP4448330","GP4448333","GP4448366","GP4448377","GP4448390","GP4448415","GP4448417"])->update(['batch_status'=>'Approved']);
        dd($m);*/
        //$m = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','whm_system_utility_id'=>'','physical_testing_status'=>'Tested'])->update(['whm_system_utility_id'=>time(),'batch_status'=>'Approved']);
        //dd($m);
        /*$m = \DB::table('meter')->where(['physical_testing_status'=>'Tested'])->get();
        
        $t = [];
        foreach ($m as $key => $value) {
            array_push($t,$value['device_id']);
        }
        $m1 = \DB::table('meter')->where('batch_status','!=','Approved')->get();
        $t1 = [];
        foreach ($m1 as $key => $value) {
            if(!in_array($value['device_id'], $t))
            {

                array_push($t1,$value['device_id']);
            }
        }
        dd($t1);*/
        //dd(\DB::table('meter')->groupBy('batch_supplier')->get());
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
         $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'physical_testing_status'=>'Rejected'/*'Damaged'*/,'date_of_dispatch_to_OEM_repair'=>'']);
            }
            else
            {
                $cursor = $cursor->where(['physical_testing_status'=>'Rejected'/*'Damaged'*/,'date_of_dispatch_to_OEM_repair'=>'']);
            }
        }
        else
        {
            $cursor = $cursor->where(['physical_testing_status'=>'Rejected'/*'Damaged'*/,'date_of_dispatch_to_OEM_repair'=>'']);
        }
        /*->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])*/
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Physically Damage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'phisical_damage',$data);
    }

    public function vm_manage_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) || isset($_GET['search_batch']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_id'=>$_GET['search_batch'],'swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],'swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);
            }
            else
            {
                $cursor = $cursor->where(['swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);
            }
        }
        else
        {
            $cursor = $cursor->where(['swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "All";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'vm_manage_meter',$data);
    }

    public function vm_installation_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_id'=>$_GET['search_batch'],'status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))]);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))]);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],'status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))]);
            }
            else
            {
                $cursor = $cursor->where(['status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))]);
            }
        }
        else
        {
            $cursor = $cursor->where(['status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "All";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'vm_installation_meter',$data);
    }

    public function vm_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'vm_damaged_meter',$data);
    }

    public function s2s_vm_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','s2s_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','s2s_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_vm_damaged_meter',$data);
    }

    public function sm_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'sm_damaged_mark_by'=>'sm','is_damage_accepted_swh'=>'Yes','is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')/*'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/]);
        }
        else
        {
            $cursor = $cursor->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_swh'=>'Yes','is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')/*'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'sm_damaged_meter',$data);
    }

    public function s2s_sm_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_swh'=>'Yes','s2s_is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')/*'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/]);
        }
        else
        {
            $cursor = $cursor->where(['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_swh'=>'Yes','s2s_is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')/*'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_sm_damaged_meter',$data);
    }

    public function sm_to_admin_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','Yes');
        }
        else
        {
            $cursor = $cursor->where(['sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','Yes'); 
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Accepted Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'sm_to_admin_damaged_meter',$data);
    }

    public function s2s_sm_to_admin_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','Yes');
        }
        else
        {
            $cursor = $cursor->where(['s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','Yes'); 
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Accepted Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_sm_to_admin_damaged_meter',$data);
    }

    public function sm_to_admin_pending_acceptance_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>'']);
        }
        else
        {
            $cursor = $cursor->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>'']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Pending Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'sm_to_admin_pending_acceptance_damaged_meter',$data);
    }

    public function s2s_sm_to_admin_pending_acceptance_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_admin'=>'']);
        }
        else
        {
            $cursor = $cursor->where(['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_admin'=>'']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Pending Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_sm_to_admin_pending_acceptance_damaged_meter',$data);
    }

    public function vm_to_sm_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/]);
        }
        else
        {
            $cursor = $cursor->where(['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'vm_to_sm_damaged_meter',$data);
    }

    public function s2s_vm_to_sm_damaged_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/]);
        }
        else
        {
            $cursor = $cursor->where(['s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Damaged";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_vm_to_sm_damaged_meter',$data);
    }

    public function repaired_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'damaged_status'=>'Repaired','vmwh_mrn_ref'=>'']);
        }
        else
        {
            $cursor = $cursor->where(['damaged_status'=>'Repaired','vmwh_mrn_ref'=>'']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Repaired";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'repaired_meter',$data);
    }

    public function s2s_repaired_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_damaged_status'=>'Repaired']);
        }
        else
        {
            $cursor = $cursor->where(['s2s_damaged_status'=>'Repaired']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Repaired";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_repaired_meter',$data);
    }

    public function supplier_pending_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        else
        {
            $cursor = $cursor->where(['supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Pending";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'supplier_pending_meter',$data);
    }

    public function s2s_supplier_pending_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        else
        {
            $cursor = $cursor->where(['s2s_supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Pending";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_supplier_pending_meter',$data);
    }

    public function supplier_approved_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'supplier_status'=>'approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        else
        {
            $cursor = $cursor->where(['supplier_status'=>'approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Approved";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'supplier_approved_meter',$data);
    }

    public function s2s_supplier_approved_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_supplier_status'=>'approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        else
        {
            $cursor = $cursor->where(['s2s_supplier_status'=>'approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Approved";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_supplier_approved_meter',$data);
    }

    public function supplier_admin_approved_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');     
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'supplier_status'=>'admin_approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        else
        {
            $cursor = $cursor->where(['supplier_status'=>'admin_approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Admin Approved";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'supplier_admin_approved_meter',$data);
    }

    public function s2s_supplier_admin_approved_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');     
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_supplier_status'=>'admin_approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        else
        {
            $cursor = $cursor->where(['s2s_supplier_status'=>'admin_approved','batch_supplier'=>\Session::get('warehouse_name')]);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Admin Approved";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_supplier_admin_approved_meter',$data);
    }

    public function send_to_supplier()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'supplier_status'=>'pending']);
        }
        else
        {
            $cursor = $cursor->where(['supplier_status'=>'pending']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Send To Supplier";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'send_to_supplier',$data);
    }

    public function s2s_send_to_supplier()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_supplier_status'=>'pending']);
        }
        else
        {
            $cursor = $cursor->where(['s2s_supplier_status'=>'pending']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Meter Send To Supplier";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_send_to_supplier',$data);
    }

    public function return_from_supplier()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'supplier_status'=>'approved']);
        }
        else
        {
            $cursor = $cursor->where(['supplier_status'=>'approved']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Return From Supplier";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'return_from_supplier',$data);
    }

    public function s2s_return_from_supplier()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');        
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search'],'s2s_supplier_status'=>'approved']);
        }
        else
        {
            $cursor = $cursor->where(['s2s_supplier_status'=>'approved']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
       
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Return From Supplier";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'s2s_return_from_supplier',$data);
    }

    public function upload_vm_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0],'swh_inventory_status'=>'Outstock','vmwh'=>new MongoId(\Session::get('_id'))])->first();
     
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0],'s2s_damaged_status'=>'S2SDamaged'])->first();
     
                            if(!empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number is already proceed for S2S Damaged: ".implode($temp, ', '));
            return \Redirect::back();
        }

        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                             = [];
                            $new_data['status']                   = 'Damaged';
                            $new_data['damaged_status']           = 'Damaged';
                            $new_data['damaged_mark_by']          = 'vm';
                            $new_data['damaged_mark_by_id']       = Session::get('_id');
                            $new_data['damaged_mark_by_time']     = date('Y-m-d H:i:s');
                            $new_data['parent_sw_for_damaged']    = $user['parent_sw'];
                            $new_data['is_damage_accepted_swh']   = '';

                            $new_data['faulty_declared_date']           = $row[1];


                            $new_data['sm_damaged_mark_by']              = '';
                            $new_data['sm_damaged_mark_by_id']           = '';
                            $new_data['sm_damaged_mark_by_time']         = '';
                            $new_data['is_damage_accepted_admin']        = '';
                            $new_data['supplier_status']                 = '';
                            $new_data['supplier_send_date']              = '';
                            $new_data['supplier_approve_date']           = '';
                            $new_data['date_of_receipt_of_meter_WH']     = '';
                            $new_data['date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['date_of_receipt_of_refurbished']  = '';
                            $new_data['refurbished_meter_received_date'] = '';




                            //$new_data['date_of_receipt_of_meter_WH']    = $row[2];
                            //$new_data['date_of_dispatch_to_OEM_repair'] = $row[3];
                            //$new_data['date_of_receipt_of_refurbished'] = $row[4];

                            $new_data['last_meter_location']      = \Session::get('warehouse_name');
                            $new_data['current_meter_status']     = 'Damaged Marked by VM';
                            $new_data['last_meter_location_time'] = time();

                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('vm_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_vm_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0],'swh_inventory_status'=>'Outstock'/*,'vmwh'=>new MongoId(\Session::get('_id'))*/])->first();
     
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0],'damaged_status'=>'Damaged'])->first();
                            if(!empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number is already proceed for Damaged: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data           = [];
                            $new_data['status'] = 'Damaged';
                            
                            $new_data['s2s_damaged_status']        = 'S2SDamaged';
                            $new_data['s2s_damaged_mark_by']       = 'vm';
                            $new_data['s2s_damaged_mark_by_id']    = Session::get('_id');
                            $new_data['s2s_damaged_mark_by_time']  = date('Y-m-d H:i:s');
                            $new_data['s2s_parent_sw_for_damaged'] = $user['parent_sw'];
                            $new_data['s2s_is_damage_accepted_swh']       = '';
                            $new_data['s2s_faulty_declared_date']           = $row[1];


                            $new_data['s2s_sm_damaged_mark_by']              = '';
                            $new_data['s2s_sm_damaged_mark_by_id']           = '';
                            $new_data['s2s_sm_damaged_mark_by_time']         = '';
                            $new_data['s2s_is_damage_accepted_admin']        = '';
                            $new_data['s2s_supplier_status']                 = '';
                            $new_data['s2s_supplier_send_date']              = '';
                            $new_data['s2s_supplier_approve_date']           = '';
                            $new_data['s2s_date_of_receipt_of_meter_WH']     = '';
                            $new_data['s2s_date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['s2s_date_of_receipt_of_refurbished']  = '';
                            $new_data['s2s_refurbished_meter_received_date'] = '';


                            //$new_data['s2s_date_of_receipt_of_meter_WH']    = $row[2];
                            //$new_data['s2s_date_of_dispatch_to_OEM_repair'] = $row[3];
                            //$new_data['s2s_date_of_receipt_of_refurbished'] = $row[4];

                            $new_data['last_meter_location']       = \Session::get('warehouse_name');
                            $new_data['current_meter_status']      = 'S2S Damaged Marked by VM';
                            $new_data['last_meter_location_time']  = time();
                            /*--------------------------S2S History ----------------------*/
                            $s2sdata                                         = [];
                            $s2sdata['device_id']                            = $row[0];
                            $s2sdata['s2s_damaged_status']                   = 'Damaged';
                            $s2sdata['s2s_damaged_mark_by']                  = 'vm';
                            $s2sdata['s2s_damaged_mark_by_id']               = Session::get('_id');
                            $s2sdata['s2s_damaged_mark_by_time']             = date('Y-m-d H:i:s');
                            $s2sdata['s2s_parent_sw_for_damaged']            = $user['parent_sw'];
                            $s2sdata['s2s_faulty_declared_date']             = $row[1];
                            //$s2sdata['s2s_date_of_receipt_of_meter_WH']    = $row[2];
                            //$s2sdata['s2s_date_of_dispatch_to_OEM_repair'] = $row[3];
                            //$s2sdata['s2s_date_of_receipt_of_refurbished'] = $row[4];
                            $s2sdata['whm_vendor_manager_name']            = \Session::get('warehouse_name');
                            $s2sdata['s2s_date_of_receipt_of_meter_WH']      = '';
                            $s2sdata['s2s_date_of_dispatch_to_OEM_repair']   = '';
                            $s2sdata['s2s_date_of_receipt_of_refurbished']   = '';
                            $s2sdata['s2s_is_damage_accepted_swh']           = '';
                            $s2sdata['s2s_sm_damaged_mark_by']               = '';
                            $s2sdata['s2s_sm_damaged_mark_by_id']            = '';
                            $s2sdata['s2s_sm_damaged_mark_by_time']          = '';
                            $s2sdata['s2s_is_damage_accepted_admin']         = '';
                            $s2sdata['s2s_supplier_status']                  = '';
                            $s2sdata['s2s_supplier_approve_date']            = '';
                            $s2sdata['s2s_refurbished_meter_received_date']  = '';
                            $s2sdata['repaired_time']                        = '';
                            $s2sdata['edf_status']                           = '';

                            $s2sdata['created_at']                         = date('Y-m-d H:i:s');
                            \DB::table('s2s_meter_history')->insert($s2sdata);
                            /*--------------------------S2S History ----------------------*/

                            //dd($new_data);
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_vm_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_sm_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0],'damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'Yes','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/])->first(); 

                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                            $i++;
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                             = [];
                            $new_data['status']                   = 'Damaged';
                            $new_data['damaged_status']           = 'Damaged';
                            $new_data['sm_damaged_mark_by']       = 'sm';
                            $new_data['date_of_receipt_of_meter_WH']    = $row[1];
                            $new_data['sm_damaged_mark_by_id']    = Session::get('_id');
                            $new_data['sm_damaged_mark_by_time']  = date('Y-m-d H:i:s');
                            $new_data['last_meter_location']      = \Session::get('warehouse_name');
                            $new_data['current_meter_status']     = 'Damaged Marked by SM';
                            $new_data['last_meter_location_time'] = time();

                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('sm_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_sm_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0],'s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'Yes','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/])->first(); 

                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                                = [];
                            $new_data['status']                      = 'Damaged';
                            $new_data['s2s_damaged_status']          = 'S2SDamaged';
                            $new_data['s2s_sm_damaged_mark_by']      = 'sm';
                            $new_data['s2s_is_damage_accepted_admin']= '';

                            $new_data['s2s_sm_damaged_mark_by_id']   = Session::get('_id');
                            $new_data['s2s_sm_damaged_mark_by_time'] = date('Y-m-d H:i:s');
                            $new_data['last_meter_location']         = \Session::get('warehouse_name');
                            $new_data['current_meter_status']        = 'S2S Damaged Marked by SM';
                            $new_data['last_meter_location_time']    = time();
                            $new_data['s2s_date_of_receipt_of_meter_WH']    = $row[1];
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);

                            $s2sdata        = [];
                            $s2sdata['s2s_sm_damaged_mark_by_time']   = date('Y-m-d H:i:s');
                            $s2sdata['s2s_date_of_receipt_of_meter_WH']    = $row[1];
                            \DB::table('s2s_meter_history')->where(['device_id'=>$row[0],'s2s_is_damage_accepted_swh'=>'Yes'])->update($s2sdata);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_sm_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_swh_accept_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0],'damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/])->first();

                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]); 
                        }
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exist in current queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $new_data                             = [];
                        $new_data                             = [];
                        $new_data['is_damage_accepted_swh']   = 'Yes';
                        $new_data['sm_damaged_mark_by']       = 'sm';
                        $new_data['sm_damaged_mark_by_id']    = new MongoId(\Session::get('_id'));
                        $new_data['sm_damaged_mark_by_time']  = date('Y-m-d H:i:s');
                        $new_data['swh_inventory_status']     = 'Instock';
                        $new_data['vmwh']                     = '';


                        $new_data['last_meter_location']      = \Session::get('warehouse_name');
                        $new_data['current_meter_status']     = 'Damaged Meters SM-Accepted';
                        $new_data['last_meter_location_time'] = time();

                        $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('vm_to_sm_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }


    public function s2s_upload_swh_accept_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0],'s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')/*'parent_sw_for_damaged'=>new MongoId(\Session::get('_id'))*/])->first();

                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]); 
                        }
                    }
                }
            }
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exist in current queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $new_data                             = [];
                        $new_data                             = [];
                        $new_data['s2s_is_damage_accepted_swh']   = 'Yes';
                        $new_data['s2s_sm_damaged_mark_by']       = 'sm';
                        $new_data['s2s_sm_damaged_mark_by_id']    = new MongoId(\Session::get('_id'));
                        $new_data['s2s_sm_damaged_mark_by_time']  = date('Y-m-d H:i:s');
                        $new_data['swh_inventory_status']     = 'Instock';
                        $new_data['vmwh']                     = '';


                        $new_data['last_meter_location']      = \Session::get('warehouse_name');
                        $new_data['current_meter_status']     = 'S2S Damaged Meters SM-Accepted';
                        $new_data['last_meter_location_time'] = time();


                        $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);

                        $s2sdata        = [];
                        $s2sdata['s2s_is_damage_accepted_swh']   = 'Yes';
                        $s2sdata['s2s_sm_damaged_mark_by']       = 'sm';
                        $s2sdata['s2s_sm_damaged_mark_by_id']    = new MongoId(\Session::get('_id'));
                        \DB::table('s2s_meter_history')->where(['device_id'=>$row[0],'s2s_is_damage_accepted_swh'=>''])->update($s2sdata);
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_vm_to_sm_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_admin_accept_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','')->where('is_damage_accepted_swh','=','Yes')->first();

                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exist in current queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $new_data                             = [];
                        $new_data['is_damage_accepted_admin'] = 'Yes';
                        $new_data['swh_inventory_status']     = 'NA';
                        
                        $new_data['last_meter_location']      = \Session::get('warehouse_name');
                        $new_data['current_meter_status']     = 'Damaged Meter Admin-Accepted';
                        $new_data['last_meter_location_time'] = time();


                        $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('sm_to_admin_pending_acceptance_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }


    public function s2s_upload_admin_accept_damaged_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','')->where('s2s_is_damage_accepted_swh','=','Yes')->first();

                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exist in current queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $new_data                                 = [];
                        $new_data['s2s_is_damage_accepted_admin'] = 'Yes';
                        $new_data['swh_inventory_status']         = 'NA';
                        
                        $new_data['last_meter_location']      = \Session::get('warehouse_name');
                        $new_data['current_meter_status']     = 'S2S Damaged Meter Admin-Accepted';
                        $new_data['last_meter_location_time'] = time();


                        $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        $s2sdata        = [];
                        $s2sdata['s2s_is_damage_accepted_admin']   = 'Yes';
                        \DB::table('s2s_meter_history')->where(['device_id'=>$row[0],'s2s_is_damage_accepted_admin'=>''])->update($s2sdata);
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_sm_to_admin_pending_acceptance_damaged_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_admin_repaired_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]) && $row[0]!='device_id')
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])/*->where(['supplier_status'=>'approved'])*/->first(); 
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                                = [];
                            $new_data['physical_testing_status']     = 'sagregated';
                            $new_data['status']                      = 'New Meter';
                            $new_data['testing_status']              = 'Approved';
                            $new_data['damaged_status']              = 'Repaired';
                            $new_data['batch_status']                = 'Approved';
                            $new_data['mrn_ref']                     = '';
                            $new_data['dl_ch_ref']                   = '';
                            $new_data['vmwh_mrn_ref']                = '';
                            $new_data['vmwh_dl_ch_ref']              = '';
                            $new_data['supplier_status']             = 'admin_approved';
                            $new_data['refurbished_meter_received_date'] = $row[1];
                            $new_data['supplier_admin_approve_date'] = date('Y-m-d H:i:s');
                            $new_data['repaired_time']               = date('Y-m-d H:i:s');
                            $new_data['last_meter_location']         = \Session::get('warehouse_name');
                            $new_data['current_meter_status']        = \Session::get('warehouse_name');
                            $new_data['last_meter_location_time']    = time();

                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('return_from_supplier');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_admin_repaired_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]) && $row[0]!='device_id')
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['s2s_supplier_status'=>'approved'])->first(); 
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                                = [];
                            $new_data['physical_testing_status']     = 'sagregated';
                            $new_data['status']                      = 'New Meter';
                            $new_data['testing_status']              = 'Approved';
                            $new_data['s2s_damaged_status']              = 'Repaired';
                            $new_data['batch_status']                = 'Approved';
                            $new_data['mrn_ref']                     = '';
                            $new_data['dl_ch_ref']                   = '';
                            $new_data['vmwh_mrn_ref']                = '';
                            $new_data['vmwh_dl_ch_ref']              = '';
                            $new_data['s2s_supplier_status']             = 'admin_approved';
                            $new_data['s2s_refurbished_meter_received_date'] = $row[1];
                            $new_data['s2s_supplier_admin_approve_date'] = date('Y-m-d H:i:s');
                            $new_data['repaired_time']               = date('Y-m-d H:i:s');
                            $new_data['last_meter_location']         = \Session::get('warehouse_name');
                            $new_data['current_meter_status']        = \Session::get('warehouse_name');
                            $new_data['last_meter_location_time']    = time();

                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);

                            $s2sdata                       = [];
                            $s2sdata['s2s_damaged_status'] = 'Repaired';
                            $s2sdata['repaired_time']      = date('Y-m-d h:i:s');
                            $s2sdata['s2s_refurbished_meter_received_date'] = $row[1];
                            \DB::table('s2s_meter_history')->where(['device_id' =>$row[0],'s2s_supplier_status'=>'approved'])->update($s2sdata);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_return_from_supplier');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_send_to_supplier(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {

                            //$responce = \DB::table('meter')->where(['device_id'=>$row[0],'sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>'Yes'])->orwhere(['device_id'=>$row[0],'status'=>'Rejected'])->toSql();
                            $responce = \DB::table('meter')
                                ->where(['device_id'=>$row[0]])
                                ->where(function($query) use ($row){
                                    $query->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>'Yes']);
                                    $query->orwhere(['device_id'=>$row[0],'status'=>'Rejected']);
                                })
                                ->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                             = [];
                            $new_data['supplier_status']          = 'pending';
                            $new_data['supplier_send_date']       = date('Y-m-d h:i:s');
                            $new_data['sm_damaged_mark_by']       = 'pending';
                            //$new_data['is_damage_accepted_admin'] = 'pending';
                            $new_data['date_of_dispatch_to_OEM_repair'] = $row[1];

                            //$new_data['supplier_approve_date']       = '';
                            //$new_data['supplier_admin_approve_date'] = 'Sent To Supplier';
                            $new_data['last_meter_location']         = 'Sent To Supplier';
                            $new_data['current_meter_status']        = 'Sent To Supplier';
                            $new_data['last_meter_location_time']    = time();
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('sm_to_admin_damaged_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_prepare_resend_to_supplier(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['damaged_status'=>'Repaired'])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        
                            $new_data                                    = [];
                            $new_data['is_damage_accepted_admin']        = 'Yes';
                            $new_data['damaged_status']                  = 'Repaired (NeedToResentSupplierForRepair)';
                            $new_data['sm_damaged_mark_by_id']           = Session::get('_id');
                            $new_data['supplier_status']                 = '';
                            $new_data['supplier_send_date']              = '';
                            $new_data['sm_damaged_mark_by']              = 'sm';
                            $new_data['date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['supplier_approve_date']           = '';
                            $new_data['date_of_receipt_of_refurbished']  = '';
                            $new_data['refurbished_meter_received_date'] = '';
                            $new_data['supplier_admin_approve_date']     = '';
                            $responce                                    = \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('repaired_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_prepare_resend_to_supplier_from_pd(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['batch_status'=>'Permanent Damage'])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        
                            $new_data                                    = [];
                            $new_data['batch_status']                    = 'Approved';
                            $new_data['is_damage_accepted_admin']        = 'Yes';
                            $new_data['damaged_status']                  = 'Repaired (NeedToResentSupplierForRepair)';
                            $new_data['sm_damaged_mark_by_id']           = Session::get('_id');
                            $new_data['supplier_status']                 = '';
                            $new_data['supplier_send_date']              = '';
                            $new_data['sm_damaged_mark_by']              = 'sm';
                            $new_data['date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['supplier_approve_date']           = '';
                            $new_data['date_of_receipt_of_refurbished']  = '';
                            $new_data['refurbished_meter_received_date'] = '';
                            $new_data['supplier_admin_approve_date']     = '';
                            $responce                                    = \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('permanent_damage_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    
    public function tagging_refurbish(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp1 = '';
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->first();
                            if(empty($responce)){
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                            else{
                                $temp1 .= $row[0].',';
                            }
                                $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::to('manage_meter');
        }
        if($i>1000)
        {
            Session::flash('error', "Error! Meter count could not be greater than 1000");
            return \Redirect::to('manage_meter');
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $new_data                            = [];
                            $new_data['device_id']               = 'RE_'.str_replace("NR_","",$row[0]);
                            $new_data['special_tag']             = 'RE_';
                            $new_data['special_tag_sync_status'] = 'pending';
                            $responce                            = \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                            
                            $meter = \DB::table('meter')->where(['device_id'=>$row[0]])->first();
                            $history                               = [];
                            $history['meter_id'] = new MongoId($meter['_id']);
                            $history['created_name']               = Session::get('username');
                            $history['activity']                   = 'Meter tagged as Refurbished';
                            $history['description']                = 'Meter device_id tagged as '.'RE_'.str_replace("NR_","",$row[0]).' from '.$row[0];
                            $history['date']                       = date('Y-m-d h:i:s');
                            $history['created_by']                 = Session::get('_id');
                            \DB::table('meter_movement')->insert($history);
                    }
                }
            }

            $payload = [];
            $payload['meterNums'] = rtrim($temp1, ",");
            $payload['remark'] = "RE_";
            if(!empty($temp1)){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://10.9.1.27:3002/api/update_meter_reburish',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,

                CURLOPT_POSTFIELDS =>json_encode($payload),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                ));
        
                
                $result = curl_exec($curl);
                print_r($result);
                if (curl_errno($curl)) {
                echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);
                //die;
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('manage_meter');
        }
        
       

        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function get_single_tagging_meter(Request $request)
    {
        $data = \DB::table('meter')->where(['special_tag_sync_status'=>'pending'])->limit(1)->first();
        if(!empty($data)){
            $response['status']  = true;
            $response['message'] = 'Data Found.';
            $response["data"]    = ['device_id'=>str_replace($data['special_tag'],"",$data['device_id']),'tag'=>$data['special_tag']];
            return response()->json($response);  
        }else{
            $response['status']      = false;
            $response['message']     = 'Data Not Found.';
            $response["data"]        = [];
            return response()->json($response);  
        }
    }

    public function update_single_tagged_meter(Request $request)
    {
        $arr_rules              = [];
        $arr_rules['device_id']   = "required";
        $validator = validator::make($request->all(),$arr_rules);  
        if ($validator->fails()) 
        {
            $response['status']      = false;
            $response['message']     = 'Please enter all details';
            $response["data"]        = [];
            return response()->json($response);  
        }

        $data = \DB::table('meter')->where(['device_id'=>$request->device_id,'special_tag_sync_status'=>'pending'])->limit(1)->first();
        if(!empty($data)){
            \DB::table('meter')->where(['device_id'=>$request->device_id,'special_tag_sync_status'=>'pending'])->update(['special_tag_sync_status'=>'done']);
            $response['status']      = true;
            $response['message']     = 'Tag sync flag updated';
            $response["data"]        = [];
            return response()->json($response);  
        }else{
            $response['status']      = false;
            $response['message']     = 'Error! Tag sync flag not updated';
            $response["data"]        = [];
            return response()->json($response);  
        }
        
    }

    public function tagging_non_refurbish(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $temp1 = '';
            $temp = [];

            $flag = false;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->first();
                        if(empty($responce)){
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                        else{
                            $temp1 .= $row[0].',';
                        }
                            $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::to('manage_meter');
        }
        if($i>1000)
        {
            Session::flash('error', "Error! Meter count could not be greater than 1000");
            return \Redirect::to('manage_meter');
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $new_data                            = [];
                        $new_data['device_id']               = 'NR_'.str_replace("RE_","",$row[0]);
                        $new_data['special_tag']             = 'NR_';
                        $new_data['special_tag_sync_status'] = 'pending';
                        $responce                            = \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        
                        $meter = \DB::table('meter')->where(['device_id'=>$row[0]])->first();
                        $history                               = [];
                        $history['meter_id'] = new MongoId($meter['_id']);
                        $history['created_name']               = Session::get('username');
                        $history['activity']                   = 'Meter tagged as Non-Refurbished';
                        $history['description']                = 'Meter device_id tagged as '.'NR_'.str_replace("RE_","",$row[0]).' from '.$row[0];
                        $history['date']                       = date('Y-m-d h:i:s');
                        $history['created_by']                 = Session::get('_id');
                        \DB::table('meter_movement')->insert($history);
                    }
                }
            }

            $payload = [];
            $payload['meterNums'] = rtrim($temp1, ",");
            $payload['remark'] = "NR_";
            if(!empty($temp1)){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://10.9.1.27:3002/api/update_meter_reburish',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,

                CURLOPT_POSTFIELDS =>json_encode($payload),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                ));
        
                
                $result = curl_exec($curl);
                print_r($result);
                if (curl_errno($curl)) {
                echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);
                // die;
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('manage_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::to('manage_meter');
    }

    public function upload_permanent_damage(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['damaged_status'=>'Repaired'])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $new_data                                    = [];
                            $new_data['batch_status']                    = 'Permanent Damage';
                            $new_data['is_damage_accepted_admin']        = '';
                            $new_data['damaged_status']                  = 'Permanent Damage';
                            $new_data['sm_damaged_mark_by_id']           = '';
                            $new_data['supplier_status']                 = '';
                            $new_data['supplier_send_date']              = '';
                            $new_data['sm_damaged_mark_by']              = '';
                            $new_data['date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['supplier_approve_date']           = '';
                            $new_data['date_of_receipt_of_refurbished']  = '';
                            $new_data['refurbished_meter_received_date'] = '';
                            $new_data['supplier_admin_approve_date']     = '';
                            $responce                                    = \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('repaired_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_prepare_resend_to_supplier(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['s2s_damaged_status'=>'Repaired'])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $new_data                                        = [];
                            $new_data['s2s_is_damage_accepted_admin']        = 'Yes';
                            $new_data['s2s_damaged_status']                  = 'Repaired (NeedToResentSupplierForRepair)';
                            $new_data['s2s_sm_damaged_mark_by_id']           = Session::get('_id');
                            $new_data['s2s_supplier_status']                 = '';
                            $new_data['s2s_supplier_send_date']              = '';
                            $new_data['s2s_sm_damaged_mark_by']              = 'sm';
                            $new_data['s2s_date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['s2s_supplier_approve_date']           = '';
                            $new_data['s2s_date_of_receipt_of_refurbished']  = '';
                            $new_data['s2s_refurbished_meter_received_date'] = '';
                            $new_data['s2s_supplier_admin_approve_date']     = '';
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_repaired_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_prepare_resend_to_supplier_from_pd(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['batch_status'=>'Permanent Damage'])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $new_data                                        = [];
                            $new_data['batch_status']                        = 'Approved';
                            $new_data['s2s_is_damage_accepted_admin']        = 'Yes';
                            $new_data['s2s_damaged_status']                  = 'Repaired (NeedToResentSupplierForRepair)';
                            $new_data['s2s_sm_damaged_mark_by_id']           = Session::get('_id');
                            $new_data['s2s_supplier_status']                 = '';
                            $new_data['s2s_supplier_send_date']              = '';
                            $new_data['s2s_sm_damaged_mark_by']              = 'sm';
                            $new_data['s2s_date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['s2s_supplier_approve_date']           = '';
                            $new_data['s2s_date_of_receipt_of_refurbished']  = '';
                            $new_data['s2s_refurbished_meter_received_date'] = '';
                            $new_data['s2s_supplier_admin_approve_date']     = '';
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_permanent_damage_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_permanent_damage(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['s2s_damaged_status'=>'Repaired'])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists in repaired queue: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        
        
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                            $new_data                                        = [];
                            $new_data['batch_status']                        = 'Permanent Damage';
                            $new_data['s2s_is_damage_accepted_admin']        = '';
                            $new_data['s2s_damaged_status']                  = 'Permanent Damage';
                            $new_data['s2s_sm_damaged_mark_by_id']           = '';
                            $new_data['s2s_supplier_status']                 = '';
                            $new_data['s2s_supplier_send_date']              = '';
                            $new_data['s2s_sm_damaged_mark_by']              = '';
                            $new_data['s2s_date_of_dispatch_to_OEM_repair']  = '';
                            $new_data['s2s_supplier_approve_date']           = '';
                            $new_data['s2s_date_of_receipt_of_refurbished']  = '';
                            $new_data['s2s_refurbished_meter_received_date'] = '';
                            $new_data['s2s_supplier_admin_approve_date']     = '';
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_repaired_meter');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_upload_send_to_supplier(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','Yes')->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                                 = [];
                            $new_data['s2s_supplier_status']          = 'pending';
                            $new_data['s2s_supplier_send_date']       = date('Y-m-d h:i:s');
                            $new_data['s2s_sm_damaged_mark_by']       = 'pending';
                            $new_data['s2s_is_damage_accepted_admin'] = 'pending';
                            $new_data['s2s_date_of_dispatch_to_OEM_repair'] = $row[1];


                            //$new_data['supplier_approve_date']       = '';
                            //$new_data['supplier_admin_approve_date'] = 'Sent To Supplier';
                            $new_data['last_meter_location']         = 'S2S Meter Sent To Supplier';
                            $new_data['current_meter_status']        = 'S2S Meter Sent To Supplier';
                            $new_data['last_meter_location_time']    = time();
                            $temp = \DB::table('meter')->where(['device_id'=>$row[0]])->first();
                            $new_data['whm_vendor_manager_name']    = $temp['batch_supplier'];
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);

                            $s2sdata                            = [];
                            //$s2sdata['whm_vendor_manager_name'] = $temp['batch_supplier'];
                            $s2sdata['s2s_supplier_status']     = 'pending';
                            $s2sdata['s2s_date_of_dispatch_to_OEM_repair'] = $row[1];
                            \DB::table('s2s_meter_history')->where(['device_id'=>$row[0],'s2s_is_damage_accepted_admin'=>'Yes'])->update($s2sdata);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_sm_to_admin_damaged_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function supplier_approve_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
 
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                             = [];
                            $new_data['supplier_status']          = 'approved';
                            $new_data['supplier_approve_date']       = date('Y-m-d h:i:s');
                            //$new_data['supplier_admin_approve_date'] = 'Sent To Supplier';
                            $new_data['last_meter_location']         = 'Main warehouse(Pending Acceptance)';
                            $new_data['current_meter_status']        = 'Main warehouse(Pending Acceptance)';
                            $new_data['last_meter_location_time']    = time();
                            $new_data['date_of_receipt_of_refurbished'] = $row[1];
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('supplier_pending_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function s2s_supplier_approve_meter(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['s2s_supplier_status'=>'pending','batch_supplier'=>\Session::get('warehouse_name')])->first();
                            if(empty($responce))
                            {
                                $flag = true;
                                array_push($temp, $row[0]);
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $user = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {        
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        if($i!=0)
                        {
                            $new_data                                       = [];
                            $new_data['s2s_supplier_status']                = 'approved';
                            $new_data['s2s_supplier_approve_date']          = date('Y-m-d h:i:s');
                            //$new_data['supplier_admin_approve_date']      = 'Sent To Supplier';
                            $new_data['last_meter_location']                = 'Main warehouse(S2S Pending Acceptance)';
                            $new_data['current_meter_status']               = 'Main warehouse(S2S Pending Acceptance)';
                            $new_data['last_meter_location_time']           = time();
                            $new_data['s2s_date_of_receipt_of_refurbished'] = $row[1];
                            
                            $responce =  \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);

                            $s2sdata                                           = [];
                            $s2sdata['s2s_supplier_status']                    = 'approved';
                            $s2sdata['s2s_supplier_approve_date']              = date('Y-m-d h:i:s');
                            $s2sdata['s2s_date_of_receipt_of_refurbished']     = $row[1];
                            \DB::table('s2s_meter_history')->where(['device_id' =>$row[0],'s2s_supplier_status'=>'pending'])->update($s2sdata);
                        }
                        $i++;
                    }
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('s2s_supplier_pending_meter');
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function upload_admin_physical_damage_meter(Request $request)
    {
        dd('Please contact to admin');
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0],'physical_testing_status'=>'Damaged'])->first();
                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        
        $batch_grn_no     = \DB::table('meter')->where('batch_id','!=','')->groupBy('batch_id')->count();
        
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        
                            $new_data                       = [];
                            /*$new_data['batch_invoice_no']   = $details[1];
                            $new_data['batch_invoice_date'] = $details[2];
                            $new_data['batch_waybill_no']   = $details[3];
                            $new_data['batch_waybill_date'] = $details[4];*/

                            /*$new_data['device_id']                  = preg_replace('/[^A-Za-z0-9\-]/', '', $details[5]);
                            $new_data['manufacturer_serial_number'] = $details[5];
                            $new_data['box_no']                     = $details[6];
                            $new_data['reveived_date']              = $details[7];
                            $new_data['phase_type']                 = $details[8];
                            $new_data['sim_no']                     = $details[9];
                            $new_data['imei_no']                    = $details[10];
                            $new_data['sim_no2']                    = $details[11];
                            $new_data['batch_supplier']             = $details[12];*/



                            $new_data['consumer_id']             = '';
                            $new_data['edf_vendor_manager_name'] = '';
                            $new_data['edf_vendor_plan_name']    = '';
                            $new_data['field_worker']            = '';
                            $new_data['whm_vendor_manager_name'] = '';

                            



                            /*
                            $new_data['manufacturer_serial_number']                     = $details[1];
                            $new_data['device_type']                                    = $details[2];
                            $new_data['device_subtype']                                 = $details[3];
                            $new_data['device_model_number']                            = $details[4];
                            $new_data['device_manufacturer_abbreviation']               = $details[5];
                            $new_data['device_manufacturing_year']                      = $details[6];
                            $new_data['device_calibration_year']                        = $details[7];
                            $new_data['device_protocol']                                = $details[8];
                            $new_data['device_protocol_version']                        = $details[9];
                            $new_data['device_mac_address']                             = $details[10];
                            $new_data['device_firmware_version']                        = $details[11];
                            $new_data['device_configuration_version']                   = $details[12];
                            $new_data['device_display_register_digit']                  = $details[13];
                            $new_data['device_communication_technology']                = $details[14];
                            $new_data['device_communication_module_model']              = $details[15];
                            $new_data['device_communication_module_serial_number']      = $details[16];
                            $new_data['device_communication_module_manufacturing_year'] = $details[17];
                            $new_data['device_communication_module_firmware_version']   = $details[18];
                            $new_data['device_communication_module_imei_number']        = $details[19];
                            $new_data['dlms_tcp_port']                                  = $details[20];
                            $new_data['dlms_communication_profile']                     = $details[21];
                            $new_data['dlms_client_id']                                 = $details[22];
                            $new_data['dlms_master_key']                                = $details[23];
                            $new_data['dlms_authentication_key']                        = $details[24];
                            $new_data['dlms_guc']                                       = $details[25];
                            $new_data['dlms_security_secret']                           = $details[26];
                            $new_data['dlms_security_policy']                           = $details[27];
                            $new_data['dlms_authentication_mechanism']                  = $details[28];
                            $new_data['dlms_security_suite']                            = $details[29];
                            $new_data['dlms_companion']                                 = $details[30];
                            $new_data['dlms_companion_version']                         = $details[31];
                            $new_data['device_utilityid']                               = $details[32];
                            $new_data['utility']                                        = $details[33];
                            $new_data['iccid']                                          = $details[34];*/
                            

                           
                            $new_data['batch_grn_no']            = $batch_grn_no+1;
                            $new_data['batch_grn_date']          = date('Y-m-d');//$request->input('batch_grn_date');
                            $new_data['batch_delivery_location'] = $request->input('batch_delivery_location');
                            $new_data['batch_order_no']          = $request->input('batch_order_no');
                            $new_data['batch_transporter']       = $request->input('batch_transporter');
                            $new_data['batch_lr_docket_no']      = $request->input('batch_lr_docket_no');
                            $new_data['batch_vehicle_no']        = $request->input('batch_vehicle_no');
                            
                            
                           

                            $new_data['batch_id']                         = $batch_id;
                            $new_data['meter_upload_time']                = $date_time;
                            $new_data['batch_approve_reject_time']        = '';
                            $new_data['swh_delivery_time']                = '';
                            $new_data['vmwh_delivery_time']               = '';
                            $new_data['swh']                              = '';
                            $new_data['vmwh']                             = '';
                            $new_data['swh_name']                         = '';
                            $new_data['vmwh_name']                        = '';
                            $new_data['mrn_ref']                          = '';
                            $new_data['dl_ch_ref']                        = '';
                            $new_data['vmwh_mrn_ref']                     = '';
                            $new_data['vmwh_dl_ch_ref']                   = '';
                            $new_data['state_warehouse_selfpickup_image'] = '';
                            $new_data['vm_warehouse_selfpickup_image']    = '';
                            $new_data['current_meter_status']             = 'New';
                            $new_data['status']                           = 'Pending';
                            $new_data['testing_status']                   = 'Pending';
                            $new_data['testing_type']                     = '';
                            $new_data['meter_reject_reason']              = '';
                            $new_data['meter_reject_images']              = '';
                            $new_data['testing_time']                     = '';
                            $new_data['batch_status']                     = 'Pending';
                            $new_data['batch_reject_reason']              = '';
                            $new_data['physical_testing_status']          = 'Pending';
                            $new_data['physical_testing_time']            = '';
                            $new_data['physical_meter_reject_images']     = '';
                            $new_data['physical_meter_reject_reason']     = '';
                            $new_data['repaired_time ']                   = '';
                            $new_data['is_damage_accepted_swh']           = '';
                            $new_data['is_damage_accepted_admin']          = '';
                            $new_data['sm_damaged_mark_by_id']            = '';
                            $new_data['sm_damaged_mark_by_time']          = '';

                            $new_data['supplier_status']             = '';
                            $new_data['supplier_send_date']          = '';
                            $new_data['supplier_approve_date']       = '';
                            $new_data['supplier_admin_approve_date'] = '';

                            $new_data['supplier_status']             = '';
                            $new_data['supplier_send_date']          = '';
                            $new_data['supplier_approve_date']       = '';
                            $new_data['supplier_admin_approve_date'] = '';

                            $new_data['whm_system_utility']               = '';
                            $new_data['whm_system_utility_id']            = '';
                             $new_data['sm_damaged_mark_by']               = '';
                            $new_data['damaged_mark_by']                  = '';
                            $new_data['swh_inventory_status']             = 'NA';
                            $new_data['latitude']                         = '';
                            $new_data['longitude']                        = '';
                            $new_data['last_meter_location']              = \Session::get('warehouse_name');
                            $new_data['last_meter_location_time']         = time();
                            $new_data['meter_created_at']                 = date('d/m/Y h:i:s A');



                            /*$responce =  \DB::table('bsnl_sim')->where(['imsi'=>$details[19]])->first();

                            if(!empty($responce))
                            {
                                $condition = ['_id'=>$details[19]];
                                $responce  = \DB::table('bsnl_sim')->where(['imsi'=>$details[19]])->update(["sim_status" => 'UTILIZED']);
                            }*/

                            $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->first();
                            if(!empty($responce))
                            {
                                $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->update($new_data);  
                            }
                    $i++;
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('phisical_damage');
            //return \Redirect::to('manage_'.$this->url_slug);
        }
        
        /*Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();*/
    }

    public function upload_admin_rejected_meter(Request $request)
    {
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0],'testing_status'=>'Rejected'])->orwhere(['device_id'=>$row[0],'status'=>'Rejected'])->first();
                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        $batch_grn_no     = \DB::table('meter')->where('batch_id','!=','')->groupBy('batch_id')->count();
        
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        
                            $new_data                       = [];
                            /*$new_data['batch_invoice_no']   = $details[1];
                            $new_data['batch_invoice_date'] = $details[2];
                            $new_data['batch_waybill_no']   = $details[3];
                            $new_data['batch_waybill_date'] = $details[4];*/

                            /*$new_data['device_id']                  = preg_replace('/[^A-Za-z0-9\-]/', '', $details[5]);
                            $new_data['manufacturer_serial_number'] = $details[5];
                            $new_data['box_no']                     = $details[6];
                            $new_data['reveived_date']              = $details[7];
                            $new_data['phase_type']                 = $details[8];
                            $new_data['sim_no']                     = $details[9];
                            $new_data['imei_no']                    = $details[10];
                            $new_data['sim_no2']                    = $details[11];
                            $new_data['batch_supplier']             = $details[12];*/



                            $new_data['consumer_id']             = '';
                            $new_data['edf_vendor_manager_name'] = '';
                            $new_data['edf_vendor_plan_name']    = '';
                            $new_data['field_worker']            = '';
                            $new_data['whm_vendor_manager_name'] = '';


                            



                            /*
                            $new_data['manufacturer_serial_number']                     = $details[1];
                            $new_data['device_type']                                    = $details[2];
                            $new_data['device_subtype']                                 = $details[3];
                            $new_data['device_model_number']                            = $details[4];
                            $new_data['device_manufacturer_abbreviation']               = $details[5];
                            $new_data['device_manufacturing_year']                      = $details[6];
                            $new_data['device_calibration_year']                        = $details[7];
                            $new_data['device_protocol']                                = $details[8];
                            $new_data['device_protocol_version']                        = $details[9];
                            $new_data['device_mac_address']                             = $details[10];
                            $new_data['device_firmware_version']                        = $details[11];
                            $new_data['device_configuration_version']                   = $details[12];
                            $new_data['device_display_register_digit']                  = $details[13];
                            $new_data['device_communication_technology']                = $details[14];
                            $new_data['device_communication_module_model']              = $details[15];
                            $new_data['device_communication_module_serial_number']      = $details[16];
                            $new_data['device_communication_module_manufacturing_year'] = $details[17];
                            $new_data['device_communication_module_firmware_version']   = $details[18];
                            $new_data['device_communication_module_imei_number']        = $details[19];
                            $new_data['dlms_tcp_port']                                  = $details[20];
                            $new_data['dlms_communication_profile']                     = $details[21];
                            $new_data['dlms_client_id']                                 = $details[22];
                            $new_data['dlms_master_key']                                = $details[23];
                            $new_data['dlms_authentication_key']                        = $details[24];
                            $new_data['dlms_guc']                                       = $details[25];
                            $new_data['dlms_security_secret']                           = $details[26];
                            $new_data['dlms_security_policy']                           = $details[27];
                            $new_data['dlms_authentication_mechanism']                  = $details[28];
                            $new_data['dlms_security_suite']                            = $details[29];
                            $new_data['dlms_companion']                                 = $details[30];
                            $new_data['dlms_companion_version']                         = $details[31];
                            $new_data['device_utilityid']                               = $details[32];
                            $new_data['utility']                                        = $details[33];
                            $new_data['iccid']                                          = $details[34];*/
                            

                           
                            $new_data['batch_grn_no']            = $batch_grn_no+1;
                            $new_data['batch_grn_date']          = date('Y-m-d');//$request->input('batch_grn_date');
                            $new_data['batch_delivery_location'] = $request->input('batch_delivery_location');
                            $new_data['batch_order_no']          = $request->input('batch_order_no');
                            $new_data['batch_transporter']       = $request->input('batch_transporter');
                            $new_data['batch_lr_docket_no']      = $request->input('batch_lr_docket_no');
                            $new_data['batch_vehicle_no']        = $request->input('batch_vehicle_no');
                            
                            
                           

                            $new_data['batch_id']                         = $batch_id;
                            $new_data['meter_upload_time']                = $date_time;
                            $new_data['batch_approve_reject_time']        = '';
                            $new_data['swh_delivery_time']                = '';
                            $new_data['vmwh_delivery_time']               = '';
                            $new_data['swh']                              = '';
                            $new_data['vmwh']                             = '';
                            $new_data['swh_name']                         = '';
                            $new_data['vmwh_name']                        = '';
                            $new_data['mrn_ref']                          = '';
                            $new_data['dl_ch_ref']                        = '';
                            $new_data['vmwh_mrn_ref']                     = '';
                            $new_data['vmwh_dl_ch_ref']                   = '';
                            $new_data['state_warehouse_selfpickup_image'] = '';
                            $new_data['vm_warehouse_selfpickup_image']    = '';
                            $new_data['current_meter_status']             = 'New';
                            $new_data['status']                           = 'Pending';
                            $new_data['testing_status']                   = 'Pending';
                            $new_data['testing_type']                     = '';
                            $new_data['meter_reject_reason']              = '';
                            $new_data['meter_reject_images']              = '';
                            $new_data['testing_time']                     = '';
                            $new_data['batch_status']                     = 'Pending';
                            $new_data['batch_reject_reason']              = '';
                            $new_data['physical_testing_status']          = 'Pending';
                            $new_data['physical_testing_time']            = '';
                            $new_data['physical_meter_reject_images']     = '';
                            $new_data['physical_meter_reject_reason']     = '';
                            $new_data['repaired_time ']                   = '';
                            $new_data['is_damage_accepted_swh']           = '';
                            $new_data['is_damage_accepted_admin']          = '';
                            $new_data['sm_damaged_mark_by_id']            = '';
                            $new_data['sm_damaged_mark_by_time']          = '';

                            $new_data['supplier_status']             = '';
                            $new_data['supplier_send_date']          = '';
                            $new_data['supplier_approve_date']       = '';
                            $new_data['supplier_admin_approve_date'] = '';

                            $new_data['whm_system_utility']               = '';
                            $new_data['whm_system_utility_id']            = '';
                            $new_data['sm_damaged_mark_by']               = '';
                            $new_data['damaged_mark_by']                  = '';
                            $new_data['swh_inventory_status']             = 'NA';
                            $new_data['latitude']                         = '';
                            $new_data['longitude']                        = '';
                            $new_data['last_meter_location']              = \Session::get('warehouse_name');
                            $new_data['last_meter_location_time']         = time();
                            $new_data['meter_created_at']                 = date('d/m/Y h:i:s A');



                            /*$responce =  \DB::table('bsnl_sim')->where(['imsi'=>$details[19]])->first();

                            if(!empty($responce))
                            {
                                $condition = ['_id'=>$details[19]];
                                $responce  = \DB::table('bsnl_sim')->where(['imsi'=>$details[19]])->update(["sim_status" => 'UTILIZED']);
                            }*/

                            $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->first();
                            if(!empty($responce))
                            {
                                $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->update($new_data);  
                            }
                    $i++;
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('reject_meter');
            //return \Redirect::to('manage_'.$this->url_slug);
        }
        
        /*Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();*/
    }

    public function vm_reject_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $regex1     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['device_id'=>$regex,'batch_id'=>$regex1,'status'=>'Rejected','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
            elseif(!empty($_GET['search']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $condition = ['device_id'=>$regex,'status'=>'Rejected','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
            elseif(!empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['batch_id'=>$regex,'status'=>'Rejected','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
            else
            {
                $condition = ['status'=>'Rejected','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
        }
        else
        {
            $condition = ['status'=>'Rejected','vmwh'=>new \MongoId(\Session::get('_id'))];
        }
        
        $cursor     = $this->common_collection->find($condition)->skip($skip)->limit($limit)->sort($sort);
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "All";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'vm_reject_meter',$data);
    }

    public function swh_new_manage_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $regex1     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['device_id'=>$regex,'batch_id'=>$regex1,'status'=>'New Meter','swh'=>new \MongoId(\Session::get('_id'))];
            }
            elseif(!empty($_GET['search']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $condition = ['device_id'=>$regex,'status'=>'New Meter','swh'=>new \MongoId(\Session::get('_id'))];
            }
            elseif(!empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['batch_id'=>$regex,'status'=>'New Meter','swh'=>new \MongoId(\Session::get('_id'))];
            }
            else
            {
                $condition = ['status'=>'New Meter','swh'=>new \MongoId(\Session::get('_id'))];
            }
        }
        else
        {
            $condition = ['status'=>'New Meter','swh'=>new \MongoId(\Session::get('_id'))];
        }
        
        $cursor     = $this->common_collection->find($condition)->skip($skip)->limit($limit)->sort($sort);
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "New";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'swh_new_manage_meter',$data);
    }

    public function vm_new_manage_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $regex1     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['device_id'=>$regex,'batch_id'=>$regex1,'swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
            elseif(!empty($_GET['search']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $condition = ['device_id'=>$regex,'swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
            elseif(!empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['batch_id'=>$regex,'swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
            else
            {
                $condition = ['swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new \MongoId(\Session::get('_id'))];
            }
        }
        else
        {
            $condition = ['swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new \MongoId(\Session::get('_id'))];
        }
        
        $cursor     = $this->common_collection->find($condition)->skip($skip)->limit($limit)->sort($sort);
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "New";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'vm_new_manage_meter',$data);
    }

    public function select_sample()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated','device_id'=>$_GET['search'],'batch_id'=>$_GET['search_batch'],'batch_status'=>'Pending','testing_status'=>'Pending']);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated','device_id'=>$_GET['search'],'batch_status'=>'Pending','testing_status'=>'Pending']);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated','batch_id'=>$_GET['search_batch'],'batch_status'=>'Pending','testing_status'=>'Pending']);
            }
            else
            {
                $cursor = $cursor->where(['physical_testing_status'=>'sagregated','batch_status'=>'Pending','testing_status'=>'Pending']);
            }
        }
        else
        {
            $cursor = $cursor->where(['physical_testing_status'=>'sagregated','batch_status'=>'Pending','testing_status'=>'Pending']);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = \DB::table('meter')->select('batch_id')->groupBy('batch_id')->get();//->distinct('batch_id');
        $data['page_name'] = "Pending Test Bench";
        $data['title']     = "";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'select_sample',$data);
    }

    public function test_report()
    {
         $cursor     = \DB::table('meter')->where(['batch_status'=>'Sample Selected'])->groupBy('batch_id')->get();

        $temp       = [];
        $total      = 0; 
        if(!empty($cursor))
        {
            foreach($cursor as $key =>$value) 
            {
                $Selected_samples       = \DB::table('meter')->where(['physical_testing_status'=>'sagregated','batch_id'=>$value['_id']['batch_id'],'batch_status'=>'Sample Selected'])->get();
                $Selected_samples_count = $Selected_samples->count();
                $condition_tested              = ['batch_status'=>'Sample Selected','batch_id'=>$value['_id']['batch_id'],'testing_status'=>'Approved'];
                $Selected_samples_tested       = \DB::table('meter')->where(['batch_status'=>'Sample Selected','batch_id'=>$value['_id']['batch_id'],'testing_status'=>'Approved'])->get();
                $Selected_samples_tested_count = $Selected_samples_tested->count();

                //Reject meters
                $condition_rejected              = ['batch_status'=>'Sample Selected','batch_id'=>$value['_id']['batch_id'],'testing_status'=>'Rejected'];
                $Selected_samples_rejected       = \DB::table('meter')->where(['batch_status'=>'Sample Selected','batch_id'=>$value['_id']['batch_id'],'testing_status'=>'Rejected'])->get();
                $Selected_samples_rejected_count = $Selected_samples_rejected->count();
                
                if($Selected_samples_count!=0)
                {
                    $percentage = (($Selected_samples_tested_count/*+$Selected_samples_rejected_count*/)/$Selected_samples_count)*100;
                }
                else
                {
                    $percentage = 0;
                }

                $temp1 = [];
                $temp1['batch_id'] = $value['_id']['batch_id'];
                $temp1['percentage'] = $percentage;
                array_push($temp, $temp1);
                $total++;
            }
        }
        //$this->common_connection->close();

        /*$data['page']      = $page;
        $data['limit']     = $limit;
        $data['prev']      = $prev;
        $data['next']      = $next;*/
        $data['reason']    = \DB::table('reason')->get();
        $data['total']     = $total;
        $data['data']      = $temp;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Sample Selected']);
        $data['page_name'] = "Testing";
        $data['title']     = "Report";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'test_report',$data);
    }

    public function physical_test_report()
    {
        $cursor     = \DB::table('meter')->where(['physical_testing_status'=>'Pending'])->groupBy('batch_id')->get();//
        $temp       = [];
        $total      = 0; 
        if(isset($cursor))
        {
            foreach($cursor as $key =>$value) 
            {
                $condition              = ['batch_id'=>$value['_id']];
                $Selected_samples       = \DB::table('meter')->where(['batch_id'=>$value['batch_id']]);
                $Selected_samples_count = $Selected_samples->count();
                $condition_tested              = array('$or'=> [
                          ['batch_id'=>$value['_id'],"physical_testing_status" => "Tested"]/*,
                          ['batch_id'=>$value['_id'],"physical_testing_status" => "Damaged"]*/
                        ]);
                        // [,'$or'=>[['physical_testing_status'=>'Tested'],['physical_testing_status'=>'Damaged']];
                $Selected_samples_tested       = \DB::table('meter')->where(['batch_id'=>$value['batch_id'],"physical_testing_status" => "Tested"]);
                $Selected_samples_tested_count = $Selected_samples_tested->count();
                if($Selected_samples_count!=0)
                {
                    $percentage = ($Selected_samples_tested_count/$Selected_samples_count)*100;
                }
                else
                {
                    $percentage = 0;
                }

                $temp1 = [];
                $temp1['batch_id'] = $value['batch_id'];
                $temp1['percentage'] = number_format($percentage,0);
                array_push($temp, $temp1);
                $total++;
            }
        }
        //$this->common_connection->close();

        
        $data['reason']    = \DB::table('reason')->get();
        $data['total']     = $total;
        $data['data']      = $temp;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Sample Selected']);
        $data['page_name'] = "Testing";
        $data['title']     = "Report";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'physical_test_report',$data);
    }

    public function manage_seleted_meter($id)
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_id'=>$id,'batch_status'=>'Sample Selected']);
            }
            else
            {
                $cursor = $cursor->where(['batch_id'=>$id,'batch_status'=>'Sample Selected']);
            }
        }
        else
        {
            $cursor = $cursor->where(['batch_id'=>$id,'batch_status'=>'Sample Selected']);
        }

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
      
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['testing_status'=>'Sample Selected']);
        $data['page_name'] = "Manage Selected";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'manage_seleted_meter',$data);
    }

    public function manage_physical_testing_meter($id)
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
         $cursor     = \DB::table('meter');
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_id'=>$id,'physical_testing_status'=>'Pending']);
            }
            else
            {
                $cursor = $cursor->where(['batch_id'=>$id,'physical_testing_status'=>'Pending']);
            }
        }
        else
        {
            $cursor = $cursor->where(['batch_id'=>$id,'physical_testing_status'=>'Pending']);

        }

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();
       

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['testing_status'=>'Sample Selected']);
        $data['page_name'] = "Manage Testing";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'manage_physical_testing_meter',$data);
    }

    public function edf_meter_pool()
    {
        //\DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>'','swh_inventory_status'=>'NA'])->update(['swh_inventory_status'=>'Instock','dl_ch_ref'=>'AdminActivityPerformedForMeterMovment']);die;
        /*$meter =  \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->update(['dl_ch_ref'=>'AdminActivityPerformedForMeterMovment']);
        dd($meter);
        die;*/
        /*$meter = \DB::table('meter')->where('whm_system_utility','=','')
        ->update(['physical_testing_time'=>'','whm_system_utility_id'=>'','batch_approve_reject_time'=>'','status'=>'Pending','testing_status'=>'Pending','testing_type'=>'','batch_status'=>'Pending','physical_testing_status'=>'Pending']);*/
        //->count();
        //->update(['physical_testing_time'=>'1667970781','whm_system_utility_id'=>'1667970781','batch_approve_reject_time'=>'1667970781','status'=>'New Meter','testing_status'=>'Approved','testing_type'=>'manual','batch_status'=>'Approved','physical_testing_status'=>'sagregated']);
        //dd($meter);
        //->update(['dl_ch_ref'=>'AdminActivityPerformedForMeterMovment']);
        
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
             if(!empty($_GET['search_device_phase']) && !empty($_GET['search_utility']) && !empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'phase_type'=>$_GET['search_device_phase'],'whm_system_utility'=>$_GET['search_utility'],'batch_status'=>'Approved','dl_ch_ref'=>'']);
            }
            elseif(!empty($_GET['search_device_phase']) && !empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'phase_type'=>$_GET['search_device_phase'],'batch_status'=>'Approved','dl_ch_ref'=>'']);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_status'=>'Approved','dl_ch_ref'=>'']);
            }
            elseif(!empty($_GET['search_device_phase']))
            {
                $cursor = $cursor->where(['phase_type'=>$_GET['search_device_phase'],'batch_status'=>'Approved','dl_ch_ref'=>'']);
            }
            elseif(!empty($_GET['search_utility']))
            {
                $cursor = $cursor->where(['whm_system_utility'=>$_GET['search_utility'],'batch_status'=>'Approved','dl_ch_ref'=>'']);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],'batch_status'=>'Approved','dl_ch_ref'=>'']);
            }
            else
            {
                $cursor = $cursor->where(['batch_status'=>'Approved','dl_ch_ref'=>'']);
            }

            if($_GET['filter']=='S2S Repaired')
            {
                $cursor = $cursor->where(['batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            elseif($_GET['filter']=='Non-S2S Repaired')
            {
                $cursor = $cursor->where(['batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'']);
            }
            else
            {
                //No need to do anything
            }
        }
        else
        {
            $cursor = $cursor->where(['batch_status'=>'Approved','dl_ch_ref'=>'']);

        }
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where(['status'=>'Pending','vmwh'=>''])->get();      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = \DB::table('meter')->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "All EDF Meter";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'edf_meter_pool',$data);
    }

    public function s2s_edf_meter_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
             if(!empty($_GET['search_device_phase']) && !empty($_GET['search_utility']) && !empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'phase_type'=>$_GET['search_device_phase'],'whm_system_utility'=>$_GET['search_utility'],'batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            elseif(!empty($_GET['search_device_phase']) && !empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'phase_type'=>$_GET['search_device_phase'],'batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            elseif(!empty($_GET['search_device_phase']))
            {
                $cursor = $cursor->where(['phase_type'=>$_GET['search_device_phase'],'batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            elseif(!empty($_GET['search_utility']))
            {
                $cursor = $cursor->where(['whm_system_utility'=>$_GET['search_utility'],'batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],'batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
            else
            {
                $cursor = $cursor->where(['batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);
            }
        }
        else
        {
            $cursor = $cursor->where(['batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired']);

        }
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where(['status'=>'Pending','vmwh'=>''])->get();      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = [];
        $data['page_name'] = "S2S EDF Meter";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'s2s_edf_meter_pool',$data);
    }

    public function edf_sim_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('bsnl_sim');
        if(isset($_GET['sim_no_search']) || isset($_GET['mobile_no_search']))
        {
            if(!empty($_GET['sim_no_search']) && !empty($_GET['mobile_no_search']))
            {
                $cursor = $cursor->where(['sim_no'=>$_GET['sim_no_search'],'mobile_no'=>$_GET['mobile_no_search'],'swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED']);
            }
            elseif(!empty($_GET['sim_no_search']))
            {
                $cursor = $cursor->where(['sim_no'=>$_GET['sim_no_search'],'swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED']);
            }
            elseif(!empty($_GET['mobile_no_search']))
            {
                $cursor = $cursor->where(['mobile_no'=>$_GET['mobile_no_search'],'swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED']);
            }
            else
            {
                $cursor = $cursor->where(['swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED']);
            }
        }
        else
        {
            $cursor = $cursor->where(['swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED']);
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where(['status'=>'Pending'])->where('swh','!=','')->get();      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Sim";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'edf_sim_pool',$data);
    }

    public function edf_modem_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('modem');
        if(isset($_GET['modem_number_search']) && isset($_GET['modem_number_search']))
        {
            $cursor = $cursor->where(['modem_number'=>$_GET['modem_number_search'],'swh'=>'','vmwh'=>'','mrn_ref'=>'','status'=>'UNUTILISED']);
        }
        else
        {
            $cursor = $cursor->where(['swh'=>'','vmwh'=>'','mrn_ref'=>'','status'=>'UNUTILISED']);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where(['status'=>'Pending'])->where('swh','!=','')->get();      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Modem";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'edf_modem_pool',$data);
    }

    public function swh_edf_modem_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('modem');
        if(isset($_GET['modem_number_search']) && isset($_GET['modem_number_search']))
        {
            $cursor = $cursor->where(['modem_number'=>$_GET['modem_number_search'],'vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED']);
        }
        else
        {
            $cursor = $cursor->where(['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED']);
        }
        

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where('swh','!=','')->where(['status'=>'Pending'])->get();                            
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Modem";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'swh_edf_modem_pool',$data);
    }

    public function vmwh_edf_modem_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
         $cursor     = \DB::table('modem');
        if(isset($_GET['modem_number_search']))
        {
            $cursor = $cursor->where(['modem_number'=>$_GET['modem_number_search'],'vmwh'=>new \MongoId(\Session::get('_id')),'status'=>'UNUTILISED']);
        }
        else
        {
            $cursor = $cursor->where(['vmwh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED']);
        }
        

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where('swh','!=','')->where(['status'=>'Pending'])->get();;      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Modem";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'vmwh_edf_modem_pool',$data);
    }

    public function swh_edf_meter_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search_device_phase']) && !empty($_GET['search_utility']) && !empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'phase_type'=>$_GET['search_device_phase'],'whm_system_utility'=>$_GET['search_utility'],'batch_status'=>'Approved','swh_inventory_status'=>'Instock',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search_device_phase']) && !empty($_GET['search_utility']))
            {
                $cursor = $cursor->where(['phase_type'=>$_GET['search_device_phase'],'whm_system_utility'=>$_GET['search_utility'],'batch_status'=>'Approved','swh_inventory_status'=>'Instock',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search_device_phase']) && !empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'phase_type'=>$_GET['search_device_phase'],'batch_status'=>'Approved','swh_inventory_status'=>'Instock',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_status'=>'Approved','swh_inventory_status'=>'Instock',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search_device_phase']))
            {
                $cursor = $cursor->where(['phase_type'=>$_GET['search_device_phase'],'swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search_utility']))
            {
                $cursor = $cursor->where(['whm_system_utility'=>$_GET['search_utility'],'swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],'swh_inventory_status'=>'Instock','batch_status'=>'Approved','swh'=>new \MongoId(\Session::get('_id'))]);
            }
            else
            {
                $cursor = $cursor->where(['swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
            }
        }
        else
        {
            $cursor = $cursor->where(['swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();
        $data['mrn']       = \DB::table('mrn')->where('vmwh','!=','')->where(['mrn_authorized_2_status'=>'Approve','status'=>'Pending','utility'=>\Session::get('utility')])->get();     
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Meter";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'swh_edf_meter_pool',$data);
    }

    public function swh_edf_sim_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('bsnl_sim');
        if(isset($_GET['sim_no_search']) || isset($_GET['mobile_no_search']))
        {
            if(!empty($_GET['sim_no_search']))
            {
                //dd(new MongoId(\Session::get('_id')));
                $cursor = $cursor->where(['sim_no'=>$_GET['sim_no_search'],'swh'=>new MongoId(\Session::get('_id')),'vmwh'=>'',/*'mrn_ref'=>'',*/'sim_status'=>'UNUTILISED']);
            }
            elseif(!empty($_GET['mobile_no_search']))
            {
                $cursor = $cursor->where(['mobile_no'=>$_GET['mobile_no_search'],'swh'=>new MongoId(\Session::get('_id')),'vmwh'=>'',/*'mrn_ref'=>'',*/'sim_status'=>'UNUTILISED']);
            }
            elseif(!empty($_GET['mobile_no_search']) && !empty($_GET['sim_no_search']))
            {
                $cursor = $cursor->where(['sim_no'=>$_GET['sim_no_search'],'mobile_no'=>$_GET['mobile_no_search'],'swh'=>new MongoId(\Session::get('_id')),'vmwh'=>'',/*'mrn_ref'=>'',*/'sim_status'=>'UNUTILISED']);

            }
            else
            {
                $cursor = $cursor->where(['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED']);
            }
        }
        else
        {
            $cursor = $cursor->where(['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED']);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('mrn')->where('vmwh','!=','')->where(['status'=>'Pending'])->get();;    ;      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Meter";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'swh_edf_sim_pool',$data);
    }

    public function vmwh_edf_sim_pool()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('bsnl_sim');
        if(isset($_GET['sim_no_search']) || isset($_GET['mobile_no_search']))
        {
            if(!empty($_GET['sim_no_search']))
            {
                $cursor = $cursor->where(['sim_no'=>$_GET['sim_no_search'],'swh'=>'','vmwh'=>new MongoId(\Session::get('_id')),'mrn_ref'=>'','sim_status'=>'UNUTILISED']);
                
            }
            elseif(!empty($_GET['mobile_no_search']))
            {
                $cursor = $cursor->where(['mobile_no'=>$_GET['mobile_no_search'],'swh'=>'','vmwh'=>new MongoId(\Session::get('_id')),'mrn_ref'=>'','sim_status'=>'UNUTILISED']);
            }
            elseif(!empty($_GET['sim_no_search']) && !empty($_GET['mobile_no_search']))
            {
                $cursor = $cursor->where(['sim_no'=>$_GET['sim_no_search'],'mobile_no'=>$_GET['mobile_no_search'],'swh'=>'','vmwh'=>new MongoId(\Session::get('_id')),'mrn_ref'=>'','sim_status'=>'UNUTILISED']);
            }
            else
            {
                $cursor = $cursor->where(['swh'=>'','vmwh'=>new MongoId(\Session::get('_id')),'mrn_ref'=>'','sim_status'=>'UNUTILISED']);

            }
        }
        else
        {
            $cursor = $cursor->where(['vmwh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED']);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $total      = 0;//$cursor->count();

        $data['mrn']       = \DB::table('meter')->where('vmwh','!=','')->where(['status'=>'Pending'])->get();      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['batch_status'=>'Tested']);
        $data['page_name'] = "EDF Meter";
        $data['title']     = "Pool";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'vmwh_edf_sim_pool',$data);
    }

    public function assigned_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');

        if(isset($_GET['search']) || isset($_GET['search_batch']))
        {
            /*if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $regex1    = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['device_id'=>$regex,'batch_id'=>$regex1,'dl_ch_ref'=>['$ne'=>'']];
            }*/
            if(!empty($_GET['search']) && !empty($_GET['swh_search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'dl_ch_ref'=>$_GET['swh_search']])->where('dl_ch_ref','!=','');
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search']])->where('dl_ch_ref','!=','');
            }
            elseif(!empty($_GET['swh_search']))
            {
                $cursor = $cursor->where(['swh_name'=>$_GET['swh_search']])->where('dl_ch_ref','!=','');
            }
            else
            {
                $cursor = $cursor->where('dl_ch_ref','!=','');
            }
        }
        else
        {
            $cursor = $cursor->where('dl_ch_ref','!=','');
        }


        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Assigned";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'assigned_meter',$data);
    }

    public function permanent_damage_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');

        if(!empty($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search']])->where('damaged_status','=','Permanent Damage');
        }
        else
        {
            $cursor = $cursor->where('damaged_status','=','Permanent Damage');
        }

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Permanent Damage";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'permanent_damage_meter',$data);
    }

    public function s2s_permanent_damage_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');

        if(!empty($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search']])->where('s2s_damaged_status','=','Permanent Damage');
        }
        else
        {
            $cursor = $cursor->where('s2s_damaged_status','=','Permanent Damage');
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "S2S Permanent Damage ";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'s2s_permanent_damage_meter',$data);
    }
    public function edf_meter_pool_all_permanent_damage()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');

        if(!empty($_GET['search']))
        {
            $cursor = $cursor->where(['device_id'=>$_GET['search']])->where('batch_status','=','Permanent Damage');
        }
        else
        {
            $cursor = $cursor->where('batch_status','=','Permanent Damage');
        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "All Permanent Damage";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'edf_meter_pool_all_permanent_damage',$data);
    }

    public function swh_assigned_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'batch_id'=>$_GET['search_batch'],'swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*,'swh'=>new MongoId(\Session::get('_id'))*/]);
            }
            elseif(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search'],'swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*,'swh'=>new MongoId(\Session::get('_id'))*/]);
            }
            elseif(!empty($_GET['search_batch']))
            {
                $cursor = $cursor->where(['batch_id'=>$_GET['search_batch'],'swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*,'swh'=>new MongoId(\Session::get('_id'))*/]);
            }
            else
            {
                $cursor = $cursor->where(['swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*,'swh'=>new MongoId(\Session::get('_id'))*/]);
            }
        }
        else
        {
            $cursor = $cursor->where(['swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*,'swh'=>new MongoId(\Session::get('_id'))*/]);

        }

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Assigned";
        $data['title']     = "Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'swh_assigned_meter',$data);
    }

    public function swh_reject_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']) && !empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $regex1    = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['swh'=>new \MongoId(\Session::get('_id')),'device_id'=>$regex,'batch_id'=>$regex1,'$or'=> [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
            }
            elseif(!empty($_GET['search']))
            {
                $regex     = new \MongoRegex("^".$_GET['search']."/i");
                $condition = ['swh'=>new \MongoId(\Session::get('_id')),'device_id'=>$regex,'$or'=> [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
            }
            elseif(!empty($_GET['search_batch']))
            {
                $regex     = new \MongoRegex("^".$_GET['search_batch']."/i");
                $condition = ['swh'=>new \MongoId(\Session::get('_id')),'batch_id'=>$regex,'$or'=> [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
            }
            else
            {
                $condition = ['swh'=>new \MongoId(\Session::get('_id')),'$or'=> [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
            }
        }
        else
        {
            $condition = ['swh'=>new \MongoId(\Session::get('_id')),'$or'=> [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
        }
        //dd($condition);
        $cursor     = $this->common_collection->find($condition)->skip($skip)->limit($limit)->sort($sort);
        //$this->common_connection->close();
        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['batch']     = $this->common_collection->distinct('batch_id',['status'=>'Rejeted']);
        $data['page_name'] = "Reject";
        $data['title']     = " Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'reject_meter',$data);
    }

    public function reject_meter()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];
        $cursor     = \DB::table('meter');

        if(isset($_GET['search']) && isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where('supplier_status','=','admin_approved')->where(['device_id'=>$_GET['search'],'testing_status'=>'Rejected'])->orwhere(['device_id'=>$_GET['search']])->where(['status'=>'Rejected'])->where('supplier_status','=','admin_approved');
            }
            else
            {
                $cursor = $cursor->where('supplier_status','=','admin_approved')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->where('supplier_status','=','admin_approved');
            }
        }
        else
        {
            $cursor = $cursor->where('supplier_status','=','admin_approved')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->where('supplier_status','=','admin_approved');
        }


        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $total      = 0;//$cursor->count();

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id',['status'=>'Rejeted']);
        $data['page_name'] = "Rejected";
        $data['title']     = " Meter";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'reject_meter',$data);
    }
 
    public function add()
    {
        //ini_set('memory_limit','1684M');
        /*ini_set('max_execution_time', '0');
        for ($i=0; $i < 1000000; $i++) { 
            $new_data                       = [];
                        $new_data['batch_invoice_no']   = 'batch_invoice_no'.rand(10,1000000);
                        $new_data['batch_invoice_date'] = 'batch_invoice_date'.rand(10,1000000);
                        $new_data['batch_waybill_no']   = 'batch_waybill_no'.rand(10,1000000);
                        $new_data['batch_waybill_date'] = 'batch_waybill_date'.rand(10,1000000);

                        $new_data['device_id']                  = 'device_id'.rand(10,1000000);
                        $new_data['manufacturer_serial_number'] = 'manufacturer_serial_number'.rand(10,1000000);
                        $new_data['box_no']                     = 'box_no'.rand(10,1000000);
                        $new_data['reveived_date']              = 'reveived_date'.rand(10,1000000);
                        $new_data['phase_type']                 = 'phase_type'.rand(10,1000000);
                        $new_data['sim_no']                     = 'sim_no'.rand(10,1000000);
                        $new_data['imei_no']                    = 'imei_no'.rand(10,1000000);
                        $new_data['sim_no2']                    = 'sim_no2'.rand(10,1000000);
                        $new_data['batch_supplier']             = 'batch_supplier'.rand(10,1000000);



                        $new_data['consumer_id']             = '';
                        $new_data['edf_vendor_manager_name'] = '';
                        $new_data['edf_vendor_plan_name']    = '';
                        $new_data['field_worker']            = '';
                        $new_data['whm_vendor_manager_name']            = '';

                        

                       
                        $new_data['batch_grn_no']            = uniqid();
                        $new_data['batch_grn_date']          = date('Y-m-d');//$request->input('batch_grn_date');
                        $new_data['batch_delivery_location'] = 'batch_delivery_location'.rand(10,1000000);
                        $new_data['batch_order_no']          = 'batch_order_no'.rand(10,1000000);
                        $new_data['batch_transporter']       = 'batch_transporter'.rand(10,1000000);
                        $new_data['batch_lr_docket_no']      = 'batch_lr_docket_no'.rand(10,1000000);
                        $new_data['batch_vehicle_no']        = 'batch_vehicle_no'.rand(10,1000000);
                        
                        
                       

                        $new_data['batch_id']                         = $batch_id = "Batch-".date('d_m_Y_h:i:s').rand(10,1000000);
                        $new_data['meter_upload_time']                = time();
                        $new_data['batch_approve_reject_time']        = '';
                        $new_data['swh_delivery_time']                = '';
                        $new_data['vmwh_delivery_time']               = '';
                        $new_data['swh']                              = '';
                        $new_data['vmwh']                             = '';
                        $new_data['swh_name']                         = '';
                        $new_data['vmwh_name']                        = '';
                        $new_data['mrn_ref']                          = '';
                        $new_data['dl_ch_ref']                        = '';
                        $new_data['vmwh_mrn_ref']                     = '';
                        $new_data['vmwh_dl_ch_ref']                   = '';
                        $new_data['state_warehouse_selfpickup_image'] = '';
                        $new_data['vm_warehouse_selfpickup_image']    = '';
                        $new_data['current_meter_status']             = 'New';
                        $new_data['status']                           = 'Pending';
                        $new_data['testing_status']                   = 'Pending';
                        $new_data['testing_type']                     = '';
                        $new_data['meter_reject_reason']              = '';
                        $new_data['meter_reject_images']              = '';
                        $new_data['testing_time']                     = '';
                        $new_data['batch_status']                     = 'Pending';
                        $new_data['batch_reject_reason']              = '';
                        $new_data['physical_testing_status']          = 'Pending';
                        $new_data['physical_testing_time']            = '';
                        $new_data['physical_meter_reject_images']     = '';
                        $new_data['physical_meter_reject_reason']     = '';
                        $new_data['whm_system_utility']               = '';
                        $new_data['whm_system_utility_id']            = '';
                        $new_data['swh_inventory_status']             = 'NA';
                        $new_data['latitude']                         = '';
                        $new_data['longitude']                        = '';
                        $new_data['last_meter_location']              = \Session::get('warehouse_name');
                        $new_data['last_meter_location_time']         = time();
                        $new_data['meter_created_at']                 = date('d/m/Y h:i:s A');
                        \DB::table('meter')->insert($new_data);
        }
        echo $i;die;*/

        /*header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Meter mismatched_utility.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $count = \DB::table('meter')->select(['device_id','phase_type'])->where('whm_system_utility','!=','NBPD')->where('whm_system_utility','!=','SBPD')->get(); 

         echo "Sr. No.";
          echo ',';
          echo "Meter No.";
          echo ',';
          echo "Phase Type";
          echo ',';echo "\n"; 
          foreach ($count as $key => $value) {

              echo ($key+1);
              echo ',';
              echo  $value['device_id'];
              echo ',';
              echo  $value['phase_type'];
              echo ',';echo "\n";
          }
          die;*/

        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt'=> -1);
        $condition  = [];

        $cursor     = \DB::table('meter')->select(['batch_grn_no','batch_invoice_no','batch_grn_date','batch_supplier','batch_delivery_location','batch_invoice_date','batch_order_no','batch_transporter','batch_lr_docket_no','batch_waybill_no','batch_waybill_date','batch_vehicle_no','batch_id'])->where('batch_id','!=','');
        if(isset($_GET['search']))
        {
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->where(['device_id'=>$_GET['search']]);
            }
        }
        
        
        $total      = 0;//$cursor->count();
        // $cursor     = $cursor->groupBy('batch_id')->options(['allowDiskUse' => true])->simplePaginate(10);
        $cursor     = $cursor->skip($skip)->limit($limit)->groupBy('batch_id')->orderBy('createdAt','ASC')->get();
        //dd($cursor);

        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data1']      = $cursor;
        //$data['batch']     = $this->common_collection->distinct('batch_id');
        $data['page_name'] = "Upload";
        $data['title']     = '.CSV';
        /*$db  = \DB::table('meter')->select(['batch_grn_no','batch_invoice_no','batch_grn_date','batch_supplier','batch_delivery_location','batch_invoice_date','batch_order_no','batch_transporter','batch_lr_docket_no','batch_waybill_no','batch_waybill_date','batch_vehicle_no','batch_id'])->where('batch_id','!=','')->limit(10)->groupBy('batch_id')->options(['allowDiskUse' => true])->get();

        $data['data1']    = $db;*/
        $data['url_slug']  = $this->url_slug;

        return view($this->folder_path.'add',$data);
    }

    public function bulk_activity()
    {
        
        
        
        $data = [];
        $data['page_name'] = "Upload";
        $data['title']     = '.CSV';
        $data['url_slug']  = $this->url_slug;

        return view($this->folder_path.'bulk_activity',$data);
    }

    public function update_bulk_activity(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

       
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        if($i!=0)
                        {
                            $condition = ['warehouse_name'=>$row[72]];
                            $responce = $this->common_db->login_users->find($condition);
                            if(!empty(iterator_to_array($responce)))
                            {
                                foreach (iterator_to_array($responce) as $key =>$value) 
                                {
                                    $condition = ['device_id'=>preg_replace('/[^A-Za-z0-9\-]/', '', $row[1])];
                                    //$condition = ['device_id'=>'GOEGP5861666'];
                                    $new_data  = [
                                                    '$set'=> ["vmwh" =>$value['_id'],"vmwh_name" =>$value['warehouse_name']]
                                                 ];
                                                 
                                    $responce  = $this->common_collection->update($condition,$new_data);
                                }
                            }
                        }

                    $i++;
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.'.$i);
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function store_selected_meters(Request $request)
    {
       /* $validator          = Validator::make($request->all(), [
                'obi_id'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Please select minimum one record.");
            return \Redirect::back();
        }*/

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(isset($row[0]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[0]])->where(['physical_testing_status'=>'sagregated','batch_status'=>'Pending','testing_status'=>'Pending'])->first();
                        $i++;
                        if(empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[0]);
                        }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter device number not exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');   
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        if(isset($details[0]) && !empty($details[0]))
                        {
                            $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->update(['testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected']);  
                            //$responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[0]])->get();
                        
                        }
                }
            }
        }

        /*$obi_id = $request->input('obi_id');
        foreach ($obi_id as $key =>$value) 
        {
            $responce  = \DB::table('meter')->where(['_id'=>new MongoId($value)])->update(['testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected']);
        }*/
        Session::flash('success', 'Success! Meter has been selected successfully.');
        return \Redirect::back();
  
    }

    public function store_testing_meters_status(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'id'          => 'required',
                'status'      => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Please select minimum one record.");
            return \Redirect::back();
        }

       if($request->input('status')=='Approved')
        {
            $new_data  = ['testing_status'=>$request->input('status')];
        }
        else
        {
            $new_data  = ['testing_status'=>$request->input('status'),'meter_reject_reason'=>$request->input('reason')];
        }
       
        $responce  = \DB::table('meter')->where(['_id'=>new MongoId($request->input('id'))])->update($new_data);
        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::back();
  
    }

    public function store_physical_testing_meters_status(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'id'          => 'required',
                'status'      => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Please select minimum one record.");
            return \Redirect::back();
        }

        $responce  = \DB::table('meter')->where(['_id'=>new MongoId($request->input('id'))])->update( ['physical_testing_status'=>$request->input('status'),'physical_testing_time'=>time()]);
        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('physical_test_report');
    }

    public function store_physical_testing_batch_status(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'hidden_id'          => 'required',
                'status'      => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Please select minimum one record.");
            return \Redirect::back();
        }

        $responce  = \DB::table('meter')->where(['physical_testing_status'=>'Pending','batch_id'=>$request->input('hidden_id')])->update(['physical_meter_reject_reason'=>$request->input('reason'),'physical_testing_status'=>$request->input('status'),'physical_testing_time'=>time(),'current_meter_status'=>'Passed Physical test']);

        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('physical_test_report');
  
    }

    public function store_testing_batch_status(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'hidden_id'          => 'required',
                'status'      => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Please select minimum one record.");
            return \Redirect::back();
        }

        $new_data  = [];
        if($request->input('status')=='Approved')
        {
            $responce  = \DB::table('meter')->where('testing_status','!=','Rejected')->where(['physical_testing_status'=>'sagregated','batch_id'=>$request->input('hidden_id'),'testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected'])->update(['current_meter_status'=>'Open in EDF pool','status'=>'New Meter','testing_status'=>$request->input('status'),'batch_status'=>$request->input('status'),'batch_approve_reject_time'=>time()]);

            //rejected meters
            $responce  = \DB::table('meter')->where(['testing_status'=> 'Rejected',
                          'physical_testing_status'=>'sagregated','batch_id'=>$request->input('hidden_id'),'testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected'])->update(['current_meter_status'=>'Rejected in technical test','status'=>'New Meter','testing_status'=>"Rejected",'batch_status'=>"Rejected",'batch_reject_reason'=>$request->input('reason'),'batch_approve_reject_time'=>time()]);
        }
        else
        {
            $responce  = \DB::table('meter')->where('testing_status','!=','Rejected')->where(['physical_testing_status'=>'sagregated','batch_id'=>$request->input('hidden_id'),'testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected'])->update(['current_meter_status'=>'Rejected in technical test','status'=>'New Meter','testing_status'=>"Rejected",'batch_status'=>"Rejected",'batch_reject_reason'=>$request->input('reason'),'batch_approve_reject_time'=>time()]);
                    
            $responce  = \DB::table('meter')->where(['testing_status'=> 'Rejected',
                          'physical_testing_status'=>'sagregated','batch_id'=>$request->input('hidden_id'),'testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected'])->update(['current_meter_status'=>'Rejected in technical test','status'=>'New Meter','testing_status'=>"Rejected",'batch_status'=>"Rejected",'batch_reject_reason'=>$request->input('reason'),'batch_approve_reject_time'=>time()]);
        }

        $responce  = \DB::table('meter')->where('Rejected','!=','Rejected')->where('manual','!=','manual')->where(['physical_testing_status'=>'sagregated','batch_id'=>$request->input('hidden_id'),'testing_type'=>'manual','testing_status'=>'Sample Selected','batch_status'=>'Sample Selected'])->update(['testing_type'=>'auto']);

        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('test_report');
    }

    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            $flag = false;
            $temp = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if(!empty($row[5]))
                    {
                        $responce = \DB::table('meter')->where(['device_id'=>$row[5]])->first();

                        $i++;
                        if(!empty($responce))
                        {
                            $flag = true;
                            array_push($temp, $row[5]);
                        }
                    }
                }
            }
        }
        if($flag)
        {
            Session::flash('error', "Error! Meter No already exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
        
        $batch_grn_no     = \DB::table('meter')->where('batch_id','!=','')->groupBy('batch_id')->count();
        $tempdata = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        $details = $row;//explode(";",$row[0]);
                        if(isset($details[1]) && !empty($details[1]))
                        {
                            $new_data                       = [];
                            $new_data['batch_invoice_no']   = $details[1];
                            $new_data['batch_invoice_date'] = $details[2];
                            $new_data['batch_waybill_no']   = $details[3];
                            $new_data['batch_waybill_date'] = $details[4];

                            $new_data['device_id']                  = preg_replace('/[^A-Za-z0-9\-]/', '', $details[5]);
                            $new_data['manufacturer_serial_number'] = $details[5];
                            $new_data['box_no']                     = $details[6];
                            $new_data['reveived_date']              = $details[7];
                            $new_data['phase_type']                 = $details[8];
                            $new_data['sim_no']                     = 'sim_'.$details[9];
                            $new_data['imei_no']                    = $details[10];
                            $new_data['sim_no2']                    = $details[11];
                            $new_data['batch_supplier']             = $details[12];

                            $new_data['consumer_id']             = '';
                            $new_data['edf_vendor_manager_name'] = '';
                            $new_data['edf_vendor_plan_name']    = '';
                            $new_data['field_worker']            = '';
                            $new_data['edf_status']              = '';
                            $new_data['antenna']                 = '';
                            $new_data['installation_date_time']  = '';
                            $new_data['whm_vendor_manager_name'] = '';


                            $new_data['batch_grn_no']            = $batch_grn_no+1;
                            $new_data['batch_grn_date']          = date('Y-m-d');//$request->input('batch_grn_date');
                            $new_data['batch_delivery_location'] = $request->input('batch_delivery_location');
                            $new_data['batch_order_no']          = $request->input('batch_order_no');
                            $new_data['batch_transporter']       = $request->input('batch_transporter');
                            $new_data['batch_lr_docket_no']      = $request->input('batch_lr_docket_no');
                            $new_data['batch_vehicle_no']        = $request->input('batch_vehicle_no');       

                            $new_data['batch_id']                         = $batch_id;
                            $new_data['meter_upload_time']                = $date_time;
                            $new_data['batch_approve_reject_time']        = '';
                            $new_data['swh_delivery_time']                = '';
                            $new_data['vmwh_delivery_time']               = '';
                            $new_data['vendor_dispatch_date']               = '';
                            $new_data['vmwh_delivery_date']               = '';
                            $new_data['swh']                              = '';
                            $new_data['vmwh']                             = '';
                            $new_data['swh_name']                         = '';
                            $new_data['vmwh_name']                        = '';
                            $new_data['mrn_ref']                          = '';
                            $new_data['dl_ch_ref']                        = '';
                            $new_data['vmwh_mrn_ref']                     = '';
                            $new_data['vmwh_dl_ch_ref']                   = '';
                            $new_data['state_warehouse_selfpickup_image'] = '';
                            $new_data['vm_warehouse_selfpickup_image']    = '';
                            $new_data['current_meter_status']             = 'New';
                            $new_data['status']                           = 'Pending';
                            $new_data['testing_status']                   = 'Pending';
                            $new_data['testing_type']                     = '';
                            $new_data['meter_reject_reason']              = '';
                            $new_data['meter_reject_images']              = '';
                            $new_data['testing_time']                     = '';
                            $new_data['batch_status']                     = 'Pending';
                            $new_data['batch_reject_reason']              = '';
                            $new_data['physical_testing_status']          = 'Pending';
                            $new_data['physical_testing_time']            = '';
                            $new_data['physical_meter_reject_images']     = '';
                            $new_data['physical_meter_reject_reason']     = '';
                            $new_data['repaired_time ']                   = '';
                            $new_data['is_damage_accepted_swh']           = '';
                            $new_data['is_damage_accepted_admin']         = '';
                            $new_data['sm_damaged_mark_by_id']            = '';
                            $new_data['sm_damaged_mark_by_time']          = '';

                            $new_data['supplier_status']             = '';
                            $new_data['supplier_send_date']          = '';
                            $new_data['supplier_approve_date']       = '';
                            $new_data['supplier_admin_approve_date'] = '';

                            $new_data['s2s_damaged_status']                 = '';
                            $new_data['s2s_damaged_mark_by']                = '';
                            $new_data['s2s_damaged_mark_by_id']             = '';
                            $new_data['s2s_damaged_mark_by_time']           = '';
                            $new_data['s2s_parent_sw_for_damaged']          = '';
                            $new_data['s2s_is_damage_accepted_swh']         = '';
                            $new_data['s2s_sm_damaged_mark_by']             = '';
                            $new_data['s2s_sm_damaged_mark_by_id']          = '';
                            $new_data['s2s_sm_damaged_mark_by_time']        = '';
                            $new_data['s2s_is_damage_accepted_admin']       = '';
                            $new_data['s2s_supplier_status']                = '';
                            $new_data['s2s_supplier_send_date']             = '';
                            $new_data['s2s_supplier_approve_date']          = '';
                            $new_data['faulty_declared_date']               = '';
                            $new_data['date_of_receipt_of_meter_WH']        = '';
                            $new_data['date_of_dispatch_to_OEM_repair']     = '';
                            $new_data['date_of_receipt_of_refurbished']     = '';
                            $new_data['s2s_faulty_declared_date']           = '';
                            $new_data['s2s_date_of_receipt_of_meter_WH']    = '';
                            $new_data['s2s_date_of_dispatch_to_OEM_repair'] = '';
                            $new_data['s2s_date_of_receipt_of_refurbished'] = '';
                            $new_data['refurbished_meter_received_date']     = '';
                            $new_data['s2s_refurbished_meter_received_date'] = '';




                            $new_data['whm_system_utility']               = '';
                            $new_data['whm_system_utility_id']            = '';
                            $new_data['sm_damaged_mark_by']               = '';
                            $new_data['damaged_mark_by']                  = '';
                            $new_data['swh_inventory_status']             = 'NA';
                            $new_data['latitude']                         = '';
                            $new_data['longitude']                        = '';
                            $new_data['last_meter_location']              = \Session::get('warehouse_name');
                            $new_data['last_meter_location_time']         = time();
                            $new_data['meter_created_at']                 = date('d/m/Y h:i:s A');

                            $responce =  \DB::table('bsnl_sim')->where(['sim_no'=>$details[11]])->first();

                            if(!empty($responce))
                            {
                                $responce  = \DB::table('bsnl_sim')->where(['sim_no'=>$details[11]])->update(["sim_status" => 'UTILIZED']);
                            }

                            $responce = \DB::table('meter')->where(['manufacturer_serial_number'=>$details[1]])->first();
                            if(empty($responce))
                            {
                                array_push($tempdata, $new_data);
                            }
                        }
                    }
                    $i++;
                }
            }
            $responce = \DB::table('meter')->insert($tempdata);  
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }
        
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }

    public function view($id)
    {
        $cursor     = \DB::table('meter')->where(['_id'=>new MongoId($id)])->first();
        if(empty($cursor))
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = $cursor;
        $data['id']        = $id;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function new_view($id)
    {
        $option     = ['_id'=>new \MongoId($id)];
        $cursor     = $this->common_collection->find($option);
        $total      = 0;//$cursor->count();
        //$this->common_connection->close();
        
        if(!$total)
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = iterator_to_array($cursor);
        $data['id']        = $id;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'new_view',$data);
    }

    public function view_meter_testing($id)
    {
        $cursor     = \DB::table('meter')->where(['_id'=>new MongoId($id)])->first();
        
        if(!$cursor) 
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = $cursor;
        $data['reason']    = \DB::table('reason')->get();
        $data['id']        = $id;
        $data['page_name'] = "Testing";
        $data['title']     = "Report";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'view_meter_testing',$data);
    }

    public function view_physical_meter_testing($id)
    {
        $cursor     = \DB::table('meter')->where(['_id'=>new MongoId($id)])->first();
        
        if(empty($cursor)) 
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = $cursor;
        $data['reason']    = \DB::table('reason')->get();
        $data['id']        = $id;
        $data['page_name'] = "Testing";
        $data['title']     = "Report";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'view_physical_meter_testing',$data);
    }

    public function batch_list()
    {
        $db  = \DB::table('meter')->select(['batch_grn_no','batch_invoice_no','batch_grn_date','batch_supplier','batch_delivery_location','batch_invoice_date','batch_order_no','batch_transporter','batch_lr_docket_no','batch_waybill_no','batch_waybill_date','batch_vehicle_no','batch_id'])->where('batch_id','!=','')->groupBy('batch_id')->get();

        $data['data']    = $db;
        $data['page_name'] = "Process";
        $data['title']     = 'Batch';
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'batch_list',$data);
    }

    public function view_grn_batch($id)
    {
        $cursor     = \DB::table('meter')->where(['batch_id'=>$id])->orderBy('_id','DESC')->first();
        if(empty($cursor))
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $cursor = $cursor;
        $data = [];
        $data['data'] = $cursor;
        $data['id'] = $id;
        //$pdf = PDF::loadView($this->folder_path.'dl_ch_pdf',$data);
        return view($this->folder_path.'view_grn_batch',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf');
    }

    public function process_batch($id)
    {
        $reason_db  = $this->common_db->reason;
        $reason     = $reason_db->find();
        $data['reason']    = $reason;
        $data['page_name'] = "Process";
        $data['id']        = $id;
        $data['title']     = 'Batch';
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'process_batch',$data);
    }

    public function edit($id)
    {
        $option     = ['_id'=>new MongoId($id)];
        $cursor     = \DB::table('meter')->where($option)->first();
        

        $data['data']      = $cursor;
        $data['id']        = $id;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update_meter_sim(Request $request, $id)
    {
        
        $meter = \DB::table('meter')->where(['_id'=>new MongoId($id)])->first();
        \DB::table('meter')->where(['_id'=>new MongoId($id)])->update(['sim_no'=>$request->input('new_iccid')]);

        $history                 = [];
        $history['meter_id']     = new MongoId($id);
        $history['created_name'] = Session::get('username');
        
        $history['old_iccid']    = $meter['sim_no'];
        $history['iccid']        = $request->input('new_iccid');
        $history['date']         = date('Y-m-d h:i:s');
        $history['created_by']   = Session::get('_id');
        \DB::table('sim_history')->insert($history);
        
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('manage_'.$this->url_slug);
    }

    public function get_meter_to_admin_pool(Request $request)
    {
        //dd($_GET);
        foreach ($_GET['checkbox_id'] as $key => $value) 
        {
            $login_users = \DB::table('login_users')->where(['_id'=>new MongoId($request->input('assignee'))])->first();
            //dd($login_users);
            $arr_data                 = [];
            $arr_data['admin']        = new MongoId($request->input('assignee'));
            $arr_data['admin_name']   = $login_users['warehouse_name'];
            $arr_data['dl_ch_ref']    = '';
            $arr_data['batch_status'] = 'Approved';
            $arr_data['last_meter_location'] = $login_users['warehouse_name'];
            $arr_data['last_meter_location_time'] = time();
            $meter = \DB::table('meter')->where(['_id'=>new MongoId($value)])->first();
            $location = (!empty($meter['last_meter_location']))? $meter['last_meter_location']: 'Unknown';
            $respone = \DB::table('meter')->where(['_id'=>new MongoId($value)])->update($arr_data);


            
            $history                               = [];
            $history['meter_id'] = new MongoId($value);
            $history['created_name']               = Session::get('username');
            $history['activity']                   = 'Location:'.$location.' to Admin:'.$login_users['username'].'('.$login_users['warehouse_name'].')';
            $history['description']                = 'Meter get back to Inventory';
            $history['date']                       = date('Y-m-d h:i:s');
            $history['created_by']                 = Session::get('_id');
            \DB::table('meter_movement')->insert($history);
        }
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('manage_meter');
    }

    public function send_meter_to_vm_pool(Request $request)
    {
        $cursor_parameter_list     = \DB::table('mrn')->where(['_id' => new MongoId($request->input('select_vm_mrn'))])->first();
        $mrn_ref          = $cursor_parameter_list['vmwh_mrn_ref'];

        $login_users          = \DB::table('login_users')->where(['_id'=>new MongoId($request->input('select_vm'))])->first();
        $count_1phase         = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;
        $is_same_utility      = false;
        $meter_utility        = $mrn_utility = '';
        $not_same_utility_arr = $not_exist_arr = [];

        /*foreach ($_GET['checkbox_id'] as $key => $value) 
        {
            $meter_details = \DB::table('meter')->where(['_id'=>new MongoId($value)])->first();
            $meter_details = $meter_details;
            if(!empty($meter_details))
            {
                if($meter_details['whm_system_utility']!=$cursor_parameter_list['utility'])
                {
                    $meter_utility   = $meter_details['whm_system_utility'];
                    $mrn_utility     = $cursor_parameter_list['utility'];
                    $is_same_utility = true;
                    array_push($not_same_utility_arr, $meter_details['device_id']);
                }
                if($meter_details['phase_type']=='1 Phase')
                {
                    $count_1phase++;
                }
                elseif($meter_details['phase_type']=='3 Phase')
                {
                    $count_3phase++;

                }
            }
        }*/
        $validator          = Validator::make($request->all(), [
                'file1'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $fh = fopen($_FILES['file1']['tmp_name'], 'r+');   
        if(isset($_FILES["file1"]['tmp_name'])  && !empty($_FILES["file1"]['tmp_name']))
        {                    
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        if(isset($details[0]) && !empty($details[0]))
                        {
                            $meter_details = \DB::table('meter')->where(['device_id'=>$details[0]])->first();
                            $meter_details = $meter_details;
                            if(!empty($meter_details))
                            {
                                 if($meter_details['whm_system_utility']!=$cursor_parameter_list['utility'])
                                {
                                    $meter_utility   = $meter_details['whm_system_utility'];
                                    $mrn_utility     = $cursor_parameter_list['utility'];
                                    $is_same_utility = true;
                                    array_push($not_same_utility_arr, $meter_details['device_id']);
                                }
                                if($meter_details['phase_type']=='1 Phase')
                                {
                                    $count_1phase++;
                                }
                                elseif($meter_details['phase_type']=='3 Phase')
                                {
                                    $count_3phase++;

                                }
                            }
                        }
                }
            }
        }
        if($is_same_utility)
        {
            Session::flash('error', $meter_utility." meter can't assign to ".$mrn_utility.".... Meter List: -".implode(', ', $not_same_utility_arr));
            return \Redirect::back();
        }

        if($is_same_utility)
        {
            Session::flash('error', $meter_utility." meter can't assign to ".$mrn_utility.".... Meter List: -".implode(', ', $not_same_utility_arr));
            return \Redirect::back();
        }

        $count_1phase_balance = (empty($mrn_details['single_phase_meter_qty']))? 0: $mrn_details['single_phase_meter_qty']-$count_1phase;
        $count_3phase_balance = (empty($mrn_details['three_phase_meter_qty']))? 0: $mrn_details['three_phase_meter_qty']-$count_3phase;

        $single_phase_meter_qty_issued = $count_1phase;
        $three_phase_meter_qty_issued  = $count_3phase;
        $single_balance_to_issued      = $count_1phase_balance;
        $three_balance_to_issued       = $count_3phase_balance;

        $cursor           = \DB::table('mrn')->get();
        $count            = $cursor->count()+1;
        $dl_ch_ref        = $cursor_parameter_list['vmwh_dl_ch_ref'];//'EDF/BHR/EESL/'.date('d').'-'.date('Y').'-'.$count;

        $new_data                      = ["single_comment" => '',
                            "three_comment"                 => '',
                            "single_phase_meter_qty_issued" => $single_phase_meter_qty_issued,
                            "three_phase_meter_qty_issued"  => $three_phase_meter_qty_issued,
                            "single_balance_to_issued"      => (string)$single_balance_to_issued,
                            "three_balance_to_issued"       => (string)$three_balance_to_issued,
                            "to_dispatch"                   => new MongoId($request->input('select_vm')),
                            "dispatch_mode"                 => 'Self Pickup',
                            "name_of_pickup_person"         => $login_users['warehouse_name'],
                            "mobile_no_pickup_person"       => '',
                            "lr_no"                         => '',
                            "lr_copy"                       => '',
                            "transport_name"                => '',
                            "driver_name"                   => '',
                            "driver_mobile_no"              => '',

                            "dl_ch_ref"                     => $dl_ch_ref,
                            "dispatch_processing_date"      => date('d-m-Y'),
                            "dispatch_processing_time"      => date('h:i:s A'),
                            "is_delivery_challan"           => 'Yes',
                            "status"                        => 'Pending',
                            "delivery_status"               => 'Dispatch Process',
                            "wh"                            => \Session::get('_id'),
                            "from_address"                  => \Session::get('warehouse_address'),
                            "dispatch_created_time"         => time(),
                            //"vmwh_delivery_status"          => 'Delivered',
                            //"vmwh_delivery_date"            => date('d-m-Y'),
                            //"vmwh_delivery_time"            => date('h:i:s A'),
                            "vmwh_dispatch_processing_date" => date('d-m-Y'),
                            "vmwh_dispatch_processing_time" => date('h:i:s A'),
                            

                            "added_by"                      => '3',
                            
                            "delivery_date"                 => '',
                            "delivery_time"                 => '',
                            "delivery_accepted_time"        => '',
                            "single_phase_meter_price"      => '',
                            "three_phase_meter_price"       => '',
                            "grand_total"                   => '',
                        ];
                        $responce  = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('select_vm_mrn'))])->update($new_data);
        //dd($_GET);
        $fh = fopen($_FILES['file1']['tmp_name'], 'r+');   
        if(isset($_FILES["file1"]['tmp_name'])  && !empty($_FILES["file1"]['tmp_name']))
        {                   
                       
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    $details = $row;//explode(";",$row[0]);
                    if(isset($details[0]) && !empty($details[0]))
                    {
                        $login_users = \DB::table('login_users')->where(['_id'=>new MongoId($request->input('select_vm'))])->first();
                        
                       /* $arr_data                         = [];
                        $arr_data['vmwh']                 = new MongoId($request->input('select_vm'));
                        $arr_data['vmwh_name']            = $login_users['warehouse_name'];
                        $arr_data['swh_inventory_status'] = 'AssignedToVM';
                        $arr_data['last_meter_location'] = $login_users['warehouse_name'];
                        $arr_data['last_meter_location_time'] = time();

                        $arr_data['vmwh_mrn_ref'] = $mrn_ref;
                        $arr_data['vmwh_dl_ch_ref'] = $dl_ch_ref;
                        $arr_data['swh_inventory_status'] = 'Outstock';
                        $arr_data['current_meter_status'] = 'Pending MRN Acceptance in VP warehouse';*/
                        $arr_data  =  [
                                                "vmwh" => $cursor_parameter_list['vmwh'],
                                                "vmwh_mrn_ref" => $mrn_ref,
                                                "vmwh_dl_ch_ref" => $dl_ch_ref,
                                                "swh_inventory_status" => 'AssignedToVM',
                                                 "current_meter_status" => 'Pending MRN Acceptance in VP warehouse'
                                            ];



                        $meter = \DB::table('meter')->where(['device_id'=>$details[0]])->first();
                        $location = (!empty($meter['last_meter_location']))? $meter['last_meter_location']: 'Unknown';
                        $respone = \DB::table('meter')->where(['device_id'=>$details[0]])->update($arr_data);


                        
                        $history                               = [];
                        $history['meter_id'] = $details[0];
                        $history['created_name']               = Session::get('username');
                        $history['activity']                   = 'Location:'.$location.' to VM Warehouse:'.$login_users['username'].'('.$login_users['warehouse_name'].')';
                        $history['description']                = 'Meter sent to Inventory Pool';
                        $history['date']                       = date('Y-m-d h:i:s');
                        $history['created_by']                 = Session::get('_id');
                        \DB::table('meter_movement')->insert($history);
                    }
                }
            }
        }
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('metermovement');
    }

    public function send_meter_to_sm_pool(Request $request)
    {
         $cursor_parameter_list     = \DB::table('mrn')->where(['_id' => new MongoId($request->input('select_sw_mrn'))])->first();
        $mrn_ref          = $cursor_parameter_list['mrn_ref'];

        $login_users = \DB::table('login_users')->where(['_id'=>new MongoId($request->input('select_sw'))])->first();
        $count_1phase = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;
        $is_same_utility      = false;
        $meter_utility        = $mrn_utility = '';
        $not_same_utility_arr = $not_exist_arr = [];
        /*foreach ($_GET['checkbox_id'] as $key => $value) 
        {
            $meter_details = \DB::table('meter')->where(['_id'=>new MongoId($value)])->first();
            $meter_details = $meter_details;
            if(!empty($meter_details))
            {
                 if($meter_details['whm_system_utility']!=$cursor_parameter_list['utility'])
                {
                    $meter_utility   = $meter_details['whm_system_utility'];
                    $mrn_utility     = $cursor_parameter_list['utility'];
                    $is_same_utility = true;
                    array_push($not_same_utility_arr, $meter_details['device_id']);
                }
                if($meter_details['phase_type']=='1 Phase')
                {
                    $count_1phase++;
                }
                elseif($meter_details['phase_type']=='3 Phase')
                {
                    $count_3phase++;

                }
            }
        }*/
        $validator          = Validator::make($request->all(), [
                'file'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $fh = fopen($_FILES['file']['tmp_name'], 'r+');   
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                        $details = $row;//explode(";",$row[0]);
                        if(isset($details[0]) && !empty($details[0]))
                        {
                            $meter_details = \DB::table('meter')->where(['device_id'=>$details[0]])->first();
                            $meter_details = $meter_details;
                            if(!empty($meter_details))
                            {
                                 if($meter_details['whm_system_utility']!=$cursor_parameter_list['utility'])
                                {
                                    $meter_utility   = $meter_details['whm_system_utility'];
                                    $mrn_utility     = $cursor_parameter_list['utility'];
                                    $is_same_utility = true;
                                    array_push($not_same_utility_arr, $meter_details['device_id']);
                                }
                                if($meter_details['phase_type']=='1 Phase')
                                {
                                    $count_1phase++;
                                }
                                elseif($meter_details['phase_type']=='3 Phase')
                                {
                                    $count_3phase++;

                                }
                            }
                        }
                }
            }
        }
        if($is_same_utility)
        {
            Session::flash('error', $meter_utility." meter can't assign to ".$mrn_utility.".... Meter List: -".implode(', ', $not_same_utility_arr));
            return \Redirect::back();
        }
        $count_1phase_balance = (empty($mrn_details['single_phase_meter_qty']))? 0: $mrn_details['single_phase_meter_qty']-$count_1phase;
        $count_3phase_balance = (empty($mrn_details['three_phase_meter_qty']))? 0: $mrn_details['three_phase_meter_qty']-$count_3phase;

        $single_phase_meter_qty_issued = $count_1phase;
        $three_phase_meter_qty_issued  = $count_3phase;
        $single_balance_to_issued      = $count_1phase_balance;
        $three_balance_to_issued       = $count_3phase_balance;

        $cursor           = \DB::table('mrn')->get();
        $count            = $cursor->count()+1;
        $dl_ch_ref        = $cursor_parameter_list['dl_ch_ref'];//'EDF/BHR/EESL/'.date('d').'-'.date('Y').'-'.$count;

        $new_data                      = ["single_comment" => '',
                            "three_comment"                 => '',
                            "single_phase_meter_qty_issued" => $single_phase_meter_qty_issued,
                            "three_phase_meter_qty_issued"  => $three_phase_meter_qty_issued,
                            "single_balance_to_issued"      => (string)$single_balance_to_issued,
                            "three_balance_to_issued"       => (string)$three_balance_to_issued,
                            "to_dispatch"                   => new MongoId($request->input('select_sw')),
                            "dispatch_mode"                 => 'Self Pickup',
                            "name_of_pickup_person"         => $login_users['warehouse_name'],
                            "mobile_no_pickup_person"       => '',
                            "lr_no"                         => '',
                            "lr_copy"                       => '',
                            "transport_name"                => '',
                            "driver_name"                   => '',
                            "driver_mobile_no"              => '',

                            "dl_ch_ref"                     => $dl_ch_ref,
                            "dispatch_processing_date"      => date('d-m-Y'),
                            "dispatch_processing_time"      => date('h:i:s A'),
                            "is_delivery_challan"           => 'Yes',
                            "status"                        => 'Dispatch Process',
                            "delivery_status"               => 'Dispatch Process',
                            "wh"                            => \Session::get('_id'),
                            "from_address"                  => \Session::get('warehouse_address'),
                            "dispatch_created_time"         => time(),
                            "delivery_date"                 => '',
                            "delivery_time"                 => '',
                            "delivery_accepted_time"        => '',
                            "single_phase_meter_price"      => '',
                            "three_phase_meter_price"       => '',
                            "grand_total"                   => '',
                        ];

                        $responce  = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('select_sw_mrn'))])->update($new_data);
        $fh = fopen($_FILES['file']['tmp_name'], 'r+');   
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                   
                       
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    $details = $row;//explode(";",$row[0]);
                    if(isset($details[0]) && !empty($details[0]))
                    {
       
        
                        //dd($login_users);
                        $arr_data                         = [];
                        /*$arr_data['swh']                  = new MongoId($request->input('select_sw'));
                        $arr_data['swh_name']             = $login_users['warehouse_name'];
                        $arr_data['batch_status']         = 'Approved';
                        $arr_data['swh_inventory_status'] = 'Instock';*/

                        $arr_data['mrn_ref']              = $mrn_ref;
                        $arr_data['dl_ch_ref']            = $dl_ch_ref;
                        $arr_data['current_meter_status'] = 'Pending MRN Acceptance in EDF warehouse';
                        
                        /*$arr_data['last_meter_location'] = $login_users['warehouse_name'];
                        $arr_data['last_meter_location_time'] = time();*/


                        $meter = \DB::table('meter')->where(['device_id'=>$details[0]])->first();
                        $location = (!empty($meter['last_meter_location']))? $meter['last_meter_location']: 'Unknown';
                        $respone                          = \DB::table('meter')->where(['device_id'=>$details[0]])->update($arr_data);

                        
                        $history                               = [];
                        $history['meter_id'] = $details[0];
                        $history['created_name']               = Session::get('username');
                        $history['activity']                   = 'Location:'.$location.' to SM Warehouse:'.$login_users['username'].'('.$login_users['warehouse_name'].')';
                        $history['description']                = 'Meter sent to Inventory Pool';
                        $history['date']                       = date('Y-m-d h:i:s');
                        $history['created_by']                 = Session::get('_id');
                        \DB::table('meter_movement')->insert($history);
                    }
                }
            }
        }
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('metermovement');
    }

    public function get_sm_mrn()
    {
        $state = $_GET['id'];
        if ($state != null) {
                $data = \DB::table('mrn')->where(['status'=>'Pending','vmwh'=>'','swh'=>new MongoId($_GET['id'])])->get();
                if (count($data) > 0) {
                        echo "<option>Select MRN</option>";
                    foreach ($data as $details) {
                        echo "<option value='" . $details['_id'] . "'>" . $details['mrn_ref']."</option>";
                    }
                } else {
                    echo '<option value="">No MRN Available</option>';
                }
        }
    }

    public function get_vm_mrn()
    {
        $state = $_GET['id'];
        if ($state != null) {
                $data =  \DB::table('mrn')->where('vmwh','!=','')->where(['vmwh'=>new MongoId($_GET['id']),'mrn_authorized_2_status'=>'Approve','status'=>'Pending'])->get();
                if (count($data) > 0) {
                        echo "<option>Select MRN</option>";
                    foreach ($data as $details) {
                        echo "<option value='" . $details['_id'] . "'>" . $details['vmwh_mrn_ref']."</option>";
                    }
                } else {
                    echo '<option value="">No MRN Available</option>';
                }
        }
    }

    public function delete($id)
    {
        $condition = ['_id'  => new \MongoId($id)];
        $new_data  = ['$set'=> ["is_delete" => '1']];
        $responce  = $this->common_collection->update($condition,$new_data);
        //$this->common_connection->close();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
