<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class RazorPayController extends Controller
{
   public function createOrder(Request $request){
        $api_key = env('RAZORPAY_API_KEY');
        $api_secret = env('RAZORPAY_API_SECRET');
        $api = new Api($api_key, $api_secret);
        $receipt = rand();
        $amount = $request->amount;
        $order  = $api->order->create(array('receipt' => $receipt, 'amount' => $amount, 'currency' => 'INR')); 
        $orderId = $order['id'];
        $data['orderId'] = $order['id']; // Get the created Order ID
        return response()->json(['success' => $data], $this->successStatus);
    }

    public function verifyOrder(Request $request){
        $api_key = env('RAZORPAY_API_KEY');
        $api_secret = env('RAZORPAY_API_SECRET');
        $signature = $request->razorpay_signature;
        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;
        $api = new Api($key_id, $key_secret);
        $attributes  = array('razorpay_signature'  => $signature,  'razorpay_payment_id'  => $paymentId ,  'razorpay_order_id' => $orderId);
        $data['order']  = $api->utility->verifyPaymentSignature($attributes);
        return response()->json(['success' => $data], $this->successStatus);
    }

    public function verifyOrderForm(){
        return View('payumoney');
    }
  
}
