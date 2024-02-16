<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use \MongoDB\BSON\ObjectID as MongoId;
class StateController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        /* $this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db         = $this->common_connection->whm;
        $this->common_collection = $this->common_db->login_users;*/
        $this->title             = "State";
        $this->url_slug          = "state";
        $this->folder_path       = "admin/state/";
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
         $cursor     = \DB::table('state');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['state' =>$_GET['search'],'is_delete'=>'0']);
        }
        else
        {
            $cursor = $cursor->where(['is_delete'=>'0']);

        }
            //$cursor = $cursor->where(['role'=>'1']);
        //dd($condition);
        $cursor     = $cursor->skip($skip)->limit($limit)->orderBy('createdAt','ASC')->get();
        
        $total      = $cursor->count();
        
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
 
    public function add()
    {
       
        $cursor     = \DB::table('state')->where(['role'=>'2'])->get();
        $data['sw_list'] = $cursor;
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'state'          => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $cursor     = \DB::table('state')->where(['state'=>$request->input('state'),'is_delete'=>'0'])->first();
        if(!empty($cursor))
        {
            Session::flash('error', "State already exist!");
            return \Redirect::back();
        }

        $new_data                      = [];
        $new_data['state']          = $request->input('state');
       
        $new_data['is_delete']  = "0";

        $responce = \DB::table('state')->insert($new_data);
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
        $cursor     = \DB::table('state')->where(['_id'=>new MongoId($id)])->first();
        
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
        $cursor     = \DB::table('state')->where(['_id'=>new MongoId($id)])->first();;
        
        if(!$cursor)
        {
            Session::flash('error', "Something went wrong! Please try again.");
            return \Redirect::back();
        }

        $data['data']      = $cursor;
        $cursor     = \DB::table('state')->where(['role'=>'2'])->get();
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
                'state'          => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $cursor     = \DB::table('state')->where('_id','!=',new MongoId($id))->where(['state'=>$request->input('state'),'is_delete'=>'0'])->first();
        
        if(!empty($cursor))
        {
            Session::flash('error', "Email(Username) already exist!");
            return \Redirect::back();
        }
        
        $new_data = [];
        $new_data['state']             = $request->input('state');
        
       
       
        $responce  = \DB::table('state')->where(['_id'=>new MongoId($id)])->update($new_data);
        
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('manage_'.$this->url_slug);
    }

    public function delete($id)
    {
        $responce  = \DB::table('state')->where(['_id'  => new MongoId($id)])->update(["is_delete" => '1']);
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
