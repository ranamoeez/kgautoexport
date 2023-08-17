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

// Route::post('vehicle-images', [ HomeController::class, 'vehicles_images' ])->name('vehicle-images');

Route::prefix('user')->middleware(['auth'])->group(function(){
	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('user-home');
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

	Route::post('/update-vehicle-data', [App\Http\Controllers\Admin\HomeController::class, 'update_vehicle_data'])->name('update-vehicle-data');
	Route::post('/update-container-data', [App\Http\Controllers\Admin\HomeController::class, 'update_container_data'])->name('update-container-data');

	Route::get('/delete-vehicle-fines/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicle_fines'])->name('delete-vehicle-fines');
	Route::get('/delete-vehicle-documents/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicle_documents'])->name('delete-vehicle-documents');
	Route::get('/delete-vehicle-images/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicle_images'])->name('delete-vehicle-images');
	Route::get('/delete-container-documents/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_container_documents'])->name('delete-container-documents');

	Route::get('/get-auction-location/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_auction_location'])->name('get-auction-location');

	Route::get('/get-vehicles/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_vehicles'])->name('get-vehicles');
	Route::post('/assign-vehicle', [App\Http\Controllers\Admin\HomeController::class, 'assign_vehicle'])->name('assign-vehicle');

	Route::get('/pickup-history', [App\Http\Controllers\Admin\HomeController::class, 'pickup_history'])->name('pickup-history');
	Route::post('/update-pickup-data', [App\Http\Controllers\Admin\HomeController::class, 'update_pickup_data'])->name('update-pickup-data');
	
	Route::get('/system-configuration/users', [App\Http\Controllers\Admin\SystemConfigController::class, 'users'])->name('users');
	Route::post('/system-configuration/users/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_user'])->name('add-user');
	Route::get('/system-configuration/users/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_user'])->name('edit-user');
	Route::post('/system-configuration/users/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_user'])->name('update-user');
	Route::get('/system-configuration/users/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_user'])->name('delete-user');

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

	Route::get('/system-configuration/auto-status', [App\Http\Controllers\Admin\SystemConfigController::class, 'auto_status'])->name('auto-status');
	Route::post('/system-configuration/auto-status/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_auto_status'])->name('add-auto-status');
	Route::get('/system-configuration/auto-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auto_status'])->name('edit-auto-status');
	Route::post('/system-configuration/auto-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_auto_status'])->name('update-auto-status');
	Route::get('/system-configuration/auto-status/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_auto_status'])->name('delete-auto-status');

	Route::get('/system-configuration/container-status', [App\Http\Controllers\Admin\SystemConfigController::class, 'container_status'])->name('container-status');
	Route::post('/system-configuration/container-status/add', [App\Http\Controllers\Admin\SystemConfigController::class, 'add_container_status'])->name('add-container-status');
	Route::get('/system-configuration/container-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_container_status'])->name('edit-container-status');
	Route::post('/system-configuration/container-status/edit/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'edit_container_status'])->name('update-container-status');
	Route::get('/system-configuration/container-status/delete/{id}', [App\Http\Controllers\Admin\SystemConfigController::class, 'delete_container_status'])->name('delete-container-status');
});