<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', 									'App\Http\Controllers\StudentController@index');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 									'Admin\Auth1Controller@login');

Route::get('/login', 								'Admin\Auth1Controller@login');

Route::post('/login_process', 						'Admin\Auth1Controller@login_process');

Route::get('/forget_password', 						'Admin\Auth1Controller@forget_password');

Route::post('/forget_password_process', 			'Admin\Auth1Controller@forget_password_process');

Route::get('/cron_dump_send_email', 			    'Admin\Auth1Controller@cron_dump_send_email');


Route::get('/cron_get_all_installed_meter', 			    'Admin\CronController@cron_get_all_installed_meter');

Route::post('/get_single_tagging_meter',		'Admin\MeternewController@get_single_tagging_meter');
Route::post('/update_single_tagged_meter',		'Admin\MeternewController@update_single_tagged_meter');

Route::get('/logout',		 						'Admin\Auth1Controller@logout');
Route::group(['prefix'=>'api','as'=>'api'], function ()
{
	Route::post('/mobile_login', 					'Admin\ApinewController@login');
	Route::post('/mrn_list', 					  	'Admin\ApinewController@mrn_list');
	Route::post('/check_meter', 					'Admin\ApinewController@check_meter');
	Route::post('/create_dispatch', 				'Admin\ApinewController@create_dispatch');
	Route::post('/dispatch_list', 					'Admin\ApinewController@dispatch_list');
	Route::post('/warehouse_list', 					'Admin\ApinewController@warehouse_list');
	Route::post('/upload_lr_copy', 					'Admin\ApinewController@upload_lr_copy');
	Route::post('/upload_reject_meter', 			'Admin\ApinewController@upload_reject_meter');
	Route::post('/upload_damage_meter', 			'Admin\ApinewController@upload_damage_meter');
	Route::post('/upload_state_salfpickup_image', 	'Admin\ApinewController@upload_state_salfpickup_image');
	Route::post('/upload_vm_salfpickup_image', 		'Admin\ApinewController@upload_vm_salfpickup_image');

	Route::post('/check_physical_meter', 			'Admin\ApinewController@check_physical_meter');
	Route::post('/physical_test_report', 			'Admin\ApinewController@physical_test_report');
	Route::post('/search_physical_meter', 			'Admin\ApinewController@search_physical_meter');
	Route::post('/update_physical_testing_report', 	'Admin\ApinewController@update_physical_testing_report');

	Route::post('/check_technical_meter', 			'Admin\ApinewController@check_technical_meter');
	Route::post('/technical_test_report', 			'Admin\ApinewController@technical_test_report');
	Route::post('/search_technical_meter', 			'Admin\ApinewController@search_technical_meter');
	Route::post('/update_technical_testing_report', 'Admin\ApinewController@update_technical_testing_report');
}); 


Route::get('/dump_cron_dump_send_email', 			         		'Admin\DumpController@dump_cron_dump_send_email');

Route::group(['middleware' => 'admin'], function () 
{

	Route::get('/dump_meter', 			         		'Admin\DumpController@dump_meter');
	Route::get('/dump_sim', 			         		'Admin\DumpController@dump_sim');
	Route::get('/dump_modem', 			         		'Admin\DumpController@dump_modem');
	Route::get('/dashbord',		 					'Admin\Auth1Controller@dashbord');
	
	Route::post('/get_sidebar_counts',		 		'Admin\Auth1Controller@get_sidebar_counts');
	Route::post('/get_sidebar_counts1',		 		'Admin\Auth1Controller@get_sidebar_counts1');
	Route::post('/get_sidebar_counts2',		 		'Admin\Auth1Controller@get_sidebar_counts2');
	Route::post('/get_sidebar_counts3',		 		'Admin\Auth1Controller@get_sidebar_counts3');
	Route::post('/get_sidebar_counts4',		 		'Admin\Auth1Controller@get_sidebar_counts4');
	Route::post('/get_sidebar_counts5',		 		'Admin\Auth1Controller@get_sidebar_counts5');
	Route::post('/get_sidebar_counts6',		 		'Admin\Auth1Controller@get_sidebar_counts6');
	Route::post('/get_sidebar_counts7',		 		'Admin\Auth1Controller@get_sidebar_counts7');
	Route::post('/get_sidebar_counts8',		 		'Admin\Auth1Controller@get_sidebar_counts8');
	Route::post('/get_sidebar_counts9',		 		'Admin\Auth1Controller@get_sidebar_counts9');
	Route::post('/get_sidebar_counts10',		 	'Admin\Auth1Controller@get_sidebar_counts10');
	Route::post('/get_sidebar_counts11',		 	'Admin\Auth1Controller@get_sidebar_counts11');
	Route::post('/get_sidebar_counts12_1',		 	'Admin\Auth1Controller@get_sidebar_counts12_1');
	Route::post('/get_sidebar_counts12_2',		 	'Admin\Auth1Controller@get_sidebar_counts12_2');

	Route::get('/change_pagination_limit',		 	'Admin\Auth1Controller@change_pagination_limit');
	Route::get('/change_password',		 			'Admin\Auth1Controller@change_password');
	Route::post('/change_password_process',		 	'Admin\Auth1Controller@change_password_process');


	Route::get('/manage_sealstock',		 			'Admin\SealstocknewController@index');
	Route::post('/store_sealstock',		 			'Admin\SealstocknewController@store');

	Route::get('/manage_modem',		 				'Admin\ModemnewController@index');
	Route::post('/store_modem',		 				'Admin\ModemnewController@store');

	Route::get('/manage_antennas',		 				'Admin\AntennasController@index');
	Route::post('/store_antennas',		 				'Admin\AntennasController@store');
	//Member
	Route::get('/manage_member',		 			'Admin\MembernewController@index');
	Route::get('/add_member',		 				'Admin\MembernewController@add');
	Route::post('/store_member',		 			'Admin\MembernewController@store');
	Route::get('/view_member/{id}',	 			    'Admin\MembernewController@view');
	Route::get('/edit_member/{id}',		 		    'Admin\MembernewController@edit');
	Route::post('/update_member/{id}',		 	    'Admin\MembernewController@update');
	Route::get('/delete_member/{id}',		 		'Admin\MembernewController@delete');
	Route::get('/assign_mrn_authority',		 		'Admin\MembernewController@assign_mrn_authority');

	//admin
	Route::get('/manage_admin',		 	'Admin\AdminController@index');
	Route::get('/add_admin',		 	'Admin\AdminController@add');
	Route::post('/store_admin',		 	'Admin\AdminController@store');
	Route::get('/view_admin/{id}',	 	'Admin\AdminController@view');
	Route::get('/edit_admin/{id}',		'Admin\AdminController@edit');
	Route::post('/update_admin/{id}',	'Admin\AdminController@update');
	Route::get('/delete_admin/{id}',	'Admin\AdminController@delete');


	//state
	Route::get('/manage_state',		 	'Admin\StateController@index');
	Route::get('/add_state',		 	'Admin\StateController@add');
	Route::post('/store_state',		 	'Admin\StateController@store');
	Route::get('/view_state/{id}',	 	'Admin\StateController@view');
	Route::get('/edit_state/{id}',		'Admin\StateController@edit');
	Route::post('/update_state/{id}',	'Admin\StateController@update');
	Route::get('/delete_state/{id}',	'Admin\StateController@delete');

	//Dispatch
	Route::get('/manage_dispatch',		 			'Admin\DispatchnewController@index');
	Route::get('/dispatch_swh_index',		 		'Admin\DispatchnewController@dispatch_swh_index');
	Route::get('/dispatch_vmwh_index',		 		'Admin\DispatchnewController@dispatch_vmwh_index');
	
	Route::get('/add_dispatch',		 				'Admin\DispatchnewController@add');
	Route::get('/accept_dispatch_swh/{id}',		 	'Admin\DispatchnewController@accept_dispatch_swh');
	Route::post('/store_accept_dispatch_swh',		'Admin\DispatchnewController@store_accept_dispatch_swh');
	Route::get('/accept_dispatch_vmwh/{id}',		 'Admin\DispatchnewController@accept_dispatch_vmwh');
	Route::post('/store_accept_dispatch_vmwh',		'Admin\DispatchnewController@store_accept_dispatch_vmwh');
	Route::post('/store_dispatch',		 			'Admin\DispatchnewController@store');
	Route::post('/form_dispatch_meter_step_1',		'Admin\DispatchnewController@form_dispatch_meter_step_1');
	Route::post('/form_dispatch_meter_step_2',		'Admin\DispatchnewController@form_dispatch_meter_step_2');
	Route::post('/swh_form_dispatch_meter_step_1',	'Admin\DispatchnewController@swh_form_dispatch_meter_step_1');
	Route::post('/swh_form_dispatch_meter_step_2',	'Admin\DispatchnewController@swh_form_dispatch_meter_step_2');
	Route::get('/view_dispatch/{id}',	 			'Admin\DispatchnewController@view_dispatch');
	Route::get('/view_grn_dispatch/{id}',	 			'Admin\DispatchnewController@view_grn_dispatch');
	Route::get('/vmwh_view_grn_dispatch/{id}',	 			'Admin\DispatchnewController@vmwh_view_grn_dispatch');
	
	Route::get('/vmwh_view_dispatch/{id}',	 		'Admin\DispatchnewController@vmwh_view_dispatch');
	Route::get('/edit_dispatch/{id}',		 		'Admin\DispatchnewController@edit');
	Route::post('/update_dispatch/{id}',		 	'Admin\DispatchnewController@update');
	Route::get('/delete_dispatch/{id}',		 		'Admin\DispatchnewController@delete');


	//Report
	Route::get('/report_fresh_wh_inventory',		 				'Admin\ReportController@report_fresh_wh_inventory');
	Route::get('/report_vendor_wh_inventory',		 				'Admin\ReportController@report_vendor_wh_inventory');
	Route::get('/report_faulty_warranty_management',		 				'Admin\ReportController@report_faulty_warranty_management');
	Route::get('/daily_mis',		 				'Admin\ReportController@daily_mis');
	Route::get('/report_inventory_upload_file',		 				'Admin\ReportController@report_inventory_upload_file');
	Route::get('/report_master_mis',		 				'Admin\ReportController@report_master_mis');
	Route::get('/test_report_repaired',		 				'Admin\ReportController@test_report_repaired');
	Route::get('/export_report/{id}',		 				'Admin\ReportController@export_report');


	//MRN
	Route::get('/new_vm_mrn',		 				'Admin\MrnnewController@new_vm_mrn');
	Route::get('/new_swh_mrn',		 				'Admin\MrnnewController@new_swh_mrn');
	Route::get('/recived_swh_mrn',		 			'Admin\MrnnewController@recived_swh_mrn');
	Route::get('/recived_vm_mrn',		 			'Admin\MrnnewController@recived_vm_mrn');
	Route::get('/recived_wh_mrn',		 			'Admin\MrnnewController@recived_wh_mrn');

	Route::get('/add_vm_mrn',		 				'Admin\MrnnewController@add_vm_mrn');
	Route::get('/add_swh_mrn',		 				'Admin\MrnnewController@add_swh_mrn');
	Route::post('/store_vm_mrn',		 			'Admin\MrnnewController@store_vm_mrn');
	Route::post('/store_swh_mrn',		 			'Admin\MrnnewController@store_swh_mrn');
	Route::get('/view_swh_mrn/{id}',	 			'Admin\MrnnewController@view_swh_mrn');
	Route::get('/view_vmwh_mrn/{id}',	 			'Admin\MrnnewController@view_vmwh_mrn');
	Route::get('/edit_vm_mrn/{id}',	 				'Admin\MrnnewController@edit_vm_mrn');
	Route::post('/update_mrn_a_1_mrn/{id}',	 				'Admin\MrnnewController@update_mrn_a_1_mrn');
	Route::post('/status_update_mrn_a_1',	 		'Admin\MrnnewController@status_update_mrn_a_1');
	Route::post('/status_update_mrn_a_2',	 		'Admin\MrnnewController@status_update_mrn_a_2');

	
	Route::get('/mrn_a_1_pending',		 			'Admin\MrnnewController@mrn_a_1_pending');
	Route::get('/mrn_a_1_approved',		 			'Admin\MrnnewController@mrn_a_1_approved');
	Route::get('/mrn_a_1_rejected',		 			'Admin\MrnnewController@mrn_a_1_rejected');
	Route::get('/mrn_a_2_pending_from1',		 	'Admin\MrnnewController@mrn_a_2_pending_from1');
	Route::get('/mrn_a_2_pending',		 			'Admin\MrnnewController@mrn_a_2_pending');
	Route::get('/mrn_a_2_approved',		 			'Admin\MrnnewController@mrn_a_2_approved');
	Route::get('/mrn_a_2_rejected',		 			'Admin\MrnnewController@mrn_a_2_rejected');


	
	//Route::get('/edit_mrn/{id}',		 		    'Admin\MrnnewController@edit');
	//Route::post('/update_mrn/{id}',		 	  	    'Admin\MrnnewController@update');
	//Route::get('/delete_mrn/{id}',		 			'Admin\MrnnewController@delete');

	//Meter
	Route::get('/manage_meter',		 				'Admin\MeternewController@index');
	Route::get('/get_meter_to_admin_pool',		 	'Admin\MeternewController@get_meter_to_admin_pool');
	Route::post('/send_meter_to_vm_pool',		 	'Admin\MeternewController@send_meter_to_vm_pool');
	Route::post('/send_meter_to_sm_pool',		 	'Admin\MeternewController@send_meter_to_sm_pool');

	Route::get('/swh_manage_meter',		 			'Admin\MeternewController@swh_manage_meter');
	Route::get('/vm_manage_meter',		 			'Admin\MeternewController@vm_manage_meter');
	Route::get('/swh_new_manage_meter',		 		'Admin\MeternewController@swh_new_manage_meter');
	Route::get('/vm_new_manage_meter',		 		'Admin\MeternewController@vm_new_manage_meter');
	Route::get('/vm_installation_meter',			'Admin\MeternewController@vm_installation_meter');
	Route::get('/vm_damaged_meter',			        'Admin\MeternewController@vm_damaged_meter');
	Route::get('/admin_damaged_meter',				'Admin\MeternewController@admin_damaged_meter');
	Route::get('/sm_damaged_meter',					'Admin\MeternewController@sm_damaged_meter');
	Route::post('/upload_vm_damaged_meter',			'Admin\MeternewController@upload_vm_damaged_meter');
	Route::post('/upload_swh_accept_damaged_meter', 'Admin\MeternewController@upload_swh_accept_damaged_meter');
	Route::post('/upload_admin_accept_damaged_meter','Admin\MeternewController@upload_admin_accept_damaged_meter');
	Route::get('/vm_to_sm_damaged_meter',			'Admin\MeternewController@vm_to_sm_damaged_meter');
	Route::get('/sm_to_admin_damaged_meter',		'Admin\MeternewController@sm_to_admin_damaged_meter');
	Route::get('/sm_to_admin_pending_acceptance_damaged_meter',			'Admin\MeternewController@sm_to_admin_pending_acceptance_damaged_meter');
	Route::get('/repaired_meter',					'Admin\MeternewController@repaired_meter');
	Route::post('/upload_sm_damaged_meter',			'Admin\MeternewController@upload_sm_damaged_meter');
	Route::post('/upload_admin_repaired_meter',		'Admin\MeternewController@upload_admin_repaired_meter');
	Route::post('/upload_send_to_supplier',			'Admin\MeternewController@upload_send_to_supplier');
	Route::post('/upload_admin_rejected_meter',		'Admin\MeternewController@upload_admin_rejected_meter');
	
	
	Route::post('/tagging_refurbish',					'Admin\MeternewController@tagging_refurbish');
	Route::post('/tagging_non_refurbish',				'Admin\MeternewController@tagging_non_refurbish');
	
	
	// permanent_damage
	Route::post('/upload_permanent_damage',				'Admin\MeternewController@upload_permanent_damage');
	Route::post('/s2s_upload_permanent_damage',			'Admin\MeternewController@s2s_upload_permanent_damage');
	Route::post('/upload_prepare_resend_to_supplier_from_pd',	  'Admin\MeternewController@upload_prepare_resend_to_supplier_from_pd');
	Route::post('/s2s_upload_prepare_resend_to_supplier_from_pd', 'Admin\MeternewController@s2s_upload_prepare_resend_to_supplier_from_pd');
	Route::get('/permanent_damage_meter',				'Admin\MeternewController@permanent_damage_meter');
	Route::get('/s2s_permanent_damage_meter',			'Admin\MeternewController@s2s_permanent_damage_meter');
	Route::get('/edf_meter_pool_all_permanent_damage',	'Admin\MeternewController@edf_meter_pool_all_permanent_damage');

	//s2s damaged meter flow
	Route::get('/s2s_vm_damaged_meter',			    	'Admin\MeternewController@s2s_vm_damaged_meter');
	Route::post('/s2s_upload_vm_damaged_meter',			'Admin\MeternewController@s2s_upload_vm_damaged_meter');
	Route::get('/s2s_vm_to_sm_damaged_meter',			'Admin\MeternewController@s2s_vm_to_sm_damaged_meter');
	Route::post('/s2s_upload_swh_accept_damaged_meter', 'Admin\MeternewController@s2s_upload_swh_accept_damaged_meter');
	Route::get('/s2s_sm_damaged_meter',					'Admin\MeternewController@s2s_sm_damaged_meter');
	Route::post('/s2s_upload_sm_damaged_meter',			'Admin\MeternewController@s2s_upload_sm_damaged_meter');
	Route::get('/s2s_sm_to_admin_pending_acceptance_damaged_meter',			'Admin\MeternewController@s2s_sm_to_admin_pending_acceptance_damaged_meter');
	Route::post('/s2s_upload_admin_accept_damaged_meter','Admin\MeternewController@s2s_upload_admin_accept_damaged_meter');
	Route::get('/s2s_sm_to_admin_damaged_meter',		'Admin\MeternewController@s2s_sm_to_admin_damaged_meter');
	Route::post('/s2s_upload_send_to_supplier',			'Admin\MeternewController@s2s_upload_send_to_supplier');
	Route::post('/s2s_upload_prepare_resend_to_supplier',			'Admin\MeternewController@s2s_upload_prepare_resend_to_supplier');
	Route::post('/upload_prepare_resend_to_supplier',			'Admin\MeternewController@upload_prepare_resend_to_supplier');

	Route::get('/s2s_send_to_supplier',					'Admin\MeternewController@s2s_send_to_supplier');
	Route::get('/s2s_return_from_supplier',				'Admin\MeternewController@s2s_return_from_supplier');
	Route::post('/s2s_upload_admin_repaired_meter',		'Admin\MeternewController@s2s_upload_admin_repaired_meter');

	Route::get('/s2s_supplier_pending_meter',			'Admin\MeternewController@s2s_supplier_pending_meter');
	Route::post('/s2s_supplier_approve_meter',			'Admin\MeternewController@s2s_supplier_approve_meter');
	Route::get('/s2s_supplier_approved_meter',			'Admin\MeternewController@s2s_supplier_approved_meter');
	Route::get('/s2s_supplier_admin_approved_meter',	'Admin\MeternewController@s2s_supplier_admin_approved_meter');
	Route::get('/s2s_repaired_meter',	'Admin\MeternewController@s2s_repaired_meter');

	






	Route::post('/upload_admin_physical_damage_meter','Admin\MeternewController@upload_admin_physical_damage_meter');
	Route::get('/manage_intransit',		 			'Admin\MeternewController@manage_intransit');
	Route::get('/ghost_meter',		    			'Admin\MeternewController@ghost_meter');
	Route::get('/warranty_expiring_in_one_month',		    			'Admin\MeternewController@warranty_expiring_in_one_month');
	Route::get('/edf_installed_meter',				'Admin\MeternewController@edf_installed_meter');
	Route::get('/edf_reject_meter',					'Admin\MeternewController@edf_reject_meter');
	Route::any('/metermovement',					'Admin\MeternewController@metermovement');
	Route::get('/get_sm_mrn',						'Admin\MeternewController@get_sm_mrn');
	Route::get('/get_vm_mrn',						'Admin\MeternewController@get_vm_mrn');


	Route::get('/supplier_pending_meter',			'Admin\MeternewController@supplier_pending_meter');
	Route::post('/supplier_approve_meter',	'Admin\MeternewController@supplier_approve_meter');
	Route::get('/supplier_approved_meter',			'Admin\MeternewController@supplier_approved_meter');
	Route::get('/supplier_pending_admin_meter',		'Admin\MeternewController@supplier_pending_admin_meter');
	Route::get('/supplier_admin_approved_meter',	'Admin\MeternewController@supplier_admin_approved_meter');
	Route::get('/send_to_supplier',					'Admin\MeternewController@send_to_supplier');
	Route::get('/return_from_supplier',				'Admin\MeternewController@return_from_supplier');







	Route::get('/vm_reject_meter',		 			'Admin\MeternewController@vm_reject_meter');
	Route::get('/select_sample',		 			'Admin\MeternewController@select_sample');
	Route::get('/edf_meter_pool',		 			'Admin\MeternewController@edf_meter_pool');
	Route::get('/s2s_edf_meter_pool',		 		'Admin\MeternewController@s2s_edf_meter_pool');
	Route::get('/swh_edf_meter_pool',		 		'Admin\MeternewController@swh_edf_meter_pool');
	Route::get('/edf_sim_pool',		 				'Admin\MeternewController@edf_sim_pool');
	Route::get('/swh_edf_sim_pool',		 			'Admin\MeternewController@swh_edf_sim_pool');
	Route::get('/vmwh_edf_sim_pool',		 		'Admin\MeternewController@vmwh_edf_sim_pool');
	Route::get('/edf_modem_pool',		 			'Admin\MeternewController@edf_modem_pool');
	Route::get('/swh_edf_modem_pool',		 		'Admin\MeternewController@swh_edf_modem_pool');
	Route::get('/vmwh_edf_modem_pool',		 		'Admin\MeternewController@vmwh_edf_modem_pool');
	Route::get('/bulk_activity',		 			'Admin\MeternewController@bulk_activity');
	Route::post('/update_bulk_activity',		 	'Admin\MeternewController@update_bulk_activity');

	Route::get('/assigned_meter',		 			'Admin\MeternewController@assigned_meter');
	Route::get('/swh_assigned_meter',		 		'Admin\MeternewController@swh_assigned_meter');
	Route::get('/swh_reject_meter',		 			'Admin\MeternewController@swh_reject_meter');
	Route::get('/reject_meter',		 				'Admin\MeternewController@reject_meter');
	Route::get('/add_meter',		 				'Admin\MeternewController@add');
	Route::post('/store_meter',		 				'Admin\MeternewController@store');
	Route::post('/store_selected_meters',		 	'Admin\MeternewController@store_selected_meters');
	Route::get('/manage_seleted_meter/{id}',		'Admin\MeternewController@manage_seleted_meter');
	Route::get('/test_report',		 				'Admin\MeternewController@test_report');
	Route::post('/store_testing_meters_status', 	'Admin\MeternewController@store_testing_meters_status');
	Route::post('/store_testing_batch_status', 	    'Admin\MeternewController@store_testing_batch_status');
	Route::get('/manage_physical_testing_meter/{id}',		'Admin\MeternewController@manage_physical_testing_meter');
	Route::get('/physical_test_report',		 				'Admin\MeternewController@physical_test_report');
	Route::post('/store_physical_testing_meters_status', 	'Admin\MeternewController@store_physical_testing_meters_status');
	Route::post('/store_physical_testing_batch_status', 	    'Admin\MeternewController@store_physical_testing_batch_status');

	Route::get('/process_batch/{id}', 	   			'Admin\MeternewController@process_batch');
	Route::get('/batch_list', 	   			'Admin\MeternewController@batch_list');
	Route::get('/view_grn_batch/{id}', 	   			'Admin\MeternewController@view_grn_batch');


	Route::get('/view_meter/{id}',	 				'Admin\MeternewController@view');
	Route::get('/new_view_meter/{id}',	 			'Admin\MeternewController@new_view');
	Route::get('/view_meter_testing/{id}',	 		'Admin\MeternewController@view_meter_testing');
	Route::get('/view_physical_meter_testing/{id}',	'Admin\MeternewController@view_physical_meter_testing');
	Route::get('/edit_meter/{id}',		 		    'Admin\MeternewController@edit');
	Route::post('/update_meter/{id}',		 	    'Admin\MeternewController@update');
	Route::post('/update_meter_sim/{id}',		 	'Admin\MeternewController@update_meter_sim');

	Route::get('/delete_meter/{id}',		 		'Admin\MeternewController@delete');
	Route::get('/download_m',		 				'Admin\MeternewController@download_m');

	Route::get('/uploaded_meter',		 			'Admin\MeternewController@uploaded_meter');
	Route::get('/phisical_tested',		 			'Admin\MeternewController@phisical_tested');
	Route::get('/phisical_damage',		 			'Admin\MeternewController@phisical_damage');
	Route::post('/change_utility',		 			'Admin\MeternewController@change_utility');
	Route::get('/segregated',		 				'Admin\MeternewController@segregated');
	Route::get('/segregated_hesm/{id}',		 		'Admin\MeternewController@segregated_hesm');
	Route::get('/segregated_hess/{id}',		 		'Admin\MeternewController@segregated_hess');
	Route::get('/segregated_hesms/{id}',		 	'Admin\MeternewController@segregated_hesms');
	Route::get('/segregated_mdmm/{id}',		 		'Admin\MeternewController@segregated_mdmm');
	Route::get('/segregated_mdms/{id}',		 		'Admin\MeternewController@segregated_mdms');
	Route::get('/segregated_mdmsm/{id}',		 	'Admin\MeternewController@segregated_mdmsm');
	Route::post('/mdm_hes_update',		 	    	'Admin\MeternewController@mdm_hes_update');
	Route::post('/store_segregated',		 		'Admin\MeternewController@store_segregated');
	Route::get('/report_dumps',		 				'Admin\DumpController@report_dumps');
	Route::get('/dumps_proccess/{id}',		 		'Admin\DumpController@dumps_proccess');
	Route::get('/dumps_proccess_ajax/{id}',		 	'Admin\DumpController@dumps_proccess_ajax');


	Route::get('/add_bsnlsim',		 				'Admin\BsnlsimnewController@add');
	Route::post('/store_bsnlsim',		 			'Admin\BsnlsimnewController@store');
});





Route::post('/api_dashboard_get_admin_c', 			    		 'Admin\CronController@api_dashboard_get_admin_c');
Route::post('/api_dashboard_get_admin_c1', 			    		 'Admin\CronController@api_dashboard_get_admin_c1');
Route::post('/api_dashboard_get_admin_c2', 			    		 'Admin\CronController@api_dashboard_get_admin_c2');
Route::post('/api_dashboard_get_admin_c3', 			    		 'Admin\CronController@api_dashboard_get_admin_c3');

Route::post('/api_dashboard_get_admin_meter_bfc_c2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c2');
Route::post('/api_dashboard_get_admin_meter_bfc_c3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c3');
Route::post('/api_dashboard_get_admin_meter_bfc_c3_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c3_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c3_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c3_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c3_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c3_3');
Route::post('/api_dashboard_get_admin_meter_bfc_c4', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c4');
Route::post('/api_dashboard_get_admin_meter_bfc_c4_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c4_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c4_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c4_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c4_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c4_3');
Route::post('/api_dashboard_get_admin_meter_bfc_c5', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c5');
Route::post('/api_dashboard_get_admin_meter_bfc_c5_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c5_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c5_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c5_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c5_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c5_3');


Route::post('/api_dashboard_get_admin_meter_bfc_c6', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c6');
Route::post('/api_dashboard_get_admin_meter_bfc_c6_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c6_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c6_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c6_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c6_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c6_3');
Route::post('/api_dashboard_get_admin_meter_bfc_c7', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c7');
Route::post('/api_dashboard_get_admin_meter_bfc_c7_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c7_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c7_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c7_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c7_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c7_3');
Route::post('/api_dashboard_get_admin_meter_bfc_c8', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c8');
Route::post('/api_dashboard_get_admin_meter_bfc_c8_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c8_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c8_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c8_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c8_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c8_3');
Route::post('/api_dashboard_get_admin_meter_bfc_c9', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c9');
Route::post('/api_dashboard_get_admin_meter_bfc_c9_1', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c9_1');
Route::post('/api_dashboard_get_admin_meter_bfc_c9_2', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c9_2');
Route::post('/api_dashboard_get_admin_meter_bfc_c9_3', 			 'Admin\CronController@api_dashboard_get_admin_meter_bfc_c9_3');
Route::post('/api_dashboard_get_admin_all_meter', 				 'Admin\CronController@api_dashboard_get_admin_all_meter');

// Route::post('/api_dashboard_get_admin_meter_bfc_c', 			'Admin\CronController@api_dashboard_get_admin_meter_bfc_c');
Route::post('/api_dashboard_get_admin_meter_c', 			    'Admin\CronController@api_dashboard_get_admin_meter_c');
Route::post('/api_admin_meter_tested_c', 			    		'Admin\CronController@api_admin_meter_tested_c');
Route::post('/api_dashboard_admin_meter_pool_c', 			    'Admin\CronController@api_dashboard_admin_meter_pool_c');
Route::post('/api_dashboard_admin_meter_assign_c', 			    'Admin\CronController@api_dashboard_admin_meter_assign_c');
Route::post('/api_dashboard_admin_sim_assign_c', 			    'Admin\CronController@api_dashboard_admin_sim_assign_c');
Route::post('/api_dashboard_admin_sim_utilized_c', 			    'Admin\CronController@api_dashboard_admin_sim_utilized_c');
Route::post('/api_dashboard_admin_sim_unutilized_c', 			'Admin\CronController@api_dashboard_admin_sim_unutilized_c');
Route::post('/api_dashboard_admin_modem_loader_c', 			    'Admin\CronController@api_dashboard_admin_modem_loader_c');
Route::post('/api_dashboard_admin_antena_loader_c', 			'Admin\CronController@api_dashboard_admin_antena_loader_c');
Route::post('/api_dashboard_admin_intransist_loader_c', 		'Admin\CronController@api_dashboard_admin_intransist_loader_c');

Route::post('/api_admin_meter_reject_loader_c', 			    'Admin\CronController@api_admin_meter_reject_loader_c');
Route::post('/api_dashboard_get_vm_meter_c', 			    	'Admin\CronController@api_dashboard_get_vm_meter_c');
Route::post('/api_dashboard_get_vm_modem_c', 			    	'Admin\CronController@api_dashboard_get_vm_modem_c');
Route::post('/api_dashboard_get_vm_sim_c', 			    		'Admin\CronController@api_dashboard_get_vm_sim_c');
Route::post('/api_admin_meter_bifucation_loader_c', 			'Admin\CronController@api_admin_meter_bifucation_loader_c');

Route::post('/api_dashboard_get_mrn1_meter_c', 			    'Admin\CronController@api_dashboard_get_mrn1_meter_c');
Route::post('/api_dashboard_get_mrn1_modem_c', 			    'Admin\CronController@api_dashboard_get_mrn1_modem_c');
Route::post('/api_dashboard_get_mrn1_antenna_c', 			    'Admin\CronController@api_dashboard_get_mrn1_antenna_c');
Route::post('/api_dashboard_get_mrn2_meter_c', 			    'Admin\CronController@api_dashboard_get_mrn2_meter_c');
Route::post('/api_dashboard_get_mrn2_modem_c', 			    'Admin\CronController@api_dashboard_get_mrn2_modem_c');
Route::post('/api_dashboard_get_mrn2_antenna_c', 			    'Admin\CronController@api_dashboard_get_mrn2_antenna_c');

Route::get('/cron_get_origin', 			    'Admin\CronController@cron_get_origin');
Route::get('/cron_daily_meter_inventory', 	'Admin\CronController@cron_daily_meter_inventory');
Route::get('/cron_daily_meter_inventory_map_with_vendor', 			    'Admin\CronController@cron_daily_meter_inventory_map_with_vendor');











Route::group(['middleware' => 'state'], function () 
{
});

Route::group(['middleware' => 'vm'], function () 
{
});




