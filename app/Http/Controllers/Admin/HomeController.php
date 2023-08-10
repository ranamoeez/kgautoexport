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
use Auth;
use Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['type'] = "vehicles";
        $data['page'] = '1';
        $vehicles = Vehicle::orderBy('id', 'DESC')->with('vehicle_images', 'vehicle_documents', 'auction', 'terminal', 'status', 'buyer');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 20;
                $vehicles = $vehicles->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        if (!empty($request->terminal) && $request->terminal !== 'all') {
        	$data['terminal'] = $request->terminal;
        	$vehicles = $vehicles->where('terminal_id', $request->terminal);
        }
        if (!empty($request->status) && $request->status !== 'all') {
        	$data['status'] = $request->status;
        	$vehicles = $vehicles->where('status_id', $request->status);
        }
        if (!empty($request->destination) && $request->destination !== 'all') {
        	$data['destination'] = $request->destination;
        	$vehicles = $vehicles->where('destination_manual', $request->destination);
        }
        if (!empty($request->buyer) && $request->buyer !== 'all') {
        	$data['buyer'] = $request->buyer;
        	$vehicles = $vehicles->where('buyer_id', $request->buyer);
        }
        if (!empty($request->search)) {
        	$data['search'] = $request->search;
        	$search = $request->search;
        	$vehicles = $vehicles->where(function ($query) use ($search) {
			    $query->where('delivery_date', 'LIKE', '%'.$search.'%')
			        ->orWhere('description', 'LIKE', '%'.$search.'%')
			        ->orWhere('vin', 'LIKE', '%'.$search.'%')
			        ->orWhere('client_name', 'LIKE', '%'.$search.'%')
			        ->orWhere('destination_manual', 'LIKE', '%'.$search.'%')
			        ->orWhere('notes', 'LIKE', '%'.$search.'%');
			});
        }
        if (!empty($request->unpaid)) {
        	$data['unpaid'] = $request->unpaid;
        	$vehicles = $vehicles->where('all_paid', '0');
        }
        $vehicles = $vehicles->limit(20)->get();
        $data['list'] = $vehicles;
        $data['all_terminal'] = Terminal::all();
        $data['all_status'] = Status::all();
        $data['all_buyer'] = User::where('role', '!=', '1')->get();
        return view('admin.vehicles', $data);
    }

    public function containers(Request $request)
    {
        $data['type'] = "containers";
        $data['page'] = '1';
        $containers = Container::orderBy('id', 'DESC')->with('container_images', 'status', 'shipper', 'shipping_line', 'consignee', 'pre_carriage', 'loading_port', 'discharge_port', 'destination_port', 'notify_party', 'pier_terminal', 'measurement');
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
        if (!empty($request->unpaid)) {
        	$data['unpaid'] = $request->unpaid;
        	$containers = $containers->where('all_paid', '0');
        }
        $containers = $containers->limit(20)->get();
        $data['list'] = $containers;
        $data['all_port'] = LoadingPort::all();
        $data['all_status'] = ContStatus::all();
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
            $data['search_body'] = "Booked K&G Auto Export Inc MSC REBOU AL SHARQ USED CARS TR.LLC HOUSTON TX JEBEL ALI,UAE JEBEL ALI,UAE EBKG05951642 00/00/0000 07/02/2023 00/00/0000 GA- 45'HC 00/00/0000 06/16/2023 SAME AS CONSIGNEE telex";
            $container = Container::create($data);
            if ($request->hasFile('documents')) {
                $files = [];
                foreach ($request->file('documents') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('container', $file);
                    
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
            $response = array('flag'=>true,'msg'=>'Container is added sucessfully.','action'=>'reload');
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'add-container';
        $data['action'] = url('admin/add-container');
        $data['all_shipper'] = Shipper::all();
        $data['all_shipping_line'] = ShippingLine::all();
        $data['all_loading_port'] = LoadingPort::all();
        $data['all_consignee'] = Consignee::all();
        $data['all_destination_port'] = DestinationPort::all();
        $data['all_status'] = ContStatus::all();
        $data['all_notify_party'] = NotifyParty::all();
        $data['all_measurement'] = Measurement::all();
        $data['all_discharge_port'] = DischargePort::all();
        return view('admin.add-container', $data);
    }

    public function add_vehicle(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $this->cleanData($data);
            $data['description'] = $data['model'].' '.$data['company'].' '.$data['name'];
            $data['owner_id'] = Auth::user()->id;
            $vehicle = Vehicle::create($data);
            if ($request->hasFile('images')) {
                $files = [];
                foreach ($request->file('images') as $key => $value) {
                    $file = $value;
                    $filename = Storage::putFile('vehicle/images', $file);
                    
                    $image = new VehicleImage;
                    $image->vehicle_id = $vehicle->id;
                    $image->filesize = $value->getSize();
                    $image->owner_id = Auth::user()->id;
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
                    $filename = Storage::putFile('vehicle/documents', $file);
                    
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
            $response = array('flag'=>true,'msg'=>'Vehicle is added sucessfully.','action'=>'reload');
            return json_encode($response);
        }
        $data   = array();
        $data['type'] = 'add-vehicle';
        $data['action'] = url('admin/add-vehicle');
        $data['all_status'] = Status::all();
        $data['all_terminal'] = Terminal::all();
        $data['all_buyer'] = User::where('role', '!=', '1')->get();
        $data['all_auction'] = Auction::all();
        $data['all_auction_location'] = AuctionLocation::all();
        $data['all_destination_port'] = DestinationPort::all();
        return view('admin.add-vehicle', $data);
    }

    // public function vehicle_images(Request $request)
    // {
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $filename = Storage::putFile("vehicle", $file);

    //     	return json_encode(['success'=>true, "data"=>$filename]);
    //     }
    //     return json_encode(['success'=>false]);
    // }

    public function get_auction_location($id)
    {
    	$data = AuctionLocation::where("auction_id", $id)->get();
    	return json_encode(["success"=>true, "data" => $data]);
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
    	if (!empty($request->payment_status)) {
    		$data["all_paid"] = $request->payment_status;
    	}
    	Vehicle::where('id', $request->id)->update($data);
    	return json_encode(["success"=>true]);
    }

    public function delete_vehicles($id)
    {
    	$vehicle = Vehicle::find($id);
        $vehicle->delete();
        $response = array('flag'=>true,'msg'=>'Vehicle has been deleted.');
        echo json_encode($response); return;
    }

    public function delete_containers($id)
    {
    	$container = Container::find($id);
        $container->delete();
        $response = array('flag'=>true,'msg'=>'Container has been deleted.');
        echo json_encode($response); return;
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
