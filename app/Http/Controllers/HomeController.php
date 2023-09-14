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
                'ClientID' => "ABIdJb32v3epesMWXz0y5xokrQDirpjHrEKa0n39mLIvUGbN9t",
                'ClientSecret' => "40uEBRLODbAQgmVu5vs6X38Bbt8Kv45Bp3P0znfs",
                'RedirectURI' => "https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl",
                'accessTokenKey' => "eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..Os3c1eJkNKVCDwtFazOkgg.GSw_l9ZHvrjYrezx3rzbORWdAmk0H6x0DTjFwVT-X2m__IMvJ-BXntqT81wmcUyy3DfHvRVeSypfxFXi0CCiNxU183U9SKz0teWGTFfGTjDJIwc0NoEyJNI35E7_zVNHqrZNbmYBtJBMb0GT0WeoVb9dzWeEAy5ls9e6GjMvKQIxlmV5RRMiKaM1vtvCpvuO8NSKQoMWX1oMkfxv9e_-KNhA0iSxqfQGPsnoqPGEQcch2DRSc_yDito7gCPbE9wl8HBCaO7RKCaHVMjQDat2rTp80Ypxuk_kRpU-VzUY3S_AFRDKZOH2-rRoyAo33w98gpgvMH_3SDyOkoFeKa6RgYdiFQvTt0eMF4DwIOep13RJPx8urRXzPEtEM_CD7ACnyGO-epbftOx06ExNeQwq-ox5IrtzgGWPXaV9R3QKeF3CoGJPMo2eFmriw9s_v4hXMGnI9WcZl6IzxhmxjoTPkykUHguCx2s11e95wogI9xLGfSExMDm1SLd4Kywgfw5RQEv1XQBYPAKpLijNgAMrBZCxjH1BguaEVTtQ9b8LQusNyJRJgR3eN6GI5-iXmJBu-kyXtssBWcZT9UgRuVsTOqf4XaxNz9BQ2Od6Yxcs5UJmzE4z3Bv1frWJUV-d-WMkZZ5C6F5Iq5wCaCRrMaYe0kXT_kCYa2aC24sNXG2Y772J6-Rg02JT9wTcvKvmtwnjnwqPpG72WMgceew-2V6WZEHXkTL3RFl5V_On_-WJd_O8M3vl6nX0CcrH6kHpdixA86E4H5Y2nq8vj19D4KBZOpVFjov1Sj6lAzDlxLZW0cbXUYj38jfJHhJwygSKnsrrgxO6Ewl9ts6TueuWTbLsAN6mNozUdlVcYz2uNjeG8cRGsSrJI9TkJOQd0AcfgVosHgA5MPJ4fWthHCJd_Gi4yw.Twpcaqn-jQgSdb_hyShn_g",
                'refreshTokenKey' => "AB11702846192BRYtVwIIcdCnLBIB8s2C5TOzQz0zTmMYd1IEN",
                'QBORealmID' => "4620816365340509870",
                'baseUrl' => "development"
            ]);

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $accessTokenObj = $OAuth2LoginHelper->refreshAccessTokenWithRefreshToken("AB11702846192BRYtVwIIcdCnLBIB8s2C5TOzQz0zTmMYd1IEN");
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
