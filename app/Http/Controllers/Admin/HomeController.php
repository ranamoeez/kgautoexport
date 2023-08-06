<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Status;
use App\Models\Terminal;
use App\Models\Container;
use App\Models\ContStatus;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['type'] = "vehicles";
        $data['page'] = '1';
        $vehicles = Vehicle::orderBy('id', 'DESC')->with('vehicle_images', 'auction', 'terminal', 'status');
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
        }
        $vehicles = $vehicles->limit(20)->get();
        $data['list'] = $vehicles;
        $data['all_terminal'] = Terminal::all();
        $data['all_status'] = Status::all();
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
        if (!empty($request->unpaid)) {
        	$data['unpaid'] = $request->unpaid;
        }
        $containers = $containers->limit(20)->get();
        $data['list'] = $containers;
        $data['all_status'] = ContStatus::all();
        return view('admin.containers', $data);
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
}
