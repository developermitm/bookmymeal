<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Address extends Authenticatable
{
    use  Notifiable ,SoftDeletes;
    
    protected $table = 'address';
    
    protected $fillable = [
        'user_id',
        'address_label',
        'mobile',
        'address1',
        'address2',
        'city',
        'zip',
        'state',
        'lat',
        'lang'
    ];


}
