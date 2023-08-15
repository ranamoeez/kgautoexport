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

	Route::get('/system-configuration/auto-status', [App\Http\Controllers\Admin\SystemConfigController::class, 'auto_status'])->name('auto-status');
	Route::get('/system-configuration/container-status', [App\Http\Controllers\Admin\SystemConfigController::class, 'container_status'])->name('container-status');
});