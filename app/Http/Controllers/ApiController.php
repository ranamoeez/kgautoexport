<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\Container;
use App\Models\PickupRequest;
use App\Models\TransactionsHistory;
use App\Models\Status;
use App\Models\AssignVehicle;
use App\Models\UserLoginLog;
use App\Models\ContainerVehicle;
use Validator;
use Storage;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user();
            if (!empty(User::where('id', Auth::user()->id)->first()->api_token)) {
                $success['token'] = $user->api_token;
            } else {
                $success['token'] = $user->createToken('MyApp')->accessToken;
            }
            $success['user'] = User::with("user_level", "operator_level")->where('id', Auth::user()->id)->first();

            $log = new UserLoginLog;
            $log->user_id = $user->id;
            $log->datetime = date("Y-m-d H:i:s");
            $log->save();

            User::where('id', Auth::user()->id)->update(['api_token' => $success['token'], 'fcm_token' => $request->fcm_token]);
   
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
                $user_id = User::where('api_token', $token)->first()->id;

                $vehicles = AssignVehicle::orderBy('id', 'DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.destination_port', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer', 'container.container_documents', 'container.status', 'container.shipper', 'container.shipping_line', 'container.consignee', 'container.pre_carriage', 'container.loading_port', 'container.discharge_port', 'container.destination_port', 'container.notify_party', 'container.pier_terminal', 'container.measurement')->where('user_id', $user_id)->limit(100)->get();

                if (!empty($request->Status)) {
                    $status = Status::where('name', $request->Status)->first();
                    if (!empty($status->id)) {
                        $status_id = $status->id;
                        $vehicles = AssignVehicle::orderBy('id', 'DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.destination_port', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer', 'container.container_documents', 'container.status', 'container.shipper', 'container.shipping_line', 'container.consignee', 'container.pre_carriage', 'container.loading_port', 'container.discharge_port', 'container.destination_port', 'container.notify_party', 'container.pier_terminal', 'container.measurement')->whereHas('vehicle', function ($query) use($status_id) {
                                $query->where('status_id', $status_id);
                            })->where('user_id', $user_id)->limit(100)->get();
                    }
                }

                if (!empty($request->PageIndex)) {
                    if ($request->PageIndex > 1) {
                        $offset = ($request->PageIndex - 1) * 100;
                        $vehicles = AssignVehicle::orderBy('id', 'DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.destination_port', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer', 'container.container_documents', 'container.status', 'container.shipper', 'container.shipping_line', 'container.consignee', 'container.pre_carriage', 'container.loading_port', 'container.discharge_port', 'container.destination_port', 'container.notify_party', 'container.pier_terminal', 'container.measurement')->where('user_id', $user_id)->offset((int)$offset)->limit(100)->get();
                    }
                }
            
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
                $user_id = User::where('api_token', $token)->first()->id;

                $containers = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
                    $q->where("user_id", $user_id);
                })->limit(100)->get();

                if (!empty($request->PageIndex)) {
                    if ($request->PageIndex == 1) {
                        $containers = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
                            $q->where("user_id", $user_id);
                        })->limit(100)->get();
                    } else {
                        $offset = ($request->PageIndex - 1) * 100;
                        $containers = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
                            $q->where("user_id", $user_id);
                        })->limit(100)->offset((int)$offset)->get();
                    }
                }

                foreach ($containers as $key => $value) {
                    $vehicles = AssignVehicle::with('user', 'vehicle')->where('assigned_to', $value->id)->get();
                    $containers[$key]['vehicles'] = $vehicles;
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
                $user_id = User::where('api_token', $token)->first()->id;

                $sub_users = User::where('role', '3')->where('main_user_id', $user_id)->orderBy('id', 'DESC')->limit(100)->get();
            
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
                $user_id = User::where('api_token', $token)->first()->id;
           
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
                $input['main_user_id'] = $user_id;
                $user = User::create($input);
           
                return $this->sendResponse($user, 'Sub User created successfully.');
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
                $pickup_requests = PickupRequest::orderBy('id', 'DESC')->with('user', 'vehicle');

                if (!empty($request->client)) {
                    $client = $request->client;
                    $pickup_requests = $pickup_requests->whereHas('user', function ($q) use($client)
                    {
                        $q->where("surname", $client);
                    });
                }
                if (!empty($request->start_date)) {
                    $pickup_requests = $pickup_requests->where("created_at", ">", $request->start_date);
                }
                if (!empty($request->end_date)) {
                    $pickup_requests = $pickup_requests->where("created_at", "<", $request->end_date);
                }
                if (!empty($request->status)) {
                    $pickup_requests = $pickup_requests->where("status", $request->status);
                }

                $pickup_requests = $pickup_requests->where('user_id', $id)->get();

                foreach ($pickup_requests as $key => $value) {
                    $transaction = AssignVehicle::where('user_id', $id)->where("vehicle_id", $value->vehicle_id)->first();
                    $pickup_requests[$key]['payment_status'] = @$transaction->payment_status;
                }
            
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

                $vehicle = Vehicle::with('destination_port')->where('id', $input['vehicle_id'])->first();

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
                    $pickup_request->picker_name = @$input['picker_name'];
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

    public function send_vehicle_images(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $input = $request->all();
           
            $validator = Validator::make($input, [
                'container_number' => 'required',
                'images' => 'required'
            ]);
       
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
       
            $container = Container::where("container_no", $input['container_number'])->first();

            if (!empty($container)) {
                $all_vehicles = ContainerVehicle::where('container_id', $container->id)->whereHas('vehicle')->get();
                if ($request->hasFile('images')) {
                    foreach ($all_vehicles as $k => $v) {
                        $vehicle_id = $v->vehicle_id;
                        $buyer_id = $v->user_id;
                        if (is_array($request->file('images'))) {
                            foreach ($request->file('images') as $key => $value) {
                                $file = $value;
                                $filename = Storage::putFile('vehicle/images/'.$vehicle_id, $file);
                                
                                $image = new VehicleImage;
                                $image->vehicle_id = $vehicle_id;
                                $image->filesize = $value->getSize();
                                $image->owner_id = $buyer_id;
                                $image->title = '';
                                $image->filename = $filename;
                                $image->filepath = 'storage/app/';
                                $image->type = 'unloading';
                                $image->save();
                            }
                        } else {
                            $file = $request->file('images');
                            $filename = Storage::putFile('vehicle/images/'.$vehicle_id, $file);
                            
                            $image = new VehicleImage;
                            $image->vehicle_id = $vehicle_id;
                            $image->filesize = $file->getSize();
                            $image->owner_id = $buyer_id;
                            $image->title = '';
                            $image->filename = $filename;
                            $image->filepath = 'storage/app/';
                            $image->type = 'unloading';
                            $image->save();
                        }
                    }
                }
            } else {
                return $this->sendError('Not Found.', ['error'=>'Container not found.']);
            }

            $success['id'] =  $input['container_number'];
       
            return $this->sendResponse($success, 'Images sended successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function operator_containers(Request $request, $id)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
           
                $operator = User::where('id', $id)->first();

                if (!empty($operator)) {
                    $containers = Container::with('container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->where("destination_port_id", $operator->destination_id)->get();
                } else {
                    return $this->sendError('Not Found.', ['error'=>'Operator not found.']);
                }

                $success['containers'] =  $containers;
           
                return $this->sendResponse($success, 'Containers retrieved successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function add_user_to_vehicle(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $input = $request->all();
           
                $validator = Validator::make($input, [
                    'vehicle_id' => 'required',
                    'user_id' => 'required'
                ]);
           
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }

                $vehicle = Vehicle::where('id', $input['vehicle_id'])->first();

                if (!empty($vehicle)) {
                    $vehicle = new AssignVehicle;
                    $vehicle->user_id = $input['user_id'];
                    $vehicle->vehicle_id = $input['vehicle_id'];
                    $vehicle->payment_status = "unpaid";
                    $vehicle->assigned_by = "super_user";
                    $vehicle->save();
                } else {
                    return $this->sendError('Not Found.', ['error'=>'Vehicle not found.']);
                }
           
                return $this->sendResponse($vehicle, 'User added to vehicle successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function update_pickup_request(Request $request)
    {
        $token = $request->bearerToken();

        if (!empty($token)) {
            $check_user = User::where('api_token', $token)->count();
            if ($check_user > 0) {
                $input = $request->all();
                $user_id = User::where('api_token', $token)->first()->id;
           
                $validator = Validator::make($input, [
                    'status' => 'required',
                    'pickup_request_id' => 'required'
                ]);
           
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());       
                }
           
                $request = PickupRequest::where('id', $input['pickup_request_id'])->first();

                if (!empty($request)) {
                    PickupRequest::where('id', $input['pickup_request_id'])->update(['status' => $input['status'], 'approved_by' => $user_id]);
                } else {
                    return $this->sendError('Not Found.', ['error'=>'Pickup request not found.']);
                }

                $pickup_request = PickupRequest::where('id', $input['pickup_request_id'])->first();
           
                return $this->sendResponse($pickup_request, 'Vehicle updated successfully.');
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
                User::where('id', $id)->update(['api_token' => '', 'fcm_token' => '']);
            
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
