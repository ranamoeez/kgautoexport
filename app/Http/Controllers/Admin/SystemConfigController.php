<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\UserLoginLog;
use App\Models\ContStatus;
use App\Models\Shipper;
use App\Models\Consignee;
use App\Models\Terminal;
use App\Models\PreCarriage;
use App\Models\LoadingPort;
use App\Models\DischargePort;
use App\Models\DestinationPort;
use App\Models\NotifyParty;
use App\Models\Measurement;
use App\Models\ShippingLine;
use App\Models\Status;
use App\Models\Auction;
use App\Models\AuctionLocation;
use App\Models\MailTemplate;
use App\Models\ReminderTemplate;
use App\Models\VehicleModal;
use App\Models\VehicleBrand;
use App\Models\Level;
use App\Models\AdminLevel;
use App\Models\OperatorLevel;
use App\Models\FineType;
use App\Models\TransFineType;
use App\Models\Post;
use App\Models\Carrier;
use App\Models\ShippingCompany;
use App\Models\Country;
use App\Models\ForwardingAgent;
use Auth;

class SystemConfigController extends Controller
{
    // Users Functions

    public function users(Request $request)
    {
    	$data['type'] = "system-configuration";
        $data['page'] = '1';
    	$users = User::orderBy('id', 'DESC')->with('user_level')->where(function ($query) {
    		$query->where('role', '2')
    		->orWhere('role', '3');
    	});
    	if (!empty($request->search)) {
    		$data['search'] = $request->search;
    		$search = $request->search;
    		$users = $users->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('surname', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$search.'%')
                    ->orWhere('company', 'LIKE', '%'.$search.'%');
            });
    	}
        if (!empty($request->users) && $request->users !== "all") {
            $data['sel_users'] = $request->users;
            $users = $users->where("role", $request->users);
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $users = $users->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $users = $users->limit(10)->get();
        $data['users'] = $users;
        $data['level'] = Level::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
    	return view('admin.system-configuration.users', $data);
    }

    public function add_user(Request $request)
    {
        $data = $request->all();
        $check_username = User::where("name", $data['name'])->count();
        if ($check_username == 0) {
        	$check_email = User::where("email", $data['email'])->count();
        	if ($check_email == 0) {
	            if ($data['password'] == $data['cpassword']) {
	                $data['password'] = \Hash::make($data['password']);
	                if (!empty($data['sheet_password'])) {
	                    $data['sheet_password'] = \Hash::make($data['sheet_password']);
	                }
	                if (!empty($data['phone'])) {
	                    $data['phone'] = $data['phone_code']." ".$data['phone'];
	                }
	                User::create($data);

	                return json_encode(["success"=>true, "msg"=>"User added successfully!", "action"=>"reload"]);
	            } else {
	                return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
	            }
	        } else {
	            return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
	        }
        } else {
            return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
        }
    }

    public function edit_user(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $check_username = User::where("name", $data['name'])->where('id', '!=', $id)->count();
            if ($check_username == 0) {
            	$check_email = User::where("email", $data['email'])->where('id', '!=', $id)->count();
        		if ($check_email == 0) {
	                if (!empty($data['password'])) {
	                    if ($data['password'] == $data['cpassword']) {
	                        $data['password'] = \Hash::make($data['password']);
	                        if (!empty($data['sheet_password'])) {
	                            $data['sheet_password'] = \Hash::make($data['sheet_password']);
	                        } else {
                                unset($data['sheet_password']);
                            }
	                        if (!empty($data['phone'])) {
	                            $data['phone'] = $data['phone_code']." ".$data['phone'];
	                        }
	                        unset($data['_token']);
	                        unset($data['cpassword']);
	                        unset($data['phone_code']);
	                        User::where('id', $id)->update($data);

	                        return json_encode(["success"=>true, "msg"=>"User updated successfully!", "action"=>"reload"]);
	                    } else {
	                        return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
	                    }
	                } else {
	                    if (!empty($data['sheet_password'])) {
	                        $data['sheet_password'] = \Hash::make($data['sheet_password']);
	                    } else {
                            unset($data['sheet_password']);
                        }
	                    if (!empty($data['phone'])) {
	                        $data['phone'] = $data['phone_code']." ".$data['phone'];
	                    }
	                    $data['password'] = User::where('id', $id)->first()->password;
	                    unset($data['_token']);
	                    unset($data['cpassword']);
	                    unset($data['phone_code']);
	                    User::where('id', $id)->update($data);

	                    return json_encode(["success"=>true, "msg"=>"User updated successfully!", "action"=>"reload"]);
	                }
	            } else {
	                return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
	            }
            } else {
                return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
            }
        }

        $data = User::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_user($id)
    {
    	User::find($id)->delete();
    	return json_encode(["success"=>true, "msg"=>"User deleted successfully!"]);
    }

    // Admins Functions

    public function admins(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $admins = User::with('admin_level')->where('role', '1');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $admins = $admins->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $admins = $admins->limit(10)->get();
        $data['admins'] = $admins;
        $data['level'] = AdminLevel::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.admins', $data);
    }

    public function add_admin(Request $request)
    {
        $data = $request->all();
        $check_username = User::where("name", $data['name'])->count();
        if ($check_username == 0) {
        	$check_email = User::where("email", $data['email'])->count();
        	if ($check_email == 0) {
	            if ($data['password'] == $data['cpassword']) {
	                $data['password'] = \Hash::make($data['password']);
	                if (!empty($data['phone'])) {
	                    $data['phone'] = $data['phone_code']." ".$data['phone'];
	                }
	                $data['role'] = "1";
	                User::create($data);

	                return json_encode(["success"=>true, "msg"=>"Admin added successfully!", "action"=>"reload"]);
	            } else {
	                return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
	            }
        	} else {
                return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
            }
        } else {
            return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
        }
    }

    public function edit_admin(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $check_username = User::where("name", $data['name'])->where('id', '!=', $id)->count();
            if ($check_username == 0) {
            	$check_email = User::where("email", $data['email'])->where('id', '!=', $id)->count();
        		if ($check_email == 0) {
	                if (!empty($data['password'])) {
	                    if ($data['password'] == $data['cpassword']) {
	                        $data['password'] = \Hash::make($data['password']);
	                        if (!empty($data['phone'])) {
	                            $data['phone'] = $data['phone_code']." ".$data['phone'];
	                        }
	                        unset($data['_token']);
	                        unset($data['cpassword']);
	                        unset($data['phone_code']);
	                        User::where('id', $id)->update($data);

	                        return json_encode(["success"=>true, "msg"=>"Admin updated successfully!", "action"=>"reload"]);
	                    } else {
	                        return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
	                    }
	                } else {
	                    if (!empty($data['phone'])) {
	                        $data['phone'] = $data['phone_code']." ".$data['phone'];
	                    }
	                    $data['password'] = User::where('id', $id)->first()->password;
	                    unset($data['_token']);
	                    unset($data['cpassword']);
	                    unset($data['phone_code']);
	                    User::where('id', $id)->update($data);

	                    return json_encode(["success"=>true, "msg"=>"User updated successfully!", "action"=>"reload"]);
	                }
	            } else {
	                return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
	            }
            } else {
                return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
            }
        }

        $data = User::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_admin($id)
    {
        User::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Admin deleted successfully!"]);
    }

    // Operators Functions

    public function operators(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $operators = User::with('operator_level')->where('role', '4');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $operators = $operators->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $operators = $operators->limit(10)->get();
        $data['operators'] = $operators;
        $data['level'] = OperatorLevel::all();
        $data['destination'] = DestinationPort::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.operators', $data);
    }

    public function add_operator(Request $request)
    {
        $data = $request->all();
        $check_username = User::where("name", $data['name'])->count();
        if ($check_username == 0) {
        	$check_email = User::where("email", $data['email'])->count();
        	if ($check_email == 0) {
	            if ($data['password'] == $data['cpassword']) {
	                $data['password'] = \Hash::make($data['password']);
	                if (!empty($data['phone'])) {
	                    $data['phone'] = $data['phone_code']." ".$data['phone'];
	                }
	                $data['role'] = "4";
	                if (!empty($data['access'])) {
	                    $data['access'] = json_encode($data['access']);   
	                }
	                User::create($data);

	                return json_encode(["success"=>true, "msg"=>"Operators added successfully!", "action"=>"reload"]);
	            } else {
	                return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
	            }
            } else {
                return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
            }
        } else {
            return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
        }
    }

    public function edit_operator(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $check_username = User::where("name", $data['name'])->where('id', '!=', $id)->count();
            if ($check_username == 0) {
            	$check_email = User::where("email", $data['email'])->where('id', '!=', $id)->count();
        		if ($check_email == 0) {
	                if (!empty($data['password'])) {
	                    if ($data['password'] == $data['cpassword']) {
	                        $data['password'] = \Hash::make($data['password']);
	                        if (!empty($data['phone'])) {
	                            $data['phone'] = $data['phone_code']." ".$data['phone'];
	                        }
	                        unset($data['_token']);
	                        unset($data['cpassword']);
	                        unset($data['phone_code']);
	                        if (!empty($data['access'])) {
	                            $data['access'] = json_encode($data['access']);   
	                        }
	                        User::where('id', $id)->update($data);

	                        return json_encode(["success"=>true, "msg"=>"Operators updated successfully!", "action"=>"reload"]);
	                    } else {
	                        return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
	                    }
	                } else {
	                    if (!empty($data['phone'])) {
	                        $data['phone'] = $data['phone_code']." ".$data['phone'];
	                    }
	                    $data['password'] = User::where('id', $id)->first()->password;
	                    unset($data['_token']);
	                    unset($data['cpassword']);
	                    unset($data['phone_code']);
	                    User::where('id', $id)->update($data);

	                    return json_encode(["success"=>true, "msg"=>"Operators updated successfully!", "action"=>"reload"]);
	                }
	            } else {
	                return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
	            }
            } else {
                return json_encode(["success"=>false, "msg"=>"Username already taken!"]);
            }
        }

        $data = User::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_operator($id)
    {
        User::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Operators deleted successfully!"]);
    }

    // Admin Role Functions

    public function admin_role(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $role = Role::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $role = $role->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $role = $role->limit(10)->get();
        $data['role'] = $role;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.admin-role', $data);
    }

    public function add_admin_role(Request $request)
    {
        $data = $request->all();
        $check_role = Role::where("name", $data['name'])->count();
        if ($check_role == 0) {
            Role::create($data);

            return json_encode(["success"=>true, "msg"=>"Admin role added successfully!", "action"=>"reload"]);
        } else {
            return json_encode(["success"=>false, "msg"=>"Admin role already exists!"]);
        }
    }

    public function edit_admin_role(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            $check_role = Role::where("name", $data['name'])->where('id', '!=', $id)->count();
            if ($check_role == 0) {
                unset($data['_token']);
                Role::where('id', $id)->update($data);

                return json_encode(["success"=>true, "msg"=>"Admin role updated successfully!", "action"=>"reload"]);
            } else {
                return json_encode(["success"=>false, "msg"=>"Admin role already exists!"]);
            }
        }

        $data = Role::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_admin_role($id)
    {
        Role::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Admin role deleted successfully!"]);
    }

    // Group List Functions

    public function group_list(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $group = Group::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $group = $group->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $group = $group->limit(10)->get();
        $data['group'] = $group;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.group-list', $data);
    }

    public function add_group_list(Request $request)
    {
        $data = $request->all();
        $check_group = Group::where("name", $data['name'])->count();
        if ($check_group == 0) {
            Group::create($data);

            return json_encode(["success"=>true, "msg"=>"Group added successfully!", "action"=>"reload"]);
        } else {
            return json_encode(["success"=>false, "msg"=>"Group already exists!"]);
        }
    }

    public function edit_group_list(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            $check_group = Group::where("name", $data['name'])->where('id', '!=', $id)->count();
            if ($check_group == 0) {
                unset($data['_token']);
                Group::where('id', $id)->update($data);

                return json_encode(["success"=>true, "msg"=>"Group updated successfully!", "action"=>"reload"]);
            } else {
                return json_encode(["success"=>false, "msg"=>"Group already exists!"]);
            }
        }

        $data = Group::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_group_list($id)
    {
        Group::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Group deleted successfully!"]);
    }

    // Login History Functions

    public function login_history(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $history = UserLoginLog::orderBy('id', 'DESC')->with('user');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $history = $history->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $history = $history->limit(10)->get();
        $data['history'] = $history;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.login-history', $data);
    }

    // Container Status Functions

    public function container_status(Request $request)
    {
    	$data['type'] = "system-configuration";
    	$data['page'] = '1';
        $status = ContStatus::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $status = $status->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $status = $status->limit(10)->get();
        $data['status'] = $status;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
    	return view('admin.system-configuration.container-status', $data);
    }

    public function add_container_status(Request $request)
    {
        $data = $request->all();
        $check_status = ContStatus::where("name", $data['name'])->count();
        if ($check_status == 0) {
            ContStatus::create($data);

            return json_encode(["success"=>true, "msg"=>"Container status added successfully!", "action"=>"reload"]);
        } else {
            return json_encode(["success"=>false, "msg"=>"Container status already exists!"]);
        }
    }

    public function edit_container_status(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            if (!empty($data['name'])) {
                $check_status = ContStatus::where("name", $data['name'])->where('id', '!=', $id)->count();
                if ($check_status == 0) {
                    unset($data['_token']);
                    ContStatus::where('id', $id)->update($data);

                    return json_encode(["success"=>true, "msg"=>"Container status updated successfully!", "action"=>"reload"]);
                } else {
                    return json_encode(["success"=>false, "msg"=>"Container status already exists!"]);
                }
            } else {
                unset($data['_token']);
                ContStatus::where('id', $id)->update($data);
                
                return json_encode(["success"=>true, "msg"=>"Container status updated successfully!", "action"=>"reload"]);
            }
        }

        $data = ContStatus::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_container_status($id)
    {
        ContStatus::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Container status deleted successfully!"]);
    }

    // Shipper Functions

    public function shipper(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $shipper = Shipper::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $shipper = $shipper->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $shipper = $shipper->limit(10)->get();
        $data['shipper'] = $shipper;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.shipper', $data);
    }

    public function add_shipper(Request $request)
    {
        $data = $request->all();
        Shipper::create($data);
        return json_encode(["success"=>true, "msg"=>"Shipper added successfully!", "action"=>"reload"]);
    }

    public function edit_shipper(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            Shipper::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Shipper updated successfully!", "action"=>"reload"]);
        }

        $data = Shipper::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_shipper($id)
    {
        Shipper::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Shipper deleted successfully!"]);
    }

    // Forwarding Agent Functions

    public function forwarding_agent(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $forwarding_agent = ForwardingAgent::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $forwarding_agent = $forwarding_agent->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $forwarding_agent = $forwarding_agent->limit(10)->get();
        $data['forwarding_agent'] = $forwarding_agent;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.forwarding-agent', $data);
    }

    public function add_forwarding_agent(Request $request)
    {
        $data = $request->all();
        ForwardingAgent::create($data);
        return json_encode(["success"=>true, "msg"=>"Forwarding agent added successfully!", "action"=>"reload"]);
    }

    public function edit_forwarding_agent(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            ForwardingAgent::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Forwarding agent updated successfully!", "action"=>"reload"]);
        }

        $data = ForwardingAgent::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_forwarding_agent($id)
    {
        ForwardingAgent::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Forwarding agent deleted successfully!"]);
    }

    // Consignee Functions

    public function consignee(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $consignee = Consignee::orderBy('id', 'DESC')->with('shipper');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $consignee = $consignee->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $consignee = $consignee->limit(10)->get();
        $data['consignee'] = $consignee;
        $data['shipper'] = Shipper::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.consignee', $data);
    }

    public function add_consignee(Request $request)
    {
        $data = $request->all();
        Consignee::create($data);
        return json_encode(["success"=>true, "msg"=>"Consignee added successfully!", "action"=>"reload"]);
    }

    public function edit_consignee(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            Consignee::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Consignee updated successfully!", "action"=>"reload"]);
        }

        $data = Consignee::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_consignee($id)
    {
        Consignee::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Consignee deleted successfully!"]);
    }

    // Terminal Functions

    public function terminal(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $terminal = Terminal::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $terminal = $terminal->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $terminal = $terminal->limit(10)->get();
        $data['terminal'] = $terminal;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.terminal', $data);
    }

    public function add_terminal(Request $request)
    {
        $data = $request->all();
        Terminal::create($data);
        return json_encode(["success"=>true, "msg"=>"Terminal added successfully!", "action"=>"reload"]);
    }

    public function edit_terminal(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            Terminal::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Terminal updated successfully!", "action"=>"reload"]);
        }

        $data = Terminal::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_terminal($id)
    {
        Terminal::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Terminal deleted successfully!"]);
    }

    // Pre Carriage Functions

    public function pre_carriage(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $pre_carriage = PreCarriage::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $pre_carriage = $pre_carriage->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $pre_carriage = $pre_carriage->limit(10)->get();
        $data['pre_carriage'] = $pre_carriage;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.pre-carriage', $data);
    }

    public function add_pre_carriage(Request $request)
    {
        $data = $request->all();
        PreCarriage::create($data);
        return json_encode(["success"=>true, "msg"=>"Pre carriage added successfully!", "action"=>"reload"]);
    }

    public function edit_pre_carriage(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            PreCarriage::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Pre carriage updated successfully!", "action"=>"reload"]);
        }

        $data = PreCarriage::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_pre_carriage($id)
    {
        PreCarriage::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Pre carriage deleted successfully!"]);
    }

    // Loading Port Functions

    public function loading_port(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $loading_port = LoadingPort::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $loading_port = $loading_port->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $loading_port = $loading_port->limit(10)->get();
        $data['loading_port'] = $loading_port;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.loading-port', $data);
    }

    public function add_loading_port(Request $request)
    {
        $data = $request->all();
        LoadingPort::create($data);
        return json_encode(["success"=>true, "msg"=>"Loading port added successfully!", "action"=>"reload"]);
    }

    public function edit_loading_port(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            LoadingPort::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Loading port updated successfully!", "action"=>"reload"]);
        }

        $data = LoadingPort::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_loading_port($id)
    {
        LoadingPort::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Loading port deleted successfully!"]);
    }

    // Discharge Port Functions

    public function discharge_port(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $discharge_port = DischargePort::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $discharge_port = $discharge_port->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $discharge_port = $discharge_port->limit(10)->get();
        $data['discharge_port'] = $discharge_port;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.discharge-port', $data);
    }

    public function add_discharge_port(Request $request)
    {
        $data = $request->all();
        DischargePort::create($data);
        return json_encode(["success"=>true, "msg"=>"Discharge port added successfully!", "action"=>"reload"]);
    }

    public function edit_discharge_port(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            DischargePort::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Discharge port updated successfully!", "action"=>"reload"]);
        }

        $data = DischargePort::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_discharge_port($id)
    {
        DischargePort::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Discharge port deleted successfully!"]);
    }

    // Destination Port Functions

    public function destination_port(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $destination_port = DestinationPort::orderBy('id', 'DESC')->with("discharge");
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $destination_port = $destination_port->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $destination_port = $destination_port->limit(10)->get();
        $data['destination_port'] = $destination_port;
        $data['discharge_port'] = DischargePort::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.destination-port', $data);
    }

    public function add_destination_port(Request $request)
    {
        $data = $request->all();
        DestinationPort::create($data);
        return json_encode(["success"=>true, "msg"=>"Destination port added successfully!", "action"=>"reload"]);
    }

    public function edit_destination_port(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            DestinationPort::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Destination port updated successfully!", "action"=>"reload"]);
        }

        $data = DestinationPort::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_destination_port($id)
    {
        DestinationPort::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Destination port deleted successfully!"]);
    }

    // Notify Party Functions

    public function notify_party(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $notify_party = NotifyParty::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $notify_party = $notify_party->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $notify_party = $notify_party->limit(10)->get();
        $data['notify_party'] = $notify_party;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.notify-party', $data);
    }

    public function add_notify_party(Request $request)
    {
        $data = $request->all();
        NotifyParty::create($data);
        return json_encode(["success"=>true, "msg"=>"Notify party added successfully!", "action"=>"reload"]);
    }

    public function edit_notify_party(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            NotifyParty::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Notify party updated successfully!", "action"=>"reload"]);
        }

        $data = NotifyParty::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_notify_party($id)
    {
        NotifyParty::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Notify party deleted successfully!"]);
    }

    // Measurement Functions

    public function measurement(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $measurement = Measurement::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $measurement = $measurement->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $measurement = $measurement->limit(10)->get();
        $data['measurement'] = $measurement;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.measurement', $data);
    }

    public function add_measurement(Request $request)
    {
        $data = $request->all();
        Measurement::create($data);
        return json_encode(["success"=>true, "msg"=>"Measurement added successfully!", "action"=>"reload"]);
    }

    public function edit_measurement(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            Measurement::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Measurement updated successfully!", "action"=>"reload"]);
        }

        $data = Measurement::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_measurement($id)
    {
        Measurement::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Measurement deleted successfully!"]);
    }

    // Shipping Line Functions

    public function shipping_line(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $shipping_line = ShippingLine::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $shipping_line = $shipping_line->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $shipping_line = $shipping_line->limit(10)->get();
        $data['shipping_line'] = $shipping_line;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.shipping-line', $data);
    }

    public function add_shipping_line(Request $request)
    {
        $data = $request->all();
        ShippingLine::create($data);
        return json_encode(["success"=>true, "msg"=>"Shipping line added successfully!", "action"=>"reload"]);
    }

    public function edit_shipping_line(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            ShippingLine::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Shipping line updated successfully!", "action"=>"reload"]);
        }

        $data = ShippingLine::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_shipping_line($id)
    {
        ShippingLine::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Shipping line deleted successfully!"]);
    }

    // Auto Status Functions

    public function auto_status(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $status = Status::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $status = $status->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $status = $status->limit(10)->get();
        $data['status'] = $status;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.auto-status', $data);
    }

    public function add_auto_status(Request $request)
    {
        $data = $request->all();
        $check_status = Status::where("name", $data['name'])->count();
        if ($check_status == 0) {
            Status::create($data);

            return json_encode(["success"=>true, "msg"=>"Vehicle status added successfully!", "action"=>"reload"]);
        } else {
            return json_encode(["success"=>false, "msg"=>"Vehicle status already exists!"]);
        }
    }

    public function edit_auto_status(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            if (!empty($data['name'])) {
                $check_status = Status::where("name", $data['name'])->where('id', '!=', $id)->count();
                if ($check_status == 0) {
                    unset($data['_token']);
                    Status::where('id', $id)->update($data);

                    return json_encode(["success"=>true, "msg"=>"Vehicle status updated successfully!", "action"=>"reload"]);
                } else {
                    return json_encode(["success"=>false, "msg"=>"Vehicle status already exists!"]);
                }
            } else {
                unset($data['_token']);
                Status::where('id', $id)->update($data);
                
                return json_encode(["success"=>true, "msg"=>"Vehicle status updated successfully!", "action"=>"reload"]);
            }
        }

        $data = Status::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_auto_status($id)
    {
        Status::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Vehicle status deleted successfully!"]);
    }

    // Auction Functions

    public function auction(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $auction = Auction::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $auction = $auction->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $auction = $auction->limit(10)->get();
        $data['auction'] = $auction;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.auction', $data);
    }

    public function add_auction(Request $request)
    {
        $data = $request->all();
        Auction::create($data);
        return json_encode(["success"=>true, "msg"=>"Auction added successfully!", "action"=>"reload"]);
    }

    public function edit_auction(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            Auction::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Auction updated successfully!", "action"=>"reload"]);
        }

        $data = Auction::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_auction($id)
    {
        Auction::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Auction deleted successfully!"]);
    }

    // Auction Location Functions

    public function auction_location(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $auction_location = AuctionLocation::orderBy('id', 'DESC')->with('auction');
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $auction_location = $auction_location->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('position', 'LIKE', '%'.$search.'%');
            });
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $auction_location = $auction_location->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $auction_location = $auction_location->limit(10)->get();
        $data['auction_location'] = $auction_location;
        $data['auction'] = Auction::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.auction-location', $data);
    }

    public function add_auction_location(Request $request)
    {
        $data = $request->all();
        AuctionLocation::create($data);
        return json_encode(["success"=>true, "msg"=>"Auction location added successfully!", "action"=>"reload"]);
    }

    public function edit_auction_location(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            AuctionLocation::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Auction location updated successfully!", "action"=>"reload"]);
        }

        $data = AuctionLocation::with('auction')->where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_auction_location($id)
    {
        AuctionLocation::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Auction location deleted successfully!"]);
    }

    // Posts for sale Functions

    public function posts(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $posts = Post::orderBy('id', 'DESC')->with("user", "vehicle");
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $posts = $posts->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $posts = $posts->limit(10)->get();
        $data['posts'] = $posts;
        $data['user_levels'] = Level::all();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.posts', $data);
    }

    // Mail Templates Functions

    public function mail_templates(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $templates = MailTemplate::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $templates = $templates->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $templates = $templates->limit(10)->get();
        $data['templates'] = $templates;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.mail-templates', $data);
    }

    public function add_mail_templates(Request $request)
    {
        $data = $request->all();
        MailTemplate::create($data);
        return json_encode(["success"=>true, "msg"=>"Mail template added successfully!", "action"=>"reload"]);
    }

    public function edit_mail_templates(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            MailTemplate::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Mail template updated successfully!", "action"=>"reload"]);
        }

        $data = MailTemplate::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_mail_templates($id)
    {
        MailTemplate::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Mail template deleted successfully!"]);
    }

    // Send to all Users Functions

    public function send_to_all_users(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['user_levels'] = Level::all();
        $data['templates'] = MailTemplate::all();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.send-to-all-users', $data);
    }

    public function send_to_all_users_send(Request $request)
    {
        $data = $request->all();

        $users = User::where("role", "2")->get();
        foreach ($users as $key => $value) {
            if (!empty($value->email)) {

                $template = (object)[];
                $template->name = $data['name'];
                $template->content = $data['content'];

                \Mail::to(@$value->email)->send(new \App\Mail\SendReminder($template));
            }
        }

        return json_encode(["success"=>true, "msg"=>"Mails sended successfully!", "action"=>"reload"]);
    }

    // Reminder Templates Functions

    public function reminder_templates(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $templates = ReminderTemplate::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $templates = $templates->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $templates = $templates->limit(10)->get();
        $data['templates'] = $templates;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.reminder-templates', $data);
    }

    public function add_reminder_templates(Request $request)
    {
        $data = $request->all();
        ReminderTemplate::create($data);
        return json_encode(["success"=>true, "msg"=>"Reminder template added successfully!", "action"=>"reload"]);
    }

    public function edit_reminder_templates(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            ReminderTemplate::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Reminder template updated successfully!", "action"=>"reload"]);
        }

        $data = ReminderTemplate::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_reminder_templates($id)
    {
        ReminderTemplate::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Reminder template deleted successfully!"]);
    }

    // Vehicles Brand Functions

    public function vehicles_brand(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $brands = VehicleBrand::orderBy('id', 'DESC')->with("models");
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $brands = $brands->where('name', 'LIKE', '%'.$request->search.'%');
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $brands = $brands->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $brands = $brands->limit(10)->get();
        $data['brands'] = $brands;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.vehicles-brand', $data);
    }

    public function add_vehicles_brand(Request $request)
    {
        $data = $request->all();
        if (!empty($data['name'])) {
            $total_count = VehicleBrand::where("name", $data['name'])->count();
            if ($total_count > 0) {
                return json_encode(["success"=>false, "msg" => "Vehicle brand already exists!"]);
            }
        }
        VehicleBrand::create($data);
        return json_encode(["success"=>true, "msg"=>"Vehicles brand added successfully!", "action"=>"reload"]);
    }

    public function edit_vehicles_brand(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if (!empty($data['name'])) {
                $total_count = VehicleBrand::where('id', '!=', $id)->where("name", $data['name'])->count();
                if ($total_count > 0) {
                    return json_encode(["success"=>false, "msg" => "Vehicle brand already exists!"]);
                }
            }

            unset($data['_token']);
            VehicleBrand::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Vehicles brand updated successfully!", "action"=>"reload"]);
        }

        $data = VehicleBrand::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_vehicles_brand($id)
    {
        VehicleBrand::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Vehicles brand deleted successfully!"]);
    }

    // Vehicles Modal Functions

    public function vehicles_modal(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $modals = VehicleModal::orderBy('id', 'DESC')->with('vehicles_brand');
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $modals = $modals->whereHas("vehicles_brand", function ($q) use($search) {
                $q->where('name', 'LIKE', '%'.$search.'%');
            })->orWhere(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('weight', 'LIKE', '%'.$search.'%')
                    ->orWhere('fuel_type', 'LIKE', '%'.$search.'%');
            });
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $modals = $modals->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $modals = $modals->limit(10)->get();
        $data['modals'] = $modals;
        $data['brands'] = VehicleBrand::all();
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.vehicles-modal', $data);
    }

    public function add_vehicles_modal(Request $request)
    {
        $data = $request->all();
        if (!empty($data['name'])) {
            $total_count = VehicleModal::where("name", $data['name'])->where("vehicle_brand_id", $data['vehicle_brand_id'])->count();
            if ($total_count > 0) {
                return json_encode(["success"=>false, "msg" => "Vehicle model already exists!"]);
            }
        }
        VehicleModal::create($data);
        return json_encode(["success"=>true, "msg"=>"Vehicles model added successfully!", "action"=>"reload"]);
    }

    public function edit_vehicles_modal(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if (!empty($data['name'])) {
                $total_count = VehicleModal::where('id', '!=', $id)->where("name", $data['name'])->where("vehicle_brand_id", $data['vehicle_brand_id'])->count();
                if ($total_count > 0) {
                    return json_encode(["success"=>false, "msg" => "Vehicle model already exists!"]);
                }
            }
            unset($data['_token']);
            VehicleModal::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Vehicles model updated successfully!", "action"=>"reload"]);
        }

        $data = VehicleModal::with('vehicles_brand')->where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_vehicles_modal($id)
    {
        VehicleModal::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Vehicles model deleted successfully!"]);
    }

    // User Levels Functions

    public function user_levels(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $levels = Level::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $levels = $levels->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $levels = $levels->limit(10)->get();
        $data['levels'] = $levels;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.user-levels', $data);
    }

    public function add_user_levels(Request $request)
    {
        $data = $request->all();
        Level::create($data);
        return json_encode(["success"=>true, "msg"=>"User level added successfully!", "action"=>"reload"]);
    }

    public function edit_user_levels(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            Level::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"User level updated successfully!", "action"=>"reload"]);
        }

        $data = Level::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_user_levels($id)
    {
        Level::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"User level deleted successfully!"]);
    }

    // Fine Type Functions

    public function fine_type(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $fine_type = FineType::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $fine_type = $fine_type->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $fine_type = $fine_type->limit(10)->get();
        $data['fine_type'] = $fine_type;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.fine-type', $data);
    }

    public function add_fine_type(Request $request)
    {
        $data = $request->all();
        FineType::create($data);
        return json_encode(["success"=>true, "msg"=>"Fine type added successfully!", "action"=>"reload"]);
    }

    public function edit_fine_type(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            FineType::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Fine type updated successfully!", "action"=>"reload"]);
        }

        $data = FineType::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_fine_type($id)
    {
        FineType::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Fine type deleted successfully!"]);
    }

    // Trans Fine Type Functions

    public function trans_fine_type(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $trans_fine_type = TransFineType::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $trans_fine_type = $trans_fine_type->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $trans_fine_type = $trans_fine_type->limit(10)->get();
        $data['trans_fine_type'] = $trans_fine_type;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.trans-fine-type', $data);
    }

    public function add_trans_fine_type(Request $request)
    {
        $data = $request->all();
        TransFineType::create($data);
        return json_encode(["success"=>true, "msg"=>"Trans. fine type added successfully!", "action"=>"reload"]);
    }

    public function edit_trans_fine_type(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (empty(@$data['selected'])) {
                $data['selected'] = '0';
            }
            TransFineType::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Trans. fine type updated successfully!", "action"=>"reload"]);
        }

        $data = TransFineType::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_trans_fine_type($id)
    {
        TransFineType::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Trans. fine type deleted successfully!"]);
    }

    // Admin Levels Functions

    public function admin_levels(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $levels = AdminLevel::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $levels = $levels->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $levels = $levels->limit(10)->get();
        $data['levels'] = $levels;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.admin-levels', $data);
    }

    public function add_admin_levels(Request $request)
    {
        $data = $request->all();
        if (!empty($data['access'])) {
            $data['access'] = json_encode($data['access']);   
        }
        AdminLevel::create($data);
        return json_encode(["success"=>true, "msg"=>"Admin level added successfully!", "action"=>"reload"]);
    }

    public function edit_admin_levels(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            if (!empty($data['access'])) {
                $data['access'] = json_encode($data['access']);   
            }
            AdminLevel::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Admin level updated successfully!", "action"=>"reload"]);
        }

        $data = AdminLevel::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_admin_levels($id)
    {
        AdminLevel::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Admin level deleted successfully!"]);
    }

    // Operator Levels Functions

    public function operator_levels(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $levels = OperatorLevel::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $levels = $levels->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $levels = $levels->limit(10)->get();
        $data['levels'] = $levels;
        $data['user_levels'] = Level::all();
        $data['auth_user'] = User::with('admin_level')->where('id', Auth::user()->id)->first();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.operator-levels', $data);
    }

    public function add_operator_levels(Request $request)
    {
        $data = $request->all();
        OperatorLevel::create($data);
        return json_encode(["success"=>true, "msg"=>"Operator level added successfully!", "action"=>"reload"]);
    }

    public function edit_operator_levels(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            OperatorLevel::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Operator level updated successfully!", "action"=>"reload"]);
        }

        $data = OperatorLevel::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_operator_levels($id)
    {
        OperatorLevel::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Operator level deleted successfully!"]);
    }

    // Carriers Functions

    public function carriers(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $carriers = Carrier::orderBy('id', 'DESC');
        if (!empty($request->search)) {
            $data['search'] = $request->search;
            $search = $request->search;
            $carriers = $carriers->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('phone_numbers', 'LIKE', '%'.$search.'%');
            });
        }
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $carriers = $carriers->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $carriers = $carriers->limit(10)->get();
        $data['carriers'] = $carriers;
        $data['user_levels'] = Level::all();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.carriers', $data);
    }

    public function add_carriers(Request $request)
    {
        $data = $request->all();
        Carrier::create($data);
        return json_encode(["success"=>true, "msg"=>"Carrier added successfully!", "action"=>"reload"]);
    }

    public function edit_carriers(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            Carrier::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Carrier updated successfully!", "action"=>"reload"]);
        }

        $data = Carrier::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_carriers($id)
    {
        Carrier::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Carrier deleted successfully!"]);
    }

    // Shipping Company Functions

    public function shipping_company(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['page'] = '1';
        $shipping_company = ShippingCompany::orderBy('id', 'DESC');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $shipping_company = $shipping_company->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $shipping_company = $shipping_company->limit(10)->get();
        $data['shipping_company'] = $shipping_company;
        $data['user_levels'] = Level::all();
        $data['countries'] = Country::all();
        return view('admin.system-configuration.shipping-company', $data);
    }

    public function add_shipping_company(Request $request)
    {
        $data = $request->all();
        ShippingCompany::create($data);
        return json_encode(["success"=>true, "msg"=>"Shipping company added successfully!", "action"=>"reload"]);
    }

    public function edit_shipping_company(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            unset($data['_token']);
            ShippingCompany::where('id', $id)->update($data);
            return json_encode(["success"=>true, "msg"=>"Shipping Company updated successfully!", "action"=>"reload"]);
        }

        $data = ShippingCompany::where('id', $id)->first(); 
        return json_encode(["success"=>true, "data"=>$data]);
    }

    public function delete_shipping_company($id)
    {
        ShippingCompany::find($id)->delete();
        return json_encode(["success"=>true, "msg"=>"Shipping Company deleted successfully!"]);
    }
}
