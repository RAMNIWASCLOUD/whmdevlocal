<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Validator;
use \MongoDB\BSON\ObjectID as MongoId;
class CronController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', '1200');
        $data                    = [];
        $this->title             = "Users";
        $this->url_slug          = "member";
        $this->folder_path       = "admin/member/";
    }

    public function cron_get_all_installed_meter()
    {


        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://10.9.1.27/api/get_installed_meters_whm',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'today_date=2022-11-15',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            dd($error_msg);
        }
        curl_close($curl);

        dd($response);



        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => "https://wfm.edfeesl.com/api/get_installed_meters_whm",
            CURLOPT_POST           => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) {
            echo $err;
        }
        dd($result);
        $result = json_decode($result);
        curl_close($ch);
        $i = 0;
        $batch_grn_no     = \DB::table('meter')->where('batch_id','!=','')->groupBy('batch_id')->count();
        $date_time= time();
        if(isset($result->details))
        {
            foreach ($result->details as $key => $value) 
            {
                $responce =  \DB::table('meter')->where(['manufacturer_serial_number'=>$value->manufacturer_serial_number])->first();

                /*if(empty($responce))
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
                            $new_data['sim_no']                     = $details[9];
                            $new_data['imei_no']                    = $details[10];
                            $new_data['sim_no2']                    = $details[11];
                            $new_data['batch_supplier']             = $details[12];

                            $new_data['consumer_id']             = $value->consumer_id;
                            $new_data['edf_vendor_manager_name'] = $value->edf_vendor_manager_name;
                            $new_data['edf_vendor_plan_name']    = $value->edf_vendor_plan_name;
                            $new_data['field_worker']            = $value->field_worker;
                            $new_data['edf_status']              = 'Installed';
                            $new_data['antenna']                 = $value->antenna;
                            $new_data['installation_date_time']  = date('Y-m-d h:s:i',strtotime($value->installation_date_time));

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
                            $new_data['current_meter_status']             = 'Unknown';
                            $new_data['status']                           = 'Unknown';
                            $new_data['testing_status']                   = 'Unknown';
                            $new_data['testing_type']                     = '';
                            $new_data['meter_reject_reason']              = '';
                            $new_data['meter_reject_images']              = '';
                            $new_data['testing_time']                     = '';
                            $new_data['batch_status']                     = 'Unknown';
                            $new_data['batch_reject_reason']              = '';
                            $new_data['physical_testing_status']          = 'Unknown';
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



                            $new_data['whm_system_utility']               = '';
                            $new_data['whm_system_utility_id']            = '';
                            $new_data['sm_damaged_mark_by']               = '';
                            $new_data['damaged_mark_by']                  = '';
                            $new_data['swh_inventory_status']             = 'NA';
                            $new_data['latitude']                         = '';
                            $new_data['longitude']                        = '';
                            $new_data['last_meter_location']              = 'Consumer:'.$value->consumer_id;
                            $new_data['last_meter_location_time']         = time();
                            $new_data['meter_created_at']                 = date('d/m/Y h:i:s A');


                    $new_data                                                   = [];
                    $new_data['batch_invoice_no']                               = '';
                    $new_data['batch_invoice_date']                             = '';
                    $new_data['batch_waybill_no']                               = '';
                    $new_data['batch_waybill_date']                             = '';

                    $new_data['device_id']                                      = $value->device_id;
                    $new_data['manufacturer_serial_number']                     = $value->manufacturer_serial_number;
                    $new_data['device_type']                                    = $value->device_type;
                    $new_data['device_subtype']                                 = $value->device_subtype;
                    $new_data['device_model_number']                            = $value->device_model_number;
                    $new_data['device_manufacturer_abbreviation']               = $value->device_manufacturer_abbreviation;
                    $new_data['device_manufacturing_year']                      = $value->device_manufacturing_year;
                    $new_data['device_calibration_year']                        = $value->device_calibration_year;
                    $new_data['device_protocol']                                = $value->device_protocol;
                    $new_data['device_protocol_version']                        = $value->device_protocol_version;
                    $new_data['device_mac_address']                             = $value->device_mac_address;
                    $new_data['device_firmware_version']                        = $value->device_firmware_version;
                    $new_data['device_configuration_version']                   = $value->device_configuration_version;
                    $new_data['device_display_register_digit']                  = $value->device_display_register_digit;
                    $new_data['device_communication_technology']                = $value->device_communication_technology;
                    $new_data['device_communication_module_model']              = $value->device_communication_module_model;
                    $new_data['device_communication_module_serial_number']      = $value->device_communication_module_serial_number;
                    $new_data['device_communication_module_manufacturing_year'] = $value->device_communication_module_manufacturing_year;
                    $new_data['device_communication_module_firmware_version']   = $value->device_communication_module_firmware_version;
                    $new_data['device_communication_module_imei_number']        = $value->device_communication_module_imei_number;
                    $new_data['dlms_tcp_port']                                  = $value->dlms_tcp_port;
                    $new_data['dlms_communication_profile']                     = $value->dlms_communication_profile;
                    $new_data['dlms_client_id']                                 = $value->dlms_client_id;
                    $new_data['dlms_master_key']                                = $value->dlms_master_key;
                    $new_data['dlms_authentication_key']                        = $value->dlms_authentication_key;
                    $new_data['dlms_guc']                                       = $value->dlms_guc;
                    $new_data['dlms_security_secret']                           = $value->dlms_security_secret;
                    $new_data['dlms_security_policy']                           = $value->dlms_security_policy;
                    $new_data['dlms_authentication_mechanism']                  = $value->dlms_authentication_mechanism;
                    $new_data['dlms_security_suite']                            = $value->dlms_security_suite;
                    $new_data['dlms_companion']                                 = $value->dlms_companion;
                    $new_data['dlms_companion_version']                         = $value->dlms_companion_version;
                    $new_data['device_utilityid']                               = $value->device_utilityid;
                    $new_data['utility']                                        = $value->utility;
                    $new_data['iccid']                                          = $value->iccid;

                    $new_data['batch_id']                         = '';
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
                    $new_data['current_meter_status']             = 'Unknown';
                    $new_data['status']                           = 'Unknown';
                    $new_data['testing_status']                   = 'Unknown';
                    $new_data['testing_type']                     = '';
                    $new_data['meter_reject_reason']              = '';
                    $new_data['meter_reject_images']              = '';
                    $new_data['testing_time']                     = '';
                    $new_data['batch_status']                     = 'Unknown';
                    $new_data['batch_reject_reason']              = '';
                    $new_data['physical_testing_status']          = 'Unknown';
                    $new_data['physical_testing_time']            = '';
                    $new_data['physical_meter_reject_images']     = '';
                    $new_data['physical_meter_reject_reason']     = '';
                    $new_data['whm_system_utility']               = '';
                    $new_data['whm_system_utility_id']            = '';
                    $new_data['swh_inventory_status']             = 'NA';
                    $new_data['latitude']                         = '';
                    $new_data['longitude']                        = '';
                    $new_data['last_meter_location']              = 'Consumer:'.$value->consumer_id;
                    $new_data['last_meter_location_time']         = time();
                    $new_data['meter_created_at']                 = date('d/m/Y h:i:s A');

                    $new_data['consumer_id']             = $value->consumer_id;
                    $new_data['edf_status']              = 'Installed';
                    $new_data['edf_vendor_manager_name'] = $value->edf_vendor_manager_name;
                    $new_data['edf_vendor_plan_name']    = $value->edf_vendor_plan_name;
                    $new_data['field_worker']            = $value->field_worker;
                    $new_data['antenna']            = $value->antenna;
                    $new_data['installation_date_time']  = date('Y-m-d h:s:i',strtotime($value->installation_date_time));
                     \DB::table('meter')->insert($new_data);
                }
                else
                {*/
                    $new_data                             = [];

                    $new_data['last_meter_location']      = 'Consumer:'.$value->consumer_id;
                    $new_data['last_meter_location_time'] = strtotime(date('Y-m-d h:s:i',strtotime($value->installation_date_time)));
                    //$new_data['meter_created_at']         = date('d/m/Y h:i:s A');
                    $new_data['consumer_id']              = $value->consumer_id;
                    $new_data['edf_status']               = 'Installed';
                    $new_data['edf_vendor_manager_name']  = $value->edf_vendor_manager_name;
                    $new_data['edf_vendor_plan_name']     = $value->edf_vendor_plan_name;
                    $new_data['field_worker']             = $value->field_worker;
                    $new_data['installation_date_time']   = date('Y-m-d h:s:i',strtotime($value->installation_date_time));
                    dd($new_data);
                    \DB::table('meter')->where(['manufacturer_serial_number'=>$value->manufacturer_serial_number])->update($new_data);
                //}

                $i++;


                /*$responce =  \DB::table('bsnl_sim')->where(['imsi'=>$details[19]])->first();

                if(!empty($responce))
                {
                    $condition = ['_id'=>$details[19]];
                    $responce  = \DB::table('bsnl_sim')->where(['imsi'=>$details[19]])->update(["sim_status" => 'UTILIZED']);
                }*/
            }
        }
                echo 'success:'.$i;
        
    }


    public function cron_get_origin()
    {
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => "http://uat.edfeesl.com:3003/api/getOriginList",
            CURLOPT_POST           => false,
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) {
            echo $err;
        }
        $result = json_decode($result);

        curl_close($ch);
        $i = 0;
        if(isset($result->data))
        {
            $temp = [];
            foreach ($result->data as $key => $value) 
            {
                $c = \DB::table('login_users')->where('username','like','%'.$value->email.'%')->first();
                if(!empty($c))
                {
                    \DB::table('login_users')->where(['_id'=>new MongoId($c['_id'])])->update(['origin_name'=>$value->name,'origin_email'=>$value->email,'origin_user_id'=>$value->user_id]);
                }
            }
        }
        echo 'success';
    }

    public function cron_daily_meter_inventory()
    {
        $GOE_meter_3G = \DB::table('meter')->where([/*'batch_status'=>'Approved',*/'dl_ch_ref'=>'','batch_supplier'=>'Genus 3G'])->count();
        $GOE_meter_4G = \DB::table('meter')->where([/*'batch_status'=>'Approved',*/'dl_ch_ref'=>'','batch_supplier'=>'Genus 4G'])->count();
        $L_T_meter_    = \DB::table('meter')->where([/*'batch_status'=>'Approved',*/'dl_ch_ref'=>'','batch_supplier'=>'L&T'])->count();

        $L_T_meter = \DB::table('daily_meter_inventory')->where(['date'=>date('Y-m-d')])->count();
        if($L_T_meter)
        {
            \DB::table('daily_meter_inventory')->where(['meter'=>'Genus 3G','date'=>date('Y-m-d')])->update(['Opening_stock'=>$GOE_meter_3G]);
            \DB::table('daily_meter_inventory')->where(['meter'=>'Genus 4G','date'=>date('Y-m-d')])->update(['Opening_stock'=>$GOE_meter_4G]);
            \DB::table('daily_meter_inventory')->where(['meter'=>'L&T','date'=>date('Y-m-d')])->update(['Opening_stock'=>$L_T_meter_]);

        }
        else
        {
            \DB::table('daily_meter_inventory')->insert(['meter'=>'Genus 3G','date'=>date('Y-m-d'),'Opening_stock'=>$GOE_meter_3G]);
            \DB::table('daily_meter_inventory')->insert(['meter'=>'Genus 4G','date'=>date('Y-m-d'),'Opening_stock'=>$GOE_meter_4G]);
            \DB::table('daily_meter_inventory')->insert(['meter'=>'L&T','date'=>date('Y-m-d'),'Opening_stock'=>$L_T_meter_]);
        }
        echo 'success';
    }

    public function cron_daily_meter_inventory_map_with_vendor()
    {

        $vendor = \DB::table('login_users')->where(['role'=>'3'])->get();
        foreach ($vendor as $key => $value) 
        {            
            $opening_stock = \DB::table('meter')->where([['swh_inventory_status'=>'Instock','batch_status'=>'Approved','vmwh'=>new MongoId($value['_id'])]])->count();
            $installed = \DB::table('meter')->where('installation_flag','!=','')->where(['vmwh'=>new MongoId($value['_id'])])->count();
            \DB::table('login_users')->where(['_id'=>new MongoId($value['_id'])])->update(['opening_stock'=>$opening_stock,'installed'=>$installed,'meter_available_with_them'=>$opening_stock]);
        }
       
       
        echo 'success';
    }

    public function api_dashboard_get_admin_c()
    {
        $data                          = [];
        $data['bfc_sim_total']         = \DB::table('bsnl_sim')->count();
        $data['bfc_sim_utilized']      = \DB::table('bsnl_sim')->where(['sim_status'=>'UTILIZED'])->count();
        $data['bfc_sim_unutilized']    = \DB::table('bsnl_sim')->where(['sim_status'=>'UNUTILISED'])->count();
        $data['bfc_modem_total']       = \DB::table('modem')->count();
        $data['bfc_modem_ok']          = \DB::table('modem')->count();
        $data['bfc_modem_defective']   = 0;
        $seal_stock                    = \DB::table('seal_stock')->get();
        $available_stock = 0;
        foreach ($seal_stock as $key => $value) 
        {
            $available_stock = $available_stock + $value['new_stock'];
        }
        $data['bfc_antenna_ok']        = $data['bfc_antenna_total']     = $available_stock;
        $data['bfc_antenna_defective'] = 0;
        return $data;
    }

    public function api_dashboard_get_admin_c1()
    {
        $data                          = [];
        $data['bfc_sim_total']         = \DB::table('bsnl_sim')->count();
        $data['bfc_sim_utilized']      = \DB::table('bsnl_sim')->where(['sim_status'=>'UTILIZED'])->count();
        $data['bfc_sim_unutilized']    = \DB::table('bsnl_sim')->where(['sim_status'=>'UNUTILISED'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_c2()
    {
        $data                          = [];
        $data['bfc_modem_total']       = \DB::table('modem')->count();
        $data['bfc_modem_ok']          = \DB::table('modem')->count();
        $data['bfc_modem_defective']   = 0;
        return $data;
    }

    public function api_dashboard_get_admin_c3()
    {
        $data                          = [];
        $seal_stock                    = \DB::table('seal_stock')->get();
        $available_stock = 0;
        foreach ($seal_stock as $key => $value) 
        {
            $available_stock = $available_stock + $value['new_stock'];
        }
        $data['bfc_antenna_ok']        = $data['bfc_antenna_total']     = $available_stock;
        $data['bfc_antenna_defective'] = 0;
        return $data;
    }

    /*public function api_dashboard_get_admin_meter_bfc_c()
    {
        $data             = [];
        $data['lnt']      = \DB::table('meter')->where(['batch_supplier'=>'L&T'])->count();
        $data['genus_3g'] = \DB::table('meter')->where(['batch_supplier'=>'Genus 3G'])->count();
        $data['genus_4g'] = \DB::table('meter')->where(['batch_supplier'=>'Genus 4G'])->count();

        $data['sbpd_lnt_1ph']      = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['sbpd_lnt_3ph']      = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['sbpd_genus_3g_1ph'] = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['sbpd_genus_3g_3ph'] = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['sbpd_genus_4g_1ph'] = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['sbpd_genus_4g_3ph'] = \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();

        $data['nbpd_lnt_1ph']      =  \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['nbpd_lnt_3ph']      =  \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['nbpd_genus_3g_1ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['nbpd_genus_3g_3ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['nbpd_genus_4g_1ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['nbpd_genus_4g_3ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();

        $data['lnt_1ph']      = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['lnt_3ph']      = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['genus_3g_1ph'] = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['genus_3g_3ph'] = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['genus_4g_1ph'] = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['genus_4g_3ph'] = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();

        $data['edf_pool_lnt_1ph']      = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['edf_pool_lnt_3ph']      = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['edf_pool_genus_3g_1ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['edf_pool_genus_3g_3ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['edf_pool_genus_4g_1ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['edf_pool_genus_4g_3ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();

        $data['assigned_lnt_1ph']      = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['assigned_lnt_3ph']      = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['assigned_genus_3g_1ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['assigned_genus_3g_3ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['assigned_genus_4g_1ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['assigned_genus_4g_3ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();


        $data['unsigned_lnt_1ph']      = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['unsigned_lnt_3ph']      = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['unsigned_genus_3g_1ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['unsigned_genus_3g_3ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['unsigned_genus_4g_1ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['unsigned_genus_4g_3ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();


        $data['damage_lnt_1ph']      = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['damage_lnt_3ph']      = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        $data['damage_genus_3g_1ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['damage_genus_3g_3ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['damage_genus_4g_1ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['damage_genus_4g_3ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();

        return $data;
    }*/

     public function api_dashboard_get_admin_meter_bfc_c2()
    {
        $data             = [];
        $data['lnt']      = \DB::table('meter')->where(['batch_supplier'=>'L&T'])->count();
        $data['genus_3g'] = \DB::table('meter')->where(['batch_supplier'=>'Genus 3G'])->count();
        $data['genus_4g'] = \DB::table('meter')->where(['batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c3_1()
    {
        $data             = [];
        $data['sbpd_lnt_1ph']      = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['sbpd_lnt_3ph']      = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c3_2()
    {
        $data             = [];
        $data['sbpd_genus_3g_1ph'] = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['sbpd_genus_3g_3ph'] = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c3_3()
    {
        $data             = [];
        $data['sbpd_genus_4g_1ph'] = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['sbpd_genus_4g_3ph'] = \DB::table('meter')->where(['whm_system_utility'=>'SBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c4_1()
    {
        $data             = [];
        $data['nbpd_lnt_1ph']      =  \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['nbpd_lnt_3ph']      =  \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c4_2()
    {
        $data             = [];
        $data['nbpd_genus_3g_1ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['nbpd_genus_3g_3ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c4_3()
    {
        $data             = [];
        $data['nbpd_genus_4g_1ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['nbpd_genus_4g_3ph'] =  \DB::table('meter')->where(['whm_system_utility'=>'NBPD','phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c5_1()
    {
        $data             = [];
        $data['lnt_1ph']  = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['lnt_3ph']  = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c5_2()
    {
        $data             = [];
        $data['genus_3g_1ph'] = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['genus_3g_3ph'] = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c5_3()
    {
        $data             = [];
        $data['genus_4g_1ph'] = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['genus_4g_3ph'] = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c6_1()
    {
        $data             = [];
        $data['edf_pool_lnt_1ph']      = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['edf_pool_lnt_3ph']      = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c6_2()
    {
        $data             = [];
        $data['edf_pool_genus_3g_1ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['edf_pool_genus_3g_3ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c6_3()
    {
        $data             = [];
        $data['edf_pool_genus_4g_1ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['edf_pool_genus_4g_3ph'] = \DB::table('meter')->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c7_1()
    {
        $data             = [];
        $data['assigned_lnt_1ph']      = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['assigned_lnt_3ph']      = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c7_2()
    {
        $data             = [];
        $data['assigned_genus_3g_1ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['assigned_genus_3g_3ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c7_3()
    {
        $data             = [];
        $data['assigned_genus_4g_1ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['assigned_genus_4g_3ph'] = \DB::table('meter')->where('dl_ch_ref','!=','')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c8_1()
    {
        $data             = [];
        $data['unsigned_lnt_1ph']      = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['unsigned_lnt_3ph']      = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c8_2()
    {
        $data             = [];
        $data['unsigned_genus_3g_1ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['unsigned_genus_3g_3ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c8_3()
    {
        $data             = [];
        $data['unsigned_genus_4g_1ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['unsigned_genus_4g_3ph'] = \DB::table('meter')->where('batch_status','!=','Approved')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c9_1()
    {
        $data             = [];
        $data['damage_lnt_1ph']      = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'])->count();
        $data['damage_lnt_3ph']      = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c9_2()
    {
        $data             = [];
        $data['damage_genus_3g_1ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'])->count();
        $data['damage_genus_3g_3ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_meter_bfc_c9_3()
    {
        $data             = [];
        $data['damage_genus_4g_1ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'])->count();
        $data['damage_genus_4g_3ph'] = \DB::table('meter')->where(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->orwhere(['physical_testing_status'=>'Damaged'])->orwhere(['is_damage_accepted_admin'=>'Yes'])->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'])->count();
        return $data;
    }

    public function api_dashboard_get_admin_all_meter()
    {
        $data                           = [];
        $data['Received_Meter']         = \DB::table('meter')->count();
        $data['Test_Report']            = \DB::table('meter')->where(['physical_testing_status'=>'Pending'])->count();
        $data['Physical_Tested']        = \DB::table('meter')->where(['physical_testing_status'=>'Tested'])->count();
        $data['Physical_Damage']        = \DB::table('meter')->where(['physical_testing_status'=>'Rejected'/*'Damaged'*/,'date_of_dispatch_to_OEM_repair'=>''])->count();
        $data['Pending_Damaged_Meter']  = \DB::table('meter')->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_admin'=>''])->count();
        $data['Accepted_Damaged_Meter'] = \DB::table('meter')->where(['sm_damaged_mark_by'=>'sm'])->where('is_damage_accepted_admin','=','Yes')->count();
        $data['Sent_To_Supplier']       = \DB::table('meter')->where(['supplier_status'=>'pending'])->count();
        $data['Return_From_Supplier']   = \DB::table('meter')->where(['supplier_status'=>'approved'])->count();
        $data['Repaired_Meter']         = \DB::table('meter')->where(['damaged_status'=>'Repaired','vmwh_mrn_ref'=>''])->count();
        $data['All_MRN']                = \DB::table('mrn')->count();
        $data['Dispatch']               = \DB::table('meter')->where(['swh_inventory_status'=>'Outstock'])->count();//\DB::table('mrn')->where('dl_ch_ref','!=','')->count();
        $data['pending_utility_map']    = \DB::table('meter')->where(['physical_testing_status'=>'Tested'])->count();

        /*$data['s2s_pending_damaged_meter']  = \DB::table('s2s_meter_history')->where(['s2s_sm_damaged_mark_by'=>'sm','s2s_is_damage_accepted_admin'=>''])->count();
        $data['s2s_accepted_damaged_meter'] = \DB::table('s2s_meter_history')->where(['s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','Yes')->count();
        $data['s2s_sent_to_supplier']       = \DB::table('s2s_meter_history')->where(['s2s_supplier_status'=>'pending'])->count();
        $data['s2s_return_from_supplier']   = \DB::table('s2s_meter_history')->where(['s2s_supplier_status'=>'approved'])->count();
        $data['s2s_repaired_meter']         = \DB::table('s2s_meter_history')->where(['s2s_damaged_status'=>'Repaired'])->count();*/

        /*$data['Total_S2S_received_at_WH']  = \DB::table('s2s_meter_history')->count();
        $data['Total_S2S_Pending_With_EDF_WH']  = \DB::table('s2s_meter_history')->where(['s2s_supplier_status'=>''])->count();
        $data['Total_S2S_Pending_With_Supplier']  = \DB::table('s2s_meter_history')->where(['s2s_supplier_status'=>'pending'])->count();
        $data['Total_S2S_Repaired_in_WH']  = \DB::table('s2s_meter_history')->where(['s2s_damaged_status'=>'Repaired'])->count();*/
        $data['Total_S2S_received_at_WH']  = \DB::table('meter')->where(['s2s_damaged_mark_by'=>'vm'])->count();
        $data['Total_S2S_Pending_With_EDF_WH']  = \DB::table('meter')->where(['s2s_sm_damaged_mark_by'=>'sm'])->where('s2s_is_damage_accepted_admin','=','Yes')->count();
        $data['Total_S2S_Pending_With_Supplier']  = \DB::table('meter')->where(['s2s_supplier_status'=>'pending'])->count();
        $data['Total_S2S_Repaired_in_WH']  = \DB::table('meter')->where(['s2s_damaged_status'=>'Repaired'])->count();

        $data['Total_S2S_repaired_installed_in_Field']  = \DB::table('s2s_meter_history')->where(['s2s_damaged_status'=>'Repaired'])->where(['edf_status'=>'Installed'])->count();
        $data['Total_S2S_Repaired_Available_in_Field']  = \DB::table('s2s_meter_history')->where(['s2s_damaged_status'=>'Repaired'])->where(['edf_status'=>'','swh_inventory_status'=>'Outstock'])->count();
        
        $data['Permanent_Damage']  = \DB::table('meter')->where(['damaged_status'=>'Permanent Damage'])->count();
        $data['s2s_Permanent_Damage']  = \DB::table('meter')->where(['s2s_damaged_status'=>'Permanent Damage'])->count();
        
        
        return $data;
    }

    public function api_dashboard_get_admin_meter_c()
    {
        $vm_t_meter_c = \DB::table('meter');
        
        if(\Session::get('role')=='2')
        {
            $vm_t_meter_c = $vm_t_meter_c->where([/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
        }
        $vm_t_meter_c = $vm_t_meter_c->count();

        $vm_d_meter_c = \DB::table('meter');
        if(\Session::get('role')=='2')
        {
            $vm_d_meter_c = $vm_d_meter_c->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_swh'=>'Yes','is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')]);
        }
        if(\Session::get('role')=='1')
        {
            $vm_d_meter_c = $vm_d_meter_c->where(['sm_damaged_mark_by'=>'sm','damaged_status'=>'Damaged']);
            $vm_d_meter_c = $vm_d_meter_c->orwhere(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected']);
        }
        $vm_d_meter_c = $vm_d_meter_c->count();


        $res = [];
        $res['t_meter_c'] = $vm_t_meter_c;
        $res['d_meter_c'] = $vm_d_meter_c;
        return $res;
    }


    public function api_dashboard_admin_intransist_loader_c()
    {
        $admin_t_intransit_c = \DB::table('meter');
        $admin_t_intransit_c = $admin_t_intransit_c->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse']);
        $admin_t_intransit_c = $admin_t_intransit_c->count();

        $admin_1phase_intransit_c = \DB::table('meter');
        $admin_1phase_intransit_c = $admin_1phase_intransit_c->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','phase_type'=>'1 Phase'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse'])->where(['phase_type'=>'1 Phase']);
        $admin_1phase_intransit_c = $admin_1phase_intransit_c->count();

        $admin_3phase_intransit_c = \DB::table('meter');
        $admin_3phase_intransit_c = $admin_3phase_intransit_c->where(['current_meter_status'=>'Pending MRN Acceptance in VP warehouse','phase_type'=>'3 Phase'])->orwhere(['current_meter_status'=>'Pending MRN Acceptance in EDF warehouse','phase_type'=>'3 Phase']);
        $admin_3phase_intransit_c = $admin_3phase_intransit_c->count();




        $res = [];
        $res['admin_t_intransit_c'] = $admin_t_intransit_c;
        $res['admin_1phase_intransit_c'] = $admin_1phase_intransit_c;
        $res['admin_3phase_intransit_c'] = $admin_3phase_intransit_c;
        return $res;
    }

    public function api_admin_meter_tested_c()
    {
        echo $physical_tested   = \DB::table('meter')->where(['physical_testing_status'=>'Tested'])->count();
    }

    public function api_dashboard_admin_meter_pool_c()
    {
        $edf_meter_poole = \DB::table('meter');
        if(\Session::get('role')=='999')
        {
            $edf_meter_poole = $edf_meter_poole->where(['batch_status'=>'Approved','dl_ch_ref'=>''])->orwhere(['swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);

        }
        if(\Session::get('role')=='1')
        {
            $edf_meter_poole = $edf_meter_poole->where(['batch_status'=>'Approved','dl_ch_ref'=>'']);

        }
        if(\Session::get('role')=='2')
        {
            $edf_meter_poole = $edf_meter_poole->where(['swh_inventory_status'=>'Instock','batch_status'=>'Approved',/*'swh'=>new MongoId(\Session::get('_id')),*/'whm_system_utility'=>\Session::get('utility')]);
        }
        echo  $edf_meter_poole = $edf_meter_poole->count();
    }

    public function api_dashboard_admin_meter_assign_c()
    {
         $assigned_meter    = \DB::table('meter');
         $assigned_meter = \DB::table('meter');
        if(\Session::get('role')=='999')
        {
            $assigned_meter = $assigned_meter->where(['dl_ch_ref'=>['$ne'=>'']/*,'swh'=>['$ne'=>'']*/])->orwhere(['swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*'swh'=>new MongoId(\Session::get('_id'))*/]);
        }

        if(\Session::get('role')=='1')
        {
            $assigned_meter = $assigned_meter->where(['dl_ch_ref'=>['$ne'=>'']/*,'swh'=>['$ne'=>'']*/]);

        }
        if(\Session::get('role')=='2')
        {
            $assigned_meter = $assigned_meter->where(['swh_inventory_status'=>'AssignedToVM','whm_system_utility'=>\Session::get('utility')/*'swh'=>new MongoId(\Session::get('_id'))*/]);
        }
        echo  $assigned_meter = $assigned_meter->count();
    }

    public function api_dashboard_admin_sim_assign_c()
    {
        echo $all_sim           = \DB::table('bsnl_sim')->count();
    }

    public function api_dashboard_admin_sim_utilized_c()
    {
        echo $utilized_sim      = \DB::table('bsnl_sim')->where(['sim_status'=>'UTILIZED'])->count();
    }

    public function api_dashboard_admin_sim_unutilized_c()
    {
        echo $unutilised_sim    = \DB::table('bsnl_sim')->where(['sim_status'=>'UNUTILISED'])->count();
        
    }

    public function api_dashboard_admin_modem_loader_c()
    {
        $reject_meter = \DB::table('modem');
        
        if(\Session::get('role')=='2')
        {
            $reject_meter = $reject_meter->where(['vmwh'=>'','swh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED']);
        }
        echo  $reject_meter = $reject_meter->count();
    }


    public function api_dashboard_admin_antena_loader_c()
    {
        echo $all_modem         = \DB::table('antennas')->count();
    }

    public function api_admin_meter_reject_loader_c()
    {
        $reject_meter = \DB::table('meter');
        if(\Session::get('role')=='999')
        {
            $reject_meter = $reject_meter->orwhere(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->where(['sm_damaged_mark_by'=>'sm','sm_damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
        }
        if(\Session::get('role')=='1')
        {
            $reject_meter = $reject_meter->orwhere(['testing_status'=>'Rejected'])->orwhere(['status'=>'Rejected'])->count();
        }
        if(\Session::get('role')=='2')
        {
            $reject_meter = $reject_meter->where(['sm_damaged_mark_by'=>'sm','is_damage_accepted_swh'=>'Yes','is_damage_accepted_admin'=>'','whm_system_utility'=>\Session::get('utility')]);
        }
        echo  $reject_meter = $reject_meter->count();
    }



    public function api_dashboard_get_vm_meter_c()
    {
        $vm_t_meter_c = \DB::table('meter');
        $vm_t_meter_c = $vm_t_meter_c->where(['swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))]);
        $vm_t_meter_c = $vm_t_meter_c->count();

        $vm_d_meter_c = \DB::table('meter');
        $vm_d_meter_c = $vm_d_meter_c->where(['damaged_mark_by'=>'vm','whm_system_utility'=>\Session::get('utility'),'damaged_mark_by_id'=>new MongoId(\Session::get('_id'))]);
        $vm_d_meter_c = $vm_d_meter_c->count();

        $res = [];
        $res['vm_t_meter_c'] = $vm_t_meter_c;
        $res['vm_d_meter_c'] = $vm_d_meter_c;
        return $res;
    }

    public function api_admin_meter_bifucation_loader_c()
    {
        $supplier_LT = $supplier_Genus = $supplier_LT_1PH = $supplier_LT_3PH = $supplier_Genus_1PH = $supplier_Genus_3PH = $supplier_Genus_3PH = $supplier_Genus1_1PH = $supplier_Genus1_3PH = 0;
        if(\Session::get('role')=='999')
        {
            $supplier_LT        = \DB::table('meter')->where(['batch_supplier'=>'L&T'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_LT_1PH    = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_LT_3PH    = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_Genus     = \DB::table('meter')->where(['batch_supplier'=>'Genus 3G'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_Genus1     = \DB::table('meter')->where(['batch_supplier'=>'Genus 4G'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_Genus_1PH = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_Genus_3PH = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_Genus1_1PH = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
           $supplier_Genus1_3PH = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G'/*,'swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')*/])->count();
        }
        if(\Session::get('role')=='2')
        {
           //$supplier_LT        = \DB::table('meter')->where(['batch_supplier'=>'L&T','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           $supplier_LT_1PH    = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           $supplier_LT_3PH    = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           //$supplier_Genus     = \DB::table('meter')->where(['batch_supplier'=>'Genus 3G','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           //$supplier_Genus1     = \DB::table('meter')->where(['batch_supplier'=>'Genus 4G','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           $supplier_Genus_1PH = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           $supplier_Genus_3PH = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           $supplier_Genus1_1PH = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
           $supplier_Genus1_3PH = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G','swh_inventory_status'=>'Instock','batch_status'=>'Approved','whm_system_utility'=>\Session::get('utility')])->count();
            $supplier_LT = $supplier_LT_1PH+$supplier_LT_3PH;
            $supplier_Genus = $supplier_Genus_1PH+$supplier_Genus_3PH;
            $supplier_Genus1 = $supplier_Genus1_1PH+$supplier_Genus1_3PH;
        }
        if(\Session::get('role')=='3')
        {
           $supplier_LT        = \DB::table('meter')->where(['batch_supplier'=>'L&T','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_LT_1PH    = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'L&T','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_LT_3PH    = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'L&T','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_Genus     = \DB::table('meter')->where(['batch_supplier'=>'Genus 3G','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_Genus1     = \DB::table('meter')->where(['batch_supplier'=>'Genus 4G','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_Genus_1PH = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 3G','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_Genus_3PH = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 3G','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_Genus1_1PH = \DB::table('meter')->where(['phase_type'=>'1 Phase','batch_supplier'=>'Genus 4G','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
           $supplier_Genus1_3PH = \DB::table('meter')->where(['phase_type'=>'3 Phase','batch_supplier'=>'Genus 4G','swh_inventory_status'=>'Outstock','whm_system_utility'=>\Session::get('utility'),'vmwh'=>new MongoId(\Session::get('_id'))])->count();
        }
        $data                       = [];
        $data['supplier_LT']        = $supplier_LT;
        $data['supplier_Genus']     = $supplier_Genus;
        $data['supplier_Genus1']     = $supplier_Genus1;
        $data['supplier_LT_1PH']    = $supplier_LT_1PH;
        $data['supplier_LT_3PH']    = $supplier_LT_3PH;
        $data['supplier_Genus_1PH'] = $supplier_Genus_1PH;
        $data['supplier_Genus_3PH'] = $supplier_Genus_3PH;
        $data['supplier_Genus1_1PH'] = $supplier_Genus1_1PH;
        $data['supplier_Genus1_3PH'] = $supplier_Genus1_3PH;



        return $data;
        //echo $all_meter = \DB::table('modem')->where(['vmwh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'])->count();;
    }

    public function api_dashboard_get_vm_modem_c()
    {
        echo $all_meter = \DB::table('modem')->where(['vmwh'=>new MongoId(\Session::get('_id')),'status'=>'UNUTILISED'])->count();;
    }

    public function api_dashboard_get_vm_sim_c()
    {
        echo $all_sim           = \DB::table('bsnl_sim')->where(['vmwh'=>new MongoId(\Session::get('_id')),'sim_status'=>'UNUTILISED'])->count();;
    }

    public function api_dashboard_get_mrn1_meter_c()
    {
        echo $all_meter = \DB::table('meter')->count();
    }

    public function api_dashboard_get_mrn1_modem_c()
    {
        echo $all_modem         = \DB::table('modem')->count();
    }

    public function api_dashboard_get_mrn1_antenna_c()
    {
        echo $all_sim           = \DB::table('antennas')->count();
    }

    public function api_dashboard_get_mrn2_meter_c()
    {
        echo $all_meter = \DB::table('meter')->where(['whm_system_utility'=>\Session::get('utility')])->count();
    }

    public function api_dashboard_get_mrn2_modem_c()
    {
        echo $all_modem         = \DB::table('modem')->count();
    }

    public function api_dashboard_get_mrn2_antenna_c()
    {
        echo $all_sim           = \DB::table('antennas')->count();
    }

     
}
