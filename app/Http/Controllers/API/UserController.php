<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Address;
use App\Models\ContactMessage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Mail;
use DB;

class UserController extends Controller
{
    

    public $successStatus = 200;
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:user',
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
        }
        $input = $request->all();
       
        $input['password'] = bcrypt($input['password']);
        $user = Customer::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['userInfo'] =  $user;
        DB::table('device_token')->updateOrInsert(
        ['token' => $success['token']] , ['token' => $success['token']] );
        Auth::login($user);
        return response()->json(['success'=>$success], $this->successStatus); 
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request){
        if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::guard('customer')->user();
            $success['token'] =$user->createToken('MyApp')->accessToken; 
            $success['userInfo'] =  $user;
            $url =  env('APP_URL').'/public/userProfile/'.$user->profile_pic;
            $success['userInfo']['profile_pic'] = $url ;
            DB::table('device_token')->updateOrInsert(
            ['token' => $success['token']] , ['token' => $success['token']] );

            return response()->json(['success' => $success], $this->successStatus);
        } 
        else{ 
            return response()->json(['error'=>'Wrong Credentials please try again'], 401); 
        } 
    }

    public function userdetails() { 
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->orderBy('id', 'asc')->first();
        $name = !empty($address->name) ? $address->name : '';
        $mobile = !empty($address->mobile) ? $address->mobile : '';
        $address1 = !empty($address->address1) ? $address->address1 : $user->address1;
        $address2 = !empty($address->address2) ? $address->address2 : $user->address2;
        $city = !empty($address->city) ? $address->city : $user->city;
        $zip = !empty($address->zip) ? $address->zip : $user->zip;
        $state = !empty($address->state) ? $address->state : $user->state;
        $url =  env('APP_URL').'/public/userProfile/'.$user->profile_pic;
        $userArr = ['id' => $user->id, 'username' => $user->username, 'surname' => $user->surname, 'email' => $user->email, 'phone' => $user->phone ,'user_otp' => $user->user_otp, 'gender' => $user->gender, 'dob' => $user->dob, 'profile_pic' => $url ,'fb_id' => $user->fb_id, 'g_id' => $user->g_id, 'g_photo' => $user->g_photo ,'address1' => $address1, 'address2' => $address2, 'city' => $city, 'zip' => $zip, 'state' => $state, 'mobile' => $mobile, 'name' => $name];
        return response()->json(['userInfo' => $userArr], $this->successStatus); 
    } 

    public function logout()
    {

      if (Auth::user()) {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
        ]);
      
      }else {
          return response()->json([
            'success' => false,
            'message' => 'Unable to Logout'
          ]);
        }
    }

    public function restPassword( Request $request){
      $userId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
          'password' => 'required',
          'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
        }

      $password = bcrypt($request->password);
      $updateArr = ['password' => $password];
      $update = Customer::find($userId)->update($updateArr);
     
      if($update){
         return response()->json(['success' => 'Passowrd changed successfully !'], $this->successStatus);
      }
      else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function forgotPassword(Request $request){
      $email = $request->input('email');
      $user = Customer::where('email',$email)->first();
      $userId = $user->id;
      $data = [];
      if($user){
        $otp = random_int(100000, 999999);
        $data = array("name" => $user->username, 'email' => $user->email,"otp" => $otp);
        
        $mail = Mail::send('email.forgetPassword',['data' => $data] , function ($m) use ($data) {
            $m->from('info@orline.in', 'Admin');
            $m->to($data['email'], $data['name'])->subject('Forgot password !');
        });
        
        $update = Customer::find($userId)->update(['user_otp' => $otp]);
        if($update){
          return response()->json(['success' => 'OTP send into your registerd email address !'], $this->successStatus);
        }  

      }else{
            return response()->json(['error'=>'Email address not found'], $this->successStatus); 
      }
    }

    public function verifyOTP(Request $request){
      $email = $request->input('email');
      $otp = $request->input('otp');
      $user = Customer::where(['email' => $email, 'user_otp' => $otp])->first();
      if(!$user){
        return response()->json(['error'=>'Invalid OTP please try again'], $this->successStatus); 
      }else{
        return response()->json(['success' => 'OTP verification successfully !'], $this->successStatus);
      }
    }

    public function updatePassword(Request $request){

      $email = $request->input('email');
      $user = Customer::where('email',$email)->first();
      $userId = $user->id;

      $validator = Validator::make($request->all(), [
          'password' => 'required',
          'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
        }

      $password = bcrypt($request->password);
      $updateArr = ['password' => $password, 'user_otp' => null];
      $update = Customer::find($userId)->update($updateArr);
     
      if($update){
         return response()->json(['success' => 'Passowrd changed successfully !'], $this->successStatus);
      }
      else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    } 

      public function edituserDetails(){ 
        $user  = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus); 
      } 



        public function updateProfile(Request $request) {  
          $userId = Auth::user()->id;

            $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email'    => 'required|email',
            'phone'    => ['required', 'numeric', 'min:10'],
                       
            ]);

           if($validator->fails()){
              return response()->json(['error'=>$validator->errors()], 401);     
            }

            $userImage = '';
        
            if ($files = $request->file('user_image')) {
              $userImage = $files->getClientOriginalExtension();
              $userImage = 'user_'.$userId.'.'.$userImage; 
              $path = public_path('userProfile/'.$userImage); 
              
              if(file_exists($path)){
                 unlink($path);
              } 

               $files->move(public_path().'/userProfile/', $userImage);
            }

           
                $user = Customer::find($userId);
                $user->username  = $request->username;
                $user->email     = $request->email;
                $user->phone     = $request->phone;
                $user->profile_pic = $userImage;
                $user->gender   = !empty($request->gender) ? $request->gender : '';
                $user->dob      = !empty($request->dob) ? $request->dob : '' ;

                if($user->save()){
                   return response()->json(['success'=>' Profile updated successfully '],$this->successStatus);
                }

                else{
                  return response()->json(['error'=>'Unauthorised'], 401); 
                }
        }
             
      public function updateAddress( Request $request){
        $userId = Auth::user()->id;
       
        $updateArr = [
         'address1' => !empty($request->address1) ? $request->address1 : '',
          'address2' => !empty($request->address2) ? $request->address2 : '',
          'city' => !empty($request->city) ? $request->city : '',
          'zip' => !empty($request->zip) ? $request->zip : '',
          'langlat' => !empty($request->langlat) ? $request->langlat : '',
        ];
       
        $update = Customer::find($userId)->update($updateArr);
        if($update){
          return response()->json(['success'=>' Address updated successfully '],$this->successStatus);
         }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
      }   

      public function contactMessage( Request $request){
          $jsonData = $request->json()->all();
          
          $validator = Validator::make($request->json()->all(), [
            'name' => 'required',
            'subject'  => 'required',
            'email'    => 'required|email',
            'message' => 'required',
          ]);
   
         if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
          }

        $insert = ContactMessage::Create([
          'name' => $jsonData['name'],
          'subject' => $jsonData['subject'],
          'email' => $jsonData['email'],
          'message' => $jsonData['message'],
          'timestamp' => time(),

        ]);
        
        if($insert){
          return response()->json(['success'=>'Message send successfully !'], $this->successStatus); 
        }


      }

      public function addUserAddress(Request $request){
        $userId = Auth::user()->id;
      
        $insert = Address::Create([
          'user_id' => $userId,
          'name' =>$request->name,
          'mobile' =>$request->mobile,
          'address1' => $request->address1,
          'address2' =>$request->address2 ,
          'city' => $request->city,
          'zip' => $request->zip,
          'state' =>$request->state,
        ]);

        if($insert){
          return response()->json(['success'=>'Address saved successfully !'], $this->successStatus); 
        }
      }

    public function deleteAddress($id){
      $delete = Address::find($id)->delete();
      
      if($delete){
          return response()->json(['success'=>'Address deleted successfully !'], $this->successStatus); 
        }
    }

    public function userAddress(){
      $userId = Auth::user()->id;
      $address = Address::where('user_id', $userId)->get();
      return response()->json(['address'=> $address], $this->successStatus); 
    } 

    public function facebookLogin(Request $request){
      $name = $request->name;
      $email = $request->email;
      $providerId = $request->provider_id;
      $profileUrl = $request->profile_pic;
      if(isset($providerId) && !empty($providerId)){
        $getRst = Customer::select('id','username', 'surname','email','phone','password','gender',
        'dob','address1','user_otp','address2','city','zip','langlat','state','country','wishlist','profile_pic','fb_id','fb_photo')->where(['fb_id' => $providerId])->first();
        if(isset($getRst) && !empty($getRst)){
            $success['token'] = $getRst->createToken('MyApp')->accessToken; 
            $success['userInfo'] =  $getRst;
            DB::table('device_token')->updateOrInsert(
            ['token' => $success['token']] , ['token' => $success['token']] );

            return response()->json(['success' => $success], $this->successStatus);
        }else{
          $insertArr = [
            'username' => $name,
            'email' => $email,
            'fb_id' => $providerId,
            'fb_photo' => $profileUrl,
          ];
          $user = Customer::create($insertArr);
          $success['token'] =  $user->createToken('MyApp')->accessToken;
            DB::table('device_token')->updateOrInsert(
            ['token' => $success['token']] , ['token' => $success['token']] );
          $success['userInfo'] =  $user;
          Auth::login($user);
          return response()->json(['success'=>$success], $this->successStatus); 
        }
      }
    } 

    public function firebaseToken(Request $request){
      $token = $request->device_token;
      $userId = Auth::user()->id;
      $updateArr = ['device_token' => $token];
      DB::table('device_token')->updateOrInsert(
      ['token' => $token] , ['token' => $token] );
      $update = Customer::find($userId)->update($updateArr);
      $success = ['token saved successfully'];
      return response()->json(['success' => $success], $this->successStatus);
    }

    public function anonymousToken(Request $request){
      $insert =  DB::table('device_token')->updateOrInsert(
        ['token' => $request->anonymous_token] , ['token' => $request->anonymous_token] );
      $success = ['token saved successfully'];
      return response()->json(['success' => $success], $this->successStatus);
    }
}

