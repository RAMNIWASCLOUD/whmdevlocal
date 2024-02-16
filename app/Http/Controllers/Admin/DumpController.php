<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Session;
use Validator;
use PDF;

    ///deleted
class DumpController extends Controller
{
    public function __construct()
    {
        /*$this->common_connection           = new \MongoClient(config('app.aliases.DB_URL'));
        $this->common_db                   = $this->common_connection->whm;
        $this->common_collection_modem     = $this->common_db->modem;
        $this->common_collection_bsnl_sim  = $this->common_db->bsnl_sim;
        $this->common_collection_meter     = $this->common_db->meter;*/

        $this->url_slug          = "meter";
        $this->folder_path       = "admin/meter/";
        ini_set('memory_limit', '8192M');
        ini_set('max_execution_time', '0');
    }

    /*public function dump_meter()
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=meter.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "_id";
        echo ',';
        echo "device_id";
        echo ',';
        echo "manufacturer_serial_number";
        echo ',';
        echo "device_type";
        echo ',';
        echo "device_subtype";
        echo ',';
        echo "device_model_number";
        echo ',';
        echo "device_manufacturer_abbreviation";
        echo ',';
        echo "device_manufacturing_year";
        echo ',';
        echo "device_calibration_year";
        echo ',';
        echo "device_protocol";
        echo ',';
        echo "device_protocol_version";
        echo ',';
        echo "device_mac_address";
        echo ',';
        echo "device_firmware_version";
        echo ',';
        echo "device_configuration_version";
        echo ',';
        echo "device_display_register_digit";
        echo ',';
        echo "device_communication_technology";
        echo ',';
        echo "device_communication_module_model";
        echo ',';
        echo "device_communication_module_serial_number";
        echo ',';
        echo "device_communication_module_manufacturing_year";
        echo ',';
        echo "device_communication_module_firmware_version";
        echo ',';
        echo "device_communication_module_imei_number";
        echo ',';
        echo "dlms_tcp_port";
        echo ',';
        echo "dlms_communication_profile";
        echo ',';
        echo "dlms_client_id";
        echo ',';
        echo "dlms_master_key";
        echo ',';
        echo "dlms_authentication_key";
        echo ',';
        echo "dlms_guc";
        echo ',';
        echo "dlms_security_secret";
        echo ',';
        echo "dlms_security_policy";
        echo ',';
        echo "dlms_authentication_mechanism";
        echo ',';
        echo "dlms_security_suite";
        echo ',';
        echo "dlms_companion";
        echo ',';
        echo "dlms_companion_version";
        echo ',';
        echo "device_utilityid";
        echo ',';
        echo "utility";
        echo ',';
        echo "iccid";
        echo ',';
        echo "batch_id";
        echo ',';
        echo "meter_upload_time";
        echo ',';
        echo "batch_approve_reject_time";
        echo ',';
        echo "swh_delivery_time";
        echo ',';
        echo "vendor_dispatch_date";
        echo ',';
        echo "swh";
        echo ',';
        echo "vmwh";
        echo ',';
        echo "swh_name";
        echo ',';
        echo "vmwh_name";
        echo ',';
        echo "mrn_ref";
        echo ',';
        echo "dl_ch_ref";
        echo ',';
        echo "vmwh_mrn_ref";
        echo ',';
        echo "vmwh_dl_ch_ref";
        echo ',';
        echo "state_warehouse_selfpickup_image";
        echo ',';
        echo "vm_warehouse_selfpickup_image";
        echo ',';
        echo "current_meter_status";
        echo ',';
        echo "status";
        echo ',';
        echo "testing_status";
        echo ',';
        echo "testing_type";
        echo ',';
        echo "meter_reject_reason";
        echo ',';
        echo "meter_reject_images";
        echo ',';
        echo "testing_time";
        echo ',';
        echo "batch_status";
        echo ',';
        echo "batch_reject_reason";
        echo ',';
        echo "physical_testing_status";
        echo ',';
        echo "physical_testing_time";
        echo ',';
        echo "physical_meter_reject_images";
        echo ',';
        echo "physical_meter_reject_reason";
        echo ',';
        echo "whm_system_utility";
        echo ',';
        echo "whm_system_utility_id";
        echo ',';
        echo "swh_inventory_status";
        echo ',';
        echo "latitude";
        echo ',';
        echo "longitude";
        echo ',';
        echo "last_meter_location";
        echo ',';
        echo "last_meter_location_time";
        echo ',';
        echo "meter_created_at";
        echo ',';
        echo "\n";
        $sort       = array('createdAt' => -1);
        $cursor     = $this->common_collection_meter->find(); 
        
        foreach ($cursor as $key => $value) 
        {
            echo $value['_id'];
            echo ',';
            echo $value['device_id'];
            echo ',';
            echo $value['manufacturer_serial_number'];
            echo ',';
            echo $value['device_type'];
            echo ',';
            echo $value['device_subtype'];
            echo ',';
            echo $value['device_model_number'];
            echo ',';
            echo $value['device_manufacturer_abbreviation'];
            echo ',';
            echo $value['device_manufacturing_year'];
            echo ',';
            echo $value['device_calibration_year'];
            echo ',';
            echo $value['device_protocol'];
            echo ',';
            echo $value['device_protocol_version'];
            echo ',';
            echo $value['device_mac_address'];
            echo ',';
            echo $value['device_firmware_version'];
            echo ',';
            echo $value['device_configuration_version'];
            echo ',';
            echo $value['device_display_register_digit'];
            echo ',';
            echo $value['device_communication_technology'];
            echo ',';
            echo $value['device_communication_module_model'];
            echo ',';
            echo $value['device_communication_module_serial_number'];
            echo ',';
            echo $value['device_communication_module_manufacturing_year'];
            echo ',';
            echo $value['device_communication_module_firmware_version'];
            echo ',';
            echo $value['device_communication_module_imei_number'];
            echo ',';
            echo $value['dlms_tcp_port'];
            echo ',';
            echo $value['dlms_communication_profile'];
            echo ',';
            echo $value['dlms_client_id'];
            echo ',';
            echo $value['dlms_master_key'];
            echo ',';
            echo $value['dlms_authentication_key'];
            echo ',';
            echo $value['dlms_guc'];
            echo ',';
            echo $value['dlms_security_secret'];
            echo ',';
            echo $value['dlms_security_policy'];
            echo ',';
            echo $value['dlms_authentication_mechanism'];
            echo ',';
            echo $value['dlms_security_suite'];
            echo ',';
            echo $value['dlms_companion'];
            echo ',';
            echo $value['dlms_companion_version'];
            echo ',';
            echo $value['device_utilityid'];
            echo ',';
            echo $value['utility'];
            echo ',';
            echo 'sim'.$value['iccid'];
            echo ',';
            echo $value['batch_id'];
            echo ',';
            echo $value['meter_upload_time'];
            echo ',';
            echo $value['batch_approve_reject_time'];
            echo ',';
            echo $value['swh_delivery_time'];
            echo ',';
            echo $value['vendor_dispatch_date'];
            echo ',';
            echo $value['swh'];
            echo ',';
            echo $value['vmwh'];
            echo ',';
            echo $value['swh_name'];
            echo ',';
            echo $value['vmwh_name'];
            echo ',';
            echo $value['mrn_ref'];
            echo ',';
            echo $value['dl_ch_ref'];
            echo ',';
            echo $value['vmwh_mrn_ref'];
            echo ',';
            echo $value['vmwh_dl_ch_ref'];
            echo ',';
            echo $value['state_warehouse_selfpickup_image'];
            echo ',';
            echo $value['vm_warehouse_selfpickup_image'];
            echo ',';
            echo $value['current_meter_status'];
            echo ',';
            echo $value['status'];
            echo ',';
            echo $value['testing_status'];
            echo ',';
            echo $value['testing_type'];
            echo ',';
            echo $value['meter_reject_reason'];
            echo ',';
            echo $value['meter_reject_images'];
            echo ',';
            echo $value['testing_time'];
            echo ',';
            echo $value['batch_status'];
            echo ',';
            echo $value['batch_reject_reason'];
            echo ',';
            echo $value['physical_testing_status'];
            echo ',';
            echo $value['physical_testing_time'];
            echo ',';
            echo $value['physical_meter_reject_images'];
            echo ',';
            echo $value['physical_meter_reject_reason'];
            echo ',';
            echo $value['whm_system_utility'];
            echo ',';
            echo $value['whm_system_utility_id'];
            echo ',';
            echo $value['swh_inventory_status'];
            echo ',';
            echo $value['latitude'];
            echo ',';
            echo $value['longitude'];
            echo ',';
            echo $value['last_meter_location'];
            echo ',';
            echo $value['last_meter_location_time'];
            echo ',';
            echo $value['meter_created_at'];
            echo ',';
            echo "\n";
        }
    }

    public function dump_sim()
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=sim.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "_id";
        echo ',';
        echo "sim_no";
        echo ',';
        echo "mobile_no";
        echo ',';
        echo "imsi";
        echo ',';
        echo "static_ip";
        echo ',';
        echo "apn";
        echo ',';
        echo "status";
        echo ',';
        echo "batch_id";
        echo ',';
        echo "sim_upload_time";
        echo ',';
        echo "sim_status";
        echo ',';
        echo "swh";
        echo ',';
        echo "swh_name";
        echo ',';
        echo "last_sim_location";
        echo ',';
        echo "last_sim_location_time";
        echo ',';
        echo "swh_delivery_time";
        echo ',';
        echo "swh_inventory_status";
        echo ',';
        echo "mrn_ref";
        echo ',';
        echo "dl_ch_ref";
        echo ',';
        echo "vmwh";
        echo ',';
        echo "vmwh_name";
        echo ',';
        echo "vendor_dispatch_date";
        echo ',';echo "\n";
        $cursor     = $this->common_collection_bsnl_sim->find(); 
        foreach ($cursor as $key => $value) 
        {
            echo $value['_id'];
            echo ',';
            echo 'sim'.$value['sim_no'];
            echo ',';
            echo $value['mobile_no'];
            echo ',';
            echo $value['imsi'];
            echo ',';
            echo $value['static_ip'];
            echo ',';
            echo $value['apn'];
            echo ',';
            echo $value['status'];
            echo ',';
            echo $value['batch_id'];
            echo ',';
            echo $value['sim_upload_time'];
            echo ',';
            echo $value['sim_status'];
            echo ',';
            echo $value['swh'];
            echo ',';
            echo $value['swh_name'];
            echo ',';
            echo $value['last_sim_location'];
            echo ',';
            echo $value['last_sim_location_time'];
            echo ',';
            echo $value['swh_delivery_time'];
            echo ',';
            echo $value['swh_inventory_status'];
            echo ',';
            echo $value['mrn_ref'];
            echo ',';
            echo $value['dl_ch_ref'];
            echo ',';
            echo $value['vmwh'];
            echo ',';
            echo $value['vmwh_name'];
            echo ',';
            echo $value['vendor_dispatch_date'];
            echo ',';
            echo "\n";
        }

    }

    public function dump_modem()
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=modem.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "_id";
        echo ',';
        echo "modem_number";
        echo ',';
        echo "status";
        echo ',';
        echo "date";
        echo ',';
        echo "swh";
        echo ',';
        echo "swh_name";
        echo ',';
        echo "last_modem_location";
        echo ',';
        echo "last_modem_location_time";
        echo ',';
        echo "swh_delivery_time";
        echo ',';
        echo "swh_inventory_status";
        echo ',';
        echo "mrn_ref";
        echo ',';
        echo "dl_ch_ref";
        echo ',';
        echo "vmwh";
        echo ',';
        echo "vmwh_name";
        echo ',';
        echo "vendor_dispatch_date";
        echo ',';echo "\n";
        $cursor     = $this->common_collection_modem->find(); 
        foreach ($cursor as $key => $value) 
        {
            echo $value['_id'];
            echo ',';
            echo $value['modem_number'];
            echo ',';
            echo $value['status'];
            echo ',';
            echo $value['date'];
            echo ',';
            echo $value['swh'];
            echo ',';
            echo $value['swh_name'];
            echo ',';
            echo $value['last_modem_location'];
            echo ',';
            echo $value['last_modem_location_time'];
            echo ',';
            echo $value['swh_delivery_time'];
            echo ',';
            echo $value['swh_inventory_status'];
            echo ',';
            echo $value['mrn_ref'];
            echo ',';
            echo $value['dl_ch_ref'];
            echo ',';
            echo $value['vmwh'];
            echo ',';
            echo $value['vmwh_name'];
            echo ',';
            echo $value['vendor_dispatch_date'];
            echo ',';
            echo "\n";
        }
    }*/

    public function report_dumps()
    {
        $data['page_name'] = "";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Dumps';
        return view($this->folder_path.'report_dumps',$data);
    }

    public function dumps_proccess($id)
    {
        switch ($id) {
            case '1':
                $page_name = 'NBPD';
            break;

            case '2':
                $page_name = 'SBPD';
            break;

            case '3':
                $page_name = 'NON-NBPD/SBPD';
            break;

            case '4':
                $page_name = 'Sim Batch 1';
            break;

            case '5':
                $page_name = 'Sim Batch 2';
            break;

            case '6':
                $page_name = 'Modem';

            case '111':
                $page_name = 'S2S Meter';

            break;
        }
        $data['page_name'] = $page_name;
        $data['id'] = $id;
        $data['url_slug']  = $this->url_slug;
        $data['title']     = 'Dump Process';
        return view($this->folder_path.'dumps_proccess',$data);
    }

    public function dump_cron_dump_send_email()
    {
        $this->nbpd_dump();
        $this->sbpd_dump();
        $this->non_nbpd_sbpd_dump();
        $this->sim_dump();
        $this->sim_dump1();
        $this->modem_dump();
        $this->s2s_dump();

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
        <td>
            <ul style="list-style-type: lower-alpha;font-size: 18px;">
              <li>Meter dump files
                <ul style="list-style-type: lower-alpha;font-size: 14px;">
                  <li>NBPD Meter Link: <a href="'.url('/').'/dumps/nbpd.csv">Click Here</a></li>
                  <li>SBPD Meter Link: <a href="'.url('/').'/dumps/sbpd.csv">Click Here</a></li>
                  <li>Non-NBPD/SBPD Link: <a href="'.url('/').'/dumps/non_nbpd_sbpd.csv">Click Here</a></li>
                </ul>
              </li>
              <li>Sim dump file 
                <ul style="list-style-type: lower-alpha;font-size: 14px;">
                  <li>Batch 1:<a href="'.url('/').'/dumps/sim_batch_1.csv">Click Here</a></li>
                  <li>Batch 2:<a href="'.url('/').'/dumps/sim_batch_2.csv">Click Here</a></li>
                </ul>
              </li>
              <li>Modem dump file <a href="'.url('/').'/dumps/modem.csv">Click Here</a></li>
              <li>S2S dump file <a href="'.url('/').'/dumps/s2s_meter.csv">Click Here</a></li>
            </ul>
        </td>
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
        //print_r($html);die;
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
            $mail->Password   = 'fGAFAFSD#$31213';
            $mail->Subject    = 'WHM Daily dump email for '.date('d-m-Y');
            $mail->Body       = $html;
            $mail->setFrom('support@edfin-india.com', "WHM");
            //$mail->addAddress('suraj.hoh@gmail.com', "Admin");
            $mail->addAddress('radhika.malik@hohtechlabs.com', "Admin");
            $mail->addAddress('vikram.rao@edfin-india.com', "Admin");
            $mail->addAddress('ravinath@edfin-india.com', "Admin");
            $mail->addAddress('mahesh.kumar@edfin-india.com', "Admin");
            $mail->addReplyTo("whm.hoh@edf-india.com", "Reply");
            $mail->addCC("nikhil.singh@edfin-india.com"); 
            $mail->addCC("ashutosh1@edfin-india.com"); 
            $mail->addCC("radhika.malik@hohtechlabs.com"); 
            $mail->addCC("peeush@hohtechlabs.com"); 
            $mail->addBCC("suraj.hoh@gmail.com");
            
            


            /*$mail->addCC("nand.lal.4312@gmail.com"); 
            $mail->addCC("armanali265@gmail.com"); */
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
        }
        echo 'success';
    }

    public function dumps_proccess_ajax($id)
    {
        switch ($id) {
            case '1':
                $this->nbpd_dump();
                $link = url('/').'/dumps/nbpd.csv';
            break;

            case '2':
            $this->sbpd_dump();
                $link = url('/').'/dumps/sbpd.csv';
            break;

            case '3':
            $this->non_nbpd_sbpd_dump();
                $link = url('/').'/dumps/non_nbpd_sbpd.csv';
            break;

            case '4':
            $this->sim_dump();
                $link = url('/').'/dumps/sim_batch_1.csv';
            break;

            case '5':
            $this->sim_dump1();
                $link = url('/').'/dumps/sim_batch_2.csv';
            break;

            case '6':
            $this->modem_dump();
                $link = url('/').'/dumps/modem.csv';
            break;

            case '111':
            $this->s2s_dump();
                $link = url('/').'/dumps/s2s_meter.csv';
            break;
        }

        return $link;
    }

    public function nbpd_dump()
    {
       $meter = \DB::table('meter')
                    ->select(['batch_invoice_no','batch_invoice_date','batch_waybill_no','batch_waybill_date','device_id','meter_created_at','phase_type','sim_no','imei_no','whm_system_utility','last_meter_location','swh_delivery_time','current_meter_status','status','edf_vendor_manager_name','batch_supplier','whm_vendor_manager_name','date_of_dispatch_to_OEM_repair','date_of_receipt_of_meter_WH','date_of_receipt_of_refurbished','refurbished_meter_received_date','faulty_declared_date','s2s_faulty_declared_date','s2s_date_of_receipt_of_meter_WH','s2s_date_of_dispatch_to_OEM_repair','s2s_date_of_receipt_of_refurbished','s2s_refurbished_meter_received_date','reveived_date','vendor_dispatch_date','swh_inventory_status'])
                    ->where('whm_system_utility','NBPD')
                    ->get();

        $file                                       = fopen("dumps/nbpd.csv","w");
        $data                                       = [];
        $data['batch_invoice_no']                   = 'batch_invoice_no';
        $data['batch_invoice_date']                 = 'batch_invoice_date';
        $data['batch_waybill_no']                   = 'batch_waybill_no';
        $data['batch_waybill_date']                 = 'batch_waybill_date';
        $data['device_id']                          = 'device_id';
        $data['meter_created_at']                   = 'meter_created_at';
        $data['phase_type']                         = 'phase_type';
        $data['sim_no']                             = 'sim_no';
        $data['imei_no']                            = 'imei_no';
        $data['whm_system_utility']                 = 'whm_system_utility';
        $data['last_meter_location']                = 'last_meter_location';
        $data['swh_delivery_time']                  = 'swh_delivery_time';
        $data['current_meter_status']               = 'current_meter_status';
        $data['status']                             = 'status';
        $data['edf_vendor_manager_name']            = 'edf_vendor_manager_name';
        $data['batch_supplier']                     = 'batch_supplier';
        $data['whm_vendor_manager_name']            = 'whm_vendor_manager_name';
        $data['date_of_dispatch_to_OEM_repair']     = 'date_of_dispatch_to_OEM_repair';
        $data['date_of_receipt_of_meter_WH']        = 'date_of_receipt_of_meter_WH';
        $data['date_of_receipt_of_refurbished']     = 'date_of_receipt_of_refurbished';
        $data['refurbished_meter_received_date']     = 'refurbished_meter_received_date';
        $data['faulty_declared_date']               = 'faulty_declared_date';
        $data['s2s_faulty_declared_date']           = 's2s_faulty_declared_date';
        $data['s2s_date_of_receipt_of_meter_WH']    = 's2s_date_of_receipt_of_meter_WH';
        $data['s2s_date_of_dispatch_to_OEM_repair'] = 's2s_date_of_dispatch_to_OEM_repair';
        $data['s2s_date_of_receipt_of_refurbished'] = 's2s_date_of_receipt_of_refurbished';
        $data['s2s_refurbished_meter_received_date']= 's2s_refurbished_meter_received_date';
        $data['reveived_date']                      = 'reveived_date';
        $data['vendor_dispatch_date']      = 'vendor_dispatched_date';
        $data['swh_inventory_status']      = 'swh_inventory_status';

        fputcsv($file, $data);
        foreach ($meter as $line) {
            $data                                       = [];
            $data['batch_invoice_no']                   = $line['batch_invoice_no'];
            $data['batch_invoice_date']                 = $line['batch_invoice_date'];
            $data['batch_waybill_no']                   = $line['batch_waybill_no'];
            $data['batch_waybill_date']                 = $line['batch_waybill_date'];
            $data['device_id']                          = $line['device_id'];
            $data['meter_created_at']                   = $line['meter_created_at'];
            $data['phase_type']                         = $line['phase_type'];
            $data['sim_no']                             = $line['sim_no'];
            $data['imei_no']                            = $line['imei_no'];
            $data['whm_system_utility']                 = $line['whm_system_utility'];
            $data['last_meter_location']                = $line['last_meter_location'];
            $data['swh_delivery_time']                  = $line['swh_delivery_time'];
            $data['current_meter_status']               = $line['current_meter_status'];
            $data['status']                             = $line['status'];
            $data['edf_vendor_manager_name']            = $line['edf_vendor_manager_name'];
            $data['batch_supplier']                     = $line['batch_supplier'];
            $data['whm_vendor_manager_name']            = $line['whm_vendor_manager_name'];
            $data['date_of_dispatch_to_OEM_repair']     = $line['date_of_dispatch_to_OEM_repair'];
            $data['date_of_receipt_of_meter_WH']        = $line['date_of_receipt_of_meter_WH'];
            $data['date_of_receipt_of_refurbished']     = $line['date_of_receipt_of_refurbished'];
            $data['refurbished_meter_received_date']    = $line['refurbished_meter_received_date'];
            $data['faulty_declared_date']               = $line['faulty_declared_date'];
            $data['s2s_faulty_declared_date']           = $line['s2s_faulty_declared_date'];
            $data['s2s_date_of_receipt_of_meter_WH']    = $line['s2s_date_of_receipt_of_meter_WH'];
            $data['s2s_date_of_dispatch_to_OEM_repair'] = $line['s2s_date_of_dispatch_to_OEM_repair'];
            $data['s2s_date_of_receipt_of_refurbished'] = $line['s2s_date_of_receipt_of_refurbished'];
            $data['s2s_refurbished_meter_received_date'] = $line['s2s_refurbished_meter_received_date'];
            $data['reveived_date'] = $line['reveived_date'];
            $data['vendor_dispatch_date'] = $line['vendor_dispatch_date'];
            $data['swh_inventory_status'] = $line['swh_inventory_status'];

          fputcsv($file, $data);
        }

        fclose($file);
    }

    public function sbpd_dump()
    {
       $meter = \DB::table('meter')->select(['batch_invoice_no','batch_invoice_date','batch_waybill_no','batch_waybill_date','device_id','meter_created_at','phase_type','sim_no','imei_no','whm_system_utility','last_meter_location','swh_delivery_time','current_meter_status','status','edf_vendor_manager_name','batch_supplier','whm_vendor_manager_name','date_of_dispatch_to_OEM_repair','date_of_receipt_of_meter_WH','date_of_receipt_of_refurbished','refurbished_meter_received_date','faulty_declared_date','s2s_faulty_declared_date','s2s_date_of_receipt_of_meter_WH','s2s_date_of_dispatch_to_OEM_repair','s2s_date_of_receipt_of_refurbished','s2s_refurbished_meter_received_date','reveived_date','vendor_dispatch_date','swh_inventory_status'])->where('whm_system_utility','SBPD')->get();
        

        $file = fopen("dumps/sbpd.csv","w");
        $data                            = [];
        $data['batch_invoice_no']        = 'batch_invoice_no';
        $data['batch_invoice_date']      = 'batch_invoice_date';
        $data['batch_waybill_no']        = 'batch_waybill_no';
        $data['batch_waybill_date']      = 'batch_waybill_date';
        $data['device_id']               = 'device_id';
        $data['meter_created_at']        = 'meter_created_at';
        $data['phase_type']              = 'phase_type';
        $data['sim_no']                  = 'sim_no';
        $data['imei_no']                 = 'imei_no';
        $data['whm_system_utility']      = 'whm_system_utility';
        $data['last_meter_location']     = 'last_meter_location';
        $data['swh_delivery_time']       = 'swh_delivery_time';
        $data['current_meter_status']    = 'current_meter_status';
        $data['status']                  = 'status';
        $data['edf_vendor_manager_name'] = 'edf_vendor_manager_name';
        $data['batch_supplier']          = 'batch_supplier';
        $data['whm_vendor_manager_name'] = 'whm_vendor_manager_name';
        $data['date_of_dispatch_to_OEM_repair']     = 'date_of_dispatch_to_OEM_repair';
        $data['date_of_receipt_of_meter_WH']        = 'date_of_receipt_of_meter_WH';
        $data['date_of_receipt_of_refurbished']     = 'date_of_receipt_of_refurbished';
        $data['refurbished_meter_received_date']     = 'refurbished_meter_received_date';
        $data['faulty_declared_date']               = 'faulty_declared_date';
        $data['s2s_faulty_declared_date']           = 's2s_faulty_declared_date';
        $data['s2s_date_of_receipt_of_meter_WH']    = 's2s_date_of_receipt_of_meter_WH';
        $data['s2s_date_of_dispatch_to_OEM_repair'] = 's2s_date_of_dispatch_to_OEM_repair';
        $data['s2s_date_of_receipt_of_refurbished'] = 's2s_date_of_receipt_of_refurbished';
        $data['s2s_refurbished_meter_received_date'] = 's2s_refurbished_meter_received_date';
        $data['reveived_date'] = 'reveived_date';
        $data['vendor_dispatch_date'] = 'vendor_dispatched_date';
        $data['swh_inventory_status'] = 'swh_inventory_status';

        fputcsv($file, $data);
        foreach ($meter as $line) {
            $data                            = [];
            $data['batch_invoice_no']        = $line['batch_invoice_no'];
            $data['batch_invoice_date']      = $line['batch_invoice_date'];
            $data['batch_waybill_no']        = $line['batch_waybill_no'];
            $data['batch_waybill_date']      = $line['batch_waybill_date'];
            $data['device_id']               = $line['device_id'];
            $data['meter_created_at']        = $line['meter_created_at'];
            $data['phase_type']              = $line['phase_type'];
            $data['sim_no']                  = $line['sim_no'];
            $data['imei_no']                 = $line['imei_no'];
            $data['whm_system_utility']      = $line['whm_system_utility'];
            $data['last_meter_location']     = $line['last_meter_location'];
            $data['swh_delivery_time']       = $line['swh_delivery_time'];
            $data['current_meter_status']    = $line['current_meter_status'];
            $data['status']                  = $line['status'];
            $data['edf_vendor_manager_name'] = $line['edf_vendor_manager_name'];
            $data['batch_supplier']          = $line['batch_supplier'];
            $data['whm_vendor_manager_name'] = $line['whm_vendor_manager_name'];
            $data['date_of_dispatch_to_OEM_repair']     = $line['date_of_dispatch_to_OEM_repair'];
            $data['date_of_receipt_of_meter_WH']        = $line['date_of_receipt_of_meter_WH'];
            $data['date_of_receipt_of_refurbished']     = $line['date_of_receipt_of_refurbished'];
            $data['refurbished_meter_received_date']    = $line['refurbished_meter_received_date'];
            $data['faulty_declared_date']               = $line['faulty_declared_date'];
            $data['s2s_faulty_declared_date']           = $line['s2s_faulty_declared_date'];
            $data['s2s_date_of_receipt_of_meter_WH']    = $line['s2s_date_of_receipt_of_meter_WH'];
            $data['s2s_date_of_dispatch_to_OEM_repair'] = $line['s2s_date_of_dispatch_to_OEM_repair'];
            $data['s2s_date_of_receipt_of_refurbished'] = $line['s2s_date_of_receipt_of_refurbished'];
            $data['s2s_refurbished_meter_received_date'] = $line['s2s_refurbished_meter_received_date'];
            $data['reveived_date'] = $line['reveived_date'];
            $data['vendor_dispatch_date'] = $line['vendor_dispatch_date'];
            $data['swh_inventory_status'] = $line['swh_inventory_status'];

          fputcsv($file, $data);
        }

        fclose($file);
    }

    public function non_nbpd_sbpd_dump()
    {
       $meter = \DB::table('meter')->select(['batch_invoice_no','batch_invoice_date','batch_waybill_no','batch_waybill_date','device_id','meter_created_at','phase_type','sim_no','imei_no','whm_system_utility','last_meter_location','swh_delivery_time','current_meter_status','status','edf_vendor_manager_name','batch_supplier','whm_vendor_manager_name','date_of_dispatch_to_OEM_repair','date_of_receipt_of_meter_WH','date_of_receipt_of_refurbished','refurbished_meter_received_date','faulty_declared_date','s2s_faulty_declared_date','s2s_date_of_receipt_of_meter_WH','s2s_date_of_dispatch_to_OEM_repair','s2s_date_of_receipt_of_refurbished','s2s_refurbished_meter_received_date','reveived_date','vendor_dispatch_date'])->where('whm_system_utility','')->get();
        
       
        $file = fopen("dumps/non_nbpd_sbpd.csv","w");
        $data                            = [];
        $data['batch_invoice_no']        = 'batch_invoice_no';
        $data['batch_invoice_date']      = 'batch_invoice_date';
        $data['batch_waybill_no']        = 'batch_waybill_no';
        $data['batch_waybill_date']      = 'batch_waybill_date';
        $data['device_id']               = 'device_id';
        $data['meter_created_at']        = 'meter_created_at';
        $data['phase_type']              = 'phase_type';
        $data['sim_no']                  = 'sim_no';
        $data['imei_no']                 = 'imei_no';
        $data['whm_system_utility']      = 'whm_system_utility';
        $data['last_meter_location']     = 'last_meter_location';
        $data['swh_delivery_time']       = 'swh_delivery_time';
        $data['current_meter_status']    = 'current_meter_status';
        $data['status']                  = 'status';
        $data['edf_vendor_manager_name'] = 'edf_vendor_manager_name';
        $data['batch_supplier']          = 'batch_supplier';
        $data['whm_vendor_manager_name'] = 'whm_vendor_manager_name';
        $data['date_of_dispatch_to_OEM_repair']     = 'date_of_dispatch_to_OEM_repair';
        $data['date_of_receipt_of_meter_WH']        = 'date_of_receipt_of_meter_WH';
        $data['date_of_receipt_of_refurbished']     = 'date_of_receipt_of_refurbished';
        $data['refurbished_meter_received_date']     = 'refurbished_meter_received_date';
        $data['faulty_declared_date']               = 'faulty_declared_date';
        $data['s2s_faulty_declared_date']           = 's2s_faulty_declared_date';
        $data['s2s_date_of_receipt_of_meter_WH']    = 's2s_date_of_receipt_of_meter_WH';
        $data['s2s_date_of_dispatch_to_OEM_repair'] = 's2s_date_of_dispatch_to_OEM_repair';
        $data['s2s_date_of_receipt_of_refurbished'] = 's2s_date_of_receipt_of_refurbished';
        $data['s2s_refurbished_meter_received_date'] = 's2s_refurbished_meter_received_date';
        $data['reveived_date'] = 'reveived_date';
        $data['vendor_dispatch_date'] = 'vendor_dispatched_date';

        fputcsv($file, $data);
        foreach ($meter as $line) {
            $data                            = [];
            $data['batch_invoice_no']        = $line['batch_invoice_no'];
            $data['batch_invoice_date']      = $line['batch_invoice_date'];
            $data['batch_waybill_no']        = $line['batch_waybill_no'];
            $data['batch_waybill_date']      = $line['batch_waybill_date'];
            $data['device_id']               = $line['device_id'];
            $data['meter_created_at']        = $line['meter_created_at'];
            $data['phase_type']              = $line['phase_type'];
            $data['sim_no']                  = $line['sim_no'];
            $data['imei_no']                 = $line['imei_no'];
            $data['whm_system_utility']      = $line['whm_system_utility'];
            $data['last_meter_location']     = $line['last_meter_location'];
            $data['swh_delivery_time']       = $line['swh_delivery_time'];
            $data['current_meter_status']    = $line['current_meter_status'];
            $data['status']                  = $line['status'];
            $data['edf_vendor_manager_name'] = $line['edf_vendor_manager_name'];
            $data['batch_supplier']          = $line['batch_supplier'];
            $data['whm_vendor_manager_name'] = $line['whm_vendor_manager_name'];
            $data['date_of_dispatch_to_OEM_repair']     = $line['date_of_dispatch_to_OEM_repair'];
            $data['date_of_receipt_of_meter_WH']        = $line['date_of_receipt_of_meter_WH'];
            $data['date_of_receipt_of_refurbished']     = $line['date_of_receipt_of_refurbished'];
            $data['refurbished_meter_received_date']    = $line['refurbished_meter_received_date'];

            $data['faulty_declared_date']               = $line['faulty_declared_date'];
            $data['s2s_faulty_declared_date']           = $line['s2s_faulty_declared_date'];
            $data['s2s_date_of_receipt_of_meter_WH']    = $line['s2s_date_of_receipt_of_meter_WH'];
            $data['s2s_date_of_dispatch_to_OEM_repair'] = $line['s2s_date_of_dispatch_to_OEM_repair'];
            $data['s2s_date_of_receipt_of_refurbished'] = $line['s2s_date_of_receipt_of_refurbished'];
            $data['s2s_refurbished_meter_received_date'] = $line['s2s_refurbished_meter_received_date'];
            $data['reveived_date'] = $line['reveived_date'];
            $data['vendor_dispatch_date'] = $line['vendor_dispatch_date'];

          fputcsv($file, $data);
        }

        fclose($file);
    }

    public function sim_dump()
    {
       $meter = \DB::table('bsnl_sim')->select(['_id','sim_no','mobile_no','imsi','static_ip','apn','status','batch_id','sim_upload_time','sim_status'])->limit(800000)->orderBy('_id','ASC')->get();
        

        $file                    = fopen("dumps/sim_batch_1.csv","w");
        $data                    = [];
        $data['sim_no']          = 'sim_no';
        $data['mobile_no']       = 'mobile_no';
        $data['imsi']            = 'imsi';
        $data['static_ip']       = 'static_ip';
        $data['apn']             = 'apn';
        $data['status']          = 'status';
        $data['batch_id']        = 'batch_id';
        $data['sim_upload_time'] = 'sim_upload_time';
        $data['sim_status']      = 'sim_status';

        fputcsv($file, $data);
        foreach ($meter as $line) {
            $data                    = [];
            $data['sim_no']          = $line['sim_no'];
            $data['mobile_no']       = $line['mobile_no'];
            $data['imsi']            = $line['imsi'];
            $data['static_ip']       = $line['static_ip'];
            $data['apn']             = $line['apn'];
            $data['status']          = $line['status'];
            $data['batch_id']        = $line['batch_id'];
            $data['sim_upload_time'] = $line['sim_upload_time'];
            $data['sim_status']      = $line['sim_status'];
          fputcsv($file, $data);
        }

        fclose($file);
    }

    public function sim_dump1()
    {
       $meter = \DB::table('bsnl_sim')->select(['_id','sim_no','mobile_no','imsi','static_ip','apn','status','batch_id','sim_upload_time','sim_status'])->skip(800000)->orderBy('_id','ASC')->get();
        

        $file                    = fopen("dumps/sim_batch_2.csv","w");
        $data                    = [];
        $data['sim_no']          = 'sim_no';
        $data['mobile_no']       = 'mobile_no';
        $data['imsi']            = 'imsi';
        $data['static_ip']       = 'static_ip';
        $data['apn']             = 'apn';
        $data['status']          = 'status';
        $data['batch_id']        = 'batch_id';
        $data['sim_upload_time'] = 'sim_upload_time';
        $data['sim_status']      = 'sim_status';

        fputcsv($file, $data);
        foreach ($meter as $line) {
            $data                    = [];
            $data['sim_no']          = $line['sim_no'];
            $data['mobile_no']       = $line['mobile_no'];
            $data['imsi']            = $line['imsi'];
            $data['static_ip']       = $line['static_ip'];
            $data['apn']             = $line['apn'];
            $data['status']          = $line['status'];
            $data['batch_id']        = $line['batch_id'];
            $data['sim_upload_time'] = $line['sim_upload_time'];
            $data['sim_status']      = $line['sim_status'];
          fputcsv($file, $data);
        }

        fclose($file);
    }

    public function modem_dump()
    {
       $meter = \DB::table('modem')->select(['_id','modem_number','make','phase','category','status','date'])->get();
        

        $file                 = fopen("dumps/modem.csv","w");
        $data                 = [];
        $data['modem_number'] = 'modem_number';
        $data['make']         = 'make';
        $data['phase']        = 'phase';
        $data['category']     = 'category';
        $data['status']       = 'status';
        $data['date']         = 'date';
        fputcsv($file, $data);
        foreach ($meter as $line) {
            $data                 = [];
            $data['modem_number'] = $line['modem_number'];
            $data['make']         = $line['make'];
            $data['phase']        = $line['phase'];
            $data['category']     = $line['category'];
            $data['status']       = $line['status'];
            $data['date']         = $line['date'];
          fputcsv($file, $data);
        }

        fclose($file);
    }


    public function s2s_dump()
    {
        $s2s_meter_history = \DB::table('s2s_meter_history')->get();
        
        $file                                       = fopen("dumps/s2s_meter.csv","w");
        $data                                       = [];
        $data['device_id']                          = 'device_id';
        $data['s2s_faulty_declared_date']           = 's2s_faulty_declared_date';
        $data['s2s_date_of_receipt_of_meter_WH']    = 's2s_date_of_receipt_of_meter_WH';
        $data['s2s_date_of_dispatch_to_OEM_repair'] = 's2s_date_of_dispatch_to_OEM_repair';
        $data['s2s_date_of_receipt_of_refurbished'] = 's2s_date_of_receipt_of_refurbished';
        $data['whm_vendor_manager_name']            = 'whm_vendor_manager_name';
        $data['s2s_is_damage_accepted_swh']         = 's2s_is_damage_accepted_state_warehouse';
        $data['s2s_is_damage_accepted_admin']       = 's2s_is_damage_accepted_admin_warehouse';
        $data['s2s_supplier_status']                = 's2s_supplier_status';
        $data['s2s_supplier_approve_date']          = 's2s_supplier_approve_date';
        $data['repaired_time']                      = 'repaired_time';
        $data['edf_status']                         = 'install_status';
        $data['s2s_refurbished_meter_received_date']= 's2s_refurbished_meter_received_date';
        $data['s2s_damaged_mark_by_time']           = 's2s_damaged_mark_in_system';


        fputcsv($file, $data);
        foreach ($s2s_meter_history as $line) {
            $data                                       = [];
            $data['device_id']                          = $line['device_id'];
            $data['s2s_faulty_declared_date']           = $line['s2s_faulty_declared_date'];
            $data['s2s_date_of_receipt_of_meter_WH']    = $line['s2s_date_of_receipt_of_meter_WH'];
            $data['s2s_date_of_dispatch_to_OEM_repair'] = $line['s2s_date_of_dispatch_to_OEM_repair'];
            $data['s2s_date_of_receipt_of_refurbished'] = $line['s2s_date_of_receipt_of_refurbished'];
            $data['whm_vendor_manager_name']            = (isset($line['whm_vendor_manager_name']))? $line['whm_vendor_manager_name']:'';
            $data['s2s_is_damage_accepted_swh']         = $line['s2s_is_damage_accepted_swh'];
            $data['s2s_is_damage_accepted_admin']       = $line['s2s_is_damage_accepted_admin'];
            $data['s2s_supplier_status']                = ucfirst($line['s2s_supplier_status']);
            $data['s2s_supplier_approve_date']          = $line['s2s_supplier_approve_date'];
            $data['repaired_time']                      = $line['repaired_time'];
            $data['edf_status']                         = (!empty($line['edf_status']))? $line['edf_status'] : 'Not Installed';
            $data['s2s_refurbished_meter_received_date']= $line['s2s_refurbished_meter_received_date'];
            $data['s2s_damaged_mark_by_time']           = $line['s2s_damaged_mark_by_time'];

          fputcsv($file, $data);
        }

        fclose($file);
    }
}
