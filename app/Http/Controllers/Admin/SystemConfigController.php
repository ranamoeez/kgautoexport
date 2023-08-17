<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\UserLoginLog;
use App\Models\Status;
use App\Models\ContStatus;

class SystemConfigController extends Controller
{
    // Users Functions

    public function users(Request $request)
    {
    	$data['type'] = "system-configuration";
        $data['page'] = '1';
    	$users = User::where('role', '!=', '1');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $users = $users->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $users = $users->limit(10)->get();
        $data['users'] = $users;
    	return view('admin.system-configuration.users', $data);
    }

    public function add_user(Request $request)
    {
        $data = $request->all();
        $check_email = User::where("email", $data['email'])->count();
        if ($check_email == 0) {
            if ($data['password'] == $data['cpassword']) {
                $data['password'] = \Hash::make($data['password']);
                User::create($data);

                return json_encode(["success"=>true, "msg"=>"User added successfully!", "action"=>"reload"]);
            } else {
                return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
            }
        } else {
            return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
        }
    }

    public function edit_user(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $check_email = User::where("email", $data['email'])->where('id', '!=', $id)->count();
            if ($check_email == 0) {
                if (!empty($data['password'])) {
                    if ($data['password'] == $data['cpassword']) {
                        $data['password'] = \Hash::make($data['password']);
                        unset($data['_token']);
                        unset($data['cpassword']);
                        User::where('id', $id)->update($data);

                        return json_encode(["success"=>true, "msg"=>"User updated successfully!", "action"=>"reload"]);
                    } else {
                        return json_encode(["success"=>false, "msg"=>"Confirm password should be same as password!"]);
                    }
                } else {
                    unset($data['_token']);
                    unset($data['cpassword']);
                    User::where('id', $id)->update($data);

                    return json_encode(["success"=>true, "msg"=>"User updated successfully!", "action"=>"reload"]);
                }
            } else {
                return json_encode(["success"=>false, "msg"=>"Email already taken!"]);
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

    // Admin Role Functions

    public function admin_role(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['role'] = Role::all();
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
        $data['group'] = Group::all();
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
        $history = UserLoginLog::with('user');
        if (!empty($request->page)) {
            if ($request->page > 1) {
                $offset = ($request->page - 1) * 10;
                $history = $history->offset((int)$offset);
            }
            $data['page'] = $request->page;
        }
        $history = $history->limit(10)->get();
        $data['history'] = $history;
        return view('admin.system-configuration.login-history', $data);
    }

    // Auto Status Functions

    public function auto_status(Request $request)
    {
        $data['type'] = "system-configuration";
        $data['status'] = Status::all();
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

    // Container Status Functions

    public function container_status(Request $request)
    {
    	$data['type'] = "system-configuration";
    	$data['status'] = ContStatus::all();
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
}
