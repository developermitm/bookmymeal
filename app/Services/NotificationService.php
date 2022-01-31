<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\Role;
use App\Models\ProductFeature;
use App\Models\ExtraFeature;
use App\Models\Permission;
use App\services\Notification;
use DB;
class NotificationService extends Controller
{
    public function sendPushNotification($title, $message, $imgUrl) {  
        $firebaseToken = DB::table('device_token')->whereNotNull('token')->pluck('token')->all();
        $getFcmKey = env('FCM_KEY');;    
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';            
        $headers = array("authorization: key=" . $getFcmKey . "",
            "content-type: application/json"
        );    

        $notification = [
            'title' => strip_tags($title),
            'body' => strip_tags($message),
            'sound' => true,
            "image" => $imgUrl,
        ];
        $extraNotificationData = ["message" => $notification];

        $fcmNotification = [
            'registration_ids' =>$firebaseToken,
            'notification' => $notification,
            'data' => $extraNotificationData,
        ];

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);  
        curl_close($ch);
        return true;
    }
}