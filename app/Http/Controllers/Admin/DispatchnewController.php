<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use PDF;
use \MongoDB\BSON\ObjectID as MongoId;

class DispatchnewController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        /*$this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db         = $this->common_connection->whm;
        $this->common_collection = $this->common_db->mrn;*/
        $this->title             = "Dispatch";
        $this->url_slug          = "dispatch";
        $this->folder_path       = "admin/dispatch/";
    }

    public function index()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt' => -1);
        $condition  = [];
        $cursor     = \DB::table('mrn');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['dl_ch_ref' => $_GET['search'],'is_delivery_challan'=>'Yes'])->where('dl_ch_ref','!=','');
        }
        else
        {
           $cursor = $cursor->where('dl_ch_ref','!=',''); 
        }

        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }

    public function dispatch_swh_index()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt' => -1);
        $condition  = [];
        $cursor     = \DB::table('mrn');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['added_by'=>'2','dl_ch_ref' =>$_GET['search'],'is_delivery_challan'=>'Yes','swh'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['added_by'=>'2','is_delivery_challan'=>'Yes','swh'=>new MongoId(\Session::get('_id'))]);

        }

        //dd($condition);
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['reason']    = \DB::table('reason')->get();
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;  
        return view($this->folder_path.'dispatch_swh_index',$data);
    }

    public function dispatch_vmwh_index()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('createdAt' => -1);
        $condition  = [];
         $cursor     = \DB::table('mrn');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where('vmwh_dispatch_processing_date','!=','')->where(['added_by'=>'3','vmwh_dl_ch_ref' =>$_GET['search'],'is_delivery_challan'=>'Yes','vmwh'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where('vmwh_dispatch_processing_date','!=','')->where(['added_by'=>'3','is_delivery_challan'=>'Yes','vmwh'=>new MongoId(\Session::get('_id'))]);

        }
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $total      = 0;//$cursor->count();
        
        $data['reason']    = \DB::table('reason')->get();
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'dispatch_vmwh_index',$data);
    }
 
    public function add()
    {
        
        $data['page_name'] = "Add";  
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function accept_dispatch_swh($id)
    {
        $reason_db  = $this->common_db->reason;
        $reason     = $reason_db->find();
        $data['reason']    = $reason;
        $data['id']        = $id;  
        $data['page_name'] = "Accept";  
        $data['title']     = "Dispatch";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'accept_dispatch_swh',$data);
    }

    public function store_accept_dispatch_swh(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'id'          => 'required',
                'status'      => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Oop's something went wrong. Please try again.");
            return \Redirect::to('dispatch_swh_index');
        }

        $id     = $request->input('id');
        $status = $request->input('status');
        $reason = $request->input('reason');
        $condition = ['_id'=>new MongoId($id)];
        //dd($_FILES);
        //dd($condition);
        $new_data  = [];
        if($status=='Approved')
        {
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString     = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $latest_image = '';
            if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"]))
            {
                $file_name        = $_FILES["file"]["name"];
                $file_tmp         = $_FILES["file"]["tmp_name"];
                $ext              = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name = $randomString.'0.'.$ext;
                $latest_image     = '/upload/delivery_proof/'.$random_file_name;
                if(!move_uploaded_file($file_tmp,base_path().$latest_image))
                {
                    Session::flash('error', "Error! Oop's something went wrong.");
                    return \Redirect::to('dispatch_swh_index');
                }
            }
            $new_data  = ['delivery_status'=>'Delivered','status'=>'Delivered','delivery_proof'=>$latest_image,'delivery_date'=>date('d-m-Y'),'delivery_time'=>date('h:i:s A'),'delivery_accepted_time'=>time()];
                    $str = 'Open in EDF Warehouse';
        }
        else
        {
            $new_data  = ['delivery_status'=>'Delivered','status'=>$status,'delivery_reject_reason'=>$reason,'delivery_date'=>date('d-m-Y'),'delivery_time'=>date('h:i:s A'),'delivery_accepted_time'=>time()];
                    $str = 'Rejected in EDF warehouse';
        }

        $responce  = \DB::table('mrn')->where($condition)->update($new_data);


        $responce  = \DB::table('mrn')->where($condition)->first();
        $dl_ch_ref = $responce['dl_ch_ref'];    
       
        if(!empty($responce))
        {
            $condition       = ['dl_ch_ref'=>$dl_ch_ref];
            $new_data        = ['current_meter_status'=>$str,'swh'=>\Session::get('_id'),'swh_name'=>\Session::get('warehouse_name'),'last_meter_location'=>\Session::get('warehouse_name'),'last_meter_location_time'=>time(),'swh_delivery_time'=>time(),'swh_inventory_status'=>'Instock'];
            $responce        = \DB::table('meter')->where($condition)->update($new_data);

            
            $condition       = ['dl_ch_ref'=>$dl_ch_ref];
            $new_data        = ['swh'=>\Session::get('_id'),'swh_name'=>\Session::get('warehouse_name'),'last_sim_location'=>\Session::get('warehouse_name'),'last_sim_location_time'=>time(),'swh_delivery_time'=>time(),'swh_inventory_status'=>'Instock'];
            $responce        = \DB::table('bsnl_sim')->where($condition)->update($new_data);

            
            $condition       = ['dl_ch_ref'=>$dl_ch_ref];
            $new_data        = ['swh'=>\Session::get('_id'),'swh_name'=>\Session::get('warehouse_name'),'last_modem_location'=>\Session::get('warehouse_name'),'last_modem_location_time'=>time(),'swh_delivery_time'=>time(),'swh_inventory_status'=>'Instock'];
            $responce        = \DB::table('modem')->where($condition)->update($new_data);
        }

        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('dispatch_swh_index');
    }

    public function accept_dispatch_vmwh($id)
    {
        $reason_db  = $this->common_db->reason;
        $reason     = $reason_db->find();
        $data['reason']    = $reason;
        $data['id']        = $id;  
        $data['page_name'] = "Accept";  
        $data['title']     = "Dispatch";
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'accept_dispatch_vmwh',$data);
    }

    public function store_accept_dispatch_vmwh(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'id'          => 'required',
                'status'      => 'required',
            ]);

        if ($validator->fails()) 
        {
            Session::flash('error', "Error! Oop's something went wrong. Please try again.");
            return \Redirect::to('dispatch_vmwh_index');
        }

        $id     = $request->input('id');
        $status = $request->input('status');
        $reason = $request->input('reason');
        $condition = ['_id'=>new MongoId($id)];
        //dd($_FILES);
        $new_data  = [];
        if($status=='Approved')
        {
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString     = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            if(isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"]))
            {
                $file_name        = $_FILES["file"]["name"];
                $file_tmp         = $_FILES["file"]["tmp_name"];
                $ext              = pathinfo($file_name,PATHINFO_EXTENSION);
                $random_file_name = $randomString.'0.'.$ext;
                $latest_image     = '/upload/delivery_proof/'.$random_file_name;
                if(!move_uploaded_file($file_tmp,base_path().$latest_image))
                {
                    Session::flash('error', "Error! Oop's something went wrong.");
                    return \Redirect::to('dispatch_vmwh_index');
                }
            }
            $new_data  = ['vmwh_delivery_status'=>'Delivered','status'=>'Delivered','vmwh_delivery_proof'=>$latest_image,'vmwh_delivery_date'=>date('d-m-Y'),'vmwh_delivery_time'=>date('h:i:s A'),'vmwh_dispatch_created_time'=>time()];
                    $str = 'Open in VP warehouse';
        }
        else
        {
            $new_data  = ['vmwh_delivery_status'=>'Delivered','status'=>$status,'delivery_reject_reason'=>$reason,'vmwh_delivery_date'=>date('d-m-Y'),'vmwh_delivery_time'=>date('h:i:s A'),'vmwh_dispatch_created_time'=>time()];
                    $str = 'Rejected in VP warehouse';
        }

        \DB::table('mrn')->where($condition)->update($new_data);


        $mrn_details  = \DB::table('mrn')->where($condition)->first();
        $dl_ch_ref = '__null__';
        if(!empty($mrn_details))
        {
            $dl_ch_ref = $mrn_details['vmwh_dl_ch_ref'];    
        }
        if(!empty($mrn_details))
        {
            $condition       = ['vmwh_dl_ch_ref'=>$dl_ch_ref,'swh_inventory_status'=>'AssignedToVM'];
            $new_data        = ['current_meter_status'=>$str,'vmwh'=>\Session::get('_id'),'last_meter_location'=>\Session::get('warehouse_name'),'whm_vendor_manager_name'=>\Session::get('warehouse_name'),'vmwh_name'=>\Session::get('warehouse_name'),'last_meter_location_time'=>time(),'vmwh_delivery_time'=>time(),'vmwh_delivery_date'=>date('Y-m-d'),'swh_inventory_status'=>'Outstock'];
            $responce        = \DB::table('meter')->where($condition)->update($new_data);
            
            $new_data        = ['vmwh'=>\Session::get('_id'),'last_sim_location'=>\Session::get('warehouse_name'),'vmwh_name'=>\Session::get('warehouse_name'),'last_sim_location_time'=>time(),'vmwh_delivery_time'=>time(),'swh_inventory_status'=>'Outstock'];
            $responce        = \DB::table('bsnl_sim')->where($condition)->update($new_data);

            $new_data        = ['vmwh'=>\Session::get('_id'),'last_modem_location'=>\Session::get('warehouse_name'),'vmwh_name'=>\Session::get('warehouse_name'),'last_modem_location_time'=>time(),'vmwh_delivery_time'=>time(),'swh_inventory_status'=>'Outstock'];
            $responce        = \DB::table('modem')->where($condition)->update($new_data);
        }

       
        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('dispatch_vmwh_index');
    }
    
    public function form_dispatch_meter_step_1(Request $request)
    {
        if(!empty($_POST['mrn']) && isset($_POST['obi_id']) && empty($_POST['obi_id']))
        {
            Session::flash('error', "Error! Please select MRN No. & Meters to process");
            return \Redirect::back();
        }

        $mrn_details = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('mrn'))])->first();
        
        if(empty($mrn_details))
        {
            Session::flash('error', "Error! Please select valid MRN No.");
            return \Redirect::back(); 
        }

        $swh = \DB::table('login_users')->where(['role'=>'2'])->get();
        if(empty($swh))
        {
            Session::flash('error', "Error! SWH not available! Please try again.");
            return \Redirect::back(); 
        }

        $total_bsnl_sim_count = $total_modem_count = $match_found_meter = $total_upload_meter = $count_1phase = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;
        $temp = $temp1 = $temp2 = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
          
            $i = 0;
            $is_same_utility = false;
            $not_exist_flag  = false;
            $meter_utility = $mrn_utility = '';
            $not_same_utility_arr = $not_exist_arr = [];
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                /*if(strlen($row[0])!=9)
                {
                    Session::flash('error', "Meter No. is having ASCII characters. Please check sheet & upload again.");
                    return \Redirect::back();
                }*/   
                $meter_details_ = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>"",'device_id'=>$row[0]])->get();
                if(!count($meter_details_))
                {
                    $not_exist_flag = true;
                    array_push($not_exist_arr, $row[0]);
                }

                foreach ($meter_details_ as $key => $value) 
                {
                    if(!empty($value))
                    {
                        if($value['whm_system_utility']!=$mrn_details['utility'])
                        {
                            $meter_utility   = $value['whm_system_utility'];
                            $mrn_utility     = $mrn_details['utility'];
                            $is_same_utility = true;
                            array_push($not_same_utility_arr, $row[0]);
                        }

                        if($value['phase_type']=='1 Phase')
                        {
                            $count_1phase++;
                            foreach ($value['_id'] as $key1 => $value1) 
                            {
                                array_push($temp,$value1);
                            }
                        }
                        elseif($value['phase_type']=='3 Phase')
                        {
                            $count_3phase++;
                            foreach ($value['_id'] as $key1 => $value1) 
                            {
                                array_push($temp,$value1);
                            }
                        }
                        $match_found_meter++;
                    }
                }
                $total_upload_meter++;
            }

            if($not_exist_flag)
            {
                Session::flash('error', "Meter Not Found in EDF Pool! Meter List: -".implode(', ', $not_exist_arr));
                return \Redirect::back();
            }

            if($is_same_utility)
            {
                Session::flash('error', $meter_utility." meter can't assign to ".$mrn_utility.".... Meter List: -".implode(', ', $not_same_utility_arr));
                return \Redirect::back();
            }
        }
            $match_found_sim = $i = 0;
        if(isset($_FILES["simfile"]['tmp_name'])  && !empty($_FILES["simfile"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['simfile']['tmp_name'], 'r+');               
          
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                $sim = \DB::table('bsnl_sim')->where(['sim_no'=>$row[0],'mrn_ref'=>'','sim_status'=>'UNUTILISED'])->get();
                if(empty($sim))
                {
                    Session::flash('error', "Sim Not Found in EDF Pool!");
                    return \Redirect::back();
                }
                foreach ($sim as $key => $value) 
                {
                    if(!empty($value))
                    {
                        foreach ($value['_id'] as $key1 => $value1) 
                        {
                            array_push($temp1,$value1);
                        }
                        $match_found_sim++;
                    }
                }

                $i++;
            }
            $total_bsnl_sim_count = $i;
        }
            $match_found_modem = $i = 0;
        if(isset($_FILES["modemfile"]['tmp_name'])  && !empty($_FILES["modemfile"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['modemfile']['tmp_name'], 'r+');               
          
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                $modem = \DB::table('modem')->where(['modem_number'=>$row[0],'mrn_ref'=>'','status'=>'UNUTILISED'])->get();
                
                if(empty($modem))
                {
                    Session::flash('error', "Modem Not Found in EDF Pool!");
                    return \Redirect::back();
                }
                foreach ($modem as $key => $value) 
                {
                    if(!empty($value))
                    {
                        foreach ($value['_id'] as $key1 => $value1) 
                        {
                            array_push($temp2,$value1);
                        }
                        $match_found_modem++;
                    }
                }
                $i++;
            }
            $total_modem_count = $i;
        }


        $validation_sim_qty                = $mrn_details['sim_qty'];
        $validation_modem_qty              = $mrn_details['modem_qty'];
        $validation_three_phase_meter_qty  = $mrn_details['three_phase_meter_qty'];
        $validation_single_phase_meter_qty = $mrn_details['single_phase_meter_qty'];
        $validation_total_meter            = $validation_three_phase_meter_qty+$validation_single_phase_meter_qty;
        
        if($validation_total_meter>0)
        {
            /*if($validation_single_phase_meter_qty>=$count_1phase)
            {
                Session::flash('error', "Error! Please upload 1 phase Meter:".$validation_single_phase_meter_qty);
                return \Redirect::back();
            }

            if($validation_three_phase_meter_qty>=$count_3phase)
            {
                Session::flash('error', "Error! Please upload 3 phase Meter:".$validation_three_phase_meter_qty);
                return \Redirect::back();

            }*/
            if($validation_total_meter!=$match_found_meter && $validation_total_meter<=$match_found_meter)
            {
                Session::flash('error', "Uploaded meter quantity is exceeded that MRN Request!");
                return \Redirect::back();

            }
        }
        if($validation_sim_qty>0)
        {
            if($validation_sim_qty!=$match_found_sim && $validation_sim_qty<=$match_found_sim)
            {
                Session::flash('error', "Uploaded sim quantity is exceeded that MRN Request!");
                return \Redirect::back(); 
            }
        }
        if($validation_modem_qty>0)
        {
            if($validation_modem_qty!=$match_found_modem && $validation_modem_qty<=$match_found_modem)
            {
                Session::flash('error', "Uploaded modem quantity is exceeded that MRN Request!:");
                return \Redirect::back(); 
            }
        }

        //dd('validation pass');
        
        /*foreach ($request->input('obi_id') as $key => $value) 
        {
            $meter_details = $this->common_db->meter->find(['_id'=>new MongoId($value)]);
            $meter_details = iterator_to_array($meter_details);
            if(!empty($meter_details))
            {
                if($meter_details[$value]['phase_type']=='1 Phase')
                {
                    $count_1phase++;
                }
                elseif($meter_details[$value]['phase_type']=='3 Phase')
                {
                    $count_3phase++;

                }
            }
        }*/

        $count_1phase_balance = (empty($mrn_details['single_phase_meter_qty']))? 0: $mrn_details['single_phase_meter_qty']-$count_1phase;
        $count_3phase_balance = (empty($mrn_details['three_phase_meter_qty']))? 0: $mrn_details['three_phase_meter_qty']-$count_3phase;
        $count_bsnl_sim_balance       = (empty($mrn_details['sim_qty']))? 0: $mrn_details['sim_qty']-$match_found_sim;
        $count_modem_balance          = (empty($mrn_details['modem_qty']))? 0: $mrn_details['modem_qty']-$match_found_modem;
      
        $meter_ids_list               = json_encode($temp);
        $data['mrn_id']               = $request->input('mrn');
        $data['mrn_details']          = $mrn_details;
        $data['match_found_meter']    = $match_found_meter;
        $data['total_upload_meter']   = $total_upload_meter;
        $data['count_1phase']         = $count_1phase;
        $data['count_3phase']         = $count_3phase;
        $data['count_1phase_balance'] = $count_1phase_balance;
        $data['count_3phase_balance'] = $count_3phase_balance;
        $data['meter_ids_list']       = $meter_ids_list;
        $data['swh']                  = $swh;
        $data['upload_sim_total']     = $total_bsnl_sim_count;
        $data['match_found_sim']      = $match_found_sim;
        $data['sim_ids_list']         = json_encode($temp1);
        $data['upload_modem_total']   = $total_modem_count;

        $data['count_bsnl_sim_balance']   = $count_bsnl_sim_balance;
        $data['count_modem_balance']   = $count_modem_balance;

        $data['match_found_modem']    = $match_found_modem;
        $data['modem_ids_list']       = json_encode($temp2);
        $data['page_name']            = "Add";
        $data['title']                = $this->title;
        $data['url_slug']             = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function form_dispatch_meter_step_2(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'to_dispatch'          => 'required',
                'dispatch_mode'        => 'required',
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $cursor     = \DB::table('mrn')->where(['_id' => new MongoId($request->input('mrn_id'))])->first();
        
        if(empty($cursor))
        {
            Session::flash('error', "Please Select valid MRN No.");
            return \Redirect::back();
        }
        if(empty($request->input('meter_ids_list')))
        {
            Session::flash('error', "Please Select Meters to process.");
            return \Redirect::back();
        }

        $count_1phase = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;

        foreach (json_decode($request->input('meter_ids_list')) as $key => $value) 
        {
            $meter_details = \DB::table('meter')->where(['_id'=>new MongoId($value)])->first();
            $meter_details = $meter_details;
            if(!empty($meter_details))
            {
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


        $count_1phase_balance = (empty($mrn_details['single_phase_meter_qty']))? 0: $mrn_details['single_phase_meter_qty']-$count_1phase;
        $count_3phase_balance = (empty($mrn_details['three_phase_meter_qty']))? 0: $mrn_details['three_phase_meter_qty']-$count_3phase;

        $single_phase_meter_qty_issued = $count_1phase;
        $three_phase_meter_qty_issued  = $count_3phase;
        $single_balance_to_issued      = $count_1phase_balance;
        $three_balance_to_issued       = $count_3phase_balance;
        //$total_meter_qty               = $single_phase_meter_qty_issued + $three_phase_meter_qty_issued;
        $cursor_parameter_list         = $cursor;

        $cursor           = \DB::table('mrn')->get();
        $count            = $cursor->count()+1;
        $mrn_ref          = $cursor_parameter_list['mrn_ref'];
        $dl_ch_ref        = $cursor_parameter_list['dl_ch_ref'];//'EDF/BHR/EESL/'.date('d').'-'.date('Y').'-'.$count;
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString     = '';

        for ($i = 0; $i < 18; $i++) 
        {
            $randomString    .= $characters[rand(0, $charactersLength - 1)];
        }
        $latest_image = '';
        if(isset($_FILES["lr_copy"]["name"]) && !empty($_FILES["lr_copy"]["name"]))
        {
            $file_name        = $_FILES["lr_copy"]["name"];
            $file_tmp         = $_FILES["lr_copy"]["tmp_name"];
            $ext              = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name = $randomString.'0.'.$ext;
            $latest_image     = '/upload/lr_copy/'.$random_file_name;
            if(!move_uploaded_file($file_tmp,base_path().$latest_image)){ /*no action*/ }
        }
        $new_data                       = ["single_comment" => $request->input('single_comment'),
                    "three_comment"                 => $request->input('three_comment'),
                    "single_phase_meter_qty_issued" => $single_phase_meter_qty_issued,
                    "three_phase_meter_qty_issued"  => $three_phase_meter_qty_issued,
                    "single_balance_to_issued"      => (string)$single_balance_to_issued,
                    "three_balance_to_issued"       => (string)$three_balance_to_issued,
                    "to_dispatch"                   => $request->input('to_dispatch'),
                    "dispatch_mode"                 => $request->input('dispatch_mode'),
                    "name_of_pickup_person"         => $request->input('name_of_pickup_person'),
                    "mobile_no_pickup_person"       => $request->input('mobile_no_pickup_person'),
                    "lr_no"                         => $request->input('lr_no'),
                    "lr_copy"                       => $latest_image,
                    "transport_name"                => $request->input('transport_name'),
                    "driver_name"                   => $request->input('driver_name'),
                    "driver_mobile_no"              => $request->input('driver_mobile_no'),
                    "sim_qty_issued"                => $request->input('match_found_sim'),
                    "modem_phase_meter_qty_issued"  => $request->input('match_found_modem'),
                    "seal_phase_meter_qty_issued"   => $request->input('seal_qty'),
                    "sim_balance_to_issued"         => $request->input('count_bsnl_sim_balance'),
                    "modem_balance_to_issued"       => $request->input('count_modem_balance'),





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
                     
        $responce  = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('mrn_id'))])->update($new_data);
        if(!empty($request->input('meter_ids_list')))
        {
            foreach (json_decode($request->input('meter_ids_list')) as $key => $value) 
            {
                $new_data  =  [
                                    "mrn_ref" => $mrn_ref,
                                    "dl_ch_ref" => $dl_ch_ref,
                                    "current_meter_status" => 'Pending MRN Acceptance in EDF warehouse',
                                ];
                $responce  = \DB::table('meter')->where(['_id'=>new MongoId($value)])->update($new_data);
            }
        }

       
        if(!empty($request->input('seal_qty')))
        {
             $new_data                     = [];
            $new_data['new_stock']         = '-'.$request->input('seal_qty');
            $new_data['date']              = date('d-m-Y h:i:s');
            $new_data['mrn_ref']           = $mrn_ref;
            $new_data['dl_ch_ref']         = $dl_ch_ref;
            $responce = \DB::table('seal_stock')->insert($new_data);
        }
       
        if(!empty($request->input('sim_ids_list')))
        {
            foreach (json_decode($request->input('sim_ids_list')) as $key => $value) 
            {
                $new_data  =  [
                                    "mrn_ref" => $mrn_ref,
                                    "dl_ch_ref" => $dl_ch_ref,
                                ];
                $responce  = \DB::table('bsnl_sim')->where(['_id'=>new MongoId($value)])->update($new_data);
            }
        }

        if(!empty($request->input('modem_ids_list')))
        {
            foreach (json_decode($request->input('modem_ids_list')) as $key => $value) 
            {
                $new_data  =  [
                                    "mrn_ref" => $mrn_ref,
                                    "dl_ch_ref" => $dl_ch_ref,
                                ];
                $responce  = \DB::table('modem')->where(['_id'=>new MongoId($value)])->update($new_data);
            }
        }
        
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('edf_meter_pool');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function swh_form_dispatch_meter_step_1(Request $request)
    {
        if(!empty($_POST['mrn']) && isset($_POST['obi_id']) && empty($_POST['obi_id']))
        {
            Session::flash('error', "Error! Please select MRN No. & Meters to process");
            return \Redirect::back();
        }

        $mrn_details = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('mrn'))])->first();
        if(empty($mrn_details))
        {
            Session::flash('error', "Error! Please select valid MRN No.");
            return \Redirect::back(); 
        }
        //['$ne'=>'1']
        $swh = \DB::table('login_users')->where(['role'=>'3'])->get();
        if(empty($swh))
        {
            Session::flash('error', "Error! SWH not available! Please try again.");
            return \Redirect::back(); 
        }

        $match_found_sim = 0;
        $match_found_modem=0;
        $total_bsnl_sim_count = 0;
        $total_modem_count = 0;
        $count_1phase = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;
        $match_found_meter = $total_upload_meter = $count_1phase = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;
        $temp = $temp1 =$temp2 = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            $not_exist_flag = false;
            $is_same_utility = false;
            $meter_utility = $mrn_utility = '';
            $not_same_utility_arr = $not_exist_arr = [];
            $count = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                $meter_details = \DB::table('meter')->where(['swh_inventory_status'=>'Instock','batch_status'=>'Approved'/*'swh'=>new MongoId(\Session::get('_id'))*//*,'whm_system_utility'=>\Session::get('utility')*/,'device_id'=>$row[0]])->get();
                //$meter_details = \DB::table('meter')->where(['device_id'=>$row[0]])->get();
                if(!count($meter_details))
                {
                    $not_exist_flag = true;
                    array_push($not_exist_arr, $row[0]);
                    //Session::flash('error', "Meter Not Found in EDF Pool!");
                    //return \Redirect::back();
                }
                foreach ($meter_details as $key => $value) 
                {
                    //echo 'device_id:'.$value['device_id'].'->Vendor Name:'.$value['vmwh_name'].'<br>';
                    if(!empty($value))
                    {

                        if($value['whm_system_utility']!=$mrn_details['utility'])
                        {
                            $meter_utility   = $value['whm_system_utility'];
                            $mrn_utility     = $mrn_details['utility'];
                            $is_same_utility = true;
                            array_push($not_same_utility_arr, $row[0]);
                        }
                        if($value['phase_type']=='1 Phase')
                        {
                            $count_1phase++;
                            
                                array_push($temp,$value['_id']);
                            
                        }
                        elseif($value['phase_type']=='3 Phase')
                        {
                            $count_3phase++;
                            
                                array_push($temp,$value['_id']);
                            
                        }
                        else
                        {
                            dd(321);
                        }
                    }
                    $match_found_meter++;
                }
                $total_upload_meter++;
            }
            if($not_exist_flag)
            {
                Session::flash('error', "Meter Not Found in EDF Pool! Meter List: -".implode(', ', $not_exist_arr));
                return \Redirect::back();
            }

            if($is_same_utility)
            {
                Session::flash('error', $meter_utility." meter can't assign to ".$mrn_utility.".... Meter List: -".implode(', ', $not_same_utility_arr));
                return \Redirect::back();
            }
        }
        
        /*else
        {
            Session::flash('error', "Error! Please upload .csv");
            return \Redirect::back(); 
        }*/
        /*$modem = $this->common_db->modem->find(['swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED']);
        $modem = iterator_to_array($modem);

        $sim = $this->common_db->bsnl_sim->find(['swh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED']);
        $sim = iterator_to_array($sim);*/

        if(isset($_FILES["simfile"]['tmp_name'])  && !empty($_FILES["simfile"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['simfile']['tmp_name'], 'r+');               
          
            $match_found_sim = $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                //dd(\Session::get('_id'));
                $sim = \DB::table('bsnl_sim')->where(['sim_no'=>$row[0],'swh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'])->get();

                if(empty($sim))
                {
                    Session::flash('error', "Sim Not Found in EDF Pool!");
                    return \Redirect::back();
                }
                foreach ($sim as $key => $value) 
                {
                    if(!empty($value))
                    {
                        foreach ($value['_id'] as $key1 => $value1) 
                        {
                            array_push($temp1,$value1);
                        }
                        $match_found_sim++;
                    }
                }

                $i++;
            }
            $total_bsnl_sim_count = $i;
        }
        if(isset($_FILES["modemfile"]['tmp_name'])  && !empty($_FILES["modemfile"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['modemfile']['tmp_name'], 'r+');               
          
            $match_found_modem = $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                $modem = \DB::table('modem')->where(['modem_number'=>$row[0],'swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'])->get();
                if(empty($modem))
                {
                    Session::flash('error', "Modem Not Found in EDF Pool!");
                    return \Redirect::back();
                }
                foreach ($modem as $key => $value) 
                {
                    if(!empty($value))
                    {
                        foreach ($value['_id'] as $key1 => $value1) 
                        {
                            array_push($temp2,$value1);
                        }
                        $match_found_modem++;
                    }
                }
                $i++;
            }
            $total_modem_count = $i;
        }

          $validation_sim_qty                = $mrn_details['sim_qty'];
        $validation_modem_qty              = $mrn_details['modem_qty'];
        $validation_three_phase_meter_qty  = $mrn_details['three_phase_meter_qty'];
        $validation_single_phase_meter_qty = $mrn_details['single_phase_meter_qty'];
        $validation_total_meter            = $validation_three_phase_meter_qty+$validation_single_phase_meter_qty;
        
        if($validation_total_meter>0)
        {
            /*if($validation_single_phase_meter_qty>=$count_1phase)
            {
                Session::flash('error', "Error! Please upload 1 phase Meter:".$validation_single_phase_meter_qty);
                return \Redirect::back();
            }

            if($validation_three_phase_meter_qty>=$count_3phase)
            {
                Session::flash('error', "Error! Please upload 3 phase Meter:".$validation_three_phase_meter_qty);
                return \Redirect::back();

            }*/
            if($validation_total_meter!=$match_found_meter && $validation_total_meter<=$match_found_meter)
            {
                Session::flash('error', "Uploaded meter quantity is exceeded that MRN Request!");
                return \Redirect::back();

            }
        }
       
        if($validation_sim_qty>0)
        {
            if($validation_sim_qty!=$match_found_sim && $validation_sim_qty<=$match_found_sim)
            {
                Session::flash('error', "Uploaded sim quantity is exceeded that MRN Request!");
                return \Redirect::back(); 
            }
        }
        if($validation_modem_qty>0)
        {
            if($validation_modem_qty!=$match_found_modem && $validation_modem_qty<=$match_found_modem)
            {
                Session::flash('error', "Uploaded modem quantity is exceeded that MRN Request!:");
                return \Redirect::back(); 
            }
        }

        /*foreach ($request->input('obi_id') as $key => $value) 
        {
            $meter_details = $this->common_db->meter->find(['_id'=>new MongoId($value)]);
            $meter_details = iterator_to_array($meter_details);
            if(!empty($meter_details))
            {
                if($meter_details[$value]['phase_type']=='1 Phase')
                {
                    $count_1phase++;
                }
                elseif($meter_details[$value]['phase_type']=='3 Phase')
                {
                    $count_3phase++;

                }
            }
        }*/


        $count_1phase_balance = (empty($mrn_details['single_phase_meter_qty']))? 0: $mrn_details['single_phase_meter_qty']-$count_1phase;
        $count_3phase_balance = (empty($mrn_details['three_phase_meter_qty']))? 0: $mrn_details['three_phase_meter_qty']-$count_3phase;
        $count_bsnl_sim_balance       = (empty($mrn_details['sim_qty']))? 0: $mrn_details['sim_qty']-$match_found_sim;
        $count_modem_balance          = (empty($mrn_details['modem_qty']))? 0: $mrn_details['modem_qty']-$match_found_modem;

       


        $meter_ids_list               = json_encode($temp);
        $data['mrn_id']               = $request->input('mrn');
        $data['mrn_details']          = $mrn_details;
        $data['match_found_meter']    = $match_found_meter;
        $data['total_upload_meter']   = $total_upload_meter;
        $data['count_1phase']         = $count_1phase;
        $data['count_3phase']         = $count_3phase;
        $data['count_1phase_balance'] = $count_1phase_balance;
        $data['count_3phase_balance'] = $count_3phase_balance;
        $data['meter_ids_list']       = $meter_ids_list;
        $data['swh']                  = $swh;
        $data['upload_sim_total']     = $total_bsnl_sim_count;
        $data['match_found_sim']      = $match_found_sim;
        $data['sim_ids_list']         = json_encode($temp1);
        $data['upload_modem_total']   = $total_modem_count;

        $data['count_bsnl_sim_balance']   = $count_bsnl_sim_balance;
        $data['count_modem_balance']   = $count_modem_balance;

        $data['match_found_modem']    = $match_found_modem;
        $data['modem_ids_list']       = json_encode($temp2);
        $data['page_name']            = "Add";
        $data['title']                = $this->title;
        $data['url_slug']             = $this->url_slug;
        return view($this->folder_path.'swh_add',$data);
    }

    public function swh_form_dispatch_meter_step_2(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'to_dispatch'          => 'required',
                'dispatch_mode'        => 'required',
            ]);
        
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $cursor     = \DB::table('mrn')->where(['_id' => new MongoId($request->input('mrn_id'))])->first();
        
        if(empty($cursor))
        {
            Session::flash('error', "Please Select valid MRN No.");
            return \Redirect::back();
        }
        if(empty($request->input('meter_ids_list')))
        {
            Session::flash('error', "Please Select Meters to process.");
            return \Redirect::back();
        }
        
        $count_1phase = $count_3phase = $count_1phase_balance = $count_3phase_balance = 0;
        foreach (json_decode($request->input('meter_ids_list')) as $key => $value) 
        {
                $__id__temp = '';
                if(!empty($value))
                {
                    // print_r($value);
                    // echo "<br>--";
                    if($key==1){}
                    foreach ($value as $key1 => $value1) {
                        $__id__temp = $value1;
                    }
                }
                $meter_details = \DB::table('meter')->where(['_id'=>new MongoId($__id__temp)])->first();
                if(!empty($meter_details))
                {
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


        $count_1phase_balance = (empty($mrn_details['single_phase_meter_qty']))? 0: $mrn_details['single_phase_meter_qty']-$count_1phase;
        $count_3phase_balance = (empty($mrn_details['three_phase_meter_qty']))? 0: $mrn_details['three_phase_meter_qty']-$count_3phase;

        $single_phase_meter_qty_issued = $count_1phase;
        $three_phase_meter_qty_issued  = $count_3phase;
        $single_balance_to_issued      = $count_1phase_balance;
        $three_balance_to_issued       = $count_3phase_balance;
        //$total_meter_qty               = $single_phase_meter_qty_issued + $three_phase_meter_qty_issued;
        $cursor_parameter_list         = $cursor;

        $cursor                        = \DB::table('mrn')->get();
        $count                         = $cursor->count()+1;
        $mrn_ref                       = $cursor_parameter_list['vmwh_mrn_ref'];
        $dl_ch_ref                     = $cursor_parameter_list['vmwh_dl_ch_ref'];//'EDF/BHR/EESL/'.date('d').'-'.date('Y').'-'.$count;
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString     = '';

        for ($i = 0; $i < 18; $i++) 
        {
            $randomString    .= $characters[rand(0, $charactersLength - 1)];
        }
        $latest_image = '';
        if(isset($_FILES["lr_copy"]["name"]) && !empty($_FILES["lr_copy"]["name"]))
        {
            $file_name        = $_FILES["lr_copy"]["name"];
            $file_tmp         = $_FILES["lr_copy"]["tmp_name"];
            $ext              = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name = $randomString.'0.'.$ext;
            $latest_image     = '/upload/lr_copy/'.$random_file_name;
            if(!move_uploaded_file($file_tmp,base_path().$latest_image)){ /*no action*/ }
        }
        $new_data                      = ["single_comment" => $request->input('single_comment'),
                            "three_comment"                 => $request->input('three_comment'),
                            "single_phase_meter_qty_issued" => $single_phase_meter_qty_issued,
                            "three_phase_meter_qty_issued"  => $three_phase_meter_qty_issued,
                            "single_balance_to_issued"      => (string)$single_balance_to_issued,
                            "three_balance_to_issued"       => (string)$three_balance_to_issued,
                            "to_dispatch"                   => $request->input('to_dispatch'),
                            "dispatch_mode"                 => $request->input('dispatch_mode'),
                            "name_of_pickup_person"         => $request->input('name_of_pickup_person'),
                            "mobile_no_pickup_person"       => $request->input('mobile_no_pickup_person'),
                            "lr_no"                         => $request->input('lr_no'),
                            "lr_copy"                       => $latest_image,
                            "transport_name"                => $request->input('transport_name'),
                            "driver_name"                   => $request->input('driver_name'),
                            "driver_mobile_no"              => $request->input('driver_mobile_no'),
                            "sim_qty_issued"                => $request->input('match_found_sim'),
                            "modem_phase_meter_qty_issued"  => $request->input('match_found_modem'),
                            "seal_phase_meter_qty_issued"   => $request->input('seal_qty'),
                            "sim_balance_to_issued"         => $request->input('count_bsnl_sim_balance'),
                            "modem_balance_to_issued"       => $request->input('count_modem_balance'),

                            "grn_no"                        => $count,
                            "vmwh_dl_ch_ref"                     => $dl_ch_ref,
                            "vmwh_dispatch_processing_date"      => date('d-m-Y'),
                            "vmwh_dispatch_processing_time"      => date('h:i:s A'),
                            "is_delivery_challan"           => 'Yes',
                            "vmwh_status"                   => 'Dispatch Process',
                            "vmwh_delivery_status"          => 'Dispatch Process',
                            "swh"                           => \Session::get('_id'),
                            "from_address"                  => \Session::get('warehouse_address'),
                            "vmwh_dispatch_created_time"    => time(),
                            "delivery_date"                 => '',
                            "delivery_time"                 => '',
                            "delivery_accepted_time"        => '',
                            "single_phase_meter_price"      => '',
                            "three_phase_meter_price"       => '',
                            "grand_total"                   => '',
                     ];
                     
        $responce  = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('mrn_id'))])->update($new_data);
        if(!empty($request->input('meter_ids_list')))
        {
            foreach (json_decode($request->input('meter_ids_list')) as $key => $value) 
            {
                $__id__temp_ = '';
                if(!empty($value))
                {
                    //print_r($value);
                    //echo "<br>--";
                    if($key==1){ }
                    foreach ($value as $key1 => $value1) {
                        $__id__temp_ = $value1;
                    }
                }
                $new_data  =  [
                                    "vmwh" => $cursor_parameter_list['vmwh'],
                                    "vmwh_mrn_ref" => $mrn_ref,
                                    "vmwh_dl_ch_ref" => $dl_ch_ref,
                                    "swh_inventory_status" => 'AssignedToVM',
                                    "vendor_dispatch_date" => date('Y-m-d'),
                                     "current_meter_status" => 'Pending MRN Acceptance in VP warehouse'
                                ];
                                
                $responce  = \DB::table('meter')->where(['_id'=>new MongoId($__id__temp_)])->update($new_data);
            }
        }
        
        if(!empty($request->input('seal_qty')))
        {
            $new_data                     = [];
            $new_data['new_stock']         = '-'.$request->input('seal_qty');
            $new_data['date']              = date('d-m-Y h:i:s');
            $new_data['vmwh_mrn_ref']      = $mrn_ref;
            $new_data['vmwh_dl_ch_ref']    = $dl_ch_ref;
            $responce = \DB::table('seal_stock')->insert($new_data);
        }
        if(!empty($request->input('sim_ids_list')))
        {
            foreach (json_decode($request->input('sim_ids_list')) as $key => $value) 
            {
                $new_data  =  [
                                    "vmwh_mrn_ref" => $mrn_ref,
                                    "vmwh_dl_ch_ref" => $dl_ch_ref,
                                    "swh_inventory_status" => 'AssignedToVM',
                                     ];
                $responce  = \DB::table('bsnl_sim')->where(['_id'=>new MongoId($value)])->update($new_data);
                
            }
        }
        if(!empty($request->input('modem_ids_list')))
        {
            foreach (json_decode($request->input('modem_ids_list')) as $key => $value) 
            {
                $new_data  =  [
                                    "vmwh_mrn_ref" => $mrn_ref,
                                    "vmwh_dl_ch_ref" => $dl_ch_ref,
                                    "swh_inventory_status" => 'AssignedToVM',
                                     ];
                $responce  = \DB::table('modem')->where(['_id'=>new MongoId($value)])->update($new_data);
            }
        }
        
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('swh_edf_meter_pool');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'username'          => 'required',
                'role'              => 'required',
                'password'          => 'required',
                'confimed_password' => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $option     = ['username'=>$request->input('username')];
        $cursor     = $this->common_collection->find($option);
        $total      = 0;//$cursor->count();
      
        if($total)
        {
            Session::flash('error', "Email(Username) already exist!");
            return \Redirect::back();
        }

        $new_data               = [];
        $new_data['username']   = $request->input('username');
        $new_data['role']       = $request->input('role');
        $new_data['password']   = $request->input('password');
        $new_data['is_delete']  = "0";

        $responce = $this->common_collection->insert($new_data);
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_'.$this->url_slug);
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function view_grn_dispatch($id)
    {
        $cursor     = \DB::table('mrn')->where(['_id'=>new MongoId($id)])->first();
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
        return view($this->folder_path.'view_grn_dispatch',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf');
    }

    public function vmwh_view_grn_dispatch($id)
    {
        $cursor     = \DB::table('mrn')->where(['_id'=>new MongoId($id)])->first();
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
        return view($this->folder_path.'vmwh_view_grn_dispatch',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf');
    }

    public function view_dispatch($id)
    {
        $cursor     = \DB::table('mrn')->where(['_id'=>new MongoId($id)])->first();
        if(empty($cursor))
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $cursor = $cursor;
        $data = [];
        $data['data'] = $cursor;
        $data['id'] = $id;
        /*PDF::SetTitle($cursor['dl_ch_ref']);
        PDF::AddPage('P','A4');
        PDF::writeHTML(view($this->folder_path.'dl_ch_pdf',$data)->render(), true, false, true, false, '');
        PDF::Output('hello_world.pdf');*/
        $pdf = PDF::loadView($this->folder_path.'dl_ch_pdf',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf');
       // $pdf = PDF::loadView($this->folder_path.'dl_ch_pdf',$data);
       // $pdf->save(base_path().'/upload/temp_pdf/'.$id.'.pdf');
        die;
        $data['data']      = iterator_to_array($cursor);
        $data['id']        = $id;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function vmwh_view_dispatch($id)
    {
        
        $cursor     = \DB::table('mrn')->where(['_id'=>new MongoId($id)])->first();
        if(empty($cursor))
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $cursor = $cursor;
        $data = [];
        $data['data'] = $cursor;
        $data['id'] = $id;
        /*PDF::SetTitle($cursor['dl_ch_ref']);
        PDF::AddPage('P','A4');
        PDF::writeHTML(view($this->folder_path.'dl_ch_pdf',$data)->render(), true, false, true, false, '');
        PDF::Output('hello_world.pdf');*/
        $pdf = PDF::loadView($this->folder_path.'vmwh_dl_ch_pdf',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf');
       // $pdf = PDF::loadView($this->folder_path.'dl_ch_pdf',$data);
       // $pdf->save(base_path().'/upload/temp_pdf/'.$id.'.pdf');
        die;
        $data['data']      = iterator_to_array($cursor);
        $data['id']        = $id;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function edit($id)
    {
        $option     = ['_id'=>new MongoId($id)];
        $cursor     = $this->common_collection->find($option);
        $total      = 0;//$cursor->count();
        
        if(!$total)
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = iterator_to_array($cursor);
        $data['id']        = $id;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'username'          => 'required',
                'role'              => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $condition  = [
                        '_id' => ['$ne'=>new MongoId($id)],
                        'username'=>$request->input('username')
                      ];
        $cursor     = $this->common_collection->find($condition);
        $total      = 0;//$cursor->count();
      
        if($total)
        {
            Session::flash('error', "Email(Username) already exist!");
            return \Redirect::back();
        }

        $condition = ['_id'=>new MongoId($id)];
        $new_data  = [
                        '$set' => ["username" => $request->input('username')],
                        '$set' => ["role" => $request->input('role')]
                     ];
        $responce  = $this->common_collection->update($condition,$new_data);
        
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('manage_'.$this->url_slug);
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function delete($id)
    {
        $condition = ['_id'  => new MongoId($id)];
        $new_data  = ['$set' => ["is_delete" => '1']];
        $responce  = $this->common_collection->update($condition,$new_data);
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
