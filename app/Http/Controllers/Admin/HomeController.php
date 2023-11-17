<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Status;
use App\Models\Terminal;
use App\Models\Container;
use App\Models\ContStatus;
use App\Models\User;
use App\Models\LoadingPort;
use App\Models\Measurement;
use App\Models\NotifyParty;
use App\Models\DestinationPort;
use App\Models\DischargePort;
use App\Models\Consignee;
use App\Models\ShippingLine;
use App\Models\Shipper;
use App\Models\Auction;
use App\Models\AuctionLocation;
use App\Models\VehicleImage;
use App\Models\VehicleDocuments;
use App\Models\ContainerImage;
use App\Models\Fine;
use App\Models\AssignVehicle;
use App\Models\ContainerVehicle;
use App\Models\PickupRequest;
use App\Models\TransactionsHistory;
use App\Models\VehicleBrand;
use App\Models\VehicleModal;
use App\Models\FineType;
use App\Models\TransFineType;
use App\Models\ReminderTemplate;
use App\Models\ReminderHistory;
use App\Models\Level;
use App\Models\MoneyTransfer;
use App\Models\EmailHistory;
use App\Models\NotesHistory;
use App\Models\Carrier;
use App\Models\ShippingCompany;
use App\Models\Country;
use Auth;
use Storage;
use PDF;

class HomeController extends Controller
{
    private $perpage = 20;

    // Vehicle Functions

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
        if (!empty($request->at_terminal) && $request->at_terminal !== 'all') {
            $data['at_terminal'] = $request->at_terminal;
            $at_terminal = $request->at_terminal;
            $filter['at_terminal'] = $at_terminal;
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
        if (!empty($request->buyer) && $request->buyer !== 'all') {
            $data['buyer'] = $request->buyer;
            $records = $records->where('user_id', $request->buyer);
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
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }
        $data['type'] = "vehicles";
        $data['page'] = '1';
        $data['user_levels'] = Level::all();
        $data['all_terminal'] = Terminal::with("vehicles")->get();
        $data['all_status'] = Status::with("vehicles")->get();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_destination_port'] = DestinationPort::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        /*
        GET RECORDS
        */
        $records = new AssignVehicle;
        $records = $records->orderBy('id','DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where("assigned_by", "admin");
        $records = $this->search($records,$request,$data);
        /*
        GET TOTAL RECORD BEFORE BEFORE PAGINATE
        */
        $data['total_vehicles'] = $records->count();
        /*
        PAGINATE THE RECORDS
        */
        $records = $records->paginate($this->perpage);
        $records->appends($request->all())->links();
        $links = $records->links();

        $records = $records->toArray();
        $records['pagination'] = $links;
        $data['list'] = $records;

        /*
        ASSIGN DATA FOR VIEW
        */
        return view('admin.vehicles', $data);
    }

    public function add_vehicle(Request $request)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $this->cleanData($data);
            if (!empty($data['vin'])) {
                $total_count = Vehicle::where("vin", $data['vin'])->count();
                if ($total_count > 0) {
                    return json_encode(["success"=>false, "msg" => "VIN already exists!"]);
                }
            } else {
                return json_encode(["success"=>false, "msg" => "VIN is required!"]);
            }
            $data['owner_id'] = \Auth::user()->id;
            if (empty($data['purchase_date'])) {
                $data['purchase_date'] = date('Y-m-d');
            }
            if (!empty($data['phone'])) {
                $data['phone'] = $data['phone_code'].' '.$data['phone'];
            }
            if (!empty($data['buyer_id'])) {
                $user_levels = User::with("user_level")->where("id", $data['buyer_id'])->first();
                if (!empty($user_levels->user_level)) {
                    $data['company_fee'] = @$user_levels->user_level->company_fee;
                }
            }
            if (!empty($data['destination_port_id'])) {
                $destination = DestinationPort::where("id", $data['destination_port_id'])->first();
                $data['unloading_fee'] = $destination->unloading_fee;
            }
            if (!empty($data['weight'])) {
                $data['weight'] = (int)$data['weight'];
            }
            unset($data['phone_code']);
            $vehicle = Vehicle::create($data);
            $assign = new AssignVehicle;
            $assign->user_id = $data['buyer_id'];
            $assign->vehicle_id = $vehicle->id;
            $assign->payment_status = "unpaid";
            $assign->assigned_by = "admin";
            $assign->save();
            if ($data['buyer_id'] !== "1") {
                $fcm_token = User::where("id", $data['buyer_id'])->first()->fcm_token;
                if (!empty($fcm_token)) {
                    $this->send_noti($fcm_token, "add-vehicle", $vehicle->vin);
                }
            }
            $transaction_history = new TransactionsHistory;
            $transaction_history->user_id = $data['buyer_id'];
            $transaction_history->amount = '0';
            $transaction_history->vehicle_id = $vehicle->id;
            $transaction_history->type = 'init';
            $transaction_history->save();
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/vehicle-'.$vehicle->id, $file);

                    $image = new VehicleImage;
                    $image->vehicle_id = $vehicle->id;
                    $image->filesize = $value->getSize();
                    $image->owner_id = $data['buyer_id'];
                    $image->title = '';
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->type = 'warehouse';
                    $image->save();
                }
            }
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/vehicle-'.$vehicle->id, $file);
                    
                    $image = new VehicleDocuments;
                    $image->vehicle_id = $vehicle->id;
                    $image->filesize = $value->getSize();
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->save();
                }
            }
            if (!empty($data['auction_type'])) {
                foreach ($data['auction_type'] as $key => $value) {
                    $fine = new Fine;
                    $fine->vehicle_id = $vehicle->id;
                    $fine->type = 'auction';
                    $fine->cause = $value;
                    $fine->amount = $data['auction_fine'][$key];
                    $fine->save();
                }
            }
            if (!empty($data['trans_type'])) {
                foreach ($data['trans_type'] as $key => $value) {
                    $fine = new Fine;
                    $fine->vehicle_id = $vehicle->id;
                    $fine->type = 'transaction';
                    $fine->cause = $value;
                    $fine->amount = $data['trans_fine'][$key];
                    $fine->save();
                }
            }
            if (!empty($data['expense_type'])) {
                foreach ($data['expense_type'] as $key => $value) {
                    $fine = new Fine;
                    $fine->vehicle_id = $vehicle->id;
                    $fine->type = 'draft_expense';
                    $fine->cause = $value;
                    $fine->amount = $data['expense_fine'][$key];
                    $fine->save();
                }
            }
            $response = array('success'=>true,'msg'=>'Vehicle is added sucessfully.','action'=>'reload');
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'add-vehicle';
        $data['action'] = url('admin/vehicles/add');
        $data['user_levels'] = Level::all();
        $data['all_status'] = Status::all();
        $data['all_terminal'] = Terminal::all();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_auction'] = Auction::all();
        $data['all_auction_location'] = AuctionLocation::all();
        $data['all_vehicle_brand'] = VehicleBrand::all();
        $data['all_vehicle_modal'] = VehicleModal::all();
        $data['all_fine_type'] = FineType::all();
        $data['all_trans_fine_type'] = TransFineType::all();
        $data['all_destination_port'] = DestinationPort::all();
        $data['all_carrier'] = Carrier::all();
        $data['all_shipping_company'] = ShippingCompany::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.add-vehicle', $data);
    }

    public function edit_vehicle(Request $request, $id)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $vehicle = AssignVehicle::where('id', $id)->first();
            if (!empty($data['vin'])) {
                $total_count = Vehicle::where("id", "!=", $vehicle->vehicle_id)->where("vin", $data['vin'])->count();
                if ($total_count > 0) {
                    return json_encode(["success"=>false, "msg" => "VIN already exists!"]);
                }
            } else {
                return json_encode(["success"=>false, "msg" => "VIN is required!"]);
            }
            // if ($data['buyer_id'] !== $buyer) {
            //     AssignVehicle::where('id', $id)->update(["user_id" => $data['buyer_id']]);
            //     $vehicle_id = AssignVehicle::where('id', $id)->first()->vehicle_id;
            //     TransactionsHistory::where('user_id', $buyer)->where('vehicle_id', $vehicle_id)->update(["user_id" => $data['buyer_id']]);
            //     if ($data['buyer_id'] !== "1") {
            //         $fcm_token = User::where("id", $data['buyer_id'])->first()->fcm_token;
            //         $this->send_noti($fcm_token, "add-vehicle");
            //     }
            // }
            if ($data['destination_port_id'] == "0") {
                $data['update_destination'] = 0; 
            }
            $id = AssignVehicle::where('id', $id)->first()->vehicle_id;
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/vehicle-'.$id, $file);
                    
                    $image = new VehicleImage;
                    $image->vehicle_id = $id;
                    $image->filesize = $value->getSize();
                    $image->owner_id = $vehicle->user_id;
                    $image->title = '';
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->type = 'warehouse';
                    $image->save();
                }
            }
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/vehicle-'.$id, $file);
                    
                    $image = new VehicleDocuments;
                    $image->vehicle_id = $id;
                    $image->filesize = $value->getSize();
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->save();
                }
            }
            if (!empty($data['auction_type'])) {
                foreach ($data['auction_type'] as $key => $value) {
                    $fine = new Fine;
                    $fine->vehicle_id = $id;
                    $fine->type = 'auction';
                    $fine->cause = $value;
                    $fine->amount = $data['auction_fine'][$key];
                    $fine->save();
                }
            }
            if (!empty($data['trans_type'])) {
                foreach ($data['trans_type'] as $key => $value) {
                    $fine = new Fine;
                    $fine->vehicle_id = $id;
                    $fine->type = 'transaction';
                    $fine->cause = $value;
                    $fine->amount = $data['trans_fine'][$key];
                    $fine->save();
                }
            }
            if (!empty($data['expense_type'])) {
                foreach ($data['expense_type'] as $key => $value) {
                    $fine = new Fine;
                    $fine->vehicle_id = $id;
                    $fine->type = 'draft_expense';
                    $fine->cause = $value;
                    $fine->amount = $data['expense_fine'][$key];
                    $fine->save();
                }
            }
            $this->cleanData($data);
            if (!empty($data['phone'])) {
                $data['phone'] = $data['phone_code'].' '.$data['phone'];
            }
            unset($data['documents']);
            unset($data['images']);
            unset($data['trans_type']);
            unset($data['trans_fine']);
            unset($data['auction_type']);
            unset($data['auction_fine']);
            unset($data['expense_type']);
            unset($data['expense_fine']);
            unset($data['phone_code']);
            if ($data['status_id'] == "6") {
                $data["delivered_on_date"] = date("Y-m-d");
            }
            if (!empty($data['weight'])) {
                $data['weight'] = (int)$data['weight'];
            }
            $sel_vehicle = Vehicle::where('id', $id)->first();
            if (!empty($data['destination_port_id']) && (empty($sel_vehicle->destination_port_id) || $sel_vehicle->destination_port_id !== $data['destination_port_id'])) {
                $destination = DestinationPort::where("id", $data['destination_port_id'])->first();
                $data['unloading_fee'] = $destination->unloading_fee;
            } else if ($data['destination_port_id'] == "0") {
                $data['unloading_fee'] = 0;
            }
            Vehicle::where('id', $id)->update($data);

            $total_paid = TransactionsHistory::where("vehicle_id", $id)->where("user_id", $vehicle->user_id)->sum("amount");

            $auction_price = Vehicle::where("id", $id)->first()->auction_price;
            $towing_price = Vehicle::where("id", $id)->first()->towing_price;
            $occean_freight = Vehicle::where("id", $id)->first()->occean_freight;
            $fines = Fine::where("vehicle_id", $id)->sum('amount');
            $get_vehicle = Vehicle::with("buyer.user_level", "destination_port")->where("id", $id)->first();
            $company_fee = Vehicle::where("id", $id)->first()->company_fee;
            $unloading_fee = Vehicle::where("id", $id)->first()->unloading_fee;

            $total_unpaid = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;

            if ($total_unpaid > $total_paid) {
                if ($vehicle->payment_status == "paid") {
                    AssignVehicle::where("vehicle_id", $id)->where("user_id", $vehicle->user_id)->update(["payment_status" => "partly paid"]);
                }
            } else if ($total_unpaid == $total_paid) {
                if ($vehicle->payment_status !== "paid") {
                    AssignVehicle::where("vehicle_id", $id)->where("user_id", $vehicle->user_id)->update(["payment_status" => "paid"]);
                }
            }

            $response = array('success'=>true,'msg'=>'Vehicle is updated sucessfully.','action'=>'reload');
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'vehicles';
        $data['action'] = url('admin/vehicles/edit/'.$id);
        $data['user_levels'] = Level::all();
        $data['list'] = AssignVehicle::with('vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.destination_port', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer', 'container.shipping_line')->where('id', $id)->first();
        $data['all_status'] = Status::all();
        $data['all_terminal'] = Terminal::all();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_auction'] = Auction::all();
        $data['all_auction_location'] = AuctionLocation::all();
        $data['all_vehicle_brand'] = VehicleBrand::all();
        $data['all_vehicle_modal'] = VehicleModal::all();
        $data['all_fine_type'] = FineType::all();
        $data['all_trans_fine_type'] = TransFineType::all();
        $data['all_destination_port'] = DestinationPort::all();
        $data['all_carrier'] = Carrier::all();
        $data['all_shipping_company'] = ShippingCompany::all();
        $data['templates'] = ReminderTemplate::all();
        $vid = AssignVehicle::where('id', $id)->first()->vehicle_id;
        $data['history'] = ReminderHistory::where('vehicle_id', $vid)->get();
        $data['notes_history'] = NotesHistory::where('vehicle_id', $vid)->get();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['email_history'] = EmailHistory::where("vehicle_id", $vid)->where("user_id", \Auth::user()->id)->get();
        $data['countries'] = Country::all();
        return view('admin.edit-vehicle', $data);
    }

    public function delete_vehicles($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        AssignVehicle::where('vehicle_id', $id)->delete();
        $response = array('success'=>true,'msg'=>'Vehicle has been deleted.');
        echo json_encode($response); return;
    }

    // Container Functions

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
        if (!empty($request->fromDate) && !empty($request->toDate)) {
            $data['fromDate'] = $request->fromDate;
            $data['toDate'] = $request->toDate;
            $records = $records->where('arrival', '<=', $request->toDate)->where('arrival', '>=', $request->fromDate);
        } elseif(!empty($request->fromDate)) {
            $data['fromDate'] = $request->fromDate;
            $records = $records->where('arrival', '>=', $request->fromDate);
        } elseif(!empty($request->toDate)) {
            $data['toDate'] = $request->toDate;
            $records = $records->where('arrival', '<=', $request->toDate);
        }
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || @$request->pay_status == '0') {
            $data['pay_status'] = $request->pay_status;
            $records = $records->where('all_paid', $request->pay_status);
        }
        if (!empty($request->released_status) && $request->released_status !== 'all') {
            $data['released_status'] = $request->released_status;
            $records = $records->where('released_status', $request->released_status);
        }
        if (!empty($request->unloaded_status) && $request->unloaded_status !== 'all') {
            $data['unloaded_status'] = $request->unloaded_status;
            $records = $records->where('unloaded_status', $request->unloaded_status);
        }
        $data['request'] = $params;
        return $records;    
    }

    public function containers(Request $request)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }

        $data['type'] = "containers";
        $data['page'] = '1';
        $data['user_levels'] = Level::all();
        $data['all_port'] = LoadingPort::all();
        $data['all_status'] = ContStatus::with("containers")->get();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        /*
        GET RECORDS
        */
        $records = new Container;
        $records = $records->orderBy('id','DESC')->with('container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement');
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
        $data['list'] = $records;     
        
        return view('admin.containers', $data);
    }

    public function add_container(Request $request)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $this->cleanData($data);
            $data['owner_id'] = Auth::user()->id;
            $data['request_type'] = '2';
            $data['date_created'] = time();
            if (!empty($data['booking_no'])) {
                $check = Container::where("booking_no", $data['booking_no'])->count();
                if ($check > 0) {
                    $response = array('success'=>false,'msg'=>'Booking number already exists!','action'=>'reload');
                    return json_encode($response);
                }
            }
            if ($data['released_status'] == "In hand") {
                $data["in_hand_date"] = date("Y-m-d");
            }
            $container = Container::create($data);
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/container-'.$container->id, $file);
                    
                    $image = new ContainerImage;
                    $image->container_id = $container->id;
                    $image->filesize = $value->getSize();
                    $image->title = 'images';
                    $image->owner_id = Auth::user()->id;
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->save();
                }
            }
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/container-'.$container->id, $file);
                    
                    $image = new ContainerImage;
                    $image->container_id = $container->id;
                    $image->filesize = $value->getSize();
                    $image->title = '';
                    $image->owner_id = Auth::user()->id;
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->save();
                }
            }
            $response = array('success'=>true,'msg'=>'Container is added sucessfully.','action'=>'reload','url'=>url('/admin/containers/edit', $container->id));
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'add-container';
        $data['action'] = url('admin/containers/add');
        $data['user_levels'] = Level::all();
        $data['all_shipper'] = Shipper::all();
        $data['all_shipping_line'] = ShippingLine::all();
        $data['all_loading_port'] = LoadingPort::all();
        $data['all_consignee'] = Consignee::all();
        $data['all_destination_port'] = DestinationPort::all();
        $data['all_status'] = ContStatus::all();
        $data['all_notify_party'] = NotifyParty::all();
        $data['all_measurement'] = Measurement::all();
        $data['all_discharge_port'] = DischargePort::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.add-container', $data);
    }

    public function edit_container(Request $request, $id)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $container = Container::where('id', $id)->first();
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/container-'.$id, $file);
                    
                    $image = new ContainerImage;
                    $image->container_id = $container->id;
                    $image->filesize = $value->getSize();
                    $image->title = 'images';
                    $image->owner_id = Auth::user()->id;
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->save();
                }
            }
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $current_date = explode("-", date("Y-m-d"));
                    $filename = Storage::disk("s3")->putFile('storage/'.$current_date[0].'y/'.$current_date[1].'/'.$current_date[2].'/container-'.$id, $file);
                    
                    $image = new ContainerImage;
                    $image->container_id = $id;
                    $image->filesize = $value->getSize();
                    $image->title = '';
                    $image->owner_id = Auth::user()->id;
                    $image->filename = $filename;
                    $image->filepath = '';
                    $image->save();
                }
            }
            $this->cleanData($data);
            if ($container->container_no !== $data['container_no'] && !empty($data['container_no'])) {
                $data['status_id'] = "2";
            }
            if ($container->arrival !== $data['arrival'] && !empty($data['arrival'])) {
                $data['status_id'] = "4";
            }
            if (!empty($data['released_status']) && $data['released_status'] == "In hand") {
                $data["in_hand_date"] = date("Y-m-d");
            }
            if (!empty($data['status_id'])) {
                $all_vehicles = ContainerVehicle::where("container_id", $id)->get();
                if (count($all_vehicles) > 0) {
                    $cont_status = ContStatus::where("id", $data['status_id'])->first();
                    $veh_status = Status::where("name", $cont_status->name)->first();
                    if (!empty($veh_status)) {
                        foreach ($all_vehicles as $key => $value) {
                            Vehicle::where("id", $value->vehicle_id)->update(["status_id" => $veh_status->id]);
                        }
                    }
                }
            }
            unset($data['documents']);
            unset($data['images']);
            if (!empty($data['cut_off']) && $data['cut_off'] == "0000-00-00") {
                unset($data['cut_off']);
            }
            $container = Container::where('id', $id)->update($data);
            $response = array('success'=>true,'msg'=>'Container is updated sucessfully.','action'=>'reload');
            return json_encode($response);
        }
        $data = array();

        $buyer = ContainerVehicle::with("user")->where("container_id", $id)->get();
        $unique = [];
        $buyers = [];
        $c_id = [];
        foreach ($buyer as $k => $v) {
            $user_id = $v->user_id;
            if (!in_array($user_id, $unique)) {
                array_push($unique, $user_id);
                $vehicles = AssignVehicle::with('vehicle')->where("user_id", $user_id)->where('assigned_to', $id)->get();
                if (count($vehicles) > 0) {
                    $v->vehicles = $vehicles;
                    array_push($buyers, $v);
                    array_push($c_id, $v->id);
                }
            } else {
                array_push($c_id, $v->id);
            }
        }
        $data['buyers'] = $buyers;
        $data['c_id'] = $c_id;
        $data['type'] = 'containers';
        $data['action'] = url('admin/containers/edit/'.$id);
        $data['user_levels'] = Level::all();
        $data['container'] = Container::with('container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->where('id', $id)->first();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_shipper'] = Shipper::all();
        $data['all_shipping_line'] = ShippingLine::all();
        $data['all_loading_port'] = LoadingPort::all();
        $data['all_consignee'] = Consignee::all();
        $data['all_destination_port'] = DestinationPort::all();
        $data['all_status'] = ContStatus::all();
        $data['all_notify_party'] = NotifyParty::all();
        $data['all_measurement'] = Measurement::all();
        $data['all_discharge_port'] = DischargePort::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['email_history'] = EmailHistory::where("container_id", $id)->where("user_id", \Auth::user()->id)->get();
        $data['countries'] = Country::all();
        return view('admin.edit-container', $data);
    }

    public function delete_containers($id)
    {
        $container = Container::find($id);
        $container->delete();
        $response = array('success'=>true,'msg'=>'Container has been deleted.');
        echo json_encode($response); return;
    }

    public function send_email(Request $request)
    {
        $data = $request->all();

        if (!empty($data['vehicle_id'])) {
            $vehicle = Vehicle::with('vehicle_documents')->where('id', $data['vehicle_id'])->first();

            \Mail::to($data['sent_to'])->send(new \App\Mail\SendVehicle($vehicle, url("/").$vehicle->vehicle_documents[0]->filename));
        }

        if (!empty($data['container_id'])) {
            $container = Container::with('status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement')->where('id', $data['container_id'])->first();

            \Mail::to($data['sent_to'])->send(new \App\Mail\SendContainer($container));
        }

        EmailHistory::create($data);

        return json_encode(["success" => true, "msg" => "Email is sended successfully!"]);
    }

    public function loading_order(Request $request, $id)
    {
        $container = Container::with('status', 'shipping_line', 'shipper', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'measurement')->where("id", $id)->first();
        $vehicle = ContainerVehicle::with("vehicle")->where("container_id", $id)->get();
        $data = [
            'container' => $container,
            'vehicle' => $vehicle
        ];

        $pdf = PDF::loadView('pdf.loading-order', $data);

        return $pdf->download('loading-order.pdf');
    }

    public function letter(Request $request, $id)
    {
        $container = Container::with('status', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'measurement')->where("id", $id)->first();
        $vehicle = ContainerVehicle::with("vehicle")->where("container_id", $id)->get();
        $data = [
            'container' => $container,
            'vehicle' => $vehicle
        ];

        $pdf = PDF::loadView('pdf.letter', $data);

        return $pdf->download('letter.pdf');
    }

    public function financial_system(Request $request)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }

        $data['type'] = "financial-system";
        $data['page'] = '1';
        $filter = [];
        if (!empty($request->buyer) && $request->buyer !== 'all') {
            $data['buyer'] = $request->buyer;
            $buyer = $request->buyer;
            $filter['buyer'] = $buyer;
        }
        if (!empty($request->vin)) {
            $data['vin'] = $request->vin;
            $vin = $request->vin;
            $filter['vin'] = $vin;
        }

        $transaction_history = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer')->whereHas("vehicle");
        if (!empty($filter)) {
            $transaction_history = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer')->whereHas('vehicle', function ($query) use($filter) {
                if (!empty($filter['vin'])) {
                    $query->where('vin', $filter['vin']);
                }
                if (!empty($filter['buyer'])) {
                    $query->where('buyer_id', $filter['buyer']);
                }
            });
        }
        if (!empty($request->from) && !empty($request->to)) {
            $data['from'] = $request->from;
            $data['to'] = $request->to;
            $transaction_history = $transaction_history->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $data['from'] = $request->from;
            $transaction_history = $transaction_history->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $data['to'] = $request->to;
            $transaction_history = $transaction_history->where('created_at', '<=', $request->to);
        }
        $previous = $transaction_history->sum('amount');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $transaction_history = $transaction_history->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $transaction_history = $transaction_history->where("type", "init")->limit(10)->get();

        foreach ($transaction_history as $key => $value) {
            $all_transactions = TransactionsHistory::where("vehicle_id", $value->vehicle_id)->where("user_id", $value->user_id);
            $transaction_history[$key]['total_paid'] = $all_transactions->sum("amount");
            $transaction_history[$key]['all'] = $all_transactions->where("type", "!=", "init")->get();
            $transaction_history[$key]['payment_status'] = AssignVehicle::where("vehicle_id", $value->vehicle_id)->where("user_id", $value->user_id)->first()->payment_status;

            $auction_price = Vehicle::where("id", $value->vehicle_id)->first()->auction_price;
            $towing_price = Vehicle::where("id", $value->vehicle_id)->first()->towing_price;
            $occean_freight = Vehicle::where("id", $value->vehicle_id)->first()->occean_freight;
            $fines = Fine::where("vehicle_id", $value->vehicle_id)->sum('amount');
            $company_fee = Vehicle::where("id", $value->vehicle_id)->first()->company_fee;
            $unloading_fee = Vehicle::where("id", $value->vehicle_id)->first()->unloading_fee;

            $total_unpaid = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;

            $transaction_history[$key]['total_unpaid'] = $total_unpaid - (int)$all_transactions->sum("amount");
        }

        $data['transaction_history'] = $transaction_history;

        $auction_price = new Vehicle;
        if (!empty($filter['vin'])) {
            $auction_price = $auction_price->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $auction_price = $auction_price->where('buyer_id', $filter['buyer']);
        }
        if (!empty($request->from) && !empty($request->to)) {
            $auction_price = $auction_price->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $auction_price = $auction_price->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $auction_price = $auction_price->where('created_at', '<=', $request->to);
        }
        $auction_price = $auction_price->sum('auction_price');
        $towing_price = new Vehicle;
        if (!empty($filter['vin'])) {
            $towing_price = $towing_price->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $towing_price = $towing_price->where('buyer_id', $filter['buyer']);
        }
        if (!empty($request->from) && !empty($request->to)) {
            $towing_price = $towing_price->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $towing_price = $towing_price->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $towing_price = $towing_price->where('created_at', '<=', $request->to);
        }
        $towing_price = $towing_price->sum('towing_price');
        $occean_freight = new Vehicle;
        if (!empty($filter['vin'])) {
            $occean_freight = $occean_freight->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $occean_freight = $occean_freight->where('buyer_id', $filter['buyer']);
        }
        if (!empty($request->from) && !empty($request->to)) {
            $occean_freight = $occean_freight->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $occean_freight = $occean_freight->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $occean_freight = $occean_freight->where('created_at', '<=', $request->to);
        }
        $occean_freight = $occean_freight->sum('occean_freight');
        $company_fee = new Vehicle;
        if (!empty($filter['vin'])) {
            $company_fee = $company_fee->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $company_fee = $company_fee->where('buyer_id', $filter['buyer']);
        }
        if (!empty($request->from) && !empty($request->to)) {
            $company_fee = $company_fee->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $company_fee = $company_fee->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $company_fee = $company_fee->where('created_at', '<=', $request->to);
        }
        $company_fee = $company_fee->sum('company_fee');
        $unloading_fee = new Vehicle;
        if (!empty($filter['vin'])) {
            $unloading_fee = $unloading_fee->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $unloading_fee = $unloading_fee->where('buyer_id', $filter['buyer']);
        }
        if (!empty($request->from) && !empty($request->to)) {
            $unloading_fee = $unloading_fee->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $unloading_fee = $unloading_fee->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $unloading_fee = $unloading_fee->where('created_at', '<=', $request->to);
        }
        $unloading_fee = $unloading_fee->sum('unloading_fee');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines");
        if (!empty($filter['vin'])) {
            $all_data = $all_data->where('vin', $filter['vin']);
        }
        if (!empty(@$filter['buyer'])) {
            $all_data = $all_data->where('buyer_id', $filter['buyer']);
        }
        if (!empty($request->from) && !empty($request->to)) {
            $all_data = $all_data->where('created_at', '<=', $request->to)->where('created_at', '>=', $request->from);
        } elseif(!empty($request->from)) {
            $all_data = $all_data->where('created_at', '>=', $request->from);
        } elseif(!empty($request->to)) {
            $all_data = $all_data->where('created_at', '<=', $request->to);
        }
        $all_data = $all_data->get();

        $balance = new User;
        if (!empty($filter['vin'])) {
            $v = Vehicle::where("vin", $filter['vin'])->first();
            $balance = $balance->where('id', $v);
        }
        if (!empty(@$filter['buyer'])) {
            $balance = $balance->where('id', $filter['buyer']);
        }
        $balance = $balance->sum('balance');

        $fines = 0;
        foreach ($all_data as $key => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $k => $val) {
                    $fines += (int)$val->amount;
                }
            }
        }
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $data['previous'] = $previous;
        $data['due_payments'] = (int)$due_payments - (int)$previous;
        $data['balance'] = $balance;
        if ($data['due_payments'] < 0) {
            $data['due_payments'] = 0;
        }
        $data['user_levels'] = Level::all();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['latest_count'] = MoneyTransfer::where('latest', '1')->count();
        $data['countries'] = Country::all();
        return view('admin.financial-system', $data);
    }

    public function transaction_history(Request $request)
    {
        $data = $request->all();
        $user = User::where("id", $data['user_id'])->first();
        if (!empty($user)) {
            if ($user->balance !== 0 && $data['amount'] <= $user->balance) {
                $pre_balance = $user->balance;
                $balance = (int)$pre_balance - (int)$data['amount'];
                User::where("id", $data['user_id'])->update(["balance" => $balance]);
            } else {
                return json_encode(["success"=>false, 'msg'=>'Buyer have low balance!']);
            }
        }
        TransactionsHistory::create($data);

        $status = "partly paid";
        $total_paid = TransactionsHistory::where("vehicle_id", $data['vehicle_id'])->where("user_id", $data['user_id'])->sum("amount");

        $auction_price = Vehicle::where("id", $data['vehicle_id'])->first()->auction_price;
        $towing_price = Vehicle::where("id", $data['vehicle_id'])->first()->towing_price;
        $occean_freight = Vehicle::where("id", $data['vehicle_id'])->first()->occean_freight;
        $fines = Fine::where("vehicle_id", $data['vehicle_id'])->sum('amount');
        $company_fee = Vehicle::where("id", $data['vehicle_id'])->first()->company_fee;
        $unloading_fee = Vehicle::where("id", $data['vehicle_id'])->first()->unloading_fee;

        $total_unpaid = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;

        $total_amount = (int)$total_unpaid - (int)$total_paid;

        if ($total_amount == "0") {
            $status = "paid";
        }

        AssignVehicle::where("vehicle_id", $data['vehicle_id'])->where("user_id", $data['user_id'])->update(["payment_status" => $status]);

        return json_encode(["success"=>true, 'msg'=>'Transaction is added successfully!', 'action'=>'reload']);
    }

    public function pay_all(Request $request)
    {
        $data = $request->all();

        $amount = explode(",", $data['amount']);
        $type = explode(",", $data['type']);
        $user_id = explode(",", $data['user_id']);
        $vehicle_id = explode(",", $data['vehicle_id']);

        $total_amount = 0;
        foreach ($amount as $key => $value) {
            $total_amount += $value;
        }

        $user = User::where("id", $user_id[0])->first();
        if (!empty($user)) {
            if ($user->balance !== 0 && $total_amount <= $user->balance) {
            } else {
                return json_encode(["success"=>false, 'msg'=>'Buyer have low balance!']);
            }
        }

        foreach ($user_id as $key => $value) {
            $user = User::where("id", $value)->first();
            $pre_balance = $user->balance;
            $balance = (int)$pre_balance - (int)$amount[$key];
            User::where("id", $value)->update(["balance" => $balance]);
                
            $transaction_data = [
                "user_id" => $value,
                "vehicle_id" => $vehicle_id[$key],
                "type" => $type[$key],
                "amount" => $amount[$key]
            ];
            TransactionsHistory::create($transaction_data);   
        }
        AssignVehicle::where("vehicle_id", $vehicle_id[0])->where("user_id", $user_id[0])->update(["payment_status" => "paid"]);

        return json_encode(["success"=>true, 'msg'=>'Transaction is added successfully!', 'action'=>'reload']);
    }

    public function add_balance(Request $request)
    {
        $user_id = $request->user_id;
        $amount = (int)$request->amount;
        $pre_amount = User::where("id", $user_id)->first();
        $balance = $amount + (int)$pre_amount->balance;
        User::where("id", $user_id)->update(['balance' => $balance]);

        return json_encode(["success"=>true, 'msg'=>'Balance is added successfully!', 'action'=>'reload']);
    }

    public function add_comment(Request $request)
    {
        $admin_notes = $request->admin_notes;
        $vehicle_id = $request->vehicle_id;

        Vehicle::where("id", $vehicle_id)->update(["notes_financial" => $admin_notes]);

        return json_encode(["success"=>true, 'msg'=>'Comment is updated successfully!', 'action'=>'reload']);
    }

    public function pickup_history(Request $request)
    {
        if (\Auth::user()->role !== "1") {
            return redirect(url("user"));
        }
        
        $data['type'] = "pickup-history";
        $data['page'] = '1';
        $filter = [];
        $pickup = PickupRequest::orderBy('id', 'DESC')->with('user', 'vehicle', 'vehicle.destination_port', 'vehicle.buyer');
        if (!empty($request->destination) && $request->destination !== 'all') {
            $data['destination'] = $request->destination;
            $destination = $request->destination;
            $filter['destination'] = $destination;
        }
        if (!empty($request->buyer) && $request->buyer !== 'all') {
            $data['buyer'] = $request->buyer;
            $buyer = $request->buyer;
            $filter['buyer'] = $buyer;
        }
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $filter['search'] = $search;
        }
        if (!empty($request->status) && $request->status !== 'all') {
            $data['status'] = $request->status;
            $filter['status'] = $request->status;
        }
        if (!empty($filter)) {
            $pickup = PickupRequest::orderBy('id', 'DESC')->with('user', 'admin', 'vehicle', 'vehicle.destination_port', 'vehicle.buyer')->whereHas('vehicle', function ($query) use($filter) {
                if (!empty($filter['destination'])) {
                    $query->where('destination_port_id', $filter['destination']);
                }
                if (!empty($filter['buyer'])) {
                    $query->where('buyer_id', $filter['buyer']);
                }
                if (!empty($filter['search'])) {
                    $search = $filter['search'];
                    $query->where(function ($q) use ($search) {
                        $q->orWhere('vin', 'LIKE', '%'.$search.'%')
                        ->orWhere('destination_manual', 'LIKE', '%'.$search.'%');
                    });
                }
                if (!empty($filter['status'])) {
                    $query->where('status', $filter['status']);
                }
            });
            if (!empty($filter['search'])) {
                $pickup = $pickup->orWhere('created_at', 'LIKE', '%'.$filter['search'].'%');
            }
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 20;
                $pickup = $pickup->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $pickup = $pickup->limit(20)->get();
        foreach ($pickup as $key => $val) {
            $buyer_id = $val->user->id;

            $previous = TransactionsHistory::where("user_id", $buyer_id)->sum('amount');
            $auction_price = Vehicle::where('buyer_id', $buyer_id)->sum('auction_price');
            $towing_price = Vehicle::where('buyer_id', $buyer_id)->sum('towing_price');
            $occean_freight = Vehicle::where('buyer_id', $buyer_id)->sum('occean_freight');
            $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', $buyer_id)->get();
            $balance = User::where('id', $buyer_id)->sum('balance');
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
            $pickup[$key]->due_payments = $all_due_payments;
            $pickup[$key]->balance = $balance;
        }
        $data['list'] = $pickup;
        $data['user_levels'] = Level::all();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_destination_port'] = DestinationPort::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.pickup-history', $data);
    }

    public function update_vehicle_data(Request $request)
    {
    	$data = [];
    	if (!empty($request->status)) {
    		$data["status_id"] = $request->status;
            if ($request->status == "6") {
                $data["delivered_on_date"] = date("Y-m-d");
            }
            $vehicle = Vehicle::where('id', $request->id)->first();
            if ($vehicle->buyer_id !== "1") {
                $fcm_token = User::where("id", $vehicle->buyer_id)->first()->fcm_token;
                if (!empty($fcm_token)) {
                    $this->send_noti($fcm_token, "status-changed", $vehicle);
                }
            }
    	}
        if (!empty($request->payment_status) || $request->payment_status == "0") {
            $data["all_paid"] = $request->payment_status;
            if ($request->payment_status == "1") {
                $data['paid_date'] = date("Y-m-d");
            }
        }
        if (!empty($request->destination_port) || $request->destination_port == "0") {
            if ($request->destination_port == "0") {
                $data['update_destination'] = 0; 
            }
            $data["destination_port_id"] = $request->destination_port;
        }
    	if (!empty($request->title)) {
    		$data["title"] = $request->title;
    	}
    	if (!empty($request->keys)) {
    		$data["keys"] = $request->keys;
    	}
    	Vehicle::where('id', $request->id)->update($data);
    	return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function update_container_data(Request $request)
    {
        $data = [];
        if (!empty($request->status)) {
            $data["status_id"] = $request->status;
            $all_vehicles = ContainerVehicle::where("container_id", $request->id)->get();
            if (count($all_vehicles) > 0) {
                $cont_status = ContStatus::where("id", $request->status)->first();
                $veh_status = Status::where("name", $cont_status->name)->first();
                if (!empty($veh_status)) {
                    foreach ($all_vehicles as $key => $value) {
                        Vehicle::where("id", $value->vehicle_id)->update(["status_id" => $veh_status->id]);
                    }
                }
            }
        }
        if (!empty($request->released_status)) {
            $data["released_status"] = $request->released_status;
            if ($request->released_status == "In hand") {
                $data["in_hand_date"] = date("Y-m-d");
            }
        }
        if (!empty($request->unloaded_status)) {
            $data["unloaded_status"] = $request->unloaded_status;
        }
        if (!empty($request->payment_status) || $request->payment_status == '0') {
            $data["all_paid"] = $request->payment_status;
        }
        Container::where('id', $request->id)->update($data);
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function vehicle_pdf_type(Request $request)
    {
        $data = [];
        if (!empty($request->type)) {
            $data["type"] = $request->type;
            VehicleDocuments::where('id', $request->id)->update($data);
            return json_encode(["success"=>true, 'action'=>'reload']);
        } else {
            return json_encode(["success"=>false, 'msg'=>'Please provide pdf type.']);
        }
    }

    public function update_pickup_data(Request $request)
    {
        $data = [];
        $data["status"] = $request->status;
        if ($data["status"] !== "waiting") {
            $data['approved_by'] = \Auth::user()->id;
        } else {
            $data['approved_by'] = NULL;
        }
        PickupRequest::where('id', $request->id)->update($data);

        $pickup = PickupRequest::where('id', $request->id)->first();

        if ($pickup->user_id !== "1") {
            $fcm_token = User::where("id", $pickup->user_id)->first()->fcm_token;
            if (!empty($fcm_token)) {
                $this->send_noti($fcm_token, "pickup-status-changed", $pickup);
            }
        }

        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function update_money_data(Request $request)
    {
        $data = [];
        $data["status"] = $request->status;

        MoneyTransfer::where('id', $request->id)->update($data);

        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function money_transfer(Request $request)
    {
        \DB::table('money_transfer')->update(["latest" => "0"]);
        
        $data['type'] = "financial-system";
        $data['page'] = "1";

        $list = MoneyTransfer::orderBy('id', 'DESC')->with("user", "vehicle");
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 20;
                $list = $list->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }

        $data["list"] = $list->limit(20)->get();
        $data['user_levels'] = Level::all();
        $data['countries'] = Country::all();
        return view("admin.money-transfer", $data);
    }

    public function delete_vehicle_fines($id)
    {
        $vehicle = Fine::find($id);
        $vehicle->delete();
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function delete_vehicle_documents($id)
    {
        $vehicle = VehicleDocuments::find($id);
        $path = $vehicle->filepath.$vehicle->filename;
        \File::delete($path);
        $vehicle->delete();
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function delete_vehicle_images($id)
    {
        $vehicle = VehicleImage::find($id);
        $path = $vehicle->filepath.$vehicle->filename;
        \File::delete($path);
        $vehicle->delete();
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function delete_container_documents($id)
    {
        $container = ContainerImage::find($id);
        $path = $container->filepath.$container->filename;
        \File::delete($path);
        $container->delete();
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function delete_buyer($c_id, $u_id)
    {
        AssignVehicle::where('user_id', $u_id)->where('assigned_to', $c_id)->update(['assigned_to'=>'0']);
        $buyer = ContainerVehicle::where('container_id', $c_id)->where('user_id', $u_id);
        $buyer->delete();
        $container = Container::where("id", $c_id)->first();
        if (!empty($container->buyers)) {
            $buyers = str_replace("-".$u_id."-", "", $container->buyers);
            Container::where("id", $c_id)->update(["buyers" => $buyers]);
        }
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function delete_buyer_vehicle($c_id, $u_id, $v_id)
    {
        AssignVehicle::where('user_id', $u_id)->where('vehicle_id', $v_id)->where('assigned_to', $c_id)->update(['assigned_to'=>'0']);
        $vehicle = ContainerVehicle::where('container_id', $c_id)->where('user_id', $u_id)->where('vehicle_id', $v_id);
        $vehicle->delete();
        $count = ContainerVehicle::where('container_id', $c_id)->where('user_id', $u_id)->count();
        if ($count == 0) {
            $container = Container::where("id", $c_id)->first();
            if (!empty($container->buyers)) {
                $buyers = str_replace("-".$u_id."-", "", $container->buyers);
                Container::where("id", $c_id)->update(["buyers" => $buyers]);
            }
        }
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function get_auction_location($id)
    {
    	$data = AuctionLocation::where("auction_id", $id)->get();
    	return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_modal($id)
    {
        $data = VehicleModal::where("vehicle_brand_id", $id)->get();
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_detail($id)
    {
        $auction_price = Vehicle::where("id", $id)->sum('auction_price');
        $towing_price = Vehicle::where("id", $id)->sum('towing_price');
        $occean_freight = Vehicle::where("id", $id)->sum('occean_freight');
        $auction_fines = Fine::where('vehicle_id', $id)->where('type', 'auction')->sum('amount');
        $trans_fines = Fine::where('vehicle_id', $id)->where('type', 'transaction')->sum('amount');
        $draft_expenses = Fine::where('vehicle_id', $id)->where('type', 'draft_expense')->sum('amount');
        $company_fee = Vehicle::where("id", $id)->sum('company_fee');
        $unloading_fee = Vehicle::where("id", $id)->sum('unloading_fee');

        $data['paid_ap'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "auction_price")->sum("amount");
        $data['paid_tp'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "towing_price")->sum("amount");
        $data['paid_of'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "occean_freight")->sum("amount");
        $data['paid_af'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "auction_fines")->sum("amount");
        $data['paid_tf'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "trans_fines")->sum("amount");
        $data['paid_de'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "draft_expenses")->sum("amount");
        $data['paid_cf'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "company_fee")->sum("amount");
        $data['paid_uf'] = TransactionsHistory::where("vehicle_id", $id)->where("type", "unloading_fee")->sum("amount");

        $data['unpaid_ap'] = (int)$auction_price - (int)$data['paid_ap'];
        if ($data['unpaid_ap'] < 0) {
            $data['unpaid_ap'] = 0;
        }
        $data['unpaid_tp'] = (int)$towing_price - (int)$data['paid_tp'];
        if ($data['unpaid_tp'] < 0) {
            $data['unpaid_tp'] = 0;
        }
        $data['unpaid_of'] = (int)$occean_freight - (int)$data['paid_of'];
        if ($data['unpaid_of'] < 0) {
            $data['unpaid_of'] = 0;
        }
        $data['unpaid_af'] = (int)$auction_fines - (int)$data['paid_af'];
        if ($data['unpaid_af'] < 0) {
            $data['unpaid_af'] = 0;
        }
        $data['unpaid_tf'] = (int)$trans_fines - (int)$data['paid_tf'];
        if ($data['unpaid_tf'] < 0) {
            $data['unpaid_tf'] = 0;
        }
        $data['unpaid_de'] = (int)$draft_expenses - (int)$data['paid_de'];
        if ($data['unpaid_de'] < 0) {
            $data['unpaid_de'] = 0;
        }
        $data['unpaid_cf'] = (int)$company_fee - (int)$data['paid_cf'];
        if ($data['unpaid_cf'] < 0) {
            $data['unpaid_cf'] = 0;
        }
        $data['unpaid_uf'] = (int)$unloading_fee - (int)$data['paid_uf'];
        if ($data['unpaid_uf'] < 0) {
            $data['unpaid_uf'] = 0;
        }

        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_notes($id)
    {
        $vehicle = Vehicle::where("id", $id)->first();
        $data['notes_financial'] = $vehicle->notes_financial;
        $data['notes_user_financial'] = $vehicle->notes_user_financial;
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_vin($id)
    {
        $data['data'] = Vehicle::where("buyer_id", $id)->get();

        $previous = TransactionsHistory::where("user_id", $id)->sum('amount');
        $auction_price = Vehicle::where('buyer_id', $id)->sum('auction_price');
        $towing_price = Vehicle::where('buyer_id', $id)->sum('towing_price');
        $occean_freight = Vehicle::where('buyer_id', $id)->sum('occean_freight');
        $company_fee = Vehicle::where('buyer_id', $id)->sum('company_fee');
        $unloading_fee = Vehicle::where('buyer_id', $id)->sum('unloading_fee');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', $id)->get();
        $balance = User::where('id', $id)->sum('balance');
        if ($id == "0") {
            $previous = TransactionsHistory::all()->sum('amount');
            $auction_price = Vehicle::sum('auction_price');
            $towing_price = Vehicle::sum('towing_price');
            $occean_freight = Vehicle::sum('occean_freight');
            $company_fee = Vehicle::sum('company_fee');
            $unloading_fee = Vehicle::sum('unloading_fee');
            $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->get();
            $balance = User::all()->sum('balance');
            $data['data'] = Vehicle::all();
        }
        $fines = 0;
        foreach ($all_data as $key => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $k => $val) {
                    $fines += (int)$val->amount;
                }
            }
        }
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $data['previous'] = $previous;
        $data['due_payments'] = (int)$due_payments - (int)$previous;
        $data['balance'] = $balance;
        if ($data['due_payments'] < 0) {
            $data['due_payments'] = 0;
        }
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_financial($id, $buyer_id)
    {
        $previous = TransactionsHistory::where("user_id", $buyer_id)->where("vehicle_id", $id)->sum('amount');
        $auction_price = Vehicle::where('id', $id)->sum('auction_price');
        $towing_price = Vehicle::where('id', $id)->sum('towing_price');
        $occean_freight = Vehicle::where('id', $id)->sum('occean_freight');
        $company_fee = Vehicle::where('id', $id)->sum('company_fee');
        $unloading_fee = Vehicle::where('id', $id)->sum('unloading_fee');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('id', $id)->get();
        $balance = User::where('id', $buyer_id)->sum('balance');
        if ($id == "0") {
            $previous = TransactionsHistory::where("user_id", $buyer_id)->sum('amount');
            $auction_price = Vehicle::where('buyer_id', $buyer_id)->sum('auction_price');
            $towing_price = Vehicle::where('buyer_id', $buyer_id)->sum('towing_price');
            $occean_freight = Vehicle::where('buyer_id', $buyer_id)->sum('occean_freight');
            $company_fee = Vehicle::where('buyer_id', $buyer_id)->sum('company_fee');
            $unloading_fee = Vehicle::where('buyer_id', $buyer_id)->sum('unloading_fee');
            $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', $buyer_id)->get();
            $balance = User::all()->sum('balance');
        }
        $fines = 0;
        foreach ($all_data as $key => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $k => $val) {
                    $fines += (int)$val->amount;
                }
            }
        }
        $due_payments = (int)$auction_price + (int)$towing_price + (int)$occean_freight + (int)$fines + (int)$company_fee + (int)$unloading_fee;
        $data['previous'] = $previous;
        $data['due_payments'] = (int)$due_payments - (int)$previous;
        $data['balance'] = $balance;
        if ($data['due_payments'] < 0) {
            $data['due_payments'] = 0;
        }
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicles(Request $request, $id)
    {
        if ($id == '0') {
            return json_encode(["success"=>false, "vehicles"=>array()]);
        }
        $data = AssignVehicle::with('vehicle');
        if (!empty($request->search)) {
            $search = $request->search;
            $data = $data->whereHas('vehicle', function ($query) use ($search) {
                $query->where('vin', 'LIKE', '%'.$search.'%')
                    ->orWhere('company_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('modal', 'LIKE', '%'.$search.'%');
            });
        }
        $data = $data->where("user_id", $id)->where("assigned_to", "0")->get();
        return json_encode(["success"=>true, "vehicles" => $data]);
    }

    public function send_to_buyer($id)
    {
        $vehicle = Vehicle::with('vehicle_images', 'vehicle_documents', 'buyer')->where('id', $id)->first();

        if (!empty(@$vehicle->buyer_id)) {
            \Mail::to(@$vehicle->buyer->email)->send(new \App\Mail\SendVehicle($vehicle));
        } else {
            return json_encode(["success"=>false, "msg" => "Please assign any buyer to this vehicle!"]);
        }
        return json_encode(["success"=>true, "msg" => "Sended to buyer successfully!"]);
    }

    public function send_to_cont_buyer($id)
    {
        $vehicle = ContainerVehicle::with('user', 'vehicle', 'vehicle.buyer', 'vehicle.vehicle_images', 'vehicle.vehicle_documents')->where('container_id', $id)->get();

        if (count($vehicle) > 0) {
            foreach ($vehicle as $key => $value) {
                \Mail::to(@$value->user->email)->send(new \App\Mail\SendVehicle($value->vehicle));
            }
        } else {
            return json_encode(["success"=>false, "msg" => "Please add any buyer to this container!"]);
        }
            
        return json_encode(["success"=>true, "msg" => "Sended to buyers successfully!"]);
    }

    public function send_reminder(Request $request)
    {
        $vehicle_id = $request->vehicle_id;
        $buyer_id = $request->buyer_id;
        $template_id = $request->template_id;

        $vehicle = Vehicle::with('destination_port', 'buyer')->where('id', $vehicle_id)->first();
        $template = ReminderTemplate::where("id", $template_id)->first();

        $template_name = $template->name;
        if (str_contains($template_name, "{vin}")) { 
            $template_name = str_replace("{vin}", @$vehicle->vin, $template_name);
        }
        if (str_contains($template_name, "{destination_port}")) { 
            $template_name = str_replace("{destination_port}", @$vehicle->destination_port->name, $template_name);
        }
        if (str_contains($template_name, "{description}")) { 
            $template_name = str_replace("{description}", @$vehicle->modal." ".@$vehicle->company_name." ".@$vehicle->name, $template_name);
        }
        if (str_contains($template_name, "{vehicle_name}")) { 
            $template_name = str_replace("{vehicle_name}", @$vehicle->modal." ".@$vehicle->company_name." ".@$vehicle->name, $template_name);
        }
        if (str_contains($template_name, "{lotnumber}")) { 
            $template_name = str_replace("{lotnumber}", @$vehicle->lotnumber, $template_name);
        }
        if (str_contains($template_name, "{buyer}")) { 
            $template_name = str_replace("{buyer}", @$vehicle->buyer->name, $template_name);
        }
        if (str_contains($template_name, "{auction_price}")) { 
            $template_name = str_replace("{auction_price}", @$vehicle->auction_price, $template_name);
        }
        if (str_contains($template_name, "{towing_price}")) { 
            $template_name = str_replace("{towing_price}", @$vehicle->towing_price, $template_name);
        }
        if (str_contains($template_name, "{occean_freight}")) { 
            $template_name = str_replace("{occean_freight}", @$vehicle->occean_freight, $template_name);
        }
        if (str_contains($template_name, "{delivery_date}")) { 
            $template_name = str_replace("{delivery_date}", @$vehicle->delivery_date, $template_name);
        }
        if (str_contains($template_name, "{purchase_date}")) { 
            $template_name = str_replace("{purchase_date}", @$vehicle->purchase_date, $template_name);
        }
        if (str_contains($template_name, "{pay_date}")) { 
            $template_name = str_replace("{pay_date}", @$vehicle->pay_date, $template_name);
        }
        if (str_contains($template_name, "{due_date}")) { 
            $template_name = str_replace("{due_date}", @$vehicle->due_date, $template_name);
        }
        if (str_contains($template_name, "{weight}")) { 
            $template_name = str_replace("{weight}", @$vehicle->weight, $template_name);
        }
        if (str_contains($template_name, "{pickup_date}")) { 
            $template_name = str_replace("{pickup_date}", @$vehicle->pickup_date, $template_name);
        }
        if (str_contains($template_name, "{assigned_by}")) { 
            $template_name = str_replace("{assigned_by}", @$vehicle->assigned_by, $template_name);
        }
        if (str_contains($template_name, "{fuel_type}")) { 
            $template_name = str_replace("{fuel_type}", @$vehicle->fuel_type, $template_name);
        }
        if (str_contains($template_name, "{keys}")) { 
            $template_name = str_replace("{keys}", @$vehicle->keys, $template_name);
        }
        if (str_contains($template_name, "{title}")) { 
            $template_name = str_replace("{title}", @$vehicle->title, $template_name);
        }
        if (str_contains($template_name, "{operable}")) { 
            $template_name = str_replace("{operable}", @$vehicle->operable, $template_name);
        }

        $template_content = $template->content;
        if (str_contains($template_content, "{vin}")) { 
            $template_content = str_replace("{vin}", @$vehicle->vin, $template_content);
        }
        if (str_contains($template_content, "{destination_port}")) { 
            $template_content = str_replace("{destination_port}", @$vehicle->destination_port->name, $template_content);
        }
        if (str_contains($template_content, "{description}")) { 
            $template_content = str_replace("{description}", @$vehicle->modal." ".@$vehicle->company_name." ".@$vehicle->name, $template_content);
        }
        if (str_contains($template_content, "{vehicle_name}")) { 
            $template_content = str_replace("{vehicle_name}", @$vehicle->modal." ".@$vehicle->company_name." ".@$vehicle->name, $template_content);
        }
        if (str_contains($template_content, "{lotnumber}")) { 
            $template_content = str_replace("{lotnumber}", @$vehicle->lotnumber, $template_content);
        }
        if (str_contains($template_content, "{buyer}")) { 
            $template_content = str_replace("{buyer}", @$vehicle->buyer->name, $template_content);
        }
        if (str_contains($template_content, "{auction_price}")) { 
            $template_content = str_replace("{auction_price}", @$vehicle->auction_price, $template_content);
        }
        if (str_contains($template_content, "{towing_price}")) { 
            $template_content = str_replace("{towing_price}", @$vehicle->towing_price, $template_content);
        }
        if (str_contains($template_content, "{occean_freight}")) { 
            $template_content = str_replace("{occean_freight}", @$vehicle->occean_freight, $template_content);
        }
        if (str_contains($template_content, "{delivery_date}")) { 
            $template_content = str_replace("{delivery_date}", @$vehicle->delivery_date, $template_content);
        }
        if (str_contains($template_content, "{purchase_date}")) { 
            $template_content = str_replace("{purchase_date}", @$vehicle->purchase_date, $template_content);
        }
        if (str_contains($template_content, "{pay_date}")) { 
            $template_content = str_replace("{pay_date}", @$vehicle->pay_date, $template_content);
        }
        if (str_contains($template_content, "{due_date}")) { 
            $template_content = str_replace("{due_date}", @$vehicle->due_date, $template_content);
        }
        if (str_contains($template_content, "{weight}")) { 
            $template_content = str_replace("{weight}", @$vehicle->weight, $template_content);
        }
        if (str_contains($template_content, "{pickup_date}")) { 
            $template_content = str_replace("{pickup_date}", @$vehicle->pickup_date, $template_content);
        }
        if (str_contains($template_content, "{assigned_by}")) { 
            $template_content = str_replace("{assigned_by}", @$vehicle->assigned_by, $template_content);
        }
        if (str_contains($template_content, "{fuel_type}")) { 
            $template_content = str_replace("{fuel_type}", @$vehicle->fuel_type, $template_content);
        }
        if (str_contains($template_content, "{keys}")) { 
            $template_content = str_replace("{keys}", @$vehicle->keys, $template_content);
        }
        if (str_contains($template_content, "{title}")) { 
            $template_content = str_replace("{title}", @$vehicle->title, $template_content);
        }
        if (str_contains($template_content, "{operable}")) { 
            $template_content = str_replace("{operable}", @$vehicle->operable, $template_content);
        }

        $template->name = $template_name;
        $template->content = $template_content;

        if (!empty(@$vehicle->buyer_id)) {
            $reminder_history = new ReminderHistory;
            $reminder_history->vehicle_id = $vehicle_id;
            $reminder_history->buyer_id = $buyer_id;
            $reminder_history->template_id = $template_id;
            $reminder_history->save();

            \Mail::to(@$vehicle->buyer->email)->send(new \App\Mail\SendReminder($template));
        } else {
            return json_encode(["success"=>false, "msg" => "Please assign any buyer to this vehicle!"]);
        }
        return json_encode(["success"=>true, "msg" => "Reminder sent successfully!"]);
    }

    public function assign_vehicle(Request $request)
    {
        $vehicle_id = explode(",", $request->vehicle_id);
        $container_id = $request->container_id;
        $user_id = $request->user_id;
        $flag = 0;

        foreach ($vehicle_id as $key => $value) {
            $vehicle = Vehicle::where("id", $value)->first();
            $container = Container::where("id", $container_id)->first();
            if ($vehicle->destination_port_id !== $container->destination_port_id) {
                return json_encode(["success"=>false, "msg" => "Destination port is not same for the vehicle with this vin: ".$vehicle->vin]);
            } else if ($vehicle->title == "NO") {
                return json_encode(["success"=>false, "msg" => 'Title is "NO" for the vehicle with this vin: '.$vehicle->vin]);
            }
        }

        $all_vehicle = ContainerVehicle::with("vehicle")->where("container_id", $container_id)->get();
        
        foreach ($vehicle_id as $key => $value) {
            $vehicle = Vehicle::where("id", $value)->first();
            foreach ($all_vehicle as $k => $v) {
                if (@$v->vehicle->fuel_type !== @$vehicle->fuel_type) {
                    $flag++;
                }
            }
            $save = new ContainerVehicle;
            $save->container_id = $container_id;
            $save->user_id = $user_id;
            $save->vehicle_id = $value;
            $save->added_by = "admin";
            $save->save();
            AssignVehicle::where("vehicle_id", $value)->where('user_id', $user_id)->update(["assigned_to"=>$container_id]);
            $container = Container::where("id", $container_id)->first();
            if (!empty($container) && !str_contains(@$container->buyers, "-".$user_id."-")) {
                if (!empty($container->buyers)) {
                    $buyers = $container->buyers.", -".$user_id."-";
                } else {
                    $buyers = "-".$user_id."-";
                }
                Container::where("id", $container_id)->update(["buyers" => $buyers]);
            }

            if ($user_id !== "1") {
                $fcm_token = User::where("id", $user_id)->first()->fcm_token;
                if (!empty($fcm_token)) {
                    $data = Container::where("id", $container_id)->first();
                    $this->send_noti($fcm_token, "added-to-container", $data);
                }
            }
        }

        if ($flag == "0") {
            return json_encode(["success"=>true, "action" => 'reload']);
        } else {
            return json_encode(["success"=>true, "msg" => 'You are mixing up vehicles in this container. Before the vehicles that are in this container have different fuel type.']);
        }
    }

    public function send_noti($fcm_token, $type, $inside_data)
    {
        $request_body = (object)[];
        if ($type == "add-vehicle") {
            $notification = (object)[];
            $notification->title = "K&G Auto Export";
            $notification->body = "New vehicle is added!";
            $notification->image = "http://kgautoexport.co/public/assets/logo.png";

            $data = (object)[];
            $data->message = "New vehicle is added!";
            $data->type = "add-vehicle";
            $data->all_data = $inside_data;
        } else if ($type == "added-to-container") {
            $notification = (object)[];
            $notification->title = "K&G Auto Export";
            $notification->body = "Vehicle is added to the container!";
            $notification->image = "http://kgautoexport.co/public/assets/logo.png";

            $data = (object)[];
            $data->message = "Vehicle status is changed";
            $data->type = "added-to-container";
            $data->all_data = $inside_data;
        } else if ($type == "status-changed") {
            $notification = (object)[];
            $notification->title = "K&G Auto Export";
            $notification->body = "Vehicle status is changed!";
            $notification->image = "http://kgautoexport.co/public/assets/logo.png";

            $data = (object)[];
            $data->message = "Vehicle status is changed";
            $data->type = "status-changed";
            $data->all_data = $inside_data;
        } else if ($type == "pickup-status-changed") {
            $notification = (object)[];
            $notification->title = "K&G Auto Export";
            $notification->body = "Pickup request status is updated!";
            $notification->image = "http://kgautoexport.co/public/assets/logo.png";

            $data = (object)[];
            $data->message = "Pickup request status is updated";
            $data->type = "pickup-status-changed";
            $data->all_data = $inside_data;
        }
        $request_body->notification = $notification;
        $request_body->priority = "high";
        $request_body->to = $fcm_token;
        $request_body->data = $data;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request_body),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: key=AAAAntu-774:APA91bHqe9UJ3pzJp3dtm7Tpqlmh0F7UwpzVK_An3JFA61khikFm9EwBOl4j9cPC7lzVxwr7dY6LL-SH2xA1DfpCzplQpBYmMIBLXkg7CTKwoXptjutN_Yo4UPA9kwDxRwiwI2tDiNZu'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
    }

    public function cleanData(&$data) {
        $unset = ['q','_token','c_id'];
        foreach ($unset as $value) {
            if(array_key_exists ($value,$data))  {
                unset($data[$value]);
            }
        }
        $int = ['Price','pur_price'];
        foreach ($int as $value) {
            if(array_key_exists ($value,$data))  {
                $data[$value] = (int)str_replace(['(','Rs',')',' ','-','_',','], '', $data[$value]);
            }

        }
        $phone = ['phone'];
        foreach ($phone as $value) {
            if(is_array($data) && array_key_exists($value,$data))  {
                $data[$value] = str_replace(['(',')',' ','-','_','+'], '', $data[$value]);
            }
            if(@$data->$value) {
                $data->$value = str_replace(['(',')',' ','-','_','+'], '', $data->$value);
            }
        }
    }
}
