<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Container;
use App\Models\PickupRequest;
use App\Models\TransactionsHistory;
use App\Models\Status;
use Validator;
use Storage;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] = $user;

            User::where('id', Auth::user()->id)->update(['api_token' => $success['token']]);
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function vehicles(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $vehicles = Vehicle::orderBy('id', 'DESC')->with('vehicle_images', 'auction', 'auction_location', 'terminal', 'status', 'buyer');

                if (!empty($request->Status)) {
                    $status = Status::where('name', $request->Status)->first();
                    if (!empty($status->id)) {
                        $vehicles = $vehicles->where('status_id', $status->id);
                    }
                }

                if (!empty($request->PageIndex)) {
                    if ($request->PageIndex > 1) {
                        $offset = ($request->PageIndex - 1) * 100;
                        $vehicles = $vehicles->offset((int)$offset);
                    }
                }

                $vehicles = $vehicles->limit(100)->get();
            
                return $this->sendResponse($vehicles, 'Vehicles retrieved successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function containers(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $containers = Container::orderBy('id', 'DESC')->with('container_images', 'status', 'shipper', '', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->limit(100)->get();

                if (!empty($request->PageIndex)) {
                    if ($request->PageIndex == 1) {
                        $containers = Container::orderBy('id', 'DESC')->with('container_images', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->limit(100)->get();
                    } else {
                        $offset = ($request->PageIndex - 1) * 100;
                        $containers = Container::orderBy('id', 'DESC')->with('container_images', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->limit(100)->offset((int)$offset)->get();
                    }
                }
            
                return $this->sendResponse($containers, 'Containers retrieved successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function sub_users(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $sub_users = User::where('role', '3')->orderBy('id', 'DESC')->limit(100)->get();
            
                return $this->sendResponse($sub_users, 'Sub Users retrieved successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function add_sub_user(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
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
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function update_user_info(Request $request, User $user, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
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
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function update_vehicle_info(Request $request, Vehicle $vehicle, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
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
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function pickup_requests(Request $request, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $pickup_requests = PickupRequest::orderBy('id', 'DESC')->with('vehicle')->where('user_id', $id)->get();
            
                return $this->sendResponse($pickup_requests, 'Pickup requests retrieved successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function financial_data(Request $request, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $financial_data = [];
                $financial_data['history'] = TransactionsHistory::with('vehicle')->where('user_id', $id)->get();
                $financial_data['total_transactions'] = TransactionsHistory::where('user_id', $id)->where('status', 'paid')->sum('amount');
                $financial_data['balance'] = TransactionsHistory::where('user_id', $id)->where('status', 'paid')->sum('amount');
                $financial_data['due_payments'] = TransactionsHistory::where('user_id', $id)->where('status', 'unpaid')->sum('amount');
                $financial_data['due_payments_limit'] = (int)User::where('id', $id)->first()->due_payments_limit;
            
                return $this->sendResponse($financial_data, 'Financial data retrieved successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function send_vehicle(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $input = $request->all();
           
                $validator = Validator::make($input, [
                    'email' => 'required|email',
                    'vehicle_id' => 'required'
                ]);
           
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }

                $vehicle = Vehicle::where('id', $input['vehicle_id'])->first();

                if (!empty($vehicle)) {
                    \Mail::to($input['email'])->send(new \App\Mail\SendVehicle($vehicle));
                } else {
                    return $this->sendError('Not Found.', ['error'=>'Vehicle not found.']);
                }
           
                return $this->sendResponse($vehicle, 'Email sended successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function send_pickup_request(Request $request, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $input = $request->all();
           
                $validator = Validator::make($input, [
                    'vehicle_id' => 'required'
                ]);
           
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
           
                $vehicle = Vehicle::where('id', $input['vehicle_id'])->first();

                if (!empty($vehicle)) {
                    $pickup_request = new PickupRequest;
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        $filename = Storage::putFile("pickup-request", $file);
                        $pickup_request->file = $filename;
                    }
                    $pickup_request->user_id = $id;
                    $pickup_request->vehicle_id = $input['vehicle_id'];
                    $pickup_request->comments = $input['comments'];
                    $pickup_request->save();
                } else {
                    return $this->sendError('Not Found.', ['error'=>'Vehicle not found.']);
                }

                $success['id'] =  $pickup_request->id;
           
                return $this->sendResponse($success, 'Pickup request created successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function send_notes(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $input = $request->all();
           
                $validator = Validator::make($input, [
                    'vehicle_id' => 'required',
                    'notes' => 'required'
                ]);
           
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
           
                $vehicle = Vehicle::where('id', $input['vehicle_id'])->first();

                if (!empty($vehicle)) {
                    Vehicle::where('id', $input['vehicle_id'])->update(["notes_user" => $input['notes']]);
                } else {
                    return $this->sendError('Not Found.', ['error'=>'Vehicle not found.']);
                }

                $success['id'] =  $input['vehicle_id'];
           
                return $this->sendResponse($success, 'Notes sended successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function logout(Request $request, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                User::where('id', $id)->update(['api_token' => '']);
            
                return $this->sendResponse('[]', 'User sign out successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
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
