<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLoginLog;
use App\Models\AssignVehicle;
use App\Models\ContainerVehicle;
use App\Models\Level;
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
        $data['user_levels'] = Level::all();
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

    public function containers()
    {
        $data['type'] = "containers";
        return view('user.containers', $data);
    }

    public function container_detail()
    {
        $data['type'] = "containers";
        return view('user.container-detail', $data);
    }

    public function financial()
    {
        $data['type'] = "financial";
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
