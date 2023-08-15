<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\ContStatus;

class SystemConfigController extends Controller
{
    public function auto_status(Request $request)
    {
    	$data['type'] = "system-configuration";
    	$data['status'] = Status::all();
    	return view('admin.system-configuration.auto-status', $data);
    }

    public function container_status(Request $request)
    {
    	$data['type'] = "system-configuration";
    	$data['status'] = ContStatus::all();
    	return view('admin.system-configuration.container-status', $data);
    }
}
