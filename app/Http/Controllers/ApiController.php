<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Container;
use App\Models\PickupRequest;
use App\Models\TransactionsHistory;
use Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function vehicles(Request $request)
    {
        $vehicles = Vehicle::limit(100)->get();

        if (!empty($request->PageIndex)) {
            if ($request->PageIndex == 1) {
                $vehicles = Vehicle::limit(100)->get();
            } else {
                $offset = ($request->PageIndex - 1) * 100;
                $vehicles = Vehicle::limit(100)->offset((int)$offset)->get();
            }
        }
    
        return $this->sendResponse($vehicles, 'Vehicles retrieved successfully.');
    }

    public function containers(Request $request)
    {
        $containers = Container::limit(100)->get();

        if (!empty($request->PageIndex)) {
            if ($request->PageIndex == 1) {
                $containers = Container::limit(100)->get();
            } else {
                $offset = ($request->PageIndex - 1) * 100;
                $containers = Container::limit(100)->offset((int)$offset)->get();
            }
        }
    
        return $this->sendResponse($containers, 'Containers retrieved successfully.');
    }

    public function sub_users()
    {
        $sub_users = User::where('role', '3')->limit(100)->get();
    
        return $this->sendResponse($sub_users, 'Sub Users retrieved successfully.');
    }

    public function add_sub_user(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
   		$input['role'] = '3';
   		$input['password'] = \Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('KGAutoExport')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'Sub User created successfully.');
    }

    public function update_user_info(Request $request, User $user, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'string',
            'password' => 'min:8'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if (!empty($input['password'])) {
            $check = User::where('id', $id)->first();
            if (\Hash::check($input['old_password'], $check->password)) {
                User::where('id', $id)->update(['name' => $input['name'], 'password' => \Hash::make($input['password'])]);
            } else { 
                return $this->sendError('Old password is incorrect.', ['error' => 'Unauthorised']);
            }
        } else {
            User::where('id', $id)->update(['name' => $input['name']]);
        }

        $user = User::where('id', $id)->first();
   
        return $this->sendResponse($user, 'User updated successfully.');
    }

    public function update_vehicle_info(Request $request, Vehicle $vehicle, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'destination' => 'string'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(empty($input['notes'])){
            $input['notes'] = '';
        }
   
        Vehicle::where('id', $id)->update(['destination_manual' => $input['destination'], 'notes' => $input['notes']]);

        $vehicle = Vehicle::where('id', $id)->first();
   
        return $this->sendResponse($vehicle, 'Vehicle updated successfully.');
    }

    public function pickup_requests($id)
    {
        $pickup_requests = PickupRequest::where('user_id', $id)->get();
    
        return $this->sendResponse($pickup_requests, 'Pickup requests retrieved successfully.');
    }

    public function financial_data($id)
    {
        $financial_data = [];
        $financial_data['history'] = TransactionsHistory::where('user_id', $id)->get();
        $financial_data['total_transactions'] = TransactionsHistory::where('user_id', $id)->sum('amount');
        $financial_data['balance'] = TransactionsHistory::where('user_id', $id)->where('status', 'paid')->sum('amount');
        $financial_data['due_payments'] = TransactionsHistory::where('user_id', $id)->where('status', 'unpaid')->sum('amount');
        $financial_data['due_payments_limit'] = (int)User::where('id', $id)->first()->due_payments_limit;
    
        return $this->sendResponse($financial_data, 'Financial data retrieved successfully.');
    }

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
