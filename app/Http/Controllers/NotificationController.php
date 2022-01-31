<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use Notification;
use App\Notifications\OffersNotification;
// /use Illuminate\Notifications\Messages\MailMessage;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index()
    {
        return view('product');
    }
    
    public function sendOfferNotification() {
        $userSchema = User::first();
  
        $offerData = [
            'name' => 'BOGO',
            'body' => 'You received an offer.',
            'thanks' => 'Thank you',
            'offerText' => 'Check out the offer',
            'offerUrl' => url('/'),
            'offer_id' => 'testeststestst'
        ];
      	
        
  		$userSchema->notify(new OffersNotification($offerData));
  		dd($userSchema->notifications);
        dd('Task completed!');
    }
}