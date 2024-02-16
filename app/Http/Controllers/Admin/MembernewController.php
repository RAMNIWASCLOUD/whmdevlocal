<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use \MongoDB\BSON\ObjectID as MongoId;
class MembernewController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        /* $this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db         = $this->common_connection->whm;
        $this->common_collection = $this->common_db->login_users;*/
        $this->title             = "Users";
        $this->url_slug          = "member";
        $this->folder_path       = "admin/member/";
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
         $cursor     = \DB::table('login_users');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where('role','!=','1')->where(['is_delete'=>'0'])->where('username','like', '%'.$_GET['search'].'%');
        }
        else
        {
            $cursor = $cursor->where('role','!=','1')->where(['is_delete'=>'0']);

        }
        //dd($condition);
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
        return view($this->folder_path.'index',$data);
    }

     public function assign_mrn_authority(Request $request)
    {
        foreach ($_GET['checkbox_id'] as $key => $value) 
        {
            $arr_data                     = [];
            //$arr_data['mrn_authorized_1'] = $request->input('assignee');
            $arr_data['mrn_authorized_2'] = $request->input('assignee1');
            $respone                      = \DB::table('login_users')->where(['_id'=>new MongoId($value)])->update($arr_data);
           
        }
        
            Session::flash('success', 'Success! Record updated successfully.');
            return \Redirect::to('manage_member');

    }   
 
    public function add()
    {
       
        $cursor     = \DB::table('login_users')->where(['role'=>'2'])->get();
        $data['sw_list'] = $cursor;
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'username'          => 'required',
                'role'              => 'required',
                'password'          => 'required',
                'confimed_password' => 'required',
                'warehouse_name'    => 'required',
                'warehouse_address' => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $cursor     = \DB::table('login_users')->where(['username'=>$request->input('username')])->first();
        if(!empty($cursor))
        {
            Session::flash('error', "Email(Username) already exist!");
            return \Redirect::back();
        }

        $new_data                      = [];
        $new_data['username']          = $request->input('username');
        $new_data['role']              = $request->input('role');
        $new_data['password']          = md5($request->input('password'));
        $new_data['state']             = $request->input('state');
        $new_data['city']              = $request->input('city');
        $new_data['warehouse_name']    = $request->input('warehouse_name');
        $new_data['warehouse_address'] = $request->input('warehouse_address');
        $new_data['parent_sw']         = new MongoId($request->input('sw'));
        $new_data['is_delete']  = "0";

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
        $sw  = \DB::table('login_users')->where(['_id'=>new MongoId($request->input('sw'))])->first();
        if(!empty($sw)){
            $new_data['utility']  = $sw['utility'];   
        }
        else
        {
            $new_data['utility']  = "";
        }

        $responce = \DB::table('login_users')->insert($new_data);
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

    public function view($id)
    {
        $cursor     = \DB::table('login_users')->where(['_id'=>new MongoId($id)])->first();
        
        if(!$cursor)
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

    public function edit($id)
    {
        $cursor     = \DB::table('login_users')->where(['_id'=>new MongoId($id)])->first();;
        
        if(!$cursor)
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = $cursor;
        $cursor     = \DB::table('login_users')->where(['role'=>'2'])->get();
        $data['sw_list'] = $cursor;
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
        
        $cursor     = \DB::table('login_users')->where('_id','!=',new MongoId($id))->where(['username'=>$request->input('username')])->first();
        
        if(!empty($cursor))
        {
            Session::flash('error', "Email(Username) already exist!");
            return \Redirect::back();
        }
        $new_data['state']             = $request->input('state');
        $new_data['city']              = $request->input('city');
        if($request->input('role')=='1')
        {
            $new_data  = ["username" => $request->input('username'),"role" => $request->input('role'),"warehouse_name" => $request->input('warehouse_name'),"warehouse_address" => $request->input('warehouse_address')];
        }
        elseif($request->input('role')=='2')
        {
            $new_data  = ["username" => $request->input('username'),"role" => $request->input('role'),"state" => $request->input('state'),"warehouse_name" => $request->input('warehouse_name'),"warehouse_address" => $request->input('warehouse_address')];
            $new_data['utility']  = $request->input('utility');   

        }
        else
        {
            $new_data  = ["username" => $request->input('username'),"role" => $request->input('role'),"state" => $request->input('state'),"city" => $request->input('city'),"warehouse_name" => $request->input('warehouse_name'),"warehouse_address" => $request->input('warehouse_address'),"parent_sw" => new MongoId($request->input('sw'))];
            $sw  = \DB::table('login_users')->where(['_id'=>new MongoId($request->input('sw'))])->first();
            if(!empty($sw)){
                $new_data['utility']  = $sw['utility'];   
            }
        }
        $responce  = \DB::table('login_users')->where(['_id'=>new MongoId($id)])->update($new_data);
        
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('manage_'.$this->url_slug);
        /*if (!empty($responce))
        {
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }*/
    }

    public function delete($id)
    {
        $responce  = \DB::table('login_users')->where(['_id'  => new MongoId($id)])->update(["is_delete" => '1']);
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
