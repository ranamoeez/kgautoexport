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

Route::get('/', function () {
	if (\Auth::user()) {
		return redirect(url('admin'));
	}
    return view('auth.login');
});

Auth::routes();

Route::get('/register', function () {
	return redirect(url('/'));
});

Route::post('/post-login', [App\Http\Controllers\HomeController::class, 'post_login'])->name('post-login');

Route::prefix('user')->middleware(['auth'])->group(function(){
	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('user-home');

	Route::post('/add-pickup-request', [App\Http\Controllers\HomeController::class, 'add_pickup_request'])->name('add-pickup-request');
	Route::get('/vehicles', [App\Http\Controllers\HomeController::class, 'vehicles'])->name('user-vehicles');
	Route::get('/vehicles/{id}', [App\Http\Controllers\HomeController::class, 'vehicle_detail'])->name('user-vehicle-detail');
	Route::get('/containers', [App\Http\Controllers\HomeController::class, 'containers'])->name('user-containers');
	Route::get('/containers/{id}', [App\Http\Controllers\HomeController::class, 'container_detail'])->name('user-container-detail');
	Route::get('/financial', [App\Http\Controllers\HomeController::class, 'financial'])->name('user-financial');
	Route::post('/check-password', [App\Http\Controllers\HomeController::class, 'check_password'])->name('check-password');
	Route::post('/assign-vehicle', [App\Http\Controllers\HomeController::class, 'assign_vehicle'])->name('user-assign-vehicle');
	Route::post('/money-transfer', [App\Http\Controllers\HomeController::class, 'money_transfer'])->name('money-transfer');
	Route::post('/add-post', [App\Http\Controllers\HomeController::class, 'add_post'])->name('add-post');
	Route::post('/add-notes', [App\Http\Controllers\HomeController::class, 'add_notes'])->name('add-notes');
	Route::post('/update-destination', [App\Http\Controllers\HomeController::class, 'update_destination'])->name('update-destination');
});

Route::prefix('admin')->middleware(['auth'])->group(function(){
	Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'vehicles'])->name('admin-home');

	Route::get('/vehicles', [App\Http\Controllers\Admin\HomeController::class, 'vehicles'])->name('vehicles');
	Route::get('/vehicles/add', [App\Http\Controllers\Admin\HomeController::class, 'add_vehicle'])->name('add-vehicle');
	Route::post('/vehicles/add', [App\Http\Controllers\Admin\HomeController::class, 'add_vehicle'])->name('save-vehicle');
	Route::get('/vehicles/edit/{id}', [App\Http\Controllers\Admin\HomeController::class, 'edit_vehicle'])->name('edit-vehicle');
	Route::post('/vehicles/edit/{id}', [App\Http\Controllers\Admin\HomeController::class, 'edit_vehicle'])->name('update-vehicle');
	Route::get('/vehicles/delete/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicles'])->name('delete-vehicles');
	
	Route::get('/containers', [App\Http\Controllers\Admin\HomeController::class, 'containers'])->name('containers');
	Route::get('/containers/add', [App\Http\Controllers\Admin\HomeController::class, 'add_container'])->name('add-container');
	Route::post('/containers/add', [App\Http\Controllers\Admin\HomeController::class, 'add_container'])->name('save-container');
	Route::get('/containers/edit/{id}', [App\Http\Controllers\Admin\HomeController::class, 'edit_container'])->name('edit-container');
	Route::post('/containers/edit/{id}', [App\Http\Controllers\Admin\HomeController::class, 'edit_container'])->name('update-container');
	Route::get('/containers/delete/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_containers'])->name('delete-containers');
	Route::get('/delete-buyer/{c_id}/{u_id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_buyer'])->name('delete-buyer');
	Route::get('/delete-buyer-vehicle/{c_id}/{u_id}/{v_id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_buyer_vehicle'])->name('delete-buyer-vehicle');

	Route::post('/update-vehicle-data', [App\Http\Controllers\Admin\HomeController::class, 'update_vehicle_data'])->name('update-vehicle-data');
	Route::post('/update-container-data', [App\Http\Controllers\Admin\HomeController::class, 'update_container_data'])->name('update-container-data');

	Route::get('/delete-vehicle-fines/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicle_fines'])->name('delete-vehicle-fines');
	Route::get('/delete-vehicle-documents/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicle_documents'])->name('delete-vehicle-documents');
	Route::get('/delete-vehicle-images/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicle_images'])->name('delete-vehicle-images');
	Route::get('/delete-container-documents/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_container_documents'])->name('delete-container-documents');

	Route::get('/get-auction-location/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_auction_location'])->name('get-auction-location');
	Route::get('/get-vehicle-modal/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicle_modal'])->name('get-vehicle-modal');
	Route::get('/get-vehicle-vin/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicle_vin'])->name('get-vehicle-vin');
	Route::get('/get-vehicle-detail/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicle_detail'])->name('get-vehicle-detail');
	Route::get('/get-vehicle-notes/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicle_notes'])->name('get-vehicle-notes');
	Route::get('/get-vehicle-financial/{id}/{buyer_id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicle_financial'])->name('get-vehicle-financial');

	Route::get('/get-vehicles/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicles'])->name('get-vehicles');
	Route::post('/assign-vehicle', [App\Http\Controllers\Admin\HomeController::class, 'assign_vehicle'])->name('assign-vehicle');
	Route::get('/send-to-buyer/{id}', [App\Http\Controllers\Admin\HomeController::class, 'send_to_buyer'])->name('send-to-buyer');
	Route::get('/send-to-cont-buyer/{id}', [App\Http\Controllers\Admin\HomeController::class, 'send_to_cont_buyer'])->name('send-to-cont-buyer');
	Route::get('/create-invoice/{id}', [App\Http\Controllers\HomeController::class, 'create_invoice'])->name('create-invoice');

	Route::get('/pickup-history', [App\Http\Controllers\Admin\HomeController::class, 'pickup_history'])->name('pickup-history');
	Route::post('/update-pickup-data', [App\Http\Controllers\Admin\HomeController::class, 'update_pickup_data'])->name('update-pickup-data');
	Route::post('/update-money-data', [App\Http\Controllers\Admin\HomeController::class, 'update_money_data'])->name('update-money-data');
	
	Route::get('/financial-system', [App\Http\Controllers\Admin\HomeController::class, 'financial_system'])->name('financial-system');
	Route::post('/pay-all', [App\Http\Controllers\Admin\HomeController::class, 'pay_all'])->name('pay-all');
	Route::post('/add-balance', [App\Http\Controllers\Admin\HomeController::class, 'add_balance'])->name('add-balance');
	Route::post('/add-comment', [App\Http\Controllers\Admin\HomeController::class, 'add_comment'])->name('add-comment');
	Route::post('/transaction-history', [App\Http\Controllers\Admin\HomeController::class, 'transaction_history'])->name('transaction-history');
	Route::get('/money-transfer', [App\Http\Controllers\Admin\HomeController::class, 'money_transfer'])->name('get-money-transfer');
	Route::post('/send-reminder', [App\Http\Controllers\Admin\HomeController::class, 'send_reminder'])->name('send-reminder');
	
	Route::get('/system-configuration/users', [App\Http\Controllers\Admin\SystemConfigController::class, 'users'])->name('users');
	Route::post('/system-configuration/users/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_user'])->name('add-user');
	Route::get('/system-configuration/users/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_user'])->name('edit-user');
	Route::post('/system-configuration/users/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_user'])->name('update-user');
	Route::get('/system-configuration/users/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_user'])->name('delete-user');

	Route::get('/system-configuration/admins', [App\Http\Controllers\Admin\SystemConfigController::class, 'admins'])->name('admins');
	Route::post('/system-configuration/admins/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_admin'])->name('add-admin');
	Route::get('/system-configuration/admins/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_admin'])->name('edit-admin');
	Route::post('/system-configuration/admins/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_admin'])->name('update-admin');
	Route::get('/system-configuration/admins/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_admin'])->name('delete-admin');

	Route::get('/system-configuration/operators', [App\Http\Controllers\Admin\SystemConfigController::class, 'operators'])->name('operators');
	Route::post('/system-configuration/operators/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_operator'])->name('add-operator');
	Route::get('/system-configuration/operators/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_operator'])->name('edit-operator');
	Route::post('/system-configuration/operators/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_operator'])->name('update-operator');
	Route::get('/system-configuration/operators/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_operator'])->name('delete-operator');

	Route::get('/system-configuration/admin-role', [App\Http\Controllers\Admin\SystemConfigController::class, 'admin_role'])->name('admin-role');
	Route::post('/system-configuration/admin-role/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_admin_role'])->name('add-admin-role');
	Route::get('/system-configuration/admin-role/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_admin_role'])->name('edit-admin-role');
	Route::post('/system-configuration/admin-role/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_admin_role'])->name('update-admin-role');
	Route::get('/system-configuration/admin-role/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_admin_role'])->name('delete-admin-role');

	Route::get('/system-configuration/group-list', [App\Http\Controllers\Admin\SystemConfigController::class, 'group_list'])->name('group-list');
	Route::post('/system-configuration/group-list/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_group_list'])->name('add-group-list');
	Route::get('/system-configuration/group-list/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_group_list'])->name('edit-group-list');
	Route::post('/system-configuration/group-list/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_group_list'])->name('update-group-list');
	Route::get('/system-configuration/group-list/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_group_list'])->name('delete-group-list');

	Route::get('/system-configuration/login-history', [App\Http\Controllers\Admin\SystemConfigController::class, 'login_history'])->name('login-history');

	Route::get('/system-configuration/container-status', [App\Http\Controllers\Admin\SystemConfigController::class, 'container_status'])->name('container-status');
	Route::post('/system-configuration/container-status/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_container_status'])->name('add-container-status');
	Route::get('/system-configuration/container-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_container_status'])->name('edit-container-status');
	Route::post('/system-configuration/container-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_container_status'])->name('update-container-status');
	Route::get('/system-configuration/container-status/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_container_status'])->name('delete-container-status');

	Route::get('/system-configuration/shipper', [App\Http\Controllers\Admin\SystemConfigController::class, 'shipper'])->name('shipper');
	Route::post('/system-configuration/shipper/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_shipper'])->name('add-shipper');
	Route::get('/system-configuration/shipper/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_shipper'])->name('edit-shipper');
	Route::post('/system-configuration/shipper/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_shipper'])->name('update-shipper');
	Route::get('/system-configuration/shipper/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_shipper'])->name('delete-shipper');

	Route::get('/system-configuration/consignee', [App\Http\Controllers\Admin\SystemConfigController::class, 'consignee'])->name('consignee');
	Route::post('/system-configuration/consignee/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_consignee'])->name('add-consignee');
	Route::get('/system-configuration/consignee/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_consignee'])->name('edit-consignee');
	Route::post('/system-configuration/consignee/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_consignee'])->name('update-consignee');
	Route::get('/system-configuration/consignee/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_consignee'])->name('delete-consignee');

	Route::get('/system-configuration/terminal', [App\Http\Controllers\Admin\SystemConfigController::class, 'terminal'])->name('terminal');
	Route::post('/system-configuration/terminal/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_terminal'])->name('add-terminal');
	Route::get('/system-configuration/terminal/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_terminal'])->name('edit-terminal');
	Route::post('/system-configuration/terminal/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_terminal'])->name('update-terminal');
	Route::get('/system-configuration/terminal/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_terminal'])->name('delete-terminal');

	Route::get('/system-configuration/pre-carriage', [App\Http\Controllers\Admin\SystemConfigController::class, 'pre_carriage'])->name('pre-carriage');
	Route::post('/system-configuration/pre-carriage/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_pre_carriage'])->name('add-pre-carriage');
	Route::get('/system-configuration/pre-carriage/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_pre_carriage'])->name('edit-pre-carriage');
	Route::post('/system-configuration/pre-carriage/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_pre_carriage'])->name('update-pre-carriage');
	Route::get('/system-configuration/pre-carriage/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_pre_carriage'])->name('delete-pre-carriage');

	Route::get('/system-configuration/loading-port', [App\Http\Controllers\Admin\SystemConfigController::class, 'loading_port'])->name('loading-port');
	Route::post('/system-configuration/loading-port/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_loading_port'])->name('add-loading-port');
	Route::get('/system-configuration/loading-port/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_loading_port'])->name('edit-loading-port');
	Route::post('/system-configuration/loading-port/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_loading_port'])->name('update-loading-port');
	Route::get('/system-configuration/loading-port/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_loading_port'])->name('delete-loading-port');

	Route::get('/system-configuration/discharge-port', [App\Http\Controllers\Admin\SystemConfigController::class, 'discharge_port'])->name('discharge-port');
	Route::post('/system-configuration/discharge-port/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_discharge_port'])->name('add-discharge-port');
	Route::get('/system-configuration/discharge-port/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_discharge_port'])->name('edit-discharge-port');
	Route::post('/system-configuration/discharge-port/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_discharge_port'])->name('update-discharge-port');
	Route::get('/system-configuration/discharge-port/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_discharge_port'])->name('delete-discharge-port');

	Route::get('/system-configuration/destination-port', [App\Http\Controllers\Admin\SystemConfigController::class, 'destination_port'])->name('destination-port');
	Route::post('/system-configuration/destination-port/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_destination_port'])->name('add-destination-port');
	Route::get('/system-configuration/destination-port/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_destination_port'])->name('edit-destination-port');
	Route::post('/system-configuration/destination-port/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_destination_port'])->name('update-destination-port');
	Route::get('/system-configuration/destination-port/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_destination_port'])->name('delete-destination-port');

	Route::get('/system-configuration/notify-party', [App\Http\Controllers\Admin\SystemConfigController::class, 'notify_party'])->name('notify-party');
	Route::post('/system-configuration/notify-party/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_notify_party'])->name('add-notify-party');
	Route::get('/system-configuration/notify-party/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_notify_party'])->name('edit-notify-party');
	Route::post('/system-configuration/notify-party/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_notify_party'])->name('update-notify-party');
	Route::get('/system-configuration/notify-party/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_notify_party'])->name('delete-notify-party');

	Route::get('/system-configuration/measurement', [App\Http\Controllers\Admin\SystemConfigController::class, 'measurement'])->name('measurement');
	Route::post('/system-configuration/measurement/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_measurement'])->name('add-measurement');
	Route::get('/system-configuration/measurement/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_measurement'])->name('edit-measurement');
	Route::post('/system-configuration/measurement/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_measurement'])->name('update-measurement');
	Route::get('/system-configuration/measurement/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_measurement'])->name('delete-measurement');

	Route::get('/system-configuration/shipping-line', [App\Http\Controllers\Admin\SystemConfigController::class, 'shipping_line'])->name('shipping-line');
	Route::post('/system-configuration/shipping-line/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_shipping_line'])->name('add-shipping-line');
	Route::get('/system-configuration/shipping-line/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_shipping_line'])->name('edit-shipping-line');
	Route::post('/system-configuration/shipping-line/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_shipping_line'])->name('update-shipping-line');
	Route::get('/system-configuration/shipping-line/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_shipping_line'])->name('delete-shipping-line');

	Route::get('/system-configuration/auto-status', [App\Http\Controllers\Admin\SystemConfigController::class, 'auto_status'])->name('auto-status');
	Route::post('/system-configuration/auto-status/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_auto_status'])->name('add-auto-status');
	Route::get('/system-configuration/auto-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auto_status'])->name('edit-auto-status');
	Route::post('/system-configuration/auto-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auto_status'])->name('update-auto-status');
	Route::get('/system-configuration/auto-status/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_auto_status'])->name('delete-auto-status');

	Route::get('/system-configuration/auto-terminal', [App\Http\Controllers\Admin\SystemConfigController::class, 'auto_terminal'])->name('auto-terminal');
	Route::post('/system-configuration/auto-terminal/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_auto_terminal'])->name('add-auto-terminal');
	Route::get('/system-configuration/auto-terminal/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auto_terminal'])->name('edit-auto-terminal');
	Route::post('/system-configuration/auto-terminal/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auto_terminal'])->name('update-auto-terminal');
	Route::get('/system-configuration/auto-terminal/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_auto_terminal'])->name('delete-auto-terminal');

	Route::get('/system-configuration/auction', [App\Http\Controllers\Admin\SystemConfigController::class, 'auction'])->name('auction');
	Route::post('/system-configuration/auction/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_auction'])->name('add-auction');
	Route::get('/system-configuration/auction/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auction'])->name('edit-auction');
	Route::post('/system-configuration/auction/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auction'])->name('update-auction');
	Route::get('/system-configuration/auction/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_auction'])->name('delete-auction');

	Route::get('/system-configuration/auction-location', [App\Http\Controllers\Admin\SystemConfigController::class, 'auction_location'])->name('auction-location');
	Route::post('/system-configuration/auction-location/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_auction_location'])->name('add-auction-location');
	Route::get('/system-configuration/auction-location/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auction_location'])->name('edit-auction-location');
	Route::post('/system-configuration/auction-location/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auction_location'])->name('update-auction-location');
	Route::get('/system-configuration/auction-location/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_auction_location'])->name('delete-auction-location');

	Route::get('/system-configuration/posts', [App\Http\Controllers\Admin\SystemConfigController::class, 'posts'])->name('posts');

	Route::get('/system-configuration/mail-templates', [App\Http\Controllers\Admin\SystemConfigController::class, 'mail_templates'])->name('mail-templates');
	Route::post('/system-configuration/mail-templates/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_mail_templates'])->name('add-mail-templates');
	Route::get('/system-configuration/mail-templates/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_mail_templates'])->name('edit-mail-templates');
	Route::post('/system-configuration/mail-templates/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_mail_templates'])->name('update-mail-templates');
	Route::get('/system-configuration/mail-templates/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_mail_templates'])->name('delete-mail-templates');

	Route::get('/system-configuration/send-to-all-users', [App\Http\Controllers\Admin\SystemConfigController::class, 'send_to_all_users'])->name('send-to-all-users');
	Route::post('/system-configuration/send-to-all-users/send', [App\Http\Controllers\Admin\SystemConfigController::class, 'send_to_all_users_send'])->name('send-to-all-users-send');

	Route::get('/system-configuration/reminder-templates', [App\Http\Controllers\Admin\SystemConfigController::class, 'reminder_templates'])->name('reminder-templates');
	Route::post('/system-configuration/reminder-templates/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_reminder_templates'])->name('add-reminder-templates');
	Route::get('/system-configuration/reminder-templates/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_reminder_templates'])->name('edit-reminder-templates');
	Route::post('/system-configuration/reminder-templates/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_reminder_templates'])->name('update-reminder-templates');
	Route::get('/system-configuration/reminder-templates/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_reminder_templates'])->name('delete-reminder-templates');

	Route::get('/system-configuration/vehicles-brand', [App\Http\Controllers\Admin\SystemConfigController::class, 'vehicles_brand'])->name('vehicles-brand');
	Route::post('/system-configuration/vehicles-brand/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_vehicles_brand'])->name('add-vehicles-brand');
	Route::get('/system-configuration/vehicles-brand/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_vehicles_brand'])->name('edit-vehicles-brand');
	Route::post('/system-configuration/vehicles-brand/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_vehicles_brand'])->name('update-vehicles-brand');
	Route::get('/system-configuration/vehicles-brand/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_vehicles_brand'])->name('delete-vehicles-brand');

	Route::get('/system-configuration/vehicles-modal', [App\Http\Controllers\Admin\SystemConfigController::class, 'vehicles_modal'])->name('vehicles-modal');
	Route::post('/system-configuration/vehicles-modal/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_vehicles_modal'])->name('add-vehicles-modal');
	Route::get('/system-configuration/vehicles-modal/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_vehicles_modal'])->name('edit-vehicles-modal');
	Route::post('/system-configuration/vehicles-modal/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_vehicles_modal'])->name('update-vehicles-modal');
	Route::get('/system-configuration/vehicles-modal/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_vehicles_modal'])->name('delete-vehicles-modal');

	Route::get('/system-configuration/user-levels', [App\Http\Controllers\Admin\SystemConfigController::class, 'user_levels'])->name('user-levels');
	Route::post('/system-configuration/user-levels/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_user_levels'])->name('add-user-levels');
	Route::get('/system-configuration/user-levels/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_user_levels'])->name('edit-user-levels');
	Route::post('/system-configuration/user-levels/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_user_levels'])->name('update-user-levels');
	Route::get('/system-configuration/user-levels/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_user_levels'])->name('delete-user-levels');

	Route::get('/system-configuration/admin-levels', [App\Http\Controllers\Admin\SystemConfigController::class, 'admin_levels'])->name('admin-levels');
	Route::post('/system-configuration/admin-levels/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_admin_levels'])->name('add-admin-levels');
	Route::get('/system-configuration/admin-levels/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_admin_levels'])->name('edit-admin-levels');
	Route::post('/system-configuration/admin-levels/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_admin_levels'])->name('update-admin-levels');
	Route::get('/system-configuration/admin-levels/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_admin_levels'])->name('delete-admin-levels');

	Route::get('/system-configuration/operator-levels', [App\Http\Controllers\Admin\SystemConfigController::class, 'operator_levels'])->name('operator-levels');
	Route::post('/system-configuration/operator-levels/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_operator_levels'])->name('add-operator-levels');
	Route::get('/system-configuration/operator-levels/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_operator_levels'])->name('edit-operator-levels');
	Route::post('/system-configuration/operator-levels/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_operator_levels'])->name('update-operator-levels');
	Route::get('/system-configuration/operator-levels/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_operator_levels'])->name('delete-operator-levels');

	Route::get('/system-configuration/fine-type', [App\Http\Controllers\Admin\SystemConfigController::class, 'fine_type'])->name('fine-type');
	Route::post('/system-configuration/fine-type/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_fine_type'])->name('add-fine-type');
	Route::get('/system-configuration/fine-type/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_fine_type'])->name('edit-fine-type');
	Route::post('/system-configuration/fine-type/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_fine_type'])->name('update-fine-type');
	Route::get('/system-configuration/fine-type/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_fine_type'])->name('delete-fine-type');

	Route::get('/system-configuration/trans-fine-type', [App\Http\Controllers\Admin\SystemConfigController::class, 'trans_fine_type'])->name('trans-fine-type');
	Route::post('/system-configuration/trans-fine-type/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_trans_fine_type'])->name('add-trans-fine-type');
	Route::get('/system-configuration/trans-fine-type/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_trans_fine_type'])->name('edit-trans-fine-type');
	Route::post('/system-configuration/trans-fine-type/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_trans_fine_type'])->name('update-trans-fine-type');
	Route::get('/system-configuration/trans-fine-type/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_trans_fine_type'])->name('delete-trans-fine-type');
});