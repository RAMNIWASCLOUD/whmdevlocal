<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use \MongoDB\BSON\ObjectID as MongoId;

class BsnlsimnewController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        /* $this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db         = $this->common_connection->whm;
        $this->common_collection = $this->common_db->bsnl_sim;*/
        $this->title             = "BSNL SIM";
        $this->url_slug          = "bsnlsim";
        $this->folder_path       = "admin/bsnlsim/";
        ini_set('max_execution_time', 0);
        ini_set('post_max_size', '1000M');
        ini_set('upload_max_filesize', '1000M');
        ini_set('memory_limit', '2048M');
    }
 
    public function add()
    {
        /*$sim = \DB::table('meter')->orderBy('_id','ASC')->chunk(5000, function($data) {
            foreach ($data as $key => $value) {
                if(!empty($value['vmwh_delivery_time']))
                {
                    $vendor_dispatch_date = date('Y-m-d', $value['vmwh_delivery_time']);
                }
                else
                {
                    $vendor_dispatch_date = '';
                }
               \DB::table('meter')->where(['device_id'=>$value['device_id']])->update((['vendor_dispatch_date'=>$vendor_dispatch_date]));
               //print_r($value['sim_no']);die;
               //die;
               
            }
        });
        echo 'success';
        die;*/




        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_%')->limit(1)->get();
        dd($sim);
        /*$sim = \DB::table('meter')->where('sim_no','like','%sim_sim_%')->orderBy('_id','ASC')->chunk(5000, function($data) {
            foreach ($data as $key => $value) {
               $sim_no = str_replace('sim_', '', str_replace('sim_', '', str_replace('sim_', '', $value['sim_no'])));
               \DB::table('meter')->where(['sim_no'=>$value['sim_no']])->update((['sim_no'=>$sim_no]));
               //print_r($value['sim_no']);die;
               //die;
               
            }
        });
        echo 'success';
        die;*/
        /*for ($i=0; $i < 100000; $i++) { 
         $new_data                    = [];
                        //$new_data['srno']          = $row[0];
                        $new_data['sim_no']          = str_replace("sim", "", 'sim'.rand(10,1000000));
                        $new_data['mobile_no']       = str_replace("mobile", "", 'mobile'.rand(10,1000000));
                        $new_data['imsi']            = str_replace("imsi", "", 'imsi'.rand(10,1000000));
                        $new_data['static_ip']       = 'static_ip'.rand(10,1000000);
                        $new_data['apn']             = 'apn'.rand(10,1000000);
                        $new_data['status']          = 'status'.rand(10,1000000);
                        $new_data['batch_id']        = "Sim_Batch-".date('d_m_Y_h:i:s');
                        $new_data['sim_upload_time'] = time();
                      
                                $new_data['sim_status'] = 'UNUTILISED';
                        
                        $new_data['swh']                    = '';
                        $new_data['swh_name']               = '';
                        $new_data['last_sim_location']      = '';
                        $new_data['last_sim_location_time'] = '';
                        $new_data['swh_delivery_time']      = '';
                        $new_data['swh_inventory_status']   = '';
                        $new_data['mrn_ref']                = '';
                        $new_data['dl_ch_ref']              = '';
                        $new_data['vmwh_mrn_ref']           = '';
                        $new_data['vmwh_dl_ch_ref']         = '';

                        $new_data['vmwh']                   = '';
                        $new_data['vmwh_name']              = '';
                        $new_data['vmwh_delivery_time']     = '';
                        $new_data['is_delete']     = '0';
                                               
                            $responce = \DB::table('bsnl_sim')->insert($new_data);
                            }     
                       die;*/
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('_id' => -1);
        $condition  = [];
        $cursor     = \DB::table('bsnl_sim');

        if(isset($_GET['search']) && !empty($_GET['search']))
        {
            $cursor = $cursor->where(['sim_no' =>$_GET['search'],'is_delete'=>'0']);
        }
        else
        {
            $cursor = $cursor->where(['is_delete'=>'0']);

        }
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);
        $total      = 0;//$cursor->count();

      
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'add',$data);
    }

  
    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                //'file'          => 'required',
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
                    $responce = \DB::table('bsnl_sim')->where(['sim_no'=>'sim_'.str_replace("sim", "", $row[1])])->first();

                    $i++;
                    if(!empty($responce))
                    {
                        $flag = true;
                        array_push($temp, $row[1]);
                    }
                }
            }
        }
        else
        {
            Session::flash('error', "Error! Please upload file.");
            return \Redirect::to('add_bsnlsim');
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Sim No already exists: ".implode($temp, ', '));
            return \Redirect::to('add_bsnlsim');
        }
 
        $temp = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Sim_Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[1]) && !empty($row[1]))
                        {

                            $new_data                    = [];
                            //$new_data['srno']          = $row[0];
                            //$sim_no                      = substr($row[1], 0, -1);
                            $new_data['sim_no']          = 'sim_'.str_replace("sim", "", $row[1]);
                            $new_data['mobile_no']       = str_replace("mobile", "", $row[2]);
                            $new_data['imsi']            = str_replace("imsi", "", $row[3]);
                            $new_data['static_ip']       = $row[4];
                            $new_data['apn']             = $row[5];
                            $new_data['status']          = $row[6];
                            $new_data['batch_id']        = $batch_id;
                            $new_data['sim_upload_time'] = $date_time;

                            if(!empty($new_data['sim_no']))
                            {
                                $responce = \DB::table('meter')->where(['sim_no2'=>$row[1]])->first();
                                if(!empty($responce))
                                {
                                    $new_data['sim_status'] = 'UTILIZED';
                                }
                                else
                                {
                                    $new_data['sim_status'] = 'UNUTILISED';
                                }
                            }
                            
                                    //$new_data['sim_status'] = 'UTILIZED';
                            $new_data['swh']                    = '';
                            $new_data['swh_name']               = '';
                            $new_data['last_sim_location']      = '';
                            $new_data['last_sim_location_time'] = '';
                            $new_data['swh_delivery_time']      = '';
                            $new_data['swh_inventory_status']   = '';
                            $new_data['mrn_ref']                = '';
                            $new_data['dl_ch_ref']              = '';
                            $new_data['vmwh_mrn_ref']           = '';
                            $new_data['vmwh_dl_ch_ref']         = '';

                            $new_data['vmwh']                   = '';
                            $new_data['vmwh_name']              = '';
                            $new_data['vmwh_delivery_time']     = '';
                            $new_data['is_delete']     = '0';
                           
                           if(!empty(str_replace("sim", "", $row[1])))
                           {
                            array_push($temp, $new_data);                    
                           }
                           //dd($temp);
                        }

                    }
                    $i++;
                }
            }
            //dd(count($temp));
            $responce = \DB::table('bsnl_sim')->insert($temp);     
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::to('add_bsnlsim');
            // return \Redirect::back();
            
        }


        /*$temp = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Sim_Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[1]) && !empty($row[1]))
                        {
                            
                            $responce = \DB::table('meter')->where(['device_id'=>$row[1]])->first();
                            if(!empty($responce))
                            {
                                $flag = '';
                                if($row[4]=='SBPDCL'){
                                    $flag = 'SBPD';
                                }else{
                                    $flag = 'NBPD';
                                }
                                //dd(['whm_system_utility'=>$flag,'whm_system_utility_id'=>8571]);
                                \DB::table('meter')->where(['device_id'=>$row[1]])->update(['whm_system_utility'=>$flag,'whm_system_utility_id'=>8571]);
                            }else{

                                 dd('error'.$row[1]);  
                            }
                            
                        }

                    }
                    $i++;
                }
            }
        }
        dd('Done'.$i);*/
        /*$temp = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Sim_Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[1]) && !empty($row[1]))
                        {

                            $new_data                    = [];
                            //$new_data['srno']          = $row[0];
                           if(!empty($row[0]))
                           {
                            array_push($temp, $row[0]);                    
                           }
                        }

                    }
                    $i++;
                }
            }
            \DB::table('meter')->whereIn('device_id',$temp)->update(['whm_system_utility'=>'SBPD']);
            $responce = \DB::table('bsnl_sim')->insert($temp);     
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }*/

        /*$id = '';
        $warehouse_name = '';
        $count = 0;
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[1]) && !empty($row[1]))
                        {
                            if(empty($id))
                            {
                                $login_users = \DB::table('login_users')->where(['username'=>$row[6]])->first();
                                $warehouse_name = $login_users['warehouse_name'];
                                $id = $login_users['_id'];
                            }
                            if(empty($id)){
                                echo 'Username Not found: '.$row[6];die;
                            }
                            $new_data                             = [];
                            $new_data['current_meter_status']     = 'Open in VP warehouse';
                            $new_data['vmwh']                     = $id;//new MongoId($id);
                            $new_data['last_meter_location']      = $warehouse_name;
                            $new_data['vmwh_name']                = $warehouse_name;
                            $new_data['last_meter_location_time'] = time();
                            $new_data['vmwh_delivery_time']       = time();
                            $new_data['swh_inventory_status']     = 'Outstock';
                            $new_data['dl_ch_ref']                = 'AdminActivityPerformedForMeterMovment';

                           if(!empty($row[0]))
                           {
                            \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);   
                            $count++;       
                           }
                        }

                    }
                    $i++;
                }
            }
            //\DB::table('meter')->whereIn('device_id',$temp)->update(['whm_system_utility'=>'SBPD']);
            //$responce = \DB::table('bsnl_sim')->insert($temp);     
            Session::flash('success', 'Success! .CSV uploded successfully.'.$count);
            return \Redirect::to('add_bsnlsim');
            return \Redirect::back();
        }
        else
        {
            dd('error file upload');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
        */

        /*if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(!empty($row[5]))
                        {
                            $login_users  = \DB::table('login_users')->where(['username'=>$row[5]])->first();
                            if(empty($login_users))
                            {
                                if($row[3]=='NBPDCL')
                                {
                                    $sw = '632d52182d5864aff9b32160';
                                }else{
                                    $sw = '632d52182d5864aff9b3215f';
                                }
                                $new_data                      = [];
                                $new_data['username']          = $row[5];
                                $new_data['role']              = '3';
                                $new_data['password']          = md5('12345');
                                $new_data['state']             = 'Bihar';
                                $new_data['city']              = $row[1];
                                $new_data['warehouse_name']    = $row[4];
                                $new_data['warehouse_address'] = $row[8];
                                $new_data['parent_sw']         = new MongoId($sw);
                                $new_data['is_delete']         = "0";

                                $new_data['mrn_authorized_1']          = "";
                                $new_data['mrn_authorized_2']          = "";
                                $new_data['admin']                     = new MongoId(\Session::get('_id'));
                                $new_data['admin_name']                = "Main Warehouse";
                                $new_data['origin_email']              = "";
                                $new_data['origin_name']               = "";
                                $new_data['origin_user_id']            = "";
                                $new_data['installed']                 = "0";
                                $new_data['opening_stock']             = "0";
                                $new_data['receipts']                  = "0";
                                $new_data['meter_available_with_them'] = "0";
                                $sw_  = \DB::table('login_users')->where(['_id'=>new MongoId($sw)])->first();
                                if(!empty($sw_)){
                                    $new_data['utility']  = $sw_['utility'];   
                                }
                                else
                                {
                                    $new_data['utility']  = "";
                                }
                                $responce = \DB::table('login_users')->insert($new_data);
                            }

                        }

                    }
                    $i++;
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
        }*/

        /*//installedmeter upload
        $count = 0;
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[0]) && !empty($row[0]))
                        {
                            $new_data                             = [];

                            $new_data['last_meter_location']      = 'Consumer:'.$row[1];
                            $new_data['last_meter_location_time'] = strtotime(date('Y-m-d h:s:i',strtotime($row[6])));
                            //$new_data['meter_created_at']         = date('d/m/Y h:i:s A');
                            $new_data['consumer_id']              = $row[1];
                            $new_data['edf_status']               = 'Installed';
                            $new_data['edf_vendor_manager_name']  = $row[2];
                            $new_data['edf_vendor_plan_name']     = $row[3];
                            $new_data['field_worker']             = $row[4];
                            $new_data['installation_date_time']   = date('Y-m-d h:s:i',strtotime($row[6]));
                            //dd($new_data);
                           if(!empty($row[0]))
                           {
                            \DB::table('meter')->where(['device_id'=>$row[0]])->update($new_data);   
                            $count++;       
                           }
                        }

                    }
                    $i++;
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.'.$count);
            return \Redirect::to('add_bsnlsim');
            return \Redirect::back();
        }
        else
        {
            dd('error file upload');
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    */


    /*    //mark physical damage
        $temp = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Sim_Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[0]) && !empty($row[0]))
                        {

                            $new_data                    = [];
                            //$new_data['srno']          = $row[0];
                           if(!empty($row[0]))
                           {
                            array_push($temp, $row[0]);                    
                           }
                        }

                    }
                    $i++;
                }
            }
            \DB::table('meter')->whereIn('device_id',$temp)->update(['batch_status'=>'Rejected','testing_status'=>'Rejected','status'=>'Rejected','physical_testing_status'=>'Damaged','dl_ch_ref'=>'']);
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }*/

        /*7 meter add into Intellismart_Patna_NB
        $temp = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Sim_Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[0]) && !empty($row[0]))
                        {

                            $new_data                    = [];
                            //$new_data['srno']          = $row[0];
                           if(!empty($row[0]))
                           {
                            array_push($temp, $row[0]);                    
                           }
                        }

                    }
                    $i++;
                }
            }
            dd($temp);
            \DB::table('meter')->whereIn('device_id',$temp)->update(['swh_inventory_status'=>'Outstock','vmwh_name'=>'Intellismart_Patna_NB','vmwh'=>new MongoId('6378a0f6413d3c26691f0c92')]);
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }*/



        //Send repaired meter into edf pool
        /*$temp = [];
        if(isset($_FILES["file"]['tmp_name'])  && !empty($_FILES["file"]['tmp_name']))
        {                    
            $fh = fopen($_FILES['file']['tmp_name'], 'r+');               
            $batch_id = "Sim_Batch-".date('d_m_Y_h:i:s');
            $date_time= time();
            $i = 0;
            while( ($row = fgetcsv($fh, 8192)) !== FALSE) 
            {
                if(isset($row) && $row!=NULL)
                {
                    if($i!=0)
                    {
                        if(isset($row[0]) && !empty($row[0]))
                        {
                

                            $new_data                    = [];
                            //$new_data['srno']          = $row[0];
                           if(!empty($row[0]))
                           {
                            array_push($temp, $row[0]);                    
                           }
                        }

                    }
                    $i++;
                }
            }
            \DB::table('meter')->whereIn('device_id',$temp)->update(['batch_status'=>'Approved']);
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }*/
    }

}
