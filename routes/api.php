<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [ApiController::class, 'login']);
Route::post('financial-login', [ApiController::class, 'financial_login']);
Route::get('vehicles', [ApiController::class, 'vehicles']);
Route::get('containers', [ApiController::class, 'containers']);
Route::get('sub-users', [ApiController::class, 'sub_users']);
Route::post('add-sub-user', [ApiController::class, 'add_sub_user']);
Route::post('update-user-info/{id}', [ApiController::class, 'update_user_info']);
Route::post('update-vehicle-info/{id}', [ApiController::class, 'update_vehicle_info']);
Route::get('pickup-requests/{id}', [ApiController::class, 'pickup_requests']);
Route::get('financial-data/{id}', [ApiController::class, 'financial_data']);
Route::post('send-vehicle', [ApiController::class, 'send_vehicle']);
Route::post('send-pickup-request/{id}', [ApiController::class, 'send_pickup_request']);
Route::post('send-notes', [ApiController::class, 'send_notes']);
Route::post('send-vehicle-images', [ApiController::class, 'send_vehicle_images']);
Route::get('operator-containers/{id}', [ApiController::class, 'operator_containers']);
Route::post('add-user-to-vehicle', [ApiController::class, 'add_user_to_vehicle']);
Route::post('update-pickup-request', [ApiController::class, 'update_pickup_request']);
Route::get('users', [ApiController::class, 'users']);
Route::get('destination-port', [ApiController::class, 'destination_port']);
Route::get('logout/{id}', [ApiController::class, 'logout']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
