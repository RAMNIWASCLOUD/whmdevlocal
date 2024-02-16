<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Session;
use \MongoDB\BSON\ObjectID as MongoId;
class Auth1Controller extends Controller
{
    public function __construct()
    {
    	$data                      = [];
        //$this->common_connection   = new \MongoClient('mongodb://whmadmin:YGAEIDU3cSpzM@10.10.251.77:41702/whm');
        //$this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        //$this->common_db           = $this->common_connection->whm;
        
    }

    public function login()
    {

        
        // dd(md5('Ad@w#m*uHs!e'));
        return view('admin/login');
    }

    public function login_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'email'     => 'required',
                'password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $credentials = [
            'username'    => $request->input('email'),
            'password' => md5($request->input('password')),
        ];

//  $cursor = \DB::table('whm_mrn')->get();

       \DB::connection()->getPDO();

        
       $cursor = \DB::table('login_users')->where(['is_delete'=>'0'])->where($credentials)->get();
    //  $cursor = \DB::table('login_users')->where(['is_delete'=>'0'])->where(['role'=>'1'])->get();
       
        
        if (count($cursor))
        {
            //dd(new \MongoDB\BSON\ObjectId("654654"));
            foreach ($cursor as $key => $value) 
            {
            //     //dd($value['_id']);
            //     //dd($value);       

             // Session::put('role','1');             
                 Session::put('_id',$value['_id']);
                 Session::put('username',$value['username']);
                 Session::put('role',$value['role']);
                 Session::put('warehouse_name',$value['warehouse_name']);
                 Session::put('warehouse_address',$value['warehouse_address']);
                 Session::put('state',$value['state']);
                 Session::put('city',$value['city']);
                 Session::put('parent_sw',$value['parent_sw']);
                 Session::put('utility',$value['utility']);
                 Session::put('download_enabled','1');
                //print_r($value); exit;
                break;
            }
            

            return redirect('dashbord');
        }
        else
        {
           \Sentinel::logout();
            Session::flash('error', 'Error! Incorrect username or password.');
            return \Redirect::back();
        }
    }

   public function get_sidebar_counts(Request $request)
    {
        //$mongoId = \Session::get('_id');
        //dd(new MongoId());
        //new MongoId(\Session::get('_id'))
        
        $condition           = ['physical_testing_status'=>'sagregated'];
        $all_meter           = \DB::table('meter')->where($condition)->count();
        $condition           = ['physical_testing_status'=>'sagregated','batch_status'=>'Pending','testing_status'=>'Pending'];
        $select_meter        = \DB::table('meter')->where($condition)->count();
        //$condition         = ['swh'=>new MongoId(\Session::get('_id'))];
        //$test_report_meter = \DB::table('meter')->where($condition)->count();

        $condition       = ['batch_status'=>'Approved','dl_ch_ref'=>''];
        $edf_meter_poole = \DB::table('meter')->where($condition)->count();

        $condition         = ['dl_ch_ref'=>['$ne'=>'']/*,'swh'=>['$ne'=>'']*/];
        $assigned_meter    = \DB::table('meter')->where($condition)->count();
        $condition         = ['$or' => [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
        $reject_meter      = \DB::table('meter')->where($condition)->count();
        $_id = \Session::get('_id');

        $condition          = [/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')];
        $sm_all_meter       = \DB::table('meter')->where($condition)->count();
        
        $condition          = ['status'=>'New Meter'/*,'swh'=>new MongoId(\Session::get('_id'))*/];
        $sm_new_meter       = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')];
        $sm_edf_meter_poole = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh_inventory_status'=>'AssignedToVM'/*,'swh'=>new MongoId(\Session::get('_id'))*/,'whm_system_utility'=>\Session::get('utility')];
        $sm_assigned_meter  = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh'=>new MongoId(\Session::get('_id')),'$or' => [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
        $sm_reject_meter    = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))];


        $vm_all_meter          = \DB::table('meter')->where($condition)->count();
        $condition             = ['swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_new_meter          = \DB::table('meter')->where($condition)->count();
        $condition             = ['status'=>'Rejected','vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_reject_meter       = \DB::table('meter')->where($condition)->count();


        $condition          = ['swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED'];
        $edf_sim_poole      = \DB::table('bsnl_sim')->where($condition)->count();
        $condition          = ['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
        $swh_edf_sim_poole  = \DB::table('bsnl_sim')->where($condition)->count();
        $condition          = ['vmwh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
        $vmwh_edf_sim_poole = \DB::table('bsnl_sim')->where($condition)->count();

        $condition            = ['swh'=>'','vmwh'=>'','mrn_ref'=>'','status'=>'UNUTILISED'];
        $edf_modem_poole      = \DB::table('modem')->where($condition)->count();
        $condition            = ['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
        $swh_edf_modem_poole  = \DB::table('modem')->where($condition)->count();
        $condition            = ['vmwh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
        $vmwh_edf_modem_poole = \DB::table('modem')->where($condition)->count();

        $condition            = ['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>''/*,'sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))*/,'whm_system_utility'=>\Session::get('utility')];
        $sm_damaged_meter     = \DB::table('meter')->where($condition)->count();
        $condition            = ['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')];
        $vm_to_sm_damaged_meter = \DB::table('meter')->where($condition)->count();
        
        $condition            = ['status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_installation_meter     = \DB::table('meter')->where($condition)->count();

        $condition            = ['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','damaged_mark_by_id'=>new MongoId(\Session::get('_id'))];
        $vm_damaged_meter = \DB::table('meter')->where($condition)->count();
        
        $condition            = ['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>''];
        $pending_damaged_meter = \DB::table('meter')->where($condition)->count();

        $data            = [];
        $data['status']  = true;

        $data['all_meter']              = $all_meter;
        $data['select_meter']           = $select_meter;
        $data['edf_meter_poole']        = $edf_meter_poole;
        $data['assigned_meter']         = $assigned_meter;
        $data['reject_meter']           = $reject_meter;
        $data['sm_all_meter']           = $sm_all_meter;
        $data['sm_new_meter']           = $sm_new_meter;
        $data['sm_edf_meter_poole']     = $sm_edf_meter_poole;
        $data['sm_assigned_meter']      = $sm_assigned_meter;
        $data['sm_reject_meter']        = $sm_reject_meter;
        $data['vm_all_meter']           = $vm_all_meter;
        $data['vm_new_meter']           = $vm_new_meter;
        $data['vm_reject_meter']        = $vm_reject_meter;
        $data['edf_sim_poole']          = $edf_sim_poole;
        $data['swh_edf_sim_poole']      = $swh_edf_sim_poole;
        $data['vmwh_edf_sim_poole']     = $vmwh_edf_sim_poole;
        $data['edf_modem_poole']        = $edf_modem_poole;
        $data['swh_edf_modem_poole']    = $swh_edf_modem_poole;
        $data['vmwh_edf_modem_poole']   = $vmwh_edf_modem_poole;
        $data['sm_damaged_meter']       = $sm_damaged_meter;
        $data['vm_to_sm_damaged_meter'] = $vm_to_sm_damaged_meter;
        $data['vm_installation_meter']  = $vm_installation_meter;
        $data['vm_damaged_meter']       = $vm_damaged_meter;
        $data['pending_damaged_meter']  = $pending_damaged_meter;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts1(Request $request)
    {
        $condition           = ['physical_testing_status'=>'sagregated'];
        $all_meter           = \DB::table('meter')->where($condition)->count();
        $condition           = ['physical_testing_status'=>'sagregated','batch_status'=>'Pending','testing_status'=>'Pending'];
        $select_meter        = \DB::table('meter')->where($condition)->count();
        
        $data                           = [];
        $data['status']                 = true;
        $data['all_meter']              = $all_meter;
        $data['select_meter']           = $select_meter;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts2(Request $request)
    {
        $condition       = ['batch_status'=>'Approved','dl_ch_ref'=>''];
        $edf_meter_poole = \DB::table('meter')->where($condition)->count();
        $condition       = ['batch_status'=>'Approved','dl_ch_ref'=>'','s2s_damaged_status'=>'Repaired'];
        $s2s_edf_meter_poole = \DB::table('meter')->where($condition)->count();
        $condition         = ['dl_ch_ref'=>['$ne'=>'']];
        $assigned_meter    = \DB::table('meter')->where($condition)->count();
        $condition         = ['batch_status'=>'Permanent Damage'];
        $edf_meter_pool_all_permanent_damagee    = \DB::table('meter')->where($condition)->count();
        
        $data                           = [];
        $data['status']                 = true;
        $data['edf_meter_poole']        = $edf_meter_poole;
        $data['s2s_edf_meter_poole']    = $s2s_edf_meter_poole;
        $data['assigned_meter']         = $assigned_meter;
        $data['edf_meter_pool_all_permanent_damagee']         = $edf_meter_pool_all_permanent_damagee;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts3(Request $request)
    {
        $reject_meter      = \DB::table('meter')->where('supplier_status','=','admin_approved')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->where('supplier_status','=','admin_approved')->count();
        $_id = \Session::get('_id');

        $condition          = ['whm_system_utility'=>\Session::get('utility')];
        $sm_all_meter       = \DB::table('meter')->where($condition)->count();
        
        $data                           = [];
        $data['status']                 = true;
        $data['reject_meter']           = $reject_meter;
        $data['sm_all_meter']           = $sm_all_meter;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts4(Request $request)
    {
        $condition          = ['status'=>'New Meter'];
        $sm_new_meter       = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')];
        $sm_edf_meter_poole = \DB::table('meter')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['sm_new_meter']           = $sm_new_meter;
        $data['sm_edf_meter_poole']     = $sm_edf_meter_poole;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts5(Request $request)
    {
        $condition          = ['swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')];
        $sm_assigned_meter  = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh'=>new MongoId(\Session::get('_id')),'$or' => [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
        $sm_reject_meter    = \DB::table('meter')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['sm_assigned_meter']      = $sm_assigned_meter;
        $data['sm_reject_meter']        = $sm_reject_meter;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts6(Request $request)
    {
        $condition          = ['swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_all_meter          = \DB::table('meter')->where($condition)->count();
        $condition             = ['swh_inventory_status'=>'Outstock','status'=>'New Meter','vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_new_meter          = \DB::table('meter')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['vm_all_meter']           = $vm_all_meter;
        $data['vm_new_meter']           = $vm_new_meter;
        $data['message']                = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts7(Request $request)
    {
        $condition             = ['status'=>'Rejected','vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_reject_meter       = \DB::table('meter')->where($condition)->count();
        $condition          = ['swh'=>'','vmwh'=>'','mrn_ref'=>'','sim_status'=>'UNUTILISED'];
        $edf_sim_poole      = \DB::table('bsnl_sim')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['vm_reject_meter']        = $vm_reject_meter;
        $data['edf_sim_poole']          = $edf_sim_poole;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts8(Request $request)
    {
        $condition          = ['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
        $swh_edf_sim_poole  = \DB::table('bsnl_sim')->where($condition)->count();
        $condition          = ['vmwh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
        $vmwh_edf_sim_poole = \DB::table('bsnl_sim')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['swh_edf_sim_poole']      = $swh_edf_sim_poole;
        $data['vmwh_edf_sim_poole']     = $vmwh_edf_sim_poole;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts9(Request $request)
    {
        $condition            = ['swh'=>'','vmwh'=>'','mrn_ref'=>'','status'=>'UNUTILISED'];
        $edf_modem_poole      = \DB::table('modem')->where($condition)->count();
        $condition            = ['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
        $swh_edf_modem_poole  = \DB::table('modem')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['edf_modem_poole']        = $edf_modem_poole;
        $data['swh_edf_modem_poole']    = $swh_edf_modem_poole;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts10(Request $request)
    {
        $condition            = ['vmwh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
        $vmwh_edf_modem_poole = \DB::table('modem')->where($condition)->count();
        $condition            = ['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')];
        $sm_damaged_meter     = \DB::table('meter')->where($condition)->count();
        $data                           = [];
        $data['status']                 = true;
        $data['vmwh_edf_modem_poole']   = $vmwh_edf_modem_poole;
        $data['sm_damaged_meter']       = $sm_damaged_meter;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts11(Request $request)
    {
        $condition            = ['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')];
        $vm_to_sm_damaged_meter = \DB::table('meter')->where($condition)->count();
        
        $condition            = ['status'=>'Installed','vmwh'=>new MongoId(\Session::get('_id'))];
        $vm_installation_meter     = \DB::table('meter')->where($condition)->count();
        
        $condition            = ['s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','whm_system_utility'=>\Session::get('utility')];
        $s2s_vm_to_sm_damaged_meter = \DB::table('meter')->where($condition)->count();

        $condition            = ['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_swh'=>'Yes','s2s_is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')];
        $s2s_sm_damaged_meter = \DB::table('meter')->where($condition)->count();
        
        $data                           = [];
        $data['status']                 = true;
        $data['vm_to_sm_damaged_meter'] = $vm_to_sm_damaged_meter;
        $data['vm_installation_meter']  = $vm_installation_meter;
        $data['s2s_vm_to_sm_damaged_meter'] = $s2s_vm_to_sm_damaged_meter;
        $data['s2s_sm_damaged_meter']       = $s2s_sm_damaged_meter;

        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts12_1(Request $request)
    {
        $condition            = ['damaged_mark_by'=>'vm','is_damage_accepted_swh'=>'','damaged_mark_by_id'=>new MongoId(\Session::get('_id'))];
        $vm_damaged_meter = \DB::table('meter')->where($condition)->count();

        $condition            = ['s2s_damaged_mark_by'=>'vm','s2s_is_damage_accepted_swh'=>'','s2s_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))];
        $s2s_vm_damaged_meter = \DB::table('meter')->where($condition)->count();

        
        
        $data                               = [];
        $data['status']                     = true;
        $data['vm_damaged_meter']           = $vm_damaged_meter;
        $data['s2s_vm_damaged_meter']       = $s2s_vm_damaged_meter;
        
        
        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function get_sidebar_counts12_2(Request $request)
    {
        $condition            = ['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>''];
        $pending_damaged_meter = \DB::table('meter')->where($condition)->count();

        $condition            = ['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_admin'=>''];
        $s2s_pending_damaged_meter = \DB::table('meter')->where($condition)->count();
        
        $data                              = [];
        $data['status']                    = true;
        $data['pending_damaged_meter']     = $pending_damaged_meter;
        $data['s2s_pending_damaged_meter'] = $s2s_pending_damaged_meter;


        $data['message'] = 'Fetching Sidebar counts';
        return $data;
    }

    public function dashbord(Request $request)
    {
        $data                   = [];

        if(\Session::get('role')=='1')
        {
            $all_meter         =0; //\DB::table('meter')->count();
            
            $condition         = ['batch_status'=>'Approved','dl_ch_ref'=>''];
            $edf_meter_poole   = 0; //\DB::table('meter')->where($condition)->count();

            $condition         = ['dl_ch_ref'=>['$ne'=>'']/*,'swh'=>['$ne'=>'']*/];
            $assigned_meter    = 0; //\DB::table('meter')->where($condition)->count();

            $condition         = ['physical_testing_status'=>'Tested'];
            $physical_tested   = 0; //\DB::table('meter')->where($condition)->count();
            $data['physical_tested'] = $physical_tested;
        }
        elseif(\Session::get('role')=='2')
        {
            /*$condition = ['swh'=>new MongoId(\Session::get('_id'))];
            //$condition         = ['physical_testing_status'=>'sagregated'];
            $all_meter         = \DB::table('meter')->where($condition)->count();

            $condition = ['swh_inventory_status'=>'Instock','batch_status'=>'Approved','swh'=>new MongoId(\Session::get('_id'))];
            //$condition         = ['batch_status'=>'Approved','dl_ch_ref'=>''];
            $edf_meter_poole   = \DB::table('meter')->where($condition)->count();

            $condition = ['swh_inventory_status'=>'Outstock','swh'=>new MongoId(\Session::get('_id'))];*/
            //$condition         = ['dl_ch_ref'=>['$ne'=>'']/*,'swh'=>['$ne'=>'']*/];
            /*$assigned_meter    = \DB::table('meter')->where($condition)->count();*/
        }
        else
        {
            $condition = ['swh_inventory_status'=>'Outstock','vmwh'=>new MongoId(\Session::get('_id'))];
            $all_meter         = \DB::table('meter')->where($condition)->count();

            $condition         = ['vmwh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'];
            /*All sim*/$edf_meter_poole   = \DB::table('bsnl_sim')->where($condition)->count();

            $condition = ['vmwh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'];
            /*All Modem*/$assigned_meter    = \DB::table('modem')->where($condition)->count();
        }

        $condition         = ['$or' => [ ['batch_status'=>'Rejected'],['testing_status'=>'Rejected'],['status'=>'Rejected'] ]];
        $reject_meter      = 0;//\DB::table('meter')->where($condition)->count();

        $all_sim           = 0;//\DB::table('bsnl_sim')->count();
        $condition         = ['sim_status'=>'UNUTILISED'];
        $unutilised_sim    = 0;//\DB::table('bsnl_sim')->where($condition)->count();
        $condition         = ['sim_status'=>'UTILIZED'];
        $utilized_sim      = 0;//\DB::table('bsnl_sim')->where($condition)->count();
        $all_modem         = 0;//\DB::table('modem')->count();
        
       
        $data['all_meter']      = 0;$all_meter;
        $data['edf_meter_pool'] = 0;$edf_meter_poole;
        $data['assigned_meter'] = 0;$assigned_meter;
        $data['rejected_meter'] = $reject_meter;
        
        $data['all_sim'] = $all_sim;
        $data['utilized_sim'] = $utilized_sim;
        $data['unutilised_sim'] = $unutilised_sim;
        $data['all_modem'] = $all_modem;
        
        return view('admin/dashbord_admin',$data);
    }

    public function forget_password()
    {
        return view('admin/forget_password');
    }

    public function forget_password_process(Request $request)
    {
        if(!empty($request->input('email')))
        {
            $user = \DB::table('users')->where(['email'=>$request->input('email')])->count();
            if($user)
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randstring = '';
                for ($i = 0; $i < 8; $i++) {
                    $randstring.= $characters[rand(0, strlen($characters))];
                }
                
                \DB::table('users')->where(['email'=>$request->input('email')])->update(['password'=>bcrypt($randstring)]);
                $mail = new PHPMailer(true); 
                try {
                    $mail->isSMTP(); 
                    $mail->CharSet    = "utf-8"; 
                    $mail->SMTPAuth   = true;  
                    $mail->SMTPSecure = env('SMTPSECURE');
                    $mail->Host       = env('HOST');
                    $mail->Port       = env('PORT');
                    $mail->Username   = env('USERNAME');
                    $mail->Password   = env('PASSWORD');
                    $mail->setFrom(env('SETFROMEMAIL'), "WHM");
                    $mail->Subject = "Forget Password";
                    $mail->MsgHTML("Your system generated password is ".$randstring."");
                    $mail->addAddress($request->input('email'), "Admin");
                    $mail->send();
                } 
                // catch (phpmailerException $e) 
                // {
                //     dd($e);
                //     Session::flash('error', $e);
                // } 
                catch (Exception $e) 
                {
                    dd($e);
                    Session::flash('error', $e);
                }
                Session::flash('success', 'Success! Please check your email for temporary password. Please login again.');
                return redirect('/login');
            }
            else
            {
                Session::flash('error', 'Error! Invalid email.');
                return \Redirect::back();
            }
        }
    }

    public function change_password()
    {
        return view('admin/change_password');
    }

    public function change_password_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'oldpassword'     => 'required',
                'new_password'    => 'required',
                'confi_password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        dd('This provision is restricted.');
        $data = \Sentinel::check();
        $credentials = [
            'email'    => $data->email,
            'password' => $request->input('oldpassword'),
        ];

        $user = \Sentinel::authenticate($credentials);

        if (!empty($user))
        {
            \DB::table('users')->where(['email'=>$data->email])->update(['password'=>bcrypt($request->input('new_password'))]);
            Session::flash('success', 'Success! Password changed successfully.');
            return \Redirect::back();
        }
        else
        {
            Session::flash('error', 'Error! Old password is wrong.');
            return \Redirect::back();
        }
    } 

    public function change_pagination_limit()
    {
        Session::put('limit',$_GET['limit']);
    } 
    

    public function cron_dump_send_email()
    {
        $html = '<table width="600px" border="0" cellspacing="0" cellpadding="10" style="font-family:Arial,Helvetica,sans-serif;margin:0 auto;border:1px solid #eee;font-size:14px;background-color:#d4e7ff">
        <tbody>
        <tr>
        <td><a href="https://whmuat.edfeesl.com/testing/css_and_js/logo.png" target="_blank"><img width="200" src="https://whmuat.edfeesl.com/testing/css_and_js/logo.png" alt="EDF Logo"></a></td>
        </tr>
        <tr>
        <td></td>
        </tr>
        <tr>
        <td>Dear Team,</td>
        </tr>
        <tr>
        <td>Hope this email finds you well.</td>
        </tr>
        <tr>
        <td>Please find the daily dump of WHM portal with this mail. Download the dump file from the below links:</td>
        </tr>
        <tr>
        <td>1) Meter dump files
                <ul>
                    <li>
                        NBPD Meter Link: <a href="https://whmuat.edfeesl.com/testing/dumps/meter_nbpd.csv.tar.gz" style="color:#000;text-decoration:none;background-color:#d4e7ff" target="_blank"><b>Click here</b></a>
                    </li>
                    <li>
                        SBPD Meter Link: <a href="https://whmuat.edfeesl.com/testing/dumps/meter_sbpd.csv.tar.gz" style="color:#000;text-decoration:none;background-color:#d4e7ff" target="_blank"><b>Click here</b></a>
                    </li>
                    <li>
                        Non-NBPD/SBPD Link: <a href="https://whmuat.edfeesl.com/testing/dumps/meter_non_sbpd_nbpd.csv.tar.gz" style="color:#000;text-decoration:none;background-color:#d4e7ff" target="_blank"><b>Click here</b></a>
                    </li>
                </ul>
                </td>
        </tr>
        <tr>
        <td>2) SIM dump file<a href="https://whmuat.edfeesl.com/testing/dumps/whm_sim_LIVE.csv.tar.gz" style="color:#000;text-decoration:none;background-color:#d4e7ff" target="_blank">
        <b>Click here</b></a> </td>
        </tr>
        <tr>
        <td>3) Modem dump file <a href="https://whmuat.edfeesl.com/testing/dumps/whm_modem_LIVE.csv.tar.gz" style="color:#000;text-decoration:none;background-color:#d4e7ff" target="_blank">
        <b>Click here</b></a> </td>
        </tr>
        <tr>
        <td height="15">&nbsp;</td>
        </tr>
        <tr>
        <td>Thanks,<br>
        Team WHM</td>
        </tr>
        </tbody>
        </table>';
       
        //$headers1 = "MIME-Version: 1.0"."\r\n";
        //$headers1.= "Content-type:text/html;charset=iso-8859-1". "\r\n";
        //$headers1.= "From: wfm.hoh@edf-india.com"."\r\n";
        //$headers1.= "to: vikram.rao@edfin-india.com"."\r\n";
        //$headers1.= "to: ravinath@edfin-india.com"."\r\n";
        //$headers1.= "cc: s.varun@edfin-india.com"."\r\n";
        
        //$headers1.= "cc: nand.lal.4312@gmail.com"."\r\n";
        //$headers1.= "cc: armanali265@gmail.com"."\r\n";

        // $headers1.= "cc: radhika.malik@hohtechlabs.com"."\r\n";
        //$headers1.= "cc: peeush@hohtechlabs.com"."\r\n";
        // $headers1.= "cc: suraj.hoh@gmail.com"."\r\n";
        //$headers1.= "Reply-To: whm.hoh@edf-india.com";
        // mail('mahesh.kumar@edfin-india.com','WHM Daily dump email for '.date('d-m-Y'),$html,$headers1);
        //error_reporting();
        /*$mail = mail('suraj.hoh@gmail.com','WHM Daily dump email for '.date('d-m-Y'),$html,$headers1);
        echo 'success.';
        print_r($mail);
        print_r(error_get_last());die;*/
        $mail = new PHPMailer(true); 
        try {
            $mail->isSMTP(); 
            $mail->isHTML(true);
            $mail->CharSet    = "utf-8"; 
            $mail->SMTPAuth   = true;  
            $mail->SMTPSecure = 'tls';
            $mail->Host       = 'smtp.office365.com';
            $mail->Port       = '587';
            $mail->Username   = 'support@edfin-india.com';
            $mail->Password   = 'QW#@$EdF#';
            $mail->Subject    = 'WHM Daily dump email for '.date('d-m-Y');
            $mail->Body       = $html;
            $mail->setFrom('support@edfin-india.com', "WHM");
            // $mail->addAddress('suraj.hoh@gmail.com', "Admin");
            $mail->addAddress('radhika.malik@hohtechlabs.com', "Admin");
            $mail->addAddress('vikram.rao@edfin-india.com', "Admin");
            $mail->addAddress('ravinath@edfin-india.com', "Admin");
            $mail->addAddress('mahesh.kumar@edfin-india.com', "Admin");
            $mail->addReplyTo("whm.hoh@edf-india.com", "Reply");
            //$mail->addCC("nand.lal.4312@gmail.com"); 
            //$mail->addCC("armanali265@gmail.com"); 
            
            $mail->addCC("nikhil.singh@edfin-india.com"); 
            $mail->addCC("ashutosh1@edfin-india.com"); 
            $mail->addCC("radhika.malik@hohtechlabs.com"); 
            $mail->addCC("peeush@hohtechlabs.com"); 
            $mail->addBCC("suraj.hoh@gmail.com");
            $mail->send();
        } 
        // catch (phpmailerException $e) 
        // {
        //     dd($e);
        //    // Session::flash('error', $e);
        // } 
        catch (Exception $e) 
        {
            dd($e);
            //Session::flash('error', $e);
        }die;
       
    }

    public function logout() 
    {
        Session::flush();
        Session::flash('success', 'Success! Session destroyed successfully');
        return redirect('/login');
    }
}
