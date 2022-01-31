<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , LogsActivity ,SoftDeletes;



    protected $table = 'user';

     protected $guard = 'customer';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'surname',
        'email',
        'address',
        'gender',
        'dob',
        'phone',
        'password',
        'address1',
        'user_otp',
        'address2',
        'city',
        'zip',
        'langlat',
        'state',
        'country',
        'wishlist',
        'profile_pic',
        'fb_id',
        'fb_photo',
        'device_token',
        'status'
        
    ];

    protected static $logAttributes = [
        'username',
        'surname',
        'email',
        'phone',
        'password',
        'address1',
        'user_otp',
        'address2',
        'city',
        'zip',
        'langlat',
        'state',
        'country',
        'wishlist',
        'profile_pic',
        'status'
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'MobileApp';


}

