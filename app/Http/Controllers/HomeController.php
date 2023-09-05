<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLoginLog;
use App\Models\AssignVehicle;
use Auth;

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
        $data['total_vehicles'] = AssignVehicle::where('user_id', \Auth::user()->id)->count();
        $data['latest'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->where('user_id', \Auth::user()->id)->orderBy("id", "DESC")->limit(3)->get();
        return view('user.index', $data);
    }

    public function vehicles()
    {
        $data['type'] = "vehicles";
        $data['super_admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("assigned_by", "super_admin");
        })->where('user_id', \Auth::user()->id)->orderBy("id", "DESC")->get();
        $data['admin'] = AssignVehicle::with('user', 'vehicle', 'container', 'vehicle.vehicle_images', 'vehicle.vehicle_documents', 'vehicle.fines', 'vehicle.auction', 'vehicle.auction_location', 'vehicle.terminal', 'vehicle.status', 'vehicle.buyer')->whereHas("vehicle", function ($q) {
            $q->where("assigned_by", "admin");
        })->where('user_id', \Auth::user()->id)->orderBy("id", "DESC")->get();
        return view('user.vehicles', $data);
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
            } else if ($user->role == '2') {
                return redirect(url('/user'));
            }
            return redirect(url('/'))->with(['error' => 'These credentials do not match our records.']);
        } 
        else{ 
            return redirect(url('/'))->with(['error' => 'These credentials do not match our records.']);
        } 
    }

    public function send_noti()
    {
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
            CURLOPT_POSTFIELDS =>'{
                "notification": {
                    "title": "K&G Auto Export",
                    "body": "New vehicle is added!",
                    "image": "http://kgautoexport.co/public/assets/logo.png"
                },
                "priority": "high",
                "to": "d8XrExhrQZ6diKzm6Zg3bL:APA91bGwLhyqes2pu7tAH_2jxavx0jTfKnUH0EfQP5tWdI--kZ_uLVCIVU3EMHCdWnjwPqYc7STJZg5bwgOuONqUAbr1DGH2uIpC-xpKZus1GvmOMx6tlMfIgqQ30AYlILluyh9KUc0a",
                "data": {
                    "message": "New vehicle is added!",
                    "type": "add_vehicle"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: key=AAAAntu-774:APA91bHqe9UJ3pzJp3dtm7Tpqlmh0F7UwpzVK_An3JFA61khikFm9EwBOl4j9cPC7lzVxwr7dY6LL-SH2xA1DfpCzplQpBYmMIBLXkg7CTKwoXptjutN_Yo4UPA9kwDxRwiwI2tDiNZu'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
