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
use App\Models\MoneyTransfer;
use App\Models\DestinationPort;
use App\Models\Post;
use App\Models\Fine;
use App\Models\VehicleImage;
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
        $auction_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('auction_price');
        $towing_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('towing_price');
        $occean_freight = Vehicle::where('buyer_id', Auth::user()->id)->sum('occean_freight');
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
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $all_due_payments = (int)$due_payments - (int)$previous;
        if ($all_due_payments < 0) {
            $all_due_payments = 0;
        }
        $data['spend'] = $all_due_payments;

        $data['vehicles'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("status_id", "11");
        })->where('user_id', Auth::user()->id)->orderBy("id", "DESC")->get();
        $data['user_levels'] = Level::all();
        $data['sub_buyers'] = User::where("main_user_id", \Auth::user()->id)->get();
        return view('user.index', $data);
    }

    public function assign_vehicle(Request $request)
    {
        $user_id = $request->user_id;
        $vehicle_id = $request->vehicle_id;

        $check = AssignVehicle::where("user_id", $user_id)->where("vehicle_id", $vehicle_id)->count();
        if ($check == 0) {
            $data = [
                "user_id" => $user_id,
                "vehicle_id" => $vehicle_id,
                "payment_status" => "unpaid",
                "assigned_by" => "super_user"
            ];

            AssignVehicle::create($data);

            return json_encode(["success" => true, "msg" => "Vehicle assigned successfully!"]);
        } else {
            return json_encode(["success" => false, "msg" => "Already assigned to that user!"]);
        }
    }

    public function add_sub_user(Request $request)
    {
        $data = $request->all();
        $check_username = User::where("name", $data['name'])->count();
        if ($check_username == 0) {
            $check_email = User::where("email", $data['email'])->count();
            if ($check_email == 0) {
                if ($data['password'] == $data['cpassword']) {
                    $data['password'] = \Hash::make($data['password']);
                    $data['role'] = "3";
                    $data['main_user_id'] = Auth::user()->id;
                    if (!empty($data['phone'])) {
                        $data['phone'] = $data['dial_code']." ".$data['phone'];
                    }
                    User::create($data);

                    return json_encode(["success"=>true, "msg"=>"Sub user added successfully!", "action"=>"reload"]);
                } else {
                    return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
                }
            } else {
                return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
            }
        } else {
            return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
        }
    }

    public function add_pickup_request(Request $request)
    {
        $data = $request->all();

        if (empty($data['vehicle_id'])) {
            return json_encode(["success" => false, "msg" => "Please select any vehicle first!"]);
        }

        $previous = TransactionsHistory::where("user_id", Auth::user()->id)->sum('amount');
        $auction_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('auction_price');
        $towing_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('towing_price');
        $occean_freight = Vehicle::where('buyer_id', Auth::user()->id)->sum('occean_freight');
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
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $all_due_payments = (int)$due_payments - (int)$previous;
        if ($all_due_payments < 0) {
            $all_due_payments = 0;
        }

        $due_payment_limit = User::with("user_level")->where('id', Auth::user()->id)->first();
        if (!empty($due_payment_limit->user_level)) {
            $due_payment_limit = (int)$due_payment_limit->user_level->due_payment_limit;
        } else {
            $due_payment_limit = 0;
        }

        if ($all_due_payments >= $due_payment_limit) {
            return json_encode(["success" => false, "msg" => "Your due payments limit exceeded!"]);
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
        $user_id = Auth::user()->id;
        if (Auth::user()->role == "3") {
            $user_id = Auth::user()->main_user_id;
        }
        $data['super_user'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where("assigned_by", "super_user")->where('user_id', $user_id)->orderBy("id", "DESC")->get();
        $data['admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where("assigned_by", "admin")->where('user_id', $user_id)->orderBy("id", "DESC")->get();
        $data['sub_buyers'] = User::where("main_user_id", $user_id)->get();
        $data['vehicles'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("status_id", "11");
        })->where('user_id', $user_id)->orderBy("id", "DESC")->get();
        return view('user.vehicles', $data);
    }

    public function vehicle_detail($id)
    {
        $data['type'] = "vehicles";

        $data['list'] = AssignVehicle::with('vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.destination_port', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer', 'container.shipping_line', 'container.measurement')->where('id', $id)->first();
        $data['destination_port'] = DestinationPort::all();

        return view('user.vehicle-detail', $data);
    }

    public function add_post(Request $request)
    {
        $data = $request->all();

        if ($data['amount'] == "0") {
            return json_encode(["success" => false, "msg" => "Amount should be greater than zero!"]);
        }

        Post::create($data);

        return json_encode(["success" => true, "msg" => "Post is added successfully!"]);
    }

    public function add_notes(Request $request)
    {
        $user_notes = $request->notes_user;
        $notes = $request->notes_document;

        Vehicle::where("id", $request->vehicle_id)->update(['notes_user' => $user_notes, "notes_document" => $notes]);

        return json_encode(["success" => true, "msg" => "Notes updated successfully!"]);
    }

    public function update_destination(Request $request)
    {
        $destination_port = $request->destination_port_id;

        if (empty($destination_port)) {
            return json_encode(["success" => false, "msg" => "Please select any destination!"]);
        }

        Vehicle::where("id", $request->vehicle_id)->update(['destination_port_id' => $destination_port, "update_destination" => "1"]);

        return json_encode(["success" => true, "msg" => "Destination port updated successfully!"]);
    }

    public function download_images(Request $request)
    {
        // Get the image URLs from the textarea and split them into an array
        $imageUrls = VehicleImage::where("vehicle_id", $request->vehicle_id)->get();

        // Create a ZIP archive
        $zip = new \ZipArchive;
        $zipFileName = 'images.zip';

        if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            // Loop through each image URL
            foreach ($imageUrls as $imageUrl) {
                // Remove leading/trailing whitespace and skip empty lines
                $imageUrl = url($imageUrl->filepath.$imageUrl->filename);
                if (!empty($imageUrl)) {
                    // Get the image content from the URL
                    $imageContent = file_get_contents($imageUrl);

                    if ($imageContent !== false) {
                        // Add the image to the ZIP archive with a unique name
                        $zip->addFromString(basename($imageUrl), $imageContent);
                    } else {
                        return json_encode(["success" => false, "msg" => "Failed to download images!"]);
                    }
                }
            }

            // Close the ZIP archive
            $zip->close();

            // Set headers to force download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            header('Content-Length: ' . filesize($zipFileName));

            // Output the ZIP file
            readfile($zipFileName);

            // Delete the temporary ZIP file
            unlink($zipFileName);

            return json_encode(["success" => true, "msg" => "Zip downloaded successfully!"]);
        } else {
            return json_encode(["success" => false, "msg" => "Failed to download images!"]);
        }
    }

    public function containers(Request $request)
    {
        $data['type'] = "containers";

        $user_id = Auth::user()->id;
        if (Auth::user()->role == "3") {
            $user_id = Auth::user()->main_user_id;
        }
        $admin = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
            $q->where("user_id", $user_id);
            $q->where("added_by", "admin");
        });
        $super_user = Container::orderBy('id', 'DESC')->with('container_vehicle', 'container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->whereHas("container_vehicle", function ($q) use($user_id) {
            $q->where("user_id", $user_id);
            $q->where("added_by", "super_user");
        });
        if (!empty($request->port) && $request->port !== 'all') {
            $data['port'] = $request->port;
            $admin = $admin->where('loading_port_id', $request->port);
            $super_user = $super_user->where('loading_port_id', $request->port);
        }
        if (!empty($request->status) && $request->status !== 'all') {
            $data['status'] = $request->status;
            $admin = $admin->where('status_id', $request->status);
            $super_user = $super_user->where('status_id', $request->status);
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
            $super_user = $super_user->where(function ($query) use ($search) {
                $query->where('booking_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('container_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('departure', 'LIKE', '%'.$search.'%')
                    ->orWhere('arrival', 'LIKE', '%'.$search.'%');
            });
        }
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || @$request->pay_status == '0') {
            $data['pay_status'] = $request->pay_status;
            $admin = $admin->where('all_paid', $request->pay_status);
            $super_user = $super_user->where('all_paid', $request->pay_status);
        }

        $admin = $admin->get();
        $super_user = $super_user->get();

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

        foreach ($super_user as $key => $value) {
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
            $super_user[$key]->buyers = $buyers;
        }

        $data['admin'] = $admin;
        $data['super_user'] = $super_user;
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

        $vehicle_cost = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer')->whereHas("vehicle")->where("user_id", Auth::user()->id);
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $vehicle_cost = $vehicle_cost->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $vehicle_cost = $vehicle_cost->where("type", "init")->limit(10)->get();

        foreach ($vehicle_cost as $key => $value) {
            $all_transactions = TransactionsHistory::where("vehicle_id", $value->vehicle_id)->where("user_id", $value->user_id);
            $vehicle_cost[$key]['total_paid'] = $all_transactions->where(function ($query) {
                $query->where('type', 'auction_price')
                      ->orWhere('type', 'auction_fines')
                      ->orWhere('type', 'draft_expenses');
            })->sum("amount");
            $vehicle_cost[$key]['all'] = $all_transactions->where("type", "!=", "init")->where(function ($query) {
                $query->where('type', 'auction_price')
                      ->orWhere('type', 'auction_fines')
                      ->orWhere('type', 'draft_expenses');
            })->get();
            $vehicle_cost[$key]['payment_status'] = AssignVehicle::where("vehicle_id", $value->vehicle_id)->where("user_id", $value->user_id)->first()->payment_status;

            $auction_price = Vehicle::where("id", $value->vehicle_id)->first()->auction_price;
            $fines = 0;
            $all_fines = Fine::where("vehicle_id", $value->vehicle_id)->get();
            if (count($all_fines) > 0) {
                foreach ($all_fines as $k => $v) {
                    if ($v->type == "auction" || $v->type == "draft_expense") {
                        $fines += $v->amount;
                    }
                }
            }

            $total_unpaid = (int)$auction_price + (int)$fines;

            $vehicle_cost[$key]['total_unpaid'] = $total_unpaid - (int)$all_transactions->where(function ($query) {
                $query->where('type', 'auction_price')
                      ->orWhere('type', 'auction_fines')
                      ->orWhere('type', 'draft_expenses');
            })->sum("amount");
        }

        $data['vehicle_cost'] = $vehicle_cost;

        $transportation = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer')->whereHas("vehicle")->where("user_id", Auth::user()->id);
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $transportation = $transportation->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $transportation = $transportation->where("type", "init")->limit(10)->get();

        foreach ($transportation as $key => $value) {
            $all_transactions = TransactionsHistory::where("vehicle_id", $value->vehicle_id)->where("user_id", $value->user_id);
            $transportation[$key]['total_paid'] = $all_transactions->where(function ($query) {
                $query->where('type', 'company_fee')
                      ->orWhere('type', 'towing_price')
                      ->orWhere('type', 'unloading_fee')
                      ->orWhere('type', 'trans_fines')
                      ->orWhere('type', 'occean_freight');
            })->sum("amount");
            $transportation[$key]['payment_status'] = AssignVehicle::where("vehicle_id", $value->vehicle_id)->where("user_id", $value->user_id)->first()->payment_status;

            $towing_price = Vehicle::where("id", $value->vehicle_id)->first()->towing_price;
            $occean_freight = Vehicle::where("id", $value->vehicle_id)->first()->occean_freight;
            $get_vehicle = Vehicle::with("buyer.user_level", "destination_port")->where("id", $value->vehicle_id)->first();
            $company_fee = 0;
            $unloading_fee = 0;
            if (!empty($get_vehicle->buyer->user_level->company_fee)) {
                $company_fee = $get_vehicle->buyer->user_level->company_fee;
            }
            if (!empty($get_vehicle->destination_port->unloading_fee)) {
                $unloading_fee = $get_vehicle->destination_port->unloading_fee;
            }
            $fines = 0;
            $all_fines = Fine::where("vehicle_id", $value->vehicle_id)->get();
            if (count($all_fines) > 0) {
                foreach ($all_fines as $k => $v) {
                    if ($v->type == "transaction") {
                        $fines += $v->amount;
                    }
                }
            }

            $total_unpaid = (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;

            $transportation[$key]['total_unpaid'] = $total_unpaid - (int)$all_transactions->where(function ($query) {
                $query->where('type', 'company_fee')
                      ->orWhere('type', 'towing_price')
                      ->orWhere('type', 'unloading_fee')
                      ->orWhere('type', 'trans_fines')
                      ->orWhere('type', 'occean_freight');
            })->sum("amount");
        }

        $data['transportation'] = $transportation;

        $previous = TransactionsHistory::where("user_id", Auth::user()->id)->sum('amount');
        $auction_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('auction_price');
        $towing_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('towing_price');
        $occean_freight = Vehicle::where('buyer_id', Auth::user()->id)->sum('occean_freight');
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
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $all_due_payments = (int)$due_payments - (int)$previous;
        if ($all_due_payments < 0) {
            $all_due_payments = 0;
        }

        $data['due_payments'] = $all_due_payments;
        $data['previous'] = $previous;
        $data['balance'] = User::where("id", Auth::user()->id)->first()->balance;
        $data['user'] = User::with("user_level")->where("id", Auth::user()->id)->first();
        $data['vehicles'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where('user_id', Auth::user()->id)->orderBy("id", "DESC")->get();
        return view('user.financial', $data);
    }

    public function check_password(Request $request)
    {
        $password = $request->sheet_password;

        if (\Hash::check($password, \Auth::user()->sheet_password)) {
            \Session::put("success", "1");

            return json_encode(["success" => true, "msg" => "Password is correct!"]);
        } else {
            return json_encode(["success" => false, "msg" => "Password is incorrect!"]);
        }
    }

    public function money_transfer(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $data['latest'] = "1";
        MoneyTransfer::create($data);

        return json_encode(["success" => true, "msg" => "Money is transfered successfully!"]);
    }

    public function add_comment(Request $request)
    {
        $user_notes = $request->user_notes;
        $vehicle_id = $request->vehicle_id;

        Vehicle::where("id", $vehicle_id)->update(["notes_user_financial" => $user_notes]);

        return json_encode(["success"=>true, 'msg'=>'Comment is updated successfully!', 'action'=>'reload']);
    }

    public function get_vehicle_notes($id)
    {
        $vehicle = Vehicle::where("id", $id)->first();
        $data['notes_financial'] = $vehicle->notes_financial;
        $data['notes_user_financial'] = $vehicle->notes_user_financial;
        return json_encode(["success"=>true, "data" => $data]);
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
            } else {
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
