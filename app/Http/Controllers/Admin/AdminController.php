<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Address;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Kitchen;
use App\Models\Products;
use App\Models\Brand;
use App\Models\SubCategory;
use DB;
use Auth;
use Session;
use Mail;
use App;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']); 
    }

    public function index(){
        $productCount = Products::where(['status' => 1])->count();
        $usersCount = User::where(['role' => 2])->count();
        $categoryCount = Category::where(['status' => 1])->count();
        $kitchenCount = Kitchen::where(['status' => 1])->count();
        $orderCount = Order::where('delivary_datetime', '!=', NULL)->count();
        $pendingorderCount = Order::where('delivary_datetime', '=', NULL)->count();
        $currentYear = date('Y');
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : $currentYear ;
        $saleArr = [];
        for($i = 1; $i <= 12; $i++) {
            $from = strtotime($year.'-'.$i.'-01');
            $to =  date('Y-m-t', $from);
            $to = strtotime($to);
            $sql = "SELECT sum(grand_total) as totalSale From sale where sale_datetime BETWEEN $from and $to ";
            $resCount = DB::select($sql);
            $saleArr[] = (isset($resCount[0]->totalSale) && !empty($resCount[0]->totalSale)) ? number_format( str_replace(',',' ', $resCount[0]->totalSale), 2,'.', '')  : '0';
        }
        $totalSale = !empty($saleArr) ? array_sum($saleArr) : 0; 
        $saleArr = implode(',', $saleArr);
        return view('admin.dashboard', compact('saleArr','productCount', 'usersCount','kitchenCount' ,'categoryCount', 'orderCount', 'totalSale', 'pendingorderCount'));
    }    

    public function usersListing(){
        $users = User::where('role', '!=', 1)->get();
        return view('admin.user.list', compact('users'));
    } 

    public function addUserForm(){
       $roles = Role::orderBy('name', 'asc')->get();
       return view('admin.user.add', compact('roles'));
    }

    public function saveUserDetails(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => ['required', 'string', 'min:8'],
            'user_role' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = User::Create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_num' => $request->phone,
            'address' => $request->address,
            'user_pass' => $request->password,
            'role' => 2,
            'status' => $request->status,
            'user_role' => $request->user_role,
        ]);

        if($insert){
            return redirect('admin/user-listing')->with('message', 'User Registered Successfully!');
        }

    }

    public function editUser($id){
        $roles = Role::where('id', '!=', 1)->get();
        $getDetails = User::find($id);
        return view('admin.user.edit', compact('getDetails', 'roles'));
    }

    public function updateUserDetails(Request $request){
        $id = $request->userId;
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,'.$user->id.',id'],
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => ['required', 'string', 'min:8'],
            'user_role' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateArr = [
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_num' => $request->phone,
            'address' => $request->address,
            'user_pass' => $request->password,
            'role' => 2,
            'status' => $request->status,
            'user_role' => $request->user_role,
        ];
        $update = User::find($id)->update($updateArr); 

        if($update){
            return redirect('admin/edit-user/'.$id)->with('message', 'User Details Updated Successfully!');
        }
    }
   
    public function activityLog(){
        $activityLog = activity::paginate(10);
        $users = User::select('id', 'name')->get();
        $mobileuser = Customer::select('id', 'username')->get();
        return view('admin.activity', compact('activityLog', 'users', 'mobileuser'));
    }
    
    public function updateProfile(){
        $id = Auth()->user()->id;
        $getDetails = User::find($id);
        $address = Address::where('user_id',$id)->first();
        return view('admin.editProfile', compact('getDetails', 'address'));   
    }
    
    public function updateData(Request $request){
        $id = Auth()->user()->id;
        $username = !empty($request->username) ? $request->username : '';
        $email = !empty($request->email) ? $request->email : '' ;
        $password = !empty($request->password) ? $request->password : '' ;
        $address1 = !empty($request->address1) ? $request->address1 : '' ;
        $address2 = !empty($request->address2) ? $request->address2 : '' ;
        $city = !empty($request->city) ? $request->city : '';
        $zip = !empty($request->zip) ? $request->zip : '' ;
        $state = !empty($request->state) ? $request->state : '';
        $phone = !empty($request->phone) ? $request->phone : '' ;
        $addressId = !empty($request->addressId) ? $request->addressId : '';
        $insertArr = [
            'name' => 'admin',
            'mobile' => $phone,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'zip' => $zip,
            'state' => $state,
            'user_id' =>$id, 
        ];

        $insert = !empty($addressId) ? Address::find($addressId)->update($insertArr) : Address::Create($insertArr);

        $updateArr = [
            'name' => $username,
            'email' => $email,
            'mobile_num' => $phone,
        ]; 

        if(!empty($password)){
            $updateArr['password'] = Hash::make($password);
        }

        $update = User::find($id)->update($updateArr);
        if($update){
           return redirect('admin/profile')->with('message', 'Details Updated Successfully!');   
        }
    }

    public function sendNotification(){

        $mobileuser = Customer::select('id', 'username')->get();
        $getFcm = DB::table('fcm')->where('id', '1')->first();
        return view('admin.notification', compact('mobileuser', 'getFcm'));      
    }

    public function adminNotificationSend(Request $request){
        $this->validate(
            $request,
                [
                    'notification_title' => 'required',
                    'notification_text' => 'required',
             
                ],
                [
                    'notification_title.required' => 'Enter notification title.',
                    'notification_text.required' => 'Enter notification text.',
                ]
        );

        $notification_title = $request->notification_title;
        $notification_text = $request->notification_text;
        $getFcm = DB::table('fcm')->where('id', '1')->first();
        $getFcmKey = env('FCM_KEY');
        
        $users = $request->users;

        $firebaseToken = Customer::whereNotNull('device_token')->pluck('device_token')->all();
        $getDevice = Customer::where('id',$users)->whereNotNull('device_token')->first();
       
            $fcmNotification = [];
        
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $notification = [
                'title' => $notification_title,
                'body' => $notification_text,
                'sound' => true,
            ];

            $extraNotificationData = ["message" => $notification];
            
            if(empty($users)){ 
                $fcmNotification = [
                    'registration_ids' =>$firebaseToken,
                    'notification' => $notification,
                    'data' => $extraNotificationData,
                ];
            }    

            if(!empty($users)){ 
                $fcmNotification = [
                    'to' =>$getDevice->device_token,
                    'notification' => $notification,
                    'data' => $extraNotificationData,
                ];
            }    
            $headers = [
                'Authorization: key='.$getFcmKey,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);
            return redirect()->back()->withSuccess('notification send successfully');
        }

    function test(){
        $token = "edL4ukAZ4vY:APA91bFgz4DFVeP29MqVayuEUvs-7Qix8buB1vI10mthr2sBahe8t7tFxfJ5ogA6FgNw3Wfyo_HyORDzlpKURPpc4m942LdscyOWloX_2Kn2CR1nwEpMxPLI5kViRIT16t_K1sbPbdZQ";  
        
        $from = "AAAAFWJWujs:APA91bHvxohAwnBoXdcrzMPPm_KUHzA-ocOSbwB_Fv8m8mMbvEhHqBpwkQydGGR34HFec-uVi6c2wU3J4of98ZFxDnZ3xgtsjYyd6irzZBUiotr4pAc-sPe4V5g6lMqBv4sRvzMmlhod";
        $msg = array
              (
                'body'  => "Testing Testing",
                'title' => "Hi, From Raj",
                'receiver' => 'erw',
                'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg
                );

        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    }
}