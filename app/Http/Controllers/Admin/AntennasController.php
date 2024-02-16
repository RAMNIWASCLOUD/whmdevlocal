<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;

class AntennasController extends Controller
{
    public function __construct()
    {
        $data                    = [];
        //  $this->common_connection   = new \MongoClient(config('app.aliases.DB_URL'));
        // $this->common_db         = $this->common_connection->whm;
        // $this->common_collection = $this->common_db->modem;
        $this->title             = "Antennas";
        $this->url_slug          = "antennas";
        $this->folder_path       = "admin/antennas/";
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

        $cursor     = \DB::table('antennas');
        if(isset($_GET['search']))
        {
            $cursor = $cursor->where(['username' =>$_GET['search'],'is_delete'=>'0']);
        }
        else
        {
            $cursor = $cursor->where(['is_delete'=>'0']);

        }
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
                    $responce = \DB::table('antennas')->where(['modem_number'=>$row[0]])->first();
                    $i++;
                    if(!empty($responce))
                    {
                        $flag = true;
                        array_push($temp, $row[0]);
                    }
                }
            }
        }
        else
        {
            Session::flash('error', "Error! Please upload file.");
            return \Redirect::back();
        }
        
        if($flag)
        {
            Session::flash('error', "Error! Modem No already exists: ".implode($temp, ', '));
            return \Redirect::back();
        }
 
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
                    $new_data                    = [];
                    $new_data['antena_number']    = $row[0];
                    $new_data['status']          = 'UNUTILISED';
                    $new_data['date']            = date('d-m-Y h:i:s');

                    $new_data['swh']                      = '';
                    $new_data['swh_name']                 = '';
                    $new_data['last_modem_location']      = '';
                    $new_data['last_modem_location_time'] = '';
                    $new_data['swh_delivery_time']        = '';
                    $new_data['swh_inventory_status']     = '';
                    $new_data['mrn_ref']                  = '';
                    $new_data['dl_ch_ref']                = '';
                    $new_data['vmwh_mrn_ref']           = '';
                    $new_data['vmwh_dl_ch_ref']         = '';

                    $new_data['vmwh']                   = '';
                    $new_data['vmwh_name']              = '';
                    $new_data['vmwh_delivery_time']     = '';
                    $new_data['is_delete']     = '0';

                    if(!empty($row[0]))
                    {
                        $responce = \DB::table('antennas')->insert($new_data);     
                    }
                    $i++;
                }
            }
            Session::flash('success', 'Success! .CSV uploded successfully.');
            return \Redirect::back();
            //return \Redirect::to('manage_'.$this->url_slug);
        }
        
        Session::flash('error', "Error! Oop's something went wrong.");
        return \Redirect::back();
    }
}
