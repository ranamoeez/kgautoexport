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
use Auth;
use Storage;

class HomeController extends Controller
{
    // Vehicle Functions

    public function vehicles(Request $request)
    {
        $data['type'] = "vehicles";
        $data['page'] = '1';
        $filter = [];
        $vehicles = AssignVehicle::orderBy('id', 'DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas('vehicle');
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
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || $request->pay_status == "0") {
        	$data['pay_status'] = $request->pay_status;
            $filter['pay_status'] = $request->pay_status;
        }
        if (!empty($filter)) {
            $vehicles = AssignVehicle::orderBy('id', 'DESC')->with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas('vehicle', function ($query) use($filter) {
                if (!empty($filter['terminal'])) {
                    $query->where('terminal_id', $filter['terminal']);
                }
                if (!empty($filter['status'])) {
                    $query->where('status_id', $filter['status']);
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
                if (!empty($filter['pay_status']) || @$filter['pay_status'] == "0") {
                    $query->where('all_paid', $filter['pay_status']);
                }
            });
        }
        if (!empty($request->buyer) && $request->buyer !== 'all') {
            $vehicles = $vehicles->where('user_id', $request->buyer);
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 20;
                $vehicles = $vehicles->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $vehicles = $vehicles->limit(20)->get();
        $data['list'] = $vehicles;
        $data['all_terminal'] = Terminal::all();
        $data['all_status'] = Status::all();
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_destination_port'] = DestinationPort::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        return view('admin.vehicles', $data);
    }

    public function add_vehicle(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $this->cleanData($data);
            $data['owner_id'] = \Auth::user()->id;
            if (\Auth::user()->id == "1") {
                $role = "super_admin";
            } else {
                $role = "admin";
            }
            $data['assigned_by'] = $role;
            if (empty($data['purchase_date'])) {
                $data['purchase_date'] = date('Y-m-d');
            }
            $vehicle = Vehicle::create($data);
            $assign = new AssignVehicle;
            $assign->user_id = $data['buyer_id'];
            $assign->vehicle_id = $vehicle->id;
            $assign->save();
            $transaction_history = new TransactionsHistory;
            $transaction_history->user_id = $data['buyer_id'];
            $transaction_history->amount = '0';
            $transaction_history->vehicle_id = $vehicle->id;
            $transaction_history->type = 'init';
            $transaction_history->status = 'unpaid';
            $transaction_history->save();
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('vehicle/images/'.$vehicle->id, $file);
                    
                    $image = new VehicleImage;
                    $image->vehicle_id = $vehicle->id;
                    $image->filesize = $value->getSize();
                    $image->owner_id = $data['buyer_id'];
                    $image->title = '';
                    $image->filename = $filename;
                    $image->filepath = 'storage/app/';
                    $image->type = 'warehouse';
                    $image->save();
                }
            }
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('vehicle/documents/'.$vehicle->id, $file);
                    
                    $image = new VehicleDocuments;
                    $image->vehicle_id = $vehicle->id;
                    $image->filesize = $value->getSize();
                    $image->filename = $filename;
                    $image->filepath = 'storage/app/';
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
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        return view('admin.add-vehicle', $data);
    }

    public function edit_vehicle(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $buyer = AssignVehicle::where('id', $id)->first()->user_id;
            if ($data['buyer_id'] !== $buyer) {
                AssignVehicle::where('id', $id)->update(["user_id" => $data['buyer_id']]);
                $vehicle_id = AssignVehicle::where('id', $id)->first()->vehicle_id;
                if (\Auth::user()->id == "1") {
                    $role = "super_admin";
                } else {
                    $role = "admin";
                }
                Vehicle::where('id', $vehicle_id)->update(["assigned_by" => $role]);
            }
            $id = AssignVehicle::where('id', $id)->first()->vehicle_id;
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('vehicle/images/'.$id, $file);
                    
                    $image = new VehicleImage;
                    $image->vehicle_id = $id;
                    $image->filesize = $value->getSize();
                    $image->owner_id = $data['buyer_id'];
                    $image->title = '';
                    $image->filename = $filename;
                    $image->filepath = 'storage/app/';
                    $image->type = 'warehouse';
                    $image->save();
                }
            }
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('vehicle/documents/'.$id, $file);
                    
                    $image = new VehicleDocuments;
                    $image->vehicle_id = $id;
                    $image->filesize = $value->getSize();
                    $image->filename = $filename;
                    $image->filepath = 'storage/app/';
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
            unset($data['documents']);
            unset($data['images']);
            unset($data['trans_type']);
            unset($data['trans_fine']);
            unset($data['auction_type']);
            unset($data['auction_fine']);
            unset($data['expense_type']);
            unset($data['expense_fine']);
            $vehicle = Vehicle::where('id', $id)->update($data);
            $response = array('success'=>true,'msg'=>'Vehicle is updated sucessfully.','action'=>'reload');
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'vehicles';
        $data['action'] = url('admin/vehicles/edit/'.$id);
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
        $data['templates'] = ReminderTemplate::all();
        $vid = AssignVehicle::where('id', $id)->first()->vehicle_id;
        $data['history'] = ReminderHistory::where('vehicle_id', $vid)->get();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
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

    public function containers(Request $request)
    {
        $data['type'] = "containers";
        $data['page'] = '1';
        $containers = Container::orderBy('id', 'DESC')->with('container_documents', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 20;
                $containers = $containers->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        if (!empty($request->port) && $request->port !== 'all') {
        	$data['port'] = $request->port;
        	$containers = $containers->where('loading_port_id', $request->port);
        }
        if (!empty($request->status) && $request->status !== 'all') {
        	$data['status'] = $request->status;
        	$containers = $containers->where('status_id', $request->status);
        }
        if (!empty($request->search)) {
        	$data['search'] = $request->search;
        	$search = $request->search;
        	$containers = $containers->where(function ($query) use ($search) {
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
        	$containers = $containers->where('arrival', '<=', $request->toDate)->where('arrival', '>=', $request->fromDate);
        } elseif(!empty($request->fromDate)) {
        	$data['fromDate'] = $request->fromDate;
        	$containers = $containers->where('arrival', '>=', $request->fromDate);
        } elseif(!empty($request->toDate)) {
        	$data['toDate'] = $request->toDate;
        	$containers = $containers->where('arrival', '<=', $request->toDate);
        }
        if ((!empty($request->pay_status) && $request->pay_status !== 'all') || @$request->pay_status == '0') {
        	$data['pay_status'] = $request->pay_status;
        	$containers = $containers->where('all_paid', $request->pay_status);
        }
        $containers = $containers->limit(20)->get();
        foreach ($containers as $key => $value) {
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
            $containers[$key]->buyers = $buyers;
        }
        $data['list'] = $containers;
        $data['all_port'] = LoadingPort::all();
        $data['all_status'] = ContStatus::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        return view('admin.containers', $data);
    }

    public function add_container(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $this->cleanData($data);
            $data['owner_id'] = Auth::user()->id;
            $data['request_type'] = '2';
            $data['date_created'] = time();
            if (!empty($data['container_no'])) {
                $check = Container::where("container_no", $data['container_no'])->count();
                if ($check > 0) {
                    $response = array('success'=>false,'msg'=>'Container number already exists!','action'=>'reload');
                    return json_encode($response);
                }
            }
            $container = Container::create($data);
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('container/'.$container->id, $file);
                    
                    $image = new ContainerImage;
                    $image->container_id = $container->id;
                    $image->filesize = $value->getSize();
                    $image->title = '';
                    $image->owner_id = Auth::user()->id;
                    $image->filename = $filename;
                    $image->filepath = 'storage/app/';
                    $image->save();
                }
            }
            $response = array('success'=>true,'msg'=>'Container is added sucessfully.','action'=>'reload','url'=>url('/admin/containers/edit', $container->id));
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'add-container';
        $data['action'] = url('admin/containers/add');
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
        return view('admin.add-container', $data);
    }

    public function edit_container(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('container/'.$id, $file);
                    
                    $image = new ContainerImage;
                    $image->container_id = $id;
                    $image->filesize = $value->getSize();
                    $image->title = '';
                    $image->owner_id = Auth::user()->id;
                    $image->filename = $filename;
                    $image->filepath = 'storage/app/';
                    $image->save();
                }
            }
            $this->cleanData($data);
            unset($data['documents']);
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
        return view('admin.edit-container', $data);
    }

    public function delete_containers($id)
    {
        $container = Container::find($id);
        $container->delete();
        $response = array('success'=>true,'msg'=>'Container has been deleted.');
        echo json_encode($response); return;
    }

    public function financial_system(Request $request)
    {
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
        if (!empty($request->status) && $request->status !== 'all') {
            $data['status'] = $request->status;
            $status = $request->status;
            $filter['status'] = $status;
        }
        $transaction_history = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer');
        if (!empty($filter)) {
            $transaction_history = TransactionsHistory::orderBy('id', 'DESC')->with('vehicle', 'vehicle.buyer')->whereHas('vehicle', function ($query) use($filter) {
                if (!empty($filter['vin'])) {
                    $query->where('vin', $filter['vin']);
                }
                if (!empty($filter['buyer'])) {
                    $query->where('buyer_id', $filter['buyer']);
                }
                if (!empty($filter['status'])) {
                    $query->where('status', $filter['status']);
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
        $transaction_history = $transaction_history->limit(10)->get();
        $data['transaction_history'] = $transaction_history;
        $auction_price = \DB::table('vehicles');
        if (!empty($filter['vin'])) {
            $auction_price = $auction_price->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $auction_price = $auction_price->where('buyer_id', $filter['buyer']);
        }
        $auction_price = $auction_price->sum('auction_price');
        $towing_price = \DB::table('vehicles');
        if (!empty($filter['vin'])) {
            $towing_price = $towing_price->where('vin', $filter['vin']);
        }
        if (!empty($filter['buyer'])) {
            $towing_price = $towing_price->where('buyer_id', $filter['buyer']);
        }
        $towing_price = $towing_price->sum('towing_price');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines");
        if (!empty($filter['vin'])) {
            $all_data = $all_data->where('vin', $filter['vin']);
        }
        if (!empty(@$filter['buyer'])) {
            $all_data = $all_data->where('buyer_id', $filter['buyer']);
        }
        $balance = new User;
        if (!empty($filter['vin'])) {
            $v = Vehicle::where("vin", $filter['vin'])->first();
            $balance = $balance->where('id', $v);
        }
        if (!empty(@$filter['buyer'])) {
            $balance = $balance->where('id', $filter['buyer']);
        }
        $balance = $balance->sum('balance');
        if (empty($filter)) {
            $all_data = $all_data->offset(35000)->limit(20000)->get();
        } else {
            $all_data = $all_data->limit(20000)->get();
        }
        $fines = 0;
        $company_fee = 0;
        $unloading_fee = 0;
        foreach ($all_data as $key => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $k => $val) {
                    $fines += (int)$val->amount;
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
        $data['previous'] = $previous;
        $data['due_payments'] = (int)$due_payments - (int)$previous;
        $data['balance'] = $balance;
        if ($data['due_payments'] < 0) {
            $data['due_payments'] = 0;
        }
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        return view('admin.financial-system', $data);
    }

    public function transaction_history(Request $request)
    {
        $data = $request->all();
        $user = User::where("id", $data['user_id'])->first();
        if (!empty($user)) {
            if ($user->balance !== 0) {
                $pre_balance = $user->balance;
                $balance = (int)$pre_balance - (int)$data['amount'];
                User::where("id", $data['user_id'])->update(["balance" => $balance]);
            } else {
                return json_encode(["success"=>false, 'msg'=>'Buyer have low balance!']);
            }
        }
        TransactionsHistory::create($data);

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
        $user_notes = $request->user_notes;
        $admin_notes = $request->admin_notes;
        $vehicle_id = $request->vehicle_id;

        Vehicle::where("id", $vehicle_id)->update(["notes" => $admin_notes, "notes_user" => $user_notes]);

        return json_encode(["success"=>true, 'msg'=>'Comment is updated successfully!', 'action'=>'reload']);
    }

    public function pickup_history(Request $request)
    {
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
            $auction_price = \DB::table('vehicles')->where('buyer_id', $buyer_id)->sum('auction_price');
            $towing_price = \DB::table('vehicles')->where('buyer_id', $buyer_id)->sum('towing_price');
            $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', $buyer_id)->limit(20000)->get();
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
            $due_payments = (int)$auction_price + (int)$towing_price + (int)$fines + (int)$company_fee + (int)$unloading_fee;
            $all_due_payments = (int)$due_payments - (int)$previous;
            if ($all_due_payments < 0) {
                $all_due_payments = 0;
            }
            $pickup[$key]->due_payments = $all_due_payments;
            $pickup[$key]->balance = $balance;
        }
        $data['list'] = $pickup;
        $data['all_buyer'] = User::where('role', '2')->get();
        $data['all_destination_port'] = DestinationPort::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        return view('admin.pickup-history', $data);
    }

    public function update_vehicle_data(Request $request)
    {
    	$data = [];
    	if (!empty($request->status)) {
    		$data["status_id"] = $request->status;
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
        }
        if (!empty($request->payment_status) || $request->payment_status == '0') {
            $data["all_paid"] = $request->payment_status;
        }
        Container::where('id', $request->id)->update($data);
        return json_encode(["success"=>true, 'action'=>'reload']);
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
        return json_encode(["success"=>true, 'action'=>'reload']);
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
        return json_encode(["success"=>true, 'action'=>'reload']);
    }

    public function delete_buyer_vehicle($c_id, $u_id, $v_id)
    {
        AssignVehicle::where('user_id', $u_id)->where('vehicle_id', $v_id)->where('assigned_to', $c_id)->update(['assigned_to'=>'0']);
        $vehicle = ContainerVehicle::where('container_id', $c_id)->where('user_id', $u_id)->where('vehicle_id', $v_id);
        $vehicle->delete();
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
        $vehicle = Vehicle::with('buyer', 'buyer.user_level', 'fines', 'destination_port')->where("id", $id)->first();
        $data['auction_price'] = Vehicle::where("id", $id)->sum('auction_price');
        $data['towing_price'] = Vehicle::where("id", $id)->sum('towing_price');
        $data['fines'] = $vehicle->fines;
        $data['total_auction_fines'] = Fine::where('vehicle_id', $id)->where('type', 'auction')->sum('amount');
        $data['total_trans_fines'] = Fine::where('vehicle_id', $id)->where('type', 'transaction')->sum('amount');
        $data['total_draft_expenses'] = Fine::where('vehicle_id', $id)->where('type', 'draft_expense')->sum('amount');
        $data['company_fee'] = @$vehicle->buyer->user_level->company_fee;
        $data['transaction_history'] = TransactionsHistory::where("vehicle_id", $id)->get();
        if (empty($data['company_fee'])) {
            $data['company_fee'] = '0';
        }
        $data['unloading_fee'] = @$vehicle->destination_port->unloading_fee;
        if (empty($data['unloading_fee'])) {
            $data['unloading_fee'] = '0';
        }
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_notes($id)
    {
        $vehicle = Vehicle::where("id", $id)->first();
        $data['admin_notes'] = $vehicle->notes;
        $data['user_notes'] = $vehicle->notes_user;
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicle_vin($id)
    {
        $data['data'] = Vehicle::where("buyer_id", $id)->get();

        $previous = TransactionsHistory::where("user_id", $id)->sum('amount');
        $auction_price = \DB::table('vehicles')->where('buyer_id', $id)->sum('auction_price');
        $towing_price = \DB::table('vehicles')->where('buyer_id', $id)->sum('towing_price');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', $id)->limit(20000)->get();
        $balance = User::where('id', $id)->sum('balance');
        if ($id == "0") {
            $previous = TransactionsHistory::all()->sum('amount');
            $auction_price = \DB::table('vehicles')->sum('auction_price');
            $towing_price = \DB::table('vehicles')->sum('towing_price');
            $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->offset(35000)->limit(20000)->get();
            $balance = User::all()->sum('balance');
            $data['data'] = Vehicle::limit(20000)->offset(35000)->get();
        }
        $fines = 0;
        $company_fee = 0;
        $unloading_fee = 0;
        foreach ($all_data as $key => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $k => $val) {
                    $fines += (int)$val->amount;
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
        $auction_price = \DB::table('vehicles')->where('id', $id)->sum('auction_price');
        $towing_price = \DB::table('vehicles')->where('id', $id)->sum('towing_price');
        $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('id', $id)->get();
        $balance = User::where('id', $buyer_id)->sum('balance');
        if ($id == "0") {
            $previous = TransactionsHistory::where("user_id", $buyer_id)->sum('amount');
            $auction_price = \DB::table('vehicles')->where('buyer_id', $buyer_id)->sum('auction_price');
            $towing_price = \DB::table('vehicles')->where('buyer_id', $buyer_id)->sum('towing_price');
            $all_data = Vehicle::with("buyer", "buyer.user_level", "destination_port", "fines")->where('buyer_id', $buyer_id)->limit(20000)->get();
            $balance = User::all()->sum('balance');
        }
        $fines = 0;
        $company_fee = 0;
        $unloading_fee = 0;
        foreach ($all_data as $key => $value) {
            if (!empty(@$value->fines)) {
                foreach (@$value->fines as $k => $val) {
                    $fines += (int)$val->amount;
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
        $data['previous'] = $previous;
        $data['due_payments'] = (int)$due_payments - (int)$previous;
        $data['balance'] = $balance;
        if ($data['due_payments'] < 0) {
            $data['due_payments'] = 0;
        }
        return json_encode(["success"=>true, "data" => $data]);
    }

    public function get_vehicles($id)
    {
        if ($id == '0') {
            return json_encode(["success"=>false, "vehicles"=>array()]);
        }
        $data = AssignVehicle::with('vehicle')->where("user_id", $id)->where("assigned_to", "0")->get();
        return json_encode(["success"=>true, "vehicles" => $data]);
    }

    public function send_to_buyer($id)
    {
        $vehicle = Vehicle::with('buyer')->where('id', $id)->first();

        if (!empty(@$vehicle->buyer_id)) {
            \Mail::to(@$vehicle->buyer->email)->send(new \App\Mail\SendVehicle($vehicle));
        } else {
            return json_encode(["success"=>false, "msg" => "Please assign any buyer to this vehicle!"]);
        }
        return json_encode(["success"=>true, "msg" => "Sended to buyer successfully!"]);
    }

    public function send_reminder(Request $request)
    {
        $vehicle_id = $request->vehicle_id;
        $buyer_id = $request->buyer_id;
        $template_id = $request->template_id;

        $vehicle = Vehicle::with('buyer')->where('id', $vehicle_id)->first();
        $template = ReminderTemplate::where("id", $template_id)->first();

        $template_name = explode("{vin}", $template->name);
        if (!empty($template_name[1]) || $template_name[1] == "") {
            $template_name = $template_name[0].$vehicle->vin.$template_name[1];
        } else {
            $template_name = $template->name;
        }

        $template_content = explode("{vin}", $template->content);
        if (!empty($template_content[1]) || $template_content[1] == "") {
            $template_content = $template_content[0].$vehicle->vin.$template_content[1];
        } else {
            $template_content = $template->content;
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

        foreach ($vehicle_id as $key => $value) {
            $save = new ContainerVehicle;
            $save->container_id = $container_id;
            $save->user_id = $user_id;
            $save->vehicle_id = $value;
            $save->save();
            AssignVehicle::where("vehicle_id", $value)->where('user_id', $user_id)->update(["assigned_to"=>$container_id]);
        }

        return json_encode(["success"=>true, "action" => 'reload']);
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
