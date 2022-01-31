<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Address;
use App\Models\Role;
use App\Models\Permission;

class OrderController extends Controller
{   
    public function __construct(){
        $this->middleware(['auth']); 
        $this->middleware(function ($request, $next){
            if(auth()->user()->role != 1){
                if ($this->checkPermisstion() == false){
                  return redirect('user/dashboard');
                  exit();
                }else{ return $next($request); }
            }else{ return $next($request); }
        });
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function checkPermisstion(){
        $userRole = auth()->user()->user_role;
        $getRoles = Role::find($userRole);
        $allpermisions =  json_decode($getRoles->permission);
        $sectionPer = Permission::where('name', 'LIKE', 'coupon')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list()
    {   
        $counts = Order::where('delivary_datetime', '!=', NULL)->count();
        $orders = Order::where('delivary_datetime', '!=', NULL)->paginate($counts);
        $customer = Customer::select('id','username')->get();
        return view('admin.orders.list',compact('orders', 'customer'));
    }

    public function pendingList()
    {   
        $counts = Order::count();
        $orders = Order::where('delivary_datetime', '=', NULL)->paginate($counts);
        $customer = Customer::select('id','username')->get();
        return view('admin.orders.pendinglist',compact('orders', 'customer'));
    }

    public function openEditOrderPopup(Request $request){
        $id = $request->id;
        $getDetails = Order::where('id', $id)->first();
        return View('admin.orders.popup.edit', compact('getDetails'));
    }

    public function updateOrderDetails( Request $request){
        $userid = auth()->user()->id;
        $orderId = $request->orderId;
        $status = $request->status;
        $comment = $request->comment;
        
        $firstName = !empty($request->firstName) ? $request->firstName : '';
        $lastName = !empty($request->lastName) ? $request->lastName : '';
        $address1 = !empty($request->address1) ? $request->address1 : '';
        $address2 = !empty($request->address2) ? $request->address2 : '';
        $zip = !empty($request->zip) ? $request->zip : '';
        $mobile = !empty($request->mobile) ? $request->mobile : '';
        $email = !empty($request->email) ? $request->email : '';
        $comment = !empty($request->comment) ? $request->comment : '';

        $addressArr = ['firstname' => $firstName, 'lastname' => $lastName, 'address1' => $address1, 'address2' => $address2, 'zip' => $zip, 'email' => $email, 'phone' => $mobile];
        
        if($status == 'due'){
            $dataArr = array(['admin' => $userid, 'status' => $status]);
            $deliveryArr = array(['admin' => $userid, 'status' => 'pending','delivery_time' => '', 'comment' => $comment]);
            $updateArr = ['payment_status' => $dataArr, 'delivery_status' =>$deliveryArr, 'delivary_datetime' => time() ,'shipping_address' => json_encode($addressArr)];
            $update = Order::find($orderId)->update($updateArr);
        }else{
       
            $dataArr = array(['admin' => $userid, 'status' => $status]);
            $deliveryArr = array(['admin' => $userid, 'status' => 'delivered','delivery_time' => time(), 'comment' => $comment]);
            $dataArr =  json_encode($dataArr);
            $updateArr = ['payment_status' => $dataArr, 'delivery_status' =>$deliveryArr, 'delivary_datetime' => time() ,'shipping_address' => json_encode($addressArr)];
            $update = Order::find($orderId)->update($updateArr);
        }
        if($update){
            $data = ['status' => 'success', 'msg' => 'updated successfully !'];
            echo json_encode($data);
            exit();
        }
    }

    public function invoice($id){
        $orderId = $id;
        $userid = auth()->user()->id;
        $dataArr = [];
        $getOrder = Order::where(['orderId' => $orderId])->get();

        $productArr = [];
            foreach ($getOrder as $key => $row) {
                $address = !empty($row->shipping_address) ? json_decode($row->shipping_address) : array();
                $payment_status = !empty($row->payment_status) ? json_decode($row->payment_status) : array() ;
                $delivery_status = !empty($row->delivery_status) ? json_decode($row->delivery_status) : array();
                $payment_details = !empty($row->payment_details) ? json_decode($row->payment_details) : array();
                $shipping_address = !empty($row->shipping_address) ? json_decode($row->shipping_address) : array();
                $sale_datetime = !empty($row->sale_datetime) ? $row->sale_datetime : '';
                $orderId = !empty($row->orderId) ? $row->orderId : '';
                $product_details = !empty($row->product_details) ? json_decode($row->product_details) : array();
                $delivery_status = !empty($row->delivery_status) ? json_decode($row->delivery_status) : array();
                $dataArr = '';
                foreach($product_details as $row2){
                    $dataArr = $row2; 
                }
              $productArr[] = ['product_details' => $dataArr,'payment_details' => $payment_details,'delivery_status' => $delivery_status,'payment_status' => $payment_status,'address' => $address,'sale_code' => $row->sale_code, 'id' => $row->id, 'shipping_address' => $shipping_address, 'sale_datetime' =>$sale_datetime, 'delivery_status' => $delivery_status, 'orderId' => $orderId];
            }

            $adminAddress = Address::where('user_id', $userid)->first();
            return View('admin.orders.invoice', compact('productArr', 'adminAddress'));
        }
    

}