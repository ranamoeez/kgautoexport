<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLoginLog;
use App\Models\AssignVehicle;
use App\Models\ContainerVehicle;
use App\Models\Level;
use App\Models\User;
use App\Models\TransactionsHistory;
use App\Models\Vehicle;
use App\Models\PickupRequest;
use App\Models\Container;
use App\Models\LoadingPort;
use App\Models\ContStatus;
use Auth;
use Storage;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Data\IPPCustomer;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['type'] = "homepage";
        $data['total_vehicles'] = AssignVehicle::where('user_id', Auth::user()->id)->count();
        $data['shipped_vehicles'] = AssignVehicle::whereHas("vehicle", function ($q) {
            $q->where("status_id", "10");
        })->where('user_id', Auth::user()->id)->count();
        $data['delivered_vehicles'] = AssignVehicle::whereHas("vehicle", function ($q) {
            $q->where("status_id", "11");
        })->where('user_id', Auth::user()->id)->count();
        $data['latest'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where('user_id', Auth::user()->id)->orderBy("id", "DESC")->limit(3)->get();
        $data['user'] = User::with("user_level")->where("id", Auth::user()->id)->first();

        $previous = TransactionsHistory::where("user_id", Auth::user()->id)->sum('amount');
        $auction_price = \DB::table('vehicles')->where('buyer_id', Auth::user()->id)->sum('auction_price');
        $towing_price = \DB::table('vehicles')->where('buyer_id', Auth::user()->id)->sum('towing_price');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', Auth::user()->id)->get();
        $fines = 0;
        $company_fee = 0;
        $unloading_fee = 0;
        foreach ($all_data as $k => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $ke => $v) {
                    $fines += (int)$v->amount;
                }
            }
            if (!empty(@$value->buyer->user_level)) {
                $company_fee += (int)@$value->buyer->user_level->company_fee;
            }
            if (!empty(@$value->destination_port)) {
                $unloading_fee += (int)@$value->destination_port->unloading_fee;
            }
        }
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $all_due_payments = (int)$due_payments - (int)$previous;
        if ($all_due_payments < 0) {
            $all_due_payments = 0;
        }
        $data['spend'] = $all_due_payments;

        $data['vehicles'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where('user_id', Auth::user()->id)->orderBy("id", "DESC")->get();
        $data['user_levels'] = Level::all();
        return view('user.index', $data);
    }

    public function add_pickup_request(Request $request)
    {
        $data = $request->all();

        if (empty($data['vehicle_id'])) {
            return json_encode(["success" => false, "msg" => "Please select any vehicle first!"]);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Storage::putFile("pickup-request", $file);
            $data['file'] = $filename;
        }

        $data['user_id'] = Auth::user()->id;
        PickupRequest::create($data);

        return json_encode(["success" => true, "msg" => "Pickup request added successfully!"]);
    }

    public function vehicles()
    {
        $data['type'] = "vehicles";
        $data['super_admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("assigned_by", "super_admin");
        })->where('user_id', Auth::user()->id)->orderBy("id", "DESC")->get();
        $data['admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("assigned_by", "admin");
        })->where('user_id', Auth::user()->id)->orderBy("id", "DESC")->get();
        return view('user.vehicles', $data);
    }

    public function containers(Request $request)
    {
        $data['type'] = "containers";

        $user_id = Auth::user()->id;
        $admin = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
            $q->where("user_id", $user_id);
            $q->where("added_by", "1");
        });
        $super_admin = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
            $q->where("user_id", $user_id);
            $q->where("added_by", "!=", "1");
        });
        if (!empty($request->port) && $request->port !== 'all') {
            $data['port'] = $request->port;
            $admin = $admin->where('loading_port_id', $request->port);
            $super_admin = $super_admin->where('loading_port_id', $request->port);
        }
        if (!empty($request->status) && $request->status !== 'all') {
            $data['status'] = $request->status;
            $admin = $admin->where('status_id', $request->status);
            $super_admin = $super_admin->where('status_id', $request->status);
        }
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $admin = $admin->where(function ($query) use ($search) {
                $query->where('booking_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('container_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('departure', 'LIKE', '%'.$search.'%')
                    ->orWhere('arrival', 'LIKE', '%'.$search.'%');
            });
            $super_admin = $super_admin->where(function ($query) use ($search) {
                $query->where('booking_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('container_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('departure', 'LIKE', '%'.$search.'%')
                    ->orWhere('arrival', 'LIKE', '%'.$search.'%');
            });
        }
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || @$request->pay_status == '0') {
            $data['pay_status'] = $request->pay_status;
            $admin = $admin->where('all_paid', $request->pay_status);
            $super_admin = $super_admin->where('all_paid', $request->pay_status);
        }

        $admin = $admin->get();
        $super_admin = $super_admin->get();

        foreach ($admin as $key => $value) {
            $buyer = ContainerVehicle::with("user")->where("container_id", $value->id)->get();
            $unique = [];
            $buyers = [];
            foreach ($buyer as $k => $v) {
                $user_id = $v->user_id;
                if (!in_array($user_id, $unique)) {
                    array_push($unique, $user_id);
                    $vehicles = AssignVehicle::with('vehicle')->where("user_id", $user_id)->where('assigned_to', $value->id)->get();
                    if (count($vehicles) > 0) {
                        $v->vehicles = $vehicles;
                        array_push($buyers, $v);
                    }
                }
            }
            $admin[$key]->buyers = $buyers;
        }

        foreach ($super_admin as $key => $value) {
            $buyer = ContainerVehicle::with("user")->where("container_id", $value->id)->get();
            $unique = [];
            $buyers = [];
            foreach ($buyer as $k => $v) {
                $user_id = $v->user_id;
                if (!in_array($user_id, $unique)) {
                    array_push($unique, $user_id);
                    $vehicles = AssignVehicle::with('vehicle')->where("user_id", $user_id)->where('assigned_to', $value->id)->get();
                    if (count($vehicles) > 0) {
                        $v->vehicles = $vehicles;
                        array_push($buyers, $v);
                    }
                }
            }
            $super_admin[$key]->buyers = $buyers;
        }

        $data['admin'] = $admin;
        $data['super_admin'] = $super_admin;
        $data['all_port'] = LoadingPort::all();
        $data['all_status'] = ContStatus::all();
        return view('user.containers', $data);
    }

    public function container_detail($id)
    {
        $data['type'] = "containers";

        $container = Container::orderBy('id', 'DESC')->with('container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->where("id", $id)->first();

        $buyer = ContainerVehicle::with("user")->where("container_id", $container->id)->get();
        $unique = [];
        $buyers = [];
        foreach ($buyer as $k => $v) {
            $user_id = $v->user_id;
            if (!in_array($user_id, $unique)) {
                array_push($unique, $user_id);
                $vehicles = AssignVehicle::with('vehicle')->where("user_id", $user_id)->where('assigned_to', $container->id)->get();
                if (count($vehicles) > 0) {
                    $v->vehicles = $vehicles;
                    array_push($buyers, $v);
                }
            }
        }
        $container->buyers = $buyers;

        $data['container'] = $container;
        return view('user.container-detail', $data);
    }

    public function financial()
    {
        $data['type'] = "financial";
        $data['page'] = '1';

        $transaction_history = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer')->where("user_id", Auth::user()->id);
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $transaction_history = $transaction_history->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $data['transaction_history'] = $transaction_history->limit(10)->get();

        $previous = TransactionsHistory::where("user_id", Auth::user()->id)->sum('amount');
        $auction_price = \DB::table('vehicles')->where('buyer_id', Auth::user()->id)->sum('auction_price');
        $towing_price = \DB::table('vehicles')->where('buyer_id', Auth::user()->id)->sum('towing_price');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', Auth::user()->id)->get();
        $fines = 0;
        $company_fee = 0;
        $unloading_fee = 0;
        foreach ($all_data as $k => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $ke => $v) {
                    $fines += (int)$v->amount;
                }
            }
            if (!empty(@$value->buyer->user_level)) {
                $company_fee += (int)@$value->buyer->user_level->company_fee;
            }
            if (!empty(@$value->destination_port)) {
                $unloading_fee += (int)@$value->destination_port->unloading_fee;
            }
        }
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $all_due_payments = (int)$due_payments - (int)$previous;
        if ($all_due_payments < 0) {
            $all_due_payments = 0;
        }

        $data['due_payments'] = $all_due_payments;
        $data['previous'] = $previous;
        $data['balance'] = User::where("id", Auth::user()->id)->first()->balance;
        return view('user.financial', $data);
    }

    public function post_login(Request $request)
    {
        if(Auth::attempt(['name' => $request->username, 'password' => $request->password])){ 
            $user = Auth::user();
            $success['user'] = $user;

            $log = new UserLoginLog;
            $log->user_id = $user->id;
            $log->datetime = date("Y-m-d H:i:s");
            $log->save();
   
            if ($user->role == '1') {
                return redirect(url('/admin'));
            } else if ($user->role == '2') {
                return redirect(url('/user'));
            }
            return redirect(url('/'))->with(['error' => 'These credentials do not match our records.']);
        } 
        else{ 
            return redirect(url('/'))->with(['error' => 'These credentials do not match our records.']);
        } 
    }

    public function create_invoice(Request $request, $id)
    {
        $container = ContainerVehicle::with('user', 'vehicle')->where("container_id", $id)->get();

        if (!empty($container) && count($container) > 0) {
            $dataService = DataService::Configure([
                'auth_mode' => 'oauth2',
                'ClientID' => "ABIdJb32v3epesMWXz0y5xokrQDirpjHrEKa0n39mLIvUGbN9t",
                'ClientSecret' => "40uEBRLODbAQgmVu5vs6X38Bbt8Kv45Bp3P0znfs",
                'RedirectURI' => "https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl",
                'accessTokenKey' => "eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..KkelcVNFfGNrQ2HblMhT2w.LXD-PnavCS34xHc72_Nict4Y_IwpNmGOBhQuTvejTZ1RavaTbsn-7J4R8cmS2qbzrEjWQ6iYpp5IL0bsvXENkEpU1aPMLse8DDln-EqalatbA0BQCnAorAvhlf-8XPdNxG-vYfXO7PRJcE1ujkV4yQiSG25hIdeJHMZcOA6WTcqrutADcfYgJA5x1oChc6Q6qKtnw-t3O3zExf52YSTaWq3T6bfTzvoXtg3m29XKRG3s4C5quRCOUhmiuiQZfpGhX9ETiJk0ToWWUSK-viIqFj7snCzxLQSnDCkJkaZXcVHI-QH1WVYIp3q-axi2NJjvdvHIluDDicwdBQdibDUZeNb2UYZy13wWOce8Vv2sbhZloneJIqGGGYH85LFMdG3kXT70uqvZnIHXA60X71GwCB_CLLHYkKRP6UbhrMHkg_fmlQUVhyhV2vX_sk_A7_WTF5nEl-nldtU_ZCx8FNTyxubcBPYZM7QtXM4vI_4DIgkUFjYF7oBwHZqytGxgDhXDbMZbwsvNeyq8A2YM9154xfXfluSR5B1AqA9JyWVJ2Cl5Vjo6F4tnjEZYdTypeC3ddDQSD-f6iUpDVztTabgADTynlrx9nhPmzMwvMdbisF2KKoRcnR5u7d5JQ4DUydhBG0M8uXqaElAfFHBCR5qHMUo96z6KyshZxm8dn8PThQO29srYW7B3m3CrvauRX9uvFKWyRa9TgDPRpNqX-3bspeyUAdQ4e85CO7HALvdPjVQ.9TVPvTe6KHQR3-IlaXf7cA",
                'refreshTokenKey' => "AB11702929503i1FgiNZa2TJq9rMNMVTQBo3X46AGn7N7246TK",
                'QBORealmID' => "4620816365340509870",
                'baseUrl' => "development"
            ]);

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $accessTokenObj = $OAuth2LoginHelper->refreshAccessTokenWithRefreshToken("AB11702929503i1FgiNZa2TJq9rMNMVTQBo3X46AGn7N7246TK");
            $accessTokenValue = $accessTokenObj->getAccessToken();
            $refreshTokenValue = $accessTokenObj->getRefreshToken();

            $dataService = DataService::Configure([
                'auth_mode' => 'oauth2',
                'ClientID' => "ABIdJb32v3epesMWXz0y5xokrQDirpjHrEKa0n39mLIvUGbN9t",
                'ClientSecret' => "40uEBRLODbAQgmVu5vs6X38Bbt8Kv45Bp3P0znfs",
                'RedirectURI' => "https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl",
                'accessTokenKey' => $accessTokenValue,
                'refreshTokenKey' => $refreshTokenValue,
                'QBORealmID' => "4620816365340509870",
                'baseUrl' => "development"
            ]);

            $total_users = [];
            foreach ($container as $key => $value) {
                array_push($total_users, $value->user_id);
            }

            $total_users = array_unique($total_users);

            foreach ($total_users as $key => $value) {

                $all_vehicle = ContainerVehicle::with('user', 'vehicle')->where("container_id", $id)->where("user_id", $value)->get();

                $line = [];
                foreach ($all_vehicle as $k => $v) {
                    $amount = 100;

                    $veh_data = [
                        "Description" => @$v->vehicle->company_name.' '.@$v->vehicle->name.' '.@$v->vehicle->modal,
                        "Amount" => $amount,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "ItemRef" => [
                                "value" => $key + 1,
                                "name" => "Product"
                            ]
                        ]
                    ];
                    array_push($line, $veh_data);
                }

                $query = "SELECT * FROM Customer WHERE DisplayName = '".$all_vehicle[0]->user->name."'";
                $customer = $dataService->Query($query);

                if (!empty($customer) && count($customer) > 0) {
                    $customer = $customer[0];

                    $customer_id = $customer->Id;
                    $customer_name = $customer->DisplayName;

                    $invoiceToCreate = Invoice::create([
                        "Line" => $line,
                        "CustomerRef" => [
                            "value" => $customer_id,
                            "name" => $customer_name
                        ]
                    ]);
                } else {
                    $customer = Customer::create([
                        "GivenName" => $all_vehicle[0]->user->name,
                        "DisplayName" =>  $all_vehicle[0]->user->name,
                        "PrimaryEmailAddr" => [
                            "Address" => $all_vehicle[0]->user->email
                        ],
                        "BillAddr" => [
                            "Line1" => "123 Main Street",
                            "City" => "Mountain View",
                            "Country" => "USA",
                        ],
                        "PrimaryPhone" => [
                            "FreeFormNumber" => '+923007731712'
                        ]
                    ]);

                    $result = $dataService->Add($customer);

                    $customer_id = $result->Id;
                    $customer_name = $result->DisplayName;

                    $invoiceToCreate = Invoice::create([
                        "Line" => $line,
                        "CustomerRef" => [
                            "value" => $customer_id,
                            "name" => $customer_name
                        ]
                    ]);

                }
                $resultObj = $dataService->Add($invoiceToCreate);

            }

            if (!empty($resultObj->DocNumber) && !empty($resultObj->Id)) {
                return json_encode(["flag" => true, "msg" => "Invoice created successfully!"]);
            } else {
                return json_encode(["flag" => false, "msg" => "Something went wrong. Invoice creation failed!"]);
            }
        } else {
            return json_encode(["flag" => false, "msg" => "Please add any buyer to this container first!"]);
        }
    }
}
