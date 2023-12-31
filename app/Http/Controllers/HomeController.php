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
use App\Models\EmailHistory;
use App\Models\NotesHistory;
use App\Models\Status;
use App\Models\Terminal;
use App\Models\Country;
use App\Models\VehicleDocuments;
use Auth;
use Storage;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Data\IPPCustomer;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;

class HomeController extends Controller
{
    private $perpage = 15;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function main_page()
    {
        return view("index");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['type'] = "homepage";
        $data['at_terminal_vehicles'] = AssignVehicle::whereHas("vehicle", function ($q) {
            $q->where("status_id", "6");
        })->where('user_id', Auth::user()->id)->count();
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
        $company_fee = Vehicle::where('buyer_id', Auth::user()->id)->sum('company_fee');
        $unloading_fee = Vehicle::where('buyer_id', Auth::user()->id)->sum('unloading_fee');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', Auth::user()->id)->get();
        $fines = 0;
        foreach ($all_data as $k => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $ke => $v) {
                    $fines += (int)$v->amount;
                }
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
        $data['countries'] = Country::all();
        return view('user.index', $data);
    }

    // public function create_veh(Request $request)
    // {
    //     ini_set('max_execution_time', 120000000);

    //     $all = Container::all();
    //     foreach ($all as $key => $value) {
    //         if (!empty($value->export_reference) && $value['id'] > 14723 && $value->export_reference !== "GA-") {
    //             $vehicles = Vehicle::where("ref", $value->export_reference)->get();
    //             if (!empty($vehicles)) {
    //                 foreach ($vehicles as $k => $v) {
    //                     $data = [
    //                         "container_id" => $value['id'],
    //                         "user_id" => $v->buyer_id,
    //                         "vehicle_id" => $v->id,
    //                         "added_by" => "admin"
    //                     ];
    //                     ContainerVehicle::create($data);

    //                     AssignVehicle::where("user_id", $v->buyer_id)->where("vehicle_id", $v->id)->update(["assigned_to" => $value['id']]);
    //                 }
    //             }
    //         }
    //     }

    //     $all = Container::all();
    //     foreach ($all as $key => $value) {
    //         $buyers = [];
    //         $all_buyers = [];
    //         $all_vehicles = ContainerVehicle::where("container_id", $value->id)->get();
    //         foreach ($all_vehicles as $k => $v) {
    //             if (!in_array($v->user_id, $all_buyers)) {
    //                 array_push($buyers, "-".$v->user_id."-");
    //                 array_push($all_buyers, $v->user_id);
    //             }
    //         }
    //         if (!empty($buyers)) {
    //             Container::where("id", $value->id)->update(["buyers" => implode(",", $buyers)]);
    //         }
    //     }

    //     return true;
    // }

    public function assign_vehicle(Request $request)
    {
        $user_id = $request->user_id;
        $vehicle_id = $request->vehicle_id;

        $check = AssignVehicle::where("user_id", $user_id)->where("vehicle_id", $vehicle_id)->count();
        if ($check == 0) {
            $user = AssignVehicle::where("user_id", Auth::user()->id)->where("vehicle_id", $vehicle_id)->first();
            $data = [
                "user_id" => $user_id,
                "vehicle_id" => $vehicle_id,
                "assigned_to" => $user->assigned_to,
                "payment_status" => "unpaid",
                "assigned_by" => "super_user"
            ];

            AssignVehicle::create($data);
            $container = Container::where("id", $user->assigned_to)->first();
            if (!empty($container) && !str_contains(@$container->buyers, "-".$user_id."-")) {
                if (!empty($container->buyers)) {
                    $buyers = $container->buyers.", -".$user_id."-";
                } else {
                    $buyers = "-".$user_id."-";
                }
                Container::where("id", $user->assigned_to)->update(["buyers" => $buyers]);
            }

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
                        $data['phone'] = $data['phone_code']." ".$data['phone'];
                    }
                    $user = User::create($data);

                    // $all_vehicles = AssignVehicle::where("user_id", Auth::user()->id)->get();
                    // foreach ($all_vehicles as $key => $value) {
                    //     $data = [
                    //         "user_id" => $user->id,
                    //         "vehicle_id" => $value->id,
                    //         "payment_status" => "unpaid",
                    //         "assigned_by" => "super_user"
                    //     ];

                    //     AssignVehicle::create($data);
                    // }

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

        $check_pickup = AssignVehicle::where("user_id", Auth::user()->id)->where("vehicle_id", $data['vehicle_id'])->first();
        if (empty(@$check_pickup) || @$check_pickup->pickup == "1") {
            return json_encode(["success" => false, "msg" => "Pickup request already exists for this vehicle!"]);
        }

        $previous = TransactionsHistory::where("user_id", Auth::user()->id)->sum('amount');
        $auction_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('auction_price');
        $towing_price = Vehicle::where('buyer_id', Auth::user()->id)->sum('towing_price');
        $occean_freight = Vehicle::where('buyer_id', Auth::user()->id)->sum('occean_freight');
        $company_fee = Vehicle::where('buyer_id', Auth::user()->id)->sum('company_fee');
        $unloading_fee = Vehicle::where('buyer_id', Auth::user()->id)->sum('unloading_fee');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', Auth::user()->id)->get();
        $fines = 0;
        foreach ($all_data as $k => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $ke => $v) {
                    $fines += (int)$v->amount;
                }
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
            $filename = Storage::disk("s3")->putFile("pickup-request", $file);
            $data['file'] = $filename;
        }

        $data['user_id'] = Auth::user()->id;
        PickupRequest::create($data);

        AssignVehicle::where("user_id", Auth::user()->id)->where("vehicle_id", $data['vehicle_id'])->update(["pickup" => "1"]);

        return json_encode(["success" => true, "msg" => "Pickup request added successfully!"]);
    }

    public function search($records,$request,&$data) {
        /*
        SET DEFAULT VALUES
        */
        if($request->perpage)
            $this->perpage = $request->perpage;
        $data['sindex'] = ($request->page != NULL)?($this->perpage*$request->page - $this->perpage+1):1;
        /*
        FILTER THE DATA
        */
        $params = [];
        if($request->is_active) {
            $params['is_active'] = $request->is_active;
            $records = $records->where("is_active",$params['is_active']);
        }
        $filter = [];
        if (!empty($request->terminal) && $request->terminal !== 'all') {
            $data['terminal'] = $request->terminal;
            $terminal = $request->terminal;
            $filter['terminal'] = $terminal;
        }
        if (!empty($request->status) && $request->status !== 'all') {
            $data['status'] = $request->status;
            $status = $request->status;
            $filter['status'] = $status;
        }
        if (!empty($request->fuel_type) && $request->fuel_type !== 'all') {
            $data['fuel_type'] = $request->fuel_type;
            $fuel_type = $request->fuel_type;
            $filter['fuel_type'] = $fuel_type;
        }
        if (!empty($request->destination) && $request->destination !== 'all') {
            $data['destination'] = $request->destination;
            $destination = $request->destination;
            $filter['destination'] = $destination;
        }
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $filter['search'] = $search;
        }
        if (!empty($filter)) {
            $records = $records->whereHas('vehicle', function ($query) use($filter) {
                if (!empty($filter['terminal'])) {
                    $query->where('terminal_id', $filter['terminal']);
                }
                if (!empty($filter['fuel_type'])) {
                    $query->where('fuel_type', $filter['fuel_type']);
                }
                if (!empty($filter['status'])) {
                    $query->where('status_id', $filter['status']);
                }
                if (!empty($filter['at_terminal'])) {
                    if ($filter['at_terminal'] == "1") {
                        $oneMonthAgo = new \DateTime('1 day ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', ">=", $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "2") {
                        $oneMonthAgo = new \DateTime('2 day ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "3") {
                        $oneMonthAgo = new \DateTime('3 day ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "4") {
                        $oneMonthAgo = new \DateTime('4 day ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "5") {
                        $oneMonthAgo = new \DateTime('5 day ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "1w") {
                        $oneMonthAgo = new \DateTime('1 week ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', ">=", $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "2w") {
                        $oneMonthAgo = new \DateTime('2 week ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', ">=", $date)->where("status_id", "6");    
                    } else if ($filter['at_terminal'] == "m2w") {
                        $oneMonthAgo = new \DateTime('2 week ago');
                        $date = $oneMonthAgo->format('Y-m-d');
                        $query->where('delivered_on_date', "<=", $date)->where("status_id", "6");    
                    }
                }
                if (!empty($filter['destination'])) {
                    $query->where('destination_port_id', $filter['destination']);
                }
                if (!empty($filter['search'])) {
                    $search = $filter['search'];
                    $query->where(function ($q) use ($search) {
                        $q->where('delivery_date', 'LIKE', '%'.$search.'%')
                        ->orWhere('company_name', 'LIKE', '%'.$search.'%')
                        ->orWhere('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('modal', 'LIKE', '%'.$search.'%')
                        ->orWhere('vin', 'LIKE', '%'.$search.'%')
                        ->orWhere('client_name', 'LIKE', '%'.$search.'%')
                        ->orWhere('destination_manual', 'LIKE', '%'.$search.'%')
                        ->orWhere('notes', 'LIKE', '%'.$search.'%');
                    });
                }
            });
        }
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || $request->pay_status == "0") {
            $data['pay_status'] = $request->pay_status;
            $records = $records->where('payment_status', $request->pay_status);
        }
        $data['request'] = $params;
        return $records;    
    }

    public function vehicles(Request $request)
    {
        $user_id = \Auth::user()->id;
        $data['type'] = "vehicles";
        $data['page'] = '1';
        $data['sub_buyers'] = User::where("main_user_id", $user_id)->get();
        $data['vehicles'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("status_id", "11");
        })->where('user_id', $user_id)->orderBy("id", "DESC")->get();
        $data['all_terminal'] = Terminal::all();
        foreach ($data['all_terminal'] as $key => $value) {
            $terminal_id = $value->id;
            $total_count = AssignVehicle::with("vehicle")->whereHas("vehicle", function ($q) use($terminal_id) {
                $q->where("terminal_id", $terminal_id);
            })->where("user_id", Auth::user()->id)->count();
            $data['all_terminal'][$key]["vehicles"] = $total_count;
        }

        $data['all_status'] = Status::all();
        foreach ($data['all_status'] as $key => $value) {
            $status_id = $value->id;
            $total_count = AssignVehicle::with("vehicle")->whereHas("vehicle", function ($q) use($status_id) {
                $q->where("status_id", $status_id);
            })->where("user_id", Auth::user()->id)->count();
            $data['all_status'][$key]["vehicles"] = $total_count;
        }

        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_destination_port'] = DestinationPort::all();
        $data['countries'] = Country::all();
        /*
        GET RECORDS
        */
        $records = new AssignVehicle;
        if (\Auth::user()->role == "3") {
            $sub_user_records = $records->orderBy('id','DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where("assigned_by", "super_user")->where('user_id', $user_id);
            $records = $this->search($sub_user_records,$request,$data);

            $records = $records->paginate($this->perpage);
            $records->appends($request->all())->links();
            $links = $records->links();

            $records = $records->toArray();
            $records['pagination'] = $links;
            $data['admin'] = [];
            $data['user'] = $records;
        } else {
            $admin_records = $records->orderBy('id','DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where("assigned_by", "admin")->where('user_id', $user_id);
            $admin_records = $this->search($admin_records,$request,$data);
            $user_records = $records->orderBy('id','DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where("assigned_by", "super_user")->where('user_id', $user_id);
            $user_records = $this->search($user_records,$request,$data);

            $admin_records = $admin_records->paginate($this->perpage);
            $admin_records->appends($request->all())->links();
            $links = $admin_records->links();

            $admin_records = $admin_records->toArray();
            $admin_records['pagination'] = $links;

            $user_records = $user_records->paginate($this->perpage);
            $user_records->appends($request->all())->links();
            $links2 = $user_records->links();

            $user_records = $user_records->toArray();
            $user_records['pagination'] = $links2;

            $data['admin'] = $admin_records;
            $data['user'] = $user_records;
        }

        return view('user.vehicles', $data);
    }

    public function vehicle_detail($id)
    {
        $data['type'] = "vehicles";

        $data['list'] = AssignVehicle::with('vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.destination_port', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer', 'container.shipping_line', 'container.measurement')->where('id', $id)->first();
        $data['destination_port'] = DestinationPort::all();
        $data['email_history'] = EmailHistory::where("vehicle_id", $data['list']->vehicle_id)->where("user_id", \Auth::user()->id)->get();
        $data['countries'] = Country::all();
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

    public function send_email(Request $request)
    {
        $data = $request->all();

        if (!empty($data['vehicle_id'])) {
            $vehicle = Vehicle::where('id', $data['vehicle_id'])->first();

            \Mail::to($data['sent_to'])->send(new \App\Mail\SendVehicle($vehicle));
        }

        if (!empty($data['container_id'])) {
            $container = Container::with('status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->where('id', $data['container_id'])->first();

            \Mail::to($data['sent_to'])->send(new \App\Mail\SendContainer($container));
        }

        EmailHistory::create($data);

        return json_encode(["success" => true, "msg" => "Email is sended successfully!"]);
    }

    public function add_notes(Request $request)
    {
        $user_notes = $request->notes_user;
        $notes = $request->notes_document;

        Vehicle::where("id", $request->vehicle_id)->update(['notes_user' => $user_notes, "notes_document" => $notes]);
        $data = [
            "vehicle_id" => $request->vehicle_id,
            "buyer_id" => \Auth::user()->id,
            "notes" => $user_notes
        ];
        NotesHistory::create($data);

        return json_encode(["success" => true, "msg" => "Notes updated successfully!"]);
    }

    public function update_destination(Request $request)
    {
        $destination_port = $request->destination_port_id;

        if (empty($destination_port)) {
            return json_encode(["success" => false, "msg" => "Please select any destination!"]);
        }

        $data = [
            'destination_port_id' => $destination_port, 
            "update_destination" => "1"
        ];

        $sel_vehicle = Vehicle::where('id', $request->vehicle_id)->first();
        if (!empty($destination_port) && (empty($sel_vehicle->destination_port_id) || $sel_vehicle->destination_port_id !== $destination_port)) {
            $destination = DestinationPort::where("id", $destination_port)->first();
            $data['unloading_fee'] = $destination->unloading_fee;
        }

        Vehicle::where("id", $request->vehicle_id)->update($data);

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

    public function cont_search($records,$request,&$data) {
        /*
        SET DEFAULT VALUES
        */
        if($request->perpage)
            $this->perpage = $request->perpage;
        $data['sindex'] = ($request->page != NULL)?($this->perpage*$request->page - $this->perpage+1):1;
        /*
        FILTER THE DATA
        */
        $params = [];
        if($request->is_active) {
            $params['is_active'] = $request->is_active;
            $records = $records->where("is_active",$params['is_active']);
        }
        if (!empty($request->port) && $request->port !== 'all') {
            $data['port'] = $request->port;
            $records = $records->where('loading_port_id', $request->port);
        }
        if (!empty($request->status) && $request->status !== 'all') {
            $data['status'] = $request->status;
            $records = $records->where('status_id', $request->status);
        }
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $records = $records->where(function ($query) use ($search) {
                $query->where('booking_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('container_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('export_reference', 'LIKE', '%'.$search.'%')
                    ->orWhere('departure', 'LIKE', '%'.$search.'%')
                    ->orWhere('arrival', 'LIKE', '%'.$search.'%');
            });
        }
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || @$request->pay_status == '0') {
            $data['pay_status'] = $request->pay_status;
            $records = $records->where('all_paid', $request->pay_status);
        }
        $data['request'] = $params;
        return $records;    
    }

    public function containers(Request $request)
    {
        $user_id = Auth::user()->id;
        $data['type'] = "containers";
        $data['page'] = '1';
        $data['all_port'] = LoadingPort::all();
        $data['all_status'] = ContStatus::all();
        foreach ($data['all_status'] as $key => $value) {
            $total_count = Container::where("status_id", $value->id)->where("buyers", "LIKE", "%-".Auth::user()->id."-%")->count();
            $data['all_status'][$key]["containers"] = $total_count;
        }

        $data['countries'] = Country::all();
        /*
        GET RECORDS
        */
        $records = new Container;
        $records = $records->orderBy('id','DESC')->with('container_vehicle', 'container_documents', 'status', 'shipping_line', 'loading_port', 'discharge_port', 'destination_port', 'measurement')->where("buyers", "LIKE", "%-".$user_id."-%");
        $records = $this->cont_search($records,$request,$data);
        /*
        GET TOTAL RECORD BEFORE BEFORE PAGINATE
        */
        $data['count'] = $records->count();
        /*
        PAGINATE THE RECORDS
        */
        $records = $records->paginate($this->perpage);
        $records->appends($request->all())->links();
        $links = $records->links();

        $records = $records->toArray();
        $records['pagination'] = $links;

        foreach ($records['data'] as $key => $value) {
            $buyer = ContainerVehicle::with("user")->where("container_id", $value['id'])->get();
            $unique = [];
            $buyers = [];
            foreach ($buyer as $k => $v) {
                $user_id = $v->user_id;
                if (!in_array($user_id, $unique)) {
                    array_push($unique, $user_id);
                    $vehicles = AssignVehicle::with('vehicle')->where("user_id", $user_id)->where('assigned_to', $value['id'])->get();
                    if (count($vehicles) > 0) {
                        $v->vehicles = $vehicles;
                        array_push($buyers, $v);
                    }
                }
            }
            $records['data'][$key]['buyers'] = $buyers;
        }
        $data['admin'] = $records;     
        $data['user'] = [
            "data" => []
        ];     
        
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
        $data['email_history'] = EmailHistory::where("container_id", $id)->where("user_id", \Auth::user()->id)->get();
        $data['countries'] = Country::all();
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
            $company_fee = Vehicle::where("id", $value->vehicle_id)->first()->company_fee;
            $unloading_fee = Vehicle::where("id", $value->vehicle_id)->first()->unloading_fee;
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
        $company_fee = Vehicle::where('buyer_id', Auth::user()->id)->sum('company_fee');
        $unloading_fee = Vehicle::where('buyer_id', Auth::user()->id)->sum('unloading_fee');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', Auth::user()->id)->get();
        $fines = 0;
        foreach ($all_data as $k => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $ke => $v) {
                    $fines += (int)$v->amount;
                }
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
        $data['countries'] = Country::all();
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
                'ClientID' => "AB3dxRPE8re9a18VJzPHTmjkbDSfvXkVPB6rN5OGvckDbYNpav",
                'ClientSecret' => "2hwgy4HHP7nzLyriDrvBfm2YoJPuuJIatlzd6FDf",
                'RedirectURI' => "https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl",
                'accessTokenKey' => "eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..ibn8Cb0a2QCQrP530_2f9g.7xlNuObjWb4LOq6pj0O9u5gRBYBEj8FWm0pyIaHI3QF9W0VOkZyl7FSNV84r9Ns-S293Gi1x64ImSbRhaUNtVG4kyIahD7aF2Jp-uUmjhDLM1RvqaX--jTzWZB3AIc71JB_pwRNQmVlpBYJdQhRFT66lPYBPcBjvS9AEksU-sIJbcZaaL5_28iVjpA-VatyUJmoeWEfVMe2IlzmBU6UY4zAUfoheA4mCcQ2VfCfz6TlYXJJAiblgG7LVcwN67bs17hpSDyWpbsAaxjkgYE5fkB6nUw1-TE9Sq4XLHmsEVw1SjRbG4XVCY-i91rb92rb8kycnziBDNTRjoAYRN4Lo0j2hKttjWE4zhtR1dl9ZyUk9USsxmKsKIpvNVcDuqJbzdNFm31zSem9NsJyuKrRQeWGYbGKlXNQejAWhvV34RUnenfZBHN-kFwZDsOazLrKlQNpUlkEyK03IobSmJqXWmjBTJm4E2mVPbEeLrrzeDyhz7lkq0BUXkYOJqIuvfR2GlUdjmWE6Yi7rSTTuVaxMd17r1LElDVHzdgjpYasGFy9s9TVT63oUK6_4z3QeP8QU5DCA6WKa5d9CltilTLzd3Fyt6jx6kpRiV4g3erC6uKbYpbvVQE8sE5uYLIx4xMJLgh88TRG6WYB4ZXHr2ikIvkA6ySKC41it9Emy_00bgHBILpB5tq_L7JFIwyvMKcCrnXxxqmpHRrK8Z3xzx6ujV17_FHPP137dvhJ5H-R-hzM.Bsx7PjYGXjHuvnQ6ftXK0w",
                'refreshTokenKey' => "AB117078409407Ey5Zaq8f0WcUHj7O9l0WNqm3fmUdeTWxY36E",
                'QBORealmID' => "4620816365327675980",
                'baseUrl' => "development"
            ]);

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $accessTokenObj = $OAuth2LoginHelper->refreshAccessTokenWithRefreshToken("AB117078409407Ey5Zaq8f0WcUHj7O9l0WNqm3fmUdeTWxY36E");
            $accessTokenValue = $accessTokenObj->getAccessToken();
            $refreshTokenValue = $accessTokenObj->getRefreshToken();

            $dataService = DataService::Configure([
                'auth_mode' => 'oauth2',
                'ClientID' => "AB3dxRPE8re9a18VJzPHTmjkbDSfvXkVPB6rN5OGvckDbYNpav",
                'ClientSecret' => "2hwgy4HHP7nzLyriDrvBfm2YoJPuuJIatlzd6FDf",
                'RedirectURI' => "https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl",
                'accessTokenKey' => $accessTokenValue,
                'refreshTokenKey' => $refreshTokenValue,
                'QBORealmID' => "4620816365327675980",
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
                        "Description" => @$v->vehicle->modal.' '.@$v->vehicle->company_name.' '.@$v->vehicle->name,
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

            dd($resultObj);

            if (!empty($resultObj->Id)) {
                return json_encode(["flag" => true, "msg" => "Invoice created successfully!"]);
            } else {
                return json_encode(["flag" => false, "msg" => "Something went wrong. Invoice creation failed!"]);
            }
        } else {
            return json_encode(["flag" => false, "msg" => "Please add any buyer to this container first!"]);
        }
    }
}
