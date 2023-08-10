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
	Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin-home');
	Route::get('/vehicles', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('vehicles');
	Route::get('/add-vehicle', [App\Http\Controllers\Admin\HomeController::class, 'add_vehicle'])->name('add-vehicle');
	Route::post('/add-vehicle', [App\Http\Controllers\Admin\HomeController::class, 'add_vehicle'])->name('save-vehicle');
	Route::post('/update-vehicle-data', [App\Http\Controllers\Admin\HomeController::class, 'update_vehicle_data'])->name('update-vehicle-data');
	Route::get('/get-auction-location/{id}', [App\Http\Controllers\Admin\HomeController::class, 'get_auction_location'])->name('get-auction-location');
	Route::get('/vehicles/delete/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_vehicles'])->name('delete-vehicles');
	Route::get('/containers', [App\Http\Controllers\Admin\HomeController::class, 'containers'])->name('containers');
	Route::get('/add-container', [App\Http\Controllers\Admin\HomeController::class, 'add_container'])->name('add-container');
	Route::post('/add-container', [App\Http\Controllers\Admin\HomeController::class, 'add_container'])->name('save-container');
	Route::get('/containers/delete/{id}', [App\Http\Controllers\Admin\HomeController::class, 'delete_containers'])->name('delete-containers');
});