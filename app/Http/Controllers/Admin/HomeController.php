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
use Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['type'] = "vehicles";
        $data['page'] = '1';
        $vehicles = Vehicle::orderBy('id', 'DESC')->with('vehicle_images', 'auction', 'terminal', 'status', 'buyer');
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
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Storage::putFile("container", $file);
                $data['image'] = $filename;
            }
            $this->cleanData($data);
            $data['owner_id'] = Auth::user()->id;
            $data['request_type'] = '2';
            $data['date_created'] = time();
            $data['search_body'] = "Booked K&G Auto Export Inc MSC REBOU AL SHARQ USED CARS TR.LLC HOUSTON TX JEBEL ALI,UAE JEBEL ALI,UAE EBKG05951642 00/00/0000 07/02/2023 00/00/0000 GA- 45'HC 00/00/0000 06/16/2023 SAME AS CONSIGNEE telex";
            $Obj = new Container;
            $Obj->insert($data);
            $response = array('flag'=>true,'msg'=>'Container is added sucessfully.','action'=>'reload');
            echo json_encode($response); return;
        }
        $data   = array();
        $data['type'] = 'add-container';
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
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Storage::putFile("container", $file);
                $data['image'] = $filename;
            }
            $this->cleanData($data);
            $data['owner_id'] = Auth::user()->id;
            $data['request_type'] = '2';
            $data['date_created'] = time();
            $data['search_body'] = "Booked K&G Auto Export Inc MSC REBOU AL SHARQ USED CARS TR.LLC HOUSTON TX JEBEL ALI,UAE JEBEL ALI,UAE EBKG05951642 00/00/0000 07/02/2023 00/00/0000 GA- 45'HC 00/00/0000 06/16/2023 SAME AS CONSIGNEE telex";
            $Obj = new Container;
            $Obj->insert($data);
            $response = array('flag'=>true,'msg'=>'Container is added sucessfully.','action'=>'reload');
            echo json_encode($response); return;
        }
        $data   = array();
        $data['type'] = 'add-vehicle';
        $data['all_status'] = Status::all();
        $data['all_terminal'] = Terminal::all();
        $data['all_buyer'] = User::where('role', '!=', '1')->get();
        $data['all_auction'] = Auction::all();
        $data['all_destination_port'] = DestinationPort::all();
        return view('admin.add-vehicle', $data);
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
