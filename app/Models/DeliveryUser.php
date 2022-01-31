<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryUser extends Authenticatable
{
    use  Notifiable,SoftDeletes;
    protected $table = 'delivery_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile_no',
        'address',
        'zip_code',
        'image',
        'date_of_joining',
        'lat',
        'lang',
        'identity_number',
        'status',
    ];


}
