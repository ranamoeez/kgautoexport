<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLoginLog;
use App\Models\AssignVehicle;
use App\Models\ContainerVehicle;
use Auth;
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
        $data['total_vehicles'] = AssignVehicle::where('user_id', \Auth::user()->id)->count();
        $data['latest'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where('user_id', \Auth::user()->id)->orderBy("id", "DESC")->limit(3)->get();
        return view('user.index', $data);
    }

    public function vehicles()
    {
        $data['type'] = "vehicles";
        $data['super_admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("assigned_by", "super_admin");
        })->where('user_id', \Auth::user()->id)->orderBy("id", "DESC")->get();
        $data['admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("assigned_by", "admin");
        })->where('user_id', \Auth::user()->id)->orderBy("id", "DESC")->get();
        return view('user.vehicles', $data);
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
                'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
                'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
                'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
                'accessTokenKey' => env('QUICKBOOKS_ACCESS_TOKEN'),
                'refreshTokenKey' => env('QUICKBOOKS_REFRESH_TOKEN'),
                'QBORealmID' => env('QUICKBOOKS_REALM_ID'),
                'baseUrl' => env('QUICKBOOKS_BASE_URL')
            ]);

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $accessTokenObj = $OAuth2LoginHelper->refreshAccessTokenWithRefreshToken(env('QUICKBOOKS_REFRESH_TOKEN'));
            $accessTokenValue = $accessTokenObj->getAccessToken();
            $refreshTokenValue = $accessTokenObj->getRefreshToken();

            $dataService = DataService::Configure([
                'auth_mode' => 'oauth2',
                'ClientID' => env('QUICKBOOKS_CLIENT_ID'),
                'ClientSecret' => env('QUICKBOOKS_CLIENT_SECRET'),
                'RedirectURI' => env('QUICKBOOKS_REDIRECT_URI'),
                'accessTokenKey' => $accessTokenValue,
                'refreshTokenKey' => $refreshTokenValue,
                'QBORealmID' => env('QUICKBOOKS_REALM_ID'),
                'baseUrl' => env('QUICKBOOKS_BASE_URL')
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
                        "Description" => $v->vehicle->company_name.' '.$v->vehicle->name.' '.$v->vehicle->modal,
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

                    $customer_id = $result[0]->Id;
                    $customer_name = $result[0]->DisplayName;

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
