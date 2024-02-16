<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Session;
use \MongoDB\BSON\ObjectID as MongoId;

class ApinewController extends Controller
{
    public function __construct()
    {

        $data                    = [];
        header('Access-Control-Allow-Origin', '*');
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        date_default_timezone_set('Asia/Kolkata');


        /*$this->common_connection = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db         = $this->common_connection->whm;
        $this->common_collection = $this->common_db->mrn;*/
        //dd('Error! Access-Control-Allow-Origin');
       /* if (isset($_SERVER['HTTP_ORIGIN']))
        {
                // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                // you want to allow, and if so:
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            {
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");                         
            }    

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }*/
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'username'     => 'required',
                'password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter valid credentials';
            return $data;
        }

        $credentials = [
            'username'    => $request->input('username'),
            'password' => md5($request->input('password')),
            'role' => '1',
        ];

      
        $cursor     = \DB::table('login_users')->where($credentials)->first();//
        if (!empty($cursor))
        {
            $temp                      = [];
            $temp['_id']               = $cursor['_id'];
            $id                        = (array) $cursor['_id'];
            $temp['_id']               = $id['oid'];
            $temp['username']          = $cursor['username'];
            $temp['role']              = $cursor['role'];
            $temp['warehouse_name']    = $cursor['warehouse_name'];
            $temp['warehouse_address'] = $cursor['warehouse_address'];
            
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Login successfully.';
            $data['data']    = $temp;
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Incorrect username or password.';
            return $data;
        }
    }

    public function mrn_list(Request $request)
    {
        $condition  = ['status'=>'Pending','vmwh'=>''];
        $cursor     = \DB::table('mrn')->where($condition)->get();//iterator_to_array($collection->find($condition));
        
        if (!empty($cursor))
        {
            $temp1 = [];
            foreach ($cursor as $key => $value) 
            {
                $temp                                  = [];
                $id                                    = (array) $value['_id'];
                $temp['_id']                           = $id['oid'];
                $temp['mrn_ref']                       = $value['mrn_ref'];
                $temp['kind_attn']                     = $value['kind_attn'];
                $temp['mobile_no']                     = $value['mobile_no'];
                $temp['location']                      = $value['location'];
                $temp['telephone_1']                   = $value['telephone_1'];
                $temp['telephone_2']                   = $value['telephone_2'];
                $temp['site_address']                  = $value['site_address'];
                $temp['single_phase_meter_qty']        = $value['single_phase_meter_qty'];
                $temp['three_phase_meter_qty']         = $value['three_phase_meter_qty'];
                $temp['sim_qty']                       = $value['sim_qty'];
                $temp['modem_qty']                     = $value['modem_qty'];
                $temp['seal_qty']                      = $value['seal_qty'];
                $temp['single_phase_meter_qty_issued'] = $value['single_phase_meter_qty_issued'];
                $temp['three_phase_meter_qty_issued']  = $value['three_phase_meter_qty_issued'];
                $temp['sim_qty_issued']                = $value['sim_qty_issued'];
                $temp['modem_phase_meter_qty_issued']  = $value['modem_phase_meter_qty_issued'];
                $temp['seal_phase_meter_qty_issued']   = $value['seal_phase_meter_qty_issued'];
                $temp['single_balance_to_issued']      = $value['single_balance_to_issued'];
                $temp['three_balance_to_issued']       = $value['three_balance_to_issued'];
                $temp['sim_balance_to_issued']         = $value['sim_balance_to_issued'];
                $temp['modem_balance_to_issued']       = $value['modem_balance_to_issued'];
                $temp['seal_balance_to_issued']        = $value['seal_balance_to_issued'];
                $temp['single_comment']                = $value['single_comment'];
                $temp['three_comment']                 = $value['three_comment'];
                $temp['sim_comment']                   = $value['sim_comment'];
                $temp['modem_comment']                 = $value['modem_comment'];
                $temp['seal_comment']                  = $value['seal_comment'];
                $temp['status']                        = $value['status'];
                $temp['swh']                           = $value['swh'];
                $temp['vmwh']                          = $value['vmwh'];
                $temp['added_by']                      = $value['added_by'];
                $temp['mrn_processing_date']           = $value['mrn_processing_date'];
                $temp['mrn_processing_time']           = $value['mrn_processing_time'];
                $temp['delivery_date']                 = $value['delivery_date'];
                $temp['delivery_time']                 = $value['delivery_time'];
                $temp['created_time']                  = $value['created_time'];
                $temp['vmwh_mrn_ref']                  = $value['vmwh_mrn_ref'];
                $temp['vmwh_dl_ch_ref']                = $value['vmwh_dl_ch_ref'];
                $temp['dl_ch_ref']                     = $value['dl_ch_ref'];
                $temp['dispatch_processing_date']      = $value['dispatch_processing_date'];
                $temp['dispatch_processing_time']      = $value['dispatch_processing_time'];
                $temp['is_delivery_challan']           = $value['is_delivery_challan'];
                $temp['delivery_status']               = $value['delivery_status'];
                $temp['wh']                            = $value['wh'];
                $temp['from_address']                  = $value['from_address'];
                $temp['to_address']                    = $value['to_address'];
                $temp['dispatch_created_time']         = $value['dispatch_created_time'];
                $temp['delivery_accepted_time']        = $value['delivery_accepted_time'];
                $temp['single_phase_meter_price']      = $value['single_phase_meter_price'];
                $temp['three_phase_meter_price']       = $value['three_phase_meter_price'];
                $temp['grand_total']                   = $value['grand_total'];
                $temp['to_dispatch']                   = $value['to_dispatch'];
                $temp['dispatch_mode']                 = $value['dispatch_mode'];
                $temp['name_of_pickup_person']         = $value['name_of_pickup_person'];
                $temp['mobile_no_pickup_person']       = $value['mobile_no_pickup_person'];
                $temp['lr_copy']                       = $value['lr_copy'];
                $temp['lr_no']                         = $value['lr_no'];
                $temp['transport_name']                = $value['transport_name'];
                $temp['driver_name']                   = $value['driver_name'];
                $temp['driver_mobile_no']              = $value['driver_mobile_no'];
                $temp['delivery_proof']                = $value['delivery_proof'];
                $temp['delivery_reject_reason']        = $value['delivery_reject_reason'];
                $temp['vmwh_delivery_status']          = $value['vmwh_delivery_status'];
                $temp['vmwh_delivery_proof']           = $value['vmwh_delivery_proof'];
                $temp['vmwh_delivery_date']            = $value['vmwh_delivery_date'];
                $temp['vmwh_delivery_time']            = $value['vmwh_delivery_time'];
                $temp['vmwh_delivery_accepted_time']   = $value['vmwh_delivery_accepted_time'];
                $temp['vmwh_dispatch_processing_date'] = $value['vmwh_dispatch_processing_date'];
                $temp['vmwh_dispatch_processing_time'] = $value['vmwh_dispatch_processing_time'];
                $temp['vmwh_dispatch_created_time']    = $value['vmwh_dispatch_created_time'];



                array_push($temp1, $temp);
            }
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Record Found.';
            $data['data']    = $temp1;
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Record Not Found.';
            return $data;
        }
    }

    public function dispatch_list(Request $request)
    {

        $condition  = ['dl_ch_ref' => ['$ne'=>''],'is_delivery_challan'=>'Yes'];
        $cursor     = $cursor     = \DB::table('mrn')->where($condition)->get();//iterator_to_array($collection->find($condition));
        if (!empty($cursor))
        {
            $temp = [];
            foreach ($cursor as $key => $value) 
            {
                $temp1                             = [];
                $id                                = (array) $value['_id'];
                $temp1['_id']                      = $id['oid'];
                //$temp1['_id']                      = $value['_id'];
                $temp1['dl_ch_ref']                = $value['dl_ch_ref'];
                $temp1['kind_attn']                = $value['kind_attn'];
                $temp1['mobile_no']                = $value['mobile_no'];
                $temp1['dispatch_processing_date'] = $value['dispatch_processing_date'];
                $temp1['dispatch_processing_time'] = $value['dispatch_processing_time'];
                $temp1['status']                   = $value['status'];
                $temp1['delivery_date']            = $value['delivery_date'];
                $temp1['delivery_time']            = $value['delivery_time'];
                $temp1['url']                      = url('/').'/view_dispatch/'.$id['oid'];
                array_push($temp, $temp1);
            }
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Record Found.';
            $data['data']    = $temp;
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Record Not Found.';
            return $data;
        }
    }

    public function warehouse_list(Request $request)
    {
        $condition  = ['role'=>'2'];
        $cursor     = \DB::table('login_users')->where($condition)->get();//iterator_to_array($collection->find($condition));
        
        if (!empty($cursor))
        {
            $temp = [];
            foreach ($cursor as $key => $value) 
            {
                $temp1                      = [];
                $id                         = (array) $value['_id'];
                $temp1['_id']               = $id['oid'];
                $temp1['username']          = $value['username'];
                $temp1['warehouse_name']    = $value['warehouse_name'];
                $temp1['warehouse_address'] = $value['warehouse_address'];
                array_push($temp, $temp1);
            }
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Record Found.';
            $data['data']    = $temp;
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Record Not Found.';
            return $data;
        }
    }

    public function check_meter(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'manufacturer_serial_number'     => 'required'
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $condition  = ['batch_status'=>'New Meter','manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $total      = \DB::table('meter')->where($condition)->count();
        if($total)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter is not tested.';
            return $data;
        }

        $condition  = ['dl_ch_ref'=>'','status'=>'New Meter','manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $cursor      = \DB::table('meter')->where($condition)->first();
        if(!empty($cursor))
        {
            
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Meter Valid';
            //$data['_id']     = $cursor['_id'];
            $id              = (array) $cursor['_id'];
            $data['_id']     = $id['oid'];
            $data['manufacturer_serial_number']     = $request->input('manufacturer_serial_number');
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Invalid or Already Set for MRN.';
            return $data;
        }
    }

    public function upload_lr_copy(Request $request)
    {
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $file_name                         = $_FILES["image"]["name"];
        $file_tmp                          = $_FILES["image"]["tmp_name"];
        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
        $random_file_name                  = $randomString.'.'.$ext;
        $latest_image                      = '/upload/lr_copy/'.$random_file_name;
        $filename                          = basename($file_name,$ext);
        $newFileName                       = $filename.time().".".$ext;

        if(move_uploaded_file($file_tmp,base_path().$latest_image))
        {
            print_r($latest_image);die;
        }
        else
        {
            $response = [];
            $response['status'] = false;
            $response['message'] = 'Image not saved. Please try again.';
            $response['data'] = [];
        }
        return $response;
    }

    public function upload_damage_meter(Request $request)
    {
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $file_name                         = $_FILES["image"]["name"];
        $file_tmp                          = $_FILES["image"]["tmp_name"];
        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
        $random_file_name                  = $randomString.'.'.$ext;
        $latest_image                      = '/upload/damage_meter/'.$random_file_name;
        $filename                          = basename($file_name,$ext);
        $newFileName                       = $filename.time().".".$ext;
        //dd($file_tmp,base_path().$latest_image);
        if(move_uploaded_file($file_tmp,base_path().$latest_image))
        {
            print_r($latest_image);die;
        }
        else
        {
            $response = [];
            $response['status'] = false;
            $response['message'] = 'Image not saved. Please try again.';
            $response['data'] = [];
        }
        return $response;
    }

    public function upload_reject_meter(Request $request)
    {
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $file_name                         = $_FILES["image"]["name"];
        $file_tmp                          = $_FILES["image"]["tmp_name"];
        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
        $random_file_name                  = $randomString.'.'.$ext;
        $latest_image                      = '/upload/reject_meter/'.$random_file_name;
        $filename                          = basename($file_name,$ext);
        $newFileName                       = $filename.time().".".$ext;

        if(move_uploaded_file($file_tmp,base_path().$latest_image))
        {
            print_r($latest_image);die;
        }
        else
        {
            $response = [];
            $response['status'] = false;
            $response['message'] = 'Image not saved. Please try again.';
            $response['data'] = [];
        }
        return $response;
    }

    public function upload_state_salfpickup_image(Request $request)
    {
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $file_name                         = $_FILES["image"]["name"];
        $file_tmp                          = $_FILES["image"]["tmp_name"];
        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
        $random_file_name                  = $randomString.'.'.$ext;
        $latest_image                      = '/upload/state_salfpickup_image/'.$random_file_name;
        $filename                          = basename($file_name,$ext);
        $newFileName                       = $filename.time().".".$ext;

        if(move_uploaded_file($file_tmp,base_path().$latest_image))
        {
            print_r($latest_image);die;
        }
        else
        {
            $response = [];
            $response['status'] = false;
            $response['message'] = 'Image not saved. Please try again.';
            $response['data'] = [];
        }
        return $response;
    }

    public function upload_vm_salfpickup_image(Request $request)
    {
        $image = $_FILES["image"]["name"];
        if(empty($image))
        {
            $response            = [];
            $response['status']  = false;
            $response['message'] = "Invalid Parameters.";
            $response['data']    = [];
            print_r(json_encode($response));
            die();  
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $file_name                         = $_FILES["image"]["name"];
        $file_tmp                          = $_FILES["image"]["tmp_name"];
        $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
        $random_file_name                  = $randomString.'.'.$ext;
        $latest_image                      = '/upload/vm_salfpickup_image/'.$random_file_name;
        $filename                          = basename($file_name,$ext);
        $newFileName                       = $filename.time().".".$ext;

        if(move_uploaded_file($file_tmp,base_path().$latest_image))
        {
            print_r($latest_image);die;
        }
        else
        {
            $response = [];
            $response['status'] = false;
            $response['message'] = 'Image not saved. Please try again.';
            $response['data'] = [];
        }
        return $response;
    }

    public function create_dispatch(Request $request)
    {
        $validator          = \Validator::make($request->all(), [
                'mrn_id'                        => 'required',
                'meter_ids_list'                => 'required',
                'single_phase_meter_qty'        => 'required',
                'three_phase_meter_qty'         => 'required',
                'hidden_single_phase_meter_qty' => 'required',
                'hidden_three_phase_meter_qty'  => 'required',
                //'single_comment'                => 'required',
                //'three_comment'                 => 'required',
                'to_dispatch'                   => 'required',
                'dispatch_mode'                 => 'required',
                /*'name_of_pickup_person'         => 'required',
                'mobile_no_pickup_person'       => 'required',
                'lr_no'                         => 'required',
                'transport_name'                => 'required',
                'driver_name'                   => 'required',
                'driver_mobile_no'              => 'required',*/
                //'single_phase_meter_price'      => 'required',
                //'three_phase_meter_price'       => 'required',
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter all details';
            return $data;
        }

        $condition  = [
                        '_id' => new MongoId($request->input('mrn_id'))
                      ];
        $cursor      = \DB::table('mrn')->where($condition)->first();
      
        if(!empty($total))
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please Select valid MRN No.';
            return $data;
        }
        if(empty($request->input('meter_ids_list')))
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please Select Meters to process.';
            return $data;
        }
        $single_phase_meter_qty_issued = $request->input('single_phase_meter_qty');
        $three_phase_meter_qty_issued  = $request->input('three_phase_meter_qty');
        $single_balance_to_issued      = $request->input('hidden_single_phase_meter_qty')-$request->input('single_phase_meter_qty');
        $three_balance_to_issued       = $request->input('hidden_three_phase_meter_qty')-$request->input('three_phase_meter_qty');
        $total_meter_qty               = $single_phase_meter_qty_issued + $three_phase_meter_qty_issued;
        $cursor_parameter_list         = $cursor;

        $cursor                        = \DB::table('mrn')->where($condition)->count();
        $count                         = $cursor+1;
        $mrn_ref                       = $cursor_parameter_list['mrn_ref'];
        $dl_ch_ref                     = 'EDF/BHR/EESL/'.date('d').'-'.date('Y').'-'.$count;
        $condition                     = ['_id'=>new MongoId($request->input('mrn_id'))];
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
                            "lr_copy"                       => $request->input('lr_copy'),
                            "transport_name"                => $request->input('transport_name'),
                            "driver_name"                   => $request->input('driver_name'),
                            "driver_mobile_no"              => $request->input('driver_mobile_no'),
                            "state_warehouse_selfpickup_image" => $request->input('selfpickup_image'),

                            "dl_ch_ref"                     => $dl_ch_ref,
                            "dispatch_processing_date"      => date('d-m-Y'),
                            "dispatch_processing_time"      => date('h:i:s A'),
                            "is_delivery_challan"           => 'Yes',
                            "status"                        => 'Dispatch Process',
                            "delivery_status"               => 'Dispatch Process',
                            "wh"                            => $request->input('wh_id'),
                            "from_address"                  => $request->input('warehouse_address'),
                            "dispatch_created_time"         => time(),
                            "delivery_date"                 => '',
                            "delivery_time"                 => '',
                            "delivery_accepted_time"        => '',
                            "single_phase_meter_price"       => '',
                            "three_phase_meter_price"       => '',
                            "grand_total"                   => '',
                        ];
                     
        $responce  = \DB::table('mrn')->where($condition)->update($new_data);
        foreach (json_decode($request->input('meter_ids_list')) as $key => $value) 
        {
            $condition = ['_id'=>new MongoId($value->_id)];
            $new_data  =  [
                                "mrn_ref" => $mrn_ref,
                                "dl_ch_ref" => $dl_ch_ref];
            $responce  = \DB::table('meter')->where($condition)->update($new_data);
        }
        
        if (!empty($responce))
        {
            $data            = [];
            $data['status']  = true;
            $data['message'] = "Dispatch added successfully.";
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = "Error! Oop's something went wrong.";
            return $data;
        }
    }

    public function check_physical_meter(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'manufacturer_serial_number'     => 'required',
                'batch_id'     => 'required'
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $total      = \DB::table('meter')->where($condition)->count();
        
        if($total==0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter does not exist.';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number'),"physical_testing_status" => "Tested"];
        
        $total      = \DB::table('meter')->where($condition)->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number'),"physical_testing_status" => "Damaged"];
        
        $total      = \DB::table('meter')->where($condition)->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number'),"physical_testing_status" => "sagregated"];
        
        $total      = \DB::table('meter')->where($condition)->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition  = ['physical_testing_status'=>'Pending','batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $cursor      = \DB::table('meter')->where($condition)->first();

        if(!empty($cursor))
        {
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Meter Valid';
            $id              = (array) $cursor['_id'];
            $data['_id']     = $id['oid'];

            $data['manufacturer_serial_number']     = $request->input('manufacturer_serial_number');
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Api error';
            return $data;
        }
    }

    public function check_technical_meter(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'manufacturer_serial_number'     => 'required',
                'batch_id'     => 'required'
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $total      = \DB::table('meter')->where($condition)->count();
        
        if($total==0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter does not exist.';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $total      = \DB::table('meter')->where($condition)->count();
        
        if($total==0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter does not exist.';
            return $data;
        }

        

        $condition              = array('batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number'),"testing_status" => "Reject");
        $total      = \DB::table('meter')->where($condition)->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition              = array('batch_status'=>'Sample Selected','batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number'));
        $total      = \DB::table('meter')->where($condition)->count();
        if($total==0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter not available for technical testing.';
            return $data;
        }

        $condition  = ['batch_status'=>'Sample Selected','batch_id'=>$request->input('batch_id'),'manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $cursor      = \DB::table('meter')->where($condition)->first();
        if(!empty($cursor))
        {
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Meter Valid';
            $id              = (array) $cursor['_id'];
            $data['_id']     = $id['oid'];
            $data['manufacturer_serial_number']     = $request->input('manufacturer_serial_number');
        
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Api error';
            return $data;
        }
    }

    public function update_physical_testing_report(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'id' => 'required',
                'manufacturer_serial_number' => 'required',
                'status'                     => 'required',
                'reason'                     => 'required',
                'images'                     => 'required'

            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $condition = ['_id'=>new MongoId($request->input('id'))];

         $total      = \DB::table('meter')->where($condition)->count();
        if(!$total)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please scan valid meter.';
            return $data;
        }
       
        $condition = ['manufacturer_serial_number'=>$request->input('manufacturer_serial_number'),'physical_testing_status'=>['$ne'=>'Pending']];
        $cursor = \DB::table('meter')->where($condition)->get();
        
        if(!empty(iterator_to_array($cursor)))
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter already tested.';
            return $data;
        }
        $condition  = ['physical_testing_status'=>'Pending','manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $new_data   = ["physical_testing_status" => $request->input('status'),
                            "physical_testing_time"          => time(),
                            "physical_meter_reject_reason"   => $request->input('reason'),
                            "physical_meter_reject_images"   => $request->input('images'),
                        ];

                     
        $responce  = \DB::table('meter')->where($condition)->update($new_data);
        
        $data            = [];
        $data['status']  = true;
        $data['message'] = 'Meter Updated successfully';
        return $data;
    } 

    public function physical_test_report()
    {
        /*
        $match = ['physical_testing_status'=>'Pending'];
        $condition  = [
                        ['$match'=>$match],
                        ['$group' => ['_id' => '$batch_id']]
                      ];     
        $cursor     = $this->common_db->meter->aggregate($condition,array('cursor' => array('batchSize' => 10000)));//*/
        $temp       = [];
        $total      = 0; 
        $match = ['physical_testing_status'=>'Pending'];
        $cursor = \DB::table('meter')->where($match)->groupBy('batch_id')->get();
        if(isset($cursor/*['cursor']['firstBatch']*/))
        {
            foreach($cursor/*['cursor']['firstBatch']*/ as $key => $value) 
            {
                $condition              = ['batch_id'=>$value['_id']];
                $Selected_samples_count =  \DB::table('meter')->where($condition)->count();
                        // [,'$or'=>[['physical_testing_status'=>'Tested'],['physical_testing_status'=>'Damaged']];
                $Selected_samples_tested_count = \DB::table('meter')->where(['batch_id'=>$value['_id'],"physical_testing_status" => "Tested"])->where(['batch_id'=>$value['_id'],"physical_testing_status" => "Damaged"])->count();
                if($Selected_samples_count!=0)
                {
                    $percentage = ($Selected_samples_tested_count/$Selected_samples_count)*100;
                }
                else
                {
                    $percentage = 0;
                }

                $temp1 = [];    
                $temp1['batch_id'] = $value['_id']['batch_id'];
                $temp1['percentage'] = number_format($percentage,0);
                array_push($temp, $temp1);
                $total++;
            }
        }

        if (!empty($temp))
        {
            $data            = [];
            $data['status']  = true;
            $data['date']    = $temp;
            $data['message'] = "Record found.";
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = "Error! No Record found.";
            return $data;
        }
        //$this->common_connection->close();

    }

    public function search_physical_meter(Request $request)
    {
        print_r('Functionaity removed');die;
        $validator = \Validator::make($request->all(), [
                'device_id'     => 'required',
                'batch_id'     => 'required'
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $db         = $this->common_connection->whm;
        $collection = $db->meter;
        $condition  = ['batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id')];
        $cursor     = $collection->find($condition);
        $total      = $cursor->count();
        
        if($total==0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter does not exist.';
            return $data;
        }

        $db         = $this->common_connection->whm;
        $collection = $db->meter;
        $condition              = array('batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id'),'$or' => [
                          ["physical_testing_status" => "Tested"],
                          ["physical_testing_status" => "Damaged"],
                          ["physical_testing_status" => "sagregated"]
                        ]);
        $cursor     = $collection->find($condition);
        $total      = $cursor->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition  = ['physical_testing_status'=>'Pending','batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id')];
        $cursor     = $collection->find($condition);
        $total      = $cursor->count();

        if(!empty(iterator_to_array($cursor)))
        {
            $_id = '';
            foreach ($cursor as $key => $value) 
            {
                $_id = $key;
            }
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Meter Valid';
            $data['data'] = ['_id'=>$_id,'device_id'=>$request->input('device_id')];
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Api error.';
            return $data;
        }
    }

    public function update_technical_testing_report(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'id' => 'required',
                'manufacturer_serial_number' => 'required',
                'status'                     => 'required',
                'reason'                     => 'required',
                'images'                     => 'required'

            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $condition = ['_id'=>new MongoId($request->input('id'))];

         $total      = \DB::table('meter')->where($condition)->count();
        if(!$total)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please scan valid meter.';
            return $data;
        }
       
        $condition = ['manufacturer_serial_number'=>$request->input('manufacturer_serial_number')];
        $cursor = \DB::table('meter')->where('batch_status','!=','Sample Selected')->where($condition)->count();
        if(!$cursor)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter already tested.';
            return $data;
        }
        $condition  = ['_id'=>new MongoId($request->input('id'))];
        $new_data   = ["testing_status" => $request->input('status'),
                        "meter_reject_reason" => $request->input('reason'),
                        "meter_reject_images" => $request->input('images')
                        ];
        $responce  = \DB::table('meter')->where($condition)->update($new_data);
        
        $data            = [];
        $data['status']  = true;
        $data['message'] = 'Meter Updated successfully';
        return $data;
    } 

    public function technical_test_report()
    {
        $match = ['physical_testing_status'=>'sagregated','batch_status'=>'Sample Selected'];
        $cursor     = \DB::table('meter')->where($match)->groupBy('batch_id')->get();//
        $temp       = [];
        $total      = 0; 
        if(isset($cursor))
        {
            foreach($cursor as $key => $value) 
            {
                $condition              = ['physical_testing_status'=>'sagregated','batch_id'=>$value['_id'],'batch_status'=>'Sample Selected'];
                $Selected_samples_count = \DB::table('mrn')->where($condition)->count();
                $condition_tested              = ['batch_status'=>'Sample Selected','batch_id'=>$value['_id'],'testing_status'=>'Approved'];
                $Selected_samples_tested_count = \DB::table('mrn')->where($condition_tested)->count();
                
                if($Selected_samples_count!=0)
                {
                    $percentage = ($Selected_samples_tested_count/$Selected_samples_count)*100;
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

        if (!empty($temp))
        {
            $data            = [];
            $data['status']  = true;
            $data['date']    = $temp;
            $data['message'] = "Record found.";
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = "Error! No Record found.";
            return $data;
        }
        //$this->common_connection->close();

    }

    public function search_technical_meter(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'device_id'     => 'required',
                'batch_id'     => 'required'
            ]);

        if ($validator->fails()) 
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Please enter Device ID';
            return $data;
        }

        $condition  = ['batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id')];
        $total      = \DB::table('meter')->where($condition)->count();
        
        if($total==0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter does not exist.';
            return $data;
        }

        $condition              = array('batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id'),'$or' => [["testing_status" => "Approved"]]);
        $total      = \DB::table('meter')->where($condition)->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition              = array('batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id'),'$or' => [["testing_status" => "Reject"]]);
        $total      = \DB::table('meter')->where($condition)->count();
        if($total>0)
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Meter Already Tested.';
            return $data;
        }

        $condition  = ['batch_status'=>'Sample Selected','batch_id'=>$request->input('batch_id'),'device_id'=>$request->input('device_id')];
        $total      = \DB::table('meter')->where($condition)->get();

        if(!empty($cursor))
        {
            $data            = [];
            $data['status']  = true;
            $data['message'] = 'Meter Valid';
            $data['data'] = ['_id'=>$cursor['_id'],'device_id'=>$request->input('device_id')];
            return $data;
        }
        else
        {
            $data            = [];
            $data['status']  = false;
            $data['message'] = 'Api error.';
            return $data;
        }
    }

    public function change_pagination_limit()
    {
        Session::put('limit',$_GET['limit']);
    } 
    

    public function logout() 
    {
        Session::flush();
        Session::flash('success', 'Success! Session destroyed successfully');
        return redirect('/login');
    }
}
