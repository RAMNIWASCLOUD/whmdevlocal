<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use PDF;
use \MongoDB\BSON\ObjectID as MongoId;

class MrnnewController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        /* $this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db         = $this->common_connection->whm;
        $this->common_collection = $this->common_db->mrn;*/
        $this->title             = "MRN";
        $this->url_slug          = "mrn";
        $this->folder_path       = "admin/mrn/";
    }

    public function new_vm_mrn()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' =>$_GET['search'],'vmwh_delivery_status'=>'Pending','vmwh'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['vmwh_delivery_status'=>'Pending','vmwh'=>new MongoId(\Session::get('_id'))]);

        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit); 
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "New";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'new_vm_mrn',$data);
    }

    public function recived_vm_mrn()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' =>$_GET['search'],'vmwh_status'=>'Dispatch Process','vmwh'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['vmwh_status'=>'Dispatch Process','vmwh'=>new MongoId(\Session::get('_id'))]);

        }

        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit); 
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "Received";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'recived_vm_mrn',$data);
    }
 
    public function add_vm_mrn()
    {
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add_vm_mrn',$data);
    }

    public function store_vm_mrn(Request $request)
    {
        $validator     = Validator::make($request->all(), [
                    'kind_attn'    => 'required',
                    'mobile_no'    => 'required',
                    'location'     => 'required',
                    'telephone_1'  => 'required',
                    'site_address' => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        
        $cursor     = \DB::table('mrn')->get();
        $count      = $cursor->count()+1;

        $new_data                                  = [];
        $new_data['vmwh_mrn_ref']                  = 'BH/APN/'.date('Y').'/'.$count;
        $new_data['mrn_ref']                       = '';
        $new_data['kind_attn']                     = $request->input('kind_attn');
        $new_data['mobile_no']                     = $request->input('mobile_no');
        $new_data['location']                      = $request->input('location');
        $new_data['telephone_1']                   = $request->input('telephone_1');
        $new_data['telephone_2']                   = $request->input('telephone_2');
        $new_data['site_address']                  = $request->input('site_address');
        $new_data['single_phase_meter_qty']        = $request->input('single_phase_meter_qty');
        $new_data['three_phase_meter_qty']         = $request->input('three_phase_meter_qty');
        $new_data['sim_qty']                       = $request->input('sim_qty');
        $new_data['modem_qty']                     = $request->input('modem_qty');
        $new_data['seal_qty']                      = $request->input('seal_qty');
        $new_data['category']                      = $request->input('category');
        $new_data['other']                      = $request->input('other');
        $new_data['single_phase_meter_qty_issued'] = '';
        $new_data['three_phase_meter_qty_issued']  = '';
        $new_data['sim_qty_issued']                = '';
        $new_data['modem_phase_meter_qty_issued']  = '';
        $new_data['seal_phase_meter_qty_issued']   = '';
        $new_data['single_balance_to_issued']      = '';
        $new_data['three_balance_to_issued']       = '';
        $new_data['sim_balance_to_issued']         = '';
        $new_data['modem_balance_to_issued']       = '';
        $new_data['seal_balance_to_issued']        = '';
        $new_data['single_comment']                = '';
        $new_data['three_comment']                 = '';
        $new_data['sim_comment']                   = '';
        $new_data['modem_comment']                 = '';
        $new_data['seal_comment']                  = '';
        $new_data['status']                        = 'Pending';
        $new_data['swh']                           = \Session::get('parent_sw');
        $new_data['vmwh']                          = \Session::get('_id');
        $new_data['added_by']                      = \Session::get('role');
        $new_data['mrn_processing_date']           = date('d-m-Y');
        $new_data['mrn_processing_time']           = date('h:i:s A');
        $new_data['delivery_date']                 = '';
        $new_data['delivery_time']                 = '';
        $new_data['created_time']                  = time();

        $new_data['dl_ch_ref']                     = '';
        $new_data['vmwh_dl_ch_ref']                = 'EDF/BHR/EESL/'.date('Y').'-'.$count;
        $new_data['dispatch_processing_date']      = '';
        $new_data['dispatch_processing_time']      = '';
        $new_data['is_delivery_challan']           = 'No';
        $new_data['delivery_status']               = 'Pending';
        $new_data['wh']                            = '';
        $new_data['from_address']                  = '';
        $new_data['to_address']                    = \Session::get('warehouse_address');
        $new_data['dispatch_created_time']         = '';
        $new_data['delivery_date']                 = '';
        $new_data['delivery_time']                 = '';
        $new_data['delivery_accepted_time']        = '';
        $new_data['single_phase_meter_price']      = '';
        $new_data['three_phase_meter_price']       = '';
        $new_data['grand_total']                   = '';
        $new_data['to_dispatch']                   = \Session::get('_id');
        $new_data['dispatch_mode']                 = '';
        $new_data['name_of_pickup_person']         = '';
        $new_data['mobile_no_pickup_perso`n']      = '';
        $new_data['lr_no']                         = '';
        $new_data['lr_copy']                       = '';
        $new_data['transport_name']                = '';
        $new_data['driver_name']                   = '';
        $new_data['driver_mobile_no']              = '';
        $new_data['delivery_proof']                = '';
        $new_data['delivery_reject_reason']        = '';
        $new_data['utility']                       = \Session::get('utility');
        $new_data['vmwh_delivery_status']          = 'Pending';
        $new_data['vmwh_delivery_proof']           = '';
        $new_data['vmwh_delivery_date']            = '';
        $new_data['vmwh_delivery_time']            = '';
        $new_data['vmwh_delivery_accepted_time']   = '';
        $new_data['vmwh_dispatch_processing_date'] = '';
        $new_data['vmwh_dispatch_processing_time'] = '';
        $new_data['vmwh_dispatch_created_time']    = '';
        
        $new_data['mrn_authorized_1']               = '';
        $new_data['mrn_authorized_1_status']        = 'Pending';
        $new_data['mrn_authorized_1_update_time']   = '';
        $new_data['mrn_authorized_1_reject_reason'] = '';
        $new_data['mrn_authorized_2']               = '';
        $new_data['mrn_authorized_2_status']        = 'Pending';
        $new_data['mrn_authorized_2_update_time']   = '';
        $new_data['mrn_authorized_2_reject_reason'] = '';


        $cursor     = \DB::table('login_users')->where(['utility'=>\Session::get('utility'),'role'=>'5'])->first();
        $user_details      = $cursor;
        
        if(!empty($user_details))
        {
            /*$new_data['mrn_authorized_1']               = new MongoId($user_details['mrn_authorized_1']);
            $new_data['mrn_authorized_1_status']        = 'Pending';
            $new_data['mrn_authorized_1_update_time']   = '';
            $new_data['mrn_authorized_1_reject_reason'] = '';*/
            $new_data['mrn_authorized_2']               = new MongoId($user_details['_id']);
            $new_data['mrn_authorized_2_status']        = 'Pending';
            $new_data['mrn_authorized_2_update_time']   = '';
            $new_data['mrn_authorized_2_reject_reason'] = '';
            

        		$email = $user_details['username']; 	
        	
        	$headers2 = "Content-Type: text/html; charset=ISO-8859-1\r\n";
            //$headers2 .= "From: care@test.com". $from."\r\nReply-To: care@test.com\r\n";
            $headers2 .= "Cc: ba2.hoh@gmail.com";
            $message2="Dear Administrator,<br>

			You have received a new MRN Request. Please find the attachment for the MRN Copy.<br>

			Thanks,<br>
			Team EDF WHM";
            //mail($email,'New MRN added',$message2,$headers2);
        }
        




        $responce = \DB::table('mrn')->insert($new_data);
        //$this->common_connection->close();
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('new_vm_mrn');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function update_mrn_a_1_mrn(Request $request,$id)
    {
        $validator     = Validator::make($request->all(), [
                    'kind_attn'    => 'required',
                    'mobile_no'    => 'required',
                    'location'     => 'required',
                    'telephone_1'  => 'required',
                    'site_address' => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        
        
        $new_data                                  = [];
        $new_data['kind_attn']                     = $request->input('kind_attn');
        $new_data['mobile_no']                     = $request->input('mobile_no');
        $new_data['location']                      = $request->input('location');
        $new_data['telephone_1']                   = $request->input('telephone_1');
        $new_data['telephone_2']                   = $request->input('telephone_2');
        $new_data['site_address']                  = $request->input('site_address');
        $new_data['single_phase_meter_qty']        = $request->input('single_phase_meter_qty');
        $new_data['three_phase_meter_qty']         = $request->input('three_phase_meter_qty');
        $new_data['sim_qty']                       = $request->input('sim_qty');
        $new_data['modem_qty']                     = $request->input('modem_qty');
        $new_data['seal_qty']                      = $request->input('seal_qty');
       




        $responce = \DB::table('mrn')->where(['_id'=>new MongoId($id)])->update($new_data);
        //$this->common_connection->close();
            Session::flash('success', 'Success! Record updated successfully.');
            
            if(\Session::get('role')=='4')
            {
                return \Redirect::to('mrn_a_1_pending');
            }
            else
            {
                return \Redirect::to('mrn_a_2_pending');
            }
        
    }


    public function status_update_mrn_a_1(Request $request)
    {
        
        $new_data                                   = [];
        $new_data['mrn_authorized_1_status']        = $request->input('status');
        $new_data['mrn_authorized_1_update_time']   = date('Y-m-d h:i:s');
        $new_data['mrn_authorized_1_reject_reason'] = $request->input('reason');

        $responce = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('mrn_id'))])->update($new_data);
        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('mrn_a_1_pending');
    }

    public function status_update_mrn_a_2(Request $request)
    {
        
        $new_data                                   = [];
        $new_data['mrn_authorized_1_status']        = $request->input('status');
        $new_data['mrn_authorized_1_update_time']   = date('Y-m-d h:i:s');
        $new_data['mrn_authorized_1_reject_reason'] = $request->input('reason');
        $new_data['mrn_authorized_2_status']        = $request->input('status');
        $new_data['mrn_authorized_2_update_time']   = date('Y-m-d h:i:s');
        $new_data['mrn_authorized_2_reject_reason'] = $request->input('reason');

        $responce = \DB::table('mrn')->where(['_id'=>new MongoId($request->input('mrn_id'))])->update($new_data);
        Session::flash('success', 'Success! Record updated successfully.');
        return \Redirect::to('mrn_a_2_pending');
    }


    public function new_swh_mrn()
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
            $cursor = $cursor->where(['mrn_ref' => $_GET['search'],'status'=>'Pending','vmwh_mrn_ref'=>'','swh'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['status'=>'Pending','vmwh_mrn_ref'=>'','swh'=>new MongoId(\Session::get('_id'))]);

        }
        
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "New";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'new_swh_mrn',$data);
    }

    public function recived_wh_mrn()
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
            if(!empty($_GET['search']))
            {
                $cursor = $cursor->orwhere(['mrn_ref'=>$_GET['search']])->orwhere(['vmwh_mrn_ref'=>$_GET['search']]);
            }
            if(!empty($_GET['location']))
            {
                $cursor = $cursor->where(['location'=>$_GET['location']]);
            }
            if(!empty($_GET['kind_attn']))
            {
                $cursor = $cursor->where(['kind_attn'=>$_GET['kind_attn']]);
            }

        }
        
       
        $total      = 0;//$cursor->count();
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;

        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "All";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'recived_wh_mrn',$data);
    }

    public function recived_swh_mrn()
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
            $cursor = $cursor->where('vmwh_mrn_ref','!=','')->where(['vmwh_mrn_ref' =>$_GET['search'],'mrn_authorized_2_status'=>'Approve',/*'status'=>'Pending',*/'swh'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where('vmwh_mrn_ref','!=','')->where(['mrn_authorized_2_status'=>'Approve',/*'status'=>'Pending',*/'swh'=>new MongoId(\Session::get('_id'))]);
        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Received By VM';
        return view($this->folder_path.'recived_swh_mrn',$data);
    }

    public function mrn_a_1_pending()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' => $_GET['search'],'mrn_authorized_1_status'=>'Pending','mrn_authorized_1'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['mrn_authorized_1_status'=>'Pending','mrn_authorized_1'=>\Session::get('_id')]);
        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Pending MRN';
        return view($this->folder_path.'mrn_a_1_pending',$data);
    }

    public function mrn_a_1_approved()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' => $_GET['search'],'mrn_authorized_1_status'=>'Approve','mrn_authorized_1'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['mrn_authorized_1_status'=>'Approve','mrn_authorized_1'=>new MongoId(\Session::get('_id'))]);
        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Approved MRN';
        return view($this->folder_path.'mrn_a_1_approved',$data);
    }

    public function mrn_a_1_rejected()
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
            $cursor = $cursor->where(['vmwh_mrn_ref'=>$_GET['search'],'mrn_authorized_1_status'=>'Reject','mrn_authorized_1'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['mrn_authorized_1_status'=>'Reject','mrn_authorized_1'=>\Session::get('_id')]);
        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Rejected MRN';
        return view($this->folder_path.'mrn_a_1_rejected',$data);
    }

    public function mrn_a_2_pending_from1()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' => $_GET['search'],'mrn_authorized_1_status'=>'Pending','mrn_authorized_2'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['mrn_authorized_1_status'=>'Pending','mrn_authorized_2'=>\Session::get('_id')]);
        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Pending MRN(From MRN Authority 1)';
        return view($this->folder_path.'mrn_a_2_pending_from1',$data);
    }

    public function mrn_a_2_pending()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' => $_GET['search'],/*'mrn_authorized_1_status'=>'Approve',*/'mrn_authorized_2_status'=>'Pending','mrn_authorized_2'=>new MongoId(\Session::get('_id'))])/*->orwhere(['vmwh_mrn_ref' => $_GET['search'],'mrn_authorized_1_status'=>'Pending','mrn_authorized_1'=>new MongoId(\Session::get('_id'))])*/;
        }
        else
        {
            $cursor = $cursor->where([/*'mrn_authorized_1_status'=>'Approve',*/'mrn_authorized_2_status'=>'Pending','mrn_authorized_2'=>\Session::get('_id')])/*->orwhere(['mrn_authorized_1_status'=>'Pending','mrn_authorized_1'=>\Session::get('_id')])*/;
        }
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Pending MRN';
        return view($this->folder_path.'mrn_a_2_pending',$data);
    }

    public function mrn_a_2_approved()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' => $_GET['search'],'mrn_authorized_1_status'=>'Approve','mrn_authorized_2_status'=>'Approve','mrn_authorized_2'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['mrn_authorized_1_status'=>'Approve','mrn_authorized_2_status'=>'Approve','mrn_authorized_2'=>\Session::get('_id')]);
        }
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Approved MRN';
        return view($this->folder_path.'mrn_a_2_approved',$data);
    }

    public function mrn_a_2_rejected()
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
            $cursor = $cursor->where(['vmwh_mrn_ref' => $_GET['search'],'mrn_authorized_1_status'=>'Approve','mrn_authorized_2_status'=>'Reject','mrn_authorized_2'=>new MongoId(\Session::get('_id'))]);
        }
        else
        {
            $cursor = $cursor->where(['mrn_authorized_1_status'=>'Approve','mrn_authorized_2_status'=>'Reject','mrn_authorized_2'=>\Session::get('_id')]);
        }
       
       
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        
        $total      = 0;//$cursor->count();
        
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "MRN";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Rejected MRN';
        return view($this->folder_path.'mrn_a_2_rejected',$data);
    }
 
    public function add_swh_mrn()
    {
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add_swh_mrn',$data);
    }

    public function store_swh_mrn(Request $request)
    {
        $validator     = Validator::make($request->all(), [
                    'kind_attn'    => 'required',
                    'mobile_no'    => 'required',
                    'location'     => 'required',
                    'telephone_1'  => 'required',
                    'site_address' => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        
        $cursor     = \DB::table('mrn')->get();
        $count      = $cursor->count()+1;

        $new_data                                  = [];
        $new_data['mrn_ref']                       = 'BH/CET/'.date('Y').'/'.$count;
        $new_data['kind_attn']                     = $request->input('kind_attn');
        $new_data['mobile_no']                     = $request->input('mobile_no');
        $new_data['location']                      = $request->input('location');
        $new_data['telephone_1']                   = $request->input('telephone_1');
        $new_data['telephone_2']                   = $request->input('telephone_2');
        $new_data['site_address']                  = $request->input('site_address');
        $new_data['single_phase_meter_qty']        = $request->input('single_phase_meter_qty');
        $new_data['three_phase_meter_qty']         = $request->input('three_phase_meter_qty');
        $new_data['sim_qty']                       = $request->input('sim_qty');
        $new_data['modem_qty']                     = $request->input('modem_qty');
        $new_data['seal_qty']                      = $request->input('seal_qty');
        $new_data['category']                      = $request->input('category');
        $new_data['other']                      = $request->input('other');
        $new_data['single_phase_meter_qty_issued'] = '';
        $new_data['three_phase_meter_qty_issued']  = '';
        $new_data['sim_qty_issued']                = '';
        $new_data['modem_phase_meter_qty_issued']  = '';
        $new_data['seal_phase_meter_qty_issued']   = '';
        $new_data['single_balance_to_issued']      = '';
        $new_data['three_balance_to_issued']       = '';
        $new_data['sim_balance_to_issued']         = '';
        $new_data['modem_balance_to_issued']       = '';
        $new_data['seal_balance_to_issued']        = '';
        $new_data['single_comment']                = '';
        $new_data['three_comment']                 = '';
        $new_data['sim_comment']                   = '';
        $new_data['modem_comment']                 = '';
        $new_data['seal_comment']                  = '';
        $new_data['status']                        = 'Pending';
        $new_data['swh']                           = \Session::get('_id');
        $new_data['vmwh']                          = '';
        $new_data['added_by']                      = \Session::get('role');
        $new_data['mrn_processing_date']           = date('d-m-Y');
        $new_data['mrn_processing_time']           = date('h:i:s A');
        $new_data['delivery_date']                 = '';
        $new_data['delivery_time']                 = '';
        $new_data['created_time']                  = time();

        $new_data['grn_no']                        = $count;
        $new_data['utility']                       = \Session::get('utility');
        $new_data['vmwh_mrn_ref']                  = '';
        $new_data['vmwh_dl_ch_ref']                = '';
        $new_data['dl_ch_ref']                     = 'EDF/BHR/EESL/'.date('Y').'-'.$count;
        $new_data['dispatch_processing_date']      = '';
        $new_data['dispatch_processing_time']      = '';
        $new_data['is_delivery_challan']           = 'No';
        $new_data['delivery_status']               = 'Pending';
        $new_data['wh']                            = '';
        $new_data['from_address']                  = '';
        $new_data['to_address']                    = \Session::get('warehouse_address');
        $new_data['dispatch_created_time']         = '';
        $new_data['delivery_date']                 = '';
        $new_data['delivery_time']                 = '';
        $new_data['delivery_accepted_time']        = '';
        $new_data['single_phase_meter_price']      = '';
        $new_data['three_phase_meter_price']       = '';
        $new_data['grand_total']                   = '';
        $new_data['to_dispatch']                   = \Session::get('_id');;
        $new_data['dispatch_mode']                 = '';
        $new_data['name_of_pickup_person']         = '';
        $new_data['mobile_no_pickup_person']       = '';
        $new_data['lr_copy']                       = '';
        $new_data['lr_no']                         = '';
        $new_data['transport_name']                = '';
        $new_data['driver_name']                   = '';
        $new_data['driver_mobile_no']              = '';
        $new_data['delivery_proof']                = '';
        $new_data['delivery_reject_reason']        = '';
        $new_data['vmwh_delivery_status']          = '';
        $new_data['vmwh_delivery_proof']           = '';
        $new_data['vmwh_delivery_date']            = '';
        $new_data['vmwh_delivery_time']            = '';
        $new_data['vmwh_delivery_accepted_time']   = '';
        $new_data['vmwh_dispatch_processing_date'] = '';
        $new_data['vmwh_dispatch_processing_time'] = '';
        $new_data['vmwh_dispatch_created_time']    = '';



        $cursor     = \DB::table('login_users')->where(['_id'=>new MongoId(\Session::get('_id'))])->first();
        $user_details      = $cursor;
        if(!empty($user_details))
        {
            

            $email = $user_details['username']; 	
			
        	$headers2 = "Content-Type: text/html; charset=ISO-8859-1\r\n";
            //$headers2 .= "From: care@test.com". $from."\r\nReply-To: care@test.com\r\n";
            $headers2 .= "Cc: ba2.hoh@gmail.com";
            $message2="Dear Administrator,<br>

			You have received a new MRN Request. Please find the attachment for the MRN Copy.<br>

			Thanks,<br>
			Team EDF WHM";
            //mail($email,'New MRN added',$message2,$headers2);
        }
        
       
       
        $responce = \DB::table('mrn')->insert($new_data);
        //$this->common_connection->close();
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('new_swh_mrn');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function view_swh_mrn($id)
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
        /*PDF::SetTitle($cursor['mrn_ref']);
        PDF::AddPage('L','A4');
        PDF::writeHTML(view($this->folder_path.'mrn_pdf',$data)->render(), true, false, true, false, '');*/
        //PDF::Output('hello_world.pdf');
        $pdf = PDF::loadView($this->folder_path.'mrn_pdf',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf');  
        
        //$pdf = PDF::loadView($this->folder_path.'mrn_pdf',$data);
        //$pdf->save(base_path().'/upload/temp_pdf/'.$id.'.pdf');
    }

    public function view_vmwh_mrn($id)
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
       /* PDF::SetTitle($cursor['mrn_ref']);
        PDF::AddPage('L','A4');
        PDF::writeHTML(view($this->folder_path.'vmwh_mrn_pdf',$data)->render(), true, false, true, false, '');
        PDF::Output('hello_world.pdf');
        $pdf = PDF::loadView($this->folder_path.'vmwh_mrn_pdf',$data);
        $pdf->save(base_path().'/upload/temp_pdf/'.$id.'.pdf');*/
        
        $pdf = \PDF::loadView($this->folder_path.'vmwh_mrn_pdf',$data);
        return $pdf->setPaper('a4', 'landscape')->download($id.'.pdf'); 
    }

    public function edit($id)
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
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function edit_vm_mrn($id)
    {
        $cursor     = \DB::table('mrn')->where(['_id'=>new MongoId($id)])->first();
        
        if(empty($cursor))
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = $cursor;
        $data['id']        = $id;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit_vm_mrn',$data);
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
                        '_id' => ['$ne'=>new \MongoId($id)],
                        'username'=>$request->input('username')
                      ];
        $cursor     = $this->common_collection->find($condition);
        $total      = 0;//$cursor->count();
        //$this->common_connection->close();
      
        if($total)
        {
            Session::flash('error', "Email(Username) already exist!");
            return \Redirect::back();
        }

        $condition = ['_id'=>new \MongoId($id)];
        $new_data  = [
                        '$set' => ["username" => $request->input('username')],
                        '$set' => ["role" => $request->input('role')]
                     ];
        $responce  = $this->common_collection->update($condition,$new_data);
        //$this->common_connection->close();
        
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
        $condition = ['_id'  => new \MongoId($id)];
        $new_data  = ['$set' => ["is_delete" => '1']];
        $responce  = $this->common_collection->update($condition,$new_data);
        //$this->common_connection->close();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
