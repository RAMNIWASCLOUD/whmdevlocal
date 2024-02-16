<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;

class SealstocknewController extends Controller
{
    public function __construct()
    {
        $data                    = [];
         //$this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        //$this->common_db         = $this->common_connection->whm;
        //$this->common_collection = $this->common_db->seal_stock;
        $this->title             = "Antennas";
        $this->url_slug          = "sealstock";
        $this->folder_path       = "admin/sealstock/";
    }

    public function index()
    {
        $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit      = (!empty(Session::get('limit')))? (int)Session::get('limit') : 10;
        $skip       = ($page - 1) * $limit;
        $next       = ($page + 1);
        $prev       = ($page - 1);
        $sort       = array('_id' => -1);
        $condition  = [];
        $cursor     = \DB::table('seal_stock');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['username' =>$_GET['search'],'is_delete'=>'0']);
        }
        else
        {
            $cursor = $cursor->where(['is_delete'=>'0']);

        }
        //dd($condition);
        $cursor     = $cursor/*->skip($skip)->limit($limit)->orderBy('createdAt','ASC')*/->paginate($limit);

        $total      = '0';//$cursor->count();

        $available_stock = 0;
        foreach ($cursor as $key => $value) 
        {
            $available_stock = $available_stock + $value['new_stock'];
        }
        $data['page']      = $page;
        $data['limit']     = $limit;
        $data['available_stock']     = $available_stock;
        $data['total']     = $total/$limit;
        $data['prev']      = $prev;
        $data['next']      = $next;
        $data['data']      = $cursor;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }

    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
                'new_stock'          => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

       
        $new_data                      = [];
        $new_data['new_stock']         = $request->input('new_stock');
        $new_data['date']              = date('d-m-Y h:i:s');
        $new_data['is_delete']         = '0';
       

        $responce = \DB::table('seal_stock')->insert($new_data);
        if (!empty($responce))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('manage_sealstock');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
    
}
